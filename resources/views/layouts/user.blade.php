<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Rumah Kreatif Toba')</title>

    <!-- FAVICON -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

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

    <!-- SWEETALERT2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.confirmDelete = function(form, title = 'Hapus data?', text = 'Data yang dihapus tidak dapat dikembalikan!') {
            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                iconColor: '#f97316',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#5e6673',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    container: 'z-[999999]',
                    popup: 'rounded-[2rem] p-8',
                    title: 'text-2xl font-bold text-gray-800',
                    htmlContainer: 'text-sm text-gray-500',
                    confirmButton: 'px-6 py-3 rounded-xl font-bold text-white text-sm bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-200 transition-all duration-300',
                    cancelButton: 'px-6 py-3 rounded-xl font-bold text-white text-sm bg-gray-500 hover:bg-gray-600 focus:ring-4 focus:ring-gray-200 transition-all duration-300 ml-3'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
            return false;
        };
    </script>
</head>

<body class="min-h-screen bg-[#EAEFEF] font-sans text-gray-900 overflow-x-hidden">

    <!-- NOTIFIKASI GLOBAL (Laravel Session via SweetAlert2) -->
    @if(session('success') || session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                title: "{{ session('error') ? 'Gagal!' : 'Berhasil!' }}",
                text: "{{ session('error') ?? session('success') }}",
                icon: "{{ session('error') ? 'error' : 'success' }}",
                iconColor: "{{ session('error') ? '#ef4444' : '#10b981' }}",
                confirmButtonColor: '#111827',
                confirmButtonText: 'OK',
                customClass: {
                    container: 'z-[999999]',
                    popup: 'rounded-[2rem] p-8',
                    title: 'text-2xl font-bold text-gray-800',
                    htmlContainer: 'text-sm text-gray-500',
                    confirmButton: 'px-6 py-3 rounded-xl font-bold text-white text-sm bg-gray-900 hover:bg-amber-700 transition-all duration-300'
                },
                buttonsStyling: false
            });
        });
    </script>
    @endif

    <div class="min-h-screen flex flex-col">
        {{-- NAVBAR --}}
        @include('components.navbar-user', ['nav_type' => $__env->getSection('nav_type')])

        {{-- CONTENT DINAMIS --}}
        <main class="flex-1">
            @yield('content')
        </main>

        {{-- FOOTER --}}
        @include('components.footer-user')

        {{-- CART DRAWER --}}
        @include('components.cart-drawer')
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

        if(drawer && overlay) {
            drawer.classList.toggle('active');
            overlay.classList.toggle('active');

            document.body.style.overflow =
                drawer.classList.contains('active') ? 'hidden' : 'auto';
        }
    }

    // AJAX ADD TO CART (MODAL)
    document.addEventListener('DOMContentLoaded', () => {
        const orderForm = document.getElementById('formOrder');
        if (orderForm) {
            orderForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);

                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: data.message,
                            icon: 'success',
                            iconColor: '#10b981',
                            confirmButtonColor: '#111827',
                            confirmButtonText: 'OK',
                            customClass: {
                                container: 'z-[999999]',
                                popup: 'rounded-[2rem] p-8',
                                title: 'text-2xl font-bold text-gray-800',
                                htmlContainer: 'text-sm text-gray-500',
                                confirmButton: 'px-6 py-3 rounded-xl font-bold text-white text-sm bg-gray-900 hover:bg-amber-700 transition-all duration-300'
                            },
                            buttonsStyling: false
                        });

                        // Update counter badges globally
                        const cartBadge = document.getElementById('cart-badge');
                        if (cartBadge) {
                            cartBadge.innerText = data.cart_count;
                            if (data.cart_count > 0) {
                                cartBadge.classList.remove('hidden');
                                cartBadge.classList.add('flex');
                            } else {
                                cartBadge.classList.remove('flex');
                                cartBadge.classList.add('hidden');
                            }
                        }

                        // Refresh cart content without reload
                        refreshCartUI();
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        }
    });

    // AJAX UPDATE QTY (IN CART)
    window.updateCartQty = function(id, action) {
        const url = `/cart/${id}`;
        const formData = new FormData();
        formData.append('_method', 'PATCH');
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('action', action);

        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Refresh total and badges
                refreshCartUI();
                const cartBadge = document.getElementById('cart-badge');
                if (cartBadge) {
                    cartBadge.innerText = data.cart_count;
                    if (data.cart_count > 0) {
                        cartBadge.classList.remove('hidden');
                        cartBadge.classList.add('flex');
                    } else {
                        cartBadge.classList.remove('flex');
                        cartBadge.classList.add('hidden');
                    }
                }
            }
        });
    }

    function refreshCartUI() {
        fetch(window.location.href)
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');

            const newItemsContainer = doc.getElementById('cartItemsContainer');
            const newFooterContainer = doc.getElementById('cartFooter');

            if(newItemsContainer) document.getElementById('cartItemsContainer').innerHTML = newItemsContainer.innerHTML;
            if(newFooterContainer) {
                const cartFooter = document.getElementById('cartFooter');
                cartFooter.innerHTML = newFooterContainer.innerHTML;
                cartFooter.className = newFooterContainer.className;
            }

            if (window.lucide) lucide.createIcons();
        });
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
