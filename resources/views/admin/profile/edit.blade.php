@extends('layouts.admin')
@section('page_title', 'Edit Profil')

@section('content')
<div class="max-w-5xl mx-auto">

    <!-- NOTIFIKASI -->
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-xl flex items-center gap-3">
            <i data-lucide="check-circle" class="text-green-500 w-5 h-5"></i>
            <p class="text-sm text-green-700 font-bold">{{ session('success') }}</p>
        </div>
    @endif

    <!-- CARD -->
    <div class="admin-card border-t-8 border-orange-brand p-6">

        <!-- FORM -->
        <form action="{{ route('admin.profile.update', $profile->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- HERO TITLE -->
            <div class="admin-input-group">
                <label>Judul Utama Halaman Profil (Hero Title)</label>
                <input type="text" 
                       name="hero_title" 
                       value="{{ old('hero_title', $profile->hero_title) }}" 
                       class="silua-input-v2" 
                       required
                       placeholder="Contoh: Profil Perusahaan Silua Toba">

                <p class="text-[10px] text-gray-400 mt-1">
                    *Muncul sebagai tulisan besar di bagian atas halaman profil user.
                </p>
            </div>

            <!-- HISTORY -->
            <div class="admin-input-group">
                <label>Sejarah / Tentang</label>
                <textarea name="history_text" 
                          rows="6" 
                          class="silua-input-v2" 
                          required
                          placeholder="Ceritakan awal mula...">{{ old('history_text', $profile->history_text) }}</textarea>
            </div>

            <!-- VISI & MISI -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <div class="admin-input-group">
                    <label>Visi</label>
                    <textarea name="vision" 
                              rows="4" 
                              class="silua-input-v2" 
                              required
                              placeholder="Visi perusahaan...">{{ old('vision', $profile->vision) }}</textarea>
                </div>

                <div class="admin-input-group">
                    <label>Misi</label>
                    <textarea name="mission" 
                              rows="4" 
                              class="silua-input-v2" 
                              required
                              placeholder="Misi perusahaan...">{{ old('mission', $profile->mission) }}</textarea>
                </div>

            </div>

            <!-- MAP -->
            <div class="admin-input-group">
                <label>Link Embed Google Maps</label>
                <input type="text" 
                       name="map_embed" 
                       value="{{ old('map_embed', $profile->map_embed) }}" 
                       class="silua-input-v2" 
                       required
                       placeholder="Paste link dari Google Maps">

                <p class="text-[10px] text-gray-400 mt-1">
                    *Ambil dari Google Maps → Share → Embed → ambil URL src
                </p>
            </div>

            <!-- BUTTON -->
            <div class="pt-4">
                <button type="submit" 
                        class="btn-admin-submit-v2 w-full shadow-lg hover:scale-[1.02] transition">
                    <i data-lucide="save" class="w-5 h-5 mr-2"></i>
                    SIMPAN PERUBAHAN
                </button>
            </div>

        </form>
    </div>
</div>
@endsection