<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;

class LoginController extends \App\Http\Controllers\Auth\LoginController
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;

    public function __construct()
    {
        parent::__construct();
        $this->redirectTo = route('client.dashboard');
    }

    public function showLoginForm()
    {
        return view('pages.client.auth');
    }

    protected function loggedOut(Request $request)
    {
        return redirect()->route('client.login');
    }
}
