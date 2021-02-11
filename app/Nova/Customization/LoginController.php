<?php

declare(strict_types=1);


namespace App\Nova\Customization;

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Nova;

final class LoginController extends \Laravel\Nova\Http\Controllers\LoginController
{
    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath(): string
    {
        if (!Auth::guard(config('nova.guard'))->user()->password_changed) {
            return RouteServiceProvider::novaChangePasswordUrl();
        }

        return Nova::path();
    }
}
