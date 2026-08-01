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

    .jobs-hero {
        background: linear-gradient(-45deg, #312E81, #4338CA, #6366F1, #7C3AED);
        background-size: 300% 300%;
        animation: gradientMesh 12s ease infinite, fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        border-radius: 24px;
        padding: 2.25rem 2.5rem;
        color: #ffffff;
        margin-bottom: 1.75rem;
        box-shadow: 0 20px 45px rgba(49, 46, 129, 0.3);
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

    .job-card {
        background: #ffffff;
        border-radius: 22px;
        border: 1px solid #EFEFF7;
        box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.05);
        padding: 1.6rem;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        animation: fadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) both;
    }

    .job-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 18px 35px rgba(99, 102, 241, 0.15);
    }

    /* Dark Mode Overrides */
    [data-bs-theme="dark"] .pastel-ui8-card,
    [data-bs-theme="dark"] .job-card {
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
<div class="jobs-hero">
    <div class="row align-items-center g-3">
        <div class="col-12 col-md-8">
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge rounded-pill bg-white bg-opacity-20 text-white fs-8 px-2.5 py-1">
                    <i class="bi bi-briefcase-fill me-1"></i> Talent Acquisition
                </span>
                <span class="fs-8 text-white-50">• {{ $stats['published_count'] }} Active Job Openings</span>
            </div>
            <h3 class="mb-1 fw-extrabold text-white" style="letter-spacing: -0.02em;">
                Job Requisitions & Openings
            </h3>
            <p class="mb-0 text-white-50 fs-7">
                Manage organization job vacancies, track candidate application flow, and publish postings.
            </p>
        </div>
        <div class="col-12 col-md-4 text-md-end">
            <button class="btn btn-light rounded-pill px-4 py-2.5 fw-bold text-indigo shadow-sm" data-bs-toggle="modal" data-bs-target="#createJobModal" style="color: #4F46E5;">
                <i class="bi bi-plus-circle-fill me-1.5 fs-6"></i> Post New Job
            </button>
        </div>
    </div>
</div>

<!-- Image-Style Soft Pastel KPI Cards (4 Cards in 1 Row) -->
<div class="row g-3 mb-4">
    <!-- Card 1: Active Openings (Soft Emerald) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-emerald">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-broadcast me-1"></i> Live Positions
                    </span>
                    <span class="ui8-pill-val" style="color: #059669;">
                        {{ $stats['published_count'] }} Active
                    </span>
                </div>
                <h4 class="ui8-card-title">Active Job Openings</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Published Vacancies
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-success shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-check-circle-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Active</span>
                    <span class="ui8-tag-chip">#Published</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Total Applicants (Soft Sky Blue) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-indigo">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-people-fill me-1"></i> Talent Pool
                    </span>
                    <span class="ui8-pill-val" style="color: #0284C7;">
                        {{ $stats['total_applicants'] }} Candidates
                    </span>
                </div>
                <h4 class="ui8-card-title">Total Applications</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Candidate Submissions
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-info shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-file-earmark-person"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Applicants</span>
                    <span class="ui8-tag-chip">#Candidates</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Total Requisitions (Soft Purple) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-purple">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-journal-check me-1"></i> All Requisitions
                    </span>
                    <span class="ui8-pill-val" style="color: #7C3AED;">
                        {{ $stats['total_jobs'] }} Posts
                    </span>
                </div>
                <h4 class="ui8-card-title">Total Job Posts</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Created Openings
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-purple shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800; color: #7C3AED;">
                        <i class="bi bi-collection-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Total</span>
                    <span class="ui8-tag-chip">#Requisitions</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Closed Openings (Soft Amber) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-amber">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-lock-fill me-1"></i> Filled / Closed
                    </span>
                    <span class="ui8-pill-val" style="color: #D97706;">
                        {{ $stats['closed_count'] }} Closed
                    </span>
                </div>
                <h4 class="ui8-card-title">Closed Openings</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Filled Requisitions
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-warning shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-check2-all"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Closed</span>
                    <span class="ui8-tag-chip">#Filled</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Job Cards Grid -->
<div class="row g-4">
    @forelse($jobs as $j)
        <div class="col-12 col-md-6 col-xl-4">
            <div class="job-card">
                <div>
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge rounded-pill bg-primary-subtle text-primary border px-3 py-1 fs-8 fw-bold" style="background: #EEF2FF; color: #4F46E5;">
                            <i class="bi bi-briefcase me-1"></i> {{ $j->employment_type }}
                        </span>
                        <div class="dropdown">
                            <button class="btn btn-light btn-sm rounded-circle shadow-2xs" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 fs-7 p-2" style="border-radius: 14px; min-width: 160px;">
                                <li>
                                    <button class="dropdown-item rounded-2 py-1.5 fs-8" 
                                            onclick="editJobModal('{{ $j->id }}', '{{ $j->company_id }}', '{{ $j->department_id }}', '{{ addslashes($j->title) }}', '{{ $j->employment_type }}', '{{ $j->status }}', '{{ $j->closing_date?->format('Y-m-d') }}', '{{ addslashes($j->description) }}')">
                                        <i class="bi bi-pencil me-2 text-primary"></i> Edit Opening
                                    </button>
                                </li>
                                <li>
                                    <form action="{{ route('recruitment.jobs.destroy', $j->id) }}" method="POST" onsubmit="event.preventDefault(); confirmDeleteJob('{{ $j->id }}', '{{ addslashes($j->title) }}', this);">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item rounded-2 py-1.5 text-danger fs-8 fw-semibold">
                                            <i class="bi bi-trash me-2"></i> Delete Job Post
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <h5 class="fw-bold text-dark mb-1 fs-6">{{ $j->title }}</h5>
                    <div class="fs-8 text-muted mb-3">
                        <i class="bi bi-building me-1"></i> {{ $j->department?->name ?? 'General' }} • {{ $j->company?->name }}
                    </div>

                    <p class="fs-8 text-secondary mb-3" style="line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                        {{ $j->description ?? 'No detailed description provided for this job opening.' }}
                    </p>

                    <div class="bg-light rounded-3 p-2.5 mb-3 border d-flex justify-content-between align-items-center">
                        <span class="fs-8 text-muted"><i class="bi bi-people me-1"></i> Candidates Applied</span>
                        <span class="badge bg-white text-dark border px-2.5 py-1 fs-8 fw-bold">{{ $j->applicants->count() }} Applicants</span>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center pt-2 border-top fs-8 text-muted">
                    <span>
                        @if($j->status === 'published')
                            <i class="bi bi-circle-fill text-success me-1 fs-9"></i> Active
                        @else
                            <i class="bi bi-circle-fill text-secondary me-1 fs-9"></i> {{ ucfirst($j->status) }}
                        @endif
                    </span>
                    <a href="{{ route('recruitment.applicants.index') }}" class="fw-bold text-indigo" style="color: #4F46E5;">
                        View Applicants <i class="bi bi-arrow-right me-1"></i>
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5 text-muted fs-7">
            <i class="bi bi-briefcase fs-2 d-block mb-2 text-slate-300"></i>
            <div class="fw-bold text-dark">No job requisitions posted</div>
            <p class="fs-8 text-muted mb-3">Click "Post New Job" to create talent acquisition openings.</p>
        </div>
    @endforelse
</div>

<!-- Create / Edit Job Modal -->
<div class="modal fade" id="createJobModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom px-4 py-3">
                <h5 class="modal-title fw-bold fs-6 text-dark" id="jobModalTitle">Post New Job Opening</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('recruitment.jobs.store') }}" method="POST" id="jobForm">
                @csrf
                <input type="hidden" name="_method" id="jobMethod" value="POST">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Company <span class="text-danger">*</span></label>
                        <select name="company_id" id="job_company_id" class="form-select rounded-3 fs-8" required>
                            @foreach($companies as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Job Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="job_title" class="form-control rounded-3 fs-8" placeholder="e.g. Senior Full Stack Engineer" required>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Department</label>
                            <select name="department_id" id="job_department_id" class="form-select rounded-3 fs-8">
                                <option value="">Select Department</option>
                                @foreach($departments as $d)
                                    <option value="{{ $d->id }}">{{ $d->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Employment Type</label>
                            <select name="employment_type" id="job_employment_type" class="form-select rounded-3 fs-8">
                                <option value="Full-Time">Full-Time</option>
                                <option value="Part-Time">Part-Time</option>
                                <option value="Contract">Contract</option>
                                <option value="Remote">Remote</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Status</label>
                            <select name="status" id="job_status" class="form-select rounded-3 fs-8">
                                <option value="published">Published</option>
                                <option value="draft">Draft</option>
                                <option value="closed">Closed</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Closing Date</label>
                            <input type="date" name="closing_date" id="job_closing_date" class="form-control rounded-3 fs-8">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Job Description</label>
                        <textarea name="description" id="job_description" class="form-control rounded-3 fs-8" rows="3" placeholder="Provide responsibilities and required skills..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4 fs-8 fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fs-8 fw-bold" style="background: #4F46E5; border: none;">Save Job Opening</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function editJobModal(id, companyId, deptId, title, empType, status, closingDate, desc) {
        document.getElementById('jobModalTitle').textContent = 'Edit Job Opening';
        document.getElementById('jobForm').action = "{{ url('recruitment/jobs') }}/" + id;
        document.getElementById('jobMethod').value = 'PUT';

        document.getElementById('job_company_id').value = companyId;
        document.getElementById('job_department_id').value = deptId;
        document.getElementById('job_title').value = title;
        document.getElementById('job_employment_type').value = empType;
        document.getElementById('job_status').value = status;
        document.getElementById('job_closing_date').value = closingDate;
        document.getElementById('job_description').value = desc;

        const modal = new bootstrap.Modal(document.getElementById('createJobModal'));
        modal.show();
    }

    function confirmDeleteJob(id, title, formEl) {
        const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
        
        Swal.fire({
            title: `<div class="d-flex align-items-center justify-content-center gap-2 text-danger fw-bold fs-5 mb-1">
                        <i class="bi bi-exclamation-triangle-fill fs-4"></i> Delete Job Post?
                    </div>`,
            html: `
                <div class="text-center py-2">
                    <p class="fs-7 text-secondary mb-3" style="line-height: 1.6;">
                        Are you sure you want to delete <strong class="text-dark">${title}</strong>?
                    </p>
                    <div class="alert alert-danger border-0 fs-8 py-2.5 px-3 text-start mb-0 rounded-3" style="background: ${isDark ? '#374151' : '#FEF2F2'}; color: ${isDark ? '#F87171' : '#991B1B'};">
                        <i class="bi bi-trash me-1"></i>
                        Deleting this job posting will also remove candidate applications.
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: '<i class="bi bi-trash-fill me-1"></i> Yes, Delete Job',
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
