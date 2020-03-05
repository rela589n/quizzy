<?php


namespace App\Lib;


use App\Models\TestResult;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * Class TestResultsEvaluator
 * @package App\Lib
 */
class TestResultsEvaluator
{
    /**
     * @var TestResult
     */
    protected $testResult;

    /**
     * TestResultsEvaluator constructor.
     * @param TestResult $testResult
     */
    public function __construct(TestResult $testResult)
    {
        $this->testResult = $testResult;
    }

    /**
     *
     * @return array [<br>
     *   questionId => [answeredRight, asked]<br>
     * ]
     */
    public function evaluateEachQuestion()
    {
        $result = [];

        $this->testResult->askedQuestions->loadMissing(['question' => function (Relation $query) {
            $query->withTrashed();
        }]);

        $this->testResult->askedQuestions->loadMissing(['answers.answerOption' => function (Relation $query) {
            $query->withTrashed();
        }]);

        foreach ($this->testResult->askedQuestions as $askedQuestion) {
            $questionId = $askedQuestion->question->id;

            if (empty($result[$questionId])) {
                $result[$questionId] = [0, 0];
            }

            foreach ($askedQuestion->answers as $answer) {
                if ($answer->is_chosen == $answer->answerOption->is_right) {
                    ++$result[$questionId][0];
                }

                ++$result[$questionId][1];
            }
        }

        return $result;
    }

    /**
     * Consider question right if all options are right
     * @param array $evaluatedQuestions [<br>
     *   questionId => [answeredRight, asked]<br>
     *  ]
     * @return array [<br>
     *   questionId => score<br>
     *  ]
     */
    public function evaluateWholeTest(array $evaluatedQuestions) // todo in future may use strategy pattern
    {
        $perQuestion = 1. / count($evaluatedQuestions);
        return array_map(function ($pair) use ($perQuestion) {
            return ($pair[0] == $pair[1]) * $perQuestion;
        }, $evaluatedQuestions);
    }

    /**
     * @param array $evaluatedWholeTest [<br>
     *   questionId => score<br>
     *  ]
     * @return float
     */
    public function evaluateTestScore(array $evaluatedWholeTest): float
    {
        return array_sum($evaluatedWholeTest);
    }

    /**
     * @param float $evaluatedTestScore
     * @return int
     */
    public function putMark(float $evaluatedTestScore): int
    {
        return (int)round($evaluatedTestScore * 5);
    }
}
