<?php

namespace App\Http\Controllers\Admin\Tests;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestUrlManager;
use App\Http\Requests\Tests\CreateTestRequest;
use App\Test;
use Illuminate\Http\Request;

class TestsController extends Controller
{
    public function showNewTestForm(RequestUrlManager $urlManager)
    {
        /**
         * @var  \App\TestSubject $subject
         */

        $subject = $urlManager->getCurrentSubject();

        $tests = $subject->tests()->has('nativeQuestions')
            ->withCount('nativeQuestions as questions_count')->get();


        return view('pages.admin.tests-new', ['includeTests' => $tests]);
    }

    public function newTest(CreateTestRequest $request, RequestUrlManager $urlManager)
    {
        /**
         * @var \App\Test $newTest
         */

        $validated = $request->validated();

        // todo move this logic into another class
        $includeTests = array_filter($validated['include'] ?? [], function ($v) {
            return !empty($v['count']);
        });

        $includeTests = array_map(
            function ($value) {
                return [
                    'questions_quantity' => $value['count']
                ];
            },
            $includeTests
        );

        $currentSubject = $urlManager->getCurrentSubject();
        $newTest = $currentSubject->tests()->create($request->validated());
        $newTest->tests()->attach($includeTests);

        return redirect()->route('admin.tests.subject.test', [
            'subject' => $currentSubject->uri_alias,
            'test' => $newTest->uri_alias
        ]);
    }

    public function showUpdateTestForm(Request $request, RequestUrlManager $urlManager)
    {
        $test = $urlManager->getCurrentTest();

        return view('pages.admin.tests-single-settings', [
            'test' => $test
        ]);
    }
}
