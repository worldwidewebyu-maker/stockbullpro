<?php

namespace Tests\Feature\Admin;

use App\Models\WithdrawalRequest;
use App\Services\WalletService;
use Tests\TestCase;

class WithdrawalApprovalTest extends TestCase
{
    public function test_admin_can_approve_pending_withdrawal(): void
    {
        $admin = $this->createAdmin();
        $user  = $this->createUser(['balance' => 1000]);
        $method = $this->createWithdrawalMethod();

        $withdrawal = WithdrawalRequest::create([
            'user_id'              => $user->id,
            'withdrawal_method_id' => $method->id,
            'amount'               => 300,
            'charge'               => 0,
            'final_amount'         => 300,
            'wallet_address'       => 'addr123',
            'status'               => 'pending',
        ]);

        app(WalletService::class)->debit($user, 300, 'withdrawal', $withdrawal);

        $response = $this->actingAs($admin)->post(route('admin.withdrawals.approve', $withdrawal));

        $response->assertSessionHas('success');
        $this->assertEquals('approved', $withdrawal->fresh()->status);
        $this->assertEquals(700.00, (float) $user->fresh()->balance);
    }

    public function test_admin_reject_refunds_user_balance(): void
    {
        $admin = $this->createAdmin();
        $user  = $this->createUser(['balance' => 1000]);
        $method = $this->createWithdrawalMethod();

        $withdrawal = WithdrawalRequest::create([
            'user_id'              => $user->id,
            'withdrawal_method_id' => $method->id,
            'amount'               => 300,
            'charge'               => 0,
            'final_amount'         => 300,
            'wallet_address'       => 'addr123',
            'status'               => 'pending',
        ]);

        app(WalletService::class)->debit($user, 300, 'withdrawal', $withdrawal);
        $user->refresh();
        $this->assertEquals(700.00, (float) $user->balance);

        $response = $this->actingAs($admin)->post(route('admin.withdrawals.reject', $withdrawal), [
            'admin_note' => 'Invalid address',
        ]);

        $response->assertSessionHas('success');
        $this->assertEquals('rejected', $withdrawal->fresh()->status);
        $this->assertEquals(1000.00, (float) $user->fresh()->balance);
    }
}
