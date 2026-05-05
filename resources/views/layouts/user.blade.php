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
    <link rel="stylesheet" href="{{ asset('css/cart-premium.css') }}">

    <!-- TAILWIND CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- LUCIDE ICONS LIBRARY -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="min-h-screen bg-[#EAEFEF] font-sans text-gray-900 overflow-x-hidden">

    <!-- NOTIFIKASI GLOBAL (Laravel Session) -->
    @if(session('success') || session('error'))
        <div id="global-alert" class="fixed top-28 right-8 z-[10002] px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-4 animate-bounce-in {{ session('error') ? 'bg-red-600 text-white' : 'bg-green-600 text-white' }}">
            <div class="p-2 rounded-full bg-white/10">
                <i data-lucide="check" class="w-4 h-4"></i>
            </div>
            <p class="text-xs font-bold uppercase tracking-widest">
                {{ session('error') ?? session('success') }}
            </p>
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
        <a href="https://wa.me/6285361839192" target="_blank" class="wa-fab-link">
            <div class="wa-icon-box">
                <svg viewBox="0 0 24 24" width="30" height="30" fill="currentColor">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.94 3.659 1.437 5.634 1.437h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
            </div>
            <div class="wa-text-content">
                <span class="wa-label">Chat Admin</span>
                <span class="wa-number">+62 853-6183-9192</span>
            </div>
        </a>
    </div>

    <!-- SCRIPTS -->
    <script>
document.addEventListener("DOMContentLoaded", function () {

    /* ===============================
       1. INIT LUCIDE ICONS
    =============================== */
    if (window.lucide) {
        lucide.createIcons();
    }

    /* ===============================
       2. INTERSECTION OBSERVER
    =============================== */
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.img-box, .product-premium-card')
        .forEach(el => observer.observe(el));

    /* ===============================
       3. WISHLIST BUTTON
    =============================== */
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

    /* ===============================
       4. NAVBAR SCROLL EFFECT
    =============================== */
    window.addEventListener('scroll', function() {
        const navbar = document.getElementById('navbar');
        if (navbar) {
            if (window.scrollY > 50) navbar.classList.add('scrolled');
            else navbar.classList.remove('scrolled');
        }
    });

    /* ===============================
       5. AUTO HIDE ALERT
    =============================== */
    const alertBox = document.getElementById('global-alert');
    if(alertBox) {
        setTimeout(() => alertBox.remove(), 4000);
    }

});

/* ===============================
   6. FALLBACK LUCIDE (IMPORTANT)
=============================== */
window.addEventListener("load", function () {
    if (window.lucide) {
        lucide.createIcons();
    }
});

/* ===============================
   GLOBAL FUNCTIONS
=============================== */

// CART DRAWER
function toggleCart() {
    const drawer = document.getElementById('cartDrawer');
    const overlay = document.getElementById('cartOverlay');

    drawer.classList.toggle('active');
    overlay.classList.toggle('active');

    document.body.style.overflow =
        drawer.classList.contains('active') ? 'hidden' : 'auto';
}

// MODAL
const orderModal = document.getElementById('modalOrder');

if (!window.openOrderModal) {
    window.openOrderModal = function(id, name, price, img, desc, reviews = []) {
        if(!orderModal) return;

        document.getElementById('m-name').innerText = name;
        document.getElementById('m-price').innerText =
            "Rp " + new Intl.NumberFormat('id-ID').format(price);
        document.getElementById('m-img').src = img;
        document.getElementById('m-desc').innerText =
            desc || "Kelezatan autentik khas Toba.";

        const container = document.getElementById('m-reviews-container');
        if(container) {
            container.innerHTML = reviews.length
                ? reviews.map(rev => `
                    <div style="background:#f8fafc;padding:20px;border-radius:20px;margin-bottom:10px;">
                        <p><strong>${rev.user?.name || 'Pelanggan'}</strong></p>
                        <p>"${rev.comment}"</p>
                    </div>
                `).join('')
                : '<p class="text-center text-gray-400">Belum ada ulasan</p>';
        }

        orderModal.classList.add('active');
        document.body.style.overflow = 'hidden';

        lucide.createIcons();
    }
}

if (!window.closeModal) {
    window.closeModal = function() {
        if(orderModal){
            orderModal.classList.remove('active');
            document.body.style.overflow = 'auto';
        }
    }
}

if (!window.changeQty) {
    window.changeQty = function(amount) {
        const qty = document.getElementById('m-qty');
        if(qty){
            let val = parseInt(qty.value);
            if(val + amount >= 1) qty.value = val + amount;
        }
    }
}
</script>
</body>
</html>