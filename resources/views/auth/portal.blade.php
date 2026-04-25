@extends('layouts.auth')

@section('content')
<link rel="stylesheet" href="{{ asset('css/auth-premium.css') }}">

<div class="auth-wrapper">
    <div class="auth-container reveal">
        
        <!-- SISI KIRI: BRANDING & INFO -->
        <div class="auth-side-info">
            <div class="auth-logo-top">
                <div class="logo-circle">
                    <!-- Ganti path gambar sesuai dengan lokasi logo Anda -->
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Silua Toba">
                </div>
                <span class="brand-name">Silua Toba</span>
            </div>
            
            <div class="info-content">
                <h1>Selamat Datang di <br> Silua Toba</h1>
                <p>Pintu masuk menuju kehangatan cita rasa autentik dan warisan bumbu terbaik Toba.</p>
            </div>

            <div class="auth-side-footer">
                <span>AUTHENTIC</span>
                <span>TRADITIONAL</span>
                <span>QUALITY</span>
            </div>
        </div>

        <!-- SISI KANAN: PILIHAN AKSES (PORTAL) -->
        <div class="auth-side-form">
            <!-- Tombol Home di Pojok Kanan Atas -->
            <div class="auth-nav-header">
                <div></div> <!-- Spacer -->
                <a href="{{ url('/') }}" class="nav-link-btn">
                    <i data-lucide="home"></i> HOME
                </a>
            </div>

            <div class="form-wrapper">
                <div class="form-header">
                    <h2>Portal Masuk</h2>
                    <p>Pilih jenis akses akun Anda untuk melanjutkan.</p>
                </div>

                <!-- Kartu Administrator -->
                <a href="{{ route('admin.login') }}" class="role-card">
                    <div class="role-icon">
                        <i data-lucide="user-cog"></i>
                    </div>
                    <div class="role-info">
                        <span>AKSES MANAJEMEN</span>
                        <h4>Administrator</h4>
                    </div>
                
                </a>

                <!-- Kartu Pelanggan -->
                <a href="{{ route('user.login') }}" class="role-card">
                    <div class="role-icon">
                        <i data-lucide="shopping-bag"></i>
                    </div>
                    <div class="role-info">
                        <span>AKSES BELANJA</span>
                        <h4>Pelanggan</h4>
                    </div>
                    
                </a>
            </div>
        </div>

    </div>
</div>

<script>
    // Inisialisasi ikon Lucide jika menggunakan library tersebut
    if(typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>
@endsection