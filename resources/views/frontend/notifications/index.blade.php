@extends('layouts.app')

@section('title', 'Notifikasi Saya - Aciaa Fashion Store')

@push('styles')
<style>
    :root {
        --ck-pink: #d4a5a5;
        --ck-pink-2: #b5838d;
        --ck-soft: #fef6f5;
        --ck-dark: #1a1a1a;
    }

    .notification-page {
        font-family: 'Poppins', 'Inter', sans-serif;
    }

    .notification-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        background: #ffffff;
        margin-bottom: 30px;
    }

    .notification-card-header {
        background: linear-gradient(135deg, rgba(212,165,165,0.08), rgba(254,246,245,0.4));
        border-bottom: 1px solid rgba(212,165,165,0.15);
        padding: 20px 24px;
    }

    .filter-btn {
        padding: 8px 18px;
        border-radius: 50px;
        font-weight: 500;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        border: 1px solid #e0e0e0;
        color: #666;
        background: #fff;
    }

    .filter-btn.active {
        background: linear-gradient(135deg, var(--ck-pink), var(--ck-pink-2));
        color: white;
        border-color: transparent;
        box-shadow: 0 4px 12px rgba(181, 131, 141, 0.25);
    }

    .filter-btn:hover:not(.active) {
        background: var(--ck-soft);
        color: var(--ck-pink-2);
        border-color: var(--ck-pink);
    }

    .btn-pink {
        background: linear-gradient(135deg, var(--ck-pink), var(--ck-pink-2));
        border: none;
        color: white;
        font-weight: 600;
        padding: 10px 22px;
        border-radius: 50px;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
    }
    
    .btn-pink:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(181, 131, 141, 0.25);
        color: white;
    }

    .btn-outline-pink {
        border: 2px solid var(--ck-pink);
        color: var(--ck-pink-2);
        font-weight: 600;
        padding: 8px 20px;
        border-radius: 50px;
        transition: all 0.2s ease;
        background: transparent;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
    }
    
    .btn-outline-pink:hover {
        background: var(--ck-soft);
        color: var(--ck-dark);
        border-color: var(--ck-pink-2);
    }

    .notification-item {
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.25s ease;
        position: relative;
    }

    .notification-item:hover {
        background-color: #fafafa !important;
    }

    .notification-item.unread {
        background-color: var(--ck-soft);
    }

    .notification-icon-wrapper {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .icon-shipping {
        background-color: rgba(212, 165, 165, 0.15);
        color: var(--ck-pink-2);
    }

    .icon-promo {
        background-color: rgba(234, 179, 8, 0.15);
        color: #d97706;
    }

    .icon-info {
        background-color: rgba(59, 130, 246, 0.15);
        color: #2563eb;
    }

    .unread-indicator {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #ff4444;
        display: inline-block;
        position: absolute;
        top: 22px;
        left: 12px;
    }

    .btn-delete {
        background: none;
        border: none;
        color: #a0aec0;
        transition: color 0.2s;
        padding: 6px;
        border-radius: 50%;
    }

    .btn-delete:hover {
        color: #e53e3e;
        background: rgba(229, 62, 62, 0.05);
    }

    .empty-state {
        text-align: center;
        padding: 50px 20px;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--ck-soft), rgba(212,165,165,0.2));
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: var(--ck-pink-2);
        margin-bottom: 20px;
    }
</style>
@endpush

@section('content')
<div class="container my-5 notification-page">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header Page -->
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-3">
                <div>
                    <h2 class="fw-bold text-gray-800 mb-1">Notifikasi Saya</h2>
                    <p class="text-muted mb-0">Lihat kabar pengiriman, promo, dan info menarik lainnya.</p>
                </div>
                
                <div class="d-flex gap-2">
                    @if($notifications->count() > 0)
                        <!-- Tandai semua dibaca -->
                        <form action="{{ route('notifications.mark-all-read') }}" method="POST" id="markAllReadForm">
                            @csrf
                            <button type="submit" class="btn-outline-pink">
                                <i class="fas fa-check-double"></i> Tandai Semua Dibaca
                            </button>
                        </form>
                        
                        <!-- Bersihkan semua -->
                        <form action="{{ route('notifications.clear-all') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus semua notifikasi?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger rounded-pill px-3 py-2 fw-semibold" style="font-size: 0.85rem;">
                                <i class="fas fa-trash-alt"></i> Bersihkan Semua
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Filters -->
            <div class="d-flex gap-2 mb-4 overflow-auto pb-1">
                @php
                    $currentStatus = request()->status;
                @endphp
                <a href="{{ route('notifications.index') }}" class="filter-btn {{ !$currentStatus ? 'active' : '' }}">
                    Semua Notifikasi
                </a>
                <a href="{{ route('notifications.index', ['status' => 'unread']) }}" class="filter-btn {{ $currentStatus === 'unread' ? 'active' : '' }}">
                    Belum Dibaca
                </a>
                <a href="{{ route('notifications.index', ['status' => 'read']) }}" class="filter-btn {{ $currentStatus === 'read' ? 'active' : '' }}">
                    Sudah Dibaca
                </a>
            </div>

            <!-- Notifications Card -->
            <div class="card notification-card">
                <div class="card-body p-0">
                    @if($notifications->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($notifications as $item)
                                <div class="list-group-item notification-item p-3 {{ !$item->is_read ? 'unread' : '' }} d-flex justify-content-between align-items-center">
                                    
                                    <!-- Unread Dot Indicator -->
                                    @if(!$item->is_read)
                                        <span class="unread-indicator"></span>
                                    @endif

                                    <div class="d-flex align-items-center gap-3 ps-3 flex-grow-1" style="min-width: 0;">
                                        <!-- Icon Container -->
                                        @php
                                            $iconClass = 'icon-info';
                                            $icon = 'fa-info-circle';
                                            if ($item->type === 'shipping') {
                                                $iconClass = 'icon-shipping';
                                                $icon = 'fa-shipping-fast';
                                            } elseif ($item->type === 'promo') {
                                                $iconClass = 'icon-promo';
                                                $icon = 'fa-gift';
                                            }
                                        @endphp
                                        <div class="notification-icon-wrapper {{ $iconClass }}">
                                            <i class="fas {{ $icon }} fa-lg"></i>
                                        </div>

                                        <!-- Message Content -->
                                        <div style="min-width: 0;">
                                            <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                                                <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.95rem;">
                                                    @if($item->link)
                                                        <a href="{{ route('notifications.read-redirect', $item->id) }}" class="text-decoration-none text-dark hover-pink-link">
                                                            {{ $item->title }}
                                                        </a>
                                                    @else
                                                        {{ $item->title }}
                                                    @endif
                                                </h6>
                                                <span class="text-muted small" style="font-size: 0.75rem;">
                                                    <i class="far fa-clock me-1"></i>{{ $item->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                            <p class="text-muted mb-0 small" style="font-size: 0.85rem; line-height: 1.4;">
                                                {{ $item->message }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Delete Button -->
                                    <div class="ms-2">
                                        <form action="{{ route('notifications.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete" title="Hapus Notifikasi">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="far fa-bell fa-3x"></i>
                            </div>
                            <h5 class="fw-bold text-gray-800 mb-2">Tidak ada notifikasi</h5>
                            <p class="text-muted mb-4 small" style="max-width: 320px; margin: 0 auto;">
                                @if($currentStatus === 'unread')
                                    Hebat! Semua notifikasi Anda sudah selesai dibaca.
                                @elseif($currentStatus === 'read')
                                    Belum ada notifikasi yang ditandai sebagai dibaca.
                                @else
                                    Anda belum menerima notifikasi apa pun saat ini.
                                @endif
                            </p>
                            <a href="{{ route('home') }}" class="btn-pink">
                                <i class="fas fa-shopping-bag"></i> Belanja Sekarang
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Pagination Links -->
            @if($notifications->count() > 0)
                <div class="d-flex justify-content-center">
                    {{ $notifications->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // AJAX to mark as read when user clicks link
    function markAsRead(id) {
        fetch('/notifications/' + id + '/read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).catch(err => console.error(err));
    }
    
    // AJAX for mark all read form to keep experience slick
    const markAllReadForm = document.getElementById('markAllReadForm');
    if (markAllReadForm) {
        markAllReadForm.addEventListener('submit', function(e) {
            e.preventDefault();
            fetch('{{ route('notifications.mark-all-read') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Refresh current page
                    window.location.reload();
                }
            })
            .catch(() => {
                // Fallback to normal form submission if fetch fails
                markAllReadForm.submit();
            });
        });
    }
</script>
@endpush
