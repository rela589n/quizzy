<?php

declare(strict_types=1);


namespace App\Lib\Tests\Pass\Exceptions;

use App\Models\TestResult;

final class QuestionsRanOutException extends \RuntimeException
{
    private TestResult $testResult;

    public function __construct(TestResult $testResult)
    {
        parent::__construct('Questions list has ran out');
        $this->testResult = $testResult;
    }

    public function getTestResult(): TestResult
    {
        return $this->testResult;
    }
}
