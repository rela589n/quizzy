<?php

namespace App\Http\Controllers\Admin\Results;

use App\Http\Requests\FilterTestResults\FilterTestResultsRequest;
use App\Lib\Filters\Eloquent\TestResultFilter;
use App\Http\Controllers\Admin\AdminController;
use App\Repositories\StudentGroupsRepository;
use App\Repositories\SubjectsRepository;
use App\Repositories\TestsRepository;
use App\Services\TestResults\MarksCollector;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class TestResultsController extends AdminController
{
    public function showSelectSubjectPage(SubjectsRepository $repository): View
    {
        return view('pages.admin.results-select-subject', [
            'subjects' => $repository->subjectsForResults()
        ]);
    }

    public function showSelectTestPage(TestsRepository $testsRepository): View
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
     * @param MarksCollector $marksCollector
     * @return View
     * @throws BindingResolutionException
     */
    public function showTestResults(FilterTestResultsRequest $request,
                                    TestResultFilter $filters,
                                    StudentGroupsRepository $groupsRepository,
                                    MarksCollector $marksCollector): View
    {
        $currentSubject = $this->urlManager->getCurrentSubject();
        $currentTest = $this->urlManager->getCurrentTest(true);

        $filters->setQueryFilters($request->getQueryFilters());
        $filters->setFilters($request->getFilters());

        $filteredResults = $currentTest
            ->testResults()
            ->orderByDesc('id')
            ->filtered($filters, static function (Collection $results) use ($currentTest) {
                $results->setRelation('test', $currentTest);
            })
            ->paginate(20)
            ->appends($request->query());

        return view('pages.admin.results-single', [
            'subject'     => $currentSubject,
            'test'        => $currentTest,
            'testResults' => $filteredResults,
            'userGroups'  => $groupsRepository->groupsWhereHasResultsOf($currentTest->id),
            'possibleMarks' => $marksCollector->setTest($currentTest)->collect(),
        ]);
    }
}
