<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee\Employee;
use App\Models\Core\Company;
use App\Models\Payroll\SalaryStructure;
use App\Models\Payroll\SalaryComponent;
use App\Models\Payroll\PayrollRun;
use App\Models\Payroll\Payslip;
use App\Models\Payroll\LoanAdvance;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller
{
    /**
     * 1. Salary Structures Management
     */
    public function structures(Request $request)
    {
        $query = SalaryStructure::with(['employee.department', 'employee.designation', 'components']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('employee', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('employee_code', 'like', "%{$search}%");
            });
        }

        $structures = $query->latest()->paginate(15);
        $employees = Employee::where('employment_status', 'active')->get();

        $stats = [
            'total_structures' => SalaryStructure::count(),
            'total_payroll_value' => SalaryStructure::where('status', true)->sum('basic_salary'),
            'average_basic' => round(SalaryStructure::where('status', true)->avg('basic_salary') ?? 0, 2),
            'active_count' => SalaryStructure::where('status', true)->count(),
        ];

        return view('payroll.structures', compact('structures', 'employees', 'stats'));
    }

    public function storeStructure(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'basic_salary' => 'required|numeric|min:0',
            'effective_date' => 'required|date',
            'house_rent' => 'nullable|numeric|min:0',
            'medical_allowance' => 'nullable|numeric|min:0',
            'conveyance' => 'nullable|numeric|min:0',
            'tax_deduction' => 'nullable|numeric|min:0',
        ]);

        DB::transaction(function () use ($validated) {
            $structure = SalaryStructure::updateOrCreate(
                ['employee_id' => $validated['employee_id']],
                [
                    'basic_salary' => $validated['basic_salary'],
                    'effective_date' => $validated['effective_date'],
                    'status' => true,
                ]
            );

            // Re-create components
            $structure->components()->delete();

            if (!empty($validated['house_rent'])) {
                SalaryComponent::create(['salary_structure_id' => $structure->id, 'type' => 'allowance', 'name' => 'House Rent Allowance', 'amount' => $validated['house_rent']]);
            }
            if (!empty($validated['medical_allowance'])) {
                SalaryComponent::create(['salary_structure_id' => $structure->id, 'type' => 'allowance', 'name' => 'Medical Allowance', 'amount' => $validated['medical_allowance']]);
            }
            if (!empty($validated['conveyance'])) {
                SalaryComponent::create(['salary_structure_id' => $structure->id, 'type' => 'allowance', 'name' => 'Conveyance Allowance', 'amount' => $validated['conveyance']]);
            }
            if (!empty($validated['tax_deduction'])) {
                SalaryComponent::create(['salary_structure_id' => $structure->id, 'type' => 'tax', 'name' => 'Income Tax', 'amount' => $validated['tax_deduction']]);
            }
        });

        return redirect()->back()->with('success', 'Employee salary structure configured successfully.');
    }

    public function updateStructure(Request $request, SalaryStructure $structure)
    {
        return $this->storeStructure($request);
    }

    public function destroyStructure(SalaryStructure $structure)
    {
        $structure->delete();
        return redirect()->back()->with('success', 'Salary structure deleted successfully.');
    }

    /**
     * 2. Monthly Payroll Runs
     */
    public function runs(Request $request)
    {
        $runs = PayrollRun::with(['company', 'generator', 'approver', 'payslips'])
            ->latest()
            ->paginate(15);

        $companies = Company::all();

        $stats = [
            'total_runs' => PayrollRun::count(),
            'total_disbursed' => PayrollRun::where('status', 'paid')->sum('total_amount'),
            'pending_approval' => PayrollRun::where('status', 'pending_approval')->count(),
            'draft_count' => PayrollRun::where('status', 'draft')->count(),
        ];

        return view('payroll.runs', compact('runs', 'companies', 'stats'));
    }

    public function storeRun(Request $request)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer|min:2020',
        ]);

        DB::transaction(function () use ($validated) {
            $run = PayrollRun::create([
                'company_id' => $validated['company_id'],
                'month' => $validated['month'],
                'year' => $validated['year'],
                'status' => 'pending_approval',
                'generated_by' => auth()->id(),
                'total_amount' => 0,
            ]);

            // Generate payslips for all active employees
            $employees = Employee::where('employment_status', 'active')->get();
            $totalRunAmount = 0;

            foreach ($employees as $emp) {
                $structure = SalaryStructure::with('components')->where('employee_id', $emp->id)->first();
                $basic = $structure?->basic_salary ?? 45000;

                $allowances = $structure ? $structure->components->whereIn('type', ['allowance', 'bonus'])->sum('amount') : 12000;
                $deductions = $structure ? $structure->components->whereIn('type', ['deduction', 'tax', 'pf'])->sum('amount') : 2500;
                $net = ($basic + $allowances) - $deductions;

                Payslip::create([
                    'payroll_run_id' => $run->id,
                    'employee_id' => $emp->id,
                    'basic_salary' => $basic,
                    'total_allowances' => $allowances,
                    'total_deductions' => $deductions,
                    'total_bonuses' => 0,
                    'tax_amount' => 1500,
                    'net_salary' => $net,
                    'status' => 'pending',
                ]);

                $totalRunAmount += $net;
            }

            $run->update(['total_amount' => $totalRunAmount]);
        });

        return redirect()->back()->with('success', 'Monthly payroll run generated successfully.');
    }

    public function approveRun(PayrollRun $run)
    {
        DB::transaction(function () use ($run) {
            $run->update([
                'status' => 'paid',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            $run->payslips()->update(['status' => 'paid']);
        });

        return redirect()->back()->with('success', 'Payroll run approved and salaries disbursed.');
    }

    /**
     * 3. Payslips Directory
     */
    public function payslips(Request $request)
    {
        $query = Payslip::with(['employee.department', 'employee.designation', 'payrollRun']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('employee', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('employee_code', 'like', "%{$search}%");
            });
        }

        $payslips = $query->latest()->paginate(15);

        $stats = [
            'total_payslips' => Payslip::count(),
            'total_disbursed_net' => Payslip::where('status', 'paid')->sum('net_salary'),
            'avg_net_salary' => round(Payslip::avg('net_salary') ?? 0, 2),
            'paid_count' => Payslip::where('status', 'paid')->count(),
        ];

        return view('payroll.payslips', compact('payslips', 'stats'));
    }

    public function showPayslip(Payslip $payslip)
    {
        $payslip->load(['employee.department', 'employee.designation', 'payrollRun']);
        return response()->json($payslip);
    }

    /**
     * 4. Loans & Advances
     */
    public function loans(Request $request)
    {
        $loans = LoanAdvance::with(['employee.department', 'employee.designation', 'approver'])
            ->latest()
            ->paginate(15);

        $employees = Employee::where('employment_status', 'active')->get();

        $stats = [
            'total_loans' => LoanAdvance::sum('amount'),
            'total_remaining' => LoanAdvance::whereIn('status', ['approved', 'requested'])->sum('remaining_amount'),
            'approved_count' => LoanAdvance::where('status', 'approved')->count(),
            'pending_count' => LoanAdvance::where('status', 'requested')->count(),
        ];

        return view('payroll.loans', compact('loans', 'employees', 'stats'));
    }

    public function storeLoan(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'type' => 'required|in:loan,advance',
            'amount' => 'required|numeric|min:100',
            'installments' => 'required|integer|min:1',
        ]);

        LoanAdvance::create([
            'employee_id' => $validated['employee_id'],
            'type' => $validated['type'],
            'amount' => $validated['amount'],
            'installments' => $validated['installments'],
            'remaining_amount' => $validated['amount'],
            'status' => 'requested',
            'requested_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Loan request submitted successfully.');
    }

    public function approveLoan(LoanAdvance $loan)
    {
        $loan->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Loan application approved.');
    }

    public function rejectLoan(LoanAdvance $loan)
    {
        $loan->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Loan application rejected.');
    }
}
