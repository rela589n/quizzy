<?php

namespace App\Http\Controllers\Client\Tests;

use App\Http\Controllers\Client\ClientController;
use App\Http\Requests\Tests\Pass\FinishTestRequest;
use App\Models\AskedQuestion;
use App\Models\TestResult;
use Illuminate\Http\Request;

class TestsController extends ClientController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showSingleTestForm(Request $request)
    {
        $currentTest = $this->urlManager->getCurrentTest();
        $currentSubject = $currentTest->subject;

        $this->authorize('pass-test', $currentTest);

        $questions = $currentTest->allQuestions();
        $questions->loadMissing('answerOptions');

        return view('pages.client.tests-single', [
            'subject' => $currentSubject,
            'test' => $currentTest,
            'allQuestions' => $questions,
        ]);
    }

    /**
     * @param FinishTestRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function finishTest(FinishTestRequest $request)
    {
        $currentTest = $this->urlManager->getCurrentTest();

        $testResult = new TestResult();
        $testResult->test()->associate($currentTest);
        $testResult->user()->associate(\Auth::guard('client')->user());
        $testResult->save();

        $validated = $request->validated();

        /**
         * @var $askedQuestions AskedQuestion[]
         */
        $askedQuestions = $testResult->askedQuestions()->createMany($validated['asked']);
        $testResult->setRelation('askedQuestions', $askedQuestions);

        foreach ($askedQuestions as $askedQuestion) {
            $createdAnswers = $askedQuestion->answers()->createMany($validated['ans'][$askedQuestion->question_id]);
            $askedQuestion->setRelation('answers', $createdAnswers);
        }

        return view('pages.client.pass-test-single-result', [
            'subject' => $currentTest->subject,
            'test' => $currentTest,
            'resultPercents' => $testResult->score_readable,
            'resultMark' => $testResult->mark_readable
        ]);
    }
}
