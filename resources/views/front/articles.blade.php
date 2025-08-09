@extends('../layouts/master_nav')

@section('content')

<div class="container py-5 mt-5 pt-lg-0">
    <h2 class="fw-bold mb-4 text-center section-title-articles">Semua Artikel Seputar Olahraga & Komunitas</h2>

    <div class="mb-4 d-flex justify-content-end">
        <form action="{{ route('front.articles') }}" method="GET">
            <select name="filter" class="form-select border-primary-custom text-primary-custom" onchange="this.form.submit()">
                <option value="">Sort by</option>
                <option value="latest" {{ request('filter') == 'latest' ? 'selected' : '' }}>Latest</option>
                <option value="popular" {{ request('filter') == 'popular' ? 'selected' : '' }}>Popular</option>
                <option value="author" {{ request('filter') == 'author' ? 'selected' : '' }}>By Author</option>
            </select>
        </form>
    </div>

    <div class="row row-cols-2 row-cols-md-3 g-3 g-md-4">
        @forelse($articles as $article)
            <div class="col">
                {{-- UBAH INI: Gunakan SLUG untuk tautan detail artikel --}}
                <a href="{{ route('front.articles.show', $article->slug) }}" class="article-link">
                    <div class="card h-100 border-0 shadow-sm card-hover-zoom overflow-hidden">
                        <div class="ratio ratio-4x3 article-thumbnail-wrapper">
                            <img src="{{ asset('storage/' . $article->thumbnail) }}" class="card-img-top object-fit-cover article-thumbnail" alt="{{ $article->title }}">
                        </div>
                       <div class="card-body">
                            <h5 class="card-title fw-semibold title-text text-primary-custom">{{ $article->title }}</h5>
                            <p class="card-text description-text text-muted">{{ $article->description }}</p>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center text-primary-custom">No articles found.</p>
            </div>
        @endforelse
    </div>

    {{-- Custom Pagination --}}
    <div class="mt-4 d-flex justify-content-center">
        <nav aria-label="Page navigation for Articles">
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($articles->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">&laquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $articles->previousPageUrl() . '&filter=' . request('filter') }}" rel="prev">&laquo;</a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @php
                    $currentPage = $articles->currentPage();
                    $lastPage = $articles->lastPage();
                    $pageRange = 5; // Number of page links to show

                    $startPage = max(1, $currentPage - floor($pageRange / 2));
                    $endPage = min($lastPage, $currentPage + floor($pageRange / 2));

                    // Adjust range if current page is near start or end
                    if ($currentPage <= floor($pageRange / 2) && $lastPage >= $pageRange) {
                        $endPage = $pageRange;
                    }
                    if ($currentPage > ($lastPage - floor($pageRange / 2)) && $lastPage >= $pageRange) {
                        $startPage = max(1, $lastPage - $pageRange + 1);
                    }
                @endphp

                @for ($i = $startPage; $i <= $endPage; $i++)
                    <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                        <a class="page-link" href="{{ $articles->url($i) . '&filter=' . request('filter') }}">{{ $i }}</a>
                    </li>
                @endfor

                {{-- Next Page Link --}}
                @if ($articles->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $articles->nextPageUrl() . '&filter=' . request('filter') }}" rel="next">&raquo;</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">&raquo;</span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>

</div>

@endsection

@push('styles')
<style>
    /* Main Colors from your provided code */
    :root {
        --primary-color: #002061; /* Biru Tua/Navy */
        --secondary-color: #fdbf06; /* Kuning Cerah/Emas */
        --accent-color: #c92788; /* Pink Keunguan/Magenta */
        --text-dark: #333;
        --text-light: #666;
    }

    /* General Styling */
    body {
        font-family: 'Open Sans', sans-serif;
        color: var(--text-dark);
    }

    a {
        text-decoration: none;
        color: var(--primary-color);
    }

    /* Custom Text Colors based on Brand Identity */
    .text-primary-custom { color: var(--primary-color) !important; }
    .text-secondary-custom { color: var(--secondary-color) !important; }
    .text-accent-custom { color: var(--accent-color) !important; }

    /* Section Title */
    .section-title-articles {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 2.5rem;
        color: var(--primary-color);
        margin-top: 8rem;
        position: relative;
        padding-bottom: 15px;
    }

    .section-title-articles::after {
        content: '';
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        bottom: 0;
        width: 80px;
        height: 5px;
        background-color: var(--secondary-color);
        border-radius: 2px;
    }

    /* Filter Dropdown */
    .form-select {
        width: 200px;
        display: inline-block;
        border: 1px solid var(--primary-color);
        color: var(--primary-color);
    }

    .form-select:focus {
        border-color: var(--accent-color);
        box-shadow: 0 0 0 0.25rem rgba(201, 39, 136, 0.25);
    }

    /* Article Cards */
    .article-link {
        display: block;
    }

    .card {
        border: none;
        border-radius: 0.75rem;
        overflow: hidden;
    }

    .card-hover-zoom {
        transition: transform 0.4s ease, box-shadow 0.3s ease;
    }

    .card-hover-zoom:hover {
        transform: scale(1.03);
        z-index: 2;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    .article-thumbnail-wrapper {
        background-color: var(--primary-color);
    }

    .article-thumbnail {
        object-fit: cover;
        width: 100%;
        height: 100%;
    }

    .card-body {
        padding: 1.25rem;
    }

    .card-title {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        color: var(--primary-color);
    }

    .card-text.description-text {
        color: var(--text-light);
    }

    /* Text clamping for titles */
    .title-text {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 0.5rem;
    }

    /* Text clamping for descriptions */
    .description-text {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 0;
    }

    /* --- Custom Pagination Styles (Adapted from Gallery, maintaining article colors) --- */
    .pagination {
        list-style: none;
        display: flex;
        justify-content: center;
        padding: 0;
        margin: 0;
        /* Using primary-color and secondary-color from article page's :root */
        --pagination-link-color: var(--primary-color); /* Matches `border` and `color` in your ref */
        --pagination-active-bg: var(--primary-color); /* Matches `background-color` and `border-color` in active state */
        --pagination-active-color: white; /* Text color for active page */
        --pagination-hover-bg: var(--secondary-color); /* Matches `background-color` and `border-color` on hover */
        --pagination-hover-color: white; /* Text color on hover */
        --pagination-border-color: var(--primary-color); /* Default border color */
        --pagination-disabled-color: rgba(0, 32, 97, 0.4); /* Matches `color` for disabled */
        --pagination-disabled-border: rgba(0, 32, 97, 0.2); /* Matches `border-color` for disabled */
    }

    .pagination .page-item {
        margin: 0 5px; /* Spacing between pagination items */
    }

    .pagination .page-link {
        border-radius: 8px; /* Rounded corners for links */
        padding: 10px 15px;
        min-width: 40px; /* Ensures consistent width */
        text-align: center;
        font-weight: 500;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 40px; /* Consistent height */

        /* Applying colors from the new variables */
        color: var(--pagination-link-color);
        background-color: transparent;
        border: 1px solid var(--pagination-border-color);
    }

    .pagination .page-item.active .page-link {
        background-color: var(--pagination-active-bg);
        border-color: var(--pagination-active-bg);
        color: var(--pagination-active-color);
        font-weight: bold; /* Make active page number bold */
        box-shadow: 0 4px 8px rgba(0, 32, 97, 0.2); /* Subtle shadow for active page (using primary-color with opacity) */
    }

    .pagination .page-link:hover:not(.active) {
        background-color: var(--pagination-hover-bg);
        border-color: var(--pagination-hover-bg);
        color: var(--pagination-hover-color);
        transform: translateY(-2px); /* Slight lift on hover */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow on hover */
    }

    .pagination .page-item.disabled .page-link {
        color: var(--pagination-disabled-color);
        pointer-events: none;
        border-color: var(--pagination-disabled-border);
        background-color: transparent; /* Ensure disabled background is transparent */
        transform: none; /* Remove hover effect */
        box-shadow: none; /* Remove hover effect */
    }

    /* Responsive adjustments for small screens */
    @media (max-width: 767.98px) {
        .section-title-articles {
            font-size: 1.8rem;
            margin-top: 5rem;
        }
        .section-title-articles::after {
            width: 60px;
            height: 3px;
        }
        .title-text {
            font-size: 16px;
            -webkit-line-clamp: 3;
        }

        .description-text {
            -webkit-line-clamp: 2;
            font-size: 12px;
        }
        .form-select {
            width: 100%;
        }
        .d-flex.justify-content-end {
            justify-content: center !important;
        }
    }

    /* Media query for very small screens or where navbar might overlap title */
    @media (max-width: 575.98px) {
        .hero-section-articles { /* Not directly present, but good to keep if it exists elsewhere */
            padding-bottom: 2rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // No specific JS for filtering needed if using native select change for page reload
</script>
@endpush
