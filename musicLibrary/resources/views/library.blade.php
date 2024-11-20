@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/libstyle.css') }}">
@endsection

@section('content')
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="playlists">
            <h3>Your Playlists</h3>
            <ul>
                @foreach($playlists as $playlist)
                    <li class="playlist-icon" data-id="{{ $playlist->id }}">
                        <a href="{{ route('playlists.show', $playlist) }}">{{ $playlist->name }}</a>
                    </li>
                @endforeach
                <li class="playlist-icon" data-id="create">
                    <a href="{{ route('playlists.create') }}">+ Add New</a>
                </li>
            </ul>
        </div>
    </aside>

    <!-- Main Content -->
    <main>
    <section class="album-carousel">
    <div class="playlist-view">
        <div class="playlist-title">
            <h2>Sounds of Hungarian Rap</h2>
            <p>or whatever</p>
        </div>
        <div class="playlist-carousel">
            <button class="carousel-btn left-btn">&lt;</button>
            <div class="carousel">
                <!--<div class="carousel-item"><p>6363 - Arany</p><img src="/images/song_pics/dummy1.jpg"></div>-->
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
@endsection