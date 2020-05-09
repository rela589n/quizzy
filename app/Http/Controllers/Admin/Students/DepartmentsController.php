<?php


namespace App\Http\Controllers\Admin\Students;


use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Departments\CreateDepartmentsRequest;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentsController extends AdminController
{
    public function showAll(Request $request)
    {
        $departments = Department::withCount('studentGroups')->get();

        return view('pages.admin.student-departments-list', compact('departments'));
    }

    public function showNewDepartmentForm()
    {
        $this->authorize('create-departments');

        return view('pages.admin.student-departments-new');
    }

    public function newDepartment(CreateDepartmentsRequest $request)
    {
        $validated = $request->validated();
        Department::create($validated);

        return redirect()->route('admin.students');
    }
}
