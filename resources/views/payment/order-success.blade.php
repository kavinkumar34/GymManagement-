@extends('layouts.app')

@section('content')
    <style>
        .success-container {
            max-width: 820px;
            margin: 30px auto;
            padding: 0 15px;
        }

        .success-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            background: white;
        }

        .success-header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            padding: 25px 20px;
            text-align: center;
            color: white;
            position: relative;
        }

        .success-header i {
            font-size: 3.5rem;
        }

        .success-header h3 {
            margin: 10px 0 0;
            font-size: 1.6rem;
            font-weight: 700;
        }

        .success-header .sub-text {
            margin: 5px 0 0;
            opacity: 0.9;
            font-size: 14px;
        }

        .email-sent-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            padding: 5px 18px;
            border-radius: 20px;
            font-size: 12px;
            margin-top: 10px;
        }

        .email-sent-badge i {
            font-size: 12px;
            margin-right: 5px;
        }

        .success-body {
            padding: 25px 30px;
        }

        .email-info-box {
            background: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 12px 18px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
        }

        .email-info-box i {
            color: #3b82f6;
            font-size: 18px;
            flex-shrink: 0;
        }

        .email-info-box span {
            color: #475569;
        }

        .email-info-box strong {
            color: #1e293b;
        }

        .order-details-table {
            width: 100%;
            margin-bottom: 15px;
        }

        .order-details-table td {
            padding: 8px 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
        }

        .order-details-table td:first-child {
            font-weight: 600;
            width: 45%;
            color: #64748b;
        }

        .order-details-table td:last-child {
            color: #1e293b;
            font-weight: 500;
        }

        .order-details-table tr:last-child td {
            border-bottom: none;
        }

        .section-title {
            font-size: 16px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title i {
            color: #dc3545;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .items-table th {
            background: #f8fafc;
            padding: 10px 12px;
            text-align: left;
            font-weight: 600;
            color: #475569;
            border-bottom: 2px solid #e2e8f0;
        }

        .items-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #f1f5f9;
            color: #1e293b;
        }

        .items-table tr:last-child td {
            border-bottom: none;
        }

        .order-status-badge {
            display: inline-block;
            padding: 4px 14px;
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

        .payment-method-badge {
            display: inline-block;
            padding: 4px 14px;
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
            padding: 12px 16px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            margin-top: 5px;
            font-size: 13px;
            line-height: 1.6;
        }

        .shipping-address-box p {
            margin: 2px 0;
            color: #475569;
        }

        .shipping-address-box .address-label {
            font-weight: 600;
            color: #1e293b;
        }

        .price-wrapper {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .original-price {
            text-decoration: line-through;
            color: #999;
            font-size: 12px;
        }

        .discount-tag {
            background: #dc3545;
            color: white;
            padding: 1px 8px;
            border-radius: 4px;
            font-size: 10px;
        }

        .final-price {
            font-weight: 600;
            color: #0f172a;
        }

        .subtotal-row td {
            color: #475569;
        }

        .shipping-row td {
            color: #0f172a;
        }

        .discount-row td {
            color: #15803d;
        }

        .grand-total-row td {
            padding: 15px 12px;
            border-top: 2px solid #e2e8f0;
        }

        .grand-total-label {
            font-size: 16px;
            font-weight: 700;
            color: #1e293b;
        }

        .grand-total-amount {
            font-size: 20px;
            font-weight: 700;
            color: #28a745;
        }

        .btn-success-custom {
            background: #28a745;
            color: white;
            padding: 10px 30px;
            border-radius: 30px;
            text-decoration: none;
            display: inline-block;
            margin: 5px;
            transition: all 0.3s;
            font-weight: 600;
            border: none;
            cursor: pointer;
        }

        .btn-success-custom:hover {
            background: #218838;
            transform: translateY(-2px);
            color: white;
        }

        .btn-primary-custom {
            background: #3b82f6;
            color: white;
            padding: 10px 30px;
            border-radius: 30px;
            text-decoration: none;
            display: inline-block;
            margin: 5px;
            transition: all 0.3s;
            font-weight: 600;
            border: none;
            cursor: pointer;
        }

        .btn-primary-custom:hover {
            background: #2563eb;
            transform: translateY(-2px);
            color: white;
        }

        .cod-payment-info {
            background: #fef3c7;
            padding: 12px 16px;
            border-radius: 10px;
            color: #92400e;
            font-size: 13px;
            margin-top: 10px;
        }

        .cod-payment-info i {
            margin-right: 8px;
        }

        .mobile-summary-card {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 15px;
        }

        .mobile-summary-row {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            font-size: 14px;
        }

        .order-number {
            color: #1e293b;
            font-weight: 600;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .success-body {
                padding: 18px 16px;
            }

            .success-header {
                padding: 20px 15px;
            }

            .success-header h3 {
                font-size: 1.3rem;
            }

            .items-table {
                font-size: 12px;
            }

            .items-table th,
            .items-table td {
                padding: 6px 8px;
            }

            .order-details-table td {
                font-size: 13px;
                padding: 6px 0;
            }

            .email-info-box {
                font-size: 13px;
                padding: 10px 14px;
                flex-wrap: wrap;
            }

            .btn-success-custom,
            .btn-primary-custom {
                width: 100%;
                text-align: center;
                padding: 12px;
            }

            .grand-total-amount {
                font-size: 17px;
            }

            .section-title {
                font-size: 14px;
            }

            .shipping-address-box {
                font-size: 12px;
            }
        }

        @media (max-width: 576px) {
            .success-container {
                padding: 0 10px;
                margin: 20px auto;
            }

            .success-header i {
                font-size: 2.8rem;
            }

            .success-header h3 {
                font-size: 1.1rem;
            }

            .items-table {
                font-size: 11px;
            }

            .items-table th,
            .items-table td {
                padding: 5px 6px;
            }

            .order-details-table td {
                font-size: 12px;
                padding: 5px 0;
            }

            .success-body {
                padding: 14px 12px;
            }

            .email-info-box {
                font-size: 12px;
                padding: 8px 12px;
            }

            .grand-total-amount {
                font-size: 16px;
            }

            .mobile-summary-row {
                font-size: 13px;
            }

            .btn-success-custom,
            .btn-primary-custom {
                padding: 10px;
                font-size: 14px;
            }
        }
    </style>

    <div class="container success-container">
        <div class="card success-card">
            <div class="success-header">
                <i class="fas fa-check-circle"></i>
                <h3>🎉 Order Placed Successfully!</h3>
                <p class="sub-text">Thank you for your purchase! Your order is confirmed.</p>
                <div class="email-sent-badge">
                    <i class="fas fa-envelope"></i> Order confirmation sent to your email
                </div>
            </div>

            <div class="success-body">
                <!-- Email Confirmation Notice -->
                <div class="email-info-box">
                    <i class="fas fa-envelope"></i>
                    <span>
                        <strong>📧 Order confirmation email sent!</strong><br>
                        We've sent the order details to
                        <strong>{{ Auth::user()->email ?? ($order->user->email ?? 'your registered email') }}</strong>
                    </span>
                </div>

                <!-- Order Details -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="section-title">
                            <i class="fas fa-receipt"></i> Order Details
                        </div>
                        <table class="order-details-table">
                            <tr>
                                <td>Order Number</td>
                                <td><strong class="order-number">#{{ $order->order_number }}</strong></td>
                            </tr>
                            <tr>
                                <td>Order Date</td>
                                <td>{{ \Carbon\Carbon::parse($order->order_date ?? $order->created_at)->setTimezone('Asia/Kolkata')->format('d M Y, g:i A') }}
                                </td>
                            </tr>
                            <tr>
                                <td>Payment Status</td>
                                <td><span class="badge bg-success">✅ Paid</span></td>
                            </tr>
                            <tr>
                                <td>Payment Method</td>
                                <td>
                                    @if ($order->payment_method == 'COD')
                                        <span class="payment-method-badge payment-cod">
                                            <i class="fas fa-money-bill-wave"></i> Cash on Delivery
                                        </span>
                                    @else
                                        <span class="payment-method-badge payment-online">
                                            <i class="fas fa-credit-card"></i> {{ $order->payment_method ?? 'Online' }}
                                        </span>
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
                        <div class="section-title">
                            <i class="fas fa-user"></i> Customer Details
                        </div>
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

                        <!-- ============================================================ -->
                        <!-- SHIPPING ADDRESS - FIXED WITH CORRECT PHP SYNTAX              -->
                        <!-- ============================================================ -->
                        @php
                            $shippingAddress = null;
                            
                            // METHOD 1: Try from payment_details (works for COD)
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
                            
                            // METHOD 2: Get from user_addresses table using user_id (FIX FOR ONLINE PAYMENTS)
                            if (!$shippingAddress && $order->user_id) {
                                try {
                                    // Use fully qualified class name with backslash
                                    $userAddress = \App\Models\UserAddress::where('user_id', $order->user_id)
                                        ->where('is_default', 1)
                                        ->first();
                                    
                                    if ($userAddress) {
                                        $shippingAddress = [
                                            'name' => $userAddress->name ?? 'N/A',
                                            'address' => $userAddress->address ?? '',
                                            'city' => $userAddress->city ?? '',
                                            'state' => $userAddress->state ?? '',
                                            'pincode' => $userAddress->pincode ?? '',
                                            'phone' => $userAddress->phone ?? 'N/A'
                                        ];
                                    } else {
                                        // If no default address, get any address
                                        $userAddress = \App\Models\UserAddress::where('user_id', $order->user_id)->first();
                                        if ($userAddress) {
                                            $shippingAddress = [
                                                'name' => $userAddress->name ?? 'N/A',
                                                'address' => $userAddress->address ?? '',
                                                'city' => $userAddress->city ?? '',
                                                'state' => $userAddress->state ?? '',
                                                'pincode' => $userAddress->pincode ?? '',
                                                'phone' => $userAddress->phone ?? 'N/A'
                                            ];
                                        }
                                    }
                                } catch (\Exception $e) {
                                    // If UserAddress model doesn't exist, try direct DB query
                                    try {
                                        $addressData = DB::table('user_addresses')
                                            ->where('user_id', $order->user_id)
                                            ->where('is_default', 1)
                                            ->first();
                                        
                                        if ($addressData) {
                                            $shippingAddress = [
                                                'name' => $addressData->name ?? 'N/A',
                                                'address' => $addressData->address ?? '',
                                                'city' => $addressData->city ?? '',
                                                'state' => $addressData->state ?? '',
                                                'pincode' => $addressData->pincode ?? '',
                                                'phone' => $addressData->phone ?? 'N/A'
                                            ];
                                        } else {
                                            // Get any address
                                            $addressData = DB::table('user_addresses')
                                                ->where('user_id', $order->user_id)
                                                ->first();
                                            if ($addressData) {
                                                $shippingAddress = [
                                                    'name' => $addressData->name ?? 'N/A',
                                                    'address' => $addressData->address ?? '',
                                                    'city' => $addressData->city ?? '',
                                                    'state' => $addressData->state ?? '',
                                                    'pincode' => $addressData->pincode ?? '',
                                                    'phone' => $addressData->phone ?? 'N/A'
                                                ];
                                            }
                                        }
                                    } catch (\Exception $e2) {
                                        // Silent fail
                                    }
                                }
                            }
                            
                            // METHOD 3: Try from session (for online payments)
                            if (!$shippingAddress) {
                                $sessionAddress = session('shipping_address');
                                if ($sessionAddress) {
                                    $shippingAddress = $sessionAddress;
                                }
                            }
                            
                            // METHOD 4: Try from order_data session (for online payments)
                            if (!$shippingAddress) {
                                $orderData = session('order_data');
                                if ($orderData && isset($orderData['address'])) {
                                    $shippingAddress = $orderData['address'];
                                }
                            }
                            
                            // METHOD 5: Try from user's default address (fallback)
                            if (!$shippingAddress && Auth::check()) {
                                $user = Auth::user();
                                $shippingAddress = [
                                    'name' => $user->name ?? 'N/A',
                                    'address' => $user->address ?? $user->address_line1 ?? 'N/A',
                                    'city' => $user->city ?? '',
                                    'state' => $user->state ?? '',
                                    'pincode' => $user->pincode ?? '',
                                    'phone' => $user->phone ?? 'N/A'
                                ];
                            }
                        @endphp

                        @if ($shippingAddress && ($shippingAddress['address'] ?? '') != '' && ($shippingAddress['address'] ?? '') != 'N/A')
                            <div class="section-title" style="margin-top: 15px; font-size: 14px;">
                                <i class="fas fa-truck"></i> Shipping Address
                            </div>
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
                        @else
                            <!-- Fallback: Show user's address from database -->
                            @php
                                $fallbackAddress = null;
                                if (Auth::check()) {
                                    try {
                                        $fallbackAddress = \App\Models\UserAddress::where('user_id', Auth::id())
                                            ->where('is_default', 1)
                                            ->first();
                                        if (!$fallbackAddress) {
                                            $fallbackAddress = \App\Models\UserAddress::where('user_id', Auth::id())->first();
                                        }
                                    } catch (\Exception $e) {
                                        try {
                                            $fallbackAddress = DB::table('user_addresses')
                                                ->where('user_id', Auth::id())
                                                ->where('is_default', 1)
                                                ->first();
                                            if (!$fallbackAddress) {
                                                $fallbackAddress = DB::table('user_addresses')
                                                    ->where('user_id', Auth::id())
                                                    ->first();
                                            }
                                        } catch (\Exception $e2) {}
                                    }
                                }
                            @endphp
                            
                            @if ($fallbackAddress)
                                <div class="section-title" style="margin-top: 15px; font-size: 14px;">
                                    <i class="fas fa-truck"></i> Shipping Address
                                </div>
                                <div class="shipping-address-box">
                                    <p><span class="address-label">Name:</span> {{ $fallbackAddress->name ?? 'N/A' }}</p>
                                    <p><span class="address-label">Address:</span> {{ $fallbackAddress->address ?? '' }}</p>
                                    <p><span class="address-label">City:</span> {{ $fallbackAddress->city ?? '' }}, {{ $fallbackAddress->state ?? '' }} - {{ $fallbackAddress->pincode ?? '' }}</p>
                                    <p><span class="address-label">Phone:</span> {{ $fallbackAddress->phone ?? 'N/A' }}</p>
                                </div>
                            @else
                                <div class="section-title" style="margin-top: 15px; font-size: 14px;">
                                    <i class="fas fa-truck"></i> Shipping Address
                                </div>
                                <div class="shipping-address-box">
                                    <p style="color: #dc3545;">⚠️ No shipping address found for this order</p>
                                </div>
                            @endif
                        @endif
                        <!-- ============================================================ -->
                        <!-- END OF SHIPPING ADDRESS - FIXED CODE                          -->
                        <!-- ============================================================ -->
                    </div>
                </div>

                <!-- Order Items -->
                <div class="section-title" style="margin-top: 20px;">
                    <i class="fas fa-box"></i> Order Items
                </div>
                <div class="table-responsive">
                    <table class="items-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Qty</th>
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
                                    $itemPrice = $item->final_price ?? ($item->price ?? 0);
                                    $itemTotal = $itemPrice * $item->quantity;
                                    $subtotal += $itemTotal;

                                    $hasDiscount = isset($item->final_price) && $item->final_price < $item->price;
                                    $discountPercent = $hasDiscount
                                        ? round((($item->price - $item->final_price) / $item->price) * 100)
                                        : 0;
                                @endphp
                                <tr>
                                    <td>
                                        {{ $item->product_name }}
                                        @if (isset($item->size) && $item->size)
                                            <br><small style="color: #64748b; font-size: 11px;">
                                                📏 Size: {{ $item->size }}
                                            </small>
                                        @endif
                                        @if (isset($item->color) && $item->color)
                                            <br><small style="color: #64748b; font-size: 11px;">
                                                🎨 Color: {{ $item->color }}
                                            </small>
                                        @endif
                                    </td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>
                                        <div class="price-wrapper">
                                            @if ($hasDiscount)
                                                <span class="original-price">₹{{ number_format($item->price, 2) }}</span>
                                                <span class="final-price">₹{{ number_format($itemPrice, 2) }}</span>
                                                <span class="discount-tag">-{{ $discountPercent }}%</span>
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
                            <tr class="subtotal-row">
                                <td colspan="3" style="text-align: right;"><strong>Subtotal</strong></td>
                                <td><strong>₹{{ number_format($subtotal, 2) }}</strong></td>
                            </tr>

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

                            <tr class="grand-total-row">
                                <td colspan="3" style="text-align: right;">
                                    <strong class="grand-total-label"><i class="fas fa-rupee-sign"></i> Grand Total</strong>
                                </td>
                                <td>
                                    <strong
                                        class="grand-total-amount">₹{{ number_format($order->total_amount, 2) }}</strong>
                                </td>
                            </tr>

                            @if ($order->payment_method == 'COD')
                                <tr>
                                    <td colspan="4" style="padding: 12px;">
                                        <div class="cod-payment-info">
                                            <i class="fas fa-money-bill-wave"></i>
                                            <strong>Cash on Delivery</strong> - Pay
                                            ₹{{ number_format($order->total_amount, 2) }} when your order arrives
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tfoot>
                    </table>
                </div>

                <!-- Mobile Order Summary -->
                <div class="d-md-none mt-3">
                    <div class="mobile-summary-card">
                        <h6 style="font-weight: 700; margin-bottom: 10px; color: #1e293b;">📋 Order Summary</h6>
                        <div class="mobile-summary-row">
                            <span style="color: #64748b;">Subtotal</span>
                            <span>₹{{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="mobile-summary-row">
                            <span style="color: #64748b;">Shipping</span>
                            @if ($shippingCharge > 0)
                                <span>₹{{ number_format($shippingCharge, 2) }}</span>
                            @else
                                <span style="color: #15803d;">Free</span>
                            @endif
                        </div>
                        @if ($couponDiscount > 0)
                            <div class="mobile-summary-row" style="color: #15803d;">
                                <span>Coupon Discount</span>
                                <span>- ₹{{ number_format($couponDiscount, 2) }}</span>
                            </div>
                        @endif
                        <hr style="margin: 8px 0;">
                        <div class="mobile-summary-row" style="font-size: 16px; font-weight: 700;">
                            <span>Total</span>
                            <span style="color: #28a745;">₹{{ number_format($order->total_amount, 2) }}</span>
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

             
            </div>
        </div>
    </div>

    <script>
        // Clear cart from localStorage when order success page loads
        if (typeof localStorage !== 'undefined') {
            localStorage.removeItem('cart');
            localStorage.removeItem('checkout_cart');
        }

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

        // Update wishlist count
        let wishlistCountElement = document.getElementById('navbarWishlistCount');
        if (wishlistCountElement) {
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

        localStorage.setItem('last_order_successful', Date.now());

        console.log('✅ Order placed successfully!');
        console.log('📧 Order confirmation email sent!');
    </script>
@endsection