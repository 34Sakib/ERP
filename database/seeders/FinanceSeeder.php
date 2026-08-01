<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Finance\Account;
use App\Models\Finance\Expense;
use App\Models\Finance\Invoice;
use App\Models\Finance\Payment;
use App\Models\Finance\Budget;
use App\Models\Employee\Employee;
use App\Models\Core\Department;

class FinanceSeeder extends Seeder
{
    public function run()
    {
        $employee = Employee::first();
        $department = Department::first();

        // 1. Seed Accounts
        Account::firstOrCreate(['name' => '1010 - Operating Cash Account'], ['type' => 'asset']);
        Account::firstOrCreate(['name' => '1200 - Accounts Receivable'], ['type' => 'asset']);
        Account::firstOrCreate(['name' => '2010 - Accounts Payable'], ['type' => 'liability']);
        Account::firstOrCreate(['name' => '4010 - Enterprise Software Sales Revenue'], ['type' => 'income']);
        Account::firstOrCreate(['name' => '5020 - Corporate Office Utilities & Expenses'], ['type' => 'expense']);

        // 2. Seed Expenses
        Expense::firstOrCreate(
            ['category' => 'Cloud Infrastructure & Hosting'],
            [
                'amount' => 4250.00,
                'date' => '2026-07-15',
                'employee_id' => $employee?->id,
                'status' => 'approved',
            ]
        );

        Expense::firstOrCreate(
            ['category' => 'Executive Travel & Client Hospitality'],
            [
                'amount' => 1200.00,
                'date' => '2026-07-18',
                'employee_id' => $employee?->id,
                'status' => 'pending',
            ]
        );

        // 3. Seed Invoices
        $inv1 = Invoice::firstOrCreate(
            ['invoice_number' => 'INV-2026-001'],
            [
                'client_name' => 'Acme Corporation',
                'issue_date' => '2026-07-01',
                'due_date' => '2026-07-31',
                'status' => 'paid',
                'total_amount' => 125000.00,
            ]
        );

        $inv2 = Invoice::firstOrCreate(
            ['invoice_number' => 'INV-2026-002'],
            [
                'client_name' => 'Cyberdyne Systems',
                'issue_date' => '2026-07-10',
                'due_date' => '2026-08-10',
                'status' => 'sent',
                'total_amount' => 85000.00,
            ]
        );

        // 4. Seed Payments
        Payment::firstOrCreate(
            ['invoice_id' => $inv1->id],
            [
                'amount' => 125000.00,
                'method' => 'Bank Wire Transfer',
                'paid_at' => '2026-07-20 14:30:00',
            ]
        );

        // 5. Seed Budgets
        if ($department) {
            Budget::firstOrCreate(
                ['department_id' => $department->id, 'category' => 'Software R&D & Engineering', 'year' => 2026],
                ['allocated_amount' => 500000.00]
            );

            Budget::firstOrCreate(
                ['department_id' => $department->id, 'category' => 'Global Marketing & Brand Outreach', 'year' => 2026],
                ['allocated_amount' => 250000.00]
            );
        }
    }
}
