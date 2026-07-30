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
            --shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
            --radius: 10px;
            --radius-lg: 16px;
        }

        .admin-main-content {
            padding: 20px 25px;
            background: #f0f4f8;
            min-height: 100vh;
        }

        /* ============================================ */
        /* CUSTOM TOAST - TOP RIGHT CORNER            */
        /* ============================================ */
        .toast-container-custom {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 999999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 400px;
            width: 100%;
        }

        .toast-custom {
            background: #ffffff;
            border-radius: var(--radius-lg);
            padding: 14px 18px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: flex-start;
            gap: 10px;
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            font-size: 13px;
            border: 1px solid #e2e8f0;
            position: relative;
            border-left: 5px solid var(--success);
            animation: slideIn 0.5s ease forwards;
        }

        .toast-custom.success {
            border-left-color: #4caf50;
        }

        .toast-custom.error {
            border-left-color: #ef5350;
        }

        .toast-custom.warning {
            border-left-color: #ffa726;
        }

        .toast-custom .toast-icon {
            font-size: 18px;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .toast-custom.success .toast-icon {
            color: #4caf50;
        }

        .toast-custom.error .toast-icon {
            color: #ef5350;
        }

        .toast-custom.warning .toast-icon {
            color: #ffa726;
        }

        .toast-custom .toast-content {
            flex: 1;
        }

        .toast-custom .toast-title {
            font-weight: 700;
            font-size: 13px;
            color: #0f172a;
            margin-bottom: 1px;
        }

        .toast-custom .toast-message {
            font-size: 12px;
            color: #475569;
            font-weight: 400;
            margin: 0;
            line-height: 1.5;
        }

        .toast-custom .toast-close {
            background: none;
            border: none;
            color: #94a3b8;
            font-size: 16px;
            cursor: pointer;
            padding: 0 4px;
            transition: color 0.3s;
            flex-shrink: 0;
            margin-top: -2px;
        }

        .toast-custom .toast-close:hover {
            color: #475569;
        }

        .toast-custom .toast-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            border-radius: 0 0 var(--radius-lg) var(--radius-lg);
            animation: progressBar 3s linear forwards;
            width: 100%;
        }

        .toast-custom.success .toast-progress {
            background: #4caf50;
        }

        .toast-custom.error .toast-progress {
            background: #ef5350;
        }

        .toast-custom.warning .toast-progress {
            background: #ffa726;
        }

        .toast-custom.hide {
            animation: slideOut 0.5s ease forwards;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(100%);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideOut {
            from {
                opacity: 1;
                transform: translateX(0);
            }

            to {
                opacity: 0;
                transform: translateX(100%);
            }
        }

        @keyframes progressBar {
            0% {
                width: 100%;
            }

            100% {
                width: 0%;
            }
        }

        /* ============================================ */
        /* CUSTOM CONFIRM DIALOG - TOP RIGHT CORNER   */
        /* ============================================ */
        .confirm-dialog-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 99999;
            align-items: flex-start;
            justify-content: flex-end;
            padding: 20px 25px;
            animation: fadeIn 0.25s ease;
        }

        .confirm-dialog-overlay.active {
            display: flex;
        }

        .confirm-dialog {
            background: #ffffff;
            border-radius: var(--radius-lg);
            padding: 18px 22px 20px;
            max-width: 320px;
            width: 100%;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            animation: slideDownModal 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.04);
        }

        @keyframes slideDownModal {
            from {
                opacity: 0;
                transform: translateY(-20px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
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

        .confirm-dialog .dialog-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 6px;
        }

        .confirm-dialog .dialog-header h4 {
            font-size: 14px;
            font-weight: 600;
            color: var(--dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .confirm-dialog .dialog-header h4 i {
            color: #ffa726;
            font-size: 16px;
        }

        .confirm-dialog .dialog-close {
            background: none;
            border: none;
            font-size: 16px;
            color: var(--gray);
            cursor: pointer;
            padding: 0 4px;
            transition: all 0.3s;
            line-height: 1;
        }

        .confirm-dialog .dialog-close:hover {
            color: var(--dark);
            transform: rotate(90deg);
        }

        .confirm-dialog .dialog-body {
            font-size: 12px;
            color: var(--gray);
            line-height: 1.6;
            margin-bottom: 14px;
            padding-right: 4px;
        }

        .confirm-dialog .dialog-body .highlight {
            color: var(--dark);
            font-weight: 600;
        }

        .confirm-dialog .dialog-actions {
            display: flex;
            gap: 8px;
            justify-content: flex-end;
        }

        .confirm-dialog .dialog-actions .btn-dialog {
            padding: 6px 16px;
            border: none;
            border-radius: var(--radius);
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .confirm-dialog .dialog-actions .btn-dialog.cancel {
            background: #f0f4f8;
            color: var(--gray);
        }

        .confirm-dialog .dialog-actions .btn-dialog.cancel:hover {
            background: #e9ecef;
        }

        .confirm-dialog .dialog-actions .btn-dialog.confirm {
            background: #ef5350;
            color: #fff;
        }

        .confirm-dialog .dialog-actions .btn-dialog.confirm:hover {
            background: #c62828;
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(239, 83, 80, 0.3);
        }

        /* ============================================ */
        /* LIST CARD STYLES                            */
        /* ============================================ */
        .list-card {
            background: #ffffff;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            border: 1px solid rgba(0, 0, 0, 0.04);
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
        /* TABLE STYLES                                */
        /* ============================================ */
        .table-responsive {
            overflow-x: auto;
            border-radius: var(--radius);
            border: 1px solid var(--border-color);
        }

        .table-orders {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            margin: 0;
        }

        .table-orders thead {
            background: var(--light-gray);
        }

        .table-orders thead th {
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

        .table-orders thead th.text-center {
            text-align: center;
        }

        .table-orders tbody td {
            padding: 10px 14px;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-color);
        }

        .table-orders tbody tr:hover {
            background: #f8f9fa;
        }

        .table-orders tbody tr:last-child td {
            border-bottom: none;
        }

        .table-orders .sno {
            font-weight: 600;
            color: var(--gray);
            font-size: 12px;
            text-align: center;
            width: 45px;
        }

        .table-orders .order-id {
            font-weight: 700;
            color: var(--dark);
            font-size: 12px;
        }

        .table-orders .order-date {
            font-size: 12px;
            color: var(--gray);
        }

        .table-orders .customer-name {
            font-weight: 600;
            color: var(--dark);
        }

        .table-orders .customer-email {
            font-size: 11px;
            color: var(--gray);
            display: block;
        }

        .table-orders .items-count {
            font-size: 12px;
            color: var(--gray);
            text-align: center;
        }

        .table-orders .total-amount {
            font-weight: 700;
            color: #10b981;
            font-size: 14px;
            text-align: center;
        }

        .table-orders .shipping-charge {
            font-size: 12px;
            color: var(--gray);
            text-align: center;
        }

        .table-orders .status-badge {
            padding: 4px 14px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .table-orders .status-badge.pending {
            background: #fef3c7;
            color: #92400e;
        }

        .table-orders .status-badge.confirmed {
            background: #e3f2fd;
            color: #1565c0;
        }

        .table-orders .status-badge.shipped {
            background: #e0f7fa;
            color: #00838f;
        }

        .table-orders .status-badge.delivered {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .table-orders .status-badge.cancelled {
            background: #fce4ec;
            color: #c62828;
        }

        .table-orders .status-badge.failed {
            background: #fce4ec;
            color: #c62828;
        }

        .table-orders .status-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
        }

        .table-orders .status-badge.pending .dot {
            background: #ffa726;
        }

        .table-orders .status-badge.confirmed .dot {
            background: #4a9eff;
        }

        .table-orders .status-badge.shipped .dot {
            background: #00bcd4;
        }

        .table-orders .status-badge.delivered .dot {
            background: #4caf50;
        }

        .table-orders .status-badge.cancelled .dot {
            background: #ef5350;
        }

        .table-orders .status-badge.failed .dot {
            background: #ef5350;
        }

        .table-orders .payment-badge {
            padding: 4px 14px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .table-orders .payment-badge.success {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .table-orders .payment-badge.failed {
            background: #fce4ec;
            color: #c62828;
        }

        .table-orders .payment-badge.pending {
            background: #fef3c7;
            color: #92400e;
        }

        .table-orders .payment-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
        }

        .table-orders .payment-badge.success .dot {
            background: #4caf50;
        }

        .table-orders .payment-badge.failed .dot {
            background: #ef5350;
        }

        .table-orders .payment-badge.pending .dot {
            background: #ffa726;
        }

        .action-btns {
            display: flex;
            gap: 4px;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
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
            background: rgba(74, 158, 255, 0.1);
            color: #4a9eff;
        }

        .action-btns .btn-action.view:hover {
            background: #4a9eff;
            color: #fff;
            transform: scale(1.1);
        }

        .status-dropdown-btn {
            background: linear-gradient(135deg, #4a9eff, #6c5ce7);
            color: #fff;
            border: none;
            padding: 4px 14px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 500;
            cursor: pointer;
            min-width: 80px;
            transition: all 0.3s;
            height: 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
        }

        .status-dropdown-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(74, 158, 255, 0.35);
        }

        .dropdown-menu {
            min-width: 150px;
            border-radius: var(--radius);
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow);
            padding: 4px 0;
        }

        .dropdown-item.status-opt {
            cursor: pointer;
            transition: all 0.2s;
            font-size: 12px;
            padding: 6px 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .dropdown-item.status-opt:hover {
            background-color: #f0f4f8;
        }

        .dropdown-item.status-opt i {
            width: 20px;
        }

        /* ============================================ */
        /* ORDER DETAILS MODAL                        */
        /* ============================================ */
        .order-details-modal .modal-dialog {
            max-width: 800px;
        }

        .order-details-modal .modal-content {
            border-radius: var(--radius-lg);
            overflow: hidden;
            border: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        }

        .order-header {
            background: linear-gradient(135deg, #0d1b2a 0%, #1b3a5c 100%);
            color: #fff;
            padding: 20px 24px;
            position: relative;
        }

        .order-header h3 {
            margin: 0;
            font-size: 20px;
            font-weight: 600;
        }

        .order-header h5 {
            margin: 4px 0 0 0;
            opacity: 0.8;
            font-weight: 400;
            font-size: 14px;
        }

        .order-status-badge {
            position: absolute;
            top: 20px;
            right: 24px;
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
        }

        .order-status-badge.Pending {
            background: #fef3c7;
            color: #92400e;
        }

        .order-status-badge.Confirmed {
            background: #e3f2fd;
            color: #1565c0;
        }

        .order-status-badge.Shipped {
            background: #e0f7fa;
            color: #00838f;
        }

        .order-status-badge.Delivered {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .order-status-badge.Cancelled {
            background: #fce4ec;
            color: #c62828;
        }

        .order-status-badge.Failed {
            background: #fce4ec;
            color: #c62828;
        }

        .detail-section {
            padding: 18px 24px;
            border-bottom: 1px solid #f0f0f0;
        }

        .detail-section:last-child {
            border-bottom: none;
        }

        .section-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title i {
            color: var(--primary);
        }

        .info-row {
            display: flex;
            margin-bottom: 6px;
            font-size: 13px;
        }

        .info-label {
            width: 120px;
            font-weight: 600;
            color: var(--gray);
            flex-shrink: 0;
        }

        .info-value {
            flex: 1;
            color: var(--dark);
        }

        .address-card {
            background: var(--light-gray);
            padding: 12px 16px;
            border-radius: var(--radius);
            font-size: 13px;
            line-height: 1.8;
        }

        .order-item {
            display: flex;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .order-item-image {
            width: 60px;
            height: 60px;
            background: var(--light-gray);
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }

        .order-item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .order-item-details {
            flex: 1;
        }

        .order-item-name {
            font-weight: 600;
            color: var(--dark);
            font-size: 13px;
        }

        .order-item-price {
            color: var(--primary);
            font-weight: 600;
            font-size: 13px;
        }

        .order-item-quantity {
            color: var(--gray);
            font-size: 12px;
        }

        .order-item-total {
            text-align: right;
            font-weight: 700;
            color: var(--dark);
            font-size: 13px;
            padding-top: 4px;
        }

        .payment-method-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 14px;
            border-radius: 50px;
            background: var(--light-gray);
            font-size: 12px;
        }

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
        /* RESPONSIVE                                  */
        /* ============================================ */
        @media (max-width: 768px) {
            .admin-main-content {
                padding: 12px 15px;
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

            .table-orders thead th {
                font-size: 10px;
                padding: 6px 8px;
            }

            .table-orders tbody td {
                padding: 6px 8px;
                font-size: 11px;
            }

            .pagination-wrapper {
                flex-direction: column;
                align-items: center;
            }

            .pagination-wrapper .pagination-info {
                font-size: 12px;
            }

            .pagination-wrapper .pagination-links .page-item a,
            .pagination-wrapper .pagination-links .page-item span {
                padding: 4px 10px;
                font-size: 12px;
                min-width: 30px;
            }

            .order-header {
                padding: 16px 18px;
            }

            .order-header h3 {
                font-size: 17px;
            }

            .order-status-badge {
                position: relative;
                top: auto;
                right: auto;
                margin-top: 8px;
                display: inline-block;
            }

            .detail-section {
                padding: 14px 16px;
            }

            .info-row {
                flex-direction: column;
            }

            .info-label {
                width: 100%;
            }

            .order-item {
                flex-wrap: wrap;
            }

            .order-item-total {
                width: 100%;
                text-align: left;
                padding-left: 72px;
            }

            .order-details-modal .modal-dialog {
                margin: 10px;
            }

            .table-orders .sno {
                width: 35px;
                font-size: 10px;
            }

            .action-btns .btn-action {
                width: 28px;
                height: 28px;
                font-size: 10px;
            }

            .status-dropdown-btn {
                font-size: 10px;
                padding: 3px 10px;
                min-width: 70px;
                height: 26px;
            }

            .table-orders .status-badge,
            .table-orders .payment-badge {
                font-size: 9px;
                padding: 2px 8px;
            }

            .table-orders .total-amount {
                font-size: 12px;
            }

            .order-item-image {
                width: 48px;
                height: 48px;
            }

            .order-item-name {
                font-size: 12px;
            }

            .toast-container-custom {
                top: 15px;
                right: 15px;
                max-width: calc(100% - 30px);
            }

            .toast-custom {
                padding: 12px 14px;
                font-size: 12px;
            }

            .confirm-dialog {
                max-width: 280px;
                padding: 16px 18px 18px;
            }

            .confirm-dialog .dialog-header h4 {
                font-size: 13px;
            }

            .confirm-dialog .dialog-body {
                font-size: 11px;
            }

            .confirm-dialog .dialog-actions .btn-dialog {
                padding: 5px 12px;
                font-size: 11px;
            }

            .confirm-dialog-overlay {
                padding: 15px;
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

            .table-orders tbody td {
                padding: 4px 6px;
                font-size: 10px;
            }

            .table-orders thead th {
                padding: 4px 6px;
                font-size: 9px;
            }

            .action-btns .btn-action {
                width: 24px;
                height: 24px;
                font-size: 9px;
            }

            .table-orders .sno {
                width: 30px;
                font-size: 9px;
            }

            .status-dropdown-btn {
                font-size: 9px;
                padding: 2px 8px;
                min-width: 60px;
                height: 22px;
            }

            .table-orders .status-badge,
            .table-orders .payment-badge {
                font-size: 8px;
                padding: 2px 6px;
            }

            .table-orders .total-amount {
                font-size: 11px;
            }

            .order-item-image {
                width: 40px;
                height: 40px;
            }

            .order-item-name {
                font-size: 11px;
            }

            .order-item-price {
                font-size: 11px;
            }

            .toast-container-custom {
                top: 10px;
                right: 10px;
                max-width: calc(100% - 20px);
            }

            .toast-custom {
                padding: 10px 12px;
                font-size: 12px;
            }

            .toast-custom .toast-title {
                font-size: 12px;
            }

            .toast-custom .toast-message {
                font-size: 11px;
            }

            .confirm-dialog {
                max-width: 260px;
                padding: 14px 14px 16px;
            }

            .confirm-dialog .dialog-header h4 {
                font-size: 12px;
            }

            .confirm-dialog .dialog-body {
                font-size: 11px;
                margin-bottom: 12px;
            }

            .confirm-dialog .dialog-actions .btn-dialog {
                padding: 4px 10px;
                font-size: 10px;
            }

            .confirm-dialog-overlay {
                padding: 10px;
            }
        }
    </style>

    <!-- ========================================== -->
    <!-- TOAST CONTAINER - TOP RIGHT CORNER        -->
    <!-- ========================================== -->
    <div class="toast-container-custom" id="toastContainer">
        @if (session('success'))
            <div class="toast-custom success" id="customToast">
                <i class="fas fa-check-circle toast-icon"></i>
                <div class="toast-content">
                    <div class="toast-title">Success!</div>
                    <p class="toast-message">{{ session('success') }}</p>
                </div>
                <button class="toast-close" onclick="closeToast(this)">&times;</button>
                <div class="toast-progress"></div>
            </div>
        @endif

        @if (session('error'))
            <div class="toast-custom error" id="customToast">
                <i class="fas fa-exclamation-circle toast-icon"></i>
                <div class="toast-content">
                    <div class="toast-title">Error!</div>
                    <p class="toast-message">{{ session('error') }}</p>
                </div>
                <button class="toast-close" onclick="closeToast(this)">&times;</button>
                <div class="toast-progress"></div>
            </div>
        @endif
    </div>

    <!-- ========================================== -->
    <!-- CUSTOM CONFIRM DIALOG - TOP RIGHT CORNER -->
    <!-- ========================================== -->
    <div class="confirm-dialog-overlay" id="confirmDialog">
        <div class="confirm-dialog">
            <div class="dialog-header">
                <h4><i class="fas fa-exclamation-triangle"></i> Confirm Status Change</h4>
                <button class="dialog-close" onclick="closeConfirmDialog()">&times;</button>
            </div>
            <div class="dialog-body" id="confirmMessage">
                Are you sure you want to change the order status from <span class="highlight">"Status"</span> to <span
                    class="highlight">"Shipped"</span>?
            </div>
            <div class="dialog-actions">
                <button class="btn-dialog cancel" onclick="closeConfirmDialog()">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button class="btn-dialog confirm" id="confirmYesBtn">
                    <i class="fas fa-check"></i> Yes, Change
                </button>
            </div>
        </div>
    </div>

    <div class="admin-main-content">
        <div class="list-card">
            <div class="card-header">
                <div>
                    <h4><i class="fas fa-credit-card"></i> Orders & Payments Management</h4>
                    <small style="opacity:0.8;">Manage all orders and payments</small>
                </div>
                <span
                    style="background:rgba(74,158,255,0.2); color:#8ab4f8; padding:3px 12px; border-radius:50px; font-size:11px;">
                    <i class="fas fa-shopping-cart"></i> Total: {{ $orders->total() }}
                </span>
            </div>

            <div class="card-body">
                <!-- Search & Filter -->
                <div class="search-filter-section">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchInput" placeholder="Search by order number, customer name..."
                            onkeyup="applyFilters()">
                    </div>
                    <div class="filter-group">
                        <select id="paymentStatusFilter" onchange="applyFilters()">
                            <option value="">All Payment</option>
                            <option value="SUCCESS" {{ request('payment_status') == 'SUCCESS' ? 'selected' : '' }}>Paid
                            </option>
                            <option value="FAILED" {{ request('payment_status') == 'FAILED' ? 'selected' : '' }}>Failed
                            </option>
                            <option value="PENDING" {{ request('payment_status') == 'PENDING' ? 'selected' : '' }}>Pending
                            </option>
                        </select>
                        <select id="orderStatusFilter" onchange="applyFilters()">
                            <option value="">All Order Status</option>
                            <option value="Pending" {{ request('order_status') == 'Pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="Confirmed" {{ request('order_status') == 'Confirmed' ? 'selected' : '' }}>
                                Confirmed</option>
                            <option value="Shipped" {{ request('order_status') == 'Shipped' ? 'selected' : '' }}>Shipped
                            </option>
                            <option value="Delivered" {{ request('order_status') == 'Delivered' ? 'selected' : '' }}>
                                Delivered</option>
                            <option value="Cancelled" {{ request('order_status') == 'Cancelled' ? 'selected' : '' }}>
                                Cancelled</option>
                            <option value="Failed" {{ request('order_status') == 'Failed' ? 'selected' : '' }}>Failed
                            </option>
                        </select>
                        <select id="perPageSelect" onchange="changePerPage()">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 entries</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 entries</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 entries</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 entries</option>
                        </select>
                        <button class="btn-reset" onclick="resetFilters()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table-orders" id="ordersTable">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:45px;">#</th>
                                <th style="width:100px;">Order ID</th>
                                <th style="width:130px;">Date & Time</th>
                                <th style="width:150px;">Customer</th>
                                <th class="text-center" style="width:50px;">Items</th>
                                <th class="text-center" style="width:100px;">Total</th>
                                <th class="text-center" style="width:90px;">Shipping</th>
                                <th class="text-center" style="width:110px;">Order Status</th>
                                <th class="text-center" style="width:100px;">Payment Status</th>
                                <th class="text-center" style="width:140px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @forelse($orders as $index => $order)
                                <tr id="order-row-{{ $order->id }}">
                                    <td class="text-center sno">{{ $orders->firstItem() + $index }}</td>
                                    <td><span class="order-id">#{{ $order->order_number }}</span></td>
                                    <td><span
                                            class="order-date">{{ \Carbon\Carbon::parse($order->order_date ?? $order->created_at)->format('d/m/Y h:i A') }}</span>
                                    </td>
                                    <td>
                                        <span class="customer-name">{{ $order->user->name ?? 'N/A' }}</span>
                                        <span class="customer-email">{{ $order->user->email ?? 'N/A' }}</span>
                                    </td>
                                    <td class="text-center"><span class="items-count">{{ $order->items->count() }}</span>
                                    </td>
                                    <td class="text-center"><span
                                            class="total-amount">₹{{ number_format($order->total_amount, 2) }}</span></td>
                                    <td class="text-center"><span
                                            class="shipping-charge">₹{{ number_format($order->shipping_charge ?? 0, 2) }}</span>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $statusClass = 'pending';
                                            if ($order->order_status == 'Confirmed') {
                                                $statusClass = 'confirmed';
                                            } elseif ($order->order_status == 'Shipped') {
                                                $statusClass = 'shipped';
                                            } elseif ($order->order_status == 'Delivered') {
                                                $statusClass = 'delivered';
                                            } elseif ($order->order_status == 'Cancelled') {
                                                $statusClass = 'cancelled';
                                            } elseif ($order->order_status == 'Failed') {
                                                $statusClass = 'failed';
                                            }
                                        @endphp
                                        <span class="status-badge {{ $statusClass }}"
                                            id="order-status-{{ $order->id }}">
                                            <span class="dot"></span> {{ $order->order_status }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if ($order->payment_status == 'SUCCESS')
                                            <span class="payment-badge success" id="payment-status-{{ $order->id }}">
                                                <span class="dot"></span> Paid
                                            </span>
                                        @elseif($order->payment_status == 'FAILED')
                                            <span class="payment-badge failed" id="payment-status-{{ $order->id }}">
                                                <span class="dot"></span> Failed
                                            </span>
                                        @else
                                            <span class="payment-badge pending" id="payment-status-{{ $order->id }}">
                                                <span class="dot"></span> Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-btns">
                                            <button class="btn-action view"
                                                onclick="viewOrderDetails({{ $order->id }})" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <div class="dropdown">
                                                <button class="status-dropdown-btn dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" id="status-btn-{{ $order->id }}">
                                                    <i class="fas fa-sync-alt"></i> Status
                                                </button>
                                                <ul class="dropdown-menu" id="status-menu-{{ $order->id }}">
                                                    <li><a class="dropdown-item status-opt" href="#"
                                                            data-id="{{ $order->id }}" data-status="Pending"><i
                                                                class="fas fa-clock text-warning"></i> Pending</a></li>
                                                    <li><a class="dropdown-item status-opt" href="#"
                                                            data-id="{{ $order->id }}" data-status="Confirmed"><i
                                                                class="fas fa-check-circle text-primary"></i> Confirmed</a>
                                                    </li>
                                                    <li><a class="dropdown-item status-opt" href="#"
                                                            data-id="{{ $order->id }}" data-status="Shipped"><i
                                                                class="fas fa-truck text-info"></i> Shipped</a></li>
                                                    <li><a class="dropdown-item status-opt" href="#"
                                                            data-id="{{ $order->id }}" data-status="Delivered"><i
                                                                class="fas fa-check-double text-success"></i> Delivered</a>
                                                    </li>
                                                    <li><a class="dropdown-item status-opt" href="#"
                                                            data-id="{{ $order->id }}" data-status="Cancelled"><i
                                                                class="fas fa-times-circle text-danger"></i> Cancelled</a>
                                                    </li>
                                                    <li><a class="dropdown-item status-opt" href="#"
                                                            data-id="{{ $order->id }}" data-status="Failed"><i
                                                                class="fas fa-exclamation-triangle text-danger"></i>
                                                            Failed</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10">
                                        <div class="empty-state">
                                            <i class="fas fa-shopping-cart"></i>
                                            <h5>No Orders Found</h5>
                                            <p>No orders available.</p>
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
                        Showing <strong>{{ $orders->firstItem() ?? 0 }}</strong> to
                        <strong>{{ $orders->lastItem() ?? 0 }}</strong> of <strong>{{ $orders->total() ?? 0 }}</strong>
                        entries
                    </div>
                    <div class="pagination-links">
                        {{ $orders->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- ORDER DETAILS MODAL                       -->
    <!-- ========================================== -->
    <div class="modal fade order-details-modal" id="orderDetailsModal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="order-header">
                    <h3><i class="fas fa-receipt"></i> Order Details</h3>
                    <h5 id="modalOrderNumber">#ORDER_ID</h5>
                    <span class="order-status-badge" id="modalOrderStatus">Pending</span>
                </div>
                <div class="modal-body p-0">
                    <div class="detail-section">
                        <div class="section-title"><i class="fas fa-info-circle"></i> Order Information</div>
                        <div class="info-row">
                            <span class="info-label">Order Date:</span>
                            <span class="info-value" id="modalOrderDate">-</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Transaction ID:</span>
                            <span class="info-value" id="modalTransactionId">-</span>
                        </div>
                    </div>

                    <div class="detail-section">
                        <div class="section-title"><i class="fas fa-user-circle"></i> Customer Details</div>
                        <div class="info-row">
                            <span class="info-label">Name:</span>
                            <span class="info-value" id="modalCustomerName">-</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Email:</span>
                            <span class="info-value" id="modalCustomerEmail">-</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Phone:</span>
                            <span class="info-value" id="modalCustomerPhone">-</span>
                        </div>
                    </div>

                    <div class="detail-section">
                        <div class="section-title"><i class="fas fa-receipt"></i> Order Summary</div>
                        <div class="info-row">
                            <span class="info-label">Total Amount:</span>
                            <span class="info-value" id="modalTotal">-</span>
                        </div>
                    </div>

                    <div class="detail-section">
                        <div class="section-title"><i class="fas fa-map-marker-alt"></i> Shipping Address</div>
                        <div class="address-card" id="modalShippingAddress">Loading address...</div>
                    </div>

                    <div class="detail-section">
                        <div class="section-title"><i class="fas fa-credit-card"></i> Payment Information</div>
                        <div class="info-row">
                            <span class="info-label">Method:</span>
                            <span class="info-value" id="modalPaymentMethod">-</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Status:</span>
                            <span class="info-value" id="modalPaymentStatus">-</span>
                        </div>
                    </div>

                    <div class="detail-section">
                        <div class="section-title"><i class="fas fa-box"></i> Order Items</div>
                        <div id="modalOrderItems"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        style="background:#f0f4f8; color:var(--gray); border:1px solid var(--border-color); padding:7px 20px; border-radius:var(--radius); font-weight:500; font-size:13px; transition:all 0.3s;">
                        <i class="fas fa-times"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- SCRIPTS                                    -->
    <!-- ========================================== -->
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
            '{{ csrf_token() }}';

        // ============================================
        // TOAST FUNCTIONS
        // ============================================
        function closeToast(btn) {
            const toast = btn.closest('.toast-custom');
            if (toast) {
                toast.classList.add('hide');
                setTimeout(function() {
                    toast.remove();
                }, 500);
            }
        }

        function showToast(message, type = 'success') {
            const container = document.getElementById('toastContainer');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = 'toast-custom ' + type;

            const icon = type === 'success' ? 'fa-check-circle' : type === 'warning' ? 'fa-exclamation-triangle' :
                'fa-exclamation-circle';
            const title = type === 'success' ? 'Success!' : type === 'warning' ? 'Warning!' : 'Error!';

            toast.innerHTML = `
        <i class="fas ${icon} toast-icon"></i>
        <div class="toast-content">
            <div class="toast-title">${title}</div>
            <p class="toast-message">${message}</p>
        </div>
        <button class="toast-close" onclick="closeToast(this)">&times;</button>
        <div class="toast-progress"></div>
    `;

            container.appendChild(toast);

            setTimeout(function() {
                toast.classList.add('hide');
                setTimeout(function() {
                    toast.remove();
                }, 500);
            }, 3000);
        }

        // ============================================
        // CUSTOM CONFIRM DIALOG
        // ============================================
        var confirmCallback = null;
        var confirmOrderId = null;
        var confirmNewStatus = null;

        function showConfirmDialog(title, message, callback) {
            document.getElementById('confirmMessage').innerHTML = message;
            document.getElementById('confirmDialog').classList.add('active');
            document.body.style.overflow = 'hidden';
            confirmCallback = callback;
        }

        function closeConfirmDialog() {
            document.getElementById('confirmDialog').classList.remove('active');
            document.body.style.overflow = '';
            confirmCallback = null;
        }

        document.getElementById('confirmYesBtn').addEventListener('click', function() {
            if (confirmCallback) {
                confirmCallback();
            }
            closeConfirmDialog();
        });

        document.getElementById('confirmDialog').addEventListener('click', function(e) {
            if (e.target === this) {
                closeConfirmDialog();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeConfirmDialog();
            }
        });

        // ============================================
        // ATTACH STATUS EVENT LISTENERS
        // ============================================
        function attachStatusEventListeners() {
            document.querySelectorAll('.status-opt').forEach(function(link) {
                link.removeEventListener('click', statusClickHandler);
                link.addEventListener('click', statusClickHandler);
            });
        }

        // ============================================
        // STATUS CLICK HANDLER - WITH CUSTOM CONFIRM
        // ============================================
        function statusClickHandler(e) {
            e.preventDefault();
            e.stopPropagation();

            var orderId = this.getAttribute('data-id');
            var newStatus = this.getAttribute('data-status');
            var currentBtn = document.getElementById('status-btn-' + orderId);
            var currentStatus = currentBtn ? currentBtn.innerText.trim() : '';

            var message = 'Are you sure you want to change the order status from <span class="highlight">"' +
                currentStatus + '"</span> to <span class="highlight">"' + newStatus + '"</span>?';

            showConfirmDialog(
                'Confirm Status Change',
                message,
                function() {
                    updateOrderStatus(orderId, newStatus);
                }
            );
        }

        // ============================================
        // UPDATE ORDER STATUS
        // ============================================
        function updateOrderStatus(orderId, newStatus) {
            var dropdownBtn = document.getElementById('status-btn-' + orderId);
            var originalText = dropdownBtn.innerHTML;

            dropdownBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            dropdownBtn.disabled = true;

            fetch('/admin/payments/' + orderId + '/status', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        order_status: newStatus
                    })
                })
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    if (data.success) {
                        var statusBadge = document.getElementById('order-status-' + orderId);
                        if (statusBadge) {
                            var statusClass = 'pending';
                            if (newStatus == 'Confirmed') statusClass = 'confirmed';
                            else if (newStatus == 'Shipped') statusClass = 'shipped';
                            else if (newStatus == 'Delivered') statusClass = 'delivered';
                            else if (newStatus == 'Cancelled') statusClass = 'cancelled';
                            else if (newStatus == 'Failed') statusClass = 'failed';

                            statusBadge.className = 'status-badge ' + statusClass;
                            statusBadge.innerHTML = '<span class="dot"></span> ' + newStatus;
                        }

                        dropdownBtn.innerHTML = '<i class="fas fa-sync-alt"></i> Status';

                        if (newStatus === 'Delivered' && data.payment_status === 'SUCCESS') {
                            var paymentBadge = document.getElementById('payment-status-' + orderId);
                            if (paymentBadge) {
                                paymentBadge.className = 'payment-badge success';
                                paymentBadge.innerHTML = '<span class="dot"></span> Paid';
                            }
                        }

                        attachStatusEventListeners();
                        showToast('Order status updated successfully to "' + newStatus + '"!', 'success');
                    } else {
                        showToast(data.message || 'Error updating status', 'error');
                        dropdownBtn.innerHTML = originalText;
                    }
                })
                .catch(function(error) {
                    console.error('Error:', error);
                    showToast('Network error. Please try again.', 'error');
                    dropdownBtn.innerHTML = originalText;
                })
                .finally(function() {
                    dropdownBtn.disabled = false;
                });
        }

        // ============================================
        // VIEW ORDER DETAILS
        // ============================================
        function viewOrderDetails(orderId) {
            document.getElementById('modalShippingAddress').innerHTML =
            '<div class="address-card">Loading address...</div>';

            fetch('/admin/payments/' + orderId)
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    if (data.success) {
                        var order = data.order;

                        document.getElementById('modalOrderNumber').innerText = order.order_number;
                        document.getElementById('modalOrderStatus').innerText = order.order_status;
                        document.getElementById('modalOrderStatus').className = 'order-status-badge ' + order
                            .order_status;
                        document.getElementById('modalOrderDate').innerText = new Date(order.order_date || order
                            .created_at).toLocaleString();
                        document.getElementById('modalTransactionId').innerText = order.transaction_id || 'N/A';
                        document.getElementById('modalCustomerName').innerText = order.user?.name || 'N/A';
                        document.getElementById('modalCustomerEmail').innerText = order.user?.email || 'N/A';
                        document.getElementById('modalCustomerPhone').innerText = order.user?.phone || 'N/A';
                        document.getElementById('modalTotal').innerText = '₹' + parseFloat(order.total_amount).toFixed(
                            2);

                        var paymentMethod = order.payment_method || 'N/A';
                        document.getElementById('modalPaymentMethod').innerHTML =
                            '<span class="payment-method-badge"><i class="fas fa-credit-card"></i> ' + paymentMethod +
                            '</span>';

                        var paymentStatus = order.payment_status || 'PENDING';
                        var statusHtml = '';
                        if (paymentStatus === 'SUCCESS') {
                            statusHtml = '<span class="payment-badge success"><span class="dot"></span> Paid</span>';
                        } else if (paymentStatus === 'FAILED') {
                            statusHtml = '<span class="payment-badge failed"><span class="dot"></span> Failed</span>';
                        } else {
                            statusHtml = '<span class="payment-badge pending"><span class="dot"></span> Pending</span>';
                        }
                        document.getElementById('modalPaymentStatus').innerHTML = statusHtml;

                        var itemsHtml = '';
                        if (order.items && order.items.length > 0) {
                            for (var i = 0; i < order.items.length; i++) {
                                var item = order.items[i];
                                itemsHtml += '<div class="order-item">' +
                                    '<div class="order-item-image">' +
                                    (item.product_image ? '<img src="/storage/' + item.product_image + '" alt="' + item
                                        .product_name + '">' : '<i class="fas fa-tshirt fa-2x text-muted"></i>') +
                                    '</div>' +
                                    '<div class="order-item-details">' +
                                    '<div class="order-item-name">' + (item.product_name || 'Product') + '</div>' +
                                    '<div class="order-item-price">₹' + parseFloat(item.price).toFixed(2) + '</div>' +
                                    '<div class="order-item-quantity">Quantity: ' + item.quantity + '</div>' +
                                    '</div>' +
                                    '<div class="order-item-total">₹' + parseFloat(item.price * item.quantity).toFixed(
                                        2) + '</div>' +
                                    '</div>';
                            }
                        } else {
                            itemsHtml = '<div class="text-muted">No items found</div>';
                        }
                        document.getElementById('modalOrderItems').innerHTML = itemsHtml;

                        var addressHtml = '<div class="address-card">No address information available</div>';
                        if (order.shipping_address) {
                            var addr = order.shipping_address;
                            var addressParts = [];

                            if (addr.name && addr.name !== 'N/A' && addr.name !== '') {
                                addressParts.push('<strong>' + escapeHtml(addr.name) + '</strong>');
                            }
                            if (addr.address && addr.address !== '') {
                                addressParts.push(escapeHtml(addr.address));
                            }
                            if (addr.area && addr.area !== '') {
                                addressParts.push(escapeHtml(addr.area));
                            }
                            if (addr.city && addr.city !== '' && addr.state && addr.state !== '') {
                                addressParts.push(escapeHtml(addr.city) + ', ' + escapeHtml(addr.state));
                            } else if (addr.city && addr.city !== '') {
                                addressParts.push(escapeHtml(addr.city));
                            } else if (addr.state && addr.state !== '') {
                                addressParts.push(escapeHtml(addr.state));
                            }
                            if (addr.pincode && addr.pincode !== '') {
                                addressParts.push('Pincode: ' + escapeHtml(addr.pincode));
                            }
                            if (addr.phone && addr.phone !== 'N/A' && addr.phone !== '') {
                                addressParts.push('Phone: ' + escapeHtml(addr.phone));
                            }

                            if (addressParts.length > 0) {
                                addressHtml = '<div class="address-card">' + addressParts.join('<br>') + '</div>';
                            }
                        }
                        document.getElementById('modalShippingAddress').innerHTML = addressHtml;

                        var modal = new bootstrap.Modal(document.getElementById('orderDetailsModal'));
                        modal.show();
                    } else {
                        showToast('Error loading order details: ' + (data.message || 'Unknown error'), 'error');
                    }
                })
                .catch(function(error) {
                    console.error('Error:', error);
                    document.getElementById('modalShippingAddress').innerHTML =
                        '<div class="address-card">Error loading address</div>';
                    showToast('Error loading order details', 'error');
                });
        }

        // ============================================
        // ESCAPE HTML
        // ============================================
        function escapeHtml(text) {
            if (!text) return '';
            var div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // ============================================
        // APPLY FILTERS
        // ============================================
        function applyFilters() {
            var search = document.getElementById('searchInput').value;
            var paymentStatus = document.getElementById('paymentStatusFilter').value;
            var orderStatus = document.getElementById('orderStatusFilter').value;
            var perPage = document.getElementById('perPageSelect').value;

            var url = new URL(window.location.href);
            url.searchParams.set('search', search);
            url.searchParams.set('payment_status', paymentStatus);
            url.searchParams.set('order_status', orderStatus);
            url.searchParams.set('per_page', perPage);
            url.searchParams.set('page', 1);
            window.location.href = url.toString();
        }

        function resetFilters() {
            var url = new URL(window.location.href);
            url.searchParams.delete('search');
            url.searchParams.delete('payment_status');
            url.searchParams.delete('order_status');
            url.searchParams.delete('per_page');
            url.searchParams.set('page', 1);
            window.location.href = url.toString();
        }

        function changePerPage() {
            var perPage = document.getElementById('perPageSelect').value;
            var url = new URL(window.location.href);
            url.searchParams.set('per_page', perPage);
            url.searchParams.set('page', 1);
            window.location.href = url.toString();
        }

        // ============================================
        // AUTO HIDE TOAST ON PAGE LOAD
        // ============================================
        document.addEventListener('DOMContentLoaded', function() {
            var toasts = document.querySelectorAll('.toast-custom');
            toasts.forEach(function(toast) {
                setTimeout(function() {
                    toast.classList.add('hide');
                    setTimeout(function() {
                        toast.remove();
                    }, 500);
                }, 3000);
            });

            attachStatusEventListeners();
        });
    </script>
@endsection
