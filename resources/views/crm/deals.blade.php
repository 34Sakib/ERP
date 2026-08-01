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

    .deals-hero {
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
<div class="deals-hero">
    <div class="row align-items-center g-3">
        <div class="col-12 col-md-8">
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge rounded-pill bg-white bg-opacity-20 text-white fs-8 px-2.5 py-1">
                    <i class="bi bi-graph-up-arrow me-1"></i> Sales Pipeline
                </span>
                <span class="fs-8 text-white-50">• ${{ number_format($stats['total_pipeline_value']) }} Total Pipeline Value</span>
            </div>
            <h3 class="mb-1 fw-extrabold text-white" style="letter-spacing: -0.02em;">
                Sales Deals & Opportunities
            </h3>
            <p class="mb-0 text-white-50 fs-7">
                Track revenue opportunities, advance deals through sales stages, and close revenue.
            </p>
        </div>
        <div class="col-12 col-md-4 text-md-end">
            <button class="btn btn-light rounded-pill px-4 py-2.5 fw-bold text-emerald shadow-sm" data-bs-toggle="modal" data-bs-target="#createDealModal" style="color: #059669;">
                <i class="bi bi-plus-circle-fill me-1.5 fs-6"></i> Add Deal Opportunity
            </button>
        </div>
    </div>
</div>

<!-- Image-Style Soft Pastel KPI Cards (4 Cards in 1 Row) -->
<div class="row g-3 mb-4">
    <!-- Card 1: Pipeline Value (Soft Emerald) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-emerald">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-cash-stack me-1"></i> Active Value
                    </span>
                    <span class="ui8-pill-val" style="color: #059669;">
                        ${{ number_format($stats['total_pipeline_value']) }}
                    </span>
                </div>
                <h4 class="ui8-card-title">Total Pipeline Value</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Open Opportunities
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-success shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-graph-up"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Pipeline</span>
                    <span class="ui8-tag-chip">#Revenue</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Won Deals (Soft Sky Blue) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-indigo">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-trophy-fill me-1"></i> Closed Won
                    </span>
                    <span class="ui8-pill-val" style="color: #0284C7;">
                        ${{ number_format($stats['won_value']) }}
                    </span>
                </div>
                <h4 class="ui8-card-title">Won Revenue</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Secured Contracts
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-info shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-check-circle-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Won</span>
                    <span class="ui8-tag-chip">#Secured</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: In Negotiation (Soft Amber) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-amber">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-briefcase me-1"></i> Final Stages
                    </span>
                    <span class="ui8-pill-val" style="color: #D97706;">
                        {{ $stats['negotiation_count'] }} Deals
                    </span>
                </div>
                <h4 class="ui8-card-title">Under Negotiation</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Finalizing Terms
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-warning shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-handshake-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Negotiation</span>
                    <span class="ui8-tag-chip">#FinalStage</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Proposal Stage (Soft Purple) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-purple">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-file-earmark-text me-1"></i> Sent Quotes
                    </span>
                    <span class="ui8-pill-val" style="color: #7C3AED;">
                        {{ $stats['proposal_count'] }} Proposals
                    </span>
                </div>
                <h4 class="ui8-card-title">Proposal Sent</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Active Quotations
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-purple shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800; color: #7C3AED;">
                        <i class="bi bi-file-earmark-text-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Proposal</span>
                    <span class="ui8-tag-chip">#Quotes</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Deals Table -->
<div class="directory-card">
    <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light bg-opacity-50">
        <div class="fs-8 text-muted fw-bold">
            Showing <strong class="text-dark">{{ $deals->firstItem() ?? 0 }} - {{ $deals->lastItem() ?? 0 }}</strong> of <strong class="text-dark">{{ $deals->total() }}</strong> Pipeline Deals
        </div>
        <form method="GET" action="{{ route('crm.deals.index') }}" class="d-flex gap-2">
            <input type="text" name="search" class="form-control rounded-pill fs-8 ps-3" value="{{ request('search') }}" placeholder="Search deal title...">
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-directory align-middle mb-0 fs-7">
            <thead>
                <tr>
                    <th>DEAL OPPORTUNITY</th>
                    <th>CLIENT / LEAD</th>
                    <th>DEAL VALUE</th>
                    <th>EXPECTED CLOSE</th>
                    <th>OWNER</th>
                    <th>PIPELINE STAGE</th>
                    <th class="text-end pe-3">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($deals as $d)
                    <tr>
                        <td>
                            <div class="fw-bold text-dark fs-7">{{ $d->title }}</div>
                            <div class="fs-8 text-muted">{{ $d->crmTasks->where('status', 'pending')->count() }} Pending Tasks</div>
                        </td>
                        <td>
                            <div class="fw-bold text-dark fs-8">{{ $d->lead?->name ?? 'Direct Contact' }}</div>
                            <div class="fs-8 text-secondary">{{ $d->lead?->company?->name }}</div>
                        </td>
                        <td class="fw-extrabold text-success fs-7 font-monospace" style="color: #059669;">
                            ${{ number_format($d->value, 2) }}
                        </td>
                        <td class="fw-bold text-dark fs-8 font-monospace">
                            {{ $d->expected_close_date ? $d->expected_close_date->format('M d, Y') : 'N/A' }}
                        </td>
                        <td>
                            <div class="fs-8 fw-bold text-dark">{{ $d->owner?->name ?? 'Sales Exec' }}</div>
                        </td>
                        <td>
                            <form action="{{ route('crm.deals.stage', $d->id) }}" method="POST" class="d-inline">
                                @csrf
                                <select name="stage" class="form-select form-select-sm rounded-pill fs-8 d-inline-block w-auto" onchange="this.form.submit()">
                                    <option value="prospecting" {{ $d->stage == 'prospecting' ? 'selected' : '' }}>Prospecting</option>
                                    <option value="proposal" {{ $d->stage == 'proposal' ? 'selected' : '' }}>Proposal Sent</option>
                                    <option value="negotiation" {{ $d->stage == 'negotiation' ? 'selected' : '' }}>Under Negotiation</option>
                                    <option value="won" {{ $d->stage == 'won' ? 'selected' : '' }}>Closed Won</option>
                                    <option value="lost" {{ $d->stage == 'lost' ? 'selected' : '' }}>Closed Lost</option>
                                </select>
                            </form>
                        </td>
                        <td class="text-end pe-3">
                            <form action="{{ route('crm.deals.destroy', $d->id) }}" method="POST" onsubmit="event.preventDefault(); confirmDeleteDeal('{{ $d->id }}', '{{ addslashes($d->title) }}', this);">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light rounded-circle text-danger" title="Delete Deal">
                                    <i class="bi bi-trash-fill fs-8"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted fs-7">
                            <i class="bi bi-graph-up-arrow fs-2 d-block mb-2 text-slate-300"></i>
                            <div class="fw-bold text-dark">No sales deals in pipeline</div>
                            <p class="fs-8 text-muted mb-3">Click "Add Deal Opportunity" to track revenue opportunities.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($deals->hasPages())
        <div class="p-3 border-top bg-light d-flex justify-content-between align-items-center">
            <div class="fs-8 text-muted">Showing {{ $deals->firstItem() }} to {{ $deals->lastItem() }} of {{ $deals->total() }} entries</div>
            <div>{{ $deals->links() }}</div>
        </div>
    @endif
</div>

<!-- Create Deal Modal -->
<div class="modal fade" id="createDealModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom px-4 py-3">
                <h5 class="modal-title fw-bold fs-6 text-dark">Create Sales Deal Opportunity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('crm.deals.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Deal Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control rounded-3 fs-8" placeholder="e.g. Enterprise ERP License Contract" required>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Associated Lead / Client</label>
                            <select name="lead_id" class="form-select rounded-3 fs-8">
                                <option value="">Select Lead</option>
                                @foreach($leads as $l)
                                    <option value="{{ $l->id }}">{{ $l->name }} ({{ $l->company?->name ?? 'Individual' }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Deal Value ($) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="value" class="form-control rounded-3 fs-8" placeholder="50000.00" required>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Pipeline Stage</label>
                            <select name="stage" class="form-select rounded-3 fs-8">
                                <option value="prospecting">Prospecting</option>
                                <option value="proposal">Proposal Sent</option>
                                <option value="negotiation">Under Negotiation</option>
                                <option value="won">Closed Won</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Expected Close Date</label>
                            <input type="date" name="expected_close_date" class="form-control rounded-3 fs-8" value="{{ date('Y-m-d', strtotime('+30 days')) }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4 fs-8 fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-emerald rounded-pill px-4 fs-8 fw-bold text-white" style="background: #059669; border: none;">Save Opportunity</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmDeleteDeal(id, title, formEl) {
        const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
        
        Swal.fire({
            title: `<div class="d-flex align-items-center justify-content-center gap-2 text-danger fw-bold fs-5 mb-1">
                        <i class="bi bi-exclamation-triangle-fill fs-4"></i> Delete Deal Opportunity?
                    </div>`,
            html: `
                <div class="text-center py-2">
                    <p class="fs-7 text-secondary mb-3" style="line-height: 1.6;">
                        Are you sure you want to delete <strong class="text-dark">${title}</strong>?
                    </p>
                    <div class="alert alert-danger border-0 fs-8 py-2.5 px-3 text-start mb-0 rounded-3" style="background: ${isDark ? '#374151' : '#FEF2F2'}; color: ${isDark ? '#F87171' : '#991B1B'};">
                        <i class="bi bi-trash me-1"></i>
                        Deleting this deal will remove it from the pipeline metrics.
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: '<i class="bi bi-trash-fill me-1"></i> Yes, Delete Deal',
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
