<?php

namespace App\Http\Controllers;

use App\Services\InvestmentProcessor;
use Illuminate\Http\Request;

class CronController extends Controller
{
    /**
     * HTTP endpoint for cPanel / external cron jobs.
     * Example: GET /cron/process-investments?token=YOUR_CRON_SECRET
     */
    public function processInvestments(Request $request, InvestmentProcessor $processor)
    {
        $secret = config('app.cron_secret');

        if (! $secret || ! hash_equals($secret, (string) $request->query('token', ''))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $stats = $processor->process();

        return response()->json([
            'ok'     => empty($stats['errors']),
            'stats'  => $stats,
            'ran_at' => now()->toIso8601String(),
        ]);
    }
}
