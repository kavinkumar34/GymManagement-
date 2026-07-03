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
        
        /* ===== PREVENT HORIZONTAL SCROLL ===== */
        html {
            overflow-x: hidden !important;
            width: 100% !important;
        }
        
        body {
            overflow-x: hidden !important;
            width: 100% !important;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }
        
        /* ===== FIXED NAVBAR - STAYS AT TOP ===== */
        .navbar {
            background: #ffffff !important;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            padding: 15px 0 !important;
            margin: 0 !important;
            width: 100% !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            z-index: 9999 !important;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        
        /* ===== NAVBAR SPACER - MINIMAL GAP ===== */
        .navbar-spacer {
            width: 100%;
            height: 105px; /* Just enough to clear the navbar */
            display: block;
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

        /* Fixed container for navbar */
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

        /* ===== CATEGORY DROPDOWN WITH SUB MENU ===== */
        .nav-item-category {
            position: relative;
        }

        .nav-item-category .nav-link {
            display: flex;
            align-items: center;
            gap: 4px;
            font-weight: 500;
            font-size: 0.85rem;
            color: #1a1a2e !important;
            padding: 8px 14px;
            text-decoration: none;
            transition: all 0.3s;
        }

        .nav-item-category .nav-link:hover {
            color: #dc3545 !important;
        }

        /* Sub Category Dropdown Menu */
        .sub-category-dropdown {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%) translateY(10px);
            background: #ffffff;
            min-width: 180px;
            max-width: 200px;
            border-radius: 12px;
            box-shadow: 0 15px 50px rgba(0,0,0,0.15);
            padding: 10px 0;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 99999;
            border: 1px solid #eef2f6;
            pointer-events: none;
        }

        .nav-item-category:hover .sub-category-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(0);
            pointer-events: auto;
        }

        .sub-category-dropdown .all-link {
            display: block;
            padding: 6px 16px 6px 16px;
            color: #1a1a2e;
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 600;
            transition: all 0.3s;
            border-bottom: 1px solid #eef2f6;
            margin: 0 0 4px 0;
            text-align: left;
        }

        .sub-category-dropdown .all-link:hover {
            color: #dc3545;
            background: #f8fafc;
        }

        .sub-category-dropdown .sub-cat-item {
            display: block;
            padding: 5px 16px;
            color: #4a5568;
            text-decoration: none;
            font-size: 0.78rem;
            transition: all 0.3s;
            font-weight: 400;
            text-align: left;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sub-category-dropdown .sub-cat-item:hover {
            color: #dc3545;
            background: #f8fafc;
        }

        .sub-category-dropdown .no-sub-text {
            padding: 12px 16px;
            color: #999;
            font-size: 0.8rem;
            text-align: center;
        }
        
        /* Bottom row with menu items */
        .navbar-bottom {
            text-align: center;
            margin-top: 10px;
        }
        
        .navbar-nav {
            display: flex;
            flex-direction: row;
            justify-content: center;
            flex-wrap: wrap;
            margin: 0;
            padding: 0;
            list-style: none;
            align-items: center;
            gap: 20px;
        }
        
        .navbar-nav .nav-item {
            list-style: none;
            flex: 0 1 auto;
        }
        
        .navbar-nav .nav-link {
            color: #1a1a2e !important;
            font-weight: 500;
            font-size: 0.85rem;
            padding: 8px 14px;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
            white-space: nowrap;
        }
        
        .navbar-nav .nav-link:hover {
            color: #dc3545 !important;
        }
        
        .nav-join-gym {
            margin-left: 5px;
        }
        
        /* Responsive Styles */
        @media (max-width: 992px) {
            .navbar-spacer {
                height: 90px;
            }
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
                gap: 0;
            }
            .navbar-nav .nav-item {
                width: 100%;
                text-align: center;
            }
            .navbar-nav .nav-link {
                padding: 10px 16px;
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
                margin-top: 5px;
            }

            .sub-category-dropdown {
                position: static;
                transform: none;
                box-shadow: none;
                border: none;
                border-top: 1px solid #eef2f6;
                border-radius: 0;
                opacity: 1;
                visibility: visible;
                pointer-events: auto;
                display: none;
                background: #f8fafc;
                padding: 5px 0;
                min-width: 100%;
                max-width: 100%;
            }

            .nav-item-category.active .sub-category-dropdown {
                display: block;
            }

            .sub-category-dropdown .sub-cat-item {
                padding: 8px 30px;
                text-align: center;
                white-space: normal;
                overflow: visible;
                text-overflow: clip;
            }

            .sub-category-dropdown .all-link {
                text-align: center;
                padding: 8px 30px;
            }
        }
        
        @media (max-width: 576px) {
            .navbar-spacer {
                height: 75px;
            }
            .navbar-nav .nav-link {
                font-size: 0.75rem;
                padding: 8px 10px;
            }
            .navbar-container {
                padding-left: 10px !important;
                padding-right: 10px !important;
            }
        }

        /* WhatsApp Float Button */
        .whatsapp-float {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background-color: #25d366;
            color: white;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4);
            z-index: 1000;
            transition: all 0.3s ease;
            text-decoration: none;
            animation: pulse 2s infinite;
        }

        .whatsapp-float:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 30px rgba(37, 211, 102, 0.6);
            color: white;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.4);
            }
            70% {
                box-shadow: 0 0 0 15px rgba(37, 211, 102, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0);
            }
        }

        /* WhatsApp Tooltip */
        .whatsapp-tooltip {
            position: fixed;
            bottom: 100px;
            right: 30px;
            background: rgba(0,0,0,0.8);
            color: white;
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            z-index: 999;
            opacity: 0;
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .whatsapp-tooltip.show {
            opacity: 1;
        }

        .whatsapp-tooltip::after {
            content: '';
            position: absolute;
            bottom: -8px;
            right: 20px;
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
            border-top: 8px solid rgba(0,0,0,0.8);
        }

        @media (max-width: 768px) {
            .whatsapp-float {
                width: 50px;
                height: 50px;
                font-size: 2rem;
                bottom: 20px;
                right: 20px;
            }
            .whatsapp-tooltip {
                bottom: 80px;
                right: 20px;
                font-size: 0.75rem;
                padding: 8px 12px;
            }
        }

        /* Alert Auto-hide animation */
        .alert-auto-hide {
            animation: fadeSlideIn 0.5s ease, fadeSlideOut 0.5s ease 4.5s forwards;
        }

        @keyframes fadeSlideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeSlideOut {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(-20px);
                display: none;
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
    
    // Get category ID by name
    if (!function_exists('getCategoryIdByName')) {
        function getCategoryIdByName($name) {
            $category = \App\Models\Category::where('name', $name)->first();
            return $category ? $category->id : null;
        }
    }
    
    // Get subcategories for a category - FIFO ORDER (First In First Out - Oldest First)
    if (!function_exists('getSubCategoriesForMenu')) {
        function getSubCategoriesForMenu($categoryId) {
            try {
                return \App\Models\SubCategory::where('category_id', $categoryId)
                    ->where('is_active', 1)
                    ->orderBy('id', 'asc')
                    ->get();
            } catch (\Exception $e) {
                return collect([]);
            }
        }
    }
    
    // Get all active categories
    if (!function_exists('getAllCategories')) {
        function getAllCategories() {
            try {
                return \App\Models\Category::where('status', 'Active')
                    ->orWhere('is_active', 1)
                    ->orderBy('display_order', 'asc')
                    ->orderBy('id', 'asc')
                    ->get();
            } catch (\Exception $e) {
                return collect([]);
            }
        }
    }

    // Define category names to display in navbar
    $categoryNames = ['Men', 'Women', 'Footwear', 'Gym Equipment', 'Massagers', 'Accessories', 'Supplements'];
    
    // Get categories with their subcategories
    $navCategories = collect();
    foreach ($categoryNames as $name) {
        $category = \App\Models\Category::where('name', $name)->first();
        if ($category) {
            $subs = getSubCategoriesForMenu($category->id);
            $navCategories->push([
                'id' => $category->id,
                'name' => $category->name,
                'subcategories' => $subs
            ]);
        }
    }
@endphp

{{-- 
    ============================================================
    FIXED NAVBAR - STAYS AT TOP ALWAYS
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
                
                <!-- Cart Icon -->
                <a class="nav-icon position-relative" href="{{ url('/cart') }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-count" id="navbarCartCount"></span>
                </a>
                
                <!-- Wishlist Icon -->
                <a class="nav-icon position-relative" href="{{ route('wishlist') }}">
                    <i class="fas fa-heart"></i>
                    <span class="cart-count" id="navbarWishlistCount"></span>
                </a>
                
                <!-- User Area -->
                @auth('admin')
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
                @foreach($navCategories as $category)
                    <li class="nav-item nav-item-category" data-category-id="{{ $category['id'] }}">
                        <a class="nav-link" href="/shop?category={{ $category['id'] }}&name={{ urlencode($category['name']) }}">
                            {{ $category['name'] }}
                        </a>
                        
                        @if($category['subcategories']->count() > 0)
                            <div class="sub-category-dropdown">
                                <a class="all-link" href="/shop?category={{ $category['id'] }}&name={{ urlencode($category['name']) }}">
                                    All
                                </a>
                                @foreach($category['subcategories'] as $sub)
                                    <a class="sub-cat-item" href="/shop?subcategory={{ $sub->id }}&name={{ urlencode($sub->name) }}">
                                        {{ $sub->name }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </li>
                @endforeach
                
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('my.orders') }}">My Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('about') }}">About Us</a>
                </li>
                
                @auth('admin')
                    <li class="nav-item nav-join-gym">
                        <a class="btn-dashboard-nav" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-1"></i> Admin Panel
                        </a>
                    </li>
                @elseif(auth()->check())
                    <li class="nav-item nav-join-gym">
                        <a class="btn-dashboard-nav" href="{{ getDashboardUrl() }}">
                            <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                        </a>
                    </li>
                @else
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

<!-- ===== NAVBAR SPACER - MINIMAL GAP ===== -->
<div class="navbar-spacer"></div>

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
<main style="margin: 0; padding: 0; overflow-x: hidden !important; width: 100%;">
    @if(session('success'))
        <div class="container" style="padding-left: 15px; padding-right: 15px;">
            <div class="alert alert-success alert-dismissible fade show alert-auto-hide" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="container" style="padding-left: 15px; padding-right: 15px;">
            <div class="alert alert-danger alert-dismissible fade show alert-auto-hide" role="alert">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif
    @yield('content')
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
                    <a href="https://wa.me/919025595190?text=Hi%20Gym%20Management%2C%20I%20need%20assistance." target="_blank" rel="noopener noreferrer"><i class="fab fa-whatsapp"></i></a>
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
                    <li>
                        <i class="fab fa-whatsapp"></i>
                        <span>
                            <a href="https://wa.me/919025595190?text=Hi%20Gym%20Management%2C%20I%20need%20assistance." 
                               target="_blank" rel="noopener noreferrer" 
                               style="color: #25d366; text-decoration: none; font-weight: 500;">
                                +91 90255 95190 (WhatsApp)
                            </a>
                        </span>
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

<!-- WhatsApp Floating Button -->
<a href="https://wa.me/919025595190?text=Hi%20Gym%20Management%2C%20I%20need%20assistance." 
   target="_blank" rel="noopener noreferrer" 
   class="whatsapp-float" 
   aria-label="Chat on WhatsApp">
    <i class="fab fa-whatsapp"></i>
</a>

<!-- WhatsApp Tooltip -->
<div class="whatsapp-tooltip" id="whatsappTooltip">
    <i class="fas fa-comment-dots me-2"></i> Chat with us on WhatsApp
</div>

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

    .social-icons a .fa-whatsapp:hover {
        color: #25d366;
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

    .footer-contact li .fa-whatsapp {
        color: #25d366;
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
        .footer-contact li {
            justify-content: center;
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
        // Auto-hide success alerts
        const successAlerts = document.querySelectorAll('.alert-success');
        successAlerts.forEach(function(alert) {
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

        // Auto-hide error alerts
        const errorAlerts = document.querySelectorAll('.alert-danger');
        errorAlerts.forEach(function(alert) {
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

        updateNavbarCartCount();
        updateNavbarWishlistCount();

        // Mobile: Toggle subcategory dropdown on click
        if (window.innerWidth <= 992) {
            document.querySelectorAll('.nav-item-category .nav-link').forEach(function(link) {
                link.addEventListener('click', function(e) {
                    const parent = this.closest('.nav-item-category');
                    if (parent) {
                        e.preventDefault();
                        parent.classList.toggle('active');
                    }
                });
            });
        }

        // Show WhatsApp tooltip after 3 seconds
        setTimeout(function() {
            const tooltip = document.getElementById('whatsappTooltip');
            if (tooltip) {
                tooltip.classList.add('show');
                setTimeout(function() {
                    tooltip.classList.remove('show');
                }, 5000);
            }
        }, 3000);

        // Show tooltip on hover of WhatsApp button
        const whatsappBtn = document.querySelector('.whatsapp-float');
        const tooltip = document.getElementById('whatsappTooltip');
        
        if (whatsappBtn && tooltip) {
            whatsappBtn.addEventListener('mouseenter', function() {
                tooltip.classList.add('show');
            });
            whatsappBtn.addEventListener('mouseleave', function() {
                tooltip.classList.remove('show');
            });
        }
    });

    // Handle window resize for mobile
    window.addEventListener('resize', function() {
        if (window.innerWidth > 992) {
            document.querySelectorAll('.nav-item-category.active').forEach(function(el) {
                el.classList.remove('active');
            });
        }
    });
</script>
</body>
</html>