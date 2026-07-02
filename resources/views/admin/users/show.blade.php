@extends('layouts.admin')

@section('title', 'Detail User - ' . $user->name)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Detail User</h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <!-- Informasi User -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informasi Akun</h5>
                </div>
                <div class="card-body text-center">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" width="100" height="100" style="border-radius: 50%; object-fit: cover;" class="mb-3">
                    @else
                        <div class="mx-auto mb-3 d-flex align-items-center justify-content-center bg-dark text-white rounded-circle" style="width: 100px; height: 100px; font-size: 40px;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    
                    <h4>{{ $user->name }}</h4>
                    <p class="text-muted">{{ $user->email }}</p>
                    
                    <hr>
                    <div class="text-start">
                        <p><strong>Telepon:</strong> {{ $user->phone ?? '-' }}</p>
                        <p><strong>Terdaftar:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</p>
                        <p><strong>Status:</strong> 
                            @if($user->email_verified_at)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-danger">Nonaktif</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik -->
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Pesanan</h5>
                            <h2 class="mb-0">{{ $totalOrders }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title">Pesanan Selesai</h5>
                            <h2 class="mb-0">{{ $totalOrdersCompleted }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Belanja</h5>
                            <h4 class="mb-0">Rp {{ number_format($totalSpent, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alamat -->
            <div class="card mb-3">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Alamat Tersimpan</h5>
                </div>
                <div class="card-body">
                    @forelse($user->addresses as $address)
                        <div class="border-bottom mb-2 pb-2">
                            <strong>{{ $address->label }}</strong> 
                            @if($address->is_default)
                                <span class="badge bg-primary">Default</span>
                            @endif
                            <p class="mb-0 mt-1">
                                {{ $address->recipient_name }}<br>
                                {{ $address->phone }}<br>
                                {{ $address->address }}<br>
                                {{ $address->city }}, {{ $address->province }} - {{ $address->postal_code }}
                            </p>
                        </div>
                    @empty
                        <p class="text-muted">Belum ada alamat tersimpan</p>
                    @endforelse
                </div>
            </div>

            <!-- Riwayat Transaksi -->
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Riwayat Transaksi</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Invoice</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($user->transactions()->latest()->limit(5)->get() as $transaction)
                            <tr>
                                <td>{{ $transaction->invoice_number }}</td>
                                <td>{{ $transaction->created_at->format('d/m/Y') }}</td>
                                <td>Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</td>
                                <td>{{ ucfirst($transaction->status) }}</td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada transaksi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.transactions.index', ['user_id' => $user->id]) }}" class="btn btn-sm btn-primary">
                        Lihat Semua Transaksi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection