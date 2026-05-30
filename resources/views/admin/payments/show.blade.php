@extends('layouts.admin-layout')

@section('content')
<div class="admin-main-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h4><i class="fas fa-receipt"></i> Order Details - #{{ $order->order_number }}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Order Information</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th width="35%">Order Number</th>
                                <td>{{ $order->order_number }}</div>
                            </tr>
                            <tr>
                                <th>Order Date</th>
                                <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y, h:i A') }}</div>
                            </tr>
                            <tr>
                                <th>Total Amount</th>
                                <td><strong>₹{{ number_format($order->total_amount, 2) }}</strong></div>
                            </tr>
                            <tr>
                                <th>Payment Method</th>
                                <td>{{ $order->payment_method ?? 'N/A' }}</div>
                            </tr>
                            <tr>
                                <th>Transaction ID</th>
                                <td>{{ $order->transaction_id ?? 'N/A' }}</div>
                            </tr>
                            <tr>
                                <th>Payment ID</th>
                                <td>{{ $order->payment_id ?? 'N/A' }}</div>
                            </tr>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <h5>Payment & Order Status</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th width="35%">Payment Status</th>
                                <td>
                                    @if($order->payment_status == 'SUCCESS')
                                        <span class="badge bg-success">Paid</span>
                                    @elseif($order->payment_status == 'FAILED')
                                        <span class="badge bg-danger">Failed</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </div>
                            </tr>
                            <tr>
                                <th>Order Status</th>
                                <td>
                                    @if($order->order_status == 'Confirmed')
                                        <span class="badge bg-primary">Confirmed</span>
                                    @elseif($order->order_status == 'Shipped')
                                        <span class="badge bg-info">Shipped</span>
                                    @elseif($order->order_status == 'Delivered')
                                        <span class="badge bg-success">Delivered</span>
                                    @elseif($order->order_status == 'Cancelled')
                                        <span class="badge bg-danger">Cancelled</span>
                                    @elseif($order->order_status == 'Failed')
                                        <span class="badge bg-danger">Failed</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $order->order_status }}</span>
                                    @endif
                                </div>
                            </tr>
                            <tr>
                                <th>Last Updated</th>
                                <td>{{ $order->updated_at->format('d M Y, h:i A') }}</div>
                            </tr>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <h5>Customer Information</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th width="20%">Name</th>
                            <td>{{ $order->user->name ?? 'N/A' }}</div>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $order->user->email ?? 'N/A' }}</div>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ $order->user->phone ?? 'N/A' }}</div>
                        </tr>
                    </div>
                </div>
                
                <div class="mt-4">
                    <h5>Order Items</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>{{ $item->product_name }}</div>
                                    <td>{{ $item->quantity }}</div>
                                    <td>₹{{ number_format($item->price, 2) }}</div>
                                    <td>₹{{ number_format($item->price * $item->quantity, 2) }}</div>
                                 </div>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-dark">
                                    <th colspan="3" class="text-end">Grand Total</th>
                                    <th>₹{{ number_format($order->total_amount, 2) }}</th>
                                 </tr>
                            </tfoot>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <a href="{{ route('admin.payments') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Orders
                    </a>
                    <a href="{{ route('admin.payments.edit', $order->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Status
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection