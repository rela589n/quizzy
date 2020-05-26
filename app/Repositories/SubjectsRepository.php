<?php


namespace App\Repositories;


use App\Models\Test;
use App\Models\TestSubject;
use App\Repositories\Commands\SubjectsToIncludeCommand;
use Illuminate\Database\Eloquent\Builder;

class SubjectsRepository
{
    /**
     * @var SubjectsToIncludeCommand
     */
    private $subjectsToInclude;

    public function __construct(SubjectsToIncludeCommand $subjectsToInclude)
    {
        $this->subjectsToInclude = $subjectsToInclude;
    }

    /**
     * @param array|null $departmentIds
     * @return \Illuminate\Database\Eloquent\Collection|TestSubject[]
     */
    public function subjectsToInclude(array $departmentIds = null)
    {
        $this->subjectsToInclude->setDepartmentIds($departmentIds);

        return $this->subjectsToInclude->execute();
    }

    public function subjectsForResults()
    {
        return TestSubject::whereHas('tests', function (Builder $query) {
            /**
             * @var $query Builder|Test
             */

            $query->withTrashed();
            $query->has('testResults');
        })->get();
    }
}
