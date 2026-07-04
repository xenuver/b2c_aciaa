@extends('layouts.app')

@section('title', 'Beri Ulasan - ' . $product->name)

@section('content')
<style>
    :root {
        --pd-pink: var(--color-primary);
        --pd-pink-2: var(--color-primary-light);
        --pd-soft: var(--color-surface-alt);
        --pd-dark: #111111;
        --pd-border: #ede6e4;
        --pd-warning: #fbbf24;
        --pd-shadow-soft: 0 10px 40px rgba(194, 24, 91, 0.08);
        --pd-gradient: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-light) 100%);
    }

    .form-container {
        font-family: 'Montserrat', 'Montserrat', sans-serif;
    }

    .premium-card {
        border: 1px solid var(--pd-border);
        border-radius: 24px;
        background: #ffffff;
        box-shadow: var(--pd-shadow-soft);
        overflow: hidden;
    }

    .card-header-gradient {
        background: linear-gradient(135deg, #151528 0%, #0f0f1b 100%);
        color: #ffffff;
        padding: 1.5rem 2rem;
        border-bottom: none;
    }

    .product-preview {
        background: var(--pd-soft);
        border-radius: 16px;
        padding: 1.25rem;
        border: 1px solid rgba(194, 24, 91, 0.15);
    }

    .stars-input-container {
        background: #fafafa;
        border: 1px solid #f1f5f9;
        border-radius: 16px;
        padding: 1.5rem;
        text-align: center;
    }

    .stars i {
        font-size: 2.75rem;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        color: #e2e8f0;
    }

    .stars i.active {
        color: var(--pd-warning);
        transform: scale(1.1);
        filter: drop-shadow(0 0 8px rgba(251, 191, 36, 0.3));
    }

    .stars i:hover {
        transform: scale(1.2);
    }

    .image-upload-area {
        border: 2px dashed var(--pd-pink);
        background: var(--pd-soft);
        border-radius: 16px;
        padding: 2rem 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .image-upload-area:hover {
        border-color: var(--pd-pink-2);
        background: #fdf2f0;
        transform: translateY(-2px);
    }

    .preview-img-card {
        width: 85px;
        height: 85px;
        object-fit: cover;
        border-radius: 12px;
        position: relative;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        border: 2px solid #ffffff;
    }

    .remove-img-badge {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 24px;
        height: 24px;
        background: #ef4444;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 14px;
        font-weight: bold;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        transition: all 0.2s;
    }

    .remove-img-badge:hover {
        transform: scale(1.15);
        background: #dc2626;
    }

    .btn-submit-premium {
        background: var(--pd-gradient);
        border: none;
        color: #ffffff;
        font-weight: 700;
        font-size: 0.95rem;
        padding: 12px 28px;
        border-radius: 50px;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 5px 15px rgba(233, 30, 140, 0.3);
    }

    .btn-submit-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(233, 30, 140, 0.45);
        color: #ffffff;
    }

    .btn-back-premium {
        background: #ffffff;
        color: var(--pd-dark);
        border: 2px solid var(--pd-border);
        font-weight: 700;
        font-size: 0.95rem;
        padding: 10px 24px;
        border-radius: 50px;
        transition: all 0.2s;
    }

    .btn-back-premium:hover {
        background: var(--pd-soft);
        border-color: var(--pd-pink);
    }
</style>

<div class="container my-5 form-container">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card premium-card border-0">
                <div class="card-header card-header-gradient">
                    <h4 class="mb-1 fw-bold"><i class="fas fa-pen-fancy me-2"></i> Tulis Ulasan Produk</h4>
                    <p class="mb-0 text-white-50 small">Berikan penilaian jujur untuk membantu pelanggan lainnya</p>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    <!-- Product Information Header -->
                    <div class="product-preview d-flex align-items-center gap-3 mb-4">
                        <img src="{{ url('render-image?path=' . ($product->image ?? 'default.jpg')) }}" 
                             alt="{{ $product->name }}" 
                             style="width: 70px; height: 70px; object-fit: cover; border-radius: 12px;">
                        <div class="text-start">
                            <span class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Produk yang Anda Beli</span>
                            <h5 class="mb-0 fw-bold text-dark mt-0.5" style="font-size: 1.05rem;">{{ $product->name }}</h5>
                        </div>
                    </div>

                

                    @if($errors->any())
                        <div class="alert alert-danger rounded-4 border-0 p-3 mb-4" style="background-color: #fef2f2; color: #991b1b;">
                            <ul class="mb-0 small">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ url('/ratings') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="product_slug" value="{{ $product->slug }}">
                        <input type="hidden" name="transaction_id" value="{{ $transactionId }}">

                        <!-- Honeypot anti-bot check -->
                        <input type="text" name="website_url" style="display:none !important;" tabindex="-1" autocomplete="off">

                        <!-- Rating Stars Selector -->
                        <div class="mb-4 text-start">
                            <label class="form-label fw-bold text-dark mb-2">Rating Anda <span class="text-danger">*</span></label>
                            <div class="stars-input-container">
                                <div class="stars d-flex justify-content-center gap-3">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="far fa-star" data-value="{{ $i }}"></i>
                                    @endfor
                                </div>
                                <input type="hidden" name="rating" id="ratingValue" required>
                                <div class="mt-3 fw-bold text-muted" id="ratingLabel" style="font-size: 0.9rem;">Pilih bintang untuk memberi nilai</div>
                            </div>
                        </div>

                        <!-- Review Text Area -->
                        <div class="mb-4 text-start">
                            <label class="form-label fw-bold text-dark mb-2">Ulasan Anda <span class="text-danger">*</span></label>
                            <textarea name="review" class="form-control p-3 @error('review') is-invalid @enderror" 
                                      rows="5" placeholder="Bagikan detail pengalaman Anda menggunakan produk ini. Bagaimana bahan, kenyamanan, atau pengirimannya?" 
                                      style="border-radius: 16px; border-color: var(--pd-border); resize: none; font-size: 0.9rem; line-height: 1.6;">{{ old('review') }}</textarea>
                            @error('review')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="form-text text-muted small mt-1.5"><i class="fas fa-info-circle me-1"></i> Minimal 10 karakter. Ulasan yang sopan membantu komunitas toko kami tetap positif.</div>
                        </div>

                        <!-- File upload dropzone -->
                        <div class="mb-4 text-start">
                            <label class="form-label fw-bold text-dark mb-2">Unggah Foto Produk <span class="text-muted">(Opsional)</span></label>
                            <div class="image-upload-area" id="dropzone">
                                <input type="file" name="images[]" id="imageInput" class="d-none" accept="image/*" multiple>
                                <div id="dropzoneContent">
                                    <i class="fas fa-cloud-upload-alt fa-3x mb-3 text-muted" style="color: var(--pd-pink-2) !important;"></i>
                                    <h6 class="fw-bold mb-1">Pilih atau Drag Foto ke Sini</h6>
                                    <p class="text-muted small mb-0">Maksimal 5 foto produk (format JPG, PNG, maksimal 2MB per file)</p>
                                </div>
                            </div>
                            <div id="imagePreview" class="d-flex flex-wrap gap-3 mt-3"></div>
                            @error('images.*')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <!-- Notice box -->
                        <div class="alert alert-info rounded-4 border-0 p-3 mb-4 d-flex align-items-start gap-2 text-start" style="background-color: var(--pd-soft); color: var(--pd-pink-2);">
                            <i class="fas fa-info-circle mt-1"></i>
                            <span class="small">Ulasan yang mengandung unsur promosi, spam, perjudian, atau tautan luar akan otomatis ditahan oleh sistem keamanan kami untuk ditinjau oleh Admin terlebih dahulu.</span>
                        </div>

                        <!-- Buttons actions -->
                        <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top flex-wrap gap-2">
                            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-back-premium text-decoration-none">
                                <i class="fas fa-arrow-left me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-submit-premium">
                                <i class="fas fa-paper-plane me-1"></i> Kirim Ulasan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ========== RATING STARS ACTION ==========
    const stars = document.querySelectorAll('.stars i');
    const ratingInput = document.getElementById('ratingValue');
    const ratingLabel = document.getElementById('ratingLabel');
    
    const ratingTexts = {
        1: 'Sangat Buruk - Kecewa dengan produk ini',
        2: 'Buruk - Kurang sesuai deskripsi & harapan',
        3: 'Cukup - Sesuai dengan harga produk',
        4: 'Bagus - Puas dengan kualitas produk',
        5: 'Sangat Bagus - Sangat puas! Recommended!'
    };
    
    stars.forEach(star => {
        star.addEventListener('click', function() {
            const value = parseInt(this.dataset.value);
            ratingInput.value = value;
            
            stars.forEach((s, index) => {
                if (index < value) {
                    s.classList.remove('far');
                    s.classList.add('fas');
                    s.classList.add('active');
                } else {
                    s.classList.remove('fas');
                    s.classList.add('far');
                    s.classList.remove('active');
                }
            });
            
            ratingLabel.innerHTML = `<span style="color: var(--pd-pink-2);">${ratingTexts[value]}</span>`;
        });
        
        star.addEventListener('mouseenter', function() {
            const value = parseInt(this.dataset.value);
            stars.forEach((s, index) => {
                if (index < value) {
                    s.classList.remove('far');
                    s.classList.add('fas');
                } else if (!s.classList.contains('active')) {
                    s.classList.remove('fas');
                    s.classList.add('far');
                }
            });
        });
        
        star.addEventListener('mouseleave', function() {
            const currentValue = parseInt(ratingInput.value) || 0;
            stars.forEach((s, index) => {
                if (index < currentValue && s.classList.contains('active')) {
                    s.classList.remove('far');
                    s.classList.add('fas');
                } else if (!s.classList.contains('active')) {
                    s.classList.remove('fas');
                    s.classList.add('far');
                }
            });
        });
    });
    
    // ========== DRAG AND DROP PREVIEW IMAGE ==========
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const dropzone = document.getElementById('dropzone');
    let selectedFiles = [];
    
    dropzone.addEventListener('click', function() {
        imageInput.click();
    });
    
    imageInput.addEventListener('change', function(e) {
        const files = Array.from(e.target.files);
        selectedFiles = [...selectedFiles, ...files];
        
        if (selectedFiles.length > 5) {
            alert('Maksimal upload 5 foto produk!');
            selectedFiles = selectedFiles.slice(0, 5);
        }
        
        updateImagePreview();
        updateFileInput();
    });
    
    function updateImagePreview() {
        imagePreview.innerHTML = '';
        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewContainer = document.createElement('div');
                previewContainer.style.position = 'relative';
                previewContainer.style.display = 'inline-block';
                previewContainer.innerHTML = `
                    <img src="${e.target.result}" class="preview-img-card" alt="Preview foto ulasan">
                    <span class="remove-img-badge" data-index="${index}">&times;</span>
                `;
                imagePreview.appendChild(previewContainer);
                
                previewContainer.querySelector('.remove-img-badge').addEventListener('click', function() {
                    selectedFiles.splice(index, 1);
                    updateImagePreview();
                    updateFileInput();
                });
            };
            reader.readAsDataURL(file);
        });
    }
    
    function updateFileInput() {
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => dataTransfer.items.add(file));
        imageInput.files = dataTransfer.files;
    }
    
    // Drag & Drop event list
    dropzone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropzone.style.borderColor = 'var(--pd-pink-2)';
        dropzone.style.background = '#fdf2f0';
    });
    
    dropzone.addEventListener('dragleave', () => {
        dropzone.style.borderColor = 'var(--pd-pink)';
        dropzone.style.background = 'var(--pd-soft)';
    });
    
    dropzone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropzone.style.borderColor = 'var(--pd-pink)';
        dropzone.style.background = 'var(--pd-soft)';
        
        const files = Array.from(e.dataTransfer.files).filter(file => file.type.startsWith('image/'));
        selectedFiles = [...selectedFiles, ...files];
        
        if (selectedFiles.length > 5) {
            alert('Maksimal upload 5 foto produk!');
            selectedFiles = selectedFiles.slice(0, 5);
        }
        
        updateImagePreview();
        updateFileInput();
    });
});
</script>
@endsection