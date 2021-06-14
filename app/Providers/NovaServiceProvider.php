<?php

namespace App\Providers;

use App\Nova\Administrator;
use App\Nova\Configuration;
use App\Nova\Customization\LoginController;
use App\Nova\Customization\PasswordResetController;
use App\Nova\Department;
use App\Nova\Exceptions\Handler;
use App\Nova\Metrics\TestsCount;
use App\Nova\Metrics\UsersCount;
use App\Nova\Resource;
use App\Nova\Student;
use App\Nova\StudentGroup;
use App\Nova\Test;
use App\Nova\TestSubject;
use App\Observers\TestObserver;
use DigitalCreative\CollapsibleResourceManager\CollapsibleResourceManager;
use DigitalCreative\CollapsibleResourceManager\Resources\TopLevelResource;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Exceptions\NovaExceptionHandler;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Mastani\NovaPasswordReset\NovaPasswordReset;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    protected function registerExceptionHandler()
    {
        parent::registerExceptionHandler();

        $this->app->bind(NovaExceptionHandler::class, Handler::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::serving(
            function () {
                \App\Models\Test::observe(TestObserver::class);
            }
        );
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->withPasswordResetRoutes()
            ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define(
            'viewNova',
            fn($user) => $user instanceof \App\Models\Administrator
        );
    }

    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
            new UsersCount(),
            new TestsCount(),
//            new Help,
        ];
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            new CollapsibleResourceManager(
                [
                    'navigation' => [
                        TopLevelResource::make(
                            [
                                'label'     => 'Студенти',
                                'resources' => [
                                    Department::class,
                                    StudentGroup::class,
                                    Student::class,
                                ],
                            ],
                        ),
                        TopLevelResource::make(
                            [
                                'label'     => 'Тестування',
                                'resources' => [
                                    TestSubject::class,
                                    Test::class,
                                ],
                            ],
                        ),
                        TopLevelResource::make(
                            [
                                'label'     => 'Адміністратори',
                                'resources' => [
                                    Administrator::class,
                                ],
                            ],
                        ),
                        TopLevelResource::make(
                            [
                                'label' => 'Налаштування',
                                'resources' => [
                                    Configuration::class,
                                ],
                            ]
                        ),
                    ]
                ]
            ),
            (new NovaPasswordReset()),
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        Nova::sortResourcesBy(
            function ($resource) {
                /** @var string|Resource */
                return $resource::$groupPriority ?? 99999;
            }
        );

        $this->app->bind(\Laravel\Nova\Http\Controllers\LoginController::class, LoginController::class);
        $this->app->bind(
            \Mastani\NovaPasswordReset\Http\Controllers\PasswordResetController::class,
            PasswordResetController::class
        );
    }
}
