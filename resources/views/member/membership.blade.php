@extends('layouts.member-layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-id-card me-2"></i> Membership Plans</h4>
                </div>
                <div class="card-body">
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="row">
                        @forelse($memberships as $membership)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 shadow-sm border-0">
                                    <!-- Image -->
                                    <div class="card-img-top text-center p-3" style="height: 200px; background: #f8f9fa;">
                                        @if($membership->image)
                                            <img src="{{ asset('storage/'.$membership->image) }}" 
                                                 alt="{{ $membership->plan_name }}"
                                                 style="height: 100%; object-fit: contain;">
                                        @else
                                            <img src="{{ asset('images/no-image.png') }}" 
                                                 alt="No Image"
                                                 style="height: 100%; object-fit: contain;">
                                        @endif
                                    </div>

                                    <div class="card-body">
                                        <!-- Plan Name -->
                                        <h5 class="card-title text-primary fw-bold">
                                            {{ $membership->plan_name }}
                                        </h5>

                                        <!-- Duration -->
                                        <p class="card-text">
                                            <i class="fas fa-clock text-muted me-1"></i>
                                            <strong>{{ $membership->duration }} {{ $membership->duration_type }}</strong>
                                        </p>

                                        <!-- Price with Discount -->
                                        <div class="mb-2">
                                            @if($membership->discount > 0)
                                                <span class="text-decoration-line-through text-muted me-2">
                                                    ₹ {{ number_format($membership->price, 2) }}
                                                </span>
                                                <span class="badge bg-success">
                                                    {{ $membership->discount_type == 'Flat' ? '₹' : '' }}
                                                    {{ $membership->discount }}
                                                    {{ $membership->discount_type == 'Percentage' ? '%' : '' }}
                                                    OFF
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Final Price -->
                                        <h4 class="text-success fw-bold">
                                            ₹ {{ number_format($membership->final_price, 2) }}
                                            <small class="text-muted fw-normal" style="font-size: 14px;">
                                                / {{ $membership->duration }} {{ $membership->duration_type }}
                                            </small>
                                        </h4>

                                        <!-- Description -->
                                        @if($membership->description)
                                            <p class="card-text text-muted small mt-2">
                                                {{ $membership->description }}
                                            </p>
                                        @endif

                                        <!-- Status Badge -->
                                        <div class="mt-2">
                                            @if($membership->status == 'Active')
                                                <span class="badge bg-success">Available</span>
                                            @else
                                                <span class="badge bg-danger">Not Available</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="card-footer bg-white border-0 pb-3">
                                        @if($membership->status == 'Active')
                                            <form action="{{ route('member.buy.membership') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="membership_id" value="{{ $membership->id }}">
                                                <button type="submit" class="btn btn-primary w-100">
                                                    <i class="fas fa-shopping-cart me-2"></i>
                                                    Buy Now - ₹ {{ number_format($membership->final_price, 2) }}
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn btn-secondary w-100" disabled>
                                                <i class="fas fa-times me-2"></i>
                                                Currently Unavailable
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                                    <h5 class="text-muted">No Membership Plans Available</h5>
                                    <p>Please check back later for new plans.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-end mt-3">
                        {{ $memberships->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection