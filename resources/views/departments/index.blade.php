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

    .kpi-stat-card-v3.theme-cyan {
        background: linear-gradient(135deg, #ECFEFF 0%, #CFFAFE 100%);
        border: 1.5px solid #A5F3FC;
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

    /* Tree View Widget */
    .tree-widget-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #EFEFF7;
        box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.05);
        padding: 1.25rem;
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
                    <i class="bi bi-diagram-3-fill me-1"></i> Corporate Structure & Hierarchy
                </span>
                <span class="fs-8 text-white-50">• System Settings</span>
            </div>
            <h3 class="mb-1 fw-extrabold text-white" style="letter-spacing: -0.02em;">
                Department Structure & Org Chart
            </h3>
            <p class="mb-0 text-white-50 fs-7">
                Configure top-level and sub-department hierarchies, branch relationships, and staff allocations.
            </p>
        </div>
        <div class="col-12 col-md-4 text-md-end">
            <button class="btn btn-light rounded-pill px-4 py-2 fw-bold text-dark fs-8 shadow-sm" data-bs-toggle="modal" data-bs-target="#createDepartmentModal">
                <i class="bi bi-plus-circle-fill me-1" style="color: #2563EB;"></i> Add Department
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
                    <i class="bi bi-folder-fill fs-6"></i>
                </div>
                <div>
                    <div class="kpi-label-sm" style="color: #312E81;">Active Departments</div>
                    <div class="kpi-number-sm" style="color: #1E1B4B;">{{ $departments->count() }} Depts</div>
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
                    <i class="bi bi-diagram-2 fs-6"></i>
                </div>
                <div>
                    <div class="kpi-label-sm" style="color: #065F46;">Org Hierarchy</div>
                    <div class="kpi-number-sm" style="color: #064E3B;">Multi-Level</div>
                </div>
            </div>
            <span class="badge rounded-pill px-2.5 py-1 fs-8 fw-bold" style="background: #ffffff; color: #047857; border: 1px solid #A7F3D0;">
                Tree Active
            </span>
        </div>
    </div>

    <!-- Card 3: Cyan Theme -->
    <div class="col-12 col-sm-6 col-xl-4">
        <div class="kpi-stat-card-v3 theme-cyan">
            <div class="d-flex align-items-center gap-2.5">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: #ffffff; color: #0891B2; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
                    <i class="bi bi-people-fill fs-6"></i>
                </div>
                <div>
                    <div class="kpi-label-sm" style="color: #0E7490;">Total Employees</div>
                    <div class="kpi-number-sm" style="color: #155E75;">48 Employees</div>
                </div>
            </div>
            <span class="badge rounded-pill px-2.5 py-1 fs-8 fw-bold" style="background: #ffffff; color: #0891B2; border: 1px solid #A5F3FC;">
                Assigned
            </span>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Left Table -->
    <div class="col-12 col-lg-8">
        <div class="directory-card">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light bg-opacity-50">
                <div class="fs-8 text-muted fw-bold">
                    Department Master Roster
                </div>
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1.5 rounded-pill fs-8 fw-bold">
                    Department Master Active
                </span>
            </div>

            <div class="table-responsive">
                <table class="table table-directory align-middle mb-0 fs-7">
                    <thead>
                        <tr>
                            <th>DEPARTMENT NAME</th>
                            <th>BRANCH</th>
                            <th>PARENT DEPT</th>
                            <th>ASSIGNED MEMBERS</th>
                            <th class="text-end pe-3" style="width: 110px;">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($departments as $dept)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2.5">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: #FFFBEB; color: #D97706;">
                                            <i class="bi bi-folder-fill fs-6"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark fs-7">{{ $dept->name }}</div>
                                            <div class="fs-8 text-muted font-monospace">{{ $dept->code ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-light text-dark border px-2.5 py-1 fs-8">{{ $dept->branch->name ?? 'All Branches' }}</span></td>
                                <td>
                                    @if($dept->parentDepartment)
                                        <span class="badge bg-purple bg-opacity-10 text-purple border border-purple-subtle px-2.5 py-1 rounded-pill fs-8" style="background: #F3E8FF; color: #7E22CE;">
                                            <i class="bi bi-arrow-return-right me-1"></i>{{ $dept->parentDepartment->name }}
                                        </span>
                                    @else
                                        <span class="text-muted fs-8">Top-level</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2" 
                                         onclick="Swal.fire({title: '{{ $dept->name }} Members', html: '<div class=\'text-start fs-7\'><div class=\'p-2 bg-light rounded mb-2 d-flex align-items-center gap-2\'><img src=\'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=80\' class=\'rounded-circle\' style=\'width:32px;height:32px;\'><div><b>Sarah Connor</b><br><span class=\'text-muted fs-8\'>Head of Department</span></div></div><div class=\'p-2 bg-light rounded d-flex align-items-center gap-2\'><img src=\'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=80\' class=\'rounded-circle\' style=\'width:32px;height:32px;\'><div><b>Michael Scott</b><br><span class=\'text-muted fs-8\'>Senior Lead</span></div></div></div>', confirmButtonColor: '#2563EB'})">
                                        <div class="avatar-stack-group">
                                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=80&q=80" class="avatar-stack-item">
                                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=80&q=80" class="avatar-stack-item">
                                        </div>
                                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle px-2 py-0.5 rounded-pill fs-8 fw-bold">
                                            {{ $dept->employees_count }} Members <i class="bi bi-eye-fill ms-0.5"></i>
                                        </span>
                                    </div>
                                </td>
                                <td class="text-end pe-3">
                                    <div class="d-flex justify-content-end align-items-center gap-1">
                                        <button class="btn btn-light btn-sm text-primary rounded-circle p-1.5" style="width: 32px; height: 32px;" 
                                                data-bs-toggle="modal" data-bs-target="#editDepartmentModal-{{ $dept->id }}" title="Edit Department">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
                                        <form action="{{ route('departments.destroy', $dept->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this department?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-light btn-sm text-danger rounded-circle p-1.5" style="width: 32px; height: 32px;" title="Delete Department">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal: Edit Department -->
                            <div class="modal fade" id="editDepartmentModal-{{ $dept->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content rounded-4 border-0 shadow-lg">
                                        <form action="{{ route('departments.update', $dept->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header border-bottom">
                                                <h5 class="modal-title fw-extrabold text-dark fs-6">Edit Department: {{ $dept->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body fs-7">
                                                <input type="hidden" name="company_id" value="{{ $dept->company_id }}">
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Branch</label>
                                                    <select name="branch_id" class="form-select rounded-3">
                                                        <option value="">All Branches</option>
                                                        @foreach($branches as $b)
                                                            <option value="{{ $b->id }}" {{ $dept->branch_id == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Department Name *</label>
                                                    <input type="text" name="name" class="form-control rounded-3" value="{{ $dept->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Department Code</label>
                                                    <input type="text" name="code" class="form-control rounded-3" value="{{ $dept->code }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Parent Department</label>
                                                    <select name="parent_department_id" class="form-select rounded-3">
                                                        <option value="">None (Top-Level)</option>
                                                        @foreach($departments->where('id', '!=', $dept->id) as $d)
                                                            <option value="{{ $d->id }}" {{ $dept->parent_department_id == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-top">
                                                <button type="button" class="btn btn-light rounded-pill btn-sm px-3" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary rounded-pill btn-sm px-4">Update Department</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No departments found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Tree View -->
    <div class="col-12 col-lg-4">
        <div class="tree-widget-card">
            <div class="fw-extrabold text-dark fs-7 mb-3 d-flex align-items-center gap-2">
                <span class="p-1.5 bg-success bg-opacity-10 text-success rounded-3">
                    <i class="bi bi-diagram-2"></i>
                </span>
                Org Tree Hierarchy Preview
            </div>

            <div class="fs-7">
                <div class="tree-root fw-bold text-primary mb-2">
                    <i class="bi bi-building me-1"></i> Acme Global Corporate HQ
                </div>
                <ul class="list-unstyled ps-3 border-start border-2 ms-2">
                    @foreach($departments->whereNull('parent_department_id') as $topDept)
                        <li class="mb-2">
                            <div class="fw-semibold text-dark fs-7"><i class="bi bi-folder-symlink-fill text-warning me-1"></i> {{ $topDept->name }}</div>
                            @if($topDept->subDepartments->count() > 0)
                                <ul class="list-unstyled ps-3 border-start border-2 ms-2 mt-1">
                                    @foreach($topDept->subDepartments as $subDept)
                                        <li class="text-muted fs-8 mb-1"><i class="bi bi-node-plus-fill me-1" style="color: #2563EB;"></i> {{ $subDept->name }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Create Department -->
<div class="modal fade" id="createDepartmentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <form action="{{ route('departments.store') }}" method="POST">
                @csrf
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-extrabold text-dark fs-6">Add Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body fs-7">
                    <input type="hidden" name="company_id" value="{{ $companies->first()->id ?? 1 }}">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Branch</label>
                        <select name="branch_id" class="form-select rounded-3">
                            <option value="">All Branches</option>
                            @foreach($branches as $b)
                                <option value="{{ $b->id }}">{{ $b->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Department Name *</label>
                        <input type="text" name="name" class="form-control rounded-3" required placeholder="e.g. Quality Assurance">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Department Code</label>
                        <input type="text" name="code" class="form-control rounded-3" placeholder="e.g. QA">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Parent Department</label>
                        <select name="parent_department_id" class="form-select rounded-3">
                            <option value="">None (Top-Level)</option>
                            @foreach($departments as $d)
                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-light rounded-pill btn-sm px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill btn-sm px-4">Create Department</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
