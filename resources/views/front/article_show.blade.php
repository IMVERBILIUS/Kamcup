@extends('layouts.master')

@section('head')
{{-- Meta tags untuk Google Translate --}}
<meta name="google-translate-customization" content="translate-content">
<script>
// AGGRESSIVE APPROACH: Force reload dengan Google Translate aktif
(function() {
    console.log('=== ARTICLE TRANSLATE INIT ===');
    console.log('Current URL:', window.location.href);
    console.log('Current hash:', window.location.hash);
    console.log('Cookie:', document.cookie);
    
    // Function untuk mendapatkan bahasa aktif
    function getActiveLanguage() {
        // Dari cookie
        var googTransCookie = document.cookie.split(';')
            .find(row => row.trim().startsWith('googtrans='));
        
        if (googTransCookie && googTransCookie.includes('/en')) {
            return 'en';
        }
        
        // Dari localStorage sebagai backup
        var storedLang = localStorage.getItem('preferredLanguage');
        if (storedLang === 'en') {
            return 'en';
        }
        
        return 'id';
    }
    
    var targetLang = getActiveLanguage();
    console.log('Target language:', targetLang);
    
    if (targetLang === 'en') {
        var expectedHash = '#googtrans(id|en)';
        var hasCorrectHash = window.location.hash === expectedHash;
        var hasGoogTransParam = window.location.search.includes('googtrans');
        
        console.log('Has correct hash:', hasCorrectHash);
        console.log('Has googtrans param:', hasGoogTransParam);
        
        if (!hasCorrectHash && !hasGoogTransParam) {
            console.log('REDIRECTING: Adding googtrans hash and reloading...');
            
            // Set cookie untuk memastikan Google Translate aktif
            document.cookie = 'googtrans=/id/en; path=/; max-age=86400';
            
            // Store di localStorage
            localStorage.setItem('preferredLanguage', 'en');
            localStorage.setItem('forceTranslate', 'true');
            
            // Redirect dengan hash
            window.location.href = window.location.pathname + expectedHash;
            return; // Stop execution
        }
        
        // Jika hash sudah ada tapi masih belum translate, paksa reload
        if (hasCorrectHash) {
            var forceTranslate = localStorage.getItem('forceTranslate');
            if (forceTranslate === 'true') {
                localStorage.removeItem('forceTranslate'); // Prevent infinite loop
                console.log('FORCE RELOAD: Hash exists but forcing reload to ensure translate works');
                setTimeout(function() {
                    window.location.reload();
                }, 100);
                return;
            }
        }
    }
    
    console.log('=== INIT COMPLETE ===');
})();
</script>
@endsection

@section('content')

<div class="container px-4 px-lg-5">
    <div class="row justify-content-center">
        <div class="col-lg-12">

            <div class="d-flex justify-content-between mb-4 mt-4">
            <a href="{{ route('front.articles') }}" class="btn px-4 py-2"
            style="background-color: #F0F5FF; color: #5B93FF; border-radius: 8px;">
            <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>

            <div class="mb-4 scroll-animate" data-delay="0">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span class="badge rounded-pill px-3 py-2"
                          style="background-color: {{ $article->status == 'Published' ? '#E6F7F1' : '#f5f5f5' }};
                                color: {{ $article->status == 'Published' ? '#36b37e' : '#6c757d' }};">
                        {{ $article->status }}
                    </span>
                    <div class="text-muted small">
                        <i class="far fa-calendar-alt me-1"></i> {{ $article->created_at->format('d M Y') }}
                    </div>
                </div>

                <h1 class="fw-bold mb-3 article-text">{{ $article->title }}</h1>

                <div class="d-flex align-items-center mb-4">
                    <div class="d-flex justify-content-center align-items-center rounded-circle me-3"
                         style="width: 40px; height: 40px; background-color: #F0F5FF;">
                        <i class="fas fa-user" style="color: #5B93FF;"></i>
                    </div>
                    <div>
                        <p class="mb-0 fw-medium">{{ $article->author }}</p>
                        <p class="text-muted small mb-0">Author</p>
                    </div>
                </div>

                @if($article->thumbnail)
                    <div class="text-center my-4">
                        <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="Thumbnail"
                             class="img-fluid mx-auto d-block"
                             style="max-width: 100%; height: auto; border-radius: 16px;">
                    </div>
                @endif
            </div>

            <div class="mb-4">
                <div class="article-description mb-4 scroll-animate" data-delay="200">
                    <div class="p-3 rounded-3" style="background-color: #F8FAFD;">
                        <p class="lead mb-0" style="color: #5F738C;">{{ $article->description }}</p>
                    </div>
                </div>

                @if($article->subheadings->count())
                    <div class="article-content">
                        @foreach($article->subheadings as $index => $subheading)
                            <div class="subheading-section mb-4 scroll-animate" data-delay="{{ 300 + ($index * 100) }}">
                                <h3 class="fw-bold mb-3 article-text" style="color: #3A4A5C; padding-bottom: 10px; border-bottom: 2px solid #F0F5FF;">
                                    {{ $subheading->title }}
                                </h3>
                                @foreach($subheading->paragraphs as $pIndex => $paragraph)
                                    <div class="paragraph mb-4 scroll-animate" data-delay="{{ 400 + ($index * 100) + ($pIndex * 50) }}">
                                        <p style="line-height: 1.8; color: #5F738C;">{{ $paragraph->content }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="card border-0 rounded-4 shadow-sm scroll-animate last-content-section" data-delay="600">
                <div class="card-body p-4">
                    <h3 class="fw-bold fs-5 mb-4 article-text">Komentar ({{ $article->comments->count() }})</h3>

                    @auth
                        <form action="{{ route('comments.store', $article->id) }}" method="POST" class="mb-4">
                            @csrf
                            <div class="form-group">
                                <textarea name="content" rows="3" class="form-control @error('content') is-invalid @enderror"
                                    placeholder="Tulis komentar Anda..."></textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">
                                <i class="fas fa-paper-plane me-2"></i>Kirim Komentar
                            </button>
                        </form>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2 article-text"></i>
                            Silakan <a href="{{ route('login') }}">login</a> untuk memberikan komentar.
                        </div>
                    @endauth

                    <div class="comments-list">
                        @forelse($article->comments()->with('user')->latest()->get() as $index => $comment)
                            <div class="comment-item border-bottom py-3 scroll-animate" data-delay="{{ 700 + ($index * 100) }}">
                                <div class="d-flex align-items-start">
                                    <div class="d-flex justify-content-center align-items-center rounded-circle me-3"
                                         style="width: 40px; height: 40px; background-color: #F0F5FF;">
                                        <i class="fas fa-user" style="color: #5B93FF;"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <h6 class="mb-0 fw-medium">{{ $comment->user->name }}</h6>
                                            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                        </div>
                                        <p class="mb-2" style="color: #5F738C;">{{ $comment->content }}</p>

                                        @auth
                                            @if(auth()->id() === $comment->user_id)
                                                <div class="comment-actions">
                                                    <button class="btn btn-sm btn-link text-primary edit-comment"
                                                            data-comment-id="{{ $comment->id }}"
                                                            data-content="{{ $comment->content }}">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>
                                                    <form action="{{ route('comments.destroy', $comment->id) }}"
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-link text-danger"
                                                                onclick="return confirm('Apakah Anda yakin ingin menghapus komentar ini?')">
                                                            <i class="fas fa-trash"></i> Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4 scroll-animate" data-delay="700">
                                <p class="text-muted mb-0 article-text">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .article-content h3 {
        font-size: 1.5rem;
    }

    .article-content p {
        font-size: 1.05rem;
    }

    .lead {
        font-size: 1.15rem;
        font-weight: 400;
    }
    
    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(108, 99, 255, 0.3);
    }
    
    .comment-item:last-child {
        border-bottom: none !important;
    }

    .comment-actions {
        font-size: 0.875rem;
    }

    .comment-actions .btn-link {
        padding: 0.25rem 0.5rem;
        text-decoration: none;
    }

    .comment-actions .btn-link:hover {
        text-decoration: underline;
    }

    /* Scroll Animation Styles */
    .scroll-animate {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .scroll-animate.animate {
        opacity: 1;
        transform: translateY(0);
    }

    /* Stagger animation delays */
    .scroll-animate[data-delay="0"] { transition-delay: 0ms; }
    .scroll-animate[data-delay="100"] { transition-delay: 100ms; }
    .scroll-animate[data-delay="200"] { transition-delay: 200ms; }
    .scroll-animate[data-delay="300"] { transition-delay: 300ms; }
    .scroll-animate[data-delay="400"] { transition-delay: 400ms; }
    .scroll-animate[data-delay="500"] { transition-delay: 500ms; }
    .scroll-animate[data-delay="600"] { transition-delay: 600ms; }
    .scroll-animate[data-delay="700"] { transition-delay: 700ms; }
    .scroll-animate[data-delay="800"] { transition-delay: 800ms; }
    .scroll-animate[data-delay="900"] { transition-delay: 900ms; }
    .scroll-animate[data-delay="1000"] { transition-delay: 1000ms; }


    /* ========================================================== */
    /* ===== SOLUSI FINAL: Beri jarak ideal ke footer ===== */
    /* ========================================================== */
    .last-content-section {
        margin-bottom: 4rem; /* 4rem sekitar 1.5 cm. Ubah jika perlu */
    }


    @media (max-width: 768px) {
        .article-content h3 {
            font-size: 1.3rem;
        }

        img.img-fluid {
            max-width: 100% !important;
        }
        
        .scroll-animate {
            transform: translateY(20px);
        }
    }
</style>

@push('scripts')
<script>
    // Edit comment functionality
    document.querySelectorAll('.edit-comment').forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.dataset.commentId;
            const content = this.dataset.content;

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/comments/${commentId}`;
            form.innerHTML = `
                @csrf
                @method('PUT')
                <div class="form-group">
                    <textarea name="content" rows="3" class="form-control">${content}</textarea>
                </div>
                <div class="mt-2">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    <button type="button" class="btn btn-secondary btn-sm cancel-edit">Batal</button>
                </div>
            `;

            const commentContent = this.closest('.comment-item').querySelector('p');
            commentContent.replaceWith(form);

            form.querySelector('.cancel-edit').addEventListener('click', () => {
                form.replaceWith(commentContent);
            });
        });
    });

    // === SCROLL ANIMATION SYSTEM ===
    
    // Function untuk menginisialisasi scroll animation
    function initScrollAnimation() {
        const observerOptions = {
            root: null,
            rootMargin: '0px 0px -10% 0px', // Trigger animasi saat elemen 90% terlihat
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Tambahkan class animate dengan delay
                    const delay = entry.target.dataset.delay || 0;
                    setTimeout(() => {
                        entry.target.classList.add('animate');
                    }, parseInt(delay));
                    
                    // Stop observing setelah animasi dijalankan
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);
        
        // Observe semua elemen dengan scroll-animate
        const animateElements = document.querySelectorAll('.scroll-animate');
        animateElements.forEach(element => {
            // Reset state sebelum mengamati
            element.classList.remove('animate');
            observer.observe(element);
        });
    }

    // === ENHANCED GOOGLE TRANSLATE FORCE SYSTEM ===
    
    // Wait for Google Translate to load and force it to work
    function waitForGoogleTranslateAndForce() {
        console.log('Waiting for Google Translate to load...');
        
        var attempts = 0;
        var maxAttempts = 20;
        
        var interval = setInterval(function() {
            attempts++;
            console.log('Attempt', attempts, '- Checking Google Translate...');
            
            // Check if Google Translate is available
            if (typeof google !== 'undefined' && 
                google.translate && 
                google.translate.TranslateElement) {
                
                console.log('Google Translate found! Forcing translation...');
                clearInterval(interval);
                
                // Force set the language
                setTimeout(function() {
                    forceActivateTranslate();
                }, 1000);
                
                return;
            }
            
            if (attempts >= maxAttempts) {
                console.warn('Google Translate not loaded after', maxAttempts, 'attempts');
                clearInterval(interval);
                
                // Last resort: reload page with googtrans parameter
                if (window.location.hash.includes('googtrans')) {
                    console.log('Last resort: reloading with googtrans parameter...');
                    var newUrl = window.location.pathname + '?googtrans=id%7Cen' + window.location.hash;
                    window.location.href = newUrl;
                }
            }
        }, 500);
    }
    
    // Force activate translate
    function forceActivateTranslate() {
        try {
            console.log('Forcing translate activation...');
            
            // Method 1: Try to find and trigger the dropdown
            var selectElement = document.querySelector('.goog-te-combo');
            if (selectElement) {
                console.log('Found translate dropdown, setting to English...');
                selectElement.value = 'en';
                
                // Trigger change event
                var changeEvent = new Event('change', { bubbles: true });
                selectElement.dispatchEvent(changeEvent);
                
                setTimeout(function() {
                    if (selectElement.value === 'en') {
                        console.log('Dropdown set to English successfully');
                    } else {
                        console.log('Dropdown not set properly, trying alternative...');
                        alternativeTranslateMethod();
                    }
                }, 1000);
            } else {
                console.log('Dropdown not found, trying alternative method...');
                alternativeTranslateMethod();
            }
            
        } catch (error) {
            console.error('Error in forceActivateTranslate:', error);
            alternativeTranslateMethod();
        }
    }
    
    // Alternative translate method
    function alternativeTranslateMethod() {
        console.log('Using alternative translate method...');
        
        try {
            // Method 2: Direct cookie manipulation and reload
            document.cookie = 'googtrans=/id/en; path=/; max-age=86400; domain=' + window.location.hostname;
            
            // Check if we need to reload
            var currentText = document.body.innerText;
            var hasIndonesianWords = /\b(dan|atau|yang|untuk|dengan|dari|adalah|akan|telah|pada|dalam)\b/i.test(currentText);
            
            if (hasIndonesianWords && window.location.hash.includes('googtrans')) {
                console.log('Still has Indonesian words, forcing reload...');
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
            }
            
        } catch (error) {
            console.error('Error in alternativeTranslateMethod:', error);
        }
    }
    
    // Check if translate is working
    function checkTranslateStatus() {
        setTimeout(function() {
            console.log('Checking translate status...');
            
            var currentText = document.body.innerText;
            var hasIndonesianWords = /\b(dan|atau|yang|untuk|dengan|dari|adalah|akan|telah|pada|dalam)\b/i.test(currentText);
            
            console.log('Has Indonesian words:', hasIndonesianWords);
            
            if (hasIndonesianWords && localStorage.getItem('preferredLanguage') === 'en') {
                console.log('Translation not working properly, trying alternative...');
                
                // Try reload with different approach
                var currentUrl = window.location.href;
                if (!currentUrl.includes('googtrans=')) {
                    var separator = currentUrl.includes('?') ? '&' : '?';
                    window.location.href = currentUrl + separator + 'googtrans=id%7Cen';
                } else {
                    window.location.reload();
                }
            } else {
                console.log('Translation appears to be working or not needed');
            }
        }, 5000);
    }

    // Main execution
    document.addEventListener('DOMContentLoaded', function() {
        console.log('=== ARTICLE TRANSLATE SCRIPT LOADED ===');
        console.log('Current language preference:', localStorage.getItem('preferredLanguage'));
        console.log('Current URL:', window.location.href);
        
        // Initialize scroll animations
        initScrollAnimation();
        
        // Only proceed if we should be in English mode
        if (localStorage.getItem('preferredLanguage') === 'en' || 
            document.cookie.includes('googtrans=/id/en') ||
            window.location.hash.includes('googtrans(id|en)')) {
            
            console.log('English mode detected, initializing translate...');
            
            // Wait for and force Google Translate
            waitForGoogleTranslateAndForce();
            
            // Check if it's working after some time
            checkTranslateStatus();
        } else {
            console.log('No translation needed');
        }
    });

    // Handle page visibility change (when user comes back to tab)
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden && localStorage.getItem('preferredLanguage') === 'en') {
            console.log('Page became visible, checking translate status...');
            setTimeout(checkTranslateStatus, 2000);
        }
    });

    // Export functions for debugging
    window.forceActivateTranslate = forceActivateTranslate;
    window.waitForGoogleTranslateAndForce = waitForGoogleTranslateAndForce;
    window.checkTranslateStatus = checkTranslateStatus;
    
    // Enhanced debug function
    window.debugTranslate = function() {
        console.log('=== COMPREHENSIVE TRANSLATE DEBUG ===');
        console.log('Current URL:', window.location.href);
        console.log('Current Hash:', window.location.hash);
        console.log('Cookie:', document.cookie);
        console.log('LocalStorage preferredLanguage:', localStorage.getItem('preferredLanguage'));
        console.log('Google Translate Available:', typeof google !== 'undefined' && google.translate);
        console.log('Translate Dropdown:', document.querySelector('.goog-te-combo'));
        console.log('Dropdown Value:', document.querySelector('.goog-te-combo')?.value);
        
        var currentText = document.body.innerText.substring(0, 200);
        console.log('Current text sample:', currentText);
        
        var hasIndonesianWords = /\b(dan|atau|yang|untuk|dengan|dari|adalah|akan|telah|pada|dalam)\b/i.test(currentText);
        console.log('Has Indonesian words:', hasIndonesianWords);
        console.log('=====================================');
    };
    
    // Manual force function for testing
    window.manualForceTranslate = function() {
        localStorage.setItem('preferredLanguage', 'en');
        document.cookie = 'googtrans=/id/en; path=/; max-age=86400';
        window.location.href = window.location.pathname + '#googtrans(id|en)';
    };
    
    // Debug scroll animation
    window.resetScrollAnimation = function() {
        const elements = document.querySelectorAll('.scroll-animate');
        elements.forEach(el => el.classList.remove('animate'));
        initScrollAnimation();
    };
</script>

@push('translation-script')
    @include('partials.floating-translate')
@endpush

@endsection