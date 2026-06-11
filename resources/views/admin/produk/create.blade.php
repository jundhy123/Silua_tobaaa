@extends('layouts.admin')

@section('title', 'Tambah Produk Baru - Admin Silua Toba')
@section('page_title', 'Ekspansi Inventaris')

@section('content')
<link rel="stylesheet" href="{{ asset('css/produk-admin.css') }}">

<div class="max-w-6xl mx-auto space-y-10 animate-fade-in">
    <!-- HEADER -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h1 class="main-title-premium text-[#31326F]">Form <span class="text-[#4FB7B3]">Produk Baru</span></h1>
            <p class="text-[#64748B] text-sm mt-1 italic">Lengkapi detail untuk menambahkan koleksi rasa baru ke katalog.</p>
        </div>
        <a href="{{ route('admin.produk.index') }}" class="flex items-center gap-2 px-5 py-2.5 bg-white border border-[#E2E8F0] text-[#64748B] rounded-xl font-bold uppercase tracking-widest text-[10px] hover:bg-[#31326F] hover:text-white transition-all shadow-sm">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            Kembali
        </a>
    </div>

    <!-- FORM CARD -->
    <div class="admin-form-card">
        <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">

                <!-- SISI KIRI: UPLOAD -->
                <div class="lg:col-span-5 space-y-6">
                    <label class="form-label-premium text-[#4FB7B3]">Media Produk</label>
                    <div class="image-preview-container group" onclick="document.getElementById('imageInput').click()">
                        <img id="preview" src="{{ asset('images/placeholder-img.png') }}" class="w-full h-full object-cover opacity-50">
                        <div class="absolute inset-0 bg-[#31326F]/60 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center text-white">
                            <i data-lucide="camera" class="w-10 h-10 mb-2"></i>
                            <span class="text-[10px] font-bold uppercase">Upload Foto</span>
                        </div>
                        <input type="file" name="image" id="imageInput" accept="image/*" required onchange="previewImage(event)" class="hidden">
                    </div>
                    @error('image') <p class="text-rose-500 text-[10px] font-bold mt-2">{{ $message }}</p> @enderror

                    <div class="p-6 bg-[#A8FBD3]/10 rounded-2xl border border-[#A8FBD3]/20">
                        <div class="flex gap-4">
                            <i data-lucide="info" class="w-5 h-5 text-[#4FB7B3]"></i>
                            <p class="text-xs text-[#31326F] leading-relaxed italic">"Gunakan rasio 1:1 dengan pencahayaan terang untuk hasil terbaik."</p>
                        </div>
                    </div>
                </div>

                <!-- SISI KANAN: INPUT DATA -->
                <div class="lg:col-span-7 space-y-8">
                    <div class="space-y-2">
                        <label class="form-label-premium">Nama Produk</label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="cth. Sambal Andaliman Original" required class="form-input-premium">
                        @error('name') <p class="text-rose-500 text-[10px] font-bold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="form-label-premium">Kategori</label>
                            <select name="category" required class="form-input-premium">
                                <option value="" disabled selected>Pilih Kategori</option>
                                <option value="Makanan Berat">Makanan Berat</option>
                                <option value="Camilan">Camilan</option>
                                <option value="Minuman">Minuman</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="form-label-premium">Harga (Rp)</label>
                            <input type="number" name="price" value="{{ old('price') }}" placeholder="45000" required class="form-input-premium font-bold">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="form-label-premium">Deskripsi Produk</label>
                        <textarea name="description" rows="5" placeholder="Gambarkan cita rasa, bahan baku, dan keunggulan produk ini..." class="form-input-premium leading-relaxed">{{ old('description') }}</textarea>
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="btn-submit-premium">
                            Simpan & Publikasikan
                        </button>
                    </div>
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
            output.classList.remove('opacity-50');
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
