@extends('layouts.user')

@section('title', 'Silua Toba - Artisanal Culinary Experience')
@section('nav_type', 'nav-light')

@section('content')
<link rel="stylesheet" href="{{ asset('css/home-layout.css') }}">
<link rel="stylesheet" href="{{ asset('css/animations.css') }}">

<!-- ==========================================================================
     SECTION 1: EDITORIAL HERO SLIDER
     ========================================================================== -->
<section class="hero-editorial-slider">
    <!-- Slide 1 -->
    <div class="premium-slide active">
        <div class="slide-bg-wrap">
            <img src="{{ asset('images/bgg.webp') }}" class="ken-burns">
        </div>
        <div class="max-w-7xl mx-auto px-8 h-full flex items-center relative z-10">
            <div class="text-container-masked">
                <div class="reveal-line"><span class="micro-label">Koleksi Warisan</span></div>
                <div class="reveal-line">
                    <h1 class="hero-main-text text-white">Sambal <i>Nikmat</i></h1>
                </div>
                <div class="reveal-line">
                    <h1 class="hero-main-text text-white">& Pedas.</h1>
                </div>
                <div class="reveal-line">
                    <p class="hero-sub-text">Resep warisan keluarga yang diolah dengan rempah pilihan dari tanah Toba.</p>
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
        <div class="max-w-7xl mx-auto px-8 h-full flex items-center relative z-10">
            <div class="text-container-masked">
                <div class="reveal-line"><span class="micro-label">Kopi Premium</span></div>
                <div class="reveal-line">
                    <h1 class="hero-main-text text-white">Kopi <i>Toba</i></h1>
                </div>
                <div class="reveal-line">
                    <h1 class="hero-main-text text-white">Robusta.</h1>
                </div>
                <div class="reveal-line">
                    <p class="hero-sub-text">Biji kopi pilihan dari petani lokal, disangrai dengan presisi untuk aroma maksimal.</p>
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
        <div class="max-w-7xl mx-auto px-8 h-full flex items-center relative z-10">
            <div class="text-container-masked">
                <div class="reveal-line"><span class="micro-label">Otentik Batak</span></div>
                <div class="reveal-line">
                    <h1 class="hero-main-text text-white">Cita <i>Rasa</i></h1>
                </div>
                <div class="reveal-line">
                    <h1 class="hero-main-text text-white">Autentik.</h1>
                </div>
                <div class="reveal-line">
                    <p class="hero-sub-text">Membawa kehangatan dapur Batak langsung ke meja makan Anda.</p>
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
            <button class="nav-round-btn group hover:bg-white hover:text-black transition-all duration-300" onclick="prevSlide()">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </button>
            <button class="nav-round-btn group hover:bg-white hover:text-black transition-all duration-300" onclick="nextSlide()">
                <i data-lucide="arrow-right" class="w-5 h-5"></i>
            </button>
        </div>
        <div class="slider-counter text-white font-medium tracking-widest text-sm">
            <span id="currentNum" class="text-xl font-bold">01</span> <span class="opacity-40">/ 03</span>
        </div>
    </div>
</section>

<!-- ==========================================================================
     SECTION 2: MARQUEE (TRUST BADGES)
     ========================================================================== -->
<div class="py-10 bg-[#F5F5F0] overflow-hidden whitespace-nowrap border-y border-black/5">
    <div class="flex animate-marquee gap-20 items-center">
        @foreach(range(1, 4) as $i)
        <span class="text-2xl font-bold text-black/20 flex items-center gap-4 italic uppercase">
            <i data-lucide="award" class="w-6 h-6 text-amber-700"></i> Rasa Lokal Terbaik
        </span>
        <span class="text-2xl font-bold text-black/20 flex items-center gap-4 italic uppercase">
            <i data-lucide="leaf" class="w-6 h-6 text-amber-700"></i> Bahan Organik
        </span>
        <span class="text-2xl font-bold text-black/20 flex items-center gap-4 italic uppercase">
            <i data-lucide="heart" class="w-6 h-6 text-amber-700"></i> Warisan Keluarga
        </span>
        <span class="text-2xl font-bold text-black/20 flex items-center gap-4 italic uppercase">
            <i data-lucide="shield-check" class="w-6 h-6 text-amber-700"></i> Kualitas Premium
        </span>
        @endforeach
    </div>
</div>

<!-- ==========================================================================
     SECTION 3: ASYMMETRIC STORY
     ========================================================================== -->
<section class="py-32 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-8 grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
        <div class="relative group reveal-left">
            <div class="story-frame-oval shadow-2xl transition-transform duration-700 group-hover:scale-[1.02]">
                <img src="{{ asset('images/foto1.jpeg') }}" alt="Silua Toba Heritage" class="w-full h-full object-cover">
            </div>
            <div class="absolute -bottom-10 -right-10 w-64 h-64 bg-amber-700/10 rounded-full blur-3xl -z-10 animate-pulse"></div>
            <div class="story-glow"></div>
        </div>

        <div class="text-left space-y-8 reveal-right">
            <div>
                <span class="micro-label block mb-4">Sejarah & Tradisi</span>
                <h2 class="text-5xl md:text-7xl font-black italic text-gray-900 leading-tight" style="font-family: 'Playfair Display', serif;">Cita Rasa Otentik <i>Warisan</i></h2>
            </div>
            <p class="section-desc-premium text-lg leading-relaxed text-gray-600">
                Silua Toba lahir dari kerinduan akan cita rasa otentik tanah Batak. Kami menyajikan hidangan yang memadukan resep turun-temurun dengan sentuhan modern, menggunakan bahan-bahan segar dari hasil bumi Danau Toba.
            </p>
            <div class="grid grid-cols-2 gap-8 pt-4">
                <div class="space-y-2">
                    <h4 class="text-3xl font-bold text-amber-800 italic">100%</h4>
                    <p class="text-xs uppercase tracking-widest font-bold text-gray-400">Bahan Alami</p>
                </div>
                <div class="space-y-2">
                    <h4 class="text-3xl font-bold text-amber-800 italic">5+</h4>
                    <p class="text-xs uppercase tracking-widest font-bold text-gray-400">Resep Warisan</p>
                </div>
            </div>
            <div class="pt-8">
                <a href="{{ route('user.about') }}" class="link-premium group inline-flex items-center gap-4 text-sm font-bold uppercase tracking-widest">
                    Pelajari Kisah Kami
                    <span class="w-12 h-12 flex items-center justify-center rounded-full border border-black/10 group-hover:bg-black group-hover:text-white transition-all duration-300">
                        <i data-lucide="arrow-right" class="w-5 h-5"></i>
                    </span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
     SECTION 4: FEATURED PRODUCTS (NEW)
     ========================================================================== -->
<section class="py-32 bg-[#141414] text-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-8">
        <div class="flex flex-col md:flex-row justify-between items-end mb-20 gap-8 reveal-bottom">
            <div class="max-w-xl">
                <span class="micro-label !text-amber-500 mb-6 block">Produk Unggulan</span>
                <h2 class="text-5xl md:text-6xl font-black italic mb-0">Produk <i>Wajib</i> Coba</h2>
            </div>
            <a href="{{ route('user.products') }}" class="text-sm font-bold uppercase tracking-[0.3em] text-white/50 hover:text-amber-500 transition-colors">
                Lihat Semua Produk →
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($products->take(3) as $product)
            <div class="group relative overflow-hidden rounded-[40px] bg-white/5 border border-white/10 hover:border-amber-500/50 transition-all duration-500 reveal-bottom" style="transition-delay: {{ $loop->index * 200 }}ms">
                <div class="aspect-square overflow-hidden">
                    <img src="{{ asset('uploads/products/' . $product->image) }}" alt="{{ $product->name }}"
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                </div>
                <div class="p-10">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-2xl font-bold">{{ $product->name }}</h3>
                        <span class="text-amber-500 font-bold italic">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>
                    <p class="text-white/40 text-sm line-clamp-2 mb-8 leading-relaxed">
                        {{ $product->description }}
                    </p>
                    <button onclick='openOrderModal({{ $product->id }}, "{{ addslashes($product->name) }}", {{ $product->price }}, "{{ asset('uploads/products/' . $product->image) }}", "{{ addslashes($product->description) }}", @json($product->reviews))'
                            class="w-full py-4 rounded-full border border-white/20 hover:bg-white hover:text-black font-bold uppercase tracking-widest text-[10px] transition-all duration-300">
                        Pesan Sekarang
                    </button>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-20 border border-dashed border-white/20 rounded-[40px]">
                <p class="text-white/40 italic">Belum ada produk unggulan yang ditampilkan.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- ==========================================================================
     SECTION 5: THREE PILLARS (REFINED)
     ========================================================================== -->
<section class="py-32 bg-[#F5F5F0] overflow-hidden">
    <div class="max-w-7xl mx-auto px-8">
        <div class="text-center mb-24 reveal-bottom">
            <span class="micro-label mb-6 block">Kualitas Kami</span>
            <h2 class="text-5xl md:text-7xl font-black italic text-gray-900 text-center" style="font-family: 'Playfair Display', serif;">Mengapa Memilih <i>Silua Toba</i>?</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <!-- Pillar 1 -->
            <div class="pillar-card hover:shadow-2xl hover:-translate-y-4 transition-all duration-500 reveal-left">
                <div class="pillar-icon-box"><i data-lucide="utensils"></i></div>
                <h3 class="text-2xl">Menu Terbaik</h3>
                <p class="text-gray-500 leading-relaxed">Kurasi menu terbaik dari tanah batak yang diolah secara tradisional dengan resep rahasia.</p>
            </div>

            <!-- Pillar 2 (Visual Break) -->
            <div class="pillar-card active-pillar !shadow-2xl reveal-bottom">
                <div class="pillar-icon-box"><i data-lucide="award"></i></div>
                <h3 class="text-white text-2xl">Kualitas Premium</h3>
                <p class="text-white/60 leading-relaxed">Hanya menggunakan bahan-bahan organik segar dengan standar mutu tinggi dan tanpa pengawet.</p>
            </div>

            <!-- Pillar 3 -->
            <div class="pillar-card hover:shadow-2xl hover:-translate-y-4 transition-all duration-500 reveal-right">
                <div class="pillar-icon-box"><i data-lucide="users"></i></div>
                <h3 class="text-2xl">Lokal & Dedikasi</h3>
                <p class="text-gray-500 leading-relaxed">Dikelola oleh pengrajin kuliner lokal yang berdedikasi menjaga cita rasa luhur nusantara.</p>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
     SECTION 6: CTA (NEW)
     ========================================================================== -->
<section class="relative py-40 overflow-hidden bg-white reveal-bottom">
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/bgg.webp') }}" class="w-full h-full object-cover opacity-10">
        <div class="absolute inset-0 bg-gradient-to-t from-white via-transparent to-white"></div>
    </div>

    <div class="relative z-10 max-w-4xl mx-auto px-8 text-center">
        <h2 class="text-5xl md:text-7xl font-black italic text-gray-900 leading-tight mb-10" style="font-family: 'Playfair Display', serif;">Siap Mencicipi <i>Tradisi</i>?</h2>
        <p class="text-xl text-gray-500 mb-12 max-w-2xl mx-auto leading-relaxed">
            Pesan sekarang dan nikmati kelezatan kuliner khas Danau Toba yang diantar langsung ke depan pintu Anda.
        </p>
        <div class="flex flex-col sm:flex-row gap-6 justify-center">
            <a href="{{ route('user.products') }}" class="px-12 py-6 bg-black text-white rounded-full font-bold uppercase tracking-widest hover:bg-amber-800 transition-colors duration-300">
                Mulai Belanja
            </a>
            <a href="https://wa.me/6285361839192" class="px-12 py-6 border border-black/10 rounded-full font-bold uppercase tracking-widest hover:bg-black hover:text-white transition-all duration-300">
                Hubungi Kami
            </a>
        </div>
    </div>
</section>

@include('components.modal-detail-produk')

<style>
    @keyframes marquee {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    .animate-marquee {
        display: flex;
        width: max-content;
        animation: marquee 30s linear infinite;
    }
    .animate-marquee:hover {
        animation-play-state: paused;
    }
</style>

<script>
    let currentIdx = 0;
    const slides = document.querySelectorAll('.premium-slide');
    const currentNumText = document.getElementById('currentNum');

    function showSlide(index) {
        slides.forEach(s => {
            s.classList.remove('active');
            s.style.opacity = "0";
            s.style.visibility = "hidden";
        });

        if (index >= slides.length) currentIdx = 0;
        else if (index < 0) currentIdx = slides.length - 1;
        else currentIdx = index;

        slides[currentIdx].classList.add('active');
        slides[currentIdx].style.opacity = "1";
        slides[currentIdx].style.visibility = "visible";
        currentNumText.innerText = `0${currentIdx + 1}`;
    }

    function nextSlide() { showSlide(currentIdx + 1); }
    function prevSlide() { showSlide(currentIdx - 1); }

    // Auto slide
    let slideInterval = setInterval(nextSlide, 8000);

    // Pause on interaction
    function resetInterval() {
        clearInterval(slideInterval);
        slideInterval = setInterval(nextSlide, 8000);
    }

    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();

        // Intersection Observer for Scroll Animations
        const observerOptions = {
            threshold: 0.15,
            rootMargin: '0px 0px -50px 0px'
        };

        const scrollObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                }
            });
        }, observerOptions);

        const animatedElements = document.querySelectorAll('.reveal-left, .reveal-right, .reveal-bottom');
        animatedElements.forEach(el => scrollObserver.observe(el));
    });
</script>
@endsection
