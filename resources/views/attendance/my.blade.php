@extends('layouts.app')

@push('styles')
<style>
    .page-header-title {
        font-size: 1.4rem;
        font-weight: 800;
        letter-spacing: -0.02em;
        color: #0F172A;
    }

    /* Hero Banner (Compact) */
    .my-hero-sm {
        background: linear-gradient(135deg, #4338CA 0%, #6366F1 50%, #7C3AED 100%);
        border-radius: 14px;
        padding: 1.1rem 1.35rem;
        color: #ffffff;
        margin-bottom: 1rem;
        box-shadow: 0 6px 18px rgba(99, 102, 241, 0.15);
    }

    /* Sleek Dark Biometric Shift Terminal (Improved Earlier Design) */
    .punch-terminal-improved {
        background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
        border-radius: 14px;
        padding: 1rem 1.15rem;
        color: #ffffff;
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.2);
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    .clock-display-tight {
        font-size: 1.65rem;
        font-weight: 800;
        font-family: monospace;
        letter-spacing: 0.04em;
        color: #38BDF8;
        text-shadow: 0 0 12px rgba(56, 189, 248, 0.4);
        line-height: 1;
    }

    .btn-fingerprint-tight {
        background: linear-gradient(135deg, #38BDF8 0%, #2563EB 100%);
        color: #ffffff;
        border: none;
        border-radius: 10px;
        padding: 0.65rem 1rem;
        font-weight: 800;
        font-size: 0.88rem;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        box-shadow: 0 5px 15px rgba(56, 189, 248, 0.3);
        transition: all 0.2s ease;
    }

    .btn-fingerprint-tight:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(56, 189, 248, 0.4);
        color: #ffffff;
    }

    .btn-fingerprint-tight.checked-in {
        background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
        box-shadow: 0 5px 15px rgba(239, 68, 68, 0.3);
    }

    /* Smaller 4 Soft Pastel Metric Cards */
    .pastel-card-smaller {
        border-radius: 14px;
        padding: 0.75rem 0.95rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 98px;
        position: relative;
        border: 1px solid transparent;
        transition: all 0.2s ease;
        height: 100%;
    }

    .pastel-card-smaller:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.04);
    }

    .card-pastel-emerald { background: linear-gradient(135deg, #ECFDF5 0%, #D1FAE5 100%); border-color: #A7F3D0; }
    .card-pastel-amber { background: linear-gradient(135deg, #FFFBEB 0%, #FEF3C7 100%); border-color: #FDE68A; }
    .card-pastel-rose { background: linear-gradient(135deg, #FFF1F2 0%, #FFE4E6 100%); border-color: #FECDD3; }
    .card-pastel-indigo { background: linear-gradient(135deg, #F0F9FF 0%, #E0F2FE 100%); border-color: #BAE6FD; }

    .ui8-pill-val-tight {
        background: #ffffff;
        padding: 0.15rem 0.55rem;
        border-radius: 999px;
        font-weight: 800;
        font-size: 0.72rem;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.04);
    }

    .ui8-card-title-tight {
        font-size: 0.88rem;
        font-weight: 800;
        letter-spacing: -0.01em;
        color: #1E1B4B;
        margin-top: 0.2rem;
        margin-bottom: 0;
    }

    /* Compact Datatable */
    .table-compact {
        width: 100%;
        margin-bottom: 0;
    }

    .table-compact thead th {
        background: #F8FAFC;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #475569;
        padding: 0.65rem 0.9rem;
        border-bottom: 1px solid #E2E8F0;
        white-space: nowrap;
    }

    .table-compact tbody td {
        padding: 0.65rem 0.9rem;
        vertical-align: middle;
        border-bottom: 1px solid #F1F5F9;
        font-size: 0.82rem;
    }

    .table-compact tbody tr:last-child td {
        border-bottom: none;
    }

    .table-compact tbody tr:hover {
        background-color: #F8FAFC;
    }

    .status-badge-pill {
        font-size: 0.7rem;
        font-weight: 800;
        padding: 0.25rem 0.65rem;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        white-space: nowrap;
    }

    .status-badge-pill.present { background: #DCFCE7; color: #15803D; border: 1px solid #BBF7D0; }
    .status-badge-pill.late { background: #FEF3C7; color: #B45309; border: 1px solid #FDE68A; }
    .status-badge-pill.absent { background: #FEE2E2; color: #B91C1C; border: 1px solid #FECDD3; }
    .status-badge-pill.half_day { background: #F3E8FF; color: #7E22CE; border: 1px solid #DDD6FE; }

    [data-bs-theme="dark"] .pastel-card-smaller { background: #1F2937 !important; border-color: #374151 !important; }
    [data-bs-theme="dark"] .ui8-card-title-tight { color: #F8FAFC !important; }
    [data-bs-theme="dark"] .table-compact thead th { background: #0F172A !important; color: #94A3B8 !important; border-color: #334155 !important; }
    [data-bs-theme="dark"] .table-compact tbody td { border-color: #334155 !important; color: #E2E8F0 !important; }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-3">

    <!-- Header Banner (Compact) -->
    <div class="my-hero-sm">
        <div class="row align-items-center g-2">
            <div class="col-12 col-md-8">
                <div class="d-flex align-items-center gap-2 mb-0.5">
                    <span class="badge rounded-pill bg-white bg-opacity-20 text-white fs-8 px-2.5 py-0.5">
                        <i class="bi bi-person-badge-fill me-1"></i> Personal Workspace
                    </span>
                    <span class="fs-8 text-white-50">• {{ $employee?->full_name ?? 'Staff Member' }}</span>
                </div>
                <h4 class="mb-0 fw-extrabold text-white" style="letter-spacing: -0.02em;">
                    My Attendance & Shift Portal
                </h4>
            </div>
            <div class="col-12 col-md-4 text-md-end">
                <a href="{{ route('attendance.regularizations.index') }}" class="btn btn-light rounded-pill px-3 py-1.5 fw-bold text-dark fs-8 shadow-sm">
                    <i class="bi bi-pencil-square me-1 text-primary"></i> Request Regularization
                </a>
            </div>
        </div>
    </div>

    <!-- Live Terminal & Smaller Pastel Cards Row -->
    <div class="row g-2.5 mb-3 align-items-stretch">
        <!-- Sleek Biometric Shift Terminal Widget -->
        <div class="col-12 col-lg-5 col-xl-4">
            <div class="punch-terminal-improved">
                <div>
                    <div class="d-flex justify-content-between align-items-center mb-1.5 pb-1.5 border-bottom border-white border-opacity-10 gap-2">
                        <div class="d-flex align-items-center gap-1.5 text-white-50 fw-bold text-nowrap" style="font-size: 0.78rem;">
                            <i class="bi bi-fingerprint fs-6 text-info"></i>
                            <span class="text-white">Biometric Shift Terminal</span>
                        </div>
                        <span class="badge rounded-pill px-2.5 py-1 fs-8 text-nowrap flex-shrink-0" style="background: rgba(255, 255, 255, 0.25); color: #ffffff; font-weight: 700;">
                            {{ date('M d, Y') }}
                        </span>
                    </div>

                    <div class="text-center py-1 mb-1.5">
                        <div class="clock-display-tight" id="myLiveClock">00:00:00 AM</div>
                        <div class="fs-8 text-white-50 mt-1">Shift: <strong class="text-white">09:00 AM - 06:00 PM</strong></div>
                    </div>

                    <div class="bg-black bg-opacity-30 rounded-3 p-2 mb-2 border border-white border-opacity-10">
                        <div class="d-flex justify-content-between align-items-center mb-1 fs-8 text-white-50">
                            <span>Punch Status</span>
                            @if($todayAttendance && $todayAttendance->check_in && !$todayAttendance->check_out)
                                <span id="punchBadge" class="badge bg-success text-white px-2 py-0.5 rounded-pill fs-8 fw-bold">
                                    <i class="bi bi-fingerprint me-1"></i> Checked In ({{ $todayAttendance->check_in->format('h:i A') }})
                                </span>
                            @elseif($todayAttendance && $todayAttendance->check_out)
                                <span id="punchBadge" class="badge bg-secondary text-white px-2 py-0.5 rounded-pill fs-8 fw-bold">Shift Completed</span>
                            @else
                                <span id="punchBadge" class="badge bg-info text-white px-2 py-0.5 rounded-pill fs-8 fw-bold">Ready to Scan</span>
                            @endif
                        </div>
                        <div class="progress" style="height: 4px; background: rgba(255,255,255,0.15); border-radius: 999px;">
                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ $todayAttendance && $todayAttendance->check_in ? '100%' : '0%' }}; border-radius: 999px;"></div>
                        </div>
                    </div>
                </div>

                <button id="btnPunchAction" class="btn-fingerprint-tight {{ $todayAttendance && $todayAttendance->check_in && !$todayAttendance->check_out ? 'checked-in' : '' }}" onclick="submitLivePunch()">
                    <i class="bi bi-fingerprint fs-5 me-1"></i>
                    <span id="btnPunchText">{{ $todayAttendance && $todayAttendance->check_in && !$todayAttendance->check_out ? 'Check Out Now' : 'Check In Now' }}</span>
                </button>
            </div>
        </div>

        <!-- 4 Smaller Soft Pastel Metric Cards -->
        <div class="col-12 col-lg-7 col-xl-8">
            <div class="row g-2 h-100">
                <div class="col-6 col-sm-6">
                    <div class="pastel-card-smaller card-pastel-emerald">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fs-8 text-secondary fw-semibold"><i class="bi bi-calendar-check me-1"></i> Target</span>
                            <span class="ui8-pill-val-tight text-success">{{ $stats['present'] }} Days</span>
                        </div>
                        <h6 class="ui8-card-title-tight">Present Days</h6>
                        <div class="fs-8 text-muted">Verified attendance</div>
                    </div>
                </div>

                <div class="col-6 col-sm-6">
                    <div class="pastel-card-smaller card-pastel-amber">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fs-8 text-secondary fw-semibold"><i class="bi bi-clock-history me-1"></i> Grace</span>
                            <span class="ui8-pill-val-tight text-warning">{{ $stats['late'] }} Late</span>
                        </div>
                        <h6 class="ui8-card-title-tight">Late Arrivals</h6>
                        <div class="fs-8 text-muted">Exceeded 09:15 AM</div>
                    </div>
                </div>

                <div class="col-6 col-sm-6">
                    <div class="pastel-card-smaller card-pastel-rose">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fs-8 text-secondary fw-semibold"><i class="bi bi-exclamation-circle me-1"></i> Unexcused</span>
                            <span class="ui8-pill-val-tight text-danger">{{ $stats['absent'] }} Days</span>
                        </div>
                        <h6 class="ui8-card-title-tight">Absences</h6>
                        <div class="fs-8 text-muted">Unapproved misses</div>
                    </div>
                </div>

                <div class="col-6 col-sm-6">
                    <div class="pastel-card-smaller card-pastel-indigo">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fs-8 text-secondary fw-semibold"><i class="bi bi-stopwatch me-1"></i> Hours</span>
                            <span class="ui8-pill-val-tight text-info">{{ $stats['total_worked_hours'] }}h Worked</span>
                        </div>
                        <h6 class="ui8-card-title-tight">Total Worked</h6>
                        <div class="fs-8 text-muted">Cumulative duration</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Personal Attendance Log History Table (Compact) -->
    <div class="card rounded-4 border-0 shadow-sm overflow-hidden mb-3">
        <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light bg-opacity-50">
            <div class="fs-8 text-muted fw-bold">
                Monthly Attendance History (<strong class="text-dark">{{ date('F Y') }}</strong>)
            </div>
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill fs-8 fw-bold">
                <i class="bi bi-fingerprint me-1"></i> Biometric Verified
            </span>
        </div>

        <div class="table-responsive">
            <table class="table table-compact table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>DATE</th>
                        <th>CHECK-IN TIME</th>
                        <th>CHECK-OUT TIME</th>
                        <th>WORKED DURATION</th>
                        <th>STATUS</th>
                        <th class="text-end pe-3">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $att)
                        <tr>
                            <td class="fw-bold text-dark fs-8">{{ $att->date->format('D, M d, Y') }}</td>
                            <td>
                                @if($att->check_in)
                                    <div class="fw-bold text-dark fs-8 font-monospace">
                                        <i class="bi bi-fingerprint text-success me-1 fs-7" title="Biometric Scan"></i>{{ $att->check_in->format('h:i A') }}
                                    </div>
                                    <div class="mt-0.5">
                                        @if($att->check_in_source === 'manual')
                                            <span class="badge bg-warning bg-opacity-15 text-dark border border-warning-subtle px-2 py-0.5 fs-8 fw-bold">
                                                <i class="bi bi-pencil me-1 text-warning"></i>Manual
                                            </span>
                                        @else
                                            <span class="badge bg-info bg-opacity-10 text-primary border border-info-subtle px-2 py-0.5 fs-8 fw-bold">
                                                <i class="bi bi-fingerprint me-1 text-primary"></i>Auto
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-muted fs-8">--:--</span>
                                @endif
                            </td>
                            <td>
                                @if($att->check_out)
                                    <span class="fw-bold text-dark fs-8 font-monospace">
                                        <i class="bi bi-box-arrow-right text-danger me-1"></i>{{ $att->check_out->format('h:i A') }}
                                    </span>
                                @elseif($att->check_in)
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger-subtle px-2.5 py-1 fs-8 fw-bold">
                                        <i class="bi bi-exclamation-circle me-1"></i>Not exit
                                    </span>
                                @else
                                    <span class="badge bg-light text-secondary border px-2 py-0.5 fs-8">No Log</span>
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
                            <td class="text-end pe-3">
                                <button class="btn btn-sm btn-outline-purple rounded-pill px-2.5 py-1 fs-8 fw-bold"
                                        style="border-color: #8B5CF6; color: #7C3AED;"
                                        onclick="openRequestEntryExitModal('{{ $att->employee_id }}', '{{ $att->date->format('Y-m-d') }}', '{{ $att->check_in ? $att->check_in->format('H:i') : '' }}', '{{ $att->check_out ? $att->check_out->format('H:i') : '' }}')">
                                    <i class="bi bi-pencil-square me-1"></i>Request Edit
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted fs-8">
                                <i class="bi bi-fingerprint fs-3 d-block mb-1 text-muted"></i> No attendance logs recorded for this month.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal: Request Entry/Exit Edit (User Refined Design) -->
<div class="modal fade" id="requestEntryExitEditModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px; overflow: hidden; background: #ffffff;">
            <div class="modal-header border-0 pb-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <h5 class="modal-title fw-bold text-dark fs-5" style="letter-spacing: -0.02em;">Request Entry/Exit Edit</h5>
                <button type="button" class="btn-close rounded-circle p-2 bg-light" data-bs-dismiss="modal" aria-label="Close" style="font-size: 0.75rem;"></button>
            </div>
            <form action="{{ route('attendance.regularizations.store') }}" method="POST">
                @csrf
                <input type="hidden" name="employee_id" id="edit_modal_employee_id">
                <div class="modal-body p-4 fs-7">
                    <div class="mb-3.5">
                        <label class="form-label fw-semibold text-secondary fs-8 mb-1">Date</label>
                        <input type="date" name="date" id="edit_modal_date" class="form-control rounded-3 p-2.5 fs-7 border-light-subtle" required style="background: #F9FAFB;">
                    </div>

                    <div class="mb-3.5">
                        <label class="form-label fw-semibold text-secondary fs-8 mb-1">Entry Time (HH:MM)</label>
                        <input type="time" name="entry_time" id="edit_modal_entry_time" class="form-control rounded-3 p-2.5 fs-7 border-light-subtle" style="background: #F9FAFB;">
                    </div>

                    <div class="mb-3.5">
                        <label class="form-label fw-semibold text-secondary fs-8 mb-1">Exit Time (HH:MM) <span class="text-muted fw-normal">(optional)</span></label>
                        <input type="time" name="exit_time" id="edit_modal_exit_time" class="form-control rounded-3 p-2.5 fs-7 border-light-subtle" style="background: #F9FAFB;">
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-semibold text-secondary fs-8 mb-1">Reason</label>
                        <textarea name="reason" rows="3" class="form-control rounded-3 p-2.5 fs-7 border-light-subtle" required style="background: #F9FAFB;" placeholder="Why are you requesting this change?"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 px-4 d-flex justify-content-between gap-2">
                    <button type="button" class="btn btn-light rounded-3 px-4 py-2.5 fw-bold text-dark fs-7 flex-grow-1 border-0" style="background: #F3F4F6;" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn text-white rounded-3 px-4 py-2.5 fw-bold fs-7 flex-grow-1 border-0 shadow-sm" style="background: linear-gradient(135deg, #A855F7 0%, #8B5CF6 100%);">Submit Request</button>
                </div>
            </form>
        </div>
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
                    if (badge) badge.innerHTML = '<i class="bi bi-fingerprint me-1"></i> Checked In (' + res.time + ')';

                    Swal.fire({
                        icon: 'success',
                        title: 'Fingerprint Scanned & Checked In!',
                        text: res.message,
                        confirmButtonColor: '#4F46E5'
                    });
                } else {
                    btn.classList.remove('checked-in');
                    btnText.textContent = 'Check In Now';
                    if (badge) badge.textContent = 'Shift Completed';

                    Swal.fire({
                        icon: 'info',
                        title: 'Checked Out Successfully',
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

    function openRequestEntryExitModal(empId, date, checkIn, checkOut) {
        document.getElementById('edit_modal_employee_id').value = empId;
        document.getElementById('edit_modal_date').value = date;
        document.getElementById('edit_modal_entry_time').value = checkIn || '09:00';
        document.getElementById('edit_modal_exit_time').value = checkOut || '';

        var modal = new bootstrap.Modal(document.getElementById('requestEntryExitEditModal'));
        modal.show();
    }
</script>
@endpush
