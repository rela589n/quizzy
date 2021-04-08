<?php

declare(strict_types=1);


namespace App\Lib\Tests;

use App\Lib\Parsers\TestParser;
use App\Lib\Parsers\TestParserFactory;
use App\Models\Question;
use App\Models\Test;
use Illuminate\Http\UploadedFile;

final class TestImportService
{
    private Test $test;
    private TestParserFactory $factory;

    public function __construct(Test $test)
    {
        $this->test = $test;
        $this->factory = app()->make(TestParserFactory::class);
    }

    public function importFile(UploadedFile $file)
    {
        $this->import($this->factory->getTextParser($file));
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
