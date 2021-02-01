<?php

declare(strict_types=1);


namespace App\Lib\Tests\Pass;

use App\Models\Question;
use App\Models\Test;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Cache\Repository as Cache;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Relation;

final class UserTestPassageReadStorage
{
    private Cache $cache;

    private Test $test;
    private User $user;

    public function __construct(User $user, Test $test)
    {
        $this->test = $test;
        $this->user = $user;
        $this->cache = app()->make(Cache::class);
    }

    public function sessionExists(): bool
    {
        return $this->cache->has("pass-started:{$this->test->id}:{$this->user->id}");
    }

    public function initiateSession()
    {
        $this->initiateStartedAt();
        $this->initiateQuestions();
        $this->initiateCurrentOffset();
        $this->initiateTestResult();
    }

    private function initiateStartedAt(): void
    {
        $this->cache->set(
            "pass-started:{$this->test->id}:{$this->user->id}",
             Carbon::now(),
            $this->timeToLive(),
        );
    }

    private function initiateQuestions(): void
    {
        $this->cache->set(
            "questions:{$this->test->id}:{$this->user->id}",
            (function () {
                $questions = $this->test->allQuestions();
                $questions->loadMissing(
                    [
                        'answerOptions' => static function (Relation $q) {
                            $q->inRandomOrder();
                        }
                    ]
                );

                return $questions;
            })(),
            $this->timeToLive(),
        );
    }

    private function initiateCurrentOffset(): void
    {
        $this->cache->set(
            "current-question-index:{$this->test->id}:{$this->user->id}",
            0,
            $this->timeToLive(),
        );
    }

    private function initiateTestResult(): void
    {
        $this->cache->set(
            "pass-test-result:{$this->test->id}:{$this->user->id}",
             TestResultDto::create(collect()),
            $this->timeToLive(),
        );
    }

    /** @return Collection|Question[] */
    public function questions(): Collection
    {
        return $this->cache->get(
            "questions:{$this->test->id}:{$this->user->id}",
        );
    }

    public function nextOffset()
    {
        $currentQuestionIndex = 1 + $this->currentOffset();

        $this->cache->set(
            "current-question-index:{$this->test->id}:{$this->user->id}",
            $currentQuestionIndex,
            $this->timeToLive()
        );

        return $currentQuestionIndex;
    }

    public function currentOffset(): int
    {
        return $this->cache->get("current-question-index:{$this->test->id}:{$this->user->id}");
    }

    public function passageStartedAt(): Carbon
    {
        return $this->cache->get(
            "pass-started:{$this->test->id}:{$this->user->id}",
        );
    }

    public function rewriteTestResult(TestResultDto $resultDto): void
    {
        $this->cache->set(
            "pass-test-result:{$this->test->id}:{$this->user->id}",
            $resultDto,
            $this->timeToLive(),
        );
    }

    public function testResult(): TestResultDto
    {
        return $this->cache->get(
            "pass-test-result:{$this->test->id}:{$this->user->id}",
        );
    }

    private function timeToLive(): \DateInterval
    {
        $minutes = $this->test->time + 1;

        return new \DateInterval("PT{$minutes}M");
    }

    public function flush(): void
    {
        $this->cache->forget("questions:{$this->test->id}:{$this->user->id}");
        $this->cache->forget("current-question-index:{$this->test->id}:{$this->user->id}");
        $this->cache->forget("pass-test-result:{$this->test->id}:{$this->user->id}");
        $this->cache->forget("pass-started:{$this->test->id}:{$this->user->id}");
    }
}
