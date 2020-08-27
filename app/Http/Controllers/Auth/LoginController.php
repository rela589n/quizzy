<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

    /**
     * Name of currently used guard
     * @var string
     */
    protected string $guardName;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @param  string  $guardName
     */
    public function __construct($guardName)
    {
        $this->guardName = $guardName;

        $this->middleware(sprintf('guest:%s', $guardName))
            ->except(['logout']);

        $routeName = $guardName.'.dashboard';
        $this->redirectTo = Route::has($routeName) ? route($routeName) : '/';
    }

    public function showLoginForm()
    {
        return view(sprintf('pages.%s.auth', $this->guardName));
    }

    /**
     * @param  Request  $request
     * @param  Authenticatable  $user
     * @return mixed|void
     */
    protected function authenticated(Request $request, $user)
    {
        if (!$user->password_changed) {
            return redirect()->route($this->changePasswordRoute());
        }
    }

    protected function changePasswordRoute()
    {
        return sprintf('%s.change-password', $this->guardName);
    }

    protected function loggedOut(Request $request)
    {
        return redirect()->route(sprintf('%s.login', $this->guardName));
    }

    protected function guard()
    {
        return \Auth::guard($this->guardName);
    }
}
