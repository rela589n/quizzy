<?php

namespace App\Models;

use App\Lib\Filters\Eloquent\ResultFilter;
use App\Lib\Traits\FilteredScope;
use App\Lib\Traits\SlugScope;
use App\Models\StudentGroups\StudentGroupEloquentBuilder;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\StudentGroup
 *
 * @property int $id
 * @property string $name
 * @property string $uri_alias
 * @property int $year
 * @property Carbon|null $deleted_at
 * @property-read Collection|User[] $students
 * @property-read int|null $students_count
 * @method static bool|null forceDelete()
 * @method static Builder|StudentGroup newModelQuery()
 * @method static Builder|StudentGroup newQuery()
 * @method static \Illuminate\Database\Query\Builder|StudentGroup onlyTrashed()
 * @method static Builder|StudentGroup query()
 * @method static bool|null restore()
 * @method static Builder|StudentGroup whereDeletedAt($value)
 * @method static Builder|StudentGroup whereId($value)
 * @method static Builder|StudentGroup whereName($value)
 * @method static Builder|StudentGroup whereUriAlias($value)
 * @method static Builder|StudentGroup whereYear($value)
 * @method static \Illuminate\Database\Query\Builder|StudentGroup withTrashed()
 * @method static \Illuminate\Database\Query\Builder|StudentGroup withoutTrashed()
 * @mixin StudentGroupEloquentBuilder
 * @property-read int $course
 * @property int|null $created_by
 * @method static Builder|StudentGroup whereCreatedBy($value)
 * @method static Builder|StudentGroup whereSlug($slug)
 * @method static Builder|StudentGroup filtered(ResultFilter $filters)
 * @property int|null $department_id
 * @method static Builder|StudentGroup whereDepartmentId($value)
 * @property-read Department|null $department
 * @property-read Administrator|null $classMonitor
 */
class StudentGroup extends Model
{
    use SoftDeletes;

    use SlugScope;
    use FilteredScope;

    public $timestamps = false;

    protected $fillable = ['name', 'uri_alias', 'year', 'created_by'];
    protected int $studyStartMonth = 9;
    protected int $studyStartDay = 1;

    /**
     * @return HasMany|User
     */
    public function students()
    {
        return $this->hasMany(User::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * @return BelongsTo|Administrator
     */
    protected function administrator()
    {
        return $this->belongsTo(Administrator::class, 'created_by');
    }

    /**
     * @return BelongsTo|Builder|Administrator
     */
    public function classMonitor()
    {
        return $this->administrator()->ofRoles('class-monitor');
    }

    /**
     * Get the group's course.
     *
     * @return int
     */
    public function getCourseAttribute(): int
    {
        $started = Carbon::parse(
            sprintf(
                '%s-%s-%s',
                $this->year,
                $this->studyStartMonth,
                $this->studyStartDay
            )
        );

        return Carbon::now()->diffInYears($started) + 1;
    }

    /**
     * @param  Test  $test
     * @return TestResult|Builder
     */
    public function lastResults(Test $test)
    {
        $students = $this->students()->orderBy('surname')->orderBy('name')->withTrashed()->get();
        $builder = clone $students[0]->lastResultOf($test);

        for ($i = 1; $i < $students->count(); ++$i) {
            $builder->union($students[$i]->lastResultOf($test)->toBase());
        }

        $query = DB::table($builder->toBase(), 'test_results');

        return (new Builder(DB::query()))
            ->setModel(TestResult::newModelInstance())
            ->setQuery($query);
    }

    public function isOwnedBy(Administrator $model): bool
    {
        return $model->id === $this->created_by;
    }

    public function isAvailableForAdmin(Administrator $administrator): bool
    {
        return $administrator->canAccessGroup($this);
    }

    public function newEloquentBuilder($query): StudentGroupEloquentBuilder
    {
        return new StudentGroupEloquentBuilder($query);
    }
}
