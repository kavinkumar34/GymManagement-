@extends('layouts.app')

@section('content')
    <style>
        /* ================================================================
           DESIGN TOKENS — FitForge Athletic System
        ================================================================ */
        @import url('https://fonts.googleapis.com/css2?family=Anton&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        :root {
            --ink: #14161A;
            --ink-soft: #2B2E34;
            --canvas: #FAF9F6;
            --fog: #EFEDE7;
            --steel: #6B7280;
            --line: #E4E1D8;
            --signal: #FF4405;
            --signal-dark: #D93A03;
            --signal-tint: #FFF1EC;
            --success: #16A34A;
            --success-tint: #E8F8ED;
            --info: #2563EB;
            --info-tint: #EAF1FE;
            --font-display: 'Anton', 'Arial Narrow', sans-serif;
            --font-body: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            --radius-lg: 18px;
            --radius-md: 12px;
            --radius-sm: 8px;
            --shadow-card: 0 1px 2px rgba(20,22,26,0.04), 0 8px 24px rgba(20,22,26,0.06);
            --shadow-card-hover: 0 18px 40px rgba(20,22,26,0.14);
        }

        html, body {
            overflow-x: hidden !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        body {
            font-family: var(--font-body);
            color: var(--ink);
            background: var(--canvas);
            min-height: 100vh;
        }

        .energy-stripe {
            height: 4px;
            width: 56px;
            border-radius: 3px;
            background: repeating-linear-gradient(
                -45deg,
                var(--signal) 0px,
                var(--signal) 6px,
                var(--ink) 6px,
                var(--ink) 12px
            );
        }

        /* ===== REGISTER WRAPPER ===== */
        .register-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            padding: 20px;
        }

        /* ===== REGISTER CARD ===== */
        .user-register-card {
            border: 1px solid var(--line);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-card);
            animation: fadeInUp 0.5s ease;
            background: white;
            max-width: 420px;
            width: 100%;
            margin: 0 auto;
            transition: all 0.3s;
        }

        .user-register-card:hover {
            box-shadow: var(--shadow-card-hover);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .user-register-card .card-header {
            background: var(--ink);
            padding: 22px 20px 18px;
            border: none;
            text-align: center;
            border-bottom: 3px solid var(--signal);
        }

        .user-register-card .card-header .header-icon {
            font-size: 28px;
            color: var(--signal);
            margin-bottom: 6px;
            display: block;
        }

        .user-register-card .card-header h4 {
            font-family: var(--font-display);
            font-size: 20px;
            font-weight: 400;
            margin-bottom: 3px;
            color: white;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .user-register-card .card-header small {
            font-size: 11px;
            opacity: 0.7;
            color: rgba(255,255,255,0.6);
            font-weight: 400;
        }

        .user-register-card .card-body {
            padding: 25px 28px 28px;
            background: white;
        }

        /* ===== FORM STYLES ===== */
        .form-label {
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 4px;
            font-size: 12px;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }

        .form-label i {
            color: var(--signal);
            margin-right: 4px;
        }

        .form-control,
        .form-select {
            border-radius: var(--radius-sm);
            border: 1.5px solid var(--line);
            padding: 8px 12px;
            transition: all 0.3s ease;
            font-size: 13px;
            height: 40px;
            font-family: var(--font-body);
            background: white;
            color: var(--ink);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--signal);
            box-shadow: 0 0 0 0.2rem rgba(255, 68, 5, 0.2);
            outline: none;
        }

        .form-control::placeholder {
            color: var(--steel);
            font-weight: 400;
        }

        .form-control.is-invalid {
            border-color: var(--signal);
        }

        .form-select {
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%236B7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 12px;
        }

        .form-select option {
            color: var(--ink);
            background: white;
            padding: 8px 12px;
        }

        .form-select option:checked {
            background: var(--signal-tint);
            color: var(--ink);
        }

        .invalid-feedback {
            color: var(--signal);
            font-size: 11px;
            font-weight: 500;
            margin-top: 3px;
        }

        /* ===== PASSWORD TOGGLE ===== */
        .password-wrapper {
            position: relative;
        }

        .password-wrapper .form-control {
            padding-right: 40px;
        }

        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--steel);
            cursor: pointer;
            font-size: 14px;
            padding: 5px;
            transition: all 0.3s ease;
        }

        .password-toggle:hover {
            color: var(--signal);
        }

        /* ===== PHONE INPUT ===== */
        .phone-input-group {
            display: flex;
            align-items: center;
            gap: 0;
        }

        .phone-input-group .country-code {
            background: var(--fog);
            border: 1.5px solid var(--line);
            border-right: none;
            border-radius: var(--radius-sm) 0 0 var(--radius-sm);
            padding: 8px 12px;
            font-size: 13px;
            font-weight: 600;
            color: var(--ink);
            white-space: nowrap;
            min-width: 50px;
            text-align: center;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .phone-input-group .form-control {
            border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
            border-left: none;
            height: 40px;
        }

        .phone-input-group .form-control:focus {
            border-color: var(--signal);
        }

        /* ===== BUTTON ===== */
        .btn-user-register {
            background: var(--signal);
            border: none;
            border-radius: var(--radius-sm);
            padding: 10px;
            font-size: 14px;
            font-weight: 700;
            transition: all 0.3s ease;
            color: white;
            width: 100%;
            letter-spacing: 0.5px;
            height: 42px;
            font-family: var(--font-body);
            text-transform: uppercase;
        }

        .btn-user-register:hover {
            background: var(--signal-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 68, 5, 0.3);
            color: white;
        }

        .btn-user-register:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .btn-user-register i {
            margin-right: 6px;
        }

        /* ===== CAPTCHA ===== */
        .captcha-img {
            border-radius: var(--radius-sm);
            border: 1.5px solid var(--line);
            cursor: pointer;
            transition: all 0.3s ease;
            height: 40px;
            width: 100%;
            object-fit: cover;
        }

        .captcha-img:hover {
            border-color: var(--signal);
            transform: scale(0.97);
        }

        /* ===== ALERT ===== */
        .alert {
            border-radius: var(--radius-sm);
            margin-bottom: 12px;
            padding: 8px 12px;
            font-size: 12px;
            font-weight: 500;
            border-left: 4px solid;
        }

        .alert-danger {
            background-color: var(--signal-tint);
            border-color: var(--signal);
            color: var(--signal-dark);
        }

        .alert-success {
            background-color: var(--success-tint);
            border-color: var(--success);
            color: var(--success);
        }

        /* ===== LINKS ===== */
        .login-link {
            color: var(--signal);
            text-decoration: none;
            font-weight: 700;
            transition: all 0.3s ease;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .login-link:hover {
            color: var(--signal-dark);
            text-decoration: underline;
        }

        .login-link i {
            margin-right: 4px;
        }

        /* ===== MISC ===== */
        .fas, .far {
            margin-right: 6px;
        }

        .mb-3 {
            margin-bottom: 14px !important;
        }

        .mt-4 {
            margin-top: 15px !important;
        }

        .mt-3 {
            margin-top: 12px !important;
        }

        .text-muted {
            font-size: 11px !important;
            margin-top: 3px !important;
            color: var(--steel) !important;
            font-weight: 400;
        }

        .g-2 {
            gap: 6px !important;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 576px) {
            .register-wrapper {
                min-height: 70vh;
                padding: 10px;
            }

            .user-register-card {
                max-width: 100%;
                border-radius: var(--radius-md);
            }

            .user-register-card .card-body {
                padding: 18px 18px 20px;
            }

            .user-register-card .card-header {
                padding: 16px 15px 14px;
            }

            .user-register-card .card-header h4 {
                font-size: 18px;
            }

            .form-control,
            .form-select {
                height: 38px;
                font-size: 12px;
                padding: 6px 10px;
            }

            .btn-user-register {
                height: 40px;
                font-size: 13px;
                padding: 8px;
            }

            .captcha-img {
                height: 38px;
            }

            .form-label {
                font-size: 11px;
            }

            .mb-3 {
                margin-bottom: 12px !important;
            }

            .phone-input-group .country-code {
                height: 38px;
                font-size: 12px;
                padding: 6px 10px;
                min-width: 45px;
            }

            .phone-input-group .form-control {
                height: 38px;
            }

            .user-register-card .card-header .header-icon {
                font-size: 22px;
            }
        }

        @media (max-width: 400px) {
            .user-register-card .card-body {
                padding: 14px 14px 16px;
            }

            .user-register-card .card-header h4 {
                font-size: 16px;
            }

            .btn-user-register {
                font-size: 12px;
                height: 38px;
            }

            .phone-input-group .country-code {
                font-size: 11px;
                min-width: 40px;
                padding: 4px 6px;
                height: 36px;
            }

            .phone-input-group .form-control {
                height: 36px;
            }

            .form-control,
            .form-select {
                height: 36px;
            }

            .captcha-img {
                height: 36px;
            }
        }
    </style>

    <div class="register-wrapper">
        <div class="card user-register-card">
            <div class="card-header">
                <span class="header-icon"><i class="fas fa-dumbbell"></i></span>
                <h4>Create Account</h4>
                <small>Join our fitness community</small>
                <div class="energy-stripe mx-auto" style="margin-top: 12px;"></div>
            </div>
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <p class="mb-0"><i class="fas fa-exclamation-circle"></i> {{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('register.submit') }}" id="registerForm">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-user"></i>Full Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" placeholder="Enter full name" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-envelope"></i>Email Address</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" placeholder="your@email.com" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-phone"></i>Phone Number</label>
                        <div class="phone-input-group">
                            <span class="country-code">+91</span>
                            <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone') }}" placeholder="9876543210" required maxlength="10"
                                pattern="[0-9]{10}">
                        </div>
                        @error('phone')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Enter 10-digit phone number</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-lock"></i>Password</label>
                        <div class="password-wrapper">
                            <input type="password" name="password" id="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Create password (min 6 chars)" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('password', this)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Minimum 6 characters</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-check-circle"></i>Confirm Password</label>
                        <div class="password-wrapper">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                placeholder="Confirm your password" required>
                            <button type="button" class="password-toggle"
                                onclick="togglePassword('password_confirmation', this)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-shield-alt"></i>Security Check</label>
                        <div class="row g-2 align-items-center">
                            <div class="col-7">
                                <input type="text" name="captcha"
                                    class="form-control @error('captcha') is-invalid @enderror"
                                    placeholder="Enter 6-digit code" required>
                                @error('captcha')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-5">
                                <img src="{{ url('/captcha') }}" id="captcha-img" class="captcha-img"
                                    onclick="refreshCaptcha()" alt="Captcha">
                            </div>
                        </div>
                        <small class="text-muted"><i class="fas fa-sync-alt"></i> Click image to refresh</small>
                    </div>

                    <button type="submit" class="btn-user-register" id="registerBtn">
                        <i class="fas fa-user-plus"></i>Register & Verify OTP
                    </button>

                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}" class="login-link">
                            <i class="fas fa-sign-in-alt"></i> Already have an account? Login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function refreshCaptcha() {
            const img = document.getElementById('captcha-img');
            if (img) {
                img.src = '/captcha?' + Math.random();
            }
        }

        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);
            const icon = button.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const phoneInput = document.querySelector('input[name="phone"]');
            if (phoneInput) {
                phoneInput.addEventListener('input', function(e) {
                    this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
                });
            }

            const form = document.getElementById('registerForm');
            const registerBtn = document.getElementById('registerBtn');

            // Auto-dismiss alerts after 5 seconds
            document.querySelectorAll('.alert').forEach(function(alert) {
                setTimeout(function() {
                    const closeBtn = alert.querySelector('.btn-close');
                    if (closeBtn) {
                        closeBtn.click();
                    }
                }, 5000);
            });

            form.addEventListener('submit', function(e) {
                const phone = document.querySelector('input[name="phone"]');
                if (phone && phone.value.length !== 10) {
                    e.preventDefault();
                    alert('Please enter a valid 10-digit phone number');
                    phone.focus();
                    return false;
                }

                const password = document.getElementById('password');
                const passwordConfirm = document.getElementById('password_confirmation');

                if (password.value !== passwordConfirm.value) {
                    e.preventDefault();
                    alert('Password and Confirm Password do not match!');
                    passwordConfirm.focus();
                    return false;
                }

                if (password.value.length < 6) {
                    e.preventDefault();
                    alert('Password must be at least 6 characters long!');
                    password.focus();
                    return false;
                }

                registerBtn.disabled = true;
                registerBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Registering...';

                setTimeout(function() {
                    registerBtn.disabled = false;
                    registerBtn.innerHTML = '<i class="fas fa-user-plus me-2"></i>Register & Verify OTP';
                }, 30000);
            });
        });
    </script>
@endsection