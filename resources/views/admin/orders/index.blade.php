@extends('layouts.admin')

@section('title', 'Pesanan Masuk - Admin Silua Toba')

@section('content')
<link rel="stylesheet" href="{{ asset('css/produk-admin.css') }}">

<div class="admin-page-container">
    <!-- Header -->
    <div class="mb-10">
        <h1 class="main-title-serif italic">Pesanan Masuk</h1>
        <p class="text-gray-400 text-sm">Kelola status pesanan pelanggan dan pantau progres pengiriman.</p>
    </div>

    @if(session('success'))
    <div class="alert-premium">
        <i data-lucide="check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <div class="admin-card">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Waktu & Kode</th>
                        <th>Pelanggan</th>
                        <th>Daftar Produk</th>
                        <th>Total Tagihan</th>
                        <th>Status Saat Ini</th>
                        <th class="text-center">Update Progres</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $o)
                    <tr>
                        <!-- Waktu & Kode -->
                        <td>
                            <div class="font-bold text-navy-dark">#{{ $o->id }}</div>
                            <div class="text-[10px] text-gray-400 uppercase tracking-widest">{{ $o->created_at->format('d M Y, H:i') }}</div>
                        </td>

                        <!-- Pelanggan -->
                        <td>
                            <div class="product-name-title" style="font-family: 'Poppins', sans-serif; font-size: 14px;">
                                {{ $o->user->name ?? 'Tamu' }}
                            </div>
                            <div class="product-id-tag">{{ $o->user->phone ?? 'No Phone' }}</div>
                        </td>

                        <!-- Detail Produk -->
                        <td>
                            <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                                <ul class="text-[11px] space-y-1">
                                    @foreach($o->items as $item)
                                        <li class="flex justify-between gap-4">
                                            <span class="text-gray-600 font-medium">• {{ $item->product->name }}</span>
                                            <span class="font-bold text-navy-dark">x{{ $item->quantity }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </td>

                        <!-- Total -->
                        <td>
                            <div class="price-text text-orange-brand">
                                Rp {{ number_format($o->total_price, 0, ',', '.') }}
                            </div>
                        </td>

                        <!-- Badge Status -->
                        <td>
                            <span class="badge-status-order status-{{ $o->status }}">
                                {{ strtoupper($o->status) }}
                            </span>
                        </td>

                        <!-- Aksi Form -->
                        <td>
                            <div class="flex flex-col gap-2">
                                <form action="{{ route('admin.orders.update', $o->id) }}" method="POST" class="flex flex-wrap gap-1">
                                    @csrf
                                    @method('PATCH')

                                    @if($o->status == 'pending')
                                        <button name="status" value="accepted" class="btn-action-status accept">Setujui</button>
                                        <button type="button" onclick="showRejectModal({{ $o->id }})" class="btn-action-status reject">Tolak</button>
                                    @elseif($o->status == 'accepted')
                                        <button name="status" value="shipping" class="btn-action-status ship">Kirim Pesanan</button>
                                    @elseif($o->status == 'shipping')
                                        <button name="status" value="delivered" class="btn-action-status deliver">Selesaikan</button>
                                    @endif
                                </form>

                                {{-- Tombol Hapus (Hanya muncul jika sudah Selesai atau Ditolak) --}}
                                @if(in_array($o->status, ['delivered', 'rejected']))
                                <form action="{{ route('admin.orders.destroy', $o->id) }}" method="POST" onsubmit="return confirm('Hapus permanen riwayat ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-[9px] font-black text-red-400 hover:text-red-600 underline uppercase tracking-widest">Hapus Data</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-20 opacity-30">
                            <i data-lucide="inbox" class="w-16 h-16 mx-auto mb-4"></i>
                            <p class="font-bold uppercase tracking-widest">Belum ada pesanan masuk</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Alasan Penolakan (Manual via JS Prompt demi kepraktisan) -->
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

<style>
    /* Styling Tambahan untuk Status Badge */
    .badge-status-order {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 9px;
        font-weight: 800;
        letter-spacing: 1px;
    }
    .status-pending { background: #fff8e1; color: #f57c00; }
    .status-accepted { background: #e8f5e9; color: #2e7d32; }
    .status-shipping { background: #e3f2fd; color: #1565c0; }
    .status-delivered { background: #1A3A34; color: white; }
    .status-rejected { background: #ffebee; color: #c62828; }

    .btn-action-status {
        padding: 8px 12px;
        border-radius: 10px;
        border: none;
        font-size: 10px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.3s;
    }
    .btn-action-status.accept { background: #1A3A34; color: white; }
    .btn-action-status.reject { background: #f5f5f5; color: #999; }
    .btn-action-status.ship { background: #FF5722; color: white; }
    .btn-action-status.deliver { background: #4caf50; color: white; }
    
    .btn-action-status:hover { transform: translateY(-2px); filter: brightness(1.1); }
</style>

@endsection