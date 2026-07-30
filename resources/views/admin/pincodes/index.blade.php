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
        /* BULK ACTIONS BAR                           */
        /* ============================================ */
        .bulk-actions-bar {
            background: var(--light-gray);
            padding: 12px 16px;
            border-radius: var(--radius);
            margin-bottom: 16px;
            display: none;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            border: 1px solid var(--border-color);
        }

        .bulk-actions-bar.show {
            display: flex;
        }

        .selected-count {
            background: var(--primary);
            color: #fff;
            padding: 3px 14px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 500;
        }

        .bulk-shipping-input {
            width: 140px;
            padding: 6px 12px;
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            font-size: 13px;
            height: 34px;
            background: #fff;
        }

        .bulk-shipping-input:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(74, 158, 255, 0.12);
        }

        .btn-bulk {
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
            color: #fff;
        }

        .btn-bulk:hover {
            transform: translateY(-2px);
        }

        .btn-bulk.update {
            background: #3b82f6;
        }

        .btn-bulk.update:hover {
            background: #2563eb;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.35);
        }

        .btn-bulk.active {
            background: #4caf50;
        }

        .btn-bulk.active:hover {
            background: #388e3c;
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.35);
        }

        .btn-bulk.inactive {
            background: #f59e0b;
        }

        .btn-bulk.inactive:hover {
            background: #d97706;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.35);
        }

        .btn-bulk.delete {
            background: #ef5350;
        }

        .btn-bulk.delete:hover {
            background: #c62828;
            box-shadow: 0 4px 15px rgba(239, 83, 80, 0.35);
        }

        .btn-bulk.clear {
            background: #e9ecef;
            color: var(--gray);
        }

        .btn-bulk.clear:hover {
            background: #dee2e6;
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

        .table-pincodes {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            margin: 0;
        }

        .table-pincodes thead {
            background: var(--light-gray);
        }

        .table-pincodes thead th {
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

        .table-pincodes thead th.text-center {
            text-align: center;
        }

        .table-pincodes tbody td {
            padding: 10px 14px;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-color);
        }

        .table-pincodes tbody tr:hover {
            background: #f8f9fa;
        }

        .table-pincodes tbody tr:last-child td {
            border-bottom: none;
        }

        .table-pincodes .sno {
            font-weight: 600;
            color: var(--gray);
            font-size: 12px;
            text-align: center;
            width: 50px;
        }

        .table-pincodes .state-name {
            font-weight: 600;
            color: var(--dark);
        }

        .table-pincodes .shipping-amount {
            font-weight: 700;
            color: #10b981;
            font-size: 14px;
        }

        .table-pincodes .status-badge {
            padding: 4px 14px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .table-pincodes .status-badge.active {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .table-pincodes .status-badge.inactive {
            background: #fce4ec;
            color: #c62828;
        }

        .table-pincodes .status-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
        }

        .table-pincodes .status-badge.active .dot {
            background: #4caf50;
        }

        .table-pincodes .status-badge.inactive .dot {
            background: #ef5350;
        }

        /* ============================================ */
        /* TOGGLE SWITCH                               */
        /* ============================================ */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 40px;
            height: 22px;
            cursor: pointer;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: #e5e7eb;
            transition: 0.4s;
            border-radius: 24px;
        }

        .toggle-slider::before {
            content: "";
            position: absolute;
            height: 16px;
            width: 16px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
        }

        .toggle-switch input:checked+.toggle-slider {
            background: #10b981;
        }

        .toggle-switch input:checked+.toggle-slider::before {
            transform: translateX(18px);
        }

        /* ============================================ */
        /* CHECKBOX STYLES                             */
        /* ============================================ */
        .checkbox-custom {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: var(--primary);
        }

        .checkbox-custom:checked {
            accent-color: var(--primary);
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
        /* PAGINATION - CUSTOM                         */
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

        .entries-info {
            font-size: 13px;
            color: var(--gray);
        }

        .entries-info strong {
            color: var(--dark);
        }

        .pagination-links {
            display: flex;
            gap: 4px;
            align-items: center;
            padding-left: 0;
            margin: 0;
            list-style: none;
        }

        .pagination-links .page-item {
            display: inline-block;
            list-style: none;
        }

        .pagination-links .page-item a,
        .pagination-links .page-item span {
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
            background: transparent;
            cursor: pointer;
        }

        .pagination-links .page-item a:hover {
            background: #f0f0f0;
            color: var(--dark);
        }

        .pagination-links .page-item.active a,
        .pagination-links .page-item.active span {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
            border-radius: 8px;
        }

        .pagination-links .page-item.disabled a,
        .pagination-links .page-item.disabled span {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
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

        .empty-state a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .empty-state a:hover {
            text-decoration: underline;
        }

        /* ============================================ */
        /* BULK IMPORT MODAL                          */
        /* ============================================ */
        .modal-content {
            border-radius: var(--radius-lg);
            border: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
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

        .modal-body textarea.form-control {
            height: auto;
            min-height: 150px;
            resize: vertical;
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

            .bulk-actions-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .bulk-actions-bar .selected-count {
                text-align: center;
            }

            .bulk-shipping-input {
                width: 100%;
            }

            .action-btns {
                gap: 3px;
            }

            .action-btns .btn-action {
                width: 28px;
                height: 28px;
                font-size: 10px;
            }

            .table-pincodes thead th {
                font-size: 10px;
                padding: 6px 8px;
            }

            .table-pincodes tbody td {
                padding: 6px 8px;
                font-size: 11px;
            }

            .pagination-wrapper {
                flex-direction: column;
                align-items: center;
            }

            .entries-info {
                font-size: 12px;
                text-align: center;
                width: 100%;
            }

            .pagination-links .page-item a,
            .pagination-links .page-item span {
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

            .toggle-switch {
                width: 34px;
                height: 20px;
            }

            .toggle-slider::before {
                height: 14px;
                width: 14px;
                left: 3px;
                bottom: 3px;
            }

            .toggle-switch input:checked+.toggle-slider::before {
                transform: translateX(14px);
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

            .table-pincodes tbody td {
                padding: 4px 6px;
                font-size: 10px;
            }

            .table-pincodes thead th {
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

            .btn-bulk {
                font-size: 11px;
                padding: 5px 12px;
            }

            .bulk-shipping-input {
                font-size: 12px;
                height: 32px;
            }

            .entries-info {
                font-size: 11px;
            }

            .table-pincodes .sno {
                width: 35px;
                font-size: 10px;
            }
        }
    </style>

    <div class="admin-main-content">
        <div class="list-card">
            <div class="card-header">
                <div>
                    <h4><i class="fas fa-truck"></i> Deliverable States & Shipping Charges</h4>
                    <small style="opacity:0.8;">Manage shipping charges by state</small>
                </div>
                <div style="display:flex; gap:8px; flex-wrap:wrap;">
                    <button type="button" class="btn btn-primary"
                        style="background:#4a9eff; color:#fff; border:none; padding:7px 16px; border-radius:10px; text-decoration:none; display:inline-flex; align-items:center; gap:6px; font-weight:500; font-size:12px; transition:all 0.3s; cursor:pointer;"
                        data-bs-toggle="modal" data-bs-target="#bulkImportModal">
                        <i class="fas fa-upload"></i> Bulk Import
                    </button>
                    <a href="{{ route('admin.pincodes.create') }}" class="btn btn-success"
                        style="background:#4caf50; color:#fff; border:none; padding:7px 16px; border-radius:10px; text-decoration:none; display:inline-flex; align-items:center; gap:6px; font-weight:500; font-size:12px; transition:all 0.3s;">
                        <i class="fas fa-plus"></i> Add State
                    </a>
                </div>
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

                <!-- Search & Filter -->
                <div class="search-filter-section">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchInput" placeholder="Search by state name..."
                            onkeyup="filterTable()">
                    </div>
                    <div class="filter-group">
                        <select id="statusFilter" onchange="filterTable()">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <button class="btn-reset" onclick="resetFilters()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </div>

                <!-- Bulk Actions Bar -->
                <div id="bulkActionsBar" class="bulk-actions-bar">
                    <span class="selected-count" id="selectedCount">0 selected</span>
                    <input type="number" id="bulkShippingCharge" class="bulk-shipping-input" placeholder="Shipping charge"
                        step="0.01" min="0">
                    <button class="btn-bulk update" onclick="bulkUpdateShipping()">
                        <i class="fas fa-edit"></i> Update Shipping
                    </button>
                    <button class="btn-bulk active" onclick="bulkUpdateStatus(1)">
                        <i class="fas fa-check-circle"></i> Set Active
                    </button>
                    <button class="btn-bulk inactive" onclick="bulkUpdateStatus(0)">
                        <i class="fas fa-times-circle"></i> Set Inactive
                    </button>
                    <button class="btn-bulk delete" onclick="bulkDeleteStates()">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                    <button class="btn-bulk clear" onclick="clearSelection()">
                        <i class="fas fa-times"></i> Clear
                    </button>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table-pincodes" id="pincodeTable">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:40px;">
                                    <input type="checkbox" id="selectAllCheckbox" class="checkbox-custom"
                                        onclick="toggleSelectAll()">
                                </th>
                                <th class="text-center" style="width:50px;">#</th>
                                <th>State Name</th>
                                <th class="text-center" style="width:120px;">Shipping Charge</th>
                                <th class="text-center" style="width:140px;">Status</th>
                                <th class="text-center" style="width:120px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @forelse($pincodes as $index => $pincode)
                                <tr id="row-{{ $pincode->id }}">
                                    <td class="text-center">
                                        <input type="checkbox" class="state-checkbox checkbox-custom"
                                            value="{{ $pincode->id }}" data-state="{{ $pincode->state }}"
                                            data-shipping="{{ $pincode->shipping_charge }}"
                                            data-status="{{ $pincode->is_active }}" onclick="updateSelectedCount()">
                                    </td>
                                    <!-- ===== FIX: Use firstItem() + index for continuous numbering ===== -->
                                    <td class="text-center sno">{{ $pincodes->firstItem() + $index }}</td>
                                    <td><span class="state-name">{{ $pincode->state }}</span></td>
                                    <td class="text-center">
                                        <span class="shipping-amount"
                                            id="shipping-{{ $pincode->id }}">₹{{ number_format($pincode->shipping_charge, 2) }}</span>
                                    </td>
                                    <td class="text-center">
                                        <div style="display:flex; align-items:center; justify-content:center; gap:8px;">
                                            <label class="toggle-switch" title="Toggle status">
                                                <input type="checkbox" class="status-toggle"
                                                    data-id="{{ $pincode->id }}"
                                                    {{ $pincode->is_active ? 'checked' : '' }}
                                                    onchange="toggleStatus({{ $pincode->id }}, this.checked)">
                                                <span class="toggle-slider"></span>
                                            </label>
                                            <span class="status-badge {{ $pincode->is_active ? 'active' : 'inactive' }}"
                                                id="status-badge-{{ $pincode->id }}">
                                                <span class="dot"></span>
                                                {{ $pincode->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action-btns">
                                            <a href="{{ route('admin.pincodes.edit', $pincode->id) }}"
                                                class="btn-action edit" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn-action delete"
                                                onclick="openDeleteModal({{ $pincode->id }})" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <i class="fas fa-truck"></i>
                                            <h5>No States Found</h5>
                                            <p><a href="{{ route('admin.pincodes.create') }}">Add your first state
                                                    now!</a></p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- ========================================== -->
                <!-- CUSTOM PAGINATION - NO DUPLICATE TEXT     -->
                <!-- ========================================== -->
                @if ($pincodes->hasPages())
                    <div class="pagination-wrapper">
                        <div class="entries-info">
                            Showing <strong>{{ $pincodes->firstItem() }}</strong> to
                            <strong>{{ $pincodes->lastItem() }}</strong> of
                            <strong>{{ $pincodes->total() }}</strong> entries
                        </div>

                        <ul class="pagination-links">
                            {{-- Previous Page Link --}}
                            @if ($pincodes->onFirstPage())
                                <li class="page-item disabled"><span>« Previous</span></li>
                            @else
                                <li class="page-item"><a href="{{ $pincodes->previousPageUrl() }}" rel="prev">«
                                        Previous</a></li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($pincodes->getUrlRange(1, $pincodes->lastPage()) as $page => $url)
                                @if ($page == $pincodes->currentPage())
                                    <li class="page-item active"><span>{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($pincodes->hasMorePages())
                                <li class="page-item"><a href="{{ $pincodes->nextPageUrl() }}" rel="next">Next »</a>
                                </li>
                            @else
                                <li class="page-item disabled"><span>Next »</span></li>
                            @endif
                        </ul>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- BULK IMPORT MODAL                         -->
    <!-- ========================================== -->
    <div class="modal fade" id="bulkImportModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.pincodes.bulk') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-upload"></i> Bulk Import States</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Enter States (One per line)</label>
                            <textarea name="states" class="form-control" rows="10"
                                placeholder="Format: State Name|shipping_charge
Tamil Nadu|50
Karnataka|70
Maharashtra|80
Kerala|60
Delhi|100

OR just state name (shipping charge will be 0):
Tamil Nadu
Karnataka
Maharashtra"></textarea>
                            <small class="text-muted mt-2 d-block" style="font-size:11px;">
                                <i class="fas fa-info-circle me-1"></i>
                                Format: <strong>State Name|shipping_charge</strong> (separate with pipe |)<br>
                                Example: Tamil Nadu|50 , Karnataka|70
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            style="background:#f0f4f8; color:var(--gray); border:1px solid var(--border-color); padding:7px 20px; border-radius:var(--radius); font-weight:500; font-size:13px; transition:all 0.3s;">Cancel</button>
                        <button type="submit" class="btn btn-primary"
                            style="background:#4a9eff; color:#fff; border:none; padding:7px 20px; border-radius:var(--radius); font-weight:500; font-size:13px; transition:all 0.3s;">
                            <i class="fas fa-upload"></i> Import States
                        </button>
                    </div>
                </form>
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
                Are you sure you want to delete this state?
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
                form.action = '/admin/pincodes/' + deleteId;
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
        // TOGGLE STATUS
        // ============================================
        async function toggleStatus(id, isActive) {
            const status = isActive ? 1 : 0;
            const badge = document.getElementById('status-badge-' + id);
            const toggle = document.querySelector(`.status-toggle[data-id="${id}"]`);
            const currentState = isActive;

            if (badge) {
                badge.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            }

            try {
                const response = await fetch('/admin/pincodes/toggle-status/' + id, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        is_active: status
                    })
                });

                const data = await response.json();

                if (data.success) {
                    if (badge) {
                        if (isActive) {
                            badge.className = 'status-badge active';
                            badge.innerHTML = '<span class="dot"></span> Active';
                        } else {
                            badge.className = 'status-badge inactive';
                            badge.innerHTML = '<span class="dot"></span> Inactive';
                        }
                    }
                    const checkbox = document.querySelector(`.state-checkbox[value="${id}"]`);
                    if (checkbox) {
                        checkbox.setAttribute('data-status', status);
                    }
                } else {
                    if (toggle) {
                        toggle.checked = !isActive;
                    }
                    if (badge) {
                        badge.className = 'status-badge ' + (currentState ? 'active' : 'inactive');
                        badge.innerHTML = '<span class="dot"></span> ' + (currentState ? 'Active' : 'Inactive');
                    }
                    showToast(data.message || 'Failed to update status', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                if (toggle) {
                    toggle.checked = !isActive;
                }
                if (badge) {
                    badge.className = 'status-badge ' + (currentState ? 'active' : 'inactive');
                    badge.innerHTML = '<span class="dot"></span> ' + (currentState ? 'Active' : 'Inactive');
                }
                showToast('Network error. Please try again.', 'error');
            }
        }

        // ============================================
        // SELECT ALL / BULK ACTIONS
        // ============================================
        function toggleSelectAll() {
            const selectAll = document.getElementById('selectAllCheckbox');
            const checkboxes = document.querySelectorAll('.state-checkbox');

            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });

            updateSelectedCount();
        }

        function updateSelectedCount() {
            const checkboxes = document.querySelectorAll('.state-checkbox:checked');
            const count = checkboxes.length;
            const selectedCountSpan = document.getElementById('selectedCount');
            const bulkBar = document.getElementById('bulkActionsBar');

            if (count > 0) {
                selectedCountSpan.innerHTML = count + ' selected';
                bulkBar.classList.add('show');
            } else {
                bulkBar.classList.remove('show');
            }
        }

        function clearSelection() {
            const checkboxes = document.querySelectorAll('.state-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            document.getElementById('selectAllCheckbox').checked = false;
            updateSelectedCount();
            showToast('Selection cleared', 'success');
        }

        // ============================================
        // BULK UPDATE STATUS
        // ============================================
        async function bulkUpdateStatus(status) {
            const selectedCheckboxes = document.querySelectorAll('.state-checkbox:checked');
            const ids = Array.from(selectedCheckboxes).map(cb => cb.value);

            if (ids.length === 0) {
                showToast('Please select at least one state.', 'error');
                return;
            }

            const statusText = status === 1 ? 'Active' : 'Inactive';

            if (!confirm(`Set ${ids.length} state(s) to ${statusText}?`)) return;

            try {
                const response = await fetch('/admin/pincodes/bulk-update-status', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        state_ids: ids,
                        is_active: status
                    })
                });

                const data = await response.json();

                if (data.success) {
                    ids.forEach(id => {
                        const badge = document.getElementById('status-badge-' + id);
                        const toggle = document.querySelector(`.status-toggle[data-id="${id}"]`);

                        if (badge) {
                            if (status === 1) {
                                badge.className = 'status-badge active';
                                badge.innerHTML = '<span class="dot"></span> Active';
                            } else {
                                badge.className = 'status-badge inactive';
                                badge.innerHTML = '<span class="dot"></span> Inactive';
                            }
                        }
                        if (toggle) {
                            toggle.checked = status === 1;
                        }
                    });

                    showToast(`Successfully updated ${ids.length} state(s) to ${statusText}!`, 'success');
                    clearSelection();
                } else {
                    showToast(data.message || 'Error updating status', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Network error. Please try again.', 'error');
            }
        }

        // ============================================
        // BULK UPDATE SHIPPING
        // ============================================
        async function bulkUpdateShipping() {
            const selectedCheckboxes = document.querySelectorAll('.state-checkbox:checked');
            const ids = Array.from(selectedCheckboxes).map(cb => cb.value);

            if (ids.length === 0) {
                showToast('Please select at least one state.', 'error');
                return;
            }

            const shippingCharge = document.getElementById('bulkShippingCharge').value;

            if (!shippingCharge) {
                showToast('Please enter a shipping charge amount.', 'error');
                return;
            }

            if (!confirm(`Update shipping charge to ₹${shippingCharge} for ${ids.length} state(s)?`)) return;

            try {
                const response = await fetch('{{ route('admin.pincodes.bulk-update-shipping') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        state_ids: ids,
                        shipping_charge: shippingCharge
                    })
                });

                const data = await response.json();

                if (data.success) {
                    ids.forEach(id => {
                        const shippingSpan = document.getElementById(`shipping-${id}`);
                        if (shippingSpan) {
                            shippingSpan.innerHTML = '₹' + parseFloat(shippingCharge).toLocaleString('en-IN', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        }
                    });

                    showToast(`Successfully updated shipping for ${ids.length} state(s)!`, 'success');
                    clearSelection();
                    document.getElementById('bulkShippingCharge').value = '';
                } else {
                    showToast(data.message || 'Error updating shipping charges', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Network error. Please try again.', 'error');
            }
        }

        // ============================================
        // BULK DELETE STATES
        // ============================================
        async function bulkDeleteStates() {
            const selectedCheckboxes = document.querySelectorAll('.state-checkbox:checked');
            const ids = Array.from(selectedCheckboxes).map(cb => cb.value);

            if (ids.length === 0) {
                showToast('Please select at least one state.', 'error');
                return;
            }

            if (!confirm(`Delete ${ids.length} state(s)? This action cannot be undone!`)) return;

            try {
                const response = await fetch('{{ route('admin.pincodes.bulk-delete') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        state_ids: ids
                    })
                });

                const data = await response.json();

                if (data.success) {
                    ids.forEach(id => {
                        const row = document.getElementById(`row-${id}`);
                        if (row) {
                            row.remove();
                        }
                    });

                    showToast(`Successfully deleted ${ids.length} state(s)!`, 'success');
                    clearSelection();
                } else {
                    showToast(data.message || 'Error deleting states', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Network error. Please try again.', 'error');
            }
        }

        // ============================================
        // SEARCH & FILTER
        // ============================================
        function filterTable() {
            var searchValue = document.getElementById('searchInput').value.toLowerCase();
            var statusFilter = document.getElementById('statusFilter').value.toLowerCase();

            var rows = document.querySelectorAll('#tableBody tr');

            rows.forEach(function(row) {
                var text = row.textContent.toLowerCase();
                var status = row.querySelector('td:nth-child(5)')?.textContent.toLowerCase() || '';

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
                td.colSpan = 6;
                td.style.textAlign = 'center';
                td.style.padding = '30px';
                td.style.color = '#6c757d';
                td.innerHTML =
                    '<i class="fas fa-search" style="font-size:24px; display:block; margin-bottom:8px; color:#dee2e6;"></i> No states found matching your filters.';
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
        // TOAST MESSAGES
        // ============================================
        function showToast(message, type = 'success') {
            const alertDiv = document.createElement('div');
            alertDiv.className = `custom-alert ${type}`;
            alertDiv.innerHTML = `
            <span class="alert-icon"><i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i></span>
            <span class="alert-content">${message}</span>
            <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
            <div class="alert-timer"><div class="timer-bar"></div></div>
        `;

            const container = document.querySelector('.list-card .card-body');
            container.insertBefore(alertDiv, container.firstChild);

            setTimeout(function() {
                if (alertDiv) {
                    alertDiv.style.opacity = '0';
                    alertDiv.style.transition = 'opacity 0.5s ease';
                    setTimeout(function() {
                        alertDiv.remove();
                    }, 500);
                }
            }, 3000);
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
