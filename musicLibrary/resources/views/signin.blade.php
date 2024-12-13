<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ asset('css/signinStyle.css') }}">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <title>Main Page</title>
</head>
<body>
<header class="header" style="display: flex; justify-content: space-between; align-items: center; padding: 20px;">
    <nav class="navbar" style="display: flex; align-items: center; gap: 15px;">
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
          You are now situating in log-in page of music library.
          You can switch to sign-up page using link that is located bottom of the log-in page.
          It's just a visual representation of login and signup page.
        </p>

        <div class="social-icons">
          <a href="#"><i class='bx bxl-linkedin' ></i></a>
          <a href="#"><i class='bx bxl-facebook' ></i></a>
          <a href="#"><i class='bx bxl-instagram' ></i></a>
        </div>
      </div>
    </div>

    <div class="logreg-box">
      <div class="form-box login">
        <form action="{{ route('signin.submit') }}" method="post">
        @csrf
        @if ($errors->has('msg'))
            <div class="alert alert-danger">
                <strong>{{ $errors->first('msg') }}</strong>
            </div>
        @endif

        <h2>Sign In</h2>

          <div class="input-box">
            <span class="icon"><i class='bx bxs-envelope' ></i></span>
            <input type="email" name="mail" id="mail" required>
            <label>Email</label>
          </div>

          <div class="input-box">
            <span class="icon"><i class='bx bxs-lock-alt' ></i></span>
            <input type="password" name="pass" id="pass" required>
            <label>Password</label>
          </div>

          <div class="remember-forgot">
            <label><input type="checkbox" name="checker" id="checker"> Remember me</label>
            <a href="#">Forgot password?</a>
          </div>

          <button type="submit" class="btn" id="sign-in-btn" onclick="lsRememberMe()">Sign In</button>

          <div class="login-register">
            <p>
              Don't have an account?
              <a href="#" class="register-link">Sign Up</a>
            </p>
            <p>
              <a href="#" class="guest-login">Login as guest</a>
            </p>  
          </div>
        </form>
      </div>

      <div class="form-box register">
        <form action="{{ route('signup.submit') }}" method="post">
        @csrf 
        <h2>Sign Up</h2>

          <div class="input-box">
            <span class="icon"><i class='bx bxs-user' ></i></span>
            <input type="text" name="username" id="username" required>
            <label>Name</label>
          </div>

          <div class="input-box">
            <span class="icon"><i class='bx bxs-envelope' ></i></span>
            <input type="email" name="mail" id="mail" required>
            <label>Email</label>
          </div>

          <div class="input-box">
            <span class="icon"><i class='bx bxs-lock-alt' ></i></span>
            <input type="password" name="pass" id="pass" required>
            <label>Password</label>
          </div>

          <div class="input-box">
            <span class="icon"><i class='bx bxs-lock-alt' ></i></span>
            <input type="password" name="pass_confirmation" id="pass_confirmation" required>
            <label>Enter Password Again</label>
          </div>

          <div class="remember-forgot">
            <label><input type="checkbox" name="checker" id="checker"> I agree to the terms & conditions</label>
          </div>

          <button type="submit" class="btn">Sign Up</button>

          <div class="login-register">
            <p>
              Already have an account?
              <a href="#" class="login-link">Sign In</a>
            </p>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="{{ asset('js/signInScript.js') }}"></script>

</body>
</html>