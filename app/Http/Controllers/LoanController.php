<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $query = Loan::with('member')->latest();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if (Auth::user()->role === 'member') {
            $member = Auth::user()->member;
            if ($member) {
                $query->where('member_id', $member->id);
                $totalRepaid = \App\Models\Repayment::where('status', 'approved')->whereHas('loan', function($q) use ($member) {
                    $q->where('member_id', $member->id);
                })->sum('amount');
            } else {
                $query->where('id', 0);
                $totalRepaid = 0;
            }
        } else {
            $totalRepaid = \App\Models\Repayment::where('status', 'approved')->sum('amount');
        }

        $stats = [
            'active_balance' => $query->clone()->whereIn('status', ['approved', 'disbursed'])->sum('total_repayment') - \App\Models\Repayment::where('status', 'approved')->whereIn('loan_id', $query->clone()->whereIn('status', ['approved', 'disbursed'])->pluck('id'))->sum('amount'),
            'total_repaid' => $totalRepaid,
            'pending_count' => $query->clone()->where('status', 'pending')->count(),
        ];

        $loans = $query->paginate(10);

        return view('loans.index', compact('loans', 'stats'));
    }

    public function create()
    {
        if (Auth::user()->isStaff()) {
            $members = Member::where('status', 'active')->orderBy('first_name')->orderBy('last_name')->get();
        } else {
            $members = Member::where('user_id', Auth::id())->get();
        }
        return view('loans.create', compact('members'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'amount' => 'required|numeric|min:20000|max:3000000',
            'duration_months' => 'required|integer|in:3,6,12,18',
            'interest_rate' => 'required|numeric|min:0',
            'purpose' => 'nullable|string',
        ]);

        // Access control: Members can only create for themselves
        if (!Auth::user()->isStaff()) {
            $userMember = Auth::user()->member;
            if (!$userMember || $validated['member_id'] != $userMember->id) {
                abort(403, 'You can only apply for a loan for yourself.');
            }
        }

        // Calculate total repayment (Simple interest for example)
        // Total = Principal + (Principal * Rate * Time / 100) 
        // Assuming Rate is monthly? Or Annual? Let's assume input is flat rate for the period for simplicity or monthly.
        // Let's assume input is % flat rate.
        $interest = ($validated['amount'] * $validated['interest_rate']) / 100;
        $validated['total_repayment'] = $validated['amount'] + $interest;
        $validated['status'] = 'pending';

        Loan::create($validated);

        return redirect()->route('loans.index')->with('success', 'Loan application submitted successfully.');
    }

    public function show(Loan $loan)
    {
        if (!Auth::user()->isStaff() && $loan->member_id !== Auth::user()->member->id) {
            abort(403);
        }
        $loan->load(['member', 'repayments']);
        return view('loans.show', compact('loan'));
    }

    public function update(Request $request, Loan $loan)
    {
        // Admin approval logic
        if (!Auth::user()->isStaff()) {
            abort(403);
        }

        if ($request->has('status')) {
            $loan->update([
                'status' => $request->status,
                'approved_by' => Auth::id(),
                'approved_at' => now(),
            ]);
        }

        return back()->with('success', 'Loan status updated.');
    }
}
