@extends('layouts.admin-layout')

@section('content')
<style>
    .payment-header {
        background: linear-gradient(135deg, #0d1b2a 0%, #1b3a5c 50%, #0d1b2a 100%);
        color: white;
        padding: 18px 24px;
        border: none;
    }
    
    .payment-header h4 {
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0;
    }
    
    .payment-header h4 i {
        margin-right: 10px;
    }
    
    .badge-success {
        background: #dcfce7;
        color: #15803d;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .badge-pending {
        background: #fef3c7;
        color: #92400e;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .badge-failed {
        background: #fee2e2;
        color: #b91c1c;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .table th {
        white-space: nowrap;
        font-size: 0.8rem;
    }
    
    .table td {
        vertical-align: middle;
        font-size: 0.9rem;
    }
    
    .payment-amount {
        font-weight: 700;
        color: #10b981;
    }
</style>

<div class="admin-main-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header payment-header d-flex justify-content-between align-items-center">
                <h4><i class="fas fa-credit-card"></i> Payment Orders</h4>
                <span style="color: rgba(255,255,255,0.7); font-size: 0.9rem;">
                    <i class="fas fa-calendar-alt me-1"></i> {{ now()->format('d M Y, h:i A') }}
                </span>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>User ID</th>
                                <th>Member ID</th>
                                <th>Plan Name</th>
                                <th>Duration</th>
                                <th>Amount</th>
                                <th>Transaction ID</th>
                                <th>Payer</th>
                                <th>Payment Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->user_id }}</td>
                                <td><strong>{{ $order->member_id ?? 'N/A' }}</strong></td>
                                <td>
                                    <span class="badge" style="background: #dbeafe; color: #1d4ed8; padding: 5px 12px; border-radius: 20px; font-size: 0.75rem;">
                                        {{ $order->plan_name }}
                                    </span>
                                </td>
                                <td>{{ $order->duration }} {{ ucfirst($order->duration_type) }}</td>
                                <td><strong class="payment-amount">₹{{ number_format($order->amount, 2) }}</strong></td>
                                <td>
                                    <span style="font-size: 0.75rem; color: #64748b;">
                                        {{ $order->transaction_id ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <div style="font-size: 0.85rem;">
                                        <div><strong>{{ $order->payer_name ?? 'N/A' }}</strong></div>
                                        <div style="font-size: 0.7rem; color: #64748b;">{{ $order->payer_email ?? 'N/A' }}</div>
                                    </div>
                                </td>
                                <td>
                                    @if($order->payment_status == 'SUCCESS')
                                        <span class="badge-success"><i class="fas fa-check-circle me-1"></i> Success</span>
                                    @elseif($order->payment_status == 'PENDING')
                                        <span class="badge-pending"><i class="fas fa-clock me-1"></i> Pending</span>
                                    @else
                                        <span class="badge-failed"><i class="fas fa-times-circle me-1"></i> Failed</span>
                                    @endif
                                </td>
                                <td style="font-size: 0.8rem; color: #64748b;">
                                    {{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y h:i A') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted py-4">
                                    <i class="fas fa-credit-card fa-2x d-block mb-2" style="color: #d1d5db;"></i>
                                    No payment orders found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection