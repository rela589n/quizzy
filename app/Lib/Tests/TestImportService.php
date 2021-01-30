<?php

declare(strict_types=1);


namespace App\Lib\Tests;

use App\Lib\Parsers\TestParser;
use App\Models\Question;
use App\Models\Test;

final class TestImportService
{
    private Test $test;

    public function __construct(Test $test)
    {
        $this->test = $test;
    }

    public function import(TestParser $parser): void
    {
        $parser->parse();

        $parsed = $parser->getParsedQuestions();
        foreach ($parsed as $questionInfo) {
            /**
             * @var Question $question
             */
            $question = $this->test->nativeQuestions()
                ->create(
                    [
                        'question' => $questionInfo['question']
                    ]
                );

            $question->answerOptions()
                ->createMany($questionInfo['insert_options']);
        }

        $this->test->unsetRelation('nativeQuestions');
    }
}
