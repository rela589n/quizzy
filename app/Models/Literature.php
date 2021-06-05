<?php

declare(strict_types=1);

namespace App\Models;

/**
 * App\Models\Literature
 *
 * @property int $id
 * @property string $description
 * @property int $test_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \App\Models\Query\CustomEloquentBuilder|Literature newModelQuery()
 * @method static \App\Models\Query\CustomEloquentBuilder|Literature newQuery()
 * @method static \App\Models\Query\CustomEloquentBuilder|Literature query()
 * @method static \App\Models\Query\CustomEloquentBuilder|Literature whereCreatedAt($value)
 * @method static \App\Models\Query\CustomEloquentBuilder|Literature whereDescription($value)
 * @method static \App\Models\Query\CustomEloquentBuilder|Literature whereId($value)
 * @method static \App\Models\Query\CustomEloquentBuilder|Literature whereTestId($value)
 * @method static \App\Models\Query\CustomEloquentBuilder|Literature whereUpdatedAt($value)
 * @mixin \Eloquent
 */
/** @deprecated (currently implement with plain field on questions table, maybe use separate model in future) */
final class Literature extends Model
{

}
