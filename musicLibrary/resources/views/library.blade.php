@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/libstyle.css') }}">
@endsection

@section('content')
<div class="library-container">
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
    <main class="main-content">
        <!-- Your Personal Playlists Section -->
        <section class="playlist-section">
            <h2>Your Playlists</h2>
            <div class="playlist-grid">
                @foreach($playlists as $playlist)
                    <div class="playlist-card">
                        <div class="playlist-image">
                            @if($playlist->cover_image)
                                <img src="{{ asset('storage/' . $playlist->cover_image) }}" alt="{{ $playlist->name }}">
                            @else
                                <div class="default-cover">
                                    <i class="fas fa-music"></i>
                                </div>
                            @endif
                        </div>
                        <div class="playlist-info">
                            <h3>{{ $playlist->name }}</h3>
                            <p>{{ $playlist->songs->count() }} songs</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Public Playlists Section -->
        <section class="playlist-section">
            <h2>Public Playlists</h2>
            <div class="playlist-grid">
                @foreach($publicPlaylists as $playlist)
                    <div class="playlist-card">
                        <div class="playlist-image">
                            @if($playlist->cover_image)
                                <img src="{{ asset('storage/' . $playlist->cover_image) }}" alt="{{ $playlist->name }}">
                            @else
                                <div class="default-cover">
                                    <i class="fas fa-music"></i>
                                </div>
                            @endif
                        </div>
                        <div class="playlist-info">
                            <h3>{{ $playlist->name }}</h3>
                            <p>By {{ $playlist->user->name }}</p>
                            <p>{{ $playlist->songs->count() }} songs</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </main>
</div>
@endsection