<?php

namespace App\Models;

use App\Lib\Traits\SlugScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TestSubject
 *
 * @property int $id
 * @property string $name
 * @property string $uri_alias
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Test[] $tests
 * @property-read int|null $tests_count
 * @method static Builder|\App\Models\TestSubject newModelQuery()
 * @method static Builder|\App\Models\TestSubject newQuery()
 * @method static Builder|\App\Models\TestSubject query()
 * @method static Builder|\App\Models\TestSubject whereCourse($value)
 * @method static Builder|\App\Models\TestSubject whereId($value)
 * @method static Builder|\App\Models\TestSubject whereName($value)
 * @method static Builder|\App\Models\TestSubject whereUriAlias($value)
 * @mixin \Eloquent
 * @method static Builder|\App\Models\TestSubject availableFor($user)
 * @method static Builder|\App\Models\TestSubject whereSlug($slug)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Course[] $courses
 * @property-read int|null $courses_count
 * @property-read mixed $courses_numeric
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Department[] $departments
 * @property-read int|null $departments_count
 * @property-read mixed $department_ids
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestSubject byUserCourse($user)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestSubject byUserDepartment($user)
 */
class TestSubject extends Model
{
    use SlugScope;

    public $timestamps = false;
    protected $fillable = ['name', 'uri_alias'];

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

    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }

    public function getDepartmentIdsAttribute()
    {
        return $this->departments->pluck('id')->toArray();
    }

    /**
     * @param Builder|TestSubject $query
     * @param User $user
     * @return Builder
     */
    public function scopeAvailableFor($query, $user)
    {
        return $query->byUserCourse($user)
            ->byUserDepartment($user);
    }

    /**
     * @param Builder $query
     * @param User $user
     * @return Builder
     */
    public function scopeByUserCourse($query, $user)
    {
        return $query->whereHas(
            'courses',
            function (Builder $coursesQuery) use ($user) {
                // id represents int value of course
                $coursesQuery->where('id', $user->course);
            }
        );
    }

    /**
     * @param Builder $query
     * @param User $user
     * @return Builder
     */
    public function scopeByUserDepartment($query, $user)
    {
        return $query->whereHas(
            'departments',
            function (Builder $departmentsQuery) use ($user) {
                $departmentsQuery->where('id', $user->studentGroup->department->id);
            }
        );
    }
}
