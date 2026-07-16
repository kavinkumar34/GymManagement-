<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ App\Models\Setting::get('company_name', 'Gym Management') }} - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
        }
        
        .dashboard-wrapper {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: 260px;
            background: #1a1a2e;
            color: white;
            padding: 20px 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }
        
        .sidebar-brand {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-align: center;
        }
        
        .sidebar-brand h3 {
            color: #e94560;
            font-weight: 700;
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 20px 0;
            margin: 0;
        }
        
        .sidebar-menu li {
            padding: 12px 25px;
            margin: 5px 10px;
            border-radius: 10px;
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .sidebar-menu li:hover,
        .sidebar-menu li.active {
            background: #e94560;
        }
        
        .sidebar-menu li a {
            color: #a0a0c0;
            text-decoration: none;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .sidebar-menu li:hover a,
        .sidebar-menu li.active a {
            color: white;
        }
        
        .sidebar-menu li i {
            width: 22px;
            font-size: 1.1rem;
        }
        
        /* Main Content */
        .main-content {
            margin-left: 260px;
            flex: 1;
            padding: 30px;
            background: #f0f2f5;
            min-height: 100vh;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-wrapper">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-brand">
                <h3><i class="fas fa-dumbbell"></i> Gym</h3>
                <p class="text-muted small">Dashboard</p>
            </div>
            
            <ul class="sidebar-menu">
                <li class="active">
                    <a href="{{ route('member.dashboard') }}">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-user"></i> Profile
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-dumbbell"></i> Workouts
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-utensils"></i> Diet Plan
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-chart-line"></i> Progress
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-credit-card"></i> Payments
                    </a>
                </li>
                <li style="margin-top: 30px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px;">
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @yield('content')
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>