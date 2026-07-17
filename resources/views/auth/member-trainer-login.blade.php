@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top:70px;margin-bottom:30px;">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h4 class="mb-0"><i class="fas fa-user-check me-2"></i>Only Registered Member / Trainer Login</h4>
                    </div>
                    <div class="card-body p-4">
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('member.trainer.login.submit') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" name="email" id="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" placeholder="Enter your email" required autofocus>
                                </div>
                                @error('email')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-bold">Phone Number <small
                                        class="text-muted">(Registered Mobile Number)</small></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="tel" name="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Enter your registered phone number" required>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Enter the phone number you registered with.</small>
                            </div>

                            <div class="mb-4">
                                <label for="role" class="form-label fw-bold">Login As</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                    <select name="role" id="role"
                                        class="form-select @error('role') is-invalid @enderror" required>
                                        <option value="">-- Select Role --</option>
                                        <option value="member" {{ old('role') == 'member' ? 'selected' : '' }}>👤 Member
                                        </option>
                                        <option value="trainer" {{ old('role') == 'trainer' ? 'selected' : '' }}>🏋️ Trainer
                                        </option>
                                    </select>
                                </div>
                                @error('role')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                                <i class="fas fa-sign-in-alt me-2"></i> Login
                            </button>
                        </form>

                        <div class="mt-4 text-center">
                       
                            <p class="mb-0">
                                <a href="{{ route('home') }}" class="text-decoration-none text-muted">
                                    <i class="fas fa-arrow-left me-1"></i> Back to Home
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
