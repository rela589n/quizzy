<?php


namespace App\Http\Requests;


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
}
