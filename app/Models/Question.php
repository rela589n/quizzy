<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
 * @property int $sort_order
 * @method static \App\Models\Query\CustomEloquentBuilder|Question ordered(string $direction = 'asc')
 * @method static \App\Models\Query\CustomEloquentBuilder|Question whereSortOrder($value)
 * @property-read Collection|\App\Models\Literature[] $literatures
 * @property-read int|null $literatures_count
 * @method static \App\Models\Query\CustomEloquentBuilder|Question whereLiteratures($value)
 */
class Question extends Model implements Sortable
{
    use SoftDeletes;
    use SortableTrait;

    public array $sortable = [
        'order_column_name' => 'sort_order',
        'sort_on_has_many' => true,
    ];

    public $timestamps = false;
    public $fillable = ['question', 'type', 'test_id'];

    protected $casts = [
        'literatures' => 'array',
    ];

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    /** @return HasMany|AnswerOption */
    public function answerOptions(): HasMany
    {
        return $this->hasMany(AnswerOption::class);
    }

    /** @deprecated */
    public function _literatures(): BelongsToMany
    {
        return $this->belongsToMany(Literature::class);
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
