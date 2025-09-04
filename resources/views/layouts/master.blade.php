<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'KAMCUP')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    {{-- CSS TAMBAHAN UNTUK MENGATUR WARNA NAVBAR DI HALAMAN INDEX --}}
    <style>
        /* Secara default, link navbar akan berwarna gelap (sesuai navbar di halaman lain) */
        .navbar-dark .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.75);
            /* Warna default Bootstrap untuk .navbar-dark */
        }

        .navbar-dark .navbar-nav .nav-link:hover {
            color: white;
        }

        /* KHUSUS untuk halaman dengan class 'home-page', paksa link navbar jadi putih */
        .home-page .navbar.navbar-transparent .nav-link {
            color: white !important;
            /* !important untuk memastikan aturan ini menang */
        }

        .home-page .navbar.navbar-transparent .nav-link:hover {
            color: #dddddd !important;
        }
    </style>

    {{-- =================================================================== --}}
    {{-- ===== SOLUSI FINAL: OVERRIDE PAKSA ATURAN DARI style.css ===== --}}
    {{-- =================================================================== --}}
    <style>
        .main-wrapper {
            min-height: 0 !important;
        }
    </style>
    {{-- =================================================================== --}}


    @stack('styles')
</head>

<body class="@yield('body-class')">

    <div class="main-wrapper d-flex flex-column">
        {{-- Navbar akan selalu dipanggil dari sini --}}
        {{-- Kita akan membuat file navbar terpisah agar rapi --}}

        {{-- Di Halaman Index, navbar akan transparan --}}
        {{-- Di Halaman Lain, navbar akan memiliki background solid --}}

        {{-- KONTEN UTAMA HALAMAN --}}
        <main class="content">
            @yield('content')
        </main>

        {{-- FOOTER --}}
        @include('layouts.footer')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    @stack('scripts')

    @stack('translation-script')
</body>

</html>
