<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth - Silua Toba</title>

    <!-- PANGGIL SEMUA CSS MODULAR -->
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-[#EAEFEF]"> <!-- Paksa background agar tidak putih polos -->

    @yield('content')

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        lucide.createIcons(); // Jalankan ulang setiap ganti halaman
    });
</script>
</body>
</html>