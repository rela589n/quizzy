<?php

namespace App\Http\Controllers\Client\Tests;

use App\Http\Controllers\Client\ClientController;
use Illuminate\Http\Request;

class TestsController extends ClientController
{
    public function showSingleTestForm(Request $request)
    {
        $currentTest = $this->urlManager->getCurrentTest();
        $currentSubject = $this->urlManager->getCurrentSubject();

        $questions = $currentTest->allQuestions();
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
