@extends('layouts.app')

@push('styles')
<style>
    /* Premium Warm Beige + Deep Teal Dashboard Styles */
    :root {
        --dash-card-shadow: 0 10px 30px -5px rgba(34, 51, 59, 0.05), 0 4px 12px -2px rgba(34, 51, 59, 0.02);
        --dash-card-hover: 0 20px 40px -10px rgba(11, 79, 74, 0.18), 0 8px 16px -4px rgba(34, 51, 59, 0.04);
    }

    /* Animation Keyframes */
    @keyframes gradientMesh {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(22px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes pulsePing {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(11, 79, 74, 0.7); }
        70% { transform: scale(1.08); box-shadow: 0 0 0 12px rgba(11, 79, 74, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(11, 79, 74, 0); }
    }

    @keyframes floatOrb {
        0% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-10px) rotate(5deg); }
        100% { transform: translateY(0px) rotate(0deg); }
    }

    /* Hero Banner with Animated Fluid Mesh */
    .hero-welcome-banner {
        background: linear-gradient(-45deg, #0B4F4A, #166560, #0B4F4A, #B5A47F, #22333B);
        background-size: 300% 300%;
        animation: gradientMesh 12s ease infinite, fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        border-radius: 24px;
        padding: 2.25rem 2.5rem;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 45px rgba(11, 79, 74, 0.25);
        margin-bottom: 2rem;
        border: 1px solid rgba(181, 164, 127, 0.3);
    }

    .hero-welcome-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 380px;
        height: 380px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.22) 0%, rgba(255, 255, 255, 0) 70%);
        border-radius: 50%;
        pointer-events: none;
        animation: floatOrb 8s ease-in-out infinite;
    }

    .hero-welcome-banner::after {
        content: '';
        position: absolute;
        bottom: -40%;
        right: 15%;
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(181, 164, 127, 0.25) 0%, rgba(181, 164, 127, 0) 70%);
        border-radius: 50%;
        pointer-events: none;
        animation: floatOrb 6s ease-in-out infinite reverse;
    }

    .hero-avatar {
        width: 64px;
        height: 64px;
        border-radius: 18px;
        object-fit: cover;
        border: 3px solid rgba(255, 255, 255, 0.35);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease;
    }

    .hero-avatar:hover {
        transform: scale(1.08) rotate(-3deg);
    }

    .hero-quick-btn {
        background: rgba(255, 255, 255, 0.18);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.3);
        padding: 0.65rem 1.2rem;
        border-radius: 14px;
        font-weight: 700;
        font-size: 0.85rem;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .hero-quick-btn:hover {
        background: #ffffff;
        color: #0B4F4A;
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.18);
    }

    /* Staggered KPI Cards - Gradient Example Design */
    .stat-card-gradient {
        border-radius: 20px;
        padding: 1.2rem 1.35rem;
        position: relative;
        overflow: hidden;
        color: #ffffff;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 125px;
    }

    /* Fine wave line texture overlay */
    .stat-card-gradient::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: repeating-linear-gradient(
            45deg,
            rgba(255, 255, 255, 0.07) 0,
            rgba(255, 255, 255, 0.07) 1px,
            transparent 1px,
            transparent 9px
        );
        pointer-events: none;
        opacity: 0.8;
    }

    .stat-card-gradient:hover {
        transform: translateY(-6px) scale(1.02);
    }

    /* Card 1: Vibrant Magenta Pink to Purple */
    .stat-card-pink {
        background: linear-gradient(135deg, #EC4899 0%, #D946EF 50%, #A855F7 100%);
        box-shadow: 0 12px 28px -4px rgba(236, 72, 153, 0.38);
    }
    .stat-card-pink:hover {
        box-shadow: 0 18px 36px -4px rgba(236, 72, 153, 0.48);
    }

    /* Card 2: Violet Indigo */
    .stat-card-purple {
        background: linear-gradient(135deg, #8B5CF6 0%, #6366F1 100%);
        box-shadow: 0 12px 28px -4px rgba(139, 92, 246, 0.38);
    }
    .stat-card-purple:hover {
        box-shadow: 0 18px 36px -4px rgba(139, 92, 246, 0.48);
    }

    /* Card 3: Sky Blue / Cyan */
    .stat-card-cyan {
        background: linear-gradient(135deg, #38BDF8 0%, #3B82F6 100%);
        box-shadow: 0 12px 28px -4px rgba(56, 189, 248, 0.38);
    }
    .stat-card-cyan:hover {
        box-shadow: 0 18px 36px -4px rgba(56, 189, 248, 0.48);
    }

    /* Card 4: Emerald / Mint Green */
    .stat-card-emerald {
        background: linear-gradient(135deg, #10B981 0%, #059669 100%);
        box-shadow: 0 12px 28px -4px rgba(16, 185, 129, 0.38);
    }
    .stat-card-emerald:hover {
        box-shadow: 0 18px 36px -4px rgba(16, 185, 129, 0.48);
    }

    .stat-card-title {
        font-size: 0.88rem;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.92);
        letter-spacing: 0.01em;
        position: relative;
        z-index: 1;
    }

    .stat-card-value {
        font-size: 2.1rem;
        font-weight: 800;
        color: #ffffff;
        line-height: 1;
        letter-spacing: -0.02em;
        position: relative;
        z-index: 1;
    }

    .stat-card-icon {
        font-size: 2.2rem;
        color: rgba(255, 255, 255, 0.92);
        line-height: 1;
        position: relative;
        z-index: 1;
        transition: transform 0.3s ease;
    }

    .stat-card-gradient:hover .stat-card-icon {
        transform: scale(1.15) rotate(6deg);
    }

    .stat-card-subtext {
        font-size: 0.78rem;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.85);
        margin-top: 0.45rem;
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }
        letter-spacing: -0.03em;
        color: #22333B;
        line-height: 1;
        margin-top: 0.75rem;
        margin-bottom: 0.35rem;
    }

    .kpi-trend-pill {
        font-size: 0.72rem;
        font-weight: 700;
        padding: 0.25rem 0.65rem;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .trend-up {
        background: #E6F2F1;
        color: #0B4F4A;
    }

    .trend-alert {
        background: #FCE8E2;
        color: #E07A5F;
    }

    .trend-neutral {
        background: #F5F1E8;
        color: #6B7B83;
    }

    .kpi-progress-bar {
        height: 6px;
        border-radius: 999px;
        background: #F5F1E8;
        overflow: hidden;
        margin-top: 0.85rem;
    }

    .kpi-progress-fill {
        height: 100%;
        border-radius: 999px;
        transition: width 1.2s cubic-bezier(0.16, 1, 0.3, 1);
    }

    /* Main Section Dashboard Cards */
    .dash-card {
        background: #ffffff;
        border-radius: 22px;
        border: 1px solid #E6E0D4;
        box-shadow: var(--dash-card-shadow);
        padding: 1.65rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        animation: fadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) both;
    }

    .dash-card:hover {
        box-shadow: 0 18px 40px rgba(11, 79, 74, 0.08);
    }

    .dash-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.25rem;
    }

    .dash-card-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: #22333B;
        margin: 0;
        letter-spacing: -0.01em;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .dash-card-subtitle {
        font-size: 0.82rem;
        color: #6B7B83;
        margin-top: 0.15rem;
    }

    /* Donut chart center container */
    .donut-wrapper {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 220px;
        width: 100%;
        overflow: visible;
    }

    #departmentDonutChart {
        width: 220px;
        height: 220px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .donut-center-badge {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        pointer-events: none;
        z-index: 2;
    }

    .donut-center-badge .total-num {
        font-size: 2.1rem;
        font-weight: 800;
        color: #22333B;
        line-height: 1;
    }

    .donut-center-badge .total-label {
        font-size: 0.68rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #6B7B83;
        font-weight: 700;
        margin-top: 0.25rem;
    }

    /* Department Custom Table Items */
    .dept-progress-item {
        padding: 0.65rem 0.5rem;
        border-bottom: 1px solid #F5F1E8;
        transition: all 0.25s ease;
    }

    .dept-progress-item:last-child {
        border-bottom: none;
    }

    .dept-progress-item:hover {
        background: #F9F7F2;
        border-radius: 12px;
        transform: translateX(4px);
    }

    /* Today's Presence Compact Card */
    .presence-compact-card {
        background: #ffffff;
        border: 1px solid #E6E0D4;
        border-radius: 18px;
        padding: 0.95rem 1.25rem;
        box-shadow: var(--dash-card-shadow);
        transition: all 0.3s ease;
    }

    .presence-compact-card:hover {
        box-shadow: 0 12px 28px rgba(11, 79, 74, 0.08);
        border-color: rgba(11, 79, 74, 0.3);
    }

    .presence-icon-box {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: #E6F2F1;
        color: #0B4F4A;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    /* Shift Terminal Widget - Compact & Refined */
    .terminal-card {
        background: linear-gradient(145deg, #0B4F4A 0%, #063431 100%);
        border-radius: 18px;
        padding: 1.2rem 1.35rem;
        color: #ffffff;
        box-shadow: 0 12px 28px rgba(11, 79, 74, 0.25);
        margin-bottom: 1.25rem;
        position: relative;
        overflow: hidden;
        animation: fadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) both;
        border: 1px solid rgba(181, 164, 127, 0.3);
    }

    .terminal-clock-display {
        font-size: 1.45rem;
        font-weight: 800;
        font-family: monospace, monospace;
        letter-spacing: 0.05em;
        color: #C9A227;
        text-shadow: 0 0 14px rgba(201, 162, 39, 0.4);
    }

    .terminal-btn-punch {
        background: linear-gradient(135deg, #C9A227 0%, #B5A47F 100%);
        color: #0B4F4A;
        border: none;
        border-radius: 12px;
        padding: 0.65rem 1.25rem;
        font-weight: 800;
        font-size: 0.88rem;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        box-shadow: 0 6px 20px rgba(201, 162, 39, 0.3);
        transition: all 0.25s ease;
    }

    .terminal-btn-punch:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(201, 162, 39, 0.45);
        color: #063431;
    }

    .terminal-btn-punch.checked-in {
        background: linear-gradient(135deg, #E07A5F 0%, #C04E36 100%);
        color: #ffffff;
        box-shadow: 0 6px 20px rgba(224, 122, 95, 0.35);
    }

    /* Module Shortcut Grid - Micro Modern Cards */
    .shortcut-card {
        background: #F9F7F2;
        border: 1px solid #E6E0D4;
        border-radius: 14px;
        padding: 0.85rem 0.5rem;
        text-align: center;
        text-decoration: none;
        color: #22333B;
        transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.35rem;
    }

    .shortcut-card:hover {
        background: #ffffff;
        border-color: #0B4F4A;
        transform: translateY(-3px);
        box-shadow: 0 10px 22px rgba(11, 79, 74, 0.12);
        color: #0B4F4A;
    }

    .shortcut-icon {
        width: 38px;
        height: 38px;
        border-radius: 11px;
        background: #E6F2F1;
        color: #0B4F4A;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .shortcut-card:hover .shortcut-icon {
        background: #0B4F4A;
        color: #ffffff;
        transform: scale(1.12) rotate(6deg);
    }

    .pulsing-dot {
        width: 8px;
        height: 8px;
        background-color: #0B4F4A;
        border-radius: 50%;
        display: inline-block;
        box-shadow: 0 0 0 0 rgba(11, 79, 74, 0.7);
        animation: pulsePing 2s infinite !important;
    }

    /* Clean Organized Company Announcements Feed */
    .announcement-item-card {
        background: #F9F7F2;
        border: 1px solid #E6E0D4;
        border-left: 3px solid #0B4F4A;
        border-radius: 14px;
        padding: 0.85rem 1rem;
        margin-bottom: 0.65rem;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
    }

    .announcement-item-card:last-child {
        margin-bottom: 0;
    }

    .announcement-item-card:hover {
        background: #ffffff;
        border-color: #0B4F4A;
        border-left-width: 4px;
        transform: translateX(4px);
        box-shadow: 0 8px 20px rgba(11, 79, 74, 0.08);
    }

    .announcement-cat-badge {
        font-size: 0.7rem;
        font-weight: 700;
        padding: 0.2rem 0.6rem;
        border-radius: 999px;
        background: #E6F2F1;
        color: #0B4F4A;
        display: inline-flex;
        align-items: center;
    }

    .announcement-item-title {
        font-size: 0.85rem;
        font-weight: 700;
        color: #22333B;
        margin: 0.35rem 0 0.25rem 0;
        line-height: 1.35;
    }

    .announcement-item-body {
        font-size: 0.78rem;
        color: #6B7B83;
        margin: 0;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .announcement-filter-pill {
        font-size: 0.75rem;
        font-weight: 700;
        padding: 0.25rem 0.75rem;
        border-radius: 999px;
        border: 1px solid #E6E0D4;
        background: #F9F7F2;
        color: #6B7B83;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .announcement-filter-pill.active,
    .announcement-filter-pill:hover {
        background: #0B4F4A;
        color: #ffffff;
        border-color: #0B4F4A;
        box-shadow: 0 4px 10px rgba(11, 79, 74, 0.2);
    }
</style>
@endpush

@section('content')
<!-- Hero Welcome Section (Fluid Mesh Animated Header) -->
<div class="hero-welcome-banner">
    <div class="row align-items-center g-3">
        <div class="col-12 col-lg-7">
            <div class="d-flex align-items-center gap-3">
                <img src="{{ auth()->user()?->avatar ? asset(auth()->user()->avatar) : 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=120&q=80' }}" 
                     alt="Avatar" class="hero-avatar">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1.5">
                        <span class="badge rounded-pill bg-white bg-opacity-20 text-white fs-8 px-3 py-1">
                            <i class="bi bi-clock me-1"></i> {{ date('l, F j, Y') }}
                        </span>
                    </div>
                    <h2 class="mb-1 fw-extrabold text-white" style="letter-spacing: -0.02em;">
                        Welcome back, {{ auth()->user()?->name ?? 'System Super Admin' }} 👑
                    </h2>
                    <p class="mb-0 text-white-50 fs-7">
                        Here is your real-time workforce, department, and operational activity summary today.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-5 text-lg-end">
            <div class="d-flex flex-wrap gap-2 justify-content-lg-end align-items-center">
                <a href="{{ Route::has('employees.create') ? route('employees.create') : '#' }}" class="btn btn-light text-dark font-bold px-3.5 py-2 rounded-3 fs-7 fw-bold shadow-sm text-decoration-none d-inline-flex align-items-center gap-1.5">
                    <i class="bi bi-plus-lg"></i> Add Employee
                </a>
                <a href="{{ Route::has('attendance.index') ? route('attendance.index') : '#' }}" class="hero-quick-btn">
                    <i class="bi bi-clock-history"></i> Attendance Logs
                </a>
                <a href="{{ Route::has('payroll.index') ? route('payroll.index') : (Route::has('payroll.runs.index') ? route('payroll.runs.index') : '#') }}" class="hero-quick-btn">
                    <i class="bi bi-cash-stack"></i> Payroll
                </a>
            </div>
        </div>
    </div>
</div>

<!-- KPI Cards Grid (4 Cards Row matching Target Example Design) -->
<div class="row g-3 mb-4">
    <!-- 1. Total Employees -->
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="stat-card-gradient stat-card-pink">
            <div class="stat-card-title">Total Employees</div>
            <div class="d-flex align-items-center justify-content-between my-1">
                <div class="stat-card-value">{{ $stats['total_employees'] }}</div>
                <div class="stat-card-icon">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
            <div class="stat-card-subtext">
                <i class="bi bi-person-badge-fill me-1"></i> Registered Staff
            </div>
        </div>
    </div>

    <!-- 2. Active Headcount -->
    <div class="col-12 col-sm-6 col-lg-3">
        @php
            $activeRatio = $stats['total_employees'] > 0 ? round(($stats['active_employees'] / $stats['total_employees']) * 100) : 100;
        @endphp
        <div class="stat-card-gradient stat-card-purple">
            <div class="stat-card-title">Active Headcount</div>
            <div class="d-flex align-items-center justify-content-between my-1">
                <div class="stat-card-value">{{ $stats['active_employees'] }}</div>
                <div class="stat-card-icon">
                    <i class="bi bi-person-check-fill"></i>
                </div>
            </div>
            <div class="stat-card-subtext">
                <i class="bi bi-arrow-up-right-short fs-6"></i> {{ $activeRatio }}% Active Rate
            </div>
        </div>
    </div>

    <!-- 3. On Probation -->
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="stat-card-gradient stat-card-cyan">
            <div class="stat-card-title">On Probation</div>
            <div class="d-flex align-items-center justify-content-between my-1">
                <div class="stat-card-value">{{ $stats['probation_employees'] }}</div>
                <div class="stat-card-icon">
                    <i class="bi bi-clock-history"></i>
                </div>
            </div>
            <div class="stat-card-subtext">
                <i class="bi bi-exclamation-circle-fill me-1"></i> Review Due
            </div>
        </div>
    </div>

    <!-- 4. Departments -->
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="stat-card-gradient stat-card-emerald">
            <div class="stat-card-title">Departments</div>
            <div class="d-flex align-items-center justify-content-between my-1">
                <div class="stat-card-value">{{ $stats['total_departments'] }}</div>
                <div class="stat-card-icon">
                    <i class="bi bi-diagram-3-fill"></i>
                </div>
            </div>
            <div class="stat-card-subtext">
                <i class="bi bi-building-fill me-1"></i> {{ $stats['total_branches'] }} {{ Str::plural('Branch', $stats['total_branches']) }}
            </div>
        </div>
    </div>
</div>

<!-- Main Section Grid: Charts, Analytics, Shift Terminal & Modules -->
<div class="row g-4">
    <!-- Left Column: Donut Breakdown, Activity Trend (7 Cols) -->
    <div class="col-12 col-lg-7">
        
        <!-- Department Distribution Card -->
        <div class="dash-card">
            <div class="dash-card-header">
                <div>
                    <h5 class="dash-card-title">
                        <i class="bi bi-pie-chart-fill" style="color: #0B4F4A;"></i> Department Headcount Breakdown
                    </h5>
                    <div class="dash-card-subtitle">Real-time organization distribution across departments</div>
                </div>
                <span class="badge rounded-pill px-3 py-1.5 fs-8 fw-bold" style="background: #E6F2F1; color: #0B4F4A;">
                    <span class="pulsing-dot me-1"></span> Live Sync
                </span>
            </div>

            <div class="row align-items-center g-4">
                <!-- Donut Chart Canvas with Center Badge -->
                <div class="col-12 col-lg-5 text-center">
                    <div class="donut-wrapper">
                        <div id="departmentDonutChart"></div>
                        <div class="donut-center-badge">
                            <div class="total-num">{{ array_sum($deptChartData) }}</div>
                            <div class="total-label">Staff Total</div>
                        </div>
                    </div>
                </div>

                <!-- Custom Department Progress List -->
                <div class="col-12 col-lg-7">
                    <div class="custom-scroll pe-1">
                        @php
                            $totalDeptCount = array_sum($deptChartData) ?: 1;
                            $palette = ['#0B4F4A', '#E07A5F', '#C9A227', '#B5A47F', '#22333B'];
                        @endphp

                        @foreach($deptChartLabels as $idx => $label)
                            @php
                                $cnt = $deptChartData[$idx] ?? 0;
                                $pct = round(($cnt / $totalDeptCount) * 100);
                                $col = $palette[$idx % count($palette)];
                            @endphp
                            <div class="dept-progress-item">
                                <div class="d-flex justify-content-between align-items-center mb-1.5 gap-2">
                                    <div class="d-flex align-items-center gap-2 overflow-hidden me-2">
                                        <span class="rounded-circle d-inline-block flex-shrink-0" style="width: 8px; height: 8px; background: {{ $col }};"></span>
                                        <span class="fw-bold fs-7 text-dark text-truncate" title="{{ $label }}">{{ $label }}</span>
                                    </div>
                                    <div class="fs-7 fw-bold text-dark text-nowrap flex-shrink-0">
                                        {{ $cnt }} <span class="text-muted fs-8 font-normal">({{ $pct }}%)</span>
                                    </div>
                                </div>
                                <div class="progress" style="height: 6px; border-radius: 999px; background: #F5F1E8;">
                                    <div class="progress-bar" role="progressbar" style="width: {{ $pct }}%; background: {{ $col }}; border-radius: 999px;"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="pt-3 mt-3 border-top d-flex justify-content-between align-items-center fs-7">
                <span class="text-muted fs-8">Showing {{ count($deptChartLabels) }} active departments</span>
                <a href="{{ route('departments.index') }}" class="text-decoration-none fw-bold" style="color: #0B4F4A;">
                    View all Departments <i class="bi bi-chevron-right ms-0.5"></i>
                </a>
            </div>
        </div>

        <!-- Weekly Workforce Attendance & Activity Chart -->
        <div class="dash-card mb-0">
            <div class="dash-card-header">
                <div>
                    <h5 class="dash-card-title">
                        <i class="bi bi-graph-up-arrow" style="color: #0B4F4A;"></i> Workforce Attendance & Trend
                    </h5>
                    <div class="dash-card-subtitle">Daily clock-in rate vs target presence for the current week</div>
                </div>
                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" class="btn btn-sm active fs-8 py-1 px-3 fw-bold" style="background: #0B4F4A; color: #ffffff; border-color: #0B4F4A;">This Week</button>
                    <button type="button" class="btn btn-sm fs-8 py-1 px-3 fw-bold" style="background: #F9F7F2; color: #6B7B83; border: 1px solid #E6E0D4;">This Month</button>
                </div>
            </div>

            <div id="attendanceTrendChart" style="min-height: 220px;"></div>
        </div>

    </div>

    <!-- Right Column: Shift Terminal, Quick Modules, Announcements (5 Cols) -->
    <div class="col-12 col-lg-5">
        
        <!-- Daily Shift Terminal Card -->
        @php
            $isCheckedInToday = $todayAttendance && $todayAttendance->check_in && !$todayAttendance->check_out;
            $checkInTimeFormatted = $todayAttendance && $todayAttendance->check_in ? \Carbon\Carbon::parse($todayAttendance->check_in)->format('h:i A') : null;
        @endphp
        <div class="terminal-card">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-clock-history fs-6" style="color: #C9A227;"></i>
                    <span class="fw-bold fs-7 text-white-50 uppercase tracking-wider">Shift Terminal</span>
                </div>
                <span id="punchStatusText" class="badge {{ $isCheckedInToday ? 'bg-success' : 'bg-white bg-opacity-20' }} text-white px-2.5 py-1 rounded-pill fs-8">
                    {{ $isCheckedInToday ? 'Checked In (' . $checkInTimeFormatted . ')' : 'Ready' }}
                </span>
            </div>

            <div class="text-center py-1 mb-2">
                <div class="terminal-clock-display" id="liveDigitalClock">00:00:00 AM</div>
                <div class="fs-8 text-white-50 mt-0.5">Shift Hours: <strong class="text-white">09:00 AM – 06:00 PM</strong></div>
            </div>

            <button id="btnShiftPunch" class="terminal-btn-punch {{ $isCheckedInToday ? 'checked-in' : '' }}" onclick="toggleShiftPunch()">
                <i class="bi bi-box-arrow-in-right fs-6"></i>
                <span id="btnPunchLabel">{{ $isCheckedInToday ? 'Check Out Now' : 'Check In Now' }}</span>
            </button>
        </div>

        <!-- Quick Access Modules Grid -->
        <div class="dash-card">
            <div class="dash-card-header mb-2.5">
                <div>
                    <h5 class="dash-card-title fs-6">
                        <i class="bi bi-grid-fill" style="color: #0B4F4A;"></i> ERP Quick Modules
                    </h5>
                </div>
                <span class="fs-8 text-muted fw-semibold">6 Shortcuts</span>
            </div>

            <div class="row g-2">
                <div class="col-4">
                    <a href="{{ Route::has('employees.index') ? route('employees.index') : '#' }}" class="shortcut-card">
                        <div class="shortcut-icon"><i class="bi bi-people-fill"></i></div>
                        <span class="fs-8 fw-bold">Employees</span>
                    </a>
                </div>
                <div class="col-4">
                    <a href="{{ Route::has('attendance.index') ? route('attendance.index') : '#' }}" class="shortcut-card">
                        <div class="shortcut-icon"><i class="bi bi-calendar-check-fill"></i></div>
                        <span class="fs-8 fw-bold">Attendance</span>
                    </a>
                </div>
                <div class="col-4">
                    <a href="{{ Route::has('payroll.index') ? route('payroll.index') : (Route::has('payroll.runs.index') ? route('payroll.runs.index') : '#') }}" class="shortcut-card">
                        <div class="shortcut-icon"><i class="bi bi-wallet2"></i></div>
                        <span class="fs-8 fw-bold">Payroll</span>
                    </a>
                </div>
                <div class="col-4">
                    <a href="{{ Route::has('leave.index') ? route('leave.index') : (Route::has('leave.my') ? route('leave.my') : '#') }}" class="shortcut-card">
                        <div class="shortcut-icon"><i class="bi bi-airplane-fill"></i></div>
                        <span class="fs-8 fw-bold">Leave</span>
                    </a>
                </div>
                <div class="col-4">
                    <a href="{{ Route::has('recruitment.index') ? route('recruitment.index') : (Route::has('recruitment.jobs.index') ? route('recruitment.jobs.index') : '#') }}" class="shortcut-card">
                        <div class="shortcut-icon"><i class="bi bi-briefcase-fill"></i></div>
                        <span class="fs-8 fw-bold">Recruitment</span>
                    </a>
                </div>
                <div class="col-4">
                    <a href="{{ Route::has('assets.index') ? route('assets.index') : '#' }}" class="shortcut-card">
                        <div class="shortcut-icon"><i class="bi bi-box-seam-fill"></i></div>
                        <span class="fs-8 fw-bold">Assets</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Company Announcements Card -->
        <div class="dash-card mb-0">
            <div class="dash-card-header mb-2.5">
                <div>
                    <h5 class="dash-card-title fs-6">
                        <i class="bi bi-megaphone-fill" style="color: #0B4F4A;"></i> Company Announcements
                    </h5>
                    <div class="dash-card-subtitle">Official organization updates & notices</div>
                </div>
                <a href="{{ Route::has('noticeboard.index') ? route('noticeboard.index') : '#' }}" class="text-decoration-none fw-bold fs-8 text-nowrap d-inline-flex align-items-center gap-1 flex-shrink-0" style="color: #0B4F4A;">
                    View All <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <!-- Category Filter Pills -->
            <div class="d-flex gap-1.5 mb-3 overflow-x-auto pb-1">
                <button type="button" class="announcement-filter-pill active" onclick="filterAnnouncements('all', this)">All</button>
                <button type="button" class="announcement-filter-pill" onclick="filterAnnouncements('event', this)">Events</button>
                <button type="button" class="announcement-filter-pill" onclick="filterAnnouncements('policy', this)">Policies</button>
                <button type="button" class="announcement-filter-pill" onclick="filterAnnouncements('update', this)">Updates</button>
            </div>

            <div class="custom-scroll pe-1" id="announcementListContainer" style="max-height: 250px; overflow-y: auto;">
                @forelse($announcements as $ann)
                    <div class="announcement-item-card" data-category="all" 
                         onclick="showAnnouncementDetail('{{ addslashes($ann->title) }}', '{{ addslashes($ann->company?->name ?? 'Acme Global Corporation') }}', '{{ $ann->published_at ? $ann->published_at->diffForHumans() : '6 days ago' }}', '{{ addslashes($ann->body) }}', 'HQ Auditorium', 'Active Notice', 'Official_Broadcast.pdf')">
                        <div class="d-flex align-items-center justify-content-between flex-nowrap gap-2">
                            <span class="announcement-cat-badge overflow-hidden me-2" title="{{ $ann->company?->name ?? 'Acme Global' }}">
                                <i class="bi bi-building me-1 flex-shrink-0"></i> <span class="text-truncate d-inline-block" style="max-width: 140px; vertical-align: bottom;">{{ $ann->company?->name ?? 'Acme Global' }}</span>
                            </span>
                            <span class="text-muted fw-medium text-nowrap flex-shrink-0" style="font-size: 0.68rem;">
                                <i class="bi bi-clock me-1" style="font-size: 0.65rem;"></i>{{ $ann->published_at ? $ann->published_at->diffForHumans() : '6 days ago' }}
                            </span>
                        </div>
                        <h6 class="announcement-item-title">{{ $ann->title }}</h6>
                        <p class="announcement-item-body">{{ Str::limit($ann->body, 90) }}</p>
                    </div>
                @empty
                    <div class="announcement-item-card" data-category="all">
                        <div class="d-flex align-items-center justify-content-between flex-nowrap gap-2">
                            <span class="announcement-cat-badge overflow-hidden me-2" title="Acme Global">
                                <i class="bi bi-building me-1 flex-shrink-0"></i> <span class="text-truncate d-inline-block" style="max-width: 140px; vertical-align: bottom;">Acme Global</span>
                            </span>
                            <span class="text-muted fw-medium text-nowrap flex-shrink-0" style="font-size: 0.68rem;"><i class="bi bi-clock me-1" style="font-size: 0.65rem;"></i>6 days ago</span>
                        </div>
                        <h6 class="announcement-item-title">Quarterly All-Hands Townhall & Q3 Awards</h6>
                        <p class="announcement-item-body">Dear Acme Global Corporation Team, We are pleased to invite all employees to our Quarterly All-Hands Townhall & Q3 Awards...</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    let isCheckedIn = false;

    // Announcement Filtering
    function filterAnnouncements(category, btnEl) {
        const buttons = document.querySelectorAll('.announcement-filter-pill');
        buttons.forEach(b => b.classList.remove('active'));
        if (btnEl) btnEl.classList.add('active');

        const items = document.querySelectorAll('#announcementListContainer .announcement-item-card');
        items.forEach(item => {
            if (category === 'all' || item.getAttribute('data-category') === category) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    // Announcement Detail Popup Modal
    function showAnnouncementDetail(title, author, time, body, location, schedule, attachment) {
        Swal.fire({
            title: `<div class="fs-6 text-dark fw-bold text-start mb-1">${title}</div>`,
            html: `
                <div class="text-start fs-8 text-muted mb-3 border-bottom pb-2">
                    <i class="bi bi-person-circle me-1 text-primary"></i> ${author} • <i class="bi bi-clock me-1"></i> ${time}
                </div>
                <div class="text-start fs-7 text-secondary mb-3" style="line-height: 1.6;">
                    ${body}
                </div>
                <div class="d-flex flex-wrap gap-2 text-start pt-2 border-top">
                    ${location ? `<span class="badge bg-light text-dark border px-2.5 py-1.5 fs-8"><i class="bi bi-geo-alt-fill text-danger me-1"></i> ${location}</span>` : ''}
                    ${schedule ? `<span class="badge bg-light text-dark border px-2.5 py-1.5 fs-8"><i class="bi bi-calendar-check-fill text-primary me-1"></i> ${schedule}</span>` : ''}
                    ${attachment ? `<span class="badge bg-light text-primary border px-2.5 py-1.5 fs-8"><i class="bi bi-paperclip me-1"></i> ${attachment}</span>` : ''}
                </div>
            `,
            showCloseButton: true,
            confirmButtonText: '<i class="bi bi-check2-circle me-1"></i> Got It',
            confirmButtonColor: '#0B4F4A',
            customClass: {
                popup: 'rounded-4 border-0 shadow-lg p-4',
                confirmButton: 'px-4 py-2 rounded-pill fw-bold fs-7'
            }
        });
    }

    // Real-Time Digital Clock
    function updateDigitalClock() {
        const now = new Date();
        let hours = now.getHours();
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12;
        const strTime = `${String(hours).padStart(2, '0')}:${minutes}:${seconds} ${ampm}`;
        const clockEl = document.getElementById('liveDigitalClock');
        if (clockEl) {
            clockEl.textContent = strTime;
        }
    }

    // Toggle Punch Clock (Connected to Real Attendance DB API)
    function toggleShiftPunch() {
        const btn = document.getElementById('btnShiftPunch');
        const label = document.getElementById('btnPunchLabel');
        const status = document.getElementById('punchStatusText');

        fetch("{{ route('attendance.punch') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'checked_in') {
                isCheckedIn = true;
                btn.classList.add('checked-in');
                label.textContent = 'Check Out Now';
                status.textContent = 'Checked In (' + data.time + ')';
                status.className = 'badge bg-success text-white px-2.5 py-1 rounded-pill';

                Swal.fire({
                    icon: 'success',
                    title: 'Checked In Successfully!',
                    text: data.message,
                    confirmButtonColor: '#0B4F4A',
                    customClass: { popup: 'rounded-4 border-0 shadow-lg' }
                });
            } else if (data.status === 'checked_out') {
                isCheckedIn = false;
                btn.classList.remove('checked-in');
                label.textContent = 'Check In Now';
                status.textContent = 'Ready';
                status.className = 'badge bg-secondary text-white px-2.5 py-1 rounded-pill';

                Swal.fire({
                    icon: 'info',
                    title: 'Checked Out',
                    text: data.message,
                    confirmButtonColor: '#0B4F4A',
                    customClass: { popup: 'rounded-4 border-0 shadow-lg' }
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Terminal Notice',
                    text: data.error || data.message || 'Unable to update shift attendance.',
                    confirmButtonColor: '#0B4F4A'
                });
            }
        })
        .catch(err => {
            console.error('Punch Error:', err);
            Swal.fire({
                icon: 'error',
                title: 'Connection Error',
                text: 'Failed to communicate with shift terminal server.',
                confirmButtonColor: '#E07A5F'
            });
        });
    }

    document.addEventListener("DOMContentLoaded", function() {
        // Start Clock
        updateDigitalClock();
        setInterval(updateDigitalClock, 1000);

        // 1. Department Donut Chart
        const isDarkMode = document.documentElement.getAttribute('data-bs-theme') === 'dark';

        var donutOptions = {
            series: @json($deptChartData),
            labels: @json($deptChartLabels),
            chart: {
                type: 'donut',
                height: 220,
                width: 220,
                sparkline: { enabled: true },
                background: 'transparent'
            },
            theme: {
                mode: isDarkMode ? 'dark' : 'light'
            },
            colors: ['#0B4F4A', '#E07A5F', '#C9A227', '#B5A47F', '#22333B'],
            dataLabels: { enabled: false },
            legend: { show: false },
            tooltip: {
                enabled: true,
                theme: isDarkMode ? 'dark' : 'light',
                y: {
                    formatter: function(val) { return val + " Employees"; }
                }
            },
            stroke: { width: 3, colors: [isDarkMode ? '#1F2937' : '#ffffff'] },
            plotOptions: {
                pie: {
                    expandOnClick: false,
                    donut: {
                        size: '72%',
                        labels: { show: false }
                    }
                }
            }
        };

        var donutChart = new ApexCharts(document.querySelector("#departmentDonutChart"), donutOptions);
        donutChart.render();

        // 2. Attendance & Activity Trend Chart
        var trendOptions = {
            series: [{
                name: 'Present On-Time',
                data: [92, 95, 88, 96, 94, 78, 85]
            }, {
                name: 'Late / Absence',
                data: [8, 5, 12, 4, 6, 22, 15]
            }],
            chart: {
                type: 'area',
                height: 240,
                toolbar: { show: false },
                zoom: { enabled: false },
                background: 'transparent'
            },
            theme: {
                mode: isDarkMode ? 'dark' : 'light'
            },
            colors: ['#0B4F4A', '#E07A5F'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [0, 90, 100]
                }
            },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 2.5 },
            xaxis: {
                categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: {
                    style: {
                        colors: isDarkMode ? '#94A3B8' : '#6B7B83'
                    }
                }
            },
            yaxis: {
                max: 100,
                labels: {
                    formatter: function(val) { return val + "%"; },
                    style: {
                        colors: isDarkMode ? '#94A3B8' : '#6B7B83'
                    }
                }
            },
            grid: {
                borderColor: isDarkMode ? '#374151' : '#E6E0D4',
                strokeDashArray: 4
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                labels: {
                    colors: isDarkMode ? '#F8FAFC' : '#22333B'
                }
            },
            tooltip: {
                theme: isDarkMode ? 'dark' : 'light'
            }
        };

        var trendChart = new ApexCharts(document.querySelector("#attendanceTrendChart"), trendOptions);
        trendChart.render();
    });
</script>
@endpush
