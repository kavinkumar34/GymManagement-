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
            --shadow-card: 0 1px 2px rgba(20, 22, 26, 0.04), 0 8px 24px rgba(20, 22, 26, 0.06);
            --shadow-card-hover: 0 18px 40px rgba(20, 22, 26, 0.14);
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

        /* ===== FULL WIDTH BANNER - SMOOTH ===== */
        .banner-full-width {
            width: 100%;
            overflow: hidden;
            background: var(--ink);
        }

        .banner-full-width .carousel,
        .banner-full-width .carousel-inner,
        .banner-full-width .carousel-item {
            width: 100%;
            height: 500px;
        }

        .banner-full-width .carousel-item img {
            width: 100%;
            height: 100%;
            object-fit: fill;
            display: block;
        }

        .banner-placeholder {
            width: 100%;
            height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1D2026 0%, #14161A 100%);
            color: #F4F2EC;
            font-family: var(--font-body);
            font-weight: 600;
            font-size: 1.1rem;
            letter-spacing: 0.3px;
        }

        .banner-placeholder i {
            font-size: 2.2rem;
            margin-right: 14px;
            color: var(--signal);
        }

        .banner-full-width .carousel-control-prev,
        .banner-full-width .carousel-control-next {
            width: 46px;
            height: 46px;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(20, 22, 26, 0.55);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 50%;
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 10;
        }

        .banner-full-width:hover .carousel-control-prev,
        .banner-full-width:hover .carousel-control-next {
            opacity: 1;
        }

        .banner-full-width .carousel-control-prev:hover,
        .banner-full-width .carousel-control-next:hover {
            background: var(--signal);
        }

        .banner-full-width .carousel-control-prev {
            left: 18px;
        }

        .banner-full-width .carousel-control-next {
            right: 18px;
        }

        .banner-full-width .carousel-control-prev-icon,
        .banner-full-width .carousel-control-next-icon {
            width: 18px;
            height: 18px;
            background-size: 100% 100%;
        }

        .banner-full-width .carousel-indicators {
            bottom: 18px;
            z-index: 11;
        }

        .banner-full-width .carousel-indicators button {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.7);
            background: transparent;
            opacity: 0.7;
            transition: all 0.3s;
            margin: 0 4px;
        }

        .banner-full-width .carousel-indicators button.active {
            background: var(--signal);
            border-color: var(--signal);
            opacity: 1;
            transform: scale(1.15);
        }

        /* ===== PRODUCT CARD - FIXED LAYOUT ===== */
        .product-card {
            border: 1px solid var(--line);
            border-radius: var(--radius-md);
            transition: transform 0.28s ease, box-shadow 0.28s ease, border-color 0.28s ease;
            overflow: hidden;
            margin-bottom: 25px;
            height: 100%;
            position: relative;
            background: #FFFFFF;
            cursor: pointer;
            box-shadow: var(--shadow-card);
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-card-hover);
            border-color: transparent;
        }

        .product-image-container {
            width: 100%;
            height: 250px;
            overflow: hidden;
            background: var(--fog);
            position: relative;
            flex-shrink: 0;
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
            transform: scale(1.04);
        }

        .discount-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: var(--signal);
            color: white;
            padding: 4px 12px;
            border-radius: var(--radius-sm);
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.3px;
            z-index: 1;
        }

        .wishlist-btn {
            position: absolute;
            top: 10px;
            left: 10px;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(4px);
            border: 1px solid var(--line);
            border-radius: 50%;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 2;
            box-shadow: 0 2px 6px rgba(20, 22, 26, 0.1);
            transition: all 0.25s;
        }

        .wishlist-btn i {
            font-size: 1rem;
            transition: all 0.25s;
        }

        .wishlist-btn i.far {
            color: var(--steel);
        }

        .wishlist-btn i.fas {
            color: var(--signal);
        }

        .wishlist-btn:hover {
            transform: scale(1.1);
            border-color: var(--signal);
        }

        .product-card .card-body {
            padding: 14px 16px 12px;
            text-align: left;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .product-card .card-body .product-brand {
            flex-shrink: 0;
        }

        .product-card .card-body .product-name {
            flex-shrink: 0;
        }

        .product-card .card-body .product-price-container {
            flex-shrink: 0;
        }

        .product-card .card-body .color-options-container {
            flex-shrink: 0;
        }

        .product-card .card-body .product-stock-low,
        .product-card .card-body .product-stock-out {
            flex-shrink: 0;
        }

        .product-card .card-body .button-spacer {
            flex: 1;
            min-height: 8px;
        }

        .product-brand {
            font-size: 0.72rem;
            color: var(--steel);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 4px;
            text-align: left;
        }

        .product-brand i {
            font-size: 0.62rem;
            margin-right: 4px;
            color: var(--signal);
        }

        .product-card .product-name {
            font-size: 0.88rem;
            font-weight: 600;
            margin-bottom: 6px;
            color: var(--ink);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 40px;
            text-align: left;
            line-height: 1.35;
        }

        .product-price-container {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 2px;
        }

        .product-price-container .final-price {
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--ink);
            font-family: var(--font-body);
        }

        .product-price-container .original-price {
            font-size: 0.85rem;
            color: #A3A9B2;
            text-decoration: line-through;
        }

        .product-price-container .discount-percent {
            background: var(--signal-tint);
            color: var(--signal-dark);
            padding: 2px 10px;
            border-radius: var(--radius-sm);
            font-size: 0.72rem;
            font-weight: 700;
        }

        .product-stock-low {
            font-size: 0.78rem;
            color: var(--signal-dark);
            margin-top: 8px;
            text-align: left;
            font-weight: 600;
        }

        .product-stock-low i {
            font-size: 0.78rem;
            margin-right: 4px;
            color: var(--signal);
        }

        .product-stock-out {
            font-size: 0.78rem;
            color: var(--steel);
            margin-top: 8px;
            text-align: left;
            font-weight: 600;
            background: var(--fog);
            padding: 4px 10px;
            border-radius: var(--radius-sm);
            display: inline-block;
        }

        .product-stock-out i {
            font-size: 0.78rem;
            margin-right: 4px;
            color: var(--steel);
        }

        .color-options-container {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
            margin-top: 8px;
            align-items: center;
        }

        .color-options-container .color-label {
            font-size: 0.65rem;
            color: var(--steel);
            font-weight: 600;
            margin-right: 2px;
        }

        .color-dot {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            border: 2px solid var(--line);
            display: inline-block;
            cursor: pointer;
            transition: all 0.3s;
            flex-shrink: 0;
        }

        .color-dot:hover {
            transform: scale(1.15);
            border-color: var(--signal);
        }

        .color-dot.more-colors {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: var(--fog);
            border: 2px solid var(--line);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 7px;
            color: var(--steel);
            font-weight: 700;
            cursor: pointer;
        }

        .color-dot.more-colors:hover {
            border-color: var(--signal);
            background: var(--signal);
            color: white;
        }

        /* ===== PRODUCT ACTION BUTTONS - BOTTOM RIGHT ===== */
        .product-action-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            margin-top: 8px;
            padding-top: 8px;
            border-top: 1px solid var(--line);
            flex-shrink: 0;
            width: 100%;
        }

        .product-action-buttons .btn-view-product,
        .product-action-buttons .btn-add-cart-home {
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: var(--font-body);
            text-transform: uppercase;
            letter-spacing: 0.3px;
            display: flex;
            align-items: center;
            gap: 5px;
            white-space: nowrap;
        }

        .product-action-buttons .btn-view-product {
            background: var(--fog);
            color: var(--ink-soft);
        }

        .product-action-buttons .btn-view-product:hover {
            background: var(--ink);
            color: white;
            transform: translateY(-2px);
        }

        .product-action-buttons .btn-add-cart-home {
            background: var(--signal);
            color: white;
        }

        .product-action-buttons .btn-add-cart-home:hover:not(:disabled) {
            background: var(--signal-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 68, 5, 0.3);
        }

        .product-action-buttons .btn-add-cart-home:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .product-action-buttons .btn-add-cart-home i,
        .product-action-buttons .btn-view-product i {
            font-size: 0.7rem;
        }

        /* ===== CATEGORY CARD ===== */
        .category-card {
            background: white;
            border-radius: var(--radius-lg);
            overflow: hidden;
            transition: all 0.4s ease;
            margin-bottom: 30px;
            box-shadow: var(--shadow-card);
            border: 1px solid var(--line);
            cursor: pointer;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .category-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-card-hover);
        }

        .category-image-wrapper {
            width: 100%;
            height: 280px;
            overflow: hidden;
            background: var(--fog);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .category-image-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(180deg, rgba(20, 22, 26, 0) 40%, rgba(20, 22, 26, 0.55) 100%);
            opacity: 0;
            transition: opacity 0.3s;
            z-index: 1;
        }

        .category-card:hover .category-image-wrapper::before {
            opacity: 1;
        }

        .category-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .category-card:hover .category-image-wrapper img {
            transform: scale(1.08);
        }

        .category-icon-wrapper {
            width: 100%;
            height: 280px;
            background: var(--fog);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .category-icon-wrapper i {
            font-size: 4.5rem;
            color: #C6C2B6;
            transition: transform 0.3s, color 0.3s;
        }

        .category-card:hover .category-icon-wrapper i {
            transform: scale(1.1);
            color: var(--signal);
        }

        .category-info {
            padding: 20px 22px;
            text-align: left;
            background: white;
        }

        .category-info h5 {
            font-family: var(--font-display);
            font-weight: 400;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            font-size: 1.2rem;
            margin-bottom: 6px;
            color: var(--ink);
        }

        .category-info p {
            font-size: 0.82rem;
            color: var(--signal);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            margin-bottom: 0;
            display: inline-block;
            transition: all 0.3s;
        }

        .category-card:hover .category-info p {
            transform: translateX(5px);
            color: var(--ink);
        }

        .category-info p i {
            font-size: 0.75rem;
            transition: transform 0.3s;
        }

        .category-card:hover .category-info p i {
            transform: translateX(5px);
        }

        .category-row {
            margin-left: -15px;
            margin-right: -15px;
        }

        .category-row>[class*="col-"] {
            padding-left: 15px;
            padding-right: 15px;
        }

        .loader {
            text-align: center;
            padding: 50px;
        }

        .loader i {
            font-size: 3rem;
            color: var(--signal);
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
            padding: 50px;
            background: white;
            border: 1px solid var(--line);
            border-radius: var(--radius-lg);
            color: var(--steel);
            font-weight: 500;
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
            background: rgba(20, 22, 26, 0.6);
            backdrop-filter: blur(2px);
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
            border-radius: var(--radius-lg);
            padding: 32px 36px;
            max-width: 400px;
            width: 90%;
            text-align: center;
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.35);
            animation: slideUp 0.3s ease;
            position: relative;
            font-family: var(--font-body);
        }

        .custom-alert-box .alert-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            font-size: 2.1rem;
        }

        .custom-alert-box .alert-icon.warning {
            background: var(--signal-tint);
            color: var(--signal);
        }

        .custom-alert-box .alert-icon.success {
            background: var(--success-tint);
            color: var(--success);
        }

        .custom-alert-box .alert-icon.info {
            background: var(--info-tint);
            color: var(--info);
        }

        .custom-alert-box .alert-title {
            font-family: var(--font-display);
            font-weight: 400;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            font-size: 1.2rem;
            color: var(--ink);
            margin-bottom: 10px;
        }

        .custom-alert-box .alert-message {
            font-size: 0.92rem;
            color: var(--steel);
            margin-bottom: 22px;
            line-height: 1.55;
        }

        .custom-alert-box .alert-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .custom-alert-box .alert-btn {
            padding: 9px 26px;
            border: none;
            border-radius: var(--radius-sm);
            font-size: 0.85rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            letter-spacing: 0.2px;
        }

        .custom-alert-box .alert-btn-primary {
            background: var(--signal);
            color: white;
        }

        .custom-alert-box .alert-btn-primary:hover {
            background: var(--signal-dark);
            transform: scale(1.02);
        }

        .custom-alert-box .alert-btn-secondary {
            background: var(--fog);
            color: var(--ink-soft);
        }

        .custom-alert-box .alert-btn-secondary:hover {
            background: var(--line);
        }

        .custom-alert-box .alert-btn-success {
            background: var(--success);
            color: white;
        }

        .custom-alert-box .alert-btn-success:hover {
            background: #128A3E;
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

        /* ============================================================ */
        /* ===== SECTION WRAPPERS / HEADERS ===== */
        /* ============================================================ */
        .shop-section {
            padding-top: 48px;
        }

        .shop-section-header {
            margin-bottom: 28px;
        }

        .view-all-link {
            color: var(--ink) !important;
            font-size: 0.85rem;
            font-weight: 700;
            text-decoration: none !important;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            border-bottom: 2px solid var(--signal);
            padding-bottom: 2px;
            transition: color 0.25s;
        }

        .view-all-link:hover {
            color: var(--signal) !important;
        }

        /* ================================================================
           ABOUT SECTION - STORE SECTION STYLES
           ================================================================ */

        .about-section {
            padding: 50px 0;
            border-bottom: 1px solid var(--line);
        }

        .about-section:last-child {
            border-bottom: none;
        }

        .about-image {
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
            width: 100%;
            height: 350px;
            object-fit: cover;
            border: 1px solid var(--line);
            transition: all 0.3s ease;
        }

        .about-image:hover {
            box-shadow: var(--shadow-card-hover);
            transform: scale(1.01);
        }

        .about-content h3 {
            font-family: var(--font-display);
            font-weight: 400;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            color: var(--ink);
            margin-bottom: 20px;
            font-size: 1.8rem;
        }

        .about-content h3 i {
            color: var(--signal);
            margin-right: 10px;
        }

        .about-content p {
            color: var(--steel);
            line-height: 1.8;
            margin-bottom: 20px;
            font-weight: 400;
            font-size: 1rem;
        }

        .about-content strong {
            color: var(--ink);
            font-weight: 700;
        }

        .btn-shop-now {
            background: var(--signal);
            color: white;
            padding: 14px 40px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            border: none;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            font-family: var(--font-body);
        }

        .btn-shop-now:hover {
            background: var(--signal-dark);
            transform: scale(1.05);
            color: white;
            box-shadow: 0 6px 20px rgba(255, 68, 5, 0.3);
        }

        .btn-shop-now i {
            margin-right: 8px;
        }

        .btn-join-gym1 {
            background: var(--ink);
            color: white;
            padding: 14px 40px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin-left: 15px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            font-family: var(--font-body);
        }

        .btn-join-gym1:hover {
            background: var(--signal);
            transform: scale(1.05);
            color: white;
            box-shadow: 0 6px 20px rgba(255, 68, 5, 0.3);
        }

        .btn-join-gym1 i {
            margin-right: 8px;
        }

        /* ===== QUICK ADD TO CART MODAL (For Variant Products) ===== */
        .quick-cart-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(20, 22, 26, 0.6);
            backdrop-filter: blur(2px);
            z-index: 999999;
            display: none;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.3s ease;
        }

        .quick-cart-modal-overlay.active {
            display: flex;
        }

        .quick-cart-modal {
            background: white;
            border-radius: var(--radius-lg);
            max-width: 520px;
            width: 92%;
            max-height: 90vh;
            overflow-y: auto;
            padding: 30px 35px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.3s ease;
            position: relative;
        }

        .quick-cart-modal .modal-close-btn {
            position: absolute;
            top: 12px;
            right: 18px;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--steel);
            cursor: pointer;
            transition: all 0.3s;
        }

        .quick-cart-modal .modal-close-btn:hover {
            color: var(--signal);
            transform: rotate(90deg);
        }

        .quick-cart-modal .modal-product-info {
            display: flex;
            gap: 16px;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--line);
        }

        .quick-cart-modal .modal-product-info .modal-product-image {
            width: 80px;
            height: 80px;
            border-radius: var(--radius-sm);
            object-fit: cover;
            background: var(--fog);
            flex-shrink: 0;
        }

        .quick-cart-modal .modal-product-info .modal-product-details {
            flex: 1;
        }

        .quick-cart-modal .modal-product-info .modal-product-details .modal-product-name {
            font-family: var(--font-display);
            font-weight: 400;
            font-size: 1.1rem;
            text-transform: uppercase;
            color: var(--ink);
            margin-bottom: 2px;
        }

        .quick-cart-modal .modal-product-info .modal-product-details .modal-product-brand {
            font-size: 0.75rem;
            color: var(--steel);
            font-weight: 600;
            text-transform: uppercase;
        }

        .quick-cart-modal .modal-product-info .modal-product-details .modal-product-price {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--signal);
            margin-top: 4px;
        }

        .quick-cart-modal .modal-product-info .modal-product-details .modal-product-price .modal-old-price {
            font-size: 0.85rem;
            color: var(--steel);
            text-decoration: line-through;
            font-weight: 500;
            margin-left: 8px;
        }

        .quick-cart-modal .modal-label {
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            color: var(--ink);
            display: block;
            margin-bottom: 6px;
        }

        .quick-cart-modal .modal-color-options {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 16px;
        }

        .quick-cart-modal .modal-color-btn {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s;
            border: 3px solid var(--line);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            background-size: cover;
            background-position: center;
        }

        .quick-cart-modal .modal-color-btn:hover {
            transform: scale(1.1);
            border-color: var(--steel);
        }

        .quick-cart-modal .modal-color-btn.selected {
            border-color: var(--signal);
            box-shadow: 0 0 0 3px rgba(255, 68, 5, 0.3);
            transform: scale(1.1);
        }

        .quick-cart-modal .modal-color-btn .check-mark {
            display: none;
            color: white;
            font-size: 12px;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.5);
        }

        .quick-cart-modal .modal-color-btn.selected .check-mark {
            display: block;
        }

        .quick-cart-modal .modal-size-options {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 16px;
        }

        .quick-cart-modal .modal-size-btn {
            min-width: 50px;
            padding: 6px 14px;
            border: 1px solid var(--line);
            background: white;
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
            font-size: 12px;
            font-weight: 600;
            font-family: var(--font-body);
            color: var(--ink);
        }

        .quick-cart-modal .modal-size-btn:hover:not(.out-of-stock):not(:disabled) {
            border-color: var(--signal);
            background: var(--signal-tint);
            color: var(--ink) !important;
        }

        .quick-cart-modal .modal-size-btn.selected {
            background: var(--signal);
            color: white;
            border-color: var(--signal);
        }

        .quick-cart-modal .modal-size-btn.out-of-stock {
            opacity: 0.4;
            cursor: not-allowed;
            text-decoration: line-through;
        }

        .quick-cart-modal .modal-size-btn.out-of-stock:hover {
            background: white;
            color: var(--ink);
            border-color: var(--line);
        }

        .quick-cart-modal .modal-quantity-selector {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
        }

        .quick-cart-modal .modal-quantity-selector .modal-qty-btn {
            width: 32px;
            height: 32px;
            border: 1px solid var(--line);
            background: white;
            border-radius: var(--radius-sm);
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--ink);
            font-weight: 700;
        }

        .quick-cart-modal .modal-quantity-selector .modal-qty-btn:hover {
            border-color: var(--signal);
            background: var(--signal-tint);
        }

        .quick-cart-modal .modal-quantity-selector .modal-qty-input {
            width: 50px;
            text-align: center;
            padding: 6px;
            border: 1px solid var(--line);
            border-radius: var(--radius-sm);
            font-size: 14px;
            font-weight: 700;
            font-family: var(--font-body);
            color: var(--ink);
        }

        .quick-cart-modal .modal-quantity-selector .modal-qty-input:focus {
            outline: none;
            border-color: var(--signal);
            box-shadow: 0 0 0 3px rgba(255, 68, 5, 0.1);
        }

        .quick-cart-modal .modal-stock-info {
            font-size: 12px;
            color: var(--steel);
            margin-bottom: 16px;
            font-weight: 500;
        }

        .quick-cart-modal .modal-stock-info .in-stock-text {
            color: var(--success);
            font-weight: 700;
        }

        .quick-cart-modal .modal-stock-info .low-stock-text {
            color: var(--signal);
            font-weight: 700;
        }

        .quick-cart-modal .modal-add-to-cart-btn {
            width: 100%;
            background: var(--signal);
            color: white;
            border: none;
            border-radius: 25px;
            padding: 12px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            font-family: var(--font-body);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .quick-cart-modal .modal-add-to-cart-btn:hover:not(:disabled) {
            background: var(--signal-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 68, 5, 0.3);
        }

        .quick-cart-modal .modal-add-to-cart-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .quick-cart-modal .modal-error-msg {
            color: var(--signal);
            font-size: 12px;
            font-weight: 600;
            display: none;
            margin-bottom: 10px;
        }

        /* ===== VIEW FULL DETAILS LINK ===== */
        .modal-view-details-link {
            display: block;
            text-align: center;
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid var(--line);
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--info);
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s;
            font-family: var(--font-body);
        }

        .modal-view-details-link:hover {
            color: var(--signal);
            text-decoration: underline;
        }

        .modal-view-details-link i {
            margin-right: 6px;
            font-size: 0.7rem;
        }

        /* ================================================================
           RESPONSIVE STYLES
           ================================================================ */

        /* Tablet & Small Laptop */
        @media (max-width: 992px) {
            .about-image {
                height: 280px;
            }

            .about-content h3 {
                font-size: 1.5rem;
            }

            .about-content p {
                font-size: 0.95rem;
            }
        }

        /* Mobile */
        @media (max-width: 768px) {
            .about-section {
                padding: 30px 0;
            }

            .about-image {
                height: 200px;
                margin-bottom: 20px;
            }

            .about-content h3 {
                font-size: 1.3rem;
            }

            .about-content p {
                font-size: 0.9rem;
            }

            .btn-shop-now,
            .btn-join-gym1 {
                padding: 12px 30px;
                font-size: 0.9rem;
            }

            .btn-join-gym1 {
                margin-left: 0;
                margin-top: 10px;
            }

            .banner-full-width .carousel-item {
                height: 320px;
            }

            .banner-placeholder {
                height: 320px;
                font-size: 1rem;
            }

            .banner-placeholder i {
                font-size: 2rem;
            }

            .category-image-wrapper {
                height: 220px;
            }

            .product-image-container {
                height: 200px;
            }

            .product-card .product-name {
                font-size: 0.8rem;
                min-height: 35px;
            }

            .product-price-container .final-price {
                font-size: 1rem;
            }

            .product-brand {
                font-size: 0.68rem;
            }

            .category-info h5 {
                font-size: 1.05rem;
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

            .shop-section {
                padding-top: 36px;
            }

            .product-action-buttons .btn-view-product,
            .product-action-buttons .btn-add-cart-home {
                padding: 4px 12px;
                font-size: 0.65rem;
            }

            .quick-cart-modal {
                padding: 25px 20px;
                max-width: 95%;
            }

            .quick-cart-modal .modal-product-info .modal-product-image {
                width: 60px;
                height: 60px;
            }

            .quick-cart-modal .modal-product-info .modal-product-details .modal-product-name {
                font-size: 0.95rem;
            }
        }

        /* Small Mobile */
        @media (max-width: 576px) {
            .about-section {
                padding: 20px 0;
            }

            .about-image {
                height: 160px;
            }

            .about-content h3 {
                font-size: 1.1rem;
            }

            .about-content p {
                font-size: 0.85rem;
                line-height: 1.6;
            }

            .btn-shop-now,
            .btn-join-gym1 {
                padding: 10px 20px;
                font-size: 0.8rem;
                display: block;
                width: 100%;
                text-align: center;
                margin-left: 0;
            }

            .btn-join-gym1 {
                margin-top: 8px;
            }

            .banner-full-width,
            .banner-full-width .carousel,
            .banner-full-width .carousel-inner,
            .banner-full-width .carousel-item {
                height: 160px !important;
            }

            .banner-full-width .carousel-item img {
                width: 100%;
                height: 160px !important;
                object-fit: fill;
            }

            .banner-placeholder {
                height: 160px !important;
            }

            .banner-placeholder i {
                font-size: 1.5rem;
            }

            .banner-full-width .carousel-control-prev,
            .banner-full-width .carousel-control-next {
                width: 32px;
                height: 32px;
            }

            .banner-full-width .carousel-control-prev {
                left: 8px;
            }

            .banner-full-width .carousel-control-next {
                right: 8px;
            }

            .banner-full-width .carousel-control-prev-icon,
            .banner-full-width .carousel-control-next-icon {
                width: 14px;
                height: 14px;
            }

            .category-image-wrapper {
                height: 180px;
            }

            .category-info {
                padding: 14px 16px;
            }

            .category-info h5 {
                font-size: 0.9rem;
                margin-bottom: 4px;
            }

            .category-info p {
                font-size: 0.72rem;
            }

            .product-image-container {
                height: 150px;
            }

            .product-card .card-body {
                padding: 10px 12px 12px;
            }

            .product-card .product-name {
                font-size: 0.7rem;
                min-height: 28px;
            }

            .product-brand {
                font-size: 0.6rem;
                margin-bottom: 2px;
            }

            .product-brand i {
                font-size: 0.55rem;
            }

            .product-price-container .final-price {
                font-size: 0.85rem;
            }

            .product-price-container .original-price {
                font-size: 0.7rem;
            }

            .product-price-container .discount-percent {
                font-size: 0.6rem;
                padding: 1px 6px;
            }

            .product-price-container {
                gap: 4px;
            }

            .discount-badge {
                font-size: 0.6rem;
                padding: 2px 8px;
                top: 6px;
                right: 6px;
            }

            .wishlist-btn {
                width: 28px;
                height: 28px;
                top: 6px;
                left: 6px;
            }

            .wishlist-btn i {
                font-size: 0.8rem;
            }

            .product-stock-low {
                font-size: 0.65rem;
                margin-top: 4px;
            }

            .product-stock-out {
                font-size: 0.65rem;
                margin-top: 4px;
                padding: 3px 8px;
            }

            .color-options-container {
                margin-top: 4px;
                gap: 4px;
            }

            .color-options-container .color-label {
                font-size: 0.55rem;
            }

            .color-dot {
                width: 14px;
                height: 14px;
                border-width: 1.5px;
            }

            .color-dot.more-colors {
                width: 14px;
                height: 14px;
                font-size: 5px;
                border-width: 1.5px;
            }

            .col-sm-6 {
                flex: 0 0 50%;
                max-width: 50%;
            }

            .category-row .col-sm-6 {
                flex: 0 0 50%;
                max-width: 50%;
            }

            .container {
                padding-left: 10px !important;
                padding-right: 10px !important;
            }

            .section-heading {
                font-size: 1.3rem !important;
            }

            .d-flex .view-all-link {
                font-size: 0.72rem !important;
            }

            .banner-full-width .carousel-indicators button {
                width: 8px;
                height: 8px;
                margin: 0 3px;
            }

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
                font-size: 1.05rem;
            }

            .custom-alert-box .alert-message {
                font-size: 0.8rem;
            }

            .custom-alert-box .alert-btn {
                padding: 7px 18px;
                font-size: 0.8rem;
            }

            .product-action-buttons .btn-view-product,
            .product-action-buttons .btn-add-cart-home {
                padding: 4px 10px;
                font-size: 0.6rem;
            }

            .product-action-buttons .btn-view-product i,
            .product-action-buttons .btn-add-cart-home i {
                font-size: 0.6rem;
            }

            .quick-cart-modal {
                padding: 20px 16px;
                max-width: 98%;
            }

            .quick-cart-modal .modal-product-info {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .quick-cart-modal .modal-product-info .modal-product-image {
                width: 80px;
                height: 80px;
            }

            .quick-cart-modal .modal-size-btn {
                min-width: 44px;
                padding: 5px 10px;
                font-size: 11px;
            }

            .quick-cart-modal .modal-color-btn {
                width: 30px;
                height: 30px;
            }
        }

        /* Extra Small Mobile */
        @media (max-width: 400px) {
            .about-content h3 {
                font-size: 0.95rem;
            }

            .about-content p {
                font-size: 0.75rem;
            }

            .btn-shop-now,
            .btn-join-gym1 {
                font-size: 0.7rem;
                padding: 8px 15px;
            }

            .banner-full-width .carousel-item {
                height: 180px;
            }

            .banner-placeholder {
                height: 180px;
                font-size: 0.75rem;
            }

            .banner-placeholder i {
                font-size: 1.2rem;
            }

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

            .category-image-wrapper {
                height: 140px;
            }

            .category-info h5 {
                font-size: 0.75rem;
            }

            .category-info p {
                font-size: 0.65rem;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .about-section .row {
            animation: fadeInUp 0.6s ease forwards;
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

    <!-- ===== QUICK ADD TO CART MODAL (For Variant Products) ===== -->
    <div class="quick-cart-modal-overlay" id="quickCartModal">
        <div class="quick-cart-modal">
            <button class="modal-close-btn" onclick="closeQuickCartModal()">&times;</button>

            <div class="modal-product-info">
                <img class="modal-product-image" id="modalProductImage" src="" alt="Product">
                <div class="modal-product-details">
                    <div class="modal-product-brand" id="modalProductBrand"></div>
                    <div class="modal-product-name" id="modalProductName"></div>
                    <div class="modal-product-price">
                        <span id="modalProductPrice"></span>
                        <span class="modal-old-price" id="modalProductOldPrice"></span>
                    </div>
                </div>
            </div>

            <div id="modalVariantSection">
                <!-- Color Section -->
                <div id="modalColorSection">
                    <span class="modal-label">Color</span>
                    <div class="modal-color-options" id="modalColorOptions"></div>
                </div>

                <!-- Size Section -->
                <div id="modalSizeSection">
                    <span class="modal-label">Size</span>
                    <div class="modal-size-options" id="modalSizeOptions"></div>
                </div>
            </div>

            <!-- Quantity -->
            <span class="modal-label">Quantity</span>
            <div class="modal-quantity-selector">
                <button class="modal-qty-btn" onclick="modalDecrementQty()">-</button>
                <input type="number" class="modal-qty-input" id="modalQtyInput" value="1" min="1">
                <button class="modal-qty-btn" onclick="modalIncrementQty()">+</button>
            </div>

            <!-- Stock Info -->
            <div class="modal-stock-info" id="modalStockInfo">
                <span class="in-stock-text" id="modalStockText">In Stock</span>
            </div>

            <!-- Error Message -->
            <div class="modal-error-msg" id="modalErrorMsg">Please select all options</div>

            <!-- Add to Cart Button -->
            <button class="modal-add-to-cart-btn" id="modalAddToCartBtn" onclick="modalAddToCart()">
                <i class="fas fa-shopping-cart"></i> Add to Cart
            </button>

            <!-- View Full Details Link -->
            <a href="#" class="modal-view-details-link" id="modalViewDetailsLink" onclick="goToModalProductDetail(event)">
                <i class="fas fa-arrow-right"></i> View Full Details →
            </a>
        </div>
    </div>

    <!-- ===== FULL WIDTH BANNER ===== -->
    <div class="banner-full-width">
        <div id="bannerSlider" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-inner" id="bannerContainer">
                <div class="carousel-item active">
                    <div class="banner-placeholder">
                        <i class="fas fa-spinner fa-spin"></i>
                        <span>Loading banners...</span>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#bannerSlider" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#bannerSlider" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </div>

    <!-- About Our Store -->
    <div class="container about-section">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4">
                <img src="https://images.unsplash.com/photo-1472851294608-062f824d29cc?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80"
                    class="about-image" alt="FitForge Online Store">
            </div>
            <div class="col-md-6 about-content">
                <h3><i class="fas fa-store"></i> About Our Online Store</h3>
                <p>Welcome to <strong>FitForge Athletics</strong> - your one-stop destination for all fitness needs! We are
                    India's fastest-growing online fitness store, offering premium quality gym equipment, authentic
                    supplements, stylish gym wear, and fitness accessories.</p>
                <p>Since our launch, we have served over <strong>10,000+ satisfied customers</strong> across India with fast
                    delivery and 100% authentic products.</p>
                <p>Whether you're a fitness enthusiast, a professional athlete, or a gym owner, we have everything you need
                    to achieve your fitness goals.</p>
                <a href="/shop" class="btn-shop-now mt-3">
                    <i class="fas fa-shopping-cart"></i> Start Shopping
                </a>
            </div>
        </div>
    </div>

    <!-- ===== CATEGORY SECTION ===== -->
    <div class="container shop-section" style="background: #f8f6f2; padding: 50px 30px; border-radius: 18px; margin-bottom: 30px;">
        <div class="shop-section-header text-center">
            <span class="section-eyebrow d-block">Browse the Range</span>
            <h2 class="section-heading mb-2" style="font-size: 2rem;">Shop by Category</h2>
            <div class="energy-stripe mx-auto"></div>
        </div>
        <div class="row category-row" id="categoryContainer"></div>
    </div>

    <!-- ===== PRODUCTS SECTION ===== -->
    <div class="container shop-section" style="padding-bottom: 24px;">
        <div class="shop-section-header d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="section-eyebrow d-block">Handpicked For You</span>
                <h2 class="section-heading" style="font-size: 2rem;">Best Selling Products</h2>
            </div>
            <a href="/shop" class="view-all-link">View All &rarr;</a>
        </div>

        <div id="productsLoader" class="loader" style="display: none;">
            <i class="fas fa-spinner"></i>
            <p>Loading products...</p>
        </div>

        <div class="row" id="productsContainer"></div>
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
            document.getElementById('customAlertOverlay').classList.remove('show');
        }

        document.getElementById('customAlertOverlay').addEventListener('click', function(e) {
            if (e.target === this) closeCustomAlert();
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
        // ===== BANNER LOADING =====
        // ================================================================
        let bannerLoaded = false;

        async function loadBanners() {
            try {
                const response = await fetch('/api/banners');
                const banners = await response.json();
                const bannerContainer = document.getElementById('bannerContainer');
                if (!bannerContainer) return;

                if (!banners || banners.length === 0) {
                    bannerContainer.innerHTML = `
                        <div class="carousel-item active">
                            <div class="banner-placeholder" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <i class="fas fa-image"></i>
                                <span>No Banners Available</span>
                            </div>
                        </div>
                    `;
                    return;
                }

                let bannerHtml = '';
                banners.forEach((banner, index) => {
                    const isActive = index === 0 ? 'active' : '';
                    const imageUrl = banner.image_url || '';

                    bannerHtml += `
                        <div class="carousel-item ${isActive}">
                            ${banner.link ? `<a href="${banner.link}" target="_self" style="display:block;width:100%;height:500px;">` : ''}
                            <img src="${imageUrl}"
                                 alt="Banner"
                                 style="display:block;width:100%;height:500px;object-fit:fill;">
                            ${banner.link ? `</a>` : ''}
                        </div>
                    `;
                });

                bannerContainer.innerHTML = bannerHtml;

                const carouselElement = document.getElementById('bannerSlider');
                if (carouselElement) {
                    const existingInstance = bootstrap.Carousel.getInstance(carouselElement);
                    if (existingInstance) existingInstance.dispose();
                    new bootstrap.Carousel(carouselElement, {
                        interval: 5000,
                        pause: 'hover',
                        wrap: true,
                        touch: true,
                        ride: 'carousel'
                    });
                }

                bannerLoaded = true;

            } catch (error) {
                console.error('Error loading banners:', error);
                const bannerContainer = document.getElementById('bannerContainer');
                if (bannerContainer) {
                    bannerContainer.innerHTML = `
                        <div class="carousel-item active">
                            <div class="banner-placeholder" style="background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%);">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>Failed to load banners</span>
                            </div>
                        </div>
                    `;
                }
            }
        }

        // ================================================================
        // ===== WISHLIST FUNCTIONS =====
        // ================================================================
        let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        function updateWishlistCount() {
            let count = wishlist.length;
            let wishlistCountElement = document.getElementById('navbarWishlistCount');
            if (wishlistCountElement) {
                if (count > 0) {
                    wishlistCountElement.textContent = count;
                    wishlistCountElement.classList.remove('hide-badge');
                } else {
                    wishlistCountElement.classList.add('hide-badge');
                }
            }
        }

        function updateCartCount() {
            let count = cart.reduce((total, item) => total + item.quantity, 0);
            let cartCountElement = document.getElementById('navbarCartCount');
            if (cartCountElement) {
                if (count > 0) {
                    cartCountElement.textContent = count;
                    cartCountElement.classList.remove('hide-badge');
                } else {
                    cartCountElement.classList.add('hide-badge');
                }
            }
        }

        function loadWishlistStatus() {
            wishlist.forEach(item => {
                const icon = document.getElementById(`wishlist-icon-${item.id}`);
                if (icon) icon.className = 'fas fa-heart';
            });
        }

        function toggleWishlist(id, name, price, image) {
            @if (!auth()->check())
                showLoginRequiredAlert();
                return;
            @endif

            let currentWishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
            const existingIndex = currentWishlist.findIndex(item => item.id === id);
            const icon = document.getElementById(`wishlist-icon-${id}`);

            if (existingIndex !== -1) {
                currentWishlist.splice(existingIndex, 1);
                if (icon) icon.className = 'far fa-heart';
                showCustomToast('💔 Removed', 'Item removed from wishlist!', 'info');
            } else {
                currentWishlist.push({
                    id: id,
                    name: name,
                    price: price,
                    image: image,
                    added_at: new Date().toISOString()
                });
                if (icon) icon.className = 'fas fa-heart';
                showCustomToast('❤️ Added', 'Item added to wishlist!', 'success');
            }

            localStorage.setItem('wishlist', JSON.stringify(currentWishlist));
            wishlist = currentWishlist;
            updateWishlistCount();
        }

        // ================================================================
        // ===== PRODUCT NAVIGATION FUNCTIONS =====
        // ================================================================

        function goToProductDetail(productId, event) {
            if (event && (event.target.closest('.wishlist-btn') ||
                    event.target.closest('.btn-view-product') ||
                    event.target.closest('.btn-add-cart-home'))) {
                return;
            }
            window.location.href = `/product/${productId}`;
        }

        function goToProductDetailFromView(productId, event) {
            event.stopPropagation();
            window.location.href = `/product/${productId}`;
        }

        // ================================================================
        // ===== QUICK ADD TO CART MODAL (For Variant Products) =====
        // ================================================================

        let modalProductData = null;
        let modalSelectedColor = null;
        let modalSelectedSize = null;
        let modalSelectedVariant = null;
        let modalAllVariants = [];
        let modalProductId = null;

        function openQuickCartModal(productData) {
            modalProductData = productData;
            modalAllVariants = productData.variants || [];
            modalProductId = productData.id;
            modalSelectedColor = null;
            modalSelectedSize = null;
            modalSelectedVariant = null;

            // Set product info
            document.getElementById('modalProductImage').src = productData.image;
            document.getElementById('modalProductBrand').textContent = productData.brand || '';
            document.getElementById('modalProductName').textContent = productData.name;

            // Set View Details link
            document.getElementById('modalViewDetailsLink').href = `/product/${productData.id}`;

            // Check if product has variants
            if (modalAllVariants.length > 0) {
                document.getElementById('modalVariantSection').style.display = 'block';

                // Populate colors
                const colorSet = new Set();
                modalAllVariants.forEach(v => {
                    if (v.color && v.color.trim() !== '') colorSet.add(v.color);
                });
                const colors = Array.from(colorSet);

                const colorContainer = document.getElementById('modalColorOptions');
                if (colors.length > 0) {
                    document.getElementById('modalColorSection').style.display = 'block';
                    colorContainer.innerHTML = '';
                    colors.forEach((color, index) => {
                        const isLightColor = ['white', 'yellow', 'pink', 'lightblue', 'lightgreen', 'cream',
                            'beige', 'ivory', 'gold'
                        ].includes(color.toLowerCase());
                        const btn = document.createElement('div');
                        btn.className = 'modal-color-btn' + (index === 0 ? ' selected' : '');
                        btn.dataset.color = color;
                        btn.style.background = color;
                        if (isLightColor) btn.style.border = '3px solid #ddd';
                        btn.innerHTML = `<span class="check-mark"><i class="fas fa-check"></i></span>`;
                        btn.onclick = function() {
                            document.querySelectorAll('.modal-color-btn').forEach(b => b.classList.remove(
                            'selected'));
                            this.classList.add('selected');
                            modalSelectedColor = color;
                            updateModalSizes(color);
                            updateModalPrice(color);
                        };
                        colorContainer.appendChild(btn);
                    });

                    // Select first color
                    modalSelectedColor = colors[0];
                    updateModalSizes(colors[0]);
                    updateModalPrice(colors[0]);
                } else {
                    document.getElementById('modalColorSection').style.display = 'none';
                    updateModalSizes(null);
                    updateModalPrice(null);
                }

            } else {
                document.getElementById('modalVariantSection').style.display = 'none';
                modalSelectedVariant = null;
                // Set price for non-variant product
                updateModalPriceDisplay(productData.price, productData.original_price);
                updateModalStockInfo(null);
            }

            // Reset quantity
            document.getElementById('modalQtyInput').value = 1;
            document.getElementById('modalErrorMsg').style.display = 'none';

            // Show modal
            document.getElementById('quickCartModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function updateModalPrice(color) {
            let filteredVariants = modalAllVariants;
            if (color) {
                filteredVariants = modalAllVariants.filter(v => v.color === color);
            }

            // Get first available variant's price
            const firstVariant = filteredVariants.find(v => v.stock > 0) || filteredVariants[0];
            if (firstVariant) {
                updateModalPriceDisplay(firstVariant.price, firstVariant.original_price);
            } else {
                updateModalPriceDisplay(modalProductData.price, modalProductData.original_price);
            }
        }

        function updateModalPriceDisplay(price, originalPrice) {
            document.getElementById('modalProductPrice').textContent = '₹' + Number(price).toFixed(2);
            const oldPriceEl = document.getElementById('modalProductOldPrice');
            if (originalPrice && originalPrice > price) {
                oldPriceEl.textContent = '₹' + Number(originalPrice).toFixed(2);
                oldPriceEl.style.display = 'inline';
            } else {
                oldPriceEl.style.display = 'none';
            }
        }

        function updateModalSizes(color) {
            const sizeContainer = document.getElementById('modalSizeOptions');
            let filteredVariants = modalAllVariants;

            if (color) {
                filteredVariants = modalAllVariants.filter(v => v.color === color);
            }

            const sizes = filteredVariants.map(v => v.size).filter(s => s && s.trim() !== '');

            if (sizes.length > 0) {
                document.getElementById('modalSizeSection').style.display = 'block';
                sizeContainer.innerHTML = '';
                sizes.forEach((size, index) => {
                    const variant = filteredVariants.find(v => v.size === size);
                    const isOutOfStock = (variant && variant.stock <= 0) || false;

                    const btn = document.createElement('button');
                    btn.className = 'modal-size-btn' + (index === 0 && !isOutOfStock ? ' selected' : '') + (isOutOfStock ?
                        ' out-of-stock' : '');
                    btn.dataset.size = size;
                    btn.dataset.variantId = variant ? variant.id : null;
                    btn.dataset.stock = variant ? variant.stock : 0;
                    btn.dataset.price = variant ? variant.price : modalProductData.price;
                    btn.dataset.originalPrice = variant ? variant.original_price : modalProductData.original_price;
                    btn.textContent = size;
                    btn.disabled = isOutOfStock;

                    btn.onclick = function() {
                        if (this.disabled) return;
                        document.querySelectorAll('.modal-size-btn').forEach(b => b.classList.remove(
                        'selected'));
                        this.classList.add('selected');
                        modalSelectedSize = this.dataset.size;
                        const vid = this.dataset.variantId;
                        modalSelectedVariant = modalAllVariants.find(v => v.id == vid) || null;
                        // Update price when size is selected
                        if (modalSelectedVariant) {
                            updateModalPriceDisplay(modalSelectedVariant.price, modalSelectedVariant
                            .original_price);
                        }
                        updateModalStockInfo(modalSelectedVariant);
                        document.getElementById('modalErrorMsg').style.display = 'none';
                    };

                    sizeContainer.appendChild(btn);
                });

                // Select first available size
                const firstSizeBtn = sizeContainer.querySelector('.modal-size-btn:not(.out-of-stock)');
                if (firstSizeBtn) {
                    firstSizeBtn.click();
                } else {
                    modalSelectedSize = null;
                    modalSelectedVariant = null;
                    updateModalStockInfo(null);
                }
            } else {
                document.getElementById('modalSizeSection').style.display = 'none';
                modalSelectedSize = null;
                modalSelectedVariant = null;
                // If no sizes, update price from first variant
                const firstVariant = filteredVariants.find(v => v.stock > 0) || filteredVariants[0];
                if (firstVariant) {
                    updateModalPriceDisplay(firstVariant.price, firstVariant.original_price);
                }
                updateModalStockInfo(null);
            }
        }

        function updateModalStockInfo(variant) {
            const stockInfo = document.getElementById('modalStockInfo');
            const stockText = document.getElementById('modalStockText');

            if (variant && variant.stock > 0) {
                if (variant.stock <= 5) {
                    stockText.className = 'low-stock-text';
                    stockText.textContent = '⚠️ Only ' + variant.stock + ' left in stock!';
                } else {
                    stockText.className = 'in-stock-text';
                    stockText.textContent = '✅ In Stock';
                }
                stockInfo.style.display = 'block';
            } else if (modalAllVariants.length === 0) {
                // No variants - check product stock
                if (modalProductData.stock > 0) {
                    if (modalProductData.stock <= 5) {
                        stockText.className = 'low-stock-text';
                        stockText.textContent = '⚠️ Only ' + modalProductData.stock + ' left in stock!';
                    } else {
                        stockText.className = 'in-stock-text';
                        stockText.textContent = '✅ In Stock';
                    }
                    stockInfo.style.display = 'block';
                } else {
                    stockText.className = 'low-stock-text';
                    stockText.textContent = '❌ Out of Stock';
                    stockInfo.style.display = 'block';
                }
            } else {
                // Check if any variant has stock
                const hasStock = modalAllVariants.some(v => v.stock > 0);
                if (hasStock) {
                    stockText.className = 'in-stock-text';
                    stockText.textContent = '✅ In Stock';
                    stockInfo.style.display = 'block';
                } else {
                    stockText.className = 'low-stock-text';
                    stockText.textContent = '❌ Out of Stock';
                    stockInfo.style.display = 'block';
                }
            }

            // Enable/disable add to cart button
            const addBtn = document.getElementById('modalAddToCartBtn');
            const hasStock = (variant && variant.stock > 0) || (modalAllVariants.length === 0 && modalProductData.stock > 0) ||
                (modalAllVariants.length > 0 && modalAllVariants.some(v => v.stock > 0));
            addBtn.disabled = !hasStock;
        }

        function modalIncrementQty() {
            const input = document.getElementById('modalQtyInput');
            let max = 10;
            if (modalSelectedVariant && modalSelectedVariant.stock) {
                max = modalSelectedVariant.stock;
            } else if (modalProductData && modalProductData.stock) {
                max = modalProductData.stock;
            }
            let val = parseInt(input.value) + 1;
            if (val <= max) input.value = val;
        }

        function modalDecrementQty() {
            const input = document.getElementById('modalQtyInput');
            let val = parseInt(input.value) - 1;
            if (val >= 1) input.value = val;
        }

        function modalAddToCart() {
            const errorMsg = document.getElementById('modalErrorMsg');

            // For variant products, validate selection
            if (modalAllVariants.length > 0) {
                if (!modalSelectedSize) {
                    errorMsg.textContent = 'Please select a size';
                    errorMsg.style.display = 'block';
                    return;
                }
                if (!modalSelectedVariant) {
                    errorMsg.textContent = 'Selected variant is not available';
                    errorMsg.style.display = 'block';
                    return;
                }
                if (modalSelectedVariant.stock <= 0) {
                    errorMsg.textContent = 'Selected size is out of stock!';
                    errorMsg.style.display = 'block';
                    return;
                }
            }

            errorMsg.style.display = 'none';

            const quantity = parseInt(document.getElementById('modalQtyInput').value);

            // Get the product details
            const productId = modalProductData.id;
            const productName = modalProductData.name;
            const price = modalSelectedVariant ? modalSelectedVariant.price : modalProductData.price;
            const image = modalProductData.image;
            const variantId = modalSelectedVariant ? modalSelectedVariant.id : null;
            const size = modalSelectedSize || null;
            const color = modalSelectedColor || null;

            // Check stock for variant
            if (modalSelectedVariant && quantity > modalSelectedVariant.stock) {
                errorMsg.textContent = 'Only ' + modalSelectedVariant.stock + ' items available!';
                errorMsg.style.display = 'block';
                return;
            }

            // Add to cart
            let currentCart = JSON.parse(localStorage.getItem('cart')) || [];

            let existingItem = currentCart.find(item =>
                item.id === productId &&
                item.variant_id === variantId &&
                item.size === size &&
                item.color === color
            );

            if (existingItem) {
                const maxStock = modalSelectedVariant ? modalSelectedVariant.stock : 999;
                if (existingItem.quantity + quantity > maxStock) {
                    errorMsg.textContent = 'Only ' + maxStock + ' items available!';
                    errorMsg.style.display = 'block';
                    return;
                }
                existingItem.quantity += quantity;
            } else {
                currentCart.push({
                    id: productId,
                    name: productName,
                    price: price,
                    original_price: modalProductData.original_price || price,
                    image: image,
                    quantity: quantity,
                    size: size,
                    color: color,
                    variant_id: variantId
                });
            }

            localStorage.setItem('cart', JSON.stringify(currentCart));
            cart = currentCart;
            updateCartCount();

            // Close modal
            closeQuickCartModal();

            // Show toast and redirect
            showCustomToast('🛒 Added', productName + ' added to cart!', 'success');

            setTimeout(() => {
                window.location.href = "{{ route('cart') }}";
            }, 500);
        }

        function closeQuickCartModal() {
            document.getElementById('quickCartModal').classList.remove('active');
            document.body.style.overflow = '';
            modalProductData = null;
            modalSelectedColor = null;
            modalSelectedSize = null;
            modalSelectedVariant = null;
            modalAllVariants = [];
            modalProductId = null;
        }

        // Close modal on overlay click
        document.getElementById('quickCartModal').addEventListener('click', function(e) {
            if (e.target === this) closeQuickCartModal();
        });

        // ===== VIEW FULL DETAILS FROM MODAL =====
        function goToModalProductDetail(event) {
            event.preventDefault();
            if (modalProductId) {
                window.location.href = `/product/${modalProductId}`;
            }
        }

        // ================================================================
        // ===== HANDLE CART BUTTON CLICK =====
        // ================================================================

        function handleAddToCart(product) {
            // Check if product has variants
            if (product.hasVariant && product.variants && product.variants.length > 0) {
                // Open modal for variant selection
                openQuickCartModal(product);
            } else {
                // Direct add for non-variant products
                addToCartDirect(
                    product.id,
                    product.name,
                    product.price,
                    product.image,
                    null,
                    null,
                    null
                );
            }
        }

        // ================================================================
        // ===== ADD TO CART DIRECT (Non-variant products) =====
        // ================================================================

        function addToCartDirect(productId, productName, price, image, variantId = null, size = null, color = null) {
            event.stopPropagation();

            let currentCart = JSON.parse(localStorage.getItem('cart')) || [];

            let existingItem = currentCart.find(item =>
                item.id === productId &&
                item.variant_id === variantId &&
                item.size === size &&
                item.color === color
            );

            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                currentCart.push({
                    id: productId,
                    name: productName,
                    price: price,
                    image: image,
                    quantity: 1,
                    size: size || null,
                    color: color || null,
                    variant_id: variantId || null
                });
            }

            localStorage.setItem('cart', JSON.stringify(currentCart));
            cart = currentCart;
            updateCartCount();

            showCustomToast('🛒 Added', productName + ' added to cart!', 'success');

            setTimeout(() => {
                window.location.href = "{{ route('cart') }}";
            }, 500);
        }

        // ================================================================
        // ===== CUSTOM TOAST NOTIFICATION =====
        // ================================================================

        function showCustomToast(title, message, type = 'info') {
            if (typeof showNotification === 'function') {
                showNotification(message, type);
            } else {
                let notification = document.createElement('div');
                notification.className = 'custom-toast';
                notification.style.position = 'fixed';
                notification.style.top = '80px';
                notification.style.right = '20px';
                notification.style.zIndex = '99999';
                notification.style.minWidth = '280px';
                notification.style.maxWidth = '400px';
                notification.style.padding = '14px 20px';
                notification.style.borderRadius = '12px';
                notification.style.boxShadow = '0 10px 40px rgba(0,0,0,0.15)';
                notification.style.fontFamily = "'Plus Jakarta Sans', sans-serif";
                notification.style.fontWeight = '600';
                notification.style.fontSize = '14px';
                notification.style.background = type === 'success' ? '#16A34A' : type === 'error' ? '#FF4405' :
                '#2563EB';
                notification.style.color = 'white';
                notification.style.display = 'flex';
                notification.style.alignItems = 'center';
                notification.style.gap = '10px';
                notification.style.animation = 'slideInNotif 0.3s ease';

                const icon = type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' :
                    'fa-info-circle';
                notification.innerHTML = `<i class="fas ${icon}"></i> <span><strong>${title}</strong><br>${message}</span>`;

                document.body.appendChild(notification);
                setTimeout(() => {
                    notification.style.opacity = '0';
                    notification.style.transition = 'opacity 0.3s ease';
                    setTimeout(() => notification.remove(), 300);
                }, 2500);
            }
        }

        function goToCategoryProducts(categoryId, categoryName) {
            window.location.href = `/shop?category=${categoryId}&name=${encodeURIComponent(categoryName)}`;
        }

        // ================================================================
        // ===== LOAD CATEGORIES =====
        // ================================================================

        async function loadCategories() {
            try {
                const response = await fetch('/api/categories');
                const categories = await response.json();
                const categoryContainer = document.getElementById('categoryContainer');
                if (!categoryContainer) return;

                if (categories.length === 0) {
                    categoryContainer.innerHTML = '<div class="col-12 text-center">No categories found</div>';
                    return;
                }

                categoryContainer.innerHTML = categories.map(cat => `
                    <div class="col-md-4 col-sm-6 mb-4">
                        <div class="category-card" onclick="goToCategoryProducts(${cat.id}, '${cat.name.replace(/'/g, "\\'")}')">
                            <div class="category-image-wrapper">
                                ${cat.image ? 
                                    `<img src="/storage/${cat.image}" alt="${cat.name}" loading="lazy">` : 
                                    `<div class="category-icon-wrapper"><i class="fas fa-tag"></i></div>`
                                }
                            </div>
                            <div class="category-info">
                                <h5>${cat.name}</h5>
                                <p>View Products <i class="fas fa-arrow-right ms-1"></i></p>
                            </div>
                        </div>
                    </div>
                `).join('');

            } catch (error) {
                console.error('Error loading categories:', error);
            }
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

            if (images.length === 0 && product.product_images && product.product_images.length > 0) {
                const normalImages = product.product_images.filter(img => !img.variant_id || img.variant_id === null || img
                    .variant_id === 0);
                if (normalImages.length > 0) {
                    const sortedImages = [...normalImages].sort((a, b) => {
                        if (a.is_main !== b.is_main) return b.is_main - a.is_main;
                        return (a.display_order || 0) - (b.display_order || 0);
                    });
                    images = sortedImages.map(img => '/storage/' + img.image_path);
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
                const colors = ['#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7', '#DDA0DD', '#FF8A5C', '#A29BFE'];
                const colorIndex = (product.id || 1) % colors.length;
                const bgColor = colors[colorIndex];
                const text = product.name ? product.name.substring(0, 2).toUpperCase() : '?';

                const svg = `<svg xmlns="http://www.w3.org/2000/svg" width="300" height="300" viewBox="0 0 300 300">
                        <rect width="300" height="300" fill="${bgColor}" opacity="0.3"/>
                        <rect x="50" y="50" width="200" height="200" fill="${bgColor}" rx="10"/>
                        <text x="150" y="175" font-family="Arial" font-size="80" fill="${bgColor}" text-anchor="middle" dominant-baseline="central">${text}</text>
                        <text x="150" y="250" font-family="Arial" font-size="14" fill="#999" text-anchor="middle">${product.name || 'Product'}</text>
                    </svg>`;

                const encoded = btoa(svg);
                images.push(`data:image/svg+xml;base64,${encoded}`);
            }

            return images;
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
                    const colors = ['#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7', '#DDA0DD', '#FF8A5C', '#A29BFE'];
                    const colorIndex = (product.id || 1) % colors.length;
                    const bgColor = colors[colorIndex];
                    const text = product.name ? product.name.substring(0, 2).toUpperCase() : '?';
                    const svg = `<svg xmlns="http://www.w3.org/2000/svg" width="300" height="300" viewBox="0 0 300 300">
                            <rect width="300" height="300" fill="${bgColor}" opacity="0.3"/>
                            <rect x="50" y="50" width="200" height="200" fill="${bgColor}" rx="10"/>
                            <text x="150" y="175" font-family="Arial" font-size="80" fill="${bgColor}" text-anchor="middle" dominant-baseline="central">${text}</text>
                            <text x="150" y="250" font-family="Arial" font-size="14" fill="#999" text-anchor="middle">${product.name || 'Product'}</text>
                        </svg>`;
                    const encoded = btoa(svg);
                    variantImages.push(`data:image/svg+xml;base64,${encoded}`);
                }

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

                let totalStock = 0;
                product.variants.forEach(v => {
                    totalStock += parseInt(v.stock) || 0;
                });

                const originalPrice = parseFloat(firstVariant.total_price) || parseFloat(firstVariant.mrp) || parseFloat(
                    firstVariant.price) || 0;
                const displayPrice = parseFloat(firstVariant.final_price) || parseFloat(firstVariant.price) || 0;

                // Build variants array for modal
                const variantsForModal = product.variants.map(v => ({
                    id: v.id,
                    size: v.size || null,
                    color: v.color || null,
                    price: parseFloat(v.final_price) || parseFloat(v.price) || 0,
                    original_price: parseFloat(v.total_price) || parseFloat(v.mrp) || parseFloat(v.price) || 0,
                    stock: parseInt(v.stock) || 0,
                    discount_type: v.discount_type || 'flat',
                    discount_value: parseFloat(v.discount_value) || 0
                }));

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
                    colors: colors,
                    variantCount: product.variants.length,
                    firstVariantSize: firstVariant.size || null,
                    firstVariantColor: firstVariant.color || null,
                    variants: variantsForModal
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
                colors: [],
                variantCount: 0,
                firstVariantSize: null,
                firstVariantColor: null,
                variants: []
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
            const loader = document.getElementById('productsLoader');
            const container = document.getElementById('productsContainer');
            if (loader) loader.style.display = 'block';

            try {
                const response = await fetch('/api/products');
                const products = await response.json();

                if (loader) loader.style.display = 'none';

                const allProducts = products.sort((a, b) => {
                    return (b.id || 0) - (a.id || 0);
                });

                if (allProducts.length === 0) {
                    container.innerHTML =
                        '<div class="col-12"><div class="no-products">No products available</div></div>';
                    return;
                }

                container.innerHTML = allProducts.map(product => {
                    const variantData = getVariantData(product);

                    let imageUrls = [];
                    if (variantData.hasVariant && variantData.allImages.length > 0) {
                        imageUrls = variantData.allImages;
                    } else {
                        imageUrls = getProductImages(product);
                    }

                    const firstImage = imageUrls.length > 0 ? imageUrls[0] :
                        'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMDAiIGhlaWdodD0iMzAwIiB2aWV3Qm94PSIwIDAgMzAwIDMwMCI+PHJlY3Qgd2lkdGg9IjMwMCIgaGVpZ2h0PSIzMDAiIGZpbGw9IiNmMGYwZjAiLz48dGV4dCB4PSIxNTAiIHk9IjE1MCIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjUwIiBmaWxsPSIjY2NjIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBkb21pbmFudC1iYXNlbGluZT0iY2VudHJhbCI+Tm8gSW1hZ2U8L3RleHQ+PC9zdmc+';

                    const totalStock = variantData.totalStock || parseInt(product.stock) || 0;

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

                    const isInWishlist = wishlist.some(item => item.id === product.id);
                    const heartClass = isInWishlist ? 'fas fa-heart' : 'far fa-heart';
                    const escapeName = product.name.replace(/'/g, "\\'");

                    let brandName = '';
                    if (product.brand) {
                        brandName = product.brand.name || '';
                    } else if (product.brand_name) {
                        brandName = product.brand_name;
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

                    let brandHtml = '';
                    if (brandName) {
                        brandHtml = `
                            <div class="product-brand">
                                <i class="fas fa-tag"></i>
                                ${brandName}
                            </div>
                        `;
                    }

                    const firstVariantId = variantData.variantId;
                    const firstVariantSize = variantData.firstVariantSize;
                    const firstVariantColor = variantData.firstVariantColor;
                    const isInStock = totalStock > 0;

                    // Build product data object for modal
                    const productDataForModal = {
                        id: product.id,
                        name: product.name,
                        price: displayPrice,
                        original_price: originalPrice,
                        image: firstImage,
                        brand: brandName,
                        stock: totalStock,
                        hasVariant: variantData.hasVariant,
                        variants: variantData.variants
                    };

                    return `
                        <div class="col-md-3 col-sm-6 mb-4">
                            <div class="product-card card" onclick="goToProductDetail(${product.id}, event)">
                                <button class="wishlist-btn" onclick="event.stopPropagation(); toggleWishlist(${product.id}, '${escapeName}', ${displayPrice}, '${firstImage}')">
                                    <i class="${heartClass}" id="wishlist-icon-${product.id}"></i>
                                </button>
                                
                                <div class="product-image-container">
                                    <img src="${firstImage}" alt="${product.name}" 
                                        onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMDAiIGhlaWdodD0iMzAwIiB2aWV3Qm94PSIwIDAgMzAwIDMwMCI+PHJlY3Qgd2lkdGg9IjMwMCIgaGVpZ2h0PSIzMDAiIGZpbGw9IiNmMGYwZjAiLz48dGV4dCB4PSIxNTAiIHk9IjE1MCIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjQwIiBmaWxsPSIjY2NjIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBkb21pbmFudC1iYXNlbGluZT0iY2VudHJhbCI+TG9hZCBFcnJvcjwvdGV4dD48L3N2Zz4='"
                                        loading="lazy">
                                </div>
                                
                                <div class="card-body">
                                    ${brandHtml}
                                    <div class="product-name">${product.name}</div>
                                    ${priceHtml}
                                    ${colorHtml}
                                    ${stockHtml}
                                    
                                    <div class="button-spacer"></div>
                                    
                                    <div class="product-action-buttons">
                                        <button class="btn-view-product" onclick="goToProductDetailFromView(${product.id}, event)">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                        <button class="btn-add-cart-home" 
                                            onclick="event.stopPropagation(); handleAddToCart(${JSON.stringify(productDataForModal).replace(/"/g, '&quot;')})"
                                            ${!isInStock ? 'disabled' : ''}>
                                            <i class="fas fa-shopping-cart"></i> Cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                }).join('');

                loadWishlistStatus();

            } catch (error) {
                console.error('Error loading products:', error);
                if (loader) loader.style.display = 'none';
                container.innerHTML =
                    '<div class="col-12"><div class="no-products text-danger">Error loading products. Please try again.</div></div>';
            }
        }

        // ================================================================
        // ===== INITIALIZE =====
        // ================================================================

        document.addEventListener('DOMContentLoaded', function() {
            wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
            cart = JSON.parse(localStorage.getItem('cart')) || [];

            loadBanners();
            loadCategories();
            loadProducts();

            updateCartCount();
            updateWishlistCount();
        });

        document.addEventListener('visibilitychange', function() {
            if (!document.hidden && !bannerLoaded) {
                loadBanners();
            }
        });
    </script>
@endsection