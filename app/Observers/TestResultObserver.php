<?php

namespace App\Observers;

use App\Lib\TestResultsEvaluator;
use App\Lib\Words\WordsManager;
use App\Models\TestResult;

class TestResultObserver
{

    /**
     * Handle the test result "retrieved" event.
     *
     * @param  \App\Models\TestResult  $testResult
     * @return void
     */
    public function retrieved(TestResult $testResult)
    {
        $testResult->setResultsEvaluator(resolve(TestResultsEvaluator::class));
        $testResult->setWordsManager(resolve(WordsManager::class));
    }
}
