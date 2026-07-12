<?php

namespace App\Models;

use App\Services\WalletService;
use Illuminate\Database\Eloquent\Model;

class WithdrawalRequest extends Model
{
    protected $fillable = [
        'user_id', 'withdrawal_method_id',
        'amount', 'charge', 'final_amount',
        'wallet_address', 'status', 'admin_note',
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
        return $this->belongsTo(WithdrawalMethod::class, 'withdrawal_method_id');
    }

    /**
     * Approve the withdrawal. Funds were already reserved (debited) on request,
     * so approval only finalizes the record.
     */
    public function approve(?User $admin = null): bool
    {
        if ($this->status !== 'pending') {
            return false;
        }

        $this->update([
            'status'       => 'approved',
            'approved_at'  => now(),
            'processed_by' => $admin?->id,
        ]);

        return true;
    }

    /**
     * Reject the withdrawal and refund the reserved amount to the user's balance.
     */
    public function reject(?User $admin = null, ?string $note = null): bool
    {
        if ($this->status !== 'pending') {
            return false;
        }

        $this->update([
            'status'       => 'rejected',
            'processed_by' => $admin?->id,
            'admin_note'   => $note ?? $this->admin_note,
        ]);

        app(WalletService::class)->credit(
            $this->user,
            (float) $this->amount,
            'adjustment',
            $this,
            'Withdrawal rejected - refund',
        );

        return true;
    }
}
