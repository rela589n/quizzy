<?php

namespace App\Http\Controllers\Admin\Tests;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\RequestUrlManager;
use App\Http\Requests\Subjects\CreateSubjectRequest;
use App\Http\Requests\Subjects\UpdateSubjectRequest;
use App\Models\TestSubject;

class SubjectsController extends AdminController
{
    public function showNewSubjectForm()
    {
        return view('pages.admin.subjects-new');
    }

    public function showAll()
    {
        return view('pages.admin.subjects-list', [
            'subjects' => TestSubject::withCount('tests')->get()
        ]);
    }

    public function newSubject(CreateSubjectRequest $request)
    {
        $validated = $request->validated();
        TestSubject::create($validated);

        return redirect()->route('admin.tests.subject', [
            'subject' => $validated['uri_alias']
        ]);
    }

    public function showSingleSubject(RequestUrlManager $urlManager)
    {
        $subject = $urlManager->getCurrentSubject();
        $subject->tests->loadCount('nativeQuestions as questions_count');
        // because in view we use $test->subject->uri_alias, which cause duplicated queries
        $subject->tests->loadMissing('subject');

        return view('pages.admin.subjects-single', [
            'subject' => $subject
        ]);
    }

    public function showUpdateSubjectForm(RequestUrlManager $urlManager)
    {
        return view('pages.admin.subjects-single-settings', [
            'subject' => $urlManager->getCurrentSubject()
        ]);
    }

    public function updateSubject(UpdateSubjectRequest $request, RequestUrlManager $urlManager)
    {
        $subject = $urlManager->getCurrentSubject();
        $subject->update($request->validated());

        return redirect()->route('admin.tests.subject', [
            'subject' => $subject['uri_alias']
        ]);
    }
}
