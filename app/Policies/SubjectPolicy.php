<?php

namespace App\Policies;

use App\Models\Administrator;
use App\Models\TestSubject;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubjectPolicy
{
    use HandlesAuthorization;

    public function create(Administrator $administrator): bool
    {
        return $administrator->can('create-subjects');
    }

    public function viewAny(Administrator $administrator): bool
    {
        return $administrator->can('view-subjects');
    }

    public function viewAll(Administrator $administrator): bool
    {
        return $administrator->can('view-all-subjects');
    }

    public function view(Administrator $user, TestSubject $testSubject): bool
    {
        return $this->viewAll($user)
            || ($user->can('view-subjects')
                && $testSubject->isAvailableToAdmin($user));
    }

    public function update(Administrator $user, TestSubject $testSubject): bool
    {
        return $user->can('update-all-subjects')
            || ($user->can('update-subjects')
                && $testSubject->isAvailableToAdmin($user));
    }

    public function delete(Administrator $user, TestSubject $testSubject): bool
    {
        return $user->can('delete-all-subjects')
            || ($testSubject->isAvailableToAdmin($user)
                && ($user->can('delete-subjects')
                    || 0 === $testSubject->tests_count)
            );
    }
}
