<?php


namespace App\Lib\Filters\Eloquent;


use App\Models\StudentGroup;
use App\Models\TestResult;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Carbon;

class TestResultFilter extends ResultFilter
{
    /**
     * @var array
     */
    protected $queryFilters;

    /**
     * @var array
     */
    protected $filters;

    /**
     * @param array $queryFilters
     */
    public function setQueryFilters(array $queryFilters): void
    {
        $this->queryFilters = $queryFilters;
    }

    /**
     * @param array $filters
     */
    public function setFilters(array $filters): void
    {
        $this->filters = $filters;
    }

    protected function loadRelations(EloquentCollection $results)
    {
        $results->loadMissing([
            'askedQuestions.question'             => function (Relation $query) {
                $query->withTrashed();
            },
            'askedQuestions.answers.answerOption' => function (Relation $query) {
                $query->withTrashed();
            },
            'user'                                => function (Relation $query) {
                $query->withTrashed();
            },
            'user.studentGroup'                   => function (Relation $query) {
                $query->withTrashed();
            }
        ]);
    }

    protected function filterFilters(array $arr)
    {
        return array_filter($arr, function ($val) {
            return $val !== '' && $val !== null && $val !== [];
        });
    }

    protected function filters()
    {
        return $this->filterFilters($this->filters);
    }

    protected function queryFilters()
    {
        return $this->filterFilters($this->queryFilters);
    }

    /**
     * @param EloquentBuilder $query
     * @param $value
     */
    public function resultId($query, $value)
    {
        $query->where('id', $value);
    }

    /**
     * @param EloquentBuilder $query
     * @param $groupId
     */
    public function groupId($query, $groupId)
    {
        $query->whereHas('user', function (EloquentBuilder $userBuilder) use ($groupId) {
            /**
             * @var EloquentBuilder|User $userBuilder
             */
            $userBuilder->withTrashed();

            $userBuilder->whereHas('studentGroup', function (EloquentBuilder $groupBuilder) use ($groupId) {
                /**
                 * @var EloquentBuilder|StudentGroup $groupBuilder
                 */
                $groupBuilder->withTrashed();
                $groupBuilder->where('id', $groupId);
            });
        });
    }

    /**
     * @param string $relation
     * @param EloquentBuilder $query
     * @param string $field
     * @param $fieldValue
     */
    protected function textFieldFilter(string $relation, $query, string $field, $fieldValue)
    {
        $query->whereHas($relation, function (EloquentBuilder $builder) use ($field, $fieldValue) {
            /**
             * @var Model|EloquentBuilder $builder
             */
            
            $builder->withTrashed();
            $builder->where($field, 'like', "%$fieldValue%");
        });
    }

    /**
     * @param EloquentBuilder $query
     * @param $name
     */
    public function name($query, $name)
    {
        $this->textFieldFilter('user', $query, 'name', $name);
    }

    /**
     * @param EloquentBuilder $query
     * @param $surname
     */
    public function surname($query, $surname)
    {
        $this->textFieldFilter('user', $query, 'surname', $surname);
    }

    /**
     * @param EloquentBuilder $query
     * @param $patronymic
     */
    public function patronymic($query, $patronymic)
    {
        $this->textFieldFilter('user', $query, 'patronymic', $patronymic);
    }

    /**
     * @param EloquentBuilder $query
     * @param Carbon[] $dates
     */
    public function resultDateIn($query, $dates)
    {
        $query->where(function (EloquentBuilder $query) use ($dates) {

            array_map(function (Carbon $date) use ($query) {

                $query->orWhereDate('created_at', $date);

            }, $dates);
        });
    }

    /**
     * @param TestResult $testResult
     * @param $score
     * @return bool
     */
    public function result($testResult, $score)
    {
        return abs(100 * $testResult->score - $score) <= 5;
    }

    /**
     * @param TestResult $testResult
     * @param $mark
     * @return bool
     */
    public function mark($testResult, $mark)
    {
        return $testResult->mark == $mark;
    }
}
