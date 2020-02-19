<?php

namespace App\Models;

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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Question[] $nativeQuestions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TestComposite[] $testComposites
 * @property-read int|null $native_questions_count
 * @property-read \App\Models\TestSubject $subject
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Test[] $tests
 * @property-read int|null $tests_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Test newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Test newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Test query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Test whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Test whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Test whereTestSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Test whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Test whereUriAlias($value)
 * @mixin \Eloquent
 * @property-read int|null $test_composites_count
 */
class Test extends Model
{
    use SoftDeletes;
//    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    public $timestamps = false;
    protected $fillable = ['name', 'uri_alias', 'time']; // todo create architecture

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
     * @return \Illuminate\Database\Eloquent\Collection|\App\Models\Question[]
     */
    public function allQuestions()
    {
//        return $this->hasManyDeepFromRelations(
//            $this->testComposites(),
//            (new TestComposite)->questions()
//        ); // :-/ does not work in the right way

        // todo move it into repository
        return $this->testComposites->pluck('questions')->flatten();

//        return $this->hasManyDeep(
//            Question::class,
//            ['test_composite', self::class],
//            ['id_test'],
//            [null, 'id_include_test']
//        );
    }
}
