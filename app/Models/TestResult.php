<?php

namespace App\Models;

use App\Lib\Filters\TestResultFilter;
use App\Lib\TestResultsEvaluator;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TestResult
 *
 * @property int $id
 * @property int|null $test_id
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property-read \App\Models\Test|null $test
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestResult newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestResult newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestResult query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestResult whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestResult whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestResult whereTestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestResult whereUserId($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AskedQuestion[] $askedQuestions
 * @property-read int|null $asked_questions_count
 * @property-read \App\Models\User|null $user
 * @property-read mixed $date_readable
 * @property-read mixed $mark
 * @property-read mixed $mark_readable
 * @property-read mixed $score
 * @property-read mixed $score_readable
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestResult filtered(\App\Lib\Filters\TestResultFilter $filters)
 */
class TestResult extends Model
{
    public const UPDATED_AT = null;

    /**
     * @var TestResultsEvaluator
     */
    protected $resultsEvaluator;
    protected $resultScore = null;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->resultsEvaluator = new TestResultsEvaluator($this);
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
        if ($this->resultScore === null) {
            $evaluatedQuestions = $this->resultsEvaluator->evaluateEachQuestion();
            $eachQuestionScore = $this->resultsEvaluator->evaluateWholeTest($evaluatedQuestions);

            $this->resultScore = $this->resultsEvaluator->evaluateTestScore($eachQuestionScore);
        }

        return $this->resultScore;
    }

    public function getScoreReadableAttribute()
    {
        return round(100 * $this->score, 2);
    }

    public function getMarkAttribute()
    {
        return $this->resultsEvaluator->putMark($this->score);
    }

    public function getMarkReadableAttribute()
    {
        // todo create class wrapper under this function
        $mark = $this->mark;
        return $mark . declineCyrillicWord($mark, ' бал', ['', 'а', 'ів']);
    }

    public function getDateReadableAttribute()
    {
        return $this->created_at->format('d.m.Y H:i');
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param TestResultFilter $filters
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function scopeFiltered($query, TestResultFilter $filters)
    {
        $response = $filters->applyQueryFilters($query)->get();

        return $filters->apply($response);
    }
}
