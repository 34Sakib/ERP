<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Core\Company;
use App\Models\Employee\Employee;
use App\Models\Leave\LeaveType;
use App\Models\Leave\LeaveBalance;
use App\Models\Leave\LeaveApplication;
use Carbon\Carbon;

class LeaveSeeder extends Seeder
{
    public function run()
    {
        $company = Company::first();
        $employees = Employee::take(10)->get();

        if (!$company || $employees->isEmpty()) {
            return;
        }

        // 1. Create Leave Types
        $annual = LeaveType::firstOrCreate(
            ['company_id' => $company->id, 'name' => 'Annual Paid Leave'],
            [
                'color' => '#10B981',
                'days_per_year' => 15,
                'carry_forward' => true,
                'max_carry_forward_days' => 5,
                'is_paid' => true,
                'status' => true,
            ]
        );

        $sick = LeaveType::firstOrCreate(
            ['company_id' => $company->id, 'name' => 'Sick Leave'],
            [
                'color' => '#F43F5E',
                'days_per_year' => 10,
                'carry_forward' => false,
                'is_paid' => true,
                'status' => true,
            ]
        );

        $casual = LeaveType::firstOrCreate(
            ['company_id' => $company->id, 'name' => 'Casual Leave'],
            [
                'color' => '#F59E0B',
                'days_per_year' => 10,
                'carry_forward' => false,
                'is_paid' => true,
                'status' => true,
            ]
        );

        $maternity = LeaveType::firstOrCreate(
            ['company_id' => $company->id, 'name' => 'Maternity / Paternity Leave'],
            [
                'color' => '#6366F1',
                'days_per_year' => 60,
                'carry_forward' => false,
                'is_paid' => true,
                'status' => true,
            ]
        );

        $year = date('Y');

        // 2. Seed Balances & Applications for Employees
        foreach ($employees as $idx => $emp) {
            LeaveBalance::firstOrCreate(
                ['employee_id' => $emp->id, 'leave_type_id' => $annual->id, 'year' => $year],
                ['allocated_days' => 15, 'used_days' => $idx % 3 === 0 ? 3 : 0]
            );

            LeaveBalance::firstOrCreate(
                ['employee_id' => $emp->id, 'leave_type_id' => $sick->id, 'year' => $year],
                ['allocated_days' => 10, 'used_days' => $idx % 2 === 0 ? 2 : 0]
            );

            LeaveBalance::firstOrCreate(
                ['employee_id' => $emp->id, 'leave_type_id' => $casual->id, 'year' => $year],
                ['allocated_days' => 10, 'used_days' => 1]
            );

            // Create Sample Applications
            if ($idx === 0) {
                LeaveApplication::firstOrCreate(
                    ['employee_id' => $emp->id, 'start_date' => '2026-08-01'],
                    [
                        'leave_type_id' => $annual->id,
                        'end_date' => '2026-08-05',
                        'days_count' => 5,
                        'reason' => 'Annual family vacation trip to Saint Martin Island.',
                        'status' => 'pending',
                    ]
                );
            } elseif ($idx === 1) {
                LeaveApplication::firstOrCreate(
                    ['employee_id' => $emp->id, 'start_date' => '2026-07-10'],
                    [
                        'leave_type_id' => $sick->id,
                        'end_date' => '2026-07-12',
                        'days_count' => 3,
                        'reason' => 'High fever and doctor prescribed bed rest.',
                        'status' => 'approved',
                        'approved_at' => now(),
                    ]
                );
            } elseif ($idx === 2) {
                LeaveApplication::firstOrCreate(
                    ['employee_id' => $emp->id, 'start_date' => '2026-07-20'],
                    [
                        'leave_type_id' => $casual->id,
                        'end_date' => '2026-07-21',
                        'days_count' => 2,
                        'reason' => 'Personal urgent family work.',
                        'status' => 'pending',
                    ]
                );
            }
        }
    }
}
