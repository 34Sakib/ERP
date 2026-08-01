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

    .movements-hero {
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
<div class="movements-hero">
    <div class="row align-items-center g-3">
        <div class="col-12 col-md-8">
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge rounded-pill bg-white bg-opacity-20 text-white fs-8 px-2.5 py-1">
                    <i class="bi bi-arrow-left-right me-1"></i> Audit Trail
                </span>
                <span class="fs-8 text-white-50">• {{ $stockMovements->total() }} Logged Stock Adjustments</span>
            </div>
            <h3 class="mb-1 fw-extrabold text-white" style="letter-spacing: -0.02em;">
                Stock Movements & Audit Trail
            </h3>
            <p class="mb-0 text-white-50 fs-7">
                Log stock intake, dispatches, inter-warehouse transfers, and inventory reconciliations.
            </p>
        </div>
        <div class="col-12 col-md-4 text-md-end">
            <button class="btn btn-light rounded-pill px-4 py-2.5 fw-bold text-indigo shadow-sm" data-bs-toggle="modal" data-bs-target="#createMovementModal" style="color: #4F46E5;">
                <i class="bi bi-plus-circle-fill me-1.5 fs-6"></i> Log Stock Movement
            </button>
        </div>
    </div>
</div>

<!-- Image-Style Soft Pastel KPI Cards (4 Cards in 1 Row) -->
<div class="row g-3 mb-4">
    <!-- Card 1: Stock In (Soft Emerald) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-emerald">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-box-arrow-in-down me-1"></i> Stock Intake
                    </span>
                    <span class="ui8-pill-val" style="color: #059669;">
                        +{{ number_format($stats['total_in']) }} Units
                    </span>
                </div>
                <h4 class="ui8-card-title">Stock Intake (In)</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Received Inventory
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-success shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-arrow-down-circle-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#StockIn</span>
                    <span class="ui8-tag-chip">#Intake</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Stock Out (Soft Amber) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-amber">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-box-arrow-up me-1"></i> Dispatched
                    </span>
                    <span class="ui8-pill-val" style="color: #D97706;">
                        -{{ number_format($stats['total_out']) }} Units
                    </span>
                </div>
                <h4 class="ui8-card-title">Stock Out (Dispatched)</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Fulfilled Orders
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-warning shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-arrow-up-circle-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#StockOut</span>
                    <span class="ui8-tag-chip">#Dispatched</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Inter-Depot Transfers (Soft Purple) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-purple">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-arrow-left-right me-1"></i> Transfers
                    </span>
                    <span class="ui8-pill-val" style="color: #7C3AED;">
                        {{ $stats['total_transfers'] }} Transfers
                    </span>
                </div>
                <h4 class="ui8-card-title">Inter-Depot Transfers</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Warehouse Relocations
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-purple shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800; color: #7C3AED;">
                        <i class="bi bi-arrow-repeat"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Transfers</span>
                    <span class="ui8-tag-chip">#Relocations</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Adjustments (Soft Sky Blue) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-indigo">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-sliders me-1"></i> Reconciled
                    </span>
                    <span class="ui8-pill-val" style="color: #0284C7;">
                        {{ $stats['total_adjustments'] }} Adjustments
                    </span>
                </div>
                <h4 class="ui8-card-title">Stock Adjustments</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Audit Reconciliations
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-info shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-sliders"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Audit</span>
                    <span class="ui8-tag-chip">#Adjustments</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stock Movements Table -->
<div class="directory-card">
    <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light bg-opacity-50">
        <div class="fs-8 text-muted fw-bold">
            Showing <strong class="text-dark">{{ $stockMovements->firstItem() ?? 0 }} - {{ $stockMovements->lastItem() ?? 0 }}</strong> of <strong class="text-dark">{{ $stockMovements->total() }}</strong> Stock Movement Entries
        </div>
        <span class="badge bg-indigo bg-opacity-10 text-indigo px-3 py-1.5 rounded-pill fs-8 fw-bold" style="background: #EEF2FF; color: #4F46E5;">
            <i class="bi bi-arrow-left-right me-1"></i> Stock Audit Log
        </span>
    </div>

    <div class="table-responsive">
        <table class="table table-directory align-middle mb-0 fs-7">
            <thead>
                <tr>
                    <th>PRODUCT SKU</th>
                    <th>WAREHOUSE DEPOT</th>
                    <th>MOVEMENT TYPE</th>
                    <th>QUANTITY</th>
                    <th>LOGGED DATE</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stockMovements as $sm)
                    <tr>
                        <td>
                            <div class="fw-bold text-dark fs-7">{{ $sm->product?->name }}</div>
                            <div class="fs-8 text-muted"><code class="text-indigo bg-light px-1.5 py-0.5 rounded">{{ $sm->product?->sku }}</code></div>
                        </td>
                        <td>
                            <div class="fs-8 fw-bold text-dark"><i class="bi bi-building me-1 text-muted"></i> {{ $sm->warehouse?->name }}</div>
                        </td>
                        <td>
                            @if($sm->type === 'in')
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1 rounded-pill fs-8"><i class="bi bi-arrow-down-left me-1"></i> Stock In</span>
                            @elseif($sm->type === 'out')
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2.5 py-1 rounded-pill fs-8"><i class="bi bi-arrow-up-right me-1"></i> Stock Out</span>
                            @elseif($sm->type === 'transfer')
                                <span class="badge bg-purple-subtle text-purple border px-2.5 py-1 rounded-pill fs-8" style="background: #F3E8FF; color: #7C3AED;"><i class="bi bi-arrow-left-right me-1"></i> Transfer</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary px-2.5 py-1 rounded-pill fs-8">Adjustment</span>
                            @endif
                        </td>
                        <td class="fw-extrabold fs-7 font-monospace">
                            {{ $sm->type === 'in' ? '+' : ($sm->type === 'out' ? '-' : '') }}{{ number_format($sm->quantity) }} {{ strtoupper($sm->product?->unit ?? 'pcs') }}
                        </td>
                        <td class="fw-bold text-dark fs-8 font-monospace">
                            {{ $sm->created_at->format('M d, Y H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted fs-7">
                            <i class="bi bi-arrow-left-right fs-2 d-block mb-2 text-slate-300"></i>
                            <div class="fw-bold text-dark">No stock movements logged</div>
                            <p class="fs-8 text-muted mb-3">Click "Log Stock Movement" to record inventory transfers and intake.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($stockMovements->hasPages())
        <div class="p-3 border-top bg-light d-flex justify-content-between align-items-center">
            <div class="fs-8 text-muted">Showing {{ $stockMovements->firstItem() }} to {{ $stockMovements->lastItem() }} of {{ $stockMovements->total() }} entries</div>
            <div>{{ $stockMovements->links() }}</div>
        </div>
    @endif
</div>

<!-- Create Movement Modal -->
<div class="modal fade" id="createMovementModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom px-4 py-3">
                <h5 class="modal-title fw-bold fs-6 text-dark">Log Stock Movement Entry</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('inventory.stock-movements.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Product SKU <span class="text-danger">*</span></label>
                        <select name="product_id" class="form-select rounded-3 fs-8" required>
                            @foreach($products as $prd)
                                <option value="{{ $prd->id }}">{{ $prd->sku }} - {{ $prd->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Warehouse Depot <span class="text-danger">*</span></label>
                        <select name="warehouse_id" class="form-select rounded-3 fs-8" required>
                            @foreach($warehouses as $wh)
                                <option value="{{ $wh->id }}">{{ $wh->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Movement Type <span class="text-danger">*</span></label>
                            <select name="type" class="form-select rounded-3 fs-8" required>
                                <option value="in">Stock In (Intake)</option>
                                <option value="out">Stock Out (Dispatch)</option>
                                <option value="transfer">Inter-Depot Transfer</option>
                                <option value="adjustment">Reconciliation Adjustment</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Quantity <span class="text-danger">*</span></label>
                            <input type="number" name="quantity" class="form-control rounded-3 fs-8" value="10" min="1" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4 fs-8 fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fs-8 fw-bold" style="background: #4F46E5; border: none;">Save Movement Entry</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
