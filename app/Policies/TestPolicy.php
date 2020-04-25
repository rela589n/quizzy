<?php

namespace App\Policies;

use App\Models\Test;
use App\Models\Administrator;
use Illuminate\Auth\Access\HandlesAuthorization;

class TestPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the test.
     *
     * @param Administrator $user
     * @param Test $test
     * @return mixed
     */
    public function view(Administrator $user, Test $test)
    {
        return $test->isOwnedBy($user) || $user->can('view-tests');
    }

    /**
     * Determine whether the user can update the test.
     *
     * @param Administrator $user
     * @param Test $test
     * @return mixed
     */
    public function update(Administrator $user, Test $test)
    {
        return $test->isOwnedBy($user) || $user->can('update-tests');
    }

    /**
     * Determine whether the user can delete the test.
     *
     * @param Administrator $user
     * @param Test $test
     * @return mixed
     */
    public function delete(Administrator $user, Test $test)
    {
        return $test->isOwnedBy($user) || $user->can('delete-tests');
    }
}
