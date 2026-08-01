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

    .assets-hero {
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
<div class="assets-hero">
    <div class="row align-items-center g-3">
        <div class="col-12 col-md-8">
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge rounded-pill bg-white bg-opacity-20 text-white fs-8 px-2.5 py-1">
                    <i class="bi bi-laptop-fill me-1"></i> Asset Management
                </span>
                <span class="fs-8 text-white-50">• {{ $stats['total_assets'] }} Hardware Assets</span>
            </div>
            <h3 class="mb-1 fw-extrabold text-white" style="letter-spacing: -0.02em;">
                Company Hardware & Asset Inventory
            </h3>
            <p class="mb-0 text-white-50 fs-7">
                Track company laptops, monitors, mobile devices, furniture, and equipment lifecycle.
            </p>
        </div>
        <div class="col-12 col-md-4 text-md-end">
            <button class="btn btn-light rounded-pill px-4 py-2.5 fw-bold text-indigo shadow-sm" data-bs-toggle="modal" data-bs-target="#createAssetModal" style="color: #4F46E5;">
                <i class="bi bi-plus-circle-fill me-1.5 fs-6"></i> Add Asset
            </button>
        </div>
    </div>
</div>

<!-- Image-Style Soft Pastel KPI Cards (4 Cards in 1 Row) -->
<div class="row g-3 mb-4">
    <!-- Card 1: Total Assets (Soft Sky Blue) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-indigo">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-box-seam me-1"></i> Asset Count
                    </span>
                    <span class="ui8-pill-val" style="color: #0284C7;">
                        {{ $stats['total_assets'] }} Items
                    </span>
                </div>
                <h4 class="ui8-card-title">Total Company Assets</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Registered Hardware
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-info shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-laptop"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Inventory</span>
                    <span class="ui8-tag-chip">#Hardware</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Assigned Equipment (Soft Emerald) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-emerald">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-person-check me-1"></i> In Use
                    </span>
                    <span class="ui8-pill-val" style="color: #059669;">
                        {{ $stats['assigned_count'] }} Assigned
                    </span>
                </div>
                <h4 class="ui8-card-title">Assigned Equipment</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Deployed to Staff
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-success shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-check-circle-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Assigned</span>
                    <span class="ui8-tag-chip">#InUse</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Available Inventory (Soft Purple) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-purple">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-house-check me-1"></i> In Stock
                    </span>
                    <span class="ui8-pill-val" style="color: #7C3AED;">
                        {{ $stats['available_count'] }} Available
                    </span>
                </div>
                <h4 class="ui8-card-title">Available Inventory</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Ready for Assignment
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-purple shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800; color: #7C3AED;">
                        <i class="bi bi-box2-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Available</span>
                    <span class="ui8-tag-chip">#InStock</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Under Maintenance (Soft Amber) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-amber">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-tools me-1"></i> In Repair
                    </span>
                    <span class="ui8-pill-val" style="color: #D97706;">
                        {{ $stats['maintenance_count'] }} Repairing
                    </span>
                </div>
                <h4 class="ui8-card-title">Under Maintenance</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Vendor Repair Status
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-warning shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-wrench"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Repair</span>
                    <span class="ui8-tag-chip">#Maintenance</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Assets Inventory Table -->
<div class="directory-card">
    <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light bg-opacity-50">
        <div class="fs-8 text-muted fw-bold">
            Showing <strong class="text-dark">{{ $assets->firstItem() ?? 0 }} - {{ $assets->lastItem() ?? 0 }}</strong> of <strong class="text-dark">{{ $assets->total() }}</strong> Registered Hardware Assets
        </div>
        <form method="GET" action="{{ route('assets.index') }}" class="d-flex gap-2">
            <input type="text" name="search" class="form-control rounded-pill fs-8 ps-3" value="{{ request('search') }}" placeholder="Search asset tag, brand, model...">
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-directory align-middle mb-0 fs-7">
            <thead>
                <tr>
                    <th>ASSET TAG & ITEM</th>
                    <th>CATEGORY</th>
                    <th>SERIAL NUMBER</th>
                    <th>PURCHASE COST</th>
                    <th>ASSIGNED EMPLOYEE</th>
                    <th>STATUS</th>
                    <th class="text-end pe-3">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($assets as $a)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2.5">
                                <div class="p-2 bg-indigo bg-opacity-10 text-indigo rounded-3 fs-5" style="background: #EEF2FF; color: #4F46E5;">
                                    @if($a->category === 'laptop') <i class="bi bi-laptop"></i>
                                    @elseif($a->category === 'phone') <i class="bi bi-phone"></i>
                                    @elseif($a->category === 'monitor') <i class="bi bi-display"></i>
                                    @else <i class="bi bi-box-seam"></i>
                                    @endif
                                </div>
                                <div>
                                    <div class="fw-bold text-dark fs-7">{{ $a->brand }} {{ $a->model }}</div>
                                    <div class="fs-8 text-muted"><code class="text-indigo bg-light px-1.5 py-0.5 rounded">{{ $a->asset_tag }}</code></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border px-2.5 py-1 fs-8 fw-bold text-uppercase">
                                {{ $a->category }}
                            </span>
                        </td>
                        <td class="fw-bold text-dark fs-8 font-monospace">
                            {{ $a->serial_number ?? 'N/A' }}
                        </td>
                        <td class="fw-bold text-dark fs-8 font-monospace">
                            ${{ number_format($a->purchase_cost, 2) }}
                        </td>
                        <td>
                            @if($a->currentAssignment)
                                <div class="fw-bold text-dark fs-8">{{ $a->currentAssignment->employee?->full_name }}</div>
                                <div class="fs-8 text-muted">{{ $a->currentAssignment->employee?->department?->name }}</div>
                            @else
                                <span class="text-muted fs-8">Unassigned</span>
                            @endif
                        </td>
                        <td>
                            @if($a->status === 'available')
                                <span class="badge bg-purple-subtle text-purple border px-2.5 py-1 rounded-pill fs-8" style="background: #F3E8FF; color: #7C3AED;">Available</span>
                            @elseif($a->status === 'assigned')
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1 rounded-pill fs-8">Assigned</span>
                            @elseif($a->status === 'maintenance')
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2.5 py-1 rounded-pill fs-8">Maintenance</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary px-2.5 py-1 rounded-pill fs-8">Retired</span>
                            @endif
                        </td>
                        <td class="text-end pe-3">
                            <div class="d-flex justify-content-end align-items-center gap-1.5">
                                <button class="btn btn-sm btn-light rounded-circle text-primary" 
                                        onclick="editAssetModal('{{ $a->id }}', '{{ $a->company_id }}', '{{ addslashes($a->asset_tag) }}', '{{ $a->category }}', '{{ addslashes($a->brand) }}', '{{ addslashes($a->model) }}', '{{ addslashes($a->serial_number) }}', '{{ $a->purchase_date?->format('Y-m-d') }}', '{{ $a->purchase_cost }}', '{{ $a->status }}')"
                                        title="Edit Asset">
                                    <i class="bi bi-pencil-fill fs-8"></i>
                                </button>
                                <form action="{{ route('assets.destroy', $a->id) }}" method="POST" onsubmit="event.preventDefault(); confirmDeleteAsset('{{ $a->id }}', '{{ addslashes($a->asset_tag) }}', this);">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light rounded-circle text-danger" title="Delete Asset">
                                        <i class="bi bi-trash-fill fs-8"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted fs-7">
                            <i class="bi bi-laptop fs-2 d-block mb-2 text-slate-300"></i>
                            <div class="fw-bold text-dark">No hardware assets registered</div>
                            <p class="fs-8 text-muted mb-3">Click "Add Asset" to register company equipment.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($assets->hasPages())
        <div class="p-3 border-top bg-light d-flex justify-content-between align-items-center">
            <div class="fs-8 text-muted">Showing {{ $assets->firstItem() }} to {{ $assets->lastItem() }} of {{ $assets->total() }} entries</div>
            <div>{{ $assets->links() }}</div>
        </div>
    @endif
</div>

<!-- Create / Edit Asset Modal -->
<div class="modal fade" id="createAssetModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom px-4 py-3">
                <h5 class="modal-title fw-bold fs-6 text-dark" id="assetModalTitle">Register Hardware Asset</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('assets.store') }}" method="POST" id="assetForm">
                @csrf
                <input type="hidden" name="_method" id="assetMethod" value="POST">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Company <span class="text-danger">*</span></label>
                        <select name="company_id" id="ast_company_id" class="form-select rounded-3 fs-8" required>
                            @foreach($companies as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Asset Tag Code <span class="text-danger">*</span></label>
                            <input type="text" name="asset_tag" id="ast_tag" class="form-control rounded-3 fs-8" placeholder="e.g. AST-MBP-005" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Category <span class="text-danger">*</span></label>
                            <select name="category" id="ast_category" class="form-select rounded-3 fs-8" required>
                                <option value="laptop">Laptop / PC</option>
                                <option value="desktop">Desktop Workstation</option>
                                <option value="monitor">Monitor Display</option>
                                <option value="phone">Mobile Phone</option>
                                <option value="vehicle">Vehicle</option>
                                <option value="accessory">Accessory / Furniture</option>
                                <option value="other">Other Equipment</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Brand</label>
                            <input type="text" name="brand" id="ast_brand" class="form-control rounded-3 fs-8" placeholder="e.g. Apple / Dell">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Model</label>
                            <input type="text" name="model" id="ast_model" class="form-control rounded-3 fs-8" placeholder="e.g. MacBook Pro M3">
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Serial Number</label>
                            <input type="text" name="serial_number" id="ast_serial" class="form-control rounded-3 fs-8" placeholder="e.g. C02GX001MD6R">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Purchase Cost ($)</label>
                            <input type="number" step="0.01" name="purchase_cost" id="ast_cost" class="form-control rounded-3 fs-8" placeholder="2500.00">
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Purchase Date</label>
                            <input type="date" name="purchase_date" id="ast_date" class="form-control rounded-3 fs-8">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Status</label>
                            <select name="status" id="ast_status" class="form-select rounded-3 fs-8">
                                <option value="available">Available</option>
                                <option value="assigned">Assigned</option>
                                <option value="maintenance">Maintenance</option>
                                <option value="retired">Retired</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4 fs-8 fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fs-8 fw-bold" style="background: #4F46E5; border: none;">Save Asset</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function editAssetModal(id, companyId, tag, category, brand, model, serial, pDate, cost, status) {
        document.getElementById('assetModalTitle').textContent = 'Edit Hardware Asset';
        document.getElementById('assetForm').action = "{{ url('assets') }}/" + id;
        document.getElementById('assetMethod').value = 'PUT';

        document.getElementById('ast_company_id').value = companyId;
        document.getElementById('ast_tag').value = tag;
        document.getElementById('ast_category').value = category;
        document.getElementById('ast_brand').value = brand;
        document.getElementById('ast_model').value = model;
        document.getElementById('ast_serial').value = serial;
        document.getElementById('ast_date').value = pDate;
        document.getElementById('ast_cost').value = cost;
        document.getElementById('ast_status').value = status;

        const modal = new bootstrap.Modal(document.getElementById('createAssetModal'));
        modal.show();
    }

    function confirmDeleteAsset(id, tag, formEl) {
        const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
        
        Swal.fire({
            title: `<div class="d-flex align-items-center justify-content-center gap-2 text-danger fw-bold fs-5 mb-1">
                        <i class="bi bi-exclamation-triangle-fill fs-4"></i> Delete Asset?
                    </div>`,
            html: `
                <div class="text-center py-2">
                    <p class="fs-7 text-secondary mb-3" style="line-height: 1.6;">
                        Are you sure you want to delete asset <strong class="text-dark">${tag}</strong>?
                    </p>
                    <div class="alert alert-danger border-0 fs-8 py-2.5 px-3 text-start mb-0 rounded-3" style="background: ${isDark ? '#374151' : '#FEF2F2'}; color: ${isDark ? '#F87171' : '#991B1B'};">
                        <i class="bi bi-trash me-1"></i>
                        Deleting this asset will remove its assignment history.
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: '<i class="bi bi-trash-fill me-1"></i> Yes, Delete Asset',
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
