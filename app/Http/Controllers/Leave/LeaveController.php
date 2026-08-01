<?php

namespace App\Http\Controllers\Leave;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee\Employee;
use App\Models\Core\Company;
use App\Models\Leave\LeaveType;
use App\Models\Leave\LeaveBalance;
use App\Models\Leave\LeaveApplication;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LeaveController extends Controller
{
    /**
     * 1. My Personal Leave Portal & Balances
     */
    public function myLeave(Request $request)
    {
        $user = auth()->user();
        $employee = $user?->employee ?? Employee::first();

        $currentYear = date('Y');

        // Ensure Leave Balances exist for employee
        $leaveTypes = LeaveType::where('status', true)->get();
        if ($employee) {
            foreach ($leaveTypes as $type) {
                LeaveBalance::firstOrCreate(
                    [
                        'employee_id' => $employee->id,
                        'leave_type_id' => $type->id,
                        'year' => $currentYear,
                    ],
                    [
                        'allocated_days' => $type->days_per_year,
                        'used_days' => 0,
                        'carried_forward_days' => 0,
                    ]
                );
            }
        }

        $balances = LeaveBalance::with('leaveType')
            ->where('employee_id', $employee?->id)
            ->where('year', $currentYear)
            ->get();

        $applications = LeaveApplication::with(['leaveType', 'approver'])
            ->where('employee_id', $employee?->id)
            ->latest()
            ->get();

        $stats = [
            'total_allocated' => $balances->sum('allocated_days'),
            'total_used' => $balances->sum('used_days'),
            'total_remaining' => $balances->sum('allocated_days') - $balances->sum('used_days'),
            'pending_count' => $applications->where('status', 'pending')->count(),
        ];

        return view('leave.my', compact('employee', 'balances', 'applications', 'stats', 'leaveTypes'));
    }

    /**
     * 2. Apply Leave Page
     */
    public function apply()
    {
        $user = auth()->user();
        $employee = $user?->employee ?? Employee::first();
        $leaveTypes = LeaveType::where('status', true)->get();
        $currentYear = date('Y');

        $balances = LeaveBalance::with('leaveType')
            ->where('employee_id', $employee?->id)
            ->where('year', $currentYear)
            ->get();

        return view('leave.apply', compact('employee', 'leaveTypes', 'balances'));
    }

    /**
     * Store Leave Application
     */
    public function storeApplication(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:1000',
        ]);

        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);
        $daysCount = $startDate->diffInDays($endDate) + 1;

        LeaveApplication::create([
            'employee_id' => $validated['employee_id'],
            'leave_type_id' => $validated['leave_type_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'days_count' => $daysCount,
            'reason' => $validated['reason'],
            'status' => 'pending',
        ]);

        return redirect()->route('leave.my')->with('success', 'Leave application submitted successfully.');
    }

    /**
     * Cancel Leave Application
     */
    public function cancelApplication(LeaveApplication $application)
    {
        if ($application->status === 'pending') {
            $application->update(['status' => 'cancelled']);
            return redirect()->back()->with('success', 'Leave application cancelled.');
        }

        return redirect()->back()->with('error', 'Only pending leave applications can be cancelled.');
    }

    /**
     * 3. Approval Queue Manager
     */
    public function approvals(Request $request)
    {
        $query = LeaveApplication::with(['employee.department', 'employee.designation', 'leaveType', 'approver']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('employee', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('employee_code', 'like', "%{$search}%");
            });
        }

        $applications = $query->latest()->paginate(15);

        $stats = [
            'pending' => LeaveApplication::where('status', 'pending')->count(),
            'approved' => LeaveApplication::where('status', 'approved')->count(),
            'rejected' => LeaveApplication::where('status', 'rejected')->count(),
            'total' => LeaveApplication::count(),
        ];

        return view('leave.approvals', compact('applications', 'stats'));
    }

    /**
     * Approve Leave Application
     */
    public function approveApplication(LeaveApplication $application)
    {
        DB::transaction(function () use ($application) {
            $application->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            // Deduct days from Leave Balance
            $balance = LeaveBalance::where('employee_id', $application->employee_id)
                ->where('leave_type_id', $application->leave_type_id)
                ->where('year', date('Y'))
                ->first();

            if ($balance) {
                $balance->increment('used_days', $application->days_count);
            }
        });

        return redirect()->back()->with('success', 'Leave application approved and quota balance updated.');
    }

    /**
     * Reject Leave Application
     */
    public function rejectApplication(Request $request, LeaveApplication $application)
    {
        $validated = $request->validate([
            'rejection_reason' => 'nullable|string|max:500',
        ]);

        $application->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'rejection_reason' => $validated['rejection_reason'] ?? 'Request rejected by manager.',
        ]);

        return redirect()->back()->with('success', 'Leave application rejected.');
    }

    /**
     * 4. Leave Types CRUD
     */
    public function leaveTypes()
    {
        $types = LeaveType::with('company')->latest()->get();
        $companies = Company::all();

        return view('leave.types', compact('types', 'companies'));
    }

    public function storeLeaveType(Request $request)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string|max:100',
            'color' => 'required|string|max:20',
            'days_per_year' => 'required|integer|min:1',
            'carry_forward' => 'nullable|boolean',
            'max_carry_forward_days' => 'nullable|integer|min:0',
            'is_paid' => 'nullable|boolean',
        ]);

        $validated['carry_forward'] = $request->has('carry_forward');
        $validated['max_carry_forward_days'] = $validated['max_carry_forward_days'] ?? 0;
        $validated['is_paid'] = $request->has('is_paid');

        LeaveType::create($validated);
        return redirect()->back()->with('success', 'Leave type created successfully.');
    }

    public function updateLeaveType(Request $request, LeaveType $leaveType)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string|max:100',
            'color' => 'required|string|max:20',
            'days_per_year' => 'required|integer|min:1',
            'carry_forward' => 'nullable|boolean',
            'max_carry_forward_days' => 'nullable|integer|min:0',
            'is_paid' => 'nullable|boolean',
        ]);

        $validated['carry_forward'] = $request->has('carry_forward');
        $validated['max_carry_forward_days'] = $validated['max_carry_forward_days'] ?? 0;
        $validated['is_paid'] = $request->has('is_paid');

        $leaveType->update($validated);
        return redirect()->back()->with('success', 'Leave type updated successfully.');
    }

    public function destroyLeaveType(LeaveType $leaveType)
    {
        $leaveType->delete();
        return redirect()->back()->with('success', 'Leave type deleted successfully.');
    }
}
