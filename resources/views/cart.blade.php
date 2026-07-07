{{-- resources/views/cart.blade.php --}}
@extends('layouts.app')

@section('content')
    <style>
        .cart-wrapper {
            background: #f8fafc;
            min-height: 70vh;
            padding: 2rem 0;
        }

        .cart-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

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

        .cart-items-card,
        .checkout-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            padding: 1.5rem;
        }

        .cart-item {
            display: grid;
            grid-template-columns: 100px 1fr auto;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid #eef2f6;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item-image {
            width: 100px;
            height: 100px;
            border-radius: 16px;
            overflow: hidden;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cart-item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-placeholder {
            font-size: 2.5rem;
        }

        .product-title {
            font-size: 1rem;
            font-weight: 600;
            color: #1e293b;
            text-decoration: none;
        }

        .product-price {
            font-size: 1rem;
            font-weight: 700;
            color: #0f172a;
            margin-top: 0.25rem;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: #f1f5f9;
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
            font-weight: 600;
        }

        .qty-btn:hover {
            background: #3b82f6;
            color: white;
        }

        .item-total {
            font-weight: 700;
            font-size: 1rem;
            color: #0f172a;
        }

        .remove-item {
            background: none;
            border: none;
            color: #ef4444;
            cursor: pointer;
            font-size: 0.75rem;
            margin-top: 0.5rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .summary-card {
            background: white;
            border-radius: 24px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 100px;
        }

        .summary-header {
            font-size: 1.1rem;
            font-weight: 700;
            padding-bottom: 1rem;
            border-bottom: 2px solid #eef2f6;
            margin-bottom: 1rem;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            color: #475569;
            font-size: 0.9rem;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            padding: 1rem 0;
            border-top: 2px solid #eef2f6;
            margin-top: 0.5rem;
            font-size: 1.2rem;
            font-weight: 800;
            color: #0f172a;
        }

        .btn-primary-custom {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border: none;
            border-radius: 40px;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            margin-top: 1rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.3);
        }

        .btn-primary-custom:disabled {
            background: #cbd5e1;
            cursor: not-allowed;
            transform: none;
        }

        .btn-secondary-custom {
            width: 100%;
            padding: 0.75rem;
            background: transparent;
            border: 1px solid #cbd5e1;
            border-radius: 40px;
            color: #475569;
            font-weight: 500;
            margin-top: 0.5rem;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            display: block;
        }

        .btn-secondary-custom:hover {
            background: #f1f5f9;
        }

        .empty-cart-card {
            background: white;
            border-radius: 24px;
            padding: 3rem;
            text-align: center;
        }

        .empty-cart-icon {
            font-size: 5rem;
            color: #cbd5e1;
            margin-bottom: 1rem;
        }

        .stock-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.2rem 0.6rem;
            border-radius: 40px;
            font-size: 0.65rem;
            font-weight: 500;
        }

        .stock-available {
            background: #dcfce7;
            color: #15803d;
        }

        .stock-low {
            background: #fef9c3;
            color: #854d0e;
        }

        .stock-out {
            background: #fee2e2;
            color: #b91c1c;
        }

        .user-info-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem;
            border-radius: 16px;
            margin-bottom: 1rem;
        }

        .user-email {
            font-size: 0.85rem;
            opacity: 0.9;
        }

        .checkout-section-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #eef2f6;
        }

        .form-group {
            margin-bottom: 0.8rem;
        }

        .form-group label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
            color: #475569;
        }

        .form-group label .required {
            color: #ef4444;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 0.7rem;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            outline: none;
            font-size: 0.9rem;
            transition: border-color 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-group input[readonly] {
            background: #f1f5f9;
        }

        .payment-methods {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .payment-option {
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            padding: 0.75rem 1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.3s;
        }

        .payment-option.selected {
            border-color: #3b82f6;
            background: #eff6ff;
        }

        .payment-icon {
            width: 36px;
            height: 36px;
            background: #f1f5f9;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .payment-info {
            flex: 1;
        }

        .payment-name {
            font-weight: 600;
            color: #1e293b;
            font-size: 0.9rem;
        }

        .payment-desc {
            font-size: 0.7rem;
            color: #64748b;
        }

        .payment-option .radio-select {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            border: 2px solid #cbd5e1;
            flex-shrink: 0;
        }

        .payment-option.selected .radio-select {
            border-color: #3b82f6;
            background: #3b82f6;
            box-shadow: inset 0 0 0 4px white;
        }

        .address-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            max-height: 350px;
            overflow-y: auto;
        }

        .address-item {
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            padding: 0.75rem 1rem;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
        }

        .address-item.selected {
            border-color: #3b82f6;
            background: #eff6ff;
        }

        .address-item:hover {
            border-color: #3b82f6;
        }

        .address-name {
            font-weight: 700;
            color: #1e293b;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.5rem;
            font-size: 0.9rem;
        }

        .address-details {
            color: #475569;
            font-size: 0.8rem;
            margin-top: 0.3rem;
            line-height: 1.5;
        }

        .address-phone {
            margin-top: 0.3rem;
            color: #64748b;
            font-size: 0.75rem;
        }

        .address-item .radio-select {
            position: relative;
            right: auto;
            top: auto;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            border: 2px solid #cbd5e1;
            flex-shrink: 0;
            margin-right: 12px;
            display: inline-block;
            vertical-align: middle;
        }

        .address-item.selected .radio-select {
            border-color: #3b82f6;
            background: #3b82f6;
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
            background: #e0f2fe;
            color: #0369a1;
            border: none;
            padding: 2px 12px;
            border-radius: 20px;
            font-size: 0.65rem;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-address-edit:hover {
            background: #bae6fd;
        }

        .btn-address-delete {
            background: #fee2e2;
            color: #b91c1c;
            border: none;
            padding: 2px 12px;
            border-radius: 20px;
            font-size: 0.65rem;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-address-delete:hover {
            background: #fecaca;
        }

        .add-address-toggle {
            color: #3b82f6;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.85rem;
            margin-top: 0.5rem;
            display: inline-block;
        }

        .add-address-toggle:hover {
            text-decoration: underline;
        }

        .add-address-form {
            margin-top: 1rem;
            padding: 1rem;
            background: #f8fafc;
            border-radius: 16px;
            display: none;
        }

        .add-address-form.show {
            display: block;
        }

        .btn-add-address {
            background: #3b82f6;
            color: white;
            border: none;
            padding: 0.75rem;
            border-radius: 12px;
            cursor: pointer;
            width: 100%;
            font-weight: 600;
        }

        .btn-add-address:hover {
            background: #2563eb;
        }

        .order-item-mini {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.5rem 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .order-item-mini:last-child {
            border-bottom: none;
        }

        .order-item-mini .item-img {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            overflow: hidden;
            background: #f1f5f9;
            flex-shrink: 0;
        }

        .order-item-mini .item-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .order-item-mini .item-info {
            flex: 1;
        }

        .order-item-mini .item-info .item-name {
            font-weight: 600;
            font-size: 0.85rem;
            color: #1e293b;
        }

        .order-item-mini .item-info .item-qty {
            font-size: 0.75rem;
            color: #64748b;
        }

        .order-item-mini .item-price {
            font-weight: 600;
            font-size: 0.85rem;
            color: #0f172a;
        }

        .coupon-section {
            margin: 0.5rem 0;
            display: flex;
            gap: 0.5rem;
            align-items: center;
            background: #f8fafc;
            padding: 0.75rem 1rem;
            border-radius: 12px;
            border: 1px dashed #cbd5e1;
        }

        .coupon-section select {
            flex: 1;
            padding: 0.6rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.85rem;
            background: white;
            cursor: pointer;
            appearance: auto;
            min-width: 150px;
        }

        .coupon-section select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .coupon-section .coupon-icon {
            color: #8b5cf6;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .coupon-section .btn-apply-coupon {
            padding: 0.6rem 1.5rem;
            background: #8b5cf6;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.85rem;
            white-space: nowrap;
        }

        .coupon-section .btn-apply-coupon:hover {
            background: #7c3aed;
        }

        .coupon-section .btn-apply-coupon:disabled {
            background: #cbd5e1;
            cursor: not-allowed;
        }

        .coupon-applied {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: #dcfce7;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            font-size: 0.85rem;
            color: #15803d;
        }

        .coupon-applied .remove-coupon {
            color: #ef4444;
            cursor: pointer;
            font-weight: 600;
            margin-left: 0.5rem;
        }

        .coupon-applied .remove-coupon:hover {
            text-decoration: underline;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .fa-spinner {
            animation: spin 1s linear infinite;
        }

        .cart-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .cart-actions .btn-update {
            padding: 0.5rem 1.5rem;
            background: #3b82f6;
            color: white;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .cart-actions .btn-clear {
            padding: 0.5rem 1.5rem;
            background: #ef4444;
            color: white;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .state-shipping-display {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            font-size: 0.85rem;
            color: #475569;
            border-top: 1px dashed #e2e8f0;
            margin-top: 0.5rem;
            padding-top: 0.5rem;
        }

        .state-shipping-display .shipping-amount {
            font-weight: 700;
            color: #0f172a;
        }

        .checkout-contact-section {
            background: white;
            border-radius: 24px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .checkout-contact-section .section-title {
            font-size: 1rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #eef2f6;
        }

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

        .checkout-contact-section .form-group {
            margin-bottom: 0.8rem;
        }

        .checkout-contact-section .form-group label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: 0.25rem;
        }

        .checkout-contact-section .form-group label .required {
            color: #ef4444;
        }

        .checkout-contact-section .form-group input,
        .checkout-contact-section .form-group select {
            width: 100%;
            padding: 0.7rem 0.8rem;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.9rem;
            outline: none;
            transition: all 0.3s;
        }

        .checkout-contact-section .form-group input:focus,
        .checkout-contact-section .form-group select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .checkout-contact-section .form-group input[readonly] {
            background: #f1f5f9;
        }

        .delivery-address-section {
            background: white;
            border-radius: 24px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
        }

        .delivery-address-section .section-title {
            font-size: 1rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #eef2f6;
        }

        .coupon-section-wrapper {
            background: white;
            border-radius: 24px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
        }

        .coupon-section-wrapper .section-title {
            font-size: 1rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #eef2f6;
        }

        .order-summary-section .summary-card {
            background: white;
            border-radius: 24px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 100px;
        }

        .order-summary-section .summary-card .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 1rem;
            border-bottom: 2px solid #eef2f6;
            margin-bottom: 1rem;
        }

        .order-summary-section .summary-card .order-header h4 {
            font-size: 1rem;
            font-weight: 700;
            margin: 0;
        }

        .order-summary-section .summary-card .order-header .order-count {
            font-size: 0.85rem;
            color: #64748b;
        }

        .order-summary-section .summary-card .order-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.5rem 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .order-summary-section .summary-card .order-item:last-child {
            border-bottom: none;
        }

        .order-summary-section .summary-card .order-item .item-img {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            overflow: hidden;
            background: #f1f5f9;
            flex-shrink: 0;
        }

        .order-summary-section .summary-card .order-item .item-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .order-summary-section .summary-card .order-item .item-info {
            flex: 1;
        }

        .order-summary-section .summary-card .order-item .item-info .item-name {
            font-weight: 600;
            font-size: 0.85rem;
            color: #1e293b;
        }

        .order-summary-section .summary-card .order-item .item-info .item-details {
            font-size: 0.75rem;
            color: #64748b;
        }

        .order-summary-section .summary-card .order-item .item-price {
            font-weight: 600;
            font-size: 0.85rem;
            color: #0f172a;
        }

        .cod-availability {
            background: #f0fdf4;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            margin-top: 0.5rem;
            font-size: 0.75rem;
            color: #15803d;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .cod-availability i {
            color: #22c55e;
        }

        .shipping-charge-display {
            padding: 0.5rem 0;
            font-size: 0.85rem;
            color: #475569;
            display: flex;
            justify-content: space-between;
            border-top: 1px solid #e2e8f0;
            margin-top: 0.5rem;
            padding-top: 0.5rem;
        }

        .shipping-charge-display .charge-amount {
            font-weight: 700;
            color: #0f172a;
        }

        .secure-checkout-footer {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 0.75rem;
            font-size: 0.7rem;
            color: #64748b;
            flex-wrap: wrap;
        }

        .secure-checkout-footer span {
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }
    </style>

    <div class="cart-wrapper">
        <div class="cart-container">
            <div id="cartContainer">
                <!-- Dynamic content will be injected here -->
            </div>
        </div>
    </div>

    <script>
        // Get CSRF token from meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
            '{{ csrf_token() }}';

        // Global variables
        let productStock = {};
        let productImages = {};
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

        // ============ LOAD DELIVERABLE STATES FROM ADMIN ============
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

        async function updateAddressInDatabase(addressId, address) {
            try {
                const response = await fetch(`/api/user-addresses/${addressId}`, {
                    method: 'PUT',
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
                console.error('Error updating address:', error);
                return null;
            }
        }

        function saveAddressesToLocal() {
            localStorage.setItem('user_addresses', JSON.stringify(savedAddresses));
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
                            productStock[product.id] = parseInt(product.stock) || 0;
                            if (product.image) {
                                productImages[product.id] = '/storage/' + product.image;
                            }
                        }
                    });
                }

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
            return getSubtotal() + shippingCharge - couponDiscount;
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

        function showToast(message, type = 'success') {
            alert(message);
        }

        // ============ NAVIGATION ============
        function goToCheckout() {
            if (checkStockIssues()) {
                alert('Some items have stock issues. Please check your cart.');
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
            if (confirm('Are you sure you want to delete this address?')) {
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
                alert('Please fill all required fields');
                return false;
            }

            if (pincode.length < 6) {
                alert('Please enter a valid 6-digit pincode');
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
                if (existingAddress.id) {
                    updateAddressInDatabase(existingAddress.id, addressData).then(updated => {
                        if (updated) {
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
                            showToast('Address updated successfully!');
                        } else {
                            alert('Failed to update address. Please try again.');
                        }
                    });
                    return true;
                } else {
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
                    showToast('Address updated successfully!');
                    return true;
                }
            } else {
                saveAddressToDatabase(addressData).then(saved => {
                    if (saved) {
                        savedAddresses.push(saved);
                        saveAddressesToLocal();
                        selectedAddress = saved;
                        showAddressForm = false;
                        renderPage();
                        showToast('Address added successfully!');
                    } else {
                        savedAddresses.push(addressData);
                        saveAddressesToLocal();
                        selectedAddress = addressData;
                        showAddressForm = false;
                        renderPage();
                        showToast('Address added successfully!');
                    }
                });
                return true;
            }
        }

        function selectPayment(method) {
            selectedPayment = method;
            renderPage();
        }

        // ============ COUPON FUNCTIONS - WITH DROPDOWN ============

        // Load available coupons into dropdown - Only Coupon Code
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
                        // Only show coupon code in dropdown
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

        // Apply coupon from dropdown
        async function applyCouponFromDropdown() {
            const select = document.getElementById('couponSelect');
            if (!select) {
                alert('Coupon selection not found');
                return;
            }

            const code = select.value;

            if (!code) {
                alert('Please select a coupon from the dropdown');
                return;
            }

            const btn = document.getElementById('applyCouponBtn');
            if (btn) {
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                btn.disabled = true;
            }

            try {
                const response = await fetch('/api/validate-coupon', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        code: code,
                        subtotal: getSubtotal()
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
                    alert('✅ Coupon applied! Discount: ₹' + couponDiscount.toFixed(2));
                } else {
                    alert('❌ ' + (data.message || 'Invalid coupon code'));
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
                alert('Error applying coupon. Please try again.');
            }
        }

        function removeCoupon() {
            couponCode = null;
            couponDiscount = 0;
            renderPage();
            alert('Coupon removed');
        }

        // ============ CART OPERATIONS ============
        window.updateQty = async function(index, change) {
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
                alert(`Sorry, only ${stock} items available!`);
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
            if (confirm('Remove this item?')) {
                let cart = JSON.parse(localStorage.getItem('cart')) || [];
                cart.splice(index, 1);
                localStorage.setItem('cart', JSON.stringify(cart));
                cartData = cart;
                if (cartData.length === 0) {
                    currentPage = 'cart';
                }
                renderPage();
                updateNavbarCartCount();
            }
        };

        window.clearCart = function() {
            if (confirm('Are you sure you want to clear your entire cart?')) {
                localStorage.removeItem('cart');
                cartData = [];
                renderPage();
                updateNavbarCartCount();
            }
        };

        window.updateCart = function() {
            renderPage();
            alert('Cart updated!');
        };

        // ============ PLACE ORDER ============
        async function placeOrder() {
            if (checkStockIssues()) {
                alert('Some items are out of stock or quantity exceeds available stock!');
                return;
            }

            if (!selectedPayment) {
                alert('Please select a payment method');
                return;
            }

            if (!selectedState) {
                alert('Please select a state in the address section');
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
                alert('Please add a delivery address');
                return;
            }

            let checkoutBtn = document.querySelector('.place-order-btn');
            if (checkoutBtn) {
                checkoutBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Placing Order...';
                checkoutBtn.disabled = true;
            }

            // Calculate all amounts
            const subtotal = getSubtotal();
            const totalWithShipping = getTotalWithShipping();

            // Prepare order data
            const orderData = {
                cart: cartData,
                address: selectedAddress,
                state_id: selectedState ? selectedState.id : '',
                shipping_charge: shippingCharge,
                shipping_state: selectedState,
                subtotal: subtotal,
                total_amount: totalWithShipping,
                coupon_code: couponCode || null,
                coupon_discount: couponDiscount || 0,
                payment_method: selectedPayment
            };

            console.log('Order Data:', orderData);
            console.log('Grand Total to be charged:', totalWithShipping);

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
                        coupon_discount: couponDiscount,
                        coupon_code: couponCode
                    })
                });

                const saveData = await saveResponse.json();

                if (saveData.success) {
                    const form = document.createElement('form');
                    form.method = 'POST';

                    // For COD - use direct order placement, for Online - use buy-now
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

                    // ===== SEND GRAND TOTAL - IMPORTANT =====
                    const totalInput = document.createElement('input');
                    totalInput.type = 'hidden';
                    totalInput.name = 'total_amount';
                    totalInput.value = totalWithShipping;
                    form.appendChild(totalInput);

                    // Send subtotal
                    const subtotalInput = document.createElement('input');
                    subtotalInput.type = 'hidden';
                    subtotalInput.name = 'subtotal';
                    subtotalInput.value = subtotal;
                    form.appendChild(subtotalInput);

                    // Send shipping charge
                    const shippingInput = document.createElement('input');
                    shippingInput.type = 'hidden';
                    shippingInput.name = 'shipping_charge';
                    shippingInput.value = shippingCharge;
                    form.appendChild(shippingInput);

                    // Send coupon details
                    if (couponCode) {
                        const couponInput = document.createElement('input');
                        couponInput.type = 'hidden';
                        couponInput.name = 'coupon_code';
                        couponInput.value = couponCode;
                        form.appendChild(couponInput);

                        const couponDiscountInput = document.createElement('input');
                        couponDiscountInput.type = 'hidden';
                        couponDiscountInput.name = 'coupon_discount';
                        couponDiscountInput.value = couponDiscount;
                        form.appendChild(couponDiscountInput);
                    }

                    // Send full order data
                    const orderDataInput = document.createElement('input');
                    orderDataInput.type = 'hidden';
                    orderDataInput.name = 'order_data';
                    orderDataInput.value = JSON.stringify(orderData);
                    form.appendChild(orderDataInput);

                    // Send address
                    const addressInput = document.createElement('input');
                    addressInput.type = 'hidden';
                    addressInput.name = 'address';
                    addressInput.value = JSON.stringify(selectedAddress);
                    form.appendChild(addressInput);

                    // Send state
                    const stateInput = document.createElement('input');
                    stateInput.type = 'hidden';
                    stateInput.name = 'state_id';
                    stateInput.value = selectedState ? selectedState.id : '';
                    form.appendChild(stateInput);

                    // Send payment method
                    const paymentInput = document.createElement('input');
                    paymentInput.type = 'hidden';
                    paymentInput.name = 'payment_method';
                    paymentInput.value = selectedPayment;
                    form.appendChild(paymentInput);

                    // For COD, add additional flags
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

                    // Add cart items
                    const cartInput = document.createElement('input');
                    cartInput.type = 'hidden';
                    cartInput.name = 'cart';
                    cartInput.value = JSON.stringify(cartData);
                    form.appendChild(cartInput);

                    document.body.appendChild(form);
                    form.submit();
                } else {
                    alert('Error processing order');
                    if (checkoutBtn) {
                        checkoutBtn.innerHTML = '<i class="fas fa-check-circle"></i> Place Order';
                        checkoutBtn.disabled = false;
                    }
                    renderPage();
                }
            } catch (error) {
                console.error('Order error:', error);
                alert('Network error. Please try again.');
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
                let qty = item.quantity;
                let price = parseFloat(item.price);
                let itemTotal = price * qty;

                subtotal += itemTotal;
                totalItems += qty;

                let stockText = stock > 0 ? (stock <= 5 ? `Only ${stock} left` : 'In Stock') : 'Out of Stock';
                let stockClass = stock > 0 ? (stock <= 5 ? 'stock-low' : 'stock-available') : 'stock-out';
                let imageUrl = productImages[item.id] || '';

                cartItemsHtml += `
            <div class="cart-item">
                <div class="cart-item-image">
                    ${imageUrl ? `<img src="${imageUrl}" alt="${escapeHtml(item.name)}">` : `<div class="image-placeholder">🏋️</div>`}
                </div>
                <div>
                    <div class="product-title">${escapeHtml(item.name)}</div>
                    <div class="product-price">₹${price.toLocaleString()}</div>
                    <div class="quantity-control">
                        <button class="qty-btn" onclick="updateQty(${i}, -1)">-</button>
                        <span>${qty}</span>
                        <button class="qty-btn" onclick="updateQty(${i}, 1)" ${qty >= stock ? 'disabled' : ''}>+</button>
                    </div>
                    <span class="stock-badge ${stockClass}">${stockText}</span>
                </div>
                <div>
                    <div class="item-total">₹${itemTotal.toLocaleString()}</div>
                    <button class="remove-item" onclick="removeItem(${i})"><i class="fas fa-trash-alt"></i> Remove</button>
                </div>
            </div>
        `;
            }

            let hasStockIssue = checkStockIssues();

            let html = `
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h2 style="font-size: 1.8rem; font-weight: 700; color: #1e293b;">
                <i class="fas fa-shopping-cart" style="color: #3b82f6;"></i> Shopping Cart (${cartData.length} item${cartData.length > 1 ? 's' : ''})
            </h2>
        </div>
        <div class="cart-grid">
            <div class="cart-items-card">
                <div style="display: grid; grid-template-columns: 100px 1fr auto; gap: 1rem; padding: 0.5rem 0; border-bottom: 2px solid #eef2f6; font-weight: 600; font-size: 0.85rem; color: #64748b;">
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
                        <span>₹${subtotal.toLocaleString()}</span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span class="text-success">Select state at checkout</span>
                    </div>
                    <div class="summary-total">
                        <span>Total</span>
                        <span>₹${subtotal.toLocaleString()}</span>
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
            let totalWithShipping = getTotalWithShipping();

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
                    '<div style="text-align: center; padding: 1rem; color: #64748b; font-size: 0.85rem;">No addresses saved.</div>';
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
                let price = parseFloat(item.price);
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
                <div class="item-price">₹${(price * item.quantity).toLocaleString()}</div>
            </div>
        `;
            }

            let codAvailable = true;
            let editAddress = editAddressData || {};

            // ===== COUPON SECTION HTML - WITH DROPDOWN (Only Coupon Code) =====
            let couponHtml = '';
            if (couponCode) {
                const discountAmount = typeof couponDiscount === 'number' ? couponDiscount : parseFloat(couponDiscount) ||
                    0;
                couponHtml = `
            <div class="coupon-applied">
                <i class="fas fa-check-circle" style="color: #22c55e;"></i>
                Coupon <strong>${couponCode}</strong> applied! 
                Discount: ₹${discountAmount.toFixed(2)}
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

            let html = `
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h2 style="font-size: 1.8rem; font-weight: 700; color: #1e293b;">
                <i class="fas fa-check-circle" style="color: #10b981;"></i> Checkout
            </h2>
            <button class="btn-secondary-custom" onclick="goToCart()" style="width: auto; padding: 0.5rem 1.5rem; display: inline-block;">
                <i class="fas fa-arrow-left"></i> Back to Cart
            </button>
        </div>
        <div class="cart-grid">
            <!-- LEFT SIDE -->
            <div>
                <!-- Contact Information -->
                <div class="checkout-contact-section">
                    <div class="section-title">Contact Information</div>
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
                
                <!-- Delivery Address -->
                <div class="delivery-address-section">
                    <div class="section-title">Delivery Address</div>
                    
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
            
            <!-- RIGHT SIDE -->
            <div class="order-summary-section">
                <!-- Coupon / Promo Code Section -->
                <div class="coupon-section-wrapper">
                    <div class="section-title">
                        <i class="fas fa-ticket-alt" style="color: #8b5cf6;"></i> Coupon / Promo Code
                    </div>
                    ${couponHtml}
                </div>
                <div class="summary-card">
                    <div class="order-header">
                        <h4>Your Order (${totalItems} item${totalItems > 1 ? 's' : ''})</h4>
                    </div>
                    ${orderItemsHtml}
                    <hr style="margin: 1rem 0;">
                    
                    <div class="summary-row">
                        <span>Subtotal (Tax included)</span>
                        <span>₹${subtotal.toLocaleString()}</span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span>${selectedState ? selectedState.state + ' ₹' + shippingCharge.toFixed(2) : '₹0.00'}</span>
                    </div>
                    ${(couponCode && couponDiscount > 0) ? `
                                            <div class="summary-row" style="color: #15803d;">
                                                <span>Coupon Discount (${couponCode})</span>
                                                <span>- ₹${parseFloat(couponDiscount || 0).toFixed(2)}</span>
                                            </div>
                                        ` : ''}
                    
                    <!-- Payment Method -->
                    <div style="margin-top: 1rem; border-top: 1px solid #eef2f6; padding-top: 1rem;">
                        <div class="payment-methods">
                            <div class="payment-option ${selectedPayment === 'online' ? 'selected' : ''}" onclick="selectPayment('online')">
                                <div class="payment-icon"><i class="fas fa-credit-card"></i></div>
                                <div class="payment-info">
                                    <div class="payment-name">Online Payment</div>
                                    <div class="payment-desc">UPI, Card, NetBanking, Wallet</div>
                                </div>
                                <span class="radio-select"></span>
                            </div>
                            <div class="payment-option ${selectedPayment === 'cod' ? 'selected' : ''}" onclick="selectPayment('cod')">
                                <div class="payment-icon"><i class="fas fa-money-bill-wave"></i></div>
                                <div class="payment-info">
                                    <div class="payment-name">Cash on Delivery</div>
                                    <div class="payment-desc">Pay when your order arrives</div>
                                </div>
                                <span class="radio-select"></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="summary-total">
                        <span>Grand Total</span>
                        <span>₹${parseFloat(totalWithShipping || 0).toLocaleString()}</span>
                    </div>
                    <button class="btn-primary-custom place-order-btn" onclick="placeOrder()" ${!selectedAddress || !selectedPayment || !selectedState ? 'disabled' : ''}>
                        <i class="fas fa-check-circle"></i> Place Order
                    </button>
                    <div class="secure-checkout-footer">
                        <span><i class="fas fa-lock"></i> Secure Checkout</span>
                        <span><i class="fas fa-undo"></i> 3 Day Return Policy</span>
                        <span><i class="fas fa-truck"></i> COD Available in Tamil Nadu Only</span>
                    </div>
                </div>
            </div>
        </div>
    `;

            document.getElementById('cartContainer').innerHTML = html;

            // Load available coupons into dropdown
            if (!couponCode) {
                const select = document.getElementById('couponSelect');
                if (select) {
                    loadAvailableCoupons();
                }
            }

            const newStateSelect = document.getElementById('newState');
            if (newStateSelect && selectedState) {
                newStateSelect.value = selectedState.id;
            }
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
