@extends('errors::layout')
@section('title', '429 - Terlalu Banyak Permintaan')

@section('content')
    <h1 data-aos="fade-up" data-aos-delay="100" data-aos-offset="100">429</h1>
    <h2 data-aos="fade-up" data-aos-delay="300" data-aos-offset="100">Terlalu Banyak Permintaan</h2>
    <p data-aos="fade-up" data-aos-delay="500" data-aos-offset="100">Anda telah melakukan terlalu banyak permintaan dalam waktu singkat.</p>
    <p data-aos="fade-up" data-aos-delay="700" data-aos-offset="100">Silakan tunggu beberapa saat sebelum mencoba lagi.</p>
    <a href="{{ url('/') }}" class="cta-button" data-aos="zoom-in" data-aos-delay="900" data-aos-offset="100">Kembali ke Halaman Utama</a>
    <p class="footer-text" data-aos="fade-in" data-aos-delay="1100" data-aos-offset="100">Kami membatasi lalu lintas untuk menjaga performa sistem.</p>
@endsection
