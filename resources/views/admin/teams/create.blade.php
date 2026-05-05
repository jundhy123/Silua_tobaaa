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

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-xl">
                    <p class="text-sm text-red-700 font-bold mb-2">Periksa kembali data yang Anda masukkan:</p>
                    <ul class="text-xs text-red-600 list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Nama -->
                <div class="admin-input-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="silua-input" placeholder="Contoh: Jundhy Situmorang">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Jabatan -->
                <div class="admin-input-group">
                    <label>Jabatan / Posisi</label>
                    <input type="text" name="position" value="{{ old('position') }}" required class="silua-input" placeholder="Contoh: Founder / Head Chef">
                    @error('position') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Foto -->
            <div class="admin-input-group">
                <label>Foto Anggota</label>
                <input type="file" name="photo" required class="silua-input file-input">
                @error('photo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                <button type="submit" class="btn-admin-submit">
                    <i data-lucide="save" class="w-5 h-5 mr-2"></i>
                    <span>SIMPAN DATA TIM</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection