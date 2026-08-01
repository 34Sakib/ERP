<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-bs-theme', savedTheme);
        })();
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'Enterprise ERP') }}</title>

    <!-- Google Fonts: Manrope -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- ApexCharts CSS -->
    <link href="https://cdn.jsdelivr.net/npm/apexcharts@3.46.0/dist/apexcharts.css" rel="stylesheet">

    <style>
        :root {
            /* Palette Tokens: Warm Beige + Deep Teal (Calm, High-End) */
            --bg-gradient: #F5F1E8;
            --app-card-bg: #FFFFFF;
            --sidebar-bg: #0B4F4A;
            --text-dark: #22333B;
            --text-gray: #6B7B83;
            --input-bg: #F5F3ED;

            --primary-accent: #0B4F4A;
            --primary-accent-hover: #073834;
            --secondary-tan: #B5A47F;
            --color-coral: #E07A5F;
            --color-gold: #C9A227;

            --font-main: 'Manrope', system-ui, -apple-system, sans-serif;
        }

        body {
            font-family: var(--font-main);
            background: var(--bg-gradient);
            color: var(--text-dark);
            min-height: 100vh;
            margin: 0;
            padding: 2rem 1.5rem;
            -webkit-font-smoothing: antialiased;
        }

        /* Floating Dashboard Outer Canvas Card */
        #floating-app-container {
            max-width: 1440px;
            margin: 0 auto;
            background: var(--app-card-bg);
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(11, 79, 74, 0.07);
            display: flex;
            min-height: 860px;
            position: relative;
            overflow: hidden;
            border: 1px solid #E6E0D4;
        }

        /* Decorative Floating Snippet Cards Peeking Behind Container */
        .bg-snippet-card {
            position: fixed;
            background: #ffffff;
            border-radius: 18px;
            padding: 1rem;
            box-shadow: 0 15px 35px rgba(11, 79, 74, 0.08);
            z-index: 0;
            pointer-events: none;
            opacity: 0.85;
            background-image: repeating-linear-gradient(45deg, rgba(230, 224, 212, 0.4) 0, rgba(230, 224, 212, 0.4) 10px, transparent 10px, transparent 20px);
        }

        .snippet-top-right {
            top: 25px;
            right: 40px;
            transform: rotate(12deg);
            width: 140px;
            text-align: center;
        }

        .snippet-bottom-left {
            bottom: 30px;
            left: 50px;
            transform: rotate(-10deg);
            width: 160px;
            text-align: center;
        }

        /* Floating Sidebar Panel */
        #sidebar-panel {
            width: 260px;
            background: linear-gradient(180deg, #0B4F4A 0%, #063431 100%) !important;
            border-right: 1px solid rgba(255, 255, 255, 0.1) !important;
            padding: 1.75rem 1.15rem 1.25rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            flex-shrink: 0;
            color: #ffffff;
        }

        .sidebar-brand-wrapper {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.75rem;
            padding-left: 0.5rem;
        }

        .sidebar-brand-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #0B4F4A 0%, #166560 100%);
            border: 1px solid rgba(181, 164, 127, 0.4);
            border-radius: 12px;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
            box-shadow: 0 6px 16px rgba(11, 79, 74, 0.4);
        }

        .sidebar-brand-text {
            font-size: 0.95rem;
            font-weight: 800;
            color: #FFFFFF !important;
            letter-spacing: 0.04em;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu .nav-item {
            margin-bottom: 0.3rem;
        }

        .sidebar-menu .nav-link {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 0.7rem 0.9rem;
            color: #E2ECEB !important;
            border-radius: 14px;
            font-weight: 600;
            font-size: 0.88rem;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            position: relative;
        }

        .sidebar-menu .nav-link i {
            font-size: 1.1rem;
            color: #B5A47F !important;
            width: 22px;
            text-align: center;
            transition: color 0.2s ease;
        }

        .sidebar-menu .nav-link:hover {
            color: #ffffff !important;
            background: rgba(181, 164, 127, 0.15) !important;
        }

        .sidebar-menu .nav-link:hover i {
            color: #E07A5F !important;
        }

        .sidebar-menu .nav-link.active {
            color: #ffffff !important;
            background: linear-gradient(135deg, #0B4F4A 0%, #166560 100%) !important;
            border: 1px solid rgba(181, 164, 127, 0.3);
            font-weight: 700;
            box-shadow: 0 8px 20px rgba(11, 79, 74, 0.4) !important;
        }

        .sidebar-menu .nav-link.active i {
            color: #B5A47F !important;
        }

        /* Sub-Navigation (Nested Dropdown Items) */
        .sidebar-menu .collapse {
            margin-left: 1.4rem;
            padding-left: 0.4rem;
            border-left: 2px solid rgba(181, 164, 127, 0.3);
            margin-top: 0.35rem;
            margin-bottom: 0.5rem;
        }

        .sidebar-menu .collapse .nav-item {
            margin-bottom: 0.25rem;
        }

        .sidebar-menu .collapse .nav-link {
            padding: 0.45rem 0.85rem !important;
            font-size: 0.83rem !important;
            font-weight: 500 !important;
            color: #D3E0DE !important;
            border-radius: 10px !important;
            box-shadow: none !important;
            background: transparent !important;
            display: flex;
            align-items: center;
            gap: 0.55rem;
        }

        .sidebar-menu .collapse .nav-link::before {
            content: '';
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: rgba(181, 164, 127, 0.5);
            display: inline-block;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        .sidebar-menu .collapse .nav-link:hover {
            color: #ffffff !important;
            background: rgba(181, 164, 127, 0.12) !important;
        }

        .sidebar-menu .collapse .nav-link:hover::before {
            background: #B5A47F;
            transform: scale(1.3);
        }

        .sidebar-menu .collapse .nav-link.active {
            color: #C9A227 !important;
            background: rgba(201, 162, 39, 0.15) !important;
            font-weight: 700 !important;
        }

        .sidebar-menu .collapse .nav-link.active::before {
            background: #C9A227;
            transform: scale(1.4);
            box-shadow: 0 0 8px rgba(201, 162, 39, 0.8);
        }

        .sidebar-menu [data-bs-toggle="collapse"] .bi-chevron-down {
            transition: transform 0.25s ease;
        }

        .sidebar-menu [data-bs-toggle="collapse"][aria-expanded="true"] .bi-chevron-down {
            transform: rotate(180deg);
        }

        .sidebar-user-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 0.85rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Bottom Sidebar Add New Button */
        .btn-sidebar-add {
            background: var(--primary-purple);
            color: #ffffff;
            border-radius: 999px;
            padding: 0.75rem 1.25rem;
            font-weight: 700;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-decoration: none;
            box-shadow: 0 8px 20px rgba(108, 99, 255, 0.25);
            transition: all 0.15s ease;
            border: none;
            width: 100%;
        }

        .btn-sidebar-add:hover {
            background: var(--primary-purple-hover);
            color: #ffffff;
            transform: translateY(-1px);
        }

        /* Main Content Viewport */
        #main-dashboard-viewport {
            flex: 1;
            padding: 2rem 2.25rem;
            overflow-y: auto;
            background: #ffffff;
        }

        /* Top Bar */
        .dashboard-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            gap: 1.5rem;
        }

        .topbar-title {
            font-size: 1.65rem;
            font-weight: 800;
            color: var(--text-dark);
            margin: 0;
            letter-spacing: -0.02em;
        }

        /* Pill Search Bar Elevated */
        .topbar-search-pill {
            background: #F8FAFC;
            border-radius: 999px;
            padding: 0.6rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            width: 380px;
            border: 1.5px solid #E2E8F0;
            transition: all 0.25s ease;
            position: relative;
        }

        .topbar-search-pill:focus-within {
            background: #ffffff;
            border-color: #0B4F4A;
            box-shadow: 0 0 0 4px rgba(11, 79, 74, 0.12);
        }

        .topbar-search-pill input {
            border: none;
            background: transparent;
            outline: none;
            font-size: 0.88rem;
            font-weight: 600;
            color: #22333B;
            width: 100%;
        }

        .topbar-search-pill input::placeholder {
            color: #6B7B83;
            font-weight: 500;
        }

        /* Search Dropdown Panel Elevated */
        .search-dropdown-card {
            top: calc(100% + 10px) !important;
            left: 0 !important;
            width: 440px !important;
            border-radius: 20px !important;
            border: 1px solid #E6E0D4 !important;
            box-shadow: 0 25px 50px -12px rgba(34, 51, 59, 0.15), 0 0 1px rgba(34, 51, 59, 0.1) !important;
            overflow: hidden !important;
            z-index: 1050 !important;
            background: #ffffff !important;
            animation: searchFadeIn 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes searchFadeIn {
            from {
                opacity: 0;
                transform: translateY(-8px) scale(0.98);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .search-dropdown-header {
            background: linear-gradient(135deg, #F9F7F2 0%, #F5F1E8 100%);
            padding: 0.85rem 1.15rem;
            border-bottom: 1px solid #E6E0D4;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .search-result-row {
            padding: 0.85rem 1.15rem;
            border-bottom: 1px solid #F5F1E8;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.85rem;
            position: relative;
        }

        .search-result-row:last-child {
            border-bottom: none;
        }

        .search-result-row:hover {
            background: linear-gradient(90deg, #F9F7F2 0%, #E6F2F1 100%);
            transform: translateX(4px);
        }

        .search-result-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            flex-shrink: 0;
        }

        .search-status-chip {
            font-size: 0.7rem;
            font-weight: 700;
            padding: 0.2rem 0.65rem;
            border-radius: 999px;
            text-transform: capitalize;
            letter-spacing: 0.01em;
            display: inline-block;
        }

        .search-status-chip.active {
            background: #E6F2F1;
            color: #0B4F4A;
            border: 1px solid rgba(11, 79, 74, 0.3);
        }

        .search-status-chip.probation {
            background: #FCE8E2;
            color: #E07A5F;
            border: 1px solid #F7C5B8;
        }

        .search-status-chip.other {
            background: #F5F1E8;
            color: #6B7B83;
            border: 1px solid #E6E0D4;
        }

        .search-dropdown-footer {
            background: #F9F7F2;
            padding: 0.75rem 1.15rem;
            border-top: 1px solid #E6E0D4;
            text-align: center;
        }

        .topbar-icons {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .icon-btn-plain {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-gray);
            font-size: 1.25rem;
            transition: background 0.15s ease;
            text-decoration: none;
        }

        .icon-btn-plain:hover {
            background: var(--input-bg);
            color: var(--text-dark);
        }

        .user-avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ffffff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        /* Global Theme System Class Overrides for Sub-Pages */
        .text-indigo,
        .text-purple,
        .text-primary {
            color: #0B4F4A !important;
        }

        .bg-indigo,
        .bg-purple,
        .bg-primary {
            background-color: #0B4F4A !important;
            color: #ffffff !important;
        }

        .bg-indigo-subtle,
        .bg-purple-subtle,
        .bg-primary-subtle,
        .bg-primary.bg-opacity-10,
        .bg-indigo.bg-opacity-10 {
            background-color: #E6F2F1 !important;
            color: #0B4F4A !important;
            border-color: rgba(11, 79, 74, 0.2) !important;
        }

        .btn-primary,
        .btn-indigo {
            background-color: #0B4F4A !important;
            border-color: #0B4F4A !important;
            color: #ffffff !important;
            box-shadow: 0 4px 14px rgba(11, 79, 74, 0.25) !important;
        }

        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary:active,
        .btn-indigo:hover {
            background-color: #073834 !important;
            border-color: #073834 !important;
            color: #ffffff !important;
        }

        .btn-outline-primary,
        .btn-outline-indigo {
            color: #0B4F4A !important;
            border-color: #0B4F4A !important;
        }

        .btn-outline-primary:hover,
        .btn-outline-indigo:hover {
            background-color: #0B4F4A !important;
            color: #ffffff !important;
        }

        .topbar-title {
            color: #22333B !important;
            font-weight: 800;
        }

        /* Card & Table Overrides for Sub-Pages */
        .card,
        .directory-card,
        .erp-card,
        .friendly-card,
        .side-widget-card,
        .notice-feed-card,
        .widget-panel-card,
        .calendar-container-card,
        .role-mesh-card,
        .tree-widget-card,
        .applicant-mesh-card,
        .deal-mesh-card,
        .task-mesh-card {
            border-color: #E6E0D4 !important;
        }

        .table-directory thead th,
        .table thead th {
            background: #F9F7F2 !important;
            color: #22333B !important;
            border-bottom: 2px solid #E6E0D4 !important;
        }

        .table tbody tr:hover,
        .table-hover tbody tr:hover {
            background-color: #F9F7F2 !important;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #0B4F4A !important;
            box-shadow: 0 0 0 3px rgba(11, 79, 74, 0.15) !important;
        }

        .nav-pills .nav-link.active,
        .nav-tabs .nav-link.active {
            background-color: #0B4F4A !important;
            color: #ffffff !important;
            border-color: #0B4F4A !important;
        }

        .nav-tabs .nav-link {
            color: #6B7B83;
        }

        .nav-tabs .nav-link:hover {
            color: #0B4F4A;
        }

        .page-item.active .page-link {
            background-color: #0B4F4A !important;
            border-color: #0B4F4A !important;
            color: #ffffff !important;
        }

        .page-link {
            color: #0B4F4A;
        }

        .swal2-confirm {
            background-color: #0B4F4A !important;
            border-color: #0B4F4A !important;
        }

        /* Friendly KPI Cards */
        .kpi-card-friendly {
            background: var(--input-bg);
            border-radius: 16px;
            padding: 1.1rem 1.1rem;
            border: none;
            box-shadow: none;
            position: relative;
            height: 100%;
        }

        .kpi-card-friendly.attention-alert {
            background: var(--pastel-red);
        }

        .kpi-chip-square {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-bottom: 0.85rem;
        }

        .kpi-label-friendly {
            font-size: 0.82rem;
            color: var(--text-gray);
            font-weight: 600;
            margin-bottom: 0.15rem;
        }

        .kpi-number-friendly {
            font-size: 1.65rem;
            font-weight: 800;
            color: var(--text-dark);
            line-height: 1.1;
        }

        .kpi-trend-arrow {
            position: absolute;
            top: 1rem;
            right: 1rem;
            color: #E53935;
            font-size: 1.25rem;
            font-weight: 800;
        }

        /* Friendly Dashboard Cards */
        .friendly-card {
            background: #ffffff;
            border-radius: 18px;
            border: 1px solid #F0EEF8;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .friendly-card-title {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 0.2rem;
        }

        .friendly-card-subtitle {
            font-size: 0.8rem;
            color: var(--text-gray);
            margin-bottom: 1.25rem;
        }

        /* Donut Ring styling */
        .donut-center-circle {
            position: relative;
            display: inline-block;
        }

        .donut-center-number {
            position: absolute;
            top: 48%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 1.65rem;
            font-weight: 800;
            color: var(--text-dark);
            text-align: center;
        }

        .donut-center-arrow {
            position: absolute;
            top: 48%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            font-weight: 800;
        }

        .arrow-up {
            background: #E6F9F0;
            color: #0C8F82;
        }

        .arrow-down {
            background: #FFEAEA;
            color: #E53935;
        }

        /* Comprehensive High-Visibility Dark Mode System */
        [data-bs-theme="dark"] {
            color-scheme: dark;
        }

        [data-bs-theme="dark"] body {
            background: linear-gradient(135deg, #0B0F19 0%, #111827 100%) !important;
            color: #F8FAFC !important;
        }
        [data-bs-theme="dark"] #floating-app-container {
            background: #111827 !important;
            border-color: #1F2937 !important;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5) !important;
        }
        [data-bs-theme="dark"] #sidebar-panel {
            background: #111827 !important;
            border-color: #1F2937 !important;
        }
        [data-bs-theme="dark"] #main-dashboard-viewport {
            background: #111827 !important;
            color: #F8FAFC !important;
        }
        [data-bs-theme="dark"] .sidebar-brand-text {
            color: #FFFFFF !important;
        }
        [data-bs-theme="dark"] .sidebar-menu .nav-link {
            color: #94A3B8 !important;
        }
        [data-bs-theme="dark"] .sidebar-menu .nav-link:hover {
            color: #818CF8 !important;
            background: rgba(129, 140, 248, 0.1) !important;
        }
        [data-bs-theme="dark"] .sidebar-menu .nav-link.active {
            color: #818CF8 !important;
            background: rgba(129, 140, 248, 0.15) !important;
        }
        [data-bs-theme="dark"] .topbar-title {
            color: #FFFFFF !important;
        }
        [data-bs-theme="dark"] .topbar-search-pill {
            background: #1F2937 !important;
            border-color: #374151 !important;
        }
        [data-bs-theme="dark"] .topbar-search-pill input {
            color: #F8FAFC !important;
        }
        [data-bs-theme="dark"] .topbar-search-pill input::placeholder {
            color: #64748B !important;
        }
        [data-bs-theme="dark"] .dropdown-menu {
            background-color: #1F2937 !important;
            border-color: #374151 !important;
            color: #F8FAFC !important;
        }
        [data-bs-theme="dark"] .dropdown-item {
            color: #CBD5E1 !important;
        }
        [data-bs-theme="dark"] .dropdown-item:hover {
            background-color: #374151 !important;
            color: #FFFFFF !important;
        }
        [data-bs-theme="dark"] .text-dark,
        [data-bs-theme="dark"] .text-black,
        [data-bs-theme="dark"] .text-body {
            color: #F8FAFC !important;
        }
        [data-bs-theme="dark"] .text-muted,
        [data-bs-theme="dark"] .text-secondary {
            color: #94A3B8 !important;
        }
        [data-bs-theme="dark"] .bg-light,
        [data-bs-theme="dark"] .bg-white,
        [data-bs-theme="dark"] .table-light {
            background-color: #1F2937 !important;
            color: #F8FAFC !important;
        }
        [data-bs-theme="dark"] .badge.bg-light,
        [data-bs-theme="dark"] .badge.bg-white,
        [data-bs-theme="dark"] .badge.bg-white.text-dark {
            background-color: #374151 !important;
            color: #F8FAFC !important;
            border-color: #4B5563 !important;
        }
        [data-bs-theme="dark"] .table-directory thead th {
            background: linear-gradient(180deg, #1F2937 0%, #111827 100%) !important;
            color: #94A3B8 !important;
            border-color: #374151 !important;
        }
        [data-bs-theme="dark"] .table-directory tbody tr {
            border-color: #1F2937 !important;
        }
        [data-bs-theme="dark"] .table-directory tbody tr:hover {
            background-color: #1F2937 !important;
        }
        [data-bs-theme="dark"] .directory-card,
        [data-bs-theme="dark"] .notice-feed-card,
        [data-bs-theme="dark"] .side-widget-card,
        [data-bs-theme="dark"] .kpi-accent-card,
        [data-bs-theme="dark"] .widget-panel-card,
        [data-bs-theme="dark"] .calendar-container-card,
        [data-bs-theme="dark"] .role-mesh-card,
        [data-bs-theme="dark"] .tree-widget-card,
        [data-bs-theme="dark"] .erp-card,
        [data-bs-theme="dark"] .friendly-card,
        [data-bs-theme="dark"] .message-feed-card {
            background: #1F2937 !important;
            border-color: #374151 !important;
            color: #F8FAFC !important;
        }
        [data-bs-theme="dark"] .modal-content {
            background: #1F2937 !important;
            color: #F8FAFC !important;
            border-color: #374151 !important;
        }
        [data-bs-theme="dark"] .form-control,
        [data-bs-theme="dark"] .form-select,
        [data-bs-theme="dark"] .input-group-text {
            background-color: #111827 !important;
            border-color: #374151 !important;
            color: #F8FAFC !important;
        }
        [data-bs-theme="dark"] .calendar-day-cell {
            background-color: #1F2937 !important;
            border-color: #374151 !important;
        }
        [data-bs-theme="dark"] .calendar-day-cell.weekend {
            background-color: #111827 !important;
        }
        [data-bs-theme="dark"] .calendar-day-cell.other-month {
            background-color: #111827 !important;
            opacity: 0.35;
        }
        [data-bs-theme="dark"] .calendar-table th {
            background-color: #111827 !important;
            border-color: #374151 !important;
            color: #94A3B8 !important;
        }
        [data-bs-theme="dark"] .code-chip {
            background-color: #111827 !important;
            border-color: #374151 !important;
            color: #CBD5E1 !important;
        }
        [data-bs-theme="dark"] .applicant-mesh-card,
        [data-bs-theme="dark"] .deal-mesh-card,
        [data-bs-theme="dark"] .task-mesh-card {
            background: #1F2937 !important;
            border-color: #374151 !important;
            color: #F8FAFC !important;
        }
        [data-bs-theme="dark"] .kanban-column-wrapper {
            background: #111827 !important;
            border-color: #1F2937 !important;
        }
        [data-bs-theme="dark"] .side-widget-header {
            background: #111827 !important;
            border-color: #374151 !important;
        }
        [data-bs-theme="dark"] .widget-item-row {
            background: #111827 !important;
        }
        [data-bs-theme="dark"] .table {
            color: #F8FAFC !important;
            border-color: #374151 !important;
        }
        [data-bs-theme="dark"] .table th,
        [data-bs-theme="dark"] .table td {
            color: #F8FAFC !important;
            border-color: #374151 !important;
        }
        [data-bs-theme="dark"] .btn-light,
        [data-bs-theme="dark"] .btn-white {
            background-color: #374151 !important;
            color: #F8FAFC !important;
            border-color: #4B5563 !important;
        }
        [data-bs-theme="dark"] .btn-light:hover,
        [data-bs-theme="dark"] .btn-white:hover {
            background-color: #4B5563 !important;
            color: #FFFFFF !important;
        }
        [data-bs-theme="dark"] .swal2-popup {
            background-color: #1F2937 !important;
            color: #F8FAFC !important;
        }
        [data-bs-theme="dark"] .swal2-title,
        [data-bs-theme="dark"] .swal2-html-container {
            color: #F8FAFC !important;
        }
    </style>
    @stack('styles')
    <style>
        /* ==========================================================================
           UNIVERSAL OVERRIDES FOR ALL SUB-PAGES & SIDEBAR VIEWS
           Enforces Warm Beige + Deep Teal palette across all module Blade templates
           ========================================================================== */

        /* 1. Universal Hero Banners & Header Gradients */
        div[class*="-hero"],
        div[class*="hero-"],
        div[class*="header-gradient"],
        div[class*="page-header"],
        .directory-hero,
        .payroll-hero,
        .leave-hero,
        .recruitment-hero,
        .finance-hero,
        .asset-hero,
        .crm-hero,
        .project-hero,
        .team-hero,
        .role-hero,
        .notice-hero,
        .calendar-hero,
        .attendance-hero,
        .hero-welcome-banner {
            background: linear-gradient(135deg, #0B4F4A 0%, #166560 50%, #B5A47F 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 15px 35px rgba(11, 79, 74, 0.2) !important;
            border: 1px solid rgba(181, 164, 127, 0.3) !important;
        }

        /* 2. All Cards & Content Container Cards on Sub-Pages */
        .card,
        .directory-card,
        .filter-panel-card,
        .notice-feed-card,
        .side-widget-card,
        .kpi-accent-card,
        .widget-panel-card,
        .calendar-container-card,
        .role-mesh-card,
        .tree-widget-card,
        .erp-card,
        .friendly-card,
        .message-feed-card,
        .applicant-mesh-card,
        .deal-mesh-card,
        .task-mesh-card,
        .kanban-column-wrapper,
        .kpi-card-v2 {
            background: #ffffff !important;
            border-color: #E6E0D4 !important;
        }

        /* 3. Action Buttons & Icons */
        .btn-primary,
        .btn-indigo,
        button[class*="btn-primary"] {
            background-color: #0B4F4A !important;
            border-color: #0B4F4A !important;
            color: #ffffff !important;
            box-shadow: 0 4px 14px rgba(11, 79, 74, 0.25) !important;
        }

        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary:active,
        .btn-indigo:hover {
            background-color: #073834 !important;
            border-color: #073834 !important;
            color: #ffffff !important;
        }

        .btn-outline-primary,
        .btn-outline-indigo {
            color: #0B4F4A !important;
            border-color: #0B4F4A !important;
        }

        .btn-outline-primary:hover,
        .btn-outline-indigo:hover {
            background-color: #0B4F4A !important;
            color: #ffffff !important;
        }

        .btn-light.text-indigo,
        .btn-light.text-primary {
            color: #0B4F4A !important;
            background-color: #ffffff !important;
            border: 1px solid #E6E0D4 !important;
        }

        /* 4. Text, Links, Badges & Chips */
        .text-indigo,
        .text-purple,
        .text-primary,
        a.text-primary,
        a.text-indigo,
        .fw-bold.text-indigo {
            color: #0B4F4A !important;
        }

        .bg-indigo,
        .bg-purple,
        .bg-primary {
            background-color: #0B4F4A !important;
            color: #ffffff !important;
        }

        .bg-indigo-subtle,
        .bg-purple-subtle,
        .bg-primary-subtle,
        .bg-primary.bg-opacity-10,
        .bg-indigo.bg-opacity-10,
        span[style*="background: #EEF2FF"],
        span[style*="background:#EEF2FF"],
        div[style*="background: #EEF2FF"],
        div[style*="background:#EEF2FF"] {
            background-color: #E6F2F1 !important;
            color: #0B4F4A !important;
            border-color: rgba(11, 79, 74, 0.2) !important;
        }

        /* 5. Tables & Directory Grids */
        .table-directory thead th,
        .table thead th,
        table thead th {
            background: #F9F7F2 !important;
            color: #22333B !important;
            border-bottom: 2px solid #E6E0D4 !important;
        }

        .table tbody tr:hover,
        .table-hover tbody tr:hover,
        .widget-item-row:hover {
            background-color: #F5F1E8 !important;
        }

        /* 6. Form Inputs & Filters */
        .form-control:focus,
        .form-select:focus,
        .filter-input-pill input:focus {
            border-color: #0B4F4A !important;
            box-shadow: 0 0 0 3px rgba(11, 79, 74, 0.15) !important;
        }

        .filter-input-pill input {
            background: #F9F7F2 !important;
            border-color: #E6E0D4 !important;
            color: #22333B !important;
        }

        /* 7. Nav Pills, Tabs, Pagination & Modals */
        .nav-pills .nav-link.active,
        .nav-tabs .nav-link.active {
            background-color: #0B4F4A !important;
            color: #ffffff !important;
            border-color: #0B4F4A !important;
        }

        .nav-tabs .nav-link {
            color: #6B7B83;
        }

        .nav-tabs .nav-link:hover {
            color: #0B4F4A;
        }

        .page-item.active .page-link {
            background-color: #0B4F4A !important;
            border-color: #0B4F4A !important;
            color: #ffffff !important;
        }

        .page-link {
            color: #0B4F4A;
        }

        .swal2-confirm {
            background-color: #0B4F4A !important;
            border-color: #0B4F4A !important;
        }
    </style>
</head>

<body>

    <!-- Floating Background Decorative Cards -->
    <div class="bg-snippet-card snippet-top-right">
        <div style="font-size: 1.2rem; font-weight: 800; color: var(--text-dark);">{{ $stats['total_departments'] ?? '4' }}</div>
        <div style="font-size: 0.7rem; color: var(--text-gray);">Departments</div>
    </div>
    <div class="bg-snippet-card snippet-bottom-left">
        <div style="font-size: 1.2rem; font-weight: 800; color: var(--text-dark);">{{ $stats['active_employees'] ?? '3' }}</div>
        <div style="font-size: 0.7rem; color: var(--text-gray);">Active Staff</div>
    </div>

    <!-- Outer Floating White Card Container -->
    <div id="floating-app-container">
        <!-- Sidebar Panel -->
        <aside id="sidebar-panel">
            <div>
                <div class="sidebar-brand-wrapper">
                    <div class="sidebar-brand-icon">
                        <i class="bi bi-hexagon-fill"></i>
                    </div>
                    <span class="sidebar-brand-text">ENTERPRISE ERP</span>
                </div>

                <ul class="sidebar-menu">
                    @php
                    $sidebarConfig = config('sidebar.items', []);
                    @endphp

                    @foreach($sidebarConfig as $item)
                    @php
                    $hasChildren = !empty($item['children']);
                    $permission = $item['permission'] ?? null;
                    $canViewParent = !$permission || (auth()->check() && auth()->user()->can($permission));

                    if ($hasChildren && !$canViewParent) {
                    foreach ($item['children'] as $child) {
                    if (empty($child['permission']) || (auth()->check() && auth()->user()->can($child['permission']))) {
                    $canViewParent = true;
                    break;
                    }
                    }
                    }
                    @endphp

                    @if($canViewParent)
                    @if($hasChildren)
                    @php
                    $collapseId = 'menu-' . Str::slug($item['label']);
                    $isParentActive = false;
                    foreach($item['children'] as $child) {
                    if (isset($child['route']) && Route::has($child['route']) && request()->routeIs($child['route'])) {
                    $isParentActive = true;
                    break;
                    }
                    }
                    @endphp
                    <li class="nav-item">
                        <a class="nav-link {{ $isParentActive ? 'active' : '' }}" data-bs-toggle="collapse" href="#{{ $collapseId }}" role="button" aria-expanded="{{ $isParentActive ? 'true' : 'false' }}">
                            <i class="{{ $item['icon'] ?? 'bi bi-circle' }}"></i>
                            <span>{{ $item['label'] }}</span>
                            <i class="bi bi-chevron-down ms-auto fs-8 opacity-60"></i>
                        </a>
                        <div class="collapse {{ $isParentActive ? 'show' : '' }}" id="{{ $collapseId }}">
                            <ul class="nav flex-column">
                                @foreach($item['children'] as $child)
                                @php
                                $childPermission = $child['permission'] ?? null;
                                $canViewChild = !$childPermission || (auth()->check() && auth()->user()->can($childPermission));
                                @endphp
                                @if($canViewChild)
                                <li class="nav-item">
                                    <a href="{{ isset($child['route']) && Route::has($child['route']) ? route($child['route']) : '#' }}"
                                        class="nav-link {{ isset($child['route']) && Route::has($child['route']) && request()->routeIs($child['route']) ? 'active' : '' }}">
                                        <span>{{ $child['label'] }}</span>
                                    </a>
                                </li>
                                @endif
                                @endforeach
                            </ul>
                        </div>
                    </li>
                    @else
                    <li class="nav-item">
                        <a href="{{ isset($item['route']) && Route::has($item['route']) ? route($item['route']) : '#' }}"
                            class="nav-link {{ isset($item['route']) && Route::has($item['route']) && request()->routeIs($item['route']) ? 'active' : '' }}">
                            <i class="{{ $item['icon'] ?? 'bi bi-circle' }}"></i>
                            <span>{{ $item['label'] }}</span>
                        </a>
                    </li>
                    @endif
                    @endif
                    @endforeach
                </ul>
            </div>

            <div>
                <!-- User Profile Footer -->
                <div class="sidebar-user-footer">
                    <div class="d-flex align-items-center gap-2.5">
                        <img src="{{ auth()->user()?->avatar ? asset(auth()->user()->avatar) : 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=80&q=80' }}" 
                             class="rounded-circle" style="width: 36px; height: 36px; object-fit: cover; border: 2px solid rgba(255,255,255,0.2);">
                        <div>
                            <div class="fw-bold text-white fs-8">{{ auth()->user()?->name ?? 'Super Admin' }}</div>
                            <div class="fs-8 text-white-50">{{ $role ?? 'System Admin' }}</div>
                        </div>
                    </div>
                    <button class="btn btn-link text-white-50 p-0 border-0 fs-6 shadow-none">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                </div>
            </div>
        </aside>

        <!-- Main Dashboard Viewport -->
        <main id="main-dashboard-viewport">
            <!-- Topbar -->
            <div class="dashboard-topbar">
                <h1 class="topbar-title">Dashboard</h1>

                <div class="topbar-search-pill">
                    <i class="bi bi-search text-muted fs-7"></i>
                    <input type="text" id="topbar-search-input" placeholder="Search for an employee by name, code, email..." autocomplete="off">
                    <i id="clear-search-btn" class="bi bi-x-circle-fill text-secondary opacity-50 cursor-pointer d-none fs-7 me-1" title="Clear search" style="cursor: pointer;"></i>
                    <div id="search-spinner" class="spinner-border spinner-border-sm text-primary d-none ms-1" role="status" style="width: 1rem; height: 1rem;"></div>

                    <!-- Instant Search Live Dropdown Popup Card -->
                    <div id="search-dropdown-menu" class="search-dropdown-card dropdown-menu p-0" style="display: none;">
                        <div class="search-dropdown-header">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-person-search text-primary fs-6"></i>
                                <span class="fs-7 fw-bold text-dark" style="letter-spacing: -0.01em;">Employee Matches</span>
                            </div>
                            <span id="search-count-badge" class="badge rounded-pill" style="background: #EEF2FF; color: #4F46E5; border: 1px solid #C7D2FE; font-weight: 800; font-size: 0.75rem; padding: 0.35rem 0.75rem;">0 Matches</span>
                        </div>
                        
                        <div id="search-results-list" class="custom-scroll" style="max-height: 340px; overflow-y: auto;">
                            <!-- Dynamic Search Results -->
                        </div>

                        <div class="search-dropdown-footer p-2.5 bg-light border-top">
                            <a href="{{ route('employees.index') }}" id="search-view-all-link" 
                               class="btn btn-primary btn-sm w-100 rounded-pill fw-bold fs-8 py-2 d-flex align-items-center justify-content-center gap-1.5 shadow-sm"
                               style="background: linear-gradient(135deg, #4F46E5 0%, #6366F1 100%); border: none;">
                                <span>View Full Employee Directory</span>
                                <i class="bi bi-arrow-right fs-7"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="topbar-icons">
                    <!-- Dark/Light Theme Switcher Button -->
                    <button type="button" class="icon-btn-plain border-0 bg-transparent" id="theme-toggle-btn" onclick="toggleTheme()" title="Toggle Dark/Light Mode">
                        <i id="theme-toggle-icon" class="bi bi-moon-stars-fill"></i>
                    </button>

                    <!-- Notifications Dropdown Popup (Refined Dynamic UI8 Style) -->
                    <div class="dropdown">
                        <button class="icon-btn-plain border-0 bg-transparent position-relative" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-bell"></i>
                            @if(($unreadNotificationsCount ?? 0) > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light" style="font-size: 0.65rem; padding: 0.25rem 0.4rem;">
                                    {{ $unreadNotificationsCount }}
                                </span>
                            @endif
                        </button>
                        <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 p-0 mt-2" style="width: 380px; border-radius: 18px; overflow: hidden; background: #ffffff;">
                            <!-- Header with All / Unread Filter Tabs -->
                            <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-white">
                                <h5 class="mb-0 fw-bold fs-6 text-dark" style="letter-spacing: -0.01em;">Notifications</h5>
                                <div class="d-flex gap-1 bg-light p-1 rounded-pill fs-8">
                                    <button type="button" id="notif-tab-all" class="btn btn-sm py-0.5 px-3 rounded-pill fw-bold text-dark bg-white shadow-sm border-0 fs-8" onclick="filterNotifs('all')">All</button>
                                    <button type="button" id="notif-tab-unread" class="btn btn-sm py-0.5 px-3 rounded-pill text-muted border-0 fs-8" onclick="filterNotifs('unread')">Unread ({{ $unreadNotificationsCount ?? 0 }})</button>
                                </div>
                            </div>

                            <!-- Dynamic Notification Item List -->
                            <div class="list-group list-group-flush" id="notif-container" style="max-height: 380px; overflow-y: auto;">
                                @forelse(($notificationsList ?? []) as $notif)
                                    <div class="list-group-item p-3 border-bottom border-light notif-item-row {{ $notif->is_read ? 'notif-read' : 'notif-unread' }}">
                                        <div class="d-flex align-items-start gap-3">
                                            <div class="position-relative flex-shrink-0">
                                                <img src="{{ $notif->sender_avatar ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80' }}" class="rounded-circle" style="width: 44px; height: 44px; object-fit: cover;">
                                                <span class="position-absolute bottom-0 end-0 text-white rounded-circle d-flex align-items-center justify-content-center {{ $notif->badge_color }}" style="width: 18px; height: 18px; font-size: 0.65rem; border: 2px solid #fff;">
                                                    <i class="bi {{ $notif->badge_icon }}"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <strong class="fs-7 text-dark fw-bold">{{ $notif->sender_name }}</strong>
                                                        <span class="text-muted fs-8 ms-1">{{ $notif->created_at->diffForHumans(null, true, true) }} ago</span>
                                                    </div>
                                                    @if(!$notif->is_read)
                                                        <span class="rounded-circle bg-success d-inline-block" style="width: 8px; height: 8px;" title="Unread"></span>
                                                    @endif
                                                </div>
                                                <div class="fs-8 text-secondary mt-0.5">
                                                    {{ $notif->title }}
                                                    @if($notif->target_name)
                                                        <strong class="text-dark">{{ $notif->target_name }}</strong>
                                                    @endif
                                                </div>
                                                @if($notif->body)
                                                    <p class="mb-0 text-muted fs-8 mt-1 text-truncate" style="max-width: 260px;">{{ $notif->body }}</p>
                                                @endif

                                                @if($notif->has_actions)
                                                    <div class="d-flex gap-2 mt-2.5">
                                                        <button type="button" class="btn btn-light btn-sm rounded-pill px-3 py-1 fs-8 fw-bold text-dark border-0" style="background: #EAEAEA;" onclick="Swal.fire('Declined', 'Action declined.', 'info')">{{ $notif->action_decline_label }}</button>
                                                        <button type="button" class="btn btn-dark btn-sm rounded-pill px-3 py-1 fs-8 fw-bold text-white border-0" style="background: #222222;" onclick="Swal.fire('Accepted', 'Action accepted.', 'success')">{{ $notif->action_accept_label }}</button>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-4 text-center text-muted fs-8">
                                        <i class="bi bi-bell-slash fs-4 d-block mb-1"></i>
                                        No notifications found.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Rich User Profile Dropdown Popup -->
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center gap-2 text-decoration-none dropdown-toggle text-dark" data-bs-toggle="dropdown">
                            <img src="{{ auth()->user()?->avatar ? asset(auth()->user()->avatar) : 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80' }}" alt="Avatar" class="user-avatar-circle user-avatar-img">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 fs-7 p-2 mt-2" style="width: 250px; border-radius: 14px;">
                            <li class="px-3 py-2 border-bottom mb-2">
                                <div class="fw-bold text-dark user-name-display">{{ auth()->user()?->name ?? 'System Admin' }}</div>
                                <div class="fs-8 text-muted user-email-display">{{ auth()->user()?->email ?? 'admin@erp.com' }}</div>
                                <span class="badge bg-primary bg-opacity-10 text-primary mt-1 fs-8">
                                    {{ auth()->user()?->getRoleNames()->first() ?? 'Super Admin' }}
                                </span>
                            </li>
                            <li>
                                <a class="dropdown-item rounded-2 py-2" href="#" data-bs-toggle="modal" data-bs-target="#userSettingsModal">
                                    <i class="bi bi-person-gear me-2 text-primary"></i> Account Settings
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item rounded-2 py-2" href="#" data-bs-toggle="modal" data-bs-target="#userSettingsModal">
                                    <i class="bi bi-shield-lock me-2 text-secondary"></i> Security & Password
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item rounded-2 py-2 text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right me-2"></i> Log Out
                                </a>
                            </li>
                        </ul>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </div>
                </div>
            </div>

            <!-- Main Page Content Slot -->
            @yield('content')
        </main>
    </div>

    <!-- User Account Settings Modal Popup -->
    <div class="modal fade" id="userSettingsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                <div class="modal-header border-bottom px-4 py-3">
                    <h5 class="modal-title fw-bold text-dark fs-6"><i class="bi bi-person-gear me-2 text-primary"></i>Account & User Settings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="userSettingsForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" onsubmit="handleProfileFormSubmit(event)">
                        @csrf
                        <div class="mb-3 text-center">
                            <img id="avatar-preview-img" src="{{ auth()->user()?->avatar ? asset(auth()->user()->avatar) : 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80' }}" class="rounded-circle shadow-sm mb-2 user-avatar-img" style="width: 76px; height: 76px; object-fit: cover;">
                            <div>
                                <label for="avatar-file-input" class="btn btn-outline-secondary btn-sm fs-8 rounded-pill cursor-pointer">
                                    <i class="bi bi-camera me-1"></i> Change Avatar
                                </label>
                                <input type="file" id="avatar-file-input" name="avatar" class="d-none" accept="image/*" onchange="previewAvatar(this)">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold fs-7">Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{ auth()->user()?->name ?? 'System Admin' }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold fs-7">Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ auth()->user()?->email ?? 'admin@erp.com' }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold fs-7">Phone Number</label>
                            <input type="text" name="phone" class="form-control" value="{{ auth()->user()?->phone ?? '' }}" placeholder="+1 (555) 000-0000">
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label fw-bold fs-7">New Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Optional">
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold fs-7">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Optional">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 pt-2 border-top">
                            <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" id="save-settings-btn" class="btn btn-primary btn-sm px-4 fw-bold">Save Settings</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.46.0/dist/apexcharts.min.js"></script>
    <script>
        function filterNotifs(type) {
            const allBtn = document.getElementById('notif-tab-all');
            const unreadBtn = document.getElementById('notif-tab-unread');
            const items = document.querySelectorAll('#notif-container .notif-item-row');

            if (type === 'all') {
                allBtn.className = 'btn btn-sm py-0.5 px-3 rounded-pill fw-bold text-dark bg-white shadow-sm border-0 fs-8';
                unreadBtn.className = 'btn btn-sm py-0.5 px-3 rounded-pill text-muted border-0 fs-8';
                items.forEach(el => el.style.display = '');
            } else {
                unreadBtn.className = 'btn btn-sm py-0.5 px-3 rounded-pill fw-bold text-dark bg-white shadow-sm border-0 fs-8';
                allBtn.className = 'btn btn-sm py-0.5 px-3 rounded-pill text-muted border-0 fs-8';
                items.forEach(el => {
                    el.style.display = el.classList.contains('notif-unread') ? '' : 'none';
                });
            }
        }

        function previewAvatar(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#avatar-preview-img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function handleProfileFormSubmit(e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            const $btn = $('#save-settings-btn');
            $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Saving...');

            $.ajax({
                url: form.action,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    $btn.prop('disabled', false).text('Save Settings');
                    
                    const modalEl = document.getElementById('userSettingsModal');
                    const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                    modal.hide();

                    Swal.fire({
                        icon: 'success',
                        title: 'Account Settings Saved!',
                        text: 'Your profile information and preferences have been updated successfully.',
                        confirmButtonColor: '#6C63FF',
                        confirmButtonText: 'Great!',
                        customClass: {
                            popup: 'rounded-4 border-0 shadow-lg',
                            confirmButton: 'px-4 py-2 rounded-pill fw-bold'
                        }
                    });

                    if (response.user) {
                        $('.user-name-display').text(response.user.name);
                        $('.user-email-display').text(response.user.email);
                        if (response.user.avatar) {
                            $('.user-avatar-img').attr('src', response.user.avatar);
                        }
                    }
                },
                error: function(xhr) {
                    $btn.prop('disabled', false).text('Save Settings');
                    let errMsg = 'Something went wrong. Please check your inputs.';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errMsg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Update Failed',
                        html: errMsg,
                        confirmButtonColor: '#E53935',
                        customClass: {
                            popup: 'rounded-4 border-0 shadow-lg'
                        }
                    });
                }
            });
        }

        // Instant Live Employee Search
        let topbarSearchTimer = null;
        
        function clearTopSearch() {
            $('#topbar-search-input').val('');
            $('#clear-search-btn').addClass('d-none');
            $('#search-dropdown-menu').hide();
            $('#search-spinner').addClass('d-none');
        }

        $(document).on('click', '#clear-search-btn', function() {
            clearTopSearch();
        });

        $(document).on('input', '#topbar-search-input', function() {
            const query = $(this).val().trim();
            const $dropdown = $('#search-dropdown-menu');
            const $list = $('#search-results-list');
            const $badge = $('#search-count-badge');
            const $spinner = $('#search-spinner');
            const $clearBtn = $('#clear-search-btn');
            const $viewAll = $('#search-view-all-link');

            clearTimeout(topbarSearchTimer);

            if (query.length > 0) {
                $clearBtn.removeClass('d-none');
            } else {
                $clearBtn.addClass('d-none');
            }

            if (query.length < 1) {
                $dropdown.hide();
                $spinner.addClass('d-none');
                return;
            }

            $spinner.removeClass('d-none');

            topbarSearchTimer = setTimeout(function() {
                $.ajax({
                    url: "{{ route('employees.search.api') }}",
                    type: "GET",
                    data: { q: query },
                    success: function(data) {
                        $spinner.addClass('d-none');
                        $list.empty();
                        $badge.text(data.length + (data.length === 1 ? ' Match' : ' Matches'));
                        $viewAll.attr('href', "{{ route('employees.index') }}?search=" + encodeURIComponent(query));

                        if (data.length > 0) {
                            data.forEach(function(emp) {
                                let statusClass = 'other';
                                if (emp.status === 'active') statusClass = 'active';
                                if (emp.status === 'probation') statusClass = 'probation';

                                const itemHtml = `
                                    <a href="${emp.url}" class="search-result-row">
                                        <img src="${emp.photo}" alt="${emp.full_name}" class="search-result-avatar">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <div class="d-flex justify-content-between align-items-center mb-0.5">
                                                <span class="fs-7 fw-bold text-dark text-truncate mb-0">${emp.full_name}</span>
                                                <span class="search-status-chip ${statusClass}">${emp.status}</span>
                                            </div>
                                            <div class="fs-8 text-secondary text-truncate d-flex align-items-center gap-1.5">
                                                <span class="fw-bold text-dark bg-light px-1.5 py-0.5 rounded" style="font-size: 0.72rem; border: 1px solid #E2E8F0;">${emp.code}</span>
                                                <span>•</span>
                                                <span>${emp.designation} (${emp.department})</span>
                                            </div>
                                        </div>
                                        <i class="bi bi-chevron-right text-muted fs-8 ms-1 opacity-50"></i>
                                    </a>
                                `;
                                $list.append(itemHtml);
                            });
                        } else {
                            $list.html(`
                                <div class="p-4 text-center text-muted fs-8">
                                    <i class="bi bi-search fs-4 d-block mb-2 text-secondary opacity-50"></i>
                                    No matching employees found for "<strong class="text-dark">${query}</strong>"
                                </div>
                            `);
                        }
                        $dropdown.show();
                    },
                    error: function() {
                        $spinner.addClass('d-none');
                        $dropdown.hide();
                    }
                });
            }, 150);
        });

        // Hide search dropdown on click outside or Escape key
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.topbar-search-pill').length) {
                $('#search-dropdown-menu').hide();
            }
        });

        $(document).on('keyup', function(e) {
            if (e.key === 'Escape') {
                $('#search-dropdown-menu').hide();
            }
        });

        // Global Dark / Light Mode Toggle System
        function applyThemeIcon(theme) {
            const icon = document.getElementById('theme-toggle-icon');
            if (!icon) return;
            if (theme === 'dark') {
                icon.className = 'bi bi-sun-fill text-warning';
            } else {
                icon.className = 'bi bi-moon-stars-fill text-secondary';
            }
        }

        function toggleTheme() {
            const currentTheme = document.documentElement.getAttribute('data-bs-theme') || 'light';
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            applyThemeIcon(newTheme);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const currentTheme = document.documentElement.getAttribute('data-bs-theme') || 'light';
            applyThemeIcon(currentTheme);
        });
    </script>

    <!-- Global Flash Message SweetAlert Popups -->
    @if(session('success') || session('status') || session('message') || session('error') || session('info') || session('warning'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
            
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                background: isDark ? '#1F2937' : '#ffffff',
                color: isDark ? '#F8FAFC' : '#1E1B4B',
                customClass: {
                    popup: 'rounded-4 shadow-lg border p-3'
                },
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });

            @if(session('success') || session('status') || session('message'))
                Toast.fire({
                    icon: 'success',
                    title: 'Action Completed Successfully',
                    text: @json(session('success') ?? session('status') ?? session('message'))
                });
            @elseif(session('error'))
                Toast.fire({
                    icon: 'error',
                    title: 'Operation Failed',
                    text: @json(session('error'))
                });
            @elseif(session('info'))
                Toast.fire({
                    icon: 'info',
                    title: 'Information',
                    text: @json(session('info'))
                });
            @elseif(session('warning'))
                Toast.fire({
                    icon: 'warning',
                    title: 'Notice',
                    text: @json(session('warning'))
                });
            @endif
        });
    </script>
    @endif

    @stack('scripts')
</body>

</html>