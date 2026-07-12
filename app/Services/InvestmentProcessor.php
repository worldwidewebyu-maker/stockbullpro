<?php

namespace App\Services;

use App\Models\UserInvestment;
use App\Notifications\InvestmentMatured;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InvestmentProcessor
{
    public function __construct(protected WalletService $wallet) {}

    /**
     * Accrue ROI for active investments and mature those that have reached end_date.
     */
    public function process(?Carbon $asOf = null): array
    {
        $asOf = ($asOf ?? now())->copy()->startOfDay();

        $stats = [
            'processed'      => 0,
            'profit_accrued' => 0,
            'matured'        => 0,
            'errors'         => [],
        ];

        UserInvestment::query()
            ->where('status', 'active')
            ->where('start_date', '<=', $asOf)
            ->orderBy('id')
            ->chunkById(100, function ($investments) use ($asOf, &$stats) {
                foreach ($investments as $investment) {
                    try {
                        $this->processInvestment($investment, $asOf, $stats);
                    } catch (\Throwable $e) {
                        $stats['errors'][] = [
                            'investment_id' => $investment->id,
                            'message'       => $e->getMessage(),
                        ];
                    }
                }
            });

        return $stats;
    }

    protected function processInvestment(UserInvestment $investment, Carbon $asOf, array &$stats): void
    {
        DB::transaction(function () use ($investment, $asOf, &$stats) {
            $investment->refresh();

            if ($investment->status !== 'active') {
                return;
            }

            $stats['processed']++;

            if ($this->accrueProfit($investment, $asOf)) {
                $stats['profit_accrued']++;
            }

            if ($asOf->greaterThanOrEqualTo($investment->end_date->copy()->startOfDay())) {
                $this->matureInvestment($investment, $stats);
            }
        });
    }

    protected function accrueProfit(UserInvestment $investment, Carbon $asOf): bool
    {
        $interval = $this->roiIntervalDays($investment->roi_period);
        $maxPeriods = $this->maxProfitPeriods($investment);
        $daysSinceStart = $investment->start_date->copy()->startOfDay()->diffInDays($asOf);
        $expectedPeriods = min((int) floor($daysSinceStart / $interval), $maxPeriods);
        $pending = $expectedPeriods - $investment->profit_periods_paid;

        if ($pending <= 0) {
            return false;
        }

        $profit = $this->periodProfit($investment) * $pending;

        $investment->accrued_profit = (float) $investment->accrued_profit + $profit;
        $investment->profit_periods_paid += $pending;
        $investment->last_profit_at = $asOf->toDateString();
        $investment->save();

        return true;
    }

    protected function matureInvestment(UserInvestment $investment, array &$stats): void
    {
        if ($investment->status !== 'active') {
            return;
        }

        // Ensure any missed accruals are applied before payout.
        $remaining = $this->maxProfitPeriods($investment) - $investment->profit_periods_paid;

        if ($remaining > 0) {
            $profit = $this->periodProfit($investment) * $remaining;
            $investment->accrued_profit = (float) $investment->accrued_profit + $profit;
            $investment->profit_periods_paid += $remaining;
            $investment->save();
        }

        $user = $investment->user()->lockForUpdate()->first();
        $principal = (float) $investment->final_amount;
        $profit = (float) $investment->accrued_profit;
        $totalPayout = $principal + $profit;

        if ($principal > 0) {
            $this->wallet->credit(
                $user,
                $principal,
                'adjustment',
                $investment,
                "Investment matured – principal returned ({$investment->plan_name})"
            );
        }

        if ($profit > 0) {
            $this->wallet->credit(
                $user,
                $profit,
                'profit',
                $investment,
                "Investment matured – profit paid ({$investment->plan_name})"
            );
        }

        $investment->update([
            'status'     => 'matured',
            'matured_at' => now(),
        ]);

        $user->notify(new InvestmentMatured($investment, $principal, $profit, $totalPayout));

        $stats['matured']++;
    }

    protected function periodProfit(UserInvestment $investment): float
    {
        return round((float) $investment->final_amount * (float) $investment->roi_percentage / 100, 2);
    }

    protected function maxProfitPeriods(UserInvestment $investment): int
    {
        $interval = $this->roiIntervalDays($investment->roi_period);

        if ($interval <= 0 || $investment->duration_days <= 0) {
            return 0;
        }

        return (int) floor($investment->duration_days / $interval);
    }

    protected function roiIntervalDays(string $period): int
    {
        return match ($period) {
            'Weekly'  => 7,
            'Monthly' => 30,
            default   => 1,
        };
    }
}
