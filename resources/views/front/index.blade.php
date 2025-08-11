@extends('../layouts/master')

@section('content')

<section class="position-relative hero-section">
    <nav class="navbar navbar-expand-lg bg-transparent py-3 position-absolute top-0 start-0 w-100 z-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('front.index') }}"
                style="width: 190px; overflow: hidden; height: 90px;">
                {{-- KAMCUP Logo with KAMCUP's primary color --}}
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
                    <li class="nav-item"><a class="nav-link fw-medium active"
                            href="{{ route('front.index') }}">HOME</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium"
                            href="{{ route('front.articles') }}">BERITA</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium"
                            href="{{ route('front.galleries') }}">GALERI</a></li>
                    {{-- Perhatian: Jika ada halaman daftar semua event, ganti '#' dengan route yang sesuai, misal 'route('front.events.index')' --}}
                    <li class="nav-item"><a class="nav-link fw-medium" href="{{ route('front.events.index') }}">EVENT</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium"
                            href="{{ route('front.contact') }}">CONTACT US</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium" href="{{ route('profile.index') }}">PROFILE</a>
                    </li> {{-- Diperbarui: Gunakan 'profile.index' --}}

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
                </ul>
            </div>
        </div>
    </nav>

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
            <a href="{{ route('front.events.index') }}" class="btn btn-lg fw-bold px-5 py-3 rounded-pill hero-btn">JELAJAHI PROMO & EVENT</a>
        </div>
    </div>
</section>


@if ($next_match)
<div class="container py-4">
    {{-- Apply card-hover-zoom and styling directly to the card --}}
    <a href="{{ route('front.events.show', $next_match->slug) }}" class="text-decoration-none">
        <div class="card bg-light border-0 shadow-sm card-hover-zoom" style="height: auto;"> {{-- Removed fixed height, it will adjust to content --}}
            <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-center">
                <h5 class="card-title fw-bold mb-2 mb-md-0 me-md-3 text-center text-md-start article-text"> {{-- Added article-text --}}
                    <span class="main-text">Match</span> <span class="highlight-text">Terdekat:</span> {{ $next_match->title }}
                </h5>
                <div class="text-center text-md-end">
                    <p class="mb-1 small text-muted article-text"> {{-- Added article-text --}}
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

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0 section-title"><span class="main-text">Artikel</span> <span
                class="highlight-text">Terbaru</span></h3>
        <a href="{{ route('front.articles') }}" class="btn btn-outline-dark lihat-semua-btn px-4">Lihat semuanya</a>
    </div>
    <div id="latestArticlesCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @forelse ($latest_articles->chunk($chunk_size) as $chunk)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <div class="row g-4">
                        @foreach ($chunk as $article)
                            <div class="col">
                                {{-- Diperbarui: Gunakan slug untuk route article --}}
                                <a href="{{ route('front.articles.show', $article->slug) }}" class="text-decoration-none">
                                    <div class="card card-hover-zoom border-0 rounded-3 overflow-hidden position-relative"
                                        style="height: 350px;">
                                        <div class="ratio ratio-16x9 mb-2">
                                            <img src="{{ asset('storage/' . $article->thumbnail) }}"
                                                class="img-fluid object-fit-cover w-100 h-100"
                                                alt="{{ $article->title }}">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center align-items-start px-3">
                                            <h5 class="fs-5 fw-semibold article-text">{{ Str::limit($article->title, 50) }}
                                            </h5>
                                            <p class="opacity-75 fs-7 clamp-text article-text">
                                                {{ Str::limit($article->description, 70) }}</p>
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
        <button class="carousel-control-prev" type="button" data-bs-target="#latestArticlesCarousel"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#latestArticlesCarousel"
            data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</div>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0 section-title"><span class="main-text">Artikel</span> <span
                class="highlight-text">Populer</span></h3>
        <a href="{{ route('front.articles') }}" class="btn btn-outline-dark lihat-semua-btn px-4">Lihat semuanya</a>
    </div>
    <div id="popularArticlesCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @forelse ($populer_articles->chunk($chunk_size) as $chunk)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <div class="row g-4">
                        @foreach ($chunk as $article)
                            <div class="col">
                                {{-- Diperbarui: Gunakan slug untuk route article --}}
                                <a href="{{ route('front.articles.show', $article->slug) }}" class="text-decoration-none">
                                    <div class="card card-hover-zoom border-0 rounded-3 overflow-hidden position-relative"
                                        style="height: 350px;">
                                        <div class="ratio ratio-16x9 mb-2">
                                            <img src="{{ asset('storage/' . $article->thumbnail) }}"
                                                class="img-fluid object-fit-cover w-100 h-100"
                                                alt="{{ $article->title }}">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center align-items-start px-3">
                                            <h5 class="fs-5 fw-semibold article-text">{{ Str::limit($article->title, 50) }}
                                            </h5>
                                            <p class="opacity-75 fs-7 clamp-text article-text">
                                                {{ Str::limit($article->description, 70) }}</p>
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
        <button class="carousel-control-prev" type="button" data-bs-target="#popularArticlesCarousel"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#popularArticlesCarousel"
            data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</div>


<div class="text-center mt-5 mt-md-4">
    <a href="{{ route('front.articles') }}" class="btn btn-outline-dark lihat-semua-btn px-4">Lihat semuanya</a>
</div>

{{-- Sponsor Utama (Satu Card dengan Tiga Logo Sejajar) --}}
<div class="container py-5">
    <h5 class="fw-bold section-title"><span class="main-text">Presented </span> <span class="highlight-text">by</span>
    </h5>
    <div class="card border rounded-3 shadow-sm p-4 bg-white">
        <div class="row g-4 justify-content-around align-items-center">

            {{-- Kolom Pertama untuk Sponsor 1 --}}
            <div class="col-auto d-flex justify-content-center">
                @if (isset($sponsorData['xxl'][0]))
                    @php $sponsor = $sponsorData['xxl'][0]; @endphp
                    <div class="text-center">
                        <img src="{{ asset('storage/' . $sponsor->logo) }}" alt="{{ $sponsor->name }}"
                            class="img-fluid" style="max-width: 180px; max-height: 80px; object-fit: contain;">
                    </div>
                @else
                    <div class="text-center text-muted">
                        <p class="mb-0">Sponsor 1</p>
                    </div>
                @endif
            </div>

            {{-- Kolom Kedua untuk Sponsor 2 --}}
            <div class="col-auto d-flex justify-content-center">
                @if (isset($sponsorData['xxl'][1]))
                    @php $sponsor = $sponsorData['xxl'][1]; @endphp
                    <div class="text-center">
                        <img src="{{ asset('storage/' . $sponsor->logo) }}" alt="{{ $sponsor->name }}"
                            class="img-fluid" style="max-width: 180px; max-height: 80px; object-fit: contain;">
                    </div>
                @else
                    <div class="text-center text-muted">
                        <p class="mb-0">Sponsor 2</p>
                    </div>
                @endif
            </div>

            {{-- Kolom Ketiga untuk Sponsor 3 --}}
            <div class="col-auto d-flex justify-content-center">
                @if (isset($sponsorData['xxl'][2]))
                    @php $sponsor = $sponsorData['xxl'][2]; @endphp
                    <div class="text-center">
                        <img src="{{ asset('storage/' . $sponsor->logo) }}" alt="{{ $sponsor->name }}"
                            class="img-fluid" style="max-width: 180px; max-height: 80px; object-fit: contain;">
                    </div>
                @else
                    <div class="text-center text-muted">
                        <p class="mb-0">Sponsor 3</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

{{-- New Card Section for Registrations --}}
<div class="container py-5">
    <div class="row row-cols-1 row-cols-md-3 g-4 text-center">
        <div class="col">
            <div
                class="card h-100 border-0 rounded-4 overflow-hidden shadow-sm p-4 d-flex flex-column justify-content-center align-items-center"
                style="background-color: var(--collab-primary); color: var(--text-light);">
                <i class="bi bi-people-fill display-4 mb-3" style="color: var(--collab-highlight);"></i>
                <h4 class="card-title fw-bold mb-3">Daftar Sebagai Tim</h4>
                <p class="card-text mb-4">Gabungkan tim Anda dan raih kemenangan bersama KAMCUP!</p>
                {{-- Diperbarui: Link ke route pembuatan tim --}}
                <a href="{{ route('team.create') }}" class="btn btn-lg fw-bold px-5 py-3 rounded-pill"
                    style="background-color: #F4B704; border-color: #F4B704; color: #212529;">DAFTAR SEKARANG</a>

            </div>
        </div>
        <div class="col">
            <div
                class="card h-100 border-0 rounded-4 overflow-hidden shadow-sm p-4 d-flex flex-column justify-content-center align-items-center"
                style="background-color: var(--collab-primary); color: var(--text-light);">
                <i class="bi bi-house-door-fill display-4 mb-3" style="color: var(--collab-highlight);"></i>
                <h4 class="card-title fw-bold mb-3">Daftar Sebagai Tuan Rumah</h4>
                <p class="card-text mb-4">Siapkan arena terbaik Anda dan selenggarakan turnamen seru!</p>
                <a href="{{ route('host-request.create') }}" class="btn btn-lg fw-bold px-5 py-3 rounded-pill"
                    style="background-color: #F4B704; border-color: #F4B704; color: #212529;">JADI TUAN RUMAH</a>

            </div>
        </div>
        <div class="col">
            <div
                class="card h-100 border-0 rounded-4 overflow-hidden shadow-sm p-4 d-flex flex-column justify-content-center align-items-center"
                style="background-color: var(--collab-primary); color: var(--text-light);">
                <i class="bi bi-heart-fill display-4 mb-3" style="color: var(--collab-highlight);"></i>
                <h4 class="card-title fw-bold mb-3">Daftar Sebagai Donatur</h4>
                <p class="card-text mb-4">Dukung perkembangan olahraga voli dan komunitas KAMCUP!</p>
                <a href="/donations" class="btn btn-lg fw-bold px-5 py-3 rounded-pill"
                    style="background-color: #F4B704; border-color: #F4B704; color: #212529;">BERI DONASI</a>
            </div>
        </div>
    </div>
</div>

<div class="container py-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold section-title"><span class="main-text">UPCOMING</span> <span
                class="highlight-text">EVENT</span></h3>
        {{-- Perhatian: Jika ada halaman daftar semua event, ganti '#' dengan route yang sesuai, misal 'route('front.events.index')' --}}
        <a href="{{ route('front.events.index') }}" class="btn btn-outline-dark see-all-btn px-4 rounded-pill">Lihat semuanya</a>
    </div>
    <div id="upcomingEventsCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @forelse ($events->chunk($chunk_size) as $chunk)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <div class="row g-4">
                        @foreach ($chunk as $event)
                            <div class="col">
                                <div class="card event-card border-0 rounded-4 overflow-hidden">
                                    <div class="ratio ratio-16x9 mb-2">
                                        <img src="{{ asset('storage/' . $event->thumbnail) }}"
                                            class="img-fluid object-fit-cover w-100 h-100" alt="{{ $event->title }}">
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        {{-- JUDUL TURNAMEN & TANGGAL --}}
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h5 class="card-title fw-bold mb-0 me-2 flex-grow-1 text-truncate" style="max-width: calc(100% - 70px);">{{ Str::limit($event->title, 20) }}
                                            </h5>
                                            <span class="small text-muted text-end flex-shrink-0">
                                                {{ \Carbon\Carbon::parse($event->registration_start)->format('d M') }}
                                                @if (\Carbon\Carbon::parse($event->registration_start)->format('Y') !=
                                                         \Carbon\Carbon::parse($event->registration_end)->format('Y'))
                                                    - {{ \Carbon\Carbon::parse($event->registration_end)->format('d M Y') }}
                                                @else
                                                    - {{ \Carbon\Carbon::parse($event->registration_end)->format('d M') }}
                                                    {{ \Carbon\Carbon::parse($event->registration_end)->format('Y') }}
                                                @endif
                                            </span>
                                        </div>

                                        {{-- GENDER --}}
                                        <p class="card-text small text-muted mb-2 d-flex align-items-center">
                                            <i class="bi bi-gender-ambiguous me-2"></i> {{ $event->gender_category }}
                                        </p>

                                        {{-- LOKASI & STATUS --}}
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <p class="card-text small text-muted mb-0 d-flex align-items-center me-2 flex-grow-1 text-truncate">
                                                <i class="bi bi-geo-alt me-2"></i> {{ Str::limit($event->location, 20) }}
                                            </p>
                                            @php
                                                $statusClass = '';
                                                switch ($event->status) {
                                                    case 'completed':
                                                        $statusClass = 'status-completed';
                                                        break;
                                                    case 'ongoing':
                                                        $statusClass = 'status-ongoing';
                                                        break;
                                                    case 'registration':
                                                        $statusClass = 'status-registration';
                                                        break;
                                                    default:
                                                        $statusClass = '';
                                                        break;
                                                }
                                            @endphp
                                            <span class="event-status-badge {{ $statusClass }} flex-shrink-0">
                                                {{ ucfirst($event->status) }}
                                            </span>
                                        </div>

                                        {{-- PARTISIPAN (DIHAPUS) & LOGO SPONSOR --}}
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            {{-- Logo Sponsor (ambil yang pertama jika ada banyak) --}}
                                            @if ($event->sponsors->isNotEmpty())
                                                <img src="{{ asset('storage/' . $event->sponsors->first()->logo) }}"
                                                    alt="Sponsor Logo"
                                                    style="max-height: 25px; max-width: 60px; object-fit: contain; flex-shrink: 0;">
                                            @endif
                                        </div>

                                        {{-- Tautan ke halaman detail event --}}
                                        {{-- Diperbarui: Gunakan slug untuk route event --}}
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
        <button class="carousel-control-prev" type="button" data-bs-target="#upcomingEventsCarousel"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#upcomingEventsCarousel"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<div class="container py-5 mt-md-5">
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

{{-- Galleries --}}
<div class="container py-5">
    <div class="carousel-container">
        <h2 class="carousel-title">Galeri</h2>
        <p class="carousel-subtitle"></p>
        <div class="carousel">
            <button class="nav-button left">&#10094;</button>
            <div class="carousel-images">
                @forelse ($galleries as $gallery)
                    {{-- Diperbarui: Gunakan slug untuk route gallery --}}
                    <a href="{{ route('front.galleries.show', $gallery->slug) }}" class="image-item">
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

<div class="text-center mt-4 mb-5">
    <a href="{{ route('front.galleries') }}" class="btn btn-outline-dark lihat-semua-btn px-4">Lihat semuanya</a>
</div>

{{-- Bagian PARTNER & SPONSOR KAMI --}}
<div class="container-fluid py-5" style="background-color: #0F62FF;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold section-title text-white">PARTNER & SPONSOR KAMI</h3>
            <a href="#" class="btn px-4 rounded-pill fw-bold"
                style="background-color: #ECBF00; color: #212529; border-color: #ECBF00;">MINAT JADI PARTNER?</a>
        </div>

        @php
            // Define the order and column sizes for display
            $sponsorSizes = [
                'xxl' => ['cols_md' => 2, 'cols_lg' => 2, 'max_width' => '220px', 'max_height' => '100px', 'p_size' => 4, 'limit' => 2],
                'xl' => ['cols_md' => 3, 'cols_lg' => 3, 'max_width' => '180px', 'max_height' => '90px', 'p_size' => 4, 'limit' => 3],
                'l' => ['cols_md' => 3, 'cols_lg' => 3, 'max_width' => '150px', 'max_height' => '75px', 'p_size' => 4, 'limit' => 3],
                'm' => ['cols_md' => 6, 'cols_lg' => 6, 'max_width' => '100px', 'max_height' => '50px', 'p_size' => 3, 'limit' => 6],
                's' => ['cols_md' => 6, 'cols_lg' => 6, 'max_width' => '80px', 'max_height' => '40px', 'p_size' => 3, 'limit' => 6],
            ];
            // Urutan kategori untuk perulangan
            $displayOrder = ['xxl', 'xl', 'l', 'm', 's'];
        @endphp

        @foreach ($displayOrder as $size)
            @if (isset($sponsorData[$size]) && $sponsorData[$size]->isNotEmpty())
                <div
                    class="row row-cols-1
                    row-cols-md-{{ $sponsorSizes[$size]['cols_md'] }}
                    row-cols-lg-{{ $sponsorSizes[$size]['cols_lg'] }}
                    g-4 text-center mb-4
                    @if ($size === 'xxl') justify-content-center @endif">
                    @foreach ($sponsorData[$size]->take($sponsorSizes[$size]['limit']) as $sponsor)
                        <div class="col">
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        /* Define your custom property for the shadow color */
        :root {
            --shadow-color-cf2585: #CF2585; /* Your specified magenta color */
        }

        /* Styles for the "Daftar Sebagai Tim", "JADI TUAN RUMAH", "BERI DONASI" buttons */
        /* Explicitly set background, border, and text color to yellow from --collab-highlight */
        .card a.btn { /* Target buttons inside a card specifically */
            background-color: #F4B704 !important; /* Explicit Yellow */
            border-color: #F4B704 !important; /* Explicit Yellow */
            color: #212529 !important; /* Explicit Dark Text */
            transition: all 0.3s ease;
            /* rounded-pill is already on the HTML element */
        }

        /* Hover effect for these specific yellow buttons */
        .card a.btn:hover {
            background-color: #e0ac00 !important; /* A slightly darker yellow for hover */
            border-color: #e0ac00 !important;
            color: #212529 !important;
        }

        /* Status Badges for Event Cards (from event_detail styling) */
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
            color: white; /* Default text color */
        }

        .event-status-badge.status-registration {
            background-color: #F4B704; /* Yellow */
            color: #212529; /* Dark text for yellow */
        }

        /* Custom styles for the new "Match Terdekat" section */
        .highlight-text {
            color: #F4B704; /* Example yellow color */
        }
        .main-text {
            color: #0F62FF; /* Example blue color */
        }
        /* Optional: adjust font size for the match title if needed */
        .card-title.fw-bold {
            font-size: 1.25rem; /* Default for h5, but can be adjusted */
        }
        @media (max-width: 767.98px) {
            .card-body.flex-column {
                align-items: center !important;
            }
            .card-title.fw-bold {
                text-align: center !important;
                margin-bottom: 0.5rem !important;
            }
            .btn-sm {
                width: 100%; /* Make button full width on small screens */
            }
        }

        /* Styles for card-hover-zoom and article-text for consistency */
        .card-hover-zoom {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out; /* Add box-shadow to transition */
            box-shadow:
                8px 8px 0px 0px var(--shadow-color-cf2585), /* Shadow magenta tebal */
                5px 5px 15px rgba(0, 0, 0, 0.1) !important; /* Shadow lembut di belakang, with !important */
        }

        .card-hover-zoom:hover {
            transform: translateY(-5px);
        }

        .card-hover-zoom img {
            transition: transform 0.3s ease-in-out;
        }

        .card-hover-zoom:hover img {
            transform: scale(1.05);
        }

        .article-text {
            color: #212529; /* Ensure text color is consistent with dark theme if applicable */
        }

        /* Specific styles for the "Match Terdekat" card to mimic article cards */
        .match-terdekat-card {
            /* No fixed height, adjust to content as it's not an image card */
            display: flex;
            flex-direction: column;
        }
        .match-terdekat-card .card-body {
            flex-grow: 1; /* Allow the body to grow and fill space */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding: 1rem; /* Adjust padding as needed */
        }

        /* CSS for text truncation (if not using Bootstrap's text-truncate) */
        .text-truncate {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
@endpush

@push('scripts')
    {{-- Pastikan file carousel_gallery.js ini ada di public/js/ --}}
    <script src="{{ asset('js/carousel_gallery.js') }}"></script>
    <script>
        // This part is for the custom gallery carousel.
        const carouselImagesContainer = document.querySelector('.carousel-images');
        const leftButton = document.querySelector('.nav-button.left');
        const rightButton = document.querySelector('.nav-button.right');

        if (carouselImagesContainer && leftButton && rightButton) {
            const scrollAmount = () => {
                let itemWidth = carouselImagesContainer.querySelector('.image-item')?.offsetWidth;
                return itemWidth ? itemWidth + 30 : carouselImagesContainer.offsetWidth / 2; // Increased gap to 30px
            }

            leftButton.addEventListener('click', () => {
                carouselImagesContainer.scrollBy({
                    left: -scrollAmount(),
                    behavior: 'smooth'
                });
            });

            rightButton.addEventListener('click', () => {
                carouselImagesContainer.scrollBy({
                    left: scrollAmount(),
                    behavior: 'smooth'
                });
            });
        }
    </script>
@endpush
