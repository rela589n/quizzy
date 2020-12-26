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
        return array_map(
            static function ($pair) use (&$perQuestion) {
                // if count of right == count of all, then $perQuestion, else 0
                return ($pair[0] == $pair[1]) * $perQuestion;
            },
            $evaluatedQuestions
        );
    }
}
