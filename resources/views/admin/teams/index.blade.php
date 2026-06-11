@extends('layouts.admin')

@section('title', 'Kelola Tim - Admin Silua Toba')
@section('page_title', 'Tim Kami')

@section('content')
<link rel="stylesheet" href="{{ asset('css/produk-admin.css') }}">

<div class="space-y-10 animate-fade-in">
    <!-- HEADER -->
    <div class="admin-header-flex">
        <div>
            <h1 class="main-title-premium text-[#31326F]">Kelola <span class="text-[#4FB7B3]">Tim Kreatif</span></h1>
            <p class="text-[#64748B] text-sm mt-1 italic">Individu yang menjaga dedikasi dan kualitas Silua Toba.</p>
        </div>
        <a href="{{ route('admin.teams.create') }}" class="btn-admin-add">
            <i data-lucide="user-plus"></i>
            Tambah Anggota
        </a>
    </div>

    <!-- DATA TABLE -->
    <div class="admin-table-card">
        <table class="admin-table">
            <thead>
                <tr>
                    <th width="100">Foto</th>
                    <th>Identitas Anggota</th>
                    <th>Posisi / Peran</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($teams as $t)
                <tr>
                    <td>
                        <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-white shadow-sm ring-1 ring-[#E2E8F0]">
                            <img src="{{ asset('uploads/teams/'.$t->photo) }}" class="w-full h-full object-cover">
                        </div>
                    </td>
                    <td>
                        <div class="font-bold text-[#31326F] text-sm">{{ $t->name }}</div>
                        <div class="text-[9px] font-bold text-[#4FB7B3] uppercase tracking-widest mt-0.5">Anggota Aktif</div>
                    </td>
                    <td>
                        <span class="badge-pill bg-[#A8FBD3]/20 text-[#31326F] border border-[#A8FBD3]/30">
                            {{ $t->position }}
                        </span>
                    </td>
                    <td>
                        <div class="flex justify-center gap-3">
                            <a href="{{ route('admin.teams.edit', $t->id) }}" class="action-btn edit" title="Edit">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('admin.teams.destroy', $t->id) }}" method="POST" onsubmit="return confirmDelete(this, 'Hapus Anggota Tim?')">
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
                        <i data-lucide="users" class="w-16 h-16 mx-auto mb-4 text-[#64748B]"></i>
                        <p class="font-bold uppercase tracking-widest text-xs">Belum ada anggota tim</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
