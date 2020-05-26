<?php

namespace App\Http\Controllers\Admin\Results;

use App\Http\Requests\FilterTestResultsRequest;
use App\Http\Requests\RequestUrlManager;
use App\Lib\Filters\Eloquent\TestResultFilter;
use App\Http\Controllers\Admin\AdminController;
use App\Repositories\StudentGroupsRepository;
use App\Repositories\SubjectsRepository;
use App\Repositories\TestsRepository;

class TestResultsController extends AdminController
{
    /** @var TestsRepository */
    private $testsRepository;

    /**
     * TestResultsController constructor.
     * @param TestsRepository $testsRepository
     * @param RequestUrlManager $urlManager
     */
    public function __construct(TestsRepository $testsRepository, RequestUrlManager $urlManager)
    {
        $this->testsRepository = $testsRepository;

        parent::__construct($urlManager);
    }

    /**
     * @param SubjectsRepository $repository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showSelectSubjectPage(SubjectsRepository $repository)
    {
        return view('pages.admin.results-select-subject', [
            'subjects' => $repository->subjectsForResults()
        ]);
    }

    /**
     * @param TestsRepository $testsRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showSelectTestPage(TestsRepository $testsRepository)
    {
        return view('pages.admin.results-select-test', [
            'subject'      => $this->urlManager->getCurrentSubject(),
            'subjectTests' => $testsRepository->testsForResultPage()
        ]);
    }

    /**
     * @param FilterTestResultsRequest $request
     * @param TestResultFilter $filters
     * @param StudentGroupsRepository $groupsRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showTestResults(FilterTestResultsRequest $request,
                                    TestResultFilter $filters,
                                    StudentGroupsRepository $groupsRepository)
    {
        $currentSubject = $this->urlManager->getCurrentSubject();
        $currentTest = $this->urlManager->getCurrentTest(true);

        $filters->setQueryFilters($request->getQueryFilters());
        $filters->setFilters($request->getFilters());

        $filteredResults = $currentTest
            ->testResults()
            ->orderByDesc('id')
            ->filtered($filters)
            ->paginate(20)
            ->appends($request->query());

        return view('pages.admin.results-single', [
            'subject'     => $currentSubject,
            'test'        => $currentTest,
            'testResults' => $filteredResults,
            'userGroups'  => $groupsRepository->groupsWhereHasResultsOf($currentTest->id),
        ]);
    }
}
