{{-- resources/views/front/search_results.blade.php --}}

@extends('layouts.master_nav') {{-- Sesuaikan dengan layout utama Anda --}}

@section('title', 'Hasil Pencarian untuk "' . e($query) . '"')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-10 mx-auto">

            <h1 class="mb-4">Hasil Pencarian untuk: <span class="text-primary">"{{ e($query) }}"</span></h1>

            {{-- Tampilkan total hasil --}}
            @if($totalResults > 0)
                <p class="text-muted mb-4">Ditemukan {{ $totalResults }} hasil total.</p>

                {{-- ARTICLES SECTION --}}
                @if($articles->count() > 0)
                    <div class="mb-5">
                        <h3 class="mb-3 border-bottom pb-2">
                            <i class="bi bi-newspaper me-2"></i>Artikel ({{ $articles->total() }})
                        </h3>
                        <div class="row">
                            @foreach($articles as $article)
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100">
                                        @if($article->thumbnail)
                                            <img src="{{ asset('storage/' . $article->thumbnail) }}" 
                                                 class="card-img-top" style="height: 200px; object-fit: cover;"
                                                 alt="{{ $article->title }}">
                                        @endif
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title">
                                                <a href="{{ route('front.articles.show', $article->slug) }}" 
                                                   class="text-decoration-none">
                                                    {{ $article->title }}
                                                </a>
                                            </h5>
                                            <p class="card-text flex-grow-1">
                                                {{ Str::limit($article->description, 150) }}
                                            </p>
                                            <div class="mt-auto">
                                                <small class="text-muted">
                                                    <i class="bi bi-person me-1"></i>{{ $article->author ?? 'Admin' }}
                                                    <span class="mx-2">•</span>
                                                    <i class="bi bi-calendar me-1"></i>{{ $article->created_at->format('d M Y') }}
                                                    <span class="mx-2">•</span>
                                                    <i class="bi bi-eye me-1"></i>{{ $article->views }} views
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Pagination untuk Articles --}}
                        <div class="mt-4">
                            {{ $articles->appends(['query' => $query])->links() }}
                        </div>
                    </div>
                @endif

                {{-- EVENTS SECTION --}}
                @if($events->count() > 0)
                    <div class="mb-5">
                        <h3 class="mb-3 border-bottom pb-2">
                            <i class="bi bi-calendar-event me-2"></i>Events/Tournament ({{ $events->count() }})
                        </h3>
                        <div class="row">
                            @foreach($events as $event)
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100">
                                        @if($event->thumbnail)
                                            <img src="{{ asset('storage/' . $event->thumbnail) }}" 
                                                 class="card-img-top" style="height: 200px; object-fit: cover;"
                                                 alt="{{ $event->title }}">
                                        @endif
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title">
                                                <a href="{{ route('front.events.show', $event->slug) }}" 
                                                   class="text-decoration-none">
                                                    {{ $event->title }}
                                                </a>
                                            </h5>
                                            <div class="mt-auto">
                                                <p class="card-text mb-2">
                                                    <i class="bi bi-geo-alt me-1"></i>{{ $event->location }}
                                                </p>
                                                <p class="card-text mb-2">
                                                    <i class="bi bi-calendar me-1"></i>
                                                    {{ \Carbon\Carbon::parse($event->registration_start)->format('d M') }} - 
                                                    {{ \Carbon\Carbon::parse($event->registration_end)->format('d M Y') }}
                                                </p>
                                                <p class="card-text">
                                                    <i class="bi bi-people me-1"></i>{{ ucfirst($event->gender_category) }}
                                                    <span class="badge bg-{{ $event->status == 'registration' ? 'success' : ($event->status == 'ongoing' ? 'primary' : 'secondary') }} ms-2">
                                                        {{ ucfirst($event->status) }}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- GALLERIES SECTION --}}
                @if($galleries->count() > 0)
                    <div class="mb-5">
                        <h3 class="mb-3 border-bottom pb-2">
                            <i class="bi bi-images me-2"></i>Galeri ({{ $galleries->count() }})
                        </h3>
                        <div class="row">
                            @foreach($galleries as $gallery)
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100">
                                        @if($gallery->thumbnail)
                                            <img src="{{ asset('storage/' . $gallery->thumbnail) }}" 
                                                 class="card-img-top" style="height: 200px; object-fit: cover;"
                                                 alt="{{ $gallery->title }}">
                                        @endif
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title">
                                                <a href="{{ route('front.galleries.show', $gallery->slug) }}" 
                                                   class="text-decoration-none">
                                                    {{ $gallery->title }}
                                                </a>
                                            </h5>
                                            <p class="card-text flex-grow-1">
                                                {{ Str::limit($gallery->description, 150) }}
                                            </p>
                                            <div class="mt-auto">
                                                <small class="text-muted">
                                                    @if($gallery->tournament_name)
                                                        <i class="bi bi-trophy me-1"></i>{{ $gallery->tournament_name }}
                                                        <br>
                                                    @endif
                                                    <i class="bi bi-person me-1"></i>{{ $gallery->author ?? 'Admin' }}
                                                    <span class="mx-2">•</span>
                                                    <i class="bi bi-calendar me-1"></i>{{ $gallery->created_at->format('d M Y') }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            @else
                {{-- Jika tidak ada hasil --}}
                <div class="alert alert-warning text-center mt-5" role="alert">
                    <i class="bi bi-search display-1 text-muted mb-3"></i>
                    <h4 class="alert-heading">Tidak Ada Hasil Ditemukan</h4>
                    <p>Maaf, kami tidak dapat menemukan hasil apa pun yang cocok dengan pencarian Anda untuk <strong>"{{ e($query) }}"</strong>.</p>
                    <hr>
                    <p class="mb-3">Saran untuk pencarian yang lebih baik:</p>
                    <ul class="list-unstyled">
                        <li>• Periksa ejaan kata kunci Anda</li>
                        <li>• Coba gunakan kata kunci yang lebih umum</li>
                        <li>• Gunakan sinonim atau kata-kata alternatif</li>
                        <li>• Kurangi jumlah kata dalam pencarian</li>
                    </ul>
                    <div class="mt-4">
                        <a href="{{ route('front.articles') }}" class="btn btn-primary me-2">
                            <i class="bi bi-newspaper me-1"></i>Lihat Semua Artikel
                        </a>
                        <a href="{{ route('front.events.index') }}" class="btn btn-success me-2">
                            <i class="bi bi-calendar-event me-1"></i>Lihat Semua Event
                        </a>
                        <a href="{{ route('front.galleries') }}" class="btn btn-info">
                            <i class="bi bi-images me-1"></i>Lihat Semua Galeri
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.card {
    transition: transform 0.2s ease-in-out;
    border: 1px solid #dee2e6;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.card-title a {
    color: #333;
}

.card-title a:hover {
    color: #0d6efd;
}

.border-bottom {
    border-color: #dee2e6 !important;
}

.bi {
    color: #6c757d;
}
</style>
@endpush