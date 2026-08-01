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

    .approval-hero {
        background: linear-gradient(-45deg, #312E81, #4338CA, #6366F1, #7C3AED);
        background-size: 300% 300%;
        animation: gradientMesh 12s ease infinite, fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        border-radius: 24px;
        padding: 2.25rem 2.5rem;
        color: #ffffff;
        margin-bottom: 1.75rem;
        box-shadow: 0 20px 45px rgba(49, 46, 129, 0.3);
    }

    .approval-card {
        background: #ffffff;
        border-radius: 22px;
        border: 1px solid #EFEFF7;
        box-shadow: 0 12px 35px -5px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        animation: fadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) both;
    }

    .nav-filter-pills .nav-link {
        color: #64748B;
        font-weight: 700;
        font-size: 0.8rem;
        padding: 0.5rem 1.15rem;
        border-radius: 999px;
        transition: all 0.25s ease;
        border: 1px solid transparent;
    }

    .nav-filter-pills .nav-link:hover {
        color: #4338CA;
        background: #EEF2FF;
    }

    .nav-filter-pills .nav-link.active {
        color: #ffffff;
        background: linear-gradient(135deg, #4F46E5 0%, #4338CA 100%);
        box-shadow: 0 6px 18px rgba(79, 70, 229, 0.3);
    }

    .table-directory thead th {
        background: linear-gradient(180deg, #F8FAFC 0%, #F1F5F9 100%);
        font-size: 0.72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #475569;
        padding: 1.1rem 1.25rem;
        border-bottom: 1.5px solid #E2E8F0;
    }

    .table-directory tbody tr {
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        border-bottom: 1px solid #F1F5F9;
    }

    .table-directory tbody tr:hover {
        background-color: #F8FAFC !important;
        box-shadow: inset 4px 0 0 #4F46E5;
    }

    .table-directory tbody td {
        padding: 1.1rem 1.25rem;
        vertical-align: middle;
    }

    .status-badge-pill {
        font-size: 0.74rem;
        font-weight: 800;
        padding: 0.35rem 0.85rem;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }

    .status-badge-pill.pending { background: #FEF3C7; color: #B45309; border: 1px solid #FDE68A; }
    .status-badge-pill.approved { background: #DCFCE7; color: #15803D; border: 1px solid #BBF7D0; }
    .status-badge-pill.rejected { background: #FEE2E2; color: #B91C1C; border: 1px solid #FECDD3; }

    /* Dark Mode Overrides */
    [data-bs-theme="dark"] .approval-card {
        background: #1F2937 !important;
        border-color: #374151 !important;
    }
    [data-bs-theme="dark"] .table-directory thead th {
        background: #111827 !important;
        color: #9CA3AF !important;
        border-color: #374151 !important;
    }
    [data-bs-theme="dark"] .table-directory tbody tr:hover {
        background-color: #374151 !important;
    }
</style>
@endpush

@section('content')
<!-- Header -->
<div class="approval-hero">
    <div class="row align-items-center g-3">
        <div class="col-12 col-md-8">
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge rounded-pill bg-white bg-opacity-20 text-white fs-8 px-2.5 py-1">
                    <i class="bi bi-shield-check me-1"></i> Manager Approval Queue
                </span>
                <span class="fs-8 text-white-50">• {{ $stats['pending'] }} Pending Requests Awaiting Action</span>
            </div>
            <h3 class="mb-1 fw-extrabold text-white" style="letter-spacing: -0.02em;">
                Leave Approval Queue Manager
            </h3>
            <p class="mb-0 text-white-50 fs-7">
                Review employee leave applications, inspect dates & duration, and authorize vacation time.
            </p>
        </div>
        <div class="col-12 col-md-4 text-md-end">
            <div class="badge bg-white bg-opacity-15 text-white p-3 rounded-4 shadow-sm text-start">
                <div class="fs-8 text-white-50">Pending Review</div>
                <div class="fw-extrabold fs-4">{{ $stats['pending'] }} Applications</div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Bar Card -->
<div class="approval-card p-3 mb-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <ul class="nav nav-filter-pills gap-1">
            <li class="nav-item">
                <a href="{{ route('leave.approvals') }}" class="nav-link {{ !request('status') ? 'active' : '' }}">
                    All Requests <span class="badge bg-white bg-opacity-20 rounded-pill ms-1 fs-8">{{ $stats['total'] }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('leave.approvals', ['status' => 'pending']) }}" class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}">
                    <i class="bi bi-clock-history me-1 text-warning"></i> Pending <span class="badge bg-warning bg-opacity-20 text-warning rounded-pill ms-1 fs-8">{{ $stats['pending'] }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('leave.approvals', ['status' => 'approved']) }}" class="nav-link {{ request('status') == 'approved' ? 'active' : '' }}">
                    <i class="bi bi-check-circle me-1 text-success"></i> Approved <span class="badge bg-success bg-opacity-20 text-success rounded-pill ms-1 fs-8">{{ $stats['approved'] }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('leave.approvals', ['status' => 'rejected']) }}" class="nav-link {{ request('status') == 'rejected' ? 'active' : '' }}">
                    <i class="bi bi-x-circle me-1 text-danger"></i> Rejected <span class="badge bg-danger bg-opacity-20 text-danger rounded-pill ms-1 fs-8">{{ $stats['rejected'] }}</span>
                </a>
            </li>
        </ul>

        <form method="GET" action="{{ route('leave.approvals') }}" class="d-flex align-items-center gap-2">
            <div class="position-relative">
                <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                <input type="text" name="search" class="form-control rounded-pill ps-5 fs-8" value="{{ request('search') }}" placeholder="Search applicant name...">
            </div>
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
        </form>
    </div>
</div>

<!-- Approval Queue Directory Table -->
<div class="approval-card">
    <div class="table-responsive">
        <table class="table table-directory align-middle mb-0 fs-7">
            <thead>
                <tr>
                    <th>EMPLOYEE APPLICANT</th>
                    <th>LEAVE TYPE</th>
                    <th>START & END DATES</th>
                    <th>DURATION</th>
                    <th>REASON & DETAILS</th>
                    <th>STATUS</th>
                    <th class="text-end pe-4">APPROVAL ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $app)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="position-relative">
                                    <img src="{{ $app->employee->profile_photo ? asset($app->employee->profile_photo) : 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80' }}" 
                                         class="rounded-circle shadow-sm" style="width: 42px; height: 42px; object-fit: cover;">
                                    <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-white rounded-circle"></span>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark fs-7">{{ $app->employee->full_name }}</div>
                                    <div class="fs-8 text-muted d-flex align-items-center gap-1.5 mt-0.5">
                                        <code class="text-indigo bg-light px-1.5 py-0.5 rounded">{{ $app->employee->employee_code }}</code>
                                        <span>• {{ $app->employee->department?->name ?? 'General' }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge rounded-pill px-3 py-1.5 fs-8 fw-bold shadow-2xs" style="background: {{ $app->leaveType?->color ?? '#6366F1' }}18; color: {{ $app->leaveType?->color ?? '#6366F1' }}; border: 1px solid {{ $app->leaveType?->color ?? '#6366F1' }}40;">
                                <i class="bi bi-tag-fill me-1" style="color: {{ $app->leaveType?->color ?? '#6366F1' }};"></i>
                                {{ $app->leaveType?->name }}
                            </span>
                        </td>
                        <td>
                            <div class="d-inline-flex align-items-center gap-2 p-2 px-3 rounded-4 bg-light border shadow-2xs">
                                <div class="d-flex align-items-center gap-1.5">
                                    <i class="bi bi-calendar-event text-success fs-8"></i>
                                    <span class="fw-bold text-dark fs-8 font-monospace">{{ $app->start_date->format('M d, Y') }}</span>
                                </div>
                                <i class="bi bi-arrow-right text-muted fs-8 px-1"></i>
                                <div class="d-flex align-items-center gap-1.5">
                                    <i class="bi bi-calendar-check text-primary fs-8"></i>
                                    <span class="fw-bold text-dark fs-8 font-monospace">{{ $app->end_date->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary border border-primary border-opacity-20 px-3 py-1.5 fs-8 fw-extrabold" style="background: #EEF2FF; color: #4F46E5; border-color: #C7D2FE;">
                                <i class="bi bi-clock-history me-1"></i> {{ $app->days_count }} {{ Str::plural('Day', $app->days_count) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="fs-8 text-secondary text-truncate" style="max-width: 170px;" title="{{ $app->reason }}">
                                    {{ $app->reason }}
                                </span>
                                <button class="btn btn-sm btn-light rounded-circle shadow-2xs text-indigo" 
                                        onclick="viewReasonModal('{{ addslashes($app->employee->full_name) }}', '{{ addslashes($app->leaveType?->name) }}', '{{ $app->start_date->format('M d, Y') }}', '{{ $app->end_date->format('M d, Y') }}', '{{ $app->days_count }}', '{{ addslashes($app->reason) }}')"
                                        title="View Full Reason">
                                    <i class="bi bi-eye-fill fs-8"></i>
                                </button>
                            </div>
                        </td>
                        <td>
                            @if($app->status === 'pending')
                                <span class="status-badge-pill pending"><i class="bi bi-hourglass-split"></i> Pending</span>
                            @elseif($app->status === 'approved')
                                <span class="status-badge-pill approved"><i class="bi bi-check-circle-fill"></i> Approved</span>
                            @else
                                <span class="status-badge-pill rejected"><i class="bi bi-x-circle-fill"></i> Rejected</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            @if($app->status === 'pending')
                                <div class="d-flex justify-content-end align-items-center gap-2">
                                    <form action="{{ route('leave.approve', $app->id) }}" method="POST" id="approveForm_{{ $app->id }}">
                                        @csrf
                                        <button type="button" class="btn btn-sm btn-success rounded-pill px-3.5 py-1.5 fs-8 fw-bold shadow-sm" 
                                                onclick="confirmApproveLeave('{{ $app->id }}', '{{ addslashes($app->employee->full_name) }}', '{{ $app->days_count }}')">
                                            <i class="bi bi-check-circle-fill me-1"></i> Approve
                                        </button>
                                    </form>

                                    <form action="{{ route('leave.reject', $app->id) }}" method="POST" id="rejectForm_{{ $app->id }}">
                                        @csrf
                                        <input type="hidden" name="rejection_reason" id="rejectReason_{{ $app->id }}">
                                        <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3 py-1.5 fs-8 fw-bold" 
                                                onclick="promptRejectLeave('{{ $app->id }}', '{{ addslashes($app->employee->full_name) }}')">
                                            Reject
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="fs-8 text-muted">
                                    <i class="bi bi-person-check me-1"></i> {{ $app->approver?->name ?? 'System' }}
                                </div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted fs-7">
                            <i class="bi bi-shield-check fs-2 d-block mb-2 text-slate-300"></i>
                            <div class="fw-bold text-dark">No leave applications found</div>
                            <p class="fs-8 text-muted mb-3">All employee leave requests have been reviewed.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($applications->hasPages())
        <div class="p-3.5 border-top bg-light d-flex justify-content-between align-items-center">
            <div class="fs-8 text-muted">Showing {{ $applications->firstItem() }} to {{ $applications->lastItem() }} of {{ $applications->total() }} entries</div>
            <div>{{ $applications->links() }}</div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    function viewReasonModal(employeeName, leaveType, startDate, endDate, days, reason) {
        const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';

        Swal.fire({
            title: `<div class="fw-bold fs-6 text-dark text-start mb-0"><i class="bi bi-journal-text text-primary me-2"></i> Leave Request Explanation</div>`,
            html: `
                <div class="text-start py-2">
                    <div class="bg-light p-3 rounded-3 mb-3 border">
                        <div class="fw-bold text-dark fs-7">${employeeName}</div>
                        <div class="fs-8 text-muted">${leaveType} • ${startDate} to ${endDate} (${days} Days)</div>
                    </div>
                    <label class="fw-bold fs-8 text-secondary mb-1">Reason / Justification:</label>
                    <div class="p-3 rounded-3 fs-7 text-dark border" style="background: ${isDark ? '#111827' : '#F9FAFB'}; line-height: 1.6;">
                        ${reason}
                    </div>
                </div>
            `,
            confirmButtonText: 'Close Details',
            confirmButtonColor: '#4F46E5',
            background: isDark ? '#1F2937' : '#ffffff',
            color: isDark ? '#F8FAFC' : '#1E1B4B',
            customClass: {
                popup: 'rounded-4 border-0 shadow-lg p-4',
                confirmButton: 'px-4 py-2 rounded-pill fw-bold fs-7'
            }
        });
    }

    function confirmApproveLeave(appId, employeeName, days) {
        const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';

        Swal.fire({
            title: `<div class="d-flex align-items-center justify-content-center gap-2 text-success fw-bold fs-5 mb-1">
                        <i class="bi bi-check-circle-fill fs-4"></i> Approve Leave Request?
                    </div>`,
            html: `
                <div class="text-center py-2">
                    <p class="fs-7 text-secondary mb-3" style="line-height: 1.6;">
                        Are you sure you want to approve leave for <strong class="text-dark">${employeeName}</strong> (${days} Days)?
                    </p>
                    <div class="alert alert-success border-0 fs-8 py-2.5 px-3 text-start mb-0 rounded-3" style="background: ${isDark ? '#064E3B' : '#ECFDF5'}; color: ${isDark ? '#6EE7B7' : '#065F46'};">
                        <i class="bi bi-shield-check me-1"></i>
                        Approving this request will automatically deduct <strong>${days} Days</strong> from the employee's available leave quota.
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: '<i class="bi bi-check-circle-fill me-1"></i> Yes, Authorize Leave',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#10B981',
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
                document.getElementById('approveForm_' + appId).submit();
            }
        });
    }

    function promptRejectLeave(appId, employeeName) {
        const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';

        Swal.fire({
            title: `<div class="d-flex align-items-center justify-content-center gap-2 text-danger fw-bold fs-5 mb-1">
                        <i class="bi bi-x-circle-fill fs-4"></i> Reject Leave Application
                    </div>`,
            html: `
                <div class="text-start py-2">
                    <p class="fs-7 text-secondary mb-3">
                        Rejecting leave application for <strong class="text-dark">${employeeName}</strong>.
                    </p>
                    <label class="form-label fw-bold fs-8 text-dark">Reason for Rejection (Optional):</label>
                    <textarea id="swalRejectReason" class="form-control fs-8 rounded-3" rows="3" placeholder="Provide notes or reason for rejection..."></textarea>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: '<i class="bi bi-x-circle-fill me-1"></i> Reject Application',
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
                const reason = document.getElementById('swalRejectReason').value;
                document.getElementById('rejectReason_' + appId).value = reason;
                document.getElementById('rejectForm_' + appId).submit();
            }
        });
    }
</script>
@endpush
