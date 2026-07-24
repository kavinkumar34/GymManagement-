@extends('layouts.member-layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="fas fa-check-circle me-2"></i> Payment Successful!</h4>
                </div>
                <div class="card-body text-center">
                    <i class="fas fa-check-circle text-success" style="font-size: 80px;"></i>
                    <h3 class="mt-3">Thank You!</h3>
                    <p>Your membership has been activated successfully.</p>

                    <div class="card bg-light mt-4">
                        <div class="card-body text-left">
                            <h5>Order Details</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Order ID</th>
                                    <td>{{ $order->transaction_id }}</td>
                                </tr>
                                <tr>
                                    <th>Plan</th>
                                    <td>{{ $order->plan_name }}</td>
                                </tr>
                                <tr>
                                    <th>Duration</th>
                                    <td>{{ $order->duration }} {{ $order->duration_type }}</td>
                                </tr>
                                <tr>
                                    <th>Amount Paid</th>
                                    <td><strong>₹ {{ number_format($order->amount, 2) }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Payment Status</th>
                                    <td><span class="badge bg-success">SUCCESS</span></td>
                                </tr>
                                <tr>
                                    <th>Payment ID</th>
                                    <td>{{ $order->payment_id }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('member.dashboard') }}" class="btn btn-primary">
                            <i class="fas fa-home me-2"></i> Go to Dashboard
                        </a>
                        <a href="{{ route('member.membership') }}" class="btn btn-outline-primary">
                            <i class="fas fa-id-card me-2"></i> View Memberships
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsectionw