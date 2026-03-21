<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Saving;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContributionController extends Controller
{
    public function index(Request $request)
    {
        $query = Saving::where('category', 'Contribution')->with('member')->latest('transaction_date');

        if (Auth::user()->role === 'member') {
            $member = Auth::user()->member;
            if ($member) {
                $query->where('member_id', $member->id);
            } else {
                $query->where('id', 0);
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
            'total_contributions' => $statsQuery->clone()->where('status', 'approved')->where('type', 'deposit')->sum('amount'),
            'monthly_contributions' => $statsQuery->clone()->where('status', 'approved')->where('type', 'deposit')->whereBetween('transaction_date', [now()->startOfMonth(), now()->endOfMonth()])->sum('amount'),
            'pending_count' => $statsQuery->clone()->where('status', 'pending')->count(),
        ];

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $contributions = $query->paginate(15);

        return view('contributions.index', compact('contributions', 'stats'));
    }

    public function deposit()
    {
        abort(403);
        return view('contributions.deposit');
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
            'category' => 'Contribution',
            'type' => 'deposit',
            'transaction_date' => now(),
            'status' => 'pending',
            'payment_proof_path' => $path,
            'notes' => 'Member Contribution: ' . ($validated['notes'] ?? 'Manual deposit'),
            'recorded_by' => null,
        ]);

        return redirect()->route('contributions.index')->with('success', 'Contribution submitted successfully! Pending approval.');
    }

    public function show(Saving $contribution)
    {
        if ($contribution->category !== 'Contribution') {
            abort(404);
        }

        $contribution->load('member.user');

        return view('contributions.show', compact('contribution'));
    }

    public function approve(Request $request, Saving $contribution)
    {
        if (!Auth::user()->isStaff() || $contribution->category !== 'Contribution') {
            abort(403);
        }

        $contribution->update([
            'status' => 'approved',
            'recorded_by' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Contribution approved successfully.');
    }

    public function reject(Request $request, Saving $contribution)
    {
        if (!Auth::user()->isStaff() || $contribution->category !== 'Contribution') {
            abort(403);
        }

        $request->validate(['reason' => 'required|string|max:1000']);

        $contribution->update([
            'status' => 'rejected',
            'rejection_reason' => $request->reason,
            'recorded_by' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Contribution rejected.');
    }
}
