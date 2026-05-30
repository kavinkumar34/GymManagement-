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
                
                <form method="POST" action="{{ route('contact.submit') }}">
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
                    
                    <button type="submit" class="btn-send">
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
@endsection