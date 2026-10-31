<?php
$uri = rtrim((string) parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/') ?: '/';
?>

<nav class="navbar <?= !empty($navOverlay) ? 'navbar--overlay' : '' ?>">
    <a href="/" aria-label="Jawlah Home">
        <div class="glass-logo-bg">
            <img
                class="nav-logo"
                src="/public/assets/Logo/Jawlah.webp"
                alt="Jawlah Logo">
        </div>
    </a>

    <div class="nav-content">
        <button
            type="button"
            class="nav-toggle"
            id="nav-toggle"
            aria-label="Toggle Navigation"
            aria-controls="nav-menu"
            aria-expanded="false">
            <span class="bar"></span>
            <span class="bar"></span>
        </button>

        <div class="nav-menu-glass" id="nav-menu">

            <a
                href="/"
                class="nav-link <?= $uri === '/' ? 'active' : '' ?>">
                Home
            </a>

            <a
                href="/tour"
                class="nav-link <?= $uri === '/tour' ? 'active' : '' ?>">
                Tours
            </a>

            <a
                href="/booking?type=activity&id=b063825c-9387-11f1-991b-4c77cb9a64c8"
                class="nav-link <?= $uri === '/booking' ? 'active' : '' ?>">
                Booking
            </a>

            <a
                href="/about"
                class="nav-link <?= $uri === '/about' ? 'active' : '' ?>">
                About us
            </a>

            <a
                href="/contact"
                class="nav-link <?= $uri === '/contact' ? 'active' : '' ?>">
                Contact us
            </a>

            <div class="sidebar-contact-info">
                <a href="mailto:jawlah.contact@gmail.com" class="contact-link sidebar-btn">
                    jawlah.contact@gmail.com
                </a>

                <a href="tel:+212600000000" class="contact-link sidebar-btn">
                    +212 6 00 00 00 00
                </a>

                <p class="location-txt sidebar-btn">
                    Erg Chebbi, Merzouga Desert,<br>
                    Drâa-Tafilalet Region,<br>
                    52227 - Morocco
                </p>
            </div>

        </div>
    </div>
</nav>