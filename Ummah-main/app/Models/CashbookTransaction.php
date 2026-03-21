<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashbookTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_date',
        'type',
        'category',
        'amount',
        'payment_method',
        'description',
        'reference_number',
        'attachment_path',
    ];

    protected $casts = [
        'transaction_date' => 'date',
    ];
}
