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

    /* Avatar Stack Component */
    .avatar-stack-group {
        display: inline-flex;
        align-items: center;
        cursor: pointer;
    }

    .avatar-stack-item {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: 2px solid #ffffff;
        object-fit: cover;
        margin-left: -8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .avatar-stack-item:first-child {
        margin-left: 0;
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
                    <i class="bi bi-person-badge-fill me-1"></i> Job Titles & Roles Structure
                </span>
                <span class="fs-8 text-white-50">• System Settings</span>
            </div>
            <h3 class="mb-1 fw-extrabold text-white" style="letter-spacing: -0.02em;">
                Designations & Job Titles Directory
            </h3>
            <p class="mb-0 text-white-50 fs-7">
                Manage job designations, seniority levels, department scopes, and employee position ranks.
            </p>
        </div>
        <div class="col-12 col-md-4 text-md-end">
            <button class="btn btn-light rounded-pill px-4 py-2 fw-bold text-dark fs-8 shadow-sm" data-bs-toggle="modal" data-bs-target="#createDesignationModal">
                <i class="bi bi-plus-circle-fill me-1" style="color: #2563EB;"></i> Add Designation
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
                    <i class="bi bi-person-badge fs-6"></i>
                </div>
                <div>
                    <div class="kpi-label-sm" style="color: #312E81;">Active Designations</div>
                    <div class="kpi-number-sm" style="color: #1E1B4B;">18 Job Titles</div>
                </div>
            </div>
            <span class="badge rounded-pill px-2.5 py-1 fs-8 fw-bold" style="background: #ffffff; color: #4338CA; border: 1px solid #C7D2FE;">
                Configured
            </span>
        </div>
    </div>

    <!-- Card 2: Emerald Theme -->
    <div class="col-12 col-sm-6 col-xl-4">
        <div class="kpi-stat-card-v3 theme-emerald">
            <div class="d-flex align-items-center gap-2.5">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: #ffffff; color: #047857; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
                    <i class="bi bi-award fs-6"></i>
                </div>
                <div>
                    <div class="kpi-label-sm" style="color: #065F46;">Seniority Ranks</div>
                    <div class="kpi-number-sm" style="color: #064E3B;">5 Level Bands</div>
                </div>
            </div>
            <span class="badge rounded-pill px-2.5 py-1 fs-8 fw-bold" style="background: #ffffff; color: #047857; border: 1px solid #A7F3D0;">
                Rank Matrix
            </span>
        </div>
    </div>

    <!-- Card 3: Amber Theme -->
    <div class="col-12 col-sm-6 col-xl-4">
        <div class="kpi-stat-card-v3 theme-amber">
            <div class="d-flex align-items-center gap-2.5">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: #ffffff; color: #D97706; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
                    <i class="bi bi-people fs-6"></i>
                </div>
                <div>
                    <div class="kpi-label-sm" style="color: #92400E;">Assigned Staff</div>
                    <div class="kpi-number-sm" style="color: #78350F;">48 Employees</div>
                </div>
            </div>
            <span class="badge rounded-pill px-2.5 py-1 fs-8 fw-bold" style="background: #ffffff; color: #B45309; border: 1px solid #FDE68A;">
                Assigned
            </span>
        </div>
    </div>
</div>

<!-- Organized Designations Table Card -->
<div class="directory-card">
    <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light bg-opacity-50">
        <div class="fs-8 text-muted fw-bold">
            Corporate Designations Master Roster
        </div>
        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1.5 rounded-pill fs-8 fw-bold">
            Designation Matrix Active
        </span>
    </div>

    <div class="table-responsive">
        <table class="table table-directory align-middle mb-0 fs-7">
            <thead>
                <tr>
                    <th style="width: 40px;" class="ps-3"><input type="checkbox" class="form-check-input" id="selectAll"></th>
                    <th>DESIGNATION / JOB TITLE</th>
                    <th>LINKED DEPARTMENT</th>
                    <th>SENIORITY RANK LEVEL</th>
                    <th>ASSIGNED MEMBERS</th>
                    <th>STATUS</th>
                    <th class="text-end pe-3" style="width: 110px;">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($designations as $desig)
                <tr>
                    <td class="ps-3"><input type="checkbox" class="form-check-input row-checkbox"></td>
                    <td>
                        <div class="d-flex align-items-center gap-2.5">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: #EFF6FF; color: #2563EB;">
                                <i class="bi bi-person-badge-fill fs-6"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark fs-7">{{ $desig->title }}</div>
                                <div class="fs-8 text-muted">Seniority Band L{{ $desig->level ?? 1 }}</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge bg-light text-dark border px-2.5 py-1 fs-8">{{ $desig->department?->name ?? 'General' }}</span></td>
                    <td><span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle px-2.5 py-1 rounded-pill fs-8">Level {{ $desig->level ?? 1 }}</span></td>
                    <td>
                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle px-2.5 py-1 rounded-pill fs-8 fw-bold">
                            {{ $desig->employees_count }} Staff Assigned
                        </span>
                    </td>
                    <td>
                        @if($desig->status)
                            <span class="status-badge-dot active"><span class="status-dot-pulse"></span> Active</span>
                        @else
                            <span class="status-badge-dot inactive">Inactive</span>
                        @endif
                    </td>
                    <td class="text-end pe-3">
                        <div class="d-flex justify-content-end align-items-center gap-1">
                            <button class="btn btn-light btn-sm text-primary rounded-circle p-1.5" style="width: 32px; height: 32px;"
                                    onclick="editDesignationModal('{{ $desig->id }}', '{{ route('designations.update', $desig->id) }}', '{{ addslashes($desig->title) }}', '{{ $desig->department_id }}', '{{ $desig->level }}')" title="Edit Designation">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                            <form action="{{ route('designations.destroy', $desig->id) }}" method="POST" onsubmit="return confirm('Delete {{ addslashes($desig->title) }} designation?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-light btn-sm text-danger rounded-circle p-1.5" style="width: 32px; height: 32px;" title="Delete Designation">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center p-4 text-muted fs-8">
                        <i class="bi bi-person-badge fs-4 d-block mb-1"></i>
                        No designations configured yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Create Designation -->
<div class="modal fade" id="createDesignationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <form action="{{ route('designations.store') }}" method="POST">
                @csrf
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-extrabold text-dark fs-6">Add New Designation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body fs-7">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Designation Title *</label>
                        <input type="text" name="title" class="form-control rounded-3" required placeholder="e.g. Senior DevOps Specialist">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Department *</label>
                        <select name="department_id" class="form-select rounded-3" required>
                            <option value="">Select Department</option>
                            @foreach($departments as $d)
                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Seniority Rank Level (1-5)</label>
                        <select name="level" class="form-select rounded-3">
                            <option value="1">Junior Level (L1)</option>
                            <option value="2">Mid Level (L2)</option>
                            <option value="3">Senior Level (L3)</option>
                            <option value="4" selected>Lead Specialist (L4)</option>
                            <option value="5">Principal / Director (L5)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-light rounded-pill btn-sm px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill btn-sm px-4">Save Designation</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Dynamic Edit Designation -->
<div class="modal fade" id="editDesignationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <form id="editDesignationForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-extrabold text-dark fs-6">Edit Designation Title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body fs-7">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Designation Title *</label>
                        <input type="text" name="title" id="edit_desig_title" class="form-control rounded-3" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Department *</label>
                        <select name="department_id" id="edit_desig_department_id" class="form-select rounded-3" required>
                            @foreach($departments as $d)
                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Seniority Rank Level</label>
                        <select name="level" id="edit_desig_level" class="form-select rounded-3">
                            <option value="1">Junior Level (L1)</option>
                            <option value="2">Mid Level (L2)</option>
                            <option value="3">Senior Level (L3)</option>
                            <option value="4">Lead Specialist (L4)</option>
                            <option value="5">Principal / Director (L5)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-light rounded-pill btn-sm px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill btn-sm px-4">Update Designation</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function editDesignationModal(id, actionUrl, title, departmentId, level) {
        document.getElementById('editDesignationForm').action = actionUrl;
        document.getElementById('edit_desig_title').value = title;
        document.getElementById('edit_desig_department_id').value = departmentId;
        document.getElementById('edit_desig_level').value = level || 1;

        var modal = new bootstrap.Modal(document.getElementById('editDesignationModal'));
        modal.show();
    }
</script>
@endpush
@endsection
