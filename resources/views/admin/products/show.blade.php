@extends('layouts.admin-layout')

@section('content')
<style>
    /* ============================================ */
    /* COLOR VARIABLES                             */
    /* ============================================ */
    :root {
        --primary: #4a9eff;
        --primary-dark: #2b7be0;
        --primary-light: #e8f4fd;
        --success: #4caf50;
        --success-light: #e8f5e9;
        --warning: #ffa726;
        --danger: #ef5350;
        --danger-light: #fce4ec;
        --dark: #1a1a2e;
        --gray: #6c757d;
        --gray-light: #f8f9fa;
        --border-color: #e9ecef;
        --shadow: 0 2px 20px rgba(0,0,0,0.05);
        --shadow-hover: 0 8px 35px rgba(0,0,0,0.12);
        --radius: 10px;
        --radius-lg: 16px;
        --transition: all 0.3s ease;
    }

    .admin-main-content {
        padding: 20px 25px !important;
        background: #f0f4f8;
        min-height: 100vh;
        margin-left: 270px !important;
        width: auto !important;
        max-width: calc(100% - 270px) !important;
        box-sizing: border-box;
    }

    .detail-card {
        background: #ffffff;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow);
        border: 1px solid rgba(0,0,0,0.04);
        overflow: hidden;
        max-width: 100%;
        margin: 0 auto;
    }

    .detail-card .card-header {
        padding: 16px 24px;
        background: linear-gradient(135deg, #0d1b2a 0%, #1b3a5c 100%);
        color: #ffffff;
        border-bottom: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .detail-card .card-header h4 {
        margin: 0;
        font-weight: 600;
        font-size: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .detail-card .card-header h4 i {
        color: #4a9eff;
    }

    .detail-card .card-header small {
        font-size: 12px;
        opacity: 0.8;
        font-weight: 400;
    }

    .detail-card .card-body {
        padding: 24px 28px;
    }

    .section-title {
        font-size: 14px;
        font-weight: 600;
        color: var(--dark);
        padding: 6px 14px;
        background: var(--gray-light);
        border-radius: var(--radius);
        border-left: 3px solid var(--primary);
        margin-bottom: 12px;
        margin-top: 18px;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .section-title i {
        color: var(--primary);
        font-size: 14px;
    }

    .product-image-container {
        background: var(--gray-light);
        border-radius: var(--radius);
        border: 1px solid var(--border-color);
        padding: 15px;
        text-align: center;
        min-height: 250px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-image-container img {
        max-height: 280px;
        max-width: 100%;
        object-fit: contain;
        border-radius: var(--radius);
    }

    .product-image-container .no-image {
        color: var(--gray);
    }

    .product-image-container .no-image i {
        font-size: 48px;
        display: block;
        margin-bottom: 10px;
        color: #dee2e6;
    }

    .thumbnail-gallery {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-top: 12px;
        justify-content: center;
    }

    .thumbnail-gallery .thumb {
        width: 60px;
        height: 60px;
        border-radius: var(--radius);
        border: 2px solid var(--border-color);
        overflow: hidden;
        cursor: pointer;
        transition: var(--transition);
        background: #fff;
    }

    .thumbnail-gallery .thumb:hover {
        border-color: var(--primary);
        transform: scale(1.05);
    }

    .thumbnail-gallery .thumb.active {
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(74, 158, 255, 0.2);
    }

    .thumbnail-gallery .thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-title {
        font-size: 22px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 6px;
    }

    .product-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 12px;
    }

    .product-meta .badge-custom {
        padding: 3px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .product-meta .badge-custom.category {
        background: #e3f2fd;
        color: #1565c0;
    }

    .product-meta .badge-custom.subcategory {
        background: #f3e5f5;
        color: #6a1b9a;
    }

    .product-meta .badge-custom.brand {
        background: #fff3e0;
        color: #e65100;
    }

    .product-meta .badge-custom.type {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .product-meta .badge-custom.topcategory {
        background: #e8eaf6;
        color: #283593;
    }

    .price-display {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 16px;
        padding: 10px 16px;
        background: var(--gray-light);
        border-radius: var(--radius);
        border: 1px solid var(--border-color);
    }

    .price-display .final-price {
        font-size: 26px;
        font-weight: 700;
        color: var(--success);
    }

    .price-display .price-range {
        font-size: 16px;
        font-weight: 500;
        color: var(--gray);
    }

    .price-display .original-price {
        font-size: 17px;
        color: var(--gray);
        text-decoration: line-through;
    }

    .price-display .discount-badge {
        background: var(--danger);
        color: #fff;
        padding: 2px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .price-display .gst-tag {
        background: var(--primary);
        color: #fff;
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 10px;
        font-weight: 500;
    }

    .price-display .variant-count {
        font-size: 12px;
        color: var(--gray);
        background: var(--gray-light);
        padding: 2px 12px;
        border-radius: 20px;
    }

    /* ============================================ */
    /* VARIANT LAYOUT - SEPARATE DESIGN            */
    /* ============================================ */
    .variant-layout-header {
        background: linear-gradient(135deg, #e8f4fd 0%, #d4e8fc 100%);
        border-radius: var(--radius);
        padding: 15px 20px;
        margin-bottom: 20px;
        border: 1px solid #b8d4f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .variant-layout-header .header-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .variant-layout-header .header-title i {
        color: var(--primary);
    }

    .variant-layout-header .header-stats {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .variant-layout-header .header-stats .stat-item {
        background: white;
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    }

    .variant-layout-header .header-stats .stat-item i {
        color: var(--primary);
    }

    /* ============================================ */
    /* VARIANT CARD - ENHANCED                     */
    /* ============================================ */
    .variant-card {
        background: #ffffff;
        border-radius: var(--radius);
        border: 1px solid var(--border-color);
        padding: 20px 22px;
        margin-bottom: 16px;
        transition: var(--transition);
        box-shadow: var(--shadow);
        position: relative;
    }

    .variant-card:hover {
        border-color: var(--primary);
        box-shadow: var(--shadow-hover);
        transform: translateY(-2px);
    }

    .variant-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        border-radius: var(--radius) 0 0 var(--radius);
    }

    .variant-card:nth-child(1)::before { background: #4a9eff; }
    .variant-card:nth-child(2)::before { background: #ff6b6b; }
    .variant-card:nth-child(3)::before { background: #feca57; }
    .variant-card:nth-child(4)::before { background: #48dbfb; }
    .variant-card:nth-child(5)::before { background: #ff9ff3; }
    .variant-card:nth-child(6)::before { background: #54a0ff; }

    .variant-card .variant-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 14px;
        padding-bottom: 12px;
        border-bottom: 1px solid var(--border-color);
    }

    .variant-card .variant-header .variant-title {
        font-weight: 600;
        font-size: 16px;
        color: var(--primary);
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .variant-card .variant-header .variant-title .color-dot {
        display: inline-block;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 2px solid var(--border-color);
        flex-shrink: 0;
    }

    .variant-card .variant-header .variant-title .color-name {
        font-weight: 600;
        color: var(--dark);
        font-size: 15px;
    }

    .variant-card .variant-header .variant-title .size-count {
        font-weight: 400;
        color: var(--gray);
        font-size: 12px;
        background: var(--gray-light);
        padding: 2px 12px;
        border-radius: 20px;
    }

    .variant-card .variant-header .stock-badge {
        padding: 4px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .variant-card .variant-header .stock-badge.in-stock {
        background: var(--success-light);
        color: var(--success);
    }

    .variant-card .variant-header .stock-badge.out-stock {
        background: var(--danger-light);
        color: var(--danger);
    }

    .variant-price-range {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 12px;
        padding: 8px 12px;
        background: var(--gray-light);
        border-radius: var(--radius);
    }

    .variant-price-range .price-item {
        font-size: 12px;
        color: var(--gray);
    }

    .variant-price-range .price-item strong {
        color: var(--success);
    }

    /* ============================================ */
    /* VARIANT SIZES TABLE                         */
    /* ============================================ */
    .variant-sizes-table {
        width: 100%;
        margin-top: 10px;
        border-collapse: collapse;
        font-size: 12px;
    }

    .variant-sizes-table thead th {
        background: var(--gray-light);
        padding: 8px 10px;
        text-align: left;
        font-weight: 600;
        font-size: 10px;
        text-transform: uppercase;
        color: var(--gray);
        border-bottom: 2px solid var(--border-color);
    }

    .variant-sizes-table tbody td {
        padding: 8px 10px;
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
    }

    .variant-sizes-table tbody tr:last-child td {
        border-bottom: none;
    }

    .variant-sizes-table tbody tr:hover {
        background: var(--gray-light);
    }

    .variant-sizes-table .size-badge {
        display: inline-block;
        background: var(--primary-light);
        color: var(--primary-dark);
        padding: 2px 12px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 12px;
    }

    .variant-sizes-table .price-cell {
        font-weight: 600;
        color: var(--dark);
    }

    .variant-sizes-table .final-price-cell {
        font-weight: 700;
        color: var(--success);
        font-size: 14px;
    }

    .variant-sizes-table .stock-cell {
        font-weight: 600;
    }

    .variant-sizes-table .stock-cell.in-stock {
        color: var(--success);
    }

    .variant-sizes-table .stock-cell.out-stock {
        color: var(--danger);
    }

    /* ============================================ */
    /* VARIANT IMAGES                              */
    /* ============================================ */
    .variant-card .variant-images {
        margin-top: 14px;
        padding-top: 12px;
        border-top: 1px dashed var(--border-color);
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .variant-card .variant-images .vlabel {
        font-size: 9px;
        font-weight: 600;
        color: var(--gray);
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .variant-card .variant-images .vlabel i {
        margin-right: 4px;
        color: var(--primary);
    }

    .variant-card .variant-images .image-thumbs {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }

    .variant-card .variant-images .image-thumbs .vthumb {
        width: 50px;
        height: 50px;
        border-radius: 6px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        transition: var(--transition);
        cursor: pointer;
    }

    .variant-card .variant-images .image-thumbs .vthumb:hover {
        border-color: var(--primary);
        transform: scale(1.05);
        box-shadow: 0 2px 8px rgba(74, 158, 255, 0.2);
    }

    .variant-card .variant-images .image-thumbs .vthumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* ============================================ */
    /* VARIANT SUMMARY                             */
    /* ============================================ */
    .variant-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
        gap: 12px 20px;
        margin-top: 16px;
        padding: 14px 20px;
        background: var(--primary-light);
        border-radius: var(--radius);
        border: 1px solid #d4e4f8;
    }

    .variant-summary .summary-item {
        display: flex;
        flex-direction: column;
    }

    .variant-summary .summary-item .slabel {
        font-size: 10px;
        color: var(--gray);
        text-transform: uppercase;
        letter-spacing: 0.3px;
        font-weight: 600;
    }

    .variant-summary .summary-item .slabel i {
        margin-right: 4px;
        font-size: 10px;
        color: var(--primary);
    }

    .variant-summary .summary-item .svalue {
        font-size: 18px;
        font-weight: 700;
        color: var(--dark);
        margin-top: 2px;
    }

    .variant-summary .summary-item .svalue.green {
        color: var(--success);
    }

    .variant-summary .summary-item .svalue.blue {
        color: var(--primary);
    }

    /* ============================================ */
    /* NORMAL PRODUCT TABLE                        */
    /* ============================================ */
    .detail-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .detail-table tr {
        border-bottom: 1px solid var(--border-color);
    }

    .detail-table tr:last-child {
        border-bottom: none;
    }

    .detail-table td {
        padding: 8px 12px;
        vertical-align: middle;
    }

    .detail-table .label {
        font-weight: 600;
        color: var(--gray);
        width: 140px;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .detail-table .label i {
        margin-right: 6px;
        font-size: 12px;
        color: var(--primary);
    }

    .detail-table .value {
        font-weight: 500;
        color: var(--dark);
    }

    .description-box {
        background: var(--gray-light);
        border-radius: var(--radius);
        padding: 16px 20px;
        border: 1px solid var(--border-color);
        font-size: 14px;
        line-height: 1.8;
        color: var(--dark);
    }

    .description-box ul {
        padding-left: 20px;
        margin-bottom: 0;
    }

    .description-box ul li {
        margin-bottom: 4px;
    }

    .btn-primary {
        background: var(--primary);
        color: #fff;
        border: none;
        padding: 8px 20px;
        border-radius: var(--radius);
        font-weight: 500;
        font-size: 13px;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(74, 158, 255, 0.35);
    }

    .btn-warning {
        background: var(--warning);
        color: #fff;
        border: none;
        padding: 8px 20px;
        border-radius: var(--radius);
        font-weight: 500;
        font-size: 13px;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-warning:hover {
        background: #e69500;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(255, 167, 38, 0.35);
    }

    .btn-secondary {
        background: var(--gray-light);
        color: var(--gray);
        border: 1px solid var(--border-color);
        padding: 8px 20px;
        border-radius: var(--radius);
        font-weight: 500;
        font-size: 13px;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-secondary:hover {
        background: #e9ecef;
        color: var(--dark);
    }

    .btn-sm {
        padding: 5px 14px;
        font-size: 12px;
    }

    .badge-status {
        padding: 3px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .badge-status.active {
        background: var(--success-light);
        color: var(--success);
    }

    .badge-status.inactive {
        background: var(--danger-light);
        color: var(--danger);
    }

    .badge-status.draft {
        background: #fff3cd;
        color: #856404;
    }

    .badge-status .dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        display: inline-block;
    }

    .badge-status.active .dot {
        background: var(--success);
    }

    .badge-status.inactive .dot {
        background: var(--danger);
    }

    .badge-status.draft .dot {
        background: #ffc107;
    }

    .variant-type-label {
        display: inline-block;
        background: var(--primary);
        color: white;
        padding: 2px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 500;
    }

    /* ============================================ */
    /* COLOR LIST                                  */
    /* ============================================ */
    .color-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 12px;
    }

    .color-list .color-item {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--gray-light);
        padding: 4px 12px 4px 8px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    .color-list .color-item .color-circle {
        width: 14px;
        height: 14px;
        border-radius: 50%;
        border: 1px solid var(--border-color);
    }

    /* ============================================ */
    /* RESPONSIVE                                  */
    /* ============================================ */
    @media (max-width: 992px) {
        .admin-main-content {
            margin-left: 70px !important;
            max-width: calc(100% - 70px) !important;
            padding: 15px 18px !important;
        }
        .detail-card .card-body {
            padding: 18px 20px;
        }
    }

    @media (max-width: 768px) {
        .admin-main-content {
            margin-left: 0 !important;
            max-width: 100% !important;
            padding: 12px 15px !important;
        }
        .detail-card .card-header {
            padding: 12px 16px;
            flex-direction: column;
            align-items: flex-start;
        }
        .detail-card .card-header h4 {
            font-size: 16px;
        }
        .detail-card .card-body {
            padding: 14px 16px;
        }
        .product-title {
            font-size: 18px;
        }
        .price-display .final-price {
            font-size: 22px;
        }
        .product-image-container {
            min-height: 180px;
        }
        .product-image-container img {
            max-height: 200px;
        }
        .thumbnail-gallery .thumb {
            width: 50px;
            height: 50px;
        }
        .variant-summary {
            grid-template-columns: 1fr 1fr;
            gap: 8px 16px;
        }
        .variant-card {
            padding: 14px 16px;
        }
        .variant-sizes-table {
            font-size: 11px;
        }
        .variant-sizes-table thead th,
        .variant-sizes-table tbody td {
            padding: 6px 8px;
        }
        .detail-table td {
            padding: 6px 8px;
            font-size: 12px;
        }
        .detail-table .label {
            width: 100px;
            font-size: 11px;
        }
        .variant-layout-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .variant-layout-header .header-stats {
            width: 100%;
            flex-wrap: wrap;
        }
    }

    @media (max-width: 576px) {
        .detail-card .card-header h4 {
            font-size: 14px;
        }
        .detail-card .card-body {
            padding: 10px 12px;
        }
        .product-title {
            font-size: 16px;
        }
        .price-display {
            flex-direction: column;
            align-items: flex-start;
            gap: 6px;
        }
        .price-display .final-price {
            font-size: 20px;
        }
        .price-display .original-price {
            font-size: 15px;
        }
        .product-image-container {
            min-height: 150px;
        }
        .product-image-container img {
            max-height: 160px;
        }
        .thumbnail-gallery .thumb {
            width: 40px;
            height: 40px;
        }
        .section-title {
            font-size: 12px;
            padding: 4px 10px;
        }
        .description-box {
            font-size: 12px;
            padding: 12px 14px;
        }
        .btn-primary,
        .btn-warning,
        .btn-secondary {
            padding: 6px 14px;
            font-size: 12px;
        }
        .variant-card {
            padding: 12px 14px;
        }
        .variant-card .variant-header .variant-title {
            font-size: 14px;
        }
        .variant-summary {
            grid-template-columns: 1fr 1fr;
            gap: 6px 12px;
            padding: 10px 14px;
        }
        .variant-summary .summary-item .svalue {
            font-size: 15px;
        }
        .variant-card .variant-images .image-thumbs .vthumb {
            width: 40px;
            height: 40px;
        }
        .variant-sizes-table {
            font-size: 10px;
        }
        .variant-sizes-table thead th,
        .variant-sizes-table tbody td {
            padding: 4px 6px;
        }
        .detail-table .label {
            width: 80px;
            font-size: 10px;
        }
        .detail-table td {
            padding: 4px 6px;
            font-size: 11px;
        }
        .variant-layout-header .header-stats .stat-item {
            font-size: 10px;
            padding: 2px 10px;
        }
    }
</style>

<div class="admin-main-content">
    <div class="detail-card">
        <div class="card-header">
            <div>
                <h4><i class="fas fa-box"></i> Product Details</h4>
                <small style="opacity:0.8;">
                    @php
                        $hasVariants = false;
                        if (isset($product->variants) && $product->variants->count() > 0) {
                            $hasVariants = true;
                        }
                    @endphp
                    @if($hasVariants)
                        <i class="fas fa-palette"></i> Variant Product
                        <span class="variant-type-label">
                            <i class="fas fa-tshirt"></i> {{ $product->variants->count() }} Variants
                        </span>
                    @else
                        <i class="fas fa-box"></i> Simple Product
                    @endif
                </small>
            </div>
            <div style="display:flex; gap:8px; flex-wrap:wrap;">
                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="card-body">
            @php
                $hasVariants = false;
                if (isset($product->variants) && $product->variants->count() > 0) {
                    $hasVariants = true;
                }
            @endphp

            @if($hasVariants)
                <!-- ========================================== -->
                <!-- ====== VARIANT PRODUCT LAYOUT ============ -->
                <!-- ========================================== -->
                <div class="row">
                    <!-- LEFT COLUMN - IMAGES -->
                    <div class="col-md-4">
                        @php
                            $mainImage = null;
                            $allImages = collect();
                            
                            // Collect all variant images
                            if ($hasVariants) {
                                foreach ($product->variants as $variant) {
                                    if (isset($variant->variantImages) && $variant->variantImages->count() > 0) {
                                        foreach ($variant->variantImages as $img) {
                                            $allImages->push($img);
                                        }
                                    }
                                    if (isset($variant->images) && $variant->images->count() > 0) {
                                        foreach ($variant->images as $img) {
                                            $allImages->push($img);
                                        }
                                    }
                                }
                            }
                            
                            // Check for product images
                            if (isset($product->productImages) && $product->productImages->count() > 0) {
                                $mainImage = $product->productImages->where('is_main', 1)->first();
                                if (!$mainImage) {
                                    $mainImage = $product->productImages->first();
                                }
                                $allImages = $product->productImages;
                            }
                            // If no product images, use variant images
                            elseif ($allImages->count() > 0) {
                                $mainImage = $allImages->first();
                            }
                            // Fallback
                            elseif (isset($product->image) && !empty($product->image)) {
                                $mainImage = (object) ['image_path' => $product->image];
                                $allImages = collect([$mainImage]);
                            }
                        @endphp

                        <div class="product-image-container">
                            @if($mainImage)
                                <img src="{{ asset('storage/'.($mainImage->image_path ?? $mainImage)) }}" alt="{{ $product->name }}" id="mainProductImage">
                            @else
                                <div class="no-image">
                                    <i class="fas fa-image"></i>
                                    <span>No Image Available</span>
                                </div>
                            @endif
                        </div>

                        @if($allImages && $allImages->count() > 1)
                            <div class="thumbnail-gallery" id="thumbnailGallery">
                                @foreach($allImages as $index => $img)
                                    <div class="thumb {{ $index == 0 ? 'active' : '' }}" 
                                         onclick="changeMainImage(this, '{{ asset('storage/'.($img->image_path ?? $img)) }}')">
                                        <img src="{{ asset('storage/'.($img->image_path ?? $img)) }}" alt="Thumbnail {{ $index + 1 }}">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- RIGHT COLUMN - VARIANT DETAILS -->
                    <div class="col-md-8">
                        <!-- Product Name -->
                        <h3 class="product-title">{{ $product->name }}</h3>

                        <!-- Meta Badges -->
                        <div class="product-meta">
                            @if(isset($product->topCategory) && $product->topCategory)
                                <span class="badge-custom topcategory"><i class="fas fa-arrow-up"></i> {{ $product->topCategory->name }}</span>
                            @endif
                            @if(isset($product->category) && $product->category)
                                <span class="badge-custom category"><i class="fas fa-folder"></i> {{ $product->category->name }}</span>
                            @endif
                            @if(isset($product->subCategory) && $product->subCategory)
                                <span class="badge-custom subcategory"><i class="fas fa-folder-open"></i> {{ $product->subCategory->name }}</span>
                            @endif
                            @if(isset($product->brand) && $product->brand)
                                <span class="badge-custom brand"><i class="fas fa-tag"></i> {{ $product->brand->name }}</span>
                            @endif
                            @if(isset($product->productType) && $product->productType)
                                <span class="badge-custom type"><i class="fas fa-layer-group"></i> {{ $product->productType->name }}</span>
                            @endif
                        </div>

                        <!-- Price Display -->
                        @php
                            $allPrices = $product->variants->pluck('final_price')->filter();
                            $minPrice = $allPrices->min() ?? 0;
                            $maxPrice = $allPrices->max() ?? 0;
                            $firstVariant = $product->variants->first();
                            $firstVariantMrp = $firstVariant ? $firstVariant->mrp : 0;
                            $gstRate = $firstVariant ? $firstVariant->gst_percentage : 0;
                            $totalStock = $product->variants->sum('stock');
                            $variantCount = $product->variants->count();
                            $hasDiscount = $minPrice > 0 && $firstVariantMrp && $minPrice < $firstVariantMrp;
                            $discountPercent = $hasDiscount ? round((($firstVariantMrp - $minPrice) / $firstVariantMrp) * 100) : 0;
                            
                            // Get all colors for display
                            $allColors = $product->variants->pluck('color')->filter()->unique();
                        @endphp

                        <div class="price-display">
                            <span class="final-price">₹{{ number_format($minPrice, 2) }}</span>
                            @if($minPrice != $maxPrice && $maxPrice > 0)
                                <span class="price-range">- ₹{{ number_format($maxPrice, 2) }}</span>
                            @endif
                            @if($hasDiscount)
                                <span class="original-price">₹{{ number_format($firstVariantMrp, 2) }}</span>
                                <span class="discount-badge">-{{ $discountPercent }}%</span>
                            @endif                            @if($gstRate > 0)
                                <span class="gst-tag"><i class="fas fa-percent"></i> GST {{ $gstRate }}%</span>
                            @endif
                            <span class="variant-count"><i class="fas fa-palette"></i> {{ $variantCount }} Variants</span>
                        </div>

                        <!-- Colors List -->
                        @if($allColors->count() > 0)
                            <div class="color-list">
                                @foreach($allColors as $color)
                                    <span class="color-item">
                                        <span class="color-circle" style="background-color: {{ strtolower($color) }};"></span>
                                        {{ $color }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <!-- ========================================== -->
                        <!-- ====== VARIANT LAYOUT HEADER ============= -->
                        <!-- ========================================== -->
                        <div class="variant-layout-header">
                            <div class="header-title">
                                <i class="fas fa-palette"></i>
                                <span>Variant Details</span>
                            </div>
                            <div class="header-stats">
                                <span class="stat-item">
                                    <i class="fas fa-cubes"></i> {{ $allColors->count() }} Colors
                                </span>
                                <span class="stat-item">
                                    <i class="fas fa-boxes"></i> {{ $totalStock }} Total Stock
                                </span>
                                <span class="stat-item">
                                    <i class="fas fa-tshirt"></i> {{ $variantCount }} Sizes
                                </span>
                            </div>
                        </div>

                        @php
                            // Group variants by color
                            $variantGroups = [];
                            foreach ($product->variants as $variant) {
                                $color = $variant->color ?? 'Default';
                                if (!isset($variantGroups[$color])) {
                                    $variantGroups[$color] = [
                                        'color' => $color,
                                        'variants' => [],
                                        'total_stock' => 0,
                                        'images' => collect(),
                                    ];
                                }
                                $variantGroups[$color]['variants'][] = $variant;
                                $variantGroups[$color]['total_stock'] += $variant->stock ?? 0;
                                
                                // Collect images for this color
                                if (isset($variant->variantImages) && $variant->variantImages->count() > 0) {
                                    foreach ($variant->variantImages as $img) {
                                        $variantGroups[$color]['images']->push($img);
                                    }
                                }
                                if (isset($variant->images) && $variant->images->count() > 0) {
                                    foreach ($variant->images as $img) {
                                        $variantGroups[$color]['images']->push($img);
                                    }
                                }
                            }
                        @endphp

                        <!-- ========================================== -->
                        <!-- ====== EACH VARIANT CARD ================= -->
                        <!-- ========================================== -->
                        @foreach($variantGroups as $colorName => $group)
                            @php
                                $colorHex = $colorName != 'Default' ? strtolower($colorName) : '#cccccc';
                                $groupVariants = $group['variants'];
                                $groupStock = $group['total_stock'];
                                $groupImages = $group['images'];
                                $groupPrices = collect($groupVariants)->pluck('final_price')->filter();
                                $groupMinPrice = $groupPrices->min() ?? 0;
                                $groupMaxPrice = $groupPrices->max() ?? 0;
                            @endphp
                            <div class="variant-card">
                                <div class="variant-header">
                                    <div class="variant-title">
                                        <span class="color-dot" style="background-color: {{ $colorHex }};"></span>
                                        <span class="color-name">
                                            <i class="fas fa-palette"></i> {{ $colorName }}
                                        </span>
                                        <span class="size-count">
                                            <i class="fas fa-tshirt"></i> {{ count($groupVariants) }} size(s)
                                        </span>
                                    </div>
                                    <span class="stock-badge {{ $groupStock > 0 ? 'in-stock' : 'out-stock' }}">
                                        <i class="fas fa-{{ $groupStock > 0 ? 'check-circle' : 'times-circle' }}"></i>
                                        Stock: {{ $groupStock }}
                                    </span>
                                </div>

                                <!-- Price Range for this Color -->
                                <div class="variant-price-range">
                                    <span class="price-item">
                                        <i class="fas fa-arrow-down"></i> Min: <strong>₹{{ number_format($groupMinPrice, 2) }}</strong>
                                    </span>
                                    @if($groupMinPrice != $groupMaxPrice && $groupMaxPrice > 0)
                                        <span class="price-item">
                                            <i class="fas fa-arrow-up"></i> Max: <strong>₹{{ number_format($groupMaxPrice, 2) }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <!-- Sizes Table -->
                                <div style="overflow-x:auto;">
                                    <table class="variant-sizes-table">
                                        <thead>
                                            <tr>
                                                <th style="width:60px;">Size</th>
                                                <th style="width:80px;">Cost Price</th>
                                                <th style="width:80px;">MRP</th>
                                                <th style="width:50px;">GST</th>
                                                <th style="width:80px;">Total Price</th>
                                                <th style="width:90px;">Discount</th>
                                                <th style="width:80px;">Final Price</th>
                                                <th style="width:50px;">Stock</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($groupVariants as $variant)
                                                @php
                                                    $sizeName = $variant->size ?? 'N/A';
                                                    $sizeCostPrice = $variant->cost_price ?? 0;
                                                    $sizeMrp = $variant->mrp ?? 0;
                                                    $sizeGstPercentage = $variant->gst_percentage ?? 0;
                                                    $sizeTotalPrice = $variant->total_price ?? 0;
                                                    $sizeDiscountType = $variant->discount_type ?? 'flat';
                                                    $sizeDiscountValue = $variant->discount_value ?? 0;
                                                    $sizeFinalPrice = $variant->final_price ?? 0;
                                                    $sizeStock = $variant->stock ?? 0;
                                                @endphp
                                                <tr>
                                                    <td><span class="size-badge">{{ $sizeName }}</span></td>
                                                    <td class="price-cell">₹{{ number_format($sizeCostPrice, 2) }}</td>
                                                    <td class="price-cell">₹{{ number_format($sizeMrp, 2) }}</td>
                                                    <td>{{ $sizeGstPercentage }}%</td>
                                                    <td class="price-cell">₹{{ number_format($sizeTotalPrice, 2) }}</td>
                                                    <td>
                                                        @if($sizeDiscountType == 'flat')
                                                            <span class="badge bg-primary" style="font-size:9px;">Flat ₹{{ number_format($sizeDiscountValue, 2) }}</span>
                                                        @elseif($sizeDiscountType == 'percentage')
                                                            <span class="badge bg-warning text-dark" style="font-size:9px;">{{ $sizeDiscountValue }}%</span>
                                                        @else
                                                            <span class="badge bg-secondary" style="font-size:9px;">None</span>
                                                        @endif
                                                    </td>
                                                    <td class="final-price-cell">₹{{ number_format($sizeFinalPrice, 2) }}</td>
                                                    <td class="stock-cell {{ $sizeStock > 0 ? 'in-stock' : 'out-stock' }}">
                                                        {{ $sizeStock }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Variant Images -->
                                @if($groupImages && $groupImages->count() > 0)
                                    <div class="variant-images">
                                        <span class="vlabel"><i class="fas fa-images"></i> Images</span>
                                        <div class="image-thumbs">
                                            @foreach($groupImages as $vImg)
                                                <div class="vthumb" onclick="openImageModal('{{ asset('storage/'.$vImg->image_path) }}')">
                                                    <img src="{{ asset('storage/'.$vImg->image_path) }}" alt="Variant Image">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach

                        <!-- ========================================== -->
                        <!-- ====== VARIANT SUMMARY =================== -->
                        <!-- ========================================== -->
                        @php
                            $minVariantPrice = $product->variants->min('final_price') ?? 0;
                            $maxVariantPrice = $product->variants->max('final_price') ?? 0;
                            $avgVariantPrice = $product->variants->avg('final_price') ?? 0;
                            $totalVariantStock = $product->variants->sum('stock');
                        @endphp
                        <div class="variant-summary">
                            <div class="summary-item">
                                <span class="slabel"><i class="fas fa-cubes"></i> Total Variants</span>
                                <span class="svalue blue">{{ $variantCount }}</span>
                            </div>
                            <div class="summary-item">
                                <span class="slabel"><i class="fas fa-boxes"></i> Total Stock</span>
                                <span class="svalue green">{{ $totalVariantStock }}</span>
                            </div>
                            <div class="summary-item">
                                <span class="slabel"><i class="fas fa-arrow-down"></i> Min Price</span>
                                <span class="svalue">₹{{ number_format($minVariantPrice, 2) }}</span>
                            </div>
                            <div class="summary-item">
                                <span class="slabel"><i class="fas fa-arrow-up"></i> Max Price</span>
                                <span class="svalue">₹{{ number_format($maxVariantPrice, 2) }}</span>
                            </div>
                            <div class="summary-item">
                                <span class="slabel"><i class="fas fa-chart-line"></i> Avg Price</span>
                                <span class="svalue">₹{{ number_format($avgVariantPrice, 2) }}</span>
                            </div>
                            <div class="summary-item">
                                <span class="slabel"><i class="fas fa-palette"></i> Colors</span>
                                <span class="svalue blue">{{ count($variantGroups) }}</span>
                            </div>
                        </div>

                        <!-- Description -->
                        @if($product->description)
                            <div class="section-title">
                                <i class="fas fa-align-left"></i> Description
                            </div>
                            <div class="description-box">
                                {!! nl2br(e($product->description)) !!}
                            </div>
                        @endif
                    </div>
                </div>

            @else
                <!-- ========================================== -->
                <!-- ====== NORMAL PRODUCT LAYOUT ============= -->
                <!-- ========================================== -->
                <div class="row">
                    <!-- LEFT COLUMN - IMAGES -->
                    <div class="col-md-4">
                        @php
                            $mainImage = null;
                            $allImages = collect();
                            
                            if (isset($product->productImages) && $product->productImages->count() > 0) {
                                $mainImage = $product->productImages->where('is_main', 1)->first();
                                if (!$mainImage) {
                                    $mainImage = $product->productImages->first();
                                }
                                $allImages = $product->productImages;
                            } elseif (isset($product->image) && !empty($product->image)) {
                                $mainImage = (object) ['image_path' => $product->image];
                                $allImages = collect([$mainImage]);
                            }
                        @endphp

                        <div class="product-image-container">
                            @if($mainImage)
                                <img src="{{ asset('storage/'.($mainImage->image_path ?? $mainImage)) }}" alt="{{ $product->name }}" id="mainProductImage">
                            @else
                                <div class="no-image">
                                    <i class="fas fa-image"></i>
                                    <span>No Image Available</span>
                                </div>
                            @endif
                        </div>

                        @if($allImages && $allImages->count() > 1)
                            <div class="thumbnail-gallery" id="thumbnailGallery">
                                @foreach($allImages as $index => $img)
                                    <div class="thumb {{ $index == 0 ? 'active' : '' }}" 
                                         onclick="changeMainImage(this, '{{ asset('storage/'.($img->image_path ?? $img)) }}')">
                                        <img src="{{ asset('storage/'.($img->image_path ?? $img)) }}" alt="Thumbnail {{ $index + 1 }}">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- RIGHT COLUMN - PRODUCT DETAILS -->
                    <div class="col-md-8">
                        <h3 class="product-title">{{ $product->name }}</h3>

                        <div class="product-meta">
                            @if(isset($product->topCategory) && $product->topCategory)
                                <span class="badge-custom topcategory"><i class="fas fa-arrow-up"></i> {{ $product->topCategory->name }}</span>
                            @endif
                            @if(isset($product->category) && $product->category)
                                <span class="badge-custom category"><i class="fas fa-folder"></i> {{ $product->category->name }}</span>
                            @endif
                            @if(isset($product->subCategory) && $product->subCategory)
                                <span class="badge-custom subcategory"><i class="fas fa-folder-open"></i> {{ $product->subCategory->name }}</span>
                            @endif
                            @if(isset($product->brand) && $product->brand)
                                <span class="badge-custom brand"><i class="fas fa-tag"></i> {{ $product->brand->name }}</span>
                            @endif
                            @if(isset($product->productType) && $product->productType)
                                <span class="badge-custom type"><i class="fas fa-layer-group"></i> {{ $product->productType->name }}</span>
                            @endif
                        </div>

                        <!-- Price Display -->
                        <div class="price-display">
                            <span class="final-price">₹{{ number_format($product->final_price ?? $product->mrp, 2) }}</span>
                            @if(isset($product->final_price) && $product->final_price && $product->final_price < $product->mrp)
                                <span class="original-price">₹{{ number_format($product->mrp, 2) }}</span>
                                <span class="discount-badge">-{{ round((($product->mrp - $product->final_price) / $product->mrp) * 100) }}%</span>
                            @endif
                            @if(isset($product->gst_percentage) && $product->gst_percentage > 0)
                                <span class="gst-tag"><i class="fas fa-percent"></i> GST {{ $product->gst_percentage }}%</span>
                            @endif
                        </div>

                        <!-- Product Details Table -->
                        <div class="section-title">
                            <i class="fas fa-box"></i> Product Details
                        </div>

                        <table class="detail-table">
                            <tr>
                                <td class="label"><i class="fas fa-tag"></i> Cost Price</td>
                                <td class="value">₹{{ number_format($product->price ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="label"><i class="fas fa-tags"></i> MRP</td>
                                <td class="value">₹{{ number_format($product->mrp ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="label"><i class="fas fa-percent"></i> Discount Type</td>
                                <td class="value">
                                    @if(isset($product->discount_type) && $product->discount_type == 'flat')
                                        <span class="badge bg-primary" style="font-size:11px;">Flat</span>
                                    @elseif(isset($product->discount_type) && $product->discount_type == 'percentage')
                                        <span class="badge bg-warning text-dark" style="font-size:11px;">Percentage</span>
                                    @else
                                        <span class="badge bg-secondary" style="font-size:11px;">No Discount</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="label"><i class="fas fa-percent"></i> Discount Value</td>
                                <td class="value">
                                    @if(isset($product->discount_type) && $product->discount_type == 'flat')
                                        ₹{{ number_format($product->discount_value ?? 0, 2) }}
                                    @elseif(isset($product->discount_type) && $product->discount_type == 'percentage')
                                        {{ $product->discount_value ?? 0 }}%
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="label"><i class="fas fa-calculator"></i> Discount Amount</td>
                                <td class="value">₹{{ number_format($product->discount_amount ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="label"><i class="fas fa-percent"></i> GST Rate</td>
                                <td class="value">{{ $product->gst_percentage ?? 0 }}%</td>
                            </tr>
                            <tr>
                                <td class="label"><i class="fas fa-calculator"></i> GST Amount</td>
                                <td class="value">₹{{ number_format($product->gst_amount ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="label"><i class="fas fa-receipt"></i> Total Price</td>
                                <td class="value">₹{{ number_format($product->total_price ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="label"><i class="fas fa-flag"></i> Final Price</td>
                                <td class="value"><strong style="color: var(--success); font-size:16px;">₹{{ number_format($product->final_price ?? 0, 2) }}</strong></td>
                            </tr>
                            <tr>
                                <td class="label"><i class="fas fa-boxes"></i> Stock</td>
                                <td class="value">
                                    <span class="badge bg-{{ ($product->stock ?? 0) > 0 ? 'success' : 'danger' }}" style="font-size:12px; padding:4px 12px;">
                                        {{ $product->stock ?? 0 }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="label"><i class="fas fa-circle"></i> Status</td>
                                <td class="value">
                                    <span class="badge-status {{ strtolower($product->status ?? 'draft') }}">
                                        <span class="dot"></span> {{ $product->status ?? 'Draft' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="label"><i class="fas fa-truck"></i> COD Available</td>
                                <td class="value">
                                    <span class="badge bg-{{ ($product->cod_available ?? 0) ? 'success' : 'secondary' }}" style="font-size:12px; padding:4px 12px;">
                                        {{ ($product->cod_available ?? 0) ? 'Available' : 'Not Available' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="label"><i class="fas fa-undo"></i> Return Days</td>
                                <td class="value">{{ $product->return_days ?? 'N/A' }} days</td>
                            </tr>
                            <tr>
                                <td class="label"><i class="fas fa-clock"></i> Delivery Days</td>
                                <td class="value">{{ $product->delivery_days ?? 'N/A' }} days</td>
                            </tr>
                            @if(isset($product->sizeChart) && $product->sizeChart)
                            <tr>
                                <td class="label"><i class="fas fa-ruler"></i> Size Chart</td>
                                <td class="value">{{ $product->sizeChart->title }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="label"><i class="fas fa-calendar"></i> Created Date</td>
                                <td class="value">{{ $product->created_at->format('d M Y, h:i A') }}</td>
                            </tr>
                            <tr>
                                <td class="label"><i class="fas fa-edit"></i> Last Updated</td>
                                <td class="value">{{ $product->updated_at->format('d M Y, h:i A') }}</td>
                            </tr>
                        </table>

                        <!-- Description -->
                        @if($product->description)
                            <div class="section-title">
                                <i class="fas fa-align-left"></i> Description
                            </div>
                            <div class="description-box">
                                {!! nl2br(e($product->description)) !!}
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Image" style="max-width:100%; max-height:80vh; object-fit:contain;">
            </div>
        </div>
    </div>
</div>

<script>
    function changeMainImage(element, imageSrc) {
        document.querySelectorAll('.thumbnail-gallery .thumb').forEach(function(thumb) {
            thumb.classList.remove('active');
        });
        element.classList.add('active');
        var mainImage = document.getElementById('mainProductImage');
        if (mainImage) {
            mainImage.src = imageSrc;
            mainImage.onerror = function() {
                this.src = '{{ asset('images/no-image.png') }}';
            };
        }
    }

    function openImageModal(imageSrc) {
        document.getElementById('modalImage').src = imageSrc;
        var modal = new bootstrap.Modal(document.getElementById('imageModal'));
        modal.show();
    }

    document.addEventListener('DOMContentLoaded', function() {
        var thumbs = document.querySelectorAll('.thumbnail-gallery .thumb');
        if (thumbs.length > 1) {
            document.addEventListener('keydown', function(e) {
                var activeThumb = document.querySelector('.thumbnail-gallery .thumb.active');
                if (!activeThumb) return;

                var index = Array.from(thumbs).indexOf(activeThumb);
                var newIndex = index;

                if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
                    newIndex = (index + 1) % thumbs.length;
                } else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
                    newIndex = (index - 1 + thumbs.length) % thumbs.length;
                } else {
                    return;
                }

                e.preventDefault();
                var newThumb = thumbs[newIndex];
                var imgSrc = newThumb.querySelector('img').src;
                changeMainImage(newThumb, imgSrc);
            });
        }
    });
</script>
@endsection