<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Aciaa Store Admin - @yield('title')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;600;700&family=Fira+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom Admin CSS -->
    <style>
        \:root {
            --primary: #DB2777; /* Pink accent */
            --primary-light: #FBCFE8; /* Soft pink */
            --cta: #CA8A04;
            --bg-body: #F8F9FA; /* Clean light gray background */
            --text-main: #1F2937; /* Dark gray text */
            --text-muted: #6B7280;
            --glass-bg: #FFFFFF; /* Solid white cards */
            --glass-border: #E5E7EB; /* Subtle gray borders */
            --sidebar-bg: #FFFFFF;
            --sidebar-active: rgba(219, 39, 119, 0.08); /* Soft pink active state */
            --transition-smooth: all 0.3s ease;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Fira Sans', sans-serif;
            background: var(--bg-body);
            color: var(--text-main);
            overflow-x: auto !important;
            position: relative;
        }

        /* Sidebar - Liquid Glass */
        .admin-sidebar {
            background: #FFFFFF;
            
            -webkit-
            min-height: 100vh;
            width: 280px;
            transition: var(--transition-smooth);
            position: relative;
            box-shadow: 1px 0 0 var(--glass-border);
            border-right: 1px solid var(--glass-border);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            z-index: 1000;
        }
        
        .sidebar-header {
            padding: 28px 24px;
            text-align: center;
            border-bottom: 1px solid var(--glass-border);
        }
        
        .sidebar-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            text-decoration: none;
            margin-bottom: 8px;
            transition: transform 0.3s ease;
        }
        
        .sidebar-logo:hover {
            transform: scale(1.02);
        }
        
        .sidebar-logo span {
            font-family: 'Fira Code', monospace;
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--primary);
            letter-spacing: 0.5px;
        }
        
        .sidebar-subtitle {
            font-size: 0.72rem;
            color: var(--primary-light);
            letter-spacing: 2px;
            text-transform: uppercase;
            font-weight: 600;
        }
        
        .sidebar-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--glass-border), transparent);
            margin: 16px 20px;
        }
        
        .sidebar-nav {
            padding: 8px 12px;
            flex-grow: 1;
        }
        
        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 18px;
            color: var(--text-main);
            text-decoration: none;
            transition: var(--transition-smooth);
            font-size: 0.9rem;
            font-weight: 500;
            border-radius: 16px;
            margin-bottom: 6px;
            position: relative;
            background: transparent;
            border: 1px solid transparent;
        }
        
        .sidebar-nav .nav-link i, .sidebar-nav .nav-link svg {
            width: 18px;
            height: 18px;
            transition: var(--transition-smooth);
            color: var(--primary-light);
        }
        
        .sidebar-nav .nav-link:hover {
            background: #FFFFFF;
            border: 1px solid var(--glass-border);
            box-shadow: 0 4px 15px rgba(219, 39, 119, 0.05);
            transform: translateX(4px);
        }
        
        .sidebar-nav .nav-link:hover i, .sidebar-nav .nav-link:hover svg {
            color: var(--primary);
            transform: scale(1.1);
        }
        
        .sidebar-nav .nav-link.active {
            background: linear-gradient(135deg, var(--sidebar-active) 0%, transparent 100%);
            color: var(--primary);
            font-weight: 600;
            border: 1px solid var(--glass-border);
            box-shadow: 0 4px 20px rgba(219, 39, 119, 0.08);
        }
        
        .sidebar-nav .nav-link.active i, .sidebar-nav .nav-link.active svg {
            color: var(--primary);
        }
        
        .nav-badge {
            margin-left: auto;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            font-size: 0.7rem;
            font-family: 'Fira Code', monospace;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 50px;
            box-shadow: 0 2px 8px rgba(219, 39, 119, 0.3);
        }
        
        /* Main Content */
        .admin-main {
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: auto !important;
            max-width: 100%;
            min-width: 0;
            background: transparent;
        }
        
        /* Top Navbar - Glassmorphism */
        .admin-topbar {
            background: #FFFFFF;
            
            -webkit-
            padding: 0 32px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            
            border-bottom: 1px solid var(--glass-border);
            position: sticky;
            top: 0;
            z-index: 1030;
            flex-shrink: 0;
        }
        
        .topbar-welcome {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .welcome-text {
            font-size: 0.95rem;
            font-weight: 500;
            color: var(--text-main);
        }
        
        .welcome-name {
            font-weight: 700;
            color: var(--primary);
        }
        
        .admin-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            padding: 8px 18px;
            border-radius: 50px;
            color: white;
            font-size: 0.8rem;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(219, 39, 119, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: var(--transition-smooth);
        }

        .admin-badge:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(219, 39, 119, 0.3);
        }
        
        .admin-badge i, .admin-badge svg {
            width: 14px;
            height: 14px;
            color: white;
        }
        
        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .admin-content {
            padding: 32px;
            flex-grow: 1;
            overflow-x: auto !important;
            width: 100%;
            min-width: 0;
            animation: fadeIn 0.4s ease;
        }
        
        /* Mobile Sidebar Toggle */
        .sidebar-toggle {
            display: none;
            background: #FFFFFF;
            border: 1px solid var(--glass-border);
            cursor: pointer;
            padding: 8px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(219, 39, 119, 0.05);
            transition: var(--transition-smooth);
            backdrop-filter: blur(8px);
        }
        
        .sidebar-toggle:hover {
            background: white;
            transform: scale(1.05);
        }
        
        .sidebar-toggle i, .sidebar-toggle svg {
            width: 20px;
            height: 20px;
            color: var(--primary);
        }
        
        /* Premium Pagination styling */
        .pagination {
            justify-content: center;
            margin-top: 24px;
            gap: 8px;
        }
        
        .page-link {
            color: var(--text-main);
            border: 1px solid var(--glass-border) !important;
            padding: 10px 16px;
            margin: 0;
            border-radius: 12px !important;
            transition: var(--transition-smooth);
            font-weight: 500;
            font-size: 0.85rem;
            background: #FFFFFF;
            backdrop-filter: blur(8px);
        }
        
        .page-link:hover {
            background: var(--primary-light) !important;
            border-color: var(--primary-light) !important;
            color: white !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(244, 114, 182, 0.3);
        }
        
        .page-item.active .page-link {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%) !important;
            border-color: transparent !important;
            color: white !important;
            box-shadow: 0 4px 15px rgba(219, 39, 119, 0.2);
            font-weight: 600;
        }
        
        .admin-wrapper {
            display: flex;
            max-width: 100%;
            min-width: 0;
        }
        
        .table-responsive-custom {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch;
            width: 100%;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .admin-sidebar {
                position: fixed;
                left: -280px;
                top: 0;
                transition: left 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            }
            
            .admin-sidebar.mobile-open {
                left: 0;
            }
            
            .sidebar-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            .admin-content {
                padding: 16px 20px;
            }
        }
        
        @media (max-width: 576px) {
            .admin-content {
                padding: 12px 16px;
            }
            
            .topbar-welcome .welcome-text {
                display: none;
            }
        }
        
        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--primary-light);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary);
        }
        
        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    
                /* Topbar Redesign */
        .topbar-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .topbar-search {
            position: relative;
            align-items: center;
            background: rgba(255, 255, 255, 0.5);
            border: 1px solid var(--glass-border);
            border-radius: 50px;
            padding: 6px 16px;
            width: 320px;
            transition: var(--transition-smooth);
        }
        
        .topbar-search:focus-within {
            background: #fff;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(219, 39, 119, 0.1);
        }
        
        .topbar-search i {
            width: 16px;
            height: 16px;
            color: #6b7280;
            position: absolute;
            left: 16px;
        }
        
        .topbar-search input {
            border: none;
            background: transparent;
            width: 100%;
            padding: 4px 4px 4px 28px;
            font-size: 0.85rem;
            color: var(--text-main);
            outline: none;
        }
        
        .search-shortcut {
            font-size: 0.65rem;
            color: #9ca3af;
            background: rgba(0,0,0,0.05);
            padding: 2px 6px;
            border-radius: 4px;
            font-family: 'Fira Code', monospace;
            position: absolute;
            right: 12px;
        }
        
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .topbar-btn {
            background: transparent;
            border: 1px solid transparent;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6b7280;
            cursor: pointer;
            transition: var(--transition-smooth);
            text-decoration: none;
        }
        
        .topbar-btn:hover {
            background: rgba(219, 39, 119, 0.08);
            color: var(--primary);
        }
        
        .topbar-btn i, .topbar-btn svg {
            width: 18px;
            height: 18px;
        }
        
        .topbar-divider {
            width: 1px;
            height: 24px;
            background: var(--glass-border);
        }
        
        .profile-trigger {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            padding: 4px 8px 4px 4px;
            border-radius: 50px;
            transition: var(--transition-smooth);
            border: 1px solid transparent;
        }
        
        .profile-trigger:hover, .profile-trigger[aria-expanded="true"] {
            background: rgba(255, 255, 255, 0.5);
            border-color: var(--glass-border);
        }
        
        .profile-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
            box-shadow: 0 4px 10px rgba(219, 39, 119, 0.2);
        }
        
        .profile-info {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .profile-name {
            font-weight: 700;
            font-size: 0.85rem;
            color: var(--text-main);
            line-height: 1.2;
        }
        
        .profile-role {
            font-size: 0.7rem;
            color: #6b7280;
        }
        
        .profile-dropdown {
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            padding: 8px;
            min-width: 220px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            margin-top: 8px;
        }
        
        .profile-dropdown .dropdown-header {
            padding: 12px 16px;
        }
        
        .profile-dropdown .dropdown-header h6 {
            margin: 0;
            font-weight: 700;
            color: var(--text-main);
        }
        
        .profile-dropdown .dropdown-header span {
            font-size: 0.75rem;
            color: #6b7280;
        }
        
        .profile-dropdown .dropdown-item {
            border-radius: 10px;
            padding: 8px 16px;
            font-size: 0.85rem;
            font-weight: 500;
            color: #4b5563;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: var(--transition-smooth);
        }
        
        .profile-dropdown .dropdown-item i, .profile-dropdown .dropdown-item svg {
            width: 16px;
            height: 16px;
            color: #9ca3af;
        }
        
        .profile-dropdown .dropdown-item:hover {
            background: rgba(219, 39, 119, 0.08);
            color: var(--primary);
        }
        
        .profile-dropdown .dropdown-item:hover i, .profile-dropdown .dropdown-item:hover svg {
            color: var(--primary);
        }
        
        .profile-dropdown .dropdown-item.text-danger:hover {
            background: rgba(220, 38, 38, 0.08);
            color: #dc2626 !important;
        }
        
        .profile-dropdown .dropdown-item.text-danger:hover i, .profile-dropdown .dropdown-item.text-danger:hover svg {
            color: #dc2626;
        }

        /* Bootstrap Overrides for Liquid Glass */
        .card {
            background: #FFFFFF;
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        
        .card-header {
            background: #F9FAFB;
            border-bottom: 1px solid var(--glass-border);
            padding: 1rem 1.5rem;
            font-weight: 600;
        }
        
        .form-control, .form-select {
            background: #FFFFFF !important;
            border: 1.5px solid #D1D5DB !important;
            border-radius: 12px;
            padding: 0.6rem 1rem;
            color: var(--text-main);
            transition: var(--transition-smooth);
        }
        
        .form-control:focus, .form-select:focus {
            background: #fff !important;
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 4px rgba(219, 39, 119, 0.15) !important;
            outline: none !important;
        }

        .form-control::placeholder, .form-select option[value=""] {
            color: #9CA3AF;
        }

        .input-group .input-group-text {
            border: 1.5px solid #D1D5DB !important;
            background: #F9FAFB !important;
        }
        .input-group .form-control {
            border-left: none !important;
        }
        .input-group:focus-within .input-group-text {
            border-color: var(--primary) !important;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-light)) !important;
            border: none !important;
            border-radius: 12px !important;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            color: #FFFFFF !important;
            box-shadow: 0 4px 15px rgba(219, 39, 119, 0.3);
            transition: var(--transition-smooth);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(219, 39, 119, 0.4);
            background: linear-gradient(135deg, var(--primary), #be185d) !important;
            color: #FFFFFF !important;
        }
        
        .btn-secondary {
            background: var(--glass-bg) !important;
            color: var(--text-main) !important;
            border: 1px solid var(--glass-border) !important;
            border-radius: 12px !important;
            font-weight: 600;
            transition: var(--transition-smooth);
        }
        
        .btn-secondary:hover {
            background: white !important;
            border-color: #d1d5db !important;
            transform: translateY(-2px);
        }
        
        .form-label {
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 0.5rem;
        }
        
        h1, h2, h3, h4, h5, h6 {
            color: var(--text-main);
            font-weight: 700;
        }

        /* ===== GLOBAL BUTTON FIXES ===== */
        /* Pastikan semua btn-sm dan btn-group selalu visible */
        .btn { 
            position: relative; 
            z-index: 1;
        }
        .btn-sm {
            font-size: 0.8rem;
            padding: 0.4rem 0.85rem;
            font-weight: 600;
            border-radius: 10px !important;
        }
        .btn-info {
            background: linear-gradient(135deg, #0891b2, #06b6d4) !important;
            border: none !important;
            color: #fff !important;
            box-shadow: 0 3px 10px rgba(8,145,178,0.25);
            font-weight: 600;
        }
        .btn-info:hover {
            background: linear-gradient(135deg, #0e7490, #0891b2) !important;
            color: #fff !important;
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(8,145,178,0.3);
        }
        .btn-warning {
            background: linear-gradient(135deg, #d97706, #f59e0b) !important;
            border: none !important;
            color: #fff !important;
            box-shadow: 0 3px 10px rgba(217,119,6,0.25);
            font-weight: 600;
        }
        .btn-warning:hover {
            background: linear-gradient(135deg, #b45309, #d97706) !important;
            color: #fff !important;
            transform: translateY(-1px);
        }
        .btn-danger {
            background: linear-gradient(135deg, #dc2626, #ef4444) !important;
            border: none !important;
            color: #fff !important;
            box-shadow: 0 3px 10px rgba(220,38,38,0.25);
            font-weight: 600;
        }
        .btn-danger:hover {
            background: linear-gradient(135deg, #b91c1c, #dc2626) !important;
            color: #fff !important;
            transform: translateY(-1px);
        }
        .btn-success {
            background: linear-gradient(135deg, #16a34a, #22c55e) !important;
            border: none !important;
            color: #fff !important;
            box-shadow: 0 3px 10px rgba(22,163,74,0.25);
            font-weight: 600;
        }
        .btn-success:hover {
            background: linear-gradient(135deg, #15803d, #16a34a) !important;
            color: #fff !important;
            transform: translateY(-1px);
        }
        .btn-outline-secondary {
            background: #fff !important;
            border: 1.5px solid #D1D5DB !important;
            color: var(--text-main) !important;
            border-radius: 10px !important;
            font-weight: 600;
        }
        .btn-outline-secondary:hover {
            background: #F3F4F6 !important;
            border-color: #9CA3AF !important;
        }

        /* btn-group children harus solid */
        .btn-group .btn { border-radius: 10px !important; }
        .btn-group .btn + .btn { margin-left: 4px; }

        /* Input-group override */
        .input-group .form-control {
            border-left: none !important;
        }
        .input-group .input-group-text {
            border: 1.5px solid #D1D5DB !important;
            background: #F9FAFB !important;
            border-radius: 12px 0 0 12px !important;
        }
        .input-group .form-control:first-child {
            border-left: 1.5px solid #D1D5DB !important;
            border-radius: 12px 0 0 12px !important;
        }
        .input-group .form-control:last-child {
            border-radius: 0 12px 12px 0 !important;
        }
        .input-group:focus-within .input-group-text,
        .input-group:focus-within .form-control {
            border-color: var(--primary) !important;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <div class="admin-sidebar" id="adminSidebar">
            <div class="sidebar-header">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
                    <img src="{{ asset('images/aciaa_logo.png') }}" alt="Aciaa Logo" style="width: 32px; height: 32px; object-fit: contain;">
                    <span>Aciaa Store</span>
                </a>
                <div class="sidebar-subtitle">Admin Panel</div>
            </div>
            
            <div class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i data-lucide="layout-dashboard"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i data-lucide="package"></i>
                    <span>Manajemen Produk</span>
                </a>
                
                <a href="{{ route('admin.stocks.index') }}" class="nav-link {{ request()->routeIs('admin.stocks.*') ? 'active' : '' }}">
                    <i data-lucide="database"></i>
                    <span>Kelola Stok</span>
                    @php
                        $lowStockCount = App\Models\Product::where('stock', '<=', 15)->count();
                    @endphp
                    @if($lowStockCount > 0)
                        <span class="nav-badge">{{ $lowStockCount }}</span>
                    @endif
                </a>
                
                <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i data-lucide="tags"></i>
                    <span>Kelola Kategori</span>
                </a>
                
                <a href="{{ route('admin.banners.index') }}" class="nav-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
                    <i data-lucide="image"></i>
                    <span>Kelola Banner</span>
                </a>
                
                <a href="{{ route('admin.vouchers.index') }}" class="nav-link {{ request()->routeIs('admin.vouchers.*') ? 'active' : '' }}">
                    <i data-lucide="ticket"></i>
                    <span>Voucher</span>
                </a>
                
                <a href="{{ route('admin.transactions.index') }}" class="nav-link {{ request()->routeIs('admin.transactions.*') ? 'active' : '' }}">
                    <i data-lucide="shopping-cart"></i>
                    <span>Kelola Transaksi</span>
                </a>
                
                <a href="{{ route('admin.returs.index') }}" class="nav-link {{ request()->routeIs('admin.returs.*') ? 'active' : '' }}">
                    <i data-lucide="rotate-ccw"></i>
                    <span>Retur</span>
                </a>

                <a href="{{ route('admin.ratings.index') }}" class="nav-link {{ request()->routeIs('admin.ratings.*') ? 'active' : '' }}">
                    <i data-lucide="star"></i>
                    <span>Kelola Ulasan</span>
                    @php
                        $pendingApproveCount = App\Models\Rating::where('is_approved', false)->count();
                    @endphp
                    @if($pendingApproveCount > 0)
                        <span class="nav-badge" style="background: #eab308; box-shadow: 0 2px 8px rgba(234, 179, 8, 0.4);">{{ $pendingApproveCount }}</span>
                    @endif
                </a>
                
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i data-lucide="users"></i>
                    <span>Kelola Pengguna</span>
                </a>
                
                <a href="{{ route('admin.reports.index') }}" class="nav-link">
                    <i data-lucide="bar-chart-2"></i>
                    <span>Laporan Penjualan</span>
                </a>
            </div>
            
            <div class="sidebar-divider" style="margin-top: auto; margin-bottom: 8px;"></div>
            <div class="sidebar-nav" style="flex-grow: 0;">
                <a class="nav-link text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i data-lucide="log-out"></i>
                    <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="admin-main">
                        <!-- Top Navbar -->
            <nav class="admin-topbar">
                <div class="topbar-left">
                    <button class="sidebar-toggle" id="sidebarToggle">
                        <i data-lucide="menu"></i>
                    </button>
                </div>
                
                <div class="topbar-right">
                    <a href="{{ route('home') }}" target="_blank" class="topbar-btn" title="Kunjungi Toko">
                        <i data-lucide="external-link"></i>
                    </a>
                    
                    <a href="{{ route('notifications.index') }}" class="topbar-btn position-relative" title="Notifikasi">
                        <i data-lucide="bell"></i>
                        @php
                            $unreadCount = App\Models\Notification::where('user_id', Auth::id())->where('is_read', false)->count();
                        @endphp
                        @if($unreadCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle" style="margin-top: 10px; margin-left: -5px;">
                            <span class="visually-hidden">New alerts</span>
                        </span>
                        @endif
                    </a>
                    
                    <div class="topbar-divider"></div>
                    
                    <div class="topbar-profile dropdown">
                        <div class="profile-trigger" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="profile-avatar">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="profile-info d-none d-sm-flex">
                                <div class="profile-name">{{ Auth::user()->name }}</div>
                                <div class="profile-role">Administrator</div>
                            </div>
                            <i data-lucide="chevron-down" class="ms-2 text-muted" style="width: 14px; height: 14px;"></i>
                        </div>
                        <ul class="dropdown-menu dropdown-menu-end profile-dropdown">
                            <li class="dropdown-header">
                                <h6>{{ Auth::user()->name }}</h6>
                                <span>{{ Auth::user()->email }}</span>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i data-lucide="user"></i> Profil Saya
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-topbar').submit();">
                                    <i data-lucide="log-out"></i> Logout
                                </a>
                                <form id="logout-form-topbar" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <div class="admin-content">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Overlay for mobile -->
    <div id="sidebarOverlay" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1040;" onclick="closeSidebar()"></div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Lucide JS -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <script>
        // Initialize Lucide icons
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
            
            // Sidebar toggle for mobile
            const sidebar = document.getElementById('adminSidebar');
            const toggleBtn = document.getElementById('sidebarToggle');
            const overlay = document.getElementById('sidebarOverlay');
            
            function openSidebar() {
                sidebar.classList.add('mobile-open');
                overlay.style.display = 'block';
                document.body.style.overflow = 'hidden';
            }
            
            function closeSidebar() {
                sidebar.classList.remove('mobile-open');
                overlay.style.display = 'none';
                document.body.style.overflow = '';
            }
            
            if (toggleBtn) {
                toggleBtn.addEventListener('click', openSidebar);
            }
            
            // Close sidebar when clicking on overlay
            if (overlay) {
                overlay.addEventListener('click', closeSidebar);
            }
            
            // Close sidebar on window resize if screen becomes larger
            window.addEventListener('resize', function() {
                if (window.innerWidth > 992) {
                    closeSidebar();
                }
            });
            
            // Add active class to current nav link
            const currentPath = window.location.pathname;
            document.querySelectorAll('.sidebar-nav .nav-link').forEach(link => {
                const href = link.getAttribute('href');
                if (href && href !== '#' && currentPath.includes(href)) {
                    link.classList.add('active');
                }
            });
        });
        
        // Re-initialize Lucide after any dynamic content updates
        document.addEventListener('alpine:init', function() {
            setTimeout(function() {
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            }, 100);
        });
    </script>
    
    @stack('scripts')
</body>
</html>