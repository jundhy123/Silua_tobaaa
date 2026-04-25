@extends('layouts.admin')

@section('title', 'Kelola Galeri')
@section('page_title', 'Galeri Dokumentasi')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
    <div>
        <h3 class="text-3xl font-black text-navy-dark tracking-tighter uppercase">Daftar Galeri</h3>
        <p class="text-gray-500 text-sm font-medium">Total terdapat {{ $galleries->count() }} foto dokumentasi aktivitas.</p>
    </div>
    <!-- Tombol Tambah -->
    <a href="{{ route('admin.gallery.create') }}" class="btn-admin-primary">
        <i data-lucide="image-plus" class="w-5 h-5"></i>
        <span>Tambah Foto Baru</span>
    </a>
</div>

<!-- Notifikasi Sukses -->
@if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-xl flex items-center gap-3 animate-fade-in">
        <i data-lucide="check-circle" class="text-green-500 w-5 h-5"></i>
        <p class="text-sm text-green-700 font-bold">{{ session('success') }}</p>
    </div>
@endif

<div class="admin-card overflow-hidden">
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th class="text-center">Preview</th>
                    <th>Judul & Deskripsi</th>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($galleries as $g)
                <tr>
                    <td class="text-center w-32">
                        <div class="inline-block relative group">
                            <img src="{{ asset('uploads/gallery/'.$g->file) }}" class="product-img-thumb shadow-md transition-transform group-hover:scale-110">
                        </div>
                    </td>
                    <td>
                        <div class="product-name-title">{{ $g->title }}</div>
                        <div class="text-xs text-gray-400 mt-1 line-clamp-1 italic">
                            {{ $g->description ?? 'Tidak ada deskripsi' }}
                        </div>
                    </td>
                    <td class="text-center">
                        <span class="text-xs font-bold text-gray-500 bg-gray-100 px-3 py-1 rounded-full uppercase">
                            {{ $g->created_at->format('d M Y') }}
                        </span>
                    </td>
                    <td>
                        <div class="flex justify-center gap-3">
                            <!-- ✅ TOMBOL EDIT (Pill Style) -->
                            <a href="{{ route('admin.gallery.edit', $g->id) }}" class="action-btn-pill edit" title="Ubah Data">
                                <i data-lucide="edit-3"></i>
                                <span>Edit</span>
                            </a>

                            <!-- TOMBOL HAPUS -->
                            <form action="{{ route('admin.gallery.destroy', $g->id) }}" method="POST" onsubmit="return confirm('Hapus dokumentasi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn-pill delete" title="Hapus">
                                    <i data-lucide="trash-2"></i>
                                    <span>Hapus</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-24 text-center">
                        <div class="opacity-20 mb-4">
                            <i data-lucide="image-off" class="w-20 h-20 mx-auto text-gray-400"></i>
                        </div>
                        <p class="text-gray-400 font-bold italic tracking-widest uppercase text-xs">Belum ada foto yang diupload.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection