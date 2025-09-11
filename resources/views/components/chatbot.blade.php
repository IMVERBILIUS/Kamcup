<!-- Chatbot Widget -->
<div class="chatbot-widget" id="chatbot-widget">
    <!-- Toggle Button -->
    <button class="chatbot-toggle" id="chatbot-toggle" aria-label="Buka Chatbot">
        <i class="bi bi-chat-dots"></i>
        <span class="notification-badge" id="notification-badge">1</span>
    </button>

    <!-- Chatbot Container -->
    <div class="chatbot-container" id="chatbot-container">
        <div class="chatbot-header">
            <div class="chatbot-title">
                <i class="bi bi-robot"></i>
                <span>KAMCUP Assistant</span>
            </div>
            <button class="chatbot-close" id="chatbot-close" aria-label="Tutup Chatbot">
                <i class="bi bi-x"></i>
            </button>
        </div>

        <div class="chatbot-messages" id="chatbot-messages">
            <div class="message bot-message">
                <div class="message-avatar"><i class="bi bi-robot"></i></div>
                <div class="message-content">
                    <p>Halo! Selamat datang di KAMCUP Bot!</p>
                    <p>Ketik 'menu' untuk melihat pilihan atau 'help' untuk bantuan.</p>
                </div>
            </div>
        </div>

        <div class="chatbot-input">
            <div class="input-group">
                <input type="text" class="form-control" id="chatbot-message-input" placeholder="Ketik pesan Anda..."
                    autocomplete="off">
                <button class="btn btn-primary" id="chatbot-send-btn" aria-label="Kirim Pesan">
                    <i class="bi bi-send"></i>
                </button>
            </div>
        </div>
    </div>
</div>
