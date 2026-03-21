<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Loan extends Model
{
    protected $guarded = [];

    // Approval Stages
    // Approval Stages
    const STAGE_MANAGER_REVIEW = 1;
    const STAGE_CHAIRMAN_REVIEW = 2;
    const STAGE_FINANCE_REVIEW = 3;
    const STAGE_AUDITOR_REVIEW = 4;
    const STAGE_CHAIRMAN_FINAL = 5;
    const STAGE_TREASURER_DISBURSE = 6;

    protected $casts = [
        'amount' => 'decimal:2',
        'interest_rate' => 'decimal:2',
        'total_repayment' => 'decimal:2',
        'approved_at' => 'datetime',
        'metadata' => 'array',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function guarantors(): HasMany
    {
        return $this->hasMany(LoanGuarantor::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(LoanDocument::class);
    }

    public function committeeApprovals(): HasMany
    {
        return $this->hasMany(LoanCommitteeApproval::class);
    }

    public function repayments(): HasMany
    {
        return $this->hasMany(Repayment::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function isRepaymentDoneForMonth($month, $year)
    {
        if ($this->relationLoaded('repayments')) {
            return $this->repayments
                ->where('month', $month)
                ->where('year', $year)
                ->where('status', 'approved')
                ->isNotEmpty();
        }

        return $this->repayments()
            ->where('month', $month)
            ->where('year', $year)
            ->where('status', 'approved')
            ->exists();
    }

    public function monthlyRepaymentAmount()
    {
        return $this->duration_months > 0 
            ? $this->total_repayment / $this->duration_months 
            : 0;
    }

    public function getCurrentStageNameAttribute()
    {
        if ($this->status == 'rejected') return 'Rejected';
        if ($this->status == 'disbursed') return 'Disbursed';
        if ($this->status == 'approved' && $this->stage == self::STAGE_TREASURER_DISBURSE) return 'Ready for Disbursement';

        switch ($this->stage) {
            case self::STAGE_MANAGER_REVIEW: return 'Manager Review';
            case self::STAGE_CHAIRMAN_REVIEW: return 'Chairman Review';
            case self::STAGE_FINANCE_REVIEW: return 'Finance Review';
            case self::STAGE_AUDITOR_REVIEW: return 'Auditor Review';
            case self::STAGE_CHAIRMAN_FINAL: return 'Chairman Final';
            case self::STAGE_TREASURER_DISBURSE: return 'Treasurer Action';
            default: return 'Processing';
        }
    }
}
