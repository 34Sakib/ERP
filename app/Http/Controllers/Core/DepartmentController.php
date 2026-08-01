<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Core\Department;
use App\Models\Core\Branch;
use App\Models\Core\Company;

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
        return view('designations.index', compact('departments'));
    }

    public function teams()
    {
        $departments = Department::all();
        return view('teams.index', compact('departments'));
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
