<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Library</title>
    <link rel="stylesheet" href="{{asset('css/libstyle.css')}}">
</head>
<body>

      <!-- Header & navbar -->
 <header class="header">
    <nav class="navbar">
    <div class="about-image-wrapper">
          <img src="{{ asset('images/MusicLibraryLogo.png') }}" alt="try" class="about-image">
        </div> 
      <a href="{{ route('home') }}">Home</a>
      
      <a href="{{ route('library') }}">Library</a>
      
      <a href="{{ route('signin') }}">Sign in</a>
    </nav>
    </div>
    <form action="#" class="search-bar">
      <input type="text" name="search" id="search" placeholder="Search...">
      <button type="submit"><i class='bx bx-search'></i></button>
    </form>
  </header>

    


    <!-- Sidebar -->
    <aside class="sidebar">
        
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
    <div class="playlist-view">
        <div class="playlist-title">
            <h2>Sounds of Rock</h2>
            <p>or whatever</p>
        </div>
        <div class="playlist-carousel">
            <button class="carousel-btn left-btn">&lt;</button>
            <div class="carousel">
                <div class="carousel-item">Emptiness Machine</div>
                <div class="carousel-item">APT.</div>
                <div class="carousel-item">Gossip feat. Tom Morello</div>
                <div class="carousel-item">Imperial March</div>
                <div class="carousel-item">Stick Season</div>
                <div class="carousel-item">vampire</div>
            </div>
            <button class="carousel-btn right-btn">&gt;</button>
        </div>
        <div class="show-more">
            <a href="#">Show more</a>
        </div>
    </div>
    </div>

</section>


                <!-- Playlist Detail Section 
                <section id="playlist-details" class="playlist-details">
            <h3>Playlist Details</h3>
            <div id="playlist-content">Select a playlist to view its contents</div>
        </section> -->

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
