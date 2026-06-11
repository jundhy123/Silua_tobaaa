@extends('layouts.admin')

@section('title', 'Kelola Inventaris - Admin Silua Toba')
@section('page_title', 'Inventaris Produk')

@section('content')
<link rel="stylesheet" href="{{ asset('css/produk-admin.css') }}">

<div class="space-y-10 animate-fade-in">
    <!-- TOP ACTION BAR -->
    <div class="admin-header-flex">
        <div>
            <h1 class="main-title-premium">Daftar <span class="text-[#4FB7B3]">Produk</span></h1>
            <p class="text-[#64748B] text-sm mt-1 italic">Total {{ $products->count() }} produk tersedia dalam katalog.</p>
        </div>
        <a href="{{ route('admin.produk.create') }}" class="btn-admin-add">
            <i data-lucide="plus"></i>
            Tambah Produk
        </a>
    </div>

    <!-- DATA TABLE CARD -->
    <div class="admin-table-card">
        <table class="admin-table">
            <thead>
                <tr>
                    <th width="100">Media</th>
                    <th>Identitas</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $p)
                <tr>
                    <td>
                        <img src="{{ asset('uploads/products/' . $p->image) }}" class="product-thumb">
                    </td>
                    <td>
                        <div class="product-name-bold">{{ $p->name }}</div>
                        <div class="product-meta-small">SKU: PROD-{{ sprintf('%03d', $p->id) }}</div>
                    </td>
                    <td>
                        <span class="badge-pill bg-[#F8FAFC] text-[#31326F] border border-[#E2E8F0]">
                            {{ $p->category }}
                        </span>
                    </td>
                    <td>
                        <div class="font-bold text-[#31326F]">Rp {{ number_format($p->price, 0, ',', '.') }}</div>
                    </td>
                    <td>
                        <div class="flex justify-center gap-3">
                            <a href="{{ route('admin.produk.edit', $p->id) }}" class="action-btn edit" title="Edit">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('admin.produk.destroy', $p->id) }}" method="POST" onsubmit="return confirmDelete(this, 'Hapus Produk?', 'Produk ini akan dihapus secara permanen.')">
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
                    <td colspan="5" class="py-20 text-center opacity-30">
                        <i data-lucide="package-search" class="w-16 h-16 mx-auto mb-4"></i>
                        <p class="font-bold uppercase tracking-widest text-xs">Inventaris Kosong</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
