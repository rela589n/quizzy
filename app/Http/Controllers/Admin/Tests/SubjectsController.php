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
        $this->authorize('view-subjects');

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

        return redirect()->route('admin.tests.subject', [
            'subject' => $validated['uri_alias']
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showSingleSubject()
    {
        $this->authorize('view-subjects');

        $subject = $this->urlManager->getCurrentSubject();
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
        $this->authorize('update-subjects');

        return view('pages.admin.subjects-single-settings', [
            'subject' => $this->urlManager->getCurrentSubject()
        ]);
    }

    /**
     * @param UpdateSubjectRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSubject(UpdateSubjectRequest $request)
    {
        $subject = $this->urlManager->getCurrentSubject();
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
        $this->authorize('delete-subjects');

        $subject = $this->urlManager->getCurrentSubject();
        $subject->delete();

        return redirect()->route('admin.tests');
    }
}
