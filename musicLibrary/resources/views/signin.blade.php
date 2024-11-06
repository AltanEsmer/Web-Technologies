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
  <header class="header">
    <nav class="navbar">
      <a href="{{ route('home') }}">Home</a>
      <a href="#">About</a>
      <a href="{{ route('library') }}">Library</a>
      <a href="#">Contact</a>
    </nav>

    <form action="#" class="search-bar">
      <input type="text" name="search" id="search" placeholder="Search...">
      <button type="submit"><i class='bx bx-search'></i></button>
    </form>
  </header>

  <div class="background"></div>
  <div class="container">
    <div class="content">
      <h2 class="logo"><i class='bx bxs-hot' ></i>Music Library</h2>

      <div class="text-sci">
        <h2>Welcome!<br><span>To Our Website</span></h2>
        <p>
          This is the login page designed for Music Library.
          The database and functional javascript code is not impelemented yet.
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