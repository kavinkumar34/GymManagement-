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

    .section-eyebrow {
        font-family: var(--font-body);
        font-weight: 700;
        font-size: 0.72rem;
        letter-spacing: 2.5px;
        text-transform: uppercase;
        color: var(--signal);
        margin-bottom: 6px;
        display: block;
    }

    .section-heading {
        font-family: var(--font-display);
        font-weight: 400;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        color: var(--ink);
        line-height: 1;
    }

    .contact-section {
        padding: 40px 0;
    }
    
    .contact-card {
        border: 1px solid var(--line);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-card);
        transition: all 0.28s ease;
        height: 100%;
        background: white;
        padding: 30px 20px;
        text-align: center;
    }
    
    .contact-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-card-hover);
        border-color: transparent;
    }
    
    .contact-card h5 {
        font-family: var(--font-display);
        font-weight: 400;
        letter-spacing: 0.3px;
        text-transform: uppercase;
        color: var(--ink);
        margin-bottom: 10px;
    }
    
    .contact-card p {
        color: var(--steel);
        font-weight: 500;
        line-height: 1.6;
        margin-bottom: 0;
    }
    
    .contact-icon {
        width: 70px;
        height: 70px;
        background: var(--ink);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px auto;
        transition: all 0.3s;
    }
    
    .contact-card:hover .contact-icon {
        background: var(--signal);
    }
    
    .contact-icon i {
        font-size: 30px;
        color: white;
    }
    
    .contact-form {
        background: white;
        border-radius: var(--radius-lg);
        padding: 30px;
        box-shadow: var(--shadow-card);
        border: 1px solid var(--line);
    }
    
    .contact-form:hover {
        box-shadow: var(--shadow-card-hover);
    }
    
    .contact-form h3 {
        font-family: var(--font-display);
        font-weight: 400;
        letter-spacing: 0.3px;
        text-transform: uppercase;
        color: var(--ink);
        margin-bottom: 20px;
    }
    
    .contact-form h3 i {
        color: var(--signal);
        margin-right: 10px;
    }
    
    .contact-form .form-label {
        font-weight: 700;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        color: var(--ink-soft);
    }
    
    .contact-form .form-control {
        border-radius: var(--radius-sm);
        border: 2px solid var(--line);
        padding: 12px 15px;
        transition: all 0.3s;
        font-family: var(--font-body);
        font-size: 0.9rem;
        background: white;
    }
    
    .contact-form .form-control:focus {
        border-color: var(--signal);
        box-shadow: 0 0 0 3px rgba(255, 68, 5, 0.1);
    }
    
    .contact-form .form-control::placeholder {
        color: var(--steel);
        font-weight: 400;
    }
    
    .btn-send {
        background: var(--signal);
        border: none;
        border-radius: var(--radius-sm);
        padding: 12px 30px;
        font-weight: 700;
        transition: all 0.3s;
        color: white;
        width: 100%;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        font-family: var(--font-body);
        font-size: 0.9rem;
    }
    
    .btn-send:hover {
        background: var(--signal-dark);
        transform: translateY(-2px);
        color: white;
        box-shadow: 0 6px 20px rgba(255, 68, 5, 0.3);
    }
    
    .btn-send i {
        margin-right: 8px;
    }
    
    .map-container {
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-card);
        border: 1px solid var(--line);
        height: 100%;
    }
    
    .map-container iframe {
        width: 100%;
        height: 100%;
        min-height: 450px;
        border: none;
    }
    
    .page-title {
        text-align: center;
        margin-bottom: 40px;
    }
    
    .page-title h1 {
        font-family: var(--font-display);
        font-weight: 400;
        font-size: 2.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--ink);
    }
    
    .page-title h1 i {
        color: var(--signal);
        margin-right: 12px;
    }
    
    .page-title p {
        color: var(--steel);
        font-size: 1.1rem;
        font-weight: 500;
        margin-top: 8px;
    }

    /* ===== CUSTOM LOGIN MODAL STYLES ===== */
    .custom-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(20, 22, 26, 0.6);
        backdrop-filter: blur(2px);
        z-index: 99999;
        display: none;
        align-items: center;
        justify-content: center;
        animation: fadeInModal 0.3s ease;
    }
    
    .custom-modal-overlay.active {
        display: flex;
    }
    
    @keyframes fadeInModal {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
    
    .custom-modal-box {
        background: white;
        border-radius: var(--radius-lg);
        padding: 40px;
        max-width: 450px;
        width: 90%;
        text-align: center;
        box-shadow: 0 25px 60px rgba(0,0,0,0.3);
        position: relative;
        animation: slideUpModal 0.4s ease;
    }
    
    @keyframes slideUpModal {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .custom-modal-box .modal-icon {
        width: 80px;
        height: 80px;
        background: var(--success);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 2.5rem;
        color: white;
        box-shadow: 0 10px 30px rgba(22, 163, 74, 0.3);
    }
    
    .custom-modal-box .modal-title {
        font-family: var(--font-display);
        font-weight: 400;
        font-size: 1.5rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        color: var(--ink);
        margin-bottom: 10px;
    }
    
    .custom-modal-box .modal-subtitle {
        font-size: 0.95rem;
        color: var(--steel);
        margin-bottom: 25px;
        line-height: 1.6;
        font-weight: 500;
    }
    
    .custom-modal-box .modal-subtitle span {
        color: var(--success);
        font-weight: 700;
    }
    
    .custom-modal-box .modal-buttons {
        display: flex;
        gap: 12px;
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .custom-modal-box .btn-modal-primary {
        background: var(--signal);
        color: white;
        border: none;
        padding: 12px 35px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        font-family: var(--font-body);
    }
    
    .custom-modal-box .btn-modal-primary:hover {
        background: var(--signal-dark);
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(255, 68, 5, 0.3);
        color: white;
    }
    
    .custom-modal-box .btn-modal-secondary {
        background: var(--fog);
        color: var(--steel);
        border: none;
        padding: 12px 35px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        font-family: var(--font-body);
    }
    
    .custom-modal-box .btn-modal-secondary:hover {
        background: var(--line);
        color: var(--ink);
    }
    
    .custom-modal-box .modal-close {
        position: absolute;
        top: 15px;
        right: 20px;
        background: none;
        border: none;
        font-size: 1.5rem;
        color: var(--steel);
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .custom-modal-box .modal-close:hover {
        color: var(--signal);
        transform: rotate(90deg);
    }
    
    .custom-modal-box .register-link {
        margin-top: 15px;
        font-size: 0.8rem;
        color: var(--steel);
    }
    
    .custom-modal-box .register-link a {
        color: var(--signal);
        text-decoration: none;
        font-weight: 700;
        transition: all 0.3s;
    }
    
    .custom-modal-box .register-link a:hover {
        text-decoration: underline;
    }
    
    @media (max-width: 576px) {
        .custom-modal-box {
            padding: 30px 20px;
        }
        .custom-modal-box .modal-icon {
            width: 60px;
            height: 60px;
            font-size: 2rem;
        }
        .custom-modal-box .modal-title {
            font-size: 1.2rem;
        }
        .custom-modal-box .modal-subtitle {
            font-size: 0.85rem;
        }
        .custom-modal-box .modal-buttons {
            flex-direction: column;
        }
        .custom-modal-box .btn-modal-primary,
        .custom-modal-box .btn-modal-secondary {
            width: 100%;
            text-align: center;
        }
    }

    /* ===== NOTIFICATION ===== */
    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 99999;
        min-width: 280px;
        padding: 15px 20px;
        border-radius: var(--radius-sm);
        color: white;
        font-size: 0.9rem;
        animation: slideIn 0.3s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        font-weight: 600;
        font-family: var(--font-body);
    }
    
    .notification.success {
        background: var(--success);
    }
    
    .notification.error {
        background: var(--signal);
    }
    
    .notification.info {
        background: var(--info);
    }
    
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 992px) {
        .contact-section {
            padding: 30px 0;
        }
        
        .page-title h1 {
            font-size: 2rem;
        }
        
        .map-container iframe {
            min-height: 350px;
        }
    }

    @media (max-width: 768px) {
        .contact-card {
            padding: 20px 15px;
        }
        
        .contact-form {
            padding: 20px;
        }
        
        .page-title h1 {
            font-size: 1.6rem;
        }
        
        .page-title p {
            font-size: 0.95rem;
        }
        
        .map-container iframe {
            min-height: 300px;
        }
    }

    @media (max-width: 576px) {
        .contact-section {
            padding: 20px 0;
        }
        
        .contact-card {
            padding: 15px;
        }
        
        .contact-icon {
            width: 55px;
            height: 55px;
        }
        
        .contact-icon i {
            font-size: 22px;
        }
        
        .contact-form {
            padding: 15px;
        }
        
        .contact-form h3 {
            font-size: 1.1rem;
        }
        
        .page-title h1 {
            font-size: 1.3rem;
        }
        
        .page-title p {
            font-size: 0.85rem;
        }
        
        .btn-send {
            font-size: 0.8rem;
            padding: 10px 20px;
        }
        
        .map-container iframe {
            min-height: 250px;
        }
    }

    @media (max-width: 400px) {
        .page-title h1 {
            font-size: 1.1rem;
        }
        
        .contact-card h5 {
            font-size: 0.9rem;
        }
        
        .contact-card p {
            font-size: 0.8rem;
        }
        
        .contact-form .form-label {
            font-size: 0.7rem;
        }
        
        .contact-form .form-control {
            font-size: 0.8rem;
            padding: 8px 12px;
        }
        
        .notification {
            min-width: 200px;
            font-size: 0.8rem;
            padding: 12px 16px;
            top: 10px;
            right: 10px;
        }
    }
</style>

<div class="container contact-section">
    <div class="page-title">
        <span class="section-eyebrow">Get in Touch</span>
        <h1><i class="fas fa-envelope"></i> Contact Us</h1>
        <div class="energy-stripe mx-auto" style="margin-top: 10px;"></div>
        <p class="mt-3">We'd love to hear from you! Get in touch with us for any queries.</p>
    </div>
    
    <div class="row">
        <!-- Contact Info Cards -->
        <div class="col-md-4 mb-4">
            <div class="contact-card">
                <div class="contact-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h5>Our Location</h5>
                <p>123 Fitness Street,<br>Chennai - 600001,<br>Tamil Nadu, India</p>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="contact-card">
                <div class="contact-icon">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <h5>Phone Number</h5>
                <p>+91 98765 43210<br>+91 98765 43211</p>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="contact-card">
                <div class="contact-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <h5>Email Address</h5>
                <p>info@fitforge.com<br>support@fitforge.com</p>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-lg-6 mb-4">
            <div class="contact-form">
                <h3><i class="fas fa-paper-plane"></i> Send us a Message</h3>
                
                @if(session('contact_success'))
                    <div class="alert alert-success alert-dismissible fade show" style="border-radius: var(--radius-sm); border-left: 4px solid var(--success);">
                        <i class="fas fa-check-circle"></i> {{ session('contact_success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if(session('contact_error'))
                    <div class="alert alert-danger alert-dismissible fade show" style="border-radius: var(--radius-sm); border-left: 4px solid var(--signal);">
                        <i class="fas fa-exclamation-circle"></i> {{ session('contact_error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('contact.submit') }}" id="contactForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Your Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Subject <span class="text-danger">*</span></label>
                        <input type="text" name="subject" class="form-control" placeholder="Enter subject" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Message <span class="text-danger">*</span></label>
                        <textarea name="message" class="form-control" rows="5" placeholder="Write your message here..." required></textarea>
                    </div>
                    
                    <button type="submit" class="btn-send" id="sendMessageBtn">
                        <i class="fas fa-paper-plane"></i> Send Message
                    </button>
                </form>
            </div>
        </div>
        
        <div class="col-lg-6 mb-4">
            <div class="map-container">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15542.866040940103!2d80.233642!3d13.08268!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a5265c0c2c5c2c1%3A0x8c2c5c2c5c2c5c2!2sChennai!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin" 
                    allowfullscreen="" 
                    loading="lazy"
                    title="FitForge Location Map">
                </iframe>
            </div>
        </div>
    </div>
</div>

<!-- ===== CUSTOM LOGIN MODAL ===== -->
<div class="custom-modal-overlay" id="loginModal">
    <div class="custom-modal-box">
        <button class="modal-close" onclick="closeLoginModal()">✕</button>
        <div class="modal-icon">
            <i class="fas fa-lock"></i>
        </div>
        <h2 class="modal-title">Login Required</h2>
        <p class="modal-subtitle">
            Please login to your account to send a message. <br>
            <span>Don't have an account? Register now!</span>
        </p>
        <div class="modal-buttons">
            <a href="{{ route('login') }}" class="btn-modal-primary">
                <i class="fas fa-sign-in-alt me-2"></i> Login Now
            </a>
            <button class="btn-modal-secondary" onclick="closeLoginModal()">
                <i class="fas fa-times me-2"></i> Cancel
            </button>
        </div>
        <div class="register-link">
            <i class="fas fa-user-plus me-1"></i> 
            <a href="{{ route('member.register') }}">Create new account</a>
        </div>
    </div>
</div>

<script>
    // ================================================================
    // ===== CUSTOM LOGIN MODAL FUNCTIONS =====
    // ================================================================
    function showLoginModal() {
        const modal = document.getElementById('loginModal');
        if (modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }
    
    function closeLoginModal() {
        const modal = document.getElementById('loginModal');
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }
    
    // Close modal on overlay click
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('loginModal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeLoginModal();
                }
            });
        }

        // ================================================================
        // ===== CONTACT FORM - CHECK LOGIN BEFORE SUBMIT =====
        // ================================================================
        const contactForm = document.getElementById('contactForm');
        if (contactForm) {
            contactForm.addEventListener('submit', function(e) {
                @if(!auth()->check())
                    e.preventDefault(); // Stop form submission
                    showLoginModal(); // Show login modal
                    showNotification('Please login to send a message.', 'error');
                    return false;
                @endif
                return true;
            });
        }

        // ================================================================
        // ===== CLOSE MODAL WITH ESC KEY =====
        // ================================================================
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeLoginModal();
            }
        });
    });

    // ================================================================
    // ===== NOTIFICATION FUNCTION =====
    // ================================================================
    function showNotification(message, type = 'info') {
        // Remove existing notifications
        const existingNotifications = document.querySelectorAll('.notification');
        existingNotifications.forEach(notif => notif.remove());
        
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        
        let icon = 'fa-info-circle';
        if (type === 'success') icon = 'fa-check-circle';
        else if (type === 'error') icon = 'fa-exclamation-circle';
        
        notification.innerHTML = `<i class="fas ${icon} me-2"></i> ${message}`;
        document.body.appendChild(notification);
        
        // Auto-dismiss after 3 seconds
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transition = 'opacity 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // ================================================================
    // ===== AUTO-DISMISS ALERTS =====
    // ================================================================
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.alert-success, .alert-danger').forEach(function(alert) {
            setTimeout(function() {
                const closeBtn = alert.querySelector('.btn-close');
                if (closeBtn) {
                    closeBtn.click();
                } else {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.remove();
                    }, 500);
                }
            }, 5000);
        });
    });
</script>
@endsection