@extends('layouts.admin')

@section('title', 'Riwayat Stok - ' . $product->name)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Riwayat Mutasi Stok</h1>
        <a href="{{ route('admin.stocks.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <h5>{{ $product->name }}</h5>
            <p class="text-muted">SKU: {{ $product->sku ?? '-' }} | Stok Saat Ini: 
                <strong class="{{ $product->stock == 0 ? 'text-danger' : 'text-success' }}">
                    {{ $product->stock }}
                </strong>
            </p>
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                        <th>Oleh</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($histories as $history)
                    <tr>
                        <td>{{ $history->created_at->format('d/m/Y H:i:s') }}</td>
                        <td>
                            @if($history->type == 'in')
                                <span class="badge bg-success">Masuk (+)</span>
                            @else
                                <span class="badge bg-danger">Keluar (-)</span>
                            @endif
                        </td>
                        <td>{{ $history->quantity }}</td>
                        <td>{{ $history->description ?? '-' }}</td>
                        <td>{{ $history->creator->name ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-center">
                {{ $histories->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection