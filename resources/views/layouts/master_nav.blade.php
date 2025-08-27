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
    {{-- ============= NAVBAR LENGKAP DITEMPATKAN DI SINI ============== --}}
    {{-- ================================================================= --}}
    <nav class="navbar navbar-expand-lg bg-transparent py-3 position-absolute top-0 start-0 w-100 z-3" >
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('front.index') }}"
                style="width: 260px; overflow: hidden; height: 130px;">
                <img src="{{ asset('assets/img/logo5.png') }}" alt="KAMCUP Logo" class="me-2 brand-logo"
                    style="height: 100%; width: 100%; object-fit: cover;">
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
                    <li class="nav-item"><a class="nav-link fw-medium" href="{{ route('front.contact') }}">CONTACT
                            US</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium" href="{{ route('profile.index') }}">PROFILE</a>
                    </li>
                    @guest
                        <li class="nav-item"><a class="nav-link fw-medium" href="{{ route('login') }}">LOGIN</a></li>
                    @else
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-light ms-lg-3">LOGOUT</button>
                            </form>
                        </li>
                    @endguest
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    @stack('scripts')
</body>

</html>
