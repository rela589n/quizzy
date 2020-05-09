<?php


namespace App\Http\Controllers\Admin\Students;


use App\Http\Controllers\Admin\AdminController;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentsController extends AdminController
{
    public function showAll(Request $request)
    {
        $departments = Department::withCount('studentGroups')->get();

        return view('pages.admin.student-departments-list', compact('departments'));
    }
}
