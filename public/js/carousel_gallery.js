document.addEventListener("DOMContentLoaded", () => {
    const images = document.querySelectorAll(".image-item");
    const leftButton = document.querySelector(".left");
    const rightButton = document.querySelector(".right");
    let currentIndex = 0;

    function updateClasses() {
        images.forEach((image, index) => {
            image.classList.remove(
                "active",
                "prev",
                "next",
                "prev-hidden",
                "next-hidden",
                "hidden"
            );

            if (index === currentIndex) {
                image.classList.add("active");
            } else if (
                index ===
                (currentIndex - 1 + images.length) % images.length
            ) {
                image.classList.add("prev");
            } else if (index === (currentIndex + 1) % images.length) {
                image.classList.add("next");
            } else if (
                index ===
                (currentIndex - 2 + images.length) % images.length
            ) {
                image.classList.add("prev-hidden");
            } else if (index === (currentIndex + 2) % images.length) {
                image.classList.add("next-hidden");
            } else {
                image.classList.add("hidden");
            }
        });
    }

    function autoSlide() {
        currentIndex = (currentIndex + 1) % images.length;
        updateClasses();
    }

    let autoSlideInterval = setInterval(autoSlide, 5000);

    rightButton.addEventListener("click", () => {
        clearInterval(autoSlideInterval);
        currentIndex = (currentIndex + 1) % images.length;
        updateClasses();
        autoSlideInterval = setInterval(autoSlide, 5000);
    });

    leftButton.addEventListener("click", () => {
        clearInterval(autoSlideInterval);
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        updateClasses();
        autoSlideInterval = setInterval(autoSlide, 5000);
    });

    // Initial setup
    updateClasses();

    // Pause on hover
    const carousel = document.querySelector(".carousel");
    carousel.addEventListener("mouseenter", () =>
        clearInterval(autoSlideInterval)
    );
    carousel.addEventListener("mouseleave", () => {
        autoSlideInterval = setInterval(autoSlide, 5000);
    });
});
