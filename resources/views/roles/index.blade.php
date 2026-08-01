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

    /* Premium Role Card */
    .role-mesh-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #EFEFF7;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.04);
        padding: 1.35rem;
        transition: all 0.25s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .role-mesh-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(37, 99, 235, 0.12);
        border-color: #BFDBFE;
    }

    .action-btn-pill-v2 {
        padding: 0.35rem 0.75rem;
        border-radius: 10px;
        font-size: 0.76rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        transition: all 0.2s ease;
        text-decoration: none;
        border: none;
    }

    .action-btn-pill-v2.edit {
        background: #EFF6FF;
        color: #1D4ED8;
        border: 1px solid #BFDBFE;
    }

    .action-btn-pill-v2.edit:hover {
        background: #2563EB;
        color: #ffffff;
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
                    <i class="bi bi-shield-lock-fill me-1"></i> RBAC Security Matrix
                </span>
                <span class="fs-8 text-white-50">• System Settings</span>
            </div>
            <h3 class="mb-1 fw-extrabold text-white" style="letter-spacing: -0.02em;">
                Access Control & Role Matrix
            </h3>
            <p class="mb-0 text-white-50 fs-7">
                Define role permissions, module privilege gates, and user security access profiles.
            </p>
        </div>
        <div class="col-12 col-md-4 text-md-end">
            <button class="btn btn-light rounded-pill px-4 py-2 fw-bold text-dark fs-8 shadow-sm" data-bs-toggle="modal" data-bs-target="#createRoleModal">
                <i class="bi bi-shield-plus me-1" style="color: #2563EB;"></i> Create New Custom Role
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
                    <i class="bi bi-shield-lock fs-6"></i>
                </div>
                <div>
                    <div class="kpi-label-sm" style="color: #312E81;">Configured Roles</div>
                    <div class="kpi-number-sm" style="color: #1E1B4B;">{{ $roles->count() }} System Roles</div>
                </div>
            </div>
            <span class="badge rounded-pill px-2.5 py-1 fs-8 fw-bold" style="background: #ffffff; color: #4338CA; border: 1px solid #C7D2FE;">
                RBAC Matrix
            </span>
        </div>
    </div>

    <!-- Card 2: Emerald Theme -->
    <div class="col-12 col-sm-6 col-xl-4">
        <div class="kpi-stat-card-v3 theme-emerald">
            <div class="d-flex align-items-center gap-2.5">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: #ffffff; color: #047857; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
                    <i class="bi bi-people fs-6"></i>
                </div>
                <div>
                    <div class="kpi-label-sm" style="color: #065F46;">Active Users</div>
                    <div class="kpi-number-sm" style="color: #064E3B;">48 User Accounts</div>
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
                    <i class="bi bi-key-fill fs-6"></i>
                </div>
                <div>
                    <div class="kpi-label-sm" style="color: #0E7490;">Permissions Granted</div>
                    <div class="kpi-number-sm" style="color: #155E75;">32 Privileges</div>
                </div>
            </div>
            <span class="badge rounded-pill px-2.5 py-1 fs-8 fw-bold" style="background: #ffffff; color: #0891B2; border: 1px solid #A5F3FC;">
                Gates Active
            </span>
        </div>
    </div>
</div>

<!-- Role Cards Grid -->
<div class="row g-4">
    @foreach($roles as $role)
        <div class="col-12 col-md-6 col-xl-4">
            <div class="role-mesh-card">
                <div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 34px; height: 34px; background: #EFF6FF; color: #2563EB;">
                                <i class="bi bi-shield-lock-fill fs-6"></i>
                            </div>
                            <h5 class="fw-extrabold text-dark mb-0 fs-6">{{ $role->name }}</h5>
                        </div>
                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle px-2.5 py-1 rounded-pill fs-8">{{ $role->users_count }} Users</span>
                    </div>

                    <div class="fs-8 text-muted mb-2 font-mono">
                        Permissions Granted: <span class="fw-bold text-dark">{{ $role->permissions->count() }}</span>
                    </div>

                    <div class="d-flex flex-wrap gap-1 mb-3" style="max-height: 110px; overflow-y: auto;">
                        @foreach($role->permissions as $p)
                            <span class="badge bg-light text-dark border fs-8">{{ $p->name }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                    <button class="action-btn-pill-v2 edit" data-bs-toggle="modal" data-bs-target="#editRoleModal-{{ $role->id }}">
                        <i class="bi bi-sliders"></i> Edit Permissions
                    </button>
                    @if(!in_array($role->name, ['Super Admin', 'Admin', 'HR', 'Employee']))
                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Delete role?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-light btn-sm text-danger rounded-circle p-1.5" style="width: 32px; height: 32px;"><i class="bi bi-trash"></i></button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Modal: Edit Role Permissions Matrix -->
        <div class="modal fade" id="editRoleModal-{{ $role->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content rounded-4 border-0 shadow-lg">
                    <form action="{{ route('roles.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header border-bottom">
                            <h5 class="modal-title fw-extrabold text-dark fs-6">Edit Permissions: {{ $role->name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body fs-7" style="max-height: 480px; overflow-y: auto;">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Role Name</label>
                                <input type="text" name="name" class="form-control rounded-3" value="{{ $role->name }}" required>
                            </div>

                            <h6 class="fw-bold border-bottom pb-2 mb-3">Module Permission Matrix</h6>

                            @foreach($groupedPermissions as $groupName => $perms)
                                <div class="card mb-3 border rounded-3 overflow-hidden">
                                    <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                                        <span class="fw-bold fs-7">{{ $groupName }}</span>
                                        <button type="button" class="btn btn-link btn-sm p-0 text-decoration-none fs-8" onclick="toggleGroup(this)">Select All</button>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="row g-2">
                                            @foreach($perms as $perm)
                                                <div class="col-6 col-md-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input perm-check" type="checkbox" name="permissions[]" value="{{ $perm->id }}" id="perm-{{ $role->id }}-{{ $perm->id }}" {{ $role->hasPermissionTo($perm->name) ? 'checked' : '' }}>
                                                        <label class="form-check-label fs-8" for="perm-{{ $role->id }}-{{ $perm->id }}">
                                                            {{ $perm->name }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="modal-footer border-top">
                            <button type="button" class="btn btn-light rounded-pill btn-sm px-3" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary rounded-pill btn-sm px-4">Save Permission Matrix</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Modal: Create Role -->
<div class="modal fade" id="createRoleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-extrabold text-dark fs-6">Create New Custom Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body fs-7">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Role Name *</label>
                        <input type="text" name="name" class="form-control rounded-3" required placeholder="e.g. Payroll Auditor / Branch Supervisor">
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-light rounded-pill btn-sm px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill btn-sm px-4">Create Role</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function toggleGroup(btn) {
        const cardBody = $(btn).closest('.card').find('.card-body');
        const checkboxes = cardBody.find('.perm-check');
        const allChecked = checkboxes.filter(':checked').length === checkboxes.length;
        checkboxes.prop('checked', !allChecked);
    }
</script>
@endpush
@endsection
