<?php

namespace App\Http\Controllers\Admin\Results;

use App\Lib\Filters\Eloquent\TestResultFilter;
use App\Models\StudentGroup;
use App\Http\Controllers\Admin\AdminController;
use App\Models\TestSubject;
use Illuminate\Http\Request;

class TestResultsController extends AdminController
{
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showSelectTestPage()
    {
        $currentSubject = $this->urlManager->getCurrentSubject();

        $tests = $currentSubject->tests()
            ->withTrashed()
            ->whereHas('testResults')
            ->get();

        return view('pages.admin.results-select-test', [
            'subject'      => $currentSubject,
            'subjectTests' => $tests
        ]);
    }

    /**
     * @param Request $request
     * @param TestResultFilter $filters
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showTestResults(Request $request, TestResultFilter $filters)
    {
        $currentSubject = $this->urlManager->getCurrentSubject();
        $currentTest = $this->urlManager->getCurrentTest(true);

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
