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

    .apply-hero {
        background: linear-gradient(-45deg, #059669, #10B981, #0D9488, #047857);
        background-size: 300% 300%;
        animation: gradientMesh 12s ease infinite, fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        border-radius: 24px;
        padding: 2.25rem 2.5rem;
        color: #ffffff;
        margin-bottom: 1.75rem;
        box-shadow: 0 20px 45px rgba(16, 185, 129, 0.3);
    }

    .form-card-container {
        background: #ffffff;
        border-radius: 24px;
        border: 1px solid #EFEFF7;
        box-shadow: 0 15px 40px -10px rgba(0, 0, 0, 0.07);
        overflow: hidden;
        position: relative;
        animation: fadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) both;
    }

    .form-card-container::before {
        content: '';
        display: block;
        height: 6px;
        background: linear-gradient(90deg, #10B981 0%, #059669 50%, #047857 100%);
    }

    /* Dark Mode Form Overrides */
    [data-bs-theme="dark"] .form-card-container {
        background: #1F2937 !important;
        border-color: #374151 !important;
    }
</style>
@endpush

@section('content')
<!-- Apply Leave Header -->
<div class="apply-hero">
    <div class="d-flex align-items-center gap-2 mb-1">
        <span class="badge rounded-pill bg-white bg-opacity-20 text-white fs-8 px-2.5 py-1">
            <i class="bi bi-send-fill me-1"></i> Leave Application Wizard
        </span>
        <span class="fs-8 text-white-50">• {{ $employee?->full_name ?? 'Staff Member' }}</span>
    </div>
    <h3 class="mb-1 fw-extrabold text-white" style="letter-spacing: -0.02em;">
        Submit New Leave Application
    </h3>
    <p class="mb-0 text-white-50 fs-7">
        Select your leave category, set dates, and specify the reason for your leave request.
    </p>
</div>

<div class="row g-4">
    <div class="col-12 col-lg-8">
        <div class="form-card-container p-4 p-md-5">
            <form action="{{ route('leave.store') }}" method="POST" id="leaveApplyForm">
                @csrf
                <input type="hidden" name="employee_id" value="{{ $employee?->id }}">

                <div class="mb-4">
                    <label class="form-label fw-bold text-dark fs-7">Select Leave Category <span class="text-danger">*</span></label>
                    <select name="leave_type_id" id="leave_type_id" class="form-select rounded-3 p-3 fs-8 fw-semibold" required>
                        <option value="">-- Choose Leave Category --</option>
                        @foreach($leaveTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }} ({{ $type->days_per_year }} Days / Year)</option>
                        @endforeach
                    </select>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-bold text-dark fs-7">Start Date <span class="text-danger">*</span></label>
                        <input type="date" name="start_date" id="start_date" class="form-control rounded-3 p-3 fs-8 fw-semibold" value="{{ date('Y-m-d') }}" onchange="calculateDays()" required>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-bold text-dark fs-7">End Date <span class="text-danger">*</span></label>
                        <input type="date" name="end_date" id="end_date" class="form-control rounded-3 p-3 fs-8 fw-semibold" value="{{ date('Y-m-d') }}" onchange="calculateDays()" required>
                    </div>
                </div>

                <div class="bg-light rounded-4 p-3 mb-4 border d-flex justify-content-between align-items-center">
                    <span class="fs-8 text-muted fw-bold">Computed Leave Duration:</span>
                    <span class="badge bg-emerald text-white rounded-pill px-3 py-1.5 fs-7 fw-extrabold" id="daysCountBadge" style="background: #059669;">
                        1 Day Requested
                    </span>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-dark fs-7">Reason / Explanation <span class="text-danger">*</span></label>
                    <textarea name="reason" rows="4" class="form-control rounded-3 p-3 fs-8" placeholder="Provide a detailed explanation for your leave request..." required></textarea>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                    <a href="{{ route('leave.my') }}" class="btn btn-light rounded-pill px-4 py-2.5 fs-8 fw-bold">Cancel</a>
                    <button type="submit" class="btn btn-emerald rounded-pill px-5 py-2.5 fs-8 fw-bold text-white shadow-sm" style="background: #059669; border: none;">
                        <i class="bi bi-send-check-fill me-1.5"></i> Submit Application
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Leave Balance Sidebar Preview -->
    <div class="col-12 col-lg-4">
        <div class="card rounded-4 border-0 shadow-sm p-4">
            <h6 class="fw-extrabold text-dark mb-3">Your Quota Balances</h6>
            @forelse($balances as $bal)
                <div class="p-3 bg-light rounded-3 mb-2.5 border">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="fw-bold text-dark fs-8">{{ $bal->leaveType?->name }}</span>
                        <span class="badge rounded-pill bg-white text-dark border px-2 py-0.5 fs-8 font-monospace fw-bold">
                            {{ $bal->remaining_days }} Left
                        </span>
                    </div>
                    <div class="progress" style="height: 5px;">
                        <div class="progress-bar bg-success" style="width: {{ $bal->allocated_days > 0 ? round(($bal->remaining_days / $bal->allocated_days) * 100) : 0 }}%;"></div>
                    </div>
                </div>
            @empty
                <div class="text-muted fs-8">No leave quota balances initialized.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function calculateDays() {
        const start = new Date(document.getElementById('start_date').value);
        const end = new Date(document.getElementById('end_date').value);

        if (start && end && end >= start) {
            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            document.getElementById('daysCountBadge').textContent = `${diffDays} ${diffDays === 1 ? 'Day' : 'Days'} Requested`;
        }
    }
</script>
@endpush
