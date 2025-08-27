document.addEventListener("DOMContentLoaded", function () {
    console.log("KAMCUP Website Script Loaded");

    // ===== SCROLL ANIMATIONS SCRIPT =====
    function initScrollAnimations() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: "0px 0px -50px 0px",
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const element = entry.target;
                    const delay = element.getAttribute("data-delay") || 0;

                    setTimeout(() => {
                        element.classList.add("animate");
                    }, parseInt(delay));
                } else {
                    entry.target.classList.remove("animate");
                }
            });
        }, observerOptions);

        const animateElements = document.querySelectorAll(".scroll-animate");
        animateElements.forEach((el) => {
            observer.observe(el);
        });

        console.log(
            `Scroll animations initialized for ${animateElements.length} elements`
        );
    }

    // ===== MOBILE DEVICE DETECTION =====
    function isMobileDevice() {
        return (
            window.innerWidth <= 768 ||
            /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
                navigator.userAgent
            )
        );
    }

    // ===== MOBILE TOUCH EVENTS =====
    if (isMobileDevice()) {
        console.log("Mobile device detected - setting up touch handlers");

        const cards = document.querySelectorAll(".card-hover-zoom");
        cards.forEach((card) => {
            card.addEventListener(
                "touchstart",
                function (e) {
                    this.style.transform = "scale(1.02)";
                    this.style.zIndex = "5";
                    this.style.transition = "transform 0.1s ease";
                },
                { passive: true }
            );

            card.addEventListener(
                "touchend",
                function (e) {
                    setTimeout(() => {
                        this.style.transform = "scale(1)";
                        this.style.zIndex = "1";
                    }, 100);
                },
                { passive: true }
            );

            card.addEventListener(
                "touchcancel",
                function (e) {
                    this.style.transform = "scale(1)";
                    this.style.zIndex = "1";
                },
                { passive: true }
            );
        });
    }

    // ===== BUTTON HANDLERS =====
    const buttons = document.querySelectorAll(".btn");
    buttons.forEach((btn) => {
        btn.addEventListener(
            "touchstart",
            function (e) {
                this.style.transform = "scale(0.98)";
                this.style.transition = "transform 0.1s ease";
            },
            { passive: true }
        );

        btn.addEventListener(
            "touchend",
            function (e) {
                setTimeout(() => {
                    this.style.transform = "scale(1)";
                }, 100);
            },
            { passive: true }
        );
    });

    // ===== INITIALIZE EVERYTHING =====
    initScrollAnimations();

    // ===== FALLBACK INITIALIZATION =====
    setTimeout(() => {
        console.log("Running fallback setup");

        const animateElements = document.querySelectorAll(
            ".scroll-animate:not(.animate)"
        );
        if (animateElements.length > 0) {
            console.log("Re-initializing scroll animations");
            initScrollAnimations();
        }
    }, 1000);

    console.log("All handlers setup complete");
});

// ===== WINDOW RESIZE HANDLER =====
window.addEventListener("resize", function () {
    setTimeout(() => {
        console.log("Window resized - re-checking carousels");
    }, 200);
});

// ===== PERFORMANCE OPTIMIZATION =====
document.addEventListener(
    "scroll",
    function () {
        // Scroll optimizations
    },
    { passive: true }
);
