<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailVerifiedIfEnabled
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Setting::isEmailVerificationEnabled()) {
            return $next($request);
        }

        if (! $request->user() || $request->user()->hasVerifiedEmail()) {
            return $next($request);
        }

        return $request->expectsJson()
            ? abort(403, 'Your email address is not verified.')
            : redirect()->route('verification.notice');
    }
}
