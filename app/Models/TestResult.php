<?php

namespace App\Models;

use App\Exceptions\NullPointerException;
use App\Lib\TestResultsEvaluator;
use App\Lib\Traits\FilteredScope;
use App\Lib\Words\WordsManager;
use App\Models\TestResults\TestResultQueryBuilder;
use Eloquent;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\TestResult
 *
 * @property int $id
 * @property int|null $test_id
 * @property int|null $user_id
 * @property Carbon $created_at
 * @property-read Test|null $test
 * @property-read Collection|AskedQuestion[] $askedQuestions
 * @property-read int|null $asked_questions_count
 * @property-read User|null $user
 * @property-read string $date_readable
 * @property-read int $mark
 * @property-read string $mark_readable
 * @property-read mixed $score
 * @property-read string $score_readable
 *
 * @method static TestResultQueryBuilder|TestResult newModelQuery()
 * @method static TestResultQueryBuilder|TestResult newQuery()
 * @method static TestResultQueryBuilder|TestResult query()
 * @method static TestResultQueryBuilder|TestResult whereCreatedAt($value)
 * @method static TestResultQueryBuilder|TestResult whereId($value)
 * @method static TestResultQueryBuilder|TestResult whereTestId($value)
 * @method static TestResultQueryBuilder|TestResult whereUserId($value)
 *
 * @mixin Eloquent
 * @mixin TestResultQueryBuilder
 */
class TestResult extends Model
{
    public const UPDATED_AT = null;

    protected TestResultsEvaluator $resultsEvaluator;
    protected WordsManager $wordsManager;

    /**
     * @param  TestResultsEvaluator  $resultsEvaluator
     */
    public function setResultsEvaluator(TestResultsEvaluator $resultsEvaluator): void
    {
        $this->resultsEvaluator = $resultsEvaluator;
        $this->resultsEvaluator->setTestResult($this);
    }

    public function getResultEvaluator(): TestResultsEvaluator
    {
        return $this->resultsEvaluator;
    }

    /**
     * @param  WordsManager  $wordsManager
     */
    public function setWordsManager(WordsManager $wordsManager): void
    {
        $this->wordsManager = $wordsManager;
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function askedQuestions(): HasMany
    {
        return $this->hasMany(AskedQuestion::class);
    }

    /**
     * @return float
     * @throws NullPointerException
     */
    public function getScoreAttribute(): float
    {
        return $this->resultsEvaluator->getTestScore();
    }

    public function getScoreReadableAttribute(): float
    {
        return round(100 * $this->score, 2);
    }

    /**
     * @return int
     * @throws NullPointerException
     * @throws BindingResolutionException
     */
    public function getMarkAttribute(): int
    {
        return $this->resultsEvaluator->getMark();
    }

    public function getMarkReadableAttribute(): string
    {
        $mark = $this->mark;
        return $mark.$this->wordsManager->decline($mark, ' бал');
    }

    public function getDateReadableAttribute(): string
    {
        return $this->created_at->format('d.m.Y H:i');
    }

    public function newEloquentBuilder($query): TestResultQueryBuilder
    {
        return new TestResultQueryBuilder($query);
    }
}
