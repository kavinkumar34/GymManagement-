@extends('layouts.admin')

@section('title', 'Manage Coupons')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4><i class="fas fa-ticket-alt me-2"></i> Coupons</h4>
        <a href="{{ route('admin.coupons.create') }}" class="btn btn-success">
            <i class="fas fa-plus me-1"></i> Add New Coupon
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Value</th>
                            <th>Min Order</th>
                            <th>Used / Limit</th>
                            <th>Validity</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($coupons as $coupon)
                            @php
                                $validity = $coupon->isValid();
                                $statusClass = $coupon->is_active ? 'active' : 'inactive';
                                if (!$validity['valid'] && $coupon->is_active) {
                                    $statusClass = 'expired';
                                }
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $coupon->code }}</strong></td>
                                <td>{{ $coupon->name ?? '-' }}</td>
                                <td>
                                    <span class="badge {{ $coupon->type == 'percentage' ? 'bg-primary' : 'bg-success' }}">
                                        {{ ucfirst($coupon->type) }}
                                    </span>
                                </td>
                                <td>
                                    @if ($coupon->type == 'percentage')
                                        {{ $coupon->value }}%
                                    @else
                                        ₹{{ number_format($coupon->value, 2) }}
                                    @endif
                                    @if ($coupon->max_discount)
                                        <br><small class="text-muted">Max: ₹{{ $coupon->max_discount }}</small>
                                    @endif
                                </td>
                                <td>₹{{ number_format($coupon->min_order_amount ?? 0, 2) }}</td>
                                <td>
                                    {{ $coupon->used_count }} /
                                    {{ $coupon->usage_limit ?? '∞' }}
                                    <br><small class="text-muted">Per user: {{ $coupon->per_user_limit ?? 1 }}</small>
                                </td>
                                <td>
                                    @if ($coupon->start_date || $coupon->end_date)
                                        <small>
                                            @if ($coupon->start_date)
                                                From: {{ $coupon->start_date->format('d M Y') }}<br>
                                            @endif
                                            @if ($coupon->end_date)
                                                To: {{ $coupon->end_date->format('d M Y') }}
                                            @endif
                                        </small>
                                    @else
                                        <span class="text-muted">Always</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="status-badge {{ $statusClass }}">
                                        @if ($statusClass == 'active')
                                            <i class="fas fa-check-circle me-1"></i> Active
                                        @elseif($statusClass == 'expired')
                                            <i class="fas fa-clock me-1"></i> Expired
                                        @else
                                            <i class="fas fa-times-circle me-1"></i> Inactive
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-info"
                                            onclick="viewCoupon('{{ $coupon->id }}')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <a href="{{ route('admin.coupons.edit', $coupon->id) }}"
                                            class="btn btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST"
                                            onsubmit="return confirm('Delete this coupon?')" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-4 text-muted">
                                    <i class="fas fa-ticket-alt fa-2x d-block mb-2"></i>
                                    No coupons found. <a href="{{ route('admin.coupons.create') }}">Create one now!</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ===== VIEW COUPON MODAL ===== -->
    <div class="modal fade" id="viewCouponModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #0d1b2a, #1b3a5c);">
                    <h5 class="modal-title text-white">
                        <i class="fas fa-ticket-alt me-2"></i> Coupon Details
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="couponDetailsBody">
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Loading coupon details...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function viewCoupon(id) {
            const modal = new bootstrap.Modal(document.getElementById('viewCouponModal'));
            const body = document.getElementById('couponDetailsBody');

            // Show loading
            body.innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2 text-muted">Loading coupon details...</p>
            </div>
        `;

            modal.show();

            // Fetch coupon details
            fetch(`/admin/coupons/${id}/view`, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const coupon = data.coupon;

                        // Determine status
                        let statusBadge = '';
                        if (coupon.is_active) {
                            const now = new Date();
                            const endDate = coupon.end_date ? new Date(coupon.end_date) : null;
                            if (endDate && endDate < now) {
                                statusBadge =
                                    '<span class="status-badge expired"><i class="fas fa-clock me-1"></i> Expired</span>';
                            } else {
                                statusBadge =
                                    '<span class="status-badge active"><i class="fas fa-check-circle me-1"></i> Active</span>';
                            }
                        } else {
                            statusBadge =
                                '<span class="status-badge inactive"><i class="fas fa-times-circle me-1"></i> Inactive</span>';
                        }

                        // Determine type badge
                        const typeBadge = coupon.type === 'percentage' ?
                            '<span class="badge bg-primary">Percentage (%)</span>' :
                            '<span class="badge bg-success">Fixed Amount (₹)</span>';

                        body.innerHTML = `
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="fw-bold text-muted small">Coupon Code</label>
                                <div class="p-2 bg-light rounded">
                                    <strong style="font-size: 1.2rem;">${coupon.code}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="fw-bold text-muted small">Status</label>
                                <div class="p-2 bg-light rounded">
                                    ${statusBadge}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="fw-bold text-muted small">Coupon Name</label>
                                <div class="p-2 bg-light rounded">
                                    ${coupon.name || '-'}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="fw-bold text-muted small">Discount Type</label>
                                <div class="p-2 bg-light rounded">
                                    ${typeBadge}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="fw-bold text-muted small">Discount Value</label>
                                <div class="p-2 bg-light rounded">
                                    <strong>${coupon.type === 'percentage' ? coupon.value + '%' : '₹' + parseFloat(coupon.value).toFixed(2)}</strong>
                                    ${coupon.max_discount ? `<br><small class="text-muted">Max Discount: ₹${parseFloat(coupon.max_discount).toFixed(2)}</small>` : ''}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="fw-bold text-muted small">Min Order Amount</label>
                                <div class="p-2 bg-light rounded">
                                    ${parseFloat(coupon.min_order_amount || 0).toFixed(2) > 0 ? '₹' + parseFloat(coupon.min_order_amount).toFixed(2) : 'No minimum'}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="fw-bold text-muted small">Usage</label>
                                <div class="p-2 bg-light rounded">
                                    ${coupon.used_count} used / ${coupon.usage_limit || '∞'} limit
                                    <br><small class="text-muted">Per user: ${coupon.per_user_limit || 1} time(s)</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="fw-bold text-muted small">Validity</label>
                                <div class="p-2 bg-light rounded">
                                    ${coupon.start_date ? 'From: ' + formatDate(coupon.start_date) + '<br>' : ''}
                                    ${coupon.end_date ? 'To: ' + formatDate(coupon.end_date) : 'No expiry'}
                                    ${!coupon.start_date && !coupon.end_date ? '<span class="text-muted">Always valid</span>' : ''}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="fw-bold text-muted small">Created At</label>
                                <div class="p-2 bg-light rounded">
                                    ${formatDate(coupon.created_at)}
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                    } else {
                        body.innerHTML = `
                    <div class="text-center py-4 text-danger">
                        <i class="fas fa-exclamation-circle fa-3x mb-3"></i>
                        <h5>${data.message || 'Failed to load coupon details'}</h5>
                        <p class="text-muted">Please try again</p>
                    </div>
                `;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    body.innerHTML = `
                <div class="text-center py-4 text-danger">
                    <i class="fas fa-exclamation-circle fa-3x mb-3"></i>
                    <h5>Error loading coupon details</h5>
                    <p class="text-muted">${error.message || 'Please try again'}</p>
                </div>
            `;
                });
        }

        function formatDate(dateString) {
            if (!dateString) return 'Not set';
            try {
                const date = new Date(dateString);
                if (isNaN(date.getTime())) return 'Invalid date';
                return date.toLocaleDateString('en-IN', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
            } catch (e) {
                return 'Invalid date';
            }
        }
    </script>

    <style>
        .modal-header {
            border-radius: 12px 12px 0 0;
        }

        .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        }

        .modal-body {
            padding: 25px;
        }

        .bg-light {
            background-color: #f8f9fa !important;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            display: inline-block;
        }

        .status-badge.active {
            background: #dcfce7;
            color: #15803d;
        }

        .status-badge.inactive {
            background: #fee2e2;
            color: #b91c1c;
        }

        .status-badge.expired {
            background: #fef3c7;
            color: #92400e;
        }
    </style>
@endsection
