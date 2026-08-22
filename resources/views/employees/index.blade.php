@extends('layouts.app')

@push('styles')
<style>
    .directory-hero {
        background: linear-gradient(135deg, #8B5CF6 0%, #6366F1 100%);
        border-radius: 16px;
        padding: 1.75rem 2rem;
        color: #ffffff;
        margin-bottom: 1.75rem;
        box-shadow: 0 10px 30px -5px rgba(139, 92, 246, 0.3);
        border: none;
    }

    .directory-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #E2E8F0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }

    /* Filter Control Panel Styling */
    .filter-panel-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #E2E8F0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .filter-input-pill {
        position: relative;
    }

    .filter-input-pill input {
        border-radius: 10px;
        padding-left: 2.5rem;
        font-size: 0.85rem;
        border: 1px solid #E2E8F0;
        background: #F8FAFC;
        transition: all 0.2s ease;
    }

    .filter-input-pill input:focus {
        background: #ffffff;
        border-color: #8B5CF6;
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.15);
    }

    .filter-label-sm {
        font-size: 0.72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #64748B;
        margin-bottom: 0.35rem;
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }

    .filter-select-custom {
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 600;
        border: 1px solid #E2E8F0;
        background-color: #F8FAFC;
        transition: all 0.2s ease;
    }

    .filter-select-custom:focus {
        background-color: #ffffff;
        border-color: #8B5CF6;
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.15);
    }

    .filter-chip-btn {
        font-size: 0.78rem;
        font-weight: 700;
        padding: 0.4rem 0.9rem;
        border-radius: 999px;
        border: 1px solid #E2E8F0;
        background: #F8FAFC;
        color: #64748B;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }

    .filter-chip-btn.active, .filter-chip-btn:hover {
        background: #8B5CF6;
        color: #ffffff;
        border-color: #8B5CF6;
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.25);
    }

    /* Organized Canonical Directory Table */
    .table-directory {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
        margin-bottom: 0;
    }

    .table-directory thead th {
        background: #F8FAFC;
        font-size: 0.72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #1E293B;
        padding: 0.95rem 1.15rem;
        border-bottom: 1.5px solid #E2E8F0;
        white-space: nowrap;
    }

    .table-directory tbody tr {
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        border-bottom: 1px solid #F1F5F9;
    }

    .table-directory tbody tr:hover {
        background-color: #F8FAFC !important;
        box-shadow: inset 3.5px 0 0 #8B5CF6;
    }

    .table-directory tbody td {
        padding: 0.95rem 1.15rem;
        vertical-align: middle;
    }

    /* Structured Field Badges */
    .emp-code-chip {
        font-family: monospace, monospace;
        font-weight: 700;
        font-size: 0.76rem;
        background: #F3E8FF;
        color: #8B5CF6;
        padding: 0.25rem 0.6rem;
        border-radius: 8px;
        border: 1px solid rgba(139, 92, 246, 0.2);
        display: inline-block;
    }

    .emp-avatar-box {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        object-fit: cover;
        border: 2px solid #ffffff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        flex-shrink: 0;
    }

    .dept-badge-pill {
        font-size: 0.74rem;
        font-weight: 700;
        padding: 0.25rem 0.65rem;
        border-radius: 8px;
        background: #F3E8FF;
        color: #8B5CF6;
        border: 1px solid rgba(139, 92, 246, 0.2);
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }

    .branch-badge-chip {
        font-size: 0.78rem;
        font-weight: 600;
        color: #475569;
        background: #F8FAFC;
        padding: 0.25rem 0.6rem;
        border-radius: 8px;
        border: 1px solid #E2E8F0;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }

    .status-badge-dot {
        font-size: 0.72rem;
        font-weight: 800;
        padding: 0.25rem 0.7rem;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        letter-spacing: 0.01em;
    }

    .status-badge-dot.active {
        background: #DCFCE7;
        color: #15803D;
        border: 1px solid #BBF7D0;
    }

    .status-badge-dot.probation {
        background: #FEF3C7;
        color: #B45309;
        border: 1px solid #FDE68A;
    }

    .status-badge-dot.other {
        background: #F1F5F9;
        color: #475569;
        border: 1px solid #E2E8F0;
    }

    .status-dot-pulse {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        display: inline-block;
    }

    .status-badge-dot.active .status-dot-pulse {
        background-color: #16A34A;
    }

    .status-badge-dot.probation .status-dot-pulse {
        background-color: #D97706;
    }

    .action-btn-pill {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        border: none;
    }

    .action-btn-pill:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .directory-card-header,
    .directory-card-footer {
        background: #F8FAFC;
        border-color: #E2E8F0 !important;
    }

    /* Dark Mode Theme Support for Employee Directory */
    [data-bs-theme="dark"] .directory-card-header,
    [data-bs-theme="dark"] .directory-card-footer {
        background: #0F172A !important;
        border-color: #334155 !important;
    }

    [data-bs-theme="dark"] .directory-card,
    [data-bs-theme="dark"] .filter-panel-card {
        background: #1E293B !important;
        border-color: #334155 !important;
        color: #F8FAFC !important;
    }

    [data-bs-theme="dark"] .filter-label-sm {
        color: #94A3B8 !important;
    }

    [data-bs-theme="dark"] .filter-input-pill input,
    [data-bs-theme="dark"] .filter-select-custom {
        background-color: #0F172A !important;
        border-color: #334155 !important;
        color: #F8FAFC !important;
    }

    [data-bs-theme="dark"] .filter-chip-btn {
        background-color: #0F172A !important;
        border-color: #334155 !important;
        color: #94A3B8 !important;
    }

    [data-bs-theme="dark"] .filter-chip-btn.active,
    [data-bs-theme="dark"] .filter-chip-btn:hover {
        background-color: #8B5CF6 !important;
        border-color: #8B5CF6 !important;
        color: #FFFFFF !important;
    }

    [data-bs-theme="dark"] .table-directory thead th {
        background: #0F172A !important;
        color: #CBD5E1 !important;
        border-bottom-color: #334155 !important;
    }

    [data-bs-theme="dark"] .table-directory tbody tr {
        border-bottom-color: #334155 !important;
    }

    [data-bs-theme="dark"] .table-directory tbody tr:hover {
        background-color: #334155 !important;
    }

    [data-bs-theme="dark"] .table-directory tbody td {
        color: #E2E8F0 !important;
    }

    [data-bs-theme="dark"] .emp-code-chip {
        background: rgba(139, 92, 246, 0.15) !important;
        color: #C084FC !important;
        border-color: rgba(139, 92, 246, 0.3) !important;
    }

    [data-bs-theme="dark"] .dept-badge-pill {
        background: rgba(139, 92, 246, 0.15) !important;
        color: #C084FC !important;
        border-color: rgba(139, 92, 246, 0.3) !important;
    }

    [data-bs-theme="dark"] .branch-badge-chip {
        background: #0F172A !important;
        border-color: #334155 !important;
        color: #CBD5E1 !important;
    }
</style>
@endpush

@section('content')
<!-- Directory Banner -->
<div class="directory-hero">
    <div class="row align-items-center g-3">
        <div class="col-12 col-md-7">
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge rounded-pill bg-white bg-opacity-20 text-white fs-8 px-2.5 py-1">
                    <i class="bi bi-people-fill me-1"></i> Core Directory
                </span>
                <span class="fs-8 text-white-50">• {{ $employees->total() }} Total Staff</span>
            </div>
            <h3 class="mb-1 fw-extrabold text-white" style="letter-spacing: -0.02em;">
                Employee Directory
            </h3>
            <p class="mb-0 text-white-50 fs-7">
                Single source of truth for all company staff, department assignments, and 360° employee profiles.
            </p>
        </div>
        <div class="col-12 col-md-5 text-md-end">
            @can('employee.create')
                <a href="{{ route('employees.create') }}" class="btn btn-light rounded-pill px-4 py-2 fw-bold shadow-sm" style="color: #8B5CF6; background: #ffffff;">
                    <i class="bi bi-person-plus-fill me-1 fs-6"></i> Onboard New Employee
                </a>
            @endcan
        </div>
    </div>
</div>

<!-- Organized Search & Multi-Filter Control Panel -->
<div class="filter-panel-card">
    <form method="GET" action="{{ route('employees.index') }}" id="filterForm">
        <!-- Top Title Row -->
        <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
            <div class="fw-extrabold text-dark fs-7 d-flex align-items-center gap-2">
                <span class="p-1.5 bg-primary bg-opacity-10 text-primary rounded-3">
                    <i class="bi bi-funnel-fill"></i>
                </span>
                Directory Filter & Search Control Panel
            </div>
            @if(request()->hasAny(['search', 'branch_id', 'department_id', 'status']))
                <a href="{{ route('employees.index') }}" class="btn btn-light btn-sm rounded-pill px-3 fs-8 fw-bold text-danger border border-danger-subtle">
                    <i class="bi bi-x-circle-fill me-1"></i> Reset Active Filters
                </a>
            @endif
        </div>

        <!-- Filter Grid -->
        <div class="row g-3 align-items-end">
            <!-- Search Keyword Input -->
            <div class="col-12 col-md-4">
                <div class="filter-label-sm">
                    <i class="bi bi-search text-primary"></i> Keyword Search
                </div>
                <div class="filter-input-pill">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Name, Code, or Email...">
                </div>
            </div>

            <!-- Branch Select -->
            <div class="col-6 col-md-3">
                <div class="filter-label-sm">
                    <i class="bi bi-geo-alt-fill text-danger"></i> Branch Office
                </div>
                <select name="branch_id" class="form-select filter-select-custom" onchange="this.form.submit()">
                    <option value="">All Branch Locations</option>
                    @foreach($branches as $b)
                        <option value="{{ $b->id }}" {{ request('branch_id') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Department Select -->
            <div class="col-6 col-md-3">
                <div class="filter-label-sm">
                    <i class="bi bi-building text-indigo" style="color: #4F46E5;"></i> Department Scope
                </div>
                <select name="department_id" class="form-select filter-select-custom" onchange="this.form.submit()">
                    <option value="">All Departments</option>
                    @foreach($departments as $d)
                        <option value="{{ $d->id }}" {{ request('department_id') == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Status Select -->
            <div class="col-12 col-md-2">
                <div class="filter-label-sm">
                    <i class="bi bi-check-circle-fill text-success"></i> Status
                </div>
                <select name="status" class="form-select filter-select-custom" onchange="this.form.submit()">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="probation" {{ request('status') == 'probation' ? 'selected' : '' }}>On Probation</option>
                    <option value="terminated" {{ request('status') == 'terminated' ? 'selected' : '' }}>Terminated</option>
                </select>
            </div>
        </div>

        <!-- Quick Department Filter Chips Row -->
        <div class="d-flex flex-wrap align-items-center gap-2 mt-3 pt-3 border-top">
            <span class="fs-8 fw-extrabold text-muted me-2">Quick Department Filter:</span>
            <a href="{{ route('employees.index') }}" class="filter-chip-btn {{ !request('department_id') ? 'active' : '' }}">
                👥 All Staff
            </a>
            @foreach($departments as $dept)
                <a href="{{ route('employees.index', array_merge(request()->query(), ['department_id' => $dept->id])) }}" 
                   class="filter-chip-btn {{ request('department_id') == $dept->id ? 'active' : '' }}">
                    📁 {{ $dept->name }}
                </a>
            @endforeach
        </div>
    </form>
</div>

<!-- Employees Canonical Table Card -->
<div class="directory-card">
    <div class="p-3 border-bottom d-flex justify-content-between align-items-center directory-card-header">
        <div class="fs-8 text-muted fw-bold">
            Showing <strong class="text-dark">{{ $employees->firstItem() ?? 0 }} - {{ $employees->lastItem() ?? 0 }}</strong> of <strong class="text-dark">{{ $employees->total() }}</strong> Employee Profiles
        </div>
        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1.5 rounded-pill fs-8 fw-bold">
            <i class="bi bi-shield-check me-1"></i> Live Directory
        </span>
    </div>

    <div class="table-responsive">
        <table class="table table-directory align-middle mb-0 fs-7">
            <thead>
                <tr>
                    <th style="width: 40px;" class="ps-3"><input type="checkbox" class="form-check-input" id="selectAll"></th>
                    <th style="width: 110px;">EMP CODE</th>
                    <th>EMPLOYEE PROFILE</th>
                    <th>DEPARTMENT & ROLE</th>
                    <th>LOCATION / BRANCH</th>
                    <th>JOINING DATE</th>
                    <th>STATUS</th>
                    <th class="text-end pe-3" style="width: 110px;">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $emp)
                    <tr>
                        <td class="ps-3"><input type="checkbox" class="form-check-input row-checkbox" style="cursor: pointer;"></td>
                        <td><span class="emp-code-chip">{{ $emp->employee_code }}</span></td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ $emp->avatar_url }}" 
                                     class="emp-avatar-box" alt="Avatar">
                                <div class="overflow-hidden">
                                    <a href="{{ route('employees.show', $emp->id) }}" class="fw-bold text-dark text-decoration-none hover-primary fs-7 d-block text-truncate">
                                        {{ $emp->full_name }}
                                    </a>
                                    <div class="fs-8 text-muted text-truncate mt-0.5">
                                        <i class="bi bi-envelope me-1 text-slate-400"></i>{{ $emp->personal_email }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column gap-1">
                                <div>
                                    <span class="dept-badge-pill">
                                        <i class="bi bi-building"></i> {{ $emp->department?->name ?? 'General' }}
                                    </span>
                                </div>
                                <div class="fs-8 text-secondary font-medium ps-0.5">
                                    {{ $emp->designation?->name ?? 'Staff Member' }}
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="branch-badge-chip">
                                <i class="bi bi-geo-alt-fill text-danger"></i> {{ $emp->branch?->name ?? 'Headquarters' }}
                            </span>
                        </td>
                        <td>
                            <div class="fs-8 fw-semibold text-secondary font-mono">
                                <i class="bi bi-calendar-event me-1 text-muted"></i>{{ $emp->joining_date?->format('M d, Y') ?? 'N/A' }}
                            </div>
                        </td>
                        <td>
                            @if($emp->employment_status === 'active')
                                <span class="status-badge-dot active"><span class="status-dot-pulse"></span> Active</span>
                            @elseif($emp->employment_status === 'probation')
                                <span class="status-badge-dot probation"><span class="status-dot-pulse"></span> Probation</span>
                            @else
                                <span class="status-badge-dot other"><span class="status-dot-pulse"></span> {{ ucfirst($emp->employment_status) }}</span>
                            @endif
                        </td>
                        <td class="text-end pe-3">
                            <div class="d-flex justify-content-end align-items-center gap-1.5">
                                <a href="{{ route('employees.show', $emp->id) }}" class="action-btn-pill" 
                                   style="background: #F3E8FF; color: #8B5CF6;" title="View 360° Profile">
                                    <i class="bi bi-eye-fill fs-7"></i>
                                </a>
                                <a href="{{ route('employees.edit', $emp->id) }}" class="action-btn-pill" 
                                   style="background: #E0F2FE; color: #0284C7;" title="Edit Details">
                                    <i class="bi bi-pencil-fill fs-7"></i>
                                </a>
                                @can('employee.delete')
                                    <div class="dropdown">
                                        <button class="action-btn-pill" style="background: #F1F5F9; color: #475569;" 
                                                type="button" data-bs-toggle="dropdown" title="More Actions">
                                            <i class="bi bi-three-dots-vertical fs-7"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 fs-7 p-2" style="border-radius: 14px; min-width: 170px;">
                                            <li>
                                                <form action="{{ route('employees.destroy', $emp->id) }}" method="POST" onsubmit="event.preventDefault(); confirmDeactivateEmployee('{{ $emp->id }}', '{{ addslashes($emp->full_name) }}', '{{ $emp->employee_code }}', this);">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item rounded-2 py-1.5 text-danger fs-8 fw-semibold">
                                                        <i class="bi bi-person-x me-2"></i> Deactivate Employee
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted fs-7">
                            <i class="bi bi-people fs-2 d-block mb-2 text-slate-300"></i>
                            <div class="fw-bold text-dark">No employee profiles match your criteria</div>
                            <p class="fs-8 text-muted mb-3">Try adjusting search query or clearing department/status filters.</p>
                            <a href="{{ route('employees.index') }}" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold">Reset All Filters</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($employees->hasPages())
        <div class="p-3 border-top d-flex justify-content-between align-items-center directory-card-footer">
            <div class="fs-8 text-muted">
                Showing {{ $employees->firstItem() }} to {{ $employees->lastItem() }} of {{ $employees->total() }} entries
            </div>
            <div>
                {{ $employees->links() }}
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    function confirmDeactivateEmployee(empId, empName, empCode, formEl) {
        Swal.fire({
            icon: 'warning',
            title: 'Deactivate Employee Account?',
            text: `Are you sure you want to deactivate ${empName} (${empCode})? Deactivating will revoke active portal access and archive staff records.`,
            showCancelButton: true,
            confirmButtonText: 'Yes, Deactivate Account',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                formEl.submit();
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function() {
        const selectAll = document.getElementById('selectAll');
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                document.querySelectorAll('.row-checkbox').forEach(cb => cb.checked = this.checked);
            });
        }
    });
</script>
@endpush
