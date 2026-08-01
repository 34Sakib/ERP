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

    .suppliers-hero {
        background: linear-gradient(-45deg, #7C3AED, #6366F1, #4F46E5, #4338CA);
        background-size: 300% 300%;
        animation: gradientMesh 12s ease infinite, fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        border-radius: 24px;
        padding: 2.25rem 2.5rem;
        color: #ffffff;
        margin-bottom: 1.75rem;
        box-shadow: 0 20px 45px rgba(124, 58, 237, 0.3);
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
        box-shadow: inset 3px 0 0 #7C3AED;
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
<div class="suppliers-hero">
    <div class="row align-items-center g-3">
        <div class="col-12 col-md-8">
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge rounded-pill bg-white bg-opacity-20 text-white fs-8 px-2.5 py-1">
                    <i class="bi bi-truck me-1"></i> Procurement Partners
                </span>
                <span class="fs-8 text-white-50">• {{ $stats['total_suppliers'] }} Registered Vendors</span>
            </div>
            <h3 class="mb-1 fw-extrabold text-white" style="letter-spacing: -0.02em;">
                Vendors & Merchandise Suppliers
            </h3>
            <p class="mb-0 text-white-50 fs-7">
                Manage vendor profiles, contact representatives, and track purchase order histories.
            </p>
        </div>
        <div class="col-12 col-md-4 text-md-end">
            <button class="btn btn-light rounded-pill px-4 py-2.5 fw-bold text-purple shadow-sm" data-bs-toggle="modal" data-bs-target="#createSupplierModal" style="color: #7C3AED;">
                <i class="bi bi-plus-circle-fill me-1.5 fs-6"></i> Add Supplier Vendor
            </button>
        </div>
    </div>
</div>

<!-- Image-Style Soft Pastel KPI Cards (4 Cards in 1 Row) -->
<div class="row g-3 mb-4">
    <!-- Card 1: Total Suppliers (Soft Purple) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-purple">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-truck-front-fill me-1"></i> Vendor Count
                    </span>
                    <span class="ui8-pill-val" style="color: #7C3AED;">
                        {{ $stats['total_suppliers'] }} Vendors
                    </span>
                </div>
                <h4 class="ui8-card-title">Total Suppliers</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Registered Partners
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-purple shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800; color: #7C3AED;">
                        <i class="bi bi-truck"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Vendors</span>
                    <span class="ui8-tag-chip">#Suppliers</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Total Spent (Soft Emerald) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-emerald">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-currency-dollar me-1"></i> Procurement
                    </span>
                    <span class="ui8-pill-val" style="color: #059669;">
                        ${{ number_format($stats['total_spent']) }}
                    </span>
                </div>
                <h4 class="ui8-card-title">Total Spent</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Received PO Value
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-success shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-cash-coin"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Procurement</span>
                    <span class="ui8-tag-chip">#Spent</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Total POs (Soft Sky Blue) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-indigo">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-file-earmark-text me-1"></i> Orders Placed
                    </span>
                    <span class="ui8-pill-val" style="color: #0284C7;">
                        {{ $stats['total_orders'] }} Orders
                    </span>
                </div>
                <h4 class="ui8-card-title">Total Purchase Orders</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Procurement Contracts
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-info shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-receipt"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Orders</span>
                    <span class="ui8-tag-chip">#Contracts</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Verified Status (Soft Amber) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-amber">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-shield-check me-1"></i> Verification
                    </span>
                    <span class="ui8-pill-val" style="color: #D97706;">
                        Certified
                    </span>
                </div>
                <h4 class="ui8-card-title">Vendor Compliance</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Approved Distributors
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-warning shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-patch-check-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Certified</span>
                    <span class="ui8-tag-chip">#Approved</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Suppliers Table -->
<div class="directory-card">
    <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light bg-opacity-50">
        <div class="fs-8 text-muted fw-bold">
            Showing <strong class="text-dark">{{ $suppliers->firstItem() ?? 0 }} - {{ $suppliers->lastItem() ?? 0 }}</strong> of <strong class="text-dark">{{ $suppliers->total() }}</strong> Merchandise Suppliers
        </div>
        <form method="GET" action="{{ route('inventory.suppliers.index') }}" class="d-flex gap-2">
            <input type="text" name="search" class="form-control rounded-pill fs-8 ps-3" value="{{ request('search') }}" placeholder="Search supplier name, contact...">
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-directory align-middle mb-0 fs-7">
            <thead>
                <tr>
                    <th>SUPPLIER VENDOR</th>
                    <th>CONTACT REPRESENTATIVE</th>
                    <th>EMAIL ADDRESS</th>
                    <th>PHONE NUMBER</th>
                    <th>PURCHASE ORDERS</th>
                    <th class="text-end pe-3">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suppliers as $s)
                    <tr>
                        <td>
                            <div class="fw-bold text-dark fs-7">{{ $s->name }}</div>
                            <div class="fs-8 text-muted">Registered {{ $s->created_at->format('M d, Y') }}</div>
                        </td>
                        <td class="fw-bold text-dark fs-8">
                            <i class="bi bi-person me-1 text-muted"></i> {{ $s->contact_person ?? 'Main Office' }}
                        </td>
                        <td>
                            <div class="fs-8 text-dark"><i class="bi bi-envelope me-1 text-muted"></i> {{ $s->email ?? 'N/A' }}</div>
                        </td>
                        <td class="fw-bold text-dark fs-8 font-monospace">
                            {{ $s->phone ?? 'N/A' }}
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border px-2.5 py-1 fs-8 fw-bold">
                                {{ $s->purchaseOrders->count() }} Purchase Orders
                            </span>
                        </td>
                        <td class="text-end pe-3">
                            <div class="d-flex justify-content-end align-items-center gap-1.5">
                                <button class="btn btn-sm btn-light rounded-circle text-primary" 
                                        onclick="editSupplierModal('{{ $s->id }}', '{{ addslashes($s->name) }}', '{{ addslashes($s->contact_person) }}', '{{ addslashes($s->email) }}', '{{ addslashes($s->phone) }}')"
                                        title="Edit Supplier">
                                    <i class="bi bi-pencil-fill fs-8"></i>
                                </button>
                                <form action="{{ route('inventory.suppliers.destroy', $s->id) }}" method="POST" onsubmit="event.preventDefault(); confirmDeleteSupplier('{{ $s->id }}', '{{ addslashes($s->name) }}', this);">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light rounded-circle text-danger" title="Delete Supplier">
                                        <i class="bi bi-trash-fill fs-8"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted fs-7">
                            <i class="bi bi-truck fs-2 d-block mb-2 text-slate-300"></i>
                            <div class="fw-bold text-dark">No merchandise suppliers registered</div>
                            <p class="fs-8 text-muted mb-3">Click "Add Supplier Vendor" to create supplier profiles.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($suppliers->hasPages())
        <div class="p-3 border-top bg-light d-flex justify-content-between align-items-center">
            <div class="fs-8 text-muted">Showing {{ $suppliers->firstItem() }} to {{ $suppliers->lastItem() }} of {{ $suppliers->total() }} entries</div>
            <div>{{ $suppliers->links() }}</div>
        </div>
    @endif
</div>

<!-- Create / Edit Supplier Modal -->
<div class="modal fade" id="createSupplierModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom px-4 py-3">
                <h5 class="modal-title fw-bold fs-6 text-dark" id="supplierModalTitle">Register Merchandise Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('inventory.suppliers.store') }}" method="POST" id="supplierForm">
                @csrf
                <input type="hidden" name="_method" id="supplierMethod" value="POST">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Supplier Company Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="sup_name" class="form-control rounded-3 fs-8" placeholder="e.g. Tech Data Global Distribution" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Contact Representative</label>
                        <input type="text" name="contact_person" id="sup_contact" class="form-control rounded-3 fs-8" placeholder="e.g. Robert Vance">
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Email Address</label>
                            <input type="email" name="email" id="sup_email" class="form-control rounded-3 fs-8" placeholder="orders@supplier.example.com">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Phone Number</label>
                            <input type="text" name="phone" id="sup_phone" class="form-control rounded-3 fs-8" placeholder="+1 (555) 000-0000">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4 fs-8 fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-purple rounded-pill px-4 fs-8 fw-bold text-white" style="background: #7C3AED; border: none;">Save Supplier</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function editSupplierModal(id, name, contact, email, phone) {
        document.getElementById('supplierModalTitle').textContent = 'Edit Merchandise Supplier';
        document.getElementById('supplierForm').action = "{{ url('inventory/suppliers') }}/" + id;
        document.getElementById('supplierMethod').value = 'PUT';

        document.getElementById('sup_name').value = name;
        document.getElementById('sup_contact').value = contact;
        document.getElementById('sup_email').value = email;
        document.getElementById('sup_phone').value = phone;

        const modal = new bootstrap.Modal(document.getElementById('createSupplierModal'));
        modal.show();
    }

    function confirmDeleteSupplier(id, name, formEl) {
        const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
        
        Swal.fire({
            title: `<div class="d-flex align-items-center justify-content-center gap-2 text-danger fw-bold fs-5 mb-1">
                        <i class="bi bi-exclamation-triangle-fill fs-4"></i> Delete Supplier Vendor?
                    </div>`,
            html: `
                <div class="text-center py-2">
                    <p class="fs-7 text-secondary mb-3" style="line-height: 1.6;">
                        Are you sure you want to delete <strong class="text-dark">${name}</strong>?
                    </p>
                    <div class="alert alert-danger border-0 fs-8 py-2.5 px-3 text-start mb-0 rounded-3" style="background: ${isDark ? '#374151' : '#FEF2F2'}; color: ${isDark ? '#F87171' : '#991B1B'};">
                        <i class="bi bi-trash me-1"></i>
                        Deleting this supplier will remove associated purchase order relations.
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: '<i class="bi bi-trash-fill me-1"></i> Yes, Delete Supplier',
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
