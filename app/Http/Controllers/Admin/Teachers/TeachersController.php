<?php

namespace App\Http\Controllers\Admin\Teachers;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Users\Teachers\CreateTeacherRequest;
use App\Http\Requests\Users\Teachers\UpdateTeacherRequest;
use App\Models\Administrator;
use App\Services\Users\Administrators\CreateAdministratorService;
use App\Services\Users\Administrators\UpdateAdministratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
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
     * @param CreateAdministratorService $createAdministratorService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createTeacher(CreateTeacherRequest $request, CreateAdministratorService $createAdministratorService)
    {
        $createAdministratorService->handle($request->validated());

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
            'user'  => $user,
            'roles' => Role::where('guard_name', 'admin')->get()
        ]);
    }

    /**
     * Handles submit of update admin form.
     * @param UpdateTeacherRequest $request
     * @param $teacherId
     * @param UpdateAdministratorService $updateAdministratorService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateTeacher(UpdateTeacherRequest $request, $teacherId, UpdateAdministratorService $updateAdministratorService)
    {
        $teacher = Administrator::findOrFail($teacherId);

        $validated = array_filter($request->validated());

        if ($teacher->id == $request->user()->id &&
            $teacher->roles->pluck('id')->toArray() != $validated['role_ids']
        ) {
            return redirect()->back()->withErrors(['role_ids.*' => 'Ви не можете змінити свою роль']);
        }

        $updateAdministratorService
            ->setAdministrator($teacher)
            ->setNeedPasswordHash(!empty($validated['password']))
            ->handle($validated);

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
            return redirect()->back()->withErrors(['delete' => 'Ви не можете видалити власний аккаунт.']);
        }

        $teacher->delete();

        return redirect()->route('admin.teachers');
    }
}
