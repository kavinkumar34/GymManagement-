@extends('layouts.app')

@section('content')
<style>
    .contact-section {
        padding: 40px 0;
    }
    
    .contact-card {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: transform 0.3s;
        height: 100%;
    }
    
    .contact-card:hover {
        transform: translateY(-5px);
    }
    
    .contact-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #000000 0%, #333333 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px auto;
    }
    
    .contact-icon i {
        font-size: 30px;
        color: white;
    }
    
    .contact-form {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .contact-form .form-control {
        border-radius: 10px;
        border: 2px solid #e0e0e0;
        padding: 12px 15px;
        transition: all 0.3s;
    }
    
    .contact-form .form-control:focus {
        border-color: #dc3545;
        box-shadow: none;
    }
    
    .btn-send {
        background: #000000;
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
        transition: all 0.3s;
        color: white;
        width: 100%;
    }
    
    .btn-send:hover {
        background: #dc3545;
        transform: translateY(-2px);
    }
    
    .map-container {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .page-title {
        text-align: center;
        margin-bottom: 40px;
    }
    
    .page-title h1 {
        font-size: 2.5rem;
        font-weight: bold;
        color: #000000;
    }
    
    .page-title p {
        color: #666;
        font-size: 1.1rem;
    }

    /* ===== CUSTOM LOGIN MODAL STYLES ===== */
    .custom-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.6);
        backdrop-filter: blur(5px);
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
        border-radius: 20px;
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
        background: linear-gradient(135deg, #28a745, #1e7e34);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 2.5rem;
        color: white;
        box-shadow: 0 10px 30px rgba(40, 167, 69, 0.3);
    }
    
    .custom-modal-box .modal-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 10px;
    }
    
    .custom-modal-box .modal-subtitle {
        font-size: 0.95rem;
        color: #64748b;
        margin-bottom: 25px;
        line-height: 1.6;
    }
    
    .custom-modal-box .modal-buttons {
        display: flex;
        gap: 12px;
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .custom-modal-box .btn-modal-primary {
        background: linear-gradient(135deg, #28a745, #1e7e34);
        color: white;
        border: none;
        padding: 12px 35px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
    }
    
    .custom-modal-box .btn-modal-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(40, 167, 69, 0.3);
        color: white;
    }
    
    .custom-modal-box .btn-modal-secondary {
        background: #e2e8f0;
        color: #64748b;
        border: none;
        padding: 12px 35px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .custom-modal-box .btn-modal-secondary:hover {
        background: #cbd5e1;
        color: #1a1a2e;
    }
    
    .custom-modal-box .modal-close {
        position: absolute;
        top: 15px;
        right: 20px;
        background: none;
        border: none;
        font-size: 1.5rem;
        color: #999;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .custom-modal-box .modal-close:hover {
        color: #dc3545;
        transform: rotate(90deg);
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

    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 280px;
        padding: 15px 20px;
        border-radius: 8px;
        color: white;
        font-size: 14px;
        animation: slideIn 0.3s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .notification.success {
        background: #28a745;
    }
    
    .notification.error {
        background: #dc3545;
    }
    
    .notification.info {
        background: #17a2b8;
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
</style>

<div class="container contact-section">
    <div class="page-title">
        <h1><i class="fas fa-envelope"></i> Contact Us</h1>
        <p>We'd love to hear from you! Get in touch with us for any queries.</p>
    </div>
    
    <div class="row">
        <!-- Contact Info Cards -->
        <div class="col-md-4 mb-4">
            <div class="contact-card card text-center p-4">
                <div class="contact-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h5>Our Location</h5>
                <p>123 Fitness Street,<br>Chennai - 600001,<br>Tamil Nadu, India</p>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="contact-card card text-center p-4">
                <div class="contact-icon">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <h5>Phone Number</h5>
                <p>+91 98765 43210<br>+91 98765 43211</p>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="contact-card card text-center p-4">
                <div class="contact-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <h5>Email Address</h5>
                <p>info@gymmanagement.com<br>support@gymmanagement.com</p>
            </div>
        </div>
    </div>
    
    <div class="row mt-5">
        <div class="col-lg-6 mb-4">
            <div class="contact-form">
                <h3 class="mb-4"><i class="fas fa-paper-plane"></i> Send us a Message</h3>
                
                @if(session('contact_success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle"></i> {{ session('contact_success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if(session('contact_error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-circle"></i> {{ session('contact_error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('contact.submit') }}" id="contactForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Your Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Subject</label>
                        <input type="text" name="subject" class="form-control" placeholder="Enter subject" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Message</label>
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
                    width="100%" 
                    height="650" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy">
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
            <span style="color: #28a745; font-weight: 500;">Don't have an account? Register now!</span>
        </p>
        <div class="modal-buttons">
            <a href="{{ route('login') }}" class="btn-modal-primary">
                <i class="fas fa-sign-in-alt me-2"></i> Login Now
            </a>
            <button class="btn-modal-secondary" onclick="closeLoginModal()">
                <i class="fas fa-times me-2"></i> Cancel
            </button>
        </div>
        <div style="margin-top: 15px; font-size: 0.8rem; color: #999;">
            <i class="fas fa-user-plus me-1"></i> 
            <a href="{{ route('member.register') }}" style="color: #28a745; text-decoration: none; font-weight: 500;">
                Create new account
            </a>
        </div>
    </div>
</div>

<script>
    // ===== CUSTOM LOGIN MODAL FUNCTIONS =====
    function showLoginModal() {
        document.getElementById('loginModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    
    function closeLoginModal() {
        document.getElementById('loginModal').classList.remove('active');
        document.body.style.overflow = '';
    }
    
    // Close modal on overlay click
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('loginModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeLoginModal();
            }
        });
    });

    // ===== CONTACT FORM - CHECK LOGIN BEFORE SUBMIT =====
    document.getElementById('contactForm').addEventListener('submit', function(e) {
        @if(!auth()->check())
            e.preventDefault(); // Stop form submission
            showLoginModal(); // Show login modal
            showNotification('Please login to send a message.', 'error');
            return false;
        @endif
        
        // If logged in, allow form submission
        return true;
    });

    function showNotification(message, type) {
        // Remove existing notifications
        const existingNotifications = document.querySelectorAll('.notification');
        existingNotifications.forEach(notif => notif.remove());
        
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'} me-2"></i> ${message}`;
        document.body.appendChild(notification);
        setTimeout(() => notification.remove(), 3000);
    }
</script>
@endsection