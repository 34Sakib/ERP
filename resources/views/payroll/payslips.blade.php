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

    .payslip-hero {
        background: linear-gradient(-45deg, #4338CA, #6366F1, #7C3AED, #4F46E5);
        background-size: 300% 300%;
        animation: gradientMesh 12s ease infinite, fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        border-radius: 24px;
        padding: 2.25rem 2.5rem;
        color: #ffffff;
        margin-bottom: 1.75rem;
        box-shadow: 0 20px 45px rgba(99, 102, 241, 0.3);
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
        box-shadow: inset 3px 0 0 #6366F1;
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
<div class="payslip-hero">
    <div class="row align-items-center g-3">
        <div class="col-12 col-md-8">
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge rounded-pill bg-white bg-opacity-20 text-white fs-8 px-2.5 py-1">
                    <i class="bi bi-file-earmark-text-fill me-1"></i> Generated Payslips Directory
                </span>
                <span class="fs-8 text-white-50">• {{ $stats['total_payslips'] }} Generated Slips</span>
            </div>
            <h3 class="mb-1 fw-extrabold text-white" style="letter-spacing: -0.02em;">
                Employee Salary Slips & Receipts
            </h3>
            <p class="mb-0 text-white-50 fs-7">
                View, download, and print official employee monthly payslips and breakdown receipts.
            </p>
        </div>
    </div>
</div>

<!-- Image-Style Soft Pastel KPI Cards (4 Cards in 1 Row) -->
<div class="row g-3 mb-4">
    <!-- Card 1: Total Disbursed Net (Soft Emerald) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-emerald">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-cash-stack me-1"></i> Total Net Salary
                    </span>
                    <span class="ui8-pill-val" style="color: #059669;">
                        ${{ number_format($stats['total_disbursed_net']) }}
                    </span>
                </div>
                <h4 class="ui8-card-title">Disbursed Net Pay</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Verified Disbursed Slips
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-success shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-check-circle-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#NetPay</span>
                    <span class="ui8-tag-chip">#Disbursed</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Average Net Salary (Soft Sky Blue) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-indigo">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-graph-up me-1"></i> Average Net
                    </span>
                    <span class="ui8-pill-val" style="color: #0284C7;">
                        ${{ number_format($stats['avg_net_salary']) }}
                    </span>
                </div>
                <h4 class="ui8-card-title">Average Net Salary</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Mean Employee Take-Home
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-info shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-calculator"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Average</span>
                    <span class="ui8-tag-chip">#TakeHome</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Generated Slips (Soft Purple) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-purple">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-file-earmark-text me-1"></i> Slip Count
                    </span>
                    <span class="ui8-pill-val" style="color: #7C3AED;">
                        {{ $stats['total_payslips'] }} Slips
                    </span>
                </div>
                <h4 class="ui8-card-title">Generated Payslips</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Total Generated Slips
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-purple shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800; color: #7C3AED;">
                        <i class="bi bi-journal-check"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Generated</span>
                    <span class="ui8-tag-chip">#Slips</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Paid Slips (Soft Amber) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-amber">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-shield-check me-1"></i> Disbursed Count
                    </span>
                    <span class="ui8-pill-val" style="color: #D97706;">
                        {{ $stats['paid_count'] }} Paid
                    </span>
                </div>
                <h4 class="ui8-card-title">Paid Payslips</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Completed Disbursed Slips
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-warning shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-check2-all"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Paid</span>
                    <span class="ui8-tag-chip">#Verified</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payslips Table -->
<div class="directory-card">
    <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light bg-opacity-50">
        <div class="fs-8 text-muted fw-bold">
            Showing <strong class="text-dark">{{ $payslips->firstItem() ?? 0 }} - {{ $payslips->lastItem() ?? 0 }}</strong> of <strong class="text-dark">{{ $payslips->total() }}</strong> Employee Payslips
        </div>
        <form method="GET" action="{{ route('payroll.payslips.index') }}" class="d-flex gap-2">
            <input type="text" name="search" class="form-control rounded-pill fs-8 ps-3" value="{{ request('search') }}" placeholder="Search employee name...">
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-directory align-middle mb-0 fs-7">
            <thead>
                <tr>
                    <th>EMPLOYEE PROFILE</th>
                    <th>PERIOD</th>
                    <th>BASIC SALARY</th>
                    <th>ALLOWANCES</th>
                    <th>DEDUCTIONS</th>
                    <th>NET TAKE-HOME</th>
                    <th>STATUS</th>
                    <th class="text-end pe-3">ACTION</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payslips as $p)
                    @if(!$p->employee)
                        @continue
                    @endif
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2.5">
                                <img src="{{ $p->employee->profile_photo ? asset($p->employee->profile_photo) : 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80' }}" 
                                     class="rounded-circle shadow-sm" style="width: 38px; height: 38px; object-fit: cover;">
                                <div>
                                    <div class="fw-bold text-dark">{{ $p->employee->full_name }}</div>
                                    <div class="fs-8 text-muted"><code class="text-primary">{{ $p->employee->employee_code }}</code></div>
                                </div>
                            </div>
                        </td>
                        <td class="fw-bold text-dark fs-8">
                            {{ DateTime::createFromFormat('!m', $p->payrollRun?->month ?? 7)->format('M') }} {{ $p->payrollRun?->year ?? 2026 }}
                        </td>
                        <td class="fw-bold text-dark fs-8 font-monospace">
                            ${{ number_format($p->basic_salary, 2) }}
                        </td>
                        <td class="text-success fw-bold fs-8 font-monospace">
                            +${{ number_format($p->total_allowances, 2) }}
                        </td>
                        <td class="text-danger fw-bold fs-8 font-monospace">
                            -${{ number_format($p->total_deductions, 2) }}
                        </td>
                        <td class="fw-extrabold text-indigo fs-7 font-monospace" style="color: #4F46E5;">
                            ${{ number_format($p->net_salary, 2) }}
                        </td>
                        <td>
                            @if($p->status === 'paid')
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1 rounded-pill fs-8">Paid & Disbursed</span>
                            @else
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2.5 py-1 rounded-pill fs-8">Pending</span>
                            @endif
                        </td>
                        <td class="text-end pe-3">
                            <button class="btn btn-sm btn-light rounded-pill px-3 fs-8 fw-bold text-indigo" 
                                    onclick="viewPayslipModal('{{ addslashes($p->employee->full_name) }}', '{{ $p->employee->employee_code }}', '{{ $p->employee->department?->name }}', '{{ number_format($p->basic_salary, 2) }}', '{{ number_format($p->total_allowances, 2) }}', '{{ number_format($p->total_deductions, 2) }}', '{{ number_format($p->net_salary, 2) }}')">
                                <i class="bi bi-printer me-1"></i> View Slip
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted fs-7">
                            <i class="bi bi-file-earmark-text fs-2 d-block mb-2 text-slate-300"></i>
                            <div class="fw-bold text-dark">No payslips generated yet</div>
                            <p class="fs-8 text-muted mb-3">Process a monthly payroll run to generate employee payslips.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($payslips->hasPages())
        <div class="p-3 border-top bg-light d-flex justify-content-between align-items-center">
            <div class="fs-8 text-muted">Showing {{ $payslips->firstItem() }} to {{ $payslips->lastItem() }} of {{ $payslips->total() }} entries</div>
            <div>{{ $payslips->links() }}</div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    function viewPayslipModal(name, code, dept, basic, allowances, deductions, net) {
        const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';

        Swal.fire({
            title: `<div class="fw-bold fs-6 text-dark text-start mb-0"><i class="bi bi-file-earmark-text text-primary me-2"></i> Official Salary Payslip Receipt</div>`,
            html: `
                <div class="text-start py-2">
                    <div class="bg-light p-3 rounded-3 mb-3 border">
                        <div class="fw-bold text-dark fs-6">${name}</div>
                        <div class="fs-8 text-muted">Code: <code class="text-primary">${code}</code> • Dept: ${dept ?? 'General'}</div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered fs-8 mb-3">
                            <tr class="table-light">
                                <th class="fw-bold">Description</th>
                                <th class="text-end fw-bold">Amount ($)</th>
                            </tr>
                            <tr>
                                <td>Basic Salary</td>
                                <td class="text-end font-monospace">$${basic}</td>
                            </tr>
                            <tr>
                                <td class="text-success">+ Total Allowances</td>
                                <td class="text-end font-monospace text-success">+$${allowances}</td>
                            </tr>
                            <tr>
                                <td class="text-danger">- Total Deductions & Taxes</td>
                                <td class="text-end font-monospace text-danger">-$${deductions}</td>
                            </tr>
                            <tr class="table-active">
                                <th class="fw-extrabold text-dark">NET TAKE-HOME SALARY</th>
                                <th class="text-end fw-extrabold text-indigo font-monospace" style="color: #4F46E5;">$${net}</th>
                            </tr>
                        </table>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: '<i class="bi bi-printer me-1"></i> Print Payslip',
            cancelButtonText: 'Close',
            confirmButtonColor: '#4F46E5',
            background: isDark ? '#1F2937' : '#ffffff',
            color: isDark ? '#F8FAFC' : '#1E1B4B',
            customClass: {
                popup: 'rounded-4 border-0 shadow-lg p-4',
                confirmButton: 'px-4 py-2 rounded-pill fw-bold fs-7'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.print();
            }
        });
    }
</script>
@endpush
