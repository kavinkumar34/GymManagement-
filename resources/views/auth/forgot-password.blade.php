@extends('layouts.app')

@section('content')
<style>
    .forgot-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 70vh;
        padding: 20px;
    }

    .forgot-card {
        max-width: 420px;
        width: 100%;
        border: 1px solid var(--line);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-card);
        background: white;
    }

    .forgot-card .card-header {
        background: var(--ink);
        padding: 22px 20px 18px;
        border: none;
        text-align: center;
        border-bottom: 3px solid var(--signal);
    }

    .forgot-card .card-header .header-icon {
        font-size: 28px;
        color: var(--signal);
        margin-bottom: 6px;
        display: block;
    }

    .forgot-card .card-header h4 {
        font-family: var(--font-display);
        font-size: 20px;
        font-weight: 400;
        color: white;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .forgot-card .card-header small {
        font-size: 11px;
        opacity: 0.7;
        color: rgba(255,255,255,0.6);
    }

    .forgot-card .card-body {
        padding: 25px 28px 28px;
    }

    /* Enhanced Send Reset Link Button */
    .btn-send-reset {
        background: var(--signal);
        border: none;
        border-radius: var(--radius-sm);
        padding: 10px 20px;
        font-size: 14px;
        font-weight: 700;
        transition: all 0.3s ease;
        color: white;
        width: 100%;
        letter-spacing: 0.5px;
        height: 44px;
        font-family: var(--font-body);
        text-transform: uppercase;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-send-reset::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: all 0.5s ease;
    }

    .btn-send-reset:hover::before {
        left: 100%;
    }

    .btn-send-reset:hover {
        background: var(--signal-dark);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(255, 68, 5, 0.3);
        color: white;
    }

    .btn-send-reset:active {
        transform: scale(0.97);
    }

    .btn-send-reset i {
        font-size: 16px;
    }

    /* Loading state */
    .btn-send-reset.loading {
        pointer-events: none;
        opacity: 0.8;
    }

    .btn-send-reset .spinner {
        display: none;
        width: 18px;
        height: 18px;
        border: 2px solid rgba(255,255,255,0.3);
        border-top: 2px solid white;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    .btn-send-reset.loading .spinner {
        display: inline-block;
    }

    .btn-send-reset.loading .btn-text {
        display: none;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .back-to-login {
        color: var(--signal);
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s ease;
    }

    .back-to-login:hover {
        color: var(--signal-dark);
        text-decoration: underline;
    }

    /* Responsive */
    @media (max-width: 576px) {
        .forgot-card .card-body {
            padding: 18px 18px 20px;
        }
        
        .btn-send-reset {
            height: 40px;
            font-size: 13px;
        }
    }
</style>

<div class="forgot-wrapper">
    <div class="card forgot-card">
        <div class="card-header">
            <span class="header-icon"><i class="fas fa-key"></i></span>
            <h4>Forgot Password</h4>
            <small>Enter your email to receive reset link</small>
            <div class="energy-stripe mx-auto" style="margin-top: 12px;"></div>
        </div>
        <div class="card-body">
            @if(session('error'))
                <div class="alert-custom alert-danger">
                    <span class="alert-icon"><i class="fas fa-exclamation-circle"></i></span>
                    <span class="alert-content">{{ session('error') }}</span>
                    <button type="button" class="alert-close" onclick="this.parentElement.remove()">&times;</button>
                </div>
            @endif

            @if(session('success'))
                <div class="alert-custom alert-success">
                    <span class="alert-icon"><i class="fas fa-check-circle"></i></span>
                    <span class="alert-content">{{ session('success') }}</span>
                    <button type="button" class="alert-close" onclick="this.parentElement.remove()">&times;</button>
                </div>
            @endif

            <form method="POST" action="{{ route('password.send') }}" id="forgotPasswordForm">
                @csrf
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-envelope"></i>Email Address</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                           value="{{ old('email') }}" placeholder="your@email.com" required autofocus>
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <small class="text-muted mt-2 d-block">
                        <i class="fas fa-info-circle"></i> We'll send a password reset link to this email
                    </small>
                </div>
                
                <button type="submit" class="btn-send-reset" id="sendResetBtn">
                    <span class="spinner"></span>
                    <span class="btn-text"><i class="fas fa-paper-plane"></i> Send Reset Link</span>
                </button>
                
                <div class="text-center mt-3">
                    <a href="{{ route('login') }}" class="back-to-login" onclick="event.preventDefault(); window.location.href='{{ route('login') }}';">
                        <i class="fas fa-arrow-left"></i> Back to Login
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert-custom');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            alert.style.transition = 'all 0.5s ease';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(function() {
                alert.remove();
            }, 500);
        }, 5000);
    });

    // Form submission loading state
    const form = document.getElementById('forgotPasswordForm');
    const btn = document.getElementById('sendResetBtn');
    
    form.addEventListener('submit', function() {
        btn.classList.add('loading');
        btn.disabled = true;
    });
});
</script>
@endsection