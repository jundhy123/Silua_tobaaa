@extends('layouts.user')

@section('title', 'Profil Perusahaan - Silua Toba')

@section('content')
<!-- Import Font Premium -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/profile-user.css') }}">

<div class="profile-page">
    
    <!-- SECTION 1: HERO FULL IMAGE (Premium & Clean) -->
    <section class="profile-hero-full-image reveal">
        <div class="hero-overlay"></div>
        <img src="{{ asset('images/bg_profil.png') }}" alt="Banner Silua Toba" class="banner-img">
       
    </section>

    <!-- SECTION 2: HEADER INTRO -->
    <header class="profile-header container reveal">
        <span class="top-label">TENTANG KAMI</span>
        <h2 class="main-title">Profil UMKM</h2>
        <p class="header-desc">
            Silua Toba bukan sekadar bisnis, ia adalah komunitas dan warisan. Kami percaya bahwa kebahagiaan sejati dimulai dari hidangan yang dimasak dengan cinta dan tradisi.
        </p>
        <div class="header-line"></div>
    </header>

    <!-- SECTION 3: SEJARAH (Dinamis dari Admin) -->
    <section class="container sejarah-section">
        <div class="grid-sejarah">
            <div class="sejarah-content reveal-left">
                <span class="icon-label"><i data-lucide="history"></i> SEJARAH KAMI</span>
                <h2 class="sejarah-title">Perjalanan Rasa Yang Dimulai dari <span class="italic-orange">Resep Keluarga</span></h2>
                
                <div class="sejarah-text">
                    {!! nl2br(e($info->history_text ?? 'Silua Toba hadir sebagai pusat oleh-oleh khas Toba yang mengedepankan kualitas dan keaslian rasa.')) !!}
                </div>

                <div class="stats-row">
                    <div class="stat-box">
                        <h3>2018</h3>
                        <p>TAHUN BERDIRI</p>
                    </div>
                    <div class="stat-box">
                        <h3>1k+</h3>
                        <p>PELANGGAN PUAS</p>
                    </div>
                </div>
            </div>

            <div class="sejarah-visual reveal-right">
                <div class="about-image-card">
                    <img src="{{ asset('images/foto2.jpeg') }}" alt="Dokumentasi Silua Toba">
                    <div class="decorative-blob"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 4: VISI MISI (Dinamis & Staggered Animation) -->
    <section class="visi-misi-container">
        <div class="container text-center mb-16 reveal">
            <h2 class="section-title-serif">Visi & Misi Kami</h2>
            <p class="section-subtitle">Prinsip yang memandu setiap langkah kami di Silua Toba.</p>
        </div>

        <div class="container visi-misi-grid">
            <!-- Visi (Light Card) -->
            <div class="vm-card visi reveal-up" style="transition-delay: 0.1s">
                <div class="vm-icon"><i data-lucide="eye"></i></div>
                <h3>Visi Kami</h3>
                <p>"{{ $info->vision ?? 'Visi belum diisi.' }}"</p>
                <div class="decorative-circles"></div>
            </div>

            <!-- Misi (Dark Card) -->
            <div class="vm-card misi reveal-up" style="transition-delay: 0.3s">
                <div class="vm-icon"><i data-lucide="target"></i></div>
                <h3>Misi Kami</h3>
                <div class="misi-list">
                    <p>{{ $info->mission ?? 'Misi belum diisi.' }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 5: TIM (Dinamis Loop) -->
    <section class="container team-section">
        <div class="text-center mb-12 reveal">
            <span class="top-label">OUR TEAM</span>
            <h2 class="section-title-serif">Orang-orang Hebat di Silua Toba</h2>
        </div>

        <div class="team-grid">
            @forelse($teams as $key => $t)
            <div class="team-card reveal-up" style="--order: {{ $key }}">
                <div class="team-img">
                    <img src="{{ asset('uploads/teams/'.$t->photo) }}" alt="{{ $t->name }}">
                    <div class="team-overlay">
                        <p>"Berdedikasi untuk kualitas rasa terbaik."</p>
                    </div>
                </div>
                <div class="team-info">
                    <h5>{{ $t->name }}</h5>
                    <p class="position">{{ $t->position }}</p>
                </div>
            </div>
            @empty
                <p class="col-span-full text-center text-gray-400 italic">Data tim belum dimasukkan.</p>
            @endforelse
        </div>
    </section>
<!-- SECTION 6: MAPS (Dinamis dari Admin) -->
<section class="maps-section-premium">
    <div class="container grid-maps reveal">
        <div class="maps-info">
            <h2 class="maps-title">Kunjungi <br> <span class="text-orange">Kami</span></h2>
            <p>Temukan kehangatan bumbu khas Toba langsung di lokasi kami.</p>
            <div class="h-1 w-12 bg-orange-brand mt-6"></div>
        </div>
        <div class="map-wrapper shadow-premium">
            @php
                $map = $info->map_embed ?? '';

                // Perbaiki link Google Maps biasa → embed
                $map = str_replace('www.google.com/maps', 'maps.google.com/maps', $map);

                // Tambahkan output=embed jika belum ada
                if ($map && !str_contains($map, 'output=embed')) {
                    $map .= (str_contains($map, '?') ? '&' : '?') . 'output=embed';
                }
            @endphp

            <iframe 
                src="{{ $map }}" 
                width="100%" 
                height="450" 
                style="border:0;" 
                allowfullscreen 
                loading="lazy">
            </iframe>
        </div>
    </div>
</section>

<!-- SECTION DATA PERUSAHAAN -->
    <section class="container data-perusahaan-section reveal">
        <div class="data-card-premium">
            <!-- Dekorasi bulatan di pojok kiri atas sesuai gambar -->
            <div class="card-corner-decoration"></div>

            <h2 class="data-card-title">Data usaha</h2>

            <div class="data-card-list">
                <div class="data-card-row">
                    <span class="data-label">NAMA UMKM</span>
                    <span class="data-value">{{ $info->company_name ?? 'Rasa Asli Tanah Batak(Silua Toba)' }}</span>
                </div>
                
                <div class="data-card-row">
                    <span class="data-label">TAHUN BERDIRI</span>
                    <span class="data-value">{{ $info->established_year ?? '2016' }}</span>
                </div>
                
                <div class="data-card-row">
                    <span class="data-label">IZIN USAHA</span>
                    <span class="data-value">{{ $info->business_permit ?? 'P-IRT No. 123456789/2026' }}</span>
                </div>
                
                <div class="data-card-row">
                    <span class="data-label">SERTIFIKASI</span>
                    <span class="data-value">{{ $info->certification ?? 'Halal Indonesia (H-998877)' }}</span>
                </div>
            </div>
        </div>
    </section>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const observerOptions = { threshold: 0.15 };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.reveal, .reveal-up, .reveal-left, .reveal-right').forEach(el => observer.observe(el));
        if(typeof lucide !== 'undefined') lucide.createIcons();
    });
</script>
@endsection