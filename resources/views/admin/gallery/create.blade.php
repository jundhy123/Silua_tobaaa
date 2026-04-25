@extends('layouts.admin')

@section('content')
<div class="max-w-3xl">
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('admin.gallery.index') }}" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-navy-dark shadow-md hover:bg-orange-brand hover:text-white transition">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <h3 class="text-2xl font-black text-navy-dark uppercase">Tambah Foto Galeri</h3>
    </div>

    <div class="admin-card border-t-8 border-orange-brand">
        <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            <!-- Tambahkan di dalam form create.blade.php -->
<div class="admin-input-group">
    <label>Judul Dokumentasi</label>
    <input type="text" name="title" required class="silua-input" placeholder="Misal: Peresmian Cabang Baru">
</div>

<div class="admin-input-group">
    <label>Deskripsi / Cerita Singkat</label>
    <textarea name="description" rows="3" class="silua-input" placeholder="Ceritakan sedikit tentang momen ini..."></textarea>
</div>

<div class="admin-input-group">
    <label>Pilih File Foto</label>
    <input type="file" name="file" required class="silua-input file-input">
</div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="btn-admin-submit">
                    <i data-lucide="save" class="w-5 h-5 mr-2"></i>
                    <span>SIMPAN KE GALERI</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection