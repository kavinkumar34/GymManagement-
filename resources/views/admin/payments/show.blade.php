@extends('layouts.admin-layout')

@section('content')
<style>
    /* ============================================ */
    /* COLOR VARIABLES - MATCHING NAVBAR          */
    /* ============================================ */
    :root {
        --primary: #4a9eff;
        --primary-dark: #2b7be0;
        --primary-light: #8ab4f8;
        --success: #4caf50;
        --warning: #ffa726;
        --danger: #ef5350;
        --dark: #1a1a2e;
        --gray: #6c757d;
        --light-gray: #f8f9fa;
        --border-color: #e9ecef;
        --shadow: 0 2px 20px rgba(0,0,0,0.05);
        --radius: 10px;
        --radius-lg: 16px;
    }

    .admin-main-content {
        padding: 20px 25px;
        background: #f0f4f8;
        min-height: 100vh;
    }

    .show-card {
        background: #ffffff;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow);
        border: 1px solid rgba(0,0,0,0.04);
        overflow: hidden;
        max-width: 1100px;
        margin: 0 auto;
    }

    .show-card .card-header {
        padding: 16px 24px;
        background: linear-gradient(135deg, #0d1b2a 0%, #1b3a5c 100%);
        color: #ffffff;
        border-bottom: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .show-card .card-header h4 {
        margin: 0;
        font-weight: 600;
        font-size: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .show-card .card-header h4 i {
        color: #4a9eff;
    }

    .show-card .card-header small {
        font-size: 12px;
        opacity: 0.8;
        font-weight: 400;
    }

    .show-card .card-body {
        padding: 20px 24px;
    }

    .section-title {
        font-size: 14px;
        font-weight: 600;
        color: var(--dark);
        padding: 8px 14px;
        background: var(--light-gray);
        border-radius: var(--radius);
        border-left: 3px solid var(--primary);
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .section-title i {
        color: var(--primary);
        font-size: 14px;
    }

    .details-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .details-table tr {
        transition: all 0.3s;
    }

    .details-table tr:hover {
        background: #f8f9fa;
    }

    .details-table th {
        padding: 10px 16px;
        font-weight: 600;
        color: var(--dark);
        background: var(--light-gray);
        border: 1px solid var(--border-color);
        width: 35%;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .details-table td {
        padding: 10px 16px;
        color: var(--dark);
        border: 1px solid var(--border-color);
    }

    .details-table td .badge-custom {
        padding: 3px 12px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .details-table td .badge-custom.success {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .details-table td .badge-custom.danger {
        background: #fce4ec;
        color: #c62828;
    }

    .details-table td .badge-custom.warning {
        background: #fef3c7;
        color: #92400e;
    }

    .details-table td .badge-custom.primary {
        background: #e3f2fd;
        color: #1565c0;
    }

    .details-table td .badge-custom.info {
        background: #e0f7fa;
        color: #00838f;
    }

    .btn-secondary {
        background: #f0f4f8;
        color: var(--gray);
        border: 1px solid var(--border-color);
        padding: 9px 24px;
        border-radius: var(--radius);
        font-weight: 500;
        font-size: 13px;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-secondary:hover {
        background: #e9ecef;
        color: var(--dark);
    }

    .btn-warning {
        background: #ffa726;
        color: #fff;
        border: none;
        padding: 9px 24px;
        border-radius: var(--radius);
        font-weight: 500;
        font-size: 13px;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-warning:hover {
        background: #f57c00;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(255, 167, 38, 0.35);
    }

    .form-actions {
        padding-top: 16px;
        border-top: 1px solid var(--border-color);
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 20px;
    }

    @media (max-width: 768px) {
        .admin-main-content { padding: 12px 15px; }
        .show-card .card-header { padding: 12px 16px; flex-direction: column; align-items: flex-start; }
        .show-card .card-header h4 { font-size: 16px; }
        .show-card .card-body { padding: 14px 16px; }
        .details-table { font-size: 12px; }
        .details-table th, .details-table td { padding: 8px 12px; }
        .form-actions { flex-direction: column; }
        .form-actions .btn { width: 100%; justify-content: center; }
    }

    @media (max-width: 576px) {
        .show-card .card-header h4 { font-size: 14px; }
        .show-card .card-body { padding: 10px 12px; }
        .details-table { font-size: 11px; }
        .details-table th, .details-table td { padding: 6px 10px; font-size: 11px; }
        .details-table th { font-size: 10px; }
        .section-title { font-size: 12px; padding: 6px 12px; }
        .btn-warning, .btn-secondary { padding: 7px 16px; font-size: 12px; }
    }
</style>

<div class="admin-main-content">
    <div class="show-card">
        <div class="card-header">
            <div>
                <h4><i class="fas fa-receipt"></i> Order Details</h4>
                <small>Order #{{ $order->order_number }}</small>
            </div>
            <span style="background:rgba(74,158,255,0.2); color:#8ab4f8; padding:3px 12px; border-radius:50px; font-size:11px;">
                <i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($order->order_date ?? $order->created_at)->format('d M Y, h:i A') }}
            </span>
        </div>

        <div class="card-body">
            <div class="row">
                <!-- Order Information -->
                <div class="col-md-6">
                    <div class="section-title">
                        <i class="fas fa-info-circle"></i> Order Information
                    </div>
                    <table class="details-table">
                        <tr>
                            <th>Order Number</th>
                            <td><strong>#{{ $order->order_number }}</strong></td>
                        </tr>
                        <tr>
                            <th>Order Date</th>
                            <td>{{ \Carbon\Carbon::parse($order->order_date ?? $order->created_at)->format('d M Y, h:i A') }}</td>
                        </tr>
                        <tr>
                            <th>Total Amount</th>
                            <td><strong style="color:#10b981; font-size:16px;">₹{{ number_format($order->total_amount, 2) }}</strong></td>
                        </tr>
                        <tr>
                            <th>Payment Method</th>
                            <td>{{ $order->payment_method ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Transaction ID</th>
                            <td>{{ $order->transaction_id ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Payment ID</th>
                            <td>{{ $order->payment_id ?? 'N/A' }}</td>
                        </tr>
                    </table>
                </div>

                <!-- Payment & Order Status -->
                <div class="col-md-6">
                    <div class="section-title">
                        <i class="fas fa-credit-card"></i> Payment & Order Status
                    </div>
                    <table class="details-table">
                        <tr>
                            <th>Payment Status</th>
                            <td>
                                @if($order->payment_status == 'SUCCESS')
                                    <span class="badge-custom success"><span class="dot"></span> Paid</span>
                                @elseif($order->payment_status == 'FAILED')
                                    <span class="badge-custom danger"><span class="dot"></span> Failed</span>
                                @else
                                    <span class="badge-custom warning"><span class="dot"></span> Pending</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Order Status</th>
                            <td>
                                @if($order->order_status == 'Confirmed')
                                    <span class="badge-custom primary"><span class="dot"></span> Confirmed</span>
                                @elseif($order->order_status == 'Shipped')
                                    <span class="badge-custom info"><span class="dot"></span> Shipped</span>
                                @elseif($order->order_status == 'Delivered')
                                    <span class="badge-custom success"><span class="dot"></span> Delivered</span>
                                @elseif($order->order_status == 'Cancelled')
                                    <span class="badge-custom danger"><span class="dot"></span> Cancelled</span>
                                @elseif($order->order_status == 'Failed')
                                    <span class="badge-custom danger"><span class="dot"></span> Failed</span>
                                @else
                                    <span class="badge-custom warning"><span class="dot"></span> {{ $order->order_status }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Last Updated</th>
                            <td>{{ $order->updated_at->format('d M Y, h:i A') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="section-title mt-3">
                <i class="fas fa-user-circle"></i> Customer Information
            </div>
            <table class="details-table">
                <tr>
                    <th>Name</th>
                    <td>{{ $order->user->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $order->user->email ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>{{ $order->user->phone ?? 'N/A' }}</td>
                </tr>
            </table>

            <!-- Order Items -->
            <div class="section-title mt-3">
                <i class="fas fa-box"></i> Order Items
            </div>
            <div class="table-responsive">
                <table class="details-table">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Unit Price</th>
                            <th class="text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product_name }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-center">₹{{ number_format($item->price, 2) }}</td>
                            <td class="text-center"><strong>₹{{ number_format($item->price * $item->quantity, 2) }}</strong></td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr style="background:var(--light-gray);">
                            <th colspan="3" class="text-end">Grand Total</th>
                            <th class="text-center" style="color:#10b981; font-size:16px;">₹{{ number_format($order->total_amount, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('admin.payments') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Orders
                </a>
                <a href="{{ route('admin.payments.edit', $order->id) }}" class="btn-warning">
                    <i class="fas fa-edit"></i> Edit Status
                </a>
            </div>
        </div>
    </div>
</div>
@endsection