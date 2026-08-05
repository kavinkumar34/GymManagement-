{{-- resources/views/cart.blade.php --}}
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

        /* ===== CART WRAPPER ===== */
        .cart-wrapper {
            background: var(--canvas);
            min-height: 70vh;
            padding: 2rem 0;
        }

        .cart-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* ===== CART GRID ===== */
        .cart-grid {
            display: grid;
            grid-template-columns: 1fr 420px;
            gap: 2rem;
        }

        @media (max-width: 992px) {
            .cart-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ===== CARDS ===== */
        .cart-items-card,
        .checkout-card {
            background: white;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
            overflow: hidden;
            padding: 1.5rem;
            border: 1px solid var(--line);
        }

        .cart-items-card:hover,
        .checkout-card:hover {
            box-shadow: var(--shadow-card-hover);
        }

        /* ===== CART ITEM ===== */
        .cart-item {
            display: grid;
            grid-template-columns: 100px 1fr auto;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid var(--line);
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item-image {
            width: 100px;
            height: 100px;
            border-radius: var(--radius-md);
            overflow: hidden;
            background: var(--fog);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--line);
        }

        .cart-item-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 8px;
            background: white;
        }

        .image-placeholder {
            font-size: 2.5rem;
            color: var(--steel);
        }

        .product-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--ink);
            text-decoration: none;
            font-family: var(--font-body);
        }

        .product-variant-details {
            font-size: 0.8rem;
            color: var(--steel);
            margin-top: 2px;
            font-weight: 500;
        }

        .product-price {
            font-size: 1rem;
            font-weight: 700;
            color: var(--ink);
            margin-top: 0.25rem;
        }

        .product-price .original-price {
            font-size: 0.85rem;
            color: var(--steel);
            text-decoration: line-through;
            font-weight: 400;
            margin-right: 8px;
        }

        .product-price .discount-tag {
            font-size: 0.7rem;
            background: var(--signal);
            color: white;
            padding: 1px 8px;
            border-radius: var(--radius-sm);
            margin-left: 6px;
            font-weight: 700;
        }

        /* ===== QUANTITY CONTROL ===== */
        .quantity-control {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--fog);
            border-radius: 40px;
            padding: 0.25rem;
            width: fit-content;
            margin-top: 0.5rem;
        }

        .qty-btn {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: none;
            background: white;
            cursor: pointer;
            font-weight: 700;
            transition: all 0.3s;
            font-size: 0.85rem;
            color: var(--ink);
        }

        .qty-btn:hover {
            background: var(--signal);
            color: white;
        }

        .qty-btn:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .qty-btn:disabled:hover {
            background: white;
            color: var(--ink);
        }

        .quantity-control span {
            font-weight: 700;
            min-width: 24px;
            text-align: center;
            color: var(--ink);
        }

        .item-total {
            font-weight: 700;
            font-size: 1rem;
            color: var(--ink);
            text-align: right;
        }

        .remove-item {
            background: none;
            border: none;
            color: var(--signal);
            cursor: pointer;
            font-size: 0.75rem;
            margin-top: 0.5rem;
            font-weight: 600;
            transition: all 0.3s;
        }

        .remove-item:hover {
            color: var(--signal-dark);
            text-decoration: underline;
        }

        /* ===== STOCK BADGE ===== */
        .stock-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.2rem 0.6rem;
            border-radius: 40px;
            font-size: 0.65rem;
            font-weight: 600;
            margin-top: 4px;
        }

        .stock-available {
            background: var(--success-tint);
            color: var(--success);
        }

        .stock-low {
            background: #fef9c3;
            color: #854d0e;
        }

        .stock-out {
            background: var(--signal-tint);
            color: var(--signal-dark);
        }

        /* ===== SUMMARY CARD ===== */
        .summary-card {
            background: white;
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            box-shadow: var(--shadow-card);
            border: 1px solid var(--line);
            position: sticky;
            top: 100px;
        }

        .summary-card:hover {
            box-shadow: var(--shadow-card-hover);
        }

        .summary-header {
            font-family: var(--font-display);
            font-weight: 400;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--line);
            margin-bottom: 1rem;
            color: var(--ink);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            color: var(--steel);
            font-size: 0.9rem;
            font-weight: 500;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            padding: 1rem 0;
            border-top: 2px solid var(--line);
            margin-top: 0.5rem;
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--ink);
        }

        /* ===== BUTTONS ===== */
        .btn-primary-custom {
            width: 100%;
            padding: 1rem;
            background: var(--signal);
            border: none;
            border-radius: 40px;
            color: white;
            font-weight: 700;
            font-size: 1rem;
            margin-top: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            font-family: var(--font-body);
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .btn-primary-custom:hover {
            background: var(--signal-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 68, 5, 0.3);
            color: white;
        }

        .btn-primary-custom:disabled {
            background: var(--steel);
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
            opacity: 0.6;
        }

        .btn-secondary-custom {
            width: 100%;
            padding: 0.75rem;
            background: transparent;
            border: 1px solid var(--line);
            border-radius: 40px;
            color: var(--steel);
            font-weight: 600;
            margin-top: 0.5rem;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            display: block;
            transition: all 0.3s;
            font-family: var(--font-body);
        }

        .btn-secondary-custom:hover {
            background: var(--fog);
            color: var(--ink);
        }

        /* ===== EMPTY CART ===== */
        .empty-cart-card {
            background: white;
            border-radius: var(--radius-lg);
            padding: 3rem;
            text-align: center;
            border: 1px solid var(--line);
            box-shadow: var(--shadow-card);
        }

        .empty-cart-icon {
            font-size: 5rem;
            color: var(--steel);
            margin-bottom: 1rem;
        }

        .empty-cart-card h3 {
            font-family: var(--font-display);
            font-weight: 400;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            color: var(--ink);
        }

        .empty-cart-card p {
            color: var(--steel);
            font-weight: 500;
        }

        /* ===== CART ACTIONS ===== */
        .cart-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
            flex-wrap: wrap;
        }

        .btn-update {
            padding: 0.5rem 1.5rem;
            background: var(--info);
            color: white;
            border: none;
            border-radius: 40px;
            cursor: pointer;
            font-weight: 700;
            font-size: 0.85rem;
            transition: all 0.3s;
            font-family: var(--font-body);
        }

        .btn-update:hover {
            background: var(--signal);
            transform: translateY(-2px);
            color: white;
        }

        .btn-clear {
            padding: 0.5rem 1.5rem;
            background: var(--signal);
            color: white;
            border: none;
            border-radius: 40px;
            cursor: pointer;
            font-weight: 700;
            font-size: 0.85rem;
            transition: all 0.3s;
            font-family: var(--font-body);
        }

        .btn-clear:hover {
            background: var(--signal-dark);
            transform: translateY(-2px);
            color: white;
        }

        /* ===== CHECKOUT SECTIONS ===== */
        .checkout-contact-section {
            background: white;
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--line);
            box-shadow: var(--shadow-card);
        }

        .checkout-contact-section .section-title,
        .delivery-address-section .section-title,
        .coupon-section-wrapper .section-title {
            font-family: var(--font-display);
            font-weight: 400;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            color: var(--ink);
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--line);
        }

        .checkout-contact-section .section-title i,
        .delivery-address-section .section-title i,
        .coupon-section-wrapper .section-title i {
            color: var(--signal);
        }

        .delivery-address-section {
            background: white;
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--line);
            box-shadow: var(--shadow-card);
        }

        .coupon-section-wrapper {
            background: white;
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--line);
            box-shadow: var(--shadow-card);
        }

        .order-summary-section .summary-card {
            background: white;
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            box-shadow: var(--shadow-card);
            border: 1px solid var(--line);
            position: sticky;
            top: 100px;
        }

        /* ===== FORM STYLES ===== */
        .form-group {
            margin-bottom: 0.8rem;
        }

        .form-group label {
            display: block;
            font-size: 0.8rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            color: var(--steel);
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .form-group label .required {
            color: var(--signal);
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 0.7rem;
            border: 1px solid var(--line);
            border-radius: var(--radius-sm);
            outline: none;
            font-size: 0.9rem;
            transition: border-color 0.3s;
            font-family: var(--font-body);
            background: white;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: var(--signal);
            box-shadow: 0 0 0 3px rgba(255, 68, 5, 0.1);
        }

        .form-group input[readonly] {
            background: var(--fog);
            cursor: not-allowed;
        }

        /* ===== CHECKOUT CONTACT FORM ===== */
        .checkout-contact-section .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        @media (max-width: 576px) {
            .checkout-contact-section .form-row {
                grid-template-columns: 1fr;
            }
        }

        /* ===== ADDRESS LIST ===== */
        .address-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            max-height: 350px;
            overflow-y: auto;
        }

        .address-list::-webkit-scrollbar {
            width: 4px;
        }

        .address-list::-webkit-scrollbar-track {
            background: var(--fog);
            border-radius: 10px;
        }

        .address-list::-webkit-scrollbar-thumb {
            background: var(--signal);
            border-radius: 10px;
        }

        .address-item {
            border: 2px solid var(--line);
            border-radius: var(--radius-md);
            padding: 0.75rem 1rem;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
        }

        .address-item.selected {
            border-color: var(--signal);
            background: var(--signal-tint);
        }

        .address-item:hover {
            border-color: var(--signal);
        }

        .address-name {
            font-weight: 700;
            color: var(--ink);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.5rem;
            font-size: 0.9rem;
        }

        .address-details {
            color: var(--steel);
            font-size: 0.8rem;
            margin-top: 0.3rem;
            line-height: 1.5;
        }

        .address-phone {
            margin-top: 0.3rem;
            color: var(--steel);
            font-size: 0.75rem;
        }

        .address-item .radio-select {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            border: 2px solid var(--line);
            flex-shrink: 0;
            display: inline-block;
            vertical-align: middle;
        }

        .address-item.selected .radio-select {
            border-color: var(--signal);
            background: var(--signal);
            box-shadow: inset 0 0 0 4px white;
        }

        .address-item .address-radio-wrapper {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .address-item .address-content {
            flex: 1;
        }

        .address-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 0.3rem;
        }

        .btn-address-edit {
            background: var(--info-tint);
            color: var(--info);
            border: none;
            padding: 2px 12px;
            border-radius: 20px;
            font-size: 0.65rem;
            cursor: pointer;
            font-weight: 700;
            transition: all 0.3s;
        }

        .btn-address-edit:hover {
            background: var(--info);
            color: white;
        }

        .btn-address-delete {
            background: var(--signal-tint);
            color: var(--signal-dark);
            border: none;
            padding: 2px 12px;
            border-radius: 20px;
            font-size: 0.65rem;
            cursor: pointer;
            font-weight: 700;
            transition: all 0.3s;
        }

        .btn-address-delete:hover {
            background: var(--signal);
            color: white;
        }

        .add-address-toggle {
            color: var(--signal);
            cursor: pointer;
            font-weight: 700;
            font-size: 0.85rem;
            margin-top: 0.5rem;
            display: inline-block;
            font-family: var(--font-body);
        }

        .add-address-toggle:hover {
            text-decoration: underline;
        }

        /* ===== ADD ADDRESS FORM ===== */
        .add-address-form {
            margin-top: 1rem;
            padding: 1rem;
            background: var(--fog);
            border-radius: var(--radius-md);
            display: none;
            border: 1px solid var(--line);
        }

        .add-address-form.show {
            display: block;
        }

        .btn-add-address {
            background: var(--signal);
            color: white;
            border: none;
            padding: 0.75rem;
            border-radius: var(--radius-sm);
            cursor: pointer;
            width: 100%;
            font-weight: 700;
            transition: all 0.3s;
            font-family: var(--font-body);
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .btn-add-address:hover {
            background: var(--signal-dark);
            transform: translateY(-2px);
            color: white;
        }

        /* ===== SHIPPING CHARGE DISPLAY ===== */
        .shipping-charge-display {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            font-size: 0.85rem;
            color: var(--steel);
            border-top: 1px dashed var(--line);
            margin-top: 0.5rem;
            padding-top: 0.5rem;
        }

        .shipping-charge-display .charge-amount {
            font-weight: 700;
            color: var(--ink);
        }

        /* ===== ORDER SUMMARY IN CHECKOUT ===== */
        .order-summary-section .summary-card .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--line);
            margin-bottom: 1rem;
        }

        .order-summary-section .summary-card .order-header h4 {
            font-family: var(--font-display);
            font-weight: 400;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin: 0;
            color: var(--ink);
        }

        .order-summary-section .summary-card .order-header .order-count {
            font-size: 0.85rem;
            color: var(--steel);
            font-weight: 500;
        }

        .order-summary-section .summary-card .order-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.5rem 0;
            border-bottom: 1px solid var(--line);
        }

        .order-summary-section .summary-card .order-item:last-child {
            border-bottom: none;
        }

        .order-summary-section .summary-card .order-item .item-img {
            width: 48px;
            height: 48px;
            border-radius: var(--radius-sm);
            overflow: hidden;
            background: var(--fog);
            flex-shrink: 0;
            border: 1px solid var(--line);
        }

        .order-summary-section .summary-card .order-item .item-img img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 4px;
            background: white;
        }

        .order-summary-section .summary-card .order-item .item-info {
            flex: 1;
        }

        .order-summary-section .summary-card .order-item .item-info .item-name {
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--ink);
        }

        .order-summary-section .summary-card .order-item .item-info .item-details {
            font-size: 0.75rem;
            color: var(--steel);
        }

        .order-summary-section .summary-card .order-item .item-price {
            font-weight: 700;
            font-size: 0.85rem;
            color: var(--ink);
        }

        /* ===== PAYMENT METHODS ===== */
        .payment-methods {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .payment-option {
            border: 2px solid var(--line);
            border-radius: var(--radius-md);
            padding: 0.75rem 1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.3s;
        }

        .payment-option.selected {
            border-color: var(--signal);
            background: var(--signal-tint);
        }

        .payment-option.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
        }

        .payment-icon {
            width: 36px;
            height: 36px;
            background: var(--fog);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            color: var(--steel);
        }

        .payment-option.selected .payment-icon {
            background: var(--signal);
            color: white;
        }

        .payment-info {
            flex: 1;
        }

        .payment-name {
            font-weight: 700;
            color: var(--ink);
            font-size: 0.9rem;
        }

        .payment-desc {
            font-size: 0.7rem;
            color: var(--steel);
        }

        .payment-option .radio-select {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            border: 2px solid var(--line);
            flex-shrink: 0;
        }

        .payment-option.selected .radio-select {
            border-color: var(--signal);
            background: var(--signal);
            box-shadow: inset 0 0 0 4px white;
        }

        .cod-not-available-badge {
            background: var(--signal-tint);
            color: var(--signal-dark);
            font-size: 0.65rem;
            padding: 2px 10px;
            border-radius: 20px;
            font-weight: 700;
        }

        /* ===== COUPON SECTION ===== */
        .coupon-section {
            margin: 0.5rem 0;
            display: flex;
            gap: 0.5rem;
            align-items: center;
            background: var(--fog);
            padding: 0.75rem 1rem;
            border-radius: var(--radius-sm);
            border: 1px dashed var(--line);
        }

        .coupon-section select {
            flex: 1;
            padding: 0.6rem 1rem;
            border: 1px solid var(--line);
            border-radius: var(--radius-sm);
            font-size: 0.85rem;
            background: white;
            cursor: pointer;
            appearance: auto;
            min-width: 150px;
            font-family: var(--font-body);
        }

        .coupon-section select:focus {
            outline: none;
            border-color: var(--signal);
            box-shadow: 0 0 0 3px rgba(255, 68, 5, 0.1);
        }

        .coupon-section .coupon-icon {
            color: var(--signal);
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .coupon-section .btn-apply-coupon {
            padding: 0.6rem 1.5rem;
            background: var(--signal);
            color: white;
            border: none;
            border-radius: var(--radius-sm);
            cursor: pointer;
            font-weight: 700;
            font-size: 0.85rem;
            white-space: nowrap;
            transition: all 0.3s;
            font-family: var(--font-body);
        }

        .coupon-section .btn-apply-coupon:hover {
            background: var(--signal-dark);
            transform: translateY(-2px);
        }

        .coupon-section .btn-apply-coupon:disabled {
            background: var(--steel);
            cursor: not-allowed;
            transform: none;
        }

        .coupon-applied {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--success-tint);
            padding: 0.5rem 1rem;
            border-radius: var(--radius-sm);
            font-size: 0.85rem;
            color: var(--success);
            font-weight: 600;
        }

        .coupon-applied .remove-coupon {
            color: var(--signal);
            cursor: pointer;
            font-weight: 700;
            margin-left: 0.5rem;
        }

        .coupon-applied .remove-coupon:hover {
            text-decoration: underline;
        }

        /* ===== SECURE CHECKOUT FOOTER ===== */
        .secure-checkout-footer {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 0.75rem;
            font-size: 0.7rem;
            color: var(--steel);
            flex-wrap: wrap;
        }

        .secure-checkout-footer span {
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .secure-checkout-footer span i {
            color: var(--signal);
        }

        /* ===== CUSTOM ALERT ===== */
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

        @media (max-width: 768px) {
            .cart-item {
                grid-template-columns: 80px 1fr;
                gap: 0.75rem;
            }

            .cart-item-image {
                width: 80px;
                height: 80px;
            }

            .cart-item>div:last-child {
                grid-column: 2;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .item-total {
                text-align: left;
            }

            .summary-card {
                position: static;
            }

            .order-summary-section .summary-card {
                position: static;
            }

            .cart-grid {
                gap: 1rem;
            }

            .cart-items-card,
            .checkout-card {
                padding: 1rem;
            }

            .page-header-custom {
                padding: 20px;
                flex-direction: column;
                text-align: center;
            }

            .page-header-custom .header-stats {
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .cart-container {
                padding: 0 0.75rem;
            }

            .cart-item {
                grid-template-columns: 70px 1fr;
                padding: 0.75rem 0;
            }

            .cart-item-image {
                width: 70px;
                height: 70px;
            }

            .product-title {
                font-size: 0.85rem;
            }

            .product-price {
                font-size: 0.85rem;
            }

            .quantity-control {
                padding: 0.15rem;
            }

            .qty-btn {
                width: 24px;
                height: 24px;
                font-size: 0.75rem;
            }

            .summary-header {
                font-size: 0.95rem;
            }

            .btn-primary-custom {
                font-size: 0.85rem;
                padding: 0.75rem;
            }

            .payment-option {
                padding: 0.5rem 0.75rem;
                gap: 0.5rem;
            }

            .payment-icon {
                width: 30px;
                height: 30px;
                font-size: 0.9rem;
            }

            .payment-name {
                font-size: 0.8rem;
            }

            .payment-desc {
                font-size: 0.65rem;
            }

            .coupon-section {
                flex-wrap: wrap;
            }

            .coupon-section select {
                min-width: 100%;
            }

            .coupon-section .btn-apply-coupon {
                width: 100%;
            }

            .address-item {
                padding: 0.5rem 0.75rem;
            }

            .address-name {
                font-size: 0.8rem;
            }

            .address-details {
                font-size: 0.7rem;
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

            .cart-actions .btn-update,
            .cart-actions .btn-clear {
                font-size: 0.7rem;
                padding: 0.4rem 1rem;
            }

            .empty-cart-card {
                padding: 2rem 1rem;
            }

            .empty-cart-icon {
                font-size: 3.5rem;
            }
        }

        @media (max-width: 400px) {
            .cart-item {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .cart-item-image {
                width: 80px;
                height: 80px;
                margin: 0 auto;
            }

            .cart-item>div:last-child {
                grid-column: 1;
                justify-content: center;
                flex-direction: column;
                align-items: center;
            }

            .quantity-control {
                margin: 0.5rem auto;
            }

            .item-total {
                text-align: center;
            }

            .remove-item {
                margin-top: 0.25rem;
            }

            .product-price {
                text-align: center;
            }

            .product-variant-details {
                text-align: center;
            }

            .stock-badge {
                justify-content: center;
            }
        }
    </style>

    <!-- ===== CUSTOM ALERT OVERLAY ===== -->
    <div class="custom-alert-overlay" id="customAlertOverlay">
        <div class="custom-alert-box">
            <div class="alert-icon warning" id="alertIcon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="alert-title" id="alertTitle">Alert</div>
            <div class="alert-message" id="alertMessage">Message</div>
            <div class="alert-buttons">
                <button class="alert-btn alert-btn-primary" onclick="closeCustomAlert()">OK</button>
            </div>
        </div>
    </div>

    <div class="cart-wrapper">
        <div class="cart-container">
            <div id="cartContainer">
                <!-- Dynamic content will be injected here -->
            </div>
        </div>
    </div>

    <script>
        // ================================================================
        // ===== CUSTOM ALERT FUNCTIONS =====
        // ================================================================
        function showCustomAlert(title, message, type = 'warning', buttonText = 'OK', buttonLink = null) {
            const overlay = document.getElementById('customAlertOverlay');
            const icon = document.getElementById('alertIcon');
            const titleEl = document.getElementById('alertTitle');
            const messageEl = document.getElementById('alertMessage');
            const buttons = document.querySelector('.custom-alert-box .alert-buttons');

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

            if (buttonLink) {
                buttons.innerHTML =
                    `<a href="${buttonLink}" class="alert-btn alert-btn-primary">${buttonText}</a>`;
            } else {
                buttons.innerHTML =
                    `<button class="alert-btn alert-btn-primary" onclick="closeCustomAlert()">${buttonText}</button>`;
            }

            overlay.classList.add('show');
        }

        function closeCustomAlert() {
            document.getElementById('customAlertOverlay').classList.remove('show');
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && document.getElementById('customAlertOverlay').classList.contains('show')) {
                closeCustomAlert();
            }
        });

        // Get CSRF token from meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
            '{{ csrf_token() }}';

        // Global variables
        let productStock = {};
        let productImages = {};
        let productData = {};
        let currentPage = 'cart';
        let selectedAddress = null;
        let selectedPayment = null;
        let savedAddresses = [];
        let cartData = [];
        let loggedInUser = null;
        let userEmail = '';
        let userId = null;
        let selectedState = null;
        let shippingCharge = 0;
        let deliverableStates = [];
        let isEditingAddress = false;
        let editingAddressIndex = null;
        let showAddressForm = false;
        let editAddressData = null;
        let couponCode = null;
        let couponDiscount = 0;
        let codAvailable = true;

        // ============ LOAD DELIVERABLE STATES ============
        async function loadDeliverableStates() {
            try {
                const response = await fetch('/api/deliverable-pincodes');
                const data = await response.json();
                if (data.success && data.pincodes) {
                    deliverableStates = data.pincodes;
                    selectedState = null;
                    shippingCharge = 0;
                }
            } catch (error) {
                console.error('Error loading states:', error);
                let savedStates = localStorage.getItem('deliverable_states');
                if (savedStates) {
                    try {
                        deliverableStates = JSON.parse(savedStates);
                        selectedState = null;
                        shippingCharge = 0;
                    } catch (e) {}
                }
            }
        }

        // ============ USER API FUNCTIONS ============
        async function getLoggedInUser() {
            try {
                const response = await fetch('/api/user');
                const data = await response.json();
                if (data.success && data.user) {
                    loggedInUser = data.user;
                    userEmail = data.user.email;
                    userId = data.user.id;
                    return true;
                }
                return false;
            } catch (error) {
                console.error('Error fetching user:', error);
                return false;
            }
        }

        async function loadAddressesFromDatabase() {
            try {
                const response = await fetch('/api/user-addresses');
                const data = await response.json();
                if (data.success && data.addresses && data.addresses.length > 0) {
                    savedAddresses = data.addresses;
                    localStorage.setItem('user_addresses', JSON.stringify(savedAddresses));
                    if (!selectedAddress && savedAddresses.length > 0) {
                        selectedAddress = savedAddresses[0];
                        const addrState = savedAddresses[0].state;
                        const stateData = deliverableStates.find(s => s.state === addrState);
                        if (stateData) {
                            selectedState = stateData;
                            shippingCharge = parseFloat(stateData.shipping_charge) || 0;
                        }
                    }
                } else {
                    let saved = localStorage.getItem('user_addresses');
                    if (saved && JSON.parse(saved).length > 0) {
                        savedAddresses = JSON.parse(saved);
                        if (!selectedAddress && savedAddresses.length > 0) {
                            selectedAddress = savedAddresses[0];
                            const addrState = savedAddresses[0].state;
                            const stateData = deliverableStates.find(s => s.state === addrState);
                            if (stateData) {
                                selectedState = stateData;
                                shippingCharge = parseFloat(stateData.shipping_charge) || 0;
                            }
                        }
                    } else {
                        savedAddresses = [];
                    }
                }
            } catch (error) {
                console.error('Error loading addresses:', error);
                let saved = localStorage.getItem('user_addresses');
                if (saved) {
                    savedAddresses = JSON.parse(saved);
                    if (!selectedAddress && savedAddresses.length > 0) {
                        selectedAddress = savedAddresses[0];
                    }
                } else {
                    savedAddresses = [];
                }
            }
        }

        async function saveAddressToDatabase(address) {
            try {
                const response = await fetch('/api/user-addresses', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(address)
                });
                const data = await response.json();
                if (data.success && data.address) {
                    return data.address;
                }
                return null;
            } catch (error) {
                console.error('Error saving address:', error);
                return null;
            }
        }

        async function deleteAddressFromDatabase(addressId) {
            try {
                const response = await fetch(`/api/user-addresses/${addressId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });
                const data = await response.json();
                return data.success;
            } catch (error) {
                console.error('Error deleting address:', error);
                return false;
            }
        }

        function saveAddressesToLocal() {
            localStorage.setItem('user_addresses', JSON.stringify(savedAddresses));
        }

        // ============ CHECK COD AVAILABILITY ============
        function checkCodAvailability() {
            for (const item of cartData) {
                const product = productData[item.id];
                if (product && Number(product.cod_available) === 0) {
                    return false;
                }
            }
            return true;
        }

        // ============ PRODUCT DATA FUNCTIONS ============
        async function loadProductsData() {
            try {
                const cart = JSON.parse(localStorage.getItem('cart')) || [];
                if (cart.length === 0) return;

                const response = await fetch('/api/products');
                const products = await response.json();

                let productsArray = [];
                if (Array.isArray(products)) {
                    productsArray = products;
                } else if (products.data && Array.isArray(products.data)) {
                    productsArray = products.data;
                }

                if (productsArray.length > 0) {
                    productsArray.forEach(product => {
                        if (product.id) {
                            productData[product.id] = product;
                            let stock = 0;
                            if (product.variants && product.variants.length > 0) {
                                product.variants.forEach(v => {
                                    stock += parseInt(v.stock) || 0;
                                });
                            } else {
                                stock = parseInt(product.stock) || 0;
                            }
                            productStock[product.id] = stock;

                            let imageUrl = null;
                            if (product.product_images && product.product_images.length > 0) {
                                const sortedImages = [...product.product_images].sort((a, b) => {
                                    if (a.is_main !== b.is_main) return b.is_main - a.is_main;
                                    return (a.display_order || 0) - (b.display_order || 0);
                                });
                                if (product.variants && product.variants.length > 0) {
                                    const firstVariant = product.variants[0];
                                    const variantImage = sortedImages.find(img => img.variant_id == firstVariant
                                        .id);
                                    if (variantImage) {
                                        imageUrl = '/storage/' + variantImage.image_path;
                                    } else if (sortedImages.length > 0) {
                                        imageUrl = '/storage/' + sortedImages[0].image_path;
                                    }
                                } else {
                                    if (sortedImages.length > 0) {
                                        imageUrl = '/storage/' + sortedImages[0].image_path;
                                    }
                                }
                            }
                            if (!imageUrl && product.image) {
                                imageUrl = '/storage/' + product.image;
                            }
                            if (imageUrl) {
                                productImages[product.id] = imageUrl;
                            }
                        }
                    });
                }

                codAvailable = checkCodAvailability();

                cart.forEach(item => {
                    if (productStock[item.id] === undefined || productStock[item.id] === null) {
                        productStock[item.id] = 0;
                    }
                });

                renderPage();

            } catch (error) {
                console.error('Error loading products:', error);
                const cart = JSON.parse(localStorage.getItem('cart')) || [];
                cart.forEach(item => {
                    productStock[item.id] = 0;
                });
                renderPage();
            }
        }

        function getVariantBySizeColor(productId, size, color) {
            const product = productData[productId];
            if (!product || !product.variants) return null;

            return product.variants.find(v =>
                v.size === size && v.color === color
            ) || null;
        }

        // ============ HELPER FUNCTIONS ============
        function getSubtotal() {
            let subtotal = 0;
            for (let item of cartData) {
                subtotal += parseFloat(item.price) * item.quantity;
            }
            return subtotal;
        }

        function getTotalItems() {
            return cartData.reduce((sum, item) => sum + item.quantity, 0);
        }

        function checkStockIssues() {
            for (let item of cartData) {
                let stock = productStock[item.id] || 0;
                if (item.quantity > stock || stock <= 0) {
                    return true;
                }
            }
            return false;
        }

        function getTotalWithShipping() {
            return getSubtotal() + shippingCharge - parseFloat(couponDiscount || 0);
        }

        function updateNavbarCartCount() {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            let count = cart.reduce((sum, item) => sum + item.quantity, 0);
            let badge = document.getElementById('navbarCartCount');
            if (badge) {
                badge.innerText = count > 0 ? count : '';
                badge.style.display = count > 0 ? 'inline-flex' : 'none';
            }
        }

        function escapeHtml(text) {
            if (!text) return '';
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // ============ NAVIGATION ============
        function goToCheckout() {
            if (checkStockIssues()) {
                showCustomAlert('⚠️ Stock Issue', 'Some items have stock issues. Please check your cart.', 'warning');
                return;
            }
            currentPage = 'checkout';
            showAddressForm = false;
            renderPage();
        }

        function goToCart() {
            currentPage = 'cart';
            showAddressForm = false;
            renderPage();
        }

        // ============ ADDRESS FUNCTIONS ============
        function selectAddress(index) {
            selectedAddress = savedAddresses[index];
            const addrState = savedAddresses[index].state;
            const stateData = deliverableStates.find(s => s.state === addrState);
            if (stateData) {
                selectedState = stateData;
                shippingCharge = parseFloat(stateData.shipping_charge) || 0;
            } else {
                selectedState = null;
                shippingCharge = 0;
            }
            showAddressForm = false;
            renderPage();
        }

        function editAddress(index) {
            let addr = savedAddresses[index];
            isEditingAddress = true;
            editingAddressIndex = index;
            editAddressData = {
                address: addr.address || '',
                city: addr.city || '',
                pincode: addr.pincode || '',
                state: addr.state || ''
            };
            showAddressForm = true;
            renderPage();
        }

        function deleteAddress(index) {
            let address = savedAddresses[index];
            if (address.id) {
                deleteAddressFromDatabase(address.id);
            }
            savedAddresses.splice(index, 1);
            saveAddressesToLocal();
            if (selectedAddress && selectedAddress.id === address.id) {
                selectedAddress = savedAddresses.length > 0 ? savedAddresses[0] : null;
                if (selectedAddress) {
                    const addrState = selectedAddress.state;
                    const stateData = deliverableStates.find(s => s.state === addrState);
                    if (stateData) {
                        selectedState = stateData;
                        shippingCharge = parseFloat(stateData.shipping_charge) || 0;
                    }
                } else {
                    selectedState = null;
                    shippingCharge = 0;
                }
            }
            showAddressForm = false;
            renderPage();
        }

        function showAddAddressForm() {
            showAddressForm = true;
            isEditingAddress = false;
            editingAddressIndex = null;
            editAddressData = null;
            renderPage();
        }

        function hideAddAddressForm() {
            showAddressForm = false;
            isEditingAddress = false;
            editingAddressIndex = null;
            editAddressData = null;
            renderPage();
        }

        function updateShippingFromForm() {
            const stateSelect = document.getElementById('newState');
            if (stateSelect) {
                const stateId = stateSelect.value;
                const stateData = deliverableStates.find(s => s.id == stateId);
                if (stateData) {
                    selectedState = stateData;
                    shippingCharge = parseFloat(stateData.shipping_charge) || 0;
                }
                renderPage();
            }
        }

        function saveNewAddress() {
            const address = document.getElementById('newBuilding').value.trim();
            const city = document.getElementById('newCity').value.trim();
            const pincode = document.getElementById('newPincode').value.trim();
            const stateSelect = document.getElementById('newState');
            const stateId = stateSelect ? stateSelect.value : '';
            const stateName = stateSelect ? stateSelect.options[stateSelect.selectedIndex]?.text?.split(' (')[0] || '' : '';

            if (!address || !city || !pincode || !stateId) {
                showCustomAlert('❌ Required', 'Please fill all required fields', 'warning');
                return false;
            }

            if (pincode.length < 6) {
                showCustomAlert('❌ Invalid', 'Please enter a valid 6-digit pincode', 'warning');
                return false;
            }

            const selectedStateData = deliverableStates.find(s => s.id == stateId);
            if (selectedStateData) {
                selectedState = selectedStateData;
                shippingCharge = parseFloat(selectedStateData.shipping_charge) || 0;
            }

            const addressData = {
                user_id: userId,
                name: loggedInUser?.name || '',
                email: userEmail,
                address: address,
                city: city,
                state: stateName,
                pincode: pincode,
                phone: loggedInUser?.phone || '',
                is_default: savedAddresses.length === 0 ? 1 : 0
            };

            if (isEditingAddress && editingAddressIndex !== null) {
                const existingAddress = savedAddresses[editingAddressIndex];
                savedAddresses[editingAddressIndex] = {
                    ...existingAddress,
                    ...addressData
                };
                saveAddressesToLocal();
                if (selectedAddress && selectedAddress.id === existingAddress.id) {
                    selectedAddress = savedAddresses[editingAddressIndex];
                }
                showAddressForm = false;
                isEditingAddress = false;
                editingAddressIndex = null;
                editAddressData = null;
                renderPage();
                showCustomAlert('✅ Success', 'Address updated successfully!', 'success');
                return true;
            } else {
                saveAddressToDatabase(addressData).then(saved => {
                    if (saved) {
                        savedAddresses.push(saved);
                        saveAddressesToLocal();
                        selectedAddress = saved;
                        showAddressForm = false;
                        renderPage();
                        showCustomAlert('✅ Success', 'Address added successfully!', 'success');
                    } else {
                        savedAddresses.push(addressData);
                        saveAddressesToLocal();
                        selectedAddress = addressData;
                        showAddressForm = false;
                        renderPage();
                        showCustomAlert('✅ Success', 'Address added successfully!', 'success');
                    }
                });
                return true;
            }
        }

        function selectPayment(method) {
            selectedPayment = method;
            renderPage();
        }

        // ============ COUPON FUNCTIONS ============
        async function loadAvailableCoupons() {
            try {
                const response = await fetch('/api/available-coupons', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });

                const data = await response.json();
                const select = document.getElementById('couponSelect');

                if (!select) return;

                if (data.success && data.coupons && data.coupons.length > 0) {
                    let options = '<option value="">-- Select a coupon --</option>';
                    data.coupons.forEach(coupon => {
                        options += `<option value="${coupon.code}">${coupon.code}</option>`;
                    });
                    select.innerHTML = options;
                } else {
                    select.innerHTML = '<option value="">No coupons available</option>';
                }
            } catch (error) {
                console.error('Error loading coupons:', error);
                const select = document.getElementById('couponSelect');
                if (select) {
                    select.innerHTML = '<option value="">Error loading coupons</option>';
                }
            }
        }

        async function applyCouponFromDropdown() {
            const select = document.getElementById('couponSelect');
            if (!select) {
                showCustomAlert('❌ Error', 'Coupon selection not found', 'warning');
                return;
            }

            const code = select.value;

            if (!code) {
                showCustomAlert('❌ Error', 'Please select a coupon from the dropdown', 'warning');
                return;
            }

            const btn = document.getElementById('applyCouponBtn');
            if (btn) {
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                btn.disabled = true;
            }

            try {
                const subtotal = getSubtotal();
                const response = await fetch('/api/validate-coupon', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        code: code,
                        subtotal: subtotal
                    })
                });

                const data = await response.json();

                if (btn) {
                    btn.innerHTML = 'Apply';
                    btn.disabled = false;
                }

                if (data.success) {
                    couponCode = data.coupon.code;
                    couponDiscount = parseFloat(data.discount) || 0;
                    renderPage();
                    showCustomAlert('✅ Coupon Applied!', `You saved ₹${couponDiscount.toFixed(2)}`, 'success');
                } else {
                    showCustomAlert('❌ Invalid Coupon', data.message || 'Invalid coupon code', 'warning');
                    couponCode = null;
                    couponDiscount = 0;
                    renderPage();
                }
            } catch (error) {
                console.error('Error applying coupon:', error);
                if (btn) {
                    btn.innerHTML = 'Apply';
                    btn.disabled = false;
                }
                showCustomAlert('❌ Error', 'Error applying coupon. Please try again.', 'warning');
            }
        }

        function removeCoupon() {
            couponCode = null;
            couponDiscount = 0;
            renderPage();
            showCustomAlert('✅ Removed', 'Coupon removed successfully', 'info');
        }

        // ============ CART OPERATIONS ============
        window.updateQty = function(index, change) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            if (index >= cart.length) return;

            let item = cart[index];
            let stock = productStock[item.id] || 0;

            let newQty = item.quantity + change;

            if (newQty < 1) {
                if (confirm(`Remove "${item.name}" from your cart?`)) {
                    cart.splice(index, 1);
                } else {
                    return;
                }
            } else if (newQty > stock && stock > 0) {
                showCustomAlert('⚠️ Stock Limit', `Sorry, only ${stock} items available!`, 'warning');
                return;
            } else {
                item.quantity = newQty;
            }

            localStorage.setItem('cart', JSON.stringify(cart));
            cartData = cart;
            renderPage();
            updateNavbarCartCount();
        };

        window.removeItem = function(index) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            if (index >= cart.length) return;

            let item = cart[index];
            cart.splice(index, 1);
            localStorage.setItem('cart', JSON.stringify(cart));
            cartData = cart;
            if (cartData.length === 0) {
                currentPage = 'cart';
            }
            renderPage();
            updateNavbarCartCount();
            showCustomAlert('🗑️ Removed', `"${item.name}" removed from cart`, 'info');
        };

        window.clearCart = function() {
            localStorage.removeItem('cart');
            cartData = [];
            renderPage();
            updateNavbarCartCount();
            showCustomAlert('🗑️ Cleared', 'Cart cleared successfully', 'info');
        };

        window.updateCart = function() {
            renderPage();
            showCustomAlert('✅ Updated', 'Cart updated successfully!', 'success');
        };

        // ============ PLACE ORDER ============
        async function placeOrder() {
            if (checkStockIssues()) {
                showCustomAlert('⚠️ Stock Issue', 'Some items are out of stock or quantity exceeds available stock!',
                    'warning');
                return;
            }

            if (selectedPayment === 'cod' && !codAvailable) {
                showCustomAlert('⚠️ COD Unavailable',
                    'Cash on Delivery is not available for this order. Please select Online Payment.',
                    'warning');
                return;
            }

            if (!selectedPayment) {
                showCustomAlert('⚠️ Payment Required', 'Please select a payment method', 'warning');
                return;
            }

            if (!selectedState) {
                showCustomAlert('⚠️ Address Required', 'Please select a state in the address section', 'warning');
                return;
            }

            const address = document.getElementById('newBuilding');
            const city = document.getElementById('newCity');
            const pincode = document.getElementById('newPincode');
            const stateSelect = document.getElementById('newState');

            if (address && address.value.trim() && city && city.value.trim() && pincode && pincode.value.trim()) {
                const saved = saveNewAddress();
                if (!saved) return;
            }

            if (!selectedAddress) {
                showCustomAlert('⚠️ Address Required', 'Please add a delivery address', 'warning');
                return;
            }

            let checkoutBtn = document.querySelector('.place-order-btn');
            if (checkoutBtn) {
                checkoutBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Placing Order...';
                checkoutBtn.disabled = true;
            }

            const subtotal = getSubtotal();
            const totalWithShipping = getTotalWithShipping();

            const orderData = {
                cart: cartData,
                address: selectedAddress,
                state_id: selectedState ? selectedState.id : '',
                shipping_charge: shippingCharge,
                shipping_state: selectedState,
                subtotal: subtotal,
                total_amount: totalWithShipping,
                coupon_code: couponCode || null,
                coupon_discount: parseFloat(couponDiscount || 0),
                payment_method: selectedPayment
            };

            try {
                const saveResponse = await fetch('/api/set-checkout-cart', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        cart: cartData,
                        total_amount: totalWithShipping,
                        shipping_charge: shippingCharge,
                        coupon_discount: parseFloat(couponDiscount || 0),
                        coupon_code: couponCode
                    })
                });

                const saveData = await saveResponse.json();

                if (saveData.success) {
                    const form = document.createElement('form');
                    form.method = 'POST';

                    if (selectedPayment === 'cod') {
                        form.action = '/place-cod-order';
                    } else {
                        form.action = '/buy-now';
                    }

                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken;
                    form.appendChild(csrfInput);

                    const totalInput = document.createElement('input');
                    totalInput.type = 'hidden';
                    totalInput.name = 'total_amount';
                    totalInput.value = totalWithShipping;
                    form.appendChild(totalInput);

                    const subtotalInput = document.createElement('input');
                    subtotalInput.type = 'hidden';
                    subtotalInput.name = 'subtotal';
                    subtotalInput.value = subtotal;
                    form.appendChild(subtotalInput);

                    const shippingInput = document.createElement('input');
                    shippingInput.type = 'hidden';
                    shippingInput.name = 'shipping_charge';
                    shippingInput.value = shippingCharge;
                    form.appendChild(shippingInput);

                    if (couponCode) {
                        const couponInput = document.createElement('input');
                        couponInput.type = 'hidden';
                        couponInput.name = 'coupon_code';
                        couponInput.value = couponCode;
                        form.appendChild(couponInput);

                        const couponDiscountInput = document.createElement('input');
                        couponDiscountInput.type = 'hidden';
                        couponDiscountInput.name = 'coupon_discount';
                        couponDiscountInput.value = parseFloat(couponDiscount || 0);
                        form.appendChild(couponDiscountInput);
                    }

                    const orderDataInput = document.createElement('input');
                    orderDataInput.type = 'hidden';
                    orderDataInput.name = 'order_data';
                    orderDataInput.value = JSON.stringify(orderData);
                    form.appendChild(orderDataInput);

                    const addressInput = document.createElement('input');
                    addressInput.type = 'hidden';
                    addressInput.name = 'address';
                    addressInput.value = JSON.stringify(selectedAddress);
                    form.appendChild(addressInput);

                    const stateInput = document.createElement('input');
                    stateInput.type = 'hidden';
                    stateInput.name = 'state_id';
                    stateInput.value = selectedState ? selectedState.id : '';
                    form.appendChild(stateInput);

                    const paymentInput = document.createElement('input');
                    paymentInput.type = 'hidden';
                    paymentInput.name = 'payment_method';
                    paymentInput.value = selectedPayment;
                    form.appendChild(paymentInput);

                    if (selectedPayment === 'cod') {
                        const codInput = document.createElement('input');
                        codInput.type = 'hidden';
                        codInput.name = 'is_cod';
                        codInput.value = '1';
                        form.appendChild(codInput);

                        const shippingStateInput = document.createElement('input');
                        shippingStateInput.type = 'hidden';
                        shippingStateInput.name = 'shipping_state';
                        shippingStateInput.value = JSON.stringify(selectedState);
                        form.appendChild(shippingStateInput);
                    }

                    const cartInput = document.createElement('input');
                    cartInput.type = 'hidden';
                    cartInput.name = 'cart';
                    cartInput.value = JSON.stringify(cartData);
                    form.appendChild(cartInput);

                    document.body.appendChild(form);
                    form.submit();
                } else {
                    showCustomAlert('❌ Error', 'Error processing order. Please try again.', 'warning');
                    if (checkoutBtn) {
                        checkoutBtn.innerHTML = '<i class="fas fa-check-circle"></i> Place Order';
                        checkoutBtn.disabled = false;
                    }
                    renderPage();
                }
            } catch (error) {
                console.error('Order error:', error);
                showCustomAlert('❌ Network Error', 'Please try again.', 'warning');
                if (checkoutBtn) {
                    checkoutBtn.innerHTML = '<i class="fas fa-check-circle"></i> Place Order';
                    checkoutBtn.disabled = false;
                }
                renderPage();
            }
        }

        // ============ RENDER FUNCTIONS ============
        function renderPage() {
            let container = document.getElementById('cartContainer');
            cartData = JSON.parse(localStorage.getItem('cart')) || [];

            if (cartData.length === 0) {
                container.innerHTML = `
                    <div class="empty-cart-card">
                        <div class="empty-cart-icon"><i class="fas fa-shopping-bag"></i></div>
                        <h3>Your cart is empty</h3>
                        <p class="text-muted mb-4">Looks like you haven't added anything to your cart yet.</p>
                        <a href="{{ url('/') }}" class="btn-primary-custom" style="display: inline-flex; width: auto; padding: 0.75rem 2rem; text-decoration: none;">
                            <i class="fas fa-store"></i> Start Shopping
                        </a>
                    </div>
                `;
                updateNavbarCartCount();
                return;
            }

            if (currentPage === 'cart') {
                renderCartPage();
            } else {
                renderCheckoutPage();
            }
        }

        function renderCartPage() {
            let subtotal = 0;
            let totalItems = 0;
            let cartItemsHtml = '';

            for (let i = 0; i < cartData.length; i++) {
                let item = cartData[i];
                let stock = productStock[item.id] || 0;
                let price = parseFloat(item.price) || 0;
                let originalPrice = parseFloat(item.original_price) || price;
                let qty = item.quantity;
                let itemTotal = price * qty;
                subtotal += itemTotal;
                totalItems += qty;

                let discountPercent = 0;
                let discountDisplay = '';
                let hasDiscount = false;
                if (originalPrice > 0 && price < originalPrice) {
                    hasDiscount = true;
                    discountPercent = Math.round(((originalPrice - price) / originalPrice) * 100);
                    discountDisplay = discountPercent + '% off';
                }

                let stockText = stock > 0 ? (stock <= 5 ? `Only ${stock} left` : 'In Stock') : 'Out of Stock';
                let stockClass = stock > 0 ? (stock <= 5 ? 'stock-low' : 'stock-available') : 'stock-out';
                let imageUrl = productImages[item.id] || '';
                let variantDetails = '';
                if (item.size) variantDetails += `Size: ${item.size}`;
                if (item.size && item.color) variantDetails += ' | ';
                if (item.color) variantDetails += `Color: ${item.color}`;

                let priceHtml = '';
                if (hasDiscount) {
                    priceHtml = `
                        <div class="product-price">
                            <span class="original-price">₹${originalPrice.toFixed(2)}</span>
                            ₹${price.toFixed(2)}
                            <span class="discount-tag">${discountDisplay}</span>
                        </div>
                    `;
                } else {
                    priceHtml = `
                        <div class="product-price">₹${price.toFixed(2)}</div>
                    `;
                }

                cartItemsHtml += `
                    <div class="cart-item">
                        <div class="cart-item-image">
                            ${imageUrl ? `<img src="${imageUrl}" alt="${escapeHtml(item.name)}">` : `<div class="image-placeholder">🏋️</div>`}
                        </div>
                        <div>
                            <div class="product-title">${escapeHtml(item.name)}</div>
                            ${variantDetails ? `<div class="product-variant-details">${escapeHtml(variantDetails)}</div>` : ''}
                            ${priceHtml}
                            <div class="quantity-control">
                                <button class="qty-btn" onclick="updateQty(${i}, -1)">-</button>
                                <span>${qty}</span>
                                <button class="qty-btn" onclick="updateQty(${i}, 1)" ${qty >= stock ? 'disabled' : ''}>+</button>
                            </div>
                            <span class="stock-badge ${stockClass}">${stockText}</span>
                        </div>
                        <div>
                            <div class="item-total">₹${itemTotal.toFixed(2)}</div>
                            <button class="remove-item" onclick="removeItem(${i})"><i class="fas fa-trash-alt"></i> Remove</button>
                        </div>
                    </div>
                `;
            }

            let hasStockIssue = checkStockIssues();

            let html = `
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
                    <h2 style="font-family: var(--font-display); font-weight: 400; text-transform: uppercase; letter-spacing: 0.3px; font-size: 1.8rem; color: var(--ink);">
                        <i class="fas fa-shopping-cart" style="color: var(--signal);"></i> Shopping Cart (${cartData.length} item${cartData.length > 1 ? 's' : ''})
                    </h2>
                </div>
                <div class="cart-grid">
                    <div class="cart-items-card">
                        <div style="display: grid; grid-template-columns: 100px 1fr auto; gap: 1rem; padding: 0.5rem 0; border-bottom: 2px solid var(--line); font-weight: 700; font-size: 0.85rem; color: var(--steel); text-transform: uppercase; letter-spacing: 0.3px;">
                            <div>PRODUCT</div>
                            <div></div>
                            <div style="text-align: right;">TOTAL</div>
                        </div>
                        ${cartItemsHtml}
                        <div class="cart-actions">
                            <button class="btn-update" onclick="updateCart()"><i class="fas fa-sync-alt"></i> Update Cart</button>
                            <button class="btn-clear" onclick="clearCart()"><i class="fas fa-trash"></i> Clear cart</button>
                        </div>
                    </div>
                    <div>
                        <div class="summary-card">
                            <div class="summary-header">Order Summary</div>
                            <div class="summary-row">
                                <span>Subtotal (${totalItems} items)</span>
                                <span>₹${subtotal.toFixed(2)}</span>
                            </div>
                            <div class="summary-row">
                                <span>Shipping</span>
                                <span style="color: var(--steel);">Select state at checkout</span>
                            </div>
                            <div class="summary-total">
                                <span>Total</span>
                                <span>₹${subtotal.toFixed(2)}</span>
                            </div>
                            <button class="btn-primary-custom" onclick="goToCheckout()" ${hasStockIssue ? 'disabled' : ''}>
                                Proceed to Checkout <i class="fas fa-arrow-right"></i>
                            </button>
                            <a href="{{ url('/') }}" class="btn-secondary-custom">
                                <i class="fas fa-arrow-left"></i> Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            `;

            document.getElementById('cartContainer').innerHTML = html;
            updateNavbarCartCount();
        }

        function renderCheckoutPage() {
            let subtotal = getSubtotal();
            let totalItems = getTotalItems();
            let couponDiscountAmount = parseFloat(couponDiscount || 0);
            let totalWithShipping = getTotalWithShipping();

            codAvailable = checkCodAvailability();

            let stateOptions = '';
            if (deliverableStates && deliverableStates.length > 0) {
                stateOptions = deliverableStates.map(state => {
                    const selected = selectedState && selectedState.id === state.id ? 'selected' : '';
                    return `
                        <option value="${state.id}" ${selected}>
                            ${state.state} (₹${parseFloat(state.shipping_charge || 0).toFixed(2)})
                        </option>
                    `;
                }).join('');
            } else {
                stateOptions = '<option value="">-- No states available --</option>';
            }

            let addressesHtml = '';
            if (savedAddresses.length === 0) {
                addressesHtml =
                    '<div style="text-align: center; padding: 1rem; color: var(--steel); font-size: 0.85rem;">No addresses saved.</div>';
            }
            savedAddresses.forEach((addr, idx) => {
                let isSelected = selectedAddress && selectedAddress.id === addr.id;
                addressesHtml += `
                    <div class="address-item ${isSelected ? 'selected' : ''}" onclick="selectAddress(${idx})">
                        <div class="address-radio-wrapper">
                            <span class="radio-select"></span>
                            <div class="address-content">
                                <div class="address-name">
                                    ${escapeHtml(addr.name)}
                                </div>
                                <div class="address-details">
                                    ${escapeHtml(addr.address)}<br>
                                    ${escapeHtml(addr.city)}, ${escapeHtml(addr.state)} - ${addr.pincode}
                                </div>
                                <div class="address-phone"><i class="fas fa-phone"></i> ${addr.phone}</div>
                                <div class="address-actions">
                                    <button class="btn-address-edit" onclick="event.stopPropagation(); editAddress(${idx})"><i class="fas fa-edit"></i> Edit</button>
                                    <button class="btn-address-delete" onclick="event.stopPropagation(); deleteAddress(${idx})"><i class="fas fa-trash-alt"></i> Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });

            let orderItemsHtml = '';
            for (let item of cartData) {
                let price = parseFloat(item.price) || 0;
                let originalPrice = parseFloat(item.original_price) || price;
                let imageUrl = productImages[item.id] || '';
                let color = item.color || '';
                let size = item.size || '';
                let detailsHtml = '';
                if (color || size) {
                    detailsHtml =
                        `<div class="item-details">${color ? 'Color: ' + color : ''}${color && size ? ' | ' : ''}${size ? 'Size: ' + size : ''}</div>`;
                }
                orderItemsHtml += `
                    <div class="order-item">
                        <div class="item-img">
                            ${imageUrl ? `<img src="${imageUrl}" alt="${escapeHtml(item.name)}">` : '<div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:1.5rem;">🏋️</div>'}
                        </div>
                        <div class="item-info">
                            <div class="item-name">${escapeHtml(item.name)}</div>
                            ${detailsHtml}
                            <div class="item-details">Qty: ${item.quantity}</div>
                        </div>
                        <div class="item-price">₹${(price * item.quantity).toFixed(2)}</div>
                    </div>
                `;
            }

            let editAddress = editAddressData || {};

            let couponHtml = '';
            if (couponCode && couponDiscountAmount > 0) {
                couponHtml = `
                    <div class="coupon-applied">
                        <i class="fas fa-check-circle" style="color: var(--success);"></i>
                        Coupon <strong>${couponCode}</strong> applied! 
                        Discount: <strong>₹${couponDiscountAmount.toFixed(2)}</strong>
                        <span class="remove-coupon" onclick="removeCoupon()">✕ Remove</span>
                    </div>
                `;
            } else {
                couponHtml = `
                    <div class="coupon-section">
                        <i class="fas fa-ticket-alt coupon-icon"></i>
                        <select id="couponSelect" class="form-select">
                            <option value="">-- Select a coupon --</option>
                        </select>
                        <button id="applyCouponBtn" onclick="applyCouponFromDropdown()" class="btn-apply-coupon">Apply</button>
                    </div>
                `;
            }

            let paymentMethodsHtml = `
                <div class="payment-methods">
                    <div class="payment-option ${selectedPayment === 'online' ? 'selected' : ''}" onclick="selectPayment('online')">
                        <div class="payment-icon"><i class="fas fa-credit-card"></i></div>
                        <div class="payment-info">
                            <div class="payment-name">Online Payment</div>
                            <div class="payment-desc">UPI, Card, NetBanking, Wallet</div>
                        </div>
                        <span class="radio-select"></span>
                    </div>
            `;

            if (codAvailable === true) {
                paymentMethodsHtml += `
                    <div class="payment-option ${selectedPayment === 'cod' ? 'selected' : ''}" onclick="selectPayment('cod')">
                        <div class="payment-icon"><i class="fas fa-money-bill-wave"></i></div>
                        <div class="payment-info">
                            <div class="payment-name">Cash on Delivery</div>
                            <div class="payment-desc">Pay when your order arrives</div>
                        </div>
                        <span class="radio-select"></span>
                    </div>
                `;
            } else {
                paymentMethodsHtml += `
                    <div class="payment-option disabled" style="opacity:0.6; cursor:not-allowed;">
                        <div class="payment-icon"><i class="fas fa-money-bill-wave"></i></div>
                        <div class="payment-info">
                            <div class="payment-name">Cash on Delivery</div>
                            <div class="payment-desc" style="color: var(--signal-dark);">Not available for this product</div>
                        </div>
                        <span class="cod-not-available-badge">Not Available</span>
                    </div>
                `;
            }

            paymentMethodsHtml += `</div>`;

            let couponSummaryRow = '';
            if (couponCode && couponDiscountAmount > 0) {
                couponSummaryRow = `
                    <div class="summary-row" style="color: var(--success);">
                        <span>Coupon Discount (${couponCode})</span>
                        <span>- ₹${couponDiscountAmount.toFixed(2)}</span>
                    </div>
                `;
            }

            let html = `
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
                    <h2 style="font-family: var(--font-display); font-weight: 400; text-transform: uppercase; letter-spacing: 0.3px; font-size: 1.8rem; color: var(--ink);">
                        <i class="fas fa-check-circle" style="color: var(--success);"></i> Checkout
                    </h2>
                    <button class="btn-secondary-custom" onclick="goToCart()" style="width: auto; padding: 0.5rem 1.5rem; display: inline-block;">
                        <i class="fas fa-arrow-left"></i> Back to Cart
                    </button>
                </div>
                <div class="cart-grid">
                    <div>
                        <div class="checkout-contact-section">
                            <div class="section-title"><i class="fas fa-user-circle"></i> Contact Information</div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>FULL NAME <span class="required">*</span></label>
                                    <input type="text" id="checkoutName" value="${escapeHtml(loggedInUser?.name || '')}" placeholder="Enter your name">
                                </div>
                                <div class="form-group">
                                    <label>PHONE NUMBER <span class="required">*</span></label>
                                    <input type="text" id="checkoutPhone" value="${escapeHtml(loggedInUser?.phone || '')}" placeholder="Enter 10-digit phone number">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>EMAIL <span class="required">*</span></label>
                                <input type="email" id="checkoutEmail" value="${escapeHtml(userEmail)}" readonly>
                            </div>
                        </div>
                        
                        <div class="delivery-address-section">
                            <div class="section-title"><i class="fas fa-map-marker-alt"></i> Delivery Address</div>
                            
                            <div class="address-list">
                                ${addressesHtml}
                            </div>
                            
                            <span class="add-address-toggle" onclick="showAddAddressForm()">+ Add New Address</span>
                            
                            <div id="addAddressForm" class="add-address-form ${showAddressForm ? 'show' : ''}">
                                <div class="form-group">
                                    <label>FLAT / HOUSE NO., BUILDING, STREET <span class="required">*</span></label>
                                    <input type="text" id="newBuilding" placeholder="Enter your address" value="${escapeHtml(editAddress.address || '')}">
                                </div>
                                <div class="form-group">
                                    <label>CITY / DISTRICT <span class="required">*</span></label>
                                    <input type="text" id="newCity" placeholder="City" value="${escapeHtml(editAddress.city || '')}">
                                </div>
                                <div class="form-group">
                                    <label>STATE <span class="required">*</span></label>
                                    <select id="newState" onchange="updateShippingFromForm()">
                                        <option value="">-- Select State --</option>
                                        ${stateOptions}
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>PINCODE <span class="required">*</span></label>
                                    <input type="text" id="newPincode" placeholder="Enter 6-digit pin code" maxlength="10" value="${escapeHtml(editAddress.pincode || '')}">
                                </div>
                                
                                <div class="shipping-charge-display">
                                    <span>Shipping Charge</span>
                                    <span class="charge-amount">₹${shippingCharge.toFixed(2)}</span>
                                </div>
                                
                                <button class="btn-add-address" onclick="saveNewAddress()">${isEditingAddress ? 'Update Address' : 'Add Address'}</button>
                                <button class="btn-secondary-custom" onclick="hideAddAddressForm()" style="margin-top: 0.5rem;">Cancel</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="order-summary-section">
                        <div class="coupon-section-wrapper">
                            <div class="section-title">
                                <i class="fas fa-ticket-alt" style="color: var(--signal);"></i> Coupon / Promo Code
                            </div>
                            ${couponHtml}
                        </div>
                        <div class="summary-card">
                            <div class="order-header">
                                <h4>Your Order (${totalItems} item${totalItems > 1 ? 's' : ''})</h4>
                            </div>
                            ${orderItemsHtml}
                            <hr style="margin: 1rem 0; border-color: var(--line);">
                            
                            <div class="summary-row">
                                <span>Subtotal (Tax included)</span>
                                <span>₹${subtotal.toFixed(2)}</span>
                            </div>
                            <div class="summary-row">
                                <span>Shipping</span>
                                <span>${selectedState ? selectedState.state + ' ₹' + shippingCharge.toFixed(2) : '₹0.00'}</span>
                            </div>
                            ${couponSummaryRow}
                            
                            <div style="margin-top: 1rem; border-top: 1px solid var(--line); padding-top: 1rem;">
                                ${paymentMethodsHtml}
                            </div>
                            
                            <div class="summary-total">
                                <span>Grand Total</span>
                                <span>₹${parseFloat(totalWithShipping || 0).toFixed(2)}</span>
                            </div>
                            <button class="btn-primary-custom place-order-btn" onclick="placeOrder()" ${!selectedAddress || !selectedPayment || !selectedState ? 'disabled' : ''}>
                                <i class="fas fa-check-circle"></i> Place Order
                            </button>
                            <div class="secure-checkout-footer">
                                <span><i class="fas fa-lock"></i> Secure Checkout</span>
                                <span><i class="fas fa-undo"></i> 3 Day Return Policy</span>
                                ${codAvailable ? '<span><i class="fas fa-truck"></i> COD Available</span>' : '<span style="color: var(--signal-dark);"><i class="fas fa-times-circle"></i> COD Not Available</span>'}
                            </div>
                        </div>
                    </div>
                </div>
            `;

            document.getElementById('cartContainer').innerHTML = html;

            if (!couponCode) {
                const select = document.getElementById('couponSelect');
                if (select) {
                    loadAvailableCoupons();
                }
            }

            const newStateSelect = document.getElementById('newState');
            if (newStateSelect && selectedState) {
                newStateSelect.value = selectedState.id;
            }a
        }

        // ============ INITIALIZATION ============
        document.addEventListener('DOMContentLoaded', async function() {
            await loadDeliverableStates();
            await getLoggedInUser();
            await loadProductsData();
            await loadAddressesFromDatabase();
            cartData = JSON.parse(localStorage.getItem('cart')) || [];
            renderPage();
        });
    </script>
@endsection