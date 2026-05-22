@extends('layouts.admin')

@section('title', 'Dashboard Overview')
@section('page_title', 'Statistik Silua Toba')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,900;1,700&family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">

<style>
    :root {
        --primary-orange: #FF5722;
        --navy-dark: #1A3A34;
        --olive-green: #5B5B41;
    }
    
    .dashboard-header { margin-bottom: 40px; }
    .dashboard-title { font-family: 'Playfair Display', serif; font-weight: 900; font-size: 2.5rem; color: var(--navy-dark); font-style: italic; }
    .dashboard-subtitle { color: #888; font-size: 0.9rem; margin-top: 5px; }

    /* Stats Card Styling */
    .admin-card-stat {
        background: white;
        padding: 30px;
        border-radius: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        transition: all 0.3s ease;
    }
    .admin-card-stat:hover { transform: translateY(-5px); box-shadow: 0 15px 35px rgba(0,0,0,0.05); }
    .stat-label { font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; color: #bbb; margin-bottom: 10px; }
    .stat-value { font-size: 1.8rem; font-weight: 900; color: var(--navy-dark); }
    .stat-icon { width: 45px; height: 45px; border-radius: 15px; display: flex; align-items: center; justify-content: center; }

    /* Revenue Highlight Card */
    .revenue-card {
        background: var(--navy-dark);
        color: white;
        padding: 30px;
        border-radius: 30px;
        position: relative;
        overflow: hidden;
    }
    .revenue-card .stat-label { color: rgba(255,255,255,0.5); }
    .revenue-card .stat-value { color: white; font-size: 2rem; }
    .revenue-card::after {
        content: ''; position: absolute; top: -20px; right: -20px;
        width: 120px; height: 120px; background: rgba(255, 87, 34, 0.1);
        border-radius: 50%;
    }

    /* Table Sold Products */
    .product-list-card {
        background: white; border-radius: 30px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.02);
    }
    .table-sold { width: 100%; border-collapse: separate; border-spacing: 0 15px; }
    .table-sold tr { background: #fdfdfb; transition: 0.3s; }
    .table-sold tr:hover { background: #f9f9f4; }
    .table-sold td { padding: 15px; border: none; }
    .table-sold td:first-child { border-radius: 15px 0 0 15px; }
    .table-sold td:last-child { border-radius: 0 15px 15px 0; }
    .img-sold { width: 50px; height: 50px; border-radius: 12px; object-fit: cover; }
</style>

<div class="container mx-auto px-4 py-8">
    
    <!-- HEADER DASHBOARD -->
    <div class="dashboard-header">
        <h2 class="dashboard-title">Dashboard Admin</h2>
        <p class="dashboard-subtitle">Ringkasan performa bisnis Silua Toba bulan ini.</p>
    </div>

    <!-- 1. BARIS KARTU STATISTIK UTAMA -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <!-- PENDAPATAN BULAN INI (FITUR BARU) -->
        <div class="lg:col-span-2 revenue-card shadow-lg flex items-center justify-between">
            <div>
                <p class="stat-label">Pendapatan {{ now()->translatedFormat('F Y') }}</p>
                <h4 class="stat-value">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</h4>
                <p class="text-[10px] mt-2 opacity-60">*Terhitung otomatis dari pesanan berstatus 'Diterima'</p>
            </div>
            <div class="stat-icon bg-orange-brand/20 text-orange-brand">
                <i data-lucide="trending-up" class="w-8 h-8"></i>
            </div>
        </div>

        <div class="admin-card-stat border-l-4 border-navy-dark">
            <div class="flex justify-between items-start">
                <div>
                    <p class="stat-label">Total Pesanan</p>
                    <h4 class="stat-value">{{ $totalOrders }}</h4>
                </div>
                <div class="stat-icon bg-navy-dark/10 text-navy-dark">
                    <i data-lucide="shopping-bag"></i>
                </div>
            </div>
        </div>

        <div class="admin-card-stat border-l-4 border-green-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="stat-label">Pelanggan</p>
                    <h4 class="stat-value">{{ $totalCustomers }}</h4>
                </div>
                <div class="stat-icon bg-green-500/10 text-green-500">
                    <i data-lucide="user-check"></i>
                </div>
            </div>
        </div>

    </div>

    <!-- 2. GRAFIK & DAFTAR PRODUK TERJUAL -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- GRAFIK TREND -->
        <div class="lg:col-span-2 admin-card shadow-lg p-8 bg-white rounded-[2.5rem]">
            <div class="flex justify-between items-center mb-8">
                <h3 class="text-sm font-black text-navy-dark uppercase tracking-widest">
                    Trend Aktivitas (7 Hari Terakhir)
                </h3>
            </div>
            <canvas id="activityChart" height="180"></canvas>
        </div>

        <!-- DAFTAR PRODUK TERJUAL (FITUR BARU) -->
        <div class="product-list-card shadow-lg rounded-[2.5rem]">
            <h3 class="text-sm font-black text-navy-dark uppercase tracking-widest mb-6">
                Terlaris Bulan Ini
            </h3>
            
            <div class="overflow-y-auto max-h-[400px] pr-2">
                @forelse($soldProducts as $sold)
                <div class="flex items-center gap-4 mb-5 p-3 rounded-2xl bg-gray-50/50 border border-gray-100">
                    <img src="{{ asset('uploads/products/'.$sold->product->image) }}" class="img-sold shadow-sm">
                    <div class="flex-1">
                        <h5 class="font-bold text-navy-dark text-xs truncate">{{ $sold->product->name }}</h5>
                        <p class="text-[10px] text-gray-400 font-bold uppercase">{{ $sold->product->category }}</p>
                    </div>
                    <div class="text-right">
                        <span class="text-orange-brand font-black text-sm">{{ $sold->total_qty }}</span>
                        <span class="text-[9px] block font-bold text-gray-400">TERJUAL</span>
                    </div>
                </div>
                @empty
                <p class="text-center text-gray-400 italic py-10 text-sm">Belum ada data penjualan.</p>
                @endforelse
            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                <a href="{{ route('admin.orders.index') }}" class="text-[10px] font-black text-navy-dark hover:text-orange-brand uppercase tracking-widest">Lihat Semua Pesanan</a>
            </div>
        </div>

    </div>
</div>

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('activityChart').getContext('2d');
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($dates) !!},
                datasets: [
                    {
                        label: 'User Baru',
                        data: {!! json_encode($userRegistrationData) !!},
                        borderColor: '#FF5722',
                        backgroundColor: 'rgba(255, 87, 34, 0.05)',
                        borderWidth: 4,
                        tension: 0.4,
                        fill: true,
                        pointRadius: 0,
                        pointHoverRadius: 6
                    },
                    {
                        label: 'Pesanan',
                        data: {!! json_encode($orderData) !!},
                        borderColor: '#1A3A34',
                        backgroundColor: 'rgba(26, 58, 52, 0.05)',
                        borderWidth: 4,
                        tension: 0.4,
                        fill: true,
                        pointRadius: 0,
                        pointHoverRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true, position: 'top', align: 'end', labels: { usePointStyle: true, boxWidth: 6, font: { weight: 'bold', size: 10 } } }
                },
                scales: {
                    y: { beginAtZero: true, grid: { borderDash: [5, 5], color: '#f0f0f0' }, ticks: { font: { size: 10 } } },
                    x: { grid: { display: false }, ticks: { font: { size: 10 } } }
                }
            }
        });
    });
</script>
@endsection