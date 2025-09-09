@extends('errors::layout')
@section('title', '402 - Pembayaran Diperlukan')

@section('content')
    <h1 data-aos="fade-up" data-aos-delay="100" data-aos-offset="100">402</h1>
    <h2 data-aos="fade-up" data-aos-delay="300" data-aos-offset="100">Pembayaran Diperlukan</h2>
    <p data-aos="fade-up" data-aos-delay="500" data-aos-offset="100">Untuk mengakses halaman ini, Anda perlu menyelesaikan pembayaran terlebih dahulu.</p>
    <p data-aos="fade-up" data-aos-delay="700" data-aos-offset="100">Silakan hubungi bagian keuangan atau periksa paket langganan Anda.</p>
    <a href="{{ url('/') }}" class="cta-button" data-aos="zoom-in" data-aos-delay="900" data-aos-offset="100">Kembali ke Halaman Utama</a>
    <p class="footer-text" data-aos="fade-in" data-aos-delay="1100" data-aos-offset="100">Layanan terbaik untuk pengguna yang berkomitmen.</p>
@endsection
