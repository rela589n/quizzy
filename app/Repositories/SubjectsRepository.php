<?php


namespace App\Repositories;


use App\Models\Test;
use App\Models\TestSubject;
use App\Repositories\Commands\SubjectsToIncludeCommand;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class SubjectsRepository
{
    private SubjectsToIncludeCommand $subjectsToInclude;

    public function __construct(SubjectsToIncludeCommand $subjectsToInclude)
    {
        $this->subjectsToInclude = $subjectsToInclude;
    }

    /**
     * @param  array|null  $departmentIds
     * @return Collection|TestSubject[]
     */
    public function subjectsToInclude(array $departmentIds = null)
    {
        $this->subjectsToInclude->setDepartmentIds($departmentIds);

        return $this->subjectsToInclude->execute();
    }

    public function subjectsForResults()
    {
        return TestSubject::whereHas(
            'tests',
            static function (Builder $query) {
                /**
                 * @var $query Builder|Test
                 */

                $query->withTrashed();
                $query->has('testResults');
            }
        )->get();
    }
}
