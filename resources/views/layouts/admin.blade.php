<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - @yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @yield('styles')
    <style>
        body {
            background: #f0f4f8;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }
        .admin-main-content {
            margin-left: 270px;
            padding: 25px 30px;
            min-height: 100vh;
            background: #f0f4f8;
        }
        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 25px;
        }
        .card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 2px 15px rgba(0,0,0,0.06);
            background: white;
        }
        .card-header {
            background: white;
            border-bottom: 1px solid #eef2f6;
            padding: 16px 20px;
            font-weight: 600;
            border-radius: 12px 12px 0 0 !important;
        }
        .card-body {
            padding: 20px;
        }
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            display: inline-block;
        }
        .status-badge.active {
            background: #dcfce7;
            color: #15803d;
        }
        .status-badge.inactive {
            background: #fee2e2;
            color: #b91c1c;
        }
        .status-badge.expired {
            background: #fef3c7;
            color: #92400e;
        }
        .status-badge.pending {
            background: #fef3c7;
            color: #92400e;
        }
        .alert {
            border-radius: 12px;
            border: none;
        }
        .btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 8px 20px;
        }
        .btn-danger {
            background: #dc3545;
            border-color: #dc3545;
        }
        .btn-danger:hover {
            background: #c82333;
            border-color: #bd2130;
        }
        .btn-primary {
            background: #0d6efd;
            border-color: #0d6efd;
        }
        .btn-primary:hover {
            background: #0b5ed7;
            border-color: #0a58ca;
        }
        .btn-success {
            background: #28a745;
            border-color: #28a745;
        }
        .btn-success:hover {
            background: #218838;
            border-color: #1e7e34;
        }
        .table {
            margin-bottom: 0;
        }
        .table th {
            border-top: none;
            font-weight: 600;
            color: #475569;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .table td {
            vertical-align: middle;
        }
        @media (max-width: 768px) {
            .admin-main-content {
                margin-left: 70px;
                padding: 15px;
            }
            .page-title {
                font-size: 1.2rem;
            }
        }
        @media (max-width: 480px) {
            .admin-main-content {
                margin-left: 55px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    @include('layouts.admin-navbar')
    
    <div class="admin-main-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @yield('content')
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>