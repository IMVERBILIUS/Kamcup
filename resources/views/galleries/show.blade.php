@extends('layouts.admin')

@section('content')

<div class="container py-4" style="font-family: 'Poppins', sans-serif; background-color: #F8F8FF;">

    <div class="d-flex justify-content-start mb-4 mt-4">
        <a href="{{ route('admin.galleries.index') }}" class="btn px-4 py-2" {{-- Ganti ke route list galeri, bukan index homepage --}}
           style="background-color: #F0F5FF; color: #0C2C5A; font-weight: 600; border-radius: 8px; border: 1px solid #0c2c5a8d;">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <h3 class="fw-bold mb-4" style="color: #0C2C5A;">{{ $gallery->title }}</h3>

    <div class="row mb-4">
        <div class="col-md-8">
            @if($gallery->thumbnail)
                <img src="{{ asset('storage/' . $gallery->thumbnail) }}"
                     class="img-fluid rounded shadow-sm"
                     style="width: 100%; height: 400px; object-fit: cover;"
                     alt="Thumbnail Galeri: {{ $gallery->title }}">
            @else
                <div class="d-flex align-items-center justify-content-center bg-light rounded shadow-sm" style="width: 100%; height: 400px;">
                    <p class="text-muted">Tidak ada thumbnail</p>
                </div>
            @endif

            @if($gallery->video_link)
                <div class="mt-4 card shadow-sm p-3 border-0 text-center" style="border-radius: 12px;">
                    <h5 class="fw-bold mb-3" style="color: #0C2C5A;">Tonton Video Dokumentasi</h5>
                    <a href="{{ $gallery->video_link }}" target="_blank" class="d-inline-block">
                        <i class="fab fa-youtube" style="font-size: 80px; color: #FF0000;"></i>
                    </a>
                    <p class="text-muted mt-2">Klik ikon di atas untuk menonton di YouTube</p>
                </div>
            @endif

        </div>
        <div class="col-md-4">
            <div class="card p-4 shadow-sm border-0" style="border-radius: 12px; font-family: 'Poppins', sans-serif;">
                <h5 class="fw-bold mb-3" style="color: #0C2C5A;">Detail Dokumentasi</h5>
                <hr class="mb-3 mt-0">

                <div class="mb-3">
                    <small class="text-muted d-block mb-1">Author</small>
                    <div class="fw-semibold" style="font-size: 1rem; color: #0C2C5A;">{{ $gallery->author ?? 'Tidak Diketahui' }}</div>
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block mb-1">Nama Turnamen</small>
                    {{-- Akses nama turnamen via relasi tournament --}}
                    <div class="fw-semibold" style="font-size: 1rem; color: #0C2C5A;">{{ $gallery->tournament->title ?? 'N/A' }}</div>
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block mb-1">Status</small>
                    <div class="fw-semibold" style="font-size: 1rem; color: {{ $gallery->status == 'Published' ? '#36b37e' : '#ffc107' }};">
                        {{ $gallery->status }}
                    </div>
                </div>

                <div>
                    <small class="text-muted d-block mb-1">Dibuat pada</small>
                    <div class="fw-semibold" style="font-size: 1rem; color: #0C2C5A;">{{ $gallery->created_at->format('d M Y') }}</div>
                </div>
            </div>
        </div>
    </div>

    @if ($gallery->images->count())
    <h5 class="fw-bold mb-3" style="color: #0C2C5A;">Galeri Gambar</h5>
    <div class="d-flex overflow-auto flex-nowrap gap-3 mb-4 px-1 pb-2 gallery-thumbnail-scroll">
        @foreach ($gallery->images as $image)
            <div class="flex-shrink-0 gallery-thumbnail-item" style="width: 200px; height: 140px;">
                <img src="{{ asset('storage/' . $image->image) }}"
                    class="img-fluid rounded shadow-sm gallery-thumbnail-img"
                    style="height: 100%; object-fit: cover; width: 100%;"
                    alt="Galeri {{ $gallery->title }} - Gambar {{ $loop->iteration }}">
            </div>
        @endforeach
    </div>
    @endif

    <div class="card shadow-sm p-4 mb-4 border-0" style="border-radius: 12px;">
        <h5 class="fw-bold mb-3" style="color: #0C2C5A;">Deskripsi</h5>
        <p class="text-justify mb-0" style="line-height: 1.8; color: #0C2C5A;">{{ $gallery->description }}</p>
    </div>

    @if ($gallery->subtitles->count())
        @foreach ($gallery->subtitles->sortBy('order_number') as $subtitle)
            <div class="card shadow-sm p-4 mb-4 border-0" style="border-radius: 12px;">
                <h5 class="fw-bold mb-3" style="color: #0C2C5A;">
                    {{-- Culture: commitment (detail, terstruktur); Personality: process (langkah demi langkah) --}}
                    {{ $subtitle->order_number }}. {{ $subtitle->subtitle }}
                </h5>
                @foreach ($subtitle->contents->sortBy('order_number') as $content)
                    <p class="text-justify mb-2" style="line-height: 1.8; color: #0C2C5A;">{{ $content->content }}</p>
                @endforeach
            </div>
        @endforeach
    @endif

</div>
@endsection

@push('styles')
    {{-- Pastikan Font Awesome (untuk ikon panah) sudah terhubung --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            color: #333;
            background-color: #F8F8FF; /* Added from reference */
        }

        /* Tombol Kembali */
        .btn-back { /* Using custom class for easier targeting */
            background-color: #F0F5FF;
            color: #0C2C5A;
            font-weight: 600;
            border-radius: 8px;
            border: 1px solid #0c2c5a8d;
            transition: all 0.3s ease;
        }
        .btn-back:hover {
            background-color: #0C2C5A !important;
            color: #F0F5FF !important;
            border-color: #0C2C5A !important;
            box-shadow: 0 0.25rem 0.5rem rgba(12, 44, 90, 0.2);
        }

        /* Judul Proyek */
        h3.fw-bold {
            font-family: 'Poppins', sans-serif;
            font-size: 2.2rem;
            color: #0C2C5A;
            border-bottom: 3px solid #FFC107;
            padding-bottom: 10px;
            margin-bottom: 25px !important;
        }

        /* Card Info Samping */
        .card.p-4 {
            box-shadow: 0 0.25rem 0.75rem rgba(0,0,0,.08) !important;
        }
        .card.p-4 small {
            font-size: 0.85rem;
            color: #888;
        }
        .card.p-4 .fw-semibold {
            font-size: 1.05rem;
            color: #0C2C5A;
        }
        .card.p-4 hr {
            border-top: 1px solid rgba(0, 0, 0, 0.08);
        }

        /* Galeri Thumbnail Scroll */
        .gallery-thumbnail-scroll {
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: #FFC107 #f0f0f0;
        }
        .gallery-thumbnail-scroll::-webkit-scrollbar {
            height: 8px;
        }
        .gallery-thumbnail-scroll::-webkit-scrollbar-thumb {
            background-color: #FFC107;
            border-radius: 10px;
        }
        .gallery-thumbnail-scroll::-webkit-scrollbar-track {
            background-color: #f0f0f0;
            border-radius: 10px;
        }

        .gallery-thumbnail-item {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .gallery-thumbnail-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,.1) !important;
        }

        /* Deskripsi & Konten Tambahan */
        .card.shadow-sm p {
            font-size: 1rem;
            color: #0C2C5A; /* Changed from #5F738C to #0C2C5A as in reference */
            text-align: justify;
        }

        .subheading-section h3 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.6rem;
            color: #0C2C5A; /* Changed from #3A4A5C to #0C2C5A as in reference */
            border-bottom-color: #F0F5FF !important; /* Changed from #FFC107 to #F0F5FF as in reference */
            padding-bottom: 10px;
            margin-bottom: 20px !important;
        }

        .paragraph p {
            font-size: 1rem;
            color: #0C2C5A; /* Changed from #5F738C to #0C2C5A as in reference */
            text-align: justify;
        }
    </style>
@endpush
