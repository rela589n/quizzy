<?php


namespace App\Http\Requests;


use App\Models\StudentGroup;
use App\Models\Test;
use App\Models\TestSubject;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
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

    /**
     * @return TestSubject|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function getCurrentSubject()
    {
        if ($this->currentSubject === null) {
            $this->currentSubject = TestSubject::where(
                'uri_alias',
                '=',
                $this->request->route('subject')
            )->firstOrFail();
        }

        return $this->currentSubject;
    }

    /**
     * @return Test|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function getCurrentTest()
    {
        if ($this->currentTest === null) {
            $this->currentTest = Test::where(
                'uri_alias',
                '=',
                $this->request->route('test')
            )->firstOrFail();
        }

        return $this->currentTest;
    }

    public function getCurrentGroup()
    {
        if ($this->currentGroup === null) {
            $this->currentGroup = StudentGroup::where(
                'uri_alias',
                '=',
                $this->request->route('group')
            )->firstOrFail();
        }

        return $this->currentGroup;
    }
}
