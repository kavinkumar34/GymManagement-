@extends('layouts.member-layout')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <div class="row">
        <div class="col-12">
            <div class="payment-card-main">
                <!-- Card Header - Matching Navbar Theme -->
                <div class="payment-card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h4 class="mb-0">
                        <i class="fas fa-hand-holding-usd me-2"></i> Hand Payment
                    </h4>
                    <span class="payment-date">
                        <i class="fas fa-calendar-alt me-1"></i> {{ now()->format('d M Y, h:i A') }}
                    </span>
                </div>
                
                <div class="payment-card-body">
                    
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

                    <div class="table-responsive">
                        <table class="payment-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Photo</th>
                                    <th>Member ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Plan Type</th>
                                    <th>Plan Name</th>
                                    <th>Final Price</th>
                                    <th>Joined Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($member)
                                    <tr>
                                        <td>{{ $member->id }}</td>
                                        <td>
                                            <div class="member-photo">
                                                @if($member->photo)
                                                    <img src="{{ asset('storage/'.$member->photo) }}" alt="{{ $member->name }}">
                                                @else
                                                    <span class="photo-placeholder">
                                                        {{ substr($member->name, 0, 1) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td><strong class="member-id">{{ $member->member_id }}</strong></td>
                                        <td class="member-name">{{ $member->name }}</td>
                                        <td class="member-email">{{ $member->email }}</td>
                                        <td class="member-phone">{{ $member->phone }}</td>
                                        <td>
                                            @if($member->plan_type == 'membership')
                                                <span class="plan-badge membership">
                                                    <i class="fas fa-id-card me-1"></i> Membership
                                                </span>
                                            @elseif($member->plan_type == 'package')
                                                <span class="plan-badge package">
                                                    <i class="fas fa-box me-1"></i> Package
                                                </span>
                                            @else
                                                <span class="plan-badge none">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="plan-name-badge">
                                                <i class="fas fa-tag me-1"></i> {{ $member->membership_plan ?? 'Basic' }}
                                            </span>
                                        </td>
                                        <td><span class="price-amount">₹ {{ number_format($member->final_price ?? 0, 2) }}</span></td>
                                        <td class="join-date">{{ date('d-m-Y', strtotime($member->join_date)) }}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="10" class="empty-row">
                                            <i class="fas fa-users fa-2x mb-2"></i>
                                            <p>No members found.</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ============================================ */
/* MAIN CARD - Matching Navbar Theme            */
/* ============================================ */
.payment-card-main {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(13, 27, 62, 0.08);
    overflow: hidden;
    border: 1px solid rgba(13, 27, 62, 0.06);
}

.payment-card-header {
    background: linear-gradient(135deg, #0d1b3e 0%, #1a2a6c 100%);
    color: #ffffff;
    padding: 18px 24px;
    border-bottom: none;
}

.payment-card-header h4 {
    font-weight: 600;
    font-size: 1.2rem;
}

.payment-card-header h4 i {
    color: #ffd54f;
}

.payment-date {
    background: rgba(255, 255, 255, 0.15);
    padding: 4px 14px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
    white-space: nowrap;
}

.payment-card-body {
    padding: 24px;
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
/* TABLE                                        */
/* ============================================ */
.payment-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.9rem;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(13, 27, 62, 0.06);
}

.payment-table thead {
    background: linear-gradient(135deg, #0d1b3e 0%, #1a2a6c 100%);
    color: #ffffff;
}

.payment-table thead th {
    padding: 12px 14px;
    text-align: left;
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    white-space: nowrap;
}

.payment-table tbody tr {
    border-bottom: 1px solid rgba(13, 27, 62, 0.06);
    transition: background 0.2s ease;
}

.payment-table tbody tr:hover {
    background: #f8fafc;
}

.payment-table tbody td {
    padding: 10px 14px;
    color: #334155;
    vertical-align: middle;
}

/* Member Photo */
.member-photo {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    overflow: hidden;
    border: 2px solid #e2e8f0;
    flex-shrink: 0;
}

.member-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.photo-placeholder {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: linear-gradient(135deg, #0d1b3e 0%, #1a2a6c 100%);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    font-weight: 700;
}

/* Table Cell Styles */
.member-id {
    color: #0d1b3e;
    font-weight: 700;
}

.member-name {
    font-weight: 600;
    color: #0d1b3e;
}

.member-email {
    color: #64748b;
    font-size: 0.85rem;
}

.member-phone {
    color: #64748b;
}

.price-amount {
    font-weight: 700;
    color: #10b981;
    font-size: 1rem;
}

.join-date {
    font-weight: 500;
    color: #0d1b3e;
    white-space: nowrap;
}

/* ============================================ */
/* PLAN BADGES - Navbar Colors                  */
/* ============================================ */
.plan-badge {
    padding: 4px 14px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
}

.plan-badge.membership {
    background: #dcfce7;
    color: #15803d;
}

.plan-badge.package {
    background: #fef3c7;
    color: #92400e;
}

.plan-badge.none {
    background: #f1f5f9;
    color: #64748b;
}

.plan-name-badge {
    padding: 4px 14px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    background: #dbeafe;
    color: #1d4ed8;
    display: inline-flex;
    align-items: center;
}

/* ============================================ */
/* EMPTY ROW                                    */
/* ============================================ */
.empty-row {
    padding: 40px 20px !important;
    color: #94a3b8;
    text-align: center;
}

.empty-row i {
    display: block;
    color: #94a3b8;
}

.empty-row p {
    margin: 0;
    font-size: 1rem;
}

/* ============================================ */
/* RESPONSIVE                                   */
/* ============================================ */
@media (max-width: 992px) {
    .payment-table {
        font-size: 0.8rem;
    }
    
    .payment-table thead th,
    .payment-table tbody td {
        padding: 8px 10px;
    }
    
    .payment-table thead th {
        font-size: 0.65rem;
    }
}

@media (max-width: 768px) {
    .payment-card-header {
        padding: 14px 18px;
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
    
    .payment-card-header h4 {
        font-size: 1rem;
    }
    
    .payment-card-body {
        padding: 16px;
    }
    
    .payment-table {
        font-size: 0.75rem;
    }
    
    .payment-table thead th,
    .payment-table tbody td {
        padding: 6px 8px;
    }
    
    .payment-table thead th {
        font-size: 0.6rem;
        letter-spacing: 0;
    }
    
    .member-photo {
        width: 35px;
        height: 35px;
    }
    
    .photo-placeholder {
        width: 35px;
        height: 35px;
        font-size: 0.9rem;
    }
    
    .price-amount {
        font-size: 0.85rem;
    }
    
    .plan-badge,
    .plan-name-badge {
        font-size: 0.65rem;
        padding: 2px 10px;
    }
    
    .payment-date {
        font-size: 0.7rem;
        padding: 2px 10px;
    }
}

@media (max-width: 480px) {
    .payment-card-body {
        padding: 12px;
    }
    
    .payment-table {
        font-size: 0.65rem;
    }
    
    .payment-table thead th,
    .payment-table tbody td {
        padding: 4px 6px;
    }
    
    .payment-table thead th {
        font-size: 0.5rem;
    }
    
    .member-photo {
        width: 28px;
        height: 28px;
    }
    
    .photo-placeholder {
        width: 28px;
        height: 28px;
        font-size: 0.7rem;
    }
    
    .member-email {
        font-size: 0.7rem;
    }
    
    .price-amount {
        font-size: 0.75rem;
    }
    
    .plan-badge,
    .plan-name-badge {
        font-size: 0.55rem;
        padding: 2px 6px;
    }
    
    .plan-badge i,
    .plan-name-badge i {
        display: none;
    }
}
</style>
@endsection