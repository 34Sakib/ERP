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

    .leave-hero {
        background: linear-gradient(-45deg, #059669, #10B981, #0D9488, #047857);
        background-size: 300% 300%;
        animation: gradientMesh 12s ease infinite, fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        border-radius: 24px;
        padding: 2.25rem 2.5rem;
        color: #ffffff;
        margin-bottom: 1.75rem;
        box-shadow: 0 20px 45px rgba(16, 185, 129, 0.3);
        position: relative;
        overflow: hidden;
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

    .card-pastel-rose {
        background: linear-gradient(135deg, #FFF1F2 0%, #FFE4E6 100%);
        border-color: #FECDD3;
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

    /* Dark Mode Overrides */
    [data-bs-theme="dark"] .pastel-ui8-card {
        background: #1F2937 !important;
        border-color: #374151 !important;
    }
    [data-bs-theme="dark"] .ui8-card-title {
        color: #F8FAFC !important;
    }
    [data-bs-theme="dark"] .ui8-pill-val,
    [data-bs-theme="dark"] .ui8-tag-chip {
        background: #111827 !important;
        color: #F8FAFC !important;
        border-color: #374151 !important;
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
</style>
@endpush

@section('content')
<!-- Leave Hero Header -->
<div class="leave-hero">
    <div class="row align-items-center g-3">
        <div class="col-12 col-md-8">
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge rounded-pill bg-white bg-opacity-20 text-white fs-8 px-2.5 py-1">
                    <i class="bi bi-airplane-fill me-1"></i> Personal Leave Portal
                </span>
                <span class="fs-8 text-white-50">• {{ $employee?->full_name ?? 'Staff Member' }}</span>
            </div>
            <h3 class="mb-1 fw-extrabold text-white" style="letter-spacing: -0.02em;">
                My Leave & Quota Portal
            </h3>
            <p class="mb-0 text-white-50 fs-7">
                Track annual leave balances, submit vacation requests, and monitor approval status.
            </p>
        </div>
        <div class="col-12 col-md-4 text-md-end">
            <a href="{{ route('leave.apply') }}" class="btn btn-light rounded-pill px-4 py-2.5 fw-bold text-emerald shadow-sm" style="color: #059669;">
                <i class="bi bi-plus-circle-fill me-1.5 fs-6"></i> Apply For Leave
            </a>
        </div>
    </div>
</div>

<!-- Image-Style Soft Pastel KPI Cards -->
<div class="row g-3 mb-4">
    <!-- Card 1: Total Allocated (Soft Emerald) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-emerald">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-calendar-event me-1"></i> Annual Quota
                    </span>
                    <span class="ui8-pill-val" style="color: #059669;">
                        {{ $stats['total_allocated'] }} Days
                    </span>
                </div>
                <h4 class="ui8-card-title">Total Allocated</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Yearly Leave Allocation
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-success shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-check-circle-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Quota</span>
                    <span class="ui8-tag-chip">#Annual</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Remaining Balance (Soft Sky Blue) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-indigo">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-wallet2 me-1"></i> Available Balance
                    </span>
                    <span class="ui8-pill-val" style="color: #0284C7;">
                        {{ $stats['total_remaining'] }} Days
                    </span>
                </div>
                <h4 class="ui8-card-title">Remaining Balance</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Available Days to Take
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-info shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-pie-chart-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Available</span>
                    <span class="ui8-tag-chip">#Balance</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Days Used (Soft Amber) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-amber">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-clock-history me-1"></i> Taken Leave
                    </span>
                    <span class="ui8-pill-val" style="color: #D97706;">
                        {{ $stats['total_used'] }} Days
                    </span>
                </div>
                <h4 class="ui8-card-title">Used Days</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Approved Taken Days
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-warning shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-calendar-minus-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Taken</span>
                    <span class="ui8-tag-chip">#Approved</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Pending Requests (Soft Rose) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-rose">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-hourglass-split me-1"></i> Review Queue
                    </span>
                    <span class="ui8-pill-val" style="color: #E11D48;">
                        {{ $stats['pending_count'] }} Pending
                    </span>
                </div>
                <h4 class="ui8-card-title">Pending Approval</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Requests Awaiting Review
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-danger shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-clock"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Pending</span>
                    <span class="ui8-tag-chip">#Review</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- My Leave Applications History Table -->
<div class="directory-card">
    <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light bg-opacity-50">
        <div class="fs-8 text-muted fw-bold">
            Personal Leave Application History (<strong class="text-dark">{{ date('Y') }}</strong>)
        </div>
        <span class="badge bg-success bg-opacity-10 text-success px-3 py-1.5 rounded-pill fs-8 fw-bold">
            <i class="bi bi-journal-text me-1"></i> Live Records
        </span>
    </div>

    <div class="table-responsive">
        <table class="table table-directory align-middle mb-0 fs-7">
            <thead>
                <tr>
                    <th>LEAVE TYPE</th>
                    <th>START DATE</th>
                    <th>END DATE</th>
                    <th>DURATION</th>
                    <th>REASON</th>
                    <th>STATUS</th>
                    <th class="text-end pe-3">ACTION</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $app)
                    <tr>
                        <td>
                            <span class="badge rounded-pill px-3 py-1 fs-8 fw-bold" style="background: {{ $app->leaveType?->color ?? '#6366F1' }}18; color: {{ $app->leaveType?->color ?? '#6366F1' }}; border: 1px solid {{ $app->leaveType?->color ?? '#6366F1' }}40;">
                                <i class="bi bi-tag-fill me-1"></i> {{ $app->leaveType?->name ?? 'General Leave' }}
                            </span>
                        </td>
                        <td class="fw-bold text-dark fs-8 font-monospace">{{ $app->start_date->format('M d, Y') }}</td>
                        <td class="fw-bold text-dark fs-8 font-monospace">{{ $app->end_date->format('M d, Y') }}</td>
                        <td>
                            <span class="badge bg-light text-dark border px-2.5 py-1 fs-8 fw-bold">
                                {{ $app->days_count }} {{ Str::plural('Day', $app->days_count) }}
                            </span>
                        </td>
                        <td>
                            <div class="fs-8 text-dark text-truncate" style="max-width: 240px;" title="{{ $app->reason }}">
                                {{ $app->reason }}
                            </div>
                        </td>
                        <td>
                            @if($app->status === 'pending')
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2.5 py-1 rounded-pill fs-8">Pending Approval</span>
                            @elseif($app->status === 'approved')
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1 rounded-pill fs-8">Approved</span>
                            @elseif($app->status === 'rejected')
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2.5 py-1 rounded-pill fs-8">Rejected</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary px-2.5 py-1 rounded-pill fs-8">Cancelled</span>
                            @endif
                        </td>
                        <td class="text-end pe-3">
                            @if($app->status === 'pending')
                                <form action="{{ route('leave.cancel', $app->id) }}" method="POST" onsubmit="return confirm('Cancel this leave application?')">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 fs-8 fw-bold">
                                        Cancel
                                    </button>
                                </form>
                            @else
                                <span class="text-muted fs-8">--</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted fs-7">
                            <i class="bi bi-airplane fs-2 d-block mb-2 text-slate-300"></i>
                            <div class="fw-bold text-dark">No leave applications submitted yet</div>
                            <p class="fs-8 text-muted mb-3">Click "Apply For Leave" to submit a new vacation or leave request.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
