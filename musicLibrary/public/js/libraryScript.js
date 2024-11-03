const prevButton = document.querySelector('.prev');
const nextButton = document.querySelector('.next');
const carousel = document.querySelector('.carousel');
let scrollAmount = 0;

prevButton.addEventListener('click', () => {
    carousel.scrollTo({
        top: 0,
        left: (scrollAmount -= 150),
        behavior: 'smooth'
    });
    if (scrollAmount < 0) scrollAmount = 0;
});

nextButton.addEventListener('click', () => {
    carousel.scrollTo({
        top: 0,
        left: (scrollAmount += 150),
        behavior: 'smooth'
    });
});
