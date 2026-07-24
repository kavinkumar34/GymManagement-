@php
    $userId = session('gym_user_id');
    $userName = session('gym_user_name');
    $userEmail = session('gym_user_email');
@endphp

@extends('layouts.member-layout')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <div class="row">
        <div class="col-12">
            <div class="membership-card-main">
                <!-- Card Header - Matching Navbar Theme -->
                <div class="membership-card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-id-card me-2"></i> Membership Plans
                    </h4>
                </div>
                
                <div class="membership-card-body">
                    
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
                        @forelse($memberships as $membership)
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                <div class="plan-card">
                                    <!-- Image Section - Full Cover -->
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
                                        
                                     
                                    </div>

                                    <!-- Content Section -->
                                    <div class="plan-content">
                                        <h5 class="plan-title">{{ $membership->plan_name }}</h5>
                                        
                                        <p class="plan-duration">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ $membership->duration }} {{ ucfirst($membership->duration_type) }}
                                        </p>

                                        <!-- Price Section with Discount Badge Inside -->
                                        <div class="plan-price">
                                            @if($membership->discount > 0)
                                                <span class="old-price">₹ {{ number_format($membership->price, 2) }}</span>
                                                <!-- Discount Badge Inside Price -->
                                                <span class="discount-badge-inline">
                                                    <i class="fas fa-tag me-1"></i>
                                                    {{ $membership->discount_type == 'Flat' ? '₹' : '' }}
                                                    {{ $membership->discount }}
                                                    {{ $membership->discount_type == 'Percentage' ? '%' : '' }} OFF
                                                </span>
                                            @endif
                                            <div class="price-row">
                                                <span class="new-price">₹ {{ number_format($membership->final_price, 2) }}</span>
                                                <span class="price-duration">/ {{ $membership->duration }} {{ $membership->duration_type }}</span>
                                            </div>
                                        </div>

                                        @if($membership->description)
                                            <p class="plan-description">{{ Str::limit($membership->description, 80) }}</p>
                                        @endif

                                        <!-- Available Badge Below Description -->
                                        @if($membership->status == 'Active')
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
                                    <h5>No Membership Plans Available</h5>
                                    <p>Please check back later for new plans.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($memberships->hasPages())
                        <div class="pagination-wrapper">
                            {{ $memberships->links() }}
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
.membership-card-main {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(13, 27, 62, 0.08);
    overflow: hidden;
    border: 1px solid rgba(13, 27, 62, 0.06);
}

.membership-card-header {
    background: linear-gradient(135deg, #0d1b3e 0%, #1a2a6c 100%);
    color: #ffffff;
    padding: 18px 24px;
    border-bottom: none;
}

.membership-card-header h4 {
    font-weight: 600;
    font-size: 1.2rem;
}

.membership-card-header h4 i {
    color: #ffd54f;
}

.membership-card-body {
    padding: 24px;
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
/* PLAN IMAGE - FULL COVER                      */
/* ============================================ */
.plan-image {
    position: relative;
    height: 200px;
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

/* Status Badge - Only on Image */
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
    padding: 18px 20px 20px;
    flex: 1;
}

.plan-title {
    color: #0d1b3e;
    font-weight: 700;
    font-size: 1.15rem;
    margin-bottom: 6px;
}

.plan-duration {
    color: #64748b;
    font-size: 0.85rem;
    margin-bottom: 12px;
}

.plan-duration i {
    color: #1a2a6c;
}

/* ============================================ */
/* PLAN PRICE WITH DISCOUNT BADGE INSIDE        */
/* ============================================ */
.plan-price {
    padding: 12px 14px;
    background: #f8fafc;
    border-radius: 10px;
    border: 1px solid rgba(13, 27, 62, 0.06);
    margin-bottom: 12px;
}

.old-price {
    color: #94a3b8;
    font-size: 0.85rem;
    text-decoration: line-through;
    margin-right: 8px;
}

/* Discount Badge - Inside Price Section */
.discount-badge-inline {
    display: inline-block;
    padding: 2px 12px;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 700;
    color: #ffffff;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    box-shadow: 0 2px 8px rgba(245, 158, 11, 0.25);
    margin-left: 4px;
    vertical-align: middle;
}

.price-row {
    margin-top: 6px;
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

.plan-description {
    color: #64748b;
    font-size: 0.85rem;
    line-height: 1.6;
    margin-bottom: 12px;
}

/* ============================================ */
/* AVAILABILITY BADGE - Below Description       */
/* ============================================ */
.availability-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 16px;
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
/* RESPONSIVE                                   */
/* ============================================ */
@media (max-width: 992px) {
    .plan-image {
        height: 170px;
    }
    
    .new-price {
        font-size: 1.3rem;
    }
}

@media (max-width: 768px) {
    .membership-card-header {
        padding: 14px 18px;
    }
    
    .membership-card-header h4 {
        font-size: 1rem;
    }
    
    .membership-card-body {
        padding: 16px;
    }
    
    .plan-image {
        height: 160px;
    }
    
    .plan-content {
        padding: 14px 16px 16px;
    }
    
    .plan-title {
        font-size: 1rem;
    }
    
    .new-price {
        font-size: 1.2rem;
    }
    
    .badge-status {
        font-size: 0.65rem;
        padding: 4px 10px;
    }
    
    .discount-badge-inline {
        font-size: 0.6rem;
        padding: 2px 8px;
    }
    
    .pagination-wrapper {
        justify-content: center;
    }
    
    .pagination-wrapper .page-item .page-link {
        padding: 4px 10px;
        font-size: 0.8rem;
    }
}

@media (max-width: 480px) {
    .plan-image {
        height: 140px;
    }
    
    .plan-price {
        padding: 10px 12px;
    }
    
    .new-price {
        font-size: 1.1rem;
    }
    
    .old-price {
        font-size: 0.75rem;
    }
    
    .plan-description {
        font-size: 0.8rem;
    }
    
    .availability-badge {
        font-size: 0.7rem;
        padding: 4px 12px;
    }
    
    .price-duration {
        font-size: 0.7rem;
    }
}
</style>
@endsection