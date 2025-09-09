@extends('errors::layout')
@section('title', '419 - Halaman Kedaluwarsa')

@section('content')
    <h1 data-aos="fade-up" data-aos-delay="100" data-aos-offset="100">419</h1>
    <h2 data-aos="fade-up" data-aos-delay="300" data-aos-offset="100">Halaman Kedaluwarsa</h2>
    <p data-aos="fade-up" data-aos-delay="500" data-aos-offset="100">Halaman ini sudah tidak berlaku lagi. Mungkin karena Anda terlalu lama tidak aktif.</p>
    <p data-aos="fade-up" data-aos-delay="700" data-aos-offset="100">Silakan refresh halaman atau login ulang untuk melanjutkan.</p>
    <a href="{{ url('/') }}" class="cta-button" data-aos="zoom-in" data-aos-delay="900" data-aos-offset="100">Kembali ke Halaman Utama</a>
    <p class="footer-text" data-aos="fade-in" data-aos-delay="1100" data-aos-offset="100">Kami melindungi sesi Anda untuk keamanan yang lebih baik.</p>
@endsection
