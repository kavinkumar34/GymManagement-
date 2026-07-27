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
        /* ============================================================ */
        /* ===== GLOBAL RESET ===== */
        /* ============================================================ */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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

        /* ============================================================ */
        /* ===== FIXED NAVBAR ===== */
        /* ============================================================ */
        .navbar {
            background: #ffffff !important;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            padding: 10px 0 !important;
            margin: 0 !important;
            width: 100% !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            z-index: 9999 !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .navbar-container {
            width: 100%;
            max-width: 100%;
            padding-left: 25px !important;
            padding-right: 25px !important;
            margin: 0 auto;
        }

        /* ===== NAVBAR SPACER ===== */
        .navbar-spacer {
            width: 100%;
            height: 105px;
            display: block;
        }

        /* ============================================================ */
        /* ===== TOP ROW ===== */
        /* ============================================================ */
        .navbar-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 8px;
            margin-bottom: 8px;
            border-bottom: 1px solid #eef2f6;
            flex-wrap: wrap;
            gap: 10px;
        }

        .navbar-brand {
            color: #1a1a2e !important;
            font-weight: 700;
            font-size: 1.3rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            flex-shrink: 0;
        }

        .navbar-brand i {
            color: #dc3545;
            margin-right: 10px;
            font-size: 1.4rem;
        }

        /* ===== NAV ICONS ===== */
        .nav-icons {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        /* Search */
        .search-wrapper {
            position: relative;
        }

        .search-wrapper input {
            border-radius: 30px;
            border: 1px solid #e0e0e0;
            padding: 7px 40px 7px 18px;
            font-size: 0.85rem;
            width: 220px;
            transition: all 0.3s;
            background: #f8f9fa;
            height: 38px;
        }

        .search-wrapper input:focus {
            outline: none;
            border-color: #dc3545;
            width: 260px;
            background: white;
            box-shadow: 0 0 0 2px rgba(220, 53, 69, 0.1);
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

        .cart-count {
            position: absolute;
            top: -8px;
            right: -10px;
            background: #ff4757;
            color: white;
            border-radius: 50%;
            padding: 1px 6px;
            font-size: 10px;
            font-weight: bold;
            min-width: 18px;
            text-align: center;
        }

        .cart-count.hide-badge {
            display: none;
        }

        /* User Dropdown */
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
            font-size: 0.85rem;
        }

        .user-dropdown:hover {
            background: #f8f9fa;
            color: #dc3545;
        }

        .profile-icon {
            width: 32px;
            height: 32px;
            background: #e94560;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-icon i {
            font-size: 0.85rem;
            color: white;
            margin: 0;
        }

        /* Buttons */
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
            white-space: nowrap;
        }

        .btn-join-gym:hover {
            background: #000000;
            transform: scale(1.02);
            color: white;
        }

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
            white-space: nowrap;
        }

        .btn-dashboard-nav:hover {
            background: #000000;
            transform: scale(1.02);
            color: white;
        }

        /* ===== HAMBURGER BUTTON - Desktop Hidden, Mobile Visible ===== */
        .hamburger-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.6rem;
            color: #1a1a2e;
            cursor: pointer;
            padding: 5px 8px;
            transition: all 0.3s;
            margin-left: 5px;
        }

        .hamburger-btn:hover {
            color: #dc3545;
        }

        /* ============================================================ */
        /* ===== BOTTOM ROW - DESKTOP MENU ===== */
        /* ============================================================ */
        .navbar-bottom {
            text-align: center;
            margin-top: 5px;
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
            gap: 5px 20px;
        }

        .navbar-nav .nav-item {
            list-style: none;
        }

        .navbar-nav .nav-link {
            color: #1a1a2e !important;
            font-weight: 500;
            font-size: 0.85rem;
            padding: 6px 12px;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
            white-space: nowrap;
        }

        .navbar-nav .nav-link:hover {
            color: #dc3545 !important;
        }

        /* ============================================================ */
        /* ===== CATEGORY DROPDOWN - DESKTOP HOVER ===== */
        /* ============================================================ */
        .nav-item-category {
            position: relative;
        }

        .sub-category-dropdown {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%) translateY(10px);
            background: #ffffff;
            min-width: 160px;
            max-width: 200px;
            border-radius: 12px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
            padding: 8px 0;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 99999;
            border: 1px solid #eef2f6;
            pointer-events: none;
        }

        /* Desktop Hover */
        @media (min-width: 993px) {
            .nav-item-category:hover .sub-category-dropdown {
                opacity: 1;
                visibility: visible;
                transform: translateX(-50%) translateY(0);
                pointer-events: auto;
            }
        }

        .sub-category-dropdown .all-link {
            display: block;
            padding: 5px 16px;
            color: #1a1a2e;
            text-decoration: none;
            font-size: 0.78rem;
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
            padding: 4px 16px;
            color: #4a5568;
            text-decoration: none;
            font-size: 0.76rem;
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

        /* ===== DESKTOP: HIDE ARROW ICON ===== */
        .arrow-icon {
            display: none !important;
        }

        .nav-join-gym {
            margin-left: 5px;
        }

        /* Dropdown Menu */
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
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

        /* ============================================================ */
        /* ============================================================ */
        /* ===== RESPONSIVE - MOBILE & TABLET ===== */
        /* ============================================================ */
        /* ============================================================ */

        /* ===== TABLET (≤992px) ===== */
        @media (max-width: 992px) {
            .navbar-spacer {
                height: 75px;
            }

            .navbar-container {
                padding-left: 15px !important;
                padding-right: 15px !important;
            }

            /* Show hamburger */
            .hamburger-btn {
                display: block;
            }

            /* Hide bottom menu by default, show when open */
            .navbar-bottom {
                display: none;
                flex-direction: column;
                width: 100%;
                border-top: 1px solid #eef2f6;
                margin-top: 8px;
                padding-top: 10px;
                text-align: left;
            }

            .navbar-bottom.open {
                display: flex;
            }

            /* Mobile menu items - LEFT ALIGNED */
            .navbar-nav {
                flex-direction: column;
                width: 100%;
                gap: 0;
                align-items: flex-start;
            }

            .navbar-nav .nav-item {
                width: 100%;
                text-align: left;
            }

            .navbar-nav .nav-link {
                padding: 8px 12px;
                width: 100%;
                font-size: 0.85rem;
                text-align: left;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .nav-join-gym {
                margin-left: 0;
                margin-top: 5px;
                width: 100%;
            }

            .nav-join-gym .btn-join-gym,
            .nav-join-gym .btn-dashboard-nav {
                width: 100%;
                text-align: center;
                padding: 8px 20px;
                display: block;
            }

            /* ===== MOBILE: SHOW ARROW ICON ===== */
            .arrow-icon {
                display: inline-block !important;
                font-size: 0.7rem;
                transition: transform 0.3s;
                color: #999;
            }

            .nav-item-category.active .arrow-icon {
                transform: rotate(180deg);
            }

            /* ===== MOBILE: CLICK TO SHOW DROPDOWN ===== */
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
                margin: 0;
                transition: none;
            }

            /* Show dropdown when parent has active class */
            .nav-item-category.active .sub-category-dropdown {
                display: block;
            }

            .sub-category-dropdown .sub-cat-item {
                padding: 6px 20px 6px 30px;
                text-align: left;
                white-space: normal;
                overflow: visible;
                text-overflow: clip;
                font-size: 0.8rem;
            }

            .sub-category-dropdown .all-link {
                text-align: left;
                padding: 6px 20px 6px 30px;
                font-size: 0.8rem;
            }

            /* Mobile: category link with arrow */
            .nav-item-category .nav-link {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 5px;
            }
        }

        /* ===== MOBILE (≤576px) - SEARCH ON SAME LINE ===== */
        @media (max-width: 576px) {
            .navbar-spacer {
                height: 72px;
            }

            .navbar {
                padding: 5px 0 !important;
            }

            .navbar-container {
                padding-left: 10px !important;
                padding-right: 10px !important;
            }

            .navbar-top {
                gap: 5px;
                padding-bottom: 3px;
                margin-bottom: 3px;
                flex-wrap: nowrap;
                justify-content: space-between;
            }

            .navbar-brand {
                font-size: 0.85rem;
                flex-shrink: 0;
            }

            .navbar-brand i {
                font-size: 0.95rem;
                margin-right: 4px;
            }

            /* ===== SEARCH - SAME LINE ON MOBILE ===== */
            .search-wrapper {
                display: flex !important;
                flex: 1;
                min-width: 80px;
                max-width: 120px;
                margin: 0 4px;
            }

            .search-wrapper input {
                width: 100% !important;
                height: 30px;
                padding: 4px 30px 4px 10px;
                font-size: 0.7rem;
                border-radius: 20px;
                border: 1px solid #e0e0e0;
            }

            .search-wrapper input:focus {
                width: 100% !important;
            }

            .search-wrapper button {
                right: 8px;
                font-size: 0.7rem;
            }

            /* ===== SEARCH RESULTS - MOBILE (NAME ONLY) ===== */
            .search-results-dropdown {
                max-height: 300px;
                margin-top: 3px;
                border-radius: 8px;
                min-width: 200px;
                right: 0;
                left: auto;
            }

            .search-result-item {
                padding: 8px 12px;
                gap: 8px;
            }

            .search-result-item .result-image {
                width: 28px;
                height: 28px;
                border-radius: 6px;
            }

            .search-result-item .result-info {
                display: flex;
                flex-direction: column;
                gap: 0;
            }

            /* ===== MOBILE: ONLY SHOW PRODUCT NAME ===== */
            .search-result-item .result-name {
                font-size: 0.78rem;
                font-weight: 500;
                color: #1a1a2e;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .search-result-item .result-price {
                display: none !important;
            }

            .search-result-item .result-category {
                display: none !important;
            }

            .no-results {
                font-size: 0.78rem;
                padding: 12px;
            }

            .search-loading {
                font-size: 0.78rem;
                padding: 12px;
            }

            .view-all-results {
                padding: 6px 12px;
            }

            .view-all-results a {
                font-size: 0.75rem;
            }

            /* ===== NAV ICONS - COMPACT ===== */
            .nav-icons {
                gap: 4px;
                flex-wrap: nowrap;
            }

            .nav-icon {
                font-size: 0.9rem;
            }

            .cart-count {
                font-size: 7px;
                min-width: 12px;
                padding: 0px 3px;
                top: -5px;
                right: -7px;
            }

            .profile-icon {
                width: 22px;
                height: 22px;
            }

            .profile-icon i {
                font-size: 0.6rem;
            }

            .user-dropdown {
                font-size: 0.7rem;
                padding: 2px 4px;
            }

            .user-dropdown span {
                display: none;
            }

            .hamburger-btn {
                font-size: 1.1rem;
                padding: 2px 4px;
                margin-left: 2px;
            }

            /* ===== BOTTOM MENU ===== */
            .navbar-nav .nav-link {
                font-size: 0.78rem;
                padding: 5px 10px;
            }

            .sub-category-dropdown .sub-cat-item {
                padding: 4px 12px 4px 20px;
                font-size: 0.72rem;
            }

            .sub-category-dropdown .all-link {
                padding: 4px 12px 4px 20px;
                font-size: 0.72rem;
            }

            .btn-join-gym,
            .btn-dashboard-nav {
                font-size: 0.68rem;
                padding: 4px 10px;
            }
        }

        /* ===== VERY SMALL (≤400px) ===== */
        @media (max-width: 400px) {
            .navbar-spacer {
                height: 68px;
            }

            .navbar-brand {
                font-size: 0.75rem;
            }

            .navbar-brand i {
                font-size: 0.8rem;
            }

            .search-wrapper {
                min-width: 60px;
                max-width: 90px;
            }

            .search-wrapper input {
                height: 26px;
                font-size: 0.65rem;
                padding: 3px 25px 3px 8px;
            }

            .search-wrapper button {
                font-size: 0.6rem;
                right: 6px;
            }

            .search-results-dropdown {
                max-height: 250px;
                min-width: 160px;
            }

            .search-result-item {
                padding: 6px 10px;
            }

            .search-result-item .result-image {
                width: 24px;
                height: 24px;
            }

            .search-result-item .result-name {
                font-size: 0.72rem;
            }

            .nav-icon {
                font-size: 0.8rem;
            }

            .hamburger-btn {
                font-size: 1rem;
            }

            .profile-icon {
                width: 20px;
                height: 20px;
            }

            .profile-icon i {
                font-size: 0.55rem;
            }

            .cart-count {
                font-size: 6px;
                min-width: 10px;
                padding: 0px 2px;
                top: -4px;
                right: -6px;
            }

            .navbar-nav .nav-link {
                font-size: 0.7rem;
                padding: 4px 8px;
            }
        }

        /* ============================================================ */
        /* ============================================================ */
        /* ===== OTHER STYLES ===== */
        /* ============================================================ */

        .captcha-img {
            cursor: pointer;
            border-radius: 8px;
            border: 1px solid #ddd;
            height: 45px;
            width: auto;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            transition: 0.3s;
        }

        .hide-sidebar .admin-sidebar,
        .hide-sidebar .admin-main-content {
            display: none !important;
        }

        /* Alert Auto-hide */
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

        /* ============================================================ */
        /* ===== PROFILE MODAL ===== */
        /* ============================================================ */
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
            box-shadow: -5px 0 30px rgba(0, 0, 0, 0.1) !important;
            background: #ffffff !important;
            z-index: 99999 !important;
        }

        .modal-backdrop {
            z-index: 99998 !important;
            background-color: rgba(0, 0, 0, 0.3) !important;
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
            background: rgba(255, 255, 255, 0.2);
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
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
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
            width: 100%;
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
            width: 100%;
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
            width: 100%;
        }

        .btn-cancel-profile-modal:hover {
            background: #cbd5e1;
        }

        .btn-save-profile-modal.show,
        .btn-cancel-profile-modal.show {
            display: block;
        }

        .profile-modal .modal-dialog {
            transform: translateX(100%) !important;
            transition: transform 0.3s ease !important;
        }

        .profile-modal.show .modal-dialog {
            transform: translateX(0) !important;
        }

        @media (max-width: 576px) {
            .profile-modal .modal-dialog {
                margin: 20px 10px 10px auto !important;
                max-width: 100% !important;
            }
        }

        /* ============================================================ */
        /* ===== FOOTER ===== */
        /* ============================================================ */
        .footer {
            background: linear-gradient(135deg, #0f0f1a 0%, #1a1a2e 100%);
            color: #a0a0c0;
            padding-top: 50px;
            margin-top: 60px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
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
            background: rgba(255, 255, 255, 0.05);
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

        .bottom-bar {
            padding: 20px 0;
            margin-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            font-size: 0.85rem;
        }

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

        /* ============================================================ */
        /* ===== WHATSAPP FLOAT ===== */
        /* ============================================================ */
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

        .whatsapp-tooltip {
            position: fixed;
            bottom: 100px;
            right: 30px;
            background: rgba(0, 0, 0, 0.8);
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
            border-top: 8px solid rgba(0, 0, 0, 0.8);
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

        .custom-toast {
            position: fixed;
            top: 25px;
            right: 25px;
            background: #10b981;
            color: #fff;
            padding: 15px 22px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .2);
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 999999;
            opacity: 0;
            transform: translateX(100%);
            transition: .4s;
            font-size: 15px;
            font-weight: 500;
        }

        .custom-toast.show {
            opacity: 1;
            transform: translateX(0);
        }

        .custom-toast i {
            font-size: 20px;
        }

        /* ===== SEARCH RESULTS DROPDOWN ===== */
        .search-results-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            border: 1px solid #eef2f6;
            max-height: 400px;
            overflow-y: auto;
            z-index: 99999;
            display: none;
            margin-top: 5px;
            padding: 8px 0;
        }

        .search-results-dropdown.show {
            display: block;
        }

        .search-result-item {
            display: flex;
            align-items: center;
            padding: 10px 16px;
            text-decoration: none;
            color: #1a1a2e;
            transition: all 0.2s;
            border-bottom: 1px solid #f0f0f0;
            gap: 12px;
        }

        .search-result-item:last-child {
            border-bottom: none;
        }

        .search-result-item:hover {
            background: #f8f9fa;
        }

        .search-result-item .result-image {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            object-fit: cover;
            background: #f0f0f0;
            flex-shrink: 0;
        }

        .search-result-item .result-info {
            flex: 1;
            min-width: 0;
        }

        .search-result-item .result-name {
            font-size: 0.85rem;
            font-weight: 500;
            color: #1a1a2e;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .search-result-item .result-price {
            font-size: 0.8rem;
            color: #dc3545;
            font-weight: 600;
        }

        .search-result-item .result-category {
            font-size: 0.7rem;
            color: #999;
        }

        .no-results {
            padding: 15px;
            text-align: center;
            color: #999;
            font-size: 0.85rem;
        }

        .search-loading {
            padding: 15px;
            text-align: center;
            color: #999;
            font-size: 0.85rem;
        }

        .search-loading i {
            margin-right: 8px;
            color: #dc3545;
        }

        .view-all-results {
            padding: 8px 16px;
            text-align: center;
            border-top: 1px solid #eef2f6;
        }

        .view-all-results a {
            color: #dc3545;
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .view-all-results a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body class="@if (Route::is('admin.login') || Route::is('admin.register')) hide-sidebar @endif">

    @php
        if (!function_exists('getDashboardUrl')) {
            function getDashboardUrl()
            {
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

        if (!function_exists('getSubCategoriesForMenu')) {
            function getSubCategoriesForMenu($categoryId)
            {
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

        $navCategories = \App\Models\Category::where('is_active', 1)
            ->orderBy('id', 'asc')
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'subcategories' => getSubCategoriesForMenu($category->id),
                ];
            });
    @endphp

    <!-- ============================================================ -->
    <!-- ===== FIXED NAVBAR ===== -->
    <!-- ============================================================ -->
    <nav class="navbar">
        <div class="navbar-container">

            <!-- ===== TOP ROW ===== -->
            <div class="navbar-top">
                <!-- Brand -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    @php
                        $companyLogo = \App\Models\Setting::get('company_logo', 'fas fa-dumbbell');
                        $companyName = \App\Models\Setting::get('company_name', 'Gym Management');
                    @endphp
                    <i class="{{ $companyLogo }}"></i>
                    <strong>{{ $companyName }}</strong>
                </a>

                <!-- ===== NAV ICONS ===== -->
                <div class="nav-icons">
                    <!-- Search -->
                    <div class="search-wrapper">
                        <form onsubmit="event.preventDefault(); searchProducts();" id="searchForm">
                            <input type="text" id="navbarSearch" placeholder="Search..." autocomplete="off">
                            <button type="submit"><i class="fas fa-search"></i></button>
                        </form>
                        <div id="searchResults" class="search-results-dropdown"></div>
                    </div>

                    <!-- Cart -->
                    <a class="nav-icon position-relative" href="{{ url('/cart') }}">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count" id="navbarCartCount"></span>
                    </a>

                    <!-- Wishlist -->
                    <a class="nav-icon position-relative" href="{{ route('wishlist') }}">
                        <i class="fas fa-heart"></i>
                        <span class="cart-count" id="navbarWishlistCount"></span>
                    </a>

                    <!-- User -->
                    @auth('admin')
                        <div class="dropdown">
                            <a class="user-dropdown dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown">
                                <div class="profile-icon"><i class="fas fa-user-shield"></i></div>
                                <span class="d-none d-sm-inline">Admin</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i
                                            class="fas fa-tachometer-alt me-2"></i> Admin Panel</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item text-danger" href="#"
                                        onclick="event.preventDefault(); document.getElementById('admin-logout-from-navbar').submit();"><i
                                            class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                            </ul>
                        </div>
                    @elseif(auth()->check())
                        <div class="dropdown">
                            <a class="user-dropdown dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown">
                                <div class="profile-icon"><i class="fas fa-user"></i></div>
                                <span class="d-none d-sm-inline">{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#" onclick="openProfileModal(); return false;"><i
                                            class="fas fa-id-card me-2"></i> My Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('my.orders') }}"><i
                                            class="fas fa-shopping-bag me-2"></i> My Orders</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item text-danger" href="#"
                                        onclick="event.preventDefault(); localStorage.removeItem('cart'); localStorage.removeItem('wishlist'); document.getElementById('logout-form').submit();"><i
                                            class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                            </ul>
                        </div>
                    @endif

                    <!-- HAMBURGER BUTTON (visible on mobile) -->
                    <button class="hamburger-btn" id="hamburgerBtn" aria-label="Toggle menu">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>

            <!-- ===== BOTTOM ROW - NAVIGATION MENU ===== -->
            <div class="navbar-bottom" id="navbarBottom">
                <ul class="navbar-nav">
                    @foreach ($navCategories as $category)
                        <li class="nav-item nav-item-category" data-category-id="{{ $category['id'] }}">
                            <a class="nav-link"
                                href="/shop?category={{ $category['id'] }}&name={{ urlencode($category['name']) }}">
                                {{ $category['name'] }}
                                @if ($category['subcategories']->count() > 0)
                                    <span class="arrow-icon"><i class="fas fa-chevron-down"></i></span>
                                @endif
                            </a>
                            @if ($category['subcategories']->count() > 0)
                                <div class="sub-category-dropdown">
                                    <a class="all-link"
                                        href="/shop?category={{ $category['id'] }}&name={{ urlencode($category['name']) }}">All</a>
                                    @foreach ($category['subcategories'] as $sub)
                                        <a class="sub-cat-item"
                                            href="/shop?subcategory={{ $sub->id }}&name={{ urlencode($sub->name) }}">
                                            {{ $sub->name }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </li>
                    @endforeach

                    <li class="nav-item"><a class="nav-link" href="{{ route('my.orders') }}">My Orders</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About Us</a></li>

                    @auth('admin')
                        <li class="nav-item nav-join-gym">
                            <a class="btn-dashboard-nav" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-1"></i> Admin Panel
                            </a>
                        </li>
                    @else
                        <li class="nav-item nav-join-gym">
                            <a class="btn-join-gym" href="{{ route('member.trainer.login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i> Join Gym
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>

        </div>
    </nav>

    <!-- ===== NAVBAR SPACER ===== -->
    <div class="navbar-spacer"></div>

    <!-- Hidden logout forms -->
    @auth('admin')
        <form id="admin-logout-from-navbar" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    @elseif(auth()->check())
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    @endauth

    <!-- Admin navbar include -->
    @auth('admin')
        @if (!Route::is('home') && !Route::is('login') && !Route::is('admin.login') && !Route::is('admin.register'))
            @include('layouts.admin-navbar')
        @endif
    @endauth

    <!-- ===== MAIN CONTENT ===== -->
    <main style="margin: 0; padding: 0; overflow-x: hidden !important; width: 100%;">
        @if (session('success'))
            <div class="container" style="padding-left: 15px; padding-right: 15px;">
                <div class="alert alert-success alert-dismissible fade show alert-auto-hide" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif
        @if (session('error'))
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
        <div class="modal fade profile-modal" id="profileModal" tabindex="-1" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-end"
                style="max-width: 380px; margin: 0 0 0 auto; height: 100vh; display: flex; align-items: stretch;">
                <div class="modal-content"
                    style="border-radius: 0; min-height: 100vh; max-height: 100vh; overflow-y: auto; border: none; box-shadow: -5px 0 30px rgba(0,0,0,0.1);">
                    <div class="modal-header"
                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-bottom: none; padding: 20px; position: sticky; top: 0; z-index: 10;">
                        <div class="text-center w-100">
                            <div class="profile-avatar-lg"><i class="fas fa-user"></i></div>
                            <h5 class="mb-0" id="modalProfileName">{{ Auth::user()->name }}</h5>
                        </div>
                        <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3"
                            data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" style="padding: 20px;">
                        <div class="profile-info-item">
                            <div class="profile-info-label">Full Name</div>
                            <div class="profile-info-value">
                                <span class="display-text" id="modalNameDisplay">{{ Auth::user()->name }}</span>
                                <input type="text" class="edit-input" id="modalNameInput"
                                    value="{{ Auth::user()->name }}">
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
                    <div class="modal-footer"
                        style="padding: 15px 20px 20px; border-top: none; position: sticky; bottom: 0; background: white;">
                        <button class="btn-edit-profile-modal" id="modalEditProfileBtn"
                            onclick="enableModalProfileEdit()" style="width: 100%;">
                            <i class="fas fa-edit"></i> Edit Profile
                        </button>
                        <button class="btn-save-profile-modal" id="modalSaveProfileBtn" onclick="saveModalProfile()"
                            style="width: 100%; display: none;">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                        <button class="btn-cancel-profile-modal" id="modalCancelProfileBtn"
                            onclick="cancelModalProfileEdit()" style="width: 100%; display: none;">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endauth

    <!-- ===== FOOTER ===== -->
    <footer class="footer mt-auto">
        <div class="container">
            <div class="row">
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
                        <a href="https://wa.me/919025595190?text=Hi%20Gym%20Management%2C%20I%20need%20assistance."
                            target="_blank" rel="noopener noreferrer"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                    <h5>Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="{{ url('/') }}"><i class="fas fa-chevron-right"></i> Home</a></li>
                        <li><a href="{{ route('about') }}"><i class="fas fa-chevron-right"></i> About Us</a></li>
                        <li><a
                                href="@if (auth()->check()) {{ route('contact') }} @else {{ route('login') }} @endif"><i
                                    class="fas fa-chevron-right"></i> Contact</a></li>
                        <li><a
                                href="@if (auth()->check()) {{ route('my.orders') }} @else {{ route('login') }} @endif"><i
                                    class="fas fa-chevron-right"></i> My Orders</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                    <h5>Customer Service</h5>
                    <ul class="footer-links">
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Returns & Exchange</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> FAQ</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Privacy Policy</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Terms & Conditions</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-6">
                    <h5>Get In Touch</h5>
                    <ul class="footer-contact">
                        <li><i class="fas fa-map-marker-alt"></i><span>123 Fitness Street, Chennai - 600001</span></li>
                        <li><i class="fas fa-phone-alt"></i><span>+91 98765 43210</span></li>
                        <li><i class="fas fa-envelope"></i><span>info@gymmanagement.com</span></li>
                        <li><i class="fab fa-whatsapp"></i><span><a
                                    href="https://wa.me/919025595190?text=Hi%20Gym%20Management%2C%20I%20need%20assistance."
                                    target="_blank" rel="noopener noreferrer"
                                    style="color: #a0a0c0; text-decoration: none; font-weight: 500;">+91 90255
                                    95190</a></span></li>
                    </ul>
                </div>
            </div>

            <div class="row bottom-bar">
                <div class="col-12 text-center">
                    <p class="mb-0">&copy; {{ date('Y') }} Gym Management. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/919025595190?text=Hi%20Gym%20Management%2C%20I%20need%20assistance." target="_blank"
        rel="noopener noreferrer" class="whatsapp-float" aria-label="Chat on WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- WhatsApp Tooltip -->
    <div class="whatsapp-tooltip" id="whatsappTooltip">
        <i class="fas fa-comment-dots me-2"></i> Chat with us on WhatsApp
    </div>

    <!-- Custom Toast -->
    <div id="customToast" class="custom-toast">
        <i class="fas fa-check-circle"></i>
        <span id="toastMessage"></span>
    </div>

    <script>
        // ================================================================
        // ===== HAMBURGER MENU TOGGLE =====
        // ================================================================
        document.addEventListener('DOMContentLoaded', function() {
            const hamburgerBtn = document.getElementById('hamburgerBtn');
            const navbarBottom = document.getElementById('navbarBottom');

            if (hamburgerBtn && navbarBottom) {
                hamburgerBtn.addEventListener('click', function() {
                    navbarBottom.classList.toggle('open');
                    const icon = this.querySelector('i');
                    if (icon) {
                        icon.classList.toggle('fa-bars');
                        icon.classList.toggle('fa-times');
                    }
                });
            }

            // ================================================================
            // ===== MOBILE CATEGORY CLICK TO SHOW DROPDOWN =====
            // ================================================================
            function setupMobileCategoryToggle() {
                if (window.innerWidth <= 992) {
                    document.querySelectorAll('.nav-item-category .nav-link').forEach(function(link) {
                        link.removeEventListener('click', handleCategoryClick);
                        link.addEventListener('click', handleCategoryClick);
                    });
                } else {
                    document.querySelectorAll('.nav-item-category.active').forEach(function(item) {
                        item.classList.remove('active');
                    });
                }
            }

            function handleCategoryClick(e) {
                const parent = this.closest('.nav-item-category');
                if (parent) {
                    const hasSubMenu = parent.querySelector('.sub-category-dropdown');
                    if (hasSubMenu) {
                        e.preventDefault();
                        document.querySelectorAll('.nav-item-category.active').forEach(function(item) {
                            if (item !== parent) {
                                item.classList.remove('active');
                            }
                        });
                        parent.classList.toggle('active');
                    }
                }
            }

            setupMobileCategoryToggle();

            // ================================================================
            // ===== UPDATE CART & WISHLIST =====
            // ================================================================
            updateNavbarCartCount();
            updateNavbarWishlistCount();

            // ================================================================
            // ===== WHATSAPP TOOLTIP =====
            // ================================================================
            setTimeout(function() {
                const tooltip = document.getElementById('whatsappTooltip');
                if (tooltip) {
                    tooltip.classList.add('show');
                    setTimeout(function() {
                        tooltip.classList.remove('show');
                    }, 5000);
                }
            }, 3000);

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

            // ================================================================
            // ===== AUTO-HIDE ALERTS =====
            // ================================================================
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

            // ================================================================
            // ===== SEARCH FUNCTIONALITY =====
            // ================================================================
            const searchInput = document.getElementById('navbarSearch');
            const searchResults = document.getElementById('searchResults');
            let searchTimeout = null;

            if (searchInput && searchResults) {
                searchInput.addEventListener('input', function() {
                    const query = this.value.trim();

                    if (searchTimeout) {
                        clearTimeout(searchTimeout);
                    }

                    if (query.length < 2) {
                        searchResults.classList.remove('show');
                        searchResults.innerHTML = '';
                        return;
                    }

                    searchResults.innerHTML =
                        '<div class="search-loading"><i class="fas fa-spinner fa-spin"></i> Searching...</div>';
                    searchResults.classList.add('show');

                    searchTimeout = setTimeout(function() {
                        fetchLiveSearch(query);
                    }, 300);
                });

                document.addEventListener('click', function(e) {
                    if (!e.target.closest('.search-wrapper')) {
                        searchResults.classList.remove('show');
                    }
                });

                searchInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const query = this.value.trim();
                        if (query) {
                            window.location.href = "{{ url('/') }}?search=" + encodeURIComponent(query);
                        }
                    }
                });
            }
        });

        // ================================================================
        // ===== FETCH LIVE SEARCH =====
        // ================================================================
        async function fetchLiveSearch(query) {
            const searchResults = document.getElementById('searchResults');

            try {
                const response = await fetch(`/search-products?q=${encodeURIComponent(query)}`);
                const products = await response.json();

                if (products.length === 0) {
                    searchResults.innerHTML = '<div class="no-results"><i class="fas fa-search"></i> No products found</div>';
                    return;
                }

                let html = '';
                products.forEach(function(product) {
                    const imageUrl = product.image_url || '{{ asset("images/no-image.png") }}';
                    const price = product.price || product.mrp || '0';

                    // ===== DESKTOP: Show full details (name, price, category) =====
                    // ===== MOBILE: Only show name (price & category hidden via CSS) =====
                    html += `
                        <a href="/product/${product.id}" class="search-result-item">
                            <img src="${imageUrl}" alt="${product.name}" class="result-image" onerror="this.src='{{ asset("images/no-image.png") }}'">
                            <div class="result-info">
                                <div class="result-name">${product.name}</div>
                                <div class="result-price">₹${Number(price).toFixed(2)}</div>
                                <div class="result-category">${product.category_name || ''} ${product.sub_category_name ? '› ' + product.sub_category_name : ''}</div>
                            </div>
                        </a>
                    `;
                });

                html += `
                    <div class="view-all-results">
                        <a href="{{ url('/') }}?search=${encodeURIComponent(query)}">
                            <i class="fas fa-arrow-right"></i> View all results
                        </a>
                    </div>
                `;

                searchResults.innerHTML = html;
                searchResults.classList.add('show');

            } catch (error) {
                console.error('Search error:', error);
                searchResults.innerHTML =
                    '<div class="no-results"><i class="fas fa-exclamation-circle"></i> Error loading results</div>';
            }
        }

        // ================================================================
        // ===== HANDLE URL SEARCH PARAMETER =====
        // ================================================================
        function handleUrlSearch() {
            const urlParams = new URLSearchParams(window.location.search);
            const searchQuery = urlParams.get('search');
            const searchInput = document.getElementById('navbarSearch');
            if (searchQuery && searchInput) {
                searchInput.value = searchQuery;
            }
        }

        if (document.readyState === 'complete') {
            handleUrlSearch();
        } else {
            document.addEventListener('DOMContentLoaded', handleUrlSearch);
        }

        // ================================================================
        // ===== PROFILE MODAL FUNCTIONS =====
        // ================================================================
        function openProfileModal() {
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
                    body: JSON.stringify({
                        name: name
                    })
                });

                const data = await response.json();

                if (data.success) {
                    document.getElementById('modalProfileName').textContent = name;
                    document.getElementById('modalNameDisplay').textContent = name;
                    const navbarName = document.querySelector('.user-dropdown span');
                    if (navbarName) {
                        navbarName.textContent = name;
                    }
                    showToast("Profile updated successfully!");
                    cancelModalProfileEdit();
                } else {
                    showToast(data.message || "Error updating profile");
                }
            } catch (error) {
                console.error('Error:', error);
                showToast("Network error. Please try again.");
            } finally {
                saveBtn.innerHTML = originalText;
                saveBtn.disabled = false;
            }
        }

        // ================================================================
        // ===== CART & WISHLIST FUNCTIONS =====
        // ================================================================
        function updateNavbarCartCount() {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            let count = cart.reduce((total, item) => total + item.quantity, 0);
            let cartCountElement = document.getElementById('navbarCartCount');
            if (cartCountElement) {
                if (count > 0) {
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
            if (wishlistCountElement) {
                if (count > 0) {
                    wishlistCountElement.textContent = count;
                    wishlistCountElement.classList.remove('hide-badge');
                } else {
                    wishlistCountElement.textContent = '';
                    wishlistCountElement.classList.add('hide-badge');
                }
            }
        }

        function searchProducts() {
            let searchTerm = document.getElementById('navbarSearch').value.trim();
            if (searchTerm) {
                window.location.href = "{{ url('/') }}?search=" + encodeURIComponent(searchTerm);
            }
        }

        function refreshCaptcha() {
            const img = document.getElementById('captcha-img');
            if (img) {
                img.src = '{{ url('/captcha') }}?' + Math.random();
            }
        }

        function showToast(message) {
            const toast = document.getElementById("customToast");
            const msg = document.getElementById("toastMessage");
            msg.innerText = message;
            toast.classList.add("show");
            setTimeout(function() {
                toast.classList.remove("show");
            }, 3000);
        }

        // ================================================================
        // ===== HANDLE WINDOW RESIZE =====
        // ================================================================
        window.addEventListener('resize', function() {
            if (window.innerWidth > 992) {
                document.querySelectorAll('.nav-item-category.active').forEach(function(el) {
                    el.classList.remove('active');
                });
                const navbarBottom = document.getElementById('navbarBottom');
                if (navbarBottom) {
                    navbarBottom.classList.remove('open');
                }
                const hamburgerIcon = document.querySelector('#hamburgerBtn i');
                if (hamburgerIcon) {
                    hamburgerIcon.classList.add('fa-bars');
                    hamburgerIcon.classList.remove('fa-times');
                }
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>