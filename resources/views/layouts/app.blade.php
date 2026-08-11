<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ App\Models\Setting::get('company_name', 'FitForge Athletic System') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- ================================================================
         DESIGN TOKENS — FitForge Athletic System
         Display: Anton (poster-weight, athletic)
         Body:    Plus Jakarta Sans (clean, modern e-commerce)
    ================================================================ -->
    <link
        href="https://fonts.googleapis.com/css2?family=Anton&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        /* ================================================================
           DESIGN TOKENS — FitForge Athletic System
        ================================================================ */
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
            --shadow-card: 0 1px 2px rgba(20, 22, 26, 0.04), 0 8px 24px rgba(20, 22, 26, 0.06);
            --shadow-card-hover: 0 18px 40px rgba(20, 22, 26, 0.14);
        }

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
            font-family: var(--font-body);
            color: var(--ink);
            background: var(--canvas);
            margin: 0;
            padding: 0;
        }

        /* Signature element: a repeating diagonal "energy stripe" */
        .energy-stripe {
            height: 4px;
            width: 56px;
            border-radius: 3px;
            background: repeating-linear-gradient(-45deg,
                    var(--signal) 0px,
                    var(--signal) 6px,
                    var(--ink) 6px,
                    var(--ink) 12px);
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
            border-bottom: 1px solid var(--line);
            flex-wrap: wrap;
            gap: 10px;
        }

        .navbar-brand {
            color: var(--ink) !important;
            font-family: var(--font-display);
            font-weight: 400;
            font-size: 1.3rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            flex-shrink: 0;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .navbar-brand i {
            color: var(--signal);
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
            border: 1px solid var(--line);
            padding: 7px 40px 7px 18px;
            font-size: 0.85rem;
            width: 220px;
            transition: all 0.3s;
            background: var(--fog);
            height: 38px;
            font-family: var(--font-body);
        }

        .search-wrapper input:focus {
            outline: none;
            border-color: var(--signal);
            width: 260px;
            background: white;
            box-shadow: 0 0 0 2px rgba(255, 68, 5, 0.1);
        }

        .search-wrapper button {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--steel);
            cursor: pointer;
            font-size: 1rem;
        }

        .search-wrapper button:hover {
            color: var(--signal);
        }

        /* Nav Icons */
        .nav-icon {
            position: relative;
            font-size: 1.2rem;
            color: var(--ink);
            transition: all 0.3s;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .nav-icon:hover {
            color: var(--signal);
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -10px;
            background: var(--signal);
            color: white;
            border-radius: 50%;
            padding: 1px 6px;
            font-size: 10px;
            font-weight: 700;
            min-width: 18px;
            text-align: center;
            font-family: var(--font-body);
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
            color: var(--ink);
            padding: 5px 10px;
            border-radius: 30px;
            transition: all 0.3s;
            font-size: 0.85rem;
            font-family: var(--font-body);
            font-weight: 500;
        }

        .user-dropdown:hover {
            background: var(--fog);
            color: var(--signal);
        }

        .profile-icon {
            width: 32px;
            height: 32px;
            background: var(--signal);
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
            background: var(--signal);
            color: white;
            border-radius: 25px;
            padding: 7px 20px;
            transition: all 0.3s;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            font-size: 0.85rem;
            border: none;
            cursor: pointer;
            white-space: nowrap;
            font-family: var(--font-body);
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .btn-join-gym:hover {
            background: var(--signal-dark);
            transform: scale(1.02);
            color: white;
        }

        .btn-dashboard-nav {
            background: var(--ink);
            color: white;
            border-radius: 25px;
            padding: 7px 20px;
            transition: all 0.3s;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            font-size: 0.85rem;
            white-space: nowrap;
            font-family: var(--font-body);
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .btn-dashboard-nav:hover {
            background: var(--ink-soft);
            transform: scale(1.02);
            color: white;
        }

        /* ===== HAMBURGER BUTTON - Desktop Hidden, Mobile Visible ===== */
        .hamburger-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.6rem;
            color: var(--ink);
            cursor: pointer;
            padding: 5px 8px;
            transition: all 0.3s;
            margin-left: 5px;
        }

        .hamburger-btn:hover {
            color: var(--signal);
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
            color: var(--ink) !important;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 6px 12px;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
            white-space: nowrap;
            font-family: var(--font-body);
            letter-spacing: 0.2px;
        }

        .navbar-nav .nav-link:hover {
            color: var(--signal) !important;
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
            border-radius: var(--radius-md);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
            padding: 8px 0;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 99999;
            border: 1px solid var(--line);
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
            color: var(--ink);
            text-decoration: none;
            font-size: 0.78rem;
            font-weight: 700;
            transition: all 0.3s;
            border-bottom: 1px solid var(--line);
            margin: 0 0 4px 0;
            text-align: left;
            font-family: var(--font-body);
        }

        .sub-category-dropdown .all-link:hover {
            color: var(--signal);
            background: var(--fog);
        }

        .sub-category-dropdown .sub-cat-item {
            display: block;
            padding: 4px 16px;
            color: var(--steel);
            text-decoration: none;
            font-size: 0.76rem;
            transition: all 0.3s;
            font-weight: 500;
            text-align: left;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-family: var(--font-body);
        }

        .sub-category-dropdown .sub-cat-item:hover {
            color: var(--signal);
            background: var(--fog);
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
            border-radius: var(--radius-sm);
            padding: 8px 0;
            margin-top: 8px;
        }

        .dropdown-item {
            padding: 8px 20px;
            font-size: 0.85rem;
            color: var(--ink);
            transition: all 0.2s;
            font-family: var(--font-body);
            font-weight: 500;
        }

        .dropdown-item:hover {
            background: var(--signal);
            color: white;
        }

        .dropdown-item.text-danger:hover,
        .dropdown-item.text-danger:hover i {
            color: #fff !important;
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
                border-top: 1px solid var(--line);
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
                color: var(--steel);
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
                border-top: 1px solid var(--line);
                border-radius: 0;
                opacity: 1;
                visibility: visible;
                pointer-events: auto;
                display: none;
                background: var(--fog);
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
                border: 1px solid var(--line);
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
                border-radius: var(--radius-sm);
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
                color: var(--ink);
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
            border-radius: var(--radius-sm);
            border: 1px solid var(--line);
            height: 45px;
            width: auto;
        }

        .card {
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
        }

        .btn-primary {
            background: var(--signal);
            border: none;
        }

        .btn-primary:hover {
            background: var(--signal-dark);
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
            border-radius: var(--radius-lg) !important;
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
            background: var(--ink) !important;
            color: white !important;
            border-bottom: none !important;
            padding: 20px !important;
            position: sticky !important;
            top: 0 !important;
            z-index: 10 !important;
            border-radius: var(--radius-lg) var(--radius-lg) 0 0 !important;
        }

        .profile-modal .modal-header .modal-title {
            font-family: var(--font-display);
            font-weight: 400;
            letter-spacing: 0.3px;
            text-transform: uppercase;
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
            border-radius: 0 0 var(--radius-lg) var(--radius-lg) !important;
        }

        /* ===== PROFILE AVATAR UPLOAD ===== */
        .profile-avatar-wrapper {
            position: relative;
            display: inline-block;
        }

        .profile-avatar-wrapper .btn-upload-profile {
            transition: all 0.3s;
        }

        .profile-avatar-wrapper .btn-upload-profile:hover {
            transform: scale(1.1);
            background: var(--signal-dark);
        }

        .profile-avatar-lg {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: white;
            overflow: hidden;
            cursor: pointer;
            background: var(--signal);
            margin: 0 auto 10px;
            border: 3px solid rgba(255, 255, 255, 0.3);
        }

        .profile-avatar-lg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-avatar-lg i {
            font-size: 32px;
        }

        .btn-upload-profile {
            position: absolute;
            bottom: 5px;
            right: 5px;
            background: var(--signal);
            border: 2px solid white;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.3s;
            z-index: 5;
        }

        .btn-upload-profile:hover {
            background: var(--signal-dark);
            transform: scale(1.1);
        }

        .profile-info-item {
            display: flex;
            padding: 8px 0;
            border-bottom: 1px solid var(--line);
        }

        .profile-info-item:last-child {
            border-bottom: none;
        }

        .profile-info-label {
            width: 85px;
            font-weight: 700;
            color: var(--steel);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .profile-info-value {
            flex: 1;
            color: var(--ink);
            font-size: 13px;
            font-weight: 500;
        }

        .profile-info-value .edit-input {
            display: none;
            width: 100%;
            padding: 4px 10px;
            border: 1px solid var(--line);
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-family: var(--font-body);
        }

        .profile-info-value .edit-input:focus {
            outline: none;
            border-color: var(--signal);
            box-shadow: 0 0 0 3px rgba(255, 68, 5, 0.1);
        }

        .profile-info-value .edit-input.show {
            display: block;
        }

        .profile-info-value .display-text.hide {
            display: none;
        }

        .btn-edit-profile-modal {
            background: var(--signal);
            color: white;
            border: none;
            padding: 8px 25px;
            border-radius: 25px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
            font-family: var(--font-body);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .btn-edit-profile-modal:hover {
            background: var(--signal-dark);
            transform: translateY(-2px);
        }

        .btn-save-profile-modal {
            background: var(--success);
            color: white;
            border: none;
            padding: 8px 25px;
            border-radius: 25px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            display: none;
            width: 100%;
            font-family: var(--font-body);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .btn-save-profile-modal:hover {
            background: #128A3E;
            transform: translateY(-2px);
        }

        .btn-cancel-profile-modal {
            background: var(--fog);
            color: var(--steel);
            border: none;
            padding: 8px 25px;
            border-radius: 25px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            display: none;
            width: 100%;
            font-family: var(--font-body);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .btn-cancel-profile-modal:hover {
            background: var(--line);
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
            background: var(--ink);
            color: var(--steel);
            padding-top: 50px;
            margin-top: 60px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .footer-logo {
            font-family: var(--font-display);
            font-weight: 400;
            font-size: 1.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: white;
        }

        .footer-logo i {
            color: var(--signal);
        }

        .footer-about {
            line-height: 1.8;
            font-size: 0.9rem;
            max-width: 350px;
            font-weight: 400;
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
            color: var(--steel);
            transition: all 0.3s;
            text-decoration: none;
        }

        .social-icons a:hover {
            background: var(--signal);
            color: white;
            transform: translateY(-3px);
        }

        .footer h5 {
            font-family: var(--font-display);
            font-weight: 400;
            color: white;
            font-size: 1.1rem;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .footer h5::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 40px;
            height: 2px;
            background: var(--signal);
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
            color: var(--steel);
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            font-weight: 400;
        }

        .footer-links li a i {
            width: 16px;
            margin-right: 10px;
            font-size: 10px;
            color: var(--signal);
        }

        .footer-links li a:hover {
            color: var(--signal);
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
            color: var(--signal);
            font-size: 1rem;
            margin-top: 3px;
            min-width: 20px;
        }

        .footer-contact li span {
            font-size: 0.9rem;
            line-height: 1.6;
            font-weight: 400;
        }

        .footer-contact li a {
            color: var(--steel);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
        }

        .footer-contact li a:hover {
            color: var(--signal);
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
            border-radius: var(--radius-sm);
            font-size: 0.85rem;
            z-index: 999;
            opacity: 0;
            transition: all 0.3s ease;
            pointer-events: none;
            font-family: var(--font-body);
            font-weight: 500;
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

        /* ===== CUSTOM TOAST ===== */
        .custom-toast {
            position: fixed;
            top: 25px;
            right: 25px;
            background: var(--success);
            color: #fff;
            padding: 15px 22px;
            border-radius: var(--radius-md);
            box-shadow: 0 10px 25px rgba(0, 0, 0, .2);
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 999999;
            opacity: 0;
            transform: translateX(100%);
            transition: .4s;
            font-size: 15px;
            font-weight: 600;
            font-family: var(--font-body);
        }

        .custom-toast.show {
            opacity: 1;
            transform: translateX(0);
        }

        .custom-toast i {
            font-size: 20px;
        }

        .custom-toast.error {
            background: var(--signal);
        }

        .custom-toast.info {
            background: var(--info);
        }

        /* ===== SEARCH RESULTS DROPDOWN ===== */
        .search-results-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #ffffff;
            border-radius: var(--radius-md);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            border: 1px solid var(--line);
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
            color: var(--ink);
            transition: all 0.2s;
            border-bottom: 1px solid var(--line);
            gap: 12px;
        }

        .search-result-item:last-child {
            border-bottom: none;
        }

        .search-result-item:hover {
            background: var(--fog);
        }

        .search-result-item .result-image {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-sm);
            object-fit: cover;
            background: var(--fog);
            flex-shrink: 0;
        }

        .search-result-item .result-info {
            flex: 1;
            min-width: 0;
        }

        .search-result-item .result-name {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--ink);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-family: var(--font-body);
        }

        .search-result-item .result-price {
            font-size: 0.8rem;
            color: var(--signal);
            font-weight: 700;
        }

        .search-result-item .result-category {
            font-size: 0.7rem;
            color: var(--steel);
            font-weight: 500;
        }

        .no-results {
            padding: 15px;
            text-align: center;
            color: var(--steel);
            font-size: 0.85rem;
            font-weight: 500;
        }

        .search-loading {
            padding: 15px;
            text-align: center;
            color: var(--steel);
            font-size: 0.85rem;
            font-weight: 500;
        }

        .search-loading i {
            margin-right: 8px;
            color: var(--signal);
        }

        .view-all-results {
            padding: 8px 16px;
            text-align: center;
            border-top: 1px solid var(--line);
        }

        .view-all-results a {
            color: var(--signal);
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 700;
            font-family: var(--font-body);
        }

        .view-all-results a:hover {
            text-decoration: underline;
        }

        /* ===== ADDRESS CARD STYLES ===== */
        .address-card {
            transition: all 0.3s ease;
        }

        .address-card:hover {
            transform: translateX(3px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .btn-address-edit-small {
            transition: all 0.3s ease;
        }

        .btn-address-edit-small:hover {
            background: var(--info) !important;
            color: white !important;
        }

        .btn-address-delete-small {
            transition: all 0.3s ease;
        }

        .btn-address-delete-small:hover {
            background: var(--signal) !important;
            color: white !important;
        }

        .btn-add-address-small {
            transition: all 0.3s ease;
        }

        .btn-add-address-small:hover {
            background: var(--signal-dark) !important;
            transform: translateY(-2px);
        }

        #addAddressFormModal input:focus,
        #editAddressFormModal input:focus {
            outline: none;
            border-color: var(--signal);
            box-shadow: 0 0 0 3px rgba(255, 68, 5, 0.1);
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
                        $companyName = \App\Models\Setting::get('company_name', 'FitForge Athletics');
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
                                <div class="profile-icon">
                                    @if (Auth::user()->profile_image)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="Profile"
                                            style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                                    @else
                                        <i class="fas fa-user"></i>
                                    @endif
                                </div>
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
        {{--  <main style="margin: 0; padding: 0; overflow-x: hidden !important; width: 100%;">
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
    </main>  --}}

        <!-- ===== MAIN CONTENT ===== -->
        <main style="margin: 0; padding: 0; overflow-x: hidden !important; width: 100%;">
            @yield('content')
        </main>

        <!-- ===== PROFILE MODAL ===== -->
        @auth
            @php
                // Get ALL addresses for this user
                $userAddresses = \App\Models\UserAddress::where('user_id', Auth::id())
                    ->orderBy('is_default', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->get();

                // Get default address (first one)
                $userAddress = $userAddresses->where('is_default', 1)->first();
                if (!$userAddress) {
                    $userAddress = $userAddresses->first();
                }

                $profileImage = Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : null;
            @endphp
            <!-- PROFILE MODAL CONTENT GOES HERE -->
            <div class="modal fade profile-modal" id="profileModal" tabindex="-1" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-end"
                    style="max-width: 480px; margin: 0 0 0 auto; height: 100vh; display: flex; align-items: stretch;">
                    <div class="modal-content"
                        style="border-radius: 0; min-height: 100vh; max-height: 100vh; overflow-y: auto; border: none; box-shadow: -5px 0 30px rgba(0,0,0,0.1);">
                        <div class="modal-header"
                            style="background: var(--ink); color: white; border-bottom: none; padding: 20px; position: sticky; top: 0; z-index: 10;">
                            <div class="text-center w-100">
                                <!-- Profile Avatar with Image Upload -->
                                <div class="profile-avatar-wrapper" style="position: relative; display: inline-block;">
                                    <div class="profile-avatar-lg" id="profileAvatarDisplay"
                                        style="background: var(--signal); width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-size: 32px; color: white; overflow: hidden; border: 3px solid rgba(255,255,255,0.3); cursor: pointer;">
                                        @if ($profileImage)
                                            <img src="{{ $profileImage }}" alt="Profile"
                                                style="width: 100%; height: 100%; object-fit: cover;" id="profileAvatarImg">
                                        @else
                                            <i class="fas fa-user" id="profileAvatarIcon"></i>
                                        @endif
                                    </div>
                                    <button type="button" class="btn-upload-profile"
                                        onclick="document.getElementById('profileImageInput').click()"
                                        style="position: absolute; bottom: 5px; right: 5px; background: var(--signal); border: 2px solid white; border-radius: 50%; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px; cursor: pointer; transition: all 0.3s; z-index: 5;">
                                        <i class="fas fa-camera"></i>
                                    </button>
                                    <input type="file" id="profileImageInput" accept="image/*" style="display: none;"
                                        onchange="uploadProfileImage(event)">
                                </div>
                                <h5 class="mb-0" id="modalProfileName"
                                    style="font-family: var(--font-display); text-transform: uppercase; letter-spacing: 0.3px; margin-top: 5px;">
                                    {{ Auth::user()->name }}</h5>
                            </div>
                            <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3"
                                data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body" style="padding: 20px;">
                            <!-- Personal Information -->
                            <div style="margin-bottom: 15px;">
                                <h6
                                    style="font-family: var(--font-display); font-weight: 400; text-transform: uppercase; letter-spacing: 0.3px; color: var(--signal); font-size: 0.85rem; border-bottom: 2px solid var(--line); padding-bottom: 8px;">
                                    <i class="fas fa-user-circle"></i> Personal Information
                                </h6>
                            </div>

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
                                    <span class="display-text" style="color: var(--steel);">{{ Auth::user()->email }}</span>

                                </div>
                            </div>
                            <div class="profile-info-item">
                                <div class="profile-info-label">Phone</div>
                                <div class="profile-info-value">
                                    <span class="display-text"
                                        style="color: var(--steel);">{{ Auth::user()->phone ?? 'Not provided' }}</span>

                                </div>
                            </div>

                            <!-- Address Section -->
                            <div style="margin-top: 20px; margin-bottom: 10px;">
                                <h6
                                    style="font-family: var(--font-display); font-weight: 400; text-transform: uppercase; letter-spacing: 0.3px; color: var(--signal); font-size: 0.85rem; border-bottom: 2px solid var(--line); padding-bottom: 8px;">
                                    <i class="fas fa-map-marker-alt"></i> Shipping Addresses
                                </h6>
                            </div>

                            <!-- ===== LIST ALL ADDRESSES ===== -->
                            @if ($userAddresses->count() > 0)
                                @foreach ($userAddresses as $index => $addr)
                                    <div class="address-card"
                                        style="background: {{ $addr->is_default ? 'var(--signal-tint)' : 'var(--fog)' }}; border: 1px solid {{ $addr->is_default ? 'var(--signal)' : 'var(--line)' }}; border-radius: var(--radius-sm); padding: 12px 15px; margin-bottom: 10px;">
                                        <div
                                            style="display: flex; justify-content: space-between; align-items: center; gap: 10px; width: 100%;">
                                            <div style="flex: 1; min-width: 0;">
                                                <span
                                                    style="font-weight: 700; font-size: 13px; color: var(--ink); display: flex; align-items: center; flex-wrap: wrap; gap: 5px;">
                                                    <span style="word-break: break-word;">{{ $addr->address }}</span>
                                                    @if ($addr->is_default)
                                                        <span
                                                            style="background: var(--signal); color: white; font-size: 9px; padding: 1px 10px; border-radius: 20px; margin-left: 8px; white-space: nowrap;">Default</span>
                                                    @endif
                                                </span>
                                                <div style="font-size: 12px; color: var(--steel); margin-top: 3px;">
                                                    {{ $addr->city }}, {{ $addr->state }} - {{ $addr->pincode }}
                                                </div>
                                                <div style="font-size: 12px; color: var(--steel);">
                                                    <i class="fas fa-phone"></i> {{ $addr->phone }}
                                                </div>
                                            </div>
                                            <div style="display: flex; gap: 5px; flex-shrink: 0; align-items: center;">
                                                <button class="btn-address-edit-small"
                                                    onclick="editAddress({{ $index }})"
                                                    style="background: var(--info-tint); color: var(--info); border: none; padding: 4px 14px; border-radius: 15px; font-size: 10px; cursor: pointer; font-weight: 600; white-space: nowrap; transition: all 0.3s;">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                                <button class="btn-address-delete-small"
                                                    onclick="deleteAddress({{ $addr->id }})"
                                                    style="background: var(--signal-tint); color: var(--signal-dark); border: none; padding: 4px 14px; border-radius: 15px; font-size: 10px; cursor: pointer; font-weight: 600; white-space: nowrap; transition: all 0.3s;">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div
                                    style="text-align: center; padding: 15px; color: var(--steel); font-size: 13px; background: var(--fog); border-radius: var(--radius-sm);">
                                    No addresses added yet.
                                </div>
                            @endif

                            <!-- Add New Address Button -->
                            <button class="btn-add-address-small" onclick="toggleAddAddressForm()"
                                style="background: var(--signal); color: white; border: none; padding: 8px 20px; border-radius: 20px; font-size: 12px; cursor: pointer; font-weight: 700; margin-top: 10px; width: 100%; transition: all 0.3s;">
                                <i class="fas fa-plus"></i> Add New Address
                            </button>

                            <!-- Add Address Form -->
                            <div id="addAddressFormModal"
                                style="display: none; margin-top: 12px; padding: 15px; background: var(--fog); border-radius: var(--radius-sm); border: 1px solid var(--line);">
                                <div style="margin-bottom: 8px;">
                                    <label
                                        style="font-size: 11px; font-weight: 700; color: var(--steel); text-transform: uppercase; display: block; margin-bottom: 3px;">Address
                                        *</label>
                                    <input type="text" id="newAddressInput" placeholder="Enter address"
                                        style="width: 100%; padding: 6px 10px; border: 1px solid var(--line); border-radius: var(--radius-sm); font-size: 13px;">
                                </div>
                                <div style="margin-bottom: 8px;">
                                    <label
                                        style="font-size: 11px; font-weight: 700; color: var(--steel); text-transform: uppercase; display: block; margin-bottom: 3px;">City
                                        *</label>
                                    <input type="text" id="newCityInput" placeholder="Enter city"
                                        style="width: 100%; padding: 6px 10px; border: 1px solid var(--line); border-radius: var(--radius-sm); font-size: 13px;">
                                </div>
                                <div style="margin-bottom: 8px;">
                                    <label
                                        style="font-size: 11px; font-weight: 700; color: var(--steel); text-transform: uppercase; display: block; margin-bottom: 3px;">State
                                        *</label>
                                    <select id="newStateInput"
                                        style="width: 100%; padding: 6px 10px; border: 1px solid var(--line); border-radius: var(--radius-sm); font-size: 13px; background: white;">
                                        <option value="">-- Select State --</option>
                                        @php
                                            $states = \App\Models\DeliverablePincode::where('is_active', 1)
                                                ->select('state')
                                                ->distinct()
                                                ->orderBy('state', 'asc')
                                                ->get();
                                        @endphp
                                        @foreach ($states as $state)
                                            <option value="{{ $state->state }}">{{ $state->state }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div style="margin-bottom: 8px;">
                                    <label
                                        style="font-size: 11px; font-weight: 700; color: var(--steel); text-transform: uppercase; display: block; margin-bottom: 3px;">Pincode
                                        *</label>
                                    <input type="text" id="newPincodeInput" placeholder="Enter pincode"
                                        style="width: 100%; padding: 6px 10px; border: 1px solid var(--line); border-radius: var(--radius-sm); font-size: 13px;">
                                </div>
                              {{--  <div style="margin-bottom: 8px;">
                                    <label
                                        style="font-size: 11px; font-weight: 700; color: var(--steel); text-transform: uppercase; display: block; margin-bottom: 3px;">Phone</label>
                                    <input type="text" id="newPhoneInput" placeholder="Enter phone"
                                        value="{{ Auth::user()->phone ?? '' }}"
                                        style="width: 100%; padding: 6px 10px; border: 1px solid var(--line); border-radius: var(--radius-sm); font-size: 13px;">
                                </div>--}}
                                <div style="display: flex; gap: 8px; margin-top: 10px;">
                                    <button onclick="saveNewAddress()"
                                        style="background: var(--signal); color: white; border: none; padding: 7px 20px; border-radius: 20px; font-size: 12px; cursor: pointer; font-weight: 700; flex: 1;">
                                        <i class="fas fa-save"></i> Save
                                    </button>
                                    <button onclick="toggleAddAddressForm()"
                                        style="background: var(--fog); color: var(--steel); border: 1px solid var(--line); padding: 7px 20px; border-radius: 20px; font-size: 12px; cursor: pointer; font-weight: 600;">
                                        Cancel
                                    </button>
                                </div>
                            </div>

                            <!-- Edit Address Form -->
                            <div id="editAddressFormModal"
                                style="display: none; margin-top: 12px; padding: 15px; background: var(--signal-tint); border-radius: var(--radius-sm); border: 1px solid var(--signal);">
                                <h6 style="font-size: 13px; font-weight: 700; color: var(--signal); margin-bottom: 10px;"><i
                                        class="fas fa-edit"></i> Edit Address</h6>
                                <div style="margin-bottom: 8px;">
                                    <label
                                        style="font-size: 11px; font-weight: 700; color: var(--steel); text-transform: uppercase; display: block; margin-bottom: 3px;">Address
                                        *</label>
                                    <input type="text" id="editAddressInput"
                                        style="width: 100%; padding: 6px 10px; border: 1px solid var(--line); border-radius: var(--radius-sm); font-size: 13px;">
                                </div>
                                <div style="margin-bottom: 8px;">
                                    <label
                                        style="font-size: 11px; font-weight: 700; color: var(--steel); text-transform: uppercase; display: block; margin-bottom: 3px;">City
                                        *</label>
                                    <input type="text" id="editCityInput"
                                        style="width: 100%; padding: 6px 10px; border: 1px solid var(--line); border-radius: var(--radius-sm); font-size: 13px;">
                                </div>
                                <div style="margin-bottom: 8px;">
                                    <label
                                        style="font-size: 11px; font-weight: 700; color: var(--steel); text-transform: uppercase; display: block; margin-bottom: 3px;">State
                                        *</label>
                                    <select id="editStateInput"
                                        style="width: 100%; padding: 6px 10px; border: 1px solid var(--line); border-radius: var(--radius-sm); font-size: 13px; background: white;">
                                        <option value="">-- Select State --</option>
                                        @php
                                            $states = \App\Models\DeliverablePincode::where('is_active', 1)
                                                ->select('state')
                                                ->distinct()
                                                ->orderBy('state', 'asc')
                                                ->get();
                                        @endphp
                                        @foreach ($states as $state)
                                            <option value="{{ $state->state }}">{{ $state->state }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div style="margin-bottom: 8px;">
                                    <label
                                        style="font-size: 11px; font-weight: 700; color: var(--steel); text-transform: uppercase; display: block; margin-bottom: 3px;">Pincode
                                        *</label>
                                    <input type="text" id="editPincodeInput"
                                        style="width: 100%; padding: 6px 10px; border: 1px solid var(--line); border-radius: var(--radius-sm); font-size: 13px;">
                                </div>
                                <div style="display: flex; gap: 8px; margin-top: 10px;">
                                    <button onclick="updateAddress()"
                                        style="background: var(--success); color: white; border: none; padding: 7px 20px; border-radius: 20px; font-size: 12px; cursor: pointer; font-weight: 700; flex: 1;">
                                        <i class="fas fa-save"></i> Update
                                    </button>
                                    <button onclick="closeEditAddressForm()"
                                        style="background: var(--fog); color: var(--steel); border: 1px solid var(--line); padding: 7px 20px; border-radius: 20px; font-size: 12px; cursor: pointer; font-weight: 600;">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer"
                            style="padding: 15px 20px 20px; border-top: none; position: sticky; bottom: 0; background: white; gap: 8px;">
                            <button class="btn-edit-profile-modal" id="modalEditProfileBtn"
                                onclick="enableModalProfileEdit()" style="width: 100%;">
                                <i class="fas fa-edit"></i> Edit Name
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
                            @php
                                $companyLogo = \App\Models\Setting::get('company_logo', 'fas fa-dumbbell');
                                $companyName = \App\Models\Setting::get('company_name', 'FitForge Athletics');
                            @endphp
                            <i class="{{ $companyLogo }} me-2"></i>
                            <strong>{{ $companyName }}</strong>
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
                            <a href="https://wa.me/919025595190?text=Hi%20FitForge%2C%20I%20need%20assistance."
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
                            <li><i class="fas fa-envelope"></i><span>info@fitforge.com</span></li>
                            <li><i class="fab fa-whatsapp"></i><span><a
                                        href="https://wa.me/919025595190?text=Hi%20FitForge%2C%20I%20need%20assistance."
                                        target="_blank" rel="noopener noreferrer">+91 90255 95190</a></span></li>
                        </ul>
                    </div>
                </div>

                <div class="row bottom-bar">
                    <div class="col-12 text-center">
                        <p class="mb-0">&copy; {{ date('Y') }} {{ $companyName }}. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </footer>

        <!-- WhatsApp Floating Button -->
        <a href="https://wa.me/919025595190?text=Hi%20FitForge%2C%20I%20need%20assistance." target="_blank"
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
                                window.location.href = "{{ url('/') }}?search=" + encodeURIComponent(
                                    query);
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
                        searchResults.innerHTML =
                            '<div class="no-results"><i class="fas fa-search"></i> No products found</div>';
                        return;
                    }

                    let html = '';
                    products.forEach(function(product) {
                        const imageUrl = product.image_url || '{{ asset('images/no-image.png') }}';
                        const price = product.price || product.mrp || '0';

                        html += `
                        <a href="/product/${product.id}" class="search-result-item">
                            <img src="${imageUrl}" alt="${product.name}" class="result-image" onerror="this.src='{{ asset('images/no-image.png') }}'">
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
            // ================================================================
            // ===== PROFILE IMAGE UPLOAD =====
            // ================================================================
            async function uploadProfileImage(event) {
                const file = event.target.files[0];
                if (!file) return;

                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!allowedTypes.includes(file.type)) {
                    showToast('Please upload JPEG, PNG, GIF, or WEBP image!');
                    return;
                }

                if (file.size > 2 * 1024 * 1024) {
                    showToast('Image size should be less than 2MB!');
                    return;
                }

                const formData = new FormData();
                formData.append('profile_image', file);
                formData.append('_token', '{{ csrf_token() }}');

                const avatarDisplay = document.getElementById('profileAvatarDisplay');
                if (!avatarDisplay) {
                    showToast('Profile avatar element not found');
                    return;
                }

                const originalContent = avatarDisplay.innerHTML;
                avatarDisplay.innerHTML = '<i class="fas fa-spinner fa-spin" style="font-size: 32px;"></i>';

                try {
                    const response = await fetch('/api/update-profile-image', {
                        method: 'POST',
                        body: formData
                    });

                    const data = await response.json();

                    if (data.success && data.image_url) {
                        avatarDisplay.innerHTML =
                            `<img src="${data.image_url}?t=${Date.now()}" alt="Profile" style="width: 100%; height: 100%; object-fit: cover;">`;
                        showToast("✅ Profile image updated successfully!");
                    } else {
                        avatarDisplay.innerHTML = originalContent;
                        showToast(data.message || "Error uploading image");
                    }
                } catch (error) {
                    console.error('Error:', error);
                    avatarDisplay.innerHTML = originalContent;
                    showToast("Network error. Please try again.");
                }

                event.target.value = '';
            }

            // ================================================================
            // ===== PROFILE MODAL FUNCTIONS =====
            // ================================================================
            function openProfileModal() {
                cancelModalProfileEdit();

                // Properly initialize Bootstrap Modal
                const modalElement = document.getElementById('profileModal');
                if (!modalElement) {
                    console.error('Profile modal element not found');
                    return;
                }

                // Use Bootstrap's modal method correctly
                const modal = new bootstrap.Modal(modalElement, {
                    backdrop: true,
                    keyboard: true
                });
                modal.show();
            }

            function enableModalProfileEdit() {
                // Only Name field is editable - Check if elements exist first
                const nameDisplay = document.getElementById('modalNameDisplay');
                const nameInput = document.getElementById('modalNameInput');
                const editBtn = document.getElementById('modalEditProfileBtn');
                const saveBtn = document.getElementById('modalSaveProfileBtn');
                const cancelBtn = document.getElementById('modalCancelProfileBtn');

                if (nameDisplay) nameDisplay.style.display = 'none';
                if (nameInput) nameInput.style.display = 'block';
                if (editBtn) editBtn.style.display = 'none';
                if (saveBtn) saveBtn.style.display = 'block';
                if (cancelBtn) cancelBtn.style.display = 'block';

                if (nameInput) nameInput.focus();
            }

            function cancelModalProfileEdit() {
                // Check if elements exist first
                const nameDisplay = document.getElementById('modalNameDisplay');
                const nameInput = document.getElementById('modalNameInput');
                const editBtn = document.getElementById('modalEditProfileBtn');
                const saveBtn = document.getElementById('modalSaveProfileBtn');
                const cancelBtn = document.getElementById('modalCancelProfileBtn');

                if (nameDisplay) nameDisplay.style.display = 'block';
                if (nameInput) nameInput.style.display = 'none';
                if (editBtn) editBtn.style.display = 'block';
                if (saveBtn) saveBtn.style.display = 'none';
                if (cancelBtn) cancelBtn.style.display = 'none';

                if (nameInput && nameDisplay) {
                    nameInput.value = nameDisplay.textContent;
                }
            }

            async function saveModalProfile() {
                const nameInput = document.getElementById('modalNameInput');
                if (!nameInput) {
                    showToast('Name input not found');
                    return;
                }

                const name = nameInput.value.trim();

                if (!name) {
                    showToast('Name cannot be empty!');
                    return;
                }

                const saveBtn = document.getElementById('modalSaveProfileBtn');
                if (!saveBtn) return;

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
                        const profileName = document.getElementById('modalProfileName');
                        const nameDisplay = document.getElementById('modalNameDisplay');

                        if (profileName) profileName.textContent = name;
                        if (nameDisplay) nameDisplay.textContent = name;

                        const navbarName = document.querySelector('.user-dropdown span');
                        if (navbarName) {
                            navbarName.textContent = name;
                        }

                        showToast("✅ Profile updated successfully!");
                        cancelModalProfileEdit();
                    } else {
                        showToast(data.message || "Error updating profile");
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showToast("Network error. Please try again.");
                } finally {
                    if (saveBtn) {
                        saveBtn.innerHTML = originalText;
                        saveBtn.disabled = false;
                    }
                }
            } // ================================================================
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

            // ================================================================
            // ===== ADDRESS MANAGEMENT FUNCTIONS =====
            // ================================================================
            let editAddressId = null;
            let addressesData = @json($userAddresses ?? []);

            function toggleAddAddressForm() {
                const form = document.getElementById('addAddressFormModal');
                if (!form) return;

                if (form.style.display === 'none' || form.style.display === '') {
                    form.style.display = 'block';
                    const editForm = document.getElementById('editAddressFormModal');
                    if (editForm) editForm.style.display = 'none';

                    // Clear fields
                    const newAddress = document.getElementById('newAddressInput');
                    const newCity = document.getElementById('newCityInput');
                    const newState = document.getElementById('newStateInput');
                    const newPincode = document.getElementById('newPincodeInput');
                    const newPhone = document.getElementById('newPhoneInput');

                    if (newAddress) newAddress.value = '';
                    if (newCity) newCity.value = '';
                    if (newState) newState.value = '';
                    if (newPincode) newPincode.value = '';
                    if (newPhone) newPhone.value = '{{ Auth::user()->phone ?? '' }}';
                } else {
                    form.style.display = 'none';
                }
            }

            function editAddress(index) {
                const addr = addressesData[index];

                if (addr) {
                    editAddressId = addr.id;

                    const editAddress = document.getElementById('editAddressInput');
                    const editCity = document.getElementById('editCityInput');
                    const editState = document.getElementById('editStateInput');
                    const editPincode = document.getElementById('editPincodeInput');

                    if (editAddress) editAddress.value = addr.address || '';
                    if (editCity) editCity.value = addr.city || '';
                    if (editPincode) editPincode.value = addr.pincode || '';

                    // Set state dropdown value
                    if (editState) {
                        editState.value = addr.state || '';
                    }

                    const editForm = document.getElementById('editAddressFormModal');
                    const addForm = document.getElementById('addAddressFormModal');

                    if (editForm) editForm.style.display = 'block';
                    if (addForm) addForm.style.display = 'none';
                }
            }

            function closeEditAddressForm() {
                const editForm = document.getElementById('editAddressFormModal');
                if (editForm) editForm.style.display = 'none';
                editAddressId = null;
            }

            async function saveNewAddress() {
                const address = document.getElementById('newAddressInput');
                const city = document.getElementById('newCityInput');
                const state = document.getElementById('newStateInput');
                const pincode = document.getElementById('newPincodeInput');
                const phone = document.getElementById('newPhoneInput');

                if (!address || !city || !state || !pincode) {
                    showToast('Please fill all required fields!');
                    return;
                }

                const addressVal = address.value.trim();
                const cityVal = city.value.trim();
                const stateVal = state.value;
                const pincodeVal = pincode.value.trim();
const phoneVal = '{{ Auth::user()->phone ?? '' }}';
                if (!addressVal || !cityVal || !stateVal || !pincodeVal) {
                    showToast('Please fill all required fields!');
                    return;
                }

                try {
                    const response = await fetch('/api/user-addresses', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            name: '{{ Auth::user()->name ?? '' }}',
                            email: '{{ Auth::user()->email ?? '' }}',

                            address: addressVal,
                            city: cityVal,
                            state: stateVal,
                            pincode: pincodeVal,

                            phone: phoneVal,

                            is_default: false
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        showToast('✅ Address added successfully!');
                        const addForm = document.getElementById('addAddressFormModal');
                        if (addForm) addForm.style.display = 'none';
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showToast(data.message || 'Error adding address');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showToast('Network error. Please try again.');
                }
            }





            async function updateAddress() {
                const address = document.getElementById('editAddressInput');
                const city = document.getElementById('editCityInput');
                const state = document.getElementById('editStateInput');
                const pincode = document.getElementById('editPincodeInput');

                if (!address || !city || !state || !pincode) {
                    showToast('Please fill all required fields!');
                    return;
                }

                const addressVal = address.value.trim();
                const cityVal = city.value.trim();
                const stateVal = state.value;
                const pincodeVal = pincode.value.trim();

                if (!addressVal || !cityVal || !stateVal || !pincodeVal) {
                    showToast('Please fill all required fields!');
                    return;
                }

                try {
                    const response = await fetch(`/api/user-addresses/${editAddressId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            name: '{{ Auth::user()->name ?? '' }}',
                            email: '{{ Auth::user()->email ?? '' }}',
                            phone: '{{ Auth::user()->phone ?? '' }}',

                            address: addressVal,
                            city: cityVal,
                            state: stateVal,
                            pincode: pincodeVal
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        showToast('✅ Address updated successfully!');
                        closeEditAddressForm();
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showToast(data.message || 'Error updating address');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showToast('Network error. Please try again.');
                }
            }



            async function deleteAddress(addressId) {
                if (!confirm('Are you sure you want to delete this address?')) {
                    return;
                }

                try {
                    const response = await fetch(`/api/user-addresses/${addressId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        showToast('🗑️ Address deleted successfully!');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showToast(data.message || 'Error deleting address');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showToast('Network error. Please try again.');
                }
            }
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
