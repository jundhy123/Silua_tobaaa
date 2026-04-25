<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Admin Silua Toba</title>

    <!-- PANGGIL CSS MODULAR -->
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&family=Lora:wght@700&display=swap" rel="stylesheet">
    
     <!-- CSS GLOBAL -->
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">

    <!-- CSS KHUSUS ADMIN -->
    <link rel="stylesheet" href="{{ asset('css/sidebar-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/forms-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard-admin.css') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="admin-body">

    <div class="admin-wrapper">
        
        {{-- SIDEBAR COMPONENT --}}
        @include('components.sidebar-admin')

        <!-- MAIN AREA -->
        <div class="admin-main-panel">
            
            {{-- TOP HEADER --}}
            <header class="admin-top-header">
    <div class="page-info">
        <h2 class="current-page-title">@yield('page_title')</h2>
    </div>

    <!-- AREA PROFIL (KANAN) -->
    <div class="admin-profile-section">
        <div class="admin-profile-info">
            <p class="admin-name">{{ Auth::user()->name }}</p>
            <p class="admin-id">ID: {{ Auth::user()->customer_id }}</p>
        </div>
        
        <!-- Lingkaran Avatar -->
        <div class="admin-avatar-circle">
            {{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}
        </div>
    </div>
</header>

            {{-- CONTENT --}}
            <div class="admin-content-inner">
                @yield('content')
            </div>

        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>