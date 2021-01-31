<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\TestResult;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class TestResultPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can view any test results.
     *
     * @param  User  $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the test result.
     *
     * @param  User  $user
     * @param  TestResult  $testResult
     * @return bool
     */
    public function view(User $user, TestResult $testResult)
    {
        return $testResult->user_id === $user->id;
    }

    /**
     * Determine whether the user can create test results.
     *
     * @param  User  $user
     * @return bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the test result.
     *
     * @param  User  $user
     * @param  TestResult  $testResult
     * @return bool
     */
    public function update(User $user, TestResult $testResult)
    {
        //
    }

    /**
     * Determine whether the user can delete the test result.
     *
     * @param  User  $user
     * @param  TestResult  $testResult
     * @return bool
     */
    public function delete(User $user, TestResult $testResult)
    {
        //
    }

    /**
     * Determine whether the user can restore the test result.
     *
     * @param  User  $user
     * @param  TestResult  $testResult
     * @return bool
     */
    public function restore(User $user, TestResult $testResult)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the test result.
     *
     * @param  User  $user
     * @param  TestResult  $testResult
     * @return bool
     */
    public function forceDelete(User $user, TestResult $testResult)
    {
        //
    }
}
