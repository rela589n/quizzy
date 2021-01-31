<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Administrator;
use App\Models\TestResult;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class TestResultPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the test result.
     *
     * @param  User|Administrator  $user
     * @param  TestResult  $testResult
     * @return bool
     */
    public function view( $user, TestResult $testResult)
    {
        if ($user instanceof User) {
            return $testResult->user_id === $user->id;
        }
    }
}
