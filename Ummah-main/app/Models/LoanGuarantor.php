<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoanGuarantor extends Model
{
    protected $guarded = [];

    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }
}
