@extends('layouts.admin')

@section('title', 'Kelola Produk - Silua Toba')

@section('content')
<link rel="stylesheet" href="{{ asset('css/produk-admin.css') }}">

<div class="admin-page-container">
    <div class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-3xl font-black text-navy-dark uppercase tracking-tighter">Kelola Produk</h1>
            <p class="text-gray-400 text-sm">Dashboard / 
                <span class="text-orange-brand font-bold">
                    {{ $profiles->company_name ?? 'Silua Toba' }} <!-- FIX ERROR: Tanpa isEmpty -->
                </span>
            </p>
        </div>
        <a href="{{ route('admin.produk.create') }}" class="btn-admin-primary">
            <i data-lucide="plus-circle"></i> TAMBAH PRODUK
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-8 rounded-r-2xl animate-fade-in">
        <p class="text-green-700 font-bold text-sm">{{ session('success') }}</p>
    </div>
    @endif

    <div class="admin-card">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Info Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $p)
                    <tr>
                        <td>
                            <img src="{{ asset('uploads/products/' . $p->image) }}" class="product-img-thumb shadow-sm">
                        </td>
                        <td>
                            <div class="product-name-title">{{ $p->name }}</div>
                            <div class="product-id-tag">ID: #PROD-00{{ $p->id }}</div>
                        </td>
                        <td>
                            <span class="badge-pill-category">{{ $p->category }}</span>
                        </td>
                        <td>
                            <div class="price-text">Rp {{ number_format($p->price, 0, ',', '.') }}</div>
                        </td>
                        <td>
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.produk.edit', $p->id) }}" class="action-btn-pill edit">
                                    <i data-lucide="edit-3"></i> Edit
                                </a>
                                <form action="{{ route('admin.produk.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-btn-pill delete">
                                        <i data-lucide="trash-2"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-20 opacity-30">
                            <i data-lucide="package-search" class="w-16 h-16 mx-auto mb-4"></i>
                            <p class="font-bold uppercase tracking-widest">Belum ada produk</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection