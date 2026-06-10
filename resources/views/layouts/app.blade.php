<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ App\Models\Setting::get('company_name', 'Gym Management System') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #e4e7f2 0%, #e6ddef 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .captcha-img {
            cursor: pointer;
            border-radius: 8px;
            border: 1px solid #ddd;
            height: 45px;
            width: auto;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            transition: 0.3s;
        }
        footer {
            text-align: center;
            padding: 20px;
            color: white;
            margin-top: 50px;
        }
        
        /* Cart Count Badge */
        .cart-count {
            position: absolute;
            top: -8px;
            right: -12px;
            background: #ff4757;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 10px;
            font-weight: bold;
            min-width: 18px;
            text-align: center;
        }
        
        /* Hide cart count when empty */
        .cart-count.hide-badge {
            display: none;
        }
        
        /* Navbar Dropdown Styles */
        .navbar-nav .dropdown-menu {
            background: #2d2d4a;
            border: none;
            border-radius: 8px;
        }
        
        .navbar-nav .dropdown-item {
            color: #a0a0c0;
        }
        
        .navbar-nav .dropdown-item:hover {
            background: #e94560;
            color: white;
        }
        
        /* Join Gym / My Dashboard Button */
        .btn-join-gym, .btn-dashboard {
            background: #ff4757;
            color: white;
            border-radius: 25px;
            padding: 5px 15px;
            margin-left: 10px;
            transition: all 0.3s;
        }
        
        .btn-join-gym:hover, .btn-dashboard:hover {
            background: #ff6b6b;
            transform: scale(1.05);
            color: white;
        }
        
        /* Profile Icon */
        .profile-icon {
            width: 35px;
            height: 35px;
            background: #e94560;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 8px;
        }
        
        .profile-icon i {
            font-size: 1rem;
            margin: 0;
        }
        
        /* Hide admin sidebar on login page */
        .hide-sidebar .admin-sidebar,
        .hide-sidebar .admin-main-content {
            display: none !important;
        }
    </style>
</head>
<body class="@if(Route::is('admin.login') || Route::is('admin.register')) hide-sidebar @endif">

{{-- Helper function to get dashboard URL based on role --}}
@php
    if (!function_exists('getDashboardUrl')) {
        function getDashboardUrl() {
            if (auth()->check()) {
                $user = auth()->user();
                if ($user->role == 'trainer') {
                    return route('trainer.dashboard');
                } else {
                    return route('member.dashboard');
                }
            }
            return route('login');
        }
    }
    
    // Helper function for contact link - redirects to login only for guests
    if (!function_exists('getContactUrl')) {
        function getContactUrl() {
            if (auth()->check()) {
                return route('contact');
            }
            return route('login');
        }
    }
@endphp

{{-- ROLE BASED NAVBAR --}}
@auth('admin')
    {{-- ONLY CHANGE: Show frontend navbar on home page instead of admin navbar --}}
    @if(Route::is('home'))
        {{-- FRONTEND NAVBAR FOR ADMIN ON HOME PAGE --}}
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="{{ App\Models\Setting::get('company_logo', 'fas fa-dumbbell') }} me-2"></i>
                    <strong>{!! nl2br(e(App\Models\Setting::get('company_name', 'GYMMANAGEMENT'))) !!}</strong>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#storeNavbarAdmin">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="storeNavbarAdmin">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About Us</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('track.order') }}">Track Order</a></li>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> Admin Panel
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('admin-logout-from-frontend').submit();">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <form id="admin-logout-from-frontend" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    @else
        {{-- Admin Navbar (Only shown when admin is logged in on admin pages) --}}
        @include('layouts.admin-navbar')
    @endif
@elseif(auth()->check())
    {{-- STORE NAVBAR FOR LOGGED IN USERS (Member/Trainer) --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="{{ App\Models\Setting::get('company_logo', 'fas fa-dumbbell') }} me-2"></i>
                <strong>{!! nl2br(e(App\Models\Setting::get('company_name', 'GYMMANAGEMENT'))) !!}</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#storeNavbarLogged">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="storeNavbarLogged">
                <!-- Main Menu Links -->
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Home</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="#">Shop</a>
                    </li> -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Categories
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">🏋️ Gym Equipment</a></li>
                            <li><a class="dropdown-item" href="#">👕 Gym Wear</a></li>
                            <li><a class="dropdown-item" href="#">👟 Footwear</a></li>
                            <li><a class="dropdown-item" href="#">💪 Supplements</a></li>
                            <li><a class="dropdown-item" href="#">🎒 Accessories</a></li>
                            <li><a class="dropdown-item" href="#">⌚ Fitness Trackers</a></li>
                        </ul>
                    </li>
                    <!-- FIXED: My Orders link for logged-in users -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('my.orders') }}">
                            <i class="fas fa-shopping-bag me-1"></i> My Orders
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('track.order') }}">Track Order</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-dashboard" href="{{ getDashboardUrl() }}">
                            <i class="fas fa-sign-in-alt"></i> Join Gym
                        </a>
                    </li>
                </ul>
                
                <!-- Right Side: Search, Cart, Wishlist, Profile -->
                <ul class="navbar-nav ms-auto align-items-center">
                    <!-- Search Form -->
                    <li class="nav-item me-2">
                        <form class="d-flex" onsubmit="event.preventDefault(); searchProducts();">
                            <input class="form-control form-control-sm" type="search" placeholder="Search products..." id="navbarSearch" style="width: 180px; border-radius: 20px 0 0 20px;">
                            <button class="btn btn-sm btn-primary" type="submit" style="border-radius: 0 20px 20px 0;">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </li>
                    
                    <!-- Cart Icon with Count (hides when 0) -->
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="{{ url('/cart') }}">
                            <i class="fas fa-shopping-cart" style="font-size: 1.3rem;"></i>
                            <span class="cart-count" id="navbarCartCount"></span>
                        </a>
                    </li>
                    
                    <!-- Wishlist Icon with Count -->
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="{{ route('wishlist') }}">
                            <i class="fas fa-heart" style="font-size: 1.3rem;"></i>
                            <span class="cart-count" id="navbarWishlistCount"></span>
                        </a>
                    </li>
                    
                    <!-- Profile Dropdown -->
                    <li class="nav-item dropdown ms-2">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                            <div class="profile-icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">
                                <i class="fas fa-id-card me-2"></i> My Profile
                            </a></li>
                            <!-- FIXED: My Orders link in dropdown -->
                            <li><a class="dropdown-item" href="{{ route('my.orders') }}">
                                <i class="fas fa-shopping-bag me-2"></i> My Orders
                            </a></li>
                            @if(auth()->user()->role == 'trainer')
                                <li><a class="dropdown-item" href="{{ route('trainer.dashboard') }}">
                                    <i class="fas fa-chalkboard-user me-2"></i> Trainer Dashboard
                                </a></li>
                            @else
                                <li><a class="dropdown-item" href="{{ route('member.dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-2"></i> Member Dashboard
                                </a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); localStorage.removeItem('cart'); localStorage.removeItem('wishlist'); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
@else
{{-- STORE NAVBAR FOR GUESTS (Cart Icon without count) --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <i class="{{ App\Models\Setting::get('company_logo', 'fas fa-dumbbell') }} me-2"></i>
            <strong>{!! nl2br(e(App\Models\Setting::get('company_name', 'GYMMANAGEMENT'))) !!}</strong>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#storeNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="storeNavbar">
            <!-- Main Menu Links -->
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">Home</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="#">Shop</a>
                </li> -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        Categories
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">🏋️ Gym Equipment</a></li>
                        <li><a class="dropdown-item" href="#">👕 Gym Wear</a></li>
                        <li><a class="dropdown-item" href="#">👟 Footwear</a></li>
                        <li><a class="dropdown-item" href="#">💪 Supplements</a></li>
                        <li><a class="dropdown-item" href="#">🎒 Accessories</a></li>
                        <li><a class="dropdown-item" href="#">⌚ Fitness Trackers</a></li>
                    </ul>
                </li>
                <!-- FIXED: My Orders link for guests redirects to login -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">
                        <i class="fas fa-shopping-bag me-1"></i> My Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('track.order') }}">Track Order</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('about') }}">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn-join-gym" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt"></i> Join Gym
                    </a>
                </li>
            </ul>
            
            <!-- Right Side: Search, Cart, Wishlist (No Count Badge for Guests) -->
            <ul class="navbar-nav ms-auto align-items-center">
                <!-- Search Form -->
                <li class="nav-item me-2">
                    <form class="d-flex" onsubmit="event.preventDefault(); searchProducts();">
                        <input class="form-control form-control-sm" type="search" placeholder="Search products..." id="navbarSearch" style="width: 180px; border-radius: 20px 0 0 20px;">
                        <button class="btn btn-sm btn-primary" type="submit" style="border-radius: 0 20px 20px 0;">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </li>
                
                <!-- Cart Icon - No count badge for guests -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/cart') }}">
                        <i class="fas fa-shopping-cart" style="font-size: 1.3rem;"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
@endauth

{{-- MAIN CONTENT --}}
<main class="py-4">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @yield('content')
    </div>
</main>

<!-- FOOTER SECTION -->
<footer class="footer mt-auto">
    <div class="container">
        <div class="row">
            <!-- About Section -->
            <div class="col-md-4 mb-4">
                <div class="footer-logo">
                    <i class="fas fa-dumbbell me-2"></i>
                    <strong>{{ App\Models\Setting::get('company_name', 'GYMMANAGEMENT') }}</strong>
                </div>
                <p class="footer-about mt-3">
                    Your complete fitness management solution. We provide gym management software, 
                    fitness equipment, supplements, and workout gear to help you achieve your fitness goals.
                </p>
                <div class="social-icons mt-3">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-md-2 mb-4">
                <h5>Quick Links</h5>
                <ul class="footer-links">
                    <li><a href="{{ url('/') }}"><i class="fas fa-chevron-right"></i> Home</a></li>
                    <li><a href="{{ route('about') }}"><i class="fas fa-chevron-right"></i> About Us</a></li>
                    <li><a href="@if(auth()->check()) {{ route('contact') }} @else {{ route('login') }} @endif"><i class="fas fa-chevron-right"></i> Contact</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Blog</a></li>
                </ul>
            </div>

            <!-- Customer Service -->
            <div class="col-md-3 mb-4">
                <h5>Customer Service</h5>
                <ul class="footer-links">
                    <li><a href="@if(auth()->check()) {{ route('my.orders') }} @else {{ route('login') }} @endif"><i class="fas fa-chevron-right"></i> My Account</a></li>
                    <li><a href="{{ route('track.order') }}"><i class="fas fa-chevron-right"></i> Track Order</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Returns & Exchange</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> FAQ</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Privacy Policy</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Terms & Conditions</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-md-3 mb-4">
                <h5>Get In Touch</h5>
                <ul class="footer-contact">
                    <li>
                        <i class="fas fa-map-marker-alt"></i>
                        <span>123 Fitness Street, Chennai - 600001</span>
                    </li>
                    <li>
                        <i class="fas fa-phone-alt"></i>
                        <span>+91 98765 43210</span>
                    </li>
                    <li>
                        <i class="fas fa-envelope"></i>
                        <span>info@gymmanagement.com</span>
                    </li>
                    <li>
                        <i class="fas fa-clock"></i>
                        <span>Mon - Sat: 6:00 AM - 10:00 PM</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="row bottom-bar">
            <div class="col-md-6 text-center text-md-start">
                <p>&copy; {{ date('Y') }} {{ App\Models\Setting::get('company_name', 'Gym Management System') }}. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <div class="payment-methods">
                    <i class="fab fa-cc-visa"></i>
                    <i class="fab fa-cc-mastercard"></i>
                    <i class="fab fa-cc-amex"></i>
                    <i class="fab fa-cc-paypal"></i>
                    <i class="fas fa-credit-card"></i>
                    <i class="fas fa-mobile-alt"></i>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    /* Footer Styles */
    .footer {
        background: linear-gradient(135deg, #0f0f1a 0%, #1a1a2e 100%);
        color: #a0a0c0;
        padding-top: 50px;
        margin-top: 60px;
        border-top: 1px solid rgba(255,255,255,0.05);
    }

    .footer-logo {
        font-size: 1.5rem;
        font-weight: bold;
        color: white;
    }

    .footer-logo i {
        color: #e94560;
    }

    .footer-about {
        line-height: 1.6;
        font-size: 0.9rem;
    }

    /* Social Icons */
    .social-icons a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 35px;
        height: 35px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
        margin-right: 10px;
        color: #a0a0c0;
        transition: all 0.3s;
        text-decoration: none;
    }

    .social-icons a:hover {
        background: #e94560;
        color: white;
        transform: translateY(-3px);
    }

    /* Footer Links */
    .footer h5 {
        color: white;
        font-size: 1.1rem;
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 10px;
    }

    .footer h5::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 40px;
        height: 2px;
        background: #e94560;
    }

    .footer-links, .footer-contact {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-links li, .footer-contact li {
        margin-bottom: 12px;
    }

    .footer-links a {
        color: #a0a0c0;
        text-decoration: none;
        transition: all 0.3s;
        display: inline-block;
    }

    .footer-links a i {
        font-size: 10px;
        margin-right: 8px;
        transition: all 0.3s;
    }

    .footer-links a:hover {
        color: #e94560;
        transform: translateX(5px);
    }

    .footer-links a:hover i {
        transform: translateX(3px);
    }

    /* Contact Info */
    .footer-contact li {
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .footer-contact li i {
        color: #e94560;
        font-size: 1rem;
        margin-top: 3px;
        min-width: 20px;
    }

    .footer-contact li span {
        font-size: 0.9rem;
    }

    /* Bottom Bar */
    .bottom-bar {
        padding: 20px 0;
        margin-top: 30px;
        border-top: 1px solid rgba(255,255,255,0.05);
        font-size: 0.85rem;
    }

    .payment-methods i {
        font-size: 1.5rem;
        margin-left: 10px;
        color: #a0a0c0;
        transition: all 0.3s;
    }

    .payment-methods i:hover {
        color: #e94560;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .footer {
            text-align: center;
        }
        .footer h5::after {
            left: 50%;
            transform: translateX(-50%);
        }
        .bottom-bar {
            text-align: center;
        }
        .payment-methods {
            margin-top: 10px;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Refresh captcha function
    function refreshCaptcha() {
        const img = document.getElementById('captcha-img');
        if (img) {
            img.src = '{{ url("/captcha") }}?' + Math.random();
        }
    }
    
    // Update cart count in navbar - Only shows badge when count > 0
    function updateNavbarCartCount() {
        @auth
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            let count = cart.reduce((total, item) => total + item.quantity, 0);
            let cartCountElement = document.getElementById('navbarCartCount');
            if(cartCountElement) {
                if(count > 0) {
                    cartCountElement.textContent = count;
                    cartCountElement.classList.remove('hide-badge');
                } else {
                    cartCountElement.textContent = '';
                    cartCountElement.classList.add('hide-badge');
                }
            }
        @endauth
    }
    
    // Update wishlist count in navbar
    function updateNavbarWishlistCount() {
        @auth
            let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
            let count = wishlist.length;
            let wishlistCountElement = document.getElementById('navbarWishlistCount');
            if(wishlistCountElement) {
                if(count > 0) {
                    wishlistCountElement.textContent = count;
                    wishlistCountElement.classList.remove('hide-badge');
                } else {
                    wishlistCountElement.textContent = '';
                    wishlistCountElement.classList.add('hide-badge');
                }
            }
        @endauth
    }
    
    // Search function for navbar
    function searchProducts() {
        let searchTerm = document.getElementById('navbarSearch').value.toLowerCase();
        if(searchTerm) {
            window.location.href = "{{ url('/') }}?search=" + searchTerm;
        }
    }
    
    // Update counts on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateNavbarCartCount();
        updateNavbarWishlistCount();
    });
</script>
</body>
</html>