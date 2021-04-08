<?php

namespace App\Models;

use App\Lib\Filters\Eloquent\ResultFilter;
use App\Lib\Traits\FilteredScope;
use App\Models\Departments\DepartmentEloquentBuilder;
use App\Repositories\Queries\AccessibleDepartments as AccessibleDepartmentsQuery;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder as QueryBuilder;

/**
 * App\Models\Department
 *
 * @property int $id
 * @property string $name
 * @property string $uri_alias
 * @property string|null $deleted_at
 * @method static Builder|Department newModelQuery()
 * @method static Builder|Department newQuery()
 * @method static Builder|Department query()
 * @method static Builder|Department whereDeletedAt($value)
 * @method static Builder|Department whereId($value)
 * @method static Builder|Department whereName($value)
 * @method static Builder|Department whereUriAlias($value)
 * @mixin Eloquent
 * @property-read Collection|StudentGroup[] $studentGroups
 * @property-read int|null $student_groups_count
 * @property-read Collection|TestSubject[] $testSubjects
 * @property-read int|null $test_subjects_count
 * @property-read Collection|Administrator[] $administrators
 * @property-read int|null $administrators_count
 * @method static Builder|Department filtered(ResultFilter $filters)
 * @method static QueryBuilder|Department onlyTrashed()
 * @method static QueryBuilder|Department withTrashed()
 * @method static QueryBuilder|Department withoutTrashed()
 */
class Department extends Model
{
    use SoftDeletes;
    use FilteredScope;

    public $timestamps = false;
    protected $fillable = ['name', 'uri_alias'];

    public function testSubjects(): BelongsToMany
    {
        return $this->belongsToMany(TestSubject::class);
    }

    public function administrators(): BelongsToMany
    {
        return $this->belongsToMany(Administrator::class, 'administrator_department');
    }

    public function studentGroups(): HasMany
    {
        return $this->hasMany(StudentGroup::class);
    }

    public function isAvailableForAdmin(Administrator $administrator): bool
    {
        return $administrator->departments->find($this->id) !== null
            || app()->make(AccessibleDepartmentsQuery::class)->setUser($administrator)->isCreatedBy($this);
    }

    public function newEloquentBuilder($query): DepartmentEloquentBuilder
    {
        return new DepartmentEloquentBuilder($query);
    }
}
