<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'KAMCUP')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')
</head>

<body style="font-family: 'Poppins', sans-serif">
    <nav class="navbar navbar-expand-lg bg-transparent py-3 position-absolute top-0 start-0 w-100 z-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('front.index') }}"
                style="width: 260px; overflow: hidden; height: 130px;">
                <img src="{{ asset('assets/img/logo5.png') }}" alt="KAMCUP Logo" class="me-2 brand-logo"
                    style="height: 90%; width: 90%; object-fit: cover;">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
                    <li class="nav-item"><a class="nav-link fw-medium" href="{{ route('front.index') }}">HOME</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium" href="{{ route('front.articles') }}">BERITA</a>
                    </li>
                    <li class="nav-item"><a class="nav-link fw-medium" href="{{ route('front.galleries') }}">GALERI</a>
                    </li>
                    <li class="nav-item"><a class="nav-link fw-medium"
                            href="{{ route('front.events.index') }}">EVENT</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium" href="{{ route('front.contact') }}">HUBUNGI
                            KAMI</a></li>
                    </li>

                    <li class="nav-item search-container">
                        <a href="#" class="nav-link search-icon" id="search-icon">
                            <i class="fas fa-search"></i>
                        </a>
                        <form action="{{ route('front.search') }}" method="GET" class="search-form" id="search-form">
                            <input type="text" name="query" class="search-input"
                                placeholder="Cari artikel, event, galeri..." value="{{ request('query') }}"
                                autocomplete="off" required minlength="3">
                            <button type="submit" class="search-submit-btn" aria-label="Submit Search">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </li>

                    @guest
                        <li class="nav-item"><a class="nav-link fw-medium" href="{{ route('login') }}">LOGIN</a></li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle fw-medium d-flex align-items-center" href="#"
                                id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-1"></i>
                                {{ Str::limit(Auth::user()->name ?? 'Profile', 15) }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.index') }}">
                                        <i class="bi bi-person me-2"></i>Profile Saya
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest

                    {{-- Component Translator --}}
                    <x-navbar-translate />
                </ul>
            </div>
        </div>
    </nav>
    <div class="main-wrapper d-flex flex-column min-vh-100">
        <div class="container alert-fixed">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        {{-- Content Section --}}
        <div class="content flex-grow-1">
            @yield('content')
        </div>

        {{-- Footer --}}
        @include('layouts.footer')
    </div>

    <!-- Chatbot Widget -->
    <div id="chatbot-widget" class="chatbot-widget">
        <!-- Chatbot Toggle Button -->
        <div class="chatbot-toggle" id="chatbot-toggle">
            <i class="bi bi-chat-dots"></i>
            <span class="notification-badge" id="notification-badge">1</span>
        </div>

        <!-- Chatbot Container -->
        <div class="chatbot-container" id="chatbot-container">
            <div class="chatbot-header">
                <div class="chatbot-title">
                    <i class="bi bi-robot"></i>
                    <span>KAMCUP Assistant</span>
                </div>
                <button class="chatbot-close" id="chatbot-close">
                    <i class="bi bi-x"></i>
                </button>
            </div>

            <div class="chatbot-messages" id="chatbot-messages">
                <div class="message bot-message">
                    <div class="message-avatar">
                        <i class="bi bi-robot"></i>
                    </div>
                    <div class="message-content">
                        <p>Halo! Selamat datang di KAMCUP Bot!</p>
                        <p>Ketik 'menu' untuk melihat pilihan atau 'help' untuk bantuan.</p>
                    </div>
                </div>
            </div>

            <div class="chatbot-input">
                <div class="input-group">
                    <input type="text" id="chatbot-message-input" class="form-control"
                        placeholder="Ketik pesan Anda..." autocomplete="off">
                    <button class="btn btn-primary" id="chatbot-send-btn">
                        <i class="bi bi-send"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Chatbot Widget Styles */
        .chatbot-widget {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
            font-family: 'Poppins', sans-serif;
        }

        .chatbot-toggle {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #0F62FF, #1976d2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(15, 98, 255, 0.3);
            transition: all 0.3s ease;
            position: relative;
        }

        .chatbot-toggle:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 25px rgba(15, 98, 255, 0.4);
        }

        .chatbot-toggle i {
            color: white;
            font-size: 24px;
            transition: transform 0.3s ease;
        }

        .chatbot-toggle:hover i {
            transform: scale(1.1);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #F4B704;
            color: #212529;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }

        .chatbot-container {
            position: absolute;
            bottom: 80px;
            right: 0;
            width: 350px;
            height: 500px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            display: none;
            flex-direction: column;
            overflow: hidden;
            border: 1px solid #e9ecef;
        }

        .chatbot-container.active {
            display: flex;
            animation: slideUp 0.3s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .chatbot-header {
            background: linear-gradient(135deg, #0F62FF, #1976d2);
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chatbot-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            font-size: 16px;
        }

        .chatbot-close {
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            padding: 5px;
            border-radius: 50%;
            transition: background 0.2s ease;
        }

        .chatbot-close:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .chatbot-messages {
            flex: 1;
            padding: 15px;
            overflow-y: auto;
            background: #f8f9fa;
        }

        .message {
            display: flex;
            margin-bottom: 15px;
            align-items: flex-start;
            gap: 10px;
        }

        .message-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .bot-message .message-avatar {
            background: linear-gradient(135deg, #0F62FF, #1976d2);
            color: white;
        }

        .user-message {
            flex-direction: row-reverse;
        }

        .user-message .message-avatar {
            background: #F4B704;
            color: #212529;
        }

        .message-content {
            max-width: 250px;
            padding: 10px 15px;
            border-radius: 15px;
            line-height: 1.4;
            font-size: 14px;
        }

        .bot-message .message-content {
            background: white;
            border: 1px solid #e9ecef;
            margin-right: auto;
        }

        .user-message .message-content {
            background: #0F62FF;
            color: white;
            margin-left: auto;
        }

        .message-content p {
            margin: 0;
            margin-bottom: 5px;
        }

        .message-content p:last-child {
            margin-bottom: 0;
        }

        .chatbot-input {
            padding: 15px;
            background: white;
            border-top: 1px solid #e9ecef;
        }

        .chatbot-input .input-group {
            display: flex;
            gap: 10px;
        }

        .chatbot-input .form-control {
            flex: 1;
            border: 1px solid #dee2e6;
            border-radius: 20px;
            padding: 10px 15px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s ease;
        }

        .chatbot-input .form-control:focus {
            border-color: #0F62FF;
            box-shadow: 0 0 0 2px rgba(15, 98, 255, 0.2);
        }

        .chatbot-input .btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0F62FF;
            border: none;
            transition: background 0.2s ease;
        }

        .chatbot-input .btn:hover {
            background: #1976d2;
        }

        /* Typing indicator */
        .typing-indicator {
            display: flex;
            align-items: center;
            gap: 4px;
            padding: 15px;
        }

        .typing-indicator span {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #6c757d;
            animation: typing 1.4s infinite ease-in-out;
        }

        .typing-indicator span:nth-child(1) {
            animation-delay: -0.32s;
        }

        .typing-indicator span:nth-child(2) {
            animation-delay: -0.16s;
        }

        @keyframes typing {

            0%,
            80%,
            100% {
                transform: scale(0.8);
                opacity: 0.5;
            }

            40% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Mobile responsive */
        @media (max-width: 768px) {
            .chatbot-container {
                width: 300px;
                height: 450px;
                bottom: 70px;
                right: 10px;
            }

            .chatbot-widget {
                bottom: 15px;
                right: 15px;
            }

            .chatbot-toggle {
                width: 55px;
                height: 55px;
            }

            .chatbot-toggle i {
                font-size: 22px;
            }
        }

        @media (max-width: 480px) {
            .chatbot-container {
                width: calc(100vw - 30px);
                height: 400px;
                left: 15px;
                right: 15px;
            }
        }

        /* Scrollbar styling */
        .chatbot-messages::-webkit-scrollbar {
            width: 4px;
        }

        .chatbot-messages::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .chatbot-messages::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }

        .chatbot-messages::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

    {{-- JavaScript untuk Search Toggle --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            const searchIcon = document.getElementById('search-icon');
            const searchForm = document.getElementById('search-form');
            const searchInput = searchForm?.querySelector('.search-input');

            if (searchIcon && searchForm && searchInput) {
                searchIcon.addEventListener('click', function(event) {
                    event.preventDefault();
                    event.stopPropagation();
                    searchForm.classList.toggle('active');
                    if (searchForm.classList.contains('active')) {
                        searchInput.focus();
                    }
                });

                document.addEventListener('click', function(event) {
                    const isClickInsideForm = searchForm.contains(event.target);
                    const isClickOnIcon = searchIcon.contains(event.target);
                    if (!isClickInsideForm && !isClickOnIcon) {
                        searchForm.classList.remove('active');
                    }
                });

                searchForm.addEventListener('click', function(event) {
                    event.stopPropagation();
                });
            }

            // Chatbot functionality
            const chatbotToggle = document.getElementById('chatbot-toggle');
            const chatbotContainer = document.getElementById('chatbot-container');
            const chatbotClose = document.getElementById('chatbot-close');
            const chatbotMessages = document.getElementById('chatbot-messages');
            const messageInput = document.getElementById('chatbot-message-input');
            const sendBtn = document.getElementById('chatbot-send-btn');
            const notificationBadge = document.getElementById('notification-badge');

            let isOpen = false;

            // Toggle chatbot
            chatbotToggle.addEventListener('click', function() {
                toggleChatbot();
            });

            chatbotClose.addEventListener('click', function() {
                toggleChatbot();
            });

            function toggleChatbot() {
                isOpen = !isOpen;
                if (isOpen) {
                    chatbotContainer.classList.add('active');
                    messageInput.focus();
                    hideNotificationBadge();
                } else {
                    chatbotContainer.classList.remove('active');
                }
            }

            function hideNotificationBadge() {
                notificationBadge.style.display = 'none';
            }

            // Send message
            function sendMessage() {
                const message = messageInput.value.trim();
                if (message === '') return;

                // Add user message to chat
                addMessage(message, 'user');
                messageInput.value = '';

                // Show typing indicator
                showTypingIndicator();

                // Send to BotMan
                fetch('/botman', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            driver: 'web',
                            message: message,
                            userId: 'web-user-' + Date.now()
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        hideTypingIndicator();
                        if (data.messages && data.messages.length > 0) {
                            data.messages.forEach(msg => {
                                setTimeout(() => {
                                    addMessage(msg.text, 'bot');
                                }, 500);
                            });
                        } else {
                            addMessage('Maaf, terjadi kesalahan. Silakan coba lagi.', 'bot');
                        }
                    })
                    .catch(error => {
                        hideTypingIndicator();
                        console.error('Error:', error);
                        addMessage('Maaf, koneksi terputus. Silakan coba lagi.', 'bot');
                    });
            }

            sendBtn.addEventListener('click', sendMessage);

            messageInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    sendMessage();
                }
            });

            function addMessage(text, sender) {
                const messageDiv = document.createElement('div');
                messageDiv.className = `message ${sender}-message`;

                const avatarDiv = document.createElement('div');
                avatarDiv.className = 'message-avatar';
                avatarDiv.innerHTML = sender === 'bot' ? '<i class="bi bi-robot"></i>' :
                    '<i class="bi bi-person"></i>';

                const contentDiv = document.createElement('div');
                contentDiv.className = 'message-content';

                // Format text with basic markdown support
                const formattedText = text
                    .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                    .replace(/\n/g, '<br>')
                    .replace(/(https?:\/\/[^\s]+)/g, '<a href="$1" target="_blank">$1</a>');

                contentDiv.innerHTML = `<p>${formattedText}</p>`;

                messageDiv.appendChild(avatarDiv);
                messageDiv.appendChild(contentDiv);

                chatbotMessages.appendChild(messageDiv);
                chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
            }

            function showTypingIndicator() {
                const typingDiv = document.createElement('div');
                typingDiv.id = 'typing-indicator';
                typingDiv.className = 'message bot-message';
                typingDiv.innerHTML = `
                    <div class="message-avatar">
                        <i class="bi bi-robot"></i>
                    </div>
                    <div class="message-content">
                        <div class="typing-indicator">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                `;
                chatbotMessages.appendChild(typingDiv);
                chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
            }

            function hideTypingIndicator() {
                const typingIndicator = document.getElementById('typing-indicator');
                if (typingIndicator) {
                    typingIndicator.remove();
                }
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
