<?php

namespace App\Providers;

use App\Models\Administrator;
use App\Models\StudentGroup;
use App\Models\Test;
use App\Models\TestSubject;
use App\Models\User;
use App\Policies\AdministratorPolicy;
use App\Policies\GroupPolicy;
use App\Policies\StudentPolicy;
use App\Policies\SubjectPolicy;
use App\Policies\TestPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        StudentGroup::class  => GroupPolicy::class,
        User::class          => StudentPolicy::class,
        Administrator::class => AdministratorPolicy::class,
        TestSubject::class   => SubjectPolicy::class,
        Test::class          => TestPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->registerGates();
    }

    protected function registerGates()
    {
        Gate::define('pass-tests-of-subject', function (User $user, TestSubject $subject) {
            return $user->course == $subject->course;
        });

        Gate::define('pass-test', function (User $user, Test $test) {
            return $user->can('pass-tests-of-subject', $test->subject);
        });

        // Implicitly grant "Super Admin" role all permissions
        Gate::after(function ($user, $ability) {
            if ($user instanceof Administrator) {
                return $user->hasRole('super-admin');
            }
        });
    }
}
