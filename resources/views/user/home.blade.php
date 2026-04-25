@extends('layouts.user')

@section('title', 'Silua Toba - Artisanal Culinary Experience')

@section('content')
<link rel="stylesheet" href="{{ asset('css/home-layout.css') }}">
<link rel="stylesheet" href="{{ asset('css/animations.css') }}">

<!-- ==========================================================================
     SECTION 1: EDITORIAL HERO SLIDER (MASKED REVEAL)
     ========================================================================== -->
<section class="hero-editorial-slider">
    <!-- Slide 1 -->
    <div class="premium-slide active">
        <div class="slide-bg-wrap">
            <img src="{{ asset('images/bgg.webp') }}" class="ken-burns">
        </div>
        <div class="max-w-7xl mx-auto px-8 h-full flex items-center">
            <div class="z-20 text-container-masked">
                <div class="reveal-line"><span class="micro-label">Heritage Collection</span></div>
                <div class="reveal-line">
                    <h1 class="hero-main-text text-white">Sambal <i>Nikmat</i></h1>
                </div>
                <div class="reveal-line">
                    <h1 class="hero-main-text text-white">& Pedas.</h1>
                </div>
                <div class="reveal-line">
                    <p class="hero-sub-text">Resep Buatan Keluarga.</p>
                </div>
                <div class="reveal-line mt-10">
                    <a href="{{ route('user.products') }}" class="btn-subway-pill">Jelajahi Rasa</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Slide 2 -->
    <div class="premium-slide">
        <div class="slide-bg-wrap">
            <img src="{{ asset('images/TobaKopi.jpg') }}" class="ken-burns">
        </div>
        <div class="max-w-7xl mx-auto px-8 h-full flex items-center">
            <div class="z-20 text-container-masked">
                <div class="reveal-line"><span class="micro-label">Premium Coffee</span></div>
                <div class="reveal-line">
                    <h1 class="hero-main-text text-white">Kopi <i>Toba</i></h1>
                </div>
                <div class="reveal-line">
                    <h1 class="hero-main-text text-white">Robusta.</h1>
                </div>
                <div class="reveal-line">
                    <p class="hero-sub-text">Diambil Dari Petani Sekitar.</p>
                </div>
                <div class="reveal-line mt-10">
                    <a href="{{ route('user.products') }}" class="btn-subway-pill">Pesan Sekarang</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Slide 3 -->
    <div class="premium-slide">
        <div class="slide-bg-wrap">
            <img src="{{ asset('images/miegomak.png') }}" class="ken-burns">
        </div>
        <div class="max-w-7xl mx-auto px-8 h-full flex items-center">
            <div class="z-20 text-container-masked">
                <div class="reveal-line"><span class="micro-label">Authentic Batak</span></div>
                <div class="reveal-line">
                    <h1 class="hero-main-text text-white">Cita <i>Rasa</i></h1>
                </div>
                <div class="reveal-line">
                    <h1 class="hero-main-text text-white">Autentik.</h1>
                </div>
                <div class="reveal-line">
                    <p class="hero-sub-text">Kebanggaan masyarakat Danau Toba.</p>
                </div>
                <div class="reveal-line mt-10">
                    <a href="{{ route('user.about') }}" class="btn-subway-pill">Tentang Kami</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation UI -->
    <div class="absolute bottom-12 left-12 z-50 flex items-center gap-6">
        <div class="flex gap-3">
            <button class="nav-round-btn" onclick="prevSlide()"><i data-lucide="arrow-left"></i></button>
            <button class="nav-round-btn" onclick="nextSlide()"><i data-lucide="arrow-right"></i></button>
        </div>
        <div class="slider-counter text-white font-bold">
            <span id="currentNum">01</span> <span class="opacity-30">/ 03</span>
        </div>
    </div>
</section> <!-- SELESAI SECTION SLIDER -->

<!-- ==========================================================================
     SECTION 2: ASYMMETRIC STORY (AUTHENTIC TASTE)
     ========================================================================== -->
<section class="py-32 bg-white">
    <div class="max-w-7xl mx-auto px-8 grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
        <div class="relative">
            <!-- Masked Image Oval/Pill Shape -->
            <div class="story-frame-oval shadow-2xl">
                <img src="{{ asset('images/foto1.jpeg') }}" alt="Silua Toba Heritage" class="w-full h-full object-cover">
            </div>
            <div class="story-glow"></div>
        </div>

        <div class="text-left px-4">
            <span class="micro-label mb-6 block">Selamat Datang</span>
            <h2 class="section-title-premium">Authentic Taste of <i>Heritage</i></h2>
            <p class="section-desc-premium">
                Kami menyajikan makanan hingga cemilan dengan memadukan konsep budaya batak dan memasukkan budaya modren. Komitmen kami adalah menghadirkan rasa yang jujur, bahan yang segar, dan pelayanan yang tulus.
            </p>
            <br>
            <a href="{{ route('user.about') }}" class="link-premium group">
                Pelajari Kisah Kami 
                <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-2 transition-transform"></i>
            </a>
        </div>
    </div>
</section>

<!-- ==========================================================================
     SECTION 3: THREE PILLARS (DARK BREAK BOX)
     ========================================================================== -->
<section class="py-32 bg-[#F5F5F0]">
    <div class="max-w-7xl mx-auto px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            
            <!-- Pillar 1 -->
            <div class="pillar-card shadow-premium">
                <div class="pillar-icon-box"><i data-lucide="utensils"></i></div>
                <h3>Menu Terbaik</h3>
                <p>Kurasi menu terbaik dari tanah batak yang diolah secara tradisional.</p>
                <a href="{{ route('user.products') }}">Jelajahi Menu</a>
            </div>

            <!-- Pillar 2 (Visual Break - Hitam Dof) -->
            <div class="pillar-card active-pillar shadow-2xl">
                <div class="pillar-icon-box"><i data-lucide="award"></i></div>
                <h3 class="text-white">Kualitas Premium</h3>
                <p class="text-white/60">Hanya menggunakan bahan-bahan organik segar dengan standar mutu tinggi.</p>
                <a href="#" class="text-white">lihat galeri</a>
            </div>

            <!-- Pillar 3 -->
            <div class="pillar-card shadow-premium">
                <div class="pillar-icon-box"><i data-lucide="users"></i></div>
                <h3>Tim Loyal</h3>
                <p>Dikelola oleh pengrajin kuliner lokal yang berdedikasi menjaga cita rasa luhur.</p>
                <a href="{{ route('user.profile') }}">Kenali Tim</a>
            </div>

        </div>
    </div>
</section>

<script>
    let currentIdx = 0;
    const slides = document.querySelectorAll('.premium-slide');
    const currentNumText = document.getElementById('currentNum');

    function showSlide(index) {
        slides.forEach(s => s.classList.remove('active'));
        if (index >= slides.length) currentIdx = 0;
        else if (index < 0) currentIdx = slides.length - 1;
        else currentIdx = index;
        slides[currentIdx].classList.add('active');
        currentNumText.innerText = `0${currentIdx + 1}`;
    }

    function nextSlide() { showSlide(currentIdx + 1); }
    function prevSlide() { showSlide(currentIdx - 1); }
    setInterval(nextSlide, 8000);

    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
    });
</script>
@endsection