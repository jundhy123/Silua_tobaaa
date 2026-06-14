@extends('layouts.user')

@section('title', 'Visual Archive - Silua Toba Gallery')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<div class="bg-[#FDFDFB] min-h-screen pt-32 pb-20 overflow-hidden">

    <!-- SECTION 1: EDITORIAL HEADER -->
    <header class="max-w-7xl mx-auto px-8 mb-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-end">
            <div class="lg:col-span-8 reveal-up">
                <span class="micro-label mb-6 block">Dokumentasi Kami</span>
                <h1 class="text-5xl md:text-7xl font-black italic leading-tight mb-0" style="font-family: 'Playfair Display', serif;">
                    Mengabadikan <i>Esensi</i>
                </h1>
            </div>
            <div class="lg:col-span-4 text-right reveal-up" style="transition-delay: 200ms">
                <p class="text-xl text-gray-400 italic leading-relaxed max-w-xs ml-auto">
                    "Setiap sudut, setiap rasa, dan setiap momen yang tertangkap dalam bingkai kejujuran."
                </p>
                <div class="w-20 h-1 bg-amber-700 ml-auto mt-10"></div>
            </div>
        </div>
    </header>

    <!-- SECTION 2: CURATED MASONRY -->
    <section class="max-w-[1400px] mx-auto px-8">
        @php
            $spans = [
                0 => 'md:col-span-2 md:row-span-2',
                1 => 'col-span-1 row-span-1',
                2 => 'md:col-span-2 md:row-span-1',
                3 => 'col-span-1 md:row-span-2',
                4 => 'col-span-1 row-span-1',
                5 => 'md:col-span-2 md:row-span-1',
                6 => 'col-span-1 row-span-1',
                7 => 'col-span-1 md:row-span-2',
            ];
        @endphp
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 auto-rows-[240px] grid-flow-row-dense">
            @foreach($galleries as $key => $g)
            @php
                $spanClass = $spans[$key % 8] ?? 'col-span-1 row-span-1';
            @endphp
            <div class="reveal-up {{ $spanClass }}" style="transition-delay: {{ ($key % 5) * 100 }}ms">
                <div class="group relative bg-white p-3.5 rounded-[1.8rem] shadow-sm hover:shadow-2xl transition-all duration-700 cursor-pointer overflow-hidden border border-black/5 flex flex-col h-full"
                     onclick="openFullImage('{{ asset('uploads/gallery/'.$g->file) }}', '{{ addslashes($g->title) }}', '{{ addslashes($g->description) }}')">

                    <!-- Image Container with Aspect Ratio Variety -->
                    <div class="flex-1 min-h-0 relative overflow-hidden rounded-[1.2rem] bg-gray-50">
                        <img src="{{ asset('uploads/gallery/'.$g->file) }}" alt="{{ $g->title }}"
                             class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">

                        <!-- Minimal Overlay -->
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center">
                            <div class="w-12 h-12 rounded-full bg-white/10 backdrop-blur-md flex items-center justify-center text-white border border-white/20 transform scale-50 group-hover:scale-100 transition-transform duration-500">
                                <i data-lucide="maximize" class="w-5 h-5"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Label Below -->
                    <div class="mt-4 px-1.5 flex justify-between items-center shrink-0">
                        <div>
                            <h3 class="text-sm font-bold text-navy-dark italic leading-tight">{{ $g->title }}</h3>
                            <span class="text-[8px] font-black uppercase tracking-widest text-amber-700/50">Momen Terpilih</span>
                        </div>
                        <div class="w-6 h-px bg-black/10"></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- SECTION 3: EMPTY STATE -->
    @if($galleries->isEmpty())
        <div class="py-40 text-center opacity-20 reveal-up">
            <i data-lucide="camera-off" class="w-20 h-20 mx-auto mb-6"></i>
            <p class="text-2xl font-bold italic">Belum ada memori yang tertangkap.</p>
        </div>
    @endif

</div>

<!-- PREMIUM LIGHTBOX VIEWER -->
<div id="siluaLightbox" class="fixed inset-0 z-[10005] bg-white opacity-0 invisible transition-all duration-700 flex items-center justify-center p-8 md:p-20" onclick="closeLightbox()">

    <!-- Close Button -->
    <button class="absolute top-10 right-10 w-16 h-16 rounded-full bg-black/5 text-black flex items-center justify-center hover:bg-black hover:text-white transition-all duration-300 z-[10010]">
        <i data-lucide="x" class="w-6 h-6"></i>
    </button>

    <div class="max-w-7xl w-full grid grid-cols-1 lg:grid-cols-12 gap-16 items-center" onclick="event.stopPropagation()">
        <!-- Image Container -->
        <div class="lg:col-span-8 relative reveal-up">
            <div class="bg-gray-100 rounded-[3rem] overflow-hidden shadow-2xl border-[15px] border-[#F5F5F0]">
                <img id="fullImage" src="" class="w-full h-auto max-h-[75vh] object-contain mx-auto">
            </div>
        </div>

        <!-- Info Sidebar -->
        <div class="lg:col-span-4 space-y-10 reveal-right">
            <div>
                <span class="micro-label !text-amber-700 mb-6 block">Visual Index #{{ date('Y') }}</span>
                <h3 id="lightboxTitle" class="text-5xl md:text-6xl font-black italic text-navy-dark leading-tight" style="font-family: 'Playfair Display', serif;"></h3>
            </div>
            <div class="w-20 h-1 bg-amber-700"></div>
            <p id="lightboxDesc" class="text-xl text-gray-400 leading-relaxed italic"></p>

            <div class="pt-10 flex gap-6">
                <button onclick="closeLightbox()" class="px-10 py-5 bg-black text-white rounded-full font-black uppercase tracking-widest text-[10px] hover:bg-amber-700 transition-all shadow-xl">Kembali Ke Galeri</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.reveal-up, .reveal-right, .reveal-left').forEach(el => observer.observe(el));

        if(typeof lucide !== 'undefined') lucide.createIcons();
    });

    function openFullImage(src, title, desc) {
        const lightbox = document.getElementById('siluaLightbox');
        document.getElementById('fullImage').src = src;
        document.getElementById('lightboxTitle').innerText = title;
        document.getElementById('lightboxDesc').innerText = desc || "Keindahan dan keaslian cita rasa Silua Toba tertangkap dalam setiap bidikan visual ini.";

        lightbox.classList.add('active');
        document.body.style.overflow = 'hidden';

        // Re-trigger animation inside lightbox
        const info = lightbox.querySelector('.reveal-right');
        const img = lightbox.querySelector('.reveal-up');
        info.classList.remove('show');
        img.classList.remove('show');
        setTimeout(() => {
            info.classList.add('show');
            img.classList.add('show');
        }, 100);
    }

    function closeLightbox() {
        const lightbox = document.getElementById('siluaLightbox');
        lightbox.classList.remove('active');
        document.body.style.overflow = 'auto';
    }
</script>

<style>
    .micro-label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.4em; color: #B45309; }

    .reveal-up { opacity: 0; transform: translateY(50px); transition: all 1.2s cubic-bezier(0.16, 1, 0.3, 1); }
    .reveal-right { opacity: 0; transform: translateX(50px); transition: all 1.2s cubic-bezier(0.16, 1, 0.3, 1); }
    .reveal-left { opacity: 0; transform: translateX(-50px); transition: all 1.2s cubic-bezier(0.16, 1, 0.3, 1); }

    .reveal-up.show, .reveal-right.show, .reveal-left.show { opacity: 1; transform: translate(0, 0); }

    #siluaLightbox {
        z-index: 10005;
        visibility: hidden;
        pointer-events: none;
    }
    #siluaLightbox.active {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
    }
</style>
@endsection
