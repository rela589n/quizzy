<?php


namespace App\Lib\TestResults;


interface ScoreEvaluatorInterface
{
    /**
     * @param array $evaluatedQuestions [<br>
     *   questionId => [answeredRight, asked]<br>
     * ]
     * @return array [<br>
     *   questionId => score<br>
     * ]
     */
    public function evaluateTest(array $evaluatedQuestions) : array;
}
