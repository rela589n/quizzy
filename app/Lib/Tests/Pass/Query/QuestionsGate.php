<?php

declare(strict_types=1);

namespace App\Lib\Tests\Pass\Query;

use App\Models\Test;
use Illuminate\Database\Eloquent\Relations\Relation;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class QuestionsGate
{
    public function read(Test $test)
    {
        $questions = $test->allQuestions();
        $questions->loadMissing(
            [
                'answerOptions' => static function (Relation $q) {
                    $q->inRandomOrder();
                }
            ]
        );

        return $questions;
    }
}
