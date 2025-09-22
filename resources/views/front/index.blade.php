@extends('../layouts/master')

{{-- Memberi penanda 'home-page' ke tag <body> di master layout --}}
@section('body-class', 'home-page')

@section('content')
    <section class="position-relative hero-section">
        <div class="position-relative vh-100 d-flex align-items-center overflow-hidden">
            <img src="{{ asset('assets/img/jpn.jpg') }}"
                class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover z-1" alt="Volleyball Action Hero Image">
            <div class="container position-relative text-white z-2 text-center hero-content">
                <h1 class="display-3 fw-bold mb-4 hero-title"><br>Energi Sportif, Kemudahan Finansial!</h1>
                <p class="lead mb-5 hero-description">
                    Bergabunglah dengan KAMCUP dan Bale by BTN dalam mewujudkan semangat <span class="highlight-text">
                        olahraga, inovasi, dan kekeluargaan.</span> Kami berkomitmen untuk menciptakan <span
                        class="highlight-text">komunitas</span> <span class="highlight-text">aktif,</span> suportif, dan
                    penuh<span class="highlight-text"> pertumbuhan </span> para generasi muda visioner.
                </p>
                <a href="{{ route('front.events.index') }}"
                    class="btn btn-lg fw-bold px-5 py-3 rounded-pill hero-btn">JELAJAHI PROMO & EVENT</a>
            </div>
        </div>
    </section>

    {{-- Match Terdekat --}}
    @if ($next_match)
        <div class="container py-4 scroll-animate" data-animation="fadeInUp">
            <a href="{{ route('front.events.show', $next_match->tournament->slug) }}" class="text-decoration-none">
                <div class="card bg-light border-0 shadow-sm card-hover-zoom" style="height: auto;">
                    <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-center">
                        <h5 class="card-title fw-bold mb-2 mb-md-0 me-md-3 text-center text-md-start article-text">
                            <span class="main-text">Match</span> <span class="highlight-text">Terdekat:</span>
                            {{ $next_match->tournament->title }}
                            <br>
                            <small class="text-muted d-block mt-1" style="font-size: 0.85rem;">
                                {{ $next_match->team1->name }} vs {{ $next_match->team2->name }}
                                @if ($next_match->stage)
                                    | {{ $next_match->stage }}
                                @endif
                            </small>
                        </h5>
                        <div class="text-center text-md-end">
                            <p class="mb-1 small text-muted article-text">
                                <i class="bi bi-calendar me-1"></i>
                                {{ \Carbon\Carbon::parse($next_match->match_datetime)->format('d M Y, H:i') }}
                            </p>
                            @if ($next_match->location)
                                <p class="mb-1 small text-muted article-text">
                                    <i class="bi bi-geo-alt me-1"></i>
                                    {{ Str::limit($next_match->location, 30) }}
                                </p>
                            @endif
                            <a href="{{ route('front.events.show', $next_match->tournament->slug) }}"
                                class="btn btn-sm btn-outline-primary mt-2 mt-md-0">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endif

    {{-- Match Terakhir --}}
    @if ($last_match)
        <div class="container py-4 scroll-animate" data-animation="fadeInUp">
            <div class="card bg-light border-0 shadow-sm card-hover-zoom" style="height: auto;">
                <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <h5 class="card-title fw-bold mb-2 mb-md-0 me-md-3 text-center text-md-start article-text">
                        <span class="main-text">Match</span> <span class="highlight-text">Terakhir:</span>
                        {{ $last_match->tournament->title }}
                        <br>
                        <small class="text-muted d-block mt-1" style="font-size: 0.85rem;">
                            {{ $last_match->team1->name }} <span
                                class="highlight-text fw-bold">{{ $last_match->team1_score }}</span>
                            -
                            <span class="highlight-text fw-bold">{{ $last_match->team2_score }}</span>
                            {{ $last_match->team2->name }}
                            @if ($last_match->winner)
                                | 🏆 {{ $last_match->winner->name }}
                            @endif
                        </small>
                    </h5>
                    <div class="text-center text-md-end">
                        <p class="mb-1 small text-muted article-text">
                            <i class="bi bi-clock me-1"></i>
                            {{ \Carbon\Carbon::parse($last_match->match_datetime)->format('d M Y, H:i') }}
                        </p>
                        @if ($last_match->location)
                            <p class="mb-1 small text-muted article-text">
                                <i class="bi bi-geo-alt me-1"></i>
                                {{ Str::limit($last_match->location, 30) }}
                            </p>
                        @endif
                        <a href="{{ route('front.events.show', $last_match->tournament->slug) }}"
                            class="btn btn-sm btn-outline-primary mt-2 mt-md-0">Lihat Detail</a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Artikel Terbaru --}}
    <div class="container py-5 scroll-animate" data-animation="fadeInUp">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold mb-0 section-title"><span class="main-text">Artikel</span> <span
                    class="highlight-text">Terbaru</span></h3>
            <a href="{{ route('front.articles') }}" class="btn btn-outline-dark lihat-semua-btn px-4">Lihat semuanya</a>
        </div>
        <div id="latestArticlesCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-inner">
                @forelse ($latest_articles->chunk($chunk_size) as $chunkIndex => $chunk)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <div class="row gx-3 gy-3">
                            @foreach ($chunk as $article)
                                <div class="col-12 col-md-6 col-lg-4 scroll-animate" data-animation="fadeInUp"
                                    data-delay="{{ $loop->index * 100 }}">
                                    <a href="{{ route('front.articles.show', $article->slug) }}"
                                        class="text-decoration-none">
                                        <div class="card card-hover-zoom border-0 rounded-3 overflow-hidden h-100">
                                            <div class="ratio ratio-16x9">
                                                <img src="{{ asset('storage/' . $article->thumbnail) }}"
                                                    class="img-fluid object-fit-cover w-100 h-100"
                                                    alt="{{ $article->title }}">
                                            </div>
                                            <div class="card-body d-flex flex-column px-3 py-3">
                                                <h5 class="card-title fw-semibold mb-2">
                                                    {{ Str::limit($article->title, 60) }}</h5>
                                                <p class="card-text text-muted mb-0 flex-grow-1">
                                                    {{ Str::limit($article->description, 80) }}</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="carousel-item active">
                        <div class="col-12 text-center py-5">
                            <p class="text-muted">Artikel terbaru akan segera hadir!</p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Carousel Controls untuk Desktop --}}
            <button class="carousel-control-prev d-none d-md-flex" type="button" data-bs-target="#latestArticlesCarousel"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next d-none d-md-flex" type="button" data-bs-target="#latestArticlesCarousel"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>

            {{-- Carousel Indicators untuk Mobile --}}
            @if ($latest_articles->count() > $chunk_size)
                <div class="carousel-indicators d-md-none position-relative mt-3 mb-0">
                    @foreach ($latest_articles->chunk($chunk_size) as $chunkIndex => $chunk)
                        <button type="button" data-bs-target="#latestArticlesCarousel"
                            data-bs-slide-to="{{ $chunkIndex }}" class="{{ $chunkIndex === 0 ? 'active' : '' }}"
                            aria-current="{{ $chunkIndex === 0 ? 'true' : 'false' }}"
                            aria-label="Slide {{ $chunkIndex + 1 }}"></button>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Artikel Populer --}}
    <div class="container py-5 scroll-animate" data-animation="fadeInUp">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold mb-0 section-title"><span class="main-text">Artikel</span> <span
                    class="highlight-text">Populer</span></h3>
            <a href="{{ route('front.articles') }}" class="btn btn-outline-dark lihat-semua-btn px-4">Lihat semuanya</a>
        </div>
        <div id="popularArticlesCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-inner">
                @forelse ($popular_articles->chunk($chunk_size) as $chunkIndex => $chunk)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <div class="row gx-3 gy-3">
                            @foreach ($chunk as $article)
                                <div class="col-12 col-md-6 col-lg-4 scroll-animate" data-animation="fadeInUp"
                                    data-delay="{{ $loop->index * 100 }}">
                                    <a href="{{ route('front.articles.show', $article->slug) }}"
                                        class="text-decoration-none">
                                        <div class="card card-hover-zoom border-0 rounded-3 overflow-hidden h-100">
                                            <div class="ratio ratio-16x9">
                                                <img src="{{ asset('storage/' . $article->thumbnail) }}"
                                                    class="img-fluid object-fit-cover w-100 h-100"
                                                    alt="{{ $article->title }}">
                                            </div>
                                            <div class="card-body d-flex flex-column px-3 py-3">
                                                <h5 class="card-title fw-semibold mb-2">
                                                    {{ Str::limit($article->title, 60) }}</h5>
                                                <p class="card-text text-muted mb-0 flex-grow-1">
                                                    {{ Str::limit($article->description, 80) }}</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="carousel-item active">
                        <div class="col-12 text-center py-5">
                            <p class="text-muted">Artikel populer akan segera hadir!</p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Carousel Controls untuk Desktop --}}
            <button class="carousel-control-prev d-none d-md-flex" type="button"
                data-bs-target="#popularArticlesCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next d-none d-md-flex" type="button"
                data-bs-target="#popularArticlesCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>

            {{-- Carousel Indicators untuk Mobile --}}
            @if ($popular_articles->count() > $chunk_size)
                <div class="carousel-indicators d-md-none position-relative mt-3 mb-0">
                    @foreach ($popular_articles->chunk($chunk_size) as $chunkIndex => $chunk)
                        <button type="button" data-bs-target="#popularArticlesCarousel"
                            data-bs-slide-to="{{ $chunkIndex }}" class="{{ $chunkIndex === 0 ? 'active' : '' }}"
                            aria-current="{{ $chunkIndex === 0 ? 'true' : 'false' }}"
                            aria-label="Slide {{ $chunkIndex + 1 }}"></button>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Card Section for Registrations --}}
    <div class="container py-5 scroll-animate" data-animation="fadeInUp">
        <div class="row row-cols-1 row-cols-md-3 g-4 text-center">
            <div class="col scroll-animate" data-animation="fadeInLeft" data-delay="100">
                <div class="card h-100 border-0 rounded-3 overflow-hidden shadow-sm p-3 p-md-4 d-flex flex-column justify-content-center align-items-center"
                    style="background-color: var(--collab-primary); color: var(--text-light); position: relative;">
                    <i class="bi bi-people-fill display-4 mb-3" style="color: var(--collab-highlight);"></i>
                    <h4 class="card-title fw-bold mb-3">Daftar Sebagai Tim</h4>
                    <p class="card-text mb-4">Gabungkan tim Anda dan raih kemenangan bersama KAMCUP!</p>
                    <a href="{{ route('team.create') }}" class="btn fw-bold px-4 py-2 rounded-pill registration-btn"
                        style="background-color: #F4B704; border-color: #F4B704; color: #212529; position: relative; z-index: 100; text-decoration: none;">
                        DAFTAR SEKARANG
                    </a>
                </div>
            </div>
            <div class="col scroll-animate" data-animation="fadeInUp" data-delay="200">
                <div class="card h-100 border-0 rounded-3 overflow-hidden shadow-sm p-3 p-md-4 d-flex flex-column justify-content-center align-items-center"
                    style="background-color: var(--collab-primary); color: var(--text-light); position: relative;">
                    <i class="bi bi-house-door-fill display-4 mb-3" style="color: var(--collab-highlight);"></i>
                    <h4 class="card-title fw-bold mb-3">Daftar Sebagai Tuan Rumah</h4>
                    <p class="card-text mb-4">Siapkan arena terbaik Anda dan selenggarakan turnamen seru!</p>
                    <a href="{{ route('host-request.create') }}"
                        class="btn fw-bold px-4 py-2 rounded-pill registration-btn"
                        style="background-color: #F4B704; border-color: #F4B704; color: #212529; position: relative; z-index: 100; text-decoration: none;">
                        JADI TUAN RUMAH
                    </a>
                </div>
            </div>
            <div class="col scroll-animate" data-animation="fadeInRight" data-delay="300">
                <div class="card h-100 border-0 rounded-3 overflow-hidden shadow-sm p-3 p-md-4 d-flex flex-column justify-content-center align-items-center"
                    style="background-color: var(--collab-primary); color: var(--text-light); position: relative;">
                    <i class="bi bi-heart-fill display-4 mb-3" style="color: var(--collab-highlight);"></i>
                    <h4 class="card-title fw-bold mb-3">Daftar Sebagai Donatur</h4>
                    <p class="card-text mb-4">Dukung perkembangan olahraga voli dan komunitas KAMCUP!</p>
                    @auth
                        <a href="{{ route('donations.create') }}" class="btn fw-bold px-4 py-2 rounded-pill registration-btn"
                            style="background-color: #F4B704; border-color: #F4B704; color: #212529; position: relative; z-index: 100; text-decoration: none;">
                            BERI DONASI
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn fw-bold px-4 py-2 rounded-pill registration-btn"
                            style="background-color: #F4B704; border-color: #F4B704; color: #212529; position: relative; z-index: 100; text-decoration: none;">
                            DONASI
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    {{-- Upcoming Events --}}
    <div class="container py-5 mb-3 scroll-animate" data-animation="fadeInUp">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold section-title"><span class="main-text">UPCOMING</span> <span
                    class="highlight-text">EVENT</span></h3>
            <a href="{{ route('front.events.index') }}" class="btn btn-outline-dark see-all-btn px-4 rounded-pill">Lihat
                semuanya</a>
        </div>
        <div id="upcomingEventsCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-inner">
                @forelse ($events->chunk($chunk_size) as $chunk)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <div class="row gx-3 gy-3">
                            @foreach ($chunk as $event)
                                <div class="col-12 col-md-6 col-lg-4 scroll-animate" data-animation="fadeInUp"
                                    data-delay="{{ $loop->index * 100 }}">
                                    <a href="{{ route('front.events.show', $event->slug) }}"
                                        class="text-decoration-none">
                                        <div class="card card-hover-zoom border-0 rounded-3 overflow-hidden h-100">
                                            <div class="ratio ratio-16x9">
                                                <img src="{{ asset('storage/' . $event->thumbnail) }}"
                                                    class="img-fluid object-fit-cover w-100 h-100"
                                                    alt="{{ $event->title }}">
                                            </div>
                                            <div class="card-body d-flex flex-column px-3 py-3">
                                                <h5 class="card-title fw-semibold mb-2">
                                                    {{ Str::limit($event->title, 60) }}</h5>
                                                <div class="event-meta mb-auto">
                                                    <p class="small text-muted mb-1 d-flex align-items-center">
                                                        <i class="bi bi-calendar me-1"></i>
                                                        {{ \Carbon\Carbon::parse($event->registration_start)->format('d M') }}
                                                        -
                                                        {{ \Carbon\Carbon::parse($event->registration_end)->format('d M Y') }}
                                                    </p>
                                                    <p class="small text-muted mb-1 d-flex align-items-center">
                                                        <i class="bi bi-geo-alt me-1"></i>
                                                        {{ Str::limit($event->location, 25) }}
                                                    </p>
                                                    <div class="d-flex align-items-center justify-content-between mt-2">
                                                        <span class="small text-muted">
                                                            <i class="bi bi-gender-ambiguous me-1"></i>
                                                            {{ $event->gender_category }}
                                                        </span>
                                                        @php
                                                            $statusClass = '';
                                                            switch ($event->status) {
                                                                case 'completed':
                                                                    $statusClass = 'bg-success text-white';
                                                                    break;
                                                                case 'ongoing':
                                                                    $statusClass = 'bg-primary text-white';
                                                                    break;
                                                                case 'registration':
                                                                    $statusClass = 'bg-warning text-dark';
                                                                    break;
                                                                default:
                                                                    $statusClass = 'bg-secondary text-white';
                                                                    break;
                                                            }
                                                        @endphp
                                                        <span class="badge {{ $statusClass }} px-2 py-1"
                                                            style="font-size: 0.7rem;">
                                                            {{ ucfirst($event->status) }}
                                                        </span>
                                                    </div>
                                                    <p class="event-detail-text">Detail Event & Daftar</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="carousel-item active">
                        <div class="col-12 text-center py-5">
                            <p class="text-muted">Akan segera hadir! Nantikan event-event seru dari kami.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Carousel Controls untuk Desktop --}}
            <button class="carousel-control-prev d-none d-md-flex" type="button"
                data-bs-target="#upcomingEventsCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next d-none d-md-flex" type="button"
                data-bs-target="#upcomingEventsCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>

            {{-- Carousel Indicators untuk Mobile --}}
            @if ($events->count() > $chunk_size)
                <div class="carousel-indicators d-md-none position-relative mt-3 mb-0">
                    @foreach ($events->chunk($chunk_size) as $chunkIndex => $chunk)
                        <button type="button" data-bs-target="#upcomingEventsCarousel"
                            data-bs-slide-to="{{ $chunkIndex }}" class="{{ $chunkIndex === 0 ? 'active' : '' }}"
                            aria-current="{{ $chunkIndex === 0 ? 'true' : 'false' }}"
                            aria-label="Slide {{ $chunkIndex + 1 }}"></button>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- PERBAIKAN SPACING UNTUK MATERI PROMOSI --}}
    <div class="container pt-5 pb-3 mt-4 scroll-animate rounded-2" data-animation="fadeInUp">
        <div class="text-center sponsor-section-header mb-4">
            <p class="mb-0 fw-bold fs-4 promo-title">Materi Promosi BY
                @if (isset($sponsorData['xxl']) && $sponsorData['xxl']->isNotEmpty())
                    {{ $sponsorData['xxl']->first()->name }}
                @else
                    TBC
                @endif
            </p>
        </div>
    </div>

    <div class="container py-5 scroll-animate" data-animation="fadeInUp">
        <div class="carousel-container">
            <h2 class="carousel-title">Galeri</h2>
            <p class="carousel-subtitle"></p>
            <div class="carousel">
                <button class="nav-button left">&#10094;</button>
                <div class="carousel-images">
                    @forelse ($galleries as $gallery)
                        <a href="{{ route('front.galleries.show', $gallery->slug) }}" class="image-item scroll-animate"
                            data-animation="fadeInUp" data-delay="{{ $loop->index * 100 }}">
                            <img src="{{ asset('storage/' . $gallery->thumbnail) }}" alt="{{ $gallery->title }}" />
                            <h1>{{ Str::limit($gallery->title, 30) }}</h1>
                        </a>
                    @empty
                        <p class="text-center text-muted w-100">Galeri akan segera diisi dengan momen-momen seru!</p>
                    @endforelse
                </div>
                <button class="nav-button right">&#10095;</button>
            </div>
        </div>
    </div>

    <div class="text-center mt-4 mb-5 scroll-animate" data-animation="fadeInUp">
        <a href="{{ route('front.galleries') }}" class="btn btn-outline-dark lihat-semua-btn px-4">Lihat semuanya</a>
    </div>

    <div class="container-fluid py-5 scroll-animate" data-animation="fadeInUp" style="background-color: #0F62FF;">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold section-title text-white">PARTNER & SPONSOR KAMI</h3>
                <a href="#" class="btn px-4 rounded-pill fw-bold"
                    style="background-color: #ECBF00; color: #212529; border-color: #ECBF00;">MINAT JADI PARTNER?</a>
            </div>
            @php
                $sponsorSizes = [
                    'xxl' => [
                        'cols_md' => 2,
                        'cols_lg' => 2,
                        'max_width' => '220px',
                        'max_height' => '100px',
                        'p_size' => 4,
                        'limit' => 2,
                    ],
                    'xl' => [
                        'cols_md' => 3,
                        'cols_lg' => 3,
                        'max_width' => '180px',
                        'max_height' => '90px',
                        'p_size' => 4,
                        'limit' => 3,
                    ],
                    'l' => [
                        'cols_md' => 3,
                        'cols_lg' => 3,
                        'max_width' => '150px',
                        'max_height' => '75px',
                        'p_size' => 4,
                        'limit' => 3,
                    ],
                    'm' => [
                        'cols_md' => 6,
                        'cols_lg' => 6,
                        'max_width' => '100px',
                        'max_height' => '50px',
                        'p_size' => 3,
                        'limit' => 6,
                    ],
                    's' => [
                        'cols_md' => 6,
                        'cols_lg' => 6,
                        'max_width' => '80px',
                        'max_height' => '40px',
                        'p_size' => 3,
                        'limit' => 6,
                    ],
                ];
                $displayOrder = ['xxl', 'xl', 'l', 'm', 's'];
            @endphp
            @foreach ($displayOrder as $size)
                @if (isset($sponsorData[$size]) && $sponsorData[$size]->isNotEmpty())
                    <div class="row row-cols-1 row-cols-md-{{ $sponsorSizes[$size]['cols_md'] }} row-cols-lg-{{ $sponsorSizes[$size]['cols_lg'] }} g-4 text-center mb-4 @if ($size === 'xxl') justify-content-center @endif scroll-animate"
                        data-animation="fadeInUp" data-delay="{{ $loop->index * 100 }}">
                        @foreach ($sponsorData[$size]->take($sponsorSizes[$size]['limit']) as $sponsor)
                            <div class="col scroll-animate" data-animation="zoomIn"
                                data-delay="{{ $loop->parent->index * 100 + $loop->index * 50 }}">
                                <div
                                    class="p-{{ $sponsorSizes[$size]['p_size'] }} border rounded-3 sponsor-box sponsor-{{ $size }} h-100 d-flex flex-column justify-content-center align-items-center bg-white text-dark">
                                    <img src="{{ asset('storage/' . $sponsor->logo) }}" alt="{{ $sponsor->name }}"
                                        class="img-fluid mb-2"
                                        style="max-width: {{ $sponsorSizes[$size]['max_width'] }}; max-height: {{ $sponsorSizes[$size]['max_height'] }}; object-fit: contain;">
                                    <p class="fw-bold mb-0">{{ $sponsor->name }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family+Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --shadow-color-cf2585: #CF2585;
            --primary-blue: #0F62FF;
            --accent-yellow: #F4B704;
            --text-dark: #212529;
            --text-muted: #6c757d;
            --border-radius: 12px;
            --transition-fast: 0.3s ease;
            --transition-medium: 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        /* ===== SCROLL ANIMATIONS - OPTIMIZED ===== */
        .scroll-animate {
            opacity: 0;
            transform: translateY(50px);
            transition: all var(--transition-medium);
            will-change: transform, opacity;
        }

        .scroll-animate.animate {
            opacity: 1;
            transform: translateY(0);
        }

        /* Animation types */
        .scroll-animate[data-animation="fadeInUp"] { transform: translateY(50px); }
        .scroll-animate[data-animation="fadeInDown"] { transform: translateY(-50px); }
        .scroll-animate[data-animation="fadeInLeft"] { transform: translateX(-50px); }
        .scroll-animate[data-animation="fadeInRight"] { transform: translateX(50px); }
        .scroll-animate[data-animation="zoomIn"] { transform: scale(0.8) translateY(30px); }
        .scroll-animate[data-animation="slideInLeft"] { transform: translateX(-100px); }
        .scroll-animate[data-animation="slideInRight"] { transform: translateX(100px); }

        /* Animated state */
        .scroll-animate[data-animation="fadeInUp"].animate,
        .scroll-animate[data-animation="fadeInDown"].animate,
        .scroll-animate[data-animation="fadeInLeft"].animate,
        .scroll-animate[data-animation="fadeInRight"].animate,
        .scroll-animate[data-animation="slideInLeft"].animate,
        .scroll-animate[data-animation="slideInRight"].animate {
            transform: translateY(0) translateX(0);
        }

        .scroll-animate[data-animation="zoomIn"].animate {
            transform: scale(1) translateY(0);
        }

        /* Staggered delays */
        .scroll-animate[data-delay="100"] { transition-delay: 0.1s; }
        .scroll-animate[data-delay="200"] { transition-delay: 0.2s; }
        .scroll-animate[data-delay="300"] { transition-delay: 0.3s; }
        .scroll-animate[data-delay="400"] { transition-delay: 0.4s; }
        .scroll-animate[data-delay="500"] { transition-delay: 0.5s; }

        /* ===== ENHANCED HOVER EFFECTS ===== */
        .card-hover-zoom {
            transition: transform var(--transition-fast), box-shadow var(--transition-fast);
            position: relative;
            z-index: 1;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: var(--border-radius);
        }

        /* Enhanced zoom effect - bigger scale */
        .card-hover-zoom:hover {
            transform: scale(1.12) translateY(-8px);
            z-index: 10;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        .card-hover-zoom img {
            transition: transform var(--transition-fast);
        }

        .card-hover-zoom:hover img {
            transform: scale(1.05);
        }

        /* ===== COLOR SCHEME ===== */
        .highlight-text { color: var(--accent-yellow); }
        .main-text { color: var(--primary-blue); }
        .article-text { color: var(--text-dark); }

        /* ===== BUTTON STYLES ===== */
        .registration-btn {
            padding: 0.75rem 2rem !important;
            font-size: 0.95rem !important;
            transition: all var(--transition-fast);
            background-color: var(--accent-yellow) !important;
            border-color: var(--accent-yellow) !important;
            color: var(--text-dark) !important;
        }

        .registration-btn:hover {
            background-color: #e0ac00 !important;
            border-color: #e0ac00 !important;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(244, 183, 4, 0.3);
        }

        /* ===== CAROUSEL CARD BORDERS ===== */
        #latestArticlesCarousel .carousel-item .card,
        #popularArticlesCarousel .carousel-item .card,
        #upcomingEventsCarousel .carousel-item .card {
            border: none !important;
            border-right: 4px solid #CF2585 !important;
            border-bottom: 4px solid #CF2585 !important;
            border-radius: var(--border-radius) !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
        }

        /* Enhanced hover for carousel cards */
        #latestArticlesCarousel .carousel-item .card-hover-zoom:hover,
        #popularArticlesCarousel .carousel-item .card-hover-zoom:hover,
        #upcomingEventsCarousel .carousel-item .card-hover-zoom:hover {
            transform: scale(1.12) translateY(-8px) !important;
            box-shadow: 0 20px 40px rgba(207, 37, 133, 0.3) !important;
            border-right: 4px solid #CF2585 !important;
            border-bottom: 4px solid #CF2585 !important;
        }

        /* ===== EVENT DETAIL TEXT STYLING ===== */
        .event-detail-text,
        #upcomingEventsCarousel .event-detail-text,
        #upcomingEventsCarousel .carousel-item .card .event-meta .event-detail-text {
            color: #CF2585 !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            margin-top: 0.3rem !important;
            margin-bottom: 0 !important;
            text-align: left !important;
            line-height: 1.2 !important;
        }

        /* ===== CAROUSEL LAYOUT CONSISTENCY ===== */
        .carousel-item .row {
            display: flex !important;
            flex-wrap: nowrap !important;
            align-items: stretch !important;
        }

        .carousel-item .col {
            display: flex !important;
            flex: 1 1 0 !important;
            min-width: 0 !important;
            padding: 0 0.75rem !important;
        }

        /* Consistent card heights */
        .carousel-item .card {
            height: 360px !important;
            width: 100% !important;
            display: flex !important;
            flex-direction: column !important;
            border-radius: var(--border-radius) !important;
            overflow: hidden !important;
        }

        /* Special height for event cards */
        #upcomingEventsCarousel .carousel-item .card {
            height: 390px !important;
        }

        /* Image containers */
        .carousel-item .card .ratio {
            flex: 0 0 200px !important;
            height: 200px !important;
            margin-bottom: 0 !important;
            border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
            overflow: hidden !important;
        }

        .carousel-item .card .ratio img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            object-position: center !important;
        }

        /* Card body layout */
        .carousel-item .card .card-body {
            flex: 1 1 auto !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: flex-start !important;
            align-items: flex-start !important;
            padding: 1rem !important;
            text-align: left !important;
        }

        /* Title consistency */
        .carousel-item .card h5 {
            font-size: 1rem !important;
            font-weight: 600 !important;
            line-height: 1.3 !important;
            margin-bottom: 0.5rem !important;
            color: var(--text-dark) !important;
            display: -webkit-box !important;
            -webkit-line-clamp: 2 !important;
            -webkit-box-orient: vertical !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            height: 2.6rem !important;
        }

        /* Article descriptions */
        #latestArticlesCarousel .carousel-item .card p.card-text,
        #popularArticlesCarousel .carousel-item .card p.card-text {
            font-size: 0.85rem !important;
            color: var(--text-muted) !important;
            line-height: 1.4 !important;
            margin-bottom: 0 !important;
            display: -webkit-box !important;
            -webkit-line-clamp: 3 !important;
            -webkit-box-orient: vertical !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            flex: 1 1 auto !important;
        }

        /* Event meta styling */
        #upcomingEventsCarousel .event-meta {
            font-size: 0.85rem !important;
            flex: 1 1 auto !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: space-between !important;
        }

        #upcomingEventsCarousel .event-meta p {
            margin-bottom: 0.25rem !important;
            line-height: 1.3 !important;
            color: var(--text-muted) !important;
        }

        #upcomingEventsCarousel .event-meta i {
            width: 12px !important;
            text-align: center !important;
            font-size: 0.8rem !important;
        }

        #upcomingEventsCarousel .event-meta .badge {
            font-size: 0.7rem !important;
            font-weight: 600 !important;
            letter-spacing: 0.3px !important;
            padding: 0.25rem 0.5rem !important;
        }

        /* Status badge colors */
        .bg-warning.text-dark {
            background-color: var(--accent-yellow) !important;
            color: var(--text-dark) !important;
        }

        /* ===== RESPONSIVE DESIGN ===== */
        
        /* Desktop - 3 columns */
        @media (min-width: 992px) {
            .carousel-item .row { gap: 1rem !important; }
            .carousel-item .col {
                flex: 1 1 calc(33.333% - 1rem) !important;
                max-width: calc(33.333% - 1rem) !important;
            }
        }

        /* Tablet - 2 columns */
        @media (max-width: 991.98px) {
            .carousel-item .row { flex-wrap: wrap !important; }
            .carousel-item .col {
                flex: 1 1 calc(50% - 1rem) !important;
                max-width: calc(50% - 1rem) !important;
                margin-bottom: 1rem !important;
            }
            .carousel-item .card { height: 330px !important; }
            #upcomingEventsCarousel .carousel-item .card { height: 360px !important; }
            .carousel-item .card .ratio { height: 180px !important; }
        }

        /* Mobile - 1 column */
        @media (max-width: 767.98px) {
            .scroll-animate {
                transition: all 0.6s ease-out;
                transform: translateY(30px);
            }

            .scroll-animate[data-animation="zoomIn"] {
                transform: scale(0.95) translateY(20px);
            }

            .scroll-animate[data-animation="fadeInLeft"] {
                transform: translateX(-30px);
            }

            .scroll-animate[data-animation="fadeInRight"] {
                transform: translateX(30px);
            }

            .carousel-item .row {
                flex-direction: column !important;
                flex-wrap: nowrap !important;
            }

            .carousel-item .col {
                flex: 1 1 100% !important;
                max-width: 100% !important;
                width: 100% !important;
                padding: 0 1rem !important;
                margin-bottom: 1rem !important;
            }

            .carousel-item .card {
                height: 360px !important;
                margin: 0 auto !important;
            }

            #upcomingEventsCarousel .carousel-item .card {
                height: 390px !important;
            }

            .carousel-item .card h5 {
                font-size: 0.95rem !important;
                height: 2.4rem !important;
            }

            #latestArticlesCarousel .carousel-item .card p.card-text,
            #popularArticlesCarousel .carousel-item .card p.card-text {
                font-size: 0.8rem !important;
            }

            #upcomingEventsCarousel .event-meta {
                font-size: 0.75rem !important;
            }

            .event-detail-text,
            #upcomingEventsCarousel .event-detail-text {
                font-size: 0.65rem !important;
                margin-top: 0.2rem !important;
            }

            /* Mobile borders */
            #latestArticlesCarousel .carousel-item .card,
            #popularArticlesCarousel .carousel-item .card,
            #upcomingEventsCarousel .carousel-item .card {
                border-right: 3px solid #CF2585 !important;
                border-bottom: 3px solid #CF2585 !important;
            }

            /* Enhanced mobile hover effect */
            .card-hover-zoom:hover {
                transform: scale(1.08) translateY(-5px);
            }

            /* Mobile section spacing */
            .py-5.mb-3 {
                padding-top: 2rem !important;
                padding-bottom: 1.5rem !important;
                margin-bottom: 1rem !important;
            }

            .pt-5.pb-3.mt-4 {
                padding-top: 2rem !important;
                padding-bottom: 1rem !important;
                margin-top: 1.5rem !important;
            }

            .promo-title {
                font-size: 1.1rem !important;
                line-height: 1.4 !important;
            }
        }

        /* ===== TOUCH DEVICES ===== */
        @media (hover: none) and (pointer: coarse) {
            .carousel-item .card-hover-zoom:active {
                transform: scale(1.05) !important;
                z-index: 5 !important;
                transition: transform 0.1s ease !important;
            }
        }

        /* ===== ACCESSIBILITY ===== */
        @media (prefers-reduced-motion: reduce) {
            .scroll-animate {
                transition: opacity 0.3s ease;
                transform: none;
            }
            .scroll-animate.animate {
                transform: none;
            }
            .card-hover-zoom {
                transition: none;
            }
        }

        /* ===== ADDITIONAL COMPONENTS ===== */
        .text-truncate {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .match-result {
            font-size: 0.9rem;
        }

        .match-result .team-info {
            min-width: 100px;
        }

        @media (max-width: 767.98px) {
            .match-result {
                font-size: 0.85rem;
                flex-direction: column;
                gap: 0.5rem;
            }

            .match-result .team-info {
                min-width: auto;
                display: flex;
                align-items: center;
                justify-content: space-between;
                background: rgba(0, 0, 0, 0.05);
                padding: 0.5rem 1rem;
                border-radius: 0.5rem;
                width: 100%;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('js/carousel_gallery.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('KAMCUP Enhanced Website Script Loaded');

            // ===== OPTIMIZED SCROLL ANIMATIONS ===== 
            function initScrollAnimations() {
                const observerOptions = {
                    threshold: [0.1, 0.3],
                    rootMargin: '0px 0px -50px 0px'
                };

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const element = entry.target;
                            const delay = parseInt(element.getAttribute('data-delay')) || 0;

                            setTimeout(() => {
                                element.classList.add('animate');
                            }, delay);
                        } else if (entry.intersectionRatio === 0) {
                            // Only remove animation if completely out of view
                            entry.target.classList.remove('animate');
                        }
                    });
                }, observerOptions);

                const animateElements = document.querySelectorAll('.scroll-animate');
                animateElements.forEach(el => {
                    observer.observe(el);
                });

                console.log(`Enhanced scroll animations initialized for ${animateElements.length} elements`);
            }

            // ===== ENHANCED CAROUSEL SYSTEM ===== 
            function initAllCarousels() {
                const carouselConfigs = [
                    { id: 'latestArticlesCarousel', interval: 6000 },
                    { id: 'popularArticlesCarousel', interval: 6500 },
                    { id: 'upcomingEventsCarousel', interval: 7000 }
                ];

                carouselConfigs.forEach(config => {
                    const carousel = document.getElementById(config.id);
                    if (carousel) {
                        console.log(`Initializing enhanced ${config.id}`);

                        const bsCarousel = new bootstrap.Carousel(carousel, {
                            interval: config.interval,
                            wrap: true,
                            touch: true,
                            keyboard: true,
                            pause: 'hover'
                        });

                        // Enhanced navigation
                        const prevBtn = carousel.querySelector('.carousel-control-prev');
                        const nextBtn = carousel.querySelector('.carousel-control-next');

                        [prevBtn, nextBtn].forEach((btn, index) => {
                            if (btn) {
                                btn.addEventListener('click', function(e) {
                                    e.preventDefault();
                                    e.stopPropagation();
                                    index === 0 ? bsCarousel.prev() : bsCarousel.next();
                                });
                            }
                        });

                        // Intersection observer for performance
                        const carouselObserver = new IntersectionObserver((entries) => {
                            entries.forEach(entry => {
                                if (entry.isIntersecting) {
                                    bsCarousel.cycle();
                                } else {
                                    bsCarousel.pause();
                                }
                            });
                        }, { threshold: 0.3 });

                        carouselObserver.observe(carousel);
                        console.log(`${config.id} enhanced initialization complete`);
                    }
                });
            }

            // ===== ENHANCED TOUCH INTERACTIONS ===== 
            function initTouchInteractions() {
                const isTouchDevice = 'ontouchstart' in window || navigator.maxTouchPoints > 0;
                
                if (isTouchDevice) {
                    console.log('Touch device detected - setting up enhanced interactions');

                    const cards = document.querySelectorAll('.card-hover-zoom');
                    cards.forEach(card => {
                        let touchTimeout;

                        card.addEventListener('touchstart', function(e) {
                            clearTimeout(touchTimeout);
                            this.style.transform = 'scale(1.08) translateY(-5px)';
                            this.style.zIndex = '5';
                            this.style.transition = 'transform 0.15s ease';
                        }, { passive: true });

                        card.addEventListener('touchend', function(e) {
                            touchTimeout = setTimeout(() => {
                                this.style.transform = 'scale(1)';
                                this.style.zIndex = '1';
                                this.style.transition = 'transform 0.3s ease';
                            }, 150);
                        }, { passive: true });

                        card.addEventListener('touchcancel', function(e) {
                            clearTimeout(touchTimeout);
                            this.style.transform = 'scale(1)';
                            this.style.zIndex = '1';
                        }, { passive: true });
                    });
                }
            }

            // ===== ENHANCED BUTTON INTERACTIONS =====
            function initButtonInteractions() {
                const buttons = document.querySelectorAll('.btn, .registration-btn');
                buttons.forEach(btn => {
                    btn.addEventListener('mouseenter', function() {
                        if (!('ontouchstart' in window)) {
                            this.style.transform = 'translateY(-3px)';
                            this.style.boxShadow = '0 8px 20px rgba(0,0,0,0.15)';
                        }
                    });

                    btn.addEventListener('mouseleave', function() {
                        if (!('ontouchstart' in window)) {
                            this.style.transform = 'translateY(0)';
                            this.style.boxShadow = '';
                        }
                    });

                    btn.addEventListener('touchstart', function(e) {
                        this.style.transform = 'scale(0.95) translateY(2px)';
                        this.style.transition = 'transform 0.1s ease';
                    }, { passive: true });

                    btn.addEventListener('touchend', function(e) {
                        setTimeout(() => {
                            this.style.transform = 'scale(1) translateY(0)';
                        }, 100);
                    }, { passive: true });
                });
            }

            // ===== ENHANCED GALLERY CAROUSEL =====
            function initGalleryCarousel() {
                const carouselContainer = document.querySelector('.carousel-images');
                const leftButton = document.querySelector('.nav-button.left');
                const rightButton = document.querySelector('.nav-button.right');

                if (carouselContainer && leftButton && rightButton) {
                    const getScrollAmount = () => {
                        const itemWidth = carouselContainer.querySelector('.image-item')?.offsetWidth || 300;
                        return itemWidth + 30; // Add gap
                    };

                    leftButton.addEventListener('click', () => {
                        carouselContainer.scrollBy({
                            left: -getScrollAmount(),
                            behavior: 'smooth'
                        });
                    });

                    rightButton.addEventListener('click', () => {
                        carouselContainer.scrollBy({
                            left: getScrollAmount(),
                            behavior: 'smooth'
                        });
                    });

                    // Auto-scroll pause on hover
                    carouselContainer.addEventListener('mouseenter', () => {
                        carouselContainer.style.scrollBehavior = 'smooth';
                    });

                    // Touch support for gallery
                    let startX = 0;
                    let scrollLeft = 0;

                    carouselContainer.addEventListener('touchstart', (e) => {
                        startX = e.touches[0].pageX - carouselContainer.offsetLeft;
                        scrollLeft = carouselContainer.scrollLeft;
                    });

                    carouselContainer.addEventListener('touchmove', (e) => {
                        if (!startX) return;
                        e.preventDefault();
                        const x = e.touches[0].pageX - carouselContainer.offsetLeft;
                        const walk = (x - startX) * 2;
                        carouselContainer.scrollLeft = scrollLeft - walk;
                    });

                    carouselContainer.addEventListener('touchend', () => {
                        startX = 0;
                    });
                }
            }

            // ===== ENHANCED KEYBOARD NAVIGATION =====
            document.addEventListener('keydown', function(e) {
                const focusedCarousel = document.querySelector('.carousel:focus-within, .carousel:hover');
                
                if (focusedCarousel && ['ArrowLeft', 'ArrowRight'].includes(e.key)) {
                    e.preventDefault();
                    const isLeft = e.key === 'ArrowLeft';
                    const btn = focusedCarousel.querySelector(
                        isLeft ? '.carousel-control-prev' : '.carousel-control-next'
                    );
                    if (btn) btn.click();
                }

                // Gallery navigation
                const galleryCarousel = document.querySelector('.carousel-images');
                if (galleryCarousel && document.activeElement === galleryCarousel) {
                    if (e.key === 'ArrowLeft') {
                        document.querySelector('.nav-button.left')?.click();
                    } else if (e.key === 'ArrowRight') {
                        document.querySelector('.nav-button.right')?.click();
                    }
                }
            });

            // ===== PERFORMANCE OPTIMIZATIONS =====
            let scrollTimeout;
            let isScrolling = false;

            document.addEventListener('scroll', function() {
                if (!isScrolling) {
                    window.requestAnimationFrame(() => {
                        // Perform scroll-based calculations here
                        isScrolling = false;
                    });
                    isScrolling = true;
                }

                clearTimeout(scrollTimeout);
                scrollTimeout = setTimeout(() => {
                    // Scroll end operations
                }, 100);
            }, { passive: true });

            // ===== MOBILE DEVICE DETECTION =====
            function isMobileDevice() {
                return window.innerWidth <= 768 || /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
            }

            // ===== CAROUSEL INTERSECTION OBSERVER =====
            const carouselObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const carousel = entry.target;
                        
                        // Pause other carousels
                        const otherCarousels = document.querySelectorAll('.carousel');
                        otherCarousels.forEach(otherCarousel => {
                            if (otherCarousel !== carousel && otherCarousel.id) {
                                const bsCarousel = bootstrap.Carousel.getInstance(otherCarousel);
                                if (bsCarousel) {
                                    bsCarousel.pause();
                                }
                            }
                        });

                        // Resume current carousel
                        const bsCarousel = bootstrap.Carousel.getInstance(carousel);
                        if (bsCarousel) {
                            bsCarousel.cycle();
                        }
                    }
                });
            }, { 
                threshold: 0.5,
                rootMargin: '0px 0px -100px 0px'
            });

            // ===== INITIALIZE ALL ENHANCED FEATURES =====
            initScrollAnimations();
            initAllCarousels();
            initTouchInteractions();
            initButtonInteractions();
            initGalleryCarousel();

            // Apply mobile optimizations
            if (isMobileDevice()) {
                console.log('Mobile optimizations applied');
                document.body.classList.add('mobile-device');
                
                // Reduce animation intensity on mobile
                const style = document.createElement('style');
                style.textContent = `
                    .card-hover-zoom:hover {
                        transform: scale(1.05) translateY(-3px) !important;
                    }
                `;
                document.head.appendChild(style);
            }

            // ===== FALLBACK & ERROR HANDLING =====
            setTimeout(() => {
                console.log('Running enhanced fallback checks...');
                
                // Re-initialize scroll animations if needed
                const unanimatedElements = document.querySelectorAll('.scroll-animate:not(.animate)');
                if (unanimatedElements.length > 0) {
                    console.log('Re-initializing scroll animations for missed elements');
                    initScrollAnimations();
                }

                // Verify and re-initialize carousels
                const carousels = document.querySelectorAll('.carousel');
                carousels.forEach(carousel => {
                    if (!bootstrap.Carousel.getInstance(carousel)) {
                        console.log(`Re-initializing carousel: ${carousel.id}`);
                        new bootstrap.Carousel(carousel, {
                            interval: 5000,
                            wrap: true,
                            touch: true
                        });
                    }
                    // Observe carousel for intersection
                    carouselObserver.observe(carousel);
                });

                // Check for JavaScript errors
                window.addEventListener('error', function(e) {
                    console.error('JavaScript error detected:', e.error);
                });

            }, 1500);

            // ===== ADDITIONAL ENHANCEMENTS =====
            
            // Preload images for better performance
            function preloadImages() {
                const images = document.querySelectorAll('img[data-src]');
                const imageObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            img.src = img.dataset.src;
                            img.classList.remove('lazy');
                            imageObserver.unobserve(img);
                        }
                    });
                });

                images.forEach(img => imageObserver.observe(img));
            }

            // Initialize image preloading
            preloadImages();

            // Add loading states for better UX
            const loadingElements = document.querySelectorAll('[data-loading]');
            loadingElements.forEach(element => {
                element.classList.remove('loading');
            });

            console.log('Enhanced KAMCUP website initialization complete');
        });

        // ===== ENHANCED RESIZE HANDLER =====
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                console.log('Enhanced resize handling...');
                
                // Recalculate carousel layouts
                const carousels = document.querySelectorAll('.carousel');
                carousels.forEach(carousel => {
                    const bsCarousel = bootstrap.Carousel.getInstance(carousel);
                    if (bsCarousel) {
                        bsCarousel.cycle();
                    }
                });

                // Update gallery scroll calculations
                const galleryContainer = document.querySelector('.carousel-images');
                if (galleryContainer) {
                    galleryContainer.style.scrollBehavior = 'auto';
                    setTimeout(() => {
                        galleryContainer.style.scrollBehavior = 'smooth';
                    }, 100);
                }
            }, 250);
        });

        // ===== GLOBAL ERROR HANDLING =====
        window.addEventListener('unhandledrejection', function(event) {
            console.error('Unhandled promise rejection:', event.reason);
        });

        // ===== PAGE VISIBILITY API FOR PERFORMANCE =====
        document.addEventListener('visibilitychange', function() {
            const carousels = document.querySelectorAll('.carousel');
            
            if (document.hidden) {
                // Pause all carousels when page is hidden
                carousels.forEach(carousel => {
                    const bsCarousel = bootstrap.Carousel.getInstance(carousel);
                    if (bsCarousel) bsCarousel.pause();
                });
            } else {
                // Resume carousels when page becomes visible
                carousels.forEach(carousel => {
                    const bsCarousel = bootstrap.Carousel.getInstance(carousel);
                    if (bsCarousel) bsCarousel.cycle();
                });
            }
        });
    </script>
@endpush