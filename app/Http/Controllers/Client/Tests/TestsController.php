<?php

namespace App\Http\Controllers\Client\Tests;

use App\Http\Controllers\Client\ClientController;
use App\Http\Requests\Tests\Pass\PassTestRequest;
use App\Lib\Tests\Pass\Exceptions\PassTestSessionDoesntExists;
use App\Lib\Tests\Pass\Exceptions\QuestionsRanOutException;
use App\Lib\Tests\Pass\Exceptions\TimeIsUpException;
use App\Lib\Tests\Pass\PassTestService;
use App\Lib\Tests\Pass\TestResultDto;
use App\Models\Test;
use App\Models\User;
use Auth;
use Webmozart\Assert\Assert;

class TestsController extends ClientController
{
    public function showSingleTestForm()
    {
        $currentTest = $this->urlManager->getCurrentTest();

        if ($currentTest->shouldDisplayAllQuestions()) {
            return $this->displayAllQuestions();
        }

        if ($currentTest->shouldDisplayOneByOneQuestions()) {
            return $this->displayCurrentQuestionOrRedirectToResult();
        }

        throw new \RuntimeException("Unknown Test Display Strategy: ".$currentTest->display_strategy);
    }

    private function displayAllQuestions()
    {
        /** @var User $user */
        $user = Auth::guard('client')->user();
        $test = $this->urlManager->getCurrentTest();
        $subject = $test->subject;
        $service = PassTestService::startPassage($user, $test);

        $allQuestions = $service->getAllQuestions();
        $remainingTime = $service->remainingTime();

        return view(
            'pages.client.tests-single',
            compact('test', 'subject', 'allQuestions', 'remainingTime'),
        );
    }

    private function displayCurrentQuestionOrRedirectToResult()
    {
        /** @var User $user */
        $user = Auth::guard('client')->user();
        $test = $this->urlManager->getCurrentTest();

        try {
            return $this->displayCurrentQuestion($user, $test);
        } catch (QuestionsRanOutException | TimeIsUpException $e) {
            return redirect()->action(
                [self::class, 'showResultPage'],
                [
                    'subject' => $test->subject->uri_alias,
                    'test'    => $test->uri_alias,
                    'result'  => $e->getTestResult()->id,
                ]
            );
        }
    }

    private function displayCurrentQuestion(User $user, Test $test)
    {
        $subject = $test->subject;

        $service = PassTestService::continuePassage($user, $test);
        $question = $service->currentQuestion();
        $remainingTime = $service->remainingTime();
        $questionIndex = $service->currentQuestionIndex();

        return view(
            'pages.client.tests-single-by-one-question',
            compact('subject', 'test', 'questionIndex', 'question', 'remainingTime'),
        );
    }

    public function storeQuestionResponse(PassTestRequest $request)
    {
        /** @var User $user */
        $user = Auth::guard('client')->user();
        $test = $this->urlManager->getCurrentTest();

        $service = PassTestService::continuePassage($user, $test);

        $askedQuestions = TestResultDto::createFromRequest($request)->getAskedQuestions();
        Assert::count($askedQuestions, 1);
        $service->addQuestionResponse($askedQuestions->first());

        return redirect()->action(
            [self::class, 'showSingleTestForm'],
            ['subject' => $test->subject->uri_alias, 'test' => $test->uri_alias],
        );
    }

    public function finishTest(PassTestRequest $request)
    {
        /** @var User $user */
        $user = Auth::guard('client')->user();
        $currentTest = $this->urlManager->getCurrentTest();

        $service = PassTestService::continueStrict($user, $currentTest);
        try {
            $service->persistTemporaryResult(TestResultDto::createFromRequest($request));
            $testResult = $service->finishTest();
        } catch (PassTestSessionDoesntExists $e) {
            $testResult = $e->getTest()
                ->testResults()
                ->where('user_id', $e->getUser()->id)
                ->latest()
                ->first();

            if (null === $testResult) {
                throw $e;
            }
        }

        return redirect()->action(
            [self::class, 'showResultPage'],
            [
                'subject' => $currentTest->subject->uri_alias,
                'test'    => $currentTest->uri_alias,
                'result'  => $testResult->id,
            ]
        );
    }

    public function cancelPassage()
    {
        /** @var User $user */
        $user = Auth::guard('client')->user();
        $currentTest = $this->urlManager->getCurrentTest();

        $service = PassTestService::continuePassage($user, $currentTest);
        $service->endSession();

        return response()->json();
    }

    public function showResultPage()
    {
        $currentTest = $this->urlManager->getCurrentTest();
        $testResult = $this->urlManager->getCurrentTestResult();
        $this->authorize('view', $testResult);

        $testResult->score_readable;
        $testResult->mark;
        $testResult->mark_readable;

        return view(
            'pages.client.pass-test-single-result',
            [
                'subject'        => $currentTest->subject,
                'test'           => $currentTest,
                'resultPercents' => $testResult->score_readable,
                'resultMark'     => $testResult->mark_readable
            ]
        );
    }
}
