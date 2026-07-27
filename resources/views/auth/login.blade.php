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
    .login-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 80vh;
        padding: 20px;
    }
    
    /* Card Styling - REDUCED WIDTH */
    .user-login-card {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 50px rgba(0,0,0,0.2);
        animation: fadeInUp 0.5s ease;
        background: white;
        max-width: 400px;  /* REDUCED WIDTH */
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
    
    .user-login-card .card-header {
        background: #000000;
        padding: 18px 20px 15px;
        border: none;
        text-align: center;
    }
    
    .user-login-card .card-header h4 {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 3px;
        color: white;
        letter-spacing: 0.5px;
    }
    
    .user-login-card .card-header small {
        font-size: 11px;
        opacity: 0.7;
        color: rgba(255,255,255,0.6);
    }
    
    .user-login-card .card-body {
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
    
    .form-control {
        border-radius: 8px;
        border: 1.5px solid #e0e0e0;
        padding: 7px 12px;
        transition: all 0.3s ease;
        font-size: 13px;
        height: 38px;
    }
    
    .form-control:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.15rem rgba(220, 53, 69, 0.2);
        outline: none;
    }
    
    /* Button Styling - COMPACT */
    .btn-user-login {
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
    
    .btn-user-login:hover {
        background: #dc3545;
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(220, 53, 69, 0.3);
    }
    
    /* Register Link */
    .register-link {
        color: #dc3545;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        font-size: 12px;
    }
    
    .register-link:hover {
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
    
    /* Icon spacing */
    .fas, .far {
        margin-right: 6px;
    }
    
    /* Form spacing - COMPACT */
    .mb-3 {
        margin-bottom: 12px !important;
    }
    
    .mt-4 {
        margin-top: 15px !important;
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
        .login-wrapper {
            min-height: 70vh;
            padding: 10px;
        }
        .user-login-card {
            max-width: 100%;
            border-radius: 15px;
        }
        .user-login-card .card-body {
            padding: 18px 18px 20px;
        }
        .user-login-card .card-header {
            padding: 14px 15px 12px;
        }
        .user-login-card .card-header h4 {
            font-size: 18px;
        }
        .form-control {
            height: 36px;
            font-size: 12px;
            padding: 5px 10px;
        }
        .btn-user-login {
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
        .col-md-5 {
            padding: 0 10px;
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
            height: 36px;
        }
    }
</style>

<div class="login-wrapper">
    <div class="card user-login-card">
        <div class="card-header">
            <i class="fas fa-dumbbell" style="font-size: 24px; margin-bottom: 4px; color: white; display: block;"></i>
            <h4>Welcome Back</h4>
            <small>Sign in to your account</small>
        </div>
        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-envelope"></i>Email Address</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="your@email.com" required autofocus>
                    @error('email')
                        <span class="text-danger small">{{ $message }}</span>
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
                            <img src="{{ url('/captcha') }}" id="captcha-img" class="captcha-img" onclick="refreshCaptcha()">
                        </div>
                    </div>
                    <small class="text-muted"><i class="fas fa-sync-alt"></i> Click image to refresh</small>
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
</script>
@endsection