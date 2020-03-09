<?php


namespace App\Models;


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
 */
class Administrator extends BaseUser
{

}
