<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Repayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RepaymentController extends Controller
{
    /**
     * Display a listing of repayments for admin.
     */
    public function index()
    {
        $repayments = Repayment::with(['loan.member', 'recordedBy'])
            ->latest()
            ->paginate(15);
            
        return view('admin.repayments.index', compact('repayments'));
    }

    /**
     * Display a single repayment for review.
     */
    public function show(Repayment $repayment)
    {
        $repayment->load(['loan.member.user', 'recordedBy']);
        return view('admin.repayments.show', compact('repayment'));
    }

    /**
     * Show the form for a user to submit a repayment.
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        if (!$user->member) {
            return redirect()->route('dashboard')->with('error', 'Member profile not found.');
        }

        $loans = $user->member->loans()
            ->whereIn('status', ['approved', 'disbursed'])
            ->get();

        if ($loans->isEmpty()) {
            return redirect()->route('loans.index')->with('error', 'You do not have any active loans to repay.');
        }

        $selectedLoanId = $request->loan_id;

        // Auto-select if there's only one active loan
        if (!$selectedLoanId && $loans->count() === 1) {
            $selectedLoanId = $loans->first()->id;
        }

        return view('repayments.repay', compact('loans', 'selectedLoanId'));
    }

    /**
     * Store a user-submitted repayment proof.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'loan_id' => 'required|exists:loans,id',
            'amount' => 'required|numeric|min:1',
            'month' => 'required|string',
            'year' => 'required|integer',
            'proof_image' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $loan = Loan::findOrFail($validated['loan_id']);
        
        // Ensure user owns the loan
        if ($loan->member_id !== Auth::user()->member->id) {
            abort(403);
        }

        $proofPath = $request->file('proof_image')->store('repayment_proofs', 'public');

        Repayment::create([
            'loan_id' => $loan->id,
            'amount' => $validated['amount'],
            'month' => $validated['month'],
            'year' => $validated['year'],
            'status' => 'pending',
            'proof_path' => $proofPath,
            'payment_method' => 'Bank Transfer', // Default for self-submission
            'paid_at' => now(),
        ]);

        return redirect()->route('loans.index')->with('success', 'Repayment proof submitted successfully. Waiting for admin approval.');
    }

    /**
     * Admin approves a repayment.
     */
    public function approve(Request $request, Repayment $repayment)
    {
        $repayment->update([
            'status' => 'approved',
            'recorded_by' => Auth::id(),
            'admin_comment' => $request->comment,
        ]);

        // Check if loan is fully paid
        $loan = $repayment->loan;
        $totalPaid = $loan->repayments()->where('status', 'approved')->sum('amount');
        if ($totalPaid >= $loan->total_repayment) {
            $loan->update(['status' => 'paid']);
        }

        // Optional: Record in Cashbook
        \App\Models\CashbookTransaction::create([
            'transaction_date' => now(),
            'type' => 'income',
            'category' => 'Loan Repayment',
            'amount' => $repayment->amount,
            'payment_method' => $repayment->payment_method,
            'description' => "Repayment for Loan #{$loan->application_number} by {$loan->member->full_name} ({$repayment->month} {$repayment->year})",
            'reference_number' => $repayment->reference ?? $loan->application_number,
        ]);

        return back()->with('success', 'Repayment approved successfully.');
    }

    /**
     * Admin rejects a repayment.
     */
    public function reject(Request $request, Repayment $repayment)
    {
        $request->validate(['comment' => 'required|string']);

        $repayment->update([
            'status' => 'rejected',
            'admin_comment' => $request->comment,
            'recorded_by' => Auth::id(),
        ]);

        return back()->with('success', 'Repayment rejected.');
    }
}
