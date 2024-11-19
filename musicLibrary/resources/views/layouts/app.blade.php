<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Library</title>
    <link rel="stylesheet" href="{{ asset('css/HomeStyle.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <nav class="navbar">
        <div class="logo-image-wrapper">
            <img src="{{ asset('images/MusicLibraryLogo.png') }}" alt="Logo" class="about-image">
        </div> 
        <a href="{{ route('home') }}">Home</a>
        <a href="#">About</a>
        <a href="{{ route('library') }}">Library</a>
        <a href="#">Contact</a>
        <a href="{{ route('signin') }}">Sign in</a>
    </nav>

    <main>
        @yield('content')
    </main>
</body>
</html>