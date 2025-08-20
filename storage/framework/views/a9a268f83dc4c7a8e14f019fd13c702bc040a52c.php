<?php $__env->startSection('body-class', 'home-page'); ?>

<?php $__env->startSection('content'); ?>


<nav class="navbar navbar-expand-lg bg-transparent py-3 position-absolute top-0 start-0 w-100 z-3 navbar-transparent">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="<?php echo e(route('front.index')); ?>"
            style="width: 190px; overflow: hidden; height: 90px;">
            <img src="<?php echo e(asset('assets/img/logo4.png')); ?>" alt="KAMCUP Logo" class="me-2 brand-logo"
                style="height: 100%; width: 100%; object-fit: cover;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"
                style="background-image: url('data:image/svg+xml;charset=utf8,%3Csvg viewBox=\'0 0 30 30\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath stroke=\'rgba%28255, 255, 255, 0.95%29\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-miterlimit=\'10\' d=\'M4 7h22M4 15h22M4 23h22\'/%3E%3C/svg%3E');"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
                <li class="nav-item"><a class="nav-link fw-medium" href="<?php echo e(route('front.index')); ?>">HOME</a></li>
                <li class="nav-item"><a class="nav-link fw-medium" href="<?php echo e(route('front.articles')); ?>">BERITA</a></li>
                <li class="nav-item"><a class="nav-link fw-medium" href="<?php echo e(route('front.galleries')); ?>">GALERI</a></li>
                <li class="nav-item"><a class="nav-link fw-medium" href="<?php echo e(route('front.events.index')); ?>">EVENT</a></li>
                <li class="nav-item"><a class="nav-link fw-medium" href="<?php echo e(route('front.contact')); ?>">CONTACT US</a></li>
                <li class="nav-item"><a class="nav-link fw-medium" href="<?php echo e(route('profile.index')); ?>">PROFILE</a></li>
                <?php if(auth()->guard()->guest()): ?>
                    <li class="nav-item"><a class="nav-link fw-medium" href="<?php echo e(route('login')); ?>">LOGIN</a></li>
                <?php else: ?>
                    <li class="nav-item">
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-outline-light ms-lg-3">LOGOUT</button>
                        </form>
                    </li>
                <?php endif; ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navbar-translate','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('navbar-translate'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<section class="position-relative hero-section">
    <div class="position-relative vh-100 d-flex align-items-center overflow-hidden">
        <img src="<?php echo e(asset('assets/img/jpn.jpg')); ?>" class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover z-1" alt="Volleyball Action Hero Image">
        <div class="container position-relative text-white z-2 text-center hero-content">
            <h1 class="display-3 fw-bold mb-4 hero-title"><br>Energi Sportif, Kemudahan Finansial!</h1>
            <p class="lead mb-5 hero-description">
                Bergabunglah dengan KAMCUP dan Bale by BTN dalam mewujudkan semangat <span class="highlight-text">
                    olahraga, inovasi, dan kekeluargaan.</span> Kami berkomitmen untuk menciptakan <span
                    class="highlight-text">komunitas</span> <span class="highlight-text">aktif,</span> suportif, dan
                penuh<span class="highlight-text"> pertumbuhan </span> para generasi muda visioner.
            </p>
            <a href="<?php echo e(route('front.events.index')); ?>" class="btn btn-lg fw-bold px-5 py-3 rounded-pill hero-btn">JELAJAHI PROMO & EVENT</a>
        </div>
    </div>
</section>

<?php if($next_match): ?>
<div class="container py-4">
    <a href="<?php echo e(route('front.events.show', $next_match->slug)); ?>" class="text-decoration-none">
        <div class="card bg-light border-0 shadow-sm card-hover-zoom" style="height: auto;">
            <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-center">
                <h5 class="card-title fw-bold mb-2 mb-md-0 me-md-3 text-center text-md-start article-text">
                    <span class="main-text">Match</span> <span class="highlight-text">Terdekat:</span> <?php echo e($next_match->title); ?>

                </h5>
                <div class="text-center text-md-end">
                    <p class="mb-1 small text-muted article-text">
                        <i class="bi bi-calendar me-1"></i>
                        <?php echo e(\Carbon\Carbon::parse($next_match->registration_start)->format('d M Y')); ?>

                        <?php if($next_match->registration_start != $next_match->registration_end): ?>
                            - <?php echo e(\Carbon\Carbon::parse($next_match->registration_end)->format('d M Y')); ?>

                        <?php endif; ?>
                    </p>
                    <a href="<?php echo e(route('front.events.show', $next_match->slug)); ?>" class="btn btn-sm btn-outline-primary mt-2 mt-md-0">Segera Daftar</a>
                </div>
            </div>
        </div>
    </a>
</div>
<?php endif; ?>


<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0 section-title"><span class="main-text">Artikel</span> <span
                class="highlight-text">Terbaru</span></h3>
        <a href="<?php echo e(route('front.articles')); ?>" class="btn btn-outline-dark lihat-semua-btn px-4">Lihat semuanya</a>
    </div>
    <div id="latestArticlesCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-inner">
            <?php $__empty_1 = true; $__currentLoopData = $latest_articles->chunk($chunk_size); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunkIndex => $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="carousel-item <?php echo e($loop->first ? 'active' : ''); ?>">
                    <div class="row gx-3 gy-3">
                        <?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-12 col-md-6 col-lg-4">
                                <a href="<?php echo e(route('front.articles.show', $article->slug)); ?>" class="text-decoration-none">
                                    <div class="card card-hover-zoom border-0 rounded-3 overflow-hidden h-100">
                                        <div class="ratio ratio-16x9">
                                            <img src="<?php echo e(asset('storage/' . $article->thumbnail)); ?>"
                                                class="img-fluid object-fit-cover w-100 h-100"
                                                alt="<?php echo e($article->title); ?>">
                                        </div>
                                        <div class="card-body d-flex flex-column px-3 py-3">
                                            <h5 class="card-title fw-semibold mb-2"><?php echo e(Str::limit($article->title, 60)); ?></h5>
                                            <p class="card-text text-muted mb-0 flex-grow-1"><?php echo e(Str::limit($article->description, 80)); ?></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="carousel-item active">
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">Artikel terbaru akan segera hadir!</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        
        <button class="carousel-control-prev d-none d-md-flex" type="button" data-bs-target="#latestArticlesCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next d-none d-md-flex" type="button" data-bs-target="#latestArticlesCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        
        
        <?php if($latest_articles->count() > $chunk_size): ?>
        <div class="carousel-indicators d-md-none position-relative mt-3 mb-0">
            <?php $__currentLoopData = $latest_articles->chunk($chunk_size); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunkIndex => $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button type="button" data-bs-target="#latestArticlesCarousel" data-bs-slide-to="<?php echo e($chunkIndex); ?>" 
                        class="<?php echo e($chunkIndex === 0 ? 'active' : ''); ?>" aria-current="<?php echo e($chunkIndex === 0 ? 'true' : 'false'); ?>" 
                        aria-label="Slide <?php echo e($chunkIndex + 1); ?>"></button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>
    </div>
</div>


<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0 section-title"><span class="main-text">Artikel</span> <span
                class="highlight-text">Populer</span></h3>
        <a href="<?php echo e(route('front.articles')); ?>" class="btn btn-outline-dark lihat-semua-btn px-4">Lihat semuanya</a>
    </div>
    <div id="popularArticlesCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-inner">
            <?php $__empty_1 = true; $__currentLoopData = $populer_articles->chunk($chunk_size); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunkIndex => $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="carousel-item <?php echo e($loop->first ? 'active' : ''); ?>">
                    <div class="row gx-3 gy-3">
                        <?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-12 col-md-6 col-lg-4">
                                <a href="<?php echo e(route('front.articles.show', $article->slug)); ?>" class="text-decoration-none">
                                    <div class="card card-hover-zoom border-0 rounded-3 overflow-hidden h-100">
                                        <div class="ratio ratio-16x9">
                                            <img src="<?php echo e(asset('storage/' . $article->thumbnail)); ?>"
                                                class="img-fluid object-fit-cover w-100 h-100"
                                                alt="<?php echo e($article->title); ?>">
                                        </div>
                                        <div class="card-body d-flex flex-column px-3 py-3">
                                            <h5 class="card-title fw-semibold mb-2"><?php echo e(Str::limit($article->title, 60)); ?></h5>
                                            <p class="card-text text-muted mb-0 flex-grow-1"><?php echo e(Str::limit($article->description, 80)); ?></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="carousel-item active">
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">Artikel populer akan segera hadir!</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        
        <button class="carousel-control-prev d-none d-md-flex" type="button" data-bs-target="#popularArticlesCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next d-none d-md-flex" type="button" data-bs-target="#popularArticlesCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        
        
        <?php if($populer_articles->count() > $chunk_size): ?>
        <div class="carousel-indicators d-md-none position-relative mt-3 mb-0">
            <?php $__currentLoopData = $populer_articles->chunk($chunk_size); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunkIndex => $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button type="button" data-bs-target="#popularArticlesCarousel" data-bs-slide-to="<?php echo e($chunkIndex); ?>" 
                        class="<?php echo e($chunkIndex === 0 ? 'active' : ''); ?>" aria-current="<?php echo e($chunkIndex === 0 ? 'true' : 'false'); ?>" 
                        aria-label="Slide <?php echo e($chunkIndex + 1); ?>"></button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<div class="text-center mt-5 mt-md-4">
    <a href="<?php echo e(route('front.articles')); ?>" class="btn btn-outline-dark lihat-semua-btn px-4">Lihat semuanya</a>
</div>


<div class="container py-5">
    <h5 class="fw-bold section-title"><span class="main-text">Presented </span> <span class="highlight-text">by</span>
    </h5>
    <div class="card border rounded-3 shadow-sm p-4 bg-white">
        <div class="row g-4 justify-content-around align-items-center">
            <div class="col-auto d-flex justify-content-center">
                <?php if(isset($sponsorData['xxl'][0])): ?>
                    <?php $sponsor = $sponsorData['xxl'][0]; ?>
                    <div class="text-center btn-ylw" style="transition: transform 0.3s;">
                        <img src="<?php echo e(asset('storage/' . $sponsor->logo)); ?>" alt="<?php echo e($sponsor->name); ?>"
                            class="img-fluid" style="max-width: 180px; max-height: 80px; object-fit: contain;">
                    </div>
                <?php else: ?>
                    <div class="text-center text-muted btn-ylw" style="transition: transform 0.3s;">
                        <p class="mb-0">Sponsor 1</p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-auto d-flex justify-content-center">
                <?php if(isset($sponsorData['xxl'][1])): ?>
                    <?php $sponsor = $sponsorData['xxl'][1]; ?>
                    <div class="text-center">
                        <img src="<?php echo e(asset('storage/' . $sponsor->logo)); ?>" alt="<?php echo e($sponsor->name); ?>"
                            class="img-fluid" style="max-width: 180px; max-height: 80px; object-fit: contain;">
                    </div>
                <?php else: ?>
                    <div class="text-center text-muted btn-ylw" style="transition: transform 0.3s;">
                        <p class="mb-0">Sponsor 2</p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-auto d-flex justify-content-center">
                <?php if(isset($sponsorData['xxl'][2])): ?>
                    <?php $sponsor = $sponsorData['xxl'][2]; ?>
                    <div class="text-center">
                        <img src="<?php echo e(asset('storage/' . $sponsor->logo)); ?>" alt="<?php echo e($sponsor->name); ?>"
                            class="img-fluid" style="max-width: 180px; max-height: 80px; object-fit: contain;">
                    </div>
                <?php else: ?>
                    <div class="text-center text-muted btn-ylw" style="transition: transform 0.3s;">
                        <p class="mb-0">Sponsor 3</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<div class="container py-5">
    <div class="row row-cols-1 row-cols-md-3 g-4 text-center">
        <div class="col">
            <div class="card h-100 border-0 rounded-4 overflow-hidden shadow-sm p-3 p-md-4 d-flex flex-column justify-content-center align-items-center"
                style="background-color: var(--collab-primary); color: var(--text-light); position: relative;">
                <i class="bi bi-people-fill display-4 mb-3" style="color: var(--collab-highlight);"></i>
                <h4 class="card-title fw-bold mb-3">Daftar Sebagai Tim</h4>
                <p class="card-text mb-4">Gabungkan tim Anda dan raih kemenangan bersama KAMCUP!</p>
                <a href="<?php echo e(route('team.create')); ?>" 
                   class="btn fw-bold px-4 py-2 rounded-pill registration-btn"
                   style="background-color: #F4B704; border-color: #F4B704; color: #212529; position: relative; z-index: 100; text-decoration: none;">
                   DAFTAR SEKARANG
                </a>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 border-0 rounded-4 overflow-hidden shadow-sm p-3 p-md-4 d-flex flex-column justify-content-center align-items-center"
                style="background-color: var(--collab-primary); color: var(--text-light); position: relative;">
                <i class="bi bi-house-door-fill display-4 mb-3" style="color: var(--collab-highlight);"></i>
                <h4 class="card-title fw-bold mb-3">Daftar Sebagai Tuan Rumah</h4>
                <p class="card-text mb-4">Siapkan arena terbaik Anda dan selenggarakan turnamen seru!</p>
                <a href="<?php echo e(route('host-request.create')); ?>" 
                   class="btn fw-bold px-4 py-2 rounded-pill registration-btn"
                   style="background-color: #F4B704; border-color: #F4B704; color: #212529; position: relative; z-index: 100; text-decoration: none;">
                   JADI TUAN RUMAH
                </a>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 border-0 rounded-4 overflow-hidden shadow-sm p-3 p-md-4 d-flex flex-column justify-content-center align-items-center"
                style="background-color: var(--collab-primary); color: var(--text-light); position: relative;">
                <i class="bi bi-heart-fill display-4 mb-3" style="color: var(--collab-highlight);"></i>
                <h4 class="card-title fw-bold mb-3">Daftar Sebagai Donatur</h4>
                <p class="card-text mb-4">Dukung perkembangan olahraga voli dan komunitas KAMCUP!</p>
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('donations.create')); ?>" 
                       class="btn fw-bold px-4 py-2 rounded-pill registration-btn"
                       style="background-color: #F4B704; border-color: #F4B704; color: #212529; position: relative; z-index: 100; text-decoration: none;">
                       BERI DONASI
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" 
                       class="btn fw-bold px-4 py-2 rounded-pill registration-btn"
                       style="background-color: #F4B704; border-color: #F4B704; color: #212529; position: relative; z-index: 100; text-decoration: none;">
                       DONASI
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<div class="container py-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold section-title"><span class="main-text">UPCOMING</span> <span
                class="highlight-text">EVENT</span></h3>
        <a href="<?php echo e(route('front.events.index')); ?>" class="btn btn-outline-dark see-all-btn px-4 rounded-pill">Lihat semuanya</a>
    </div>
    <div id="upcomingEventsCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php $__empty_1 = true; $__currentLoopData = $events->chunk($chunk_size); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="carousel-item <?php echo e($loop->first ? 'active' : ''); ?>">
                    <div class="row g-4">
                        <?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col">
                                <div class="card event-card border-0 rounded-4 overflow-hidden">
                                    <div class="ratio ratio-16x9 mb-2">
                                        <img src="<?php echo e(asset('storage/' . $event->thumbnail)); ?>"
                                            class="img-fluid object-fit-cover w-100 h-100" alt="<?php echo e($event->title); ?>">
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h5 class="card-title fw-bold mb-0 me-2 flex-grow-1 text-truncate" style="max-width: calc(100% - 70px);"><?php echo e(Str::limit($event->title, 20)); ?>

                                            </h5>
                                            <span class="small text-muted text-end flex-shrink-0">
                                                <?php echo e(\Carbon\Carbon::parse($event->registration_start)->format('d M')); ?>

                                                <?php if(\Carbon\Carbon::parse($event->registration_start)->format('Y') != \Carbon\Carbon::parse($event->registration_end)->format('Y')): ?>
                                                    - <?php echo e(\Carbon\Carbon::parse($event->registration_end)->format('d M Y')); ?>

                                                <?php else: ?>
                                                    - <?php echo e(\Carbon\Carbon::parse($event->registration_end)->format('d M')); ?>

                                                    <?php echo e(\Carbon\Carbon::parse($event->registration_end)->format('Y')); ?>

                                                <?php endif; ?>
                                            </span>
                                        </div>
                                        <p class="card-text small text-muted mb-2 d-flex align-items-center">
                                            <i class="bi bi-gender-ambiguous me-2"></i> <?php echo e($event->gender_category); ?>

                                        </p>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <p class="card-text small text-muted mb-0 d-flex align-items-center me-2 flex-grow-1 text-truncate">
                                                <i class="bi bi-geo-alt me-2"></i> <?php echo e(Str::limit($event->location, 20)); ?>

                                            </p>
                                            <?php
                                                $statusClass = '';
                                                switch ($event->status) {
                                                    case 'completed': $statusClass = 'status-completed'; break;
                                                    case 'ongoing': $statusClass = 'status-ongoing'; break;
                                                    case 'registration': $statusClass = 'status-registration'; break;
                                                    default: $statusClass = ''; break;
                                                }
                                            ?>
                                            <span class="event-status-badge <?php echo e($statusClass); ?> flex-shrink-0">
                                                <?php echo e(ucfirst($event->status)); ?>

                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <?php if($event->sponsors->isNotEmpty()): ?>
                                                <img src="<?php echo e(asset('storage/' . $event->sponsors->first()->logo)); ?>"
                                                    alt="Sponsor Logo"
                                                    style="max-height: 25px; max-width: 60px; object-fit: contain; flex-shrink: 0;">
                                            <?php endif; ?>
                                        </div>
                                        <a href="<?php echo e(route('front.events.show', $event->slug)); ?>"
                                            class="mt-auto stretched-link">Detail Event & Daftar</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="carousel-item active">
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">Akan segera hadir! Nantikan event-event seru dari kami.</p>
                    </div>
                </div>
            <?php endif; ?>
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

<div class="container py-5 mt-md-5">
    <div class="text-center sponsor-section-header mb-4">
        <p class="mb-0 fw-bold fs-4">Materi Promosi BY
            <?php if(isset($sponsorData['xxl']) && $sponsorData['xxl']->isNotEmpty()): ?>
                <?php echo e($sponsorData['xxl']->first()->name); ?>

            <?php else: ?>
                Para Mitra Hebat Kami
            <?php endif; ?>
        </p>
    </div>
</div>

<div class="container py-5">
    <div class="carousel-container">
        <h2 class="carousel-title">Galeri</h2>
        <p class="carousel-subtitle"></p>
        <div class="carousel">
            <button class="nav-button left">&#10094;</button>
            <div class="carousel-images">
                <?php $__empty_1 = true; $__currentLoopData = $galleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(route('front.galleries.show', $gallery->slug)); ?>" class="image-item">
                        <img src="<?php echo e(asset('storage/' . $gallery->thumbnail)); ?>" alt="<?php echo e($gallery->title); ?>" />
                        <h1><?php echo e(Str::limit($gallery->title, 30)); ?></h1>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-center text-muted w-100">Galeri akan segera diisi dengan momen-momen seru!</p>
                <?php endif; ?>
            </div>
            <button class="nav-button right">&#10095;</button>
        </div>
    </div>
</div>

<div class="text-center mt-4 mb-5">
    <a href="<?php echo e(route('front.galleries')); ?>" class="btn btn-outline-dark lihat-semua-btn px-4">Lihat semuanya</a>
</div>

<div class="container-fluid py-5" style="background-color: #0F62FF;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold section-title text-white">PARTNER & SPONSOR KAMI</h3>
            <a href="#" class="btn px-4 rounded-pill fw-bold"
                style="background-color: #ECBF00; color: #212529; border-color: #ECBF00;">MINAT JADI PARTNER?</a>
        </div>
        <?php
            $sponsorSizes = [
                'xxl' => ['cols_md' => 2, 'cols_lg' => 2, 'max_width' => '220px', 'max_height' => '100px', 'p_size' => 4, 'limit' => 2],
                'xl' => ['cols_md' => 3, 'cols_lg' => 3, 'max_width' => '180px', 'max_height' => '90px', 'p_size' => 4, 'limit' => 3],
                'l' => ['cols_md' => 3, 'cols_lg' => 3, 'max_width' => '150px', 'max_height' => '75px', 'p_size' => 4, 'limit' => 3],
                'm' => ['cols_md' => 6, 'cols_lg' => 6, 'max_width' => '100px', 'max_height' => '50px', 'p_size' => 3, 'limit' => 6],
                's' => ['cols_md' => 6, 'cols_lg' => 6, 'max_width' => '80px', 'max_height' => '40px', 'p_size' => 3, 'limit' => 6],
            ];
            $displayOrder = ['xxl', 'xl', 'l', 'm', 's'];
        ?>
        <?php $__currentLoopData = $displayOrder; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(isset($sponsorData[$size]) && $sponsorData[$size]->isNotEmpty()): ?>
                <div
                    class="row row-cols-1 row-cols-md-<?php echo e($sponsorSizes[$size]['cols_md']); ?> row-cols-lg-<?php echo e($sponsorSizes[$size]['cols_lg']); ?> g-4 text-center mb-4 <?php if($size === 'xxl'): ?> justify-content-center <?php endif; ?>">
                    <?php $__currentLoopData = $sponsorData[$size]->take($sponsorSizes[$size]['limit']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sponsor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col">
                            <div class="p-<?php echo e($sponsorSizes[$size]['p_size']); ?> border rounded-3 sponsor-box sponsor-<?php echo e($size); ?> h-100 d-flex flex-column justify-content-center align-items-center bg-white text-dark">
                                <img src="<?php echo e(asset('storage/' . $sponsor->logo)); ?>" alt="<?php echo e($sponsor->name); ?>"
                                    class="img-fluid mb-2"
                                    style="max-width: <?php echo e($sponsorSizes[$size]['max_width']); ?>; max-height: <?php echo e($sponsorSizes[$size]['max_height']); ?>; object-fit: contain;">
                                <p class="fw-bold mb-0"><?php echo e($sponsor->name); ?></p>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        :root { --shadow-color-cf2585: #CF2585; }
        
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
        
        /* Event cards zoom lebih kecil */
        .event-card.card-hover-zoom:hover {
            transform: scale(1.03);
            z-index: 10;
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

        /* Article card standardization */
        .carousel-item .card {
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
        .carousel-item .card .ratio {
            flex: 0 0 200px !important;
            height: 200px !important;
            margin-bottom: 0 !important;
            border-radius: 12px 12px 0 0 !important;
            overflow: hidden !important;
        }

        .carousel-item .card .ratio img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            object-position: center !important;
        }

        /* Card body standardization */
        .carousel-item .card .card-body {
            flex: 1 1 auto !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: flex-start !important;
            align-items: flex-start !important;
            padding: 1rem !important;
            text-align: left !important;
        }

        /* Title styling */
        .carousel-item .card h5 {
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
        .carousel-item .card p {
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

        /* Hover effects */
        .carousel-item .card-hover-zoom {
            transition: transform 0.3s ease, box-shadow 0.3s ease !important;
        }

        .carousel-item .card-hover-zoom:hover {
            transform: translateY(-5px) !important;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
        }

        /* Link styling */
        .carousel-item a {
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

        /* ===== RESPONSIVE FIXES ===== */

        /* Tablet view */
        @media (max-width: 991.98px) {
            .carousel-item .row {
                flex-wrap: wrap !important;
            }
            
            .carousel-item .col {
                flex: 1 1 calc(50% - 1rem) !important;
                max-width: calc(50% - 1rem) !important;
                margin-bottom: 1rem !important;
            }
            
            .carousel-item .card {
                height: 320px !important;
            }
            
            .carousel-item .card .ratio {
                flex: 0 0 180px !important;
                height: 180px !important;
            }
            
            .carousel-item .card h5 {
                font-size: 0.95rem !important;
            }
            
            .carousel-item .card p {
                font-size: 0.8rem !important;
            }
        }

        /* PERBAIKAN KHUSUS MOBILE */
        @media (max-width: 767.98px) {
            /* Reset zoom untuk card registrasi dan event agar tidak mengganggu layout */
            .card.h-100 { 
                transition: none !important;
                transform: none !important;
                z-index: auto !important;
            }
            
            .card.h-100:hover { 
                transform: none !important;
                z-index: auto !important;
            }
            
            .event-card { 
                transition: none !important;
                transform: none !important;
                z-index: auto !important;
            }
            
            .event-card:hover {
                transform: none !important;
                z-index: auto !important;
            }
            
            /* KEEP ZOOM UNTUK ARTIKEL - dengan efek yang diperkecil */
            .carousel-item .card-hover-zoom { 
                transition: transform 0.2s ease !important;
                transform: scale(1) !important;
                z-index: 1 !important;
            }
            
            /* Active state untuk touch di artikel */
            .carousel-item .card-hover-zoom:active { 
                transform: scale(1.02) !important;
                z-index: 5 !important;
                transition: transform 0.1s ease !important;
            }
            
            /* Hover untuk artikel (untuk device yang support hover) */
            .carousel-item .card-hover-zoom:hover { 
                transform: scale(1.02) !important;
                z-index: 5 !important;
            }
            
            .carousel-item .card-hover-zoom:hover img { 
                transform: scale(1.01) !important;
            }
            
            .carousel-item .card-hover-zoom img { 
                transition: transform 0.2s ease-in-out !important;
            }

            /* Article carousel mobile layout */
            .carousel-item .row {
                flex-direction: column !important;
                flex-wrap: nowrap !important;
            }
            
            .carousel-item .col {
                flex: 1 1 100% !important;
                max-width: 100% !important;
                padding: 0 1rem !important;
                margin-bottom: 1rem !important;
            }
            
            .carousel-item .card {
                height: 300px !important;
                max-width: 100% !important;
                margin: 0 auto !important;
            }
            
            .carousel-item .card .ratio {
                flex: 0 0 160px !important;
                height: 160px !important;
            }
            
            .carousel-item .card .card-body {
                padding: 0.75rem !important;
            }
            
            .carousel-item .card h5 {
                font-size: 0.9rem !important;
                height: 2.4rem !important;
            }
            
            .carousel-item .card p {
                font-size: 0.75rem !important;
                -webkit-line-clamp: 2 !important;
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

        /* Small mobile */
        @media (max-width: 575.98px) {
            .carousel-item .card {
                height: 280px !important;
            }
            
            .carousel-item .card .ratio {
                flex: 0 0 140px !important;
                height: 140px !important;
            }
            
            .carousel-item .card h5 {
                font-size: 0.85rem !important;
                height: 2.2rem !important;
            }
            
            .carousel-item .card p {
                font-size: 0.7rem !important;
            }
        }

        /* Perbaikan untuk landscape mobile */
        @media (max-width: 992px) and (orientation: landscape) {
            .registration-btn {
                padding: 0.5rem 1rem !important;
                font-size: 0.8rem !important;
            }
            
            .carousel-item .card-hover-zoom:active { 
                transform: scale(1.015) !important;
            }
        }

        /* Touch enhancement untuk semua mobile device */
        @media (hover: none) and (pointer: coarse) {
            /* Artikel cards mendapat efek zoom saat touch */
            .carousel-item .card-hover-zoom:active { 
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

        /* Khusus untuk card yang memiliki stretched-link */
        .stretched-link::after {
            z-index: 1 !important;
        }

        .card .btn {
            z-index: 51 !important;
            position: relative !important;
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
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('js/carousel_gallery.js')); ?>"></script>
    <script>
        // Perbaikan untuk mobile touch events
        document.addEventListener('DOMContentLoaded', function() {
            // Function untuk mengecek apakah device adalah mobile
            function isMobileDevice() {
                return window.innerWidth <= 768 || /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
            }
            
            // Disable zoom pada card registrasi dan event di mobile untuk mencegah layout shift
            if (isMobileDevice()) {
                const registrationCards = document.querySelectorAll('.card.h-100');
                const eventCards = document.querySelectorAll('.event-card');
                
                // Disable zoom untuk card registrasi
                registrationCards.forEach(card => {
                    card.style.transform = 'none';
                    card.style.transition = 'none';
                });
                
                // Disable zoom untuk event cards
                eventCards.forEach(card => {
                    card.style.transform = 'none';
                    card.style.transition = 'none';
                });
                
                // Enable zoom untuk artikel cards dengan touch handling
                const articleCards = document.querySelectorAll('.carousel-item .card-hover-zoom');
                articleCards.forEach(card => {
                    // Touch start event
                    card.addEventListener('touchstart', function(e) {
                        this.style.transform = 'scale(1.02)';
                        this.style.zIndex = '5';
                        this.style.transition = 'transform 0.1s ease';
                    }, { passive: true });
                    
                    // Touch end event
                    card.addEventListener('touchend', function(e) {
                        setTimeout(() => {
                            this.style.transform = 'scale(1)';
                            this.style.zIndex = '1';
                        }, 100);
                    }, { passive: true });
                    
                    // Touch cancel event
                    card.addEventListener('touchcancel', function(e) {
                        this.style.transform = 'scale(1)';
                        this.style.zIndex = '1';
                    }, { passive: true });
                });
            }
            
            // Memastikan tombol registrasi selalu bisa diklik
            const registrationBtns = document.querySelectorAll('.registration-btn');
            registrationBtns.forEach(btn => {
                // Touch events untuk button
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
            
            // Handle untuk semua button lainnya
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
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth <= 768) {
                const registrationCards = document.querySelectorAll('.card.h-100');
                const eventCards = document.querySelectorAll('.event-card');
                
                registrationCards.forEach(card => {
                    card.style.transform = 'none';
                    card.style.transition = 'none';
                });
                
                eventCards.forEach(card => {
                    card.style.transform = 'none';
                    card.style.transition = 'none';
                });
            }
        });
        
        // Carousel gallery script
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
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('../layouts/master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/Kamcup/resources/views/front/index.blade.php ENDPATH**/ ?>