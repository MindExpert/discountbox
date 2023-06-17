<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ExpectsJson
{
    public function handle(Request $request, Closure $next)
    {
        if (! app()->environment('production')) {
            return $next($request);
        }

        if (! $request->expectsJson()) {
            abort(404);
        }

        return $next($request);
    }
}
