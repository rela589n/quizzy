<?php

namespace App\Http\Controllers\Admin\Students;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Groups\CreateGroupRequest;
use App\Http\Requests\Groups\UpdateGroupRequest;
use App\Lib\Filters\Eloquent\AvailableGroupsFilter;
use App\Repositories\AdministratorsRepository;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GroupsController extends AdminController
{
    /**
     * @param AvailableGroupsFilter $filters
     * @return View
     * @throws AuthorizationException
     */
    public function showAll(AvailableGroupsFilter $filters): View
    {
        $department = $this->urlManager->getCurrentDepartment();
        $this->authorize('view', $department);

        $groups = $department->studentGroups()->withCount('students');
        $groups = $groups->filtered($filters);

        return view('pages.admin.student-groups-list', [
            'department' => $department,
            'groups'     => $groups
        ]);
    }

    /**
     * @param AdministratorsRepository $adminRepo
     * @return View
     * @throws AuthorizationException
     */
    public function showNewGroupForm(AdministratorsRepository $adminRepo): View
    {
        $this->authorize('create-groups');

        return view('pages.admin.student-groups-new', [
            'department'    => $this->urlManager->getCurrentDepartment(),
            'classMonitors' => $adminRepo->probableClassMonitors(),
        ]);
    }

    /**
     * @param CreateGroupRequest $request
     * @return RedirectResponse
     */
    public function newGroup(CreateGroupRequest $request): RedirectResponse
    {
        $department = $this->urlManager->getCurrentDepartment();

        $department->studentGroups()->create($request->validated());

        return redirect()->route('admin.students.department', [
            'department' => $department->uri_alias
        ]);
    }

    /**
     * @return View
     * @throws AuthorizationException
     */
    public function showSingleGroup(): View
    {
        $group = $this->urlManager->getCurrentGroup();
        $this->authorize('view', $group);

        return view('pages.admin.student-groups-single', [
            'department' => $this->urlManager->getCurrentDepartment(),
            'group'      => $group,
        ]);
    }

    /**
     * @param AdministratorsRepository $adminRepo
     * @return View
     * @throws AuthorizationException
     */
    public function showUpdateGroupForm(AdministratorsRepository $adminRepo): View
    {
        $currentGroup = $this->urlManager->getCurrentGroup();
        $this->authorize('update', $currentGroup);

        return view('pages.admin.student-group-settings', [
            'department'    => $this->urlManager->getCurrentDepartment(),
            'group'         => $currentGroup,
            'classMonitors' => $adminRepo->probableClassMonitors($currentGroup)
        ]);
    }

    /**
     * @param UpdateGroupRequest $request
     * @return RedirectResponse
     */
    public function updateGroup(UpdateGroupRequest $request): RedirectResponse
    {
        $group = $this->urlManager->getCurrentGroup();
        $group->update($request->validated());

        return redirect()->route('admin.students.department.group', [
            'department' => $this->urlManager->getCurrentDepartment()->uri_alias,
            'group'      => $group->uri_alias
        ]);
    }

    /**
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws Exception
     */
    public function deleteGroup(): RedirectResponse
    {
        $group = $this->urlManager->getCurrentGroup();
        $this->authorize('delete', $group);

        $group->delete();

        return redirect()->route('admin.students.department', [
            'department' => $this->urlManager->getCurrentDepartment()->uri_alias,
        ]);
    }
}
