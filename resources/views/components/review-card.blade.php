<div class="col-12">
    <div class="card review-card p-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
            <div class="d-flex align-items-center gap-3">
                <!-- User Avatar initials -->
                <div class="review-avatar-circle">
                    {{ substr($review->user->name ?? 'A', 0, 1) }}
                </div>
                <div>
                    <div class="review-user-name">{{ $review->user->name ?? 'Guest' }}</div>
                    <div class="d-flex align-items-center gap-2 mt-1">
                        <div class="text-warning small">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $review->rating ? '' : 'opacity-25' }}"></i>
                            @endfor
                        </div>
                        <span class="review-verified-badge"><i class="fas fa-check-double text-success"></i> Pembeli Terverifikasi</span>
                    </div>
                </div>
            </div>
            <span class="review-date-text"><i class="far fa-clock me-1 text-muted"></i> {{ $review->created_at->diffForHumans() }}</span>
        </div>
        <p class="review-comment mb-0">{{ $review->review }}</p>
    </div>
</div>
