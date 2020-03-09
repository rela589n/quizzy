<?php


namespace App\Lib\Filters;


use App\Models\TestResult;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class TestResultFilter extends ResultFilter
{
    protected function loadRelations(EloquentCollection $results)
    {
        $results->loadMissing([
            'askedQuestions.question' => function ($query) {
                $query->withTrashed();
            },
            'askedQuestions.answers.answerOption' => function ($query) {
                $query->withTrashed();
            },
            'user.studentGroup' => function ($query) {
                $query->withTrashed();
            }
        ]);
    }

    protected function filterFilters(array $arr)
    {
        return array_filter($arr, function ($val) {
            return $val !== '' && $val !== null;
        });
    }

    protected function filters()
    {
        return $this->filterFilters(
            $this->request->only('result', 'mark')
        );
    }

    protected function queryFilters()
    {
        return $this->filterFilters(
            $this->request->only(['resultId', 'groupId', 'name', 'surname', 'patronymic'])
        );
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param $value
     */
    public function resultId($query, $value)
    {
        $query->where('id', $value);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param $groupId
     */
    public function groupId($query, $groupId)
    {
        $query->whereHas('user.studentGroup', function ($builder) use ($groupId) {
            $builder->where('id', $groupId);
        });
    }

    /**
     * @param string $relation
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $field
     * @param $fieldValue
     */
    protected function textFieldFilter(string $relation, $query, string $field, $fieldValue)
    {
        $query->whereHas($relation, function ($builder) use ($field, $fieldValue) {
            $builder->where($field, 'like', "%$fieldValue%");
        });
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param $name
     */
    public function name($query, $name)
    {
        $this->textFieldFilter('user', $query, 'name', $name);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param $surname
     */
    public function surname($query, $surname)
    {
        $this->textFieldFilter('user', $query, 'surname', $surname);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param $patronymic
     */
    public function patronymic($query, $patronymic)
    {
        $this->textFieldFilter('user', $query, 'patronymic', $patronymic);
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
