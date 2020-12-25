<?php

namespace App\Models;

use App\Lib\Traits\SlugScope;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\TestSubject
 *
 * @property int $id
 * @property string $name
 * @property string $uri_alias
 * @property-read Collection|Test[] $tests
 * @property-read int|null $tests_count
 * @method static Builder|TestSubject newModelQuery()
 * @method static Builder|TestSubject newQuery()
 * @method static Builder|TestSubject query()
 * @method static Builder|TestSubject whereCourse($value)
 * @method static Builder|TestSubject whereId($value)
 * @method static Builder|TestSubject whereName($value)
 * @method static Builder|TestSubject whereUriAlias($value)
 * @mixin Eloquent
 * @method static Builder|TestSubject availableFor($user)
 * @method static Builder|TestSubject whereSlug($slug)
 * @property-read Collection|Course[] $courses
 * @property-read int|null $courses_count
 * @property-read mixed $courses_numeric
 * @property-read Collection|Department[] $departments
 * @property-read int|null $departments_count
 * @property-read mixed $department_ids
 * @method static Builder|TestSubject byUserCourse($user)
 * @method static Builder|TestSubject byUserDepartment($user)
 */
class TestSubject extends Model
{
    use SlugScope;

    public $timestamps = false;
    protected $fillable = ['name', 'uri_alias'];

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class);
    }

    public function getCoursesNumericAttribute(): array
    {
        return $this->courses->pluck('id')->toArray();
    }

    public function tests(): HasMany
    {
        return $this->hasMany(Test::class);
    }

    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(Department::class);
    }

    public function getDepartmentIdsAttribute(): array
    {
        return $this->departments->pluck('id')->toArray();
    }

    /**
     * @param  Builder|TestSubject  $query
     * @param  User  $user
     * @return Builder
     */
    public function scopeAvailableFor($query, $user)
    {
        return $query->byUserCourse($user)
            ->byUserDepartment($user);
    }

    /**
     * @param  Builder  $query
     * @param  User  $user
     * @return Builder
     */
    public function scopeByUserCourse($query, $user)
    {
        return $query->whereHas(
            'courses',
            static function (Builder $coursesQuery) use ($user) {
                // id represents int value of course
                $coursesQuery->where('id', $user->course);
            }
        );
    }

    /**
     * @param  Builder  $query
     * @param  User  $user
     * @return Builder
     */
    public function scopeByUserDepartment($query, $user)
    {
        return $query->whereHas(
            'departments',
            static function (Builder $departmentsQuery) use ($user) {
                $departmentsQuery->where('id', $user->studentGroup->department->id);
            }
        );
    }
}
