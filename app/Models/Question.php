<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Question
 *
 * @property int $id
 * @property string $question
 * @property int $test_id
 * @property-read Collection|AnswerOption[] $answerOptions
 * @property-read int|null $answer_options_count
 * @property-read Test $test
 * @method static Builder|Question newModelQuery()
 * @method static Builder|Question newQuery()
 * @method static Builder|Question query()
 * @method static Builder|Question whereId($value)
 * @method static Builder|Question whereQuestion($value)
 * @method static Builder|Question whereTestId($value)
 * @mixin Eloquent
 * @method static Builder|Question random($limit)
 * @property Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Question onlyTrashed()
 * @method static Builder|Question whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Question withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Question withoutTrashed()
 */
class Question extends Model
{
    use SoftDeletes;
    public $timestamps = false;
    public $fillable = ['question', 'test_id'];

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    /** @return HasMany|AnswerOption */
    public function answerOptions(): HasMany
    {
        return $this->hasMany(AnswerOption::class);
    }

    /**
     * Scope a query to include random <b>$limit</b> questions.
     *
     * @param Builder $query
     * @param int $limit
     * @return Builder
     */
    public function scopeRandom($query, $limit)
    {
        return $query->inRandomOrder()->limit($limit);
    }
}
