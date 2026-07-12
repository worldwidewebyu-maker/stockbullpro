<?php

namespace App\Console\Commands;

use App\Services\InvestmentProcessor;
use Illuminate\Console\Command;

class ProcessInvestments extends Command
{
    protected $signature = 'investments:process {--date= : Process as of this date (Y-m-d)}';

    protected $description = 'Accrue investment ROI and mature completed plans';

    public function handle(InvestmentProcessor $processor): int
    {
        $asOf = $this->option('date')
            ? \Carbon\Carbon::parse($this->option('date'))->startOfDay()
            : null;

        $stats = $processor->process($asOf);

        $this->info("Processed: {$stats['processed']}");
        $this->info("Profit accrued: {$stats['profit_accrued']}");
        $this->info("Matured: {$stats['matured']}");

        if (! empty($stats['errors'])) {
            foreach ($stats['errors'] as $error) {
                $this->error("Investment #{$error['investment_id']}: {$error['message']}");
            }

            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
