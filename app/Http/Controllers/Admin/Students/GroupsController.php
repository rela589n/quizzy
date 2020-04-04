<?php

namespace App\Http\Controllers\Admin\Students;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Groups\CreateGroupRequest;
use App\Http\Requests\Groups\UpdateGroupRequest;
use App\Lib\Filters\AvailableGroupsFilter;
use App\Models\StudentGroup;

class GroupsController extends AdminController
{
    /**
     * @param AvailableGroupsFilter $filters
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAll(AvailableGroupsFilter $filters)
    {
        $groups = StudentGroup::withCount('students');
        $groups = $groups->filtered($filters);

        return view('pages.admin.student-groups-list', [
            'groups' => $groups
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showNewGroupForm()
    {
        $this->authorize('create-groups');

        return view('pages.admin.student-groups-new');
    }

    /**
     * @param CreateGroupRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function newGroup(CreateGroupRequest $request)
    {
        $validated = $request->validated();
        StudentGroup::create($validated);

        return redirect()->route('admin.students.group', [
            'group' => $validated['uri_alias']
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showSingleGroup()
    {
        $this->authorize('view-students');

        $group = $this->urlManager->getCurrentGroup();

        return view('pages.admin.student-groups-single', [
            'group' => $group,
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showUpdateGroupForm()
    {
        $currentGroup = $this->urlManager->getCurrentGroup();
        $this->authorize('update', $currentGroup);

        return view('pages.admin.student-group-settings', [
            'group' => $currentGroup
        ]);
    }

    /**
     * @param UpdateGroupRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateGroup(UpdateGroupRequest $request)
    {
        $group = $request->studentGroup();
        $group->update($request->validated());

        return redirect()->route('admin.students.group', [
            'group' => $group->uri_alias
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function deleteGroup()
    {
        $group = $this->urlManager->getCurrentGroup();
        $this->authorize('delete', $group);

        $group->delete();
        return redirect()->route('admin.students');
    }
}
