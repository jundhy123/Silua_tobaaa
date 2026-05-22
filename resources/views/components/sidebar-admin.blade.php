<aside class="silua-admin-sidebar">
    <div class="sidebar-header">
        <h1 class="sidebar-logo">
            SILUA <span>ADMIN</span>
        </h1>
    </div>

    <nav class="sidebar-nav">
        <!-- GROUP 1: UTAMA -->
        <div class="nav-group-label">Utama</div>
        <a href="{{ route('admin.dashboard') }}"
           class="nav-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
            <i data-lucide="layout-dashboard"></i>
            <span>Dashboard</span>
        </a>

        <!-- GROUP 2: TOKO / E-COMMERCE -->
        <div class="nav-group-label">Manajemen Toko</div>
        <!-- Pendapatan -->
        <a href="{{ route('admin.produk.index') }}"
           class="nav-item {{ Request::is('admin/produk*') ? 'active' : '' }}">
            <i data-lucide="package"></i>
            <span>Kelola Produk</span>
        </a>

        <!-- GROUP 3: KONTEN WEBSITE -->
        <div class="nav-group-label">Konten Web</div>

        <a href="{{ route('admin.gallery.index') }}"
           class="nav-item {{ Request::is('admin/gallery*') ? 'active' : '' }}">
            <i data-lucide="image"></i>
            <span>Kelola Galeri</span>
        </a>

        <a href="{{ route('admin.profile.index') }}"
           class="nav-item {{ Request::is('admin/profile*') ? 'active' : '' }}">
            <i data-lucide="building-2"></i>
            <span>Kelola Profil</span>
        </a>

        <a href="{{ route('admin.teams.index') }}"
           class="nav-item {{ Request::is('admin/teams*') ? 'active' : '' }}">
            <i data-lucide="users"></i>
            <span>Kelola Tim</span>
        </a>

        <a href="{{ route('admin.about.index') }}"
           class="nav-item {{ Request::is('admin/about*') ? 'active' : '' }}">
            <i data-lucide="file-text"></i>
            <span>Kelola About</span>
        </a>

        <a href="{{ route('admin.orders.index') }}"
           class="nav-item {{ Request::is('admin/pesanan*') ? 'active' : '' }}">
            <i data-lucide="shopping-cart"></i>
            <span>Pesanan Masuk</span>
        </a>

        <!-- FOOTER SIDEBAR -->
        <div class="sidebar-divider"></div>

        <form action="{{ route('logout') }}" method="POST" class="px-4 mt-auto mb-6">
            @csrf
            <button type="submit" class="logout-pill">
                <i data-lucide="log-out"></i>
                <span>Keluar ke Home</span>
            </button>
        </form>
    </nav>
</aside>