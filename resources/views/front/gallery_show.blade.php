@extends('../layouts/master_nav')

@section('content')

<div class="container py-4" style="font-family: 'Poppins', sans-serif; background-color: #F8F8FF;">

    <div class="d-flex justify-content-start mb-4 mt-4">
        <a href="{{ route('front.galleries') }}" class="btn px-4 py-2 gallery-back-btn">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <h3 class="fw-bold mb-4 gallery-main-title">{{ $gallery->title }}</h3>

    <div class="row mb-4 g-4">
        {{-- Kolom Kiri: Thumbnail Utama --}}
        <div class="col-md-8">
            @if($gallery->thumbnail)
                <img src="{{ asset('storage/' . $gallery->thumbnail) }}"
                     class="img-fluid rounded shadow-sm gallery-main-media"
                     alt="Thumbnail Galeri: {{ $gallery->title }}">
            @else
                <div class="d-flex align-items-center justify-content-center bg-light rounded shadow-sm gallery-main-media" style="min-height: 400px;">
                    <p class="text-muted">Tidak ada thumbnail</p>
                </div>
            @endif
        </div>

        {{-- Kolom Kanan: Detail Dokumentasi (tetap di col-md-4) --}}
        <div class="col-md-4">
            <div class="card p-4 shadow-sm border-0 gallery-info-card mb-4 flex-grow-1">
                <h5 class="fw-bold mb-3 gallery-card-title">Detail Dokumentasi</h5>
                <hr class="mb-3 mt-0">

                <div class="mb-3">
                    <small class="text-muted d-block mb-1">Author</small>
                    <div class="fw-semibold gallery-detail-value">{{ $gallery->author ?? 'Tidak Diketahui' }}</div>
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block mb-1">Nama Turnamen</small>
                    <div class="fw-semibold gallery-detail-value">{{ $gallery->tournament_name ?? 'N/A' }}</div>
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block mb-1">Status</small>
                    <div class="fw-semibold gallery-detail-value" style="color: {{ $gallery->status == 'Published' ? '#36b37e' : '#ffc107' }};">
                        {{ $gallery->status }}
                    </div>
                </div>

                <div>
                    <small class="text-muted d-block mb-1">Dibuat pada</small>
                    <div class="fw-semibold gallery-detail-value">{{ $gallery->created_at->format('d M Y') }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bagian Galeri Gambar (Thumbnail Scroll) --}}
    @if ($gallery->images->count())
    <h5 class="fw-bold mb-3 gallery-section-title">Galeri Gambar</h5>
    <div class="d-flex overflow-auto flex-nowrap gap-3 mb-4 px-1 pb-2 gallery-thumbnail-scroll">
        @foreach ($gallery->images as $image)
            <div class="flex-shrink-0 gallery-thumbnail-item">
                <img src="{{ asset('storage/' . $image->image) }}"
                    class="img-fluid rounded shadow-sm gallery-thumbnail-img"
                    alt="Galeri {{ $gallery->title }} - Gambar {{ $loop->iteration }}">
            </div>
        @endforeach
    </div>
    <style>
        .gallery-thumbnail-scroll {
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none; /* Hide scrollbar for Firefox */
            -ms-overflow-style: none; /* Hide scrollbar for IE/Edge */
        }
        .gallery-thumbnail-scroll::-webkit-scrollbar { /* Hide scrollbar for Chrome/Safari */
            display: none;
        }
    </style>
    @endif

    {{-- Kartu Video Dokumentasi (dipindahkan ke bawah galeri gambar) --}}
    @if($gallery->video_link)
        <div class="mt-4 card shadow-sm p-3 border-0 gallery-info-card text-center w-100">
            <h5 class="fw-bold mb-3 gallery-card-title">Tonton Video Dokumentasi</h5>
            <a href="{{ $gallery->video_link }}" target="_blank" class="d-inline-block">
                <i class="fab fa-youtube" style="font-size: 80px; color: #FF0000;"></i>
            </a>
            <p class="text-muted mt-2">Klik ikon di atas untuk menonton di YouTube</p>
        </div>
    @endif

    {{-- Deskripsi Utama --}}
    <div class="card shadow-sm p-4 mb-4 border-0 gallery-info-card mt-4"> {{-- Ditambah mt-4 di sini --}}
        <h5 class="fw-bold mb-3 gallery-card-title">Deskripsi</h5>
        <p class="text-justify mb-0 gallery-description-content">{{ $gallery->description }}</p>
    </div>

    {{-- Subjudul dan Konten Tambahan --}}
    @if ($gallery->subtitles->count())
        @foreach ($gallery->subtitles->sortBy('order_number') as $subtitle)
            <div class="card shadow-sm p-4 mb-4 border-0 gallery-info-card">
                <h5 class="fw-bold mb-3 gallery-card-title">
                    {{ $subtitle->order_number }}. {{ $subtitle->subtitle }}
                </h5>
                @foreach ($subtitle->contents->sortBy('order_number') as $content)
                    <p class="text-justify mb-2 gallery-paragraph-content">{{ $content->content }}</p>
                @endforeach
            </div>
        @endforeach
    @endif

</div>
@endsection

@push('styles')
    {{-- Pastikan Font Awesome (untuk ikon panah dan YouTube) sudah terhubung --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        /* Main Colors (consistent with your application's theme) */
        :root {
            --main-text-color: #0C2C5A; /* Dark blue from your reference */
            --light-bg-color: #F8F8FF; /* Light background color from your reference */
            --light-highlight-bg: #F0F5FF; /* Lighter blue background for some elements */
            --accent-yellow: #FFC107; /* Yellow accent from your reference */
            --gray-text-color: #5F738C; /* Muted gray for paragraphs */
            --dark-gray-text: #333; /* Darker gray for general text */
            --border-line-color: rgba(12, 44, 90, 0.08); /* Light border for hr/separators */
            --shadow-light: rgba(0,0,0,.08);
            --shadow-medium: rgba(0,0,0,.1);
            --shadow-heavy: rgba(0,0,0,.2);
        }

        body {
            font-family: 'Open Sans', sans-serif;
            color: var(--dark-gray-text);
            background-color: var(--light-bg-color); /* Applied to body as per reference */
        }

        /* Top Back Button */
        .gallery-back-btn {
            background-color: var(--light-highlight-bg);
            color: var(--main-text-color);
            font-weight: 600;
            border-radius: 8px;
            border: 1px solid var(--border-line-color);
            transition: all 0.3s ease;
        }
        .gallery-back-btn:hover {
            background-color: var(--main-text-color) !important;
            color: var(--light-highlight-bg) !important;
            border-color: var(--main-text-color) !important;
            box-shadow: 0 0.25rem 0.5rem var(--shadow-medium);
        }

        /* Main Title */
        .gallery-main-title {
            font-family: 'Poppins', sans-serif;
            font-size: 2.2rem;
            color: var(--main-text-color);
        }

        /* Main Thumbnail/Video Container */
        .gallery-main-media {
            width: 100%;
            height: 400px; /* Fixed height as in your code */
            object-fit: cover;
            border-radius: 0.5rem; /* Consistent with other cards */
            box-shadow: 0 0.25rem 0.75rem var(--shadow-light);
        }
        /* For the placeholder div if no thumbnail */
        .gallery-main-media.bg-light {
             display: flex;
             align-items: center;
             justify-content: center;
        }

        /* General Info Card Styling (for "Detail Dokumentasi", "Deskripsi", "Subjudul") */
        .gallery-info-card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 0.25rem 0.75rem var(--shadow-light);
            border: none; /* Remove default card border */
        }

        /* Titles within cards */
        .gallery-card-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            color: var(--main-text-color);
            font-size: 1.25rem; /* Adjusted for h5 from 1.6rem */
        }

        /* Details within the info card (e.g., Author, Tournament Name) */
        .gallery-detail-value {
            font-size: 1rem;
            color: var(--main-text-color);
        }
        .gallery-info-card hr {
            border-top: 1px solid var(--border-line-color);
        }

        /* Gallery Thumbnail Scroll (horizontal gallery below main thumbnail) */
        .gallery-thumbnail-scroll {
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none; /* Hide scrollbar for Firefox */
            -ms-overflow-style: none; /* Hide scrollbar for IE/Edge */
        }
        .gallery-thumbnail-scroll::-webkit-scrollbar { /* Hide scrollbar for Chrome/Safari */
            display: none;
        }

        .gallery-thumbnail-item {
            flex-shrink: 0;
            width: 200px; /* Width from your reference */
            height: 140px; /* Height from your reference */
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            cursor: pointer;
        }
        .gallery-thumbnail-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 0.5rem; /* Consistent border-radius */
            box-shadow: 0 0.25rem 0.5rem var(--shadow-light);
        }
        .gallery-thumbnail-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 0.5rem 1rem var(--shadow-medium) !important;
        }

        /* Descriptions & Paragraphs */
        .gallery-description-content,
        .gallery-paragraph-content {
            font-size: 1rem;
            line-height: 1.8;
            color: var(--main-text-color); /* From reference */
            text-align: justify;
        }

        /* Subtitle Sections */
        .gallery-section-title { /* For "Galeri Gambar" heading */
             font-family: 'Poppins', sans-serif;
             font-weight: 700;
             color: var(--main-text-color);
             font-size: 1.8rem; /* Adjusted based on typical section title size */
             margin-bottom: 1.5rem; /* Standard margin below section titles */
        }
        .subheading-section h3 { /* For numbered subtitles like "1. Subtitle" */
            font-family: 'Poppins', sans-serif;
            font-size: 1.6rem;
            color: var(--main-text-color);
            border-bottom: 2px solid var(--light-highlight-bg) !important; /* From reference */
            padding-bottom: 8px;
            margin-bottom: 20px !important;
        }

        /* Responsive adjustments from your previous code */
        @media (max-width: 768px) {
            .gallery-main-media {
                height: 300px; /* Adjust height for smaller screens */
            }
            .gallery-thumbnail-item {
                width: 150px; /* Smaller width for thumbnails on mobile */
                height: 100px;
            }
            .gallery-main-title {
                font-size: 1.8rem;
            }
             .gallery-section-title {
                font-size: 1.5rem;
            }
            .subheading-section h3 {
                font-size: 1.4rem;
            }
        }
        @media (max-width: 576px) {
            .gallery-main-media {
                height: 250px;
            }
        }
    </style>
@endpush
