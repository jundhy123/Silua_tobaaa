@extends('layouts.admin')

@section('title', 'Identitas Perusahaan - Admin Silua Toba')
@section('page_title', 'Identitas Korporat')

@section('content')
<link rel="stylesheet" href="{{ asset('css/produk-admin.css') }}">

<div class="space-y-10 animate-fade-in">
    <!-- HEADER -->
    <div class="admin-header-flex">
        <div>
            <h1 class="main-title-premium text-[#31326F]">Profil <span class="text-[#4FB7B3]">Bisnis</span></h1>
            <p class="text-[#64748B] text-sm mt-1 italic">Konfigurasi fundamental dan narasi identitas perusahaan.</p>
        </div>
        @if($profiles->isEmpty())
        <a href="{{ route('admin.profile.create') }}" class="btn-admin-add">
            <i data-lucide="plus"></i>
            Buat Data Profil
        </a>
        @endif
    </div>

    <!-- DATA TABLE -->
    <div class="admin-table-card">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Referensi Nama</th>
                    <th>Cuplikan Sejarah</th>
                    <th class="text-center">Pembaruan</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($profiles as $profile)
                <tr>
                    <td>
                        <div class="font-bold text-[#31326F]">{{ $profile->hero_title }}</div>
                        <div class="text-[9px] font-bold text-[#4FB7B3] uppercase tracking-widest mt-1">Konfigurasi Global</div>
                    </td>
                    <td>
                        <p class="text-xs text-[#64748B] italic line-clamp-2 max-w-md">"{!! strip_tags($profile->history_text) !!}"</p>
                    </td>
                    <td class="text-center">
                        <span class="text-[10px] font-bold text-[#64748B]">{{ $profile->updated_at->format('d M Y') }}</span>
                    </td>
                    <td>
                        <div class="flex justify-center gap-3">
                            <a href="{{ route('admin.profile.edit', $profile->id) }}" class="flex items-center gap-2 px-4 py-2 bg-[#31326F] text-white rounded-lg text-[10px] font-bold uppercase tracking-widest hover:bg-[#4FB7B3] transition-all shadow-sm">
                                <i data-lucide="edit-3" class="w-3 h-3"></i> Ubah Info
                            </a>
                            <form action="{{ route('admin.profile.destroy', $profile->id) }}" method="POST" onsubmit="return confirmDelete(this, 'Hapus Profil?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn delete">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-20 text-center opacity-30">
                        <i data-lucide="building" class="w-16 h-16 mx-auto mb-4 text-[#64748B]"></i>
                        <p class="font-bold uppercase tracking-widest text-xs">Profil Belum Disetup</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
