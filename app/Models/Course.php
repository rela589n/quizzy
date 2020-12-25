<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * App\Models\Course
 *
 * @property int $id
 * @property string $public_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Course newModelQuery()
 * @method static Builder|Course newQuery()
 * @method static Builder|Course query()
 * @method static Builder|Course whereCreatedAt($value)
 * @method static Builder|Course whereId($value)
 * @method static Builder|Course whereNumericName($value)
 * @method static Builder|Course wherePublicName($value)
 * @method static Builder|Course whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read Collection|TestSubject[] $testSubjects
 * @property-read int|null $test_subjects_count
 */
class Course extends Model
{
    public function testSubjects(): BelongsToMany
    {
        return $this->belongsToMany(TestSubject::class);
    }

    public function getPublicNameAttribute($publicName): string
    {
        return Str::title($publicName);
    }
}
