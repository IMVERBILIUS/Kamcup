document.addEventListener("DOMContentLoaded", function () {
    // Search functionality
    const searchIcon = document.getElementById("search-icon");
    const searchForm = document.getElementById("search-form");
    const searchInput = searchForm?.querySelector(".search-input");

    if (searchIcon && searchForm && searchInput) {
        searchIcon.addEventListener("click", function (event) {
            event.preventDefault();
            event.stopPropagation();
            searchForm.classList.toggle("active");
            if (searchForm.classList.contains("active")) {
                searchInput.focus();
            }
        });

        document.addEventListener("click", function (event) {
            const isClickInsideForm = searchForm.contains(event.target);
            const isClickOnIcon = searchIcon.contains(event.target);
            if (!isClickInsideForm && !isClickOnIcon) {
                searchForm.classList.remove("active");
            }
        });

        searchForm.addEventListener("click", function (event) {
            event.stopPropagation();
        });
    }

    // Chatbot functionality
    const chatbotToggle = document.getElementById("chatbot-toggle");
    const chatbotContainer = document.getElementById("chatbot-container");
    const chatbotClose = document.getElementById("chatbot-close");
    const chatbotMessages = document.getElementById("chatbot-messages");
    const messageInput = document.getElementById("chatbot-message-input");
    const sendBtn = document.getElementById("chatbot-send-btn");
    const notificationBadge = document.getElementById("notification-badge");

    let isOpen = false;

    // Toggle chatbot
    chatbotToggle.addEventListener("click", function () {
        toggleChatbot();
    });

    chatbotClose.addEventListener("click", function () {
        toggleChatbot();
    });

    function toggleChatbot() {
        isOpen = !isOpen;
        if (isOpen) {
            chatbotContainer.classList.add("active");
            messageInput.focus();
            hideNotificationBadge();
        } else {
            chatbotContainer.classList.remove("active");
        }
    }

    function hideNotificationBadge() {
        notificationBadge.style.display = "none";
    }

    // Send message
    function sendMessage() {
        const message = messageInput.value.trim();
        if (message === "") return;

        // Add user message to chat
        addMessage(message, "user");
        messageInput.value = "";

        // Show typing indicator
        showTypingIndicator();

        // Send to BotMan
        fetch("/botman", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify({
                driver: "web",
                message: message,
                userId: "web-user-" + Date.now(),
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                hideTypingIndicator();
                if (data.messages && data.messages.length > 0) {
                    data.messages.forEach((msg) => {
                        setTimeout(() => {
                            addMessage(msg.text, "bot");
                        }, 500);
                    });
                } else {
                    addMessage(
                        "Maaf, terjadi kesalahan. Silakan coba lagi.",
                        "bot"
                    );
                }
            })
            .catch((error) => {
                hideTypingIndicator();
                console.error("Error:", error);
                addMessage("Maaf, koneksi terputus. Silakan coba lagi.", "bot");
            });
    }

    sendBtn.addEventListener("click", sendMessage);

    messageInput.addEventListener("keypress", function (e) {
        if (e.key === "Enter") {
            sendMessage();
        }
    });

    function addMessage(text, sender) {
        const messageDiv = document.createElement("div");
        messageDiv.className = `message ${sender}-message`;

        const avatarDiv = document.createElement("div");
        avatarDiv.className = "message-avatar";
        avatarDiv.innerHTML =
            sender === "bot"
                ? '<i class="bi bi-robot"></i>'
                : '<i class="bi bi-person"></i>';

        const contentDiv = document.createElement("div");
        contentDiv.className = "message-content";

        // Format text with basic markdown support
        const formattedText = text
            .replace(/\*\*(.*?)\*\*/g, "<strong>$1</strong>")
            .replace(/\n/g, "<br>")
            .replace(
                /(https?:\/\/[^\s]+)/g,
                '<a href="$1" target="_blank">$1</a>'
            );

        contentDiv.innerHTML = `<p>${formattedText}</p>`;

        messageDiv.appendChild(avatarDiv);
        messageDiv.appendChild(contentDiv);

        chatbotMessages.appendChild(messageDiv);
        chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
    }

    function showTypingIndicator() {
        const typingDiv = document.createElement("div");
        typingDiv.id = "typing-indicator";
        typingDiv.className = "message bot-message";
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
        const typingIndicator = document.getElementById("typing-indicator");
        if (typingIndicator) {
            typingIndicator.remove();
        }
    }
});
