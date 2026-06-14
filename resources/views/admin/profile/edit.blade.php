@extends('layouts.admin')

@section('title', 'Edit Profil - Admin Silua Toba')
@section('page_title', 'Update Identitas')

@section('content')
<style>
    :root { --primary-orange: #FF5722; }
    .form-card {
        background: white;
        border-radius: 3.5rem;
        padding: 4rem;
        border: 1px solid #f1f5f9;
    }
    .form-label {
        display: block;
        font-size: 10px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.2em;
        color: #94a3b8;
        margin-bottom: 1rem;
    }
    .form-input {
        width: 100%;
        padding: 1.25rem 1.5rem;
        background: #f8fafc;
        border: 2px solid transparent;
        border-radius: 1.25rem;
        font-size: 0.95rem;
        color: #1e293b;
        transition: all 0.3s ease;
    }
    .form-input:focus {
        background: white;
        border-color: var(--primary-orange);
        outline: none;
        box-shadow: 0 10px 25px -5px rgba(255, 87, 34, 0.1);
    }
    .btn-save {
        background: #111;
        color: white;
        padding: 1.25rem 2.5rem;
        border-radius: 1.25rem;
        font-weight: 800;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        transition: all 0.3s ease;
        width: 100%;
    }
    .btn-save:hover {
        background: var(--primary-orange);
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(255, 87, 34, 0.2);
    }
</style>

<div class="max-w-5xl mx-auto space-y-10 animate-fade-in">
    <!-- HEADER -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h1 class="text-4xl font-black italic text-gray-900" style="font-family: 'Playfair Display', serif;">Edit <span class="text-primary-orange">Identitas Bisnis</span></h1>
            <p class="text-gray-400 text-sm mt-1 italic">Perbarui narasi visi, misi, dan fundamental profil perusahaan.</p>
        </div>
        <a href="{{ route('admin.profile.index') }}" class="px-6 py-3 bg-white border border-gray-100 text-gray-400 rounded-xl font-black uppercase tracking-widest text-[10px] hover:bg-gray-900 hover:text-white transition-all shadow-sm flex items-center gap-2">
            <i data-lucide="x" class="w-4 h-4"></i>
            Batalkan
        </a>
    </div>

    <!-- FORM CARD -->
    <div class="form-card shadow-sm">
        <form action="{{ route('admin.profile.update', $profile->id) }}" method="POST" class="space-y-10">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <span class="text-[10px] font-black uppercase tracking-widest text-primary-orange border-b-2 border-orange-50 pb-2 inline-block">Kehadiran Digital</span>
                <div class="space-y-2">
                    <label class="form-label">Headline Utama (Hero Section)</label>
                    <input type="text" name="hero_title" value="{{ old('hero_title', $profile->hero_title) }}" required class="form-input font-bold italic text-xl">
                </div>
            </div>

            <div class="space-y-2">
                <label class="form-label">Sejarah & Filosofi Brand</label>
                <textarea name="history_text" rows="8" required class="form-input resize-none leading-relaxed">{{ old('history_text', $profile->history_text) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="form-label">Pernyataan Visi</label>
                    <textarea name="vision" rows="5" required class="form-input resize-none">{{ old('vision', $profile->vision) }}</textarea>
                </div>
                <div class="space-y-2">
                    <label class="form-label">Pernyataan Misi</label>
                    <textarea name="mission" rows="5" required class="form-input resize-none">{{ old('mission', $profile->mission) }}</textarea>
                </div>
            </div>

            <div class="space-y-2">
                <label class="form-label">URL Embed Google Maps</label>
                <div class="relative">
                    <i data-lucide="map-pin" class="absolute left-5 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-300"></i>
                    <input type="text" name="map_embed" value="{{ old('map_embed', $profile->map_embed) }}" required class="form-input !pl-14 text-xs font-medium">
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="btn-save">
                    Konfirmasi Pembaruan Profil
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
