<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Admin Silua Toba</title>

    <!-- FAVICON -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- TAILWIND CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- LUCIDE ICONS -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        :root {
            --navy-dark: #111827; /* Gray 900 */
            --amber-700: #B45309;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc; /* Very light slate for contrast against white cards */
            color: #1f2937; /* Gray 800 */
            -webkit-font-smoothing: antialiased;
        }

        /* Layout Structure */
        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
            margin-left: 320px; /* Width of Sidebar */
            min-height: 100vh;
            padding: 50px 80px;
        }

        /* Animation */
        .fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 1280px) {
            .main-content { padding: 40px 40px; }
        }

        @media (max-width: 1024px) {
            .main-content { margin-left: 0; padding: 30px 20px; }
        }
    </style>
</head>
<body>

    <div class="admin-layout">

        {{-- SIDEBAR --}}
        @include('components.sidebar-admin')

        <!-- MAIN PANEL -->
        <main class="main-content">

            <!-- TOP BAR -->
            <header class="flex items-center justify-between mb-20">
                <div>
                    <h2 class="text-[9px] font-black uppercase tracking-[0.5em] text-gray-400 mb-2">Pusat Operasional</h2>
                    <p class="text-sm font-bold text-gray-900 border-l-2 border-amber-700 pl-4">@yield('page_title', 'Administrasi')</p>
                </div>

                <div class="flex items-center gap-8">
                    <div class="text-right hidden sm:block">
                        <p class="text-[11px] font-black uppercase tracking-widest text-gray-900 leading-none mb-1">{{ Auth::user()->name }}</p>
                        <span class="text-[9px] text-amber-700 font-bold uppercase tracking-widest">Admin Utama</span>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-gray-900 flex items-center justify-center text-white font-black italic text-xl shadow-xl shadow-gray-200 border-4 border-white">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                </div>
            </header>

            {{-- CONTENT AREA --}}
            <div class="fade-in">
                @yield('content')
            </div>

        </main>
    </div>

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

    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                iconColor: '#10b981',
                confirmButtonColor: '#111827',
                confirmButtonText: 'OK',
                customClass: {
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

    @if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                title: 'Gagal!',
                text: "{{ session('error') }}",
                icon: 'error',
                iconColor: '#ef4444',
                confirmButtonColor: '#111827',
                confirmButtonText: 'OK',
                customClass: {
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) {
                lucide.createIcons();
            }
        });
    </script>
</body>
</html>
