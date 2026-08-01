@extends('layouts.app')

@push('styles')
<style>
    .my-hero {
        background: linear-gradient(135deg, #4338CA 0%, #6366F1 50%, #7C3AED 100%);
        border-radius: 20px;
        padding: 1.75rem 2rem;
        color: #ffffff;
        margin-bottom: 1.75rem;
        box-shadow: 0 12px 30px rgba(99, 102, 241, 0.2);
    }

    .punch-terminal-card {
        background: linear-gradient(145deg, #1E1B4B 0%, #312E81 100%);
        border-radius: 22px;
        padding: 1.75rem;
        color: #ffffff;
        box-shadow: 0 15px 35px rgba(30, 27, 75, 0.3);
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .clock-display {
        font-size: 2.3rem;
        font-weight: 800;
        font-family: monospace, monospace;
        letter-spacing: 0.05em;
        color: #38BDF8;
        text-shadow: 0 0 18px rgba(56, 189, 248, 0.5);
    }

    .btn-punch-action {
        background: linear-gradient(135deg, #38BDF8 0%, #2563EB 100%);
        color: #ffffff;
        border: none;
        border-radius: 14px;
        padding: 0.9rem 1.5rem;
        font-weight: 800;
        font-size: 1rem;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;
        box-shadow: 0 8px 25px rgba(56, 189, 248, 0.35);
        transition: all 0.25s ease;
    }

    .btn-punch-action.checked-in {
        background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
        box-shadow: 0 8px 25px rgba(239, 68, 68, 0.35);
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

    .status-badge-pill {
        font-size: 0.74rem;
        font-weight: 800;
        padding: 0.3rem 0.75rem;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }

    .status-badge-pill.present { background: #DCFCE7; color: #15803D; border: 1px solid #BBF7D0; }
    .status-badge-pill.late { background: #FEF3C7; color: #B45309; border: 1px solid #FDE68A; }
    .status-badge-pill.absent { background: #FEE2E2; color: #B91C1C; border: 1px solid #FECDD3; }
    .status-badge-pill.half_day { background: #E0F2FE; color: #0369A1; border: 1px solid #BAE6FD; }

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
</style>
@endpush

@section('content')
<!-- Header -->
<div class="my-hero">
    <div class="row align-items-center g-3">
        <div class="col-12 col-md-8">
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge rounded-pill bg-white bg-opacity-20 text-white fs-8 px-2.5 py-1">
                    <i class="bi bi-person-badge-fill me-1"></i> Personal Workspace
                </span>
                <span class="fs-8 text-white-50">• {{ $employee?->full_name ?? 'Staff Member' }}</span>
            </div>
            <h3 class="mb-1 fw-extrabold text-white" style="letter-spacing: -0.02em;">
                My Attendance & Shift Portal
            </h3>
            <p class="mb-0 text-white-50 fs-7">
                Real-time shift punch terminal, monthly attendance history, and overtime tracking.
            </p>
        </div>
        <div class="col-12 col-md-4 text-md-end">
            <a href="{{ route('attendance.regularizations.index') }}" class="btn btn-light rounded-pill px-3.5 py-2 fw-bold text-dark fs-8 shadow-sm">
                <i class="bi bi-shield-plus me-1 text-primary"></i> Request Regularization
            </a>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Live Shift Terminal Widget -->
    <div class="col-12 col-lg-5">
        <div class="punch-terminal-card">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-clock-history fs-5 text-info"></i>
                        <span class="fw-bold fs-7 text-white-50 uppercase tracking-wider">Live Shift Terminal</span>
                    </div>
                    <span class="badge bg-white bg-opacity-20 text-white rounded-pill px-3 py-1 fs-8 fw-bold">
                        {{ date('D, M d, Y') }}
                    </span>
                </div>

                <div class="text-center py-2 mb-3">
                    <div class="clock-display" id="myLiveClock">00:00:00 AM</div>
                    <div class="fs-8 text-white-50 mt-1">Assigned Shift: <strong class="text-white">09:00 AM - 06:00 PM</strong></div>
                </div>

                <div class="bg-black bg-opacity-25 rounded-3 p-3 mb-3 border border-white border-opacity-10">
                    <div class="d-flex justify-content-between align-items-center mb-2 fs-8 text-white-50">
                        <span>Terminal Status</span>
                        @if($todayAttendance && $todayAttendance->check_in && !$todayAttendance->check_out)
                            <span id="punchBadge" class="badge bg-success text-white px-2.5 py-1 rounded-pill">Checked In ({{ $todayAttendance->check_in->format('h:i A') }})</span>
                        @elseif($todayAttendance && $todayAttendance->check_out)
                            <span id="punchBadge" class="badge bg-secondary text-white px-2.5 py-1 rounded-pill">Shift Completed</span>
                        @else
                            <span id="punchBadge" class="badge bg-info text-white px-2.5 py-1 rounded-pill">Ready to Punch</span>
                        @endif
                    </div>
                    <div class="progress" style="height: 6px; background: rgba(255,255,255,0.15); border-radius: 999px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: {{ $todayAttendance && $todayAttendance->check_in ? '65%' : '0%' }}; border-radius: 999px;"></div>
                    </div>
                </div>
            </div>

            <button id="btnPunchAction" class="btn-punch-action {{ $todayAttendance && $todayAttendance->check_in && !$todayAttendance->check_out ? 'checked-in' : '' }}" onclick="submitLivePunch()">
                <i class="bi bi-box-arrow-in-right fs-5"></i>
                <span id="btnPunchText">{{ $todayAttendance && $todayAttendance->check_in && !$todayAttendance->check_out ? 'Check Out Now' : 'Check In Now' }}</span>
            </button>
        </div>
    </div>

    <!-- Monthly Summary KPIs (Refined Image-Style Pastel Cards) -->
    <div class="col-12 col-lg-7">
        <div class="row g-3">
            <!-- Card 1: Present Days (Soft Emerald) -->
            <div class="col-6">
                <div class="pastel-ui8-card card-pastel-emerald">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fs-8 text-secondary fw-semibold">
                                <i class="bi bi-calendar-check me-1"></i> Monthly Target
                            </span>
                            <span class="ui8-pill-val" style="color: #059669;">
                                {{ $stats['present'] }} Days
                            </span>
                        </div>
                        <h4 class="ui8-card-title">Present Days</h4>
                        <div class="ui8-card-sub mb-3">
                            <i class="bi bi-building me-1 opacity-75"></i> Full Attendance Days
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center pt-2">
                        <div class="d-flex align-items-center">
                            <span class="badge rounded-circle bg-white text-success shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                                <i class="bi bi-check-circle-fill"></i>
                            </span>
                        </div>
                        <div class="d-flex gap-1">
                            <span class="ui8-tag-chip">#OnTime</span>
                            <span class="ui8-tag-chip">#Verified</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Late Arrivals (Soft Amber) -->
            <div class="col-6">
                <div class="pastel-ui8-card card-pastel-amber">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fs-8 text-secondary fw-semibold">
                                <i class="bi bi-clock-history me-1"></i> Grace Time
                            </span>
                            <span class="ui8-pill-val" style="color: #D97706;">
                                {{ $stats['late'] }} Late
                            </span>
                        </div>
                        <h4 class="ui8-card-title">Late Arrivals</h4>
                        <div class="ui8-card-sub mb-3">
                            <i class="bi bi-building me-1 opacity-75"></i> Exceeded Grace Period
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
                            <span class="ui8-tag-chip">#Grace</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Absences (Soft Rose) -->
            <div class="col-6">
                <div class="pastel-ui8-card card-pastel-rose">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fs-8 text-secondary fw-semibold">
                                <i class="bi bi-exclamation-circle me-1"></i> Unexcused
                            </span>
                            <span class="ui8-pill-val" style="color: #E11D48;">
                                {{ $stats['absent'] }} Days
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
                            <span class="ui8-tag-chip">#Absence</span>
                            <span class="ui8-tag-chip">#Deduction</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 4: Worked Hours (Soft Sky Blue) -->
            <div class="col-6">
                <div class="pastel-ui8-card card-pastel-indigo">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fs-8 text-secondary fw-semibold">
                                <i class="bi bi-stopwatch me-1"></i> Duration Log
                            </span>
                            <span class="ui8-pill-val" style="color: #0284C7;">
                                {{ $stats['total_worked_hours'] }}h Worked
                            </span>
                        </div>
                        <h4 class="ui8-card-title">Total Worked</h4>
                        <div class="ui8-card-sub mb-3">
                            <i class="bi bi-building me-1 opacity-75"></i> Total Shift Hours
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center pt-2">
                        <div class="d-flex align-items-center">
                            <span class="badge rounded-circle bg-white text-info shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                                <i class="bi bi-clock-fill"></i>
                            </span>
                        </div>
                        <div class="d-flex gap-1">
                            <span class="ui8-tag-chip">#Hours</span>
                            <span class="ui8-tag-chip">#Total</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Personal Attendance Log History Table -->
<div class="card rounded-4 border-0 shadow-sm overflow-hidden">
    <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light bg-opacity-50">
        <div class="fs-8 text-muted fw-bold">
            Monthly Attendance History (<strong class="text-dark">{{ date('F Y') }}</strong>)
        </div>
        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1.5 rounded-pill fs-8 fw-bold">
            <i class="bi bi-journal-text me-1"></i> Verified Logs
        </span>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 fs-7">
            <thead class="table-light fs-8 text-muted">
                <tr>
                    <th>DATE</th>
                    <th>CHECK-IN TIME</th>
                    <th>CHECK-OUT TIME</th>
                    <th>WORKED DURATION</th>
                    <th>STATUS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $att)
                    <tr>
                        <td class="fw-bold text-dark fs-8">{{ $att->date->format('D, M d, Y') }}</td>
                        <td>
                            @if($att->check_in)
                                <span class="fw-bold text-dark fs-8 font-monospace"><i class="bi bi-box-arrow-in-right text-success me-1"></i>{{ $att->check_in->format('h:i A') }}</span>
                            @else
                                <span class="text-muted fs-8">--:--</span>
                            @endif
                        </td>
                        <td>
                            @if($att->check_out)
                                <span class="fw-bold text-dark fs-8 font-monospace"><i class="bi bi-box-arrow-right text-danger me-1"></i>{{ $att->check_out->format('h:i A') }}</span>
                            @else
                                <span class="badge bg-light text-secondary border px-2 py-0.5 fs-8">Active</span>
                            @endif
                        </td>
                        <td>
                            @if($att->check_out)
                                <span class="fw-bold text-dark fs-8">{{ round($att->total_worked_minutes / 60, 1) }} hrs</span>
                            @elseif($att->check_in)
                                <span class="fw-bold text-primary fs-8 font-monospace live-worked-timer" data-checkin="{{ $att->check_in->toIso8601String() }}">
                                    <i class="bi bi-stopwatch me-1 text-primary"></i><span class="timer-display">Calculating...</span>
                                </span>
                            @else
                                <span class="text-muted fs-8">0 hrs</span>
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
                            @else
                                <span class="status-badge-pill half_day"><i class="bi bi-pie-chart-fill"></i> {{ ucfirst($att->status) }}</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted fs-8">
                            <i class="bi bi-calendar-x fs-4 d-block mb-1 text-slate-300"></i> No attendance logs recorded for this month.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function updateMyClock() {
        const now = new Date();
        let hours = now.getHours();
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12;
        const clockEl = document.getElementById('myLiveClock');
        if (clockEl) {
            clockEl.textContent = `${String(hours).padStart(2, '0')}:${minutes}:${seconds} ${ampm}`;
        }
    }

    function submitLivePunch() {
        const btn = document.getElementById('btnPunchAction');
        const btnText = document.getElementById('btnPunchText');
        const badge = document.getElementById('punchBadge');

        $.ajax({
            url: "{{ route('attendance.punch') }}",
            type: 'POST',
            data: { _token: '{{ csrf_token() }}' },
            success: function(res) {
                if (res.status === 'checked_in') {
                    btn.classList.add('checked-in');
                    btnText.textContent = 'Check Out Now';
                    if (badge) badge.textContent = 'Checked In (' + res.time + ')';

                    Swal.fire({
                        icon: 'success',
                        title: 'Checked In Successfully!',
                        text: res.message,
                        confirmButtonColor: '#4F46E5'
                    });
                } else {
                    btn.classList.remove('checked-in');
                    btnText.textContent = 'Check In Now';
                    if (badge) badge.textContent = 'Shift Completed';

                    Swal.fire({
                        icon: 'info',
                        title: 'Checked Out',
                        text: res.message,
                        confirmButtonColor: '#4F46E5'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Punch Failed',
                    text: 'Unable to log shift punch. Please try again.',
                    confirmButtonColor: '#4F46E5'
                });
            }
        });
    }

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
        updateMyClock();
        setInterval(updateMyClock, 1000);

        updateLiveWorkedHours();
        setInterval(updateLiveWorkedHours, 1000);
    });
</script>
@endpush
