@extends('layouts.master_nav')

@section('title', 'Hasil Pencarian' . ($query ? ' - ' . $query : '') . ' | KAMCUP')

@section('content')
<div class="container py-5" style="margin-top: 120px;">
    <div class="row">
        <div class="col-12">
            <!-- Search Header -->
            <div class="search-header mb-4">
                @if($query)
                    <h2 class="fw-bold mb-2">
                        <span class="main-text">Hasil pencarian untuk:</span> 
                        <span class="highlight-text">"{{ $query }}"</span>
                    </h2>
                    <p class="text-muted mb-0">Ditemukan {{ $total_results }} hasil</p>
                @else
                    <h2 class="fw-bold mb-2">
                        <span class="main-text">Pencarian</span> <span class="highlight-text">KAMCUP</span>
                    </h2>
                    <p class="text-muted mb-0">Masukkan kata kunci untuk mencari berita, event, atau galeri</p>
                @endif
            </div>

            <!-- Search Bar -->
            <div class="search-bar-container mb-5">
                <form action="{{ route('search') }}" method="GET" class="search-form-page">
                    <div class="search-input-group">
                        <input type="text" name="q" class="form-control search-input-large" 
                               placeholder="Cari berita, event, galeri..." value="{{ $query }}" 
                               autocomplete="off" autofocus>
                        <button type="submit" class="btn search-btn-large">
                            <i class="bi bi-search"></i> Cari
                        </button>
                    </div>
                </form>
            </div>

            <!-- Search Results -->
            @if($query && $total_results > 0)
                <div class="search-results">
                    <h4 class="mb-4">Hasil Pencarian ({{ $total_results }})</h4>
                    <div class="row g-4">
                        @foreach($results as $result)
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="search-result-card">
                                    <a href="{{ $result['url'] }}" class="text-decoration-none">
                                        <div class="card h-100 border-0 shadow-sm search-card-hover">
                                            @if($result['image'])
                                                <div class="search-card-image">
                                                    <img src="{{ $result['image'] }}" 
                                                         class="card-img-top" 
                                                         alt="{{ $result['title'] }}"
                                                         style="height: 200px; object-fit: cover;">
                                                    <span class="search-card-badge">{{ $result['category'] }}</span>
                                                </div>
                                            @endif
                                            <div class="card-body">
                                                <h5 class="card-title">{{ Str::limit($result['title'], 60) }}</h5>
                                                <p class="card-text text-muted">
                                                    {{ Str::limit($result['description'], 100) }}
                                                </p>
                                                <div class="search-card-meta">
                                                    <small class="text-muted">
                                                        <i class="bi bi-calendar-event me-1"></i>
                                                        {{ $result['date'] }}
                                                        @if(isset($result['location']))
                                                            <span class="ms-2">
                                                                <i class="bi bi-geo-alt me-1"></i>
                                                                {{ Str::limit($result['location'], 20) }}
                                                            </span>
                                                        @endif
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @elseif($query && $total_results == 0)
                <!-- No Results -->
                <div class="no-results-container text-center py-5">
                    <div class="no-results-icon mb-4">
                        <i class="bi bi-search" style="font-size: 4rem; color: #6c757d;"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Tidak ada hasil ditemukan</h4>
                    <p class="text-muted mb-4">
                        Maaf, kami tidak dapat menemukan hasil untuk pencarian "<strong>{{ $query }}</strong>"
                    </p>
                    <div class="search-suggestions">
                        <p class="fw-medium mb-3">Coba tips berikut:</p>
                        <ul class="list-unstyled text-muted">
                            <li class="mb-2"><i class="bi bi-check2 me-2 text-primary"></i>Periksa ejaan kata kunci</li>
                            <li class="mb-2"><i class="bi bi-check2 me-2 text-primary"></i>Gunakan kata kunci yang lebih umum</li>
                            <li class="mb-2"><i class="bi bi-check2 me-2 text-primary"></i>Coba kata sinonim atau variasi kata</li>
                            <li class="mb-2"><i class="bi bi-check2 me-2 text-primary"></i>Kurangi jumlah kata kunci</li>
                        </ul>
                    </div>
                    <div class="popular-searches mt-4">
                        <p class="fw-medium mb-3">Pencarian populer:</p>
                        <div class="d-flex flex-wrap gap-2 justify-content-center">
                            <a href="{{ route('search', ['q' => 'volleyball']) }}" class="btn btn-outline-primary btn-sm">Volleyball</a>
                            <a href="{{ route('search', ['q' => 'turnamen']) }}" class="btn btn-outline-primary btn-sm">Turnamen</a>
                            <a href="{{ route('search', ['q' => 'kamcup']) }}" class="btn btn-outline-primary btn-sm">KAMCUP</a>
                            <a href="{{ route('search', ['q' => 'event']) }}" class="btn btn-outline-primary btn-sm">Event</a>
                        </div>
                    </div>
                </div>
            @else
                <!-- Default Search Page (no query) -->
                <div class="default-search-container">
                    <div class="row">
                        <div class="col-lg-8 mx-auto">
                            <div class="search-categories mb-5">
                                <h4 class="fw-bold mb-4 text-center">Kategori Pencarian</h4>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <a href="{{ route('front.articles') }}" class="text-decoration-none">
                                            <div class="search-category-card">
                                                <div class="text-center p-4">
                                                    <i class="bi bi-newspaper display-4 text-primary mb-3"></i>
                                                    <h5 class="fw-bold">Berita</h5>
                                                    <p class="text-muted small">Berita terbaru seputar volleyball dan turnamen</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="{{ route('front.events.index') }}" class="text-decoration-none">
                                            <div class="search-category-card">
                                                <div class="text-center p-4">
                                                    <i class="bi bi-calendar-event display-4 text-success mb-3"></i>
                                                    <h5 class="fw-bold">Event</h5>
                                                    <p class="text-muted small">Turnamen dan event yang akan datang</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="{{ route('front.galleries') }}" class="text-decoration-none">
                                            <div class="search-category-card">
                                                <div class="text-center p-4">
                                                    <i class="bi bi-images display-4 text-warning mb-3"></i>
                                                    <h5 class="fw-bold">Galeri</h5>
                                                    <p class="text-muted small">Foto dan video dokumentasi kegiatan</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Search Page Styles */
.highlight-text { color: #F4B704; }
.main-text { color: #0F62FF; }

.search-bar-container {
    max-width: 600px;
    margin: 0 auto;
}

.search-input-group {
    display: flex;
    border-radius: 50px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.search-input-large {
    border: none;
    padding: 15px 20px;
    font-size: 16px;
    flex: 1;
    outline: none;
    border-right: none;
}

.search-input-large:focus {
    box-shadow: none;
    outline: none;
}

.search-btn-large {
    background: linear-gradient(135deg, #0F62FF 0%, #1e5bbf 100%);
    border: none;
    color: white;
    padding: 15px 25px;
    font-weight: 500;
    transition: all 0.3s ease;
    min-width: 100px;
}

.search-btn-large:hover {
    background: linear-gradient(135deg, #1e5bbf 0%, #0F62FF 100%);
    color: white;
    transform: translateY(-1px);
}

.search-result-card {
    transition: transform 0.3s ease;
}

.search-card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
}

.search-card-image {
    position: relative;
    overflow: hidden;
}

.search-card-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    background: rgba(15, 98, 255, 0.9);
    color: white;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
}

.search-card-meta {
    border-top: 1px solid #f8f9fa;
    padding-top: 10px;
    margin-top: 10px;
}

.search-category-card {
    background: white;
    border: 2px solid #e9ecef;
    border-radius: 15px;
    transition: all 0.3s ease;
    height: 100%;
}

.search-category-card:hover {
    border-color: #0F62FF;
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(15, 98, 255, 0.1);
}

.no-results-container {
    max-width: 500px;
    margin: 0 auto;
}

.popular-searches .btn {
    margin: 2px;
}

/* Responsive */
@media (max-width: 768px) {
    .search-input-group {
        flex-direction: column;
        border-radius: 15px;
    }
    
    .search-input-large {
        border-radius: 15px 15px 0 0;
        border-right: 1px solid #dee2e6;
    }
    
    .search-btn-large {
        border-radius: 0 0 15px 15px;
        padding: 12px 20px;
    }
    
    .search-category-card {
        margin-bottom: 15px;
    }
}

/* Animation for search results */
.search-result-card {
    opacity: 0;
    animation: fadeInUp 0.6s ease forwards;
}

.search-result-card:nth-child(1) { animation-delay: 0.1s; }
.search-result-card:nth-child(2) { animation-delay: 0.2s; }
.search-result-card:nth-child(3) { animation-delay: 0.3s; }

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto focus on search input when page loads
    const searchInput = document.querySelector('.search-input-large');
    if (searchInput && !searchInput.value) {
        searchInput.focus();
    }
    
    // Search form submit handler
    const searchForm = document.querySelector('.search-form-page');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            const input = this.querySelector('input[name="q"]');
            if (!input.value.trim()) {
                e.preventDefault();
                input.focus();
                return false;
            }
        });
    }
    
    console.log('Search page initialized');
});
</script>
@endpush