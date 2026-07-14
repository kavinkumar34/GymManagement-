{{-- resources/views/product-detail.blade.php --}}
@extends('layouts.app')

@section('content')
    <style>
    /* Product Description Styles */
.product-description {
    font-size: 14px;
    line-height: 1.8;
    color: #333;
}

.product-description p {
    margin-bottom: 8px;
}

.product-description br {
    display: block;
    margin: 3px 0;
}
        /* Reset and Base */
        .product-detail-container {
            margin-top: 40px;
            overflow: visible;
            position: relative;
        }

        /* ===== FIXED LAYOUT - LEFT STICKY, RIGHT SCROLL ===== */
        .product-wrapper {
            display: flex;
            align-items: flex-start;
            gap: 40px;
            width: 100%;
            position: relative;
        }

        /* LEFT COLUMN - STICKY IMAGE */
        .left-column {
            width: 48%;
            flex: 0 0 48%;
            position: sticky !important;
            top: 120px;
            align-self: flex-start;
            height: fit-content;
            z-index: 10;
        }

        /* RIGHT COLUMN - SCROLLABLE WITH HIDDEN SCROLLBAR */
        .right-column {
            width: 52%;
            flex: 0 0 52%;
            position: relative;
            z-index: 1;
            max-height: calc(100vh - 150px);
            overflow-y: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .right-column::-webkit-scrollbar {
            display: none;
            width: 0;
            height: 0;
        }

        .right-side-content {
            width: 100%;
            padding-left: 15px;
            padding-right: 10px;
        }

        /* Image Gallery */
        .product-gallery-wrapper {
            display: flex;
            gap: 20px;
            flex-direction: row;
            width: 100%;
        }

        .main-image-area {
            flex: 1;
            height: 600px;
            background: #f8f8f8;
            border-radius: 15px;
            overflow: hidden;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .main-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .vertical-thumbnails {
            display: flex;
            flex-direction: column;
            gap: 12px;
            width: 100px;
            flex-shrink: 0;
            max-height: 550px;
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
            width: 95px;
            height: 95px;
            border-radius: 12px;
            overflow: hidden;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.3s ease;
            background: #f8f9fa;
            flex-shrink: 0;
        }

        .vertical-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .vertical-thumb.active {
            border-color: #dc3545;
            box-shadow: 0 0 8px rgba(220, 53, 69, 0.3);
        }

        .vertical-thumb:hover {
            transform: scale(1.05);
            border-color: #dc3545;
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
            background: rgba(0, 0, 0, 0.6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            cursor: pointer;
            pointer-events: auto;
            transition: all 0.3s;
        }

        .nav-arrow:hover {
            background: #dc3545;
        }

        /* ===== COLOR VARIANT STYLES ===== */
        .color-section {
            margin-bottom: 20px;
        }

        .color-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .color-label {
            font-weight: 600;
            font-size: 14px;
        }

        .color-options {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .color-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 3px solid #e0e0e0;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            background-size: cover;
            background-position: center;
        }

        .color-btn:hover {
            transform: scale(1.1);
            border-color: #999;
        }

        .color-btn.selected {
            border-color: #dc3545;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.3);
            transform: scale(1.1);
        }

        .color-btn .color-name-tooltip {
            position: absolute;
            bottom: -25px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 10px;
            color: #666;
            white-space: nowrap;
            display: none;
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

        /* ===== RIGHT SIDE CONTENT STYLES ===== */
        .brand-name {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }

        .product-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .product-category {
            color: #999;
            font-size: 12px;
            margin-bottom: 10px;
        }

        .rating {
            margin-bottom: 15px;
        }

        .stars {
            color: #ffc107;
        }

        .rating-text {
            color: #666;
            font-size: 12px;
            margin-left: 8px;
        }

        .price-section {
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .current-price {
            font-size: 28px;
            font-weight: bold;
            color: #dc3545;
        }

        .old-price {
            text-decoration: line-through;
            color: #999;
            font-size: 18px;
            margin-left: 10px;
        }

        .discount-badge {
            background: #28a745;
            color: white;
            padding: 4px 8px;
            border-radius: 5px;
            font-size: 12px;
            margin-left: 10px;
        }

        .tax-text {
            color: #666;
            font-size: 12px;
            margin-top: 5px;
        }

        .you-save-text {
            font-size: 13px;
            color: #28a745;
            margin-top: 5px;
        }

        /* ===== SIZE SECTION ===== */
        .size-section {
            margin-bottom: 20px;
        }

        .size-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .size-label {
            font-weight: 600;
            font-size: 14px;
        }

        .size-guide {
            font-size: 12px;
            color: #0d6efd;
            text-decoration: none;
            cursor: pointer;
        }

        .size-options {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .size-btn {
            min-width: 75px;
            padding: 10px 15px;
            border: 1px solid #ddd;
            background: white;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
            font-size: 13px;
        }

        .size-btn:hover,
        .size-btn.selected {
            background: #dc3545;
            color: white;
            border-color: #dc3545;
        }

        .size-btn.out-of-stock-size {
            opacity: 0.4;
            cursor: not-allowed;
            text-decoration: line-through;
        }

        .size-btn.out-of-stock-size:hover {
            background: white;
            color: inherit;
            border-color: #ddd;
        }

        .size-warning {
            color: red;
            font-size: 12px;
            display: none;
            margin-top: 8px;
        }

        .quantity-section {
            margin-bottom: 20px;
        }

        .quantity-label {
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 10px;
            display: block;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity-btn {
            width: 35px;
            height: 35px;
            border: 1px solid #ddd;
            background: white;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
        }

        .quantity-input {
            width: 60px;
            text-align: center;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .stock-status {
            margin-bottom: 20px;
        }

        .in-stock {
            color: #28a745;
            font-size: 14px;
        }

        .in-stock-low {
            color: #dc3545;
            font-size: 14px;
        }

        .out-of-stock {
            color: #dc3545;
            font-size: 14px;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .btn-wishlist {
            background: white;
            border: 1px solid #dc3545;
            border-radius: 25px;
            padding: 10px 20px;
            color: #dc3545;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 14px;
        }

        .btn-wishlist:hover:not(:disabled) {
            background: #dc3545;
            color: white;
        }

        .btn-add-cart {
            background: #000000;
            border: none;
            border-radius: 25px;
            padding: 10px 25px;
            color: white;
            cursor: pointer;
            transition: all 0.3s;
            flex: 1;
            font-size: 14px;
        }

        .btn-add-cart:hover:not(:disabled) {
            background: #dc3545;
        }

        .btn-buy-now {
            background: #dc3545;
            border: none;
            border-radius: 25px;
            padding: 10px 25px;
            color: white;
            cursor: pointer;
            transition: all 0.3s;
            flex: 1;
            font-size: 14px;
        }

        .btn-buy-now:hover:not(:disabled) {
            background: #000000;
        }

        /* ===== DELIVERY BOX ===== */
        .delivery-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .delivery-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .delivery-item:last-child {
            margin-bottom: 0;
        }

        .delivery-item i {
            width: 25px;
            color: #dc3545;
        }

        .delivery-text {
            font-size: 13px;
        }

        .delivery-text strong {
            display: block;
            margin-bottom: 2px;
        }

        .delivery-text small {
            color: #666;
        }

        .delivery-text .cod-available {
            color: #28a745;
            font-weight: 600;
        }

        .delivery-text .cod-not-available {
            color: #dc3545;
            font-weight: 600;
        }

        .product-info-tabs {
            margin-top: 20px;
        }

        .info-tab {
            border: 1px solid #dee2e6;
            border-radius: 10px;
            margin-bottom: 12px;
            overflow: hidden;
        }

        .info-tab-header {
            background: white;
            padding: 12px 15px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s;
            font-weight: 600;
            font-size: 13px;
        }

        .info-tab-header i {
            margin-right: 10px;
            color: #dc3545;
        }

        .info-tab-header.active {
            background: #dc3545;
            color: white;
        }

        .info-tab-header.active i {
            color: white;
        }

        .info-tab-content {
            padding: 0;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            background: #f8f9fa;
        }

        .info-tab-content.show {
            padding: 15px;
            max-height: 250px;
            overflow-y: auto;
        }

        .info-tab-header .arrow {
            transition: transform 0.3s;
        }

        .info-tab-header.active .arrow {
            transform: rotate(180deg);
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 20px;
        }

        .image-modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            cursor: pointer;
        }

        .image-modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-image {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
        }

        .close-modal {
            position: absolute;
            top: 20px;
            right: 35px;
            color: white;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
        }

        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 280px;
            padding: 15px 20px;
            border-radius: 8px;
            color: white;
            font-size: 14px;
            animation: slideIn 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .notification.success {
            background: #28a745;
        }

        .notification.error {
            background: #dc3545;
        }

        .notification.info {
            background: #17a2b8;
        }

        /* ===== CUSTOM LOGIN MODAL ===== */
        .custom-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
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
            border-radius: 20px;
            padding: 40px;
            max-width: 450px;
            width: 90%;
            text-align: center;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);
            position: relative;
            animation: slideUpModal 0.4s ease;
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
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #28a745, #1e7e34);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2.5rem;
            color: white;
            box-shadow: 0 10px 30px rgba(40, 167, 69, 0.3);
        }

        .custom-modal-box .modal-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 10px;
        }

        .custom-modal-box .modal-subtitle {
            font-size: 0.95rem;
            color: #64748b;
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .custom-modal-box .modal-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .custom-modal-box .btn-modal-primary {
            background: linear-gradient(135deg, #28a745, #1e7e34);
            color: white;
            border: none;
            padding: 12px 35px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .custom-modal-box .btn-modal-secondary {
            background: #e2e8f0;
            color: #64748b;
            border: none;
            padding: 12px 35px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .custom-modal-box .modal-close {
            position: absolute;
            top: 15px;
            right: 20px;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #999;
            cursor: pointer;
            transition: all 0.3s;
        }

        /* ===== REVIEW SECTION ===== */
        .reviews-section {
            margin-top: 30px;
            padding: 25px;
            background: #f8f9fa;
            border-radius: 15px;
        }

        .reviews-section .section-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .review-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border-left: 4px solid #dc3545;
        }

        .review-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .review-card .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            flex-wrap: wrap;
            gap: 5px;
        }

        .review-card .review-user {
            font-weight: 600;
            color: #1e293b;
            font-size: 15px;
        }

        .review-card .review-date {
            font-size: 12px;
            color: #94a3b8;
        }

        .review-card .review-stars {
            color: #f59e0b;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .review-card .review-stars .star-empty {
            color: #e2e8f0;
        }

        .review-card .review-text {
            color: #475569;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 12px;
        }

        .review-card .review-media {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 5px;
        }

        .review-card .review-media .media-item {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .review-card .review-verified {
            display: inline-block;
            background: #dcfce7;
            color: #15803d;
            font-size: 11px;
            padding: 2px 10px;
            border-radius: 20px;
            font-weight: 500;
            margin-top: 5px;
        }

        .no-reviews {
            text-align: center;
            padding: 40px;
            color: #94a3b8;
        }

        .no-reviews i {
            font-size: 40px;
            margin-bottom: 15px;
            display: block;
        }

        .review-count-badge {
            background: #dc3545;
            color: white;
            border-radius: 50%;
            padding: 2px 10px;
            font-size: 14px;
            margin-left: 8px;
        }

        /* ===== RELATED PRODUCTS ===== */
        .related-products-section {
            margin-top: 40px;
            padding: 20px 0;
            clear: both;
        }

        .related-products-section .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .related-product-card {
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

        .related-product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .related-product-card .product-image-container {
            width: 100%;
            height: 250px;
            overflow: hidden;
            background: #f8f9fa;
            position: relative;
        }

        .related-product-card .product-image-container img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            transition: transform 0.5s ease;
            background: #ffffff;
            padding: 10px;
        }

        .related-product-card:hover .product-image-container img {
            transform: scale(1.03);
        }

        .related-product-card .discount-badge {
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

        .related-product-card .wishlist-btn {
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

        .related-product-card .wishlist-btn i {
            font-size: 1rem;
        }

        .related-product-card .wishlist-btn i.far {
            color: #999;
        }

        .related-product-card .wishlist-btn i.fas {
            color: #dc3545;
        }

        .related-product-card .card-body {
            padding: 12px 15px 15px;
            text-align: left;
        }

        .related-product-card .product-brand {
            font-size: 0.75rem;
            color: #6c757d;
            font-weight: 500;
            margin-bottom: 2px;
        }

        .related-product-card .product-brand i {
            font-size: 0.65rem;
            margin-right: 4px;
            color: #6c757d;
        }

        .related-product-card .product-name {
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 4px;
            color: #1e293b;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 40px;
        }

        .related-product-card .product-price-container {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 2px;
        }

        .related-product-card .product-price-container .final-price {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1e293b;
        }

        .related-product-card .product-price-container .original-price {
            font-size: 0.85rem;
            color: #999;
            text-decoration: line-through;
        }

        .related-product-card .product-price-container .discount-percent {
            background: #dc3545;
            color: white;
            padding: 1px 10px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .related-product-card .product-stock-low {
            font-size: 0.8rem;
            color: #dc3545;
            margin-top: 6px;
            font-weight: 600;
        }

        .related-product-card .product-stock-low i {
            font-size: 0.8rem;
            margin-right: 4px;
            color: #dc3545;
        }

        .related-product-card .product-stock-out {
            font-size: 0.8rem;
            color: #999;
            margin-top: 6px;
            font-weight: 500;
            background: #f5f5f5;
            padding: 4px 10px;
            border-radius: 4px;
        }

        .related-product-card .product-stock-out i {
            font-size: 0.8rem;
            margin-right: 4px;
            color: #999;
        }

        /* ===== SIZE GUIDE MODAL - SIDE POPUP ===== */
        .sizeguide-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
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
            width: 500px;
            max-width: 90%;
            height: 100vh;
            overflow-y: auto;
            padding: 30px;
            box-shadow: -10px 0 30px rgba(0, 0, 0, 0.2);
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
            color: #999;
            transition: all 0.3s;
        }

        .sizeguide-modal-box .modal-close-btn:hover {
            color: #dc3545;
            transform: rotate(90deg);
        }

        .sizeguide-modal-box h3 {
            font-size: 22px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #eef2f6;
        }

        .sizeguide-modal-box h3 i {
            color: #dc3545;
            margin-right: 10px;
        }

        .sizeguide-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .sizeguide-table th {
            background: #dc3545;
            color: white;
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
        }

        .sizeguide-table td {
            padding: 10px 15px;
            border-bottom: 1px solid #eef2f6;
            font-size: 13px;
            color: #333;
        }

        .sizeguide-table tr:hover td {
            background: #f8f9fa;
        }

        .sizeguide-table tr:last-child td {
            border-bottom: none;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 991px) {
            .product-wrapper {
                flex-direction: column;
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
            }

            .product-gallery-wrapper {
                flex-direction: column-reverse;
            }

            .vertical-thumbnails {
                flex-direction: row;
                width: 100%;
                justify-content: center;
                max-height: 120px;
                overflow-x: auto;
                overflow-y: hidden;
            }

            .main-image-area {
                height: 450px;
            }

            .right-side-content {
                padding-left: 0;
                padding-top: 20px;
            }

            .related-product-card .product-image-container {
                height: 200px;
            }

            .sizeguide-modal-box {
                width: 100%;
                max-width: 100%;
            }
        }

        @media (max-width: 768px) {
            .main-image-area {
                min-height: 350px;
                height: 350px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-add-cart,
            .btn-buy-now,
            .btn-wishlist {
                width: 100%;
            }

            .vertical-thumb {
                width: 70px;
                height: 70px;
            }

            .related-product-card .product-image-container {
                height: 180px;
            }

            .related-product-card .product-name {
                font-size: 0.75rem;
                min-height: 30px;
            }

            .related-product-card .product-price-container .final-price {
                font-size: 0.95rem;
            }

            .related-product-card .product-brand {
                font-size: 0.65rem;
            }

            .sizeguide-modal-box {
                padding: 20px;
            }

            .sizeguide-modal-box h3 {
                font-size: 18px;
            }

            .sizeguide-table th,
            .sizeguide-table td {
                padding: 8px 10px;
                font-size: 12px;
            }
        }

        @media (max-width: 576px) {
            .main-image-area {
                height: 280px;
                min-height: 280px;
            }

            .vertical-thumb {
                width: 60px;
                height: 60px;
            }

            .vertical-thumbnails {
                gap: 8px;
            }

            .product-title {
                font-size: 20px;
            }

            .current-price {
                font-size: 24px;
            }

            .related-product-card .product-image-container {
                height: 140px;
            }

            .related-product-card .product-name {
                font-size: 0.7rem;
                min-height: 25px;
            }

            .related-product-card .product-price-container .final-price {
                font-size: 0.85rem;
            }

            .related-product-card .product-brand {
                font-size: 0.6rem;
            }

            .sizeguide-modal-box {
                padding: 15px;
            }

            .sizeguide-modal-box h3 {
                font-size: 16px;
            }

            .sizeguide-table th,
            .sizeguide-table td {
                padding: 6px 8px;
                font-size: 11px;
            }
        }
    </style>

    @php
        // ===== GET VARIANT DATA =====
        $variants = \App\Models\ProductVariant::where('product_id', $product->id)->get();
        $hasVariants = $variants->count() > 0;

        // ===== GET UNIQUE COLORS FROM VARIANTS =====
        $colors = $hasVariants ? $variants->pluck('color')->unique()->filter()->values() : collect();
        $hasColors = $colors->count() > 0;

        // ===== GET UNIQUE SIZES FROM VARIANTS =====
        $sizes = $hasVariants ? $variants->pluck('size')->unique()->filter()->values() : collect();
        $hasSizes = $sizes->count() > 0;

        // ===== GET SIZE CHART - ONLY IF ASSIGNED =====
        $sizeChart = null;
        $hasSizeChart = false;
        if ($product->size_chart_id) {
            $sizeChart = \App\Models\SizeChart::find($product->size_chart_id);
            $hasSizeChart = $sizeChart ? true : false;
        }

        // ===== DECODE SIZE CHART SIZES =====        $sizeChartSizes = [];
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

        // ===== GET FIRST VARIANT FOR DEFAULT DISPLAY =====
        $firstVariant = $hasVariants ? $variants->first() : null;
        $firstColor = $hasColors ? $colors->first() : null;

        // ===== GET BRAND NAME =====
        $brandName = $product->brand ? $product->brand->name : null;
        $hasBrand = !empty($brandName);

        // ===== DETERMINE PRICE DISPLAY =====
        if ($hasVariants && $firstVariant) {
            $displayPrice = floatval($firstVariant->final_price ?? ($firstVariant->price ?? 0));
            $displayMrp = floatval($firstVariant->total_price ?? ($firstVariant->mrp ?? ($firstVariant->price ?? 0)));
            $displayStock = $variants->sum('stock');
            $displayGstPercentage = floatval($firstVariant->gst_percentage ?? 0);
            $discountType = $firstVariant->discount_type ?? 'flat';
            $discountValue = floatval($firstVariant->discount_value ?? 0);
        } else {
            $displayPrice = floatval($product->final_price ?? ($product->price ?? 0));
            $displayMrp = floatval($product->total_price ?? ($product->mrp ?? ($product->price ?? 0)));
            $displayStock = intval($product->stock ?? 0);
            $displayGstPercentage = floatval($product->gst_percentage ?? 0);
            $discountType = $product->discount_type ?? 'flat';
            $discountValue = floatval($product->discount_value ?? 0);
        }

        // ===== CALCULATE DISCOUNT PERCENTAGE =====
        $discountPercent = 0;
        if ($displayMrp > 0 && $displayPrice > 0 && $displayPrice < $displayMrp) {
            $discountPercent = round((($displayMrp - $displayPrice) / $displayMrp) * 100);
        }

        // ===== CALCULATE DISCOUNT AMOUNT =====
        $discountAmount = $displayMrp - $displayPrice;
        if ($discountAmount < 0) {
            $discountAmount = 0;
        }

        // ===== GET DISPLAY DISCOUNT TEXT BASED ON TYPE =====
        $discountDisplayText = '';
        if ($discountValue > 0 && $discountPercent > 0) {
            if ($discountType === 'flat') {
                $discountDisplayText = '₹' . number_format($discountValue, 2) . ' off';
            } else {
                $discountDisplayText = $discountPercent . '% off';
            }
        } elseif ($discountPercent > 0) {
            $discountDisplayText = $discountPercent . '% off';
        }

        // ===== GET DISCOUNT BADGE TEXT BASED ON TYPE =====
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
        $allImages = \App\Models\ProductImage::where('product_id', $product->id)->orderBy('display_order')->get();

        if ($allImages->count() == 0 && $product->image) {
            $allImages = collect([(object) ['image_path' => $product->image, 'is_main' => 1]]);
        }

        if ($allImages->count() == 0) {
            $allImages = collect([
                (object) [
                    'image_path' => 'https://via.placeholder.com/500x500?text=No+Image',
                    'is_main' => 1,
                ],
            ]);
        }

        // ===== BUILD VARIANT DATA ARRAY FOR JAVASCRIPT =====
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

        // ===== BUILD COLOR DATA WITH IMAGES =====
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
    @endphp

    <div class="container-fluid px-5 mt-4">
        <div class="product-detail-container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">{{ $product->category->name ?? 'Products' }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($product->name, 50) }}</li>
                </ol>
            </nav>

            <!-- ===== PRODUCT WRAPPER ===== -->
            <div class="product-wrapper">
                <!-- LEFT COLUMN - STICKY IMAGE -->
                <div class="left-column">
                    <div class="product-gallery-wrapper">
                        <div class="vertical-thumbnails" id="verticalThumbnails">
                            @foreach ($allImages as $index => $img)
                                <div class="vertical-thumb {{ $index == 0 ? 'active' : '' }}"
                                    data-index="{{ $index }}" onclick="changeMainImage({{ $index }})">
                                    <img src="{{ asset('storage/' . $img->image_path) }}"
                                        alt="Thumbnail {{ $index + 1 }}">
                                </div>
                            @endforeach
                        </div>

                        <div class="main-image-area" id="mainImageArea" onclick="openModal(getCurrentImageSrc())">
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

                <!-- RIGHT COLUMN - SCROLLABLE CONTENT WITH HIDDEN SCROLLBAR -->
                <div class="right-column">
                    <div class="right-side-content">
                        <!-- ===== BRAND NAME - ONLY SHOW IF EXISTS ===== -->
                        @if ($hasBrand)
                            <div class="brand-name">
                                <i class="fas fa-building"></i> {{ $brandName }}
                            </div>
                        @endif

                        <h1 class="product-title">{{ $product->name }}</h1>
                        <p class="product-category">
                            <i class="fas fa-tag"></i>
                            {{ $product->category ? $product->category->name : 'Uncategorized' }}
                        </p>

                        <div class="rating">
                            <span class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </span>
                            <span class="rating-text">Based on 0 ratings</span>
                        </div>

                        <!-- ===== PRICE SECTION WITH DISCOUNT ===== -->
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
                                <div style="font-size:12px; color:#6c757d; margin-top:5px;">
                                    <i class="fas fa-palette"></i> {{ $variants->count() }} variants available
                                </div>
                            @endif
                            @if ($hasColors)
                                <div style="font-size:12px; color:#6c757d; margin-top:3px;">
                                    <i class="fas fa-paint-bucket"></i> {{ $colors->count() }} colors available
                                </div>
                            @endif
                        </div>

                        <!-- ===== COLOR SECTION - ONLY SHOW IF COLORS EXIST ===== -->
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
                                        @endphp
                                        <div class="color-btn {{ $isFirst ? 'selected' : '' }}"
                                            data-color="{{ $color }}"
                                            data-images="{{ json_encode($colorImages->count() > 0? $colorImages->pluck('image_path')->map(function ($p) {return asset('storage/' . $p);})->toArray(): $allImages->pluck('image_path')->map(function ($p) {return asset('storage/' . $p);})->toArray()) }}"
                                            onclick="selectColor(this, '{{ $color }}')"
                                            style="background: {{ $color }}; {{ in_array(strtolower($color), ['white', 'yellow', 'pink', 'lightblue', 'lightgreen', 'cream', 'beige']) ? 'border: 3px solid #ddd;' : '' }}">
                                            <span class="check-mark"><i class="fas fa-check"></i></span>
                                            <span class="color-name-tooltip">{{ ucfirst($color) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- ===== SIZE SECTION ===== -->
                        @if ($hasSizes || $hasSizeChart)
                            <div class="size-section">
                                <div class="size-header">
                                    <span class="size-label">Select Size</span>
                                    <!-- ===== SIZE GUIDE - ONLY SHOW IF SIZE CHART IS ASSIGNED ===== -->
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
                                                if (
                                                    $variantMrp > 0 &&
                                                    $variantPrice > 0 &&
                                                    $variantPrice < $variantMrp
                                                ) {
                                                    $variantDiscountPercent = round(
                                                        (($variantMrp - $variantPrice) / $variantMrp) * 100,
                                                    );
                                                }
                                                $variantDiscountType = $sizeVariant->discount_type ?? 'flat';
                                                $variantDiscountValue = floatval($sizeVariant->discount_value ?? 0);

                                                // ===== VARIANT DISCOUNT TEXT =====
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
                                                data-size="{{ $size }}"
                                                data-variant-id="{{ $sizeVariant->id ?? '' }}"
                                                data-price="{{ $variantPrice }}" data-mrp="{{ $variantMrp }}"
                                                data-discount="{{ $variantDiscountPercent }}"
                                                data-stock="{{ $variantStock }}" onclick="selectSize(this)"
                                                {{ $isOutOfStock ? 'disabled' : '' }}>
                                                {{ $size }}
                                                @if ($variantDiscountPercent > 0)
                                                    <span
                                                        style="font-size:9px; display:block; color:#28a745;">-{{ $variantDiscountText }}</span>
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
                                <div id="sizeStockInfo"
                                    style="font-size:12px; color:#6c757d; margin-top:8px; display:none;">
                                    <i class="fas fa-box"></i> <span id="sizeStockCount">0</span> items in stock for this
                                    size
                                </div>
                            </div>
                        @endif

                        <div class="quantity-section">
                            <label class="quantity-label">Quantity</label>
                            <div class="quantity-selector">
                                <button class="quantity-btn" onclick="decrementQuantity()">-</button>
                                <input type="number" id="quantity" class="quantity-input" value="1"
                                    min="1" max="{{ $displayStock > 0 ? $displayStock : 10 }}">
                                <button class="quantity-btn" onclick="incrementQuantity()">+</button>
                            </div>
                        </div>

                        <!-- ===== STOCK STATUS - ONLY SHOW LOW STOCK ALERT WHEN STOCK <= 5 ===== -->
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
                        <!-- ===== REMOVED: No stock message when stock > 5 ===== -->

                        <div class="action-buttons">
                            <button class="btn-wishlist" id="wishlistBtn" onclick="toggleWishlistDetail()">
                                <i class="far fa-heart"></i> Wishlist
                            </button>
                            <button class="btn-add-cart" id="addToCartBtn" onclick="addToCartDetail()">
                                <i class="fas fa-shopping-cart"></i> Add to Cart
                            </button>

                        </div>

                        <!-- ===== DELIVERY BOX ===== -->
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
                                    <small>{{ $product->return_days ?? 7 }}-day return & exchange</small>
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

                        <!-- ===== OFFER SECTION ===== -->
                        @if (isset($product->offers) && $product->offers->count() > 0)
                            <div
                                style="background: #fff3cd; border: 1px solid #ffc107; border-radius: 10px; padding: 12px 15px; margin-bottom: 20px;">
                                <strong style="color: #856404;"><i class="fas fa-tags"></i> Special Offers</strong>
                                <ul style="margin: 8px 0 0 0; padding-left: 20px; color: #856404; font-size: 13px;">
                                    @foreach ($product->offers as $offer)
                                        <li>{{ $offer->title ?? ($offer->name ?? 'Offer') }} - {{ $offer->discount }}% off
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
<!-- ===== PRODUCT INFO TABS ===== -->
<div class="product-info-tabs">
    <div class="info-tab">
        <div class="info-tab-header active" onclick="toggleTab(this)">
            <span><i class="fas fa-info-circle"></i> PRODUCT DETAILS</span>
            <span class="arrow">▼</span>
        </div>
        <div class="info-tab-content show">
            <!-- ===== DESCRIPTION WITH BULLET POINTS ===== -->
            <div class="product-description">
                @php
                    $description = $product->description ?? '';
                    if (!empty($description)) {
                        // Convert newlines to <br> for basic display
                        $formatted = nl2br(e($description));
                        echo $formatted;
                    } else {
                        echo '<p>No description available</p>';
                    }
                @endphp
            </div>
            
            @if ($product->short_description)
                <div class="alert alert-light mt-2 p-2">
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
            <p>You can return this product within {{ $product->return_days ?? 30 }} days of delivery.</p>
            <p><strong>Exchange Available:</strong> Yes</p>
            <p>Exchange within {{ $product->return_days ?? 30 }} days of delivery.</p>
            <p><strong>Warranty:</strong> {{ $product->warranty_months ?? 0 }} months manufacturer warranty</p>
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
            <!-- ===== END PRODUCT WRAPPER ===== -->

            <!-- ===== RELATED PRODUCTS ===== -->
            @if (isset($relatedProducts) && $relatedProducts->count() > 0)
                <div class="related-products-section">
                    <h3 class="section-title">
                        <i class="fas fa-sync-alt"></i> You May Also Like
                    </h3>
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
                                        $firstVariant->total_price ??
                                            ($firstVariant->mrp ?? ($firstVariant->price ?? 0)),
                                    );
                                    $relatedStock = $relatedVariants->sum('stock');
                                    $relatedDiscountType = $firstVariant->discount_type ?? 'flat';
                                    $relatedDiscountValue = floatval($firstVariant->discount_value ?? 0);
                                } else {
                                    $relatedDisplayPrice = floatval($related->final_price ?? ($related->price ?? 0));
                                    $relatedMrp = floatval(
                                        $related->total_price ?? ($related->mrp ?? ($related->price ?? 0)),
                                    );
                                    $relatedStock = intval($related->stock ?? 0);
                                    $relatedDiscountType = $related->discount_type ?? 'flat';
                                    $relatedDiscountValue = floatval($related->discount_value ?? 0);
                                }

                                $relatedDiscountPercent = 0;
                                if ($relatedMrp > 0 && $relatedDisplayPrice > 0 && $relatedDisplayPrice < $relatedMrp) {
                                    $relatedDiscountPercent = round(
                                        (($relatedMrp - $relatedDisplayPrice) / $relatedMrp) * 100,
                                    );
                                }

                                $relatedBrandName = $related->brand ? $related->brand->name : null;
                                $hasRelatedBrand = !empty($relatedBrandName);

                                // ===== RELATED DISCOUNT TEXT =====
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

                                // Only show stock alert when stock <= 5
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
                            @endphp
                            <div class="col-md-3 col-sm-6 mb-4">
                                <div class="related-product-card"
                                    onclick="window.location.href='/product/{{ $related->id }}'">
                                    @if ($relatedDiscountPercent > 0)
                                        <div class="discount-badge">{{ $relatedDiscountText }}</div>
                                    @endif
                                    <button class="wishlist-btn"
                                        onclick="event.stopPropagation(); toggleRelatedWishlist({{ $related->id }}, '{{ addslashes($related->name) }}', {{ $relatedDisplayPrice }}, '{{ $relatedImageUrls[0] ?? '' }}')">
                                        <i class="far fa-heart" id="related-wishlist-icon-{{ $related->id }}"></i>
                                    </button>

                                    <div class="product-image-container">
                                        <img src="{{ $relatedImageUrls[0] ?? 'https://via.placeholder.com/300x300?text=No+Image' }}"
                                            alt="{{ $related->name }}"
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
                                        {!! $relatedStockAlert !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- ===== REVIEWS SECTION ===== -->
            <div class="reviews-section" id="reviewsSection">
                <div class="section-title">
                    <i class="fas fa-star"></i> Customer Reviews
                    <span class="review-count-badge" id="reviewCountBadge">0</span>
                </div>
                <div id="reviewsContainer">
                    <div class="text-center" id="reviewsLoading">
                        <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
                        <p class="mt-2">Loading reviews...</p>
                    </div>
                    <div id="reviewsList"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== SIZE GUIDE MODAL - SIDE POPUP ===== -->
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

    <!-- ===== MODALS ===== -->
    <!-- Login Modal -->
    <div class="custom-modal-overlay" id="loginModal">
        <div class="custom-modal-box">
            <button class="modal-close" onclick="closeLoginModal()">✕</button>
            <div class="modal-icon">
                <i class="fas fa-lock"></i>
            </div>
            <h2 class="modal-title">Login Required</h2>
            <p class="modal-subtitle">
                Please login to your account to continue. <br>
                <span style="color: #28a745; font-weight: 500;">Don't have an account? Register now!</span>
            </p>
            <div class="modal-buttons">
                <a href="{{ route('login') }}" class="btn-modal-primary">
                    <i class="fas fa-sign-in-alt me-2"></i> Login Now
                </a>
                <button class="btn-modal-secondary" onclick="closeLoginModal()">
                    <i class="fas fa-times me-2"></i> Cancel
                </button>
            </div>
            <div style="margin-top: 15px; font-size: 0.8rem; color: #999;">
                <i class="fas fa-user-plus me-1"></i>
                <a href="{{ route('member.register') }}"
                    style="color: #28a745; text-decoration: none; font-weight: 500;">
                    Create new account
                </a>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="image-modal" onclick="closeModal()">
        <span class="close-modal">&times;</span>
        <img class="modal-image" id="modalImage">
    </div>

    <!-- Review Media Lightbox -->
    <div class="modal fade" id="reviewMediaLightbox" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="background: rgba(0,0,0,0.95);">
                <div class="modal-body text-center p-0">
                    <button type="button" class="btn-close btn-close-white position-absolute"
                        style="top: 15px; right: 15px; z-index: 10;" data-bs-dismiss="modal"></button>
                    <div id="reviewLightboxContent"
                        style="max-height: 90vh; display: flex; align-items: center; justify-content: center; padding: 20px;">
                        <img id="reviewLightboxImage" src="" alt="Review Media"
                            style="max-width: 90vw; max-height: 85vh; border-radius: 8px;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ===== VARIABLE DECLARATIONS =====
        let currentIndex = 0;
        let totalImages = {{ $allImages->count() }};
        const images = @json(
            $allImages->map(function ($img) {
                return asset('storage/' . $img->image_path);
            }));

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

        // ===== VARIANT DATA FROM PHP =====
        const variantData = @json($variantDataArray);
        const colorData = @json($colorDataArray);

        // ===== SIZE GUIDE MODAL FUNCTIONS =====
        function openSizeGuide(event) {
            event.preventDefault();
            document.getElementById('sizeGuideModalOverlay').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeSizeGuide() {
            document.getElementById('sizeGuideModalOverlay').classList.remove('active');
            document.body.style.overflow = '';
        }

        // Close modal on overlay click
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('sizeGuideModalOverlay').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeSizeGuide();
                }
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeSizeGuide();
                }
            });
        });

        // ===== SELECT COLOR FUNCTION =====
        function selectColor(element, color) {
            document.querySelectorAll('.color-btn').forEach(btn => {
                btn.classList.remove('selected');
            });
            element.classList.add('selected');

            selectedColor = color;

            const imagesData = JSON.parse(element.dataset.images);
            if (imagesData && imagesData.length > 0) {
                document.getElementById('mainImage').src = imagesData[0];

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

                totalImages = imagesData.length;
                currentIndex = 0;
                images.length = 0;
                imagesData.forEach(img => images.push(img));
            }

            updateSizesForColor(color);
        }

        // ===== UPDATE SIZES FOR SELECTED COLOR =====
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
                        html +=
                            `<span style="font-size:9px; display:block; color:#28a745;">-${discountText}</span>`;
                    }
                    btn.innerHTML = html;
                    sizeOptions.appendChild(btn);
                });

                const firstSizeBtn = sizeOptions.querySelector('.size-btn:not(.out-of-stock-size)');
                if (firstSizeBtn) {
                    selectSize(firstSizeBtn);
                }
            }
        }

        // ===== SELECT SIZE FUNCTION - UPDATED WITH STOCK =====
        function selectSize(button) {
            document.querySelectorAll('.size-btn').forEach(btn => {
                btn.classList.remove('selected');
            });
            button.classList.add('selected');

            const size = button.dataset.size;
            const variantId = button.dataset.variantId;
            const price = parseFloat(button.dataset.price);
            const mrp = parseFloat(button.dataset.mrp);
            const stock = parseInt(button.dataset.stock);
            const discount = parseInt(button.dataset.discount);

            selectedSize = size;
            selectedVariantId = variantId;
            selectedPrice = price;
            selectedMrp = mrp;
            selectedStock = stock; // ===== THIS IS THE INDIVIDUAL VARIANT STOCK =====
            selectedDiscount = discount;

            // ===== UPDATE QUANTITY MAX BASED ON SELECTED VARIANT STOCK =====
            const quantityInput = document.getElementById('quantity');
            if (quantityInput) {
                quantityInput.max = stock > 0 ? stock : 1;
                if (parseInt(quantityInput.value) > stock) {
                    quantityInput.value = stock > 0 ? stock : 1;
                }
            }

            updatePriceDisplay(price, mrp, discount, button);
            updateStockDisplay(stock);
            document.getElementById('quantity').max = stock > 0 ? stock : 1;

            const stockInfo = document.getElementById('sizeStockInfo');
            const stockCount = document.getElementById('sizeStockCount');
            if (stockInfo) {
                if (stock > 0) {
                    stockInfo.style.display = 'block';
                    stockCount.textContent = stock;
                    stockCount.style.color = '#28a745';
                } else {
                    stockInfo.style.display = 'block';
                    stockCount.textContent = '0';
                    stockCount.style.color = '#dc3545';
                }
            }

            document.getElementById('sizeWarning').style.display = 'none';
        }

        // ===== SELECT DEFAULT SIZE =====
        function selectDefaultSize(button) {
            document.querySelectorAll('.size-btn').forEach(btn => {
                btn.classList.remove('selected');
            });
            button.classList.add('selected');
            selectedSize = button.dataset.size;
            selectedVariantId = null;
            document.getElementById('sizeWarning').style.display = 'none';
        }

        // ===== UPDATE PRICE DISPLAY =====
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

        // ===== UPDATE STOCK DISPLAY =====
        function updateStockDisplay(stock) {
            const stockStatus = document.getElementById('stockStatus');
            if (stock > 0) {
                if (stock <= 5) {
                    stockStatus.className = 'in-stock-low';
                    stockStatus.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Only ' + stock + ' left in stock!';
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

        // ===== CUSTOM LOGIN MODAL FUNCTIONS =====
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

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('loginModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeLoginModal();
                }
            });

            @if ($hasVariants && $firstVariant && !$hasColors)
                const firstButton = document.querySelector('.size-btn[data-variant-id="{{ $firstVariant->id }}"]');
                if (firstButton) {
                    selectSize(firstButton);
                }
            @endif

            @if ($hasColors)
                const firstColor = document.querySelector('.color-btn.selected');
                if (firstColor) {
                    const color = firstColor.dataset.color;
                    updateSizesForColor(color);
                }
            @endif
        });

        // ===== RELATED PRODUCTS WISHLIST =====
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

        // ============ IMAGE FUNCTIONS ============
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

        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft') prevImage();
            if (e.key === 'ArrowRight') nextImage();
            if (e.key === 'Escape') closeModal();
        });

        // ============ MODAL FUNCTIONS ============
        function openModal(src) {
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');
            modal.classList.add('show');
            modalImg.src = src;
        }

        function closeModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.remove('show');
        }

        // ============ TAB FUNCTIONS ============
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

        // ============ WISHLIST ============
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
                btn.style.color = '#dc3545';
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
                btn.style.background = '#dc3545';
                btn.style.color = 'white';
                showNotification('Added to wishlist!', 'success');
            }

            localStorage.setItem('wishlist', JSON.stringify(wishlist));
            updateWishlistCount();
        }

        // ============ QUANTITY ============
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

        // ============ ADD TO CART - UPDATED WITH STOCK CHECK =====
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

            // ===== CHECK SELECTED VARIANT STOCK =====
            if (selectedStock <= 0) {
                alert('Selected size is out of stock!');
                return;
            }

            let quantity = parseInt(document.getElementById('quantity').value);

            // ===== VALIDATE QUANTITY AGAINST SELECTED VARIANT STOCK =====
            if (quantity > selectedStock) {
                alert('Only ' + selectedStock + ' items available in stock for selected size!');
                document.getElementById('quantity').value = selectedStock;
                return;
            }

            let currentCart = JSON.parse(localStorage.getItem('cart')) || [];
            let existingItem = currentCart.find(item => item.id === productId && item.size === selectedSize && item
                .color === selectedColor);

            if (existingItem) {
                // ===== CHECK IF TOTAL QUANTITY EXCEEDS STOCK =====
                if (existingItem.quantity + quantity > selectedStock) {
                    alert('Only ' + selectedStock + ' items available in stock! You already have ' + existingItem.quantity +
                        ' in cart.');
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
            const sizeText = selectedSize ? ' (' + selectedSize + ')' : '';
            const colorText = selectedColor ? ' - ' + selectedColor : '';
            showNotification(productName + sizeText + colorText + ' added to cart!', 'success');
            updateCartCount();
        }

        // ============ BUY NOW - UPDATED WITH STOCK CHECK =====
        function buyNowDetail() {
            @if (!auth()->check())
                showLoginModal('buynow', {
                    productId: productId,
                    productName: productName,
                    productPrice: selectedPrice
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

            // ===== CHECK SELECTED VARIANT STOCK =====
            if (selectedStock <= 0) {
                alert('Selected size is out of stock!');
                return;
            }

            let quantity = parseInt(document.getElementById('quantity').value);

            // ===== VALIDATE QUANTITY AGAINST SELECTED VARIANT STOCK =====
            if (quantity > selectedStock) {
                alert('Only ' + selectedStock + ' items available in stock for selected size!');
                document.getElementById('quantity').value = selectedStock;
                return;
            }

            let form = document.createElement('form');
            form.method = 'POST';
            form.action = '/buy-now';

            let csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            form.appendChild(csrfInput);

            let productInput = document.createElement('input');
            productInput.type = 'hidden';
            productInput.name = 'product_id';
            productInput.value = productId;
            form.appendChild(productInput);

            let quantityInput = document.createElement('input');
            quantityInput.type = 'hidden';
            quantityInput.name = 'quantity';
            quantityInput.value = quantity;
            form.appendChild(quantityInput);

            if (selectedSize) {
                let sizeInput = document.createElement('input');
                sizeInput.type = 'hidden';
                sizeInput.name = 'size';
                sizeInput.value = selectedSize;
                form.appendChild(sizeInput);
            }

            if (selectedColor) {
                let colorInput = document.createElement('input');
                colorInput.type = 'hidden';
                colorInput.name = 'color';
                colorInput.value = selectedColor;
                form.appendChild(colorInput);
            }

            if (selectedVariantId) {
                let variantInput = document.createElement('input');
                variantInput.type = 'hidden';
                variantInput.name = 'variant_id';
                variantInput.value = selectedVariantId;
                form.appendChild(variantInput);
            }

            document.body.appendChild(form);
            form.submit();
        }

        // ============ NOTIFICATION ============
        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML =
                `<i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-info-circle'} me-2"></i> ${message}`;
            document.body.appendChild(notification);
            setTimeout(() => notification.remove(), 3000);
        }

        // ============ CART & WISHLIST COUNTS ============
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

        // ============ WISHLIST STATUS ============
        function checkWishlistStatus() {
            let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
            const isInWishlist = wishlist.some(item => item.id === productId);
            const btn = document.querySelector('.btn-wishlist');
            const icon = btn.querySelector('i');

            if (isInWishlist) {
                icon.className = 'fas fa-heart';
                btn.style.background = '#dc3545';
                btn.style.color = 'white';
            } else {
                icon.className = 'far fa-heart';
                btn.style.background = 'white';
                btn.style.color = '#dc3545';
            }
        }

        // ============ SAVE SELECTED SIZE ============
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

        function saveSelectedSize() {
            let savedSizes = JSON.parse(localStorage.getItem('selectedSizes')) || {};
            if (selectedSize) {
                savedSizes[productId] = selectedSize;
                localStorage.setItem('selectedSizes', JSON.stringify(savedSizes));
            }
        }

        // ============ REVIEW FUNCTIONS ============
        async function loadReviews() {
            const container = document.getElementById('reviewsList');
            const loading = document.getElementById('reviewsLoading');
            const badge = document.getElementById('reviewCountBadge');

            try {
                const response = await fetch(`/api/product-reviews/${productId}`);
                const data = await response.json();

                loading.style.display = 'none';

                if (data.success && data.reviews && data.reviews.length > 0) {
                    badge.textContent = data.reviews.length;
                    container.innerHTML = data.reviews.map(review => renderReviewCard(review)).join('');
                } else {
                    container.innerHTML = `
                <div class="no-reviews">
                    <i class="fas fa-comment-slash"></i>
                    <h5>No reviews yet</h5>
                    <p class="text-muted">Be the first to review this product!</p>
                </div>
            `;
                    badge.textContent = '0';
                }
            } catch (error) {
                console.error('Error loading reviews:', error);
                loading.style.display = 'none';
                container.innerHTML = `
            <div class="no-reviews">
                <i class="fas fa-exclamation-circle text-danger"></i>
                <h5>Could not load reviews</h5>
                <p class="text-muted">Please try again later</p>
            </div>
        `;
                badge.textContent = '0';
            }
        }

        function renderReviewCard(review) {
            let starsHtml = '';
            for (let i = 1; i <= 5; i++) {
                if (i <= review.rating) {
                    starsHtml += '<i class="fas fa-star"></i>';
                } else {
                    starsHtml += '<i class="fas fa-star star-empty"></i>';
                }
            }

            let mediaHtml = '';
            if (review.images && review.images.length > 0) {
                mediaHtml += '<div class="review-media">';
                review.images.forEach(function(image) {
                    mediaHtml += `
                <div class="media-item" onclick="openReviewMedia('${image}')">
                    <img src="/storage/${image}" alt="Review Image">
                </div>
            `;
                });
                mediaHtml += '</div>';
            }

            if (review.videos && review.videos.length > 0) {
                mediaHtml += '<div class="review-media">';
                review.videos.forEach(function(video) {
                    mediaHtml += `
                <div class="media-item" onclick="openReviewMedia('${video}', 'video')">
                    <video src="/storage/${video}"></video>
                </div>
            `;
                });
                mediaHtml += '</div>';
            }

            const date = new Date(review.created_at);
            const formattedDate = date.toLocaleDateString('en-IN', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });

            return `
        <div class="review-card">
            <div class="review-header">
                <span class="review-user"><i class="fas fa-user-circle"></i> ${review.user_name || 'Anonymous'}</span>
                <span class="review-date">${formattedDate}</span>
            </div>
            <div class="review-stars">${starsHtml}</div>
            <div class="review-text">${escapeHtml(review.description)}</div>
            ${mediaHtml}
            <span class="review-verified"><i class="fas fa-check-circle"></i> Verified Purchase</span>
        </div>
    `;
        }

        function escapeHtml(text) {
            if (!text) return '';
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function openReviewMedia(src, type = 'image') {
            const modal = new bootstrap.Modal(document.getElementById('reviewMediaLightbox'));
            const content = document.getElementById('reviewLightboxContent');

            if (type === 'video') {
                content.innerHTML = `
            <video controls style="max-width: 90vw; max-height: 85vh; border-radius: 8px;">
                <source src="/storage/${src}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        `;
            } else {
                content.innerHTML =
                    `<img src="/storage/${src}" alt="Review Media" style="max-width: 90vw; max-height: 85vh; border-radius: 8px;">`;
            }

            modal.show();
        }

        // ============ DOCUMENT READY ============
        document.addEventListener('DOMContentLoaded', function() {
            const firstTab = document.querySelector('.info-tab-header');
            if (firstTab) {
                firstTab.classList.add('active');
                if (firstTab.nextElementSibling) firstTab.nextElementSibling.classList.add('show');
            }

            updateCartCount();
            updateWishlistCount();
            checkWishlistStatus();
            loadSavedSize();

            const mainImageArea = document.getElementById('mainImageArea');
            if (mainImageArea) {
                mainImageArea.addEventListener('click', function(e) {
                    if (!e.target.classList.contains('nav-arrow')) {
                        openModal(getCurrentImageSrc());
                    }
                });
            }

            loadReviews();

            // ===== SET INITIAL QUANTITY MAX =====
            const initialStock = {{ $displayStock }};
            const quantityInput = document.getElementById('quantity');
            if (quantityInput && initialStock > 0) {
                quantityInput.max = initialStock;
            }
        });
    </script>
@endsection
