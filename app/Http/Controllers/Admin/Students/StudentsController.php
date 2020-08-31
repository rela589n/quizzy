<?php

namespace App\Http\Controllers\Admin\Students;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Users\Students\CreateStudentRequest;
use App\Http\Requests\Users\Students\UpdateStudentRequest;
use App\Models\Administrator;
use App\Models\StudentGroup;
use App\Models\User;
use App\Services\Users\Administrators\CreateAdministratorService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class StudentsController extends AdminController
{
    /**
     * @return View
     * @throws AuthorizationException
     */
    public function showNewStudentForm(): View
    {
        $this->authorize('create-students');

        return view(
            'pages.admin.student-new',
            [
                'department' => $this->urlManager->getCurrentDepartment(),
                'group'      => $this->urlManager->getCurrentGroup()
            ]
        );
    }

    public function newStudent(CreateStudentRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        $group = $this->urlManager->getCurrentGroup();
        $group->students()->create($validated);

        return redirect()->route(
            'admin.students.department.group',
            [
                'department' => $this->urlManager->getCurrentDepartment()->uri_alias,
                'group'      => $group->uri_alias
            ]
        );
    }

    /**
     * @param $departmentAlias
     * @param $groupAlias
     * @param $userId
     * @return View
     * @throws AuthorizationException
     */
    public function showUpdateFormOrInfoPage($departmentAlias, $groupAlias, $userId): ?View
    {
        $user = User::findOrFail($userId);

        try {
            return $this->showUpdateForm($user);
        } catch (AuthorizationException $e) {
            return $this->showReadOnlyUserPage($user);
        }
    }

    /**
     * @param  User  $user
     * @return View
     * @throws AuthorizationException
     */
    public function showUpdateForm(User $user): View
    {
        $this->authorize('update', $user);

        return view(
            'pages.admin.student-update',
            [
                'user'          => $user,
                'studentGroups' => StudentGroup::all()->sortByDesc('year'),
                'messageToUser' => Session::pull('messageToUser'),
            ]
        );
    }

    /**
     * @param  User  $user
     * @return View
     * @throws AuthorizationException
     */
    public function showReadOnlyUserPage(User $user): View
    {
        $this->authorize('view', $user);

        return view('pages.admin.student-view', compact('user'));
    }

    /**
     * @param  UpdateStudentRequest  $request
     * @return RedirectResponse
     */
    public function updateStudent(UpdateStudentRequest $request): RedirectResponse
    {
        $user = $request->student();
        $validated = array_filter($request->validated());

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return redirect()->route(
            'admin.students.department.group',
            [
                'department' => $user->studentGroup->department->uri_alias,
                'group'      => $user->studentGroup->uri_alias
            ]
        );
    }

    /**
     * @param $departmentAlias
     * @param $groupAlias
     * @param $userId
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws Exception
     */
    public function deleteStudent($departmentAlias, $groupAlias, $userId): RedirectResponse
    {
        $user = User::findOrFail($userId);
        $this->authorize('delete', $user);

        $user->delete();

        return redirect()->route(
            'admin.students.department.group',
            [
                'department' => $departmentAlias,
                'group'      => $groupAlias
            ]
        );
    }

    /**
     * @param $departmentAlias
     * @param $groupAlias
     * @param $userId
     * @param  CreateAdministratorService  $createAdministratorService
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function makeClassMonitor(
        $departmentAlias,
        $groupAlias,
        $userId,
        CreateAdministratorService $createAdministratorService
    ): RedirectResponse {
        $user = User::findOrFail($userId);
        $this->authorize('update', $user);
        $this->authorize('make-student-class-monitor');

        $group = StudentGroup::whereUriAlias($groupAlias)->firstOrFail();

        if ($group->classMonitor()->exists()) {
            throw ValidationException::withMessages(
                [
                    'student_group_id' => 'Група вже має старосту'
                ]
            );
        }

        if (Administrator::whereEmail($user->email)->exists()) {
            throw ValidationException::withMessages(
                [
                    'email' => 'В адмін-панелі вже є користувач з заданим email'
                ]
            );
        }

        $classMonitor = $createAdministratorService
            ->withoutPasswordHashing()
            ->handle(
                [
                    'name'       => $user->name,
                    'surname'    => $user->surname,
                    'patronymic' => $user->patronymic,
                    'email'      => $user->email,
                    'password'   => $user->password,
                    'role_ids'   => [Role::whereName('class-monitor')->first('id')->id]
                ]
            );

        $group->created_by = $classMonitor->id;
        $group->save();

        return redirect()
            ->back()
            ->with(
                'messageToUser',
                'Успішно створено аккаунт старости в адмін-панелі (логін та пароль такі ж як поточні).'
            );
    }
}
