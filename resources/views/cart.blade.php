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
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 1.5rem;
    }
    .cart-header {
        margin-bottom: 2rem;
    }
    .cart-header h2 {
        font-size: 2rem;
        font-weight: 700;
        background: linear-gradient(135deg, #1e293b, #2d3a4b);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .checkout-steps {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        margin-bottom: 2rem;
        background: white;
        padding: 1rem 2rem;
        border-radius: 50px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        flex-wrap: wrap;
    }
    .step {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 40px;
        color: #94a3b8;
        font-weight: 500;
        transition: all 0.3s;
    }
    .step.active {
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        color: white;
    }
    .step.completed {
        color: #10b981;
    }
    .step.completed i {
        background: #10b981;
        color: white;
        border-radius: 50%;
    }
    .step i {
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e2e8f0;
        border-radius: 50%;
        font-size: 0.8rem;
    }
    .step.active i {
        background: white;
        color: #3b82f6;
    }
    .step-line {
        width: 50px;
        height: 2px;
        background: #e2e8f0;
    }
    
    .cart-grid {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 2rem;
    }
    @media (max-width: 992px) {
        .cart-grid {
            grid-template-columns: 1fr;
        }
    }
    
    .cart-items-card, .address-card, .payment-card {
        background: white;
        border-radius: 24px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
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
    .address-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        max-height: 450px;
        overflow-y: auto;
    }
    .address-item {
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        padding: 1rem;
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
    }
    .address-details {
        color: #475569;
        font-size: 0.875rem;
        margin-top: 0.5rem;
        line-height: 1.5;
    }
    .address-phone {
        margin-top: 0.5rem;
        color: #64748b;
        font-size: 0.8rem;
    }
    .edit-address, .delete-address {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 0.7rem;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
    }
    .edit-address {
        color: #3b82f6;
    }
    .delete-address {
        color: #ef4444;
    }
    .edit-address:hover, .delete-address:hover {
        background: #e2e8f0;
    }
    .radio-select {
        position: absolute;
        right: 1rem;
        top: 1rem;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 2px solid #cbd5e1;
    }
    .address-item.selected .radio-select {
        border-color: #3b82f6;
        background: #3b82f6;
        box-shadow: inset 0 0 0 4px white;
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
    .form-group {
        margin-bottom: 1rem;
    }
    .form-group label {
        display: block;
        font-size: 0.8rem;
        font-weight: 500;
        margin-bottom: 0.25rem;
        color: #475569;
    }
    .form-group label .required {
        color: #ef4444;
    }
    .form-group input, .form-group select {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        outline: none;
    }
    .form-group input:focus {
        border-color: #3b82f6;
    }
    .form-group input[readonly] {
        background: #f1f5f9;
    }
    .btn-add-address {
        background: #3b82f6;
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        cursor: pointer;
        width: 100%;
    }
    
    .payment-methods {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    .payment-option {
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        padding: 1rem;
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
        width: 40px;
        height: 40px;
        background: #f1f5f9;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
    .payment-info {
        flex: 1;
    }
    .payment-name {
        font-weight: 600;
        color: #1e293b;
    }
    .payment-desc {
        font-size: 0.75rem;
        color: #64748b;
    }
    
    .cart-summary {
        position: sticky;
        top: 100px;
        height: fit-content;
    }
    .summary-card {
        background: white;
        border-radius: 24px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
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
    .next-btn, .place-order-btn {
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
    }
    .next-btn:disabled, .place-order-btn:disabled {
        background: #cbd5e1;
        cursor: not-allowed;
        transform: none;
    }
    .back-btn {
        width: 100%;
        padding: 0.75rem;
        background: transparent;
        border: 1px solid #cbd5e1;
        border-radius: 40px;
        color: #475569;
        font-weight: 500;
        margin-top: 0.5rem;
        cursor: pointer;
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
    .stock-available { background: #dcfce7; color: #15803d; }
    .stock-low { background: #fef9c3; color: #854d0e; }
    .stock-out { background: #fee2e2; color: #b91c1c; }
    
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
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .fa-spinner {
        animation: spin 1s linear infinite;
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
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

// Global variables
let productStock = {};
let productImages = {};
let currentStep = 'cart';
let selectedAddress = null;
let selectedPayment = null;
let savedAddresses = [];
let cartData = [];
let loggedInUser = null;
let userEmail = '';
let userId = null;

// ============ USER API FUNCTIONS ============
async function getLoggedInUser() {
    try {
        const response = await fetch('/api/user');
        const data = await response.json();
        if (data.success && data.user) {
            loggedInUser = data.user;
            userEmail = data.user.email;
            userId = data.user.id;
            console.log('User logged in:', userId, userEmail);
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
        console.log('Address API Response:', data);
        if (data.success && data.addresses) {
            savedAddresses = data.addresses;
            localStorage.setItem('user_addresses', JSON.stringify(savedAddresses));
            console.log('Loaded addresses from DB:', savedAddresses.length);
        } else {
            let saved = localStorage.getItem('user_addresses');
            if (saved && JSON.parse(saved).length > 0) {
                savedAddresses = JSON.parse(saved);
                console.log('Loaded addresses from localStorage:', savedAddresses.length);
            } else {
                savedAddresses = [];
            }
        }
    } catch (error) {
        console.error('Error loading addresses:', error);
        let saved = localStorage.getItem('user_addresses');
        if (saved) {
            savedAddresses = JSON.parse(saved);
        } else {
            savedAddresses = [];
        }
    }
}

async function saveAddressToDatabase(address) {
    try {
        console.log('Saving address to database:', address);
        
        const response = await fetch('/api/user-addresses', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            credentials: 'same-origin',
            body: JSON.stringify(address)
        });
        
        const data = await response.json();
        console.log('Save address response:', data);
        
        if (data.success && data.address) {
            return data.address;
        } else {
            console.error('Save failed:', data.message);
            return null;
        }
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
                'Content-Type': 'application/json',
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

// ============ PRODUCT DATA FUNCTIONS ============
async function loadProductsData() {
    try {
        const response = await fetch('/api/products');
        const products = await response.json();
        products.forEach(product => {
            productStock[product.id] = product.stock;
            if (product.image) {
                productImages[product.id] = '/storage/' + product.image;
            }
        });
    } catch (error) {
        console.error('Error loading products:', error);
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

// ============ NAVIGATION FUNCTIONS ============
function goToAddress() {
    if (checkStockIssues()) {
        alert('Some items have stock issues. Please check your cart.');
        return;
    }
    currentStep = 'address';
    displayCart();
}

function goToPayment() {
    if (!selectedAddress) {
        alert('Please select a delivery address');
        return;
    }
    currentStep = 'payment';
    displayCart();
}

function goToSummary() {
    if (!selectedPayment) {
        alert('Please select a payment method');
        return;
    }
    
    // If Pay Online is selected, directly proceed to payment via POST form
    if (selectedPayment === 'online') {
        proceedToPaymentViaForm();
    } else {
        // For COD, go to summary page
        currentStep = 'summary';
        displayCart();
    }
}

// NEW FUNCTION: Submit POST form to buy-now route
function proceedToPaymentViaForm() {
    // Create a form element
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("buy.now") }}';
    
    // Add CSRF token
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = csrfToken;
    form.appendChild(csrfInput);
    
    // Add cart data
    const cartInput = document.createElement('input');
    cartInput.type = 'hidden';
    cartInput.name = 'cart';
    cartInput.value = JSON.stringify(cartData);
    form.appendChild(cartInput);
    
    // Add address data
    const addressInput = document.createElement('input');
    addressInput.type = 'hidden';
    addressInput.name = 'address';
    addressInput.value = JSON.stringify(selectedAddress);
    form.appendChild(addressInput);
    
    // Add payment method
    const paymentInput = document.createElement('input');
    paymentInput.type = 'hidden';
    paymentInput.name = 'payment_method';
    paymentInput.value = selectedPayment;
    form.appendChild(paymentInput);
    
    // Add user email
    const emailInput = document.createElement('input');
    emailInput.type = 'hidden';
    emailInput.name = 'user_email';
    emailInput.value = userEmail;
    form.appendChild(emailInput);
    
    // Append form to body and submit
    document.body.appendChild(form);
    form.submit();
}

function goBackToCart() {
    currentStep = 'cart';
    displayCart();
}

function goBackToAddress() {
    currentStep = 'address';
    displayCart();
}

function goBackToPayment() {
    currentStep = 'payment';
    displayCart();
}

// ============ ADDRESS FUNCTIONS ============
function selectAddress(index) {
    selectedAddress = savedAddresses[index];
    displayCart();
}

function editAddress(index) {
    let addr = savedAddresses[index];
    document.getElementById('newName').value = addr.name || '';
    document.getElementById('newBuilding').value = addr.address || '';
    document.getElementById('newRoad').value = addr.area || '';
    document.getElementById('newCity').value = addr.city || '';
    document.getElementById('newState').value = addr.state || '';
    document.getElementById('newPincode').value = addr.pincode || '';
    document.getElementById('newPhone').value = addr.phone || '';
    
    if (addr.id) {
        deleteAddressFromDatabase(addr.id);
    }
    savedAddresses.splice(index, 1);
    saveAddressesToLocal();
    if (selectedAddress && selectedAddress.id === addr.id) {
        selectedAddress = null;
    }
    
    showAddAddressForm();
}

async function deleteAddress(index) {
    if (confirm('Are you sure you want to delete this address?')) {
        let address = savedAddresses[index];
        if (address.id) {
            await deleteAddressFromDatabase(address.id);
        }
        savedAddresses.splice(index, 1);
        saveAddressesToLocal();
        if (selectedAddress && selectedAddress.id === address.id) {
            selectedAddress = null;
        }
        displayCart();
    }
}

function showAddAddressForm() {
    let form = document.getElementById('addAddressForm');
    if (form) form.classList.add('show');
    let saveBtn = document.getElementById('saveAddressBtn');
    if (saveBtn) saveBtn.disabled = false;
}

function hideAddAddressForm() {
    let form = document.getElementById('addAddressForm');
    if (form) form.classList.remove('show');
    document.getElementById('newName').value = '';
    document.getElementById('newBuilding').value = '';
    document.getElementById('newRoad').value = '';
    document.getElementById('newCity').value = '';
    document.getElementById('newState').value = '';
    document.getElementById('newPincode').value = '';
    document.getElementById('newPhone').value = '';
}

async function saveNewAddress() {
    let pincode = document.getElementById('newPincode').value.trim();
    
    if (!pincode) {
        alert('Please enter a pincode');
        return;
    }
    
    let newAddr = {
        user_id: userId,
        name: document.getElementById('newName').value,
        email: userEmail,
        address: document.getElementById('newBuilding').value,
        area: document.getElementById('newRoad').value,
        city: document.getElementById('newCity').value,
        state: document.getElementById('newState').value,
        pincode: pincode,
        phone: document.getElementById('newPhone').value,
        is_default: savedAddresses.length === 0 ? 1 : 0
    };
    
    if (!newAddr.name || !newAddr.address || !newAddr.city || !newAddr.state || !newAddr.pincode || !newAddr.phone) {
        alert('Please fill all required fields (Name, Building, City, State, Pincode, Phone)');
        return;
    }
    
    let saveBtn = document.getElementById('saveAddressBtn');
    let originalText = saveBtn.innerText;
    saveBtn.innerText = 'Saving...';
    saveBtn.disabled = true;
    
    let savedAddr = await saveAddressToDatabase(newAddr);
    
    if (savedAddr && savedAddr.id) {
        savedAddresses.push(savedAddr);
        alert('✓ Address saved successfully to database!');
        console.log('Address saved to DB:', savedAddr);
    } else {
        newAddr.id = Date.now();
        savedAddresses.push(newAddr);
        alert('⚠ Address saved only locally. Please check your internet connection and make sure you are logged in.');
        console.error('Failed to save to database');
    }
    
    saveAddressesToLocal();
    hideAddAddressForm();
    selectedAddress = savedAddresses[savedAddresses.length - 1];
    
    saveBtn.innerText = originalText;
    saveBtn.disabled = false;
    
    displayCart();
}

function selectPayment(method) {
    selectedPayment = method;
    displayCart();
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
    displayCart();
    updateNavbarCartCount();
};

window.removeItem = function(index) {
    if (confirm('Remove this item?')) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        cart.splice(index, 1);
        localStorage.setItem('cart', JSON.stringify(cart));
        cartData = cart;
        if (cartData.length === 0) {
            currentStep = 'cart';
        }
        displayCart();
        updateNavbarCartCount();
    }
};

// ============ PLACE ORDER FOR COD ============
async function placeOrder() {
    let finalStockCheck = checkStockIssues();
    if (finalStockCheck) {
        alert('Some items are out of stock or quantity exceeds available stock!');
        return;
    }
    
    if (!selectedAddress) {
        alert('Please select a delivery address');
        return;
    }
    
    let checkoutBtn = document.querySelector('.place-order-btn');
    if (checkoutBtn) {
        checkoutBtn.innerHTML = '<i class="fas fa-spinner"></i> Placing Order...';
        checkoutBtn.disabled = true;
    }
    
    try {
        let response = await fetch('/api/set-checkout-cart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ 
                cart: cartData,
                address: selectedAddress,
                payment_method: selectedPayment,
                user_email: userEmail
            })
        });
        
        let data = await response.json();
        
        if (data.success) {
            localStorage.removeItem('cart');
            alert('Order placed successfully! Cash on Delivery selected.');
            window.location.href = '{{ url("/my-orders") }}';
        } else {
            alert(data.message || 'Error placing order');
            displayCart();
        }
    } catch (error) {
        console.error('Order error:', error);
        alert('Network error. Please try again.');
        displayCart();
    }
}

// ============ RENDER FUNCTIONS ============
function displayCart() {
    let container = document.getElementById('cartContainer');
    cartData = JSON.parse(localStorage.getItem('cart')) || [];
    
    if (cartData.length === 0 && currentStep !== 'cart') {
        currentStep = 'cart';
    }
    
    if (cartData.length === 0) {
        container.innerHTML = `
            <div class="empty-cart-card">
                <div class="empty-cart-icon"><i class="fas fa-shopping-bag"></i></div>
                <h3>Your cart is empty</h3>
                <p class="text-muted mb-4">Looks like you haven't added anything to your cart yet.</p>
                <a href="{{ url('/shop') }}" class="next-btn" style="display: inline-flex; width: auto; padding: 0.75rem 2rem; text-decoration: none;">
                    <i class="fas fa-store"></i> Start Shopping
                </a>
            </div>
        `;
        updateNavbarCartCount();
        return;
    }
    
    if (currentStep === 'cart') {
        renderCartStep();
    } else if (currentStep === 'address') {
        renderAddressStep();
    } else if (currentStep === 'payment') {
        renderPaymentStep();
    } else if (currentStep === 'summary') {
        renderSummaryStep();
    }
}

function renderCartStep() {
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
        
        let stockText = stock > 0 ? (stock <= 5 ? `🔥 Only ${stock} left` : 'In Stock') : 'Out of Stock';
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
    
    let userInfoHtml = loggedInUser ? `
        <div class="user-info-card">
            <i class="fas fa-user-circle"></i> <strong>${escapeHtml(loggedInUser.name || 'User')}</strong>
            <div class="user-email"><i class="fas fa-envelope"></i> ${escapeHtml(userEmail)}</div>
        </div>
    ` : '';
    
    let html = `
        <div class="checkout-steps">
            <div class="step active"><i class="fas fa-shopping-cart"></i> Cart</div>
            <div class="step-line"></div>
            <div class="step"><i class="fas fa-map-marker-alt"></i> Address</div>
            <div class="step-line"></div>
            <div class="step"><i class="fas fa-credit-card"></i> Payment</div>
            <div class="step-line"></div>
            <div class="step"><i class="fas fa-check-circle"></i> Summary</div>
        </div>
        <div class="cart-grid">
            <div class="cart-items-card">
                ${userInfoHtml}
                <div class="section-title">Cart Items (${cartData.length})</div>
                ${cartItemsHtml}
            </div>
            <div class="cart-summary">
                <div class="summary-card">
                    <div class="summary-header">Price Details</div>
                    <div class="summary-row">
                        <span>Price (${totalItems} items)</span>
                        <span>₹${subtotal.toLocaleString()}</span>
                    </div>
                    <div class="summary-row">
                        <span>Delivery Charges</span>
                        <span class="text-success">FREE</span>
                    </div>
                    <div class="summary-total">
                        <span>Total Amount</span>
                        <span>₹${subtotal.toLocaleString()}</span>
                    </div>
                    <button class="next-btn" onclick="goToAddress()" ${hasStockIssue ? 'disabled' : ''}>
                        Proceed to Address <i class="fas fa-arrow-right"></i>
                    </button>
                    <a href="{{ url('/shop') }}" class="back-btn" style="display: block; text-align: center; text-decoration: none;">
                        <i class="fas fa-arrow-left"></i> Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('cartContainer').innerHTML = html;
    updateNavbarCartCount();
}

function renderAddressStep() {
    let subtotal = getSubtotal();
    let totalItems = getTotalItems();
    
    let addressesHtml = '';
    
    if (savedAddresses.length === 0) {
        addressesHtml = '<div style="text-align: center; padding: 2rem; color: #64748b;">No addresses saved. Click + ADD NEW ADDRESS to add one.</div>';
    }
    
    savedAddresses.forEach((addr, idx) => {
        let isSelected = selectedAddress && selectedAddress.id === addr.id;
        
        addressesHtml += `
            <div class="address-item ${isSelected ? 'selected' : ''}" onclick="selectAddress(${idx})">
                <div class="radio-select"></div>
                <div class="address-name">
                    ${escapeHtml(addr.name)}
                    <div>
                        <button class="edit-address" onclick="event.stopPropagation(); editAddress(${idx})"><i class="fas fa-edit"></i> EDIT</button>
                        <button class="delete-address" onclick="event.stopPropagation(); deleteAddress(${idx})"><i class="fas fa-trash"></i> DELETE</button>
                    </div>
                </div>
                <div class="address-details">
                    ${escapeHtml(addr.address)}${addr.area ? ', ' + escapeHtml(addr.area) : ''}<br>
                    ${escapeHtml(addr.city)}, ${escapeHtml(addr.state)} - ${addr.pincode}
                </div>
                <div class="address-phone"><i class="fas fa-phone"></i> ${addr.phone}</div>
            </div>
        `;
    });
    
    let html = `
        <div class="checkout-steps">
            <div class="step completed"><i class="fas fa-check"></i> Cart</div>
            <div class="step-line"></div>
            <div class="step active"><i class="fas fa-map-marker-alt"></i> Address</div>
            <div class="step-line"></div>
            <div class="step"><i class="fas fa-credit-card"></i> Payment</div>
            <div class="step-line"></div>
            <div class="step"><i class="fas fa-check-circle"></i> Summary</div>
        </div>
        <div class="cart-grid">
            <div class="address-card">
                <div class="section-title">
                    Select Delivery Address
                    <button class="edit-address" onclick="showAddAddressForm()" style="background: #3b82f6; color: white; border: none; padding: 0.5rem 1rem; border-radius: 40px;">+ ADD NEW ADDRESS</button>
                </div>
                <div class="address-list">
                    ${addressesHtml}
                </div>
                <div id="addAddressForm" class="add-address-form">
                    <h4 style="margin-bottom: 1rem;">Add New Address</h4>
                    <div class="form-group">
                        <label>Full Name <span class="required">*</span></label>
                        <input type="text" id="newName" placeholder="Enter full name" value="${escapeHtml(loggedInUser?.name || '')}">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" id="newEmail" value="${escapeHtml(userEmail)}" readonly>
                    </div>
                    <div class="form-group">
                        <label>House no./ Building name <span class="required">*</span></label>
                        <input type="text" id="newBuilding" placeholder="House/Flat number">
                    </div>
                    <div class="form-group">
                        <label>Road name / Area / Colony</label>
                        <input type="text" id="newRoad" placeholder="Road/Area/Colony">
                    </div>
                    <div class="form-group">
                        <label>City <span class="required">*</span></label>
                        <input type="text" id="newCity" placeholder="City">
                    </div>
                    <div class="form-group">
                        <label>State <span class="required">*</span></label>
                        <input type="text" id="newState" placeholder="State">
                    </div>
                    <div class="form-group">
                        <label>Pincode <span class="required">*</span></label>
                        <input type="text" id="newPincode" placeholder="Pincode" maxlength="10">
                    </div>
                    <div class="form-group">
                        <label>Phone Number <span class="required">*</span></label>
                        <input type="text" id="newPhone" placeholder="Phone number" value="${escapeHtml(loggedInUser?.phone || '')}">
                    </div>
                    <button class="btn-add-address" id="saveAddressBtn" onclick="saveNewAddress()">Save Address</button>
                    <button class="back-btn" onclick="hideAddAddressForm()" style="margin-top: 0.5rem;">Cancel</button>
                </div>
            </div>
            <div class="cart-summary">
                <div class="summary-card">
                    <div class="summary-header">Price Details (${totalItems} items)</div>
                    <div class="summary-row">
                        <span>Product Price</span>
                        <span>+ ₹${subtotal.toLocaleString()}</span>
                    </div>
                    <div class="summary-total">
                        <span>Order Total</span>
                        <span>₹${subtotal.toLocaleString()}</span>
                    </div>
                    <button class="next-btn" id="deliverBtn" onclick="goToPayment()" ${!selectedAddress ? 'disabled' : ''}>
                        Deliver to this Address <i class="fas fa-arrow-right"></i>
                    </button>
                    <button class="back-btn" onclick="goBackToCart()">
                        <i class="fas fa-arrow-left"></i> Back to Cart
                    </button>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('cartContainer').innerHTML = html;
}

function renderPaymentStep() {
    let subtotal = getSubtotal();
    let totalItems = getTotalItems();
    
    let html = `
        <div class="checkout-steps">
            <div class="step completed"><i class="fas fa-check"></i> Cart</div>
            <div class="step-line"></div>
            <div class="step completed"><i class="fas fa-check"></i> Address</div>
            <div class="step-line"></div>
            <div class="step active"><i class="fas fa-credit-card"></i> Payment</div>
            <div class="step-line"></div>
            <div class="step"><i class="fas fa-check-circle"></i> Summary</div>
        </div>
        <div class="cart-grid">
            <div class="payment-card">
                <div class="section-title">Select Payment Method</div>
                <div class="payment-methods">
                    <div class="payment-option ${selectedPayment === 'cod' ? 'selected' : ''}" onclick="selectPayment('cod')">
                        <div class="payment-icon"><i class="fas fa-money-bill-wave"></i></div>
                        <div class="payment-info">
                            <div class="payment-name">Cash on Delivery</div>
                            <div class="payment-desc">Pay when you receive the product</div>
                        </div>
                        <div class="radio-select"></div>
                    </div>
                    <div class="payment-option ${selectedPayment === 'online' ? 'selected' : ''}" onclick="selectPayment('online')">
                        <div class="payment-icon"><i class="fas fa-credit-card"></i></div>
                        <div class="payment-info">
                            <div class="payment-name">Pay Online</div>
                            <div class="payment-desc">Credit/Debit Card, UPI, NetBanking, Wallet</div>
                        </div>
                        <div class="radio-select"></div>
                    </div>
                </div>
                <p style="font-size: 0.75rem; color: #64748b; margin-top: 1rem;">
                    <i class="fas fa-lock"></i> Clicking on 'Continue' will not deduct any money
                </p>
            </div>
            <div class="cart-summary">
                <div class="summary-card">
                    <div class="summary-header">Price Details (${totalItems} items)</div>
                    <div class="summary-row">
                        <span>Product Price</span>
                        <span>+ ₹${subtotal.toLocaleString()}</span>
                    </div>
                    <div class="summary-total">
                        <span>Order Total</span>
                        <span>₹${subtotal.toLocaleString()}</span>
                    </div>
                    <button class="next-btn" onclick="goToSummary()" ${!selectedPayment ? 'disabled' : ''}>
                        Continue <i class="fas fa-arrow-right"></i>
                    </button>
                    <button class="back-btn" onclick="goBackToAddress()">
                        <i class="fas fa-arrow-left"></i> Back to Address
                    </button>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('cartContainer').innerHTML = html;
}

function renderSummaryStep() {
    let subtotal = getSubtotal();
    let totalItems = getTotalItems();
    
    let cartItemsHtml = '';
    for (let item of cartData) {
        let price = parseFloat(item.price);
        let imageUrl = productImages[item.id] || '';
        cartItemsHtml += `
            <div class="cart-item">
                <div class="cart-item-image">
                    ${imageUrl ? `<img src="${imageUrl}" style="width:60px;height:60px;">` : '<div class="image-placeholder" style="font-size:1.5rem;">🏋️</div>'}
                </div>
                <div>
                    <div class="product-title">${escapeHtml(item.name)}</div>
                    <div>Qty: ${item.quantity}</div>
                </div>
                <div class="item-total">₹${(price * item.quantity).toLocaleString()}</div>
            </div>
        `;
    }
    
    let html = `
        <div class="checkout-steps">
            <div class="step completed"><i class="fas fa-check"></i> Cart</div>
            <div class="step-line"></div>
            <div class="step completed"><i class="fas fa-check"></i> Address</div>
            <div class="step-line"></div>
            <div class="step completed"><i class="fas fa-check"></i> Payment</div>
            <div class="step-line"></div>
            <div class="step active"><i class="fas fa-check-circle"></i> Summary</div>
        </div>
        <div class="cart-grid">
            <div class="cart-items-card">
                <div class="section-title">Order Summary</div>
                ${cartItemsHtml}
                <hr>
                <div><strong>Delivery Address:</strong></div>
                <div class="address-details" style="margin-bottom: 1rem;">
                    <strong>${escapeHtml(selectedAddress.name)}</strong><br>
                    ${escapeHtml(selectedAddress.address)}${selectedAddress.area ? ', ' + escapeHtml(selectedAddress.area) : ''}<br>
                    ${escapeHtml(selectedAddress.city)}, ${escapeHtml(selectedAddress.state)} - ${selectedAddress.pincode}<br>
                    Phone: ${selectedAddress.phone}
                </div>
                <div><strong>Payment Method:</strong> ${selectedPayment === 'cod' ? 'Cash on Delivery' : 'Pay Online'}</div>
                <div style="margin-top: 0.5rem;"><strong>Email:</strong> ${escapeHtml(userEmail)}</div>
            </div>
            <div class="cart-summary">
                <div class="summary-card">
                    <div class="summary-header">Price Details (${totalItems} items)</div>
                    <div class="summary-row">
                        <span>Product Price</span>
                        <span>+ ₹${subtotal.toLocaleString()}</span>
                    </div>
                    <div class="summary-total">
                        <span>Order Total</span>
                        <span>₹${subtotal.toLocaleString()}</span>
                    </div>
                    <button class="place-order-btn" onclick="placeOrder()">
                        <i class="fas fa-check-circle"></i> Place Order
                    </button>
                    <button class="back-btn" onclick="goBackToPayment()">
                        <i class="fas fa-arrow-left"></i> Back to Payment
                    </button>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('cartContainer').innerHTML = html;
}

// ============ INITIALIZATION ============
document.addEventListener('DOMContentLoaded', async function() {
    await getLoggedInUser();
    await loadProductsData();
    await loadAddressesFromDatabase();
    cartData = JSON.parse(localStorage.getItem('cart')) || [];
    displayCart();
});
</script>
@endsection