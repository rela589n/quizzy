<?php

declare(strict_types=1);


namespace App\Nova\Customization;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Nova;

final class LoginController extends \Laravel\Nova\Http\Controllers\LoginController
{
    protected function authenticated(Request $request, $user)
    {
        if (false === $user->password_changed) {
            return redirect()->to(RouteServiceProvider::novaChangePasswordUrl());
        }
    }
}
