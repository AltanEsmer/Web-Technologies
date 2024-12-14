<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profile - Music Library</title>
  <!-- Fonts for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/profileStyle.css') }}">
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
      
      <a href="{{ url()->previous() }}" class="nav-link">
        <i class="fas fa-arrow-left"></i> Back
      </a>
      
      <form method="POST" action="{{ route('logout') }}" style="display: inline;">
        @csrf
        <button type="submit" class="nav-link">Logout</button>
      </form>
    </nav>
  </header>

  <main>
    <div class="container" style="display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 80vh;">
      <div class="profile-edit-wrapper">
        <h2 class="title">Edit Your Profile</h2>

        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
          @csrf
          
          <div class="form-group">
            <label for="username" class="form-label">Username:</label>
            <div class="input-wrapper">
              <input type="text" 
                name="username" 
                id="username" 
                class="form-control @error('username') is-invalid @enderror"
                value="{{ old('username', $user->username) }}"
                {{-- comment: this part needs to be fixed --}}
                placeholder="username {{ $user->username }}" 
                required
              >
              @error('username')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="form-group">
            <label for="profile_picture" class="form-label">Profile Picture:</label>
            <div class="input-wrapper">
              <input type="file" name="profile_picture" id="profile_picture" 
                class="form-control @error('profile_picture') is-invalid @enderror"
                accept="image/*"
              >
              @error('profile_picture')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="form-group">
            <label for="password" class="form-label">New Password:</label>
            <div class="input-wrapper">
              <input type="password" name="password" id="password" 
                class="form-control @error('password') is-invalid @enderror"
              >
              @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="form-group">
            <label for="password_confirmation" class="form-label">Confirm Password:</label>
            <div class="input-wrapper">
              <input type="password" name="password_confirmation" id="password_confirmation" 
                class="form-control"
              >
            </div>
          </div>

          <div class="form-group">
            <h3>Two-Factor Authentication</h3>
            @if(auth()->user()->two_factor_confirmed_at)
                <p>2FA is currently enabled</p>
                <form action="{{ route('2fa.disable') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">Disable 2FA</button>
                </form>
            @else
                <p>2FA is currently disabled</p>
                <a href="{{ route('2fa.setup') }}" class="btn btn-primary">Enable 2FA</a>
            @endif
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-primary">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </main>

  <!-- Linking Swiper Script -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="{{ asset('js/HomeScript.js') }}"></script>
</body>
</html>
