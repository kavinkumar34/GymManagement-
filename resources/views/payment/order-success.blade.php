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
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
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
            background: rgba(255, 255, 255, 0.2);
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

        .shipping-row {
            background: #f8fafc;
        }

        .shipping-row td {
            color: #0f172a;
        }

        .subtotal-row td {
            color: #475569;
        }

        .discount-row td {
            color: #15803d;
        }

        .grand-total-row td {
            font-size: 1.1rem;
            padding: 15px 12px;
        }

        .grand-total-row .grand-total-label {
            font-size: 1.1rem;
        }

        .grand-total-row .grand-total-amount {
            font-size: 1.3rem;
            color: #28a745;
        }

        .payment-method-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .payment-cod {
            background: #fef3c7;
            color: #92400e;
        }

        .payment-online {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .shipping-address-box {
            background: #f8fafc;
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            margin-top: 5px;
        }

        .shipping-address-box p {
            margin: 3px 0;
            font-size: 14px;
            color: #475569;
        }

        .shipping-address-box .address-label {
            font-weight: 600;
            color: #1e293b;
        }

        /* Original Price Styling */
        .original-price {
            text-decoration: line-through;
            color: #999;
            font-size: 12px;
            margin-right: 5px;
        }

        .discount-tag {
            background: #dc3545;
            color: white;
            padding: 1px 8px;
            border-radius: 4px;
            font-size: 10px;
            margin-left: 5px;
        }

        .final-price {
            font-weight: 600;
            color: #0f172a;
        }

        .price-wrapper {
            display: flex;
            align-items: center;
            gap: 5px;
            flex-wrap: wrap;
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
                        We've sent the order details to
                        <strong>{{ Auth::user()->email ?? ($order->user->email ?? 'your registered email') }}</strong>
                    </span>
                </div>

                <!-- Order Details -->
                <div class="row">
                    <div class="col-md-6">
                        <h5 style="margin-bottom: 15px; color: #333;"><i class="fas fa-receipt"></i> Order Details</h5>
                        <table class="order-details-table">
                            <tr>
                                <td>Order Number</td>
                                <td><strong>{{ $order->order_number }}</strong></td>
                            </tr>
                            <tr>
                                <td>Order Date</td>
                                <td>{{ \Carbon\Carbon::parse($order->order_date ?? $order->created_at)->setTimezone('Asia/Kolkata')->format('d M Y, g:i A') }}
                                </td>
                            </tr>
                            <tr>
                                <td>Payment Status</td>
                                <td><span class="badge bg-success">Paid</span></td>
                            </tr>
                            <tr>
                                <td>Payment Method</td>
                                <td>
                                    @if ($order->payment_method == 'COD')
                                        <span class="payment-method-badge payment-cod"><i
                                                class="fas fa-money-bill-wave"></i> Cash on Delivery</span>
                                    @else
                                        <span class="payment-method-badge payment-online"><i class="fas fa-credit-card"></i>
                                            {{ $order->payment_method ?? 'Online' }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Order Status</td>
                                <td>
                                    <span class="order-status-badge status-{{ strtolower($order->order_status) }}">
                                        {{ $order->order_status }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h5 style="margin-bottom: 15px; color: #333;"><i class="fas fa-user"></i> Customer Details</h5>
                        <table class="order-details-table">
                            <tr>
                                <td>Name</td>
                                <td>{{ Auth::user()->name ?? ($order->user->name ?? 'N/A') }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>{{ Auth::user()->email ?? ($order->user->email ?? 'N/A') }}</td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td>{{ Auth::user()->phone ?? ($order->user->phone ?? 'N/A') }}</td>
                            </tr>
                        </table>

                        <!-- Shipping Address -->
                        @php
                            $shippingAddress = null;
                            if ($order->payment_details) {
                                try {
                                    $paymentDetails = is_string($order->payment_details)
                                        ? json_decode($order->payment_details, true)
                                        : $order->payment_details;
                                    if (isset($paymentDetails['shipping_address'])) {
                                        $shippingAddress = $paymentDetails['shipping_address'];
                                    } elseif (isset($paymentDetails['address'])) {
                                        $shippingAddress = $paymentDetails['address'];
                                    }
                                } catch (\Exception $e) {
                                }
                            }
                        @endphp

                        @if ($shippingAddress)
                            <h5 style="margin: 15px 0 10px; color: #333; font-size: 14px;">
                                <i class="fas fa-truck"></i> Shipping Address
                            </h5>
                            <div class="shipping-address-box">
                                <p><span class="address-label">Name:</span> {{ $shippingAddress['name'] ?? 'N/A' }}</p>
                                <p><span class="address-label">Address:</span> {{ $shippingAddress['address'] ?? '' }}</p>
                                @if (isset($shippingAddress['area']) && $shippingAddress['area'])
                                    <p><span class="address-label">Area:</span> {{ $shippingAddress['area'] }}</p>
                                @endif
                                <p><span class="address-label">City:</span> {{ $shippingAddress['city'] ?? '' }},
                                    {{ $shippingAddress['state'] ?? '' }} - {{ $shippingAddress['pincode'] ?? '' }}</p>
                                <p><span class="address-label">Phone:</span> {{ $shippingAddress['phone'] ?? 'N/A' }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Order Items -->
                <h5 style="margin: 20px 0 15px; color: #333;"><i class="fas fa-box"></i> Order Items</h5>
                <div class="table-responsive">
                    <table class="items-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $subtotal = 0;
                                $shippingCharge = $order->shipping_charge ?? 0;
                                $couponDiscount = 0;
                                $couponCode = null;

                                // Get coupon discount from payment_details if available
                                if ($order->payment_details) {
                                    try {
                                        $paymentDetails = is_string($order->payment_details)
                                            ? json_decode($order->payment_details, true)
                                            : $order->payment_details;
                                        if (isset($paymentDetails['coupon_discount'])) {
                                            $couponDiscount = floatval($paymentDetails['coupon_discount']);
                                        }
                                        if (isset($paymentDetails['coupon_code'])) {
                                            $couponCode = $paymentDetails['coupon_code'];
                                        }
                                    } catch (\Exception $e) {
                                    }
                                }
                            @endphp

                            @foreach ($order->items as $item)
                                @php
                                    // 🔥 IMPORTANT: Use final_price (discounted price) if available
                                    $itemPrice = $item->final_price ?? ($item->price ?? 0);
                                    $itemTotal = $itemPrice * $item->quantity;
                                    $subtotal += $itemTotal;

                                    // Check if there's a difference between price and final_price (discount applied)
                                    $hasDiscount = isset($item->final_price) && $item->final_price < $item->price;
                                    $discountPercent = $hasDiscount
                                        ? round((($item->price - $item->final_price) / $item->price) * 100)
                                        : 0;
                                @endphp
                                <tr>
                                    <td>
                                        {{ $item->product_name }}
                                        @if (isset($item->size) && $item->size)
                                            <br><small style="color: #64748b; font-size: 11px;">Size:
                                                {{ $item->size }}</small>
                                        @endif
                                        @if (isset($item->color) && $item->color)
                                            <br><small style="color: #64748b; font-size: 11px;">Color:
                                                {{ $item->color }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>
                                        <div class="price-wrapper">
                                            @if ($hasDiscount)
                                                <span class="original-price">₹{{ number_format($item->price, 2) }}</span>
                                                <span class="final-price">₹{{ number_format($itemPrice, 2) }}</span>
                                                <span class="discount-tag">{{ $discountPercent }}% off</span>
                                            @else
                                                <span class="final-price">₹{{ number_format($itemPrice, 2) }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="final-price">₹{{ number_format($itemTotal, 2) }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <!-- Subtotal Row -->
                            <tr class="subtotal-row">
                                <td colspan="3" style="text-align: right;"><strong>Subtotal</strong></td>
                                <td><strong>₹{{ number_format($subtotal, 2) }}</strong></td>
                            </tr>

                            <!-- Shipping Charge Row -->
                            <tr class="shipping-row">
                                <td colspan="3" style="text-align: right;">
                                    <strong>
                                        <i class="fas fa-truck"></i> Shipping Charge
                                        @if ($shippingCharge > 0)
                                            <span style="font-size: 12px; color: #64748b; font-weight: normal;">(Delivery
                                                Fee)</span>
                                        @else
                                            <span style="font-size: 12px; color: #15803d; font-weight: normal;">(Free
                                                Delivery)</span>
                                        @endif
                                    </strong>
                                </td>
                                <td>
                                    @if ($shippingCharge > 0)
                                        <strong style="color: #0f172a;">+ ₹{{ number_format($shippingCharge, 2) }}</strong>
                                    @else
                                        <strong style="color: #15803d;">Free</strong>
                                    @endif
                                </td>
                            </tr>

                            <!-- Coupon Discount Row (if applicable) -->
                            @if ($couponDiscount > 0)
                                <tr class="discount-row">
                                    <td colspan="3" style="text-align: right;">
                                        <strong>
                                            <i class="fas fa-ticket-alt"></i> Coupon Discount
                                            @if ($couponCode)
                                                <span
                                                    style="font-size: 12px; font-weight: normal;">({{ $couponCode }})</span>
                                            @endif
                                        </strong>
                                    </td>
                                    <td><strong>- ₹{{ number_format($couponDiscount, 2) }}</strong></td>
                                </tr>
                            @endif

                            <!-- Grand Total Row -->
                            <tr class="grand-total grand-total-row">
                                <td colspan="3" style="text-align: right;">
                                    <strong class="grand-total-label"><i class="fas fa-rupee-sign"></i> Grand Total</strong>
                                </td>
                                <td>
                                    <strong
                                        class="grand-total-amount">₹{{ number_format($order->total_amount, 2) }}</strong>
                                </td>
                            </tr>

                            <!-- COD Payment Info -->
                            @if ($order->payment_method == 'COD')
                                <tr>
                                    <td colspan="4"
                                        style="padding: 12px; background: #fef3c7; border-radius: 0 0 10px 10px;">
                                        <small style="color: #92400e;">
                                            <i class="fas fa-money-bill-wave"></i>
                                            <strong>Cash on Delivery</strong> - Pay
                                            ₹{{ number_format($order->total_amount, 2) }} when your order arrives
                                        </small>
                                    </td>
                                </tr>
                            @endif
                        </tfoot>
                    </table>
                </div>

                <!-- Mobile Order Summary Card -->
                <div class="d-md-none mt-3">
                    <div class="card" style="border-radius: 12px; border: 1px solid #e2e8f0;">
                        <div class="card-body">
                            <h6 style="font-weight: 700; margin-bottom: 12px;">Order Summary</h6>
                            <div style="display: flex; justify-content: space-between; padding: 5px 0; font-size: 14px;">
                                <span style="color: #64748b;">Subtotal</span>
                                <span>₹{{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 5px 0; font-size: 14px;">
                                <span style="color: #64748b;">Shipping</span>
                                @if ($shippingCharge > 0)
                                    <span>₹{{ number_format($shippingCharge, 2) }}</span>
                                @else
                                    <span style="color: #15803d;">Free</span>
                                @endif
                            </div>
                            @if ($couponDiscount > 0)
                                <div
                                    style="display: flex; justify-content: space-between; padding: 5px 0; font-size: 14px; color: #15803d;">
                                    <span>Coupon Discount</span>
                                    <span>- ₹{{ number_format($couponDiscount, 2) }}</span>
                                </div>
                            @endif
                            <hr style="margin: 8px 0;">
                            <div
                                style="display: flex; justify-content: space-between; padding: 8px 0; font-size: 16px; font-weight: 700;">
                                <span>Total</span>
                                <span style="color: #28a745;">₹{{ number_format($order->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>
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

                <!-- Track Order Link -->
                <div class="text-center mt-2">
                    <a href="{{ route('track.order') }}" style="color: #3b82f6; text-decoration: none; font-size: 14px;">
                        <i class="fas fa-search"></i> Track Your Order
                    </a>
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
