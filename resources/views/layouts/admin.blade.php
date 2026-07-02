<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel - @yield('title')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    
    <!-- Custom Admin CSS -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6fa;
            overflow-x: auto !important; /* DIUBAH: dari hidden ke auto */
        }
        
        /* Sidebar Styles with glassmorphism & gradients */
        .admin-sidebar {
            background: linear-gradient(180deg, #0f0f1b 0%, #151528 100%);
            min-height: 100vh;
            width: 280px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            box-shadow: 4px 0 25px rgba(0,0,0,0.15);
            border-right: 1px solid rgba(255, 255, 255, 0.03);
            display: flex;
            flex-direction: column;
            flex-shrink: 0; /* TAMBAHAN: biar sidebar tidak mengecil */
        }
        
        .sidebar-header {
            padding: 28px 24px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            background: rgba(0, 0, 0, 0.1);
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
        
        .sidebar-logo img {
            filter: drop-shadow(0 2px 8px rgba(212,165,165,0.3));
        }
        
        .sidebar-logo span {
            font-size: 1.3rem;
            font-weight: 800;
            background: linear-gradient(135deg, #ffffff 0%, #ebd3d3 50%, #d4a5a5 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            letter-spacing: 1px;
        }
        
        .sidebar-subtitle {
            font-size: 0.72rem;
            color: rgba(255,255,255,0.4);
            letter-spacing: 2px;
            text-transform: uppercase;
            font-weight: 700;
        }
        
        .sidebar-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.08), transparent);
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
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: 12px;
            margin-bottom: 4px;
            position: relative;
        }
        
        .sidebar-nav .nav-link i, .sidebar-nav .nav-link svg {
            width: 18px;
            height: 18px;
            transition: all 0.25s ease;
            opacity: 0.8;
        }
        
        .sidebar-nav .nav-link:hover {
            background: rgba(212, 165, 165, 0.12);
            color: #ffffff;
            padding-left: 22px;
        }
        
        .sidebar-nav .nav-link:hover i, .sidebar-nav .nav-link:hover svg {
            color: #d4a5a5;
            transform: scale(1.1);
            opacity: 1;
            filter: drop-shadow(0 0 5px rgba(212, 165, 165, 0.5));
        }
        
        .sidebar-nav .nav-link.active {
            background: linear-gradient(135deg, rgba(212, 165, 165, 0.25) 0%, rgba(181, 131, 141, 0.08) 100%);
            color: #ebd3d3;
            box-shadow: inset 0 0 10px rgba(212, 165, 165, 0.1), 0 4px 15px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #d4a5a5;
        }
        
        .sidebar-nav .nav-link.active i, .sidebar-nav .nav-link.active svg {
            color: #ebd3d3;
            opacity: 1;
        }
        
        .nav-badge {
            margin-left: auto;
            background: linear-gradient(135deg, #ff4444, #e53e3e);
            color: white;
            font-size: 0.65rem;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 50px;
            box-shadow: 0 2px 8px rgba(255, 68, 68, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        /* Main Content with soft background */
        .admin-main {
            flex: 1;
            min-height: 100vh;
            background: #f6f8fb;
            display: flex;
            flex-direction: column;
            overflow-x: auto !important; /* TAMBAHAN: biar bisa scroll horizontal */
            max-width: 100%;
            min-width: 0; /* TAMBAHAN: penting untuk flex overflow */
        }
        
        /* Top Navbar with frosted glass effect */
        .admin-topbar {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding: 0 32px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            border-bottom: 1px solid rgba(229, 231, 235, 0.5);
            position: sticky;
            top: 0;
            z-index: 100;
            flex-shrink: 0; /* TAMBAHAN */
        }
        
        .topbar-welcome {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .welcome-text {
            font-size: 0.95rem;
            font-weight: 500;
            color: #4b5563;
        }
        
        .welcome-name {
            font-weight: 700;
            color: var(--vc-pink-2, #b5838d);
        }
        
        .admin-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #151528 0%, #0f0f1b 100%);
            padding: 8px 18px;
            border-radius: 50px;
            color: white;
            font-size: 0.78rem;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(21, 21, 40, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .admin-badge i, .admin-badge svg {
            width: 14px;
            height: 14px;
            color: #d4a5a5;
        }
        
        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        /* Page Content with layout scaling - DIPERBAIKI */
        .admin-content {
            padding: 32px;
            flex-grow: 1;
            overflow-x: auto !important; /* DIPERBAIKI: dari normal ke auto */
            width: 100%;
            min-width: 0; /* TAMBAHAN: penting untuk flex overflow */
        }
        
        /* Mobile Sidebar Toggle */
        .sidebar-toggle {
            display: none;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            cursor: pointer;
            padding: 8px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: all 0.2s;
        }
        
        .sidebar-toggle:hover {
            background: #f9fafb;
            transform: scale(1.05);
        }
        
        .sidebar-toggle i, .sidebar-toggle svg {
            width: 20px;
            height: 20px;
            color: #4b5563;
        }
        
        /* Premium Pagination styling */
        .pagination {
            justify-content: center;
            margin-top: 24px;
            gap: 4px;
        }
        
        .page-link {
            color: #4b5563;
            border: 1px solid #e5e7eb !important;
            padding: 10px 16px;
            margin: 0;
            border-radius: 12px !important;
            transition: all 0.25s;
            font-weight: 600;
            font-size: 0.85rem;
            background: #ffffff;
        }
        
        .page-link:hover {
            background: #d4a5a5 !important;
            border-color: #d4a5a5 !important;
            color: white !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(212, 165, 165, 0.3);
        }
        
        .page-item.active .page-link {
            background: linear-gradient(135deg, #151528 0%, #0f0f1b 100%) !important;
            border-color: #151528 !important;
            color: white !important;
            box-shadow: 0 4px 12px rgba(21, 21, 40, 0.15);
        }
        
        /* TAMBAHAN: Wrapper untuk konten utama */
        .d-flex {
            display: flex;
            overflow-x: auto !important;
            max-width: 100%;
            min-width: 0;
        }
        
        /* TAMBAHAN: Class untuk tabel responsive */
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
                z-index: 1050;
                transition: left 0.3s ease;
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
                overflow-x: auto !important;
            }
        }
        
        @media (max-width: 576px) {
            .admin-content {
                padding: 12px 16px;
                overflow-x: auto !important;
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
            background: #e0e0e0;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #d4a5a5;
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #b5838d;
        }
        
        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .admin-content {
            animation: fadeIn 0.3s ease;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="d-flex">
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
                
                <a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <i data-lucide="chart-line"></i>
                    <span>Laporan Penjualan</span>
                </a>
            </div>
            
            <div class="sidebar-divider"></div>
            
            <div class="sidebar-nav">
                <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
                <div class="topbar-welcome">
                    <button class="sidebar-toggle" id="sidebarToggle">
                        <i data-lucide="menu"></i>
                    </button>
                    <div class="welcome-text">
                        Selamat Datang, <span class="welcome-name">{{ Auth::user()->name }}</span>
                    </div>
                </div>
                <div class="topbar-actions">
                    <div class="admin-badge">
                        <i data-lucide="shield-check"></i>
                        <span>Administrator</span>
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