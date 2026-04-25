@extends('layouts.admin')

@section('title','Pesanan Masuk')

@section('content')

<div class="p-6">

    <h1 class="text-2xl font-black mb-6">Pesanan Masuk</h1>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-500 text-white rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-500 text-white rounded">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow p-4">

        <table class="w-full text-sm">
            <thead>
                <tr class="border-b">
                    <th class="text-left py-2">Kode</th>
                    <th class="text-left py-2">User</th>
                    <th class="text-left py-2">Total</th>
                    <th class="text-left py-2">Status</th>
                    <th class="text-left py-2">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($orders as $o)
                <tr class="border-b">
                    <td class="py-2 font-bold">{{ $o->order_code }}</td>
                    <td>{{ $o->user->name ?? '-' }}</td>
                    <td>Rp {{ number_format($o->total_price,0,',','.') }}</td>

                    <td>
                        <span class="px-2 py-1 rounded text-xs
                            @if($o->status == 'pending') bg-yellow-200
                            @elseif($o->status == 'confirmed') bg-green-200
                            @else bg-red-200
                            @endif
                        ">
                            {{ $o->status }}
                        </span>
                    </td>

                    <td class="flex gap-2 flex-wrap">
                        
                        {{-- FORM STATUS --}}
                        <form action="{{ route('admin.orders.update', $o->id) }}" method="POST" class="flex gap-2">
                            @csrf
                            @method('PATCH')

                            <button name="status" value="confirmed" class="px-2 py-1 bg-green-500 text-white rounded text-xs">
                                Terima
                            </button>

                            <button name="status" value="rejected" class="px-2 py-1 bg-red-500 text-white rounded text-xs">
                                Tolak
                            </button>
                        </form>

                        {{-- TOMBOL HAPUS (HANYA JIKA SUDAH DIPROSES) --}}
                        @if($o->status != 'pending')
                        <form action="{{ route('admin.orders.destroy', $o->id) }}" method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')">
                            @csrf
                            @method('DELETE')

                            <button class="px-2 py-1 bg-gray-800 text-white rounded text-xs hover:bg-black">
                                Hapus
                            </button>
                        </form>
                        @endif

                    </td>
                </tr>

                <!-- DETAIL PRODUK -->
                <tr>
                    <td colspan="5" class="py-2 bg-gray-50">
                        <div class="pl-4 text-xs">
                            <strong>Detail Produk:</strong>
                            <ul class="mt-1">
                                @foreach($o->items as $item)
                                    <li>
                                        {{ $item->product->name }} 
                                        ({{ $item->quantity }}x)
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="5" class="text-center py-6 text-gray-400">
                        Belum ada pesanan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>

</div>

@endsection