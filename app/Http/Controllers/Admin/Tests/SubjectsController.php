<?php

namespace App\Http\Controllers\Admin\Tests;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Subjects\CreateSubjectRequest;
use App\Http\Requests\Subjects\UpdateSubjectRequest;
use App\Models\Course;
use App\Models\Department;
use App\Models\TestSubject;
use App\Repositories\TestsRepository;
use App\Services\Subjects\CreateSubjectService;
use App\Services\Subjects\UpdateSubjectService;

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

        return view('pages.admin.subjects-new', [
            'allCourses'     => Course::all(),
            'allDepartments' => Department::all(),
        ]);
    }

    /**
     * @param CreateSubjectRequest $request
     * @param CreateSubjectService $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function newSubject(CreateSubjectRequest $request, CreateSubjectService $service)
    {
        $subject = $service->handle($request->validated());

        return redirect()->route('admin.tests');
    }

    /**
     * @param TestsRepository $testsRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showSingleSubject(TestsRepository $testsRepository)
    {
        $subject = $this->urlManager->getCurrentSubject();
        $this->authorize('view', $subject);

        return view('pages.admin.subjects-single', [
            'subject'      => $subject,
            'subjectTests' => $testsRepository->testsForSubjectPage(),
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
            'subject'        => $subject,
            'allCourses'     => Course::all(),
            'allDepartments' => Department::all(),
        ]);
    }

    /**
     * @param UpdateSubjectRequest $request
     * @param UpdateSubjectService $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSubject(UpdateSubjectRequest $request, UpdateSubjectService $service)
    {
        $subject = $this->urlManager->getCurrentSubject();

        $service->setSubject($subject)
            ->handle($request->validated());

        return redirect()->route('admin.tests.subject', [
            'subject' => $subject->uri_alias
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function deleteSubject()
    {
        $subject = $this->urlManager->getCurrentSubject();
        $this->authorize('delete', $subject);

        $subject->delete();
        return redirect()->route('admin.tests');
    }
}
