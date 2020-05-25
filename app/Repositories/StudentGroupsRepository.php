<?php


namespace App\Repositories;


use App\Models\StudentGroup;
use App\Models\TestResult;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class StudentGroupsRepository
{
    public function withResultsOf(int $id, int $testId)
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

        })->findOrFail($id);
    }
}
