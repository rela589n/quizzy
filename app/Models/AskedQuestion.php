<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\AskedQuestion
 *
 * @property int $id
 * @property int $test_result_id
 * @property int $question_id
 * @property-read Collection|Answer[] $answers
 * @property-read int|null $answers_count
 * @property-read TestResult $testResult
 * @method static Builder|AskedQuestion newModelQuery()
 * @method static Builder|AskedQuestion newQuery()
 * @method static Builder|AskedQuestion query()
 * @method static Builder|AskedQuestion whereId($value)
 * @method static Builder|AskedQuestion whereQuestionId($value)
 * @method static Builder|AskedQuestion whereTestResultId($value)
 * @mixin Eloquent
 * @property-read Question $question
 */
class AskedQuestion extends Model
{
    public $timestamps = false;

    protected $fillable = ['question_id'];

    public function testResult(): BelongsTo
    {
        return $this->belongsTo(TestResult::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
