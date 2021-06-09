<?php


namespace App\Models;

use App\Models\Concerns\OverridesQueryBuilder;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * App\Models\BaseUser
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
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static Builder|BaseUser newModelQuery()
 * @method static Builder|BaseUser newQuery()
 * @method static Builder|BaseUser query()
 * @method static Builder|BaseUser whereConfirmed($value)
 * @method static Builder|BaseUser whereCreatedAt($value)
 * @method static Builder|BaseUser whereEmail($value)
 * @method static Builder|BaseUser whereEmailVerifiedAt($value)
 * @method static Builder|BaseUser whereId($value)
 * @method static Builder|BaseUser whereName($value)
 * @method static Builder|BaseUser wherePassword($value)
 * @method static Builder|BaseUser wherePatronymic($value)
 * @method static Builder|BaseUser whereRememberToken($value)
 * @method static Builder|BaseUser whereSurname($value)
 * @method static Builder|BaseUser whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static Builder|BaseUser wherePasswordChanged($value)
 * @property-read mixed $full_name
 */
abstract class BaseUser extends Authenticatable
{
    use OverridesQueryBuilder;
    use SoftDeletes;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'patronymic', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFullNameAttribute(): string
    {
        return "{$this->surname} {$this->name} {$this->patronymic}";
    }
}
