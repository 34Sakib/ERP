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

    .applicants-hero {
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

    .directory-card {
        background: #ffffff;
        border-radius: 22px;
        border: 1px solid #EFEFF7;
        box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.05);
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
        padding: 1rem 1.25rem;
        border-bottom: 1.5px solid #E2E8F0;
    }

    .table-directory tbody tr {
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        border-bottom: 1px solid #F1F5F9;
    }

    .table-directory tbody tr:hover {
        background-color: #F8FAFC !important;
        box-shadow: inset 3px 0 0 #4F46E5;
    }

    .table-directory tbody td {
        padding: 1rem 1.25rem;
        vertical-align: middle;
    }

    /* Dark Mode Overrides */
    [data-bs-theme="dark"] .pastel-ui8-card,
    [data-bs-theme="dark"] .directory-card {
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
</style>
@endpush

@section('content')
<!-- Header -->
<div class="applicants-hero">
    <div class="row align-items-center g-3">
        <div class="col-12 col-md-8">
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge rounded-pill bg-white bg-opacity-20 text-white fs-8 px-2.5 py-1">
                    <i class="bi bi-people-fill me-1"></i> Applicant Pipeline
                </span>
                <span class="fs-8 text-white-50">• {{ $stats['total'] }} Candidate Submissions</span>
            </div>
            <h3 class="mb-1 fw-extrabold text-white" style="letter-spacing: -0.02em;">
                Candidate Applicants Directory
            </h3>
            <p class="mb-0 text-white-50 fs-7">
                Screen candidate resumes, transition application stages, and advance top talent.
            </p>
        </div>
        <div class="col-12 col-md-4 text-md-end">
            <button class="btn btn-light rounded-pill px-4 py-2.5 fw-bold text-indigo shadow-sm" data-bs-toggle="modal" data-bs-target="#createApplicantModal" style="color: #4F46E5;">
                <i class="bi bi-plus-circle-fill me-1.5 fs-6"></i> Submit Candidate Application
            </button>
        </div>
    </div>
</div>

<!-- Image-Style Soft Pastel KPI Cards (4 Cards in 1 Row) -->
<div class="row g-3 mb-4">
    <!-- Card 1: Total Candidates (Soft Sky Blue) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-indigo">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-person-lines-fill me-1"></i> Talent Pool
                    </span>
                    <span class="ui8-pill-val" style="color: #0284C7;">
                        {{ $stats['total'] }} Candidates
                    </span>
                </div>
                <h4 class="ui8-card-title">Total Applications</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Cumulative Applicants
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-info shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-file-earmark-person"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Total</span>
                    <span class="ui8-tag-chip">#TalentPool</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Shortlisted (Soft Purple) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-purple">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-star-fill me-1"></i> Top Prospects
                    </span>
                    <span class="ui8-pill-val" style="color: #7C3AED;">
                        {{ $stats['shortlisted'] }} Shortlisted
                    </span>
                </div>
                <h4 class="ui8-card-title">Shortlisted Candidates</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Screened Profiles
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-purple shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800; color: #7C3AED;">
                        <i class="bi bi-star-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Shortlisted</span>
                    <span class="ui8-tag-chip">#Screened</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Under Interview (Soft Amber) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-amber">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-camera-video-fill me-1"></i> Active Rounds
                    </span>
                    <span class="ui8-pill-val" style="color: #D97706;">
                        {{ $stats['interview'] }} Interviewing
                    </span>
                </div>
                <h4 class="ui8-card-title">Under Interview</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Active Meetings
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-warning shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-chat-left-dots-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Interview</span>
                    <span class="ui8-tag-chip">#Rounds</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Hired Talent (Soft Emerald) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-emerald">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-check-circle-fill me-1"></i> Onboarded
                    </span>
                    <span class="ui8-pill-val" style="color: #059669;">
                        {{ $stats['hired'] }} Hired
                    </span>
                </div>
                <h4 class="ui8-card-title">Hired Talent</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Joined Staff
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-success shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-person-check-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Hired</span>
                    <span class="ui8-tag-chip">#Onboarded</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Bar Card -->
<div class="directory-card p-3 mb-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <ul class="nav nav-filter-pills gap-1">
            <li class="nav-item">
                <a href="{{ route('recruitment.applicants.index') }}" class="nav-link {{ !request('status') ? 'active' : '' }}">
                    All Candidates <span class="badge bg-white bg-opacity-20 rounded-pill ms-1 fs-8">{{ $stats['total'] }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('recruitment.applicants.index', ['status' => 'applied']) }}" class="nav-link {{ request('status') == 'applied' ? 'active' : '' }}">
                    Applied <span class="badge bg-info bg-opacity-20 text-info rounded-pill ms-1 fs-8">{{ $stats['applied'] }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('recruitment.applicants.index', ['status' => 'shortlisted']) }}" class="nav-link {{ request('status') == 'shortlisted' ? 'active' : '' }}">
                    Shortlisted <span class="badge bg-purple bg-opacity-20 text-purple rounded-pill ms-1 fs-8">{{ $stats['shortlisted'] }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('recruitment.applicants.index', ['status' => 'interview']) }}" class="nav-link {{ request('status') == 'interview' ? 'active' : '' }}">
                    Interviewing <span class="badge bg-warning bg-opacity-20 text-warning rounded-pill ms-1 fs-8">{{ $stats['interview'] }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('recruitment.applicants.index', ['status' => 'hired']) }}" class="nav-link {{ request('status') == 'hired' ? 'active' : '' }}">
                    Hired <span class="badge bg-success bg-opacity-20 text-success rounded-pill ms-1 fs-8">{{ $stats['hired'] }}</span>
                </a>
            </li>
        </ul>

        <form method="GET" action="{{ route('recruitment.applicants.index') }}" class="d-flex align-items-center gap-2">
            <input type="text" name="search" class="form-control rounded-pill fs-8 ps-3" value="{{ request('search') }}" placeholder="Search candidate name...">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
        </form>
    </div>
</div>

<!-- Applicants Table -->
<div class="directory-card">
    <div class="table-responsive">
        <table class="table table-directory align-middle mb-0 fs-7">
            <thead>
                <tr>
                    <th>CANDIDATE NAME</th>
                    <th>APPLIED FOR</th>
                    <th>CONTACT INFO</th>
                    <th>SOURCE</th>
                    <th>PIPELINE STAGE</th>
                    <th class="text-end pe-3">STAGE ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applicants as $a)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2.5">
                                <div class="p-2 bg-indigo bg-opacity-10 text-indigo rounded-circle fs-6 fw-bold" style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; background: #EEF2FF; color: #4F46E5;">
                                    {{ strtoupper(substr($a->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark fs-7">{{ $a->name }}</div>
                                    <div class="fs-8 text-muted">Submitted {{ $a->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold text-dark fs-8">{{ $a->jobPost?->title }}</div>
                            <div class="fs-8 text-secondary">{{ $a->jobPost?->department?->name ?? 'General' }}</div>
                        </td>
                        <td>
                            <div class="fs-8 text-dark"><i class="bi bi-envelope me-1 text-muted"></i> {{ $a->email }}</div>
                            <div class="fs-8 text-muted"><i class="bi bi-telephone me-1 text-muted"></i> {{ $a->phone ?? 'N/A' }}</div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border px-2.5 py-1 fs-8 fw-bold">
                                {{ $a->source ?? 'Careers Portal' }}
                            </span>
                        </td>
                        <td>
                            @if($a->status === 'applied')
                                <span class="badge bg-info-subtle text-info border border-info-subtle px-2.5 py-1 rounded-pill fs-8">Applied</span>
                            @elseif($a->status === 'shortlisted')
                                <span class="badge bg-purple-subtle text-purple border px-2.5 py-1 rounded-pill fs-8" style="background: #F3E8FF; color: #7C3AED;">Shortlisted</span>
                            @elseif($a->status === 'interview')
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2.5 py-1 rounded-pill fs-8">Under Interview</span>
                            @elseif($a->status === 'hired')
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1 rounded-pill fs-8">Hired</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2.5 py-1 rounded-pill fs-8">Rejected</span>
                            @endif
                        </td>
                        <td class="text-end pe-3">
                            <form action="{{ route('recruitment.applicants.status', $a->id) }}" method="POST" class="d-inline">
                                @csrf
                                <select name="status" class="form-select form-select-sm rounded-pill fs-8 d-inline-block w-auto" onchange="this.form.submit()">
                                    <option value="applied" {{ $a->status == 'applied' ? 'selected' : '' }}>Applied</option>
                                    <option value="shortlisted" {{ $a->status == 'shortlisted' ? 'selected' : '' }}>Shortlist Candidate</option>
                                    <option value="interview" {{ $a->status == 'interview' ? 'selected' : '' }}>Schedule Interview</option>
                                    <option value="hired" {{ $a->status == 'hired' ? 'selected' : '' }}>Mark as Hired</option>
                                    <option value="rejected" {{ $a->status == 'rejected' ? 'selected' : '' }}>Reject Candidate</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted fs-7">
                            <i class="bi bi-people fs-2 d-block mb-2 text-slate-300"></i>
                            <div class="fw-bold text-dark">No candidate applications found</div>
                            <p class="fs-8 text-muted mb-3">Submitted candidate applications will appear here.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($applicants->hasPages())
        <div class="p-3 border-top bg-light d-flex justify-content-between align-items-center">
            <div class="fs-8 text-muted">Showing {{ $applicants->firstItem() }} to {{ $applicants->lastItem() }} of {{ $applicants->total() }} entries</div>
            <div>{{ $applicants->links() }}</div>
        </div>
    @endif
</div>

<!-- Submit Candidate Application Modal -->
<div class="modal fade" id="createApplicantModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom px-4 py-3">
                <h5 class="modal-title fw-bold fs-6 text-dark">Submit Candidate Application</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('recruitment.applicants.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Job Position <span class="text-danger">*</span></label>
                        <select name="job_post_id" class="form-select rounded-3 fs-8" required>
                            @foreach($jobPosts as $jp)
                                <option value="{{ $jp->id }}">{{ $jp->title }} ({{ $jp->company?->name }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Candidate Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control rounded-3 fs-8" placeholder="e.g. Alex Rivers" required>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control rounded-3 fs-8" placeholder="alex@example.com" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Phone Number</label>
                            <input type="text" name="phone" class="form-control rounded-3 fs-8" placeholder="+1 (555) 000-0000">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Source</label>
                        <select name="source" class="form-select rounded-3 fs-8">
                            <option value="LinkedIn">LinkedIn</option>
                            <option value="Careers Portal">Careers Portal</option>
                            <option value="Indeed">Indeed</option>
                            <option value="Referral">Employee Referral</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4 fs-8 fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fs-8 fw-bold" style="background: #4F46E5; border: none;">Submit Application</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
