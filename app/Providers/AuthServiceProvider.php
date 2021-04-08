<?php

namespace App\Providers;

use App\Models\Administrator;
use App\Models\Department;
use App\Models\Question;
use App\Models\StudentGroup;
use App\Models\Test;
use App\Models\TestResult;
use App\Models\TestSubject;
use App\Models\User;
use App\Policies\AdministratorPolicy;
use App\Policies\DepartmentPolicy;
use App\Policies\GroupPolicy;
use App\Policies\QuestionsPolicy;
use App\Policies\StudentPolicy;
use App\Policies\SubjectPolicy;
use App\Policies\TestPolicy;
use App\Policies\TestResultPolicy;
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
        Department::class    => DepartmentPolicy::class,
        StudentGroup::class  => GroupPolicy::class,
        User::class          => StudentPolicy::class,
        Administrator::class => AdministratorPolicy::class,
        TestSubject::class   => SubjectPolicy::class,
        Test::class          => TestPolicy::class,
        Question::class      => QuestionsPolicy::class,
        TestResult::class    => TestResultPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();

        $this->registerGates();
    }

    protected function registerGates(): void
    {
        Gate::define(
            'pass-tests-of-subject',
            static function (User $user, TestSubject $subject) {
                return in_array($user->course, $subject->courses_numeric) &&
                    in_array($user->studentGroup->department->id, $subject->department_ids);
            }
        );

        Gate::define(
            'pass-test',
            static function (User $user, Test $test) {
                return $user->can('pass-tests-of-subject', $test->subject);
            }
        );

        // Implicitly grant "Super Admin" role all permissions
        Gate::after(
            static function ($user, $ability) {
                if ($user instanceof Administrator) {
                    return $user->hasRole('super-admin');
                }

                return null;
            }
        );
    }
}
