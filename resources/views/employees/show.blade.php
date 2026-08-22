@extends('layouts.app')

@push('styles')
<style>
    .profile-hero-card {
        background: linear-gradient(135deg, #1E1B4B 0%, #312E81 50%, #4338CA 100%);
        border-radius: 20px;
        padding: 2rem;
        color: #ffffff;
        margin-bottom: 2rem;
        box-shadow: 0 15px 35px rgba(30, 27, 75, 0.25);
        position: relative;
        overflow: hidden;
    }

    .profile-avatar-xl {
        width: 76px;
        height: 76px;
        border-radius: 20px;
        object-fit: cover;
        border: 3px solid rgba(255, 255, 255, 0.4);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .profile-nav-tabs {
        background: #ffffff;
        border-radius: 16px;
        padding: 0.5rem;
        border: 1px solid #EFEFF7;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        margin-bottom: 1.75rem;
    }

    .profile-nav-tabs .nav-link {
        border: none;
        color: #64748B;
        font-weight: 700;
        font-size: 0.85rem;
        padding: 0.65rem 1.15rem;
        border-radius: 12px;
        transition: all 0.2s ease;
    }

    .profile-nav-tabs .nav-link.active {
        background: #4F46E5;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
    }

    .info-card-v2 {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #EFEFF7;
        box-shadow: 0 8px 25px -5px rgba(0, 0, 0, 0.04);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .info-field-label {
        font-size: 0.78rem;
        font-weight: 600;
        color: #64748B;
    }

    .info-field-val {
        font-size: 0.9rem;
        font-weight: 700;
        color: #1E1B4B;
    }
</style>
@endpush

@section('content')
<!-- Hero Profile Header -->
<div class="profile-hero-card">
    <div class="row align-items-center g-3">
        <div class="col-12 col-md-7">
            <div class="d-flex align-items-center gap-3.5">
                <img src="{{ $employee->avatar_url }}" 
                     alt="Avatar" class="profile-avatar-xl">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="badge rounded-pill font-monospace px-2.5 py-1 fs-8" style="background: rgba(255,255,255,0.2); color: #ffffff;">
                            {{ $employee->employee_code }}
                        </span>
                        @if($employee->employment_status === 'active')
                            <span class="badge rounded-pill bg-success text-white px-2.5 py-1 fs-8">Active Staff</span>
                        @elseif($employee->employment_status === 'probation')
                            <span class="badge rounded-pill bg-warning text-dark px-2.5 py-1 fs-8">On Probation</span>
                        @else
                            <span class="badge rounded-pill bg-secondary text-white px-2.5 py-1 fs-8">{{ ucfirst($employee->employment_status) }}</span>
                        @endif
                    </div>
                    <h3 class="mb-1 fw-extrabold text-white" style="letter-spacing: -0.02em;">
                        {{ $employee->full_name }}
                    </h3>
                    <p class="mb-0 text-white-50 fs-7">
                        {{ $employee->designation?->name ?? 'Staff Member' }} • <strong class="text-white">{{ $employee->department?->name ?? 'General' }}</strong>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-5 text-md-end">
            <div class="d-flex flex-wrap gap-2 justify-content-md-end">
                <a href="{{ route('employees.index') }}" class="btn btn-light rounded-pill px-3.5 py-2 fw-bold text-dark fs-8">
                    <i class="bi bi-arrow-left me-1"></i> Back to Directory
                </a>
                <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-primary rounded-pill px-3.5 py-2 fw-bold fs-8" style="background: #6366F1; border: none;">
                    <i class="bi bi-pencil me-1"></i> Edit Profile
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Profile Nav Tabs -->
<div class="profile-nav-tabs">
    <ul class="nav nav-pills" id="employeeProfileTabs" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview-content">
                <i class="bi bi-person-badge-fill me-1.5"></i> 360° Overview
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="documents-tab" data-bs-toggle="tab" data-bs-target="#documents-content">
                <i class="bi bi-folder2-open me-1.5"></i> Documents Vault
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="bank-tab" data-bs-toggle="tab" data-bs-target="#bank-content">
                <i class="bi bi-bank2 me-1.5"></i> Bank & Payroll
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history-content">
                <i class="bi bi-clock-history me-1.5"></i> History Log
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="notes-tab" data-bs-toggle="tab" data-bs-target="#notes-content">
                <i class="bi bi-sticky-fill me-1.5"></i> HR Notes
            </button>
        </li>
    </ul>
</div>

<!-- Tab Contents -->
<div class="tab-content" id="employeeProfileTabContent">
    <!-- Tab 1: Overview -->
    <div class="tab-pane fade show active" id="overview-content">
        <div class="row g-4">
            <!-- Personal Info Card -->
            <div class="col-12 col-lg-6">
                <div class="info-card-v2 h-100">
                    <h5 class="fw-bold text-dark fs-6 mb-3 pb-2 border-bottom">
                        <i class="bi bi-person-fill text-primary me-2"></i>Personal & Contact Details
                    </h5>
                    
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="info-field-label">Full Name</div>
                            <div class="info-field-val">{{ $employee->full_name }}</div>
                        </div>
                        <div class="col-6">
                            <div class="info-field-label">Gender</div>
                            <div class="info-field-val text-capitalize">{{ $employee->gender }}</div>
                        </div>
                        <div class="col-6">
                            <div class="info-field-label">Date of Birth</div>
                            <div class="info-field-val">{{ $employee->dob?->format('M d, Y') ?? 'N/A' }}</div>
                        </div>
                        <div class="col-6">
                            <div class="info-field-label">Personal Email</div>
                            <div class="info-field-val text-truncate">
                                <a href="mailto:{{ $employee->personal_email }}" class="text-decoration-none text-primary">
                                    {{ $employee->personal_email }}
                                </a>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="info-field-label">Phone Number</div>
                            <div class="info-field-val">{{ $employee->phone ?? 'N/A' }}</div>
                        </div>
                        <div class="col-6">
                            <div class="info-field-label">Emergency Contact</div>
                            <div class="info-field-val">Configured</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Employment Details Card -->
            <div class="col-12 col-lg-6">
                <div class="info-card-v2 h-100">
                    <h5 class="fw-bold text-dark fs-6 mb-3 pb-2 border-bottom">
                        <i class="bi bi-briefcase-fill text-success me-2"></i>Employment & Department Placement
                    </h5>
                    
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="info-field-label">Company</div>
                            <div class="info-field-val">{{ $employee->company?->name ?? 'Enterprise ERP' }}</div>
                        </div>
                        <div class="col-6">
                            <div class="info-field-label">Branch Location</div>
                            <div class="info-field-val">{{ $employee->branch?->name ?? 'Headquarters' }}</div>
                        </div>
                        <div class="col-6">
                            <div class="info-field-label">Department</div>
                            <div class="info-field-val">{{ $employee->department?->name ?? 'General' }}</div>
                        </div>
                        <div class="col-6">
                            <div class="info-field-label">Designation / Role</div>
                            <div class="info-field-val">{{ $employee->designation?->name ?? 'Staff Member' }}</div>
                        </div>
                        <div class="col-6">
                            <div class="info-field-label">Joining Date</div>
                            <div class="info-field-val">{{ $employee->joining_date?->format('M d, Y') ?? 'N/A' }}</div>
                        </div>
                        <div class="col-6">
                            <div class="info-field-label">Employment Status</div>
                            <div class="info-field-val">
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1 rounded-pill fs-8">
                                    {{ ucfirst($employee->employment_status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab 2: Documents Vault -->
    <div class="tab-pane fade" id="documents-content">
        <div class="info-card-v2">
            <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                <h5 class="fw-bold text-dark fs-6 mb-0">
                    <i class="bi bi-folder2-open text-warning me-2"></i>Employee Document Repository
                </h5>
                <button class="btn btn-outline-primary btn-sm rounded-pill px-3 fs-8 fw-bold">
                    <i class="bi bi-upload me-1"></i> Upload Document
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 fs-7">
                    <thead class="table-light fs-8 text-muted">
                        <tr>
                            <th>DOCUMENT TITLE</th>
                            <th>TYPE</th>
                            <th>DOCUMENT NUMBER</th>
                            <th>EXPIRY DATE</th>
                            <th class="text-end">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employee->documents as $doc)
                            <tr>
                                <td class="fw-bold text-dark">{{ $doc->title }}</td>
                                <td><span class="badge bg-light text-dark border px-2 py-1 fs-8">{{ strtoupper($doc->type) }}</span></td>
                                <td class="font-monospace fs-8">{{ $doc->number ?? 'N/A' }}</td>
                                <td class="text-muted fs-8">{{ $doc->expiry_date?->format('M d, Y') ?? 'N/A' }}</td>
                                <td class="text-end">
                                    <button class="btn btn-light btn-sm rounded-circle text-primary" title="Download">
                                        <i class="bi bi-download"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted fs-8">
                                    <i class="bi bi-folder fs-4 d-block mb-1 text-slate-300"></i> No documents uploaded yet for this employee.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tab 3: Bank & Payroll -->
    <div class="tab-pane fade" id="bank-content">
        <div class="info-card-v2">
            <h5 class="fw-bold text-dark fs-6 mb-3 pb-2 border-bottom">
                <i class="bi bi-bank2 text-info me-2"></i>Bank Account & Direct Deposit Information
            </h5>

            @if($employee->bankDetail)
                <div class="row g-3">
                    <div class="col-6 col-md-3">
                        <div class="info-field-label">Bank Name</div>
                        <div class="info-field-val">{{ $employee->bankDetail->bank_name }}</div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="info-field-label">Account Title</div>
                        <div class="info-field-val">{{ $employee->bankDetail->account_title }}</div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="info-field-label">Account Number</div>
                        <div class="info-field-val font-monospace">{{ $employee->bankDetail->account_number }}</div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="info-field-label">IBAN / SWIFT</div>
                        <div class="info-field-val font-monospace">{{ $employee->bankDetail->iban ?? 'N/A' }}</div>
                    </div>
                </div>
            @else
                <div class="text-center py-4 text-muted fs-8">
                    <i class="bi bi-bank fs-4 d-block mb-1 text-slate-300"></i> No bank transfer details added yet.
                </div>
            @endif
        </div>
    </div>

    <!-- Tab 4: History -->
    <div class="tab-pane fade" id="history-content">
        <div class="info-card-v2">
            <h5 class="fw-bold text-dark fs-6 mb-3 pb-2 border-bottom">
                <i class="bi bi-clock-history text-secondary me-2"></i>Employment & Designation History Log
            </h5>
            <div class="text-center py-4 text-muted fs-8">
                <i class="bi bi-journal-check fs-4 d-block mb-1 text-slate-300"></i>
                Initial employment contract registered on <strong>{{ $employee->joining_date?->format('M d, Y') ?? 'N/A' }}</strong>.
            </div>
        </div>
    </div>

    <!-- Tab 5: Notes -->
    <div class="tab-pane fade" id="notes-content">
        <div class="info-card-v2">
            <h5 class="fw-bold text-dark fs-6 mb-3 pb-2 border-bottom">
                <i class="bi bi-sticky-fill text-warning me-2"></i>HR Confidential Notes
            </h5>
            <p class="text-muted fs-8 mb-0">Private internal record reserved for HR managers and administrators.</p>
        </div>
    </div>
</div>
@endsection
