<?php

namespace Tests\Feature\Dashboard;

use App\Models\Setting;
use App\Models\UserInvestment;
use Tests\TestCase;

class InvestTest extends TestCase
{
    public function test_user_can_join_investment_plan(): void
    {
        $user = $this->createUser(['balance' => 5000]);
        $plan = $this->createInvestmentPlan([
            'min_amount' => 100,
            'max_amount' => 10000,
        ]);

        $response = $this->actingAs($user)->post(route('dashboard.invest.join', $plan), [
            'amount' => 1000,
        ]);

        $response->assertRedirect(route('dashboard.plans'));
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertEquals(4000.00, (float) $user->balance);
        $this->assertEquals(1, UserInvestment::count());

        $investment = UserInvestment::first();
        $this->assertEquals('active', $investment->status);
        $this->assertEquals(1000.00, (float) $investment->amount);
        $this->assertDatabaseHas('transactions', [
            'user_id'   => $user->id,
            'type'      => 'investment',
            'direction' => 'debit',
        ]);
    }

    public function test_join_fails_with_insufficient_balance(): void
    {
        $user = $this->createUser(['balance' => 50]);
        $plan = $this->createInvestmentPlan(['min_amount' => 100, 'max_amount' => 10000]);

        $response = $this->actingAs($user)->post(route('dashboard.invest.join', $plan), [
            'amount' => 1000,
        ]);

        $response->assertSessionHasErrors('amount');
        $this->assertEquals(0, UserInvestment::count());
    }

    public function test_user_can_view_investment_plans_page(): void
    {
        $user = $this->createUser();
        $this->createActiveInvestment($user);

        $this->actingAs($user)
            ->get(route('dashboard.plans'))
            ->assertOk()
            ->assertSee('TEST PLAN');
    }
}
