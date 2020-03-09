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
        return $this->filterFilters($this->request->query());
    }

    protected function queryFilters()
    {
        return [

        ];
    }

    /**
     * @param TestResult $testResult
     * @param $value
     * @return bool
     */
    public function resultId($testResult, $value)
    {
        return $testResult->id == $value;
    }

    /**
     * @param TestResult $testResult
     * @param $groupId
     * @return bool
     */
    public function groupId($testResult, $groupId)
    {
        return $testResult->user->studentGroup->id == $groupId;
    }

    /**
     * @param TestResult $testResult
     * @param $userName
     * @return bool
     */
    public function name($testResult, $userName)
    {
        return str_contains($testResult->user->name, $userName);
    }

    /**
     * @param TestResult $testResult
     * @param $userSurname
     * @return bool
     */
    public function surname($testResult, $userSurname)
    {
        return str_contains($testResult->user->surname, $userSurname);
    }

    /**
     * @param TestResult $testResult
     * @param $userPatronymic
     * @return bool
     */
    public function patronymic($testResult, $userPatronymic)
    {
        return str_contains($testResult->user->patronymic, $userPatronymic);
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
