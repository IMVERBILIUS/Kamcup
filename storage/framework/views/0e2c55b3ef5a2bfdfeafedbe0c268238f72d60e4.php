







<div id="google_translate_element_invisible" style="display:none !important;"></div>


<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'id',
            includedLanguages: 'id,en',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
            autoDisplay: false
        }, 'google_translate_element_invisible');
    }
</script>

<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>




<script type="text/javascript">
    // Fungsi ini akan berjalan setelah seluruh halaman dimuat
    window.onload = function() {
        // Jalankan pengecekan secara berulang setiap 100 milidetik
        const interval = setInterval(function() {
            // Cari elemen banner Google
            const bannerFrame = document.querySelector('.goog-te-banner-frame');
            
            if (bannerFrame !== null) {
                // Jika banner ditemukan, hapus dari halaman
                bannerFrame.remove();
                
                // Paksa posisi body kembali ke atas
                document.body.style.top = '0px';
                
                // Hentikan pengecekan berulang karena tugas sudah selesai
                clearInterval(interval);
            }
        }, 100); // Cek setiap 100ms
    };
</script><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/Kamcup/resources/views/partials/floating-translate.blade.php ENDPATH**/ ?>