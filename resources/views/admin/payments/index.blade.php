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
    .order-status-badge.Shipped { background: #06b6d4; color: white; }
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
        line-height: 1.6;
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
    
    /* Status Dropdown Button Styles */
    .status-dropdown-btn {
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        color: white;
        border: none;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        cursor: pointer;
        min-width: 90px;
    }
    .status-dropdown-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(59,130,246,0.3);
    }
    .dropdown-menu {
        min-width: 150px;
    }
    .dropdown-item.status-opt {
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.85rem;
        padding: 0.5rem 1rem;
    }
    .dropdown-item.status-opt:hover {
        background-color: #eef2ff;
    }
    .dropdown-item.status-opt i {
        width: 24px;
        margin-right: 8px;
    }
    
    .fa-spinner {
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
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
                    <table class="table table-bordered table-hover" id="ordersTable">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%">ORDER ID</th>
                                <th width="13%">DATE & TIME</th>
                                <th width="15%">CUSTOMER</th>
                                <th width="8%">ITEMS</th>
                                <th width="10%">TOTAL AMOUNT</th>
                                <th width="10%">ORDER STATUS</th>
                                <th width="10%">PAYMENT</th>
                                <th width="15%">UPDATE STATUS</th>
                                <th width="14%">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr id="order-row-{{ $order->id }}">
                                <td><strong>#{{ $order->order_number }}</strong></td>
                                <td>{{ \Carbon\Carbon::parse($order->order_date ?? $order->created_at)->format('d/m/Y, h:i A') }}</td>
                                <td>
                                    <strong>{{ $order->user->name ?? 'N/A' }}</strong><br>
                                    <small class="text-muted">{{ $order->user->email ?? 'N/A' }}</small>
                                 </td>
                                <td>{{ $order->items->count() }} item(s)</td>
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
                                    <span class="badge bg-{{ $statusClass }} order-status-badge-{{ $order->id }}" id="order-status-{{ $order->id }}">{{ $order->order_status }}</span>
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
                                    <div class="dropdown">
                                        <button class="btn status-dropdown-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" id="status-btn-{{ $order->id }}">
                                            {{ $order->order_status }}
                                        </button>
                                        <ul class="dropdown-menu" id="status-menu-{{ $order->id }}">
                                            <li><a class="dropdown-item status-opt" href="#" data-id="{{ $order->id }}" data-status="Pending"><i class="fas fa-clock text-warning"></i> Pending</a></li>
                                            <li><a class="dropdown-item status-opt" href="#" data-id="{{ $order->id }}" data-status="Confirmed"><i class="fas fa-check-circle text-primary"></i> Confirmed</a></li>
                                            <li><a class="dropdown-item status-opt" href="#" data-id="{{ $order->id }}" data-status="Shipped"><i class="fas fa-truck text-info"></i> Shipped</a></li>
                                            <li><a class="dropdown-item status-opt" href="#" data-id="{{ $order->id }}" data-status="Delivered"><i class="fas fa-check-double text-success"></i> Delivered</a></li>
                                            <li><a class="dropdown-item status-opt" href="#" data-id="{{ $order->id }}" data-status="Cancelled"><i class="fas fa-times-circle text-danger"></i> Cancelled</a></li>
                                            <li><a class="dropdown-item status-opt" href="#" data-id="{{ $order->id }}" data-status="Failed"><i class="fas fa-exclamation-triangle text-danger"></i> Failed</a></li>
                                        </ul>
                                    </div>
                                 </td>
                                <td>
                                    <button class="btn btn-sm btn-info" onclick="viewOrderDetails({{ $order->id }})" title="View Details">
                                        <i class="fas fa-eye"></i> View
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
<div class="modal fade order-details-modal" id="orderDetailsModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="order-header">
                <h3>Order Details</h3>
                <h5 id="modalOrderNumber">#ORDER_ID</h5>
                <span class="order-status-badge" id="modalOrderStatus">Pending</span>
            </div>
            <div class="modal-body p-0">
                <div class="detail-section">
                    <div class="section-title"><i class="fas fa-info-circle"></i> Order Information</div>
                    <div class="info-row">
                        <div class="info-label">Order Date:</div>
                        <div class="info-value" id="modalOrderDate">-</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Transaction ID:</div>
                        <div class="info-value" id="modalTransactionId">-</div>
                    </div>
                </div>

                <div class="detail-section">
                    <div class="section-title"><i class="fas fa-user-circle"></i> Customer Details</div>
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

                <div class="detail-section">
                    <div class="section-title"><i class="fas fa-receipt"></i> Order Summary</div>
                    <div class="info-row">
                        <div class="info-label">Total Amount:</div>
                        <div class="info-value" id="modalTotal">-</div>
                    </div>
                </div>

                <!-- Shipping Address Section -->
                <div class="detail-section">
                    <div class="section-title"><i class="fas fa-map-marker-alt"></i> Shipping Address</div>
                    <div class="address-card" id="modalShippingAddress">
                        Loading address...
                    </div>
                </div>

                <div class="detail-section">
                    <div class="section-title"><i class="fas fa-credit-card"></i> Payment Information</div>
                    <div class="info-row">
                        <div class="info-label">Method:</div>
                        <div class="info-value" id="modalPaymentMethod">-</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Status:</div>
                        <div class="info-value" id="modalPaymentStatus">-</div>
                    </div>
                </div>

                <div class="detail-section">
                    <div class="section-title"><i class="fas fa-box"></i> Order Items</div>
                    <div id="modalOrderItems"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
// Get CSRF token from meta tag
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

// Function to attach event listeners to status options
function attachStatusEventListeners() {
    document.querySelectorAll('.status-opt').forEach(function(link) {
        link.removeEventListener('click', statusClickHandler);
        link.addEventListener('click', statusClickHandler);
    });
}

// Status click handler function
function statusClickHandler(e) {
    e.preventDefault();
    e.stopPropagation();
    
    var orderId = this.getAttribute('data-id');
    var newStatus = this.getAttribute('data-status');
    var currentBtn = document.getElementById('status-btn-' + orderId);
    var currentStatus = currentBtn ? currentBtn.innerText : '';
    
    if (confirm('Change order status from "' + currentStatus + '" to "' + newStatus + '"?')) {
        updateOrderStatus(orderId, newStatus);
    }
}

// Update order status function
function updateOrderStatus(orderId, newStatus) {
    var dropdownBtn = document.getElementById('status-btn-' + orderId);
    var originalText = dropdownBtn.innerText;
    
    dropdownBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    dropdownBtn.disabled = true;
    
    fetch('/admin/payments/' + orderId + '/status', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ order_status: newStatus })
    })
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {
        console.log('Response:', data);
        
        if (data.success) {
            var statusBadge = document.getElementById('order-status-' + orderId);
            if (statusBadge) {
                var badgeClass = 'badge ';
                if (newStatus == 'Confirmed') badgeClass += 'bg-primary';
                else if (newStatus == 'Shipped') badgeClass += 'bg-info';
                else if (newStatus == 'Delivered') badgeClass += 'bg-success';
                else if (newStatus == 'Cancelled') badgeClass += 'bg-danger';
                else if (newStatus == 'Failed') badgeClass += 'bg-danger';
                else if (newStatus == 'Pending') badgeClass += 'bg-warning';
                else badgeClass += 'bg-secondary';
                
                statusBadge.className = badgeClass;
                statusBadge.innerText = newStatus;
            }
            
            dropdownBtn.innerText = newStatus;
            
            var menu = document.getElementById('status-menu-' + orderId);
            if (menu) {
                var items = menu.querySelectorAll('.status-opt');
                items.forEach(function(item) {
                    item.setAttribute('data-id', orderId);
                });
            }
            
            attachStatusEventListeners();
            alert('Order status updated successfully to "' + newStatus + '"!');
        } else {
            alert(data.message || 'Error updating status');
            dropdownBtn.innerText = originalText;
        }
    })
    .catch(function(error) {
        console.error('Error:', error);
        alert('Network error. Please try again.');
        dropdownBtn.innerText = originalText;
    })
    .finally(function() {
        dropdownBtn.disabled = false;
    });
}

// Escape HTML function
function escapeHtml(text) {
    if (!text) return '';
    var div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Format number function
function formatNumber(num) {
    return parseFloat(num).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

// Get payment method badge
function getPaymentMethodBadge(method) {
    if (method === 'cod') {
        return '<span class="payment-method-badge"><i class="fas fa-money-bill-wave"></i> Cash on Delivery</span>';
    } else if (method === 'online' || method === 'card') {
        return '<span class="payment-method-badge"><i class="fas fa-credit-card"></i> Online Payment</span>';
    }
    return '<span class="payment-method-badge">' + (method || 'N/A') + '</span>';
}

// Get payment status badge
function getPaymentStatusBadge(status) {
    if (status === 'SUCCESS') {
        return '<span class="badge bg-success">Paid</span>';
    } else if (status === 'FAILED') {
        return '<span class="badge bg-danger">Failed</span>';
    }
    return '<span class="badge bg-warning">Pending</span>';
}

// View order details with shipping address
function viewOrderDetails(orderId) {
    // Show loading state
    document.getElementById('modalShippingAddress').innerHTML = '<div class="address-card">Loading address...</div>';
    
    fetch('/admin/payments/' + orderId)
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            if (data.success) {
                var order = data.order;
                
                // Basic order info
                document.getElementById('modalOrderNumber').innerText = order.order_number;
                document.getElementById('modalOrderStatus').innerText = order.order_status;
                document.getElementById('modalOrderStatus').className = 'order-status-badge ' + order.order_status;
                document.getElementById('modalOrderDate').innerText = new Date(order.order_date || order.created_at).toLocaleString();
                document.getElementById('modalTransactionId').innerText = order.transaction_id || 'N/A';
                document.getElementById('modalCustomerName').innerText = order.user?.name || 'N/A';
                document.getElementById('modalCustomerEmail').innerText = order.user?.email || 'N/A';
                document.getElementById('modalCustomerPhone').innerText = order.user?.phone || 'N/A';
                document.getElementById('modalTotal').innerText = '₹' + formatNumber(order.total_amount);
                
                // Payment info
                document.getElementById('modalPaymentMethod').innerHTML = getPaymentMethodBadge(order.payment_method);
                document.getElementById('modalPaymentStatus').innerHTML = getPaymentStatusBadge(order.payment_status);
                
                // Order Items
                var itemsHtml = '';
                if (order.items && order.items.length > 0) {
                    for (var i = 0; i < order.items.length; i++) {
                        var item = order.items[i];
                        itemsHtml += '<div class="order-item">' +
                            '<div class="order-item-image">' +
                                (item.product_image ? '<img src="/storage/' + item.product_image + '" alt="' + item.product_name + '">' : '<i class="fas fa-tshirt fa-2x text-muted"></i>') +
                            '</div>' +
                            '<div class="order-item-details">' +
                                '<div class="order-item-name">' + (item.product_name || 'Product') + '</div>' +
                                '<div class="order-item-price">₹' + formatNumber(item.price) + '</div>' +
                                '<div class="order-item-quantity">Quantity: ' + item.quantity + '</div>' +
                            '</div>' +
                            '<div class="order-item-total">₹' + formatNumber(item.price * item.quantity) + '</div>' +
                        '</div>';
                    }
                } else {
                    itemsHtml = '<div class="text-muted">No items found</div>';
                }
                document.getElementById('modalOrderItems').innerHTML = itemsHtml;
                
                // SHIPPING ADDRESS - Display directly from order data
                var addressHtml = '<div class="address-card">No address information available</div>';
                if (order.shipping_address) {
                    var addr = order.shipping_address;
                    var addressParts = [];
                    
                    if (addr.name && addr.name !== 'N/A' && addr.name !== '') {
                        addressParts.push('<strong>' + escapeHtml(addr.name) + '</strong>');
                    }
                    if (addr.address && addr.address !== '') {
                        addressParts.push(escapeHtml(addr.address));
                    }
                    if (addr.area && addr.area !== '') {
                        addressParts.push(escapeHtml(addr.area));
                    }
                    if (addr.city && addr.city !== '' && addr.state && addr.state !== '') {
                        addressParts.push(escapeHtml(addr.city) + ', ' + escapeHtml(addr.state));
                    } else if (addr.city && addr.city !== '') {
                        addressParts.push(escapeHtml(addr.city));
                    } else if (addr.state && addr.state !== '') {
                        addressParts.push(escapeHtml(addr.state));
                    }
                    if (addr.pincode && addr.pincode !== '') {
                        addressParts.push('Pincode: ' + escapeHtml(addr.pincode));
                    }
                    if (addr.phone && addr.phone !== 'N/A' && addr.phone !== '') {
                        addressParts.push('Phone: ' + escapeHtml(addr.phone));
                    }
                    
                    if (addressParts.length > 0) {
                        addressHtml = '<div class="address-card">' + addressParts.join('<br>') + '</div>';
                    }
                }
                document.getElementById('modalShippingAddress').innerHTML = addressHtml;
                
                var modal = new bootstrap.Modal(document.getElementById('orderDetailsModal'));
                modal.show();
            } else {
                alert('Error loading order details: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(function(error) {
            console.error('Error:', error);
            document.getElementById('modalShippingAddress').innerHTML = '<div class="address-card">Error loading address</div>';
            alert('Error loading order details');
        });
}

// Apply filters function
function applyFilters() {
    var search = document.getElementById('searchInput').value;
    var paymentStatus = document.getElementById('paymentStatusFilter').value;
    var orderStatus = document.getElementById('orderStatusFilter').value;
    var perPage = document.getElementById('perPageSelect').value;
    
    var url = new URL(window.location.href);
    url.searchParams.set('search', search);
    url.searchParams.set('payment_status', paymentStatus);
    url.searchParams.set('order_status', orderStatus);
    url.searchParams.set('per_page', perPage);
    url.searchParams.set('page', 1);
    window.location.href = url.toString();
}

function resetFilters() {
    var url = new URL(window.location.href);
    url.searchParams.delete('search');
    url.searchParams.delete('payment_status');
    url.searchParams.delete('order_status');
    url.searchParams.delete('per_page');
    url.searchParams.set('page', 1);
    window.location.href = url.toString();
}

function changePerPage() {
    var perPage = document.getElementById('perPageSelect').value;
    var url = new URL(window.location.href);
    url.searchParams.set('per_page', perPage);
    url.searchParams.set('page', 1);
    window.location.href = url.toString();
}

// Initialize event listeners when page loads
document.addEventListener('DOMContentLoaded', function() {
    attachStatusEventListeners();
});
</script>
@endsection