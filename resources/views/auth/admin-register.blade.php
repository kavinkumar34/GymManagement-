@extends('layouts.app')

@section('content')
<style>
    /* Hide navbar and footer completely */
    nav.navbar, .navbar, .admin-sidebar, footer, .footer {
        display: none !important;
    }
    
    /* REMOVE SCROLLBAR - No scroll at all */
    html, body {
        overflow: hidden !important;
        height: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    
    body {
        padding-top: 0 !important;
        margin-top: 0 !important;
        background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        overflow: hidden;
        min-height: 100vh;
    }
    
    main.py-4 {
        padding: 0 !important;
        margin: 0 !important;
    }
    
    /* Override any admin sidebar that might sneak in */
    .admin-sidebar, .admin-main-content {
        display: none !important;
    }
    
    /* Container - No scroll */
    .register-container {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        margin: 0;
        padding: 0;
    }
    
    /* Card Styling - Compact to fit without scroll */
    .admin-reg-card {
        border: none;
        border-radius: 30px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        animation: fadeInUp 0.6s ease;
        background: white;
        width: 100%;
        max-width: 550px;
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
    
    .admin-reg-card .card-header {
        background: #000000;
        padding: 15px 20px;
        border: none;
    }
    
    .admin-reg-card .card-header h4 {
        font-size: 22px;
        font-weight: 600;
        margin-bottom: 3px;
        color: white;
    }
    
    .admin-reg-card .card-header small {
        font-size: 11px;
        opacity: 0.8;
        color: rgba(255,255,255,0.7);
    }
    
    .admin-reg-card .card-header i {
        font-size: 28px;
    }
    
    .admin-reg-card .card-body {
        padding: 20px 25px;
        background: white;
    }
    
    /* Form Styling - Compact */
    .form-label {
        font-weight: 500;
        color: #000000;
        margin-bottom: 4px;
        font-size: 13px;
    }
    
    .form-control {
        border-radius: 8px;
        border: 2px solid #e0e0e0;
        padding: 6px 10px;
        transition: all 0.3s ease;
        font-size: 13px;
    }
    
    .form-control:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        outline: none;
    }
    
    /* Button Styling */
    .btn-admin-register {
        background: #000000;
        border: none;
        border-radius: 8px;
        padding: 8px;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.3s ease;
        color: white;
        width: 100%;
    }
    
    .btn-admin-register:hover {
        background: #dc3545;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
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
    
    /* Captcha Image */
    .captcha-img {
        border-radius: 8px;
        border: 2px solid #e0e0e0;
        cursor: pointer;
        transition: all 0.3s ease;
        height: 38px;
        width: 100%;
        object-fit: cover;
    }
    
    .captcha-img:hover {
        border-color: #dc3545;
        transform: scale(0.98);
    }
    
    /* Alert Styling */
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
    
    /* Remove extra spacing - Compact */
    .mb-3 {
        margin-bottom: 10px !important;
    }
    
    .mt-4 {
        margin-top: 14px !important;
    }
    
    .mt-3 {
        margin-top: 10px !important;
    }
    
    .g-2 {
        gap: 6px;
    }
    
    .text-muted {
        font-size: 11px;
    }
    
    /* Responsive - Adjust for smaller screens */
    @media (max-width: 768px) {
        .admin-reg-card {
            max-width: 90%;
        }
        .admin-reg-card .card-body {
            padding: 15px 20px;
        }
        .admin-reg-card .card-header {
            padding: 12px 20px;
        }
        .admin-reg-card .card-header h4 {
            font-size: 20px;
        }
        .admin-reg-card .card-header i {
            font-size: 24px;
        }
        .form-control {
            padding: 5px 8px;
        }
        .btn-admin-register {
            padding: 6px;
        }
    }
    
    @media (max-width: 576px) {
        .admin-reg-card {
            max-width: 95%;
        }
        .admin-reg-card .card-body {
            padding: 12px 15px;
        }
        .form-label {
            font-size: 12px;
        }
        .form-control {
            font-size: 12px;
        }
        .mb-3 {
            margin-bottom: 8px !important;
        }
    }
    
    /* For very small screens, allow minimal scroll only if absolutely necessary */
    @media (max-width: 450px) {
        html, body {
            overflow: auto !important;
        }
        .register-container {
            position: relative;
            height: auto;
            min-height: 100vh;
            padding: 20px 0;
        }
    }

    /* Hide WhatsApp float button on admin pages */
.whatsapp-float, .whatsapp-tooltip {
    display: none !important;
}
</style>

<div class="register-container">
    <div class="col-md-6 col-lg-5" style="padding: 0 15px; width: 100%;">
        <div class="card admin-reg-card">
            <div class="card-header text-center">
                <i class="fas fa-dumbbell" style="font-size: 28px; margin-bottom: 5px; color: white;"></i>
                <h4><i class="fas fa-user-shield"></i> Admin Registration</h4>
                <small>Create Admin Account</small>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <p class="mb-0">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.register.submit') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-user me-2"></i>Full Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Enter your full name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-envelope me-2"></i>Email Address</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Enter your email" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-lock me-2"></i>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Create a password" required>
                        <small class="text-muted">Minimum 6 characters</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-lock me-2"></i>Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm your password" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-robot me-2"></i>Security Check</label>
                        <div class="row g-2 align-items-center">
                            <div class="col-7">
                                <input type="text" name="captcha" class="form-control" placeholder="Enter 6-digit code" required>
                            </div>
                            <div class="col-5">
                                <img src="{{ url('/captcha') }}" id="captcha-img" class="captcha-img" onclick="refreshCaptcha()">
                            </div>
                        </div>
                        <small class="text-muted mt-1 d-block"><i class="fas fa-sync-alt me-1"></i>Click on the image to refresh</small>
                    </div>
                    
                    <button type="submit" class="btn-admin-register">
                        <i class="fas fa-user-plus me-2"></i>Register Admin
                    </button>
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('admin.login') }}" class="login-link">
                            <i class="fas fa-sign-in-alt me-1"></i> Already have account? Admin Login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
function refreshCaptcha() {
    const img = document.getElementById('captcha-img');
    if (img) {
        img.src = '/captcha?' + Math.random();
    }
}
</script>