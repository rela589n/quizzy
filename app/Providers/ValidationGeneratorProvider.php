<?php

namespace App\Providers;

use App\Lib\ValidationGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class ValidationGeneratorProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ValidationGenerator::class, function ($app) {
            return new ValidationGenerator(resolve(Request::class));
        });
    }
}
