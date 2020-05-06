<?php

namespace App\Models;

use App\Lib\Traits\SlugScope;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TestSubject
 *
 * @property int $id
 * @property string $name
 * @property string $uri_alias
 * @property string $course
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Test[] $tests
 * @property-read int|null $tests_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestSubject newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestSubject newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestSubject query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestSubject whereCourse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestSubject whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestSubject whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestSubject whereUriAlias($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestSubject availableFor($user)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestSubject whereSlug($slug)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Course[] $courses
 * @property-read int|null $courses_count
 * @property-read mixed $courses_numeric
 */
class TestSubject extends Model
{
    use SlugScope;

    public $timestamps = false;
    protected $fillable = ['name', 'uri_alias', 'course'];

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function getCoursesNumericAttribute()
    {
        return $this->courses->pluck('id')->toArray();
    }

    public function tests()
    {
        return $this->hasMany(Test::class);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailableFor($query, $user)
    {
        return $query->where('course', $user->course);
    }
}
