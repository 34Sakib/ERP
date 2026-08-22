<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Core\CompanyController;
use App\Http\Controllers\Core\BranchController;
use App\Http\Controllers\Core\DepartmentController;
use App\Http\Controllers\AccessControl\RoleController;
use App\Http\Controllers\Employee\EmployeeController;

use App\Http\Controllers\Attendance\AttendanceController;
use App\Http\Controllers\Leave\LeaveController;
use App\Http\Controllers\Payroll\PayrollController;
use App\Http\Controllers\Recruitment\RecruitmentController;
use App\Http\Controllers\Asset\AssetController;
use App\Http\Controllers\CRM\CrmController;
use App\Http\Controllers\Inventory\InventoryController;
use App\Http\Controllers\Finance\FinanceController;
use App\Http\Controllers\Project\ProjectController;
use App\Http\Controllers\NoticeBoard\NoticeBoardController;
use App\Http\Controllers\Calendar\CalendarController;
use App\Http\Controllers\Core\ProfileController;
use App\Http\Controllers\Core\NotificationController;

// Redirect root to dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Authenticated ERP Core Routes
Route::middleware(['auth'])->group(function () {
    // 1. Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Notifications API Routes
    Route::post('notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::get('notifications/fetch', [NotificationController::class, 'fetch'])->name('notifications.fetch');

    // 2. Core Structure Routes
    Route::resource('companies', CompanyController::class)->except(['create', 'edit']);
    Route::resource('branches', BranchController::class)->except(['create', 'edit']);
    Route::resource('departments', DepartmentController::class)->except(['create', 'edit']);
    
    // Designations CRUD
    Route::get('designations', [DepartmentController::class, 'designations'])->name('designations.index');
    Route::post('designations', [DepartmentController::class, 'storeDesignation'])->name('designations.store');
    Route::put('designations/{designation}', [DepartmentController::class, 'updateDesignation'])->name('designations.update');
    Route::delete('designations/{designation}', [DepartmentController::class, 'destroyDesignation'])->name('designations.destroy');

    // Teams CRUD
    Route::get('teams', [DepartmentController::class, 'teams'])->name('teams.index');
    Route::post('teams', [DepartmentController::class, 'storeTeam'])->name('teams.store');
    Route::put('teams/{team}', [DepartmentController::class, 'updateTeam'])->name('teams.update');
    Route::delete('teams/{team}', [DepartmentController::class, 'destroyTeam'])->name('teams.destroy');

    // 3. Access Control RBAC Routes
    Route::resource('roles', RoleController::class)->except(['create', 'edit']);
    Route::get('audit-logs', [RoleController::class, 'auditLogs'])->name('audit-logs.index');

    // 4. Employee Module Routes
    Route::get('employees/search/api', [EmployeeController::class, 'apiSearch'])->name('employees.search.api');
    Route::resource('employees', EmployeeController::class);
    Route::get('employees/documents/expiry', [EmployeeController::class, 'index'])->name('employees.documents.expiry');

    // 5. Attendance Module Routes
    Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('attendance/store', [AttendanceController::class, 'storeManual'])->name('attendance.store');
    Route::post('attendance/punch', [AttendanceController::class, 'togglePunch'])->name('attendance.punch');
    Route::get('attendance/my', [AttendanceController::class, 'myAttendance'])->name('attendance.my');

    // Shift CRUD
    Route::get('shifts', [AttendanceController::class, 'shifts'])->name('shifts.index');
    Route::post('shifts', [AttendanceController::class, 'storeShift'])->name('shifts.store');
    Route::put('shifts/{shift}', [AttendanceController::class, 'updateShift'])->name('shifts.update');
    Route::delete('shifts/{shift}', [AttendanceController::class, 'destroyShift'])->name('shifts.destroy');

    // Holiday CRUD
    Route::get('holidays', [AttendanceController::class, 'holidays'])->name('holidays.index');
    Route::post('holidays', [AttendanceController::class, 'storeHoliday'])->name('holidays.store');
    Route::put('holidays/{holiday}', [AttendanceController::class, 'updateHoliday'])->name('holidays.update');
    Route::delete('holidays/{holiday}', [AttendanceController::class, 'destroyHoliday'])->name('holidays.destroy');

    // Regularizations
    Route::get('attendance/regularizations', [AttendanceController::class, 'regularizations'])->name('attendance.regularizations.index');
    Route::post('attendance/regularizations', [AttendanceController::class, 'storeRegularization'])->name('attendance.regularizations.store');
    Route::post('attendance/regularizations/{regularization}/approve', [AttendanceController::class, 'approveRegularization'])->name('attendance.regularizations.approve');
    Route::post('attendance/regularizations/{regularization}/reject', [AttendanceController::class, 'rejectRegularization'])->name('attendance.regularizations.reject');

    // 6. Leave Management Routes
    Route::get('leave', [LeaveController::class, 'myLeave'])->name('leave.index');
    Route::get('leave/my', [LeaveController::class, 'myLeave'])->name('leave.my');
    Route::get('leave/apply', [LeaveController::class, 'apply'])->name('leave.apply');
    Route::post('leave/store', [LeaveController::class, 'storeApplication'])->name('leave.store');
    Route::post('leave/{application}/cancel', [LeaveController::class, 'cancelApplication'])->name('leave.cancel');

    // Approvals Queue
    Route::get('leave/approvals', [LeaveController::class, 'approvals'])->name('leave.approvals');
    Route::post('leave/approvals/{application}/approve', [LeaveController::class, 'approveApplication'])->name('leave.approve');
    Route::post('leave/approvals/{application}/reject', [LeaveController::class, 'rejectApplication'])->name('leave.reject');

    // Leave Types CRUD
    Route::get('leave-types', [LeaveController::class, 'leaveTypes'])->name('leave-types.index');
    Route::post('leave-types', [LeaveController::class, 'storeLeaveType'])->name('leave-types.store');
    Route::put('leave-types/{leaveType}', [LeaveController::class, 'updateLeaveType'])->name('leave-types.update');
    Route::delete('leave-types/{leaveType}', [LeaveController::class, 'destroyLeaveType'])->name('leave-types.destroy');

    // 7. Payroll Module Routes
    Route::get('payroll', [PayrollController::class, 'runs'])->name('payroll.index');
    Route::get('payroll/structures', [PayrollController::class, 'structures'])->name('payroll.structures.index');
    Route::post('payroll/structures', [PayrollController::class, 'storeStructure'])->name('payroll.structures.store');
    Route::put('payroll/structures/{structure}', [PayrollController::class, 'updateStructure'])->name('payroll.structures.update');
    Route::delete('payroll/structures/{structure}', [PayrollController::class, 'destroyStructure'])->name('payroll.structures.destroy');

    // Payroll Runs
    Route::get('payroll/runs', [PayrollController::class, 'runs'])->name('payroll.runs.index');
    Route::post('payroll/runs', [PayrollController::class, 'storeRun'])->name('payroll.runs.store');
    Route::post('payroll/runs/{run}/approve', [PayrollController::class, 'approveRun'])->name('payroll.runs.approve');

    // Payslips
    Route::get('payroll/payslips', [PayrollController::class, 'payslips'])->name('payroll.payslips.index');
    Route::get('payroll/payslips/{payslip}', [PayrollController::class, 'showPayslip'])->name('payroll.payslips.show');

    // Loans & Advances
    Route::get('payroll/loans', [PayrollController::class, 'loans'])->name('payroll.loans.index');
    Route::post('payroll/loans', [PayrollController::class, 'storeLoan'])->name('payroll.loans.store');
    Route::post('payroll/loans/{loan}/approve', [PayrollController::class, 'approveLoan'])->name('payroll.loans.approve');
    Route::post('payroll/loans/{loan}/reject', [PayrollController::class, 'rejectLoan'])->name('payroll.loans.reject');

    // 8. Recruitment Module Routes
    Route::get('recruitment', [RecruitmentController::class, 'jobs'])->name('recruitment.index');
    Route::get('recruitment/jobs', [RecruitmentController::class, 'jobs'])->name('recruitment.jobs.index');
    Route::post('recruitment/jobs', [RecruitmentController::class, 'storeJob'])->name('recruitment.jobs.store');
    Route::put('recruitment/jobs/{job}', [RecruitmentController::class, 'updateJob'])->name('recruitment.jobs.update');
    Route::delete('recruitment/jobs/{job}', [RecruitmentController::class, 'destroyJob'])->name('recruitment.jobs.destroy');

    // Applicants
    Route::get('recruitment/applicants', [RecruitmentController::class, 'applicants'])->name('recruitment.applicants.index');
    Route::post('recruitment/applicants', [RecruitmentController::class, 'storeApplicant'])->name('recruitment.applicants.store');
    Route::post('recruitment/applicants/{applicant}/status', [RecruitmentController::class, 'updateApplicantStatus'])->name('recruitment.applicants.status');

    // Interviews
    Route::get('recruitment/interviews', [RecruitmentController::class, 'interviews'])->name('recruitment.interviews.index');
    Route::post('recruitment/interviews', [RecruitmentController::class, 'storeInterview'])->name('recruitment.interviews.store');
    Route::post('recruitment/interviews/{interview}/feedback', [RecruitmentController::class, 'updateInterviewFeedback'])->name('recruitment.interviews.feedback');

    // 9. Asset Management Routes
    Route::get('assets', [AssetController::class, 'index'])->name('assets.index');
    Route::post('assets', [AssetController::class, 'storeAsset'])->name('assets.store');
    Route::put('assets/{asset}', [AssetController::class, 'updateAsset'])->name('assets.update');
    Route::delete('assets/{asset}', [AssetController::class, 'destroyAsset'])->name('assets.destroy');

    // Assignments
    Route::get('assets/assignments', [AssetController::class, 'assignments'])->name('assets.assignments');
    Route::post('assets/assignments', [AssetController::class, 'storeAssignment'])->name('assets.assignments.store');
    Route::post('assets/assignments/{assignment}/return', [AssetController::class, 'returnAssignment'])->name('assets.assignments.return');

    // Maintenance
    Route::get('assets/maintenance', [AssetController::class, 'maintenance'])->name('assets.maintenance');
    Route::post('assets/maintenance', [AssetController::class, 'storeMaintenance'])->name('assets.maintenance.store');

    // 10. CRM Module Routes
    Route::get('crm/leads', [CrmController::class, 'leads'])->name('crm.leads.index');
    Route::post('crm/leads', [CrmController::class, 'storeLead'])->name('crm.leads.store');
    Route::post('crm/leads/{lead}/status', [CrmController::class, 'updateLeadStatus'])->name('crm.leads.status');
    Route::delete('crm/leads/{lead}', [CrmController::class, 'destroyLead'])->name('crm.leads.destroy');

    // Deals Pipeline
    Route::get('crm/deals', [CrmController::class, 'deals'])->name('crm.deals.index');
    Route::post('crm/deals', [CrmController::class, 'storeDeal'])->name('crm.deals.store');
    Route::post('crm/deals/{deal}/stage', [CrmController::class, 'updateDealStage'])->name('crm.deals.stage');
    Route::delete('crm/deals/{deal}', [CrmController::class, 'destroyDeal'])->name('crm.deals.destroy');

    // Client Companies
    Route::get('crm/companies', [CrmController::class, 'companies'])->name('crm.companies.index');
    Route::post('crm/companies', [CrmController::class, 'storeCompany'])->name('crm.companies.store');
    Route::put('crm/companies/{company}', [CrmController::class, 'updateCompany'])->name('crm.companies.update');
    Route::delete('crm/companies/{company}', [CrmController::class, 'destroyCompany'])->name('crm.companies.destroy');

    // CRM Tasks
    Route::get('crm/tasks', [CrmController::class, 'tasks'])->name('crm.tasks.index');
    Route::post('crm/tasks', [CrmController::class, 'storeTask'])->name('crm.tasks.store');
    Route::post('crm/tasks/{task}/toggle', [CrmController::class, 'toggleTaskStatus'])->name('crm.tasks.toggle');

    // 11. Inventory Module Routes
    Route::get('inventory/products', [InventoryController::class, 'products'])->name('inventory.products.index');
    Route::post('inventory/products', [InventoryController::class, 'storeProduct'])->name('inventory.products.store');
    Route::put('inventory/products/{product}', [InventoryController::class, 'updateProduct'])->name('inventory.products.update');
    Route::delete('inventory/products/{product}', [InventoryController::class, 'destroyProduct'])->name('inventory.products.destroy');

    // Warehouses
    Route::get('inventory/warehouses', [InventoryController::class, 'warehouses'])->name('inventory.warehouses.index');
    Route::post('inventory/warehouses', [InventoryController::class, 'storeWarehouse'])->name('inventory.warehouses.store');
    Route::put('inventory/warehouses/{warehouse}', [InventoryController::class, 'updateWarehouse'])->name('inventory.warehouses.update');
    Route::delete('inventory/warehouses/{warehouse}', [InventoryController::class, 'destroyWarehouse'])->name('inventory.warehouses.destroy');

    // Suppliers
    Route::get('inventory/suppliers', [InventoryController::class, 'suppliers'])->name('inventory.suppliers.index');
    Route::post('inventory/suppliers', [InventoryController::class, 'storeSupplier'])->name('inventory.suppliers.store');
    Route::put('inventory/suppliers/{supplier}', [InventoryController::class, 'updateSupplier'])->name('inventory.suppliers.update');
    Route::delete('inventory/suppliers/{supplier}', [InventoryController::class, 'destroySupplier'])->name('inventory.suppliers.destroy');

    // Purchase Orders
    Route::get('inventory/purchase-orders', [InventoryController::class, 'purchaseOrders'])->name('inventory.purchase-orders.index');
    Route::post('inventory/purchase-orders', [InventoryController::class, 'storePurchaseOrder'])->name('inventory.purchase-orders.store');
    Route::post('inventory/purchase-orders/{order}/status', [InventoryController::class, 'updatePOStatus'])->name('inventory.purchase-orders.status');

    // Stock Movements
    Route::get('inventory/stock-movements', [InventoryController::class, 'stockMovements'])->name('inventory.stock-movements.index');
    Route::post('inventory/stock-movements', [InventoryController::class, 'storeStockMovement'])->name('inventory.stock-movements.store');

    // 12. Finance Module Routes
    Route::get('finance/accounts', [FinanceController::class, 'accounts'])->name('finance.accounts.index');
    Route::post('finance/accounts', [FinanceController::class, 'storeAccount'])->name('finance.accounts.store');
    Route::put('finance/accounts/{account}', [FinanceController::class, 'updateAccount'])->name('finance.accounts.update');
    Route::delete('finance/accounts/{account}', [FinanceController::class, 'destroyAccount'])->name('finance.accounts.destroy');

    // Expenses
    Route::get('finance/expenses', [FinanceController::class, 'expenses'])->name('finance.expenses.index');
    Route::post('finance/expenses', [FinanceController::class, 'storeExpense'])->name('finance.expenses.store');
    Route::post('finance/expenses/{expense}/status', [FinanceController::class, 'updateExpenseStatus'])->name('finance.expenses.status');
    Route::delete('finance/expenses/{expense}', [FinanceController::class, 'destroyExpense'])->name('finance.expenses.destroy');

    // Invoices
    Route::get('finance/invoices', [FinanceController::class, 'invoices'])->name('finance.invoices.index');
    Route::post('finance/invoices', [FinanceController::class, 'storeInvoice'])->name('finance.invoices.store');
    Route::post('finance/invoices/{invoice}/status', [FinanceController::class, 'updateInvoiceStatus'])->name('finance.invoices.status');
    Route::delete('finance/invoices/{invoice}', [FinanceController::class, 'destroyInvoice'])->name('finance.invoices.destroy');

    // Payments
    Route::get('finance/payments', [FinanceController::class, 'payments'])->name('finance.payments.index');
    Route::post('finance/payments', [FinanceController::class, 'storePayment'])->name('finance.payments.store');

    // Budgets
    Route::get('finance/budgets', [FinanceController::class, 'budgets'])->name('finance.budgets.index');
    Route::post('finance/budgets', [FinanceController::class, 'storeBudget'])->name('finance.budgets.store');
    Route::put('finance/budgets/{budget}', [FinanceController::class, 'updateBudget'])->name('finance.budgets.update');
    Route::delete('finance/budgets/{budget}', [FinanceController::class, 'destroyBudget'])->name('finance.budgets.destroy');

    // 13. Project Management Routes
    Route::get('projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::post('projects', [ProjectController::class, 'storeProject'])->name('projects.store');
    Route::post('projects/{project}/status', [ProjectController::class, 'updateProjectStatus'])->name('projects.status');
    Route::delete('projects/{project}', [ProjectController::class, 'destroyProject'])->name('projects.destroy');

    // Project Tasks
    Route::get('projects/tasks/my', [ProjectController::class, 'myTasks'])->name('projects.tasks.my');
    Route::post('projects/tasks', [ProjectController::class, 'storeTask'])->name('projects.tasks.store');
    Route::post('projects/tasks/{task}/status', [ProjectController::class, 'updateTaskStatus'])->name('projects.tasks.status');
    Route::delete('projects/tasks/{task}', [ProjectController::class, 'destroyTask'])->name('projects.tasks.destroy');

    // Timelogs
    Route::get('projects/timelogs', [ProjectController::class, 'timelogs'])->name('projects.timelogs.index');
    Route::post('projects/timelogs', [ProjectController::class, 'storeTimeLog'])->name('projects.timelogs.store');

    // 14. Notice Board Route
    Route::get('noticeboard', [NoticeBoardController::class, 'index'])->name('noticeboard.index');
    Route::post('noticeboard', [NoticeBoardController::class, 'storeAnnouncement'])->name('noticeboard.store');
    Route::post('noticeboard/policies', [NoticeBoardController::class, 'storePolicy'])->name('noticeboard.policies.store');
    Route::get('noticeboard/policies/{policy}/download', [NoticeBoardController::class, 'downloadPolicy'])->name('noticeboard.policies.download');
    Route::delete('noticeboard/{announcement}', [NoticeBoardController::class, 'destroyAnnouncement'])->name('noticeboard.destroy');

    // 15. Calendar Route
    Route::get('calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::post('calendar/events', [CalendarController::class, 'storeEvent'])->name('calendar.events.store');
    Route::delete('calendar/events/{event}', [CalendarController::class, 'destroyEvent'])->name('calendar.events.destroy');

    // User Profile Settings Route
    Route::post('profile/update', [ProfileController::class, 'update'])->name('profile.update');
});
