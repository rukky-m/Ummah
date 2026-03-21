<?php

namespace App\Models;

use App\Notifications\QueuedVerifyEmail;
use App\Notifications\QueuedResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_photo_path',
        'approval_order',
        'google_id',
        'google_token',
        'google_refresh_token',
    ];

    public function member(): HasOne
    {
        return $this->hasOne(Member::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isStaff(): bool
    {
        return $this->role === 'staff' || $this->role === 'admin';
    }

    // Role-Based Permissions
    public function canManageMembers(): bool
    {
        // Manager(4), Chairman(1), Financial Secretary(2)
        return $this->isAdmin() && in_array($this->approval_order, [1, 2, 4]);
    }

    public function canManageAnnouncements(): bool
    {
        // Admin 6: PRO
        return $this->isAdmin() && $this->approval_order === 6;
    }

    public function canViewCashbook(): bool
    {
        // Admin 2: Finance, 3: Auditor
        if ($this->isAdmin() && in_array($this->approval_order, [2, 3])) return true;
        // Chairman fallback if Finance is unassigned
        if ($this->isAdmin() && $this->approval_order == 1) {
            if (!static::where('role','admin')->where('approval_order',2)->exists()) return true;
        }
        return false;
    }

    public function canManageRepayments(): bool
    {
        // Admin 2: Finance, 3: Auditor, 5: Treasurer
        if ($this->isAdmin() && in_array($this->approval_order, [2, 3, 5])) return true;
        // Chairman fallback if Finance & Treasurer are unassigned
        if ($this->isAdmin() && $this->approval_order == 1) {
            $hasFinance   = static::where('role','admin')->where('approval_order',2)->exists();
            $hasTreasurer = static::where('role','admin')->where('approval_order',5)->exists();
            if (!$hasFinance && !$hasTreasurer) return true;
        }
        return false;
    }

    public function canManageContributions(): bool
    {
        // Admin 2: Finance, 5: Treasurer
        if ($this->isAdmin() && in_array($this->approval_order, [2, 5])) return true;
        // Chairman fallback if Finance & Treasurer are unassigned
        if ($this->isAdmin() && $this->approval_order == 1) {
            $hasFinance   = static::where('role','admin')->where('approval_order',2)->exists();
            $hasTreasurer = static::where('role','admin')->where('approval_order',5)->exists();
            if (!$hasFinance && !$hasTreasurer) return true;
        }
        return false;
    }

    public function canManageSavings(): bool
    {
        // Manager(4), Chairman(1), Financial Secretary(2)
        return $this->isAdmin() && in_array($this->approval_order, [1, 2, 4]);
    }

    public function canManageLoans(): bool
    {
        // Admin 1: Chairman, 2: Finance, 3: Auditor, 4: Manager, 5: Treasurer
        // Excluded: Admin 6 (PRO)
        return $this->isAdmin() && in_array($this->approval_order, [1, 2, 3, 4, 5]);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    public function tickets(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SupportTicket::class);
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new QueuedVerifyEmail);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new QueuedResetPassword($token));
    }
}
