<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\TestComposite
 *
 * @property int $id
 * @property int $id_test
 * @property int $id_include_test
 * @property int $questions_quantity
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Question[] $questions
 * @property-read int|null $questions_count
 * @property-read \App\Models\Test $includeTest
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestComposite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestComposite newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestComposite query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestComposite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestComposite whereIdIncludeTest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestComposite whereIdTest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestComposite whereQuestionsQuantity($value)
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
        return $this->hasManyDeepFromRelations(
            $this->includeTest(),
            (new Test)->nativeQuestions()
        )->random($this->questions_quantity);
    }
}
