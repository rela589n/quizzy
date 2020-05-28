<?php

namespace App\Models;

use App\Lib\Traits\OwnerChecks;
use App\Lib\Traits\SlugScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Test
 *
 * @property int $id
 * @property string $name
 * @property string $uri_alias
 * @property int $time
 * @property int $test_subject_id
 * @property-read \Illuminate\Database\Eloquent\Collection|Question[] $nativeQuestions
 * @property-read \Illuminate\Database\Eloquent\Collection|TestComposite[] $testComposites
 * @property-read int|null $native_questions_count
 * @property-read TestSubject $subject
 * @property-read \Illuminate\Database\Eloquent\Collection|Test[] $tests
 * @property-read int|null $tests_count
 * @method static \Illuminate\Database\Eloquent\Builder|Test newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Test newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Test query()
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereTestSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereUriAlias($value)
 * @mixin \Eloquent
 * @property-read int|null $test_composites_count
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Test onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Test withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Test withoutTrashed()
 * @property-read \Illuminate\Database\Eloquent\Collection|TestResult[] $testResults
 * @property-read int|null $test_results_count
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereSlug($slug)
 * @property int|null $created_by
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereCreatedBy($value)
 */
class Test extends Model
{
    use SoftDeletes;
    use SlugScope;

    use OwnerChecks;

    public $timestamps = false;
    protected $fillable = ['name', 'uri_alias', 'time', 'test_subject_id'];

    public function subject()
    {
        return $this->belongsTo(TestSubject::class, 'test_subject_id');
    }

    public function nativeQuestions()
    {
        return $this->hasMany(Question::class);
    }

    public function tests()
    {
        return $this->belongsToMany(
            self::class,
            'test_composite',
            'id_test',
            'id_include_test'
        )->using(TestComposite::class)
            ->withPivot(['questions_quantity']);
    }

    public function testComposites()
    {
        return $this->hasMany(TestComposite::class, 'id_test');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|Question[]
     */
    public function allQuestions()
    {
        return \Illuminate\Database\Eloquent\Collection::make($this->testComposites->pluck('questions')->flatten());
    }

    public function testResults()
    {
        return $this->hasMany(TestResult::class);
    }

    public function marksPercents()
    {
        return $this->hasMany(MarkPercent::class);
    }
}
