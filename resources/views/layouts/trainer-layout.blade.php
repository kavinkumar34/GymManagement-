<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ App\Models\Setting::get('company_name', 'Gym Management') }} - Trainer Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            overflow-x: hidden;
        }

        .dashboard-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* ============================================ */
        /* TRAINER SIDEBAR - GREEN THEME                */
        /* ============================================ */
        .sidebar {
            width: 280px;
            min-height: 100vh;
            height: auto;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px 0;
            overflow-y: auto;
            z-index: 1000;
            transition: all 0.3s ease;
            display: block !important;
            background: linear-gradient(180deg, #0d2818 0%, #1a472a 100%);
            color: #ffffff;
        }

        .sidebar-brand {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .sidebar-brand h3 {
            font-weight: 700;
            margin: 0;
            color: #ffffff !important;
        }

        .sidebar-brand h3 i {
            margin-right: 10px;
            color: #ffd54f;
        }

        .sidebar-brand p {
            font-size: 0.75rem;
            opacity: 0.7;
            margin-top: 5px;
            color: rgba(255, 255, 255, 0.6) !important;
        }

        .sidebar-menu {
            list-style: none;
            padding: 15px 0;
            margin: 0;
        }

        .sidebar-menu .menu-label {
            padding: 10px 25px;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.5;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.5) !important;
        }

        .sidebar-menu li {
            padding: 10px 20px;
            margin: 3px 12px;
            border-radius: 10px;
            transition: all 0.3s ease;
            cursor: pointer;
            list-style: none;
        }

        .sidebar-menu li:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar-menu li.active {
            background: rgba(255, 213, 79, 0.2);
            border-left: 3px solid #ffd54f;
        }

        .sidebar-menu li a {
            text-decoration: none;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
            color: rgba(255, 255, 255, 0.7) !important;
        }

        .sidebar-menu li:hover a,
        .sidebar-menu li.active a {
            color: #ffffff !important;
        }

        .sidebar-menu li a i {
            width: 22px;
            font-size: 1rem;
            text-align: center;
            color: rgba(255, 255, 255, 0.6);
        }

        .sidebar-menu li:hover a i,
        .sidebar-menu li.active a i {
            color: #ffd54f;
        }

        .sidebar-menu li a .badge {
            margin-left: auto;
            font-size: 0.7rem;
            padding: 2px 8px;
            border-radius: 20px;
            background: #e94560 !important;
            color: #ffffff !important;
        }

        .sidebar-menu li.logout-item {
            margin-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 20px;
        }

        .sidebar-menu li.logout-item a {
            color: #ff6b6b !important;
        }

        .sidebar-menu li.logout-item:hover {
            background: rgba(255, 107, 107, 0.15);
        }

        /* ============================================ */
        /* MAIN CONTENT                                 */
        /* ============================================ */
        .main-content {
            margin-left: 280px;
            flex: 1;
            padding: 0;
            background: #f0f2f5;
            min-height: 100vh;
            width: calc(100% - 280px);
        }

        /* ============================================ */
        /* TRAINER TOP NAVBAR - GREEN                   */
        /* ============================================ */
        .top-navbar {
            padding: 12px 25px;
            background: linear-gradient(135deg, #0d2818 0%, #1a472a 100%);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .top-navbar .page-title h4 {
            margin: 0;
            color: #ffffff;
            font-weight: 600;
        }

        .top-navbar .page-title h4 i {
            color: #ffd54f;
        }

        .top-navbar .page-title small {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .top-navbar .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .top-navbar .user-info .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #ffd54f;
            color: #0d2818;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .top-navbar .user-info .user-name {
            font-weight: 600;
            color: #ffffff;
        }

        .top-navbar .user-info .user-role {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.7);
            display: block;
        }

        .top-navbar .user-info .badge-role {
            background: #ffd54f;
            color: #0d2818;
            padding: 3px 12px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .page-content {
            padding: 25px 30px;
        }

        /* ============================================ */
        /* RESPONSIVE                                   */
        /* ============================================ */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                padding: 10px 0;
                display: block !important;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .top-navbar {
                flex-direction: column;
                gap: 10px;
                text-align: center;
                padding: 15px;
            }

            .page-content {
                padding: 15px;
            }
        }

        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            border: none;
        }

        .card-header {
            border-radius: 15px 15px 0 0 !important;
        }



        /* Attendance Dropdown */
        .has-dropdown {
            margin: 0;
        }

        .dropdown-menu-custom {
            display: none;
            list-style: none;
            margin: 0;
            padding: 0;
            width: 100%;
            background: transparent;
        }

        .has-dropdown.active .dropdown-menu-custom {
            display: block;
        }

        .dropdown-item-custom {
            display: flex;
            align-items: center;
            width: 100%;
            padding: 12px 20px 12px 52px;
            color: rgba(255, 255, 255, .8);
            text-decoration: none;
            background: transparent;
            border-left: 3px solid transparent;
            white-space: nowrap;
            /* Single line */
            flex-wrap: nowrap;
            /* Don't wrap */
            gap: 12px;
        }

        .dropdown-item-custom:hover {
            background: rgba(255, 255, 255, .08);
            border-left: 3px solid #ffd54f;
            color: #fff;
        }

        .dropdown-item-custom i {
            width: 20px;
            margin-right: 10px;
        }

        .dropdown-arrow {
            margin-left: auto;
            transition: .3s;
        }

        .has-dropdown.active .dropdown-arrow {
            transform: rotate(180deg);
        }
    </style>
</head>

<body>

    <div class="dashboard-wrapper">

        <!-- ============================================ -->
        <!-- TRAINER SIDEBAR                              -->
        <!-- ============================================ -->
        <div class="sidebar">
            <div class="sidebar-brand">
                <h3><i class="fas fa-dumbbell"></i> Trainer</h3>
                <p>Portal</p>
            </div>
            <ul class="sidebar-menu">
                <li class="menu-label">Main Menu</li>
                <li class="active">
                    <a href="{{ route('trainer.dashboard') }}">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('trainer.members') }}">
                        <i class="fas fa-users"></i> Members
                    </a>
                </li>
                <li>
                    <a href="{{ route('trainer.workout.index') }}">
                        <i class="fas fa-dumbbell"></i> Workout
                    </a>
                </li>
                <li>
                    <a href="{{ route('trainer.diet.index') }}">
                        <i class="fas fa-utensils"></i>
                        <span>Diet</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('trainer.progress.index') }}">
                        <i class="fas fa-chart-line"></i> Progress
                    </a>
                </li>

                <li class="has-dropdown">
                    <a href="javascript:void(0)" class="nav-link dropdown-toggle">
                        <i class="fas fa-calendar-check"></i>
                        <span>Attendance</span>
                        <span class="dropdown-arrow">
                            <i class="fas fa-chevron-down"></i>
                        </span>
                    </a>

                    <ul class="dropdown-menu-custom">
                        <li>
                            <a href="{{ route('trainer.trainer-attendance.index') }}" class="dropdown-item-custom">
                                <i class="fas fa-user-check"></i>
                                My Attendance
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('trainer.member-attendance.index') }}" class="dropdown-item-custom">
                                <i class="fas fa-users"></i>
                                Member Attendance
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('trainer.appointment.index') }}">
                        <i class="fas fa-calendar-plus"></i> Appointments
                    </a>
                </li>

                <li class="logout-item">
                    <a href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </div>

        <!-- ============================================ -->
        <!-- MAIN CONTENT                                 -->
        <!-- ============================================ -->
        <div class="main-content">

            <!-- ===== TRAINER TOP NAVBAR ===== -->
            <div class="top-navbar">
                <div class="page-title">
                    <h4>
                        <i class="fas fa-chalkboard-user me-2"></i> Trainer Dashboard
                        <small><i class="fas fa-calendar-alt ms-3 me-1"></i> {{ date('l, d M Y') }}</small>
                    </h4>
                </div>
                <div class="user-info">
                    <div class="text-end">
                        <span class="user-name">{{ auth()->user()->name ?? 'Guest' }}</span>
                        <span class="user-role">
                            <span class="badge-role"><i class="fas fa-user me-1"></i> Trainer</span>
                        </span>
                    </div>
                    <div class="avatar">
                        {{ substr(auth()->user()->name ?? 'G', 0, 1) }}
                    </div>
                </div>
            </div>

            <!-- ===== PAGE CONTENT ===== -->
            <div class="page-content">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- LOGOUT FORM - IMPORTANT!                     -->
    <!-- ============================================ -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const dropdowns = document.querySelectorAll('.has-dropdown');

            dropdowns.forEach(function(dropdown) {

                const toggle = dropdown.querySelector('.dropdown-toggle');

                toggle.addEventListener('click', function(e) {

                    e.preventDefault();

                    dropdown.classList.toggle('active');

                });

            });

        });
    </script>

</body>

</html>
