<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;
use App\Models\Core\Company;
use App\Models\Core\Branch;
use App\Models\Core\Department;
use App\Models\Core\Designation;
use App\Models\Employee\Employee;
use Illuminate\Support\Facades\Hash;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Define Modules & Permissions Matrix
        $permissions = [
            'Company Structure' => [
                'company.view',
                'company.manage',
            ],
            'Access Control' => [
                'role.view',
                'role.manage',
                'audit.view',
            ],
            'Employees' => [
                'employee.view',
                'employee.create',
                'employee.edit',
                'employee.delete',
            ],
            'Attendance' => [
                'attendance.view',
                'attendance.create',
                'attendance.edit',
                'attendance.manage',
            ],
            'Leave Management' => [
                'leave.view',
                'leave.create',
                'leave.approve',
                'leave.manage',
            ],
            'Payroll' => [
                'salary.view',
                'salary.manage',
                'payroll.generate',
            ],
            'Recruitment' => [
                'recruitment.view',
                'recruitment.manage',
            ],
            'Asset Management' => [
                'asset.view',
                'asset.manage',
            ],
            'CRM' => [
                'crm.view',
                'crm.manage',
            ],
            'Inventory' => [
                'inventory.view',
                'inventory.manage',
            ],
            'Finance' => [
                'finance.view',
                'finance.manage',
            ],
            'Project Management' => [
                'project.view',
                'project.manage',
            ],
            'Notice Board' => [
                'noticeboard.view',
                'noticeboard.manage',
            ],
            'Calendar' => [
                'calendar.view',
            ],
            'Messaging & Notifications' => [
                'messaging.view',
                'messaging.manage',
            ],
            'Reports' => [
                'reports.view',
                'reports.export',
            ],
        ];

        // Create Permissions
        foreach ($permissions as $group => $perms) {
            foreach ($perms as $perm) {
                Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
            }
        }

        // 2. Create Roles
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $hrRole = Role::firstOrCreate(['name' => 'HR', 'guard_name' => 'web']);
        $managerRole = Role::firstOrCreate(['name' => 'Manager', 'guard_name' => 'web']);
        $employeeRole = Role::firstOrCreate(['name' => 'Employee', 'guard_name' => 'web']);

        // Super Admin gets all permissions
        $superAdminRole->syncPermissions(Permission::all());

        // Admin permissions
        $adminRole->syncPermissions(Permission::all());

        // HR permissions
        $hrPermissions = [
            'company.view', 'employee.view', 'employee.create', 'employee.edit', 'employee.delete',
            'attendance.view', 'attendance.create', 'attendance.edit', 'attendance.manage',
            'leave.view', 'leave.create', 'leave.approve', 'leave.manage',
            'salary.view', 'salary.manage', 'payroll.generate',
            'recruitment.view', 'recruitment.manage',
            'asset.view', 'asset.manage', 'noticeboard.view', 'noticeboard.manage',
            'calendar.view', 'messaging.view', 'reports.view', 'reports.export'
        ];
        $hrRole->syncPermissions($hrPermissions);

        // Manager permissions
        $managerPermissions = [
            'company.view', 'employee.view',
            'attendance.view', 'attendance.create', 'attendance.edit', 'attendance.manage',
            'leave.view', 'leave.create', 'leave.approve',
            'recruitment.view', 'asset.view', 'crm.view', 'crm.manage',
            'project.view', 'project.manage', 'noticeboard.view', 'calendar.view', 'messaging.view', 'reports.view'
        ];
        $managerRole->syncPermissions($managerPermissions);

        // Employee permissions
        $employeePermissions = [
            'company.view', 'attendance.view', 'attendance.create',
            'leave.view', 'leave.create', 'salary.view',
            'noticeboard.view', 'calendar.view', 'messaging.view'
        ];
        $employeeRole->syncPermissions($employeePermissions);

        // 3. Create Sample Company, Branch, Department, Designation
        $company = Company::firstOrCreate([
            'name' => 'Acme Global Corporation',
        ], [
            'code' => 'ACME-01',
            'email' => 'contact@acme.com',
            'phone' => '+1 (555) 019-2834',
            'address' => '100 Innovation Way, Silicon Valley, CA',
            'timezone' => 'America/Los_Angeles',
            'currency' => 'USD',
            'status' => true,
        ]);

        $branch = Branch::firstOrCreate([
            'company_id' => $company->id,
            'name' => 'Headquarters (HQ)',
        ], [
            'code' => 'HQ-01',
            'phone' => '+1 (555) 019-2835',
            'address' => '100 Innovation Way, Building A',
            'status' => true,
        ]);

        $engDept = Department::firstOrCreate([
            'company_id' => $company->id,
            'branch_id' => $branch->id,
            'name' => 'Engineering',
        ], [
            'code' => 'ENG',
            'status' => true,
        ]);

        $hrDept = Department::firstOrCreate([
            'company_id' => $company->id,
            'branch_id' => $branch->id,
            'name' => 'Human Resources',
        ], [
            'code' => 'HR',
            'status' => true,
        ]);

        $desigDev = Designation::firstOrCreate([
            'department_id' => $engDept->id,
            'title' => 'Senior Software Engineer',
        ], [
            'level' => 3,
            'status' => true,
        ]);

        $desigHR = Designation::firstOrCreate([
            'department_id' => $hrDept->id,
            'title' => 'HR Manager',
        ], [
            'level' => 4,
            'status' => true,
        ]);

        // 4. Create System Users
        $superAdminUser = User::firstOrCreate([
            'email' => 'admin@erp.com',
        ], [
            'company_id' => $company->id,
            'branch_id' => $branch->id,
            'department_id' => $engDept->id,
            'name' => 'System Super Admin',
            'password' => Hash::make('12345678'),
            'status' => true,
        ]);
        $superAdminUser->assignRole($superAdminRole);

        $hrUser = User::firstOrCreate([
            'email' => 'hr@erp.com',
        ], [
            'company_id' => $company->id,
            'branch_id' => $branch->id,
            'department_id' => $hrDept->id,
            'name' => 'Sarah Connor (HR Admin)',
            'password' => Hash::make('12345678'),
            'status' => true,
        ]);
        $hrUser->assignRole($hrRole);

        $managerUser = User::firstOrCreate([
            'email' => 'manager@erp.com',
        ], [
            'company_id' => $company->id,
            'branch_id' => $branch->id,
            'department_id' => $engDept->id,
            'name' => 'Alex Rivera (Engineering Lead)',
            'password' => Hash::make('12345678'),
            'status' => true,
        ]);
        $managerUser->assignRole($managerRole);

        $employeeUser = User::firstOrCreate([
            'email' => 'employee@erp.com',
        ], [
            'company_id' => $company->id,
            'branch_id' => $branch->id,
            'department_id' => $engDept->id,
            'name' => 'John Doe (Software Engineer)',
            'password' => Hash::make('12345678'),
            'status' => true,
        ]);
        $employeeUser->assignRole($employeeRole);

        // 5. Create Employee Records
        $emp1 = Employee::firstOrCreate([
            'employee_code' => 'EMP-001',
        ], [
            'user_id' => $superAdminUser->id,
            'company_id' => $company->id,
            'branch_id' => $branch->id,
            'department_id' => $engDept->id,
            'designation_id' => $desigDev->id,
            'first_name' => 'System',
            'last_name' => 'Admin',
            'gender' => 'male',
            'dob' => '1990-01-15',
            'phone' => '+1555019001',
            'personal_email' => 'admin@erp.com',
            'joining_date' => '2023-01-01',
            'employment_status' => 'active',
        ]);
        $superAdminUser->update(['employee_id' => $emp1->id]);

        $emp2 = Employee::firstOrCreate([
            'employee_code' => 'EMP-002',
        ], [
            'user_id' => $hrUser->id,
            'company_id' => $company->id,
            'branch_id' => $branch->id,
            'department_id' => $hrDept->id,
            'designation_id' => $desigHR->id,
            'first_name' => 'Sarah',
            'last_name' => 'Connor',
            'gender' => 'female',
            'dob' => '1992-05-20',
            'phone' => '+1555019002',
            'personal_email' => 'hr@erp.com',
            'joining_date' => '2023-03-10',
            'employment_status' => 'active',
        ]);
        $hrUser->update(['employee_id' => $emp2->id]);

        $mktDept = Department::firstOrCreate([
            'company_id' => $company->id,
            'branch_id' => $branch->id,
            'name' => 'Marketing & Sales',
        ], [
            'code' => 'MKT',
            'status' => true,
        ]);

        $finDept = Department::firstOrCreate([
            'company_id' => $company->id,
            'branch_id' => $branch->id,
            'name' => 'Finance & Accounting',
        ], [
            'code' => 'FIN',
            'status' => true,
        ]);

        $opsDept = Department::firstOrCreate([
            'company_id' => $company->id,
            'branch_id' => $branch->id,
            'name' => 'Operations & Logistics',
        ], [
            'code' => 'OPS',
            'status' => true,
        ]);

        $emp3 = Employee::firstOrCreate([
            'employee_code' => 'EMP-003',
        ], [
            'user_id' => $employeeUser->id,
            'company_id' => $company->id,
            'branch_id' => $branch->id,
            'department_id' => $engDept->id,
            'designation_id' => $desigDev->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'gender' => 'male',
            'dob' => '1995-08-12',
            'phone' => '+1555019003',
            'personal_email' => 'john.doe@example.com',
            'joining_date' => '2024-02-01',
            'employment_status' => 'probation',
        ]);
        $employeeUser->update(['employee_id' => $emp3->id]);

        // Additional Sample Employees
        $sampleEmps = [
            ['code' => 'EMP-004', 'first' => 'Emily', 'last' => 'Watson', 'dept' => $mktDept->id, 'email' => 'emily.w@example.com', 'status' => 'active', 'date' => '2023-05-15'],
            ['code' => 'EMP-005', 'first' => 'Michael', 'last' => 'Brown', 'dept' => $finDept->id, 'email' => 'm.brown@example.com', 'status' => 'active', 'date' => '2023-06-01'],
            ['code' => 'EMP-006', 'first' => 'Jessica', 'last' => 'Taylor', 'dept' => $opsDept->id, 'email' => 'j.taylor@example.com', 'status' => 'probation', 'date' => '2024-01-10'],
            ['code' => 'EMP-007', 'first' => 'David', 'last' => 'Miller', 'dept' => $engDept->id, 'email' => 'd.miller@example.com', 'status' => 'active', 'date' => '2023-09-01'],
            ['code' => 'EMP-008', 'first' => 'Sophia', 'last' => 'Davis', 'dept' => $hrDept->id, 'email' => 'sophia.d@example.com', 'status' => 'active', 'date' => '2023-11-15'],
            ['code' => 'EMP-009', 'first' => 'James', 'last' => 'Wilson', 'dept' => $mktDept->id, 'email' => 'j.wilson@example.com', 'status' => 'probation', 'date' => '2024-03-01'],
        ];

        foreach ($sampleEmps as $s) {
            Employee::firstOrCreate([
                'employee_code' => $s['code'],
            ], [
                'company_id' => $company->id,
                'branch_id' => $branch->id,
                'department_id' => $s['dept'],
                'first_name' => $s['first'],
                'last_name' => $s['last'],
                'gender' => 'other',
                'personal_email' => $s['email'],
                'joining_date' => $s['date'],
                'employment_status' => $s['status'],
            ]);
        }
    }
}
