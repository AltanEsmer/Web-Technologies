const navLinks = document.querySelectorAll(".nav-menu .nav-link");
const menuOpenButton = document.querySelector("#menu-open-button");
const menuCloseButton = document.querySelector("#menu-close-button");
/*
menuOpenButton.addEventListener("click", () => {
  //Enable mobile menu visibility
  document.body.classList.toggle("show-mobile-menu");
});

menuCloseButton.addEventListener("click", () => menuOpenButton.click()
);

// Automatic close of nav links
navLinks.forEach(link => {
  link.addEventListener("click", () => menuOpenButton.click())
});*/

/*
//Initialize Swiper
const swiper = new Swiper('.slider-wrapper', {
  loop: true,
  grapCursor: true,
  spaceBetween: 25,

  pagination: {
    el: '.swiper-pagination',
    clickable: true,
    dynamicBullets: true
  },

  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },

  //Responsive Breakpoints
  breakpoints: {
    0: {
      slidesPerView: 1
    },
    768: {
      slidesPerView: 2
    },
    1024: {
      slidesPerView: 3
    }
  }
});
*/

gsap.registerPlugin(ScrollTrigger);

// Smooth hover animations for navbar links
document.querySelectorAll(".navbar a").forEach(link => {
  link.addEventListener("mouseenter", () => {
    gsap.to(link, { scale: 1.2, color: "#1DB954", duration: 0.3 });
  });
  link.addEventListener("mouseleave", () => {
    gsap.to(link, { scale: 1, color: "#ffffff", duration: 0.3 });
  });
});

const buttons = document.querySelectorAll('.animated-btn');

buttons.forEach(button => {
  button.addEventListener('mouseenter', () => {
    anime({
      targets: button,
      scale: 1.2,
      duration: 200,
      easing: 'easeInOutQuad',
    });
  });

  button.addEventListener('mouseleave', () => {
    anime({
      targets: button,
      scale: 1,
      duration: 200,
      easing: 'easeInOutQuad',
    });
  });

  button.addEventListener('mousedown', () => {
    anime({
      targets: button,
      scale: 0.9,
      duration: 100,
      easing: 'easeOutQuad',
    });
  });

  button.addEventListener('mouseup', () => {
    anime({
      targets: button,
      scale: 1.1,
      duration: 200,
      easing: 'easeOutQuad',
    });
  });
});


// Scroll animations for sections
gsap.utils.toArray("section").forEach(section => {
  gsap.from(section, {
    opacity: 0,
    y: 50,
    duration: 1,
    scrollTrigger: {
      trigger: section,
      start: "top 100%", 
      toggleActions: "play none none reverse", 
    }
  });
});

// Input field animations
document.querySelectorAll(".form-input").forEach(input => {
  input.addEventListener("focus", () => {
    gsap.to(input, { borderColor: "#1DB954", boxShadow: "0 0 8px #1DB954", duration: 0.3 });
  });
  input.addEventListener("blur", () => {
    gsap.to(input, { borderColor: "#ccc", boxShadow: "none", duration: 0.3 });
  });
});

document.addEventListener("DOMContentLoaded", function() {
  const images = document.querySelectorAll('.parent-image, .about-image');

  images.forEach(image => {
    image.addEventListener('mouseover', function() {
      anime({
        targets: image,
        scale: 1.1,          
        rotate: '10deg',      
        easing: 'easeOutQuad', 
        duration: 500,   
      });
    });

    image.addEventListener('mouseleave', function() {
      anime({
        targets: image,
        scale: 1,             
        rotate: '0deg',       
        easing: 'easeOutQuad', 
        duration: 500,        
      });
    });
  });
});

document.addEventListener("DOMContentLoaded", function() {
  gsap.from(".parent-details .title", {
    duration: 1,
    opacity: 0,
    y: -50,
    ease: "power3.out",
  });

  gsap.from(".parent-details .subtitle", {
    duration: 1,
    opacity: 0,
    y: -50,
    delay: 0.2,
    ease: "power3.out",
  });

  gsap.from(".parent-details .description", {
    duration: 1,
    opacity: 0,
    y: -50,
    delay: 0.4,
    ease: "power3.out",
  });

  gsap.from(".buttons .button", {
    duration: 1,
    opacity: 0,
    scale: 0.8,
    stagger: 0.2,
    ease: "power3.out",
  });

  gsap.from(".parent-image", {
    duration: 1,
    opacity: 0,
    scale: 0.9,
    ease: "power3.out",
  });

  // Hover animation for title text
  const title = document.querySelector(".parent-details .title");
  title.addEventListener('mouseenter', () => {
    gsap.to(title, {
      scale: 1.1,
      color: "yellow",
      duration: 0.3,
      ease: "power1.out",
    });
  });
  title.addEventListener('mouseleave', () => {
    gsap.to(title, {
      scale: 1,
      color: "#E29578",
      duration: 0.3,
      ease: "power1.out",
    });
  });

  // Hover animation for subtitle text
  const subtitle = document.querySelector(".parent-details .subtitle");
  subtitle.addEventListener('mouseenter', () => {
    gsap.to(subtitle, {
      scale: 1.1,
      color: "#1DB954",
      duration: 0.3,
      ease: "power1.out",
    });
  });
  subtitle.addEventListener('mouseleave', () => {
    gsap.to(subtitle, {
      scale: 1,
      color: "white",
      duration: 0.3,
      ease: "power1.out",
    });
  });

  // Hover animation for description text
  const description = document.querySelector(".parent-details .description");
  description.addEventListener('mouseenter', () => {
    gsap.to(description, {
      scale: 1.05,
      color: "#1DB954",
      duration: 0.3,
      ease: "power1.out",
    });
  });
  description.addEventListener('mouseleave', () => {
    gsap.to(description, {
      scale: 1,
      color: "white",
      duration: 0.3,
      ease: "power1.out",
    });
  });
});

document.addEventListener("DOMContentLoaded", function() {
  // Hover animation for About Us title
  const aboutTitle = document.querySelector(".about-section .section-title");
  aboutTitle.addEventListener('mouseenter', () => {
    gsap.to(aboutTitle, {
      scale: 1.1,       
      color: "blue",   
      duration: 0.3,
      ease: "power1.out", 
    });
  });
  aboutTitle.addEventListener('mouseleave', () => {
    gsap.to(aboutTitle, {
      scale: 1,          
      color: "#000",      
      duration: 0.3,
      ease: "power1.out",
    });
  });

  // Hover animation for Contact Us title
  const contactTitle = document.querySelector(".contact-section .section-title");
  contactTitle.addEventListener('mouseenter', () => {
    gsap.to(contactTitle, {
      scale: 1.1,        
      color: "blue",   
      duration: 0.3,
      ease: "power1.out",
    });
  });
  contactTitle.addEventListener('mouseleave', () => {
    gsap.to(contactTitle, {
      scale: 1,           
      color: "#000",      
      duration: 0.3,
      ease: "power1.out",
    });
  });
});
