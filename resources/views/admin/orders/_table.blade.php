<table class="w-full text-left border-collapse">
    <thead>
        <tr class="border-b border-gray-50">
            <th class="px-8 py-8 text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 text-center">Pri</th>
            <th class="px-6 py-8 text-[10px] font-black uppercase tracking-[0.3em] text-gray-400">ID & Waktu</th>
            <th class="px-6 py-8 text-[10px] font-black uppercase tracking-[0.3em] text-gray-400">Pelanggan</th>
            <th class="px-6 py-8 text-[10px] font-black uppercase tracking-[0.3em] text-gray-400">Produk</th>
            <th class="px-6 py-8 text-[10px] font-black uppercase tracking-[0.3em] text-gray-400">Total</th>
            <th class="px-6 py-8 text-[10px] font-black uppercase tracking-[0.3em] text-gray-400">Status</th>
            <th class="px-8 py-8 text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 text-center">Aksi</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-50">
        @forelse($orders as $o)
        @php
            $isPending = $o->status == 'pending';
            $isOld = $o->created_at->diffInHours(now()) > 24;
            $priorityColor = $isPending ? ($isOld ? 'bg-red-500' : 'bg-amber-400') : 'bg-gray-200';
        @endphp
        <tr class="group hover:bg-gray-50/50 transition-all duration-300">
            <td class="px-8 py-8">
                <div class="flex justify-center">
                    <div class="w-3 h-3 rounded-full {{ $priorityColor }} shadow-sm" title="{{ $isPending ? ($isOld ? 'Prioritas Tinggi (>24 Jam)' : 'Menunggu Konfirmasi') : 'Selesai/Diproses' }}"></div>
                </div>
            </td>
            <td class="px-6 py-8">
                <div class="font-black text-gray-900 text-sm">#{{ $o->order_code ?? $o->id }}</div>
                <div class="text-[9px] font-black text-gray-400 uppercase tracking-widest mt-1">{{ $o->created_at->format('d/m/Y • H:i') }}</div>
            </td>
            <td class="px-6 py-8">
                <div class="font-bold text-gray-900 italic" style="font-family: 'Playfair Display', serif;">{{ $o->user->name ?? 'Tamu' }}</div>
                <div class="text-[9px] font-black text-amber-700/50 uppercase tracking-widest mt-1">ID: {{ $o->user->customer_id ?? '-' }}</div>
            </td>
            <td class="px-6 py-8">
                <div class="space-y-2">
                    @foreach($o->items as $item)
                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-gray-700">{{ $item->product->name }} <b class="text-amber-700 ml-1">x{{ $item->quantity }}</b></span>
                        </div>
                    @endforeach
                </div>
            </td>
            <td class="px-6 py-8">
                <div class="font-black text-gray-900 text-base italic">Rp {{ number_format($o->total_price, 0, ',', '.') }}</div>
            </td>
            <td class="px-6 py-8">
                @php
                    $statusClasses = [
                        'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                        'accepted' => 'bg-indigo-100 text-indigo-700 border-indigo-200',
                        'shipping' => 'bg-blue-100 text-blue-700 border-blue-200',
                        'delivered' => 'bg-green-100 text-green-700 border-green-200',
                        'rejected' => 'bg-red-100 text-red-700 border-red-200'
                    ];
                    $statusLabels = [
                        'pending' => 'MENUNGGU',
                        'accepted' => 'DIPROSES',
                        'shipping' => 'DIKIRIM',
                        'delivered' => 'SELESAI',
                        'rejected' => 'BATAL'
                    ];
                @endphp
                <span class="px-4 py-2 rounded-xl text-[8px] font-black tracking-widest border {{ $statusClasses[$o->status] ?? 'bg-gray-100 text-gray-500' }}">
                    {{ $statusLabels[$o->status] ?? strtoupper($o->status) }}
                </span>
            </td>
            <td class="px-8 py-8">
                <div class="flex justify-center gap-2">
                    <form action="{{ route('admin.orders.update', $o->id) }}" method="POST" class="flex gap-2">
                        @csrf @method('PATCH')
                        @if($o->status == 'pending')
                            <button name="status" value="accepted" class="w-10 h-10 bg-gray-900 text-white rounded-xl flex items-center justify-center hover:bg-amber-700 transition-all shadow-lg" title="Setujui">
                                <i data-lucide="check" class="w-4 h-4"></i>
                            </button>
                            <button type="button" onclick="showRejectModal({{ $o->id }})" class="w-10 h-10 bg-white border border-gray-100 text-gray-400 rounded-xl flex items-center justify-center hover:bg-red-50 hover:text-red-500 transition-all" title="Tolak">
                                <i data-lucide="x" class="w-4 h-4"></i>
                            </button>
                        @elseif($o->status == 'accepted')
                            <button name="status" value="shipping" class="w-10 h-10 bg-indigo-600 text-white rounded-xl flex items-center justify-center hover:bg-gray-900 transition-all shadow-lg" title="Kirim">
                                <i data-lucide="truck" class="w-4 h-4"></i>
                            </button>
                        @elseif($o->status == 'shipping')
                            <button name="status" value="delivered" class="w-10 h-10 bg-green-600 text-white rounded-xl flex items-center justify-center hover:bg-gray-900 transition-all shadow-lg" title="Selesaikan">
                                <i data-lucide="package-check" class="w-4 h-4"></i>
                            </button>
                        @endif
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="px-10 py-32 text-center opacity-30 italic">
                <i data-lucide="inbox" class="w-20 h-20 mx-auto mb-6 text-gray-200"></i>
                <p class="text-xl font-bold">Tidak ada pesanan.</p>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="px-8 py-8 border-t border-gray-50 flex flex-col md:flex-row justify-between items-center gap-6">
    <div class="flex items-center gap-4">
        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Tampilkan:</span>
        <select onchange="window.handlePerPage(this.value)" class="bg-gray-50 border border-gray-100 rounded-xl px-3 py-1.5 text-xs font-bold outline-none focus:ring-2 focus:ring-amber-700/20">
            @foreach([10, 25, 50] as $size)
                <option value="{{ $size }}" {{ $orders->perPage() == $size ? 'selected' : '' }}>{{ $size }} data</option>
            @endforeach
        </select>
    </div>

    <div class="flex flex-col items-center md:items-end">
        <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4">
            Menampilkan {{ $orders->firstItem() ?? 0 }}–{{ $orders->lastItem() ?? 0 }} dari {{ $orders->total() }} pesanan
        </p>
        {{ $orders->links('admin.orders._pagination_links') }}
    </div>
</div>
