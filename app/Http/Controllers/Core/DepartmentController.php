<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Core\Department;
use App\Models\Core\Branch;
use App\Models\Core\Company;
use App\Models\Core\Designation;
use App\Models\Core\Team;
use App\Models\Employee\Employee;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::with(['branch', 'parentDepartment', 'headEmployee'])->withCount(['employees', 'designations'])->get();
        $branches = Branch::all();
        $companies = Company::all();
        return view('departments.index', compact('departments', 'branches', 'companies'));
    }

    public function designations()
    {
        $departments = Department::all();
        $designations = Designation::with('department')->withCount('employees')->get();
        return view('designations.index', compact('departments', 'designations'));
    }

    public function storeDesignation(Request $request)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'title' => 'required|string|max:191',
            'level' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        $validated['status'] = $request->has('status') ? (bool)$request->status : true;

        Designation::create($validated);
        return back()->with('success', 'Designation title created successfully.');
    }

    public function updateDesignation(Request $request, Designation $designation)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'title' => 'required|string|max:191',
            'level' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        $validated['status'] = $request->has('status') ? (bool)$request->status : true;

        $designation->update($validated);
        return back()->with('success', 'Designation title updated successfully.');
    }

    public function destroyDesignation(Designation $designation)
    {
        $designation->delete();
        return back()->with('success', 'Designation deleted successfully.');
    }

    public function teams()
    {
        $departments = Department::all();
        $teams = Team::with(['department', 'lead'])->withCount('members')->get();
        $employees = Employee::all();
        return view('teams.index', compact('departments', 'teams', 'employees'));
    }

    public function storeTeam(Request $request)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:191',
            'lead_employee_id' => 'nullable|exists:employees,id',
            'status' => 'nullable|boolean',
        ]);

        $validated['status'] = $request->has('status') ? (bool)$request->status : true;

        Team::create($validated);
        return back()->with('success', 'Team squad created successfully.');
    }

    public function updateTeam(Request $request, Team $team)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:191',
            'lead_employee_id' => 'nullable|exists:employees,id',
            'status' => 'nullable|boolean',
        ]);

        $validated['status'] = $request->has('status') ? (bool)$request->status : true;

        $team->update($validated);
        return back()->with('success', 'Team squad updated successfully.');
    }

    public function destroyTeam(Team $team)
    {
        $team->delete();
        return back()->with('success', 'Team squad deleted successfully.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'branch_id' => 'nullable|exists:branches,id',
            'parent_department_id' => 'nullable|exists:departments,id',
            'name' => 'required|string|max:191',
            'code' => 'nullable|string|max:50',
        ]);

        Department::create($validated);

        return back()->with('success', 'Department created successfully.');
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'branch_id' => 'nullable|exists:branches,id',
            'parent_department_id' => 'nullable|exists:departments,id',
            'name' => 'required|string|max:191',
            'code' => 'nullable|string|max:50',
        ]);

        $department->update($validated);

        return back()->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return back()->with('success', 'Department deleted successfully.');
    }
}
