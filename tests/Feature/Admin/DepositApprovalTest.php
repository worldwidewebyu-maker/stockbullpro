<?php

namespace Tests\Feature\Admin;

use App\Models\DepositLog;
use App\Notifications\DepositApproved;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class DepositApprovalTest extends TestCase
{
    public function test_admin_can_approve_pending_deposit(): void
    {
        Notification::fake();

        $admin  = $this->createAdmin();
        $user   = $this->createUser(['balance' => 0]);
        $deposit = $this->createPendingDeposit($user, amount: 500);

        $response = $this->actingAs($admin)->post(route('admin.deposits.approve', $deposit));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $deposit->refresh();
        $user->refresh();

        $this->assertEquals('approved', $deposit->status);
        $this->assertEquals(500.00, (float) $user->balance);
        Notification::assertSentTo($user, DepositApproved::class);
    }

    public function test_admin_cannot_approve_already_processed_deposit(): void
    {
        $admin  = $this->createAdmin();
        $user   = $this->createUser();
        $deposit = $this->createPendingDeposit($user);
        $deposit->approve();

        $response = $this->actingAs($admin)->post(route('admin.deposits.approve', $deposit->fresh()));

        $response->assertSessionHas('error');
    }

    public function test_admin_can_reject_pending_deposit(): void
    {
        Notification::fake();

        $admin  = $this->createAdmin();
        $user   = $this->createUser(['balance' => 0]);
        $deposit = $this->createPendingDeposit($user);

        $response = $this->actingAs($admin)->post(route('admin.deposits.reject', $deposit), [
            'admin_note' => 'Invalid proof',
        ]);

        $response->assertSessionHas('success');
        $this->assertEquals('rejected', $deposit->fresh()->status);
        $this->assertEquals(0.00, (float) $user->fresh()->balance);
    }

    public function test_non_admin_cannot_approve_deposits(): void
    {
        $user    = $this->createUser();
        $deposit = $this->createPendingDeposit($user);

        $this->actingAs($user)
            ->post(route('admin.deposits.approve', $deposit))
            ->assertForbidden();
    }
}
