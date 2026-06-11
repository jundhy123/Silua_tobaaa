@extends('layouts.admin')

@section('title', 'Analisis Pendapatan - Admin Silua Toba')
@section('page_title', 'Laporan Keuangan')

@section('content')
<link rel="stylesheet" href="{{ asset('css/produk-admin.css') }}">

<div class="space-y-10 animate-fade-in">
    <!-- HEADER -->
    <div class="admin-header-flex">
        <div>
            <h1 class="main-title-premium text-[#31326F]">Rekap <span class="text-[#4FB7B3]">Pendapatan</span></h1>
            <p class="text-[#64748B] text-sm mt-1 italic">Ringkasan performa finansial berdasarkan pesanan sukses.</p>
        </div>
    </div>

    <!-- SUMMARY TABLE -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-4">
            <div class="admin-table-card">
                <div class="p-6 border-b border-[#E2E8F0] bg-[#F8FAFC]">
                    <h3 class="text-xs font-black uppercase tracking-widest text-[#31326F]">Ringkasan Bulanan</h3>
                </div>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Periode</th>
                            <th class="text-right">Total (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($monthlyIncome as $data)
                            <tr>
                                <td class="font-bold text-[#31326F]">{{ date('F', mktime(0, 0, 0, $data->month, 10)) }} {{ $data->year }}</td>
                                <td class="text-right font-black text-[#4FB7B3]">Rp {{ number_format($data->total, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="lg:col-span-8">
            <div class="admin-table-card">
                <div class="p-6 border-b border-[#E2E8F0] bg-[#F8FAFC]">
                    <h3 class="text-xs font-black uppercase tracking-widest text-[#31326F]">Analisis Pertumbuhan</h3>
                </div>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Tahun</th>
                            <th>Bulan</th>
                            <th class="text-right">Total Pendapatan</th>
                            <th class="text-right">Pertumbuhan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $prev = null; @endphp
                        @foreach($monthlyIncome->reverse() as $data)
                            @php
                                $growth = $prev && $prev->total > 0 ? (($data->total - $prev->total) / $prev->total) * 100 : 0;
                                $prev = $data;
                            @endphp
                            <tr>
                                <td class="font-bold text-[#31326F]">{{ $data->year }}</td>
                                <td class="text-[#64748B] font-medium">{{ date('F', mktime(0, 0, 0, $data->month, 10)) }}</td>
                                <td class="text-right font-bold">Rp {{ number_format($data->total, 0, ',', '.') }}</td>
                                <td class="text-right">
                                    @if($growth > 0)
                                        <span class="text-green-600 font-bold">↑ {{ round($growth, 1) }}%</span>
                                    @elseif($growth < 0)
                                        <span class="text-rose-600 font-bold">↓ {{ abs(round($growth, 1)) }}%</span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
