@extends('layouts.app')

@push('styles')
<style>
    .settings-hero {
        background: linear-gradient(135deg, #0F172A 0%, #1E293B 50%, #334155 100%);
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

    .kpi-stat-card-v3.theme-rose {
        background: linear-gradient(135deg, #FFF1F2 0%, #FFE4E6 100%);
        border: 1.5px solid #FECDD3;
    }

    .kpi-stat-card-v3.theme-emerald {
        background: linear-gradient(135deg, #ECFDF5 0%, #D1FAE5 100%);
        border: 1.5px solid #A7F3D0;
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
</style>
@endpush

@section('content')
<!-- Hero Header -->
<div class="settings-hero">
    <div class="row align-items-center g-3">
        <div class="col-12 col-md-8">
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge rounded-pill bg-white bg-opacity-20 text-white fs-8 px-2.5 py-1">
                    <i class="bi bi-journal-check me-1"></i> Security & System Audit Trail
                </span>
                <span class="fs-8 text-white-50">• System Settings</span>
            </div>
            <h3 class="mb-1 fw-extrabold text-white" style="letter-spacing: -0.02em;">
                System Audit Logs & Activity History
            </h3>
            <p class="mb-0 text-white-50 fs-7">
                Immutable audit trail tracking user authentication events, role permission modifications, and data edits.
            </p>
        </div>
        <div class="col-12 col-md-4 text-md-end">
            <button class="btn btn-light rounded-pill px-4 py-2 fw-bold text-dark fs-8 shadow-sm"
                    onclick="Swal.fire({icon: 'success', title: 'Audit Trail Exported', text: 'PDF audit log file generated.', confirmButtonColor: '#2563EB'})">
                <i class="bi bi-download me-1" style="color: #2563EB;"></i> Export Audit Ledger
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
                    <i class="bi bi-journal-text fs-6"></i>
                </div>
                <div>
                    <div class="kpi-label-sm" style="color: #312E81;">Total Audit Events</div>
                    <div class="kpi-number-sm" style="color: #1E1B4B;">1,284 Events</div>
                </div>
            </div>
            <span class="badge rounded-pill px-2.5 py-1 fs-8 fw-bold" style="background: #ffffff; color: #4338CA; border: 1px solid #C7D2FE;">
                All Time
            </span>
        </div>
    </div>

    <!-- Card 2: Rose Theme -->
    <div class="col-12 col-sm-6 col-xl-4">
        <div class="kpi-stat-card-v3 theme-rose">
            <div class="d-flex align-items-center gap-2.5">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: #ffffff; color: #E11D48; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
                    <i class="bi bi-exclamation-triangle-fill fs-6"></i>
                </div>
                <div>
                    <div class="kpi-label-sm" style="color: #9F1239;">High Severity Actions</div>
                    <div class="kpi-number-sm" style="color: #881337;">12 Flagged</div>
                </div>
            </div>
            <span class="badge rounded-pill px-2.5 py-1 fs-8 fw-bold" style="background: #ffffff; color: #BE185D; border: 1px solid #FECDD3;">
                Security
            </span>
        </div>
    </div>

    <!-- Card 3: Emerald Theme -->
    <div class="col-12 col-sm-6 col-xl-4">
        <div class="kpi-stat-card-v3 theme-emerald">
            <div class="d-flex align-items-center gap-2.5">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: #ffffff; color: #047857; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
                    <i class="bi bi-people fs-6"></i>
                </div>
                <div>
                    <div class="kpi-label-sm" style="color: #065F46;">Active Users Logged</div>
                    <div class="kpi-number-sm" style="color: #064E3B;">48 Users</div>
                </div>
            </div>
            <span class="badge rounded-pill px-2.5 py-1 fs-8 fw-bold" style="background: #ffffff; color: #047857; border: 1px solid #A7F3D0;">
                Today
            </span>
        </div>
    </div>
</div>

<!-- Organized Audit Logs Table Card -->
<div class="directory-card">
    <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light bg-opacity-50">
        <div class="fs-8 text-muted fw-bold">
            Real-Time System Audit Log Feed
        </div>
        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1.5 rounded-pill fs-8 fw-bold">
            Live Stream Active
        </span>
    </div>

    <div class="table-responsive">
        <table class="table table-directory align-middle mb-0 fs-7">
            <thead>
                <tr>
                    <th>TIMESTAMP</th>
                    <th>USER / PERFORMER</th>
                    <th>ACTION / EVENT</th>
                    <th>MODULE</th>
                    <th>IP ADDRESS</th>
                    <th class="text-end pe-3" style="width: 90px;">DETAILS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><span class="fs-8 font-monospace text-dark fw-bold">2026-07-25 16:45:12</span></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=100&q=80" 
                                 class="rounded-circle shadow-sm" style="width: 32px; height: 32px; object-fit: cover;">
                            <div>
                                <div class="fw-bold text-dark fs-7">Sarah Connor</div>
                                <div class="fs-8 text-muted font-monospace">Super Admin</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-purple bg-opacity-10 text-purple border border-purple-subtle px-2.5 py-1 rounded-pill fs-8" style="background: #F3E8FF; color: #7E22CE;">
                            <i class="bi bi-shield-check me-1"></i> Role Permissions Updated
                        </span>
                    </td>
                    <td><span class="badge bg-light text-dark border px-2.5 py-1 fs-8">Access Control</span></td>
                    <td><span class="fs-8 font-monospace text-secondary">192.168.1.45</span></td>
                    <td class="text-end pe-3">
                        <button class="btn btn-light btn-sm text-primary rounded-circle p-1.5" style="width: 32px; height: 32px;"
                                onclick="Swal.fire({title: 'Audit Detail', html: '<div class=\'text-start fs-7\'><p><b>Action:</b> Role Permissions Updated</p><p><b>Target:</b> HR Manager Role</p><p><b>IP:</b> 192.168.1.45</p><p><b>Browser:</b> Chrome v126 (Windows)</p></div>', confirmButtonColor: '#2563EB'})">
                            <i class="bi bi-eye-fill"></i>
                        </button>
                    </td>
                </tr>

                <tr>
                    <td><span class="fs-8 font-monospace text-dark fw-bold">2026-07-25 15:20:08</span></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&q=80" 
                                 class="rounded-circle shadow-sm" style="width: 32px; height: 32px; object-fit: cover;">
                            <div>
                                <div class="fw-bold text-dark fs-7">Michael Scott</div>
                                <div class="fs-8 text-muted font-monospace">Finance Admin</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-emerald bg-opacity-10 text-success border border-success-subtle px-2.5 py-1 rounded-pill fs-8" style="background: #ECFDF5; color: #059669;">
                            <i class="bi bi-currency-dollar me-1"></i> July Payroll Executed
                        </span>
                    </td>
                    <td><span class="badge bg-light text-dark border px-2.5 py-1 fs-8">Payroll & Finance</span></td>
                    <td><span class="fs-8 font-monospace text-secondary">192.168.1.88</span></td>
                    <td class="text-end pe-3">
                        <button class="btn btn-light btn-sm text-primary rounded-circle p-1.5" style="width: 32px; height: 32px;"
                                onclick="Swal.fire({title: 'Audit Detail', html: '<div class=\'text-start fs-7\'><p><b>Action:</b> July Payroll Executed</p><p><b>Target:</b> $128,450 Direct Deposit</p><p><b>IP:</b> 192.168.1.88</p></div>', confirmButtonColor: '#2563EB'})">
                            <i class="bi bi-eye-fill"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
