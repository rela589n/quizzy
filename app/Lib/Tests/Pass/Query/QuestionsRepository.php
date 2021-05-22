<?php

declare(strict_types=1);

namespace App\Lib\Tests\Pass\Query;

use App\Models\Question;
use App\Models\Test;
use App\Models\TestComposite;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Relation;
use JetBrains\PhpStorm\Immutable;

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
        /** @var Collection|Question[] $questions */

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
        return $composite->questions()->inRandomOrder()->limit($composite->questions_quantity)->get();
    }
}
