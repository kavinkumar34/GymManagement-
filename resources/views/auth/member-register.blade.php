@extends('layouts.app')

@section('content')
<style>
    /* Remove navbar hiding - Now navbar will show */
    body {
        padding-top: 0 !important;
        margin-top: 0 !important;
        min-height: 100vh;
    }
    
    /* Card Styling */
    .user-register-card {
        border: none;
        border-radius: 30px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        animation: fadeInUp 0.6s ease;
        background: white;
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
        padding: 20px 20px;
        border: none;
    }
    
    .user-register-card .card-header h4 {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 5px;
        color: white;
    }
    
    .user-register-card .card-header small {
        font-size: 12px;
        opacity: 0.8;
        color: rgba(255,255,255,0.7);
    }
    
    .user-register-card .card-body {
        padding: 25px 30px;
        background: white;
    }
    
    /* Form Styling */
    .form-label {
        font-weight: 500;
        color: #000000;
        margin-bottom: 5px;
        font-size: 13px;
    }
    
    .form-control, .form-select {
        border-radius: 10px;
        border: 2px solid #e0e0e0;
        padding: 8px 12px;
        transition: all 0.3s ease;
        font-size: 14px;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        outline: none;
    }
    
    .form-control.is-invalid {
        border-color: #dc3545;
    }
    
    .invalid-feedback {
        color: #dc3545;
        font-size: 12px;
        margin-top: 3px;
        display: block;
    }
    
    /* Password Input Group */
    .password-wrapper {
        position: relative;
    }
    
    .password-wrapper .form-control {
        padding-right: 45px;
    }
    
    .password-toggle {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #999;
        cursor: pointer;
        font-size: 1.1rem;
        padding: 5px;
        transition: all 0.3s ease;
    }
    
    .password-toggle:hover {
        color: #dc3545;
    }
    
    /* Button Styling */
    .btn-user-register {
        background: #000000;
        border: none;
        border-radius: 10px;
        padding: 10px;
        font-size: 15px;
        font-weight: 600;
        transition: all 0.3s ease;
        color: white;
        width: 100%;
    }
    
    .btn-user-register:hover {
        background: #dc3545;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
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
        font-size: 13px;
    }
    
    .login-link:hover {
        color: #000000;
        text-decoration: underline;
    }
    
    /* Captcha Image */
    .captcha-img {
        border-radius: 10px;
        border: 2px solid #e0e0e0;
        cursor: pointer;
        transition: all 0.3s ease;
        height: 42px;
        width: 100%;
        object-fit: cover;
    }
    
    .captcha-img:hover {
        border-color: #dc3545;
        transform: scale(0.98);
    }
    
    /* Alert Styling */
    .alert {
        border-radius: 10px;
        margin-bottom: 15px;
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
    
    /* Move form UP */
    .row.justify-content-center {
        margin-top: 2rem !important;
    }
    
    /* Phone input with country code */
    .phone-input-group {
        display: flex;
        align-items: center;
        gap: 0;
    }
    
    .phone-input-group .country-code {
        background: #f8f9fa;
        border: 2px solid #e0e0e0;
        border-right: none;
        border-radius: 10px 0 0 10px;
        padding: 8px 12px;
        font-size: 14px;
        font-weight: 500;
        color: #333;
        white-space: nowrap;
        min-width: 65px;
        text-align: center;
    }
    
    .phone-input-group .form-control {
        border-radius: 0 10px 10px 0;
        border-left: none;
    }
    
    .phone-input-group .form-control:focus {
        border-color: #dc3545;
    }
    
    .phone-input-group .form-control.is-invalid {
        border-color: #dc3545;
    }
    
    .phone-input-group .form-control.is-invalid + .invalid-feedback {
        display: block;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .row.justify-content-center {
            margin-top: 1rem !important;
        }
        .user-register-card .card-body {
            padding: 20px;
        }
        .user-register-card .card-header {
            padding: 15px 20px;
        }
        .user-register-card .card-header h4 {
            font-size: 20px;
        }
        .form-control, .form-select {
            padding: 6px 10px;
        }
        .btn-user-register {
            padding: 8px;
        }
        .phone-input-group .country-code {
            padding: 6px 8px;
            font-size: 12px;
            min-width: 55px;
        }
    }
    
    @media (max-width: 576px) {
        .row.justify-content-center {
            margin-top: 0.5rem !important;
        }
        .user-register-card .card-body {
            padding: 15px;
        }
        .form-label {
            font-size: 12px;
        }
        .col-md-6 {
            padding: 0 15px;
        }
        .phone-input-group .country-code {
            padding: 5px 6px;
            font-size: 11px;
            min-width: 45px;
        }
    }
</style>

<div class="row justify-content-center mt-2">
    <div class="col-md-6">
        <div class="card user-register-card">
            <div class="card-header text-center">
                <i class="fas fa-dumbbell" style="font-size: 28px; margin-bottom: 8px; color: white;"></i>
                <h4><i class="fas fa-user-plus"></i> Create Your Account</h4>
                <small>Join our gym family today!</small>
            </div>
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <p class="mb-0"><i class="fas fa-exclamation-circle"></i> {{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('register.submit') }}" id="registerForm">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-user me-2"></i>Full Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Enter your full name" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-envelope me-2"></i>Email Address</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Enter your email address" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-phone me-2"></i>Phone Number</label>
                        <div class="phone-input-group">
                            <span class="country-code">+91</span>
                            <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="9876543210" required maxlength="10" pattern="[0-9]{10}">
                        </div>
                        @error('phone')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Enter 10-digit phone number (e.g., 9876543210)</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-lock me-2"></i>Password</label>
                        <div class="password-wrapper">
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Create a password (min 6 characters)" required>
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
                        <label class="form-label"><i class="fas fa-lock me-2"></i>Confirm Password</label>
                        <div class="password-wrapper">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm your password" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', this)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-robot me-2"></i>Security Check</label>
                        <div class="row g-2 align-items-center">
                            <div class="col-7">
                                <input type="text" name="captcha" class="form-control @error('captcha') is-invalid @enderror" placeholder="Enter 6-digit code" required>
                                @error('captcha')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-5">
                                <img src="{{ url('/captcha') }}" id="captcha-img" class="captcha-img" onclick="refreshCaptcha()" alt="Captcha">
                            </div>
                        </div>
                        <small class="text-muted mt-1 d-block"><i class="fas fa-sync-alt me-1"></i>Click on the image to refresh</small>
                    </div>
                    
                    <button type="submit" class="btn-user-register" id="registerBtn">
                        <i class="fas fa-user-plus me-2"></i>Register & Verify OTP
                    </button>
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('login') }}" class="login-link">
                            <i class="fas fa-sign-in-alt me-1"></i> Already have an account? Login here
                        </a>
                    </div>
                </form>
            </div>
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

    form.addEventListener('submit', function(e) {
        // Validate phone number length
        const phone = document.querySelector('input[name="phone"]');
        if (phone && phone.value.length !== 10) {
            e.preventDefault();
            alert('Please enter a valid 10-digit phone number');
            phone.focus();
            return false;
        }
        
        registerBtn.disabled = true;
        registerBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Registering...';
        
        // Re-enable button after 30 seconds if not redirected
        setTimeout(function() {
            registerBtn.disabled = false;
            registerBtn.innerHTML = '<i class="fas fa-user-plus me-2"></i>Register & Verify OTP';
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