<?php

namespace App\Http\Controllers\Admin\Teachers;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Users\Teachers\CreateTeacherRequest;
use App\Http\Requests\Users\Teachers\UpdateTeacherRequest;
use App\Models\Administrator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class TeachersController extends AdminController
{
    /**
     * Shows list of all administrators
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showAll()
    {
        $this->authorize('view-administrators');

        return view('pages.admin.teachers-list', [
            'teachers' => Administrator::all()
        ]);
    }

    /**
     * Shows new administrator form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showNewForm()
    {
        $this->authorize('create-administrators');

        return view('pages.admin.teacher-new', [
            'roles' => Role::where('guard_name', 'admin')->get()
        ]);
    }

    /**
     * Handle submit of new administrator form
     * @param CreateTeacherRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createTeacher(CreateTeacherRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        $newTeacher = Administrator::create($validated);
        $newTeacher->syncRoles($validated['role_ids']);

        return redirect()->route('admin.teachers');
    }

    /**
     * When user clicked "go to user" button, shows form for updating,
     * if he is able to. Else if he can view info, shows information about
     * selected user.
     * @param $teacherId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showUpdateFormOrInfoPage($teacherId)
    {
        $user = Administrator::findOrFail($teacherId);

        if (($response = Gate::inspect('update', $user))->denied()) {
            $response = Gate::inspect('view', $user);
        }

        $response->authorize();

        return view('pages.admin.teacher-view', [
            'user' => $user,
            'roles' => Role::where('guard_name', 'admin')->get()
        ]);
    }

    /**
     * Handles submit of update admin form.
     * @param UpdateTeacherRequest $request
     * @param $teacherId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateTeacher(UpdateTeacherRequest $request, $teacherId)
    {
        $teacher = Administrator::findOrFail($teacherId);
        $validated = array_filter($request->validated());

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $teacher->update($validated);
        if ($teacher->id == $request->user()->id &&
            $teacher->roles->pluck('id')->toArray() != $validated['role_ids']
        ) {
            return redirect()->back()->withErrors(['role_ids.*' => 'Ви не можете змінити свою роль']);
        }

        $teacher->syncRoles($validated['role_ids']);

        return redirect()->route('admin.teachers');
    }

    /**
     * Handles delete request of administrator
     * @param Request $request
     * @param $teacherId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function deleteTeacher(Request $request, $teacherId)
    {
        $teacher = Administrator::findOrFail($teacherId);
        $this->authorize('delete', $teacher);

        if ($teacher->id == $request->user()->id) {
            return redirect()->back()->withErrors(['delete'=> 'Ви не можете видалити власний аккаунт.']);
        }

        $teacher->delete();

        return redirect()->route('admin.teachers');
    }
}
