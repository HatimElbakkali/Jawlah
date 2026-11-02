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
                    const res = await fetch('/employeeLogin', {
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