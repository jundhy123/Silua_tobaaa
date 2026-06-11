@extends('layouts.user')

@section('title', 'Katalog Produk Silua Toba - Artisanal Collection')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/produk-user.css') }}">

<div class="product-page-wrapper bg-[#F5F5F0] min-h-screen pt-32 pb-40">

    <!-- HEADER -->
    <header class="max-w-7xl mx-auto px-8 mb-24 reveal-up">
        <div class="flex flex-col md:flex-row justify-between items-end gap-10">
            <div class="max-w-2xl">
                <span class="micro-label mb-6 block">Koleksi Produk</span>
                <h1 class="text-6xl md:text-8xl font-black italic leading-none mb-8" style="font-family: 'Playfair Display', serif;">
                    Daftar <i>Produk</i> <br> Unggulan <i>Kami</i>
                </h1>
                <p class="text-xl text-gray-500 leading-relaxed italic">
                    "Kurasi menu terbaik dari tanah Toba, diolah dengan cinta dan rempah pilihan untuk pengalaman kuliner yang tak terlupakan."
                </p>
            </div>

        </div>
        <div class="w-32 h-1 bg-amber-700 mt-16"></div>
    </header>

    <!-- CATALOG GRID -->
    <section class="max-w-7xl mx-auto px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10" id="productGrid">
            @forelse ($products as $key => $p)
            <div class="group reveal-up" style="transition-delay: {{ ($key % 3) * 100 }}ms">
                <div class="relative bg-white rounded-[3rem] overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-700 border border-black/5">

                    <!-- Top Actions -->
                    <div class="absolute top-6 left-6 right-6 z-20 flex justify-between items-start opacity-0 group-hover:opacity-100 transition-all duration-500 translate-y-[-10px] group-hover:translate-y-0">
                        @if($p->reviews->count() > 5)
                            <span class="px-4 py-2 bg-amber-700 text-white text-[9px] font-black uppercase tracking-widest rounded-full shadow-lg">Terlaris</span>
                        @else
                            <span></span>
                        @endif

                        @auth
                            <form action="{{ route('wishlist.toggle') }}" method="POST" class="wishlist-form">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $p->id }}">
                                @php
                                    $isWishlisted = \App\Models\Wishlist::where('user_id', auth()->id())
                                                        ->where('product_id', $p->id)
                                                        ->exists();
                                @endphp
                                <button type="submit" class="w-10 h-10 rounded-full bg-white flex items-center justify-center shadow-lg hover:scale-110 transition-transform">
                                    <i data-lucide="heart"
                                       class="w-4 h-4 {{ $isWishlisted ? 'text-red-500' : 'text-gray-300' }}"
                                       fill="{{ $isWishlisted ? 'currentColor' : 'none' }}"></i>
                                </button>
                            </form>
                        @else
                            <a href="{{ route('user.register') }}" class="w-10 h-10 rounded-full bg-white flex items-center justify-center shadow-lg hover:scale-110 transition-transform text-gray-300">
                                <i data-lucide="heart" class="w-4 h-4"></i>
                            </a>
                        @endauth
                    </div>

                    <!-- Image Section -->
                    <div class="aspect-[4/5] overflow-hidden bg-gray-100">
                        <img src="{{ asset('uploads/products/' . $p->image) }}" alt="{{ $p->name }}"
                             class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">

                        <!-- Quick Add Overlay -->
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center">
                            <button type="button"
                                    onclick='openOrderModal({{ $p->id }}, "{{ addslashes($p->name) }}", {{ $p->price }}, "{{ asset('uploads/products/'.$p->image) }}", "{{ addslashes($p->description) }}", @json($p->reviews))'
                                    class="px-10 py-5 bg-white text-black rounded-full font-black uppercase tracking-widest text-[10px] shadow-2xl hover:bg-amber-700 hover:text-white transition-all transform translate-y-10 group-hover:translate-y-0 duration-500">
                                Detail & Pesan
                            </button>
                        </div>
                    </div>

                    <!-- Content Section -->
                    <div class="p-10">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-2xl font-bold text-navy-dark leading-tight mb-2">{{ $p->name }}</h3>
                                <div class="flex items-center gap-2">
                                    <div class="flex text-amber-500">
                                        @php $rating = $p->reviews->avg('rating') ?: 5; @endphp
                                        @for($i=1; $i<=5; $i++)
                                            <i data-lucide="star" class="w-3 h-3 {{ $i <= $rating ? 'fill-current' : '' }}"></i>
                                        @endfor
                                    </div>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">({{ $p->reviews->count() }} Ulasan)</span>
                                </div>
                            </div>
                            <span class="text-xl font-black italic text-amber-700">Rp {{ number_format($p->price, 0, ',', '.') }}</span>
                        </div>

                        <p class="text-sm text-gray-500 leading-relaxed line-clamp-2 mb-8 italic">
                            {{ $p->description }}
                        </p>

                        <div class="pt-8 border-t border-black/5 flex justify-between items-center">
                            <form action="{{ route('cart.store') }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $p->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="text-[10px] font-black uppercase tracking-[0.3em] text-navy-dark hover:text-amber-700 transition-colors flex items-center gap-3">
                                    <i data-lucide="shopping-bag" class="w-4 h-4"></i> Masukkan ke Troli
                                </button>
                            </form>
                            <button onclick='openOrderModal({{ $p->id }}, "{{ addslashes($p->name) }}", {{ $p->price }}, "{{ asset('uploads/products/'.$p->image) }}", "{{ addslashes($p->description) }}", @json($p->reviews))'
                                    class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-black hover:text-white transition-all">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-40 text-center opacity-20">
                <i data-lucide="package-open" class="w-20 h-20 mx-auto mb-6"></i>
                <p class="text-2xl font-bold italic">Belum ada produk yang dapat ditampilkan.</p>
            </div>
            @endforelse
        </div>
    </section>

    <!-- PROMO SECTION -->
    <section class="max-w-7xl mx-auto px-8 mt-32">
        <div class="bg-amber-700 rounded-[4rem] p-16 md:p-24 relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-12 reveal-up">
            <div class="absolute -top-20 -left-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-black/10 rounded-full blur-3xl"></div>

            <div class="relative z-10 max-w-xl text-center md:text-left">
                <span class="text-white/60 text-[10px] font-black uppercase tracking-[0.4em] mb-6 block">Penawaran Spesial</span>
                <h2 class="text-4xl md:text-6xl font-black italic text-white leading-tight mb-8" style="font-family: 'Playfair Display', serif;">Dapatkan <i>Potongan</i> Khusus Member</h2>
                <p class="text-white/70 text-lg leading-relaxed italic">Bergabunglah dengan program loyalitas kami dan nikmati penawaran eksklusif setiap bulannya.</p>
            </div>

            <div class="relative z-10">
                <a href="{{ route('user.register') }}" class="px-12 py-6 bg-black text-white rounded-full font-black uppercase tracking-[0.3em] text-xs hover:bg-white hover:text-black transition-all duration-500 shadow-2xl">Daftar Sekarang</a>
            </div>
        </div>
    </section>
</div>

@include('components.modal-detail-produk')

<script>
document.addEventListener("DOMContentLoaded", function() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal-up').forEach(el => observer.observe(el));
    if(typeof lucide !== 'undefined') lucide.createIcons();
});
</script>
@endsection
