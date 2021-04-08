<?php

declare(strict_types=1);


namespace App\Models\AskedQuestions;

use App\Models\Answer;
use App\Models\AskedQuestion;
use App\Models\Query\CustomEloquentBuilder;

/** @mixin AskedQuestion */
final class AskedQuestionsEloquentBuilder extends CustomEloquentBuilder
{
    public function withRightAnswersCount(): self
    {
        return $this->appendSelectSub(
            Answer::query()
                ->selectRaw('sum(IF(is_chosen = is_right, 1, 0))')
                ->join('answer_options', 'answer_options.id', '=', 'answers.answer_option_id')
                ->whereRaw('answers.asked_question_id = asked_questions.id')
                ->toBase(),
            'right_answers_count'
        );
    }
}
