@extends('layouts.admin-layout')

@section('content')
<style>
    .offer-stats {
        background: #fff;
        border-radius: 8px;
        padding: 15px 20px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
    .stat-box {
        text-align: center;
        padding: 10px;
        border-right: 1px solid #dee2e6;
    }
    .stat-box:last-child {
        border-right: none;
    }
    .stat-box .stat-number {
        font-size: 24px;
        font-weight: 700;
        color: #0d6efd;
    }
    .stat-box .stat-label {
        font-size: 12px;
        color: #6c757d;
        margin-top: 4px;
    }
    .stat-box .stat-number.active {
        color: #28a745;
    }
    .stat-box .stat-number.inactive {
        color: #dc3545;
    }
    .stat-box .stat-number.scheduled {
        color: #ffc107;
    }
    .stat-box .stat-number.expired {
        color: #6c757d;
    }
    .filter-section {
        background: #fff;
        padding: 15px 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
    .table-offers {
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .table-offers thead {
        background: #f8f9fa;
    }
    .table-offers th {
        font-weight: 600;
        font-size: 13px;
        color: #495057;
        border-bottom: 2px solid #dee2e6;
        padding: 12px 15px;
        vertical-align: middle;
    }
    .table-offers td {
        padding: 12px 15px;
        vertical-align: middle;
        font-size: 13px;
    }
    .table-offers tbody tr:hover {
        background: #f8f9fa;
    }
    .offer-badge {
        display: inline-block;
        padding: 3px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    .offer-badge.active {
        background: #d4edda;
        color: #155724;
    }
    .offer-badge.inactive {
        background: #f8d7da;
        color: #721c24;
    }
    .offer-badge.scheduled {
        background: #fff3cd;
        color: #856404;
    }
    .offer-badge.expired {
        background: #e2e3e5;
        color: #383d41;
    }
    .offer-code {
        font-weight: 700;
        color: #0d6efd;
        background: #e7f1ff;
        padding: 2px 10px;
        border-radius: 4px;
        font-size: 12px;
        letter-spacing: 0.5px;
    }
    .discount-badge {
        background: #dc3545;
        color: white;
        padding: 3px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 700;
        display: inline-block;
    }
    .type-badge {
        display: inline-block;
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 10px;
        font-weight: 600;
    }
    .type-badge.product { background: #cfe2ff; color: #084298; }
    .type-badge.category { background: #d1e7dd; color: #0f5132; }
    .type-badge.brand { background: #f8d7da; color: #721c24; }
    .type-badge.cart { background: #fff3cd; color: #856404; }
    .type-badge.bogo { background: #e2d9f3; color: #4b0082; }
    .type-badge.bundle { background: #d6d8db; color: #1e2124; }
    .type-badge.flash_sale { background: #fce4ec; color: #c62828; }
    .type-badge.new_user { background: #e8f5e9; color: #2e7d32; }
    .type-badge.festival { background: #fff8e1; color: #f57f17; }
    .progress-wrapper {
        width: 100px;
    }
    .progress-wrapper .progress {
        height: 5px;
        border-radius: 3px;
    }
    .progress-wrapper .progress-text {
        font-size: 10px;
        color: #6c757d;
        margin-top: 2px;
    }
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
    .empty-state i {
        font-size: 60px;
        color: #dee2e6;
        margin-bottom: 20px;
    }
    .empty-state h5 {
        color: #495057;
    }
    .btn-action {
        width: 30px;
        height: 30px;
        padding: 0;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        margin: 0 2px;
        border: 1px solid transparent;
        transition: all 0.3s;
    }
    .btn-action:hover {
        transform: scale(1.1);
    }
    .btn-action .fas {
        font-size: 12px;
    }
    .table-responsive {
        overflow-x: auto;
    }
    
    /* Toast Notification */
    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
    }
    .toast {
        padding: 12px 20px;
        border-radius: 8px;
        color: #fff;
        margin-bottom: 10px;
        min-width: 250px;
        animation: slideIn 0.5s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .toast-success { background: #28a745; }
    .toast-error { background: #dc3545; }
    .toast-info { background: #17a2b8; }
    .toast-warning { background: #ffc107; color: #333; }
    
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    @media (max-width: 768px) {
        .stat-box {
            border-right: none;
            border-bottom: 1px solid #dee2e6;
            padding: 10px 0;
        }
        .stat-box:last-child {
            border-bottom: none;
        }
        .table-offers td, .table-offers th {
            padding: 8px 10px;
            font-size: 12px;
        }
        .discount-badge {
            font-size: 11px;
            padding: 2px 8px;
        }
        .offer-code {
            font-size: 10px;
            padding: 1px 6px;
        }
        .btn-action {
            width: 25px;
            height: 25px;
            font-size: 10px;
        }
        .btn-action .fas {
            font-size: 10px;
        }
    }
</style>

<div class="container">
    <div class="row" style="margin-left:200px;">
        <div class="col-12">

            <!-- Toast Notification Container -->
            <div class="toast-container" id="toastContainer"></div>

            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4><i class="fas fa-tags text-primary me-2"></i> Offers & Coupons</h4>
                <a href="{{ route('admin.offers.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Create New Offer
                </a>
            </div>

            <!-- Statistics -->
            <div class="offer-stats" id="statsContainer">
                <div class="row">
                    <div class="col-md-3 col-6">
                        <div class="stat-box">
                            <div class="stat-number" id="statTotal">0</div>
                            <div class="stat-label">Total Offers</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-box">
                            <div class="stat-number active" id="statActive">0</div>
                            <div class="stat-label">Active</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-box">
                            <div class="stat-number inactive" id="statInactive">0</div>
                            <div class="stat-label">Inactive</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-box">
                            <div class="stat-number scheduled" id="statScheduled">0</div>
                            <div class="stat-label">Scheduled</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <div class="row align-items-center">
                    <div class="col-md-3 mb-2 mb-md-0">
                        <input type="text" id="searchOffers" class="form-control" placeholder="Search offers..." onkeyup="filterOffers()">
                    </div>
                    <div class="col-md-3 mb-2 mb-md-0">
                        <select id="filterStatus" class="form-select" onchange="filterOffers()">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="scheduled">Scheduled</option>
                            <option value="expired">Expired</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2 mb-md-0">
                        <select id="filterType" class="form-select" onchange="filterOffers()">
                            <option value="">All Types</option>
                            <option value="product">Product Offer</option>
                            <option value="category">Category Offer</option>
                            <option value="brand">Brand Offer</option>
                            <option value="cart">Cart Offer</option>
                            <option value="bogo">BOGO Offer</option>
                            <option value="bundle">Bundle Offer</option>
                            <option value="flash_sale">Flash Sale</option>
                            <option value="new_user">New User</option>
                            <option value="festival">Festival Offer</option>
                        </select>
                    </div>
                    <div class="col-md-3 text-end">
                        <button class="btn btn-danger btn-sm" onclick="bulkDelete()" id="bulkDeleteBtn" style="display:none;">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                        <button class="btn btn-success btn-sm" onclick="bulkStatus('active')" id="bulkActiveBtn" style="display:none;">
                            <i class="fas fa-check"></i> Activate
                        </button>
                        <button class="btn btn-warning btn-sm" onclick="bulkStatus('inactive')" id="bulkInactiveBtn" style="display:none;">
                            <i class="fas fa-pause"></i> Deactivate
                        </button>
                    </div>
                </div>
            </div>

            <!-- Bulk Action Checkbox -->
            <div class="mb-2">
                <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                <label for="selectAll" class="ms-1">Select All</label>
                <span class="text-muted ms-3" id="selectedCount">0 selected</span>
            </div>

            <!-- Offers Table -->
            <div class="table-responsive">
                <table class="table table-offers">
                    <thead>
                        <tr>
                            <th style="width:30px;">
                                <input type="checkbox" id="selectAllTable" onchange="toggleSelectAll()">
                            </th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Discount</th>
                            <th>Status</th>
                            <th>Usage</th>
                            <th>Valid Dates</th>
                            <th style="width:180px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="offersTableBody">
                        @if($offers->count() > 0)
                            @foreach($offers as $offer)
                                <tr class="offer-item" 
                                    data-id="{{ $offer->id }}"
                                    data-status="{{ $offer->status }}" 
                                    data-type="{{ $offer->offer_type }}"
                                    data-name="{{ strtolower($offer->offer_name) }}"
                                    data-code="{{ strtolower($offer->offer_code) }}">
                                    <td>
                                        <input type="checkbox" class="offer-checkbox" value="{{ $offer->id }}" onchange="updateSelectedCount()">
                                    </td>
                                    <td>
                                        <span class="offer-code">{{ $offer->offer_code }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ $offer->offer_name }}</strong>
                                        @if($offer->offer_description)
                                            <br><small class="text-muted">{{ Str::limit($offer->offer_description, 30) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="type-badge {{ $offer->offer_type }}">{{ $offer->getTypeLabel() }}</span>
                                    </td>
                                    <td>
                                        @if($offer->discount_type == 'percentage')
                                            <span class="discount-badge">{{ $offer->discount_value }}%</span>
                                        @elseif($offer->discount_type == 'fixed')
                                            <span class="discount-badge">₹{{ number_format($offer->discount_value, 2) }}</span>
                                        @elseif($offer->discount_type == 'buy_x_get_y')
                                            <span class="discount-badge">Buy {{ $offer->buy_quantity }} Get {{ $offer->get_quantity }} Free</span>
                                        @elseif($offer->discount_type == 'free_shipping')
                                            <span class="discount-badge"><i class="fas fa-truck"></i> Free</span>
                                        @else
                                            <span class="discount-badge">{{ ucfirst($offer->discount_type) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="offer-badge {{ $offer->status }}">
                                            {{ ucfirst($offer->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($offer->usage_limit_total)
                                            <div class="progress-wrapper">
                                                @php
                                                    $usagePercent = $offer->usage_limit_total > 0 ? ($offer->usage_count / $offer->usage_limit_total) * 100 : 0;
                                                    $usagePercent = min($usagePercent, 100);
                                                    $colorClass = $usagePercent >= 90 ? 'bg-danger' : ($usagePercent >= 70 ? 'bg-warning' : 'bg-info');
                                                @endphp
                                                <div class="progress">
                                                    <div class="progress-bar {{ $colorClass }}" role="progressbar" style="width: {{ $usagePercent }}%;"></div>
                                                </div>
                                                <div class="progress-text">
                                                    {{ $offer->usage_count }} / {{ $offer->usage_limit_total }}
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted">∞</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>
                                            {{ \Carbon\Carbon::parse($offer->start_date)->format('d M Y') }}<br>
                                            <span class="text-muted">to</span><br>
                                            {{ \Carbon\Carbon::parse($offer->end_date)->format('d M Y') }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            <!-- Edit Button -->
                                            <a href="{{ route('admin.offers.edit', $offer->id) }}" class="btn btn-sm btn-outline-primary btn-action" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <!-- Duplicate Button -->
                                            <button class="btn btn-sm btn-outline-primary btn-action" onclick="duplicateOffer({{ $offer->id }})" title="Duplicate">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                            <!-- Toggle Status Button -->
                                            <button class="btn btn-sm btn-outline-{{ $offer->status == 'active' ? 'warning' : 'success' }} btn-action" 
                                                    onclick="toggleOffer({{ $offer->id }})" title="{{ $offer->status == 'active' ? 'Deactivate' : 'Activate' }}">
                                                <i class="fas fa-{{ $offer->status == 'active' ? 'pause' : 'play' }}"></i>
                                            </button>
                                            <!-- Delete Button -->
                                            <button class="btn btn-sm btn-outline-danger btn-action" onclick="deleteOffer({{ $offer->id }})" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="9">
                                    <div class="empty-state">
                                        <i class="fas fa-tags"></i>
                                        <h5>No Offers Found</h5>
                                        <p class="text-muted">Create your first offer to attract more customers.</p>
                                        <a href="{{ route('admin.offers.create') }}" class="btn btn-primary mt-2">
                                            <i class="fas fa-plus me-1"></i> Create Offer
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($offers->count() > 0)
                <div class="d-flex justify-content-center mt-3">
                    {{ $offers->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    // ========== CSRF Token ==========
    var csrfToken = '{{ csrf_token() }}';

    // ========== TOAST NOTIFICATION ==========
    function showToast(message, type) {
        if (typeof type === 'undefined') type = 'success';
        var container = document.getElementById('toastContainer');
        if (!container) return;
        var toast = document.createElement('div');
        toast.className = 'toast toast-' + type;
        
        var icon = '';
        if (type === 'success') icon = '<i class="fas fa-check-circle me-2"></i>';
        else if (type === 'error') icon = '<i class="fas fa-exclamation-circle me-2"></i>';
        else if (type === 'warning') icon = '<i class="fas fa-exclamation-triangle me-2"></i>';
        else icon = '<i class="fas fa-info-circle me-2"></i>';
        
        toast.innerHTML = icon + message;
        container.appendChild(toast);
        
        setTimeout(function() {
            toast.style.opacity = '0';
            toast.style.transition = 'opacity 0.5s';
            setTimeout(function() {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 500);
        }, 3000);
    }

    // ========== STATS LOADING ==========
    function loadStats() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '{{ route("admin.offers.get-stats") }}', true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        document.getElementById('statTotal').textContent = response.total;
                        document.getElementById('statActive').textContent = response.active;
                        document.getElementById('statInactive').textContent = response.inactive;
                        document.getElementById('statScheduled').textContent = response.scheduled;
                    }
                } catch (e) {
                    console.log('Error parsing stats:', e);
                }
            }
        };
        xhr.onerror = function() {
            console.log('Error loading stats');
        };
        xhr.send();
    }

    // ========== FILTER OFFERS ==========
    function filterOffers() {
        var searchTerm = document.getElementById('searchOffers').value.toLowerCase();
        var statusFilter = document.getElementById('filterStatus').value;
        var typeFilter = document.getElementById('filterType').value;
        
        var rows = document.querySelectorAll('.offer-item');
        var visibleCount = 0;
        
        rows.forEach(function(row) {
            var status = row.dataset.status;
            var type = row.dataset.type;
            var name = row.dataset.name;
            var code = row.dataset.code;
            
            var matchStatus = !statusFilter || status === statusFilter;
            var matchType = !typeFilter || type === typeFilter;
            var matchSearch = !searchTerm || name.includes(searchTerm) || code.includes(searchTerm);
            
            if (matchStatus && matchType && matchSearch) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
    }

    // ========== SELECT ALL ==========
    function toggleSelectAll() {
        var selectAll = document.getElementById('selectAll');
        var checkboxes = document.querySelectorAll('.offer-checkbox:not(:disabled)');
        checkboxes.forEach(function(cb) {
            cb.checked = selectAll.checked;
        });
        updateSelectedCount();
    }

    function updateSelectedCount() {
        var checkboxes = document.querySelectorAll('.offer-checkbox:checked');
        var count = checkboxes.length;
        document.getElementById('selectedCount').textContent = count + ' selected';
        
        var bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
        var bulkActiveBtn = document.getElementById('bulkActiveBtn');
        var bulkInactiveBtn = document.getElementById('bulkInactiveBtn');
        
        if (count > 0) {
            bulkDeleteBtn.style.display = 'inline-block';
            bulkActiveBtn.style.display = 'inline-block';
            bulkInactiveBtn.style.display = 'inline-block';
        } else {
            bulkDeleteBtn.style.display = 'none';
            bulkActiveBtn.style.display = 'none';
            bulkInactiveBtn.style.display = 'none';
        }
    }

    // ========== BULK ACTIONS ==========
    function getSelectedIds() {
        var checkboxes = document.querySelectorAll('.offer-checkbox:checked');
        var ids = [];
        checkboxes.forEach(function(cb) {
            ids.push(parseInt(cb.value));
        });
        return ids;
    }

    function bulkDelete() {
        var ids = getSelectedIds();
        if (ids.length === 0) {
            showToast('Please select at least one offer to delete.', 'warning');
            return;
        }
        
        if (!confirm('Are you sure you want to delete ' + ids.length + ' offer(s)? This action cannot be undone!')) {
            return;
        }
        
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '{{ route("admin.offers.bulk-delete") }}', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        showToast(response.message, 'success');
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        showToast('Error: ' + response.message, 'error');
                    }
                } catch (e) {
                    showToast('An error occurred. Please try again.', 'error');
                }
            } else {
                showToast('An error occurred. Please try again.', 'error');
            }
        };
        xhr.onerror = function() {
            showToast('An error occurred. Please try again.', 'error');
        };
        xhr.send(JSON.stringify({
            ids: ids,
            _token: csrfToken
        }));
    }

    function bulkStatus(status) {
        var ids = getSelectedIds();
        if (ids.length === 0) {
            showToast('Please select at least one offer.', 'warning');
            return;
        }
        
        var statusText = status === 'active' ? 'activate' : 'deactivate';
        if (!confirm('Are you sure you want to ' + statusText + ' ' + ids.length + ' offer(s)?')) {
            return;
        }
        
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '{{ route("admin.offers.bulk-status") }}', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        showToast(response.message, 'success');
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        showToast('Error: ' + response.message, 'error');
                    }
                } catch (e) {
                    showToast('An error occurred. Please try again.', 'error');
                }
            } else {
                showToast('An error occurred. Please try again.', 'error');
            }
        };
        xhr.onerror = function() {
            showToast('An error occurred. Please try again.', 'error');
        };
        xhr.send(JSON.stringify({
            ids: ids,
            status: status,
            _token: csrfToken
        }));
    }

    // ========== OFFER ACTIONS ==========
    function toggleOffer(id) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/admin/offers/' + id + '/toggle', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        showToast(response.message, 'success');
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        showToast('Error: ' + response.message, 'error');
                    }
                } catch (e) {
                    showToast('An error occurred. Please try again.', 'error');
                }
            } else {
                showToast('An error occurred. Please try again.', 'error');
            }
        };
        xhr.onerror = function() {
            showToast('An error occurred. Please try again.', 'error');
        };
        xhr.send(JSON.stringify({
            _token: csrfToken
        }));
    }

    function duplicateOffer(id) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/admin/offers/' + id + '/duplicate', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        showToast('Offer duplicated successfully!', 'success');
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        showToast('Error: ' + response.message, 'error');
                    }
                } catch (e) {
                    showToast('An error occurred. Please try again.', 'error');
                }
            } else {
                showToast('An error occurred. Please try again.', 'error');
            }
        };
        xhr.onerror = function() {
            showToast('An error occurred. Please try again.', 'error');
        };
        xhr.send(JSON.stringify({
            _token: csrfToken
        }));
    }

    function deleteOffer(id) {
        if (!confirm('Are you sure you want to delete this offer? This action cannot be undone!')) {
            return;
        }
        
        var xhr = new XMLHttpRequest();
        xhr.open('DELETE', '/admin/offers/' + id, true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        showToast(response.message, 'success');
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        showToast('Error: ' + response.message, 'error');
                    }
                } catch (e) {
                    showToast('An error occurred. Please try again.', 'error');
                }
            } else {
                showToast('An error occurred. Please try again.', 'error');
            }
        };
        xhr.onerror = function() {
            showToast('An error occurred. Please try again.', 'error');
        };
        xhr.send(JSON.stringify({
            _token: csrfToken
        }));
    }

    // ========== INITIALIZATION ==========
    document.addEventListener('DOMContentLoaded', function() {
        loadStats();
        updateSelectedCount();
        
        // Update stats every 60 seconds
        setInterval(loadStats, 60000);
        
        // Search on Enter key
        var searchInput = document.getElementById('searchOffers');
        if (searchInput) {
            searchInput.addEventListener('keyup', function(e) {
                if (e.key === 'Enter') {
                    filterOffers();
                }
            });
        }
    });
</script>
@endsection