@extends('layouts.admin')

@section('title', 'Kelola Galeri - Admin Silua Toba')
@section('page_title', 'Aset Visual')

@section('content')
<link rel="stylesheet" href="{{ asset('css/produk-admin.css') }}">

<div class="space-y-10 animate-fade-in">
    <!-- HEADER -->
    <div class="admin-header-flex">
        <div>
            <h1 class="main-title-premium">Galeri <span class="text-[#4FB7B3]">Visual</span></h1>
            <p class="text-[#64748B] text-sm mt-1 italic">Total {{ $galleries->count() }} memori yang telah diabadikan.</p>
        </div>
        <a href="{{ route('admin.gallery.create') }}" class="btn-admin-add">
            <i data-lucide="image-plus"></i>
            Tambah Momen
        </a>
    </div>

    <!-- DATA TABLE -->
    <div class="admin-table-card">
        <table class="admin-table">
            <thead>
                <tr>
                    <th width="180">Pratinjau</th>
                    <th>Konteks</th>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($galleries as $g)
                <tr>
                    <td>
                        <div class="relative w-32 h-20 rounded-xl overflow-hidden shadow-sm border border-[#E2E8F0]">
                            <img src="{{ asset('uploads/gallery/'.$g->file) }}" class="w-full h-full object-cover">
                        </div>
                    </td>
                    <td>
                        <div class="font-bold text-[#31326F]">{{ $g->title }}</div>
                        <p class="text-[10px] text-[#64748B] mt-1 italic line-clamp-1 max-w-sm">"{{ $g->description ?? 'Tidak ada narasi.' }}"</p>
                    </td>
                    <td class="text-center">
                        <span class="badge-pill bg-[#F8FAFC] text-[#64748B] border border-[#E2E8F0]">
                            {{ $g->created_at->format('d/m/Y') }}
                        </span>
                    </td>
                    <td>
                        <div class="flex justify-center gap-3">
                            <a href="{{ route('admin.gallery.edit', $g->id) }}" class="action-btn edit" title="Edit">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('admin.gallery.destroy', $g->id) }}" method="POST" onsubmit="return confirmDelete(this, 'Hapus Dokumentasi?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn delete" title="Hapus">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-20 text-center opacity-30">
                        <i data-lucide="image" class="w-16 h-16 mx-auto mb-4 text-[#64748B]"></i>
                        <p class="font-bold uppercase tracking-widest text-xs">Galeri Kosong</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
