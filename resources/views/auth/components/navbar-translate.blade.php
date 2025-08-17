{{-- Custom Beautiful Button for Google Translate --}}
<li class="nav-item">
    <div class="custom-translate-button">
        <button id="language-toggle" class="translate-btn">
            <span class="btn-icon">🌍</span>
            <span class="btn-text">Indonesia</span>
            <span class="btn-arrow">▼</span>
        </button>
        
        <div class="language-dropdown" id="language-dropdown">
            <div class="dropdown-item" data-lang="id">
                <span class="flag">🇮🇩</span>
                <span class="lang-name">Indonesia</span>
            </div>
            <div class="dropdown-item" data-lang="en">
                <span class="flag">🇺🇸</span>
                <span class="lang-name">English</span>
            </div>
        </div>
    </div>
    
    <div id="google_translate_element" style="display: none !important;"></div>
</li>

<style>
/* Custom Beautiful Button Styles */
.custom-translate-button {
    position: relative;
    margin-left: 10px;
}

.translate-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 25px;
    padding: 10px 20px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    outline: none;
    display: flex;
    align-items: center;
    gap: 8px;
    min-width: 140px;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

/* Button Icons and Text */
.btn-icon {
    font-size: 16px;
    flex-shrink: 0;
}

.btn-text {
    flex: 1;
    text-align: left;
    font-weight: 500;
}

.btn-arrow {
    font-size: 10px;
    transition: transform 0.3s ease;
    flex-shrink: 0;
}

/* Button States */
.translate-btn:hover {
    background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    transform: translateY(-2px);
}

.translate-btn:active {
    transform: translateY(0);
    box-shadow: 0 2px 10px rgba(102, 126, 234, 0.4);
}

.translate-btn.open .btn-arrow {
    transform: rotate(180deg);
}

/* Dropdown Menu */
.language-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 1000;
    overflow: hidden;
    margin-top: 5px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.language-dropdown.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    cursor: pointer;
    transition: all 0.2s ease;
    color: #333;
    font-size: 14px;
    font-weight: 500;
}

.dropdown-item:hover {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.dropdown-item:first-child {
    border-radius: 15px 15px 0 0;
}

.dropdown-item:last-child {
    border-radius: 0 0 15px 15px;
}

.dropdown-item .flag {
    font-size: 18px;
    flex-shrink: 0;
}

.dropdown-item .lang-name {
    flex: 1;
}

.dropdown-item.active {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

/* Enhanced notification */
.simple-notification {
    position: fixed;
    top: 70px;
    right: 20px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    padding: 12px 20px;
    border-radius: 25px;
    font-size: 13px;
    font-weight: 500;
    z-index: 9999;
    opacity: 0;
    transform: translateX(100%);
    transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.2);
}

.simple-notification.show {
    opacity: 1;
    transform: translateX(0);
}

/* Hide Google Translate completely */
#google_translate_element, .goog-te-gadget, .goog-te-banner-frame {
    display: none !important;
    visibility: hidden !important;
    opacity: 0 !important;
    position: absolute !important;
    left: -9999px !important;
}

body { top: 0 !important; }
.skiptranslate > iframe { display: none !important; }
</style>

<script type="text/javascript">
// --- HELPER FUNCTIONS ---
function setCookie(name, value, days) {
    let expires = "";
    if (days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/; SameSite=Lax";
}

function getCookie(name) {
    const nameEQ = name + "=";
    const ca = document.cookie.split(';');
    for(let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

function getCurrentLanguage() {
    // Cek dari localStorage dulu untuk persistensi yang lebih baik
    const savedLang = localStorage.getItem('selected_language');
    if (savedLang && (savedLang === 'id' || savedLang === 'en')) {
        return savedLang;
    }
    
    // Fallback ke cookie Google Translate
    const cookie = getCookie('googtrans');
    if (!cookie || cookie === 'null' || cookie === '') {
        return 'id';
    }
    const langCode = cookie.split('/').pop();
    return langCode || 'id';
}

function setCurrentLanguage(lang) {
    // Simpan di localStorage untuk persistensi
    localStorage.setItem('selected_language', lang);
    
    // Set cookie untuk Google Translate
    if (lang === 'id') {
        setCookie('googtrans', '', -1); // Remove cookie for Indonesian
        setCookie('googtrans', '/id/id', 365);
    } else {
        setCookie('googtrans', `/id/${lang}`, 365);
    }
}

// --- GOOGLE TRANSLATE INITIALIZATION ---
function googleTranslateElementInit() {
    new google.translate.TranslateElement({
        pageLanguage: 'id',
        includedLanguages: 'en,id',
        layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
        autoDisplay: false
    }, 'google_translate_element');
    
    // Setelah Google Translate dimuat, terapkan bahasa yang tersimpan
    setTimeout(applyStoredLanguage, 1000);
}

function loadGoogleTranslateScript() {
    if (document.querySelector('script[src*="translate.google.com"]')) return;
    const script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = 'https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
    script.onerror = () => showSimpleNotification('⚠ Translation service unavailable', 'error');
    document.head.appendChild(script);
}

// --- APPLY STORED LANGUAGE ---
function applyStoredLanguage() {
    const savedLang = getCurrentLanguage();
    if (savedLang && savedLang !== 'id') {
        // Trigger Google Translate programmatically
        const translateSelect = document.querySelector('.goog-te-combo');
        if (translateSelect) {
            translateSelect.value = savedLang;
            translateSelect.dispatchEvent(new Event('change'));
        }
    }
}

// --- CUSTOM UI LOGIC ---
const pageLanguage = 'id';

/**
 * Mengubah bahasa dengan menyimpan preferensi dan memuat ulang halaman
 * @param {string} lang - Kode bahasa target.
 */
function selectLanguage(lang) {
    const currentLang = getCurrentLanguage();
    if (lang === currentLang) {
        closeDropdown();
        return;
    }
    
    showSimpleNotification(`🌍 Applying language...`, 'success');
    
    // Simpan preferensi bahasa
    setCurrentLanguage(lang);
    
    // Reload halaman untuk menerapkan perubahan
    setTimeout(() => {
        window.location.reload();
    }, 500);
}

function updateActiveLanguageUI(lang) {
    const toggleBtn = document.getElementById('language-toggle');
    const dropdown = document.getElementById('language-dropdown');
    if (!toggleBtn || !dropdown) return;

    const btnText = toggleBtn.querySelector('.btn-text');
    const langNames = { 'id': 'Indonesia', 'en': 'English' };
    btnText.textContent = langNames[lang] || 'Language';

    dropdown.querySelectorAll('.dropdown-item').forEach(item => {
        item.classList.toggle('active', item.getAttribute('data-lang') === lang);
    });
}

// --- DROPDOWN VISIBILITY ---
function openDropdown() {
    document.getElementById('language-dropdown').classList.add('show');
    document.getElementById('language-toggle').classList.add('open');
}

function closeDropdown() {
    document.getElementById('language-dropdown').classList.remove('show');
    document.getElementById('language-toggle').classList.remove('open');
}

// --- NOTIFICATION ---
function showSimpleNotification(message, type = 'success') {
    const existing = document.getElementById('simpleNotification');
    if (existing) existing.remove();
    const notification = document.createElement('div');
    notification.id = 'simpleNotification';
    notification.className = `simple-notification ${type}`;
    notification.innerHTML = `<span>${message}</span>`;
    document.body.appendChild(notification);
    setTimeout(() => notification.classList.add('show'), 100);
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.parentNode?.removeChild(notification), 400);
    }, 3500);
}

// --- DETECT LANGUAGE CHANGES ---
function detectLanguageChange() {
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                const body = document.body;
                if (body.classList.contains('translated-ltr')) {
                    // Halaman telah diterjemahkan ke bahasa lain
                    const currentLang = getCurrentLanguage();
                    updateActiveLanguageUI(currentLang);
                }
            }
        });
    });
    
    observer.observe(document.body, {
        attributes: true,
        attributeFilter: ['class']
    });
}

// --- MAIN INITIALIZATION ---
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('language-toggle');
    const dropdown = document.getElementById('language-dropdown');
    if (!toggleBtn || !dropdown) return;

    const initialLang = getCurrentLanguage();
    updateActiveLanguageUI(initialLang);

    toggleBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        dropdown.classList.contains('show') ? closeDropdown() : openDropdown();
    });

    dropdown.querySelectorAll('.dropdown-item').forEach(item => {
        item.addEventListener('click', () => selectLanguage(item.getAttribute('data-lang')));
    });

    document.addEventListener('click', (e) => {
        if (!e.target.closest('.custom-translate-button')) {
            closeDropdown();
        }
    });
    
    // Load Google Translate
    loadGoogleTranslateScript();
    
    // Detect language changes
    detectLanguageChange();
});

// --- HANDLE PAGE NAVIGATION ---
window.addEventListener('beforeunload', function() {
    // Pastikan bahasa tersimpan sebelum navigasi
    const currentLang = getCurrentLanguage();
    localStorage.setItem('selected_language', currentLang);
});

// --- HANDLE BACK/FORWARD NAVIGATION ---
window.addEventListener('pageshow', function(event) {
    // Jika halaman dimuat dari cache, pastikan bahasa diterapkan
    if (event.persisted) {
        setTimeout(applyStoredLanguage, 500);
    }
});
</script>
