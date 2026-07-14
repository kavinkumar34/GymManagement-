<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 650px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            background: linear-gradient(135deg, #dc3545, #b02a37);
            padding: 30px 20px;
            text-align: center;
            color: white;
        }

        .email-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }

        .email-header p {
            margin: 8px 0 0;
            opacity: 0.9;
            font-size: 14px;
        }

        .email-body {
            padding: 25px 30px;
        }

        .email-body h2 {
            font-size: 20px;
            color: #1e293b;
            margin-top: 0;
        }

        .order-info {
            background: #f8fafc;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
        }

        .order-info table {
            width: 100%;
            font-size: 14px;
        }

        .order-info td {
            padding: 5px 0;
        }

        .order-info td:first-child {
            font-weight: 600;
            color: #475569;
            width: 40%;
        }

        .order-info td:last-child {
            color: #1e293b;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 14px;
        }

        .items-table th {
            background: #f1f5f9;
            padding: 10px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #e2e8f0;
        }

        .items-table td {
            padding: 10px;
            border-bottom: 1px solid #e2e8f0;
        }

        .items-table .total-row td {
            background: #f8fafc;
            font-weight: 700;
            border-top: 2px solid #e2e8f0;
        }

        .items-table .shipping-row td {
            background: #f8fafc;
            border-top: none;
        }

        .items-table .discount-row td {
            background: #f0fdf4;
            color: #15803d;
            border-top: none;
        }

        .items-table .grand-total-row td {
            background: #dc3545;
            color: white;
            border-top: 2px solid #dc3545;
            font-size: 16px;
        }

        .shipping-box {
            background: #f8fafc;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            line-height: 1.8;
        }

        .status-badge {
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

        .status-cancelled {
            background: #fee2e2;
            color: #b91c1c;
        }

        .payment-badge {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .payment-success {
            background: #dcfce7;
            color: #15803d;
        }

        .payment-pending {
            background: #fef9c3;
            color: #854d0e;
        }

        .payment-failed {
            background: #fee2e2;
            color: #b91c1c;
        }

        .footer {
            text-align: center;
            padding: 20px;
            border-top: 1px solid #e2e8f0;
            font-size: 12px;
            color: #94a3b8;
        }

        .footer a {
            color: #dc3545;
            text-decoration: none;
        }

        .btn-order {
            display: inline-block;
            background: #dc3545;
            color: white;
            padding: 10px 25px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            margin-top: 10px;
        }

        .btn-order:hover {
            background: #b02a37;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .order-number {
            font-size: 18px;
            font-weight: 700;
            color: #dc3545;
        }

        .divider {
            border: none;
            border-top: 2px solid #e2e8f0;
            margin: 20px 0;
        }

        .whats-next {
            background: #f8fafc;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .whats-next h3 {
            font-size: 16px;
            color: #1e293b;
            margin-bottom: 5px;
        }

        .whats-next p {
            color: #475569;
            margin: 5px 0;
            font-size: 14px;
        }

        .fw-bold {
            font-weight: 700;
        }

        .text-muted {
            color: #64748b;
        }

        .text-success {
            color: #15803d;
        }

        .text-danger {
            color: #dc3545;
        }

        .shipping-charge-free {
            color: #15803d;
            font-weight: 600;
        }

        .shipping-charge-amount {
            color: #0f172a;
            font-weight: 700;
        }

        .variant-details {
            font-size: 12px;
            color: #64748b;
            margin-top: 2px;
        }

        @media (max-width: 480px) {
            .email-body {
                padding: 15px;
            }

            .items-table th,
            .items-table td {
                padding: 6px;
                font-size: 12px;
            }

            .items-table .grand-total-row td {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>🎉 Order Confirmed!</h1>
            <p>Thank you for your purchase</p>
        </div>

        <!-- Body -->
        <div class="email-body">
            <h2>Hello {{ $user->name ?? 'Customer' }},</h2>
            <p style="color: #475569; line-height: 1.6;">
                We're happy to confirm that your order has been placed successfully.
                Here are the details of your order:
            </p>

            <div style="text-align: center; margin: 15px 0;">
                <span style="background: #f1f5f9; padding: 8px 20px; border-radius: 30px; font-size: 14px;">
                    Order # <strong class="order-number">{{ $order->order_number }}</strong>
                </span>
                <span style="display: inline-block; margin-left: 10px;">
                    @php
                        $orderStatus = $order->order_status ?? 'Pending';
                        $statusClass = 'status-' . strtolower($orderStatus);
                    @endphp
                    <span class="status-badge {{ $statusClass }}">{{ $orderStatus }}</span>
                </span>
            </div>

            <!-- Order Details -->
            <div class="order-info">
                <table>
                    <tr>
                        <td>Order Date</td>
                        <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, h:i A') }}</td>
                    </tr>
                    <tr>
                        <td>Payment Method</td>
                        <td>{{ ucfirst($order->payment_method ?? 'Online') }}</td>
                    </tr>
                    <tr>
                        <td>Payment Status</td>
                        <td>
                            @php
                                $paymentStatus = $order->payment_status ?? 'PENDING';
                                $paymentClass = 'payment-' . strtolower($paymentStatus);
                                $paymentLabel = $paymentStatus;

                                // For COD orders, show as "Pending" not "Paid"
                                if ($order->payment_method == 'COD') {
                                    $paymentLabel = 'Pending (COD)';
                                    $paymentClass = 'payment-pending';
                                } elseif ($paymentStatus == 'SUCCESS') {
                                    $paymentLabel = '✅ Paid';
                                    $paymentClass = 'payment-success';
                                } elseif ($paymentStatus == 'FAILED') {
                                    $paymentLabel = '❌ Failed';
                                    $paymentClass = 'payment-failed';
                                } else {
                                    $paymentLabel = '⏳ Pending';
                                    $paymentClass = 'payment-pending';
                                }
                            @endphp
                            <span class="payment-badge {{ $paymentClass }}">{{ $paymentLabel }}</span>
                        </td>
                    </tr>
                    @if ($order->payment_method == 'COD')
                        <tr>
                            <td>Payment Type</td>
                            <td><span style="color: #92400e; font-weight: 600;">💵 Cash on Delivery</span></td>
                        </tr>
                        <tr>
                            <td>Amount to Pay</td>
                            <td><span
                                    style="color: #dc3545; font-weight: 700;">₹{{ number_format($order->total_amount, 2) }}</span>
                                (on delivery)</td>
                        </tr>
                    @endif
                </table>
            </div>

            <!-- Order Items -->
            <h3 style="font-size: 16px; color: #1e293b; margin-bottom: 10px;">🛍️ Order Items</h3>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th style="text-align: center;">Qty</th>
                        <th style="text-align: right;">Price</th>
                        <th style="text-align: right;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $subtotal = 0;
                        $shippingCharge = $order->shipping_charge ?? 0;
                        $couponDiscount = 0;
                        $couponCode = null;

                        // Get coupon details from payment_details
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

                    @foreach ($items as $item)
                        @php
                            $itemPrice = $item->final_price ?? ($item->price ?? 0);
                            $itemTotal = $itemPrice * $item->quantity;
                            $subtotal += $itemTotal;
                        @endphp
                        <tr>
                            <td>
                                {{ $item->product_name }}
                                @if (isset($item->size) && $item->size)
                                    <div class="variant-details">Size: {{ $item->size }}</div>
                                @endif
                                @if (isset($item->color) && $item->color)
                                    <div class="variant-details">Color: {{ $item->color }}</div>
                                @endif
                            </td>
                            <td style="text-align: center;">{{ $item->quantity }}</td>
                            <td style="text-align: right;">₹{{ number_format($itemPrice, 2) }}</td>
                            <td style="text-align: right;">₹{{ number_format($itemTotal, 2) }}</td>
                        </tr>
                    @endforeach

                    <!-- Subtotal -->
                    <tr class="total-row">
                        <td colspan="3" style="text-align: right;">Subtotal</td>
                        <td style="text-align: right;">₹{{ number_format($subtotal, 2) }}</td>
                    </tr>

                    <!-- Shipping Charge -->
                    <tr class="shipping-row">
                        <td colspan="3" style="text-align: right;">
                            <span>🚚 Shipping Charge</span>
                            @if ($shippingCharge > 0)
                                <span style="font-size: 12px; color: #64748b; font-weight: normal;">(Delivery
                                    Fee)</span>
                            @else
                                <span style="font-size: 12px; color: #15803d; font-weight: normal;">(Free
                                    Delivery)</span>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            @if ($shippingCharge > 0)
                                <span class="shipping-charge-amount">+ ₹{{ number_format($shippingCharge, 2) }}</span>
                            @else
                                <span class="shipping-charge-free">Free</span>
                            @endif
                        </td>
                    </tr>

                    <!-- Coupon Discount -->
                    @if ($couponDiscount > 0)
                        <tr class="discount-row">
                            <td colspan="3" style="text-align: right;">
                                <span>🎫 Coupon Discount</span>
                                @if ($couponCode)
                                    <span style="font-size: 12px; font-weight: normal;">({{ $couponCode }})</span>
                                @endif
                            </td>
                            <td style="text-align: right;">- ₹{{ number_format($couponDiscount, 2) }}</td>
                        </tr>
                    @endif

                    <!-- Grand Total -->
                    <tr class="grand-total-row">
                        <td colspan="3" style="text-align: right; font-size: 16px; color: white; font-weight: 700;">
                            Grand Total
                        </td>
                        <td style="text-align: right; font-size: 18px; color: white; font-weight: 800;">
                            ₹{{ number_format($order->total_amount, 2) }}
                        </td>
                    </tr>

                    <!-- COD Payment Info -->
                    @if ($order->payment_method == 'COD')
                        <tr>
                            <td colspan="4"
                                style="padding: 12px; background: #fef3c7; text-align: center; border-radius: 0 0 8px 8px;">
                                <small style="color: #92400e;">
                                    💵 <strong>Cash on Delivery</strong> - Pay
                                    ₹{{ number_format($order->total_amount, 2) }} when your order arrives
                                </small>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <!-- Shipping Address -->
            @if ($shippingAddress)
                <h3 style="font-size: 16px; color: #1e293b; margin-bottom: 10px; margin-top: 20px;">📦 Shipping Address
                </h3>
                <div class="shipping-box">
                    <strong>{{ $shippingAddress['name'] ?? 'N/A' }}</strong><br>
                    {{ $shippingAddress['address'] ?? '' }}<br>
                    @if (isset($shippingAddress['area']) && $shippingAddress['area'])
                        {{ $shippingAddress['area'] }}<br>
                    @endif
                    {{ $shippingAddress['city'] ?? '' }}, {{ $shippingAddress['state'] ?? '' }} -
                    {{ $shippingAddress['pincode'] ?? '' }}<br>
                    <strong>Phone:</strong> {{ $shippingAddress['phone'] ?? 'N/A' }}
                </div>
            @endif

            <hr class="divider">

            <!-- What's Next -->
            <div class="whats-next">
                <h3>📋 What's Next?</h3>
                <p>
                    @if ($order->payment_method == 'COD')
                        Your order will be processed and delivered to your address. Please keep the cash ready for
                        payment upon delivery.
                    @else
                        We'll send you a confirmation once your order is processed. You can track your order status in
                        your account.
                    @endif
                </p>
            </div>

            <!-- Buttons -->
            <div class="text-center">
                <a href="{{ route('my.orders') }}" class="btn-order">
                    📋 View My Orders
                </a>
                <a href="{{ url('/') }}"
                    style="display: inline-block; margin-top: 10px; color: #64748b; text-decoration: none; font-size: 14px; margin-left: 15px;">
                    🛒 Continue Shopping →
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>
                This is a system-generated email. Please do not reply to this email.<br>
                &copy; {{ date('Y') }} <a href="{{ url('/') }}">Gym Management</a>. All rights reserved.
            </p>
        </div>
    </div>
</body>

</html>
