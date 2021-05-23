<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

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
 * @property string $type
 * @method static \App\Models\Query\CustomEloquentBuilder|Question whereType($value)
 */
class Question extends Model implements Sortable
{
    use SortableTrait;

    public array $sortable = [
        'order_column_name' => 'sort_order',
        'sort_on_has_many' => true,
    ];

    use SoftDeletes;
    public $timestamps = false;
    public $fillable = ['question', 'type', 'test_id'];

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
