<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankReconciliation extends Model
{
    use HasFactory;

    protected $fillable = [
        'reconciliation_date',
        'bank_statement_balance',
        'cashbook_balance',
        'difference',
        'reconciled_by',
        'notes',
        'status',
        'reconciliation_items',
    ];

    protected $casts = [
        'reconciliation_date' => 'date',
        'bank_statement_balance' => 'decimal:2',
        'cashbook_balance' => 'decimal:2',
        'difference' => 'decimal:2',
        'reconciliation_items' => 'array',
    ];

    /**
     * Get the user who performed the reconciliation
     */
    public function reconciledBy()
    {
        return $this->belongsTo(User::class, 'reconciled_by');
    }
}
