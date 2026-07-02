@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="admin-dashboard">
    <div class="dashboard-header">
        <div class="dashboard-title-section">
            <h1 class="dashboard-title">Dashboard</h1>
            <p class="dashboard-subtitle">Welcome back, {{ Auth::user()->name }} 👋</p>
        </div>
        <div class="dashboard-date">
            <i data-lucide="calendar"></i>
            <span>{{ date('l, d F Y') }}</span>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-label">Total Revenue</div>
                    <div class="stat-value" style="font-size: 20px;">Rp {{ number_format($total_revenue, 0, ',', '.') }}</div>
                </div>
                <div class="stat-icon stat-icon-green">
                    <i data-lucide="wallet"></i>
                </div>
            </div>
            <span class="stat-badge sb-green">Paid & Delivered</span>
        </div>
        
        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-label">Total Transactions</div>
                    <div class="stat-value">{{ number_format($total_transactions) }}</div>
                </div>
                <div class="stat-icon stat-icon-blue">
                    <i data-lucide="shopping-cart"></i>
                </div>
            </div>
            <span class="stat-badge sb-blue">All orders</span>
        </div>
        
        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-label">Total Customers</div>
                    <div class="stat-value">{{ number_format($total_users) }}</div>
                </div>
                <div class="stat-icon stat-icon-amber">
                    <i data-lucide="users"></i>
                </div>
            </div>
            <span class="stat-badge sb-amber">Registered users</span>
        </div>
        
        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-label">Total Products</div>
                    <div class="stat-value">{{ number_format($total_products) }}</div>
                </div>
                <div class="stat-icon stat-icon-red">
                    <i data-lucide="package"></i>
                </div>
            </div>
            <span class="stat-badge sb-red">Active items</span>
        </div>
    </div>

    <!-- Status Pesanan Row -->
    <div class="status-section">
        <div class="section-header">
            <h2 class="section-title">Order Status Overview</h2>
            <div class="section-divider"></div>
        </div>
        <div class="status-grid">
            <div class="status-item status-pending">
                <div class="status-icon">
                    <i data-lucide="clock"></i>
                </div>
                <div class="status-info">
                    <h4 class="status-value">{{ $pending_transactions }}</h4>
                    <p class="status-label">Pending</p>
                </div>
            </div>
            <div class="status-item status-processing">
                <div class="status-icon">
                    <i data-lucide="loader-2"></i>
                </div>
                <div class="status-info">
                    <h4 class="status-value">{{ $processing_transactions }}</h4>
                    <p class="status-label">Processing</p>
                </div>
            </div>
            <div class="status-item status-shipped">
                <div class="status-icon">
                    <i data-lucide="truck"></i>
                </div>
                <div class="status-info">
                    <h4 class="status-value">{{ $shipped_transactions }}</h4>
                    <p class="status-label">Shipped</p>
                </div>
            </div>
            <div class="status-item status-delivered">
                <div class="status-icon">
                    <i data-lucide="check-circle"></i>
                </div>
                <div class="status-info">
                    <h4 class="status-value">{{ $delivered_transactions }}</h4>
                    <p class="status-label">Delivered</p>
                </div>
            </div>
            <div class="status-item status-cancelled">
                <div class="status-icon">
                    <i data-lucide="x-circle"></i>
                </div>
                <div class="status-info">
                    <h4 class="status-value">{{ $cancelled_transactions }}</h4>
                    <p class="status-label">Cancelled</p>
                </div>
            </div>
            <div class="status-item status-retur">
                <div class="status-icon">
                    <i data-lucide="rotate-ccw"></i>
                </div>
                <div class="status-info">
                    <h4 class="status-value">{{ $pending_returs }}</h4>
                    <p class="status-label">Return Pending</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Batang & Tren Pendapatan -->
    <div class="chart-section-grid">
        <!-- Grafik Produk Terlaris -->
        <div class="data-card">
            <div class="card-header-chart">
                <div class="chart-header-left">
                    <i data-lucide="bar-chart-3"></i>
                    <h3>Produk Terlaris (10 Besar)</h3>
                </div>
                <span class="chart-badge bg-white-20 text-white">Jumlah Terjual</span>
            </div>
            <div class="card-body p-4 bg-white rounded-bottom-4">
                @if($top_sold_products->count() > 0)
                    <div class="chart-container" style="position: relative; height: 320px; width: 100%;">
                        <canvas id="productsChart"></canvas>
                    </div>
                @else
                    <div class="empty-state py-5 text-center text-muted">
                        <i data-lucide="shopping-bag" style="width: 48px; height: 48px; stroke-width: 1.5;" class="mb-3 text-muted"></i>
                        <p class="mb-0">Belum ada data produk terjual</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Grafik Tren Pendapatan Bulanan -->
        <div class="data-card">
            <div class="card-header-chart" style="background: linear-gradient(135deg, #16213e, #1a1a2e);">
                <div class="chart-header-left">
                    <i data-lucide="trending-up"></i>
                    <h3>Tren Pendapatan Bulanan</h3>
                </div>
                <span class="chart-badge bg-white-20 text-white">6 Bulan Terakhir</span>
            </div>
            <div class="card-body p-4 bg-white rounded-bottom-4">
                @if($monthly_revenue->count() > 0)
                    <div class="chart-container" style="position: relative; height: 320px; width: 100%;">
                        <canvas id="revenueChart"></canvas>
                    </div>
                @else
                    <div class="empty-state py-5 text-center text-muted">
                        <i data-lucide="dollar-sign" style="width: 48px; height: 48px; stroke-width: 1.5;" class="mb-3 text-muted"></i>
                        <p class="mb-0">Belum ada data pendapatan bulanan</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Transaksi & Produk Terbaru -->
    <div class="two-columns">
        <div class="column">
            <div class="data-card">
                <div class="card-header-primary">
                    <i data-lucide="receipt"></i>
                    <h3>Recent Transactions</h3>
                </div>
                <div class="card-body">
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Invoice</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_transactions as $transaction)
                                <tr>
                                    <td class="invoice-number">#{{ $transaction->invoice_number }}</td>
                                    <td>{{ $transaction->user->name ?? '-' }}</td>
                                    <td class="price">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="status-badge status-{{ $transaction->status }}">
                                            {{ ucfirst($transaction->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="empty-state">
                                        <i data-lucide="inbox"></i>
                                        <p>No transactions yet</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="column">
            <div class="data-card">
                <div class="card-header-success">
                    <i data-lucide="package"></i>
                    <h3>Recent Products</h3>
                </div>
                <div class="card-body">
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_products as $product)
                                <tr>
                                    <td class="product-name">{{ Str::limit($product->name, 30) }}</td>
                                    <td class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td>
                                        @if($product->stock == 0)
                                            <span class="stock-badge out-of-stock">
                                                <i data-lucide="alert-circle"></i> Out of Stock
                                            </span>
                                        @elseif($product->stock < 10)
                                            <span class="stock-badge low-stock">
                                                <i data-lucide="alert-triangle"></i> {{ $product->stock }} left
                                            </span>
                                        @else
                                            <span class="stock-badge in-stock">
                                                <i data-lucide="check-circle"></i> {{ $product->stock }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="empty-state">
                                        <i data-lucide="box"></i>
                                        <p>No products yet</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Customer -->
    <div class="top-customers-section">
        <div class="data-card full-width">
            <div class="card-header-dark">
                <i data-lucide="trophy"></i>
                <h3>Top 5 Active Customers</h3>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th class="rank-column">Rank</th>
                                <th>Customer Name</th>
                                <th>Email</th>
                                <th class="total-column">Total Spending</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($top_customers as $index => $customer)
                            <tr class="customer-row">
                                <td class="rank">
                                    <div class="rank-badge rank-{{ $index + 1 }}">
                                        {{ $index + 1 }}
                                    </div>
                                </td>
                                <td class="customer-name">
                                    <i data-lucide="user-circle"></i>
                                    {{ $customer->name }}
                                </td>
                                <td>{{ $customer->email }}</td>
                                <td class="total-spending">Rp {{ number_format($customer->transactions_sum_grand_total ?? 0, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="empty-state">
                                    <i data-lucide="users"></i>
                                    <p>No active customers yet</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Admin Dashboard Styles */
.admin-dashboard {
    padding: 24px 32px;
    background: #f8f9fc;
    min-height: 100vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
}

/* Dashboard Header */
.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 32px;
    flex-wrap: wrap;
    gap: 16px;
}

.dashboard-title-section {
    flex: 1;
}

.dashboard-title {
    font-size: 28px;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0 0 4px 0;
    letter-spacing: -0.5px;
}

.dashboard-subtitle {
    font-size: 14px;
    color: #666;
    margin: 0;
}

.dashboard-date {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    background: white;
    border-radius: 50px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    font-size: 14px;
    color: #666;
}

.dashboard-date i {
    width: 18px;
    height: 18px;
}/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
    margin-bottom: 32px;
}

@media(max-width: 992px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media(max-width: 576px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
}

.stat-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 1.1rem 1.25rem;
    box-shadow: none;
    transition: all 0.2s ease;
    position: relative;
    overflow: hidden;
}

.stat-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,.05);
    transform: translateY(-2px);
}

.stat-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 10px;
}

.stat-icon {
    width: 36px;
    height: 36px;
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.stat-icon i {
    width: 18px;
    height: 18px;
}

.stat-icon-blue  { background: #eff6ff; color: #2563eb; }
.stat-icon-green { background: #f0fdf4; color: #16a34a; }
.stat-icon-amber { background: #fffbeb; color: #d97706; }
.stat-icon-red   { background: #fef2f2; color: #dc2626; }

.stat-label {
    font-size: 11px;
    color: #6b7280;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: .04em;
    margin-bottom: 4px;
}

.stat-value {
    font-size: 22px;
    font-weight: 700;
    color: #111827;
    line-height: 1.1;
    margin-bottom: 6px;
}

.stat-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 11px;
    font-weight: 500;
    padding: 3px 8px;
    border-radius: 99px;
}

.sb-green { background: #dcfce7; color: #166534; }
.sb-amber { background: #fef3c7; color: #92400e; }
.sb-red   { background: #fee2e2; color: #991b1b; }
.sb-blue  { background: #dbeafe; color: #1e40af; }

/* Status Section */
.status-section {
    background: white;
    border-radius: 20px;
    padding: 24px;
    margin-bottom: 32px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.section-header {
    margin-bottom: 20px;
}

.section-title {
    font-size: 18px;
    font-weight: 600;
    color: #1a1a1a;
    margin: 0 0 8px 0;
}

.section-divider {
    width: 50px;
    height: 3px;
    background: linear-gradient(90deg, #d4a5a5, #b5838d);
    border-radius: 3px;
}

.status-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 16px;
}

.status-item {
    background: #f8f9fc;
    border-radius: 16px;
    padding: 20px;
    text-align: center;
    transition: all 0.3s ease;
}

.status-item:hover {
    transform: translateY(-2px);
    background: #fef6f5;
}

.status-icon {
    width: 48px;
    height: 48px;
    margin: 0 auto 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
}

.status-icon i {
    width: 24px;
    height: 24px;
}

.status-pending .status-icon {
    background: #fef3c7;
}
.status-pending .status-icon i {
    color: #d97706;
}

.status-processing .status-icon {
    background: #dbeafe;
}
.status-processing .status-icon i {
    color: #2563eb;
}

.status-shipped .status-icon {
    background: #e0f2fe;
}
.status-shipped .status-icon i {
    color: #0284c7;
}

.status-delivered .status-icon {
    background: #d1fae5;
}
.status-delivered .status-icon i {
    color: #059669;
}

.status-cancelled .status-icon {
    background: #fee2e2;
}
.status-cancelled .status-icon i {
    color: #dc2626;
}

.status-retur .status-icon {
    background: #fef3c7;
}
.status-retur .status-icon i {
    color: #d97706;
}

.status-value {
    font-size: 28px;
    font-weight: 700;
    margin: 0 0 4px 0;
    color: #1a1a1a;
}

.status-label {
    font-size: 12px;
    color: #666;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Two Columns Grid */
.two-columns {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
    margin-bottom: 32px;
}

@media (max-width: 992px) {
    .two-columns {
        grid-template-columns: 1fr;
        gap: 24px;
    }
}

/* Data Cards */
.data-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.card-header-primary, .card-header-success, .card-header-dark {
    padding: 16px 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.card-header-primary i, .card-header-success i, .card-header-dark i {
    width: 20px;
    height: 20px;
    color: white;
}

.card-header-primary h3, .card-header-success h3, .card-header-dark h3 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
    color: white;
}

.card-header-primary {
    background: linear-gradient(135deg, #4f46e5, #6366f1);
}

.card-header-success {
    background: linear-gradient(135deg, #10b981, #059669);
}

.card-header-dark {
    background: linear-gradient(135deg, #1f2937, #374151);
}

.card-body {
    padding: 0;
}

/* Data Table */
.table-container {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table thead {
    background: #f8f9fc;
}

.data-table th {
    padding: 14px 16px;
    text-align: left;
    font-size: 12px;
    font-weight: 600;
    color: #666;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 1px solid #e5e7eb;
}

.data-table td {
    padding: 14px 16px;
    font-size: 14px;
    color: #4b5563;
    border-bottom: 1px solid #f0f0f0;
}

.data-table tbody tr:hover {
    background: #fef6f5;
}

/* Status Badges */
.status-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 600;
    text-transform: capitalize;
}

.status-pending-badge {
    background: #fef3c7;
    color: #d97706;
}

.status-processing {
    background: #dbeafe;
    color: #2563eb;
}

.status-shipped {
    background: #e0f2fe;
    color: #0284c7;
}

.status-delivered {
    background: #d1fae5;
    color: #059669;
}

.status-cancelled {
    background: #fee2e2;
    color: #dc2626;
}

/* Stock Badges */
.stock-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 10px;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 500;
}

.stock-badge i {
    width: 14px;
    height: 14px;
}

.in-stock {
    background: #d1fae5;
    color: #059669;
}

.low-stock {
    background: #fef3c7;
    color: #d97706;
}

.out-of-stock {
    background: #fee2e2;
    color: #dc2626;
}

/* Top Customers */
.full-width {
    width: 100%;
}

.top-customers-section {
    margin-bottom: 32px;
}

.rank-column, .total-column {
    text-align: center;
}

.rank {
    text-align: center;
}

.rank-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    font-weight: 700;
    font-size: 14px;
}

.rank-1 {
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    color: white;
}

.rank-2 {
    background: linear-gradient(135deg, #9ca3af, #6b7280);
    color: white;
}

.rank-3 {
    background: linear-gradient(135deg, #cd7f32, #b87333);
    color: white;
}

.rank-4, .rank-5 {
    background: #e5e7eb;
    color: #4b5563;
}

.customer-name {
    display: flex;
    align-items: center;
    gap: 8px;
}

.customer-name i {
    width: 18px;
    height: 18px;
    color: #d4a5a5;
}

.total-spending {
    font-weight: 600;
    color: #10b981;
}

.price {
    font-weight: 500;
    color: #1a1a1a;
}

.invoice-number {
    font-family: monospace;
    font-weight: 600;
    color: #4f46e5;
}

.product-name {
    font-weight: 500;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 48px !important;
}

.empty-state i {
    width: 48px;
    height: 48px;
    color: #d1d5db;
    margin-bottom: 12px;
}

.empty-state p {
    color: #9ca3af;
    font-size: 14px;
    margin: 0;
}

/* Responsive */
@media (max-width: 768px) {
    .admin-dashboard {
        padding: 16px 20px;
    }
    
    .stats-grid {
        gap: 16px;
    }
    
    .dashboard-title {
        font-size: 22px;
    }
    
    .stat-card {
        padding: 16px;
    }
    
    .stat-value {
        font-size: 20px;
    }
    
    .stat-icon-wrapper {
        width: 44px;
        height: 44px;
    }
    
    .stat-icon-wrapper i {
        width: 22px;
        height: 22px;
    }
    
    .status-grid {
        grid-template-columns: repeat(3, 1fr);
    }
    
    .data-table th, .data-table td {
        padding: 10px 12px;
    }
}

@media (max-width: 480px) {
    .status-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .dashboard-header {
        flex-direction: column;
        align-items: flex-start;
    }
}

/* Chart Section */
.chart-section-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
    margin-bottom: 32px;
}

@media (max-width: 992px) {
    .chart-section-grid {
        grid-template-columns: 1fr;
    }
}

.card-header-chart {
    padding: 16px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: linear-gradient(135deg, #d4a5a5, #b5838d);
    border-radius: 20px 20px 0 0;
}

.chart-header-left {
    display: flex;
    align-items: center;
    gap: 10px;
}

.chart-header-left i {
    width: 20px;
    height: 20px;
    color: white;
}

.chart-header-left h3 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
    color: white;
}

.chart-badge {
    background: rgba(255,255,255,0.25);
    color: white;
    padding: 4px 12px;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 600;
    backdrop-filter: blur(4px);
}
</style>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // Chart 1: Produk Terlaris
    @if($top_sold_products->count() > 0)
    const ctxProducts = document.getElementById('productsChart').getContext('2d');
    const productsData = @json($top_sold_products);
    
    const productLabels = productsData.map(item => {
        return item.product_name.length > 20 ? item.product_name.substring(0, 18) + '...' : item.product_name;
    });
    const productQty = productsData.map(item => item.total_sold);
    
    new Chart(ctxProducts, {
        type: 'bar',
        data: {
            labels: productLabels,
            datasets: [{
                label: 'Jumlah Terjual',
                data: productQty,
                backgroundColor: 'rgba(212, 165, 165, 0.85)',
                borderColor: 'rgba(181, 131, 141, 1)',
                borderWidth: 1.5,
                borderRadius: 6,
                hoverBackgroundColor: 'rgba(181, 131, 141, 1)'
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        title: function(context) {
                            return productsData[context[0].dataIndex].product_name;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        font: {
                            family: 'Inter',
                            size: 11
                        },
                        stepSize: 1
                    }
                },
                y: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            family: 'Inter',
                            size: 11
                        }
                    }
                }
            }
        }
    });
    @endif

    // Chart 2: Tren Pendapatan Bulanan
    @if($monthly_revenue->count() > 0)
    const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
    const rawRevenue = @json($monthly_revenue);
    const revenueData = [...rawRevenue].reverse();
    
    const monthNames = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
    
    const revenueLabels = revenueData.map(item => {
        return monthNames[item.month - 1] + ' ' + item.year;
    });
    const revenueTotals = revenueData.map(item => item.total);
    
    const gradient = ctxRevenue.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(22, 33, 94, 0.25)');
    gradient.addColorStop(1, 'rgba(22, 33, 94, 0)');
    
    new Chart(ctxRevenue, {
        type: 'line',
        data: {
            labels: revenueLabels,
            datasets: [{
                label: 'Pendapatan',
                data: revenueTotals,
                fill: true,
                backgroundColor: gradient,
                borderColor: '#16213e',
                borderWidth: 3,
                tension: 0.3,
                pointBackgroundColor: '#16213e',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(context.parsed.y);
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            family: 'Inter',
                            size: 11
                        }
                    }
                },
                y: {
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        font: {
                            family: 'Inter',
                            size: 11
                        },
                        callback: function(value) {
                            return 'Rp ' + (value >= 1e6 ? (value / 1e6) + 'jt' : (value >= 1e3 ? (value / 1e3) + 'rb' : value));
                        }
                    }
                }
            }
        }
    });
    @endif
});
</script>
@endsection