<?php

namespace App\Providers;

use App\Models\StudentGroup;
use App\Models\Test;
use App\Models\TestResult;
use App\Observers\CreatedByObserver;
use App\Observers\StudentGroupObserver;
use App\Observers\TestResultObserver;
use Illuminate\Support\ServiceProvider;

class ModelObserversProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        TestResult::observe(TestResultObserver::class);

        StudentGroup::observe(CreatedByObserver::class);
        Test::observe(CreatedByObserver::class);

        StudentGroup::observe(StudentGroupObserver::class);
    }
}
