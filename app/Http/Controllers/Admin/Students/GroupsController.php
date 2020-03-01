<?php

namespace App\Http\Controllers\Admin\Students;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Groups\CreateGroupRequest;
use App\Http\Requests\Groups\UpdateGroupRequest;
use App\Http\Requests\UrlManageable;
use App\Http\Requests\UrlManageableRequests;
use App\Models\StudentGroup;

class GroupsController extends AdminController implements UrlManageable
{
    use UrlManageableRequests;

    public function showAll()
    {
        return view('pages.admin.student-groups-list', [
            'groups' => StudentGroup::withCount('students')->get()
        ]);
    }

    public function showNewGroupForm()
    {
        return view('pages.admin.student-groups-new');
    }

    public function newGroup(CreateGroupRequest $request)
    {
        $validated = $request->validated();
        StudentGroup::create($validated);

        return redirect()->route('admin.students.group', [
            'group' => $validated['uri_alias']
        ]);
    }

    public function showSingleGroup()
    {
        $group = $this->urlManager->getCurrentGroup();
        $group->students->loadMissing('studentGroup');

        return view('pages.admin.student-groups-single', [
            'group' => $group,
        ]);
    }

    public function showUpdateGroupForm()
    {
        return view('pages.admin.student-group-settings', [
            'group' => $this->urlManager->getCurrentGroup()
        ]);
    }

    public function updateGroup(UpdateGroupRequest $request)
    {
        $group = $this->urlManager->getCurrentGroup();
        $group->update($request->validated());

        return redirect()->route('admin.students.group', [
            'group' => $group->uri_alias
        ]);
    }
}
