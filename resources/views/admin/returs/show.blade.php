@extends('layouts.admin')

@section('title', 'Proses Retur - ' . $retur->retur_number)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Proses Pengajuan Retur</h1>
        <a href="{{ route('admin.returs.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informasi Retur</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <th width="35%">No. Retur</th>
                            <td>{{ $retur->retur_number }}</span></td>
                        </tr>
                        <tr>
                            <th>Invoice</th>
                            <td>{{ $retur->transaction->invoice_number }}</span></td>
                        </tr>
                        <tr>
                            <th>Customer</th>
                            <td>{{ $retur->user->name }} ({{ $retur->user->email }})</span></td>
                        </tr>
                        <tr>
                            <th>Tanggal Pengajuan</th>
                            <td>{{ $retur->created_at->format('d/m/Y H:i') }}</span></td>
                        </tr>
                        <tr>
                            <th>Alasan</th>
                            <td>{{ ucfirst($retur->reason) }}</span></td>
                        </tr>
                        @if($retur->description)
                        <tr>
                            <th>Keterangan</th>
                            <td>{{ $retur->description }}</span></td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Produk yang Diretur</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Refund</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($retur->items as $item)
                            <tr>
                                <td>{{ $item->transactionDetail->product->name }}</span></span></td>
                                <td>{{ $item->quantity }} pcs</span></td>
                                <td>Rp {{ number_format($item->refund_amount, 0, ',', '.') }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-active">
                            <tr>
                                <th colspan="2" class="text-end">Total Refund</th>
                                <th>Rp {{ number_format($retur->items->sum('refund_amount'), 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            @if($retur->proof_image)
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Bukti Foto</h5>
                </div>
                <div class="card-body text-center">
                    <img src="{{ asset('storage/' . $retur->proof_image) }}" class="img-fluid rounded" style="max-height: 300px;">
                </div>
            </div>
            @endif
        </div>
    </div>

    @if($retur->status == 'pending')
    <div class="row mt-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">Tindakan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.returs.approve', $retur->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Catatan (opsional)</label>
                            <input type="text" name="admin_notes" class="form-control" placeholder="Tambahkan catatan untuk customer">
                        </div>
                        <button type="submit" class="btn btn-success me-2" onclick="return confirm('Setujui pengajuan retur ini?')">
                            <i class="fas fa-check"></i> Setujui
                        </button>
                    </form>

                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                        <i class="fas fa-times"></i> Tolak
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Reject -->
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.returs.reject', $retur->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Tolak Pengajuan Retur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Alasan Penolakan *</label>
                            <textarea name="admin_notes" class="form-control" rows="3" required placeholder="Jelaskan alasan retur ditolak..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Tolak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @elseif($retur->status == 'approved')
    <div class="row mt-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Retur Disetujui</h5>
                </div>
                <div class="card-body">
                    <p>Retur telah disetujui pada: {{ $retur->approved_at ? \Carbon\Carbon::parse($retur->approved_at)->format('d/m/Y H:i') : '-' }}</p>
                    <form action="{{ route('admin.returs.complete', $retur->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-primary" onclick="return confirm('Tandai retur sebagai selesai?')">
                            <i class="fas fa-check-double"></i> Tandai Selesai
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection