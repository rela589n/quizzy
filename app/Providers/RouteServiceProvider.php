<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';
    protected $adminNamespace = 'App\Http\Controllers\Admin';
    protected $clientNamespace = 'App\Http\Controllers\Client';

    /**
     * The path to the "home" route for your application depending on guard.
     *
     * @var string
     */
    public const HOME = '/';

    public static function getHomeUrl($guardName)
    {
        // todo create AdminRouteHandler and ClientRouteHandler and use polymorphism
        switch ($guardName) {
            case 'admin':
                return route('admin.dashboard');
            default:
                return route('client.dashboard');
        }
    }

    public static function getLoginUrl($guardName)
    {
        switch ($guardName) {
            case 'admin':
                return route('admin.login');
            default:
                return route('client.login');
        }
    }
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        Route::pattern('id', '[0-9]+');
        Route::pattern('name', '[a-zA-Z0-9_-]+');

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapAdminRoutes();

        $this->mapClientRoutes();
        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }

    /**
     * Define the "admin" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {
        Route::prefix('admin')
            ->middleware('web')
            ->namespace($this->adminNamespace)
            ->name('admin')
            ->group(base_path('routes/admin.php'));
    }

    /**
     * Define the "client" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapClientRoutes()
    {
        Route::middleware('web')
            ->namespace($this->clientNamespace)
            ->name('client')
            ->group(base_path('routes/client.php'));
    }
}
