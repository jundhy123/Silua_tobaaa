@extends('layouts.user')

@section('title', 'Tentang Kami - Rasa Nusantara')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/about-user.css') }}">

<div class="about-page-wrapper">
    
    {{-- ================= HERO ================= --}}
    @if($abouts->count() > 0)
    @php $first = $abouts->first(); @endphp

    <section class="about-hero container">
        <div class="about-text-content reveal-left">
            <span class="label-kisah">KISAH KAMI</span>

            <h1 class="about-title">
                {{ $first->title }} <br> 
                <span class="text-orange-brand">{{ $first->subtitle }}</span>
            </h1>
            
            <div class="about-description">
                {!! nl2br(e($first->description)) !!}
            </div>

            @if($first->years_experience)
            <div class="experience-badge">
                <span class="exp-number">{{ $first->years_experience }}+</span>
                <span class="exp-text">Tahun <br> Konsisten</span>
            </div>
            @endif
        </div>

        <div class="about-image-main reveal-right">
            <div class="premium-frame">
                <img src="{{ asset('uploads/about/' . $first->image) }}" alt="{{ $first->title }}">
            </div>
            <div class="decorative-circle"></div>
        </div>
    </section>
    @endif


    {{-- ================= STATS (HANYA SEKALI) ================= --}}
    <section class="stats-section reveal-up">
        <div class="container stats-grid">
            <div class="stat-item">
                <i data-lucide="heart" class="stat-icon"></i>
                <h2 class="stat-number">100%</h2>
                <p class="stat-label">Buatan Tangan</p>
            </div>
            <div class="stat-item">
                <i data-lucide="utensils" class="stat-icon"></i>
                <h2 class="stat-number">0%</h2>
                <p class="stat-label">Bahan Pengawet</p>
            </div>
            <div class="stat-item">
                <i data-lucide="clock" class="stat-icon"></i>
                <h2 class="stat-number">15th+</h2>
                <p class="stat-label">Berjalan</p>
            </div>
            <div class="stat-item">
                <i data-lucide="shield-check" class="stat-icon"></i>
                <h2 class="stat-number">100%</h2>
                <p class="stat-label">Halal</p>
            </div>
        </div>
    </section>


    {{-- ================= ZIGZAG CONTENT ================= --}}
    @foreach($abouts->skip(1) as $key => $a)
    <section class="zigzag-section {{ $key % 2 == 0 ? 'bg-soft' : '' }}">
        <div class="container">
            <div class="flex-container {{ $key % 2 == 0 ? 'flex-reverse' : '' }}">
                
                <div class="flex-image reveal-up">
                    <div class="secondary-frame">
                        <img src="{{ asset('uploads/about/' . $a->image) }}" alt="{{ $a->title }}">
                    </div>
                </div>

                <div class="flex-text reveal-up">
                    <h2 class="secondary-title">{{ $a->title }}</h2>
                    <span class="secondary-subtitle">{{ $a->subtitle }}</span>
                    <div class="divider"></div>

                    <div class="description-text">
                        {!! nl2br(e($a->description)) !!}
                    </div>
                </div>

            </div>
        </div>
    </section>
    @endforeach


    {{-- ================= EMPTY STATE ================= --}}
    @if($abouts->isEmpty())
        <div class="empty-state">
            <p>Belum ada konten "Tentang Kami" yang ditambahkan.</p>
        </div>
    @endif

</div>


{{-- ================= SCRIPT ================= --}}
<script>
document.addEventListener("DOMContentLoaded", function() {

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal-left, .reveal-right, .reveal-up')
        .forEach(el => observer.observe(el));

    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});
</script>

@endsection