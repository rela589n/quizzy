<?php

namespace App\Http\Controllers\Client\Tests;

use App\Http\Controllers\Client\ClientController;
use App\Http\Requests\Tests\FinishTestRequest;
use App\Lib\TestResultsEvaluator;
use App\Models\AskedQuestion;
use App\Models\TestResult;
use Illuminate\Database\Eloquent\Collection;
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

        $answers = Collection::make();
        foreach ($askedQuestions as $askedQuestion) {
            $createdAnswers = $askedQuestion->answers()->createMany($validated['ans'][$askedQuestion->question_id]);
            $askedQuestion->setRelation('answers', $createdAnswers);
            $answers = $answers->concat($createdAnswers);
        }

        $evaluator = new TestResultsEvaluator($testResult);

        $evaluatedQuestions = $evaluator->evaluateEachQuestion();
        $wholeTest = $evaluator->evaluateWholeTest($evaluatedQuestions);
        $score = $evaluator->evaluateTestScore($wholeTest);
        $mark = $evaluator->putMark($score);

        return view('pages.client.pass-test-single-result', [
            'subject' => $currentTest->subject,
            'test' => $currentTest,
            'resultPercents' => round($score * 100, 2),
            'resultMark' => sprintf(
                '%d %s',
                $mark,
                declineCyrillicWord($mark, 'бал', ['', 'а', 'ів'])
            )
        ]);
    }
}
