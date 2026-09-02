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
        /* CARD STYLES                                 */
        /* ============================================ */
        .members-card {
            background: #ffffff;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            border: 1px solid rgba(0, 0, 0, 0.04);
            overflow: hidden;
            max-width: 100%;
            margin: 0 auto;
        }

        .members-card .card-header {
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

        .members-card .card-header h4 {
            margin: 0;
            font-weight: 600;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .members-card .card-header h4 i {
            color: #4a9eff;
        }

        .members-card .card-body {
            padding: 20px 24px;
        }

        /* ============================================ */
        /* TABS STYLES                                 */
        /* ============================================ */
        .members-tabs {
            display: flex;
            gap: 0;
            margin-bottom: 20px;
            background: var(--light-gray);
            border-radius: var(--radius);
            border: 1px solid var(--border-color);
            overflow: hidden;
            flex-wrap: wrap;
        }

        .members-tabs .tab-item {
            flex: 1;
            min-width: 120px;
        }

        .members-tabs .tab-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 18px;
            color: var(--gray);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.3s;
            border-bottom: 3px solid transparent;
            background: transparent;
            border-right: 1px solid var(--border-color);
            cursor: pointer;
            white-space: nowrap;
        }

        .members-tabs .tab-item:last-child .tab-link {
            border-right: none;
        }

        .members-tabs .tab-link:hover {
            background: rgba(74, 158, 255, 0.05);
            color: var(--dark);
        }

        .members-tabs .tab-link.active {
            color: var(--primary);
            background: #ffffff;
            border-bottom-color: var(--primary);
            font-weight: 600;
        }

        .members-tabs .tab-link .tab-badge {
            padding: 2px 10px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 600;
        }

        .members-tabs .tab-link .tab-badge.all {
            background: #e3f2fd;
            color: #1565c0;
        }

        .members-tabs .tab-link .tab-badge.active {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .members-tabs .tab-link .tab-badge.expired {
            background: #fce4ec;
            color: #c62828;
        }

        .members-tabs .tab-link .tab-badge.inactive {
            background: #f5f5f5;
            color: #9e9e9e;
        }

        .members-tabs .tab-link .tab-badge.not-started {
            background: #fff3e0;
            color: #e65100;
        }

        /* ============================================ */
        /* SEARCH & FILTER SECTION                    */
        /* ============================================ */
        .search-filter-section {
            background: var(--light-gray);
            border-radius: var(--radius);
            padding: 16px 18px;
            margin-bottom: 20px;
            border: 1px solid var(--border-color);
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 12px;
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
            padding: 8px 12px 8px 36px;
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            font-size: 13px;
            transition: all 0.3s;
            background: #fff;
            height: 38px;
        }

        .search-filter-section .search-box input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(74, 158, 255, 0.12);
            outline: none;
        }

        .search-filter-section .filter-group {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
        }

        .search-filter-section .filter-group select,
        .search-filter-section .filter-group input[type="date"] {
            padding: 8px 12px;
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            font-size: 13px;
            background: #fff;
            height: 38px;
            min-width: 130px;
            transition: all 0.3s;
            color: var(--dark);
        }

        .search-filter-section .filter-group select:focus,
        .search-filter-section .filter-group input[type="date"]:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(74, 158, 255, 0.12);
            outline: none;
        }

        .search-filter-section .filter-group .btn-reset {
            padding: 8px 18px;
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
            height: 38px;
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

        .table-members {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            margin: 0;
            min-width: 1400px;
        }

        .table-members thead {
            background: var(--light-gray);
        }

        .table-members thead th {
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

        .table-members thead th.text-center {
            text-align: center;
        }

        .table-members tbody td {
            padding: 10px 14px;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-color);
        }

        .table-members tbody tr:hover {
            background: #f8f9fa;
        }

        .table-members tbody tr:last-child td {
            border-bottom: none;
        }

        .table-members .sno {
            font-weight: 600;
            color: var(--gray);
            font-size: 12px;
            text-align: center;
            width: 40px;
        }

        .table-members .avatar-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--border-color);
        }

        .table-members .member-id-badge {
            font-family: monospace;
            font-size: 12px;
            color: var(--gray);
            background: #f8f9fa;
            padding: 2px 10px;
            border-radius: 4px;
            white-space: nowrap;
        }

        .table-members .plan-tag {
            padding: 3px 12px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            white-space: nowrap;
        }

        .table-members .plan-tag.membership {
            background: #e3f2fd;
            color: #1565c0;
        }

        .table-members .plan-tag.package {
            background: #f3e5f5;
            color: #6a1b9a;
        }

        .table-members .plan-tag.monthly {
            background: #fff3e0;
            color: #e65100;
        }

        .table-members .plan-tag.none {
            background: #f5f5f5;
            color: #9e9e9e;
        }

        .table-members .plan-name {
            font-size: 12px;
            font-weight: 500;
            color: var(--dark);
        }

        .table-members .price-amount {
            font-weight: 600;
            color: var(--dark);
            white-space: nowrap;
        }

        .table-members .trainer-name {
            font-size: 12px;
            color: var(--gray);
        }

        .table-members .trainer-name i {
            margin-right: 4px;
            color: var(--primary);
        }

        .table-members .status-badge {
            padding: 4px 14px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .table-members .status-badge.active {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .table-members .status-badge.inactive {
            background: #fce4ec;
            color: #c62828;
        }

        .table-members .status-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
        }

        .table-members .status-badge.active .dot {
            background: #4caf50;
        }

        .table-members .status-badge.inactive .dot {
            background: #ef5350;
        }

        .table-members .status-badge.expired {
            background: #fce4ec;
            color: #c62828;
        }

        .table-members .status-badge.expired .dot {
            background: #ef5350;
        }

        .table-members .join-date {
            font-size: 12px;
            color: var(--gray);
            white-space: nowrap;
        }

        /* ============================================ */
        /* PAY BUTTON                                  */
        /* ============================================ */
        .pay-btn {
            background: #10b981;
            color: #fff;
            border: none;
            padding: 4px 14px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            text-decoration: none;
            margin-left: 8px;
        }

        .pay-btn:hover {
            background: #059669;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.35);
        }

        .pay-btn i {
            font-size: 10px;
        }

        /* ============================================ */
        /* ACTION BUTTONS - HORIZONTAL                 */
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
        /* CUSTOM DELETE MODAL - TOP RIGHT CORNER     */
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

            .members-card .card-header {
                padding: 12px 16px;
                flex-direction: column;
                align-items: flex-start;
            }

            .members-card .card-header h4 {
                font-size: 16px;
            }

            .members-card .card-body {
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

            .search-filter-section .filter-group select,
            .search-filter-section .filter-group input[type="date"] {
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

            .table-members thead th {
                font-size: 10px;
                padding: 6px 8px;
            }

            .table-members tbody td {
                padding: 6px 8px;
                font-size: 11px;
            }

            .table-members .avatar-img {
                width: 30px;
                height: 30px;
            }

            .table-members .status-badge {
                font-size: 10px;
                padding: 2px 10px;
            }

            .table-members .plan-tag {
                font-size: 10px;
                padding: 2px 8px;
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

            .members-tabs {
                flex-wrap: wrap;
            }

            .members-tabs .tab-item {
                flex: 1 1 50%;
                min-width: unset;
            }

            .members-tabs .tab-link {
                font-size: 12px;
                padding: 8px 12px;
                border-right: none;
                border-bottom: 1px solid var(--border-color);
            }

            .members-tabs .tab-item:last-child .tab-link {
                border-bottom: none;
            }
        }

        @media (max-width: 576px) {
            .members-card .card-header h4 {
                font-size: 14px;
            }

            .members-card .card-body {
                padding: 10px 12px;
            }

            .search-filter-section .search-box input {
                font-size: 12px;
                height: 34px;
            }

            .search-filter-section .filter-group select,
            .search-filter-section .filter-group input[type="date"] {
                font-size: 12px;
                height: 34px;
            }

            .search-filter-section .filter-group .btn-reset {
                font-size: 12px;
                height: 34px;
            }

            .table-members tbody td {
                padding: 4px 6px;
                font-size: 10px;
            }

            .table-members thead th {
                padding: 4px 6px;
                font-size: 9px;
            }

            .action-btns .btn-action {
                width: 24px;
                height: 24px;
                font-size: 9px;
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

            .members-tabs .tab-item {
                flex: 1 1 100%;
            }
        }
    </style>

    <div class="admin-main-content">
        <div class="members-card">
            <!-- Card Header -->
            <div class="card-header">
                <div>
                    <h4><i class="fas fa-users"></i> Members List</h4>
                    <small style="opacity:0.8;">Manage all gym members</small>
                </div>
                <a href="{{ route('admin.member.create') }}" class="btn btn-primary"
                    style="background:#4a9eff; color:#fff; border:none; padding:8px 20px; border-radius:10px; text-decoration:none; display:inline-flex; align-items:center; gap:8px; font-weight:500; font-size:13px; transition:all 0.3s;">
                    <i class="fas fa-user-plus"></i> Add Member
                </a>
            </div>

            <!-- Card Body -->
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

                <!-- ========================================== -->
                <!-- TABS - All | Active | Expired | Inactive  -->
                <!-- ========================================== -->
            <!-- ========================================== -->
<!-- TABS - All | Active | Expired | Inactive  -->
<!-- ========================================== -->
@php
    $currentTab = request('tab', 'all');
    
    // Count members for each tab
    $allCount = $members->total();
    $activeCount = \App\Models\Member::where('status', 'Active')
        ->where(function($q) {
            $q->whereNull('expiry_date')
              ->orWhere('expiry_date', '>=', now());
        })
        ->count();
    
    $expiredCount = \App\Models\Member::where('expiry_date', '<', now())->count();
    $inactiveCount = \App\Models\Member::where('status', 'Inactive')->count();
@endphp

<div class="members-tabs">
    <div class="tab-item">
        <a href="{{ route('admin.member.index', ['tab' => 'all']) }}" 
           class="tab-link {{ $currentTab == 'all' ? 'active' : '' }}">
            <i class="fas fa-list"></i> All
            <span class="tab-badge all">{{ $allCount }}</span>
        </a>
    </div>
    <div class="tab-item">
        <a href="{{ route('admin.member.index', ['tab' => 'active']) }}" 
           class="tab-link {{ $currentTab == 'active' ? 'active' : '' }}">
            <i class="fas fa-check-circle"></i> Active
            <span class="tab-badge active">{{ $activeCount }}</span>
        </a>
    </div>
    <div class="tab-item">
        <a href="{{ route('admin.member.index', ['tab' => 'expired']) }}" 
           class="tab-link {{ $currentTab == 'expired' ? 'active' : '' }}">
            <i class="fas fa-exclamation-circle"></i> Expired
            <span class="tab-badge expired">{{ $expiredCount }}</span>
        </a>
    </div>
    <div class="tab-item">
        <a href="{{ route('admin.member.index', ['tab' => 'inactive']) }}" 
           class="tab-link {{ $currentTab == 'inactive' ? 'active' : '' }}">
            <i class="fas fa-user-slash"></i> Inactive
            <span class="tab-badge inactive">{{ $inactiveCount }}</span>
        </a>
    </div>
</div>

                <!-- Search & Filter -->
                <div class="search-filter-section">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchInput" placeholder="Search by name, email, phone, member ID..."
                            onkeyup="filterTable()">
                    </div>
                    <div class="filter-group">
                        <select id="planFilter" onchange="filterTable()">
                            <option value="">All Plans</option>
                            <option value="membership">Membership</option>
                            <option value="package">Package</option>
                            <option value="monthly">Monthly Plan</option>
                        </select>
                        <input type="date" id="dateFilter" onchange="filterTable()" title="Filter by join date">
                        <button class="btn-reset" onclick="resetFilters()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table-members" id="membersTable">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:50px;">S.No</th>
                                <th style="width:50px;">Photo</th>
                                <th>Member ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Register Date</th>
                                <th>Plan</th>
                                <th>Plan Name</th>
                                <th>Price</th>
                                <th>Payment Type</th>
                                <th>Transaction ID</th>
                                <th>Trainer</th>
                                <th>Status</th>
                                <th>Join Date</th>
                                <th>Expiry Date</th>
                                <th>Plan Status</th>
                                <th class="text-center" style="width:120px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @forelse($members as $index => $member)
                                <tr>
                                    <td class="text-center sno">{{ $members->firstItem() + $index }}</td>
                                    <td>
                                        @if ($member->photo)
                                            <img src="{{ asset('storage/' . $member->photo) }}" class="avatar-img" alt="{{ $member->name }}">
                                        @else
                                            <img src="{{ asset('images/no-image.png') }}" class="avatar-img" alt="No Image">
                                        @endif
                                    </td>
                                    <td><span class="member-id-badge">{{ $member->member_id }}</span></td>
                                    <td><strong>{{ $member->name }}</strong></td>
                                    <td>{{ $member->email }}</td>
                                    <td>{{ $member->phone }}</td>
                                    
                                    <!-- Register Date -->
                                    <td>
                                        @if($member->register_date)
                                            <span class="join-date">{{ date('d-m-Y', strtotime($member->register_date)) }}</span>
                                        @else
                                            <span class="plan-tag none">-</span>
                                        @endif
                                    </td>
                                    
                                    <!-- Plan Type -->
                                    <td>
                                        @if ($member->plan_type == 'membership')
                                            <span class="plan-tag membership"><i class="fas fa-id-card"></i> Membership</span>
                                        @elseif($member->plan_type == 'package')
                                            <span class="plan-tag package"><i class="fas fa-box"></i> Package</span>
                                        @elseif($member->plan_type == 'monthly')
                                            <span class="plan-tag monthly"><i class="fas fa-calendar-alt"></i> Monthly</span>
                                        @else
                                            <span class="plan-tag none">-</span>
                                        @endif
                                    </td>
                                    
                                    <td><span class="plan-name">{{ $member->membership_plan ?? '-' }}</span></td>
                                    <td><span class="price-amount">₹ {{ number_format($member->final_price ?? 0, 2) }}</span></td>
                                    
                                    <!-- Payment Type -->
                                    <td>
                                        @if($member->payment_type == 'hand')
                                            <span class="plan-tag membership"><i class="fas fa-hand-holding-usd"></i> Hand</span>
                                        @elseif($member->payment_type == 'online')
                                            <span class="plan-tag package"><i class="fas fa-wifi"></i> Online</span>
                                        @else
                                            <span class="plan-tag none">-</span>
                                        @endif
                                    </td>
                                    
                                    <!-- Transaction ID -->
                                    <td>
                                        @if($member->transaction_id)
                                            <span class="plan-name" style="font-size:11px;">{{ $member->transaction_id }}</span>
                                        @else
                                            <span class="plan-tag none">-</span>
                                        @endif
                                    </td>
                                    
                                    <!-- Trainer -->
                                    <td>
                                        @if ($member->trainer)
                                            <span class="trainer-name">
                                                <i class="fas fa-chalkboard-user"></i>
                                                {{ $member->trainer->name }}
                                            </span>
                                        @else
                                            <span class="plan-tag none">Not Assigned</span>
                                        @endif
                                    </td>
                                    
                                    <!-- Status -->
                                    <td>
                                        @if ($member->status == 'Active')
                                            <span class="status-badge active">
                                                <span class="dot"></span> Active
                                            </span>
                                        @else
                                            <span class="status-badge inactive">
                                                <span class="dot"></span> Inactive
                                            </span>
                                        @endif
                                    </td>
                                    
                                    <!-- Join Date -->
                                    <td><span class="join-date">{{ date('d-m-Y', strtotime($member->join_date)) }}</span></td>
                                    
                                    <!-- Expiry Date -->
                                    <td>
                                        @if($member->expiry_date)
                                            {{ date('d-m-Y', strtotime($member->expiry_date)) }}
                                        @else
                                            <span class="plan-tag none">-</span>
                                        @endif
                                    </td>
                                    
                                    <!-- Plan Status - WITH PAY BUTTON -->
                                    <td>
                                        @if($member->expiry_date)
                                            @if(now()->gt($member->expiry_date))
                                                <span class="status-badge expired">
                                                    <span class="dot"></span> Expired
                                                    <a href="{{ route('admin.member.edit', $member->id) }}?renew=true&amount={{ $member->final_price }}" 
                                                       class="pay-btn" title="Renew Member">
                                                        <i class="fas fa-credit-card"></i> Pay ₹{{ number_format($member->final_price ?? 0, 2) }}
                                                    </a>
                                                </span>
                                            @else
                                                @php
                                                    if($member->join_date > now()) {
                                                        $daysLeft = 0;
                                                        $statusText = 'Not Started';
                                                        $badgeClass = 'inactive';
                                                    } else {
                                                        $daysLeft = floor(now()->diffInDays($member->expiry_date));
                                                        $statusText = $daysLeft . ' days left';
                                                        $badgeClass = ($daysLeft <= 7) ? 'warning' : 'active';
                                                    }
                                                @endphp
                                                @if($member->join_date > now())
                                                    <span class="status-badge inactive">
                                                        <span class="dot"></span> Not Started
                                                    </span>
                                                @elseif($daysLeft <= 7)
                                                    <span class="status-badge" style="background: #fef3c7; color: #92400e; padding: 4px 14px; border-radius: 50px; font-size: 11px; font-weight: 500; display: inline-flex; align-items: center; gap: 6px;">
                                                        <span class="dot" style="width:6px; height:6px; border-radius:50%; background:#f59e0b; display:inline-block;"></span>
                                                        {{ $daysLeft }} days left
                                                    </span>
                                                @else
                                                    <span class="status-badge active">
                                                        <span class="dot"></span> {{ $daysLeft }} days left
                                                    </span>
                                                @endif
                                            @endif
                                        @else
                                            <span class="plan-tag none">-</span>
                                        @endif
                                    </td>
                                    
                                    <!-- Actions -->
                                    <td>
                                        <div class="action-btns">
                                            <a href="{{ route('admin.member.show', $member->id) }}" class="btn-action view" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.member.edit', $member->id) }}" class="btn-action edit" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn-action delete" onclick="openDeleteModal({{ $member->id }})" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="18">
                                        <div class="empty-state">
                                            <i class="fas fa-users"></i>
                                            <h5>No Members Found</h5>
                                            <p>
                                                @if($currentTab == 'expired')
                                                    No expired members found.
                                                @elseif($currentTab == 'active')
                                                    No active members found.
                                                @elseif($currentTab == 'inactive')
                                                    No inactive members found.
                                                @else
                                                    Click "Add Member" to register a new member.
                                                @endif
                                            </p>
                                            @if($currentTab == 'all')
                                                <a href="{{ route('admin.member.create') }}" class="btn btn-primary" style="background:#4a9eff; color:#fff; border:none; padding:8px 20px; border-radius:10px; text-decoration:none; display:inline-flex; align-items:center; gap:8px; font-weight:500; font-size:13px;">
                                                    <i class="fas fa-user-plus"></i> Add Member
                                                </a>
                                            @endif
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
                        Showing <strong>{{ $members->firstItem() ?? 0 }}</strong> to
                        <strong>{{ $members->lastItem() ?? 0 }}</strong> of <strong>{{ $members->total() ?? 0 }}</strong>
                        entries
                    </div>
                    <div class="pagination-links">
                        {{ $members->appends(['tab' => $currentTab])->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- CUSTOM DELETE MODAL - TOP RIGHT           -->
    <!-- ========================================== -->
    <div class="delete-modal-overlay" id="deleteModal">
        <div class="delete-modal">
            <div class="modal-header">
                <h4><i class="fas fa-trash-alt"></i> Confirm Delete</h4>
                <button class="modal-close" onclick="closeDeleteModal()">&times;</button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this member?
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
    <!-- DELETE FORM                                -->
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

        // Confirm Delete
        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (deleteId) {
                let form = document.getElementById('delete-form');
                form.action = '/admin/members/' + deleteId;
                form.submit();
            }
        });

        // Close modal on overlay click
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        // Close modal on Escape key
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
            var planFilter = document.getElementById('planFilter').value.toLowerCase();
            var dateFilter = document.getElementById('dateFilter').value;

            var rows = document.querySelectorAll('#tableBody tr');

            rows.forEach(function(row) {
                var text = row.textContent.toLowerCase();
                var planType = row.querySelector('td:nth-child(8)')?.textContent.toLowerCase() || '';
                var joinDate = row.querySelector('td:nth-child(15)')?.textContent.trim() || '';

                var joinDateFormatted = '';
                if (joinDate) {
                    var parts = joinDate.split('-');
                    if (parts.length === 3) {
                        joinDateFormatted = parts[2] + '-' + parts[1] + '-' + parts[0];
                    }
                }

                var matchesSearch = text.includes(searchValue);
                var matchesPlan = planFilter === '' || planType.includes(planFilter);
                var matchesDate = dateFilter === '' || joinDateFormatted === dateFilter;

                if (matchesSearch && matchesPlan && matchesDate) {
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
                td.colSpan = 18;
                td.style.textAlign = 'center';
                td.style.padding = '30px';
                td.style.color = '#6c757d';
                td.innerHTML =
                    '<i class="fas fa-search" style="font-size:24px; display:block; margin-bottom:8px; color:#dee2e6;"></i> No members found matching your filters.';
                tr.appendChild(td);
                tbody.appendChild(tr);
            }
        }

        // ============================================
        // RESET FILTERS
        // ============================================
        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('planFilter').value = '';
            document.getElementById('dateFilter').value = '';
            filterTable();
        }

        // ============================================
        // CUSTOM ALERT - AUTO HIDE AFTER 3 SECONDS
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