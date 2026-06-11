@extends('layouts.admin')

@section('title', 'Ubah Info Talenta - Admin Silua Toba')
@section('page_title', 'Manajemen Tim')

@section('content')
<link rel="stylesheet" href="{{ asset('css/produk-admin.css') }}">

<div class="max-w-4xl mx-auto space-y-10 animate-fade-in">
    <!-- HEADER -->
    <div class="flex items-center gap-6">
        <a href="{{ route('admin.teams.index') }}" class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-[#64748B] shadow-sm border border-[#E2E8F0] hover:bg-[#31326F] hover:text-white transition-all">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-3xl font-black text-[#31326F]">Ubah <span class="text-[#4FB7B3]">Info Talenta</span></h1>
            <p class="text-[#64748B] text-sm mt-1">Perbarui kredensial dan identitas visual <b>{{ $team->name }}</b>.</p>
        </div>
    </div>

    <!-- FORM CARD -->
    <div class="admin-form-card">
        <form action="{{ route('admin.teams.update', $team->id) }}" method="POST" enctype="multipart/form-data" class="space-y-12">
            @csrf
            @method('PUT')

            <div class="flex flex-col items-center">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                    <div class="text-center">
                        <span class="text-[9px] font-bold text-[#64748B] uppercase mb-4 block">Foto Saat Ini</span>
                        <div class="w-32 h-32 mx-auto rounded-full overflow-hidden border-4 border-white shadow-lg ring-1 ring-[#E2E8F0]">
                            <img src="{{ asset('uploads/teams/'.$team->photo) }}" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div class="text-center">
                        <span class="text-[9px] font-bold text-[#64748B] uppercase mb-4 block">Ganti Foto</span>
                        <div class="relative w-32 h-32 mx-auto group">
                            <div class="w-full h-full rounded-full bg-[#F8FAFC] border-2 border-dashed border-[#E2E8F0] flex flex-col items-center justify-center overflow-hidden cursor-pointer" onclick="document.getElementById('photoInput').click()">
                                <img id="preview" class="absolute inset-0 w-full h-full object-cover hidden">
                                <i data-lucide="refresh-cw" id="icon" class="w-6 h-6 text-[#CBD5E1]"></i>
                                <input type="file" name="photo" id="photoInput" accept="image/*" onchange="previewImage(event)" class="hidden">
                            </div>
                        </div>
                    </div>
                </div>
                <p class="text-[9px] text-[#64748B] italic uppercase mt-6">*Biarkan kosong untuk mempertahankan foto lama</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-2">
                    <label class="form-label-premium">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $team->name) }}" required class="form-input-premium font-bold">
                </div>

                <div class="space-y-2">
                    <label class="form-label-premium">Posisi Jabatan</label>
                    <input type="text" name="position" value="{{ old('position', $team->position) }}" required class="form-input-premium">
                </div>
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
