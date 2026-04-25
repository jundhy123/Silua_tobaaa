<header id="navbar" class="silua-navbar fixed top-0 left-0 w-full z-50 transition-all duration-500">
    <div class="max-w-[1440px] mx-auto px-10 w-full flex items-center justify-between">
        
        <!-- LOGO AREA (Sudah Menggunakan Gambar) -->
        <a href="/" class="flex items-center gap-4 no-underline group flex-shrink-0">
            <!-- Ganti path gambar sesuai logo Anda -->
            <img src="{{ asset('images/logo.png') }}" alt="Logo Silua Toba" class="logo-img-premium">
            
            <div class="flex flex-col leading-tight">
                <span class="brand-name-premium">SILUA TOBA</span>
                <span class="text-orange-brand font-bold uppercase tracking-[0.2em]" style="font-size: 9px;">Toba Experience</span>
            </div>
        </a>

        <!-- NAVIGASI TENGAH -->
        <nav class="hidden lg:flex items-center gap-8 xl:gap-12">
            <a href="/" class="nav-link-premium {{ Request::is('/') ? 'active' : '' }}">Home</a>
            <a href="{{ route('user.products') }}" class="nav-link-premium {{ Request::is('products*') ? 'active' : '' }}">Produk</a>
            <a href="{{ route('user.about') }}" class="nav-link-premium {{ Request::is('about*') ? 'active' : '' }}">About</a>
            <a href="{{ route('user.profile') }}" class="nav-link-premium {{ Request::is('profile*') ? 'active' : '' }}">Profil</a>
            <a href="{{ route('user.gallery') }}" class="nav-link-premium {{ Request::is('galeri*') ? 'active' : '' }}">Galeri</a>
            <a href="{{ route('user.testimoni') }}" class="nav-link-premium {{ Request::is('testimoni*') ? 'active' : '' }}">Testimoni</a>
        </nav>

        <!-- ACTIONS -->
        <div class="flex items-center gap-8 flex-shrink-0">
            <a href="{{ route('user.wishlist') }}" class="hover:text-orange-brand transition-colors">
                <i data-lucide="heart" class="w-6 h-6"></i>
            </a>
            <div class="cursor-pointer hover:text-orange-brand transition-colors relative" onclick="toggleCart()">
                <i data-lucide="shopping-cart" class="w-6 h-6"></i>
                @auth
                    @php $count = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity'); @endphp
                    @if($count > 0) <span class="badge-premium">{{ $count }}</span> @endif
                @endauth
            </div>
            
            @guest
                <a href="{{ route('portal') }}" class="btn-login-premium">
                    <span>Login</span>
                </a>
            @else
                <div class="flex items-center gap-4 pl-6 border-l border-gray-200">
                    <span class="text-sm font-bold text-navy-dark">{{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-red-500 transition"><i data-lucide="log-out" class="w-5 h-5"></i></button>
                    </form>
                </div>
            @endguest
        </div>
    </div>
</header>