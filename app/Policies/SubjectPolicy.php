<?php

namespace App\Policies;

use App\Models\TestSubject;
use App\Models\Administrator;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the test subject.
     *
     * @param Administrator $user
     * @param TestSubject $testSubject
     * @return mixed
     */
    public function view(Administrator $user, TestSubject $testSubject)
    {
        return $user->can('view-subjects');
    }

    /**
     * Determine whether the user can update the test subject.
     *
     * @param Administrator $user
     * @param TestSubject $testSubject
     * @return mixed
     */
    public function update(Administrator $user, TestSubject $testSubject)
    {
        return $user->can('update-subjects');
    }

    /**
     * Determine whether the user can delete the test subject.
     *
     * @param Administrator $user
     * @param TestSubject $testSubject
     * @return mixed
     */
    public function delete(Administrator $user, TestSubject $testSubject)
    {
        return $user->can('delete-subjects');
    }
}
