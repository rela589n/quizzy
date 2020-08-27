<?php

namespace App\Http\Controllers\Admin\Teachers;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\RequestUrlManager;
use App\Http\Requests\Users\Teachers\CreateTeacherRequest;
use App\Http\Requests\Users\Teachers\UpdateTeacherRequest;
use App\Models\Administrator;
use App\Services\Users\Administrators\CreateAdministratorService;
use App\Services\Users\Administrators\UpdateAdministratorService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class TeachersController extends AdminController
{

    public function __construct(RequestUrlManager $urlManager)
    {

        parent::__construct($urlManager);
    }

    /**
     * Shows list of all administrators
     * @return View
     * @throws AuthorizationException
     */
    public function showAll(): View
    {
        $this->authorize('view-administrators');

        return view(
            'pages.admin.teachers-list',
            [
                'teachers' => Administrator::all()
            ]
        );
    }

    /**
     * Shows new administrator form
     * @return View
     * @throws AuthorizationException
     */
    public function showNewForm(): View
    {
        $this->authorize('create-administrators');

        return view(
            'pages.admin.teacher-new',
            [
                'roles' => Role::where('guard_name', 'admin')->get()
            ]
        );
    }

    public function createTeacher(
        CreateTeacherRequest $request,
        CreateAdministratorService $createAdministratorService
    ): RedirectResponse
    {
        $createAdministratorService->handle($request->validated());

        return redirect()->route('admin.teachers');
    }

    /**
     * When user clicked "go to user" button, shows form for updating,
     * if he is able to. Else if he can view info, shows information about
     * selected user.
     * @param $teacherId
     * @return View
     * @throws AuthorizationException
     */
    public function showUpdateFormOrInfoPage($teacherId): View
    {
        $user = Administrator::findOrFail($teacherId);

        if (($response = Gate::inspect('update', $user))->denied()) {
            $response = Gate::inspect('view', $user);
        }

        $response->authorize();

        return view(
            'pages.admin.teacher-view',
            [
                'user'  => $user,
                'roles' => Role::where('guard_name', 'admin')->get()
            ]
        );
    }

    public function updateTeacher(
        UpdateTeacherRequest $request,
        $teacherId,
        UpdateAdministratorService $updateAdministratorService
    ): RedirectResponse {
        $teacher = Administrator::findOrFail($teacherId);

        $validated = array_filter($request->validated());

        if ($teacher->id == $request->user()->id &&
            $teacher->roles->pluck('id')->toArray() !== $validated['role_ids']
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
     * @param  Request  $request
     * @param $teacherId
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws Exception
     */
    public function deleteTeacher(Request $request, $teacherId): RedirectResponse
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
