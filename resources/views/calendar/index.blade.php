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

    .calendar-hero {
        background: linear-gradient(-45deg, #1E1B4B, #312E81, #4338CA, #6366F1);
        background-size: 300% 300%;
        animation: gradientMesh 12s ease infinite, fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        border-radius: 24px;
        padding: 2.25rem 2.5rem;
        color: #ffffff;
        margin-bottom: 1.75rem;
        box-shadow: 0 20px 45px rgba(30, 27, 75, 0.3);
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

    /* Calendar Control Bar & Grid */
    .calendar-container-card {
        background: #ffffff;
        border-radius: 22px;
        border: 1px solid #EFEFF7;
        box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        animation: fadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) both;
    }

    .calendar-header-toolbar {
        background: #F8FAFC;
        padding: 1.15rem 1.5rem;
        border-bottom: 1.5px solid #E2E8F0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .calendar-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin-bottom: 0;
    }

    .calendar-table th {
        background: #F1F5F9;
        font-size: 0.72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #475569;
        text-align: center;
        padding: 0.85rem 0.5rem;
        border-bottom: 1.5px solid #E2E8F0;
        border-right: 1px solid #E2E8F0;
    }

    .calendar-table th:last-child {
        border-right: none;
    }

    .calendar-day-cell {
        height: 125px;
        vertical-align: top;
        padding: 0.65rem;
        border-bottom: 1px solid #F1F5F9;
        border-right: 1px solid #F1F5F9;
        background: #ffffff;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        cursor: pointer;
    }

    .calendar-day-cell:hover {
        background: #F0F4FF !important;
        box-shadow: inset 0 0 0 2px #4F46E5;
    }

    .calendar-day-cell:hover .add-event-hint {
        opacity: 1;
        transform: scale(1);
    }

    .calendar-day-cell.weekend {
        background: #FAFAFA;
    }

    .calendar-day-cell.other-month {
        background: #F8FAFC;
        opacity: 0.5;
    }

    .day-number-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.4rem;
    }

    .day-number {
        font-size: 0.85rem;
        font-weight: 800;
        color: #334155;
        display: inline-block;
    }

    .day-number.today {
        background: #4338CA;
        color: #ffffff;
        width: 26px;
        height: 26px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(67, 56, 202, 0.3);
    }

    .add-event-hint {
        opacity: 0;
        font-size: 0.7rem;
        font-weight: 700;
        color: #4F46E5;
        transition: all 0.2s ease;
        transform: scale(0.8);
    }

    /* Event Badge Items */
    .event-chip-pill {
        font-size: 0.7rem;
        font-weight: 700;
        padding: 0.25rem 0.55rem;
        border-radius: 8px;
        margin-bottom: 0.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .event-chip-pill:hover {
        transform: scale(1.02);
    }

    .event-chip-pill.red {
        background: #FEE2E2;
        color: #991B1B;
        border-left: 3px solid #EF4444;
    }

    .event-chip-pill.indigo {
        background: #EEF2FF;
        color: #3730A3;
        border-left: 3px solid #6366F1;
    }

    .event-chip-pill.emerald {
        background: #ECFDF5;
        color: #065F46;
        border-left: 3px solid #10B981;
    }

    .event-chip-pill.amber {
        background: #FEF3C7;
        color: #92400E;
        border-left: 3px solid #F59E0B;
    }

    /* Dark Mode Overrides */
    [data-bs-theme="dark"] .pastel-ui8-card,
    [data-bs-theme="dark"] .calendar-container-card {
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
    [data-bs-theme="dark"] .calendar-day-cell {
        background: #1F2937 !important;
        border-color: #374151 !important;
    }
    [data-bs-theme="dark"] .calendar-day-cell:hover {
        background: #374151 !important;
    }
    [data-bs-theme="dark"] .day-number {
        color: #F8FAFC !important;
    }
</style>
@endpush

@section('content')
<!-- Hero Header -->
<div class="calendar-hero">
    <div class="row align-items-center g-3">
        <div class="col-12 col-md-8">
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge rounded-pill bg-white bg-opacity-20 text-white fs-8 px-2.5 py-1">
                    <i class="bi bi-calendar3 me-1"></i> Master Organization Calendar
                </span>
                <span class="fs-8 text-white-50">• Year {{ $year }}</span>
            </div>
            <h3 class="mb-1 fw-extrabold text-white" style="letter-spacing: -0.02em;">
                Company Master Schedule & Events
            </h3>
            <p class="mb-0 text-white-50 fs-7">
                Click any calendar date cell to schedule an event for that specific day.
            </p>
        </div>
        <div class="col-12 col-md-4 text-md-end">
            <button class="btn btn-light rounded-pill px-4 py-2.5 fw-bold text-indigo shadow-sm"
                    onclick="openScheduleModal('{{ date('Y-m-d') }}')" style="color: #4F46E5;">
                <i class="bi bi-calendar-plus-fill me-1.5 fs-6"></i> Schedule New Event
            </button>
        </div>
    </div>
</div>

<!-- Image-Style Soft Pastel KPI Cards (4 Cards in 1 Row) -->
<div class="row g-3 mb-4">
    <!-- Card 1: Month Events (Soft Sky Blue) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-indigo">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-calendar-event me-1"></i> Month Schedule
                    </span>
                    <span class="ui8-pill-val" style="color: #0284C7;">
                        {{ $stats['total_events'] }} Events
                    </span>
                </div>
                <h4 class="ui8-card-title">Events This Month</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> {{ $monthName }} {{ $year }}
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-info shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-calendar-check"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Events</span>
                    <span class="ui8-tag-chip">#Schedule</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Public Holidays (Soft Amber) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-amber">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-flag-fill me-1"></i> Public Holidays
                    </span>
                    <span class="ui8-pill-val" style="color: #D97706;">
                        {{ $stats['holidays_count'] }} Holidays
                    </span>
                </div>
                <h4 class="ui8-card-title">Official Holidays</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Office Closures
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-warning shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-flag-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Holidays</span>
                    <span class="ui8-tag-chip">#Official</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Sprint Review (Soft Emerald) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-emerald">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-kanban me-1"></i> Milestone Deadlines
                    </span>
                    <span class="ui8-pill-val" style="color: #059669;">
                        {{ $stats['sprints_count'] }} Sprints
                    </span>
                </div>
                <h4 class="ui8-card-title">Project Milestones</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Key Deliverables
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-success shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-lightning-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Sprints</span>
                    <span class="ui8-tag-chip">#Milestones</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Status (Soft Purple) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-purple">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-calendar-plus me-1"></i> Interactive
                    </span>
                    <span class="ui8-pill-val" style="color: #7C3AED;">
                        Click Date
                    </span>
                </div>
                <h4 class="ui8-card-title">Click Date to Add</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Instant Event Popups
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-purple shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800; color: #7C3AED;">
                        <i class="bi bi-cursor-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Clickable</span>
                    <span class="ui8-tag-chip">#Interactive</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Master Calendar Card -->
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
            <div class="btn-group btn-group-sm">
                <a href="{{ route('calendar.index', ['month' => $prevM, 'year' => $prevY]) }}" class="btn btn-white border fw-bold text-dark"><i class="bi bi-chevron-left"></i></a>
                <a href="{{ route('calendar.index', ['month' => $nextM, 'year' => $nextY]) }}" class="btn btn-white border fw-bold text-dark"><i class="bi bi-chevron-right"></i></a>
            </div>
            <h4 class="fw-extrabold text-dark mb-0" style="letter-spacing: -0.02em;">{{ $monthName }} {{ $year }}</h4>
            <span class="badge bg-indigo bg-opacity-10 text-indigo px-3 py-1 rounded-pill fs-8 fw-bold" style="background: #EEF2FF; color: #4338CA;">
                <i class="bi bi-clock me-1"></i> Today: July 25, 2026
            </span>
        </div>

        <div class="d-flex align-items-center gap-2">
            <span class="fs-8 text-muted fw-bold">
                <i class="bi bi-info-circle me-1"></i> Click any grid box below to schedule an event for that date
            </span>
        </div>
    </div>

    <!-- Calendar Month Table -->
    <div class="table-responsive">
        <table class="calendar-table">
            <thead>
                <tr>
                    <th style="width: 14.28%;">Sun</th>
                    <th style="width: 14.28%;">Mon</th>
                    <th style="width: 14.28%;">Tue</th>
                    <th style="width: 14.28%;">Wed</th>
                    <th style="width: 14.28%;">Thu</th>
                    <th style="width: 14.28%;">Fri</th>
                    <th style="width: 14.28%;">Sat</th>
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

                                @foreach($dayEvents as $ev)
                                    <div class="event-chip-pill {{ $ev->type }}" 
                                         onclick="event.stopPropagation(); viewEventModal('{{ $ev->id }}', '{{ addslashes($ev->title) }}', '{{ addslashes($ev->description) }}', '{{ $ev->event_date->format('M d, Y') }}', '{{ $ev->type }}')">
                                        <span>{{ $ev->title }}</span>
                                        <i class="bi bi-trash-fill fs-8 text-danger ms-1 opacity-75" onclick="event.stopPropagation(); confirmDeleteEvent('{{ $ev->id }}', '{{ addslashes($ev->title) }}');" title="Delete Event"></i>
                                    </div>
                                @endforeach
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
