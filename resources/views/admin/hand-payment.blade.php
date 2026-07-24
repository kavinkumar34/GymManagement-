@extends('layouts.admin-layout')

@section('content')
<style>
    .hand-payment-header {
        background: linear-gradient(135deg, #0d1b2a 0%, #1b3a5c 50%, #0d1b2a 100%);
        color: white;
        padding: 18px 24px;
        border: none;
    }
    
    .hand-payment-header h4 {
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0;
    }
    
    .hand-payment-header h4 i {
        margin-right: 10px;
    }
    
    .badge-plan {
        background: #dbeafe;
        color: #1d4ed8;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .badge-package {
        background: #fef3c7;
        color: #92400e;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .badge-membership {
        background: #dcfce7;
        color: #15803d;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .table th {
        white-space: nowrap;
        font-size: 0.8rem;
    }
    
    .table td {
        vertical-align: middle;
        font-size: 0.9rem;
    }
</style>

<div class="admin-main-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header hand-payment-header d-flex justify-content-between align-items-center">
                <h4><i class="fas fa-hand-holding-usd"></i> Hand Payment</h4>
                <span style="color: rgba(255,255,255,0.7); font-size: 0.9rem;">
                    <i class="fas fa-calendar-alt me-1"></i> {{ now()->format('d M Y, h:i A') }}
                </span>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
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
                            @forelse($members as $member)
                            <tr>
                                <td>{{ $member->id }}</td>
                                <td class="text-center">
                                    @if($member->photo)
                                        <img src="{{ asset('storage/'.$member->photo) }}"
                                             width="45"
                                             height="45"
                                             class="rounded-circle"
                                             style="object-fit:cover; border: 2px solid #e2e8f0;">
                                    @else
                                        <img src="{{ asset('images/no-image.png') }}"
                                             width="45"
                                             height="45"
                                             class="rounded-circle">
                                    @endif
                                </td>
                                <td><strong>{{ $member->member_id }}</strong></td>
                                <td>{{ $member->name }}</td>
                                <td>{{ $member->email }}</td>
                                <td>{{ $member->phone }}</td>
                                <td>
                                    @if($member->plan_type == 'membership')
                                        <span class="badge badge-membership"><i class="fas fa-id-card me-1"></i> Membership</span>
                                    @elseif($member->plan_type == 'package')
                                        <span class="badge badge-package"><i class="fas fa-box me-1"></i> Package</span>
                                    @else
                                        <span class="badge bg-secondary">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-plan">
                                        <i class="fas fa-tag me-1"></i> {{ $member->membership_plan ?? 'Basic' }}
                                    </span>
                                </td>
                                <td><strong style="color: #10b981;">₹{{ number_format($member->final_price ?? 0, 2) }}</strong></td>
                                <td>{{ date('d-m-Y', strtotime($member->join_date)) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted py-4">
                                    <i class="fas fa-users fa-2x d-block mb-2" style="color: #d1d5db;"></i>
                                    No members found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $members->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection