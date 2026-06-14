@extends('layouts.admin')

@section('title', 'Kelola Inventaris - Admin Silua Toba')
@section('page_title', 'Inventaris Produk')

@section('content')
<link rel="stylesheet" href="{{ asset('css/produk-admin.css') }}">
<style>
    :root {
        --primary-orange: #FF5722;
    }
    .text-primary-orange { color: var(--primary-orange); }
    .bg-primary-orange { background-color: var(--primary-orange); }
    .main-title-premium span { color: var(--primary-orange) !important; }
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
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }
    .btn-admin-add:hover {
        background-color: var(--primary-orange);
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(255, 87, 34, 0.2);
    }
</style>

<div class="space-y-10 animate-fade-in">
    <!-- TOP ACTION BAR -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h1 class="text-4xl font-black italic text-gray-900" style="font-family: 'Playfair Display', serif;">Daftar <span class="text-primary-orange">Produk</span></h1>
            <p class="text-gray-400 text-sm mt-1 italic">Total {{ $products->total() }} produk tersedia dalam katalog.</p>
        </div>
        <a href="{{ route('admin.produk.create') }}" class="btn-admin-add">
            <i data-lucide="plus"></i>
            Tambah Produk
        </a>
    </div>

    <!-- DATA TABLE CARD -->
    <div class="bg-white rounded-[3.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-50">
                    <th class="px-10 py-8 text-[10px] font-black uppercase tracking-[0.3em] text-gray-400" width="120">Media</th>
                    <th class="px-10 py-8 text-[10px] font-black uppercase tracking-[0.3em] text-gray-400">Identitas</th>
                    <th class="px-10 py-8 text-[10px] font-black uppercase tracking-[0.3em] text-gray-400">Kategori</th>
                    <th class="px-10 py-8 text-[10px] font-black uppercase tracking-[0.3em] text-gray-400">Harga</th>
                    <th class="px-10 py-8 text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($products as $p)
                <tr class="group hover:bg-gray-50/50 transition-all duration-300">
                    <td class="px-10 py-8">
                        <img src="{{ asset('uploads/products/' . $p->image) }}" class="w-20 h-20 object-cover rounded-2xl shadow-sm group-hover:scale-105 transition-transform duration-500">
                    </td>
                    <td class="px-10 py-8">
                        <div class="font-bold text-gray-900 text-lg italic" style="font-family: 'Playfair Display', serif;">{{ $p->name }}</div>
                        <div class="text-[9px] font-black text-gray-400 uppercase tracking-widest mt-1">SKU: PROD-{{ sprintf('%03d', $p->id) }}</div>
                    </td>
                    <td class="px-10 py-8">
                        <span class="px-4 py-2 rounded-full text-[9px] font-black uppercase tracking-widest bg-gray-50 text-gray-600 border border-gray-100">
                            {{ $p->category }}
                        </span>
                    </td>
                    <td class="px-10 py-8">
                        <div class="font-black text-gray-900 text-lg italic">Rp {{ number_format($p->price, 0, ',', '.') }}</div>
                    </td>
                    <td class="px-10 py-8">
                        <div class="flex justify-center gap-3">
                            <a href="{{ route('admin.produk.edit', $p->id) }}" class="p-3 bg-gray-50 text-gray-400 rounded-xl hover:bg-gray-900 hover:text-white transition-all">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('admin.produk.destroy', $p->id) }}" method="POST" onsubmit="return confirmDelete(this, 'Hapus Produk?', 'Produk ini akan dihapus secara permanen.')">
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
                    <td colspan="5" class="px-10 py-32 text-center opacity-30 italic">
                        <i data-lucide="package-search" class="w-20 h-20 mx-auto mb-6 text-gray-200"></i>
                        <p class="text-xl font-bold">Inventaris Kosong</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- PAGINATION -->
        @if($products->hasPages())
        <div class="px-10 py-8 bg-gray-50/50 border-t border-gray-50">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
