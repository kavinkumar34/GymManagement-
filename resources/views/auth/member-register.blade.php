@extends('layouts.app')

@section('content')
    <style>
        /* Remove navbar hiding - Now navbar will show */
        body {
            padding-top: 0 !important;
            margin-top: 0 !important;
            min-height: 100vh;
        }

        /* ===== CENTER CONTAINER - REDUCED WIDTH ===== */
        .register-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            padding: 20px;
        }

        /* Card Styling - REDUCED WIDTH */
        .user-register-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.2);
            animation: fadeInUp 0.5s ease;
            background: white;
            max-width: 420px;
            width: 100%;
            margin: 0 auto;
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
            background: #000000;
            padding: 18px 20px 15px;
            border: none;
            text-align: center;
        }

        .user-register-card .card-header h4 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 3px;
            color: white;
            letter-spacing: 0.5px;
        }

        .user-register-card .card-header small {
            font-size: 11px;
            opacity: 0.7;
            color: rgba(255, 255, 255, 0.6);
        }

        .user-register-card .card-body {
            padding: 22px 25px 25px;
            background: white;
        }

        /* Form Styling - COMPACT */
        .form-label {
            font-weight: 500;
            color: #333;
            margin-bottom: 4px;
            font-size: 12px;
            letter-spacing: 0.3px;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            border: 1.5px solid #e0e0e0;
            padding: 7px 12px;
            transition: all 0.3s ease;
            font-size: 13px;
            height: 38px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.15rem rgba(220, 53, 69, 0.2);
            outline: none;
        }

        .form-control.is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 11px;
            margin-top: 2px;
            display: block;
        }

        /* Password Input Group */
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
            color: #999;
            cursor: pointer;
            font-size: 14px;
            padding: 5px;
            transition: all 0.3s ease;
        }

        .password-toggle:hover {
            color: #dc3545;
        }

        /* Button Styling - COMPACT */
        .btn-user-register {
            background: #000000;
            border: none;
            border-radius: 8px;
            padding: 9px;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white;
            width: 100%;
            letter-spacing: 0.5px;
            height: 40px;
        }

        .btn-user-register:hover {
            background: #dc3545;
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(220, 53, 69, 0.3);
        }

        .btn-user-register:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        /* Login Link */
        .login-link {
            color: #dc3545;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            font-size: 12px;
        }

        .login-link:hover {
            color: #000000;
            text-decoration: underline;
        }

        /* Captcha Image - COMPACT */
        .captcha-img {
            border-radius: 8px;
            border: 1.5px solid #e0e0e0;
            cursor: pointer;
            transition: all 0.3s ease;
            height: 38px;
            width: 100%;
            object-fit: cover;
        }

        .captcha-img:hover {
            border-color: #dc3545;
            transform: scale(0.97);
        }

        /* Alert Styling - COMPACT */
        .alert {
            border-radius: 8px;
            margin-bottom: 12px;
            padding: 6px 12px;
            font-size: 12px;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }

        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }

        /* Phone input with country code - COMPACT */
        .phone-input-group {
            display: flex;
            align-items: center;
            gap: 0;
        }

        .phone-input-group .country-code {
            background: #f8f9fa;
            border: 1.5px solid #e0e0e0;
            border-right: none;
            border-radius: 8px 0 0 8px;
            padding: 7px 10px;
            font-size: 13px;
            font-weight: 500;
            color: #333;
            white-space: nowrap;
            min-width: 50px;
            text-align: center;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .phone-input-group .form-control {
            border-radius: 0 8px 8px 0;
            border-left: none;
            height: 38px;
        }

        .phone-input-group .form-control:focus {
            border-color: #dc3545;
        }

        .phone-input-group .form-control.is-invalid {
            border-color: #dc3545;
        }

        /* Icon spacing */
        .fas,
        .far {
            margin-right: 6px;
        }

        /* Form spacing - COMPACT */
        .mb-3 {
            margin-bottom: 12px !important;
        }

        .mt-4 {
            margin-top: 15px !important;
        }

        .mt-3 {
            margin-top: 12px !important;
        }

        .g-2 {
            gap: 6px !important;
        }

        .text-muted {
            font-size: 11px !important;
            margin-top: 3px !important;
        }

        /* Responsive - MOBILE FIRST */
        @media (max-width: 576px) {
            .register-wrapper {
                min-height: 70vh;
                padding: 10px;
            }

            .user-register-card {
                max-width: 100%;
                border-radius: 15px;
            }

            .user-register-card .card-body {
                padding: 18px 18px 20px;
            }

            .user-register-card .card-header {
                padding: 14px 15px 12px;
            }

            .user-register-card .card-header h4 {
                font-size: 18px;
            }

            .form-control,
            .form-select {
                height: 36px;
                font-size: 12px;
                padding: 5px 10px;
            }

            .btn-user-register {
                height: 38px;
                font-size: 13px;
                padding: 7px;
            }

            .captcha-img {
                height: 36px;
            }

            .form-label {
                font-size: 11px;
            }

            .mb-3 {
                margin-bottom: 10px !important;
            }

            .phone-input-group .country-code {
                height: 36px;
                font-size: 12px;
                padding: 5px 8px;
                min-width: 45px;
            }

            .phone-input-group .form-control {
                height: 36px;
            }

            .col-md-6 {
                padding: 0 10px;
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
                height: 36px;
            }

            .phone-input-group .country-code {
                font-size: 11px;
                min-width: 40px;
                padding: 4px 6px;
            }
        }
    </style>

    <div class="register-wrapper">
        <div class="card user-register-card">
            <div class="card-header">
                <i class="fas fa-dumbbell" style="font-size: 24px; margin-bottom: 4px; color: white; display: block;"></i>
                <h4>Create Account</h4>
                <small>Join our fitness community</small>
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

                    <!-- ===== PASSWORD FIELD ===== -->
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

                    <!-- ===== CONFIRM PASSWORD FIELD (ADD THIS) ===== -->
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

        // Phone number validation - only numbers
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
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const closeBtn = alert.querySelector('.btn-close');
                    if (closeBtn) {
                        closeBtn.click();
                    }
                }, 5000);
            });

            // ===== ADD CONFIRM PASSWORD VALIDATION =====
            form.addEventListener('submit', function(e) {
                // Validate phone number length
                const phone = document.querySelector('input[name="phone"]');
                if (phone && phone.value.length !== 10) {
                    e.preventDefault();
                    alert('Please enter a valid 10-digit phone number');
                    phone.focus();
                    return false;
                }

                // ===== VALIDATE PASSWORD MATCH =====
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

                // Re-enable button after 30 seconds if not redirected
                setTimeout(function() {
                    registerBtn.disabled = false;
                    registerBtn.innerHTML =
                        '<i class="fas fa-user-plus me-2"></i>Register & Verify OTP';
                }, 30000);
            });
        });

        // Enter key to submit form
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                const activeElement = document.activeElement;
                if (activeElement && activeElement.tagName === 'INPUT') {
                    const form = activeElement.closest('form');
                    if (form) {
                        e.preventDefault();
                        form.submit();
                    }
                }
            }
        });
    </script>
@endsection
