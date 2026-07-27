@extends('layouts.app')

@section('content')
    <style>
        /* ===== CENTER CONTAINER - REDUCED WIDTH ===== */
        .otp-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            padding: 20px;
        }

        .otp-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.2);
            animation: fadeInUp 0.5s ease;
            background: white;
            max-width: 400px;
            /* REDUCED WIDTH */
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

        .otp-card .card-header {
            background: #000000;
            padding: 18px 20px 15px;
            border: none;
            text-align: center;
        }

        .otp-card .card-header h4 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 3px;
            color: white;
            letter-spacing: 0.5px;
        }

        .otp-card .card-header small {
            font-size: 11px;
            opacity: 0.7;
            color: rgba(255, 255, 255, 0.6);
        }

        .otp-card .card-body {
            padding: 22px 25px 25px;
            background: white;
            text-align: center;
        }

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
            font-weight: bold;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .otp-input:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
            outline: none;
        }

        .btn-verify-otp {
            background: #000000;
            border: none;
            border-radius: 8px;
            padding: 10px;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white;
            width: 100%;
            margin-top: 15px;
            height: 40px;
            letter-spacing: 0.5px;
        }

        .btn-verify-otp:hover {
            background: #dc3545;
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(220, 53, 69, 0.3);
        }

        .btn-verify-otp:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .btn-resend-otp {
            background: transparent;
            border: none;
            color: #dc3545;
            font-weight: 500;
            text-decoration: underline;
            cursor: pointer;
            margin-top: 12px;
            font-size: 13px;
        }

        .btn-resend-otp:hover {
            color: #000000;
        }

        .btn-resend-otp:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .timer {
            font-size: 13px;
            color: #666;
            margin-top: 8px;
        }

        .timer span {
            font-weight: bold;
            color: #dc3545;
        }

        .alert {
            border-radius: 8px;
            margin-bottom: 12px;
            padding: 8px 12px;
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

        .alert-warning {
            background-color: #fff3cd;
            border-color: #ffc107;
            color: #856404;
        }

        .phone-info {
            background: #f8f9fa;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 13px;
        }

        .phone-info i {
            color: #dc3545;
        }

        .test-otp-box {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: 2px solid #1e7e34;
            border-radius: 8px;
            padding: 15px;
            margin: 12px 0 15px 0;
            color: white;
        }

        .test-otp-box .otp-code {
            font-size: 32px;
            font-weight: bold;
            color: #fff;
            letter-spacing: 8px;
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 20px;
            border-radius: 6px;
            display: inline-block;
            margin: 6px 0;
        }

        .copy-btn {
            background: rgba(255, 255, 255, 0.3);
            border: none;
            color: white;
            padding: 4px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 11px;
            transition: all 0.3s;
        }

        .copy-btn:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        .text-muted {
            font-size: 12px !important;
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

        .back-link {
            color: #dc3545;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
        }

        .back-link:hover {
            color: #000000;
            text-decoration: underline;
        }

        /* Responsive - MOBILE FIRST */
        @media (max-width: 576px) {
            .otp-wrapper {
                min-height: 70vh;
                padding: 10px;
            }

            .otp-card {
                max-width: 100%;
                border-radius: 15px;
            }

            .otp-card .card-body {
                padding: 18px 18px 20px;
            }

            .otp-card .card-header {
                padding: 14px 15px 12px;
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
                height: 38px;
                font-size: 13px;
                padding: 7px;
            }

            .phone-info {
                font-size: 12px;
                padding: 8px 12px;
            }

            .test-otp-box .otp-code {
                font-size: 24px;
                letter-spacing: 4px;
                padding: 6px 12px;
            }

            .test-otp-box {
                padding: 12px;
            }

            .otp-input-group {
                gap: 5px;
                margin: 15px 0;
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
                height: 36px;
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
                <i class="fas fa-shield-alt" style="font-size: 24px; margin-bottom: 4px; color: white; display: block;"></i>
                <h4>Verify Account</h4>
                <small>Enter the OTP to complete registration</small>
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
