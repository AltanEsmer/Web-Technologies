@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/libstyle.css') }}">
    <link rel="stylesheet" href="{{ asset('css/playlistShow.css') }}">
@endsection

@section('content')
<div class="library-container">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="playlists">
            <h3>Your Playlists</h3>
            <ul>
                @foreach($playlists as $sidebarPlaylist)
                    <li class="playlist-icon" data-id="{{ $sidebarPlaylist->id }}">
                        <a href="{{ route('playlists.show', $sidebarPlaylist) }}" 
                           class="{{ $sidebarPlaylist->id === $playlist->id ? 'active' : '' }}">
                            {{ $sidebarPlaylist->name }}
                        </a>
                    </li>
                @endforeach
                <li class="playlist-icon" data-id="create">
                    <a href="{{ route('playlists.create') }}">+ Add New</a>
                </li>
            </ul>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="playlist-container">
            <div class="playlist-header">
                <div class="header-content">
                    <div class="playlist-cover">
                        @if($playlist->cover_image)
                            <img src="{{ asset('storage/' . $playlist->cover_image) }}" alt="{{ $playlist->name }}">
                        @else
                            <div class="default-cover">
                                <i class="fas fa-music"></i>
                            </div>
                        @endif
                    </div>
                    
                    <div class="playlist-info">
                        <h1>{{ $playlist->name }}</h1>
                        @if($playlist->description)
                            <p class="description">{{ $playlist->description }}</p>
                        @endif
                        <div class="playlist-stats">
                            <span><i class="fas fa-music"></i> {{ $playlist->songs->count() }} songs</span>
                            <span><i class="far fa-clock"></i> {{ number_format($playlist->songs->sum('duration_ms') / 60000, 1) }} minutes</span>
                        </div>
                    </div>
                </div>
                
                <div class="action-buttons">
                    <a href="{{ route('playlists.edit', $playlist) }}" class="edit-button">
                        <i class="fas fa-edit"></i> Edit Playlist
                    </a>
                    <a href="{{ route('playlists.searchSpotify', $playlist) }}" class="add-songs-button">
                        <i class="fas fa-plus"></i> Add Songs
                    </a>
                </div>
            </div>

            <div class="songs-container">
                @if($playlist->songs->count() > 0)
                    <div class="songs-header">
                        <div class="song-number">#</div>
                        <div class="song-info">Title</div>
                        <div class="song-album">Album</div>
                        <div class="song-duration"><i class="far fa-clock"></i></div>
                    </div>
                    
                    <div class="songs-list">
                        @foreach($playlist->songs as $index => $song)
                            <div class="song-item">
                                <div class="song-number">{{ $index + 1 }}</div>
                                <div class="song-info">
                                    <div class="song-image">
                                        @if($song->cover_art)
                                            <img src="{{ $song->cover_art }}" alt="Album artwork">
                                        @else
                                            <div class="default-song-cover">
                                                <i class="fas fa-music"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="song-details">
                                        <h3>{{ $song->title }}</h3>
                                        <p>{{ $song->artist }}</p>
                                    </div>
                                </div>
                                <div class="song-album">{{ $song->album }}</div>
                                <div class="song-duration">{{ gmdate("i:s", $song->duration_ms/1000) }}</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-playlist">
                        <i class="fas fa-music"></i>
                        <p>This playlist is empty</p>
                        <a href="{{ route('playlists.searchSpotify', $playlist) }}" class="add-songs-button">
                            Add Some Songs
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </main>
</div>
@endsection
