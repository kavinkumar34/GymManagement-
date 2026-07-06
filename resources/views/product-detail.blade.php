{{-- resources/views/product-detail.blade.php --}}
@extends('layouts.app')

@section('content')
    <style>
        /* Rest of your existing styles (keep everything except delivery-section styles) */
        .product-detail-container {
            margin-top: 40px;
            overflow: visible;
        }



        .vertical-thumbnails {
            width: 120px;
        }

        .vertical-thumb {
            width: 110px;
            height: 110px;
        }

        .vertical-thumbnails::-webkit-scrollbar {
            width: 3px;
        }

        .vertical-thumbnails::-webkit-scrollbar-thumb {
            background: #dc3545;
            border-radius: 10px;
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



        .main-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
            transition: .3s;
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


        .navbar {
            position: sticky;
            top: 0;
            z-index: 9999;
            background: #fff;
        }

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

        .product-subtitle {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
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

        .btn-add-cart:disabled,
        .btn-buy-now:disabled,
        .btn-wishlist:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none !important;
        }

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

        .specs-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .specs-list li {
            padding: 6px 0;
            border-bottom: 1px solid #eee;
        }

        .specs-list li strong {
            width: 110px;
            display: inline-block;
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

        /* ===== CUSTOM LOGIN MODAL STYLES ===== */
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

        .custom-modal-box .btn-modal-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(40, 167, 69, 0.3);
            color: white;
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

        .custom-modal-box .btn-modal-secondary:hover {
            background: #cbd5e1;
            color: #1a1a2e;
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

        .custom-modal-box .modal-close:hover {
            color: #dc3545;
            transform: rotate(90deg);
        }

        @media (max-width: 576px) {
            .custom-modal-box {
                padding: 30px 20px;
            }

            .custom-modal-box .modal-icon {
                width: 60px;
                height: 60px;
                font-size: 2rem;
            }

            .custom-modal-box .modal-title {
                font-size: 1.2rem;
            }

            .custom-modal-box .modal-subtitle {
                font-size: 0.85rem;
            }

            .custom-modal-box .modal-buttons {
                flex-direction: column;
            }

            .custom-modal-box .btn-modal-primary,
            .custom-modal-box .btn-modal-secondary {
                width: 100%;
                text-align: center;
            }
        }

        /* ⭐ NEW: Review Section Styles */
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

        .reviews-section .section-title i {
            color: #dc3545;
        }

        .review-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border-left: 4px solid #dc3545;
            transition: transform 0.2s;
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

        .review-card .review-user i {
            color: #dc3545;
            margin-right: 5px;
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

        .review-card .review-media .media-item:hover {
            transform: scale(1.05);
        }

        .review-card .review-media .media-item img,
        .review-card .review-media .media-item video {
            width: 100%;
            height: 100%;
            object-fit: cover;
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

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* ===== RELATED PRODUCTS SECTION - FIXED IMAGE GAP ===== */
        .related-products-section {
            margin-top: 40px;
            padding: 20px 0;
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

        .related-products-section .section-title i {
            color: #dc3545;
        }

        .related-product-card {
            border: none;
            border-radius: 15px;
            transition: transform 0.3s, box-shadow 0.3s;
            overflow: hidden;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            height: 100%;
            position: relative;
            background: white;
            cursor: pointer;
        }

        .related-product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        /* FIX: Image slider container - removed padding-top: 100% and using aspect-ratio instead */
        .related-product-card .product-image-slider {
            position: relative;
            overflow: hidden;
            background: #f5f5f5;
            width: 100%;
            aspect-ratio: 1 / 1;
            /* This creates square aspect ratio without extra gap */
        }

        .related-product-card .product-image-slider .carousel-inner {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .related-product-card .product-image-slider .carousel-item {
            width: 100%;
            height: 100%;
        }

        .related-product-card .product-image-slider .carousel-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            background: #f5f5f5;
        }

        .related-product-card .product-image-slider .carousel-control-prev,
        .related-product-card .product-image-slider .carousel-control-next {
            opacity: 0;
            transition: opacity 0.3s;
            width: 28px;
            height: 28px;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            z-index: 10;
        }

        .related-product-card:hover .product-image-slider .carousel-control-prev,
        .related-product-card:hover .product-image-slider .carousel-control-next {
            opacity: 1;
        }

        .related-product-card .product-image-slider .carousel-control-prev {
            left: 6px;
        }

        .related-product-card .product-image-slider .carousel-control-next {
            right: 6px;
        }

        .related-product-card .product-image-slider .carousel-control-prev-icon,
        .related-product-card .product-image-slider .carousel-control-next-icon {
            background-size: 60%;
            width: 14px;
            height: 14px;
        }

        .related-product-card .card-body {
            text-align: left;
            padding: 10px 12px;
        }

        .related-product-card .card-title {
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: #1e293b;
            text-align: left;
        }

        .related-product-card .product-price-display {
            font-size: 1rem;
            font-weight: bold;
            color: #dc3545;
        }

        .related-product-card .product-old-price-display {
            text-decoration: line-through;
            color: #999;
            font-size: 0.8rem;
            margin-right: 8px;
        }

        .related-product-card .discount-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #dc3545;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
            z-index: 5;
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
            z-index: 5;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            transition: all 0.3s;
        }

        .related-product-card .wishlist-btn i {
            font-size: 1.1rem;
            transition: all 0.3s;
        }

        .related-product-card .wishlist-btn i.far {
            color: #999;
        }

        .related-product-card .wishlist-btn i.fas {
            color: #dc3545;
        }

        .related-product-card .wishlist-btn:hover {
            transform: scale(1.1);
        }

        .related-product-card .product-rating {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 4px;
            justify-content: flex-start;
        }

        .related-product-card .product-rating .stars {
            display: flex;
            gap: 2px;
        }

        .related-product-card .product-rating .stars i {
            font-size: 0.85rem;
        }

        .related-product-card .product-rating .stars i.fa-star,
        .related-product-card .product-rating .stars i.fa-star-half-alt {
            color: #f59e0b !important;
        }

        .related-product-card .product-rating .stars i.far.fa-star {
            color: #e0e0e0 !important;
        }

        .related-product-card .product-rating .rating-value {
            font-size: 0.9rem;
            font-weight: 600;
            color: #1e293b;
        }

        .related-product-card .product-stock-low {
            font-size: 0.9rem;
            color: #ef4444;
            margin-top: 6px;
            text-align: left;
            font-weight: 600;
            background: #fef2f2;
            padding: 4px 10px;
            border-radius: 6px;
            border-left: 3px solid #ef4444;
            display: inline-block;
            width: 100%;
        }



        .right-side-content {
            padding-left: 45px;
            position: relative;
        }

        .related-product-card .product-stock-low i {
            font-size: 0.9rem;
            margin-right: 6px;
            color: #ef4444;
        }




        .main-image-area {
            flex: 1;
            width: 100%;
            min-height: 500px;
            height: 100%;
            border-radius: 15px;
            overflow: hidden;
            background: #f8f8f8;
            position: relative;
        }

        .product-wrapper {
            display: flex;
            align-items: flex-start;
            gap: 40px;
        }

        .left-column {
            width: 48%;
        }

        .right-column {
            width: 52%;
        }

        .product-gallery-wrapper {
            display: flex;
            gap: 25px;
            position: sticky;
            top: 90px;
            /* below navbar */
            align-self: flex-start;
        }

        .main-image-area {
            width: 100%;
            height: 900px;
            background: #f8f8f8;
            border-radius: 18px;
            overflow: hidden;
        }

        .main-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .right-side-content {
            width: 100%;
        }

        @media (max-width: 768px) {
            .product-gallery-wrapper {
                flex-direction: column-reverse;
            }

            .vertical-thumbnails {
                flex-direction: row;
                width: 100%;
                justify-content: center;
            }

            .main-image-area {
                min-height: 350px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-add-cart,
            .btn-buy-now,
            .btn-wishlist {
                width: 100%;
            }

            .review-card .review-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .related-product-card .product-image-slider .carousel-control-prev,
            .related-product-card .product-image-slider .carousel-control-next {
                opacity: 1;
                width: 24px;
                height: 24px;
            }
        }

        @media (max-width: 576px) {

            .related-product-card .product-image-slider .carousel-control-prev,
            .related-product-card .product-image-slider .carousel-control-next {
                width: 20px;
                height: 20px;
            }

            .related-product-card .product-image-slider .carousel-control-prev-icon,
            .related-product-card .product-image-slider .carousel-control-next-icon {
                width: 10px;
                height: 10px;
            }
        }
    </style>

    <div class="container-fluid px-5 mt-4">
        <div class="product-detail-container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">{{ $product->category->name ?? 'Products' }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($product->name, 50) }}</li>
                </ol>
            </nav>

            <div class="product-wrapper">
                <div class="left-column">
                    <div class="product-gallery-wrapper">
                        <div class="vertical-thumbnails" id="verticalThumbnails">
                            @php
                                $allImages = \App\Models\ProductImage::where('product_id', $product->id)
                                    ->orderBy('display_order')
                                    ->get();

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
                            @endphp

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

                <div class="left-column">
                    <div class="right-side-content">
                        <div class="brand-name">
                            <i class="fas fa-building"></i> {{ $product->brand->name ?? 'BRAVE' }}
                        </div>

                        <h1 class="product-title">{{ $product->name }}</h1>
                        <p class="product-subtitle">{{ $product->short_description ?? 'Graphic Printed T-Shirt' }}</p>
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

                        <div class="price-section">
                            @if ($product->discount_price && $product->discount_price < $product->price)
                                <span class="current-price">₹{{ number_format($product->discount_price, 2) }}</span>
                                <span class="old-price">₹{{ number_format($product->price, 2) }}</span>
                                <span
                                    class="discount-badge">{{ round((($product->price - $product->discount_price) / $product->price) * 100) }}%
                                    OFF</span>
                            @else
                                <span class="current-price">₹{{ number_format($product->price, 2) }}</span>
                            @endif
                            <div class="tax-text">Inclusive of all taxes</div>
                        </div>

                        <div class="size-section">
                            <div class="size-header">
                                <span class="size-label">Select Size</span>
                                <a href="#" class="size-guide" onclick="showSizeGuide(event)">Size Guide</a>
                            </div>
                            <div class="size-options" id="sizeOptions">
                                @php
                                    $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
                                @endphp
                                @foreach ($sizes as $size)
                                    <button type="button" class="size-btn"
                                        data-size="{{ $size }}">{{ $size }}</button>
                                @endforeach
                            </div>
                            <div id="sizeWarning" class="size-warning">Please select a size first</div>
                        </div>

                        <div class="quantity-section">
                            <label class="quantity-label">Quantity</label>
                            <div class="quantity-selector">
                                <button class="quantity-btn" onclick="decrementQuantity()">-</button>
                                <input type="number" id="quantity" class="quantity-input" value="1" min="1"
                                    max="{{ $product->stock > 0 ? $product->stock : 10 }}">
                                <button class="quantity-btn" onclick="incrementQuantity()">+</button>
                            </div>
                        </div>

                        <div class="stock-status">
                            @if ($product->stock > 0)
                                <span class="in-stock"><i class="fas fa-check-circle"></i> In Stock ({{ $product->stock }}
                                    items available)</span>
                            @else
                                <span class="out-of-stock"><i class="fas fa-times-circle"></i> Out of Stock</span>
                            @endif
                        </div>


                        <div class="action-buttons">
                            <button class="btn-wishlist" id="wishlistBtn" onclick="toggleWishlistDetail()">
                                <i class="far fa-heart"></i> Wishlist
                            </button>
                            <button class="btn-add-cart" id="addToCartBtn" onclick="addToCartDetail()">
                                <i class="fas fa-shopping-cart"></i> Add to Cart
                            </button>

                        </div>

                        <!-- Delivery Information Box -->
                        <div class="delivery-box">
                            <div class="delivery-item">
                                <i class="fas fa-truck"></i>
                                <div class="delivery-text">
                                    <strong>CASH ON DELIVERY</strong>
                                    <small>Available</small>
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
                                    <small>Free delivery on orders above ₹999</small>
                                </div>
                            </div>
                        </div>


                        <div class="product-info-tabs">
                            <div class="info-tab">
                                <div class="info-tab-header" onclick="toggleTab(this)">
                                    <span><i class="fas fa-info-circle"></i> PRODUCT DETAILS</span>
                                    <span class="arrow">▼</span>
                                </div>
                                <div class="info-tab-content">
                                    <p>{{ $product->description ?? 'No description available' }}</p>
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
                                    <span><i class="fas fa-clipboard-list"></i> KNOW YOUR PRODUCT</span>
                                    <span class="arrow">▼</span>
                                </div>
                                <div class="info-tab-content">
                                    <ul class="specs-list">
                                        <li><strong>SKU:</strong> {{ $product->sku ?? 'N/A' }}</li>
                                        <li><strong>GST:</strong> {{ $product->gst_percentage ?? 18 }}%</li>
                                        <li><strong>Weight:</strong> {{ $product->weight ?? 0 }}
                                            {{ $product->weight_unit ?? 'kg' }}</li>
                                        @if ($product->dimensions)
                                            <li><strong>Dimensions:</strong> {{ $product->dimensions }}</li>
                                        @endif
                                        <li><strong>Material:</strong> High Quality Cotton</li>
                                        <li><strong>Fit:</strong> Regular Fit</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="info-tab">
                                <div class="info-tab-header" onclick="toggleTab(this)">
                                    <span><i class="fas fa-undo-alt"></i> RETURN & EXCHANGE</span>
                                    <span class="arrow">▼</span>
                                </div>
                                <div class="info-tab-content">
                                    <p>You can return this product within {{ $product->return_days ?? 30 }} days of
                                        delivery.</p>
                                    <p><strong>Exchange Available:</strong> Yes</p>
                                    <p>Exchange within {{ $product->return_days ?? 30 }} days of delivery.</p>
                                    <p><strong>Warranty:</strong> {{ $product->warranty_months ?? 0 }} months manufacturer
                                        warranty</p>
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
        </div>

        <!-- ===== RELATED PRODUCTS SECTION - FIXED IMAGE GAP ===== -->
        @if (isset($relatedProducts) && $relatedProducts->count() > 0)
            <div class="related-products-section">
                <h3 class="section-title">
                    <i class="fas fa-sync-alt"></i> You May Also Like
                </h3>
                <div class="product-wrapper">
                    @foreach ($relatedProducts as $related)
                        @php
                            // Get images for related product
                            $relatedImages = [];
                            if ($related->image) {
                                $relatedImages[] = $related->image;
                            }
                            if (isset($related->gallery_images) && is_array($related->gallery_images)) {
                                $relatedImages = array_merge($relatedImages, $related->gallery_images);
                            }
                            if (empty($relatedImages)) {
                                $relatedImages = ['https://via.placeholder.com/300x300?text=No+Image'];
                            }
                            $relatedImageUrls = array_map(function ($img) {
                                return strpos($img, 'http') === 0 ? $img : '/storage/' . $img;
                            }, $relatedImages);
                            $relatedCarouselId = 'relatedCarousel-' . $related->id;
                            $hasMultipleRelatedImages = count($relatedImageUrls) > 1;

                            // Rating - Yellow Filled Stars
                            $relatedRating = floatval($related->rating ?? 0);
                            $fullStars = floor($relatedRating);
                            $halfStar = $relatedRating - $fullStars >= 0.5;
                            $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                            $relatedStarsHtml = '';
                            for ($i = 0; $i < $fullStars; $i++) {
                                $relatedStarsHtml .= '<i class="fas fa-star"></i>';
                            }
                            if ($halfStar) {
                                $relatedStarsHtml .= '<i class="fas fa-star-half-alt"></i>';
                            }
                            for ($i = 0; $i < $emptyStars; $i++) {
                                $relatedStarsHtml .= '<i class="far fa-star"></i>';
                            }

                            // Stock Alert - Only when stock <= 5
                            $relatedStock = intval($related->stock ?? 0);
                            $relatedStockAlertHtml = '';
                            if ($relatedStock <= 5 && $relatedStock > 0) {
                                $relatedStockAlertHtml =
                                    '
                        <div class="product-stock-low">
                            <i class="fas fa-exclamation-triangle"></i>
                            Only ' .
                                    $relatedStock .
                                    ' left in stock!
                        </div>
                    ';
                            }

                            // Discount
                            $relatedDiscountPercent = 0;
                            if ($related->discount_price && $related->discount_price < $related->price) {
                                $relatedDiscountPercent = round(
                                    (($related->price - $related->discount_price) / $related->price) * 100,
                                );
                            }
                        @endphp
                        <div class="col-md-3 col-sm-6 mb-4">
                            <div class="related-product-card"
                                onclick="window.location.href='/product/{{ $related->id }}'">
                                @if ($relatedDiscountPercent > 0)
                                    <div class="discount-badge">-{{ $relatedDiscountPercent }}%</div>
                                @endif
                                <button class="wishlist-btn"
                                    onclick="event.stopPropagation(); toggleRelatedWishlist({{ $related->id }}, '{{ addslashes($related->name) }}', {{ $related->discount_price ?? $related->price }}, '{{ $relatedImageUrls[0] ?? '' }}')">
                                    <i class="far fa-heart" id="related-wishlist-icon-{{ $related->id }}"></i>
                                </button>

                                <div id="{{ $relatedCarouselId }}" class="carousel slide product-image-slider"
                                    data-bs-ride="false" data-bs-interval="false">
                                    <div class="carousel-inner">
                                        @foreach ($relatedImageUrls as $idx => $imgUrl)
                                            <div class="carousel-item {{ $idx == 0 ? 'active' : '' }}">
                                                <img src="{{ $imgUrl }}" alt="{{ $related->name }}">
                                            </div>
                                        @endforeach
                                    </div>
                                    @if ($hasMultipleRelatedImages)
                                        <button class="carousel-control-prev" type="button"
                                            data-bs-target="#{{ $relatedCarouselId }}" data-bs-slide="prev"
                                            onclick="event.stopPropagation()">
                                            <span class="carousel-control-prev-icon"></span>
                                        </button>
                                        <button class="carousel-control-next" type="button"
                                            data-bs-target="#{{ $relatedCarouselId }}" data-bs-slide="next"
                                            onclick="event.stopPropagation()">
                                            <span class="carousel-control-next-icon"></span>
                                        </button>
                                    @endif
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title">{{ Str::limit($related->name, 35) }}</h5>
                                    <div>
                                        @if ($related->discount_price)
                                            <span
                                                class="product-old-price-display">₹{{ number_format($related->price, 2) }}</span>
                                            <span
                                                class="product-price-display">₹{{ number_format($related->discount_price, 2) }}</span>
                                        @else
                                            <span
                                                class="product-price-display">₹{{ number_format($related->price, 2) }}</span>
                                        @endif
                                    </div>

                                    <!-- Rating Stars - Yellow Filled -->
                                    <div class="product-rating">
                                        <div class="stars">{!! $relatedStarsHtml !!}</div>
                                        <span
                                            class="rating-value">{{ $relatedRating > 0 ? number_format($relatedRating, 1) : '0.0' }}</span>
                                    </div>

                                    <!-- Low Stock Alert -->
                                    {!! $relatedStockAlertHtml !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- ⭐⭐⭐ NEW: REVIEWS SECTION ⭐⭐⭐ -->
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

    <!-- ===== CUSTOM LOGIN MODAL - GREEN BUTTON WITH CORRECT LINKS ===== -->
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

    <div id="imageModal" class="image-modal" onclick="closeModal()">
        <span class="close-modal">&times;</span>
        <img class="modal-image" id="modalImage">
    </div>

    <div id="sizeGuideModal" class="image-modal" style="display:none;" onclick="closeSizeGuide()">
        <div style="background:white; border-radius:15px; max-width:500px; width:90%; padding:20px;"
            onclick="event.stopPropagation()">
            <span style="float:right; cursor:pointer; font-size:24px;" onclick="closeSizeGuide()">&times;</span>
            <h4>Size Guide</h4>
            <table style="width:100%; border-collapse:collapse; margin-top:15px;">
                <tr style="background:#f0f0f0;">
                    <th style="padding:10px; border:1px solid #ddd;">Size</th>
                    <th style="padding:10px; border:1px solid #ddd;">Chest (inches)</th>
                    <th style="padding:10px; border:1px solid #ddd;">Length (inches)</th>
                </tr>
                <tr>
                    <td style="padding:8px; border:1px solid #ddd;">XS</td>
                    <td style="padding:8px; border:1px solid #ddd;">34-36</td>
                    <td style="padding:8px; border:1px solid #ddd;">27</td>
                </tr>
                <tr>
                    <td style="padding:8px; border:1px solid #ddd;">S</td>
                    <td style="padding:8px; border:1px solid #ddd;">36-38</td>
                    <td style="padding:8px; border:1px solid #ddd;">28</td>
                </tr>
                <tr>
                    <td style="padding:8px; border:1px solid #ddd;">M</td>
                    <td style="padding:8px; border:1px solid #ddd;">38-40</td>
                    <td style="padding:8px; border:1px solid #ddd;">29</td>
                </tr>
                <tr>
                    <td style="padding:8px; border:1px solid #ddd;">L</td>
                    <td style="padding:8px; border:1px solid #ddd;">40-42</td>
                    <td style="padding:8px; border:1px solid #ddd;">30</td>
                </tr>
                <tr>
                    <td style="padding:8px; border:1px solid #ddd;">XL</td>
                    <td style="padding:8px; border:1px solid #ddd;">42-44</td>
                    <td style="padding:8px; border:1px solid #ddd;">31</td>
                </tr>
                <tr>
                    <td style="padding:8px; border:1px solid #ddd;">XXL</td>
                    <td style="padding:8px; border:1px solid #ddd;">44-46</td>
                    <td style="padding:8px; border:1px solid #ddd;">32</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- ⭐ Lightbox Modal for Review Media -->
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

        // Close modal on overlay click
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('loginModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeLoginModal();
                }
            });
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

        let currentIndex = 0;
        let totalImages = {{ $allImages->count() }};
        const images = @json(
            $allImages->map(function ($img) {
                return asset('storage/' . $img->image_path);
            }));

        const productId = {{ $product->id }};
        const productName = "{{ addslashes($product->name) }}";
        const productPrice = {{ $product->discount_price ?? $product->price }};
        const productImage = "{{ asset('storage/' . ($allImages[0]->image_path ?? $product->image)) }}";
        let selectedSize = null;

        const wishlistBtn = document.getElementById('wishlistBtn');
        const addToCartBtn = document.getElementById('addToCartBtn');

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
            // Generate stars
            let starsHtml = '';
            for (let i = 1; i <= 5; i++) {
                if (i <= review.rating) {
                    starsHtml += '<i class="fas fa-star"></i>';
                } else {
                    starsHtml += '<i class="fas fa-star star-empty"></i>';
                }
            }

            // Media HTML
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

            // Format date
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

        // ============ EXISTING FUNCTIONS ============

        // Function to change main image
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

        function showSizeGuide(event) {
            event.preventDefault();
            document.getElementById('sizeGuideModal').style.display = 'flex';
        }

        function closeSizeGuide() {
            document.getElementById('sizeGuideModal').style.display = 'none';
        }

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

        function toggleWishlistDetail() {
            @if (!auth()->check())
                showLoginModal('wishlist', {
                    id: productId,
                    name: productName,
                    price: productPrice,
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
                    price: productPrice,
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

        document.querySelectorAll('.size-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('selected'));
                this.classList.add('selected');
                selectedSize = this.getAttribute('data-size');
                document.getElementById('sizeWarning').style.display = 'none';
                saveSelectedSize();
            });
        });

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

        function addToCartDetail() {
            @if (!auth()->check())
                showLoginModal('cart', {
                    id: productId,
                    name: productName,
                    price: productPrice,
                    image: productImage
                });
                return;
            @endif

            if (!selectedSize) {
                document.getElementById('sizeWarning').style.display = 'block';
                document.getElementById('sizeWarning').scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                return;
            }

            let quantity = parseInt(document.getElementById('quantity').value);
            let currentCart = JSON.parse(localStorage.getItem('cart')) || [];
            let existingItem = currentCart.find(item => item.id === productId && item.size === selectedSize);

            if (existingItem) {
                existingItem.quantity += quantity;
            } else {
                currentCart.push({
                    id: productId,
                    name: productName,
                    price: productPrice,
                    image: productImage,
                    quantity: quantity,
                    size: selectedSize
                });
            }

            localStorage.setItem('cart', JSON.stringify(currentCart));
            showNotification(productName + ' (' + selectedSize + ') added to cart!', 'success');
            updateCartCount();
        }

        function buyNowDetail() {
            @if (!auth()->check())
                showLoginModal('buynow', {
                    productId: productId,
                    productName: productName,
                    productPrice: productPrice
                });
                return;
            @endif

            if (!selectedSize) {
                document.getElementById('sizeWarning').style.display = 'block';
                document.getElementById('sizeWarning').scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                return;
            }

            let quantity = parseInt(document.getElementById('quantity').value);

            let form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('buy.now') }}';

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

            let sizeInput = document.createElement('input');
            sizeInput.type = 'hidden';
            sizeInput.name = 'size';
            sizeInput.value = selectedSize;
            form.appendChild(sizeInput);

            document.body.appendChild(form);
            form.submit();
        }

        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML =
                `<i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-info-circle'} me-2"></i> ${message}`;
            document.body.appendChild(notification);
            setTimeout(() => notification.remove(), 3000);
        }

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

        function loadSavedSize() {
            let savedSizes = JSON.parse(localStorage.getItem('selectedSizes')) || {};
            if (savedSizes[productId]) {
                selectedSize = savedSizes[productId];
                document.querySelectorAll('.size-btn').forEach(btn => {
                    if (btn.getAttribute('data-size') === selectedSize) {
                        btn.classList.add('selected');
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

            // Load reviews
            loadReviews();
        });
    </script>
@endsection
