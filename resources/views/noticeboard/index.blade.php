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

    .notice-hero-card {
        background: linear-gradient(-45deg, #7F1D1D, #991B1B, #C2410C, #EA580C);
        background-size: 300% 300%;
        animation: gradientMesh 12s ease infinite, fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        border-radius: 24px;
        padding: 2.25rem 2.5rem;
        color: #ffffff;
        margin-bottom: 1.75rem;
        box-shadow: 0 20px 45px rgba(234, 88, 12, 0.3);
        position: relative;
        overflow: hidden;
    }

    .notice-hero-card::after {
        content: '';
        position: absolute;
        right: 0;
        bottom: 0;
        top: 0;
        width: 45%;
        background: radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.15) 0%, transparent 60%);
        pointer-events: none;
    }

    .notice-year-chip {
        background: rgba(255, 255, 255, 0.18);
        backdrop-filter: blur(10px);
        color: #ffffff;
        font-size: 0.76rem;
        font-weight: 700;
        padding: 0.35rem 0.85rem;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        margin-bottom: 1.25rem;
    }

    .notice-hero-title {
        font-size: 2.1rem;
        font-weight: 800;
        letter-spacing: -0.03em;
        line-height: 1.15;
        margin-bottom: 0.65rem;
    }

    .notice-hero-sub {
        font-size: 0.92rem;
        color: rgba(255, 255, 255, 0.85);
        max-width: 520px;
        line-height: 1.45;
        margin-bottom: 0;
    }

    .notice-post-btn {
        background: #ffffff;
        color: #1E293B;
        border: none;
        border-radius: 16px;
        padding: 0.75rem 1.4rem;
        font-size: 0.88rem;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        transition: all 0.2s ease;
    }

    .notice-post-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.18);
        color: #EA580C;
    }

    /* Image-Style Soft Pastel Cards (4 Cards in 1 Row) */
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

    .card-pastel-amber {
        background: linear-gradient(135deg, #FFFBEB 0%, #FEF3C7 100%);
        border-color: #FDE68A;
    }

    .card-pastel-emerald {
        background: linear-gradient(135deg, #ECFDF5 0%, #D1FAE5 100%);
        border-color: #A7F3D0;
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

    /* Main Announcement Feed Cards */
    .message-feed-card {
        background: linear-gradient(135deg, #FFFFFF 0%, #FAFAF9 50%, #F5F3FF 100%);
        border-radius: 22px;
        border: 1px solid #EDE9FE;
        box-shadow: 0 10px 30px rgba(124, 58, 237, 0.05);
        padding: 1.85rem;
        position: relative;
        overflow: hidden;
        border-left: 4px solid #EA580C;
        margin-bottom: 1.5rem;
        animation: fadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) both;
    }

    .ribbon-pin-tag {
        position: absolute;
        top: 0;
        right: 1.5rem;
        background: #EA580C;
        color: #ffffff;
        padding: 0.4rem 0.65rem 0.65rem 0.65rem;
        border-bottom-left-radius: 8px;
        border-bottom-right-radius: 8px;
        font-size: 0.9rem;
        box-shadow: 0 4px 10px rgba(234, 88, 12, 0.3);
    }

    .author-avatar-img {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        object-fit: cover;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
    }

    .feed-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: #0F172A;
        letter-spacing: -0.02em;
        margin-top: 1.25rem;
        margin-bottom: 0.75rem;
    }

    .feed-body-text {
        font-size: 0.9rem;
        color: #475569;
        line-height: 1.65;
        margin-bottom: 1.5rem;
    }

    .rsvp-btn-action {
        background: #ffffff;
        color: #EA580C;
        border: 1px solid #FFEDD5;
        border-radius: 12px;
        padding: 0.5rem 1.15rem;
        font-size: 0.8rem;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        box-shadow: 0 2px 8px rgba(234, 88, 12, 0.06);
        transition: all 0.2s ease;
    }

    .rsvp-btn-action:hover {
        background: #EA580C;
        color: #ffffff;
        border-color: #EA580C;
    }

    /* Right Column Widgets */
    .widget-panel-card {
        background: #ffffff;
        border-radius: 22px;
        border: 1px solid #F1F5F9;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        padding: 1.35rem;
        margin-bottom: 1.25rem;
    }

    .widget-title-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .widget-title-text {
        font-size: 0.92rem;
        font-weight: 800;
        color: #0F172A;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .widget-item-row {
        background: #F8FAFC;
        border-radius: 14px;
        padding: 0.85rem 1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.75rem;
    }

    /* Dark Mode Overrides */
    [data-bs-theme="dark"] .pastel-ui8-card,
    [data-bs-theme="dark"] .message-feed-card,
    [data-bs-theme="dark"] .widget-panel-card {
        background: #1F2937 !important;
        border-color: #374151 !important;
    }
    [data-bs-theme="dark"] .ui8-card-title,
    [data-bs-theme="dark"] .feed-title { color: #F8FAFC !important; }
    [data-bs-theme="dark"] .feed-body-text { color: #9CA3AF !important; }
    [data-bs-theme="dark"] .ui8-pill-val,
    [data-bs-theme="dark"] .ui8-tag-chip {
        background: #111827 !important;
        color: #F8FAFC !important;
        border-color: #374151 !important;
    }
</style>
@endpush

@section('content')
<!-- Hero Card -->
<div class="notice-hero-card">
    <div class="d-flex justify-content-between align-items-start">
        <div>
            <div class="notice-year-chip">
                <i class="bi bi-calendar-event"></i> Year 2026
            </div>
            <h2 class="notice-hero-title">Company Notice Board & Announcements</h2>
            <p class="notice-hero-sub">
                Official corporate broadcasts, townhall notices, team celebrations, and policy updates.
            </p>
        </div>
        <button class="notice-post-btn" data-bs-toggle="modal" data-bs-target="#createAnnouncementModal">
            <i class="bi bi-megaphone-fill" style="color: #EA580C;"></i> Post Announcement
        </button>
    </div>
</div>

<!-- Image-Style Soft Pastel KPI Cards (4 Cards in 1 Row) -->
<div class="row g-3 mb-4">
    <!-- Card 1: Active Broadcasts (Soft Amber) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-amber">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-broadcast me-1"></i> Live Broadcasts
                    </span>
                    <span class="ui8-pill-val" style="color: #D97706;">
                        {{ $stats['active_broadcasts'] }} Active
                    </span>
                </div>
                <h4 class="ui8-card-title">Active Broadcasts</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Live Company Notices
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-warning shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-megaphone-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Broadcasts</span>
                    <span class="ui8-tag-chip">#Notices</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Upcoming Celebrations (Soft Emerald) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-emerald">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-cake2 me-1"></i> Celebrations
                    </span>
                    <span class="ui8-pill-val" style="color: #059669;">
                        {{ $stats['birthdays_count'] }} Birthdays
                    </span>
                </div>
                <h4 class="ui8-card-title">Team Celebrations</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Staff Events & Birthdays
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-success shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-cake2-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Celebrations</span>
                    <span class="ui8-tag-chip">#Events</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Total Notices (Soft Purple) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-purple">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-journal-text me-1"></i> All Time
                    </span>
                    <span class="ui8-pill-val" style="color: #7C3AED;">
                        {{ $stats['total_notices'] }} Notices
                    </span>
                </div>
                <h4 class="ui8-card-title">Total Announcements</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Corporate Archives
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-purple shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800; color: #7C3AED;">
                        <i class="bi bi-archive-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Archives</span>
                    <span class="ui8-tag-chip">#History</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Policy Library (Soft Sky Blue) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-indigo">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-file-earmark-text me-1"></i> Policy Docs
                    </span>
                    <span class="ui8-pill-val" style="color: #0284C7;">
                        {{ $stats['policies_count'] }} Files
                    </span>
                </div>
                <h4 class="ui8-card-title">Policy Documents</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Employee Library
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-info shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-file-earmark-pdf-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Library</span>
                    <span class="ui8-tag-chip">#Policies</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Section: Feed + Right Widgets -->
<div class="row g-4">
    <!-- Left Column: Dynamic Announcement Feed -->
    <div class="col-12 col-lg-8">
        @forelse($announcements as $ann)
            <div class="message-feed-card">
                <div class="ribbon-pin-tag">
                    <i class="bi bi-pin-angle-fill"></i>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=100&q=80" 
                             class="author-avatar-img">
                        <div>
                            <div class="fw-extrabold text-dark fs-7">Corporate Executive Office</div>
                            <div class="fs-8 text-muted">
                                Published {{ $ann->published_at ? $ann->published_at->diffForHumans() : 'Recently' }} • Company: {{ $ann->company?->name }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="feed-title">
                    {{ $ann->title }}
                </div>

                <div class="feed-body-text">
                    {!! nl2br(e($ann->body)) !!}
                </div>

                <div class="d-flex align-items-center justify-content-between pt-3 border-top">
                    <button class="rsvp-btn-action" 
                            onclick="Swal.fire({icon: 'success', title: 'RSVP Acknowledged!', text: 'Your acknowledgment for {{ addslashes($ann->title) }} is registered.', confirmButtonColor: '#EA580C', customClass: {popup: 'rounded-4 border-0 shadow-lg'}})">
                        <i class="bi bi-calendar-check text-warning"></i> Acknowledge & RSVP
                    </button>

                    <form action="{{ route('noticeboard.destroy', $ann->id) }}" method="POST" onsubmit="event.preventDefault(); confirmDeleteAnnouncement('{{ $ann->id }}', '{{ addslashes($ann->title) }}', this);">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-light rounded-circle text-danger" title="Delete Announcement">
                            <i class="bi bi-trash-fill fs-8"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center py-5 text-muted bg-white rounded-4 border p-4">
                <i class="bi bi-megaphone fs-2 d-block mb-2 text-slate-300"></i>
                <div class="fw-bold text-dark">No announcements posted yet</div>
                <p class="fs-8 text-muted mb-3">Click "Post Announcement" to broadcast news to all staff.</p>
            </div>
        @endforelse

        @if($announcements->hasPages())
            <div class="mt-3">
                {{ $announcements->links() }}
            </div>
        @endif
    </div>

    <!-- Right Column: Sidebar Widgets (100% Fully Dynamic) -->
    <div class="col-12 col-lg-4">
        <!-- Widget 1: Dynamic Upcoming Birthdays -->
        <div class="widget-panel-card">
            <div class="widget-title-row">
                <div class="widget-title-text">
                    <span class="p-1.5 bg-amber bg-opacity-10 text-amber rounded-3" style="background: #FEF3C7; color: #D97706;">
                        <i class="bi bi-cake2-fill"></i>
                    </span>
                    Upcoming Birthdays
                </div>
                <span class="ui8-tag-chip">Staff Roster</span>
            </div>

            @forelse($upcomingBirthdays as $emp)
                <div class="widget-item-row">
                    <div class="d-flex align-items-center gap-2.5">
                        <div class="rounded-circle bg-amber text-warning d-flex align-items-center justify-content-center fw-bold fs-7 shadow-sm" 
                             style="width: 36px; height: 36px; background: #FEF3C7; color: #D97706;">
                            {{ substr($emp->first_name, 0, 1) }}{{ substr($emp->last_name, 0, 1) }}
                        </div>
                        <div>
                            <div class="fw-bold text-dark fs-7">{{ $emp->full_name }}</div>
                            <div class="fs-8 text-muted">{{ $emp->department?->name ?? 'Staff' }}</div>
                        </div>
                    </div>
                    <span class="badge bg-white text-dark border px-2.5 py-1 fs-8 font-monospace shadow-2xs">
                        🗓️ {{ $emp->dob ? $emp->dob->format('M d') : 'N/A' }}
                    </span>
                </div>
            @empty
                <div class="widget-item-row text-center text-muted fs-8 py-3">
                    No upcoming birthdays this month
                </div>
            @endforelse
        </div>

        <!-- Widget 2: Dynamic Policy Library -->
        <div class="widget-panel-card">
            <div class="widget-title-row">
                <div class="widget-title-text">
                    <span class="p-1.5 bg-blue bg-opacity-10 text-primary rounded-3" style="background: #EFF6FF; color: #2563EB;">
                        <i class="bi bi-file-earmark-pdf-fill"></i>
                    </span>
                    Policy Library
                </div>
                <button class="btn btn-sm btn-light rounded-pill fs-8 fw-bold text-primary" data-bs-toggle="modal" data-bs-target="#createPolicyModal">
                    <i class="bi bi-plus me-1"></i> Add Policy
                </button>
            </div>

            @forelse($policyDocuments as $policy)
                <div class="widget-item-row">
                    <div>
                        <div class="fw-bold text-dark fs-7">{{ $policy->title }}</div>
                        <div class="fs-8 text-muted">{{ $policy->category }} • {{ $policy->file_size }}</div>
                    </div>
                    @if($policy->file_path)
                        <a href="{{ route('noticeboard.policies.download', $policy->id) }}" 
                           class="btn btn-light rounded-circle d-flex align-items-center justify-content-center p-0 text-primary shadow-2xs" 
                           style="width: 34px; height: 34px; background: #ffffff; border: 1px solid #E2E8F0;"
                           title="Download Real Policy Document">
                            <i class="bi bi-download"></i>
                        </a>
                    @else
                        <button class="btn btn-light rounded-circle d-flex align-items-center justify-content-center p-0 text-primary shadow-2xs" 
                                onclick="Swal.fire({icon: 'info', title: '{{ addslashes($policy->title) }}', text: 'Document Category: {{ $policy->category }} (Size: {{ $policy->file_size }}). Pre-seeded policy record.', confirmButtonColor: '#2563EB'})"
                                style="width: 34px; height: 34px; background: #ffffff; border: 1px solid #E2E8F0;"
                                title="Policy Info">
                            <i class="bi bi-info-circle"></i>
                        </button>
                    @endif
                </div>
            @empty
                <div class="widget-item-row text-center text-muted fs-8 py-3">
                    No policy documents uploaded
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Create Announcement Modal -->
<div class="modal fade" id="createAnnouncementModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom px-4 py-3">
                <h5 class="modal-title fw-bold fs-6 text-dark">Post New Company Announcement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('noticeboard.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Target Company <span class="text-danger">*</span></label>
                        <select name="company_id" class="form-select rounded-3 fs-8" required>
                            @foreach($companies as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Announcement Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control rounded-3 fs-8" placeholder="e.g. Quarterly All-Hands Townhall & Q3 Awards" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Message Content & Details <span class="text-danger">*</span></label>
                        <textarea name="body" class="form-control rounded-3 fs-8" rows="4" placeholder="Write full broadcast notice details..." required></textarea>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Publish Date & Time <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="published_at" class="form-control rounded-3 fs-8" value="{{ date('Y-m-d\TH:i') }}" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Expiry Date (Optional)</label>
                            <input type="date" name="expires_at" class="form-control rounded-3 fs-8" value="{{ date('Y-m-d', strtotime('+30 days')) }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4 fs-8 fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fs-8 fw-bold" style="background: #EA580C; border: none;">Broadcast Announcement</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Create Policy Modal (Supports Real File Upload) -->
<div class="modal fade" id="createPolicyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom px-4 py-3">
                <h5 class="modal-title fw-bold fs-6 text-dark">Upload Real Policy Document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('noticeboard.policies.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Policy Document Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control rounded-3 fs-8" placeholder="e.g. Corporate Travel & Reimbursement Policy 2026" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Policy Category <span class="text-danger">*</span></label>
                        <select name="category" class="form-select rounded-3 fs-8" required>
                            <option value="HR & Employee Policy">HR & Employee Policy</option>
                            <option value="IT & Cyber Security Guidelines">IT & Cyber Security Guidelines</option>
                            <option value="Finance & Travel Expense">Finance & Travel Expense</option>
                            <option value="Operations & Compliance">Operations & Compliance</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Select File Document (PDF, Word, Image) <span class="text-danger">*</span></label>
                        <input type="file" name="file" class="form-control rounded-3 fs-8" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg" required>
                        <div class="fs-8 text-muted mt-1"><i class="bi bi-info-circle me-1"></i> Supports PDF, DOC, DOCX, PNG, JPG (Max 10 MB). File size is calculated automatically.</div>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4 fs-8 fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fs-8 fw-bold" style="background: #2563EB; border: none;">Upload & Save Policy File</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmDeleteAnnouncement(id, title, formEl) {
        const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
        
        Swal.fire({
            title: `<div class="d-flex align-items-center justify-content-center gap-2 text-danger fw-bold fs-5 mb-1">
                        <i class="bi bi-exclamation-triangle-fill fs-4"></i> Delete Announcement?
                    </div>`,
            html: `
                <div class="text-center py-2">
                    <p class="fs-7 text-secondary mb-3" style="line-height: 1.6;">
                        Are you sure you want to delete <strong class="text-dark">${title}</strong>?
                    </p>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: '<i class="bi bi-trash-fill me-1"></i> Yes, Delete Notice',
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
