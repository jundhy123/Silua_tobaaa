@extends('layouts.auth')

@section('content')
<link rel="stylesheet" href="{{ asset('css/auth-premium.css') }}">

<div class="auth-wrapper">
    <div class="auth-container reveal">
        <!-- SISI KIRI: INFO & BRANDING -->
        <div class="auth-side-info">
            <div class="auth-logo-top">
                <div class="logo-circle">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Silua Toba">
                </div>
                <span class="brand-name">Silua Toba</span>
            </div>
            
            <div class="info-content">
                <h1>Menghadirkan <br> Yang terbaik</h1>
            </div>

            <div class="auth-side-footer">
                <span>AUTHENTIC</span>
                <span>TRADITIONAL</span>
                <span>QUALITY</span>
            </div>
        </div>

        <!-- SISI KANAN: FORM LOGIN -->
        <div class="auth-side-form">
            <!-- Navigation Links -->
            <div class="auth-nav-header">
                <a href="{{ route('portal') }}" class="nav-link-btn">
                    <i data-lucide="chevron-left"></i> PORTAL
                </a>
                <a href="{{ url('/') }}" class="nav-link-btn">
                    <i data-lucide="home"></i> HOME
                </a>
            </div>

            <div class="form-wrapper">
                <div class="form-header">
                    <h2>Sign In {{ $role == 'admin' ? 'Administrator' : 'Pelanggan' }}</h2>
                    <p>Silakan masukkan kredensial akun Anda.</p>
                </div>

                <!-- Tampilkan Error Jika Ada -->
                @if ($errors->any())
                <div class="error-alert">
                    <i data-lucide="alert-circle"></i>
                    <span>Email atau password salah.</span>
                </div>
                @endif

                <form action="{{ $role == 'admin' ? route('admin.login.post') : route('user.login.post') }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <label>ALAMAT EMAIL</label>
                        <div class="input-relative">
                            <i data-lucide="mail" class="input-icon"></i>
                            <input type="email" name="email" value="{{ old('email') }}" required class="premium-input" placeholder="name@example.com">
                        </div>
                    </div>

                    <div class="input-group">
                        <label>PASSWORD</label>
                        <div class="input-relative">
                            <i data-lucide="lock" class="input-icon"></i>
                            <input type="password" name="password" required class="premium-input" placeholder="••••••••">
                        </div>
                    </div>

                    <button type="submit" class="btn-premium-auth">
                        <span>MASUK SEKARANG</span>
                        <i data-lucide="log-in"></i>
                    </button>
                </form>

                @if($role == 'pelanggan')
                <div class="auth-switch">
                    <p>Belum punya akun? <a href="{{ route('user.register') }}">Daftar gratis di sini</a></p>
                </div>
                @else
                <div class="auth-switch">
                    <p class="admin-notice">Akses terbatas hanya untuk staf internal.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    // Pastikan Lucide Icons ter-load
    if(typeof lucide !== 'undefined') lucide.createIcons();
</script>
@endsection