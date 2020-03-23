<?php

namespace App\Http\Controllers\Admin\Students;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Groups\CreateGroupRequest;
use App\Http\Requests\Groups\UpdateGroupRequest;
use App\Models\StudentGroup;

class GroupsController extends AdminController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showAll()
    {
        $this->authorize('view-groups');

        return view('pages.admin.student-groups-list', [
            'groups' => StudentGroup::withCount('students')->get()
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
        $this->authorize('update-groups');

        return view('pages.admin.student-group-settings', [
            'group' => $this->urlManager->getCurrentGroup()
        ]);
    }

    /**
     * @param UpdateGroupRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateGroup(UpdateGroupRequest $request)
    {
        $group = $this->urlManager->getCurrentGroup();
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
        $this->authorize('delete-groups');

        $group = $this->urlManager->getCurrentGroup();
        $group->delete();

        return redirect()->route('admin.students');
    }
}
