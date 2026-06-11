@extends('layouts.admin')

@section('title', 'Ubah Momen - Admin Silua Toba')
@section('page_title', 'Update Visual')

@section('content')
<link rel="stylesheet" href="{{ asset('css/produk-admin.css') }}">

<div class="max-w-4xl mx-auto space-y-10 animate-fade-in">
    <!-- HEADER -->
    <div class="flex items-center gap-6">
        <a href="{{ route('admin.gallery.index') }}" class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-[#64748B] shadow-sm border border-[#E2E8F0] hover:bg-[#31326F] hover:text-white transition-all">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-3xl font-black text-[#31326F]">Ubah <span class="text-[#4FB7B3]">Momen</span></h1>
            <p class="text-[#64748B] text-sm mt-1">Perbarui detail arsip visual <b>{{ $gallery->title }}</b>.</p>
        </div>
    </div>

    <!-- FORM CARD -->
    <div class="admin-form-card">
        <form action="{{ route('admin.gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <div class="space-y-2">
                <label class="form-label-premium">Judul Bab</label>
                <input type="text" name="title" value="{{ old('title', $gallery->title) }}" required class="form-input-premium font-bold">
            </div>

            <div class="space-y-2">
                <label class="form-label-premium">Narasi Arsip</label>
                <textarea name="description" rows="4" class="form-input-premium">{{ old('description', $gallery->description) }}</textarea>
            </div>

            <div class="space-y-6">
                <label class="form-label-premium text-[#4FB7B3]">Ganti Visual</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <span class="text-[9px] font-bold text-[#64748B] uppercase mb-3 block">Visual Saat Ini</span>
                        <div class="relative h-48 rounded-2xl overflow-hidden border border-[#E2E8F0]">
                            <img src="{{ asset('uploads/gallery/'.$gallery->file) }}" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div>
                        <span class="text-[9px] font-bold text-[#64748B] uppercase mb-3 block">Ganti Gambar</span>
                        <div class="relative h-48 rounded-2xl bg-[#F8FAFC] border-2 border-dashed border-[#E2E8F0] flex flex-col items-center justify-center overflow-hidden cursor-pointer" onclick="document.getElementById('fileInput').click()">
                            <img id="preview" class="absolute inset-0 w-full h-full object-cover hidden">
                            <i data-lucide="refresh-cw" id="icon" class="w-8 h-8 text-[#CBD5E1]"></i>
                            <input type="file" name="file" id="fileInput" accept="image/*" onchange="previewImage(event)" class="hidden">
                        </div>
                    </div>
                </div>
                <p class="text-[9px] text-[#64748B] italic uppercase">*Biarkan kosong jika tidak ingin mengubah gambar</p>
            </div>

            <div class="pt-6">
                <button type="submit" class="btn-submit-premium !bg-[#4FB7B3] hover:!bg-[#31326F]">
                    Konfirmasi Pembaruan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        var output = document.getElementById('preview');
        var icon = document.getElementById('icon');
        reader.onload = function(){
            output.src = reader.result;
            output.classList.remove('hidden');
            icon.classList.add('hidden');
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
