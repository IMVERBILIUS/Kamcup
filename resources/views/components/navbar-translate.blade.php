{{-- Google Translate Widget Bawaan --}}
<li class="nav-item">
    <div class="google-translate-container">
        <div id="google_translate_element"></div>
    </div>
</li>

<style>
/* Container untuk Google Translate */
.google-translate-container {
    margin-left: 10px;
}

/* Styling untuk Google Translate Widget */
#google_translate_element {
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
    new google.translate.TranslateElement({
        pageLanguage: 'id', // Bahasa halaman default (Indonesia)
        includedLanguages: 'id,en', // Hanya Indonesia dan Inggris
        layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
        autoDisplay: false,
        gaTrack: true,
        gaId: 'UA-XXXXXXXX-X' // Ganti dengan Google Analytics ID Anda jika ada
    }, 'google_translate_element');
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
        // Re-scan halaman untuk elemen baru
        google.translate.TranslateElement().cleanUp();
        setTimeout(function() {
            googleTranslateElementInit();
        }, 500);
    }
}

// Export function untuk digunakan setelah load konten AJAX
window.reinitializeGoogleTranslate = reinitializeTranslate;
</script>