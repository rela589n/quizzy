<?php

namespace App\Http\Controllers\Admin\Teachers;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Users\Teachers\CreateTeacherRequest;
use App\Http\Requests\Users\Teachers\UpdateTeacherRequest;
use App\Models\Administrator;
use Illuminate\Support\Facades\Hash;

class TeachersController extends AdminController
{
    public function showAll()
    {
        return view('pages.admin.teachers-list', [
            'teachers' => Administrator::all()
        ]);
    }

    public function showNewForm()
    {
        return view('pages.admin.teacher-new');
    }

    public function createTeacher(CreateTeacherRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        $newTeacher = Administrator::create($validated);

        return redirect()->route('admin.teachers.teacher', [
            'teacherId' => $newTeacher
        ]);
    }

    public function showUpdateForm($teacherId)
    {
        return view('pages.admin.teacher-update', [
            'user' => Administrator::findOrFail($teacherId)
        ]);
    }

    public function updateTeacher(UpdateTeacherRequest $request, $teacherId)
    {
        $teacher = Administrator::findOrFail($teacherId);
        $validated = array_filter($request->validated());

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $teacher->update($validated);
        return redirect()->route('admin.teachers');
    }
}
