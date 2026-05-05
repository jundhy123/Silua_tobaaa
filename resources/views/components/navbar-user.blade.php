<header id="navbar" class="silua-navbar fixed top-0 left-0 w-full z-50">

    <div class="w-full px-4 md:px-6 xl:px-10 flex items-center justify-between">
        
        <!-- LOGO -->
        <a href="/" class="flex items-center gap-4 no-underline group">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Silua Toba" class="logo-img-premium">
            
            <div class="flex flex-col leading-tight">
                <span class="brand-name-premium">SILUA TOBA</span>
                <span class="text-orange-brand text-[9px] font-bold uppercase tracking-[0.2em]">
                    Toba Experience
                </span>
            </div>
        </a>

        <!-- MENU -->
        <nav class="hidden lg:flex items-center gap-8 xl:gap-12">
            <a href="/" 
class="nav-link-premium {{ Route::is('home') ? 'active' : '' }}">
Home
</a>

<a href="{{ route('user.products') }}" 
class="nav-link-premium {{ Route::is('user.products*') ? 'active' : '' }}">
Produk
</a>

<a href="{{ route('user.about') }}" 
class="nav-link-premium {{ Route::is('user.about*') ? 'active' : '' }}">
About
</a>

<a href="{{ route('user.profile') }}" 
class="nav-link-premium {{ Route::is('user.profile*') ? 'active' : '' }}">
Profil
</a>

<a href="{{ route('user.gallery') }}" 
class="nav-link-premium {{ Route::is('user.gallery*') ? 'active' : '' }}">
Galeri
</a>

<a href="{{ route('user.testimoni') }}" 
class="nav-link-premium {{ Route::is('user.testimoni*') ? 'active' : '' }}">
Testimoni
</a>
        </nav>

        <!-- ACTION -->
        <div class="flex items-center gap-6 md:gap-8">

            <!-- Wishlist -->
            <a href="{{ route('user.wishlist') }}" class="nav-icon">
                <i data-lucide="heart" class="w-6 h-6"></i>
            </a>

            <!-- Cart -->
            <div class="nav-icon relative cursor-pointer" onclick="toggleCart()">
                <i data-lucide="shopping-cart" class="w-6 h-6"></i>

                @auth
                    @php $count = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity'); @endphp
                    @if($count > 0)
                        <span class="badge-premium">{{ $count }}</span>
                    @endif
                @endauth
            </div>

            <!-- Auth -->
            @guest
                <a href="{{ route('portal') }}" class="btn-login-premium">
                    Login
                </a>
            @else
                <div class="flex items-center gap-4 pl-6 border-l border-gray-200">
                    <span class="text-sm font-bold text-navy-dark">{{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-icon">
                            <i data-lucide="log-out" class="w-5 h-5"></i>
                        </button>
                    </form>
                </div>
            @endguest

        </div>
    </div>
</header>