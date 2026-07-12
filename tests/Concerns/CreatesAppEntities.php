<?php

namespace Tests\Concerns;

use App\Models\DepositLog;
use App\Models\DepositMethod;
use App\Models\InvestmentPlan;
use App\Models\User;
use App\Models\UserInvestment;
use App\Models\WithdrawalMethod;
use Carbon\Carbon;

trait CreatesAppEntities
{
    protected function createUser(array $attributes = []): User
    {
        return User::factory()->create($attributes);
    }

    protected function createAdmin(array $attributes = []): User
    {
        return User::factory()->admin()->create($attributes);
    }

    protected function createInvestmentPlan(array $attributes = []): InvestmentPlan
    {
        return InvestmentPlan::create(array_merge([
            'name'           => 'TEST PLAN',
            'roi_percentage' => 10,
            'roi_period'     => 'Daily',
            'duration_days'  => 5,
            'min_amount'     => 100,
            'max_amount'     => 10000,
            'charge_type'    => 'percentage',
            'charge_amount'  => 0,
            'is_active'      => true,
            'sort_order'     => 1,
        ], $attributes));
    }

    protected function createDepositMethod(array $attributes = []): DepositMethod
    {
        return DepositMethod::create(array_merge([
            'name'           => 'Bitcoin',
            'wallet_address' => 'bc1qtest',
            'min_amount'     => 10,
            'max_amount'     => 100000,
            'charge_type'    => 'percentage',
            'charge_amount'  => 0,
            'is_active'      => true,
            'sort_order'     => 1,
        ], $attributes));
    }

    protected function createWithdrawalMethod(array $attributes = []): WithdrawalMethod
    {
        return WithdrawalMethod::create(array_merge([
            'name'           => 'Bank Transfer',
            'min_amount'     => 10,
            'max_amount'     => 100000,
            'charge_type'    => 'percentage',
            'charge_amount'  => 0,
            'duration'       => 'Instant',
            'is_active'      => true,
            'sort_order'     => 1,
        ], $attributes));
    }

    protected function createPendingDeposit(User $user, ?DepositMethod $method = null, float $amount = 500): DepositLog
    {
        $method ??= $this->createDepositMethod();

        return DepositLog::create([
            'user_id'           => $user->id,
            'deposit_method_id' => $method->id,
            'amount'            => $amount,
            'charge'            => 0,
            'final_amount'      => $amount,
            'status'            => 'pending',
        ]);
    }

    protected function createActiveInvestment(User $user, ?InvestmentPlan $plan = null, array $overrides = []): UserInvestment
    {
        $plan ??= $this->createInvestmentPlan();
        $start = Carbon::parse($overrides['start_date'] ?? now()->subDays(3)->startOfDay());

        return UserInvestment::create(array_merge([
            'user_id'            => $user->id,
            'investment_plan_id' => $plan->id,
            'plan_name'          => $plan->name,
            'roi_percentage'     => $plan->roi_percentage,
            'roi_period'         => $plan->roi_period,
            'duration_days'      => $plan->duration_days,
            'amount'             => 1000,
            'charge'             => 0,
            'final_amount'       => 1000,
            'start_date'         => $start,
            'end_date'           => $start->copy()->addDays($plan->duration_days),
            'status'             => 'active',
        ], $overrides));
    }
}
