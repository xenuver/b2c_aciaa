@extends('layouts.admin')

@section('title', 'Laporan Penjualan')

@section('content')
<style>
*, *::before, *::after { box-sizing: border-box; }

.pm-page { padding: 1.5rem; }
.pm-topbar {
    display: flex; align-items: flex-start;
    justify-content: space-between;
    gap: 12px; flex-wrap: wrap;
    margin-bottom: 1.75rem;
}
.pm-title { font-size: 20px; font-weight: 700; color: #111827; margin: 0 0 3px; }
.pm-subtitle { font-size: 13px; color: #6b7280; margin: 0; }

.pm-filters { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; padding: 1.25rem; background: #fff; border: 1px solid #e5e7eb; border-radius: 14px; margin-bottom: 1.5rem; }
.pm-filter-group { display: flex; flex-direction: column; gap: 4px; }
.pm-filter-label { font-size: 11px; font-weight: 600; color: #4b5563; text-transform: uppercase; }
.pm-date-input {
    padding: 6px 12px;
    font-size: 13px; color: #374151;
    border: 1px solid #e5e7eb; border-radius: 9px;
    background: #f9fafb; outline: none;
    transition: border-color .15s;
}
.pm-date-input:focus { border-color: #6ee7b7; background: #fff; }

.btn-primary-custom {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 16px; background: #2563eb; border: none;
    border-radius: 9px; font-size: 13px; font-weight: 600; color: #fff;
    cursor: pointer; text-decoration: none; transition: background .15s;
}
.btn-primary-custom:hover { background: #1d4ed8; color: #fff; }
.btn-green-custom {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 16px; background: #16a34a; border: none;
    border-radius: 9px; font-size: 13px; font-weight: 600; color: #fff;
    cursor: pointer; text-decoration: none; transition: background .15s;
}
.btn-green-custom:hover { background: #15803d; color: #fff; }

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
    margin-bottom: 1.5rem;
}
@media(max-width: 992px) {
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
}
@media(max-width: 576px) {
    .stats-grid { grid-template-columns: 1fr; }
}

.stat-card {
    background: #fff; border: 1px solid #e5e7eb;
    border-radius: 12px; padding: 1.1rem 1.25rem;
    transition: all 0.2s ease;
}
.stat-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,.05);
    transform: translateY(-2px);
}
.stat-top { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 10px; }
.stat-icon {
    width: 36px; height: 36px; border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.stat-icon i { width: 18px; height: 18px; }
.stat-icon-blue  { background: #eff6ff; color: #2563eb; }
.stat-icon-green { background: #f0fdf4; color: #16a34a; }
.stat-icon-amber { background: #fffbeb; color: #d97706; }
.stat-icon-red   { background: #fef2f2; color: #dc2626; }

.stat-label { font-size: 11px; color: #6b7280; font-weight: 500; text-transform: uppercase; letter-spacing: .04em; margin-bottom: 4px; }
.stat-val { font-size: 20px; font-weight: 700; color: #111827; line-height: 1.2; margin-bottom: 6px; }
.stat-badge {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 11px; font-weight: 500; padding: 3px 8px; border-radius: 99px;
}
.sb-green { background: #dcfce7; color: #166534; }
.sb-amber { background: #fef3c7; color: #92400e; }
.sb-red   { background: #fee2e2; color: #991b1b; }
.sb-blue  { background: #dbeafe; color: #1e40af; }

.pm-card {
    background: #fff; border: 1px solid #e5e7eb;
    border-radius: 14px; overflow: hidden;
    box-shadow: 0 1px 4px rgba(0,0,0,.05);
    margin-bottom: 1.5rem;
}
.pm-card-header {
    display: flex; align-items: center;
    justify-content: space-between;
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #f3f4f6;
    background: linear-gradient(135deg, rgba(212,165,165,0.05), rgba(254,246,245,0.2));
}
.pm-card-title { font-size: 14px; font-weight: 700; color: #111827; display: flex; align-items: center; gap: 8px; }

.pm-table { width: 100%; border-collapse: collapse; }
.pm-table thead th {
    font-size: 11px; font-weight: 700; color: #6b7280;
    text-transform: uppercase; letter-spacing: .06em;
    white-space: nowrap; padding: 10px 16px;
    background: #f9fafb; border-bottom: 1px solid #f3f4f6;
    text-align: left;
}
.pm-table tbody td {
    padding: 12px 16px; border-bottom: 1px solid #f3f4f6;
    vertical-align: middle; font-size: 13px; color: #374151;
}
.pm-table tbody tr:last-child td { border-bottom: none; }
.pm-table tbody tr:hover td { background: #fafafa; }

.badge-pill {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 11px; font-weight: 600;
    padding: 6px 12px; border-radius: 99px; white-space: nowrap;
}

.two-columns {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
}
@media(max-width: 992px) {
    .two-columns { grid-template-columns: 1fr; }
}

.prod-thumb {
    width: 32px; height: 32px; border-radius: 6px;
    object-fit: cover; border: 1px solid #e5e7eb; flex-shrink: 0;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="pm-page">
    {{-- Top bar --}}
    <div class="pm-topbar">
        <div>
            <h1 class="pm-title">Laporan Penjualan</h1>
            <p class="pm-subtitle">Analisis performa penjualan toko Anda</p>
        </div>
    </div>

    {{-- Filter Tanggal --}}
    <div class="pm-filters">
        <form method="GET" class="d-flex align-items-end gap-3 flex-wrap m-0">
            <div class="pm-filter-group">
                <span class="pm-filter-label">Dari Tanggal</span>
                <input type="date" name="start_date" class="pm-date-input" value="{{ $startDate }}">
            </div>
            
            <div class="pm-filter-group">
                <span class="pm-filter-label">Sampai Tanggal</span>
                <input type="date" name="end_date" class="pm-date-input" value="{{ $endDate }}">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn-primary-custom">
                    <i class="fas fa-chart-line me-1"></i> Tampilkan
                </button>
                <a href="{{ route('admin.reports.export', request()->query()) }}" class="btn-green-custom">
                    <i class="fas fa-file-excel me-1"></i> Export Excel (CSV)
                </a>
            </div>
        </form>
    </div>

    {{-- Summary Cards --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-label">Total Pesanan</div>
                    <div class="stat-val">{{ number_format($summary['total_orders']) }}</div>
                </div>
                <div class="stat-icon stat-icon-blue">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
            <span class="stat-badge sb-blue">Transaksi berhasil</span>
        </div>
        
        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-label">Total Pendapatan</div>
                    <div class="stat-val">Rp {{ number_format($summary['total_revenue'], 0, ',', '.') }}</div>
                </div>
                <div class="stat-icon stat-icon-green">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
            <span class="stat-badge sb-green">Pendapatan kotor</span>
        </div>
        
        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-label">Rata-rata Pesanan</div>
                    <div class="stat-val">Rp {{ number_format($summary['average_order'], 0, ',', '.') }}</div>
                </div>
                <div class="stat-icon stat-icon-amber">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
            <span class="stat-badge sb-amber">Rata-rata per keranjang</span>
        </div>
        
        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-label">Total Customer</div>
                    <div class="stat-val">{{ number_format($summary['total_customers']) }}</div>
                </div>
                <div class="stat-icon stat-icon-red">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <span class="stat-badge sb-red">Customer aktif berbelanja</span>
        </div>
    </div>

    {{-- Status Pesanan Ringkasan --}}
    <div class="pm-card">
        <div class="pm-card-header">
            <span class="pm-card-title"><i class="fas fa-tasks text-muted"></i> Ringkasan Status Pesanan</span>
        </div>
        <div class="card-body p-4 bg-white">
            <div class="row g-3 text-center">
                <div class="col-6 col-md-2.4 col-lg-2.4" style="flex: 1 1 20%;">
                    <div class="badge-pill bp-warning w-100 justify-content-center py-2" style="background:#fffbeb; color:#d97706; border:1px solid #fde68a;">
                        <h6 class="mb-0 fw-bold me-2">{{ $summary['pending_orders'] }}</h6>
                        <small>Pending</small>
                    </div>
                </div>
                <div class="col-6 col-md-2.4 col-lg-2.4" style="flex: 1 1 20%;">
                    <div class="badge-pill bp-info w-100 justify-content-center py-2" style="background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe;">
                        <h6 class="mb-0 fw-bold me-2">{{ $summary['processing_orders'] }}</h6>
                        <small>Processing</small>
                    </div>
                </div>
                <div class="col-6 col-md-2.4 col-lg-2.4" style="flex: 1 1 20%;">
                    <div class="badge-pill bp-primary w-100 justify-content-center py-2" style="background:#f0f9ff; color:#0369a1; border:1px solid #bae6fd;">
                        <h6 class="mb-0 fw-bold me-2">{{ $summary['shipped_orders'] }}</h6>
                        <small>Shipped</small>
                    </div>
                </div>
                <div class="col-6 col-md-2.4 col-lg-2.4" style="flex: 1 1 20%;">
                    <div class="badge-pill bp-success w-100 justify-content-center py-2" style="background:#f0fdf4; color:#166534; border:1px solid #bbf7d0;">
                        <h6 class="mb-0 fw-bold me-2">{{ $summary['total_orders'] }}</h6>
                        <small>Delivered</small>
                    </div>
                </div>
                <div class="col-6 col-md-2.4 col-lg-2.4" style="flex: 1 1 20%;">
                    <div class="badge-pill bp-danger w-100 justify-content-center py-2" style="background:#fef2f2; color:#991b1b; border:1px solid #fecaca;">
                        <h6 class="mb-0 fw-bold me-2">{{ $summary['cancelled_orders'] }}</h6>
                        <small>Cancelled</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart Penjualan --}}
    <div class="pm-card">
        <div class="pm-card-header">
            <span class="pm-card-title"><i class="fas fa-chart-area text-muted"></i> Grafik Performa Penjualan</span>
        </div>
        <div class="card-body p-4 bg-white" style="position: relative; height: 350px;">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    {{-- Top Produk & Top Customer --}}
    <div class="two-columns">
        {{-- Top Produk --}}
        <div class="pm-card">
            <div class="pm-card-header" style="background: linear-gradient(135deg, rgba(22,163,74,0.03), rgba(254,246,245,0.2));">
                <span class="pm-card-title text-success"><i class="fas fa-trophy"></i> 10 Produk Terlaris</span>
            </div>
            <div class="table-responsive">
                <table class="pm-table">
                    <thead>
                        <tr>
                            <th width="8%">#</th>
                            <th>Produk</th>
                            <th class="text-center">Terjual</th>
                            <th class="text-end">Total Omset</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topProducts as $index => $product)
                        <tr>
                            <td class="fw-bold text-muted">{{ $index + 1 }}</td>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" class="prod-thumb" alt="{{ $product->name }}">
                                    @else
                                        <div class="prod-thumb" style="background:#f3f4f6;display:flex;align-items:center;justify-content:center;">
                                            <i class="far fa-image text-muted" style="font-size:12px;"></i>
                                        </div>
                                    @endif
                                    <span class="fw-semibold text-dark">{{ $product->name }}</span>
                                </div>
                            </td>
                            <td class="text-center fw-bold">{{ $product->total_sold }} pcs</td>
                            <td class="text-end fw-bold text-success">Rp {{ number_format($product->total_revenue, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="empty-state text-center py-4">Belum ada data penjualan produk</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Top Customer --}}
        <div class="pm-card">
            <div class="pm-card-header" style="background: linear-gradient(135deg, rgba(37,99,235,0.03), rgba(254,246,245,0.2));">
                <span class="pm-card-title text-primary"><i class="fas fa-medal"></i> 10 Customer Teraktif</span>
            </div>
            <div class="table-responsive">
                <table class="pm-table">
                    <thead>
                        <tr>
                            <th width="8%">#</th>
                            <th>Customer</th>
                            <th class="text-center">Pesanan</th>
                            <th class="text-end">Total Belanja</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topCustomers as $index => $customer)
                        <tr>
                            <td class="fw-bold text-muted">{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $customer->user->name ?? 'User Dihapus' }}</div>
                                <div class="text-muted small">{{ $customer->user->email ?? '-' }}</div>
                            </td>
                            <td class="text-center fw-bold">{{ $customer->total_orders }}x</td>
                            <td class="text-end fw-bold text-primary">Rp {{ number_format($customer->total_spent, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="empty-state text-center py-4">Belum ada data customer aktif</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('salesChart').getContext('2d');
    
    const gradientRevenue = ctx.createLinearGradient(0, 0, 0, 300);
    gradientRevenue.addColorStop(0, 'rgba(75, 192, 192, 0.25)');
    gradientRevenue.addColorStop(1, 'rgba(75, 192, 192, 0)');
    
    const gradientOrders = ctx.createLinearGradient(0, 0, 0, 300);
    gradientOrders.addColorStop(0, 'rgba(255, 99, 132, 0.25)');
    gradientOrders.addColorStop(1, 'rgba(255, 99, 132, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($salesData['labels']) !!},
            datasets: [
                {
                    label: 'Pendapatan (Rp)',
                    data: {!! json_encode($salesData['revenue']) !!},
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: gradientRevenue,
                    tension: 0.3,
                    fill: true,
                    borderWidth: 3,
                    pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                    pointBorderColor: '#fff',
                    pointRadius: 4,
                    yAxisID: 'y'
                },
                {
                    label: 'Jumlah Pesanan',
                    data: {!! json_encode($salesData['orders']) !!},
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: gradientOrders,
                    tension: 0.3,
                    fill: true,
                    borderWidth: 3,
                    pointBackgroundColor: 'rgba(255, 99, 132, 1)',
                    pointBorderColor: '#fff',
                    pointRadius: 4,
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        font: {
                            family: 'Inter',
                            size: 12
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            let value = context.parsed.y;
                            if (label.includes('Pendapatan')) {
                                return label + ': Rp ' + value.toLocaleString('id-ID');
                            }
                            return label + ': ' + value;
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
                    beginAtZero: true,
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
                },
                y1: {
                    beginAtZero: true,
                    position: 'right',
                    grid: {
                        drawOnChartArea: false
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
});
</script>
@endsection