<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once __DIR__ . '/../components/head.php' ?>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>JAWLAH – Contact</title>
  <link rel="stylesheet" href="/public/css/contact-us.css" />
  <link rel="stylesheet" href="/public/css/nav.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Amiri+Quran&display=swap"
    rel="stylesheet">
  <link rel="shortcut icon" href="/public/assets/Logo/favicon.ico" />
  <link rel="icon" type="image/png" sizes="16x16" href="/public/assets/Logo/favicon-16.png" />
  <link rel="icon" type="image/png" sizes="32x32" href="/public/assets/Logo/favicon-32.png" />
  <link rel="icon" type="image/png" sizes="48x48" href="/public/assets/Logo/favicon-48.png" />
  <link rel="icon" type="image/png" sizes="64x64" href="/public/assets/Logo/favicon-64.png" />
  <link rel="icon" type="image/png" sizes="128x128" href="/public/assets/Logo/favicon-128.png" />
  <link rel="apple-touch-icon" sizes="180x180" href="/public/assets/Logo/apple-touch-icon.png" />
  <meta name="theme-color" content="#231709" />
</head>

<body>
  <div class="overlay" id="overlay"></div>
  <?php $navOverlay = true; ?>
  <?php include __DIR__ . '/../components/nav.php'; ?>
  <header class="hero">
    <div class="hero__bg"></div>
    <div class="hero__overlay"></div>
    <div class="hero__content">
      <div class="hero__text">
        <h1 class="hero__title animate-hero-title">Contact</h1>
        <p class="hero__subtitle animate-hero-subtitle">What are you waiting for? Let's build your Journey together.</p>
        <div class="hero__arrow animate-hero-arrow">
          <a href="#contact99"><img class=" " src="/public/assets/Icons/arrow-down-return.svg" alt="Scroll down" /></a>
        </div>
      </div>
    </div>
  </header>

  <main>

    <section id="contact99" class="contact-info">
      <div class="container">

        <h2 class="contact-info__heading reveal reveal--left">
          Contact <span class="gold">JAWLAH<span class="dot">.</span></span>
        </h2>

        <div class="cards">

          <article class="card reveal reveal--left">
            <div class="card__icon-box">
              <img src="/public/assets/Icons/icon-email.png" alt="Email icon" />
            </div>
            <div class="card__body">
              <h3>E-mail us</h3>
              <p>For bookings and adventure enquiries, contact</p>
              <a href="mailto:jawlah.contact@gmail.com" class="card__link">jawlah.contact@gmail.com</a>
            </div>
          </article>

          <article class="card reveal reveal--right">
            <div class="card__icon-box">
              <img src="/public/assets/Icons/icon-location.png" alt="Location icon" />
            </div>
            <div class="card__body">
              <h3>Find us</h3>
              <p>
                <strong>Merzouga Desert</strong><br />
                Drâa-Tafilalet Region,<br />52227 – Morocco
              </p>
            </div>
          </article>

          <article class="card reveal reveal--left">
            <div class="card__icon-box">
              <img src="/public/assets/Icons/icon-info.png" alt="Info icon" loading="lazy" />
            </div>
            <div class="card__body">
              <h3>Info</h3>
              <p>
                Company Registration: 80195520<br />
                VAT: NL861584594B01<br />
                Business Hours: Mon – Sat, 10:00 AM – 09:30 PM
              </p>
            </div>
          </article>

        </div>

        <div class="desert-photo reveal reveal--scale">
          <img src="/public/assets/Images/men with camel rest.webp" alt="Camels resting in the Merzouga Desert"
            loading="lazy" />
        </div>

      </div>
    </section>

    <section class="message-us">
      <div class="container message-us__inner">

        <div class="message-us__left reveal reveal--left">
          <h2>Message us</h2>
        </div>

        <div class="message-us__right reveal reveal--up">

          <p class="message-us__intro">
            Fill in the information required in the form and we will get back to you.
            Or contact JAWLAH. via our social media channels.
          </p>

          <div class="social-icons">
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
          </div>

          <p class="message-us__privacy">
            Your information will be kept private and confidential and will be used by JAWLAH only.
            Fields marked * must be completed before submitting. All details provided by you will be
            held by JAWLAH and used in accordance with our Privacy Policy.
          </p>

          <form method="post" class="contact-form" id="contactForm">
            <div class="form-field">
              <label for="name">Name*</label>
              <div class="form-field__input-wrap">
                <input type="text" id="name" name="name" placeholder="Name" />
                <svg class="form-field__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="1.5">
                  <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                  <circle cx="12" cy="7" r="4" />
                </svg>
              </div>
            </div>
            <div class="form-field">
              <label for="email">Email*</label>
              <div class="form-field__input-wrap">
                <input type="email" id="email" name="email" placeholder="Email address" />
                <svg class="form-field__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="1.5">
                  <rect x="2" y="4" width="20" height="16" rx="2" />
                  <polyline points="2,4 12,13 22,4" />
                </svg>
              </div>
            </div>
            <div class="form-field">
              <label for="phone">Phone number*</label>
              <div class="form-field__input-wrap">
                <input type="tel" id="phone" name="phone" placeholder="Phone number" />
                <svg class="form-field__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="1.5">
                  <path
                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.18 2 2 0 0 1 3.59 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.5a16 16 0 0 0 6 6l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" />
                </svg>
              </div>
            </div>

            <div class="form-field">
              <label for="subject">Subject</label>
              <div class="form-field__input-wrap">
                <input type="text" id="subject" name="subject" placeholder="Subject" />
                <svg class="form-field__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="1.5">
                  <line x1="21" y1="10" x2="3" y2="10" />
                  <line x1="21" y1="6" x2="3" y2="6" />
                  <line x1="15" y1="14" x2="3" y2="14" />
                </svg>
              </div>
            </div>
            <div class="form-field">
              <label for="message">Message</label>
              <div class="form-field__input-wrap form-field__input-wrap--textarea">
                <textarea id="message" name="message" rows="4" placeholder="Type here.."></textarea>
              </div>
            </div>
            <div class="form-submit">
              <button type="submit" name="submit" id="submitBtn" class="btn-send">Send message</button>
            </div>
          </form>

        </div>
      </div>
    </section>
  </main>
  <div id="toast" class="toast">
    <span id="toastMessage"></span>
  </div>

  <?php include __DIR__ . '/../components/footer.php'; ?>
  <script src="/public/js/contact-us.js" defer></script>
  <script type="module" src="/public/js/scroll.js" defer></script>
  <script src="/public/js/nav-toggle.js" defer></script>
</body>

</html>