<?php

namespace App\Http\Controllers\Admin\Students;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\UrlManageable;
use App\Http\Requests\UrlManageableRequests;
use App\Http\Requests\Users\Students\CreateStudentRequest;
use App\Http\Requests\Users\Students\UpdateStudentRequest;
use App\Models\StudentGroup;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StudentsController extends AdminController implements UrlManageable
{
    use UrlManageableRequests;

    public function showNewStudentForm()
    {
        return view('pages.admin.student-new');
    }

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

    public function showUpdateStudentForm($groupAlias, $userId)
    {
        return view('pages.admin.student-update', [
            'user' => User::findOrFail($userId),
            'studentGroups' => StudentGroup::all()->sortByDesc('year')
        ]);
    }

    public function updateStudent(UpdateStudentRequest $request, $groupAlias, $userId)
    {
        $user = User::findOrFail($userId);
        $validated = array_filter($request->validated());

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.students.group', [
            'group' => $user->studentGroup->uri_alias
        ]);
    }

    public function deleteStudent($groupAlias, $userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();

        return redirect()->route('admin.students.group', [
            'group' => $groupAlias
        ]);
    }
}
