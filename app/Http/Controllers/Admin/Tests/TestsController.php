<?php

namespace App\Http\Controllers\Admin\Tests;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\RequestUrlManager;
use App\Http\Requests\Tests\CRUD\CreateTestRequest;
use App\Http\Requests\Tests\CRUD\UpdateTestRequest;
use App\Repositories\SubjectsRepository;
use App\Services\Subjects\IncludeTestsFormManager;
use App\Services\Tests\CreateTestService;
use App\Services\Tests\UpdateTestService;

class TestsController extends AdminController
{
    private $subjectsRepository;

    public function __construct(RequestUrlManager $urlManager, SubjectsRepository $subjectsRepository)
    {
        parent::__construct($urlManager);
        $this->subjectsRepository = $subjectsRepository;
    }

    /**
     * @param IncludeTestsFormManager $includeTestsManager
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showNewTestForm(IncludeTestsFormManager $includeTestsManager)
    {
        $this->authorize('create-tests');

        $subject = $this->urlManager->getCurrentSubject();
        $toInclude = $this->subjectsRepository->subjectsToInclude($subject->department_ids);

        $includeTestsManager->setSubject($subject)
            ->transform($toInclude);

        return view('pages.admin.tests-new', [
            'subject'               => $subject,
            'subjectsToIncludeFrom' => $toInclude
        ]);
    }

    /**
     * @param CreateTestRequest $request
     * @param CreateTestService $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function newTest(CreateTestRequest $request, CreateTestService $service)
    {
        $currentSubject = $this->urlManager->getCurrentSubject();

        $service->ofSubject($currentSubject)
            ->handle($request->validated());

        return redirect()->route('admin.tests.subject', [
            'subject' => $currentSubject->uri_alias
        ]);
    }

    /**
     * @param IncludeTestsFormManager $includeTestsManager
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showUpdateTestForm(IncludeTestsFormManager $includeTestsManager)
    {
        $test = $this->urlManager->getCurrentTest();
        $this->authorize('update', $test);

        $subject = $this->urlManager->getCurrentSubject();
        $toInclude = $this->subjectsRepository->subjectsToInclude($subject->department_ids);

        $includeTestsManager
            ->setTest($test)
            ->transform($toInclude);

        return view('pages.admin.tests-single-settings', [
            'test'    => $test,
            'subject' => $subject,

            'subjectsToIncludeFrom' => $toInclude,
        ]);
    }

    /**
     * @param UpdateTestRequest $request
     * @param UpdateTestService $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateTest(UpdateTestRequest $request, UpdateTestService $service)
    {
        $currentSubject = $this->urlManager->getCurrentSubject();
        $currentTest = $this->urlManager->getCurrentTest();

        $service->setTest($currentTest)
            ->handle($request->validated());

        return redirect()->route('admin.tests.subject.test', [
            'subject' => $currentSubject->uri_alias,
            'test'    => $currentTest->uri_alias
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

        return redirect()->route('admin.tests.subject', [
            'subject' => $this->urlManager->getCurrentSubject()->uri_alias
        ]);
    }
}
