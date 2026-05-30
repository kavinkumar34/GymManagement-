@extends('layouts.admin-layout')

@section('content')
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
                                <th width="5%"><a href="#" class="text-white text-decoration-none" onclick="sortBy('id')">ID ↕</a></th>
                                <th width="20%"><a href="#" class="text-white text-decoration-none" onclick="sortBy('order_number')">Order Number ↕</a></th>
                                <th width="15%"><a href="#" class="text-white text-decoration-none" onclick="sortBy('customer')">Customer ↕</a></th>
                                <th width="10%"><a href="#" class="text-white text-decoration-none" onclick="sortBy('total_amount')">Amount ↕</a></th>
                                <th width="12%">Payment Status</th>
                                <th width="12%">Order Status</th>
                                <th width="10%"><a href="#" class="text-white text-decoration-none" onclick="sortBy('created_at')">Date ↕</a></th>
                                <th width="16%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->user->name ?? 'N/A' }}</td>
                                <td>₹{{ number_format($order->total_amount, 2) }}</td>
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
                                    @if($order->order_status == 'Confirmed')
                                        <span class="badge bg-primary">Confirmed</span>
                                    @elseif($order->order_status == 'Shipped')
                                        <span class="badge bg-info">Shipped</span>
                                    @elseif($order->order_status == 'Delivered')
                                        <span class="badge bg-success">Delivered</span>
                                    @elseif($order->order_status == 'Cancelled')
                                        <span class="badge bg-danger">Cancelled</span>
                                    @elseif($order->order_status == 'Failed')
                                        <span class="badge bg-danger">Failed</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $order->order_status }}</span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.payments.show', $order->id) }}" class="btn btn-sm btn-info" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.payments.edit', $order->id) }}" class="btn btn-sm btn-warning" title="Edit Status">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger" onclick="deleteOrder({{ $order->id }})" title="Delete Order">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">No orders found</td>
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

<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
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
    let sortBy = document.getElementById('sortBy') ? document.getElementById('sortBy').value : 'id';
    let sortOrder = document.getElementById('sortOrder') ? document.getElementById('sortOrder').value : 'desc';
    
    let url = new URL(window.location.href);
    url.searchParams.set('search', search);
    url.searchParams.set('payment_status', paymentStatus);
    url.searchParams.set('order_status', orderStatus);
    url.searchParams.set('per_page', perPage);
    url.searchParams.set('sort_by', sortBy);
    url.searchParams.set('sort_order', sortOrder);
    url.searchParams.set('page', 1);
    
    window.location.href = url.toString();
}

function resetFilters() {
    let url = new URL(window.location.href);
    url.searchParams.delete('search');
    url.searchParams.delete('payment_status');
    url.searchParams.delete('order_status');
    url.searchParams.delete('per_page');
    url.searchParams.delete('sort_by');
    url.searchParams.delete('sort_order');
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

let currentSortBy = '{{ request("sort_by", "id") }}';
let currentSortOrder = '{{ request("sort_order", "desc") }}';

function sortBy(column) {
    let sortBy = column;
    let sortOrder = 'asc';
    
    if (currentSortBy === column && currentSortOrder === 'asc') {
        sortOrder = 'desc';
    }
    
    let url = new URL(window.location.href);
    url.searchParams.set('sort_by', sortBy);
    url.searchParams.set('sort_order', sortOrder);
    url.searchParams.set('page', 1);
    
    window.location.href = url.toString();
}

// Add hidden inputs for sorting state
document.addEventListener('DOMContentLoaded', function() {
    let hiddenDiv = document.createElement('div');
    hiddenDiv.style.display = 'none';
    hiddenDiv.innerHTML = '<input type="hidden" id="sortBy" value="' + currentSortBy + '"><input type="hidden" id="sortOrder" value="' + currentSortOrder + '">';
    document.body.appendChild(hiddenDiv);
});
</script>

<style>
    .pagination {
        margin-bottom: 0;
    }
    .table th, .table td {
        vertical-align: middle;
    }
    .btn-sm {
        margin: 0 2px;
    }
</style>
@endsection