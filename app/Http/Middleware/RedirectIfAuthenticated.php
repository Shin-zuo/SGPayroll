<?php

namespace SGpayroll\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
<<<<<<< HEAD
            return redirect('/home');
=======
            // Redirect based on user type
            if (Auth::user()->user_type == 2) {
                return redirect('/portal');
            }
            return redirect('/employee');
>>>>>>> branch1
        }

        return $next($request);
    }
}
