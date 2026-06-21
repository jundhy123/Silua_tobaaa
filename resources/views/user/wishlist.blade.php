@extends('layouts.user')

@section('title', 'Wishlist Saya - Silua Toba')

@section('content')
<!-- Import Font Premium -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/wishlist-user.css') }}">

<div class="wishlist-page-wrapper">

    <!-- HEADER SECTION -->
    <header class="wishlist-header container reveal text-center py-20">
        <span class="micro-label mb-6 block">Koleksi Anda</span>
        <h1 class="text-5xl md:text-7xl font-black italic text-navy-dark leading-tight mb-8" style="font-family: 'Playfair Display', serif;">Wishlist <i>Saya</i></h1>
        <p class="text-xl text-gray-500 leading-relaxed italic max-w-2xl mx-auto">
            Daftar rasa favorit yang telah Anda simpan. Siap untuk dinikmati kapan saja.
        </p>
        <div class="w-24 h-1 bg-amber-700 mx-auto mt-12"></div>
    </header>

    <!-- LIST ITEMS -->
    <section class="container pb-20">
        <div class="wishlist-grid max-w-7xl mx-auto">
            @forelse($wishlists as $key => $w)
            <div class="wish-card-premium reveal-up" style="--order: {{ $key }}"
                 onclick='openOrderModal({{ $w->product->id }}, "{{ addslashes($w->product->name) }}", {{ $w->product->price }}, "{{ asset('uploads/products/'.$w->product->image) }}", "{{ addslashes($w->product->description) }}", @json($w->product->reviews))'>

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
            <!-- Tampilan Kosong yang Manis -->
            <div class="empty-wishlist-box col-span-full reveal">
                <div class="empty-icon">
                    <i data-lucide="heart-off"></i>
                </div>
                <h2>Belum Ada Favorit</h2>
                <p>Jelajahi produk kami dan temukan rasa yang Anda cintai.</p>
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
