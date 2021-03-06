<?php


namespace App\Repositories\Commands;


use App\Models\TestSubject;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Relations\Relation;

class SubjectsToIncludeCommand
{
    /**
     * @var EloquentBuilder
     */
    protected $builder;

    protected ?array $departmentIds;

    public function setDepartmentIds(array $departmentIds): self
    {
        $this->departmentIds = $departmentIds;

        return $this;
    }

    public function __construct(array $departmentIds = null)
    {
        $this->builder = TestSubject::query();
        $this->departmentIds = $departmentIds;
    }

    public function execute(): EloquentCollection
    {
        $this->handleDepartments();
        $this->loadTests();

        return $this->applyFilters($this->builder->get());
    }

    protected function handleDepartments(): void
    {
        if ($this->departmentIds !== null) {
            $this->builder->whereHas(
                'departments',
                function (EloquentBuilder $query) {
                    $query->whereIn('id', $this->departmentIds);
                }
            );
        }
    }

    protected function loadTests(): void
    {
        $this->builder->with(
            [
                'tests' => static function (Relation $query) {
                    $query->has('nativeQuestions')
                        ->withCount('nativeQuestions as questions_count');
                }
            ]
        );
    }

    protected function applyFilters(EloquentCollection $results): EloquentCollection
    {
        return $results->filter(
            static function (TestSubject $result) {
                return count($result->tests);
            }
        );
    }
}
