<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\AnswerOption;
use App\Models\AskedQuestion;
use App\Models\Question;

final class QuestionObserver
{
    /**
     * Handle the question "deleted" event.
     *
     * @param  Question  $question
     */
    public function deleted(Question $question)
    {
        $question->answerOptions()->delete();
    }

    /**
     * Handle the question "restored" event.
     *
     * @param  Question  $question
     */
    public function restored(Question $question)
    {
        $question->answerOptions()->withTrashed()->get()->map(static fn(AnswerOption $option) => $option->restore());
    }

    /**
     * Handle the question "force deleted" event.
     *
     * @param  Question  $question
     */
    public function forceDeleted(Question $question)
    {
        $question->answerOptions()->forceDelete();

        AskedQuestion::query()
            ->where('question_id', $question->id)
            ->get()
            ->map(static fn(AskedQuestion $askedQuestion) => $askedQuestion->forceDelete());
    }
}
