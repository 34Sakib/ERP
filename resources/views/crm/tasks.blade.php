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

    .tasks-hero {
        background: linear-gradient(-45deg, #7C3AED, #6366F1, #4F46E5, #4338CA);
        background-size: 300% 300%;
        animation: gradientMesh 12s ease infinite, fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        border-radius: 24px;
        padding: 2.25rem 2.5rem;
        color: #ffffff;
        margin-bottom: 1.75rem;
        box-shadow: 0 20px 45px rgba(124, 58, 237, 0.3);
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
        box-shadow: inset 3px 0 0 #7C3AED;
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
<div class="tasks-hero">
    <div class="row align-items-center g-3">
        <div class="col-12 col-md-8">
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge rounded-pill bg-white bg-opacity-20 text-white fs-8 px-2.5 py-1">
                    <i class="bi bi-check2-square me-1"></i> Sales Follow-Ups
                </span>
                <span class="fs-8 text-white-50">• {{ $stats['pending_tasks'] }} Pending Follow-Ups</span>
            </div>
            <h3 class="mb-1 fw-extrabold text-white" style="letter-spacing: -0.02em;">
                CRM Follow-Up & Action Tasks
            </h3>
            <p class="mb-0 text-white-50 fs-7">
                Schedule client calls, proposal follow-ups, contract reviews, and meeting tasks.
            </p>
        </div>
        <div class="col-12 col-md-4 text-md-end">
            <button class="btn btn-light rounded-pill px-4 py-2.5 fw-bold text-purple shadow-sm" data-bs-toggle="modal" data-bs-target="#createTaskModal" style="color: #7C3AED;">
                <i class="bi bi-plus-circle-fill me-1.5 fs-6"></i> Add Follow-Up Task
            </button>
        </div>
    </div>
</div>

<!-- Image-Style Soft Pastel KPI Cards (4 Cards in 1 Row) -->
<div class="row g-3 mb-4">
    <!-- Card 1: Pending Tasks (Soft Amber) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-amber">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-clock-history me-1"></i> Action Required
                    </span>
                    <span class="ui8-pill-val" style="color: #D97706;">
                        {{ $stats['pending_tasks'] }} Pending
                    </span>
                </div>
                <h4 class="ui8-card-title">Pending Tasks</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Awaiting Completion
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-warning shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-exclamation-circle-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Pending</span>
                    <span class="ui8-tag-chip">#Action</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Completed Tasks (Soft Emerald) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-emerald">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-check-circle-fill me-1"></i> Closed Tasks
                    </span>
                    <span class="ui8-pill-val" style="color: #059669;">
                        {{ $stats['completed_tasks'] }} Done
                    </span>
                </div>
                <h4 class="ui8-card-title">Completed Tasks</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Successfully Handled
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-success shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-check-circle-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Completed</span>
                    <span class="ui8-tag-chip">#Closed</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Total Tasks (Soft Purple) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-purple">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-card-checklist me-1"></i> All Follow-Ups
                    </span>
                    <span class="ui8-pill-val" style="color: #7C3AED;">
                        {{ $stats['total_tasks'] }} Total
                    </span>
                </div>
                <h4 class="ui8-card-title">Total CRM Tasks</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Scheduled Tasks
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-purple shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800; color: #7C3AED;">
                        <i class="bi bi-collection-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Total</span>
                    <span class="ui8-tag-chip">#FollowUps</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Compliance (Soft Sky Blue) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-indigo">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-shield-check me-1"></i> SLA Tracking
                    </span>
                    <span class="ui8-pill-val" style="color: #0284C7;">
                        100% Tracked
                    </span>
                </div>
                <h4 class="ui8-card-title">SLA Compliance</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Timely Client Outreach
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-info shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-shield-check"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#SLA</span>
                    <span class="ui8-tag-chip">#Outreach</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tasks Table -->
<div class="directory-card">
    <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light bg-opacity-50">
        <div class="fs-8 text-muted fw-bold">
            Showing <strong class="text-dark">{{ $tasks->firstItem() ?? 0 }} - {{ $tasks->lastItem() ?? 0 }}</strong> of <strong class="text-dark">{{ $tasks->total() }}</strong> CRM Follow-Up Tasks
        </div>
        <span class="badge bg-purple bg-opacity-10 text-purple px-3 py-1.5 rounded-pill fs-8 fw-bold" style="background: #F3E8FF; color: #7C3AED;">
            <i class="bi bi-check2-square me-1"></i> Task Schedule
        </span>
    </div>

    <div class="table-responsive">
        <table class="table table-directory align-middle mb-0 fs-7">
            <thead>
                <tr>
                    <th>TASK DESCRIPTION</th>
                    <th>ASSOCIATED DEAL & CLIENT</th>
                    <th>DUE DATE</th>
                    <th>ASSIGNED REPRESENTATIVE</th>
                    <th>STATUS</th>
                    <th class="text-end pe-3">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tasks as $t)
                    <tr>
                        <td>
                            <div class="fw-bold text-dark fs-7">{{ $t->title }}</div>
                        </td>
                        <td>
                            <div class="fw-bold text-dark fs-8">{{ $t->deal?->title ?? 'General Inquiry' }}</div>
                            <div class="fs-8 text-secondary">{{ $t->deal?->lead?->name }}</div>
                        </td>
                        <td class="fw-bold text-dark fs-8 font-monospace">
                            <i class="bi bi-calendar-event me-1 text-primary"></i> {{ $t->due_date->format('M d, Y') }}
                        </td>
                        <td>
                            <div class="fs-8 fw-bold text-dark">{{ $t->assignee?->name ?? 'Sales Exec' }}</div>
                        </td>
                        <td>
                            @if($t->status === 'completed')
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1 rounded-pill fs-8">Completed</span>
                            @else
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2.5 py-1 rounded-pill fs-8">Pending Action</span>
                            @endif
                        </td>
                        <td class="text-end pe-3">
                            <form action="{{ route('crm.tasks.toggle', $t->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $t->status === 'completed' ? 'btn-outline-secondary' : 'btn-success' }} rounded-pill px-3 fs-8 fw-bold">
                                    {{ $t->status === 'completed' ? 'Mark Pending' : 'Complete Task' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted fs-7">
                            <i class="bi bi-check2-square fs-2 d-block mb-2 text-slate-300"></i>
                            <div class="fw-bold text-dark">No follow-up tasks scheduled</div>
                            <p class="fs-8 text-muted mb-3">Click "Add Follow-Up Task" to schedule client outreach tasks.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($tasks->hasPages())
        <div class="p-3 border-top bg-light d-flex justify-content-between align-items-center">
            <div class="fs-8 text-muted">Showing {{ $tasks->firstItem() }} to {{ $tasks->lastItem() }} of {{ $tasks->total() }} entries</div>
            <div>{{ $tasks->links() }}</div>
        </div>
    @endif
</div>

<!-- Create Task Modal -->
<div class="modal fade" id="createTaskModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom px-4 py-3">
                <h5 class="modal-title fw-bold fs-6 text-dark">Add CRM Follow-Up Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('crm.tasks.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Task Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control rounded-3 fs-8" placeholder="e.g. Schedule product demo call with client" required>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Associated Deal</label>
                            <select name="deal_id" class="form-select rounded-3 fs-8">
                                <option value="">Select Deal</option>
                                @foreach($deals as $dl)
                                    <option value="{{ $dl->id }}">{{ $dl->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Due Date <span class="text-danger">*</span></label>
                            <input type="date" name="due_date" class="form-control rounded-3 fs-8" value="{{ date('Y-m-d', strtotime('+3 days')) }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Assigned Sales Representative</label>
                        <select name="assigned_to" class="form-select rounded-3 fs-8">
                            @foreach($users as $u)
                                <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4 fs-8 fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-purple rounded-pill px-4 fs-8 fw-bold text-white" style="background: #7C3AED; border: none;">Save Task</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
