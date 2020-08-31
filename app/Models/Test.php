<?php

namespace App\Models;

use App\Lib\Traits\OwnerChecks;
use App\Lib\Traits\SlugScope;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Test
 *
 * @property int $id
 * @property string $name
 * @property string $uri_alias
 * @property int $time
 * @property int $test_subject_id
 * @property-read Collection|Question[] $nativeQuestions
 * @property-read Collection|TestComposite[] $testComposites
 * @property-read int|null $native_questions_count
 * @property-read TestSubject $subject
 * @property-read Collection|Test[] $tests
 * @property-read int|null $tests_count
 * @method static Builder|Test newModelQuery()
 * @method static Builder|Test newQuery()
 * @method static Builder|Test query()
 * @method static Builder|Test whereId($value)
 * @method static Builder|Test whereName($value)
 * @method static Builder|Test whereTestSubjectId($value)
 * @method static Builder|Test whereTime($value)
 * @method static Builder|Test whereUriAlias($value)
 * @mixin Eloquent
 * @property-read int|null $test_composites_count
 * @property Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Test onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Test whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Test withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Test withoutTrashed()
 * @property-read Collection|TestResult[] $testResults
 * @property-read int|null $test_results_count
 * @method static Builder|Test whereSlug($slug)
 * @property int|null $created_by
 * @method static Builder|Test whereCreatedBy($value)
 * @property string $mark_evaluator_type
 * @property-read Collection|MarkPercent[] $marksPercents
 * @property-read int|null $marks_percents_count
 * @method static Builder|Test whereMarkEvaluatorType($value)
 */
class Test extends Model
{
    use SoftDeletes;
    use SlugScope;

    use OwnerChecks;

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

    public function testResults(): HasMany
    {
        return $this->hasMany(TestResult::class);
    }

    public function marksPercents(): HasMany
    {
        return $this->hasMany(MarkPercent::class);
    }
}
