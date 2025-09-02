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
    {{-- ============= NAVBAR LENGKAP DENGAN SEARCH DI SINI ============== --}}
    {{-- ================================================================= --}}
    <nav class="navbar navbar-expand-lg bg-white shadow-sm py-3 fixed-top navbar-solid">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('front.index') }}"
                style="width: 200px; overflow: hidden; height: 80px;">
                <img src="{{ asset('assets/img/logo5.png') }}" alt="KAMCUP Logo" class="me-2 brand-logo"
                    style="height: 100%; width: 100%; object-fit: cover;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
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
                           href="{{ route('front.contact') }}">HUBUNGI KAMI</a>
                    </li>
                    
                    {{-- Search Bar Desktop --}}
                    <li class="nav-item d-none d-lg-block">
                        <form class="search-form" action="{{ route('search') }}" method="GET">
                            <div class="search-container">
                                <input type="text" name="q" class="search-input" placeholder="Cari..." 
                                       value="{{ request('q') }}" autocomplete="off">
                                <button type="submit" class="search-btn" aria-label="Search">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>
                    </li>
                    
                    {{-- Authentication Links --}}
                    @guest
                        <li class="nav-item">
                            <a class="nav-link fw-medium {{ request()->routeIs('login') ? 'active' : '' }}" 
                               href="{{ route('login') }}">LOGIN</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle fw-medium d-flex align-items-center" 
                               href="#" id="navbarDropdown" role="button" 
                               data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-1"></i>
                                <span class="d-none d-lg-inline">{{ Str::limit(Auth::user()->name ?? 'Profile', 15) }}</span>
                                <span class="d-lg-none">Profile</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end navbar-dropdown" aria-labelledby="navbarDropdown">
                                <li>
                                    <h6 class="dropdown-header">
                                        <i class="bi bi-person-circle me-2"></i>
                                        {{ Auth::user()->name ?? 'User' }}
                                    </h6>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.index') }}">
                                        <i class="bi bi-person me-2"></i>Profile Saya
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                    
                    {{-- Language Translator --}}
                    <x-navbar-translate />
                </ul>
                
                {{-- Mobile Search Bar --}}
                <div class="d-lg-none mt-3">
                    <form class="mobile-search-form" action="{{ route('search') }}" method="GET">
                        <div class="mobile-search-container">
                            <input type="text" name="q" class="mobile-search-input" placeholder="Cari berita, event, galeri..." 
                                   value="{{ request('q') }}" autocomplete="off">
                            <button type="submit" class="mobile-search-btn" aria-label="Search">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    {{-- ================================================================= --}}
    {{-- ======================= NAVBAR LENGKAP SELESAI ====================== --}}
    {{-- ================================================================= --}}

    {{-- Spacer untuk fixed navbar --}}
    <div class="navbar-spacer" style="height: 90px;"></div>

    <div class="main-wrapper d-flex flex-column min-vh-100">
        <div class="container alert-fixed" style="margin-top: 20px;">
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
    @stack('scripts')

    {{-- Navbar Search Script --}}
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search form handling
        const searchForms = document.querySelectorAll('.search-form, .mobile-search-form');
        searchForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const input = this.querySelector('input[name="q"]');
                if (!input.value.trim()) {
                    e.preventDefault();
                    input.focus();
                    return false;
                }
            });
        });
        
        // Keyboard shortcut for search (Ctrl+K)
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                const searchInput = document.querySelector('.search-input') || 
                                 document.querySelector('.mobile-search-input');
                if (searchInput) {
                    searchInput.focus();
                    searchInput.select();
                }
            }
        });
        
        console.log('Navbar with search initialized');
    });
    </script>
</body>

</html>

<style>
/* ===== NAVBAR STYLING ===== */
.navbar-solid {
    backdrop-filter: blur(10px);
    background-color: rgba(255, 255, 255, 0.95) !important;
    transition: all 0.3s ease;
}

.nav-link {
    transition: all 0.3s ease;
    position: relative;
}

.nav-link.active {
    color: #F4B704 !important;
    font-weight: 600;
}

.nav-link.active::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 50%;
    transform: translateX(-50%);
    width: 20px;
    height: 2px;
    background: #F4B704;
    border-radius: 2px;
}

.nav-link:hover {
    color: #0F62FF !important;
}

/* ===== SEARCH BAR STYLING ===== */
.search-form {
    margin: 0;
    padding: 0;
}

.search-container {
    position: relative;
    display: flex;
    align-items: center;
    background: rgba(15, 98, 255, 0.08);
    border: 1px solid rgba(15, 98, 255, 0.15);
    border-radius: 25px;
    padding: 0;
    transition: all 0.3s ease;
    overflow: hidden;
    width: 240px;
}

.search-container:hover,
.search-container:focus-within {
    background: rgba(15, 98, 255, 0.12);
    border-color: rgba(15, 98, 255, 0.3);
    box-shadow: 0 2px 8px rgba(15, 98, 255, 0.1);
}

.search-input {
    background: transparent;
    border: none;
    padding: 9px 15px;
    color: #333;
    font-size: 14px;
    width: 100%;
    outline: none;
    font-family: 'Poppins', sans-serif;
}

.search-input::placeholder {
    color: rgba(51, 51, 51, 0.6);
    font-weight: 400;
}

.search-btn {
    background: transparent;
    border: none;
    padding: 9px 15px;
    color: #666;
    cursor: pointer;
    transition: all 0.3s ease;
}

.search-btn:hover {
    color: #0F62FF;
    background: rgba(15, 98, 255, 0.1);
}

/* Mobile Search */
.mobile-search-container {
    display: flex;
    background: rgba(15, 98, 255, 0.08);
    border: 1px solid rgba(15, 98, 255, 0.15);
    border-radius: 25px;
    overflow: hidden;
    width: 100%;
}

.mobile-search-input {
    background: transparent;
    border: none;
    padding: 12px 15px;
    color: #333;
    font-size: 15px;
    width: 100%;
    outline: none;
    font-family: 'Poppins', sans-serif;
}

.mobile-search-input::placeholder {
    color: rgba(51, 51, 51, 0.6);
}

.mobile-search-btn {
    background: rgba(15, 98, 255, 0.2);
    border: none;
    padding: 12px 15px;
    color: #333;
    cursor: pointer;
    min-width: 50px;
    transition: all 0.3s ease;
}

.mobile-search-btn:hover {
    background: rgba(15, 98, 255, 0.3);
}

/* Dropdown Styling */
.navbar-dropdown {
    border: none;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    border-radius: 12px;
    padding: 0.5rem 0;
    min-width: 220px;
    backdrop-filter: blur(10px);
    background: rgba(255, 255, 255, 0.95);
    margin-top: 8px;
}

.navbar-dropdown .dropdown-header {
    font-size: 0.85rem;
    font-weight: 600;
    color: #0F62FF;
    padding: 0.5rem 1.25rem;
}

.navbar-dropdown .dropdown-item {
    padding: 0.75rem 1.25rem;
    font-size: 14px;
    transition: all 0.3s ease;
    border: none;
    background: transparent;
    width: 100%;
    text-align: left;
    display: flex;
    align-items: center;
    color: #333;
}

.navbar-dropdown .dropdown-item:hover {
    background: rgba(15, 98, 255, 0.08);
    color: #0F62FF;
}

.navbar-dropdown .dropdown-item.text-danger:hover {
    background: rgba(220, 53, 69, 0.08);
    color: #dc3545;
}

.navbar-dropdown .dropdown-item i {
    width: 18px;
    text-align: center;
}

/* Responsive */
@media (max-width: 768px) {
    .navbar-brand {
        width: 150px !important;
        height: 60px !important;
    }
    
    .mobile-search-container {
        margin-bottom: 1rem;
    }
}

/* Accessibility */
.search-input:focus,
.mobile-search-input:focus {
    box-shadow: 0 0 0 2px rgba(15, 98, 255, 0.3);
}

.search-btn:focus,
.mobile-search-btn:focus {
    outline: 2px solid rgba(15, 98, 255, 0.5);
    outline-offset: 2px;
}
</style>