<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        .search-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        /* Styling ikon search */
        .search-icon {
            cursor: pointer;
            font-size: 1.1rem;
            /* Sedikit lebih besar */
            color: var(--text-light) !important;
            /* Warna putih agar kontras */
            transition: color 0.3s ease;
        }

        .search-icon:hover {
            color: var(--collab-highlight) !important;
            /* Warna kuning saat hover */
        }

        /* Form pencarian */
        .search-form {
            position: absolute;
            top: 50%;
            right: 35px;
            /* Posisi di sebelah kiri ikon */
            display: flex;
            align-items: center;
            width: 250px;
            /* Lebar form */
            background-color: #fff;
            border-radius: 25px;
            padding: 4px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);

            /* Awalnya disembunyikan menggunakan transform & opacity */
            opacity: 0;
            transform: translateY(-50%) scaleX(0);
            transform-origin: right;
            /* Animasi dimulai dari kanan */
            visibility: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 10;
        }

        /* State ketika form aktif/terlihat */
        .search-form.active {
            opacity: 1;
            transform: translateY(-50%) scaleX(1);
            visibility: visible;
        }

        /* Input field di dalam form */
        .search-input {
            border: none;
            background: transparent;
            width: 100%;
            padding: 0.3rem 0.8rem;
            font-size: 0.9rem;
            color: var(--text-dark);
        }

        .search-input:focus {
            outline: none;
            box-shadow: none;
        }

        /* Tombol submit di dalam form */
        .search-submit-btn {
            background-color: var(--collab-primary);
            /* Warna BTN Blue */
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        .search-submit-btn:hover {
            background-color: #1e5291;
            color: #fff;
        }

        .main-wrapper {
            min-height: 0 !important;
        }
    </style>
    @stack('styles')
</head>

<body class="@yield('body-class')">

    <div class="main-wrapper d-flex flex-column">
        {{-- Navbar transparan untuk homepage --}}
        <nav
            class="navbar navbar-expand-lg bg-transparent py-3 position-absolute top-0 start-0 w-100 z-3 navbar-transparent">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ route('front.index') }}"
                    style="width: 190px; overflow: hidden; height: 90px;">
                    <img src="{{ asset('assets/img/logo4.png') }}" alt="KAMCUP Logo" class="me-2 brand-logo"
                        style="height: 100%; width: 100%; object-fit: cover;">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                    aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"
                        style="background-image: url('data:image/svg+xml;charset=utf8,%3Csvg viewBox=\'0 0 30 30\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath stroke=\'rgba%28255, 255, 255, 0.95%29\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-miterlimit=\'10\' d=\'M4 7h22M4 15h22M4 23h22\'/%3E%3C/svg%3E');"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('front.index') }}">HOME</a>
                        </li>
                        <li class="nav-item dropdown dropdown-hover">
                            <a class="nav-link dropdown-toggle fw-medium" href="#" id="infoPublikDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                INFO PUBLIK
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="infoPublikDropdown">
                                <li><a class="dropdown-item" href="{{ route('front.articles') }}">Berita</a></li>
                                <li><a class="dropdown-item" href="{{ route('front.galleries') }}">Galeri</a></li>
                                <li><a class="dropdown-item" href="{{ route('front.events.index') }}">Event</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('front.contact') }}">HUBUNGI KAMI</a>
                        </li>
                        <li class="nav-item search-container">
                            <a href="#" class="nav-link search-icon" id="search-icon">
                                <i class="fas fa-search"></i>
                            </a>
                            <form action="{{ route('front.search') }}" method="GET" class="search-form"
                                id="search-form">
                                <input type="text" name="query" class="search-input"
                                    placeholder="Cari artikel, event, galeri..." value="{{ request('query') }}"
                                    autocomplete="off" required minlength="3">
                                <button type="submit" class="search-submit-btn" aria-label="Submit Search">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </li>
                        {{-- Authentication Links --}}
                        @guest
                            <li class="nav-item">
                                <a class="nav-link fw-medium" href="{{ route('login') }}">LOGIN</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle fw-medium d-flex align-items-center" href="#"
                                    id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle me-1"></i>
                                    {{ Str::limit(Auth::user()->name ?? 'Profile', 15) }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile.index') }}">
                                            <i class="bi bi-person me-2"></i>Profile Saya
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest

                        <x-navbar-translate />
                    </ul>
                </div>
            </div>
        </nav>

        {{-- KONTEN UTAMA HALAMAN --}}
        <main class="content">
            @yield('content')
        </main>
        <x-chatbot></x-chatbot>
        @include('layouts.footer')
    </div>

    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    @stack('scripts')

    @stack('translation-script')
</body>

</html>
