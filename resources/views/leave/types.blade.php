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

    .types-hero {
        background: linear-gradient(-45deg, #4338CA, #6366F1, #7C3AED, #4F46E5);
        background-size: 300% 300%;
        animation: gradientMesh 12s ease infinite, fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        border-radius: 24px;
        padding: 2.25rem 2.5rem;
        color: #ffffff;
        margin-bottom: 1.75rem;
        box-shadow: 0 20px 45px rgba(99, 102, 241, 0.3);
    }

    /* Refined Image-Style Soft Pastel Cards */
    .pastel-ui8-card {
        border-radius: 20px;
        padding: 1.35rem 1.4rem;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 210px;
        position: relative;
        border: 1px solid transparent;
        animation: fadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) both;
    }

    .pastel-ui8-card:hover {
        transform: translateY(-6px) scale(1.015);
        box-shadow: 0 18px 35px rgba(0, 0, 0, 0.08);
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
        padding: 0.35rem 0.9rem;
        border-radius: 999px;
        font-weight: 800;
        font-size: 0.85rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
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
        padding: 0.22rem 0.65rem;
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
</style>
@endpush

@section('content')
<!-- Header -->
<div class="types-hero">
    <div class="row align-items-center g-3">
        <div class="col-12 col-md-8">
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge rounded-pill bg-white bg-opacity-20 text-white fs-8 px-2.5 py-1">
                    <i class="bi bi-gear-fill me-1"></i> Leave Master Setup
                </span>
                <span class="fs-8 text-white-50">• {{ $types->count() }} Configured Categories</span>
            </div>
            <h3 class="mb-1 fw-extrabold text-white" style="letter-spacing: -0.02em;">
                Leave Category & Policy Management
            </h3>
            <p class="mb-0 text-white-50 fs-7">
                Configure annual leave quotas, paid leave policies, and carry-forward limits.
            </p>
        </div>
        <div class="col-12 col-md-4 text-md-end">
            <button class="btn btn-light rounded-pill px-4 py-2.5 fw-bold text-indigo shadow-sm" data-bs-toggle="modal" data-bs-target="#createLeaveTypeModal" style="color: #4F46E5;">
                <i class="bi bi-plus-circle-fill me-1.5 fs-6"></i> Add Leave Type
            </button>
        </div>
    </div>
</div>

<!-- Leave Type Cards Grid (All 4 Cards in 1 Row matching Reference Image Design) -->
<div class="row g-3">
    @php
        $pastelClasses = ['card-pastel-emerald', 'card-pastel-amber', 'card-pastel-purple', 'card-pastel-indigo'];
        $pillColors = ['#059669', '#D97706', '#7C3AED', '#0284C7'];
    @endphp

    @forelse($types as $index => $t)
        @php
            $pastelClass = $pastelClasses[$index % count($pastelClasses)];
            $pillColor = $pillColors[$index % count($pillColors)];
        @endphp

        <div class="col-12 col-md-6 col-xl-3">
            <div class="pastel-ui8-card {{ $pastelClass }}">
                <div>
                    <!-- Top Row: Icon + Target & Elevated White Value Pill -->
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="fs-8 text-secondary fw-semibold">
                            <i class="bi bi-calendar-event me-1"></i> Target Quota
                        </span>
                        <span class="ui8-pill-val" style="color: {{ $pillColor }};">
                            {{ $t->days_per_year }} Days
                        </span>
                    </div>

                    <!-- Main Title & Company Subtitle -->
                    <h4 class="ui8-card-title">{{ $t->name }}</h4>
                    <div class="ui8-card-sub mb-3">
                        <i class="bi bi-building me-1 opacity-75"></i> {{ $t->company?->name ?? 'All Companies' }}
                    </div>

                    <!-- Policy Data Info Box -->
                    <div class="bg-white bg-opacity-60 rounded-3 p-2.5 mb-3 border border-white border-opacity-50">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fs-8 text-secondary fw-semibold">Paid Status</span>
                            <span class="badge {{ $t->is_paid ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }} px-2 py-0.5 fs-8 fw-bold">
                                {{ $t->is_paid ? 'Paid Leave' : 'Unpaid' }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fs-8 text-secondary fw-semibold">Carry Forward</span>
                            <span class="fs-8 fw-bold text-dark font-monospace">
                                {{ $t->carry_forward ? 'Max ' . $t->max_carry_forward_days . 'd' : 'None' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Bottom Row: Dropdown Actions & White Pill Hashtag Tags -->
                <div class="d-flex justify-content-between align-items-center pt-2 border-top border-white border-opacity-40">
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown" style="width: 32px; height: 32px; padding: 0;">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu shadow-lg border-0 fs-7 p-2" style="border-radius: 14px; min-width: 160px;">
                            <li>
                                <button class="dropdown-item rounded-2 py-1.5 fs-8" 
                                        onclick="editLeaveTypeModal('{{ $t->id }}', '{{ $t->company_id }}', '{{ addslashes($t->name) }}', '{{ $t->color }}', '{{ $t->days_per_year }}', {{ $t->carry_forward ? 'true' : 'false' }}, '{{ $t->max_carry_forward_days }}', {{ $t->is_paid ? 'true' : 'false' }})">
                                    <i class="bi bi-pencil me-2 text-primary"></i> Edit Type
                                </button>
                            </li>
                            <li>
                                <form action="{{ route('leave-types.destroy', $t->id) }}" method="POST" onsubmit="event.preventDefault(); confirmDeleteLeaveType('{{ $t->id }}', '{{ addslashes($t->name) }}', this);">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item rounded-2 py-1.5 text-danger fs-8 fw-semibold">
                                        <i class="bi bi-trash me-2"></i> Delete Category
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>

                    <div class="d-flex gap-1">
                        <span class="ui8-tag-chip">#{{ $t->is_paid ? 'Paid' : 'Unpaid' }}</span>
                        <span class="ui8-tag-chip">#{{ $t->carry_forward ? 'CarryForward' : 'AnnualQuota' }}</span>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5 text-muted fs-7">
            <i class="bi bi-gear fs-2 d-block mb-2 text-slate-300"></i>
            <div class="fw-bold text-dark">No leave categories defined</div>
            <p class="fs-8 text-muted mb-3">Click "Add Leave Type" to create organization leave quotas.</p>
        </div>
    @endforelse
</div>

<!-- Create / Edit Leave Type Modal -->
<div class="modal fade" id="createLeaveTypeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom px-4 py-3">
                <h5 class="modal-title fw-bold fs-6 text-dark" id="leaveTypeModalTitle">Create Leave Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('leave-types.store') }}" method="POST" id="leaveTypeForm">
                @csrf
                <input type="hidden" name="_method" id="leaveTypeMethod" value="POST">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Company Scope <span class="text-danger">*</span></label>
                        <select name="company_id" id="lt_company_id" class="form-select rounded-3 fs-8" required>
                            @foreach($companies as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-8">
                            <label class="form-label fw-bold fs-7 text-dark">Category Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="lt_name" class="form-control rounded-3 fs-8" placeholder="e.g. Annual Vacation Leave" required>
                        </div>
                        <div class="col-4">
                            <label class="form-label fw-bold fs-7 text-dark">Theme Color</label>
                            <input type="color" name="color" id="lt_color" class="form-control form-control-color w-100 rounded-3" value="#10B981">
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Annual Days <span class="text-danger">*</span></label>
                            <input type="number" name="days_per_year" id="lt_days_per_year" class="form-control rounded-3 fs-8" value="14" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Max Carry Days</label>
                            <input type="number" name="max_carry_forward_days" id="lt_max_carry" class="form-control rounded-3 fs-8" value="5">
                        </div>
                    </div>

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="carry_forward" id="lt_carry_forward" value="1">
                        <label class="form-check-label fs-7 text-dark fw-bold" for="lt_carry_forward">
                            Allow Carry Forward to Next Year
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_paid" id="lt_is_paid" value="1" checked>
                        <label class="form-check-label fs-7 text-dark fw-bold" for="lt_is_paid">
                            Paid Leave Policy
                        </label>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4 fs-8 fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fs-8 fw-bold" style="background: #4F46E5; border: none;">Save Leave Type</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function editLeaveTypeModal(id, companyId, name, color, days, carry, maxCarry, isPaid) {
        document.getElementById('leaveTypeModalTitle').textContent = 'Edit Leave Category';
        document.getElementById('leaveTypeForm').action = "{{ url('leave-types') }}/" + id;
        document.getElementById('leaveTypeMethod').value = 'PUT';

        document.getElementById('lt_company_id').value = companyId;
        document.getElementById('lt_name').value = name;
        document.getElementById('lt_color').value = color;
        document.getElementById('lt_days_per_year').value = days;
        document.getElementById('lt_carry_forward').checked = carry;
        document.getElementById('lt_max_carry').value = maxCarry;
        document.getElementById('lt_is_paid').checked = isPaid;

        const modal = new bootstrap.Modal(document.getElementById('createLeaveTypeModal'));
        modal.show();
    }

    function confirmDeleteLeaveType(id, name, formEl) {
        const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
        
        Swal.fire({
            title: `<div class="d-flex align-items-center justify-content-center gap-2 text-danger fw-bold fs-5 mb-1">
                        <i class="bi bi-exclamation-triangle-fill fs-4"></i> Delete Leave Category?
                    </div>`,
            html: `
                <div class="text-center py-2">
                    <p class="fs-7 text-secondary mb-3" style="line-height: 1.6;">
                        Are you sure you want to delete <strong class="text-dark">${name}</strong>?
                    </p>
                    <div class="alert alert-danger border-0 fs-8 py-2.5 px-3 text-start mb-0 rounded-3" style="background: ${isDark ? '#374151' : '#FEF2F2'}; color: ${isDark ? '#F87171' : '#991B1B'};">
                        <i class="bi bi-trash me-1"></i>
                        Deleting this leave category will remove its associated allocations.
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: '<i class="bi bi-trash-fill me-1"></i> Yes, Delete Category',
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
