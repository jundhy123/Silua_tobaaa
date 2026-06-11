@extends('layouts.user')

@section('title', 'Kisah Pelanggan - Silua Toba Wall of Love')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<div class="bg-[#FDFDFB] min-h-screen pt-32 pb-40 overflow-hidden">

    <!-- SECTION 1: DRAMATIC HEADER -->
    <header class="max-w-7xl mx-auto px-8 mb-32">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-end">
            <div class="lg:col-span-8 reveal-up">
                <span class="micro-label mb-6 block">Cerita Dari Pengunjung</span>
                <h1 class="text-7xl md:text-[10rem] font-black italic leading-[0.8] mb-0" style="font-family: 'Playfair Display', serif;">
                    Kesan Dan Pesan <i>dari Mereka</i>
                </h1>
            </div>
            <div class="lg:col-span-4 text-right reveal-up" style="transition-delay: 200ms">
                <p class="text-xl text-gray-400 italic leading-relaxed max-w-xs ml-auto">
                    "Kepuasan Anda adalah melodi terindah bagi kami. Terima kasih telah menjadi bagian dari perjalanan rasa ini."
                </p>
                <div class="w-20 h-1 bg-amber-700 ml-auto mt-10"></div>
            </div>
        </div>
    </header>

    <!-- SECTION 2: CURATED MASONRY TESTIMONIALS -->
    <section class="max-w-7xl mx-auto px-8">
        <div class="columns-1 md:columns-2 lg:columns-3 gap-12 space-y-12">
            @foreach($testimonials as $key => $t)
            <div class="break-inside-avoid reveal-up" style="transition-delay: {{ ($key % 3) * 100 }}ms">
                <div class="group relative bg-white p-12 rounded-[3rem] shadow-sm hover:shadow-2xl transition-all duration-700 border border-black/5">

                    <!-- Top Quote Decoration -->
                    <div class="absolute top-10 right-12 text-6xl font-black italic text-amber-700/5 select-none">“</div>

                    <!-- Content -->
                    <div class="relative z-10">
                        <p class="text-xl text-navy-dark leading-relaxed italic mb-12">
                            "{!! nl2br(e($t->message)) !!}"
                        </p>

                        <div class="flex items-center justify-between pt-8 border-t border-black/5">
                            <div class="flex items-center gap-5">
                                <div class="w-14 h-14 rounded-full overflow-hidden border-2 border-amber-700/10">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($t->user->name) }}&background=B45309&color=fff" alt="User" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h4 class="font-bold text-navy-dark text-sm">{{ $t->user->name }}</h4>
                                    <span class="text-[9px] uppercase tracking-[0.2em] font-black text-amber-700/40">Verified Patron</span>
                                </div>
                            </div>

                            @auth
                                @if($t->user_id === Auth::id())
                                <div class="flex gap-2">
                                    <button onclick="toggleEdit({{ $t->id }})" class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-black hover:text-white transition-all">
                                        <i data-lucide="edit-3" class="w-3 h-3"></i>
                                    </button>
                                    <form action="{{ route('testimoni.destroy', $t->id) }}" method="POST" class="inline" onsubmit="return confirmDelete(this, 'Hapus Testimoni?', 'Ulasan Anda akan dihapus secara permanen.')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-red-500 hover:text-white transition-all">
                                            <i data-lucide="trash-2" class="w-3 h-3"></i>
                                        </button>
                                    </form>
                                </div>
                                @endif
                            @endauth
                        </div>
                    </div>

                    <!-- Hidden Edit Form (Premium Slide) -->
                    @auth
                        @if($t->user_id === Auth::id())
                        <div id="editTestiForm{{ $t->id }}" class="hidden mt-8 pt-8 border-t border-dashed border-gray-200 animate-fade-in">
                            <form action="{{ route('testimoni.update', $t->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <textarea name="message" class="w-full p-6 rounded-2xl bg-gray-50 border-none outline-none text-sm italic mb-4 focus:ring-1 focus:ring-amber-700/20" rows="4">{{ $t->message }}</textarea>
                                <div class="flex justify-end gap-4">
                                    <button type="button" onclick="toggleEdit({{ $t->id }})" class="text-[10px] font-bold uppercase tracking-widest text-gray-400 hover:text-black">Batal</button>
                                    <button type="submit" class="px-8 py-3 bg-amber-700 text-white rounded-full text-[10px] font-bold uppercase tracking-widest hover:bg-black transition-all shadow-lg">Perbarui Kisah</button>
                                </div>
                            </form>
                        </div>
                        @endif
                    @endauth
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- SECTION 3: PREMIUM CTA (WRITE YOUR OWN) -->
    <section class="max-w-4xl mx-auto px-8 mt-40">
        <div class="relative bg-[#141414] rounded-[5rem] p-16 md:p-24 overflow-hidden text-center reveal-up shadow-2xl">
            <!-- Decorative Glows -->
            <div class="absolute -top-20 -right-20 w-80 h-80 bg-amber-700/10 rounded-full blur-[100px]"></div>
            <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-amber-700/5 rounded-full blur-[100px]"></div>

            <div class="relative z-10">
                <span class="micro-label !text-amber-500 mb-8 block">Share Your Experience</span>
                <h2 class="text-5xl md:text-7xl font-black italic text-white mb-10" style="font-family: 'Playfair Display', serif;">Tuliskan <i>Cerita</i> Anda</h2>
                <p class="text-xl text-white/30 mb-16 max-w-lg mx-auto leading-relaxed italic">"Punya kenangan manis bersama produk kami? Ceritakan bagaimana Silua Toba menjadi bagian dari hari Anda."</p>

                @auth
                    @if(!$myTestimony)
                    <form action="{{ route('testimoni.store') }}" method="POST" class="space-y-8">
                        @csrf
                        <div class="relative group">
                            <textarea name="message" placeholder="Tuliskan pengalaman Anda di sini..." required
                                      class="w-full p-10 rounded-[3rem] bg-white/5 border border-white/10 text-white outline-none focus:border-amber-700/50 focus:bg-white/10 transition-all italic text-xl min-h-[200px]" rows="4"></textarea>
                            <div class="absolute bottom-6 right-10 text-white/10 group-focus-within:text-amber-700/20 transition-colors">
                                <i data-lucide="pen-tool" class="w-8 h-8"></i>
                            </div>
                        </div>
                        <button type="submit" class="px-16 py-7 bg-amber-700 text-white rounded-full font-black uppercase tracking-[0.4em] text-xs hover:bg-white hover:text-black transition-all duration-700 shadow-2xl">Kirimkan Kisah Saya</button>
                    </form>
                    @else
                    <div class="p-16 border-2 border-dashed border-white/10 rounded-[4rem] bg-white/[0.02]">
                        <div class="w-20 h-20 bg-amber-700/20 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-8">
                            <i data-lucide="check-circle" class="w-10 h-10"></i>
                        </div>
                        <h3 class="text-3xl font-bold text-white mb-4 italic">Kisah Anda Telah Kami Simpan</h3>
                        <p class="text-white/30 text-lg italic">Terima kasih telah berbagi cinta. Testimoni Anda sangat berarti bagi kami.</p>
                    </div>
                    @endif
                @else
                    <div class="flex flex-col items-center gap-10">
                        <a href="{{ route('login') }}" class="px-16 py-7 bg-white text-black rounded-full font-black uppercase tracking-[0.4em] text-xs hover:bg-amber-700 hover:text-white transition-all duration-700 shadow-2xl">Masuk Untuk Berbagi</a>
                        <p class="text-white/20 text-[10px] uppercase tracking-[0.5em] font-black">Join our community of authentic tastes</p>
                    </div>
                @endauth
            </div>
        </div>
    </section>

</div>

<script>
    function toggleEdit(id) {
        const form = document.getElementById('editTestiForm' + id);
        form.classList.toggle('hidden');
    }

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

        document.querySelectorAll('.reveal-up').forEach(el => observer.observe(el));
        if(typeof lucide !== 'undefined') lucide.createIcons();
    });
</script>

<style>
    .micro-label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.4em; color: #B45309; }
    .reveal-up { opacity: 0; transform: translateY(50px); transition: all 1.2s cubic-bezier(0.16, 1, 0.3, 1); }
    .reveal-up.show { opacity: 1; transform: translate(0, 0); }

    .animate-fade-in {
        animation: fadeIn 0.5s ease forwards;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection
