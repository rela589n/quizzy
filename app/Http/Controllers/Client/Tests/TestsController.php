<?php

namespace App\Http\Controllers\Client\Tests;

use App\Http\Controllers\Client\ClientController;
use App\Http\Requests\Tests\Pass\FinishTestRequest;
use App\Models\AskedQuestion;
use App\Models\TestResult;
use Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\View\View;

class TestsController extends ClientController
{
    /**
     * @return View
     * @throws AuthorizationException
     */
    public function showSingleTestForm(): View
    {
        $currentTest = $this->urlManager->getCurrentTest();
        $currentSubject = $currentTest->subject;

        $this->authorize('pass-test', $currentTest);

        $questions = $currentTest->allQuestions();
        $questions->loadMissing(['answerOptions' => static function (Relation $q) {
            $q->inRandomOrder();
        }]);

        return view('pages.client.tests-single', [
            'subject'      => $currentSubject,
            'test'         => $currentTest,
            'allQuestions' => $questions,
        ]);
    }

    /**
     * @param FinishTestRequest $request
     * @return View
     */
    public function finishTest(FinishTestRequest $request): View
    {
        $currentTest = $this->urlManager->getCurrentTest();

        $testResult = new TestResult();
        $testResult->test()->associate($currentTest);
        $testResult->user()->associate(Auth::guard('client')->user());
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
            'subject'        => $currentTest->subject,
            'test'           => $currentTest,
            'resultPercents' => $testResult->score_readable,
            'resultMark'     => $testResult->mark_readable
        ]);
    }
}
