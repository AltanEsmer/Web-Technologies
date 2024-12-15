// Create.blade.php animations
document.addEventListener('DOMContentLoaded', () => {
  // Back Button Animation
  const backButton = document.getElementById('back');
  gsap.from(backButton, {
      opacity: 0,
      y: -50,
      duration: 0.5,
      ease: "power4.out"
  });

  backButton.addEventListener('mouseenter', () => {
      gsap.to(backButton, {
          scale: 1.1,
          duration: 0.3,
          ease: "ease.out"
      });
  });

  backButton.addEventListener('mouseleave', () => {
      gsap.to(backButton, {
          scale: 1,
          duration: 0.3,
          ease: "ease.out"
      });
  });

  // File Button Animation
  const fileButton = document.getElementById('cover_image');
  gsap.from(fileButton, {
      opacity: 0,
      x: -100,
      duration: 0.5,
      ease: "power4.out"
  });

  fileButton.addEventListener('mouseenter', () => {
      gsap.to(fileButton, {
          scale: 1.05,
          duration: 0.3,
          backgroundColor: '#EEEEEE',
          ease: "power1.out"
      });
  });

  fileButton.addEventListener('mouseleave', () => {
      gsap.to(fileButton, {
          scale: 1,
          duration: 0.3,
          backgroundColor: '#EEEEEE',
          ease: "power1.out"
      });
  });

  // Create Button Animation
  const createButton = document.getElementById('saveButton');
  gsap.from(createButton, {
      opacity: 0,
      y: 50,
      duration: 0.5,
      ease: "power4.out"
  });

  createButton.addEventListener('mouseenter', () => {
      gsap.to(createButton, {
          scale: 1.05,
          duration: 0.3,
          backgroundColor: 'blue',
          ease: "power1.out"
      });
  });

  createButton.addEventListener('mouseleave', () => {
      gsap.to(createButton, {
          scale: 1,
          duration: 0.3,
          backgroundColor: '#006D77',
          ease: "power1.out"
      });
  });
});

// Link animation
document.querySelectorAll(".pl-0").forEach(link => {
    link.addEventListener("mouseenter", () => {
      gsap.to(link, { scale: 1.2, color: "green", duration: 0.3 });
    });
    link.addEventListener("mouseleave", () => {
      gsap.to(link, { scale: 1, color: "#ffffff", duration: 0.3 });
    });
  });

  function removeSong(songId) {
    const removeButton = document.getElementById(`removeButton-${songId}`);

    anime({
        targets: removeButton,
        rotate: '360deg',
        duration: 800,
        easing: 'easeInOutQuad',
        complete: function() {
          // Error control
            console.log(`Rotation completed for song ID: ${songId}`);
        }
    });
}
