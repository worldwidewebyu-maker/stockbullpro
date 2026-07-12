<?php

namespace Tests\Feature\Admin;

use App\Models\Customer;
use App\Notifications\AccountDebited;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class UserDeductTest extends TestCase
{
    public function test_admin_can_deduct_from_user_balance(): void
    {
        Notification::fake();

        $admin = $this->createAdmin();
        $user  = $this->createUser(['balance' => 1000]);

        $response = $this->actingAs($admin)->post(route('admin.users.deduct', $user), [
            'amount' => 250,
            'note'   => 'Manual correction',
        ]);

        $response->assertRedirect(route('admin.users.show', $user));
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertEquals(750.00, (float) $user->balance);
        $this->assertDatabaseHas('transactions', [
            'user_id'   => $user->id,
            'type'      => 'adjustment',
            'direction' => 'debit',
            'amount'    => 250,
        ]);

        Notification::assertSentTo(Customer::find($user->id), AccountDebited::class);
    }

    public function test_deduct_fails_when_amount_exceeds_balance(): void
    {
        $admin = $this->createAdmin();
        $user  = $this->createUser(['balance' => 100]);

        $response = $this->actingAs($admin)->post(route('admin.users.deduct', $user), [
            'amount' => 500,
        ]);

        $response->assertSessionHasErrors('amount');
        $this->assertEquals(100.00, (float) $user->fresh()->balance);
    }
}
