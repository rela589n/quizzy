<?php

declare(strict_types=1);


namespace App\Models\Subjects;

use App\Models\Administrator;
use App\Models\Administrators\AdministratorsEloquentBuilder;
use App\Models\Query\CustomEloquentBuilder;
use App\Models\TestSubject;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

/** @mixin TestSubject */
final class SubjectEloquentBuilder extends CustomEloquentBuilder
{
    /**
     * @param  User  $user
     * @return $this
     */
    public function byUserCourse(User $user): self
    {
        return $this->whereHas(
            'courses',
            static function (Builder $coursesQuery) use ($user) {
                // id represents int value of course
                $coursesQuery->where('id', $user->course);
            }
        );
    }

    public function byUserDepartment(User $user): self
    {
        return $this->whereHas(
            'departments',
            static function (Builder $departmentsQuery) use ($user) {
                $departmentsQuery->where('id', $user->studentGroup->department->id);
            }
        );
    }

    public function availableFor(User $user): self
    {
        return $this->byUserCourse($user)
            ->byUserDepartment($user);
    }

    public function availableForAdmin(Administrator $administrator): self
    {
        if ($administrator->can('viewAll', TestSubject::class)) {
            return $this;
        }

        return $this->whereHas(
            'administrators',
            static fn(AdministratorsEloquentBuilder $builder) => $builder->where('id', $administrator->id),
        );
    }
}
