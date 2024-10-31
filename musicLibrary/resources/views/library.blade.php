<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Library</title>
    <link rel="stylesheet" href="libstyle.css">
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <input type="text" placeholder="Search..." class="search-bar">
        <div class="playlists">
            <h3>Your Playlists</h3>
            <ul>
                <!-- Icons representing playlists -->
                <li class="playlist-icon">Playlist 1</li>
                <li class="playlist-icon">Playlist 2</li>
                <li class="playlist-icon">+ Add New</li>
            </ul>
        </div>
    </aside>

    <!-- Main Content -->
    <main>
        <header>
            <nav>
                <a href="#">Home</a>
                <a href="#">Library</a>
                <a href="#">About</a>
                <a href="#">Contact</a>
            </nav>
        </header>
        
        <section class="recommendations">
            <h2>Artists You May Like</h2>
            <!-- Artist circles -->
            <div class="artists">
                <div class="artist-circle">Artist 1</div>
                <div class="artist-circle">Artist 2</div>
                <div class="artist-circle">Artist 3</div>
            </div>
        </section>

        <section class="album-carousel">
            <h2>Sounds of Rock</h2>
            <!-- Carousel for albums -->
            <div class="carousel">
                <div class="carousel-item">Album 1</div>
                <div class="carousel-item">Album 2</div>
                <div class="carousel-item">Album 3</div>
                <!-- Carousel controls -->
                <button class="carousel-control prev">◀</button>
                <button class="carousel-control next">▶</button>
            </div>
        </section>
    </main>

</body>
</html>
