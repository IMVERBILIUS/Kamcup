
<li class="nav-item">
    <div class="google-translate-container">
        <div id="google_translate_element_desktop"></div>
    </div>
</li>


<li class="nav-item mobile-language-link d-lg-none">
    <a class="nav-link disabled" href="#">
        <i class="bi bi-globe2"></i><span><?php echo e(__('navbar.language')); ?></span>
    </a>
    <div id="google_translate_element_mobile"></div>
</li>

<style>
/* Container untuk Google Translate */
.google-translate-container {
    margin-left: 10px;
}

/* Styling untuk Google Translate Widget */
#google_translate_element_desktop,
#google_translate_element_mobile {
    display: inline-block;
}

/* Styling untuk dropdown Google Translate */
.goog-te-gadget {
    font-family: inherit !important;
    font-size: 14px !important;
    color: #333 !important;
}

.goog-te-gadget .goog-te-combo {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    color: white !important;
    border: none !important;
    border-radius: 25px !important;
    padding: 8px 15px !important;
    font-size: 14px !important;
    font-weight: 500 !important;
    cursor: pointer !important;
    outline: none !important;
    min-width: 120px !important;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3) !important;
    transition: all 0.3s ease !important;
    -webkit-appearance: none !important;
    -moz-appearance: none !important;
    appearance: none !important;
}

.goog-te-gadget .goog-te-combo:hover {
    background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%) !important;
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4) !important;
    transform: translateY(-1px) !important;
}

.goog-te-gadget .goog-te-combo:focus {
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.3) !important;
}

.goog-te-gadget .goog-te-combo option {
    background: white !important;
    color: #333 !important;
    padding: 8px !important;
}

/* Hide Google Translate branding text */
.goog-te-gadget-simple .goog-te-menu-value span:first-child {
    display: none;
}

.goog-te-gadget-simple .goog-te-menu-value:before {
    content: '🌐 ';
    margin-right: 5px;
}

/* Style untuk banner translate */
.goog-te-banner-frame {
    display: none !important;
}

/* Jangan ubah posisi body saat translate */
body {
    top: 0 !important;
    position: static !important;
}

/* Hide iframe notifikasi */
.skiptranslate > iframe {
    display: none !important;
}

/* Mobile language link styling */
.mobile-language-link .nav-link {
    padding: 0.5rem 1rem !important;
}

.mobile-language-link #google_translate_element_mobile {
    margin-top: 0.5rem;
    padding: 0 1rem;
}

/* Responsive design */
@media (max-width: 768px) {
    .google-translate-container {
        margin-left: 5px;
    }
    
    .goog-te-gadget .goog-te-combo {
        min-width: 100px !important;
        padding: 6px 12px !important;
        font-size: 13px !important;
    }
    
    /* Hide desktop version on mobile */
    .google-translate-container {
        display: none;
    }
}

@media (min-width: 769px) {
    /* Hide mobile version on desktop */
    .mobile-language-link {
        display: none !important;
    }
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .goog-te-gadget .goog-te-combo option {
        background: #2d3748 !important;
        color: white !important;
    }
}
</style>

<script type="text/javascript">
function googleTranslateElementInit() {
    // Initialize untuk desktop
    new google.translate.TranslateElement({
        pageLanguage: 'id', // Bahasa halaman default (Indonesia)
        includedLanguages: 'id,en', // Hanya Indonesia dan Inggris
        layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
        autoDisplay: false,
        gaTrack: true,
        gaId: 'UA-XXXXXXXX-X' // Ganti dengan Google Analytics ID Anda jika ada
    }, 'google_translate_element_desktop');
    
    // Initialize untuk mobile
    new google.translate.TranslateElement({
        pageLanguage: 'id', // Bahasa halaman default (Indonesia)
        includedLanguages: 'id,en', // Hanya Indonesia dan Inggris
        layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
        autoDisplay: false,
        gaTrack: true,
        gaId: 'UA-XXXXXXXX-X' // Ganti dengan Google Analytics ID Anda jika ada
    }, 'google_translate_element_mobile');
}

// Load Google Translate script
function loadGoogleTranslate() {
    // Cek apakah script sudah dimuat
    if (document.querySelector('script[src*="translate.google.com"]')) {
        return;
    }
    
    const script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = 'https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
    script.async = true;
    
    script.onerror = function() {
        console.warn('Google Translate failed to load');
    };
    
    document.head.appendChild(script);
}

// Initialize Google Translate saat DOM ready
document.addEventListener('DOMContentLoaded', function() {
    loadGoogleTranslate();
});

// Untuk memastikan translate berfungsi di semua halaman
window.addEventListener('load', function() {
    // Timeout untuk memastikan Google Translate sudah siap
    setTimeout(function() {
        if (typeof google !== 'undefined' && google.translate) {
            // Google Translate sudah ready
            console.log('Google Translate ready');
        }
    }, 2000);
});

// Handle navigation untuk SPA atau AJAX loaded content
function reinitializeTranslate() {
    if (typeof google !== 'undefined' && google.translate) {
        // Force refresh translation untuk konten baru
        setTimeout(function() {
            var translateElement = google.translate.TranslateElement();
            if (translateElement) {
                translateElement.c();
            }
            // Trigger translate ulang untuk konten yang baru di-load
            google.translate.googleTranslateElementInit2();
        }, 1000);
    }
}

// Function untuk memaksa translate konten baru
function forceTranslateNewContent() {
    if (typeof google !== 'undefined' && google.translate && google.translate.TranslateElement) {
        // Dapatkan bahasa yang sedang aktif
        var currentLang = getCurrentLanguage();
        if (currentLang && currentLang !== 'id') {
            // Paksa translate konten baru
            setTimeout(function() {
                var allElements = document.querySelectorAll('body *:not(.goog-te-gadget):not(.goog-te-gadget *)');
                allElements.forEach(function(element) {
                    if (element.childNodes.length > 0) {
                        // Trigger translate untuk setiap elemen
                        var event = new Event('DOMNodeInserted', { bubbles: true });
                        element.dispatchEvent(event);
                    }
                });
            }, 500);
        }
    }
}

// Function untuk mendapatkan bahasa yang sedang aktif
function getCurrentLanguage() {
    try {
        var selectElement = document.querySelector('.goog-te-combo');
        if (selectElement) {
            return selectElement.value;
        }
        // Alternatif: cek dari URL atau cookie
        var match = document.cookie.match(/googtrans=\/[^\/]*\/([^;]*)/);
        if (match && match[1]) {
            return match[1];
        }
    } catch (e) {
        console.warn('Error getting current language:', e);
    }
    return 'id'; // default bahasa Indonesia
}

// Monitor perubahan URL untuk SPA
var lastUrl = location.href;
new MutationObserver(function() {
    const url = location.href;
    if (url !== lastUrl) {
        lastUrl = url;
        // URL berubah, mungkin navigasi SPA
        setTimeout(function() {
            forceTranslateNewContent();
        }, 1000);
    }
}).observe(document, {subtree: true, childList: true});

// Export functions untuk digunakan setelah load konten AJAX
window.reinitializeGoogleTranslate = reinitializeTranslate;
window.forceTranslateNewContent = forceTranslateNewContent;

// Event listener untuk perubahan konten dinamis
document.addEventListener('DOMContentLoaded', function() {
    // Observer untuk mendeteksi konten baru
    var observer = new MutationObserver(function(mutations) {
        var hasNewContent = false;
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                // Cek apakah ada konten baru yang perlu ditranslate
                mutation.addedNodes.forEach(function(node) {
                    if (node.nodeType === 1 && node.tagName !== 'SCRIPT' && node.tagName !== 'STYLE') {
                        hasNewContent = true;
                    }
                });
            }
        });
        
        if (hasNewContent) {
            // Ada konten baru, coba translate
            setTimeout(forceTranslateNewContent, 500);
        }
    });
    
    // Mulai observe setelah Google Translate ready
    setTimeout(function() {
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }, 3000);
});
</script><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/Kamcup/resources/views/components/navbar-translate.blade.php ENDPATH**/ ?>