<?php

namespace App\Providers;

use App\Models\Administrator;
use App\Models\StudentGroup;
use App\Models\Test;
use App\Models\TestSubject;
use App\Models\User;
use App\Policies\GroupPolicy;
use App\Policies\StudentPolicy;
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
        StudentGroup::class => GroupPolicy::class,
        User::class => StudentPolicy::class,
        // 'App\Model' => 'App\Policies\ModelPolicy',
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

        $this->registerAdministratorGates();

        $this->registerSubjectGates();

        $this->registerTestGates();
    }

    protected function registerAdministratorGates()
    {
        Gate::define('update-administrator', function (Administrator $user, Administrator $admin) {
            return $user->can('update-administrators');
        });

        Gate::define('delete-administrator', function (Administrator $user, Administrator $admin) {
            return $user->can('delete-administrators');
        });
    }

    protected function registerSubjectGates()
    {
        Gate::define('update-subject', function (Administrator $user, TestSubject $subject) {
            return $user->can('update-subjects');
        });

        Gate::define('delete-subject', function (Administrator $user, TestSubject $subject) {
            return $user->can('delete-subjects');
        });
    }

    protected function registerTestGates()
    {
        Gate::define('update-test', function (Administrator $user, Test $test) {
            return $user->can('update-tests');
        });

        Gate::define('delete-test', function (Administrator $user, Test $test) {
            return $user->can('delete-tests');
        });
    }
}
