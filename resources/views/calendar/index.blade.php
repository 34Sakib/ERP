@extends('layouts.app')

@push('styles')
<style>
    /* Premium Executive Side-Scroll-Free Calendar */
    .calendar-hero-card {
        background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
        border-radius: 16px;
        padding: 1.5rem 2rem;
        color: #ffffff;
        margin-bottom: 1.25rem;
        box-shadow: 0 10px 30px -5px rgba(79, 70, 229, 0.35);
        position: relative;
        overflow: hidden;
    }

    .calendar-hero-card::before {
        content: '';
        position: absolute;
        top: -40%;
        right: -5%;
        width: 320px;
        height: 320px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .calendar-container-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #E2E8F0;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        overflow: hidden;
        width: 100%;
    }

    .calendar-header-toolbar {
        background: #F8FAFC;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #E2E8F0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    /* Fixed Table Layout - Guarantees 0 Horizontal Scrollbar / Side Scroll */
    .calendar-table-wrapper {
        width: 100%;
        overflow-x: hidden;
    }

    .calendar-table {
        width: 100%;
        table-layout: fixed; /* Equal 14.285% width distribution */
        border-collapse: collapse;
        margin-bottom: 0;
    }

    .calendar-table th {
        background: #F1F5F9;
        font-size: 0.72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #475569;
        text-align: center;
        padding: 0.75rem 0.25rem;
        border-bottom: 1px solid #E2E8F0;
        border-right: 1px solid #E2E8F0;
        width: 14.285%;
    }

    .calendar-table th:last-child {
        border-right: none;
    }

    .calendar-day-cell {
        width: 14.285%;
        height: 115px;
        vertical-align: top;
        padding: 0.5rem;
        border-bottom: 1px solid #E2E8F0;
        border-right: 1px solid #E2E8F0;
        background: #ffffff;
        transition: background 0.15s ease;
        position: relative;
        cursor: pointer;
    }

    .calendar-day-cell:last-child {
        border-right: none;
    }

    .calendar-day-cell:hover {
        background: #F4F5FF !important;
    }

    .calendar-day-cell.weekend {
        background: #FAFAFA;
    }

    .calendar-day-cell.other-month {
        background: #F8FAFC;
        opacity: 0.45;
    }

    .day-number-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.35rem;
    }

    .day-number {
        font-size: 0.8rem;
        font-weight: 700;
        color: #334155;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .day-number.today {
        background: #4F46E5;
        color: #ffffff;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        font-weight: 800;
        font-size: 0.75rem;
        box-shadow: 0 2px 8px rgba(79, 70, 229, 0.35);
    }

    .add-event-hint {
        opacity: 0;
        font-size: 0.68rem;
        font-weight: 700;
        color: #4F46E5;
        transition: opacity 0.15s ease;
    }

    .calendar-day-cell:hover .add-event-hint {
        opacity: 1;
    }

    .events-container {
        max-height: 75px;
        overflow-y: auto;
        padding-right: 2px;
    }

    .events-container::-webkit-scrollbar {
        width: 3px;
    }
    .events-container::-webkit-scrollbar-thumb {
        background: #CBD5E1;
        border-radius: 4px;
    }

    /* Event Badge Items */
    .event-chip-pill {
        font-size: 0.68rem;
        font-weight: 600;
        padding: 0.2rem 0.45rem;
        border-radius: 6px;
        margin-bottom: 0.2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        cursor: pointer;
        transition: transform 0.15s ease;
        max-width: 100%;
        line-height: 1.25;
    }

    .event-chip-pill span {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .event-chip-pill:hover {
        transform: scale(1.01);
    }

    .event-chip-pill.red {
        background: #FEE2E2;
        color: #991B1B;
        border-left: 2.5px solid #EF4444;
    }

    .event-chip-pill.indigo {
        background: #EEF2FF;
        color: #3730A3;
        border-left: 2.5px solid #6366F1;
    }

    .event-chip-pill.emerald {
        background: #ECFDF5;
        color: #065F46;
        border-left: 2.5px solid #10B981;
    }

    .event-chip-pill.amber {
        background: #FEF3C7;
        color: #92400E;
        border-left: 2.5px solid #F59E0B;
    }

    /* KPI Summary Cards */
    .cal-kpi-card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #E2E8F0;
        padding: 0.85rem 1.15rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    }

    .cal-kpi-val {
        font-size: 1.25rem;
        font-weight: 800;
        color: #1E293B;
        line-height: 1;
    }

    .cal-kpi-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #64748B;
    }

    /* Dark Mode Overrides */
    [data-bs-theme="dark"] .calendar-container-card,
    [data-bs-theme="dark"] .cal-kpi-card {
        background: #1E293B !important;
        border-color: #334155 !important;
    }
    [data-bs-theme="dark"] .calendar-header-toolbar {
        background: #0F172A !important;
        border-color: #334155 !important;
    }
    [data-bs-theme="dark"] .calendar-table th {
        background: #0F172A !important;
        color: #94A3B8 !important;
        border-color: #334155 !important;
    }
    [data-bs-theme="dark"] .calendar-day-cell {
        background: #1E293B !important;
        border-color: #334155 !important;
    }
    [data-bs-theme="dark"] .calendar-day-cell.weekend,
    [data-bs-theme="dark"] .calendar-day-cell.other-month {
        background: #0F172A !important;
    }
    [data-bs-theme="dark"] .calendar-day-cell:hover {
        background: #334155 !important;
    }
    [data-bs-theme="dark"] .day-number {
        color: #F8FAFC !important;
    }
    [data-bs-theme="dark"] .cal-kpi-val {
        color: #F8FAFC !important;
    }
</style>
@endpush

@section('content')
<!-- Hero Header -->
<div class="calendar-hero-card">
    <div class="row align-items-center g-3">
        <div class="col-12 col-md-8">
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge rounded-pill bg-white bg-opacity-20 text-white fs-8 px-2.5 py-1">
                    <i class="bi bi-calendar3 me-1"></i> Master Organization Schedule
                </span>
                <span class="fs-8 text-white-75">• {{ $monthName }} {{ $year }}</span>
            </div>
            <h3 class="mb-1 fw-black text-white style-heading" style="letter-spacing: -0.02em;">
                Company Calendar & Live Schedule
            </h3>
            <p class="mb-0 text-white-75 fs-7">
                Real-time synchronized company events, approved employee leaves, and notices. Click any date cell to schedule.
            </p>
        </div>
        <div class="col-12 col-md-4 text-md-end">
            <button class="btn btn-light rounded-pill px-3.5 py-2 fw-bold text-indigo shadow-sm"
                    onclick="openScheduleModal('{{ date('Y-m-d') }}')" style="color: #4F46E5;">
                <i class="bi bi-plus-circle-fill me-1 fs-6"></i> Schedule Event
            </button>
        </div>
    </div>
</div>

<!-- Compact Summary Bar -->
<div class="row g-3 mb-3">
    <div class="col-6 col-md-3">
        <div class="cal-kpi-card">
            <div>
                <div class="cal-kpi-label">Month Events</div>
                <div class="cal-kpi-val text-primary">{{ $stats['total_events'] }}</div>
            </div>
            <div class="badge rounded-circle bg-primary bg-opacity-10 text-primary p-2 fs-6">
                <i class="bi bi-calendar-event"></i>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="cal-kpi-card">
            <div>
                <div class="cal-kpi-label">Public Holidays</div>
                <div class="cal-kpi-val text-danger">{{ $stats['holidays_count'] }}</div>
            </div>
            <div class="badge rounded-circle bg-danger bg-opacity-10 text-danger p-2 fs-6">
                <i class="bi bi-flag-fill"></i>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="cal-kpi-card">
            <div>
                <div class="cal-kpi-label">Sprints & Audits</div>
                <div class="cal-kpi-val text-warning">{{ $stats['sprints_count'] }}</div>
            </div>
            <div class="badge rounded-circle bg-warning bg-opacity-10 text-warning p-2 fs-6">
                <i class="bi bi-lightning-fill"></i>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="cal-kpi-card">
            <div>
                <div class="cal-kpi-label">Today's Date</div>
                <div class="cal-kpi-val text-success" style="font-size: 1rem;">{{ date('M d, Y') }}</div>
            </div>
            <div class="badge rounded-circle bg-success bg-opacity-10 text-success p-2 fs-6">
                <i class="bi bi-clock-history"></i>
            </div>
        </div>
    </div>
</div>

<!-- Master Calendar Grid Card (Side-Scroll Free) -->
<div class="calendar-container-card">
    <!-- Toolbar Header -->
    <div class="calendar-header-toolbar">
        <div class="d-flex align-items-center gap-3">
            @php
                $prevM = $month - 1;
                $prevY = $year;
                if ($prevM < 1) { $prevM = 12; $prevY--; }

                $nextM = $month + 1;
                $nextY = $year;
                if ($nextM > 12) { $nextM = 1; $nextY++; }
            @endphp
            <div class="btn-group btn-group-sm shadow-sm rounded-pill overflow-hidden border">
                <a href="{{ route('calendar.index', ['month' => $prevM, 'year' => $prevY]) }}" class="btn btn-white fw-bold text-dark px-3 py-1.5"><i class="bi bi-chevron-left"></i> Prev</a>
                <a href="{{ route('calendar.index', ['month' => $nextM, 'year' => $nextY]) }}" class="btn btn-white fw-bold text-dark px-3 py-1.5">Next <i class="bi bi-chevron-right"></i></a>
            </div>
            <h4 class="fw-black text-dark mb-0" style="letter-spacing: -0.02em;">{{ $monthName }} {{ $year }}</h4>
            <span class="badge bg-indigo bg-opacity-10 text-indigo px-3 py-1.5 rounded-pill fs-8 fw-bold" style="background: #EEF2FF; color: #4338CA;">
                <i class="bi bi-clock me-1"></i> Today: {{ date('F j, Y') }}
            </span>
        </div>

        <div class="d-flex align-items-center gap-2">
            <span class="fs-8 text-muted fw-bold">
                <i class="bi bi-info-circle me-1"></i> Click any cell to add an event
            </span>
        </div>
    </div>

    <!-- Fixed Width Calendar Table - Fits 100% Viewport Width with 0 Side-Scroll -->
    <div class="calendar-table-wrapper">
        <table class="calendar-table">
            <thead>
                <tr>
                    <th>Sun</th>
                    <th>Mon</th>
                    <th>Tue</th>
                    <th>Wed</th>
                    <th>Thu</th>
                    <th>Fri</th>
                    <th>Sat</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $chunks = array_chunk($calendarDays, 7);
                @endphp
                @foreach($chunks as $week)
                    <tr>
                        @foreach($week as $dayCell)
                            @php
                                $dStr = $dayCell['date'];
                                $dayEvents = $eventsByDate[$dStr] ?? [];
                            @endphp
                            <td class="calendar-day-cell {{ $dayCell['is_weekend'] ? 'weekend' : '' }} {{ !$dayCell['is_current_month'] ? 'other-month' : '' }}"
                                onclick="handleDayCellClick(event, '{{ $dStr }}')">
                                <div class="day-number-header">
                                    <span class="day-number {{ $dayCell['is_today'] ? 'today' : '' }}">
                                        {{ $dayCell['day'] }}
                                    </span>
                                    <span class="add-event-hint"><i class="bi bi-plus-circle-fill"></i> Add</span>
                                </div>

                                <div class="events-container">
                                    @foreach($dayEvents as $ev)
                                        <div class="event-chip-pill {{ $ev->type }}" 
                                             onclick="event.stopPropagation(); viewEventModal('{{ $ev->id }}', '{{ addslashes($ev->title) }}', '{{ addslashes($ev->description) }}', '{{ $ev->event_date->format('M d, Y') }}', '{{ $ev->type }}')">
                                            <span>{{ $ev->title }}</span>
                                            @if($ev->is_custom ?? true)
                                                <i class="bi bi-trash-fill fs-8 text-danger ms-1 opacity-75" onclick="event.stopPropagation(); confirmDeleteEvent('{{ $ev->id }}', '{{ addslashes($ev->title) }}');" title="Delete Event"></i>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Schedule New Event Modal -->
<div class="modal fade" id="scheduleEventModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom px-4 py-3">
                <h5 class="modal-title fw-bold fs-6 text-dark" id="eventModalTitle">Schedule New Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('calendar.events.store') }}" method="POST" id="scheduleEventForm">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Event Date <span class="text-danger">*</span></label>
                        <input type="date" name="event_date" id="evt_date" class="form-control rounded-3 fs-8" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Event Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="evt_title" class="form-control rounded-3 fs-8" placeholder="e.g. Q3 Sprint Review Demo" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Event Category / Theme <span class="text-danger">*</span></label>
                        <select name="type" id="evt_type" class="form-select rounded-3 fs-8" required>
                            <option value="indigo">⚡ Indigo (Sprint / Meeting)</option>
                            <option value="emerald">💵 Emerald (Payroll / Finance)</option>
                            <option value="amber">🛡️ Amber (System Audit / Reminder)</option>
                            <option value="red">🇨🇦 Red (Public Holiday / Urgent Closure)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Description & Agenda</label>
                        <textarea name="description" id="evt_desc" class="form-control rounded-3 fs-8" rows="3" placeholder="Enter event details and meeting link..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4 fs-8 fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fs-8 fw-bold" style="background: #4338CA; border: none;">Save & Schedule Event</button>
                </div>
            </form>
        </div>
    </div>
</div>

<form id="deleteEventForm" action="" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
    function handleDayCellClick(e, dateStr) {
        openScheduleModal(dateStr);
    }

    function openScheduleModal(dateStr) {
        document.getElementById('eventModalTitle').textContent = 'Schedule New Event (' + dateStr + ')';
        document.getElementById('evt_date').value = dateStr;
        document.getElementById('evt_title').value = '';
        document.getElementById('evt_desc').value = '';

        const modal = new bootstrap.Modal(document.getElementById('scheduleEventModal'));
        modal.show();
    }

    function viewEventModal(id, title, desc, dateStr, type) {
        const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';

        Swal.fire({
            title: `<div class="fw-bold text-dark fs-5 mb-1">${title}</div>`,
            html: `
                <div class="text-center py-2">
                    <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary px-3 py-1.5 fs-8 fw-bold mb-3 d-inline-block">
                        <i class="bi bi-calendar-event me-1"></i> ${dateStr}
                    </span>
                    <p class="fs-7 text-secondary mb-0" style="line-height: 1.6;">
                        ${desc || 'No description provided.'}
                    </p>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: '<i class="bi bi-trash-fill me-1"></i> Delete Event',
            cancelButtonText: 'Close',
            confirmButtonColor: '#EF4444',
            cancelButtonColor: isDark ? '#4B5563' : '#64748B',
            background: isDark ? '#1F2937' : '#ffffff',
            color: isDark ? '#F8FAFC' : '#1E1B4B',
            customClass: {
                popup: 'rounded-4 border-0 shadow-lg p-4',
                confirmButton: 'px-4 py-2.5 rounded-pill fw-bold fs-7 shadow-sm',
                cancelButton: 'px-4 py-2.5 rounded-pill fw-bold fs-7'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                confirmDeleteEvent(id, title);
            }
        });
    }

    function confirmDeleteEvent(id, title) {
        const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
        
        Swal.fire({
            title: `<div class="d-flex align-items-center justify-content-center gap-2 text-danger fw-bold fs-5 mb-1">
                        <i class="bi bi-exclamation-triangle-fill fs-4"></i> Remove Event?
                    </div>`,
            html: `
                <div class="text-center py-2">
                    <p class="fs-7 text-secondary mb-3">
                        Are you sure you want to remove event <strong class="text-dark">${title}</strong> from the schedule?
                    </p>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: '<i class="bi bi-trash-fill me-1"></i> Yes, Remove',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#EF4444',
            cancelButtonColor: isDark ? '#4B5563' : '#64748B',
            background: isDark ? '#1F2937' : '#ffffff',
            color: isDark ? '#F8FAFC' : '#1E1B4B',
            customClass: {
                popup: 'rounded-4 border-0 shadow-lg p-4',
                confirmButton: 'px-4 py-2.5 rounded-pill fw-bold fs-7 shadow-sm',
                cancelButton: 'px-4 py-2.5 rounded-pill fw-bold fs-7'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('deleteEventForm');
                form.action = "{{ url('calendar/events') }}/" + id;
                form.submit();
            }
        });
    }
</script>
@endpush
