<?php

namespace App\Models;

use App\Lib\Traits\SlugScope;
use App\Models\Subjects\SubjectEloquentBuilder;
use App\Models\Tests\TestEloquentBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $uri_alias
 * @property-read Collection|Test[] $tests
 * @property-read int|null $tests_count
 * @property-read Collection|Course[] $courses
 * @property-read int|null $courses_count
 * @property-read mixed $courses_numeric
 * @property-read Collection|Department[] $departments
 * @property-read int|null $departments_count
 * @property-read Collection|Administrator[] $administrators
 * @property-read int|null $administrators_count
 * @property-read mixed $department_ids
 *
 * @method static SubjectEloquentBuilder newModelQuery()
 * @method static SubjectEloquentBuilder newQuery()
 * @method static SubjectEloquentBuilder query()
 * @method static SubjectEloquentBuilder whereCourse($value)
 * @method static SubjectEloquentBuilder whereId($value)
 * @method static SubjectEloquentBuilder whereName($value)
 * @method static SubjectEloquentBuilder whereUriAlias($value)
 * @method static SubjectEloquentBuilder whereSlug($slug)
 *
 * @mixin SubjectEloquentBuilder
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

    /** @return HasMany|TestEloquentBuilder */
    public function tests(): HasMany
    {
        return $this->hasMany(Test::class);
    }

    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(Department::class);
    }

    public function administrators(): BelongsToMany
    {
        return $this->belongsToMany(Administrator::class, 'administrator_test_subject');
    }

    public function getDepartmentIdsAttribute(): array
    {
        return $this->departments->pluck('id')->toArray();
    }

    public function newEloquentBuilder($query): SubjectEloquentBuilder
    {
        return new SubjectEloquentBuilder($query);
    }

    public function isAvailableToAdmin(Administrator $administrator): bool
    {
        return $this->administrators->find($administrator->id) !== null;
    }

    protected static function boot()
    {
        parent::boot();
        static::created(function (self $model) {

            $model->administrators()->attach(request()->user()->id);
        });
    }
}
