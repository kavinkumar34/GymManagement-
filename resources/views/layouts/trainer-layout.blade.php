<!-- trainer-layout.blade.php -->
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
            padding: 5px 0;
            overflow-y: auto;
            z-index: 1000;
            transition: all 0.3s ease;
            display: block !important;
            background: linear-gradient(180deg, #0d2818 0%, #1a472a 100%);
            color: #ffffff;
        }

        /* Sidebar overlay for mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }

        /* Hamburger Toggle Button - Mobile Only */
        .sidebar-toggle {
            display: none;
            background: transparent;
            border: none;
            color: #ffffff;
            font-size: 1.5rem;
            padding: 5px 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .sidebar-toggle:hover {
            color: #ffd54f;
        }

        .sidebar-brand {
            padding: 0 1px 1px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .sidebar-brand h3 {
            font-weight: 700;
            margin-bottom: 24px;
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

        /* Close button inside sidebar (mobile) */
        .sidebar-close-btn {
            display: none;
            position: absolute;
            right: 15px;
            top: 15px;
            background: transparent;
            border: none;
            color: #ffffff;
            font-size: 1.5rem;
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.3s ease;
        }

        .sidebar-close-btn:hover {
            opacity: 1;
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
            white-space: nowrap;
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
            flex-shrink: 0;
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
        /* ATTENDANCE DROPDOWN - PERFECT ALIGNMENT      */
        /* ============================================ */
        .has-dropdown {
            margin: 0;
            position: relative;
        }

        .has-dropdown>.dropdown-toggle {
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.7) !important;
            border-radius: 10px;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

    

        .has-dropdown>.dropdown-toggle i {
            width: 22px;
            font-size: 1rem;
            text-align: center;
            color: rgba(255, 255, 255, 0.6);
            flex-shrink: 0;
        }

        .has-dropdown>.dropdown-toggle span {
            flex: 1;
            white-space: nowrap;
        }

        .has-dropdown .dropdown-arrow {
            margin-left: auto;
            transition: transform 0.3s ease;
            flex-shrink: 0;
        }

        .has-dropdown.active .dropdown-arrow {
            transform: rotate(180deg);
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

        .dropdown-menu-custom li {
            padding: 0 !important;
            margin: 0 !important;
            border-radius: 0 !important;
            background: transparent !important;
            list-style: none !important;
        }

        .dropdown-menu-custom li:hover {
            background: transparent !important;
        }

        .dropdown-item-custom {
            display: flex !important;
            align-items: center !important;
            width: 100% !important;
            padding: 8px 20px 8px 52px !important;
            color: rgba(255, 255, 255, 0.6) !important;
            text-decoration: none !important;
            background: transparent !important;
            border-left: 3px solid transparent !important;
            border-radius: 8px !important;
            transition: all 0.3s ease !important;
            gap: 12px !important;
            font-size: 0.85rem !important;
            white-space: nowrap !important;
        }

        .dropdown-item-custom:hover {
            background: rgba(255, 255, 255, 0.06) !important;
            border-left-color: #ffd54f !important;
            color: #ffffff !important;
            padding-left: 57px !important;
        }

        .dropdown-item-custom i {
            width: 20px !important;
            text-align: center !important;
            color: rgba(255, 255, 255, 0.4) !important;
            font-size: 0.85rem !important;
            flex-shrink: 0 !important;
        }

        .dropdown-item-custom:hover i {
            color: #ffd54f !important;
        }

        .dropdown-item-custom span {
            white-space: nowrap !important;
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
            transition: margin-left 0.3s ease;
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

        .top-navbar .left-section {
            display: flex;
            align-items: center;
            gap: 15px;
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
            cursor: pointer;
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
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .top-navbar .user-info .avatar:hover {
            transform: scale(1.05);
            box-shadow: 0 0 20px rgba(255, 213, 79, 0.3);
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
        /* PROFILE MODAL - RIGHT SIDE                   */
        /* ============================================ */
        .profile-modal .modal-dialog {
            margin: 0 0 0 auto;
            max-width: 420px;
            height: 100vh;
            display: flex;
            align-items: stretch;
        }

        .profile-modal .modal-content {
            border-radius: 0;
            min-height: 100vh;
            max-height: 100vh;
            overflow-y: auto;
            border: none;
            box-shadow: -5px 0 30px rgba(0, 0, 0, 0.1);
        }

        .profile-modal .modal-header {
            background: linear-gradient(135deg, #0d2818 0%, #1a472a 100%);
            color: white;
            border-bottom: none;
            padding: 20px 25px;
            position: sticky;
            top: 0;
            z-index: 10;
            border-radius: 0;
        }

        .profile-modal .modal-header .btn-close {
            filter: brightness(0) invert(1);
            opacity: 0.8;
        }

        .profile-modal .modal-header .btn-close:hover {
            opacity: 1;
        }

        .profile-modal .modal-body {
            padding: 25px;
        }

        .profile-modal .modal-footer {
            padding: 15px 25px;
            border-top: 1px solid #eef2f6;
            position: sticky;
            bottom: 0;
            background: white;
            border-radius: 0;
        }

        .profile-avatar-lg {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #ffd54f, #ffb300);
            color: #0d2818;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0 auto 15px;
            border: 4px solid #ffd54f;
            box-shadow: 0 4px 15px rgba(255, 213, 79, 0.3);
        }

        .profile-modal .profile-name {
            text-align: center;
            font-size: 1.3rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 5px;
        }

        .profile-modal .profile-email {
            text-align: center;
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 20px;
        }

        .profile-modal .profile-specialization {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-modal .profile-specialization .badge {
            background: rgba(13, 40, 24, 0.1);
            color: #0d2818;
            padding: 6px 18px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .profile-modal .profile-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .profile-modal .profile-info-item {
            background: #f8fafc;
            padding: 12px 16px;
            border-radius: 12px;
            border: 1px solid #eef2f6;
        }

        .profile-modal .profile-info-item .label {
            font-size: 0.7rem;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        .profile-modal .profile-info-item .value {
            font-size: 0.95rem;
            font-weight: 600;
            color: #1e293b;
            margin-top: 2px;
        }

        .profile-modal .profile-info-item .value .badge {
            font-size: 0.7rem;
        }

        .profile-modal .profile-info-item .value .status-badge {
            padding: 3px 12px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .profile-modal .profile-info-item .value .status-badge.active {
            background: #d4edda;
            color: #155724;
        }

        .profile-modal .profile-info-item .value .status-badge.inactive {
            background: #f8d7da;
            color: #721c24;
        }

        /* Animation for right side modal */
        .profile-modal .modal-dialog {
            transform: translateX(100%) !important;
            transition: transform 0.3s ease !important;
        }

        .profile-modal.show .modal-dialog {
            transform: translateX(0) !important;
        }

        .profile-modal .modal-backdrop {
            z-index: 1040 !important;
        }

        /* ============================================ */
        /* RESPONSIVE - MOBILE & TABLET                 */
        /* ============================================ */

        /* Tablet - Medium Screens */
        @media (max-width: 1024px) {
            .sidebar {
                width: 240px;
            }

            .main-content {
                margin-left: 240px;
                width: calc(100% - 240px);
            }
        }

        /* Mobile - Small Screens */
        @media (max-width: 768px) {

            /* Hide sidebar by default on mobile */
            .sidebar {
                width: 300px;
                left: -320px;
                display: block !important;
                position: fixed;
                top: 0;
                height: 100vh;
                min-height: 100vh;
                z-index: 1001;
                transition: left 0.3s ease;
                box-shadow: 2px 0 30px rgba(0, 0, 0, 0.2);
                padding-top: 0;
            }

            .sidebar.open {
                left: 0;
            }

            /* Show hamburger toggle on mobile */
            .sidebar-toggle {
                display: block;
            }

            .sidebar-close-btn {
                display: block;
            }

            .sidebar-brand {
                padding: 15px 20px;
                justify-content: space-between;
            }

            .sidebar-brand h3 {
                font-size: 1.2rem;
                margin-bottom: 0;
            }

            .sidebar-overlay.active {
                display: block;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .top-navbar {
                padding: 12px 15px;
                gap: 10px;
                flex-wrap: wrap;
            }

            .top-navbar .left-section {
                gap: 10px;
            }

            .top-navbar .page-title h4 {
                font-size: 1rem;
            }

            .top-navbar .page-title small {
                font-size: 0.65rem;
                display: none;
            }

            .top-navbar .user-info .user-name {
                font-size: 0.85rem;
            }

            .top-navbar .user-info .avatar {
                width: 35px;
                height: 35px;
                font-size: 0.9rem;
            }

            .page-content {
                padding: 15px;
            }

            .profile-modal .profile-info-grid {
                grid-template-columns: 1fr;
            }

            .profile-modal .modal-dialog {
                max-width: 100% !important;
                margin: 0 !important;
            }

            .sidebar-menu li {
                padding: 8px 15px;
                margin: 2px 10px;
            }

            .sidebar-menu li a {
                font-size: 0.85rem;
            }

            .sidebar-menu .menu-label {
                padding: 8px 20px;
                font-size: 0.6rem;
            }

            .dropdown-item-custom {
                padding: 6px 15px 6px 40px !important;
                font-size: 0.8rem !important;
            }

            .dropdown-item-custom:hover {
                padding-left: 45px !important;
            }
        }

        /* Extra Small Devices */
        @media (max-width: 480px) {
            .sidebar {
                width: 280px;
                left: -290px;
            }

            .top-navbar .page-title small {
                display: none;
            }

            .top-navbar .user-info .user-name {
                font-size: 0.8rem;
            }

            .top-navbar .user-info .badge-role {
                font-size: 0.6rem;
                padding: 2px 8px;
            }

            .page-content {
                padding: 10px;
            }

            .profile-modal .modal-dialog {
                max-width: 100% !important;
            }
        }

        /* Scrollbar styling */
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
    </style>
</head>

<body>

    <div class="dashboard-wrapper">

        <!-- ============================================ -->
        <!-- SIDEBAR OVERLAY (Mobile)                     -->
        <!-- ============================================ -->
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

        <!-- ============================================ -->
        <!-- TRAINER SIDEBAR                              -->
        <!-- ============================================ -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <h3><i class="fas fa-dumbbell"></i> Trainer</h3>
                <button class="sidebar-close-btn" onclick="closeSidebar()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <ul class="sidebar-menu">
                <li class="{{ request()->routeIs('trainer.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('trainer.dashboard') }}">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li class="{{ request()->routeIs('trainer.members*') ? 'active' : '' }}">
                    <a href="{{ route('trainer.members') }}">
                        <i class="fas fa-users"></i> Members
                    </a>
                </li>
                <li class="{{ request()->routeIs('trainer.workout*') ? 'active' : '' }}">
                    <a href="{{ route('trainer.workout.index') }}">
                        <i class="fas fa-dumbbell"></i> Workout
                    </a>
                </li>
                <li class="{{ request()->routeIs('trainer.diet*') ? 'active' : '' }}">
                    <a href="{{ route('trainer.diet.index') }}">
                        <i class="fas fa-utensils"></i> Diet
                    </a>
                </li>
                <li class="{{ request()->routeIs('trainer.progress*') ? 'active' : '' }}">
                    <a href="{{ route('trainer.progress.index') }}">
                        <i class="fas fa-chart-line"></i> Progress
                    </a>
                </li>
                <!-- Attendance Dropdown - Proper Alignment -->
                <li
                    class="has-dropdown {{ request()->routeIs('trainer.trainer-attendance*') || request()->routeIs('trainer.member-attendance*') ? 'active' : '' }}">
                    <a href="javascript:void(0)" class="dropdown-toggle">
                        <i class="fas fa-calendar-check"></i>
                        <span>Attendance</span>
                      
                    </a>

                    <ul class="dropdown-menu-custom">
                        <li>
                            <a href="{{ route('trainer.trainer-attendance.index') }}" class="dropdown-item-custom">
                                <i class="fas fa-user-check"></i>
                                <span>My Attendance</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('trainer.member-attendance.index') }}" class="dropdown-item-custom">
                                <i class="fas fa-users"></i>
                                <span>Member Attendance</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="{{ request()->routeIs('trainer.appointment*') ? 'active' : '' }}">
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
            @php
                $trainerData = null;
                if (session('gym_user_id')) {
                    $trainerData = \App\Models\Trainer::find(session('gym_user_id'));
                }
                if (!$trainerData && auth()->check()) {
                    $trainerData = \App\Models\Trainer::where('email', auth()->user()->email)->first();
                }
                if (!$trainerData) {
                    $trainerData = \App\Models\Trainer::first();
                }
            @endphp

            <div class="top-navbar">
                <div class="left-section">
                    <!-- Hamburger Toggle Button -->
                    <button class="sidebar-toggle" onclick="toggleSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="page-title">
                        <h4>
                            <i class="fas fa-chalkboard-user me-2"></i> Trainer
                            <small><i class="fas fa-calendar-alt ms-3 me-1"></i> {{ date('l, d M Y') }}</small>
                        </h4>
                    </div>
                </div>
                <div class="user-info" onclick="openProfileModal()">
                    <div class="text-end">
                        <span class="user-name">{{ $trainerData->name ?? 'Guest' }}</span>
                        <span class="user-role">Trainer</span>
                    </div>
                    <div class="avatar">
                        {{ $trainerData ? strtoupper(substr($trainerData->name, 0, 1)) : 'G' }}
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
    <!-- PROFILE MODAL - RIGHT SIDE                   -->
    <!-- ============================================ -->
    <div class="modal fade profile-modal" id="profileModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-user-circle me-2"></i> Trainer Profile
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @php
                        $profileTrainer = null;
                        if (session('gym_user_id')) {
                            $profileTrainer = \App\Models\Trainer::find(session('gym_user_id'));
                        }
                        if (!$profileTrainer && auth()->check()) {
                            $profileTrainer = \App\Models\Trainer::where('email', auth()->user()->email)->first();
                        }
                        if (!$profileTrainer) {
                            $profileTrainer = \App\Models\Trainer::first();
                        }
                    @endphp

                    @if ($profileTrainer)
                        <div class="profile-avatar-lg">
                            {{ strtoupper(substr($profileTrainer->name, 0, 1)) }}
                        </div>
                        <div class="profile-name">{{ $profileTrainer->name }}</div>
                        <div class="profile-email">{{ $profileTrainer->email }}</div>
                        <div class="profile-specialization">
                            <span class="badge">
                                <i class="fas fa-dumbbell me-1"></i>
                                {{ $profileTrainer->specialization ?? 'Personal Training' }}
                            </span>
                        </div>

                        <div class="profile-info-grid">
                            <div class="profile-info-item">
                                <div class="label">Trainer ID</div>
                                <div class="value"><strong>{{ $profileTrainer->trainer_id ?? 'N/A' }}</strong></div>
                            </div>
                            <div class="profile-info-item">
                                <div class="label">Phone</div>
                                <div class="value">{{ $profileTrainer->phone ?? 'N/A' }}</div>
                            </div>
                            <div class="profile-info-item">
                                <div class="label">Gender</div>
                                <div class="value">{{ $profileTrainer->gender ?? 'N/A' }}</div>
                            </div>
                            <div class="profile-info-item">
                                <div class="label">Age</div>
                                <div class="value">{{ $profileTrainer->age ?? 'N/A' }} years</div>
                            </div>
                            <div class="profile-info-item">
                                <div class="label">Date of Birth</div>
                                <div class="value">
                                    {{ $profileTrainer->dob ? date('d M Y', strtotime($profileTrainer->dob)) : 'N/A' }}
                                </div>
                            </div>
                            <div class="profile-info-item">
                                <div class="label">Experience</div>
                                <div class="value">{{ $profileTrainer->experience ?? 'N/A' }} years</div>
                            </div>
                            <div class="profile-info-item">
                                <div class="label">Shift Timing</div>
                                <div class="value">{{ $profileTrainer->shift_timing ?? 'N/A' }}</div>
                            </div>
                            <div class="profile-info-item">
                                <div class="label">Assigned Members</div>
                                <div class="value"><strong>{{ $profileTrainer->assigned_members ?? 0 }}</strong>
                                </div>
                            </div>
                            <div class="profile-info-item">
                                <div class="label">Join Date</div>
                                <div class="value">
                                    {{ $profileTrainer->join_date ? date('d M Y', strtotime($profileTrainer->join_date)) : 'N/A' }}
                                </div>
                            </div>
                            <div class="profile-info-item">
                                <div class="label">Certification</div>
                                <div class="value">{{ $profileTrainer->certification ?? 'N/A' }}</div>
                            </div>
                            <div class="profile-info-item">
                                <div class="label">Salary</div>
                                <div class="value">
                                    <strong>₹{{ number_format($profileTrainer->salary ?? 0, 2) }}</strong>
                                </div>
                            </div>
                            <div class="profile-info-item">
                                <div class="label">Status</div>
                                <div class="value">
                                    <span
                                        class="status-badge {{ strtolower($profileTrainer->status ?? 'active') === 'active' ? 'active' : 'inactive' }}">
                                        {{ $profileTrainer->status ?? 'Active' }}
                                    </span>
                                </div>
                            </div>
                            <div class="profile-info-item" style="grid-column: 1 / -1;">
                                <div class="label">Address</div>
                                <div class="value">{{ $profileTrainer->address ?? 'N/A' }}</div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Trainer profile not found.</p>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- LOGOUT FORM                                  -->
    <!-- ============================================ -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script>
        // ============================================ //
        // SIDEBAR TOGGLE FUNCTIONS                     //
        // ============================================ //
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            sidebar.classList.toggle('open');
            overlay.classList.toggle('active');

            // Prevent body scroll when sidebar is open
            document.body.style.overflow = sidebar.classList.contains('open') ? 'hidden' : '';
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            sidebar.classList.remove('open');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        // Close sidebar when clicking on a menu item (mobile)
        document.addEventListener('DOMContentLoaded', function() {
            const menuItems = document.querySelectorAll('.sidebar-menu li a');
            menuItems.forEach(function(item) {
                item.addEventListener('click', function() {
                    if (window.innerWidth <= 768) {
                        // Don't close if it's the logout link (it has its own handler)
                        if (!this.closest('.logout-item') && !this.closest('.has-dropdown')) {
                            closeSidebar();
                        }
                    }
                });
            });

            // Close sidebar on resize to desktop
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    closeSidebar();
                }
            });

            // ============================================ //
            // ATTENDANCE DROPDOWN TOGGLE                   //
            // ============================================ //
            const dropdowns = document.querySelectorAll('.has-dropdown');
            dropdowns.forEach(function(dropdown) {
                const toggle = dropdown.querySelector('.dropdown-toggle');
                if (toggle) {
                    toggle.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        dropdown.classList.toggle('active');
                    });
                }
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                dropdowns.forEach(function(dropdown) {
                    if (!dropdown.contains(e.target)) {
                        dropdown.classList.remove('active');
                    }
                });
            });
        });

        // ============================================ //
        // PROFILE MODAL                                //
        // ============================================ //
        function openProfileModal() {
            const modal = new bootstrap.Modal(document.getElementById('profileModal'), {
                backdrop: true,
                keyboard: true
            });
            modal.show();
        }

        // Close modal on backdrop click
        document.addEventListener('DOMContentLoaded', function() {
            const modalElement = document.getElementById('profileModal');
            if (modalElement) {
                modalElement.addEventListener('click', function(e) {
                    if (e.target === this) {
                        const modal = bootstrap.Modal.getInstance(this);
                        if (modal) {
                            modal.hide();
                        }
                    }
                });
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
