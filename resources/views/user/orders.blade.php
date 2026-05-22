@extends('layouts.user')

@section('content')
<link rel="stylesheet" href="{{ asset('css/produk-user.css') }}">
<style>
    .tracking-wrapper { background: #F9F9F4; min-height: 100vh; padding-top: 150px; }
    .order-card { background: white; border-radius: 30px; padding: 40px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
    
    /* Premium Status Badges */
    .badge-status-order {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 1px;
        display: inline-block;
    }
    .status-pending { background: #fff8e1; color: #f57c00; }
    .status-accepted, .status-confirmed { background: #e8f5e9; color: #2e7d32; }
    .status-shipping { background: #e3f2fd; color: #1565c0; }
    .status-delivered { background: #1A3A34; color: white; }
    .status-rejected { background: #ffebee; color: #c62828; }

    .step-icon { width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; font-size: 20px; transition: 0.3s; }
    .line-step { height: 2px; flex: 1; background: #eee; margin-top: 25px; }
    .step-active { background: #1A3A34; color: white; box-shadow: 0 10px 20px rgba(26, 58, 52, 0.2); }
    .step-inactive { background: #f5f5f5; color: #ccc; }
</style>

<div class="tracking-wrapper">
    <div class="container">
        <header class="text-center mb-16">
            <span class="text-orange-brand font-bold tracking-widest text-xs uppercase">Riwayat Belanja</span>
            <h1 class="text-5xl font-black text-navy-dark italic mt-2" style="font-family: 'Playfair Display', serif;">Pesanan Saya</h1>
        </header>

        @forelse($orders as $order)
        <div class="order-card reveal">
            <div class="flex justify-between items-center border-b pb-6 mb-8">
                <div>
                    <div class="flex items-center gap-3">
                        <h3 class="text-xl font-bold text-navy-dark">Order #ID-{{ $order->id }}</h3>
                        <span class="badge-status-order status-{{ $order->status }}">
                            @if($order->status == 'pending')
                                Menunggu Konfirmasi
                            @elseif($order->status == 'accepted')
                                Disetujui
                            @elseif($order->status == 'confirmed')
                                Dikonfirmasi
                            @elseif($order->status == 'shipping')
                                Dalam Pengiriman
                            @elseif($order->status == 'delivered')
                                Selesai
                            @elseif($order->status == 'rejected')
                                Dibatalkan
                            @else
                                {{ strtoupper($order->status) }}
                            @endif
                        </span>
                    </div>
                    <p class="text-gray-400 text-xs uppercase tracking-widest mt-1">{{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div class="text-right">
                    <span class="text-xs font-black uppercase tracking-widest text-gray-400 block mb-1">Total Tagihan</span>
                    <span class="text-2xl font-black text-orange-brand">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            @if($order->status == 'rejected')
                <!-- TAMPILAN JIKA DITOLAK -->
                <div class="p-8 bg-red-50 rounded-[2rem] border border-red-100 flex items-center gap-6">
                    <div class="w-16 h-16 bg-red-500 text-white rounded-full flex items-center justify-center text-3xl">✕</div>
                    <div>
                        <h4 class="text-red-600 font-black uppercase tracking-widest text-sm">Pesanan Dibatalkan</h4>
                        <p class="text-gray-600 mt-1">Alasan: <span class="italic">"{{ $order->reject_reason ?? 'Tidak ada alasan spesifik.' }}"</span></p>
                    </div>
                </div>
            @else
                <!-- LINI MASA PROGRESS -->
                <div class="flex items-start justify-between relative px-4">
                    <!-- Step 1 -->
                    <div class="text-center flex-1">
                        <div class="step-icon step-active">✓</div>
                        <h5 class="text-[10px] font-black uppercase tracking-widest text-navy-dark">Dibuat</h5>
                    </div>

                    <div class="line-step {{ in_array($order->status, ['accepted', 'confirmed', 'shipping', 'delivered']) ? 'bg-navy-dark' : '' }}"></div>

                    <!-- Step 2 -->
                    <div class="text-center flex-1">
                        <div class="step-icon {{ in_array($order->status, ['accepted', 'confirmed', 'shipping', 'delivered']) ? 'step-active' : 'step-inactive' }}">
                            {{ in_array($order->status, ['accepted', 'confirmed', 'shipping', 'delivered']) ? '✓' : '⏰' }}
                        </div>
                        <h5 class="text-[10px] font-black uppercase tracking-widest text-navy-dark">Disetujui</h5>
                    </div>

                    <div class="line-step {{ in_array($order->status, ['shipping', 'delivered']) ? 'bg-navy-dark' : '' }}"></div>

                    <!-- Step 3 -->
                    <div class="text-center flex-1">
                        <div class="step-icon {{ in_array($order->status, ['shipping', 'delivered']) ? 'step-active' : 'step-inactive' }}">🚚</div>
                        <h5 class="text-[10px] font-black uppercase tracking-widest text-navy-dark">Dikirim</h5>
                    </div>

                    <div class="line-step {{ $order->status == 'delivered' ? 'bg-navy-dark' : '' }}"></div>

                    <!-- Step 4 -->
                    <div class="text-center flex-1">
                        <div class="step-icon {{ $order->status == 'delivered' ? 'step-active' : 'step-inactive' }}">📍</div>
                        <h5 class="text-[10px] font-black uppercase tracking-widest text-navy-dark">Tiba</h5>
                    </div>
                </div>
            @endif
        </div>
        @empty
        <div class="text-center py-20 opacity-20">
            <i data-lucide="shopping-bag" class="w-20 h-20 mx-auto mb-4"></i>
            <p class="text-xl font-bold uppercase tracking-widest">Belum ada pesanan</p>
        </div>
        @endforelse
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

        if(typeof lucide !== 'undefined') lucide.createIcons();
    });
</script>
@endsection