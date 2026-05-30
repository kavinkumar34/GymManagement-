@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2><i class="fas fa-heart text-danger"></i> My Wishlist</h2>
    <p class="text-muted">Products you've saved for later</p>
    
    <div id="wishlistContainer" class="row"></div>
    
    <div id="emptyWishlist" class="text-center py-5" style="display: none;">
        <i class="fas fa-heart-broken" style="font-size: 4rem; color: #ddd;"></i>
        <h4 class="mt-3">Your wishlist is empty</h4>
        <p>Start adding items to your wishlist by clicking the heart icon on products.</p>
        <a href="{{ url('/') }}" class="btn btn-primary">Continue Shopping</a>
    </div>
</div>

<style>
    .wishlist-card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        margin-bottom: 25px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s;
    }
    .wishlist-card:hover {
        transform: translateY(-5px);
    }
    .wishlist-image {
        height: 200px;
        object-fit: cover;
        width: 100%;
    }
    .remove-wishlist {
        background: none;
        border: none;
        color: #ff4757;
        cursor: pointer;
        transition: all 0.3s;
    }
    .remove-wishlist:hover {
        transform: scale(1.1);
    }
    .move-to-cart {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
        border-radius: 25px;
        padding: 8px 20px;
        color: white;
        transition: all 0.3s;
        font-size: 0.85rem;
    }
    .move-to-cart:hover {
        transform: scale(1.05);
    }
    .price-text {
        font-size: 1.2rem;
        font-weight: bold;
        color: #dc3545;
    }
</style>

<script>
    let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    
    // Function to permanently hide wishlist count badge
    function permanentlyHideWishlistCount() {
        let wishlistCountElement = document.getElementById('navbarWishlistCount');
        if (wishlistCountElement) {
            wishlistCountElement.style.display = 'none';
        }
        // Set permanent flag that wishlist has been viewed
        localStorage.setItem('wishlist_permanent_hide', 'true');
    }
    
    // Function to show wishlist count (only when adding new items)
    function showWishlistCount() {
        let count = wishlist.length;
        let wishlistCountElement = document.getElementById('navbarWishlistCount');
        if (wishlistCountElement && count > 0) {
            wishlistCountElement.style.display = '';
            wishlistCountElement.textContent = count;
            wishlistCountElement.classList.remove('hide-badge');
        }
        // Remove the permanent hide flag
        localStorage.removeItem('wishlist_permanent_hide');
    }
    
    function loadWishlist() {
        const container = document.getElementById('wishlistContainer');
        const emptyDiv = document.getElementById('emptyWishlist');
        
        if (wishlist.length === 0) {
            container.style.display = 'none';
            emptyDiv.style.display = 'block';
            localStorage.removeItem('wishlist_permanent_hide');
            return;
        }
        
        container.style.display = 'flex';
        emptyDiv.style.display = 'none';
        
        container.innerHTML = wishlist.map(item => `
            <div class="col-md-3 col-sm-6">
                <div class="wishlist-card card">
                    <div class="position-relative">
                        <img src="${item.image || 'https://via.placeholder.com/300x200?text=Product'}" class="wishlist-image" alt="${item.name}">
                        <button class="remove-wishlist position-absolute top-0 end-0 m-2" onclick="removeFromWishlist(${item.id})" title="Remove from wishlist">
                            <i class="fas fa-times-circle fa-lg"></i>
                        </button>
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title">${item.name}</h5>
                        <p class="price-text">₹${parseFloat(item.price).toLocaleString()}</p>
                        <div class="d-flex gap-2 justify-content-center">
                            <button class="move-to-cart" onclick="addToCartFromWishlist(${item.id}, '${item.name}', ${item.price})">
                                <i class="fas fa-shopping-cart"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
        
        // Permanently hide count after viewing wishlist
        permanentlyHideWishlistCount();
    }
    
    function addToCartFromWishlist(id, name, price) {
        let existingItem = cart.find(item => item.id === id);
        if (existingItem) {
            existingItem.quantity++;
        } else {
            cart.push({
                id: id,
                name: name,
                price: price,
                quantity: 1
            });
        }
        localStorage.setItem('cart', JSON.stringify(cart));
        updateNavbarCartCount();
        showNotification(name + ' added to cart!', 'success');
    }
    
    function removeFromWishlist(id) {
        if(confirm('Remove this item from wishlist?')) {
            wishlist = wishlist.filter(item => item.id !== id);
            localStorage.setItem('wishlist', JSON.stringify(wishlist));
            
            if (wishlist.length === 0) {
                localStorage.removeItem('wishlist_permanent_hide');
            }
            
            loadWishlist();
            
            const heartIcon = document.getElementById(`wishlist-icon-${id}`);
            if (heartIcon) heartIcon.className = 'far fa-heart';
            
            showNotification('Removed from wishlist', 'info');
        }
    }
    
    function updateNavbarCartCount() {
        let count = cart.reduce((total, item) => total + item.quantity, 0);
        let cartCountElement = document.getElementById('navbarCartCount');
        if (cartCountElement) {
            if (count > 0) {
                cartCountElement.textContent = count;
                cartCountElement.classList.remove('hide-badge');
                cartCountElement.style.display = '';
            } else {
                cartCountElement.textContent = '';
                cartCountElement.classList.add('hide-badge');
                cartCountElement.style.display = 'none';
            }
        }
    }
    
    function showNotification(message, type) {
        let notification = document.createElement('div');
        notification.className = 'alert alert-' + (type === 'success' ? 'success' : 'info') + ' alert-dismissible fade show';
        notification.style.position = 'fixed';
        notification.style.top = '20px';
        notification.style.right = '20px';
        notification.style.zIndex = '9999';
        notification.style.minWidth = '250px';
        notification.innerHTML = '<i class="fas fa-check-circle"></i> ' + message + '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
        document.body.appendChild(notification);
        setTimeout(() => notification.remove(), 3000);
    }
    
    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        loadWishlist();
    });
</script>
@endsection