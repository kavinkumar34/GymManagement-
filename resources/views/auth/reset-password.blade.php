@extends('layouts.app')

@section('content')
<style>
    .reset-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 70vh;
        padding: 20px;
    }

    .reset-card {
        max-width: 420px;
        width: 100%;
        border: 1px solid var(--line);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-card);
        background: white;
    }

    .reset-card .card-header {
        background: var(--ink);
        padding: 22px 20px 18px;
        border: none;
        text-align: center;
        border-bottom: 3px solid var(--signal);
    }

    .reset-card .card-header .header-icon {
        font-size: 28px;
        color: var(--signal);
        margin-bottom: 6px;
        display: block;
    }

    .reset-card .card-header h4 {
        font-family: var(--font-display);
        font-size: 20px;
        font-weight: 400;
        color: white;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .reset-card .card-header small {
        font-size: 11px;
        opacity: 0.7;
        color: rgba(255,255,255,0.6);
    }

    .reset-card .card-body {
        padding: 25px 28px 28px;
    }

    /* Password input with eye icon */
    .password-wrapper {
        position: relative;
    }

    .password-wrapper .form-control {
        padding-right: 45px;
    }

    .password-wrapper .toggle-password {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--steel);
        cursor: pointer;
        font-size: 16px;
        padding: 5px;
        transition: all 0.3s ease;
        z-index: 2;
    }

    .password-wrapper .toggle-password:hover {
        color: var(--signal);
    }

    .password-wrapper .toggle-password i {
        font-size: 16px;
    }

    /* Enhanced Reset Password Button */
    .btn-reset-password {
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

    .btn-reset-password::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: all 0.5s ease;
    }

    .btn-reset-password:hover::before {
        left: 100%;
    }

    .btn-reset-password:hover {
        background: var(--signal-dark);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(255, 68, 5, 0.3);
        color: white;
    }

    .btn-reset-password:active {
        transform: scale(0.97);
    }

    .btn-reset-password i {
        font-size: 16px;
    }

    /* Loading state */
    .btn-reset-password.loading {
        pointer-events: none;
        opacity: 0.8;
    }

    .btn-reset-password .spinner {
        display: none;
        width: 18px;
        height: 18px;
        border: 2px solid rgba(255,255,255,0.3);
        border-top: 2px solid white;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    .btn-reset-password.loading .spinner {
        display: inline-block;
    }

    .btn-reset-password.loading .btn-text {
        display: none;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Password strength indicator */
    .password-strength {
        margin-top: 6px;
    }

    .password-strength .strength-bar {
        height: 4px;
        border-radius: 4px;
        background: var(--line);
        overflow: hidden;
        margin-top: 4px;
    }

    .password-strength .strength-bar .bar-fill {
        height: 100%;
        width: 0%;
        transition: all 0.3s ease;
        border-radius: 4px;
    }

    .password-strength .strength-text {
        font-size: 11px;
        color: var(--steel);
        margin-top: 3px;
    }

    /* Responsive */
    @media (max-width: 576px) {
        .reset-card .card-body {
            padding: 18px 18px 20px;
        }
        
        .btn-reset-password {
            height: 40px;
            font-size: 13px;
        }
        
        .password-wrapper .toggle-password {
            right: 10px;
        }
    }
</style>

<div class="reset-wrapper">
    <div class="card reset-card">
        <div class="card-header">
            <span class="header-icon"><i class="fas fa-lock"></i></span>
            <h4>Reset Password</h4>
            <small>Enter your new password</small>
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

            <form method="POST" action="{{ route('password.reset') }}" id="resetPasswordForm">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">
                
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-key"></i>New Password</label>
                    <div class="password-wrapper">
                        <input type="password" name="password" id="newPassword" 
                               class="form-control @error('password') is-invalid @enderror" 
                               placeholder="Minimum 8 characters" required>
                        <button type="button" class="toggle-password" onclick="togglePassword('newPassword', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <div class="password-strength">
                        <div class="strength-bar">
                            <div class="bar-fill" id="strengthBar"></div>
                        </div>
                        <div class="strength-text" id="strengthText">Enter a strong password</div>
                    </div>
                    <small class="text-muted">Password must be at least 8 characters</small>
                </div>
                
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-check-circle"></i>Confirm Password</label>
                    <div class="password-wrapper">
                        <input type="password" name="password_confirmation" id="confirmPassword" 
                               class="form-control" placeholder="Confirm your new password" required>
                        <button type="button" class="toggle-password" onclick="togglePassword('confirmPassword', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                
                <button type="submit" class="btn-reset-password" id="resetBtn">
                    <span class="spinner"></span>
                    <span class="btn-text"><i class="fas fa-save"></i> Reset Password</span>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
// Toggle password visibility
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

// Password strength indicator
document.getElementById('newPassword').addEventListener('input', function() {
    const password = this.value;
    const bar = document.getElementById('strengthBar');
    const text = document.getElementById('strengthText');
    let strength = 0;
    
    if (password.length >= 8) strength += 20;
    if (password.match(/[a-z]+/)) strength += 20;
    if (password.match(/[A-Z]+/)) strength += 20;
    if (password.match(/[0-9]+/)) strength += 20;
    if (password.match(/[$@#&!]+/)) strength += 20;
    
    bar.style.width = strength + '%';
    
    if (strength <= 20) {
        bar.style.background = '#EF4444';
        text.textContent = 'Weak - Add uppercase, numbers, and special characters';
        text.style.color = '#EF4444';
    } else if (strength <= 40) {
        bar.style.background = '#F59E0B';
        text.textContent = 'Fair - Add more variety';
        text.style.color = '#F59E0B';
    } else if (strength <= 60) {
        bar.style.background = '#F59E0B';
        text.textContent = 'Good - Keep going!';
        text.style.color = '#F59E0B';
    } else if (strength <= 80) {
        bar.style.background = '#10B981';
        text.textContent = 'Strong - Almost there!';
        text.style.color = '#10B981';
    } else {
        bar.style.background = '#10B981';
        text.textContent = 'Very Strong - Great password!';
        text.style.color = '#10B981';
    }
});

// Auto-dismiss alerts after 5 seconds
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

    // Form submission loading state
    const form = document.getElementById('resetPasswordForm');
    const btn = document.getElementById('resetBtn');
    
    form.addEventListener('submit', function() {
        btn.classList.add('loading');
        btn.disabled = true;
    });
});

// Prevent opening in new tab - force same tab
document.addEventListener('DOMContentLoaded', function() {
    // Ensure all links open in same tab
    document.querySelectorAll('a[target="_blank"]').forEach(function(link) {
        link.removeAttribute('target');
    });
    
    // Handle any click that might try to open new tab
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (link && link.getAttribute('target') === '_blank') {
            e.preventDefault();
            link.removeAttribute('target');
            window.location.href = link.href;
        }
    });
});
</script>
@endsection