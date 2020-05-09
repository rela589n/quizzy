<?php

namespace App\Http\Controllers\Admin\Students;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Users\Students\CreateStudentRequest;
use App\Http\Requests\Users\Students\UpdateStudentRequest;
use App\Models\StudentGroup;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class StudentsController extends AdminController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
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

        return redirect()->route('admin.students.group', [
            'group' => $group->uri_alias
        ]);
    }

    /**
     * @param $groupAlias
     * @param $userId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showUpdateFormOrInfoPage($groupAlias, $userId)
    {
        $user = User::findOrFail($userId);

        if (($response = Gate::inspect('update', $user))->denied()) {
            $response = Gate::inspect('view', $user);
        }

        $response->authorize();

        return view('pages.admin.student-view', [
            'user'          => $user,
            'studentGroups' => StudentGroup::all()->sortByDesc('year')
        ]);
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

        return redirect()->route('admin.students.group', [
            'group' => $user->studentGroup->uri_alias
        ]);
    }

    /**
     * @param $groupAlias
     * @param $userId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function deleteStudent($groupAlias, $userId)
    {
        $user = User::findOrFail($userId);
        $this->authorize('delete', $user);

        $user->delete();

        return redirect()->route('admin.students.group', [
            'group' => $groupAlias
        ]);
    }
}
