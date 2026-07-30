@extends('layouts.app')

@section('content')
    <style>
        /* ===== BREADCRUMB ===== */
        .breadcrumb-section {
            background: #f8fafc;
            padding: 10px 0;
            margin-bottom: 20px;
            margin-top: 15px;
            border-bottom: 1px solid #eef2f6;
        }

        .breadcrumb-section .breadcrumb {
            margin: 0;
            background: transparent;
            padding: 0;
        }

        .breadcrumb-section .breadcrumb-item a {
            color: #64748b;
            text-decoration: none;
            font-size: 0.85rem;
        }

        .breadcrumb-section .breadcrumb-item a:hover {
            color: #dc3545;
        }

        .breadcrumb-section .breadcrumb-item.active {
            color: #1e293b;
            font-weight: 600;
            font-size: 0.85rem;
        }

        /* ===== SUB CATEGORIES ===== */
        .sub-categories-section {
            margin-bottom: 30px;
            padding: 20px 0;
            background: #ffffff;
            border-radius: 15px;
            border: 1px solid #eef2f6;
        }

        .sub-categories-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 18px;
            padding: 0 20px;
        }

        .sub-categories-scroll {
            display: flex;
            gap: 16px;
            overflow-x: auto;
            padding: 5px 20px 15px 20px;
            scrollbar-width: thin;
            scrollbar-color: #dc3545 #f1f1f1;
            -webkit-overflow-scrolling: touch;
        }

        .sub-categories-scroll::-webkit-scrollbar {
            height: 6px;
        }

        .sub-categories-scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .sub-categories-scroll::-webkit-scrollbar-thumb {
            background: #dc3545;
            border-radius: 10px;
        }

        .sub-category-item {
            flex: 0 0 auto;
            min-width: 230px;
            height: 240px;
            text-align: center;
            padding: 18px 20px;
            background: white;
            border-radius: 16px;
            border: 2px solid #eef2f6;
            transition: all 0.3s;
            cursor: pointer;
            text-decoration: none;
            color: #1e293b;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
            position: relative;
            overflow: hidden;
        }

        .sub-category-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(220, 53, 69, 0.2);
            border-color: #dc3545;
        }

        .sub-category-item.active {
            border-color: #dc3545;
            background: #dc3545;
            color: white;
            box-shadow: 0 8px 25px rgba(220, 53, 69, 0.3);
        }

        .sub-category-item * {
            position: relative;
            z-index: 1;
        }

        .sub-category-item img {
            width: 180px;
            height: 180px;
            object-fit: cover;
            margin-bottom: 12px;
            transition: all 0.3s;
        }

        .sub-category-item:hover img {
            transform: scale(1.05);
        }

        .sub-category-item.active img {
            border-color: white;
            transform: scale(1.05);
        }

        .sub-category-item .sub-cat-icon {
            width: 70px;
            height: 70px;
            background: #f8fafc;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            font-size: 2rem;
            color: #64748b;
            border: 3px solid #eef2f6;
            transition: all 0.3s;
        }

        .sub-category-item:hover .sub-cat-icon {
            border-color: #dc3545;
            color: #dc3545;
        }

        .sub-category-item.active .sub-cat-icon {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border-color: white;
        }

        .sub-category-item .sub-cat-name {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            white-space: nowrap;
            margin-bottom: 4px;
        }

        .sub-category-item .product-count {
            display: block;
            font-size: 0.7rem;
            opacity: 0.7;
            font-weight: 400;
        }

        .sub-category-item.active .product-count {
            opacity: 0.9;
        }

        /* ===== FILTER INFO ===== */
        .filter-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .filter-info .results-count {
            font-size: 0.9rem;
            color: #64748b;
        }

        .filter-info .results-count strong {
            color: #1e293b;
        }

        /* ===== PRODUCT CARD ===== */
        .product-card {
            border: 1px solid #eee;
            border-radius: 12px;
            transition: transform 0.3s, box-shadow 0.3s;
            overflow: hidden;
            margin-bottom: 25px;
            height: 100%;
            position: relative;
            background: white;
            cursor: pointer;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .product-image-container {
            width: 100%;
            height: 250px;
            overflow: hidden;
            background: #f8f9fa;
            position: relative;
        }

        .product-image-container img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            transition: transform 0.5s ease;
            background: #ffffff;
            padding: 10px;
        }

        .product-card:hover .product-image-container img {
            transform: scale(1.03);
        }

        .discount-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #dc3545;
            color: white;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 700;
            z-index: 1;
        }

        .wishlist-btn {
            position: absolute;
            top: 10px;
            left: 10px;
            background: white;
            border: none;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 2;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
            transition: all 0.3s;
        }

        .wishlist-btn i {
            font-size: 1rem;
            transition: all 0.3s;
        }

        .wishlist-btn i.far {
            color: #999;
        }

        .wishlist-btn i.fas {
            color: #dc3545;
        }

        .wishlist-btn:hover {
            transform: scale(1.1);
        }

        .product-card .card-body {
            padding: 12px 15px 15px;
            text-align: left;
        }

        .product-brand {
            font-size: 0.75rem;
            color: #6c757d;
            font-weight: 500;
            margin-bottom: 2px;
            text-align: left;
            letter-spacing: 0.3px;
        }

        .product-brand i {
            font-size: 0.65rem;
            margin-right: 4px;
            color: #6c757d;
        }

        .product-card .product-name {
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 4px;
            color: #1e293b;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 40px;
            text-align: left;
        }

        .product-price-container {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 2px;
        }

        .product-price-container .final-price {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1e293b;
        }

        .product-price-container .original-price {
            font-size: 0.85rem;
            color: #999;
            text-decoration: line-through;
        }

        .product-price-container .discount-percent {
            background: #dc3545;
            color: white;
            padding: 1px 10px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .product-stock-low {
            font-size: 0.8rem;
            color: #dc3545;
            margin-top: 6px;
            text-align: left;
            font-weight: 600;
        }

        .product-stock-low i {
            font-size: 0.8rem;
            margin-right: 4px;
            color: #dc3545;
        }

        .product-stock-out {
            font-size: 0.8rem;
            color: #999;
            margin-top: 6px;
            text-align: left;
            font-weight: 500;
            background: #f5f5f5;
            padding: 4px 10px;
            border-radius: 4px;
        }

        .product-stock-out i {
            font-size: 0.8rem;
            margin-right: 4px;
            color: #999;
        }

        /* ===== COLOR OPTIONS - WITH COLOR COUNT ===== */
        .color-options-container {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
            margin-top: 6px;
            align-items: center;
        }

        .color-options-container .color-label {
            font-size: 0.65rem;
            color: #666;
            font-weight: 500;
            margin-right: 2px;
        }

        .color-dot {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            border: 2px solid #e0e0e0;
            display: inline-block;
            cursor: pointer;
            transition: all 0.3s;
            flex-shrink: 0;
        }

        .color-dot:hover {
            transform: scale(1.15);
            border-color: #dc3545;
        }

        .color-dot.more-colors {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #f0f0f0;
            border: 2px solid #e0e0e0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 7px;
            color: #666;
            font-weight: 600;
            cursor: pointer;
        }

        .color-dot.more-colors:hover {
            border-color: #dc3545;
            background: #dc3545;
            color: white;
        }

        /* ===== FILTER SIDEBAR ===== */
   .filter-sidebar-wrapper {
    position: sticky;
    top: 115px;
    align-self: flex-start;
    height: calc(100vh - 115px);
}

      .filter-sidebar {
    background: white;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 5px 15px rgba(0,0,0,.05);

    height: calc(100vh - 125px);
    overflow-y: auto;

    margin-top: 0;
}

        .filter-sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .filter-sidebar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .filter-sidebar::-webkit-scrollbar-thumb {
            background: #dc3545;
            border-radius: 10px;
        }

        .filter-section {
            margin-bottom: 18px;
            border-bottom: 1px solid #eef2f6;
            padding-bottom: 15px;
        }

        .filter-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .filter-title {
            font-size: 0.9rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: #1e293b;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            user-select: none;
        }

        .filter-title i {
            font-size: 0.75rem;
            color: #dc3545;
            transition: transform 0.3s ease;
        }

        .filter-title.collapsed i {
            transform: rotate(-90deg);
        }

        .filter-content {
            display: none;
            transition: all 0.3s ease;
        }

        .filter-options {
            list-style: none;
            padding: 0;
            margin: 0;
            max-height: 180px;
            overflow-y: auto;
        }

        .filter-options li {
            margin-bottom: 6px;
        }

        .filter-options label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-size: 0.8rem;
            color: #64748b;
            transition: all 0.3s;
        }

        .filter-options label:hover {
            color: #dc3545;
        }

        .filter-options input[type="checkbox"],
        .filter-options input[type="radio"] {
            width: 14px;
            height: 14px;
            cursor: pointer;
            accent-color: #dc3545;
        }

        /* ===== SIZE OPTIONS - DYNAMIC ===== */
        .size-options {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .size-btn {
            padding: 4px 12px;
            border: 1px solid #e0e0e0;
            border-radius: 20px;
            font-size: 0.7rem;
            cursor: pointer;
            transition: all 0.3s;
            background: white;
            font-weight: 500;
        }

        .size-btn:hover,
        .size-btn.active {
            background: #dc3545;
            border-color: #dc3545;
            color: white;
        }

        /* ===== COLOR OPTIONS - DYNAMIC WITH NAMES ===== */
        .color-options-filter {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .color-filter-item {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border: 1px solid #e0e0e0;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s;
            background: white;
            font-size: 0.7rem;
            font-weight: 500;
        }

        .color-filter-item:hover,
        .color-filter-item.active {
            border-color: #dc3545;
            background: #dc3545;
            color: white;
        }

        .color-filter-item .color-dot-small {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 2px solid #e0e0e0;
            flex-shrink: 0;
            transition: all 0.3s;
        }

        .color-filter-item.active .color-dot-small {
            border-color: white;
        }

        .color-filter-item .color-name {
            font-size: 0.7rem;
        }

        .filter-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .btn-reset-filter {
            background: #e2e8f0;
            color: #64748b;
            border: none;
            border-radius: 25px;
            padding: 6px 12px;
            font-size: 0.75rem;
            cursor: pointer;
            flex: 1;
            width: 100%;
        }

        .btn-reset-filter:hover {
            background: #cbd5e1;
        }

        .loader {
            text-align: center;
            padding: 50px;
        }

        .loader i {
            font-size: 3rem;
            color: #dc3545;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .no-products {
            text-align: center;
            padding: 40px;
            background: white;
            border-radius: 15px;
        }

        .sorting-wrapper {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 15px;
        }

        .sort-select {
            padding: 6px 15px;
            border-radius: 30px;
            border: 1px solid #e0e0e0;
            background: white;
            font-size: 0.8rem;
            cursor: pointer;
            outline: none;
        }

        .sort-select:focus {
            border-color: #dc3545;
        }

        .product-grid {
            margin-left: -10px;
            margin-right: -10px;
        }


        .product-grid>[class*="col-"] {
            padding-left: 10px;
            padding-right: 10px;
        }
.products-scroll {
    height: calc(100vh - 125px);
    overflow-y: auto;
    overflow-x: hidden;
    padding-right: 10px;
}

.products-scroll::-webkit-scrollbar {
    width: 6px;
}

.products-scroll::-webkit-scrollbar-thumb {
    background: #dc3545;
    border-radius: 10px;
}
        /* ============================================================ */
        /* ===== RESPONSIVE ===== */
        /* ============================================================ */
@media (max-width: 992px) {

    .filter-sidebar-wrapper {
        position: static;
        height: auto;
    }

    .filter-sidebar {
        height: auto;
        overflow: visible;
    }

    .products-scroll {
        height: auto;
        overflow: visible;
    }
}

        @media (max-width: 768px) {
            .sub-category-item {
                min-width: 120px;
                padding: 14px 16px;
                height: 200px;
            }

            .sub-category-item img {
                width: 55px;
                height: 55px;
            }

            .sub-category-item .sub-cat-icon {
                width: 55px;
                height: 55px;
                font-size: 1.5rem;
            }

            .sub-category-item .sub-cat-name {
                font-size: 0.8rem;
            }

            .filter-info {
                flex-direction: column;
                align-items: flex-start;
            }

            .sub-categories-section {
                padding: 12px 0;
            }

            .product-image-container {
                height: 200px;
            }

            .product-card .product-name {
                font-size: 0.75rem;
                min-height: 30px;
            }

            .product-price-container .final-price {
                font-size: 0.95rem;
            }

            .product-brand {
                font-size: 0.65rem;
            }

            .color-dot {
                width: 16px;
                height: 16px;
            }

            .color-dot.more-colors {
                width: 16px;
                height: 16px;
                font-size: 6px;
            }
        }

        @media (max-width: 576px) {
            .sub-category-item {
                min-width: 100px;
                padding: 10px 12px;
                height: 170px;
            }

            .sub-category-item img {
                width: 45px;
                height: 45px;
            }

            .sub-category-item .sub-cat-icon {
                width: 45px;
                height: 45px;
                font-size: 1.2rem;
            }

            .sub-category-item .sub-cat-name {
                font-size: 0.7rem;
            }

            .product-image-container {
                height: 160px;
            }

            .product-card .product-name {
                font-size: 0.7rem;
                min-height: 25px;
            }

            .product-price-container .final-price {
                font-size: 0.85rem;
            }

            .product-brand {
                font-size: 0.6rem;
            }

            .color-dot {
                width: 14px;
                height: 14px;
            }

            .color-dot.more-colors {
                width: 14px;
                height: 14px;
                font-size: 5px;
            }

            .filter-sidebar {
                padding: 12px 15px;
            }

            .filter-title {
                font-size: 0.8rem;
            }

            .filter-options label {
                font-size: 0.75rem;
            }

            .col-sm-6 {
                flex: 0 0 50%;
                max-width: 50%;
            }

            .container {
                padding-left: 10px !important;
                padding-right: 10px !important;
            }

            .sorting-wrapper {
                justify-content: flex-start;
            }

            .sort-select {
                font-size: 0.7rem;
                padding: 4px 10px;
            }

            .size-btn {
                font-size: 0.6rem;
                padding: 3px 8px;
            }

            .color-filter-item {
                font-size: 0.6rem;
                padding: 3px 8px;
            }

            .color-filter-item .color-dot-small {
                width: 12px;
                height: 12px;
            }
        }

        @media (max-width: 400px) {
            .product-image-container {
                height: 120px;
            }

            .product-card .product-name {
                font-size: 0.65rem;
                min-height: 24px;
            }

            .product-price-container .final-price {
                font-size: 0.75rem;
            }

            .product-brand {
                font-size: 0.55rem;
            }

            .color-dot {
                width: 12px;
                height: 12px;
            }

            .color-dot.more-colors {
                width: 12px;
                height: 12px;
                font-size: 4px;
            }

            .sub-category-item {
                min-width: 80px;
                padding: 8px 10px;
                height: 140px;
            }

            .sub-category-item .sub-cat-icon {
                width: 35px;
                height: 35px;
                font-size: 1rem;
            }

            .sub-category-item .sub-cat-name {
                font-size: 0.6rem;
            }

            .sub-category-item img {
                width: 35px;
                height: 35px;
            }
        }

        /* ============================================================ */
        /* ===== CUSTOM ALERT / TOAST STYLES ===== */
        /* ============================================================ */
        .custom-alert-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999999;
            display: none;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.3s ease;
        }

        .custom-alert-overlay.show {
            display: flex;
        }

        .custom-alert-box {
            background: #ffffff;
            border-radius: 16px;
            padding: 30px 35px;
            max-width: 400px;
            width: 90%;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.3s ease;
            position: relative;
        }

        .custom-alert-box .alert-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 2.2rem;
        }

        .custom-alert-box .alert-icon.warning {
            background: #fff3cd;
            color: #dc3545;
        }

        .custom-alert-box .alert-icon.success {
            background: #d4edda;
            color: #28a745;
        }

        .custom-alert-box .alert-icon.info {
            background: #d1ecf1;
            color: #17a2b8;
        }

        .custom-alert-box .alert-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .custom-alert-box .alert-message {
            font-size: 0.9rem;
            color: #64748b;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .custom-alert-box .alert-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .custom-alert-box .alert-btn {
            padding: 8px 24px;
            border: none;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .custom-alert-box .alert-btn-primary {
            background: #dc3545;
            color: white;
        }

        .custom-alert-box .alert-btn-primary:hover {
            background: #b02a37;
            transform: scale(1.02);
        }

        .custom-alert-box .alert-btn-secondary {
            background: #e2e8f0;
            color: #64748b;
        }

        .custom-alert-box .alert-btn-secondary:hover {
            background: #cbd5e1;
        }

        .custom-alert-box .alert-btn-success {
            background: #28a745;
            color: white;
        }

        .custom-alert-box .alert-btn-success:hover {
            background: #1e7e34;
            transform: scale(1.02);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(30px) scale(0.95);
                opacity: 0;
            }

            to {
                transform: translateY(0) scale(1);
                opacity: 1;
            }
        }

        /* Mobile responsive */
        @media (max-width: 576px) {
            .custom-alert-box {
                padding: 25px 20px;
                max-width: 95%;
            }

            .custom-alert-box .alert-icon {
                width: 55px;
                height: 55px;
                font-size: 1.8rem;
            }

            .custom-alert-box .alert-title {
                font-size: 1rem;
            }

            .custom-alert-box .alert-message {
                font-size: 0.8rem;
            }

            .custom-alert-box .alert-btn {
                padding: 6px 18px;
                font-size: 0.8rem;
            }
        }
    </style>

    <!-- ===== CUSTOM ALERT OVERLAY ===== -->
    <div class="custom-alert-overlay" id="customAlertOverlay">
        <div class="custom-alert-box">
            <div class="alert-icon warning" id="alertIcon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="alert-title" id="alertTitle">Login Required</div>
            <div class="alert-message" id="alertMessage">Please login to add items to wishlist!</div>
            <div class="alert-buttons" id="alertButtons">
                <button class="alert-btn alert-btn-secondary" onclick="closeCustomAlert()">Cancel</button>
                <a href="{{ route('login') }}" class="alert-btn alert-btn-primary" id="alertActionBtn">Login Now</a>
            </div>
        </div>
    </div>

    <!-- Breadcrumb Section -->
    <div class="breadcrumb-section">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('shop') }}">Shop</a></li>
                    <li class="breadcrumb-item " id="breadcrumbCategory">All Products</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container mb-4">
        <!-- Sub Categories Section -->
        <div class="sub-categories-section" id="subCategoriesSection" style="display: none;">
            <div class="sub-categories-title" id="categoryTitle">Shop by Category</div>
            <div class="sub-categories-scroll" id="subCategoriesContainer">
                <span class="text-muted" style="font-size:0.85rem; padding:10px 0;">Loading sub categories...</span>
            </div>
        </div>

        <div class="row">
            <!-- Filter Sidebar -->
            <div class="col-md-3">
                <div class="filter-sidebar-wrapper">
                    <div class="filter-sidebar">
                        <h5 class="mb-3"><i class="fas fa-filter me-2 text-danger"></i> Filters</h5>

                        <!-- Category Filter -->
                        <div class="filter-section">
                            <div class="filter-title collapsed" onclick="toggleFilter(this, 'category')">
                                Category <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="filter-content" id="filter-category" style="display: none;">
                                <ul class="filter-options" id="categoryFilterList"></ul>
                            </div>
                        </div>

                        <!-- Brand Filter -->
                        <div class="filter-section">
                            <div class="filter-title collapsed" onclick="toggleFilter(this, 'brand')">
                                Brand <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="filter-content" id="filter-brand" style="display: none;">
                                <ul class="filter-options" id="brandFilterList"></ul>
                            </div>
                        </div>

                        <!-- Price Filter -->
                        <div class="filter-section">
                            <div class="filter-title collapsed" onclick="toggleFilter(this, 'price')">
                                Price <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="filter-content" id="filter-price" style="display: none;">
                                <ul class="filter-options">
                                    <li><label><input type="radio" name="price" value="0-500"
                                                onchange="autoApplyFilters()"> ₹0 - ₹500</label></li>
                                    <li><label><input type="radio" name="price" value="500-1000"
                                                onchange="autoApplyFilters()"> ₹500 - ₹1000</label></li>
                                    <li><label><input type="radio" name="price" value="1000-2000"
                                                onchange="autoApplyFilters()"> ₹1000 - ₹2000</label></li>
                                    <li><label><input type="radio" name="price" value="2000-5000"
                                                onchange="autoApplyFilters()"> ₹2000 - ₹5000</label></li>
                                    <li><label><input type="radio" name="price" value="5000-10000"
                                                onchange="autoApplyFilters()"> ₹5000 - ₹10000</label></li>
                                    <li><label><input type="radio" name="price" value="10000+"
                                                onchange="autoApplyFilters()"> ₹10000+</label></li>
                                </ul>
                            </div>
                        </div>

                        <!-- ===== SIZE FILTER - DYNAMIC ===== -->
                        <div class="filter-section">
                            <div class="filter-title collapsed" onclick="toggleFilter(this, 'size')">
                                Size <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="filter-content" id="filter-size" style="display: none;">
                                <div class="size-options" id="sizeFilterContainer">
                                    <span class="text-muted" style="font-size:0.8rem;">Loading sizes...</span>
                                </div>
                            </div>
                        </div>

                        <!-- ===== COLOR FILTER - DYNAMIC WITH NAMES ===== -->
                        <div class="filter-section">
                            <div class="filter-title collapsed" onclick="toggleFilter(this, 'color')">
                                Color <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="filter-content" id="filter-color" style="display: none;">
                                <div class="color-options-filter" id="colorFilterContainer">
                                    <span class="text-muted" style="font-size:0.8rem;">Loading colors...</span>
                                </div>
                            </div>
                        </div>

                        <div class="filter-actions">
                            <button class="btn-reset-filter" onclick="resetFilters()"><i class="fas fa-undo me-1"></i>
                                Reset All</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Container -->
<div class="col-md-9">
    <div class="products-scroll">              

                <div class="sorting-wrapper">
                    <select class="sort-select" id="sortBy" onchange="sortProducts()">
                        <option value="default">Default Sorting</option>
                        <option value="price_asc">Price: Low to High</option>
                        <option value="price_desc">Price: High to Low</option>
                        <option value="name_asc">Name: A to Z</option>
                        <option value="name_desc">Name: Z to A</option>
                    </select>
                </div>

                <div id="loader" class="loader" style="display: none;">
                    <i class="fas fa-spinner"></i>
                    <p>Loading products...</p>
                </div>

                <div class="row product-grid" id="productsContainer"></div>
            </div>
        </div>
    </div>

    <script>
        // ================================================================
        // ===== CUSTOM ALERT FUNCTIONS =====
        // ================================================================

        function showCustomAlert(title, message, type = 'warning', buttonText = 'Login Now', buttonLink =
            '{{ route('login') }}') {
            const overlay = document.getElementById('customAlertOverlay');
            const icon = document.getElementById('alertIcon');
            const titleEl = document.getElementById('alertTitle');
            const messageEl = document.getElementById('alertMessage');
            const actionBtn = document.getElementById('alertActionBtn');

            icon.className = 'alert-icon ' + type;
            if (type === 'warning') {
                icon.innerHTML = '<i class="fas fa-exclamation-triangle"></i>';
            } else if (type === 'success') {
                icon.innerHTML = '<i class="fas fa-check-circle"></i>';
            } else if (type === 'info') {
                icon.innerHTML = '<i class="fas fa-info-circle"></i>';
            }

            titleEl.textContent = title;
            messageEl.textContent = message;

            if (buttonText && buttonLink) {
                actionBtn.textContent = buttonText;
                actionBtn.href = buttonLink;
                actionBtn.style.display = 'inline-block';
            } else {
                actionBtn.style.display = 'none';
            }

            overlay.classList.add('show');
        }

        function closeCustomAlert() {
            const overlay = document.getElementById('customAlertOverlay');
            overlay.classList.remove('show');
        }

        document.getElementById('customAlertOverlay').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCustomAlert();
            }
        });

        function showLoginRequiredAlert() {
            showCustomAlert(
                '🔒 Login Required',
                'Please login to add items to wishlist!',
                'warning',
                'Login Now',
                '{{ route('login') }}'
            );
        }

        // ================================================================
        // ===== VARIABLES =====
        // ================================================================
        let currentCategoryId = null;
        let currentSubCategoryId = null;
        let allProducts = [];
        let filteredProducts = [];
        let categoriesList = [];

        // ================================================================
        // ===== URL PARAMETER =====
        // ================================================================
        function getUrlParameter(name) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

        // ================================================================
        // ===== TOGGLE FILTER =====
        // ================================================================
        function toggleFilter(element, filterId) {
            element.classList.toggle('collapsed');
            const content = document.getElementById(`filter-${filterId}`);
            if (content) {
                content.style.display = content.style.display === 'none' ? 'block' : 'none';
            }
        }

        // ================================================================
        // ===== TOGGLE SIZE =====
        // ================================================================
        function toggleSize(element) {
            element.classList.toggle('active');
            autoApplyFilters();
        }

        // ================================================================
        // ===== TOGGLE COLOR FILTER =====
        // ================================================================
        function toggleColorFilter(element) {
            element.classList.toggle('active');
            autoApplyFilters();
        }

        // ================================================================
        // ===== LOAD CATEGORIES & BRANDS =====
        // ================================================================
        async function loadCategoriesAndBrands() {
            try {
                const response = await fetch('/api/categories');
                categoriesList = await response.json();

                const categoryFilterList = document.getElementById('categoryFilterList');
                if (!categoryFilterList) return;

                categoryFilterList.innerHTML = '';
                categoriesList.forEach(cat => {
                    const checked = currentCategoryId == cat.id ? 'checked' : '';
                    categoryFilterList.innerHTML += `
                        <li>
                            <label>
                                <input type="checkbox" value="${cat.id}" class="filter-check" data-filter="category" ${checked} onchange="autoApplyFilters()">
                                ${cat.name}
                            </label>
                        </li>
                    `;
                });

            } catch (error) {
                console.error('Error loading categories:', error);
            }
        }

        // ================================================================
        // ===== UPDATE SIZE & COLOR FILTERS FROM PRODUCTS =====
        // ================================================================
        function updateSizeAndColorFilters(products) {
            // Extract all sizes from variants
            const sizeSet = new Set();
            const colorSet = new Set();

            products.forEach(product => {
                if (product.variants && product.variants.length > 0) {
                    product.variants.forEach(variant => {
                        if (variant.size && variant.size.trim() !== '') {
                            sizeSet.add(variant.size);
                        }
                        if (variant.color && variant.color.trim() !== '') {
                            colorSet.add(variant.color);
                        }
                    });
                }
            });

            // Sort sizes (XS, S, M, L, XL, XXL)
            const sizeOrder = { 'XS': 0, 'S': 1, 'M': 2, 'L': 3, 'XL': 4, 'XXL': 5 };
            const sortedSizes = Array.from(sizeSet).sort((a, b) => {
                return (sizeOrder[a] || 99) - (sizeOrder[b] || 99);
            });

            // Sort colors alphabetically
            const sortedColors = Array.from(colorSet).sort();

            // Update Size Filter
            const sizeContainer = document.getElementById('sizeFilterContainer');
            if (sizeContainer) {
                if (sortedSizes.length === 0) {
                    sizeContainer.innerHTML = '<span class="text-muted" style="font-size:0.8rem;">No sizes available</span>';
                } else {
                    sizeContainer.innerHTML = sortedSizes.map(size =>
                        `<span class="size-btn" data-size="${size}" onclick="toggleSize(this)">${size}</span>`
                    ).join('');
                }
            }

            // Update Color Filter
            const colorContainer = document.getElementById('colorFilterContainer');
            if (colorContainer) {
                if (sortedColors.length === 0) {
                    colorContainer.innerHTML = '<span class="text-muted" style="font-size:0.8rem;">No colors available</span>';
                } else {
                    // Color mapping for display
                    const colorMap = {
                        'red': '#FF0000',
                        'blue': '#0000FF',
                        'green': '#008000',
                        'yellow': '#FFFF00',
                        'black': '#000000',
                        'white': '#FFFFFF',
                        'pink': '#FFC0CB',
                        'purple': '#800080',
                        'orange': '#FFA500',
                        'grey': '#808080',
                        'gray': '#808080'
                    };

                    colorContainer.innerHTML = sortedColors.map(color => {
                        const colorLower = color.toLowerCase();
                        const bgColor = colorMap[colorLower] || colorLower;
                        const borderStyle = (colorLower === 'white' || colorLower === 'yellow') ?
                            'border: 2px solid #ddd;' : '';

                        return `
                            <div class="color-filter-item" data-color="${color}" onclick="toggleColorFilter(this)">
                                <span class="color-dot-small" style="background: ${bgColor}; ${borderStyle}"></span>
                                <span class="color-name">${color.charAt(0).toUpperCase() + color.slice(1)}</span>
                            </div>
                        `;
                    }).join('');
                }
            }
        }

        // ================================================================
        // ===== LOAD SUB CATEGORIES =====
        // ================================================================
        async function loadSubCategories(categoryId) {
            try {
                const response = await fetch(`/api/subcategories/${categoryId}`);
                const subCategories = await response.json();
                const container = document.getElementById('subCategoriesContainer');
                const title = document.getElementById('categoryTitle');
                const section = document.getElementById('subCategoriesSection');

                if (!container) return;

                if (section) {
                    section.style.display = subCategories.length > 0 ? 'block' : 'none';
                }

                if (subCategories.length === 0) {
                    container.innerHTML =
                        '<span class="text-muted" style="font-size:0.85rem;">No sub categories available</span>';
                    return;
                }

                const categoryName = getUrlParameter('name') || 'All Categories';
                if (title) title.textContent = categoryName;

                const breadcrumb = document.getElementById('breadcrumbCategory');
                if (breadcrumb) breadcrumb.textContent = categoryName;

                container.innerHTML = subCategories.map(sub => {
                    const isActive = currentSubCategoryId == sub.id;
                    const imageHtml = sub.image ?
                        `<img src="/storage/${sub.image}" alt="${sub.name}">` :
                        `<div class="sub-cat-icon"><i class="fas fa-tag"></i></div>`;

                    return `
                        <a href="javascript:void(0)" 
                           class="sub-category-item ${isActive ? 'active' : ''}"
                           onclick="filterBySubCategory(${sub.id}, ${categoryId}, '${sub.name.replace(/'/g, "\\'")}', this)">
                            ${imageHtml}
                            <span class="sub-cat-name">${sub.name}</span>
                        </a>
                    `;
                }).join('');

            } catch (error) {
                console.error('Error loading sub categories:', error);
                const container = document.getElementById('subCategoriesContainer');
                if (container) {
                    container.innerHTML = '<span class="text-danger">Error loading sub categories</span>';
                }
            }
        }

        // ================================================================
        // ===== FILTER BY SUB CATEGORY =====
        // ================================================================
        function filterBySubCategory(subCategoryId, categoryId, subName, element) {
            document.querySelectorAll('.sub-category-item').forEach(item => {
                item.classList.remove('active');
            });
            if (element) {
                element.classList.add('active');
            }

            currentSubCategoryId = subCategoryId;
            currentCategoryId = categoryId;

            const breadcrumb = document.getElementById('breadcrumbCategory');
            if (breadcrumb) breadcrumb.textContent = subName;

            const title = document.getElementById('categoryTitle');
            if (title) title.textContent = subName;

            loadProducts();
        }

        // ================================================================
        // ===== GET PRODUCT IMAGES =====
        // ================================================================
        function getProductImages(product) {
            let images = [];

            if (product.variants && product.variants.length > 0) {
                const firstVariant = product.variants[0];
                if (product.product_images && product.product_images.length > 0) {
                    const variantImages = product.product_images.filter(img => img.variant_id == firstVariant.id);
                    if (variantImages.length > 0) {
                        const sortedImages = [...variantImages].sort((a, b) => {
                            if (a.is_main !== b.is_main) return b.is_main - a.is_main;
                            return (a.display_order || 0) - (b.display_order || 0);
                        });
                        images = sortedImages.map(img => '/storage/' + img.image_path);
                    }
                }
            }

            if (images.length === 0 && product.all_images && product.all_images.length > 0) {
                images = product.all_images.map(img => {
                    if (img.startsWith('http')) return img;
                    return '/storage/' + img;
                });
            }

            if (images.length === 0 && product.image) {
                if (product.image.startsWith('http')) {
                    images.push(product.image);
                } else {
                    images.push('/storage/' + product.image);
                }
            }

            if (images.length === 0) {
                images.push('https://via.placeholder.com/300x300?text=No+Image');
            }

            return images.slice(0, 4);
        }

        // ================================================================
        // ===== GET VARIANT DATA WITH COLORS =====
        // ================================================================
        function getVariantData(product) {
            if (product.variants && product.variants.length > 0) {
                const firstVariant = product.variants[0];

                let variantImages = [];
                if (product.product_images && product.product_images.length > 0) {
                    const variantImageObjs = product.product_images.filter(img => img.variant_id == firstVariant.id);
                    if (variantImageObjs.length > 0) {
                        const sortedImages = [...variantImageObjs].sort((a, b) => {
                            if (a.is_main !== b.is_main) return b.is_main - a.is_main;
                            return (a.display_order || 0) - (b.display_order || 0);
                        });
                        variantImages = sortedImages.map(img => '/storage/' + img.image_path);
                    }
                }

                if (variantImages.length === 0 && product.image) {
                    variantImages.push('/storage/' + product.image);
                }

                if (variantImages.length === 0) {
                    variantImages.push('https://via.placeholder.com/300x300?text=No+Image');
                }

                let totalStock = 0;
                product.variants.forEach(v => {
                    totalStock += parseInt(v.stock) || 0;
                });

                let colors = [];
                if (product.variants && product.variants.length > 0) {
                    const colorSet = new Set();
                    product.variants.forEach(variant => {
                        if (variant.color && variant.color.trim() !== '') {
                            colorSet.add(variant.color);
                        }
                    });
                    colors = Array.from(colorSet);
                }

                const originalPrice = parseFloat(firstVariant.total_price) || parseFloat(firstVariant.mrp) || parseFloat(
                    firstVariant.price) || 0;
                const displayPrice = parseFloat(firstVariant.final_price) || parseFloat(firstVariant.price) || 0;

                return {
                    hasVariant: true,
                    image: variantImages[0],
                    allImages: variantImages,
                    price: displayPrice,
                    originalPrice: originalPrice,
                    discountType: firstVariant.discount_type || 'flat',
                    discountValue: parseFloat(firstVariant.discount_value) || 0,
                    stock: parseInt(firstVariant.stock) || 0,
                    totalStock: totalStock,
                    variantId: firstVariant.id,
                    colors: colors
                };
            }

            const originalPrice = parseFloat(product.total_price) || parseFloat(product.mrp) || parseFloat(product.price) ||
                0;
            const displayPrice = parseFloat(product.final_price) || parseFloat(product.price) || 0;

            return {
                hasVariant: false,
                image: null,
                allImages: [],
                price: displayPrice,
                originalPrice: originalPrice,
                discountType: product.discount_type || 'flat',
                discountValue: parseFloat(product.discount_value) || 0,
                stock: parseInt(product.stock) || 0,
                totalStock: parseInt(product.stock) || 0,
                variantId: null,
                colors: []
            };
        }

        // ================================================================
        // ===== CALCULATE DISCOUNT =====
        // ================================================================
        function calculateDiscount(priceData) {
            const originalPrice = priceData.originalPrice || 0;
            const displayPrice = priceData.price || 0;
            const discountType = priceData.discountType || 'flat';
            const discountValue = priceData.discountValue || 0;

            let discountDisplay = '';
            let hasDiscount = false;

            if (discountValue > 0 && originalPrice > 0) {
                hasDiscount = true;
                const discountAmount = originalPrice - displayPrice;
                const discountPercent = Math.round((discountAmount / originalPrice) * 100);

                if (discountType === 'flat') {
                    discountDisplay = `₹${discountValue.toFixed(2)} off`;
                } else if (discountType === 'percentage') {
                    discountDisplay = `${discountValue}% off`;
                } else {
                    discountDisplay = `₹${discountValue.toFixed(2)} off`;
                }
            } else if (originalPrice > 0 && displayPrice > 0 && displayPrice < originalPrice) {
                hasDiscount = true;
                const discountPercent = Math.round(((originalPrice - displayPrice) / originalPrice) * 100);
                discountDisplay = `${discountPercent}% off`;
            }

            return {
                originalPrice: originalPrice,
                displayPrice: displayPrice,
                discountDisplay: discountDisplay,
                hasDiscount: hasDiscount && discountDisplay !== ''
            };
        }

        // ================================================================
        // ===== LOAD PRODUCTS =====
        // ================================================================
        async function loadProducts() {
            const loader = document.getElementById('loader');
            const container = document.getElementById('productsContainer');
            loader.style.display = 'block';

            try {
                let url = '/api/products';

                if (currentSubCategoryId) {
                    url = `/api/products/subcategory/${currentSubCategoryId}`;
                } else if (currentCategoryId) {
                    url = `/api/products/category/${currentCategoryId}`;
                }

                const response = await fetch(url);
                const products = await response.json();

                allProducts = products;
                filteredProducts = [...products];
                loader.style.display = 'none';

                const countDisplay = document.getElementById('productCountDisplay');
                if (countDisplay) countDisplay.textContent = products.length;

                // Update Size & Color filters from products
                updateSizeAndColorFilters(products);

                // Populate brand filter
                const brands = [...new Set(products.map(p => p.brand && p.brand.name ? p.brand.name : null).filter(b =>
                    b))];
                const brandFilterList = document.getElementById('brandFilterList');
                if (brandFilterList && brands.length > 0) {
                    brandFilterList.innerHTML = brands.map(brand =>
                        `<li><label><input type="checkbox" value="${brand}" class="filter-check" data-filter="brand" onchange="autoApplyFilters()"> ${brand}</label></li>`
                    ).join('');
                }

                if (products.length === 0) {
                    container.innerHTML =
                        '<div class="col-12"><div class="no-products">No products available</div></div>';
                    return;
                }

                renderProducts(products);
            } catch (error) {
                console.error('Error loading products:', error);
                loader.style.display = 'none';
                container.innerHTML =
                    '<div class="col-12"><div class="no-products text-danger">Error loading products. Please try again.</div></div>';
            }
        }

        // ================================================================
        // ===== RENDER PRODUCTS =====
        // ================================================================
        function renderProducts(products) {
            const container = document.getElementById('productsContainer');
            let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];

            if (products.length === 0) {
                container.innerHTML = '<div class="col-12"><div class="no-products">No products found</div></div>';
                return;
            }

            container.innerHTML = products.map(product => {
                const variantData = getVariantData(product);

                let imageUrls = [];
                if (variantData.hasVariant && variantData.allImages.length > 0) {
                    imageUrls = variantData.allImages;
                } else {
                    imageUrls = getProductImages(product);
                }

                const firstImage = imageUrls.length > 0 ? imageUrls[0] :
                    'https://via.placeholder.com/300x300?text=No+Image';

                const priceData = {
                    originalPrice: variantData.originalPrice,
                    price: variantData.price,
                    discountType: variantData.discountType,
                    discountValue: variantData.discountValue
                };

                const discount = calculateDiscount(priceData);
                const displayPrice = discount.displayPrice;
                const originalPrice = discount.originalPrice;
                const discountDisplay = discount.discountDisplay;
                const hasDiscount = discount.hasDiscount;

                const totalStock = variantData.totalStock || parseInt(product.stock) || 0;

                const isInWishlist = wishlist.some(item => item.id === product.id);
                const heartClass = isInWishlist ? 'fas fa-heart' : 'far fa-heart';
                const escapeName = product.name.replace(/'/g, "\\'");

                let brandName = '';
                if (product.brand) {
                    brandName = product.brand.name || '';
                } else if (product.brand_name) {
                    brandName = product.brand_name;
                }

                let brandHtml = '';
                if (brandName) {
                    brandHtml = `
                        <div class="product-brand">
                            <i class="fas fa-tag"></i>
                            ${brandName}
                        </div>
                    `;
                }

                let stockHtml = '';
                if (totalStock <= 5 && totalStock > 0) {
                    stockHtml = `
                        <div class="product-stock-low">
                            <i class="fas fa-exclamation-triangle"></i>
                            Only ${totalStock} left in stock!
                        </div>
                    `;
                } else if (totalStock === 0) {
                    stockHtml = `
                        <div class="product-stock-out">
                            <i class="fas fa-times-circle"></i>
                            Out of Stock
                        </div>
                    `;
                }

                let priceHtml = '';
                if (hasDiscount && originalPrice > 0 && displayPrice > 0) {
                    priceHtml = `
                        <div class="product-price-container">
                            <span class="final-price">₹${displayPrice.toFixed(2)}</span>
                            <span class="original-price">₹${originalPrice.toFixed(2)}</span>
                            <span class="discount-percent">${discountDisplay}</span>
                        </div>
                    `;
                } else {
                    priceHtml = `
                        <div class="product-price-container">
                            <span class="final-price">₹${displayPrice.toFixed(2)}</span>
                        </div>
                    `;
                }

                // ===== COLOR OPTIONS - SHOW COLOR COUNT =====
                let colorHtml = '';
                const totalColors = variantData.colors.length;

                if (totalColors > 0) {
                    const displayColors = variantData.colors.slice(0, 4);
                    const remaining = totalColors - 4;

                    colorHtml = `
                        <div class="color-options-container">
                            <span class="color-label">${totalColors} Color${totalColors > 1 ? 's' : ''}:</span>
                            ${displayColors.map(color => `
                                <span class="color-dot" style="background: ${color.toLowerCase()};" title="${color}"></span>
                            `).join('')}
                            ${remaining > 0 ? `<span class="color-dot more-colors">+${remaining}</span>` : ''}
                        </div>
                    `;
                }

                return `
                    <div class="col-md-4 col-sm-6 mb-4">
                        <div class="product-card card" onclick="goToProductDetail(${product.id}, event)">
                            <button class="wishlist-btn" onclick="event.stopPropagation(); toggleWishlist(${product.id}, '${escapeName}', ${displayPrice}, '${firstImage}')">
                                <i class="${heartClass}" id="wishlist-icon-${product.id}"></i>
                            </button>
                            
                            <div class="product-image-container">
                                <img src="${firstImage}" alt="${product.name}" 
                                    onerror="this.src='https://via.placeholder.com/300x300?text=No+Image'"
                                    loading="lazy">
                            </div>
                            
                            <div class="card-body">
                                ${brandHtml}
                                <div class="product-name">${product.name}</div>
                                ${priceHtml}
                                ${colorHtml}
                                ${stockHtml}
                            </div>
                        </div>
                    </div>
                `;
            }).join('');

            wishlist.forEach(item => {
                const icon = document.getElementById(`wishlist-icon-${item.id}`);
                if (icon) icon.className = 'fas fa-heart';
            });
        }

        // ================================================================
        // ===== AUTO APPLY FILTERS =====
        // ================================================================
        function getSelectedCheckboxValues(filterType) {
            const values = [];
            document.querySelectorAll(`.filter-check[data-filter="${filterType}"]`).forEach(function(checkbox) {
                if (checkbox.checked) {
                    values.push(checkbox.value);
                }
            });
            return values;
        }

        function getSelectedPriceValue() {
            const selected = document.querySelector('input[name="price"]:checked');
            return selected ? selected.value : null;
        }

        function getSelectedSizes() {
            const selected = document.querySelectorAll('.size-btn.active');
            return Array.from(selected).map(btn => btn.dataset.size);
        }

        function getSelectedColors() {
            const selected = document.querySelectorAll('.color-filter-item.active');
            return Array.from(selected).map(el => el.dataset.color);
        }

        function autoApplyFilters() {
            const selectedCategories = getSelectedCheckboxValues('category');
            const selectedBrands = getSelectedCheckboxValues('brand');
            const selectedPrice = getSelectedPriceValue();
            const selectedSizes = getSelectedSizes();
            const selectedColors = getSelectedColors();

            let filtered = [...allProducts];

            // CATEGORY
            if (selectedCategories.length > 0) {
                filtered = filtered.filter(product =>
                    selectedCategories.includes(product.category.id.toString())
                );
            }

            // BRAND
            if (selectedBrands.length > 0) {
                filtered = filtered.filter(product => {
                    if (!product.brand) return false;
                    return selectedBrands.includes(product.brand.name);
                });
            }

            // PRICE
            if (selectedPrice) {
                const [min, max] = selectedPrice.split('-');
                filtered = filtered.filter(product => {
                    let price = 0;
                    if (product.variants && product.variants.length > 0) {
                        price = parseFloat(
                            product.variants[0].final_price ||
                            product.variants[0].price
                        );
                    } else {
                        price = parseFloat(
                            product.final_price ||
                            product.price
                        );
                    }
                    if (max === "10000+") {
                        return price >= parseFloat(min);
                    }
                    return price >= parseFloat(min) && price <= parseFloat(max);
                });
            }

            // SIZE
            if (selectedSizes.length > 0) {
                filtered = filtered.filter(product => {
                    if (!product.variants) return false;
                    return product.variants.some(variant =>
                        variant.size &&
                        selectedSizes.includes(variant.size)
                    );
                });
            }

            // COLOR
            if (selectedColors.length > 0) {
                filtered = filtered.filter(product => {
                    if (!product.variants) return false;
                    return product.variants.some(variant =>
                        variant.color &&
                        selectedColors.includes(variant.color)
                    );
                });
            }

            filteredProducts = filtered;
            renderProducts(filteredProducts);
            document.getElementById('productCountDisplay').innerHTML = filteredProducts.length;
        }

        // ================================================================
        // ===== SORT PRODUCTS =====
        // ================================================================
        function getProductPrice(product) {
            if (product.variants && product.variants.length > 0) {
                return parseFloat(
                    product.variants[0].final_price ||
                    product.variants[0].price
                );
            }
            return parseFloat(
                product.final_price ||
                product.price
            );
        }

        function sortProducts() {
            const sortValue = document.getElementById('sortBy').value;
            let sortedProducts = [...filteredProducts];

            switch (sortValue) {
                case "price_asc":
                    sortedProducts.sort((a, b) =>
                        getProductPrice(a) - getProductPrice(b));
                    break;
                case "price_desc":
                    sortedProducts.sort((a, b) =>
                        getProductPrice(b) - getProductPrice(a));
                    break;
                case "name_asc":
                    sortedProducts.sort((a, b) =>
                        a.name.localeCompare(b.name));
                    break;
                case "name_desc":
                    sortedProducts.sort((a, b) =>
                        b.name.localeCompare(a.name));
                    break;
            }
            renderProducts(sortedProducts);
        }

        // ================================================================
        // ===== RESET FILTERS =====
        // ================================================================
        function resetFilters() {
            document.querySelectorAll('.filter-check:checked').forEach(cb => cb.checked = false);
            document.querySelectorAll('input[name="price"]:checked').forEach(radio => radio.checked = false);
            document.querySelectorAll('.size-btn.active').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.color-filter-item.active').forEach(el => el.classList.remove('active'));

            filteredProducts = [...allProducts];
            renderProducts(allProducts);
            document.getElementById('sortBy').value = 'default';
            document.getElementById('productCountDisplay').innerHTML = allProducts.length;
        }

        // ================================================================
        // ===== WISHLIST FUNCTIONS =====
        // ================================================================
        function goToProductDetail(productId, event) {
            if (event && (event.target.closest('.wishlist-btn') ||
                    event.target.closest('.btn-add-cart') ||
                    event.target.closest('.btn-buy-now') ||
                    event.target.closest('.carousel-control-prev') ||
                    event.target.closest('.carousel-control-next'))) {
                return;
            }
            window.location.href = `/product/${productId}`;
        }

        function toggleWishlist(id, name, price, image, event) {
            if (event) event.stopPropagation();
            @if (!auth()->check())
                showLoginRequiredAlert();
                return;
            @endif

            let currentWishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
            const index = currentWishlist.findIndex(item => item.id === id);
            const icon = document.getElementById(`wishlist-icon-${id}`);

            if (index !== -1) {
                currentWishlist.splice(index, 1);
                if (icon) icon.className = 'far fa-heart';
                showNotification('Removed from wishlist!', 'info');
            } else {
                currentWishlist.push({
                    id,
                    name,
                    price,
                    image,
                    added_at: new Date().toISOString()
                });
                if (icon) icon.className = 'fas fa-heart';
                showNotification('Added to wishlist!', 'success');
            }
            localStorage.setItem('wishlist', JSON.stringify(currentWishlist));
            updateNavbarWishlistCount();
        }

        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `alert alert-${type === 'success' ? 'success' : 'info'} alert-dismissible fade show`;
            notification.style.cssText = 'position:fixed;top:20px;right:20px;z-index:9999;min-width:250px';
            notification.innerHTML =
                `<i class="fas fa-check-circle"></i> ${message}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
            document.body.appendChild(notification);
            setTimeout(() => notification.remove(), 3000);
        }

        function updateNavbarCartCount() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const count = cart.reduce((t, i) => t + i.quantity, 0);
            const el = document.getElementById('navbarCartCount');
            if (el) {
                el.textContent = count;
                el.classList.toggle('hide-badge', count === 0);
            }
        }

        function updateNavbarWishlistCount() {
            const wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
            const count = wishlist.length;
            const el = document.getElementById('navbarWishlistCount');
            if (el) {
                el.textContent = count;
                el.classList.toggle('hide-badge', count === 0);
            }
        }

        // ================================================================
        // ===== INITIALIZE =====
        // ================================================================
        document.addEventListener('DOMContentLoaded', async function() {
            currentCategoryId = getUrlParameter('category');
            currentSubCategoryId = getUrlParameter('subcategory');

            await loadCategoriesAndBrands();

            if (currentCategoryId) {
                await loadSubCategories(currentCategoryId);
            }

            await loadProducts();

            updateNavbarCartCount();
            updateNavbarWishlistCount();
        });
    </script>
@endsection