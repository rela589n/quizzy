<?php

namespace App\Policies;

use App\Models\Administrator;
use App\Models\Test;
use Illuminate\Auth\Access\HandlesAuthorization;

class TestPolicy
{
    use HandlesAuthorization;

    public function create(Administrator $administrator): bool
    {
        return $administrator->can('create-tests');
    }

    public function viewAny(Administrator $administrator): bool
    {
        return $administrator->can('view-tests');
    }

    public function viewAll(Administrator $administrator): bool
    {
        return $administrator->can('view-all-tests');
    }

    public function view(Administrator $user, Test $test): bool
    {
        return $this->viewAll($user)
            || ($user->can('view-tests')
                && $test->isAvailableToAdmin($user));
    }

    public function update(Administrator $user, Test $test): bool
    {
        return $user->can('update-all-tests')
            || ($user->can('update-tests')
                && $test->isAvailableToAdmin($user));
    }

    public function delete(Administrator $user, Test $test): bool
    {
        return $user->can('delete-all-tests')
            || ($user->can('delete-tests')
                && $test->isAvailableToAdmin($user));
    }
}
