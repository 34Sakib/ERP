<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee\Employee;
use App\Models\Core\Company;
use App\Models\Core\Branch;
use App\Models\Core\Department;
use App\Models\Core\Designation;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::with(['department', 'designation', 'branch']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('employee_code', 'like', "%{$search}%")
                  ->orWhere('personal_email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }
        if ($request->filled('status')) {
            $query->where('employment_status', $request->status);
        }

        $employees = $query->latest()->paginate(15);
        $departments = Department::all();
        $branches = Branch::all();

        return view('employees.index', compact('employees', 'departments', 'branches'));
    }

    public function apiSearch(Request $request)
    {
        $search = trim($request->input('q', ''));
        if (empty($search)) {
            return response()->json([]);
        }

        $employees = Employee::with(['department', 'designation'])
            ->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('employee_code', 'like', "%{$search}%")
                  ->orWhere('personal_email', 'like', "%{$search}%");
            })
            ->take(8)
            ->get()
            ->map(function ($emp) {
                return [
                    'id' => $emp->id,
                    'full_name' => $emp->full_name,
                    'code' => $emp->employee_code,
                    'email' => $emp->personal_email,
                    'photo' => $emp->profile_photo ? asset($emp->profile_photo) : 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80',
                    'department' => $emp->department?->name ?? 'General',
                    'designation' => $emp->designation?->name ?? 'Staff',
                    'status' => $emp->employment_status,
                    'url' => route('employees.show', $emp->id),
                ];
            });

        return response()->json($employees);
    }

    public function create()
    {
        $companies = Company::all();
        $branches = Branch::all();
        $departments = Department::all();
        $designations = Designation::all();

        return view('employees.create', compact('companies', 'branches', 'departments', 'designations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_code' => 'required|string|unique:employees,employee_code',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'gender' => 'required|in:male,female,other',
            'dob' => 'nullable|date',
            'personal_email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:50',
            'company_id' => 'required|exists:companies,id',
            'branch_id' => 'nullable|exists:branches,id',
            'department_id' => 'nullable|exists:departments,id',
            'designation_id' => 'nullable|exists:designations,id',
            'joining_date' => 'required|date',
            'employment_status' => 'required|in:probation,active,terminated,resigned',
        ]);

        DB::transaction(function () use ($validated, &$employee) {
            $user = User::create([
                'company_id' => $validated['company_id'],
                'branch_id' => $validated['branch_id'] ?? null,
                'department_id' => $validated['department_id'] ?? null,
                'name' => "{$validated['first_name']} {$validated['last_name']}",
                'email' => $validated['personal_email'],
                'password' => Hash::make('12345678'),
                'status' => true,
            ]);
            $user->assignRole('Employee');

            $validated['user_id'] = $user->id;
            $employee = Employee::create($validated);

            $user->update(['employee_id' => $employee->id]);
        });

        return redirect()->route('employees.show', $employee->id)->with('success', 'Employee onboarded successfully with portal account.');
    }

    public function show(Employee $employee)
    {
        $employee->load([
            'user', 'branch', 'department', 'designation',
            'emergencyContacts', 'education', 'experience',
            'documents', 'bankDetail', 'history', 'notes.creator'
        ]);

        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $companies = Company::all();
        $branches = Branch::all();
        $departments = Department::all();
        $designations = Designation::all();

        return view('employees.edit', compact('employee', 'companies', 'branches', 'departments', 'designations'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'employee_code' => 'required|string|unique:employees,employee_code,' . $employee->id,
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'gender' => 'required|in:male,female,other',
            'dob' => 'nullable|date',
            'personal_email' => 'required|email|unique:employees,personal_email,' . $employee->id,
            'phone' => 'nullable|string|max:50',
            'company_id' => 'required|exists:companies,id',
            'branch_id' => 'nullable|exists:branches,id',
            'department_id' => 'nullable|exists:departments,id',
            'designation_id' => 'nullable|exists:designations,id',
            'joining_date' => 'required|date',
            'employment_status' => 'required|in:probation,active,terminated,resigned',
        ]);

        $employee->update($validated);

        if ($employee->user) {
            $employee->user->update([
                'name' => "{$validated['first_name']} {$validated['last_name']}",
                'email' => $validated['personal_email'],
                'company_id' => $validated['company_id'],
                'branch_id' => $validated['branch_id'] ?? null,
                'department_id' => $validated['department_id'] ?? null,
            ]);
        }

        return redirect()->route('employees.show', $employee->id)->with('success', 'Employee profile updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}
