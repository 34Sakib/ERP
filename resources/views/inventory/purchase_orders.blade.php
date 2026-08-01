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

    .po-hero {
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
<div class="po-hero">
    <div class="row align-items-center g-3">
        <div class="col-12 col-md-8">
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge rounded-pill bg-white bg-opacity-20 text-white fs-8 px-2.5 py-1">
                    <i class="bi bi-file-earmark-text-fill me-1"></i> Procurement POs
                </span>
                <span class="fs-8 text-white-50">• ${{ number_format($stats['total_po_value']) }} Total Procurement Value</span>
            </div>
            <h3 class="mb-1 fw-extrabold text-white" style="letter-spacing: -0.02em;">
                Procurement Purchase Orders
            </h3>
            <p class="mb-0 text-white-50 fs-7">
                Issue purchase orders to suppliers, manage receiving status, and track warehouse stock intake.
            </p>
        </div>
        <div class="col-12 col-md-4 text-md-end">
            <button class="btn btn-light rounded-pill px-4 py-2.5 fw-bold text-emerald shadow-sm" data-bs-toggle="modal" data-bs-target="#createPOModal" style="color: #059669;">
                <i class="bi bi-plus-circle-fill me-1.5 fs-6"></i> Issue Purchase Order
            </button>
        </div>
    </div>
</div>

<!-- Image-Style Soft Pastel KPI Cards (4 Cards in 1 Row) -->
<div class="row g-3 mb-4">
    <!-- Card 1: Total Value (Soft Emerald) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-emerald">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-cash-stack me-1"></i> PO Budget
                    </span>
                    <span class="ui8-pill-val" style="color: #059669;">
                        ${{ number_format($stats['total_po_value']) }}
                    </span>
                </div>
                <h4 class="ui8-card-title">Procurement Value</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Total Issued POs
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-success shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-file-earmark-text-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Procurement</span>
                    <span class="ui8-tag-chip">#POs</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Received Orders (Soft Sky Blue) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-indigo">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-box-arrow-in-down me-1"></i> Stock Received
                    </span>
                    <span class="ui8-pill-val" style="color: #0284C7;">
                        ${{ number_format($stats['received_value']) }}
                    </span>
                </div>
                <h4 class="ui8-card-title">Received Inventory</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Restocked Warehouses
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-info shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-check-circle-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Received</span>
                    <span class="ui8-tag-chip">#Restocked</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Pending Delivery (Soft Amber) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-amber">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-truck me-1"></i> In Transit
                    </span>
                    <span class="ui8-pill-val" style="color: #D97706;">
                        {{ $stats['ordered_count'] }} Ordered
                    </span>
                </div>
                <h4 class="ui8-card-title">Pending Receiving</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Awaiting Vendor Delivery
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-warning shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-clock-history"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Ordered</span>
                    <span class="ui8-tag-chip">#InTransit</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Draft POs (Soft Purple) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-purple">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-pencil-square me-1"></i> Draft Mode
                    </span>
                    <span class="ui8-pill-val" style="color: #7C3AED;">
                        {{ $stats['draft_count'] }} Drafts
                    </span>
                </div>
                <h4 class="ui8-card-title">Draft Purchase Orders</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Unsubmitted Orders
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-purple shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800; color: #7C3AED;">
                        <i class="bi bi-file-earmark"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Drafts</span>
                    <span class="ui8-tag-chip">#Pending</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Purchase Orders Table -->
<div class="directory-card">
    <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light bg-opacity-50">
        <div class="fs-8 text-muted fw-bold">
            Showing <strong class="text-dark">{{ $purchaseOrders->firstItem() ?? 0 }} - {{ $purchaseOrders->lastItem() ?? 0 }}</strong> of <strong class="text-dark">{{ $purchaseOrders->total() }}</strong> Purchase Orders
        </div>
        <span class="badge bg-success bg-opacity-10 text-success px-3 py-1.5 rounded-pill fs-8 fw-bold">
            <i class="bi bi-file-earmark-text me-1"></i> Procurement Log
        </span>
    </div>

    <div class="table-responsive">
        <table class="table table-directory align-middle mb-0 fs-7">
            <thead>
                <tr>
                    <th>PO NUMBER</th>
                    <th>SUPPLIER VENDOR</th>
                    <th>TARGET WAREHOUSE DEPOT</th>
                    <th>TOTAL AMOUNT</th>
                    <th>ORDER DATE</th>
                    <th>RECEIVING STATUS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($purchaseOrders as $po)
                    <tr>
                        <td>
                            <div class="fw-bold text-dark fs-7"><code class="text-indigo bg-light px-2 py-1 rounded" style="color: #4F46E5;">PO-{{ str_pad($po->id, 5, '0', STR_PAD_LEFT) }}</code></div>
                        </td>
                        <td>
                            <div class="fw-bold text-dark fs-8">{{ $po->supplier?->name }}</div>
                            <div class="fs-8 text-muted">{{ $po->supplier?->contact_person ?? 'Main Office' }}</div>
                        </td>
                        <td>
                            <div class="fs-8 fw-bold text-dark"><i class="bi bi-building me-1 text-muted"></i> {{ $po->warehouse?->name }}</div>
                        </td>
                        <td class="fw-extrabold text-success fs-7 font-monospace" style="color: #059669;">
                            ${{ number_format($po->total_amount, 2) }}
                        </td>
                        <td class="fw-bold text-dark fs-8 font-monospace">
                            {{ $po->created_at->format('M d, Y') }}
                        </td>
                        <td>
                            <form action="{{ route('inventory.purchase-orders.status', $po->id) }}" method="POST" class="d-inline">
                                @csrf
                                <select name="status" class="form-select form-select-sm rounded-pill fs-8 d-inline-block w-auto" onchange="this.form.submit()">
                                    <option value="draft" {{ $po->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="ordered" {{ $po->status == 'ordered' ? 'selected' : '' }}>Ordered (In Transit)</option>
                                    <option value="received" {{ $po->status == 'received' ? 'selected' : '' }}>Received & Restocked</option>
                                    <option value="cancelled" {{ $po->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted fs-7">
                            <i class="bi bi-file-earmark-text fs-2 d-block mb-2 text-slate-300"></i>
                            <div class="fw-bold text-dark">No purchase orders generated</div>
                            <p class="fs-8 text-muted mb-3">Click "Issue Purchase Order" to create vendor procurement contracts.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($purchaseOrders->hasPages())
        <div class="p-3 border-top bg-light d-flex justify-content-between align-items-center">
            <div class="fs-8 text-muted">Showing {{ $purchaseOrders->firstItem() }} to {{ $purchaseOrders->lastItem() }} of {{ $purchaseOrders->total() }} entries</div>
            <div>{{ $purchaseOrders->links() }}</div>
        </div>
    @endif
</div>

<!-- Create PO Modal -->
<div class="modal fade" id="createPOModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom px-4 py-3">
                <h5 class="modal-title fw-bold fs-6 text-dark">Issue Purchase Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('inventory.purchase-orders.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Supplier Vendor <span class="text-danger">*</span></label>
                        <select name="supplier_id" class="form-select rounded-3 fs-8" required>
                            @foreach($suppliers as $sup)
                                <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Destination Warehouse Depot <span class="text-danger">*</span></label>
                        <select name="warehouse_id" class="form-select rounded-3 fs-8" required>
                            @foreach($warehouses as $wh)
                                <option value="{{ $wh->id }}">{{ $wh->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Total Order Amount ($) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="total_amount" class="form-control rounded-3 fs-8" placeholder="15000.00" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Initial Status</label>
                            <select name="status" class="form-select rounded-3 fs-8">
                                <option value="draft">Draft</option>
                                <option value="ordered">Ordered (In Transit)</option>
                                <option value="received">Received & Restocked</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4 fs-8 fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-emerald rounded-pill px-4 fs-8 fw-bold text-white" style="background: #059669; border: none;">Save Purchase Order</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
