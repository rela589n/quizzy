<?php


namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\BaseUser
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
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseUser whereConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseUser whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseUser whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseUser whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseUser wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseUser wherePatronymic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseUser whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseUser whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseUser whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseUser wherePasswordChanged($value)
 * @property-read mixed $full_name
    */
abstract class BaseUser extends Authenticatable
{
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

    public function getFullNameAttribute()
    {
        return "{$this->surname} {$this->name} {$this->patronymic}";
    }
}
