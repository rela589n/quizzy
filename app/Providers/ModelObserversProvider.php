<?php

namespace App\Providers;

use App\Models\TestResult;
use App\Observers\TestResultObserver;
use Illuminate\Support\ServiceProvider;

class ModelObserversProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        TestResult::observe(TestResultObserver::class);
    }
}
