<?php

namespace App\Http\Controllers\Admin\Tests;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\RequestUrlManager;
use App\Http\Requests\Tests\CRUD\CreateTestRequest;
use App\Http\Requests\Tests\CRUD\UpdateTestRequest;
use App\Lib\Filters\Common\IncludeTestsFilter;
use App\Lib\Transformers\Collection\IncludeTestsTransformer;
use App\Repositories\SubjectsRepository;

class TestsController extends AdminController
{
    private $subjectsRepository;

    public function __construct(RequestUrlManager $urlManager, SubjectsRepository $subjectsRepository)
    {
        parent::__construct($urlManager);
        $this->subjectsRepository = $subjectsRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showNewTestForm()
    {
        $this->authorize('create-tests');

        return view('pages.admin.tests-new', [
            'subject'               => $this->urlManager->getCurrentSubject(),
            'subjectsToIncludeFrom' => $this->subjectsRepository->subjectsToInclude()
        ]);
    }

    /**
     * @param CreateTestRequest $request
     * @param IncludeTestsFilter $filter
     * @param IncludeTestsTransformer $transformer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function newTest(CreateTestRequest $request, IncludeTestsFilter $filter, IncludeTestsTransformer $transformer)
    {
        /**
         * @var \App\Models\Test $newTest
         */

        $validated = $request->validated();

        $currentSubject = $this->urlManager->getCurrentSubject();
        $newTest = $currentSubject->tests()->create($request->validated());

        $includeTests = collect($validated['include'] ?? []);
        $includeTests = $filter->apply($includeTests); // remove not necessary and with empty count

        $includeTests[$newTest->id] = [ // todo remove duplicate
            'count' => "999"
        ];

        // normalize for eloquent
        $includeTests = $transformer->transform($includeTests);
        $newTest->tests()->attach($includeTests);

        return redirect()->route('admin.tests.subject', [
            'subject' => $currentSubject->uri_alias
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showUpdateTestForm()
    {
        $test = $this->urlManager->getCurrentTest();
        $this->authorize('update', $test);

        $subject = $this->urlManager->getCurrentSubject();

        return view('pages.admin.tests-single-settings', [
            'test'                  => $test,
            'subject'               => $subject,
            'subjectsToIncludeFrom' => $this->subjectsRepository->subjectsToInclude(),
        ]);
    }

    /**
     * @param UpdateTestRequest $request
     * @param IncludeTestsFilter $filter
     * @param IncludeTestsTransformer $transformer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateTest(UpdateTestRequest $request, IncludeTestsFilter $filter, IncludeTestsTransformer $transformer)
    {
        $validated = $request->validated();

        $currentSubject = $this->urlManager->getCurrentSubject();
        $currentTest = $this->urlManager->getCurrentTest();

        $currentTest->update($validated);

        $includeTests = collect($validated['include'] ?? []);
        $includeTests = $filter->apply($includeTests); // remove not necessary and with empty count

        if (!isset($validated['include'][$currentTest->id])) {
            $includeTests[$currentTest->id] = [ // todo remove duplicate
                'count' => "999"
            ];
        }

        // normalize for eloquent
        $includeTests = $transformer->transform($includeTests);
        $currentTest->tests()->sync($includeTests);

        return redirect()->route('admin.tests.subject.test', [
            'subject' => $currentSubject['uri_alias'],
            'test'    => $currentTest['uri_alias']
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function deleteTest()
    {
        $currentTest = $this->urlManager->getCurrentTest();
        $this->authorize('delete', $currentTest);

        $currentTest->delete();
        $currentSubject = $this->urlManager->getCurrentSubject();

        return redirect()->route('admin.tests.subject', [
            'subject' => $currentSubject['uri_alias']
        ]);
    }
}
