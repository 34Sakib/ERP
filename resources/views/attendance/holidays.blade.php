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

    .holiday-hero {
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

    .holiday-card {
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
<!-- Header -->
<div class="holiday-hero">
    <div class="row align-items-center g-3">
        <div class="col-12 col-md-8">
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge rounded-pill bg-white bg-opacity-20 text-white fs-8 px-2.5 py-1">
                    <i class="bi bi-calendar-heart-fill me-1"></i> Public Holiday Calendar
                </span>
                <span class="fs-8 text-white-50">• {{ $holidays->count() }} Public Holidays</span>
            </div>
            <h3 class="mb-1 fw-extrabold text-white" style="letter-spacing: -0.02em;">
                Company Holiday Calendar & Schedule
            </h3>
            <p class="mb-0 text-white-50 fs-7">
                Manage organization public holidays, branch-specific closures, and annual recurring dates.
            </p>
        </div>
        <div class="col-12 col-md-4 text-md-end">
            <button class="btn btn-light rounded-pill px-4 py-2.5 fw-bold text-emerald shadow-sm" data-bs-toggle="modal" data-bs-target="#createHolidayModal" style="color: #059669;">
                <i class="bi bi-plus-circle-fill me-1.5 fs-6"></i> Add Holiday Date
            </button>
        </div>
    </div>
</div>

<!-- Holiday List Table -->
<div class="holiday-card">
    <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light bg-opacity-50">
        <div class="fs-8 text-muted fw-bold">
            Official Organization Holiday Schedule (<strong class="text-dark">{{ date('Y') }}</strong>)
        </div>
        <span class="badge bg-success bg-opacity-10 text-success px-3 py-1.5 rounded-pill fs-8 fw-bold">
            <i class="bi bi-calendar-check me-1"></i> Active Calendar
        </span>
    </div>

    <div class="table-responsive">
        <table class="table table-directory align-middle mb-0 fs-7">
            <thead>
                <tr>
                    <th>HOLIDAY NAME</th>
                    <th>DATE</th>
                    <th>DAY OF WEEK</th>
                    <th>APPLICABLE BRANCH / COMPANY</th>
                    <th>RECURRING</th>
                    <th class="text-end pe-3">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($holidays as $h)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2.5">
                                <div class="p-2 bg-emerald-500 bg-opacity-10 text-emerald rounded-3 fs-5" style="background: #ECFDF5; color: #059669;">
                                    <i class="bi bi-calendar-event-fill"></i>
                                </div>
                                <div class="fw-bold text-dark fs-7">{{ $h->name }}</div>
                            </div>
                        </td>
                        <td class="fw-bold text-dark fs-8 font-monospace">
                            {{ $h->date->format('F d, Y') }}
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border px-2.5 py-1 fs-8 fw-semibold">
                                {{ $h->date->format('l') }}
                            </span>
                        </td>
                        <td>
                            <span class="badge rounded-pill bg-primary-subtle text-primary border px-2.5 py-1 fs-8" style="background: #EEF2FF; color: #4F46E5;">
                                <i class="bi bi-building me-1"></i> {{ $h->branch?->name ?? 'All Branches' }}
                            </span>
                        </td>
                        <td>
                            @if($h->is_recurring)
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1 rounded-pill fs-8">Annual Recurring</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary px-2.5 py-1 rounded-pill fs-8">One-Time Date</span>
                            @endif
                        </td>
                        <td class="text-end pe-3">
                            <div class="d-flex justify-content-end align-items-center gap-1.5">
                                <button class="btn btn-sm btn-light rounded-circle text-primary" 
                                        onclick="editHolidayModal('{{ $h->id }}', '{{ $h->company_id }}', '{{ $h->branch_id }}', '{{ addslashes($h->name) }}', '{{ $h->date->format('Y-m-d') }}', {{ $h->is_recurring ? 'true' : 'false' }})"
                                        title="Edit Holiday">
                                    <i class="bi bi-pencil-fill fs-8"></i>
                                </button>
                                <form action="{{ route('holidays.destroy', $h->id) }}" method="POST" onsubmit="event.preventDefault(); confirmDeleteHoliday('{{ $h->id }}', '{{ addslashes($h->name) }}', '{{ $h->date->format('M d, Y') }}', this);">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light rounded-circle text-danger" title="Delete Holiday">
                                        <i class="bi bi-trash-fill fs-8"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted fs-7">
                            <i class="bi bi-calendar-x fs-2 d-block mb-2 text-slate-300"></i>
                            <div class="fw-bold text-dark">No holidays scheduled in calendar</div>
                            <p class="fs-8 text-muted mb-3">Click "Add Holiday Date" to register public holidays.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Create / Edit Holiday Modal -->
<div class="modal fade" id="createHolidayModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom px-4 py-3">
                <h5 class="modal-title fw-bold fs-6 text-dark" id="holidayModalTitle">Add Holiday Date</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('holidays.store') }}" method="POST" id="holidayForm">
                @csrf
                <input type="hidden" name="_method" id="holidayMethod" value="POST">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Company Scope <span class="text-danger">*</span></label>
                        <select name="company_id" id="holiday_company_id" class="form-select rounded-3 fs-8" required>
                            @foreach($companies as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Branch Scope</label>
                        <select name="branch_id" id="holiday_branch_id" class="form-select rounded-3 fs-8">
                            <option value="">All Branches</option>
                            @foreach($branches as $b)
                                <option value="{{ $b->id }}">{{ $b->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Holiday Title / Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="holiday_name" class="form-control rounded-3 fs-8" placeholder="e.g. Independence Day Celebration" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Holiday Date <span class="text-danger">*</span></label>
                        <input type="date" name="date" id="holiday_date" class="form-control rounded-3 fs-8" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_recurring" id="holiday_is_recurring" value="1">
                        <label class="form-check-label fs-7 text-dark fw-bold" for="holiday_is_recurring">
                            Annual Recurring Holiday (Every Year)
                        </label>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4 fs-8 fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-emerald rounded-pill px-4 fs-8 fw-bold text-white" style="background: #059669; border: none;">Save Holiday</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function editHolidayModal(id, companyId, branchId, name, date, isRecurring) {
        document.getElementById('holidayModalTitle').textContent = 'Edit Holiday Details';
        document.getElementById('holidayForm').action = "{{ url('holidays') }}/" + id;
        document.getElementById('holidayMethod').value = 'PUT';

        document.getElementById('holiday_company_id').value = companyId;
        document.getElementById('holiday_branch_id').value = branchId;
        document.getElementById('holiday_name').value = name;
        document.getElementById('holiday_date').value = date;
        document.getElementById('holiday_is_recurring').checked = isRecurring;

        const modal = new bootstrap.Modal(document.getElementById('createHolidayModal'));
        modal.show();
    }

    function confirmDeleteHoliday(holidayId, holidayName, dateStr, formEl) {
        const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
        
        Swal.fire({
            title: `<div class="d-flex align-items-center justify-content-center gap-2 text-danger fw-bold fs-5 mb-1">
                        <i class="bi bi-exclamation-triangle-fill fs-4"></i> Delete Holiday Date?
                    </div>`,
            html: `
                <div class="text-center py-2">
                    <p class="fs-7 text-secondary mb-3" style="line-height: 1.6;">
                        Are you sure you want to delete <strong class="text-dark">${holidayName}</strong> (<code class="text-primary">${dateStr}</code>)?
                    </p>
                    <div class="alert alert-danger border-0 fs-8 py-2.5 px-3 text-start mb-0 rounded-3" style="background: ${isDark ? '#374151' : '#FEF2F2'}; color: ${isDark ? '#F87171' : '#991B1B'};">
                        <i class="bi bi-calendar-x me-1"></i>
                        Deleting this holiday date will restore normal working schedule calculations.
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: '<i class="bi bi-trash-fill me-1"></i> Yes, Delete Holiday',
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
