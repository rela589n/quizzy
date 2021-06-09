<?php

declare(strict_types=1);


namespace App\Lib\Tests;

use App\Lib\Parsers\TestParser;
use App\Lib\Parsers\TestParserFactory;
use App\Lib\Tests\Exceptions\TestImportError;
use App\Models\Question;
use App\Models\Test;
use Exception;
use Illuminate\Http\UploadedFile;
use Throwable;

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
        try {
            $this->import($this->factory->getTextParser($file));
        } catch (Throwable $e) {
            throw new TestImportError($e);
        }
    }

    public function import(TestParser $parser): void
    {
        $parser->parse();

        foreach ($parser->getParsedQuestions() as $block) {
            /** @var Question $question */
            $question = $this->test->nativeQuestions()
                ->create($block->getQuestion());

            $question->answerOptions()
                ->createMany($block->getAnswerOptions());
        }

        $this->test->unsetRelation('nativeQuestions');
    }
}
