// Carousel Scrolling Functionality
const prevButton = document.querySelector('.prev');
const nextButton = document.querySelector('.next');
const carousel = document.querySelector('.carousel');
const songs = document.querySelectorAll('.carousel-item');
let scrollAmount = 0;
let songsShownIndex = [0, 1, 2];

prevButton.addEventListener('click', () => {
    carousel.scrollTo({
        top: 0,
        left: (scrollAmount -= 150),
        behavior: 'smooth'
    });
    if (scrollAmount < 0) scrollAmount = 0;
});

nextButton.addEventListener('click', () => {
    songsShownIndex.forEach((value, index, array)=>{
        array[index] = value + 1;
    })
    console.log(songsShownIndex);
    songs[songsShownIndex[0]-1].hidden = true ;
    songs[songsShownIndex[2]].hidden = false;
    console.log(songs);
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
