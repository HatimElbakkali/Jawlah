<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in to manage JAWLAH</title>
    <link rel="shortcut icon" href="/public/assets/Logo/favicon.ico" />
    <link rel="icon" type="image/png" sizes="32x32" href="/public/assets/Logo/favicon-32.png" />
    <meta name="theme-color" content="#b2ae85">
    <link rel="preload" href="/public/assets/Fonts/Andalus.woff2" as="font" type="font/woff2" crossorigin />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="/public/css/adminEmployee.css">
</head>

<body>
    <img class="login-logo" src="/public/assets/Logo/Jawlah.webp" alt="JAWLAH Logo">

    <h1 class="login-title">Welcome back, <span>Team Member</span>.</h1>

    <div class="login-card">
        <div id="loginError" class="error" role="alert"></div>

        <form id="employeeLoginForm" autocomplete="on" novalidate>
            <div class="field">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" autocomplete="username" autofocus required>
            </div>

            <div class="field">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <input type="password" id="password" name="password" autocomplete="current-password" required>
                    <button type="button" class="toggle-pass" id="togglePass" aria-label="Show password">
                        <svg class="icon-show" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <svg class="icon-hide" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"></path>
                            <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"></path>
                            <path d="M14.12 14.12a3 3 0 1 1-4.24-4.24"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-submit" id="loginBtn">Sign in</button>
        </form>
    </div>
    <script src="/public/js/AdminEmployee.js"></script>
</body>

</html>