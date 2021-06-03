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
    public function notCorrectOfResult(TestResult $testResult)
    {
        $testId = $testResult->test_id;
        $resultId = $testResult->id;

        $this->whereRaw(
            <<<SQL
                questions.test_id = $testId
                  and questions.id not in
                      (select distinct questions.id
                       from questions
                                inner join asked_questions on asked_questions.test_result_id = $resultId
                           and questions.id = asked_questions.question_id
                                inner join answers on asked_questions.id = answers.asked_question_id
                                inner join answer_options
                                           on answers.answer_option_id = answer_options.id
                                               and answers.is_chosen = answer_options.is_right)
            SQL
        );
    }
}
