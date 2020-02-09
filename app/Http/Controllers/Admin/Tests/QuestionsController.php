<?php

namespace App\Http\Controllers\Admin\Tests;

use App\Lib\transformers\QuestionsTransformer;
use App\Models\AnswerOption;
use App\Http\Controllers\Controller;
use App\Http\Requests\Questions\FillAnswersRequest;
use App\Http\Requests\RequestUrlManager;
use App\Models\Question;
use App\Models\Test;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public function showCreateUpdateForm(Request $request, RequestUrlManager $urlManager, QuestionsTransformer $transformer)
    {
        /**
         * @var Test $currentTest
         */
        $currentTest = $urlManager->getCurrentTest();
        $currentTest->loadMissing('nativeQuestions');
        $currentTest->nativeQuestions->load('answerOptions');

        $exclude = array_flip(old("q.deleted", []));

        $fullQuestions = collect($request->old('q.modified'))
            ->map(function ($modified, $id) use (&$exclude, $transformer) {
                $exclude["$id"] = 1;

                return $transformer->requestToDto($modified, [
                    'id' => $id,
                    'type' => 'modified'
                ]);
            });

        /*
         * Although we included modified from request, there may not be all entities
         * (We don't need send request to update entries that has not been updated)
         */
        $fullQuestions = $fullQuestions->concat(
            $currentTest->nativeQuestions->reject(
                function ($item) use ($exclude) {
                    return isset($exclude["$item->id"]);
                })
                ->map(function ($item) use ($transformer) {
                    return $transformer->modelToDto($item, [
                        'type' => 'modified'
                    ]);
                })
        );

        $fullQuestions = $fullQuestions->concat(
            collect($request->old('q.new', []))
                ->map(function ($newQuestion, $id) use ($transformer) {
                    return $transformer->requestToDto($newQuestion, [
                        'id' => $id,
                        'type' => 'new'
                    ]);
                })
        );

        return view('pages.admin.tests-single', [
            'subject' => $urlManager->getCurrentSubject(),
            'test' => $currentTest,
            'filteredQuestions' => $fullQuestions->all(),
            'message' => \Session::get('message'),
        ]);
    }

    public function createUpdate(FillAnswersRequest $request, RequestUrlManager $urlManager)
    {
        /**
         * @var Test $currentTest
         */
        $currentTest = $urlManager->getCurrentTest();
        $currentTest->loadMissing('nativeQuestions');

        $validated = $request->validated();

        $this->performCreate($currentTest, $validated['q']['new'] ?? []);
        $this->performModify($currentTest, $validated['q']['modified'] ?? []);
        $this->performDelete($validated['q']['deleted'] ?? []);

        return redirect()->back()->with('message', 'Збережено');
    }

    // todo remove duplicate
    private function performCreate(Test $currentTest, array $questions)
    {
        foreach ($questions as $id => $question) {
            /**
             * @var Question $new
             */
            $new = $currentTest->nativeQuestions()->save(new Question(['question' => $question['name']]));

            foreach ($question['v'] as $vId => $variant) {
                $new->answerOptions()->save(new AnswerOption([
                    'text' => $variant['text'],
                    'is_right' => boolval($variant['is_right'] ?? false)
                ]));
            }
        }
    }

    // todo remove duplicate
    private function performModify(Test $currentTest, array $questions)
    {
        foreach ($questions as $id => $question) {
            /**
             * @var Question $toModify
             */
            $toModify = $currentTest->nativeQuestions->find($id); //update(['toModify' => $modified['name']]);
            $toModify->question = $question['name'];
            $toModify->save();

            $toModify->answerOptions()->delete();

            foreach ($question['v'] as $vId => $variant) {
                $toModify->answerOptions()->save(new AnswerOption([
                    'text' => $variant['text'],
                    'is_right' => boolval($variant['is_right'] ?? false)
                ]));
            }
        }
    }

    private function performDelete(array $ids)
    {
        if (count($ids) > 0)
            Question::destroy($ids);
    }
}
