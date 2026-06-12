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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
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

        /* Modern Navbar Styles */
        .navbar {
            background: #ffffff !important;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            padding: 15px 0 !important;
            margin: 0 !important;
            width: 100%;
        }
        
        /* Fixed container for navbar - ensures consistent 30px margins on ALL pages */
        .navbar-container {
            width: 100%;
            max-width: 100%;
            padding-left: 30px !important;
            padding-right: 30px !important;
            margin: 0 auto;
        }
        
        /* Top row - brand on left, icons on right */
        .navbar-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 12px;
            margin-bottom: 12px;
            border-bottom: 1px solid #eef2f6;
            flex-wrap: wrap;
        }
        
        .navbar-brand {
            color: #1a1a2e !important;
            font-weight: 700;
            font-size: 1.4rem;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        
        .navbar-brand i {
            color: #dc3545;
            margin-right: 10px;
            font-size: 1.5rem;
        }
        
        /* Right side icons container */
        .nav-icons {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }
        
        /* Search Wrapper */
        .search-wrapper {
            position: relative;
        }
        
        .search-wrapper input {
            border-radius: 30px;
            border: 1px solid #e0e0e0;
            padding: 8px 40px 8px 18px;
            font-size: 0.85rem;
            width: 240px;
            transition: all 0.3s;
            background: #f8f9fa;
        }
        
        .search-wrapper input:focus {
            outline: none;
            border-color: #dc3545;
            width: 280px;
            background: white;
            box-shadow: 0 0 0 2px rgba(220,53,69,0.1);
        }
        
        .search-wrapper button {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #999;
            cursor: pointer;
            font-size: 1rem;
        }
        
        .search-wrapper button:hover {
            color: #dc3545;
        }
        
        /* Nav Icons */
        .nav-icon {
            position: relative;
            font-size: 1.2rem;
            color: #1a1a2e;
            transition: all 0.3s;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        
        .nav-icon:hover {
            color: #dc3545;
        }
        
        /* Join Gym Button */
        .btn-join-gym {
            background: #dc3545;
            color: white;
            border-radius: 25px;
            padding: 7px 20px;
            transition: all 0.3s;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
            font-size: 0.85rem;
            border: none;
            cursor: pointer;
        }
        
        .btn-join-gym:hover {
            background: #000000;
            transform: scale(1.02);
            color: white;
        }
        
        /* Dashboard Button for logged in users */
        .btn-dashboard-nav {
            background: #28a745;
            color: white;
            border-radius: 25px;
            padding: 7px 20px;
            transition: all 0.3s;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
            font-size: 0.85rem;
        }
        
        .btn-dashboard-nav:hover {
            background: #000000;
            transform: scale(1.02);
            color: white;
        }
        
        /* Dropdown Styles */
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-radius: 8px;
            padding: 8px 0;
            margin-top: 8px;
        }
        
        .dropdown-item {
            padding: 8px 20px;
            font-size: 0.85rem;
            color: #333;
            transition: all 0.2s;
        }
        
        .dropdown-item:hover {
            background: #dc3545;
            color: white;
        }
        
        /* User Dropdown Toggle */
        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            text-decoration: none;
            color: #1a1a2e;
            padding: 5px 10px;
            border-radius: 30px;
            transition: all 0.3s;
        }
        
        .user-dropdown:hover {
            background: #f8f9fa;
            color: #dc3545;
        }
        
        /* Bottom row with menu items centered */
        .navbar-bottom {
            text-align: center;
            margin-top: 10px;
        }
        
        .navbar-nav {
            display: inline-flex;
            flex-direction: row;
            gap: 0;
            justify-content: center;
            flex-wrap: wrap;
            margin: 0;
            padding: 0;
            list-style: none;
            align-items: center;
        }
        
        .navbar-nav .nav-item {
            list-style: none;
        }
        
        .navbar-nav .nav-link {
            color: #1a1a2e !important;
            font-weight: 500;
            font-size: 0.85rem;
            padding: 8px 16px;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        
        .navbar-nav .nav-link:hover {
            color: #dc3545 !important;
        }
        
        /* Join Gym button in bottom nav */
        .nav-join-gym {
            margin-left: 10px;
        }
        
        /* Responsive Styles */
        @media (max-width: 992px) {
            .navbar-container {
                padding-left: 15px !important;
                padding-right: 15px !important;
            }
            .navbar-top {
                flex-direction: column;
                gap: 15px;
            }
            .navbar-nav {
                flex-direction: column;
                width: 100%;
            }
            .search-wrapper input {
                width: 100%;
            }
            .search-wrapper input:focus {
                width: 100%;
            }
            .nav-icons {
                flex-wrap: wrap;
                justify-content: center;
            }
            .navbar-brand {
                justify-content: center;
            }
            .nav-join-gym {
                margin-left: 0;
                margin-top: 10px;
            }
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
    
    if (!function_exists('getContactUrl')) {
        function getContactUrl() {
            if (auth()->check()) {
                return route('contact');
            }
            return route('login');
        }
    }
@endphp

{{-- 
    ============================================================
    UNIVERSAL SINGLE NAVBAR - SAME FOR BOTH LOGGED IN AND LOGGED OUT USERS
    Navbar has 30px left and right margins on ALL pages
    ============================================================
--}}
<nav class="navbar">
    <div class="navbar-container">
        <div class="navbar-top">
            <!-- Brand on LEFT side -->
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-dumbbell"></i>
                <strong>Gym Management</strong>
            </a>
            
            <!-- Icons on RIGHT side -->
            <div class="nav-icons">
                <!-- Search Box -->
                <div class="search-wrapper">
                    <form onsubmit="event.preventDefault(); searchProducts();">
                        <input type="text" id="navbarSearch" placeholder="Search for products...">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>
                
                <!-- Cart Icon - Same for all users -->
                <a class="nav-icon position-relative" href="{{ url('/cart') }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-count" id="navbarCartCount"></span>
                </a>
                
                <!-- Wishlist Icon - Same for all users -->
                <a class="nav-icon position-relative" href="{{ route('wishlist') }}">
                    <i class="fas fa-heart"></i>
                    <span class="cart-count" id="navbarWishlistCount"></span>
                </a>
                
                <!-- User Area - Changes based on login status -->
                @auth('admin')
                    {{-- Admin Logged In --}}
                    <div class="dropdown">
                        <a class="user-dropdown dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <div class="profile-icon">
                                <i class="fas fa-user-shield"></i>
                            </div>
                            <span>Admin</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i> Admin Panel</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('admin-logout-from-navbar').submit();"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                        </ul>
                    </div>
                @elseif(auth()->check())
                    {{-- Regular User (Member/Trainer) Logged In --}}
                    <div class="dropdown">
                        <a class="user-dropdown dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <div class="profile-icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-id-card me-2"></i> My Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('my.orders') }}"><i class="fas fa-shopping-bag me-2"></i> My Orders</a></li>
                            @if(auth()->user()->role == 'trainer')
                                <li><a class="dropdown-item" href="{{ route('trainer.dashboard') }}"><i class="fas fa-chalkboard-user me-2"></i> Trainer Dashboard</a></li>
                            @else
                                <li><a class="dropdown-item" href="{{ route('member.dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i> Member Dashboard</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); localStorage.removeItem('cart'); localStorage.removeItem('wishlist'); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                        </ul>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Bottom Navigation Menu -->
        <div class="navbar-bottom">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">New Arrivals</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Men</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Women</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Apparel</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Footwear</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Gym Equipment</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Massagers</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Accessories</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Supplements</a></li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('my.orders') }}">My Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('about') }}">About Us</a>
                </li>                
                <!-- Join Gym / Dashboard Button - Shows in bottom row after Bulk Orders -->
                @auth('admin')
                    {{-- Admin Logged In - Show Admin Panel button --}}
                    <li class="nav-item nav-join-gym">
                        <a class="btn-dashboard-nav" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-1"></i> Admin Panel
                        </a>
                    </li>
                @elseif(auth()->check())
                    {{-- Regular User Logged In - Show Dashboard button --}}
                    <li class="nav-item nav-join-gym">
                        <a class="btn-dashboard-nav" href="{{ getDashboardUrl() }}">
                            <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                        </a>
                    </li>
                @else
                    {{-- No User Logged In - Show Join Gym button --}}
                    <li class="nav-item nav-join-gym">
                        <a class="btn-join-gym" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i> Join Gym
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

{{-- Hidden forms for logout --}}
@auth('admin')
    <form id="admin-logout-from-navbar" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
@elseif(auth()->check())
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
@endauth

{{-- For admin dashboard pages, include the admin navbar --}}
@auth('admin')
    @if(!Route::is('home') && !Route::is('login') && !Route::is('admin.login') && !Route::is('admin.register'))
        @include('layouts.admin-navbar')
    @endif
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
            <div class="col-md-4 mb-4">
                <div class="footer-logo">
                    <i class="fas fa-dumbbell me-2"></i>
                    <strong>Gym Management</strong>
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

            <div class="col-md-2 mb-4">
                <h5>Quick Links</h5>
                <ul class="footer-links">
                    <li><a href="{{ url('/') }}"><i class="fas fa-chevron-right"></i> Home</a></li>
                    <li><a href="{{ route('about') }}"><i class="fas fa-chevron-right"></i> About Us</a></li>
                    <li><a href="@if(auth()->check()) {{ route('contact') }} @else {{ route('login') }} @endif"><i class="fas fa-chevron-right"></i> Contact</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Blog</a></li>
                </ul>
            </div>

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

        <div class="row bottom-bar">
            <div class="col-md-6 text-center text-md-start">
                <p>&copy; {{ date('Y') }} Gym Management. All rights reserved.</p>
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
    function refreshCaptcha() {
        const img = document.getElementById('captcha-img');
        if (img) {
            img.src = '{{ url("/captcha") }}?' + Math.random();
        }
    }
    
    function updateNavbarCartCount() {
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
    }
    
    function updateNavbarWishlistCount() {
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
    }
    
    function searchProducts() {
        let searchTerm = document.getElementById('navbarSearch').value.toLowerCase();
        if(searchTerm) {
            window.location.href = "{{ url('/') }}?search=" + searchTerm;
        }
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        updateNavbarCartCount();
        updateNavbarWishlistCount();
    });
</script>
</body>
</html>