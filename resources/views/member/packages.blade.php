@extends('layouts.member-layout')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <div class="row">
        <div class="col-12">
            <div class="package-card-main">
                <!-- Card Header - Matching Navbar Theme -->
                <div class="package-card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-box me-2"></i> Our Packages
                    </h4>
                </div>
                
                <div class="package-card-body">
                    
                    @if(session('success'))
                        <div class="alert alert-custom-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-custom-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="row g-4">
                        @forelse($packages as $package)
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                <div class="package-card">
                                    <!-- Image Section - Full Cover -->
                                    <div class="package-image">
                                        @if($package->image)
                                            <img src="{{ asset('storage/'.$package->image) }}" 
                                                 alt="{{ $package->package_name }}"
                                                 style="object-fit: cover;">
                                        @else
                                            <img src="{{ asset('images/no-image.png') }}" 
                                                 alt="No Image"
                                                 style="object-fit: cover;">
                                        @endif
                                        
                                   
                                    </div>

                                    <!-- Content Section -->
                                    <div class="package-content">
                                        <h5 class="package-title">{{ $package->package_name }}</h5>
                                        
                                        <p class="package-duration">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ $package->duration }} {{ ucfirst($package->duration_type) }}
                                        </p>

                                        <!-- Price Section -->
                                        <div class="package-price">
                                            <div class="price-row">
                                                <span class="new-price">₹ {{ number_format($package->price, 2) }}</span>
                                                <span class="price-duration">/ {{ $package->duration }} {{ $package->duration_type }}</span>
                                            </div>
                                        </div>

                                        @if($package->description)
                                            <p class="package-description">{{ Str::limit($package->description, 80) }}</p>
                                        @endif

                                        <!-- Features - Show All -->
                                        @php
                                            $features = $package->getFeaturesArrayAttribute();
                                        @endphp

                                        @if(count($features) > 0)
                                            <div class="package-features">
                                                <h6 class="features-title">
                                                    <i class="fas fa-check-circle me-1"></i> Features:
                                                </h6>
                                                <ul class="features-list" id="features-{{ $package->id }}">
                                                    @foreach($features as $index => $feature)
                                                        <li class="feature-item {{ $index >= 3 ? 'hidden-feature' : '' }}" 
                                                            data-index="{{ $index }}">
                                                            <i class="fas fa-check"></i>
                                                            {{ $feature }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                @if(count($features) > 3)
                                                    <button class="btn-show-more" 
                                                            onclick="toggleFeatures({{ $package->id }})"
                                                            id="toggle-btn-{{ $package->id }}">
                                                        <i class="fas fa-plus-circle me-1"></i>
                                                        Show +{{ count($features) - 3 }} more
                                                    </button>
                                                @endif
                                            </div>
                                        @endif

                                        <!-- Availability Badge Below Description -->
                                        @if($package->status == 'Active')
                                            <div class="availability-badge">
                                                <i class="fas fa-check-circle me-1"></i> Available
                                            </div>
                                        @else
                                            <div class="availability-badge inactive">
                                                <i class="fas fa-times-circle me-1"></i> Not Available
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="empty-state">
                                    <i class="fas fa-box-open fa-4x"></i>
                                    <h5>No Packages Available</h5>
                                    <p>Please check back later for new packages.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($packages->hasPages())
                        <div class="pagination-wrapper">
                            {{ $packages->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ============================================ */
/* MAIN CARD - Matching Navbar Theme            */
/* ============================================ */
.package-card-main {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(13, 27, 62, 0.08);
    overflow: hidden;
    border: 1px solid rgba(13, 27, 62, 0.06);
}

.package-card-header {
    background: linear-gradient(135deg, #0d1b3e 0%, #1a2a6c 100%);
    color: #ffffff;
    padding: 18px 24px;
    border-bottom: none;
}

.package-card-header h4 {
    font-weight: 600;
    font-size: 1.2rem;
}

.package-card-header h4 i {
    color: #ffd54f;
}

.package-card-body {
    padding: 24px;
}

/* ============================================ */
/* PACKAGE CARD - Professional Design           */
/* ============================================ */
.package-card {
    background: #ffffff;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(13, 27, 62, 0.06);
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    border: 1px solid rgba(13, 27, 62, 0.06);
}

.package-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(13, 27, 62, 0.12);
}

/* ============================================ */
/* PACKAGE IMAGE - FULL COVER                   */
/* ============================================ */
.package-image {
    position: relative;
    height: 200px;
    background: linear-gradient(135deg, #f0f4ff 0%, #e8edf5 100%);
    overflow: hidden;
}

.package-image img {
    width: 100%;
    height: 100%;
    object-fit: cover !important;
    transition: transform 0.4s ease;
}

.package-card:hover .package-image img {
    transform: scale(1.08);
}

/* Status Badge */
.badge-status {
    position: absolute;
    top: 12px;
    right: 12px;
    padding: 5px 14px;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
    color: #ffffff;
    letter-spacing: 0.3px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
    backdrop-filter: blur(4px);
}

.badge-status.active {
    background: linear-gradient(135deg, #10b981, #059669);
}

.badge-status.inactive {
    background: linear-gradient(135deg, #ef4444, #dc2626);
}

/* ============================================ */
/* PACKAGE CONTENT                              */
/* ============================================ */
.package-content {
    padding: 18px 20px 20px;
    flex: 1;
}

.package-title {
    color: #0d1b3e;
    font-weight: 700;
    font-size: 1.15rem;
    margin-bottom: 4px;
    letter-spacing: -0.3px;
}

.package-duration {
    color: #64748b;
    font-size: 0.85rem;
    margin-bottom: 12px;
}

.package-duration i {
    color: #1a2a6c;
}

/* ============================================ */
/* PACKAGE PRICE                                */
/* ============================================ */
.package-price {
    padding: 12px 14px;
    background: #f8fafc;
    border-radius: 10px;
    border: 1px solid rgba(13, 27, 62, 0.06);
    margin-bottom: 12px;
}

.price-row {
    display: flex;
    align-items: baseline;
    flex-wrap: wrap;
    gap: 4px;
}

.new-price {
    color: #0d1b3e;
    font-size: 1.5rem;
    font-weight: 700;
}

.price-duration {
    color: #94a3b8;
    font-size: 0.8rem;
    font-weight: 400;
}

/* ============================================ */
/* PACKAGE DESCRIPTION                          */
/* ============================================ */
.package-description {
    color: #64748b;
    font-size: 0.85rem;
    line-height: 1.6;
    margin-bottom: 12px;
}

/* ============================================ */
/* PACKAGE FEATURES - All Features              */
/* ============================================ */
.package-features {
    margin-bottom: 12px;
}

.features-title {
    color: #0d1b3e;
    font-size: 0.85rem;
    font-weight: 600;
    margin-bottom: 6px;
}

.features-title i {
    color: #10b981;
}

.features-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.features-list li {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 4px 0;
    color: #334155;
    font-size: 0.82rem;
    transition: all 0.3s ease;
}

.features-list li i {
    color: #10b981;
    font-size: 0.7rem;
    width: 16px;
}

/* Hidden features */
.features-list .hidden-feature {
    display: none;
    animation: fadeIn 0.3s ease;
}

.features-list .hidden-feature.show {
    display: flex;
}

/* Show More Button */
.btn-show-more {
    background: transparent;
    border: none;
    color: #1a2a6c;
    font-weight: 600;
    font-size: 0.8rem;
    padding: 5px 0;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.btn-show-more:hover {
    color: #0d1b3e;
    transform: scale(1.02);
}

.btn-show-more i {
    font-size: 0.85rem;
}

/* ============================================ */
/* AVAILABILITY BADGE - Below Description       */
/* ============================================ */
.availability-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 16px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    background: #ecfdf5;
    color: #065f46;
    border: 1px solid #a7f3d0;
}

.availability-badge i {
    color: #10b981;
    font-size: 0.85rem;
}

.availability-badge.inactive {
    background: #fef2f2;
    color: #991b1b;
    border: 1px solid #fca5a5;
}

.availability-badge.inactive i {
    color: #ef4444;
}

/* ============================================ */
/* ALERTS - Custom Colors                       */
/* ============================================ */
.alert-custom-success {
    background: #ecfdf5;
    color: #065f46;
    border-left: 4px solid #10b981;
    border-radius: 10px;
    padding: 12px 18px;
}

.alert-custom-danger {
    background: #fef2f2;
    color: #991b1b;
    border-left: 4px solid #ef4444;
    border-radius: 10px;
    padding: 12px 18px;
}

/* ============================================ */
/* EMPTY STATE                                  */
/* ============================================ */
.empty-state {
    text-align: center;
    padding: 50px 20px;
    background: #f8fafc;
    border-radius: 12px;
    border: 2px dashed rgba(13, 27, 62, 0.08);
}

.empty-state i {
    color: #94a3b8;
    margin-bottom: 12px;
}

.empty-state h5 {
    color: #0d1b3e;
    font-weight: 600;
}

.empty-state p {
    color: #94a3b8;
    margin-bottom: 0;
}

/* ============================================ */
/* PAGINATION                                   */
/* ============================================ */
.pagination-wrapper {
    display: flex;
    justify-content: flex-end;
    margin-top: 20px;
    padding-top: 16px;
    border-top: 1px solid rgba(13, 27, 62, 0.06);
}

.pagination-wrapper .pagination {
    gap: 4px;
    margin-bottom: 0;
}

.pagination-wrapper .page-item .page-link {
    color: #0d1b3e;
    border: 1px solid rgba(13, 27, 62, 0.08);
    border-radius: 6px;
    padding: 6px 14px;
    font-size: 0.85rem;
    transition: all 0.3s ease;
}

.pagination-wrapper .page-item.active .page-link {
    background: linear-gradient(135deg, #0d1b3e 0%, #1a2a6c 100%);
    border-color: #0d1b3e;
    color: #ffffff;
}

.pagination-wrapper .page-item .page-link:hover {
    background: rgba(13, 27, 62, 0.05);
    border-color: #0d1b3e;
}

/* ============================================ */
/* ANIMATIONS                                   */
/* ============================================ */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-5px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.package-card {
    animation: fadeInUp 0.5s ease forwards;
}

.package-card:nth-child(1) { animation-delay: 0.05s; }
.package-card:nth-child(2) { animation-delay: 0.1s; }
.package-card:nth-child(3) { animation-delay: 0.15s; }
.package-card:nth-child(4) { animation-delay: 0.2s; }
.package-card:nth-child(5) { animation-delay: 0.25s; }
.package-card:nth-child(6) { animation-delay: 0.3s; }

/* ============================================ */
/* RESPONSIVE                                   */
/* ============================================ */
@media (max-width: 1200px) {
    .package-image {
        height: 180px;
    }
    
    .new-price {
        font-size: 1.3rem;
    }
}

@media (max-width: 992px) {
    .package-image {
        height: 170px;
    }
    
    .new-price {
        font-size: 1.2rem;
    }
}

@media (max-width: 768px) {
    .package-card-header {
        padding: 14px 18px;
    }
    
    .package-card-header h4 {
        font-size: 1rem;
    }
    
    .package-card-body {
        padding: 16px;
    }
    
    .package-image {
        height: 160px;
    }
    
    .package-content {
        padding: 14px 16px 16px;
    }
    
    .package-title {
        font-size: 1rem;
    }
    
    .new-price {
        font-size: 1.2rem;
    }
    
    .badge-status {
        font-size: 0.65rem;
        padding: 4px 10px;
    }
    
    .pagination-wrapper {
        justify-content: center;
    }
    
    .pagination-wrapper .page-item .page-link {
        padding: 4px 10px;
        font-size: 0.8rem;
    }
    
    .features-list li {
        font-size: 0.78rem;
    }
}

@media (max-width: 480px) {
    .package-image {
        height: 140px;
    }
    
    .package-price {
        padding: 10px 12px;
    }
    
    .new-price {
        font-size: 1.1rem;
    }
    
    .package-description {
        font-size: 0.8rem;
    }
    
    .availability-badge {
        font-size: 0.7rem;
        padding: 4px 12px;
    }
    
    .price-duration {
        font-size: 0.7rem;
    }
    
    .features-title {
        font-size: 0.8rem;
    }
    
    .btn-show-more {
        font-size: 0.7rem;
    }
}
</style>

<script>
// ============================================ //
// TOGGLE FEATURES - Show/Hide All Features    //
// ============================================ //
function toggleFeatures(packageId) {
    const hiddenFeatures = document.querySelectorAll(`#features-${packageId} .hidden-feature`);
    const toggleBtn = document.getElementById(`toggle-btn-${packageId}`);
    
    // Check if features are currently hidden
    const isHidden = hiddenFeatures[0]?.classList.contains('show') === false;
    
    if (isHidden) {
        // Show all features
        hiddenFeatures.forEach(feature => {
            feature.classList.add('show');
        });
        toggleBtn.innerHTML = '<i class="fas fa-minus-circle me-1"></i> Show less';
    } else {
        // Hide extra features
        hiddenFeatures.forEach(feature => {
            feature.classList.remove('show');
        });
        const count = hiddenFeatures.length;
        toggleBtn.innerHTML = `<i class="fas fa-plus-circle me-1"></i> Show +${count} more`;
    }
}
</script>
@endsection