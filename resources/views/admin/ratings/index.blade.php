@extends('layouts.admin')

@section('title', 'Kelola Ulasan')

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

/* Stats Grid */
.ratings-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1.25rem;
    margin-bottom: 1.75rem;
}
.stat-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}
.stat-info {
    display: flex;
    flex-direction: column;
}
.stat-value {
    font-size: 22px;
    font-weight: 700;
    color: #111827;
    line-height: 1.2;
}
.stat-label {
    font-size: 12px;
    color: #6b7280;
    font-weight: 500;
}

/* Filters Panel */
.filter-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 1.25rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
}

/* Alerts */
.pm-alert {
    display: flex; align-items: center; gap: 10px;
    background: #f0fdf4; border: 1px solid #bbf7d0;
    border-radius: 10px; padding: 12px 16px;
    font-size: 13px; color: #166534;
    margin-bottom: 1.5rem;
}
.pm-alert-danger {
    background: #fef2f2; border: 1px solid #fee2e2;
    color: #991b1b;
}
.pm-alert button {
    margin-left: auto; background: none; border: none;
    cursor: pointer; color: inherit; font-size: 18px; line-height: 1;
}

.pm-card {
    background: #fff; border: 1px solid #e5e7eb;
    border-radius: 14px; overflow: hidden;
    box-shadow: 0 1px 4px rgba(0,0,0,.05);
}
.pm-card-header {
    display: flex; align-items: center;
    justify-content: space-between;
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #f3f4f6;
    flex-wrap: wrap; gap: 10px;
}
.pm-card-title { font-size: 14px; font-weight: 700; color: #111827; }

/* Table styling */
.pm-table { width: 100%; border-collapse: collapse; }
.pm-table thead th {
    font-size: 11px; font-weight: 700; color: #6b7280;
    text-transform: uppercase; letter-spacing: .06em;
    white-space: nowrap; padding: 10px 16px;
    background: #f9fafb; border-bottom: 1px solid #f3f4f6;
    text-align: left;
}
.pm-table tbody td {
    padding: 13px 16px; border-bottom: 1px solid #f3f4f6;
    vertical-align: middle; font-size: 13px; color: #374151;
}
.pm-table tbody tr:last-child td { border-bottom: none; }
.pm-table tbody tr:hover td { background: #fafafa; }

/* Badge Pills */
.badge-pill {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 11px; font-weight: 600;
    padding: 3px 9px; border-radius: 99px; white-space: nowrap;
}
.bp-active   { background: #dcfce7; color: #166534; }
.bp-inactive { background: #fee2e2; color: #991b1b; }
.dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
.dot-green { background: #16a34a; }
.dot-red   { background: #dc2626; }

/* Buttons */
.btn-act {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 12px; font-weight: 600;
    padding: 6px 12px; border-radius: 8px;
    cursor: pointer; text-decoration: none;
    transition: background .15s, color .15s;
    white-space: nowrap; border: 1px solid;
    background: #fff;
}
.btn-act-edit { border-color: #e5e7eb; color: #374151; }
.btn-act-edit:hover { background: #f9fafb; border-color: #d1d5db; color: #111827; text-decoration: none; }

.btn-act-approve { border-color: #bbf7d0; color: #16a34a; background: #f0fdf4; }
.btn-act-approve:hover { background: #dcfce7; border-color: #86efac; }

.btn-act-hide { border-color: #fed7aa; color: #ea580c; background: #fff7ed; }
.btn-act-hide:hover { background: #ffedd5; border-color: #fdba74; }

.btn-act-del  { background: #fff0f0; border-color: #fecaca; color: #dc2626; }
.btn-act-del:hover { background: #fee2e2; border-color: #fca5a5; }

.pm-footer {
    display: flex;
    align-items: center;
    padding: .875rem 1.25rem;
    border-top: 1px solid #f3f4f6;
    min-height: 56px;
}

.empty-state { text-align: center; padding: 3.5rem 1rem; color: #9ca3af; }
.empty-state p { margin: .5rem 0 0; font-size: 14px; }

/* Reply Box styling */
.admin-reply-box {
    background: #f8fafc;
    border-left: 3px solid #64748b;
    padding: 8px 12px;
    border-radius: 4px;
    margin-top: 6px;
    font-size: 12px;
}
.reply-header {
    font-weight: 700;
    color: #475569;
    margin-bottom: 2px;
    display: flex;
    justify-content: space-between;
}
.reply-content {
    color: #334155;
    font-style: italic;
}
.star-rating i {
    color: #fbbf24;
}
</style>

<div class="pm-page">
    {{-- Top bar --}}
    <div class="pm-topbar">
        <div>
            <h1 class="pm-title">Kelola Ulasan & Rating</h1>
            <p class="pm-subtitle">Moderasi ulasan dari pelanggan dan berikan balasan resmi</p>
        </div>
    </div>

    {{-- Alert --}}
    @if(session('success'))
    <div class="pm-alert">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
             fill="none" stroke="currentColor" stroke-width="2"
             stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
            <polyline points="22 4 12 14.01 9 11.01"/>
        </svg>
        {{ session('success') }}
        <button onclick="this.parentElement.remove()">×</button>
    </div>
    @endif

    {{-- Stats Cards --}}
    <div class="ratings-stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: #eff6ff; color: #2563eb;">
                <i class="fas fa-comments"></i>
            </div>
            <div class="stat-info">
                <span class="stat-value">{{ $totalRatings }}</span>
                <span class="stat-label">Total Ulasan</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #fffbeb; color: #d97706;">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-info">
                <span class="stat-value">{{ number_format($avgRating, 1) }} / 5.0</span>
                <span class="stat-label">Rata-rata Rating</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #faf5ff; color: #7c3aed;">
                <i class="fas fa-reply-all"></i>
            </div>
            <div class="stat-info">
                <span class="stat-value">{{ $pendingReply }}</span>
                <span class="stat-label">Belum Dibalas</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #fff7ed; color: #ea580c;">
                <i class="fas fa-eye-slash"></i>
            </div>
            <div class="stat-info">
                <span class="stat-value">{{ $hiddenCount }}</span>
                <span class="stat-label">Butuh Moderasi</span>
            </div>
        </div>
    </div>

    {{-- Filter Panel --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.ratings.index') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted">Cari Ulasan</label>
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="User, Produk, atau isi ulasan..." value="{{ request('search') }}">
                </div>
            </div>

            <div class="col-md-2.5 col-sm-6">
                <label class="form-label small fw-bold text-muted">Rating Bintang</label>
                <select name="rating" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">Semua Bintang</option>
                    @for($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>{{ $i }} Bintang</option>
                    @endfor
                </select>
            </div>

            <div class="col-md-2.5 col-sm-6">
                <label class="form-label small fw-bold text-muted">Status Moderasi</label>
                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Ditampilkan</option>
                    <option value="hidden" {{ request('status') === 'hidden' ? 'selected' : '' }}>Disembunyikan (Moderasi)</option>
                </select>
            </div>

            <div class="col-md-2.5 col-sm-6">
                <label class="form-label small fw-bold text-muted">Status Balasan</label>
                <select name="reply" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">Semua Balasan</option>
                    <option value="replied" {{ request('reply') === 'replied' ? 'selected' : '' }}>Sudah Dibalas</option>
                    <option value="unreplied" {{ request('reply') === 'unreplied' ? 'selected' : '' }}>Belum Dibalas</option>
                </select>
            </div>

            <div class="col-md-1.5 col-sm-6 d-flex align-items-end">
                <a href="{{ route('admin.ratings.index') }}" class="btn btn-sm btn-outline-secondary w-100"><i class="fas fa-sync-alt me-1"></i> Reset</a>
            </div>
        </form>
    </div>

    {{-- Table Card --}}
    <div class="pm-card">
        <div class="pm-card-header">
            <span class="pm-card-title">Daftar Ulasan Pelanggan</span>
        </div>

        <div class="table-responsive">
            <table class="pm-table">
                <thead>
                    <tr>
                        <th width="15%">Pelanggan</th>
                        <th width="20%">Produk</th>
                        <th width="40%">Ulasan & Rating</th>
                        <th width="10%">Status</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ratings as $rating)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:32px; height:32px; background:#eff6ff; display:flex; align-items:center; justify-content:center; border-radius:50%; font-weight:700; color:#2563eb; font-size:12px;">
                                    {{ substr($rating->user->name ?? 'U', 0, 1) }}
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="fw-semibold text-dark">{{ $rating->user->name ?? 'User Terhapus' }}</span>
                                    <span class="text-muted" style="font-size:10px;">{{ $rating->user->email ?? '' }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @if($rating->product && $rating->product->image)
                                    <img src="{{ asset('storage/' . $rating->product->image) }}" alt="" style="width:36px; height:36px; object-fit:cover; border-radius:6px;">
                                @else
                                    <div style="width:36px; height:36px; background:#f3f4f6; display:flex; align-items:center; justify-content:center; border-radius:6px; color:#9ca3af;"><i class="fas fa-image"></i></div>
                                @endif
                                <div class="d-flex flex-column" style="max-width: 150px;">
                                    <span class="fw-semibold text-dark text-truncate">{{ $rating->product->name ?? 'Produk Terhapus' }}</span>
                                    <span class="text-muted text-truncate" style="font-size:10px;">Invoice: {{ $rating->transaction->invoice_number ?? '-' }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <div class="star-rating mb-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="{{ $i <= $rating->rating ? 'fas' : 'far' }} fa-star" style="font-size:11px;"></i>
                                    @endfor
                                    <span class="text-muted small ms-1" style="font-size:11px;">({{ $rating->created_at->format('d/m/Y H:i') }})</span>
                                </div>
                                <div class="text-dark fw-medium" style="font-size:12.5px;">{{ $rating->review }}</div>
                                
                                {{-- Rating Images --}}
                                @if($rating->images && count($rating->images) > 0)
                                <div class="d-flex gap-1 mt-2">
                                    @foreach($rating->images as $img)
                                        <a href="{{ asset('storage/' . $img) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $img) }}" style="width:40px; height:40px; object-fit:cover; border-radius:6px; border:1px solid #e5e7eb;">
                                        </a>
                                    @endforeach
                                </div>
                                @endif

                                {{-- Admin Reply --}}
                                @if($rating->admin_reply)
                                <div class="admin-reply-box">
                                    <div class="reply-header">
                                        <span><i class="fas fa-reply text-muted me-1"></i> Balasan Toko:</span>
                                    </div>
                                    <div class="reply-content">{{ $rating->admin_reply }}</div>
                                </div>
                                @endif
                            </div>
                        </td>
                        <td>
                            @if($rating->is_approved)
                                <span class="badge-pill bp-active">
                                    <span class="dot dot-green"></span> Tampil
                                </span>
                            @else
                                <span class="badge-pill bp-inactive">
                                    <span class="dot dot-red"></span> Moderasi
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex flex-wrap gap-1 align-items-center">
                                {{-- Toggle Approve/Hide Button --}}
                                <form action="{{ route('admin.ratings.toggle-approve', $rating->id) }}" method="POST" style="margin:0; display:inline;">
                                    @csrf
                                    @method('PUT')
                                    @if($rating->is_approved)
                                        <button type="submit" class="btn-act btn-act-hide" title="Sembunyikan Ulasan (Set ke Moderasi)">
                                            <i class="fas fa-eye-slash me-1"></i> Hide
                                        </button>
                                    @else
                                        <button type="submit" class="btn-act btn-act-approve" title="Tampilkan Ulasan di Toko">
                                            <i class="fas fa-eye me-1"></i> Approve
                                        </button>
                                    @endif
                                </form>

                                {{-- Reply Trigger Button --}}
                                <button type="button" class="btn-act btn-act-edit" data-bs-toggle="modal" data-bs-target="#replyModal-{{ $rating->id }}" title="Balas Ulasan">
                                    <i class="fas fa-reply me-1"></i> Balas
                                </button>

                                {{-- Delete Button --}}
                                <form action="{{ route('admin.ratings.destroy', $rating->id) }}" method="POST" style="margin:0; display:inline;" onsubmit="return confirm('Yakin ingin menghapus ulasan ini secara permanen?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-act btn-act-del" title="Hapus Ulasan Permanen">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>

                            {{-- Reply Modal --}}
                            <div class="modal fade" id="replyModal-{{ $rating->id }}" tabindex="-1" aria-labelledby="replyModalLabel-{{ $rating->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold" id="replyModalLabel-{{ $rating->id }}">Balas Ulasan - {{ $rating->user->name ?? 'User' }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('admin.ratings.reply', $rating->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3 p-3 bg-light rounded text-start">
                                                    <div class="fw-bold mb-1">{{ $rating->product->name ?? 'Produk' }}</div>
                                                    <div class="star-rating mb-2">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <i class="{{ $i <= $rating->rating ? 'fas' : 'far' }} fa-star" style="font-size:12px;"></i>
                                                        @endfor
                                                    </div>
                                                    <div class="text-muted small" style="font-style: italic;">"{{ $rating->review }}"</div>
                                                </div>

                                                <div class="mb-3 text-start">
                                                    <label for="admin_reply-{{ $rating->id }}" class="form-label small fw-bold">Tulis Balasan Toko <span class="text-danger">*</span></label>
                                                    <textarea class="form-control" name="admin_reply" id="admin_reply-{{ $rating->id }}" rows="4" required placeholder="Terima kasih atas masukannya! Kami akan terus meningkatkan kualitas pelayanan kami..." style="font-size: 13px;">{{ $rating->admin_reply }}</textarea>
                                                    <div class="form-text text-muted small">Minimal 5 karakter, maksimal 1000 karakter.</div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-sm btn-primary" style="background: linear-gradient(135deg, #151528 0%, #0f0f1b 100%); border:none;"><i class="fas fa-paper-plane me-1"></i> Simpan Balasan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <i class="fas fa-star-half-alt fa-2x mb-2 text-muted"></i>
                                <p>Belum ada ulasan yang sesuai filter.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pm-footer">
            {{ $ratings->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
