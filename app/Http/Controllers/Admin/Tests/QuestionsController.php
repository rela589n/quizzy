<?php

namespace App\Http\Controllers\Admin\Tests;

use App\Http\Controllers\Admin\AdminController;
use App\Lib\transformers\QuestionsTransformer;
use App\Models\AnswerOption;
use App\Http\Requests\Questions\FillAnswersRequest;
use App\Models\Question;
use App\Models\Test;
use Illuminate\Http\Request;

class QuestionsController extends AdminController
{
    public function showCreateUpdateForm(Request $request, QuestionsTransformer $transformer)
    {
        /**
         * @var Test $currentTest
         */
        $currentTest = $this->urlManager->getCurrentTest();
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
         * That is done on the front-end by js // todo
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

        $lastOptionId = $request->old('last-answer-option-id') ?? (AnswerOption::latest('id')->first()->id ?? 0);

        return view('pages.admin.tests-single', [
            'subject' => $this->urlManager->getCurrentSubject(),
            'test' => $currentTest,
            'filteredQuestions' => $fullQuestions->all(),
            'message' => \Session::get('message'),
            'lastAnswerOptionId' => $lastOptionId
        ]);
    }

    public function createUpdate(FillAnswersRequest $request)
    {
        /**
         * @var Test $currentTest
         */
        $currentTest = $this->urlManager->getCurrentTest();
        $currentTest->loadMissing('nativeQuestions');

        $validated = $request->validated();

        $this->performQuestionsDelete($validated['q']['deleted'] ?? []);
        $this->performVariantsDelete($validated['v']['deleted'] ?? []);

        $this->performCreate($currentTest, $validated['q']['new'] ?? []);
        $this->performModify($currentTest, $validated['q']['modified'] ?? []);

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
                    'is_right' => (int)(isset($variant['is_right']) ?? false)
                ]));
            }
        }
    }

    // todo remove duplicate
    private function performModify(Test $currentTest, array $questions)
    {
        $currentTest->loadMissing('nativeQuestions.answerOptions');

        foreach ($questions as $id => $question) {
            /**
             * @var Question $toModify
             */
            $toModify = $currentTest->nativeQuestions->find($id); //update(['toModify' => $modified['name']]);
            $toModify->question = $question['name'];
            $toModify->save();

            foreach ($question['v'] as $vId => $variant) {
                $option = $toModify->answerOptions->where('id', $vId)->first();

                if ($option === null) {
                    $option = new AnswerOption();
                    $option->question()->associate($toModify);
                }

                $option->text = $variant['text'];
                $option->is_right = (int)(isset($variant['is_right']) ?? false);

                $option->save();
            }
        }
    }

    private function performQuestionsDelete(array $ids)
    {
        if (count($ids) > 0) {
            Question::whereIn('id', $ids)->delete();
        }
    }

    private function performVariantsDelete(array $ids)
    {
        if (count($ids) > 0) {
            AnswerOption::whereIn('id', $ids)->delete();
        }
    }
}
