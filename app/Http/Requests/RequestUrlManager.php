<?php


namespace App\Http\Requests;


use App\Models\StudentGroup;
use App\Models\Test;
use App\Models\TestSubject;
use Illuminate\Http\Request;

class RequestUrlManager
{
    protected $request;

    /**
     * @var TestSubject
     */
    protected $currentSubject = null;

    /**
     * @var Test
     */
    protected $currentTest = null;

    /**
     * @var StudentGroup
     */
    protected $currentGroup = null;

    /**
     * RequestUrlManager constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function resolveEntity(&$property, \Illuminate\Database\Eloquent\Builder $builder, bool $withTrashed = false)
    {
        if ($property === null) {
            if ($withTrashed) {
                $builder->withTrashed();
            }

            $property = $builder->firstOrFail();
        }

        return $property;
    }

    /**
     * @return TestSubject|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function getCurrentSubject()
    {
        return $this->resolveEntity($this->currentSubject, TestSubject::where(
            'uri_alias',
            '=',
            $this->request->route('subject')
        ));
    }

    /**
     * @param bool $withTrashed
     * @return Test|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function getCurrentTest(bool $withTrashed = false)
    {
        return $this->resolveEntity($this->currentTest, Test::where(
            'uri_alias',
            '=',
            $this->request->route('test')
        ), $withTrashed);
    }

    public function getCurrentGroup()
    {
        return $this->resolveEntity($this->currentGroup, StudentGroup::where(
            'uri_alias',
            '=',
            $this->request->route('group')
        ));
    }
}
