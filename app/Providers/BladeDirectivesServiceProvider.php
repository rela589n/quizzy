<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class BladeDirectivesServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('ifroute', function($routeName) {
            return Str::startsWith(\Route::currentRouteName(), $routeName);
        });
    }
}
