@extends('layouts.app')

@section('content')
<style>
    .track-container {
        max-width: 900px;
        margin: 40px auto;
    }
    .track-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    .track-header {
        background: linear-gradient(135deg, #000000 0%, #1a1a2e 100%);
        padding: 20px;
        text-align: center;
        color: white;
    }
    .track-header i {
        font-size: 2.5rem;
    }
    .track-header h3 {
        margin: 10px 0 0;
        font-size: 1.5rem;
    }
    .track-body {
        padding: 25px;
    }
    .search-box {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 30px;
    }
    .order-status {
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
    }
    .status-pending { background: #fff3cd; border-left: 4px solid #ffc107; }
    .status-confirmed { background: #cfe2ff; border-left: 4px solid #0d6efd; }
    .status-shipped { background: #cff4fc; border-left: 4px solid #0dcaf0; }
    .status-delivered { background: #d1e7dd; border-left: 4px solid #198754; }
    .status-cancelled { background: #f8d7da; border-left: 4px solid #dc3545; }
    .track-btn {
        background: #000000;
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 25px;
        transition: all 0.3s;
    }
    .track-btn:hover {
        background: #dc3545;
    }
</style>

<div class="container track-container">
    <div class="card track-card">
        <div class="track-header">
            <i class="fas fa-truck"></i>
            <h3>Track Your Order</h3>
            <p style="margin: 5px 0 0; opacity: 0.8;">Enter your order number to track status</p>
        </div>
        <div class="track-body">
            <!-- Search Form -->
            <div class="search-box">
                <form method="GET" action="{{ route('track.order') }}" id="trackForm">
                    <div class="row g-2">
                        <div class="col-md-8">
                            <input type="text" name="order_number" class="form-control" 
                                   placeholder="Enter Order Number (e.g., ORD1234567890)" 
                                   value="{{ request('order_number') }}" required>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="track-btn w-100">
                                <i class="fas fa-search"></i> Track Order
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Order Results -->
            @if(request('order_number'))
                @if($order)
                    <div class="order-status status-{{ strtolower($order->order_status) }}">
                        <div class="row">
                            <div class="col-md-6">
                                <h5><i class="fas fa-receipt"></i> Order #{{ $order->order_number }}</h5>
                                <p><strong>Order Date:</strong> {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y, h:i A') }}</p>
                                <p><strong>Total Amount:</strong> ₹{{ number_format($order->total_amount, 2) }}</p>
                            </div>
                            <div class="col-md-6">
                                <h5><i class="fas fa-info-circle"></i> Order Status</h5>
                                @if($order->order_status == 'Pending')
                                    <span class="badge bg-warning" style="font-size: 1rem;">⏳ Pending</span>
                                @elseif($order->order_status == 'Confirmed')
                                    <span class="badge bg-primary" style="font-size: 1rem;">✅ Confirmed</span>
                                @elseif($order->order_status == 'Shipped')
                                    <span class="badge bg-info" style="font-size: 1rem;">📦 Shipped</span>
                                @elseif($order->order_status == 'Delivered')
                                    <span class="badge bg-success" style="font-size: 1rem;">🏠 Delivered</span>
                                @elseif($order->order_status == 'Cancelled')
                                    <span class="badge bg-danger" style="font-size: 1rem;">❌ Cancelled</span>
                                @endif
                                
                                @if($order->order_status == 'Shipped')
                                    <p class="mt-2"><i class="fas fa-truck"></i> Your order is on the way!</p>
                                @elseif($order->order_status == 'Delivered')
                                    <p class="mt-2"><i class="fas fa-check-circle"></i> Order delivered successfully!</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <h5>Order Items</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-dark">
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
                        </table>
                    </div>
                @else
                    <div class="alert alert-danger text-center">
                        <i class="fas fa-exclamation-circle"></i> Order not found! Please check your order number.
                    </div>
                @endif
            @else
                <div class="text-center text-muted py-4">
                    <i class="fas fa-search" style="font-size: 3rem;"></i>
                    <p class="mt-2">Enter your order number to track status</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection