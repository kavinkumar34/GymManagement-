@extends('layouts.member-layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-credit-card me-2"></i> Payment Details</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Order Summary</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Plan</th>
                                    <td>{{ $membership->plan_name }}</td>
                                </tr>
                                <tr>
                                    <th>Duration</th>
                                    <td>{{ $membership->duration }} {{ $membership->duration_type }}</td>
                                </tr>
                                <tr>
                                    <th>Amount</th>
                                    <td><strong>₹ {{ number_format($amount, 2) }}</strong></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Payer Details</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $firstName }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $email }}</td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td>{{ $phone }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <h5>You will be redirected to PayU payment gateway</h5>
                        <p class="text-muted">Please do not close this window</p>
                        
      <form action="{{ $payuUrl }}" method="POST" id="payuForm">
    <input type="hidden" name="key" value="{{ $merchantKey }}">
    <input type="hidden" name="txnid" value="{{ $txnId }}">
    <input type="hidden" name="amount" value="{{ $amount }}">
    <input type="hidden" name="productinfo" value="{{ $productInfo }}">
    <input type="hidden" name="firstname" value="{{ $firstName }}">
    <input type="hidden" name="email" value="{{ $email }}">
    <input type="hidden" name="phone" value="{{ $phone }}">
    <input type="hidden" name="surl" value="{{ $surl }}">
    <input type="hidden" name="furl" value="{{ $furl }}">
    <input type="hidden" name="hash" value="{{ $hash }}">
    
    <!-- UDF Fields -->
    <input type="hidden" name="udf1" value="{{ $udf1 }}">
    <input type="hidden" name="udf2" value="{{ $udf2 }}">
    <input type="hidden" name="udf3" value="{{ $udf3 }}">
    <input type="hidden" name="udf4" value="{{ $udf4 }}">
    <input type="hidden" name="udf5" value="{{ $udf5 }}">
    
    <!-- ✅ Add service_provider -->
    <input type="hidden" name="service_provider" value="payu_paisa">
    
    <button type="submit" class="btn btn-success btn-lg">
        <i class="fas fa-credit-card me-2"></i> Pay Now - ₹ {{ number_format($amount, 2) }}
    </button>
</form>            </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Auto submit form on page load
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('payuForm').submit();
    });
</script>
@endsection