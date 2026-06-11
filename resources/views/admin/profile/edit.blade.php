@extends('layouts.admin')

@section('title', 'Edit Profil - Admin Silua Toba')
@section('page_title', 'Update Identitas')

@section('content')
<link rel="stylesheet" href="{{ asset('css/produk-admin.css') }}">

<div class="max-w-5xl mx-auto space-y-10 animate-fade-in">
    <!-- HEADER -->
    <div class="flex items-center gap-6">
        <a href="{{ route('admin.profile.index') }}" class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-[#64748B] shadow-sm border border-[#E2E8F0] hover:bg-[#31326F] hover:text-white transition-all">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-3xl font-black text-[#31326F]">Edit <span class="text-[#4FB7B3]">Identitas Bisnis</span></h1>
            <p class="text-[#64748B] text-sm mt-1">Perbarui narasi visi, misi, dan fundamental profil perusahaan.</p>
        </div>
    </div>

    <!-- FORM CARD -->
    <div class="admin-form-card">
        <form action="{{ route('admin.profile.update', $profile->id) }}" method="POST" class="space-y-10">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <span class="text-[10px] font-black uppercase tracking-widest text-[#4FB7B3] border-b border-[#A8FBD3] pb-2 inline-block">Kehadiran Digital</span>
                <div class="space-y-2">
                    <label class="form-label-premium">Headline Utama (Hero)</label>
                    <input type="text" name="hero_title" value="{{ old('hero_title', $profile->hero_title) }}" required class="form-input-premium font-bold italic text-lg">
                </div>
            </div>

            <div class="space-y-2">
                <label class="form-label-premium">Sejarah & Filosofi Brand</label>
                <textarea name="history_text" rows="8" required class="form-input-premium leading-relaxed">{{ old('history_text', $profile->history_text) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="form-label-premium">Pernyataan Visi</label>
                    <textarea name="vision" rows="5" required class="form-input-premium">{{ old('vision', $profile->vision) }}</textarea>
                </div>
                <div class="space-y-2">
                    <label class="form-label-premium">Pernyataan Misi</label>
                    <textarea name="mission" rows="5" required class="form-input-premium">{{ old('mission', $profile->mission) }}</textarea>
                </div>
            </div>

            <div class="space-y-2">
                <label class="form-label-premium">Lokasi Google Maps (Embed)</label>
                <div class="relative group">
                    <input type="text" name="map_embed" value="{{ old('map_embed', $profile->map_embed) }}" required class="form-input-premium !pl-14 text-xs font-medium">
                    <i data-lucide="map-pin" class="absolute left-5 top-1/2 -translate-y-1/2 w-5 h-5 text-[#CBD5E1]"></i>
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="btn-submit-premium !bg-[#4FB7B3] hover:!bg-[#31326F]">
                    Konfirmasi Pembaruan Profil
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
