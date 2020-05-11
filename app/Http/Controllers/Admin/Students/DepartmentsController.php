<?php


namespace App\Http\Controllers\Admin\Students;


use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Departments\CreateDepartmentsRequest;
use App\Http\Requests\Departments\UpdateDepartmentRequest;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentsController extends AdminController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAll(Request $request)
    {
        $departments = Department::withCount('studentGroups')->get();

        return view('pages.admin.student-departments-list', compact('departments'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showNewDepartmentForm()
    {
        $this->authorize('create-departments');

        return view('pages.admin.student-departments-new');
    }

    /**
     * @param CreateDepartmentsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function newDepartment(CreateDepartmentsRequest $request)
    {
        $validated = $request->validated();
        Department::create($validated);

        return redirect()->route('admin.students');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showUpdateDepartmentForm()
    {
        $department = $this->urlManager->getCurrentDepartment();
        $this->authorize('update', $department);

        return view('pages.admin.student-department-settings', compact('department'));
    }

    /**
     * @param UpdateDepartmentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateDepartment(UpdateDepartmentRequest $request)
    {
        $department = $this->urlManager->getCurrentDepartment();
        $department->update($request->validated());

        return redirect()->route('admin.students.department', [
            'department' => $department->uri_alias
        ]);
    }


    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function deleteDepartment()
    {
        $department = $this->urlManager->getCurrentDepartment();
        $this->authorize('delete', $department);

        $department->delete();
        return redirect()->route('admin.students');
    }
}
