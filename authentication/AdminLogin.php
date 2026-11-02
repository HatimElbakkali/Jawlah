<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in to JAWLAH</title>
    <link rel="shortcut icon" href="/public/assets/Logo/favicon.ico" />
    <link rel="icon" type="image/png" sizes="16x16" href="/public/assets/Logo/favicon-16.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="/public/assets/Logo/favicon-32.png" />
    <link rel="icon" type="image/png" sizes="48x48" href="/public/assets/Logo/favicon-48.png" />
    <link rel="icon" type="image/png" sizes="64x64" href="/public/assets/Logo/favicon-64.png" />
    <link rel="icon" type="image/png" sizes="128x128" href="/public/assets/Logo/favicon-128.png" />
    <link rel="apple-touch-icon" sizes="180x180" href="/public/assets/Logo/apple-touch-icon.png" />
    <link rel="preload" href="/public/assets/Fonts/Andalus.woff2" as="font" type="font/woff2" crossorigin />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Amiri+Quran&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="/public/css/AdminLogin.css">
</head>

<body>
    <div class="auth-container">
        <div class="auth-header">
            <a href="/public/home.php">
                <img src="/public/assets/Logo/Jawlah.webp" alt="JAWLAH Logo" class="auth-logo">
            </a>
            <h1 class="login-title">Welcome back, <span>Manager</span>.</h1>
        </div>
        <div class="auth-card">
            <div id="errorBanner" class="error-banner"></div>
            <form id="loginForm" autocomplete="on" novalidate>
                <input type="hidden" id="csrfToken" name="csrf_token" value="<?php echo bin2hex(random_bytes(16)); ?>">
                <div class="form-group">
                    <label class="form-label" for="username">Username or email address</label>
                    <input type="text" id="username" name="username" class="form-input" required autocomplete="username" autofocus>
                </div>
                <div class="form-group">
                    <div class="form-label-row">
                        <label class="form-label" for="password">Password</label>
                    </div>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" class="form-input" required autocomplete="current-password">
                        <button type="button" class="toggle-password" id="togglePasswordBtn" aria-label="Toggle password visibility">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                    <div class="strength-bar" id="strengthBar">
                        <div class="strength-fill" id="strengthFill"></div>
                    </div>
                </div>
                <button type="submit" class="btn-submit" id="submitBtn">Sign in</button>
            </form>
        </div>
    </div>
    <script src="/public/js/adminLogin.js"></script>
</body>

</html>