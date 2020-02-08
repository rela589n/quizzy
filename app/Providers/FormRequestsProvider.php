<?php

namespace App\Providers;

use App\Http\Requests\Questions\FillAnswersRequest;
use App\Lib\ValidationGenerator;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class FormRequestsProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->extend(FillAnswersRequest::class, function (FillAnswersRequest $service, Application $app) {
            $service->setValidationGenerator($app->make(ValidationGenerator::class));
            return $service;
        });
    }
}
