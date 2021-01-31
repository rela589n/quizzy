<?php


namespace App\Http\Requests;


use App\Models\Department;
use App\Models\StudentGroup;
use App\Models\Test;
use App\Models\TestResult;
use App\Models\TestSubject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class RequestUrlManager
{
    protected Request $request;
    protected ?TestSubject $currentSubject = null;
    protected ?Test $currentTest = null;
    protected ?StudentGroup $currentGroup = null;
    protected ?Department $currentDepartment = null;
    protected ?TestResult $currentResult = null;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function resolveEntity(Builder $builder, bool $withTrashed = false)
    {
        if ($withTrashed) {
            $builder->withTrashed();
        }

        return $builder->firstOrFail();
    }

    /**
     * @param  bool  $withTrashed
     * @return TestSubject|Builder|Model
     */
    public function getCurrentSubject(bool $withTrashed = false): TestSubject
    {
        return singleVar(
            $this->currentSubject,
            function () use ($withTrashed) {
                return $this->resolveEntity(
                    TestSubject::whereSlug($this->request->route('subject')),
                    $withTrashed
                );
            }
        );
    }

    /**
     * @param  bool  $withTrashed
     * @return Test|Builder|Model
     */
    public function getCurrentTest(bool $withTrashed = false): Test
    {
        return singleVar(
            $this->currentTest,
            function () use ($withTrashed) {
                return $this->resolveEntity(
                    Test::whereSlug($this->request->route('test')),
                    $withTrashed
                );
            }
        );
    }

    /**
     * @param  bool  $withTrashed
     * @return StudentGroup|Builder|Model
     */
    public function getCurrentGroup(bool $withTrashed = false)
    {
        return singleVar(
            $this->currentGroup,
            function () use ($withTrashed) {
                return $this->resolveEntity(
                    StudentGroup::whereSlug($this->request->route('group')),
                    $withTrashed
                );
            }
        );
    }

    /**
     * @param  bool  $withTrashed
     * @return Department|Builder|Model
     */
    public function getCurrentDepartment(bool $withTrashed = false)
    {
        return singleVar(
            $this->currentDepartment,
            function () use ($withTrashed) {
                return $this->resolveEntity(
                    Department::whereUriAlias($this->request->route('department')),
                    $withTrashed
                );
            }
        );
    }

    public function getCurrentTestResult(): TestResult
    {
        return singleVar(
            $this->currentResult,
            function () {
                return $this->resolveEntity(
                    TestResult::whereId($this->request->route('result'))
                );
            }
        );
    }
}
