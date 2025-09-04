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

    {{-- ================================================================= --}}
    {{-- ========================= NAVBAR LENGKAP ======================== --}}
    {{-- ================================================================= --}}
    <nav class="navbar navbar-expand-lg bg-white shadow-sm py-3 fixed-top" id="mainNavbar">
        <div class="container">
    <a class="navbar-brand" href="{{ route('front.index') }}">
     <img src="{{ asset('assets/img/logo2.png') }}" alt="KAMCUP Logo" class="brand-logo">
  </a>

            {{-- Mobile Navbar Toggler --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- Navbar Links --}}
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
                    <li class="nav-item">
                        <a class="nav-link fw-medium {{ request()->routeIs('front.index') ? 'active' : '' }}"
                            href="{{ route('front.index') }}">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium {{ request()->routeIs('front.articles*') ? 'active' : '' }}"
                            href="{{ route('front.articles') }}">BERITA</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium {{ request()->routeIs('front.galleries*') ? 'active' : '' }}"
                            href="{{ route('front.galleries') }}">GALERI</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium {{ request()->routeIs('front.events*') ? 'active' : '' }}"
                            href="{{ route('front.events.index') }}">EVENT</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium {{ request()->routeIs('front.contact') ? 'active' : '' }}"
                            href="{{ route('front.contact') }}">CONTACT US</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium {{ request()->routeIs('profile.index') ? 'active' : '' }}"
                            href="{{ route('profile.index') }}">PROFILE</a>
                    </li>
                    @guest
                        <li class="nav-item">
                            <a class="nav-link fw-medium {{ request()->routeIs('login') ? 'active' : '' }}"
                                href="{{ route('login') }}">LOGIN</a>
                        </li>
                    @else
                        {{-- Dropdown untuk User yang Sudah Login --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=0D8ABC&color=fff' }}"
                                    alt="User Avatar" class="rounded-circle me-2"
                                    style="width: 32px; height: 32px; object-fit: cover;">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end navbar-dropdown" aria-labelledby="userDropdown">
                                @if (Auth::user()->hasRole('admin'))
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                            <i class="bi bi-speedometer2 me-2"></i>Admin Dashboard
                                        </a></li>
                                @endif
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="bi bi-person-circle me-2"></i>Edit Profile
                                    </a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="mb-0">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                    
                    <li class="nav-item search-container">
                        <a href="#" class="nav-link search-icon" id="search-icon">
                            <i class="fas fa-search"></i>
                        </a>
                        <form action="{{ route('front.search') }}" method="GET" class="search-form" id="search-form">
                            <input type="text" name="query" placeholder="Cari berita..." class="form-control search-input" required minlength="3">
                            <button type="submit" class="btn search-submit-btn">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </li>
                    {{-- Component Translator yang benar dipanggil di sini --}}
                    <x-navbar-translate />
                </ul>
            </div>
        </div>
    </nav>
    {{-- ================================================================= --}}
    {{-- ======================= NAVBAR LENGKAP SELESAI ====================== --}}
    {{-- ================================================================= --}}


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

    {{-- SCRIPTS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <script src="{{ asset('js/animate.js') }}"></script>
    <script src="{{ asset('js/carousel_gallery.js') }}"></script>

    {{-- SCRIPT NAVBAR TRANSPARENT & ALERT TIMEOUT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.getElementById('mainNavbar');

            // Function to handle navbar transparency
            function handleNavbarTransparency() {
                if (window.scrollY > 50) {
                    navbar.classList.remove('navbar-transparent');
                    navbar.classList.add('bg-white', 'shadow-sm');
                } else {
                    navbar.classList.add('navbar-transparent');
                    navbar.classList.remove('bg-white', 'shadow-sm');
                }
            }

            // Initial check
            handleNavbarTransparency();

            // Event listener for scroll
            window.addEventListener('scroll', handleNavbarTransparency);

            // Function to handle alert auto-dismissal
            setTimeout(function() {
                let alert = document.querySelector('.alert-fixed .alert');
                if (alert) {
                    new bootstrap.Alert(alert).close();
                }
            }, 5000); // 5 seconds
        });
    </script>
    @stack('scripts')

    <script>
    document.addEventListener('DOMContentLoaded', function() {
    const searchIcon = document.getElementById('search-icon');
    const searchForm = document.getElementById('search-form');
    const searchInput = searchForm.querySelector('.search-input');
    
    // Pastikan elemen-elemennya ada sebelum menambahkan event listener
    if (searchIcon && searchForm && searchInput) {
        
        // Ketika ikon search diklik
        searchIcon.addEventListener('click', function(event) {
            event.preventDefault(); // Mencegah link berpindah halaman
            event.stopPropagation(); // Mencegah event "klik di luar" aktif saat ikon diklik
            
            searchForm.classList.toggle('active');
            
            // Jika form menjadi aktif, langsung fokus ke input field
            if (searchForm.classList.contains('active')) {
                searchInput.focus();
            }
        });
        
        // Sembunyikan form jika user mengklik di mana pun di luar area form
        document.addEventListener('click', function(event) {
            const isClickInsideForm = searchForm.contains(event.target);
            const isClickOnIcon = searchIcon.contains(event.target);
            
            if (!isClickInsideForm && !isClickOnIcon) {
                searchForm.classList.remove('active');
            }
        });

        // Jangan sembunyikan form ketika mengklik di dalam form itu sendiri
        searchForm.addEventListener('click', function(event) {
            event.stopPropagation(); // Mencegah event "klik di luar" aktif saat form diklik
        });
        
    } else {
        console.warn('Beberapa elemen tidak ditemukan: pastikan #search-icon, #search-form, dan .search-input sudah tersedia di DOM');
    }
});
    </script>
    </body>

</html>