<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\Relation;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

/**
 * App\Models\TestComposite
 *
 * @property int $id
 * @property int $id_test
 * @property int $id_include_test
 * @property int $questions_quantity
 * @property-read Collection|Question[] $questions
 * @property-read int|null $questions_count
 * @property-read Test $includeTest
 * @method static Builder|TestComposite newModelQuery()
 * @method static Builder|TestComposite newQuery()
 * @method static Builder|TestComposite query()
 * @method static Builder|TestComposite whereId($value)
 * @method static Builder|TestComposite whereIdIncludeTest($value)
 * @method static Builder|TestComposite whereIdTest($value)
 * @method static Builder|TestComposite whereQuestionsQuantity($value)
 * @mixin Eloquent
 */
class TestComposite extends Pivot
{
    use HasRelationships;

    public $timestamps = false;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    public function includeTest(): BelongsTo
    {
        return $this->belongsTo(Test::class, 'id_include_test');
    }

    public function questions()
    {
        $builder = $this->hasManyDeepFromRelations(
            $this->includeTest(),
            (new Test)->nativeQuestions()
        );

        return $this->applySort($builder);
    }

    /**
     * @param  Builder|Relation|Question  $query
     * @return Builder|Relation|Question
     */
    protected function applySort($query)
    {
        return $query->random($this->questions_quantity);
    }
}
