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

    .maintenance-hero {
        background: linear-gradient(-45deg, #D97706, #F59E0B, #B45309, #92400E);
        background-size: 300% 300%;
        animation: gradientMesh 12s ease infinite, fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        border-radius: 24px;
        padding: 2.25rem 2.5rem;
        color: #ffffff;
        margin-bottom: 1.75rem;
        box-shadow: 0 20px 45px rgba(217, 119, 6, 0.3);
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
        box-shadow: inset 3px 0 0 #F59E0B;
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
<div class="maintenance-hero">
    <div class="row align-items-center g-3">
        <div class="col-12 col-md-8">
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge rounded-pill bg-white bg-opacity-20 text-white fs-8 px-2.5 py-1">
                    <i class="bi bi-wrench me-1"></i> Asset Maintenance Logs
                </span>
                <span class="fs-8 text-white-50">• ${{ number_format($stats['total_maintenance_cost']) }} Repair Expenses</span>
            </div>
            <h3 class="mb-1 fw-extrabold text-white" style="letter-spacing: -0.02em;">
                Hardware Repairs & Maintenance Logs
            </h3>
            <p class="mb-0 text-white-50 fs-7">
                Log equipment repair tickets, track vendor service costs, and audit maintenance history.
            </p>
        </div>
        <div class="col-12 col-md-4 text-md-end">
            <button class="btn btn-light rounded-pill px-4 py-2.5 fw-bold text-amber shadow-sm" data-bs-toggle="modal" data-bs-target="#createMaintenanceModal" style="color: #D97706;">
                <i class="bi bi-plus-circle-fill me-1.5 fs-6"></i> Log Repair Service
            </button>
        </div>
    </div>
</div>

<!-- Image-Style Soft Pastel KPI Cards (4 Cards in 1 Row) -->
<div class="row g-3 mb-4">
    <!-- Card 1: Total Repair Expense (Soft Amber) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-amber">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-currency-dollar me-1"></i> Repair Budget
                    </span>
                    <span class="ui8-pill-val" style="color: #D97706;">
                        ${{ number_format($stats['total_maintenance_cost']) }}
                    </span>
                </div>
                <h4 class="ui8-card-title">Total Repair Expense</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Cumulative Service Costs
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-warning shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-cash-coin"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Expenses</span>
                    <span class="ui8-tag-chip">#Repairs</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Assets in Repair (Soft Purple) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-purple">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-tools me-1"></i> In Shop
                    </span>
                    <span class="ui8-pill-val" style="color: #7C3AED;">
                        {{ $stats['assets_in_maintenance'] }} Items
                    </span>
                </div>
                <h4 class="ui8-card-title">Assets in Repair</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Under Active Servicing
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-purple shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800; color: #7C3AED;">
                        <i class="bi bi-wrench-adjustable-circle-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#InShop</span>
                    <span class="ui8-tag-chip">#Servicing</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Total Service Logs (Soft Sky Blue) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-indigo">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-journal-text me-1"></i> Tickets Logged
                    </span>
                    <span class="ui8-pill-val" style="color: #0284C7;">
                        {{ $stats['total_service_logs'] }} Tickets
                    </span>
                </div>
                <h4 class="ui8-card-title">Total Service Logs</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Completed Tickets
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-info shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-card-checklist"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Tickets</span>
                    <span class="ui8-tag-chip">#Logs</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Vendor Support (Soft Emerald) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-emerald">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-building-check me-1"></i> Authorized Vendors
                    </span>
                    <span class="ui8-pill-val" style="color: #059669;">
                        Certified
                    </span>
                </div>
                <h4 class="ui8-card-title">Vendor Services</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Official Repair Centers
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-success shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-shield-check"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Vendors</span>
                    <span class="ui8-tag-chip">#Certified</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Maintenance Table -->
<div class="directory-card">
    <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light bg-opacity-50">
        <div class="fs-8 text-muted fw-bold">
            Showing <strong class="text-dark">{{ $maintenances->firstItem() ?? 0 }} - {{ $maintenances->lastItem() ?? 0 }}</strong> of <strong class="text-dark">{{ $maintenances->total() }}</strong> Maintenance Service Logs
        </div>
        <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-1.5 rounded-pill fs-8 fw-bold">
            <i class="bi bi-wrench me-1"></i> Repair Audit Trail
        </span>
    </div>

    <div class="table-responsive">
        <table class="table table-directory align-middle mb-0 fs-7">
            <thead>
                <tr>
                    <th>ASSET DETAILS</th>
                    <th>SERVICE DESCRIPTION</th>
                    <th>REPAIR COST</th>
                    <th>SERVICE DATE</th>
                    <th>VENDOR / REPAIR CENTER</th>
                </tr>
            </thead>
            <tbody>
                @forelse($maintenances as $m)
                    <tr>
                        <td>
                            <div class="fw-bold text-dark fs-7">{{ $m->asset?->brand }} {{ $m->asset?->model }}</div>
                            <div class="fs-8 text-muted"><code class="text-indigo bg-light px-1.5 py-0.5 rounded">{{ $m->asset?->asset_tag }}</code></div>
                        </td>
                        <td>
                            <div class="fs-8 text-dark" style="max-width: 320px;" title="{{ $m->description }}">
                                {{ $m->description }}
                            </div>
                        </td>
                        <td class="fw-bold text-dark fs-8 font-monospace">
                            ${{ number_format($m->cost, 2) }}
                        </td>
                        <td class="fw-bold text-dark fs-8 font-monospace">
                            {{ $m->date->format('M d, Y') }}
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border px-2.5 py-1 fs-8 fw-bold">
                                <i class="bi bi-building me-1 text-muted"></i> {{ $m->vendor ?? 'Internal IT' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted fs-7">
                            <i class="bi bi-wrench fs-2 d-block mb-2 text-slate-300"></i>
                            <div class="fw-bold text-dark">No maintenance service logs registered</div>
                            <p class="fs-8 text-muted mb-3">Click "Log Repair Service" to record asset repair costs.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($maintenances->hasPages())
        <div class="p-3 border-top bg-light d-flex justify-content-between align-items-center">
            <div class="fs-8 text-muted">Showing {{ $maintenances->firstItem() }} to {{ $maintenances->lastItem() }} of {{ $maintenances->total() }} entries</div>
            <div>{{ $maintenances->links() }}</div>
        </div>
    @endif
</div>

<!-- Log Service Modal -->
<div class="modal fade" id="createMaintenanceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom px-4 py-3">
                <h5 class="modal-title fw-bold fs-6 text-dark">Log Equipment Repair / Maintenance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('assets.maintenance.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Hardware Asset <span class="text-danger">*</span></label>
                        <select name="asset_id" class="form-select rounded-3 fs-8" required>
                            @foreach($assets as $ast)
                                <option value="{{ $ast->id }}">{{ $ast->asset_tag }} - {{ $ast->brand }} {{ $ast->model }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Repair Cost ($) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="cost" class="form-control rounded-3 fs-8" placeholder="150.00" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Service Date <span class="text-danger">*</span></label>
                            <input type="date" name="date" class="form-control rounded-3 fs-8" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Service Vendor / Repair Center</label>
                        <input type="text" name="vendor" class="form-control rounded-3 fs-8" placeholder="e.g. Apple Authorized Service Center">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Description & Repair Details <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control rounded-3 fs-8" rows="3" placeholder="Provide breakdown description and repair actions taken..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4 fs-8 fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-amber rounded-pill px-4 fs-8 fw-bold text-white" style="background: #D97706; border: none;">Save Service Log</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
