<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Saving;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavingController extends Controller
{
    public function index(Request $request)
    {
        $query = Saving::where('category', 'Personal Savings')->with('member')->latest('transaction_date');

        if (Auth::user()->role === 'member') {
            $member = Auth::user()->member;
            if ($member) {
                $query->where('member_id', $member->id);
            } else {
                $query->where('id', 0); // Show nothing if no member linked
            }
        }

        if ($request->has('search')) {
             $search = $request->get('search');
             $query->whereHas('member', function($q) use ($search) {
                 $q->where('first_name', 'like', "%{$search}%")
                   ->orWhere('last_name', 'like', "%{$search}%")
                   ->orWhere('account_number', 'like', "%{$search}%");
             });
        }

        // Calculate stats
        $statsQuery = $query->clone();
        
        if (Auth::user()->role === 'member') {
            $member = Auth::user()->member;
            if ($member) {
                $statsQuery->where('member_id', $member->id);
            } else {
                 $statsQuery->where('id', 0);
            }
        }

        $stats = [
            'total_savings' => $statsQuery->clone()->where('status', 'approved')->where('type', 'deposit')->sum('amount') - $statsQuery->clone()->where('status', 'approved')->where('type', 'withdrawal')->sum('amount'),
            'monthly_deposits' => $statsQuery->clone()->where('status', 'approved')->where('type', 'deposit')->whereBetween('transaction_date', [now()->startOfMonth(), now()->endOfMonth()])->sum('amount'),
            'pending_count' => $statsQuery->clone()->where('status', 'pending')->count(),
        ];

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $savings = $query->paginate(15);

        return view('savings.index', compact('savings', 'stats'));
    }

    public function create()
    {
        if (!Auth::user()->isStaff()) {
            abort(403);
        }
        $members = Member::where('status', 'active')->orderBy('first_name')->orderBy('last_name')->get();
        $categories = ['Personal Savings', 'Contribution'];
        return view('savings.create', compact('members', 'categories'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isStaff()) {
            abort(403);
        }

        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'amount' => 'required|numeric|min:1',
            'type' => 'required|string|in:deposit,withdrawal',
            'category' => 'required|string|in:Personal Savings,Contribution',
            'transaction_date' => 'required|date',
            'reference' => 'nullable|string',
            'notes' => 'nullable|string',
            'bank_name' => 'nullable|required_if:type,withdrawal|string|max:255',
            'account_name' => 'nullable|required_if:type,withdrawal|string|max:255',
            'account_number' => 'nullable|required_if:type,withdrawal|string|size:10',
        ]);

        $validated['recorded_by'] = Auth::id();
        $validated['status'] = 'approved';

        Saving::create($validated);

        return redirect()->route('savings.index')->with('success', 'Transaction recorded successfully.');
    }

    public function deposit()
    {
        abort(403);
        return view('savings.deposit');
    }

    public function storeDeposit(Request $request)
    {
        abort(403);
        $validated = $request->validate([
            'amount' => 'required|numeric|min:100',
            'payment_proof' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
            'notes' => 'nullable|string',
        ]);

        $member = Auth::user()->member;

        if (!$member) {
             return redirect()->route('dashboard')->with('error', 'Member profile not found.');
        }

        $path = $request->file('payment_proof')->store('payment_proofs', 'public');

        Saving::create([
            'member_id' => $member->id,
            'amount' => $validated['amount'],
            'category' => 'Personal Savings',
            'type' => 'deposit',
            'transaction_date' => now(),
            'status' => 'pending',
            'payment_proof_path' => $path,
            'notes' => 'Member Personal Savings: ' . ($validated['notes'] ?? 'Manual deposit via dashboard'),
            'recorded_by' => null,
        ]);

        return redirect()->route('savings.index')->with('success', 'Deposit submitted successfully! Pending approval.');
    }

    public function withdraw()
    {
        abort(403);
        $member = Auth::user()->member;
        if (!$member) {
            return redirect()->route('dashboard')->with('error', 'Member profile not found.');
        }

        $balance = $member->savings()->where('category', 'Personal Savings')->where('status', 'approved')->where('type', 'deposit')->sum('amount') - $member->savings()->where('category', 'Personal Savings')->where('status', 'approved')->where('type', 'withdrawal')->sum('amount');
        
        return view('savings.withdraw', compact('balance'));
    }

    public function storeWithdrawal(Request $request)
    {
        abort(403);
        $member = Auth::user()->member;

        if (!$member) {
            return redirect()->route('dashboard')->with('error', 'Member profile not found.');
        }

        $balance = $member->savings()->where('category', 'Personal Savings')->where('status', 'approved')->where('type', 'deposit')->sum('amount') - $member->savings()->where('category', 'Personal Savings')->where('status', 'approved')->where('type', 'withdrawal')->sum('amount');

        $validated = $request->validate([
            'amount' => 'required|numeric|min:1|max:' . $balance,
            'bank_name' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|size:10',
            'notes' => 'nullable|string',
        ]);

        Saving::create([
            'member_id' => $member->id,
            'amount' => $validated['amount'],
            'category' => 'Personal Savings',
            'type' => 'withdrawal',
            'bank_name' => $validated['bank_name'],
            'account_name' => $validated['account_name'],
            'account_number' => $validated['account_number'],
            'transaction_date' => now(),
            'status' => 'pending',
            'notes' => 'Member Withdrawal Request: ' . ($validated['notes'] ?? 'None'),
            'recorded_by' => null, // Will be set by admin on approval
        ]);

        return redirect()->route('savings.index')->with('success', 'Withdrawal request submitted successfully! Pending admin verification and transfer.');
    }

    public function show(Saving $saving)
    {
        $saving->load('member.user');
        return view('savings.show', compact('saving'));
    }

    public function approve(Request $request, Saving $saving)
    {
        if (!Auth::user()->isStaff()) {
            abort(403);
        }

        $saving->update([
            'status' => 'approved',
            'recorded_by' => Auth::id(),
        ]);

        if ($saving->member && $saving->member->user) {
            $saving->member->user->notify(new \App\Notifications\SavingsStatusUpdated(
                'Savings Transaction Approved',
                "Your ".ucfirst($saving->type)." request of " . number_format($saving->amount, 2) . " has been approved."
            ));
        }

        return redirect()->back()->with('success', 'Transaction approved successfully.');
    }

    public function reject(Request $request, Saving $saving)
    {
        if (!Auth::user()->isStaff()) {
            abort(403);
        }

        $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        $saving->update([
            'status' => 'rejected',
            'rejection_reason' => $request->reason,
        ]);

        if ($saving->member && $saving->member->user) {
            $saving->member->user->notify(new \App\Notifications\SavingsStatusUpdated(
                'Savings Transaction Rejected',
                "Your ".ucfirst($saving->type)." request of " . number_format($saving->amount, 2) . " was rejected. Reason: {$request->reason}"
            ));
        }

        return redirect()->back()->with('success', 'Transaction rejected.');
    }
}
