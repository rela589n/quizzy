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
    public function register(): void
    {
        $this->app->singleton(
            RequestUrlManager::class,
            static function () {
                return new RequestUrlManager(resolve(Request::class));
            }
        );
    }
}
