<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-bs-theme', savedTheme);
        })();
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Enterprise ERP</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #1A2420 0%, #26241F 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            margin: 0;
            color: #2B2622;
        }

        .auth-card {
            background: #FAF7F2;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.35);
            width: 100%;
            max-width: 440px;
            overflow: hidden;
            border: 1px solid #E8E2D9;
            position: relative;
        }

        .auth-header {
            background: #2F6B4F;
            padding: 2.25rem 2rem;
            color: #ffffff;
            text-align: center;
            position: relative;
        }

        .theme-toggle-login-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: #ffffff;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .theme-toggle-login-btn:hover {
            background: rgba(255, 255, 255, 0.35);
            transform: scale(1.05);
        }

        .auth-body {
            padding: 2rem;
        }

        .btn-cta {
            background-color: #C56A2E;
            border-color: #C56A2E;
            color: #ffffff;
            padding: 0.75rem 1.5rem;
            font-weight: 700;
            border-radius: 12px;
            transition: background 0.15s ease;
        }

        .btn-cta:hover {
            background-color: #AB5A25;
            border-color: #AB5A25;
            color: #ffffff;
        }

        .demo-btn {
            font-size: 0.78rem;
            padding: 0.4rem 0.65rem;
            border-radius: 8px;
            font-weight: 600;
        }

        /* Dark Mode Overrides for Login */
        [data-bs-theme="dark"] body {
            background: linear-gradient(135deg, #0B0F19 0%, #111827 100%) !important;
            color: #F8FAFC !important;
        }

        [data-bs-theme="dark"] .auth-card {
            background: #1F2937 !important;
            border-color: #374151 !important;
            color: #F8FAFC !important;
        }

        [data-bs-theme="dark"] .text-dark {
            color: #F8FAFC !important;
        }

        [data-bs-theme="dark"] .form-control,
        [data-bs-theme="dark"] .input-group-text {
            background-color: #111827 !important;
            border-color: #374151 !important;
            color: #F8FAFC !important;
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="auth-header">
            <button type="button" class="theme-toggle-login-btn" id="theme-toggle-btn" onclick="toggleTheme()" title="Toggle Dark/Light Mode">
                <i id="theme-toggle-icon" class="bi bi-moon-stars-fill"></i>
            </button>
            <div class="d-inline-flex align-items-center justify-content-center bg-white text-success rounded-3 p-2 mb-2 shadow-sm" style="width: 44px; height: 44px;">
                <i class="bi bi-tree-fill fs-3" style="color: #2F6B4F;"></i>
            </div>
            <h4 class="fw-bold mb-1">Enterprise ERP</h4>
            <p class="text-white-50 fs-7 mb-0">Sign in to your organic workspace portal</p>
        </div>

        <div class="auth-body">
            @if ($errors->any())
                <div class="alert alert-danger border-0 fs-7 py-2 mb-3" style="background-color: #FDF0ED; color: #B83A34;">
                    <i class="bi bi-exclamation-circle me-1"></i> {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold fs-7 text-dark">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                        <input type="email" name="email" id="email" class="form-control border-start-0" value="{{ old('email', 'admin@erp.com') }}" required autofocus>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label fw-bold fs-7 text-dark mb-0">Password</label>
                        <a href="#" class="fs-8 text-decoration-none" style="color: #6C63FF;">Forgot Password?</a>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text border-end-0"><i class="bi bi-lock text-muted"></i></span>
                        <input type="password" name="password" id="password" class="form-control border-start-0" value="12345678" required>
                    </div>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label fs-7 text-secondary" for="remember">Keep me signed in</label>
                </div>

                <button type="submit" class="btn btn-cta w-100 mb-3 shadow-sm">
                    Sign In <i class="bi bi-arrow-right ms-1"></i>
                </button>
            </form>

            <div class="border-top pt-3 mt-3">
                <div class="text-muted fs-8 fw-bold mb-2">QUICK DEMO LOGINS (Password: 12345678)</div>
                <div class="d-flex flex-wrap gap-1">
                    <button class="btn btn-outline-success demo-btn" onclick="fillLogin('admin@erp.com')">Super Admin</button>
                    <button class="btn btn-outline-warning demo-btn" onclick="fillLogin('hr@erp.com')">HR Admin</button>
                    <button class="btn btn-outline-secondary demo-btn" onclick="fillLogin('manager@erp.com')">Manager</button>
                    <button class="btn btn-outline-info demo-btn" onclick="fillLogin('employee@erp.com')">Employee</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function fillLogin(email) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = '12345678';
        }

        function applyThemeIcon(theme) {
            const icon = document.getElementById('theme-toggle-icon');
            if (!icon) return;
            if (theme === 'dark') {
                icon.className = 'bi bi-sun-fill text-warning';
            } else {
                icon.className = 'bi bi-moon-stars-fill text-white';
            }
        }

        function toggleTheme() {
            const currentTheme = document.documentElement.getAttribute('data-bs-theme') || 'light';
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            applyThemeIcon(newTheme);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const currentTheme = document.documentElement.getAttribute('data-bs-theme') || 'light';
            applyThemeIcon(currentTheme);
        });
    </script>
</body>
</html>
