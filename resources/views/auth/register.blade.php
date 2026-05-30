@extends('layouts.app')

@section('content')
<style>
    /* Hide navbar completely */
    nav.navbar, .navbar {
        display: none !important;
    }
    body {
        padding-top: 0 !important;
        margin-top: 0 !important;
    }
    main.py-4 {
        padding-top: 2rem !important;
    }
</style>

<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-dark text-white text-center">
                <h4><i class="fas fa-user-plus"></i> Admin Registration</h4>
                <small>Create Admin Account</small>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                        <small class="text-muted">Minimum 6 characters</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Captcha</label>
                        <div class="row">
                            <div class="col-7">
                                <input type="text" name="captcha" class="form-control" required>
                            </div>
                            <div class="col-5">
                                <img src="{{ url('/captcha') }}" id="captcha-img" onclick="refreshCaptcha()" style="cursor: pointer; height: 42px; border-radius: 5px;">
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">Register Admin</button>
                    
                    <div class="text-center mt-3">
                        <a href="{{ route('admin.login') }}">Already have account? Admin Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
function refreshCaptcha() {
    document.getElementById('captcha-img').src = '/captcha?' + Math.random();
}
</script>