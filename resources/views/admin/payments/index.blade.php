@extends('layouts.admin-layout')

@section('content')
<style>
    /* Order Details Modal Styles */
    .order-details-modal .modal-dialog {
        max-width: 800px;
    }
    .order-details-modal .modal-content {
        border-radius: 20px;
        overflow: hidden;
    }
    .order-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1.5rem;
        position: relative;
    }
    .order-header h3 {
        margin: 0;
        font-size: 1.5rem;
    }
    .order-header h5 {
        margin-top: 0.5rem;
        margin-bottom: 0;
        opacity: 0.9;
    }
    .order-status-badge {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
        padding: 0.5rem 1rem;
        border-radius: 40px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    .order-status-badge.Pending { background: #f59e0b; color: white; }
    .order-status-badge.Confirmed { background: #3b82f6; color: white; }
    .order-status-badge.Shipped { background: #8b5cf6; color: white; }
    .order-status-badge.Delivered { background: #10b981; color: white; }
    .order-status-badge.Cancelled { background: #ef4444; color: white; }
    .order-status-badge.Failed { background: #dc2626; color: white; }
    
    .detail-section {
        padding: 1.5rem;
        border-bottom: 1px solid #eef2f6;
    }
    .detail-section:last-child {
        border-bottom: none;
    }
    .section-title {
        font-size: 1rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .section-title i {
        color: #3b82f6;
    }
    .info-row {
        display: flex;
        margin-bottom: 0.75rem;
    }
    .info-label {
        width: 120px;
        font-weight: 600;
        color: #64748b;
    }
    .info-value {
        flex: 1;
        color: #1e293b;
    }
    .order-item {
        display: flex;
        gap: 1rem;
        padding: 1rem 0;
        border-bottom: 1px solid #eef2f6;
    }
    .order-item:last-child {
        border-bottom: none;
    }
    .order-item-image {
        width: 80px;
        height: 80px;
        background: #f1f5f9;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .order-item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .order-item-details {
        flex: 1;
    }
    .order-item-name {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.25rem;
    }
    .order-item-price {
        color: #3b82f6;
        font-weight: 700;
    }
    .order-item-quantity {
        color: #64748b;
        font-size: 0.8rem;
    }
    .order-item-total {
        text-align: right;
        font-weight: 700;
        color: #1e293b;
    }
    .address-card {
        background: #f8fafc;
        padding: 1rem;
        border-radius: 12px;
        margin-bottom: 0.5rem;
    }
    .payment-method-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 40px;
        background: #f1f5f9;
    }
    
    /* Table Styles */
    .table th, .table td {
        vertical-align: middle;
    }
    .btn-sm {
        margin: 0 2px;
    }
    .pagination {
        margin-bottom: 0;
    }
</style>

<div class="admin-main-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4><i class="fas fa-credit-card"></i> Orders & Payments Management</h4>
                <div>
                    <span class="badge bg-light text-dark">Total Orders: {{ $orders->total() }}</span>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Search and Filter Section -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search by Order Number, Customer Name..." value="{{ request('search') }}">
                            <button class="btn btn-primary" type="button" onclick="applyFilters()">
                                <i class="fas fa-search"></i> Search
                            </button>
                            <button class="btn btn-secondary" type="button" onclick="resetFilters()">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select id="paymentStatusFilter" class="form-select" onchange="applyFilters()">
                            <option value="">All Payment Status</option>
                            <option value="SUCCESS" {{ request('payment_status') == 'SUCCESS' ? 'selected' : '' }}>Paid</option>
                            <option value="FAILED" {{ request('payment_status') == 'FAILED' ? 'selected' : '' }}>Failed</option>
                            <option value="PENDING" {{ request('payment_status') == 'PENDING' ? 'selected' : '' }}>Pending</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="orderStatusFilter" class="form-select" onchange="applyFilters()">
                            <option value="">All Order Status</option>
                            <option value="Confirmed" {{ request('order_status') == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="Shipped" {{ request('order_status') == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="Delivered" {{ request('order_status') == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="Cancelled" {{ request('order_status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="Failed" {{ request('order_status') == 'Failed' ? 'selected' : '' }}>Failed</option>
                            <option value="Pending" {{ request('order_status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select id="perPageSelect" class="form-select" onchange="changePerPage()">
                            <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5 entries</option>
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 entries</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 entries</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 entries</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 entries</option>
                        </select>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%">ID</th>
                                <th width="15%">Order Number</th>
                                <th width="15%">Customer</th>
                                <th width="13%">Date & Time</th>
                                <th width="8%">Items</th>
                                <th width="10%">Total Amount</th>
                                <th width="10%">Order Status</th>
                                <th width="10%">Payment</th>
                                <th width="14%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td><strong>#{{ $order->order_number }}</strong></td>
                                <td>
                                    <strong>{{ $order->user->name ?? 'N/A' }}</strong><br>
                                    <small class="text-muted">{{ $order->user->email ?? 'N/A' }}</small>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($order->order_date ?? $order->created_at)->format('d/m/Y, h:i A') }}</td>
                                <td>{{ $order->items_count ?? $order->items->count() ?? 1 }} item(s)</td>
                                <td>₹{{ number_format($order->total_amount, 2) }}</td>
                                <td>
                                    @php
                                        $statusClass = 'secondary';
                                        if($order->order_status == 'Confirmed') $statusClass = 'primary';
                                        elseif($order->order_status == 'Shipped') $statusClass = 'info';
                                        elseif($order->order_status == 'Delivered') $statusClass = 'success';
                                        elseif($order->order_status == 'Cancelled') $statusClass = 'danger';
                                        elseif($order->order_status == 'Failed') $statusClass = 'danger';
                                        elseif($order->order_status == 'Pending') $statusClass = 'warning';
                                    @endphp
                                    <span class="badge bg-{{ $statusClass }}">{{ $order->order_status }}</span>
                                </td>
                                <td>
                                    @if($order->payment_status == 'SUCCESS')
                                        <span class="badge bg-success">Paid</span>
                                    @elseif($order->payment_status == 'FAILED')
                                        <span class="badge bg-danger">Failed</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-info" onclick="viewOrderDetails({{ $order->id }})" title="View Details">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                    <button class="btn btn-sm btn-warning" onclick="updateOrderStatus({{ $order->id }}, '{{ $order->order_status }}')" title="Update Status">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center">No orders found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <div>
                        <small>Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} entries</small>
                    </div>
                    <div>
                        {{ $orders->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Order Details Modal -->
<div class="modal fade order-details-modal" id="orderDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="order-header">
                <h3>Order Details</h3>
                <h5 id="modalOrderNumber">#ORDER_ID</h5>
                <span class="order-status-badge" id="modalOrderStatus">Pending</span>
            </div>
            <div class="modal-body p-0">
                <!-- Order Info Section -->
                <div class="detail-section">
                    <div class="section-title">
                        <i class="fas fa-info-circle"></i> Order Information
                    </div>
                    <div class="info-row">
                        <div class="info-label">Order Date:</div>
                        <div class="info-value" id="modalOrderDate">-</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Transaction ID:</div>
                        <div class="info-value" id="modalTransactionId">-</div>
                    </div>
                </div>

                <!-- Customer Details Section -->
                <div class="detail-section">
                    <div class="section-title">
                        <i class="fas fa-user-circle"></i> Customer Details
                    </div>
                    <div class="info-row">
                        <div class="info-label">Name:</div>
                        <div class="info-value" id="modalCustomerName">-</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Email:</div>
                        <div class="info-value" id="modalCustomerEmail">-</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Phone:</div>
                        <div class="info-value" id="modalCustomerPhone">-</div>
                    </div>
                </div>

                <!-- Order Summary Section -->
                <div class="detail-section">
                    <div class="section-title">
                        <i class="fas fa-receipt"></i> Order Summary
                    </div>
                    <div class="info-row">
                        <div class="info-label">Total Amount:</div>
                        <div class="info-value" id="modalTotal">-</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Order Status:</div>
                        <div class="info-value" id="modalOrderStatusText">-</div>
                    </div>
                </div>

                <!-- Shipping Address Section -->
                <div class="detail-section">
                    <div class="section-title">
                        <i class="fas fa-map-marker-alt"></i> Shipping Address
                    </div>
                    <div class="address-card" id="modalShippingAddress">No address information available</div>
                </div>

                <!-- Payment Information Section -->
                <div class="detail-section">
                    <div class="section-title">
                        <i class="fas fa-credit-card"></i> Payment Information
                    </div>
                    <div class="info-row">
                        <div class="info-label">Method:</div>
                        <div class="info-value" id="modalPaymentMethod">-</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Status:</div>
                        <div class="info-value" id="modalPaymentStatus">-</div>
                    </div>
                    <div class="info-row" id="paymentIdRow" style="display: none;">
                        <div class="info-label">Payment ID:</div>
                        <div class="info-value" id="modalPaymentId">-</div>
                    </div>
                </div>

                <!-- Order Items Section -->
                <div class="detail-section">
                    <div class="section-title">
                        <i class="fas fa-box"></i> Order Items
                    </div>
                    <div id="modalOrderItems"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Update Status Modal -->
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Update Order Status</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="statusOrderId">
                <div class="mb-3">
                    <label class="form-label">Order Status</label>
                    <select id="orderStatusSelect" class="form-select">
                        <option value="Pending">Pending</option>
                        <option value="Confirmed">Confirmed</option>
                        <option value="Shipped">Shipped</option>
                        <option value="Delivered">Delivered</option>
                        <option value="Cancelled">Cancelled</option>
                        <option value="Failed">Failed</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveStatusUpdate()">Update Status</button>
            </div>
        </div>
    </div>
</div>

<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
// Load order details when view button is clicked
async function viewOrderDetails(orderId) {
    try {
        const response = await fetch(`/admin/payments/${orderId}`);
        const data = await response.json();
        
        if (data.success) {
            const order = data.order;
            
            // Set modal header
            document.getElementById('modalOrderNumber').innerText = '#' + order.order_number;
            document.getElementById('modalOrderStatus').innerText = order.order_status;
            document.getElementById('modalOrderStatus').className = 'order-status-badge ' + order.order_status;
            
            // Order Information
            document.getElementById('modalOrderDate').innerText = new Date(order.order_date || order.created_at).toLocaleString();
            document.getElementById('modalTransactionId').innerText = order.transaction_id || 'N/A';
            
            // Customer Details
            document.getElementById('modalCustomerName').innerText = order.user?.name || 'N/A';
            document.getElementById('modalCustomerEmail').innerText = order.user?.email || 'N/A';
            document.getElementById('modalCustomerPhone').innerText = order.shipping_address?.phone || order.user?.phone || 'N/A';
            
            // Order Summary
            document.getElementById('modalTotal').innerText = '₹' + formatNumber(order.total_amount);
            document.getElementById('modalOrderStatusText').innerHTML = getStatusBadge(order.order_status);
            
            // Shipping Address - Parse from payment_details or separate field
            let addressHtml = 'No address information available';
            if (order.shipping_address) {
                let addr = typeof order.shipping_address === 'string' ? JSON.parse(order.shipping_address) : order.shipping_address;
                addressHtml = `
                    <strong>${addr.name || 'N/A'}</strong><br>
                    ${addr.address || ''}${addr.address ? ', ' : ''}${addr.area || ''}<br>
                    ${addr.city || ''}, ${addr.state || ''} - ${addr.pincode || ''}<br>
                    Phone: ${addr.phone || 'N/A'}
                `;
            } else if (order.payment_details) {
                try {
                    let details = typeof order.payment_details === 'string' ? JSON.parse(order.payment_details) : order.payment_details;
                    if (details.shipping_address) {
                        addressHtml = `
                            <strong>${details.shipping_address.name || 'N/A'}</strong><br>
                            ${details.shipping_address.address || ''}<br>
                            ${details.shipping_address.city || ''}, ${details.shipping_address.state || ''} - ${details.shipping_address.pincode || ''}<br>
                            Phone: ${details.shipping_address.phone || 'N/A'}
                        `;
                    }
                } catch(e) {}
            }
            document.getElementById('modalShippingAddress').innerHTML = addressHtml;
            
            // Payment Information
            document.getElementById('modalPaymentMethod').innerHTML = getPaymentMethodBadge(order.payment_method);
            document.getElementById('modalPaymentStatus').innerHTML = getPaymentStatusBadge(order.payment_status);
            
            if (order.payment_id) {
                document.getElementById('paymentIdRow').style.display = 'flex';
                document.getElementById('modalPaymentId').innerText = order.payment_id;
            } else {
                document.getElementById('paymentIdRow').style.display = 'none';
            }
            
            // Order Items
            let itemsHtml = '';
            if (order.items && order.items.length > 0) {
                order.items.forEach(item => {
                    itemsHtml += `
                        <div class="order-item">
                            <div class="order-item-image">
                                ${item.product_image ? `<img src="/storage/${item.product_image}" alt="${item.product_name}">` : '<i class="fas fa-tshirt fa-2x text-muted"></i>'}
                            </div>
                            <div class="order-item-details">
                                <div class="order-item-name">${item.product_name}</div>
                                <div class="order-item-price">₹${formatNumber(item.price)}</div>
                                <div class="order-item-quantity">Quantity: ${item.quantity}</div>
                            </div>
                            <div class="order-item-total">₹${formatNumber(item.price * item.quantity)}</div>
                        </div>
                    `;
                });
            } else {
                itemsHtml = '<div class="text-muted">No items found</div>';
            }
            document.getElementById('modalOrderItems').innerHTML = itemsHtml;
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('orderDetailsModal'));
            modal.show();
        } else {
            alert('Error loading order details');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error loading order details');
    }
}

function getStatusBadge(status) {
    const badges = {
        'Pending': '<span class="badge bg-warning">Pending</span>',
        'Confirmed': '<span class="badge bg-primary">Confirmed</span>',
        'Shipped': '<span class="badge bg-info">Shipped</span>',
        'Delivered': '<span class="badge bg-success">Delivered</span>',
        'Cancelled': '<span class="badge bg-danger">Cancelled</span>',
        'Failed': '<span class="badge bg-danger">Failed</span>'
    };
    return badges[status] || `<span class="badge bg-secondary">${status}</span>`;
}

function getPaymentMethodBadge(method) {
    const methods = {
        'cod': '<span class="payment-method-badge"><i class="fas fa-money-bill-wave"></i> Cash on Delivery</span>',
        'online': '<span class="payment-method-badge"><i class="fas fa-credit-card"></i> Online Payment</span>',
        'card': '<span class="payment-method-badge"><i class="fas fa-credit-card"></i> Card</span>'
    };
    return methods[method] || `<span class="payment-method-badge">${method || 'N/A'}</span>`;
}

function getPaymentStatusBadge(status) {
    if (status === 'SUCCESS') {
        return '<span class="badge bg-success">Paid</span>';
    } else if (status === 'FAILED') {
        return '<span class="badge bg-danger">Failed</span>';
    }
    return '<span class="badge bg-warning">Pending</span>';
}

function formatNumber(num) {
    return parseFloat(num).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

// Update order status
function updateOrderStatus(orderId, currentStatus) {
    document.getElementById('statusOrderId').value = orderId;
    document.getElementById('orderStatusSelect').value = currentStatus;
    const modal = new bootstrap.Modal(document.getElementById('statusModal'));
    modal.show();
}

async function saveStatusUpdate() {
    const orderId = document.getElementById('statusOrderId').value;
    const status = document.getElementById('orderStatusSelect').value;
    
    try {
        const response = await fetch(`/admin/payments/${orderId}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ order_status: status })
        });
        
        const data = await response.json();
        
        if (data.success) {
            alert('Order status updated successfully!');
            location.reload();
        } else {
            alert('Error updating status');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error updating status');
    }
}

function deleteOrder(id) {
    if(confirm('Are you sure you want to delete this order?')) {
        let form = document.getElementById('delete-form');
        form.action = '/admin/payments/' + id;
        form.submit();
    }
}

function applyFilters() {
    let search = document.getElementById('searchInput').value;
    let paymentStatus = document.getElementById('paymentStatusFilter').value;
    let orderStatus = document.getElementById('orderStatusFilter').value;
    let perPage = document.getElementById('perPageSelect').value;
    
    let url = new URL(window.location.href);
    url.searchParams.set('search', search);
    url.searchParams.set('payment_status', paymentStatus);
    url.searchParams.set('order_status', orderStatus);
    url.searchParams.set('per_page', perPage);
    url.searchParams.set('page', 1);
    
    window.location.href = url.toString();
}

function resetFilters() {
    let url = new URL(window.location.href);
    url.searchParams.delete('search');
    url.searchParams.delete('payment_status');
    url.searchParams.delete('order_status');
    url.searchParams.delete('per_page');
    url.searchParams.set('page', 1);
    
    window.location.href = url.toString();
}

function changePerPage() {
    let perPage = document.getElementById('perPageSelect').value;
    let url = new URL(window.location.href);
    url.searchParams.set('per_page', perPage);
    url.searchParams.set('page', 1);
    window.location.href = url.toString();
}
</script>
@endsection