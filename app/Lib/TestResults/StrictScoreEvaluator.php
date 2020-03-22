<?php


namespace App\Lib\TestResults;


class StrictScoreEvaluator implements ScoreEvaluatorInterface
{
    /**
     * @inheritDoc
     */
    public function evaluateTest(array $evaluatedQuestions): array
    {
        $perQuestion = 1. / count($evaluatedQuestions);
        return array_map(function ($pair) use (&$perQuestion) {
            return ($pair[0] == $pair[1]) * $perQuestion;
        }, $evaluatedQuestions);
    }
}