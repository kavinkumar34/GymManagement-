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
    /* LIST CARD                                   */
    /* ============================================ */
    .list-card {
        background: #ffffff;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow);
        border: 1px solid rgba(0,0,0,0.04);
        overflow: hidden;
        max-width: 100%;
        margin: 0 auto;
    }

    .list-card .card-header {
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

    .list-card .card-header h4 {
        margin: 0;
        font-weight: 600;
        font-size: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .list-card .card-header h4 i {
        color: #4a9eff;
    }

    .list-card .card-header small {
        font-size: 12px;
        opacity: 0.8;
        font-weight: 400;
    }

    .list-card .card-body {
        padding: 20px 24px;
    }

    /* ============================================ */
    /* SEARCH & FILTER SECTION                    */
    /* ============================================ */
    .search-filter-section {
        background: var(--light-gray);
        border-radius: var(--radius);
        padding: 14px 16px;
        margin-bottom: 18px;
        border: 1px solid var(--border-color);
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
    }

    .search-filter-section .search-box {
        flex: 1;
        min-width: 200px;
        position: relative;
    }

    .search-filter-section .search-box i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray);
        font-size: 14px;
    }

    .search-filter-section .search-box input {
        width: 100%;
        padding: 7px 12px 7px 36px;
        border: 1px solid var(--border-color);
        border-radius: var(--radius);
        font-size: 13px;
        transition: all 0.3s;
        background: #fff;
        height: 36px;
    }

    .search-filter-section .search-box input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(74, 158, 255, 0.12);
        outline: none;
    }

    .search-filter-section .filter-group {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        align-items: center;
    }

    .search-filter-section .filter-group select {
        padding: 7px 12px;
        border: 1px solid var(--border-color);
        border-radius: var(--radius);
        font-size: 13px;
        background: #fff;
        height: 36px;
        min-width: 130px;
        transition: all 0.3s;
        color: var(--dark);
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236c757d' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        padding-right: 30px;
    }

    .search-filter-section .filter-group select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(74, 158, 255, 0.12);
        outline: none;
    }

    .search-filter-section .filter-group .btn-reset {
        padding: 7px 16px;
        background: var(--danger);
        color: #fff;
        border: none;
        border-radius: var(--radius);
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        height: 36px;
    }

    .search-filter-section .filter-group .btn-reset:hover {
        background: #c62828;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(239, 83, 80, 0.35);
    }

    /* ============================================ */
    /* CUSTOM ALERT - AUTO HIDE                    */
    /* ============================================ */
    .custom-alert {
        padding: 12px 18px;
        border-radius: var(--radius);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 13px;
        animation: slideDown 0.4s ease;
        border-left: 4px solid;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
    }

    .custom-alert.success {
        background: #e8f5e9;
        color: #2e7d32;
        border-left-color: #4caf50;
    }

    .custom-alert.error {
        background: #fce4ec;
        color: #c62828;
        border-left-color: #ef5350;
    }

    .custom-alert .alert-icon {
        font-size: 18px;
        flex-shrink: 0;
    }

    .custom-alert .alert-content {
        flex: 1;
    }

    .custom-alert .alert-content strong {
        font-weight: 600;
    }

    .custom-alert .alert-close {
        background: none;
        border: none;
        font-size: 20px;
        cursor: pointer;
        color: inherit;
        opacity: 0.5;
        padding: 0 4px;
        transition: all 0.3s;
        flex-shrink: 0;
    }

    .custom-alert .alert-close:hover {
        opacity: 1;
    }

    .custom-alert .alert-timer {
        width: 60px;
        height: 3px;
        background: rgba(0,0,0,0.1);
        border-radius: 4px;
        position: relative;
        overflow: hidden;
        flex-shrink: 0;
    }

    .custom-alert .alert-timer .timer-bar {
        height: 100%;
        border-radius: 4px;
        animation: timerShrink 3s linear forwards;
    }

    .custom-alert.success .alert-timer .timer-bar {
        background: #4caf50;
    }

    .custom-alert.error .alert-timer .timer-bar {
        background: #ef5350;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-15px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes timerShrink {
        from { width: 100%; }
        to { width: 0%; }
    }

    /* ============================================ */
    /* TABLE STYLES                                */
    /* ============================================ */
    .table-responsive {
        overflow-x: auto;
        border-radius: var(--radius);
        border: 1px solid var(--border-color);
    }

    .table-products {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        margin: 0;
    }

    .table-products thead {
        background: var(--light-gray);
    }

    .table-products thead th {
        padding: 12px 14px;
        font-weight: 600;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--dark);
        border-bottom: 2px solid var(--border-color);
        text-align: left;
        white-space: nowrap;
    }

    .table-products thead th.text-center {
        text-align: center;
    }

    .table-products tbody td {
        padding: 10px 14px;
        vertical-align: middle;
        border-bottom: 1px solid var(--border-color);
    }

    .table-products tbody tr:hover {
        background: #f8f9fa;
    }

    .table-products tbody tr:last-child td {
        border-bottom: none;
    }

    .table-products .sno {
        font-weight: 600;
        color: var(--gray);
        font-size: 12px;
        text-align: center;
        width: 40px;
    }

    .product-image-thumb {
        width: 40px;
        height: 40px;
        border-radius: var(--radius);
        object-fit: cover;
        border: 2px solid var(--border-color);
    }

    .product-placeholder {
        width: 40px;
        height: 40px;
        border-radius: var(--radius);
        background: var(--light-gray);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--gray);
        font-size: 16px;
        border: 2px solid var(--border-color);
    }

    .product-name {
        font-weight: 600;
        color: var(--dark);
    }

    .category-name {
        padding: 2px 10px;
        border-radius: 50px;
        font-size: 10px;
        font-weight: 500;
        background: #e3f2fd;
        color: #1565c0;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .status-badge {
        padding: 4px 14px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
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

    .status-badge .dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        display: inline-block;
    }

    .status-badge.active .dot {
        background: #4caf50;
    }

    .status-badge.inactive .dot {
        background: #ef5350;
    }

    .status-badge.draft .dot {
        background: #ffc107;
    }

    /* ============================================ */
    /* PRICE TAG                                   */
    /* ============================================ */
    .price-tag {
        font-weight: 600;
        color: var(--dark);
    }

    .price-tag .original {
        font-size: 12px;
        color: var(--gray);
        text-decoration: line-through;
        font-weight: 400;
        margin-left: 5px;
    }

    .price-tag .discount-tag {
        background: var(--danger);
        color: white;
        padding: 1px 8px;
        border-radius: 10px;
        font-size: 10px;
        font-weight: 600;
        margin-left: 5px;
    }

    .price-tag .variant-cost {
        font-size: 11px;
        color: var(--gray);
        font-weight: 400;
        display: block;
        margin-top: 2px;
    }

    .variant-badge {
        display: inline-block;
        background: #e8f4fd;
        color: #4a9eff;
        font-size: 10px;
        font-weight: 500;
        padding: 1px 8px;
        border-radius: 10px;
        margin-left: 4px;
    }

    /* ============================================ */
    /* ACTION BUTTONS                              */
    /* ============================================ */
    .action-btns {
        display: flex;
        gap: 4px;
        justify-content: center;
        align-items: center;
    }

    .action-btns .btn-action {
        width: 32px;
        height: 32px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        text-decoration: none;
        flex-shrink: 0;
    }

    .action-btns .btn-action.view {
        background: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
    }

    .action-btns .btn-action.view:hover {
        background: #0d6efd;
        color: #fff;
        transform: scale(1.1);
    }

    .action-btns .btn-action.edit {
        background: rgba(255, 167, 38, 0.1);
        color: #ffa726;
    }

    .action-btns .btn-action.edit:hover {
        background: #ffa726;
        color: #fff;
        transform: scale(1.1);
    }

    .action-btns .btn-action.delete {
        background: rgba(239, 83, 80, 0.1);
        color: #ef5350;
    }

    .action-btns .btn-action.delete:hover {
        background: #ef5350;
        color: #fff;
        transform: scale(1.1);
    }

    /* ============================================ */
    /* CUSTOM DELETE MODAL                         */
    /* ============================================ */
    .delete-modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.25);
        backdrop-filter: blur(2px);
        z-index: 9999;
        align-items: flex-start;
        justify-content: flex-end;
        padding: 25px 30px;
        animation: fadeIn 0.25s ease;
    }

    .delete-modal-overlay.active {
        display: flex;
    }

    .delete-modal {
        background: #ffffff;
        border-radius: var(--radius-lg);
        padding: 16px 20px 18px;
        max-width: 280px;
        width: 100%;
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        animation: slideDownModal 0.3s ease;
        border: 1px solid rgba(0,0,0,0.04);
    }

    @keyframes slideDownModal {
        from { opacity: 0; transform: translateY(-20px) scale(0.95); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .delete-modal .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 4px;
    }

    .delete-modal .modal-header h4 {
        font-size: 14px;
        font-weight: 600;
        color: var(--dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .delete-modal .modal-header h4 i {
        color: #ef5350;
        font-size: 14px;
    }

    .delete-modal .modal-close {
        background: none;
        border: none;
        font-size: 16px;
        color: var(--gray);
        cursor: pointer;
        padding: 0 4px;
        transition: all 0.3s;
        line-height: 1;
    }

    .delete-modal .modal-close:hover {
        color: var(--dark);
        transform: rotate(90deg);
    }

    .delete-modal .modal-body {
        font-size: 12px;
        color: var(--gray);
        line-height: 1.5;
        margin-bottom: 12px;
        padding-left: 2px;
    }

    .delete-modal .modal-body .warning-text {
        color: #ef5350;
        font-weight: 500;
        font-size: 11px;
        display: block;
        margin-top: 2px;
    }

    .delete-modal .modal-body .warning-text i {
        font-size: 10px;
        margin-right: 3px;
    }

    .delete-modal .modal-actions {
        display: flex;
        gap: 6px;
        justify-content: flex-end;
    }

    .delete-modal .modal-actions .btn-modal {
        padding: 5px 14px;
        border: none;
        border-radius: var(--radius);
        font-size: 11px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .delete-modal .modal-actions .btn-modal.cancel {
        background: #f0f4f8;
        color: var(--gray);
    }

    .delete-modal .modal-actions .btn-modal.cancel:hover {
        background: #e9ecef;
    }

    .delete-modal .modal-actions .btn-modal.confirm {
        background: #ef5350;
        color: #fff;
    }

    .delete-modal .modal-actions .btn-modal.confirm:hover {
        background: #c62828;
        transform: translateY(-1px);
        box-shadow: 0 3px 12px rgba(239, 83, 80, 0.3);
    }

    /* ============================================ */
    /* PAGINATION                                 */
    /* ============================================ */
    .pagination-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 16px;
        padding-top: 14px;
        border-top: 1px solid var(--border-color);
    }

    .pagination-wrapper .pagination-info {
        font-size: 13px;
        color: var(--gray);
    }

    .pagination-wrapper .pagination-info strong {
        color: var(--dark);
    }

    .pagination-wrapper .pagination-links {
        display: flex;
        gap: 4px;
    }

    .pagination-wrapper .pagination-links .page-item {
        display: inline-block;
    }

    .pagination-wrapper .pagination-links .page-item a,
    .pagination-wrapper .pagination-links .page-item span {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 13px;
        color: var(--gray);
        text-decoration: none;
        transition: all 0.3s;
        border: 1px solid transparent;
        min-width: 36px;
        text-align: center;
    }

    .pagination-wrapper .pagination-links .page-item a:hover {
        background: #f0f0f0;
        color: var(--dark);
    }

    .pagination-wrapper .pagination-links .page-item.active a,
    .pagination-wrapper .pagination-links .page-item.active span {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
    }

    .pagination-wrapper .pagination-links .page-item.disabled a,
    .pagination-wrapper .pagination-links .page-item.disabled span {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* ============================================ */
    /* EMPTY STATE                                 */
    /* ============================================ */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
    }

    .empty-state i {
        color: #dee2e6;
        font-size: 48px;
        margin-bottom: 12px;
    }

    .empty-state h5 {
        color: var(--dark);
        margin-bottom: 4px;
    }

    .empty-state p {
        color: var(--gray);
        font-size: 14px;
        margin-bottom: 12px;
    }

    /* ============================================ */
    /* VIEW MODAL STYLES                           */
    /* ============================================ */
    .modal-content {
        border-radius: 16px;
        border: none;
        box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    }

    .modal-header {
        border-bottom: 1px solid var(--border-color);
        padding: 20px 25px;
        background: var(--light-gray);
        border-radius: 16px 16px 0 0;
    }

    .modal-header .modal-title {
        font-weight: 700;
        font-size: 18px;
    }

    .modal-body {
        padding: 25px;
    }

    .modal-footer {
        border-top: 1px solid var(--border-color);
        padding: 15px 25px;
        background: var(--light-gray);
        border-radius: 0 0 16px 16px;
    }

    .product-detail-image {
        width: 100%;
        height: 320px;
        object-fit: contain;
        border-radius: 12px;
        background: var(--light-gray);
        padding: 10px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .detail-label {
        font-size: 11px;
        color: var(--gray);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-value {
        font-size: 15px;
        font-weight: 500;
        color: var(--dark);
    }

    .detail-row {
        padding: 8px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2px 20px;
    }

    .product-title {
        font-size: 22px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 5px;
    }

    .product-badges .badge {
        font-size: 12px;
        padding: 6px 12px;
    }

    .gallery-thumb {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid var(--border-color);
        cursor: pointer;
        transition: all 0.3s ease;
        background: var(--light-gray);
    }

    .gallery-thumb:hover {
        border-color: var(--primary);
        transform: scale(1.05);
        box-shadow: 0 2px 8px rgba(74, 158, 255, 0.2);
    }

    .gallery-thumb.active {
        border-color: var(--primary);
        box-shadow: 0 0 0 2px var(--primary);
    }

    .gallery-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .gallery-thumbnails {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }

    .loading-spinner {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 200px;
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
    }

    @media (max-width: 768px) {
        .admin-main-content {
            margin-left: 0 !important;
            max-width: 100% !important;
            padding: 12px 15px !important;
        }

        .list-card .card-header {
            padding: 12px 16px;
            flex-direction: column;
            align-items: flex-start;
        }

        .list-card .card-header h4 {
            font-size: 16px;
        }

        .list-card .card-body {
            padding: 14px 16px;
        }

        .search-filter-section {
            flex-direction: column;
            padding: 12px 14px;
        }

        .search-filter-section .filter-group {
            flex-direction: column;
            width: 100%;
        }

        .search-filter-section .filter-group select {
            width: 100%;
        }

        .search-filter-section .filter-group .btn-reset {
            width: 100%;
            justify-content: center;
        }

        .pagination-wrapper {
            flex-direction: column;
            align-items: center;
        }

        .action-btns .btn-action {
            width: 28px;
            height: 28px;
            font-size: 10px;
        }

        .table-products thead th {
            font-size: 10px;
            padding: 6px 8px;
        }

        .table-products tbody td {
            padding: 6px 8px;
            font-size: 11px;
        }

        .detail-grid {
            grid-template-columns: 1fr;
        }

        .product-detail-image {
            height: 250px;
        }

        .gallery-thumb {
            width: 60px;
            height: 60px;
        }

        .delete-modal-overlay {
            padding: 16px;
            align-items: flex-start;
        }

        .delete-modal {
            max-width: 260px;
            padding: 14px 16px 16px;
        }
    }

    @media (max-width: 576px) {
        .list-card .card-header h4 {
            font-size: 14px;
        }

        .list-card .card-body {
            padding: 10px 12px;
        }

        .search-filter-section .search-box input {
            font-size: 12px;
            height: 34px;
        }

        .search-filter-section .filter-group select {
            font-size: 12px;
            height: 34px;
        }

        .search-filter-section .filter-group .btn-reset {
            font-size: 12px;
            height: 34px;
        }

        .table-products tbody td {
            padding: 4px 6px;
            font-size: 10px;
        }

        .table-products thead th {
            padding: 4px 6px;
            font-size: 9px;
        }

        .action-btns .btn-action {
            width: 24px;
            height: 24px;
            font-size: 9px;
        }

        .status-badge {
            font-size: 9px;
            padding: 2px 8px;
        }

        .price-tag .original {
            font-size: 10px;
        }

        .price-tag .discount-tag {
            font-size: 8px;
            padding: 1px 6px;
        }

        .delete-modal-overlay {
            padding: 12px;
        }

        .delete-modal {
            max-width: 240px;
            padding: 12px 14px 14px;
        }

        .delete-modal .modal-header h4 {
            font-size: 12px;
        }

        .delete-modal .modal-body {
            font-size: 10px;
            margin-bottom: 10px;
        }

        .delete-modal .modal-actions .btn-modal {
            padding: 4px 10px;
            font-size: 10px;
        }
    }
</style>

<!-- ============================================ -->
<!-- MAIN CONTENT                                -->
<!-- ============================================ -->
<div class="admin-main-content">
    <div class="list-card">
        <div class="card-header">
            <div>
                <h4><i class="fas fa-box"></i> Products</h4>
                <small style="opacity:0.8;">Manage all products</small>
            </div>
            <div style="display:flex; gap:8px; flex-wrap:wrap; align-items:center;">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary" style="background:#4a9eff; color:#fff; border:none; padding:7px 16px; border-radius:10px; text-decoration:none; display:inline-flex; align-items:center; gap:6px; font-weight:500; font-size:12px; transition:all 0.3s;">
                    <i class="fas fa-plus"></i> Add Product
                </a>
                <span style="background:rgba(74,158,255,0.2); color:#8ab4f8; padding:3px 12px; border-radius:50px; font-size:11px;">
                    <i class="fas fa-tags"></i> Total: {{ $products->total() }}
                </span>
            </div>
        </div>

        <div class="card-body">
            <!-- Custom Alert -->
            @if(session('success'))
                <div class="custom-alert success" id="customAlert">
                    <span class="alert-icon"><i class="fas fa-check-circle"></i></span>
                    <span class="alert-content"><strong>Success!</strong> {{ session('success') }}</span>
                    <button class="alert-close" onclick="closeAlert()">&times;</button>
                    <div class="alert-timer"><div class="timer-bar"></div></div>
                </div>
            @endif

            @if(session('error'))
                <div class="custom-alert error" id="customAlert">
                    <span class="alert-icon"><i class="fas fa-exclamation-circle"></i></span>
                    <span class="alert-content"><strong>Error!</strong> {{ session('error') }}</span>
                    <button class="alert-close" onclick="closeAlert()">&times;</button>
                    <div class="alert-timer"><div class="timer-bar"></div></div>
                </div>
            @endif

            <!-- Search & Filter -->
            <div class="search-filter-section">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Search by name..." onkeyup="filterTable()">
                </div>
                <div class="filter-group">
                    <select id="statusFilter" onchange="filterTable()">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="draft">Draft</option>
                    </select>
                    <button class="btn-reset" onclick="resetFilters()">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table-products" id="productsTable">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:45px;">#</th>
                            <th style="width:50px;">Image</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" style="width:120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @forelse($products as $index => $product)
                        @php
                            // Get variant data for display
                            $variantFinalPrice = null;
                            $variantCostPrice = null;
                            $variantColor = null;
                            $variantSize = null;
                            $variantStock = null;
                            $variantCount = 0;
                            $totalStock = $product->stock ?? 0;
                            
                            if ($product->variants && $product->variants->count() > 0) {
                                $variantCount = $product->variants->count();
                                $totalStock = $product->variants->sum('stock');
                                
                                // Get first variant (first size, first color)
                                $firstVariant = $product->variants->first();
                                if ($firstVariant) {
                                    $variantFinalPrice = $firstVariant->final_price ?? null;
                                    $variantCostPrice = $firstVariant->cost_price ?? null;
                                    $variantColor = $firstVariant->color ?? null;
                                    $variantSize = $firstVariant->size ?? null;
                                    $variantStock = $firstVariant->stock ?? 0;
                                }
                            }
                            
                            // Determine display price
                            $displayPrice = $variantFinalPrice ?? ($product->final_price ?? $product->mrp);
                            $displayCost = $variantCostPrice ?? ($product->price ?? 0);
                            $displayMrp = $product->mrp ?? 0;
                            $hasVariants = $variantCount > 0;
                            
                            // Calculate discount if any
                            $discountPercent = 0;
                            if ($displayPrice && $displayMrp && $displayPrice < $displayMrp) {
                                $discountPercent = round((($displayMrp - $displayPrice) / $displayMrp) * 100);
                            }
                        @endphp
                        <tr>
                            <td class="text-center sno">{{ $products->firstItem() + $index }}</td>
                            <td>
                                @php
                                    $mainImage = null;
                                    if ($product->productImages && $product->productImages->count() > 0) {
                                        $mainImage = $product->productImages->where('is_main', 1)->first();
                                        if (!$mainImage) {
                                            $mainImage = $product->productImages->first();
                                        }
                                    }
                                    $imagePath = $mainImage ? $mainImage->image_path : $product->image;
                                @endphp
                                @if($imagePath)
                                    <img src="{{ asset('storage/'.$imagePath) }}" class="product-image-thumb" alt="{{ $product->name }}">
                                @else
                                    <div class="product-placeholder">
                                        <i class="fas fa-box"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <span class="product-name">{{ $product->name }}</span>
                                <br>
                                <span class="category-name">
                                    <i class="fas fa-tag"></i> {{ $product->category->name ?? 'N/A' }}
                                    @if($product->subCategory) > {{ $product->subCategory->name }} @endif
                                </span>
                                @if($hasVariants)
                                    <br>
                                    <span class="variant-badge">
                                        <i class="fas fa-palette"></i> {{ $variantCount }} variants
                                    </span>
                                    @if($variantColor)
                                        <span class="variant-badge" style="background:#f3e5f5; color:#7b1fa2;">
                                            <i class="fas fa-paint-bucket"></i> {{ $variantColor }}
                                        </span>
                                    @endif
                                    @if($variantSize)
                                        <span class="variant-badge" style="background:#e8f5e9; color:#2e7d32;">
                                            <i class="fas fa-ruler"></i> {{ $variantSize }}
                                        </span>
                                    @endif
                                @endif
                            </td>
                            <td>
                                <div class="price-tag">
                                    ₹{{ number_format($displayPrice, 2) }}
                                    @if($displayPrice && $displayMrp && $displayPrice < $displayMrp)
                                        <span class="original">₹{{ number_format($displayMrp, 2) }}</span>
                                        <span class="discount-tag">-{{ $discountPercent }}%</span>
                                    @endif
                                    @if($hasVariants && $variantCostPrice !== null)
                                        <span class="variant-cost">
                                            <i class="fas fa-tag"></i> Cost: ₹{{ number_format($variantCostPrice, 2) }}
                                        </span>
                                    @else
                                        <span class="variant-cost">
                                            <i class="fas fa-tag"></i> Cost: ₹{{ number_format($displayCost, 2) }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-{{ $totalStock > 0 ? 'success' : 'danger' }} rounded-pill px-3 py-2" style="font-size:12px;">
                                    {{ $totalStock }}
                                </span>
                                @if($hasVariants)
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-cubes"></i> {{ $variantCount }} variants
                                    </small>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="status-badge {{ strtolower($product->status) }}">
                                    <span class="dot"></span> {{ $product->status }}
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <button type="button" class="btn-action view" onclick="viewProduct({{ $product->id }})" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-action edit" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn-action delete" onclick="openDeleteModal({{ $product->id }})" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fas fa-box-open"></i>
                                    <h5>No Products Found</h5>
                                    <p><a href="{{ route('admin.products.create') }}">Create your first product!</a></p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination-wrapper">
                <div class="pagination-info">
                    Showing <strong>{{ $products->firstItem() ?? 0 }}</strong> to <strong>{{ $products->lastItem() ?? 0 }}</strong> of <strong>{{ $products->total() ?? 0 }}</strong> entries
                </div>
                <div class="pagination-links">
                    {{ $products->links() }}
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- CUSTOM DELETE MODAL                         -->
<!-- ============================================ -->
<div class="delete-modal-overlay" id="deleteModal">
    <div class="delete-modal">
        <div class="modal-header">
            <h4><i class="fas fa-trash-alt"></i> Confirm Delete</h4>
            <button class="modal-close" onclick="closeDeleteModal()">&times;</button>
        </div>
        <div class="modal-body">
            Are you sure you want to delete this product?
            <span class="warning-text"><i class="fas fa-exclamation-triangle"></i> This action cannot be undone.</span>
        </div>
        <div class="modal-actions">
            <button class="btn-modal cancel" onclick="closeDeleteModal()">
                <i class="fas fa-times"></i> Cancel
            </button>
            <button class="btn-modal confirm" id="confirmDeleteBtn">
                <i class="fas fa-trash"></i> Delete
            </button>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- DELETE FORM                                 -->
<!-- ============================================ -->
<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- ============================================ -->
<!-- VIEW PRODUCT MODAL                          -->
<!-- ============================================ -->
<div class="modal fade" id="viewProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-box me-2 text-primary"></i>
                    <span id="modalProductTitle">Product Details</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="productDetailBody">
                <div class="loading-spinner">
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Loading product details...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Close
                </button>
                <a href="#" id="editProductBtn" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i> Edit Product
                </a>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- SCRIPTS                                      -->
<!-- ============================================ -->
<script>
    // ============================================
    // DELETE MODAL FUNCTIONS
    // ============================================
    var deleteId = null;

    function openDeleteModal(id) {
        deleteId = id;
        document.getElementById('deleteModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.remove('active');
        document.body.style.overflow = '';
        deleteId = null;
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if (deleteId) {
            let form = document.getElementById('delete-form');
            form.action = '/admin/products/' + deleteId;
            form.submit();
        }
    });

    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });

    // ============================================
    // SEARCH & FILTER TABLE
    // ============================================
    function filterTable() {
        var searchValue = document.getElementById('searchInput').value.toLowerCase();
        var statusFilter = document.getElementById('statusFilter').value.toLowerCase();

        var rows = document.querySelectorAll('#tableBody tr');

        rows.forEach(function(row) {
            var text = row.textContent.toLowerCase();
            var status = row.querySelector('td:nth-child(6)')?.textContent.toLowerCase() || '';

            var matchesSearch = text.includes(searchValue);
            var matchesStatus = statusFilter === '' || status.includes(statusFilter);

            if (matchesSearch && matchesStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });

        var visibleRows = document.querySelectorAll('#tableBody tr[style*="display: none"]');
        var allRows = document.querySelectorAll('#tableBody tr');

        var noResultRow = document.querySelector('#noResultRow');
        if (noResultRow) {
            noResultRow.remove();
        }

        if (allRows.length > 0 && allRows.length === visibleRows.length) {
            var tbody = document.getElementById('tableBody');
            var tr = document.createElement('tr');
            tr.id = 'noResultRow';
            var td = document.createElement('td');
            td.colSpan = 7;
            td.style.textAlign = 'center';
            td.style.padding = '30px';
            td.style.color = '#6c757d';
            td.innerHTML = '<i class="fas fa-search" style="font-size:24px; display:block; margin-bottom:8px; color:#dee2e6;"></i> No products found matching your filters.';
            tr.appendChild(td);
            tbody.appendChild(tr);
        }
    }

    function resetFilters() {
        document.getElementById('searchInput').value = '';
        document.getElementById('statusFilter').value = '';
        filterTable();
    }

    // ============================================
    // CUSTOM ALERT - AUTO HIDE
    // ============================================
    function closeAlert() {
        var alert = document.getElementById('customAlert');
        if (alert) {
            alert.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        var alert = document.getElementById('customAlert');
        if (alert) {
            setTimeout(function() {
                alert.style.display = 'none';
            }, 3000);
        }
    });

    // ============================================
    // VIEW PRODUCT FUNCTION
    // ============================================
    function viewProduct(productId) {
        var modal = new bootstrap.Modal(document.getElementById('viewProductModal'));
        var body = document.getElementById('productDetailBody');
        var title = document.getElementById('modalProductTitle');

        body.innerHTML = `
            <div class="loading-spinner">
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Loading product details...</p>
                </div>
            </div>
        `;

        modal.show();

        fetch(`/admin/products/${productId}/details`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                var product = data.product;
                var variants = data.variants || [];
                var images = data.images || [];

                title.textContent = product.name + ' - Product Details';

                var mainImageSrc = '';
                var allImages = [];

                if (images.length > 0) {
                    images.forEach(function(img) {
                        allImages.push('/storage/' + img.image_path);
                    });
                    mainImageSrc = allImages[0];
                } else if (product.image) {
                    mainImageSrc = '/storage/' + product.image;
                    allImages = [mainImageSrc];
                } else {
                    mainImageSrc = 'https://via.placeholder.com/400x400?text=No+Image';
                    allImages = [mainImageSrc];
                }

            var galleryHtml = '';

if (variants.length > 0) {

    // ==========================================
    // VARIANT PRODUCT GALLERY
    // Group images by color / variant
    // ==========================================

    var galleryGroups = {};

    variants.forEach(function(v) {

        var groupKey = v.color || 'No Color';

        if (!galleryGroups[groupKey]) {
            galleryGroups[groupKey] = {
                color: v.color || 'N/A',
                images: []
            };
        }

        if (v.variant_images && v.variant_images.length > 0) {

            v.variant_images.forEach(function(img) {

                var imagePath = '/storage/' + img.image_path;

                // Avoid duplicate images
                if (!galleryGroups[groupKey].images.includes(imagePath)) {
                    galleryGroups[groupKey].images.push(imagePath);
                }

            });

        }

    });


    var galleryGroupList = Object.values(galleryGroups);


    galleryHtml = `
        <div class="gallery-container">

            <span class="detail-label">
                <i class="fas fa-images me-1"></i>
                Product Gallery
            </span>

            <div style="margin-top:10px;">

                ${galleryGroupList.map(function(group, groupIndex) {

                    return `
                        <div style="
                            margin-bottom:16px;
                        ">

                            <!-- VARIANT / COLOR NAME -->
                            <div style="
                                font-size:13px;
                                font-weight:600;
                                color:#495057;
                                margin-bottom:7px;
                                display:flex;
                                align-items:center;
                                gap:6px;
                            ">
                                <span style="
                                    width:8px;
                                    height:8px;
                                    background:#6c757d;
                                    border-radius:50%;
                                    display:inline-block;
                                "></span>

                                ${group.color}
                            </div>


                            <!-- VARIANT IMAGES -->
                            <div class="gallery-thumbnails">

                                ${group.images.map(function(imgSrc, imageIndex) {

                                    return `
                                        <div
                                            class="gallery-thumb ${
                                                groupIndex === 0 && imageIndex === 0
                                                    ? 'active'
                                                    : ''
                                            }"
                                            onclick="changeGalleryImage(this, '${imgSrc}')"
                                            title="${group.color} Image ${imageIndex + 1}"
                                        >

                                            <img
                                                src="${imgSrc}"
                                                alt="${group.color} Image ${imageIndex + 1}"
                                                onerror="this.parentElement.style.display='none'"
                                            >

                                        </div>
                                    `;

                                }).join('')}

                            </div>

                        </div>
                    `;

                }).join('')}

            </div>

        </div>
    `;


} else if (allImages.length > 0) {

    // ==========================================
    // NORMAL PRODUCT GALLERY
    // Existing logic - DO NOT CHANGE
    // ==========================================

    galleryHtml = `
        <div class="gallery-container">

            <span class="detail-label">
                <i class="fas fa-images me-1"></i>
                Product Gallery
            </span>

            <div class="gallery-thumbnails">

                ${allImages.map(function(imgSrc, index) {

                    return `
                        <div
                            class="gallery-thumb ${index === 0 ? 'active' : ''}"
                            onclick="changeGalleryImage(this, '${imgSrc}')"
                            title="Image ${index + 1}"
                        >

                            <img
                                src="${imgSrc}"
                                alt="Product Image ${index + 1}"
                                onerror="this.parentElement.style.display='none'"
                            >

                        </div>
                    `;

                }).join('')}

            </div>

        </div>
    `;

}

var variantsHtml = '';

if (variants.length > 0) {

    // Group sizes under same color / variant
    var groupedVariants = {};

    variants.forEach(function(v) {

        var groupKey = v.color || 'No Color';

        if (!groupedVariants[groupKey]) {
            groupedVariants[groupKey] = {
                color: v.color || 'N/A',
                variants: [],
                images: []
            };
        }

        // Keep every size as one row inside same variant card
        groupedVariants[groupKey].variants.push(v);

        // Collect unique variant images
        if (v.variant_images && v.variant_images.length > 0) {

            v.variant_images.forEach(function(img) {

                var alreadyExists =
                    groupedVariants[groupKey].images.some(function(existing) {
                        return existing.image_path === img.image_path;
                    });

                if (!alreadyExists) {
                    groupedVariants[groupKey].images.push(img);
                }

            });
        }

    });


    var variantGroups = Object.values(groupedVariants);


    // Create HTML for each variant/color group
    variantsHtml = `
        <div class="mt-4">

            <span class="detail-label">
                <i class="fas fa-palette me-1"></i>
                Variants
            </span>

            <div class="mt-2">

                ${variantGroups.map(function(group, index) {

                    var firstVariant = group.variants[0];

                    var variantImage = mainImageSrc;

                    if (group.images.length > 0) {
                        variantImage =
                            '/storage/' + group.images[0].image_path;
                    }


                    return `
                        <div style="
                            border:1px solid #e9ecef;
                            border-radius:12px;
                            padding:15px;
                            margin-bottom:18px;
                            background:#fff;
                        ">

                            <div class="row g-3">

                                <!-- VARIANT IMAGE -->
                                <div class="col-md-3">

                                    <div style="
                                        width:100%;
                                        height:180px;
                                        border:1px solid #e9ecef;
                                        border-radius:10px;
                                        overflow:hidden;
                                        background:#f8f9fa;
                                        display:flex;
                                        align-items:center;
                                        justify-content:center;
                                    ">

                                        <img
                                            src="${variantImage}"
                                            alt="Variant ${index + 1}"
                                            style="
                                                width:100%;
                                                height:100%;
                                                object-fit:contain;
                                            "
                                            onerror="
                                                this.src='https://via.placeholder.com/250x250?text=No+Image'
                                            "
                                        >

                                    </div>

                                </div>


                                <!-- VARIANT DETAILS -->
                                <div class="col-md-9">

                                    <div style="
                                        display:flex;
                                        justify-content:space-between;
                                        align-items:center;
                                        margin-bottom:12px;
                                    ">

                                        <strong style="
                                            font-size:16px;
                                            color:#1a1a2e;
                                        ">
                                            Variant ${index + 1}
                                        </strong>

                                        <span class="badge bg-secondary">
                                            Color:
                                            ${group.color}
                                        </span>

                                    </div>


                                    <!-- SIZE TABLE -->

                                    <div style="
                                        border:1px solid #e9ecef;
                                        border-radius:8px;
                                        overflow:hidden;
                                    ">

                                     <div style="
    display:grid;
    grid-template-columns:
        0.7fr
        0.8fr
        1fr
        1.2fr
        1.2fr
        1.2fr;
    gap:8px;
    background:#f8f9fa;
    padding:10px;
    font-size:11px;
    font-weight:600;
    color:#6c757d;
">

                                            <div>SIZE</div>
                                            <div>STOCK</div>
                                            <div>MRP</div>
                                            <div>DISCOUNT</div>
                                            <div>TOTAL</div>
                                            <div> PRICE</div>

                                        </div>


                                        ${group.variants.map(function(v) {

                                            var mrp =
                                                parseFloat(v.mrp || 0);

                                            var discountValue =
                                                parseFloat(
                                                    v.discount_value || 0
                                                );

                                            var discountAmount =
                                                parseFloat(
                                                    v.discount_amount || 0
                                                );

                                            var totalPrice =
                                                parseFloat(
                                                    v.total_price || 0
                                                );

                                            var finalPrice =
                                                parseFloat(
                                                    v.final_price || 0
                                                );

                                            var discountType =
                                                v.discount_type || 'flat';


                                            return `
                                              <div style="
    display:grid;
    grid-template-columns:
        0.7fr
        0.8fr
        1fr
        1.2fr
        1.2fr
        1.2fr;
    gap:8px;
    padding:10px;
    border-top:1px solid #e9ecef;
    align-items:center;
    font-size:12px;
">

                                                    <!-- SIZE -->
                                                    <div>
                                                        <strong>
                                                            ${v.size || 'N/A'}
                                                        </strong>
                                                    </div>


                                                    <!-- STOCK -->
                                                    <div>

                                                        <span class="badge bg-${
                                                            parseInt(v.stock || 0) > 0
                                                                ? 'success'
                                                                : 'danger'
                                                        }">
                                                            ${v.stock || 0}
                                                        </span>

                                                    </div>


                                                    <!-- MRP -->
                                                    <div>
                                                        ₹${mrp.toFixed(2)}
                                                    </div>


                                                    <!-- DISCOUNT -->
                                                    <div>

                                                        ${
                                                            discountType === 'percentage'
                                                            ?
                                                            discountValue + '%'
                                                            :
                                                            '₹' +
                                                            discountValue.toFixed(2)
                                                        }

                                                        <small style="
                                                            display:block;
                                                            color:#6c757d;
                                                            font-size:10px;
                                                        ">
                                                            ₹${discountAmount.toFixed(2)}
                                                        </small>

                                                    </div>


                                                    <!-- TOTAL -->
                                                    <div>
                                                        ₹${totalPrice.toFixed(2)}
                                                    </div>


                                                    <!-- FINAL PRICE -->
                                                    <div>
                                                        <strong style="
                                                            color:#28a745;
                                                        ">
                                                            ₹${finalPrice.toFixed(2)}
                                                        </strong>
                                                    </div>

                                                </div>
                                            `;

                                        }).join('')}

                                    </div>


                                    <!-- GST / OTHER DETAILS OF FIRST VARIANT -->

                                    <div class="detail-grid mt-3">

                                        <div class="detail-row">

                                            <div class="detail-label">
                                                GST Percentage
                                            </div>

                                            <div class="detail-value">
                                                ${
                                                    parseFloat(
                                                        firstVariant.gst_percentage || 0
                                                    ).toFixed(2)
                                                }%
                                            </div>

                                        </div>


                                        <div class="detail-row">

                                            <div class="detail-label">
                                                GST Amount
                                            </div>

                                            <div class="detail-value">
                                                ₹${
                                                    parseFloat(
                                                        firstVariant.gst_amount || 0
                                                    ).toFixed(2)
                                                }
                                            </div>

                                        </div>


                                        <div class="detail-row">

                                            <div class="detail-label">
                                                Variant Images
                                            </div>

                                            <div class="detail-value">
                                                ${group.images.length}
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>
                    `;

                }).join('')}

            </div>

        </div>
    `;
}

var html = `
                    <div class="row">
                        <div class="col-md-5 product-detail-left">
                            <img src="${mainImageSrc}" 
                                id="mainProductImage" 
                                class="product-detail-image" 
                                alt="${product.name}"
                                onerror="this.src='https://via.placeholder.com/400x400?text=No+Image'">
                            ${galleryHtml}
                        </div>
                        <div class="col-md-7 product-detail-right">
                            <h4 class="product-title">${product.name}</h4>
                            <div class="product-badges">
                                ${product.category_name ? '<span class="badge bg-secondary me-1">' + product.category_name + '</span>' : ''}
                                ${product.sub_category_name ? '<span class="badge bg-secondary me-1">' + product.sub_category_name + '</span>' : ''}
                                ${product.brand_name ? '<span class="badge bg-secondary">' + product.brand_name + '</span>' : ''}
                            </div>
                            ${variants.length === 0 ? `
                            <div class="mb-3">
                                <div class="price-tag" style="font-size:24px; font-weight:700; color:#28a745;">
                                    ₹${parseFloat(product.final_price || product.price).toFixed(2)}
                                    ${product.mrp && product.final_price < product.mrp ? 
                                        '<span style="font-size:16px; color:#6c757d; text-decoration:line-through; font-weight:400; margin-left:10px;">₹' + parseFloat(product.mrp).toFixed(2) + '</span>' + 
                                        '<span style="background:#dc3545; color:white; padding:2px 10px; border-radius:12px; font-size:12px; font-weight:600; margin-left:10px;">-' + Math.round(((product.mrp - product.final_price) / product.mrp) * 100) + '%</span>' 
                                        : ''}
                                </div>
                            </div>
                            <div class="detail-grid">
                                <div class="detail-row">
                                    <div class="detail-label">Cost Price</div>
                                    <div class="detail-value">₹${parseFloat(product.price).toFixed(2)}</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">MRP</div>
                                    <div class="detail-value">₹${parseFloat(product.mrp).toFixed(2)}</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Discount Type</div>
                                    <div class="detail-value">${product.discount_type || 'N/A'}</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Discount Value</div>
                                    <div class="detail-value">${product.discount_value ? product.discount_value + '%' : 'N/A'}</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Discount Amount</div>
                                    <div class="detail-value">₹${parseFloat(product.discount_amount || 0).toFixed(2)}</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">GST Percentage</div>
                                    <div class="detail-value">${product.gst_percentage || 0}%</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">GST Amount</div>
                                    <div class="detail-value">₹${parseFloat(product.gst_amount || 0).toFixed(2)}</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Total Price</div>
                                    <div class="detail-value">₹${parseFloat(product.total_price || 0).toFixed(2)}</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Final Price</div>
                                    <div class="detail-value"><strong style="color:#28a745;">₹${parseFloat(product.final_price || 0).toFixed(2)}</strong></div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Stock</div>
                                    <div class="detail-value">
                                        <span class="badge bg-${product.total_stock > 0 ? 'success' : 'danger'}">
                                            ${product.total_stock}
                                        </span>
                                    </div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Status</div>
                                    <div class="detail-value">
                                        <span class="status-badge ${(product.status || 'draft').toLowerCase()}">
                                            <span class="dot"></span> ${product.status || 'Draft'}
                                        </span>
                                    </div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">COD Available</div>
                                    <div class="detail-value">
                                        <span class="badge bg-${product.cod_available ? 'success' : 'secondary'}">
                                            ${product.cod_available ? 'Yes' : 'No'}
                                        </span>
                                    </div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Return Days</div>
                                    <div class="detail-value">${product.return_days || 'N/A'} days</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Delivery Days</div>
                                    <div class="detail-value">${product.delivery_days || 'N/A'} days</div>
                                </div>
                          </div>

` : ''}

${variantsHtml}
                            ${product.description ? `
                                <div class="mt-3">
                                    <span class="detail-label"><i class="fas fa-align-left me-1"></i> Description</span>
                                    <p class="detail-value mt-1">${product.description}</p>
                                </div>
                            ` : ''}
                        </div>
                    </div>
                `;

                body.innerHTML = html;
                window.galleryImages = allImages;
                document.getElementById('editProductBtn').href = `/admin/products/${product.id}/edit`;

            } else {
                body.innerHTML = `
                    <div class="text-center py-5">
                        <i class="fas fa-exclamation-circle fa-3x text-danger mb-3 d-block"></i>
                        <h6 class="text-danger">Error loading product details</h6>
                        <p class="text-muted">${data.message || 'Please try again later'}</p>
                    </div>
                `;
            }
        })
        .catch(error => {
            body.innerHTML = `
                <div class="text-center py-5">
                    <i class="fas fa-exclamation-circle fa-3x text-danger mb-3 d-block"></i>
                    <h6 class="text-danger">Error loading product details</h6>
                    <p class="text-muted">Please try again later</p>
                </div>
            `;
            console.error('Error:', error);
        });
    }

    // ============================================
    // GALLERY IMAGE CHANGE
    // ============================================
    function changeGalleryImage(element, imageSrc) {
        document.querySelectorAll('.gallery-thumb').forEach(function(thumb) {
            thumb.classList.remove('active');
        });
        element.classList.add('active');
        var mainImage = document.getElementById('mainProductImage');
        if (mainImage) {
            mainImage.src = imageSrc;
            mainImage.onerror = function() {
                this.src = 'https://via.placeholder.com/400x400?text=No+Image';
            };
        }
    }
</script>
@endsection