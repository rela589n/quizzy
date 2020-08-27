<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Route;

class BladeDirectivesServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        Blade::if(
            'ifroute',
            static function ($routeName) {
                return Str::startsWith(Route::currentRouteName(), $routeName);
            }
        );
    }
}
