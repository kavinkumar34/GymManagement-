@extends('layouts.app')

@section('content')
<style>
    .login-container {
        margin-top: 50px;
        margin-bottom: 20px;
    }
    
    .login-card {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        max-width: 420px;
        margin: 0 auto;
    }
    
    .login-header {
        background: linear-gradient(135deg, #1a1a2e 0%, #2d3a4b 50%, #1a1a2e 100%);
        color: white;
        padding: 15px 20px;
        text-align: center;
    }
    
    .login-header h4 {
        font-size: 1.1rem;
        margin: 0;
        font-weight: 600;
    }
    
    .login-header h4 i {
        margin-right: 8px;
    }
    
    .login-body {
        padding: 20px 25px 20px;
    }
    
    .login-body .form-label {
        font-size: 0.85rem;
        margin-bottom: 4px;
        color: #1e293b;
    }
    
    .login-body .input-group-text {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-right: none;
        color: #94a3b8;
        font-size: 0.9rem;
        padding: 0 12px;
    }
    
    .login-body .form-control,
    .login-body .form-select {
        border: 1px solid #e2e8f0;
        border-left: none;
        padding: 8px 12px;
        font-size: 0.9rem;
        height: 40px;
        background-color: #ffffff;
        color: #1e293b;
    }
    
    .login-body .form-control:focus,
    .login-body .form-select:focus {
        box-shadow: none;
        border-color: #1a1a2e;
        border-left: none;
        outline: none;
    }
    
    .login-body .form-select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%231a1a2e' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 12px;
        appearance: none;
        -webkit-appearance: none;
        cursor: pointer;
    }
    
    /* ===== DROPDOWN STYLING - MATCH FORM INPUT COLOR ===== */
    /* Dropdown options - white background with dark text */
    .login-body .form-select option {
        padding: 10px 14px;
        color: #1e293b;
        background-color: #ffffff;
        font-size: 0.9rem;
        cursor: pointer;
        border-bottom: 1px solid #f1f5f9;
    }
    
    /* Hover effect - Light gray like form input focus */
    .login-body .form-select option:hover {
        background-color: #f1f5f9 !important;
        color: #1e293b !important;
    }
    
    /* REMOVED :checked dark color - now uses default white */
    .login-body .form-select option:checked {
        background-color: #ffffff !important;
        color: #1e293b !important;
    }
    
    /* For Firefox - keep white */
    .login-body .form-select option:checked {
        background-color: #ffffff !important;
        color: #1e293b !important;
    }
    
    /* For Chrome/Safari/Edge - keep white */
    .login-body .form-select:focus option:checked {
        background: #ffffff !important;
        color: #1e293b !important;
    }
    
    /* Remove forced dark color */
    select.form-select option:checked,
    select.form-select option:focus,
    select.form-select option:active {
        background: #ffffff !important;
        color: #1e293b !important;
    }
    
    /* For Webkit browsers - keep white */
    select.form-select::-webkit-listbox {
        background: #ffffff;
    }
    
    select.form-select::-webkit-listbox option:checked {
        background: #ffffff !important;
        color: #1e293b !important;
    }
    
    .login-body .input-group {
        margin-bottom: 0;
    }
    
    .login-body .mb-3 {
        margin-bottom: 12px !important;
    }
    
    .login-body .mb-4 {
        margin-bottom: 16px !important;
    }
    
    .login-body .text-muted {
        font-size: 0.75rem;
        color: #94a3b8 !important;
    }
    
    .btn-login {
        background: linear-gradient(135deg, #1a1a2e 0%, #2d3a4b 50%, #1a1a2e 100%);
        color: white;
        border: none;
        padding: 10px;
        font-weight: 600;
        font-size: 0.95rem;
        border-radius: 8px;
        width: 100%;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-login:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(26, 26, 46, 0.3);
        color: white;
    }
    
    .btn-login i {
        margin-right: 8px;
    }
    
    .login-footer {
        text-align: center;
        margin-top: 14px;
        padding-top: 12px;
        border-top: 1px solid #eef2f6;
    }
    
    .login-footer a {
        color: #64748b;
        text-decoration: none;
        font-size: 0.85rem;
    }
    
    .login-footer a:hover {
        color: #1a1a2e;
    }
    
    .alert {
        padding: 10px 14px;
        font-size: 0.85rem;
        margin-bottom: 12px;
        border-radius: 8px;
    }
    
    .invalid-feedback {
        font-size: 0.8rem;
        color: #ef4444;
        display: block;
        margin-top: 4px;
    }
</style>

<div class="container login-container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card login-card shadow-lg border-0">
                <div class="login-header">
                    <h4><i class="fas fa-user-check"></i>Only Registered Member / Trainer Login</h4>
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
                            <label for="email" class="form-label fw-bold">Email Address</label>
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
                            <label for="password" class="form-label fw-bold">Phone Number <small
                                    class="text-muted">(Registered Mobile Number)</small></label>
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
                            <label for="role" class="form-label fw-bold">Login As</label>
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
@endsection