<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_number',
        'user_id',
        'title',
        'first_name',
        'middle_name',
        'last_name',
        'dob',
        'gender',
        'marital_status',
        'phone',
        'address',
        'city',
        'state',
        'occupation',
        'employer_name',
        'monthly_income_range',
        'next_of_kin_name',
        'nok_relationship',
        'next_of_kin_phone',
        'emergency_contact_name',
        'emergency_contact_phone',
        'id_type',
        'id_number',
        'id_card_path',
        'passport_photo_path',
        'bank_name',
        'account_name',
        'account_number',
        'payment_method',
        'payment_proof_path',
        'application_ref',
        'status',
        'rejection_reason',
    ];

    protected $casts = [
        'dob' => 'date',
    ];

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function savings(): HasMany
    {
        return $this->hasMany(Saving::class);
    }

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }
}
