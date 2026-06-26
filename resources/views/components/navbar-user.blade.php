<header id="navbar" class="silua-navbar fixed top-0 left-0 w-full z-[10001] transition-all duration-500 {{ $nav_type ?? '' }}">
    <!-- Kontainer Navbar: Menggunakan justify-between untuk memisahkan Kiri, Tengah, dan Kanan -->
    <div class="w-full px-6 md:px-12 flex items-center justify-between h-full">

        <!-- BAGIAN KIRI: LOGO & BRAND -->
        <div class="flex-shrink-0">
            <a href="/" class="flex items-center gap-4 no-underline group py-4">
                <div class="relative w-12 h-12 bg-amber-700 rounded-xl flex items-center justify-center p-2 shadow-md group-hover:rotate-6 transition-transform duration-500">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-contain brightness-0 invert">
                </div>
                <div class="flex flex-col leading-none">
                    <span class="text-2xl font-black italic tracking-tighter brand-text-silua uppercase" style="font-family: 'Playfair Display', serif;">
                        SILUA <span class="brand-text-toba">TOBA</span>
                    </span>
                    <span class="text-[8px] font-bold uppercase tracking-[0.4em] brand-text-sub mt-1">Kuliner Warisan</span>
                </div>
            </a>
        </div>

        <!-- BAGIAN TENGAH: MENU NAVIGASI (Dibuat Lebih Nampak & Besar) -->
        <nav class="hidden lg:block absolute left-1/2 -translate-x-1/2">
            <ul class="flex items-center gap-2 m-0 p-0 list-none">
                <li><a href="/" class="nav-list-link {{ Route::is('home') ? 'active' : '' }}">Beranda</a></li>
                <li><a href="{{ route('user.products') }}" class="nav-list-link {{ Route::is('user.products*') ? 'active' : '' }}">Produk</a></li>
                <li><a href="{{ route('user.about') }}" class="nav-list-link {{ Route::is('user.about*') ? 'active' : '' }}">Tentang</a></li>
                <li><a href="{{ route('user.profile') }}" class="nav-list-link {{ Route::is('user.profile*') ? 'active' : '' }}">Profil</a></li>
                <li><a href="{{ route('user.gallery') }}" class="nav-list-link {{ Route::is('user.gallery*') ? 'active' : '' }}">Galeri</a></li>
                <li><a href="{{ route('user.testimoni') }}" class="nav-list-link {{ Route::is('user.testimoni*') ? 'active' : '' }}">Testimoni</a></li>
                <li><a href="{{ route('user.orders') }}" class="nav-list-link {{ Route::is('user.orders*') ? 'active' : '' }}">Pesanan Saya</a></li>
            </ul>
        </nav>

        <!-- BAGIAN KANAN: LOGIN, CART, WISHLIST -->
        <div class="flex items-center gap-4 md:gap-6 flex-shrink-0">
            <!-- Wishlist -->
            <a href="{{ route('user.wishlist') }}" class="nav-util-icon relative" title="Wishlist">
                <i data-lucide="heart" class="w-6 h-6"></i>
                @auth
                    @php $wishCount = \App\Models\Wishlist::where('user_id', auth()->id())->count(); @endphp
                    <span id="wishlist-badge" class="nav-badge {{ $wishCount > 0 ? 'flex' : 'hidden' }}">{{ $wishCount }}</span>
                @endauth
            </a>

            <!-- Cart -->
            <button onclick="toggleCart()" class="nav-util-icon relative" title="Keranjang">
                <i data-lucide="shopping-cart" class="w-6 h-6"></i>
                @auth
                    @php $count = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity'); @endphp
                    <span id="cart-badge" class="nav-badge {{ $count > 0 ? 'flex' : 'hidden' }}">{{ $count }}</span>
                @endauth
            </button>

            <!-- Auth -->
            @guest
                <a href="{{ route('login') }}" class="px-6 py-2.5 border border-navy-dark/10 text-navy-dark rounded-xl text-[12px] font-black uppercase tracking-widest hover:bg-navy-dark hover:text-white transition-all">
                    Masuk
                </a>
            @else
                <div class="flex items-center gap-4 pl-4 border-l border-gray-100">
                    <!-- User Identity -->
                    <div class="hidden sm:flex flex-col items-end leading-none mr-2">
                        <span class="text-[11px] font-black uppercase brand-text-silua">{{ Auth::user()->name }}</span>
                        <span class="text-[8px] font-bold text-amber-700 uppercase mt-1">
                            {{ Auth::user()->role === 'admin' ? 'Admin Utama' : 'Pelanggan Premium' }}
                        </span>
                    </div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center hover:bg-red-50 hover:text-red-600 transition-all" title="Keluar">
                            <i data-lucide="log-out" class="w-5 h-5"></i>
                        </button>
                    </form>
                </div>
            @endguest

            <!-- Mobile Toggle -->
            <button class="lg:hidden p-2" onclick="toggleMobileMenu()">
                <i data-lucide="menu" id="menuIcon" class="w-8 h-8"></i>
            </button>
        </div>
    </div>

    <!-- MOBILE MENU (Dibuat sebagai Dropdown, tidak menutupi seluruh layar) -->
    <div id="mobileMenu" class="absolute top-full left-0 w-full bg-white border-b border-black/5 shadow-2xl -translate-y-full opacity-0 invisible transition-all duration-700 lg:hidden py-10 px-8 rounded-b-[3rem]">
        <ul class="flex flex-col gap-2 list-none p-0 m-0">
            <li>
                <a href="/" class="mobile-nav-item {{ Route::is('home') ? 'active' : '' }}">
                    <i data-lucide="home" class="w-5 h-5"></i>
                    <span>Beranda</span>
                </a>
            </li>
            <li>
                <a href="{{ route('user.products') }}" class="mobile-nav-item {{ Route::is('user.products*') ? 'active' : '' }}">
                    <i data-lucide="package" class="w-5 h-5"></i>
                    <span>Produk</span>
                </a>
            </li>
            <li>
                <a href="{{ route('user.about') }}" class="mobile-nav-item {{ Route::is('user.about*') ? 'active' : '' }}">
                    <i data-lucide="book-open" class="w-5 h-5"></i>
                    <span>Tentang</span>
                </a>
            </li>
            <li>
                <a href="{{ route('user.profile') }}" class="mobile-nav-item {{ Route::is('user.profile*') ? 'active' : '' }}">
                    <i data-lucide="user" class="w-5 h-5"></i>
                    <span>Profil</span>
                </a>
            </li>
            <li>
                <a href="{{ route('user.gallery') }}" class="mobile-nav-item {{ Route::is('user.gallery*') ? 'active' : '' }}">
                    <i data-lucide="image" class="w-5 h-5"></i>
                    <span>Galeri</span>
                </a>
            </li>
            <li>
                <a href="{{ route('user.testimoni') }}" class="mobile-nav-item {{ Route::is('user.testimoni*') ? 'active' : '' }}">
                    <i data-lucide="message-circle" class="w-5 h-5"></i>
                    <span>Testimoni</span>
                </a>
            </li>
            <li>
                <a href="{{ route('user.orders') }}" class="mobile-nav-item {{ Route::is('user.orders*') ? 'active' : '' }}">
                    <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                    <span>Pesanan Saya</span>
                </a>
            </li>
        </ul>
        <div class="mt-8 pt-8 border-t border-gray-50 flex justify-center">
            <span class="text-[10px] font-black uppercase tracking-[0.4em] text-gray-300">Silua Toba Artisan</span>
        </div>
    </div>
</header>

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobileMenu');
        const icon = document.getElementById('menuIcon');
        const isOpen = menu.classList.contains('!translate-y-0');

        if (isOpen) {
            menu.classList.remove('!translate-y-0', '!opacity-100', '!visible');
            icon.setAttribute('data-lucide', 'menu');
        } else {
            menu.classList.add('!translate-y-0', '!opacity-100', '!visible');
            icon.setAttribute('data-lucide', 'x');
        }
        lucide.createIcons();
    }
</script>
