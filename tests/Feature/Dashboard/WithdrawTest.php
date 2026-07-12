<?php

namespace Tests\Feature\Dashboard;

use App\Models\WithdrawalRequest;
use Tests\TestCase;

class WithdrawTest extends TestCase
{
    public function test_user_can_submit_withdrawal_request(): void
    {
        $user   = $this->createUser(['balance' => 1000]);
        $method = $this->createWithdrawalMethod(['min_amount' => 10, 'max_amount' => 5000]);

        $response = $this->actingAs($user)->post(route('dashboard.withdraw.submit', $method), [
            'amount'         => 300,
            'wallet_address' => 'bc1qwithdrawtest',
        ]);

        $response->assertRedirect(route('dashboard.withdraw'));
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertEquals(700.00, (float) $user->balance);
        $this->assertEquals(1, WithdrawalRequest::count());
        $this->assertDatabaseHas('transactions', [
            'user_id'   => $user->id,
            'type'      => 'withdrawal',
            'direction' => 'debit',
            'amount'    => 300,
        ]);
    }

    public function test_withdrawal_fails_with_insufficient_balance(): void
    {
        $user   = $this->createUser(['balance' => 50]);
        $method = $this->createWithdrawalMethod(['min_amount' => 10, 'max_amount' => 5000]);

        $response = $this->actingAs($user)->post(route('dashboard.withdraw.submit', $method), [
            'amount'         => 300,
            'wallet_address' => 'bc1qwithdrawtest',
        ]);

        $response->assertSessionHasErrors('amount');
        $this->assertEquals(0, WithdrawalRequest::count());
    }
}
