<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Core\Company;
use App\Models\Employee\Employee;
use App\Models\Project\Project;
use App\Models\Project\Task;
use App\Models\Project\TimeLog;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        $company = Company::first();
        $employee = Employee::first();

        if (!$company) {
            return;
        }

        // 1. Seed Projects
        $p1 = Project::firstOrCreate(
            ['name' => 'Enterprise ERP Core Architecture & System Modernization'],
            [
                'company_id' => $company->id,
                'client_name' => 'Acme Corporation',
                'start_date' => '2026-06-01',
                'end_date' => '2026-12-31',
                'status' => 'active',
                'budget' => 150000.00,
            ]
        );

        $p2 = Project::firstOrCreate(
            ['name' => 'Cross-Platform Mobile App V2 Suite Development'],
            [
                'company_id' => $company->id,
                'client_name' => 'Cyberdyne Systems',
                'start_date' => '2026-07-01',
                'end_date' => '2026-10-31',
                'status' => 'active',
                'budget' => 95000.00,
            ]
        );

        // 2. Seed Tasks
        $t1 = Task::firstOrCreate(
            ['title' => 'Design scalable database schema & relational entity diagrams'],
            [
                'project_id' => $p1->id,
                'description' => 'Architect multi-tenant database models for finance, inventory, and payroll.',
                'assigned_to' => 1,
                'priority' => 'high',
                'status' => 'in_progress',
                'due_date' => '2026-07-30',
            ]
        );

        $t2 = Task::firstOrCreate(
            ['title' => 'Implement soft-pastel UI component library & dark mode styles'],
            [
                'project_id' => $p1->id,
                'description' => 'Build high-fidelity UI cards matching 1:1 image reference styling.',
                'assigned_to' => 1,
                'priority' => 'urgent',
                'status' => 'done',
                'due_date' => '2026-07-25',
            ]
        );

        // 3. Seed Timelogs
        if ($employee) {
            TimeLog::firstOrCreate(
                ['task_id' => $t1->id, 'employee_id' => $employee->id, 'date' => '2026-07-24'],
                ['hours' => 7.5, 'note' => 'Worked on Eloquent model associations and migration indexing.']
            );

            TimeLog::firstOrCreate(
                ['task_id' => $t2->id, 'employee_id' => $employee->id, 'date' => '2026-07-25'],
                ['hours' => 8.0, 'note' => 'Refactored Blade template views and integrated SweetAlert popups.']
            );
        }
    }
}
