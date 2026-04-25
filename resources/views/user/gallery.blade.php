@extends('layouts.user')

@section('title', 'Galeri Rasa - Silua Toba')

@section('content')
<!-- Import Font Premium -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/gallery-user.css') }}">

<section class="gallery-wrapper">
    <div class="container">
        
        <!-- HEADER ALA RASA NUSANTARA -->
        <div class="gallery-header reveal">
            <span class="visual-story-label">VISUAL STORY</span>
            <h1 class="gallery-title">Galeri Rasa</h1>
            <div class="header-divider"></div>
        </div>

        <!-- MOSAIC GRID (Masonry Style) -->
        <div class="mosaic-container">
            @foreach($galleries as $key => $g)
            <div class="mosaic-item reveal-up" style="--order: {{ $key }}" 
                 onclick="openFullImage('{{ asset('uploads/gallery/'.$g->file) }}', '{{ $g->title }}', '{{ $g->description }}')">
                
                <div class="mosaic-card">
                    <img src="{{ asset('uploads/gallery/'.$g->file) }}" alt="{{ $g->title }}" class="gallery-img">
                    
                    <!-- Overlay Hover Premium -->
                    <div class="mosaic-overlay">
                        <div class="zoom-icon-box">
                            <i data-lucide="search"></i>
                        </div>
                        <span class="view-moment-text">LIHAT MOMEN</span>
                    </div>
                </div>
                
                <!-- Caption bawah (opsional, jika ingin bersih bisa dihapus) -->
                <div class="mosaic-caption">
                    <p>{{ $g->title }}</p>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

<!-- LIGHTBOX VIEWER PREMIUM -->
<div id="siluaLightbox" class="premium-lightbox" onclick="closeLightbox()">
    <button class="lightbox-close">&times;</button>
    <div class="lightbox-content" onclick="event.stopPropagation()">
        <div class="image-container">
            <img id="fullImage" src="" class="zoom-animation">
        </div>
        <div class="lightbox-info">
            <h3 id="lightboxTitle"></h3>
            <p id="lightboxDesc"></p>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Intersection Observer untuk Animasi Muncul
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.reveal, .reveal-up').forEach(el => observer.observe(el));
        
        if(typeof lucide !== 'undefined') lucide.createIcons();
    });

    function openFullImage(src, title, desc) {
        const lightbox = document.getElementById('siluaLightbox');
        document.getElementById('fullImage').src = src;
        document.getElementById('lightboxTitle').innerText = title;
        document.getElementById('lightboxDesc').innerText = desc || "";
        
        lightbox.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        document.getElementById('siluaLightbox').classList.remove('active');
        document.body.style.overflow = 'auto';
    }
</script>
@endsection