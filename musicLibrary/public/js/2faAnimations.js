document.addEventListener('DOMContentLoaded', () => {
    const backButton = document.querySelector('.nav-link');
    
    // Initial animation
    gsap.from(backButton, {
        opacity: 0,
        x: -20,
        duration: 0.5,
        ease: "power2.out"
    });

    // Hover animations
    backButton.addEventListener('mouseenter', () => {
        gsap.to(backButton, {
            scale: 1.1,
            x: -5,
            duration: 0.3,
            ease: "power1.out"
        });
    });

    backButton.addEventListener('mouseleave', () => {
        gsap.to(backButton, {
            scale: 1,
            x: 0,
            duration: 0.3,
            ease: "power1.out"
        });
    });
}); 