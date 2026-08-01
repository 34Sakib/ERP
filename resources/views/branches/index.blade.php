@extends('layouts.app')

@push('styles')
<style>
    .settings-hero {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 50%, #334155 100%);
        border-radius: 20px;
        padding: 1.5rem 2rem;
        color: #ffffff;
        margin-bottom: 1.75rem;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.25);
    }

    /* Compact Color-Themed KPI Cards */
    .kpi-stat-card-v3 {
        border-radius: 18px;
        padding: 1rem 1.25rem;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 100%;
    }

    .kpi-stat-card-v3:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
    }

    .kpi-stat-card-v3.theme-indigo {
        background: linear-gradient(135deg, #EEF2FF 0%, #E0E7FF 100%);
        border: 1.5px solid #C7D2FE;
    }

    .kpi-stat-card-v3.theme-emerald {
        background: linear-gradient(135deg, #ECFDF5 0%, #D1FAE5 100%);
        border: 1.5px solid #A7F3D0;
    }

    .kpi-stat-card-v3.theme-amber {
        background: linear-gradient(135deg, #FFFBEB 0%, #FEF3C7 100%);
        border: 1.5px solid #FDE68A;
    }

    .kpi-label-sm {
        font-size: 0.72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .kpi-number-sm {
        font-size: 1.45rem;
        font-weight: 800;
        line-height: 1.1;
        margin-top: 0.15rem;
    }

    /* Organized Directory Table */
    .directory-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #EFEFF7;
        box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .table-directory {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
        margin-bottom: 0;
    }

    .table-directory thead th {
        background: linear-gradient(180deg, #F8FAFC 0%, #F1F5F9 100%);
        font-size: 0.72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #475569;
        padding: 0.95rem 1.15rem;
        border-bottom: 1.5px solid #E2E8F0;
        white-space: nowrap;
    }

    .table-directory tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid #F1F5F9;
    }

    .table-directory tbody tr:hover {
        background-color: #F8FAFC !important;
        box-shadow: inset 3px 0 0 #3B82F6;
    }

    .table-directory tbody td {
        padding: 0.95rem 1.15rem;
        vertical-align: middle;
    }

    .code-chip {
        font-family: monospace, monospace;
        font-weight: 700;
        font-size: 0.78rem;
        background: #F1F5F9;
        color: #334155;
        padding: 0.25rem 0.65rem;
        border-radius: 8px;
        border: 1px solid #CBD5E1;
        display: inline-block;
    }

    .status-badge-dot {
        font-size: 0.72rem;
        font-weight: 800;
        padding: 0.25rem 0.7rem;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .status-badge-dot.active {
        background: #DCFCE7;
        color: #15803D;
        border: 1px solid #BBF7D0;
    }

    .status-dot-pulse {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        display: inline-block;
        background-color: #16A34A;
    }
</style>
@endpush

@section('content')
<!-- Hero Header -->
<div class="settings-hero">
    <div class="row align-items-center g-3">
        <div class="col-12 col-md-8">
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge rounded-pill bg-white bg-opacity-20 text-white fs-8 px-2.5 py-1">
                    <i class="bi bi-geo-alt-fill me-1"></i> Regional Offices & Depots
                </span>
                <span class="fs-8 text-white-50">• System Settings</span>
            </div>
            <h3 class="mb-1 fw-extrabold text-white" style="letter-spacing: -0.02em;">
                Branch Locations & Office Management
            </h3>
            <p class="mb-0 text-white-50 fs-7">
                Manage physical headquarters, regional branch offices, and department allocations.
            </p>
        </div>
        <div class="col-12 col-md-4 text-md-end">
            <button class="btn btn-light rounded-pill px-4 py-2 fw-bold text-dark fs-8 shadow-sm" data-bs-toggle="modal" data-bs-target="#createBranchModal">
                <i class="bi bi-plus-circle-fill me-1" style="color: #2563EB;"></i> Add New Branch
            </button>
        </div>
    </div>
</div>

<!-- Compact Different-Color KPI Summary Row -->
<div class="row g-3 mb-4">
    <!-- Card 1: Indigo Theme -->
    <div class="col-12 col-sm-6 col-xl-4">
        <div class="kpi-stat-card-v3 theme-indigo">
            <div class="d-flex align-items-center gap-2.5">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: #ffffff; color: #4F46E5; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
                    <i class="bi bi-geo-alt fs-6"></i>
                </div>
                <div>
                    <div class="kpi-label-sm" style="color: #312E81;">Active Branches</div>
                    <div class="kpi-number-sm" style="color: #1E1B4B;">{{ $branches->count() }} Offices</div>
                </div>
            </div>
            <span class="badge rounded-pill px-2.5 py-1 fs-8 fw-bold" style="background: #ffffff; color: #4338CA; border: 1px solid #C7D2FE;">
                Regional
            </span>
        </div>
    </div>

    <!-- Card 2: Emerald Theme -->
    <div class="col-12 col-sm-6 col-xl-4">
        <div class="kpi-stat-card-v3 theme-emerald">
            <div class="d-flex align-items-center gap-2.5">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: #ffffff; color: #047857; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
                    <i class="bi bi-building fs-6"></i>
                </div>
                <div>
                    <div class="kpi-label-sm" style="color: #065F46;">Primary HQ</div>
                    <div class="kpi-number-sm" style="color: #064E3B;">Central HQ</div>
                </div>
            </div>
            <span class="badge rounded-pill px-2.5 py-1 fs-8 fw-bold" style="background: #ffffff; color: #047857; border: 1px solid #A7F3D0;">
                Primary
            </span>
        </div>
    </div>

    <!-- Card 3: Amber Theme -->
    <div class="col-12 col-sm-6 col-xl-4">
        <div class="kpi-stat-card-v3 theme-amber">
            <div class="d-flex align-items-center gap-2.5">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: #ffffff; color: #D97706; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
                    <i class="bi bi-diagram-3 fs-6"></i>
                </div>
                <div>
                    <div class="kpi-label-sm" style="color: #92400E;">Linked Departments</div>
                    <div class="kpi-number-sm" style="color: #78350F;">14 Depts</div>
                </div>
            </div>
            <span class="badge rounded-pill px-2.5 py-1 fs-8 fw-bold" style="background: #ffffff; color: #B45309; border: 1px solid #FDE68A;">
                Assigned
            </span>
        </div>
    </div>
</div>

<!-- Organized Branches Table Card -->
<div class="directory-card">
    <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light bg-opacity-50">
        <div class="fs-8 text-muted fw-bold">
            Branch Offices Master Roster
        </div>
        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1.5 rounded-pill fs-8 fw-bold">
            Active Office Directory
        </span>
    </div>

    <div class="table-responsive">
        <table class="table table-directory align-middle mb-0 fs-7">
            <thead>
                <tr>
                    <th style="width: 40px;" class="ps-3"><input type="checkbox" class="form-check-input" id="selectAll"></th>
                    <th>BRANCH NAME</th>
                    <th>CODE</th>
                    <th>PARENT COMPANY</th>
                    <th>PHONE CONTACT</th>
                    <th>DEPARTMENTS</th>
                    <th>STATUS</th>
                    <th class="text-end pe-3" style="width: 100px;">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($branches as $branch)
                    <tr>
                        <td class="ps-3"><input type="checkbox" class="form-check-input row-checkbox"></td>
                        <td>
                            <div class="d-flex align-items-center gap-2.5">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: #FFF1F2; color: #E11D48;">
                                    <i class="bi bi-geo-alt-fill fs-6"></i>
                                </div>
                                <div class="fw-bold text-dark fs-7">{{ $branch->name }}</div>
                            </div>
                        </td>
                        <td><span class="code-chip">{{ $branch->code ?? 'N/A' }}</span></td>
                        <td><span class="fw-bold text-primary fs-7"><i class="bi bi-building me-1"></i> {{ $branch->company->name ?? 'N/A' }}</span></td>
                        <td><span class="fs-8 font-mono text-secondary">{{ $branch->phone ?? 'N/A' }}</span></td>
                        <td><span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle px-2.5 py-1 rounded-pill fs-8">{{ $branch->departments_count }} Departments</span></td>
                        <td>
                            <span class="status-badge-dot active"><span class="status-dot-pulse"></span> Active</span>
                        </td>
                        <td class="text-end pe-3">
                            <form action="{{ route('branches.destroy', $branch->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-light btn-sm text-danger rounded-circle p-1.5" style="width: 32px; height: 32px;"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">No branches found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Create Branch -->
<div class="modal fade" id="createBranchModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <form action="{{ route('branches.store') }}" method="POST">
                @csrf
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-extrabold text-dark fs-6">Add New Branch</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body fs-7">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Company *</label>
                        <select name="company_id" class="form-select rounded-3" required>
                            @foreach($companies as $comp)
                                <option value="{{ $comp->id }}">{{ $comp->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Branch Name *</label>
                        <input type="text" name="name" class="form-control rounded-3" required placeholder="e.g. Headquarters / Regional Office">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Branch Code</label>
                        <input type="text" name="code" class="form-control rounded-3" placeholder="e.g. HQ-01">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Phone</label>
                        <input type="text" name="phone" class="form-control rounded-3">
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-light rounded-pill btn-sm px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill btn-sm px-4">Create Branch</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
