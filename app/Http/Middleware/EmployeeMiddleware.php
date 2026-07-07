<?php

namespace SGpayroll\Http\Middleware;

use Closure;

class EmployeeMiddleware
{
    /**
     * Handle an incoming request.
     * Only allows users with user_type = 2 (Employee) to proceed.
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->user_type != 2) {
            abort(403, 'Unauthorized. Employee portal access required.');
        }

        return $next($request);
    }
}
