<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Question;
use App\Models\Administrator;
use Illuminate\Auth\Access\HandlesAuthorization;

final class QuestionsPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can view any questions.
     *
     * @param  Administrator  $user
     * @return bool
     */
    public function viewAny(Administrator $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the question.
     *
     * @param  Administrator  $user
     * @param  Question  $question
     * @return bool
     */
    public function view(Administrator $user, Question $question)
    {
        return true;
    }

    /**
     * Determine whether the user can create questions.
     *
     * @param  Administrator  $user
     * @return bool
     */
    public function create(Administrator $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the question.
     *
     * @param  Administrator  $user
     * @param  Question  $question
     * @return bool
     */
    public function update(Administrator $user, Question $question)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the question.
     *
     * @param  Administrator  $user
     * @param  Question  $question
     * @return bool
     */
    public function delete(Administrator $user, Question $question)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the question.
     *
     * @param  Administrator  $user
     * @param  Question  $question
     * @return bool
     */
    public function restore(Administrator $user, Question $question)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the question.
     *
     * @param  Administrator  $user
     * @param  Question  $question
     * @return bool
     */
    public function forceDelete(Administrator $user, Question $question)
    {
        return true;
    }
}
