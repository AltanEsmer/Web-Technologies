// Carousel Scrolling Functionality
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

// Playlist Loading Functionality
document.querySelectorAll('.playlist-icon').forEach(item => {
    item.addEventListener('click', event => {
        const playlistId = event.target.getAttribute('data-playlist-id');
        loadPlaylistDetails(playlistId);
    });
});
document.querySelectorAll('.playlist-icon').forEach(item => {
    item.addEventListener('click', function () {
        const playlistId = this.dataset.id;
        window.location.href = `/playlist/${playlistId}`;
    });
});


// Function to load playlist details via AJAX
function loadPlaylistDetails(playlistId) {
    fetch(`playlist.php?playlist_id=${playlistId}`)
        .then(response => response.json())
        .then(data => {
            const playlistContent = document.getElementById('playlist-content');
            if (data.error) {
                playlistContent.innerText = data.error;
            } else {
                playlistContent.innerHTML = `
                    <h4>${data.name}</h4>
                    <p>${data.description}</p>
                    <ul>
                        ${data.songs.map(song => `<li>${song}</li>`).join('')}
                    </ul>
                `;
            }
        })
        .catch(error => {
            console.error('Error fetching playlist:', error);
        });
}
