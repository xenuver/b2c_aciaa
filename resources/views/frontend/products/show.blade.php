@extends('layouts.app')

@section('title', $product->name)

@section('content')
@php
    $userRating = Auth::check() ? App\Models\Rating::where('user_id', Auth::id())
        ->where('product_id', $product->id)->first() : null;
    $canReview = Auth::check() && !$userRating && \App\Models\Transaction::where('user_id', Auth::id())
        ->where('status', 'delivered')
        ->whereHas('details', function($q) use ($product) {
            $q->where('product_id', $product->id);
        })->exists();

    // Parse gallery JSON securely
    $gallery = [];
    if (!empty($product->gallery)) {
        if (is_array($product->gallery)) {
            $gallery = $product->gallery;
        } else {
            $gallery = json_decode($product->gallery, true) ?? [];
        }
    }
    
    // Social Proof Helpers
    $populerBadge = $product->views_count > 100;
    $diskonPercent = 0;
    if ($product->discount_price && $product->price > 0) {
        $diskonPercent = round((($product->price - $product->discount_price) / $product->price) * 100);
    }
@endphp

<style>
    /* Premium Design Tokens */
    :root {
        --pd-pink: var(--color-primary);
        --pd-pink-2: var(--color-primary-light);
        --pd-pink-light: var(--color-surface-alt);
        --pd-soft: var(--color-surface-alt);
        --pd-dark: #111111;
        --pd-dark-gray: #2d3748;
        --pd-gray: #718096;
        --pd-border: #ede6e4;
        --pd-success: #38a169;
        --pd-rating: #CA8A04;
        --pd-shadow-soft: 0 10px 40px rgba(212, 165, 165, 0.12);
        --pd-shadow-hover: 0 20px 50px rgba(212, 165, 165, 0.22);
        --pd-gradient: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-light) 100%);
    }

    .pd-container {
        font-family: var(--font-body, 'Montserrat', sans-serif);
        color: var(--pd-dark);
    }

    /* Breadcrumbs styling */
    .pd-breadcrumb {
        font-size: 0.85rem;
        font-weight: 500;
        letter-spacing: 0.5px;
    }
    
    .pd-breadcrumb a {
        color: var(--pd-gray);
        text-decoration: none;
        transition: color 0.2s ease;
    }
    
    .pd-breadcrumb a:hover {
        color: var(--pd-pink-2);
    }

    /* Left Column: Image Gallery Showcase */
    .pd-gallery-container {
        position: relative;
    }

    .pd-image-wrapper {
        border-radius: 24px;
        overflow: hidden;
        background: #ffffff;
        box-shadow: var(--pd-shadow-soft);
        border: 1px solid rgba(212, 165, 165, 0.2);
        transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s ease;
        position: relative;
    }

    .pd-image-wrapper:hover {
        transform: translateY(-4px);
        box-shadow: var(--pd-shadow-hover);
    }

    .pd-zoom-wrapper {
        overflow: hidden;
        position: relative;
        cursor: zoom-in;
    }

    .pd-img {
        width: 100%;
        height: auto;
        max-height: 540px;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.3s ease;
    }

    .pd-zoom-wrapper:hover .pd-img {
        transform: scale(1.06);
    }

    /* Custom Floating Badge */
    .pd-floating-badge {
        position: absolute;
        top: 20px;
        left: 20px;
        z-index: 10;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(212, 165, 165, 0.3);
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--pd-pink-2);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }

    /* Gallery Thumbnails list */
    .pd-thumbnails {
        display: flex;
        gap: 12px;
        margin-top: 20px;
        flex-wrap: wrap;
    }

    .pd-thumb-btn {
        width: 76px;
        height: 76px;
        border-radius: 16px;
        overflow: hidden;
        border: 2px solid transparent;
        background: #ffffff;
        padding: 0;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 4px 10px rgba(0,0,0,0.02);
    }

    .pd-thumb-btn img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .pd-thumb-btn:hover img {
        transform: scale(1.08);
    }

    .pd-thumb-btn.active {
        border-color: var(--pd-pink-2);
        box-shadow: 0 6px 15px rgba(181, 131, 141, 0.25);
        transform: translateY(-2px);
    }

    /* Social Guarantee List */
    .pd-guarantee-list {
        background: var(--pd-soft);
        border: 1px dashed rgba(181, 131, 141, 0.3);
        border-radius: 20px;
        padding: 20px;
        margin-top: 30px;
    }

    .pd-guarantee-item {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 0.85rem;
        color: var(--pd-dark-gray);
        font-weight: 500;
    }

    .pd-guarantee-item i {
        color: var(--pd-pink-2);
        font-size: 1.1rem;
    }

    /* Right Column: Title and Details styling */
    .category-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--pd-pink-light);
        color: var(--pd-pink-2);
        padding: 6px 16px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        text-decoration: none;
        transition: all 0.3s ease;
        border: 1px solid rgba(181, 131, 141, 0.15);
    }

    .category-pill:hover {
        background: var(--pd-pink-2);
        color: #ffffff;
        transform: translateY(-1px);
    }

    .sku-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #f7fafc;
        border: 1px solid #e2e8f0;
        color: var(--pd-gray);
        padding: 5px 14px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .btn-copy-sku {
        background: transparent;
        border: none;
        color: var(--pd-pink-2);
        cursor: pointer;
        padding: 2px 4px;
        border-radius: 4px;
        transition: background 0.2s;
    }

    .btn-copy-sku:hover {
        background: rgba(181, 131, 141, 0.1);
        color: var(--pd-pink);
    }

    .pd-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--pd-dark);
        letter-spacing: -0.8px;
        line-height: 1.15;
    }

    /* Ratings and Stats System */
    .pd-rating-block {
        display: flex;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .pd-stars {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 0.95rem;
    }

    .social-proof-bar {
        display: flex;
        align-items: center;
        gap: 12px;
        border-left: 2px solid #e2e8f0;
        padding-left: 15px;
    }

    @media (max-width: 576px) {
        .social-proof-bar {
            border-left: none;
            padding-left: 0;
            width: 100%;
            margin-top: 5px;
        }
    }

    .social-stat-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--pd-gray);
        background: #f7fafc;
        padding: 4px 10px;
        border-radius: 6px;
    }

    /* Price tag system */
    .pd-price-card {
        background: #ffffff;
        border: 1px solid var(--pd-border);
        border-radius: 20px;
        padding: 24px;
        display: flex;
        flex-direction: column;
        box-shadow: 0 10px 30px rgba(212, 165, 165, 0.05);
        position: relative;
    }

    .pd-price-original {
        font-size: 1.1rem;
        text-decoration: line-through;
        color: var(--pd-gray);
        font-weight: 500;
    }

    .pd-price-promo-row {
        display: flex;
        align-items: baseline;
        gap: 12px;
        margin-top: 2px;
    }

    .pd-price-promo {
        font-size: 2.25rem;
        font-weight: 800;
        color: var(--pd-pink-2);
        line-height: 1;
        letter-spacing: -0.5px;
    }

    .pd-discount-badge {
        background: #ff4d4f;
        color: #ffffff;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Stock Badge */
    .badge-stock {
        padding: 8px 18px;
        font-weight: 700;
        font-size: 0.8rem;
        border-radius: 50px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    /* Interactive Quantity Selector Widget */
    .qty-label {
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--pd-dark-gray);
        margin-bottom: 8px;
    }

    .qty-widget {
        display: inline-flex;
        align-items: center;
        background: #f7fafc;
        border: 1px solid #e2e8f0;
        border-radius: 50px;
        padding: 4px;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
    }

    .qty-btn {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        border: none;
        background: #ffffff;
        color: var(--pd-dark);
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        transition: all 0.2s ease;
    }

    .qty-btn:hover {
        background: var(--pd-pink-2);
        color: #ffffff;
        box-shadow: 0 4px 10px rgba(181, 131, 141, 0.3);
    }

    .qty-num {
        width: 50px;
        text-align: center;
        border: none;
        background: transparent;
        font-weight: 700;
        font-size: 1rem;
        color: var(--pd-dark);
        outline: none;
    }

    /* Action Buttons Row */
    .btn-pd-cart {
        background: var(--pd-gradient) !important;
        border: none !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        font-size: 0.95rem !important;
        padding: 14px 28px !important;
        border-radius: 50px !important;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1) !important;
        box-shadow: 0 5px 15px rgba(194, 24, 91, 0.3) !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-pd-cart:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 8px 25px rgba(194, 24, 91, 0.45) !important;
    }

    .btn-pd-buy {
        background: linear-gradient(135deg, #CA8A04 0%, #EAB308 100%) !important;
        border: none !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        font-size: 0.95rem !important;
        padding: 14px 28px !important;
        border-radius: 50px !important;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1) !important;
        box-shadow: 0 5px 15px rgba(202, 138, 4, 0.3) !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-pd-buy:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 8px 25px rgba(202, 138, 4, 0.45) !important;
    }

    .btn-pd-wish {
        width: 52px;
        height: 52px;
        border-radius: 50% !important;
        border: 2px solid var(--pd-border) !important;
        background: #ffffff !important;
        color: var(--pd-pink-2) !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1) !important;
        padding: 0 !important;
    }

    .btn-pd-wish:hover {
        background: var(--pd-pink-light) !important;
        border-color: var(--pd-pink) !important;
        transform: translateY(-2px) scale(1.05) !important;
    }

    .btn-pd-wish.active i {
        animation: heartPulse 0.4s ease;
    }

    @keyframes heartPulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.3); }
        100% { transform: scale(1); }
    }

    .btn-pd-share {
        width: 52px;
        height: 52px;
        border-radius: 50% !important;
        border: 2px solid var(--pd-border) !important;
        background: #ffffff !important;
        color: var(--pd-gray) !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1) !important;
        padding: 0 !important;
    }

    .btn-pd-share:hover {
        background: #f7fafc !important;
        border-color: #cbd5e0 !important;
        color: var(--pd-dark) !important;
        transform: translateY(-2px) !important;
    }

    /* Premium Accordion Panel */
    .pd-accordion {
        margin-top: 35px;
        border: 1px solid var(--pd-border);
        border-radius: 20px;
        overflow: hidden;
        background: #ffffff;
    }

    .pd-accordion-item {
        border-bottom: 1px solid var(--pd-border);
    }

    .pd-accordion-item:last-child {
        border-bottom: none;
    }

    .pd-accordion-header {
        width: 100%;
        background: #ffffff;
        border: none;
        padding: 20px 24px;
        text-align: left;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 700;
        font-size: 0.95rem;
        color: var(--pd-dark);
        outline: none;
        transition: background 0.3s ease;
    }

    .pd-accordion-header:hover {
        background: var(--pd-soft);
    }

    .pd-accordion-header i.arrow-icon {
        transition: transform 0.3s ease;
        color: var(--pd-pink-2);
        font-size: 0.85rem;
    }

    .pd-accordion-header[aria-expanded="true"] i.arrow-icon {
        transform: rotate(180deg);
    }

    .pd-accordion-content {
        padding: 0 24px 24px;
        color: var(--pd-gray);
        font-size: 0.9rem;
        line-height: 1.7;
    }

    .pd-specs-table {
        width: 100%;
        margin: 0;
    }

    .pd-specs-table td {
        padding: 10px 0;
        border-bottom: 1px solid #f7fafc;
        font-size: 0.9rem;
    }

    .pd-specs-table tr:last-child td {
        border-bottom: none;
    }

    .pd-specs-label {
        font-weight: 600;
        color: var(--pd-dark-gray);
        width: 35%;
    }

    /* Dynamic Toast Notification */
    .pd-toast {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: rgba(17, 17, 17, 0.95);
        backdrop-filter: blur(10px);
        color: #ffffff;
        padding: 14px 24px;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 600;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.1);
        z-index: 9999;
        transform: translateY(20px);
        opacity: 0;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        display: flex;
        align-items: center;
    }
    
    .pd-toast.show {
        transform: translateY(0);
        opacity: 1;
    }

    /* Recommended products cards */
    .recom-card {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        border: 1px solid rgba(0, 0, 0, 0.05);
        background: #ffffff;
        position: relative;
    }

    .recom-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--pd-shadow-hover);
        border-color: rgba(212, 165, 165, 0.3);
    }

    .recom-img-container {
        position: relative;
        height: 240px;
        overflow: hidden;
    }

    .recom-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .recom-card:hover .recom-img {
        transform: scale(1.05);
    }

    .recom-float-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        background: #ff4d4f;
        color: #ffffff;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 6px;
    }

    .recom-title {
        font-weight: 700;
        font-size: 0.95rem;
        color: var(--pd-dark);
        line-height: 1.4;
        transition: color 0.2s ease;
    }

    .recom-card:hover .recom-title {
        color: var(--pd-pink-2);
    }

    .recom-price {
        color: var(--pd-pink-2);
        font-weight: 800;
        font-size: 1rem;
    }

    .btn-recom-view {
        border-radius: 50px !important;
        border: 1.5px solid var(--pd-pink) !important;
        color: var(--pd-pink-2) !important;
        font-weight: 700 !important;
        font-size: 0.8rem !important;
        transition: all 0.3s ease !important;
        background: transparent;
    }

    .btn-recom-view:hover {
        background: var(--pd-gradient) !important;
        border-color: transparent !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(181, 131, 141, 0.3);
    }

    /* Advanced Reviews Dashboard */
    .review-summary-card {
        background: var(--pd-soft);
        border: 1px solid var(--pd-border);
        border-radius: 24px;
        padding: 30px;
        text-align: center;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        box-shadow: 0 4px 20px rgba(212, 165, 165, 0.05);
    }

    .review-score-big {
        font-size: 3.5rem;
        font-weight: 800;
        color: var(--pd-dark);
        line-height: 1;
    }

    .review-count-small {
        font-size: 0.85rem;
        color: var(--pd-gray);
        font-weight: 500;
        margin-top: 8px;
    }

    /* Rating Bars Breakdowns */
    .rating-bar-container {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 8px;
        font-size: 0.85rem;
        color: var(--pd-dark-gray);
        font-weight: 600;
    }

    .rating-bar-container:last-child {
        margin-bottom: 0;
    }

    .rating-bar-track {
        flex: 1;
        height: 8px;
        background: #edf2f7;
        border-radius: 10px;
        overflow: hidden;
    }

    .rating-bar-fill {
        height: 100%;
        background: var(--pd-gradient);
        border-radius: 10px;
    }

    .rating-bar-star-num {
        width: 15px;
        text-align: left;
    }

    .rating-bar-percent {
        width: 35px;
        text-align: right;
        color: var(--pd-gray);
    }

    .btn-write-review {
        background: var(--pd-gradient);
        color: #ffffff;
        font-weight: 700;
        font-size: 0.85rem;
        padding: 10px 24px;
        border-radius: 50px;
        border: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(181, 131, 141, 0.25);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-write-review:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(181, 131, 141, 0.4);
        color: #ffffff;
    }

    /* Review items stream */
    .review-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
        background: #ffffff;
        border: 1px solid #f1f5f9;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .review-card:hover {
        border-color: var(--pd-pink);
        box-shadow: var(--pd-shadow-soft);
        transform: translateY(-2px);
    }

    .review-avatar-circle {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: var(--pd-pink-light);
        color: var(--pd-pink-2);
        font-weight: 700;
        font-size: 1.05rem;
        display: flex;
        align-items: center;
        justify-content: center;
        text-transform: uppercase;
        border: 1px solid rgba(181, 131, 141, 0.2);
    }

    .review-user-name {
        font-weight: 700;
        color: var(--pd-dark);
        font-size: 0.95rem;
    }

    .review-verified-badge {
        font-size: 0.7rem;
        font-weight: 700;
        color: var(--pd-success);
        background: #f0fff4;
        padding: 2px 8px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 3px;
        border: 1px solid rgba(56, 161, 105, 0.15);
    }

    .review-date-text {
        font-size: 0.75rem;
        color: var(--pd-gray);
        font-weight: 500;
    }

    .review-comment {
        font-size: 0.9rem;
        color: var(--pd-dark-gray);
        line-height: 1.6;
    }
</style>

<div class="container my-5 pd-container">
    <!-- Breadcrumbs Section -->
    <div class="pd-breadcrumb mb-4 d-flex align-items-center gap-2">
        <a href="{{ route('home') }}"><i class="fas fa-home me-1"></i>Home</a>
        <span class="text-muted opacity-50">/</span>
        <a href="{{ route('products.index') }}">Products</a>
        <span class="text-muted opacity-50">/</span>
        @if($product->category)
            <a href="{{ route('products.index', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a>
            <span class="text-muted opacity-50">/</span>
        @endif
        <span class="text-muted">{{ $product->name }}</span>
    </div>

    <!-- Main Grid Content -->
    <div class="row g-5">
        <!-- Left Column: Image Showcase -->
        <div class="col-lg-6">
            <div class="pd-gallery-container" x-data="{ mainImage: '{{ url('render-image?path=' . ($product->image ?? 'default.jpg')) }}' }">
                <!-- Floating Promos and Badges -->
                @if($diskonPercent > 0)
                    <span class="pd-floating-badge">-{{ $diskonPercent }}%</span>
                @elseif($populerBadge)
                    <span class="pd-floating-badge">🔥 Populer</span>
                @else
                    <span class="pd-floating-badge">🌸 Collection</span>
                @endif

                <!-- Main Card Preview -->
                <div class="pd-image-wrapper">
                    <div class="pd-zoom-wrapper">
                        <img id="mainProductImg" :src="mainImage" src="{{ url('render-image?path=' . ($product->image ?? 'default.jpg')) }}" class="pd-img img-fluid" alt="{{ $product->name }}">
                    </div>
                </div>

                <!-- Gallery Thumbnails (only if gallery array is not empty) -->
                @if(count($gallery) > 0)
                    <div class="pd-thumbnails">
                        <!-- Main image thumbnail -->
                        <button type="button" class="pd-thumb-btn" :class="{ 'active': mainImage === '{{ url('render-image?path=' . ($product->image ?? 'default.jpg')) }}' }" @click="mainImage = '{{ url('render-image?path=' . ($product->image ?? 'default.jpg')) }}'">
                            <img src="{{ url('render-image?path=' . ($product->image ?? 'default.jpg')) }}" alt="Thumbnail {{ $product->name }} Utama">
                        </button>
                        
                        <!-- Extra thumbnails -->
                        @foreach($gallery as $gImg)
                            <button type="button" class="pd-thumb-btn" :class="{ 'active': mainImage === '{{ url('render-image?path=' . $gImg) }}' }" @click="mainImage = '{{ url('render-image?path=' . $gImg) }}'">
                                <img src="{{ url('render-image?path=' . $gImg) }}" alt="Thumbnail {{ $product->name }} {{ $loop->iteration }}">
                            </button>
                        @endforeach
                    </div>
                @endif

                <!-- Bottom Features/Guarantees -->
                <div class="pd-guarantee-list">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="pd-guarantee-item">
                                <i class="fas fa-shield-alt"></i>
                                <span>100% Produk Original Import</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="pd-guarantee-item">
                                <i class="fas fa-shipping-fast"></i>
                                <span>Bebas Ongkir Min. Pembelian</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="pd-guarantee-item">
                                <i class="fas fa-undo"></i>
                                <span>30 Hari Pengembalian Mudah</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="pd-guarantee-item">
                                <i class="fas fa-heart"></i>
                                <span>Bahan Premium Lembut & Nyaman</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Specs & Buy Actions -->
        <div class="col-lg-6 d-flex flex-column justify-content-between">
            <div>
                <!-- Category and SKU Row -->
                <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                    @if($product->category)
                        <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="category-pill">
                            <i class="fas {{ $product->category->icon ?? 'fa-tag' }}"></i> {{ $product->category->name }}
                        </a>
                    @else
                        <span class="category-pill"><i class="fas fa-tag"></i> Fashion</span>
                    @endif
                    
                    <div class="sku-pill">
                        <span>SKU: {{ $product->sku ?? '-' }}</span>
                        @if($product->sku)
                            <button class="btn-copy-sku" id="skuCopyBtn" title="Salin SKU">
                                <i class="far fa-copy"></i>
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Product Name -->
                <h1 class="pd-title mb-3">{{ $product->name }}</h1>

                <!-- Rating and Statistics (Social Proof) -->
                <div class="pd-rating-block mb-4">
                    <div class="pd-stars text-warning">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($averageRating))
                                <i class="fas fa-star"></i>
                            @elseif($i - 0.5 <= $averageRating)
                                <i class="fas fa-star-half-alt"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                        <span class="text-muted ms-1 fw-bold">({{ number_format($averageRating, 1) }})</span>
                    </div>
                    
                    <div class="social-proof-bar">
                        <span class="social-stat-pill"><i class="far fa-eye me-1 text-primary"></i> {{ $product->views_count }} Dilihat</span>
                        <span class="social-stat-pill"><i class="fas fa-shopping-bag me-1 text-success"></i> {{ $product->sold_count }} Terjual</span>
                    </div>
                </div>

                <!-- Pricing Card -->
                <div class="mb-4">
                    <div class="pd-price-card">
                        @if($product->discount_price)
                            <div class="d-flex align-items-center gap-2">
                                <span class="pd-price-original">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                <span class="pd-discount-badge">{{ $diskonPercent }}% OFF</span>
                            </div>
                            <div class="pd-price-promo-row">
                                <span class="pd-price-promo">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                            </div>
                        @else
                            <div class="pd-price-promo-row">
                                <span class="pd-price-promo">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Availability Badge -->
                <div class="mb-4">
                    @if($product->stock > 0)
                        <span class="badge bg-success-subtle text-success border border-success-subtle badge-stock">
                            <i class="fas fa-check-circle"></i> Ready Stock: {{ $product->stock }} item
                        </span>
                    @else
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle badge-stock">
                            <i class="fas fa-times-circle"></i> Stok Habis
                        </span>
                    @endif
                </div>

                <!-- Interactive Qty widget and Actions via Alpine.js -->
                <div x-data="productActions({{ $product->id }}, {{ $product->stock }})">
                    @if($product->stock > 0)
                        <div class="mb-4">
                            <div class="qty-label">Pilih Jumlah</div>
                            <div class="qty-widget">
                                <button type="button" class="qty-btn" @click="if(quantity > 1) quantity--" aria-label="Kurangi jumlah"><i class="fas fa-minus"></i></button>
                                <input type="text" class="qty-num" x-model="quantity" readonly aria-label="Kuantitas produk">
                                <button type="button" class="qty-btn" @click="if(quantity < maxStock) quantity++" aria-label="Tambah jumlah"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                    @endif

                    <!-- Checkout and Shopping Forms Section -->
                    <div class="d-flex gap-3 flex-wrap align-items-center mt-3 pt-3 border-top">
                        @if($product->stock > 0)
                            <!-- Form Tambah Keranjang -->
                            <form @submit.prevent="addToCart" class="m-0 flex-grow-1 flex-md-grow-0">
                                <button type="submit" class="btn btn-pd-cart btn-lg w-100 py-3 px-4" :disabled="loadingCart">
                                    <i class="fas fa-shopping-cart" x-show="!loadingCart"></i>
                                    <i class="fas fa-spinner fa-spin" x-show="loadingCart" style="display: none;"></i> 
                                    <span x-text="loadingCart ? 'Menambahkan...' : 'Tambah Keranjang'">Tambah Keranjang</span>
                                </button>
                            </form>
                            
                            <!-- Form Beli Langsung -->
                            <form action="{{ route('checkout.direct', $product->id) }}" method="POST" class="m-0 flex-grow-1 flex-md-grow-0" @submit="loadingBuy = true">
                                @csrf
                                <input type="hidden" name="quantity" :value="quantity">
                                <button type="submit" class="btn btn-pd-buy btn-lg w-100 py-3 px-4" :disabled="loadingBuy">
                                    <i class="fas fa-bolt" x-show="!loadingBuy"></i>
                                    <i class="fas fa-spinner fa-spin" x-show="loadingBuy" style="display: none;"></i>
                                    <span x-text="loadingBuy ? 'Memproses...' : 'Beli Sekarang'">Beli Sekarang</span>
                                </button>
                            </form>
                            
                            <!-- Wishlist Toggle (AJAX) -->
                            <button type="button" class="btn btn-pd-wish btn-lg" 
                                    x-data="wishlistToggle({{ $product->isInWishlist() ? 'true' : 'false' }})"
                                    :class="{ 'active': inWishlist }"
                                    @click.prevent="toggle({{ $product->id }})"
                                    :disabled="isProcessing"
                                    :title="inWishlist ? 'Hapus dari Wishlist' : 'Tambah ke Wishlist'">
                                <i :class="inWishlist ? 'fas text-danger' : 'far'" class="fa-heart fa-lg"></i>
                            </button>
                            
                            <!-- Share Button -->
                            <button type="button" class="btn btn-pd-share btn-lg" id="btnShareProduct" title="Bagikan Produk" aria-label="Bagikan produk {{ $product->name }}">
                                <i class="fas fa-share-alt fa-lg"></i>
                            </button>
                        @else
                            <button class="btn btn-secondary btn-lg rounded-pill w-100 py-3" disabled><i class="fas fa-exclamation-circle me-2"></i> Stok Habis Sementara</button>
                        @endif
                    </div>
                </div>

            <!-- Accordion Details and Specs -->
            <div class="pd-accordion" id="productDetailAccordion">
                <!-- Deskripsi Produk -->
                <div class="pd-accordion-item">
                    <button class="pd-accordion-header" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDesc" aria-expanded="true" aria-controls="collapseDesc">
                        <span><i class="fas fa-align-left text-muted me-2"></i> Deskripsi Produk</span>
                        <i class="fas fa-chevron-down arrow-icon"></i>
                    </button>
                    <div id="collapseDesc" class="collapse show" data-bs-parent="#productDetailAccordion">
                        <div class="pd-accordion-content pt-2">
                            {{ $product->description }}
                        </div>
                    </div>
                </div>

                <!-- Spesifikasi Tambahan -->
                <div class="pd-accordion-item">
                    <button class="pd-accordion-header collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSpecs" aria-expanded="false" aria-controls="collapseSpecs">
                        <span><i class="fas fa-tasks text-muted me-2"></i> Spesifikasi Detail</span>
                        <i class="fas fa-chevron-down arrow-icon"></i>
                    </button>
                    <div id="collapseSpecs" class="collapse" data-bs-parent="#productDetailAccordion">
                        <div class="pd-accordion-content pt-2">
                            <table class="pd-specs-table">
                                <tr>
                                    <td class="pd-specs-label">Kode SKU</td>
                                    <td>{{ $product->sku ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="pd-specs-label">Kategori</td>
                                    <td>{{ $product->category->name ?? 'Pakaian Wanita' }}</td>
                                </tr>
                                <tr>
                                    <td class="pd-specs-label">Status Stok</td>
                                    <td>{{ $product->stock > 0 ? 'Ready (' . $product->stock . ' Pcs)' : 'Stok Habis' }}</td>
                                </tr>
                                <tr>
                                    <td class="pd-specs-label">Total Penjualan</td>
                                    <td>{{ $product->sold_count }} Terjual</td>
                                </tr>
                                <tr>
                                    <td class="pd-specs-label">Popularitas</td>
                                    <td>Dilihat {{ $product->views_count }} Kali</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Pengiriman & Pengembalian -->
                <div class="pd-accordion-item">
                    <button class="pd-accordion-header collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseShipping" aria-expanded="false" aria-controls="collapseShipping">
                        <span><i class="fas fa-truck text-muted me-2"></i> Pengiriman & Garansi</span>
                        <i class="fas fa-chevron-down arrow-icon"></i>
                    </button>
                    <div id="collapseShipping" class="collapse" data-bs-parent="#productDetailAccordion">
                        <div class="pd-accordion-content pt-2">
                            Kami memastikan pengemasan yang aman dan rapi untuk seluruh produk import premium kami.
                            <ul class="ps-3 mt-2 mb-0">
                                <li><strong>Pengiriman:</strong> Didukung kurir JNE, J&T, POS, TIKI, SICEPAT, GoSend, dan GrabExpress.</li>
                                <li><strong>Gratis Ongkir:</strong> Dapatkan voucher free shipping di menu voucher checkout (jika memenuhi minimum transaksi).</li>
                                <li><strong>Kebijakan Retur:</strong> Pengembalian barang maksimal 30 hari sejak barang diterima jika terdapat cacat pabrik atau ketidaksesuaian pesanan (wajib video unboxing).</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Reviews / Ulasan -->
                <div class="pd-accordion-item">
                    <button class="pd-accordion-header collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseReviews" aria-expanded="false" aria-controls="collapseReviews">
                        <span><i class="fas fa-star text-muted me-2"></i> Ulasan Pelanggan</span>
                        <i class="fas fa-chevron-down arrow-icon"></i>
                    </button>
                    <div id="collapseReviews" class="collapse" data-bs-parent="#productDetailAccordion">
                        <div class="pd-accordion-content pt-3">
                            <div class="row align-items-center mb-4">
                                <div class="col-md-4 text-center border-end">
                                    <div class="review-score-big">4.8</div>
                                    <div class="text-warning my-1">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                    <div class="review-count-small">Berdasarkan 24 Ulasan</div>
                                </div>
                                <div class="col-md-8 ps-md-4 mt-4 mt-md-0">
                                    <div class="rating-bar-container">
                                        <span class="rating-bar-star-num">5</span> <i class="fas fa-star text-warning"></i>
                                        <div class="rating-bar-track ms-2"><div class="rating-bar-fill" style="width: 85%;"></div></div>
                                        <span class="rating-bar-percent">85%</span>
                                    </div>
                                    <div class="rating-bar-container">
                                        <span class="rating-bar-star-num">4</span> <i class="fas fa-star text-warning"></i>
                                        <div class="rating-bar-track ms-2"><div class="rating-bar-fill" style="width: 10%;"></div></div>
                                        <span class="rating-bar-percent">10%</span>
                                    </div>
                                    <div class="rating-bar-container">
                                        <span class="rating-bar-star-num">3</span> <i class="fas fa-star text-warning"></i>
                                        <div class="rating-bar-track ms-2"><div class="rating-bar-fill" style="width: 5%;"></div></div>
                                        <span class="rating-bar-percent">5%</span>
                                    </div>
                                </div>
                            </div>
                            
                            <hr class="my-4 text-muted opacity-25">
                            
                            <!-- Dummy Reviews -->
                            <div class="review-list">
                                <div class="review-card p-3 mb-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="review-avatar-circle">AD</div>
                                            <div>
                                                <div class="review-user-name">Amanda D. <span class="review-verified-badge ms-2"><i class="fas fa-check-circle"></i> Verified Buyer</span></div>
                                                <div class="text-warning" style="font-size: 0.75rem;">
                                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="review-date-text">2 Hari yang lalu</span>
                                    </div>
                                    <p class="review-comment mb-0 mt-2">Bahan sangat premium dan jahitannya rapi banget. Dipakai seharian tetap nyaman dan nggak gerah. Warnanya juga sesuai dengan ekspektasi, bahkan lebih bagus aslinya. Worth every penny!</p>
                                </div>

                                <div class="review-card p-3 mb-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="review-avatar-circle">SB</div>
                                            <div>
                                                <div class="review-user-name">Sarah B. <span class="review-verified-badge ms-2"><i class="fas fa-check-circle"></i> Verified Buyer</span></div>
                                                <div class="text-warning" style="font-size: 0.75rem;">
                                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="review-date-text">1 Minggu yang lalu</span>
                                    </div>
                                    <p class="review-comment mb-0 mt-2">Ukurannya pas banget di badan, modelnya elegan dan gampang di-mix and match. Pengirimannya juga cepet banget. Puas belanja di sini, bakal order lagi next time.</p>
                                </div>
                            </div>

                            @if($canReview)
                            <div class="text-center mt-4">
                                <a href="#" class="btn-write-review">
                                    <i class="fas fa-pen"></i> Tulis Ulasan Anda
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products Showcase Section -->
    @if($relatedProducts->count() > 0)
    <div class="mt-5 pt-5 border-top">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <span class="text-uppercase text-muted fw-bold small tracking-wider" style="letter-spacing: 1px;">Koleksi Serupa</span>
                <h3 class="fw-bold text-dark m-0">Rekomendasi Untuk Anda</h3>
            </div>
            <a href="{{ route('products.index', ['category' => $product->category->slug ?? '']) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-4">Lihat Semua</a>
        </div>
        
        <div class="row">
            @foreach($relatedProducts as $related)
            @php
                $relDisPercent = 0;
                if ($related->discount_price && $related->price > 0) {
                    $relDisPercent = round((($related->price - $related->discount_price) / $related->price) * 100);
                }
            @endphp
            <div class="col-lg-3 col-md-4 col-6 mb-4">
                <div class="card recom-card h-100 d-flex flex-column justify-content-between">
                    <div class="recom-img-container">
                        <img src="{{ url('render-image?path=' . ($related->image ?? 'default.jpg')) }}" class="recom-img" alt="{{ $related->name }}">
                        @if($relDisPercent > 0)
                            <span class="recom-float-badge">-{{ $relDisPercent }}%</span>
                        @endif
                    </div>
                    <div class="card-body p-3 d-flex flex-column justify-content-between flex-grow-1">
                        <div>
                            <h6 class="recom-title mb-2 text-truncate-2">{{ Str::limit($related->name, 38) }}</h6>
                            <div class="d-flex flex-column mb-3">
                                @if($related->discount_price)
                                    <span class="text-muted text-decoration-line-through small">Rp {{ number_format($related->price, 0, ',', '.') }}</span>
                                    <span class="recom-price">Rp {{ number_format($related->discount_price, 0, ',', '.') }}</span>
                                @else
                                    <span class="recom-price">Rp {{ number_format($related->price, 0, ',', '.') }}</span>
                                @endif
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('products.show', $related->slug) }}" class="btn btn-recom-view btn-sm w-100 py-2">
                                <i class="far fa-eye me-1"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Reviews and Ratings Dashboard -->
    <div class="mt-5 pt-5 border-top" id="reviewsContainer">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div>
                <span class="text-uppercase text-muted fw-bold small tracking-wider" style="letter-spacing: 1px;">Testimoni Pelanggan</span>
                <h3 class="fw-bold text-dark m-0">Ulasan & Rating Produk</h3>
            </div>
            
            @if($userRating)
                <a href="{{ route('ratings.edit', $userRating->id) }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 btn-sm fw-bold">
                    <i class="fas fa-edit me-2"></i> Edit Ulasan Anda
                </a>
            @endif
        </div>

        <div class="row g-4">
            <!-- Left Side: Ratings Breakdown Statistics -->
            <div class="col-lg-4">
                <div class="review-summary-card">
                    <span class="review-score-big">{{ number_format($averageRating, 1) }}</span>
                    
                    <div class="text-warning my-2" style="font-size: 1.25rem;">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($averageRating))
                                <i class="fas fa-star"></i>
                            @elseif($i - 0.5 <= $averageRating)
                                <i class="fas fa-star-half-alt"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </div>
                    
                    <span class="review-count-small">Berdasarkan {{ $reviews->count() }} Ulasan</span>
                    
                    <!-- Progress Bar Stars Distributions -->
                    @php
                        $totalReviews = $reviews->count();
                        $starCounts = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
                        foreach($reviews as $rev) {
                            $r = (int)$rev->rating;
                            if(isset($starCounts[$r])) {
                                $starCounts[$r]++;
                            }
                        }
                    @endphp
                    
                    <div class="w-100 mt-4 px-2">
                        @for($star = 5; $star >= 1; $star--)
                            @php
                                $percent = $totalReviews > 0 ? ($starCounts[$star] / $totalReviews) * 100 : 0;
                            @endphp
                            <div class="rating-bar-container">
                                <span class="rating-bar-star-num">{{ $star }}</span>
                                <i class="fas fa-star text-warning" style="font-size: 0.75rem;"></i>
                                <div class="rating-bar-track">
                                    <div class="rating-bar-fill" style="width: {{ $percent }}%;"></div>
                                </div>
                                <span class="rating-bar-percent">{{ round($percent) }}%</span>
                            </div>
                        @endfor
                    </div>
                    
                    @if($canReview)
                        <div class="mt-4">
                            <a href="{{ route('ratings.create', $product->id) }}" class="btn btn-write-review">
                                <i class="fas fa-pen"></i> Tulis Ulasan Produk
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Side: Reviews List Feed -->
            <div class="col-lg-8" x-data="reviewsLoader({{ $product->id }}, {{ $reviews->currentPage() }}, {{ $reviews->hasMorePages() ? 'true' : 'false' }})">
                <div class="row g-3" id="reviewsListArea">
                    @forelse($reviews as $review)
                        @include('components.review-card', ['review' => $review])
                    @empty
                        <div class="col-12" id="emptyReviewsState">
                            <div class="card border border-dashed rounded-4 p-5 text-center text-muted bg-light">
                                <div class="mb-3">
                                    <i class="far fa-comment-dots fa-3x opacity-25"></i>
                                </div>
                                <h5 class="fw-bold text-dark mb-1">Belum Ada Ulasan</h5>
                                <p class="mb-0 text-muted small px-lg-5">Produk ini belum menerima ulasan dari pembeli. Bagikan pengalaman berbelanja Anda jika Anda telah membeli produk ini!</p>
                                
                                @if($canReview)
                                    <div class="mt-4">
                                        <a href="{{ route('ratings.create', $product->id) }}" class="btn btn-write-review">
                                            <i class="fas fa-pen"></i> Mulai Ulas Pertama Kali
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforelse
                </div>
                
                <div class="text-center mt-4" x-show="hasMore">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4 py-2" @click="loadMore" :disabled="loadingReviews">
                        <span x-show="!loadingReviews">Muat Lebih Banyak Ulasan</span>
                        <span x-show="loadingReviews" style="display: none;"><i class="fas fa-spinner fa-spin me-2"></i> Memuat...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Alpine Components Data
    document.addEventListener('alpine:init', () => {
        Alpine.data('productActions', (productId, maxStock) => ({
            quantity: 1,
            maxStock: maxStock,
            loadingCart: false,
            loadingBuy: false,
            productId: productId,
            
            addToCart() {
                this.loadingCart = true;
                axios.post('{{ route('cart.add') }}', {
                    product_id: this.productId,
                    quantity: this.quantity
                }).then(response => {
                    this.loadingCart = false;
                    if (response.data.success) {
                        const toast = document.createElement('div');
                        toast.className = 'pd-toast';
                        toast.innerHTML = '<i class="fas fa-check-circle text-success me-2"></i> Produk ditambahkan ke keranjang!';
                        document.body.appendChild(toast);
                        setTimeout(() => toast.classList.add('show'), 50);
                        setTimeout(() => {
                            toast.classList.remove('show');
                            setTimeout(() => toast.remove(), 400);
                        }, 2500);
                        
                        // Update cart badge if function exists (from layout)
                        if (typeof updateCartBadge === 'function') {
                            updateCartBadge(response.data.cart_count);
                        }
                    }
                }).catch(error => {
                    this.loadingCart = false;
                    console.error('Error adding to cart:', error);
                    alert('Gagal menambahkan ke keranjang. Silakan coba lagi.');
                });
            }
        }));

        Alpine.data('reviewsLoader', (productId, currentPage, initialHasMore) => ({
            productId: productId,
            currentPage: currentPage,
            hasMore: initialHasMore,
            loadingReviews: false,
            
            loadMore() {
                if(this.loadingReviews || !this.hasMore) return;
                
                this.loadingReviews = true;
                this.currentPage++;
                
                axios.get(`{{ url()->current() }}`, {
                    params: {
                        page: this.currentPage,
                        load_reviews: 1
                    },
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }).then(response => {
                    this.loadingReviews = false;
                    if(response.data.html) {
                        document.getElementById('reviewsListArea').insertAdjacentHTML('beforeend', response.data.html);
                    }
                    this.hasMore = response.data.hasMore;
                }).catch(error => {
                    this.loadingReviews = false;
                    console.error('Error loading reviews:', error);
                });
            }
        }));
    });

document.addEventListener('DOMContentLoaded', function () {
    // 2. Custom SKU Copy to Clipboard function
    const skuCopyBtn = document.getElementById('skuCopyBtn');
    const skuText = "{{ $product->sku ?? '' }}";
    
    if (skuCopyBtn && skuText) {
        skuCopyBtn.addEventListener('click', function () {
            navigator.clipboard.writeText(skuText).then(() => {
                const toast = document.createElement('div');
                toast.className = 'pd-toast';
                toast.innerHTML = '<i class="fas fa-check-circle text-success me-2"></i> SKU ' + skuText + ' disalin ke papan klip!';
                document.body.appendChild(toast);
                setTimeout(() => toast.classList.add('show'), 50);
                setTimeout(() => {
                    toast.classList.remove('show');
                    setTimeout(() => toast.remove(), 400);
                }, 2500);
            });
        });
    }

    // 3. Link share copier
    const btnShare = document.getElementById('btnShareProduct');
    if (btnShare) {
        btnShare.addEventListener('click', function (e) {
            e.preventDefault();
            navigator.clipboard.writeText(window.location.href).then(() => {
                const toast = document.createElement('div');
                toast.className = 'pd-toast';
                toast.innerHTML = '<i class="fas fa-share-alt text-primary me-2"></i> Tautan produk berhasil disalin!';
                document.body.appendChild(toast);
                setTimeout(() => toast.classList.add('show'), 50);
                setTimeout(() => {
                    toast.classList.remove('show');
                    setTimeout(() => toast.remove(), 400);
                }, 2500);
            });
        });
    }

    // 4. Interactive Image Gallery Switcher
    const mainImg = document.getElementById('mainProductImg');
    const thumbs = document.querySelectorAll('.pd-thumb-btn');
    if (mainImg && thumbs.length > 0) {
        thumbs.forEach(thumb => {
            thumb.addEventListener('click', function () {
                thumbs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                
                const newSrc = this.getAttribute('data-large');
                mainImg.style.opacity = '0.2';
                setTimeout(() => {
                    mainImg.src = newSrc;
                    mainImg.style.opacity = '1';
                }, 150);
            });
        });
    }



    // 6. Login Required Modal for Product Detail
    function showPdLoginModal() {
        const existing = document.getElementById('pdLoginModal');
        if (existing) existing.remove();

        const modal = document.createElement('div');
        modal.id = 'pdLoginModal';
        modal.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;z-index:10002;display:flex;align-items:center;justify-content:center;opacity:0;transition:opacity 0.3s ease;';
        modal.innerHTML = `
            <div style="position:absolute;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.7);backdrop-filter:blur(5px);" id="pdLoginOverlay"></div>
            <div style="position:relative;background:white;border-radius:20px;padding:40px;max-width:400px;width:90%;text-align:center;transform:scale(0.9);transition:transform 0.3s ease;z-index:2;box-shadow:0 10px 25px rgba(0,0,0,0.2);" id="pdLoginContent">
                <button id="pdLoginClose" style="position:absolute;top:15px;right:20px;font-size:1.5rem;background:none;border:none;cursor:pointer;color:#999;transition:color 0.3s;">&times;</button>
                <div style="display:flex;justify-content:center;margin-bottom:1.5rem;">
                    <i class="fas fa-heart" style="font-size:48px;color:var(--pd-pink);"></i>
                </div>
                <h3 style="font-size:1.5rem;margin-bottom:0.5rem;font-weight:600;color:#1a1a1a;">Login Dibutuhkan</h3>
                <p style="color:#666;font-size:0.9rem;margin-bottom:1.5rem;">Silakan login atau daftar untuk menyimpan produk ke wishlist favorit Anda.</p>
                <div style="display:flex;gap:15px;justify-content:center;margin-bottom:1rem;">
                    <a href="{{ route('login') }}" style="padding:10px 25px;border-radius:50px;text-decoration:none;font-weight:500;font-size:0.9rem;background:#1a1a1a;color:white;transition:all 0.3s;">Login</a>
                    <a href="{{ route('register') }}" style="padding:10px 25px;border-radius:50px;text-decoration:none;font-weight:500;font-size:0.9rem;background:#f0f0f0;color:#1a1a1a;transition:all 0.3s;">Daftar</a>
                </div>
                <p style="font-size:0.75rem;color:#999;margin:0;">Halaman akan otomatis dialihkan kembali setelah login</p>
            </div>
        `;
        document.body.appendChild(modal);

        localStorage.setItem('redirect_after_login', window.location.pathname + window.location.search);

        setTimeout(() => {
            modal.style.opacity = '1';
            document.getElementById('pdLoginContent').style.transform = 'scale(1)';
        }, 10);

        const closeModal = () => {
            modal.style.opacity = '0';
            document.getElementById('pdLoginContent').style.transform = 'scale(0.9)';
            setTimeout(() => modal.remove(), 300);
        };
        document.getElementById('pdLoginClose').addEventListener('click', closeModal);
        document.getElementById('pdLoginOverlay').addEventListener('click', closeModal);
    }
});
</script>
@endpush
@endsection