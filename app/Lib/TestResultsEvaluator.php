<?php


namespace App\Lib;


use App\Exceptions\NullPointerException;
use App\Factories\MarkEvaluatorsFactory;
use App\Lib\TestResults\MarkEvaluator;
use App\Lib\TestResults\ScoreEvaluatorInterface;
use App\Models\TestResult;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * Class TestResultsEvaluator
 * @package App\Lib
 *
 * @deprecated use stored function instead
 */
class TestResultsEvaluator
{
    protected TestResult $testResult;
    protected ScoreEvaluatorInterface $scoreEvaluator;
    protected MarkEvaluatorsFactory $markEvaluatorsFactory;
    private ?MarkEvaluator $markEvaluator = null;

    protected ?array $evaluatedQuestions = null;
    protected ?array $questionsScore = null;
    protected ?float $testScore = null;

    /**
     * TestResultsEvaluator constructor.
     * @param  ScoreEvaluatorInterface  $scoreEvaluator
     * @param  MarkEvaluatorsFactory  $markEvaluatorsFactory
     */
    public function __construct(
        ScoreEvaluatorInterface $scoreEvaluator,
        MarkEvaluatorsFactory $markEvaluatorsFactory
    ) {
        $this->scoreEvaluator = $scoreEvaluator;
        $this->markEvaluatorsFactory = $markEvaluatorsFactory;
    }

    /**
     * @param  TestResult  $testResult
     */
    public function setTestResult(TestResult $testResult): void
    {
        $this->testResult = $testResult;
    }

    /**
     * @return MarkEvaluator
     * @throws BindingResolutionException
     */
    protected function markEvaluator(): MarkEvaluator
    {
        return singleVar(
            $this->markEvaluator,
            function () {
                return $this->markEvaluatorsFactory
                    ->setTest($this->testResult->test)
                    ->resolve();
            }
        );
    }

    protected function loadDependencies(): void
    {
        $this->testResult->askedQuestions->loadMissing(
            [
                'question' => static function (Relation $query) {
                    $query->withTrashed();
                }
            ]
        );

        $this->testResult->askedQuestions->loadMissing(
            [
                'answers.answerOption' => static function (Relation $query) {
                    $query->withTrashed();
                }
            ]
        );
    }

    /**
     * @return array [<br>
     *   questionId => [answeredRight, asked]<br>
     * ]
     * @throws NullPointerException
     */
    public function evaluateEachQuestion(): array
    {
        if ($this->testResult === null) {
            throw new NullPointerException(
                "Property testResult must be set before calling ".__FUNCTION__.'. Try setTestResult().'
            );
        }

        if (!is_null($this->evaluatedQuestions)) {
            return $this->evaluatedQuestions;
        }

        $this->loadDependencies();

        $result = [];
        foreach ($this->testResult->askedQuestions as $askedQuestion) {
            $questionId = $askedQuestion->question->id;

            if (empty($result[$questionId])) {
                $result[$questionId] = [0, 0]; // [right, all]
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
    public function getQuestionsScore(): array
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
     * @throws NullPointerException|BindingResolutionException
     */
    public function getMark(): ?int
    {
        return $this->markEvaluator()->putMark($this->getTestScore() * 100);
    }
}
