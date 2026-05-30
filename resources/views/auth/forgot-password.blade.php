@extends('layouts.app')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header bg-dark text-white text-center">
                <h4><i class="fas fa-key"></i> Reset Password</h4>
            </div>
            <div class="card-body">
                <p class="text-muted">Enter your email address and we'll send you a password reset link.</p>
                
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-paper-plane"></i> Send Reset Link
                    </button>
                    
                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}">Back to Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection