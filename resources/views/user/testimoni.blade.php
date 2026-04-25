@extends('layouts.user')

@section('title', 'Testimonials - Silua Toba')

@section('content')
<!-- Import Font Premium -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/testimonial-user.css') }}">

<div class="testi-page-wrapper">
    
    <!-- HEADER SECTION -->
    <header class="testi-header container reveal">
        <span class="top-label">ULASAN PELANGGAN</span>
        <h1 class="main-title">Kisah Bahagia Pelanggan</h1>
        <p class="header-desc">
            Apa kata mereka tentang pengalaman rasa di Silua Toba. Kepuasan Anda adalah energi kami.
        </p>
        <div class="header-line"></div>
    </header>

    <!-- GRID TESTIMONI -->
    <section class="container pb-20">
        <div class="testi-grid">
            @foreach($testimonials as $key => $t)
            <div class="testi-card-premium reveal-up" style="--order: {{ $key }}">
                <!-- Ikon Kutip Besar (Background Decor) -->
                <div class="testi-quote-mark">“</div>
                
                <div class="testi-body">
                    <p class="testi-msg">"{{ $t->message }}"</p>
                </div>

                <!-- Bagian Bawah: Avatar, Nama, dan Tombol -->
                <div class="testi-footer">
                    <div class="testi-avatar-wrapper">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($t->user->name) }}&background=5B5B41&color=fff" alt="User">
                    </div>
                    
                    <div class="testi-user-info">
                        <div class="name-badge-row">
                            <h4 class="user-name">{{ $t->user->name }}</h4>
                            <span class="user-label-tag">Pelanggan Setia</span>
                        </div>

                        <!-- Tombol Aksi (Dibuat Lebih Cantik & Rapi) -->
                        @auth
                            @if($t->user_id === Auth::id())
                            <div class="testi-owner-actions">
                                <button onclick="toggleEdit({{ $t->id }})" class="btn-action edit">
                                    <i data-lucide="edit-3" class="w-3 h-3"></i> EDIT
                                </button>
                                <form action="{{ route('testimoni.destroy', $t->id) }}" method="POST" class="inline-form">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-action delete" onclick="return confirm('Hapus testimoni ini?')">
                                        <i data-lucide="trash-2" class="w-3 h-3"></i> HAPUS
                                    </button>
                                </form>
                            </div>
                            @endif
                        @endauth
                    </div>
                </div>

                <!-- Hidden Edit Form (Muncul di dalam kartu) -->
                @auth
                    @if($t->user_id === Auth::id())
                    <div id="editTestiForm{{ $t->id }}" class="hidden-edit-form">
                        <form action="{{ route('testimoni.update', $t->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <textarea name="message" class="testi-edit-input">{{ $t->message }}</textarea>
                            <div class="flex justify-end gap-2 mt-3">
                                <button type="button" onclick="toggleEdit({{ $t->id }})" class="btn-cancel">Batal</button>
                                <button type="submit" class="btn-save">Simpan</button>
                            </div>
                        </form>
                    </div>
                    @endif
                @endauth
            </div>
            @endforeach
        </div>
    </section>

    <!-- SECTION INPUT (Olive Card Premium) -->
    <section class="container reveal mt-12">
        <div class="input-card-olive">
            <div class="cta-icon-box">
                <svg viewBox="0 0 24 24" width="40" height="40" fill="none" stroke="#FF5722" stroke-width="2">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                    <line x1="12" y1="7" x2="12" y2="13"></line>
                    <line x1="9" y1="10" x2="15" y2="10"></line>
                </svg>
            </div>
            <h2 class="cta-title">Punya Pengalaman Menarik?</h2>
            <p class="cta-desc">Bagikan cerita Anda tentang kelezatan Silua Toba kepada dunia.</p>
            
            @auth
                @if(!$myTestimony)
                <form action="{{ route('testimoni.store') }}" method="POST" class="cta-form">
                    @csrf
                    <textarea name="message" placeholder="Tuliskan pengalaman Anda di sini..." required class="testi-textarea-white"></textarea>
                    <button type="submit" class="btn-pill-white">Kirim Testimoni</button>
                </form>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn-pill-white">Login Sekarang</a>
            @endauth
        </div>
    </section>
</div>

<script>
    function toggleEdit(id) {
        const form = document.getElementById('editTestiForm' + id);
        form.classList.toggle('active');
    }

    document.addEventListener("DOMContentLoaded", function() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.reveal, .reveal-up').forEach(el => observer.observe(el));
        if(typeof lucide !== 'undefined') lucide.createIcons();
    });
</script>
@endsection