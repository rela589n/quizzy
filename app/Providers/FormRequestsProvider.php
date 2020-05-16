<?php

namespace App\Providers;

use App\Http\Requests\Auth\AdminChangePasswordRequest;
use App\Http\Requests\Auth\StudentChangePasswordRequest;
use App\Models\Administrator;
use App\Models\User;
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
        $this->app->extend(AdminChangePasswordRequest::class, function (AdminChangePasswordRequest $service, Application $app) {
            $service->setAuthUser($app->make(Administrator::class));
            return $service;
        });

        $this->app->extend(StudentChangePasswordRequest::class, function (StudentChangePasswordRequest $service, Application $app) {
            $service->setAuthUser($app->make(User::class));
            return $service;
        });
    }
}
