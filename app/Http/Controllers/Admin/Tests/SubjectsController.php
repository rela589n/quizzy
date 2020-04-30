<?php

namespace App\Http\Controllers\Admin\Tests;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Subjects\CreateSubjectRequest;
use App\Http\Requests\Subjects\UpdateSubjectRequest;
use App\Models\TestSubject;

class SubjectsController extends AdminController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showAll()
    {
        $this->authorize('access-subjects');

        return view('pages.admin.subjects-list', [
            'subjects' => TestSubject::withCount('tests')->get()
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showNewSubjectForm()
    {
        $this->authorize('create-subjects');

        return view('pages.admin.subjects-new');
    }

    /**
     * @param CreateSubjectRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function newSubject(CreateSubjectRequest $request)
    {
        $validated = $request->validated();
        TestSubject::create($validated);

        return redirect()->route('admin.tests');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showSingleSubject()
    {
        $subject = $this->urlManager->getCurrentSubject();
        $this->authorize('view', $subject);

        $subject->tests->loadCount('nativeQuestions as questions_count');

        return view('pages.admin.subjects-single', [
            'subject' => $subject
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showUpdateSubjectForm()
    {
        $subject = $this->urlManager->getCurrentSubject();
        $this->authorize('update', $subject);

        return view('pages.admin.subjects-single-settings', [
            'subject' => $subject
        ]);
    }

    /**
     * @param UpdateSubjectRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSubject(UpdateSubjectRequest $request)
    {
        $subject = $request->subject();
        $subject->update($request->validated());

        return redirect()->route('admin.tests.subject', [
            'subject' => $subject['uri_alias']
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function deleteSubject()
    {
        $subject = $this->urlManager->getCurrentSubject();
        $this->authorize('delete', $subject);

        $subject->delete();
        return redirect()->route('admin.tests');
    }
}
