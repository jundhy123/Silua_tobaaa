@extends('layouts.admin')

@section('title', 'Identitas Perusahaan - Admin Silua Toba')
@section('page_title', 'Identitas Korporat')

@section('content')
<style>
    :root { --primary-orange: #FF5722; }
    .btn-admin-add {
        background-color: #111;
        color: #fff;
        padding: 14px 24px;
        border-radius: 16px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        display: inline-flex;
        align-items: center; gap: 8px;
        transition: all 0.3s ease;
    }
    .btn-admin-add:hover {
        background-color: var(--primary-orange);
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(255, 87, 34, 0.2);
    }
</style>

<div class="space-y-10 animate-fade-in">
    <!-- HEADER -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h1 class="text-4xl font-black italic text-gray-900" style="font-family: 'Playfair Display', serif;">Profil <span class="text-primary-orange">Bisnis</span></h1>
            <p class="text-gray-400 text-sm mt-1 italic">Konfigurasi fundamental dan narasi identitas perusahaan.</p>
        </div>
        @if($profiles->isEmpty())
        <a href="{{ route('admin.profile.create') }}" class="btn-admin-add">
            <i data-lucide="plus"></i>
            Buat Data Profil
        </a>
        @endif
    </div>

    <!-- DATA TABLE -->
    <div class="bg-white rounded-[3.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-50">
                    <th class="px-10 py-8 text-[10px] font-black uppercase tracking-[0.3em] text-gray-400">Referensi Nama</th>
                    <th class="px-10 py-8 text-[10px] font-black uppercase tracking-[0.3em] text-gray-400">Cuplikan Sejarah</th>
                    <th class="px-10 py-8 text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 text-center">Pembaruan</th>
                    <th class="px-10 py-8 text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($profiles as $profile)
                <tr class="group hover:bg-gray-50/50 transition-all duration-300">
                    <td class="px-10 py-8">
                        <div class="font-bold text-gray-900 text-lg italic" style="font-family: 'Playfair Display', serif;">{{ $profile->hero_title }}</div>
                        <div class="text-[9px] font-black text-primary-orange/70 uppercase tracking-widest mt-1">Konfigurasi Global</div>
                    </td>
                    <td class="px-10 py-8">
                        <p class="text-xs text-gray-400 italic line-clamp-2 max-w-md">"{!! strip_tags($profile->history_text) !!}"</p>
                    </td>
                    <td class="px-10 py-8 text-center">
                        <span class="px-4 py-2 rounded-full text-[9px] font-black uppercase tracking-widest bg-gray-50 text-gray-600 border border-gray-100">
                            {{ $profile->updated_at->format('d M Y') }}
                        </span>
                    </td>
                    <td class="px-10 py-8">
                        <div class="flex justify-center gap-3">
                            <a href="{{ route('admin.profile.edit', $profile->id) }}" class="flex items-center gap-2 px-6 py-3 bg-gray-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-primary-orange transition-all shadow-lg shadow-gray-200">
                                <i data-lucide="edit-3" class="w-3.5 h-3.5"></i> Ubah Info
                            </a>
                            <form action="{{ route('admin.profile.destroy', $profile->id) }}" method="POST" onsubmit="return confirmDelete(this, 'Hapus Profil?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-3 bg-red-50 text-red-400 rounded-xl hover:bg-red-500 hover:text-white transition-all">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-10 py-32 text-center opacity-30 italic">
                        <i data-lucide="building" class="w-20 h-20 mx-auto mb-6 text-gray-200"></i>
                        <p class="text-xl font-bold">Profil Belum Disetup.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
