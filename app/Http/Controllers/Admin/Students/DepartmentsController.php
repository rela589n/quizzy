<?php


namespace App\Http\Controllers\Admin\Students;


use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Departments\CreateDepartmentsRequest;
use App\Http\Requests\Departments\UpdateDepartmentRequest;
use App\Lib\Filters\Eloquent\AvailableDepartmentsFilter;
use App\Models\Department;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DepartmentsController extends AdminController
{
    public function showAll(AvailableDepartmentsFilter $filters): View
    {
        $departments = Department::withCount('studentGroups');
        $departments = $departments->filtered($filters);

        return view('pages.admin.student-departments-list', compact('departments'));
    }

    /**
     * @return View
     * @throws AuthorizationException
     */
    public function showNewDepartmentForm(): View
    {
        $this->authorize('create-departments');

        return view('pages.admin.student-departments-new');
    }

    /**
     * @param CreateDepartmentsRequest $request
     * @return RedirectResponse
     */
    public function newDepartment(CreateDepartmentsRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        Department::create($validated);

        return redirect()->route('admin.students');
    }

    /**
     * @return View
     * @throws AuthorizationException
     */
    public function showUpdateDepartmentForm(): View
    {
        $department = $this->urlManager->getCurrentDepartment();
        $this->authorize('update', $department);

        return view('pages.admin.student-department-settings', compact('department'));
    }

    /**
     * @param UpdateDepartmentRequest $request
     * @return RedirectResponse
     */
    public function updateDepartment(UpdateDepartmentRequest $request): RedirectResponse
    {
        $department = $this->urlManager->getCurrentDepartment();
        $department->update($request->validated());

        return redirect()->route('admin.students.department', [
            'department' => $department->uri_alias
        ]);
    }

    /**
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws Exception
     */
    public function deleteDepartment(): RedirectResponse
    {
        $department = $this->urlManager->getCurrentDepartment();
        $this->authorize('delete', $department);

        $department->delete();
        return redirect()->route('admin.students');
    }
}
