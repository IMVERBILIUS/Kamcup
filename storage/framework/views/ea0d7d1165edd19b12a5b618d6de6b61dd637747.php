<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $__env->yieldContent('title', 'KAMCUP'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo e(asset('favicon.ico')); ?>" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?php echo e(asset('css/navbar.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body style="font-family: 'Poppins', sans-serif">




<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #0F62FF;"> 
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="<?php echo e(route('front.index')); ?>"
            style="width: 150px; height: 70px;">
            <img src="<?php echo e(asset('assets/img/logo4.png')); ?>" alt="KAMCUP Logo" class="me-2 brand-logo"
                style="height: 100%; width: 100%; object-fit: cover;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
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





<div class="main-wrapper d-flex flex-column min-vh-100">
    <div class="container alert-fixed">
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    </div>

    
    <div class="content flex-grow-1">
        <?php echo $__env->yieldContent('content'); ?>
    </div>

    
    <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/Kamcup/resources/views////layouts/master_nav.blade.php ENDPATH**/ ?>