@extends('../layouts/master_nav')
@section('content')
<style>
    /* Main Colors */
    :root {
        --primary-color: #cb2786; /* physique: sportive.inspiration refresh (main color) */
        --secondary-color: #00617a; /* relationship: interactive care expressive competitive */
        --accent-color: #f4b704; /* reflection: sporty youthful */
        --text-dark: #333;
        --text-light: #f8f9fa;
    }

    /* General Styling for a Sporty, Youthful, and Active Vibe */
    body {
        font-family: 'Poppins', sans-serif; /* Example font, consider adding to master layout */
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
    }

    .btn-primary-kersa:hover {
        background-color: darken(var(--primary-color), 10%); /* Requires Sass/Less or a dynamic CSS var */
        border-color: darken(var(--primary-color), 10%);
    }

    .btn-outline-primary-kersa {
        color: var(--primary-color);
        border-color: var(--primary-color);
        background-color: transparent;
    }

    .btn-outline-primary-kersa:hover {
        background-color: var(--primary-color);
        color: white;
    }

    .navbar .nav-link.active,
    .navbar .nav-link:hover {
        color: var(--primary-color) !important;
    }

    /* Gallery Specific Styles */
    .gallery-header {
        background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
        color: var(--text-light);
        padding: 60px 0;
        text-align: center;
        border-bottom-left-radius: 50px; /* Youthful, dynamic shape */
        border-bottom-right-radius: 50px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .gallery-item-card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background-color: #ffffff;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        display: flex; /* Use flexbox for layout */
        flex-direction: column; /* Stack elements vertically */
    }

    .gallery-item-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }

    .gallery-thumbnail {
        height: 250px; /* Fixed height for consistent look */
        width: 100%;
        object-fit: cover;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }

    .gallery-content {
        padding: 20px;
        flex-grow: 1; /* Allows content to take available space */
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
        /* Limit description lines */
        display: -webkit-box;
        -webkit-line-clamp: 3; /* Show 3 lines */
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

    .gallery-views {
        font-size: 0.85rem;
        color: #888;
        display: flex;
        align-items: center;
    }

    .gallery-views i {
        margin-right: 5px;
        color: var(--accent-color);
    }

    /* Filter/Sort Dropdown */
    .filter-sort-container {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        margin-bottom: 30px;
    }

    .filter-sort-container .form-select {
        border-color: var(--secondary-color);
        color: var(--secondary-color);
        border-radius: 8px;
        padding: 8px 15px;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2300617a' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e"); /* Custom arrow for select */
    }

    .filter-sort-container label {
        margin-right: 15px;
        font-weight: 600;
        color: var(--secondary-color);
    }


    /* Pagination */
    .pagination .page-item .page-link {
        border-radius: 8px;
        margin: 0 5px;
        min-width: 40px;
        text-align: center;
        transition: all 0.3s ease;
        border: 1px solid var(--secondary-color);
        color: var(--secondary-color);
        font-weight: 500;
    }

    .pagination .page-item.active .page-link {
        background-color: var(--secondary-color);
        border-color: var(--secondary-color);
        color: white;
    }

    .pagination .page-item .page-link:hover:not(.active) {
        background-color: var(--accent-color);
        border-color: var(--accent-color);
        color: white;
    }
</style>

<section class="gallery-header">
    <div class="container">
        <h2 class="display-4 fw-bold mb-3">Sportive Moments, Inspiring Visions</h2>
        <p class="lead">Dive into our collection of dynamic and youthful galleries.</p>
    </div>
</section>

<div class="container py-5 gallery-page">

    <div class="filter-sort-container">
        <label for="sort-select">Sort by:</label>
        <select id="sort-select" class="form-select w-auto" onchange="location = this.value;">
            <option value="{{ request()->url() }}?sort=latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
            <option value="{{ request()->url() }}?sort=oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
            <option value="{{ request()->url() }}?sort=popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
        </select>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4"> {{-- Grid for galleries --}}
        @forelse ($galleries as $gallery)
        <div class="col">
            <div class="card gallery-item-card h-100">
                <img src="{{ asset('storage/' . $gallery->thumbnail) }}" class="card-img-top gallery-thumbnail" alt="{{ $gallery->title }}">
                <div class="card-body gallery-content">
                    <h5 class="card-title gallery-title">{{ $gallery->title }}</h5>
                    <div class="gallery-meta">
                        <p class="card-text mb-1"><strong>Author:</strong> {{ $gallery->author }}</p>
                        <p class="card-text mb-1"><strong>Tournament:</strong> {{ $gallery->tournament_name }}</p>
                    </div>
                    <p class="card-text gallery-description">{{ $gallery->description }}</p>
                </div>
                <div class="gallery-footer">
                    <span class="gallery-views"><i class="fas fa-eye"></i> {{ number_format($gallery->views) }} views</span>
                    {{-- UBAH INI: Gunakan SLUG untuk tautan detail galeri --}}
                    <a href="{{ route('front.galleries.show', $gallery->slug) }}" class="btn btn-outline-primary-kersa btn-sm">View Details</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <p class="text-center text-secondary">No galleries to display yet. Check back soon!</p>
        </div>
        @endforelse
    </div>

    <div class="mt-5 d-flex justify-content-center">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($galleries->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $galleries->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                @endif

                {{-- Pagination Elements --}}
                @php
                    $currentPage = $galleries->currentPage();
                    $lastPage = $galleries->lastPage();
                    $pageRange = 5;
                    $startPage = max(1, $currentPage - floor($pageRange / 2));
                    $endPage = min($lastPage, $currentPage + floor($pageRange / 2));

                    if ($currentPage < floor($pageRange / 2)) {
                        $endPage = min($lastPage, $pageRange);
                    }
                    if ($currentPage > $lastPage - floor($pageRange / 2)) {
                        $startPage = max(1, $lastPage - $pageRange + 1);
                    }
                @endphp

                @for ($i = $startPage; $i <= $endPage; $i++)
                    <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                        <a class="page-link" href="{{ $galleries->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor

                {{-- Next Page Link --}}
                @if ($galleries->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $galleries->nextPageUrl() }}" rel="next">&raquo;</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                @endif
            </ul>
        </nav>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // You can add JavaScript here if needed for interactive elements
    // For example, dynamic loading or more complex filtering
</script>
@endpush
