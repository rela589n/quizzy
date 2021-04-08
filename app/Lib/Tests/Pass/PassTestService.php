<?php

declare(strict_types=1);


namespace App\Lib\Tests\Pass;

use App\Lib\Tests\Pass\Exceptions\PassTestSessionDoesntExists;
use App\Lib\Tests\Pass\Exceptions\QuestionsRanOutException;
use App\Lib\Tests\Pass\Exceptions\TimeIsUpException;
use App\Models\AnswerOption;
use App\Models\Question;
use App\Models\Test;
use App\Models\TestResult;
use App\Models\User;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Database\ConnectionInterface as Connection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

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

    public static function startPassage(User $user, Test $test): self
    {
        $service = new self($user, $test);
        $service->startSession();
        return $service;
    }

    public static function continuePassage(User $user, Test $test): self
    {
        $service = new self($user, $test);
        $service->startSessionIfNotExists();
        return $service;
    }

    public static function continueStrict(User $user, Test $currentTest): self
    {
        return new self($user, $currentTest);
    }

    private function startSession(): void
    {
        $this->storage->initiateSession();
    }

    private function startSessionIfNotExists(): void
    {
        if (!$this->storage->sessionExists()) {
            $this->storage->initiateSession();
        }
    }

    public function endSession(): void
    {
        $this->storage->flush();
    }

    public function remainingTime(): int
    {
        return ($this->test->time * 60) - $this->elapsedTime();
    }

    private function elapsedTime(): int
    {
        return $this->storage->passageStartedAt()->diffInSeconds(now());
    }

    /** @return EloquentCollection|Question[] */
    public function getAllQuestions(): EloquentCollection
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
            $testResult = $this->finishTest();

            throw new QuestionsRanOutException($testResult);
        }

        if ($this->timeIsUp()) {
            $testResult = $this->finishTest();

            throw new TimeIsUpException($testResult);
        }

        return $questions->offsetGet($offset);
    }

    public function currentQuestionIndex(): int
    {
        return $this->storage->currentOffset();
    }

    public function addQuestionResponse(AskedQuestionDto $dto): void
    {
        $resultDto = $this->storage->testResult();

        $askedQuestions = $resultDto->getAskedQuestions();
        $askedQuestions->push($dto);

        $this->storage->rewriteTestResult(TestResultDto::create($askedQuestions));

        $this->shiftOffset();
    }

    public function persistTemporaryResult(TestResultDto $dto): void
    {
        $this->makeSureSessionValid();
        $this->storage->rewriteTestResult($dto);
    }

    public function finishTest(): TestResult
    {
        $this->makeSureSessionValid();

        $this->pushEmptyRemainingAnswers();

        $dto = $this->storage->testResult();

        $testResult = $this->connection->transaction(fn() => $this->persistTestResult($dto));

        $this->endSession();

        return $testResult;
    }

    private function makeSureSessionValid(): void
    {
        throw_if(
            !$this->storage->sessionExists(),
            new PassTestSessionDoesntExists($this->test, $this->user)
        );
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

                $askedQuestion->setRelation('answers', EloquentCollection::make($answersCollection));

                return $askedQuestion;
            }
        );

        $testResult->setRelation('askedQuestions', EloquentCollection::make($askedQuestionsCollection));

        return $testResult;
    }

    private function timeIsUp(): bool
    {
        return $this->remainingTime() < 3;
    }

    private function pushEmptyRemainingAnswers(): void
    {
        $notAsked = $this->getNotAskedQuestions();

        $emptyResponses = $notAsked->map(fn(Question $q) => $this->createEmptyAskedQuestionResponse($q));

        $emptyResponses->map(fn(AskedQuestionDto $dto) => $this->addQuestionResponse($dto));
    }

    /** @return EloquentCollection|Question[] */
    private function getNotAskedQuestions(): EloquentCollection
    {
        $dto = $this->storage->testResult();

        $askedIds = $dto->getAskedQuestions()
            ->map(static fn(AskedQuestionDto $a) => $a->getQuestionId())
            ->flip();

        return $this->getAllQuestions()
            ->filter(static fn(Question $question) => !$askedIds->offsetExists($question->id));
    }

    private function createEmptyAskedQuestionResponse(Question $question): AskedQuestionDto
    {
        return AskedQuestionDto::create(
            $question->id,
            $this->createEmptyAnswersDtoCollection($question)
        );
    }

    private function createEmptyAnswersDtoCollection(Question $question): Collection
    {
        return $question->answerOptions->map(
            static fn(AnswerOption $option) => AnswerDto::create($option->id, false)
        );
    }
}
