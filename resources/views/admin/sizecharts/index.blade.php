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

    .table-sizecharts {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        margin: 0;
    }

    .table-sizecharts thead {
        background: var(--light-gray);
    }

    .table-sizecharts thead th {
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

    .table-sizecharts thead th.text-center {
        text-align: center;
    }

    .table-sizecharts tbody td {
        padding: 10px 14px;
        vertical-align: middle;
        border-bottom: 1px solid var(--border-color);
    }

    .table-sizecharts tbody tr:hover {
        background: #f8f9fa;
    }

    .table-sizecharts tbody tr:last-child td {
        border-bottom: none;
    }

    .table-sizecharts .sno {
        font-weight: 600;
        color: var(--gray);
        font-size: 12px;
        text-align: center;
        width: 40px;
    }

    .table-sizecharts .chart-image {
        width: 40px;
        height: 40px;
        border-radius: var(--radius);
        object-fit: cover;
        border: 2px solid var(--border-color);
    }

    .table-sizecharts .chart-placeholder {
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

    .table-sizecharts .chart-title {
        font-weight: 600;
        color: var(--dark);
    }

    .table-sizecharts .chart-sub {
        font-size: 11px;
        color: var(--gray);
        display: block;
    }

    .table-sizecharts .gender-badge {
        padding: 3px 12px;
        border-radius: 50px;
        font-size: 10px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .table-sizecharts .gender-badge.men {
        background: #e3f2fd;
        color: #1565c0;
    }

    .table-sizecharts .gender-badge.women {
        background: #fce4ec;
        color: #c62828;
    }

    .table-sizecharts .gender-badge.kids {
        background: #fff3e0;
        color: #e65100;
    }

    .table-sizecharts .gender-badge.unisex {
        background: #f3e5f5;
        color: #6a1b9a;
    }

    .table-sizecharts .category-badge {
        padding: 3px 12px;
        border-radius: 50px;
        font-size: 10px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .table-sizecharts .category-badge.topwear {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .table-sizecharts .category-badge.bottomwear {
        background: #fff3e0;
        color: #e65100;
    }

    .table-sizecharts .category-badge.footwear {
        background: #e0f7fa;
        color: #00838f;
    }

    .table-sizecharts .sizes-count {
        padding: 3px 12px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 500;
        background: #e3f2fd;
        color: #1565c0;
        display: inline-flex;
        align-items: center;
        gap: 4px;
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
        background: rgba(74, 158, 255, 0.1);
        color: #4a9eff;
    }

    .action-btns .btn-action.view:hover {
        background: #4a9eff;
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
    /* VIEW MODAL                                  */
    /* ============================================ */
    .modal-content {
        border-radius: var(--radius-lg);
        border: none;
        box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    }

    .modal-header {
        padding: 14px 20px;
        background: linear-gradient(135deg, #0d1b2a 0%, #1b3a5c 100%);
        color: #ffffff;
        border-bottom: none;
        border-radius: var(--radius-lg) var(--radius-lg) 0 0;
    }

    .modal-header .modal-title {
        font-weight: 600;
        font-size: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .modal-header .modal-title i {
        color: #4a9eff;
    }

    .modal-header .btn-close {
        filter: brightness(0) invert(1);
        opacity: 0.7;
    }

    .modal-header .btn-close:hover {
        opacity: 1;
    }

    .modal-body {
        padding: 20px 24px;
    }

    .modal-footer {
        padding: 12px 20px;
        border-top: 1px solid var(--border-color);
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
        width: 120px;
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

    .size-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        font-size: 13px;
    }

    .size-table th {
        background: var(--light-gray);
        padding: 8px 12px;
        border: 1px solid var(--border-color);
        font-weight: 600;
        font-size: 11px;
        text-align: center;
    }

    .size-table td {
        padding: 6px 12px;
        border: 1px solid var(--border-color);
        text-align: center;
    }

    .size-table tr:hover {
        background: #f8f9fa;
    }

    .size-table .size-label {
        font-weight: 600;
        color: var(--primary);
    }

    .modal-image {
        max-height: 180px;
        width: 100%;
        object-fit: contain;
        background: var(--light-gray);
        padding: 8px;
        border-radius: var(--radius);
        border: 1px solid var(--border-color);
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

        .action-btns {
            gap: 3px;
        }

        .action-btns .btn-action {
            width: 28px;
            height: 28px;
            font-size: 10px;
        }

        .table-sizecharts thead th {
            font-size: 10px;
            padding: 6px 8px;
        }

        .table-sizecharts tbody td {
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

        .modal-body {
            padding: 14px 16px;
        }

        .detail-label {
            width: 100px;
            font-size: 11px;
        }

        .detail-value {
            font-size: 12px;
        }

        .size-table {
            font-size: 12px;
        }

        .size-table th,
        .size-table td {
            padding: 4px 8px;
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

        .table-sizecharts tbody td {
            padding: 4px 6px;
            font-size: 10px;
        }

        .table-sizecharts thead th {
            padding: 4px 6px;
            font-size: 9px;
        }

        .action-btns .btn-action {
            width: 24px;
            height: 24px;
            font-size: 9px;
        }

        .table-sizecharts .gender-badge,
        .table-sizecharts .category-badge {
            font-size: 9px;
            padding: 2px 8px;
        }

        .table-sizecharts .sizes-count {
            font-size: 9px;
            padding: 2px 8px;
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

        .modal-body {
            padding: 10px 12px;
        }

        .detail-row {
            flex-direction: column;
            padding: 4px 0;
        }

        .detail-label {
            width: 100%;
            margin-bottom: 2px;
        }

        .detail-value {
            width: 100%;
        }

        .size-table {
            font-size: 10px;
        }

        .size-table th,
        .size-table td {
            padding: 3px 6px;
            font-size: 10px;
        }

        .modal-image {
            max-height: 120px;
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
                <h4><i class="fas fa-chart-line"></i> Size Charts</h4>
                <small style="opacity:0.8;">Manage all size charts</small>
            </div>
            <div style="display:flex; gap:8px; flex-wrap:wrap; align-items:center;">
                <a href="{{ route('admin.sizecharts.create') }}" class="btn btn-primary" style="background:#4a9eff; color:#fff; border:none; padding:7px 16px; border-radius:10px; text-decoration:none; display:inline-flex; align-items:center; gap:6px; font-weight:500; font-size:12px; transition:all 0.3s;">
                    <i class="fas fa-plus"></i> Add Size Chart
                </a>
                <span style="background:rgba(74,158,255,0.2); color:#8ab4f8; padding:3px 12px; border-radius:50px; font-size:11px;">
                    <i class="fas fa-ruler"></i> Total: {{ $sizeCharts->total() }}
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
                    <input type="text" id="searchInput" placeholder="Search by title..." onkeyup="filterTable()">
                </div>
                <div class="filter-group">
                    <select id="genderFilter" onchange="filterTable()">
                        <option value="">All Gender</option>
                        <option value="men">Men</option>
                        <option value="women">Women</option>
                        <option value="kids">Kids</option>
                        <option value="unisex">Unisex</option>
                    </select>
                    <select id="categoryFilter" onchange="filterTable()">
                        <option value="">All Category</option>
                        <option value="topwear">Topwear</option>
                        <option value="bottomwear">Bottomwear</option>
                        <option value="footwear">Footwear</option>
                    </select>
                    <button class="btn-reset" onclick="resetFilters()">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table-sizecharts" id="sizeChartsTable">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:45px;">#</th>
                            <th style="width:50px;">Image</th>
                            <th>Title</th>
                            <th class="text-center">Gender</th>
                            <th class="text-center">Category</th>
                            <th class="text-center">Sizes</th>
                            <th class="text-center" style="width:130px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @forelse($sizeCharts as $index => $chart)
                        <tr>
                            <td class="text-center sno">{{ $sizeCharts->firstItem() + $index }}</td>
                            <td>
                                @if($chart->image)
                                    <img src="{{ asset('storage/'.$chart->image) }}" class="chart-image" alt="{{ $chart->title }}">
                                @else
                                    <div class="chart-placeholder">
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <span class="chart-title">{{ $chart->title }}</span>
                                <span class="chart-sub">
                                    <i class="fas fa-clock"></i> {{ $chart->created_at->format('d M Y') }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="gender-badge {{ $chart->gender ?? 'unisex' }}">
                                    <i class="fas fa-venus-mars"></i> {{ ucfirst($chart->gender ?? 'Unisex') }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="category-badge {{ $chart->category_type ?? 'topwear' }}">
                                    <i class="fas fa-tag"></i> {{ ucfirst($chart->category_type ?? 'Topwear') }}
                                </span>
                            </td>
                            <td class="text-center">
                                @php
                                    $sizesCount = 0;
                                    if ($chart->sizes) {
                                        if (is_array($chart->sizes)) {
                                            $sizesCount = count($chart->sizes);
                                        } else {
                                            $sizesCount = count(json_decode($chart->sizes, true) ?: []);
                                        }
                                    }
                                @endphp
                                <span class="sizes-count">
                                    <i class="fas fa-ruler"></i> {{ $sizesCount }}
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <button type="button" class="btn-action view" onclick="viewSizeChart({{ $chart->id }})" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="{{ route('admin.sizecharts.edit', $chart->id) }}" class="btn-action edit" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn-action delete" onclick="openDeleteModal({{ $chart->id }})" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fas fa-chart-line"></i>
                                    <h5>No Size Charts Found</h5>
                                    <p><a href="{{ route('admin.sizecharts.create') }}">Create your first size chart!</a></p>
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
                    Showing <strong>{{ $sizeCharts->firstItem() ?? 0 }}</strong> to <strong>{{ $sizeCharts->lastItem() ?? 0 }}</strong> of <strong>{{ $sizeCharts->total() ?? 0 }}</strong> entries
                </div>
                <div class="pagination-links">
                    {{ $sizeCharts->links() }}
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- VIEW SIZE CHART MODAL                       -->
<!-- ============================================ -->
<div class="modal fade" id="viewSizeChartModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-chart-line me-2"></i>
                    <span id="modalChartTitle">Size Chart Details</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalChartBody">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Loading size chart details...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background:#f0f4f8; color:var(--gray); border:1px solid var(--border-color); padding:7px 20px; border-radius:var(--radius); font-weight:500; font-size:13px; transition:all 0.3s;">
                    <i class="fas fa-times"></i> Close
                </button>
                <a href="#" id="editSizeChartBtn" class="btn btn-primary" style="background:#4a9eff; color:#fff; border:none; padding:7px 20px; border-radius:var(--radius); font-weight:500; font-size:13px; transition:all 0.3s; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                    <i class="fas fa-edit"></i> Edit
                </a>
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
            Are you sure you want to delete this size chart?
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
        form.action = '/admin/sizecharts/' + deleteId;
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
// VIEW SIZE CHART
// ============================================
function viewSizeChart(id) {
    var modal = new bootstrap.Modal(document.getElementById('viewSizeChartModal'));
    var body = document.getElementById('modalChartBody');
    var title = document.getElementById('modalChartTitle');

    body.innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2 text-muted">Loading size chart details...</p>
        </div>
    `;

    modal.show();

    fetch(`/admin/size-charts/${id}/details`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            var chart = data.sizeChart;
            title.textContent = chart.title + ' - Size Chart Details';

            var sizes = chart.sizes || [];
            var fieldNames = {
                'topwear': ['Size', 'Chest', 'Waist', 'Length', 'Sleeve'],
                'bottomwear': ['Size', 'Waist', 'Length', 'Inseam'],
                'footwear': ['Size', 'Length', 'Width', 'Heel']
            };

            var fields = fieldNames[chart.category_type] || ['Size'];
            var sizeHtml = '';

            if (sizes.length > 0) {
                sizeHtml = `
                    <div class="table-responsive mt-3">
                        <table class="size-table">
                            <thead>
                                <tr>
                                    ${fields.map(function(field) {
                                        return `<th>${field}</th>`;
                                    }).join('')}
                                </tr>
                            </thead>
                            <tbody>
                                ${sizes.map(function(size) {
                                    var rowData = fields.map(function(field) {
                                        var fieldKey = field.toLowerCase();
                                        if (fieldKey === 'size') {
                                            return `<td><span class="size-label">${size.size || '-'}</span></td>`;
                                        }
                                        return `<td>${size[fieldKey] || '-'}</td>`;
                                    }).join('');
                                    return `<tr>${rowData}</tr>`;
                                }).join('')}
                            </tbody>
                        </table>
                    </div>
                `;
            } else {
                sizeHtml = `<p class="text-muted text-center py-3">No size measurements available</p>`;
            }

            var genderColors = {
                'men': 'men',
                'women': 'women',
                'kids': 'kids',
                'unisex': 'unisex'
            };

            var categoryColors = {
                'topwear': 'topwear',
                'bottomwear': 'bottomwear',
                'footwear': 'footwear'
            };

            var categoryLabels = {
                'topwear': 'Topwear',
                'bottomwear': 'Bottomwear',
                'footwear': 'Footwear'
            };

            body.innerHTML = `
                <div class="row">
                    <div class="col-md-4 text-center">
                        ${chart.image ? 
                            `<img src="/storage/${chart.image}" class="modal-image" alt="${chart.title}">` :
                            `<div class="bg-light rounded d-flex align-items-center justify-content-center" style="height:180px; width:100%; border:1px solid var(--border-color);">
                                <i class="fas fa-chart-line fa-3x text-muted"></i>
                            </div>`
                        }
                    </div>
                    <div class="col-md-8">
                        <h5>${chart.title}</h5>
                        <div class="mb-3">
                            <span class="gender-badge ${genderColors[chart.gender] || 'unisex'} me-2">
                                <i class="fas fa-venus-mars"></i> ${chart.gender ? chart.gender.charAt(0).toUpperCase() + chart.gender.slice(1) : 'Unisex'}
                            </span>
                            <span class="category-badge ${categoryColors[chart.category_type] || 'topwear'}">
                                <i class="fas fa-tag"></i> ${categoryLabels[chart.category_type] || chart.category_type || 'Topwear'}
                            </span>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="detail-row">
                                    <span class="detail-label">Default Unit</span>
                                    <span class="detail-value">${chart.default_unit ? chart.default_unit.toUpperCase() : 'in'}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-row">
                                    <span class="detail-label">Total Sizes</span>
                                    <span class="detail-value">${sizes.length}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="detail-row">
                                    <span class="detail-label">Created At</span>
                                    <span class="detail-value">${new Date(chart.created_at).toLocaleDateString('en-IN', { day: 'numeric', month: 'long', year: 'numeric' })}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-row">
                                    <span class="detail-label">Last Updated</span>
                                    <span class="detail-value">${new Date(chart.updated_at).toLocaleDateString('en-IN', { day: 'numeric', month: 'long', year: 'numeric' })}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <h6 class="mt-2">
                    <i class="fas fa-ruler me-2 text-primary"></i> 
                    Size Measurements
                    <small class="text-muted">(${categoryLabels[chart.category_type] || 'Topwear'})</small>
                </h6>
                ${sizeHtml}
            `;

            document.getElementById('editSizeChartBtn').href = `/admin/sizecharts/${chart.id}/edit`;

        } else {
            body.innerHTML = `
                <div class="text-center py-5">
                    <i class="fas fa-exclamation-circle fa-3x text-danger mb-3 d-block"></i>
                    <h6 class="text-danger">Error loading size chart details</h6>
                    <p class="text-muted">${data.message || 'Please try again later'}</p>
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        body.innerHTML = `
            <div class="text-center py-5">
                <i class="fas fa-exclamation-circle fa-3x text-danger mb-3 d-block"></i>
                <h6 class="text-danger">Error loading size chart details</h6>
                <p class="text-muted">Please try again later</p>
            </div>
        `;
    });
}

// ============================================
// SEARCH & FILTER TABLE
// ============================================
function filterTable() {
    var searchValue = document.getElementById('searchInput').value.toLowerCase();
    var genderFilter = document.getElementById('genderFilter').value.toLowerCase();
    var categoryFilter = document.getElementById('categoryFilter').value.toLowerCase();

    var rows = document.querySelectorAll('#tableBody tr');

    rows.forEach(function(row) {
        var text = row.textContent.toLowerCase();
        var gender = row.querySelector('td:nth-child(4)')?.textContent.toLowerCase() || '';
        var category = row.querySelector('td:nth-child(5)')?.textContent.toLowerCase() || '';

        var matchesSearch = text.includes(searchValue);
        var matchesGender = genderFilter === '' || gender.includes(genderFilter);
        var matchesCategory = categoryFilter === '' || category.includes(categoryFilter);

        if (matchesSearch && matchesGender && matchesCategory) {
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
        td.innerHTML = '<i class="fas fa-search" style="font-size:24px; display:block; margin-bottom:8px; color:#dee2e6;"></i> No size charts found matching your filters.';
        tr.appendChild(td);
        tbody.appendChild(tr);
    }
}

function resetFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('genderFilter').value = '';
    document.getElementById('categoryFilter').value = '';
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