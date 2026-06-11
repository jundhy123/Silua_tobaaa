@extends('layouts.auth')

@section('title', 'Buat Akun - Silua Toba')

@section('content')
<link rel="stylesheet" href="{{ asset('css/auth-premium.css') }}">

<div class="auth-wrapper">
    <div class="auth-container reveal">

        <!-- SISI KIRI: BRANDING & INFO (Premium Style) -->
        <div class="auth-side-info">
            <div class="auth-logo-top">
                <div class="logo-circle">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Silua Toba">
                </div>
                <span class="brand-name">Silua Toba</span>
            </div>

            <div class="info-content">
                <h1>Bergabunglah <br> Dengan Kami</h1>
                <p>Ciptakan akun Anda dan nikmati kemudahan memesan cita rasa autentik Nusantara dalam satu sentuhan.</p>
            </div>

            <div class="auth-side-footer">
                <span>AUTHENTIC</span>
                <span>TRADITIONAL</span>
                <span>QUALITY</span>
            </div>
        </div>

        <!-- SISI KANAN: FORM REGISTER -->
        <div class="auth-side-form">
            <!-- Navigation Header -->
            <div class="auth-nav-header">
                <a href="{{ route('login') }}" class="nav-link-btn">
                    <i data-lucide="chevron-left"></i> LOGIN
                </a>
                <a href="{{ url('/') }}" class="nav-link-btn">
                    <i data-lucide="home"></i> HOME
                </a>
            </div>

            <div class="form-wrapper">
                <div class="form-header">
                    <h2>Buat Akun Baru</h2>
                    <p>Lengkapi data diri Anda untuk mulai menjelajah.</p>
                </div>

                <form action="{{ route('user.register.post') }}" method="POST">
                    @csrf

                    <!-- Input Nama (Berjajar) -->
                    <div class="input-row-flex">
                        <div class="input-group flex-1">
                            <label>NAMA DEPAN</label>
                            <div class="input-relative">
                                <i data-lucide="user" class="input-icon"></i>
                                <input type="text" name="first_name" value="{{ old('first_name') }}" required
                                    class="premium-input @error('first_name') border-red @enderror" placeholder="Jundhy">
                            </div>
                            @error('first_name') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>

                        <div class="input-group flex-1">
                            <label>NAMA BELAKANG</label>
                            <div class="input-relative">
                                <input type="text" name="last_name" value="{{ old('last_name') }}" required
                                    class="premium-input @error('last_name') border-red @enderror" placeholder="Situmorang">
                            </div>
                            @error('last_name') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="input-group">
                        <label>ALAMAT EMAIL</label>
                        <div class="input-relative">
                            <i data-lucide="mail" class="input-icon"></i>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="premium-input @error('email') border-red @enderror" placeholder="name@example.com">
                        </div>
                        @error('email') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>

                    <!-- Password -->
                    <div class="input-group">
                        <label>PASSWORD</label>
                        <div class="input-relative">
                            <i data-lucide="lock" class="input-icon"></i>
                            <input type="password" name="password" required
                                class="premium-input @error('password') border-red @enderror" placeholder="Min. 6 Karakter">
                        </div>
                        @error('password') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>

                    <!-- Konfirmasi Password (PENTING: Agar tidak error 'Password Confirmation doesn't match') -->
                    <div class="input-group">
                        <label>KONFIRMASI PASSWORD</label>
                        <div class="input-relative">
                            <i data-lucide="shield-check" class="input-icon"></i>
                            <input type="password" name="password_confirmation" required
                                class="premium-input" placeholder="Ulangi password Anda">
                        </div>
                    </div>

                    <button type="submit" class="btn-premium-auth">
                        <span>DAFTAR SEKARANG</span>
                        <i data-lucide="user-plus"></i>
                    </button>
                </form>

                <div class="auth-switch">
                    <p>Sudah memiliki akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    // Inisialisasi ikon Lucide
    if(typeof lucide !== 'undefined') lucide.createIcons();
</script>

<style>
    /* CSS Tambahan Khusus untuk Validasi Error agar Manis */
    .error-msg {
        display: block;
        color: #ff4d4d;
        font-size: 10px;
        font-weight: 700;
        margin-top: 5px;
        margin-left: 5px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .border-red {
        border-color: #ff4d4d !important;
        background-color: #fffafa !important;
    }

    .input-row-flex {
        display: flex;
        gap: 15px;
    }

    .flex-1 { flex: 1; }

    /* Responsif untuk HP */
    @media (max-width: 480px) {
        .input-row-flex { flex-direction: column; gap: 0; }
    }
</style>
@endsection
