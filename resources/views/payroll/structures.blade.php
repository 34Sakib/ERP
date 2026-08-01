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

    .payroll-hero {
        background: linear-gradient(-45deg, #1E1B4B, #312E81, #4338CA, #6366F1);
        background-size: 300% 300%;
        animation: gradientMesh 12s ease infinite, fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        border-radius: 24px;
        padding: 2.25rem 2.5rem;
        color: #ffffff;
        margin-bottom: 1.75rem;
        box-shadow: 0 20px 45px rgba(30, 27, 75, 0.3);
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
<div class="payroll-hero">
    <div class="row align-items-center g-3">
        <div class="col-12 col-md-8">
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge rounded-pill bg-white bg-opacity-20 text-white fs-8 px-2.5 py-1">
                    <i class="bi bi-cash-stack me-1"></i> Compensation Setup
                </span>
                <span class="fs-8 text-white-50">• {{ $stats['total_structures'] }} Configured Structures</span>
            </div>
            <h3 class="mb-1 fw-extrabold text-white" style="letter-spacing: -0.02em;">
                Employee Salary Structures & Compensation
            </h3>
            <p class="mb-0 text-white-50 fs-7">
                Configure basic salaries, house rent allowances, conveyance, and tax deductions.
            </p>
        </div>
        <div class="col-12 col-md-4 text-md-end">
            <button class="btn btn-light rounded-pill px-4 py-2.5 fw-bold text-indigo shadow-sm" data-bs-toggle="modal" data-bs-target="#createStructureModal" style="color: #4F46E5;">
                <i class="bi bi-plus-circle-fill me-1.5 fs-6"></i> Add Salary Structure
            </button>
        </div>
    </div>
</div>

<!-- Image-Style Soft Pastel KPI Cards (4 Cards in 1 Row) -->
<div class="row g-3 mb-4">
    <!-- Card 1: Total Payroll Value (Soft Emerald) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-emerald">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-currency-dollar me-1"></i> Monthly Budget
                    </span>
                    <span class="ui8-pill-val" style="color: #059669;">
                        ${{ number_format($stats['total_payroll_value']) }}
                    </span>
                </div>
                <h4 class="ui8-card-title">Total Payroll Value</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Base Payroll Commitment
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-success shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-cash-coin"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Payroll</span>
                    <span class="ui8-tag-chip">#BaseValue</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Average Basic (Soft Sky Blue) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-indigo">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-graph-up me-1"></i> Salary Average
                    </span>
                    <span class="ui8-pill-val" style="color: #0284C7;">
                        ${{ number_format($stats['average_basic']) }}
                    </span>
                </div>
                <h4 class="ui8-card-title">Average Basic Salary</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Mean Compensation
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-info shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-calculator-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Average</span>
                    <span class="ui8-tag-chip">#BasicSalary</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Configured Structures (Soft Purple) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-purple">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-person-badge me-1"></i> Enrolled Staff
                    </span>
                    <span class="ui8-pill-val" style="color: #7C3AED;">
                        {{ $stats['total_structures'] }} Profiles
                    </span>
                </div>
                <h4 class="ui8-card-title">Configured Structures</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Employees Configured
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-purple shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800; color: #7C3AED;">
                        <i class="bi bi-check-circle-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Enrolled</span>
                    <span class="ui8-tag-chip">#Profiles</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Active Policy (Soft Amber) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-amber">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-shield-check me-1"></i> Active Status
                    </span>
                    <span class="ui8-pill-val" style="color: #D97706;">
                        {{ $stats['active_count'] }} Active
                    </span>
                </div>
                <h4 class="ui8-card-title">Active Compensation</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Currently Disbursing
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-warning shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-shield-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Active</span>
                    <span class="ui8-tag-chip">#Disbursing</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Salary Structures Table -->
<div class="directory-card">
    <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light bg-opacity-50">
        <div class="fs-8 text-muted fw-bold">
            Showing <strong class="text-dark">{{ $structures->firstItem() ?? 0 }} - {{ $structures->lastItem() ?? 0 }}</strong> of <strong class="text-dark">{{ $structures->total() }}</strong> Configured Salary Structures
        </div>
        <form method="GET" action="{{ route('payroll.structures.index') }}" class="d-flex gap-2">
            <input type="text" name="search" class="form-control rounded-pill fs-8 ps-3" value="{{ request('search') }}" placeholder="Search employee name...">
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-directory align-middle mb-0 fs-7">
            <thead>
                <tr>
                    <th>EMPLOYEE PROFILE</th>
                    <th>DEPARTMENT & ROLE</th>
                    <th>BASIC SALARY</th>
                    <th>ALLOWANCES & DEDUCTIONS</th>
                    <th>EFFECTIVE DATE</th>
                    <th>STATUS</th>
                    <th class="text-end pe-3">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($structures as $s)
                    @if(!$s->employee)
                        @continue
                    @endif
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2.5">
                                <img src="{{ $s->employee->profile_photo ? asset($s->employee->profile_photo) : 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80' }}" 
                                     class="rounded-circle shadow-sm" style="width: 38px; height: 38px; object-fit: cover;">
                                <div>
                                    <div class="fw-bold text-dark">{{ $s->employee->full_name }}</div>
                                    <div class="fs-8 text-muted"><code class="text-primary">{{ $s->employee->employee_code }}</code></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold text-dark fs-8">{{ $s->employee->department?->name ?? 'General' }}</div>
                            <div class="fs-8 text-secondary">{{ $s->employee->designation?->name ?? 'Staff' }}</div>
                        </td>
                        <td class="fw-bold text-dark fs-8 font-monospace">
                            ${{ number_format($s->basic_salary, 2) }}
                        </td>
                        <td>
                            <div class="d-flex gap-1.5 flex-wrap">
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-0.5 fs-8">
                                    +${{ number_format($s->components->whereIn('type', ['allowance', 'bonus'])->sum('amount'), 0) }} Allowances
                                </span>
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-0.5 fs-8">
                                    -${{ number_format($s->components->whereIn('type', ['deduction', 'tax', 'pf'])->sum('amount'), 0) }} Tax
                                </span>
                            </div>
                        </td>
                        <td class="fw-bold text-dark fs-8 font-monospace">
                            {{ $s->effective_date->format('M d, Y') }}
                        </td>
                        <td>
                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1 rounded-pill fs-8">Active Structure</span>
                        </td>
                        <td class="text-end pe-3">
                            <div class="d-flex justify-content-end align-items-center gap-1.5">
                                <button class="btn btn-sm btn-light rounded-circle text-primary" 
                                        onclick="editStructureModal('{{ $s->id }}', '{{ $s->employee_id }}', '{{ $s->basic_salary }}', '{{ $s->effective_date->format('Y-m-d') }}')"
                                        title="Edit Salary Structure">
                                    <i class="bi bi-pencil-fill fs-8"></i>
                                </button>
                                <form action="{{ route('payroll.structures.destroy', $s->id) }}" method="POST" onsubmit="event.preventDefault(); confirmDeleteStructure('{{ $s->id }}', '{{ addslashes($s->employee->full_name) }}', this);">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light rounded-circle text-danger" title="Delete Structure">
                                        <i class="bi bi-trash-fill fs-8"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted fs-7">
                            <i class="bi bi-cash-stack fs-2 d-block mb-2 text-slate-300"></i>
                            <div class="fw-bold text-dark">No salary structures configured</div>
                            <p class="fs-8 text-muted mb-3">Click "Add Salary Structure" to configure employee compensation.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($structures->hasPages())
        <div class="p-3 border-top bg-light d-flex justify-content-between align-items-center">
            <div class="fs-8 text-muted">Showing {{ $structures->firstItem() }} to {{ $structures->lastItem() }} of {{ $structures->total() }} entries</div>
            <div>{{ $structures->links() }}</div>
        </div>
    @endif
</div>

<!-- Create / Edit Structure Modal -->
<div class="modal fade" id="createStructureModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom px-4 py-3">
                <h5 class="modal-title fw-bold fs-6 text-dark" id="structureModalTitle">Configure Salary Structure</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('payroll.structures.store') }}" method="POST" id="structureForm">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Employee <span class="text-danger">*</span></label>
                        <select name="employee_id" id="struct_employee_id" class="form-select rounded-3 fs-8" required>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->full_name }} ({{ $emp->employee_code }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Basic Salary ($) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="basic_salary" id="struct_basic_salary" class="form-control rounded-3 fs-8" placeholder="50000.00" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Effective Date <span class="text-danger">*</span></label>
                            <input type="date" name="effective_date" id="struct_effective_date" class="form-control rounded-3 fs-8" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    <h6 class="fw-bold fs-7 text-dark border-bottom pb-2 mb-3 mt-4">Allowance Components</h6>
                    <div class="row g-2 mb-3">
                        <div class="col-4">
                            <label class="form-label fs-8 text-secondary">House Rent ($)</label>
                            <input type="number" step="0.01" name="house_rent" class="form-control rounded-3 fs-8" placeholder="15000">
                        </div>
                        <div class="col-4">
                            <label class="form-label fs-8 text-secondary">Medical ($)</label>
                            <input type="number" step="0.01" name="medical_allowance" class="form-control rounded-3 fs-8" placeholder="3000">
                        </div>
                        <div class="col-4">
                            <label class="form-label fs-8 text-secondary">Conveyance ($)</label>
                            <input type="number" step="0.01" name="conveyance" class="form-control rounded-3 fs-8" placeholder="2500">
                        </div>
                    </div>

                    <h6 class="fw-bold fs-7 text-dark border-bottom pb-2 mb-3">Deduction Components</h6>
                    <div class="mb-3">
                        <label class="form-label fs-8 text-secondary">Income Tax Deduction ($)</label>
                        <input type="number" step="0.01" name="tax_deduction" class="form-control rounded-3 fs-8" placeholder="2000">
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4 fs-8 fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fs-8 fw-bold" style="background: #4F46E5; border: none;">Save Salary Structure</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function editStructureModal(id, empId, basic, date) {
        document.getElementById('structureModalTitle').textContent = 'Edit Salary Structure';
        document.getElementById('struct_employee_id').value = empId;
        document.getElementById('struct_basic_salary').value = basic;
        document.getElementById('struct_effective_date').value = date;

        const modal = new bootstrap.Modal(document.getElementById('createStructureModal'));
        modal.show();
    }

    function confirmDeleteStructure(id, name, formEl) {
        const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
        
        Swal.fire({
            title: `<div class="d-flex align-items-center justify-content-center gap-2 text-danger fw-bold fs-5 mb-1">
                        <i class="bi bi-exclamation-triangle-fill fs-4"></i> Delete Salary Structure?
                    </div>`,
            html: `
                <div class="text-center py-2">
                    <p class="fs-7 text-secondary mb-3" style="line-height: 1.6;">
                        Are you sure you want to delete salary structure for <strong class="text-dark">${name}</strong>?
                    </p>
                    <div class="alert alert-danger border-0 fs-8 py-2.5 px-3 text-start mb-0 rounded-3" style="background: ${isDark ? '#374151' : '#FEF2F2'}; color: ${isDark ? '#F87171' : '#991B1B'};">
                        <i class="bi bi-trash me-1"></i>
                        Deleting this structure will remove custom allowances for future payroll runs.
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: '<i class="bi bi-trash-fill me-1"></i> Yes, Delete Structure',
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
