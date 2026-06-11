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
                <h1>Menghadirkan <br> Yang Terbaik</h1>
                <p>Silakan masuk untuk menikmati pengalaman kuliner autentik Toba.</p>
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
                <div></div> <!-- Spacer -->
                <a href="{{ url('/') }}" class="nav-link-btn">
                    <i data-lucide="home"></i> HOME
                </a>
            </div>

            <div class="form-wrapper">
                <div class="form-header">
                    <h2>Sign In</h2>
                    <p>Masukkan kredensial akun Anda untuk melanjutkan.</p>
                </div>

                <!-- Tampilkan Error Jika Ada -->
                @if ($errors->any())
                <div class="error-alert">
                    <i data-lucide="alert-circle"></i>
                    <span>Kredensial salah atau akun tidak ditemukan.</span>
                </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST">
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

                <div class="auth-switch">
                    <p>Belum punya akun? <a href="{{ route('user.register') }}">Daftar di sini</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    if(typeof lucide !== 'undefined') lucide.createIcons();
</script>
@endsection
