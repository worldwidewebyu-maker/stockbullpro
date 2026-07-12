<?php

namespace Tests\Unit\Services;

use App\Models\UserInvestment;
use App\Notifications\InvestmentMatured;
use App\Services\InvestmentProcessor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class InvestmentProcessorTest extends TestCase
{
    private InvestmentProcessor $processor;

    protected function setUp(): void
    {
        parent::setUp();
        $this->processor = app(InvestmentProcessor::class);
        Notification::fake();
    }

    public function test_accrues_daily_profit_over_time(): void
    {
        Carbon::setTestNow('2026-01-10');

        $user = $this->createUser(['balance' => 0]);
        $plan = $this->createInvestmentPlan([
            'roi_percentage' => 10,
            'roi_period'     => 'Daily',
            'duration_days'  => 5,
        ]);

        $investment = $this->createActiveInvestment($user, $plan, [
            'start_date'   => Carbon::parse('2026-01-01'),
            'end_date'     => Carbon::parse('2026-01-06'),
            'final_amount' => 1000,
        ]);

        $stats = $this->processor->process(Carbon::parse('2026-01-04'));

        $investment->refresh();
        $this->assertEquals(1, $stats['profit_accrued']);
        $this->assertEquals(300.00, (float) $investment->accrued_profit);
        $this->assertEquals(3, $investment->profit_periods_paid);
        $this->assertEquals('active', $investment->status);
        $this->assertEquals(0.00, (float) $user->fresh()->balance);
    }

    public function test_matures_investment_and_pays_principal_and_profit(): void
    {
        Carbon::setTestNow('2026-01-10');

        $user = $this->createUser(['balance' => 0, 'profit_total' => 0]);
        $plan = $this->createInvestmentPlan([
            'roi_percentage' => 10,
            'roi_period'     => 'Daily',
            'duration_days'  => 5,
        ]);

        $investment = $this->createActiveInvestment($user, $plan, [
            'start_date'   => Carbon::parse('2026-01-01'),
            'end_date'     => Carbon::parse('2026-01-06'),
            'final_amount' => 1000,
        ]);

        $stats = $this->processor->process(Carbon::parse('2026-01-06'));

        $investment->refresh();
        $user->refresh();

        $this->assertEquals(1, $stats['matured']);
        $this->assertEquals('matured', $investment->status);
        $this->assertEquals(500.00, (float) $investment->accrued_profit);
        $this->assertEquals(1500.00, (float) $user->balance);
        $this->assertEquals(500.00, (float) $user->profit_total);
        $this->assertNotNull($investment->matured_at);

        Notification::assertSentTo($user, InvestmentMatured::class);
    }

    public function test_is_idempotent_on_repeated_runs(): void
    {
        Carbon::setTestNow('2026-01-10');

        $user = $this->createUser(['balance' => 0]);
        $investment = $this->createActiveInvestment($user, overrides: [
            'start_date'   => Carbon::parse('2026-01-01'),
            'end_date'     => Carbon::parse('2026-01-06'),
            'roi_percentage' => 10,
            'roi_period'     => 'Daily',
            'duration_days'  => 5,
            'final_amount'   => 1000,
        ]);

        $this->processor->process(Carbon::parse('2026-01-06'));
        $balanceAfterFirst = (float) $user->fresh()->balance;

        $stats = $this->processor->process(Carbon::parse('2026-01-06'));

        $this->assertEquals(0, $stats['processed']);
        $this->assertEquals($balanceAfterFirst, (float) $user->fresh()->balance);
        $this->assertEquals('matured', $investment->fresh()->status);
    }
}
