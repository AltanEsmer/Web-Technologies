<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Library</title>
    <link rel="stylesheet" href="{{asset('css/libstyle.css')}}">
</head>
<body>

    <!-- Header with Navigation Bar -->
    <header> 
        <nav class="navbar section-content">
            <a href="" class="nav-logo">
                <h2 class="logo-text">🎸 Music Library</h2>
            </a>
            <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link">Home</a>
            </li>
                <li class="nav-item">
                    <a href="#about" class="nav-link">About</a>
                </li>
                <li class="nav-item">
                    <a href="library.html" class="nav-link">Library</a>
                </li>
                <li class="nav-item">
                    <a href="#contact" class="nav-link">Contact</a>
                </li>
            </ul>
        </nav>
    </header>

    <!-- Sidebar -->
    <aside class="sidebar">
        <input type="text" placeholder="Search..." class="search-bar">
        <div class="playlists">
            <h3>Your Playlists</h3>
            <ul>
            <!-- Link each playlist to its detail page -->
            <li class="playlist-icon" data-id="1">Playlist 1</li>
            <li class="playlist-icon" data-id="2">Playlist 2</li>
            <li class="playlist-icon" data-id="create">+ Add New</li>
        </ul>
        </div>
    </aside>

    <!-- Main Content -->
    <main>
        <section class="album-carousel">
            <h2>Sounds of Phonk</h2>
            <!-- Carousel for albums -->
            <div class="carousel">
                <div class="carousel-item">Hilfiger - Plan 9<br><img src="/images/sample1.jpg" width="150px"></div>
                <div class="carousel-item">HOODMAFFIA - Prophecy Sounds<br><img src="/images/sample2.jpg" width="150px"></div>
                <div class="carousel-item">SPYDER550 - On the run<br><img src="/images/sample3.jpg" width="150px"></div>
                <div class="carousel-item" hidden>HOODMAFFIA - Criminology<br><img src="/images/sample4.jpg" width="150px"></div>
            </div>
            <!-- Carousel controls centered below the carousel -->
            <div class="carousel-controls">
                <button class="carousel-control prev">◀</button>
                <button class="carousel-control next">▶</button>
            </div>
        </section>
                <!-- Playlist Detail Section -->
                <section id="playlist-details" class="playlist-details">
            <h3>Playlist Details</h3>
            <div id="playlist-content">Select a playlist to view its contents</div>
        </section>

        <section class="recommendations">
            <h3>Artists You May Like</h3>
            <div class="artists">
                <div class="artist">
                    <div class="artist-circle"></div>
                    <p class="artist-name">Artist 1</p>
                </div>
                <div class="artist">
                    <div class="artist-circle"></div>
                    <p class="artist-name">Artist 2</p>
                </div>
                <div class="artist">
                    <div class="artist-circle"></div>
                    <p class="artist-name">Artist 3</p>
                </div>
            </div>
        </section>
    </main>
    <script src="{{ asset('js/libraryScript.js') }}"></script>
    
</body>
</html>
