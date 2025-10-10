@extends('../layouts/master_nav')
@section('title', 'Semua Event KAMCUP')

@section('content')

    {{-- Hero Section for Events Page --}}
    <section class="gallery-header scroll-animate" data-animation="fadeInDown">
        <div class="container">
            <h2 class="display-4 fw-bold mb-3 scroll-animate" data-animation="fadeInUp" data-delay="100">Jelajahi Semua Event
                KAMCUP</h2>
            <p class="lead scroll-animate" data-animation="fadeInUp" data-delay="200">Dapatkan informasi lengkap tentang
                berbagai kompetisi dan acara <b>inspiratif</b> yang diselenggarakan oleh KAMCUP.
                Jadilah bagian dari semangat <b>olahraga</b> dan <b>pertumbuhan</b> komunitas kami!</p>
        </div>
    </section>

    <div class="container py-5 gallery-page">
        <div class="filter-sort-container mb-4 d-flex justify-content-end align-items-center gap-3 scroll-animate"
            data-animation="fadeInRight">
            {{-- Filter Kategori --}}
            <div>
                <label for="category-select" class="form-label mb-0 fw-bold"
                    style="color: var(--secondary-color);">Kategori:</label>
                <select id="category-select" class="form-select w-auto d-inline-block"
                    onchange="window.location.href = this.value;"
                    style="border-color: var(--secondary-color); color: var(--secondary-color); border-radius: 8px; padding: 8px 15px;">
                    <option value="{{ request()->fullUrlWithoutQuery(['category', 'page']) }}"
                        {{ $category == 'all' ? 'selected' : '' }}>Semua</option>
                    <option value="{{ request()->fullUrlWithQuery(['category' => 'male', 'page' => 1]) }}"
                        {{ $category == 'male' ? 'selected' : '' }}>Pria</option>
                    <option value="{{ request()->fullUrlWithQuery(['category' => 'female', 'page' => 1]) }}"
                        {{ $category == 'female' ? 'selected' : '' }}>Wanita</option>
                    <option value="{{ request()->fullUrlWithQuery(['category' => 'mixed', 'page' => 1]) }}"
                        {{ $category == 'mixed' ? 'selected' : '' }}>Campuran</option>
                </select>
            </div>

            {{-- Urutkan Berdasarkan --}}
            <div>
                <label for="sort-select" class="form-label mb-0 fw-bold"
                    style="color: var(--secondary-color);">Urutkan:</label>
                <select id="sort-select" class="form-select w-auto d-inline-block"
                    onchange="window.location.href = this.value;"
                    style="border-color: var(--secondary-color); color: var(--secondary-color); border-radius: 8px; padding: 8px 15px;">
                    <option value="{{ request()->fullUrlWithoutQuery(['sort', 'page']) }}"
                        {{ $sort == 'latest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'oldest', 'page' => 1]) }}"
                        {{ $sort == 'oldest' ? 'selected' : '' }}>Terlama</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'upcoming', 'page' => 1]) }}"
                        {{ $sort == 'upcoming' ? 'selected' : '' }}>Mendatang</option>
                </select>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @forelse ($events as $index => $event)
                <div class="col scroll-animate" data-animation="fadeInUp" data-delay="{{ 100 * ($index + 1) }}">
                    <div class="card gallery-item-card h-100">
                        <img src="{{ asset('storage/' . $event->thumbnail) }}" class="card-img-top gallery-thumbnail"
                            alt="{{ $event->title }}">
                        <div class="card-body gallery-content">
                            <h5 class="card-title gallery-title">{{ $event->title }}</h5>
                            <div class="gallery-meta">
                                <p class="card-text mb-1"><strong>Lokasi:</strong> {{ $event->location }}</p>
                                <p class="card-text mb-1"><strong>Kategori:</strong> {{ ucfirst($event->gender_category) }}
                                </p>
                                <p class="card-text mb-1"><strong>Tanggal:</strong>
                                    {{ \Carbon\Carbon::parse($event->registration_start)->format('d M Y') }}
                                    @if (
                                        \Carbon\Carbon::parse($event->registration_start)->format('Y-m-d') !=
                                            \Carbon\Carbon::parse($event->registration_end)->format('Y-m-d'))
                                        - {{ \Carbon\Carbon::parse($event->registration_end)->format('d M Y') }}
                                    @endif
                                </p>
                            </div>
                            <p class="card-text gallery-description">{{ Str::limit($event->description, 100) }}</p>
                        </div>
                        <div class="gallery-footer">
                            @php
                                $statusBgColor = '';
                                $statusTextColor = '';
                                switch ($event->status) {
                                    case 'completed':
                                        $statusBgColor = 'var(--primary-color)';
                                        $statusTextColor = 'white';
                                        break;
                                    case 'ongoing':
                                        $statusBgColor = 'var(--secondary-color)';
                                        $statusTextColor = 'white';
                                        break;
                                    case 'registration':
                                        $statusBgColor = 'var(--accent-color)';
                                        $statusTextColor = 'var(--text-dark)';
                                        break;
                                    default:
                                        $statusBgColor = '#6c757d';
                                        $statusTextColor = 'white';
                                        break;
                                }
                            @endphp
                            <span class="badge"
                                style="background-color: {{ $statusBgColor }}; color: {{ $statusTextColor }};">{{ ucfirst($event->status) }}</span>
                            <a href="{{ route('front.events.show', $event->slug) }}"
                                class="btn btn-primary-kersa btn-sm">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 scroll-animate" data-animation="fadeInUp">
                    <p class="text-center text-secondary">Belum ada event untuk ditampilkan saat ini. Segera hadir!</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if ($events->hasPages())
            <div class="mt-5 d-flex justify-content-center scroll-animate" data-animation="fadeInUp">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        {{-- Previous Page Link --}}
                        @if ($events->onFirstPage())
                            <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $events->previousPageUrl() }}"
                                    rel="prev">&laquo;</a></li>
                        @endif
                        @php
                            $currentPage = $events->currentPage();
                            $lastPage = $events->lastPage();
                            $pageRange = 5;
                            $startPage = max(1, $currentPage - floor($pageRange / 2));
                            $endPage = min($lastPage, $currentPage + floor($pageRange / 2));
                            if ($currentPage <= floor($pageRange / 2) && $lastPage >= $pageRange) {
                                $endPage = $pageRange;
                            }
                            if ($currentPage > $lastPage - floor($pageRange / 2) && $lastPage >= $pageRange) {
                                $startPage = max(1, $lastPage - $pageRange + 1);
                            }
                        @endphp
                        @for ($i = $startPage; $i <= $endPage; $i++)
                            <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                <a class="page-link" href="{{ $events->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor
                        {{-- Next Page Link --}}
                        @if ($events->hasMorePages())
                            <li class="page-item"><a class="page-link" href="{{ $events->nextPageUrl() }}"
                                    rel="next">&raquo;</a></li>
                        @else
                            <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                        @endif
                    </ul>
                </nav>
            </div>
        @endif
    </div>

@endsection

@push('styles')
    {{-- Panggil CSS animasi dari file terpisah --}}
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    {{-- Letakkan CSS spesifik halaman di sini --}}
    <style>
        /* Main Colors (Jika belum didefinisikan di master_nav.blade.php atau file CSS global lainnya) */
        :root {
            --primary-color: #cb2786;
            --secondary-color: #00617a;
            --accent-color: #f4b704;
            --text-dark: #333;
            --text-light: #f8f9fa;
            --kamcup-pink: var(--primary-color);
            --kamcup-blue-green: var(--secondary-color);
            --kamcup-yellow: var(--accent-color);
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-dark);
        }

        .text-primary-kersa {
            color: var(--primary-color) !important;
        }

        .bg-primary-kersa {
            background-color: var(--primary-color) !important;
        }

        .border-primary-kersa {
            border-color: var(--primary-color) !important;
        }

        .btn-primary-kersa {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            transition: all 0.3s ease;
        }

        .btn-primary-kersa:hover {
            background-color: #a6206b;
            border-color: #a6206b;
        }

        .btn-outline-primary-kersa {
            color: var(--primary-color);
            border-color: var(--primary-color);
            background-color: transparent;
            transition: all 0.3s ease;
        }

        .btn-outline-primary-kersa:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .gallery-header {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            color: var(--text-light);
            padding: 60px 0;
            text-align: center;
            border-bottom-left-radius: 50px;
            border-bottom-right-radius: 50px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .hero-title {
            font-size: 3.5rem;
        }

        .hero-description {
            font-size: 1.25rem;
        }

        .gallery-item-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background-color: #ffffff;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            display: flex;
            flex-direction: column;
        }

        .gallery-item-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .gallery-thumbnail {
            height: 250px;
            width: 100%;
            object-fit: cover;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        .gallery-content {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .gallery-title {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 10px;
            font-size: 1.5rem;
        }

        .gallery-meta p {
            margin-bottom: 5px;
            font-size: 0.9rem;
            color: #555;
        }

        .gallery-meta strong {
            color: var(--secondary-color);
        }

        .gallery-description {
            font-size: 0.95rem;
            line-height: 1.6;
            color: #666;
            margin-top: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .gallery-footer {
            padding: 15px 20px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #eee;
            margin-top: 15px;
        }

        .event-status-badge {
            padding: 0.4em 0.8em;
            border-radius: 0.35rem;
            font-size: 0.85em;
            font-weight: 700;
            line-height: 1;
            white-space: nowrap;
            text-align: center;
            vertical-align: baseline;
            text-transform: capitalize;
        }

        .filter-sort-container .form-select {
            border-color: var(--secondary-color);
            color: var(--secondary-color);
            border-radius: 8px;
            padding: 8px 15px;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2300617a' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        }

        .filter-sort-container label {
            margin-right: 15px;
            font-weight: 600;
            color: var(--secondary-color);
        }

        .pagination .page-item .page-link {
            border-radius: 8px;
            margin: 0 5px;
            min-width: 40px;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid var(--secondary-color);
            color: var(--secondary-color);
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 40px;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            color: var(--text-light);
            font-weight: bold;
            box-shadow: 0 4px 8px rgba(0, 97, 122, 0.2);
        }

        .pagination .page-item .page-link:hover:not(.active) {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            color: var(--text-light);
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .pagination .page-item.disabled .page-link {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
    </style>
@endpush

@push('scripts')
    {{-- Panggil JS animasi dari file terpisah --}}
    <script src="{{ asset('js/animate.js') }}"></script>
    {{-- No specific JS needed for filtering since it's handled by native select change --}}
@endpush
