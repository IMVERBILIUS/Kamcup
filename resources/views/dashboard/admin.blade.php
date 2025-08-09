@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-white rounded-4 shadow-sm p-4" style="border: 1px solid rgba(0, 97, 122, 0.1);"> {{-- Soft border using secondary color --}}
                <div class="d-flex align-items-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle me-4" style="width: 80px; height: 80px; background-image: linear-gradient(135deg, #f4b70420, #cb278620);"> {{-- Gradient background for youthful/sporty --}}
                        <i class="fas fa-user-circle fs-2" style="color: #00617a;"></i> {{-- Icon color using secondary color --}}
                    </div>
                    <div>
                        <h2 class="fs-3 fw-bold mb-1" style="color: #00617a;">Welcome, {{ Auth::user()->name }}!</h2> {{-- Text color using secondary color --}}
                        <p class="text-muted mb-0">Here's what's happening with your articles and galleries today on **Kamcup**.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        @foreach([
            ['Articles', $articles, '#cb2786', 'fas fa-newspaper'], /* Primary color */
            ['Published Articles', $articles->filter(fn($a) => strtolower(trim($a->status)) == 'published'), '#00617a', 'fas fa-check-circle'], /* Secondary color */
            ['Galleries', $galleries, '#f4b704', 'fas fa-images'], /* Accent color */
            ['Published Galleries', $galleries->filter(fn($g) => strtolower(trim($g->status)) == 'published'), '#cb2786', 'fas fa-check-circle'] /* Primary color */
        ] as $stat)
        <div class="col-md-3 mb-3">
            <div class="bg-white rounded-3 shadow-sm p-4" style="border: 1px solid {{ $stat[2] }}1A;"> {{-- Light border based on card color --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-semibold m-0" style="color: #343a40;">Total {{ $stat[0] }}</h5> {{-- Darker text for readability --}}
                    <div class="rounded-circle p-3" style="background-color: {{ $stat[2] }}; box-shadow: 0 4px 12px {{ $stat[2] }}30;"> {{-- Stronger shadow for accent --}}
                        <i class="{{ $stat[3] }}" style="color: #fff; font-size: 1.5rem;"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-center" style="color: {{ $stat[2] }};">{{ $stat[1]->count() }}</h3> {{-- Value color matches card color --}}
                <div class="progress mt-2" style="height: 6px; background-color: {{ $stat[2] }}20;"> {{-- Lighter background for progress bar --}}
                    <div class="progress-bar" role="progressbar" style="width: 100%; background-color: {{ $stat[2] }};" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row mb-4">
        @foreach([
            ['Articles', $articles, '#cb2786'], /* Primary color */
            ['Galleries', $galleries, '#f4b704'] /* Accent color */
        ] as $stat)
        <div class="col-md-6 mb-3">
            <div class="bg-white rounded-3 shadow-sm p-3" style="border: 1px solid {{ $stat[2] }}1A;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="fw-semibold m-0 fs-6" style="color: #343a40;">Total Views ({{ $stat[0] }})</h5>
                    <div class="rounded-circle p-2" style="background-color: {{ $stat[2] }}20;"> {{-- Lighter background for icon circle --}}
                        <i class="fas fa-eye" style="color: {{ $stat[2] }}; font-size: 1.25rem;"></i> {{-- Icon color matches card color --}}
                    </div>
                </div>
                <h3 class="fw-bold text-center fs-4" style="color: {{ $stat[2] }};">{{ $stat[1]->sum('views') }}</h3>
                <div class="progress mt-2" style="height: 4px; background-color: {{ $stat[2] }}20;">
                    <div class="progress-bar" role="progressbar" style="width: 100%; background-color: {{ $stat[2] }};" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row mb-4">
        @foreach([
            ['Today', $today, 'calendar-day', '#cb2786'], /* Primary color */
            ['This Week', $week, 'calendar-week', '#00617a'], /* Secondary color */
            ['This Month', $month, 'calendar-alt', '#f4b704'], /* Accent color */
            ['This Year', $year, 'calendar', '#cb2786'] /* Primary color */
        ] as $visit)
        <div class="col-md-3 mb-3">
            <div class="bg-white rounded-3 shadow-sm p-4" style="border: 1px solid {{ $visit[3] }}1A;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-semibold m-0" style="color: #343a40;">{{ $visit[0] }}</h6>
                    <i class="fas fa-{{ $visit[2] }}" style="color: {{ $visit[3] }};"></i> {{-- Icon color --}}
                </div>
                <h4 class="fw-bold text-center" style="color: {{ $visit[3] }};">{{ $visit[1] }}</h4>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row mb-4">
        <div class="col-md-6 mb-3 d-flex">
            <div class="bg-white rounded-3 shadow-sm p-4 flex-fill" style="border: 1px solid rgba(0, 97, 122, 0.1);">
                <h5 class="fw-semibold mb-3" style="color: #00617a;"> {{-- Secondary color for heading --}}
                    <i class="fas fa-chart-line me-2"></i> Page Visits
                </h5>
                <ul class="list-unstyled mb-0">
                    @foreach([
                        ['Homepage', $homeVisit, 'home', '#cb2786'], /* Primary */
                        ['Articles', $articleVisit, 'newspaper', '#00617a'], /* Secondary */
                        ['Galleries', $galleryVisit, 'images', '#f4b704'], /* Accent */
                        ['Contact', $contactVisit, 'envelope', '#cb2786'] /* Primary */
                    ] as $page)
                    <li class="mb-2">
                        <i class="fas fa-{{ $page[2] }} me-2" style="color: {{ $page[3] }};"></i>
                        {{ $page[0] }}: <strong style="color: #343a40;">{{ $page[1] }}</strong> visits
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="col-md-6 mb-3 d-flex">
            <div class="bg-white rounded-3 shadow-sm p-4 flex-fill" style="border: 1px solid rgba(0, 97, 122, 0.1);">
                <h5 class="fw-semibold mb-3" style="color: #00617a;">
                    <i class="fas fa-users me-2"></i> Total Visits
                </h5>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="fw-bold fs-4" style="color: #cb2786;">{{ $homeVisit + $articleVisit + $galleryVisit + $contactVisit }}</span> {{-- Primary color for total --}}
                </div>

                <hr style="border-color: rgba(0, 97, 122, 0.2);">

                <div>
                    <h6 class="fw-semibold mb-2" style="color: #6c757d;">Homepage Stats</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-1">
                            <i class="fas fa-calendar-day me-2" style="color: #cb2786;"></i>
                            Today: <strong style="color: #343a40;">{{ $homeVisitToday }}</strong>
                        </li>
                        <li class="mb-1">
                            <i class="fas fa-calendar-week me-2" style="color: #00617a;"></i>
                            This Week: <strong style="color: #343a40;">{{ $homeVisitWeek }}</strong>
                        </li>
                        <li class="mb-1">
                            <i class="fas fa-calendar-alt me-2" style="color: #f4b704;"></i>
                            This Month: <strong style="color: #343a40;">{{ $homeVisitMonth }}</strong>
                        </li>
                        <li>
                            <i class="fas fa-calendar me-2" style="color: #cb2786;"></i>
                            This Year: <strong style="color: #343a40;">{{ $homeVisitYear }}</strong>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="bg-white rounded-3 shadow-sm p-4" style="border: 1px solid rgba(0, 97, 122, 0.1);">
                <h5 class="fw-semibold mb-3" style="color: #00617a;">Page Visit Statistics Chart</h5>
                <canvas id="visitChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <div class="card border-0 rounded-3 shadow-sm mb-4" style="border: 1px solid rgba(0, 97, 122, 0.1);">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-semibold m-0" style="color: #00617a;">Recent Articles</h4>
                <a href="{{ route('admin.articles.index') }}" class="btn btn-sm px-3" style="background-color: #cb27861A; color: #cb2786; border-radius: 8px; font-weight: 600;">View All</a>
            </div>
            @if($articles->count())
                <div class="row">
                    @foreach($articles->take(6) as $article)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100 border-0 shadow-sm" style="border: 1px solid #f0f0f0;"> {{-- Soft border for article cards --}}
                                @if($article->thumbnail)
                                    <img src="{{ asset('storage/' . $article->thumbnail) }}" class="card-img-top" alt="{{ $article->title }}" style="height: 180px; object-fit: cover;">
                                @else
                                    <div class="bg-light d-flex justify-content-center align-items-center" style="height: 180px;">
                                        <i class="fas fa-image text-muted fa-2x"></i>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="badge rounded-pill px-3 py-2" style="background-color: {{ strtolower(trim($article->status)) == 'published' ? '#00617a1A' : '#f5f5f5' }}; color: {{ strtolower(trim($article->status)) == 'published' ? '#00617a' : '#6c757d' }};">
                                            {{ $article->status }}
                                        </span>
                                        <span class="badge rounded-pill px-3 py-2" style="background-color: #f4b7041A; color: #f4b704;">
                                            <i class="fas fa-eye me-1"></i> {{ $article->views }}
                                        </span>
                                    </div>
                                    <h5 class="card-title fw-semibold" style="color: #343a40;">{{ Str::limit($article->title, 50) }}</h5>
                                    <p class="card-text text-muted mb-3" style="height: 60px; overflow: hidden; line-height: 1.5;">{{ Str::limit($article->description, 100) }}</p>
                                    <div class="d-grid">
                                        <a href="{{ route('admin.articles.show', $article->id) }}" class="btn btn-sm" style="background-color: #cb2786; color: #fff; border-radius: 8px; font-weight: 600;"> {{-- Primary color for action button --}}
                                            View Details <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-footer text-muted text-center" style="font-size: 0.85rem; background-color: #f8f9fa;">
                                    Published on {{ \Carbon\Carbon::parse($article->created_at)->format('F d, Y') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">No recent articles found.</p>
            @endif
        </div>
    </div>

    <div class="card border-0 rounded-3 shadow-sm mb-4" style="border: 1px solid rgba(0, 97, 122, 0.1);">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-semibold m-0" style="color: #00617a;">Recent Galleries</h4>
                <a href="{{ route('admin.galleries.index') }}" class="btn btn-sm px-3" style="background-color: #f4b7041A; color: #f4b704; border-radius: 8px; font-weight: 600;">View All</a>
            </div>
            @if($galleries->count())
                <div class="row">
                    @foreach($galleries->take(6) as $gallery)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100 border-0 shadow-sm" style="border: 1px solid #f0f0f0;">
                                @if($gallery->thumbnail)
                                    <img src="{{ asset('storage/' . $gallery->thumbnail) }}" class="card-img-top" alt="{{ $gallery->title }}" style="height: 180px; object-fit: cover;">
                                @else
                                    <div class="bg-light d-flex justify-content-center align-items-center" style="height: 180px;">
                                        <i class="fas fa-image text-muted fa-2x"></i>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="badge rounded-pill px-3 py-2"
                                              style="background-color: {{ strtolower(trim($gallery->status)) == 'published' ? '#00617a1A' : '#f5f5f5' }}; color: {{ strtolower(trim($gallery->status)) == 'published' ? '#00617a' : '#6c757d' }};">
                                            {{ $gallery->status }}
                                        </span>
                                        <span class="badge rounded-pill px-3 py-2" style="background-color: #f4b7041A; color: #f4b704;">
                                            <i class="fas fa-eye me-1"></i> {{ $gallery->views }}
                                        </span>
                                    </div>
                                    <h5 class="card-title fw-semibold" style="color: #343a40;">{{ Str::limit($gallery->title, 50) }}</h5>
                                    <p class="card-text text-muted mb-3" style="height: 60px; overflow: hidden; line-height: 1.5;">{{ Str::limit($gallery->description, 100) }}</p>
                                    <div class="d-grid">
                                        <a href="{{ route('admin.galleries.show', $gallery->id) }}" class="btn btn-sm" style="background-color: #f4b704; color: #fff; border-radius: 8px; font-weight: 600;"> {{-- Accent color for action button --}}
                                            View Details <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-footer text-muted text-center" style="font-size: 0.85rem; background-color: #f8f9fa;">
                                    Published on {{ \Carbon\Carbon::parse($gallery->created_at)->format('F d, Y') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">No recent galleries found.</p>
            @endif
        </div>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('visitChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Homepage', 'Articles', 'Galleries', 'Contact'], // Added 'Contact'
            datasets: [{
                label: 'Page Visits',
                data: [{{ $homeVisit }}, {{ $articleVisit }}, {{ $galleryVisit }}, {{ $contactVisit }}], // Added $contactVisit
                backgroundColor: ['#cb2786', '#00617a', '#f4b704', '#7F8C8D'], // Updated colors for consistency, added color for Contact
                borderColor: ['#cb2786', '#00617a', '#f4b704', '#7F8C8D'],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush
@endsection
