<?php

namespace App\Http\Controllers\Client\Tests;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestUrlManager;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;

class TestsController extends Controller
{
    private $urlManager;

    /**
     * TestsController constructor.
     * @param RequestUrlManager $urlManager
     */
    public function __construct(RequestUrlManager $urlManager)
    {
        $this->urlManager = $urlManager;
    }

    public function showSingleTestForm(Request $request)
    {
        $currentTest = $this->urlManager->getCurrentTest();
        $currentSubject = $this->urlManager->getCurrentSubject();

        $questions = \Illuminate\Database\Eloquent\Collection::make($currentTest->allQuestions());
        $questions->loadMissing('answerOptions');

        return view('pages.client.tests-single', [
            'subject' => $currentSubject,
            'test' => $currentTest,
            'allQuestions' => $questions,
        ]);
    }

    public function finishTest(Request $request)
    {
        dd($request->all());
    }
}
