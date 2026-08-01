@extends('layouts.app')

@push('styles')
<style>
    @keyframes gradientMesh {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .budgets-hero {
        background: linear-gradient(-45deg, #4338CA, #6366F1, #7C3AED, #4F46E5);
        background-size: 300% 300%;
        animation: gradientMesh 12s ease infinite, fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        border-radius: 24px;
        padding: 2.25rem 2.5rem;
        color: #ffffff;
        margin-bottom: 1.75rem;
        box-shadow: 0 20px 45px rgba(99, 102, 241, 0.3);
    }

    /* Refined Image-Style Soft Pastel Cards */
    .pastel-ui8-card {
        border-radius: 20px;
        padding: 1.25rem 1.35rem;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 145px;
        position: relative;
        border: 1px solid transparent;
        animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both;
    }

    .pastel-ui8-card:hover {
        transform: translateY(-5px) scale(1.015);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
    }

    .card-pastel-emerald {
        background: linear-gradient(135deg, #ECFDF5 0%, #D1FAE5 100%);
        border-color: #A7F3D0;
    }

    .card-pastel-amber {
        background: linear-gradient(135deg, #FFFBEB 0%, #FEF3C7 100%);
        border-color: #FDE68A;
    }

    .card-pastel-purple {
        background: linear-gradient(135deg, #F3E8FF 0%, #EDE9FE 100%);
        border-color: #DDD6FE;
    }

    .card-pastel-indigo {
        background: linear-gradient(135deg, #F0F9FF 0%, #E0F2FE 100%);
        border-color: #BAE6FD;
    }

    .ui8-pill-val {
        background: #ffffff;
        padding: 0.3rem 0.85rem;
        border-radius: 999px;
        font-weight: 800;
        font-size: 0.85rem;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.04);
        display: inline-flex;
        align-items: center;
    }

    .ui8-card-title {
        font-size: 1.05rem;
        font-weight: 800;
        letter-spacing: -0.01em;
        color: #1E1B4B;
        margin-top: 0.5rem;
        margin-bottom: 0.15rem;
    }

    .ui8-card-sub {
        font-size: 0.76rem;
        color: #64748B;
        font-weight: 600;
    }

    .ui8-tag-chip {
        background: #ffffff;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 0.2rem 0.6rem;
        border-radius: 8px;
        color: #475569;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
    }

    .directory-card {
        background: #ffffff;
        border-radius: 22px;
        border: 1px solid #EFEFF7;
        box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        animation: fadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) both;
    }

    .table-directory thead th {
        background: linear-gradient(180deg, #F8FAFC 0%, #F1F5F9 100%);
        font-size: 0.72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #475569;
        padding: 1rem 1.25rem;
        border-bottom: 1.5px solid #E2E8F0;
    }

    .table-directory tbody tr {
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        border-bottom: 1px solid #F1F5F9;
    }

    .table-directory tbody tr:hover {
        background-color: #F8FAFC !important;
        box-shadow: inset 3px 0 0 #4F46E5;
    }

    .table-directory tbody td {
        padding: 1rem 1.25rem;
        vertical-align: middle;
    }

    /* Dark Mode Overrides */
    [data-bs-theme="dark"] .pastel-ui8-card,
    [data-bs-theme="dark"] .directory-card {
        background: #1F2937 !important;
        border-color: #374151 !important;
    }
    [data-bs-theme="dark"] .ui8-card-title { color: #F8FAFC !important; }
    [data-bs-theme="dark"] .ui8-pill-val,
    [data-bs-theme="dark"] .ui8-tag-chip {
        background: #111827 !important;
        color: #F8FAFC !important;
        border-color: #374151 !important;
    }
</style>
@endpush

@section('content')
<!-- Header -->
<div class="budgets-hero">
    <div class="row align-items-center g-3">
        <div class="col-12 col-md-8">
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge rounded-pill bg-white bg-opacity-20 text-white fs-8 px-2.5 py-1">
                    <i class="bi bi-pie-chart-fill me-1"></i> Annual Budgeting
                </span>
                <span class="fs-8 text-white-50">• ${{ number_format($stats['total_budget']) }} Allocated Budget</span>
            </div>
            <h3 class="mb-1 fw-extrabold text-white" style="letter-spacing: -0.02em;">
                Department Annual Budgets & Allocations
            </h3>
            <p class="mb-0 text-white-50 fs-7">
                Allocate fiscal year budgets to corporate departments, monitor expenditure caps, and audit variance.
            </p>
        </div>
        <div class="col-12 col-md-4 text-md-end">
            <button class="btn btn-light rounded-pill px-4 py-2.5 fw-bold text-indigo shadow-sm" data-bs-toggle="modal" data-bs-target="#createBudgetModal" style="color: #4F46E5;">
                <i class="bi bi-plus-circle-fill me-1.5 fs-6"></i> Allocate Department Budget
            </button>
        </div>
    </div>
</div>

<!-- Image-Style Soft Pastel KPI Cards (4 Cards in 1 Row) -->
<div class="row g-3 mb-4">
    <!-- Card 1: Total Budget (Soft Sky Blue) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-indigo">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-pie-chart me-1"></i> Budget Cap
                    </span>
                    <span class="ui8-pill-val" style="color: #0284C7;">
                        ${{ number_format($stats['total_budget']) }}
                    </span>
                </div>
                <h4 class="ui8-card-title">Total Allocated Budget</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Annual Corporate Allocation
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-info shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-pie-chart-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Budget</span>
                    <span class="ui8-tag-chip">#Allocation</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Departments (Soft Emerald) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-emerald">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-building me-1"></i> Departments
                    </span>
                    <span class="ui8-pill-val" style="color: #059669;">
                        {{ $stats['department_count'] }} Depts
                    </span>
                </div>
                <h4 class="ui8-card-title">Allocated Departments</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Departmental Units
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-success shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-diagram-3-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Depts</span>
                    <span class="ui8-tag-chip">#Units</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Fiscal Year (Soft Purple) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-purple">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-calendar-check me-1"></i> Fiscal Period
                    </span>
                    <span class="ui8-pill-val" style="color: #7C3AED;">
                        FY {{ $stats['fiscal_year'] }}
                    </span>
                </div>
                <h4 class="ui8-card-title">Current Fiscal Year</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Active Budgeting Cycle
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-purple shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800; color: #7C3AED;">
                        <i class="bi bi-calendar-event"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#FY2026</span>
                    <span class="ui8-tag-chip">#Cycle</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Compliance (Soft Amber) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-amber">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-shield-check me-1"></i> Audited
                    </span>
                    <span class="ui8-pill-val" style="color: #D97706;">
                        Approved
                    </span>
                </div>
                <h4 class="ui8-card-title">Budget Compliance</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Verified Allocation
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-warning shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-shield-fill-check"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Approved</span>
                    <span class="ui8-tag-chip">#Audited</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Budgets Table -->
<div class="directory-card">
    <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light bg-opacity-50">
        <div class="fs-8 text-muted fw-bold">
            Showing <strong class="text-dark">{{ $budgets->firstItem() ?? 0 }} - {{ $budgets->lastItem() ?? 0 }}</strong> of <strong class="text-dark">{{ $budgets->total() }}</strong> Department Budgets
        </div>
        <form method="GET" action="{{ route('finance.budgets.index') }}" class="d-flex gap-2">
            <input type="text" name="search" class="form-control rounded-pill fs-8 ps-3" value="{{ request('search') }}" placeholder="Search category...">
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-directory align-middle mb-0 fs-7">
            <thead>
                <tr>
                    <th>BUDGET CATEGORY</th>
                    <th>DEPARTMENT</th>
                    <th>ALLOCATED AMOUNT ($)</th>
                    <th>FISCAL YEAR</th>
                    <th class="text-end pe-3">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($budgets as $b)
                    <tr>
                        <td>
                            <div class="fw-bold text-dark fs-7">{{ $b->category }}</div>
                        </td>
                        <td>
                            <div class="fw-bold text-dark fs-8">{{ $b->department?->name }}</div>
                        </td>
                        <td class="fw-extrabold text-success fs-7 font-monospace" style="color: #059669;">
                            ${{ number_format($b->allocated_amount, 2) }}
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border px-2.5 py-1 fs-8 fw-bold">
                                FY {{ $b->year }}
                            </span>
                        </td>
                        <td class="text-end pe-3">
                            <div class="d-flex justify-content-end align-items-center gap-1.5">
                                <button class="btn btn-sm btn-light rounded-circle text-primary" 
                                        onclick="editBudgetModal('{{ $b->id }}', '{{ $b->department_id }}', '{{ addslashes($b->category) }}', '{{ $b->allocated_amount }}', '{{ $b->year }}')"
                                        title="Edit Budget">
                                    <i class="bi bi-pencil-fill fs-8"></i>
                                </button>
                                <form action="{{ route('finance.budgets.destroy', $b->id) }}" method="POST" onsubmit="event.preventDefault(); confirmDeleteBudget('{{ $b->id }}', '{{ addslashes($b->category) }}', this);">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light rounded-circle text-danger" title="Delete Budget">
                                        <i class="bi bi-trash-fill fs-8"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted fs-7">
                            <i class="bi bi-pie-chart fs-2 d-block mb-2 text-slate-300"></i>
                            <div class="fw-bold text-dark">No department budgets allocated</div>
                            <p class="fs-8 text-muted mb-3">Click "Allocate Department Budget" to assign fiscal funds.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($budgets->hasPages())
        <div class="p-3 border-top bg-light d-flex justify-content-between align-items-center">
            <div class="fs-8 text-muted">Showing {{ $budgets->firstItem() }} to {{ $budgets->lastItem() }} of {{ $budgets->total() }} entries</div>
            <div>{{ $budgets->links() }}</div>
        </div>
    @endif
</div>

<!-- Create / Edit Budget Modal -->
<div class="modal fade" id="createBudgetModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom px-4 py-3">
                <h5 class="modal-title fw-bold fs-6 text-dark" id="budgetModalTitle">Allocate Department Budget</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('finance.budgets.store') }}" method="POST" id="budgetForm">
                @csrf
                <input type="hidden" name="_method" id="budgetMethod" value="POST">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Department <span class="text-danger">*</span></label>
                        <select name="department_id" id="bgt_dept_id" class="form-select rounded-3 fs-8" required>
                            @foreach($departments as $d)
                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Budget Category <span class="text-danger">*</span></label>
                        <input type="text" name="category" id="bgt_category" class="form-control rounded-3 fs-8" placeholder="e.g. Software R&D & Engineering" required>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Allocated Amount ($) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="allocated_amount" id="bgt_amount" class="form-control rounded-3 fs-8" placeholder="100000.00" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Fiscal Year <span class="text-danger">*</span></label>
                            <input type="number" name="year" id="bgt_year" class="form-control rounded-3 fs-8" value="{{ date('Y') }}" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4 fs-8 fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fs-8 fw-bold" style="background: #4F46E5; border: none;">Save Budget</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function editBudgetModal(id, deptId, category, amount, year) {
        document.getElementById('budgetModalTitle').textContent = 'Edit Department Budget';
        document.getElementById('budgetForm').action = "{{ url('finance/budgets') }}/" + id;
        document.getElementById('budgetMethod').value = 'PUT';

        document.getElementById('bgt_dept_id').value = deptId;
        document.getElementById('bgt_category').value = category;
        document.getElementById('bgt_amount').value = amount;
        document.getElementById('bgt_year').value = year;

        const modal = new bootstrap.Modal(document.getElementById('createBudgetModal'));
        modal.show();
    }

    function confirmDeleteBudget(id, category, formEl) {
        const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
        
        Swal.fire({
            title: `<div class="d-flex align-items-center justify-content-center gap-2 text-danger fw-bold fs-5 mb-1">
                        <i class="bi bi-exclamation-triangle-fill fs-4"></i> Delete Department Budget?
                    </div>`,
            html: `
                <div class="text-center py-2">
                    <p class="fs-7 text-secondary mb-3" style="line-height: 1.6;">
                        Are you sure you want to delete budget <strong class="text-dark">${category}</strong>?
                    </p>
                    <div class="alert alert-danger border-0 fs-8 py-2.5 px-3 text-start mb-0 rounded-3" style="background: ${isDark ? '#374151' : '#FEF2F2'}; color: ${isDark ? '#F87171' : '#991B1B'};">
                        <i class="bi bi-trash me-1"></i>
                        Deleting this budget will remove its allocation metrics.
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: '<i class="bi bi-trash-fill me-1"></i> Yes, Delete Budget',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#EF4444',
            cancelButtonColor: isDark ? '#4B5563' : '#64748B',
            background: isDark ? '#1F2937' : '#ffffff',
            color: isDark ? '#F8FAFC' : '#1E1B4B',
            customClass: {
                popup: 'rounded-4 border-0 shadow-lg p-4',
                confirmButton: 'px-4 py-2.5 rounded-pill fw-bold fs-7 shadow-sm',
                cancelButton: 'px-4 py-2.5 rounded-pill fw-bold fs-7'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                formEl.submit();
            }
        });
    }
</script>
@endpush
