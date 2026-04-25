@extends('layouts.admin')
@section('page_title', 'Kelola Info Profil')

@section('content')
<div class="max-w-6xl mx-auto">

    <!-- HEADER ATAS -->
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-bold text-gray-700">
            Data Profil
        </h2>

        <a href="{{ route('admin.profile.create') }}"
           class="px-4 py-2 text-sm font-semibold text-white rounded-xl shadow-md
                  hover:scale-105 transition"
           style="background: linear-gradient(to right, #4FB7B3, #637AB9);">
            + Tambah
        </a>
    </div>

    <!-- HEADER TABLE -->
    <div class="grid grid-cols-12 px-6 py-4 text-white text-xs font-bold uppercase tracking-wide
                rounded-t-2xl"
         style="background: linear-gradient(to right, #000000, #1f3c3a);">
        <div class="col-span-7">Judul & Deskripsi</div>
        <div class="col-span-3">Tanggal</div>
        <div class="col-span-2 text-center">Aksi</div>
    </div>

    <!-- BODY -->
    <div class="bg-white rounded-b-2xl shadow-sm divide-y">

        @forelse ($profiles as $profile)
        <div class="grid grid-cols-12 items-center px-6 py-4 hover:bg-gray-50 transition">

            <!-- TITLE -->
            <div class="col-span-7">
                <h3 class="font-semibold text-gray-800 text-sm">
                    {{ $profile->hero_title }}
                </h3>
                <p class="text-xs text-gray-400 italic">
                    {{ Str::limit($profile->history_text, 60) }}
                </p>
            </div>

            <!-- DATE -->
            <div class="col-span-3">
                <span class="text-[10px] bg-gray-100 px-3 py-1 rounded-full text-gray-500 font-semibold">
                    {{ $profile->created_at->format('d M Y') }}
                </span>
            </div>

            <!-- ACTION -->
            <div class="col-span-2 flex justify-center gap-2">

                <!-- EDIT -->
                <a href="{{ route('admin.profile.edit', $profile->id) }}"
                   class="px-3 py-1.5 text-xs rounded-lg 
                          bg-gray-100 hover:bg-gray-200 text-gray-700 transition font-semibold">
                    Edit
                </a>

                <!-- DELETE -->
                <form action="{{ route('admin.profile.destroy', $profile->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        onclick="return confirm('Hapus data ini?')"
                        class="px-3 py-1.5 text-xs rounded-lg 
                               bg-red-50 hover:bg-red-100 text-red-500 transition font-semibold">
                        Hapus
                    </button>
                </form>

            </div>
        </div>

        @empty
        <div class="p-6 text-center text-gray-400 text-sm">
            Tidak ada data
        </div>
        @endforelse

    </div>
</div>
@endsection