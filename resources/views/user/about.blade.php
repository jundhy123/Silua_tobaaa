@extends('layouts.user')

@section('title', 'Kisah Kami - Warisan Silua Toba')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

<div class="bg-[#FDFDFB] min-h-screen pt-32 pb-20 overflow-hidden">

    <!-- SECTION 1: PEMBUKA (HERO EDITORIAL) -->
    @if($abouts->count() > 0)
    @php $first = $abouts->first(); @endphp
    <section class="max-w-7xl mx-auto px-8 mb-24">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <!-- Sisi Teks -->
            <div class="lg:col-span-7 reveal-left">
                <span class="micro-label mb-8 block">Warisan Rasa</span>
                <h1 class="text-5xl md:text-7xl font-black italic leading-tight mb-12" style="font-family: 'Playfair Display', serif;">
                    {{ $first->title }} <br>
                    <span class="text-amber-700 ml-4 md:ml-12">{{ $first->subtitle }}</span>
                </h1>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
                    <div class="md:col-span-2 pt-2">
                        <div class="w-12 h-1 bg-amber-700"></div>
                    </div>
                    <div class="md:col-span-10 text-xl text-gray-500 leading-relaxed italic">
                        "{!! nl2br(e($first->description)) !!}"
                    </div>
                </div>
            </div>

            <!-- Image Side (Asymmetric) -->
            <div class="lg:col-span-5 relative reveal-right">
                <div class="relative z-10 aspect-[3/4] rounded-[5rem] overflow-hidden shadow-2xl border-[15px] border-white">
                    <img src="{{ asset('uploads/about/' . $first->image) }}" alt="{{ $first->title }}" class="w-full h-full object-cover">
                </div>
                <!-- Decorative Elements -->
                <div class="absolute -top-12 -right-12 w-64 h-64 bg-amber-700/5 rounded-full blur-3xl -z-10"></div>
                @if($first->years_experience)
                <div class="absolute -bottom-8 -left-8 z-20 bg-black text-white p-10 rounded-[3rem] shadow-2xl transform -rotate-3 hover:rotate-0 transition-transform duration-500">
                    <span class="block text-5xl font-black italic text-amber-500">{{ $first->years_experience }}+</span>
                    <span class="block text-[10px] uppercase tracking-[0.3em] font-bold opacity-50 mt-2">Tahun <br> Dedikasi</span>
                </div>
                @endif
            </div>
        </div>
    </section>
    @endif

    <!-- SECTION 2: FILOSOFI KAMI -->
    <section class="py-24 bg-[#141414] text-white relative overflow-hidden">
        <!-- Floating Text Decoration -->
        <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center opacity-[0.03] pointer-events-none select-none">
            <h2 class="text-[25vw] font-black italic leading-none">WARISAN</h2>
        </div>

        <div class="max-w-7xl mx-auto px-8 relative z-10">
            <div class="text-center mb-24 reveal-up">
                <span class="micro-label !text-amber-500 mb-6 block">Prinsip Kami</span>
                <h2 class="text-5xl md:text-7xl font-black italic" style="font-family: 'Playfair Display', serif;">Filosofi di Balik <i>Rasa</i></h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-16">
                <div class="space-y-8 reveal-up" style="transition-delay: 100ms">
                    <div class="w-20 h-20 bg-white/5 rounded-[2rem] flex items-center justify-center text-amber-500 border border-white/10">
                        <i data-lucide="leaf" class="w-10 h-10"></i>
                    </div>
                    <h3 class="text-3xl font-bold italic">Keaslian Bahan</h3>
                    <p class="text-white/40 leading-relaxed italic text-lg">"Hanya menggunakan rempah terbaik langsung dari tanah Toba untuk menjaga kemurnian rasa."</p>
                </div>
                <div class="space-y-8 reveal-up" style="transition-delay: 200ms">
                    <div class="w-20 h-20 bg-white/5 rounded-[2rem] flex items-center justify-center text-amber-500 border border-white/10">
                        <i data-lucide="heart" class="w-10 h-10"></i>
                    </div>
                    <h3 class="text-3xl font-bold italic">Cinta Keluarga</h3>
                    <p class="text-white/40 leading-relaxed italic text-lg">"Setiap hidangan dimasak dengan kehangatan dan dedikasi layaknya masakan di rumah sendiri."</p>
                </div>
                <div class="space-y-8 reveal-up" style="transition-delay: 300ms">
                    <div class="w-20 h-20 bg-white/5 rounded-[2rem] flex items-center justify-center text-amber-500 border border-white/10">
                        <i data-lucide="shield-check" class="w-10 h-10"></i>
                    </div>
                    <h3 class="text-3xl font-bold italic">Kualitas Premium</h3>
                    <p class="text-white/40 leading-relaxed italic text-lg">"Tanpa pengawet, tanpa kompromi. Hanya kualitas terbaik yang sampai ke meja Anda."</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= SECTION 3: THE JOURNEY (ZIGZAG) ================= --}}
    @foreach($abouts->skip(1) as $key => $a)
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                <!-- Image with Decorative Floating Elements -->
                <div class="relative reveal-up {{ $key % 2 != 0 ? 'lg:order-2' : '' }}">
                    <div class="aspect-square rounded-[4rem] overflow-hidden shadow-2xl relative z-10">
                        <img src="{{ asset('uploads/about/' . $a->image) }}" alt="{{ $a->title }}" class="w-full h-full object-cover transition-all duration-700">
                    </div>
                    <div class="absolute -top-10 {{ $key % 2 == 0 ? '-left-10' : '-right-10' }} w-40 h-40 bg-amber-700/10 rounded-full blur-3xl"></div>
                    <div class="absolute -bottom-10 {{ $key % 2 == 0 ? '-right-10' : '-left-10' }} w-32 h-32 bg-amber-700/5 rounded-full border border-amber-700/20"></div>
                </div>

                <!-- Text Content -->
                <div class="space-y-10 reveal-up {{ $key % 2 != 0 ? 'lg:order-1' : '' }}">
                    <div>
                        <span class="micro-label block mb-6">Bab {{ $key + 2 }}</span>
                        <h2 class="text-5xl md:text-6xl font-black italic leading-tight" style="font-family: 'Playfair Display', serif;">
                            {{ $a->title }} <br>
                            <span class="text-amber-700">{{ $a->subtitle }}</span>
                        </h2>
                    </div>

                    <div class="w-20 h-1 bg-amber-700"></div>

                    <div class="text-xl text-gray-500 leading-relaxed italic">
                        "{!! nl2br(e($a->description)) !!}"
                    </div>

                    <div class="pt-8">
                        <a href="{{ route('user.products') }}" class="group inline-flex items-center gap-6">
                            <span class="w-16 h-16 rounded-full border border-black/10 flex items-center justify-center group-hover:bg-black group-hover:text-white transition-all duration-500">
                                <i data-lucide="arrow-right" class="w-6 h-6"></i>
                            </span>
                            <span class="text-sm font-bold uppercase tracking-[0.3em]">Lihat Produk Kami</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endforeach

    {{-- ================= SECTION 4: INVITATION (CTA) ================= --}}
    <section class="relative py-24 bg-white">
        <div class="max-w-4xl mx-auto px-8 text-center reveal-up">
            <h2 class="text-5xl md:text-7xl font-black italic leading-tight mb-12" style="font-family: 'Playfair Display', serif;">
                Mari Jadi Bagian dari <br> <i>Cerita</i> Kami.
            </h2>
            <p class="text-xl text-gray-400 mb-16 max-w-2xl mx-auto italic leading-relaxed">
                "Nikmati kelezatan warisan Toba yang diolah dengan cinta. Setiap suapan adalah perjalanan menuju kehangatan tradisi."
            </p>
            <div class="flex flex-col sm:flex-row gap-8 justify-center">
                <a href="{{ route('user.products') }}" class="px-12 py-6 bg-black text-white rounded-full font-bold uppercase tracking-[0.4em] text-xs hover:bg-amber-700 transition-all duration-500 shadow-xl">Belanja Sekarang</a>
                <a href="{{ route('user.gallery') }}" class="px-12 py-6 border border-black/10 rounded-full font-bold uppercase tracking-[0.4em] text-xs hover:bg-black hover:text-white transition-all duration-500">Lihat Galeri</a>
            </div>
        </div>
    </section>

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

    document.querySelectorAll('.reveal-left, .reveal-right, .reveal-up')
        .forEach(el => observer.observe(el));

    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});
</script>

<style>
    /* Ensure styles match global.css variables or fallbacks */
    .micro-label {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4em;
        color: #B45309; /* Amber-700 */
    }

    .reveal-left { opacity: 0; transform: translateX(-50px); transition: all 1.2s cubic-bezier(0.16, 1, 0.3, 1); }
    .reveal-right { opacity: 0; transform: translateX(50px); transition: all 1.2s cubic-bezier(0.16, 1, 0.3, 1); }
    .reveal-up { opacity: 0; transform: translateY(50px); transition: all 1.2s cubic-bezier(0.16, 1, 0.3, 1); }

    .reveal-left.show, .reveal-right.show, .reveal-up.show {
        opacity: 1;
        transform: translate(0, 0);
    }
</style>

@endsection
