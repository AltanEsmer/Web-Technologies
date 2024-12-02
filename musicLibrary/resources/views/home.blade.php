<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome To Music Library</title>
  <!-- Fonts for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/HomeStyle.css') }}">
  <!-- Linking Swiper CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
</head>
<body>

  <!-- Header & navbar -->
  <header class="header" style="display: flex; justify-content: space-between; align-items: center; padding: 20px;">
    <nav class="navbar" style="display: flex; align-items: center; gap: 15px;">
      <div class="logo-image-wrapper">
        <img src="{{ asset('images/MusicLibraryLogo.png') }}" alt="Logo" class="about-image">
      </div> 
      <a href="{{ route('home') }}">Home</a>
      <a href="#about">About</a>
      @auth
        <a href="{{ route('library') }}">Library</a>
      @endauth
      <a href="#contact">Contact</a>
    </nav>
    <div style="display: flex; align-items: center; gap: 15px;">
      <form action="#" class="search-bar">
        <input type="text" name="search" id="search" placeholder="Search...">
        <button type="submit"><i class='bx bx-search'></i></button>
      </form>
      @auth
        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
          @csrf
          <button type="submit" style="background-color: #1DB954; color: white; padding: 8px 16px; border: none; border-radius: 20px; cursor: pointer; transition: background-color 0.3s ease;">Logout</button>
        </form>
      @endauth
      @guest
        <div class="navbar" style="margin: 0; padding: 0;">
          <a href="{{ route('signin') }}" style="margin-right: 15px;">Sign in</a>
          <a href="{{ route('signin', ['mode' => 'signup']) }}" style="background-color: #1DB954; color: white; padding: 8px 16px; border-radius: 20px; text-decoration: none; transition: background-color 0.3s ease;">Sign up</a>
        </div>
      @endguest
    </div>
  </header>

  <main>
    <!-- Parent Section (Main part of website) -->
    <section class="parent-section">
      <div class="section-content">
        <div class="parent-details">
          <h2 class="title">Best Music Library</h2>
          <h3 class="subtitle">Find the best music that fits you!</h3>
          <p class="description">On this page you are going to receive personal recommendations for your playlists</p>
          <div class="buttons">
            @auth
              <a href="{{ route('library') }}" class="button choose-now">Go to the Library</a>
            @else
              <a href="{{ route('signin') }}" class="button choose-now">Sign In to Start</a>
            @endauth
            <a href="#contact" class="button contact-us">Contact Us</a>
          </div>
        </div>
        <div class="parent-image-wrapper">
          <img src="{{ asset('images/rock.png') }}" alt="parent" class="parent-image">
        </div>
      </div>
    </section>

    <!-- About Section -->
    <section class="about-section" id="about">
      <div class="section-content">
        <div class="about-image-wrapper">
          <img src="{{ asset('images/Music-removebg-preview.png') }}" alt="about" class="about-image">
        </div>
        <div class="about-details">
          <h2 class="section-title">About Us</h2>
          <p class="text">Music Library was created as part of the project for Web Technology, Autumn semester 2024</p>
          <div class="social-link-list">
            <a href="#" class="social-link"><i class="fa-brands fa-linkedin"></i></a>
            <a href="#" class="social-link"><i class="fa-brands fa-facebook"></i></a>
            <a href="#" class="social-link"><i class="fa-brands fa-instagram"></i></a>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section" id="contact">
      <h2 class="section-title">Contact Us</h2>
      <div class="section-content">
        <ul class="contact-info-list">
          <li class="contact-info"><i class="fa-solid fa-location-crosshairs"></i><p>Alsion Sonderborg SDU Campus Software Rooms</p></li>
          <li class="contact-info"><i class="fa-regular fa-envelope"></i><p>musicLibrary@gmail.com</p></li>
          <li class="contact-info"><i class="fa-solid fa-phone"></i><p>(+45) 123456789</p></li>
          <li class="contact-info"><i class="fa-regular fa-clock"></i><p>Monday - Friday: 8:00 AM - 2:00 PM</p></li>
          <li class="contact-info"><i class="fa-regular fa-clock"></i><p>Saturday - Sunday: Closed</p></li>
          <li class="contact-info"><i class="fa-solid fa-globe"></i><p>www.dolmaweb.com</p></li>
        </ul>
        <form action="#" class="contact-form">
          <input type="text" placeholder="Your name" class="form-input" required>
          <input type="email" placeholder="Your email" class="form-input" required>
          <textarea placeholder="Your message" name="message" id="message" class="form-input"></textarea>
          <button class="submit-button">Submit</button>
        </form>
      </div>
    </section>

    <!-- Footer Section -->
    <footer class="footer-section">
      <div class="section-content">
        <p class="copyright-text">2024 Music Library</p>
        <div class="social-link-list">
          <a href="#" class="social-link"><i class="fa-brands fa-linkedin"></i></a>
          <a href="#" class="social-link"><i class="fa-brands fa-facebook"></i></a>
          <a href="#" class="social-link"><i class="fa-brands fa-instagram"></i></a>
        </div>
        <p class="policy-text">
          <span class="separator">•</span>
          <a href="#" class="policy-link">Privacy policy</a>
          <span class="separator">•</span>
        </p>
      </div>
    </footer>
  </main>

  <!-- Linking Swiper Script -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="{{ asset('js/HomeScript.js') }}"></script>
</body>
</html>