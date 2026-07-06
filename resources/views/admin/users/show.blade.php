@extends('layouts.admin')

@section('title', 'Detail User - ' . $user->name)

@section('content')
<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mb-1">Detail User</h1>
            <p class="text-muted mb-0" style="font-size: 0.875rem;">Informasi lengkap akun pelanggan</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i data-lucide="arrow-left" style="width:16px;height:16px;"></i>
            Kembali
        </a>
    </div>

    <div class="row g-4">
        {{-- Kolom kiri: Info user --}}
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header">
                    <span style="font-weight:700;font-size:0.9rem;">Informasi Akun</span>
                </div>
                <div class="card-body text-center py-4">
                    @if($user->avatar)
                        <img src="{{ url('render-image?path=' . $user->avatar) }}"
                             width="96" height="96"
                             style="border-radius:50%;object-fit:cover;border:3px solid var(--primary-light);"
                             class="mb-3">
                    @else
                        <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle"
                             style="width:96px;height:96px;font-size:2.2rem;font-weight:700;
                                    background:linear-gradient(135deg,var(--primary),var(--primary-light));
                                    color:#fff;box-shadow:0 4px 15px rgba(219,39,119,0.25);">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif

                    <h4 class="mb-1">{{ $user->name }}</h4>
                    <p class="text-muted mb-3" style="font-size:0.85rem;">{{ $user->email }}</p>

                    <div class="d-flex justify-content-center gap-2 mb-4">
                        @if($user->email_verified_at)
                            <span class="badge rounded-pill" style="background:rgba(22,163,74,0.12);color:#16a34a;padding:5px 14px;font-size:0.78rem;font-weight:600;">
                                <i data-lucide="check-circle" style="width:12px;height:12px;margin-right:4px;"></i>Aktif
                            </span>
                        @else
                            <span class="badge rounded-pill" style="background:rgba(220,38,38,0.1);color:#dc2626;padding:5px 14px;font-size:0.78rem;font-weight:600;">
                                <i data-lucide="x-circle" style="width:12px;height:12px;margin-right:4px;"></i>Nonaktif
                            </span>
                        @endif
                    </div>

                    <div class="text-start" style="font-size:0.875rem;">
                        <div class="d-flex align-items-center gap-2 mb-2 pb-2" style="border-bottom:1px solid var(--glass-border);">
                            <i data-lucide="phone" style="width:15px;height:15px;color:var(--primary);flex-shrink:0;"></i>
                            <span class="text-muted">Telepon:</span>
                            <span class="ms-auto fw-600">{{ $user->phone ?? '-' }}</span>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2 pb-2" style="border-bottom:1px solid var(--glass-border);">
                            <i data-lucide="calendar" style="width:15px;height:15px;color:var(--primary);flex-shrink:0;"></i>
                            <span class="text-muted">Terdaftar:</span>
                            <span class="ms-auto fw-600">{{ $user->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i data-lucide="user-check" style="width:15px;height:15px;color:var(--primary);flex-shrink:0;"></i>
                            <span class="text-muted">Role:</span>
                            <span class="ms-auto fw-600" style="text-transform:capitalize;">{{ $user->role ?? 'customer' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom kanan: Statistik + Alamat + Transaksi --}}
        <div class="col-lg-8">

            {{-- Statistik --}}
            <div class="row g-3 mb-4">
                <div class="col-sm-4">
                    <div class="card text-center py-3">
                        <div class="card-body py-2">
                            <div class="mb-1" style="font-size:1.8rem;font-weight:800;color:var(--primary);">{{ $totalOrders }}</div>
                            <div class="text-muted" style="font-size:0.78rem;font-weight:600;letter-spacing:.05em;text-transform:uppercase;">Total Pesanan</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card text-center py-3">
                        <div class="card-body py-2">
                            <div class="mb-1" style="font-size:1.8rem;font-weight:800;color:#16a34a;">{{ $totalOrdersCompleted }}</div>
                            <div class="text-muted" style="font-size:0.78rem;font-weight:600;letter-spacing:.05em;text-transform:uppercase;">Pesanan Selesai</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card text-center py-3">
                        <div class="card-body py-2">
                            <div class="mb-1" style="font-size:1.4rem;font-weight:800;color:#ca8a04;">Rp {{ number_format($totalSpent, 0, ',', '.') }}</div>
                            <div class="text-muted" style="font-size:0.78rem;font-weight:600;letter-spacing:.05em;text-transform:uppercase;">Total Belanja</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Alamat Tersimpan --}}
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center gap-2">
                    <i data-lucide="map-pin" style="width:16px;height:16px;color:var(--primary);"></i>
                    <span style="font-weight:700;font-size:0.9rem;">Alamat Tersimpan</span>
                </div>
                <div class="card-body">
                    @forelse($user->addresses as $address)
                        <div class="d-flex align-items-start gap-3 {{ !$loop->last ? 'mb-3 pb-3' : '' }}"
                             style="{{ !$loop->last ? 'border-bottom:1px solid var(--glass-border)' : '' }}">
                            <div style="width:36px;height:36px;background:rgba(219,39,119,0.08);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i data-lucide="map-pin" style="width:16px;height:16px;color:var(--primary);"></i>
                            </div>
                            <div style="font-size:0.875rem;">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <strong>{{ $address->label }}</strong>
                                    @if($address->is_default)
                                        <span class="badge rounded-pill" style="background:rgba(219,39,119,0.12);color:var(--primary);font-size:0.7rem;padding:3px 10px;">Default</span>
                                    @endif
                                </div>
                                <div class="text-muted">
                                    {{ $address->recipient_name }} &bull; {{ $address->phone }}<br>
                                    {{ $address->address }}<br>
                                    {{ $address->city }}, {{ $address->province }} - {{ $address->postal_code }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-3 text-muted" style="font-size:0.875rem;">
                            <i data-lucide="map-off" style="width:28px;height:28px;opacity:0.3;display:block;margin:0 auto 8px;"></i>
                            Belum ada alamat tersimpan
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Riwayat Transaksi --}}
            <div class="card">
                <div class="card-header d-flex align-items-center gap-2">
                    <i data-lucide="shopping-cart" style="width:16px;height:16px;color:var(--primary);"></i>
                    <span style="font-weight:700;font-size:0.9rem;">Riwayat Transaksi</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead>
                                <tr style="background:#F9FAFB;">
                                    <th style="padding:12px 16px;font-size:0.75rem;text-transform:uppercase;letter-spacing:.05em;color:#6B7280;font-weight:700;border-bottom:1px solid var(--glass-border);">Invoice</th>
                                    <th style="padding:12px 16px;font-size:0.75rem;text-transform:uppercase;letter-spacing:.05em;color:#6B7280;font-weight:700;border-bottom:1px solid var(--glass-border);">Tanggal</th>
                                    <th style="padding:12px 16px;font-size:0.75rem;text-transform:uppercase;letter-spacing:.05em;color:#6B7280;font-weight:700;border-bottom:1px solid var(--glass-border);">Total</th>
                                    <th style="padding:12px 16px;font-size:0.75rem;text-transform:uppercase;letter-spacing:.05em;color:#6B7280;font-weight:700;border-bottom:1px solid var(--glass-border);">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($user->transactions()->latest()->limit(5)->get() as $transaction)
                                <tr>
                                    <td style="padding:12px 16px;font-size:0.85rem;border-bottom:1px solid var(--glass-border);">
                                        <a href="{{ route('admin.transactions.show', $transaction->id) }}"
                                           style="color:var(--primary);font-weight:600;text-decoration:none;">
                                            {{ $transaction->invoice_number }}
                                        </a>
                                    </td>
                                    <td style="padding:12px 16px;font-size:0.85rem;color:#6B7280;border-bottom:1px solid var(--glass-border);">{{ $transaction->created_at->format('d/m/Y') }}</td>
                                    <td style="padding:12px 16px;font-size:0.85rem;font-weight:600;border-bottom:1px solid var(--glass-border);">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</td>
                                    <td style="padding:12px 16px;border-bottom:1px solid var(--glass-border);">
                                        @php
                                            $statusColor = match($transaction->status) {
                                                'delivered','completed' => ['bg'=>'rgba(22,163,74,0.12)','text'=>'#16a34a'],
                                                'processing','shipped' => ['bg'=>'rgba(8,145,178,0.12)','text'=>'#0891b2'],
                                                'cancelled','expired'  => ['bg'=>'rgba(220,38,38,0.1)','text'=>'#dc2626'],
                                                default => ['bg'=>'rgba(217,119,6,0.1)','text'=>'#d97706'],
                                            };
                                        @endphp
                                        <span class="badge rounded-pill" style="background:{{ $statusColor['bg'] }};color:{{ $statusColor['text'] }};font-size:0.75rem;font-weight:600;padding:4px 12px;">
                                            {{ ucfirst($transaction->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted" style="font-size:0.875rem;">
                                            Belum ada transaksi
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end" style="background:#F9FAFB;">
                    <a href="{{ route('admin.transactions.index', ['user_id' => $user->id]) }}" class="btn btn-sm btn-primary">
                        <i data-lucide="external-link" style="width:14px;height:14px;margin-right:6px;"></i>
                        Lihat Semua Transaksi
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
