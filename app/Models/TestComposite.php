<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * App\Models\TestComposite
 *
 * @property int $id
 * @property int $id_test
 * @property int $id_include_test
 * @property int $questions_quantity
 * @property-read \Illuminate\Database\Eloquent\Collection|Question[] $questions
 * @property-read int|null $questions_count
 * @property-read Test $includeTest
 * @method static \Illuminate\Database\Eloquent\Builder|TestComposite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TestComposite newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TestComposite query()
 * @method static \Illuminate\Database\Eloquent\Builder|TestComposite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestComposite whereIdIncludeTest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestComposite whereIdTest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestComposite whereQuestionsQuantity($value)
 * @mixin \Eloquent
 */
class TestComposite extends Pivot
{
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    public $timestamps = false;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    public function includeTest()
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
     * @param  \Illuminate\Database\Eloquent\Builder|Relation|Question  $query
     * @return \Illuminate\Database\Eloquent\Builder|Relation|Question
     */
    protected function applySort($query)
    {
        return $query->random($this->questions_quantity);
    }
}
