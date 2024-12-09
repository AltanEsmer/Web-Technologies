@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/playlistStyle.css') }}">
@endsection

@section('content')
<div class="playlist-container">
    <div class="playlist-header">
        <h1>Your Playlists</h1>
        <a href="{{ route('playlists.create') }}" class="create-button">
            <i class="fas fa-plus"></i> Create New Playlist
        </a>
    </div>

    @if(session('success'))
        <div class="success-alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="playlists-grid">
        @forelse($playlists as $playlist)
            <div class="playlist-card">
                <div class="playlist-cover">
                    @if($playlist->cover_image)
                        <img src="{{ asset('storage/playlist-covers/' . $playlist->cover_image) }}" alt="{{ $playlist->name }}">
                    @else
                        <div class="default-cover">
                            <i class="fas fa-music"></i>
                        </div>
                    @endif
                </div>
                <div class="playlist-details">
                    <h2>{{ $playlist->name }}</h2>
                    @if($playlist->description)
                        <p class="description">{{ Str::limit($playlist->description, 100) }}</p>
                    @endif
                    <div class="playlist-meta">
                        <span><i class="fas fa-music"></i> {{ $playlist->songs->count() }} songs</span>
                        <a href="{{ route('playlists.show', $playlist) }}" class="view-button">
                            View Playlist
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="fas fa-music"></i>
                <p>No playlists yet. Create your first playlist!</p>
                <a href="{{ route('playlists.create') }}" class="create-button">Create Playlist</a>
            </div>
        @endforelse
    </div>
</div>
@endsection
