<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

abstract class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $guardName;

    /**
     * Create a new controller instance.
     *
     * @param string $guardName
     */
    public function __construct($guardName = null)
    {
        $this->guardName = $guardName;

        $middleware = 'guest';
        if (!empty($guardName)) {
            $middleware = sprintf('%s:%s', $middleware, $guardName);
        }

        $this->middleware($middleware)->except('logout');
    }

    protected function guard()
    {
        return \Auth::guard($this->guardName);
    }
}
