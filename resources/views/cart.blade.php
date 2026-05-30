@extends('layouts.app')

@section('content')
<style>
    .cart-table {
        width: 100%;
        border-collapse: collapse;
    }
    .cart-table th, .cart-table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    .cart-table th {
        background-color: #1a1a2e;
        color: white;
    }
    .cart-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
    }
    .quantity-control {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .quantity-control button {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: none;
        background: #e0e0e0;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
    }
    .quantity-control button:hover {
        background: #dc3545;
        color: white;
    }
    .quantity-control button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    .btn-remove {
        background: #dc3545;
        color: white;
        border: none;
        padding: 5px 12px;
        border-radius: 5px;
        cursor: pointer;
    }
    .btn-remove:hover {
        background: #a71d2a;
    }
    .stock-badge {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 20px;
        font-size: 11px;
    }
    .stock-available {
        background: #d4edda;
        color: #155724;
    }
    .stock-low {
        background: #fff3cd;
        color: #856404;
    }
    .stock-out {
        background: #f8d7da;
        color: #721c24;
    }
    .empty-cart {
        text-align: center;
        padding: 50px;
    }
    .summary-card {
        margin-top: 20px;
        padding: 20px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
</style>

<div class="container mt-4">
    <h2><i class="fas fa-shopping-cart"></i> My Cart</h2>
    
    <div id="cartContainer">
        <div class="text-center py-5">
            <i class="fas fa-spinner fa-spin fa-2x"></i>
            <p>Loading cart...</p>
        </div>
    </div>
</div>

<script>
// Global variables
let productStock = {};
let productImages = {};

// Load everything when page loads
document.addEventListener('DOMContentLoaded', async function() {
    await loadProductsData();
    displayCart();
});

// Load product stocks and images from database
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

// Display cart
function displayCart() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let container = document.getElementById('cartContainer');
    
    if (cart.length === 0) {
        container.innerHTML = `
            <div class="empty-cart">
                <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
                <h4>Your cart is empty</h4>
                <p>Add some products to your cart!</p>
                <a href="{{ url('/') }}" class="btn btn-primary">Continue Shopping</a>
            </div>
        `;
        return;
    }
    
    let subtotal = 0;
    let totalItems = 0;
    let hasStockIssue = false;
    
    let tableHtml = `
        <div class="table-responsive">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Stock Status</th>
                        <th>Total</th>
                        <th>Action</th>
                    </td>
                </thead>
                <tbody>
    `;
    
    for (let i = 0; i < cart.length; i++) {
        let item = cart[i];
        let stock = productStock[item.id] || 0;
        let qty = item.quantity;
        let price = parseFloat(item.price);
        let itemTotal = price * qty;
        
        subtotal += itemTotal;
        totalItems += qty;
        
        // Stock status
        let stockText = '';
        let stockClass = '';
        if (stock <= 0) {
            stockText = 'Out of Stock';
            stockClass = 'stock-out';
            hasStockIssue = true;
        } else if (stock <= 5) {
            stockText = 'Only ' + stock + ' left!';
            stockClass = 'stock-low';
        } else {
            stockText = 'In Stock';
            stockClass = 'stock-available';
        }
        
        if (qty > stock && stock > 0) {
            stockText = 'Only ' + stock + ' available!';
            stockClass = 'stock-out';
            hasStockIssue = true;
        }
        
        // Get image
        let imageUrl = productImages[item.id] || '';
        
        tableHtml += `
            <tr>
                <td><strong>${escapeHtml(item.name)}</strong></td>
                <td class="text-center">
                    ${imageUrl ? `<img src="${imageUrl}" class="cart-image" alt="${escapeHtml(item.name)}">` : '<div style="width:60px;height:60px;background:#f0f0f0;border-radius:8px;display:flex;align-items:center;justify-content:center;">📷</div>'}
                 </div>
                <td>₹${price}</div>
                <td>
                    <div class="quantity-control">
                        <button onclick="updateQty(${i}, -1)">-</button>
                        <span>${qty}</span>
                        <button onclick="updateQty(${i}, 1)" ${(qty >= stock && stock > 0) ? 'disabled' : ''}>+</button>
                    </div>
                 </div>
                <td><span class="stock-badge ${stockClass}">${stockText}</span></div>
                <td>₹${itemTotal}</div>
                <td><button class="btn-remove" onclick="removeItem(${i})">Remove</button></div>
            </tr>
        `;
    }
    
    tableHtml += `
                </tbody>
            </table>
        </div>
        
        <div class="summary-card">
            <h4>Cart Summary</h4>
            <p><strong>Total Items:</strong> ${totalItems}</p>
            <p><strong>Subtotal:</strong> ₹${subtotal.toLocaleString()}</p>
            <hr>
            <h3>Total: ₹${subtotal.toLocaleString()}</h3>
            <button class="btn btn-primary mt-3" id="checkoutBtn" onclick="checkout()" ${hasStockIssue ? 'disabled' : ''}>
                Proceed to Checkout
            </button>
        </div>
    `;
    
    container.innerHTML = tableHtml;
}

// Update quantity
window.updateQty = async function(index, change) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    if (index >= cart.length) return;
    
    let item = cart[index];
    let stock = productStock[item.id] || 0;
    let newQty = item.quantity + change;
    
    if (newQty < 1) {
        if (confirm('Remove this item?')) {
            cart.splice(index, 1);
        } else {
            return;
        }
    } else if (newQty > stock && stock > 0) {
        alert(`Only ${stock} items available in stock!`);
        return;
    } else {
        item.quantity = newQty;
    }
    
    localStorage.setItem('cart', JSON.stringify(cart));
    displayCart();
    updateNavbarCartCount();
};

// Remove item
window.removeItem = function(index) {
    if (confirm('Remove this item from cart?')) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        cart.splice(index, 1);
        localStorage.setItem('cart', JSON.stringify(cart));
        displayCart();
        updateNavbarCartCount();
    }
};

// Update navbar cart count
function updateNavbarCartCount() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let count = cart.reduce((sum, item) => sum + item.quantity, 0);
    let badge = document.getElementById('navbarCartCount');
    if (badge) {
        badge.innerText = count > 0 ? count : '';
        badge.style.display = count > 0 ? '' : 'none';
    }
}

// Checkout
window.checkout = async function() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    if (cart.length === 0) {
        alert('Your cart is empty!');
        return;
    }
    
    for (let item of cart) {
        let stock = productStock[item.id] || 0;
        if (item.quantity > stock) {
            alert(`${item.name}: Only ${stock} items available!`);
            return;
        }
    }
    
    try {
        let response = await fetch('/api/set-checkout-cart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ cart: cart })
        });
        
        let data = await response.json();
        
        if (data.success) {
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("buy.now") }}';
            let csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            form.appendChild(csrf);
            document.body.appendChild(form);
            form.submit();
        } else {
            alert('Error processing checkout');
        }
    } catch (error) {
        console.error(error);
        alert('Error processing checkout');
    }
};

// Escape HTML
function escapeHtml(text) {
    if (!text) return '';
    return text.replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}
</script>
@endsection