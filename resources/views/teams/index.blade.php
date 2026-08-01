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
                    <i class="bi bi-people-fill me-1"></i> Cross-Functional Working Groups
                </span>
                <span class="fs-8 text-white-50">• System Settings</span>
            </div>
            <h3 class="mb-1 fw-extrabold text-white" style="letter-spacing: -0.02em;">
                Teams & Working Groups Directory
            </h3>
            <p class="mb-0 text-white-50 fs-7">
                Organize agile working squads, project teams, departmental guilds, and team lead assignments.
            </p>
        </div>
        <div class="col-12 col-md-4 text-md-end">
            <button class="btn btn-light rounded-pill px-4 py-2 fw-bold text-dark fs-8 shadow-sm" data-bs-toggle="modal" data-bs-target="#createTeamModal">
                <i class="bi bi-plus-circle-fill me-1" style="color: #2563EB;"></i> Create New Team
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
                    <i class="bi bi-microsoft-teams fs-6"></i>
                </div>
                <div>
                    <div class="kpi-label-sm" style="color: #312E81;">Active Teams</div>
                    <div class="kpi-number-sm" style="color: #1E1B4B;">8 Agile Teams</div>
                </div>
            </div>
            <span class="badge rounded-pill px-2.5 py-1 fs-8 fw-bold" style="background: #ffffff; color: #4338CA; border: 1px solid #C7D2FE;">
                Operating
            </span>
        </div>
    </div>

    <!-- Card 2: Emerald Theme -->
    <div class="col-12 col-sm-6 col-xl-4">
        <div class="kpi-stat-card-v3 theme-emerald">
            <div class="d-flex align-items-center gap-2.5">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: #ffffff; color: #047857; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
                    <i class="bi bi-person-check fs-6"></i>
                </div>
                <div>
                    <div class="kpi-label-sm" style="color: #065F46;">Team Leaders</div>
                    <div class="kpi-number-sm" style="color: #064E3B;">8 Leads</div>
                </div>
            </div>
            <span class="badge rounded-pill px-2.5 py-1 fs-8 fw-bold" style="background: #ffffff; color: #047857; border: 1px solid #A7F3D0;">
                Assigned
            </span>
        </div>
    </div>

    <!-- Card 3: Cyan Theme -->
    <div class="col-12 col-sm-6 col-xl-4">
        <div class="kpi-stat-card-v3 theme-cyan">
            <div class="d-flex align-items-center gap-2.5">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: #ffffff; color: #0891B2; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
                    <i class="bi bi-people fs-6"></i>
                </div>
                <div>
                    <div class="kpi-label-sm" style="color: #0E7490;">Total Team Members</div>
                    <div class="kpi-number-sm" style="color: #155E75;">42 Members</div>
                </div>
            </div>
            <span class="badge rounded-pill px-2.5 py-1 fs-8 fw-bold" style="background: #ffffff; color: #0891B2; border: 1px solid #A5F3FC;">
                Allocated
            </span>
        </div>
    </div>
</div>

<!-- Organized Teams Table Card -->
<div class="directory-card">
    <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light bg-opacity-50">
        <div class="fs-8 text-muted fw-bold">
            Agile Squads & Working Teams Master Roster
        </div>
        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1.5 rounded-pill fs-8 fw-bold">
            Teams Active
        </span>
    </div>

    <div class="table-responsive">
        <table class="table table-directory align-middle mb-0 fs-7">
            <thead>
                <tr>
                    <th style="width: 40px;" class="ps-3"><input type="checkbox" class="form-check-input" id="selectAll"></th>
                    <th>TEAM NAME & SQUAD</th>
                    <th>TEAM LEADER</th>
                    <th>DEPARTMENT SCOPE</th>
                    <th>TOTAL MEMBERS</th>
                    <th>STATUS</th>
                    <th class="text-end pe-3" style="width: 110px;">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                <tr id="team-row-1">
                    <td class="ps-3"><input type="checkbox" class="form-check-input row-checkbox"></td>
                    <td>
                        <div class="d-flex align-items-center gap-2.5">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: #EEF2FF; color: #4F46E5;">
                                <i class="bi bi-diagram-3-fill fs-6"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark fs-7" id="team-title-1">Frontend Architecture Guild</div>
                                <div class="fs-8 text-muted">Core Web UI Engineering</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&q=80" 
                                 class="rounded-circle shadow-sm" style="width: 32px; height: 32px; object-fit: cover;">
                            <div>
                                <div class="fw-bold text-dark fs-7">Michael Scott</div>
                                <div class="fs-8 text-muted font-monospace">Lead Tech</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge bg-light text-dark border px-2.5 py-1 fs-8">Engineering</span></td>
                    <td><span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle px-2.5 py-1 rounded-pill fs-8">8 Members</span></td>
                    <td>
                        <span class="status-badge-dot active"><span class="status-dot-pulse"></span> Active</span>
                    </td>
                    <td class="text-end pe-3">
                        <div class="d-flex justify-content-end align-items-center gap-1">
                            <button class="btn btn-light btn-sm text-primary rounded-circle p-1.5" style="width: 32px; height: 32px;" data-bs-toggle="modal" data-bs-target="#editTeamModal-1" title="Edit Team">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                            <button class="btn btn-light btn-sm text-danger rounded-circle p-1.5" style="width: 32px; height: 32px;" title="Delete Team" onclick="if(confirm('Delete Frontend Architecture Guild?')){ document.getElementById('team-row-1').remove(); Swal.fire({icon:'success', title:'Deleted!', text:'Team deleted successfully.', timer:1500, showConfirmButton:false}); }">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Create Team -->
<div class="modal fade" id="createTeamModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <form onsubmit="event.preventDefault(); $('#createTeamModal').modal('hide'); Swal.fire({icon:'success', title:'Team Created!', text:'New working squad added.', confirmButtonColor: '#2563EB', customClass: {popup:'rounded-4 border-0 shadow-lg'}})">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-extrabold text-dark fs-6">Create New Team Squad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body fs-7">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Team Squad Name *</label>
                        <input type="text" class="form-control rounded-3" required placeholder="e.g. DevOps Infrastructure Taskforce">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Team Leader</label>
                        <input type="text" class="form-control rounded-3" placeholder="e.g. Michael Scott">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Department Scope</label>
                        <select class="form-select rounded-3">
                            @foreach($departments as $d)
                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-light rounded-pill btn-sm px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill btn-sm px-4">Create Team</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Edit Team 1 -->
<div class="modal fade" id="editTeamModal-1" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <form onsubmit="event.preventDefault(); $('#editTeamModal-1').modal('hide'); Swal.fire({icon:'success', title:'Team Updated!', text:'Frontend Architecture Guild updated.', confirmButtonColor: '#2563EB', customClass: {popup:'rounded-4 border-0 shadow-lg'}})">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-extrabold text-dark fs-6">Edit Team: Frontend Architecture Guild</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body fs-7">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Team Squad Name *</label>
                        <input type="text" class="form-control rounded-3" value="Frontend Architecture Guild" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Team Leader</label>
                        <input type="text" class="form-control rounded-3" value="Michael Scott">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Department Scope</label>
                        <select class="form-select rounded-3">
                            @foreach($departments as $d)
                                <option value="{{ $d->id }}" {{ $d->name == 'Engineering' ? 'selected' : '' }}>{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-light rounded-pill btn-sm px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill btn-sm px-4">Update Team</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
