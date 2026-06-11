@extends('layouts.admin')

@section('title', 'Kisah Brand - Admin Silua Toba')
@section('page_title', 'Narasi Tentang Kami')

@section('content')
<link rel="stylesheet" href="{{ asset('css/produk-admin.css') }}">

<div class="space-y-10 animate-fade-in">
    <!-- HEADER -->
    <div class="admin-header-flex">
        <div>
            <h1 class="main-title-premium text-[#31326F]">Kisah <span class="text-[#4FB7B3]">Brand</span></h1>
            <p class="text-[#64748B] text-sm mt-1 italic">Susun narasi sejarah dan filosofi Silua Toba secara visual.</p>
        </div>
        <a href="{{ route('admin.about.create') }}" class="btn-admin-add">
            <i data-lucide="plus"></i>
            Tambah Blok Kisah
        </a>
    </div>

    <!-- DATA TABLE -->
    <div class="admin-table-card">
        <table class="admin-table">
            <thead>
                <tr>
                    <th width="150">Visual</th>
                    <th>Judul Bab</th>
                    <th>Penanda Waktu</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($abouts as $a)
                <tr>
                    <td>
                        <div class="w-24 h-16 rounded-xl overflow-hidden shadow-sm border border-[#E2E8F0]">
                            <img src="{{ asset('uploads/about/'.$a->image) }}" class="w-full h-full object-cover">
                        </div>
                    </td>
                    <td>
                        <div class="font-bold text-[#31326F]">{{ $a->title }}</div>
                        <p class="text-[10px] text-[#4FB7B3] font-bold uppercase tracking-widest mt-1">{{ $a->subtitle ?? 'Narasi Utama' }}</p>
                    </td>
                    <td>
                        @if($a->years_experience)
                        <div class="flex items-center gap-3">
                            <span class="text-xl font-black text-[#31326F]">{{ $a->years_experience }}</span>
                            <span class="text-[9px] font-bold text-[#64748B] uppercase tracking-tighter leading-none">Tahun<br>Berdiri</span>
                        </div>
                        @else
                        <span class="text-[#64748B] italic text-xs">N/A</span>
                        @endif
                    </td>
                    <td>
                        <div class="flex justify-center gap-3">
                            <a href="{{ route('admin.about.edit', $a->id) }}" class="action-btn edit" title="Edit">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('admin.about.destroy', $a->id) }}" method="POST" onsubmit="return confirmDelete(this, 'Hapus Konten Kisah?')">
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
                        <i data-lucide="file-text" class="w-16 h-16 mx-auto mb-4 text-[#64748B]"></i>
                        <p class="font-bold uppercase tracking-widest text-xs">Kisah belum ditambahkan</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
