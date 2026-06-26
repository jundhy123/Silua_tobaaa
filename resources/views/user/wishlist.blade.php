@extends('layouts.user')

@section('title', 'Wishlist Saya - Silua Toba')

@section('content')
<!-- Import Font Premium -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/wishlist-user.css') }}">

<div class="wishlist-page-wrapper">

    <!-- HEADER SECTION -->
    <header class="wishlist-header max-w-7xl mx-auto px-6 reveal text-left py-20">
        <span class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-300 mb-4 block">Koleksi Favorit</span>
        <h1 class="text-5xl md:text-7xl font-black italic text-[#1a1a3a] leading-tight mb-8" style="font-family: 'Playfair Display', serif;">Wishlist <i>Saya</i></h1>
        <div class="w-24 h-1 bg-[#FF5722]"></div>
    </header>

    <!-- LIST ITEMS -->
    <section class="max-w-7xl mx-auto px-6 pb-20">
        <div class="wishlist-grid">
            @forelse($wishlists as $key => $w)
            <div class="wish-card-premium reveal-up" style="--order: {{ $key }}"
                 onclick='openOrderModal({{ $w->product->id }}, "{{ addslashes($w->product->name) }}", {{ $w->product->price }}, "{{ asset("uploads/products/".$w->product->image) }}", "{{ addslashes($w->product->description) }}", @json($w->product->reviews))'>

                <!-- Tombol Hapus (Heart Icon) -->
                <form action="{{ route('wishlist.toggle') }}" method="POST" onclick="event.stopPropagation()">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $w->product->id }}">
                    <button type="submit" class="btn-wish-toggle" title="Hapus dari Wishlist">
                        <i data-lucide="heart"></i>
                    </button>
                </form>

                <div class="wish-img-wrapper">
                    <img src="{{ asset('uploads/products/' . $w->product->image) }}" alt="{{ $w->product->name }}">
                </div>

                <div class="wish-details">
                    <h3 class="product-name">{{ $w->product->name }}</h3>
                    <span class="product-price">Rp {{ number_format($w->product->price, 0, ',', '.') }}</span>
                </div>
            </div>
            @empty
            <!-- Tampilan Kosong -->
            <div class="empty-wishlist-box col-span-full reveal">
                <div class="empty-icon">
                    <i data-lucide="heart-off"></i>
                </div>
                <h2 class="text-3xl font-black italic mb-4" style="font-family: 'Playfair Display', serif;">Belum Ada Favorit</h2>
                <p class="text-gray-400 italic mb-8">Jelajahi produk kami dan temukan rasa yang Anda cintai.</p>
                <a href="{{ route('user.products') }}" class="btn-go-shopping">Cari Produk Sekarang</a>
            </div>
            @endforelse
        </div>
    </section>

</div>

@include('components.modal-detail-produk')

<script>
    document.addEventListener("DOMContentLoaded", function() {
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
</script>
@endsection
