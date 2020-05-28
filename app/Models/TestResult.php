<?php

namespace App\Models;

use App\Lib\TestResultsEvaluator;
use App\Lib\Traits\FilteredScope;
use App\Lib\Words\WordsManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TestResult
 *
 * @property int $id
 * @property int|null $test_id
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property-read Test|null $test
 * @method static Builder|TestResult newModelQuery()
 * @method static Builder|TestResult newQuery()
 * @method static Builder|TestResult query()
 * @method static Builder|TestResult whereCreatedAt($value)
 * @method static Builder|TestResult whereId($value)
 * @method static Builder|TestResult whereTestId($value)
 * @method static Builder|TestResult whereUserId($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|AskedQuestion[] $askedQuestions
 * @property-read int|null $asked_questions_count
 * @property-read User|null $user
 * @property-read mixed $date_readable
 * @property-read mixed $mark
 * @property-read mixed $mark_readable
 * @property-read mixed $score
 * @property-read mixed $score_readable
 * @method static Builder|TestResult ofTest($testId)
 * @method static Builder|TestResult recent($count)
 * @method static Builder|TestResult filtered(\App\Lib\Filters\Eloquent\ResultFilter $filters)
 */
class TestResult extends Model
{
    use FilteredScope;

    public const UPDATED_AT = null;

    /**
     * @var TestResultsEvaluator
     */
    protected $resultsEvaluator;

    /**
     * @var WordsManager
     */
    protected $wordsManager;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * @param TestResultsEvaluator $resultsEvaluator
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function setResultsEvaluator(TestResultsEvaluator $resultsEvaluator): void
    {
        $this->resultsEvaluator = $resultsEvaluator;
        $this->resultsEvaluator->setTestResult($this);
    }

    /**
     * @return TestResultsEvaluator
     */
    public function getResultEvaluator()
    {
        return $this->resultsEvaluator;
    }

    /**
     * @param WordsManager $wordsManager
     */
    public function setWordsManager(WordsManager $wordsManager): void
    {
        $this->wordsManager = $wordsManager;
    }

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function askedQuestions()
    {
        return $this->hasMany(AskedQuestion::class);
    }

    /**
     * @return float
     * @throws \App\Exceptions\NullPointerException
     */
    public function getScoreAttribute()
    {
        return $this->resultsEvaluator->getTestScore();
    }

    public function getScoreReadableAttribute()
    {
        return round(100 * $this->score, 2);
    }

    /**
     * @return int
     * @throws \App\Exceptions\NullPointerException
     */
    public function getMarkAttribute()
    {
        return $this->resultsEvaluator->getMark();
    }

    public function getMarkReadableAttribute()
    {
        $mark = $this->mark;
        return $mark . $this->wordsManager->decline($mark, ' бал');
    }

    public function getDateReadableAttribute()
    {
        return $this->created_at->format('d.m.Y H:i');
    }

    /**
     * @param Builder $query
     * @param int | Test $test
     * @return Builder
     */
    public function scopeOfTest($query, $test)
    {
        $testId = is_numeric($test) ? $test : $test->id;

        return $query->whereHas('test', function (Builder $query) use ($testId) {
            /**
             * @var Builder|Test $query
             */

            $query->withTrashed();
            $query->where('id', $testId);
        });
    }

    /**
     * @param Builder $query
     * @param $count
     * @return Builder
     */
    public function scopeRecent($query, $count)
    {
        return $query->latest()->limit($count);
    }
}
