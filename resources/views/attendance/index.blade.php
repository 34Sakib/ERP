@extends('layouts.app')

@push('styles')
<style>
    @keyframes gradientMesh {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .attendance-hero {
        background: linear-gradient(-45deg, #1E1B4B, #312E81, #4338CA, #6366F1);
        background-size: 300% 300%;
        animation: gradientMesh 12s ease infinite, fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        border-radius: 24px;
        padding: 2.25rem 2.5rem;
        color: #ffffff;
        margin-bottom: 1.75rem;
        box-shadow: 0 20px 45px rgba(30, 27, 75, 0.3);
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

    .card-pastel-purple {
        background: linear-gradient(135deg, #F3E8FF 0%, #EDE9FE 100%);
        border-color: #DDD6FE;
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

    /* Dark Mode Overrides for Pastel Cards */
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
        box-shadow: inset 3px 0 0 #4F46E5;
    }

    .table-directory tbody td {
        padding: 1rem 1.25rem;
        vertical-align: middle;
    }

    .status-badge-pill {
        font-size: 0.74rem;
        font-weight: 800;
        padding: 0.35rem 0.85rem;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        letter-spacing: 0.01em;
    }

    .status-badge-pill.present {
        background: #DCFCE7;
        color: #15803D;
        border: 1px solid #BBF7D0;
    }

    .status-badge-pill.late {
        background: #FEF3C7;
        color: #B45309;
        border: 1px solid #FDE68A;
    }

    .status-badge-pill.absent {
        background: #FEE2E2;
        color: #B91C1C;
        border: 1px solid #FECDD3;
    }

    .status-badge-pill.half_day {
        background: #E0F2FE;
        color: #0369A1;
        border: 1px solid #BAE6FD;
    }

    .status-badge-pill.on_leave {
        background: #F3E8FF;
        color: #7C3AED;
        border: 1px solid #DDD6FE;
    }

    .pulsing-dot {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #22C55E;
        animation: pulse 1.5s ease-in-out infinite;
    }

    @keyframes pulse {
        0% {
            opacity: 1;
            transform: scale(1);
        }

        50% {
            opacity: 0.5;
            transform: scale(0.8);
        }

        100% {
            opacity: 1;
            transform: scale(1);
        }
    }

    .fs-7 {
        font-size: 0.9rem;
    }

    .fs-8 {
        font-size: 0.8rem;
    }

    .fw-extrabold {
        font-weight: 800;
    }
</style>
@endpush

@section('content')
<!-- Attendance Hero Banner -->
<div class="attendance-hero">
    <div class="row align-items-center g-3">
        <div class="col-12 col-md-7">
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge rounded-pill bg-white bg-opacity-20 text-white px-2.5 py-1" style="font-size: 0.75rem;">
                    <i class="bi bi-clock-history me-1"></i> Daily Operations
                </span>
                <span style="font-size: 0.8rem; color: rgba(255,255,255,0.5);">• Live Workforce Clock Logs</span>
            </div>
            <h3 class="mb-1 fw-extrabold text-white" style="letter-spacing: -0.02em;">
                Daily Attendance Operations
            </h3>
            <p class="mb-0 text-white-50" style="font-size: 0.9rem;">
                Real-time workforce presence, shift clocking logs, and manual attendance override controls.
            </p>
        </div>
        <div class="col-12 col-md-5 text-md-end">
            <button class="btn btn-light rounded-pill px-4 py-2 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#manualAttendanceModal" style="color: #4F46E5; transition: transform 0.2s ease; font-size: 0.9rem;">
                <i class="bi bi-plus-circle-fill me-1.5"></i> Log Manual Attendance
            </button>
        </div>
    </div>
</div>

<!-- Daily KPI Summary Cards -->
<div class="row g-3 mb-4">
    <!-- Card 1: Present On-Time -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-emerald">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-calendar-check me-1"></i> Today's Presence
                    </span>
                    <span class="ui8-pill-val" style="color: #059669;">
                        {{ $stats['total_present'] ?? 0 }} Present
                    </span>
                </div>
                <h4 class="ui8-card-title">Present On-Time</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Full Attendance Rate
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-success shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-check-circle-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#LiveSync</span>
                    <span class="ui8-tag-chip">#OnTime</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Late Arrivals -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-amber">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-clock-history me-1"></i> Shift Grace Time
                    </span>
                    <span class="ui8-pill-val" style="color: #D97706;">
                        {{ $stats['total_late'] ?? 0 }} Late
                    </span>
                </div>
                <h4 class="ui8-card-title">Late Arrivals</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Grace Period Exceeded
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-warning shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Late</span>
                    <span class="ui8-tag-chip">#Review</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Absences -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-rose">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-exclamation-circle me-1"></i> Unexcused Log
                    </span>
                    <span class="ui8-pill-val" style="color: #E11D48;">
                        {{ $stats['total_absent'] ?? 0 }} Absent
                    </span>
                </div>
                <h4 class="ui8-card-title">Absences</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Unapproved Missed Shifts
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-danger shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-x-circle-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Absent</span>
                    <span class="ui8-tag-chip">#Action</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Approved Leave -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-indigo">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-airplane me-1"></i> Scheduled Leave
                    </span>
                    <span class="ui8-pill-val" style="color: #0284C7;">
                        {{ $stats['total_on_leave'] ?? 0 }} Leave
                    </span>
                </div>
                <h4 class="ui8-card-title">Approved Leave</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Scheduled Off Time
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-info shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-airplane-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Leave</span>
                    <span class="ui8-tag-chip">#Approved</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Analytics & Operations Summary Row -->
<div class="row g-4 mb-4 align-items-stretch">
    <!-- Left Column: Attendance Status Graph -->
    <div class="col-12 col-lg-5 col-xl-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white" style="border: 1px solid #EFEFF7 !important;">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    <h6 class="fw-extrabold text-dark mb-0" style="font-size: 0.9rem; letter-spacing: -0.01em;">
                        Attendance Status Graph
                    </h6>
                    <span class="fs-8 text-muted">Daily distribution breakdown</span>
                </div>
                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2.5 py-1 fs-8 fw-bold">
                    <span class="pulsing-dot me-1"></span> Live Data
                </span>
            </div>

            <!-- Donut Chart Canvas Container -->
            <div class="d-flex justify-content-center align-items-center py-2" style="min-height: 230px;">
                <div id="attendanceStatusDonutChart" style="width: 100%; max-width: 280px;"></div>
            </div>

            <!-- Colors Legend List -->
            <div class="pt-3 border-top mt-auto">
                <div class="fs-7 fw-extrabold mb-2.5" style="color: #1E1B4B;">Colors</div>
                <div class="row g-2">
                    <div class="col-6">
                        <div class="d-flex align-items-center gap-2.5 fs-8 text-dark fw-bold">
                            <span style="width: 14px; height: 14px; background: #FF9F9F; border-radius: 4px; display: inline-block;"></span>
                            <span>Late</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center gap-2.5 fs-8 text-dark fw-bold">
                            <span style="width: 14px; height: 14px; background: #16C760; border-radius: 4px; display: inline-block;"></span>
                            <span>On-time</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center gap-2.5 fs-8 text-dark fw-bold">
                            <span style="width: 14px; height: 14px; background: #4F86F7; border-radius: 4px; display: inline-block;"></span>
                            <span>Home Office</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center gap-2.5 fs-8 text-dark fw-bold">
                            <span style="width: 14px; height: 14px; background: #A855F7; border-radius: 4px; display: inline-block;"></span>
                            <span>Half Office</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center gap-2.5 fs-8 text-dark fw-bold">
                            <span style="width: 14px; height: 14px; background: #54C5F8; border-radius: 4px; display: inline-block;"></span>
                            <span>Leave</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center gap-2.5 fs-8 text-dark fw-bold">
                            <span style="width: 14px; height: 14px; background: #F43F5E; border-radius: 4px; display: inline-block;"></span>
                            <span>Absent</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Operations Overview & Policy Panel -->
    <div class="col-12 col-lg-7 col-xl-8">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white" style="border: 1px solid #EFEFF7 !important;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h6 class="fw-extrabold text-dark mb-0" style="font-size: 0.9rem;">Shift Operations & Governance</h6>
                    <span class="fs-8 text-muted">Real-time attendance policy enforcement</span>
                </div>
                <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary border border-primary-subtle px-3 py-1 fs-8 fw-bold">
                    <i class="bi bi-shield-check me-1"></i> Standard Shift Active
                </span>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-12 col-md-4">
                    <div class="p-3 rounded-4 bg-light border text-center">
                        <div class="fs-8 text-muted fw-semibold mb-1">Shift Hours</div>
                        <div class="fs-7 fw-extrabold text-dark">09:00 AM - 06:00 PM</div>
                        <div class="fs-8 text-muted mt-1">Standard Workday</div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="p-3 rounded-4 bg-light border text-center">
                        <div class="fs-8 text-muted fw-semibold mb-1">Grace Period</div>
                        <div class="fs-7 fw-extrabold text-warning">15 Minutes</div>
                        <div class="fs-8 text-muted mt-1">Up to 09:15 AM</div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="p-3 rounded-4 bg-light border text-center">
                        <div class="fs-8 text-muted fw-semibold mb-1">On-Time Target</div>
                        <div class="fs-7 fw-extrabold text-success">95.0%</div>
                        <div class="fs-8 text-muted mt-1">SLA Benchmark</div>
                    </div>
                </div>
            </div>

            <div class="bg-light rounded-4 p-3.5 border mt-auto">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle p-2.5 bg-primary bg-opacity-10 text-primary fs-4 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-info-circle-fill"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-bold fs-7 text-dark">Automatic Late Arrival Calculation</div>
                        <div class="fs-8 text-muted">Any clock-in logged after 09:15 AM is automatically tagged as <strong>Late Arrival</strong> with formatted duration (hours & minutes) in the table directory below.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search & Filter Controls Bar -->
<div class="directory-card p-3.5 mb-4">
    <form method="GET" action="{{ route('attendance.index') }}" id="attendanceFilterForm">
        <div class="row g-2.5 align-items-center">
            <div class="col-12 col-md-3">
                <div class="position-relative">
                    <i class="bi bi-calendar-event position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    <input type="date" name="date" class="form-control rounded-pill ps-5 fs-8 fw-semibold" value="{{ $date ?? date('Y-m-d') }}" onchange="this.form.submit()">
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="position-relative">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    <input type="text" name="search" class="form-control rounded-pill ps-5 fs-8" value="{{ request('search') }}" placeholder="Search employee name or code...">
                </div>
            </div>
            <div class="col-6 col-md-3">
                <select name="status" class="form-select rounded-pill fs-8 fw-semibold" onchange="this.form.submit()">
                    <option value="">All Presence Statuses</option>
                    <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>Present On-Time</option>
                    <option value="late" {{ request('status') == 'late' ? 'selected' : '' }}>Late Arrival</option>
                    <option value="half_day" {{ request('status') == 'half_day' ? 'selected' : '' }}>Half Day</option>
                    <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>Absent</option>
                    <option value="on_leave" {{ request('status') == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                </select>
            </div>
            <div class="col-6 col-md-2 text-end">
                <a href="{{ route('attendance.index') }}" class="btn btn-light rounded-pill px-3 fs-8 fw-bold text-muted border">
                    <i class="bi bi-arrow-counterclockwise me-1"></i> Today
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Full-Width Attendance Directory Datatable -->
<div class="directory-card mb-4">
    <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light bg-opacity-50">
        <div class="fs-8 text-muted fw-bold">
            Showing <strong class="text-dark">{{ $attendances->count() }}</strong> Daily Attendance Logs for <strong class="text-primary">{{ \Carbon\Carbon::parse($date ?? date('Y-m-d'))->format('l, F j, Y') }}</strong>
        </div>
        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1.5 rounded-pill fs-8 fw-bold">
            <i class="bi bi-broadcast me-1"></i> Live Logs
        </span>
    </div>

    <div class="table-responsive">
        <table class="table table-directory align-middle mb-0" style="font-size: 0.9rem;">
            <thead>
                <tr>
                    <th>EMPLOYEE PROFILE</th>
                    <th>DEPARTMENT & ROLE</th>
                    <th>CHECK-IN</th>
                    <th>CHECK-OUT</th>
                    <th>WORKED HOURS</th>
                    <th>STATUS</th>
                    <th class="text-end pe-3">ACTION</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $att)
                    @if(!$att->employee)
                        @continue
                    @endif
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2.5">
                                <img src="{{ $att->employee->profile_photo ? asset($att->employee->profile_photo) : 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80' }}"
                                    class="rounded-circle shadow-sm" style="width: 38px; height: 38px; object-fit: cover;">
                                <div>
                                    <div class="fw-bold text-dark" style="font-size: 0.9rem;">{{ $att->employee->full_name }}</div>
                                    <div class="fs-8 text-muted"><code class="text-primary">{{ $att->employee->employee_code }}</code></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold text-dark fs-8">{{ $att->employee->department?->name ?? 'General' }}</div>
                            <div class="fs-8 text-secondary">{{ $att->employee->designation?->name ?? 'Staff' }}</div>
                        </td>
                    <td>
                        @if($att->check_in)
                        <div class="fw-bold text-dark fs-8 font-monospace">
                            <i class="bi bi-box-arrow-in-right text-success me-1"></i>{{ $att->check_in->format('h:i A') }}
                        </div>
                        <div class="fs-8 text-muted">Via {{ ucfirst($att->check_in_source) }}</div>
                        @else
                        <span class="text-muted fs-8">--:--</span>
                        @endif
                    </td>
                    <td>
                        @if($att->check_out)
                        <div class="fw-bold text-dark fs-8 font-monospace">
                            <i class="bi bi-box-arrow-right text-danger me-1"></i>{{ $att->check_out->format('h:i A') }}
                        </div>
                        @else
                        <span class="badge bg-light text-secondary border px-2 py-0.5 fs-8">In Progress</span>
                        @endif
                    </td>
                    <td>
                        @if($att->check_out)
                        <div class="fw-bold text-dark fs-8">
                            {{ round($att->total_worked_minutes / 60, 1) }} hrs
                        </div>
                        <div class="fs-8 text-muted" style="font-size: 0.72rem;">Completed</div>
                        @elseif($att->check_in)
                        <div class="fw-bold text-primary fs-8 font-monospace live-worked-timer"
                            data-checkin="{{ $att->check_in->toIso8601String() }}">
                            <i class="bi bi-stopwatch me-1 text-primary"></i><span class="timer-display">Calculating...</span>
                        </div>
                        <div class="fs-8 text-success" style="font-size: 0.72rem;"><span class="pulsing-dot me-1"></span> Live Active</div>
                        @else
                        <div class="text-muted fs-8">0 hrs</div>
                        @endif
                    </td>
                    <td>
                        @php
                        $isLateArrival = $att->status === 'late'
                        || ($att->late_minutes > 0)
                        || ($att->check_in && \Carbon\Carbon::parse($att->check_in)->format('H:i') > '09:15');
                        @endphp
                        @if($isLateArrival)
                        @php
                        $lateMins = $att->late_minutes;
                        if (!$lateMins && $att->check_in) {
                        $shiftStart = \Carbon\Carbon::parse($att->date->format('Y-m-d') . ' 09:00:00');
                        if ($att->check_in->greaterThan($shiftStart)) {
                        $lateMins = $att->check_in->diffInMinutes($shiftStart);
                        }
                        }
                        $lateHours = floor($lateMins / 60);
                        $remainingMins = $lateMins % 60;
                        $lateTimeStr = $lateHours > 0 ? "{$lateHours}h {$remainingMins}m" : "{$remainingMins}m";
                        @endphp
                        <span class="status-badge-pill late"><i class="bi bi-clock-history"></i> Late Arrival ({{ $lateTimeStr }})</span>
                        @elseif($att->status === 'present')
                        <span class="status-badge-pill present"><i class="bi bi-check-circle-fill"></i> Present</span>
                        @elseif($att->status === 'absent')
                        <span class="status-badge-pill absent"><i class="bi bi-x-circle-fill"></i> Absent</span>
                        @elseif($att->status === 'half_day')
                        <span class="status-badge-pill half_day"><i class="bi bi-pie-chart-fill"></i> Half Day</span>
                        @else
                        <span class="status-badge-pill on_leave"><i class="bi bi-airplane-fill"></i> On Leave</span>
                        @endif
                    </td>
                    <td class="text-end pe-3">
                        <button class="btn btn-sm btn-light rounded-circle text-primary"
                            onclick="editAttendanceModal('{{ $att->employee_id }}', '{{ $att->date->format('Y-m-d') }}', '{{ $att->check_in ? $att->check_in->format('H:i') : '' }}', '{{ $att->check_out ? $att->check_out->format('H:i') : '' }}', '{{ $att->status }}')"
                            title="Edit Attendance Log">
                            <i class="bi bi-pencil-fill fs-8"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted fs-7">
                        <i class="bi bi-clock fs-2 d-block mb-2 text-slate-300"></i>
                        <div class="fw-bold text-dark">No attendance logs registered for {{ \Carbon\Carbon::parse($date ?? date('Y-m-d'))->format('M d, Y') }}</div>
                        <p class="fs-8 text-muted mb-3">Log a manual attendance record or choose another date.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($attendances->hasPages())
    <div class="p-3 border-top bg-light d-flex justify-content-between align-items-center">
        <div class="fs-8 text-muted">Showing {{ $attendances->firstItem() }} to {{ $attendances->lastItem() }} of {{ $attendances->total() }} entries</div>
        <div>{{ $attendances->links() }}</div>
    </div>
    @endif
</div>

<!-- Manual Attendance Entry / Edit Modal -->
<div class="modal fade" id="manualAttendanceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom px-4 py-3">
                <h5 class="modal-title fw-bold fs-6 text-dark" id="modalTitle">Log Manual Attendance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('attendance.store') }}" method="POST" id="manualAttendanceForm">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Employee <span class="text-danger">*</span></label>
                        <select name="employee_id" id="modal_employee_id" class="form-select rounded-3 fs-8" required>
                            <option value="">Select Employee</option>
                            @foreach($employees ?? [] as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->full_name }} ({{ $emp->employee_code }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Date <span class="text-danger">*</span></label>
                        <input type="date" name="date" id="modal_date" class="form-control rounded-3 fs-8" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Check-In Time</label>
                            <input type="time" name="check_in" id="modal_check_in" class="form-control rounded-3 fs-8" value="09:00">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Check-Out Time</label>
                            <input type="time" name="check_out" id="modal_check_out" class="form-control rounded-3 fs-8" value="18:00">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Attendance Status <span class="text-danger">*</span></label>
                        <select name="status" id="modal_status" class="form-select rounded-3 fs-8" required>
                            <option value="present" selected>Present On-Time</option>
                            <option value="late">Late Arrival</option>
                            <option value="half_day">Half Day</option>
                            <option value="absent">Absent</option>
                            <option value="on_leave">On Approved Leave</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4 fs-8 fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fs-8 fw-bold" style="background: #4F46E5; border: none;">Save Attendance</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var options = {
            series: {!! json_encode($chartSeries ?? [13.6, 86.4, 0, 0, 0, 0]) !!},
            labels: ['Late', 'On-time', 'Home Office', 'Half Office', 'Leave', 'Absent'],
            chart: {
                type: 'donut',
                height: 250,
                sparkline: {
                    enabled: false
                },
                background: 'transparent'
            },
            colors: ['#FF8A65', '#4DB6AC', '#8B5CF6', '#64B5F6', '#5C6BC0', '#F06292'],
            dataLabels: {
                enabled: true,
                formatter: function(val) {
                    return val > 0 ? val.toFixed(1) + "%" : '';
                },
                style: {
                    fontSize: '11px',
                    fontFamily: 'Inter, sans-serif',
                    fontWeight: '800',
                    colors: ['#ffffff']
                },
                dropShadow: {
                    enabled: false
                }
            },
            legend: {
                show: false
            },
            stroke: {
                width: 2.5,
                colors: ['#ffffff']
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '56%',
                        labels: {
                            show: false
                        }
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val + "% of total logs";
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#attendanceStatusDonutChart"), options);
        chart.render();
    });

    function padZero(num) {
        return num < 10 ? '0' + num : num;
    }

    function updateLiveWorkedHours() {
        var timers = document.querySelectorAll('.live-worked-timer');
        var now = new Date();

        timers.forEach(function(timer) {
            var checkInIso = timer.getAttribute('data-checkin');
            if (!checkInIso) return;

            var checkIn = new Date(checkInIso);
            var diffMs = Math.max(0, now - checkIn);

            var diffSecs = Math.floor(diffMs / 1000);
            var hours = Math.floor(diffSecs / 3600);
            var minutes = Math.floor((diffSecs % 3600) / 60);
            var seconds = diffSecs % 60;

            var displayEl = timer.querySelector('.timer-display');
            if (displayEl) {
                displayEl.textContent = padZero(hours) + ':' + padZero(minutes) + ':' + padZero(seconds);
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function() {
        updateLiveWorkedHours();
        setInterval(updateLiveWorkedHours, 1000);
    });

    function editAttendanceModal(empId, date, checkIn, checkOut, status) {
        document.getElementById('modalTitle').textContent = 'Edit Attendance Record';
        document.getElementById('modal_employee_id').value = empId;
        document.getElementById('modal_date').value = date;
        document.getElementById('modal_check_in').value = checkIn;
        document.getElementById('modal_check_out').value = checkOut;
        document.getElementById('modal_status').value = status;

        var modal = new bootstrap.Modal(document.getElementById('manualAttendanceModal'));
        modal.show();
    }
</script>
@endpush
@endsection