<?php


namespace App\Models;


use App\Lib\Traits\FilteredScope;
use App\Models\Administrators\AdministratorsEloquentBuilder;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\Administrator
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $patronymic
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property int $password_changed
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read mixed $full_name
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static AdministratorsEloquentBuilder|Administrator newModelQuery()
 * @method static AdministratorsEloquentBuilder|Administrator newQuery()
 * @method static AdministratorsEloquentBuilder|Administrator query()
 * @method static AdministratorsEloquentBuilder|Administrator whereCreatedAt($value)
 * @method static AdministratorsEloquentBuilder|Administrator whereEmail($value)
 * @method static AdministratorsEloquentBuilder|Administrator whereEmailVerifiedAt($value)
 * @method static AdministratorsEloquentBuilder|Administrator whereId($value)
 * @method static AdministratorsEloquentBuilder|Administrator whereName($value)
 * @method static AdministratorsEloquentBuilder|Administrator wherePassword($value)
 * @method static AdministratorsEloquentBuilder|Administrator wherePasswordChanged($value)
 * @method static AdministratorsEloquentBuilder|Administrator wherePatronymic($value)
 * @method static AdministratorsEloquentBuilder|Administrator whereRememberToken($value)
 * @method static AdministratorsEloquentBuilder|Administrator whereSurname($value)
 * @method static AdministratorsEloquentBuilder|Administrator whereUpdatedAt($value)
 * @method static AdministratorsEloquentBuilder|Administrator permission($permissions)
 * @method static AdministratorsEloquentBuilder|Administrator role($roles, $guard = null)
 * @mixin Eloquent
 * @property-read Collection|Department[] $departments
 * @property-read int|null $departments_count
 * @property-read Collection|Department[] $testSubjects
 * @property-read int|null $test_subjects_count
 * @property-read Collection|Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read string|null $roles_readable
 * @property-read Collection|Role[] $roles
 * @property-read int|null $roles_count
 */
class Administrator extends BaseUser
{
    use HasRoles;
    use FilteredScope;

    public const ROLES_FOR_TEACHER = [
        'teacher',
        'class-monitor',
    ];

    public function guardName(): string
    {
        return 'admin';
    }

    public function studentGroup(): HasOne
    {
        return $this->hasOne(StudentGroup::class, 'created_by');
    }

    public function getRolesReadableAttribute()
    {
        $roles = $this->roles;
        $roles = $roles->pluck('public_name');

        return implode(', ', $roles->toArray());
    }

    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(Department::class, 'administrator_department');
    }

    public function testSubjects(): BelongsToMany
    {
        return $this->belongsToMany(TestSubject::class, 'administrator_test_subject');
    }

    public function newEloquentBuilder($query)
    {
        return new AdministratorsEloquentBuilder($query);
    }

    public function canAccessGroup(StudentGroup $group): bool
    {
        if ($this->hasRole('class-monitor')) {
            return $group->created_by === $this->id;
        }

        return $group->department->isAvailableForAdmin($this);
    }
}
