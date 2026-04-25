@extends('layouts.admin')

@section('title', 'Dashboard Overview')
@section('page_title', 'Statistik Silua Toba')

@section('content')

    <!-- HEADER DASHBOARD -->
    <div class="dashboard-header">
        <h2 class="dashboard-title">Dashboard Admin</h2>
        <p class="dashboard-subtitle">
            Ringkasan aktivitas dan performa sistem Silua Toba
        </p>
        <p class="dashboard-note">
            Data diperbarui secara real-time berdasarkan aktivitas pengguna
        </p>
    </div>

    <!-- 1. BARIS KARTU STATISTIK -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        
        <div class="admin-card-stat border-l-4 border-orange-brand">
            <div class="flex justify-between items-start">
                <div>
                    <p class="stat-label">Total Produk</p>
                    <h4 class="stat-value">{{ $totalProducts }}</h4>
                </div>
                <div class="stat-icon bg-orange-brand/10 text-orange-brand">
                    <i data-lucide="package"></i>
                </div>
            </div>
            <p class="stat-desc">Produk aktif di katalog</p>
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
            <p class="stat-desc">Pesanan masuk sistem</p>
        </div>

        <div class="admin-card-stat border-l-4 border-gray-soft">
            <div class="flex justify-between items-start">
                <div>
                    <p class="stat-label">Pekerja/Tim</p>
                    <h4 class="stat-value">{{ $totalWorkers }}</h4>
                </div>
                <div class="stat-icon bg-gray-soft/10 text-gray-soft">
                    <i data-lucide="users"></i>
                </div>
            </div>
            <p class="stat-desc">Staff & Pemilik</p>
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
            <p class="stat-desc">User terdaftar</p>
        </div>

    </div>

    <!-- 2. GRAFIK -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 admin-card shadow-lg p-6 bg-white rounded-3xl">
            <h3 class="text-lg font-black text-navy-dark mb-6 uppercase tracking-widest">
                Trend Aktivitas (7 Hari Terakhir)
            </h3>
            <canvas id="activityChart" height="150"></canvas>
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
                            label: 'Pendaftaran User',
                            data: {!! json_encode($userRegistrationData) !!},
                            borderColor: '#637AB9',
                            backgroundColor: 'rgba(99, 122, 185, 0.1)',
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true
                        },
                        {
                            label: 'Pesanan Masuk',
                            data: {!! json_encode($orderData) !!},
                            borderColor: '#4FB7B3',
                            backgroundColor: 'rgba(79, 183, 179, 0.1)',
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'bottom' }
                    },
                    scales: {
                        y: { beginAtZero: true, grid: { display: false } },
                        x: { grid: { display: false } }
                    }
                }
            });
        });
    </script>

@endsection