@extends('layouts.admin-layout')

@section('content')
<style>
    /* ===== DASHBOARD STAT CARDS ===== */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 20px;
        margin-bottom: 25px;
    }

    @media (max-width: 1200px) {
        .stat-grid {
            grid-template-columns: repeat(3, 1fr);
        }
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

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 18px 20px 18px 22px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
        transition: all 0.3s ease;
        border: 1px solid #f1f5f9;
        position: relative;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
        min-height: 120px;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.08);
        border-color: transparent;
        text-decoration: none;
        color: inherit;
    }

    /* Card Top Section - Icon and Content */
    .stat-card-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 2px;
        flex: 1;
    }

    .stat-card .stat-icon-wrapper {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .stat-card .stat-right {
        text-align: right;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        min-width: 0;
        flex-shrink: 1;
    }

    .stat-card .stat-number {
        font-size: 1.6rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.2;
        white-space: nowrap;
    }

    .stat-card .stat-label {
        font-size: 0.78rem;
        color: #64748b;
        font-weight: 500;
        margin-top: 1px;
        white-space: nowrap;
        letter-spacing: 0.2px;
    }

    .stat-card .stat-change {
        font-size: 0.65rem;
        font-weight: 600;
        padding: 2px 10px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        margin-top: 4px;
        align-self: flex-start;
        white-space: nowrap;
        flex-shrink: 0;
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

    /* Icon Colors */
    .icon-purple { background: #ede9fe; color: #7c3aed; }
    .icon-blue { background: #dbeafe; color: #2563eb; }
    .icon-green { background: #dcfce7; color: #16a34a; }
    .icon-orange { background: #fef3c7; color: #d97706; }
    .icon-red { background: #fee2e2; color: #dc2626; }
    .icon-cyan { background: #cffafe; color: #0891b2; }
    .icon-pink { background: #fce7f3; color: #db2777; }
    .icon-indigo { background: #e0e7ff; color: #4f46e5; }
    .icon-teal { background: #ccfbf1; color: #0d9488; }

    /* Card Bottom Decoration */
    .stat-card .stat-decoration {
        position: absolute;
        right: -20px;
        bottom: -20px;
        font-size: 5rem;
        opacity: 0.04;
        color: #1e293b;
        pointer-events: none;
    }

    /* ===== CHART CONTAINERS ===== */
    .chart-container {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
        height: 100%;
        transition: all 0.3s ease;
    }

    .chart-container:hover {
        box-shadow: 0 8px 30px rgba(0,0,0,0.06);
    }

    .chart-container .chart-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .chart-container canvas {
        width: 100% !important;
        height: 280px !important;
        max-height: 280px;
    }

    /* ===== DASHBOARD GRID ===== */
    .dashboard-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    @media (max-width: 992px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
        }
    }

    /* ===== TABLE STYLES ===== */
    .table-dashboard {
        margin-bottom: 0;
        font-size: 0.85rem;
    }

    .table-dashboard th {
        background: #f8fafc;
        color: #475569;
        font-weight: 600;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e2e8f0;
        padding: 10px 14px;
        position: sticky;
        top: 0;
        z-index: 2;
    }

    .table-dashboard td {
        padding: 10px 14px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
    }

    .table-dashboard tr:hover {
        background: #f8fafc;
    }

    .table-dashboard .badge-status {
        padding: 3px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        display: inline-block;
    }

    .badge-pending { background: #fef3c7; color: #92400e; }
    .badge-confirmed { background: #dbeafe; color: #1d4ed8; }
    .badge-shipped { background: #e0e7ff; color: #3730a3; }
    .badge-delivered { background: #dcfce7; color: #15803d; }
    .badge-cancelled { background: #fee2e2; color: #b91c1c; }
    .badge-failed { background: #fee2e2; color: #b91c1c; }
    .badge-read { background: #dbeafe; color: #1d4ed8; }
    .badge-replied { background: #dcfce7; color: #15803d; }
    .badge-new { background: #fef3c7; color: #92400e; }

    /* ===== QUICK ACTIONS ===== */
    .quick-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 24px;
    }

    .quick-action-btn {
        padding: 10px 22px;
        border-radius: 12px;
        border: none;
        font-weight: 600;
        font-size: 0.82rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 1px solid transparent;
    }

    .quick-action-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        color: white !important;
        text-decoration: none;
    }

    .quick-action-btn i {
        font-size: 0.9rem;
    }

    .btn-primary-custom { background: #3b82f6; color: white; }
    .btn-primary-custom:hover { background: #2563eb; color: white; }

    .btn-success-custom { background: #22c55e; color: white; }
    .btn-success-custom:hover { background: #16a34a; color: white; }

    .btn-purple-custom { background: #8b5cf6; color: white; }
    .btn-purple-custom:hover { background: #7c3aed; color: white; }

    .btn-orange-custom { background: #f59e0b; color: white; }
    .btn-orange-custom:hover { background: #d97706; color: white; }

    .btn-pink-custom { background: #ec4899; color: white; }
    .btn-pink-custom:hover { background: #db2777; color: white; }

    /* ===== PAGE HEADER ===== */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .page-header h4 {
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .page-header .header-date {
        color: #64748b;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 6px;
        background: #f8fafc;
        padding: 6px 14px;
        border-radius: 20px;
    }

    /* ===== SCROLLABLE TABLE CONTAINER ===== */
    .table-scroll {
        max-height: 300px;
        overflow-y: auto;
    }

    .table-scroll::-webkit-scrollbar {
        width: 4px;
    }

    .table-scroll::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 4px;
    }

    .table-scroll::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }

    .table-scroll::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* ===== WELCOME BANNER ===== */
    .welcome-banner {
        background: linear-gradient(135deg, #1e293b 0%, #2d3a4b 100%);
        border-radius: 16px;
        padding: 24px 30px;
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }

    .welcome-banner h4 {
        color: white;
        margin: 0;
        font-weight: 600;
    }

    .welcome-banner p {
        color: #94a3b8;
        margin: 4px 0 0 0;
        font-size: 0.9rem;
    }

    .welcome-banner .welcome-stats {
        display: flex;
        gap: 24px;
        align-items: center;
    }

    .welcome-banner .welcome-stat-item {
        text-align: center;
    }

    .welcome-banner .welcome-stat-item .number {
        color: white;
        font-size: 1.3rem;
        font-weight: 700;
    }

    .welcome-banner .welcome-stat-item .label {
        color: #94a3b8;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    @media (max-width: 768px) {
        .welcome-banner {
            flex-direction: column;
            text-align: center;
        }
        .welcome-banner .welcome-stats {
            flex-wrap: wrap;
            justify-content: center;
        }
    }

    /* ===== STAT CARD CLICK CURSOR ===== */
    .stat-card-clickable {
        cursor: pointer;
        text-decoration: none;
        color: inherit;
    }

    .stat-card-clickable:hover {
        text-decoration: none;
        color: inherit;
    }

    .stat-card .stat-bottom-row {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        margin-top: 2px;
        flex-shrink: 0;
        min-height: 26px;
    }

    /* ===== RESPONSIVE FIXES ===== */
    @media (max-width: 992px) {
        .stat-card .stat-number {
            font-size: 1.4rem;
        }
        .stat-card .stat-label {
            font-size: 0.72rem;
        }
        .stat-card .stat-change {
            font-size: 0.6rem;
            padding: 1px 8px;
        }
    }

    @media (max-width: 576px) {
        .stat-card {
            padding: 14px 16px 14px 18px;
            min-height: 100px;
        }
        .stat-card .stat-icon-wrapper {
            width: 38px;
            height: 38px;
            font-size: 1rem;
        }
        .stat-card .stat-number {
            font-size: 1.2rem;
        }
        .stat-card .stat-label {
            font-size: 0.68rem;
        }
        .stat-card .stat-change {
            font-size: 0.55rem;
            padding: 1px 6px;
        }
    }
</style>

<div class="admin-main-content">
    <div class="container-fluid">
        <!-- ===== WELCOME BANNER ===== -->
        <div class="welcome-banner">
            <div>
                <h4><i class="fas fa-chart-line me-2"></i> Welcome back, {{ Auth::user()->name ?? 'Admin' }}!</h4>
                <p>Here's what's happening with your store today.</p>
            </div>
            <div class="welcome-stats">
                <div class="welcome-stat-item">
                    <div class="number">{{ $totalOrders ?? 0 }}</div>
                    <div class="label">Orders</div>
                </div>
                <div class="welcome-stat-item">
                    <div class="number">₹{{ number_format($totalRevenue ?? 0, 0) }}</div>
                    <div class="label">Revenue</div>
                </div>
                <div class="welcome-stat-item">
                    <div class="number">{{ $totalMembers ?? 0 }}</div>
                    <div class="label">Users</div>
                </div>
                <div class="welcome-stat-item">
                    <div class="number">{{ $pendingOrders ?? 0 }}</div>
                    <div class="label">Pending</div>
                </div>
            </div>
        </div>

        <!-- ===== QUICK ACTIONS ===== -->
        <div class="quick-actions">
            <a href="{{ route('admin.products.create') }}" class="quick-action-btn btn-primary-custom">
                <i class="fas fa-plus-circle"></i> Add Product
            </a>
            <a href="{{ route('admin.payments.index') }}" class="quick-action-btn btn-success-custom">
                <i class="fas fa-shopping-bag"></i> View Orders
            </a>
            <a href="{{ route('admin.offers.index') }}" class="quick-action-btn btn-orange-custom">
                <i class="fas fa-tags"></i> Manage Offers
            </a>
            <a href="{{ route('admin.contacts.index') }}" class="quick-action-btn btn-pink-custom">
                <i class="fas fa-envelope"></i> Messages
            </a>
            <a href="{{ route('admin.products.index') }}" class="quick-action-btn btn-purple-custom">
                <i class="fas fa-box"></i> Products
            </a>
        </div>

        <!-- ===== STATISTICS CARDS - CLICKABLE ===== -->
        <div class="stat-grid">
            <!-- Total Orders -->
            <a href="{{ route('admin.payments.index') }}" class="stat-card stat-card-clickable">
                <div class="stat-card-top">
                    <div>
                        <div class="stat-icon-wrapper icon-blue">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                    </div>
                    <div class="stat-right">
                        <div class="stat-number">{{ $totalOrders ?? 0 }}</div>
                        <div class="stat-label">Total Orders</div>
                    </div>
                </div>
                <div class="stat-bottom-row">
                    <span class="stat-change positive">
                        <i class="fas fa-arrow-up"></i> {{ $ordersGrowth ?? '0' }}%
                    </span>
                </div>
            </a>

            <!-- Total Revenue -->
            <a href="{{ route('admin.reports.orders') }}" class="stat-card stat-card-clickable">
                <div class="stat-card-top">
                    <div>
                        <div class="stat-icon-wrapper icon-green">
                            <i class="fas fa-rupee-sign"></i>
                        </div>
                    </div>
                    <div class="stat-right">
                        <div class="stat-number">₹{{ number_format($totalRevenue ?? 0, 0) }}</div>
                        <div class="stat-label">Total Revenue</div>
                    </div>
                </div>
                <div class="stat-bottom-row">
                    <span class="stat-change positive">
                        <i class="fas fa-arrow-up"></i> {{ $revenueGrowth ?? '0' }}%
                    </span>
                </div>
            </a>

            <!-- Total Products -->
            <a href="{{ route('admin.products.index') }}" class="stat-card stat-card-clickable">
                <div class="stat-card-top">
                    <div>
                        <div class="stat-icon-wrapper icon-purple">
                            <i class="fas fa-box"></i>
                        </div>
                    </div>
                    <div class="stat-right">
                        <div class="stat-number">{{ $totalProducts ?? 0 }}</div>
                        <div class="stat-label">Total Products</div>
                    </div>
                </div>
                <div class="stat-bottom-row">
                    <span class="stat-change neutral">
                        <i class="fas fa-minus"></i> {{ $productsGrowth ?? '0' }}%
                    </span>
                </div>
            </a>

            <!-- Total Users -->
            <a href="{{ route('admin.users.index') }}" class="stat-card stat-card-clickable">
                <div class="stat-card-top">
                    <div>
                        <div class="stat-icon-wrapper icon-cyan">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="stat-right">
                        <div class="stat-number">{{ $totalMembers ?? 0 }}</div>
                        <div class="stat-label">Total Users</div>
                    </div>
                </div>
                <div class="stat-bottom-row">
                    <span class="stat-change positive">
                        <i class="fas fa-arrow-up"></i> {{ $membersGrowth ?? '0' }}%
                    </span>
                </div>
            </a>

            <!-- Pending Orders -->
            <a href="{{ route('admin.payments.index') }}" class="stat-card stat-card-clickable">
                <div class="stat-card-top">
                    <div>
                        <div class="stat-icon-wrapper icon-red">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                    <div class="stat-right">
                        <div class="stat-number">{{ $pendingOrders ?? 0 }}</div>
                        <div class="stat-label">Pending Orders</div>
                    </div>
                </div>
                <div class="stat-bottom-row">
                    <span class="stat-change negative">
                        <i class="fas fa-exclamation-triangle"></i> Needs Attention
                    </span>
                </div>
            </a>

            <!-- Revenue This Month -->
            <a href="{{ route('admin.reports.orders') }}" class="stat-card stat-card-clickable">
                <div class="stat-card-top">
                    <div>
                        <div class="stat-icon-wrapper icon-orange">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                    </div>
                    <div class="stat-right">
                        <div class="stat-number">₹{{ number_format($monthlyRevenue ?? 0, 0) }}</div>
                        <div class="stat-label">Revenue This Month</div>
                    </div>
                </div>
                <div class="stat-bottom-row">
                    <span class="stat-change neutral">
                        <i class="fas fa-calendar-alt"></i> {{ now()->format('M Y') }}
                    </span>
                </div>
            </a>
        </div>

        <!-- ===== CHARTS SECTION ===== -->
        <div class="dashboard-grid">
            <!-- Revenue Chart -->
            <div class="chart-container">
                <div class="chart-title">
                    <i class="fas fa-chart-bar" style="color: #3b82f6;"></i>
                    Monthly Revenue
                </div>
                <canvas id="revenueChart"></canvas>
            </div>

            <!-- Order Status Chart -->
            <div class="chart-container">
                <div class="chart-title">
                    <i class="fas fa-chart-pie" style="color: #8b5cf6;"></i>
                    Order Status Distribution
                </div>
                <canvas id="orderStatusChart"></canvas>
            </div>
        </div>

        <!-- ===== RECENT ORDERS & TOP PRODUCTS ===== -->
        <div class="dashboard-grid">
            <!-- Recent Orders -->
            <div class="chart-container">
                <div class="chart-title d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-receipt" style="color: #3b82f6;"></i> Recent Orders</span>
                    <a href="{{ route('admin.payments.index') }}" style="font-size: 0.75rem; color: #3b82f6; text-decoration: none; font-weight: 500;">
                        View All <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="table-scroll">
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
                    <span><i class="fas fa-fire" style="color: #f59e0b;"></i> Top Selling Products</span>
                    <a href="{{ route('admin.products.index') }}" style="font-size: 0.75rem; color: #3b82f6; text-decoration: none; font-weight: 500;">
                        View All <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="table-scroll">
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
                                <td><strong>{{ $product->name ?? 'N/A' }}</strong></td>
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

        <!-- ===== RECENT USERS & MESSAGES ===== -->
        <div class="dashboard-grid">
            <!-- Recent Users -->
            <div class="chart-container">
                <div class="chart-title d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-user-plus" style="color: #10b981;"></i> Recent Users</span>
                    <a href="{{ route('admin.users.index') }}" style="font-size: 0.75rem; color: #3b82f6; text-decoration: none; font-weight: 500;">
                        View All <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="table-scroll">
                    <table class="table table-dashboard">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentMembers ?? [] as $member)
                            <tr>
                                <td><strong>{{ $member->name }}</strong></td>
                                <td>{{ $member->email }}</td>
                                <td>{{ $member->created_at->format('d M Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">No users found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Messages -->
            <div class="chart-container">
                <div class="chart-title d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-envelope" style="color: #f59e0b;"></i> Recent Messages</span>
                    <a href="{{ route('admin.contacts.index') }}" style="font-size: 0.75rem; color: #3b82f6; text-decoration: none; font-weight: 500;">
                        View All <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="table-scroll">
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

<!-- ===== CHART.JS ===== -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ===== REVENUE CHART =====
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyLabels ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']) !!},
            datasets: [{
                label: 'Revenue (₹)',
                data: {!! json_encode($monthlyRevenueData ?? [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]) !!},
                backgroundColor: 'rgba(59, 130, 246, 0.08)',
                borderColor: '#3b82f6',
                borderWidth: 2.5,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#3b82f6',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
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
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });

    // ===== ORDER STATUS CHART =====
    const statusCtx = document.getElementById('orderStatusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($statusLabels ?? ['Pending', 'Confirmed', 'Shipped', 'Delivered', 'Cancelled', 'Failed']) !!},
            datasets: [{
                data: {!! json_encode($statusData ?? [0, 0, 0, 0, 0, 0]) !!},
                backgroundColor: ['#f59e0b', '#3b82f6', '#8b5cf6', '#22c55e', '#ef4444', '#64748b'],
                borderWidth: 2,
                borderColor: '#fff',
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 14,
                        usePointStyle: true,
                        pointStyle: 'circle',
                        font: {
                            size: 11,
                            weight: '500'
                        }
                    }
                }
            },
            cutout: '68%'
        }
    });
});
</script>
@endsection