@extends('layouts.admin-layout')

@section('content')
<style>
    .stat-card-return {
        background: white;
        border-radius: 12px;
        padding: 15px 20px;
        border: 1px solid #e9ecef;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        transition: all 0.3s;
        text-align: center;
    }
    .stat-card-return:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    }
    .stat-card-return .stat-number {
        font-size: 24px;
        font-weight: 700;
    }
    .stat-card-return .stat-label {
        font-size: 12px;
        color: #64748b;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .stat-number.pending { color: #f59e0b; }
    .stat-number.processing { color: #3b82f6; }
   
    .stat-number.completed { color: #22c55e; }
    .stat-number.total { color: #0f172a; }

    .badge-return { background: #fee2e2; color: #dc2626; }
    .badge-exchange { background: #dbeafe; color: #2563eb; }
    .badge-pending { background: #fef3c7; color: #92400e; }
    .badge-processing { background: #dbeafe; color: #1d4ed8; }
    
    .badge-completed { background: #dcfce7; color: #15803d; }

    .table-returns thead th {
        background: #f8fafc;
        color: #475569;
        font-weight: 600;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 10px 14px;
        border-bottom: 2px solid #e2e8f0;
    }
    .table-returns tbody td {
        padding: 10px 14px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13px;
    }
    .btn-action-return {
        width: 30px;
        height: 30px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
    }
    .btn-action-return.view {
        background: rgba(74,158,255,0.1);
        color: #4a9eff;
    }
    .btn-action-return.view:hover {
        background: #4a9eff;
        color: #fff;
    }
    .btn-action-return.approve {
        background: rgba(34,197,94,0.1);
        color: #22c55e;
    }
    .btn-action-return.approve:hover {
        background: #22c55e;
        color: #fff;
    }
    .btn-action-return.reject {
        background: rgba(239,68,68,0.1);
        color: #ef4444;
    }
    .btn-action-return.reject:hover {
        background: #ef4444;
        color: #fff;
    }
</style>

<div class="admin-main-content">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <h4 style="font-weight:700; color:#1e293b; margin:0;">
                <i class="fas fa-undo-alt" style="color:#f59e0b;"></i> Return & Exchange Management
            </h4>
        </div>

        <!-- Stat Cards -->
     <div class="row g-3 mb-4">

    <div class="col-md-3 col-6">
        <div class="stat-card-return">
            <div class="stat-number total">
                {{ $counts['total'] ?? 0 }}
            </div>
            <div class="stat-label">Total</div>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="stat-card-return">
            <div class="stat-number pending">
                {{ $counts['pending'] ?? 0 }}
            </div>
            <div class="stat-label">Pending</div>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="stat-card-return">
            <div class="stat-number processing">
                {{ $counts['processing'] ?? 0 }}
            </div>
            <div class="stat-label">Processing</div>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="stat-card-return">
            <div class="stat-number completed">
                {{ $counts['completed'] ?? 0 }}
            </div>
            <div class="stat-label">Completed</div>
        </div>
    </div>

</div>

        <!-- Search & Filter -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label" style="font-size:12px; font-weight:600;">Search</label>
                        <input type="text" name="search" class="form-control" placeholder="Order # or Customer..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label" style="font-size:12px; font-weight:600;">Type</label>
                        <select name="request_type" class="form-select">
                            <option value="">All</option>
                            <option value="return" {{ request('request_type')=='return'?'selected':'' }}>Return</option>
                            <option value="exchange" {{ request('request_type')=='exchange'?'selected':'' }}>Exchange</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label" style="font-size:12px; font-weight:600;">Status</label>
                       <select name="status" class="form-select">

    <option value="">All</option>

    <option value="pending"
        {{ request('status') == 'pending' ? 'selected' : '' }}>
        Pending
    </option>

    <option value="processing"
        {{ request('status') == 'processing' ? 'selected' : '' }}>
        Processing
    </option>

    <option value="completed"
        {{ request('status') == 'completed' ? 'selected' : '' }}>
        Completed
    </option>

</select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100" style="background:#4a9eff; border:none;">
                            <i class="fas fa-search"></i> Filter
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('admin.returns.index') }}" class="btn btn-secondary w-100" style="background:#e9ecef; color:#6c757d; border:none;">
                            <i class="fas fa-undo"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table -->
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-returns">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Type</th>
                                <th>Product</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <th>Refund</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requests as $index => $req)
                            <tr id="return-row-{{ $req->id }}">
                                <td>{{ $requests->firstItem() + $index }}</td>
                                <td><strong>#{{ $req->order->order_number ?? 'N/A' }}</strong></td>
                                <td>
                                    <strong>{{ $req->user->name ?? 'N/A' }}</strong>
                                    <small class="d-block text-muted">{{ $req->user->email ?? '' }}</small>
                                </td>
                                <td>
                                    <span class="badge {{ $req->request_type == 'return' ? 'badge-return' : 'badge-exchange' }}">
                                        {{ $req->request_type_label }}
                                    </span>
                                </td>
                                <td>{{ $req->orderItem->product_name ?? 'N/A' }}</td>
                                <td>{{ Str::limit($req->reason, 25) }}</td>
                                <td>
                                    <span class="badge badge-{{ $req->status }}">
                                        {{ $req->status_label }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $totalRefund = ($req->refund_amount ?? 0) + ($req->order->shipping_charge ?? 0);
                                    @endphp
                                    ₹{{ number_format($totalRefund, 2) }}
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <button class="btn-action-return view" onclick="viewReturnDetails({{ $req->id }})" title="View">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                     <div class="dropdown">
    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" style="padding:2px 8px; font-size:11px;">
        <i class="fas fa-ellipsis-v"></i>
    </button>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="#" onclick="updateReturnStatus({{ $req->id }}, 'pending')">⏳ Pending</a></li>
        <li><a class="dropdown-item" href="#" onclick="updateReturnStatus({{ $req->id }}, 'processing')">🔄 Processing</a></li>
        <li><a class="dropdown-item" href="#" onclick="updateReturnStatus({{ $req->id }}, 'completed')">✅ Completed</a></li>
    </ul>
</div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">
                                    <i class="fas fa-inbox" style="font-size:32px; display:block; margin-bottom:8px;"></i>
                                    No return/exchange requests found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{ $requests->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>

    </div>
</div>

<!-- ===== DETAILS MODAL ===== -->
<div class="modal fade" id="returnDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background:#0d1b2a; color:white; border:none;">
                <h5 class="modal-title"><i class="fas fa-undo-alt me-2"></i> Request Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="returnDetailsContent">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-2 text-muted">Loading...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

function viewReturnDetails(id) {
    document.getElementById('returnDetailsContent').innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="mt-2 text-muted">Loading...</p>
        </div>
    `;

    fetch('/admin/returns/' + id + '/details')
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const req = data.request;
                document.getElementById('returnDetailsContent').innerHTML = `
                    <div class="row g-3">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-muted" style="font-size:11px;">REQUEST INFO</h6>
                            <p><strong>Type:</strong> <span class="badge ${req.request_type == 'return' ? 'badge-return' : 'badge-exchange'}">${req.request_type_label || req.request_type}</span></p>
                            <p><strong>Status:</strong> <span class="badge badge-${req.status}">${req.status_label || req.status}</span></p>
                            <p><strong>Reason:</strong> ${req.reason || 'N/A'}</p>
                            <p><strong>Comment:</strong> ${req.comment || 'No comment'}</p>
                            ${req.request_type === 'return' ? `
    <div
        class="mt-3 p-3"
        style="
            background:#f8fafc;
            border:1px solid #e2e8f0;
            border-radius:10px;
        "
    >
        <h6
            class="fw-bold"
            style="
                font-size:11px;
                color:#dc2626;
                margin-bottom:12px;
            "
        >
            <i class="fas fa-university me-1"></i>
            REFUND BANK DETAILS
        </h6>

        <div class="row g-2">

            <div class="col-md-12">
                <div class="small text-muted">
                    Bank Name
                </div>

                <div class="fw-bold">
                    ${req.bank_name || 'N/A'}
                </div>
            </div>

            <div class="col-md-6">
                <div class="small text-muted">
                    Account Number
                </div>

                <div class="fw-bold">
                    ${req.account_number || 'N/A'}
                </div>
            </div>

            <div class="col-md-6">
                <div class="small text-muted">
                    IFSC Code
                </div>

                <div class="fw-bold">
                    ${req.ifsc_code || 'N/A'}
                </div>
            </div>

        </div>
    </div>
` : ''}
                            <p><strong>Refund Amount:</strong> ₹${parseFloat(req.refund_amount || 0).toFixed(2)}</p>
                            <p><strong>Shipping Charge:</strong> ₹${parseFloat(req.order?.shipping_charge || 0).toFixed(2)}</p>
                            <p><strong>Total Refund:</strong> ₹${parseFloat(req.total_refund || 0).toFixed(2)}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold text-muted" style="font-size:11px;">ORDER INFO</h6>
                            <p><strong>Order #:</strong> #${req.order?.order_number || 'N/A'}</p>
                            <p><strong>Customer:</strong> ${req.user?.name || 'N/A'}</p>
                            <p><strong>Email:</strong> ${req.user?.email || 'N/A'}</p>
                            <p><strong>Product:</strong> ${req.product_name || req.orderItem?.product_name || 'N/A'}</p>
                            <p><strong>Quantity:</strong> ${req.return_quantity || 1}</p>
                     ${req.exchange_product_id ? `
    <p>
        <strong>Exchange Product:</strong>
        ${req.exchange_product?.name || 'N/A'}
    </p>

    ${
        (
            req.exchange_variant_id ||
            req.exchange_size ||
            req.exchange_color
        )
        ? `
            ${
                req.exchange_size
                    ? `
                        <p>
                            <strong>Exchange Size:</strong>
                            ${req.exchange_size}
                        </p>
                    `
                    : ''
            }

            ${
                req.exchange_color
                    ? `
                        <p>
                            <strong>Exchange Color:</strong>
                            ${req.exchange_color}
                        </p>
                    `
                    : ''
            }
        `
        : ''
    }

    <p>
        <strong>Exchange Quantity:</strong>
        ${req.exchange_quantity || 1}
    </p>
` : ''}
                        </div>
                    </div>
                    ${req.admin_comment ? `
                    <div class="mt-3 pt-3 border-top">
                        <h6 class="fw-bold text-muted" style="font-size:11px;">ADMIN COMMENT</h6>
                        <p>${req.admin_comment}</p>
                    </div>
                    ` : ''}
                    <div class="mt-3 pt-3 border-top">
                        <p class="text-muted"><strong>Submitted:</strong> ${new Date(req.created_at).toLocaleString()}</p>
                        ${req.processed_at ? `<p class="text-muted"><strong>Processed:</strong> ${new Date(req.processed_at).toLocaleString()}</p>` : ''}
                    </div>
                `;
                const modal = new bootstrap.Modal(document.getElementById('returnDetailsModal'));
                modal.show();
            } else {
                document.getElementById('returnDetailsContent').innerHTML = `
                    <div class="text-center py-4 text-danger">
                        <i class="fas fa-exclamation-circle" style="font-size:32px;"></i>
                        <p>${data.message || 'Error loading details'}</p>
                    </div>
                `;
            }
        })
        .catch(err => {
            document.getElementById('returnDetailsContent').innerHTML = `
                <div class="text-center py-4 text-danger">
                    <i class="fas fa-exclamation-circle" style="font-size:32px;"></i>
                    <p>Error loading details</p>
                </div>
            `;
        });
}

function updateReturnStatus(id, status) {
    if (!confirm('Are you sure you want to change status to ' + status + '?')) {
        return;
    }

    const btn = document.querySelector('#return-row-' + id + ' .dropdown-toggle');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    btn.disabled = true;

    fetch('/admin/returns/' + id + '/status', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ status })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'Error updating status');
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    })
    .catch(err => {
        alert('Network error');
        btn.innerHTML = originalText;
        btn.disabled = false;
    });
}
</script>
@endsection