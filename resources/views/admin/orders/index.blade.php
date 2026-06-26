@extends('layouts.admin')

@section('title', 'Manajemen Pesanan - Admin Silua Toba')
@section('page_title', 'Pesanan Masuk')

@section('content')
<style>
    :root {
        --primary-orange: #FF5722;
        --navy-dark: #1a1a3a;
    }
    .text-primary-orange { color: var(--primary-orange); }
    .bg-primary-orange { background-color: var(--primary-orange); }
    .border-primary-orange { border-color: var(--primary-orange); }
</style>

<div class="space-y-8 animate-fade-in">
    <!-- HEADER -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h1 class="text-4xl font-black italic text-gray-900" style="font-family: 'Playfair Display', serif;">Daftar <span class="text-primary-orange">Pesanan</span></h1>
            <p class="text-gray-400 text-sm mt-1 italic">Pantau status transaksi dan progres pengiriman secara real-time.</p>
        </div>
        <div class="flex gap-4">
            <div class="px-6 py-4 bg-white rounded-2xl shadow-sm border border-gray-100 flex items-center gap-3">
                <span class="w-2 h-2 bg-primary-orange rounded-full animate-pulse"></span>
                <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">{{ $stats['new'] }} Menunggu</span>
            </div>
        </div>
    </div>

    <!-- FILTERS -->
    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Search -->
            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Cari Pesanan</label>
                <div class="relative">
                    <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Kode, Nama, Produk..."
                        class="w-full pl-12 pr-4 py-3 bg-gray-50 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary-orange transition-all">
                </div>
            </div>

            <!-- Category Filter -->
            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Kategori Produk</label>
                <select name="category" class="w-full px-4 py-3 bg-gray-50 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary-orange transition-all appearance-none">
                    <option value="all">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Time Filter -->
            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Waktu Pemesanan</label>
                <select name="group" class="w-full px-4 py-3 bg-gray-50 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary-orange transition-all appearance-none">
                    <option value="all">Semua Waktu</option>
                    <option value="today" {{ request('group') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                    <option value="yesterday" {{ request('group') == 'yesterday' ? 'selected' : '' }}>Kemarin</option>
                    <option value="week" {{ request('group') == 'week' ? 'selected' : '' }}>Minggu Ini</option>
                    <option value="month" {{ request('group') == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                </select>
            </div>

            <!-- Actions -->
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 bg-gray-900 text-white py-3 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-primary-orange transition-all shadow-lg shadow-gray-200">
                    Filter
                </button>
                <a href="{{ route('admin.orders.index') }}" class="px-4 py-3 bg-gray-100 text-gray-400 rounded-xl hover:bg-gray-200 transition-all">
                    <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- DATA TABLE -->
    <div class="bg-white rounded-[3.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-50">
                        <th class="px-10 py-8 text-[10px] font-black uppercase tracking-[0.3em] text-gray-400">Ref Pesanan</th>
                        <th class="px-10 py-8 text-[10px] font-black uppercase tracking-[0.3em] text-gray-400">Pelanggan</th>
                        <th class="px-10 py-8 text-[10px] font-black uppercase tracking-[0.3em] text-gray-400">Item</th>
                        <th class="px-10 py-8 text-[10px] font-black uppercase tracking-[0.3em] text-gray-400">Total</th>
                        <th class="px-10 py-8 text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 text-center">Status</th>
                        <th class="px-10 py-8 text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($orders as $o)
                    <tr class="group hover:bg-gray-50/50 transition-all duration-300">
                        <td class="px-10 py-8">
                            <div class="font-black text-gray-900 text-lg">#ID-{{ $o->id }}</div>
                            <div class="text-[9px] font-black text-gray-400 uppercase tracking-widest mt-1">{{ $o->created_at->format('d M Y • H:i') }}</div>
                        </td>
                        <td class="px-10 py-8">
                            <div class="font-bold text-gray-900 italic text-base" style="font-family: 'Playfair Display', serif;">{{ $o->user->name ?? 'Tamu' }}</div>
                            <div class="text-[9px] font-black text-primary-orange/70 uppercase tracking-widest mt-1">Pelanggan Terverifikasi</div>
                        </td>
                        <td class="px-10 py-8">
                            <div class="space-y-2">
                                @foreach($o->items as $item)
                                    <div class="flex items-center gap-3 text-xs italic text-gray-500">
                                        <div class="w-1.5 h-1.5 rounded-full bg-primary-orange/40"></div>
                                        <span>{{ $item->product->name }} <b class="text-gray-900 ml-1">x{{ $item->quantity }}</b></span>
                                    </div>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-10 py-8">
                            <div class="font-black text-gray-900 text-lg italic">Rp {{ number_format($o->total_price, 0, ',', '.') }}</div>
                        </td>
                        <td class="px-10 py-8 text-center">
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-orange-50 text-orange-600 border-orange-100',
                                    'accepted' => 'bg-green-50 text-green-600 border-green-100',
                                    'shipping' => 'bg-blue-50 text-blue-600 border-blue-100',
                                    'delivered' => 'bg-gray-900 text-white border-gray-900',
                                    'rejected' => 'bg-red-50 text-red-600 border-red-100'
                                ];
                            @endphp
                            <span class="px-4 py-2 rounded-full text-[9px] font-black uppercase tracking-widest border {{ $statusClasses[$o->status] ?? 'bg-gray-100 text-gray-500' }}">
                                {{ strtoupper($o->status) }}
                            </span>
                        </td>
                        <td class="px-10 py-8">
                            <div class="flex flex-col gap-3 items-center">
                                <form action="{{ route('admin.orders.update', $o->id) }}" method="POST" class="flex flex-wrap justify-center gap-2">
                                    @csrf @method('PATCH')

                                    @if($o->status == 'pending')
                                        <button name="status" value="accepted" class="px-6 py-2 bg-gray-900 text-white rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-primary-orange transition-all shadow-lg shadow-gray-200">Setujui</button>
                                        <button type="button" onclick="showRejectModal({{ $o->id }})" class="px-6 py-2 bg-gray-50 text-gray-400 rounded-xl text-[9px] font-black uppercase tracking-widest border border-gray-100 hover:bg-red-50 hover:text-red-500 transition-all">Tolak</button>
                                    @elseif($o->status == 'accepted')
                                        <button name="status" value="shipping" class="px-6 py-2 bg-primary-orange text-white rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-gray-900 transition-all shadow-lg shadow-orange-100">Kirim</button>
                                    @elseif($o->status == 'shipping')
                                        <button name="status" value="delivered" class="px-6 py-2 bg-green-600 text-white rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-gray-900 transition-all shadow-lg shadow-green-100">Selesaikan</button>
                                    @endif
                                </form>

                                @if(in_array($o->status, ['delivered', 'rejected']))
                                <form action="{{ route('admin.orders.destroy', $o->id) }}" method="POST" onsubmit="return confirmDelete(this, 'Hapus Log Pesanan?', 'Riwayat transaksi ini akan dihapus secara permanen.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-[8px] font-black text-gray-300 hover:text-red-500 uppercase tracking-widest underline underline-offset-4 transition-colors">Hapus Log</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-10 py-32 text-center opacity-30 italic">
                            <i data-lucide="inbox" class="w-20 h-20 mx-auto mb-6 text-gray-200"></i>
                            <p class="text-xl font-bold">Tidak ada transaksi yang cocok.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        @if($orders->hasPages())
        <div class="px-10 py-8 bg-gray-50/50 border-t border-gray-50">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal Reject Logic -->
<form id="formReject" action="" method="POST" class="hidden">
    @csrf @method('PATCH')
    <input type="hidden" name="status" value="rejected">
</form>

<script>
    function showRejectModal(id) {
        Swal.fire({
            title: 'Tolak Pesanan?',
            text: 'Pesanan ini akan dibatalkan dan pelanggan akan mendapatkan notifikasi.',
            icon: 'warning',
            iconColor: '#f97316',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#5e6673',
            confirmButtonText: 'Ya, Tolak!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-[2rem] p-8',
                title: 'text-2xl font-bold text-gray-800',
                htmlContainer: 'text-sm text-gray-500',
                confirmButton: 'px-6 py-3 rounded-xl font-bold text-white text-sm bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-200 transition-all duration-300',
                cancelButton: 'px-6 py-3 rounded-xl font-bold text-white text-sm bg-gray-500 hover:bg-gray-600 focus:ring-4 focus:ring-gray-200 transition-all duration-300 ml-3'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                let form = document.getElementById('formReject');
                form.action = "/admin/pesanan/" + id + "/update";
                form.submit();
            }
        });
    }
</script>
@endsection
