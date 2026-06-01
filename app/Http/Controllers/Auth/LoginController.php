<?php

namespace SGpayroll\Http\Controllers\Auth;

use SGpayroll\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    public function redirectTo()
    {
        // Redirect based on user type:
        //   user_type == 1 => Admin/HR portal
        //   otherwise => Employee dashboard
        if (auth()->user()->user_type == 2) {
            return '/portal';
        }else if(auth()->user()->user_type == 1){
            return '/employee';
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
