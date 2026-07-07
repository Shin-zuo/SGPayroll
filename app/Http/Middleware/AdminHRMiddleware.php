<?php

namespace SGpayroll\Http\Middleware;

use Closure;

class AdminHRMiddleware
{
    /**
     * Handle an incoming request.
     * Only allows users with user_type = 1 (HR/Admin) to proceed.
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->user_type != 1) {
            abort(403, 'Unauthorized. Admin/HR access required.');
        }

        return $next($request);
    }
}
