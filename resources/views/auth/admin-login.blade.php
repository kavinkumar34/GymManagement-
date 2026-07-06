@extends('layouts.app')

@section('content')
<style>
    /* Hide navbar and footer completely */
    nav.navbar, .navbar, .admin-sidebar, footer, .footer {
        display: none !important;
    }
    
    /* REMOVE SCROLLBAR - Added these lines */
    html, body {
        overflow: hidden !important;
        height: 100% !important;
    }
    
    body {
        padding-top: 0 !important;
        margin-top: 0 !important;
        min-height: 100vh;
        background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        overflow: hidden;
    }
    
    main.py-4 {
        padding-top: 1rem !important;
        padding-bottom: 1rem !important;
    }
    
    /* Override any admin sidebar that might sneak in */
    .admin-sidebar, .admin-main-content {
        display: none !important;
    }
    
    /* Card Styling - Reduced height */
    .admin-card {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        animation: fadeInUp 0.6s ease;
        background: white;
        margin: 20px 0;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .admin-card .card-header {
        background: #000000;
        padding: 20px 20px;
        border: none;
    }
    
    .admin-card .card-header h4 {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 5px;
        color: white;
    }
    
    .admin-card .card-header small {
        font-size: 12px;
        opacity: 0.8;
        color: rgba(255,255,255,0.7);
    }
    
    .admin-card .card-header i {
        font-size: 32px;
    }
    
    .admin-card .card-body {
        padding: 25px 30px;
        background: white;
    }
    
    /* Form Styling - Compact */
    .form-label {
        font-weight: 500;
        color: #000000;
        margin-bottom: 5px;
        font-size: 14px;
    }
    
    .form-control {
        border-radius: 10px;
        border: 2px solid #e0e0e0;
        padding: 8px 12px;
        transition: all 0.3s ease;
        font-size: 14px;
    }
    
    .form-control:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        outline: none;
    }
    
    /* Button Styling - Compact */
    .btn-admin-login {
        background: #000000;
        border: none;
        border-radius: 10px;
        padding: 10px;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s ease;
        color: white;
    }
    
    .btn-admin-login:hover {
        background: #dc3545;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }
    
    /* Register Link */
    .register-link {
        color: #dc3545;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        font-size: 13px;
    }
    
    .register-link:hover {
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
        padding: 10px 15px;
        font-size: 13px;
    }
    
    .alert-danger {
        background-color: #f8d7da;
        border-color: #f5c6cb;
        color: #721c24;
    }
    
    /* Remove scroll - Container height adjustment */
    .container {
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .row {
        width: 100%;
        margin: 0;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .admin-card .card-body {
            padding: 20px;
        }
        .admin-card .card-header {
            padding: 15px 20px;
        }
        .admin-card .card-header h4 {
            font-size: 20px;
        }
        .admin-card .card-header i {
            font-size: 28px;
        }
        .form-control {
            padding: 8px 10px;
        }
        .btn-admin-login {
            padding: 8px;
        }
        .container {
            height: auto;
            min-height: 100vh;
            padding: 20px 0;
        }
        /* Remove scroll on mobile too */
        html, body {
            overflow: auto !important;
        }
    }
    
    @media (max-width: 576px) {
        .admin-card .card-body {
            padding: 15px;
        }
        .form-label {
            font-size: 13px;
        }
        .form-control {
            font-size: 13px;
        }
    }
    
    /* For mobile devices - ensure no scroll issues */
    @media (max-width: 480px) {
        body {
            background-attachment: scroll;
        }
        .admin-card {
            margin: 10px 0;
        }
    }

    /* Hide WhatsApp float button on admin pages */
.whatsapp-float, .whatsapp-tooltip {
    display: none !important;
}

/* Hide navbar spacer */
.navbar-spacer {
    display: none !important;
    height: 0 !important;
}

/* Remove main spacing */
main {
    margin: 0 !important;
    padding: 0 !important;
    min-height: 100vh;
}

/* Perfect center */
.container {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 0 !important;
    margin: 0 auto;
}

.row {
    width: 100%;
    justify-content: center;
    margin: 0;
}

.admin-card {
    margin: 0 !important;
}
.container-fluid{
    padding:0 !important;
}
#togglePassword {
    color: #6c757d;
    font-size: 16px;
    z-index: 10;
}

#togglePassword:hover {
    color: #dc3545;
}
</style>

<div class="container-fluid">
<div class="row justify-content-center align-items-center" style="min-height:100vh;">
            <div class="col-md-5 col-lg-4">
            <div class="card admin-card">
                <div class="card-header text-center">
                    <i class="fas fa-dumbbell" style="font-size: 32px; margin-bottom: 8px; color: white;"></i>
                    <h4><i class="fas fa-user-shield"></i> Admin Login</h4>
                    <small>Admin Only Access</small>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.login.submit') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-envelope me-2"></i>Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter your email" required autofocus>
                        </div>
                        
                      <div class="mb-3">
    <label class="form-label">
        <i class="fas fa-lock me-2"></i>Password
    </label>

    <div class="position-relative">
     <input type="password"
       id="password"
       name="password"
       class="form-control pe-5"
       placeholder="Enter your password"
       autocomplete="current-password"
       required>

        <span id="togglePassword"
              class="position-absolute top-50 end-0 translate-middle-y me-3"
              style="cursor:pointer;">
            <i class="fas fa-eye"></i>
        </span>
    </div>  
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
                        
                        <button type="submit" class="btn-admin-login w-100">
                            <i class="fas fa-sign-in-alt me-2"></i>Admin Login
                        </button>
                    </form>
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('admin.register') }}" class="register-link">
                            <i class="fas fa-user-plus me-1"></i> New Admin? Register here
                        </a>
                    </div>
                </div>
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

document.addEventListener("DOMContentLoaded", function () {

    const togglePassword = document.getElementById("togglePassword");
    const password = document.getElementById("password");

    togglePassword.addEventListener("click", function () {

        if (password.type === "password") {
            password.type = "text";
            this.querySelector("i").classList.remove("fa-eye");
            this.querySelector("i").classList.add("fa-eye-slash");
        } else {
            password.type = "password";
            this.querySelector("i").classList.remove("fa-eye-slash");
            this.querySelector("i").classList.add("fa-eye");
        }

    });

});
</script>