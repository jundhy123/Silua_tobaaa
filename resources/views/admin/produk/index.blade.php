@extends('layouts.admin')
@section('page_title', 'Data Profil')

@section('content')
<div class="max-w-5xl">

    <a href="{{ route('admin.profile.create') }}" class="btn-admin-submit-v2 mb-4 inline-block">
        + Tambah Profil
    </a>

    @if(session('success'))
        <p class="text-green-600">{{ session('success') }}</p>
    @endif

    @if($profiles->isEmpty())
        <p>Tidak ada data</p>
    @else
        @foreach ($profiles as $profile)
            <div class="admin-card mb-4 p-4">
                <h3 class="font-bold text-lg">{{ $profile->hero_title }}</h3>
                <p class="text-sm text-gray-500">{{ Str::limit($profile->history_text, 100) }}</p>

                <div class="mt-3 flex gap-2">
                    <a href="{{ route('admin.profile.edit', $profile->id) }}" class="btn-edit">
                        Edit
                    </a>

                    <form action="{{ route('admin.profile.destroy', $profile->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn-delete">Hapus</button>
                    </form>
                </div>
            </div>
        @endforeach
    @endif

</div>
@endsection