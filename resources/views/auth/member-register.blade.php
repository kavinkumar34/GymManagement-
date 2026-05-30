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
    
    /* Move form UP */
    .row.justify-content-center {
        margin-top: 2rem !important;
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
    }
</style>

<div class="row justify-content-center mt-2">
    <div class="col-md-6">
        <div class="card user-register-card">
            <div class="card-header text-center">
                <i class="fas fa-dumbbell" style="font-size: 28px; margin-bottom: 8px; color: white;"></i>
                <h4><i class="fas fa-user-plus"></i> Member / Trainer Registration</h4>
                <small>Join our gym family today!</small>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <p class="mb-0">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('member.register.submit') }}">
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
                        <label class="form-label"><i class="fas fa-user-tag me-2"></i>Register As</label>
                        <select name="role" class="form-select" required>
                            <option value="member" {{ old('role') == 'member' ? 'selected' : '' }}>👤 Member</option>
                            <option value="trainer" {{ old('role') == 'trainer' ? 'selected' : '' }}>🏋️ Trainer</option>
                        </select>
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
                    
                    <button type="submit" class="btn-user-register">
                        <i class="fas fa-user-plus me-2"></i>Register
                    </button>
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('login') }}" class="login-link">
                            <i class="fas fa-sign-in-alt me-1"></i> Already have account? Login here
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