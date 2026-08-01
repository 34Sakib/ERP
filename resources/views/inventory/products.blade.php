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

    .products-hero {
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
<div class="products-hero">
    <div class="row align-items-center g-3">
        <div class="col-12 col-md-8">
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge rounded-pill bg-white bg-opacity-20 text-white fs-8 px-2.5 py-1">
                    <i class="bi bi-box-seam-fill me-1"></i> Product Master Catalog
                </span>
                <span class="fs-8 text-white-50">• {{ $stats['total_products'] }} Active Product SKUs</span>
            </div>
            <h3 class="mb-1 fw-extrabold text-white" style="letter-spacing: -0.02em;">
                Inventory Product Catalog & Pricing
            </h3>
            <p class="mb-0 text-white-50 fs-7">
                Manage merchandise SKUs, cost & selling prices, barcodes, and minimum reorder thresholds.
            </p>
        </div>
        <div class="col-12 col-md-4 text-md-end">
            <button class="btn btn-light rounded-pill px-4 py-2.5 fw-bold text-emerald shadow-sm" data-bs-toggle="modal" data-bs-target="#createProductModal" style="color: #059669;">
                <i class="bi bi-plus-circle-fill me-1.5 fs-6"></i> Add Product SKU
            </button>
        </div>
    </div>
</div>

<!-- Image-Style Soft Pastel KPI Cards (4 Cards in 1 Row) -->
<div class="row g-3 mb-4">
    <!-- Card 1: Total SKUs (Soft Emerald) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-emerald">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-box-seam me-1"></i> SKU Count
                    </span>
                    <span class="ui8-pill-val" style="color: #059669;">
                        {{ $stats['total_products'] }} SKUs
                    </span>
                </div>
                <h4 class="ui8-card-title">Total SKU Items</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Registered Catalog Items
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-success shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-box-seam"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#SKUs</span>
                    <span class="ui8-tag-chip">#Catalog</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Valuation (Soft Sky Blue) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-indigo">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-currency-dollar me-1"></i> Catalog Value
                    </span>
                    <span class="ui8-pill-val" style="color: #0284C7;">
                        ${{ number_format($stats['total_valuation']) }}
                    </span>
                </div>
                <h4 class="ui8-card-title">Retail Valuation</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Total List Value
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-info shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-cash-stack"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Valuation</span>
                    <span class="ui8-tag-chip">#Pricing</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Reorder Alerts (Soft Amber) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-amber">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-exclamation-triangle me-1"></i> Low Stock
                    </span>
                    <span class="ui8-pill-val" style="color: #D97706;">
                        {{ $stats['reorder_alert'] }} Alerts
                    </span>
                </div>
                <h4 class="ui8-card-title">Reorder Alerts</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Threshold Alerts
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-warning shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-bell-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Reorder</span>
                    <span class="ui8-tag-chip">#Alerts</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Product Units (Soft Purple) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-purple">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-tag-fill me-1"></i> Unit Types
                    </span>
                    <span class="ui8-pill-val" style="color: #7C3AED;">
                        PCS / Units
                    </span>
                </div>
                <h4 class="ui8-card-title">Standard Measurement</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Unit Cataloging
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-purple shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800; color: #7C3AED;">
                        <i class="bi bi-rulers"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Units</span>
                    <span class="ui8-tag-chip">#Standard</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Products Table -->
<div class="directory-card">
    <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light bg-opacity-50">
        <div class="fs-8 text-muted fw-bold">
            Showing <strong class="text-dark">{{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }}</strong> of <strong class="text-dark">{{ $products->total() }}</strong> Catalog Products
        </div>
        <form method="GET" action="{{ route('inventory.products.index') }}" class="d-flex gap-2">
            <input type="text" name="search" class="form-control rounded-pill fs-8 ps-3" value="{{ request('search') }}" placeholder="Search SKU, product name...">
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-directory align-middle mb-0 fs-7">
            <thead>
                <tr>
                    <th>PRODUCT NAME & SKU</th>
                    <th>BARCODE</th>
                    <th>UNIT COST ($)</th>
                    <th>RETAIL PRICE ($)</th>
                    <th>REORDER THRESHOLD</th>
                    <th class="text-end pe-3">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $p)
                    <tr>
                        <td>
                            <div class="fw-bold text-dark fs-7">{{ $p->name }}</div>
                            <div class="fs-8 text-muted"><code class="text-emerald bg-light px-1.5 py-0.5 rounded" style="color: #059669;">{{ $p->sku }}</code> • {{ strtoupper($p->unit) }}</div>
                        </td>
                        <td class="fw-bold text-dark fs-8 font-monospace">
                            <i class="bi bi-upc-scan me-1 text-muted"></i> {{ $p->barcode ?? 'N/A' }}
                        </td>
                        <td class="fw-bold text-dark fs-8 font-monospace">
                            ${{ number_format($p->cost_price, 2) }}
                        </td>
                        <td class="fw-extrabold text-success fs-7 font-monospace" style="color: #059669;">
                            ${{ number_format($p->sale_price, 2) }}
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border px-2.5 py-1 fs-8 fw-bold">
                                {{ $p->reorder_level }} {{ strtoupper($p->unit) }}
                            </span>
                        </td>
                        <td class="text-end pe-3">
                            <div class="d-flex justify-content-end align-items-center gap-1.5">
                                <button class="btn btn-sm btn-light rounded-circle text-primary" 
                                        onclick="editProductModal('{{ $p->id }}', '{{ addslashes($p->sku) }}', '{{ addslashes($p->name) }}', '{{ addslashes($p->barcode) }}', '{{ $p->unit }}', '{{ $p->cost_price }}', '{{ $p->sale_price }}', '{{ $p->reorder_level }}')"
                                        title="Edit Product">
                                    <i class="bi bi-pencil-fill fs-8"></i>
                                </button>
                                <form action="{{ route('inventory.products.destroy', $p->id) }}" method="POST" onsubmit="event.preventDefault(); confirmDeleteProduct('{{ $p->id }}', '{{ addslashes($p->name) }}', this);">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light rounded-circle text-danger" title="Delete Product">
                                        <i class="bi bi-trash-fill fs-8"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted fs-7">
                            <i class="bi bi-box-seam fs-2 d-block mb-2 text-slate-300"></i>
                            <div class="fw-bold text-dark">No products registered in catalog</div>
                            <p class="fs-8 text-muted mb-3">Click "Add Product SKU" to create catalog items.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
        <div class="p-3 border-top bg-light d-flex justify-content-between align-items-center">
            <div class="fs-8 text-muted">Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} entries</div>
            <div>{{ $products->links() }}</div>
        </div>
    @endif
</div>

<!-- Create / Edit Product Modal -->
<div class="modal fade" id="createProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom px-4 py-3">
                <h5 class="modal-title fw-bold fs-6 text-dark" id="productModalTitle">Add Product SKU</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('inventory.products.store') }}" method="POST" id="productForm">
                @csrf
                <input type="hidden" name="_method" id="productMethod" value="POST">
                <div class="modal-body p-4">
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">SKU Code <span class="text-danger">*</span></label>
                            <input type="text" name="sku" id="prd_sku" class="form-control rounded-3 fs-8" placeholder="e.g. SKU-MBP-16" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Barcode</label>
                            <input type="text" name="barcode" id="prd_barcode" class="form-control rounded-3 fs-8" placeholder="e.g. 885909456782">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Product Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="prd_name" class="form-control rounded-3 fs-8" placeholder="e.g. MacBook Pro 16 M3 Max" required>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-4">
                            <label class="form-label fw-bold fs-7 text-dark">Unit</label>
                            <input type="text" name="unit" id="prd_unit" class="form-control rounded-3 fs-8" value="pcs" required>
                        </div>
                        <div class="col-4">
                            <label class="form-label fw-bold fs-7 text-dark">Cost Price ($) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="cost_price" id="prd_cost" class="form-control rounded-3 fs-8" placeholder="2800.00" required>
                        </div>
                        <div class="col-4">
                            <label class="form-label fw-bold fs-7 text-dark">Sale Price ($) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="sale_price" id="prd_sale" class="form-control rounded-3 fs-8" placeholder="3499.00" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Minimum Reorder Level <span class="text-danger">*</span></label>
                        <input type="number" name="reorder_level" id="prd_reorder" class="form-control rounded-3 fs-8" value="10" required>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4 fs-8 fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-emerald rounded-pill px-4 fs-8 fw-bold text-white" style="background: #059669; border: none;">Save Product SKU</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function editProductModal(id, sku, name, barcode, unit, cost, sale, reorder) {
        document.getElementById('productModalTitle').textContent = 'Edit Catalog Product';
        document.getElementById('productForm').action = "{{ url('inventory/products') }}/" + id;
        document.getElementById('productMethod').value = 'PUT';

        document.getElementById('prd_sku').value = sku;
        document.getElementById('prd_name').value = name;
        document.getElementById('prd_barcode').value = barcode;
        document.getElementById('prd_unit').value = unit;
        document.getElementById('prd_cost').value = cost;
        document.getElementById('prd_sale').value = sale;
        document.getElementById('prd_reorder').value = reorder;

        const modal = new bootstrap.Modal(document.getElementById('createProductModal'));
        modal.show();
    }

    function confirmDeleteProduct(id, name, formEl) {
        const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
        
        Swal.fire({
            title: `<div class="d-flex align-items-center justify-content-center gap-2 text-danger fw-bold fs-5 mb-1">
                        <i class="bi bi-exclamation-triangle-fill fs-4"></i> Delete Product SKU?
                    </div>`,
            html: `
                <div class="text-center py-2">
                    <p class="fs-7 text-secondary mb-3" style="line-height: 1.6;">
                        Are you sure you want to delete <strong class="text-dark">${name}</strong>?
                    </p>
                    <div class="alert alert-danger border-0 fs-8 py-2.5 px-3 text-start mb-0 rounded-3" style="background: ${isDark ? '#374151' : '#FEF2F2'}; color: ${isDark ? '#F87171' : '#991B1B'};">
                        <i class="bi bi-trash me-1"></i>
                        Deleting this SKU will remove its stock audit trail.
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: '<i class="bi bi-trash-fill me-1"></i> Yes, Delete SKU',
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
