<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

#[Fillable(['username', 'full_name', 'email', 'phone', 'country', 'referral', 'password',
            'notify_withdrawal_otp', 'notify_profit_email', 'notify_plan_expiry_email',
            'balance', 'profit_total', 'bonus_total', 'referral_total',
            'referral_code', 'referred_by', 'is_admin'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at'        => 'datetime',
            'password'                 => 'hashed',
            'notify_withdrawal_otp'    => 'boolean',
            'notify_profit_email'      => 'boolean',
            'notify_plan_expiry_email' => 'boolean',
            'is_admin'                 => 'boolean',
            'balance'                  => 'decimal:2',
            'profit_total'             => 'decimal:2',
            'bonus_total'              => 'decimal:2',
            'referral_total'           => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (User $user) {
            if (empty($user->referral_code)) {
                $user->referral_code = static::generateReferralCode();
            }
        });
    }

    public static function generateReferralCode(): string
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (static::withoutGlobalScopes()->where('referral_code', $code)->exists());

        return $code;
    }

    public function isAdmin(): bool
    {
        return (bool) $this->is_admin;
    }

    public function wallets()
    {
        return $this->hasMany(UserWallet::class, 'user_id');
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    public function referrals()
    {
        return $this->hasMany(User::class, 'referred_by');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_id');
    }

    public function referralEarnings()
    {
        return $this->hasMany(ReferralEarning::class, 'referrer_id');
    }

    public function deposits()
    {
        return $this->hasMany(DepositLog::class, 'user_id');
    }

    public function withdrawals()
    {
        return $this->hasMany(WithdrawalRequest::class, 'user_id');
    }

    public function investments()
    {
        return $this->hasMany(UserInvestment::class, 'user_id');
    }
}
