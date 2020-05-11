<?php

namespace App\Http\Controllers\Admin\Students;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Users\Students\CreateStudentRequest;
use App\Http\Requests\Users\Students\UpdateStudentRequest;
use App\Models\StudentGroup;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Hash;

class StudentsController extends AdminController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws AuthorizationException
     */
    public function showNewStudentForm()
    {
        $this->authorize('create-students');

        return view('pages.admin.student-new', [
            'department' => $this->urlManager->getCurrentDepartment(),
            'group'      => $this->urlManager->getCurrentGroup()
        ]);
    }

    /**
     * @param CreateStudentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function newStudent(CreateStudentRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        $group = $this->urlManager->getCurrentGroup();
        $group->students()->create($validated);

        return redirect()->route('admin.students.department.group', [
            'department' => $this->urlManager->getCurrentDepartment()->uri_alias,
            'group'      => $group->uri_alias
        ]);
    }

    /**
     * @param $departmentAlias
     * @param $groupAlias
     * @param $userId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws AuthorizationException
     */
    public function showUpdateFormOrInfoPage($departmentAlias, $groupAlias, $userId)
    {
        $user = User::findOrFail($userId);

        try {
            return $this->showUpdateForm($user);

        } catch (AuthorizationException $e) {

            return $this->showReadOnlyUserPage($user);
        }
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws AuthorizationException
     */
    public function showUpdateForm(User $user)
    {
        $this->authorize('update', $user);

        return view('pages.admin.student-update', [
            'user'          => $user,
            'studentGroups' => StudentGroup::all()->sortByDesc('year')
        ]);
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws AuthorizationException
     */
    public function showReadOnlyUserPage(User $user)
    {
        $this->authorize('view', $user);

        return view('pages.admin.student-view', compact('user'));
    }

    /**
     * @param UpdateStudentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStudent(UpdateStudentRequest $request)
    {
        $user = $request->student();
        $validated = array_filter($request->validated());

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.students.department.group', [
            'department' => $user->studentGroup->department->uri_alias,
            'group'      => $user->studentGroup->uri_alias
        ]);
    }

    /**
     * @param $departmentAlias
     * @param $groupAlias
     * @param $userId
     * @return \Illuminate\Http\RedirectResponse
     * @throws AuthorizationException
     * @throws \Exception
     */
    public function deleteStudent($departmentAlias, $groupAlias, $userId)
    {
        $user = User::findOrFail($userId);
        $this->authorize('delete', $user);

        $user->delete();

        return redirect()->route('admin.students.department.group', [
            'department' => $departmentAlias,
            'group'      => $groupAlias
        ]);
    }
}
