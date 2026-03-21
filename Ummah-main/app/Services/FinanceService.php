<?php

namespace App\Services;

use App\Models\Member;
use App\Models\Saving;
use App\Models\Loan;
use Carbon\Carbon;

class FinanceService
{
    /**
     * Calculate the personal savings balance for a member.
     */
    public function getMemberSavingsBalance(Member $member, Carbon $upToDate = null): float
    {
        $query = $member->savings()
            ->where('category', 'Personal Savings')
            ->where('status', 'approved');

        if ($upToDate) {
            $query->where('transaction_date', '<', $upToDate);
        }

        $deposits = (clone $query)->where('type', 'deposit')->sum('amount');
        $withdrawals = (clone $query)->where('type', 'withdrawal')->sum('amount');

        return (float) ($deposits - $withdrawals);
    }

    /**
     * Calculate the total contributions for a member.
     */
    public function getMemberTotalContributions(Member $member): float
    {
        return (float) $member->savings()
            ->where('category', 'Contribution')
            ->where('status', 'approved')
            ->where('type', 'deposit')
            ->sum('amount');
    }

    /**
     * Calculate interest rate based on loan purpose.
     */
    public function calculateInterestRate(string $purpose): float
    {
        $emergencyPurposes = ['Emergency', 'Essential Commodity'];
        return in_array($purpose, $emergencyPurposes) ? 6.0 : 10.0;
    }

    /**
     * Calculate total repayment for a standard loan.
     */
    public function calculateTotalRepayment(float $amount, float $interestRate): float
    {
        $interest = $amount * ($interestRate / 100);
        return $amount + $interest;
    }

    /**
     * Calculate remaining loan balance for a member.
     */
    public function getMemberActiveLoansBalance(Member $member): float
    {
        $activeLoans = $member->loans()->whereIn('status', ['approved', 'disbursed'])->get();
        $totalRemaining = 0;

        foreach ($activeLoans as $loan) {
            $totalPaid = $loan->repayments()->where('status', 'approved')->sum('amount');
            $totalRemaining += max(0, $loan->total_repayment - $totalPaid);
        }

        return (float) $totalRemaining;
    }

    /**
     * Calculate global active loans balance (Staff view).
     */
    public function getGlobalActiveLoansBalance(): float
    {
        return (float) (Loan::query()->where('status', 'approved')->orWhere('status', 'disbursed')->sum('total_repayment') - \App\Models\Repayment::query()->where('status', '=', 'approved')->sum('amount'));
    }

    /**
     * Calculate global personal savings balance (Staff view).
     */
    public function getGlobalSavingsBalance(): float
    {
        $deposits = Saving::query()->where('category', '=', 'Personal Savings')->where('status', '=', 'approved')->where('type', '=', 'deposit')->sum('amount');
        $withdrawals = Saving::query()->where('category', '=', 'Personal Savings')->where('status', '=', 'approved')->where('type', '=', 'withdrawal')->sum('amount');
        return (float) ($deposits - $withdrawals);
    }

    /**
     * Calculate global total contributions (Staff view).
     */
    public function getGlobalTotalContributions(): float
    {
        return (float) Saving::query()->where('category', '=', 'Contribution')->where('status', '=', 'approved')->where('type', '=', 'deposit')->sum('amount');
    }

    /**
     * Calculate total repayment for Ramadan/Sallah loans.
     */
    public function calculateRamadanSallahRepayment(float $amount): float
    {
        // For now, it seems RS loans don't add interest to the total_repayment field in the controller, 
        // but interest_rate is set to 6. Let's align with the controller's logic or standardize.
        // Controller line 282: 'total_repayment' => $validated['amount'], 
        return $amount; 
    }

    /**
     * Calculate total repayment for Asset loans (Fixed 10%).
     */
    public function calculateAssetRepayment(float $amount): float
    {
        return $amount * 1.10;
    }
}
