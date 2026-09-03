@extends('layouts.member-layout')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <div class="row">
        <div class="col-12">
            <div class="plans-card-main">
                <div class="plans-card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-crown me-2"></i> Choose Your Plan
                    </h4>
                    <small style="color: rgba(255,255,255,0.7); font-size: 0.85rem;">
                        Select the best plan that suits your fitness goals
                    </small>
                </div>
                
                <div class="plans-card-body">
                    
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

                    <!-- Member Status -->
                    @php
                        $member = App\Models\Member::where('email', session('gym_user_email'))->first();
                        $hasActivePlan = ($member && $member->status == 'Active' && !$member->isExpired());
                    @endphp

                    @if($hasActivePlan)
                        <div class="alert alert-info" style="background: #dbeafe; border-left: 4px solid #3b82f6; border-radius: 10px; padding: 12px 18px; margin-bottom: 20px;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <i class="fas fa-info-circle" style="font-size: 20px; color: #3b82f6;"></i>
                                <div>
                                    <strong style="color: #1d4ed8;">You have an active plan!</strong><br>
                                    <span style="color: #1d4ed8; font-size: 0.85rem;">
                                        Current plan: <strong>{{ $member->membership_plan }}</strong> | 
                                        Expires: <strong>{{ \Carbon\Carbon::parse($member->expiry_date)->format('d M Y') }}</strong> |
                                        @php
                                            $daysLeft = floor(now()->diffInDays($member->expiry_date));
                                        @endphp
                                        <strong>{{ $daysLeft }} days left</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                    @elseif($member && $member->status == 'Inactive')
                        <div class="alert alert-warning" style="background: #fef3c7; border-left: 4px solid #f59e0b; border-radius: 10px; padding: 12px 18px; margin-bottom: 20px;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <i class="fas fa-exclamation-triangle" style="font-size: 20px; color: #f59e0b;"></i>
                                <div>
                                    <strong style="color: #92400e;">Your plan has expired!</strong><br>
                                    <span style="color: #92400e; font-size: 0.85rem;">
                                        Please purchase a new plan to continue your membership.
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Tabs -->
                    <ul class="nav nav-tabs custom-tabs" id="planTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="membership-tab" data-bs-toggle="tab" data-bs-target="#membership" type="button" role="tab">
                                <i class="fas fa-id-card me-1"></i> Membership Plans
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="packages-tab" data-bs-toggle="tab" data-bs-target="#packages" type="button" role="tab">
                                <i class="fas fa-box me-1"></i> Packages
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="planTabsContent">
                        <!-- Membership Tab -->
                        <div class="tab-pane fade show active" id="membership" role="tabpanel">
                            <div class="row g-4 mt-3">
                                @forelse($memberships as $membership)
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                        <div class="plan-card">
                                            <!-- Image Section -->
                                            <div class="plan-image">
                                                @if($membership->image)
                                                    <img src="{{ asset('storage/'.$membership->image) }}" 
                                                         alt="{{ $membership->plan_name }}"
                                                         style="object-fit: cover;">
                                                @else
                                                    <img src="{{ asset('images/no-image.png') }}" 
                                                         alt="No Image"
                                                         style="object-fit: cover;">
                                                @endif
                                                
                                                <span class="badge-status {{ $membership->status == 'Active' ? 'active' : 'inactive' }}">
                                                    {{ $membership->status == 'Active' ? 'Available' : 'Not Available' }}
                                                </span>
                                            </div>

                                            <!-- Content Section -->
                                            <div class="plan-content">
                                                <h5 class="plan-title">{{ $membership->plan_name }}</h5>
                                                
                                                <p class="plan-duration">
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{ $membership->duration }} {{ ucfirst($membership->duration_type) }}
                                                </p>

                                                <!-- Price Section -->
                                                <div class="plan-price">
                                                    @if($membership->original_price && $membership->original_price > $membership->price)
                                                        <span class="old-price">₹ {{ number_format($membership->original_price, 2) }}</span>
                                                        <span class="discount-badge-inline">
                                                            {{ round((($membership->original_price - $membership->price) / $membership->original_price) * 100) }}% OFF
                                                        </span>
                                                    @endif
                                                    <div class="price-row">
                                                        <span class="new-price">₹ {{ number_format($membership->price, 2) }}</span>
                                                        <span class="price-duration">/ {{ $membership->duration }} {{ $membership->duration_type }}</span>
                                                    </div>
                                                </div>

                                                @if($membership->description)
                                                    <p class="plan-description">{{ Str::limit($membership->description, 80) }}</p>
                                                @endif

                                                <!-- Features -->
                                                @php
                                                    $features = [];
                                                    if(method_exists($membership, 'getFeaturesArrayAttribute')) {
                                                        $features = $membership->getFeaturesArrayAttribute();
                                                    }
                                                @endphp

                                                @if(count($features) > 0)
                                                    <div class="plan-features">
                                                        <h6 class="features-title">
                                                            <i class="fas fa-check-circle me-1"></i> Features:
                                                        </h6>
                                                        <ul class="features-list" id="features-mem-{{ $membership->id }}">
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
                                                                    onclick="toggleFeatures('mem-{{ $membership->id }}')"
                                                                    id="toggle-btn-mem-{{ $membership->id }}">
                                                                <i class="fas fa-plus-circle me-1"></i>
                                                                Show +{{ count($features) - 3 }} more
                                                            </button>
                                                        @endif
                                                    </div>
                                                @endif

                                                <!-- Buy Button -->
                                                @if($membership->status == 'Active')
                                                    @if($hasActivePlan)
                                                        <button class="buy-btn buy-btn-disabled" disabled>
                                                            <i class="fas fa-clock me-1"></i> Active Plan
                                                        </button>
                                                    @else
                                                        <button class="buy-btn" onclick="initiatePayment('membership', {{ $membership->id }}, {{ $membership->price }}, '{{ addslashes($membership->plan_name) }}')">
                                                            <i class="fas fa-shopping-cart me-1"></i> Buy Now
                                                        </button>
                                                    @endif
                                                @else
                                                    <button class="buy-btn buy-btn-disabled" disabled>
                                                        <i class="fas fa-times-circle me-1"></i> Not Available
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <div class="empty-state">
                                            <i class="fas fa-box-open fa-4x"></i>
                                            <h5>No Membership Plans Available</h5>
                                            <p>Please check back later for new plans.</p>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                            @if($memberships->hasPages())
                                <div class="pagination-wrapper">
                                    {{ $memberships->links() }}
                                </div>
                            @endif
                        </div>

                        <!-- Packages Tab -->
                        <div class="tab-pane fade" id="packages" role="tabpanel">
                            <div class="row g-4 mt-3">
                                @forelse($packages as $package)
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                        <div class="plan-card">
                                            <!-- Image Section -->
                                            <div class="plan-image">
                                                @if($package->image)
                                                    <img src="{{ asset('storage/'.$package->image) }}" 
                                                         alt="{{ $package->package_name }}"
                                                         style="object-fit: cover;">
                                                @else
                                                    <img src="{{ asset('images/no-image.png') }}" 
                                                         alt="No Image"
                                                         style="object-fit: cover;">
                                                @endif
                                                
                                                <span class="badge-status {{ $package->status == 'Active' ? 'active' : 'inactive' }}">
                                                    {{ $package->status == 'Active' ? 'Available' : 'Not Available' }}
                                                </span>
                                            </div>

                                            <!-- Content Section -->
                                            <div class="plan-content">
                                                <h5 class="plan-title">{{ $package->package_name }}</h5>
                                                
                                                <p class="plan-duration">
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{ $package->duration }} {{ ucfirst($package->duration_type) }}
                                                </p>

                                                <!-- Price Section -->
                                                <div class="plan-price">
                                                    @if($package->original_price && $package->original_price > $package->price)
                                                        <span class="old-price">₹ {{ number_format($package->original_price, 2) }}</span>
                                                        <span class="discount-badge-inline">
                                                            {{ round((($package->original_price - $package->price) / $package->original_price) * 100) }}% OFF
                                                        </span>
                                                    @endif
                                                    <div class="price-row">
                                                        <span class="new-price">₹ {{ number_format($package->price, 2) }}</span>
                                                        <span class="price-duration">/ {{ $package->duration }} {{ $package->duration_type }}</span>
                                                    </div>
                                                </div>

                                                @if($package->description)
                                                    <p class="plan-description">{{ Str::limit($package->description, 80) }}</p>
                                                @endif

                                                <!-- Features -->
                                                @php
                                                    $features = [];
                                                    if(method_exists($package, 'getFeaturesArrayAttribute')) {
                                                        $features = $package->getFeaturesArrayAttribute();
                                                    }
                                                @endphp

                                                @if(count($features) > 0)
                                                    <div class="plan-features">
                                                        <h6 class="features-title">
                                                            <i class="fas fa-check-circle me-1"></i> Features:
                                                        </h6>
                                                        <ul class="features-list" id="features-pkg-{{ $package->id }}">
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
                                                                    onclick="toggleFeatures('pkg-{{ $package->id }}')"
                                                                    id="toggle-btn-pkg-{{ $package->id }}">
                                                                <i class="fas fa-plus-circle me-1"></i>
                                                                Show +{{ count($features) - 3 }} more
                                                            </button>
                                                        @endif
                                                    </div>
                                                @endif

                                                <!-- Buy Button -->
                                                @if($package->status == 'Active')
                                                    @if($hasActivePlan)
                                                        <button class="buy-btn buy-btn-disabled" disabled>
                                                            <i class="fas fa-clock me-1"></i> Active Plan
                                                        </button>
                                                    @else
                                                        <button class="buy-btn" onclick="initiatePayment('package', {{ $package->id }}, {{ $package->price }}, '{{ addslashes($package->package_name) }}')">
                                                            <i class="fas fa-shopping-cart me-1"></i> Buy Now
                                                        </button>
                                                    @endif
                                                @else
                                                    <button class="buy-btn buy-btn-disabled" disabled>
                                                        <i class="fas fa-times-circle me-1"></i> Not Available
                                                    </button>
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
    </div>
</div>

<!-- Razorpay Script -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<style>
/* ============================================ */
/* MAIN CARD - Matching Navbar Theme            */
/* ============================================ */
.plans-card-main {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(13, 27, 62, 0.08);
    overflow: hidden;
    border: 1px solid rgba(13, 27, 62, 0.06);
}

.plans-card-header {
    background: linear-gradient(135deg, #0d1b3e 0%, #1a2a6c 100%);
    color: #ffffff;
    padding: 18px 24px;
    border-bottom: none;
}

.plans-card-header h4 {
    font-weight: 600;
    font-size: 1.2rem;
}

.plans-card-header h4 i {
    color: #ffd54f;
}

.plans-card-body {
    padding: 24px;
}

/* ============================================ */
/* CUSTOM TABS                                  */
/* ============================================ */
.custom-tabs {
    border-bottom: 2px solid rgba(13, 27, 62, 0.08);
    margin-bottom: 0;
}

.custom-tabs .nav-link {
    color: #64748b;
    border: none;
    padding: 10px 20px;
    font-weight: 600;
    font-size: 0.9rem;
    border-radius: 8px 8px 0 0;
    transition: all 0.3s ease;
    background: transparent;
}

.custom-tabs .nav-link:hover {
    color: #0d1b3e;
    background: rgba(13, 27, 62, 0.05);
}

.custom-tabs .nav-link.active {
    color: #0d1b3e;
    background: transparent;
    border-bottom: 3px solid #0d1b3e;
}

.custom-tabs .nav-link i {
    color: #1a2a6c;
}

.custom-tabs .nav-link.active i {
    color: #0d1b3e;
}

/* ============================================ */
/* PLAN CARD - Professional Design              */
/* ============================================ */
.plan-card {
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

.plan-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(13, 27, 62, 0.12);
}

/* ============================================ */
/* PLAN IMAGE                                   */
/* ============================================ */
.plan-image {
    position: relative;
    height: 180px;
    background: linear-gradient(135deg, #f0f4ff 0%, #e8edf5 100%);
    overflow: hidden;
}

.plan-image img {
    width: 100%;
    height: 100%;
    object-fit: cover !important;
    transition: transform 0.4s ease;
}

.plan-card:hover .plan-image img {
    transform: scale(1.08);
}

.badge-status {
    position: absolute;
    top: 12px;
    right: 12px;
    padding: 5px 14px;
    border-radius: 20px;
    font-size: 0.75rem;
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
/* PLAN CONTENT                                 */
/* ============================================ */
.plan-content {
    padding: 16px 18px 18px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.plan-title {
    color: #0d1b3e;
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 4px;
}

.plan-duration {
    color: #64748b;
    font-size: 0.85rem;
    margin-bottom: 10px;
}

.plan-duration i {
    color: #1a2a6c;
}

/* ============================================ */
/* PLAN PRICE                                   */
/* ============================================ */
.plan-price {
    padding: 10px 12px;
    background: #f8fafc;
    border-radius: 8px;
    border: 1px solid rgba(13, 27, 62, 0.06);
    margin-bottom: 10px;
}

.old-price {
    color: #94a3b8;
    font-size: 0.8rem;
    text-decoration: line-through;
    margin-right: 6px;
}

.discount-badge-inline {
    display: inline-block;
    padding: 1px 10px;
    border-radius: 20px;
    font-size: 0.65rem;
    font-weight: 700;
    color: #ffffff;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    box-shadow: 0 2px 8px rgba(245, 158, 11, 0.25);
    margin-left: 4px;
    vertical-align: middle;
}

.price-row {
    margin-top: 4px;
    display: flex;
    align-items: baseline;
    flex-wrap: wrap;
    gap: 4px;
}

.new-price {
    color: #0d1b3e;
    font-size: 1.3rem;
    font-weight: 700;
}

.price-duration {
    color: #94a3b8;
    font-size: 0.75rem;
    font-weight: 400;
}

.plan-description {
    color: #64748b;
    font-size: 0.85rem;
    line-height: 1.5;
    margin-bottom: 10px;
}

/* ============================================ */
/* PLAN FEATURES                                */
/* ============================================ */
.plan-features {
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
}

.features-list li i {
    color: #10b981;
    font-size: 0.7rem;
    width: 16px;
}

.features-list .hidden-feature {
    display: none;
    animation: fadeIn 0.3s ease;
}

.features-list .hidden-feature.show {
    display: flex;
}

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
}

.btn-show-more i {
    font-size: 0.85rem;
}

/* ============================================ */
/* BUY BUTTON                                   */
/* ============================================ */
.buy-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    width: 100%;
    padding: 8px 14px;
    border: none;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 600;
    color: #ffffff;
    background: linear-gradient(135deg, #0d1b3e 0%, #1a2a6c 100%);
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: auto;
}

.buy-btn:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(13, 27, 62, 0.3);
}

.buy-btn:active:not(:disabled) {
    transform: translateY(0);
}

.buy-btn-disabled {
    background: #e2e8f0;
    color: #94a3b8;
    cursor: not-allowed;
}

.buy-btn-disabled:hover {
    transform: none;
    box-shadow: none;
}

/* ============================================ */
/* ALERTS                                       */
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
    padding: 40px 20px;
    background: #f8fafc;
    border-radius: 12px;
    border: 2px dashed rgba(13, 27, 62, 0.08);
}

.empty-state i {
    color: #94a3b8;
    margin-bottom: 10px;
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
    margin-top: 16px;
    padding-top: 12px;
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
    padding: 4px 12px;
    font-size: 0.8rem;
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

/* ============================================ */
/* RESPONSIVE                                   */
/* ============================================ */
@media (max-width: 992px) {
    .plan-image {
        height: 160px;
    }
}

@media (max-width: 768px) {
    .plans-card-header {
        padding: 14px 18px;
    }
    
    .plans-card-header h4 {
        font-size: 1rem;
    }
    
    .plans-card-body {
        padding: 16px;
    }
    
    .plan-image {
        height: 150px;
    }
    
    .plan-content {
        padding: 14px 14px 16px;
    }
    
    .plan-title {
        font-size: 1rem;
    }
    
    .new-price {
        font-size: 1.15rem;
    }
    
    .pagination-wrapper {
        justify-content: center;
    }
    
    .buy-btn {
        font-size: 0.8rem;
        padding: 6px 12px;
    }
    
    .custom-tabs .nav-link {
        font-size: 0.8rem;
        padding: 8px 14px;
    }
    
    .features-list li {
        font-size: 0.78rem;
    }
}

@media (max-width: 480px) {
    .plan-image {
        height: 130px;
    }
    
    .plan-price {
        padding: 8px 10px;
    }
    
    .new-price {
        font-size: 1rem;
    }
    
    .old-price {
        font-size: 0.7rem;
    }
    
    .plan-description {
        font-size: 0.75rem;
    }
    
    .price-duration {
        font-size: 0.65rem;
    }
    
    .buy-btn {
        font-size: 0.75rem;
        padding: 5px 10px;
    }
    
    .custom-tabs .nav-link {
        font-size: 0.7rem;
        padding: 6px 10px;
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
// TOGGLE FEATURES - Show/Hide                  //
// ============================================ //
function toggleFeatures(planId) {
    const hiddenFeatures = document.querySelectorAll(`#features-${planId} .hidden-feature`);
    const toggleBtn = document.getElementById(`toggle-btn-${planId}`);
    
    if (!hiddenFeatures.length || !toggleBtn) return;
    
    const isHidden = hiddenFeatures[0]?.classList.contains('show') === false;
    
    if (isHidden) {
        hiddenFeatures.forEach(feature => {
            feature.classList.add('show');
        });
        toggleBtn.innerHTML = '<i class="fas fa-minus-circle me-1"></i> Show less';
    } else {
        hiddenFeatures.forEach(feature => {
            feature.classList.remove('show');
        });
        const count = hiddenFeatures.length;
        toggleBtn.innerHTML = `<i class="fas fa-plus-circle me-1"></i> Show +${count} more`;
    }
}

// ============================================ //
// INITIATE PAYMENT                             //
// ============================================ //
function initiatePayment(planType, planId, amount, planName) {
    // Check if member has active plan
    @php
        $member = App\Models\Member::where('email', session('gym_user_email'))->first();
        $hasActivePlan = ($member && $member->status == 'Active' && !$member->isExpired());
    @endphp
    
    @if($hasActivePlan)
        alert('You already have an active plan. Please wait until it expires to purchase a new plan.');
        return;
    @endif

    // Show loading state
    const btn = event.target.closest('.buy-btn');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Processing...';
    btn.disabled = true;

    // Create order
    fetch('{{ route('member.buy.plan') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            plan_type: planType,
            plan_id: planId,
            amount: amount
        })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            alert(data.message || 'Failed to initiate payment. Please try again.');
            btn.innerHTML = originalText;
            btn.disabled = false;
            return;
        }

        // Open Razorpay Checkout
        const options = {
            key: data.key_id,
            amount: data.amount * 100,
            currency: 'INR',
            name: 'Gym Management',
            description: 'Purchase ' + data.plan_name + ' Plan',
            order_id: data.order_id,
            prefill: {
                name: data.member_name,
                email: data.member_email,
                contact: data.member_phone
            },
            theme: {
                color: '#0d1b3e'
            },
            handler: function(response) {
                // Payment successful
                fetch('{{ route('member.payment.success') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        razorpay_payment_id: response.razorpay_payment_id,
                        razorpay_order_id: response.razorpay_order_id,
                        razorpay_signature: response.razorpay_signature
                    })
                })
                .then(res => res.json())
                .then(data => {
                    console.log('Payment Success Response:', data);
                    
                    if (data.success) {
                        // ✅ Success - Redirect
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        } else {
                            window.location.href = '{{ route('member.plans') }}';
                        }
                    } else {
                        // ❌ Show the actual error message
                        alert(data.message || 'Payment successful but failed to update plan. Please contact support.');
                        window.location.reload();
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                    alert('Something went wrong. Please contact support.');
                    window.location.reload();
                });
            },
            modal: {
                ondismiss: function() {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }
            }
        };

        const razorpay = new Razorpay(options);
        razorpay.open();
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to initiate payment. Please try again.');
        btn.innerHTML = originalText;
        btn.disabled = false;
    });
}
</script>
@endsection