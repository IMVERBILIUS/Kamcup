@extends('errors::layout')
@section('title', '500 - Kesalahan Server Internal')

@section('content')
    <h1 data-aos="fade-up" data-aos-delay="100" data-aos-offset="100">500</h1>
    <h2 data-aos="fade-up" data-aos-delay="300" data-aos-offset="100">Terjadi Kesalahan di Server</h2>
    <p data-aos="fade-up" data-aos-delay="500" data-aos-offset="100">Mohon maaf, terjadi masalah pada server kami.</p>
    <p data-aos="fade-up" data-aos-delay="700" data-aos-offset="100">Silakan coba lagi nanti atau hubungi tim teknis jika masalah berlanjut.</p>
    <a href="{{ url('/') }}" class="cta-button" data-aos="zoom-in" data-aos-delay="900" data-aos-offset="100">Kembali ke Halaman Utama</a>
    <p class="footer-text" data-aos="fade-in" data-aos-delay="1100" data-aos-offset="100">Kami sedang berusaha memperbaiki kesalahan secepatnya.</p>
@endsection
