<?php

namespace App\Providers;

use App\Http\Requests\RequestUrlManager;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class RequestManagerProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(RequestUrlManager::class, function ($app) {
            return new RequestUrlManager(resolve(Request::class));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
