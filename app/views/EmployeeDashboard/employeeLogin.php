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
    <style>
        @font-face {
            font-family: 'Andalus';
            src: url('/public/assets/Fonts/Andalus.woff2') format('woff2');
            font-display: swap;
        }

        :root {
            --bg: #b2ae85;
            --card-bg: rgba(255, 255, 255, 0.10);
            --card-border: rgba(255, 255, 255, 0.28);
            --input-bg: #ccc9b3;
            --input-border: rgba(255, 255, 255, 0.45);
            --text: #231709;
            --gold: #9c8a50;
            --button: #2a1a0b;
            --error-bg: #bc9f87;
            --error-border: #c58f7e;
            --error-text: #b3261e;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1.5rem 1rem;
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Sans', system-ui, -apple-system, 'Segoe UI', sans-serif;
        }

        .login-logo {
            display: block;
            width: 130px;
            max-width: 40%;
            height: auto;
            margin-bottom: 1.25rem;
        }

        .login-title {
            margin-bottom: 1.5rem;
            text-align: center;
            font-family: 'Andalus', Georgia, 'Times New Roman', serif;
            font-size: clamp(1.25rem, 3vw, 1.6rem);
            font-weight: 400;
            line-height: 1.2;
        }
        .login-title span { color: var(--gold); }

        .login-card {
            width: 100%;
            max-width: 380px;
            padding: 1.6rem 1.6rem 1.5rem;
            border-radius: 20px;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            box-shadow: 0 8px 24px rgba(35, 23, 9, 0.06);
        }

        .error {
            display: none;
            margin-bottom: 1rem;
            padding: 0.7rem 0.85rem;
            border-radius: 10px;
            background: var(--error-bg);
            border: 1px solid var(--error-border);
            color: var(--error-text);
            font-size: 0.85rem;
        }
        .error.show { display: block; }

        .field { margin-bottom: 1.1rem; }

        label {
            display: block;
            margin-bottom: 0.4rem;
            font-size: 0.88rem;
            font-weight: 600;
        }

        .input-wrap { position: relative; }

        input {
            width: 100%;
            height: 44px;
            padding: 0 0.9rem;
            border-radius: 10px;
            border: 1px solid var(--input-border);
            background: var(--input-bg);
            color: var(--text);
            font-family: inherit;
            font-size: 0.92rem;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        input:focus {
            outline: none;
            border-color: rgba(35, 23, 9, 0.55);
            box-shadow: 0 0 0 3px rgba(35, 23, 9, 0.10);
        }
        input.invalid { border-color: var(--error-text); }

        .input-wrap input { padding-right: 2.6rem; }

        .toggle-pass {
            position: absolute;
            top: 50%;
            right: 0.55rem;
            transform: translateY(-50%);
            display: flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border: 0;
            background: transparent;
            color: var(--text);
            cursor: pointer;
        }
        .toggle-pass svg { width: 18px; height: 18px; }
        .toggle-pass .icon-hide { display: none; }
        .toggle-pass.showing .icon-show { display: none; }
        .toggle-pass.showing .icon-hide { display: block; }

        .btn-submit {
            width: 100%;
            height: 46px;
            margin-top: 0.3rem;
            border: 0;
            border-radius: 10px;
            background: var(--button);
            color: #f5f2e8;
            font-family: inherit;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.1s, opacity 0.15s;
        }
        .btn-submit:hover { opacity: 0.92; }
        .btn-submit:active { transform: translateY(1px); }
        .btn-submit:disabled { opacity: 0.6; cursor: wait; }

        @media (max-width: 480px) {
            .login-card { padding: 1.3rem 1.1rem; border-radius: 18px; }
        }
    </style>
</head>

<body>
    <img class="login-logo" src="/public/assets/Logo/Jawlah.webp" alt="JAWLAH Logo">

    <h1 class="login-title">Sign in to manage <span>JAWLAH</span>.</h1>

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

    <script>
        (function () {
            const form = document.getElementById('employeeLoginForm');
            const btn = document.getElementById('loginBtn');
            const errorBox = document.getElementById('loginError');
            const userInput = document.getElementById('username');
            const passInput = document.getElementById('password');
            const toggle = document.getElementById('togglePass');

            toggle.addEventListener('click', () => {
                const show = passInput.type === 'password';
                passInput.type = show ? 'text' : 'password';
                toggle.classList.toggle('showing', show);
                toggle.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
            });

            function showError(msg, markInputs) {
                errorBox.textContent = msg;
                errorBox.classList.add('show');
                if (markInputs) {
                    userInput.classList.add('invalid');
                    passInput.classList.add('invalid');
                }
            }

            function clearError() {
                errorBox.classList.remove('show');
                userInput.classList.remove('invalid');
                passInput.classList.remove('invalid');
            }

            [userInput, passInput].forEach(el => el.addEventListener('input', clearError));

            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                clearError();

                const username = userInput.value.trim();
                const password = passInput.value;

                if (!username || !password) {
                    showError('Please enter both username and password.', false);
                    return;
                }

                btn.disabled = true;

                try {
                    const res = await fetch('/public/employee/login', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                        body: JSON.stringify({ username, password })
                    });

                    const text = await res.text();
                    let data;
                    try {
                        data = JSON.parse(text);
                    } catch (err) {
                        console.error('Server did not return JSON (status ' + res.status + '):\n', text);
                        showError('Server error (' + res.status + '). Check the console.', false);
                        return;
                    }

                    if (data.success) {
                        window.location.href = data.redirect || '/public/employee';
                    } else {
                        showError(data.message || 'Login failed.', res.status === 401);
                    }
                } catch (err) {
                    showError('Network error. Please try again.', false);
                } finally {
                    btn.disabled = false;
                }
            });
        })();
    </script>
</body>

</html>