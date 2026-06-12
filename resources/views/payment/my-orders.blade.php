{{-- resources/views/payment/my-orders.blade.php --}}
@extends('layouts.app')

@section('content')
<style>
    /* Order Card Styles */
    .order-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 20px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .order-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    .order-header {
        padding: 15px 20px;
        background: #f8fafc;
        border-bottom: 1px solid #eef2f6;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }
    .order-number {
        font-weight: 700;
        font-size: 1rem;
        color: #1e293b;
    }
    .order-date {
        font-size: 0.8rem;
        color: #64748b;
    }
    .order-body {
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    .order-info {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    .order-total {
        font-size: 1.1rem;
        font-weight: 700;
        color: #0f172a;
    }
    .order-items-count {
        font-size: 0.8rem;
        color: #64748b;
    }
    .order-status {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    .order-status.Pending { background: #fef9c3; color: #854d0e; }
    .order-status.Confirmed { background: #dbeafe; color: #1d4ed8; }
    .order-status.Shipped { background: #e0e7ff; color: #3730a3; }
    .order-status.Delivered { background: #dcfce7; color: #15803d; }
    .order-status.Cancelled { background: #fee2e2; color: #b91c1c; }
    .order-status.Failed { background: #fee2e2; color: #b91c1c; }
    
    .payment-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    .payment-paid { background: #dcfce7; color: #15803d; }
    .payment-pending { background: #fef9c3; color: #854d0e; }
    .payment-failed { background: #fee2e2; color: #b91c1c; }
    
    .order-actions {
        display: flex;
        gap: 10px;
    }
    .btn-view-details {
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 40px;
        font-size: 0.8rem;
        cursor: pointer;
        transition: all 0.3s;
    }
    .btn-view-details:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59,130,246,0.3);
    }
    .btn-view-details:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }
    
    /* Cancel Modal Styles */
    .cancel-modal .modal-content {
        border-radius: 20px;
        overflow: hidden;
    }
    .cancel-modal .modal-header {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        border-bottom: none;
    }
    .reason-option {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        margin-bottom: 8px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .reason-option:hover {
        border-color: #ef4444;
        background: #fef2f2;
    }
    .reason-option.selected {
        border-color: #ef4444;
        background: #fef2f2;
    }
    .reason-option input[type="radio"] {
        margin-right: 12px;
        accent-color: #ef4444;
    }
    .reason-option label {
        flex: 1;
        cursor: pointer;
        margin: 0;
        font-weight: 500;
    }
    .cancel-comment {
        width: 100%;
        padding: 12px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        resize: vertical;
        font-size: 0.9rem;
    }
    .cancel-comment:focus {
        outline: none;
        border-color: #ef4444;
    }
    
    /* Order Details Modal Styles */
    .order-details-modal .modal-dialog {
        max-width: 900px;
    }
    .order-details-modal .modal-content {
        border-radius: 20px;
        overflow: hidden;
    }
    .modal-header-custom {
        background: linear-gradient(135deg, #1e293b, #2d3a4b);
        color: white;
        padding: 20px;
        border-bottom: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .order-status-steps {
        display: flex;
        justify-content: space-between;
        padding: 20px;
        background: #f8fafc;
        border-bottom: 1px solid #eef2f6;
    }
    .status-step {
        text-align: center;
        flex: 1;
        position: relative;
    }
    .status-step .step-icon {
        width: 40px;
        height: 40px;
        background: #e2e8f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 8px;
        color: #64748b;
        font-size: 1rem;
    }
    .status-step.active .step-icon {
        background: #3b82f6;
        color: white;
    }
    .status-step.completed .step-icon {
        background: #10b981;
        color: white;
    }
    .status-step .step-label {
        font-size: 0.7rem;
        font-weight: 500;
        color: #64748b;
    }
    .status-step.active .step-label {
        color: #3b82f6;
        font-weight: 600;
    }
    .status-step.completed .step-label {
        color: #10b981;
    }
    
    .detail-section {
        padding: 20px;
        border-bottom: 1px solid #eef2f6;
    }
    .detail-section:last-child {
        border-bottom: none;
    }
    .section-title {
        font-size: 1rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .section-title i {
        color: #3b82f6;
    }
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }
    .info-item {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    .info-label {
        font-size: 0.7rem;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .info-value {
        font-size: 0.9rem;
        font-weight: 500;
        color: #1e293b;
    }
    .address-block {
        background: #f8fafc;
        padding: 15px;
        border-radius: 12px;
        margin-bottom: 15px;
        line-height: 1.6;
    }
    .order-item-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    .order-item-card {
        display: flex;
        gap: 15px;
        padding: 15px;
        background: #f8fafc;
        border-radius: 12px;
    }
    .order-item-image {
        width: 80px;
        height: 80px;
        background: white;
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
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 5px;
    }
    .order-item-price {
        font-weight: 700;
        color: #0f172a;
    }
    .order-item-quantity {
        font-size: 0.8rem;
        color: #64748b;
    }
    .order-item-total {
        text-align: right;
        font-weight: 700;
        color: #0f172a;
    }
    .payment-summary {
        background: #f8fafc;
        padding: 15px;
        border-radius: 12px;
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
    }
    .summary-total {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-top: 2px solid #e2e8f0;
        font-weight: 800;
        font-size: 1.1rem;
        color: #0f172a;
    }
    .action-buttons {
        display: flex;
        gap: 10px;
        margin-top: 15px;
    }
    .btn-cancel-order {
        background: #ef4444;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 40px;
        font-size: 0.8rem;
        cursor: pointer;
    }
    .btn-contact-support {
        background: #64748b;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 40px;
        font-size: 0.8rem;
        cursor: pointer;
    }
</style>

<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fas fa-shopping-bag"></i> My Orders</h4>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(isset($orders) && $orders->count() > 0)
                @foreach($orders as $order)
                <div class="order-card">
                    <div class="order-header">
                        <div>
                            <span class="order-number">Order #{{ $order->order_number }}</span>
                            <div class="order-date">{{ \Carbon\Carbon::parse($order->created_at)->format('j F Y \a\t h:i A') }}</div>
                        </div>
                        <div class="order-actions">
                            <button class="btn-view-details" onclick="viewOrderDetails({{ $order->id }}, this)">
                                <i class="fas fa-eye"></i> View Details
                            </button>
                        </div>
                    </div>
                    <div class="order-body">
                        <div class="order-info">
                            <div class="order-total">Total Amount: ₹{{ number_format($order->total_amount, 2) }}</div>
                            <div class="order-items-count">{{ $order->items->count() }} item(s) • 
                                @if($order->payment_status == 'SUCCESS')
                                    <span class="payment-badge payment-paid"><i class="fas fa-check-circle"></i> PAID</span>
                                @elseif($order->payment_status == 'FAILED')
                                    <span class="payment-badge payment-failed"><i class="fas fa-times-circle"></i> FAILED</span>
                                @else
                                    <span class="payment-badge payment-pending"><i class="fas fa-clock"></i> PENDING</span>
                                @endif
                            </div>
                        </div>
                        <div class="order-status {{ $order->order_status }}">{{ strtoupper($order->order_status) }}</div>
                    </div>
                </div>
                @endforeach
                
                <div class="mt-3">
                    {{ $orders->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-shopping-bag fa-4x text-muted mb-3"></i>
                    <h4>No Orders Found</h4>
                    <p>You haven't placed any orders yet.</p>
                    <a href="{{ url('/') }}" class="btn btn-primary">Start Shopping</a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Order Details Modal -->
<div class="modal fade order-details-modal" id="orderDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header-custom">
                <h5 class="mb-0">Order Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <!-- Order Status Steps -->
                <div class="order-status-steps" id="statusSteps">
                    <!-- Dynamic status steps will be injected -->
                </div>
                
                <!-- Order Info Section -->
                <div class="detail-section">
                    <div class="section-title">
                        <i class="fas fa-info-circle"></i> Order Information
                    </div>
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Order Number</span>
                            <span class="info-value" id="modalOrderNumber">-</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Placed On</span>
                            <span class="info-value" id="modalOrderDate">-</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Transaction ID</span>
                            <span class="info-value" id="modalTransactionId">-</span>
                        </div>
                    </div>
                </div>
                
                <!-- Customer Details Section -->
                <div class="detail-section">
                    <div class="section-title">
                        <i class="fas fa-user-circle"></i> Customer Details
                    </div>
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Name</span>
                            <span class="info-value" id="modalCustomerName">-</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Email</span>
                            <span class="info-value" id="modalCustomerEmail">-</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Phone</span>
                            <span class="info-value" id="modalCustomerPhone">-</span>
                        </div>
                    </div>
                </div>
                
                <!-- Shipping Address Section -->
                <div class="detail-section">
                    <div class="section-title">
                        <i class="fas fa-map-marker-alt"></i> Shipping Address
                    </div>
                    <div id="modalShippingAddress" class="address-block">
                        No address information available
                    </div>
                </div>
                
                <!-- Order Items Section -->
                <div class="detail-section">
                    <div class="section-title">
                        <i class="fas fa-box"></i> Order Items
                    </div>
                    <div id="modalOrderItems" class="order-item-list"></div>
                </div>
                
                <!-- Payment Summary Section -->
                <div class="detail-section">
                    <div class="section-title">
                        <i class="fas fa-credit-card"></i> Payment Summary
                    </div>
                    <div class="payment-summary" id="modalPaymentSummary"></div>
                    
                    <div class="action-buttons" id="modalActions">
                        <button class="btn-cancel-order" onclick="openCancelModalFromDetails()">Cancel Order</button>
                        <button class="btn-contact-support" onclick="contactSupport()">Contact Support</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Order Modal -->
<div class="modal fade cancel-modal" id="cancelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-times-circle me-2"></i> Cancel Order</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="cancelOrderId">
                <p class="text-muted mb-3">Please select a reason for cancellation:</p>
                
                <div id="cancelReasons">
                    <div class="reason-option" onclick="selectReason(this, 'Changed my mind')">
                        <input type="radio" name="cancel_reason" value="Changed my mind">
                        <label>Changed my mind</label>
                    </div>
                    <div class="reason-option" onclick="selectReason(this, 'Delivery takes too long')">
                        <input type="radio" name="cancel_reason" value="Delivery takes too long">
                        <label>Delivery takes too long</label>
                    </div>
                    <div class="reason-option" onclick="selectReason(this, 'Wrong product ordered')">
                        <input type="radio" name="cancel_reason" value="Wrong product ordered">
                        <label>Wrong product ordered</label>
                    </div>
                    <div class="reason-option" onclick="selectReason(this, 'Found better price elsewhere')">
                        <input type="radio" name="cancel_reason" value="Found better price elsewhere">
                        <label>Found better price elsewhere</label>
                    </div>
                    <div class="reason-option" onclick="selectReason(this, 'Product quality issue')">
                        <input type="radio" name="cancel_reason" value="Product quality issue">
                        <label>Product quality issue</label>
                    </div>
                    <div class="reason-option" onclick="selectReason(this, 'Size/Fit issue')">
                        <input type="radio" name="cancel_reason" value="Size/Fit issue">
                        <label>Size/Fit issue</label>
                    </div>
                    <div class="reason-option" onclick="selectReason(this, 'Other')">
                        <input type="radio" name="cancel_reason" value="Other">
                        <label>Other</label>
                    </div>
                </div>
                
                <div class="mt-3">
                    <label class="form-label fw-bold">Additional Comments (Optional)</label>
                    <textarea id="cancelComment" class="cancel-comment" rows="3" placeholder="Please provide any additional details about your cancellation request..."></textarea>
                </div>
                
                <div class="alert alert-warning mt-3">
                    <i class="fas fa-info-circle"></i> Once cancelled, your order will be processed for refund as per our policy.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" onclick="submitCancellation()">Submit Cancellation</button>
            </div>
        </div>
    </div>
</div>

<script>
// CSRF Token
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
let currentCancelOrderId = null;
let currentOrderForCancel = null;

// Select reason function
function selectReason(element, reason) {
    document.querySelectorAll('.reason-option').forEach(opt => {
        opt.classList.remove('selected');
        const radio = opt.querySelector('input[type="radio"]');
        if (radio) radio.checked = false;
    });
    
    element.classList.add('selected');
    const radio = element.querySelector('input[type="radio"]');
    if (radio) {
        radio.checked = true;
    }
}

// Open Cancel Modal from details page
function openCancelModalFromDetails() {
    if (currentOrderForCancel) {
        openCancelModal(currentOrderForCancel);
    } else {
        alert('No order selected for cancellation');
    }
}

// Open Cancel Modal
function openCancelModal(orderId) {
    currentCancelOrderId = orderId;
    document.getElementById('cancelOrderId').value = orderId;
    
    document.querySelectorAll('.reason-option').forEach(opt => {
        opt.classList.remove('selected');
        const radio = opt.querySelector('input[type="radio"]');
        if (radio) radio.checked = false;
    });
    document.getElementById('cancelComment').value = '';
    
    const modal = new bootstrap.Modal(document.getElementById('cancelModal'));
    modal.show();
}

// Submit Cancellation
async function submitCancellation() {
    const orderId = document.getElementById('cancelOrderId').value;
    const selectedReason = document.querySelector('input[name="cancel_reason"]:checked');
    const comment = document.getElementById('cancelComment').value;
    
    if (!selectedReason) {
        alert('Please select a reason for cancellation');
        return;
    }
    
    const submitBtn = document.querySelector('#cancelModal .btn-danger');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
    submitBtn.disabled = true;
    
    try {
        const response = await fetch('/cancel-order', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                order_id: orderId,
                cancellation_reason: selectedReason.value,
                cancellation_comment: comment
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            const cancelModal = bootstrap.Modal.getInstance(document.getElementById('cancelModal'));
            const orderModal = bootstrap.Modal.getInstance(document.getElementById('orderDetailsModal'));
            if (cancelModal) cancelModal.hide();
            if (orderModal) orderModal.hide();
            
            alert('Your cancellation request has been submitted successfully!');
            location.reload();
        } else {
            alert(data.message || 'Error submitting cancellation request');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Network error. Please try again.');
    } finally {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }
}

// View order details using API
async function viewOrderDetails(orderId, button) {
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
    button.disabled = true;
    
    try {
        const response = await fetch(`/api/order-details/${orderId}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        });
        
        const data = await response.json();
        
        if (data.success && data.order) {
            currentOrderForCancel = orderId;
            renderModalWithOrderData(data.order);
            const modal = new bootstrap.Modal(document.getElementById('orderDetailsModal'));
            modal.show();
        } else {
            alert(data.message || 'Error loading order details');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error loading order details. Please try again.');
    } finally {
        button.innerHTML = originalText;
        button.disabled = false;
    }
}

// Render modal with order data
function renderModalWithOrderData(order) {
    // Status Steps
    const statusSteps = ['Pending', 'Confirmed', 'Shipped', 'Delivered'];
    const currentStatus = order.order_status;
    const currentIndex = statusSteps.indexOf(currentStatus);
    
    let stepsHtml = '';
    statusSteps.forEach((step, index) => {
        let stepClass = '';
        let stepIcon = '';
        
        if (index < currentIndex) {
            stepClass = 'completed';
            stepIcon = '<i class="fas fa-check"></i>';
        } else if (index === currentIndex) {
            stepClass = 'active';
            stepIcon = '<i class="fas fa-circle"></i>';
        } else {
            stepIcon = '<i class="far fa-circle"></i>';
        }
        
        stepsHtml += `
            <div class="status-step ${stepClass}">
                <div class="step-icon">${stepIcon}</div>
                <div class="step-label">${step.toUpperCase()}</div>
            </div>
        `;
    });
    document.getElementById('statusSteps').innerHTML = stepsHtml;
    
    // Order Information
    document.getElementById('modalOrderNumber').innerText = order.order_number;
    document.getElementById('modalOrderDate').innerText = new Date(order.created_at).toLocaleDateString('en-IN', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    });
    document.getElementById('modalTransactionId').innerText = order.transaction_id || 'N/A';
    
    // Customer Details
    document.getElementById('modalCustomerName').innerText = order.user?.name || 'N/A';
    document.getElementById('modalCustomerEmail').innerText = order.user?.email || 'N/A';
    document.getElementById('modalCustomerPhone').innerText = order.user?.phone || 'N/A';
    
    // Shipping Address - Fetch from user_addresses table data
    let shippingHtml = '<div class="address-block">No address information available</div>';
    if (order.shipping_address) {
        let addr = order.shipping_address;
        let addressLines = [];
        
        if (addr.name && addr.name !== 'N/A' && addr.name !== '') {
            addressLines.push('<strong>' + escapeHtml(addr.name) + '</strong>');
        }
        if (addr.address && addr.address !== '') {
            addressLines.push(escapeHtml(addr.address));
        }
        if (addr.area && addr.area !== '') {
            addressLines.push(escapeHtml(addr.area));
        }
        if (addr.city && addr.city !== '' && addr.state && addr.state !== '') {
            addressLines.push(escapeHtml(addr.city) + ', ' + escapeHtml(addr.state));
        } else if (addr.city && addr.city !== '') {
            addressLines.push(escapeHtml(addr.city));
        } else if (addr.state && addr.state !== '') {
            addressLines.push(escapeHtml(addr.state));
        }
        if (addr.pincode && addr.pincode !== '') {
            addressLines.push('Pincode: ' + escapeHtml(addr.pincode));
        }
        if (addr.phone && addr.phone !== 'N/A' && addr.phone !== '') {
            addressLines.push('Phone: ' + escapeHtml(addr.phone));
        }
        
        if (addressLines.length > 0) {
            shippingHtml = '<div class="address-block">' + addressLines.join('<br>') + '</div>';
        }
    }
    document.getElementById('modalShippingAddress').innerHTML = shippingHtml;
    
    // Order Items
    let itemsHtml = '';
    let subtotal = 0;
    
    if (order.items && order.items.length > 0) {
        order.items.forEach(function(item) {
            var itemTotal = item.price * item.quantity;
            subtotal += itemTotal;
            
            itemsHtml += `
                <div class="order-item-card">
                    <div class="order-item-image">
                        ${item.product_image ? `<img src="/storage/${item.product_image}" alt="${escapeHtml(item.product_name)}">` : '<i class="fas fa-tshirt fa-2x text-muted"></i>'}
                    </div>
                    <div class="order-item-details">
                        <div class="order-item-name">${escapeHtml(item.product_name)}</div>
                        <div class="order-item-price">₹${formatNumber(item.price)}</div>
                        <div class="order-item-quantity">Quantity: ${item.quantity}</div>
                    </div>
                    <div class="order-item-total">₹${formatNumber(itemTotal)}</div>
                </div>
            `;
        });
    } else {
        itemsHtml = '<div class="text-muted">No items found</div>';
    }
    document.getElementById('modalOrderItems').innerHTML = itemsHtml;
    
    // Payment Summary
    const shippingCost = order.shipping_cost || 0;
    const total = order.total_amount;
    const paymentMethod = order.payment_method || 'Unknown';
    const paymentStatus = order.payment_status;
    const paymentStatusText = paymentStatus === 'SUCCESS' ? 'PAID' : (paymentStatus === 'FAILED' ? 'FAILED' : 'PENDING');
    const paymentStatusClass = paymentStatus === 'SUCCESS' ? 'payment-paid' : (paymentStatus === 'FAILED' ? 'payment-failed' : 'payment-pending');
    
    let paymentMethodDisplay = '';
    if (paymentMethod === 'cod') {
        paymentMethodDisplay = 'Cash on Delivery';
    } else if (paymentMethod === 'online' || paymentMethod === 'card' || paymentMethod === 'PayU') {
        paymentMethodDisplay = 'Online Payment (Card)';
    } else {
        paymentMethodDisplay = paymentMethod || 'Unknown';
    }
    
    const summaryHtml = `
        <div class="summary-row">
            <span>Subtotal</span>
            <span>₹${formatNumber(subtotal)}</span>
        </div>
        <div class="summary-row">
            <span>Shipping</span>
            <span>₹${formatNumber(shippingCost)}</span>
        </div>
        <div class="summary-total">
            <span>Total</span>
            <span>₹${formatNumber(total)}</span>
        </div>
        <div class="summary-row mt-2">
            <span>${paymentMethodDisplay}</span>
            <span class="payment-badge ${paymentStatusClass}">${paymentStatusText}</span>
        </div>
    `;
    document.getElementById('modalPaymentSummary').innerHTML = summaryHtml;
}

// Contact Support
function contactSupport() {
    window.location.href = '{{ route("contact") }}';
}

function formatNumber(num) {
    return parseFloat(num).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}
</script>
@endsection