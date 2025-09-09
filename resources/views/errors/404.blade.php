@extends('errors::layout')
@section('title', '404 - Halaman Tidak Ditemukan')

@section('content')
    <h1 data-aos="fade-up" data-aos-delay="100" data-aos-offset="100">404</h1>
    <h2 data-aos="fade-up" data-aos-delay="300" data-aos-offset="100">Oops! Halaman Tidak Ditemukan</h2>
    <p data-aos="fade-up" data-aos-delay="500" data-aos-offset="100">Sepertinya Anda tersesat. Halaman yang Anda cari mungkin telah dihapus, namanya diubah, atau tidak pernah ada.</p>
    <p data-aos="fade-up" data-aos-delay="700" data-aos-offset="100">Jangan khawatir, mari kita bawa Anda kembali ke jalur yang benar.</p>
    <a href="{{ url('/') }}" class="cta-button" data-aos="zoom-in" data-aos-delay="900" data-aos-offset="100">Kembali ke Halaman Utama</a>
    <p class="footer-text" data-aos="fade-in" data-aos-delay="1100" data-aos-offset="100">Kami berkomitmen pada pertumbuhan dan semangat kompetisi yang sehat.</p>
@endsection