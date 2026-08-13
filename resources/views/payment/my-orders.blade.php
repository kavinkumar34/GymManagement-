{{-- resources/views/payment/my-orders.blade.php --}}
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

        /* ============================================================ */
        /* ===== PAGE HEADER ===== */
        /* ============================================================ */
        .page-header-custom {
            background: var(--ink);
            padding: 30px 25px;
            border-radius: var(--radius-lg);
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            border: 1px solid rgba(255,255,255,0.08);
        }

        .page-header-custom h2 {
            font-family: var(--font-display);
            font-weight: 400;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            color: white;
            margin: 0;
            font-size: 1.5rem;
        }

        .page-header-custom h2 i {
            color: var(--signal);
            margin-right: 12px;
        }

        .page-header-custom .header-stats {
            display: flex;
            gap: 20px;
            align-items: center;
            flex-wrap: wrap;
        }

        .page-header-custom .header-stats .stat-item {
            color: #94a3b8;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 500;
        }

        .page-header-custom .header-stats .stat-item strong {
            color: white;
            font-size: 1rem;
        }

        /* ============================================================ */
        /* ===== ORDER GRID ===== */
        /* ============================================================ */
        .orders-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        @media (max-width: 992px) {
            .orders-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .orders-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ============================================================ */
        /* ===== ORDER CARD ===== */
        /* ============================================================ */
        .order-card {
            background: white;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-card);
            overflow: hidden;
            transition: all 0.28s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            border: 1px solid var(--line);
        }

        .order-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-card-hover);
            border-color: transparent;
        }

        .order-header {
            padding: 16px 20px;
            background: var(--fog);
            border-bottom: 1px solid var(--line);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .order-number {
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--ink);
        }

        .order-number .order-number-badge {
            background: var(--ink);
            color: white;
            padding: 2px 10px;
            border-radius: var(--radius-sm);
            font-size: 0.65rem;
            font-weight: 600;
            margin-left: 8px;
        }

        .order-number-badge i {
            margin-right: 4px;
        }

        .order-date {
            font-size: 0.75rem;
            color: var(--steel);
            margin-top: 2px;
        }

        .order-status {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 700;
            align-self: flex-start;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .order-status.Pending {
            background: #fef3c7;
            color: #92400e;
        }
        .order-status.Confirmed {
            background: #dbeafe;
            color: #1d4ed8;
        }
        .order-status.Shipped {
            background: #e0e7ff;
            color: #3730a3;
        }
        .order-status.Delivered {
            background: #dcfce7;
            color: #15803d;
        }
        .order-status.Cancelled {
            background: #fee2e2;
            color: #b91c1c;
        }
        .order-status.Failed {
            background: #fee2e2;
            color: #b91c1c;
        }

        .order-body {
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .order-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        /* ===== PRODUCT IMAGE IN CARD ===== */
        .order-product-image {
            margin-bottom: 8px;
        }

        .order-product-image img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: var(--radius-sm);
            border: 2px solid var(--line);
            transition: all 0.3s;
        }

        .order-product-image img:hover {
            transform: scale(1.05);
            border-color: var(--signal);
        }

        .order-product-image .no-image-placeholder {
            width: 60px;
            height: 60px;
            background: var(--fog);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--line);
            color: var(--steel);
            font-size: 1.2rem;
        }

        .order-total {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--ink);
            font-family: var(--font-body);
        }

        .order-total i {
            color: var(--signal);
            margin-right: 4px;
        }

        .order-items-count {
            font-size: 0.8rem;
            color: var(--steel);
            font-weight: 500;
        }

        .order-items-count i {
            margin-right: 4px;
        }

        /* ===== PAYMENT BADGE ===== */
        .payment-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 12px;
            border-radius: 20px;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .payment-paid {
            background: var(--success-tint);
            color: var(--success);
        }

        .payment-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .payment-failed {
            background: var(--signal-tint);
            color: var(--signal-dark);
        }

        /* ===== ORDER ACTIONS ===== */
        .order-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 6px;
        }

        .btn-view-details {
            background: var(--ink);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 40px;
            font-size: 0.78rem;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
            font-family: var(--font-body);
            letter-spacing: 0.2px;
        }

        .btn-view-details:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(20, 22, 26, 0.4);
            color: white;
        }

        .btn-view-details i {
            margin-right: 4px;
        }

        .btn-review {
            background: var(--signal);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 40px;
            font-size: 0.78rem;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
            font-family: var(--font-body);
            letter-spacing: 0.2px;
        }

        .btn-review:hover {
            background: var(--signal-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 68, 5, 0.4);
            color: white;
        }

        .btn-review.reviewed {
            background: var(--steel);
            cursor: not-allowed;
            opacity: 0.7;
        }

        .btn-review.reviewed:hover {
            transform: none;
            box-shadow: none;
        }

        /* ============================================================ */
        /* ===== FILTER SECTION ===== */
        /* ============================================================ */
        .filter-section {
            background: white;
            border-radius: var(--radius-lg);
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid var(--line);
            box-shadow: var(--shadow-card);
        }

        .filter-section .form-label {
            font-weight: 700;
            font-size: 0.8rem;
            color: var(--ink);
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .filter-section .form-control,
        .filter-section .form-select {
            border-radius: var(--radius-sm);
            border: 1px solid var(--line);
            font-size: 0.85rem;
            padding: 8px 14px;
            transition: all 0.3s;
            font-family: var(--font-body);
        }

        .filter-section .form-control:focus,
        .filter-section .form-select:focus {
            border-color: var(--signal);
            box-shadow: 0 0 0 3px rgba(255, 68, 5, 0.1);
        }

        .filter-section .input-group-text {
            background: white;
            border: 1px solid var(--line);
            border-right: none;
            border-radius: var(--radius-sm) 0 0 var(--radius-sm);
            color: var(--steel);
        }

        .filter-section .input-group .form-control {
            border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
        }

        .btn-filter-primary {
            background: var(--signal);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            font-weight: 700;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            font-size: 0.75rem;
        }

        .btn-filter-primary:hover {
            background: var(--signal-dark);
            transform: translateY(-2px);
            color: white;
        }

        .btn-filter-secondary {
            background: var(--fog);
            color: var(--ink-soft);
            border: 1px solid var(--line);
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            font-weight: 700;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            font-size: 0.75rem;
        }

        .btn-filter-secondary:hover {
            background: var(--line);
            color: var(--ink);
        }

        /* ============================================================ */
        /* ===== MODAL STYLES ===== */
        /* ============================================================ */

        /* Review Modal */
        .review-modal .modal-dialog {
            max-width: 500px;
        }

        .review-modal .modal-content {
            border-radius: var(--radius-lg);
            overflow: hidden;
            border: none;
        }

        .review-modal .modal-header {
            background: var(--ink);
            color: white;
            border-bottom: none;
            padding: 18px 24px;
        }

        .review-modal .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }

        .review-modal .modal-header .modal-title {
            font-family: var(--font-display);
            font-weight: 400;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            font-size: 1.1rem;
        }

        .review-modal .modal-body {
            padding: 24px;
        }

        .review-modal .modal-footer {
            padding: 12px 24px 24px;
            border-top: 1px solid var(--line);
        }

        .review-stars {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
            gap: 5px;
            margin: 10px 0;
        }

        .review-stars input {
            display: none;
        }

        .review-stars label {
            font-size: 30px;
            color: #ddd;
            cursor: pointer;
            transition: 0.2s;
        }

        .review-stars label:hover,
        .review-stars label:hover~label,
        .review-stars input:checked~label {
            color: #f59e0b;
        }

        .review-textarea {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid var(--line);
            border-radius: var(--radius-sm);
            resize: vertical;
            font-size: 0.9rem;
            min-height: 80px;
            transition: all 0.3s;
            font-family: var(--font-body);
        }

        .review-textarea:focus {
            outline: none;
            border-color: var(--signal);
            box-shadow: 0 0 0 3px rgba(255, 68, 5, 0.1);
        }

        .file-upload-area {
            border: 2px dashed var(--line);
            border-radius: var(--radius-sm);
            padding: 16px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            background: var(--fog);
        }

        .file-upload-area:hover {
            border-color: var(--signal);
            background: var(--signal-tint);
        }

        .file-upload-area .file-preview {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .file-upload-area .file-preview-item {
            position: relative;
            width: 60px;
            height: 60px;
            border-radius: var(--radius-sm);
            overflow: hidden;
            border: 1px solid var(--line);
        }

        .file-upload-area .file-preview-item img,
        .file-upload-area .file-preview-item video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .file-upload-area .file-preview-item .remove-file {
            position: absolute;
            top: -6px;
            right: -6px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--signal);
            color: white;
            border: none;
            font-size: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ===== CANCEL MODAL ===== */
        .cancel-modal .modal-content {
            border-radius: var(--radius-lg);
            overflow: hidden;
            border: none;
        }

        .cancel-modal .modal-header {
            background: var(--signal);
            color: white;
            border-bottom: none;
            padding: 18px 24px;
        }

        .cancel-modal .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }

        .cancel-modal .modal-header .modal-title {
            font-family: var(--font-display);
            font-weight: 400;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            font-size: 1.1rem;
        }

        .reason-option {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            margin-bottom: 8px;
            border: 1px solid var(--line);
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: all 0.2s;
        }

        .reason-option:hover {
            border-color: var(--signal);
            background: var(--signal-tint);
        }

        .reason-option.selected {
            border-color: var(--signal);
            background: var(--signal-tint);
        }

        .reason-option input[type="radio"] {
            margin-right: 12px;
            accent-color: var(--signal);
        }

        .reason-option label {
            flex: 1;
            cursor: pointer;
            margin: 0;
            font-weight: 500;
            font-size: 0.9rem;
            font-family: var(--font-body);
        }

        .cancel-comment {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--line);
            border-radius: var(--radius-sm);
            resize: vertical;
            font-size: 0.9rem;
            transition: all 0.3s;
            font-family: var(--font-body);
        }

        .cancel-comment:focus {
            outline: none;
            border-color: var(--signal);
            box-shadow: 0 0 0 3px rgba(255, 68, 5, 0.1);
        }

        /* ===== ORDER DETAILS MODAL ===== */
        .order-details-modal .modal-dialog {
            max-width: 900px;
        }

        .order-details-modal .modal-content {
            border-radius: var(--radius-lg);
            overflow: hidden;
            border: none;
        }

        .modal-header-custom {
            background: var(--ink);
            color: white;
            padding: 20px 24px;
            border-bottom: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header-custom .btn-close {
            filter: brightness(0) invert(1);
        }

        .modal-header-custom h5 {
            font-family: var(--font-display);
            font-weight: 400;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            font-size: 1.1rem;
            margin: 0;
        }

        .order-status-steps {
            display: flex;
            justify-content: space-between;
            padding: 20px 24px;
            background: var(--fog);
            border-bottom: 1px solid var(--line);
        }

        .status-step {
            text-align: center;
            flex: 1;
            position: relative;
        }

        .status-step .step-icon {
            width: 40px;
            height: 40px;
            background: var(--line);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 8px;
            color: var(--steel);
            font-size: 1rem;
            transition: all 0.3s;
        }

        .status-step.active .step-icon {
            background: var(--signal);
            color: white;
        }

        .status-step.completed .step-icon {
            background: var(--success);
            color: white;
        }

        .status-step .step-label {
            font-size: 0.65rem;
            font-weight: 600;
            color: var(--steel);
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .status-step.active .step-label {
            color: var(--signal);
        }

        .status-step.completed .step-label {
            color: var(--success);
        }

        .detail-section {
            padding: 20px 24px;
            border-bottom: 1px solid var(--line);
        }

        .detail-section:last-child {
            border-bottom: none;
        }

        .section-title {
            font-family: var(--font-display);
            font-weight: 400;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            color: var(--ink);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title i {
            color: var(--signal);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        @media (max-width: 576px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .info-label {
            font-size: 0.65rem;
            color: var(--steel);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        .info-value {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--ink);
        }

        .address-block {
            background: var(--fog);
            padding: 16px;
            border-radius: var(--radius-sm);
            line-height: 1.8;
            font-size: 0.9rem;
            border: 1px solid var(--line);
        }

        /* ===== ORDER ITEMS IN MODAL ===== */
        .order-item-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .order-item-card {
            display: flex;
            gap: 15px;
            padding: 15px;
            background: var(--fog);
            border-radius: var(--radius-sm);
            align-items: center;
            border: 1px solid var(--line);
            transition: all 0.3s;
        }

        .order-item-card:hover {
            border-color: var(--signal);
        }

        .order-item-image {
            width: 80px;
            height: 80px;
            min-width: 80px;
            background: white;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 1px solid var(--line);
        }

        .order-item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .order-item-image .no-image {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--fog);
            color: var(--steel);
            font-size: 2rem;
        }

        .order-item-details {
            flex: 1;
            min-width: 0;
        }

        .order-item-name {
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 4px;
            font-size: 0.95rem;
        }

        .order-item-price {
            font-weight: 600;
            color: var(--ink);
            font-size: 0.9rem;
        }

        .order-item-price i {
            color: var(--signal);
        }

        .order-item-quantity {
            font-size: 0.8rem;
            color: var(--steel);
        }

        .order-item-variant {
            font-size: 0.75rem;
            color: var(--steel);
            margin-top: 2px;
        }

        .order-item-total {
            text-align: right;
            font-weight: 700;
            color: var(--ink);
            flex-shrink: 0;
            font-size: 0.95rem;
        }

        /* ===== PAYMENT SUMMARY ===== */
        .payment-summary {
            background: var(--fog);
            padding: 16px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--line);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .summary-row .shipping-free {
            color: var(--success);
            font-weight: 700;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-top: 2px solid var(--line);
            font-weight: 800;
            font-size: 1.1rem;
            color: var(--ink);
        }

        /* ===== ACTION BUTTONS ===== */
        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 15px;
            flex-wrap: wrap;
        }

        .btn-cancel-order {
            background: var(--signal);
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 40px;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
            font-family: var(--font-body);
            letter-spacing: 0.2px;
        }

        .btn-cancel-order:hover {
            background: var(--signal-dark);
            transform: translateY(-2px);
            color: white;
        }

        .btn-cancel-order:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        .btn-contact-support {
            background: var(--steel);
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 40px;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
            font-family: var(--font-body);
            letter-spacing: 0.2px;
        }

        .btn-contact-support:hover {
            background: var(--ink-soft);
            transform: translateY(-2px);
            color: white;
        }

        /* ============================================================ */
        /* ===== MODAL Z-INDEX FIX ===== */
        /* ============================================================ */
        .modal {
            z-index: 99999 !important;
        }

        .modal-backdrop {
            z-index: 99998 !important;
        }

        .modal-open {
            overflow: auto !important;
            padding-right: 0 !important;
        }

        .modal-open .navbar {
            z-index: 9999 !important;
        }

        /* ============================================================ */
        /* ===== EMPTY STATE ===== */
        /* ============================================================ */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 4rem;
            color: var(--steel);
            margin-bottom: 20px;
        }

        .empty-state h4 {
            font-family: var(--font-display);
            font-weight: 400;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            color: var(--ink);
            margin-bottom: 10px;
        }

        .empty-state p {
            color: var(--steel);
            margin-bottom: 20px;
            font-weight: 500;
        }

        .empty-state .btn-start-shopping {
            background: var(--signal);
            color: white;
            padding: 10px 30px;
            border-radius: 40px;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.3s;
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            font-size: 0.85rem;
        }

        .empty-state .btn-start-shopping:hover {
            background: var(--signal-dark);
            transform: translateY(-2px);
            color: white;
        }

        /* ============================================================ */
        /* ===== TOAST / ALERT ===== */
        /* ============================================================ */
    /* ===== MY ORDERS TOAST - DO NOT CONFLICT WITH APP TOAST ===== */
.my-orders-toast {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: auto !important;
    height: auto !important;
    min-height: 0 !important;
    max-width: 350px !important;
    padding: 14px 24px !important;
    margin: 0 !important;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    z-index: 999999 !important;
    display: flex;
    align-items: center;
    gap: 10px;
    color: #fff;
    font-size: 0.9rem;
    font-weight: 600;
    box-sizing: border-box;
}

.my-orders-toast.success {
    background: var(--success);
}

.my-orders-toast.error {
    background: var(--signal);
}

.my-orders-toast.info {
    background: var(--info);
}

        .custom-toast.success {
            background: var(--success);
            color: white;
        }

        .custom-toast.error {
            background: var(--signal);
            color: white;
        }

        .custom-toast.info {
            background: var(--info);
            color: white;
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

        @media (max-width: 768px) {
            .page-header-custom {
                padding: 20px;
                flex-direction: column;
                text-align: center;
            }

            .page-header-custom h2 {
                font-size: 1.2rem;
            }

            .page-header-custom .header-stats {
                justify-content: center;
                gap: 12px;
            }

            .page-header-custom .header-stats .stat-item {
                font-size: 0.75rem;
            }

            .order-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .order-status {
                align-self: flex-start;
            }

            .order-item-card {
                flex-wrap: wrap;
            }

            .order-item-total {
                text-align: left;
                width: 100%;
                padding-left: 95px;
            }

            .filter-section .row>[class*="col-"] {
                margin-bottom: 10px;
            }

            .modal-header-custom {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }

            .order-status-steps {
                flex-wrap: wrap;
                gap: 10px;
            }

            .status-step {
                flex: 0 0 45%;
            }
        }

        @media (max-width: 576px) {
            .order-card .order-body {
                padding: 15px;
            }

            .order-header {
                padding: 12px 15px;
            }

            .order-number {
                font-size: 0.85rem;
            }

            .order-number .order-number-badge {
                font-size: 0.55rem;
                padding: 1px 8px;
                margin-left: 4px;
            }

            .order-product-image img {
                width: 50px;
                height: 50px;
            }

            .order-product-image .no-image-placeholder {
                width: 50px;
                height: 50px;
                font-size: 1rem;
            }

            .order-total {
                font-size: 1rem;
            }

            .btn-view-details,
            .btn-review {
                font-size: 0.7rem;
                padding: 6px 14px;
            }

            .order-item-image {
                width: 60px;
                height: 60px;
                min-width: 60px;
            }

            .order-item-name {
                font-size: 0.85rem;
            }

            .order-item-price {
                font-size: 0.8rem;
            }

            .order-item-total {
                padding-left: 75px;
                font-size: 0.85rem;
            }

            .review-modal .modal-dialog {
                margin: 10px;
            }

            .review-stars label {
                font-size: 24px;
            }

            .detail-section {
                padding: 15px;
            }

            .section-title {
                font-size: 0.85rem;
            }

            .custom-toast {
                bottom: 20px;
                right: 20px;
                max-width: 90%;
                font-size: 0.8rem;
                padding: 12px 18px;
            }
        }

        @media (max-width: 400px) {
            .page-header-custom h2 {
                font-size: 1rem;
            }

            .page-header-custom .header-stats .stat-item {
                font-size: 0.65rem;
            }

            .order-number {
                font-size: 0.75rem;
            }

            .order-date {
                font-size: 0.65rem;
            }

            .order-status {
                font-size: 0.6rem;
                padding: 3px 10px;
            }

            .order-total {
                font-size: 0.9rem;
            }

            .order-items-count {
                font-size: 0.7rem;
            }

            .payment-badge {
                font-size: 0.55rem;
                padding: 2px 8px;
            }

            .btn-view-details,
            .btn-review {
                font-size: 0.6rem;
                padding: 5px 10px;
            }

            .order-item-card {
                padding: 10px;
                gap: 10px;
            }

            .order-item-image {
                width: 50px;
                height: 50px;
                min-width: 50px;
            }

            .order-item-name {
                font-size: 0.75rem;
            }

            .order-item-price {
                font-size: 0.7rem;
            }

            .order-item-quantity {
                font-size: 0.65rem;
            }

            .order-item-total {
                font-size: 0.75rem;
                padding-left: 60px;
            }

            .filter-section {
                padding: 12px;
            }

            .filter-section .form-label {
                font-size: 0.7rem;
            }

            .filter-section .form-control,
            .filter-section .form-select {
                font-size: 0.75rem;
                padding: 6px 10px;
            }
        }
    </style>

    <div class="container mt-4 pt-2 pb-5 mb-4">
        <!-- ===== PAGE HEADER ===== -->
        <div class="page-header-custom">
            <h2><i class="fas fa-shopping-bag"></i> My Orders</h2>
            <div class="header-stats">
                <span class="stat-item">
                    <i class="fas fa-box"></i> Total Orders: <strong>{{ $orders->total() ?? 0 }}</strong>
                </span>
                <span class="stat-item">
                    <i class="fas fa-clock"></i> Pending: <strong>{{ $orders->where('order_status', 'Pending')->count() ?? 0 }}</strong>
                </span>
                <span class="stat-item">
                    <i class="fas fa-check-circle" style="color: var(--success);"></i> Delivered: <strong>{{ $orders->where('order_status', 'Delivered')->count() ?? 0 }}</strong>
                </span>
            </div>
        </div>

        <!-- ===== SEARCH & FILTER SECTION ===== -->
        <div class="filter-section">
            <form method="GET" action="{{ route('my.orders') }}" id="orderFilterForm">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label"><i class="fas fa-search me-1"></i> Search Order</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" name="search" class="form-control" placeholder="Order # or Product..."
                                value="{{ request('search') }}">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label"><i class="fas fa-tag me-1"></i> Status</label>
                        <select name="status" class="form-select" onchange="this.form.submit()">
                            <option value="">All Status</option>
                            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Confirmed" {{ request('status') == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="Shipped" {{ request('status') == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="Delivered" {{ request('status') == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="Failed" {{ request('status') == 'Failed' ? 'selected' : '' }}>Failed</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label"><i class="fas fa-credit-card me-1"></i> Payment</label>
                        <select name="payment_status" class="form-select" onchange="this.form.submit()">
                            <option value="">All Payments</option>
                            <option value="SUCCESS" {{ request('payment_status') == 'SUCCESS' ? 'selected' : '' }}>Paid</option>
                            <option value="PENDING" {{ request('payment_status') == 'PENDING' ? 'selected' : '' }}>Pending</option>
                            <option value="FAILED" {{ request('payment_status') == 'FAILED' ? 'selected' : '' }}>Failed</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label"><i class="fas fa-calendar-alt me-1"></i> From Date</label>
                        <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label"><i class="fas fa-calendar-alt me-1"></i> To Date</label>
                        <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                    </div>

                    <div class="col-md-1">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn-filter-primary w-100">
                                <i class="fas fa-filter"></i>
                            </button>
                            <a href="{{ route('my.orders') }}" class="btn-filter-secondary w-100" title="Clear Filters">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- ===== ORDERS LIST ===== -->
        <div class="card border-0 shadow-sm" style="border-radius: var(--radius-lg); overflow: hidden;">
            <div class="card-body" style="padding: 0;">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show m-3" role="alert" style="border-radius: var(--radius-sm);">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show m-3" role="alert" style="border-radius: var(--radius-sm);">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (isset($orders) && $orders->count() > 0)
                    @php
                        $sortedOrders = $orders->sortByDesc('created_at');
                        $reviewedProductIds = \App\Models\ProductReview::where('user_id', auth()->id())
                            ->pluck('product_id')
                            ->toArray();
                    @endphp

                    <div class="orders-grid p-3">
                        @foreach ($sortedOrders as $order)
                            <div class="order-card-wrapper">
                                <div class="order-card">
                                    <div class="order-header">
                                        <div>
                                            <span class="order-number">
                                                Order #{{ $order->order_number }}
                                                <span class="order-number-badge">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($order->created_at)->diffForHumans() }}
                                                </span>
                                            </span>
                                            <div class="order-date">
                                                <i class="far fa-calendar-alt me-1"></i>
                                                {{ \Carbon\Carbon::parse($order->created_at)->format('j F Y \a\t h:i A') }}
                                            </div>
                                        </div>
                                        <div>
                                            <span class="order-status {{ $order->order_status }}">
                                                <i class="fas fa-circle" style="font-size: 0.4rem;"></i>
                                                {{ strtoupper($order->order_status) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="order-body">
                                        <div class="order-info">
                                            <!-- ===== PRODUCT IMAGE ===== -->
                                            <div class="order-product-image">
                                                @php
                                                    $firstItem = $order->items->first();
                                                    $productImage = null;

                                                    if ($firstItem) {
                                                        $productImage = \App\Models\ProductImage::where(
                                                            'product_id',
                                                            $firstItem->product_id,
                                                        )
                                                            ->where(function ($q) use ($firstItem) {
                                                                if ($firstItem->variant_id) {
                                                                    $q->where('variant_id', $firstItem->variant_id);
                                                                } else {
                                                                    $q->whereNull('variant_id');
                                                                }
                                                            })
                                                            ->orderByDesc('is_main')
                                                            ->orderBy('display_order')
                                                            ->value('image_path');

                                                        if (!$productImage) {
                                                            $productImage = \App\Models\ProductImage::where(
                                                                'product_id',
                                                                $firstItem->product_id,
                                                            )
                                                                ->orderByDesc('is_main')
                                                                ->orderBy('display_order')
                                                                ->value('image_path');
                                                        }
                                                    }
                                                @endphp
                                                @if ($productImage)
                                                    <img src="{{ asset('storage/' . $productImage) }}" alt="Product">
                                                @else
                                                    <div class="no-image-placeholder">
                                                        <i class="fas fa-box"></i>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="order-total">
                                                <i class="fas fa-rupee-sign"></i>
                                                {{ number_format($order->total_amount, 2) }}
                                            </div>
                                            <div class="order-items-count">
                                                <i class="fas fa-box"></i> {{ $order->items->count() }} item(s) •
                                                @if ($order->payment_status == 'SUCCESS')
                                                    <span class="payment-badge payment-paid"><i
                                                            class="fas fa-check-circle"></i> Payment Paid</span>
                                                @elseif($order->payment_status == 'FAILED')
                                                    <span class="payment-badge payment-failed"><i
                                                            class="fas fa-times-circle"></i> Payment Failed</span>
                                                @else
                                                    <span class="payment-badge payment-pending"><i
                                                            class="fas fa-clock"></i> Payment Pending</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="order-actions">
                                            <button class="btn-view-details"
                                                onclick="viewOrderDetails({{ $order->id }}, this)">
                                                <i class="fas fa-eye"></i> View Details
                                            </button>

                                            @if (strtolower($order->order_status) === 'delivered')
                                                @php
                                                    $hasReviewed = false;
                                                    foreach ($order->items as $item) {
                                                        if (in_array($item->product_id, $reviewedProductIds)) {
                                                            $hasReviewed = true;
                                                            break;
                                                        }
                                                    }
                                                @endphp
                                                @if (!$hasReviewed)
                                                    <button class="btn-review"
                                                        onclick="openReviewModal({{ $order->id }})">
                                                        <i class="fas fa-star"></i> Write Review
                                                    </button>
                                                @else
                                                    <button class="btn-review reviewed" disabled>
                                                        <i class="fas fa-check-circle"></i> Reviewed
                                                    </button>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 d-flex justify-content-center pb-3">
                        {{ $orders->links('pagination::bootstrap-5') }}
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-shopping-bag"></i>
                        <h4>No Orders Found</h4>
                        <p>You haven't placed any orders yet. Start shopping now!</p>
                        <a href="{{ url('/') }}" class="btn-start-shopping">
                            <i class="fas fa-shopping-cart me-2"></i> Start Shopping
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- ===== REVIEW MODAL ===== -->
    <!-- ============================================================ -->
    <div class="modal fade review-modal" id="reviewModal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-star me-2"></i> Write a Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="review_order_id" value="">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Select Product <span class="text-danger">*</span></label>
                        <select id="review_product_select" class="form-control form-control-sm" required>
                            <option value="">-- Select Product --</option>
                        </select>
                        <small class="text-danger" id="product_select_error" style="display:none;">Please select a
                            product</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Your Rating <span class="text-danger">*</span></label>
                        <div class="review-stars" id="reviewStars">
                            <input type="radio" name="rating" value="5" id="review_star5">
                            <label for="review_star5"><i class="fas fa-star"></i></label>
                            <input type="radio" name="rating" value="4" id="review_star4">
                            <label for="review_star4"><i class="fas fa-star"></i></label>
                            <input type="radio" name="rating" value="3" id="review_star3">
                            <label for="review_star3"><i class="fas fa-star"></i></label>
                            <input type="radio" name="rating" value="2" id="review_star2">
                            <label for="review_star2"><i class="fas fa-star"></i></label>
                            <input type="radio" name="rating" value="1" id="review_star1" checked>
                            <label for="review_star1"><i class="fas fa-star"></i></label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Review <span class="text-danger">*</span></label>
                        <textarea id="review_description" class="review-textarea" placeholder="Share your experience with this product..."></textarea>
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-bold">Upload Photos</label>
                        <div class="file-upload-area" onclick="document.getElementById('review_files').click()">
                            <i class="fas fa-cloud-upload-alt" style="color: var(--signal);"></i>
                            <p class="mb-0 small">Click to upload photos or videos</p>
                            <small class="text-muted">You can upload multiple files</small>
                            <input type="file" id="review_files" name="review_files[]" multiple
                                accept="image/*,video/*" style="display:none" onchange="previewReviewFiles(this)">
                            <div id="review_files_preview" class="file-preview"></div>
                        </div>
                    </div>

                    <div id="review_error_message" class="alert alert-danger"
                        style="display:none; padding: 8px 12px; font-size: 0.85rem; border-radius: var(--radius-sm);"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" style="border-radius: var(--radius-sm); font-weight: 600;">Close</button>
                    <button type="button" class="btn btn-sm" id="submitReviewBtn" onclick="submitReview()" style="background: var(--signal); color: white; border-radius: var(--radius-sm); font-weight: 600;">
                        <i class="fas fa-paper-plane"></i> Submit Review
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- ===== ORDER DETAILS MODAL ===== -->
    <!-- ============================================================ -->
    <div class="modal fade order-details-modal" id="orderDetailsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header-custom">
                    <h5><i class="fas fa-shopping-bag me-2"></i> Order Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="order-status-steps" id="statusSteps"></div>

                    <div class="detail-section">
                        <div class="section-title"><i class="fas fa-info-circle"></i> Order Information</div>
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">Order Number</span>
                                <span class="info-value" id="modalOrderNumber">-</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Placed On</span>
                                <span class="info-value" id="modalOrderDate">-</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Transaction ID</span>
                                <span class="info-value" id="modalTransactionId">-</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Order Status</span>
                                <span class="info-value" id="modalOrderStatus">-</span>
                            </div>
                        </div>
                    </div>

                    <div class="detail-section">
                        <div class="section-title"><i class="fas fa-user-circle"></i> Customer Details</div>
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">Name</span>
                                <span class="info-value" id="modalCustomerName">-</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Email</span>
                                <span class="info-value" id="modalCustomerEmail">-</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Phone</span>
                                <span class="info-value" id="modalCustomerPhone">-</span>
                            </div>
                        </div>
                    </div>

                    <div class="detail-section">
                        <div class="section-title"><i class="fas fa-map-marker-alt"></i> Shipping Address</div>
                        <div id="modalShippingAddress" class="address-block">No address information available</div>
                    </div>

                    <div class="detail-section">
                        <div class="section-title"><i class="fas fa-box"></i> Order Items</div>
                        <div id="modalOrderItems" class="order-item-list"></div>
                    </div>

                    <div class="detail-section">
                        <div class="section-title"><i class="fas fa-credit-card"></i> Payment Summary</div>
                        <div class="payment-summary" id="modalPaymentSummary"></div>
                       <div class="action-buttons" id="modalActions">
                          {{--   <button class="btn-cancel-order" id="cancelOrderBtn"
                                onclick="openCancelModalFromDetails()">Cancel Order</button> --}}
                            <button class="btn-contact-support" onclick="contactSupport()">Contact Support</button>
                        </div> 
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: var(--radius-sm); font-weight: 600;">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- ===== CANCEL ORDER MODAL ===== -->
    <!-- ============================================================ -->
    <div class="modal fade cancel-modal" id="cancelModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-times-circle me-2"></i> Cancel Order</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="cancelOrderId">
                    <p class="text-muted mb-3">Please select a reason for cancellation:</p>
                    <div id="cancelReasons">
                        <div class="reason-option" onclick="selectReason(this, 'Changed my mind')">
                            <input type="radio" name="cancel_reason" value="Changed my mind">
                            <label>Changed my mind</label>
                        </div>
                        <div class="reason-option" onclick="selectReason(this, 'Delivery takes too long')">
                            <input type="radio" name="cancel_reason" value="Delivery takes too long">
                            <label>Delivery takes too long</label>
                        </div>
                        <div class="reason-option" onclick="selectReason(this, 'Wrong product ordered')">
                            <input type="radio" name="cancel_reason" value="Wrong product ordered">
                            <label>Wrong product ordered</label>
                        </div>
                        <div class="reason-option" onclick="selectReason(this, 'Found better price elsewhere')">
                            <input type="radio" name="cancel_reason" value="Found better price elsewhere">
                            <label>Found better price elsewhere</label>
                        </div>
                        <div class="reason-option" onclick="selectReason(this, 'Product quality issue')">
                            <input type="radio" name="cancel_reason" value="Product quality issue">
                            <label>Product quality issue</label>
                        </div>
                        <div class="reason-option" onclick="selectReason(this, 'Size/Fit issue')">
                            <input type="radio" name="cancel_reason" value="Size/Fit issue">
                            <label>Size/Fit issue</label>
                        </div>
                        <div class="reason-option" onclick="selectReason(this, 'Other')">
                            <input type="radio" name="cancel_reason" value="Other">
                            <label>Other</label>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label class="form-label fw-bold">Additional Comments (Optional)</label>
                        <textarea id="cancelComment" class="cancel-comment" rows="3"
                            placeholder="Please provide any additional details about your cancellation request..."></textarea>
                    </div>
                    <div class="alert alert-warning mt-3" style="border-radius: var(--radius-sm);">
                        <i class="fas fa-info-circle"></i> Once cancelled, your order will be processed for refund as per
                        our policy.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: var(--radius-sm); font-weight: 600;">Close</button>
                    <button type="button" class="btn btn-danger" onclick="submitCancellation()" style="border-radius: var(--radius-sm); font-weight: 600;">Submit
                        Cancellation</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- ===== JAVASCRIPT ===== -->
    <!-- ============================================================ -->
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
            '{{ csrf_token() }}';
        let currentCancelOrderId = null;
        let currentOrderForCancel = null;
        let currentOrderId = null;
        let reviewFiles = [];
        let orderItemsData = [];

        // ============================================================
        // ===== TOAST NOTIFICATION =====
        // ============================================================
    function showMyOrdersToast(message, type = 'info') {
    const toast = document.createElement('div');

    toast.className = `my-orders-toast ${type}`;

    const icon = type === 'success'
        ? 'fa-check-circle'
        : type === 'error'
            ? 'fa-exclamation-circle'
            : 'fa-info-circle';

    toast.innerHTML = `
        <i class="fas ${icon}"></i>
        <span>${message}</span>
    `;

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(10px)';
        toast.style.transition = 'all 0.3s ease';

        setTimeout(() => {
            toast.remove();
        }, 300);
    }, 3000);
}

        // ============================================================
        // ===== SELECT REASON FOR CANCELLATION =====
        // ============================================================
        function selectReason(element, reason) {
            document.querySelectorAll('.reason-option').forEach(opt => {
                opt.classList.remove('selected');
                const radio = opt.querySelector('input[type="radio"]');
                if (radio) radio.checked = false;
            });
            element.classList.add('selected');
            const radio = element.querySelector('input[type="radio"]');
            if (radio) radio.checked = true;
        }

        // ============================================================
        // ===== OPEN REVIEW MODAL =====
        // ============================================================
        function openReviewModal(orderId) {
            try {
                currentOrderId = orderId;

                const orderIdInput = document.getElementById('review_order_id');
                if (orderIdInput) {
                    orderIdInput.value = orderId;
                }

                const descriptionTextarea = document.getElementById('review_description');
                if (descriptionTextarea) {
                    descriptionTextarea.value = '';
                }

                const filesPreview = document.getElementById('review_files_preview');
                if (filesPreview) {
                    filesPreview.innerHTML = '';
                }

                const errorDiv = document.getElementById('review_error_message');
                if (errorDiv) {
                    errorDiv.style.display = 'none';
                }

                reviewFiles = [];
                orderItemsData = [];

                const productError = document.getElementById('product_select_error');
                if (productError) {
                    productError.style.display = 'none';
                }

                document.querySelectorAll('#reviewStars input').forEach(input => input.checked = false);
                const star1 = document.getElementById('review_star1');
                if (star1) {
                    star1.checked = true;
                }

                const select = document.getElementById('review_product_select');
                if (select) {
                    select.innerHTML = '<option value="">-- Loading products... --</option>';
                    select.disabled = true;
                }

                fetch(`/api/order-details/${orderId}`)
                    .then(res => {
                        if (!res.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return res.json();
                    })
                    .then(data => {
                        if (select) {
                            select.innerHTML = '<option value="">-- Select Product --</option>';
                            select.disabled = false;
                        }

                        if (data.success && data.order && data.order.items && data.order.items.length > 0) {
                            orderItemsData = data.order.items;

                            data.order.items.forEach((item) => {
                                const option = document.createElement('option');
                                option.value = parseInt(item.product_id);
                                option.textContent = item.product_name + ' (₹' + parseFloat(item.price)
                                    .toFixed(2) + ')';
                                if (select) {
                                    select.appendChild(option);
                                }
                            });

                            if (data.order.items.length === 1 && select) {
                                select.value = parseInt(data.order.items[0].product_id);
                            }
                        } else {
                            if (select) {
                                select.innerHTML = '<option value="">-- No products found --</option>';
                                select.disabled = true;
                            }
                        }
                    })
                    .catch(err => {
                        console.error('Error loading products:', err);
                        if (select) {
                            select.innerHTML = '<option value="">-- Error loading products --</option>';
                            select.disabled = false;
                        }
                        showMyOrdersToast('Error loading products', 'error');
                    });

                const modal = new bootstrap.Modal(document.getElementById('reviewModal'));
                modal.show();
            } catch (error) {
                console.error('Error in openReviewModal:', error);
                showMyOrdersToast('Error opening review modal', 'error');
            }
        }

        // ============================================================
        // ===== PREVIEW REVIEW FILES =====
        // ============================================================
        function previewReviewFiles(input) {
            const preview = document.getElementById('review_files_preview');
            if (!preview) return;

            const files = Array.from(input.files);

            files.forEach((file) => {
                reviewFiles.push(file);
                const reader = new FileReader();
                const fileIndex = reviewFiles.length - 1;
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'file-preview-item';
                    if (file.type.startsWith('image/')) {
                        div.innerHTML =
                            `<img src="${e.target.result}" alt="Preview"><button class="remove-file" onclick="removeReviewFile(this, ${fileIndex})">×</button>`;
                    } else if (file.type.startsWith('video/')) {
                        div.innerHTML =
                            `<video src="${e.target.result}"></video><button class="remove-file" onclick="removeReviewFile(this, ${fileIndex})">×</button>`;
                    }
                    preview.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        }

        // ============================================================
        // ===== REMOVE REVIEW FILE =====
        // ============================================================
        function removeReviewFile(button, index) {
            button.closest('.file-preview-item').remove();
            reviewFiles.splice(index, 1);
        }

        // ============================================================
        // ===== SUBMIT REVIEW =====
        // ============================================================
        async function submitReview() {
            try {
                const orderId = document.getElementById('review_order_id').value;
                const productSelect = document.getElementById('review_product_select');
                const productId = productSelect ? productSelect.value : null;
                const rating = document.querySelector('input[name="rating"]:checked');
                const description = document.getElementById('review_description').value;
                const errorDiv = document.getElementById('review_error_message');
                const submitBtn = document.getElementById('submitReviewBtn');

                let hasError = false;
                let errorMessages = [];

                if (!productId || productId === '' || productId === '0' || productId === 'null') {
                    const productError = document.getElementById('product_select_error');
                    if (productError) {
                        productError.style.display = 'block';
                    }
                    if (productSelect) {
                        productSelect.style.borderColor = 'red';
                    }
                    hasError = true;
                    errorMessages.push('Please select a product');
                } else {
                    const productError = document.getElementById('product_select_error');
                    if (productError) {
                        productError.style.display = 'none';
                    }
                    if (productSelect) {
                        productSelect.style.borderColor = '';
                    }
                }

                if (!rating) {
                    errorMessages.push('Please select a rating');
                    hasError = true;
                }

                if (!description || description.trim() === '') {
                    errorMessages.push('Please write a review description');
                    hasError = true;
                }

                if (hasError) {
                    if (errorDiv) {
                        errorDiv.style.display = 'block';
                        errorDiv.innerHTML = errorMessages.join('<br>');
                    } else {
                        showMyOrdersToast(errorMessages.join('\n'), 'error');
                    }
                    return;
                }

                if (errorDiv) {
                    errorDiv.style.display = 'none';
                }

                if (!submitBtn) {
                    showMyOrdersToast('Error: Submit button not found.', 'error');
                    return;
                }

                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
                submitBtn.disabled = true;

                const formData = new FormData();
                formData.append('order_id', orderId);
                formData.append('product_id', parseInt(productId));
                formData.append('rating', parseInt(rating.value));
                formData.append('description', description);

                if (reviewFiles && reviewFiles.length > 0) {
                    reviewFiles.forEach(function(file) {
                        formData.append('review_files[]', file);
                    });
                }

                const response = await fetch('/submit-product-review', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('reviewModal'));
                    if (modal) {
                        modal.hide();
                    }
                    showMyOrdersToast(data.message || 'Thank you! Your review has been submitted for approval.', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    if (errorDiv) {
                        errorDiv.style.display = 'block';
                        errorDiv.innerHTML = data.message || 'Error submitting review';
                    } else {
                        showMyOrdersToast(data.message || 'Error submitting review', 'error');
                    }
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            } catch (error) {
                console.error('Error in submitReview:', error);
                const errorDiv = document.getElementById('review_error_message');
                if (errorDiv) {
                    errorDiv.style.display = 'block';
                    errorDiv.innerHTML = 'Network error: ' + error.message;
                } else {
                    showMyOrdersToast('Network error: ' + error.message, 'error');
                }
                const submitBtn = document.getElementById('submitReviewBtn');
                if (submitBtn) {
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Submit Review';
                    submitBtn.disabled = false;
                }
            }
        }

        // ============================================================
        // ===== OPEN CANCEL MODAL =====
        // ============================================================
        function openCancelModalFromDetails() {
            if (currentOrderForCancel) {
                openCancelModal(currentOrderForCancel);
            } else {
                showMyOrdersToast('No order selected for cancellation', 'error');
            }
        }

        function openCancelModal(orderId) {
            currentCancelOrderId = orderId;
            document.getElementById('cancelOrderId').value = orderId;
            document.querySelectorAll('.reason-option').forEach(opt => {
                opt.classList.remove('selected');
                const radio = opt.querySelector('input[type="radio"]');
                if (radio) radio.checked = false;
            });
            document.getElementById('cancelComment').value = '';
            const modal = new bootstrap.Modal(document.getElementById('cancelModal'));
            modal.show();
        }

        // ============================================================
        // ===== SUBMIT CANCELLATION =====
        // ============================================================
        async function submitCancellation() {
            const orderId = document.getElementById('cancelOrderId').value;
            const selectedReason = document.querySelector('input[name="cancel_reason"]:checked');
            const comment = document.getElementById('cancelComment').value;

            if (!selectedReason) {
                showMyOrdersToast('Please select a reason for cancellation', 'error');
                return;
            }

            const submitBtn = document.querySelector('#cancelModal .btn-danger');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
            submitBtn.disabled = true;

            try {
                const response = await fetch('/cancel-order', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        order_id: orderId,
                        cancellation_reason: selectedReason.value,
                        cancellation_comment: comment
                    })
                });

                const data = await response.json();
                if (data.success) {
                    const cancelModal = bootstrap.Modal.getInstance(document.getElementById('cancelModal'));
                    const orderModal = bootstrap.Modal.getInstance(document.getElementById('orderDetailsModal'));
                    if (cancelModal) cancelModal.hide();
                    if (orderModal) orderModal.hide();
                    showMyOrdersToast('Your cancellation request has been submitted successfully!', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showMyOrdersToast(data.message || 'Error submitting cancellation request', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showMyOrdersToast('Network error. Please try again.', 'error');
            } finally {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        }

        // ============================================================
        // ===== VIEW ORDER DETAILS =====
        // ============================================================
        async function viewOrderDetails(orderId, button) {
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
            button.disabled = true;

            try {
                const response = await fetch(`/api/order-details/${orderId}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });
                const data = await response.json();
                if (data.success && data.order) {
                    currentOrderForCancel = orderId;
                    renderModalWithOrderData(data.order);
                    const modal = new bootstrap.Modal(document.getElementById('orderDetailsModal'));
                    modal.show();
                } else {
                    showMyOrdersToast(data.message || 'Error loading order details', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showMyOrdersToast('Error loading order details. Please try again.', 'error');
            } finally {
                button.innerHTML = originalText;
                button.disabled = false;
            }
        }

        // ============================================================
        // ===== RENDER MODAL WITH ORDER DATA =====
        // ============================================================
        function renderModalWithOrderData(order) {
            // Status steps
            const statusSteps = ['Pending', 'Confirmed', 'Shipped', 'Delivered'];
            const currentStatus = order.order_status;
            const currentIndex = statusSteps.indexOf(currentStatus);
            let stepsHtml = '';
            statusSteps.forEach((step, index) => {
                let stepClass = '';
                let stepIcon = '';
                if (index < currentIndex) {
                    stepClass = 'completed';
                    stepIcon = '<i class="fas fa-check"></i>';
                } else if (index === currentIndex) {
                    stepClass = 'active';
                    stepIcon = '<i class="fas fa-circle"></i>';
                } else {
                    stepIcon = '<i class="far fa-circle"></i>';
                }
                stepsHtml +=
                    `<div class="status-step ${stepClass}"><div class="step-icon">${stepIcon}</div><div class="step-label">${step.toUpperCase()}</div></div>`;
            });
            document.getElementById('statusSteps').innerHTML = stepsHtml;

            // Order Info
            document.getElementById('modalOrderNumber').innerText = order.order_number;
            document.getElementById('modalOrderDate').innerText = new Date(order.created_at).toLocaleDateString('en-IN', {
                day: 'numeric',
                month: 'long',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            document.getElementById('modalTransactionId').innerText = order.transaction_id || 'N/A';
            document.getElementById('modalOrderStatus').innerHTML =
                `<span class="order-status ${order.order_status}"><i class="fas fa-circle" style="font-size: 0.5rem;"></i> ${order.order_status.toUpperCase()}</span>`;

            // Customer Details
            document.getElementById('modalCustomerName').innerText = order.user?.name || 'N/A';
            document.getElementById('modalCustomerEmail').innerText = order.user?.email || 'N/A';
            document.getElementById('modalCustomerPhone').innerText = order.user?.phone || 'N/A';

            // Shipping Address
            let shippingHtml = '<div class="address-block">No address information available</div>';
            if (order.shipping_address) {
                let addr = order.shipping_address;
                let addressLines = [];
                if (addr.name && addr.name !== 'N/A' && addr.name !== '') addressLines.push('<strong>' + escapeHtml(addr
                    .name) + '</strong>');
                if (addr.address && addr.address !== '') addressLines.push(escapeHtml(addr.address));
                if (addr.area && addr.area !== '') addressLines.push(escapeHtml(addr.area));
                if (addr.city && addr.city !== '' && addr.state && addr.state !== '') addressLines.push(escapeHtml(addr
                    .city) + ', ' + escapeHtml(addr.state));
                else if (addr.city && addr.city !== '') addressLines.push(escapeHtml(addr.city));
                else if (addr.state && addr.state !== '') addressLines.push(escapeHtml(addr.state));
                if (addr.pincode && addr.pincode !== '') addressLines.push('Pincode: ' + escapeHtml(addr.pincode));
                if (addr.phone && addr.phone !== 'N/A' && addr.phone !== '') addressLines.push('Phone: ' + escapeHtml(addr
                    .phone));
                if (addressLines.length > 0) shippingHtml = '<div class="address-block">' + addressLines.join('<br>') +
                    '</div>';
            }
            document.getElementById('modalShippingAddress').innerHTML = shippingHtml;

            // ===== ORDER ITEMS WITH IMAGES =====
            let itemsHtml = '';
            let subtotal = 0;

            if (order.items && order.items.length > 0) {
                order.items.forEach(function(item) {
                    var itemTotal = parseFloat(item.price) * parseInt(item.quantity);
                    subtotal += itemTotal;

                    let imageUrl = null;

                    if (item.product_image && item.product_image !== '' && item.product_image !== null) {
                        imageUrl = item.product_image;
                    } else if (item.product_images && item.product_images.length > 0) {
                        const mainImg = item.product_images.find(img => img.is_main == 1);
                        imageUrl = mainImg ? mainImg.image_path : item.product_images[0].image_path;
                    } else if (item.image && item.image !== '' && item.image !== null) {
                        imageUrl = item.image;
                    } else if (item.product && item.product.images && item.product.images.length > 0) {
                        const mainImg = item.product.images.find(img => img.is_main == 1);
                        imageUrl = mainImg ? mainImg.image_path : item.product.images[0].image_path;
                    }

                    let imageHtml = '';
                    if (imageUrl) {
                        let fullUrl = imageUrl;
                        if (!imageUrl.startsWith('http') && !imageUrl.startsWith('/storage/')) {
                            fullUrl = '/storage/' + imageUrl;
                        }
                        if (imageUrl.startsWith('storage/')) {
                            fullUrl = '/' + imageUrl;
                        }
                        imageHtml =
                            `<img src="${fullUrl}" alt="${escapeHtml(item.product_name)}" onerror="this.parentElement.innerHTML='<div class=\\'no-image\\'><i class=\\'fas fa-box\\'></i></div>'">`;
                    } else {
                        imageHtml = `<div class="no-image"><i class="fas fa-box"></i></div>`;
                    }

                    itemsHtml += `
                        <div class="order-item-card">
                            <div class="order-item-image">
                                ${imageHtml}
                            </div>
                            <div class="order-item-details">
                                <div class="order-item-name">${escapeHtml(item.product_name)}</div>
                                <div class="order-item-price"><i class="fas fa-rupee-sign"></i> ${formatNumber(item.price)}</div>
                                <div class="order-item-quantity"><i class="fas fa-cube"></i> Quantity: ${item.quantity}</div>
                                ${item.variant_name ? `<div class="order-item-variant">Variant: ${escapeHtml(item.variant_name)}</div>` : ''}
                                ${item.size ? `<div class="order-item-variant">Size: ${escapeHtml(item.size)}</div>` : ''}
                                ${item.color ? `<div class="order-item-variant">Color: ${escapeHtml(item.color)}</div>` : ''}
                            </div>
                            <div class="order-item-total">₹${formatNumber(itemTotal)}</div>
                        </div>
                    `;
                });
            } else {
                itemsHtml = '<div class="text-muted">No items found</div>';
            }
            document.getElementById('modalOrderItems').innerHTML = itemsHtml;

            // ===== PAYMENT SUMMARY WITH SHIPPING =====
            const shippingCost = parseFloat(order.shipping_charge) || 0;
            const total = parseFloat(order.total_amount) || 0;
            const paymentMethod = order.payment_method || 'Unknown';
            const paymentStatus = order.payment_status;
            const paymentStatusText = paymentStatus === 'SUCCESS' ? 'PAID' : (paymentStatus === 'FAILED' ? 'FAILED' :
                'PENDING');
            const paymentStatusClass = paymentStatus === 'SUCCESS' ? 'payment-paid' : (paymentStatus === 'FAILED' ?
                'payment-failed' : 'payment-pending');

            let paymentMethodDisplay = 'Unknown';
            if (paymentMethod === 'cod') {
                paymentMethodDisplay = 'Cash on Delivery';
            } else if (paymentMethod === 'online' || paymentMethod === 'card' || paymentMethod === 'PayU' ||
                paymentMethod === 'payu') {
                paymentMethodDisplay = 'Online Payment (Card)';
            } else if (paymentMethod) {
                paymentMethodDisplay = paymentMethod;
            }

            let shippingDisplay = '';
            if (shippingCost > 0) {
                shippingDisplay = '₹' + formatNumber(shippingCost);
            } else {
                shippingDisplay = '<span class="shipping-free">FREE</span>';
            }

            const summaryHtml = `
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>₹${formatNumber(subtotal)}</span>
                </div>
                <div class="summary-row">
                    <span>Shipping</span>
                    <span>${shippingDisplay}</span>
                </div>
                <div class="summary-total">
                    <span>Total</span>
                    <span>₹${formatNumber(total)}</span>
                </div>
                <div class="summary-row mt-2" style="border-top: 1px solid var(--line); padding-top: 12px;">
                    <span>${paymentMethodDisplay}</span>
                    <span class="payment-badge ${paymentStatusClass}">${paymentStatusText}</span>
                </div>
            `;
            document.getElementById('modalPaymentSummary').innerHTML = summaryHtml;

            // ===== SHOW/HIDE CANCEL BUTTON =====
            const cancelBtn = document.getElementById('cancelOrderBtn');
            if (cancelBtn) {
                const cancelableStatuses = ['Pending', 'Confirmed'];
                if (!cancelableStatuses.includes(order.order_status)) {
                    cancelBtn.style.display = 'none';
                } else {
                    cancelBtn.style.display = 'inline-block';
                }
            }
        }

        // ============================================================
        // ===== CONTACT SUPPORT =====
        // ============================================================
        function contactSupport() {
            window.location.href = '{{ route('contact') }}';
        }

        // ============================================================
        // ===== HELPER FUNCTIONS =====
        // ============================================================
        function formatNumber(num) {
            if (num === undefined || num === null || isNaN(num)) return '0.00';
            return parseFloat(num).toLocaleString('en-IN', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        function escapeHtml(text) {
            if (!text) return '';
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    </script>
@endsection