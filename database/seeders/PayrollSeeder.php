<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Core\Company;
use App\Models\Employee\Employee;
use App\Models\Payroll\SalaryStructure;
use App\Models\Payroll\SalaryComponent;
use App\Models\Payroll\PayrollRun;
use App\Models\Payroll\Payslip;
use App\Models\Payroll\LoanAdvance;
use Carbon\Carbon;

class PayrollSeeder extends Seeder
{
    public function run()
    {
        $company = Company::first();
        $employees = Employee::take(10)->get();

        if (!$company || $employees->isEmpty()) {
            return;
        }

        // 1. Seed Salary Structures for Employees
        foreach ($employees as $idx => $emp) {
            $basic = 45000 + ($idx * 3500);

            $struct = SalaryStructure::firstOrCreate(
                ['employee_id' => $emp->id],
                [
                    'basic_salary' => $basic,
                    'effective_date' => '2026-01-01',
                    'status' => true,
                ]
            );

            // Allowances
            SalaryComponent::firstOrCreate(
                ['salary_structure_id' => $struct->id, 'name' => 'House Rent Allowance'],
                ['type' => 'allowance', 'amount' => $basic * 0.4]
            );

            SalaryComponent::firstOrCreate(
                ['salary_structure_id' => $struct->id, 'name' => 'Medical Allowance'],
                ['type' => 'allowance', 'amount' => 3000]
            );

            // Deductions
            SalaryComponent::firstOrCreate(
                ['salary_structure_id' => $struct->id, 'name' => 'Income Tax'],
                ['type' => 'tax', 'amount' => 2500]
            );
        }

        // 2. Seed Payroll Run & Payslips for July 2026
        $runJuly = PayrollRun::firstOrCreate(
            ['company_id' => $company->id, 'month' => 7, 'year' => 2026],
            [
                'status' => 'paid',
                'generated_by' => 1,
                'approved_by' => 1,
                'approved_at' => '2026-07-25 10:00:00',
                'total_amount' => 625000,
            ]
        );

        foreach ($employees as $emp) {
            $struct = SalaryStructure::where('employee_id', $emp->id)->first();
            $basic = $struct?->basic_salary ?? 50000;
            $allowance = $basic * 0.45;
            $deduction = 2500;
            $net = ($basic + $allowance) - $deduction;

            Payslip::firstOrCreate(
                ['payroll_run_id' => $runJuly->id, 'employee_id' => $emp->id],
                [
                    'basic_salary' => $basic,
                    'total_allowances' => $allowance,
                    'total_deductions' => $deduction,
                    'total_bonuses' => 0,
                    'tax_amount' => 1500,
                    'net_salary' => $net,
                    'status' => 'paid',
                ]
            );
        }

        // 3. Seed Loans & Advances
        if (isset($employees[0])) {
            LoanAdvance::firstOrCreate(
                ['employee_id' => $employees[0]->id, 'amount' => 50000],
                [
                    'type' => 'loan',
                    'installments' => 10,
                    'remaining_amount' => 35000,
                    'status' => 'approved',
                    'requested_at' => '2026-05-10 09:30:00',
                ]
            );
        }

        if (isset($employees[1])) {
            LoanAdvance::firstOrCreate(
                ['employee_id' => $employees[1]->id, 'amount' => 15000],
                [
                    'type' => 'advance',
                    'installments' => 1,
                    'remaining_amount' => 15000,
                    'status' => 'requested',
                    'requested_at' => '2026-07-22 14:15:00',
                ]
            );
        }
    }
}
