<?php

namespace App\Http\Controllers\Admin\Tests;

use App\Http\Controllers\Admin\AdminController;
use App\Lib\Transformers\QuestionsTransformer;
use App\Models\AnswerOption;
use App\Http\Requests\Questions\FillAnswersRequest;
use App\Models\Test;
use App\Services\AnswerOptions\DeleteAnswerOptionsService;
use App\Services\Questions\DeleteQuestionsService;
use App\Services\Questions\Store\Multiple\CreateQuestionsService;
use App\Services\Questions\Store\Multiple\UpdateQuestionsService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class QuestionsController extends AdminController
{
    /**
     * @param Request $request
     * @param QuestionsTransformer $transformer
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws AuthorizationException
     */
    public function showCreateOrUpdateForm(Request $request, QuestionsTransformer $transformer)
    {
        $currentTest = $this->urlManager->getCurrentTest();

        try {
            return $this->showUpdateForm($request, $transformer, $currentTest);
        } catch (AuthorizationException $e) {
            return $this->showReadOnlyView($request, $currentTest);
        }
    }

    /**
     * @param Request $request
     * @param QuestionsTransformer $transformer
     * @param Test $currentTest
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws AuthorizationException
     */
    public function showUpdateForm(Request $request, QuestionsTransformer $transformer, Test $currentTest)
    {
        $this->authorize('update', $currentTest);

        $currentTest->loadMissing('nativeQuestions.answerOptions'); // todo dependency loader
//        $currentTest->nativeQuestions->load('answerOptions');

        $exclude = array_flip(old("q.deleted", []));

        $fullQuestions = collect($request->old('q.modified'))
            ->map(function ($modified, $id) use (&$exclude, $transformer) {
                $exclude["$id"] = true;

                return $transformer->requestToDto($modified, [
                    'id'   => $id,
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
                        'id'   => $id,
                        'type' => 'new'
                    ]);
                })
        );

        $lastOptionId = $request->old('last-answer-option-id') ?? (AnswerOption::latest('id')->first()->id ?? 0);

        return view('pages.admin.tests-single', [
            'subject'            => $this->urlManager->getCurrentSubject(),
            'test'               => $currentTest,
            'filteredQuestions'  => $fullQuestions->all(),
            'messageToUser'      => \Session::pull('messageToUser'),
            'lastAnswerOptionId' => $lastOptionId
        ]);
    }

    /**
     * @param Request $request
     * @param Test $currentTest
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws AuthorizationException
     */
    public function showReadOnlyView(Request $request, Test $currentTest)
    {
        $this->authorize('view', $currentTest);

        $currentTest->loadMissing('nativeQuestions.answerOptions');

        return view('pages.admin.tests-single-read-only', [
            'subject' => $this->urlManager->getCurrentSubject(),
            'test'    => $currentTest,
        ]);
    }

    /**
     * @param FillAnswersRequest $request
     * @param DeleteQuestionsService $deleteQuestionsService
     * @param DeleteAnswerOptionsService $deleteAnswerOptionsService
     * @param CreateQuestionsService $createQuestionsService
     * @param UpdateQuestionsService $updateQuestionsService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(FillAnswersRequest $request,
                                   DeleteQuestionsService $deleteQuestionsService,
                                   DeleteAnswerOptionsService $deleteAnswerOptionsService,
                                   CreateQuestionsService $createQuestionsService,
                                   UpdateQuestionsService $updateQuestionsService)
    {
        $currentTest = $this->urlManager->getCurrentTest();

        $deleteQuestionsService->handle($request->questionsToDelete());
        $deleteAnswerOptionsService->handle($request->answerOptionsToDelete());

        $createQuestionsService->ofTest($currentTest)
            ->handle($request->questionsToCreate());

        $updateQuestionsService->ofTest($currentTest)
            ->handle($request->questionsToUpdate());

        return redirect()->back()->with('message', 'Збережено');
    }
}
