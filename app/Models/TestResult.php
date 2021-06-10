<?php

namespace App\Models;

use App\Factories\MarkEvaluatorsFactory;
use App\Lib\TestResults\MarkEvaluator;
use App\Lib\TestResultsEvaluator;
use App\Lib\Words\WordsManager;
use App\Models\TestResults\TestResultQueryBuilder;
use Eloquent;
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
 * @property-read ?float $result_percents
 * @property-read ?float $result_percents_readable
 * @property-read ?int $result_mark
 * @property-read string $mark_readable
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

    protected MarkEvaluatorsFactory $markEvaluatorFactory;
    protected ?MarkEvaluator $markEvaluator = null;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->markEvaluatorFactory = app(MarkEvaluatorsFactory::class);
    }

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

    private function markEvaluator(): MarkEvaluator
    {
        return singleVar(
            $this->markEvaluator,
            fn() => $this->markEvaluatorFactory->resolve($this->test)
        );
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class)
            ->withTrashed();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function askedQuestions(): HasMany
    {
        return $this->hasMany(AskedQuestion::class);
    }

    public function getResultPercentsAttribute(?float $attr): ?float
    {
        return optional($attr, static fn() => round($attr, 2));
    }

    public function getResultPercentsReadableAttribute(): float
    {
        return round($this->result_percents, 2);
    }

    public function getResultMarkAttribute(): ?int
    {
        return $this->markEvaluator()->putMark($this->result_percents);
    }

    public function getMarkReadableAttribute(): string
    {
        $mark = $this->result_mark;

        if (null === $mark) {
            return '';
        }

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
