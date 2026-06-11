@extends('layouts.admin')

@section('title', 'Incoming Orders - Admin Silua Toba')
@section('page_title', 'Order Management')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,900;1,700&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<div class="space-y-10 animate-fade-in">
    <!-- HEADER -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h1 class="text-4xl font-black italic text-gray-900" style="font-family: 'Playfair Display', serif;">Daftar <span class="text-amber-700">Pesanan</span></h1>
            <p class="text-gray-400 text-sm mt-1 italic">Pantau status transaksi dan progres pengiriman secara real-time.</p>
        </div>
        <div class="flex gap-4">
            <div class="px-6 py-4 bg-white rounded-2xl shadow-sm border border-gray-100 flex items-center gap-3">
                <span class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></span>
                <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">{{ $orders->where('status', 'pending')->count() }} Menunggu</span>
            </div>
        </div>
    </div>

    @if(session('success'))
    {{-- Alert handled by layout --}}
    @endif

    <!-- DATA TABLE -->
    <div class="bg-white rounded-[3.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-50">
                        <th class="px-10 py-8 text-[10px] font-black uppercase tracking-[0.3em] text-gray-400">Ref Pesanan</th>
                        <th class="px-10 py-8 text-[10px] font-black uppercase tracking-[0.3em] text-gray-400">Info Pelanggan</th>
                        <th class="px-10 py-8 text-[10px] font-black uppercase tracking-[0.3em] text-gray-400">Item Pesanan</th>
                        <th class="px-10 py-8 text-[10px] font-black uppercase tracking-[0.3em] text-gray-400">Total Investasi</th>
                        <th class="px-10 py-8 text-[10px] font-black uppercase tracking-[0.3em] text-gray-400">Tahap Saat Ini</th>
                        <th class="px-10 py-8 text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 text-center">Proses</th>
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
                            <div class="text-[9px] font-black text-amber-700/50 uppercase tracking-widest mt-1">Pelanggan Terverifikasi</div>
                        </td>
                        <td class="px-10 py-8">
                            <div class="space-y-2">
                                @foreach($o->items as $item)
                                    <div class="flex items-center gap-3 text-xs italic text-gray-500">
                                        <div class="w-1.5 h-1.5 rounded-full bg-amber-700/20"></div>
                                        <span>{{ $item->product->name }} <b class="text-gray-900 ml-1">x{{ $item->quantity }}</b></span>
                                    </div>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-10 py-8">
                            <div class="font-black text-gray-900 text-lg italic">Rp {{ number_format($o->total_price, 0, ',', '.') }}</div>
                        </td>
                        <td class="px-10 py-8">
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                                    'accepted' => 'bg-green-100 text-green-700 border-green-200',
                                    'shipping' => 'bg-blue-100 text-blue-700 border-blue-200',
                                    'delivered' => 'bg-gray-900 text-white border-gray-900',
                                    'rejected' => 'bg-red-100 text-red-700 border-red-200'
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
                                        <button name="status" value="accepted" class="px-6 py-2 bg-gray-900 text-white rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-amber-700 transition-all shadow-lg shadow-gray-200">Setujui</button>
                                        <button type="button" onclick="showRejectModal({{ $o->id }})" class="px-6 py-2 bg-gray-50 text-gray-400 rounded-xl text-[9px] font-black uppercase tracking-widest border border-gray-100 hover:bg-red-50 hover:text-red-500 transition-all">Tolak</button>
                                    @elseif($o->status == 'accepted')
                                        <button name="status" value="shipping" class="px-6 py-2 bg-amber-700 text-white rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-gray-900 transition-all shadow-lg shadow-amber-700/20">Kirim</button>
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
                            <p class="text-xl font-bold">Tidak ada transaksi aktif.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Reject Logic -->
<form id="formReject" action="" method="POST" class="hidden">
    @csrf @method('PATCH')
    <input type="hidden" name="status" value="rejected">
    <input type="hidden" name="reject_reason" id="inputRejectReason">
</form>

<script>
    function showRejectModal(id) {
        let reason = prompt("Masukkan alasan penolakan untuk pelanggan:");
        if (reason != null && reason != "") {
            let form = document.getElementById('formReject');
            form.action = "/admin/pesanan/" + id + "/update";
            document.getElementById('inputRejectReason').value = reason;
            form.submit();
        }
    }
</script>
@endsection
