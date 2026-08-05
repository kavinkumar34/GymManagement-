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

        /* ===== BREADCRUMB ===== */
        .breadcrumb-section {
            background: var(--fog);
            padding: 10px 0;
            margin-bottom: 20px;
            margin-top: 15px;
            border-bottom: 1px solid var(--line);
        }

        .breadcrumb-section .breadcrumb {
            margin: 0;
            background: transparent;
            padding: 0;
        }

        .breadcrumb-section .breadcrumb-item a {
            color: var(--steel);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .breadcrumb-section .breadcrumb-item a:hover {
            color: var(--signal);
        }

        .breadcrumb-section .breadcrumb-item.active {
            color: var(--ink);
            font-weight: 700;
            font-size: 0.85rem;
        }

        .breadcrumb-section .breadcrumb-item+.breadcrumb-item::before {
            color: var(--steel);
        }

        /* ===== SUB CATEGORIES ===== */
        .sub-categories-section {
            margin-bottom: 30px;
            padding: 20px 0;
            background: #ffffff;
            border-radius: var(--radius-lg);
            border: 1px solid var(--line);
        }

        .sub-categories-title {
            font-family: var(--font-display);
            font-weight: 400;
            font-size: 1.2rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            color: var(--ink);
            margin-bottom: 18px;
            padding: 0 20px;
        }

        .sub-categories-scroll {
            display: flex;
            gap: 16px;
            overflow-x: auto;
            padding: 5px 20px 15px 20px;
            scrollbar-width: thin;
            scrollbar-color: var(--signal) var(--fog);
            -webkit-overflow-scrolling: touch;
        }

        .sub-categories-scroll::-webkit-scrollbar {
            height: 6px;
        }

        .sub-categories-scroll::-webkit-scrollbar-track {
            background: var(--fog);
            border-radius: 10px;
        }

        .sub-categories-scroll::-webkit-scrollbar-thumb {
            background: var(--signal);
            border-radius: 10px;
        }

        .sub-category-item {
            flex: 0 0 auto;
            min-width: 230px;
            height: 240px;
            text-align: center;
            padding: 18px 20px;
            background: white;
            border-radius: var(--radius-md);
            border: 2px solid var(--line);
            transition: all 0.3s;
            cursor: pointer;
            text-decoration: none;
            color: var(--ink);
            box-shadow: var(--shadow-card);
            position: relative;
            overflow: hidden;
        }

        .sub-category-item:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-card-hover);
            border-color: var(--signal);
        }

        .sub-category-item.active {
            border-color: var(--signal);
            background: var(--signal);
            color: white;
            box-shadow: 0 8px 25px rgba(255, 68, 5, 0.3);
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
            background: var(--fog);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            font-size: 2rem;
            color: var(--steel);
            border: 3px solid var(--line);
            transition: all 0.3s;
        }

        .sub-category-item:hover .sub-cat-icon {
            border-color: var(--signal);
            color: var(--signal);
        }

        .sub-category-item.active .sub-cat-icon {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border-color: white;
        }

        .sub-category-item .sub-cat-name {
            display: block;
            font-family: var(--font-body);
            font-size: 0.9rem;
            font-weight: 700;
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

        /* ===== FILTER SIDEBAR ===== */
        .filter-sidebar-wrapper {
            position: sticky;
            top: 115px;
            align-self: flex-start;
            height: calc(100vh - 115px);
        }

        .filter-sidebar {
            background: white;
            border-radius: var(--radius-lg);
            padding: 20px;
            box-shadow: var(--shadow-card);
            height: calc(100vh - 125px);
            overflow-y: auto;
            border: 1px solid var(--line);
            margin-top: 0;
        }

        .filter-sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .filter-sidebar::-webkit-scrollbar-track {
            background: var(--fog);
            border-radius: 10px;
        }

        .filter-sidebar::-webkit-scrollbar-thumb {
            background: var(--signal);
            border-radius: 10px;
        }

        .filter-section {
            margin-bottom: 18px;
            border-bottom: 1px solid var(--line);
            padding-bottom: 15px;
        }

        .filter-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .filter-title {
            font-family: var(--font-body);
            font-size: 0.9rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--ink);
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            user-select: none;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .filter-title i {
            font-size: 0.75rem;
            color: var(--signal);
            transition: transform 0.3s ease;
        }

        .filter-title.collapsed i {
            transform: rotate(-90deg);
        }

        .filter-content {
            display: none;
            transition: all 0.3s ease;
        }

        .filter-content.show {
            display: block;
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
            color: var(--steel);
            transition: all 0.3s;
            font-weight: 500;
        }

        .filter-options label:hover {
            color: var(--signal);
        }

        .filter-options input[type="checkbox"],
        .filter-options input[type="radio"] {
            width: 14px;
            height: 14px;
            cursor: pointer;
            accent-color: var(--signal);
        }

        /* ===== SIZE OPTIONS - DYNAMIC ===== */
        .size-options {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .size-btn {
            padding: 4px 14px;
            border: 1px solid var(--line);
            border-radius: 20px;
            font-size: 0.7rem;
            cursor: pointer;
            transition: all 0.3s;
            background: white;
            font-weight: 600;
            color: var(--ink-soft);
        }

        .size-btn:hover,
        .size-btn.active {
            background: var(--signal);
            border-color: var(--signal);
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
            padding: 4px 12px;
            border: 1px solid var(--line);
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s;
            background: white;
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--ink-soft);
        }

        .color-filter-item:hover,
        .color-filter-item.active {
            border-color: var(--signal);
            background: var(--signal);
            color: white;
        }

        .color-filter-item .color-dot-small {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 2px solid var(--line);
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
            background: var(--fog);
            color: var(--ink-soft);
            border: none;
            border-radius: 25px;
            padding: 8px 16px;
            font-size: 0.75rem;
            font-weight: 700;
            cursor: pointer;
            flex: 1;
            width: 100%;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .btn-reset-filter:hover {
            background: var(--line);
            color: var(--ink);
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
            color: var(--steel);
            font-weight: 500;
        }

        .filter-info .results-count strong {
            color: var(--ink);
        }

        /* ===== PRODUCT CARD ===== */
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
            padding: 14px 16px 16px;
            text-align: left;
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

        /* ===== SORTING ===== */
        .sorting-wrapper {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 15px;
        }

        .sort-select {
            padding: 8px 18px;
            border-radius: 30px;
            border: 1px solid var(--line);
            background: white;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            outline: none;
            font-family: var(--font-body);
            color: var(--ink-soft);
            transition: all 0.3s;
        }

        .sort-select:focus {
            border-color: var(--signal);
        }

        .sort-select:hover {
            border-color: var(--signal);
        }

        /* ===== PRODUCT GRID ===== */
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

        .products-scroll::-webkit-scrollbar-track {
            background: var(--fog);
            border-radius: 10px;
        }

        .products-scroll::-webkit-scrollbar-thumb {
            background: var(--signal);
            border-radius: 10px;
        }

        /* ===== LOADER ===== */
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

        .no-products i {
            font-size: 3rem;
            color: var(--steel);
            margin-bottom: 16px;
            display: block;
        }

        /* ===== CUSTOM ALERT / TOAST STYLES ===== */
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
                margin-bottom: 20px;
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
                font-size: 0.8rem;
                min-height: 35px;
            }

            .product-price-container .final-price {
                font-size: 1rem;
            }

            .product-brand {
                font-size: 0.68rem;
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

            .container {
                padding-left: 10px !important;
                padding-right: 10px !important;
            }

            .section-heading {
                font-size: 1.3rem !important;
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

            .sorting-wrapper {
                justify-content: flex-start;
            }

            .sort-select {
                font-size: 0.7rem;
                padding: 4px 12px;
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
                    <li class="breadcrumb-item active" id="breadcrumbCategory">All Products</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container mb-4">
        <!-- Sub Categories Section -->
        <div class="sub-categories-section" id="subCategoriesSection" style="display: none;">
            <div class="sub-categories-title" id="categoryTitle">
                <span class="section-eyebrow" style="font-size:0.6rem; margin-bottom:2px;">Browse the Range</span>
                Shop by Category
            </div>
            <div class="sub-categories-scroll" id="subCategoriesContainer">
                <span class="text-muted" style="font-size:0.85rem; padding:10px 0;">Loading sub categories...</span>
            </div>
        </div>

        <div class="row">
            <!-- Filter Sidebar -->
            <div class="col-md-3">
                <div class="filter-sidebar-wrapper">
                    <div class="filter-sidebar">
                        <h5 class="mb-3" style="font-family: var(--font-display); text-transform: uppercase; letter-spacing: 0.5px; font-size: 1.1rem;">
                            <i class="fas fa-filter me-2" style="color: var(--signal);"></i> Filters
                        </h5>

                        <!-- Category Filter -->
                        <div class="filter-section">
                            <div class="filter-title collapsed" onclick="toggleFilter(this, 'category')">
                                Category <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="filter-content" id="filter-category" style="display: none;">
                                <ul class="filter-options" id="categoryFilterList">
                                    <li><span class="text-muted" style="font-size:0.8rem;">Loading categories...</span></li>
                                </ul>
                            </div>
                        </div>

                        <!-- Brand Filter -->
                        <div class="filter-section">
                            <div class="filter-title collapsed" onclick="toggleFilter(this, 'brand')">
                                Brand <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="filter-content" id="filter-brand" style="display: none;">
                                <ul class="filter-options" id="brandFilterList">
                                    <li><span class="text-muted" style="font-size:0.8rem;">Loading brands...</span></li>
                                </ul>
                            </div>
                        </div>

                        <!-- Price Filter -->
                        <div class="filter-section">
                            <div class="filter-title collapsed" onclick="toggleFilter(this, 'price')">
                                Price <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="filter-content" id="filter-price" style="display: none;">
                                <ul class="filter-options">
                                    <li><label><input type="radio" name="price" value="0-500" onchange="autoApplyFilters()"> ₹0 - ₹500</label></li>
                                    <li><label><input type="radio" name="price" value="500-1000" onchange="autoApplyFilters()"> ₹500 - ₹1000</label></li>
                                    <li><label><input type="radio" name="price" value="1000-2000" onchange="autoApplyFilters()"> ₹1000 - ₹2000</label></li>
                                    <li><label><input type="radio" name="price" value="2000-5000" onchange="autoApplyFilters()"> ₹2000 - ₹5000</label></li>
                                    <li><label><input type="radio" name="price" value="5000-10000" onchange="autoApplyFilters()"> ₹5000 - ₹10000</label></li>
                                    <li><label><input type="radio" name="price" value="10000+" onchange="autoApplyFilters()"> ₹10000+</label></li>
                                </ul>
                            </div>
                        </div>

                        <!-- Size Filter - DYNAMIC -->
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

                        <!-- Color Filter - DYNAMIC WITH NAMES -->
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
                            <button class="btn-reset-filter" onclick="resetFilters()">
                                <i class="fas fa-undo me-1"></i> Reset All
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Container -->
            <div class="col-md-9">
                <div class="products-scroll">
                    <div class="filter-info" id="filterInfo">
                        <div class="results-count">
                            Showing <strong id="productCountDisplay">0</strong> products
                        </div>
                        <div class="sorting-wrapper">
                            <select class="sort-select" id="sortBy" onchange="sortProducts()">
                                <option value="default">Default Sorting</option>
                                <option value="price_asc">Price: Low to High</option>
                                <option value="price_desc">Price: High to Low</option>
                                <option value="name_asc">Name: A to Z</option>
                                <option value="name_desc">Name: Z to A</option>
                            </select>
                        </div>
                    </div>

                    <div id="loader" class="loader" style="display: none;">
                        <i class="fas fa-spinner"></i>
                        <p style="margin-top: 12px; color: var(--steel);">Loading products...</p>
                    </div>

                    <div class="row product-grid" id="productsContainer"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ================================================================
        // ===== CUSTOM ALERT FUNCTIONS =====
        // ================================================================

        function showCustomAlert(title, message, type = 'warning', buttonText = 'Login Now', buttonLink = '{{ route('login') }}') {
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
        // ===== CUSTOM TOAST NOTIFICATION =====
        // ================================================================

        function showToast(message, type = 'info') {
            // Try to use the global notification function first
            if (typeof showNotification === 'function') {
                showNotification(message, type);
                return;
            }

            // Fallback toast
            const toast = document.createElement('div');
            const bgColor = type === 'success' ? 'var(--success)' : type === 'warning' ? 'var(--signal)' : 'var(--info)';
            toast.style.cssText = `
                position: fixed;
                bottom: 30px;
                right: 30px;
                background: ${bgColor};
                color: white;
                padding: 14px 24px;
                border-radius: var(--radius-md);
                box-shadow: 0 10px 30px rgba(0,0,0,0.2);
                z-index: 99999;
                font-family: var(--font-body);
                font-weight: 600;
                font-size: 0.9rem;
                max-width: 350px;
                animation: slideUp 0.3s ease;
                display: flex;
                align-items: center;
                gap: 10px;
            `;
            toast.innerHTML = `
                <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle'}"></i>
                ${message}
            `;
            document.body.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
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

                if (categoriesList.length === 0) {
                    categoryFilterList.innerHTML = '<li><span class="text-muted" style="font-size:0.8rem;">No categories</span></li>';
                    return;
                }

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
                const categoryFilterList = document.getElementById('categoryFilterList');
                if (categoryFilterList) {
                    categoryFilterList.innerHTML = '<li><span class="text-danger">Error loading categories</span></li>';
                }
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
                        'gray': '#808080',
                        'navy': '#000080',
                        'maroon': '#800000',
                        'teal': '#008080',
                        'olive': '#808000',
                        'lime': '#00FF00',
                        'cyan': '#00FFFF',
                        'magenta': '#FF00FF',
                        'silver': '#C0C0C0',
                        'gold': '#FFD700'
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
                    container.innerHTML = '<span class="text-muted" style="font-size:0.85rem;">No sub categories available</span>';
                    return;
                }

                const categoryName = getUrlParameter('name') || 'All Categories';
                if (title) {
                    title.innerHTML = `
                        <span class="section-eyebrow" style="font-size:0.6rem; margin-bottom:2px;">Browse the Range</span>
                        ${categoryName}
                    `;
                }

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
            if (title) {
                title.innerHTML = `
                    <span class="section-eyebrow" style="font-size:0.6rem; margin-bottom:2px;">Browse the Range</span>
                    ${subName}
                `;
            }

            // Reset filters when changing subcategory
            resetFiltersUI();
            loadProducts();
        }

        // ================================================================
        // ===== RESET FILTERS UI =====
        // ================================================================

        function resetFiltersUI() {
            document.querySelectorAll('.filter-check:checked').forEach(cb => cb.checked = false);
            document.querySelectorAll('input[name="price"]:checked').forEach(radio => radio.checked = false);
            document.querySelectorAll('.size-btn.active').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.color-filter-item.active').forEach(el => el.classList.remove('active'));
            document.getElementById('sortBy').value = 'default';
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
                // Generate a placeholder with product name initials
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
                    image: variantImages[0] || null,
                    allImages: variantImages,
                    price: displayPrice,
                    originalPrice: originalPrice,
                    discountType: firstVariant.discount_type || 'flat',
                    discountValue: parseFloat(firstVariant.discount_value) || 0,
                    stock: parseInt(firstVariant.stock) || 0,
                    totalStock: totalStock,
                    variantId: firstVariant.id,
                    colors: colors,
                    variantCount: product.variants.length
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
                variantCount: 0
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
            if (loader) loader.style.display = 'block';

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
                if (loader) loader.style.display = 'none';

                const countDisplay = document.getElementById('productCountDisplay');
                if (countDisplay) countDisplay.textContent = products.length;

                // Update Size & Color filters from products
                updateSizeAndColorFilters(products);

                // Populate brand filter
                const brands = [...new Set(products.map(p => p.brand && p.brand.name ? p.brand.name : null).filter(b =>
                    b))];
                const brandFilterList = document.getElementById('brandFilterList');
                if (brandFilterList) {
                    if (brands.length === 0) {
                        brandFilterList.innerHTML = '<li><span class="text-muted" style="font-size:0.8rem;">No brands</span></li>';
                    } else {
                        brandFilterList.innerHTML = brands.map(brand =>
                            `<li><label><input type="checkbox" value="${brand}" class="filter-check" data-filter="brand" onchange="autoApplyFilters()"> ${brand}</label></li>`
                        ).join('');
                    }
                }

                if (products.length === 0) {
                    container.innerHTML = `
                        <div class="col-12">
                            <div class="no-products">
                                <i class="fas fa-box-open"></i>
                                <h4 style="margin-top: 16px; font-family: var(--font-display); text-transform: uppercase; letter-spacing: 0.5px;">No Products Found</h4>
                                <p style="color: var(--steel);">Try adjusting your filters or check back later!</p>
                            </div>
                        </div>
                    `;
                    return;
                }

                renderProducts(products);

                // Show subcategories if we have a category
                if (currentCategoryId && !currentSubCategoryId) {
                    await loadSubCategories(currentCategoryId);
                }

            } catch (error) {
                console.error('Error loading products:', error);
                if (loader) loader.style.display = 'none';
                container.innerHTML = `
                    <div class="col-12">
                        <div class="no-products" style="border-color: var(--signal);">
                            <i class="fas fa-exclamation-triangle" style="color: var(--signal);"></i>
                            <h4 style="margin-top: 16px; font-family: var(--font-display); text-transform: uppercase; letter-spacing: 0.5px;">Error Loading Products</h4>
                            <p style="color: var(--steel);">Please try again later.</p>
                        </div>
                    </div>
                `;
            }
        }

        // ================================================================
        // ===== RENDER PRODUCTS =====
        // ================================================================

        function renderProducts(products) {
            const container = document.getElementById('productsContainer');
            let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];

            if (products.length === 0) {
                container.innerHTML = `
                    <div class="col-12">
                        <div class="no-products">
                            <i class="fas fa-box-open"></i>
                            <h4 style="margin-top: 16px; font-family: var(--font-display); text-transform: uppercase; letter-spacing: 0.5px;">No Products Found</h4>
                            <p style="color: var(--steel);">Try adjusting your filters!</p>
                        </div>
                    </div>
                `;
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
                    'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMDAiIGhlaWdodD0iMzAwIiB2aWV3Qm94PSIwIDAgMzAwIDMwMCI+PHJlY3Qgd2lkdGg9IjMwMCIgaGVpZ2h0PSIzMDAiIGZpbGw9IiNmMGYwZjAiLz48dGV4dCB4PSIxNTAiIHk9IjE1MCIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjUwIiBmaWxsPSIjY2NjIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBkb21pbmFudC1iYXNlbGluZT0iY2VudHJhbCI+Tm8gSW1hZ2U8L3RleHQ+PC9zdmc+';

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

                // Color options with count
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
                            <button class="wishlist-btn" onclick="event.stopPropagation(); toggleWishlist(${product.id}, '${escapeName}', ${displayPrice}, '${firstImage}')" aria-label="Add to wishlist">
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
                            </div>
                        </div>
                    </div>
                `;
            }).join('');

            // Update wishlist icons
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
                filtered = filtered.filter(product => {
                    if (!product.category) return false;
                    return selectedCategories.includes(product.category.id.toString());
                });
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
                    if (!product.variants || product.variants.length === 0) return false;
                    return product.variants.some(variant =>
                        variant.size &&
                        selectedSizes.includes(variant.size)
                    );
                });
            }

            // COLOR
            if (selectedColors.length > 0) {
                filtered = filtered.filter(product => {
                    if (!product.variants || product.variants.length === 0) return false;
                    return product.variants.some(variant =>
                        variant.color &&
                        selectedColors.includes(variant.color)
                    );
                });
            }

            filteredProducts = filtered;
            renderProducts(filteredProducts);
            const countDisplay = document.getElementById('productCountDisplay');
            if (countDisplay) countDisplay.textContent = filteredProducts.length;
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
                default:
                    // Default sorting - keep as is
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

            // Reset subcategory selection if any
            document.querySelectorAll('.sub-category-item.active').forEach(item => {
                item.classList.remove('active');
            });
            currentSubCategoryId = null;

            filteredProducts = [...allProducts];
            renderProducts(allProducts);
            document.getElementById('sortBy').value = 'default';

            const countDisplay = document.getElementById('productCountDisplay');
            if (countDisplay) countDisplay.textContent = allProducts.length;

            // Reset breadcrumb and title
            const breadcrumb = document.getElementById('breadcrumbCategory');
            if (breadcrumb) breadcrumb.textContent = 'All Products';

            const title = document.getElementById('categoryTitle');
            if (title) {
                title.innerHTML = `
                    <span class="section-eyebrow" style="font-size:0.6rem; margin-bottom:2px;">Browse the Range</span>
                    Shop by Category
                `;
            }
        }

        // ================================================================
        // ===== WISHLIST FUNCTIONS =====
        // ================================================================

        function goToProductDetail(productId, event) {
            if (event && (event.target.closest('.wishlist-btn') ||
                    event.target.closest('.btn-add-cart') ||
                    event.target.closest('.btn-buy-now') ||
                    event.target.closest('.carousel-control-prev') ||
                    event.target.closest('.carousel-control-next') ||
                    event.target.closest('.color-dot'))) {
                return;
            }
            window.location.href = `/product/${productId}`;
        }

        function toggleWishlist(id, name, price, image) {
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
                showToast('Removed from wishlist!', 'info');
            } else {
                currentWishlist.push({
                    id,
                    name,
                    price,
                    image,
                    added_at: new Date().toISOString()
                });
                if (icon) icon.className = 'fas fa-heart';
                showToast('Added to wishlist!', 'success');
            }
            localStorage.setItem('wishlist', JSON.stringify(currentWishlist));
            updateNavbarWishlistCount();
        }

        // ================================================================
        // ===== UPDATE NAVBAR COUNTS =====
        // ================================================================

        function updateNavbarCartCount() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const count = cart.reduce((t, i) => t + i.quantity, 0);
            const el = document.getElementById('navbarCartCount');
            if (el) {
                el.textContent = count;
                el.style.display = count > 0 ? '' : 'none';
            }
        }

        function updateNavbarWishlistCount() {
            const wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
            const count = wishlist.length;
            const el = document.getElementById('navbarWishlistCount');
            if (el) {
                el.textContent = count;
                el.style.display = count > 0 ? '' : 'none';
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