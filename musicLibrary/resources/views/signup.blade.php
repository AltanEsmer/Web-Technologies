<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ asset('css/signinStyle.css') }}">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <title>Sign Up</title>
</head>
<body>
  <header class="header">
    <nav class="navbar">
      <a href="{{ route('home') }}">
        <div class="logo-image-wrapper">
          <img src="{{ asset('images/MusicLibraryLogo.png') }}" alt="Logo" class="about-image">
        </div>
      </a>
    </nav>
  </header>

  <div class="background"></div>
  <div class="container">
    <div class="content">
      <h2 class="logo"><i></i>Music Library</h2>

      <div class="text-sci">
        <h2>Welcome!<br><span>To Our Website</span></h2>
        <p>
          You are now on the sign-up page of music library.
          You can switch to sign-in page using the link located at the bottom of this page.
          Join our community to discover and share great music!
        </p>

        <div class="social-icons">
          <a href="#"><i class='bx bxl-linkedin'></i></a>
          <a href="#"><i class='bx bxl-facebook'></i></a>
          <a href="#"><i class='bx bxl-instagram'></i></a>
        </div>
      </div>
    </div>

    <div class="logreg-box">
      <div class="form-box login">
        <form action="{{ route('signup.post') }}" method="POST">
          @csrf
          
          @if ($errors->any())
            <div class="alert alert-danger">
              @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
              @endforeach
            </div>
          @endif

          <h2>Sign Up</h2>

          <div class="input-box">
            <span class="icon"><i class='bx bxs-user'></i></span>
            <input type="text" name="username" id="username" value="{{ old('username') }}" required>
            <label>Username</label>
          </div>

          <div class="input-box">
            <span class="icon"><i class='bx bxs-envelope'></i></span>
            <input type="email" name="mail" id="mail" value="{{ old('mail') }}" required>
            <label>Email</label>
          </div>

          <div class="input-box">
            <span class="icon"><i class='bx bxs-lock-alt'></i></span>
            <input type="password" name="pass" id="pass" required>
            <label>Password</label>
          </div>

          <div class="input-box">
            <span class="icon"><i class='bx bxs-lock-alt'></i></span>
            <input type="password" name="pass_confirmation" id="pass_confirmation" required>
            <label>Confirm Password</label>
          </div>

          <div class="remember-forgot">
            <label><input type="checkbox" required> I agree to the terms & conditions</label>
          </div>

          <button type="submit" class="btn" id="sign-up-btn">Sign Up</button>

          <div class="login-register">
            <p>Already have an account? <a href="{{ route('signin') }}" class="login-link">Sign In</a></p>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
  <script src="{{ asset('js/signInScript.js') }}"></script>
</body>
</html>
