@extends('layouts.user')

@section('title', 'Wishlist Saya - Silua Toba')

@section('content')
<!-- Import Font Premium -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/wishlist-user.css') }}">

<div class="wishlist-page-wrapper">

    <!-- HEADER SECTION -->
    <header class="wishlist-header container reveal">
        <span class="top-label">KOLEKSI ANDA</span>
        <h1 class="main-title">Wishlist Saya</h1>
        <p class="header-desc">
            Daftar rasa favorit yang telah Anda simpan. Siap untuk dinikmati kapan saja.
        </p>
        <div class="header-line"></div>
    </header>

    <!-- LIST ITEMS -->
    <section class="container pb-20">
        <div class="wishlist-grid">
            @forelse($wishlists as $key => $w)
            <div class="wish-card-premium reveal-up" style="--order: {{ $key }}">

                <div class="wish-card-content">
                    <!-- Area Gambar -->
                    <div class="wish-img-wrapper">
                        <img src="{{ asset('uploads/products/' . $w->product->image) }}" alt="{{ $w->product->name }}">
                        <!-- Badge Harga di Atas Gambar -->
                        <div class="price-badge">Rp {{ number_format($w->product->price, 0, ',', '.') }}</div>
                    </div>

                    <!-- Area Info -->
                    <div class="wish-details">
                        <div>
                            <span class="product-category">{{ $w->product->category ?? 'Produk Nusantara' }}</span>
                            <h3 class="product-name">{{ $w->product->name }}</h3>
                            <p class="product-short-desc">{{ Str::limit($w->product->description, 60) }}</p>
                        </div>

                        <!-- Tombol Aksi di Bagian Bawah Info -->
                        <div class="wish-actions-row">
                            <!-- Tombol Hapus (Badge Merah Muda) -->
                            <form action="{{ route('wishlist.toggle') }}" method="POST" onsubmit="return confirmDelete(this, 'Hapus Wishlist?', 'Produk ini akan dihapus dari daftar keinginan Anda.')">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $w->product->id }}">
                                <button type="submit" class="btn-wish-action delete" title="Hapus dari Wishlist">
                                    <i data-lucide="trash-2"></i> HAPUS
                                </button>
                            </form>

                            <!-- Tombol Detail (Pill Style) -->
                            <button type="button" class="btn-wish-cart w-full"
                                onclick="openOrderModal('{{ $w->product->id }}', '{{ addslashes($w->product->name) }}', '{{ $w->product->price }}', '{{ asset('uploads/products/'.$w->product->image) }}', '{{ addslashes($w->product->description) }}')">
                                <i data-lucide="eye"></i>
                                <span>Lihat Detail & Pesan</span>
                            </button>
                        </div>
                    </div>
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
