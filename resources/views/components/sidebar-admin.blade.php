<aside class="silua-admin-sidebar">
    <!-- BRANDING -->
    <div class="sidebar-branding">
        <a href="/" class="no-underline">
            <h1 class="italic tracking-tighter" style="font-family: 'Poppins', sans-serif;">
                SILUA <span>TOBA</span>
            </h1>
            <span class="text-[9px] font-black uppercase tracking-[0.4em] text-white/30">Administrasi Utama</span>
        </a>
    </div>

    <!-- NAVIGATION -->
    <nav class="sidebar-nav">
        <!-- Akses Website -->
        <div class="nav-group">
            <p class="nav-group-label">Akses</p>
            <a href="{{ route('home') }}" target="_blank" class="nav-item">
                <i data-lucide="external-link"></i>
                <span>Lihat Website</span>
            </a>
        </div>

        <!-- Utama -->
        <div class="nav-group">
            <p class="nav-group-label">Manajemen</p>
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                <i data-lucide="layout-dashboard"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.orders.index') }}" class="nav-item {{ Request::is('admin/pesanan*') ? 'active' : '' }}">
                <i data-lucide="shopping-cart"></i>
                <span>Pesanan</span>
            </a>
        </div>

        <!-- Inventaris -->
        <div class="nav-group">
            <p class="nav-group-label">Produk</p>
            <a href="{{ route('admin.produk.index') }}" class="nav-item {{ Request::is('admin/produk*') ? 'active' : '' }}">
                <i data-lucide="package"></i>
                <span>Inventaris</span>
            </a>
        </div>

        <!-- Konten -->
        <div class="nav-group">
            <p class="nav-group-label">Pengalaman</p>
            <a href="{{ route('admin.gallery.index') }}" class="nav-item {{ Request::is('admin/gallery*') ? 'active' : '' }}">
                <i data-lucide="image"></i>
                <span>Galeri Visual</span>
            </a>
            <a href="{{ route('admin.profile.index') }}" class="nav-item {{ Request::is('admin/profile*') ? 'active' : '' }}">
                <i data-lucide="building-2"></i>
                <span>Profil Bisnis</span>
            </a>
            <a href="{{ route('admin.teams.index') }}" class="nav-item {{ Request::is('admin/teams*') ? 'active' : '' }}">
                <i data-lucide="users"></i>
                <span>Tim Kreatif</span>
            </a>
            <a href="{{ route('admin.about.index') }}" class="nav-item {{ Request::is('admin/about*') ? 'active' : '' }}">
                <i data-lucide="file-text"></i>
                <span>Kisah Brand</span>
            </a>
        </div>
    </nav>

    <!-- FOOTER -->
    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">
                <i data-lucide="log-out" class="w-4 h-4"></i>
                <span class="text-[11px] uppercase tracking-widest">Keluar</span>
            </button>
        </form>
    </div>
</aside>
