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
            'filteredQuestions' => $fullQuestions->all()
        ]);
    }

    public function createUpdate(FillAnswersRequest $request, RequestUrlManager $urlManager)
    {
        /**
         * @var Test $currentTest
         */
        $currentTest = $urlManager->getCurrentTest();
//        $currentTest->loadMissing('nativeQuestions');
//        $currentTest->nativeQuestions->load('answerOptions');

        $validated = $request->validated();

        /**
         * @var Question[] $new
         */
        $new = [];
        foreach ($validated['q']['new'] ?? [] as $id => $question) {

            $new[$id] = new Question(['question' => $question['name']]);
            $currentTest->nativeQuestions()->save($new[$id]);

            /**
             * @var AnswerOption[] $options
             */
            $options = [];
            foreach ($question['v'] as $vId => $variant) {
                $options[$vId] = new AnswerOption([
                    'text' => $variant['text'],
                    'is_right' => boolval($variant['is_right'] ?? false)
                ]);

                $new[$id]->answerOptions()->save($options[$vId]);
//                $options[$vId]->question()->associate($new[$id]);
            }

//            $new[$id]->answerOptions()->saveMany($options);
        }


        $this->performModify($currentTest, $validated['q']['modified'] ?? []);
        $this->performDelete($validated['q']['deleted'] ?? []);

        log_r($validated);
        return "Create and (or) update.";
    }

    private function performDelete(array $ids)
    {
        if (count($ids) > 0)
            Question::destroy($ids);
    }

    private function performModify(Test $current, array $modified)
    {
        foreach ($modified as $id => $question) {

        }
    }
}
