@extends('layouts.admin')

@section('title', 'Tambah Talenta - Admin Silua Toba')
@section('page_title', 'Update Tim')

@section('content')
<link rel="stylesheet" href="{{ asset('css/produk-admin.css') }}">

<div class="max-w-4xl mx-auto space-y-10 animate-fade-in">
    <!-- HEADER -->
    <div class="flex items-center gap-6">
        <a href="{{ route('admin.teams.index') }}" class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-[#64748B] shadow-sm border border-[#E2E8F0] hover:bg-[#31326F] hover:text-white transition-all">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-3xl font-black text-[#31326F]">Registrasi <span class="text-[#4FB7B3]">Anggota Baru</span></h1>
            <p class="text-[#64748B] text-sm mt-1">Tambahkan pengrajin kuliner ke dalam daftar tim resmi.</p>
        </div>
    </div>

    <!-- FORM CARD -->
    <div class="admin-form-card">
        <form action="{{ route('admin.teams.store') }}" method="POST" enctype="multipart/form-data" class="space-y-12">
            @csrf

            <!-- Portrait -->
            <div class="flex flex-col items-center">
                <div class="relative w-40 h-40 group">
                    <div class="w-full h-full rounded-full bg-[#F8FAFC] border-4 border-white shadow-xl overflow-hidden relative ring-1 ring-[#E2E8F0] cursor-pointer" onclick="document.getElementById('photoInput').click()">
                        <img id="preview" src="{{ asset('images/placeholder-img.png') }}" class="w-full h-full object-cover opacity-40">
                        <div class="absolute inset-0 bg-[#31326F]/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white">
                            <i data-lucide="camera" class="w-6 h-6"></i>
                        </div>
                        <input type="file" name="photo" id="photoInput" required accept="image/*" onchange="previewImage(event)" class="hidden">
                    </div>
                    <label class="text-[9px] font-black uppercase tracking-widest text-[#64748B] text-center block mt-5">Foto Profil Resmi</label>
                </div>
                @error('photo') <p class="text-rose-500 text-[10px] font-bold mt-4">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-2">
                    <label class="form-label-premium">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="cth. Jundhy Situmorang" class="form-input-premium">
                </div>

                <div class="space-y-2">
                    <label class="form-label-premium">Posisi / Jabatan</label>
                    <input type="text" name="position" value="{{ old('position') }}" required placeholder="cth. Head of Spices" class="form-input-premium">
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="btn-submit-premium">
                    Daftarkan Anggota Tim
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
            output.classList.remove('opacity-40');
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
