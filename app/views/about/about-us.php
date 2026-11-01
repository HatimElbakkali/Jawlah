<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once __DIR__ . '/../components/head.php' ?>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us - Jawlah</title>
  <link rel="shortcut icon" href="/public/assets/Logo/favicon.ico">
  <link rel="icon" type="image/png" sizes="16x16" href="/public/assets/Logo/favicon-16.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/public/assets/Logo/favicon-32.png">
  <link rel="icon" type="image/png" sizes="48x48" href="/public/assets/Logo/favicon-48.png">
  <link rel="icon" type="image/png" sizes="64x64" href="/public/assets/Logo/favicon-64.png">
  <link rel="icon" type="image/png" sizes="128x128" href="/public/assets/Logo/favicon-128.png">
  <link rel="apple-touch-icon" sizes="180x180" href="/public/assets/Logo/apple-touch-icon.png">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Amiri+Quran&display=swap"
    rel="stylesheet">

  <link rel="stylesheet" href="/public/css/about-us.css">
  <link rel="stylesheet" href="/public/css/nav.css">
  <meta name="theme-color" content="#231709">
</head>

<body>
  <div class="overlay" id="overlay"></div>

  <div class="hero-wrapper">
    <?php require __DIR__ . '/../components/nav.php'; ?>

    <main class="site-container">
      <div class="main-logo-wrapper">
        <img class="main-logo" src="/public/assets/Logo/Jawlah.webp" alt="Jawlah Main Logo" loading="lazy">
      </div>

      <section class="about-jawlah-section">
        <h1 class="about-title">
          About<span class="brand-text">JAWLAH</span><span class="dot-accent">.</span>
        </h1>

        <p class="about-desc">
          offers authentic desert adventure across the desert, allowing you to enjoy the beauty of the dunes,
          peaceful moments, and traditional desert life guided by local experts.
        </p>

        <a href="#BehindJawlah" aria-label="Scroll down">
          <img class="scroll-arrow" src="/public/assets/Icons/arrow-down.png" alt="Scroll down arrow" loading="lazy">
        </a>
      </section>

      <button class="return" id="return-btn" aria-label="Return to top">
        <img class="return-arrow" src="/public/assets/Icons/arrow-down-return.svg" alt="Back to top">
      </button>

      <div class="hero-img-container">
        <img class="hero-desert-img" src="/public/assets/Images/Desert and Camels.webp" alt="Desert and Camels"
          fetchpriority="high">
      </div>

      <section id="BehindJawlah" class="behind-section">
        <div class="behind-content">
          <h1 class="section-title">
            Behind<span class="brand-text">JAWLAH</span><span class="dot-accent">.</span>
          </h1>

          <p class="section-desc">
            <span class="brand-title">JAWLAH</span><span class="dot-accent">.</span> was founded in 2025 by a passionate
            local team dedicated to creating authentic desert experiences that respect desert culture and nature.
            We offer a variety of carefully designed activities, including Camel Riding, Quad Biking, Sandboarding,
            and 4x4 Desert Safaris, combining adventure with comfort and safety. Our goal is to provide unforgettable
            moments through well-organized experiences, guided by local expertise and a deep love for the desert.
          </p>
        </div>

        <div class="behind-images-wrapper">
          <div>
            <img class="behind-img camel-img" src="/public/assets/Images/Camel.webp" alt="Camel" loading="lazy">
            <h2 class="img-caption">Camel</h2>
          </div>

          <div>
            <img class="behind-img quad-img" src="/public/assets/Images/men a Quad Bike.webp" alt="Man on a quad bike"
              loading="lazy">
            <h2 class="img-caption">Quad Bike</h2>
          </div>
        </div>
      </section>

      <section class="behind-section">
        <div>
          <h1 class="section-title">
            Why<span class="brand-text">JAWLAH</span><span class="dot-accent">.</span>
          </h1>
        </div>

        <div class="features-grid">
          <article class="feature-card">
            <img class="feature-icon" src="/public/assets/Icons/Safety.svg" alt="Safety icon" loading="lazy">
            <h2 class="feature-title">Comfort & Safety</h2>
            <p class="feature-desc">
              Enjoy a smooth and relaxing camel ride with a strong focus on comfort and safety throughout the
              experience.
            </p>
          </article>

          <article class="feature-card">
            <img class="feature-icon" src="/public/assets/Icons/Desert Area.svg" alt="Desert area icon" loading="lazy">
            <h2 class="feature-title">Authentic Desert Area</h2>
            <p class="feature-desc">
              Carefully selected desert locations that offer silence, beauty, and a true connection with nature.
            </p>
          </article>

          <article class="feature-card">
            <img class="feature-icon" src="/public/assets/Icons/duration1.svg" alt="Duration icon" loading="lazy">
            <h2 class="feature-title">Flexible Ride Duration</h2>
            <p class="feature-desc">
              Choose the ride duration that suits you, whether a short sunset ride or a longer desert experience.
            </p>
          </article>

          <article class="feature-card">
            <img class="feature-icon" src="/public/assets/Icons/local experience.svg" alt="Local experience icon"
              loading="lazy">
            <h2 class="feature-title">Local Experience</h2>
            <p class="feature-desc">
              Guided by local experts who understand the desert, its culture, and traditions.
            </p>
          </article>
        </div>
      </section>

      <section class="behind-section">
        <div>
          <h1 class="testimonials-title">What our clients say</h1>
        </div>

        <div class="testimonials-wrapper">
          <article class="testimonial-card">
            <p class="testimonial-quote">
              I booked my flight via JAWLAH and everything was smooth and fast. I loved the ease of choosing the
              flight and paying, and everything was done without any problems. I will definitely use the service again!
            </p>
            <h2 class="testimonial-author">~ Rachid Elbakkali</h2>
          </article>

          <article class="testimonial-card">
            <p class="testimonial-quote">
              With JAWLAH my experience on a tour beyond beauty was unforgettable! It saved me a lot of time and effort
              booking, and everything was wonderfully organized. I felt comfortable and enjoyed every moment in the
              desert.
              I will definitely repeat the experience.
            </p>
            <h2 class="testimonial-author">~ James</h2>
          </article>
        </div>
      </section>

      <section class="quote-section">
        <h1 class="quote-text">
          In a world that turns people into numbers, we combine technology with tradition to deliver personalized camel
          rides and unforgettable desert moments.
        </h1>

        <img class="quote-img" src="/public/assets/Images/camel rest.webp" alt="Camel resting" loading="lazy">
      </section>
    </main>

    <section class="cta-banner">
      <p class="cta-subtitle">What are you waiting for?</p>
      <a class="btn-book" href="/public/tour">Book a Jawlah</a>
    </section>
  </div>

  <?php include __DIR__ . '/../components/footer.php' ?>

  <script type="module" src="/public/js/nav-toggle.js" defer></script>
  <script type="module" src="/public/js/scroll.js" defer></script>
</body>

</html>
