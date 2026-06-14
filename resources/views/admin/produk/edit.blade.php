@extends('layouts.admin')

@section('title', 'Ubah Produk - Admin Silua Toba')
@section('page_title', 'Update Inventaris')

@section('content')
<style>
    :root { --primary-orange: #FF5722; }
    .text-primary-orange { color: var(--primary-orange); }
    .bg-primary-orange { background-color: var(--primary-orange); }

    .form-card {
        background: white;
        border-radius: 3.5rem;
        padding: 4rem;
        border: 1px solid #f1f5f9;
    }
    .form-label {
        display: block;
        font-size: 10px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.2em;
        color: #94a3b8;
        margin-bottom: 1rem;
    }
    .form-input {
        width: 100%;
        padding: 1.25rem 1.5rem;
        background: #f8fafc;
        border: 2px solid transparent;
        border-radius: 1.25rem;
        font-size: 0.95rem;
        color: #1e293b;
        transition: all 0.3s ease;
    }
    .form-input:focus {
        background: white;
        border-color: var(--primary-orange);
        outline: none;
        box-shadow: 0 10px 25px -5px rgba(255, 87, 34, 0.1);
    }
    .image-upload-box {
        aspect-ratio: 1;
        background: #f8fafc;
        border: 3px dashed #e2e8f0;
        border-radius: 2.5rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
    }
    .image-upload-box:hover {
        border-color: var(--primary-orange);
        background: white;
    }
    .btn-save {
        background: #111;
        color: white;
        padding: 1.25rem 2.5rem;
        border-radius: 1.25rem;
        font-weight: 800;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        transition: all 0.3s ease;
        width: 100%;
    }
    .btn-save:hover {
        background: var(--primary-orange);
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(255, 87, 34, 0.2);
    }
</style>

<div class="max-w-5xl mx-auto space-y-10 animate-fade-in">
    <!-- HEADER -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h1 class="text-4xl font-black italic text-gray-900" style="font-family: 'Playfair Display', serif;">Ubah <span class="text-primary-orange">Detail Produk</span></h1>
            <p class="text-gray-400 text-sm mt-1 italic">Perbarui informasi untuk koleksi <b>{{ $product->name }}</b>.</p>
        </div>
        <a href="{{ route('admin.produk.index') }}" class="px-6 py-3 bg-white border border-gray-100 text-gray-400 rounded-xl font-black uppercase tracking-widest text-[10px] hover:bg-gray-900 hover:text-white transition-all shadow-sm flex items-center gap-2">
            <i data-lucide="x" class="w-4 h-4"></i>
            Batalkan
        </a>
    </div>

    <!-- FORM CARD -->
    <div class="form-card shadow-sm">
        <form action="{{ route('admin.produk.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            @csrf
            @method('PUT')
            <!-- LEFT: IMAGE UPLOAD -->
            <div class="lg:col-span-4 space-y-4">
                <label class="form-label">Visual Produk</label>
                <div class="image-upload-box group" onclick="document.getElementById('imageInput').click()">
                    <img id="preview" src="{{ asset('uploads/products/' . $product->image) }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 flex flex-col items-center justify-center bg-gray-900/40 opacity-0 group-hover:opacity-100 transition-all">
                        <i data-lucide="refresh-cw" class="w-8 h-8 text-white"></i>
                        <span class="text-[9px] font-black text-white uppercase mt-2 tracking-widest">Ganti Foto</span>
                    </div>
                </div>
                <input type="file" name="image" id="imageInput" accept="image/*" class="hidden" onchange="previewImage(event)">
                <div class="p-6 bg-gray-50 rounded-[2rem] border border-gray-100">
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Identitas Sistem</p>
                    <p class="text-xs font-bold text-gray-900 italic">SKU: PROD-{{ sprintf('%03d', $product->id) }}</p>
                </div>
                @error('image') <p class="text-red-500 text-[10px] font-bold mt-2">{{ $message }}</p> @enderror
            </div>

            <!-- RIGHT: INPUTS -->
            <div class="lg:col-span-8 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2 md:col-span-2">
                        <label class="form-label">Nama Koleksi Produk</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="form-input font-bold italic text-lg">
                        @error('name') <p class="text-red-500 text-[10px] font-bold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="form-label">Kategori</label>
                        <select name="category" required class="form-input font-bold">
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ (old('category') ?? $product->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="form-label">Harga Jual (IDR)</label>
                        <input type="number" name="price" value="{{ old('price', $product->price) }}" required class="form-input font-black">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="form-label">Narasi & Deskripsi Produk</label>
                    <textarea name="description" rows="4" class="form-input resize-none leading-relaxed">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="pt-4">
                    <button type="submit" class="btn-save">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        var output = document.getElementById('preview');
        reader.onload = function(){
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
