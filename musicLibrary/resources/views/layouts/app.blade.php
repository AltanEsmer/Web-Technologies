<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Library</title>
    <link rel="stylesheet" href="{{ asset('css/HomeStyle.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/profile-helper.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <style>
        .yellow-progress-bar,
        #nprogress,
        .turbolinks-progress-bar {
            display: none !important;
        }
        
        .yellow-progress-bar,
        #nprogress,
        .turbolinks-progress-bar {
            display: none !important;
        }

        /* Profile Picture Hover */
        .user-pic {
            transition: transform 0.5s ease-in-out;
        }
        .user-pic:hover {
            transform: scale(1.2);
        }

        /* Playlist Card Hover */
        .playlist-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .playlist-card:hover {
            transform: translateY(-10px) scale(1.05);
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
        }
    </style>
    
    @yield('head')
</head>
<body class="bg-gray-200">
    <header class="header">
        <nav class="navbar flex justify-between items-center w-full">
            <div class="flex items-center space-x-4">
            <div class="logo-image-wrapper">
        <a href="{{ route('home') }}">
          <img src="{{ asset('images/MusicLibraryLogo.png') }}" alt="Logo" class="about-image">
        </a>
      </div> 
            <a href="{{ route('home') }}">Home</a>
                @auth
                    <a href="{{ route('library') }}" class="pl-0">Library</a>
                @endauth
            </div>
            
            <div class="flex items-center space-x-6 ml-auto">
                <form action="#" class="search-bar">
                    <input type="text" name="search" id="search" placeholder="Search...">
                    <button type="submit"><i class='bx bx-search'></i></button>
                </form>

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
                    <hr>
                    <a href="{{ route('profile.edit') }}" class="sub-menu-link"
                    data-user-type="{{ Auth::check() ? Auth::user()->user_type : 'normal' }}"
                    data-edit-url="{{ route('profile.edit') }}">
                        <img src="{{ asset('images/profile-icon.png') }}" alt="profile">
                        <p>Edit Profile</p>
                        <span>></span>
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" 
                           class="sub-menu-link2">
                            <img src="{{ asset('images/logout2.jpg') }}" alt="logout">
                            <p>Logout</p>
                            <span>></span>
                        </a>
                    </form>
                </div>
                @endauth
            </div>
        </nav>
    </header>
    @yield('content')
    @stack('scripts')
</body>
</html>