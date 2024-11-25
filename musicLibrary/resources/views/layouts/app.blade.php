<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Library</title>
    <link rel="stylesheet" href="{{ asset('css/HomeStyle.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    @yield('head')
</head>
<body class="bg-gray-100">
    <header class="header">
        <nav class="navbar flex justify-between items-center w-full">
            <div class="flex items-center space-x-4 ml-0">
                <div class="logo-image-wrapper pl-0">
                    <img src="{{ asset('images/MusicLibraryLogo.png') }}" alt="Logo" class="about-image">
                </div> 
                @auth
                    <a href="{{ route('library') }}" class="pl-0">Library</a>
                @endauth
            </div>
            
            <div class="flex items-center space-x-6">
                <form action="#" class="search-bar">
                    <input type="text" name="search" id="search" placeholder="Search...">
                    <button type="submit"><i class='bx bx-search'></i></button>
                </form>
                
                @auth
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
                    </form>
                @else
                    <a href="{{ route('signin') }}">Sign in</a>
                @endauth
            </div>
        </nav>
    </header>

    <style>
    .navbar {
        padding-left: 0;
    }
    .logo-image-wrapper {
        margin-left: 0;
    }
    </style>

    @yield('content')
</body>
</html>