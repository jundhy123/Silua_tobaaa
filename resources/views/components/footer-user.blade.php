<footer class="silua-footer-mewah">
    <div class="max-w-7xl mx-auto px-8 md:px-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-16 lg:gap-8">
            
            <!-- KOLOM 1: BRANDING (Span 4 kolom) -->
            <div class="lg:col-span-4 space-y-8">
                <div>
                    <h2 class="footer-brand-title">SILUA <span>TOBA.</span></h2>
                    <p class="footer-description">
                        Menyajikan kehangatan tradisi Toba melalui cita rasa artisanal yang autentik, kurasi bahan alami, dan dedikasi pada kualitas premium di setiap hidangan.
                    </p>
                </div>

                <!-- Media Sosial -->
                <div class="footer-social-wrapper">
                    <a href="#" class="social-icon-btn" title="Instagram">
                        <i data-lucide="instagram" class="w-5 h-5"></i>
                    </a>
                    <a href="#" class="social-icon-btn" title="Facebook">
                        <i data-lucide="facebook" class="w-5 h-5"></i>
                    </a>
                    <a href="#" class="social-icon-btn" title="Twitter">
                        <i data-lucide="twitter" class="w-5 h-5"></i>
                    </a>
                </div>
            </div>

            <!-- KOLOM 2: PINTASAN (Span 2 kolom) -->
            <div class="lg:col-span-2">
                <span class="footer-column-title">Eksplorasi</span>
                <ul class="footer-list">
                    <li><a href="/">Beranda</a></li>
                    <li><a href="{{ route('user.products') }}">Koleksi Produk</a></li>
                    <li><a href="{{ route('user.about') }}">Cerita Kami</a></li>
                    <li><a href="{{ route('user.gallery') }}">Galeri Foto</a></li>
                    <li><a href="{{ route('user.testimoni') }}">Testimoni</a></li>
                </ul>
            </div>

            <!-- KOLOM 3: INFORMASI (Span 3 kolom) -->
            <div class="lg:col-span-3">
                <span class="footer-column-title">Informasi</span>
                <ul class="footer-list">
                    <li><a href="#">Cara Pemesanan</a></li>
                    <li><a href="#">Pengiriman & Logistik</a></li>
                    <li><a href="#">Syarat & Ketentuan</a></li>
                    <li><a href="#">Kebijakan Privasi</a></li>
                    <li><a href="#">Pertanyaan Umum (FAQ)</a></li>
                </ul>
            </div>

            <!-- KOLOM 4: KONTAK (Span 3 kolom) -->
            <div class="lg:col-span-3">
                <span class="footer-column-title">Kunjungi Kami</span>
                <div class="contact-detail space-y-4">
                    <p class="opacity-60 font-light">
                        Jl. Sisingamangaraja No. 123, Balige,<br>
                        Kabupaten Toba, Sumatera Utara,<br>
                        Indonesia.
                    </p>
                    <div class="pt-2">
                        <strong class="text-accent-gold">+62 812 3456 7890</strong>
                        <p class="opacity-60">concierge@siluatoba.com</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- BARIS HAK CIPTA -->
        <div class="footer-copyright-bar">
            <p class="copyright-text">
                &copy; {{ date('Y') }} Silua Toba. Seluruh Hak Cipta Dilindungi.
            </p>
        </div>
    </div>
</footer>