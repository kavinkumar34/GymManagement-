@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2><i class="fas fa-shopping-bag"></i> My Orders</h2>
    <p class="text-muted">View all your orders</p>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Total Amount</th>
                    <th>Payment Status</th>
                    <th>Order Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>{{ $order->order_number }}</div>
                    <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</div>
                    <td>₹{{ number_format($order->total_amount, 2) }}</div>
                    <td>
                        @if($order->payment_status == 'SUCCESS')
                            <span class="badge bg-success">Paid</span>
                        @else
                            <span class="badge bg-danger">Failed</span>
                        @endif
                    </div>
                    <td>
                        <span class="badge bg-primary">{{ $order->order_status }}</span>
                    </div>
                    <td>
                        <a href="{{ route('order.details', $order->id) }}" class="btn btn-sm btn-info">View</a>
                    </div>
                 </div>
                @empty
                 </div>
                    <td colspan="6" class="text-center">No orders found</div>
                 </div>
                @endforelse
            </tbody>
        </div>
    </div>
    
    {{ $orders->links() }}
</div>
@endsection