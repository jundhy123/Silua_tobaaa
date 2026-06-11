@extends('layouts.admin')

@section('title', 'Laporan Penjualan - Admin Silua Toba')
@section('page_title', 'Laporan & Analitik')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,900;1,700&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="space-y-10 animate-fade-in pb-20">
    <!-- HEADER & PERIOD SELECTOR -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
        <div>
            <h1 class="text-4xl font-black italic text-gray-900" style="font-family: 'Playfair Display', serif;">Laporan <span class="text-[#4FB7B3]">Penjualan</span></h1>
            <p class="text-gray-400 text-sm mt-1 italic">Analisis performa bisnis berdasarkan data pesanan selesai.</p>
        </div>

        <div class="flex bg-white p-1.5 rounded-2xl shadow-sm border border-gray-100">
            @foreach(['daily' => 'Harian', 'weekly' => 'Mingguan', 'monthly' => 'Bulanan', 'yearly' => 'Tahunan'] as $key => $label)
                <a href="{{ route('admin.reports.index', ['period' => $key]) }}"
                   class="px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all
                   {{ $period == $key ? 'bg-[#31326F] text-white shadow-lg' : 'text-gray-400 hover:text-gray-900 hover:bg-gray-50' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- 1. RINGKASAN PENJUALAN (CARDS) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Revenue -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-500 group">
            <div class="flex justify-between items-start mb-6">
                <div class="w-12 h-12 bg-[#A8FBD3]/20 text-[#4FB7B3] rounded-2xl flex items-center justify-center">
                    <i data-lucide="wallet" class="w-6 h-6"></i>
                </div>
                <span class="px-3 py-1 rounded-lg text-[9px] font-bold {{ $stats['revenue']['diff'] >= 0 ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                    {{ $stats['revenue']['diff'] >= 0 ? '+' : '' }}{{ round($stats['revenue']['diff'], 1) }}%
                </span>
            </div>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Pendapatan</p>
            <h3 class="text-2xl font-black text-gray-900 mt-2 tracking-tighter">Rp {{ number_format($stats['revenue']['total'], 0, ',', '.') }}</h3>
            <p class="text-[9px] text-gray-400 mt-4 italic uppercase">Bulan ini: Rp {{ number_format($stats['revenue']['current_month'], 0, ',', '.') }}</p>
        </div>

        <!-- Orders -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-500">
            <div class="flex justify-between items-start mb-6">
                <div class="w-12 h-12 bg-[#637AB9]/10 text-[#637AB9] rounded-2xl flex items-center justify-center">
                    <i data-lucide="shopping-bag" class="w-6 h-6"></i>
                </div>
                <span class="px-3 py-1 rounded-lg text-[9px] font-bold {{ $stats['orders']['diff'] >= 0 ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                    {{ $stats['orders']['diff'] >= 0 ? '+' : '' }}{{ round($stats['orders']['diff'], 1) }}%
                </span>
            </div>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Pesanan Selesai</p>
            <h3 class="text-2xl font-black text-gray-900 mt-2 tracking-tighter">{{ $stats['orders']['total'] }} Transaksi</h3>
            <p class="text-[9px] text-gray-400 mt-4 italic uppercase">Bulan ini: {{ $stats['orders']['current_month'] }} Pesanan</p>
        </div>

        <!-- Products Sold -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-500">
            <div class="flex justify-between items-start mb-6">
                <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center">
                    <i data-lucide="package" class="w-6 h-6"></i>
                </div>
                <span class="px-3 py-1 rounded-lg text-[9px] font-bold {{ $stats['items']['diff'] >= 0 ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                    {{ $stats['items']['diff'] >= 0 ? '+' : '' }}{{ round($stats['items']['diff'], 1) }}%
                </span>
            </div>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Produk Terjual</p>
            <h3 class="text-2xl font-black text-gray-900 mt-2 tracking-tighter">{{ $stats['items']['total'] }} Produk</h3>
            <p class="text-[9px] text-gray-400 mt-4 italic uppercase">Bulan ini: {{ $stats['items']['current_month'] }} terjual</p>
        </div>

        <!-- Profit -->
        <div class="bg-[#31326F] p-8 rounded-[2.5rem] shadow-lg shadow-[#31326F]/20 transition-all duration-500 text-white">
            <div class="flex justify-between items-start mb-6">
                <div class="w-12 h-12 bg-white/10 text-[#A8FBD3] rounded-2xl flex items-center justify-center">
                    <i data-lucide="trending-up" class="w-6 h-6"></i>
                </div>
                <div class="flex items-center gap-1 text-[9px] font-bold text-[#A8FBD3]">
                    <i data-lucide="info" class="w-3 h-3"></i> 30% Margin
                </div>
            </div>
            <p class="text-[10px] font-black text-white/50 uppercase tracking-widest">Estimasi Keuntungan</p>
            <h3 class="text-2xl font-black text-white mt-2 tracking-tighter">Rp {{ number_format($stats['profit']['total'], 0, ',', '.') }}</h3>
            <p class="text-[9px] text-white/30 mt-4 italic uppercase">Estimasi laba kotor akumulasi</p>
        </div>
    </div>

    <!-- 2. GRAFIK UTAMA -->
    <div class="bg-white p-10 rounded-[3.5rem] border border-gray-100 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 gap-6">
            <div>
                <h3 class="text-xl font-black text-gray-900 italic" style="font-family: 'Playfair Display', serif;">Tren Penjualan</h3>
                <p class="text-[10px] text-gray-400 mt-1 uppercase tracking-widest font-black">Visualisasi Data Berdasarkan Periode {{ ucfirst($period) }}</p>
            </div>
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-[#4FB7B3]"></span>
                    <span class="text-[9px] font-black text-gray-500 uppercase">Pendapatan</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-[#31326F]"></span>
                    <span class="text-[9px] font-black text-gray-500 uppercase">Transaksi</span>
                </div>
            </div>
        </div>
        <div class="relative h-[400px]">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <!-- 3. KATEGORI & PRODUK TERLARIS -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Distribusi Kategori -->
        <div class="lg:col-span-5 bg-white p-10 rounded-[3.5rem] border border-gray-100 shadow-sm">
            <h3 class="text-xl font-black text-gray-900 italic mb-8" style="font-family: 'Playfair Display', serif;">Distribusi Kategori</h3>

            <div class="flex flex-col md:flex-row items-center gap-10">
                <div class="w-48 h-48 shrink-0">
                    <canvas id="categoryChart"></canvas>
                </div>

                <div class="flex-1 space-y-6 w-full">
                    @foreach($categoryDist['data'] as $cat)
                    <div class="space-y-2">
                        <div class="flex justify-between items-end">
                            <span class="text-[10px] font-black text-gray-900 uppercase tracking-widest">{{ $cat['name'] }}</span>
                            <span class="text-[11px] font-bold text-[#4FB7B3]">{{ $cat['percentage'] }}%</span>
                        </div>
                        <div class="h-2 bg-gray-50 rounded-full overflow-hidden">
                            @php
                                $colors = ['Minuman' => '#4FB7B3', 'Camilan' => '#637AB9', 'Makanan Berat' => '#31326F'];
                                $bgColor = $colors[$cat['name']] ?? '#4FB7B3';
                            @endphp
                            <div class="h-full rounded-full transition-all duration-1000" style="width: {{ $cat['percentage'] }}%; background-color: {{ $bgColor }}"></div>
                        </div>
                        <p class="text-[8px] text-gray-400 font-bold uppercase">{{ $cat['count'] }} Produk Terjual</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Produk Terlaris -->
        <div class="lg:col-span-7 bg-white p-10 rounded-[3.5rem] border border-gray-100 shadow-sm">
            <div class="flex justify-between items-center mb-10">
                <h3 class="text-xl font-black text-gray-900 italic" style="font-family: 'Playfair Display', serif;">Produk Terlaris</h3>
                <i data-lucide="award" class="w-6 h-6 text-[#4FB7B3]"></i>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-gray-50">
                            <th class="pb-5 text-[9px] font-black uppercase text-gray-400 tracking-widest">Produk</th>
                            <th class="pb-5 text-[9px] font-black uppercase text-gray-400 tracking-widest text-center">Kategori</th>
                            <th class="pb-5 text-[9px] font-black uppercase text-gray-400 tracking-widest text-center">Terjual</th>
                            <th class="pb-5 text-[9px] font-black uppercase text-gray-400 tracking-widest text-right">Kontribusi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($topProducts as $tp)
                        <tr class="group hover:bg-gray-50/50 transition-colors">
                            <td class="py-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl overflow-hidden border border-gray-100">
                                        <img src="{{ asset('uploads/products/'.$tp->product->image) }}" class="w-full h-full object-cover">
                                    </div>
                                    <span class="text-sm font-bold text-gray-900">{{ $tp->product->name }}</span>
                                </div>
                            </td>
                            <td class="py-5 text-center">
                                <span class="px-3 py-1 bg-gray-50 text-[8px] font-black text-gray-500 uppercase rounded-lg border border-gray-100">
                                    {{ $tp->product->category }}
                                </span>
                            </td>
                            <td class="py-5 text-center">
                                <span class="text-base font-black text-[#31326F]">{{ $tp->total_qty }}</span>
                            </td>
                            <td class="py-5 text-right">
                                <span class="text-xs font-bold text-[#4FB7B3]">{{ $tp->percentage }}%</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 4. INSIGHTS SUMMARY -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-[#A8FBD3]/10 p-8 rounded-[2.5rem] border border-[#A8FBD3]/20">
            <p class="text-[9px] font-black text-[#4FB7B3] uppercase tracking-widest mb-3">Kategori Terlaris</p>
            <h4 class="text-xl font-black text-gray-900">{{ $insights['top_category'] }}</h4>
            <div class="w-8 h-1 bg-[#4FB7B3] mt-4 rounded-full"></div>
        </div>
        <div class="bg-[#637AB9]/5 p-8 rounded-[2.5rem] border border-[#637AB9]/10">
            <p class="text-[9px] font-black text-[#637AB9] uppercase tracking-widest mb-3">Produk Terlaris</p>
            <h4 class="text-xl font-black text-gray-900 truncate" title="{{ $insights['top_product'] }}">{{ $insights['top_product'] }}</h4>
            <div class="w-8 h-1 bg-[#637AB9] mt-4 rounded-full"></div>
        </div>
        <div class="bg-amber-50 p-8 rounded-[2.5rem] border border-amber-100">
            <p class="text-[9px] font-black text-amber-600 uppercase tracking-widest mb-3">Volume Produk</p>
            <h4 class="text-xl font-black text-gray-900">{{ $insights['total_sold'] }} <span class="text-xs font-bold text-gray-400 ml-1 uppercase italic">Items terjual</span></h4>
            <div class="w-8 h-1 bg-amber-500 mt-4 rounded-full"></div>
        </div>
        <div class="bg-[#31326F]/5 p-8 rounded-[2.5rem] border border-[#31326F]/10">
            <p class="text-[9px] font-black text-[#31326F] uppercase tracking-widest mb-3">Insight Pertumbuhan</p>
            <p class="text-xs font-bold text-gray-600 italic leading-relaxed">{{ $insights['comparison'] }}</p>
            <div class="w-8 h-1 bg-[#31326F] mt-4 rounded-full"></div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. SALES TREND CHART
    const salesCtx = document.getElementById('salesChart').getContext('2d');

    // Gradients
    const primaryGradient = salesCtx.createLinearGradient(0, 0, 0, 400);
    primaryGradient.addColorStop(0, 'rgba(79, 183, 179, 0.2)');
    primaryGradient.addColorStop(1, 'rgba(79, 183, 179, 0)');

    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartData['labels']) !!},
            datasets: [
                {
                    label: 'Pendapatan (Rp)',
                    data: {!! json_encode($chartData['revenue']) !!},
                    borderColor: '#4FB7B3',
                    backgroundColor: primaryGradient,
                    fill: true,
                    tension: 0.4,
                    borderWidth: 4,
                    pointRadius: 6,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#4FB7B3',
                    pointBorderWidth: 2,
                    yAxisID: 'y',
                },
                {
                    label: 'Transaksi',
                    data: {!! json_encode($chartData['orders']) !!},
                    borderColor: '#31326F',
                    borderWidth: 3,
                    borderDash: [5, 5],
                    pointRadius: 0,
                    tension: 0.4,
                    fill: false,
                    yAxisID: 'y1',
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { intersect: false, mode: 'index' },
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    grid: { color: '#f8fafc', drawBorder: false },
                    ticks: {
                        callback: function(value) { return 'Rp ' + value.toLocaleString(); },
                        font: { weight: 'bold', size: 10 },
                        color: '#9ca3af'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    grid: { display: false },
                    ticks: { font: { weight: 'bold', size: 10 }, color: '#9ca3af' }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { weight: 'bold', size: 10 }, color: '#9ca3af' }
                }
            }
        }
    });

    // 2. CATEGORY DONUT CHART
    const catCtx = document.getElementById('categoryChart').getContext('2d');
    new Chart(catCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(collect($categoryDist['data'])->pluck('name')) !!},
            datasets: [{
                data: {!! json_encode(collect($categoryDist['data'])->pluck('count')) !!},
                backgroundColor: ['#4FB7B3', '#637AB9', '#31326F'],
                borderWidth: 5,
                borderColor: '#fff',
                hoverOffset: 15
            }]
        },
        options: {
            cutout: '75%',
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } }
        }
    });
});
</script>

<style>
    .animate-fade-in { animation: fadeIn 0.8s ease-out forwards; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection
