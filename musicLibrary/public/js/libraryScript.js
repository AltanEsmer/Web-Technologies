// Carousel Scrolling Functionality
const prevButton = document.querySelector('.left-btn');
const nextButton = document.querySelector('.right-btn');
const carousel = document.querySelector('.carousel');
const songs = document.querySelectorAll('.carousel-item');

// Show more - Functionality
const explodeBtn = document.querySelector(".show-more");
const playlistView = document.querySelector(".playlist-view");

let scrollAmount = 0;
let songsShownIndex = [0, 1, 2];

// A sample array of songs to test functions
const songsList = [
    {
        artist: "6363",
        name: "Arany",
        pic: "/images/song_pics/dummy1.jpg",
        album: "METAMATIKA"
    },
    {
        artist: "6363",
        name: "Valahol",
        pic: "/images/song_pics/dummy2.jpg",
        album: "ELVESZETT!!4!"
    },
    {
        artist: "6363",
        name: "Osszevissza Beszelek",
        pic: "/images/song_pics/dummy3.jpg",
        album: "KORD"
    },
    {
        artist: "6363",
        name: "Repeta",
        pic: "/images/song_pics/dummy4.jpg",
        album: "M3T4M4T1K4"
    },
    {
        artist: "6363",
        name: "Trip",
        pic: "/images/song_pics/dummy5.jpg",
        album: "SISTAHOOD"   
    },
    {
        artist: "Pogany Indulo",
        name: "Mamor",
        pic: "/images/song_pics/dummy6.jpg",
        album: "Vagy Mindent Vagy Semmit"
    },
    {
        artist: "Pogany Indulo",
        name: "Fiendulo",
        pic: "/images/song_pics/dummy7.jpg",
        album: "Megall Az Ido"
    },
    {
        artist: "Pogany Indulo",
        name: "Idegenek",
        pic: "/images/song_pics/dummy8.jpg",
        album: "Igaziakert"
    },
    {
        artist: "Sisi",
        name: "SHEN GONG WU",
        pic: "/images/song_pics/dummy9.jpg",
        album: "SISTAHOOD"
    },
    {
        artist: "Bongor",
        name: "Paralel",
        pic: "/images/song_pics/dummy10.jpg",
        album: "Korok"
    },
    {
        artist: "Bongor",
        name: "Testi Mesek",
        pic: "/images/song_pics/dummy11.jpg",
        album: "Testi Mesek"
    },
]

/*prevButton.addEventListener('click', () => {
    carousel.scrollTo({
        top: 0,
        left: (scrollAmount -= 150),
        behavior: 'smooth'
    });
    if (scrollAmount < 0) scrollAmount = 0;
});*/

/*nextButton.addEventListener('click', () => {
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
});*/

// Playlist Sidebar Loading Functionality
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

// Function to render the selected 3 songs of the playlist on the page
const renderSongs = () => {
    for(let i=0; i<3; i++) {
        
        let songbox = document.createElement("div")
        songbox.setAttribute("class", "carousel-item");
        songbox.innerHTML = `
        <p>${songsList[songsShownIndex[i]].name}</p><img src="${songsList[songsShownIndex[i]].pic}">
        `;
        carousel.appendChild(songbox);
    }
    return;    
}
const songScrollNext = () => {
    for(let i = 0; i<3;i++) {
        if(songsShownIndex[i]===songsList.length-1) {
            songsShownIndex[i] = 0;
        } else {
            songsShownIndex[i]++;
        }
    }
        carousel.innerHTML = "";
        renderSongs();
        return;
}

// Functions for scrolling throught the songs in the playlist in preview mode
const songScrollPrev = () => {

        for(let i =0; i<3; i++) {
            if(songsShownIndex[i]===0) {
                songsShownIndex[i] = songsList.length-1;
            } else {
                songsShownIndex[i] = songsShownIndex[i] - 1;
            }
        }
        carousel.innerHTML = "";
        renderSongs();
        return;    
}
 
// Renders songs when page loaded
renderSongs();

//show-more function for playlist recommendations
const showMore = () => {
    prevButton.setAttribute("hidden", "true");
    nextButton.setAttribute("hidden", "true");
}

nextButton.addEventListener("click", songScrollNext);
prevButton.addEventListener("click", songScrollPrev);
explodeBtn.addEventListener("click", function(event) {
    event.preventDefault();
    showMore();
})