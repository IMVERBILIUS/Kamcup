@extends('errors::layout')
@section('title', '403 - Akses Ditolak')

@section('content')
    <h1 data-aos="fade-up" data-aos-delay="100" data-aos-offset="100">403</h1>
    <h2 data-aos="fade-up" data-aos-delay="300" data-aos-offset="100">Akses Ditolak</h2>
    <p data-aos="fade-up" data-aos-delay="500" data-aos-offset="100">Anda tidak memiliki hak akses ke halaman ini.</p>
    <p data-aos="fade-up" data-aos-delay="700" data-aos-offset="100">Silakan kembali atau hubungi administrator jika Anda memerlukan akses khusus.</p>
    <a href="{{ url('/') }}" class="cta-button" data-aos="zoom-in" data-aos-delay="900" data-aos-offset="100">Kembali ke Halaman Utama</a>
    <p class="footer-text" data-aos="fade-in" data-aos-delay="1100" data-aos-offset="100">Kami menjaga akses agar tetap aman dan sesuai izin.</p>
@endsection