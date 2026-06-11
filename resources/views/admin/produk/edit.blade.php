@extends('layouts.admin')

@section('title', 'Ubah Produk - Admin Silua Toba')
@section('page_title', 'Update Inventaris')

@section('content')
<link rel="stylesheet" href="{{ asset('css/produk-admin.css') }}">

<div class="max-w-6xl mx-auto space-y-10 animate-fade-in">
    <!-- HEADER -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h1 class="main-title-premium text-[#31326F]">Ubah <span class="text-[#4FB7B3]">Detail Produk</span></h1>
            <p class="text-[#64748B] text-sm mt-1 italic">Perbarui informasi untuk <b>{{ $product->name }}</b>.</p>
        </div>
        <a href="{{ route('admin.produk.index') }}" class="flex items-center gap-2 px-5 py-2.5 bg-white border border-[#E2E8F0] text-[#64748B] rounded-xl font-bold uppercase tracking-widest text-[10px] hover:bg-[#31326F] hover:text-white transition-all shadow-sm">
            <i data-lucide="x" class="w-3.5 h-3.5"></i>
            Batalkan
        </a>
    </div>

    <!-- FORM CARD -->
    <div class="admin-form-card">
        <form action="{{ route('admin.produk.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">

                <!-- SISI KIRI: UPLOAD -->
                <div class="lg:col-span-5 space-y-6">
                    <label class="form-label-premium text-[#4FB7B3]">Ganti Visual</label>
                    <div class="image-preview-container group" onclick="document.getElementById('imageInput').click()">
                        <img id="preview" src="{{ asset('uploads/products/' . $product->image) }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-[#31326F]/60 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center text-white">
                            <i data-lucide="refresh-cw" class="w-10 h-10 mb-2"></i>
                            <span class="text-[10px] font-bold uppercase">Ganti Foto</span>
                        </div>
                        <input type="file" name="image" id="imageInput" accept="image/*" onchange="previewImage(event)" class="hidden">
                    </div>
                    @error('image') <p class="text-rose-500 text-[10px] font-bold mt-2">{{ $message }}</p> @enderror

                    <div class="p-6 bg-[#31326F] rounded-2xl text-white">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-2 h-2 rounded-full bg-[#A8FBD3] animate-pulse"></div>
                            <span class="text-[9px] font-bold uppercase tracking-widest text-white/50">Status Data</span>
                        </div>
                        <h4 class="font-bold text-lg">SKU #PROD-{{ sprintf('%03d', $product->id) }}</h4>
                        <p class="text-[10px] text-white/40 mt-2 uppercase tracking-widest">Terakhir diubah: {{ $product->updated_at->diffForHumans() }}</p>
                    </div>
                </div>

                <!-- SISI KANAN: INPUT DATA -->
                <div class="lg:col-span-7 space-y-8">
                    <div class="space-y-2">
                        <label class="form-label-premium">Nama Produk</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="form-input-premium font-bold text-lg">
                        @error('name') <p class="text-rose-500 text-[10px] font-bold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="form-label-premium">Kategori</label>
                            <select name="category" required class="form-input-premium">
                                <option value="Makanan Berat" {{ $product->category == 'Makanan Berat' ? 'selected' : '' }}>Makanan Berat</option>
                                <option value="Camilan" {{ $product->category == 'Camilan' ? 'selected' : '' }}>Camilan</option>
                                <option value="Minuman" {{ $product->category == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="form-label-premium">Harga Jual (Rp)</label>
                            <input type="number" name="price" value="{{ old('price', $product->price) }}" required class="form-input-premium font-bold">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="form-label-premium">Narasi Produk</label>
                        <textarea name="description" rows="5" class="form-input-premium leading-relaxed">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="btn-submit-premium !bg-[#4FB7B3] hover:!bg-[#31326F]">
                            Konfirmasi Perubahan
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
        reader.onload = function(){ output.src = reader.result; };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
