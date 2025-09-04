<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'KAMCUP')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')
</head>

<body style="font-family: 'Poppins', sans-serif">
    <nav class="navbar navbar-expand-lg bg-transparent py-3 position-absolute top-0 start-0 w-100 z-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('front.index') }}"
                style="width: 260px; overflow: hidden; height: 130px;">
                <img src="{{ asset('assets/img/logo5.png') }}" alt="KAMCUP Logo" class="me-2 brand-logo"
                    style="height: 90%; width: 90%; object-fit: cover;">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
                    <li class="nav-item"><a class="nav-link fw-medium" href="{{ route('front.index') }}">HOME</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium" href="{{ route('front.articles') }}">BERITA</a>
                    </li>
                    <li class="nav-item"><a class="nav-link fw-medium" href="{{ route('front.galleries') }}">GALERI</a>
                    </li>
                    <li class="nav-item"><a class="nav-link fw-medium"
                            href="{{ route('front.events.index') }}">EVENT</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium" href="{{ route('front.contact') }}">HUBUNGI
                            KAMI</a></li>
                    </li>

                    <li class="nav-item search-container">
                        <a href="#" class="nav-link search-icon" id="search-icon">
                            <i class="fas fa-search"></i>
                        </a>
                        <form action="{{ route('front.search') }}" method="GET" class="search-form" id="search-form">
                            <input type="text" name="query" class="search-input"
                                placeholder="Cari artikel, event, galeri..." value="{{ request('query') }}"
                                autocomplete="off" required minlength="3">
                            <button type="submit" class="search-submit-btn" aria-label="Submit Search">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </li>

                    @guest
                        <li class="nav-item"><a class="nav-link fw-medium" href="{{ route('login') }}">LOGIN</a></li>
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

                    {{-- Component Translator --}}
                    <x-navbar-translate />
                </ul>
            </div>
        </div>
    </nav>
    <div class="main-wrapper d-flex flex-column min-vh-100">
        <div class="container alert-fixed">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        {{-- Content Section --}}
        <div class="content flex-grow-1">
            @yield('content')
        </div>

        {{-- Footer --}}
        @include('layouts.footer')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

    {{-- JavaScript untuk Search Toggle --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchIcon = document.getElementById('search-icon');
            const searchForm = document.getElementById('search-form');
            const searchInput = searchForm?.querySelector('.search-input');

            if (searchIcon && searchForm && searchInput) {
                // Ketika ikon search diklik
                searchIcon.addEventListener('click', function(event) {
                    event.preventDefault();
                    event.stopPropagation();

                    searchForm.classList.toggle('active');

                    // Jika form menjadi aktif, langsung fokus ke input field
                    if (searchForm.classList.contains('active')) {
                        searchInput.focus();
                    }
                });

                // Sembunyikan form jika user mengklik di luar area form
                document.addEventListener('click', function(event) {
                    const isClickInsideForm = searchForm.contains(event.target);
                    const isClickOnIcon = searchIcon.contains(event.target);

                    if (!isClickInsideForm && !isClickOnIcon) {
                        searchForm.classList.remove('active');
                    }
                });

                // Jangan sembunyikan form ketika mengklik di dalam form itu sendiri
                searchForm.addEventListener('click', function(event) {
                    event.stopPropagation();
                });
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
