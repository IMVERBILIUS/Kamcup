@extends('errors::layout')
@section('title', '503 - Layanan Tidak Tersedia')

@section('content')
    <h1 data-aos="fade-up" data-aos-delay="100" data-aos-offset="100">503</h1>
    <h2 data-aos="fade-up" data-aos-delay="300" data-aos-offset="100">Layanan Tidak Tersedia</h2>
    <p data-aos="fade-up" data-aos-delay="500" data-aos-offset="100">Saat ini layanan sedang tidak tersedia karena pemeliharaan atau overload.</p>
    <p data-aos="fade-up" data-aos-delay="700" data-aos-offset="100">Kami akan kembali secepat mungkin. Terima kasih atas kesabaran Anda.</p>
    <a href="{{ url('/') }}" class="cta-button" data-aos="zoom-in" data-aos-delay="900" data-aos-offset="100">Kembali ke Halaman Utama</a>
    <p class="footer-text" data-aos="fade-in" data-aos-delay="1100" data-aos-offset="100">Kami berkomitmen memberikan layanan terbaik.</p>
@endsection
