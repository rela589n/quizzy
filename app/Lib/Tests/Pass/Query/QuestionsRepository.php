<?php

declare(strict_types=1);

namespace App\Lib\Tests\Pass\Query;

use App\Models\Question;
use App\Models\Test;
use App\Models\TestComposite;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Relation;
use JetBrains\PhpStorm\Immutable;
use RuntimeException;

#[Immutable]
final class QuestionsRepository
{
    public function readTestQuestionsCount(Test $test): int
    {
        return $test->testComposites
            ->map(
                fn(TestComposite $composite) => $composite->questions()->select('questions.id')->limit(
                    $composite->questions_quantity
                )->count()
            )->sum();
    }

    private function questionsWithoutanswers(Test $test)
    {
        return Collection::make(
            $test->testComposites->map(
                fn(TestComposite $composite) => $this->retrieveCompositeQuestions($test, $composite)
            )->flatten()
        );
    }

    public function readTestQuestions(Test $test)
    {
        $questions = $this->questionsWithoutanswers($test);

        $questions->load(
            [
                'answerOptions' => static function (Relation $q) use ($test) {
                    if (Test::ANSWER_OPTION_ORDER_RANDOM === $test->answer_options_order) {
                        $q->inRandomOrder();
                    } elseif (Test::ANSWER_OPTION_ORDER_SERIATIM === $test->answer_options_order) {
                        $q->orderBy('id');
                    } else {
                        throw new RuntimeException(
                            "Unknown answer_options_order: $test->answer_options_order for test $test->id"
                        );
                    }
                }
            ]
        );

        return $questions;
    }

    private function retrieveCompositeQuestions(Test $test, TestComposite $composite)
    {
        /** @var \Illuminate\Database\Eloquent\Builder|Question $builder */
        $builder = $composite->questions();

        if (Test::QUESTION_ORDER_RANDOM === $test->questions_order) {
            $builder->inRandomOrder();
        } elseif (Test::QUESTION_ORDER_SERIATIM === $test->questions_order) {
            $builder->ordered();
        } else {
            throw new RuntimeException("Unknown questions_order: $test->questions_order");
        }

        return $builder->limit($composite->questions_quantity)->get();
    }
}
