<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ App\Models\Setting::get('company_name', 'Gym Management') }} - Member Dashboard</title>
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
        /* MEMBER SIDEBAR - BLUE THEME                  */
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
            background: linear-gradient(180deg, #0d1b3e 0%, #1a2a6c 100%);
            color: #ffffff;
        }

        .sidebar-brand {
            padding: 0 1px 1px;
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
        /* MEMBER TOP NAVBAR - BLUE                     */
        /* ============================================ */
        .top-navbar {
            padding: 12px 25px;
            background: linear-gradient(135deg, #0d1b3e 0%, #1a2a6c 100%);
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
            cursor: pointer;
        }

        .top-navbar .user-info .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #ffd54f;
            color: #0d1b3e;
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
            color: #0d1b3e;
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
            background: linear-gradient(135deg, #0d1b3e 0%, #1a2a6c 100%);
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
            background: #ffd54f;
            color: #0d1b3e;
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

            .profile-modal .profile-info-grid {
                grid-template-columns: 1fr;
            }

            .profile-modal .modal-dialog {
                max-width: 100% !important;
                margin: 0 !important;
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
    </style>
</head>

<body>

    <div class="dashboard-wrapper">

        <!-- ============================================ -->
        <!-- MEMBER SIDEBAR                               -->
        <!-- ============================================ -->
        <div class="sidebar">
            <div class="sidebar-brand">
                <h3><i class="fas fa-dumbbell"></i> Member</h3>
                <p>Dashboard</p>
            </div>
            <ul class="sidebar-menu">
                <li class="menu-label">Main Menu</li>
                <li class="{{ request()->routeIs('member.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('member.dashboard') }}">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li class="{{ request()->routeIs('member.membership') ? 'active' : '' }}">
                    <a href="{{ route('member.membership') }}">
                        <i class="fas fa-id-card"></i> Membership
                        <span class="badge">Active</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('member.packages') ? 'active' : '' }}">
                    <a href="{{ route('member.packages') }}">
                        <i class="fas fa-shopping-bag"></i> Packages
                    </a>
                </li>
                <li class="{{ request()->routeIs('member.workout*') ? 'active' : '' }}">
                    <a href="{{ route('member.workout.index') }}">
                        <i class="fas fa-dumbbell"></i> Workout
                    </a>
                </li>
                <li class="{{ request()->routeIs('member.diet*') ? 'active' : '' }}">
                    <a href="{{ route('member.diet.index') }}">
                        <i class="fas fa-utensils"></i> Diet
                    </a>
                </li>

                <li class="{{ request()->routeIs('member.attendance*') ? 'active' : '' }}">
                    <a href="{{ route('member.attendance.index') }}">
                        <i class="fas fa-calendar-check"></i> Attendance
                    </a>
                </li>

                <li class="{{ request()->routeIs('member.progress*') ? 'active' : '' }}">
                    <a href="{{ route('member.progress.index') }}">
                        <i class="fas fa-chart-line"></i> Progress
                    </a>
                </li>

                <li class="{{ request()->routeIs('member.appointment*') ? 'active' : '' }}">
                    <a href="{{ route('member.appointment.index') }}">
                        <i class="fas fa-calendar-plus"></i> Appointment
                    </a>
                </li>

                <li class="{{ request()->routeIs('member.payments*') ? 'active' : '' }}">
                    <a href="{{ route('member.payments.index') }}">
                        <i class="fas fa-credit-card"></i> Payments
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

            <!-- ===== MEMBER TOP NAVBAR ===== -->
            @php
                $memberData = \App\Models\Member::where('email', session('gym_user_email'))->first();
            @endphp

            <div class="top-navbar">
                <div class="page-title">
                    <h4>
                        <i class="fas fa-user me-2"></i> Member
                        <small><i class="fas fa-calendar-alt ms-3 me-1"></i> {{ date('l, d M Y') }}</small>
                    </h4>
                </div>
                <div class="user-info" onclick="openProfileModal()">
                    <div class="text-end">
                        <span class="user-name">{{ $memberData->name ?? session('gym_user_name', 'Guest') }}</span>

                    </div>
                    <div class="avatar">
                        {{ $memberData ? substr($memberData->name, 0, 1) : 'G' }}
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
                        <i class="fas fa-user-circle me-2"></i> My Profile
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @php
                        $profileMember = \App\Models\Member::where('email', session('gym_user_email'))->first();
                    @endphp

                    @if ($profileMember)
                        <div class="profile-avatar-lg">
                            {{ substr($profileMember->name, 0, 1) }}
                        </div>
                        <div class="profile-name">{{ $profileMember->name }}</div>
                        <div class="profile-email">{{ $profileMember->email }}</div>

                        <div class="profile-info-grid">
                            <div class="profile-info-item">
                                <div class="label">Member ID</div>
                                <div class="value">{{ $profileMember->member_id }}</div>
                            </div>
                            <div class="profile-info-item">
                                <div class="label">Phone</div>
                                <div class="value">{{ $profileMember->phone }}</div>
                            </div>
                            <div class="profile-info-item">
                                <div class="label">Gender</div>
                                <div class="value">{{ $profileMember->gender ?? 'Not specified' }}</div>
                            </div>
                            <div class="profile-info-item">
                                <div class="label">Age</div>
                                <div class="value">{{ $profileMember->age ?? 'N/A' }}</div>
                            </div>
                            <div class="profile-info-item">
                                <div class="label">Height</div>
                                <div class="value">{{ $profileMember->height ?? 'N/A' }} cm</div>
                            </div>
                            <div class="profile-info-item">
                                <div class="label">Weight</div>
                                <div class="value">{{ $profileMember->weight ?? 'N/A' }} kg</div>
                            </div>
                            <div class="profile-info-item">
                                <div class="label">BMI</div>
                                <div class="value">{{ $profileMember->bmi ?? 'N/A' }}</div>
                            </div>
                            <div class="profile-info-item">
                                <div class="label">Goal</div>
                                <div class="value">
                                    <span class="badge" style="background: #8b5cf6; color: white;">
                                        {{ $profileMember->goal_type ?? 'Fitness' }}
                                    </span>
                                </div>
                            </div>
                            <div class="profile-info-item">
                                <div class="label">Plan Type</div>
                                <div class="value">
                                    @if ($profileMember->plan_type == 'membership')
                                        <span class="badge"
                                            style="background: #3b82f6; color: white;">Membership</span>
                                    @elseif($profileMember->plan_type == 'package')
                                        <span class="badge" style="background: #10b981; color: white;">Package</span>
                                    @else
                                        <span class="badge bg-secondary">N/A</span>
                                    @endif
                                </div>
                            </div>
                            <div class="profile-info-item">
                                <div class="label">Membership Plan</div>
                                <div class="value">{{ $profileMember->membership_plan ?? 'Basic' }}</div>
                            </div>
                            <div class="profile-info-item">
                                <div class="label">Join Date</div>
                                <div class="value">
                                    {{ \Carbon\Carbon::parse($profileMember->join_date)->format('d M Y') }}</div>
                            </div>
                            <div class="profile-info-item">
                                <div class="label">Status</div>
                                <div class="value">
                                    @if ($profileMember->status == 'Active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </div>
                            </div>
                            @if ($profileMember->trainer_id)
                                <div class="profile-info-item">
                                    <div class="label">Trainer</div>
                                    <div class="value">
                                        @php
                                            $trainer = \App\Models\Trainer::find($profileMember->trainer_id);
                                        @endphp
                                        @if ($trainer)
                                            <span class="badge" style="background: #f59e0b; color: white;">
                                                {{ $trainer->name ?? 'Not Assigned' }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">Not Assigned</span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            <div class="profile-info-item" style="grid-column: 1 / -1;">
                                <div class="label">Address</div>
                                <div class="value">{{ $profileMember->address ?? 'Not provided' }}</div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Member profile not found.</p>
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
