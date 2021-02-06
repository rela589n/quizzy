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
 * @method static Builder|Administrator newModelQuery()
 * @method static Builder|Administrator newQuery()
 * @method static Builder|Administrator query()
 * @method static Builder|Administrator whereCreatedAt($value)
 * @method static Builder|Administrator whereEmail($value)
 * @method static Builder|Administrator whereEmailVerifiedAt($value)
 * @method static Builder|Administrator whereId($value)
 * @method static Builder|Administrator whereName($value)
 * @method static Builder|Administrator wherePassword($value)
 * @method static Builder|Administrator wherePasswordChanged($value)
 * @method static Builder|Administrator wherePatronymic($value)
 * @method static Builder|Administrator whereRememberToken($value)
 * @method static Builder|Administrator whereSurname($value)
 * @method static Builder|Administrator whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read Collection|Department[] $departments
 * @property-read int|null $departments_count
 * @property-read Collection|Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read string|null $roles_readable
 * @property-read Collection|Role[] $roles
 * @property-read int|null $roles_count
 * @method static Builder|Administrator ofRole($roleName)
 * @method static Builder|Administrator permission($permissions)
 * @method static Builder|Administrator role($roles, $guard = null)
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

    /**
     * @param  Builder  $query
     * @param  string  $roleName
     * @return Builder
     */
    public function scopeOfRole($query, string $roleName): Builder
    {
        return $query->whereHas(
            'roles',
            static function ($q) use ($roleName) {
                $q->whereName($roleName);
            }
        );
    }

    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(Department::class, 'administrator_department');
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
