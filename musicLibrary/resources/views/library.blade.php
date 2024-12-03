@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/libstyle.css') }}">
    <script src="{{ asset('js/profile-helper.js') }}"></script>
    <script src="{{ asset('js/libraryScript.js') }}" defer></script>
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
        <!-- User Profile Section -->
        @auth
        <div class="user-profile">
            <img class="user-pic" onclick="toggleMenu()" 
                 src="{{ Auth::user()->profile_image ?? asset('images/mona-lisa.jpg') }}" 
                 alt="user">
            <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu">
                    <div class="user-info">
                        <img src="{{ Auth::user()->profile_image ?? asset('images/mona-lisa.jpg') }}" alt="user">
                        <h3>{{ Auth::user()->name }}</h3>
                    </div>
                    <hr>
                    <a href="{{ route('profile.edit') }}" class="sub-menu-link">
                        <img src="{{ asset('images/profile-icon.png') }}" alt="profile">
                        <p>Edit Profile</p>
                        <span>></span>
                    </a>
                    <a href="{{ route('home') }}" class="sub-menu-link">
                        <img src="{{ asset('images/home-icon.png') }}" alt="home">
                        <p>Home</p>
                        <span>></span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" 
                           class="sub-menu-link">
                            <img src="{{ asset('images/mona-lisa.jpg') }}" alt="logout">
                            <p>Logout</p>
                            <span>></span>
                        </a>
                    </form>
                </div>
            </div>
        </div>
        @endauth

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
@endsection