<?php $bookingInfo = $type === 'pack' ? $showInfoPack : $showInfoActivities; ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <?php require_once __DIR__ . '/../components/head.php' ?>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book Experience | JAWLAH Desert Adventures</title>
  <link rel="preload" href="/public/assets/Fonts/Andalus.woff2" as="font" type="font/woff2" crossorigin />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Amiri+Quran&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="/public/css/booking.css">
  <link rel="stylesheet" href="/public/css/nav.css">
  <link rel="shortcut icon" href="/public/assets/Logo/favicon.ico" />
  <link rel="icon" type="image/png" sizes="16x16" href="/public/assets/Logo/favicon-16.png" />
  <link rel="icon" type="image/png" sizes="32x32" href="/public/assets/Logo/favicon-32.png" />
  <link rel="icon" type="image/png" sizes="48x48" href="/public/assets/Logo/favicon-48.png" />
  <link rel="icon" type="image/png" sizes="64x64" href="/public/assets/Logo/favicon-64.png" />
  <link rel="icon" type="image/png" sizes="128x128" href="/public/assets/Logo/favicon-128.png" />
  <link rel="apple-touch-icon" sizes="180x180" href="/public/assets/Logo/apple-touch-icon.png" />
</head>

<body>

  <div class="overlay" id="overlay"></div>
  <?php require_once __DIR__ . '/../components/nav.php'; ?>

  <div class="step-indicator-wrapper">
    <div class="step-indicator-container">
      <div class="step-item completed" id="step-node-1" data-step="1">
        <div class="step-icon">
          <svg class="icon-check" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"></polyline>
          </svg>
        </div>
        <span class="step-title">Activity</span>
      </div>

      <div class="step-connector"></div>

      <div class="step-item active" id="step-node-2" data-step="2">
        <div class="step-icon">
          <span class="step-num">2</span>
          <svg class="icon-check" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"></polyline>
          </svg>
        </div>
        <span class="step-title">Date</span>
      </div>

      <div class="step-connector"></div>

      <div class="step-item" id="step-node-3" data-step="3">
        <div class="step-icon">
          <span class="step-num">3</span>
          <svg class="icon-check" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"></polyline>
          </svg>
        </div>
        <span class="step-title">Duration</span>
      </div>


      <div class="step-connector"></div>

      <div class="step-item" id="step-node-4" data-step="4">
        <div class="step-icon">
          <span class="step-num">4</span>
          <svg class="icon-check" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"></polyline>
          </svg>
        </div>
        <span class="step-title">Time</span>
      </div>

      <div class="step-connector"></div>

      <div class="step-item" id="step-node-5" data-step="5">
        <div class="step-icon">
          <span class="step-num">5</span>
          <svg class="icon-check" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"></polyline>
          </svg>
        </div>
        <span class="step-title">Participants</span>
      </div>

      <div class="step-connector"></div>

      <div class="step-item" id="step-node-6" data-step="6">
        <div class="step-icon">
          <span class="step-num">6</span>
          <svg class="icon-check" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"></polyline>
          </svg>
        </div>
        <span class="step-title">Review</span>
      </div>

    </div>
  </div>

  <div class="page-content-wrapper">
    <div class="main-layout-grid">

      <main class="left-action-column">

        <section class="step-screen active" id="screen-date">
          <div class="section-title-group">
            <h1 class="section-title">Select your date</h1>
            <p class="section-subtitle">Choose the date you want to book</p>
          </div>

          <div class="calendar-card">
            <div class="calendar-month-nav">
              <button class="cal-arrow-btn" id="cal-prev" aria-label="Previous Month">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
              </button>
              <span class="cal-month-name" id="cal-month-title">Current month</span>
              <button class="cal-arrow-btn" id="cal-next" aria-label="Next Month">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
              </button>
            </div>

            <div class="date-picker-row">
              <label class="date-picker-label" for="date-picker">Choose a date</label>
              <input class="date-picker-input" type="date" id="date-picker" aria-label="Choose a booking date">
            </div>

            <div class="calendar-weekdays">
              <span>Sun</span><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span>
            </div>

            <div class="calendar-days-grid" id="calendar-days-grid">
            </div>

            <div class="calendar-legend">
              <span class="legend-dot green org"></span><span class="legend-text">Available</span>
              <span class="legend-dot orange org"></span><span class="legend-text">Limited availability</span>
              <span class="legend-dot gray org"></span><span class="legend-text">Not available</span>
            </div>
          </div>

          <div class="screen-footer-actions">
            <a href="/public/tour">
              <button class="btn-back-outline" id="btn-back-date">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                  <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
                <span class="txt-back">Back</span>
              </button>
            </a>
            <button class="btn-primary-brown" id="btn-next-date">
              <span class="cta-next">Next: Select Duration</span>
              <svg width="16" height="16" viewBox="0 0 24 24" class="arrow" fill="none" stroke="currentColor"
                stroke-width="2.2">
                <polyline points="9 18 15 12 9 6"></polyline>
              </svg>
            </button>
          </div>
        </section>

        <section class="step-screen" id="screen-duration">
          <div class="section-title-group">
            <h1 class="section-title">Select duration</h1>
            <p class="section-subtitle">Choose how long you want to enjoy the experience</p>
          </div>

          <div class="duration-cards-grid-pack">
            <?php if ($type === 'pack'): ?>
              <div class="duration-select-card" id="card-dur-1hr" data-duration="60 min" data-price="<?= $bookingInfo['price'] ?>">
                <div class="dur-card-check">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#FFF" stroke-width="3.5">
                    <polyline points="20 6 9 17 4 12"></polyline>
                  </svg>
                </div>
                <div class="dur-icon-circle">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#5C2C16" stroke-width="2">
                    <circle cx="12" cy="12" r="10" />
                    <polyline points="12 6 12 12 16 14" />
                  </svg>
                </div>
                <h2 class="dur-time-title">60 min</h2>
                <span class="dur-tag-sub">Full experience</span>
                <p class="dur-desc">Experience the desert in three exciting ways</p>
                <div class="dur-price-line">
                  <span class="dur-from">From</span> <strong class="dur-amount">$<?= $bookingInfo['price'] ?></strong> <span class="dur-per">/
                    person</span>
                </div>
              </div>
            <?php else: ?>
              <div class="duration-cards-grid">
                <div class="duration-select-card selected" id="card-dur-30min" data-duration="30 min"
                  data-price="<?= $bookingInfo['price'] ?>">
                  <div class="dur-card-check">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#FFF" stroke-width="3.5">
                      <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                  </div>
                  <div class="dur-icon-circle">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#5C2C16" stroke-width="2">
                      <circle cx="12" cy="12" r="10" />
                      <polyline points="12 6 12 12 16 14" />
                    </svg>
                  </div>
                  <h2 class="dur-time-title">30 min</h2>
                  <span class="dur-tag-sub">Short & sweet</span>
                  <p class="dur-desc">Perfect for a quick desert experience</p>
                  <div class="dur-price-line">
                    <span class="dur-from">From</span> <strong class="dur-amount">$<?= $bookingInfo['price'] ?></strong> <span class="dur-per">/
                      person</span>
                  </div>
                </div>

                <div class="duration-select-card" id="card-dur-1hr" data-duration="60 min" data-price="<?= $bookingInfo['price'] * 2 ?>">
                  <div class="dur-card-check">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#FFF" stroke-width="3.5">
                      <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                  </div>
                  <div class="dur-icon-circle">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#5C2C16" stroke-width="2">
                      <circle cx="12" cy="12" r="10" />
                      <polyline points="12 6 12 12 16 14" />
                    </svg>
                  </div>
                  <h2 class="dur-time-title">60 min</h2>
                  <span class="dur-tag-sub">Full experience</span>
                  <p class="dur-desc">More time to enjoy the desert</p>
                  <div class="dur-price-line">
                    <span class="dur-from">From</span> <strong class="dur-amount">$<?= $bookingInfo['price'] * 2 ?></strong> <span class="dur-per">/
                      person</span>
                  </div>
                </div>
              </div>
            <?php endif; ?>
            <div class="info-notice-card">
              <svg class="info-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#5C2C16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-alert-icon lucide-shield-alert">
                <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z" />
                <path d="M12 8v4" />
                <path d="M12 16h.01" />
              </svg>
              <span>The longer you ride, the more you pay.</span>
            </div>

            <div class="screen-footer-actions">
              <button class="btn-back-outline" id="btn-back-duration">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                  <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
                <span>Back</span>
              </button>
              <button class="btn-primary-brown" id="btn-next-duration">
                <span class="cta-next">Next: Select Time</span>
                <svg width="16" height="16" viewBox="0 0 24 24" class="arrow" fill="none" stroke="currentColor"
                  stroke-width="2.2">
                  <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
              </button>
            </div>
        </section>

        <section class="step-screen" id="screen-time">
          <div class="section-title-group">
            <h1 class="section-title">Select available time</h1>
            <p class="section-subtitle">All times are in local time (GMT+1)</p>
          </div>

          <div class="time-selection-meta">
            <span><strong>Selected Date:</strong> <span id="meta-date-display">Not selected</span></span>
            <span class="meta-gap"></span>
            <span><strong>Duration:</strong> <span id="meta-duration-display">30 min</span></span>
            <span class="meta-gap"></span>
            <span><strong>capacity:</strong> <span id="meta-capacity-display" data-capacity="<?= (int)($bookingInfo['capacity'] ?? 30) ?>"><?= $bookingInfo['capacity'] ?? 30 ?></span></span>
          </div>

          <div class="time-slots-card">
            <div class="time-buttons-grid" id="time-buttons-grid">
              <button class="time-slot-btn" data-time="10:00 AM">10:00 AM</button>
              <button class="time-slot-btn" data-time="10:30 AM">10:30 AM</button>
              <button class="time-slot-btn" data-time="11:00 AM">11:00 AM</button>
              <button class="time-slot-btn" data-time="11:30 AM">11:30 AM</button>

              <button class="time-slot-btn" data-time="12:00 PM">12:00 PM</button>
              <button class="time-slot-btn" data-time="12:30 PM">12:30 PM</button>
              <button class="time-slot-btn" data-time="01:00 PM">01:00 PM</button>
              <button class="time-slot-btn" data-time="01:30 PM">01:30 PM</button>

              <button class="time-slot-btn" data-time="02:00 PM">02:00 PM</button>
              <button class="time-slot-btn" data-time="02:30 PM">02:30 PM</button>
              <button class="time-slot-btn" data-time="03:00 PM">03:00 PM</button>
              <button class="time-slot-btn selected" data-time="03:30 PM">03:30 PM</button>

              <button class="time-slot-btn" data-time="04:00 PM">04:00 PM</button>
              <button class="time-slot-btn" data-time="04:30 PM">04:30 PM</button>
              <button class="time-slot-btn" data-time="05:00 PM">05:00 PM</button>
              <button class="time-slot-btn" data-time="05:30 PM">05:30 PM</button>

              <button class="time-slot-btn" data-time="06:00 PM">06:00 PM</button>
              <button class="time-slot-btn" data-time="06:30 PM">06:30 PM</button>
              <button class="time-slot-btn" data-time="07:00 PM">07:00 PM</button>
              <button class="time-slot-btn" data-time="07:30 PM">07:30 PM</button>

              <button class="time-slot-btn" data-time="08:00 PM">08:00 PM</button>
              <button class="time-slot-btn" data-time="08:30 PM">08:30 PM</button>
              <button class="time-slot-btn" data-time="09:00 PM">09:00 PM</button>
              <button class="time-slot-btn" data-time="09:30 PM">09:30 PM</button>
            </div>

            <div class="time-legend">
              <span class="legend-dot green"></span><span class="legend-text">Available</span>
              <span class="legend-dot orange"></span><span class="legend-text">Limited</span>
              <span class="legend-dot red"></span><span class="legend-text">Fully booked</span>
            </div>
          </div>

          <div class="screen-footer-actions">
            <button class="btn-back-outline" id="btn-back-time">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                <polyline points="15 18 9 12 15 6"></polyline>
              </svg>
              <span>Back</span>
            </button>
            <button class="btn-primary-brown" id="btn-next-time">
              <span class="cta-next">Next: Participants</span>
              <svg width="16" height="16" viewBox="0 0 24 24" class="arrow" fill="none" stroke="currentColor"
                stroke-width="2.2">
                <polyline points="9 18 15 12 9 6"></polyline>
              </svg>
            </button>
          </div>
        </section>

        <section class="step-screen" id="screen-participants">
          <div class="section-title-group">
            <h1 class="section-title">Select number of participants</h1>
            <p class="section-subtitle">Select the number of people for your booking</p>
          </div>

          <div class="participants-card">
            <div class="counter-row">
              <div class="counter-label-group">
                <span class="counter-title">Adults</span>
                <span class="counter-sub">(12+ years)</span>
              </div>
              <div class="counter-stepper">
                <button class="btn-step-minus" id="adults-dec" aria-label="Decrease Adults">−</button>
                <span class="counter-num" id="adults-count">0</span>
                <button class="btn-step-plus" id="adults-inc" aria-label="Increase Adults">+</button>
              </div>
            </div>

            <div class="counter-row">
              <div class="counter-label-group">
                <span class="counter-title">Children</span>
                <span class="counter-sub">(6 – 11 years)</span>
              </div>
              <div class="counter-stepper">
                <button class="btn-step-minus" id="children-dec" aria-label="Decrease Children">−</button>
                <span class="counter-num" id="children-count">0</span>
                <button class="btn-step-plus" id="children-inc" aria-label="Increase Children">+</button>
              </div>
            </div>

            <div class="counter-row">
              <div class="counter-label-group">
                <span class="counter-title">Infants</span>
                <span class="counter-sub">(0 – 5 years)</span>
                <span class="counter-sub">Unpaid</span>
              </div>
              <div class="counter-stepper">
                <button class="btn-step-minus" id="infants-dec" aria-label="Decrease Infants">−</button>
                <span class="counter-num" id="infants-count">0</span>
                <button class="btn-step-plus" id="infants-inc" aria-label="Increase Infants">+</button>
              </div>
            </div>
          </div>

          <div class="screen-footer-actions">
            <button class="btn-back-outline" id="btn-back-participants">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                <polyline points="15 18 9 12 15 6"></polyline>
              </svg>
              <span>Back</span>
            </button>
            <button class="btn-primary-brown" id="btn-next-participants">
              <span class="cta-next">Next: Review Booking</span>
              <svg width="16" height="16" viewBox="0 0 24 24" class="arrow" fill="none" stroke="currentColor"
                stroke-width="2.2">
                <polyline points="9 18 15 12 9 6"></polyline>
              </svg>
            </button>
          </div>
        </section>

        <section class="step-screen" id="screen-review">
          <div class="section-title-group">
            <h1 class="section-title">Review your booking & payment</h1>
            <p class="section-subtitle">Please check your details and enter payment information before confirming</p>
          </div>

          <div class="review-details-card">
            <div class="review-activity-header">
              <div class="review-thumb">
                <img src="<?= $bookingInfo['image'] ?>" alt="Camel Riding Merzouga">
              </div>
              <div class="review-act-info">
                <h3 class="review-act-title"><?= $bookingInfo['title'] ?></h3>
                <span class="review-act-location"><img width="16" height="16" src="/public/assets/Icons/icon-location.png"
                    alt=""><?= $bookingInfo['location'] ?></span>
              </div>
            </div>

            <div class="review-grid-table">
              <div class="review-grid-row">
                <span class="review-label"> <svg class="sum-icon" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                    <line x1="16" y1="2" x2="16" y2="6" />
                    <line x1="8" y1="2" x2="8" y2="6" />
                    <line x1="3" y1="10" x2="21" y2="10" />
                  </svg>Date</span>
                <span class="review-val" id="rev-date-val">Not selected</span>
              </div>
              <div class="review-grid-row">
                <span class="review-label"> <svg class="sum-icon" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" />
                    <polyline points="12 6 12 12 16 14" />
                  </svg> Duration</span>
                <span class="review-val" id="rev-duration-val">30 min</span>
              </div>
              <div class="review-grid-row">
                <span class="review-label"> <svg class="sum-icon" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" />
                    <polyline points="12 6 12 12 16 14" />
                  </svg> Time</span>
                <span class="review-val" id="rev-time-val">03:30 PM</span>
              </div>
              <div class="review-grid-row">
                <span class="review-label"> <svg class="sum-icon" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                  </svg> Participants</span>
                <span class="review-val" id="rev-participants-val">2 Adults, 1 Child</span>
              </div>
            </div>

            <div class="review-price-section">
              <h4 class="price-sec-title">Price Details</h4>
              <div class="price-line-row">
                <span id="adult-price-detail">2 Adults × $20</span>
                <span id="adult-total-detail">$40</span>
              </div>
              <div class="price-line-row">
                <span id="child-price-detail">1 Child × $20</span>
                <span id="child-total-detail">$20</span>
              </div>

              <div class="review-total-divider"></div>

              <div class="review-total-row">
                <span class="review-total-label">Total Price</span>
                <span class="review-total-amount" id="rev-total-val">$60</span>
              </div>
            </div>
          </div>

          <form class="guest-details-form" id="guest-form" onsubmit="event.preventDefault()">
            <h3 class="form-title">Lead Guest Details</h3>
            <div class="form-row-2col">
              <div class="form-field">
                <label for="form-name">Full Name *</label>
                <input type="text" id="form-name" placeholder="e.g. Sarah Jenkins" value="" required>
              </div>
              <div class="form-field">
                <label for="form-email">Email Address *</label>
                <input type="email" id="form-email" placeholder="e.g. sarah@example.com" value="" required>
              </div>
            </div>
            <div class="form-field" style="margin-bottom: 1.5rem;">
              <label for="form-phone">Phone Number (WhatsApp) *</label>
              <input type="tel" id="form-phone" placeholder="e.g. +1 555-019-2834" value="" required>
            </div>
          </form>

          <div class="screen-footer-actions review-actions-align">
            <button class="btn-back-outline" id="btn-back-review">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                <polyline points="15 18 9 12 15 6"></polyline>
              </svg>
              <span>Back</span>
            </button>
            <div class="confirm-btn-wrapper">
              <button class="btn-primary-brown btn-confirm-wide" id="btn-confirm-booking">
                <span class="cta-next">Confirm</span>
                <svg width="16" height="16" viewBox="0 0 24 24" class="arrow" fill="none" stroke="currentColor"
                  stroke-width="2.2">
                  <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                </svg>
              </button>
              <span class="charge-subtext">Instant booking confirmation</span>
            </div>
          </div>
        </section>
      </main>

    </div>
  </div>

  <footer class="app-trust-footer">
    <div class="trust-footer-container">
      <div class="trust-cell">
        <div class="trust-icon-wrap">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#9e8a45" stroke-width="2">
            <circle cx="12" cy="12" r="10" />
            <path d="M12 6v6l4 2" />
          </svg>
        </div>
        <div class="trust-text-wrap">
          <strong class="trust-title">Free Cancellation</strong>
          <span class="trust-sub">Up to 24h in advance</span>
        </div>
      </div>

      <div class="trust-cell">
        <div class="trust-icon-wrap">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#9e8a45" stroke-width="2">
            <circle cx="12" cy="12" r="10" />
            <path d="M12 8v8M8 12h8" />
          </svg>
        </div>
        <div class="trust-text-wrap">
          <strong class="trust-title">Best Price Guarantee</strong>
          <span class="trust-sub">No hidden fees</span>
        </div>
      </div>

      <div class="trust-cell">
        <div class="trust-icon-wrap">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#9e8a45" stroke-width="2">
            <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2" />
          </svg>
        </div>
        <div class="trust-text-wrap">
          <strong class="trust-title">Instant Confirmation</strong>
          <span class="trust-sub">Book in seconds</span>
        </div>
      </div>

      <div class="trust-cell">
        <div class="trust-icon-wrap">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#9e8a45" stroke-width="2">
            <circle cx="12" cy="12" r="10" />
            <path d="M12 6v6l4 2" />
          </svg>
        </div>
        <div class="trust-text-wrap">
          <strong class="trust-title">24/7 Support</strong>
          <span class="trust-sub">We're here to help</span>
        </div>
      </div>
    </div>
  </footer>

  <div class="modal-backdrop" id="modal-confirm">
    <div class="modal-box">
      <div class="modal-check-circle">✓</div>
      <h2 class="modal-head">Payment & Booking Confirmed!</h2>
      <p class="modal-msg">Shukran! Your luxury desert experience is confirmed. Voucher reference: <strong
          id="modal-ref-code">JWL-984210</strong>.</p>
      <div class="modal-summary-list">
        <p><strong>Activity:</strong> Camel Riding</p>
        <p><strong>Date:</strong> <span id="modal-date-val">Not selected</span></p>
        <p><strong>Time & Duration:</strong> <span id="modal-time-val">03:30 PM (30 min)</span></p>
        <p><strong>Total Paid:</strong> <span id="modal-price-val">$60</span></p>
      </div>
      <button class="btn-primary-brown" id="btn-close-modal">Close</button>
    </div>
  </div>
  <div id="toast" class="toast">
    <span id="toastMessage"></span>
  </div>
  <script src="/public/js/booking.js" defer></script>
  <script src="/public/js/nav-toggle.js" defer></script>
</body>

</html>