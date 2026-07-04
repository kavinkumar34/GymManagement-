@extends('layouts.app')

@section('content')
<style>
    .success-container {
        max-width: 800px;
        margin: 40px auto;
    }
    .success-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    .success-header {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        padding: 20px;
        text-align: center;
        color: white;
    }
    .success-header i {
        font-size: 3rem;
    }
    .success-header h3 {
        margin: 10px 0 0;
        font-size: 1.5rem;
    }
    .success-header .sub-text {
        margin: 5px 0 0;
        opacity: 0.9;
        font-size: 14px;
    }
    .email-sent-badge {
        display: inline-block;
        background: rgba(255,255,255,0.2);
        padding: 4px 15px;
        border-radius: 20px;
        font-size: 12px;
        margin-top: 8px;
    }
    .order-details-table {
        width: 100%;
        margin-bottom: 20px;
    }
    .order-details-table td {
        padding: 10px;
        border-bottom: 1px solid #eee;
    }
    .order-details-table td:first-child {
        font-weight: bold;
        width: 40%;
        color: #555;
    }
    .order-details-table td:last-child {
        color: #333;
    }
    .items-table {
        width: 100%;
        border-collapse: collapse;
    }
    .items-table th {
        background: #f8f9fa;
        padding: 10px;
        text-align: left;
        font-weight: bold;
        border-bottom: 2px solid #ddd;
    }
    .items-table td {
        padding: 10px;
        border-bottom: 1px solid #eee;
    }
    .btn-success-custom {
        background: #28a745;
        color: white;
        padding: 10px 25px;
        border-radius: 25px;
        text-decoration: none;
        display: inline-block;
        margin: 5px;
        transition: all 0.3s;
    }
    .btn-success-custom:hover {
        background: #218838;
        transform: translateY(-2px);
        color: white;
    }
    .btn-primary-custom {
        background: #3b82f6;
        color: white;
        padding: 10px 25px;
        border-radius: 25px;
        text-decoration: none;
        display: inline-block;
        margin: 5px;
        transition: all 0.3s;
    }
    .btn-primary-custom:hover {
        background: #2563eb;
        transform: translateY(-2px);
        color: white;
    }
    .grand-total {
        background: #f8f9fa;
        font-weight: bold;
    }
    .grand-total td {
        padding: 12px;
    }
    .order-status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    .status-confirmed {
        background: #dbeafe;
        color: #1d4ed8;
    }
    .status-pending {
        background: #fef9c3;
        color: #854d0e;
    }
    .status-shipped {
        background: #e0e7ff;
        color: #3730a3;
    }
    .status-delivered {
        background: #dcfce7;
        color: #15803d;
    }
    .email-info-box {
        background: #eff6ff;
        border-left: 4px solid #3b82f6;
        padding: 12px 15px;
        border-radius: 8px;
        margin: 15px 0;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
    }
    .email-info-box i {
        color: #3b82f6;
        font-size: 18px;
    }
    .email-info-box span {
        color: #475569;
    }
    .email-info-box strong {
        color: #1e293b;
    }
</style>

<div class="container success-container">
    <div class="card success-card">
        <div class="success-header">
            <i class="fas fa-check-circle"></i>
            <h3>Payment Successful!</h3>
            <p class="sub-text">Thank you for your purchase!</p>
          
        </div>
        <div class="success-body p-4">
            <!-- Email Confirmation Notice -->
            <div class="email-info-box">
                <i class="fas fa-envelope"></i>
                <span>
                    <strong>Order confirmation email sent!</strong><br>
                    We've sent the order details to <strong>{{ Auth::user()->email ?? $order->user->email ?? 'your registered email' }}</strong>
                </span>
            </div>

            <!-- Order Details -->
            <div class="row">
                <div class="col-md-6">
                    <h5 style="margin-bottom: 15px; color: #333;"><i class="fas fa-receipt"></i> Order Details</h5>
                    <table class="order-details-table">
                        <tr><td>Order Number</td><td><strong>{{ $order->order_number }}</strong></td></tr>
<tr><td>Order Date</td><td>{{ \Carbon\Carbon::parse($order->order_date ?? $order->created_at)->setTimezone('Asia/Kolkata')->format('d M Y, g:i A') }}</td></tr>                        
<tr><td>Payment Status</td><td><span class="badge bg-success">Paid</span></td></tr>
                        <tr><td>Total Amount</td><td><strong style="color: #28a745;">₹{{ number_format($order->total_amount, 2) }}</strong></td></tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 style="margin-bottom: 15px; color: #333;"><i class="fas fa-user"></i> Customer Details</h5>
                    <table class="order-details-table">
                        <tr><td>Name</td><td>{{ Auth::user()->name ?? $order->user->name ?? 'N/A' }}</td></tr>
                        <tr><td>Email</td><td>{{ Auth::user()->email ?? $order->user->email ?? 'N/A' }}</td></tr>
                    </table>
                </div>
            </div>

            <!-- Order Items -->
            <h5 style="margin: 20px 0 15px; color: #333;"><i class="fas fa-box"></i> Order Items</h5>
            <div class="table-responsive">
                <table class="items-table">
                    <thead>
                        <tr><th>Product</th><th>Quantity</th><th>Price</th><th>Total</th></tr>
                    </thead>
                    <tbody>
                        @php $subtotal = 0; @endphp
                        @foreach($order->items as $item)
                        @php $itemTotal = $item->price * $item->quantity; $subtotal += $itemTotal; @endphp
                        <tr>
                            <td>{{ $item->product_name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>₹{{ number_format($item->price, 2) }}</td>
                            <td>₹{{ number_format($itemTotal, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="grand-total">
                            <td colspan="3" style="text-align: right;"><strong>Grand Total</strong></td>
                            <td><strong>₹{{ number_format($order->total_amount, 2) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Buttons -->
            <div class="text-center mt-4">
                <a href="{{ url('/') }}" class="btn-success-custom">
                    <i class="fas fa-shopping-cart"></i> Continue Shopping
                </a>
                <a href="{{ route('my.orders') }}" class="btn-primary-custom">
                    <i class="fas fa-list-ul"></i> View My Orders
                </a>
            </div>
            
            <div class="text-center mt-3">
                <small class="text-muted">
                    <i class="fas fa-envelope"></i> A confirmation email has been sent to your registered email address.
                </small>
            </div>
        </div>
    </div>
</div>

<script>
    // Clear cart from localStorage when order success page loads
    if (typeof localStorage !== 'undefined') {
        localStorage.removeItem('cart');
        localStorage.removeItem('checkout_cart');
    }
    
    // Clear session storage
    if (typeof sessionStorage !== 'undefined') {
        sessionStorage.removeItem('checkout_cart');
    }
    
    // Update navbar cart count
    let cartCountElement = document.getElementById('navbarCartCount');
    if (cartCountElement) {
        cartCountElement.innerText = 0;
        cartCountElement.classList.add('hide-badge');
        cartCountElement.style.display = 'none';
    }
    
    // Update wishlist count if needed
    let wishlistCountElement = document.getElementById('navbarWishlistCount');
    if (wishlistCountElement) {
        // Don't clear wishlist, just refresh count
        let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        let count = wishlist.length;
        if (count > 0) {
            wishlistCountElement.innerText = count;
            wishlistCountElement.classList.remove('hide-badge');
            wishlistCountElement.style.display = 'inline-flex';
        } else {
            wishlistCountElement.innerText = '';
            wishlistCountElement.classList.add('hide-badge');
            wishlistCountElement.style.display = 'none';
        }
    }
    
    // Store that order was successful (optional)
    localStorage.setItem('last_order_successful', Date.now());
</script>
@endsection