@extends('layouts.admin')

@section('title', 'Tambah Produk - Admin Silua Toba')
@section('page_title', 'Ekspansi Inventaris')

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
            <h1 class="text-4xl font-black italic text-gray-900" style="font-family: 'Playfair Display', serif;">Tambah <span class="text-primary-orange">Produk Baru</span></h1>
            <p class="text-gray-400 text-sm mt-1 italic">Lengkapi detail untuk menambahkan koleksi rasa baru ke katalog.</p>
        </div>
        <a href="{{ route('admin.produk.index') }}" class="px-6 py-3 bg-white border border-gray-100 text-gray-400 rounded-xl font-black uppercase tracking-widest text-[10px] hover:bg-gray-900 hover:text-white transition-all shadow-sm flex items-center gap-2">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali
        </a>
    </div>

    <!-- FORM CARD -->
    <div class="form-card shadow-sm">
        <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            @csrf
            <!-- LEFT: IMAGE UPLOAD -->
            <div class="lg:col-span-4 space-y-4">
                <label class="form-label">Media Produk</label>
                <div class="image-upload-box group" onclick="document.getElementById('imageInput').click()">
                    <img id="preview" src="{{ asset('images/placeholder-img.png') }}" class="w-full h-full object-cover opacity-20">
                    <div class="absolute inset-0 flex flex-col items-center justify-center group-hover:bg-gray-900/5 transition-all">
                        <i data-lucide="camera" class="w-8 h-8 text-gray-300 group-hover:text-primary-orange transition-colors"></i>
                        <span class="text-[9px] font-black text-gray-400 uppercase mt-2 tracking-widest">Pilih Foto</span>
                    </div>
                </div>
                <input type="file" name="image" id="imageInput" accept="image/*" class="hidden" required onchange="previewImage(event)">
                <p class="text-[10px] text-gray-400 italic text-center leading-relaxed">Gunakan foto berkualitas tinggi dengan rasio 1:1.</p>
                @error('image') <p class="text-red-500 text-[10px] font-bold mt-2">{{ $message }}</p> @enderror
            </div>

            <!-- RIGHT: INPUTS -->
            <div class="lg:col-span-8 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2 md:col-span-2">
                        <label class="form-label">Nama Koleksi Produk</label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="cth. Sambal Andaliman Original" required class="form-input font-bold italic">
                        @error('name') <p class="text-red-500 text-[10px] font-bold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="form-label">Kategori</label>
                        <select name="category" required class="form-input font-bold">
                            <option value="" disabled selected>Pilih Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->category_name }}" {{ old('category') == $cat->category_name ? 'selected' : '' }}>{{ $cat->category_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="form-label">Harga Jual (IDR)</label>
                        <input type="number" name="price" value="{{ old('price') }}" placeholder="45000" required class="form-input font-black">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="form-label">Narasi & Deskripsi Produk</label>
                    <textarea name="description" rows="4" placeholder="Ceritakan cita rasa unik produk ini..." class="form-input resize-none leading-relaxed">{{ old('description') }}</textarea>
                </div>

                <div class="pt-4">
                    <button type="submit" class="btn-save">
                        Simpan ke Inventaris
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
            output.classList.remove('opacity-20');
            output.classList.add('opacity-100');
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
