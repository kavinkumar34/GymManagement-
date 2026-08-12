@extends('layouts.app')

@section('content')
<style>
    /* ================================================================
       DESIGN TOKENS — FitForge Athletic System
       Display: Anton (poster-weight, athletic)
       Body:    Plus Jakarta Sans (clean, modern e-commerce)
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

    /* ===== PREVENT HORIZONTAL SCROLL ===== */
    html,
    body {
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

    /* Signature element: a repeating diagonal "energy stripe" */
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

    /* ===== LOGIN WRAPPER ===== */
    .login-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 80vh;
        padding: 20px;
    }

    /* ===== LOGIN CARD ===== */
    .user-login-card {
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

    .user-login-card:hover {
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

    .user-login-card .card-header {
        background: var(--ink);
        padding: 22px 20px 18px;
        border: none;
        text-align: center;
        border-bottom: 3px solid var(--signal);
    }

    .user-login-card .card-header .header-icon {
        font-size: 28px;
        color: var(--signal);
        margin-bottom: 6px;
        display: block;
    }

    .user-login-card .card-header h4 {
        font-family: var(--font-display);
        font-size: 20px;
        font-weight: 400;
        margin-bottom: 3px;
        color: white;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .user-login-card .card-header small {
        font-size: 11px;
        opacity: 0.7;
        color: rgba(255,255,255,0.6);
        font-weight: 400;
    }

    .user-login-card .card-body {
        padding: 25px 28px 28px;
        background: white;
    }

    /* ===== ALERT STYLES - INLINE INSIDE CARD ===== */
    .alert-custom {
        border-radius: var(--radius-sm);
        margin-bottom: 16px;
        padding: 12px 16px;
        font-size: 13px;
        font-weight: 600;
        border-left: 4px solid;
        display: flex;
        align-items: center;
        gap: 10px;
        animation: slideDown 0.3s ease;
        position: relative;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-custom .alert-icon {
        flex-shrink: 0;
        font-size: 16px;
        width: 24px;
        text-align: center;
    }

    .alert-custom .alert-content {
        flex: 1;
    }

    .alert-custom .alert-close {
        background: none;
        border: none;
        font-size: 18px;
        cursor: pointer;
        padding: 0 4px;
        transition: all 0.3s;
        flex-shrink: 0;
        color: inherit;
        opacity: 0.6;
    }

    .alert-custom .alert-close:hover {
        opacity: 1;
    }

    .alert-custom.alert-danger {
        background-color: var(--signal-tint);
        border-color: var(--signal);
        color: var(--signal-dark);
    }

    .alert-custom.alert-danger .alert-icon {
        color: var(--signal);
    }

    .alert-custom.alert-success {
        background-color: var(--success-tint);
        border-color: var(--success);
        color: var(--success);
    }

    .alert-custom.alert-success .alert-icon {
        color: var(--success);
    }

    .alert-custom.alert-info {
        background-color: var(--info-tint);
        border-color: var(--info);
        color: var(--info);
    }

    .alert-custom.alert-info .alert-icon {
        color: var(--info);
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

    .form-control {
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

    .form-control:focus {
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

    .invalid-feedback {
        color: var(--signal);
        font-size: 11px;
        font-weight: 500;
        margin-top: 3px;
    }

    /* ===== BUTTON ===== */
    .btn-user-login {
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

    .btn-user-login:hover {
        background: var(--signal-dark);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(255, 68, 5, 0.3);
        color: white;
    }

    .btn-user-login i {
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

    /* ===== LINKS ===== */
    .register-link {
        color: var(--signal);
        text-decoration: none;
        font-weight: 700;
        transition: all 0.3s ease;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .register-link:hover {
        color: var(--signal-dark);
        text-decoration: underline;
    }

    .register-link i {
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
        .login-wrapper {
            min-height: 70vh;
            padding: 10px;
        }

        .user-login-card {
            max-width: 100%;
            border-radius: var(--radius-md);
        }

        .user-login-card .card-body {
            padding: 18px 18px 20px;
        }

        .user-login-card .card-header {
            padding: 16px 15px 14px;
        }

        .user-login-card .card-header h4 {
            font-size: 18px;
        }

        .form-control {
            height: 38px;
            font-size: 12px;
            padding: 6px 10px;
        }

        .btn-user-login {
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

        .alert-custom {
            font-size: 12px;
            padding: 10px 14px;
        }
    }

    @media (max-width: 400px) {
        .user-login-card .card-body {
            padding: 14px 14px 16px;
        }

        .user-login-card .card-header h4 {
            font-size: 16px;
        }

        .btn-user-login {
            font-size: 12px;
            height: 38px;
        }

        .user-login-card .card-header .header-icon {
            font-size: 22px;
        }

        .alert-custom {
            font-size: 11px;
            padding: 8px 12px;
        }
    }
</style>

<div class="login-wrapper">
    <div class="card user-login-card">
        <div class="card-header">
            <span class="header-icon"><i class="fas fa-dumbbell"></i></span>
            <h4>Welcome Back</h4>
            <small>Sign in to your account</small>
            <div class="energy-stripe mx-auto" style="margin-top: 12px;"></div>
        </div>
        <div class="card-body">
            <!-- ===== INLINE ALERT - ONLY INSIDE CARD ===== -->
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

            @if($errors->any() && !session('error'))
                <div class="alert-custom alert-danger">
                    <span class="alert-icon"><i class="fas fa-exclamation-circle"></i></span>
                    <span class="alert-content">
                        @foreach($errors->all() as $error)
                            {{ $error }}{{ !$loop->last ? ', ' : '' }}
                        @endforeach
                    </span>
                    <button type="button" class="alert-close" onclick="this.parentElement.remove()">&times;</button>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-envelope"></i>Email Address</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                           value="{{ old('email') }}" placeholder="your@email.com" required autofocus>
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-lock"></i>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                </div>
                
                <div class="mb-3">  
                    <label class="form-label"><i class="fas fa-shield-alt"></i>Security Check</label>
                    <div class="row g-2 align-items-center">
                        <div class="col-7">
                            <input type="text" name="captcha" class="form-control" placeholder="Enter 6-digit code" required>
                        </div>
                        <div class="col-5">
                            <img src="{{ url('/captcha') }}" id="captcha-img" class="captcha-img" onclick="refreshCaptcha()" alt="Captcha">
                        </div>
                    </div>
                    <small class="text-muted"><i class="fas fa-sync-alt"></i> Click image to refresh</small>
                </div>
                <!-- Add this before the submit button -->
<div class="text-end mb-3">
    <a href="{{ route('password.request') }}" class="register-link" style="font-size: 13px;">
        <i class="fas fa-key"></i> Forgot Password?
    </a>
</div>
                
                <button type="submit" class="btn-user-login">
                    <i class="fas fa-sign-in-alt"></i>Sign In
                </button>
                
                <div class="text-center mt-3">
                    <a href="{{ route('member.register') }}" class="register-link">
                        <i class="fas fa-user-plus"></i> Create New Account
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

// Auto-dismiss alerts after 5 seconds with smooth animation
document.addEventListener('DOMContentLoaded', function() {
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
});
</script>
@endsection