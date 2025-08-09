<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'KAMCUP')</title> {{-- Mengubah default title menjadi KAMCUP --}}
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Favicon (opsional) --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet"> {{-- Menambahkan Poppins bold --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    {{-- CSS Global Anda (navbar.css, atau main.css jika ada) --}}
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    {{-- Jika ada CSS global lainnya, tambahkan di sini --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/main.css') }}"> --}}

    {{-- Tempat untuk CSS yang di-push dari halaman spesifik (seperti profile.css) --}}
    {{-- Ini harus di sini, setelah CSS global dan Bootstrap, agar dapat mengoverride --}}
    @stack('styles')

    {{-- Gaya Kustom Global dan Variabel Warna --}}
    <style>
        /* Definisi variabel warna KAMCUP */
        :root {
            --kamcup-pink: #cb2786;
            --kamcup-blue-green: #00617a;
            --kamcup-yellow: #f4b704;
            --kamcup-dark-text: #212529; /* Warna teks gelap untuk kontras */
            --kamcup-light-text: #ffffff; /* Warna teks terang */
        }

        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Styling untuk teks utama dan highlight yang sering digunakan */
        .main-text {
            color: var(--kamcup-blue-green);
        }
        .highlight-text {
            color: var(--kamcup-yellow);
        }

        /* Navbar Toggler Icon - Menggunakan warna kuning KAMCUP */
        .navbar-toggler-icon {
            background-image: url('data:image/svg+xml;charset=utf8,%3Csvg viewBox=\'0 0 30 30\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath stroke=\'%23f4b704\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-miterlimit=\'10\' d=\'M4 7h22M4 15h22M4 23h22\'/%3E%3C/svg%3E') !important;
        }

        /* Gaya untuk tombol dengan warna brand KAMCUP */
        .btn-kamcup-primary {
            background-color: var(--kamcup-pink);
            border-color: var(--kamcup-pink);
            color: var(--kamcup-light-text);
        }
        .btn-kamcup-primary:hover {
            background-color: #a6206b; /* Slightly darker pink */
            border-color: #a6206b;
        }

        .btn-kamcup-secondary {
            background-color: var(--kamcup-blue-green);
            border-color: var(--kamcup-blue-green);
            color: var(--kamcup-light-text);
        }
        .btn-kamcup-secondary:hover {
            background-color: #004b5c; /* Slightly darker blue-green */
            border-color: #004b5c;
        }

        .btn-kamcup-outline {
            color: var(--kamcup-yellow);
            border-color: var(--kamcup-yellow);
            background-color: transparent;
        }
        .btn-kamcup-outline:hover {
            background-color: var(--kamcup-yellow);
            color: var(--kamcup-dark-text);
        }

        /* Gaya umum untuk card dan hover, jika belum ada di CSS terpisah */
        .card-hover-zoom {
            overflow: hidden;
            position: relative;
        }
        .card-hover-zoom img {
            transition: transform 0.5s ease;
        }
        .card-hover-zoom:hover img {
            transform: scale(1.05);
        }

        /* Gaya untuk alert agar selalu di atas konten dan terlihat jelas */
        .alert-fixed {
            position: fixed;
            top: 20px; /* Jarak dari atas */
            left: 50%;
            transform: translateX(-50%);
            z-index: 1050; /* Pastikan di atas elemen lain, di bawah navbar */
            width: 80%; /* Lebar alert */
            max-width: 600px; /* Maksimal lebar */
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-transparent py-3 position-absolute top-0 start-0 w-100 z-3" >
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('front.index') }}"
            style="width: 260px; overflow: hidden; height: 130px;">
            <img src="{{ asset('assets/img/logo5.png') }}" alt="KAMCUP Logo" class="me-2 brand-logo"
                style="height: 130%; width: 130%; object-fit: cover;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            {{-- Menggunakan gaya dari <style> global di atas --}}
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
                <li class="nav-item"><a class="nav-link fw-medium active" href="{{ route('front.index') }}">HOME</a></li>
                <li class="nav-item"><a class="nav-link fw-medium" href="{{ route('front.articles') }}">BERITA</a></li>
                <li class="nav-item"><a class="nav-link fw-medium" href="{{ route('front.galleries') }}">GALERI</a></li>
                {{-- Diperbarui: Mengarahkan ke halaman daftar semua event --}}
                <li class="nav-item"><a class="nav-link fw-medium" href="{{ route('front.events.index') }}">EVENT</a></li>
                <li class="nav-item"><a class="nav-link fw-medium" href="{{ route('front.contact') }}">CONTACT US</a></li>
                <li class="nav-item"><a class="nav-link fw-medium" href="{{ route('profile.index') }}">PROFILE</a></li>
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
            </ul>
        </div>
    </div>
</nav>

<div class="main-wrapper d-flex flex-column min-vh-100">

    {{-- Notifikasi Sukses/Error Global --}}
    {{-- Ini akan muncul di setiap halaman yang menggunakan layout ini setelah redirect --}}
    <div class="container alert-fixed">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
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

{{-- Bootstrap JS Bundle --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
{{-- Font Awesome JS (jika Anda memuatnya secara terpisah) --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

{{-- Additional Scripts (untuk JS spesifik halaman) --}}
@stack('scripts')

</body>
</html>
