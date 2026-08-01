<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Finance\Account;
use App\Models\Finance\Expense;
use App\Models\Finance\Invoice;
use App\Models\Finance\Payment;
use App\Models\Finance\Budget;
use App\Models\Employee\Employee;
use App\Models\Core\Department;

class FinanceController extends Controller
{
    /**
     * 1. Chart of Accounts
     */
    public function accounts(Request $request)
    {
        $query = Account::query();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $accounts = $query->latest()->paginate(15);

        $stats = [
            'total_accounts' => Account::count(),
            'asset_count' => Account::where('type', 'asset')->count(),
            'income_count' => Account::where('type', 'income')->count(),
            'expense_count' => Account::where('type', 'expense')->count(),
        ];

        return view('finance.accounts', compact('accounts', 'stats'));
    }

    public function storeAccount(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:asset,liability,equity,income,expense',
        ]);

        Account::create($validated);
        return redirect()->back()->with('success', 'Chart of Accounts entry added successfully.');
    }

    public function updateAccount(Request $request, Account $account)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:asset,liability,equity,income,expense',
        ]);

        $account->update($validated);
        return redirect()->back()->with('success', 'Ledger account updated successfully.');
    }

    public function destroyAccount(Account $account)
    {
        $account->delete();
        return redirect()->back()->with('success', 'Ledger account deleted.');
    }

    /**
     * 2. Expenses & Claims
     */
    public function expenses(Request $request)
    {
        $query = Expense::with('employee');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('category', 'like', "%{$request->search}%");
        }

        $expenses = $query->latest()->paginate(15);
        $employees = Employee::all();

        $stats = [
            'total_expenses' => Expense::sum('amount'),
            'approved_expenses' => Expense::where('status', 'approved')->sum('amount'),
            'pending_count' => Expense::where('status', 'pending')->count(),
            'rejected_count' => Expense::where('status', 'rejected')->count(),
        ];

        return view('finance.expenses', compact('expenses', 'employees', 'stats'));
    }

    public function storeExpense(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'employee_id' => 'nullable|exists:employees,id',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        Expense::create($validated);
        return redirect()->back()->with('success', 'Corporate expense entry recorded successfully.');
    }

    public function updateExpenseStatus(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $expense->update(['status' => $validated['status']]);
        return redirect()->back()->with('success', 'Expense claim status updated to ' . strtoupper($validated['status']) . '.');
    }

    public function destroyExpense(Expense $expense)
    {
        $expense->delete();
        return redirect()->back()->with('success', 'Expense entry deleted.');
    }

    /**
     * 3. Invoices & Billing
     */
    public function invoices(Request $request)
    {
        $query = Invoice::with('payments');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('client_name', 'like', "%{$search}%")
                  ->orWhere('invoice_number', 'like', "%{$search}%");
        }

        $invoices = $query->latest()->paginate(15);

        $stats = [
            'total_invoiced' => Invoice::sum('total_amount'),
            'paid_invoiced' => Invoice::where('status', 'paid')->sum('total_amount'),
            'sent_count' => Invoice::where('status', 'sent')->count(),
            'overdue_count' => Invoice::where('status', 'overdue')->count(),
        ];

        return view('finance.invoices', compact('invoices', 'stats'));
    }

    public function storeInvoice(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'invoice_number' => 'required|string|max:100|unique:invoices,invoice_number',
            'issue_date' => 'required|date',
            'due_date' => 'required|date',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|in:draft,sent,paid,overdue',
        ]);

        Invoice::create($validated);
        return redirect()->back()->with('success', 'Customer invoice issued successfully.');
    }

    public function updateInvoiceStatus(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'status' => 'required|in:draft,sent,paid,overdue',
        ]);

        $invoice->update(['status' => $validated['status']]);
        return redirect()->back()->with('success', 'Invoice status updated to ' . strtoupper($validated['status']) . '.');
    }

    public function destroyInvoice(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->back()->with('success', 'Invoice deleted.');
    }

    /**
     * 4. Payments Received
     */
    public function payments(Request $request)
    {
        $query = Payment::with('invoice');

        $payments = $query->latest()->paginate(15);
        $invoices = Invoice::whereNotIn('status', ['paid'])->get();

        $stats = [
            'total_collected' => Payment::sum('amount'),
            'total_payments' => Payment::count(),
            'bank_transfers' => Payment::where('method', 'Bank Transfer')->sum('amount'),
        ];

        return view('finance.payments', compact('payments', 'invoices', 'stats'));
    }

    public function storePayment(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'amount' => 'required|numeric|min:0',
            'method' => 'required|string|max:100',
            'paid_at' => 'required|date',
        ]);

        $payment = Payment::create($validated);

        // Mark invoice as paid if full payment recorded
        $invoice = Invoice::find($validated['invoice_id']);
        if ($invoice) {
            $totalPaid = $invoice->payments()->sum('amount');
            if ($totalPaid >= $invoice->total_amount) {
                $invoice->update(['status' => 'paid']);
            }
        }

        return redirect()->back()->with('success', 'Customer payment registered successfully.');
    }

    /**
     * 5. Budgets & Allocations
     */
    public function budgets(Request $request)
    {
        $query = Budget::with('department');

        if ($request->filled('search')) {
            $query->where('category', 'like', "%{$request->search}%");
        }

        $budgets = $query->latest()->paginate(15);
        $departments = Department::all();

        $stats = [
            'total_budget' => Budget::sum('allocated_amount'),
            'department_count' => Department::count(),
            'fiscal_year' => date('Y'),
        ];

        return view('finance.budgets', compact('budgets', 'departments', 'stats'));
    }

    public function storeBudget(Request $request)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'category' => 'required|string|max:255',
            'allocated_amount' => 'required|numeric|min:0',
            'year' => 'required|integer|min:2020|max:2035',
        ]);

        Budget::create($validated);
        return redirect()->back()->with('success', 'Department annual budget allocated successfully.');
    }

    public function updateBudget(Request $request, Budget $budget)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'category' => 'required|string|max:255',
            'allocated_amount' => 'required|numeric|min:0',
            'year' => 'required|integer|min:2020|max:2035',
        ]);

        $budget->update($validated);
        return redirect()->back()->with('success', 'Department budget updated.');
    }

    public function destroyBudget(Budget $budget)
    {
        $budget->delete();
        return redirect()->back()->with('success', 'Department budget deleted.');
    }
}
