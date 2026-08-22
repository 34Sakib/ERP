@extends('layouts.app')

@push('styles')
<style>
    .page-header-title {
        font-size: 1.5rem;
        font-weight: 800;
        letter-spacing: -0.02em;
        color: #0F172A;
    }

    /* Minimal Metric Stat Cards */
    .stat-card-simple {
        background: #ffffff;
        border-radius: 16px;
        padding: 1.25rem;
        border: 1px solid #E2E8F0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stat-card-simple:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
    }

    .stat-label {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748B;
    }

    .stat-value {
        font-size: 1.6rem;
        font-weight: 800;
        color: #0F172A;
        line-height: 1.2;
        margin-top: 0.25rem;
    }

    /* Clean Card Container */
    .clean-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #E2E8F0;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    }

    /* Simple Datatable */
    .table-simple {
        width: 100%;
        margin-bottom: 0;
    }

    .table-simple thead th {
        background: #F8FAFC;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #475569;
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #E2E8F0;
        white-space: nowrap;
    }

    .table-simple tbody td {
        padding: 1rem 1.25rem;
        vertical-align: middle;
        border-bottom: 1px solid #F1F5F9;
        font-size: 0.875rem;
    }

    .table-simple tbody tr:last-child td {
        border-bottom: none;
    }

    .table-simple tbody tr:hover {
        background-color: #F8FAFC;
    }

    /* Status Badges */
    .badge-status {
        font-size: 0.75rem;
        font-weight: 700;
        padding: 0.35rem 0.75rem;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        white-space: nowrap;
    }

    .badge-status.present {
        background: #DCFCE7;
        color: #15803D;
    }

    .badge-status.late {
        background: #FEF3C7;
        color: #B45309;
    }

    .badge-status.absent {
        background: #FEE2E2;
        color: #B91C1C;
    }

    .badge-status.half_day {
        background: #F3E8FF;
        color: #7E22CE;
    }

    .badge-status.on_leave {
        background: #E0F2FE;
        color: #0369A1;
    }

    [data-bs-theme="dark"] .stat-card-simple,
    [data-bs-theme="dark"] .clean-card {
        background: #1E293B !important;
        border-color: #334155 !important;
    }

    [data-bs-theme="dark"] .page-header-title,
    [data-bs-theme="dark"] .stat-value {
        color: #F8FAFC !important;
    }

    [data-bs-theme="dark"] .table-simple thead th {
        background: #0F172A !important;
        color: #94A3B8 !important;
        border-color: #334155 !important;
    }

    [data-bs-theme="dark"] .table-simple tbody td {
        border-color: #334155 !important;
        color: #E2E8F0 !important;
    }

    [data-bs-theme="dark"] .table-simple tbody tr:hover {
        background-color: #0F172A !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">

    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="page-header-title mb-1">Attendance Directory</h1>
            <p class="text-muted mb-0 fs-7">Daily attendance records for {{ \Carbon\Carbon::parse($date ?? date('Y-m-d'))->format('l, F j, Y') }}</p>
        </div>

        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('attendance.regularizations.index') }}" class="btn btn-outline-secondary rounded-pill px-3 py-2 fs-8 fw-bold">
                <i class="bi bi-card-checklist me-1"></i> Approvals Queue
            </a>
            <button class="btn btn-primary rounded-pill px-4 py-2 fs-8 fw-bold border-0 shadow-sm"
                    onclick="editAttendanceModal('', '{{ date('Y-m-d') }}', '09:00', '18:00', 'present')">
                <i class="bi bi-plus-lg me-1"></i> Log Attendance
            </button>
        </div>
    </div>

    <!-- Simple Metric Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card-simple">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="stat-label">Present</span>
                    <i class="bi bi-check-circle-fill text-success fs-5"></i>
                </div>
                <div class="stat-value text-success">{{ $stats['total_present'] ?? 0 }}</div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="stat-card-simple">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="stat-label">Late Arrival</span>
                    <i class="bi bi-clock-history text-warning fs-5"></i>
                </div>
                <div class="stat-value text-warning">{{ $stats['total_late'] ?? 0 }}</div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="stat-card-simple">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="stat-label">Absent</span>
                    <i class="bi bi-x-circle-fill text-danger fs-5"></i>
                </div>
                <div class="stat-value text-danger">{{ $stats['total_absent'] ?? 0 }}</div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="stat-card-simple">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="stat-label">On Leave</span>
                    <i class="bi bi-airplane-fill text-primary fs-5"></i>
                </div>
                <div class="stat-value text-primary">{{ $stats['total_on_leave'] ?? 0 }}</div>
            </div>
        </div>
    </div>

    <!-- Simple Filter Bar -->
    <div class="clean-card p-3 mb-4">
        <form method="GET" action="{{ route('attendance.index') }}">
            <div class="row g-3 align-items-center">
                <div class="col-12 col-sm-6 col-md-3">
                    <input type="date" name="date" class="form-control rounded-3 fs-8 fw-semibold" value="{{ $date ?? date('Y-m-d') }}" onchange="this.form.submit()">
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <input type="text" name="search" class="form-control rounded-3 fs-8" value="{{ request('search') }}" placeholder="Search employee name or code...">
                </div>
                <div class="col-6 col-md-3">
                    <select name="status" class="form-select rounded-3 fs-8 fw-semibold" onchange="this.form.submit()">
                        <option value="">All Statuses</option>
                        <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>Present</option>
                        <option value="late" {{ request('status') == 'late' ? 'selected' : '' }}>Late Arrival</option>
                        <option value="half_day" {{ request('status') == 'half_day' ? 'selected' : '' }}>Half Day</option>
                        <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>Absent</option>
                        <option value="on_leave" {{ request('status') == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                    </select>
                </div>
                <div class="col-6 col-md-2 text-end">
                    <a href="{{ route('attendance.index') }}" class="btn btn-light border rounded-3 w-100 fs-8 text-muted fw-bold">Reset</a>
                </div>
            </div>
        </form>
    </div>

    <!-- Attendance Table -->
    <div class="clean-card overflow-hidden mb-4">
        <div class="table-responsive">
            <table class="table table-simple align-middle">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Department</th>
                        <th>Entry Time</th>
                        <th>Exit Time</th>
                        <th>Worked Hours</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $att)
                        @if(!$att->employee)
                            @continue
                        @endif
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ $att->employee->avatar_url }}"
                                         class="rounded-circle" style="width: 36px; height: 36px; object-fit: cover;">
                                    <div>
                                        <div class="fw-bold text-dark fs-7">{{ $att->employee->full_name }}</div>
                                        <div class="fs-8 text-muted">{{ $att->employee->employee_code }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="fw-semibold text-dark">{{ $att->employee->department?->name ?? 'General' }}</span>
                            </td>
                            <td>
                                @if($att->check_in)
                                    <div class="fw-bold text-dark font-monospace"><i class="bi bi-box-arrow-in-right text-success me-1"></i>{{ $att->check_in->format('h:i A') }}</div>
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
                                    <span class="text-muted">--:--</span>
                                @endif
                            </td>
                            <td>
                                @if($att->check_out)
                                    <span class="fw-bold text-dark font-monospace"><i class="bi bi-box-arrow-right text-danger me-1"></i>{{ $att->check_out->format('h:i A') }}</span>
                                @elseif($att->check_in)
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger-subtle px-2.5 py-1 rounded-pill fw-bold fs-8">
                                        Not exit
                                    </span>
                                @else
                                    <span class="text-muted">--:--</span>
                                @endif
                            </td>
                            <td>
                                @if($att->check_out)
                                    <span class="fw-bold text-dark font-monospace">{{ round($att->total_worked_minutes / 60, 1) }} hrs</span>
                                @elseif($att->check_in)
                                    <span class="fw-bold text-primary font-monospace live-worked-timer" data-checkin="{{ $att->check_in->toIso8601String() }}">
                                        <i class="bi bi-stopwatch me-1"></i><span class="timer-display">Live</span>
                                    </span>
                                @else
                                    <span class="text-muted">0 hrs</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $isLate = $att->status === 'late' || ($att->late_minutes > 0);
                                @endphp
                                @if($isLate)
                                    <span class="badge-status late"><i class="bi bi-clock-history"></i> Late Arrival</span>
                                @elseif($att->status === 'present')
                                    <span class="badge-status present"><i class="bi bi-check-circle-fill"></i> Present</span>
                                @elseif($att->status === 'absent')
                                    <span class="badge-status absent"><i class="bi bi-x-circle-fill"></i> Absent</span>
                                @elseif($att->status === 'half_day')
                                    <span class="badge-status half_day"><i class="bi bi-pie-chart-fill"></i> Half Day</span>
                                @else
                                    <span class="badge-status on_leave"><i class="bi bi-airplane-fill"></i> On Leave</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end align-items-center gap-1.5">
                                    <button class="btn btn-sm btn-outline-purple rounded-pill px-3 py-1 fs-8 fw-bold"
                                            style="border-color: #8B5CF6; color: #7C3AED;"
                                            onclick="openRequestEntryExitModal('{{ $att->employee_id }}', '{{ $att->date->format('Y-m-d') }}', '{{ $att->check_in ? $att->check_in->format('H:i') : '' }}', '{{ $att->check_out ? $att->check_out->format('H:i') : '' }}')">
                                        Request Edit
                                    </button>
                                    <button class="btn btn-sm btn-light rounded-circle text-muted" style="width: 32px; height: 32px;"
                                            onclick="editAttendanceModal('{{ $att->employee_id }}', '{{ $att->date->format('Y-m-d') }}', '{{ $att->check_in ? $att->check_in->format('H:i') : '' }}', '{{ $att->check_out ? $att->check_out->format('H:i') : '' }}', '{{ $att->status }}')"
                                            title="Edit Log">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <div class="fw-bold mb-1 text-dark">No attendance logs found</div>
                                <div class="fs-8">Try selecting a different date or log an entry.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($attendances->hasPages())
            <div class="p-3 border-top">
                {{ $attendances->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Modal: Admin Manual Attendance Log/Edit -->
<div class="modal fade" id="manualAttendanceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <form action="{{ route('attendance.store') }}" method="POST">
                @csrf
                <div class="modal-header border-bottom px-4 py-3">
                    <h5 class="modal-title fw-bold text-dark fs-6" id="modalTitle">Log Attendance Entry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 fs-7">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs-8 mb-1">Select Employee *</label>
                        <select name="employee_id" id="modal_employee_id" class="form-select rounded-3 fs-8" required>
                            <option value="">Choose Staff Member</option>
                            @foreach(($employees ?? []) as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->full_name }} ({{ $emp->employee_code }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs-8 mb-1">Date *</label>
                        <input type="date" name="date" id="modal_date" class="form-control rounded-3 fs-8" required value="{{ date('Y-m-d') }}">
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold text-dark fs-8 mb-1">Check-In Time</label>
                            <input type="time" name="check_in" id="modal_check_in" class="form-control rounded-3 fs-8" value="09:00">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold text-dark fs-8 mb-1">Check-Out Time</label>
                            <input type="time" name="check_out" id="modal_check_out" class="form-control rounded-3 fs-8" value="18:00">
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-bold text-dark fs-8 mb-1">Attendance Status *</label>
                        <select name="status" id="modal_status" class="form-select rounded-3 fs-8" required>
                            <option value="present">Present (On-Time)</option>
                            <option value="late">Late Arrival</option>
                            <option value="half_day">Half Day</option>
                            <option value="absent">Absent</option>
                            <option value="on_leave">On Leave</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4 fs-8 fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fs-8 fw-bold">Save Record</button>
                </div>
            </form>
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

@push('scripts')
<script>
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
        document.getElementById('modalTitle').textContent = empId ? 'Edit Attendance Record' : 'Log Manual Attendance';
        document.getElementById('modal_employee_id').value = empId || '';
        document.getElementById('modal_date').value = date || '{{ date('Y-m-d') }}';
        document.getElementById('modal_check_in').value = checkIn || '09:00';
        document.getElementById('modal_check_out').value = checkOut || '18:00';
        document.getElementById('modal_status').value = status || 'present';

        var modal = new bootstrap.Modal(document.getElementById('manualAttendanceModal'));
        modal.show();
    }

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
@endsection