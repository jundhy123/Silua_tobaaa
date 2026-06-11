@extends('layouts.admin')

@section('title', 'Ubah Narasi - Admin Silua Toba')
@section('page_title', 'Update Konten Kisah')

@section('content')
<link rel="stylesheet" href="{{ asset('css/produk-admin.css') }}">

<div class="max-w-4xl mx-auto space-y-10 animate-fade-in">
    <!-- HEADER -->
    <div class="flex items-center gap-6">
        <a href="{{ route('admin.about.index') }}" class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-[#64748B] shadow-sm border border-[#E2E8F0] hover:bg-[#31326F] hover:text-white transition-all">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-3xl font-black text-[#31326F]">Ubah <span class="text-[#4FB7B3]">Narasi</span></h1>
            <p class="text-[#64748B] text-sm mt-1 italic">Sempurnakan detail cerita untuk bab <b>{{ $about->title }}</b>.</p>
        </div>
    </div>

    <!-- FORM CARD -->
    <div class="admin-form-card">
        <form action="{{ route('admin.about.update', $about->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="form-label-premium">Judul Bab</label>
                    <input type="text" name="title" value="{{ old('title', $about->title) }}" required class="form-input-premium">
                </div>
                <div class="space-y-2">
                    <label class="form-label-premium">Headline Bab</label>
                    <input type="text" name="subtitle" value="{{ old('subtitle', $about->subtitle) }}" class="form-input-premium">
                </div>
            </div>

            <div class="space-y-2">
                <label class="form-label-premium">Konten Narasi Utama</label>
                <textarea name="description" rows="8" required class="form-input-premium">{{ old('description', $about->description) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-end">
                <div class="space-y-2">
                    <label class="form-label-premium">Penanda Waktu (Tahun)</label>
                    <input type="number" name="years_experience" value="{{ old('years_experience', $about->years_experience) }}" class="form-input-premium font-black text-2xl">
                </div>
                <div class="space-y-2">
                    <label class="form-label-premium">Ganti Visual</label>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="h-32 rounded-xl overflow-hidden border border-[#E2E8F0]">
                            <img src="{{ asset('uploads/about/'.$about->image) }}" class="w-full h-full object-cover">
                        </div>
                        <div class="relative h-32 rounded-xl bg-[#F8FAFC] border-2 border-dashed border-[#E2E8F0] flex flex-col items-center justify-center overflow-hidden cursor-pointer" onclick="document.getElementById('imgInput').click()">
                            <img id="preview" class="absolute inset-0 w-full h-full object-cover hidden">
                            <i data-lucide="refresh-cw" class="w-6 h-6 text-[#CBD5E1]"></i>
                            <input type="file" name="image" id="imgInput" accept="image/*" onchange="previewImage(event)" class="hidden">
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="btn-submit-premium !bg-[#4FB7B3] hover:!bg-[#31326F]">
                    Simpan Perubahan
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
