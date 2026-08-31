@extends('layouts.admin-layout')

@section('content')
<style>
    :root {
        --primary: #4a9eff;
        --primary-dark: #2b7be0;
        --success: #4caf50;
        --warning: #ffa726;
        --danger: #ef5350;
        --dark: #1a1a2e;
        --gray: #6c757d;
        --light-gray: #f8f9fa;
        --border-color: #e9ecef;
        --shadow: 0 2px 20px rgba(0,0,0,0.05);
        --radius: 10px;
        --radius-lg: 16px;
    }

    .admin-main-content {
        padding: 20px 25px;
        background: #f0f4f8;
        min-height: 100vh;
    }

    .report-card {
        background: #ffffff;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow);
        border: 1px solid rgba(0,0,0,0.04);
        overflow: hidden;
        max-width: 100%;
        margin: 0 auto;
        margin-bottom: 20px;
    }

    .report-card .card-header {
        padding: 16px 24px;
        background: linear-gradient(135deg, #0d1b2a 0%, #1b3a5c 100%);
        color: #ffffff;
        border-bottom: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .report-card .card-header h4 {
        margin: 0;
        font-weight: 600;
        font-size: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .report-card .card-header h4 i {
        color: #4a9eff;
    }

    .report-card .card-body {
        padding: 20px 24px;
    }

    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .stat-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .stat-grid {
            grid-template-columns: 1fr;
        }
    }

    .stat-item {
        background: #ffffff;
        border-radius: var(--radius);
        padding: 16px 20px;
        border: 1px solid var(--border-color);
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }

    .stat-item .stat-label {
        font-size: 11px;
        color: var(--gray);
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .stat-item .stat-value {
        font-size: 22px;
        font-weight: 700;
        color: var(--dark);
        margin-top: 4px;
    }

    .stat-item .stat-value.red { color: #ef4444; }
    .stat-item .stat-value.blue { color: #3b82f6; }
    .stat-item .stat-value.green { color: #10b981; }
    .stat-item .stat-value.orange { color: #f59e0b; }
    .stat-item .stat-value.purple { color: #8b5cf6; }

    .stat-item .stat-icon {
        float: right;
        font-size: 28px;
        opacity: 0.15;
    }

    .stat-item .stat-sub {
        font-size: 12px;
        color: var(--gray);
        margin-top: 2px;
    }

    .btn-primary {
        background: var(--primary);
        color: #fff;
        border: none;
        padding: 8px 20px;
        border-radius: 8px;
        font-weight: 500;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(74, 158, 255, 0.35);
        color: #fff;
    }

    .btn-secondary {
        background: #f0f4f8;
        color: var(--gray);
        border: 1px solid var(--border-color);
        padding: 8px 20px;
        border-radius: 8px;
        font-weight: 500;
        font-size: 13px;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-secondary:hover {
        background: #e9ecef;
        color: var(--dark);
    }

    .filter-section {
        background: var(--light-gray);
        border-radius: var(--radius);
        padding: 16px 18px;
        margin-bottom: 20px;
        border: 1px solid var(--border-color);
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 12px;
    }

    .filter-section select {
        padding: 8px 12px;
        border: 1px solid var(--border-color);
        border-radius: var(--radius);
        font-size: 13px;
        background: #fff;
        height: 38px;
        min-width: 150px;
        transition: all 0.3s;
        color: var(--dark);
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236c757d' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 36px;
    }

    .filter-section select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(74, 158, 255, 0.12);
        outline: none;
    }

    .chart-container {
        background: #ffffff;
        border-radius: var(--radius);
        padding: 20px;
        border: 1px solid var(--border-color);
        margin-bottom: 20px;
    }

    .chart-container .chart-title {
        font-size: 14px;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .chart-container .chart-title i {
        color: var(--primary);
    }

    .chart-container canvas {
        width: 100% !important;
        height: 280px !important;
        max-height: 280px;
    }

    .table-responsive {
        overflow-x: auto;
        border-radius: var(--radius);
        border: 1px solid var(--border-color);
    }

    .table-salaries {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        margin: 0;
        min-width: 500px;
    }

    .table-salaries thead {
        background: var(--light-gray);
    }

    .table-salaries thead th {
        padding: 12px 14px;
        font-weight: 600;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--dark);
        border-bottom: 2px solid var(--border-color);
        text-align: left;
        white-space: nowrap;
    }

    .table-salaries tbody td {
        padding: 10px 14px;
        vertical-align: middle;
        border-bottom: 1px solid var(--border-color);
    }

    .table-salaries tbody tr:hover {
        background: #f8f9fa;
    }

    .table-salaries .amount {
        font-weight: 700;
        color: #10b981;
        white-space: nowrap;
    }

    .table-salaries .sno {
        font-weight: 600;
        color: var(--gray);
        font-size: 12px;
        text-align: center;
        width: 40px;
    }

    @media (max-width: 768px) {
        .admin-main-content {
            padding: 12px 15px;
        }
        .report-card .card-header {
            padding: 12px 16px;
            flex-direction: column;
            align-items: flex-start;
        }
        .report-card .card-header h4 {
            font-size: 16px;
        }
        .report-card .card-body {
            padding: 14px 16px;
        }
        .stat-item .stat-value {
            font-size: 18px;
        }
        .filter-section {
            flex-direction: column;
        }
        .filter-section select {
            width: 100%;
        }
        .table-salaries tbody td {
            padding: 6px 8px;
            font-size: 11px;
        }
        .table-salaries thead th {
            padding: 6px 8px;
            font-size: 10px;
        }
    }

    @media (max-width: 576px) {
        .report-card .card-header h4 {
            font-size: 14px;
        }
        .report-card .card-body {
            padding: 10px 12px;
        }
        .stat-item {
            padding: 12px 14px;
        }
        .stat-item .stat-value {
            font-size: 16px;
        }
        .chart-container canvas {
            height: 200px !important;
            max-height: 200px;
        }
        .table-salaries tbody td {
            padding: 4px 6px;
            font-size: 10px;
        }
        .table-salaries thead th {
            padding: 4px 6px;
            font-size: 9px;
        }
        .table-salaries .amount {
            font-size: 11px;
        }
    }
</style>

<div class="admin-main-content">
    <div class="report-card">
        <div class="card-header">
            <div>
                <h4><i class="fas fa-chart-bar"></i> Salary Report</h4>
                <small>Trainer salary summary and statistics</small>
            </div>
            <div style="display:flex; gap:10px; flex-wrap:wrap;">
                <a href="{{ route('admin.trainer-salaries.export', ['month' => request('month'), 'year' => request('year')]) }}" class="btn-primary" style="background:#22c55e;">
                    <i class="fas fa-file-excel"></i> Export CSV
                </a>
                <a href="{{ route('admin.trainer-salaries.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="card-body">
            <!-- Filter -->
            <div class="filter-section">
                <form method="GET" action="{{ route('admin.trainer-salaries.report') }}" style="display:flex; flex-wrap:wrap; gap:10px; align-items:center; width:100%;">
                    <select name="year">
                        @for($i = now()->year; $i >= now()->year - 5; $i--)
                            <option value="{{ $i }}" {{ ($year ?? now()->year) == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                    <select name="month">
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ ($month ?? now()->month) == $m ? 'selected' : '' }}>{{ date('F', mktime(0,0,0,$m,1)) }}</option>
                        @endfor
                    </select>
                    <button type="submit" class="btn-primary" style="padding:8px 18px;">
                        <i class="fas fa-filter"></i> View Report
                    </button>
                </form>
            </div>

            <!-- Stats -->
            <div class="stat-grid">
                <div class="stat-item">
                    <span class="stat-icon"><i class="fas fa-rupee-sign"></i></span>
                    <div class="stat-label">Monthly Total</div>
                    <div class="stat-value red">₹ {{ number_format($monthlyTotal ?? 0, 2) }}</div>
                    <div class="stat-sub">{{ date('M Y', mktime(0,0,0,$month ?? 1,1,$year ?? now()->year)) }}</div>
                </div>
                <div class="stat-item">
                    <span class="stat-icon"><i class="fas fa-calendar-alt"></i></span>
                    <div class="stat-label">Yearly Total</div>
                    <div class="stat-value blue">₹ {{ number_format($yearlyTotal ?? 0, 2) }}</div>
                    <div class="stat-sub">{{ $year ?? now()->year }}</div>
                </div>
                <div class="stat-item">
                    <span class="stat-icon"><i class="fas fa-hand-holding-usd"></i></span>
                    <div class="stat-label">Cash Payments</div>
                    <div class="stat-value orange">₹ {{ number_format($cashTotal ?? 0, 2) }}</div>
                    <div class="stat-sub">{{ date('M Y', mktime(0,0,0,$month ?? 1,1,$year ?? now()->year)) }}</div>
                </div>
                <div class="stat-item">
                    <span class="stat-icon"><i class="fas fa-university"></i></span>
                    <div class="stat-label">Bank + Online</div>
                    <div class="stat-value purple">₹ {{ number_format(($bankTotal ?? 0) + ($onlineTotal ?? 0), 2) }}</div>
                    <div class="stat-sub">{{ date('M Y', mktime(0,0,0,$month ?? 1,1,$year ?? now()->year)) }}</div>
                </div>
            </div>

            <!-- Monthly Chart -->
            <div class="chart-container">
                <div class="chart-title">
                    <i class="fas fa-chart-bar" style="color: #3b82f6;"></i> Monthly Salary Trend
                </div>
                <canvas id="salaryChart"></canvas>
            </div>

            <!-- Trainer-wise Breakdown -->
            <div class="table-responsive">
                <h6 style="font-weight:600; color:#1a1a2e; margin-bottom:12px;">
                    <i class="fas fa-users" style="color: #4a9eff;"></i> Trainer-wise Salary ({{ date('F Y', mktime(0,0,0,$month ?? 1,1,$year ?? now()->year)) }})
                </h6>
                <table class="table-salaries">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:50px;">#</th>
                            <th>Trainer</th>
                            <th>Specialization</th>
                            <th>Salary Amount</th>
                            <th>Payment Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($trainerSalaries as $index => $trainer)
                            @php
                                $salaryTotal = $trainer->salaries->sum('salary_amount');
                                $salaryType = $trainer->salaries->first()->payment_type ?? 'N/A';
                            @endphp
                            @if($salaryTotal > 0)
                                <tr>
                                    <td class="text-center sno">{{ $index + 1 }}</td>
                                    <td><strong>{{ $trainer->name }}</strong></td>
                                    <td>{{ $trainer->specialization ?? 'General' }}</td>
                                    <td><span class="amount">₹ {{ number_format($salaryTotal, 2) }}</span></td>
                                    <td>
                                        @if($salaryType == 'cash')
                                            <span class="payment-tag cash">Cash</span>
                                        @elseif($salaryType == 'bank')
                                            <span class="payment-tag bank">Bank Transfer</span>
                                        @elseif($salaryType == 'online')
                                            <span class="payment-tag online">Online</span>
                                        @else
                                            <span class="payment-tag">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="5" style="text-align:center; padding:30px; color:var(--gray);">
                                    <i class="fas fa-users" style="font-size:24px; display:block; margin-bottom:8px; color:#dee2e6;"></i>
                                    No salary records found for this month.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Salary Chart
    const ctx = document.getElementById('salaryChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($monthlyLabels) !!},
            datasets: [{
                label: 'Salary (₹)',
                data: {!! json_encode($monthlyData) !!},
                backgroundColor: 'rgba(74, 158, 255, 0.7)',
                borderColor: '#4a9eff',
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
});
</script>

<style>
    .payment-tag {
        padding: 3px 12px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
    }

    .payment-tag.cash {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .payment-tag.bank {
        background: #e3f2fd;
        color: #1565c0;
    }

    .payment-tag.online {
        background: #f3e5f5;
        color: #6a1b9a;
    }

    .payment-tag {
        background: #f5f5f5;
        color: #9e9e9e;
    }
</style>
@endsection