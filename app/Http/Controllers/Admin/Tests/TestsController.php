<?php

namespace App\Http\Controllers\Admin\Tests;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\RequestUrlManager;
use App\Http\Requests\Tests\CreateManageTestRequest;
use App\Http\Requests\Tests\UpdateManageTestRequest;
use Illuminate\Http\Request;

class TestsController extends AdminController
{

    public function showNewTestForm()
    {
        /**
         * @var  \App\Models\TestSubject $subject
         */

        $subject = $this->urlManager->getCurrentSubject();

        $tests = $subject->tests()->has('nativeQuestions')
            ->withCount('nativeQuestions as questions_count')->get();


        return view('pages.admin.tests-new', ['includeTests' => $tests]);
    }

    public function newTest(CreateManageTestRequest $request)
    {
        /**
         * @var \App\Models\Test $newTest
         */

        $validated = $request->validated();

        $currentSubject = $this->urlManager->getCurrentSubject();
        $newTest = $currentSubject->tests()->create($request->validated());


        // todo move this logic into another class and remove duplication
        $includeTests = array_filter($validated['include'] ?? [], function ($v) {
            return !empty($v['count']) && isset($v['necessary']);
        });

        $includeTests[$newTest->id] = [
            'count' => 999
        ];

        $includeTests = array_map(
            function ($value) {
                return [
                    'questions_quantity' => $value['count']
                ];
            },
            $includeTests
        );

        $newTest->tests()->attach($includeTests);

        return redirect()->route('admin.tests.subject.test', [
            'subject' => $currentSubject->uri_alias,
            'test' => $newTest->uri_alias
        ]);
    }

    public function showUpdateTestForm(Request $request)
    {
        //todo add field include self
        $test = $this->urlManager->getCurrentTest();
        $subject = $this->urlManager->getCurrentSubject();

        return view('pages.admin.tests-single-settings', [
            'test' => $test,
            'includeTests' => $subject->tests()->has('nativeQuestions')
                ->withCount('nativeQuestions as questions_count')
                ->get()
        ]);
    }

    public function updateTest(UpdateManageTestRequest $request)
    {
        $validated = $request->validated();

        $currentSubject = $this->urlManager->getCurrentSubject();
        $currentTest = $this->urlManager->getCurrentTest();

        $currentTest->update($validated);

        // todo move this logic into another class and remove duplication
        $includeTests = array_filter($validated['include'] ?? [], function ($v) {
            return !empty($v['count']) && isset($v['necessary']);
        });

        $includeTests = array_map(
            function ($value) {
                return [
                    'questions_quantity' => $value['count']
                ];
            },
            $includeTests
        );

        $currentTest->tests()->sync($includeTests);

        return redirect()->route('admin.tests.subject.test', [
            'subject' => $currentSubject['uri_alias'],
            'test' => $currentTest['uri_alias']
        ]);
    }
}
