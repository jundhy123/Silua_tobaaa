@extends('layouts.admin')
@section('page_title', 'Kelola About Us')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="admin-card border-t-8 border-gray-soft">

        {{-- NOTIFIKASI SUCCESS --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.about.update', $about->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="admin-input-group">
                    <label>Judul Utama (Title)</label>
                    <input type="text" name="title" value="{{ $about->title }}" class="silua-input-v2" required>
                </div>

                <div class="admin-input-group">
                    <label>Sub-Judul (Subtitle)</label>
                    <input type="text" name="subtitle" value="{{ $about->subtitle }}" class="silua-input-v2" required>
                </div>
            </div>

            <div class="admin-input-group">
                <label>Deskripsi Cerita</label>
                <textarea name="description" rows="6" class="silua-input-v2" required>{{ $about->description }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="admin-input-group">
                    <label>Tahun Pengalaman</label>
                    <input type="text" name="years_experience" value="{{ $about->years_experience }}" class="silua-input-v2">
                </div>

                <div class="admin-input-group">
                    <label>Foto Dokumentasi About</label>
                    <input type="file" name="image" class="silua-input-v2 file-input">

                    @if($about->image)
                        <p class="text-xs mt-2 text-gray-400">
                            File: {{ $about->image }}
                        </p>
                        <img src="{{ asset('uploads/about/' . $about->image) }}" class="mt-2 w-32 rounded">
                    @endif
                </div>
            </div>

            <button type="submit" class="btn-admin-submit-v2 w-full">
                SIMPAN PERUBAHAN ABOUT US
            </button>
        </form>

    </div>
</div>
@endsection