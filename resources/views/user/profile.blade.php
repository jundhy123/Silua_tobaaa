@extends('layouts.user')

@section('title', 'Company Profile - Silua Toba Heritage')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<div class="bg-[#FDFDFB] min-h-screen pt-28 pb-20 overflow-hidden">

    <!-- ==========================================================================
         SECTION 1: THE IDENTITY (EDITORIAL HEADER)
         ========================================================================== -->
    <header class="max-w-7xl mx-auto px-8 mb-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-end">
            <div class="lg:col-span-8 reveal-up">
                <h1 class="text-6xl md:text-8xl font-black italic leading-[0.8] mb-0 text-gray-900" style="font-family: 'Playfair Display', serif;">
                    Pilar <br> <i>Kejujuran</i> Rasa
                </h1>
            </div>
            <div class="lg:col-span-4 text-right reveal-up" style="transition-delay: 200ms">
                <div class="flex flex-col items-end">
                    <p class="text-lg text-gray-400 italic leading-relaxed max-w-xs ml-auto">
                        "Dedikasi kami adalah menghidupkan kembali warisan bumbu Toba dalam standar kualitas modern."
                    </p>
                    <div class="w-16 h-1 bg-amber-700 mt-6"></div>
                </div>
            </div>
        </div>
    </header>

    <!-- ==========================================================================
         SECTION 2: CHRONICLE (HISTORY SPLIT)
         ========================================================================== -->
    <section class="py-24 bg-white border-y border-black/5">
        <div class="max-w-7xl mx-auto px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                <div class="lg:col-span-5 relative reveal-left">
                    <div class="aspect-[4/5] rounded-[3rem] overflow-hidden shadow-xl relative z-10 border-[10px] border-gray-50">
                        <img src="{{ asset('images/foto2.jpeg') }}" alt="Silua Toba History" class="w-full h-full object-cover">
                    </div>
                    <div class="absolute -top-6 -left-6 w-48 h-48 bg-amber-700/5 rounded-full blur-2xl"></div>
                    <div class="absolute -bottom-6 -right-6 w-32 h-32 border border-amber-700/10 rounded-full"></div>
                </div>

                <div class="lg:col-span-7 space-y-8 reveal-right">
                    <div>
                        <h2 class="text-4xl md:text-6xl font-black italic leading-tight text-gray-900" style="font-family: 'Playfair Display', serif;">
                            Dimulai Dari <br> <span class="text-amber-700">Resep Keluarga</span>
                        </h2>
                        <div class="w-24 h-px bg-amber-700/30 mt-4"></div>
                    </div>

                    <div class="text-lg text-gray-500 leading-relaxed italic space-y-4">
                        {!! nl2br(e($info->history_text ?? 'Silua Toba lahir sebagai wujud kecintaan kami terhadap kekayaan kuliner Danau Toba. Berawal dari resep rumahan yang dijaga selama tiga generasi, kini kami bertumbuh menjadi jembatan rasa bagi siapapun yang merindukan cita rasa autentik tanah Batak.')) !!}
                    </div>

                    <div class="flex gap-8 pt-6 border-t border-black/5">
                        <div class="flex items-center gap-4">
                            <span class="text-3xl font-black italic text-gray-900">1k+</span>
                            <span class="text-[8px] font-bold uppercase tracking-widest text-gray-400 leading-none">Happy<br>Patrons</span>
                        </div>
                        <div class="w-px h-10 bg-black/5"></div>
                        <div class="flex items-center gap-4">
                            <span class="text-3xl font-black italic text-gray-900">100%</span>
                            <span class="text-[8px] font-bold uppercase tracking-widest text-gray-400 leading-none">Authentic<br>Toba</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================================================
         SECTION 3: MANIFESTO (VISION & MISSION)
         ========================================================================== -->
    <section class="py-28 bg-[#0c0c0b] text-white relative overflow-hidden">
        <!-- Ambient Glows -->
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-amber-700/10 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-orange-800/10 rounded-full blur-[120px] pointer-events-none"></div>
        
        <div class="max-w-7xl mx-auto px-8 relative z-10">
            <div class="mb-20 text-center reveal-up">
                <span class="micro-label !text-amber-500 mb-3 block">Purpose & Narrative</span>
                <h2 class="text-4xl md:text-6xl font-black italic text-white" style="font-family: 'Playfair Display', serif;">Visi & <i>Misi</i> Kami</h2>
                <div class="w-20 h-0.5 bg-amber-600 mx-auto mt-6"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                <!-- Visi Card -->
                <div class="relative bg-gradient-to-b from-white/[0.04] to-transparent backdrop-blur-xl border border-white/10 rounded-[3rem] p-12 md:p-16 transition-all duration-500 hover:border-amber-500/30 hover:shadow-2xl hover:shadow-amber-500/5 hover:-translate-y-2 group overflow-hidden reveal-left">
                    <!-- Subtle big number overlay -->
                    <div class="absolute -right-6 -bottom-10 text-[12rem] font-bold text-white/[0.01] select-none pointer-events-none italic font-serif group-hover:text-amber-500/[0.02] transition-all duration-700">01</div>
                    <div class="absolute right-12 top-12 text-white/5 text-8xl font-serif select-none pointer-events-none">“</div>
                    
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-500 text-[10px] font-bold uppercase tracking-wider mb-8 w-fit">
                        <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                        Vision
                    </div>
                    
                    <span class="text-amber-500 text-5xl font-black italic block mb-4" style="font-family: 'Playfair Display', serif;">01.</span>
                    <h3 class="text-3xl font-bold tracking-tight text-white mb-6">Visi Utama</h3>
                    <p class="text-lg md:text-xl text-gray-300 italic font-light leading-relaxed pl-6 border-l-2 border-amber-500/40">
                        "{{ $info->vision ?? 'Menjadi standar keagungan rasa yang membawa nama Danau Toba ke puncak dunia kuliner internasional.' }}"
                    </p>
                </div>
                
                <!-- Misi Card -->
                <div class="relative bg-gradient-to-b from-white/[0.04] to-transparent backdrop-blur-xl border border-white/10 rounded-[3rem] p-12 md:p-16 transition-all duration-500 hover:border-orange-500/30 hover:shadow-2xl hover:shadow-orange-500/5 hover:-translate-y-2 group overflow-hidden reveal-right">
                    <!-- Subtle big number overlay -->
                    <div class="absolute -right-6 -bottom-10 text-[12rem] font-bold text-white/[0.01] select-none pointer-events-none italic font-serif group-hover:text-orange-500/[0.02] transition-all duration-700">02</div>
                    <div class="absolute right-12 top-12 text-white/5 text-8xl font-serif select-none pointer-events-none">“</div>
                    
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-orange-500/10 border border-orange-500/20 text-orange-500 text-[10px] font-bold uppercase tracking-wider mb-8 w-fit">
                        <i data-lucide="compass" class="w-3.5 h-3.5"></i>
                        Mission
                    </div>
                    
                    <span class="text-amber-500 text-5xl font-black italic block mb-4" style="font-family: 'Playfair Display', serif;">02.</span>
                    <h3 class="text-3xl font-bold tracking-tight text-white mb-6">Misi Kami</h3>
                    <p class="text-lg md:text-xl text-gray-300 italic font-light leading-relaxed pl-6 border-l-2 border-orange-500/40">
                        "{{ $info->mission ?? 'Melindungi kemurnian bahan lokal dan memberdayakan komunitas pengrajin pangan tradisional secara berkelanjutan.' }}"
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================================================
         SECTION 4: THE CRAFTSMEN (TEAM)
         ========================================================================== -->
    <section class="py-24 bg-[#FDFDFB]">
        <div class="max-w-7xl mx-auto px-8">
            <div class="text-center mb-16 reveal-up">
                <span class="micro-label mb-3 block">Our Craftsmen</span>
                <h2 class="text-5xl md:text-7xl font-black italic text-gray-900" style="font-family: 'Playfair Display', serif;">Jiwa Di Balik <i>Silua</i></h2>
                <div class="w-16 h-px bg-amber-700/40 mx-auto mt-6"></div>
            </div>

            <div class="flex flex-wrap justify-center gap-10">
                @forelse($teams as $key => $t)
                <div class="w-full sm:w-64 group reveal-up" style="transition-delay: {{ ($key % 4) * 100 }}ms">
                    <div class="aspect-[3/4] rounded-[2.5rem] overflow-hidden mb-6 relative shadow-md">
                        <img src="{{ asset('uploads/teams/'.$t->photo) }}" alt="{{ $t->name }}"
                             class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end p-6 text-center">
                            <p class="text-white text-[9px] italic uppercase tracking-widest font-bold w-full">Dedicated Artisan</p>
                        </div>
                    </div>
                    <div class="text-center">
                        <h4 class="text-xl font-bold text-gray-900 italic" style="font-family: 'Playfair Display', serif;">{{ $t->name }}</h4>
                        <p class="text-[8px] font-black uppercase tracking-[0.2em] text-amber-700 mt-1">{{ $t->position }}</p>
                    </div>
                </div>
                @empty
                    <div class="w-full py-10 text-center opacity-20 italic text-gray-400 text-sm">Data pengrajin belum tersedia.</div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ==========================================================================
         SECTION 5: CORPORATE DATA (MODERN INDEX)
         ========================================================================== -->
    <section class="py-24 bg-[#F5F5F0] border-y border-black/5">
        <div class="max-w-4xl mx-auto px-8 reveal-up">
            <div class="bg-white rounded-[3rem] p-10 md:p-20 shadow-xl relative overflow-hidden border border-black/5">
                <div class="absolute top-0 left-0 w-24 h-24 bg-amber-700/5 rounded-br-[100%]"></div>

                <div class="mb-12 text-center">
                    <span class="micro-label mb-2 block">Official Index</span>
                    <h2 class="text-4xl md:text-5xl font-black italic text-gray-900" style="font-family: 'Playfair Display', serif;">Legalitas <i>Usaha</i></h2>
                    <div class="w-12 h-px bg-amber-700/30 mx-auto mt-6"></div>
                </div>

                <div class="space-y-2">
                    <div class="flex flex-col md:flex-row justify-between items-center py-6 border-b border-black/5 group hover:px-4 transition-all duration-500">
                        <span class="text-[9px] font-black uppercase tracking-widest text-gray-400">Nama Resmi UMKM</span>
                        <span class="text-lg font-bold italic text-gray-900">{{ $info->company_name ?? 'Silua Toba Heritage' }}</span>
                    </div>
                    <div class="flex flex-col md:flex-row justify-between items-center py-6 border-b border-black/5 group hover:px-4 transition-all duration-500">
                        <span class="text-[9px] font-black uppercase tracking-widest text-gray-400">Tahun Pendirian</span>
                        <span class="text-lg font-bold italic text-gray-900">{{ $info->established_year ?? '2016' }}</span>
                    </div>
                    <div class="flex flex-col md:flex-row justify-between items-center py-6 border-b border-black/5 group hover:px-4 transition-all duration-500">
                        <span class="text-[9px] font-black uppercase tracking-widest text-gray-400">Izin Usaha (P-IRT)</span>
                        <span class="text-lg font-bold italic text-gray-900">{{ $info->business_permit ?? 'No. 2024.01.XXX' }}</span>
                    </div>
                    <div class="flex flex-col md:flex-row justify-between items-center py-6 group hover:px-4 transition-all duration-500">
                        <span class="text-[9px] font-black uppercase tracking-widest text-gray-400">Sertifikasi Halal</span>
                        <span class="text-lg font-bold italic text-gray-900">{{ $info->certification ?? 'Certified ID-00XXX' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================================================
         SECTION 6: THE SANCTUARY (MAPS)
         ========================================================================== -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                <div class="lg:col-span-4 reveal-left">
                    <div class="mb-8">
                        <span class="micro-label mb-6 block text-amber-700">Our Sanctuary</span>
                        <h2 class="text-5xl md:text-7xl font-black italic leading-none mb-6 text-gray-900" style="font-family: 'Playfair Display', serif;">Kunjungi <i>Kami</i></h2>
                        <div class="w-16 h-1 bg-amber-700 mb-8"></div>
                        <p class="text-lg text-gray-400 italic leading-relaxed mb-8">"Setiap pintu kami selalu terbuka bagi para penikmat rasa sejati. Mari temukan kehangatan Toba secara langsung."</p>
                    </div>
                    <a href="https://maps.google.com" target="_blank" class="px-8 py-4 bg-black text-white rounded-full font-black uppercase tracking-[0.4em] text-[9px] hover:bg-amber-700 transition-all shadow-lg inline-block">Dapatkan Arah</a>
                </div>

                <div class="lg:col-span-8 reveal-right">
                    <div class="h-[500px] rounded-[3rem] overflow-hidden shadow-xl border-[12px] border-[#F5F5F0]">
                        @php
                            $map = $info->map_embed ?? '';
                            $map = str_replace('www.google.com/maps', 'maps.google.com/maps', $map);
                            if ($map && !str_contains($map, 'output=embed')) {
                                $map .= (str_contains($map, '?') ? '&' : '?') . 'output=embed';
                            }
                        @endphp
                        <iframe src="{{ $map }}" width="100%" height="100%" style="border:0;" allowfullscreen loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const observerOptions = { threshold: 0.1 };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.reveal-up, .reveal-left, .reveal-right').forEach(el => observer.observe(el));
        if(typeof lucide !== 'undefined') lucide.createIcons();
    });
</script>

<style>
    .micro-label { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5em; color: #B45309; }
    .reveal-left { opacity: 0; transform: translateX(-40px); transition: all 1.2s cubic-bezier(0.16, 1, 0.3, 1); }
    .reveal-right { opacity: 0; transform: translateX(40px); transition: all 1.2s cubic-bezier(0.16, 1, 0.3, 1); }
    .reveal-up { opacity: 0; transform: translateY(40px); transition: all 1.2s cubic-bezier(0.16, 1, 0.3, 1); }
    .reveal-left.show, .reveal-right.show, .reveal-up.show { opacity: 1; transform: translate(0, 0); }
</style>
@endsection
