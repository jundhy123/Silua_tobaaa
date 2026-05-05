@extends('layouts.admin')

@section('title', 'Tambah Produk - Admin')

@section('content')
<link rel="stylesheet" href="{{ asset('css/produk-admin.css') }}">

<div class="admin-page-container">
    <!-- Header -->
    <div class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-3xl font-black text-navy-dark uppercase tracking-tighter">Tambah Produk</h1>
            <p class="text-gray-400 text-sm">Produk / Baru / 
                <span class="text-orange-brand font-bold">{{ $profiles->company_name ?? 'Silua Toba' }}</span>
            </p>
        </div>
        <a href="{{ route('admin.produk.index') }}" class="btn-admin-secondary">
            <i data-lucide="arrow-left"></i> KEMBALI
        </a>
    </div>

    <!-- Form Card -->
    <div class="admin-card-form reveal">
        <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                
                <!-- SISI KIRI: UPLOAD GAMBAR -->
                <div class="form-image-section">
                    <label class="form-label-premium">Foto Produk</label>
                    <div class="image-upload-wrapper">
                        <img id="preview" src="{{ asset('images/placeholder-img.png') }}" class="img-preview-big">
                        <div class="upload-overlay">
                            <input type="file" name="image" id="imageInput" accept="image/*" required onchange="previewImage(event)">
                            <div class="upload-texts">
                                <i data-lucide="camera" class="w-10 h-10 mb-2"></i>
                                <span>Klik untuk upload foto</span>
                                <small>Maksimal 2MB (JPG, PNG, WEBP)</small>
                            </div>
                        </div>
                    </div>
                    @error('image') <span class="text-red-500 text-xs font-bold mt-2">{{ $message }}</span> @enderror
                </div>

                <!-- SISI KANAN: DATA PRODUK -->
                <div class="form-inputs-section">
                    <div class="input-group-premium">
                        <label>NAMA PRODUK</label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Rendang Daging" required>
                        @error('name') <span class="error-text">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        <div class="input-group-premium">
                            <label>KATEGORI</label>
                            <select name="category" required>
                                <option value="" disabled selected>Pilih Kategori</option>
                                <option value="Makanan Berat">Makanan Berat</option>
                                <option value="Camilan">Camilan</option>
                                <option value="Minuman">Minuman</option>
                            </select>
                        </div>
                        <div class="input-group-premium">
                            <label>HARGA (RP)</label>
                            <input type="number" name="price" value="{{ old('price') }}" placeholder="45000" required>
                            @error('price') <span class="error-text">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="input-group-premium">
                        <label>DESKRIPSI PRODUK</label>
                        <textarea name="description" rows="5" placeholder="Tuliskan detail rasa dan bahan...">{{ old('description') }}</textarea>
                    </div>

                    <button type="submit" class="btn-admin-submit-premium">
                        <i data-lucide="check-circle"></i> SIMPAN PRODUK SEKARANG
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection