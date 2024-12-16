@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/libstyle.css') }}">
    <script src="{{ asset('js/profile-helper.js') }}"></script>
@endsection

@section('content')
<div class="library-container">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="playlists">
            <h3>Your Playlists</h3>
            <ul>
                @if(Auth::check() && Auth::user()->user_type !== 'guest')
                    @foreach($playlists as $playlist)
                        <li class="playlist-icon" data-id="{{ $playlist->id }}">
                            <a href="{{ route('playlists.show', $playlist) }}">{{ $playlist->name }}</a>
                        </li>
                    @endforeach
                    <li class="playlist-icon" data-id="create">
                        <a href="{{ route('playlists.create') }}">+ Add New</a>
                    </li>
                @else
                    <li class="playlist-icon no-access">
                        <p>You cannot create playlists as a guest user.</p>
                    </li>
                @endif
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
                    <a href="{{ route('playlists.show', $playlist) }}" class="playlist-link">
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
                    </a>
                @endforeach
                <!-- Add New Playlist Button -->
            @if(Auth::check() && Auth::user()->user_type !== 'guest')
                <a href="{{ route('playlists.create') }}" class="playlist-link">
                    <div class="playlist-card">
                        <div class="playlist-image">
                            <div class="default-cover">
                                <i class="fas fa-plus"></i> 
                            </div>
                        </div>
                        <div class="playlist-info">
                            <h3>Add a new playlist</h3>
                            <p>Create a new playlist</p>
                        </div>
                    </div>
                </a>
            @else
                        <div class="playlist-info">
                            <h3>Login to create playlists</h3>
                        </div>
            @endif
            </div>
        </section>

        <!-- Public Playlists Section -->
        <section class="playlist-section">
            <h2>Public Playlists</h2>
            <div class="playlist-grid">
                @foreach($publicPlaylists as $playlist)
                    <a href="{{ route('playlists.show', $playlist) }}" class="playlist-link">
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
                    </a>
                @endforeach
            </div>
        </section>
    </main>
</div>

<script src="{{ asset('js/libraryScript.js') }}" defer></script>
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
@endsection