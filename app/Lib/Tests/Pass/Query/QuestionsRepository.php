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
                'answerOptions' => static function (Relation $q) {
                    $q->inRandomOrder();
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
            throw new RuntimeException('Unknown question sort order');
        }

        return $builder->limit($composite->questions_quantity)->get();
    }
}
