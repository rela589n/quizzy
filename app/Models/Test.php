<?php

namespace App\Models;

use App\Lib\Traits\OwnerChecks;
use App\Lib\Traits\SlugScope;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int|null $created_by
 * @property string $name
 * @property string $uri_alias
 * @property int $time
 * @property int $test_subject_id
 * @property Carbon|null $deleted_at
 * @property string $mark_evaluator_type
 * @property string $type
 * @property-read Collection|\App\Models\MarkPercent[] $marksPercents
 * @property-read int|null $marks_percents_count
 * @property-read Collection|\App\Models\Question[] $nativeQuestions
 * @property-read int|null $native_questions_count
 * @property-read \App\Models\TestSubject $subject
 * @property-read Collection|\App\Models\TestComposite[] $testComposites
 * @property-read int|null $test_composites_count
 * @property-read Collection|\App\Models\TestResult[] $testResults
 * @property-read int|null $test_results_count
 * @property-read Collection|Test[] $tests
 * @property-read int|null $tests_count
 *
 * @method static \App\Models\Query\CustomEloquentBuilder|Test newModelQuery()
 * @method static \App\Models\Query\CustomEloquentBuilder|Test newQuery()
 * @method static \App\Models\Query\CustomEloquentBuilder|Test query()
 * @method static \App\Models\Query\CustomEloquentBuilder|Test whereCreatedBy($value)
 * @method static \App\Models\Query\CustomEloquentBuilder|Test whereDeletedAt($value)
 * @method static \App\Models\Query\CustomEloquentBuilder|Test whereId($value)
 * @method static \App\Models\Query\CustomEloquentBuilder|Test whereMarkEvaluatorType($value)
 * @method static \App\Models\Query\CustomEloquentBuilder|Test whereName($value)
 * @method static \App\Models\Query\CustomEloquentBuilder|Test whereSlug($slug)
 * @method static \App\Models\Query\CustomEloquentBuilder|Test whereTestSubjectId($value)
 * @method static \App\Models\Query\CustomEloquentBuilder|Test whereTime($value)
 * @method static \App\Models\Query\CustomEloquentBuilder|Test whereType($value)
 * @method static \App\Models\Query\CustomEloquentBuilder|Test whereUriAlias($value)
 * @method static \Illuminate\Database\Query\Builder|Test withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Test withoutTrashed()
 * @method static \Illuminate\Database\Query\Builder|Test onlyTrashed()
 *
 * @mixin Eloquent
 */
class Test extends Model
{
    use SoftDeletes;
    use SlugScope;
    use OwnerChecks;

    public const TYPE_STANDALONE = 'standalone';
    public const TYPE_COMPOSED = 'composed';

    public const TYPES = [
        self::TYPE_STANDALONE,
        self::TYPE_COMPOSED,
    ];

    public const EVALUATOR_TYPE_DEFAULT = 'default';
    public const EVALUATOR_TYPE_CUSTOM = 'custom';

    public const EVALUATOR_TYPES = [
        self::EVALUATOR_TYPE_DEFAULT,
        self::EVALUATOR_TYPE_CUSTOM,
    ];

    public $timestamps = false;
    protected $fillable = ['name', 'uri_alias', 'time', 'mark_evaluator_type', 'test_subject_id'];

    public function subject(): BelongsTo
    {
        return $this->belongsTo(TestSubject::class, 'test_subject_id');
    }

    public function nativeQuestions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function tests(): BelongsToMany
    {
        return $this->belongsToMany(
            self::class,
            'test_composite',
            'id_test',
            'id_include_test'
        )->using(TestComposite::class)
            ->withPivot(['questions_quantity']);
    }

    public function testComposites(): HasMany
    {
        return $this->hasMany(TestComposite::class, 'id_test');
    }

    /**
     * @return Collection|Question[]
     */
    public function allQuestions()
    {
        return Collection::make($this->testComposites->pluck('questions')->flatten());
    }

    /** @return HasMany|TestResult */
    public function testResults(): HasMany
    {
        return $this->hasMany(TestResult::class);
    }

    public function marksPercents(): HasMany
    {
        return $this->hasMany(MarkPercent::class);
    }
}
