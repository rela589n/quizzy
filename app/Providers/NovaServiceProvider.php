<?php

namespace App\Providers;

use App\Nova\Administrator;
use App\Nova\Department;
use App\Nova\Resource;
use App\Nova\Student;
use App\Nova\StudentGroup;
use App\Nova\Test;
use App\Nova\TestSubject;
use App\Observers\TestObserver;
use DigitalCreative\CollapsibleResourceManager\CollapsibleResourceManager;
use DigitalCreative\CollapsibleResourceManager\Resources\TopLevelResource;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
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
            function ($user) {
                return in_array(
                    $user->email,
                    [
                        //
                    ]
                );
            }
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
            new Help,
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
                        )->canSee(fn(NovaRequest $request) => $request->user()->hasRole('super-admin')),
                    ]
                ]
            )
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
    }
}
