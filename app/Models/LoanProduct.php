<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanProduct extends Model
{
    protected $fillable = [
        'category',
        'name',
        'price',
        'vendor', // keeping for backward compatibility if needed, but we'll use vendor_id
        'vendor_id',
        'is_active',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
