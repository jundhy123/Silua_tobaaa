@extends('layouts.admin')

@section('title', 'Kelola Tim')
@section('page_title', 'Daftar Tim Silua Toba')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
    <div>
        <h3 class="text-3xl font-black text-navy-dark uppercase tracking-tighter">Anggota Tim</h3>
        <p class="text-gray-500 text-sm">Kelola foto dan jabatan pemilik serta staff.</p>
    </div>
    <a href="{{ route('admin.teams.create') }}" class="btn-admin-primary">
        <i data-lucide="user-plus" class="w-5 h-5"></i>
        <span>Tambah Anggota</span>
    </a>
</div>

@if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-xl flex items-center gap-3">
        <i data-lucide="check-circle" class="text-green-500 w-5 h-5"></i>
        <p class="text-sm text-green-700 font-bold">{{ session('success') }}</p>
    </div>
@endif

<div class="admin-card overflow-hidden">
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th class="text-center">Foto</th>
                    <th>Nama Lengkap</th>
                    <th>Jabatan</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($teams as $t)
                <tr>
                    <td class="text-center w-32">
                        <img src="{{ asset('uploads/teams/'.$t->photo) }}" class="product-img-thumb shadow-sm" style="width: 60px; height: 80px; object-fit: cover;">
                    </td>
                    <td>
                        <div class="product-name-title">{{ $t->name }}</div>
                    </td>
                    <td>
                        <span class="badge-pill-category" style="background: #FEF3C7; color: #B45309;">
                            {{ $t->position }}
                        </span>
                    </td>
                    
                    <td>
                        <div class="flex justify-center gap-3">
                            <!-- ✅ TOMBOL EDIT BARU -->
                            <a href="{{ route('admin.teams.edit', $t->id) }}" class="action-btn-pill edit" title="Ubah Data">
                                <i data-lucide="edit-3"></i>
                                <span>Edit</span>
                            </a>

                            <!-- TOMBOL HAPUS -->
                            <form action="{{ route('admin.teams.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Hapus anggota ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn-pill delete">
                                    <i data-lucide="trash-2"></i>
                                    <span>Hapus</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-20 text-center">
                        <i data-lucide="users" class="w-16 h-16 mx-auto text-gray-200 mb-4"></i>
                        <p class="text-gray-400 font-bold italic">Belum ada anggota tim...</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection