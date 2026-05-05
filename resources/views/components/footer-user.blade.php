<footer class="silua-footer-mewah">
    <div class="max-w-7xl mx-auto px-8 md:px-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-16 lg:gap-8">
            
            <!-- KOLOM 1: BRANDING -->
            <div class="lg:col-span-5 space-y-8">
                <div>
                    <h2 class="footer-brand-title">SILUA <span>TOBA.</span></h2>
                    <p class="footer-description">
                        Menyajikan kehangatan tradisi Toba melalui cita rasa artisanal yang autentik, kurasi bahan alami, dan dedikasi pada kualitas premium di setiap hidangan.
                    </p>
                </div>
    </div>

            <!-- KOLOM 2: PINTASAN -->
            <div class="lg:col-span-3">
                <span class="footer-column-title">Eksplorasi</span>
                <ul class="footer-list">
                    <li><a href="/">Beranda</a></li>
                    <li><a href="{{ route('user.products') }}">Koleksi Produk</a></li>
                    <li><a href="{{ route('user.about') }}">Cerita Kami</a></li>
                    <li><a href="{{ route('user.gallery') }}">Galeri Foto</a></li>
                    <li><a href="{{ route('user.testimoni') }}">Testimoni</a></li>
                </ul>
            </div>

            <!-- KOLOM 3: KONTAK -->
            <div class="lg:col-span-4">
                <span class="footer-column-title">Kunjungi Kami</span>

                <div class="contact-detail space-y-4">

                    <!-- Alamat -->
                    <div class="flex items-start gap-3">
                        <i data-lucide="map-pin" class="w-5 h-5 text-orange-500 mt-1"></i>
                        <p class="opacity-60 font-light">
                            Jl. Sisingamangaraja No. 123, Balige,<br>
                            Kabupaten Toba, Sumatera Utara,<br>
                            Indonesia.
                        </p>
                    </div>

                    <!-- Telepon -->
                    <div class="flex items-center gap-3">
                        <i data-lucide="phone" class="w-5 h-5 text-orange-500"></i>
                        <strong class="text-accent-gold">+62 812 3456 7890</strong>
                    </div>

                    <!-- Email -->
                    <div class="flex items-center gap-3">
                        <i data-lucide="mail" class="w-5 h-5 text-orange-500"></i>
                        <p class="opacity-60">concierge@siluatoba.com</p>
                    </div>

                </div>
            </div>

        </div>

        <!-- COPYRIGHT -->
        <div class="footer-copyright-bar">
            <p class="copyright-text">
                &copy; {{ date('Y') }} Silua Toba. Seluruh Hak Cipta Dilindungi.
            </p>
        </div>
    </div>
</footer>