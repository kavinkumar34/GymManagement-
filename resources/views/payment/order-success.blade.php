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
    .success-body {
        padding: 25px;
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
    }
    .btn-secondary-custom {
        background: #6c757d;
        color: white;
        padding: 10px 25px;
        border-radius: 25px;
        text-decoration: none;
        display: inline-block;
        margin: 5px;
        transition: all 0.3s;
    }
    .btn-secondary-custom:hover {
        background: #5a6268;
        transform: translateY(-2px);
    }
    .grand-total {
        background: #f8f9fa;
        font-weight: bold;
    }
    .grand-total td {
        padding: 12px;
    }
</style>

<div class="container success-container">
    <div class="card success-card">
        <div class="success-header">
            <i class="fas fa-check-circle"></i>
            <h3>Payment Successful!</h3>
            <p style="margin: 5px 0 0; opacity: 0.9;">Thank you for your purchase!</p>
        </div>
        <div class="success-body">
            <!-- Order Details -->
            <div class="row">
                <div class="col-md-6">
                    <h5 style="margin-bottom: 15px; color: #333;"><i class="fas fa-receipt"></i> Order Details</h5>
                    <table class="order-details-table">
                        <tr><td>Order Number</td><td><strong>{{ $order->order_number }}</strong></td></tr>
                        <tr><td>Order Date</td><td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y, h:i A') }}</td></tr>
                        <tr><td>Payment Status</td><td><span class="badge bg-success">Paid</span></td></tr>
                        <tr><td>Total Amount</td><td><strong style="color: #28a745;">₹{{ number_format($order->total_amount, 2) }}</strong></td></tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 style="margin-bottom: 15px; color: #333;"><i class="fas fa-user"></i> Customer Details</h5>
                    <table class="order-details-table">
                        <tr><td>Name</td><td>{{ Auth::user()->name }}</td></tr>
                        <tr><td>Email</td><td>{{ Auth::user()->email }}</td></tr>
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
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product_name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>₹{{ number_format($item->price, 2) }}</td>
                            <td>₹{{ number_format($item->price * $item->quantity, 2) }}</td>
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
                <a href="{{ route('track.order') }}" class="btn-secondary-custom">
                    <i class="fas fa-truck"></i> View My Orders
                </a>
            </div>
        </div>
    </div>
</div>
<script>
    // Clear cart from localStorage when order success page loads
    localStorage.removeItem('cart');
    
    // Update navbar cart count
    let cartCountElement = document.getElementById('navbarCartCount');
    if (cartCountElement) {
        cartCountElement.innerText = 0;
        cartCountElement.classList.add('hide-badge');
        cartCountElement.style.display = 'none';
    }
    
    // Clear any stored checkout cart
    sessionStorage.removeItem('checkout_cart');
</script>
@endsection