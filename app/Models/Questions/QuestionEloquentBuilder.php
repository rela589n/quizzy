<?php

declare(strict_types=1);

namespace App\Models\Questions;

use App\Models\Query\CustomEloquentBuilder;
use App\Models\Question;
use App\Models\TestResult;
use JetBrains\PhpStorm\Immutable;

/** @mixin Question */
#[Immutable]
final class QuestionEloquentBuilder extends CustomEloquentBuilder
{
    public function notCorrectOfResult(TestResult $testResult): self
    {
        $testId = $testResult->test_id;
        $resultId = $testResult->id;

        return $this
            ->rightJoin('asked_questions', 'asked_questions.question_id', '=', 'questions.id')
            ->rightJoinSub(
                <<<SQL
                        select answers.asked_question_id,
                               sum(answers.is_chosen = answer_options.is_right) = count(*) as question_right
                        from answers
                                 inner join answer_options on answer_options.id = answers.answer_option_id
                                 inner join asked_questions on asked_questions.id = answers.asked_question_id
                        where asked_questions.test_result_id = $resultId
                        group by answers.asked_question_id
                    SQL,
                'sub',
                'sub.asked_question_id',
                '=',
                'asked_questions.id'
            )->where('questions.test_id', $testId)
            ->where('sub.question_right', '=', false);
    }

    public function whereHasLiteratures(): self
    {
        return $this->whereJsonLength('questions.literatures', '>', 0);
    }
}
