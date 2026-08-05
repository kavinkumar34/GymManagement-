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

    .login-container {
        margin-top: 50px;
        margin-bottom: 20px;
    }
    
    .login-card {
        border: 1px solid var(--line);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-card);
        max-width: 420px;
        margin: 0 auto;
        transition: all 0.3s;
    }

    .login-card:hover {
        box-shadow: var(--shadow-card-hover);
    }
    
    .login-header {
        background: var(--ink);
        padding: 22px 20px 18px;
        text-align: center;
        border-bottom: 3px solid var(--signal);
    }

    .login-header .header-icon {
        font-size: 28px;
        color: var(--signal);
        margin-bottom: 6px;
        display: block;
    }
    
    .login-header h4 {
        font-family: var(--font-display);
        font-size: 20px;
        font-weight: 400;
        margin: 0;
        color: white;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .login-header h4 i {
        margin-right: 8px;
    }

    .login-header small {
        font-size: 11px;
        opacity: 0.7;
        color: rgba(255,255,255,0.6);
        font-weight: 400;
        display: block;
        margin-top: 2px;
    }
    
    .login-body {
        padding: 25px 28px 28px;
        background: white;
    }
    
    .login-body .form-label {
        font-size: 12px;
        margin-bottom: 4px;
        color: var(--ink);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    
    .login-body .form-label i {
        color: var(--signal);
        margin-right: 4px;
    }
    
    .login-body .input-group-text {
        background: var(--fog);
        border: 1.5px solid var(--line);
        border-right: none;
        color: var(--steel);
        font-size: 0.9rem;
        padding: 0 12px;
        border-radius: var(--radius-sm) 0 0 var(--radius-sm);
        height: 40px;
    }
    
    .login-body .form-control,
    .login-body .form-select {
        border: 1.5px solid var(--line);
        border-left: none;
        padding: 8px 12px;
        font-size: 13px;
        height: 40px;
        background-color: #ffffff;
        color: var(--ink);
        font-family: var(--font-body);
        border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
    }
    
    .login-body .form-control:focus,
    .login-body .form-select:focus {
        box-shadow: none;
        border-color: var(--signal);
        outline: none;
    }
    
    .login-body .form-select {
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%236B7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 12px;
        cursor: pointer;
    }

    .login-body .form-select option {
        padding: 10px 14px;
        color: var(--ink);
        background-color: #ffffff;
        font-size: 0.9rem;
        cursor: pointer;
    }

    .login-body .form-select option:checked {
        background-color: var(--signal-tint);
        color: var(--ink);
    }
    
    .login-body .input-group {
        margin-bottom: 0;
    }
    
    .login-body .mb-3 {
        margin-bottom: 14px !important;
    }
    
    .login-body .mb-4 {
        margin-bottom: 16px !important;
    }
    
    .login-body .text-muted {
        font-size: 11px !important;
        color: var(--steel) !important;
        font-weight: 400;
        margin-top: 3px;
    }
    
    .btn-login {
        background: var(--signal);
        color: white;
        border: none;
        padding: 10px;
        font-weight: 700;
        font-size: 14px;
        border-radius: var(--radius-sm);
        width: 100%;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: var(--font-body);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        height: 42px;
    }
    
    .btn-login:hover {
        background: var(--signal-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(255, 68, 5, 0.3);
        color: white;
    }
    
    .btn-login i {
        margin-right: 8px;
    }
    
    .login-footer {
        text-align: center;
        margin-top: 14px;
        padding-top: 12px;
        border-top: 1px solid var(--line);
    }
    
    .login-footer a {
        color: var(--steel);
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 500;
        transition: all 0.3s;
    }
    
    .login-footer a:hover {
        color: var(--signal);
    }

    .login-footer a i {
        margin-right: 4px;
    }
    
    .alert {
        padding: 10px 14px;
        font-size: 12px;
        margin-bottom: 12px;
        border-radius: var(--radius-sm);
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
    
    .invalid-feedback {
        font-size: 11px;
        color: var(--signal);
        font-weight: 500;
        display: block;
        margin-top: 3px;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 576px) {
        .login-card {
            max-width: 100%;
            border-radius: var(--radius-md);
        }

        .login-body {
            padding: 18px 18px 20px;
        }

        .login-header {
            padding: 16px 15px 14px;
        }

        .login-header h4 {
            font-size: 18px;
        }

        .login-header .header-icon {
            font-size: 22px;
        }

        .login-body .form-control,
        .login-body .form-select,
        .login-body .input-group-text {
            height: 38px;
            font-size: 12px;
        }

        .btn-login {
            height: 40px;
            font-size: 13px;
            padding: 8px;
        }
    }

    @media (max-width: 400px) {
        .login-body {
            padding: 14px 14px 16px;
        }

        .login-header h4 {
            font-size: 16px;
        }

        .btn-login {
            height: 38px;
            font-size: 12px;
        }

        .login-body .form-control,
        .login-body .form-select,
        .login-body .input-group-text {
            height: 36px;
            font-size: 11px;
        }
    }
</style>

<div class="container login-container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card login-card shadow-lg border-0">
                <div class="login-header">
                    <span class="header-icon"><i class="fas fa-user-check"></i></span>
                    <h4>Member / Trainer Login</h4>
                    <small>Access your fitness dashboard</small>
                    <div class="energy-stripe mx-auto" style="margin-top: 12px;"></div>
                </div>
                <div class="login-body">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('member.trainer.login.submit') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold"><i class="fas fa-envelope"></i> Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" placeholder="Enter your email" required autofocus>
                            </div>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold"><i class="fas fa-phone"></i> Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                <input type="tel" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Enter your registered phone number" required>
                            </div>
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="text-muted">Enter the phone number you registered with.</small>
                        </div>

                        <div class="mb-4">
                            <label for="role" class="form-label fw-bold"><i class="fas fa-user-tag"></i> Login As</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                <select name="role" id="role"
                                    class="form-select @error('role') is-invalid @enderror" required>
                                    <option value="">-- Select Role --</option>
                                    <option value="member" {{ old('role') == 'member' ? 'selected' : '' }}>👤 Member</option>
                                    <option value="trainer" {{ old('role') == 'trainer' ? 'selected' : '' }}>🏋️ Trainer</option>
                                </select>
                            </div>
                            @error('role')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn-login">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </button>
                    </form>

                    <div class="login-footer">
                        <a href="{{ route('home') }}">
                            <i class="fas fa-arrow-left me-1"></i> Back to Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.alert').forEach(function(alert) {
        setTimeout(function() {
            const closeBtn = alert.querySelector('.btn-close');
            if (closeBtn) {
                closeBtn.click();
            }
        }, 5000);
    });
});
</script>
@endsection