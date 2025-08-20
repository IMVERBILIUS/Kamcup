<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?php echo $__env->yieldContent('title', 'KAMCUP'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo e(asset('favicon.ico')); ?>" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
    
    
    <style>
        /* Secara default, link navbar akan berwarna gelap (sesuai navbar di halaman lain) */
        .navbar-dark .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.75); /* Warna default Bootstrap untuk .navbar-dark */
        }
        .navbar-dark .navbar-nav .nav-link:hover {
            color: white;
        }

        /* KHUSUS untuk halaman dengan class 'home-page', paksa link navbar jadi putih */
        .home-page .navbar.navbar-transparent .nav-link {
            color: white !important; /* !important untuk memastikan aturan ini menang */
        }
        .home-page .navbar.navbar-transparent .nav-link:hover {
            color: #dddddd !important;
        }
    </style>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="<?php echo $__env->yieldContent('body-class'); ?>">

    <div class="main-wrapper d-flex flex-column min-vh-100">
        
        
        
        
        
        
        
        <main class="content flex-grow-1">
            <?php echo $__env->yieldContent('content'); ?>
        </main>

        
        <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>

    <?php echo $__env->yieldPushContent('translation-script'); ?>
</body>
</html>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/Kamcup/resources/views/layouts/master.blade.php ENDPATH**/ ?>