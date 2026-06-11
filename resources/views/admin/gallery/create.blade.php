@extends('layouts.admin')

@section('title', 'Abadikan Momen - Admin Silua Toba')
@section('page_title', 'Update Galeri')

@section('content')
<link rel="stylesheet" href="{{ asset('css/produk-admin.css') }}">

<div class="max-w-4xl mx-auto space-y-10 animate-fade-in">
    <!-- HEADER -->
    <div class="flex items-center gap-6">
        <a href="{{ route('admin.gallery.index') }}" class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-[#64748B] shadow-sm border border-[#E2E8F0] hover:bg-[#31326F] hover:text-white transition-all">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-3xl font-black text-[#31326F]">Abadikan <span class="text-[#4FB7B3]">Momen Baru</span></h1>
            <p class="text-[#64748B] text-sm mt-1">Tambahkan dokumentasi visual ke dalam arsip galeri publik.</p>
        </div>
    </div>

    <!-- FORM CARD -->
    <div class="admin-form-card">
        <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <div class="space-y-2">
                <label class="form-label-premium">Judul Momen</label>
                <input type="text" name="title" required placeholder="cth. Peresmian Cabang atau Proses Produksi" class="form-input-premium font-bold">
            </div>

            <div class="space-y-2">
                <label class="form-label-premium">Konteks Narasi</label>
                <textarea name="description" rows="4" placeholder="Ceritakan singkat tentang momen ini..." class="form-input-premium leading-relaxed"></textarea>
            </div>

            <div class="space-y-2">
                <label class="form-label-premium">Aset Visual</label>
                <div class="relative h-72 rounded-3xl bg-[#F8FAFC] border-2 border-dashed border-[#E2E8F0] group overflow-hidden flex flex-col items-center justify-center cursor-pointer transition-all hover:border-[#4FB7B3]/50" onclick="document.getElementById('fileInput').click()">
                    <img id="preview" class="absolute inset-0 w-full h-full object-cover hidden">
                    <div id="placeholder" class="flex flex-col items-center gap-4 text-[#CBD5E1]">
                        <i data-lucide="image" class="w-12 h-12"></i>
                        <span class="text-[10px] font-black uppercase tracking-widest text-[#64748B]">Pilih File Gambar</span>
                    </div>
                    <input type="file" name="file" id="fileInput" required accept="image/*" onchange="previewImage(event)" class="hidden">
                </div>
                <p class="text-[9px] text-[#64748B] italic text-center uppercase tracking-widest mt-4">Mendukung JPG, PNG, WEBP (Maks 5MB)</p>
            </div>

            <div class="pt-6">
                <button type="submit" class="btn-submit-premium">
                    Simpan ke Galeri
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        var output = document.getElementById('preview');
        var placeholder = document.getElementById('placeholder');
        reader.onload = function(){
            output.src = reader.result;
            output.classList.remove('hidden');
            placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
