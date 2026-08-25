@extends('layouts.admin-layout')

@section('content')
<style>
    /* ============================================ */
    /* COLOR VARIABLES - MATCHING NAVBAR          */
    /* ============================================ */
    :root {
        --primary: #4a9eff;
        --primary-dark: #2b7be0;
        --primary-light: #8ab4f8;
        --success: #4caf50;
        --warning: #ffa726;
        --danger: #ef5350;
        --dark: #1a1a2e;
        --gray: #6c757d;
        --light-gray: #f8f9fa;
        --border-color: #e9ecef;
        --shadow: 0 2px 20px rgba(0,0,0,0.05);
        --shadow-hover: 0 8px 35px rgba(0,0,0,0.12);
        --radius: 10px;
        --radius-lg: 16px;
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

    /* ============================================ */
    /* FORM CARD                                   */
    /* ============================================ */
    .form-card {
        background: #ffffff;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow);
        border: 1px solid rgba(0,0,0,0.04);
        overflow: hidden;
        max-width: 860px;
        margin: 0 auto;
    }

    .form-card .card-header {
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

    .form-card .card-header h4 {
        margin: 0;
        font-weight: 600;
        font-size: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-card .card-header h4 i {
        color: #4a9eff;
    }

    .form-card .card-header small {
        font-size: 12px;
        opacity: 0.8;
        font-weight: 400;
    }

    .form-card .card-body {
        padding: 20px 24px;
    }

    /* ============================================ */
    /* SECTION HEADERS                             */
    /* ============================================ */
    .section-title {
        font-size: 14px;
        font-weight: 600;
        color: var(--dark);
        padding: 6px 14px;
        background: var(--light-gray);
        border-radius: var(--radius);
        border-left: 3px solid var(--primary);
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .section-title i {
        color: var(--primary);
        font-size: 14px;
    }

    .section-title .badge {
        font-size: 10px;
        padding: 2px 10px;
        background: var(--primary);
        color: #fff;
        border-radius: 20px;
    }

    /* ============================================ */
    /* FORM STYLES                                 */
    /* ============================================ */
    .field-label {
        font-size: 12px;
        font-weight: 500;
        color: var(--dark);
        margin-bottom: 4px;
        display: block;
    }

    .field-label .required-star {
        color: var(--danger) !important;
    }

    .form-control,
    .form-select {
        border-radius: var(--radius);
        border: 1px solid var(--border-color);
        padding: 7px 12px;
        font-size: 13px;
        transition: all 0.3s;
        background: #ffffff;
        height: 38px;
        color: var(--dark);
        width: 100%;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(74, 158, 255, 0.12);
        outline: none;
    }

    .form-control.is-invalid,
    .form-select.is-invalid {
        border-color: var(--danger);
        box-shadow: 0 0 0 3px rgba(239, 83, 80, 0.12);
    }

    select.form-control,
    select.form-select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236c757d' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 36px;
        cursor: pointer;
        color: #1a1a2e !important;
        background-color: #ffffff !important;
    }

    select.form-control option,
    select.form-select option {
        padding: 8px 12px;
        color: #1a1a2e !important;
        background: #ffffff !important;
    }

    select.form-control option:checked,
    select.form-select option:checked {
        background: #d4e8fc !important;
        color: #1a1a2e !important;
    }

    textarea.form-control {
        height: auto;
        min-height: 80px;
        resize: vertical;
        line-height: 1.6;
    }

    .help-text {
        font-size: 11px;
        color: var(--gray);
        margin-top: 3px;
    }

    .help-text i {
        margin-right: 3px;
        font-size: 10px;
    }

    /* ============================================ */
    /* PRICE INPUT                                 */
    /* ============================================ */
    .price-input-group {
        position: relative;
    }

    .price-input-group .currency-symbol {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        font-weight: 600;
        color: var(--gray);
        font-size: 13px;
        z-index: 2;
    }

    .price-input-group .form-control {
        padding-left: 25px;
    }

    /* ============================================ */
    /* DISCOUNT TYPE                               */
    /* ============================================ */
    .discount-type-group {
        display: flex;
        gap: 15px;
        margin-top: 2px;
        flex-wrap: wrap;
    }

    .discount-type-group .form-check {
        display: flex;
        align-items: center;
        gap: 6px;
        margin: 0;
        padding: 0;
    }

    .discount-type-group .form-check-input {
        width: 16px;
        height: 16px;
        margin: 0;
        cursor: pointer;
        accent-color: var(--primary);
    }

    .discount-type-group .form-check-label {
        font-size: 12px;
        font-weight: 500;
        color: var(--dark);
        cursor: pointer;
        margin: 0;
    }

    /* ============================================ */
    /* TOGGLE SWITCH                               */
    /* ============================================ */
    .switch {
        position: relative;
        display: inline-block;
        width: 46px;
        height: 24px;
        flex-shrink: 0;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .3s;
        border-radius: 34px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .3s;
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0,0,0,0.15);
    }

    input:checked+.slider {
        background-color: var(--success);
    }

    input:checked+.slider:before {
        transform: translateX(22px);
    }

    .toggle-label {
        font-size: 12px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .toggle-status {
        font-weight: 600;
        padding: 1px 8px;
        border-radius: 12px;
        font-size: 11px;
    }

    .toggle-status.active {
        color: var(--success);
        background: #e8f5e9;
    }

    .toggle-status.inactive {
        color: var(--danger);
        background: #fce4ec;
    }

    /* ============================================ */
    /* GST & CALCULATION                           */
    /* ============================================ */
    .gst-badge {
        display: inline-block;
        background: var(--primary);
        color: white;
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 11px;
        margin-left: 5px;
    }

    .gst-info {
        background: #e7f3ff;
        border-left: 4px solid var(--primary);
        padding: 8px 15px;
        border-radius: 5px;
        margin-top: 10px;
        display: flex;
        flex-wrap: wrap;
        gap: 10px 20px;
        align-items: center;
        font-size: 12px;
    }

    .gst-info .gst-label {
        font-weight: 600;
        color: var(--primary-dark);
    }

    .gst-info .gst-value {
        font-weight: 600;
        color: var(--dark);
    }

    .calculation-flow {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        background: var(--light-gray);
        padding: 8px 15px;
        border-radius: var(--radius);
        margin-top: 10px;
        font-size: 12px;
        border: 1px solid var(--border-color);
    }

    .calculation-flow .step {
        background: white;
        padding: 4px 10px;
        border-radius: 20px;
        border: 1px solid var(--border-color);
        font-size: 12px;
        font-weight: 500;
        color: var(--dark);
    }

    .calculation-flow .step .highlight {
        font-weight: 700;
        color: var(--primary);
    }

    .calculation-flow .step .highlight.green {
        color: var(--success);
    }

    .calculation-flow .arrow {
        font-size: 16px;
        color: var(--gray);
        font-weight: 300;
    }

    /* ============================================ */
    /* FINAL AMOUNT BOXES                          */
    /* ============================================ */
    .final-amount-box {
        border-radius: var(--radius);
        padding: 12px 16px;
        text-align: center;
        background: var(--light-gray);
        border: 2px solid var(--border-color);
        transition: all 0.3s;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .final-amount-box .label {
        font-size: 11px;
        color: var(--gray);
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .final-amount-box .amount {
        font-size: 26px;
        font-weight: 700;
        color: var(--success);
        margin-top: 2px;
    }

    .final-amount-box .discount-info {
        font-size: 11px;
        color: var(--gray);
        margin-top: 2px;
    }

    .final-amount-box.save-box {
        border-color: var(--danger);
    }

    .final-amount-box.final-box {
        border-color: var(--success);
    }

    /* ============================================ */
    /* VARIANT SECTION                             */
    /* ============================================ */
    .variant-section {
        display: none;
        margin-top: 16px;
    }

    .variant-section.active {
        display: block;
    }

    .variant-item {
        background: #ffffff;
        border-radius: var(--radius);
        padding: 16px 18px;
        margin-bottom: 14px;
        border: 1px solid var(--border-color);
        transition: all 0.3s;
    }

    .variant-item:hover {
        border-color: var(--primary);
        box-shadow: var(--shadow-hover);
    }

    .variant-item .variant-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 14px;
        padding-bottom: 10px;
        border-bottom: 1px solid var(--border-color);
    }

    .variant-item .variant-number {
        font-weight: 600;
        color: var(--primary);
        font-size: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .variant-item .variant-number i {
        font-size: 16px;
    }

    .variant-item .remove-variant {
        background: none;
        border: none;
        color: var(--danger);
        cursor: pointer;
        font-size: 13px;
        padding: 4px 10px;
        border-radius: 6px;
        transition: all 0.3s;
        font-weight: 500;
    }

    .variant-item .remove-variant:hover {
        background: #fce4ec;
        color: #c62828;
    }

    /* ============================================ */
    /* SIZE ROW                                    */
    /* ============================================ */
    .size-row {
        display: flex;
        gap: 8px;
        align-items: center;
        margin-bottom: 8px;
        flex-wrap: wrap;
        background: var(--light-gray);
        padding: 8px 12px;
        border-radius: var(--radius);
        border: 1px solid var(--border-color);
        transition: all 0.3s;
    }

    .size-row:hover {
        border-color: var(--primary);
        background: #f0f7ff;
    }

    .size-row .form-control {
        flex: 1;
        min-width: 65px;
        font-size: 12px;
        height: 34px;
        padding: 4px 10px;
        border-radius: 6px;
    }

    .size-row .form-group {
        flex: 1;
        min-width: 60px;
    }

    .size-row .form-group label {
        font-size: 9px;
        font-weight: 600;
        color: var(--gray);
        text-transform: uppercase;
        letter-spacing: 0.4px;
        display: block;
        margin-bottom: 2px;
    }

    .size-row .remove-size {
        color: var(--danger);
        cursor: pointer;
        font-size: 16px;
        padding: 0 4px;
        transition: all 0.3s;
        background: none;
        border: none;
        line-height: 1;
    }

    .size-row .remove-size:hover {
        color: #c62828;
        transform: scale(1.2);
    }

    .size-calculation {
        font-size: 10px;
        color: var(--gray);
        padding: 2px 10px;
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid var(--border-color);
        white-space: nowrap;
        font-weight: 500;
    }

    /* ============================================ */
    /* VARIANT IMAGES                              */
    /* ============================================ */
    .variant-image-upload-area {
        border: 2px dashed var(--border-color);
        border-radius: var(--radius);
        padding: 14px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        background: var(--light-gray);
    }

    .variant-image-upload-area:hover {
        border-color: var(--primary);
        background: #e8f4fd;
    }

    .variant-image-upload-area i {
        font-size: 22px;
        color: var(--primary);
    }

    .variant-image-upload-area p {
        font-size: 12px;
        color: var(--gray);
        margin: 4px 0 0 0;
        font-weight: 500;
    }

    .variant-image-preview-container {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-top: 8px;
    }

    .variant-image-preview-item {
        position: relative;
        width: 60px;
        height: 60px;
        border: 1px solid var(--border-color);
        border-radius: var(--radius);
        overflow: hidden;
        background: #fff;
        box-shadow: var(--shadow);
    }

    .variant-image-preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .variant-image-preview-item .remove-img {
        position: absolute;
        top: -6px;
        right: -6px;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: var(--danger);
        color: white;
        border: none;
        font-size: 9px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }

    .variant-image-preview-item .remove-img:hover {
        transform: scale(1.15);
    }

    /* ============================================ */
    /* VARIANT TOTAL STOCK                         */
    /* ============================================ */
    .variant-total-stock {
        background: #e7f3ff;
        padding: 8px 15px;
        border-radius: var(--radius);
        margin-top: 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: 1px solid #d4e4f8;
    }

    .variant-total-stock .label {
        font-weight: 600;
        color: var(--primary-dark);
        font-size: 12px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .variant-total-stock .value {
        font-size: 18px;
        font-weight: 700;
        color: var(--success);
    }

    /* ============================================ */
    /* GRAND TOTAL STOCK                           */
    /* ============================================ */
    .grand-total-stock {
        background: #e8f5e9;
        padding: 10px 15px;
        border-radius: var(--radius);
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: 2px solid var(--success);
    }

    .grand-total-stock .label {
        font-weight: 700;
        color: #2e7d32;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .grand-total-stock .value {
        font-size: 22px;
        font-weight: 700;
        color: var(--success);
    }

    /* ============================================ */
    /* PRODUCT IMAGES                              */
    /* ============================================ */
    .image-upload-area {
        border: 2px dashed var(--border-color);
        border-radius: var(--radius);
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        background: var(--light-gray);
    }

    .image-upload-area:hover {
        border-color: var(--primary);
        background: #e8f4fd;
    }

    .image-upload-area i {
        font-size: 28px;
        color: var(--primary);
    }

    .image-upload-area p {
        font-size: 13px;
        color: var(--gray);
        margin: 6px 0 0 0;
        font-weight: 500;
    }

    .image-preview-container {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 10px;
    }

    .image-preview-item {
        position: relative;
        width: 72px;
        height: 72px;
        border: 1px solid var(--border-color);
        border-radius: var(--radius);
        overflow: hidden;
        background: #fff;
        box-shadow: var(--shadow);
    }

    .image-preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .image-preview-item .remove-img {
        position: absolute;
        top: -6px;
        right: -6px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: var(--danger);
        color: white;
        border: none;
        font-size: 10px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }

    .image-preview-item .remove-img:hover {
        transform: scale(1.15);
    }

    /* ============================================ */
    /* BUTTONS                                     */
    /* ============================================ */
    .btn-primary {
        background: var(--primary);
        color: #fff;
        border: none;
        padding: 8px 24px;
        border-radius: var(--radius);
        font-weight: 500;
        font-size: 13px;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(74, 158, 255, 0.35);
    }

    .btn-secondary {
        background: var(--light-gray);
        color: var(--gray);
        border: 1px solid var(--border-color);
        padding: 8px 24px;
        border-radius: var(--radius);
        font-weight: 500;
        font-size: 13px;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-secondary:hover {
        background: #e9ecef;
        color: var(--dark);
    }

    .btn-sm {
        padding: 4px 14px;
        font-size: 11px;
        height: 30px;
        border-radius: 6px;
    }

    .btn-w100 {
        width: 100%;
        justify-content: center;
    }

    .form-actions {
        padding-top: 16px;
        border-top: 1px solid var(--border-color);
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 16px;
    }

    /* ============================================ */
    /* ALERT                                       */
    /* ============================================ */
    .alert-danger {
        background: #fce4ec;
        color: #c62828;
        border-left: 4px solid var(--danger);
        border-radius: var(--radius);
        padding: 10px 16px;
        margin-bottom: 16px;
        border: none;
        font-size: 13px;
    }

    .alert-danger ul {
        margin: 0;
        padding-left: 18px;
    }

    .alert-danger ul li {
        margin-bottom: 2px;
    }

    .alert-success {
        background: #e8f5e9;
        color: #2e7d32;
        border-left: 4px solid var(--success);
        border-radius: var(--radius);
        padding: 10px 16px;
        margin-bottom: 16px;
        border: none;
        font-size: 13px;
    }

    /* ============================================ */
    /* HIDE SECTION                                */
    /* ============================================ */
    .hidden-section {
        display: none !important;
    }

    /* ============================================ */
    /* SIZE CHART BADGE                            */
    /* ============================================ */
    .size-chart-badge {
        display: inline-block;
        padding: 1px 8px;
        border-radius: 10px;
        font-size: 9px;
        font-weight: 600;
        margin-left: 4px;
    }

    .size-chart-badge.men { background: #cfe2ff; color: #084298; }
    .size-chart-badge.women { background: #f8d7da; color: #721c24; }
    .size-chart-badge.kids { background: #d1e7dd; color: #0f5132; }
    .size-chart-badge.unisex { background: #e2d9f3; color: #4b0082; }
    .size-chart-badge.topwear { background: #fff3cd; color: #856404; }
    .size-chart-badge.bottomwear { background: #d6d8db; color: #1e2124; }
    .size-chart-badge.footwear { background: #fce4ec; color: #c62828; }

    /* ============================================ */
    /* STATUS BADGE                                */
    /* ============================================ */
    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .status-badge.active {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .status-badge.inactive {
        background: #fce4ec;
        color: #c62828;
    }

    .status-badge.draft {
        background: #fff3cd;
        color: #856404;
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
        .form-card {
            max-width: 100%;
        }
    }

    @media (max-width: 768px) {
        .admin-main-content {
            margin-left: 0 !important;
            max-width: 100% !important;
            padding: 12px 15px !important;
        }
        .form-card .card-header {
            padding: 12px 16px;
            flex-direction: column;
            align-items: flex-start;
        }
        .form-card .card-header h4 {
            font-size: 16px;
        }
        .form-card .card-body {
            padding: 14px 16px;
        }
        .form-actions {
            flex-direction: column;
        }
        .form-actions .btn {
            width: 100%;
            justify-content: center;
        }
        .size-row {
            flex-direction: column;
            align-items: stretch;
        }
        .size-row .form-control {
            min-width: 100%;
        }
        .calculation-flow {
            font-size: 10px;
            padding: 6px 12px;
        }
        .calculation-flow .step {
            font-size: 10px;
            padding: 2px 8px;
        }
        .final-amount-box .amount {
            font-size: 22px;
        }
    }

    @media (max-width: 576px) {
        .form-card .card-header h4 {
            font-size: 14px;
        }
        .form-card .card-body {
            padding: 10px 12px;
        }
        .field-label {
            font-size: 11px;
        }
        .form-control,
        .form-select {
            font-size: 12px;
            padding: 5px 10px;
            height: 34px;
        }
        .section-title {
            font-size: 12px;
            padding: 4px 10px;
        }
        .btn-primary,
        .btn-secondary {
            padding: 6px 16px;
            font-size: 12px;
        }
        .variant-item {
            padding: 12px 14px;
        }
        .image-preview-item {
            width: 56px;
            height: 56px;
        }
        .variant-image-preview-item {
            width: 48px;
            height: 48px;
        }
        .gst-info {
            font-size: 11px;
            padding: 6px 12px;
            flex-direction: column;
            align-items: flex-start;
            gap: 4px;
        }
        .final-amount-box .amount {
            font-size: 20px;
        }
    }
</style>

<div class="admin-main-content">
    <div class="form-card">
        <div class="card-header">
            <div>
                <h4><i class="fas fa-edit"></i> Edit Product</h4>
                <small>Update product details</small>
            </div>
            <span style="background:rgba(74,158,255,0.2); color:#8ab4f8; padding:3px 12px; border-radius:50px; font-size:11px;">
                <i class="fas fa-circle" style="font-size:6px; color:#ffa726;"></i> Edit Mode
            </span>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert-success">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.products.update', $product->id) }}"
                enctype="multipart/form-data" id="productForm">
                @csrf
                @method('PUT')

                <input type="hidden" name="discount_type" id="hidden_discount_type"
                    value="{{ $product->discount_type ?? 'flat' }}">
                <input type="hidden" name="discount_value" id="hidden_discount_value"
                    value="{{ $product->discount_value ?? 0 }}">
                <input type="hidden" name="discount_amount" id="hidden_discount_amount"
                    value="{{ $product->discount_amount ?? 0 }}">
                <input type="hidden" name="gst_percentage" id="hidden_gst_percentage"
                    value="{{ $product->gst_percentage ?? 0 }}">
                <input type="hidden" name="gst_amount" id="hidden_gst_amount"
                    value="{{ $product->gst_amount ?? 0 }}">
                <input type="hidden" name="total_price" id="hidden_total_price"
                    value="{{ $product->total_price ?? 0 }}">
                <input type="hidden" name="final_price" id="hidden_final_price"
                    value="{{ $product->final_price ?? 0 }}">
                <input type="hidden" name="deleted_variants" id="deleted_variants" value="">
                <input type="hidden" name="deleted_variant_images" id="deleted_variant_images" value="">
                <input type="hidden" name="deleted_images" id="deleted_images" value="">

                <!-- ========================================== -->
                <!-- BASIC INFORMATION                         -->
                <!-- ========================================== -->
                <div class="section-title">
                    <i class="fas fa-info-circle"></i> Basic Information
                </div>

                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="field-label">Product Name <span class="required-star">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="field-label">Top Category <span class="required-star">*</span></label>
                        <select name="top_category_id" id="top_category" class="form-control" required>
                            <option value="">-- Select --</option>
                            @foreach ($topCategories as $tc)
                                <option value="{{ $tc->id }}" data-gst="{{ $tc->gst_rate ?? 0 }}"
                                    {{ old('top_category_id', $product->top_category_id) == $tc->id ? 'selected' : '' }}>
                                    {{ $tc->name }}
                                    @if ($tc->gst_rate) (GST: {{ $tc->gst_rate }}%) @endif
                                </option>
                            @endforeach
                        </select>
                        <div class="help-text" id="gst_selected_info">
                            @if ($product->top_category_id && $product->topCategory)
                                GST: {{ $product->topCategory->gst_rate ?? 0 }}%
                            @else
                                <i class="fas fa-info-circle"></i> Select top category to auto-fill GST
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="field-label">Category <span class="required-star">*</span></label>
                        <select name="category_id" id="category" class="form-control" required>
                            <option value="">-- Select --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="field-label">Sub Category <span class="required-star">*</span></label>
                        <select name="sub_category_id" id="sub_category" class="form-control" required>
                            <option value="">-- Select --</option>
                            @foreach ($subCategories as $sub)
                                <option value="{{ $sub->id }}"
                                    {{ old('sub_category_id', $product->sub_category_id) == $sub->id ? 'selected' : '' }}>
                                    {{ $sub->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="help-text" id="subCategoryHelper"><i class="fas fa-info-circle"></i> Select category</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="field-label">Brand</label>
                        <select name="brand_id" class="form-control">
                            <option value="">-- Select --</option>
                            @foreach ($brands as $b)
                                <option value="{{ $b->id }}"
                                    {{ old('brand_id', $product->brand_id) == $b->id ? 'selected' : '' }}>
                                    {{ $b->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="field-label">Product Type</label>
                        <select name="product_type_id" id="product_type_id" class="form-control" onchange="toggleVariantSections(this.value)">
                            <option value="">-- Select --</option>
                            @foreach ($productTypes as $pt)
                                <option value="{{ $pt->id }}"
                                    {{ old('product_type_id', $product->product_type_id) == $pt->id ? 'selected' : '' }}>
                                    {{ $pt->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="help-text" id="productTypeHelper"><i class="fas fa-info-circle"></i> Select product type</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="field-label">Size Chart</label>
                        <select name="size_chart_id" id="size_chart_id" class="form-control">
                            <option value="">-- Select Size Chart --</option>
                            @foreach ($sizeCharts ?? [] as $sc)
                                <option value="{{ $sc->id }}"
                                    data-gender="{{ $sc->gender ?? 'unisex' }}"
                                    data-category="{{ $sc->category_type ?? 'topwear' }}"
                                    {{ old('size_chart_id', $product->size_chart_id) == $sc->id ? 'selected' : '' }}>
                                    {{ $sc->title }}
                                    <span class="size-chart-badge {{ $sc->gender ?? 'unisex' }}">{{ ucfirst($sc->gender ?? 'Unisex') }}</span>
                                    <span class="size-chart-badge {{ $sc->category_type ?? 'topwear' }}">{{ ucfirst($sc->category_type ?? 'Topwear') }}</span>
                                </option>
                            @endforeach
                        </select>
                        <div class="help-text"><i class="fas fa-info-circle"></i> Select a size chart for this product</div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- PRICING & GST                            -->
                <!-- ========================================== -->
                <div class="section-title">
                    <i class="fas fa-tags"></i> Pricing & GST
                    <span id="gst_badge" class="gst-badge"
                        style="{{ $product->top_category_id && $product->topCategory && $product->topCategory->gst_rate ? 'display:inline-block;' : 'display:none;' }}">
                        <i class="fas fa-check-circle"></i> GST: {{ $product->topCategory->gst_rate ?? 0 }}%
                    </span>
                </div>

                <div class="card mb-3" id="pricingSection">
                    <div class="card-body">
                        <!-- GST Info -->
                        <div class="gst-info" id="gst_info_box"
                            style="{{ $product->top_category_id && $product->topCategory && $product->topCategory->gst_rate ? 'display:block;' : 'display:none;' }}">
                            <span class="gst-label"><i class="fas fa-percent"></i> GST Rate:</span>
                            <span class="gst-value" id="gst_rate_display">{{ $product->topCategory->gst_rate ?? 0 }}%</span>
                            <span class="gst-label"><i class="fas fa-calculator"></i> GST Amount:</span>
                            <span class="gst-value" id="gst_amount_display">₹{{ number_format(($product->mrp * ($product->topCategory->gst_rate ?? 0)) / 100, 2) }}</span>
                            <span style="color: var(--gray); font-size: 12px;">(Calculated on SP)</span>
                        </div>

                        <!-- Calculation Flow -->
                        <div class="calculation-flow" id="calculation_flow">
                            <span class="step">SP: <span class="highlight" id="flow_selling">₹{{ number_format($product->mrp, 2) }}</span></span>
                            <span class="arrow">+</span>
                            <span class="step">GST: <span class="highlight" id="flow_gst">₹{{ number_format(($product->mrp * ($product->topCategory->gst_rate ?? 0)) / 100, 2) }}</span></span>
                            <span class="arrow">=</span>
                            <span class="step">Total: <span class="highlight" id="flow_total_price">₹{{ number_format($product->mrp + ($product->mrp * ($product->topCategory->gst_rate ?? 0)) / 100, 2) }}</span></span>
                            <span class="arrow">−</span>
                            <span class="step">Disc: <span class="highlight" id="flow_discount">₹{{ number_format($product->mrp - $product->final_price, 2) }}</span></span>
                            <span class="arrow">=</span>
                            <span class="step" style="border-color: var(--success); background: #e8f5e9;">Final: <span class="highlight green" id="flow_final">₹{{ number_format($product->final_price, 2) }}</span></span>
                        </div>

                        <!-- Pricing Inputs -->
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="field-label">Cost Price (₹) <span class="required-star">*</span></label>
                                <div class="price-input-group">
                                    <span class="currency-symbol">₹</span>
                                    <input type="number" step="0.01" name="price" id="price" class="form-control" required min="0"
                                        value="{{ old('price', $product->price) }}">
                                </div>
                                <div class="help-text">Your purchase price</div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="field-label">Selling Price (₹) <span class="required-star">*</span></label>
                                <div class="price-input-group">
                                    <span class="currency-symbol">₹</span>
                                    <input type="number" step="0.01" name="mrp" id="mrp" class="form-control" required min="0"
                                        value="{{ old('mrp', $product->mrp) }}" oninput="calculateAll()">
                                </div>
                                <div class="help-text">Customer price before discount</div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="field-label">Discount Type</label>
                                <div class="discount-type-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="discount_type" id="discount_flat" value="flat"
                                            {{ old('discount_type', $product->discount_type ?? 'flat') == 'flat' ? 'checked' : '' }}
                                            onchange="calculateAll()">
                                        <label class="form-check-label" for="discount_flat">Flat</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="discount_type" id="discount_percentage" value="percentage"
                                            {{ old('discount_type', $product->discount_type ?? 'flat') == 'percentage' ? 'checked' : '' }}
                                            onchange="calculateAll()">
                                        <label class="form-check-label" for="discount_percentage">%</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="field-label">Discount Value</label>
                                <input type="number" step="0.01" name="discount_value" id="discount_value" class="form-control" min="0"
                                    value="{{ old('discount_value', $product->discount_value ?? 0) }}" oninput="calculateAll()">
                                <div class="help-text" id="discount_value_hint">Enter discount amount</div>
                            </div>
                        </div>

                        <!-- Calculated Fields -->
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="field-label">GST Amt (₹)</label>
                                <div class="price-input-group">
                                    <span class="currency-symbol">₹</span>
                                    <input type="number" step="0.01" id="gst_amount_field" class="form-control" readonly
                                        style="background: var(--light-gray); font-weight: 600; color: var(--primary);">
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="field-label">Total Price (₹)</label>
                                <div class="price-input-group">
                                    <span class="currency-symbol">₹</span>
                                    <input type="number" step="0.01" id="total_price_display" class="form-control" readonly
                                        style="background: #fff3cd; font-weight: 600; color: #856404; border-color: #ffc107;">
                                </div>
                                <div class="help-text">SP + GST</div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="field-label">Disc Amt (₹)</label>
                                <div class="price-input-group">
                                    <span class="currency-symbol">₹</span>
                                    <input type="number" step="0.01" id="discount_amount_display" class="form-control" readonly
                                        style="background: #fce4ec; font-weight: 600; color: var(--danger);">
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="field-label">Final Price (₹) <span class="required-star">*</span></label>
                                <div class="price-input-group">
                                    <span class="currency-symbol">₹</span>
                                    <input type="number" step="0.01" name="final_price" id="final_price" class="form-control" readonly
                                        style="background: #e8f5e9; font-weight: 700; color: var(--success); font-size: 17px; border-color: #a5d6a7;"
                                        value="{{ old('final_price', $product->final_price) }}">
                                </div>
                            </div>
                        </div>

                        <!-- Stock, Status, COD -->
                        <div class="row mt-3">
                            <div class="col-md-4 mb-3">
                                <label class="field-label">Stock <span class="required-star">*</span></label>
                                <input type="number" name="stock" id="stock" class="form-control"
                                    value="{{ old('stock', $product->stock) }}" min="0" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="field-label">Status</label>
                                <select name="status" class="form-control">
                                    <option value="Active" {{ old('status', $product->status) == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Inactive" {{ old('status', $product->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="Draft" {{ old('status', $product->status) == 'Draft' ? 'selected' : '' }}>Draft</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="field-label">Cash on Delivery</label>
                                <div class="d-flex align-items-center mt-2" style="gap:10px;">
                                    <label class="switch">
                                        <input type="checkbox" name="cod_available" id="cod_toggle" value="1"
                                            {{ old('cod_available', $product->cod_available) ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                    <span class="toggle-label">Status: <span id="cod_status"
                                            class="toggle-status {{ old('cod_available', $product->cod_available) ? 'active' : 'inactive' }}">
                                            {{ old('cod_available', $product->cod_available) ? 'Available' : 'Not Available' }}
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- VARIANT SECTION                           -->
                <!-- ========================================== -->
                <div class="variant-section" id="variantSection">
                    <div class="section-title">
                        <i class="fas fa-palette"></i> Variant Details
                        <span class="text-muted" style="font-size:11px; font-weight:400; color:var(--gray);" id="variantTypeLabel">
                            @if ($product->variants && $product->variants->count() > 0)
                                {{ $product->productType->name ?? 'Top Wear' }}
                            @else
                                Top Wear
                            @endif
                        </span>
                        <span class="badge" id="variantGstBadge" style="background:var(--primary); color:#fff; font-size:9px;">
                            GST: {{ $product->topCategory->gst_rate ?? 0 }}%
                        </span>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body" id="variantContainer">

                            @php
                                $groupedVariants = [];
                                if ($product->variants && $product->variants->count() > 0) {
                                    foreach ($product->variants as $variant) {
                                        $color = $variant->color ?? 'default';
                                        if (!isset($groupedVariants[$color])) {
                                            $groupedVariants[$color] = [
                                                'color' => $color,
                                                'variants' => [],
                                                'images' => $variant->variantImages ?? collect(),
                                            ];
                                        }
                                        $groupedVariants[$color]['variants'][] = $variant;
                                    }
                                }
                            @endphp

                            @if (count($groupedVariants) > 0)
                                @foreach ($groupedVariants as $colorKey => $group)
                                    @php
                                        $variantTotalStock = 0;
                                        foreach ($group['variants'] as $v) {
                                            $variantTotalStock += $v->stock ?? 0;
                                        }
                                        $variantId = preg_replace('/[^a-zA-Z0-9_]/', '_', $colorKey);
                                        if (empty($variantId)) {
                                            $variantId = 'variant_' . $loop->iteration;
                                        }
                                    @endphp
                                    <div class="variant-item" id="variant-{{ $variantId }}">
                                        <div class="variant-header">
                                            <span class="variant-number"><i class="fas fa-palette"></i> Variant #{{ $loop->iteration }}</span>
                                            @if ($loop->iteration > 1)
                                                <button type="button" class="remove-variant" onclick="removeVariant('{{ $variantId }}')">
                                                    <i class="fas fa-times"></i> Remove
                                                </button>
                                            @endif
                                        </div>

                                        <div class="row">
                                            <!-- ===== COLOR - TEXT INPUT ===== -->
                                            <div class="col-md-4 mb-3">
                                                <label class="field-label">Color <span class="required-star">*</span></label>
                                                <input type="text" name="variants[{{ $variantId }}][color]"
                                                    class="form-control variant-required"
                                                    value="{{ $group['color'] }}"
                                                    placeholder="e.g., Red, Blue, Black">
                                                <div class="help-text"><i class="fas fa-pencil-alt"></i> Enter color name manually</div>
                                            </div>

                                            <div class="col-md-8 mb-3">
                                                <label class="field-label">Images <span class="required-star">*</span></label>
                                                <div class="variant-image-upload-area"
                                                    onclick="document.getElementById('variant_images_input_{{ $variantId }}').click()">
                                                    <i class="fas fa-cloud-upload-alt"></i>
                                                    <p>Click to upload variant images</p>
                                                </div>
                                                <input type="file" id="variant_images_input_{{ $variantId }}"
                                                    name="variants[{{ $variantId }}][images][]" class="form-control mt-1"
                                                    accept="image/*" multiple style="display: none;"
                                                    onchange="previewVariantImages(this, '{{ $variantId }}')">
                                                <div id="variant_images_preview_{{ $variantId }}" class="variant-image-preview-container mt-2">
                                                    @if ($group['images'] && $group['images']->count() > 0)
                                                        @foreach ($group['images'] as $img)
                                                            <div class="variant-image-preview-item existing">
                                                                <img src="{{ asset('storage/' . $img->image_path) }}" alt="Variant Image">
                                                                <button type="button" class="remove-img"
                                                                    onclick="removeExistingVariantImage({{ $img->id }}, '{{ $variantId }}')">×</button>
                                                                <input type="hidden"
                                                                    name="variants[{{ $variantId }}][existing_images][]"
                                                                    value="{{ $img->id }}">
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Sizes -->
                                        <div class="mb-3">
                                            <label class="field-label">Sizes <span class="required-star">*</span></label>
                                            <div id="sizesContainer_{{ $variantId }}" class="sizes-container">
                                                @foreach ($group['variants'] as $sizeIndex => $sizeVariant)
                                                    <div class="size-row">
                                                        <div class="form-group">
                                                            <label>Size</label>
                                                            <input type="text"
                                                                name="variants[{{ $variantId }}][sizes][{{ $sizeIndex }}][size]"
                                                                class="form-control variant-required"
                                                                value="{{ $sizeVariant->size ?? '' }}"
                                                                placeholder="Size">
                                                            <input type="hidden"
                                                                name="variants[{{ $variantId }}][sizes][{{ $sizeIndex }}][id]"
                                                                value="{{ $sizeVariant->id }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Cost Price</label>
                                                            <input type="number" step="0.01"
                                                                name="variants[{{ $variantId }}][sizes][{{ $sizeIndex }}][cost_price]"
                                                                class="form-control"
                                                                value="{{ $sizeVariant->cost_price ?? 0 }}"
                                                                placeholder="0" min="0"
                                                                oninput="calculateSizePrice(this, '{{ $variantId }}', {{ $sizeIndex }})">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>MRP</label>
                                                            <input type="number" step="0.01"
                                                                name="variants[{{ $variantId }}][sizes][{{ $sizeIndex }}][mrp]"
                                                                class="form-control variant-required"
                                                                value="{{ $sizeVariant->mrp ?? 0 }}"
                                                                placeholder="0" min="0"
                                                                oninput="calculateSizePrice(this, '{{ $variantId }}', {{ $sizeIndex }})">
                                                        </div>
                                                        <div class="form-group" style="min-width:55px;">
                                                            <label>Stock</label>
                                                            <input type="number"
                                                                name="variants[{{ $variantId }}][sizes][{{ $sizeIndex }}][stock]"
                                                                class="form-control variant-stock"
                                                                value="{{ $sizeVariant->stock ?? 0 }}"
                                                                placeholder="0" min="0"
                                                                oninput="updateAllStocks()" onchange="updateAllStocks()">
                                                        </div>
                                                        <div class="form-group" style="min-width:65px;">
                                                            <label>Disc Type</label>
                                                            <select
                                                                name="variants[{{ $variantId }}][sizes][{{ $sizeIndex }}][discount_type]"
                                                                class="form-control"
                                                                onchange="calculateSizePrice(this, '{{ $variantId }}', {{ $sizeIndex }})">
                                                                <option value="flat" {{ ($sizeVariant->discount_type ?? 'flat') == 'flat' ? 'selected' : '' }}>Flat</option>
                                                                <option value="percentage" {{ ($sizeVariant->discount_type ?? '') == 'percentage' ? 'selected' : '' }}>%</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group" style="min-width:60px;">
                                                            <label>Disc Value</label>
                                                            <input type="number" step="0.01"
                                                                name="variants[{{ $variantId }}][sizes][{{ $sizeIndex }}][discount_value]"
                                                                class="form-control"
                                                                value="{{ $sizeVariant->discount_value ?? 0 }}"
                                                                placeholder="0" min="0"
                                                                oninput="calculateSizePrice(this, '{{ $variantId }}', {{ $sizeIndex }})">
                                                        </div>
                                                        <span class="size-calculation"
                                                            id="sizeCalc_{{ $variantId }}_{{ $sizeIndex }}">
                                                            GST: ₹{{ number_format((($sizeVariant->mrp ?? 0) * ($sizeVariant->gst_percentage ?? 0)) / 100, 2) }}
                                                            | Total: ₹{{ number_format(($sizeVariant->mrp ?? 0) + (($sizeVariant->mrp ?? 0) * ($sizeVariant->gst_percentage ?? 0)) / 100, 2) }}
                                                            | Final: ₹{{ number_format(($sizeVariant->mrp ?? 0) + (($sizeVariant->mrp ?? 0) * ($sizeVariant->gst_percentage ?? 0)) / 100 - (($sizeVariant->discount_type ?? 'flat') == 'flat' ? $sizeVariant->discount_value ?? 0 : (($sizeVariant->mrp ?? 0) * ($sizeVariant->discount_value ?? 0)) / 100), 2) }}
                                                        </span>
                                                        @if ($loop->iteration > 1)
                                                            <span class="remove-size" onclick="removeSize(this, '{{ $variantId }}')">✕</span>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="button" class="btn btn-sm btn-secondary mt-2 add-size-btn" data-variant="{{ $variantId }}">
                                                <i class="fas fa-plus"></i> Add Size
                                            </button>
                                        </div>

                                        <div class="variant-total-stock">
                                            <span class="label"><i class="fas fa-cubes"></i> Variant Total Stock</span>
                                            <span class="value" id="totalVariantStock_{{ $variantId }}">
                                                {{ $variantTotalStock }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <!-- Default empty variant -->
                                <div class="variant-item" id="variant-default">
                                    <div class="variant-header">
                                        <span class="variant-number"><i class="fas fa-palette"></i> Variant #1</span>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="field-label">Color <span class="required-star">*</span></label>
                                            <input type="text" name="variants[default][color]" class="form-control variant-required"
                                                placeholder="e.g., Red, Blue, Black">
                                            <div class="help-text"><i class="fas fa-pencil-alt"></i> Enter color name manually</div>
                                        </div>
                                        <div class="col-md-8 mb-3">
                                            <label class="field-label">Images <span class="required-star">*</span></label>
                                            <div class="variant-image-upload-area" onclick="document.getElementById('variant_images_input_default').click()">
                                                <i class="fas fa-cloud-upload-alt"></i>
                                                <p>Click to upload variant images</p>
                                            </div>
                                            <input type="file" id="variant_images_input_default" name="variants[default][images][]"
                                                class="form-control mt-1" accept="image/*" multiple style="display: none;"
                                                onchange="previewVariantImages(this, 'default')">
                                            <div id="variant_images_preview_default" class="variant-image-preview-container mt-2"></div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="field-label">Sizes <span class="required-star">*</span></label>
                                        <div id="sizesContainer_default" class="sizes-container">
                                            <div class="size-row">
                                                <div class="form-group">
                                                    <label>Size</label>
                                                    <input type="text" name="variants[default][sizes][0][size]"
                                                        class="form-control variant-required" placeholder="S, M, L, XL">
                                                </div>
                                                <div class="form-group">
                                                    <label>Cost Price</label>
                                                    <input type="number" step="0.01" name="variants[default][sizes][0][cost_price]"
                                                        class="form-control" placeholder="0" min="0"
                                                        oninput="calculateSizePrice(this, 'default', 0)">
                                                </div>
                                                <div class="form-group">
                                                    <label>MRP</label>
                                                    <input type="number" step="0.01" name="variants[default][sizes][0][mrp]"
                                                        class="form-control variant-required" placeholder="0" min="0"
                                                        oninput="calculateSizePrice(this, 'default', 0)">
                                                </div>
                                                <div class="form-group" style="min-width:55px;">
                                                    <label>Stock</label>
                                                    <input type="number" name="variants[default][sizes][0][stock]"
                                                        class="form-control variant-stock" placeholder="0" min="0"
                                                        oninput="updateAllStocks()" onchange="updateAllStocks()">
                                                </div>
                                                <div class="form-group" style="min-width:65px;">
                                                    <label>Disc Type</label>
                                                    <select name="variants[default][sizes][0][discount_type]"
                                                        class="form-control" onchange="calculateSizePrice(this, 'default', 0)">
                                                        <option value="flat">Flat</option>
                                                        <option value="percentage">%</option>
                                                    </select>
                                                </div>
                                                <div class="form-group" style="min-width:60px;">
                                                    <label>Disc Value</label>
                                                    <input type="number" step="0.01" name="variants[default][sizes][0][discount_value]"
                                                        class="form-control" placeholder="0" min="0"
                                                        oninput="calculateSizePrice(this, 'default', 0)">
                                                </div>
                                                <span class="size-calculation" id="sizeCalc_default_0">GST: ₹0 | Total: ₹0 | Final: ₹0</span>
                                                <span class="remove-size" onclick="removeSize(this, 'default')">✕</span>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-secondary mt-2 add-size-btn" data-variant="default">
                                            <i class="fas fa-plus"></i> Add Size
                                        </button>
                                    </div>

                                    <div class="variant-total-stock">
                                        <span class="label"><i class="fas fa-cubes"></i> Variant Total Stock</span>
                                        <span class="value" id="totalVariantStock_default">0</span>
                                    </div>
                                </div>
                            @endif

                            <div id="additionalVariants"></div>

                            <div class="mt-3">
                                <button type="button" id="addVariantBtn" class="btn btn-primary btn-w100" style="padding:6px 16px; font-size:12px;">
                                    <i class="fas fa-plus"></i> Add Another Variant
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- DESCRIPTION                               -->
                <!-- ========================================== -->
                <div class="section-title">
                    <i class="fas fa-align-left"></i> Description
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="field-label">Description <span class="text-muted" style="font-weight:400; font-size:11px; color:var(--gray);">(Use bullet points with ● or -)</span></label>
                            <textarea name="description" id="description" class="form-control" rows="5">{{ old('description', $product->description) }}</textarea>
                            <div class="help-text"><i class="fas fa-info-circle"></i> Use <code>•</code> or <code>-</code> for bullet points. HTML supported.</div>
                        </div>
                        <div class="mt-3" id="descriptionPreview"
                            style="{{ old('description', $product->description) ? 'display:block;' : 'display:none;' }}">
                            <label class="field-label" style="font-size:11px;">Preview:</label>
                            <div class="border rounded p-3 bg-light" id="descriptionPreviewContent"
                                style="font-size:13px; border:1px solid var(--border-color) !important;">
                                {!! $product->description !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- PRODUCT IMAGES (ONLY FOR NORMAL MODE)     -->
                <!-- ========================================== -->
                <div class="section-title" id="productImagesTitle">
                    <i class="fas fa-images"></i> Product Images
                </div>

                <div class="card mb-3" id="productImagesSection">
                    <div class="card-body">
                        @if (isset($productImages) && $productImages->count() > 0)
                            <div class="mb-3">
                                <label class="field-label">Existing Images</label>
                                <div class="d-flex flex-wrap">
                                    @foreach ($productImages as $image)
                                        <div class="image-preview-item" id="existing-image-{{ $image->id }}" style="margin-right:10px; margin-bottom:10px;">
                                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="Product Image">
                                            <button type="button" class="remove-img" onclick="removeExistingImage({{ $image->id }})">×</button>
                                            <input type="hidden" name="existing_images[]" value="{{ $image->id }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="field-label">Add New Images <span class="text-muted" style="font-weight:400; font-size:11px; color:var(--gray);">(Max 4 total)</span></label>
                            <div class="image-upload-area" onclick="document.getElementById('product_images_input').click()">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p>Click to upload new images</p>
                            </div>
                            <input type="file" id="product_images_input" name="new_images[]"
                                class="form-control mt-1" accept="image/*" multiple style="display:block;"
                                onchange="previewImages(this)">
                            <div id="images_preview" class="image-preview-container"></div>
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- RETURN & DELIVERY                         -->
                <!-- ========================================== -->
                <div class="section-title">
                    <i class="fas fa-truck"></i> Return & Delivery
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="field-label">Return Days</label>
                                <select name="return_days" class="form-control">
                                    <option value="3" {{ old('return_days', $product->return_days) == 3 ? 'selected' : '' }}>3 Days</option>
                                    <option value="7" {{ old('return_days', $product->return_days) == 7 ? 'selected' : '' }}>7 Days</option>
                                    <option value="15" {{ old('return_days', $product->return_days) == 15 ? 'selected' : '' }}>15 Days</option>
                                    <option value="30" {{ old('return_days', $product->return_days) == 30 ? 'selected' : '' }}>30 Days</option>
                                    <option value="0" {{ old('return_days', $product->return_days) == 0 ? 'selected' : '' }}>Non-returnable</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="field-label">Delivery Days</label>
                                <select name="delivery_days" class="form-control">
                                    <option value="1" {{ old('delivery_days', $product->delivery_days) == 1 ? 'selected' : '' }}>1 Day</option>
                                    <option value="2" {{ old('delivery_days', $product->delivery_days) == 2 ? 'selected' : '' }}>2 Days</option>
                                    <option value="3" {{ old('delivery_days', $product->delivery_days) == 3 ? 'selected' : '' }}>3 Days</option>
                                    <option value="5" {{ old('delivery_days', $product->delivery_days) == 5 ? 'selected' : '' }}>5 Days</option>
                                    <option value="7" {{ old('delivery_days', $product->delivery_days) == 7 ? 'selected' : '' }}>7 Days</option>
                                    <option value="10" {{ old('delivery_days', $product->delivery_days) == 10 ? 'selected' : '' }}>10 Days</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- GRAND TOTAL STOCK                         -->
                <!-- ========================================== -->
                <div class="card mb-3" id="grandTotalStockSection" style="{{ ($product->variants && $product->variants->count() > 0) ? 'display:block;' : 'display:none;' }}">
                    <div class="card-body" style="background: #e8f5e9; border: 2px solid var(--success); border-radius: var(--radius);">
                        <div class="grand-total-stock" style="background:transparent; border:none; padding:0;">
                            <span class="label"><i class="fas fa-boxes"></i> Total Stock (All Variants)</span>
                            <span class="value" id="grandTotalStock">
                                @php
                                    $grandTotal = 0;
                                    if ($product->variants) {
                                        foreach ($product->variants as $v) {
                                            $grandTotal += $v->stock ?? 0;
                                        }
                                    }
                                @endphp
                                {{ $grandTotal }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- FORM ACTIONS                              -->
                <!-- ========================================== -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Product
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var currentGstRate = {{ $product->topCategory->gst_rate ?? 0 }};
        var variantIdCounter = {{ $product->variants ? $product->variants->count() : 0 }};
        var variantImageFiles = {};
        var isVariantMode = false;
        var imageFiles = [];

        // ============================================================
        // CALCULATE SIZE PRICE
        // ============================================================
        window.calculateSizePrice = function(element, variantId, sizeIndex) {
            var row = $(element).closest('.size-row');
            var mrp = parseFloat(row.find('input[name*="[mrp]"]').val()) || 0;
            var discountType = row.find('select[name*="[discount_type]"]').val() || 'flat';
            var discountValue = parseFloat(row.find('input[name*="[discount_value]"]').val()) || 0;
            var gstRate = currentGstRate || 0;

            var gstAmount = (mrp * gstRate) / 100;
        var totalPrice = mrp + gstAmount;

var discountAmount = 0;

if (discountType === 'flat') {
    discountAmount = discountValue;
} else {
    discountAmount = (totalPrice * discountValue) / 100;
        discountAmount = Math.round(discountAmount);

}

var finalPrice = totalPrice - discountAmount;

if (finalPrice < 0) finalPrice = 0;

            var calcSpan = row.find('.size-calculation');
            if (calcSpan.length > 0) {
                calcSpan.text('GST: ₹' + gstAmount.toFixed(0) + ' | Total: ₹' + totalPrice.toFixed(0) + ' | Final: ₹' + finalPrice
                    .toFixed(0));
            }
        };

        // ============================================================
        // UPDATE STOCKS
        // ============================================================
        window.updateAllStocks = function() {
            $('.variant-item').each(function() {
                var variantId = $(this).attr('id').replace('variant-', '');
                var total = 0;
                $(this).find('.size-row input[name*="[stock]"]').each(function() {
                    var val = parseInt($(this).val()) || 0;
                    total += val;
                });
                $('#totalVariantStock_' + variantId).text(total);
            });
            updateGrandTotalStock();
        };

        function updateGrandTotalStock() {
            var grandTotal = 0;
            $('.variant-item').each(function() {
                $(this).find('.size-row input[name*="[stock]"]').each(function() {
                    var val = parseInt($(this).val()) || 0;
                    grandTotal += val;
                });
            });
            $('#grandTotalStock').text(grandTotal);
        }

        // ============================================================
        // TOGGLE VARIANT SECTIONS
        // ============================================================
        window.toggleVariantSections = function(productTypeId) {
            var selectedOption = $('#product_type_id option:selected');
            var productTypeName = selectedOption.text().toLowerCase();

            var isClothing = productTypeName.includes('top') || productTypeName.includes('bottom') ||
                productTypeName.includes('foot') || productTypeName.includes('shirt') ||
                productTypeName.includes('tshirt') || productTypeName.includes('pant') ||
                productTypeName.includes('jean') || productTypeName.includes('shoe') ||
                productTypeName.includes('sandal') || productTypeName.includes('wear');

            if (isClothing && productTypeId) {
                isVariantMode = true;
                $('#pricingSection').addClass('hidden-section');
                $('#variantSection').addClass('active');
                $('#grandTotalStockSection').show();
                $('#productImagesSection').addClass('hidden-section');
                $('#productImagesTitle').addClass('hidden-section');
                $('.variant-required').prop('required', true);

                if (productTypeName.includes('top')) {
                    $('#variantTypeLabel').text('Top Wear');
                } else if (productTypeName.includes('bottom')) {
                    $('#variantTypeLabel').text('Bottom Wear');
                } else if (productTypeName.includes('foot')) {
                    $('#variantTypeLabel').text('Foot Wear');
                }

                $('.size-row').each(function() {
                    var mrpInput = $(this).find('input[name*="[mrp]"]');
                    if (mrpInput.length > 0) {
                        calculateSizePrice(mrpInput[0], 'default', 0);
                    }
                });
            } else {
                isVariantMode = false;
                $('#pricingSection').removeClass('hidden-section');
                $('#variantSection').removeClass('active');
                $('#grandTotalStockSection').hide();
                $('#productImagesSection').removeClass('hidden-section');
                $('#productImagesTitle').removeClass('hidden-section');
                $('.variant-required').prop('required', false);
            }

            updateVariantGst();
            updateAllStocks();
        };

        function updateVariantGst() {
            var gstRate = currentGstRate || 0;
            $('#variantGstBadge').text('GST: ' + gstRate + '%');
            $('.size-row').each(function() {
                var mrpInput = $(this).find('input[name*="[mrp]"]');
                if (mrpInput.length > 0) {
                    calculateSizePrice(mrpInput[0], 'default', 0);
                }
            });
        }

        // ============================================================
        // VARIANT IMAGES
        // ============================================================
        window.previewVariantImages = function(input, variantId) {
            variantId = variantId || 'default';
            var files = Array.from(input.files);

            if (!window.variantImageFiles[variantId]) {
                window.variantImageFiles[variantId] = [];
            }

            window.variantImageFiles[variantId] = window.variantImageFiles[variantId].concat(files);
            updateVariantImagePreview(variantId);

            var dataTransfer = new DataTransfer();
            window.variantImageFiles[variantId].forEach(function(file) {
                dataTransfer.items.add(file);
            });
            input.files = dataTransfer.files;
        };

        function updateVariantImagePreview(variantId) {
            var previewId = 'variant_images_preview_' + variantId;
            var preview = $('#' + previewId);
            preview.find('.new-image').remove();

            if (!window.variantImageFiles[variantId] || window.variantImageFiles[variantId].length === 0) return;

            window.variantImageFiles[variantId].forEach(function(file, index) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    preview.append(
                        '<div class="variant-image-preview-item new-image">' +
                        '<img src="' + e.target.result + '">' +
                        '<button type="button" class="remove-img" onclick="removeVariantImage(\'' +
                        variantId + '\', ' + index + ')">×</button>' +
                        '</div>'
                    );
                };
                reader.readAsDataURL(file);
            });
        }

        window.removeVariantImage = function(variantId, index) {
            if (window.variantImageFiles[variantId]) {
                window.variantImageFiles[variantId].splice(index, 1);

                var input = document.getElementById('variant_images_input_' + variantId);
                if (input) {
                    var dataTransfer = new DataTransfer();
                    window.variantImageFiles[variantId].forEach(function(file) {
                        dataTransfer.items.add(file);
                    });
                    input.files = dataTransfer.files;
                }

                var previewId = 'variant_images_preview_' + variantId;
                $('#' + previewId).find('.new-image').remove();
                updateVariantImagePreview(variantId);
            }
        };

        window.removeExistingVariantImage = function(imageId, variantId) {
            if (confirm('Remove this image?')) {
                var element = $('input[name="variants[' + variantId + '][existing_images][]"][value="' +
                    imageId + '"]');
                element.closest('.variant-image-preview-item').remove();

                var deletedInput = $('#deleted_variant_images');
                var deleted = deletedInput.val();
                if (deleted) {
                    var deletedArray = JSON.parse(deleted);
                    if (!deletedArray.includes(imageId)) {
                        deletedArray.push(imageId);
                        deletedInput.val(JSON.stringify(deletedArray));
                    }
                } else {
                    deletedInput.val(JSON.stringify([imageId]));
                }
            }
        };

        // ============================================================
        // ADD SIZE
        // ============================================================
        $(document).on('click', '.add-size-btn', function() {
            var variantId = $(this).data('variant');
            var container = $('#sizesContainer_' + variantId);
            var sizeIndex = container.find('.size-row').length;

            var newRow = `
                <div class="size-row">
                    <div class="form-group">
                        <label>Size</label>
                        <input type="text" name="variants[${variantId}][sizes][${sizeIndex}][size]" class="form-control variant-required" placeholder="S, M, L, XL">
                    </div>
                    <div class="form-group">
                        <label>Cost Price</label>
                        <input type="number" step="0.01" name="variants[${variantId}][sizes][${sizeIndex}][cost_price]" class="form-control" placeholder="0" min="0" oninput="calculateSizePrice(this, '${variantId}', ${sizeIndex})">
                    </div>
                    <div class="form-group">
                        <label>MRP</label>
                        <input type="number" step="0.01" name="variants[${variantId}][sizes][${sizeIndex}][mrp]" class="form-control variant-required" placeholder="0" min="0" oninput="calculateSizePrice(this, '${variantId}', ${sizeIndex})">
                    </div>
                    <div class="form-group" style="min-width:55px;">
                        <label>Stock</label>
                        <input type="number" name="variants[${variantId}][sizes][${sizeIndex}][stock]" class="form-control variant-stock" placeholder="0" min="0" oninput="updateAllStocks()" onchange="updateAllStocks()">
                    </div>
                    <div class="form-group" style="min-width:65px;">
                        <label>Disc Type</label>
                        <select name="variants[${variantId}][sizes][${sizeIndex}][discount_type]" class="form-control" onchange="calculateSizePrice(this, '${variantId}', ${sizeIndex})">
                            <option value="flat">Flat</option>
                            <option value="percentage">%</option>
                        </select>
                    </div>
                    <div class="form-group" style="min-width:60px;">
                        <label>Disc Value</label>
                        <input type="number" step="0.01" name="variants[${variantId}][sizes][${sizeIndex}][discount_value]" class="form-control" placeholder="0" min="0" oninput="calculateSizePrice(this, '${variantId}', ${sizeIndex})">
                    </div>
                    <span class="size-calculation" id="sizeCalc_${variantId}_${sizeIndex}">GST: ₹0 | Total: ₹0 | Final: ₹0</span>
                    <span class="remove-size" onclick="removeSize(this, '${variantId}')">✕</span>
                </div>
            `;
            container.append(newRow);
            if (isVariantMode) {
                container.find('.variant-required').prop('required', true);
            }
            updateAllStocks();
        });

        // ============================================================
        // REMOVE SIZE
        // ============================================================
        window.removeSize = function(element, variantId) {
            var row = $(element).closest('.size-row');
            var container = $('#sizesContainer_' + variantId);
            var totalRows = container.find('.size-row').length;
            if (totalRows > 1) {
                var sizeId = row.find('input[name*="[id]"]').val();
                if (sizeId) {
                    var deletedVariants = $('#deleted_variants').val();
                    var deletedArray = deletedVariants ? JSON.parse(deletedVariants) : [];
                    if (!deletedArray.includes(sizeId)) {
                        deletedArray.push(sizeId);
                        $('#deleted_variants').val(JSON.stringify(deletedArray));
                    }
                }
                row.remove();
                updateAllStocks();
            } else {
                alert('At least one size is required!');
            }
        };

        // ============================================================
        // ADD VARIANT
        // ============================================================
        $('#addVariantBtn').on('click', function() {
            variantIdCounter++;
            var variantId = 'variant_' + variantIdCounter;
            variantImageFiles[variantId] = [];

            var newVariant = `
                <div class="variant-item" id="variant-${variantId}">
                    <div class="variant-header">
                        <span class="variant-number"><i class="fas fa-palette"></i> Variant #${variantIdCounter}</span>
                        <button type="button" class="remove-variant" onclick="removeVariant('${variantId}')" style="background:none; border:none; color:var(--danger); cursor:pointer; font-size:13px; padding:4px 10px; border-radius:6px; transition:all 0.3s;">
                            <i class="fas fa-times"></i> Remove
                        </button>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="field-label">Color <span class="required-star">*</span></label>
                            <input type="text" name="variants[${variantId}][color]" class="form-control variant-required" placeholder="e.g., Red, Blue, Black">
                            <div class="help-text"><i class="fas fa-pencil-alt"></i> Enter color name manually</div>
                        </div>
                        <div class="col-md-8 mb-3">
                            <label class="field-label">Images <span class="required-star">*</span></label>
                            <div class="variant-image-upload-area" onclick="document.getElementById('variant_images_input_${variantId}').click()">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p>Click to upload variant images</p>
                            </div>
                            <input type="file" id="variant_images_input_${variantId}" name="variants[${variantId}][images][]" class="form-control mt-1" accept="image/*" multiple style="display:none;" onchange="previewVariantImages(this, '${variantId}')">
                            <div id="variant_images_preview_${variantId}" class="variant-image-preview-container"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="field-label">Sizes <span class="required-star">*</span></label>
                        <div id="sizesContainer_${variantId}" class="sizes-container">
                            <div class="size-row">
                                <div class="form-group">
                                    <label>Size</label>
                                    <input type="text" name="variants[${variantId}][sizes][0][size]" class="form-control variant-required" placeholder="S, M, L, XL">
                                </div>
                                <div class="form-group">
                                    <label>Cost Price</label>
                                    <input type="number" step="0.01" name="variants[${variantId}][sizes][0][cost_price]" class="form-control" placeholder="0" min="0" oninput="calculateSizePrice(this, '${variantId}', 0)">
                                </div>
                                <div class="form-group">
                                    <label>MRP</label>
                                    <input type="number" step="0.01" name="variants[${variantId}][sizes][0][mrp]" class="form-control variant-required" placeholder="0" min="0" oninput="calculateSizePrice(this, '${variantId}', 0)">
                                </div>
                                <div class="form-group" style="min-width:55px;">
                                    <label>Stock</label>
                                    <input type="number" name="variants[${variantId}][sizes][0][stock]" class="form-control variant-stock" placeholder="0" min="0" oninput="updateAllStocks()" onchange="updateAllStocks()">
                                </div>
                                <div class="form-group" style="min-width:65px;">
                                    <label>Disc Type</label>
                                    <select name="variants[${variantId}][sizes][0][discount_type]" class="form-control" onchange="calculateSizePrice(this, '${variantId}', 0)">
                                        <option value="flat">Flat</option>
                                        <option value="percentage">%</option>
                                    </select>
                                </div>
                                <div class="form-group" style="min-width:60px;">
                                    <label>Disc Value</label>
                                    <input type="number" step="0.01" name="variants[${variantId}][sizes][0][discount_value]" class="form-control" placeholder="0" min="0" oninput="calculateSizePrice(this, '${variantId}', 0)">
                                </div>
                                <span class="size-calculation" id="sizeCalc_${variantId}_0">GST: ₹0 | Total: ₹0 | Final: ₹0</span>
                                <span class="remove-size" onclick="removeSize(this, '${variantId}')">✕</span>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-secondary mt-2 add-size-btn" data-variant="${variantId}">
                            <i class="fas fa-plus"></i> Add Size
                        </button>
                    </div>
                    <div class="variant-total-stock">
                        <span class="label"><i class="fas fa-cubes"></i> Variant Total Stock</span>
                        <span class="value" id="totalVariantStock_${variantId}">0</span>
                    </div>
                </div>
            `;
            $('#additionalVariants').append(newVariant);
            if (isVariantMode) {
                $('#variant-' + variantId).find('.variant-required').prop('required', true);
            }
            updateAllStocks();
        });

        // ============================================================
        // REMOVE VARIANT
        // ============================================================
        window.removeVariant = function(variantId) {
            var totalVariants = $('.variant-item').length;
            if (totalVariants > 1) {
                if (confirm('Remove this variant?')) {
                    var existingId = $('#variant-' + variantId).find('input[name*="[id]"]').val();
                    if (existingId) {
                        var deleted = $('#deleted_variants').val();
                        if (deleted) {
                            var deletedArray = JSON.parse(deleted);
                            deletedArray.push(existingId);
                            $('#deleted_variants').val(JSON.stringify(deletedArray));
                        } else {
                            $('#deleted_variants').val(JSON.stringify([existingId]));
                        }
                    }
                    $('#variant-' + variantId).remove();
                    updateAllStocks();
                }
            } else {
                alert('At least one variant is required!');
            }
        };

        // ============================================================
        // PRODUCT IMAGES
        // ============================================================
        window.previewImages = function(input) {
            var files = Array.from(input.files);
            var totalFiles = window.imageFiles.length + files.length;
            var existingCount = {{ isset($productImages) ? $productImages->count() : 0 }};

            if ((existingCount + totalFiles) > 4) {
                alert('Maximum 4 images total. You have ' + existingCount + ' existing images.');
                input.value = '';
                return;
            }

            window.imageFiles = window.imageFiles.concat(files);
            updateImagePreview();
        };

        function updateImagePreview() {
            var preview = $('#images_preview');
            preview.empty();

            if (!window.imageFiles || window.imageFiles.length === 0) return;

            window.imageFiles.forEach(function(file, index) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    preview.append(
                        '<div class="image-preview-item">' +
                        '<img src="' + e.target.result + '">' +
                        '<button type="button" class="remove-img" onclick="removeNewImage(' + index +
                        ')">×</button>' +
                        '<span class="badge bg-secondary d-block text-center" style="font-size:9px; width:100%; text-align:center; display:block; padding:1px 0; margin-top:2px;">New</span>' +
                        '</div>'
                    );
                };
                reader.readAsDataURL(file);
            });
        }

        window.removeNewImage = function(index) {
            window.imageFiles.splice(index, 1);
            updateImagePreview();

            var dataTransfer = new DataTransfer();
            for (var i = 0; i < window.imageFiles.length; i++) {
                dataTransfer.items.add(window.imageFiles[i]);
            }
            document.getElementById('product_images_input').files = dataTransfer.files;
        };

        window.removeExistingImage = function(imageId) {
            if (confirm('Remove this image?')) {
                var deleted = $('#deleted_images').val();
                var deletedArray = deleted ? JSON.parse(deleted) : [];
                deletedArray.push(imageId);
                $('#deleted_images').val(JSON.stringify(deletedArray));
                $('#existing-image-' + imageId).hide();
            }
        };

        // ============================================================
        // CATEGORY CHANGE
        // ============================================================
        $('#category').on('change', function() {
            var categoryId = $(this).val();
            var subCategorySelect = $('#sub_category');

            subCategorySelect.empty().append('<option value="">-- Select --</option>');

            if (categoryId) {
                $.ajax({
                    url: '/admin/get-subcategories/' + categoryId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data.length > 0) {
                            $.each(data, function(i, sub) {
                                subCategorySelect.append('<option value="' + sub.id + '">' + sub
                                    .name + '</option>');
                            });
                        }
                    }
                });
            }
        });

        // ============================================================
        // TOP CATEGORY CHANGE
        // ============================================================
        $('#top_category').on('change', function() {
            var topCategoryId = $(this).val();
            var selectedOption = $(this).find('option:selected');
            var dataGst = parseFloat(selectedOption.data('gst')) || 0;

            if (topCategoryId) {
                $.get('/admin/get-categories/' + topCategoryId, function(data) {
                    var categorySelect = $('#category');
                    categorySelect.empty().append('<option value="">-- Select --</option>');
                    $.each(data, function(i, cat) {
                        categorySelect.append('<option value="' + cat.id + '">' + cat.name +
                            '</option>');
                    });
                });

                $('#gst_badge').show().html('<i class="fas fa-spinner fa-spin"></i>');

                $.ajax({
                    url: '/admin/get-gst-rate/' + topCategoryId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success && response.gst_rate > 0) {
                            currentGstRate = response.gst_rate;
                            updateGstInfo(response.gst_rate);
                            $('#gst_badge').html('<i class="fas fa-check-circle"></i> GST: ' +
                                response.gst_rate + '%').show();
                            $('#gst_selected_info').text('GST: ' + response.gst_rate +
                                '% (from ' + selectedOption.text().trim() + ')');
                            updateVariantGst();
                        } else if (dataGst === 0) {
                            $('#gst_badge').html('<i class="fas fa-exclamation-circle"></i> No GST set')
                                .show();
                            currentGstRate = 0;
                            updateGstInfo(0);
                            updateVariantGst();
                        }
                        calculateAll();
                    },
                    error: function() {
                        if (dataGst > 0) {
                            currentGstRate = dataGst;
                            updateGstInfo(dataGst);
                            $('#gst_badge').html('<i class="fas fa-check-circle"></i> GST: ' + dataGst +
                                '%').show();
                            updateVariantGst();
                        } else {
                            currentGstRate = 0;
                            updateGstInfo(0);
                            $('#gst_badge').html('<i class="fas fa-exclamation-triangle"></i> Error')
                                .show();
                            updateVariantGst();
                        }
                        calculateAll();
                    }
                });
            } else {
                $('#gst_badge').hide();
                $('#gst_selected_info').text('Select top category to auto-fill GST');
                currentGstRate = 0;
                updateGstInfo(0);
                updateVariantGst();
                calculateAll();
            }
        });

        function updateGstInfo(gstRate) {
            var gstBox = $('#gst_info_box');
            if (gstRate > 0) {
                gstBox.show();
                $('#gst_rate_display').text(gstRate + '%');
            } else {
                gstBox.hide();
                $('#gst_rate_display').text('0%');
            }
            calculateAll();
        }

        // ============================================================
        // CALCULATE ALL
        // ============================================================
        function calculateAll() {
            var sellingPrice = parseFloat($('#mrp').val()) || 0;
            var discountType = $('input[name="discount_type"]:checked').val();
            var discountValue = parseFloat($('#discount_value').val()) || 0;
            var gstRate = currentGstRate || 0;

            var gstAmount = (sellingPrice * gstRate) / 100;
            var totalPrice = sellingPrice + gstAmount;

           var discountAmount = 0;

if (discountType === 'flat') {
    discountAmount = discountValue;
    $('#discount_value_hint').text('Enter flat discount amount (₹)');
} else {
    discountAmount = (totalPrice * discountValue) / 100;
        discountAmount = Math.round(discountAmount);




    $('#discount_value_hint').text('Enter percentage discount (%)');
}

var finalPrice = totalPrice - discountAmount;
if (finalPrice < 0) finalPrice = 0;

            $('#gst_amount_field').val(gstAmount.toFixed(2));
            $('#total_price_display').val(totalPrice.toFixed(2));
            $('#discount_amount_display').val(discountAmount.toFixed(2));
            $('#final_price').val(finalPrice.toFixed(2));

            $('#hidden_gst_percentage').val(gstRate);
            $('#hidden_gst_amount').val(gstAmount.toFixed(2));
            $('#hidden_total_price').val(totalPrice.toFixed(2));
            $('#hidden_discount_amount').val(discountAmount.toFixed(2));
            $('#hidden_discount_value').val(discountValue);
            $('#hidden_discount_type').val(discountType);
            $('#hidden_final_price').val(finalPrice.toFixed(2));

            $('#flow_selling').text('₹' + sellingPrice.toFixed(0));
            $('#flow_gst').text('₹' + gstAmount.toFixed(0));
            $('#flow_total_price').text('₹' + totalPrice.toFixed(0));
            $('#flow_discount').text('₹' + discountAmount.toFixed(0));
            $('#flow_final').text('₹' + finalPrice.toFixed(0));

            var savedAmount = sellingPrice - finalPrice;
            if (savedAmount < 0) savedAmount = 0;
            $('#saved_amount').text('₹' + savedAmount.toFixed(2));

            var discountPercent = 0;
            if (sellingPrice > 0 && finalPrice > 0) {
                discountPercent = ((sellingPrice - finalPrice) / sellingPrice) * 100;
            }
            if (discountPercent < 0) discountPercent = 0;
            $('#discount_percent_info').text(discountPercent.toFixed(1) + '% off');

            $('#final_total_display').text('₹' + finalPrice.toFixed(2));

            if (gstRate > 0) {
                $('#gst_amount_display').text('₹' + gstAmount.toFixed(2));
            } else {
                $('#gst_amount_display').text('₹0.00');
            }
        }

        // ============================================================
        // PRICE EVENTS
        // ============================================================
        $('input[name="discount_type"]').on('change', function() {
            var discountType = $(this).val();
            if (discountType === 'flat') {
                $('#discount_value').attr('placeholder', 'Enter flat amount');
                $('#discount_value_hint').text('Enter flat discount amount (₹)');
            } else {
                $('#discount_value').attr('placeholder', 'Enter percentage');
                $('#discount_value_hint').text('Enter percentage discount (%)');
            }
            calculateAll();
        });

        $('#mrp, #discount_value').on('input', function() {
            calculateAll();
        });

        // ============================================================
        // COD TOGGLE
        // ============================================================
        $('#cod_toggle').on('change', function() {
            var isChecked = $(this).is(':checked');
            var statusSpan = $('#cod_status');
            if (isChecked) {
                statusSpan.text('Available').removeClass('inactive').addClass('active');
            } else {
                statusSpan.text('Not Available').removeClass('active').addClass('inactive');
            }
        });

        // ============================================================
        // DESCRIPTION PREVIEW
        // ============================================================
        function previewDescription() {
            var description = $('#description').val();
            var previewDiv = $('#descriptionPreview');
            var contentDiv = $('#descriptionPreviewContent');

            if (description.trim() !== '') {
                previewDiv.show();
                var lines = description.split('\n');
                var inList = false;
                var html = [];
                for (var i = 0; i < lines.length; i++) {
                    var line = lines[i].trim();
                    if (line.match(/^[•\-*]\s/)) {
                        if (!inList) {
                            html.push('<ul class="mb-1" style="padding-left:18px;">');
                            inList = true;
                        }
                        html.push('<li>' + line.replace(/^[•\-*]\s/, '') + '</li>');
                    } else {
                        if (inList) {
                            html.push('</ul>');
                            inList = false;
                        }
                        if (line !== '') html.push('<p class="mb-1">' + line + '</p>');
                    }
                }
                if (inList) html.push('</ul>');
                contentDiv.html(html.join(''));
            } else {
                previewDiv.hide();
            }
        }

        $('#description').on('input', function() {
            previewDescription();
        });

        // ============================================================
        // FORM SUBMIT
        // ============================================================
        $('#productForm').on('submit', function(e) {
            if (isVariantMode) {
                var hasError = false;

                $('.variant-item').each(function() {
                    var variantId = $(this).attr('id').replace('variant-', '');

                    var colorInput = $(this).find('input[name*="[color]"]');
                    if (colorInput.length && !colorInput.val().trim()) {
                        hasError = true;
                        colorInput.addClass('is-invalid');
                        alert('Please enter color for Variant #' + (variantId === 'default' ? 1 :
                            variantIdCounter));
                        colorInput.focus();
                        return false;
                    }

                    var sizeRows = $(this).find('.size-row');
                    if (sizeRows.length === 0) {
                        hasError = true;
                        alert('Please add at least one size for Variant #' + (variantId === 'default' ?
                            1 : variantIdCounter));
                        return false;
                    }

                    sizeRows.each(function(index) {
                        var sizeInput = $(this).find('input[name*="[size]"]');
                        var mrpInput = $(this).find('input[name*="[mrp]"]');

                        if (!sizeInput.val().trim()) {
                            hasError = true;
                            sizeInput.addClass('is-invalid');
                            alert('Please enter size for Variant #' + (variantId === 'default' ? 1 :
                                variantIdCounter));
                            sizeInput.focus();
                            return false;
                        }
                        if (!mrpInput.val() || parseFloat(mrpInput.val()) <= 0) {
                            hasError = true;
                            mrpInput.addClass('is-invalid');
                            alert('Please enter valid MRP for Variant #' + (variantId === 'default' ?
                                1 : variantIdCounter));
                            mrpInput.focus();
                            return false;
                        }
                    });

                    if (hasError) return false;
                });

                if (hasError) {
                    e.preventDefault();
                    return false;
                }

                // Set variant images
                for (var key in window.variantImageFiles) {
                    if (window.variantImageFiles[key] && window.variantImageFiles[key].length > 0) {
                        var input = document.getElementById('variant_images_input_' + key);
                        if (input) {
                            var dataTransfer = new DataTransfer();
                            window.variantImageFiles[key].forEach(function(file) {
                                dataTransfer.items.add(file);
                            });
                            input.files = dataTransfer.files;
                        }
                    }
                }
            }

            // For product images
            var dataTransfer = new DataTransfer();
            for (var i = 0; i < window.imageFiles.length; i++) {
                dataTransfer.items.add(window.imageFiles[i]);
            }
            document.getElementById('product_images_input').files = dataTransfer.files;

            return true;
        });

        // ============================================================
        // INITIAL SETUP
        // ============================================================
        @if ($product->variants && $product->variants->count() > 0)
            isVariantMode = true;
            $('#variantSection').addClass('active');
            $('#pricingSection').addClass('hidden-section');
            $('#productImagesSection').addClass('hidden-section');
            $('#productImagesTitle').addClass('hidden-section');
            $('#grandTotalStockSection').show();
            $('.variant-required').prop('required', true);
            updateAllStocks();
            updateVariantGst();
        @else
            $('#variantSection').removeClass('active');
            $('#pricingSection').removeClass('hidden-section');
            $('#productImagesSection').removeClass('hidden-section');
            $('#productImagesTitle').removeClass('hidden-section');
            $('#grandTotalStockSection').hide();
            $('.variant-required').prop('required', false);
        @endif

        calculateAll();
        updateAllStocks();
        updateVariantGst();
    });
</script>
@endsection