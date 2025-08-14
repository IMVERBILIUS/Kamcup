{{-- Simple Google Translate Widget - Guaranteed Working --}}
<li class="nav-item">
    <div id="google_translate_element"></div>
</li>

<style>
/* Simple styling for Google Translate */
#google_translate_element {
    margin-left: 10px;
}

/* Style the Google Translate select dropdown */
.goog-te-gadget {
    font-family: inherit !important;
    font-size: 12px !important;
}

.goog-te-gadget .goog-te-combo {
    background: linear-gradient(135deg, #0F62FF, #F4B704) !important;
    color: white !important;
    border: none !important;
    border-radius: 20px !important;
    padding: 6px 12px !important;
    font-size: 12px !important;
    font-weight: 600 !important;
    cursor: pointer !important;
    outline: none !important;
    min-width: 70px !important;
}

.goog-te-gadget .goog-te-combo:hover {
    background: linear-gradient(135deg, #0d52cc, #d49a03) !important;
}

.goog-te-gadget .goog-te-combo option {
    background: #0F62FF !important;
    color: white !important;
    padding: 5px !important;
}

/* Hide Google branding */
.goog-te-gadget .goog-te-gadget-simple .goog-te-menu-value span:first-child {
    display: none;
}

.goog-te-gadget .goog-te-gadget-simple .goog-te-menu-value:before {
    content: '🌍 ';
    font-size: 12px;
}

/* Hide banner */
.goog-te-banner-frame {
    display: none !important;
}

body {
    top: 0 !important;
}

.skiptranslate > iframe {
    height: 0 !important;
    border-style: none !important;
    box-shadow: none !important;
}

/* Mobile responsive */
@media (max-width: 768px) {
    .goog-te-gadget .goog-te-combo {
        padding: 4px 8px !important;
        font-size: 11px !important;
        min-width: 60px !important;
    }
    
    #google_translate_element {
        margin-left: 5px;
    }
}

/* Simple notification */
.simple-notification {
    position: fixed;
    top: 70px;
    right: 20px;
    background: rgba(0, 123, 255, 0.9);
    color: white;
    padding: 8px 15px;
    border-radius: 5px;
    font-size: 12px;
    z-index: 9999;
    opacity: 0;
    transform: translateX(100%);
    transition: all 0.3s ease;
}

.simple-notification.show {
    opacity: 1;
    transform: translateX(0);
}

.simple-notification.success {
    background: rgba(40, 167, 69, 0.9);
}

@media (max-width: 768px) {
    .simple-notification {
        top: 60px;
        right: 10px;
        font-size: 11px;
        padding: 6px 12px;
    }
}
</style>

<script type="text/javascript">
// Simple Google Translate initialization
function googleTranslateElementInit() {
    new google.translate.TranslateElement({
        pageLanguage: 'id',
        includedLanguages: 'en,id',
        layout: google.translate.TranslateElement.InlineLayout.SIMPLE
    }, 'google_translate_element');
    
    console.log('Google Translate loaded successfully');
    showSimpleNotification('🌍 Translator ready!');
}

// Simple notification function
function showSimpleNotification(message, type = 'success') {
    // Remove existing notification
    const existing = document.getElementById('simpleNotification');
    if (existing) {
        existing.remove();
    }
    
    // Create notification
    const notification = document.createElement('div');
    notification.id = 'simpleNotification';
    notification.className = `simple-notification ${type}`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    // Show notification
    setTimeout(() => {
        notification.classList.add('show');
    }, 100);
    
    // Hide notification
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 3000);
}

// Load Google Translate
function loadGoogleTranslate() {
    const script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = 'https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
    
    script.onload = function() {
        console.log('Google Translate script loaded');
    };
    
    script.onerror = function() {
        console.error('Failed to load Google Translate');
        showSimpleNotification('Translation service unavailable', 'error');
    };
    
    document.head.appendChild(script);
}

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    console.log('Loading Google Translate...');
    loadGoogleTranslate();
});

// Test function
window.testTranslator = function() {
    console.log('Testing Google Translate...');
    console.log('Element:', document.getElementById('google_translate_element'));
    console.log('Combo:', document.querySelector('.goog-te-combo'));
    showSimpleNotification('Translator test completed!');
};
</script>
