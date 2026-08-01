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

    .shift-hero {
        background: linear-gradient(-45deg, #312E81, #4338CA, #6366F1, #7C3AED);
        background-size: 300% 300%;
        animation: gradientMesh 12s ease infinite, fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        border-radius: 24px;
        padding: 2.25rem 2.5rem;
        color: #ffffff;
        margin-bottom: 1.75rem;
        box-shadow: 0 20px 45px rgba(49, 46, 129, 0.3);
        position: relative;
        overflow: hidden;
    }

    .shift-card {
        background: #ffffff;
        border-radius: 22px;
        border: 1px solid #EFEFF7;
        box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.05);
        padding: 1.65rem;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        animation: fadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) both;
    }

    .shift-card:hover {
        transform: translateY(-6px) scale(1.015);
        box-shadow: 0 20px 40px -5px rgba(99, 102, 241, 0.2);
        border-color: #C7D2FE;
    }
</style>
@endpush

@section('content')
<!-- Header -->
<div class="shift-hero">
    <div class="row align-items-center g-3">
        <div class="col-12 col-md-8">
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge rounded-pill bg-white bg-opacity-20 text-white fs-8 px-2.5 py-1">
                    <i class="bi bi-clock-fill me-1"></i> Shift Roster Control
                </span>
                <span class="fs-8 text-white-50">• {{ $shifts->count() }} Configured Shifts</span>
            </div>
            <h3 class="mb-1 fw-extrabold text-white" style="letter-spacing: -0.02em;">
                Workforce Shift Roster Management
            </h3>
            <p class="mb-0 text-white-50 fs-7">
                Configure work schedules, grace periods, night shift rules, and company shift assignments.
            </p>
        </div>
        <div class="col-12 col-md-4 text-md-end">
            <button class="btn btn-light rounded-pill px-4 py-2.5 fw-bold text-indigo shadow-sm" data-bs-toggle="modal" data-bs-target="#createShiftModal" style="color: #4F46E5;">
                <i class="bi bi-plus-circle-fill me-1.5 fs-6"></i> Add Shift Schedule
            </button>
        </div>
    </div>
</div>

<!-- Shift Cards Grid -->
<div class="row g-4">
    @forelse($shifts as $shift)
        <div class="col-12 col-md-6 col-xl-4">
            <div class="shift-card">
                <div>
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="badge rounded-pill {{ $shift->is_night_shift ? 'bg-purple-subtle text-purple border' : 'bg-primary-subtle text-primary border' }} px-3 py-1 fs-8 fw-bold" style="{{ $shift->is_night_shift ? 'background: #F3E8FF; color: #7C3AED;' : 'background: #EEF2FF; color: #4F46E5;' }}">
                            <i class="{{ $shift->is_night_shift ? 'bi bi-moon-stars-fill' : 'bi bi-sun-fill' }} me-1"></i>
                            {{ $shift->is_night_shift ? 'Night Shift' : 'Day Shift' }}
                        </span>
                        <div class="dropdown">
                            <button class="btn btn-light btn-sm rounded-circle" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 fs-7 p-2" style="border-radius: 14px; min-width: 160px;">
                                <li>
                                    <button class="dropdown-item rounded-2 py-1.5 fs-8" 
                                            onclick="editShiftModal('{{ $shift->id }}', '{{ $shift->company_id }}', '{{ addslashes($shift->name) }}', '{{ substr($shift->start_time, 0, 5) }}', '{{ substr($shift->end_time, 0, 5) }}', '{{ $shift->grace_minutes }}', '{{ $shift->break_minutes }}', {{ $shift->is_night_shift ? 'true' : 'false' }})">
                                        <i class="bi bi-pencil me-2 text-primary"></i> Edit Shift
                                    </button>
                                </li>
                                <li>
                                    <form action="{{ route('shifts.destroy', $shift->id) }}" method="POST" onsubmit="event.preventDefault(); confirmDeleteShift('{{ $shift->id }}', '{{ addslashes($shift->name) }}', this);">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item rounded-2 py-1.5 text-danger fs-8 fw-semibold">
                                            <i class="bi bi-trash me-2"></i> Delete Shift
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <h5 class="fw-extrabold text-dark mb-1 fs-6">{{ $shift->name }}</h5>
                    <div class="fs-8 text-muted mb-3"><i class="bi bi-building me-1"></i> {{ $shift->company?->name ?? 'All Companies' }}</div>

                    <div class="bg-light rounded-3 p-3 mb-3 border">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fs-8 text-muted">Working Hours</span>
                            <span class="fw-bold text-dark fs-8 font-monospace">{{ date('h:i A', strtotime($shift->start_time)) }} - {{ date('h:i A', strtotime($shift->end_time)) }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fs-8 text-muted">Grace Period</span>
                            <span class="badge bg-warning bg-opacity-10 text-warning px-2 py-0.5 fs-8 fw-bold">{{ $shift->grace_minutes }} mins</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fs-8 text-muted">Break Duration</span>
                            <span class="fs-8 fw-bold text-dark">{{ $shift->break_minutes }} mins</span>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center pt-2 border-top fs-8 text-muted">
                    <span><i class="bi bi-check-circle-fill text-success me-1"></i> Active Status</span>
                    <span class="fw-bold text-indigo">Active Schedule</span>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5 text-muted fs-7">
            <i class="bi bi-clock-history fs-2 d-block mb-2 text-slate-300"></i>
            <div class="fw-bold text-dark">No shift schedules configured yet</div>
            <p class="fs-8 text-muted mb-3">Click "Add Shift Schedule" to configure company work hours.</p>
        </div>
    @endforelse
</div>

<!-- Create / Edit Shift Modal -->
<div class="modal fade" id="createShiftModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom px-4 py-3">
                <h5 class="modal-title fw-bold fs-6 text-dark" id="shiftModalTitle">Create Shift Schedule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('shifts.store') }}" method="POST" id="shiftForm">
                @csrf
                <input type="hidden" name="_method" id="shiftMethod" value="POST">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Company Scope <span class="text-danger">*</span></label>
                        <select name="company_id" id="shift_company_id" class="form-select rounded-3 fs-8" required>
                            @foreach($companies as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Shift Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="shift_name" class="form-control rounded-3 fs-8" placeholder="e.g. General Morning Shift" required>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Start Time <span class="text-danger">*</span></label>
                            <input type="time" name="start_time" id="shift_start_time" class="form-control rounded-3 fs-8" value="09:00" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">End Time <span class="text-danger">*</span></label>
                            <input type="time" name="end_time" id="shift_end_time" class="form-control rounded-3 fs-8" value="18:00" required>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Grace Minutes</label>
                            <input type="number" name="grace_minutes" id="shift_grace_minutes" class="form-control rounded-3 fs-8" value="15" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Break Minutes</label>
                            <input type="number" name="break_minutes" id="shift_break_minutes" class="form-control rounded-3 fs-8" value="60" required>
                        </div>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_night_shift" id="shift_is_night_shift" value="1">
                        <label class="form-check-label fs-7 text-dark fw-bold" for="shift_is_night_shift">
                            Overnight / Night Shift Schedule
                        </label>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4 fs-8 fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fs-8 fw-bold" style="background: #4F46E5; border: none;">Save Shift Schedule</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function editShiftModal(id, companyId, name, startTime, endTime, grace, breakMins, isNight) {
        document.getElementById('shiftModalTitle').textContent = 'Edit Shift Schedule';
        document.getElementById('shiftForm').action = "{{ url('shifts') }}/" + id;
        document.getElementById('shiftMethod').value = 'PUT';

        document.getElementById('shift_company_id').value = companyId;
        document.getElementById('shift_name').value = name;
        document.getElementById('shift_start_time').value = startTime;
        document.getElementById('shift_end_time').value = endTime;
        document.getElementById('shift_grace_minutes').value = grace;
        document.getElementById('shift_break_minutes').value = breakMins;
        document.getElementById('shift_is_night_shift').checked = isNight;

        const modal = new bootstrap.Modal(document.getElementById('createShiftModal'));
        modal.show();
    }

    function confirmDeleteShift(shiftId, shiftName, formEl) {
        const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
        
        Swal.fire({
            title: `<div class="d-flex align-items-center justify-content-center gap-2 text-danger fw-bold fs-5 mb-1">
                        <i class="bi bi-exclamation-triangle-fill fs-4"></i> Delete Shift Schedule?
                    </div>`,
            html: `
                <div class="text-center py-2">
                    <p class="fs-7 text-secondary mb-3" style="line-height: 1.6;">
                        Are you sure you want to delete <strong class="text-dark">${shiftName}</strong>?
                    </p>
                    <div class="alert alert-danger border-0 fs-8 py-2.5 px-3 text-start mb-0 rounded-3" style="background: ${isDark ? '#374151' : '#FEF2F2'}; color: ${isDark ? '#F87171' : '#991B1B'};">
                        <i class="bi bi-shield-x me-1"></i>
                        Deleting this shift schedule will remove it from future shift assignments.
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: '<i class="bi bi-trash-fill me-1"></i> Yes, Delete Shift',
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
                formEl.submit();
            }
        });
    }
</script>
@endpush
