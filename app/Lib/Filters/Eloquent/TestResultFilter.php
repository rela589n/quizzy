<?php


namespace App\Lib\Filters\Eloquent;


use App\Models\TestResult;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TestResultFilter extends ResultFilter
{
    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function loadRelations(EloquentCollection $results)
    {
        $results->loadMissing([
            'askedQuestions.question'             => function ($query) {
                $query->withTrashed();
            },
            'askedQuestions.answers.answerOption' => function ($query) {
                $query->withTrashed();
            },
            'user.studentGroup'                   => function ($query) {
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
            $this->request->only(['resultId', 'groupId', 'name', 'surname', 'patronymic', 'resultDateIn'])
        );
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
        $query->whereHas('user.studentGroup', function ($builder) use ($groupId) {
            $builder->where('id', $groupId);
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
        $query->whereHas($relation, function ($builder) use ($field, $fieldValue) {
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
     * @param $dates
     */
    public function resultDateIn($query, $dates)
    {
        $query->where(function(EloquentBuilder $query) use ($dates) {

            array_map(function (string $date) use ($query) {

                $query->orWhereDate('created_at', Carbon::createFromFormat('d/m/Y', trim($date)));

            }, explode(',', $dates));
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
