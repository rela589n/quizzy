<?php

namespace App\Http\Controllers\Admin\Tests;

use App\Models\AnswerOption;
use App\Http\Controllers\Controller;
use App\Http\Requests\Questions\FillAnswersRequest;
use App\Http\Requests\RequestUrlManager;
use App\Models\Question;
use App\Models\Test;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public function showCreateUpdateForm(RequestUrlManager $urlManager, Request $request)
    {
        /**
         * @var \App\Models\Test $currentTest
         */
        $currentTest = $urlManager->getCurrentTest();
        $currentTest->loadMissing('nativeQuestions');
        $currentTest->nativeQuestions->load('answerOptions');

        // todo move into another class

        $deleted = array_flip(old("q.deleted", []));
        $fullQuestions = $currentTest->nativeQuestions->reject(function ($item) use ($deleted) {
            return isset($deleted["$item->id"]);
        })->map(function ($item) {
            return (object)[
                'id' => $item->id,
                'question' => $item->question,
                'answerOptions' => $item->answerOptions->map(function ($option) {
                    return (object)[
                        'id' => $option->id,
                        'is_right' => $option->is_right,
                        'text' => $option->text,
                    ];
                })->all(),
                'type' => 'modified'
            ];
        })->toBase()->merge(collect($request->old('q.new', []))->map(function ($newQuestion, $id) {
            return (object)[
                'id' => $id,
                'question' => $newQuestion['name'],
                'answerOptions' => collect($newQuestion['v'] ?? [])->map(function ($variant, $variantId) {
                    return (object)[
                        'id' => $variantId,
                        'is_right' => $variant['is_right'] ?? false,
                        'text' => $variant['text'] ?? '',
                    ];
                })->all(),
                'type' => 'new'
            ];
        }));

        return view('pages.admin.tests-single', [
            'subject' => $urlManager->getCurrentSubject(),
            'test' => $currentTest,
            'filteredQuestions' => $fullQuestions
        ]);
    }

    public function createUpdate(FillAnswersRequest $request)
    {
        return "Create and (or) update.";
    }
}
