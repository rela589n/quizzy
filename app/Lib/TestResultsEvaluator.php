<?php


namespace App\Lib;


use App\Exceptions\NullPointerException;
use App\Lib\TestResults\MarkEvaluator;
use App\Lib\TestResults\ScoreEvaluatorInterface;
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
     * @var ScoreEvaluatorInterface
     */
    protected $scoreEvaluator;

    /**
     * @var MarkEvaluator
     */
    protected $markEvaluator;

    protected $evaluatedQuestions;
    protected $questionsScore;
    protected $testScore;

    /**
     * TestResultsEvaluator constructor.
     * @param ScoreEvaluatorInterface $scoreEvaluator
     * @param MarkEvaluator $markEvaluator
     */
    public function __construct(ScoreEvaluatorInterface $scoreEvaluator, MarkEvaluator $markEvaluator)
    {
        $this->scoreEvaluator = $scoreEvaluator;
        $this->markEvaluator = $markEvaluator;
    }

    /**
     * @param TestResult $testResult
     */
    public function setTestResult(TestResult $testResult): void
    {
        $this->testResult = $testResult;
    }

    protected function loadDependencies()
    {
        $this->testResult->askedQuestions->loadMissing(['question' => function (Relation $query) {
            $query->withTrashed();
        }]);

        $this->testResult->askedQuestions->loadMissing(['answers.answerOption' => function (Relation $query) {
            $query->withTrashed();
        }]);
    }

    /**
     * @return array [<br>
     *   questionId => [answeredRight, asked]<br>
     * ]
     * @throws NullPointerException
     */
    public function evaluateEachQuestion()
    {
        if ($this->testResult === null) {
            throw new NullPointerException("Property testResult must be set before calling " . __FUNCTION__ . '. Try setTestResult().');
        }

        if (!is_null($this->evaluatedQuestions)) {
            return $this->evaluatedQuestions;
        }

        $this->loadDependencies();

        $result = [];
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

        $this->evaluatedQuestions = &$result;
        return $result;
    }

    /**
     * @return array [<br>
     *   questionId => score<br>
     *  ]
     * @throws NullPointerException
     */
    public function getQuestionsScore()
    {
        if ($this->questionsScore === null) {
            $this->questionsScore = $this->scoreEvaluator->evaluateTest($this->evaluateEachQuestion());
        }

        return $this->questionsScore;
    }

    /**
     * @return float
     * @throws NullPointerException
     */
    public function getTestScore(): float
    {
        if ($this->testScore === null) {
            $this->testScore = array_sum($this->getQuestionsScore());
        }

        return $this->testScore;
    }

    /**
     * @return int
     * @throws NullPointerException
     */
    public function getMark(): int
    {
        return $this->markEvaluator->putMark($this->getTestScore());
    }
}
