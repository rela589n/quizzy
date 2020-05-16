<?php

namespace App\Http\Controllers\Admin\Tests;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\RequestUrlManager;
use App\Http\Requests\Tests\CRUD\CreateTestRequest;
use App\Http\Requests\Tests\CRUD\UpdateTestRequest;
use App\Repositories\SubjectsRepository;
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
     * @param CreateTestService $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function newTest(CreateTestRequest $request, CreateTestService $service)
    {
        $currentSubject = $this->urlManager->getCurrentSubject();

        $service->ofSubject($currentSubject)
            ->handle($request);

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
     * @param UpdateTestService $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateTest(UpdateTestRequest $request, UpdateTestService $service)
    {
        $currentSubject = $this->urlManager->getCurrentSubject();
        $currentTest = $this->urlManager->getCurrentTest();

        $service->setTest($currentTest)
            ->handle($request);

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
