<?php

namespace App\Providers;

use App\Http\Requests\Auth\AdminChangePasswordRequest;
use App\Http\Requests\Auth\StudentChangePasswordRequest;
use App\Http\Requests\Groups\CreateGroupRequest;
use App\Http\Requests\Groups\UpdateGroupRequest;
use App\Http\Requests\Questions\FillAnswersRequest;
use App\Http\Requests\RequestUrlManager;
use App\Http\Requests\Subjects\UpdateSubjectRequest;
use App\Http\Requests\UrlManageable;
use App\Lib\ValidationGenerator;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class FormRequestsProvider extends ServiceProvider
{
    protected $urlManageable = [
        CreateGroupRequest::class,
        UpdateGroupRequest::class,
        UpdateSubjectRequest::class,
    ];

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

        $this->app->extend(AdminChangePasswordRequest::class, function (AdminChangePasswordRequest $service) {
            $service->setAuthUser(Auth::guard('admin')->user());
            return $service;
        });

        $this->app->extend(StudentChangePasswordRequest::class, function (StudentChangePasswordRequest $service) {
            $service->setAuthUser(Auth::guard('client')->user());
            return $service;
        });

        foreach ($this->urlManageable as $request) {
            $this->app->extend($request, function (UrlManageable $service, Application $app) {
                $service->setUrlManager($app->make(RequestUrlManager::class));
                return $service;
            });
        }
    }
}
