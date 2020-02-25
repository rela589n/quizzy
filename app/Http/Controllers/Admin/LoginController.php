<?php

namespace App\Http\Controllers\Admin;

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
        parent::__construct('admin');
        $this->redirectTo = route('admin.dashboard');
    }

    public function showLoginForm()
    {
        return view('pages.admin.auth');
    }

    protected function loggedOut(Request $request)
    {
        return redirect()->route('admin.login');
    }
}
