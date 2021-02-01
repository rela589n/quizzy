<?php

declare(strict_types=1);


namespace App\Lib\Tests\Pass;

use App\Lib\Tests\Pass\Exceptions\QuestionsRanOutException;
use App\Models\Question;
use App\Models\Test;
use App\Models\TestResult;
use App\Models\User;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\ConnectionInterface as Connection;
use Illuminate\Database\Eloquent\Collection;

final class PassTestService
{
    private UserTestPassageReadStorage $storage;
    private Test $test;
    private User $user;
    private Connection $connection;

    public function __construct(User $user, Test $test)
    {
        $this->storage = new UserTestPassageReadStorage($user, $test);
        $this->test = $test;
        $this->user = $user;
        $this->connection = app()->make(Connection::class);
        app()->make(Gate::class)
            ->forUser($user)
            ->authorize('pass-test', $test);
    }

    public function remainingTime(): int
    {
        return ($this->test->time * 60) - $this->elapsedTime();
    }

    private function elapsedTime(): int
    {
        return $this->storage->passageStartedAt()->diffInSeconds(now());
    }

    /** @return Collection|Question[] */
    public function getAllQuestions(): Collection
    {
        return $this->storage->questions();
    }

    public function shiftOffset(): void
    {
        $this->storage->nextOffset();
    }

    public function currentQuestion(): Question
    {
        $questions = $this->getAllQuestions();
        $offset = $this->currentQuestionIndex();

        if (!$questions->offsetExists($offset)) {
            $testResult = $this->finishTest($this->storage->testResult());

            $this->storage->flush();

            throw new QuestionsRanOutException($testResult);
        }

        return $questions->offsetGet($offset);
    }

    public function currentQuestionIndex(): int
    {
        return $this->storage->currentOffset();
    }

    public function cancelPassage(): void
    {
        $this->storage->flush();
    }

    public function addQuestionResponse(AskedQuestionDto $dto): void
    {
        $resultDto = $this->storage->testResult();

        $askedQuestions = $resultDto->getAskedQuestions();
        $askedQuestions->push($dto);

        $this->storage->rewriteTestResult(TestResultDto::create($askedQuestions));
    }

    public function finishTest(TestResultDto $dto): TestResult
    {
        $testResult = $this->connection->transaction(fn() => $this->persistTestResult($dto));

        $this->storage->flush();

        return $testResult;
    }

    private function persistTestResult(TestResultDto $dto): TestResult
    {
        $testResult = new TestResult();
        $testResult->test()->associate($this->test);
        $testResult->user()->associate($this->user);
        $testResult->save();

        $askedQuestionsCollection = $dto->getAskedQuestions()->map(
            function (AskedQuestionDto $askedQuestionDto) use ($testResult) {
                $askedQuestion = $askedQuestionDto->mapToModel();
                $testResult->askedQuestions()->save($askedQuestion);

                $answersCollection = $askedQuestionDto->getAnswers()->map(
                    function (AnswerDto $dto) use ($askedQuestion) {
                        $answer = $dto->mapToModel();
                        $askedQuestion->answers()->save($answer);

                        return $answer;
                    }
                );

                $askedQuestion->setRelation('answers', Collection::make($answersCollection));

                return $askedQuestion;
            }
        );

        $testResult->setRelation('askedQuestions', Collection::make($askedQuestionsCollection));

        return $testResult;
    }
}
