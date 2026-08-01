<?php

return [
    /*
    |--------------------------------------------------------------------------
    | ERP Sidebar Navigation Structure
    |--------------------------------------------------------------------------
    | Multi-level recursive sidebar configuration driven by spatie permission checks.
    |
    */

    'items' => [
        [
            'label' => 'Dashboard',
            'icon' => 'bi bi-grid-1x2-fill',
            'route' => 'dashboard',
            'permission' => null,
        ],
        [
            'label' => 'HR Core',
            'icon' => 'bi bi-people-fill',
            'permission' => 'employee.view',
            'children' => [
                ['label' => 'All Employees', 'route' => 'employees.index', 'permission' => 'employee.view'],
                ['label' => 'Add Employee', 'route' => 'employees.create', 'permission' => 'employee.create'],
                ['label' => 'Document Expiry', 'route' => 'employees.documents.expiry', 'permission' => 'employee.view'],
            ],
        ],
        [
            'label' => 'Attendance',
            'icon' => 'bi bi-clock-history',
            'permission' => 'attendance.view',
            'children' => [
                ['label' => 'Daily Attendance', 'route' => 'attendance.index', 'permission' => 'attendance.view'],
                ['label' => 'My Attendance', 'route' => 'attendance.my', 'permission' => 'attendance.view'],
                ['label' => 'Shifts', 'route' => 'shifts.index', 'permission' => 'attendance.manage'],
                ['label' => 'Holidays', 'route' => 'holidays.index', 'permission' => 'attendance.manage'],
                ['label' => 'Regularizations', 'route' => 'attendance.regularizations.index', 'permission' => 'attendance.manage'],
            ],
        ],
        [
            'label' => 'Leave Management',
            'icon' => 'bi bi-calendar2-check-fill',
            'permission' => 'leave.view',
            'children' => [
                ['label' => 'My Leave', 'route' => 'leave.my', 'permission' => 'leave.view'],
                ['label' => 'Apply Leave', 'route' => 'leave.apply', 'permission' => 'leave.create'],
                ['label' => 'Approval Queue', 'route' => 'leave.approvals', 'permission' => 'leave.approve'],
                ['label' => 'Leave Types', 'route' => 'leave-types.index', 'permission' => 'leave.manage'],
            ],
        ],
        [
            'label' => 'Payroll',
            'icon' => 'bi bi-cash-stack',
            'permission' => 'salary.view',
            'children' => [
                ['label' => 'Salary Structures', 'route' => 'payroll.structures.index', 'permission' => 'salary.view'],
                ['label' => 'Payroll Runs', 'route' => 'payroll.runs.index', 'permission' => 'payroll.generate'],
                ['label' => 'Payslips', 'route' => 'payroll.payslips.index', 'permission' => 'salary.view'],
                ['label' => 'Loans & Advances', 'route' => 'payroll.loans.index', 'permission' => 'salary.view'],
            ],
        ],
        [
            'label' => 'Recruitment',
            'icon' => 'bi bi-person-plus-fill',
            'permission' => 'recruitment.manage',
            'children' => [
                ['label' => 'Job Posts', 'route' => 'recruitment.jobs.index', 'permission' => 'recruitment.manage'],
                ['label' => 'Applicants Kanban', 'route' => 'recruitment.applicants.index', 'permission' => 'recruitment.manage'],
                ['label' => 'Interviews', 'route' => 'recruitment.interviews.index', 'permission' => 'recruitment.manage'],
            ],
        ],
        [
            'label' => 'Asset Management',
            'icon' => 'bi bi-box-seam-fill',
            'permission' => 'asset.manage',
            'children' => [
                ['label' => 'Asset Inventory', 'route' => 'assets.index', 'permission' => 'asset.manage'],
                ['label' => 'Assignments', 'route' => 'assets.assignments', 'permission' => 'asset.manage'],
                ['label' => 'Maintenance Log', 'route' => 'assets.maintenance', 'permission' => 'asset.manage'],
            ],
        ],
        [
            'label' => 'CRM',
            'icon' => 'bi bi-pie-chart-fill',
            'permission' => 'crm.manage',
            'children' => [
                ['label' => 'Leads', 'route' => 'crm.leads.index', 'permission' => 'crm.manage'],
                ['label' => 'Deals Kanban', 'route' => 'crm.deals.index', 'permission' => 'crm.manage'],
                ['label' => 'CRM Companies', 'route' => 'crm.companies.index', 'permission' => 'crm.manage'],
                ['label' => 'Tasks & Meetings', 'route' => 'crm.tasks.index', 'permission' => 'crm.manage'],
            ],
        ],
        [
            'label' => 'Inventory',
            'icon' => 'bi bi-tags-fill',
            'permission' => 'inventory.manage',
            'children' => [
                ['label' => 'Products', 'route' => 'inventory.products.index', 'permission' => 'inventory.manage'],
                ['label' => 'Warehouses', 'route' => 'inventory.warehouses.index', 'permission' => 'inventory.manage'],
                ['label' => 'Suppliers', 'route' => 'inventory.suppliers.index', 'permission' => 'inventory.manage'],
                ['label' => 'Purchase Orders', 'route' => 'inventory.purchase-orders.index', 'permission' => 'inventory.manage'],
                ['label' => 'Stock Movements', 'route' => 'inventory.stock-movements.index', 'permission' => 'inventory.manage'],
            ],
        ],
        [
            'label' => 'Finance',
            'icon' => 'bi bi-bank2',
            'permission' => 'finance.manage',
            'children' => [
                ['label' => 'Accounts', 'route' => 'finance.accounts.index', 'permission' => 'finance.manage'],
                ['label' => 'Expenses', 'route' => 'finance.expenses.index', 'permission' => 'finance.manage'],
                ['label' => 'Invoices', 'route' => 'finance.invoices.index', 'permission' => 'finance.manage'],
                ['label' => 'Payments', 'route' => 'finance.payments.index', 'permission' => 'finance.manage'],
                ['label' => 'Budgets', 'route' => 'finance.budgets.index', 'permission' => 'finance.manage'],
            ],
        ],
        [
            'label' => 'Projects',
            'icon' => 'bi bi-kanban-fill',
            'permission' => 'project.manage',
            'children' => [
                ['label' => 'All Projects', 'route' => 'projects.index', 'permission' => 'project.manage'],
                ['label' => 'My Tasks', 'route' => 'projects.tasks.my', 'permission' => 'project.manage'],
                ['label' => 'Time Logs', 'route' => 'projects.timelogs.index', 'permission' => 'project.manage'],
            ],
        ],
        [
            'label' => 'Notice Board',
            'icon' => 'bi bi-megaphone-fill',
            'permission' => 'noticeboard.view',
            'route' => 'noticeboard.index',
        ],
        [
            'label' => 'Calendar',
            'icon' => 'bi bi-calendar-event-fill',
            'permission' => 'calendar.view',
            'route' => 'calendar.index',
        ],
        [
            'label' => 'Settings',
            'icon' => 'bi bi-gear-fill',
            'permission' => 'company.manage',
            'children' => [
                ['label' => 'Companies', 'route' => 'companies.index', 'permission' => 'company.manage'],
                ['label' => 'Branches', 'route' => 'branches.index', 'permission' => 'company.manage'],
                ['label' => 'Departments', 'route' => 'departments.index', 'permission' => 'company.manage'],
                ['label' => 'Designations', 'route' => 'designations.index', 'permission' => 'company.manage'],
                ['label' => 'Teams', 'route' => 'teams.index', 'permission' => 'company.manage'],
                ['label' => 'Roles & Permissions', 'route' => 'roles.index', 'permission' => 'role.manage'],
                ['label' => 'Audit Logs', 'route' => 'audit-logs.index', 'permission' => 'role.manage'],
            ],
        ],
    ],
];
