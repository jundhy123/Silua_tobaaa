@extends('layouts.admin')

@section('title','Pendapatan')
@section('page_title','Pendapatan Bulanan')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Ringkasan Pendapatan</h2>
    <table class="admin-table w-full mb-8">
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($monthlyIncome as $data)
                <tr>
                    <td>{{ $data->month }}/{{ $data->year }}</td>
                    <td class="text-right">{{ number_format($data->total,0,',','.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2 class="text-2xl font-bold mb-4">Detail Pendapatan</h2>
    <table class="admin-table w-full">
        <thead>
            <tr>
                <th>Tahun</th>
                <th>Bulan</th>
                <th>Total (Rp)</th>
                <th>Pertumbuhan %</th>
            </tr>
        </thead>
        <tbody>
            @php $prev = null; @endphp
            @foreach($monthlyIncome as $data)
                @php
                    $growth = $prev ? round((($data->total - $prev->total) / $prev->total) * 100 : 0;
                    $prev = $data;
                @endphp
                <tr>
                    <td>{{ $data->year }}</td>
                    <td>{{ $data->month }}</td>
                    <td class="text-right">{{ number_format($data->total,0,',','.') }}</td>
                    <td class="text-right">{{ $growth }} %</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
