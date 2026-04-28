@extends('layouts.user')

@section('title', 'Katalog Produk Rasa Nusantara')

@section('content')
<!-- CSS khusus untuk halaman produk -->
<link rel="stylesheet" href="{{ asset('css/produk-user.css') }}">

<div class="product-page-wrapper">
    <!-- HEADER SECTION -->
    <header class="product-header reveal">
        <h1 class="header-title">Daftar Produk</h1>
        <p class="header-subtitle">Temukan menu-menu favorit kami yang siap memanjakan lidah Anda. Semua hidangan disiapkan segar setiap hari.</p>
        
        <!-- SEARCH BAR -->

    </header>

    <section class="container">
        <!-- TITLE SECTION -->
        <div class="section-heading reveal">
            <div class="heading-text">
                <h2 class="main-title">Karya Terbaik Pengrajin</h2>
                <p class="sub-title">Setiap produk bercerita tentang dedikasi, keterampilan, dan kekayaan budaya nusantara yang kami jaga.</p>
            </div>

        </div>

        <!-- PRODUCT GRID -->
        <div class="product-grid" id="productGrid">
            @forelse ($products as $key => $p)
            <div class="product-card" style="--order: {{ $key }}">
                <div class="image-wrapper">
                    <!-- Badge Terlaris -->
                    @if($p->reviews->count() > 5)
                        <span class="badge-status">TERLARIS</span>
                    @endif

                    <!-- Wishlist Button -->
                    @auth
                        <form action="{{ route('wishlist.toggle') }}" method="POST" class="wishlist-form">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $p->id }}">
                            @php 
                                $isWishlisted = \App\Models\Wishlist::where('user_id', auth()->id())
                                                    ->where('product_id', $p->id)
                                                    ->exists();
                            @endphp
                            <button type="submit" class="btn-wishlist">
                                <i data-lucide="heart" 
                                   fill="{{ $isWishlisted ? '#ff4d4d' : 'none' }}" 
                                   style="color: {{ $isWishlisted ? '#ff4d4d' : '#ccc' }}"></i>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('user.register') }}" class="btn-wishlist">
                            <i data-lucide="heart"></i>
                        </a>
                    @endauth

                    <img src="{{ asset('uploads/products/' . $p->image) }}" alt="{{ $p->name }}">
                    
                    <!-- Hover Overlay (Slide-Up Button) -->
                    <div class="image-overlay">
                        <button type="button" class="btn-add-cart" 
                            onclick="openOrderModal('{{ $p->id }}', '{{ addslashes($p->name) }}', '{{ $p->price }}', '{{ asset('uploads/products/'.$p->image) }}', '{{ addslashes($p->description) }}', {{ $p->reviews->load('user')->toJson() }})">
                            <i data-lucide="shopping-cart"></i> Tambah ke Keranjang
                        </button>
                    </div>
                </div>

                <!-- Info Produk -->
                <div class="product-content">
                    <h3 class="product-title">{{ $p->name }}</h3>
                    <p class="product-desc">{{ Str::limit($p->description, 80) }}</p>
                    
                    <div class="flex justify-between items-center mt-4">
                        <div class="product-price">Rp {{ number_format($p->price, 0, ',', '.') }}</div>
                        
                        <button class="btn-ulasan" 
                            onclick="openOrderModal('{{ $p->id }}', '{{ addslashes($p->name) }}', '{{ $p->price }}', '{{ asset('uploads/products/'.$p->image) }}', '{{ addslashes($p->description) }}', {{ $p->reviews->load('user')->toJson() }})">
                            <i data-lucide="message-square" class="w-3 h-3"></i> ULASAN
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <i data-lucide="package-open" class="w-16 h-16 mx-auto mb-4 opacity-20"></i>
                <p>Produk belum tersedia</p>
            </div>
            @endforelse
        </div>
<!--  
         PROMO BANNER (Bentuk Kapsul) 
        <div class="promo-banner-orange reveal">
            <div class="promo-content">
                <h2>Promo Awal Pekan!</h2>
                <p>Dapatkan diskon 20% untuk setiap pemesanan di hari Senin & Selasa.</p>
            </div>
            <button class="btn-promo-action">Gunakan Promo</button>
        </div>
    </section>
</div>
-->

<!-- Modal Detail (Pastikan file ini ada di components) -->
@include('components.modal-detail-produk')

<!-- SCRIPT UNTUK ANIMASI HALUS -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    // 1. Intersection Observer untuk memicu animasi saat scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px"
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
                
                // Jika yang terlihat adalah grid, munculkan anak-anaknya (staggered)
                if (entry.target.id === 'productGrid') {
                    const cards = entry.target.querySelectorAll('.product-card');
                    cards.forEach((card) => {
                        card.classList.add('show');
                    });
                }
            }
        });
    }, observerOptions);

    // Targetkan elemen untuk animasi
    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    const grid = document.getElementById('productGrid');
    if(grid) observer.observe(grid);

    // Refresh Lucide Icons
    if(typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});

// Fungsi untuk Modal (Pastikan sinkron dengan modal-detail-produk.blade.php)
function openOrderModal(id, name, price, img, desc, reviews = []) {
    const modal = document.getElementById('modalOrder');
    
    // Set data ke modal
    document.getElementById('m-id-cart').value = id;
    document.getElementById('rev-prod-id').value = id; // ✅ PENTING: Set product_id untuk review form
    document.getElementById('m-qty-cart').value = document.getElementById('m-qty').value || 1;
    document.getElementById('m-name').innerText = name;
    document.getElementById('m-price').innerText = "Rp " + new Intl.NumberFormat('id-ID').format(price);
    document.getElementById('m-img').src = img;
    document.getElementById('m-desc').innerText = desc || "Cita rasa autentik nusantara.";
    
    // Reset quantity ke 1
    document.getElementById('m-qty').value = 1;
    
    // Reset rating & review form
    document.getElementById('selected-rating').value = 5;
    document.getElementById('rev-comment').value = '';
    document.getElementById('reviewFormSection').classList.add('hidden');
    resetStarRating();

    // Tampilkan modal
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';

    // Refresh icon di dalam modal jika ada
    setTimeout(() => {
        if(typeof lucide !== 'undefined') lucide.createIcons();
    }, 100);
}

function closeModal() {
    document.getElementById('modalOrder').classList.remove('active');
    document.body.style.overflow = 'auto';
    
    // Hide toast notification jika ada
    const toast = document.getElementById('orderToast');
    if (toast) {
        toast.classList.add('hidden');
    }
}

// Fungsi untuk mengubah quantity
function changeQty(amount) {
    const qtyInput = document.getElementById('m-qty');
    if(qtyInput) {
        let current = parseInt(qtyInput.value) || 1;
        if (current + amount >= 1) {
            qtyInput.value = current + amount;
            document.getElementById('m-qty-cart').value = qtyInput.value;
        }
    }
}

// Fungsi untuk set rating bintang
function setRating(rating) {
    document.getElementById('selected-rating').value = rating;
    document.getElementById('rating-text').innerText = 'Rating: ' + rating + ' dari 5 bintang';
    
    // Update tampilan bintang
    const stars = document.querySelectorAll('#star-input .star-btn');
    stars.forEach((star, index) => {
        if (index < rating) {
            star.setAttribute('fill', '#ff9b51');
            star.style.color = '#ff9b51';
        } else {
            star.setAttribute('fill', 'none');
            star.style.color = '#d1d5db';
        }
    });
    
    if(typeof lucide !== 'undefined') lucide.createIcons();
}

// Reset star rating ke default (kosong)
function resetStarRating() {
    document.querySelectorAll('#star-input .star-btn').forEach(star => {
        star.setAttribute('fill', 'none');
        star.style.color = '#d1d5db';
    });
    document.getElementById('rating-text').innerText = 'Klik bintang untuk memilih rating';
    if(typeof lucide !== 'undefined') lucide.createIcons();
}

// Fungsi direct order ke WhatsApp
function directOrderToWA() {
    const productId = document.getElementById('m-id-cart').value;
    const productName = document.getElementById('m-name').innerText;
    const productPrice = document.getElementById('m-price').innerText;
    const quantity = parseInt(document.getElementById('m-qty').value) || 1;
    
    // Hitung total
    const priceNumber = parseInt(productPrice.replace(/[^0-9]/g, ''));
    const totalPrice = priceNumber * quantity;
    
    // Show loading
    const btn = event.target.closest('button');
    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i data-lucide="loader" class="w-5 h-5 animate-spin"></i> <span>Memproses...</span>';
    lucide.createIcons();
    
    // Persiapkan data
    const formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('product_id', productId);
    formData.append('product_name', productName);
    formData.append('quantity', quantity);
    formData.append('price', priceNumber);
    formData.append('total_price', totalPrice);
    
    // Submit ke server dengan Fetch API
    fetch('{{ route("cart.direct-order") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('✅ Pesanan #' + data.order_id + ' berhasil dibuat!');
            
            // Tampilkan toast notification
            const toast = document.getElementById('orderToast');
            if (toast) {
                toast.classList.remove('hidden');
                lucide.createIcons();
            }
            
            // Tunggu sebentar untuk user melihat pesan, lalu redirect
            setTimeout(() => {
                window.location.href = data.whatsapp_url;
            }, 2500);
        } else {
            throw new Error(data.message || 'Gagal membuat pesanan');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        btn.disabled = false;
        btn.innerHTML = originalText;
        
        // Tampilkan error toast
        alert('❌ Terjadi kesalahan: ' + error.message);
        lucide.createIcons();
    });
}
</script>

@endsection