@extends('layouts.admin')

@section('title', 'Tambah Banner')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Tambah Banner</h1>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Judul Banner *</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Sub-judul Banner (Opsional)</label>
                            <input type="text" name="subtitle" class="form-control @error('subtitle') is-invalid @enderror" value="{{ old('subtitle') }}" placeholder="Contoh: Koleksi Premium Terkini">
                            @error('subtitle')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi Banner (Opsional)</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="Contoh: Temukan dress modern dengan bahan premium untuk gaya elegan Anda.">{{ old('description') }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gambar Banner *</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" required onchange="previewImage(this)">
                            <small class="text-muted">Format: JPG, JPEG, PNG. Max: 2MB. Rasio lebar (1600×600 atau 1920×800) direkomendasikan untuk tampilan optimal.</small>
                            @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror

                            <!-- Preview Image -->
                            <div class="mt-2" id="imagePreviewContainer" style="display: none;">
                                <div style="width: 100%; max-width: 480px; aspect-ratio: 16/6; overflow: hidden; border-radius: 10px; border: 1px solid #ddd;">
                                    <img id="imagePreview" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <small class="text-success mt-1 d-block">Preview gambar banner (rasio lebar)</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Link (URL Tujuan)</label>
                            <input type="text" name="link" class="form-control @error('link') is-invalid @enderror" value="{{ old('link') }}" placeholder="Contoh: /products">
                            <small class="text-muted">Kosongkan jika tidak ingin diklik</small>
                            @error('link')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Urutan</label>
                            <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', 0) }}">
                            <small class="text-muted">Semakin kecil angka, semakin atas tampilannya</small>
                            @error('order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Mulai (Opsional)</label>
                            <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}">
                            @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Berakhir (Opsional)</label>
                            <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}">
                            <small class="text-muted">Kosongkan jika selamanya</small>
                            @error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1" class="form-check-input" {{ old('is_active', 1) ? 'checked' : '' }}>
                                <label class="form-check-label">Aktif</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewImage(input) {
        const previewContainer = document.getElementById('imagePreviewContainer');
        const preview = document.getElementById('imagePreview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.style.display = 'block';
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            previewContainer.style.display = 'none';
        }
    }
</script>
@endpush