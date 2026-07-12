<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferralEarning extends Model
{
    protected $fillable = [
        'referrer_id', 'referred_id', 'deposit_log_id', 'amount',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
        ];
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    public function referred()
    {
        return $this->belongsTo(User::class, 'referred_id');
    }

    public function deposit()
    {
        return $this->belongsTo(DepositLog::class, 'deposit_log_id');
    }
}
