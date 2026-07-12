<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WalletService
{
    /**
     * Lifetime stat buckets that also increment on top of the spendable balance.
     */
    protected array $statBuckets = [
        'profit'         => 'profit_total',
        'bonus'          => 'bonus_total',
        'referral_bonus' => 'referral_total',
    ];

    /**
     * Add funds to a user's spendable balance and record a ledger entry.
     */
    public function credit(User $user, float $amount, string $type, ?Model $source = null, ?string $description = null): Transaction
    {
        return DB::transaction(function () use ($user, $amount, $type, $source, $description) {
            $user->refresh();
            $user->balance = (float) $user->balance + $amount;

            if (isset($this->statBuckets[$type])) {
                $bucket = $this->statBuckets[$type];
                $user->{$bucket} = (float) $user->{$bucket} + $amount;
            }

            $user->save();

            return $this->record($user, $amount, $type, 'credit', $source, $description);
        });
    }

    /**
     * Remove funds from a user's spendable balance and record a ledger entry.
     */
    public function debit(User $user, float $amount, string $type, ?Model $source = null, ?string $description = null): Transaction
    {
        return DB::transaction(function () use ($user, $amount, $type, $source, $description) {
            $user->refresh();
            $user->balance = (float) $user->balance - $amount;
            $user->save();

            return $this->record($user, $amount, $type, 'debit', $source, $description);
        });
    }

    protected function record(User $user, float $amount, string $type, string $direction, ?Model $source, ?string $description): Transaction
    {
        return $user->transactions()->create([
            'type'          => $type,
            'direction'     => $direction,
            'amount'        => $amount,
            'balance_after' => $user->balance,
            'source_type'   => $source ? $source->getMorphClass() : null,
            'source_id'     => $source?->getKey(),
            'description'   => $description,
        ]);
    }
}
