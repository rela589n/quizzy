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
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SubjectsController extends AdminController
{
    /**
     * @return View
     * @throws AuthorizationException
     */
    public function showAll(): View
    {
        $this->authorize('access-subjects');

        return view('pages.admin.subjects-list', [
            'subjects' => TestSubject::withCount('tests')->get()
        ]);
    }

    /**
     * @return View
     * @throws AuthorizationException
     */
    public function showNewSubjectForm(): View
    {
        $this->authorize('create-subjects');

        return view('pages.admin.subjects-new', [
            'allCourses'     => Course::all(),
            'allDepartments' => Department::all(),
        ]);
    }

    public function newSubject(CreateSubjectRequest $request, CreateSubjectService $service): RedirectResponse
    {
        $subject = $service->handle($request->validated());

        return redirect()->route('admin.tests');
    }

    /**
     * @param TestsRepository $testsRepository
     * @return View
     * @throws AuthorizationException
     */
    public function showSingleSubject(TestsRepository $testsRepository): View
    {
        $subject = $this->urlManager->getCurrentSubject();
        $this->authorize('view', $subject);

        return view('pages.admin.subjects-single', [
            'subject'      => $subject,
            'subjectTests' => $testsRepository->testsForSubjectPage(),
        ]);
    }

    /**
     * @return View
     * @throws AuthorizationException
     */
    public function showUpdateSubjectForm(): View
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
     * @return RedirectResponse
     */
    public function updateSubject(UpdateSubjectRequest $request, UpdateSubjectService $service): RedirectResponse
    {
        $subject = $this->urlManager->getCurrentSubject();

        $service->setSubject($subject)
            ->handle($request->validated());

        return redirect()->route('admin.tests.subject', [
            'subject' => $subject->uri_alias
        ]);
    }

    /**
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws Exception
     */
    public function deleteSubject(): RedirectResponse
    {
        $subject = $this->urlManager->getCurrentSubject();
        $this->authorize('delete', $subject);

        $subject->delete();
        return redirect()->route('admin.tests');
    }
}
