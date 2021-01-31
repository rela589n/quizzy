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

    /** @return Collection|Question[] */
    public function questions(): Collection
    {
        return $this->cache->remember(
            "questions:{$this->test->id}:{$this->user->id}",
            $this->storeTestResultInterval(),
            function () {
                $questions = $this->test->allQuestions();
                $questions->loadMissing(
                    [
                        'answerOptions' => static function (Relation $q) {
                            $q->inRandomOrder();
                        }
                    ]
                );

                return $questions;
            }
        );
    }

    public function nextOffset()
    {
        $currentQuestionIndex = 1 + $this->currentOffset();

        $this->cache->set(
            "current-question-index:{$this->test->id}:{$this->user->id}",
            $currentQuestionIndex,
            $this->storeTestResultInterval()
        );

        return $currentQuestionIndex;
    }

    public function currentOffset(): int
    {
        return $this->cache->get("current-question-index:{$this->test->id}:{$this->user->id}", 0);
    }

    public function passageStartedAt(): Carbon
    {
        return $this->cache->remember(
            "pass-started:{$this->test->id}:{$this->user->id}",
            $this->storeTestResultInterval(),
            static fn() => Carbon::now(),
        );
    }

    public function rewriteTestResult(TestResultDto $resultDto): void
    {
        $this->cache->set(
            "pass-test-result:{$this->test->id}:{$this->user->id}",
            $resultDto,
            $this->storeTestResultInterval(),
        );
    }

    public function testResult(): TestResultDto
    {
        return $this->cache->remember(
            "pass-test-result:{$this->test->id}:{$this->user->id}",
            $this->storeTestResultInterval(),
            fn() => TestResultDto::create(collect()),
        );
    }

    private function storeTestResultInterval(): \DateInterval
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
