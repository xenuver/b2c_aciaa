@if($transactions->count() > 0)
    <div class="transaction-list">
        @foreach($transactions as $transaction)
            <div class="order-item-card">
                <!-- Card Header -->
                <div class="order-card-header">
                    <div class="d-flex align-items-center gap-2">
                        <span class="order-invoice">{{ $transaction->invoice_number }}</span>
                        <span class="text-muted d-none d-sm-inline">•</span>
                        <span class="order-date"><i class="far fa-calendar-alt me-1"></i>{{ $transaction->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    
                    <div>
                        @php
                            $statusBadgeColor = match($transaction->status) {
                                'pending' => 'bg-warning text-dark',
                                'processing' => 'bg-info text-dark',
                                'shipped' => 'bg-primary text-white',
                                'delivered' => 'bg-success text-white',
                                'cancelled' => 'bg-danger text-white',
                                default => 'bg-secondary text-white',
                            };
                            $paymentBadgeColor = match($transaction->payment_status) {
                                'unpaid' => 'bg-danger-subtle text-danger border border-danger',
                                'pending' => 'bg-warning-subtle text-warning border border-warning',
                                'paid' => 'bg-success-subtle text-success border border-success',
                                'failed' => 'bg-danger-subtle text-danger border border-danger',
                                'expired' => 'bg-secondary-subtle text-secondary border border-secondary',
                                default => 'bg-secondary-subtle text-secondary',
                            };
                        @endphp
                        <span class="badge {{ $statusBadgeColor }} order-status-badge me-1">{{ ucfirst($transaction->status) }}</span>
                        <span class="badge {{ $paymentBadgeColor }} px-2.5 py-1.5 rounded-pill" style="font-size: 0.7rem; font-weight:600;">{{ ucfirst($transaction->payment_status) }}</span>
                    </div>
                </div>
                
                <!-- Card Body -->
                <div class="order-body">
                    @php
                        $firstDetail = $transaction->details->first();
                        $extraProductsCount = $transaction->details->count() - 1;
                    @endphp
                    
                    @if($firstDetail)
                        <div class="d-flex align-items-center gap-3">
                            @if($firstDetail->product && $firstDetail->product->image)
                                <img src="{{ url('media/' . $firstDetail->product->image) }}" class="order-product-img" alt="{{ $firstDetail->product->name }}">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                            @endif
                            
                            <div class="flex-grow-1">
                                <h6 class="order-product-name">{{ $firstDetail->product->name ?? 'Produk Dihapus' }}</h6>
                                <p class="text-muted small mb-0">{{ $firstDetail->quantity }} barang x Rp {{ number_format($firstDetail->price, 0, ',', '.') }}</p>
                                
                                @if($extraProductsCount > 0)
                                    <p class="text-muted small mb-0 mt-1 fw-medium"><i class="fas fa-plus-circle me-1"></i>+{{ $extraProductsCount }} produk lainnya</p>
                                @endif
                            </div>
                        </div>
                    @else
                        <p class="text-muted mb-0 small">Detail produk tidak tersedia.</p>
                    @endif
                </div>
                
                <!-- Card Footer -->
                <div class="order-footer">
                    <div>
                        <div class="order-total-label">Total Belanja</div>
                        <div class="order-total-price">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        @if($transaction->status === 'pending' && in_array($transaction->payment_status, ['unpaid', 'pending']) && !$transaction->isPaymentExpired())
                            <a href="{{ route('transactions.show', $transaction->id) }}?pay=1" class="btn-detail py-2 px-3">
                                <i class="fas fa-credit-card me-1"></i> Lanjutkan Pembayaran
                            </a>
                            <a href="{{ route('transactions.show', $transaction->id) }}" class="btn-outline-pink py-1.5 px-3" style="font-size: 0.85rem;">
                                Detail
                            </a>
                        @else
                            <a href="{{ route('transactions.show', $transaction->id) }}" class="btn-detail">
                                Lihat Detail Pesanan
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4 ajax-pagination">
            {{ $transactions->links() }}
        </div>
    </div>
@else
    <div class="empty-state">
        <i class="fas fa-receipt fa-4x mb-3 text-muted" style="color: var(--ck-pink) !important; opacity: 0.5;"></i>
        <h4 class="fw-bold mb-2">Belum Ada Transaksi</h4>
        <p class="text-muted small">Transaksi tidak ditemukan dengan kata kunci atau filter tersebut.</p>
        <a href="{{ route('products.index') }}" class="btn-shop">
            Mulai Belanja Sekarang
        </a>
    </div>
@endif
