<?php

namespace App\Models;

use App\Services\ReferralService;
use App\Services\WalletService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DepositLog extends Model
{
    protected $fillable = [
        'user_id', 'deposit_method_id',
        'amount', 'charge', 'final_amount',
        'proof', 'status', 'admin_note',
        'approved_at', 'processed_by',
    ];

    protected function casts(): array
    {
        return [
            'amount'       => 'decimal:2',
            'charge'       => 'decimal:2',
            'final_amount' => 'decimal:2',
            'approved_at'  => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function method()
    {
        return $this->belongsTo(DepositMethod::class, 'deposit_method_id');
    }

    public function getProofUrlAttribute(): ?string
    {
        return $this->proof ? asset('storage/' . $this->proof) : null;
    }

    /**
     * Approve the deposit: credit the user's balance and award any referral bonus.
     * Safe to call only on pending deposits.
     */
    public function approve(?User $admin = null): bool
    {
        if ($this->status === 'approved') {
            return false;
        }

        DB::transaction(function () use ($admin) {
            $this->update([
                'status'       => 'approved',
                'approved_at'  => now(),
                'processed_by' => $admin?->id,
            ]);

            app(WalletService::class)->credit(
                $this->user,
                (float) $this->amount,
                'deposit',
                $this,
                'Deposit approved',
            );

            app(ReferralService::class)->awardForDeposit($this);
        });

        return true;
    }

    public function reject(?User $admin = null, ?string $note = null): bool
    {
        if ($this->status === 'approved') {
            return false;
        }

        $this->update([
            'status'       => 'rejected',
            'processed_by' => $admin?->id,
            'admin_note'   => $note ?? $this->admin_note,
        ]);

        return true;
    }
}
