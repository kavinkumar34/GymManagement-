{{-- resources/views/product-detail.blade.php --}}
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
            min-height: 100vh;
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
        /* ===== PRODUCT DETAIL CONTAINER ===== */
        /* ============================================================ */
        .product-detail-container {
            margin-top: 30px;
            overflow: visible;
            position: relative;
            padding: 0 15px;
        }

        @media (min-width: 1400px) {
            .product-detail-container {
                padding: 0 40px;
            }
        }

        @media (min-width: 1200px) and (max-width: 1399px) {
            .product-detail-container {
                padding: 0 30px;
            }
        }

        @media (min-width: 992px) and (max-width: 1199px) {
            .product-detail-container {
                padding: 0 20px;
            }
        }

        /* ============================================================ */
        /* ===== PRODUCT WRAPPER - 80% WIDTH WITH CENTER ===== */
        /* ============================================================ */
        .product-wrapper {
            display: flex;
            align-items: flex-start;
            gap: 60px;
            width: 80%;
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
        }

        /* LEFT COLUMN - STICKY IMAGE */
        .left-column {
            width: 45%;
            flex: 0 0 45%;
            position: sticky !important;
            top: 120px;
            align-self: flex-start;
            height: fit-content;
            z-index: 10;
        }

        /* RIGHT COLUMN - SCROLLABLE */
        .right-column {
            width: 55%;
            flex: 0 0 55%;
            position: relative;
            z-index: 1;
            max-height: calc(100vh - 150px);
            overflow-y: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
            padding-right: 5px;
        }

        .right-column::-webkit-scrollbar {
            display: none;
            width: 0;
            height: 0;
        }

        .right-side-content {
            width: 100%;
            padding-right: 10px;
        }

        /* ============================================================ */
        /* ===== IMAGE GALLERY ===== */
        /* ============================================================ */
        .product-gallery-wrapper {
            display: flex;
            gap: 18px;
            flex-direction: row;
            width: 100%;
        }

        .main-image-area {
            flex: 1;
            width: 100%;
            height: 550px;
            background: #fff;
            border-radius: var(--radius-md);
            overflow: hidden;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--line);
            cursor: pointer;
        }

        .main-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            padding: 0;
            display: block;
            transition: transform 0.3s ease;
        }

        .main-image-area:hover .main-image {
            transform: scale(1.05);
        }

        .vertical-thumbnails {
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 85px;
            flex-shrink: 0;
            max-height: 500px;
            overflow-y: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .vertical-thumbnails::-webkit-scrollbar {
            display: none;
            width: 0;
            height: 0;
        }

        .vertical-thumb {
            width: 80px;
            height: 80px;
            border-radius: var(--radius-sm);
            overflow: hidden;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.3s;
            background: var(--fog);
            flex-shrink: 0;
        }

        .vertical-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .vertical-thumb.active {
            border-color: var(--signal);
            box-shadow: 0 0 8px rgba(255, 68, 5, 0.3);
        }

        .vertical-thumb:hover {
            transform: scale(1.05);
            border-color: var(--signal);
        }

        .nav-arrows {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 100%;
            display: flex;
            justify-content: space-between;
            padding: 0 10px;
            pointer-events: none;
        }

        .nav-arrow {
            width: 36px;
            height: 36px;
            background: rgba(20, 22, 26, 0.6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            cursor: pointer;
            pointer-events: auto;
            transition: all 0.3s;
            border: none;
        }

        .nav-arrow:hover {
            background: var(--signal);
        }

        /* ============================================================ */
        /* ===== FULL SCREEN IMAGE MODAL ===== */
        /* ============================================================ */
        .image-modal-overlay {
            display: none;
            position: fixed;
            z-index: 999999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(20, 22, 26, 0.95);
            cursor: pointer;
            align-items: center;
            justify-content: center;
        }

        .image-modal-overlay.active {
            display: flex;
        }

        .image-modal-content {
            max-width: 90%;
            max-height: 90%;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .image-modal-content img,
        .image-modal-content video {
            max-width: 90vw;
            max-height: 85vh;
            object-fit: contain;
            border-radius: var(--radius-sm);
        }

        .image-modal-content video {
            background: #000;
        }

        .image-modal-close {
            position: fixed;
            top: 20px;
            right: 35px;
            color: white;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            z-index: 9999999;
            background: rgba(20, 22, 26, 0.5);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
        }

        .image-modal-close:hover {
            color: var(--signal);
            transform: rotate(90deg);
            background: rgba(255, 68, 5, 0.2);
        }

        .image-modal-nav {
            position: fixed;
            top: 50%;
            transform: translateY(-50%);
            color: white;
            font-size: 40px;
            cursor: pointer;
            z-index: 9999999;
            background: rgba(20, 22, 26, 0.4);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            border: none;
        }

        .image-modal-nav:hover {
            background: var(--signal);
        }

        .image-modal-nav.prev {
            left: 20px;
        }

        .image-modal-nav.next {
            right: 20px;
        }

        .image-modal-counter {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            color: white;
            background: rgba(20, 22, 26, 0.6);
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 14px;
            z-index: 9999999;
            font-family: var(--font-body);
            font-weight: 500;
        }

        /* ============================================================ */
        /* ===== RIGHT SIDE CONTENT ===== */
        /* ============================================================ */
        .brand-name {
            font-size: 14px;
            color: var(--steel);
            margin-bottom: 5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .brand-name i {
            color: var(--signal);
            margin-right: 6px;
        }

        .product-title {
            font-family: var(--font-display);
            font-weight: 400;
            font-size: 24px;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            color: var(--ink);
            margin-bottom: 5px;
            line-height: 1.3;
        }

        .product-category {
            color: var(--steel);
            font-size: 13px;
            margin-bottom: 10px;
            font-weight: 500;
        }

        .product-category i {
            margin-right: 5px;
            color: var(--signal);
        }

        /* ===== RATING ===== */
        .rating {
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .stars {
            color: #f59e0b;
            font-size: 14px;
        }

        .rating-text {
            color: var(--steel);
            font-size: 13px;
            font-weight: 500;
        }

        /* ===== PRICE SECTION ===== */
        .price-section {
            margin-bottom: 15px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--line);
        }

        .current-price {
            font-family: var(--font-display);
            font-weight: 400;
            font-size: 28px;
            letter-spacing: 0.3px;
            color: var(--signal);
        }

        .old-price {
            text-decoration: line-through;
            color: var(--steel);
            font-size: 18px;
            margin-left: 10px;
            font-weight: 500;
        }

        .discount-badge {
            background: var(--signal);
            color: white;
            padding: 3px 10px;
            border-radius: var(--radius-sm);
            font-size: 12px;
            margin-left: 10px;
            font-weight: 700;
        }

        .tax-text {
            color: var(--steel);
            font-size: 12px;
            margin-top: 4px;
            font-weight: 500;
        }

        .you-save-text {
            font-size: 13px;
            color: var(--success);
            margin-top: 4px;
            font-weight: 700;
        }

        .you-save-text i {
            margin-right: 4px;
        }

        .variant-info {
            font-size: 12px;
            color: var(--steel);
            margin-top: 4px;
            font-weight: 500;
        }

        .variant-info i {
            color: var(--signal);
            margin-right: 4px;
        }

        /* ============================================================ */
        /* ===== COLOR SECTION ===== */
        /* ============================================================ */
        .color-section {
            margin-bottom: 16px;
        }

        .color-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .color-label {
            font-weight: 700;
            font-size: 14px;
            color: var(--ink);
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .color-options {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .color-btn {
            width: 38px;
            height: 38px;
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

        .color-btn:hover {
            transform: scale(1.1);
            border-color: var(--steel);
        }

        .color-btn.selected {
            border-color: var(--signal);
            box-shadow: 0 0 0 3px rgba(255, 68, 5, 0.3);
            transform: scale(1.1);
        }

        .color-btn .color-name-tooltip {
            position: absolute;
            bottom: -25px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 10px;
            color: var(--steel);
            white-space: nowrap;
            display: none;
            font-weight: 600;
        }

        .color-btn:hover .color-name-tooltip {
            display: block;
        }

        .color-btn .check-mark {
            display: none;
            color: white;
            font-size: 14px;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.5);
        }

        .color-btn.selected .check-mark {
            display: block;
        }

        /* ============================================================ */
        /* ===== SIZE SECTION ===== */
        /* ============================================================ */
        .size-section {
            margin-bottom: 16px;
        }

        .size-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .size-label {
            font-weight: 700;
            font-size: 14px;
            color: var(--ink);
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .size-guide {
            font-size: 12px;
            color: var(--info);
            text-decoration: none;
            cursor: pointer;
            font-weight: 600;
        }

        .size-guide:hover {
            text-decoration: underline;
            color: var(--signal);
        }

        .size-options {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .size-btn {
            min-width: 70px;
            padding: 8px 14px;
            border: 1px solid var(--line);
            background: white;
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
            font-size: 13px;
            font-weight: 600;
            font-family: var(--font-body);
            color: var(--ink);
        }

        .size-btn:hover:not(.out-of-stock-size):not(:disabled) {
            border-color: var(--signal);
            background: var(--signal-tint);
            color: var(--ink);
        }

        .size-btn.selected {
            background: var(--signal);
            color: white;
            border-color: var(--signal);
        }

        .size-btn.selected .discount-text {
            color: white !important;
        }

        .size-btn.out-of-stock-size {
            opacity: 0.4;
            cursor: not-allowed;
            text-decoration: line-through;
        }

        .size-btn.out-of-stock-size:hover {
            background: white;
            color: var(--ink);
            border-color: var(--line);
        }

        .size-warning {
            color: var(--signal);
            font-size: 12px;
            display: none;
            margin-top: 6px;
            font-weight: 600;
        }

        .size-stock-info {
            font-size: 12px;
            color: var(--steel);
            margin-top: 6px;
            display: none;
            font-weight: 500;
        }

        .size-stock-info i {
            margin-right: 4px;
        }

        .discount-text {
            font-size: 9px;
            display: block;
            color: white;
            transition: color 0.3s ease;
        }

        .size-btn:hover .discount-text {
            color: var(--ink) !important;
        }

        .size-btn.selected .discount-text {
            color: white !important;
        }

        /* ============================================================ */
        /* ===== QUANTITY SECTION ===== */
        /* ============================================================ */
        .quantity-section {
            margin-bottom: 16px;
        }

        .quantity-label {
            font-weight: 700;
            font-size: 14px;
            margin-bottom: 8px;
            display: block;
            color: var(--ink);
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity-btn {
            width: 38px;
            height: 38px;
            border: 1px solid var(--line);
            background: white;
            border-radius: var(--radius-sm);
            cursor: pointer;
            font-size: 18px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--ink);
            font-weight: 700;
        }

        .quantity-btn:hover {
            border-color: var(--signal);
            background: var(--signal-tint);
        }

        .quantity-input {
            width: 60px;
            text-align: center;
            padding: 8px;
            border: 1px solid var(--line);
            border-radius: var(--radius-sm);
            font-size: 14px;
            font-weight: 700;
            font-family: var(--font-body);
            color: var(--ink);
        }

        .quantity-input:focus {
            outline: none;
            border-color: var(--signal);
            box-shadow: 0 0 0 3px rgba(255, 68, 5, 0.1);
        }

        /* ============================================================ */
        /* ===== STOCK STATUS ===== */
        /* ============================================================ */
        .stock-status {
            margin-bottom: 14px;
        }

        .in-stock {
            color: var(--success);
            font-size: 14px;
            font-weight: 700;
        }

        .in-stock-low {
            color: var(--signal);
            font-size: 14px;
            font-weight: 700;
        }

        .in-stock-low i {
            margin-right: 6px;
        }

        .out-of-stock {
            color: var(--signal);
            font-size: 14px;
            font-weight: 700;
        }

        .out-of-stock i {
            margin-right: 6px;
        }

        /* ============================================================ */
        /* ===== ACTION BUTTONS ===== */
        /* ============================================================ */
        .action-buttons {
            display: flex;
            gap: 12px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }

        .btn-wishlist {
            background: white;
            border: 1px solid var(--signal);
            border-radius: 25px;
            padding: 10px 22px;
            color: var(--signal);
            cursor: pointer;
            transition: all 0.3s;
            font-size: 14px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            flex: 0 0 auto;
            font-family: var(--font-body);
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .btn-wishlist:hover:not(:disabled) {
            background: var(--signal);
            color: white;
        }

        .btn-wishlist i {
            font-size: 16px;
        }

        .btn-add-cart {
            background: var(--ink);
            border: none;
            border-radius: 25px;
            padding: 10px 28px;
            color: white;
            cursor: pointer;
            transition: all 0.3s;
            flex: 1;
            font-size: 14px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-family: var(--font-body);
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .btn-add-cart:hover:not(:disabled) {
            background: var(--signal);
        }

        .btn-add-cart:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* ============================================================ */
        /* ===== DELIVERY BOX ===== */
        /* ============================================================ */
        .delivery-box {
            background: var(--fog);
            padding: 14px 18px;
            border-radius: var(--radius-md);
            margin-bottom: 16px;
            border: 1px solid var(--line);
        }

        .delivery-item {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px;
        }

        .delivery-item:last-child {
            margin-bottom: 0;
        }

        .delivery-item i {
            width: 24px;
            color: var(--signal);
            font-size: 16px;
            flex-shrink: 0;
        }

        .delivery-text {
            font-size: 13px;
            flex: 1;
            font-weight: 500;
        }

        .delivery-text strong {
            display: block;
            margin-bottom: 1px;
            font-size: 13px;
            color: var(--ink);
        }

        .delivery-text small {
            color: var(--steel);
            font-size: 12px;
            font-weight: 500;
        }

        .delivery-text .cod-available {
            color: var(--success);
            font-weight: 700;
        }

        .delivery-text .cod-not-available {
            color: var(--signal);
            font-weight: 700;
        }

        /* ============================================================ */
        /* ===== PRODUCT INFO TABS ===== */
        /* ============================================================ */
        .product-info-tabs {
            margin-top: 16px;
        }

        .info-tab {
            border: 1px solid var(--line);
            border-radius: var(--radius-md);
            margin-bottom: 10px;
            overflow: hidden;
        }

        .info-tab-header {
            background: white;
            padding: 12px 16px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s;
            font-weight: 700;
            font-size: 13px;
            color: var(--ink);
            text-transform: uppercase;
            letter-spacing: 0.3px;
            font-family: var(--font-body);
        }

        .info-tab-header i {
            margin-right: 10px;
            color: var(--signal);
        }

        .info-tab-header.active {
            background: var(--signal);
            color: white;
        }

        .info-tab-header.active i {
            color: white;
        }

        .info-tab-header .arrow {
            transition: transform 0.3s;
        }

        .info-tab-header.active .arrow {
            transform: rotate(180deg);
        }

        .info-tab-content {
            padding: 0;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease, padding 0.3s ease;
            background: var(--fog);
        }

        .info-tab-content.show {
            padding: 16px;
            max-height: 400px;
            overflow-y: auto;
        }

        .product-description {
            font-size: 14px;
            line-height: 1.8;
            color: var(--ink-soft);
        }

        .product-description p {
            margin-bottom: 8px;
        }

        /* ============================================================ */
        /* ===== REVIEWS SECTION - CAROUSEL ===== */
        /* ============================================================ */
        .reviews-section {
            margin-top: 35px;
            padding: 0;
            background: transparent;
            border-radius: 0;
            width: 80%;
            max-width: 1400px;
            margin-left: auto;
            margin-right: auto;
        }

        .reviews-section .section-title {
            font-family: var(--font-display);
            font-weight: 400;
            font-size: 20px;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            color: var(--ink);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            padding-bottom: 12px;
            border-bottom: 2px solid var(--line);
            flex-wrap: wrap;
        }

        .reviews-section .section-title i {
            color: #f59e0b;
        }

        .review-count-badge {
            background: var(--fog);
            color: var(--ink);
            border-radius: 20px;
            padding: 2px 14px;
            font-size: 14px;
            font-weight: 700;
            border: 1px solid var(--line);
            font-family: var(--font-body);
        }

        /* ===== REVIEWS CAROUSEL ===== */
        .reviews-carousel-wrapper {
            position: relative;
            overflow: hidden;
            padding: 10px 0;
        }

        .reviews-carousel-track {
            display: flex;
            gap: 20px;
            transition: transform 0.5s ease;
            will-change: transform;
        }

        .review-card {
            flex: 0 0 calc(33.333% - 14px);
            min-width: 280px;
            background: white;
            border-radius: var(--radius-md);
            padding: 20px 22px;
            border: 1px solid var(--line);
            transition: all 0.3s;
            box-shadow: var(--shadow-card);
        }

        .review-card:hover {
            box-shadow: var(--shadow-card-hover);
            border-color: transparent;
            transform: translateY(-4px);
        }

        .review-card .review-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 6px;
            flex-wrap: wrap;
            gap: 4px;
        }

        .review-card .review-user {
            font-weight: 700;
            color: var(--ink);
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .review-card .review-user i {
            color: #667eea;
            font-size: 18px;
        }

        .review-card .review-date {
            font-size: 12px;
            color: #94a3b8;
            font-weight: 500;
        }

        .review-card .review-stars {
            color: #f59e0b;
            font-size: 14px;
            margin-bottom: 8px;
            display: flex;
            gap: 2px;
        }

        .review-card .review-stars .star-empty {
            color: var(--line);
        }

        .review-card .review-text {
            color: var(--steel);
            font-size: 14px;
            line-height: 1.7;
            font-weight: 500;
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 80px;
        }

        .review-card .review-verified {
            display: inline-block;
            background: var(--success-tint);
            color: var(--success);
            font-size: 11px;
            padding: 2px 12px;
            border-radius: 20px;
            font-weight: 600;
            margin-top: 10px;
        }

        .review-card .review-verified i {
            margin-right: 4px;
        }

        /* ===== CAROUSEL NAVIGATION ===== */
        .reviews-nav {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            margin-top: 20px;
        }

        .reviews-nav-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid var(--line);
            background: white;
            color: var(--ink);
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .reviews-nav-btn:hover:not(:disabled) {
            background: var(--signal);
            color: white;
            border-color: var(--signal);
        }

        .reviews-nav-btn:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .reviews-dots {
            display: flex;
            gap: 8px;
        }

        .reviews-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            border: 1px solid var(--line);
            background: white;
            cursor: pointer;
            transition: all 0.3s;
        }

        .reviews-dot.active {
            background: var(--signal);
            border-color: var(--signal);
            transform: scale(1.2);
        }

        .reviews-dot:hover:not(.active) {
            border-color: var(--signal);
        }

        /* ===== NO REVIEWS ===== */
        .no-reviews {
            text-align: center;
            padding: 40px 20px;
            color: #94a3b8;
            background: var(--fog);
            border-radius: var(--radius-md);
            border: 1px dashed var(--line);
        }

        .no-reviews i {
            font-size: 40px;
            margin-bottom: 15px;
            display: block;
            color: var(--steel);
        }

        .no-reviews h5 {
            font-family: var(--font-display);
            font-weight: 400;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            color: var(--ink);
            margin-bottom: 5px;
        }

        .no-reviews p {
            font-weight: 500;
        }

        /* ============================================================ */
        /* ===== RELATED PRODUCTS - RESPONSIVE ===== */
        /* ============================================================ */
        .related-products-section {
            margin-top: 35px;
            padding: 20px 0;
            clear: both;
            border-top: 2px solid var(--line);
            width: 80%;
            max-width: 1400px;
            margin-left: auto;
            margin-right: auto;
        }

        .related-products-section .section-title {
            font-family: var(--font-display);
            font-weight: 400;
            font-size: 1.3rem;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            color: var(--ink);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .related-products-section .section-title i {
            color: var(--signal);
        }

        .related-product-card {
            border: 1px solid var(--line);
            border-radius: var(--radius-md);
            transition: all 0.28s ease;
            overflow: hidden;
            margin-bottom: 20px;
            height: 100%;
            position: relative;
            background: white;
            cursor: pointer;
            box-shadow: var(--shadow-card);
        }

        .related-product-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-card-hover);
            border-color: transparent;
        }

        .related-product-card .product-image-container {
            width: 100%;
            height: 220px;
            overflow: hidden;
            background: var(--fog);
            position: relative;
        }

        .related-product-card .product-image-container img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            transition: transform 0.5s ease;
            background: #ffffff;
            padding: 15px;
        }

        .related-product-card:hover .product-image-container img {
            transform: scale(1.04);
        }

        .related-product-card .discount-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: var(--signal);
            color: white;
            padding: 3px 12px;
            border-radius: var(--radius-sm);
            font-size: 0.75rem;
            font-weight: 700;
            z-index: 1;
            letter-spacing: 0.3px;
        }

        .related-product-card .wishlist-btn {
            position: absolute;
            top: 10px;
            left: 10px;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(4px);
            border: 1px solid var(--line);
            border-radius: 50%;
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 2;
            box-shadow: 0 2px 6px rgba(20, 22, 26, 0.1);
            transition: all 0.25s;
        }

        .related-product-card .wishlist-btn i {
            font-size: 0.9rem;
            transition: all 0.25s;
        }

        .related-product-card .wishlist-btn i.far {
            color: var(--steel);
        }

        .related-product-card .wishlist-btn i.fas {
            color: var(--signal);
        }

        .related-product-card .wishlist-btn:hover {
            transform: scale(1.1);
            border-color: var(--signal);
        }

        .related-product-card .card-body {
            padding: 12px 14px 14px;
            text-align: left;
        }

        .related-product-card .product-brand {
            font-size: 0.7rem;
            color: var(--steel);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 2px;
        }

        .related-product-card .product-brand i {
            font-size: 0.6rem;
            margin-right: 4px;
            color: var(--signal);
        }

        .related-product-card .product-name {
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 4px;
            color: var(--ink);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 40px;
            line-height: 1.35;
        }

        .related-product-card .product-price-container {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 2px;
        }

        .related-product-card .product-price-container .final-price {
            font-size: 1rem;
            font-weight: 800;
            color: var(--ink);
            font-family: var(--font-body);
        }

        .related-product-card .product-price-container .original-price {
            font-size: 0.8rem;
            color: #A3A9B2;
            text-decoration: line-through;
        }

        .related-product-card .product-price-container .discount-percent {
            background: var(--signal-tint);
            color: var(--signal-dark);
            padding: 1px 8px;
            border-radius: var(--radius-sm);
            font-size: 0.7rem;
            font-weight: 700;
        }

        .related-product-card .color-options-container {
            display: flex;
            gap: 4px;
            flex-wrap: wrap;
            margin-top: 6px;
            align-items: center;
        }

        .related-product-card .color-options-container .color-label {
            font-size: 0.6rem;
            color: var(--steel);
            font-weight: 600;
            margin-right: 2px;
        }

        .related-product-card .color-dot {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 2px solid var(--line);
            display: inline-block;
            cursor: pointer;
            transition: all 0.3s;
            flex-shrink: 0;
        }

        .related-product-card .color-dot.more-colors {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: var(--fog);
            border: 2px solid var(--line);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 6px;
            color: var(--steel);
            font-weight: 700;
            cursor: pointer;
        }

        .related-product-card .product-stock-low {
            font-size: 0.7rem;
            color: var(--signal-dark);
            margin-top: 6px;
            font-weight: 600;
        }

        .related-product-card .product-stock-low i {
            font-size: 0.7rem;
            margin-right: 4px;
            color: var(--signal);
        }

        .related-product-card .product-stock-out {
            font-size: 0.7rem;
            color: var(--steel);
            margin-top: 6px;
            font-weight: 600;
            background: var(--fog);
            padding: 3px 8px;
            border-radius: var(--radius-sm);
            display: inline-block;
        }

        .related-product-card .product-stock-out i {
            font-size: 0.7rem;
            margin-right: 4px;
            color: var(--steel);
        }

        /* ============================================================ */
        /* ===== BREADCRUMB ===== */
        /* ============================================================ */
        .breadcrumb-custom {
            background: transparent;
            padding: 0;
            margin-bottom: 16px;
            width: 80%;
            max-width: 1400px;
            margin-left: auto;
            margin-right: auto;
        }

        .breadcrumb-custom .breadcrumb-item a {
            color: var(--steel);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
        }

        .breadcrumb-custom .breadcrumb-item a:hover {
            color: var(--signal);
        }

        .breadcrumb-custom .breadcrumb-item.active {
            color: var(--ink);
            font-weight: 700;
            font-size: 13px;
        }

        .breadcrumb-custom .breadcrumb-item+.breadcrumb-item::before {
            color: var(--steel);
        }

        /* ============================================================ */
        /* ===== MODALS ===== */
        /* ============================================================ */

        /* ===== CUSTOM LOGIN MODAL ===== */
        .custom-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(20, 22, 26, 0.6);
            backdrop-filter: blur(2px);
            z-index: 99999;
            display: none;
            align-items: center;
            justify-content: center;
            animation: fadeInModal 0.3s ease;
        }

        .custom-modal-overlay.active {
            display: flex;
        }

        @keyframes fadeInModal {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .custom-modal-box {
            background: white;
            border-radius: var(--radius-lg);
            padding: 35px 40px;
            max-width: 420px;
            width: 90%;
            text-align: center;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);
            position: relative;
            animation: slideUpModal 0.4s ease;
            font-family: var(--font-body);
        }

        @keyframes slideUpModal {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .custom-modal-box .modal-icon {
            width: 70px;
            height: 70px;
            background: var(--success);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
            font-size: 2.2rem;
            color: white;
            box-shadow: 0 10px 30px rgba(22, 163, 74, 0.3);
        }

        .custom-modal-box .modal-title {
            font-family: var(--font-display);
            font-weight: 400;
            font-size: 1.3rem;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            color: var(--ink);
            margin-bottom: 8px;
        }

        .custom-modal-box .modal-subtitle {
            font-size: 0.9rem;
            color: var(--steel);
            margin-bottom: 20px;
            line-height: 1.6;
            font-weight: 500;
        }

        .custom-modal-box .modal-subtitle span {
            color: var(--success);
            font-weight: 700;
        }

        .custom-modal-box .modal-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .custom-modal-box .btn-modal-primary {
            background: var(--signal);
            color: white;
            border: none;
            padding: 10px 30px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .custom-modal-box .btn-modal-primary:hover {
            background: var(--signal-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 68, 5, 0.3);
            color: white;
        }

        .custom-modal-box .btn-modal-secondary {
            background: var(--fog);
            color: var(--steel);
            border: 1px solid var(--line);
            padding: 10px 30px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .custom-modal-box .btn-modal-secondary:hover {
            background: var(--line);
            color: var(--ink);
        }

        .custom-modal-box .modal-close {
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

        .custom-modal-box .modal-close:hover {
            color: var(--signal);
            transform: rotate(90deg);
        }

        .custom-modal-box .register-link {
            margin-top: 14px;
            font-size: 0.8rem;
            color: var(--steel);
        }

        .custom-modal-box .register-link a {
            color: var(--signal);
            text-decoration: none;
            font-weight: 700;
            transition: all 0.3s;
        }

        .custom-modal-box .register-link a:hover {
            text-decoration: underline;
        }

        /* ===== SIZE GUIDE MODAL ===== */
        .sizeguide-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(20, 22, 26, 0.5);
            z-index: 99999;
            display: none;
            justify-content: flex-end;
            animation: fadeIn 0.3s ease;
        }

        .sizeguide-modal-overlay.active {
            display: flex;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .sizeguide-modal-box {
            background: white;
            width: 480px;
            max-width: 92%;
            height: 100vh;
            overflow-y: auto;
            padding: 30px 35px;
            box-shadow: -10px 0 30px rgba(0, 0, 0, 0.15);
            animation: slideInRight 0.3s ease;
            position: relative;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(0);
            }
        }

        .sizeguide-modal-box .modal-close-btn {
            position: absolute;
            top: 15px;
            right: 20px;
            background: none;
            border: none;
            font-size: 28px;
            cursor: pointer;
            color: var(--steel);
            transition: all 0.3s;
        }

        .sizeguide-modal-box .modal-close-btn:hover {
            color: var(--signal);
            transform: rotate(90deg);
        }

        .sizeguide-modal-box h3 {
            font-family: var(--font-display);
            font-weight: 400;
            font-size: 20px;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            color: var(--ink);
            margin-bottom: 18px;
            padding-bottom: 12px;
            border-bottom: 2px solid var(--line);
        }

        .sizeguide-modal-box h3 i {
            color: var(--signal);
            margin-right: 10px;
        }

        .sizeguide-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        .sizeguide-table th {
            background: var(--ink);
            color: white;
            padding: 10px 14px;
            text-align: left;
            font-weight: 700;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .sizeguide-table td {
            padding: 8px 14px;
            border-bottom: 1px solid var(--line);
            font-size: 13px;
            color: var(--ink-soft);
            font-weight: 500;
        }

        .sizeguide-table tr:hover td {
            background: var(--fog);
        }

        /* ============================================================ */
        /* ===== NOTIFICATION ===== */
        /* ============================================================ */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 99999;
            min-width: 280px;
            padding: 14px 20px;
            border-radius: var(--radius-md);
            color: white;
            font-size: 14px;
            animation: slideInNotif 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            font-family: var(--font-body);
            font-weight: 600;
        }

        .notification.success {
            background: var(--success);
        }

        .notification.error {
            background: var(--signal);
        }

        .notification.info {
            background: var(--info);
        }

        @keyframes slideInNotif {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* ============================================================ */
        /* ===== RESPONSIVE ===== */
        /* ============================================================ */

        /* ===== TABLET (≤991px) ===== */
        @media (max-width: 991px) {
            .product-wrapper {
                flex-direction: column;
                gap: 30px;
                width: 100%;
                max-width: 100%;
                padding: 0 10px;
            }

            .left-column {
                position: static !important;
                width: 100%;
                flex: 0 0 100%;
                top: 0;
            }

            .right-column {
                width: 100%;
                flex: 0 0 100%;
                max-height: none;
                overflow-y: visible;
                padding-right: 0;
            }

            .product-gallery-wrapper {
                flex-direction: column-reverse;
            }

            .vertical-thumbnails {
                flex-direction: row;
                width: 100%;
                justify-content: flex-start;
                max-height: 100px;
                overflow-x: auto;
                overflow-y: hidden;
                gap: 8px;
                padding-bottom: 5px;
            }

            .vertical-thumb {
                width: 70px;
                height: 70px;
                flex-shrink: 0;
            }

            .main-image-area {
                height: 420px;
            }

            .right-side-content {
                padding-right: 0;
                padding-top: 10px;
            }

            .related-product-card .product-image-container {
                height: 180px;
            }

            .sizeguide-modal-box {
                width: 100%;
                max-width: 100%;
                padding: 25px;
            }

            .reviews-section {
                width: 100%;
                padding: 0 10px;
            }

            .related-products-section {
                width: 100%;
                padding: 20px 10px;
            }

            .breadcrumb-custom {
                width: 100%;
                padding: 0 10px;
            }

            .review-card {
                flex: 0 0 calc(50% - 10px);
                min-width: 250px;
            }
        }

        /* ===== MOBILE (≤767px) ===== */
        @media (max-width: 767px) {
            .product-detail-container {
                padding: 0 8px;
                margin-top: 20px;
            }

            .main-image-area {
                height: 320px;
                min-height: 280px;
            }

            .vertical-thumb {
                width: 60px;
                height: 60px;
            }

            .product-title {
                font-size: 20px;
            }

            .current-price {
                font-size: 24px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-wishlist,
            .btn-add-cart {
                width: 100%;
                flex: none;
                justify-content: center;
            }

            .related-product-card .product-image-container {
                height: 160px;
            }

            .related-product-card .product-name {
                font-size: 0.75rem;
                min-height: 30px;
            }

            .related-product-card .product-price-container .final-price {
                font-size: 0.9rem;
            }

            .related-product-card .product-brand {
                font-size: 0.6rem;
            }

            .related-product-card .color-dot {
                width: 14px;
                height: 14px;
            }

            .related-product-card .color-dot.more-colors {
                width: 14px;
                height: 14px;
                font-size: 5px;
            }

            .col-sm-6 {
                flex: 0 0 50%;
                max-width: 50%;
            }

            .sizeguide-modal-box {
                padding: 20px;
            }

            .sizeguide-modal-box h3 {
                font-size: 17px;
            }

            .sizeguide-table th,
            .sizeguide-table td {
                padding: 6px 10px;
                font-size: 12px;
            }

            .custom-modal-box {
                padding: 25px 20px;
            }

            .custom-modal-box .modal-icon {
                width: 55px;
                height: 55px;
                font-size: 1.6rem;
            }

            .custom-modal-box .modal-title {
                font-size: 1.1rem;
            }

            .review-card {
                flex: 0 0 calc(50% - 10px);
                min-width: 220px;
                padding: 16px 18px;
            }

            .review-card .review-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 2px;
            }

            .image-modal-nav {
                width: 40px;
                height: 40px;
                font-size: 30px;
            }

            .image-modal-nav.prev {
                left: 10px;
            }

            .image-modal-nav.next {
                right: 10px;
            }

            .image-modal-close {
                width: 40px;
                height: 40px;
                font-size: 30px;
                top: 15px;
                right: 15px;
            }

            .reviews-section .section-title {
                font-size: 17px;
            }

            .reviews-nav-btn {
                width: 35px;
                height: 35px;
                font-size: 14px;
            }
        }

        /* ===== SMALL MOBILE (≤575px) ===== */
        @media (max-width: 575px) {
            .product-detail-container {
                padding: 0 5px;
                margin-top: 15px;
            }

            .main-image-area {
                height: 260px;
                min-height: 240px;
            }

            .vertical-thumb {
                width: 50px;
                height: 50px;
                border-radius: var(--radius-sm);
            }

            .vertical-thumbnails {
                max-height: 80px;
                gap: 6px;
            }

            .product-title {
                font-size: 17px;
            }

            .current-price {
                font-size: 20px;
            }

            .old-price {
                font-size: 15px;
                margin-left: 6px;
            }

            .discount-badge {
                font-size: 10px;
                padding: 2px 8px;
                margin-left: 6px;
            }

            .brand-name {
                font-size: 12px;
            }

            .product-category {
                font-size: 11px;
            }

            .size-btn {
                min-width: 55px;
                padding: 6px 10px;
                font-size: 12px;
            }

            .color-btn {
                width: 32px;
                height: 32px;
            }

            .delivery-box {
                padding: 10px 14px;
            }

            .delivery-item {
                gap: 8px;
            }

            .delivery-item i {
                font-size: 14px;
                width: 20px;
            }

            .delivery-text {
                font-size: 12px;
            }

            .delivery-text strong {
                font-size: 12px;
            }

            .delivery-text small {
                font-size: 11px;
            }

            .info-tab-header {
                font-size: 12px;
                padding: 10px 14px;
            }

            .info-tab-content.show {
                padding: 12px;
                max-height: 300px;
            }

            .product-description {
                font-size: 13px;
            }

            .related-product-card .product-image-container {
                height: 130px;
            }

            .related-product-card .product-name {
                font-size: 0.7rem;
                min-height: 25px;
            }

            .related-product-card .product-price-container .final-price {
                font-size: 0.8rem;
            }

            .related-product-card .product-price-container .original-price {
                font-size: 0.7rem;
            }

            .related-product-card .product-price-container .discount-percent {
                font-size: 0.6rem;
                padding: 1px 6px;
            }

            .related-product-card .card-body {
                padding: 8px 10px 10px;
            }

            .related-product-card .color-options-container .color-label {
                font-size: 0.5rem;
            }

            .related-product-card .color-dot {
                width: 12px;
                height: 12px;
            }

            .related-product-card .color-dot.more-colors {
                width: 12px;
                height: 12px;
                font-size: 4px;
            }

            .related-product-card .product-stock-low {
                font-size: 0.6rem;
            }

            .related-product-card .product-stock-out {
                font-size: 0.6rem;
                padding: 2px 6px;
            }

            .col-sm-6 {
                flex: 0 0 50%;
                max-width: 50%;
            }

            .review-card {
                flex: 0 0 100%;
                min-width: 0;
                padding: 14px 16px;
            }

            .review-card .review-user {
                font-size: 13px;
            }

            .review-card .review-user i {
                font-size: 14px;
            }

            .review-card .review-text {
                font-size: 13px;
                min-height: 60px;
                -webkit-line-clamp: 3;
            }

            .reviews-section .section-title {
                font-size: 15px;
                gap: 8px;
            }

            .review-count-badge {
                font-size: 12px;
                padding: 1px 10px;
            }

            .related-products-section .section-title {
                font-size: 1.1rem;
            }

            .notification {
                min-width: 200px;
                font-size: 12px;
                padding: 10px 16px;
                top: 10px;
                right: 10px;
            }

            .sizeguide-modal-box {
                padding: 15px 18px;
            }

            .sizeguide-modal-box h3 {
                font-size: 15px;
            }

            .sizeguide-table th,
            .sizeguide-table td {
                padding: 5px 8px;
                font-size: 11px;
            }

            .custom-modal-box .btn-modal-primary,
            .custom-modal-box .btn-modal-secondary {
                padding: 8px 20px;
                font-size: 0.8rem;
            }

            .image-modal-nav {
                width: 35px;
                height: 35px;
                font-size: 22px;
            }

            .image-modal-nav.prev {
                left: 8px;
            }

            .image-modal-nav.next {
                right: 8px;
            }

            .image-modal-close {
                width: 35px;
                height: 35px;
                font-size: 24px;
                top: 10px;
                right: 10px;
            }

            .image-modal-counter {
                font-size: 12px;
                padding: 5px 14px;
                bottom: 20px;
            }

            .reviews-nav-btn {
                width: 30px;
                height: 30px;
                font-size: 12px;
            }

            .reviews-dot {
                width: 8px;
                height: 8px;
            }
        }

        /* ===== VERY SMALL (≤400px) ===== */
        @media (max-width: 400px) {
            .main-image-area {
                height: 220px;
                min-height: 200px;
            }

            .vertical-thumb {
                width: 42px;
                height: 42px;
            }

            .vertical-thumbnails {
                max-height: 65px;
                gap: 5px;
            }

            .product-title {
                font-size: 15px;
            }

            .current-price {
                font-size: 18px;
            }

            .old-price {
                font-size: 13px;
            }

            .size-btn {
                min-width: 48px;
                padding: 5px 8px;
                font-size: 11px;
            }

            .quantity-btn {
                width: 32px;
                height: 32px;
                font-size: 15px;
            }

            .quantity-input {
                width: 50px;
                padding: 6px;
                font-size: 13px;
            }

            .btn-wishlist,
            .btn-add-cart {
                padding: 8px 16px;
                font-size: 12px;
            }

            .related-product-card .product-image-container {
                height: 110px;
            }

            .related-product-card .product-name {
                font-size: 0.65rem;
                min-height: 20px;
            }

            .related-product-card .product-price-container .final-price {
                font-size: 0.75rem;
            }

            .related-product-card .product-brand {
                font-size: 0.5rem;
            }

            .related-product-card .card-body {
                padding: 6px 8px 8px;
            }

            .custom-modal-box {
                padding: 20px 16px;
            }

            .custom-modal-box .modal-icon {
                width: 48px;
                height: 48px;
                font-size: 1.3rem;
            }

            .custom-modal-box .modal-title {
                font-size: 1rem;
            }

            .custom-modal-box .modal-subtitle {
                font-size: 0.8rem;
            }

            .image-modal-nav {
                width: 30px;
                height: 30px;
                font-size: 18px;
            }

            .image-modal-close {
                width: 30px;
                height: 30px;
                font-size: 20px;
                top: 8px;
                right: 8px;
            }

            .review-card .review-text {
                font-size: 12px;
                min-height: 50px;
                -webkit-line-clamp: 3;
            }

            .related-product-card .color-dot {
                width: 10px;
                height: 10px;
            }

            .related-product-card .color-dot.more-colors {
                width: 10px;
                height: 10px;
                font-size: 4px;
            }
        }

        /* ============================================================ */
        /* ===== ROW GAP FIX FOR RELATED PRODUCTS ===== */
        /* ============================================================ */
        .row.gap-3 {
            --bs-gutter-y: 1rem;
        }

        @media (max-width: 767px) {
            .row.gap-3 {
                --bs-gutter-y: 0.75rem;
            }
        }

        @media (max-width: 575px) {
            .row.gap-3 {
                --bs-gutter-y: 0.5rem;
            }
        }
    </style>

    @php
        // ===== GET VARIANT DATA =====
        $variants = \App\Models\ProductVariant::where('product_id', $product->id)->get();
        $hasVariants = $variants->count() > 0;

        // ===== GET UNIQUE COLORS =====
        $colors = $hasVariants ? $variants->pluck('color')->unique()->filter()->values() : collect();
        $hasColors = $colors->count() > 0;

        // ===== GET UNIQUE SIZES =====
        $sizes = $hasVariants ? $variants->pluck('size')->unique()->filter()->values() : collect();
        $hasSizes = $sizes->count() > 0;

        // ===== GET SIZE CHART =====
        $sizeChart = null;
        $hasSizeChart = false;
        if ($product->size_chart_id) {
            $sizeChart = \App\Models\SizeChart::find($product->size_chart_id);
            $hasSizeChart = $sizeChart ? true : false;
        }

        $sizeChartSizes = [];
        if ($hasSizeChart && $sizeChart && $sizeChart->sizes) {
            if (is_string($sizeChart->sizes)) {
                $sizeChartSizes = json_decode($sizeChart->sizes, true);
                if (!is_array($sizeChartSizes)) {
                    $sizeChartSizes = [];
                }
            } elseif (is_array($sizeChart->sizes)) {
                $sizeChartSizes = $sizeChart->sizes;
            }
        }

        // ===== GET FIRST VARIANT =====
        $firstVariant = $hasVariants ? $variants->first() : null;

        // ===== GET BRAND NAME =====
        $brandName = $product->brand ? $product->brand->name : null;
        $hasBrand = !empty($brandName);

        // ===== DETERMINE PRICE =====
        if ($hasVariants && $firstVariant) {
            $displayPrice = floatval($firstVariant->final_price ?? ($firstVariant->price ?? 0));
            $displayMrp = floatval($firstVariant->total_price ?? ($firstVariant->mrp ?? ($firstVariant->price ?? 0)));
            $displayStock = $variants->sum('stock');
            $discountType = $firstVariant->discount_type ?? 'flat';
            $discountValue = floatval($firstVariant->discount_value ?? 0);
        } else {
            $displayPrice = floatval($product->final_price ?? ($product->price ?? 0));
            $displayMrp = floatval($product->total_price ?? ($product->mrp ?? ($product->price ?? 0)));
            $displayStock = intval($product->stock ?? 0);
            $discountType = $product->discount_type ?? 'flat';
            $discountValue = floatval($product->discount_value ?? 0);
        }

        $discountPercent = 0;
        if ($displayMrp > 0 && $displayPrice > 0 && $displayPrice < $displayMrp) {
            $discountPercent = round((($displayMrp - $displayPrice) / $displayMrp) * 100);
        }

        $discountAmount = $displayMrp - $displayPrice;
        if ($discountAmount < 0) {
            $discountAmount = 0;
        }

        $discountBadgeText = '';
        if ($discountValue > 0 && $discountPercent > 0) {
            if ($discountType === 'flat') {
                $discountBadgeText = '₹' . number_format($discountValue, 2) . ' OFF';
            } else {
                $discountBadgeText = $discountPercent . '% OFF';
            }
        } elseif ($discountPercent > 0) {
            $discountBadgeText = $discountPercent . '% OFF';
        }

        // ===== GET PRODUCT IMAGES =====
        // ===== GET PRODUCT IMAGES - ONLY FOR FIRST COLOR =====
        $allImages = \App\Models\ProductImage::where('product_id', $product->id)->orderBy('display_order')->get();

        // NEW: Get only images for the first color
        $firstColorImages = collect();
        $firstColorName = null;

        if ($hasColors && $colors->count() > 0) {
            $firstColor = $colors->first();
            $firstColorName = $firstColor;
            $firstColorVariant = $variants->where('color', $firstColor)->first();

            if ($firstColorVariant) {
                $firstColorImages = \App\Models\ProductImage::where('product_id', $product->id)
                    ->where('variant_id', $firstColorVariant->id)
                    ->orderBy('display_order')
                    ->get();
            }
        }

        // If no color-specific images found, use all images
        if ($firstColorImages->count() == 0) {
            if ($allImages->count() > 0) {
                $firstColorImages = $allImages;
            } elseif ($product->image) {
                $firstColorImages = collect([(object) ['image_path' => $product->image, 'is_main' => 1]]);
            }
        }

        // If still no images, use placeholder
        if ($firstColorImages->count() == 0) {
            $firstColorImages = collect([
                (object) ['image_path' => 'https://via.placeholder.com/500x500?text=No+Image', 'is_main' => 1],
            ]);
        }

        $allImages = $firstColorImages;

        // ===== BUILD VARIANT DATA =====
        $variantDataArray = [];
        foreach ($variants as $v) {
            $variantPrice = floatval($v->final_price ?? ($v->price ?? 0));
            $variantMrp = floatval($v->total_price ?? ($v->mrp ?? ($v->price ?? 0)));
            $variantDiscountPercent = 0;
            if ($variantMrp > 0 && $variantPrice > 0 && $variantPrice < $variantMrp) {
                $variantDiscountPercent = round((($variantMrp - $variantPrice) / $variantMrp) * 100);
            }

            $variantDataArray[] = [
                'id' => $v->id,
                'size' => $v->size,
                'color' => $v->color,
                'price' => $variantPrice,
                'mrp' => $variantMrp,
                'stock' => intval($v->stock ?? 0),
                'discount_percent' => $variantDiscountPercent,
                'discount_type' => $v->discount_type ?? 'flat',
                'discount_value' => floatval($v->discount_value ?? 0),
            ];
        }

        // ===== BUILD COLOR DATA =====
        $colorDataArray = [];
        foreach ($colors as $color) {
            $colorVariants = $variants->where('color', $color);
            $firstColorVariant = $colorVariants->first();

            $colorImages = \App\Models\ProductImage::where('product_id', $product->id)
                ->where('variant_id', $firstColorVariant->id)
                ->orderBy('display_order')
                ->get();

            $colorImagePaths = [];
            if ($colorImages->count() > 0) {
                foreach ($colorImages as $img) {
                    $colorImagePaths[] = asset('storage/' . $img->image_path);
                }
            } else {
                foreach ($allImages as $img) {
                    $colorImagePaths[] = asset('storage/' . $img->image_path);
                }
            }

            $colorDataArray[] = [
                'name' => $color,
                'variants' => $colorVariants->pluck('id')->toArray(),
                'images' => $colorImagePaths,
            ];
        }

        // ===== BUILD ALL IMAGE PATHS FOR MODAL =====
        $allImagePaths = [];
        foreach ($allImages as $img) {
            $allImagePaths[] = asset('storage/' . $img->image_path);
        }
    @endphp

    <!-- ============================================================ -->
    <!-- ===== HTML CONTENT ===== -->
    <!-- ============================================================ -->
    <div class="container-fluid product-detail-container">
        <!-- BREADCRUMB -->
        <nav aria-label="breadcrumb" class="breadcrumb-custom">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('shop') }}">Shop</a></li>
                <li class="breadcrumb-item"><a href="#">{{ $product->category->name ?? 'Products' }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($product->name, 40) }}</li>
            </ol>
        </nav>

        <!-- ===== PRODUCT WRAPPER ===== -->
        <div class="product-wrapper">
            <!-- LEFT COLUMN - STICKY IMAGE -->
            <div class="left-column">
                <div class="product-gallery-wrapper">
                    <div class="vertical-thumbnails" id="verticalThumbnails">
                        @foreach ($allImages as $index => $img)
                            <div class="vertical-thumb {{ $index == 0 ? 'active' : '' }}" data-index="{{ $index }}"
                                onclick="changeMainImage({{ $index }})">
                                <img src="{{ asset('storage/' . $img->image_path) }}" alt="Thumbnail {{ $index + 1 }}">
                            </div>
                        @endforeach
                    </div>

                    <div class="main-image-area" id="mainImageArea" onclick="openImageModal({{ $currentIndex ?? 0 }})">
                        <img id="mainImage" class="main-image"
                            src="{{ asset('storage/' . ($allImages[0]->image_path ?? 'https://via.placeholder.com/500x500')) }}"
                            alt="Product Image">
                        @if ($allImages->count() > 1)
                            <div class="nav-arrows">
                                <div class="nav-arrow" onclick="event.stopPropagation(); prevImage()">❮</div>
                                <div class="nav-arrow" onclick="event.stopPropagation(); nextImage()">❯</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN -->
            <div class="right-column">
                <div class="right-side-content">
                    <!-- BRAND -->
                    @if ($hasBrand)
                        <div class="brand-name"><i class="fas fa-building"></i> {{ $brandName }}</div>
                    @endif

                    <h1 class="product-title">{{ $product->name }}</h1>
                    <p class="product-category"><i class="fas fa-tag"></i>
                        {{ $product->category ? $product->category->name : 'Uncategorized' }}</p>

                    <!-- RATING -->
                    <div class="rating">
                        <span class="stars">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            <i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                        </span>
                    </div>

                    <!-- PRICE -->
                    <div class="price-section">
                        @if ($discountPercent > 0)
                            <span class="current-price" id="displayPrice">₹{{ number_format($displayPrice, 2) }}</span>
                            <span class="old-price" id="displayMrp">₹{{ number_format($displayMrp, 2) }}</span>
                            <span class="discount-badge" id="discountBadge">{{ $discountBadgeText }}</span>
                            <div class="you-save-text">
                                <i class="fas fa-tag"></i> You save ₹{{ number_format($discountAmount, 2) }}
                            </div>
                        @else
                            <span class="current-price" id="displayPrice">₹{{ number_format($displayPrice, 2) }}</span>
                        @endif
                        <div class="tax-text">Inclusive of all taxes</div>
                        @if ($hasVariants)
                            <div class="variant-info">
                                <i class="fas fa-palette"></i> {{ $variants->count() }} variants available
                            </div>
                        @endif
                        @if ($hasColors)
                            <div class="variant-info">
                                <i class="fas fa-paint-bucket"></i> {{ $colors->count() }} colors available
                            </div>
                        @endif
                    </div>

                    <!-- COLOR -->
                    @if ($hasColors)
                        <div class="color-section">
                            <div class="color-header">
                                <span class="color-label">Select Color</span>
                            </div>
                            <div class="color-options" id="colorOptions">
                                @foreach ($colors as $color)
                                    @php
                                        $isFirst = $loop->first;
                                        $colorVariant = $variants->where('color', $color)->first();
                                        $colorImages = \App\Models\ProductImage::where('product_id', $product->id)
                                            ->where('variant_id', $colorVariant->id)
                                            ->orderBy('display_order')
                                            ->get();
                                        $colorImage =
                                            $colorImages->count() > 0
                                                ? asset('storage/' . $colorImages->first()->image_path)
                                                : asset('storage/' . ($allImages[0]->image_path ?? ''));
                                        $isLightColor = in_array(strtolower($color), [
                                            'white',
                                            'yellow',
                                            'pink',
                                            'lightblue',
                                            'lightgreen',
                                            'cream',
                                            'beige',
                                            'ivory',
                                            'gold',
                                        ]);
                                    @endphp
                                    <div class="color-btn {{ $isFirst ? 'selected' : '' }}"
                                        data-color="{{ $color }}"
                                        data-images="{{ json_encode(
                                            $colorImages->count() > 0
                                                ? $colorImages->pluck('image_path')->map(function ($p) {
                                                        return asset('storage/' . $p);
                                                    })->toArray()
                                                : $allImages->pluck('image_path')->map(function ($p) {
                                                        return asset('storage/' . $p);
                                                    })->toArray(),
                                        ) }}"
                                        onclick="selectColor(this, '{{ $color }}')"
                                        style="background: {{ $color }}; {{ $isLightColor ? 'border: 3px solid #ddd;' : '' }}">
                                        <span class="check-mark"><i class="fas fa-check"></i></span>
                                        <span class="color-name-tooltip">{{ ucfirst($color) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- SIZE -->
                    @if ($hasSizes || $hasSizeChart)
                        <div class="size-section">
                            <div class="size-header">
                                <span class="size-label">Select Size</span>
                                @if ($hasSizeChart)
                                    <a href="#" class="size-guide" onclick="openSizeGuide(event)">Size Guide</a>
                                @endif
                            </div>
                            <div class="size-options" id="sizeOptions">
                                @if ($hasSizes)
                                    @foreach ($sizes as $size)
                                        @php
                                            $sizeVariant = $variants->where('size', $size)->first();
                                            $variantStock = $sizeVariant ? intval($sizeVariant->stock ?? 0) : 0;
                                            $isOutOfStock = $variantStock <= 0;
                                            $variantPrice = $sizeVariant
                                                ? floatval($sizeVariant->final_price ?? ($sizeVariant->price ?? 0))
                                                : 0;
                                            $variantMrp = $sizeVariant
                                                ? floatval(
                                                    $sizeVariant->total_price ??
                                                        ($sizeVariant->mrp ?? ($sizeVariant->price ?? 0)),
                                                )
                                                : 0;
                                            $variantDiscountPercent = 0;
                                            if ($variantMrp > 0 && $variantPrice > 0 && $variantPrice < $variantMrp) {
                                                $variantDiscountPercent = round(
                                                    (($variantMrp - $variantPrice) / $variantMrp) * 100,
                                                );
                                            }
                                            $variantDiscountType = $sizeVariant->discount_type ?? 'flat';
                                            $variantDiscountValue = floatval($sizeVariant->discount_value ?? 0);
                                            $variantDiscountText = '';
                                            if ($variantDiscountValue > 0 && $variantDiscountPercent > 0) {
                                                if ($variantDiscountType === 'flat') {
                                                    $variantDiscountText =
                                                        '₹' . number_format($variantDiscountValue, 2) . ' off';
                                                } else {
                                                    $variantDiscountText = $variantDiscountPercent . '% off';
                                                }
                                            } elseif ($variantDiscountPercent > 0) {
                                                $variantDiscountText = $variantDiscountPercent . '% off';
                                            }
                                        @endphp
                                        <button type="button"
                                            class="size-btn {{ $loop->first && !$hasColors ? 'selected' : '' }} {{ $isOutOfStock ? 'out-of-stock-size' : '' }}"
                                            data-size="{{ $size }}" data-variant-id="{{ $sizeVariant->id ?? '' }}"
                                            data-price="{{ $variantPrice }}" data-mrp="{{ $variantMrp }}"
                                            data-discount="{{ $variantDiscountPercent }}" data-stock="{{ $variantStock }}"
                                            data-discount-type="{{ $variantDiscountType }}"
                                            data-discount-value="{{ $variantDiscountValue }}" onclick="selectSize(this)"
                                            {{ $isOutOfStock ? 'disabled' : '' }}>
                                            {{ $size }}
                                            @if ($variantDiscountPercent > 0)
                                                <span class="discount-text">-{{ $variantDiscountText }}</span>
                                            @endif
                                        </button>
                                    @endforeach
                                @else
                                    @php
                                        $defaultSizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
                                    @endphp
                                    @foreach ($defaultSizes as $size)
                                        <button type="button" class="size-btn" data-size="{{ $size }}"
                                            onclick="selectDefaultSize(this)">
                                            {{ $size }}
                                        </button>
                                    @endforeach
                                @endif
                            </div>
                            <div id="sizeWarning" class="size-warning">Please select a size first</div>
                            <div id="sizeStockInfo" class="size-stock-info">
                                <i class="fas fa-box"></i> <span id="sizeStockCount">0</span> items in stock
                            </div>
                        </div>
                    @endif

                    <!-- QUANTITY -->
                    <div class="quantity-section">
                        <label class="quantity-label">Quantity</label>
                        <div class="quantity-selector">
                            <button class="quantity-btn" onclick="decrementQuantity()">-</button>
                            <input type="number" id="quantity" class="quantity-input" value="1" min="1"
                                max="{{ $displayStock > 0 ? $displayStock : 10 }}">
                            <button class="quantity-btn" onclick="incrementQuantity()">+</button>
                        </div>
                    </div>

                    <!-- STOCK STATUS -->
                    @if ($displayStock > 0 && $displayStock <= 5)
                        <div class="stock-status">
                            <span class="in-stock-low" id="stockStatus">
                                <i class="fas fa-exclamation-triangle"></i> Only {{ $displayStock }} left in stock!
                            </span>
                        </div>
                    @elseif ($displayStock == 0)
                        <div class="stock-status">
                            <span class="out-of-stock" id="stockStatus">
                                <i class="fas fa-times-circle"></i> Out of Stock
                            </span>
                        </div>
                    @endif

                    <!-- ACTION BUTTONS -->
                    <div class="action-buttons">
                        <button class="btn-wishlist" id="wishlistBtn" onclick="toggleWishlistDetail()">
                            <i class="far fa-heart"></i> Wishlist
                        </button>
                        <button class="btn-add-cart" id="addToCartBtn" onclick="addToCartDetail()">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                    </div>

                    <!-- DELIVERY BOX -->
                    <div class="delivery-box">
                        <div class="delivery-item">
                            <i class="fas fa-truck"></i>
                            <div class="delivery-text">
                                <strong>CASH ON DELIVERY</strong>
                                <small class="{{ $product->cod_available ? 'cod-available' : 'cod-not-available' }}">
                                    {{ $product->cod_available ? '✅ Available' : '❌ Not Available' }}
                                </small>
                            </div>
                        </div>
                        <div class="delivery-item">
                            <i class="fas fa-undo-alt"></i>
                            <div class="delivery-text">
                                <strong>RETURN & EXCHANGE</strong>
                                <small>{{ $product->return_days ?? 30 }}-day return & exchange</small>
                            </div>
                        </div>
                        <div class="delivery-item">
                            <i class="fas fa-clock"></i>
                            <div class="delivery-text">
                                <strong>DELIVERY</strong>
                                <small>{{ $product->delivery_days ?? 3 }} days delivery</small>
                            </div>
                        </div>
                    </div>

                    <!-- OFFERS -->
                    @if (isset($product->offers) && $product->offers->count() > 0)
                        <div
                            style="background: #fff3cd; border: 1px solid #ffc107; border-radius: var(--radius-sm); padding: 12px 15px; margin-bottom: 16px;">
                            <strong style="color: #856404;"><i class="fas fa-tags"></i> Special Offers</strong>
                            <ul style="margin: 6px 0 0 0; padding-left: 20px; color: #856404; font-size: 13px;">
                                @foreach ($product->offers as $offer)
                                    <li>{{ $offer->title ?? ($offer->name ?? 'Offer') }} - {{ $offer->discount }}% off
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- PRODUCT INFO TABS -->
                    <div class="product-info-tabs">
                        <div class="info-tab">
                            <div class="info-tab-header active" onclick="toggleTab(this)">
                                <span><i class="fas fa-info-circle"></i> PRODUCT DETAILS</span>
                                <span class="arrow">▼</span>
                            </div>
                            <div class="info-tab-content show">
                                <div class="product-description">
                                    @php
                                        $description = $product->description ?? '';
                                        if (!empty($description)) {
                                            $formatted = nl2br(e($description));
                                            echo $formatted;
                                        } else {
                                            echo '<p>No description available</p>';
                                        }
                                    @endphp
                                </div>
                                @if ($product->short_description)
                                    <div class="alert alert-light mt-2 p-2" style="border-radius:var(--radius-sm);">
                                        <strong>Highlights:</strong>
                                        <p class="mb-0">{{ $product->short_description }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="info-tab">
                            <div class="info-tab-header" onclick="toggleTab(this)">
                                <span><i class="fas fa-undo-alt"></i> RETURN & EXCHANGE</span>
                                <span class="arrow">▼</span>
                            </div>
                            <div class="info-tab-content">
                                <p>You can return this product within {{ $product->return_days ?? 30 }} days of delivery.
                                </p>
                                <p><strong>Exchange Available:</strong> Yes</p>
                                <p>Exchange within {{ $product->return_days ?? 30 }} days of delivery.</p>
                                <p><strong>Conditions:</strong> Product must be unused and in original packaging.</p>
                                <hr>
                                <h6>How to Return?</h6>
                                <ol>
                                    <li>Go to your orders section</li>
                                    <li>Select the product you want to return</li>
                                    <li>Choose return reason</li>
                                    <li>Schedule a pickup</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== RELATED PRODUCTS - RESPONSIVE 2 PER ROW ON MOBILE ===== -->
        @if (isset($relatedProducts) && $relatedProducts->count() > 0)
            <div class="related-products-section">
                <h3 class="section-title"><i class="fas fa-sync-alt"></i> You May Also Like</h3>
                <div class="row">
                    @foreach ($relatedProducts as $related)
                        @php
                            $relatedImages = \App\Models\ProductImage::where('product_id', $related->id)
                                ->orderBy('display_order')
                                ->get();
                            $relatedImageUrls = [];
                            if ($relatedImages->count() > 0) {
                                foreach ($relatedImages as $img) {
                                    $relatedImageUrls[] = asset('storage/' . $img->image_path);
                                }
                            } elseif ($related->image) {
                                $relatedImageUrls[] = asset('storage/' . $related->image);
                            } else {
                                $relatedImageUrls[] = 'https://via.placeholder.com/300x300?text=No+Image';
                            }

                            $relatedVariants = \App\Models\ProductVariant::where('product_id', $related->id)->get();
                            $hasRelatedVariants = $relatedVariants->count() > 0;

                            if ($hasRelatedVariants && $relatedVariants->first()) {
                                $firstVariant = $relatedVariants->first();
                                $relatedDisplayPrice = floatval(
                                    $firstVariant->final_price ?? ($firstVariant->price ?? 0),
                                );
                                $relatedMrp = floatval(
                                    $firstVariant->total_price ?? ($firstVariant->mrp ?? ($firstVariant->price ?? 0)),
                                );
                                $relatedStock = $relatedVariants->sum('stock');
                                $relatedDiscountType = $firstVariant->discount_type ?? 'flat';
                                $relatedDiscountValue = floatval($firstVariant->discount_value ?? 0);
                                $relatedColors = $relatedVariants
                                    ->pluck('color')
                                    ->unique()
                                    ->filter()
                                    ->values()
                                    ->toArray();
                            } else {
                                $relatedDisplayPrice = floatval($related->final_price ?? ($related->price ?? 0));
                                $relatedMrp = floatval(
                                    $related->total_price ?? ($related->mrp ?? ($related->price ?? 0)),
                                );
                                $relatedStock = intval($related->stock ?? 0);
                                $relatedDiscountType = $related->discount_type ?? 'flat';
                                $relatedDiscountValue = floatval($related->discount_value ?? 0);
                                $relatedColors = [];
                            }

                            $relatedDiscountPercent = 0;
                            if ($relatedMrp > 0 && $relatedDisplayPrice > 0 && $relatedDisplayPrice < $relatedMrp) {
                                $relatedDiscountPercent = round(
                                    (($relatedMrp - $relatedDisplayPrice) / $relatedMrp) * 100,
                                );
                            }

                            $relatedBrandName = $related->brand ? $related->brand->name : null;
                            $hasRelatedBrand = !empty($relatedBrandName);

                            $relatedDiscountText = '';
                            if ($relatedDiscountValue > 0 && $relatedDiscountPercent > 0) {
                                if ($relatedDiscountType === 'flat') {
                                    $relatedDiscountText = '₹' . number_format($relatedDiscountValue, 2) . ' off';
                                } else {
                                    $relatedDiscountText = $relatedDiscountPercent . '% off';
                                }
                            } elseif ($relatedDiscountPercent > 0) {
                                $relatedDiscountText = $relatedDiscountPercent . '% off';
                            }

                            $relatedStockAlert = '';
                            if ($relatedStock <= 5 && $relatedStock > 0) {
                                $relatedStockAlert =
                                    '<div class="product-stock-low"><i class="fas fa-exclamation-triangle"></i> Only ' .
                                    $relatedStock .
                                    ' left in stock!</div>';
                            } elseif ($relatedStock === 0) {
                                $relatedStockAlert =
                                    '<div class="product-stock-out"><i class="fas fa-times-circle"></i> Out of Stock</div>';
                            }

                            $relatedColorHtml = '';
                            $totalRelatedColors = count($relatedColors);
                            if ($totalRelatedColors > 0) {
                                $displayColors = array_slice($relatedColors, 0, 4);
                                $remaining = $totalRelatedColors - 4;
                                $relatedColorHtml = '<div class="color-options-container">';
                                $relatedColorHtml .=
                                    '<span class="color-label">' .
                                    $totalRelatedColors .
                                    ' Color' .
                                    ($totalRelatedColors > 1 ? 's' : '') .
                                    ':</span>';
                                foreach ($displayColors as $color) {
                                    $relatedColorHtml .=
                                        '<span class="color-dot" style="background: ' .
                                        strtolower($color) .
                                        ';" title="' .
                                        $color .
                                        '"></span>';
                                }
                                if ($remaining > 0) {
                                    $relatedColorHtml .=
                                        '<span class="color-dot more-colors">+' . $remaining . '</span>';
                                }
                                $relatedColorHtml .= '</div>';
                            }
                        @endphp
                        <div class="col-md-3 col-sm-6 mb-4">
                            <div class="related-product-card"
                                onclick="window.location.href='/product/{{ $related->id }}'">
                                @if ($relatedDiscountPercent > 0)
                                @endif
                                <button class="wishlist-btn"
                                    onclick="event.stopPropagation(); toggleRelatedWishlist({{ $related->id }}, '{{ addslashes($related->name) }}', {{ $relatedDisplayPrice }}, '{{ $relatedImageUrls[0] ?? '' }}')">
                                    <i class="far fa-heart" id="related-wishlist-icon-{{ $related->id }}"></i>
                                </button>
                                <div class="product-image-container">
                                    <img src="{{ $relatedImageUrls[0] ?? 'https://via.placeholder.com/300x300?text=No+Image' }}"
                                        alt="{{ $related->name }}" loading="lazy"
                                        onerror="this.src='https://via.placeholder.com/300x300?text=No+Image'">
                                </div>
                                <div class="card-body">
                                    @if ($hasRelatedBrand)
                                        <div class="product-brand"><i class="fas fa-tag"></i> {{ $relatedBrandName }}
                                        </div>
                                    @endif
                                    <div class="product-name">{{ $related->name }}</div>
                                    <div class="product-price-container">
                                        <span class="final-price">₹{{ number_format($relatedDisplayPrice, 2) }}</span>
                                        @if ($relatedDiscountPercent > 0)
                                            <span class="original-price">₹{{ number_format($relatedMrp, 2) }}</span>
                                            <span class="discount-percent">{{ $relatedDiscountText }}</span>
                                        @endif
                                    </div>
                                    {!! $relatedColorHtml !!}
                                    {!! $relatedStockAlert !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- ============================================================ -->
        <!-- ===== REVIEWS SECTION - CAROUSEL ===== -->
        <!-- ============================================================ -->
        <div class="reviews-section" id="reviewsSection">
            <div class="section-title">
                <i class="fas fa-star"></i> Customer Reviews
                <span class="review-count-badge" id="reviewCountBadge">0</span>
            </div>
            <div id="reviewsContainer">
                <div id="reviewsLoading" style="text-align: center; padding: 30px;">
                    <div class="spinner-border text-danger" role="status" style="width: 30px; height: 30px;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted" style="font-size: 14px; font-weight: 500;">Loading reviews...</p>
                </div>
                <div id="reviewsList"></div>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- ===== FULL SCREEN IMAGE MODAL ===== -->
    <!-- ============================================================ -->
    <div class="image-modal-overlay" id="imageModalOverlay">
        <button class="image-modal-close" onclick="closeImageModal()">&times;</button>
        <button class="image-modal-nav prev" onclick="changeModalImage(-1)">❮</button>
        <button class="image-modal-nav next" onclick="changeModalImage(1)">❯</button>
        <div class="image-modal-content" id="imageModalContent">
            <img id="modalDisplayImage" src="" alt="Product Image">
            <video id="modalDisplayVideo" controls
                style="display:none; max-width:90vw; max-height:85vh; border-radius:var(--radius-sm); background:#000;"></video>
        </div>
        <div class="image-modal-counter" id="imageModalCounter">1 / 1</div>
    </div>

    <!-- ============================================================ -->
    <!-- ===== OTHER MODALS ===== -->
    <!-- ============================================================ -->

    <!-- SIZE GUIDE MODAL -->
    <div class="sizeguide-modal-overlay" id="sizeGuideModalOverlay">
        <div class="sizeguide-modal-box">
            <button class="modal-close-btn" onclick="closeSizeGuide()">&times;</button>
            <h3><i class="fas fa-tshirt"></i> Size Guide</h3>
            <table class="sizeguide-table">
                <thead>
                    <tr>
                        <th>Size</th>
                        <th>Chest (inches)</th>
                        <th>Length (inches)</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($sizeChartSizes) && is_array($sizeChartSizes))
                        @foreach ($sizeChartSizes as $sizeData)
                            <tr>
                                <td>{{ $sizeData['size'] ?? ($sizeData->size ?? '-') }}</td>
                                <td>{{ $sizeData['chest'] ?? ($sizeData->chest ?? '-') }}</td>
                                <td>{{ $sizeData['length'] ?? ($sizeData->length ?? '-') }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>XS</td>
                            <td>34-36</td>
                            <td>27</td>
                        </tr>
                        <tr>
                            <td>S</td>
                            <td>36-38</td>
                            <td>28</td>
                        </tr>
                        <tr>
                            <td>M</td>
                            <td>38-40</td>
                            <td>29</td>
                        </tr>
                        <tr>
                            <td>L</td>
                            <td>40-42</td>
                            <td>30</td>
                        </tr>
                        <tr>
                            <td>XL</td>
                            <td>42-44</td>
                            <td>31</td>
                        </tr>
                        <tr>
                            <td>XXL</td>
                            <td>44-46</td>
                            <td>32</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- LOGIN MODAL -->
    <div class="custom-modal-overlay" id="loginModal">
        <div class="custom-modal-box">
            <button class="modal-close" onclick="closeLoginModal()">✕</button>
            <div class="modal-icon"><i class="fas fa-lock"></i></div>
            <h2 class="modal-title">Login Required</h2>
            <p class="modal-subtitle">
                Please login to your account to continue.<br>
                <span>Don't have an account? Register now!</span>
            </p>
            <div class="modal-buttons">
                <a href="{{ route('login') }}" class="btn-modal-primary">
                    <i class="fas fa-sign-in-alt me-2"></i> Login Now
                </a>
                <button class="btn-modal-secondary" onclick="closeLoginModal()">
                    <i class="fas fa-times me-2"></i> Cancel
                </button>
            </div>
            <div class="register-link">
                <i class="fas fa-user-plus me-1"></i>
                <a href="{{ route('member.register') }}">Create new account</a>
            </div>
        </div>
    </div>

    <!-- REVIEW MEDIA LIGHTBOX -->
    <div class="modal fade" id="reviewMediaLightbox" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content"
                style="background: rgba(20,22,26,0.95); border: none; border-radius: var(--radius-lg);">
                <div class="modal-body text-center p-0">
                    <button type="button" class="btn-close btn-close-white position-absolute"
                        style="top: 15px; right: 15px; z-index: 10;" data-bs-dismiss="modal"></button>
                    <div id="reviewLightboxContent"
                        style="max-height: 90vh; display: flex; align-items: center; justify-content: center; padding: 20px;">
                        <img id="reviewLightboxImage" src="" alt="Review Media"
                            style="max-width: 90vw; max-height: 85vh; border-radius: var(--radius-sm);">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- ===== JAVASCRIPT ===== -->
    <!-- ============================================================ -->
    <script>
        // ===== VARIABLE DECLARATIONS =====
        let currentIndex = 0;
        let totalImages = {{ $allImages->count() }};
        const images = @json(
            $allImages->map(function ($img) {
                return asset('storage/' . $img->image_path);
            }));

        const allImagePaths = @json($allImagePaths);
        let modalCurrentIndex = 0;
        let modalImages = @json($allImagePaths);

        const productId = {{ $product->id }};
        const productName = "{{ addslashes($product->name) }}";
        const productImage = "{{ asset('storage/' . ($allImages[0]->image_path ?? $product->image)) }}";
        let selectedSize = null;
        let selectedColor = null;
        let selectedVariantId = null;
        let selectedPrice = {{ $displayPrice }};
        let selectedMrp = {{ $displayMrp }};
        let selectedStock = {{ $displayStock }};
        let selectedDiscount = {{ $discountPercent }};
        const hasVariants = {{ $hasVariants ? 'true' : 'false' }};
        const hasColors = {{ $hasColors ? 'true' : 'false' }};
        const hasSizes = {{ $hasSizes ? 'true' : 'false' }};

        const variantData = @json($variantDataArray);
        const colorData = @json($colorDataArray);

        // ===== REVIEWS CAROUSEL VARIABLES =====
        let reviewsData = [];
        let currentReviewIndex = 0;
        let reviewsPerPage = 3;
        let totalReviewPages = 0;

        // ================================================================
        // ===== FULL SCREEN IMAGE MODAL =====
        // ================================================================
        function openImageModal(index) {
            modalCurrentIndex = index || 0;
            modalImages = @json($allImagePaths);
            showModalImage(modalCurrentIndex);
            document.getElementById('imageModalOverlay').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal() {
            document.getElementById('imageModalOverlay').classList.remove('active');
            document.body.style.overflow = '';
            const video = document.getElementById('modalDisplayVideo');
            if (video) {
                video.pause();
                video.style.display = 'none';
            }
            const img = document.getElementById('modalDisplayImage');
            if (img) {
                img.style.display = 'block';
            }
        }

        function showModalImage(index) {
            const img = document.getElementById('modalDisplayImage');
            const video = document.getElementById('modalDisplayVideo');
            const counter = document.getElementById('imageModalCounter');

            if (!modalImages || modalImages.length === 0) return;

            const isVideo = modalImages[index].match(/\.(mp4|webm|ogg|mov)$/i);

            if (isVideo) {
                img.style.display = 'none';
                video.style.display = 'block';
                video.src = modalImages[index];
                video.load();
            } else {
                img.style.display = 'block';
                video.style.display = 'none';
                video.pause();
                img.src = modalImages[index];
            }

            counter.textContent = (index + 1) + ' / ' + modalImages.length;

            const prevBtn = document.querySelector('.image-modal-nav.prev');
            const nextBtn = document.querySelector('.image-modal-nav.next');
            if (prevBtn) prevBtn.style.display = modalImages.length > 1 ? 'flex' : 'none';
            if (nextBtn) nextBtn.style.display = modalImages.length > 1 ? 'flex' : 'none';
        }

        function changeModalImage(direction) {
            const newIndex = modalCurrentIndex + direction;
            if (newIndex >= 0 && newIndex < modalImages.length) {
                modalCurrentIndex = newIndex;
                showModalImage(modalCurrentIndex);
            }
        }

        // ================================================================
        // ===== SIZE GUIDE =====
        // ================================================================
        function openSizeGuide(event) {
            event.preventDefault();
            document.getElementById('sizeGuideModalOverlay').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeSizeGuide() {
            document.getElementById('sizeGuideModalOverlay').classList.remove('active');
            document.body.style.overflow = '';
        }

        // ================================================================
        // ===== SELECT COLOR =====
        // ================================================================
        function selectColor(element, color) {
            document.querySelectorAll('.color-btn').forEach(btn => btn.classList.remove('selected'));
            element.classList.add('selected');
            selectedColor = color;

            // Get images for this color from the data attribute
            const imagesData = JSON.parse(element.dataset.images);

            if (imagesData && imagesData.length > 0) {
                // Update main image - ONLY show this color's first image
                document.getElementById('mainImage').src = imagesData[0];

                // Update modal images
                modalImages = imagesData;

                // Update thumbnails - ONLY show images for this color
                const thumbnailsContainer = document.getElementById('verticalThumbnails');
                thumbnailsContainer.innerHTML = '';

                imagesData.forEach((imgUrl, index) => {
                    const thumb = document.createElement('div');
                    thumb.className = 'vertical-thumb' + (index === 0 ? ' active' : '');
                    thumb.dataset.index = index;
                    thumb.onclick = function() {
                        changeMainImage(index);
                    };
                    thumb.innerHTML = `<img src="${imgUrl}" alt="Thumbnail ${index + 1}">`;
                    thumbnailsContainer.appendChild(thumb);
                });

                // Update image array and total count
                totalImages = imagesData.length;
                currentIndex = 0;

                // Clear and refill images array
                images.length = 0;
                imagesData.forEach(img => images.push(img));
            }

            // Update sizes for this color
            updateSizesForColor(color);
        }

        // ================================================================
        // ===== UPDATE SIZES FOR COLOR =====
        // ================================================================
        function updateSizesForColor(color) {
            const sizeOptions = document.getElementById('sizeOptions');
            if (!sizeOptions) return;

            const colorVariants = variantData.filter(v => v.color === color);

            if (colorVariants.length > 0) {
                sizeOptions.innerHTML = '';
                colorVariants.forEach((variant, index) => {
                    const isOutOfStock = variant.stock <= 0;
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'size-btn' + (index === 0 ? ' selected' : '') + (isOutOfStock ?
                        ' out-of-stock-size' : '');
                    btn.dataset.size = variant.size;
                    btn.dataset.variantId = variant.id;
                    btn.dataset.price = variant.price;
                    btn.dataset.mrp = variant.mrp;
                    btn.dataset.discount = variant.discount_percent;
                    btn.dataset.stock = variant.stock;
                    btn.dataset.discountType = variant.discount_type;
                    btn.dataset.discountValue = variant.discount_value;
                    btn.onclick = function() {
                        selectSize(this);
                    };
                    btn.disabled = isOutOfStock;

                    let html = variant.size;
                    if (variant.discount_percent > 0) {
                        let discountText = '';
                        if (variant.discount_type === 'flat') {
                            discountText = '₹' + variant.discount_value.toFixed(2) + ' off';
                        } else {
                            discountText = variant.discount_percent + '% off';
                        }
                        html += `<span class="discount-text">-${discountText}</span>`;
                    }
                    btn.innerHTML = html;
                    sizeOptions.appendChild(btn);
                });

                const firstSizeBtn = sizeOptions.querySelector('.size-btn:not(.out-of-stock-size)');
                if (firstSizeBtn) selectSize(firstSizeBtn);
            }
        }

        // ================================================================
        // ===== SELECT SIZE =====
        // ================================================================
        function selectSize(button) {
            document.querySelectorAll('.size-btn').forEach(btn => btn.classList.remove('selected'));
            button.classList.add('selected');

            selectedSize = button.dataset.size;
            selectedVariantId = button.dataset.variantId;
            selectedPrice = parseFloat(button.dataset.price);
            selectedMrp = parseFloat(button.dataset.mrp);
            selectedStock = parseInt(button.dataset.stock);
            selectedDiscount = parseInt(button.dataset.discount);

            const quantityInput = document.getElementById('quantity');
            if (quantityInput) {
                quantityInput.max = selectedStock > 0 ? selectedStock : 1;
                if (parseInt(quantityInput.value) > selectedStock) {
                    quantityInput.value = selectedStock > 0 ? selectedStock : 1;
                }
            }

            updatePriceDisplay(selectedPrice, selectedMrp, selectedDiscount, button);
            updateStockDisplay(selectedStock);

            const stockInfo = document.getElementById('sizeStockInfo');
            const stockCount = document.getElementById('sizeStockCount');
            if (stockInfo) {
                stockInfo.style.display = 'block';
                stockCount.textContent = selectedStock > 0 ? selectedStock : '0';
                stockCount.style.color = selectedStock > 0 ? 'var(--success)' : 'var(--signal)';
            }

            document.getElementById('sizeWarning').style.display = 'none';
        }

        // ================================================================
        // ===== SELECT DEFAULT SIZE =====
        // ================================================================
        function selectDefaultSize(button) {
            document.querySelectorAll('.size-btn').forEach(btn => btn.classList.remove('selected'));
            button.classList.add('selected');
            selectedSize = button.dataset.size;
            selectedVariantId = null;
            document.getElementById('sizeWarning').style.display = 'none';
        }

        // ================================================================
        // ===== UPDATE PRICE DISPLAY =====
        // ================================================================
        function updatePriceDisplay(price, mrp, discount, button) {
            const priceDisplay = document.getElementById('displayPrice');
            const mrpDisplay = document.getElementById('displayMrp');
            const discountBadge = document.getElementById('discountBadge');

            priceDisplay.textContent = '₹' + price.toFixed(2);

            if (discount > 0 && mrp > price) {
                if (mrpDisplay) {
                    mrpDisplay.style.display = 'inline';
                    mrpDisplay.textContent = '₹' + mrp.toFixed(2);
                }
                if (discountBadge) {
                    discountBadge.style.display = 'inline';
                    if (button && button.dataset.discountType) {
                        const discountType = button.dataset.discountType;
                        const discountValue = parseFloat(button.dataset.discountValue) || 0;
                        if (discountType === 'flat') {
                            discountBadge.textContent = '₹' + discountValue.toFixed(2) + ' OFF';
                        } else {
                            discountBadge.textContent = discount + '% OFF';
                        }
                    } else {
                        discountBadge.textContent = discount + '% OFF';
                    }
                }
            } else {
                if (mrpDisplay) mrpDisplay.style.display = 'none';
                if (discountBadge) discountBadge.style.display = 'none';
            }
        }

        // ================================================================
        // ===== UPDATE STOCK DISPLAY =====
        // ================================================================
        function updateStockDisplay(stock) {
            const stockStatus = document.getElementById('stockStatus');
            if (stockStatus) {
                if (stock > 0) {
                    if (stock <= 5) {
                        stockStatus.className = 'in-stock-low';
                        stockStatus.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Only ' + stock +
                            ' left in stock!';
                        stockStatus.style.display = 'block';
                    } else {
                        stockStatus.style.display = 'none';
                    }
                } else {
                    stockStatus.className = 'out-of-stock';
                    stockStatus.innerHTML = '<i class="fas fa-times-circle"></i> Out of Stock';
                    stockStatus.style.display = 'block';
                }
            }
        }

        // ================================================================
        // ===== LOGIN MODAL =====
        // ================================================================
        let pendingAction = null;
        let pendingData = null;

        function showLoginModal(action, data) {
            pendingAction = action;
            pendingData = data;
            document.getElementById('loginModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeLoginModal() {
            document.getElementById('loginModal').classList.remove('active');
            document.body.style.overflow = '';
            pendingAction = null;
            pendingData = null;
        }

        // ================================================================
        // ===== RELATED WISHLIST =====
        // ================================================================
        function toggleRelatedWishlist(id, name, price, image) {
            @if (!auth()->check())
                showLoginModal('wishlist', {
                    id: id,
                    name: name,
                    price: price,
                    image: image
                });
                return;
            @endif

            let currentWishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
            const existingIndex = currentWishlist.findIndex(item => item.id === id);
            const icon = document.getElementById(`related-wishlist-icon-${id}`);

            if (existingIndex !== -1) {
                currentWishlist.splice(existingIndex, 1);
                if (icon) icon.className = 'far fa-heart';
                showNotification('Removed from wishlist!', 'info');
            } else {
                currentWishlist.push({
                    id: id,
                    name: name,
                    price: price,
                    image: image,
                    added_at: new Date().toISOString()
                });
                if (icon) icon.className = 'fas fa-heart';
                showNotification('Added to wishlist!', 'success');
            }

            localStorage.setItem('wishlist', JSON.stringify(currentWishlist));
            updateWishlistCount();
        }

        // ================================================================
        // ===== IMAGE FUNCTIONS =====
        // ================================================================
        function changeMainImage(index) {
            currentIndex = index;
            document.getElementById('mainImage').src = images[index];
            document.querySelectorAll('.vertical-thumb').forEach((thumb, i) => {
                if (i == index) thumb.classList.add('active');
                else thumb.classList.remove('active');
            });
        }

        function getCurrentImageSrc() {
            return document.getElementById('mainImage').src;
        }

        function prevImage() {
            let newIndex = currentIndex - 1;
            if (newIndex < 0) newIndex = totalImages - 1;
            changeMainImage(newIndex);
        }

        function nextImage() {
            let newIndex = currentIndex + 1;
            if (newIndex >= totalImages) newIndex = 0;
            changeMainImage(newIndex);
        }

        // ================================================================
        // ===== TAB FUNCTIONS =====
        // ================================================================
        function toggleTab(header) {
            const content = header.nextElementSibling;
            const isActive = header.classList.contains('active');

            if (!isActive) {
                document.querySelectorAll('.info-tab-header').forEach(tab => {
                    tab.classList.remove('active');
                    if (tab.nextElementSibling) tab.nextElementSibling.classList.remove('show');
                });
                header.classList.add('active');
                content.classList.add('show');
            } else {
                header.classList.remove('active');
                content.classList.remove('show');
            }
        }

        // ================================================================
        // ===== WISHLIST =====
        // ================================================================
        function toggleWishlistDetail() {
            @if (!auth()->check())
                showLoginModal('wishlist', {
                    id: productId,
                    name: productName,
                    price: selectedPrice,
                    image: productImage
                });
                return;
            @endif

            let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
            const existingIndex = wishlist.findIndex(item => item.id === productId);
            const btn = document.querySelector('.btn-wishlist');
            const icon = btn.querySelector('i');

            if (existingIndex !== -1) {
                wishlist.splice(existingIndex, 1);
                icon.className = 'far fa-heart';
                btn.style.background = 'white';
                btn.style.color = 'var(--signal)';
                showNotification('Removed from wishlist!', 'info');
            } else {
                wishlist.push({
                    id: productId,
                    name: productName,
                    price: selectedPrice,
                    image: productImage,
                    added_at: new Date().toISOString()
                });
                icon.className = 'fas fa-heart';
                btn.style.background = 'var(--signal)';
                btn.style.color = 'white';
                showNotification('Added to wishlist!', 'success');
            }

            localStorage.setItem('wishlist', JSON.stringify(wishlist));
            updateWishlistCount();
        }

        // ================================================================
        // ===== QUANTITY =====
        // ================================================================
        function incrementQuantity() {
            let qty = document.getElementById('quantity');
            let max = parseInt(qty.getAttribute('max')) || 99;
            let newVal = parseInt(qty.value) + 1;
            if (newVal <= max) qty.value = newVal;
        }

        function decrementQuantity() {
            let qty = document.getElementById('quantity');
            let newVal = parseInt(qty.value) - 1;
            if (newVal >= 1) qty.value = newVal;
        }

        // ================================================================
        // ===== ADD TO CART =====
        // ================================================================
     // ================================================================
// ===== ADD TO CART - IMMEDIATE REDIRECT =====
// ================================================================
function addToCartDetail() {
    @if (!auth()->check())
        showLoginModal('cart', {
            id: productId,
            name: productName,
            price: selectedPrice,
            image: productImage
        });
        return;
    @endif

    @if ($hasSizes || $hasSizeChart)
        if (!selectedSize) {
            document.getElementById('sizeWarning').style.display = 'block';
            document.getElementById('sizeWarning').scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
            return;
        }
    @endif

    if (selectedStock <= 0) {
        showNotification('Selected size is out of stock!', 'error');
        return;
    }

    let quantity = parseInt(document.getElementById('quantity').value);

    if (quantity > selectedStock) {
        showNotification('Only ' + selectedStock + ' items available in stock!', 'error');
        document.getElementById('quantity').value = selectedStock;
        return;
    }

    let currentCart = JSON.parse(localStorage.getItem('cart')) || [];
    let existingItem = currentCart.find(item => item.id === productId && item.size === selectedSize && item
        .color === selectedColor);

    if (existingItem) {
        if (existingItem.quantity + quantity > selectedStock) {
            showNotification('Only ' + selectedStock + ' items available! You already have ' + existingItem
                .quantity + ' in cart.', 'error');
            return;
        }
        existingItem.quantity += quantity;
    } else {
        currentCart.push({
            id: productId,
            name: productName,
            price: selectedPrice,
            original_price: selectedMrp,
            image: productImage,
            quantity: quantity,
            size: selectedSize,
            color: selectedColor,
            variant_id: selectedVariantId
        });
    }

    localStorage.setItem('cart', JSON.stringify(currentCart));
    updateCartCount();

    // ===== REDIRECT TO CART PAGE IMMEDIATELY =====
    window.location.href = "{{ route('cart') }}";
}
        // ================================================================
        // ===== NOTIFICATION =====
        // ================================================================
        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            const icon = type === 'success' ? 'fa-check-circle' :
                type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
            notification.innerHTML = `<i class="fas ${icon} me-2"></i> ${message}`;
            document.body.appendChild(notification);
            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transition = 'opacity 0.3s ease';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // ================================================================
        // ===== CART & WISHLIST COUNTS =====
        // ================================================================
        function updateCartCount() {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            let count = cart.reduce((total, item) => total + item.quantity, 0);
            let cartCountElement = document.getElementById('navbarCartCount');
            if (cartCountElement) {
                cartCountElement.textContent = count;
                if (count > 0) cartCountElement.classList.remove('hide-badge');
                else cartCountElement.classList.add('hide-badge');
            }
        }

        function updateWishlistCount() {
            let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
            let count = wishlist.length;
            let el = document.getElementById('navbarWishlistCount');
            if (el) {
                if (count > 0) {
                    el.textContent = count;
                    el.classList.remove('hide-badge');
                } else {
                    el.textContent = '';
                    el.classList.add('hide-badge');
                }
            }
        }

        // ================================================================
        // ===== WISHLIST STATUS =====
        // ================================================================
        function checkWishlistStatus() {
            let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
            const isInWishlist = wishlist.some(item => item.id === productId);
            const btn = document.querySelector('.btn-wishlist');
            const icon = btn.querySelector('i');

            if (isInWishlist) {
                icon.className = 'fas fa-heart';
                btn.style.background = 'var(--signal)';
                btn.style.color = 'white';
            } else {
                icon.className = 'far fa-heart';
                btn.style.background = 'white';
                btn.style.color = 'var(--signal)';
            }
        }

        // ================================================================
        // ===== SAVE SELECTED SIZE =====
        // ================================================================
        function loadSavedSize() {
            let savedSizes = JSON.parse(localStorage.getItem('selectedSizes')) || {};
            if (savedSizes[productId]) {
                selectedSize = savedSizes[productId];
                document.querySelectorAll('.size-btn').forEach(btn => {
                    if (btn.getAttribute('data-size') === selectedSize) {
                        btn.classList.add('selected');
                        if (btn.dataset.variantId) {
                            selectSize(btn);
                        }
                    }
                });
            }
        }

        // ================================================================
        // ===== REVIEWS CAROUSEL FUNCTIONS =====
        // ================================================================
        function updateReviewsPerPage() {
            if (window.innerWidth <= 575) {
                reviewsPerPage = 1;
            } else if (window.innerWidth <= 991) {
                reviewsPerPage = 2;
            } else {
                reviewsPerPage = 3;
            }
        }

        function goToReviewPage(index) {
            if (reviewsData.length === 0) return;

            const totalPages = Math.ceil(reviewsData.length / reviewsPerPage);
            if (index < 0) index = 0;
            if (index >= totalPages) index = totalPages - 1;
            currentReviewIndex = index;

            updateReviewCarousel();
            updateReviewDots();
            updateReviewNavButtons();
        }

        function updateReviewCarousel() {
            const track = document.getElementById('reviewsCarouselTrack');
            if (!track) return;

            const start = currentReviewIndex * reviewsPerPage;
            const end = Math.min(start + reviewsPerPage, reviewsData.length);
            const visibleReviews = reviewsData.slice(start, end);

            track.innerHTML = visibleReviews.map(review => renderReviewCard(review)).join('');
        }

        function updateReviewDots() {
            const totalPages = Math.ceil(reviewsData.length / reviewsPerPage);
            const dotsContainer = document.getElementById('reviewsDots');
            if (!dotsContainer) return;

            dotsContainer.innerHTML = '';
            for (let i = 0; i < totalPages; i++) {
                const dot = document.createElement('span');
                dot.className = 'reviews-dot' + (i === currentReviewIndex ? ' active' : '');
                dot.onclick = () => goToReviewPage(i);
                dotsContainer.appendChild(dot);
            }
        }

        function updateReviewNavButtons() {
            const totalPages = Math.ceil(reviewsData.length / reviewsPerPage);
            const prevBtn = document.getElementById('reviewsPrevBtn');
            const nextBtn = document.getElementById('reviewsNextBtn');

            if (prevBtn) prevBtn.disabled = currentReviewIndex === 0;
            if (nextBtn) nextBtn.disabled = currentReviewIndex >= totalPages - 1;
        }

        // ================================================================
        // ===== LOAD REVIEWS =====
        // ================================================================
        async function loadReviews() {
            const container = document.getElementById('reviewsList');
            const loading = document.getElementById('reviewsLoading');
            const badge = document.getElementById('reviewCountBadge');

            if (!container) return;

            try {
                loading.style.display = 'block';
                loading.innerHTML = `
                    <div class="d-flex justify-content-center align-items-center" style="padding: 20px;">
                        <div class="spinner-border text-danger" role="status" style="width: 28px; height: 28px;">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span class="ms-3 text-muted" style="font-size: 14px; font-weight: 500;">Loading reviews...</span>
                    </div>
                `;

                const controller = new AbortController();
                const timeoutId = setTimeout(() => controller.abort(), 10000);

                const response = await fetch(`/api/product-reviews/${productId}`, {
                    signal: controller.signal
                });
                clearTimeout(timeoutId);

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const data = await response.json();
                loading.style.display = 'none';

                if (data.success && data.reviews && data.reviews.length > 0) {
                    reviewsData = data.reviews;
                    badge.textContent = reviewsData.length;

                    updateReviewsPerPage();
                    currentReviewIndex = 0;
                    const totalPages = Math.ceil(reviewsData.length / reviewsPerPage);

                    let carouselHtml = `
                        <div class="reviews-carousel-wrapper">
                            <div class="reviews-carousel-track" id="reviewsCarouselTrack">
                                ${reviewsData.slice(0, reviewsPerPage).map(review => renderReviewCard(review)).join('')}
                            </div>
                        </div>
                        <div class="reviews-nav">
                            <button class="reviews-nav-btn" id="reviewsPrevBtn" onclick="goToReviewPage(currentReviewIndex - 1)" ${totalPages <= 1 ? 'disabled' : ''}>
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <div class="reviews-dots" id="reviewsDots"></div>
                            <button class="reviews-nav-btn" id="reviewsNextBtn" onclick="goToReviewPage(currentReviewIndex + 1)" ${totalPages <= 1 ? 'disabled' : ''}>
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    `;

                    container.innerHTML = carouselHtml;
                    updateReviewDots();
                    updateReviewNavButtons();

                } else {
                    container.innerHTML = `
                        <div class="no-reviews">
                            <i class="fas fa-comment-slash"></i>
                            <h5>No reviews yet</h5>
                            <p>Be the first to review this product!</p>
                        </div>
                    `;
                    badge.textContent = '0';
                }
            } catch (error) {
                console.error('Error loading reviews:', error);
                loading.style.display = 'none';

                container.innerHTML = `
                    <div class="no-reviews" style="border-color: #fee2e2; background: #fef2f2;">
                        <i class="fas fa-wifi text-warning" style="font-size: 40px; margin-bottom: 15px; display: block;"></i>
                        <h5 style="color: #dc2626; margin-bottom: 5px;">Unable to load reviews</h5>
                        <p style="color: var(--steel); font-size: 14px;">Please check your connection and try again.</p>
                        <button onclick="loadReviews()" class="btn btn-sm btn-outline-danger mt-2" style="border-radius: 20px; padding: 6px 20px; font-size: 13px; border-color: var(--signal); color: var(--signal);">
                            <i class="fas fa-redo me-1"></i> Retry
                        </button>
                    </div>
                `;
                badge.textContent = '0';
            }
        }

        // ================================================================
        // ===== RENDER REVIEW CARD =====
        // ================================================================
        function renderReviewCard(review) {
            let starsHtml = '';
            for (let i = 1; i <= 5; i++) {
                if (i <= review.rating) {
                    starsHtml += '<i class="fas fa-star"></i>';
                } else {
                    starsHtml += '<i class="fas fa-star star-empty"></i>';
                }
            }

            const date = new Date(review.created_at);
            const formattedDate = date.toLocaleDateString('en-IN', {
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            });

            return `
                <div class="review-card">
                    <div class="review-header">
                        <span class="review-user">
                            <i class="fas fa-user-circle"></i> 
                            ${escapeHtml(review.user_name || 'Anonymous')}
                        </span>
                        <span class="review-date">${formattedDate}</span>
                    </div>
                    <div class="review-stars">
                        ${starsHtml}
                    </div>
                    <div class="review-text">
                        ${escapeHtml(review.description)}
                    </div>
                    <span class="review-verified">
                        <i class="fas fa-check-circle"></i> Verified
                    </span>
                </div>
            `;
        }

        function escapeHtml(text) {
            if (!text) return '';
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // ================================================================
        // ===== DOCUMENT READY =====
        // ================================================================
        document.addEventListener('DOMContentLoaded', function() {
            // First tab open
            const firstTab = document.querySelector('.info-tab-header');
            if (firstTab) {
                firstTab.classList.add('active');
                if (firstTab.nextElementSibling) firstTab.nextElementSibling.classList.add('show');
            }

            // Close image modal on overlay click
            document.getElementById('imageModalOverlay').addEventListener('click', function(e) {
                if (e.target === this) closeImageModal();
            });

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                if (document.getElementById('imageModalOverlay').classList.contains('active')) {
                    if (e.key === 'Escape') closeImageModal();
                    if (e.key === 'ArrowLeft') changeModalImage(-1);
                    if (e.key === 'ArrowRight') changeModalImage(1);
                }
                if (e.key === 'ArrowLeft') prevImage();
                if (e.key === 'ArrowRight') nextImage();
            });

            // Size Guide close on overlay click
            document.getElementById('sizeGuideModalOverlay').addEventListener('click', function(e) {
                if (e.target === this) closeSizeGuide();
            });

            // Login modal close on overlay click
            document.getElementById('loginModal').addEventListener('click', function(e) {
                if (e.target === this) closeLoginModal();
            });

            // Initial setup
            updateCartCount();
            updateWishlistCount();
            checkWishlistStatus();
            loadSavedSize();

            const mainImageArea = document.getElementById('mainImageArea');
            if (mainImageArea) {
                mainImageArea.addEventListener('click', function(e) {
                    if (!e.target.classList.contains('nav-arrow')) {
                        openImageModal(currentIndex);
                    }
                });
            }

            // Load reviews
            loadReviews();

            // Handle window resize for reviews carousel
            let resizeTimeout;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(function() {
                    if (reviewsData.length > 0) {
                        updateReviewsPerPage();
                        goToReviewPage(currentReviewIndex);
                    }
                }, 300);
            });

            // Retry loading on network reconnect
            window.addEventListener('online', function() {
                loadReviews();
            });

            // Initial stock
            const initialStock = {{ $displayStock }};
            const quantityInput = document.getElementById('quantity');
            if (quantityInput && initialStock > 0) {
                quantityInput.max = initialStock;
            }

            @if ($hasVariants && $firstVariant && !$hasColors)
                const firstButton = document.querySelector('.size-btn[data-variant-id="{{ $firstVariant->id }}"]');
                if (firstButton) selectSize(firstButton);
            @endif

            @if ($hasColors)
                const firstColor = document.querySelector('.color-btn.selected');
                if (firstColor) {
                    const color = firstColor.dataset.color;
                    updateSizesForColor(color);
                }
            @endif
        });
    </script>
@endsection
