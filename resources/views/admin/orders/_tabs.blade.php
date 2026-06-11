@php
    $groups = [
        'all' => 'Semua Pesanan',
        'today' => 'Hari Ini',
        'yesterday' => 'Kemarin',
        'week' => 'Minggu Ini',
        'month' => 'Bulan Ini'
    ];
    $currentGroup = request('group', 'all');
@endphp
@foreach($groups as $key => $label)
    <a href="{{ request()->fullUrlWithQuery(['group' => $key]) }}"
       class="px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all
       {{ $currentGroup == $key ? 'bg-gray-900 text-white shadow-xl shadow-gray-200' : 'bg-white text-gray-400 border border-gray-100 hover:bg-gray-50' }}">
       {{ $label }}
    </a>
@endforeach
