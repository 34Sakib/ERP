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

    .runs-hero {
        background: linear-gradient(-45deg, #059669, #10B981, #0D9488, #047857);
        background-size: 300% 300%;
        animation: gradientMesh 12s ease infinite, fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        border-radius: 24px;
        padding: 2.25rem 2.5rem;
        color: #ffffff;
        margin-bottom: 1.75rem;
        box-shadow: 0 20px 45px rgba(16, 185, 129, 0.3);
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
<div class="runs-hero">
    <div class="row align-items-center g-3">
        <div class="col-12 col-md-8">
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge rounded-pill bg-white bg-opacity-20 text-white fs-8 px-2.5 py-1">
                    <i class="bi bi-play-circle-fill me-1"></i> Batch Payroll Processing
                </span>
                <span class="fs-8 text-white-50">• {{ $stats['total_runs'] }} Processed Payroll Runs</span>
            </div>
            <h3 class="mb-1 fw-extrabold text-white" style="letter-spacing: -0.02em;">
                Monthly Batch Payroll Runs
            </h3>
            <p class="mb-0 text-white-50 fs-7">
                Generate monthly salary batches, process company disbursements, and issue payslips.
            </p>
        </div>
        <div class="col-12 col-md-4 text-md-end">
            <button class="btn btn-light rounded-pill px-4 py-2.5 fw-bold text-emerald shadow-sm" data-bs-toggle="modal" data-bs-target="#createRunModal" style="color: #059669;">
                <i class="bi bi-plus-circle-fill me-1.5 fs-6"></i> Process New Payroll Run
            </button>
        </div>
    </div>
</div>

<!-- Image-Style Soft Pastel KPI Cards (4 Cards in 1 Row) -->
<div class="row g-3 mb-4">
    <!-- Card 1: Total Disbursed (Soft Emerald) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-emerald">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-wallet-fill me-1"></i> Total Paid Out
                    </span>
                    <span class="ui8-pill-val" style="color: #059669;">
                        ${{ number_format($stats['total_disbursed']) }}
                    </span>
                </div>
                <h4 class="ui8-card-title">Total Disbursed</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Completed Salary Runs
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-success shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-check-circle-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Disbursed</span>
                    <span class="ui8-tag-chip">#PaidOut</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Pending Approval (Soft Amber) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-amber">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-clock-history me-1"></i> Review Queue
                    </span>
                    <span class="ui8-pill-val" style="color: #D97706;">
                        {{ $stats['pending_approval'] }} Pending
                    </span>
                </div>
                <h4 class="ui8-card-title">Pending Approval</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Awaiting Authorization
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-warning shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-exclamation-circle-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Pending</span>
                    <span class="ui8-tag-chip">#Review</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Total Runs (Soft Sky Blue) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-indigo">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-journal-text me-1"></i> Batch Count
                    </span>
                    <span class="ui8-pill-val" style="color: #0284C7;">
                        {{ $stats['total_runs'] }} Runs
                    </span>
                </div>
                <h4 class="ui8-card-title">Total Payroll Runs</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Historic Batch Batches
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-info shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-collection-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Batches</span>
                    <span class="ui8-tag-chip">#History</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Draft Batches (Soft Purple) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-purple">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-file-earmark-code me-1"></i> Preparation
                    </span>
                    <span class="ui8-pill-val" style="color: #7C3AED;">
                        {{ $stats['draft_count'] }} Drafts
                    </span>
                </div>
                <h4 class="ui8-card-title">Draft Runs</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Unsubmitted Batch Runs
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-purple shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800; color: #7C3AED;">
                        <i class="bi bi-pencil-square"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Draft</span>
                    <span class="ui8-tag-chip">#Prep</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payroll Runs Table -->
<div class="directory-card">
    <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light bg-opacity-50">
        <div class="fs-8 text-muted fw-bold">
            Showing <strong class="text-dark">{{ $runs->firstItem() ?? 0 }} - {{ $runs->lastItem() ?? 0 }}</strong> of <strong class="text-dark">{{ $runs->total() }}</strong> Processed Payroll Runs
        </div>
        <span class="badge bg-success bg-opacity-10 text-success px-3 py-1.5 rounded-pill fs-8 fw-bold">
            <i class="bi bi-play-circle me-1"></i> Active Processing
        </span>
    </div>

    <div class="table-responsive">
        <table class="table table-directory align-middle mb-0 fs-7">
            <thead>
                <tr>
                    <th>PAYROLL PERIOD</th>
                    <th>COMPANY SCOPE</th>
                    <th>TOTAL DISBURSEMENT</th>
                    <th>GENERATED BY</th>
                    <th>STATUS</th>
                    <th class="text-end pe-3">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($runs as $r)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2.5">
                                <div class="p-2 bg-success bg-opacity-10 text-success rounded-3 fs-5">
                                    <i class="bi bi-calendar-check-fill"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark fs-7">{{ DateTime::createFromFormat('!m', $r->month)->format('F') }} {{ $r->year }}</div>
                                    <div class="fs-8 text-muted">{{ $r->payslips->count() }} Payslips Generated</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge rounded-pill bg-primary-subtle text-primary border px-2.5 py-1 fs-8" style="background: #EEF2FF; color: #4F46E5;">
                                <i class="bi bi-building me-1"></i> {{ $r->company?->name ?? 'All Companies' }}
                            </span>
                        </td>
                        <td class="fw-bold text-dark fs-7 font-monospace">
                            ${{ number_format($r->total_amount, 2) }}
                        </td>
                        <td>
                            <div class="fs-8 fw-bold text-dark">{{ $r->generator?->name ?? 'Administrator' }}</div>
                            <div class="fs-8 text-muted">{{ $r->created_at->format('M d, Y') }}</div>
                        </td>
                        <td>
                            @if($r->status === 'paid')
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1 rounded-pill fs-8">Disbursed & Paid</span>
                            @elseif($r->status === 'pending_approval')
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2.5 py-1 rounded-pill fs-8">Pending Approval</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary px-2.5 py-1 rounded-pill fs-8">Draft Batch</span>
                            @endif
                        </td>
                        <td class="text-end pe-3">
                            @if($r->status === 'pending_approval')
                                <form action="{{ route('payroll.runs.approve', $r->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success rounded-pill px-3.5 fs-8 fw-bold">
                                        <i class="bi bi-check-circle me-1"></i> Approve & Disburse
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('payroll.payslips.index') }}" class="btn btn-sm btn-light rounded-pill px-3 fs-8 fw-bold text-primary">
                                    View Payslips
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted fs-7">
                            <i class="bi bi-play-circle fs-2 d-block mb-2 text-slate-300"></i>
                            <div class="fw-bold text-dark">No payroll runs processed yet</div>
                            <p class="fs-8 text-muted mb-3">Click "Process New Payroll Run" to generate monthly salary batches.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($runs->hasPages())
        <div class="p-3 border-top bg-light d-flex justify-content-between align-items-center">
            <div class="fs-8 text-muted">Showing {{ $runs->firstItem() }} to {{ $runs->lastItem() }} of {{ $runs->total() }} entries</div>
            <div>{{ $runs->links() }}</div>
        </div>
    @endif
</div>

<!-- Process New Payroll Run Modal -->
<div class="modal fade" id="createRunModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom px-4 py-3">
                <h5 class="modal-title fw-bold fs-6 text-dark">Process New Monthly Payroll Run</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('payroll.runs.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Company Scope <span class="text-danger">*</span></label>
                        <select name="company_id" class="form-select rounded-3 fs-8" required>
                            @foreach($companies as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Payroll Month <span class="text-danger">*</span></label>
                            <select name="month" class="form-select rounded-3 fs-8" required>
                                @for($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ $m == date('n') ? 'selected' : '' }}>
                                        {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Payroll Year <span class="text-danger">*</span></label>
                            <input type="number" name="year" class="form-control rounded-3 fs-8" value="{{ date('Y') }}" required>
                        </div>
                    </div>

                    <div class="alert alert-info border-0 fs-8 p-3 rounded-3 mb-0" style="background: #EFF6FF; color: #1E40AF;">
                        <i class="bi bi-info-circle me-1"></i> Processing a payroll run will calculate base salaries, allowances, and tax deductions for all active employees.
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4 fs-8 fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-emerald rounded-pill px-4 fs-8 fw-bold text-white" style="background: #059669; border: none;">Generate Batch Run</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
