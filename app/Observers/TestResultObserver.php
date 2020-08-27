<?php

namespace App\Observers;

use App\Lib\TestResultsEvaluator;
use App\Lib\Words\WordsManager;
use App\Models\TestResult;

class TestResultObserver
{
    private function setTestResultDependencies(TestResult $result): void
    {
        $result->setResultsEvaluator(resolve(TestResultsEvaluator::class));
        $result->setWordsManager(resolve(WordsManager::class));
    }

    public function retrieved(TestResult $testResult): void
    {
        $this->setTestResultDependencies($testResult);
    }

    public function saved(TestResult $testResult): void
    {
        $this->setTestResultDependencies($testResult);
    }
}
