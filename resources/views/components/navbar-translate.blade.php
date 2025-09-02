{{-- Google Translate Widget --}}
<li class="nav-item">
    <div id="google_translate_element"></div>
</li>

@push('styles')
<style>
/* Google Translate Container */
#google_translate_element {
    display: inline-block;
}

/* Google Translate Gadget Styling */
.goog-te-gadget {
    font-family: 'Poppins', sans-serif !important;
    font-size: 0 !important;
}

.goog-te-gadget .goog-te-combo {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    color: white !important;
    border: none !important;
    border-radius: 20px !important;
    padding: 8px 16px !important;
    font-size: 14px !important;
    font-weight: 500 !important;
    font-family: 'Poppins', sans-serif !important;
    cursor: pointer !important;
    outline: none !important;
    min-width: 120px !important;
    box-shadow: 0 2px 10px rgba(102, 126, 234, 0.3) !important;
    transition: all 0.3s ease !important;
}

.goog-te-gadget .goog-te-combo:hover {
    background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%) !important;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4) !important;
    transform: translateY(-1px) !important;
}

.goog-te-gadget .goog-te-combo:focus {
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.3) !important;
}

/* Hide Google branding text */
.goog-te-gadget-simple .goog-te-menu-value span:first-child {
    display: none;
}

.goog-te-gadget-simple .goog-te-menu-value:before {
    content: '🌐 Language';
    font-size: 14px;
    font-weight: 500;
}

/* Hide Google Translate banner and notifications */
.goog-te-banner-frame {
    display: none !important;
}

body {
    top: 0 !important;
}

.skiptranslate > iframe {
    visibility: hidden !important;
    height: 0 !important;
    width: 0 !important;
}

/* Mobile responsive */
@media (max-width: 768px) {
    .goog-te-gadget .goog-te-combo {
        min-width: 140px !important;
        padding: 10px 16px !important;
        font-size: 15px !important;
    }
    
    .goog-te-gadget-simple .goog-te-menu-value:before {
        content: '🌐';
    }
}

/* Untuk navbar transparan di homepage */
.home-page .navbar .goog-te-gadget .goog-te-combo {
    background: rgba(255, 255, 255, 0.15) !important;
    backdrop-filter: blur(10px) !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    color: white !important;
}

.home-page .navbar .goog-te-gadget .goog-te-combo:hover {
    background: rgba(255, 255, 255, 0.25) !important;
}
</style>
@endpush

@push('scripts')
<script type="text/javascript">
function googleTranslateElementInit() {
    new google.translate.TranslateElement({
        pageLanguage: 'id',
        includedLanguages: 'id,en',
        layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
        autoDisplay: false
    }, 'google_translate_element');
}

// Load Google Translate Script
(function() {
    var gtScript = document.createElement('script');
    gtScript.type = 'text/javascript';
    gtScript.async = true;
    gtScript.src = 'https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
    
    gtScript.onload = function() {
        console.log('Google Translate loaded successfully');
    };
    
    gtScript.onerror = function() {
        console.error('Failed to load Google Translate');
    };
    
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(gtScript, s);
})();

// Clean up Google Translate UI after load
window.addEventListener('load', function() {
    setTimeout(function() {
        // Hide banner
        var banner = document.querySelector('.goog-te-banner-frame');
        if (banner) {
            banner.style.display = 'none';
        }
        
        // Reset body position
        document.body.style.top = '0px';
        document.body.style.position = 'static';
        
        // Hide notification iframe
        var skiptranslate = document.querySelector('.skiptranslate');
        if (skiptranslate) {
            var iframe = skiptranslate.querySelector('iframe');
            if (iframe) {
                iframe.style.visibility = 'hidden';
                iframe.style.height = '0px';
                iframe.style.width = '0px';
            }
        }
    }, 2000);
});
</script>
@endpush