@extends('layouts.member-layout')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-box me-2"></i> Our Packages</h4>
                    </div>
                    <div class="card-body p-3">

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show">
                                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="row">
                            @forelse($packages as $package)
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="card h-100 shadow-sm border-0">
                                        <div class="card-header bg-primary text-white text-center">
                                            <h6 class="mb-0 fw-bold">{{ $package->package_name }}</h6>
                                        </div>
                                        <div class="card-body p-3">
                                            @if ($package->image)
                                                <div class="text-center mb-3">
                                                    <img src="{{ asset('storage/' . $package->image) }}"
                                                        class="img-fluid rounded"
                                                        style="height:140px;width:100%;object-fit:cover;">
                                                </div>
                                            @endif
                                            <!-- Price -->
                                            <div class="text-center mb-3">
                                                <h4 class="text-success fw-bold mb-1">
                                                    ₹ {{ number_format($package->price, 2) }}
                                                    </h2>
                                                    <small class="text-muted">
                                                        / {{ $package->duration }} {{ $package->duration_type }}
                                                    </small>
                                            </div>

                                            <!-- Description -->
                                            @if ($package->description)
                                                <p class="text-muted text-center small">
                                                    {{ $package->description }}
                                                </p>
                                            @endif

                                            <!-- Included Features -->
                                            @php
                                                $features = $package->getFeaturesArrayAttribute();
                                            @endphp

                                            @if (count($features) > 0)
                                                <h6 class="mt-3"><i class="fas fa-check-circle text-success me-1"></i>
                                                    Features:</h6>
                                                <ul class="list-unstyled">
                                                    @foreach ($features as $feature)
                                                        <li class="py-1">
                                                            <i class="fas fa-check text-success me-2"></i>
                                                            {{ $feature }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif

                                            <!-- Status Badge -->
                                            <div class="text-center mt-3">
                                                @if ($package->status == 'Active')
                                                    <span class="badge bg-success">Available</span>
                                                @else
                                                    <span class="badge bg-danger">Not Available</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="card-footer bg-white border-0 pb-3">
                                            @if ($package->status == 'Active')
                                                <form action="{{ route('member.buy.package') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="package_id" value="{{ $package->id }}">
                                                
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
                                        <h5 class="text-muted">No Packages Available</h5>
                                        <p>Please check back later for new packages.</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-end mt-3">
                            {{ $packages->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
