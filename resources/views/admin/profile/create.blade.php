@extends('layouts.admin')

@section('title', 'Setup Profil - Admin Silua Toba')
@section('page_title', 'Identitas Korporat')

@section('content')
<link rel="stylesheet" href="{{ asset('css/produk-admin.css') }}">

<div class="max-w-5xl mx-auto space-y-10 animate-fade-in">
    <!-- HEADER -->
    <div class="flex items-center gap-6">
        <a href="{{ route('admin.profile.index') }}" class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-[#64748B] shadow-sm border border-[#E2E8F0] hover:bg-[#31326F] hover:text-white transition-all">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-3xl font-black text-[#31326F]">Setup <span class="text-[#4FB7B3]">Identitas</span></h1>
            <p class="text-[#64748B] text-sm mt-1">Konfigurasi fundamental dan visi misi perusahaan.</p>
        </div>
    </div>

    <!-- FORM CARD -->
    <div class="admin-form-card">
        <form action="{{ route('admin.profile.store') }}" method="POST" class="space-y-10">
            @csrf

            <div class="space-y-4">
                <span class="text-[10px] font-black uppercase tracking-widest text-[#4FB7B3] border-b border-[#A8FBD3] pb-2 inline-block">Kehadiran Digital</span>
                <div class="space-y-2">
                    <label class="form-label-premium">Headline Utama (Hero)</label>
                    <input type="text" name="hero_title" value="{{ old('hero_title') }}" required placeholder="cth. Silua Toba: Warisan Rasa Tanah Batak" class="form-input-premium font-bold italic text-lg">
                </div>
            </div>

            <div class="space-y-2">
                <label class="form-label-premium">Narasi Sejarah Brand</label>
                <textarea name="history_text" rows="6" placeholder="Kisah bagaimana semuanya dimulai..." required class="form-input-premium leading-relaxed">{{ old('history_text') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="form-label-premium">Visi Bisnis</label>
                    <textarea name="vision" rows="4" placeholder="Tujuan jangka panjang..." required class="form-input-premium">{{ old('vision') }}</textarea>
                </div>
                <div class="space-y-2">
                    <label class="form-label-premium">Misi Strategis</label>
                    <textarea name="mission" rows="4" placeholder="Tindakan harian..." required class="form-input-premium">{{ old('mission') }}</textarea>
                </div>
            </div>

            <div class="space-y-2">
                <label class="form-label-premium">URL Embed Google Maps</label>
                <div class="relative group">
                    <input type="text" name="map_embed" value="{{ old('map_embed') }}" required placeholder="https://www.google.com/maps/embed?..." class="form-input-premium !pl-14 text-xs font-medium">
                    <i data-lucide="map-pin" class="absolute left-5 top-1/2 -translate-y-1/2 w-5 h-5 text-[#CBD5E1]"></i>
                </div>
                <p class="text-[9px] text-[#64748B] italic px-2 mt-2">Dapatkan kode dari Google Maps > Bagikan > Sematkan peta > salin nilai 'src'</p>
            </div>

            <div class="pt-6">
                <button type="submit" class="btn-submit-premium">
                    Simpan Profil Perusahaan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
