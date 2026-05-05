@extends('layouts.user')

@section('title', 'Katalog Produk Rasa Nusantara')

@section('content')
<link rel="stylesheet" href="{{ asset('css/produk-user.css') }}">

<div class="product-page-wrapper">
    <header class="product-header reveal">
        <h1 class="header-title">Daftar Produk</h1>
        <p class="header-subtitle">Temukan menu-menu favorit kami yang siap memanjakan lidah Anda. Semua hidangan disiapkan segar setiap hari.</p>
    </header>

    <section class="container">
        <div class="section-heading reveal">
            <div class="heading-text">
                <h2 class="main-title">Karya Terbaik Pengrajin</h2>
                <p class="sub-title">Setiap produk bercerita tentang dedikasi, keterampilan, dan kekayaan budaya nusantara yang kami jaga.</p>
            </div>
        </div>

        <div class="product-grid" id="productGrid">
            @forelse ($products as $key => $p)
            <div class="product-card" style="--order: {{ $key }}">
                <div class="image-wrapper">

                    @if($p->reviews->count() > 5)
                        <span class="badge-status">TERLARIS</span>
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
                    
                    <div class="image-overlay">
                        <button type="button" class="btn-add-cart" 
                            onclick='openOrderModal(
                                {{ $p->id }},
                                "{{ addslashes($p->name) }}",
                                {{ $p->price }},
                                "{{ asset('uploads/products/'.$p->image) }}",
                                "{{ addslashes($p->description) }}",
                                @json($p->reviews)
                            )'>
                            <i data-lucide="shopping-cart"></i> Tambah ke Keranjang
                        </button>
                    </div>
                </div>

                <div class="product-content">
                    <h3 class="product-title">{{ $p->name }}</h3>
                    <p class="product-desc">{{ Str::limit($p->description, 80) }}</p>
                    
                    <div class="flex justify-between items-center mt-4">
                        <div class="product-price">Rp {{ number_format($p->price, 0, ',', '.') }}</div>
                        
                        <button class="btn-ulasan" 
                            onclick='openOrderModal(
                                {{ $p->id }},
                                "{{ addslashes($p->name) }}",
                                {{ $p->price }},
                                "{{ asset('uploads/products/'.$p->image) }}",
                                "{{ addslashes($p->description) }}",
                                @json($p->reviews)
                            )'>
                            <i data-lucide="message-square" class="w-3 h-3"></i> ULASAN
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state col-span-full text-center py-20 opacity-20">
                <i data-lucide="package-open" class="w-16 h-16 mx-auto mb-4"></i>
                <p>Produk belum tersedia</p>
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
                if (entry.target.id === 'productGrid') {
                    entry.target.querySelectorAll('.product-card').forEach((card) => {
                        card.classList.add('show');
                    });
                }
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    const grid = document.getElementById('productGrid');
    if(grid) observer.observe(grid);

    if(typeof lucide !== 'undefined') lucide.createIcons();
});

// ✅ FIX: tambah parameter reviews + render
function openOrderModal(id, name, price, img, desc, reviews = []) {
    const modal = document.getElementById('modalOrder');

    document.getElementById('m-id').value = id;
    if(document.getElementById('rev-prod-id')) document.getElementById('rev-prod-id').value = id;

    document.getElementById('m-name').innerText = name;
    document.getElementById('m-price').innerText = "Rp " + new Intl.NumberFormat('id-ID').format(price);
    document.getElementById('m-img').src = img;
    document.getElementById('m-desc').innerText = desc || "Cita rasa autentik nusantara.";
    document.getElementById('m-qty').value = 1;

    // ✅ render ulasan
    const container = document.getElementById('m-reviews-container');
    const countLabel = document.getElementById('m-review-count-label');

    if(container && countLabel){
        container.innerHTML = '';
        countLabel.innerText = `(${reviews.length} ULASAN)`;

        if (reviews.length > 0) {
            reviews.forEach(rev => {
                let stars = '';
                for(let i=1;i<=5;i++){
                    stars += `<i data-lucide="star" class="w-3 h-3 ${i<=rev.rating?'text-yellow-500':'text-gray-200'}" fill="${i<=rev.rating?'currentColor':'none'}"></i>`;
                }

                container.innerHTML += `
                    <div class="bg-gray-50 p-6 rounded-2xl">
                        <div class="flex gap-1 mb-2">${stars}</div>
                        <p class="font-bold text-sm">${rev.user ? rev.user.name : 'User'}</p>
                        <p class="text-xs text-gray-500">"${rev.comment}"</p>
                    </div>
                `;
            });
        } else {
            container.innerHTML = '<p class="text-center text-gray-400">Belum ada ulasan</p>';
        }
    }

    modal.classList.add('active');
    document.body.style.overflow = 'hidden';

    setTimeout(() => {
        if(typeof lucide !== 'undefined') lucide.createIcons();
    }, 100);
}

function closeModal() {
    document.getElementById('modalOrder').classList.remove('active');
    document.body.style.overflow = 'auto';
}

function changeQty(amount) {
    const qtyInput = document.getElementById('m-qty');
    if(qtyInput) {
        let current = parseInt(qtyInput.value) || 1;
        if (current + amount >= 1) {
            qtyInput.value = current + amount;
        }
    }
}

function handleDirectOrder() {
    const productId = document.getElementById('m-id').value;
    const quantity = document.getElementById('m-qty').value;

    const hiddenForm = document.getElementById('directOrderForm');
    if(hiddenForm) {
        document.getElementById('do-id').value = productId;
        document.getElementById('do-qty').value = quantity;
        hiddenForm.submit();
    }
}
</script>
@endsection