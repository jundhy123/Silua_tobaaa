@extends('layouts.user')

@section('title', 'Pesanan Saya - Pelacakan Silua Toba')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<div class="bg-[#FDFDFB] min-h-screen pt-40 pb-40 overflow-hidden">
    <div class="max-w-5xl mx-auto px-8">

        <!-- HEADER -->
        <header class="mb-24 reveal-up text-center">
            <span class="micro-label mb-6 block">Riwayat Pesanan</span>
            <h1 class="text-5xl md:text-7xl font-black italic leading-tight mb-8" style="font-family: 'Playfair Display', serif;">
                Pesanan <i>Saya</i>
            </h1>
            <div class="w-24 h-1 bg-amber-700 mx-auto mt-12"></div>
        </header>

        @forelse($orders as $order)
        <div class="group bg-white rounded-[3rem] p-12 md:p-16 mb-12 shadow-sm border border-black/5 reveal-up hover:shadow-2xl transition-all duration-700">
            <!-- Order Meta -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-8 mb-16 border-b border-black/5 pb-12">
                <div>
                    <div class="flex flex-wrap items-center gap-4 mb-3">
                        <h3 class="text-3xl font-black italic text-navy-dark" style="font-family: 'Playfair Display', serif;">ID-{{ $order->id }}</h3>

                        <!-- Status Badge -->
                        @php
                            $statusClasses = [
                                'pending' => 'bg-amber-100 text-amber-700',
                                'accepted' => 'bg-green-100 text-green-700',
                                'confirmed' => 'bg-blue-100 text-blue-700',
                                'shipping' => 'bg-indigo-100 text-indigo-700',
                                'delivered' => 'bg-green-100 text-green-700',
                                'rejected' => 'bg-red-100 text-red-700'
                            ];
                            $statusLabels = [
                                'pending' => 'Menunggu Konfirmasi',
                                'accepted' => 'Disetujui',
                                'confirmed' => 'Dikonfirmasi',
                                'shipping' => 'Dalam Pengiriman',
                                'delivered' => 'Selesai',
                                'rejected' => 'Dibatalkan'
                            ];
                        @endphp
                        <span class="px-4 py-2 rounded-full text-[9px] font-black uppercase tracking-widest {{ $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-500' }}">
                            {{ $statusLabels[$order->status] ?? strtoupper($order->status) }}
                        </span>
                    </div>
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Dipesan pada {{ $order->created_at->format('d M Y • H:i') }}</p>
                </div>

                <div class="text-left md:text-right">
                    <span class="text-[9px] font-black uppercase tracking-widest text-gray-400 block mb-2">Total Investasi Rasa</span>
                    <span class="text-3xl font-black text-amber-700 italic">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            @if($order->status == 'rejected')
                <!-- REJECTED STATE -->
                <div class="bg-red-50/50 rounded-[2.5rem] p-10 border border-red-100 flex items-center gap-8">
                    <div class="w-16 h-16 bg-red-500 text-white rounded-full flex items-center justify-center text-3xl shrink-0">✕</div>
                    <div>
                        <h4 class="text-red-700 font-black uppercase tracking-widest text-[10px] mb-2">Pesanan Dibatalkan</h4>
                        <p class="text-gray-600 italic">"{{ $order->reject_reason ?? 'Mohon maaf, pesanan tidak dapat kami proses saat ini.' }}"</p>
                    </div>
                </div>
            @else
                <!-- TRACKING PROGRESS -->
                <div class="relative pt-10 px-4">
                    <div class="flex justify-between relative z-10">
                        @php
                            $steps = [
                                ['label' => 'Dibuat', 'icon' => 'check', 'active_on' => ['pending', 'accepted', 'confirmed', 'shipping', 'delivered']],
                                ['label' => 'Disetujui', 'icon' => 'award', 'active_on' => ['accepted', 'confirmed', 'shipping', 'delivered']],
                                ['label' => 'Dikirim', 'icon' => 'truck', 'active_on' => ['shipping', 'delivered']],
                                ['label' => 'Tiba', 'icon' => 'home', 'active_on' => ['delivered']]
                            ];
                        @endphp

                        @foreach($steps as $index => $step)
                            @php
                                $isActive = in_array($order->status, $step['active_on']);
                                $isCurrent = ($order->status == 'pending' && $index == 0) ||
                                            ($order->status == 'accepted' && $index == 1) ||
                                            ($order->status == 'confirmed' && $index == 1) ||
                                            ($order->status == 'shipping' && $index == 2) ||
                                            ($order->status == 'delivered' && $index == 3);
                            @endphp
                            <div class="flex flex-col items-center group/step">
                                <div class="w-14 h-14 rounded-full flex items-center justify-center transition-all duration-500 border-2
                                    {{ $isActive ? 'bg-black border-black text-white shadow-xl scale-110' : 'bg-white border-black/5 text-black/20' }}
                                    {{ $isCurrent ? 'ring-8 ring-amber-700/10' : '' }}">
                                    <i data-lucide="{{ $step['icon'] }}" class="w-5 h-5"></i>
                                </div>
                                <span class="text-[9px] font-black uppercase tracking-widest mt-6 {{ $isActive ? 'text-black' : 'text-black/20' }}">
                                    {{ $step['label'] }}
                                </span>
                            </div>

                            @if(!$loop->last)
                                <div class="flex-1 h-px bg-black/5 mt-7 relative mx-4">
                                    <div class="absolute inset-0 bg-amber-700 transition-all duration-1000 origin-left"
                                         style="transform: scaleX({{ $isActive && in_array($order->status, $steps[$index+1]['active_on']) ? 1 : 0 }})"></div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        @empty
        <div class="py-40 text-center opacity-20 reveal-up">
            <i data-lucide="package-search" class="w-20 h-20 mx-auto mb-8"></i>
            <p class="text-2xl font-black italic">Belum ada jejak pesanan.</p>
            <a href="{{ route('user.products') }}" class="inline-block mt-10 px-10 py-5 bg-black text-white rounded-full text-[10px] font-black uppercase tracking-widest hover:bg-amber-700 transition-all">Mulai Berbelanja</a>
        </div>
        @endforelse
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.reveal-up').forEach(el => observer.observe(el));
        if(typeof lucide !== 'undefined') lucide.createIcons();
    });
</script>

<style>
    .micro-label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.4em; color: #B45309; }
    .reveal-up { opacity: 0; transform: translateY(50px); transition: all 1.2s cubic-bezier(0.16, 1, 0.3, 1); }
    .reveal-up.show { opacity: 1; transform: translate(0, 0); }
</style>
@endsection
