<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
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
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
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
        .shipping-box {
            background: #f8fafc;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            line-height: 1.8;
        }
        .shipping-box strong {
            color: #1e293b;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            background: #dbeafe;
            color: #1d4ed8;
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
        .order-number {
            font-size: 18px;
            font-weight: 700;
            color: #dc3545;
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
                    <span class="status-badge">{{ $order->order_status ?? 'Confirmed' }}</span>
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
                        <td><span style="color: #28a745; font-weight: 600;">Paid</span></td>
                    </tr>
                </table>
            </div>

            <!-- Order Items -->
            <h3 style="font-size: 16px; color: #1e293b; margin-bottom: 10px;">🛍️ Order Items</h3>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th style="text-align: right;">Price</th>
                        <th style="text-align: right;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php $subtotal = 0; @endphp
                    @foreach($items as $item)
                    @php $itemTotal = $item->price * $item->quantity; $subtotal += $itemTotal; @endphp
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td style="text-align: right;">₹{{ number_format($item->price, 2) }}</td>
                        <td style="text-align: right;">₹{{ number_format($itemTotal, 2) }}</td>
                    </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="3" style="text-align: right;">Subtotal</td>
                        <td style="text-align: right;">₹{{ number_format($subtotal, 2) }}</td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="3" style="text-align: right; border-top: none;">Shipping</td>
                        <td style="text-align: right; border-top: none;">₹0.00</td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="3" style="text-align: right; font-size: 16px;">Grand Total</td>
                        <td style="text-align: right; font-size: 16px; color: #dc3545;">
                            ₹{{ number_format($order->total_amount, 2) }}
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Shipping Address -->
            @if($shippingAddress)
            <h3 style="font-size: 16px; color: #1e293b; margin-bottom: 10px; margin-top: 20px;">📦 Shipping Address</h3>
            <div class="shipping-box">
                <strong>{{ $shippingAddress['name'] ?? 'N/A' }}</strong><br>
                {{ $shippingAddress['address'] ?? '' }}<br>
                @if(isset($shippingAddress['area']) && $shippingAddress['area'])
                    {{ $shippingAddress['area'] }}<br>
                @endif
                {{ $shippingAddress['city'] ?? '' }}, {{ $shippingAddress['state'] ?? '' }} - {{ $shippingAddress['pincode'] ?? '' }}<br>
                <strong>Phone:</strong> {{ $shippingAddress['phone'] ?? 'N/A' }}
            </div>
            @endif

            <!-- What's Next -->
            <div style="background: #f8fafc; padding: 15px; border-radius: 8px; margin: 20px 0;">
                <h3 style="font-size: 16px; color: #1e293b; margin-bottom: 5px;">📋 What's Next?</h3>
                <p style="color: #475569; margin: 5px 0; font-size: 14px;">
                    We'll send you a confirmation once your order is processed. You can track your order status in your account.
                </p>
            </div>

            <!-- Buttons -->
            <div class="text-center">
                <a href="{{ route('my.orders') }}" class="btn-order">
                    <i class="fas fa-list"></i> View My Orders
                </a>
                <a href="{{ url('/') }}" style="display: inline-block; margin-top: 10px; color: #64748b; text-decoration: none; font-size: 14px; margin-left: 15px;">
                    Continue Shopping →
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