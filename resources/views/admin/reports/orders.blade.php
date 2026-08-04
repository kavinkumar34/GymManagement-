@extends('layouts.admin-layout')

@section('content')
<style>
    .report-container {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
        padding: 24px;
        margin-bottom: 20px;
    }
    
    .report-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 20px;
    }
    
    .report-header h4 {
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .report-header h4 i {
        color: #4a9eff;
    }
    
    .filter-form {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        align-items: flex-end;
        background: #f8fafc;
        padding: 15px 20px;
        border-radius: 12px;
        border: 1px solid #e9ecef;
        margin-bottom: 20px;
    }
    
    .filter-form .form-group {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    
    .filter-form .form-group label {
        font-size: 11px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .filter-form .form-control {
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        padding: 6px 12px;
        font-size: 13px;
        height: 36px;
        min-width: 140px;
        background: white;
    }
    
    .filter-form .form-control:focus {
        border-color: #4a9eff;
        box-shadow: 0 0 0 3px rgba(74, 158, 255, 0.12);
        outline: none;
    }
    
    .filter-form .btn-filter {
        background: #4a9eff;
        color: white;
        border: none;
        padding: 6px 20px;
        border-radius: 8px;
        font-weight: 500;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.3s;
        height: 36px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .filter-form .btn-filter:hover {
        background: #2b7be0;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(74, 158, 255, 0.3);
    }
    
    .filter-form .btn-reset {
        background: #e9ecef;
        color: #6c757d;
        border: none;
        padding: 6px 20px;
        border-radius: 8px;
        font-weight: 500;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.3s;
        height: 36px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .filter-form .btn-reset:hover {
        background: #dee2e6;
    }
    
    /* ===== STAT CARDS ===== */
    .stat-grid-report {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 15px;
        margin-bottom: 20px;
    }
    
    @media (max-width: 1200px) {
        .stat-grid-report {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    
    @media (max-width: 768px) {
        .stat-grid-report {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 480px) {
        .stat-grid-report {
            grid-template-columns: 1fr;
        }
    }
    
    .stat-card-report {
        background: white;
        border-radius: 12px;
        padding: 15px 18px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        transition: all 0.3s;
    }
    
    .stat-card-report:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    }
    
    .stat-card-report .stat-label {
        font-size: 11px;
        color: #64748b;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .stat-card-report .stat-value {
        font-size: 22px;
        font-weight: 700;
        color: #0f172a;
        margin-top: 4px;
    }
    
    .stat-card-report .stat-sub {
        font-size: 12px;
        color: #94a3b8;
        margin-top: 2px;
    }
    
    .stat-card-report .stat-icon {
        float: right;
        font-size: 28px;
        opacity: 0.15;
    }
    
    .stat-card-report .stat-value.green { color: #16a34a; }
    .stat-card-report .stat-value.blue { color: #2563eb; }
    .stat-card-report .stat-value.purple { color: #7c3aed; }
    .stat-card-report .stat-value.orange { color: #d97706; }
    .stat-card-report .stat-value.red { color: #dc2626; }
    .stat-card-report .stat-value.teal { color: #0d9488; }
    
    /* ===== TABLE ===== */
    .table-report {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    
    .table-report thead th {
        background: #f8fafc;
        color: #475569;
        font-weight: 600;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 10px 14px;
        border-bottom: 2px solid #e2e8f0;
        position: sticky;
        top: 0;
        z-index: 2;
        text-align: left;
    }
    
    .table-report tbody td {
        padding: 10px 14px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
    }
    
    .table-report tbody tr:hover {
        background: #f8fafc;
    }
    
    .table-report .badge-status {
        padding: 3px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
    }
    
    .badge-pending { background: #fef3c7; color: #92400e; }
    .badge-confirmed { background: #dbeafe; color: #1d4ed8; }
    .badge-shipped { background: #e0e7ff; color: #3730a3; }
    .badge-delivered { background: #dcfce7; color: #15803d; }
    .badge-cancelled { background: #fee2e2; color: #b91c1c; }
    .badge-failed { background: #fee2e2; color: #b91c1c; }
    
    /* ===== CHART ===== */
    .chart-container-report {
        background: white;
        border-radius: 12px;
        padding: 20px;
        border: 1px solid #f1f5f9;
        height: 100%;
    }
    
    .chart-container-report .chart-title {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .chart-container-report canvas {
        width: 100% !important;
        height: 250px !important;
        max-height: 250px;
    }
    
    .report-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }
    
    @media (max-width: 992px) {
        .report-grid {
            grid-template-columns: 1fr;
        }
    }
    
    /* ===== STATUS SUMMARY ===== */
    .status-summary {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 15px;
    }
    
    .status-summary .status-item {
        display: flex;
        align-items: center;
        gap: 6px;
        background: #f8fafc;
        padding: 4px 14px 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        border: 1px solid #e9ecef;
    }
    
    .status-summary .status-item .dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
    }
    
    .status-summary .status-item .count {
        font-weight: 700;
        color: #0f172a;
    }
    
    .dot-pending { background: #f59e0b; }
    .dot-confirmed { background: #3b82f6; }
    .dot-shipped { background: #8b5cf6; }
    .dot-delivered { background: #22c55e; }
    .dot-cancelled { background: #ef4444; }
    .dot-failed { background: #64748b; }
    
    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .filter-form {
            flex-direction: column;
            align-items: stretch;
        }
        .filter-form .form-control {
            min-width: 100%;
        }
        .report-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .stat-grid-report {
            grid-template-columns: repeat(2, 1fr);
        }
        .table-report {
            font-size: 11px;
        }
        .table-report thead th,
        .table-report tbody td {
            padding: 6px 8px;
        }
    }
    
    @media (max-width: 480px) {
        .stat-grid-report {
            grid-template-columns: 1fr;
        }
        .report-container {
            padding: 12px;
        }
    }
</style>

<div class="admin-main-content">
    <div class="container-fluid">
        
        <!-- ===== REPORT HEADER ===== -->
        <div class="report-container">
            <div class="report-header">
                <h4><i class="fas fa-chart-pie"></i> Orders Report</h4>
                <div>
                    <a href="{{ route('admin.reports.export') }}" class="btn btn-success btn-sm" style="background:#22c55e; color:white; border:none; padding:7px 18px; border-radius:8px; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                        <i class="fas fa-file-export"></i> Export
                    </a>
                </div>
            </div>
            
            <!-- ===== FILTERS ===== -->
            <form method="GET" action="{{ route('admin.reports.orders') }}" class="filter-form">
                <div class="form-group">
                    <label>Filter Type</label>
                    <select name="filter_type" class="form-control" onchange="this.form.submit()">
                        <option value="daily" {{ $filterType == 'daily' ? 'selected' : '' }}>Today</option>
                        <option value="weekly" {{ $filterType == 'weekly' ? 'selected' : '' }}>This Week</option>
                        <option value="monthly" {{ $filterType == 'monthly' ? 'selected' : '' }}>This Month</option>
                        <option value="yearly" {{ $filterType == 'yearly' ? 'selected' : '' }}>This Year</option>
                        <option value="custom" {{ $filterType == 'custom' ? 'selected' : '' }}>Custom</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Start Date</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                </div>
                
                <div class="form-group">
                    <label>End Date</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                </div>
                
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="">All Status</option>
                        <option value="Pending" {{ $status == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Confirmed" {{ $status == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="Shipped" {{ $status == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="Delivered" {{ $status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="Cancelled" {{ $status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="Failed" {{ $status == 'Failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                </div>
                
                <button type="submit" class="btn-filter">
                    <i class="fas fa-search"></i> Apply
                </button>
                
                <a href="{{ route('admin.reports.orders') }}" class="btn-reset">
                    <i class="fas fa-undo"></i> Reset
                </a>
            </form>
        </div>
        
        <!-- ===== STATISTICS CARDS ===== -->
        <div class="stat-grid-report">
            <div class="stat-card-report">
                <div class="stat-icon"><i class="fas fa-shopping-cart"></i></div>
                <div class="stat-label">Total Orders</div>
                <div class="stat-value blue">{{ $totalOrdersCount ?? 0 }}</div>
                <div class="stat-sub">All orders</div>
            </div>
            
            <div class="stat-card-report">
                <div class="stat-icon"><i class="fas fa-rupee-sign"></i></div>
                <div class="stat-label">Product Revenue</div>
                <div class="stat-value green">₹{{ number_format($totalProductRevenue ?? 0, 0) }}</div>
                <div class="stat-sub">final_price × quantity</div>
            </div>
            
            <div class="stat-card-report">
                <div class="stat-icon"><i class="fas fa-tag"></i></div>
                <div class="stat-label">Actual Price</div>
                <div class="stat-value orange">₹{{ number_format($totalActualPrice ?? 0, 0) }}</div>
                <div class="stat-sub">products.price × quantity</div>
            </div>
            
            <div class="stat-card-report">
                <div class="stat-icon"><i class="fas fa-truck"></i></div>
                <div class="stat-label">Shipping Revenue</div>
                <div class="stat-value purple">₹{{ number_format($totalShipping ?? 0, 0) }}</div>
                <div class="stat-sub">Total shipping charges</div>
            </div>
            
            <div class="stat-card-report">
                <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
                <div class="stat-label">Total Profit</div>
                <div class="stat-value teal">₹{{ number_format($totalProfit ?? 0, 0) }}</div>
                <div class="stat-sub">Product Revenue - Actual Price</div>
            </div>
            
            <div class="stat-card-report">
                <div class="stat-icon"><i class="fas fa-coins"></i></div>
                <div class="stat-label">Profit + Shipping</div>
                <div class="stat-value green">₹{{ number_format($totalWithShipping ?? 0, 0) }}</div>
                <div class="stat-sub">Total including shipping</div>
            </div>
        </div>
        
        <!-- ===== STATUS SUMMARY ===== -->
        <div class="report-container">
            <div class="status-summary">
                @foreach($statusCounts as $key => $count)
                <span class="status-item">
                    <span class="dot dot-{{ strtolower($key) }}"></span>
                    {{ $key }}: <span class="count">{{ $count }}</span>
                </span>
                @endforeach
            </div>
        </div>
        
        <!-- ===== CHARTS ===== -->
        <div class="report-grid">
            <div class="chart-container-report">
                <div class="chart-title">
                    <i class="fas fa-chart-bar" style="color: #3b82f6;"></i>
                    Monthly Revenue
                </div>
                <canvas id="revenueChart"></canvas>
            </div>
            
            <div class="chart-container-report">
                <div class="chart-title">
                    <i class="fas fa-chart-line" style="color: #16a34a;"></i>
                    Monthly Profit
                </div>
                <canvas id="profitChart"></canvas>
            </div>
        </div>
        
        <!-- ===== TOP PRODUCTS ===== -->
        <div class="report-container">
            <h6 style="font-weight:600; color:#1e293b; margin-bottom:12px;">
                <i class="fas fa-fire" style="color:#f59e0b;"></i> Top Selling Products
            </h6>
            <div style="overflow-x:auto;">
                <table class="table table-report">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Total Sold</th>
                            <th>Total Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topProducts as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $product->name }}</strong></td>
                            <td>{{ $product->total_sold }}</td>
                            <td>₹{{ number_format($product->total_revenue, 2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3">No product data available</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- ===== ORDERS TABLE ===== -->
        <div class="report-container">
            <h6 style="font-weight:600; color:#1e293b; margin-bottom:12px;">
                <i class="fas fa-list" style="color:#4a9eff;"></i> Orders
                <span class="badge bg-primary ms-2" style="font-size:11px; background:#4a9eff !important;">{{ $orders->total() }}</span>
            </h6>
            
            <div style="overflow-x:auto;">
                <table class="table table-report">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Product Revenue</th>
                            <th>Actual Price</th>
                            <th>Profit</th>
                            <th>Shipping</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td><strong>#{{ $order->order_number }}</strong></td>
                            <td>{{ $order->user->name ?? 'N/A' }}</td>
                            <td>
                                @foreach($order->items as $item)
                                    <span style="font-size:11px; display:block; border-bottom:1px solid #f1f5f9; padding:2px 0;">
                                        {{ $item->product_name ?? 'Product' }} (x{{ $item->quantity }})
                                    </span>
                                @endforeach
                            </td>
                            <td style="color:#2563eb; font-weight:600;">₹{{ number_format($order->product_revenue ?? 0, 2) }}</td>
                            <td style="color:#d97706; font-weight:600;">₹{{ number_format($order->actual_price ?? 0, 2) }}</td>
                            <td style="color: #16a34a; font-weight:700;">₹{{ number_format($order->profit ?? 0, 2) }}</td>
                            <td style="color:#7c3aed; font-weight:600;">₹{{ number_format($order->shipping_charge ?? 0, 2) }}</td>
                            <td><strong>₹{{ number_format($order->total_with_shipping ?? 0, 2) }}</strong></td>
                            <td>
                                <span class="badge-status badge-{{ strtolower($order->order_status) }}">
                                    {{ $order->order_status }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">
                                <i class="fas fa-inbox" style="font-size:24px; display:block; margin-bottom:8px;"></i>
                                No orders found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- ===== PAGINATION ===== -->
            <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; margin-top:15px; padding-top:15px; border-top:1px solid #f1f5f9;">
                <div style="font-size:13px; color:#64748b;">
                    Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }} entries
                </div>
                <div>
                    {{ $orders->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
        
    </div>
</div>

<!-- ===== CHART.JS ===== -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ===== REVENUE CHART =====
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($monthlyLabels) !!},
            datasets: [{
                label: 'Revenue (₹)',
                data: {!! json_encode($monthlyRevenueData) !!},
                backgroundColor: 'rgba(59, 130, 246, 0.7)',
                borderColor: '#3b82f6',
                borderWidth: 2,
                borderRadius: 4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    },
                    ticks: {
                        callback: function(value) {
                            return '₹' + value.toLocaleString();
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
    
    // ===== PROFIT CHART =====
    const profitCtx = document.getElementById('profitChart').getContext('2d');
    new Chart(profitCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyLabels) !!},
            datasets: [{
                label: 'Profit (₹)',
                data: {!! json_encode($monthlyProfitData) !!},
                backgroundColor: 'rgba(22, 163, 74, 0.1)',
                borderColor: '#16a34a',
                borderWidth: 2.5,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#16a34a',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    },
                    ticks: {
                        callback: function(value) {
                            return '₹' + value.toLocaleString();
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
});
</script>
@endsection