<?php

namespace SGpayroll\Http\Middleware;

use Closure;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     * Only allows users with user_type = 0 (Super Admin) to proceed.
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->user_type != 0) {
            abort(403, 'Unauthorized. Super Admin access required.');
        }

        return $next($request);
    }
}
