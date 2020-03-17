<?php

namespace App\Observers;

use App\Lib\TestResultsEvaluator;
use App\Lib\Words\WordsManager;
use App\Models\TestResult;

class TestResultObserver
{
    private function setTestResultDependencies(TestResult $result)
    {
        $result->setResultsEvaluator(resolve(TestResultsEvaluator::class));
        $result->setWordsManager(resolve(WordsManager::class));
    }

    public function retrieved(TestResult $testResult)
    {
        $this->setTestResultDependencies($testResult);
    }

    public function saved(TestResult $testResult)
    {
        $this->setTestResultDependencies($testResult);
    }
}
