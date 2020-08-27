<?php

namespace App\Models;

use App\Exceptions\NullPointerException;
use App\Lib\Filters\Eloquent\ResultFilter;
use App\Lib\TestResultsEvaluator;
use App\Lib\Traits\FilteredScope;
use App\Lib\Words\WordsManager;
use Eloquent;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
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
 * @method static Builder|TestResult newModelQuery()
 * @method static Builder|TestResult newQuery()
 * @method static Builder|TestResult query()
 * @method static Builder|TestResult whereCreatedAt($value)
 * @method static Builder|TestResult whereId($value)
 * @method static Builder|TestResult whereTestId($value)
 * @method static Builder|TestResult whereUserId($value)
 * @mixin Eloquent
 * @property-read Collection|AskedQuestion[] $askedQuestions
 * @property-read int|null $asked_questions_count
 * @property-read User|null $user
 * @property-read mixed $date_readable
 * @property-read mixed $mark
 * @property-read mixed $mark_readable
 * @property-read mixed $score
 * @property-read mixed $score_readable
 * @method static Builder|TestResult ofTest($testId)
 * @method static Builder|TestResult recent($count)
 * @method static Builder|TestResult|Collection filtered(ResultFilter $filters)
 */
class TestResult extends Model
{
    use FilteredScope;

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

    /**
     * @param  Builder  $query
     * @param  int | Test  $test
     * @return Builder
     */
    public function scopeOfTest($query, $test): Builder
    {
        $testId = is_numeric($test) ? $test : $test->id;

        return $query->whereHas(
            'test',
            static function (Builder $query) use ($testId) {
                /**
                 * @var Builder|Test $query
                 */

                $query->withTrashed();
                $query->where('id', $testId);
            }
        );
    }

    /**
     * @param  Builder  $query
     * @param $count
     * @return Builder
     */
    public function scopeRecent($query, $count)
    {
        return $query->latest()->limit($count);
    }
}
