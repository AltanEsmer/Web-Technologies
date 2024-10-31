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
  <header>
    <nav class="navbar section-content">
      <a href="" class="nav-logo">
        <h2 class="logo-text">🎸 Music Library</h2>
      </a>
      <ul class="nav-menu">
        <button id="menu-close-button" class="fas fa-times"></button>
        <li class="nav-item"><a href="#" class="nav-link">Home</a></li>
        <li class="nav-item"><a href="#about" class="nav-link">About</a></li>
        <li class="nav-item"><a href="#library" class="nav-link">Library</a></li>
        <li class="nav-item"><a href="#artists" class="nav-link">Artists</a></li>
        <li class="nav-item"><a href="#contact" class="nav-link">Contact</a></li>
      </ul>
      <button id="menu-open-button" class="fas fa-bars"></button>
    </nav>
  </header>

  <main>
    <!-- Parent Section (Main part of website) -->
    <section class="parent-section">
      <div class="section-content">
        <div class="parent-details">
          <h2 class="title">Best Music Library</h2>
          <h3 class="subtitle">Find the best music that fits you!</h3>
          <p class="description">Deliming bama</p>
          <div class="buttons">
            <a href="#" class="button choose-now">Choose Music</a>
            <a href="#" class="button contact-us">Contact Us</a>
          </div>
        </div>
        <div class="parent-image-wrapper">
          <img src="{{ asset('images/deneme.png') }}" alt="parent" class="parent-image">
        </div>
      </div>
    </section>

    <!-- About Section -->
    <section class="about-section" id="about">
      <div class="section-content">
        <div class="about-image-wrapper">
          <img src="{{ asset('images/music_about_us.jpeg') }}" alt="try" class="about-image">
        </div>
        <div class="about-details">
          <h2 class="section-title">About Us</h2>
          <p class="text">Music Library boasts a rich history. It was founded back in 1899...</p>
          <div class="social-link-list">
            <a href="#" class="social-link"><i class="fa-brands fa-linkedin"></i></a>
            <a href="#" class="social-link"><i class="fa-brands fa-facebook"></i></a>
            <a href="#" class="social-link"><i class="fa-brands fa-instagram"></i></a>
          </div>
        </div>
      </div>
    </section>

    <!-- Library Section -->
    <section class="library-section" id="library">
      <h2 class="section-title">Our Library</h2>
      <div class="section-content">
        <ul class="library-list">
          @for ($i = 0; $i < 6; $i++)
            <li class="library-item">
              <img src="{{ asset('images/music_about_us.jpeg') }}" alt="try" class="library-image">
              <h3 class="name">Music Royale</h3>
              <p class="text">Wide range of rhythms are included inside the song</p>
            </li>
          @endfor
        </ul>
      </div>
    </section>

    <!-- Artists Section -->
    <section class="artists-section" id="artists">
      <h2 class="section-title">Artists</h2>
      <div class="section-content">
        <div class="slider-container swiper">
          <div class="slider-wrapper">
            <ul class="artists-list swiper-wrapper">
              @for ($i = 0; $i < 6; $i++)
                <li class="artists swiper-slide">
                  <img src="{{ asset('images/mona-lisa.jpg') }}" alt="artist" class="artist-image">
                  <h3 class="name">Mona Lisa</h3>
                  <i class="feedback">Classic and old painter</i>
                </li>
              @endfor
            </ul>
            <div class="swiper-pagination"></div>
            <div class="swiper-slide-button swiper-button-prev"></div>
            <div class="swiper-slide-button swiper-button-next"></div>
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