<!DOCTYPE html>
<html lang="en">
<head>
  <?php require_once __DIR__ . '/../components/head.php' ?>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home - Jawlah</title>
  <link rel="shortcut icon" href="/public/assets/Logo/favicon.ico">
  <link rel="icon" type="image/png" sizes="16x16" href="/public/assets/Logo/favicon-16.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/public/assets/Logo/favicon-32.png">
  <link rel="icon" type="image/png" sizes="48x48" href="/public/assets/Logo/favicon-48.png">
  <link rel="icon" type="image/png" sizes="64x64" href="/public/assets/Logo/favicon-64.png">
  <link rel="icon" type="image/png" sizes="128x128" href="/public/assets/Logo/favicon-128.png">
  <link rel="apple-touch-icon" sizes="180x180" href="/public/assets/Logo/apple-touch-icon.png">
  <meta name="theme-color" content="#231709">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Amiri+Quran&family=EB+Garamond:ital,wght@0,400..800;1,400..800&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="/public/css/home.css">
</head>

<body>
  <div class="overlay" id="overlay"></div>
  <div class="hero-wrapper">
    <?php include __DIR__. '/../components/nav.php'; ?>
    <main>
      <h1 class="hero-title">
        JAWLAH<span class="dot-accent">.</span>
      </h1>
      <img class="mountain-img" src="/public/assets/Images/Mountain.webp" alt="Mountain" loading="lazy">
      <div class="cta-wrapper">
        <a class="btn-discover" href="/public/tour">
          Discover <span class="brand-text">JAWLAH.</span>
        </a>
      </div>
    </main>
    <footer class="social-footer">
      <a href="#" class="glass-icon-btn" aria-label="Instagram">
        <img class="social-icon" src="/public/assets/Icons/Instagram.png" alt="Instagram" loading="lazy">
      </a>
      <a href="#" class="glass-icon-btn" aria-label="Facebook">
        <img class="social-icon" src="/public/assets/Icons/facebook.svg" alt="Facebook" loading="lazy">
      </a>
      <a href="#" class="glass-icon-btn" aria-label="Youtube">
        <img class="social-icon" src="/public/assets/Icons/Youtube.svg" alt="Youtube" loading="lazy">
      </a>
      <a href="#" class="glass-icon-btn" aria-label="X (Twitter)">
        <img class="social-icon small-icon" src="/public/assets/Icons/X.svg" alt="X" loading="lazy">
      </a>
    </footer>
  </div>
  <script src="/public/js/nav-toggle.js" defer></script>
</body>

</html>