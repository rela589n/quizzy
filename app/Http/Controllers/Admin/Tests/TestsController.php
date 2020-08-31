<?php

namespace App\Http\Controllers\Admin\Tests;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\RequestUrlManager;
use App\Http\Requests\Tests\CRUD\CreateTestRequest;
use App\Http\Requests\Tests\CRUD\UpdateTestRequest;
use App\Repositories\SubjectsRepository;
use App\Services\Subjects\IncludeTestsFormManager;
use App\Services\Tests\CreateTestService;
use App\Services\Tests\MarkPercentsMapCollector;
use App\Services\Tests\UpdateTestService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Session;

class TestsController extends AdminController
{
    private SubjectsRepository $subjectsRepository;

    public function __construct(RequestUrlManager $urlManager, SubjectsRepository $subjectsRepository)
    {
        parent::__construct($urlManager);
        $this->subjectsRepository = $subjectsRepository;
    }

    /**
     * @param  IncludeTestsFormManager  $includeTestsManager
     * @param  MarkPercentsMapCollector  $mapCollector
     * @return View
     * @throws AuthorizationException
     */
    public function showNewTestForm(
        IncludeTestsFormManager $includeTestsManager,
        MarkPercentsMapCollector $mapCollector
    ): View {
        $this->authorize('create-tests');

        $subject = $this->urlManager->getCurrentSubject();
        $toInclude = $this->subjectsRepository->subjectsToInclude($subject->department_ids);

        $includeTestsManager->setSubject($subject)
            ->transform($toInclude);

        $markPercents = $mapCollector->markPercents();

        return view(
            'pages.admin.tests-new',
            [
                'subject'               => $subject,
                'subjectsToIncludeFrom' => $toInclude,

                'marksPercentsMap' => $markPercents,
                'messageToUser'    => Session::pull('messageToUser'),
            ]
        );
    }

    public function newTest(
        CreateTestRequest $request,
        CreateTestService $service
    ): RedirectResponse {
        $currentSubject = $this->urlManager->getCurrentSubject();

        $service->ofSubject($currentSubject)
            ->handle($request->validated());

        return redirect()->route(
            'admin.tests.subject',
            [
                'subject' => $currentSubject->uri_alias
            ]
        );
    }

    /**
     * @param  IncludeTestsFormManager  $includeTestsManager
     * @param  MarkPercentsMapCollector  $mapCollector
     * @return View
     * @throws AuthorizationException
     */
    public function showUpdateTestForm(
        IncludeTestsFormManager $includeTestsManager,
        MarkPercentsMapCollector $mapCollector
    ): View {
        $test = $this->urlManager->getCurrentTest();
        $this->authorize('update', $test);

        $subject = $this->urlManager->getCurrentSubject();
        $toInclude = $this->subjectsRepository->subjectsToInclude($subject->department_ids);

        $includeTestsManager
            ->setTest($test)
            ->transform($toInclude);

        $markPercents = $mapCollector
            ->setTest($test)
            ->markPercents();

        return view(
            'pages.admin.tests-single-settings',
            [
                'test'    => $test,
                'subject' => $subject,

                'subjectsToIncludeFrom' => $toInclude,
                'marksPercentsMap'      => $markPercents,
                'messageToUser'         => Session::pull('messageToUser'),
            ]
        );
    }

    public function updateTest(
        UpdateTestRequest $request,
        UpdateTestService $service
    ): RedirectResponse
    {
        $currentSubject = $this->urlManager->getCurrentSubject();
        $currentTest = $this->urlManager->getCurrentTest();

        $service->setTest($currentTest)
            ->handle($request->validated());

        return redirect()->route(
            'admin.tests.subject.test',
            [
                'subject' => $currentSubject->uri_alias,
                'test'    => $currentTest->uri_alias
            ]
        );
    }

    /**
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws Exception
     */
    public function deleteTest(): RedirectResponse
    {
        $currentTest = $this->urlManager->getCurrentTest();
        $this->authorize('delete', $currentTest);

        $currentTest->delete();

        return redirect()->route(
            'admin.tests.subject',
            [
                'subject' => $this->urlManager->getCurrentSubject()->uri_alias
            ]
        );
    }
}
