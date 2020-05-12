<?php


namespace App\Models;


use App\Lib\Traits\FilteredScope;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\Administrator
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $patronymic
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property int $password_changed
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $full_name
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Administrator newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Administrator newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Administrator query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Administrator whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Administrator whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Administrator whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Administrator whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Administrator whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Administrator wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Administrator wherePasswordChanged($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Administrator wherePatronymic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Administrator whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Administrator whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Administrator whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read string|null $roles_readable
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Administrator ofRole($roleName)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Administrator permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Administrator role($roles, $guard = null)
 */
class Administrator extends BaseUser
{
    use HasRoles;
    use FilteredScope;

    public function guardName()
    {
        return 'admin';
    }

    public function studentGroup()
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
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $roleName
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfRole($query, string $roleName)
    {
        return $query->whereHas('roles', function ($q) use ($roleName) {
            $q->whereName($roleName);
        });
    }
}
