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

    .timelogs-hero {
        background: linear-gradient(-45deg, #059669, #10B981, #0D9488, #047857);
        background-size: 300% 300%;
        animation: gradientMesh 12s ease infinite, fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        border-radius: 24px;
        padding: 2.25rem 2.5rem;
        color: #ffffff;
        margin-bottom: 1.75rem;
        box-shadow: 0 20px 45px rgba(16, 185, 129, 0.3);
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
        box-shadow: inset 3px 0 0 #10B981;
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
<div class="timelogs-hero">
    <div class="row align-items-center g-3">
        <div class="col-12 col-md-8">
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge rounded-pill bg-white bg-opacity-20 text-white fs-8 px-2.5 py-1">
                    <i class="bi bi-clock-history me-1"></i> Billable Hours
                </span>
                <span class="fs-8 text-white-50">• {{ number_format($stats['total_hours'], 1) }} Total Hours Logged</span>
            </div>
            <h3 class="mb-1 fw-extrabold text-white" style="letter-spacing: -0.02em;">
                Billable Time Logs & Work Hours
            </h3>
            <p class="mb-0 text-white-50 fs-7">
                Log employee work hours on project tasks, audit billable time sheets, and track team velocity.
            </p>
        </div>
        <div class="col-12 col-md-4 text-md-end">
            <button class="btn btn-light rounded-pill px-4 py-2.5 fw-bold text-emerald shadow-sm" data-bs-toggle="modal" data-bs-target="#createTimeLogModal" style="color: #059669;">
                <i class="bi bi-plus-circle-fill me-1.5 fs-6"></i> Log Work Hours
            </button>
        </div>
    </div>
</div>

<!-- Image-Style Soft Pastel KPI Cards (4 Cards in 1 Row) -->
<div class="row g-3 mb-4">
    <!-- Card 1: Total Hours (Soft Emerald) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-emerald">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-clock-history me-1"></i> Total Work
                    </span>
                    <span class="ui8-pill-val" style="color: #059669;">
                        {{ number_format($stats['total_hours'], 1) }} hrs
                    </span>
                </div>
                <h4 class="ui8-card-title">Total Logged Hours</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Cumulative Engineering Output
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-success shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-stopwatch-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Hours</span>
                    <span class="ui8-tag-chip">#Billable</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Total Logs (Soft Sky Blue) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-indigo">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-journal-text me-1"></i> Entries
                    </span>
                    <span class="ui8-pill-val" style="color: #0284C7;">
                        {{ $stats['total_logs'] }} Entries
                    </span>
                </div>
                <h4 class="ui8-card-title">Timesheet Entries</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Logged Activity Sheets
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-info shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-card-checklist"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Entries</span>
                    <span class="ui8-tag-chip">#Timesheets</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Active Loggers (Soft Purple) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-purple">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-people me-1"></i> Contributors
                    </span>
                    <span class="ui8-pill-val" style="color: #7C3AED;">
                        {{ $stats['active_loggers'] }} Staff
                    </span>
                </div>
                <h4 class="ui8-card-title">Active Contributors</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Logging Engineers
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-purple shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800; color: #7C3AED;">
                        <i class="bi bi-people-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Engineers</span>
                    <span class="ui8-tag-chip">#Contributors</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Audit Status (Soft Amber) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-amber">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-shield-check me-1"></i> Verified
                    </span>
                    <span class="ui8-pill-val" style="color: #D97706;">
                        Approved
                    </span>
                </div>
                <h4 class="ui8-card-title">Audit Verification</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Verified Work Hours
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-warning shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-shield-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Verified</span>
                    <span class="ui8-tag-chip">#Approved</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Timelogs Table -->
<div class="directory-card">
    <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light bg-opacity-50">
        <div class="fs-8 text-muted fw-bold">
            Showing <strong class="text-dark">{{ $timelogs->firstItem() ?? 0 }} - {{ $timelogs->lastItem() ?? 0 }}</strong> of <strong class="text-dark">{{ $timelogs->total() }}</strong> Timesheet Entries
        </div>
        <span class="badge bg-success bg-opacity-10 text-success px-3 py-1.5 rounded-pill fs-8 fw-bold">
            <i class="bi bi-stopwatch me-1"></i> Engineering Time Roster
        </span>
    </div>

    <div class="table-responsive">
        <table class="table table-directory align-middle mb-0 fs-7">
            <thead>
                <tr>
                    <th>EMPLOYEE ENGINEER</th>
                    <th>PROJECT & WORK TASK</th>
                    <th>HOURS LOGGED</th>
                    <th>DATE</th>
                    <th>ACTIVITY NOTE</th>
                </tr>
            </thead>
            <tbody>
                @forelse($timelogs as $tl)
                    <tr>
                        <td>
                            <div class="fw-bold text-dark fs-7">{{ $tl->employee?->full_name }}</div>
                            <div class="fs-8 text-muted">{{ $tl->employee?->department?->name }}</div>
                        </td>
                        <td>
                            <div class="fw-bold text-dark fs-8">{{ $tl->task?->title }}</div>
                            <div class="fs-8 text-indigo" style="color: #4F46E5;">{{ $tl->task?->project?->name }}</div>
                        </td>
                        <td class="fw-extrabold text-success fs-7 font-monospace" style="color: #059669;">
                            +{{ number_format($tl->hours, 1) }} hrs
                        </td>
                        <td class="fw-bold text-dark fs-8 font-monospace">
                            {{ $tl->date->format('M d, Y') }}
                        </td>
                        <td>
                            <div class="fs-8 text-secondary" style="max-width: 320px;" title="{{ $tl->note }}">
                                {{ $tl->note ?? 'Standard engineering work log entry' }}
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted fs-7">
                            <i class="bi bi-stopwatch fs-2 d-block mb-2 text-slate-300"></i>
                            <div class="fw-bold text-dark">No work hours logged</div>
                            <p class="fs-8 text-muted mb-3">Click "Log Work Hours" to record engineering timesheets.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($timelogs->hasPages())
        <div class="p-3 border-top bg-light d-flex justify-content-between align-items-center">
            <div class="fs-8 text-muted">Showing {{ $timelogs->firstItem() }} to {{ $timelogs->lastItem() }} of {{ $timelogs->total() }} entries</div>
            <div>{{ $timelogs->links() }}</div>
        </div>
    @endif
</div>

<!-- Create TimeLog Modal -->
<div class="modal fade" id="createTimeLogModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom px-4 py-3">
                <h5 class="modal-title fw-bold fs-6 text-dark">Log Project Work Hours</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('projects.timelogs.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Project Work Task <span class="text-danger">*</span></label>
                        <select name="task_id" class="form-select rounded-3 fs-8" required>
                            @foreach($tasks as $tsk)
                                <option value="{{ $tsk->id }}">{{ $tsk->project?->name }} ➔ {{ $tsk->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Employee Engineer <span class="text-danger">*</span></label>
                        <select name="employee_id" class="form-select rounded-3 fs-8" required>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->full_name }} ({{ $emp->employee_code }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Hours Logged <span class="text-danger">*</span></label>
                            <input type="number" step="0.5" min="0.5" max="24" name="hours" class="form-control rounded-3 fs-8" value="8.0" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Work Date <span class="text-danger">*</span></label>
                            <input type="date" name="date" class="form-control rounded-3 fs-8" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Activity Note / Summary</label>
                        <textarea name="note" class="form-control rounded-3 fs-8" rows="3" placeholder="Describe engineering work completed during these hours..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4 fs-8 fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-emerald rounded-pill px-4 fs-8 fw-bold text-white" style="background: #059669; border: none;">Save Time Log</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
