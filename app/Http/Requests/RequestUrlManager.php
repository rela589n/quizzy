<?php


namespace App\Http\Requests;


use App\Test;
use App\TestSubject;
use Illuminate\Http\Request;

class RequestUrlManager
{
    protected $request;
    /**
     * @var \App\TestSubject
     */
    protected $currentSubject = null;
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
     * @return \Illuminate\Database\Eloquent\Model|object|null
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
