<?php

namespace App\Policies;

use App\Models\Administrator;
use App\Models\TestSubject;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the test subject.
     *
     * @param  Administrator  $user
     * @param  TestSubject  $testSubject
     * @return bool
     */
    public function view(Administrator $user, TestSubject $testSubject): bool
    {
        return $user->can('view-subjects');
    }

    /**
     * Determine whether the user can update the test subject.
     *
     * @param  Administrator  $user
     * @param  TestSubject  $testSubject
     * @return bool
     */
    public function update(Administrator $user, TestSubject $testSubject): bool
    {
        return $user->can('update-subjects');
    }

    /**
     * Determine whether the user can delete the test subject.
     *
     * @param  Administrator  $user
     * @param  TestSubject  $testSubject
     * @return bool
     */
    public function delete(Administrator $user, TestSubject $testSubject): bool
    {
        return $user->can('delete-subjects');
    }
}
