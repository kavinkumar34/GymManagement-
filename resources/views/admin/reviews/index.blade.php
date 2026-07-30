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
        /* STATUS FILTER BUTTONS                      */
        /* ============================================ */
        .status-filter-btns {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
            margin-bottom: 16px;
        }

        .status-filter-btns .btn-filter {
            padding: 6px 18px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 500;
            border: 2px solid var(--border-color);
            background: #fff;
            color: var(--gray);
            text-decoration: none;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .status-filter-btns .btn-filter:hover {
            border-color: var(--primary);
            color: var(--primary);
            transform: translateY(-2px);
        }

        .status-filter-btns .btn-filter.active {
            border-color: var(--primary);
            background: var(--primary);
            color: #fff;
        }

        .status-filter-btns .btn-filter .badge-count {
            background: rgba(0, 0, 0, 0.1);
            padding: 1px 8px;
            border-radius: 50px;
            font-size: 10px;
        }

        .status-filter-btns .btn-filter.active .badge-count {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
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
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
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
            background: rgba(0, 0, 0, 0.1);
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
            from {
                opacity: 0;
                transform: translateY(-15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes timerShrink {
            from {
                width: 100%;
            }

            to {
                width: 0%;
            }
        }

        /* ============================================ */
        /* TABLE STYLES                                */
        /* ============================================ */
        .table-responsive {
            overflow-x: auto;
            border-radius: var(--radius);
            border: 1px solid var(--border-color);
        }

        .table-reviews {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            margin: 0;
        }

        .table-reviews thead {
            background: var(--light-gray);
        }

        .table-reviews thead th {
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

        .table-reviews thead th.text-center {
            text-align: center;
        }

        .table-reviews tbody td {
            padding: 10px 14px;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-color);
        }

        .table-reviews tbody tr:hover {
            background: #f8f9fa;
        }

        .table-reviews tbody tr:last-child td {
            border-bottom: none;
        }

        .table-reviews .sno {
            font-weight: 600;
            color: var(--gray);
            font-size: 12px;
            text-align: center;
            width: 40px;
        }

        .table-reviews .product-name {
            font-weight: 600;
            color: var(--dark);
        }

        .table-reviews .user-name {
            font-weight: 500;
            color: var(--dark);
        }

        .table-reviews .user-email {
            font-size: 11px;
            color: var(--gray);
            display: block;
        }

        .table-reviews .rating-stars {
            font-size: 14px;
            letter-spacing: 1px;
            white-space: nowrap;
        }

        .table-reviews .rating-stars .star {
            color: #f59e0b;
        }

        .table-reviews .rating-stars .star-empty {
            color: #e2e8f0;
        }

        .table-reviews .review-text {
            font-size: 12px;
            color: var(--gray);
            max-width: 150px;
            display: inline-block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .table-reviews .media-badge {
            padding: 2px 10px;
            border-radius: 50px;
            font-size: 10px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .table-reviews .media-badge.images {
            background: #e3f2fd;
            color: #1565c0;
        }

        .table-reviews .media-badge.videos {
            background: #fce4ec;
            color: #c62828;
        }

        .table-reviews .media-badge.no-media {
            background: #f5f5f5;
            color: #9e9e9e;
        }

        .table-reviews .status-badge {
            padding: 4px 14px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .table-reviews .status-badge.pending {
            background: #fef3c7;
            color: #92400e;
        }

        .table-reviews .status-badge.approved {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .table-reviews .status-badge.rejected {
            background: #fce4ec;
            color: #c62828;
        }

        .table-reviews .status-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
        }

        .table-reviews .status-badge.pending .dot {
            background: #ffa726;
        }

        .table-reviews .status-badge.approved .dot {
            background: #4caf50;
        }

        .table-reviews .status-badge.rejected .dot {
            background: #ef5350;
        }

        /* ============================================ */
        /* ACTION BUTTONS                              */
        /* ============================================ */
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

        .action-btns .btn-action.approve {
            background: rgba(76, 175, 80, 0.1);
            color: #4caf50;
        }

        .action-btns .btn-action.approve:hover {
            background: #4caf50;
            color: #fff;
            transform: scale(1.1);
        }

        .action-btns .btn-action.reject {
            background: rgba(239, 83, 80, 0.1);
            color: #ef5350;
        }

        .action-btns .btn-action.reject:hover {
            background: #ef5350;
            color: #fff;
            transform: scale(1.1);
        }

        .action-btns .btn-action.delete {
            background: rgba(0, 0, 0, 0.1);
            color: #333;
        }

        .action-btns .btn-action.delete:hover {
            background: #333;
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
            background: rgba(0, 0, 0, 0.25);
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
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
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
        /* REVIEW DETAIL MODAL                         */
        /* ============================================ */
        .review-detail-modal .modal-dialog {
            max-width: 800px;
        }

        .review-detail-modal .modal-content {
            border-radius: var(--radius-lg);
            overflow: hidden;
            border: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        }

        .review-detail-modal .modal-header {
            padding: 14px 20px;
            background: linear-gradient(135deg, #0d1b2a 0%, #1b3a5c 100%);
            color: #ffffff;
            border-bottom: none;
            border-radius: var(--radius-lg) var(--radius-lg) 0 0;
        }

        .review-detail-modal .modal-header .modal-title {
            font-weight: 600;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .review-detail-modal .modal-header .modal-title i {
            color: #4a9eff;
        }

        .review-detail-modal .modal-header .btn-close {
            filter: brightness(0) invert(1);
            opacity: 0.7;
        }

        .review-detail-modal .modal-header .btn-close:hover {
            opacity: 1;
        }

        .review-detail-modal .modal-body {
            padding: 20px 24px;
        }

        .review-detail-modal .modal-footer {
            padding: 12px 20px;
            border-top: 1px solid var(--border-color);
        }

        .review-image-gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 6px;
        }

        .review-image-gallery .gallery-item {
            width: 80px;
            height: 80px;
            border-radius: var(--radius);
            overflow: hidden;
            border: 2px solid var(--border-color);
            cursor: pointer;
            transition: all 0.3s;
        }

        .review-image-gallery .gallery-item:hover {
            transform: scale(1.05);
            border-color: var(--primary);
        }

        .review-image-gallery .gallery-item img,
        .review-image-gallery .gallery-item video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .detail-row {
            display: flex;
            padding: 8px 0;
            border-bottom: 1px solid #f8f9fa;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: var(--gray);
            width: 130px;
            flex-shrink: 0;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .detail-value {
            color: var(--dark);
            flex: 1;
            font-size: 13px;
        }

        .rating-display {
            font-size: 16px;
            letter-spacing: 1px;
        }

        .rating-display .star {
            color: #f59e0b;
        }

        .rating-display .star-empty {
            color: #e2e8f0;
        }

        /* ============================================ */
        /* LIGHTBOX MODAL                              */
        /* ============================================ */
        .lightbox-modal .modal-content {
            background: rgba(0, 0, 0, 0.92);
            border-radius: 0;
            border: none;
            min-height: 100vh;
        }

        .lightbox-modal .modal-body {
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 90vh;
        }

        .lightbox-modal .btn-close {
            position: fixed;
            top: 20px;
            right: 25px;
            z-index: 10;
            filter: brightness(0) invert(1);
            opacity: 0.7;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            padding: 10px;
            width: 44px;
            height: 44px;
        }

        .lightbox-modal .btn-close:hover {
            opacity: 1;
            background: rgba(255, 255, 255, 0.2);
        }

        .lightbox-content {
            max-width: 95vw;
            max-height: 85vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .lightbox-content img,
        .lightbox-content video {
            max-width: 95vw;
            max-height: 85vh;
            border-radius: var(--radius);
            object-fit: contain;
        }

        .lightbox-content .lightbox-caption {
            color: rgba(255, 255, 255, 0.7);
            text-align: center;
            margin-top: 12px;
            font-size: 13px;
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

            .status-filter-btns {
                justify-content: center;
            }

            .status-filter-btns .btn-filter {
                font-size: 11px;
                padding: 4px 12px;
            }

            .action-btns {
                gap: 3px;
            }

            .action-btns .btn-action {
                width: 28px;
                height: 28px;
                font-size: 10px;
            }

            .table-reviews thead th {
                font-size: 10px;
                padding: 6px 8px;
            }

            .table-reviews tbody td {
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

            .delete-modal-overlay {
                padding: 16px;
                align-items: flex-start;
            }

            .delete-modal {
                max-width: 260px;
                padding: 14px 16px 16px;
            }

            .delete-modal .modal-header h4 {
                font-size: 13px;
            }

            .delete-modal .modal-body {
                font-size: 11px;
            }

            .delete-modal .modal-actions .btn-modal {
                padding: 4px 12px;
                font-size: 10px;
            }

            .review-detail-modal .modal-dialog {
                margin: 10px;
            }

            .detail-label {
                width: 100px;
                font-size: 11px;
            }

            .detail-value {
                font-size: 12px;
            }

            .review-image-gallery .gallery-item {
                width: 60px;
                height: 60px;
            }

            .lightbox-content img,
            .lightbox-content video {
                max-width: 90vw;
                max-height: 70vh;
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

            .table-reviews tbody td {
                padding: 4px 6px;
                font-size: 10px;
            }

            .table-reviews thead th {
                padding: 4px 6px;
                font-size: 9px;
            }

            .action-btns .btn-action {
                width: 24px;
                height: 24px;
                font-size: 9px;
            }

            .table-reviews .status-badge {
                font-size: 9px;
                padding: 2px 8px;
            }

            .table-reviews .media-badge {
                font-size: 9px;
                padding: 2px 8px;
            }

            .table-reviews .rating-stars {
                font-size: 11px;
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

            .review-detail-modal .modal-body {
                padding: 14px 16px;
            }

            .detail-row {
                flex-direction: column;
                padding: 6px 0;
            }

            .detail-label {
                width: 100%;
                margin-bottom: 2px;
            }

            .detail-value {
                width: 100%;
            }

            .review-image-gallery .gallery-item {
                width: 50px;
                height: 50px;
            }

            .rating-display {
                font-size: 14px;
            }

            .lightbox-content img,
            .lightbox-content video {
                max-width: 85vw;
                max-height: 60vh;
            }

            .lightbox-modal .btn-close {
                top: 10px;
                right: 15px;
                width: 36px;
                height: 36px;
                padding: 8px;
            }
        }
    </style>

    <div class="admin-main-content">
        <div class="list-card">
            <div class="card-header">
                <div>
                    <h4><i class="fas fa-star"></i> Product Reviews</h4>
                    <small style="opacity:0.8;">Manage all product reviews</small>
                </div>
                <span
                    style="background:rgba(74,158,255,0.2); color:#8ab4f8; padding:3px 12px; border-radius:50px; font-size:11px;">
                    <i class="fas fa-comments"></i> Total: {{ $reviews->total() }}
                </span>
            </div>

            <div class="card-body">
                <!-- Custom Alert -->
                @if (session('success'))
                    <div class="custom-alert success" id="customAlert">
                        <span class="alert-icon"><i class="fas fa-check-circle"></i></span>
                        <span class="alert-content"><strong>Success!</strong> {{ session('success') }}</span>
                        <button class="alert-close" onclick="closeAlert()">&times;</button>
                        <div class="alert-timer">
                            <div class="timer-bar"></div>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="custom-alert error" id="customAlert">
                        <span class="alert-icon"><i class="fas fa-exclamation-circle"></i></span>
                        <span class="alert-content"><strong>Error!</strong> {{ session('error') }}</span>
                        <button class="alert-close" onclick="closeAlert()">&times;</button>
                        <div class="alert-timer">
                            <div class="timer-bar"></div>
                        </div>
                    </div>
                @endif

                <!-- Status Filter Buttons -->
                <div class="status-filter-btns">
                    <a href="{{ route('admin.reviews.index') }}"
                        class="btn-filter {{ request()->routeIs('admin.reviews.index') ? 'active' : '' }}">
                        <i class="fas fa-list"></i> All
                        <span class="badge-count">{{ $totalCount ?? 0 }}</span>
                    </a>
                    <a href="{{ route('admin.reviews.pending') }}"
                        class="btn-filter {{ request()->routeIs('admin.reviews.pending') ? 'active' : '' }}">
                        <i class="fas fa-clock"></i> Pending
                        <span class="badge-count">{{ $pendingCount ?? 0 }}</span>
                    </a>
                    <a href="{{ route('admin.reviews.approved') }}"
                        class="btn-filter {{ request()->routeIs('admin.reviews.approved') ? 'active' : '' }}">
                        <i class="fas fa-check-circle"></i> Approved
                        <span class="badge-count">{{ $approvedCount ?? 0 }}</span>
                    </a>
                    <a href="{{ route('admin.reviews.rejected') }}"
                        class="btn-filter {{ request()->routeIs('admin.reviews.rejected') ? 'active' : '' }}">
                        <i class="fas fa-times-circle"></i> Rejected
                        <span class="badge-count">{{ $rejectedCount ?? 0 }}</span>
                    </a>
                </div>

                <!-- Search & Filter -->
                <div class="search-filter-section">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchInput" placeholder="Search by product, user, review..."
                            onkeyup="filterTable()">
                    </div>
                    <div class="filter-group">
                        <select id="ratingFilter" onchange="filterTable()">
                            <option value="">All Ratings</option>
                            <option value="5">⭐⭐⭐⭐⭐ 5</option>
                            <option value="4">⭐⭐⭐⭐ 4</option>
                            <option value="3">⭐⭐⭐ 3</option>
                            <option value="2">⭐⭐ 2</option>
                            <option value="1">⭐ 1</option>
                        </select>
                        <button class="btn-reset" onclick="resetFilters()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table-reviews" id="reviewsTable">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:45px;">#</th>
                                <th style="width:120px;">Product</th>
                                <th style="width:120px;">User</th>
                                <th class="text-center" style="width:100px;">Rating</th>
                                <th>Review</th>
                                <th class="text-center" style="width:100px;">Media</th>
                                <th class="text-center" style="width:100px;">Status</th>
                                <th class="text-center" style="width:170px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @forelse($reviews as $index => $review)
                                <tr>
                                    <td class="text-center sno">{{ $reviews->firstItem() + $index }}</td>
                                    <td><span class="product-name">{{ $review->product->name ?? 'N/A' }}</span></td>
                                    <td>
                                        <span class="user-name">{{ $review->user->name ?? 'N/A' }}</span>
                                        <span class="user-email">{{ $review->user->email ?? 'N/A' }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="rating-stars">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i
                                                    class="fas fa-star {{ $i <= $review->rating ? 'star' : 'star-empty' }}"></i>
                                            @endfor
                                        </span>
                                    </td>
                                    <td>
                                        <span class="review-text" title="{{ $review->description ?? '' }}">
                                            {{ Str::limit($review->description, 60) ?? 'No review text' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $images = is_string($review->images)
                                                ? json_decode($review->images, true)
                                                : $review->images;
                                            $videos = is_string($review->videos)
                                                ? json_decode($review->videos, true)
                                                : $review->videos;
                                            $imageCount = is_array($images) ? count($images) : 0;
                                            $videoCount = is_array($videos) ? count($videos) : 0;
                                        @endphp
                                        @if ($imageCount > 0)
                                            <span class="media-badge images"><i class="fas fa-image"></i>
                                                {{ $imageCount }}</span>
                                        @endif
                                        @if ($videoCount > 0)
                                            <span class="media-badge videos"><i class="fas fa-video"></i>
                                                {{ $videoCount }}</span>
                                        @endif
                                        @if ($imageCount == 0 && $videoCount == 0)
                                            <span class="media-badge no-media">No Media</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="status-badge {{ $review->status }}">
                                            <span class="dot"></span> {{ ucfirst($review->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-btns">
                                            <button type="button" class="btn-action view"
                                                onclick="viewReviewDetails({{ $review->id }})" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </button>

                                            @if ($review->status == 'pending')
                                                <form action="{{ route('admin.reviews.approve', $review->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn-action approve" title="Approve">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.reviews.reject', $review->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn-action reject" title="Reject">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            <button type="button" class="btn-action delete"
                                                onclick="openDeleteModal({{ $review->id }})" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <div class="empty-state">
                                            <i class="fas fa-inbox"></i>
                                            <h5>No Reviews Found</h5>
                                            <p>No product reviews available.</p>
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
                        Showing <strong>{{ $reviews->firstItem() ?? 0 }}</strong> to
                        <strong>{{ $reviews->lastItem() ?? 0 }}</strong> of <strong>{{ $reviews->total() ?? 0 }}</strong>
                        entries
                    </div>
                    <div class="pagination-links">
                        {{ $reviews->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- REVIEW DETAILS MODAL                      -->
    <!-- ========================================== -->
    <div class="modal fade review-detail-modal" id="reviewDetailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-star me-2"></i> Review Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="reviewDetailBody">
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Loading review details...</p>
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
    <!-- LIGHTBOX MODAL                            -->
    <!-- ========================================== -->
    <div class="modal fade lightbox-modal" id="mediaLightboxModal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                <div class="modal-body">
                    <div class="lightbox-content" id="lightboxContent">
                        <!-- Content will be injected -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- CUSTOM DELETE MODAL                       -->
    <!-- ========================================== -->
    <div class="delete-modal-overlay" id="deleteModal">
        <div class="delete-modal">
            <div class="modal-header">
                <h4><i class="fas fa-trash-alt"></i> Confirm Delete</h4>
                <button class="modal-close" onclick="closeDeleteModal()">&times;</button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this review?
                <span class="warning-text"><i class="fas fa-exclamation-triangle"></i> This action cannot be
                    undone.</span>
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

    <!-- ========================================== -->
    <!-- DELETE FORM                               -->
    <!-- ========================================== -->
    <form id="delete-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <!-- ========================================== -->
    <!-- SCRIPTS                                    -->
    <!-- ========================================== -->
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
                form.action = '/admin/reviews/' + deleteId;
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
        // VIEW REVIEW DETAILS
        // ============================================
        async function viewReviewDetails(reviewId) {
            const body = document.getElementById('reviewDetailBody');
            body.innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2 text-muted">Loading review details...</p>
        </div>
    `;

            try {
                const response = await fetch(`/admin/reviews/${reviewId}/details`);
                const data = await response.json();

                if (data.success && data.review) {
                    renderReviewDetails(data.review);
                    const modal = new bootstrap.Modal(document.getElementById('reviewDetailModal'));
                    modal.show();
                } else {
                    body.innerHTML = `
                <div class="text-center py-4 text-danger">
                    <i class="fas fa-exclamation-circle fa-3x mb-3"></i>
                    <h5>Failed to load review details</h5>
                    <p class="text-muted">Please try again</p>
                </div>
            `;
                }
            } catch (error) {
                console.error('Error:', error);
                body.innerHTML = `
            <div class="text-center py-4 text-danger">
                <i class="fas fa-exclamation-circle fa-3x mb-3"></i>
                <h5>Error loading review details</h5>
                <p class="text-muted">${error.message || 'Please try again'}</p>
            </div>
        `;
            }
        }

        // ============================================
        // RENDER REVIEW DETAILS
        // ============================================
        function renderReviewDetails(review) {
            const body = document.getElementById('reviewDetailBody');

            // Parse images and videos
            let images = [];
            let videos = [];

            if (review.images) {
                try {
                    images = typeof review.images === 'string' ? JSON.parse(review.images) : review.images;
                } catch (e) {
                    images = [];
                }
            }
            if (review.videos) {
                try {
                    videos = typeof review.videos === 'string' ? JSON.parse(review.videos) : review.videos;
                } catch (e) {
                    videos = [];
                }
            }

            // Build status badge
            let statusBadge = '';
            if (review.status === 'pending') {
                statusBadge = '<span class="status-badge pending"><span class="dot"></span> Pending</span>';
            } else if (review.status === 'approved') {
                statusBadge = '<span class="status-badge approved"><span class="dot"></span> Approved</span>';
            } else {
                statusBadge = '<span class="status-badge rejected"><span class="dot"></span> Rejected</span>';
            }

            // Build rating stars
            let starsHtml = '';
            for (let i = 1; i <= 5; i++) {
                if (i <= review.rating) {
                    starsHtml += '<i class="fas fa-star star"></i>';
                } else {
                    starsHtml += '<i class="fas fa-star star-empty"></i>';
                }
            }

            // Build media gallery
            let mediaHtml = '';
            if (images.length > 0 || videos.length > 0) {
                mediaHtml += '<div class="review-image-gallery">';

                images.forEach(function(image, index) {
                    mediaHtml += `
                <div class="gallery-item" onclick="openLightbox('image', '/storage/${image}', 'Image ${index + 1}')">
                    <img src="/storage/${image}" alt="Review Image ${index + 1}">
                </div>
            `;
                });

                videos.forEach(function(video, index) {
                    mediaHtml += `
                <div class="gallery-item" onclick="openLightbox('video', '/storage/${video}', 'Video ${index + 1}')">
                    <video src="/storage/${video}"></video>
                </div>
            `;
                });

                mediaHtml += '</div>';
            } else {
                mediaHtml = '<span class="text-muted">No media uploaded</span>';
            }

            body.innerHTML = `
        <div class="detail-row">
            <span class="detail-label">Review ID</span>
            <span class="detail-value"><strong>#${review.id}</strong></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Product</span>
            <span class="detail-value"><strong>${review.product_name || 'N/A'}</strong></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">User</span>
            <span class="detail-value">${review.user_name || 'N/A'} <small style="color:var(--gray);">(${review.user_email || 'N/A'})</small></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Rating</span>
            <span class="detail-value rating-display">${starsHtml}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Status</span>
            <span class="detail-value">${statusBadge}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Review</span>
            <span class="detail-value">${review.description || 'No description'}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Media</span>
            <span class="detail-value">${mediaHtml}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Submitted On</span>
            <span class="detail-value">${new Date(review.created_at).toLocaleDateString('en-IN', { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' })}</span>
        </div>
    `;
        }

        // ============================================
        // OPEN LIGHTBOX
        // ============================================
        function openLightbox(type, src, title) {
            const content = document.getElementById('lightboxContent');

            if (type === 'image') {
                content.innerHTML = `
            <div style="text-align:center;">
                <img src="${src}" alt="${title}">
                <div class="lightbox-caption">${title}</div>
            </div>
        `;
            } else if (type === 'video') {
                content.innerHTML = `
            <div style="text-align:center;">
                <video controls autoplay>
                    <source src="${src}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <div class="lightbox-caption">${title}</div>
            </div>
        `;
            }

            const modal = new bootstrap.Modal(document.getElementById('mediaLightboxModal'));
            modal.show();
        }

        // ============================================
        // CLOSE LIGHTBOX ON ESCAPE
        // ============================================
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const lightbox = bootstrap.Modal.getInstance(document.getElementById('mediaLightboxModal'));
                if (lightbox) {
                    lightbox.hide();
                }
            }
        });

        // ============================================
        // SEARCH & FILTER TABLE
        // ============================================
        function filterTable() {
            var searchValue = document.getElementById('searchInput').value.toLowerCase();
            var ratingFilter = document.getElementById('ratingFilter').value;

            var rows = document.querySelectorAll('#tableBody tr');

            rows.forEach(function(row) {
                var text = row.textContent.toLowerCase();
                var rating = row.querySelector('td:nth-child(4)')?.textContent.trim() || '';

                var matchesSearch = text.includes(searchValue);
                var matchesRating = ratingFilter === '' || rating.includes(ratingFilter);

                if (matchesSearch && matchesRating) {
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
                td.colSpan = 8;
                td.style.textAlign = 'center';
                td.style.padding = '30px';
                td.style.color = '#6c757d';
                td.innerHTML =
                    '<i class="fas fa-search" style="font-size:24px; display:block; margin-bottom:8px; color:#dee2e6;"></i> No reviews found matching your filters.';
                tr.appendChild(td);
                tbody.appendChild(tr);
            }
        }

        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('ratingFilter').value = '';
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
    </script>

@endsection
