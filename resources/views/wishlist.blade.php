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
            --shadow-card: 0 1px 2px rgba(20,22,26,0.04), 0 8px 24px rgba(20,22,26,0.06);
            --shadow-card-hover: 0 18px 40px rgba(20,22,26,0.14);
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

        /* Signature element: a repeating diagonal "energy stripe" */
        .energy-stripe {
            height: 4px;
            width: 56px;
            border-radius: 3px;
            background: repeating-linear-gradient(
                -45deg,
                var(--signal) 0px,
                var(--signal) 6px,
                var(--ink) 6px,
                var(--ink) 12px
            );
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

        /* ===== WISHLIST HEADER ===== */
        .wishlist-header {
            padding: 30px 0 20px 0;
            border-bottom: 1px solid var(--line);
            margin-bottom: 30px;
        }

        .wishlist-header h2 {
            font-family: var(--font-display);
            font-weight: 400;
            font-size: 28px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            color: var(--ink);
        }

        .wishlist-header h2 i {
            color: var(--signal);
            margin-right: 10px;
        }

        .wishlist-header p {
            color: var(--steel);
            font-size: 15px;
            font-weight: 500;
            margin-top: 5px;
        }

        /* ===== PRODUCT CARD - SAME AS HOME PAGE ===== */
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

        /* Remove from wishlist button */
        .remove-wishlist-btn {
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
            color: var(--signal);
        }

        .remove-wishlist-btn i {
            font-size: 1rem;
            transition: all 0.25s;
        }

        .remove-wishlist-btn:hover {
            transform: scale(1.1);
            background: var(--signal);
            color: white;
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

        /* ===== PRODUCT BRAND - SAME AS HOME ===== */
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

        /* Price container */
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

        /* ===== COLOR OPTIONS - WITH COLOR COUNT ===== */
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

        /* ===== EMPTY WISHLIST ===== */
        .empty-wishlist {
            text-align: center;
            padding: 80px 20px;
        }

        .empty-wishlist i {
            font-size: 4rem;
            color: var(--steel);
            margin-bottom: 20px;
        }

        .empty-wishlist h4 {
            font-family: var(--font-display);
            font-weight: 400;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            color: var(--ink);
            margin-bottom: 10px;
        }

        .empty-wishlist p {
            color: var(--steel);
            font-weight: 500;
            margin-bottom: 20px;
        }

        .btn-shop-now {
            background: var(--signal);
            color: white;
            border: none;
            border-radius: 25px;
            padding: 10px 30px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            font-family: var(--font-body);
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .btn-shop-now:hover {
            background: var(--signal-dark);
            color: white;
            transform: scale(1.02);
        }

        /* ===== CUSTOM CONFIRMATION NOTIFICATION ===== */
        .confirm-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 99999;
            min-width: 320px;
            max-width: 400px;
            background: white;
            border-radius: var(--radius-md);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            padding: 20px 25px;
            animation: slideInRight 0.3s ease;
            border-left: 5px solid var(--signal);
            font-family: var(--font-body);
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .confirm-notification .notif-icon {
            width: 45px;
            height: 45px;
            background: var(--signal);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .confirm-notification .notif-content {
            flex: 1;
        }

        .confirm-notification .notif-title {
            font-weight: 700;
            color: var(--ink);
            font-size: 15px;
            margin-bottom: 2px;
        }

        .confirm-notification .notif-message {
            font-size: 13px;
            color: var(--steel);
            font-weight: 500;
        }

        .confirm-notification .notif-actions {
            display: flex;
            gap: 8px;
            margin-top: 12px;
        }

        .confirm-notification .btn-notif-confirm {
            background: var(--signal);
            color: white;
            border: none;
            border-radius: 20px;
            padding: 6px 20px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            font-family: var(--font-body);
        }

        .confirm-notification .btn-notif-confirm:hover {
            background: var(--signal-dark);
        }

        .confirm-notification .btn-notif-cancel {
            background: var(--fog);
            color: var(--steel);
            border: none;
            border-radius: 20px;
            padding: 6px 20px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            font-family: var(--font-body);
        }

        .confirm-notification .btn-notif-cancel:hover {
            background: var(--line);
            color: var(--ink);
        }

        .confirm-notification .notif-close {
            position: absolute;
            top: 10px;
            right: 15px;
            background: none;
            border: none;
            font-size: 18px;
            color: var(--steel);
            cursor: pointer;
            transition: all 0.3s;
        }

        .confirm-notification .notif-close:hover {
            color: var(--signal);
        }

        /* ===== TOAST NOTIFICATION ===== */
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

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
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

        .quick-cart-modal .modal-view-details-link {
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

        .quick-cart-modal .modal-view-details-link:hover {
            color: var(--signal);
            text-decoration: underline;
        }

        .quick-cart-modal .modal-view-details-link i {
            margin-right: 6px;
            font-size: 0.7rem;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .wishlist-header h2 {
                font-size: 22px;
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

            .product-action-buttons {
                flex-direction: row;
            }

            .product-action-buttons .btn-view-product,
            .product-action-buttons .btn-add-cart-home {
                padding: 4px 12px;
                font-size: 0.65rem;
            }

            .confirm-notification {
                min-width: 280px;
                max-width: 90%;
                right: 10px;
                top: 10px;
                padding: 15px 20px;
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

        @media (max-width: 576px) {
            .product-image-container {
                height: 160px;
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

            .remove-wishlist-btn {
                width: 28px;
                height: 28px;
                top: 6px;
                left: 6px;
            }

            .remove-wishlist-btn i {
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

            .container {
                padding-left: 10px !important;
                padding-right: 10px !important;
            }

            .section-heading {
                font-size: 1.3rem !important;
            }

            .confirm-notification {
                min-width: auto;
                width: 90%;
                right: 5%;
                top: 10px;
                padding: 15px;
            }

            .confirm-notification .notif-actions {
                flex-direction: column;
            }

            .confirm-notification .btn-notif-confirm,
            .confirm-notification .btn-notif-cancel {
                width: 100%;
                text-align: center;
            }

            .empty-wishlist {
                padding: 50px 15px;
            }

            .empty-wishlist i {
                font-size: 3rem;
            }

            .empty-wishlist h4 {
                font-size: 1.1rem;
            }

            .empty-wishlist p {
                font-size: 0.85rem;
            }

            .btn-shop-now {
                font-size: 0.8rem;
                padding: 8px 20px;
            }

            .custom-toast {
                top: 15px;
                right: 15px;
                font-size: 13px;
                padding: 12px 18px;
                max-width: 90%;
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

            .wishlist-header h2 {
                font-size: 18px;
            }

            .wishlist-header p {
                font-size: 13px;
            }
        }
    </style>

    <div class="container">
        <!-- Wishlist Header -->
        <div class="wishlist-header">
            <span class="section-eyebrow">Saved Items</span>
            <h2><i class="fas fa-heart"></i> My Wishlist</h2>
            <div class="energy-stripe" style="margin-top: 8px;"></div>
            <p class="mt-2">Products you've saved for later</p>
        </div>

        <!-- Wishlist Products Container -->
        <div id="wishlistContainer" class="row"></div>

        <!-- Empty Wishlist Message -->
        <div id="emptyWishlist" class="empty-wishlist" style="display: none;">
            <i class="fas fa-heart-broken"></i>
            <h4>Your wishlist is empty</h4>
            <p>Start adding items to your wishlist by clicking the heart icon on products.</p>
            <a href="{{ url('/') }}" class="btn-shop-now">Continue Shopping</a>
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

    <script>
        // ================================================================
        // ===== WISHLIST DATA =====
        // ================================================================
        let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let pendingRemoveId = null;
        let pendingRemoveName = '';

        // ================================================================
        // ===== MODAL VARIABLES =====
        // ================================================================
        let modalProductData = null;
        let modalSelectedColor = null;
        let modalSelectedSize = null;
        let modalSelectedVariant = null;
        let modalAllVariants = [];
        let modalProductId = null;

        // ================================================================
        // ===== TOAST NOTIFICATION =====
        // ================================================================
        function showToast(message, type = 'info') {
            const toast = document.getElementById('customToast');
            if (!toast) {
                const fallback = document.createElement('div');
                fallback.className = 'custom-toast show';
                fallback.style.cssText =
                    'position:fixed;top:25px;right:25px;background:var(--signal);color:#fff;padding:15px 22px;border-radius:var(--radius-md);box-shadow:0 10px 25px rgba(0,0,0,.2);display:flex;align-items:center;gap:10px;z-index:999999;font-weight:600;font-family:var(--font-body);';
                fallback.innerHTML = `<i class="fas fa-info-circle"></i> ${message}`;
                document.body.appendChild(fallback);
                setTimeout(() => {
                    fallback.style.opacity = '0';
                    fallback.style.transition = 'opacity 0.3s ease';
                    setTimeout(() => fallback.remove(), 300);
                }, 3000);
                return;
            }

            const icon = toast.querySelector('i');
            const msg = toast.querySelector('#toastMessage');
            if (icon) {
                icon.className = type === 'success' ? 'fas fa-check-circle' :
                    type === 'error' ? 'fas fa-exclamation-circle' : 'fas fa-info-circle';
            }
            if (msg) msg.textContent = message;
            toast.className = 'custom-toast show';
            if (type === 'error') {
                toast.style.background = 'var(--signal)';
            } else if (type === 'success') {
                toast.style.background = 'var(--success)';
            } else {
                toast.style.background = 'var(--info)';
            }

            clearTimeout(toast._timeout);
            toast._timeout = setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        // ================================================================
        // ===== CONFIRMATION NOTIFICATION =====
        // ================================================================
        function showConfirmNotification(id, name) {
            pendingRemoveId = id;
            pendingRemoveName = name;

            const existing = document.querySelector('.confirm-notification');
            if (existing) existing.remove();

            const notification = document.createElement('div');
            notification.className = 'confirm-notification';
            notification.id = 'confirmNotification';
            notification.innerHTML = `
                <button class="notif-close" onclick="closeConfirmNotification()">✕</button>
                <div style="display:flex; gap:15px; align-items:flex-start;">
                    <div class="notif-icon">
                        <i class="fas fa-trash-alt"></i>
                    </div>
                    <div class="notif-content">
                        <div class="notif-title">Remove from Wishlist?</div>
                        <div class="notif-message">Are you sure you want to remove "<strong>${escapeHtml(name)}</strong>" from your wishlist?</div>
                        <div class="notif-actions">
                            <button class="btn-notif-confirm" onclick="confirmRemove()">
                                <i class="fas fa-trash-alt me-1"></i> Remove
                            </button>
                            <button class="btn-notif-cancel" onclick="closeConfirmNotification()">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            `;

            document.body.appendChild(notification);

            setTimeout(() => {
                closeConfirmNotification();
            }, 10000);
        }

        function closeConfirmNotification() {
            const notification = document.getElementById('confirmNotification');
            if (notification) {
                notification.style.animation = 'slideInRight 0.3s ease reverse';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }
            pendingRemoveId = null;
            pendingRemoveName = '';
        }

        function confirmRemove() {
            if (pendingRemoveId !== null) {
                removeFromWishlist(pendingRemoveId);
                closeConfirmNotification();
            }
        }

        // ================================================================
        // ===== UPDATE COUNTS =====
        // ================================================================
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

        // ================================================================
        // ===== REMOVE FROM WISHLIST =====
        // ================================================================
        function removeFromWishlist(id) {
            wishlist = wishlist.filter(item => item.id !== id);
            localStorage.setItem('wishlist', JSON.stringify(wishlist));

            const heartIcon = document.getElementById(`wishlist-icon-${id}`);
            if (heartIcon) heartIcon.className = 'far fa-heart';

            loadWishlist();
            updateWishlistCount();
            showToast('Removed from wishlist', 'info');
        }

        // ================================================================
        // ===== OPEN REMOVE CONFIRMATION =====
        // ================================================================
        function openRemoveConfirm(id, name) {
            showConfirmNotification(id, name);
        }

        // ================================================================
        // ===== GO TO PRODUCT DETAIL =====
        // ================================================================
        function goToProductDetail(productId, event) {
            if (event && (event.target.closest('.remove-wishlist-btn') ||
                    event.target.closest('.btn-view-product') ||
                    event.target.closest('.btn-add-cart-home') ||
                    event.target.closest('.color-dot'))) {
                return;
            }
            window.location.href = `/product/${productId}`;
        }

        function goToProductDetailFromView(productId, event) {
            event.stopPropagation();
            window.location.href = `/product/${productId}`;
        }

        // ================================================================
        // ===== ESCAPE HTML =====
        // ================================================================
        function escapeHtml(text) {
            if (!text) return '';
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // ================================================================
        // ===== GET VARIANT DATA =====
        // ================================================================
        function getVariantData(product) {
            if (product.variants && product.variants.length > 0) {
                const firstVariant = product.variants[0];

                let totalStock = 0;
                product.variants.forEach(v => {
                    totalStock += parseInt(v.stock) || 0;
                });

                const originalPrice = parseFloat(firstVariant.total_price) || parseFloat(firstVariant.mrp) || parseFloat(
                    firstVariant.price) || 0;
                const displayPrice = parseFloat(firstVariant.final_price) || parseFloat(firstVariant.price) || 0;

                let colors = [];
                const colorSet = new Set();
                product.variants.forEach(variant => {
                    if (variant.color && variant.color.trim() !== '') {
                        colorSet.add(variant.color);
                    }
                });
                colors = Array.from(colorSet);

                // Build variants for modal
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
                    price: displayPrice,
                    originalPrice: originalPrice,
                    discountType: firstVariant.discount_type || 'flat',
                    discountValue: parseFloat(firstVariant.discount_value) || 0,
                    totalStock: totalStock,
                    colors: colors,
                    variantCount: product.variants.length,
                    variants: variantsForModal
                };
            }

            const originalPrice = parseFloat(product.total_price) || parseFloat(product.mrp) || parseFloat(product.price) ||
                0;
            const displayPrice = parseFloat(product.final_price) || parseFloat(product.price) || 0;

            return {
                hasVariant: false,
                price: displayPrice,
                originalPrice: originalPrice,
                discountType: product.discount_type || 'flat',
                discountValue: parseFloat(product.discount_value) || 0,
                totalStock: parseInt(product.stock) || 0,
                colors: [],
                variantCount: 0,
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

                const encoded = btoa(unescape(encodeURIComponent(svg)));
                images.push(`data:image/svg+xml;base64,${encoded}`);
            }

            return images;
        }

        // ================================================================
        // ===== HANDLE CART BUTTON CLICK =====
        // ================================================================

        function handleAddToCartWishlist(product) {
            if (product.hasVariant && product.variants && product.variants.length > 0) {
                openQuickCartModal(product);
            } else {
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

            showToast(productName + ' added to cart!', 'success');

            setTimeout(() => {
                window.location.href = "{{ route('cart') }}";
            }, 500);
        }

        // ================================================================
        // ===== QUICK ADD TO CART MODAL (For Variant Products) =====
        // ================================================================

        function openQuickCartModal(productData) {
            modalProductData = productData;
            modalAllVariants = productData.variants || [];
            modalProductId = productData.id;
            modalSelectedColor = null;
            modalSelectedSize = null;
            modalSelectedVariant = null;

            document.getElementById('modalProductImage').src = productData.image;
            document.getElementById('modalProductBrand').textContent = productData.brand || '';
            document.getElementById('modalProductName').textContent = productData.name;
            document.getElementById('modalViewDetailsLink').href = `/product/${productData.id}`;

            if (modalAllVariants.length > 0) {
                document.getElementById('modalVariantSection').style.display = 'block';

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
                updateModalPriceDisplay(productData.price, productData.original_price);
                updateModalStockInfo(null);
            }

            document.getElementById('modalQtyInput').value = 1;
            document.getElementById('modalErrorMsg').style.display = 'none';

            document.getElementById('quickCartModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function updateModalPrice(color) {
            let filteredVariants = modalAllVariants;
            if (color) {
                filteredVariants = modalAllVariants.filter(v => v.color === color);
            }

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
                        if (modalSelectedVariant) {
                            updateModalPriceDisplay(modalSelectedVariant.price, modalSelectedVariant
                            .original_price);
                        }
                        updateModalStockInfo(modalSelectedVariant);
                        document.getElementById('modalErrorMsg').style.display = 'none';
                    };

                    sizeContainer.appendChild(btn);
                });

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

            const productId = modalProductData.id;
            const productName = modalProductData.name;
            const price = modalSelectedVariant ? modalSelectedVariant.price : modalProductData.price;
            const image = modalProductData.image;
            const variantId = modalSelectedVariant ? modalSelectedVariant.id : null;
            const size = modalSelectedSize || null;
            const color = modalSelectedColor || null;

            if (modalSelectedVariant && quantity > modalSelectedVariant.stock) {
                errorMsg.textContent = 'Only ' + modalSelectedVariant.stock + ' items available!';
                errorMsg.style.display = 'block';
                return;
            }

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

            closeQuickCartModal();

            showToast(productName + ' added to cart!', 'success');

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

        document.getElementById('quickCartModal').addEventListener('click', function(e) {
            if (e.target === this) closeQuickCartModal();
        });

        function goToModalProductDetail(event) {
            event.preventDefault();
            if (modalProductId) {
                window.location.href = `/product/${modalProductId}`;
            }
        }

        // ================================================================
        // ===== LOAD WISHLIST =====
        // ================================================================
        async function loadWishlist() {
            const container = document.getElementById('wishlistContainer');
            const emptyDiv = document.getElementById('emptyWishlist');

            if (wishlist.length === 0) {
                container.style.display = 'none';
                emptyDiv.style.display = 'block';
                return;
            }

            container.style.display = 'flex';
            container.style.flexWrap = 'wrap';
            emptyDiv.style.display = 'none';

            let wishlistItems = [];

            try {
                const response = await fetch('/api/products');
                const products = await response.json();

                wishlistItems = wishlist.map(item => {
                    const product = products.find(p => p.id === item.id);
                    if (product) {
                        const variantData = getVariantData(product);
                        const priceData = {
                            originalPrice: variantData.originalPrice,
                            price: variantData.price,
                            discountType: variantData.discountType,
                            discountValue: variantData.discountValue
                        };
                        const discount = calculateDiscount(priceData);

                        const images = getProductImages(product);
                        const firstImage = images.length > 0 ? images[0] :
                            'https://via.placeholder.com/300x300?text=No+Image';

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
                                    ${escapeHtml(brandName)}
                                </div>
                            `;
                        }

                        let stockHtml = '';
                        const totalStock = variantData.totalStock || 0;
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

                        const colors = variantData.colors || [];
                        let colorHtml = '';
                        if (colors.length > 0) {
                            const displayColors = colors.slice(0, 4);
                            const remaining = colors.length - 4;

                            colorHtml = `
                                <div class="color-options-container">
                                    <span class="color-label">${colors.length} Color${colors.length > 1 ? 's' : ''}:</span>
                                    ${displayColors.map(color => `
                                        <span class="color-dot" style="background: ${color.toLowerCase()};" title="${escapeHtml(color)}"></span>
                                    `).join('')}
                                    ${remaining > 0 ? `<span class="color-dot more-colors">+${remaining}</span>` : ''}
                                </div>
                            `;
                        }

                        let priceHtml = '';
                        if (discount.hasDiscount && discount.originalPrice > 0 && discount.displayPrice > 0) {
                            priceHtml = `
                                <div class="product-price-container">
                                    <span class="final-price">₹${discount.displayPrice.toFixed(2)}</span>
                                    <span class="original-price">₹${discount.originalPrice.toFixed(2)}</span>
                                    <span class="discount-percent">${discount.discountDisplay}</span>
                                </div>
                            `;
                        } else {
                            priceHtml = `
                                <div class="product-price-container">
                                    <span class="final-price">₹${discount.displayPrice.toFixed(2)}</span>
                                </div>
                            `;
                        }

                        const escapeName = product.name.replace(/'/g, "\\'");

                        // Build product data for modal
                        const productDataForModal = {
                            id: product.id,
                            name: product.name,
                            price: discount.displayPrice,
                            original_price: discount.originalPrice,
                            image: firstImage,
                            brand: brandName,
                            stock: totalStock,
                            hasVariant: variantData.hasVariant,
                            variants: variantData.variants || []
                        };

                        const isInStock = totalStock > 0;

                        return `
                            <div class="col-md-3 col-sm-6 mb-4">
                                <div class="product-card card" onclick="goToProductDetail(${product.id}, event)">
                                    <button class="remove-wishlist-btn" onclick="event.stopPropagation(); openRemoveConfirm(${product.id}, '${escapeName}')" title="Remove from wishlist">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    
                                    <div class="product-image-container">
                                        <img src="${firstImage}" alt="${escapeHtml(product.name)}" 
                                            onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMDAiIGhlaWdodD0iMzAwIiB2aWV3Qm94PSIwIDAgMzAwIDMwMCI+PHJlY3Qgd2lkdGg9IjMwMCIgaGVpZ2h0PSIzMDAiIGZpbGw9IiNmMGYwZjAiLz48dGV4dCB4PSIxNTAiIHk9IjE1MCIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjQwIiBmaWxsPSIjY2NjIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBkb21pbmFudC1iYXNlbGluZT0iY2VudHJhbCI+TG9hZCBFcnJvcjwvdGV4dD48L3N2Zz4='"
                                            loading="lazy">
                                    </div>
                                    
                                    <div class="card-body">
                                        ${brandHtml}
                                        <div class="product-name">${escapeHtml(product.name)}</div>
                                        ${priceHtml}
                                        ${colorHtml}
                                        ${stockHtml}
                                        
                                        <div class="button-spacer"></div>
                                        
                                        <div class="product-action-buttons">
                                            <button class="btn-view-product" onclick="goToProductDetailFromView(${product.id}, event)">
                                                <i class="fas fa-eye"></i> View
                                            </button>
                                            <button class="btn-add-cart-home" 
                                                onclick="event.stopPropagation(); handleAddToCartWishlist(${JSON.stringify(productDataForModal).replace(/"/g, '&quot;')})"
                                                ${!isInStock ? 'disabled' : ''}>
                                                <i class="fas fa-shopping-cart"></i> Cart
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    }
                    return null;
                }).filter(item => item !== null);

            } catch (error) {
                console.error('Error fetching product details:', error);
                wishlistItems = wishlist.map(item => {
                    const price = parseFloat(item.price) || 0;
                    const productDataForModal = {
                        id: item.id,
                        name: item.name,
                        price: price,
                        original_price: price,
                        image: item.image || 'https://via.placeholder.com/300x300?text=No+Image',
                        brand: '',
                        stock: 0,
                        hasVariant: false,
                        variants: []
                    };
                    const escapeName = item.name.replace(/'/g, "\\'");

                    return `
                        <div class="col-md-3 col-sm-6 mb-4">
                            <div class="product-card card" onclick="goToProductDetail(${item.id}, event)">
                                <button class="remove-wishlist-btn" onclick="event.stopPropagation(); openRemoveConfirm(${item.id}, '${escapeName}')" title="Remove from wishlist">
                                    <i class="fas fa-times"></i>
                                </button>
                                
                                <div class="product-image-container">
                                    <img src="${item.image || 'https://via.placeholder.com/300x300?text=No+Image'}" alt="${escapeHtml(item.name)}" 
                                        onerror="this.src='https://via.placeholder.com/300x300?text=No+Image'"
                                        loading="lazy">
                                </div>
                                
                                <div class="card-body">
                                    <div class="product-name">${escapeHtml(item.name)}</div>
                                    <div class="product-price-container">
                                        <span class="final-price">₹${price.toFixed(2)}</span>
                                    </div>
                                    
                                    <div class="button-spacer"></div>
                                    
                                    <div class="product-action-buttons">
                                        <button class="btn-view-product" onclick="goToProductDetailFromView(${item.id}, event)">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                        <button class="btn-add-cart-home" 
                                            onclick="event.stopPropagation(); handleAddToCartWishlist(${JSON.stringify(productDataForModal).replace(/"/g, '&quot;')})">
                                            <i class="fas fa-shopping-cart"></i> Cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });
            }

            if (wishlistItems.length === 0) {
                container.style.display = 'none';
                emptyDiv.style.display = 'block';
                return;
            }

            container.innerHTML = wishlistItems.join('');
            updateWishlistCount();
        }

        // ================================================================
        // ===== INITIALIZE =====
        // ================================================================
        document.addEventListener('DOMContentLoaded', function() {
            wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
            cart = JSON.parse(localStorage.getItem('cart')) || [];
            loadWishlist();
            updateCartCount();
            updateWishlistCount();

            window.addEventListener('storage', function(e) {
                if (e.key === 'wishlist') {
                    wishlist = JSON.parse(e.newValue) || [];
                    loadWishlist();
                    updateWishlistCount();
                }
                if (e.key === 'cart') {
                    cart = JSON.parse(e.newValue) || [];
                    updateCartCount();
                }
            });
        });
    </script>
@endsection