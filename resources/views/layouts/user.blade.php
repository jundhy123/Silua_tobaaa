<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Rumah Kreatif Toba')</title>

    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Montserrat:wght@300;400;600;700;800&family=Lora:ital,wght@0,400;0,700;1,400&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- CSS MODULAR (Urutan Terjaga) -->
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/produk-user.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal-produk.css') }}">

    <!-- TAILWIND CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- LUCIDE ICONS LIBRARY -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="min-h-screen bg-[#EAEFEF] font-sans text-gray-900 overflow-x-hidden">

    <!-- NOTIFIKASI SUKSES GLOBAL (Laravel Session) -->
    @if(session('success'))
        <div id="global-alert" class="fixed top-28 right-8 z-[10002] bg-navy-dark text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-4 animate-bounce-in">
            <div class="bg-orange-brand p-2 rounded-full text-white">
                <i data-lucide="check" class="w-4 h-4"></i>
            </div>
            <p class="text-xs font-bold uppercase tracking-widest">{{ session('success') }}</p>
            <button onclick="this.parentElement.remove()" class="ml-4 opacity-50 hover:opacity-100">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
    @endif

    <div class="min-h-screen flex flex-col">
        {{-- NAVBAR --}}
        @include('components.navbar-user')

        {{-- CONTENT DINAMIS --}}
        <main class="flex-1">
            @yield('content')
        </main>

        {{-- FOOTER --}}
        @include('components.footer-user')

        {{-- CART DRAWER --}}
        @include('components.cart-drawer')
    </div>

    <!-- WHATSAPP FAB GLOBAL -->
    <div class="wa-fab-container">
        <a href="https://wa.me/628123456789" target="_blank" class="wa-fab-link">
            <div class="wa-icon-box">
                <svg viewBox="0 0 24 24" width="30" height="30" fill="currentColor">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.94 3.659 1.437 5.634 1.437h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
            </div>
            <div class="wa-text-content">
                <span class="wa-label">Chat Admin</span>
                <span class="wa-number">+62 812-3456-789</span>
            </div>
        </a>
    </div>

    <!-- SCRIPTS -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // 1. Inisialisasi Lucide Icons
            lucide.createIcons();

            // 2. Intersection Observer (Animasi Muncul saat Scroll)
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('show');
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.img-box, .product-premium-card').forEach(el => {
                observer.observe(el);
            });

            // 3. Logika Wishlist (Love Button)
            document.addEventListener('click', function (e) {
                const btn = e.target.closest('.wishlist-btn');
                if (btn) {
                    e.preventDefault();
                    btn.classList.toggle('active');
                    const icon = btn.querySelector('i');
                    if (btn.classList.contains('active')) {
                        icon.setAttribute('fill', '#ef4444');
                        btn.style.color = '#ef4444';
                    } else {
                        icon.setAttribute('fill', 'none');
                        btn.style.color = '';
                    }
                    lucide.createIcons();
                }
            });

            // 4. Logika Navbar Scroll
            window.addEventListener('scroll', function() {
                const navbar = document.getElementById('navbar');
                if (navbar) {
                    if (window.scrollY > 50) navbar.classList.add('scrolled');
                    else navbar.classList.remove('scrolled');
                }
            });

            // Auto-hide alert setelah 4 detik
            const alertBox = document.getElementById('global-alert');
            if(alertBox) setTimeout(() => alertBox.remove(), 4000);
        });

        /* --- FUNGSI GLOBAL (Bisa dipanggil dari mana saja) --- */

        // A. Toggle Cart Drawer
        function toggleCart() {
            const drawer = document.getElementById('cartDrawer');
            const overlay = document.getElementById('cartOverlay');
            if(drawer && overlay) {
                drawer.classList.toggle('active');
                overlay.classList.toggle('active');
                document.body.style.overflow = drawer.classList.contains('active') ? 'hidden' : 'auto';
            }
        }

        // B. Modal Detail Produk & Render Ulasan Dinamis
        const orderModal = document.getElementById('modalOrder');

        function openOrderModal(id, name, price, img, desc, reviews = []) {
            if(!orderModal) return;
            
            // Pengisian Data Utama
            const idInput = document.getElementById('m-id');
            const revInput = document.getElementById('rev-prod-id');
            if(idInput) idInput.value = id;
            if(revInput) revInput.value = id;

            document.getElementById('m-name').innerText = name;
            document.getElementById('m-price').innerText = "Rp " + new Intl.NumberFormat('id-ID').format(price);
            document.getElementById('m-img').src = img;
            document.getElementById('m-desc').innerText = desc ? desc : "Kelezatan autentik khas Toba.";
            
            const qtyInput = document.getElementById('m-qty');
            if(qtyInput) qtyInput.value = 1;

            // Render Bintang Rata-rata di Atas
            const starSummary = document.getElementById('m-star-rating');
            const countLabel = document.getElementById('m-review-count');
            
            if(starSummary) starSummary.innerHTML = '';
            if(countLabel) countLabel.innerText = `(${reviews.length} Ulasan)`;

            // Render List Ulasan Pembeli
            const container = document.getElementById('m-reviews-container');
            if(container) {
                container.innerHTML = ''; 

                if (reviews.length > 0) {
                    reviews.forEach(rev => {
                        // Generate Bintang Ulasan
                        let starsHTML = '';
                        for(let i=1; i<=5; i++) {
                            starsHTML += `<i data-lucide="star" class="w-3 h-3" ${i <= rev.rating ? 'fill="#fbbf24" stroke="#fbbf24"' : 'stroke="#cbd5e1"'}></i>`;
                        }

                        container.innerHTML += `
                            <div class="review-card-modern" style="background:#f8fafc; padding:20px; border-radius:1.5rem; border:1px solid #edf2f7; margin-bottom:10px;">
                                <div class="flex justify-between mb-3">
                                    <div class="flex gap-1 text-yellow-500">${starsHTML}</div>
                                    <span class="text-[9px] text-gray-400 font-bold uppercase tracking-widest">
                                        ${new Date(rev.created_at).toLocaleDateString('id-ID', {day:'numeric', month:'short'})}
                                    </span>
                                </div>
                                <p class="font-black text-navy-dark text-sm flex items-center gap-2">
                                    ${rev.user ? rev.user.name : 'Pelanggan Silua'} 
                                    <i data-lucide="check-circle" class="w-3 h-3 text-green-500"></i>
                                </p>
                                <p class="text-xs text-gray-500 mt-2 italic leading-relaxed">"${rev.comment}"</p>
                            </div>
                        `;
                    });
                } else {
                    container.innerHTML = '<p class="col-span-full text-center text-gray-400 italic py-10 font-medium">Belum ada ulasan untuk produk ini.</p>';
                }
            }

            // Tampilkan Modal
            orderModal.classList.add('active');
            document.body.style.overflow = 'hidden';
            
            // Refresh Lucide untuk merender ikon bintang & centang hijau yang baru diinject
            lucide.createIcons();
        }

        function closeModal() {
            if(orderModal) {
                orderModal.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        }

        // C. Quantity Changer
        function changeQty(amount) {
            const qtyInput = document.getElementById('m-qty');
            if(qtyInput) {
                let current = parseInt(qtyInput.value);
                if (current + amount >= 1) qtyInput.value = current + amount;
            }
        }

        // D. Toggle Review Form
        function toggleReviewForm() {
            const form = document.getElementById('reviewFormSection');
            if(form) form.classList.toggle('hidden');
        }

        // E. Global Click Handlers
        window.onclick = function(event) {
            if (event.target == orderModal) closeModal();
        }

        window.addEventListener('scroll', function() {
        const navbar = document.getElementById('navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
        
    </script>
</body>
</html>