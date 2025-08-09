<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'KAMCUP')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Favicon (opsional) --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Google Fonts (optional) --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    {{-- CSS Global Anda (style.css) --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    {{-- Tempat untuk CSS yang di-push dari halaman spesifik (seperti profile.css) --}}
    {{-- Ini harus di sini, setelah CSS global dan Bootstrap, agar dapat mengoverride --}}
    @stack('styles')

</head>
<body style="font-family: 'Poppins', sans-serif">


    <div class="main-wrapper d-flex flex-column min-vh-100">

        {{-- Anda mungkin ingin menambahkan navbar atau header di sini jika master layout Anda memilikinya --}}
        {{-- Contoh: @include('layouts.navbar') --}}

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
