@extends('errors::layout')
@section('title', '401 - Akses Tidak Diizinkan')

@section('content')
    <h1 data-aos="fade-up" data-aos-delay="100" data-aos-offset="100">401</h1>
    <h2 data-aos="fade-up" data-aos-delay="300" data-aos-offset="100">Akses Tidak Diizinkan</h2>
    <p data-aos="fade-up" data-aos-delay="500" data-aos-offset="100">Anda harus login atau tidak memiliki izin untuk mengakses halaman ini.</p>
    <p data-aos="fade-up" data-aos-delay="700" data-aos-offset="100">Silakan login atau hubungi administrator jika Anda yakin ini kesalahan.</p>
    <a href="{{ url('/') }}" class="cta-button" data-aos="zoom-in" data-aos-delay="900" data-aos-offset="100">Kembali ke Halaman Utama</a>
    <p class="footer-text" data-aos="fade-in" data-aos-delay="1100" data-aos-offset="100">Kami menjaga keamanan akses untuk semua pengguna.</p>
@endsection
