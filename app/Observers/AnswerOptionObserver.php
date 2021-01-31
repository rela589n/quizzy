<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\AnswerOption;

final class AnswerOptionObserver
{
    /**
     * Handle the answer option "created" event.
     *
     * @param  AnswerOption  $answerOption
     */
    public function created(AnswerOption $answerOption)
    {
        //
    }

    /**
     * Handle the answer option "updated" event.
     *
     * @param  AnswerOption  $answerOption
     */
    public function updated(AnswerOption $answerOption)
    {
        //
    }

    /**
     * Handle the answer option "deleted" event.
     *
     * @param  AnswerOption  $answerOption
     */
    public function deleted(AnswerOption $answerOption)
    {
        //
    }

    /**
     * Handle the answer option "restored" event.
     *
     * @param  AnswerOption  $answerOption
     */
    public function restored(AnswerOption $answerOption)
    {
        //
    }

    /**
     * Handle the answer option "force deleted" event.
     *
     * @param  AnswerOption  $answerOption
     */
    public function forceDeleted(AnswerOption $answerOption)
    {
//        Answer
    }
}
