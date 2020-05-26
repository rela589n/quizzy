<?php


namespace App\Repositories;


use App\Models\StudentGroup;
use App\Models\TestResult;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class StudentGroupsRepository
{
    public function whereHasResultsOf(int $groupId, int $testId)
    {
        return $this->builderForResultsPage($testId)->findOrFail($groupId);
    }

    public function groupsWhereHasResultsOf(int $testId)
    {
        return $this->builderForResultsPage($testId)->orderByDesc('year')->get();
    }

    protected function builderForResultsPage(int $testId)
    {
        return StudentGroup::withTrashed()->whereHas('students', function (Builder $studentQuery) use ($testId) {
            /**
             * @var User|Builder $studentQuery
             */

            $studentQuery->withTrashed();

            $studentQuery->whereHas('testResults', function (Builder $resultQuery) use ($testId) {

                /**
                 * @var TestResult|Builder $resultQuery
                 */
                $resultQuery->whereTestId($testId);
            });

        });
    }
}
