<?php

namespace App\Http\Controllers\Admin\Tests;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Subjects\CreateSubjectRequest;
use App\Http\Requests\Subjects\UpdateSubjectRequest;
use App\Http\Requests\UrlManageable;
use App\Http\Requests\UrlManageableRequests;
use App\Models\TestSubject;

class SubjectsController extends AdminController implements UrlManageable
{
    use UrlManageableRequests;

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

    public function showSingleSubject()
    {
        $subject = $this->urlManager->getCurrentSubject();
        $subject->tests->loadCount('nativeQuestions as questions_count');
        // because in view we use $test->subject->uri_alias, which cause duplicated queries
        $subject->tests->loadMissing('subject');

        return view('pages.admin.subjects-single', [
            'subject' => $subject
        ]);
    }

    public function showUpdateSubjectForm()
    {
        return view('pages.admin.subjects-single-settings', [
            'subject' => $this->urlManager->getCurrentSubject()
        ]);
    }

    public function updateSubject(UpdateSubjectRequest $request)
    {
        $subject = $this->urlManager->getCurrentSubject();
        $subject->update($request->validated());

        return redirect()->route('admin.tests.subject', [
            'subject' => $subject['uri_alias']
        ]);
    }

    public function deleteSubject()
    {
        $subject = $this->urlManager->getCurrentSubject();
        $subject->delete();

        return redirect()->route('admin.tests');
    }
}
