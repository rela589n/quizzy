<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * \App\Models\Configuration
 *
 * @property int $id
 * @property string $display_name
 * @property string $name
 * @property mixed $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration query()
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereValue($value)
 * @mixin \Eloquent
 */
class Configuration extends Model
{
    //
}
