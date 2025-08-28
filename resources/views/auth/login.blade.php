<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - KAMCUP</title> {{-- Ubah title menjadi KAMCUP --}}
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* KAMCUP Brand Colors */
        :root {
            --kamcup-pink: #cb2786; /* Primary color */
            --kamcup-blue-green: #00617a; /* Secondary color */
            --kamcup-yellow: #f4b704; /* Accent color */
            --kamcup-dark-text: #212529; /* Dark text for contrast */
            --kamcup-light-text: #ffffff; /* Light text */
            --kamcup-light-bg: #f5f7fa; /* Light background variant */
            --kamcup-gradient-start: #f5f7fa; /* Start of body gradient */
            --kamcup-gradient-end: #e6f7f1; /* End of body gradient */
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--kamcup-gradient-start) 0%, var(--kamcup-gradient-end) 100%); /* Refreshing gradient */
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--kamcup-dark-text); /* Default body text color */
        }

        .card {
            border-radius: 20px; /* Youthful rounded corners */
            border: 1px solid rgba(255, 255, 255, 0.3); /* Softer border */
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1); /* Deeper shadow for impact */
            backdrop-filter: blur(8px); /* Slightly less blur, more subtle */
            background-color: rgba(255, 255, 255, 0.95); /* More opaque white */
            overflow: hidden; /* Ensures contents stay within rounded corners */
        }

        .card-body {
            padding: 3rem; /* More generous padding */
        }

        .logo-container {
            width: 90px; /* Slightly larger */
            height: 90px;
            background-color: rgba(var(--kamcup-yellow-rgb), 0.15); /* Light yellow background */
            border-radius: 50%; /* Make it circular, more dynamic */
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            box-shadow: 0 8px 16px rgba(var(--kamcup-yellow-rgb), 0.3); /* Yellow shadow */
            transition: transform 0.3s ease; /* Smooth hover effect */
        }

        .logo-container:hover {
            transform: scale(1.05); /* Interactive effect */
        }

        .logo-icon {
            font-size: 3rem; /* Larger icon */
            color: var(--kamcup-yellow); /* KAMCUP Yellow */
        }

        h1.h3 {
            color: var(--kamcup-blue-green); /* Use blue-green for main heading */
            font-weight: 700 !important; /* Stronger font weight */
            font-size: 2.25rem; /* Larger heading */
        }

        .text-muted {
            color: #6c757d !important; /* Standard Bootstrap muted text */
        }

        .form-control {
            border-radius: 12px;
            padding: 0.85rem 1.25rem; /* Slightly more padding */
            border: 1px solid rgba(var(--kamcup-blue-green-rgb), 0.3); /* Blue-green tint border */
            background-color: var(--kamcup-light-bg); /* Light background for inputs */
            transition: all 0.3s ease;
        }
        /* Mengatur variabel RGB untuk warna KAMCUP */
        .form-control:focus {
            --kamcup-pink-rgb: 203, 39, 134;
            --kamcup-blue-green-rgb: 0, 97, 122;
            --kamcup-yellow-rgb: 244, 183, 4;

            border-color: var(--kamcup-pink); /* Pink border on focus */
            box-shadow: 0 0 0 0.25rem rgba(var(--kamcup-pink-rgb), 0.15); /* Pink shadow on focus */
            background-color: var(--kamcup-light-text); /* White background on focus */
        }


        .input-group-text {
            background-color: transparent;
            border: 1px solid rgba(var(--kamcup-blue-green-rgb), 0.3); /* Match input border */
            border-right: none;
            border-radius: 12px 0 0 12px; /* Match input border-radius */
            color: var(--kamcup-blue-green); /* Icon color */
        }

        .form-control.border-start-0 {
            border-left: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--kamcup-pink) 0%, #a6206b 100%); /* Pink gradient */
            border: none;
            border-radius: 12px;
            padding: 0.85rem 1.5rem;
            font-weight: 600;
            box-shadow: 0 6px 16px rgba(var(--kamcup-pink-rgb), 0.3); /* Pink shadow */
            transition: all 0.3s ease;
            text-transform: uppercase; /* Expressive */
            letter-spacing: 0.05em; /* Sporty */
        }

        .btn-primary:hover {
            transform: translateY(-3px); /* More pronounced lift */
            box-shadow: 0 8px 20px rgba(var(--kamcup-pink-rgb), 0.4);
            background: linear-gradient(135deg, #a6206b 0%, var(--kamcup-pink) 100%); /* Reverse gradient on hover */
        }

        .alert {
            border-radius: 12px;
            border: none;
            font-weight: 500;
        }

        .alert-success {
            background-color: rgba(var(--kamcup-blue-green-rgb), 0.1); /* Light blue-green */
            color: var(--kamcup-blue-green);
        }

        .alert-danger {
            background-color: rgba(var(--kamcup-pink-rgb), 0.1); /* Light pink */
            color: var(--kamcup-pink);
        }

        .text-primary {
            color: var(--kamcup-blue-green) !important; /* Blue-green for links */
        }

        .text-primary:hover {
            color: var(--kamcup-pink) !important; /* Pink on link hover */
        }

        .social-login {
            background: rgba(var(--kamcup-yellow-rgb), 0.1); /* Light yellow background */
            border-radius: 12px;
            padding: 1rem;
            transition: all 0.3s ease;
            font-weight: 600;
            color: var(--kamcup-dark-text);
        }

        .social-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(var(--kamcup-yellow-rgb), 0.2);
            background: rgba(var(--kamcup-yellow-rgb), 0.2); /* Slightly darker yellow on hover */
        }

        .social-icon {
            width: 24px;
            height: 24px;
            margin-right: 0.75rem; /* More space */
        }

        /* Button Kembali Style */
        .btn-back {
            background-color: var(--kamcup-blue-green); /* Blue-green background */
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(var(--kamcup-blue-green-rgb), 0.2);
            transition: all 0.3s ease;
            color: var(--kamcup-light-text);
        }

        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(var(--kamcup-blue-green-rgb), 0.3);
            background-color: #004b5c; /* Darker blue-green */
        }

        .btn-back i {
            font-size: 1.2rem;
            color: var(--kamcup-light-text);
        }

        /* SCROLL ANIMATION STYLES */
        /* Definisikan variabel RGB untuk animasi */
        :root {
            --kamcup-pink-rgb: 203, 39, 134;
            --kamcup-blue-green-rgb: 0, 97, 122;
            --kamcup-yellow-rgb: 244, 183, 4;
        }

        /* Keyframes untuk berbagai animasi */
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

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: scale(0.3);
            }
            50% {
                opacity: 1;
                transform: scale(1.05);
            }
            70% {
                transform: scale(0.9);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes slideInFromBottom {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Classes untuk animasi scroll */
        .fade-in-up {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.25, 0.25, 0.25, 1);
        }

        .fade-in-down {
            opacity: 0;
            transform: translateY(-30px);
            transition: all 0.8s cubic-bezier(0.25, 0.25, 0.25, 1);
        }

        .fade-in-left {
            opacity: 0;
            transform: translateX(-30px);
            transition: all 0.8s cubic-bezier(0.25, 0.25, 0.25, 1);
        }

        .fade-in-right {
            opacity: 0;
            transform: translateX(30px);
            transition: all 0.8s cubic-bezier(0.25, 0.25, 0.25, 1);
        }

        .scale-in {
            opacity: 0;
            transform: scale(0.8);
            transition: all 0.8s cubic-bezier(0.25, 0.25, 0.25, 1);
        }

        .bounce-in {
            opacity: 0;
            transform: scale(0.3);
            transition: all 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        /* Classes untuk elemen yang sudah teranimasi */
        .fade-in-up.animate {
            opacity: 1;
            transform: translateY(0);
        }

        .fade-in-down.animate {
            opacity: 1;
            transform: translateY(0);
        }

        .fade-in-left.animate {
            opacity: 1;
            transform: translateX(0);
        }

        .fade-in-right.animate {
            opacity: 1;
            transform: translateX(0);
        }

        .scale-in.animate {
            opacity: 1;
            transform: scale(1);
        }

        .bounce-in.animate {
            opacity: 1;
            transform: scale(1);
        }

        /* Animasi khusus untuk logo */
        .logo-container.animate {
            animation: bounceIn 1s ease-out;
        }

        /* Animasi untuk form fields */
        .form-field.animate {
            animation: fadeInUp 0.8s ease-out;
        }

        /* Animasi untuk buttons */
        .btn-animate.animate {
            animation: slideInFromBottom 0.8s ease-out;
        }

        /* Animasi untuk alerts */
        .alert.animate {
            animation: fadeInDown 0.6s ease-out;
        }

        /* Pulse effect untuk interaktivitas */
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(var(--kamcup-pink-rgb), 0.7);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(var(--kamcup-pink-rgb), 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(var(--kamcup-pink-rgb), 0);
            }
        }

        .pulse-on-load {
            animation: pulse 2s infinite;
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .card-body {
                padding: 1.5rem;
            }

            .logo-container {
                width: 70px; /* Smaller on mobile */
                height: 70px;
            }

            .logo-icon {
                font-size: 2.25rem;
            }

            h1.h3 {
                font-size: 1.8rem;
            }

            .form-control {
                padding: 0.65rem 1rem;
            }

            .btn-primary, .btn-back {
                padding: 0.65rem 1rem;
                font-size: 0.95rem;
            }

            /* Reduced animation distance on mobile */
            .fade-in-up, .fade-in-down {
                transform: translateY(20px);
            }
            
            .fade-in-left, .fade-in-right {
                transform: translateY(20px);
            }
            
            .fade-in-left.animate, .fade-in-right.animate {
                transform: translateY(0);
            }
        }


    </style>
</head>
<body class="d-flex align-items-center justify-content-center py-4 py-sm-5">


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-8 col-md-7 col-lg-5 col-xl-4">
                <div class="card scale-in">
                    <div class="card-body">
                        <div class="text-center mb-4 fade-in-down" data-delay="200">
                            <div class="logo-container bounce-in" data-delay="100">
                                {{-- Mengganti ikon buku dengan ikon yang lebih sporty, misal bola voli atau piala --}}
                                <i class="fas fa-volleyball-ball logo-icon"></i> {{-- Atau fa-trophy, fa-medal, fa-futbol --}}
                            </div>
                            <h1 class="h3 fw-bold mb-1">Selamat Datang di KAMCUP!</h1> {{-- Sesuaikan teks sambutan --}}
                            <p class="text-muted mb-0">Masuk ke akun Anda dan **wujudkan semangat kompetisi**!</p> {{-- Refleksi brand --}}
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success d-flex align-items-center mb-3 fade-in-down" data-delay="300">
                                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger d-flex align-items-center mb-3 fade-in-down" data-delay="300">
                                <i class="fas fa-exclamation-circle me-2"></i> {{ $errors->first() }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3 fade-in-left" data-delay="400">
                                <label for="email" class="form-label fw-medium">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" name="email" id="email" required
                                           class="form-control border-start-0"
                                           placeholder="nama@email.com">
                                </div>
                            </div>

                            <div class="mb-2 fade-in-right" data-delay="500">
                                <label for="password" class="form-label fw-medium">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" name="password" id="password" required
                                           class="form-control border-start-0"
                                           placeholder="Masukkan password Anda">
                                </div>
                            </div>

                            <div class="mb-4 text-end fade-in-right" data-delay="600">
                                <a href="{{ route('password.request') }}" class="text-decoration-none small fw-medium">
                                    Lupa Password?
                                </a>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mb-4 btn-animate" data-delay="700">
                                <i class="fas fa-sign-in-alt me-2"></i> Masuk Akun
                            </button>

                            <div class="text-center text-muted mb-4 fade-in-up" data-delay="800">
                                Belum punya akun?
                                <a href="{{ route('register') }}" class="text-decoration-none fw-medium">Daftar di sini</a>
                            </div>

                            <div class="text-center fade-in-up" data-delay="900">
                                <p class="text-muted mb-3">Atau masuk dengan</p>
                                <div class="social-login">
                                    <a href="{{ route('auth.google') }}" class="d-flex align-items-center justify-content-center text-decoration-none">
                                        <svg class="social-icon" viewBox="0 0 24 24">
                                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                                        </svg>
                                        <span class="ms-2">Google</span>
                                    </a>
                                </div>
                            </div>
                        </form>
                        <div class="text-center mt-3 fade-in-up" data-delay="1000">
                            <a href="{{ route('front.index') }}" class="btn btn-back w-100 btn-animate">
                                <i class="fas fa-arrow-left me-2"></i> Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // Scroll Animation Functionality
            const animateElements = document.querySelectorAll('.fade-in-up, .fade-in-down, .fade-in-left, .fade-in-right, .scale-in, .bounce-in, .btn-animate');
            
            // Intersection Observer for scroll detection
            const observerOptions = {
                threshold: 0.1, // Trigger when 10% of element is visible
                rootMargin: '0px 0px -50px 0px' // Trigger slightly before element is fully visible
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const element = entry.target;
                        const delay = element.dataset.delay || 0;
                        
                        // Add delay based on data-delay attribute
                        setTimeout(() => {
                            element.classList.add('animate');
                        }, delay);
                        
                        // Stop observing after animation is triggered
                        observer.unobserve(element);
                    }
                });
            }, observerOptions);

            // Observe all animation elements
            animateElements.forEach(element => {
                observer.observe(element);
            });

            // Fallback for browsers that don't support Intersection Observer
            if (!window.IntersectionObserver) {
                animateElements.forEach(element => {
                    element.classList.add('animate');
                });
            }

            // Special handling for elements that should animate immediately on page load
            const immediateElements = document.querySelectorAll('.scale-in');
            setTimeout(() => {
                immediateElements.forEach(element => {
                    element.classList.add('animate');
                });
            }, 600);

            // Add pulse effect to login button after all animations
            const loginButton = document.querySelector('.btn-primary');
            if (loginButton) {
                setTimeout(() => {
                    loginButton.classList.add('pulse-on-load');
                    // Remove pulse after 6 seconds
                    setTimeout(() => {
                        loginButton.classList.remove('pulse-on-load');
                    }, 6000);
                }, 2000);
            }

            // Enhanced form interaction animations
            const formInputs = document.querySelectorAll('.form-control');
            formInputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.closest('.input-group').style.transform = 'scale(1.02)';
                    this.closest('.input-group').style.transition = 'all 0.3s ease';
                });
                
                input.addEventListener('blur', function() {
                    this.closest('.input-group').style.transform = 'scale(1)';
                });
            });

            // Add stagger effect to form elements
            const formElements = document.querySelectorAll('.fade-in-left, .fade-in-right');
            formElements.forEach((element, index) => {
                const originalDelay = parseInt(element.dataset.delay) || 0;
                element.dataset.delay = originalDelay + (index * 100);
            });

            // Smooth scrolling enhancement
            document.documentElement.style.scrollBehavior = 'smooth';

            // Add dynamic background gradient animation (removed)
            // Removed rotating gradient background
        });

        // Additional scroll-triggered animations for better UX
        window.addEventListener('scroll', function() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            const cards = document.querySelectorAll('.card');
            
            cards.forEach(card => {
                const cardTop = card.offsetTop;
                const cardHeight = card.offsetHeight;
                const windowHeight = window.innerHeight;
                
                if (scrollTop + windowHeight > cardTop + cardHeight / 4) {
                    card.style.transform = 'translateY(0) scale(1)';
                    card.style.opacity = '1';
                }
            });
        });
    </script>
</body>
</html>