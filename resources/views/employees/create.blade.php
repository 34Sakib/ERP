@extends('layouts.app')

@push('styles')
<style>
    .onboarding-hero {
        background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
        border-radius: 20px;
        padding: 1.75rem 2rem;
        color: #ffffff;
        margin-bottom: 2rem;
        box-shadow: 0 12px 30px rgba(79, 70, 229, 0.2);
    }

    /* Distinct Card Background Design */
    .form-card-v2 {
        background: #ffffff;
        border-radius: 22px;
        border: 1px solid #E2E8F0;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.06);
        padding: 2.25rem;
        margin-bottom: 1.75rem;
        position: relative;
        overflow: hidden;
    }

    .form-card-v2::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #4F46E5 0%, #7C3AED 50%, #C026D3 100%);
    }

    .section-header-chip {
        font-size: 0.82rem;
        font-weight: 800;
        letter-spacing: 0.03em;
        text-transform: uppercase;
        color: #4F46E5;
        background: #EEF2FF;
        border: 1px solid #C7D2FE;
        padding: 0.45rem 1rem;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .form-label-v2 {
        font-size: 0.82rem;
        font-weight: 700;
        color: #334155;
        margin-bottom: 0.45rem;
        display: block;
    }

    .form-control-v2, .form-select-v2 {
        border-radius: 12px;
        border: 1.5px solid #CBD5E1;
        background-color: #F8FAFC;
        padding: 0.7rem 1rem;
        font-size: 0.88rem;
        font-weight: 600;
        color: #0F172A;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .form-control-v2:focus, .form-select-v2:focus {
        border-color: #6366F1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
        background-color: #ffffff;
    }

    .info-callout-card {
        background: linear-gradient(135deg, #F0F9FF 0%, #E0F2FE 100%);
        border: 1px solid #BAE6FD;
        border-radius: 18px;
        padding: 1.25rem 1.5rem;
        color: #0369A1;
    }

    /* Dark Mode Overrides for Onboarding Form */
    [data-bs-theme="dark"] .form-card-v2 {
        background: #1F2937 !important;
        border-color: #374151 !important;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4) !important;
    }

    [data-bs-theme="dark"] .form-label-v2 {
        color: #F8FAFC !important;
    }

    [data-bs-theme="dark"] .form-control-v2,
    [data-bs-theme="dark"] .form-select-v2 {
        background-color: #111827 !important;
        border-color: #374151 !important;
        color: #F8FAFC !important;
    }

    [data-bs-theme="dark"] .form-control-v2:focus,
    [data-bs-theme="dark"] .form-select-v2:focus {
        border-color: #818CF8 !important;
        background-color: #111827 !important;
        box-shadow: 0 0 0 4px rgba(129, 140, 248, 0.25) !important;
    }

    [data-bs-theme="dark"] .info-callout-card {
        background: #1E293B !important;
        border-color: #334155 !important;
        color: #38BDF8 !important;
    }
</style>
@endpush

@section('content')
<!-- Onboarding Header -->
<div class="onboarding-hero">
    <div class="row align-items-center g-3">
        <div class="col-12 col-md-8">
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge rounded-pill bg-white bg-opacity-20 text-white fs-8 px-2.5 py-1">
                    <i class="bi bi-person-plus-fill me-1"></i> HR Onboarding Wizard
                </span>
                <span class="fs-8 text-white-50">• Step 1 of 1</span>
            </div>
            <h3 class="mb-1 fw-extrabold text-white" style="letter-spacing: -0.02em;">
                Onboard New Employee
            </h3>
            <p class="mb-0 text-white-50 fs-7">
                Create a 360° employee record and automatically provision portal access credentials.
            </p>
        </div>
        <div class="col-12 col-md-4 text-md-end">
            <a href="{{ route('employees.index') }}" class="btn btn-light rounded-pill px-3.5 py-2 fw-bold text-dark fs-8 shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> Back to Directory
            </a>
        </div>
    </div>
</div>

<form action="{{ route('employees.store') }}" method="POST">
    @csrf

    <!-- Section 1: Personal Information -->
    <div class="form-card-v2">
        <div class="section-header-chip">
            <i class="bi bi-person-badge-fill fs-6"></i> 1. Personal & Contact Information
        </div>

        <div class="row g-3">
            <div class="col-12 col-md-4">
                <label class="form-label-v2">Employee Code <span class="text-danger">*</span></label>
                <input type="text" name="employee_code" class="form-control-v2 font-monospace" value="EMP-00{{ rand(10, 99) }}" required>
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label-v2">First Name <span class="text-danger">*</span></label>
                <input type="text" name="first_name" class="form-control-v2" required placeholder="e.g. David">
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label-v2">Last Name <span class="text-danger">*</span></label>
                <input type="text" name="last_name" class="form-control-v2" required placeholder="e.g. Miller">
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label-v2">Personal / Work Email <span class="text-danger">*</span></label>
                <input type="email" name="personal_email" class="form-control-v2" required placeholder="david.miller@enterprise.com">
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label-v2">Phone Number</label>
                <input type="text" name="phone" class="form-control-v2" placeholder="+1 (555) 019-2834">
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label-v2">Gender <span class="text-danger">*</span></label>
                <select name="gender" class="form-select-v2" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label-v2">Date of Birth</label>
                <input type="date" name="dob" class="form-control-v2">
            </div>
        </div>
    </div>

    <!-- Section 2: Organizational Placement -->
    <div class="form-card-v2">
        <div class="section-header-chip" style="background: #ECFDF5; color: #059669; border-color: #A7F3D0;">
            <i class="bi bi-briefcase-fill fs-6"></i> 2. Organizational Placement & Role
        </div>

        <div class="row g-3">
            <div class="col-12 col-md-4">
                <label class="form-label-v2">Company <span class="text-danger">*</span></label>
                <select name="company_id" class="form-select-v2" required>
                    @foreach($companies as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label-v2">Branch Location</label>
                <select name="branch_id" class="form-select-v2">
                    <option value="">Select Branch</option>
                    @foreach($branches as $b)
                        <option value="{{ $b->id }}">{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label-v2">Department</label>
                <select name="department_id" class="form-select-v2">
                    <option value="">Select Department</option>
                    @foreach($departments as $d)
                        <option value="{{ $d->id }}">{{ $d->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label-v2">Designation / Title</label>
                <select name="designation_id" class="form-select-v2">
                    <option value="">Select Designation</option>
                    @foreach($designations as $desig)
                        <option value="{{ $desig->id }}">{{ $desig->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label-v2">Joining Date <span class="text-danger">*</span></label>
                <input type="date" name="joining_date" class="form-control-v2" value="{{ date('Y-m-d') }}" required>
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label-v2">Employment Status <span class="text-danger">*</span></label>
                <select name="employment_status" class="form-select-v2" required>
                    <option value="active" selected>Active</option>
                    <option value="probation">On Probation</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Section 3: Portal Security Provisioning Callout -->
    <div class="info-callout-card mb-4">
        <div class="d-flex align-items-center gap-3">
            <div class="bg-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 shadow-sm" style="width: 44px; height: 44px;">
                <i class="bi bi-shield-lock-fill text-primary fs-5"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-0.5 text-dark fs-7">Automatic Portal Credential Provisioning</h6>
                <p class="fs-8 text-secondary mb-0">
                    Saving this profile automatically generates a portal user login with default password <code>12345678</code> and assigns the <strong>Employee</strong> system role.
                </p>
            </div>
        </div>
    </div>

    <!-- Form Footer Actions -->
    <div class="d-flex justify-content-end gap-2.5 pb-4">
        <a href="{{ route('employees.index') }}" class="btn btn-light rounded-pill px-4 py-2 fs-8 fw-bold">Cancel</a>
        <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fs-8 fw-bold shadow-sm" style="background: linear-gradient(135deg, #4F46E5 0%, #6366F1 100%); border: none;">
            <i class="bi bi-check-circle-fill me-1"></i> Complete Onboarding
        </button>
    </div>
</form>
@endsection
