@extends('layouts.admin-layout')

@section('content')
<style>
    /* Dashboard Cards */
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 20px 24px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        transition: all 0.3s ease;
        border: none;
        position: relative;
        overflow: hidden;
        height: 100%;
    }
    
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
    }
    
    .stat-card .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        margin-bottom: 12px;
    }
    
    .stat-card .stat-number {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 4px;
    }
    
    .stat-card .stat-label {
        font-size: 0.85rem;
        color: #64748b;
        font-weight: 500;
    }
    
    .stat-card .stat-change {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 2px 10px;
        border-radius: 20px;
        display: inline-block;
        margin-top: 6px;
    }
    
    .stat-change.positive {
        background: #dcfce7;
        color: #15803d;
    }
    
    .stat-change.negative {
        background: #fee2e2;
        color: #b91c1c;
    }
    
    .stat-change.neutral {
        background: #f1f5f9;
        color: #64748b;
    }
    
    .stat-card .icon-bg {
        position: absolute;
        right: -10px;
        bottom: -10px;
        font-size: 5rem;
        opacity: 0.06;
        color: #1e293b;
    }
    
    /* Icon Colors */
    .icon-purple { background: #ede9fe; color: #7c3aed; }
    .icon-blue { background: #dbeafe; color: #2563eb; }
    .icon-green { background: #dcfce7; color: #16a34a; }
    .icon-orange { background: #fef3c7; color: #d97706; }
    .icon-red { background: #fee2e2; color: #dc2626; }
    .icon-cyan { background: #cffafe; color: #0891b2; }
    .icon-pink { background: #fce7f3; color: #db2777; }
    
    /* Chart Container */
    .chart-container {
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        border: none;
        height: 100%;
    }
    
    .chart-container .chart-title {
        font-size: 1rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 16px;
    }
    
    .chart-container canvas {
        width: 100% !important;
        height: 280px !important;
    }
    
    /* Table Styles */
    .table-dashboard {
        margin-bottom: 0;
    }
    
    .table-dashboard th {
        background: #f8fafc;
        color: #475569;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e2e8f0;
        padding: 12px 16px;
    }
    
    .table-dashboard td {
        padding: 12px 16px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .table-dashboard tr:hover {
        background: #f8fafc;
    }
    
    .table-dashboard .badge-status {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    
    .badge-pending { background: #fef3c7; color: #92400e; }
    .badge-confirmed { background: #dbeafe; color: #1d4ed8; }
    .badge-shipped { background: #e0e7ff; color: #3730a3; }
    .badge-delivered { background: #dcfce7; color: #15803d; }
    .badge-cancelled { background: #fee2e2; color: #b91c1c; }
    .badge-failed { background: #fee2e2; color: #b91c1c; }
    .badge-read { background: #dbeafe; color: #1d4ed8; }
    .badge-replied { background: #dcfce7; color: #15803d; }
    
    /* Dashboard Grid */
    .dashboard-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    
    @media (max-width: 992px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
        }
    }
    
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 25px;
    }
    
    @media (max-width: 768px) {
        .stat-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 480px) {
        .stat-grid {
            grid-template-columns: 1fr;
        }
    }
    
    /* Quick Actions */
    .quick-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }
    
    .quick-action-btn {
        padding: 10px 20px;
        border-radius: 12px;
        border: none;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .quick-action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        color: white;
    }
    
    .btn-primary-custom { background: #3b82f6; color: white; }
    .btn-success-custom { background: #22c55e; color: white; }
    .btn-purple-custom { background: #8b5cf6; color: white; }
    .btn-orange-custom { background: #f59e0b; color: white; }
    .btn-pink-custom { background: #ec4899; color: white; }
</style>

<div class="admin-main-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1" style="font-weight: 700; color: #1e293b;">
                    <i class="fas fa-chart-line me-2" style="color: #3b82f6;"></i>Dashboard
                </h4>
                <small style="color: #64748b;">Welcome back, {{ Auth::user()->name ?? 'Admin' }}!</small>
            </div>
            <div>
                <span style="color: #64748b; font-size: 0.9rem;">
                    <i class="fas fa-calendar-alt me-1"></i> {{ now()->format('d M Y, h:i A') }}
                </span>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="quick-actions">
            <a href="{{ route('admin.products.create') }}" class="quick-action-btn btn-primary-custom">
                <i class="fas fa-plus"></i> Add Product
            </a>
            <a href="{{ route('admin.payments.index') }}" class="quick-action-btn btn-success-custom">
                <i class="fas fa-shopping-bag"></i> View Orders
            </a>
            <a href="{{ route('admin.members') }}" class="quick-action-btn btn-purple-custom">
                <i class="fas fa-users"></i> Manage Members
            </a>
            <a href="{{ route('admin.offers.index') }}" class="quick-action-btn btn-orange-custom">
                <i class="fas fa-tags"></i> Manage Offers
            </a>
            <a href="{{ route('admin.contacts.index') }}" class="quick-action-btn btn-pink-custom">
                <i class="fas fa-envelope"></i> Messages
            </a>
        </div>
        
        <!-- Statistics Cards -->
        <div class="stat-grid">
            <!-- Total Orders -->
            <div class="stat-card">
                <div class="stat-icon icon-blue">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-number">{{ $totalOrders ?? 0 }}</div>
                <div class="stat-label">Total Orders</div>
                <span class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> {{ $ordersGrowth ?? '0' }}%
                </span>
                <div class="icon-bg"><i class="fas fa-shopping-cart"></i></div>
            </div>
            
            <!-- Total Revenue -->
            <div class="stat-card">
                <div class="stat-icon icon-green">
                    <i class="fas fa-rupee-sign"></i>
                </div>
                <div class="stat-number">₹{{ number_format($totalRevenue ?? 0, 2) }}</div>
                <div class="stat-label">Total Revenue</div>
                <span class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> {{ $revenueGrowth ?? '0' }}%
                </span>
                <div class="icon-bg"><i class="fas fa-rupee-sign"></i></div>
            </div>
            
            <!-- Total Products -->
            <div class="stat-card">
                <div class="stat-icon icon-purple">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-number">{{ $totalProducts ?? 0 }}</div>
                <div class="stat-label">Total Products</div>
                <span class="stat-change neutral">
                    <i class="fas fa-minus"></i> {{ $productsGrowth ?? '0' }}%
                </span>
                <div class="icon-bg"><i class="fas fa-box"></i></div>
            </div>
            
            <!-- Total Members (Users) -->
            <div class="stat-card">
                <div class="stat-icon icon-cyan">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-number">{{ $totalMembers ?? 0 }}</div>
                <div class="stat-label">Total Members</div>
                <span class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> {{ $membersGrowth ?? '0' }}%
                </span>
                <div class="icon-bg"><i class="fas fa-users"></i></div>
            </div>
            
            <!-- Pending Orders -->
            <div class="stat-card">
                <div class="stat-icon icon-red">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-number">{{ $pendingOrders ?? 0 }}</div>
                <div class="stat-label">Pending Orders</div>
                <span class="stat-change negative">
                    <i class="fas fa-exclamation-triangle"></i> Needs Attention
                </span>
                <div class="icon-bg"><i class="fas fa-clock"></i></div>
            </div>
            
            <!-- Revenue This Month -->
            <div class="stat-card">
                <div class="stat-icon icon-orange">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-number">₹{{ number_format($monthlyRevenue ?? 0, 2) }}</div>
                <div class="stat-label">Revenue This Month</div>
                <span class="stat-change neutral">
                    <i class="fas fa-calendar-alt"></i> {{ now()->format('M Y') }}
                </span>
                <div class="icon-bg"><i class="fas fa-calendar-check"></i></div>
            </div>
        </div>
        
        <!-- Charts Section -->
        <div class="dashboard-grid mb-4">
            <!-- Revenue Chart -->
            <div class="chart-container">
                <div class="chart-title">
                    <i class="fas fa-chart-bar me-2" style="color: #3b82f6;"></i>
                    Monthly Revenue
                </div>
                <canvas id="revenueChart"></canvas>
            </div>
            
            <!-- Order Status Chart -->
            <div class="chart-container">
                <div class="chart-title">
                    <i class="fas fa-chart-pie me-2" style="color: #8b5cf6;"></i>
                    Order Status Distribution
                </div>
                <canvas id="orderStatusChart"></canvas>
            </div>
        </div>
        
        <!-- Recent Orders & Top Products -->
        <div class="dashboard-grid">
            <!-- Recent Orders -->
            <div class="chart-container">
                <div class="chart-title d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-receipt me-2" style="color: #3b82f6;"></i> Recent Orders</span>
                    <a href="{{ route('admin.payments.index') }}" style="font-size: 0.8rem; color: #3b82f6; text-decoration: none;">
                        View All <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-dashboard">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders ?? [] as $order)
                            <tr>
                                <td><strong>#{{ $order->order_number }}</strong></td>
                                <td>{{ $order->user->name ?? 'N/A' }}</td>
                                <td>₹{{ number_format($order->total_amount, 2) }}</td>
                                <td>
                                    <span class="badge-status badge-{{ strtolower($order->order_status) }}">
                                        {{ $order->order_status }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">No recent orders</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Top Selling Products -->
            <div class="chart-container">
                <div class="chart-title d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-fire me-2" style="color: #f59e0b;"></i> Top Selling Products</span>
                    <a href="{{ route('admin.products.index') }}" style="font-size: 0.8rem; color: #3b82f6; text-decoration: none;">
                        View All <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-dashboard">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Sold</th>
                                <th>Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topProducts ?? [] as $product)
                            <tr>
                                <td>{{ $product->name ?? 'N/A' }}</td>
                                <td>{{ $product->total_sold ?? 0 }}</td>
                                <td>₹{{ number_format($product->total_revenue ?? 0, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">No product data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Recent Members (Users) & Contact Messages -->
        <div class="dashboard-grid mt-4">
            <!-- Recent Members (from users table) -->
            <div class="chart-container">
                <div class="chart-title d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-user-plus me-2" style="color: #10b981;"></i> Recent Members</span>
                    <a href="{{ route('admin.members') }}" style="font-size: 0.8rem; color: #3b82f6; text-decoration: none;">
                        View All <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-dashboard">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentMembers ?? [] as $member)
                            <tr>
                                <td><strong>{{ $member->name }}</strong></td>
                                <td>{{ $member->email }}</td>
                                <td>{{ $member->phone ?? 'N/A' }}</td>
                                <td>{{ $member->created_at->format('d M Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">No users found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Recent Contact Messages -->
            <div class="chart-container">
                <div class="chart-title d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-envelope me-2" style="color: #f59e0b;"></i> Recent Messages</span>
                    <a href="{{ route('admin.contacts.index') }}" style="font-size: 0.8rem; color: #3b82f6; text-decoration: none;">
                        View All <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-dashboard">
                        <thead>
                            <tr>
                                <th>From</th>
                                <th>Subject</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentMessages ?? [] as $message)
                            <tr>
                                <td><strong>{{ $message->name }}</strong></td>
                                <td>{{ Str::limit($message->subject, 25) }}</td>
                                <td>
                                    <span class="badge-status badge-{{ strtolower($message->status) }}">
                                        {{ $message->status }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">No messages</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyLabels ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']) !!},
            datasets: [{
                label: 'Revenue (₹)',
                data: {!! json_encode($monthlyRevenueData ?? [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]) !!},
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderColor: '#3b82f6',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#3b82f6',
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
                    ticks: {
                        callback: function(value) {
                            return '₹' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
    
    // Order Status Chart
    const statusCtx = document.getElementById('orderStatusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($statusLabels ?? ['Pending', 'Confirmed', 'Shipped', 'Delivered', 'Cancelled', 'Failed']) !!},
            datasets: [{
                data: {!! json_encode($statusData ?? [0, 0, 0, 0, 0, 0]) !!},
                backgroundColor: ['#f59e0b', '#3b82f6', '#8b5cf6', '#22c55e', '#ef4444', '#64748b'],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                }
            },
            cutout: '65%'
        }
    });
});
</script>
@endsection