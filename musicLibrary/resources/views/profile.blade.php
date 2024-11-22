<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profile - Music Library</title>
  <!-- Fonts for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/HomeStyle.css') }}">
  <!-- Linking Swiper CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
</head>
<body>
  <!-- Header & navbar -->
  <header class="header">
    <nav class="navbar">
      <div class="logo-image-wrapper">
        <img src="{{ asset('images/MusicLibraryLogo.png') }}" alt="Logo" class="about-image">
      </div> 
      
      <form method="POST" action="{{ route('logout') }}" style="display: inline;">
        @csrf
        <button type="submit" style="background: none; border: none; color: white; cursor: pointer;">Logout</button>
      </form>
    </nav>
  </header>

  <main>
    <div class="container">
      <h2 class="title">Edit Your Profile</h2>

      <!-- Display success message -->
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      <!-- Profile update form -->
      <form action="{{ route('profile.update') }}" method="POST">
        @csrf

        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input 
            type="text" 
            name="username" 
            id="username" 
            class="form-control @error('username') is-invalid @enderror"
            value="{{ old('username', $user->username) }}" 
            required
          >
          @error('username')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- Add more fields here if needed -->

        <button type="submit" class="btn btn-primary">Save Changes</button>
      </form>
    </div>
  </main>

  <!-- Linking Swiper Script -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="{{ asset('js/HomeScript.js') }}"></script>
</body>
</html>
