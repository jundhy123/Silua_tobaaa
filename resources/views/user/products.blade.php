@extends('layouts.user')

@section('title', 'Katalog Produk Silua Toba')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --primary-orange: #FF5722;
        --navy-dark: #1a1a3a;
        --bg-gray: #F8FAFC;
    }

    .product-page-container {
        background-color: var(--bg-gray);
        min-height: 100vh;
        padding-top: 120px;
        padding-bottom: 80px;
    }

    /* FIX NAVBAR OVERLAP: Ensure modal is always on top */
    .product-modal {
        z-index: 99999 !important;
    }

    /* TOP HEADER & SEARCH */
    .catalog-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 40px;
        flex-wrap: wrap;
        gap: 20px;
    }

    .catalog-tagline {
        font-size: 1.1rem;
        font-weight: 500;
        color: #64748b;
        font-family: 'Inter', sans-serif;
    }

    .search-box-wrap {
        display: flex;
        gap: 10px;
        background: white;
        padding: 6px;
        border-radius: 100px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        border: 1px solid #f1f5f9;
        width: 100%;
        max-width: 400px;
    }

    .search-input-minimal {
        border: none;
        outline: none;
        padding: 10px 20px;
        flex: 1;
        font-size: 0.9rem;
        border-radius: 100px;
    }

    .btn-search-minimal {
        background-color: var(--primary-orange);
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 100px;
        font-weight: 700;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-search-minimal:hover {
        background-color: #111;
        transform: translateY(-2px);
    }

    /* LAYOUT: SIDEBAR + GRID */
    .catalog-layout {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 40px;
    }

    /* SIDEBAR KATEGORI */
    .sidebar-card {
        background: white;
        border-radius: 24px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        height: fit-content;
        position: sticky;
        top: 120px;
    }

    .sidebar-label {
        font-size: 10px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #cbd5e1;
        margin-bottom: 20px;
        display: block;
    }

    .cat-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .cat-link {
        display: block;
        padding: 14px 20px;
        border-radius: 12px;
        text-decoration: none;
        color: #64748b;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .cat-link:hover {
        background-color: #f1f5f9;
        color: var(--primary-orange);
        padding-left: 25px;
    }

    .cat-link.active {
        background-color: var(--primary-orange);
        color: white;
        box-shadow: 0 10px 20px rgba(255, 87, 34, 0.2);
    }

    /* PRODUCT CARDS */
    .product-grid-main {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 30px;
    }

    .minimal-card {
        background: white;
        border-radius: 30px;
        overflow: hidden;
        transition: all 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
        border: 1px solid #f1f5f9;
        cursor: pointer;
    }

    .minimal-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    }

    .card-img-top {
        aspect-ratio: 1;
        width: 100%;
        object-fit: cover;
        background-color: #f1f5f9;
    }

    .card-info-bottom {
        padding: 20px;
        text-align: center;
        background-color: white;
    }

    .p-name-minimal {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        color: var(--navy-dark);
        font-size: 1.1rem;
        margin: 0;
    }

    .p-price-minimal {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--primary-orange);
        margin-top: 5px;
        display: block;
    }

    /* RESPONSIVE */
    @media (max-width: 1024px) {
        .catalog-layout { grid-template-columns: 1fr; }
        .sidebar-card { position: static; margin-bottom: 30px; }
        .cat-list { flex-direction: row; flex-wrap: wrap; }
    }

    @media (max-width: 640px) {
        .catalog-header { flex-direction: column; align-items: flex-start; }
        .search-box-wrap { max-width: 100%; }
    }
</style>

<div class="product-page-container">
    <div class="max-w-7xl mx-auto px-6">

        <!-- RESTORED PAGE TITLE -->
        <header class="mb-20 reveal-up">
            <span class="sidebar-label !mb-4">Koleksi Kami</span>
            <h1 class="text-5xl md:text-7xl font-black italic text-navy-dark leading-tight" style="font-family: 'Playfair Display', serif;">
                Daftar <i>Produk</i> <br> Unggulan <i>Kami</i>
            </h1>
            <div class="w-24 h-1 bg-primary-orange mt-8"></div>
        </header>

        <!-- HEADER & SEARCH -->
        <div class="catalog-header reveal-up">
            <p class="catalog-tagline">Temukan menu favorit untuk melengkapi aktivitasmu hari ini.</p>

            <form action="{{ route('user.products') }}" method="GET" class="search-box-wrap">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..." class="search-input-minimal">
                @if(request('category') && request('category') != 'all')
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <button type="submit" class="btn-search-minimal">Search</button>
            </form>
        </div>

        <div class="catalog-layout">

            <!-- SIDEBAR KATEGORI -->
            <aside class="reveal-up">
                <div class="sidebar-card">
                    <span class="sidebar-label">Kategori</span>
                    <nav class="cat-list">
                        <a href="{{ route('user.products') }}" class="cat-link {{ !request('category') || request('category') == 'all' ? 'active' : '' }}">
                            Semua Produk
                        </a>

                        {{-- Loop Kategori Dinamis --}}
                        @foreach($categories as $cat)
                            <a href="{{ route('user.products', ['category' => $cat, 'search' => request('search')]) }}"
                               class="cat-link {{ request('category') == $cat ? 'active' : '' }}">
                                {{ $cat }}
                            </a>
                        @endforeach
                    </nav>
                </div>
            </aside>

            <!-- GRID PRODUK -->
            <main>
                <div class="product-grid-main">
                    @forelse($products as $p)
                    <div class="minimal-card reveal-up"
                         onclick='openOrderModal({{ $p->id }}, "{{ addslashes($p->name) }}", {{ $p->price }}, "{{ asset('uploads/products/'.$p->image) }}", "{{ addslashes($p->description) }}", @json($p->reviews))'>

                        <div class="relative group">
                            <img src="{{ asset('uploads/products/' . $p->image) }}" class="card-img-top" alt="{{ $p->name }}">

                            <!-- Wishlist Button Over Image -->
                            @auth
                                <form action="{{ route('wishlist.toggle') }}" method="POST" class="absolute top-4 right-4 z-30" onclick="event.stopPropagation()">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $p->id }}">
                                    @php
                                        $isWishlisted = \App\Models\Wishlist::where('user_id', auth()->id())
                                                            ->where('product_id', $p->id)
                                                            ->exists();
                                    @endphp
                                    <button type="submit" class="w-10 h-10 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center shadow-lg hover:scale-110 transition-transform">
                                        <i data-lucide="heart"
                                           class="w-4 h-4 {{ $isWishlisted ? 'text-red-500 fill-current' : 'text-gray-400' }}"></i>
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="absolute top-4 right-4 z-30 w-10 h-10 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center shadow-lg" onclick="event.stopPropagation()">
                                    <i data-lucide="heart" class="w-4 h-4 text-gray-400"></i>
                                </a>
                            @endauth
                        </div>

                        <div class="card-info-bottom">
                            <h3 class="p-name-minimal">{{ $p->name }}</h3>
                            <span class="p-price-minimal">Rp {{ number_format($p->price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full py-32 text-center opacity-30 italic">
                        <i data-lucide="package-search" class="w-16 h-16 mx-auto mb-4"></i>
                        <p class="text-xl font-bold">Produk tidak ditemukan.</p>
                    </div>
                    @endforelse
                </div>

                <!-- PAGINATION -->
                @if($products->hasPages())
                <div class="mt-20 flex justify-center reveal-up">
                    {{ $products->links() }}
                </div>
                @endif
            </main>

        </div>
    </div>
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
