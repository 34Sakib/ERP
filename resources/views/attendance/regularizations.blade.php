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

    .regularization-hero {
        background: linear-gradient(-45deg, #D97706, #F59E0B, #B45309, #92400E);
        background-size: 300% 300%;
        animation: gradientMesh 12s ease infinite, fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        border-radius: 24px;
        padding: 2.25rem 2.5rem;
        color: #ffffff;
        margin-bottom: 1.75rem;
        box-shadow: 0 20px 45px rgba(217, 119, 6, 0.3);
        position: relative;
        overflow: hidden;
    }

    .regularization-card {
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
        box-shadow: inset 3px 0 0 #F59E0B;
    }

    .table-directory tbody td {
        padding: 1rem 1.25rem;
        vertical-align: middle;
    }
</style>
@endpush

@section('content')
<!-- Header -->
<div class="regularization-hero">
    <div class="row align-items-center g-3">
        <div class="col-12 col-md-8">
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge rounded-pill bg-white bg-opacity-20 text-white fs-8 px-2.5 py-1">
                    <i class="bi bi-shield-plus me-1"></i> Attendance Regularization Queue
                </span>
                <span class="fs-8 text-white-50">• {{ $regularizations->total() }} Total Requests</span>
            </div>
            <h3 class="mb-1 fw-extrabold text-white" style="letter-spacing: -0.02em;">
                Attendance Regularization Requests
            </h3>
            <p class="mb-0 text-white-50 fs-7">
                Review, approve, or reject employee punch regularization and late arrival justification requests.
            </p>
        </div>
        <div class="col-12 col-md-4 text-md-end">
            <button class="btn btn-light rounded-pill px-4 py-2.5 fw-bold text-amber shadow-sm" data-bs-toggle="modal" data-bs-target="#createRegularizationModal" style="color: #D97706;">
                <i class="bi bi-plus-circle-fill me-1.5 fs-6"></i> Submit Request
            </button>
        </div>
    </div>
</div>

<!-- Regularization Table Card -->
<div class="regularization-card">
    <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light bg-opacity-50">
        <div class="fs-8 text-muted fw-bold">
            Showing <strong class="text-dark">{{ $regularizations->firstItem() ?? 0 }} - {{ $regularizations->lastItem() ?? 0 }}</strong> of <strong class="text-dark">{{ $regularizations->total() }}</strong> Regularization Requests
        </div>
        <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-1.5 rounded-pill fs-8 fw-bold">
            <i class="bi bi-clock-history me-1"></i> Approval Queue
        </span>
    </div>

    <div class="table-responsive">
        <table class="table table-directory align-middle mb-0 fs-7">
            <thead>
                <tr>
                    <th>EMPLOYEE APPLICANT</th>
                    <th>REQUESTED SHIFT TIMES</th>
                    <th>REASON / JUSTIFICATION</th>
                    <th>STATUS</th>
                    <th>DECISION BY</th>
                    <th class="text-end pe-3">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($regularizations as $reg)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2.5">
                                <img src="{{ $reg->employee?->avatar_url }}" 
                                     class="rounded-circle shadow-sm" style="width: 38px; height: 38px; object-fit: cover;">
                                <div>
                                    <div class="fw-bold text-dark">{{ $reg->employee->full_name }}</div>
                                    <div class="fs-8 text-muted"><code class="text-primary">{{ $reg->employee->employee_code }}</code> • {{ $reg->employee->department?->name ?? 'General' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold text-dark fs-8 font-monospace">
                                <i class="bi bi-calendar-event me-1 text-primary"></i>{{ $reg->requested_check_in->format('M d, Y') }}
                            </div>
                            <div class="fs-8 text-muted font-monospace">
                                {{ $reg->requested_check_in->format('h:i A') }} - {{ $reg->requested_check_out->format('h:i A') }}
                            </div>
                        </td>
                        <td>
                            <div class="fs-8 text-dark text-truncate" style="max-width: 220px;" title="{{ $reg->reason }}">
                                {{ $reg->reason }}
                            </div>
                        </td>
                        <td>
                            @if($reg->status === 'pending')
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2.5 py-1 rounded-pill fs-8">Pending Approval</span>
                            @elseif($reg->status === 'approved')
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1 rounded-pill fs-8">Approved</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2.5 py-1 rounded-pill fs-8">Rejected</span>
                            @endif
                        </td>
                        <td>
                            @if($reg->approver)
                                <div class="fs-8 fw-bold text-dark">{{ $reg->approver->name }}</div>
                                <div class="fs-8 text-muted">{{ $reg->approved_at?->format('M d, h:i A') }}</div>
                            @else
                                <span class="text-muted fs-8">Awaiting Review</span>
                            @endif
                        </td>
                        <td class="text-end pe-3">
                            @if($reg->status === 'pending')
                                <div class="d-flex justify-content-end align-items-center gap-1.5">
                                    <button type="button" class="btn btn-sm btn-success rounded-pill px-3 fs-8 fw-bold"
                                            onclick="openApproveEditModal('{{ $reg->id }}', '{{ route('attendance.regularizations.approve', $reg->id) }}', '{{ addslashes($reg->employee->full_name) }}', '{{ $reg->requested_check_in->format('Y-m-d\TH:i') }}', '{{ $reg->requested_check_out->format('Y-m-d\TH:i') }}')">
                                        <i class="bi bi-pencil-square me-1"></i> Edit & Approve
                                    </button>
                                    <form action="{{ route('attendance.regularizations.reject', $reg->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 fs-8 fw-bold">
                                            Reject
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="badge bg-light text-muted border px-2.5 py-1 fs-8">Processed</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted fs-7">
                            <i class="bi bi-shield-check fs-2 d-block mb-2 text-slate-300"></i>
                            <div class="fw-bold text-dark">No regularization requests found</div>
                            <p class="fs-8 text-muted mb-3">Submitted attendance regularization requests will appear here for review.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($regularizations->hasPages())
        <div class="p-3 border-top bg-light d-flex justify-content-between align-items-center">
            <div class="fs-8 text-muted">Showing {{ $regularizations->firstItem() }} to {{ $regularizations->lastItem() }} of {{ $regularizations->total() }} entries</div>
            <div>{{ $regularizations->links() }}</div>
        </div>
    @endif
</div>

<!-- Submit Regularization Request Modal -->
<div class="modal fade" id="createRegularizationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom px-4 py-3">
                <h5 class="modal-title fw-bold fs-6 text-dark">Submit Attendance Regularization</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('attendance.regularizations.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Employee <span class="text-danger">*</span></label>
                        <select name="employee_id" class="form-select rounded-3 fs-8" required>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->full_name }} ({{ $emp->employee_code }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Requested Check-In <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="requested_check_in" class="form-control rounded-3 fs-8" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Requested Check-Out <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="requested_check_out" class="form-control rounded-3 fs-8" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Reason / Justification <span class="text-danger">*</span></label>
                        <textarea name="reason" rows="3" class="form-control rounded-3 fs-8" placeholder="Explain the reason for missed or late punch (e.g. traffic delay, client meeting...)" required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4 fs-8 fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-amber rounded-pill px-4 fs-8 fw-bold text-white" style="background: #D97706; border: none;">Submit Request</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: HR Edit & Approve Regularization -->
<div class="modal fade" id="hrApproveEditModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <form id="hrApproveForm" action="" method="POST">
                @csrf
                <div class="modal-header border-bottom px-4 py-3 bg-light bg-opacity-50">
                    <h5 class="modal-title fw-bold text-dark fs-6">Review & Approve Punch Adjustment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 fs-7">
                    <div class="alert alert-info py-2 px-3 fs-8 rounded-3 mb-3 d-flex align-items-center gap-2">
                        <i class="bi bi-info-circle-fill text-info fs-6"></i>
                        <div>Review or modify the entry/exit time below before granting approval to employee <strong id="approve_emp_name"></strong>.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs-7 mb-1">Approved Check-In Time</label>
                        <input type="datetime-local" name="requested_check_in" id="approve_check_in" class="form-control rounded-3 fs-8" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs-7 mb-1">Approved Check-Out Time</label>
                        <input type="datetime-local" name="requested_check_out" id="approve_check_out" class="form-control rounded-3 fs-8" required>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4 fs-8 fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4 fs-8 fw-bold">
                        <i class="bi bi-check-circle me-1"></i> Confirm & Approve
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openApproveEditModal(id, actionUrl, empName, checkIn, checkOut) {
        document.getElementById('hrApproveForm').action = actionUrl;
        document.getElementById('approve_emp_name').innerText = empName;
        document.getElementById('approve_check_in').value = checkIn;
        document.getElementById('approve_check_out').value = checkOut;

        var modal = new bootstrap.Modal(document.getElementById('hrApproveEditModal'));
        modal.show();
    }
</script>
@endpush
@endsection
