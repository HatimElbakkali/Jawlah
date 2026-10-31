<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once __DIR__ . '/../components/head.php' ?>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tour - Jawlah</title>
  <meta name="description"
    content="Explore desert adventure activities in Merzouga — camel riding, quad biking, sandboarding, and 4x4 desert tours with Jawlah." />
  <link rel="preload" href="/public/assets/Fonts/Andalus.woff2" as="font" type="font/woff2" crossorigin />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Amiri+Quran&display=swap"
    rel="stylesheet">
    
  <!-- Style -->
  <link rel="stylesheet" href="/public/css/tour.css" />
  <link rel="stylesheet" href="/public/css/nav.css">
  <!-- Style -->

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

  <div class="page-wrapper">
  <?php $navOverlay = true; ?>
  <?php require_once __DIR__ . '/../components/nav.php'; ?>

    <div class="hero-bg">
      <section class="hero-section">
        <h1 class="hero-title">Desert Adventure Journey</h1>
        <p class="hero-description">A magical tour through the sand dunes – minutes of delight</p>
        <div class="hero-activities">
          <p class="hero-activity-tag">Camel Riding</p>
          <span class="dot-separator" aria-hidden="true">·</span>
          <p class="hero-activity-tag">Quad Biking</p>
          <span class="dot-separator" aria-hidden="true">·</span>
          <p class="hero-activity-tag">Sandboarding</p>
          <span class="dot-separator" aria-hidden="true">·</span>
          <p class="hero-activity-tag">Car 4x4</p>
        </div>
        <div class="cta-wrapper">
          <a href="#slide">
            <button type="button" class="btn-choose-now">
              Choose Now
              <img class="icon-arrow-down" src="/public/assets/Icons/arrow-down.png" alt="Scroll down" loading="lazy" />
            </button>
          </a>
        </div>
      </section>
    </div>

    <div class="ticker-bar">
      <div class="ticker-track">
        <span class="ticker-item">Easy &amp; Fast Booking</span>
        <span class="ticker-item">Comfort &amp; Safety</span>
        <span class="ticker-item">Local Expert Guides</span>
        <span class="ticker-item">Authentic Locations</span>
        <span class="ticker-item">Flexible Ride Duration</span>
        <span class="ticker-item">Best Price Guarantee</span>
        <span class="ticker-item">Easy &amp; Fast Booking</span>
        <span class="ticker-item">Comfort &amp; Safety</span>
        <span class="ticker-item">Local Expert Guides</span>
        <span class="ticker-item">Authentic Locations</span>
        <span class="ticker-item">Flexible Ride Duration</span>
        <span class="ticker-item">Best Price Guarantee</span>
      </div>
    </div>

    <button class="return-btn" id="return-btn" aria-label="Return to top">
      <img class="return-arrow" src="/public/assets/Icons/arrow-down-return.svg" alt="Back to top" />
    </button>

    <div class="page-container">

      <div class="section-activities-header">
        <h2 id="slide" class="section-heading">Desert Adventure Activities</h2>
      </div>

      <?php foreach ($DesertActivities as $DesertActivity): ?>
        <div class="activity-row">
          <div class="activity-media">
            <img class="activity-img" src="<?= $DesertActivity['image'] ?>" alt="Camel Riding" loading="lazy" />
          </div>
          <div class="activity-info">
            <div class="info-row">
              <h2 class="activity-title"><?= $DesertActivity['title'] ?></h2>
              <img class="activity-title-icon" src="<?= $DesertActivity['icon_title'] ?>" alt="Camel icon" loading="lazy" />
            </div>
            <p class="activity-desc"><?= $DesertActivity['description'] ?></p>
            <div class="activity-details">
              <div class="info-row">
                <img class="detail-icon" src="/public/assets/Icons/placeholder.png" alt="Location" loading="lazy" />
                <p class="detail-text"><?= $DesertActivity['location'] ?></p>
              </div>
              <div class="info-row">
                <img class="detail-icon" src="/public/assets/Icons/duration.png" alt="Duration" loading="lazy" />
                <p class="detail-text">Up to 1 hour</p>
              </div>
              <div class="info-row">
                <img class="detail-icon" src="/public/assets/Icons/group.png" alt="Group" loading="lazy" />
                <p class="detail-text">Suitable for <?= $DesertActivity['age_restriction'] ?></p>
              </div>
              <div class="info-row">
                <img class="detail-icon" src="/public/assets/Icons/guid.png" alt="Guide" loading="lazy" />
                <p class="detail-text"><?= $DesertActivity['accompanied'] ?></p>
              </div>
              <div class="info-row">
                <img class="detail-icon" src="/public/assets/Icons/money.png" alt="Price" loading="lazy" />
                <p class="detail-text">30 minute - <?= $DesertActivity['price'] ?>$ ~ Price varies by duration</p>
              </div>
              <a href="/public/booking?id=<?= $DesertActivity['id'] ?>&type=activity" class="link-plain">
                <button type="button" class="btn-book-now">
                  <span class="btn-book-label">Book Now</span>
                  <img class="icon-arrow-right" src="/public/assets/Icons/arrow-right.png" alt="Arrow right" loading="lazy" />
                </button>
              </a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>

      <div class="section-activities-header">
        <h2 class="section-heading">Desert Adventure Pack</h2>
      </div>
      <?php foreach ($desertActivitiesPacks as $desertActivitiesPack): ?>
        <div class="pack-title-wrapper">
          <h2 class="pack-title"><?= $desertActivitiesPack['title'] ?></h2>
        </div>

        <div class="pack-img-container">
          <img class="image-pack" src="<?= $desertActivitiesPack['image'] ?>" alt="Desert Adventure Pack" loading="lazy" />
        </div>

        <div class="pack-info">
          <p class="activity-desc"><?= $desertActivitiesPack['description'] ?></p>
          <div class="activity-details">
            <div class="info-row">
              <img class="detail-icon" src="/public/assets/Icons/placeholder.png" alt="Location" loading="lazy" />
              <p class="detail-text"><?= $desertActivitiesPack['location'] ?></p>
            </div>
            <div class="info-row">
              <img class="detail-icon" src="/public/assets/Icons/duration.png" alt="Duration" loading="lazy" />
              <p class="detail-text">Up to 1 hour</p>
            </div>
            <div class="info-row">
              <img class="detail-icon" src="/public/assets/Icons/group.png" alt="Group" loading="lazy" />
              <p class="detail-text">Suitable for <?= $desertActivitiesPack['age_restriction'] ?></p>
            </div>
            <div class="info-row">
              <img class="detail-icon" src="/public/assets/Icons/guid.png" alt="Guide" loading="lazy" />
              <p class="detail-text"><?= $desertActivitiesPack['accompanied'] ?>
              </p>
            </div>
            <div class="info-row">
              <img class="detail-icon" src="/public/assets/Icons/money.png" alt="Price" loading="lazy" />
              <p class="detail-text"><?= $desertActivitiesPack['price'] ?>$ per person ~ Up to 20 minutes per activity</p>
            </div>
            <a href="/public/booking?id=<?= $desertActivitiesPack['id'] ?>&type=pack" class="link-plain">
              <button type="button" class="btn-book-now" id="btn-book-pack">
                <span class="btn-book-label">Book Now</span>
                <img class="icon-arrow-right" src="/public/assets/Icons/arrow-right.png" alt="Arrow right" loading="lazy" />
              </button>
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  <?php include __DIR__ . '/../components/footer.php' ?>
  <script type="module" src="/public/js/nav-toggle.js" defer></script>
  <script type="module" src="/public/js/scroll.js" defer></script>
</body>

</html>