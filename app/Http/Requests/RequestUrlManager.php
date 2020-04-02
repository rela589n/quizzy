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

    protected function resolveEntity(\Illuminate\Database\Eloquent\Builder $builder, bool $withTrashed = false)
    {
        if ($withTrashed) {
            $builder->withTrashed();
        }

        return $builder->firstOrFail();
    }

    /**
     * @param bool $withTrashed
     * @return TestSubject|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function getCurrentSubject(bool $withTrashed = false)
    {
        return singleVar($this->currentSubject, function () use ($withTrashed) {
            return $this->resolveEntity(
                TestSubject::whereSlug($this->request->route('subject')),
                $withTrashed
            );
        });
    }

    /**
     * @param bool $withTrashed
     * @return Test|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function getCurrentTest(bool $withTrashed = false)
    {
        return singleVar($this->currentTest, function () use ($withTrashed) {
            return $this->resolveEntity(
                Test::whereSlug($this->request->route('test')),
                $withTrashed
            );
        });
    }

    /**
     * @param bool $withTrashed
     * @return StudentGroup|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function getCurrentGroup(bool $withTrashed = false)
    {
        return singleVar($this->currentGroup, function () use ($withTrashed) {
            return $this->resolveEntity(
                StudentGroup::whereSlug($this->request->route('group')),
                $withTrashed
            );
        });
    }
}
