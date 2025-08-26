@extends('../layouts/master')

{{-- Memberi penanda 'home-page' ke tag <body> di master layout --}}
@section('body-class', 'home-page')

@section('content')

{{-- Navbar khusus untuk halaman index (transparan) diletakkan di sini --}}
<nav class="navbar navbar-expand-lg bg-transparent py-3 position-absolute top-0 start-0 w-100 z-3 navbar-transparent">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('front.index') }}"
            style="width: 190px; overflow: hidden; height: 90px;">
            <img src="{{ asset('assets/img/logo4.png') }}" alt="KAMCUP Logo" class="me-2 brand-logo"
                style="height: 100%; width: 100%; object-fit: cover;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"
                style="background-image: url('data:image/svg+xml;charset=utf8,%3Csvg viewBox=\'0 0 30 30\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath stroke=\'rgba%28255, 255, 255, 0.95%29\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-miterlimit=\'10\' d=\'M4 7h22M4 15h22M4 23h22\'/%3E%3C/svg%3E');"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
                <li class="nav-item"><a class="nav-link fw-medium" href="{{ route('front.index') }}">HOME</a></li>
                <li class="nav-item"><a class="nav-link fw-medium" href="{{ route('front.articles') }}">BERITA</a></li>
                <li class="nav-item"><a class="nav-link fw-medium" href="{{ route('front.galleries') }}">GALERI</a></li>
                <li class="nav-item"><a class="nav-link fw-medium" href="{{ route('front.events.index') }}">EVENT</a></li>
                <li class="nav-item"><a class="nav-link fw-medium" href="{{ route('front.contact') }}">CONTACT US</a></li>
                <li class="nav-item"><a class="nav-link fw-medium" href="{{ route('profile.index') }}">PROFILE</a></li>
                @guest
                    <li class="nav-item"><a class="nav-link fw-medium" href="{{ route('login') }}">LOGIN</a></li>
                @else
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-light ms-lg-3">LOGOUT</button>
                        </form>
                    </li>
                @endguest
                <x-navbar-translate />
            </ul>
        </div>
    </div>
</nav>

<section class="position-relative hero-section">
    <div class="position-relative vh-100 d-flex align-items-center overflow-hidden">
        <img src="{{ asset('assets/img/jpn.jpg') }}" class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover z-1" alt="Volleyball Action Hero Image">
        <div class="container position-relative text-white z-2 text-center hero-content">
            <h1 class="display-3 fw-bold mb-4 hero-title"><br>Energi Sportif, Kemudahan Finansial!</h1>
            <p class="lead mb-5 hero-description">
                Bergabunglah dengan KAMCUP dan Bale by BTN dalam mewujudkan semangat <span class="highlight-text">
                    olahraga, inovasi, dan kekeluargaan.</span> Kami berkomitmen untuk menciptakan <span
                    class="highlight-text">komunitas</span> <span class="highlight-text">aktif,</span> suportif, dan
                penuh<span class="highlight-text"> pertumbuhan </span> para generasi muda visioner.
            </p>
            <a href="{{ route('front.events.index') }}" class="btn btn-lg fw-bold px-5 py-3 rounded-pill hero-btn">JELAJAHI PROMO & EVENT</a>
        </div>
    </div>
</section>

@if ($next_match)
<div class="container py-4 scroll-animate" data-animation="fadeInUp">
    <a href="{{ route('front.events.show', $next_match->slug) }}" class="text-decoration-none">
        <div class="card bg-light border-0 shadow-sm card-hover-zoom" style="height: auto;">
            <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-center">
                <h5 class="card-title fw-bold mb-2 mb-md-0 me-md-3 text-center text-md-start article-text">
                    <span class="main-text">Match</span> <span class="highlight-text">Terdekat:</span> {{ $next_match->title }}
                </h5>
                <div class="text-center text-md-end">
                    <p class="mb-1 small text-muted article-text">
                        <i class="bi bi-calendar me-1"></i>
                        {{ \Carbon\Carbon::parse($next_match->registration_start)->format('d M Y') }}
                        @if ($next_match->registration_start != $next_match->registration_end)
                            - {{ \Carbon\Carbon::parse($next_match->registration_end)->format('d M Y') }}
                        @endif
                    </p>
                    <a href="{{ route('front.events.show', $next_match->slug) }}" class="btn btn-sm btn-outline-primary mt-2 mt-md-0">Segera Daftar</a>
                </div>
            </div>
        </div>
    </a>
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
                            <div class="col-12 col-md-6 col-lg-4 scroll-animate" data-animation="fadeInUp" data-delay="{{ $loop->index * 100 }}">
                                <a href="{{ route('front.articles.show', $article->slug) }}" class="text-decoration-none">
                                    <div class="card card-hover-zoom border-0 rounded-3 overflow-hidden h-100">
                                        <div class="ratio ratio-16x9">
                                            <img src="{{ asset('storage/' . $article->thumbnail) }}"
                                                class="img-fluid object-fit-cover w-100 h-100"
                                                alt="{{ $article->title }}">
                                        </div>
                                        <div class="card-body d-flex flex-column px-3 py-3">
                                            <h5 class="card-title fw-semibold mb-2">{{ Str::limit($article->title, 60) }}</h5>
                                            <p class="card-text text-muted mb-0 flex-grow-1">{{ Str::limit($article->description, 80) }}</p>
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
        <button class="carousel-control-prev d-none d-md-flex" type="button" data-bs-target="#latestArticlesCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next d-none d-md-flex" type="button" data-bs-target="#latestArticlesCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        
        {{-- Carousel Indicators untuk Mobile --}}
        @if($latest_articles->count() > $chunk_size)
        <div class="carousel-indicators d-md-none position-relative mt-3 mb-0">
            @foreach ($latest_articles->chunk($chunk_size) as $chunkIndex => $chunk)
                <button type="button" data-bs-target="#latestArticlesCarousel" data-bs-slide-to="{{ $chunkIndex }}" 
                        class="{{ $chunkIndex === 0 ? 'active' : '' }}" aria-current="{{ $chunkIndex === 0 ? 'true' : 'false' }}" 
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
            @forelse ($populer_articles->chunk($chunk_size) as $chunkIndex => $chunk)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <div class="row gx-3 gy-3">
                        @foreach ($chunk as $article)
                            <div class="col-12 col-md-6 col-lg-4 scroll-animate" data-animation="fadeInUp" data-delay="{{ $loop->index * 100 }}">
                                <a href="{{ route('front.articles.show', $article->slug) }}" class="text-decoration-none">
                                    <div class="card card-hover-zoom border-0 rounded-3 overflow-hidden h-100">
                                        <div class="ratio ratio-16x9">
                                            <img src="{{ asset('storage/' . $article->thumbnail) }}"
                                                class="img-fluid object-fit-cover w-100 h-100"
                                                alt="{{ $article->title }}">
                                        </div>
                                        <div class="card-body d-flex flex-column px-3 py-3">
                                            <h5 class="card-title fw-semibold mb-2">{{ Str::limit($article->title, 60) }}</h5>
                                            <p class="card-text text-muted mb-0 flex-grow-1">{{ Str::limit($article->description, 80) }}</p>
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
        <button class="carousel-control-prev d-none d-md-flex" type="button" data-bs-target="#popularArticlesCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next d-none d-md-flex" type="button" data-bs-target="#popularArticlesCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        
        {{-- Carousel Indicators untuk Mobile --}}
        @if($populer_articles->count() > $chunk_size)
        <div class="carousel-indicators d-md-none position-relative mt-3 mb-0">
            @foreach ($populer_articles->chunk($chunk_size) as $chunkIndex => $chunk)
                <button type="button" data-bs-target="#popularArticlesCarousel" data-bs-slide-to="{{ $chunkIndex }}" 
                        class="{{ $chunkIndex === 0 ? 'active' : '' }}" aria-current="{{ $chunkIndex === 0 ? 'true' : 'false' }}" 
                        aria-label="Slide {{ $chunkIndex + 1 }}"></button>
            @endforeach
        </div>
        @endif
    </div>
</div>

<div class="text-center mt-5 mt-md-4 scroll-animate" data-animation="fadeInUp">
    <a href="{{ route('front.articles') }}" class="btn btn-outline-dark lihat-semua-btn px-4">Lihat semuanya</a>
</div>

{{-- Sponsor Utama (Satu Card dengan Tiga Logo Sejajar) --}}
<div class="container py-5 scroll-animate" data-animation="fadeInUp">
    <h5 class="fw-bold section-title"><span class="main-text">Presented </span> <span class="highlight-text">by</span>
    </h5>
    <div class="card border rounded-3 shadow-sm p-4 bg-white">
        <div class="row g-4 justify-content-around align-items-center">
            <div class="col-auto d-flex justify-content-center scroll-animate" data-animation="fadeInLeft" data-delay="100">
                @if (isset($sponsorData['xxl'][0]))
                    @php $sponsor = $sponsorData['xxl'][0]; @endphp
                    <div class="text-center btn-ylw" style="transition: transform 0.3s;">
                        <img src="{{ asset('storage/' . $sponsor->logo) }}" alt="{{ $sponsor->name }}"
                            class="img-fluid" style="max-width: 180px; max-height: 80px; object-fit: contain;">
                    </div>
                @else
                    <div class="text-center text-muted btn-ylw" style="transition: transform 0.3s;">
                        <p class="mb-0">Sponsor 1</p>
                    </div>
                @endif
            </div>
            <div class="col-auto d-flex justify-content-center scroll-animate" data-animation="fadeInUp" data-delay="200">
                @if (isset($sponsorData['xxl'][1]))
                    @php $sponsor = $sponsorData['xxl'][1]; @endphp
                    <div class="text-center">
                        <img src="{{ asset('storage/' . $sponsor->logo) }}" alt="{{ $sponsor->name }}"
                            class="img-fluid" style="max-width: 180px; max-height: 80px; object-fit: contain;">
                    </div>
                @else
                    <div class="text-center text-muted btn-ylw" style="transition: transform 0.3s;">
                        <p class="mb-0">Sponsor 2</p>
                    </div>
                @endif
            </div>
            <div class="col-auto d-flex justify-content-center scroll-animate" data-animation="fadeInRight" data-delay="300">
                @if (isset($sponsorData['xxl'][2]))
                    @php $sponsor = $sponsorData['xxl'][2]; @endphp
                    <div class="text-center">
                        <img src="{{ asset('storage/' . $sponsor->logo) }}" alt="{{ $sponsor->name }}"
                            class="img-fluid" style="max-width: 180px; max-height: 80px; object-fit: contain;">
                    </div>
                @else
                    <div class="text-center text-muted btn-ylw" style="transition: transform 0.3s;">
                        <p class="mb-0">Sponsor 3</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Card Section for Registrations --}}
<div class="container py-5 scroll-animate" data-animation="fadeInUp">
    <div class="row row-cols-1 row-cols-md-3 g-4 text-center">
        <div class="col scroll-animate" data-animation="fadeInLeft" data-delay="100">
            <div class="card h-100 border-0 rounded-4 overflow-hidden shadow-sm p-3 p-md-4 d-flex flex-column justify-content-center align-items-center"
                style="background-color: var(--collab-primary); color: var(--text-light); position: relative;">
                <i class="bi bi-people-fill display-4 mb-3" style="color: var(--collab-highlight);"></i>
                <h4 class="card-title fw-bold mb-3">Daftar Sebagai Tim</h4>
                <p class="card-text mb-4">Gabungkan tim Anda dan raih kemenangan bersama KAMCUP!</p>
                <a href="{{ route('team.create') }}" 
                   class="btn fw-bold px-4 py-2 rounded-pill registration-btn"
                   style="background-color: #F4B704; border-color: #F4B704; color: #212529; position: relative; z-index: 100; text-decoration: none;">
                   DAFTAR SEKARANG
                </a>
            </div>
        </div>
        <div class="col scroll-animate" data-animation="fadeInUp" data-delay="200">
            <div class="card h-100 border-0 rounded-4 overflow-hidden shadow-sm p-3 p-md-4 d-flex flex-column justify-content-center align-items-center"
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
            <div class="card h-100 border-0 rounded-4 overflow-hidden shadow-sm p-3 p-md-4 d-flex flex-column justify-content-center align-items-center"
                style="background-color: var(--collab-primary); color: var(--text-light); position: relative;">
                <i class="bi bi-heart-fill display-4 mb-3" style="color: var(--collab-highlight);"></i>
                <h4 class="card-title fw-bold mb-3">Daftar Sebagai Donatur</h4>
                <p class="card-text mb-4">Dukung perkembangan olahraga voli dan komunitas KAMCUP!</p>
                @auth
                    <a href="{{ route('donations.create') }}" 
                       class="btn fw-bold px-4 py-2 rounded-pill registration-btn"
                       style="background-color: #F4B704; border-color: #F4B704; color: #212529; position: relative; z-index: 100; text-decoration: none;">
                       BERI DONASI
                    </a>
                @else
                    <a href="{{ route('login') }}" 
                       class="btn fw-bold px-4 py-2 rounded-pill registration-btn"
                       style="background-color: #F4B704; border-color: #F4B704; color: #212529; position: relative; z-index: 100; text-decoration: none;">
                       DONASI
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>

{{-- Upcoming Events --}}
<div class="container py-5 mb-5 scroll-animate" data-animation="fadeInUp">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold section-title"><span class="main-text">UPCOMING</span> <span
                class="highlight-text">EVENT</span></h3>
        <a href="{{ route('front.events.index') }}" class="btn btn-outline-dark see-all-btn px-4 rounded-pill">Lihat semuanya</a>
    </div>
    <div id="upcomingEventsCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @forelse ($events->chunk($chunk_size) as $chunk)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <div class="row g-4">
                        @foreach ($chunk as $event)
                            <div class="col scroll-animate" data-animation="zoomIn" data-delay="{{ $loop->index * 100 }}">
                                <div class="card event-card border-0 rounded-4 overflow-hidden">
                                    <div class="ratio ratio-16x9 mb-2">
                                        <img src="{{ asset('storage/' . $event->thumbnail) }}"
                                            class="img-fluid object-fit-cover w-100 h-100" alt="{{ $event->title }}">
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h5 class="card-title fw-bold mb-0 me-2 flex-grow-1 text-truncate" style="max-width: calc(100% - 70px);">{{ Str::limit($event->title, 20) }}
                                            </h5>
                                            <span class="small text-muted text-end flex-shrink-0">
                                                {{ \Carbon\Carbon::parse($event->registration_start)->format('d M') }}
                                                @if (\Carbon\Carbon::parse($event->registration_start)->format('Y') != \Carbon\Carbon::parse($event->registration_end)->format('Y'))
                                                    - {{ \Carbon\Carbon::parse($event->registration_end)->format('d M Y') }}
                                                @else
                                                    - {{ \Carbon\Carbon::parse($event->registration_end)->format('d M') }}
                                                    {{ \Carbon\Carbon::parse($event->registration_end)->format('Y') }}
                                                @endif
                                            </span>
                                        </div>
                                        <p class="card-text small text-muted mb-2 d-flex align-items-center">
                                            <i class="bi bi-gender-ambiguous me-2"></i> {{ $event->gender_category }}
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <p class="card-text small text-muted mb-0 d-flex align-items-center me-2 flex-grow-1 text-truncate">
                                                <i class="bi bi-geo-alt me-2"></i> {{ Str::limit($event->location, 20) }}
                                            </p>
                                            @php
                                                $statusClass = '';
                                                switch ($event->status) {
                                                    case 'completed': $statusClass = 'status-completed'; break;
                                                    case 'ongoing': $statusClass = 'status-ongoing'; break;
                                                    case 'registration': $statusClass = 'status-registration'; break;
                                                    default: $statusClass = ''; break;
                                                }
                                            @endphp
                                            <span class="event-status-badge {{ $statusClass }} flex-shrink-0">
                                                {{ ucfirst($event->status) }}
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            @if ($event->sponsors->isNotEmpty())
                                                <img src="{{ asset('storage/' . $event->sponsors->first()->logo) }}"
                                                    alt="Sponsor Logo"
                                                    style="max-height: 25px; max-width: 60px; object-fit: contain; flex-shrink: 0;">
                                            @endif
                                        </div>
                                        <a href="{{ route('front.events.show', $event->slug) }}"
                                            class="mt-auto stretched-link">Detail Event & Daftar</a>
                                    </div>
                                </div>
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
        <button class="carousel-control-prev" type="button" data-bs-target="#upcomingEventsCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#upcomingEventsCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<div class="container py-5 mt-md-5 scroll-animate" data-animation="fadeInUp">
    <div class="text-center sponsor-section-header mb-4">
        <p class="mb-0 fw-bold fs-4">Materi Promosi BY
            @if (isset($sponsorData['xxl']) && $sponsorData['xxl']->isNotEmpty())
                {{ $sponsorData['xxl']->first()->name }}
            @else
                Para Mitra Hebat Kami
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
                    <a href="{{ route('front.galleries.show', $gallery->slug) }}" class="image-item scroll-animate" data-animation="fadeInUp" data-delay="{{ $loop->index * 100 }}">
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
                'xxl' => ['cols_md' => 2, 'cols_lg' => 2, 'max_width' => '220px', 'max_height' => '100px', 'p_size' => 4, 'limit' => 2],
                'xl' => ['cols_md' => 3, 'cols_lg' => 3, 'max_width' => '180px', 'max_height' => '90px', 'p_size' => 4, 'limit' => 3],
                'l' => ['cols_md' => 3, 'cols_lg' => 3, 'max_width' => '150px', 'max_height' => '75px', 'p_size' => 4, 'limit' => 3],
                'm' => ['cols_md' => 6, 'cols_lg' => 6, 'max_width' => '100px', 'max_height' => '50px', 'p_size' => 3, 'limit' => 6],
                's' => ['cols_md' => 6, 'cols_lg' => 6, 'max_width' => '80px', 'max_height' => '40px', 'p_size' => 3, 'limit' => 6],
            ];
            $displayOrder = ['xxl', 'xl', 'l', 'm', 's'];
        @endphp
        @foreach ($displayOrder as $size)
            @if (isset($sponsorData[$size]) && $sponsorData[$size]->isNotEmpty())
                <div
                    class="row row-cols-1 row-cols-md-{{ $sponsorSizes[$size]['cols_md'] }} row-cols-lg-{{ $sponsorSizes[$size]['cols_lg'] }} g-4 text-center mb-4 @if ($size === 'xxl') justify-content-center @endif scroll-animate" data-animation="fadeInUp" data-delay="{{ $loop->index * 100 }}">
                    @foreach ($sponsorData[$size]->take($sponsorSizes[$size]['limit']) as $sponsor)
                        <div class="col scroll-animate" data-animation="zoomIn" data-delay="{{ ($loop->parent->index * 100) + ($loop->index * 50) }}">
                            <div class="p-{{ $sponsorSizes[$size]['p_size'] }} border rounded-3 sponsor-box sponsor-{{ $size }} h-100 d-flex flex-column justify-content-center align-items-center bg-white text-dark">
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
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
     :root { 
    --shadow-color-cf2585: #CF2585; 
}

/* ===== SCROLL ANIMATIONS ===== */
.scroll-animate {
    opacity: 0;
    transform: translateY(50px);
    transition: all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    will-change: transform, opacity;
}

.scroll-animate.animate {
    opacity: 1;
    transform: translateY(0);
}

/* Different animation types */
.scroll-animate[data-animation="fadeInUp"] {
    transform: translateY(50px);
}

.scroll-animate[data-animation="fadeInDown"] {
    transform: translateY(-50px);
}

.scroll-animate[data-animation="fadeInLeft"] {
    transform: translateX(-50px);
}

.scroll-animate[data-animation="fadeInRight"] {
    transform: translateX(50px);
}

.scroll-animate[data-animation="zoomIn"] {
    transform: scale(0.8) translateY(30px);
}

.scroll-animate[data-animation="slideInLeft"] {
    transform: translateX(-100px);
}

.scroll-animate[data-animation="slideInRight"] {
    transform: translateX(100px);
}

/* When animated */
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

/* Staggered animation delays */
.scroll-animate[data-delay="100"] { transition-delay: 0.1s; }
.scroll-animate[data-delay="200"] { transition-delay: 0.2s; }
.scroll-animate[data-delay="300"] { transition-delay: 0.3s; }
.scroll-animate[data-delay="400"] { transition-delay: 0.4s; }
.scroll-animate[data-delay="500"] { transition-delay: 0.5s; }

/* Reduce motion for users who prefer it */
@media (prefers-reduced-motion: reduce) {
    .scroll-animate {
        transition: opacity 0.3s ease;
        transform: none;
    }
    
    .scroll-animate.animate {
        transform: none;
    }
}

.card a.btn { 
    background-color: #F4B704 !important; 
    border-color: #F4B704 !important; 
    color: #212529 !important; 
    transition: all 0.3s ease; 
}

.card a.btn:hover { 
    background-color: #e0ac00 !important; 
    border-color: #e0ac00 !important; 
    color: #212529 !important; 
}

.event-status-badge { 
    padding: 0.3em 0.6em; 
    border-radius: 0.25rem; 
    font-size: 0.75em; 
    font-weight: 600; 
    line-height: 1; 
    white-space: nowrap; 
    text-align: center; 
    vertical-align: baseline; 
    transition: all 0.3s ease-in-out; 
    color: white; 
}

.event-status-badge.status-registration { 
    background-color: #F4B704; 
    color: #212529; 
}

.highlight-text { color: #F4B704; }
.main-text { color: #0F62FF; }
.card-title.fw-bold { font-size: 1.25rem; }

/* Zoom effect untuk desktop */
.card-hover-zoom { 
    transition: transform 0.3s ease, box-shadow 0.3s ease; 
    position: relative; 
    z-index: 1; 
    box-shadow: 0 3px 8px rgba(200, 200, 200, 0.3); 
}

.card-hover-zoom:hover { 
    transform: scale(1.05);
    z-index: 10;
    box-shadow: 0 10px 30px rgba(150, 150, 150, 0.3); 
}

.card-hover-zoom img { 
    transition: transform 0.3s ease-in-out; 
}

.card-hover-zoom:hover img { 
    transform: scale(1.02);
}

.article-text { color: #212529; }
.match-terdekat-card { display: flex; flex-direction: column; }
.match-terdekat-card .card-body { 
    flex-grow: 1; 
    display: flex; 
    flex-direction: column; 
    justify-content: center; 
    align-items: flex-start; 
    padding: 1rem; 
}
.text-truncate { 
    white-space: nowrap; 
    overflow: hidden; 
    text-overflow: ellipsis; 
}

.btn-ylw:hover { 
    transform: translateY(-2px);
}

.registration-btn {
    padding: 0.75rem 2rem !important;
    font-size: 0.95rem !important;
    transition: all 0.3s ease;
}

.registration-btn:hover {
    background-color: #e0ac00 !important;
    border-color: #e0ac00 !important;
    transform: translateY(-2px);
}

/* ===== PERBAIKAN UNTUK ARTIKEL CAROUSEL ===== */

/* Base article carousel styling */
#latestArticlesCarousel .carousel-item .row,
#popularArticlesCarousel .carousel-item .row {
    display: flex !important;
    flex-wrap: nowrap !important;
    align-items: stretch !important;
}

#latestArticlesCarousel .carousel-item .col,
#popularArticlesCarousel .carousel-item .col {
    display: flex !important;
    flex: 1 1 0 !important;
    min-width: 0 !important;
    padding: 0 0.75rem !important;
}

/* Article card standardization */
#latestArticlesCarousel .carousel-item .card,
#popularArticlesCarousel .carousel-item .card {
    height: 350px !important;
    width: 100% !important;
    display: flex !important;
    flex-direction: column !important;
    border: 1px solid rgba(0,0,0,0.1) !important;
    border-radius: 12px !important;
    overflow: hidden !important;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1) !important;
}

/* Image container fixed ratio */
#latestArticlesCarousel .carousel-item .card .ratio,
#popularArticlesCarousel .carousel-item .card .ratio {
    flex: 0 0 200px !important;
    height: 200px !important;
    margin-bottom: 0 !important;
    border-radius: 12px 12px 0 0 !important;
    overflow: hidden !important;
}

#latestArticlesCarousel .carousel-item .card .ratio img,
#popularArticlesCarousel .carousel-item .card .ratio img {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    object-position: center !important;
}

/* Card body standardization */
#latestArticlesCarousel .carousel-item .card .card-body,
#popularArticlesCarousel .carousel-item .card .card-body {
    flex: 1 1 auto !important;
    display: flex !important;
    flex-direction: column !important;
    justify-content: flex-start !important;
    align-items: flex-start !important;
    padding: 1rem !important;
    text-align: left !important;
}

/* Title styling */
#latestArticlesCarousel .carousel-item .card h5,
#popularArticlesCarousel .carousel-item .card h5 {
    font-size: 1rem !important;
    font-weight: 600 !important;
    line-height: 1.3 !important;
    margin-bottom: 0.5rem !important;
    color: #212529 !important;
    display: -webkit-box !important;
    -webkit-line-clamp: 2 !important;
    -webkit-box-orient: vertical !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    height: 2.6rem !important;
}

/* Description styling */
#latestArticlesCarousel .carousel-item .card p,
#popularArticlesCarousel .carousel-item .card p {
    font-size: 0.85rem !important;
    color: #6c757d !important;
    line-height: 1.4 !important;
    margin-bottom: 0 !important;
    display: -webkit-box !important;
    -webkit-line-clamp: 3 !important;
    -webkit-box-orient: vertical !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    flex: 1 1 auto !important;
}

/* ===== PERBAIKAN LENGKAP UNTUK EVENT CAROUSEL - UKURAN DIPERTAHANKAN + CLICKABLE ===== */

/* Base event carousel styling dengan ukuran yang dipertahankan */
#upcomingEventsCarousel .carousel-item .row {
    display: flex !important;
    flex-wrap: nowrap !important;
    align-items: stretch !important;
    justify-content: flex-start !important;
}

#upcomingEventsCarousel .carousel-item .col {
    display: flex !important;
    flex: 0 0 auto !important;
    min-width: 370px !important; /* UKURAN DIPERTAHANKAN */
    max-width: 400px !important; /* UKURAN DIPERTAHANKAN */
    width: 400px !important; /* UKURAN DIPERTAHANKAN */
    padding: 0 0.75rem !important;
}

/* Event card dengan ukuran yang dipertahankan + PERBAIKAN CLICKABLE */
#upcomingEventsCarousel .event-card {
    height: 350px !important; /* UKURAN DIPERTAHANKAN */
    width: 100% !important;
    min-width: 350px !important; /* UKURAN DIPERTAHANKAN */
    display: flex !important;
    flex-direction: column !important;
    border: 1px solid rgba(0,0,0,0.1) !important;
    border-radius: 12px !important;
    overflow: hidden !important;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1) !important;
    transition: transform 0.3s ease, box-shadow 0.3s ease !important;
    /* PERBAIKAN CLICKABLE */
    position: relative !important;
    cursor: pointer !important;
    z-index: 1 !important;
}

/* PERBAIKAN STRETCHED-LINK - INI YANG PALING PENTING */
#upcomingEventsCarousel .event-card .stretched-link {
    position: absolute !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    bottom: 0 !important;
    z-index: 20 !important;
    text-decoration: none !important;
    color: transparent !important;
    display: block !important;
    background: transparent !important;
    border-radius: inherit !important;
}

/* Reset pseudo-element Bootstrap stretched-link yang bermasalah */
#upcomingEventsCarousel .event-card .stretched-link::after {
    display: none !important;
    content: none !important;
}

/* Image container dengan proporsi yang dipertahankan */
#upcomingEventsCarousel .event-card .ratio {
    flex: 0 0 200px !important; /* UKURAN DIPERTAHANKAN */
    height: 200px !important; /* UKURAN DIPERTAHANKAN */
    margin-bottom: 0 !important;
    border-radius: 12px 12px 0 0 !important;
    overflow: hidden !important;
    /* PERBAIKAN CLICKABLE */
    position: relative !important;
    z-index: 15 !important;
    pointer-events: none !important;
}

#upcomingEventsCarousel .event-card .ratio img {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    object-position: center !important;
    transition: transform 0.3s ease !important;
    /* PERBAIKAN CLICKABLE */
    position: relative !important;
    z-index: 15 !important;
    pointer-events: none !important;
}

/* Event card body dengan ukuran yang dipertahankan */
#upcomingEventsCarousel .event-card .card-body {
    flex: 1 1 auto !important;
    display: flex !important;
    flex-direction: column !important;
    justify-content: flex-start !important;
    align-items: flex-start !important;
    padding: 1.1rem !important; /* UKURAN DIPERTAHANKAN */
    text-align: left !important;
    /* PERBAIKAN CLICKABLE */
    position: relative !important;
    z-index: 15 !important;
    pointer-events: none !important;
}

#upcomingEventsCarousel .event-card .card-body * {
    pointer-events: none !important;
}

/* Event title styling dengan ukuran yang dipertahankan */
#upcomingEventsCarousel .event-card h5 {
    font-size: 1.05rem !important; /* UKURAN DIPERTAHANKAN */
    font-weight: 600 !important;
    line-height: 1.3 !important;
    margin-bottom: 0.7rem !important; /* UKURAN DIPERTAHANKAN */
    color: #212529 !important;
    display: -webkit-box !important;
    -webkit-line-clamp: 2 !important;
    -webkit-box-orient: vertical !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    height: 2.7rem !important; /* UKURAN DIPERTAHANKAN */
}

/* Event meta info styling dengan ukuran yang dipertahankan */
#upcomingEventsCarousel .event-card .card-text {
    font-size: 0.87rem !important; /* UKURAN DIPERTAHANKAN */
    color: #6c757d !important;
    line-height: 1.4 !important;
    margin-bottom: 0.7rem !important; /* UKURAN DIPERTAHANKAN */
}

/* Event details dengan layout yang dipertahankan */
#upcomingEventsCarousel .event-card .d-flex {
    margin-bottom: 0.7rem !important; /* UKURAN DIPERTAHANKAN */
}

/* PERBAIKAN KHUSUS UNTUK BROWSER */
#upcomingEventsCarousel .event-card .stretched-link {
    -webkit-tap-highlight-color: transparent !important;
    -webkit-touch-callout: none !important;
    -webkit-user-select: none !important;
    -moz-user-select: none !important;
    -ms-user-select: none !important;
    user-select: none !important;
}

/* Event card hover effects - UKURAN EFEK DIPERTAHANKAN */
#upcomingEventsCarousel .event-card.card-hover-zoom:hover {
    transform: translateY(-5px) !important;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

#upcomingEventsCarousel .event-card:hover .ratio img {
    transform: scale(1.02) !important;
}

/* Hover effects untuk artikel */
#latestArticlesCarousel .carousel-item .card-hover-zoom,
#popularArticlesCarousel .carousel-item .card-hover-zoom {
    transition: transform 0.3s ease, box-shadow 0.3s ease !important;
}

#latestArticlesCarousel .carousel-item .card-hover-zoom:hover,
#popularArticlesCarousel .carousel-item .card-hover-zoom:hover {
    transform: translateY(-5px) !important;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

/* Link styling untuk artikel dan event */
#latestArticlesCarousel a,
#popularArticlesCarousel a,
#upcomingEventsCarousel a {
    text-decoration: none !important;
    color: inherit !important;
    display: block !important;
    height: 100% !important;
}

/* Carousel controls positioning */
.carousel-control-prev,
.carousel-control-next {
    width: 5% !important;
    opacity: 0.7 !important;
    transition: opacity 0.3s ease !important;
}

.carousel-control-prev:hover,
.carousel-control-next:hover {
    opacity: 1 !important;
}

/* Ensure equal height in flex containers */
.carousel-inner {
    overflow: visible !important;
}

.carousel-item {
    transition: transform 0.6s ease-in-out !important;
}

.carousel-item.active {
    display: flex !important;
}

/* Carousel indicators styling */
.carousel-indicators {
    position: relative !important;
    margin-top: 1rem !important;
    margin-bottom: 0 !important;
}

.carousel-indicators [data-bs-target] {
    background-color: #6c757d !important;
    border: none !important;
    width: 8px !important;
    height: 8px !important;
    border-radius: 50% !important;
    margin: 0 4px !important;
}

.carousel-indicators .active {
    background-color: #0F62FF !important;
}

/* Perbaikan overflow untuk event carousel */
#upcomingEventsCarousel .carousel-inner {
    overflow-x: auto !important;
    overflow-y: visible !important;
}

#upcomingEventsCarousel .carousel-item .row {
    width: max-content !important;
}

/* ===== RESPONSIVE FIXES - UKURAN DIPERTAHANKAN ===== */

/* Large Desktop - Event cards UKURAN DIPERTAHANKAN */
@media (min-width: 1400px) {
    #upcomingEventsCarousel .carousel-item .col {
        min-width: 420px !important; /* UKURAN DIPERTAHANKAN */
        max-width: 450px !important; /* UKURAN DIPERTAHANKAN */
        width: 450px !important; /* UKURAN DIPERTAHANKAN */
    }
    
    #upcomingEventsCarousel .event-card {
        min-width: 400px !important; /* UKURAN DIPERTAHANKAN */
    }
}

/* Desktop - UKURAN DIPERTAHANKAN */
@media (min-width: 1200px) and (max-width: 1399.98px) {
    #upcomingEventsCarousel .carousel-item .col {
        min-width: 370px !important; /* UKURAN DIPERTAHANKAN */
        max-width: 400px !important; /* UKURAN DIPERTAHANKAN */
        width: 400px !important; /* UKURAN DIPERTAHANKAN */
    }
    
    #upcomingEventsCarousel .event-card {
        min-width: 350px !important; /* UKURAN DIPERTAHANKAN */
    }
}

/* Tablet view */
@media (max-width: 991.98px) {
    /* Artikel carousel tablet */
    #latestArticlesCarousel .carousel-item .row,
    #popularArticlesCarousel .carousel-item .row {
        flex-wrap: wrap !important;
    }
    
    #latestArticlesCarousel .carousel-item .col,
    #popularArticlesCarousel .carousel-item .col {
        flex: 1 1 calc(50% - 1rem) !important;
        max-width: calc(50% - 1rem) !important;
        margin-bottom: 1rem !important;
    }
    
    #latestArticlesCarousel .carousel-item .card,
    #popularArticlesCarousel .carousel-item .card {
        height: 320px !important;
    }
    
    #latestArticlesCarousel .carousel-item .card .ratio,
    #popularArticlesCarousel .carousel-item .card .ratio {
        flex: 0 0 180px !important;
        height: 180px !important;
    }
    
    /* Event carousel tablet - UKURAN DIPERTAHANKAN */
    #upcomingEventsCarousel .carousel-item .row {
        flex-wrap: nowrap !important;
        width: max-content !important;
    }
    
    #upcomingEventsCarousel .carousel-item .col {
        flex: 0 0 auto !important;
        min-width: 320px !important; /* UKURAN DIPERTAHANKAN */
        max-width: 350px !important; /* UKURAN DIPERTAHANKAN */
        width: 350px !important; /* UKURAN DIPERTAHANKAN */
        margin-right: 1rem !important;
    }
    
    #upcomingEventsCarousel .event-card {
        height: 340px !important;
        min-width: 300px !important; /* UKURAN DIPERTAHANKAN */
    }
    
    #upcomingEventsCarousel .event-card .ratio {
        flex: 0 0 180px !important;
        height: 180px !important;
    }
}

/* PERBAIKAN KHUSUS MOBILE */
@media (max-width: 767.98px) {
    /* Disable scroll animations on mobile for better performance */
    .scroll-animate {
        opacity: 1 !important;
        transform: none !important;
        transition: none !important;
    }
    
    /* Reset zoom untuk card registrasi agar tidak mengganggu layout */
    .card.h-100 { 
        transition: none !important;
        transform: none !important;
        z-index: auto !important;
    }
    
    .card.h-100:hover { 
        transform: none !important;
        z-index: auto !important;
    }
    
    /* KEEP ZOOM UNTUK ARTIKEL DAN EVENT - dengan efek yang diperkecil */
    #latestArticlesCarousel .carousel-item .card-hover-zoom,
    #popularArticlesCarousel .carousel-item .card-hover-zoom,
    #upcomingEventsCarousel .event-card.card-hover-zoom { 
        transition: transform 0.2s ease !important;
        transform: scale(1) !important;
        z-index: 1 !important;
    }
    
    /* Active state untuk touch */
    #latestArticlesCarousel .carousel-item .card-hover-zoom:active,
    #popularArticlesCarousel .carousel-item .card-hover-zoom:active,
    #upcomingEventsCarousel .event-card.card-hover-zoom:active { 
        transform: scale(1.02) !important;
        z-index: 5 !important;
        transition: transform 0.1s ease !important;
    }
    
    /* Hover untuk device yang support hover */
    #latestArticlesCarousel .carousel-item .card-hover-zoom:hover,
    #popularArticlesCarousel .carousel-item .card-hover-zoom:hover,
    #upcomingEventsCarousel .event-card.card-hover-zoom:hover { 
        transform: scale(1.02) !important;
        z-index: 5 !important;
    }
    
    /* Article carousel mobile layout */
    #latestArticlesCarousel .carousel-item .row,
    #popularArticlesCarousel .carousel-item .row {
        flex-direction: column !important;
        flex-wrap: nowrap !important;
    }
    
    #latestArticlesCarousel .carousel-item .col,
    #popularArticlesCarousel .carousel-item .col {
        flex: 1 1 100% !important;
        max-width: 100% !important;
        padding: 0 1rem !important;
        margin-bottom: 1rem !important;
    }
    
    #latestArticlesCarousel .carousel-item .card,
    #popularArticlesCarousel .carousel-item .card {
        height: 300px !important;
        max-width: 100% !important;
        margin: 0 auto !important;
    }
    
    #latestArticlesCarousel .carousel-item .card .ratio,
    #popularArticlesCarousel .carousel-item .card .ratio {
        flex: 0 0 160px !important;
        height: 160px !important;
    }
    
    /* Event carousel mobile - UKURAN DIPERTAHANKAN dengan horizontal scroll */
    #upcomingEventsCarousel .carousel-item .row {
        flex-direction: row !important;
        flex-wrap: nowrap !important;
        width: max-content !important;
    }
    
    #upcomingEventsCarousel .carousel-item .col {
        flex: 0 0 auto !important;
        min-width: 300px !important; /* UKURAN DIPERTAHANKAN */
        max-width: 320px !important; /* UKURAN DIPERTAHANKAN */
        width: 320px !important; /* UKURAN DIPERTAHANKAN */
        padding: 0 0.5rem !important;
        margin-right: 0.5rem !important;
    }
    
    #upcomingEventsCarousel .event-card {
        height: 320px !important;
        min-width: 280px !important; /* UKURAN DIPERTAHANKAN */
        max-width: 100% !important;
    }
    
    #upcomingEventsCarousel .event-card .ratio {
        flex: 0 0 160px !important;
        height: 160px !important;
    }
    
    #upcomingEventsCarousel .event-card .card-body {
        padding: 1rem !important;
    }
    
    #upcomingEventsCarousel .event-card h5 {
        font-size: 0.95rem !important;
        height: 2.4rem !important;
    }
    
    #upcomingEventsCarousel .event-card .card-text {
        font-size: 0.8rem !important;
    }
    
    /* Hide carousel controls on mobile */
    .carousel-control-prev,
    .carousel-control-next {
        display: none !important;
    }
    
    /* Tombol registrasi untuk mobile */
    .registration-btn {
        padding: 0.6rem 1.2rem !important;
        font-size: 0.85rem !important;
        width: auto !important;
        display: inline-block !important;
        white-space: nowrap !important;
        transition: all 0.2s ease !important;
    }
    
    .registration-btn:active {
        transform: scale(0.98) !important;
        background-color: #e0ac00 !important;
    }
    
    /* Perbaikan untuk card registrasi */
    .card.h-100 {
        height: auto !important;
        min-height: 250px;
    }
    
    .card.h-100 .card-title {
        font-size: 1.1rem !important;
        margin-bottom: 0.75rem !important;
    }
    
    .card.h-100 .card-text {
        font-size: 0.9rem !important;
        margin-bottom: 1rem !important;
    }
    
    /* Fix untuk container */
    .container {
        overflow-x: hidden;
    }
    
    /* Fix untuk row yang berantakan */
    .row.g-4 {
        margin: 0 !important;
    }
    
    .row.g-4 > .col {
        padding: 0.5rem !important;
    }
    
    /* Hero section adjustments */
    .hero-title {
        font-size: 2rem !important;
    }
    
    .hero-description {
        font-size: 1rem !important;
    }
    
    /* Section title adjustments */
    .section-title {
        font-size: 1.5rem !important;
    }
}

/* Small mobile - UKURAN DIPERTAHANKAN */
@media (max-width: 575.98px) {
    #latestArticlesCarousel .carousel-item .card,
    #popularArticlesCarousel .carousel-item .card {
        height: 280px !important;
    }
    
    #latestArticlesCarousel .carousel-item .card .ratio,
    #popularArticlesCarousel .carousel-item .card .ratio {
        flex: 0 0 140px !important;
        height: 140px !important;
    }
    
    /* Event cards small mobile - UKURAN DIPERTAHANKAN */
    #upcomingEventsCarousel .carousel-item .col {
        min-width: 280px !important; /* UKURAN DIPERTAHANKAN */
        max-width: 300px !important; /* UKURAN DIPERTAHANKAN */
        width: 300px !important; /* UKURAN DIPERTAHANKAN */
    }
    
    #upcomingEventsCarousel .event-card {
        height: 300px !important;
        min-width: 260px !important; /* UKURAN DIPERTAHANKAN */
    }
    
    #upcomingEventsCarousel .event-card .ratio {
        flex: 0 0 140px !important;
        height: 140px !important;
    }
    
    #upcomingEventsCarousel .event-card h5 {
        font-size: 0.9rem !important;
        height: 2.2rem !important;
    }
    
    #upcomingEventsCarousel .event-card .card-text {
        font-size: 0.75rem !important;
    }
}

/* Perbaikan untuk landscape mobile */
@media (max-width: 992px) and (orientation: landscape) {
    .registration-btn {
        padding: 0.5rem 1rem !important;
        font-size: 0.8rem !important;
    }
    
    #latestArticlesCarousel .carousel-item .card-hover-zoom:active,
    #popularArticlesCarousel .carousel-item .card-hover-zoom:active,
    #upcomingEventsCarousel .event-card.card-hover-zoom:active { 
        transform: scale(1.015) !important;
    }
}

/* Touch enhancement untuk semua mobile device */
@media (hover: none) and (pointer: coarse) {
    /* Cards mendapat efek zoom saat touch */
    #latestArticlesCarousel .carousel-item .card-hover-zoom:active,
    #popularArticlesCarousel .carousel-item .card-hover-zoom:active,
    #upcomingEventsCarousel .event-card.card-hover-zoom:active { 
        transform: scale(1.02) !important;
        z-index: 5 !important;
        transition: transform 0.1s ease !important;
    }
    
    /* Tombol mendapat efek press */
    .btn:active, .registration-btn:active {
        transform: scale(0.98) !important;
        transition: transform 0.1s ease !important;
    }
}

/* Memastikan semua link dan button bisa diklik di semua device */
a, button, .btn {
    position: relative;
    z-index: 50;
    pointer-events: auto;
}

/* Perbaikan tambahan untuk mobile responsiveness */
@media (max-width: 767.98px) {
    .card-body.flex-column { 
        align-items: center !important; 
    }
    
    .card-title.fw-bold { 
        text-align: center !important; 
        margin-bottom: 0.5rem !important; 
    }
    
    .btn-sm { 
        width: 100%; 
    }
}
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('js/carousel_gallery.js') }}"></script>
    <script>
       document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 KAMCUP Event Card Script Loaded');
    
    // ===== SCROLL ANIMATIONS SCRIPT =====
    function initScrollAnimations() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const element = entry.target;
                    const delay = element.getAttribute('data-delay') || 0;
                    
                    setTimeout(() => {
                        element.classList.add('animate');
                    }, parseInt(delay));
                } else {
                    // Remove animation when scrolling back up
                    entry.target.classList.remove('animate');
                }
            });
        }, observerOptions);
        
        // Observe all scroll-animate elements
        const animateElements = document.querySelectorAll('.scroll-animate');
        animateElements.forEach(el => {
            observer.observe(el);
        });
        
        console.log(`✅ Scroll animations initialized for ${animateElements.length} elements`);
    }
    
    // ===== PERBAIKAN EVENT CARD CLICKABLE =====
    function makeEventCardsClickable() {
        const eventCards = document.querySelectorAll('#upcomingEventsCarousel .event-card');
        console.log(`Found ${eventCards.length} event cards`);
        
        eventCards.forEach((card, index) => {
            const link = card.querySelector('.stretched-link') || 
                        card.querySelector('a[href*="events"]');
            
            if (link && link.href) {
                console.log(`Setting up event card ${index + 1}:`, link.href);
                
                // Remove existing event listeners untuk prevent double binding
                const newCard = card.cloneNode(true);
                card.parentNode.replaceChild(newCard, card);
                
                // Re-query link di new card
                const newLink = newCard.querySelector('.stretched-link') || 
                               newCard.querySelector('a[href*="events"]');
                
                if (newLink) {
                    // Make entire card clickable
                    newCard.addEventListener('click', function(e) {
                        console.log('Event card clicked!', newLink.href);
                        e.preventDefault();
                        e.stopPropagation();
                        window.location.href = newLink.href;
                    });
                    
                    // Touch handler for mobile
                    newCard.addEventListener('touchend', function(e) {
                        console.log('Event card touched!', newLink.href);
                        e.preventDefault();
                        e.stopPropagation();
                        setTimeout(() => {
                            window.location.href = newLink.href;
                        }, 100);
                    });
                    
                    // Visual feedback
                    newCard.style.cursor = 'pointer';
                }
            } else {
                console.warn(`No valid link found in event card ${index + 1}`);
            }
        });
    }
    
    // ===== FUNCTION UNTUK MOBILE DEVICE DETECTION =====
    function isMobileDevice() {
        return window.innerWidth <= 768 || /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    }
    
    // ===== MOBILE TOUCH EVENTS HANDLING =====
    if (isMobileDevice()) {
        console.log('Mobile device detected - setting up touch handlers');
        
        // Disable zoom untuk card registrasi di mobile
        const registrationCards = document.querySelectorAll('.card.h-100');
        registrationCards.forEach(card => {
            card.style.transform = 'none';
            card.style.transition = 'none';
        });
        
        // Enable zoom untuk artikel cards dengan touch handling
        const articleCards = document.querySelectorAll('.carousel-item .card-hover-zoom');
        articleCards.forEach(card => {
            card.addEventListener('touchstart', function(e) {
                this.style.transform = 'scale(1.02)';
                this.style.zIndex = '5';
                this.style.transition = 'transform 0.1s ease';
            }, { passive: true });
            
            card.addEventListener('touchend', function(e) {
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                    this.style.zIndex = '1';
                }, 100);
            }, { passive: true });
            
            card.addEventListener('touchcancel', function(e) {
                this.style.transform = 'scale(1)';
                this.style.zIndex = '1';
            }, { passive: true });
        });
    } else {
        // Initialize scroll animations only on desktop/tablet
        initScrollAnimations();
    }
    
    // ===== REGISTRATION BUTTON HANDLERS =====
    const registrationBtns = document.querySelectorAll('.registration-btn');
    registrationBtns.forEach(btn => {
        btn.addEventListener('touchstart', function(e) {
            e.stopPropagation();
            this.style.transform = 'scale(0.98)';
            this.style.transition = 'transform 0.1s ease';
        }, { passive: false });
        
        btn.addEventListener('touchend', function(e) {
            e.stopPropagation();
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 100);
        }, { passive: false });
        
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });
    
    // ===== ALL OTHER BUTTONS HANDLER =====
    const allButtons = document.querySelectorAll('.btn:not(.registration-btn)');
    allButtons.forEach(btn => {
        btn.addEventListener('touchstart', function(e) {
            if (isMobileDevice()) {
                this.style.transform = 'scale(0.98)';
                this.style.transition = 'transform 0.1s ease';
            }
        }, { passive: true });
        
        btn.addEventListener('touchend', function(e) {
            if (isMobileDevice()) {
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 100);
            }
        }, { passive: true });
    });
    
    // ===== CAROUSEL GALLERY SCRIPT (DIPERTAHANKAN) =====
    const carouselImagesContainer = document.querySelector('.carousel-images');
    const leftButton = document.querySelector('.nav-button.left');
    const rightButton = document.querySelector('.nav-button.right');

    if (carouselImagesContainer && leftButton && rightButton) {
        const scrollAmount = () => {
            let itemWidth = carouselImagesContainer.querySelector('.image-item')?.offsetWidth;
            return itemWidth ? itemWidth + 30 : carouselImagesContainer.offsetWidth / 2;
        }
        
        leftButton.addEventListener('click', () => {
            carouselImagesContainer.scrollBy({ left: -scrollAmount(), behavior: 'smooth' });
        });
        
        rightButton.addEventListener('click', () => {
            carouselImagesContainer.scrollBy({ left: scrollAmount(), behavior: 'smooth' });
        });
    }
    
    // ===== SETUP EVENT CARDS CLICKABLE =====
    makeEventCardsClickable();
    
    // ===== RE-RUN SAAT CAROUSEL BERUBAH =====
    const eventCarousel = document.getElementById('upcomingEventsCarousel');
    if (eventCarousel) {
        eventCarousel.addEventListener('slid.bs.carousel', function() {
            console.log('Event carousel changed - re-setting up click handlers');
            setTimeout(makeEventCardsClickable, 200);
        });
    }
    
    // ===== FALLBACK - RE-RUN SETELAH DELAY =====
    setTimeout(() => {
        console.log('Running fallback event card setup');
        makeEventCardsClickable();
        
        // Re-initialize scroll animations if not mobile
        if (!isMobileDevice()) {
            initScrollAnimations();
        }
    }, 1000);
    
    console.log('✅ All event card handlers and scroll animations setup complete');
});

// ===== WINDOW RESIZE HANDLER =====
window.addEventListener('resize', function() {
    if (window.innerWidth <= 768) {
        const registrationCards = document.querySelectorAll('.card.h-100');
        const eventCards = document.querySelectorAll('.event-card');
        
        registrationCards.forEach(card => {
            card.style.transform = 'none';
            card.style.transition = 'none';
        });
        
        eventCards.forEach(card => {
            // Tidak disable event cards di mobile, biarkan tetap clickable
            card.style.cursor = 'pointer';
        });
    }
});

// ===== LOAD EVENT UNTUK CAROUSEL GALLERY =====
window.addEventListener('load', function() {
    // Re-setup event cards setelah semua asset loaded
    setTimeout(() => {
        const eventCards = document.querySelectorAll('#upcomingEventsCarousel .event-card');
        if (eventCards.length > 0) {
            console.log('Window loaded - re-checking event cards');
            // Function sudah dipanggil di DOMContentLoaded, ini hanya backup
        }
        
        // Re-initialize scroll animations for desktop
        if (window.innerWidth > 768) {
            const animateElements = document.querySelectorAll('.scroll-animate');
            if (animateElements.length > 0) {
                console.log('Re-initializing scroll animations after page load');
                
                const observerOptions = {
                    threshold: 0.1,
                    rootMargin: '0px 0px -100px 0px'
                };
                
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const element = entry.target;
                            const delay = element.getAttribute('data-delay') || 0;
                            
                            setTimeout(() => {
                                element.classList.add('animate');
                            }, parseInt(delay));
                        } else {
                            entry.target.classList.remove('animate');
                        }
                    });
                }, observerOptions);
                
                animateElements.forEach(el => {
                    observer.observe(el);
                });
            }
        }
    }, 500);
});

// ===== PERFORMANCE OPTIMIZATION =====
// Use passive event listeners where possible
document.addEventListener('scroll', function() {
    // Scroll performance optimizations can be added here if needed
}, { passive: true });

// ===== DEBUGGING HELPER (UNCOMMENT FOR TESTING) =====
// window.debugScrollAnimations = function() {
//     const elements = document.querySelectorAll('.scroll-animate');
//     console.log(`Total scroll animate elements: ${elements.length}`);
//     elements.forEach((el, i) => {
//         console.log(`Element ${i + 1}:`, {
//             element: el,
//             animation: el.getAttribute('data-animation'),
//             delay: el.getAttribute('data-delay'),
//             hasAnimateClass: el.classList.contains('animate')
//         });
//     });
// };
    </script>
@endpush