<?php

namespace App\Http\Controllers\Admin\Results;

use App\Http\Requests\FilterTestResultsRequest;
use App\Http\Requests\RequestUrlManager;
use App\Lib\Filters\Eloquent\TestResultFilter;
use App\Models\StudentGroup;
use App\Http\Controllers\Admin\AdminController;
use App\Models\TestSubject;
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showSelectSubjectPage()
    {
        return view('pages.admin.results-select-subject', [ // todo
            'subjects' => TestSubject::whereHas('tests', function ($query) {
                $query->withTrashed();
                $query->has('testResults');
            })->get()
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showTestResults(FilterTestResultsRequest $request, TestResultFilter $filters)
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
            'userGroups'  => StudentGroup::withTrashed()->get()
        ]);
    }
}
