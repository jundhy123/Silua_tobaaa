@extends('layouts.admin')

@section('title', 'Tulis Blok Kisah - Admin Silua Toba')
@section('page_title', 'Narasi Perusahaan')

@section('content')
<link rel="stylesheet" href="{{ asset('css/produk-admin.css') }}">

<div class="max-w-4xl mx-auto space-y-10 animate-fade-in">
    <!-- HEADER -->
    <div class="flex items-center gap-6">
        <a href="{{ route('admin.about.index') }}" class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-[#64748B] shadow-sm border border-[#E2E8F0] hover:bg-[#31326F] hover:text-white transition-all">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-3xl font-black text-[#31326F]">Tulis <span class="text-[#4FB7B3]">Kisah</span> Baru</h1>
            <p class="text-[#64748B] text-sm mt-1 italic">Tambahkan bab narasi baru untuk sejarah brand.</p>
        </div>
    </div>

    <!-- FORM CARD -->
    <div class="admin-form-card">
        <form action="{{ route('admin.about.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="form-label-premium">Judul Bab</label>
                    <input type="text" name="title" required placeholder="cth. Warisan Resep" class="form-input-premium">
                </div>
                <div class="space-y-2">
                    <label class="form-label-premium">Headline Bab</label>
                    <input type="text" name="subtitle" placeholder="cth. Sejak Generasi Pertama" class="form-input-premium">
                </div>
            </div>

            <div class="space-y-2">
                <label class="form-label-premium">Narasi Utama</label>
                <textarea name="description" rows="6" placeholder="Ceritakan bab ini secara mendalam..." required class="form-input-premium"></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-end">
                <div class="space-y-2">
                    <label class="form-label-premium">Penanda Waktu (Tahun)</label>
                    <input type="number" name="years_experience" placeholder="cth. 15" class="form-input-premium font-black text-xl">
                </div>
                <div class="space-y-2">
                    <label class="form-label-premium">Visual Bab</label>
                    <div class="relative group h-40 rounded-2xl bg-[#F8FAFC] border-2 border-dashed border-[#E2E8F0] flex flex-col items-center justify-center overflow-hidden cursor-pointer" onclick="document.getElementById('imgInput').click()">
                        <img id="preview" class="absolute inset-0 w-full h-full object-cover hidden">
                        <i data-lucide="image" class="w-8 h-8 text-[#CBD5E1]"></i>
                        <span class="text-[10px] font-bold text-[#64748B] uppercase mt-2">Pilih Gambar</span>
                        <input type="file" name="image" id="imgInput" required accept="image/*" onchange="previewImage(event)" class="hidden">
                    </div>
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="btn-submit-premium">
                    Simpan Bab Kisah
                </button>
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
            output.classList.remove('hidden');
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
