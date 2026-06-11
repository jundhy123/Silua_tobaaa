@php
    $cards = [
        ['label' => 'Total Pesanan', 'val' => $stats['total'], 'icon' => 'layers', 'bg' => 'bg-gray-50', 'text' => 'text-gray-600'],
        ['label' => 'Pesanan Baru', 'val' => $stats['new'], 'icon' => 'bell', 'bg' => 'bg-amber-50', 'text' => 'text-amber-600'],
        ['label' => 'Diproses', 'val' => $stats['processing'], 'icon' => 'refresh-cw', 'bg' => 'bg-blue-50', 'text' => 'text-blue-600'],
        ['label' => 'Dikirim', 'val' => $stats['shipping'], 'icon' => 'truck', 'bg' => 'bg-indigo-50', 'text' => 'text-indigo-600'],
        ['label' => 'Selesai', 'val' => $stats['completed'], 'icon' => 'check-circle', 'bg' => 'bg-green-50', 'text' => 'text-green-600'],
        ['label' => 'Batal', 'val' => $stats['cancelled'], 'icon' => 'x-circle', 'bg' => 'bg-red-50', 'text' => 'text-red-600'],
    ];
@endphp

@foreach($cards as $c)
<div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all">
    <div class="w-9 h-9 {{ $c['bg'] }} {{ $c['text'] }} rounded-xl flex items-center justify-center mb-3">
        <i data-lucide="{{ $c['icon'] }}" class="w-4 h-4"></i>
    </div>
    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">{{ $c['label'] }}</p>
    <h3 class="text-xl font-black text-gray-900 mt-1">{{ $c['val'] }}</h3>
</div>
@endforeach

<div class="bg-amber-700 p-5 rounded-2xl shadow-lg shadow-amber-700/10 text-white">
    <div class="w-9 h-9 bg-white/10 text-white rounded-xl flex items-center justify-center mb-3">
        <i data-lucide="wallet" class="w-4 h-4"></i>
    </div>
    <p class="text-[9px] font-black text-white/60 uppercase tracking-widest">Revenue</p>
    <h3 class="text-lg font-black text-white mt-1">Rp {{ number_format($stats['revenue']/1000, 0) }}k</h3>
</div>
