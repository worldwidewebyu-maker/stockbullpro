<?php

namespace Tests\Unit\Services;

use App\Models\Setting;
use App\Models\User;
use App\Services\WalletService;
use Tests\TestCase;

class WalletServiceTest extends TestCase
{
    private WalletService $wallet;

    protected function setUp(): void
    {
        parent::setUp();
        $this->wallet = app(WalletService::class);
    }

    public function test_credit_increases_balance_and_records_transaction(): void
    {
        $user = $this->createUser(['balance' => 100]);

        $txn = $this->wallet->credit($user, 50, 'deposit', null, 'Test deposit');

        $user->refresh();
        $this->assertEquals(150.00, (float) $user->balance);
        $this->assertEquals('credit', $txn->direction);
        $this->assertEquals('deposit', $txn->type);
        $this->assertEquals(150.00, (float) $txn->balance_after);
    }

    public function test_credit_profit_increments_profit_total(): void
    {
        $user = $this->createUser(['balance' => 0, 'profit_total' => 0]);

        $this->wallet->credit($user, 25, 'profit', null, 'ROI');

        $user->refresh();
        $this->assertEquals(25.00, (float) $user->balance);
        $this->assertEquals(25.00, (float) $user->profit_total);
    }

    public function test_credit_referral_bonus_increments_referral_total(): void
    {
        $user = $this->createUser(['balance' => 0, 'referral_total' => 0]);

        $this->wallet->credit($user, 30, 'referral_bonus', null, 'Referral');

        $user->refresh();
        $this->assertEquals(30.00, (float) $user->referral_total);
    }

    public function test_debit_decreases_balance_and_records_transaction(): void
    {
        $user = $this->createUser(['balance' => 200]);

        $this->wallet->debit($user, 75, 'investment', null, 'Invest');

        $user->refresh();
        $this->assertEquals(125.00, (float) $user->balance);
        $this->assertDatabaseHas('transactions', [
            'user_id'   => $user->id,
            'type'      => 'investment',
            'direction' => 'debit',
            'amount'    => 75,
        ]);
    }
}
