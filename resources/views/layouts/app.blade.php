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
            height: 105px;
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

        /* ===== PROFILE MODAL STYLES ===== */
        .profile-modal .modal-content {
            border-radius: 20px;
            overflow: hidden;
            max-width: 500px;
            margin: 0 auto;
        }
        .profile-modal .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-bottom: none;
            padding: 20px;
        }
        .profile-modal .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }
        .profile-modal .modal-body {
            padding: 25px;
        }
        .profile-modal .modal-footer {
            padding: 15px 25px 25px;
            border-top: none;
        }
        .profile-avatar-lg {
            width: 80px;
            height: 80px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 35px;
            color: white;
        }
        .profile-info-item {
            display: flex;
            padding: 10px 0;
            border-bottom: 1px solid #eef2f6;
        }
        .profile-info-item:last-child {
            border-bottom: none;
        }
        .profile-info-label {
            width: 100px;
            font-weight: 600;
            color: #64748b;
            font-size: 14px;
        }
        .profile-info-value {
            flex: 1;
            color: #1e293b;
            font-size: 14px;
        }
        .profile-info-value .edit-input {
            display: none;
            width: 100%;
            padding: 6px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
        }
        .profile-info-value .edit-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
        }
        .profile-info-value .edit-input.show {
            display: block;
        }
        .profile-info-value .display-text.hide {
            display: none;
        }
        .btn-edit-profile-modal {
            background: #667eea;
            color: white;
            border: none;
            padding: 8px 25px;
            border-radius: 25px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-edit-profile-modal:hover {
            background: #5a4bd1;
            transform: translateY(-2px);
        }
        .btn-save-profile-modal {
            background: #10b981;
            color: white;
            border: none;
            padding: 8px 25px;
            border-radius: 25px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            display: none;
        }
        .btn-save-profile-modal:hover {
            background: #059669;
            transform: translateY(-2px);
        }
        .btn-cancel-profile-modal {
            background: #e2e8f0;
            color: #64748b;
            border: none;
            padding: 8px 25px;
            border-radius: 25px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            display: none;
        }
        .btn-cancel-profile-modal:hover {
            background: #cbd5e1;
        }
        .btn-save-profile-modal.show,
        .btn-cancel-profile-modal.show {
            display: inline-block;
        }
        /* ===== PROFILE MODAL - RIGHT SIDE STYLES ===== */
/* ===== PROFILE MODAL - RIGHT SIDE WITH REDUCED HEIGHT ===== */
.profile-modal {
    z-index: 99999 !important;
}

.profile-modal .modal-dialog {
    margin: 50px 20px 20px auto !important;
    max-width: 380px !important;
    height: auto !important;
    display: flex !important;
    align-items: flex-start !important;
    z-index: 99999 !important;
}

.profile-modal .modal-content {
    border-radius: 16px !important;
    min-height: 0 !important;
    max-height: 85vh !important;
    overflow-y: auto !important;
    border: none !important;
    box-shadow: -5px 0 30px rgba(0,0,0,0.1) !important;
    background: #ffffff !important;
    z-index: 99999 !important;
}

.modal-backdrop {
    z-index: 99998 !important;
    background-color: rgba(0,0,0,0.3) !important;
}

.profile-modal .modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    color: white !important;
    border-bottom: none !important;
    padding: 20px !important;
    position: sticky !important;
    top: 0 !important;
    z-index: 10 !important;
    border-radius: 16px 16px 0 0 !important;
}

.profile-modal .modal-header .btn-close {
    filter: brightness(0) invert(1) !important;
    opacity: 0.8 !important;
}

.profile-modal .modal-body {
    padding: 20px !important;
}

.profile-modal .modal-footer {
    padding: 15px 20px 20px !important;
    border-top: none !important;
    position: sticky !important;
    bottom: 0 !important;
    background: white !important;
    border-radius: 0 0 16px 16px !important;
}

.profile-avatar-lg {
    width: 60px;
    height: 60px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 10px;
    font-size: 26px;
    color: white;
}

.profile-info-item {
    display: flex;
    padding: 8px 0;
    border-bottom: 1px solid #eef2f6;
}
.profile-info-item:last-child {
    border-bottom: none;
}
.profile-info-label {
    width: 85px;
    font-weight: 600;
    color: #64748b;
    font-size: 12px;
}
.profile-info-value {
    flex: 1;
    color: #1e293b;
    font-size: 13px;
}
.profile-info-value .edit-input {
    display: none;
    width: 100%;
    padding: 4px 10px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-size: 13px;
}
.profile-info-value .edit-input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
}
.profile-info-value .edit-input.show {
    display: block;
}
.profile-info-value .display-text.hide {
    display: none;
}

.btn-edit-profile-modal,
.btn-save-profile-modal,
.btn-cancel-profile-modal {
    width: 100%;
    padding: 8px 20px;
    border-radius: 25px;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.3s;
    border: none;
    font-weight: 500;
}

.btn-edit-profile-modal {
    background: #667eea;
    color: white;
}
.btn-edit-profile-modal:hover {
    background: #5a4bd1;
    transform: translateY(-2px);
}

.btn-save-profile-modal {
    background: #10b981;
    color: white;
    display: none;
}
.btn-save-profile-modal:hover {
    background: #059669;
    transform: translateY(-2px);
}

.btn-cancel-profile-modal {
    background: #e2e8f0;
    color: #64748b;
    display: none;
}
.btn-cancel-profile-modal:hover {
    background: #cbd5e1;
}

.btn-save-profile-modal.show,
.btn-cancel-profile-modal.show {
    display: block;
}

/* Animation for right side modal */
.profile-modal .modal-dialog {
    transform: translateX(100%) !important;
    transition: transform 0.3s ease !important;
}

.profile-modal.show .modal-dialog {
    transform: translateX(0) !important;
}

/* Responsive */
@media (max-width: 576px) {
    .profile-modal .modal-dialog {
        margin: 20px 10px 10px auto !important;
        max-width: 100% !important;
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
                            <li><a class="dropdown-item" href="#" onclick="openProfileModal(); return false;"><i class="fas fa-id-card me-2"></i> My Profile</a></li>
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

<!-- ===== PROFILE MODAL ===== -->
@auth
<!-- ===== PROFILE MODAL - RIGHT SIDE ===== -->
@auth
<div class="modal fade profile-modal" id="profileModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-end" style="max-width: 380px; margin: 0 0 0 auto; height: 100vh; display: flex; align-items: stretch;">
        <div class="modal-content" style="border-radius: 0; min-height: 100vh; max-height: 100vh; overflow-y: auto; border: none; box-shadow: -5px 0 30px rgba(0,0,0,0.1);">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-bottom: none; padding: 20px; position: sticky; top: 0; z-index: 10;">
                <div class="text-center w-100">
                    <div class="profile-avatar-lg">
                        <i class="fas fa-user"></i>
                    </div>
                    <h5 class="mb-0" id="modalProfileName">{{ Auth::user()->name }}</h5>
                </div>
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding: 20px;">
                <div class="profile-info-item">
                    <div class="profile-info-label">Full Name</div>
                    <div class="profile-info-value">
                        <span class="display-text" id="modalNameDisplay">{{ Auth::user()->name }}</span>
                        <input type="text" class="edit-input" id="modalNameInput" value="{{ Auth::user()->name }}">
                    </div>
                </div>
                <div class="profile-info-item">
                    <div class="profile-info-label">Email</div>
                    <div class="profile-info-value">
                        <span class="display-text">{{ Auth::user()->email }}</span>
                    </div>
                </div>
                <div class="profile-info-item">
                    <div class="profile-info-label">Phone</div>
                    <div class="profile-info-value">
                        <span class="display-text">{{ Auth::user()->phone ?? 'Not provided' }}</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="padding: 15px 20px 20px; border-top: none; position: sticky; bottom: 0; background: white;">
                <button class="btn-edit-profile-modal" id="modalEditProfileBtn" onclick="enableModalProfileEdit()" style="width: 100%;">
                    <i class="fas fa-edit"></i> Edit Profile
                </button>
                <button class="btn-save-profile-modal" id="modalSaveProfileBtn" onclick="saveModalProfile()" style="width: 100%; display: none;">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                <button class="btn-cancel-profile-modal" id="modalCancelProfileBtn" onclick="cancelModalProfileEdit()" style="width: 100%; display: none;">
                    <i class="fas fa-times"></i> Cancel
                </button>
            </div>
        </div>
    </div>
</div>
@endauth
@endauth

<script>
// ===== PROFILE MODAL FUNCTIONS =====
function openProfileModal() {
    // Reset to view mode
    cancelModalProfileEdit();
    const modal = new bootstrap.Modal(document.getElementById('profileModal'), {
        backdrop: true,
        keyboard: true
    });
    modal.show();
}

function enableModalProfileEdit() {
    document.getElementById('modalNameDisplay').style.display = 'none';
    document.getElementById('modalNameInput').style.display = 'block';
    document.getElementById('modalEditProfileBtn').style.display = 'none';
    document.getElementById('modalSaveProfileBtn').style.display = 'block';
    document.getElementById('modalCancelProfileBtn').style.display = 'block';
    document.getElementById('modalNameInput').focus();
}

function cancelModalProfileEdit() {
    document.getElementById('modalNameDisplay').style.display = 'block';
    document.getElementById('modalNameInput').style.display = 'none';
    document.getElementById('modalEditProfileBtn').style.display = 'block';
    document.getElementById('modalSaveProfileBtn').style.display = 'none';
    document.getElementById('modalCancelProfileBtn').style.display = 'none';
    document.getElementById('modalNameInput').value = document.getElementById('modalNameDisplay').textContent;
}

async function saveModalProfile() {
    const name = document.getElementById('modalNameInput').value.trim();
    
    if (!name) {
        alert('Name cannot be empty!');
        return;
    }
    
    const saveBtn = document.getElementById('modalSaveProfileBtn');
    const originalText = saveBtn.innerHTML;
    saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
    saveBtn.disabled = true;
    
    try {
        const response = await fetch('/api/update-profile', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ name: name })
        });
        
        const data = await response.json();
        
        if (data.success) {
            document.getElementById('modalProfileName').textContent = name;
            document.getElementById('modalNameDisplay').textContent = name;
            
            // Update navbar name
            const navbarName = document.querySelector('.user-dropdown span');
            if (navbarName) {
                navbarName.textContent = name;
            }
            
            alert('Profile updated successfully!');
            cancelModalProfileEdit();
        } else {
            alert(data.message || 'Error updating profile');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Network error. Please try again.');
    } finally {
        saveBtn.innerHTML = originalText;
        saveBtn.disabled = false;
    }
}

// ===== CART & WISHLIST FUNCTIONS =====
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

<!-- ===== SINGLE FOOTER SECTION ===== -->
<footer class="footer mt-auto">
    <div class="container">
        <div class="row">
            <!-- Column 1: Logo & About -->
            <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
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

            <!-- Column 2: Quick Links -->
            <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                <h5>Quick Links</h5>
                <ul class="footer-links">
                    <li><a href="{{ url('/') }}"><i class="fas fa-chevron-right"></i> Home</a></li>
                    <li><a href="{{ route('about') }}"><i class="fas fa-chevron-right"></i> About Us</a></li>
                    <li><a href="@if(auth()->check()) {{ route('contact') }} @else {{ route('login') }} @endif"><i class="fas fa-chevron-right"></i> Contact</a></li>
                    <li><a href="@if(auth()->check()) {{ route('my.orders') }} @else {{ route('login') }} @endif"><i class="fas fa-chevron-right"></i> My Orders</a></li>
                </ul>
            </div>

            <!-- Column 3: Customer Service -->
            <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                <h5>Customer Service</h5>
                <ul class="footer-links">
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Returns & Exchange</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> FAQ</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Privacy Policy</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Terms & Conditions</a></li>
                </ul>
            </div>

            <!-- Column 4: Get In Touch -->
            <div class="col-lg-4 col-md-6">
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
                        <i class="fab fa-whatsapp"></i>
                        <span>
                            <a href="https://wa.me/919025595190?text=Hi%20Gym%20Management%2C%20I%20need%20assistance." 
                               target="_blank" rel="noopener noreferrer" 
                               style="color: #a0a0c0; text-decoration: none; font-weight: 500;">
                                +91 90255 95190
                            </a>
                        </span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="row bottom-bar">
            <div class="col-12 text-center">
                <p class="mb-0">&copy; {{ date('Y') }} Gym Management. All rights reserved.</p>
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
        max-width: 350px;
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
        margin-bottom: 25px;
        position: relative;
        padding-bottom: 12px;
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

    /* Quick Links & Customer Service */
    .footer-links {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .footer-links li {
        margin-bottom: 12px;
    }

    .footer-links li a {
        display: flex;
        align-items: center;
        color: #a0a0c0;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .footer-links li a i {
        width: 16px;
        margin-right: 10px;
        font-size: 10px;
        color: #e94560;
    }

    .footer-links li a:hover {
        color: #e94560;
        transform: translateX(5px);
    }

    /* Contact Info */
    .footer-contact {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .footer-contact li {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 14px;
    }

    .footer-contact li i {
        color: #e94560;
        font-size: 1rem;
        margin-top: 3px;
        min-width: 20px;
    }

    .footer-contact li span {
        font-size: 0.9rem;
        line-height: 1.5;
    }


    /* Bottom Bar */
    .bottom-bar {
        padding: 20px 0;
        margin-top: 30px;
        border-top: 1px solid rgba(255,255,255,0.05);
        font-size: 0.85rem;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .footer h5::after {
            left: 50%;
            transform: translateX(-50%);
        }
        .footer-about {
            max-width: 100%;
            text-align: center;
        }
        .footer .social-icons {
            text-align: center;
        }
        .footer-contact li {
            justify-content: center;
        }
        .footer-links li a {
            justify-content: center;
        }
    }

    @media (max-width: 768px) {
        .footer {
            text-align: center;
            padding-top: 40px;
        }
        .footer h5 {
            margin-top: 20px;
        }
        .footer h5::after {
            left: 50%;
            transform: translateX(-50%);
        }
        .footer-links li a {
            justify-content: center;
        }
        .footer-contact li {
            justify-content: center;
        }
        .bottom-bar {
            text-align: center;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>