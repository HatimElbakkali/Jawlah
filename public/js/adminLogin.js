document.addEventListener('DOMContentLoaded', () => {
    'use strict';

    const loginForm = document.getElementById('loginForm');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const togglePasswordBtn = document.getElementById('togglePasswordBtn');
    const submitBtn = document.getElementById('submitBtn');
    const errorBanner = document.getElementById('errorBanner');
    const strengthBar = document.getElementById('strengthBar');
    const strengthFill = document.getElementById('strengthFill');

    const MAX_ATTEMPTS = 5;
    const LOCKOUT_TIME_MS = 60000;
    let attempts = parseInt(sessionStorage.getItem('auth_attempts') || '0', 10);
    let lockoutUntil = parseInt(sessionStorage.getItem('auth_lockout_until') || '0', 10);

    checkLockoutState();

    if (togglePasswordBtn && passwordInput) {
        togglePasswordBtn.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            togglePasswordBtn.innerHTML = isPassword
                ? `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                    <line x1="1" y1="1" x2="23" y2="23"></line>
                </svg>`
                : `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                </svg>`;
        });
    }

    if (passwordInput && strengthBar && strengthFill) {
        passwordInput.addEventListener('input', () => {
            const val = passwordInput.value;
            if (!val) {
                strengthBar.style.display = 'none';
                return;
            }
            strengthBar.style.display = 'block';
            let score = 0;
            if (val.length >= 6) score++;
            if (val.length >= 10) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;

            const percentages = ['20%', '40%', '65%', '85%', '100%'];
            const colors = ['#b71c1c', '#e65100', '#f57f17', '#1b5e20', '#0d47a1'];

            strengthFill.style.width = percentages[score - 1] || '10%';
            strengthFill.style.backgroundColor = colors[score - 1] || '#b71c1c';
        });
    }

    if (loginForm) {
        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();

            if (checkLockoutState()) return;

            const username = sanitizeInput(usernameInput.value.trim());
            const password = passwordInput.value.trim();

            clearErrors();

            if (!username) {
                showError('Please enter your username or email address.', usernameInput);
                return;
            }

            if (!password) {
                showError('Please enter your password.', passwordInput);
                return;
            }

            if (detectInjectionPatterns(username) || detectInjectionPatterns(password)) {
                recordFailedAttempt();
                showError('Invalid input characters detected.', usernameInput);
                return;
            }

            submitBtn.disabled = true;
            submitBtn.textContent = 'Signing in...';

            fetch('/public/admin/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ username, password })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    sessionStorage.removeItem('auth_attempts');
                    sessionStorage.removeItem('auth_lockout_until');
                    window.location.href = data.redirect || '/public/admin';
                } else {
                    recordFailedAttempt();
                    showError(data.message || 'Incorrect username or password.', passwordInput);
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Sign in';
                }
            })
            .catch(err => {
                showError('Authentication error. Please try again.', usernameInput);
                submitBtn.disabled = false;
                submitBtn.textContent = 'Sign in';
            });
        });
    }

    function sanitizeInput(str) {
        return str.replace(/[&<>'"]/g, tag => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            "'": '&#39;',
            '"': '&quot;'
        }[tag] || tag));
    }

    function detectInjectionPatterns(str) {
        const patterns = [
            /('|\"|\b(OR|AND)\b.*=)/i,
            /<script/i,
            /javascript:/i,
            /UNION\s+SELECT/i
        ];
        return patterns.some(p => p.test(str));
    }

    function recordFailedAttempt() {
        attempts++;
        sessionStorage.setItem('auth_attempts', attempts);
        if (attempts >= MAX_ATTEMPTS) {
            lockoutUntil = Date.now() + LOCKOUT_TIME_MS;
            sessionStorage.setItem('auth_lockout_until', lockoutUntil);
            checkLockoutState();
        }
    }

    function checkLockoutState() {
        const now = Date.now();
        if (lockoutUntil && now < lockoutUntil) {
            const remainingSeconds = Math.ceil((lockoutUntil - now) / 1000);
            showError(`Too many failed login attempts. Please wait ${remainingSeconds} seconds.`);
            if (submitBtn) submitBtn.disabled = true;
            if (usernameInput) usernameInput.disabled = true;
            if (passwordInput) passwordInput.disabled = true;

            setTimeout(checkLockoutState, 1000);
            return true;
        } else if (lockoutUntil && now >= lockoutUntil) {
            attempts = 0;
            lockoutUntil = 0;
            sessionStorage.removeItem('auth_attempts');
            sessionStorage.removeItem('auth_lockout_until');
            clearErrors();
            if (submitBtn) submitBtn.disabled = false;
            if (usernameInput) usernameInput.disabled = false;
            if (passwordInput) passwordInput.disabled = false;
        }
        return false;
    }

    function showError(msg, focusInput = null) {
        if (!errorBanner) return;
        errorBanner.textContent = msg;
        errorBanner.style.display = 'block';
        if (focusInput) {
            focusInput.classList.add('error');
            focusInput.focus();
        }
    }

    function clearErrors() {
        if (!errorBanner) return;
        errorBanner.style.display = 'none';
        errorBanner.textContent = '';
        if (usernameInput) usernameInput.classList.remove('error');
        if (passwordInput) passwordInput.classList.remove('error');
    }
});
