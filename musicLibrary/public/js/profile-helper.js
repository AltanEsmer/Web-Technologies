// Dropdown Menu Functionality
function toggleMenu() {
  let subMenu = document.getElementById("subMenu");
  subMenu.classList.toggle("open-menu");
}

document.addEventListener("DOMContentLoaded", () => {
    document.body.style.opacity = "0";
    document.body.style.transition = "opacity 1s ease-in-out";
    document.body.style.opacity = "1";
});

document.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', (event) => {
        event.preventDefault();
        const href = link.getAttribute('href');
        document.body.style.opacity = "0";
        setTimeout(() => {
            window.location.href = href;
        }, 1000);
    });
});
