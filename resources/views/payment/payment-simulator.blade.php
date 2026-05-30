@extends('layouts.app')

@section('content')
<style>
    .payment-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        overflow: hidden;
        max-width: 500px;
        margin: 0 auto;
    }
    .payment-header {
        background: linear-gradient(135deg, #000000 0%, #1a1a2e 100%);
        padding: 30px;
        text-align: center;
        color: white;
    }
    .payment-body {
        padding: 30px;
    }
    .order-details {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
    }
    .btn-simulate-success {
        background: #28a745;
        color: white;
        border: none;
        padding: 12px;
        border-radius: 10px;
        width: 100%;
        font-weight: bold;
        margin-bottom: 10px;
    }
    .btn-simulate-success:hover {
        background: #218838;
    }
    .btn-simulate-failure {
        background: #dc3545;
        color: white;
        border: none;
        padding: 12px;
        border-radius: 10px;
        width: 100%;
        font-weight: bold;
    }
    .btn-simulate-failure:hover {
        background: #c82333;
    }
    .amount {
        font-size: 28px;
        font-weight: bold;
        color: #dc3545;
    }
</style>

<div class="container mt-5 mb-5">
    <div class="payment-card">
        <div class="payment-header">
            <i class="fas fa-credit-card" style="font-size: 3rem;"></i>
            <h3 class="mt-3">Test Payment Simulation</h3>
            <p>This is for local testing only</p>
        </div>
        <div class="payment-body">
            <div class="order-details">
                <h5>Order Summary</h5>
                <div class="row">
                    <div class="col-6">Order Number:</div>
                    <div class="col-6 text-end"><strong>{{ $order->order_number }}</strong></div>
                    
                    <div class="col-6">Product:</div>
                    <div class="col-6 text-end"><strong>{{ $product->name }}</strong></div>
                    
                    <div class="col-6">Quantity:</div>
                    <div class="col-6 text-end"><strong>1</strong></div>
                    
                    <div class="col-6">Total Amount:</div>
                    <div class="col-6 text-end"><strong class="amount">₹{{ number_format($amount, 2) }}</strong></div>
                </div>
            </div>
            
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> This is a test payment simulation. No actual payment will be processed.
            </div>
            
            <a href="{{ route('payment.simulate.success', ['order_id' => $order->id]) }}" class="btn-simulate-success">
                <i class="fas fa-check-circle"></i> Simulate Successful Payment
            </a>
            
            <a href="{{ route('payment.simulate.failure', ['order_id' => $order->id]) }}" class="btn-simulate-failure">
                <i class="fas fa-times-circle"></i> Simulate Failed Payment
            </a>
            
            <div class="text-center mt-3">
                <a href="{{ url('/') }}" class="text-muted">Cancel and go back</a>
            </div>
        </div>
    </div>
</div>
@endsection