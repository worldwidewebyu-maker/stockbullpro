<?php

namespace App\Http\Controllers;

use Database\Seeders\AdminSeeder;
use Database\Seeders\FaqSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class DeployController extends Controller
{
    /**
     * HTTP endpoint for post-deploy tasks when SSH is unavailable.
     * Called by GitHub Actions after FTP upload.
     * Example: GET /deploy/run?token=YOUR_DEPLOY_SECRET
     */
    public function run(Request $request)
    {
        $secret = config('app.deploy_secret');

        if (! $secret || ! hash_equals($secret, (string) $request->query('token', ''))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $commands = [
            'config:clear'    => fn () => Artisan::call('config:clear'),
            'migrate --force' => fn () => Artisan::call('migrate', ['--force' => true]),
            'storage:link'    => fn () => $this->ensurePublicStorageDirectory(),
            'seed-admin'      => fn () => Artisan::call('db:seed', ['--class' => AdminSeeder::class, '--force' => true]),
            'seed-faqs'       => fn () => Artisan::call('db:seed', ['--class' => FaqSeeder::class, '--force' => true]),
            'config:cache'    => fn () => Artisan::call('config:cache'),
            'view:cache'      => fn () => Artisan::call('view:cache'),
        ];

        $results = [];

        foreach ($commands as $label => $callback) {
            try {
                $callback();
                $results[$label] = 'ok';
            } catch (\Throwable $e) {
                $results[$label] = 'error: ' . $e->getMessage();
            }
        }

        return response()->json([
            'ok'      => ! collect($results)->contains(fn ($r) => str_starts_with($r, 'error:')),
            'results' => $results,
            'ran_at'  => now()->toIso8601String(),
        ]);
    }

    /**
     * Shared hosts often disable exec() and symlink(), and serve the app from public_html.
     * Ensure the web-accessible storage directory exists instead of running storage:link.
     */
    private function ensurePublicStorageDirectory(): void
    {
        $path = config('filesystems.disks.public.root');

        if (is_dir($path)) {
            return;
        }

        if (! mkdir($path, 0755, true) && ! is_dir($path)) {
            throw new \RuntimeException("Unable to create public storage directory: {$path}");
        }
    }
}
