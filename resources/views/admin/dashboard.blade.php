@extends('layouts.admin')

@section('title', 'Admin Overview - Silua Toba')
@section('page_title', 'Dashboard Analitik')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    :root {
        --primary-orange: #FF5722;
    }
    .text-primary-orange { color: var(--primary-orange); }
    .bg-primary-orange { background-color: var(--primary-orange); }
</style>

<div class="space-y-10 animate-fade-in pb-20">

    <!-- HEADER & PERIOD SELECTOR -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
        <div>
            <span class="text-[10px] font-black uppercase tracking-[0.3em] text-primary-orange mb-2 block">Ringkasan Perusahaan</span>
            <h1 class="text-4xl font-black italic text-gray-900" style="font-family: 'Playfair Display', serif;">
                Selamat Datang, <span class="text-primary-orange">{{ Auth::user()->name }}</span>
            </h1>
            <p class="text-gray-400 text-sm mt-1 italic">Analisis performa bisnis Silua Toba berdasarkan pesanan selesai.</p>
        </div>

        <div class="flex bg-white p-1.5 rounded-2xl shadow-sm border border-gray-100">
            @foreach(['daily' => 'Harian', 'weekly' => 'Mingguan', 'monthly' => 'Bulanan', 'yearly' => 'Tahunan'] as $key => $label)
                <a href="{{ route('admin.dashboard', ['period' => $key]) }}"
                   class="px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all
                   {{ $period == $key ? 'bg-gray-900 text-white shadow-lg' : 'text-gray-400 hover:text-gray-900 hover:bg-gray-50' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- 1. KEY METRICS GRID -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-6">
        <!-- Revenue Card -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-500 group">
            <div class="flex justify-between items-start mb-6">
                <div class="w-12 h-12 bg-orange-50 text-primary-orange rounded-2xl flex items-center justify-center">
                    <i data-lucide="wallet" class="w-6 h-6"></i>
                </div>
                <span class="px-3 py-1 rounded-lg text-[9px] font-bold {{ $stats['revenue']['diff'] >= 0 ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                    {{ $stats['revenue']['diff'] >= 0 ? '↑' : '↓' }} {{ abs(round($stats['revenue']['diff'], 1)) }}%
                </span>
            </div>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Pendapatan</p>
            <h3 class="text-2xl font-black text-gray-900 mt-2 tracking-tighter">Rp {{ number_format($stats['revenue']['total'], 0, ',', '.') }}</h3>
            <p class="text-[9px] text-gray-400 mt-4 italic uppercase">Bulan ini: Rp {{ number_format($stats['revenue']['current_month'], 0, ',', '.') }}</p>
        </div>

        <!-- Orders Card -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-500">
            <div class="flex justify-between items-start mb-6">
                <div class="w-12 h-12 bg-orange-50 text-primary-orange rounded-2xl flex items-center justify-center">
                    <i data-lucide="shopping-bag" class="w-6 h-6"></i>
                </div>
                <span class="px-3 py-1 rounded-lg text-[9px] font-bold {{ $stats['orders']['diff'] >= 0 ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                    {{ $stats['orders']['diff'] >= 0 ? '↑' : '↓' }} {{ abs(round($stats['orders']['diff'], 1)) }}%
                </span>
            </div>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Pesanan Selesai</p>
            <h3 class="text-2xl font-black text-gray-900 mt-2 tracking-tighter">{{ $stats['orders']['total'] }} Transaksi</h3>
            <p class="text-[9px] text-gray-400 mt-4 italic uppercase">Bulan ini: {{ $stats['orders']['current_month'] }} Selesai</p>
        </div>

        <!-- Items Card -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-500">
            <div class="flex justify-between items-start mb-6">
                <div class="w-12 h-12 bg-orange-50 text-primary-orange rounded-2xl flex items-center justify-center">
                    <i data-lucide="package" class="w-6 h-6"></i>
                </div>
                <span class="px-3 py-1 rounded-lg text-[9px] font-bold {{ $stats['items']['diff'] >= 0 ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                    {{ $stats['items']['diff'] >= 0 ? '↑' : '↓' }} {{ abs(round($stats['items']['diff'], 1)) }}%
                </span>
            </div>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Produk Terjual</p>
            <h3 class="text-2xl font-black text-gray-900 mt-2 tracking-tighter">{{ $stats['items']['total'] }} Produk</h3>
            <p class="text-[9px] text-gray-400 mt-4 italic uppercase">Bulan ini: {{ $stats['items']['current_month'] }} unit</p>
        </div>
    </div>

    <!-- 2. ANALYTICS CHART -->
    <div class="bg-white p-10 rounded-[3.5rem] border border-gray-100 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 gap-6">
            <div>
                <h3 class="text-xl font-black text-gray-900 italic" style="font-family: 'Playfair Display', serif;">Tren Penjualan</h3>
                <p class="text-[10px] text-gray-400 mt-1 uppercase tracking-widest font-black">Visualisasi Data Periode {{ ucfirst($period) }}</p>
            </div>
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-primary-orange"></span>
                    <span class="text-[9px] font-black text-gray-500 uppercase">Pendapatan</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-gray-900"></span>
                    <span class="text-[9px] font-black text-gray-500 uppercase">Transaksi</span>
                </div>
            </div>
        </div>
        <div class="relative h-[400px]">
            <canvas id="mainSalesChart"></canvas>
        </div>
    </div>

    <!-- 3. CATEGORY & TOP PRODUCTS -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        <!-- Category Distribution -->
        <div class="lg:col-span-5 bg-white p-10 rounded-[3.5rem] border border-gray-100 shadow-sm flex flex-col h-full">
            <h3 class="text-xl font-black text-gray-900 italic mb-10" style="font-family: 'Playfair Display', serif;">Distribusi Kategori</h3>

            <div class="flex flex-col items-center gap-12 flex-1 justify-center">
                <div class="w-56 h-56 relative">
                    <canvas id="categoryDonutChart"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total</span>
                        <span class="text-2xl font-black text-gray-900">{{ $categoryDist['total'] }}</span>
                    </div>
                </div>

                <div class="w-full space-y-6">
                    @php $colors = ['Minuman' => '#FF5722', 'cemilan' => '#f97316', 'Makanan Berat' => '#111827']; @endphp
                    @foreach($categoryDist['data'] as $cat)
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 rounded-full" style="background-color: {{ $colors[$cat['name']] ?? '#eee' }}"></div>
                                <span class="text-[10px] font-black text-gray-900 uppercase tracking-widest">{{ $cat['name'] }}</span>
                            </div>
                            <span class="text-xs font-bold text-gray-900">{{ $cat['percentage'] }}%</span>
                        </div>
                        <div class="h-1.5 bg-gray-50 rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-1000" style="width: {{ $cat['percentage'] }}%; background-color: {{ $colors[$cat['name']] ?? '#eee' }}"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Top Products List -->
        <div class="lg:col-span-7 bg-white p-10 rounded-[3.5rem] border border-gray-100 shadow-sm h-full">
            <div class="flex justify-between items-center mb-10">
                <h3 class="text-xl font-black text-gray-900 italic" style="font-family: 'Playfair Display', serif;">Produk Terlaris</h3>
                <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center text-primary-orange">
                    <i data-lucide="award" class="w-5 h-5"></i>
                </div>
            </div>

            <div class="space-y-8">
                @forelse($topProducts as $tp)
                <div class="flex items-center gap-6 p-4 rounded-[2rem] hover:bg-gray-50 transition-all duration-300 border border-transparent hover:border-gray-100">
                    <div class="relative w-20 h-20 shrink-0 rounded-2xl overflow-hidden shadow-md border-2 border-white">
                        <img src="{{ asset('uploads/products/'.$tp->product->image) }}" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="px-2 py-0.5 bg-primary-orange text-white text-[7px] font-black uppercase tracking-widest rounded">Top</span>
                            <span class="text-[8px] text-primary-orange font-black uppercase tracking-widest">{{ $tp->product->category }}</span>
                        </div>
                        <h5 class="font-bold text-gray-900 text-base truncate">{{ $tp->product->name }}</h5>
                        <div class="flex items-center gap-4 mt-2">
                            <span class="text-[10px] font-black text-gray-900">{{ $tp->total_qty }} <span class="text-[8px] font-normal text-gray-400 italic">Terjual</span></span>
                            <div class="w-px h-3 bg-gray-100"></div>
                            <span class="text-[10px] font-black text-primary-orange">{{ $tp->percentage }}% <span class="text-[8px] font-normal text-gray-400 italic">Kontribusi</span></span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="py-20 text-center opacity-30 italic">
                    <i data-lucide="package-search" class="w-16 h-16 mx-auto mb-4"></i>
                    Belum ada data penjualan tersedia.
                </div>
                @endforelse
            </div>

            <div class="mt-12 pt-8 border-t border-gray-50 flex justify-between items-center">
                <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Total {{ $totalProducts }} Produk Aktif</p>
                <a href="{{ route('admin.produk.index') }}" class="text-[10px] font-black text-primary-orange uppercase tracking-widest hover:underline">Kelola Katalog →</a>
            </div>
        </div>

    </div>

    <!-- 4. INSIGHTS SUMMARY -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-orange-50 p-8 rounded-[2.5rem] border border-orange-100">
            <p class="text-[9px] font-black text-primary-orange uppercase tracking-widest mb-3">Top Category</p>
            <h4 class="text-xl font-black text-gray-900">{{ $insights['top_category'] }}</h4>
            <div class="w-8 h-1 bg-primary-orange mt-4 rounded-full"></div>
        </div>
        <div class="bg-gray-50 p-8 rounded-[2.5rem] border border-gray-100">
            <p class="text-[9px] font-black text-gray-500 uppercase tracking-widest mb-3">Top Selling</p>
            <h4 class="text-xl font-black text-gray-900 truncate">{{ $insights['top_product'] }}</h4>
            <div class="w-8 h-1 bg-gray-900 mt-4 rounded-full"></div>
        </div>
        <div class="bg-orange-50 p-8 rounded-[2.5rem] border border-orange-100">
            <p class="text-[9px] font-black text-primary-orange uppercase tracking-widest mb-3">Volume Sold</p>
            <h4 class="text-xl font-black text-gray-900">{{ $insights['total_sold'] }} <span class="text-xs font-bold text-gray-400 ml-1 uppercase italic">Items</span></h4>
            <div class="w-8 h-1 bg-orange-500 mt-4 rounded-full"></div>
        </div>
        <div class="bg-gray-900/5 p-8 rounded-[2.5rem] border border-gray-900/10">
            <p class="text-[9px] font-black text-gray-900 uppercase tracking-widest mb-3">Business Growth</p>
            <p class="text-xs font-bold text-gray-600 italic leading-relaxed">{{ $insights['comparison'] }}</p>
            <div class="w-8 h-1 bg-gray-900 mt-4 rounded-full"></div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. MAIN SALES CHART
    const salesCtx = document.getElementById('mainSalesChart').getContext('2d');
    const primaryGradient = salesCtx.createLinearGradient(0, 0, 0, 400);
    primaryGradient.addColorStop(0, 'rgba(255, 87, 34, 0.15)');
    primaryGradient.addColorStop(1, 'rgba(255, 87, 34, 0)');

    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartData['labels']) !!},
            datasets: [
                {
                    label: 'Pendapatan (Rp)',
                    data: {!! json_encode($chartData['revenue']) !!},
                    borderColor: '#FF5722',
                    backgroundColor: primaryGradient,
                    fill: true,
                    tension: 0.4,
                    borderWidth: 4,
                    pointRadius: 6,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#FF5722',
                    pointBorderWidth: 2,
                    yAxisID: 'y',
                },
                {
                    label: 'Transaksi',
                    data: {!! json_encode($chartData['orders']) !!},
                    borderColor: '#111827',
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
                    position: 'left',
                    grid: { color: '#f8fafc', drawBorder: false },
                    ticks: {
                        callback: (v) => 'Rp ' + v.toLocaleString(),
                        font: { weight: 'bold', size: 10 },
                        color: '#9ca3af'
                    }
                },
                y1: {
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
    const catCtx = document.getElementById('categoryDonutChart').getContext('2d');
    new Chart(catCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(collect($categoryDist['data'])->pluck('name')) !!},
            datasets: [{
                data: {!! json_encode(collect($categoryDist['data'])->pluck('count')) !!},
                backgroundColor: ['#FF5722', '#f97316', '#111827'],
                borderWidth: 5,
                borderColor: '#fff',
                hoverOffset: 15
            }]
        },
        options: {
            cutout: '80%',
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
