@extends('layouts.admin')

@section('title', 'Edit Produk - Admin')

@section('content')
<link rel="stylesheet" href="{{ asset('css/produk-admin.css') }}">

<div class="admin-page-container">
    <!-- Header -->
    <div class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-3xl font-black text-navy-dark uppercase tracking-tighter">Edit Produk</h1>
            <p class="text-gray-400 text-sm">Dashboard / Edit / 
                <span class="text-orange-brand font-bold">{{ $product->name }}</span>
            </p>
        </div>
        <a href="{{ route('admin.produk.index') }}" class="btn-admin-secondary">
            <i data-lucide="x"></i> BATALKAN
        </a>
    </div>

    <!-- Form Card -->
    <div class="admin-card-form reveal">
        <form action="{{ route('admin.produk.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                
                <!-- SISI KIRI: EDIT GAMBAR -->
                <div class="form-image-section">
                    <label class="form-label-premium">Foto Produk Saat Ini</label>
                    <div class="image-upload-wrapper">
                        <img id="preview" src="{{ asset('uploads/products/' . $product->image) }}" class="img-preview-big">
                        <div class="upload-overlay">
                            <input type="file" name="image" id="imageInput" accept="image/*" onchange="previewImage(event)">
                            <div class="upload-texts">
                                <i data-lucide="refresh-cw" class="w-10 h-10 mb-2"></i>
                                <span>Klik untuk ganti foto</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-[10px] text-gray-400 mt-3 italic text-center">Biarkan kosong jika tidak ingin mengubah gambar.</p>
                </div>

                <!-- SISI KANAN: UPDATE DATA -->
                <div class="form-inputs-section">
                    <div class="input-group-premium">
                        <label>NAMA PRODUK</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required>
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        <div class="input-group-premium">
                            <label>KATEGORI</label>
                            <select name="category" required>
                                <option value="Makanan Berat" {{ $product->category == 'Makanan Berat' ? 'selected' : '' }}>Makanan Berat</option>
                                <option value="Camilan" {{ $product->category == 'Camilan' ? 'selected' : '' }}>Camilan</option>
                                <option value="Minuman" {{ $product->category == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                            </select>
                        </div>
                        <div class="input-group-premium">
                            <label>HARGA (RP)</label>
                            <input type="number" name="price" value="{{ old('price', $product->price) }}" required>
                        </div>
                    </div>

                    <div class="input-group-premium">
                        <label>DESKRIPSI PRODUK</label>
                        <textarea name="description" rows="5">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <button type="submit" class="btn-admin-submit-premium">
                        <i data-lucide="save"></i> SIMPAN PERUBAHAN
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