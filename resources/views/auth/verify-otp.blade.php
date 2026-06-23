@extends('layouts.app')

@section('content')
<style>
    .otp-card {
        border: none;
        border-radius: 30px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        animation: fadeInUp 0.6s ease;
        background: white;
    }
    
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .otp-card .card-header {
        background: #000000;
        padding: 20px;
        border: none;
    }
    
    .otp-card .card-header h4 {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 5px;
        color: white;
    }
    
    .otp-card .card-header small {
        font-size: 12px;
        opacity: 0.8;
        color: rgba(255,255,255,0.7);
    }
    
    .otp-card .card-body {
        padding: 30px;
        background: white;
        text-align: center;
    }
    
    .otp-input-group {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin: 25px 0;
    }
    
    .otp-input {
        width: 50px;
        height: 60px;
        text-align: center;
        font-size: 24px;
        font-weight: bold;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
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
        border-radius: 10px;
        padding: 12px;
        font-size: 16px;
        font-weight: 600;
        transition: all 0.3s ease;
        color: white;
        width: 100%;
        margin-top: 20px;
    }
    
    .btn-verify-otp:hover {
        background: #dc3545;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }
    
    .btn-resend-otp {
        background: transparent;
        border: none;
        color: #dc3545;
        font-weight: 500;
        text-decoration: underline;
        cursor: pointer;
        margin-top: 15px;
    }
    
    .btn-resend-otp:hover {
        color: #000000;
    }
    
    .timer {
        font-size: 14px;
        color: #666;
        margin-top: 10px;
    }
    
    .timer span {
        font-weight: bold;
        color: #dc3545;
    }
    
    .alert {
        border-radius: 10px;
        margin-bottom: 15px;
        padding: 12px 15px;
        font-size: 14px;
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
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
    }
    
    .test-otp-box {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: 2px solid #1e7e34;
        border-radius: 10px;
        padding: 20px;
        margin: 15px 0 20px 0;
        color: white;
    }
    
    .test-otp-box .otp-code {
        font-size: 40px;
        font-weight: bold;
        color: #fff;
        letter-spacing: 10px;
        background: rgba(255,255,255,0.2);
        padding: 10px 25px;
        border-radius: 8px;
        display: inline-block;
        margin: 8px 0;
    }
    
    .copy-btn {
        background: rgba(255,255,255,0.3);
        border: none;
        color: white;
        padding: 5px 15px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 12px;
        transition: all 0.3s;
    }
    
    .copy-btn:hover {
        background: rgba(255,255,255,0.5);
    }
    
    @media (max-width: 576px) {
        .otp-input {
            width: 40px;
            height: 50px;
            font-size: 20px;
        }
        .otp-card .card-body {
            padding: 20px;
        }
        .test-otp-box .otp-code {
            font-size: 28px;
            letter-spacing: 5px;
            padding: 8px 15px;
        }
    }
</style>

<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card otp-card">
            <div class="card-header text-center">
                <i class="fas fa-shield-alt" style="font-size: 28px; margin-bottom: 8px; color: white;"></i>
                <h4><i class="fas fa-check-circle"></i> Verify Your Account</h4>
                <small>Enter the OTP to complete registration</small>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show">
                        <i class="fas fa-exclamation-triangle"></i> {{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

          

                <div class="phone-info">
                    <i class="fas fa-phone me-2"></i>
                    <strong>OTP sent to:</strong> {{ $user->phone }}
                </div>

                <p class="text-muted">Enter the 6-digit OTP</p>

                <form method="POST" action="{{ route('verify.otp') }}" id="otpForm">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    
                    <div class="otp-input-group">
                        <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required autofocus>
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
                    <a href="{{ route('login') }}" class="text-decoration-none">
                        <i class="fas fa-arrow-left me-1"></i> Back to Login
                    </a>
                </div>
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

    inputs[0].focus();

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
        
        fetch('{{ route("resend.otp") }}', {
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
                inputs[0].focus();
                otpValue.value = '';
                location.reload();
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