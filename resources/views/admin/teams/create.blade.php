@extends('layouts.admin')

@section('title', 'Tambah Anggota')
@section('page_title', 'Input Tim Baru')

@section('content')
<div class="max-w-4xl">
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('admin.teams.index') }}" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-navy-dark shadow-md hover:bg-orange-brand hover:text-white transition">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <h3 class="text-2xl font-black text-navy-dark uppercase tracking-tight">Form Anggota Tim</h3>
    </div>

    <div class="admin-card border-t-8 border-orange-brand">
        <form action="{{ route('admin.teams.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Nama -->
                <div class="admin-input-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" required class="silua-input" placeholder="Contoh: Jundhy Situmorang">
                </div>

                <!-- Jabatan -->
                <div class="admin-input-group">
                    <label>Jabatan / Posisi</label>
                    <input type="text" name="position" required class="silua-input" placeholder="Contoh: Founder / Head Chef">
                </div>
            </div>

            <!-- Foto -->
            <div class="admin-input-group">
                <label>Foto Anggota</label>
                <input type="file" name="photo" required class="silua-input file-input">
                <p class="text-[10px] text-gray-400 mt-1">*Rekomendasi ukuran portrait (3:4), maksimal 2MB</p>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="btn-admin-submit">
                    <i data-lucide="save" class="w-5 h-5 mr-2"></i>
                    <span>SIMPAN DATA TIM</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection