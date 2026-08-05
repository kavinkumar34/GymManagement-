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

        /* ===== OTP WRAPPER ===== */
        .otp-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            padding: 20px;
        }

        /* ===== OTP CARD ===== */
        .otp-card {
            border: 1px solid var(--line);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-card);
            animation: fadeInUp 0.5s ease;
            background: white;
            max-width: 400px;
            width: 100%;
            margin: 0 auto;
            transition: all 0.3s;
        }

        .otp-card:hover {
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

        .otp-card .card-header {
            background: var(--ink);
            padding: 22px 20px 18px;
            border: none;
            text-align: center;
            border-bottom: 3px solid var(--signal);
        }

        .otp-card .card-header .header-icon {
            font-size: 28px;
            color: var(--signal);
            margin-bottom: 6px;
            display: block;
        }

        .otp-card .card-header h4 {
            font-family: var(--font-display);
            font-size: 20px;
            font-weight: 400;
            margin-bottom: 3px;
            color: white;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .otp-card .card-header small {
            font-size: 11px;
            opacity: 0.7;
            color: rgba(255,255,255,0.6);
            font-weight: 400;
        }

        .otp-card .card-body {
            padding: 25px 28px 28px;
            background: white;
            text-align: center;
        }

        /* ===== OTP INPUT ===== */
        .otp-input-group {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin: 20px 0;
        }

        .otp-input {
            width: 42px;
            height: 50px;
            text-align: center;
            font-size: 20px;
            font-weight: 700;
            border: 2px solid var(--line);
            border-radius: var(--radius-sm);
            transition: all 0.3s ease;
            font-family: var(--font-body);
            color: var(--ink);
            background: white;
        }

        .otp-input:focus {
            border-color: var(--signal);
            box-shadow: 0 0 0 0.2rem rgba(255, 68, 5, 0.25);
            outline: none;
        }

        /* ===== BUTTONS ===== */
        .btn-verify-otp {
            background: var(--signal);
            border: none;
            border-radius: var(--radius-sm);
            padding: 10px;
            font-size: 14px;
            font-weight: 700;
            transition: all 0.3s ease;
            color: white;
            width: 100%;
            margin-top: 15px;
            height: 42px;
            letter-spacing: 0.5px;
            font-family: var(--font-body);
            text-transform: uppercase;
        }

        .btn-verify-otp:hover {
            background: var(--signal-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 68, 5, 0.3);
            color: white;
        }

        .btn-verify-otp:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .btn-verify-otp i {
            margin-right: 6px;
        }

        .btn-resend-otp {
            background: transparent;
            border: none;
            color: var(--signal);
            font-weight: 700;
            text-decoration: underline;
            cursor: pointer;
            margin-top: 12px;
            font-size: 13px;
            font-family: var(--font-body);
            transition: all 0.3s;
        }

        .btn-resend-otp:hover {
            color: var(--signal-dark);
        }

        .btn-resend-otp:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .btn-resend-otp i {
            margin-right: 4px;
        }

        /* ===== TIMER ===== */
        .timer {
            font-size: 13px;
            color: var(--steel);
            margin-top: 8px;
            font-weight: 500;
        }

        .timer span {
            font-weight: 700;
            color: var(--signal);
        }

        /* ===== PHONE INFO ===== */
        .phone-info {
            background: var(--fog);
            padding: 10px 15px;
            border-radius: var(--radius-sm);
            margin-bottom: 15px;
            font-size: 13px;
            font-weight: 500;
            color: var(--ink);
            border: 1px solid var(--line);
        }

        .phone-info i {
            color: var(--signal);
            margin-right: 6px;
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

        .alert-warning {
            background-color: #fff3cd;
            border-color: #ffc107;
            color: #856404;
        }

        /* ===== LINKS ===== */
        .back-link {
            color: var(--signal);
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .back-link:hover {
            color: var(--signal-dark);
            text-decoration: underline;
        }

        .back-link i {
            margin-right: 4px;
        }

        /* ===== MISC ===== */
        .text-muted {
            font-size: 12px !important;
            color: var(--steel) !important;
            font-weight: 400;
        }

        .mt-3 {
            margin-top: 12px !important;
        }

        .mt-4 {
            margin-top: 15px !important;
        }

        .mb-0 {
            margin-bottom: 0 !important;
        }

        .fas, .far {
            margin-right: 4px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 576px) {
            .otp-wrapper {
                min-height: 70vh;
                padding: 10px;
            }

            .otp-card {
                max-width: 100%;
                border-radius: var(--radius-md);
            }

            .otp-card .card-body {
                padding: 18px 18px 20px;
            }

            .otp-card .card-header {
                padding: 16px 15px 14px;
            }

            .otp-card .card-header h4 {
                font-size: 18px;
            }

            .otp-input {
                width: 36px;
                height: 44px;
                font-size: 18px;
                gap: 6px;
            }

            .btn-verify-otp {
                height: 40px;
                font-size: 13px;
                padding: 8px;
            }

            .phone-info {
                font-size: 12px;
                padding: 8px 12px;
            }

            .otp-input-group {
                gap: 5px;
                margin: 15px 0;
            }

            .otp-card .card-header .header-icon {
                font-size: 22px;
            }
        }

        @media (max-width: 400px) {
            .otp-card .card-body {
                padding: 14px 14px 16px;
            }

            .otp-card .card-header h4 {
                font-size: 16px;
            }

            .otp-input {
                width: 30px;
                height: 38px;
                font-size: 16px;
            }

            .btn-verify-otp {
                height: 38px;
                font-size: 12px;
            }

            .otp-input-group {
                gap: 4px;
            }
        }
    </style>

    <div class="otp-wrapper">
        <div class="card otp-card">
            <div class="card-header">
                <span class="header-icon"><i class="fas fa-shield-alt"></i></span>
                <h4>Verify Account</h4>
                <small>Enter the OTP to complete registration</small>
                <div class="energy-stripe mx-auto" style="margin-top: 12px;"></div>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show">
                        <i class="fas fa-exclamation-triangle"></i> {{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="phone-info">
                    <i class="fas fa-phone me-2"></i>
                    <strong>OTP sent to:</strong> {{ $user->phone }}
                </div>

                <p class="text-muted mb-0">Enter the 6-digit OTP</p>

                <form method="POST" action="{{ route('verify.otp') }}" id="otpForm">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">

                    <div class="otp-input-group">
                        <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required
                            autofocus>
                        <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                        <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                        <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                        <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                        <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                    </div>

                    <input type="hidden" name="otp" id="otpValue">

                    <button type="submit" class="btn-verify-otp" id="verifyBtn">
                        <i class="fas fa-check-circle me-2"></i>Verify OTP
                    </button>
                </form>

                <div class="timer" id="timerDisplay">
                    <i class="fas fa-clock me-1"></i> Resend OTP in <span id="timer">60</span> seconds
                </div>

                <button type="button" class="btn-resend-otp" id="resendBtn" style="display: none;" onclick="resendOTP()">
                    <i class="fas fa-redo me-1"></i> Resend OTP
                </button>

                <div class="mt-3">
                    <a href="{{ route('login') }}" class="back-link">
                        <i class="fas fa-arrow-left me-1"></i> Back to Login
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.otp-input');
            const form = document.getElementById('otpForm');
            const otpValue = document.getElementById('otpValue');
            const verifyBtn = document.getElementById('verifyBtn');
            const timerDisplay = document.getElementById('timerDisplay');
            const timerSpan = document.getElementById('timer');
            const resendBtn = document.getElementById('resendBtn');

            let timer = 60;
            let timerInterval;

            // Focus first input
            if (inputs.length > 0) {
                inputs[0].focus();
            }

            // Auto-dismiss alerts
            document.querySelectorAll('.alert').forEach(function(alert) {
                setTimeout(function() {
                    const closeBtn = alert.querySelector('.btn-close');
                    if (closeBtn) {
                        closeBtn.click();
                    }
                }, 5000);
            });

            inputs.forEach((input, index) => {
                input.addEventListener('input', function(e) {
                    this.value = this.value.replace(/[^0-9]/g, '');

                    if (this.value.length === 1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                    updateOTPValue();
                });

                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && this.value.length === 0 && index > 0) {
                        inputs[index - 1].focus();
                    }
                });

                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const paste = (e.clipboardData || window.clipboardData).getData('text');
                    const digits = paste.replace(/[^0-9]/g, '').slice(0, 6);

                    digits.split('').forEach((digit, i) => {
                        if (i < inputs.length) {
                            inputs[i].value = digit;
                        }
                    });

                    if (digits.length > 0) {
                        const lastIndex = Math.min(digits.length - 1, inputs.length - 1);
                        inputs[lastIndex].focus();
                    }
                    updateOTPValue();
                });
            });

            function updateOTPValue() {
                let otp = '';
                inputs.forEach(input => {
                    otp += input.value;
                });
                otpValue.value = otp;
            }

            form.addEventListener('submit', function(e) {
                updateOTPValue();
                if (otpValue.value.length !== 6) {
                    e.preventDefault();
                    alert('Please enter complete 6-digit OTP');
                    return false;
                }
                verifyBtn.disabled = true;
                verifyBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Verifying...';
            });

            function startTimer() {
                timer = 60;
                timerSpan.textContent = timer;
                timerDisplay.style.display = 'block';
                resendBtn.style.display = 'none';

                clearInterval(timerInterval);
                timerInterval = setInterval(() => {
                    timer--;
                    timerSpan.textContent = timer;

                    if (timer <= 0) {
                        clearInterval(timerInterval);
                        timerDisplay.style.display = 'none';
                        resendBtn.style.display = 'inline-block';
                    }
                }, 1000);
            }

            startTimer();

            window.resendOTP = function() {
                resendBtn.disabled = true;
                resendBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Sending...';

                fetch('{{ route('resend.otp') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            user_id: '{{ $user->id }}'
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message || 'OTP resent successfully!');
                            startTimer();
                            inputs.forEach(input => input.value = '');
                            if (inputs.length > 0) {
                                inputs[0].focus();
                            }
                            otpValue.value = '';
                        } else {
                            alert(data.error || 'Failed to resend OTP');
                        }
                    })
                    .catch(error => {
                        alert('Error sending OTP. Please try again.');
                    })
                    .finally(() => {
                        resendBtn.disabled = false;
                        resendBtn.innerHTML = '<i class="fas fa-redo me-1"></i> Resend OTP';
                    });
            };
        });
    </script>
@endsection