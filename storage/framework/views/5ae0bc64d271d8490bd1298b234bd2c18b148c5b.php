 

<?php $__env->startSection('title', 'Semua Event KAMCUP'); ?>

<?php $__env->startSection('content'); ?>


<section class="gallery-header"> 
    <div class="container">
        <h2 class="display-4 fw-bold mb-3">Jelajahi Semua Event KAMCUP</h2>
        <p class="lead">Dapatkan informasi lengkap tentang berbagai kompetisi dan acara **inspiratif** yang diselenggarakan oleh KAMCUP.
            Jadilah bagian dari semangat **olahraga** dan **pertumbuhan** komunitas kami!</p>
    </div>
</section>

<div class="container py-5 gallery-page"> 
    <div class="filter-sort-container mb-4 d-flex justify-content-end align-items-center gap-3">
        
        <div>
            <label for="category-select" class="form-label mb-0 fw-bold" style="color: var(--secondary-color);">Kategori:</label>
            <select id="category-select" class="form-select w-auto d-inline-block" onchange="window.location.href = this.value;"
                    style="border-color: var(--secondary-color); color: var(--secondary-color); border-radius: 8px; padding: 8px 15px;">
                <option value="<?php echo e(request()->fullUrlWithoutQuery(['category', 'page'])); ?>" <?php echo e($category == 'all' ? 'selected' : ''); ?>>Semua</option> 
                <option value="<?php echo e(request()->fullUrlWithQuery(['category' => 'male', 'page' => 1])); ?>" <?php echo e($category == 'male' ? 'selected' : ''); ?>>Pria</option>
                <option value="<?php echo e(request()->fullUrlWithQuery(['category' => 'female', 'page' => 1])); ?>" <?php echo e($category == 'female' ? 'selected' : ''); ?>>Wanita</option>
                <option value="<?php echo e(request()->fullUrlWithQuery(['category' => 'mixed', 'page' => 1])); ?>" <?php echo e($category == 'mixed' ? 'selected' : ''); ?>>Campuran</option>
            </select>
        </div>

        
        <div>
            <label for="sort-select" class="form-label mb-0 fw-bold" style="color: var(--secondary-color);">Urutkan:</label>
            <select id="sort-select" class="form-select w-auto d-inline-block" onchange="window.location.href = this.value;"
                    style="border-color: var(--secondary-color); color: var(--secondary-color); border-radius: 8px; padding: 8px 15px;">
                <option value="<?php echo e(request()->fullUrlWithoutQuery(['sort', 'page'])); ?>" <?php echo e($sort == 'latest' ? 'selected' : ''); ?>>Terbaru</option> 
                <option value="<?php echo e(request()->fullUrlWithQuery(['sort' => 'oldest', 'page' => 1])); ?>" <?php echo e($sort == 'oldest' ? 'selected' : ''); ?>>Terlama</option>
                <option value="<?php echo e(request()->fullUrlWithQuery(['sort' => 'upcoming', 'page' => 1])); ?>" <?php echo e($sort == 'upcoming' ? 'selected' : ''); ?>>Mendatang</option>
            </select>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4"> 
        <?php $__empty_1 = true; $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col">
            <div class="card gallery-item-card h-100"> 
                <img src="<?php echo e(asset('storage/' . $event->thumbnail)); ?>" class="card-img-top gallery-thumbnail" alt="<?php echo e($event->title); ?>">
                <div class="card-body gallery-content"> 
                    <h5 class="card-title gallery-title"><?php echo e($event->title); ?></h5>
                    <div class="gallery-meta"> 
                        <p class="card-text mb-1"><strong>Lokasi:</strong> <?php echo e($event->location); ?></p>
                        <p class="card-text mb-1"><strong>Kategori:</strong> <?php echo e(ucfirst($event->gender_category)); ?></p>
                        <p class="card-text mb-1"><strong>Tanggal:</strong> <?php echo e(\Carbon\Carbon::parse($event->registration_start)->format('d M Y')); ?>

                            <?php if(\Carbon\Carbon::parse($event->registration_start)->format('Y-m-d') != \Carbon\Carbon::parse($event->registration_end)->format('Y-m-d')): ?>
                                - <?php echo e(\Carbon\Carbon::parse($event->registration_end)->format('d M Y')); ?>

                            <?php endif; ?>
                        </p>
                    </div>
                    
                    <p class="card-text gallery-description"><?php echo e(Str::limit($event->description, 100)); ?></p>
                </div>
                <div class="gallery-footer"> 
                    <?php
                        $statusBgColor = '';
                        $statusTextColor = '';
                        switch ($event->status) {
                            case 'completed':
                                $statusBgColor = 'var(--primary-color)'; // Pink KAMCUP
                                $statusTextColor = 'white';
                                break;
                            case 'ongoing':
                                $statusBgColor = 'var(--secondary-color)'; // Blue-Green KAMCUP
                                $statusTextColor = 'white';
                                break;
                            case 'registration':
                                $statusBgColor = 'var(--accent-color)'; // Yellow KAMCUP
                                $statusTextColor = 'var(--text-dark)'; // Dark text for yellow
                                break;
                            default:
                                $statusBgColor = '#6c757d'; // Default Bootstrap gray
                                $statusTextColor = 'white';
                                break;
                        }
                    ?>
                    <span class="badge" style="background-color: <?php echo e($statusBgColor); ?>; color: <?php echo e($statusTextColor); ?>;"><?php echo e(ucfirst($event->status)); ?></span>
                    <a href="<?php echo e(route('front.events.show', $event->slug)); ?>" class="btn btn-primary-kersa btn-sm">Lihat Detail</a>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-12">
            <p class="text-center text-secondary">Belum ada event untuk ditampilkan saat ini. Segera hadir!</p>
        </div>
        <?php endif; ?>
    </div>

    
    <?php if($events->hasPages()): ?>
        <div class="mt-5 d-flex justify-content-center">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    
                    <?php if($events->onFirstPage()): ?>
                        <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                    <?php else: ?>
                        <li class="page-item"><a class="page-link" href="<?php echo e($events->previousPageUrl()); ?>" rel="prev">&laquo;</a></li>
                    <?php endif; ?>

                    
                    <?php
                        $currentPage = $events->currentPage();
                        $lastPage = $events->lastPage();
                        $pageRange = 5;
                        $startPage = max(1, $currentPage - floor($pageRange / 2));
                        $endPage = min($lastPage, $currentPage + floor($pageRange / 2));

                        if ($currentPage <= floor($pageRange / 2) && $lastPage >= $pageRange) {
                            $endPage = $pageRange;
                        }
                        if ($currentPage > ($lastPage - floor($pageRange / 2)) && $lastPage >= $pageRange) {
                            $startPage = max(1, $lastPage - $pageRange + 1);
                        }
                    ?>

                    <?php for($i = $startPage; $i <= $endPage; $i++): ?>
                        <li class="page-item <?php echo e($i == $currentPage ? 'active' : ''); ?>">
                            <a class="page-link" href="<?php echo e($events->url($i)); ?>"><?php echo e($i); ?></a>
                        </li>
                    <?php endfor; ?>

                    
                    <?php if($events->hasMorePages()): ?>
                        <li class="page-item"><a class="page-link" href="<?php echo e($events->nextPageUrl()); ?>" rel="next">&raquo;</a></li>
                    <?php else: ?>
                        <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* Main Colors (Jika belum didefinisikan di master_nav.blade.php atau file CSS global lainnya) */
    :root {
        --primary-color: #cb2786; /* physique: sportive.inspiration refresh (main color) */
        --secondary-color: #00617a; /* relationship: interactive care expressive competitive */
        --accent-color: #f4b704; /* reflection: sporty youthful */
        --text-dark: #333;
        --text-light: #f8f9fa;

        /* Mapping ke variabel KAMCUP yang mungkin sudah ada di master_nav untuk konsistensi */
        --kamcup-pink: var(--primary-color);
        --kamcup-blue-green: var(--secondary-color);
        --kamcup-yellow: var(--accent-color);
    }

    /* General Styling for a Sporty, Youthful, and Active Vibe */
    body {
        font-family: 'Poppins', sans-serif;
        color: var(--text-dark);
    }

    /* Menggunakan class dari referensi Anda */
    .text-primary-kersa { color: var(--primary-color) !important; }
    .bg-primary-kersa { background-color: var(--primary-color) !important; }
    .border-primary-kersa { border-color: var(--primary-color) !important; }
    .btn-primary-kersa {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
        transition: all 0.3s ease; /* Tambahkan transisi */
    }
    .btn-primary-kersa:hover {
        background-color: #a6206b; /* Darker pink for hover */
        border-color: #a6206b;
    }
    .btn-outline-primary-kersa {
        color: var(--primary-color);
        border-color: var(--primary-color);
        background-color: transparent;
        transition: all 0.3s ease; /* Tambahkan transisi */
    }
    .btn-outline-primary-kersa:hover {
        background-color: var(--primary-color);
        color: white;
    }

    /* Header Section (menggunakan gaya gallery-header) */
    .gallery-header {
        background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
        color: var(--text-light);
        padding: 60px 0;
        margin-top: 5rem; /* Adjust based on navbar height */
        text-align: center;
        border-bottom-left-radius: 50px; /* Youthful, dynamic shape */
        border-bottom-right-radius: 50px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .hero-title { /* Untuk judul di hero section events */
        font-size: 3.5rem;
    }
    .hero-description { /* Untuk deskripsi di hero section events */
        font-size: 1.25rem;
    }

    /* Item Card Styling (menggunakan gaya gallery-item-card) */
    .gallery-item-card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background-color: #ffffff;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        display: flex;
        flex-direction: column;
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

    /* Event status badge (custom for events) */
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

    /* Filter/Sort Dropdown */
    .filter-sort-container .form-select {
        border-color: var(--secondary-color);
        color: var(--secondary-color);
        border-radius: 8px;
        padding: 8px 15px;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2300617a' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e"); /* Custom arrow */
    }

    .filter-sort-container label {
        margin-right: 15px;
        font-weight: 600;
        color: var(--secondary-color);
    }

    /* Pagination Styling from your reference */
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
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // No specific JS needed for filtering since it's handled by native select change
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('../layouts/master_nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/Kamcup/resources/views/front/events/index.blade.php ENDPATH**/ ?>