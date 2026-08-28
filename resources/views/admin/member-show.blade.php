@extends('layouts.admin-layout')

@section('content')
    <style>
        /* ============================================ */
        /* COLOR VARIABLES - MATCHING NAVBAR          */
        /* ============================================ */
        :root {
            --primary: #4a9eff;
            --primary-dark: #2b7be0;
            --primary-light: #8ab4f8;
            --success: #4caf50;
            --warning: #ffa726;
            --danger: #ef5350;
            --dark: #1a1a2e;
            --gray: #6c757d;
            --light-gray: #f8f9fa;
            --border-color: #e9ecef;
            --shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
            --radius: 10px;
            --radius-lg: 16px;
        }

        .admin-main-content {
            padding: 20px 25px;
            background: #f0f4f8;
            min-height: 100vh;
        }

        /* ============================================ */
        /* CARD STYLES                                 */
        /* ============================================ */
        .show-card {
            background: #ffffff;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            border: 1px solid rgba(0, 0, 0, 0.04);
            overflow: hidden;
            max-width: 1100px;
            margin: 0 auto;
        }

        .show-card .card-header {
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

        .show-card .card-header h4 {
            margin: 0;
            font-weight: 600;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .show-card .card-header h4 i {
            color: #4a9eff;
        }

        .show-card .card-header small {
            font-size: 12px;
            opacity: 0.8;
            font-weight: 400;
        }

        .show-card .card-body {
            padding: 20px 24px;
        }

        /* ============================================ */
        /* PROFILE SECTION                             */
        /* ============================================ */
        .profile-section {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 16px 20px;
            background: var(--light-gray);
            border-radius: var(--radius);
            margin-bottom: 20px;
            border: 1px solid var(--border-color);
            flex-wrap: wrap;
        }

        .profile-section .profile-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary);
            box-shadow: 0 4px 15px rgba(74, 158, 255, 0.2);
            flex-shrink: 0;
        }

        .profile-section .profile-info {
            flex: 1;
        }

        .profile-section .profile-info h3 {
            font-size: 20px;
            font-weight: 600;
            color: var(--dark);
            margin: 0 0 2px 0;
        }

        .profile-section .profile-info .profile-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 12px 20px;
            font-size: 13px;
            color: var(--gray);
        }

        .profile-section .profile-info .profile-meta span i {
            margin-right: 4px;
            color: var(--primary);
        }

        .profile-section .profile-status {
            text-align: right;
            flex-shrink: 0;
        }

        .profile-section .profile-status .status-badge {
            padding: 6px 18px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .profile-section .profile-status .status-badge.active {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .profile-section .profile-status .status-badge.inactive {
            background: #fce4ec;
            color: #c62828;
        }

        .profile-section .profile-status .status-badge .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
        }

        .profile-section .profile-status .status-badge.active .dot {
            background: #4caf50;
            animation: pulse-dot 2s infinite;
        }

        .profile-section .profile-status .status-badge.inactive .dot {
            background: #ef5350;
        }

        @keyframes pulse-dot {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.5;
                transform: scale(0.8);
            }
        }

        /* ============================================ */
        /* DETAILS TABLE STYLES                        */
        /* ============================================ */
        .details-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .details-table tr {
            transition: all 0.3s;
        }

        .details-table tr:hover {
            background: #f8f9fa;
        }

        .details-table th {
            padding: 10px 16px;
            font-weight: 600;
            color: var(--dark);
            background: var(--light-gray);
            border: 1px solid var(--border-color);
            width: 35%;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .details-table td {
            padding: 10px 16px;
            color: var(--dark);
            border: 1px solid var(--border-color);
        }

        .details-table td .badge-custom {
            padding: 3px 12px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .details-table td .badge-custom.primary {
            background: #e3f2fd;
            color: #1565c0;
        }

        .details-table td .badge-custom.success {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .details-table td .badge-custom.warning {
            background: #fff3e0;
            color: #e65100;
        }

        .details-table td .badge-custom.secondary {
            background: #f5f5f5;
            color: #9e9e9e;
        }

        .details-table td .badge-custom.info {
            background: #e3f2fd;
            color: #1565c0;
        }

        /* ============================================ */
        /* SECTION HEADERS                             */
        /* ============================================ */
        .section-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--dark);
            padding: 8px 14px;
            background: var(--light-gray);
            border-radius: var(--radius);
            border-left: 3px solid var(--primary);
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title i {
            color: var(--primary);
            font-size: 14px;
        }

        /* ============================================ */
        /* BUTTON STYLES                               */
        /* ============================================ */
        .btn-primary {
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 9px 24px;
            border-radius: var(--radius);
            font-weight: 500;
            font-size: 13px;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(74, 158, 255, 0.35);
        }

        .btn-warning {
            background: #ffa726;
            color: #fff;
            border: none;
            padding: 9px 24px;
            border-radius: var(--radius);
            font-weight: 500;
            font-size: 13px;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-warning:hover {
            background: #f57c00;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(255, 167, 38, 0.35);
        }

        .btn-secondary {
            background: #f0f4f8;
            color: var(--gray);
            border: 1px solid var(--border-color);
            padding: 9px 24px;
            border-radius: var(--radius);
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

        .form-actions {
            padding-top: 16px;
            border-top: 1px solid var(--border-color);
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        /* ============================================ */
        /* RESPONSIVE                                  */
        /* ============================================ */
        @media (max-width: 768px) {
            .admin-main-content {
                padding: 12px 15px;
            }

            .show-card .card-header {
                padding: 12px 16px;
                flex-direction: column;
                align-items: flex-start;
            }

            .show-card .card-header h4 {
                font-size: 16px;
            }

            .show-card .card-body {
                padding: 14px 16px;
            }

            .profile-section {
                flex-direction: column;
                text-align: center;
                padding: 14px 16px;
            }

            .profile-section .profile-status {
                text-align: center;
                width: 100%;
            }

            .profile-section .profile-info .profile-meta {
                justify-content: center;
            }

            .profile-section .profile-avatar {
                width: 60px;
                height: 60px;
            }

            .profile-section .profile-info h3 {
                font-size: 17px;
            }

            .details-table {
                font-size: 12px;
            }

            .details-table th,
            .details-table td {
                padding: 8px 12px;
            }

            .form-actions {
                flex-direction: column;
            }

            .form-actions .btn {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .show-card .card-header h4 {
                font-size: 14px;
            }

            .show-card .card-body {
                padding: 10px 12px;
            }

            .profile-section .profile-avatar {
                width: 50px;
                height: 50px;
            }

            .profile-section .profile-info h3 {
                font-size: 15px;
            }

            .profile-section .profile-info .profile-meta {
                font-size: 12px;
                gap: 8px 14px;
            }

            .details-table {
                font-size: 11px;
            }

            .details-table th,
            .details-table td {
                padding: 6px 10px;
                font-size: 11px;
            }

            .details-table th {
                font-size: 10px;
            }

            .section-title {
                font-size: 12px;
                padding: 6px 12px;
            }

            .btn-primary,
            .btn-warning,
            .btn-secondary {
                padding: 7px 16px;
                font-size: 12px;
            }
        }
    </style>

    <div class="admin-main-content">
        <div class="show-card">
            <!-- Card Header -->
            <div class="card-header">
                <div>
                    <h4><i class="fas fa-user"></i> Member Details</h4>
                    <small>View complete member information</small>
                </div>
                <span
                    style="background:rgba(74,158,255,0.2); color:#8ab4f8; padding:3px 12px; border-radius:50px; font-size:11px;">
                    <i class="fas fa-id-card"></i> {{ $member->member_id }}
                </span>
            </div>

            <!-- Card Body -->
            <div class="card-body">
                <!-- ========================================== -->
                <!-- PROFILE SECTION                            -->
                <!-- ========================================== -->
                <div class="profile-section">
                    @if ($member->photo)
                        <img src="{{ asset('storage/' . $member->photo) }}" class="profile-avatar" alt="{{ $member->name }}">
                    @else
                        <img src="{{ asset('images/no-image.png') }}" class="profile-avatar" alt="No Image">
                    @endif

                    <div class="profile-info">
                        <h3>{{ $member->name }}</h3>
                        <div class="profile-meta">
                            <span><i class="fas fa-envelope"></i> {{ $member->email }}</span>
                            <span><i class="fas fa-phone"></i> {{ $member->phone }}</span>
                            <span><i class="fas fa-venus-mars"></i> {{ $member->gender ?? 'Not specified' }}</span>
                            <span><i class="fas fa-calendar-alt"></i> Joined:
                                {{ date('d-m-Y', strtotime($member->join_date)) }}</span>
                        </div>
                    </div>

                    <div class="profile-status">
                        @if ($member->status == 'Active')
                            <span class="status-badge active">
                                <span class="dot"></span> Active
                            </span>
                        @else
                            <span class="status-badge inactive">
                                <span class="dot"></span> Inactive
                            </span>
                        @endif
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- PERSONAL INFORMATION                       -->
                <!-- ========================================== -->
                <div class="section-title">
                    <i class="fas fa-user"></i> Personal Information
                </div>

                <table class="details-table">
                    <tr>
                        <th>Member ID</th>
                        <td><span class="badge-custom primary">{{ $member->member_id }}</span></td>
                    </tr>
                    <tr>
                        <th>Full Name</th>
                        <td>{{ $member->name }}</td>
                    </tr>
                    <tr>
                        <th>Email Address</th>
                        <td>{{ $member->email }}</td>
                    </tr>
                    <tr>
                        <th>Phone Number</th>
                        <td>{{ $member->phone }}</td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td>{{ $member->gender ?? 'Not specified' }}</td>
                    </tr>
                    <tr>
                        <th>Date of Birth</th>
                        <td>{{ $member->dob ? date('d-m-Y', strtotime($member->dob)) : 'Not specified' }}</td>
                    </tr>
                    <tr>
                        <th>Age</th>
                        <td>{{ $member->age ?? 'Not specified' }}</td>
                    </tr>
                    <tr>
                        <th>Emergency Contact</th>
                        <td>{{ $member->emergency_contact ?? 'Not specified' }}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{{ $member->address ?? 'Not specified' }}</td>
                    </tr>
                </table>

                <!-- ========================================== -->
                <!-- FITNESS INFORMATION                        -->
                <!-- ========================================== -->
                <div class="section-title mt-3">
                    <i class="fas fa-heartbeat"></i> Fitness Information
                </div>

                <table class="details-table">
                    <tr>
                        <th>Height</th>
                        <td>{{ $member->height ?? 'Not specified' }} cm</td>
                    </tr>
                    <tr>
                        <th>Weight</th>
                        <td>{{ $member->weight ?? 'Not specified' }} kg</td>
                    </tr>
                    <tr>
                        <th>BMI</th>
                        <td>
                            @if ($member->bmi)
                                <span class="badge-custom info">{{ $member->bmi }}</span>
                            @else
                                Not calculated
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Goal Type</th>
                        <td>{{ $member->goal_type ?? 'Fitness' }}</td>
                    </tr>
                    <tr>
                        <th>Medical Issues</th>
                        <td>{{ $member->medical_issues ?? 'None' }}</td>
                    </tr>
                </table>

                <!-- ========================================== -->
                <!-- MEMBERSHIP INFORMATION - UPDATED           -->
                <!-- ========================================== -->
                <div class="section-title mt-3">
                    <i class="fas fa-id-card"></i> Membership Information
                </div>

                <table class="details-table">
                    <tr>
                        <th>Plan Type</th>
                        <td>
                            @if ($member->plan_type == 'membership')
                                <span class="badge-custom primary"><i class="fas fa-id-card"></i> Membership</span>
                            @elseif($member->plan_type == 'package')
                                <span class="badge-custom success"><i class="fas fa-box"></i> Package</span>
                            @elseif($member->plan_type == 'monthly')
                                <span class="badge-custom warning"><i class="fas fa-calendar-alt"></i> Monthly</span>
                            @else
                                <span class="badge-custom secondary">Not Selected</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Membership / Package / Plan Name</th>
                        <td>
                            @if ($member->membership_plan)
                                <span class="badge-custom info">{{ $member->membership_plan }}</span>
                            @else
                                <span class="badge-custom secondary">Not Selected</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Duration</th>
                        <td>{{ $member->membership_duration ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Final Price</th>
                        <td><strong>₹ {{ number_format($member->final_price ?? 0, 2) }}</strong></td>
                    </tr>
                    <tr>
                        <th>Join Date</th>
                        <td>{{ date('d-m-Y', strtotime($member->join_date)) }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if ($member->status == 'Active')
                                <span class="badge-custom success"><i class="fas fa-check-circle"></i> Active</span>
                            @else
                                <span class="badge-custom warning"><i class="fas fa-times-circle"></i> Inactive</span>
                            @endif
                        </td>
                    </tr>
                </table>

                <!-- ========================================== -->
                <!-- PAYMENT INFORMATION                        -->
                <!-- ========================================== -->
                <div class="section-title mt-3">
                    <i class="fas fa-credit-card"></i> Payment Information
                </div>

                <table class="details-table">
                    <tr>
                        <th>Payment Type</th>
                        <td>
                            @if($member->payment_type == 'hand')
                                <span class="badge-custom primary"><i class="fas fa-hand-holding-usd"></i> Hand Payment</span>
                            @elseif($member->payment_type == 'online')
                                <span class="badge-custom success"><i class="fas fa-wifi"></i> Online Payment</span>
                            @else
                                <span class="badge-custom secondary">Not specified</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Transaction ID</th>
                        <td>{{ $member->transaction_id ?? 'Not specified' }}</td>
                    </tr>
                    <tr>
                        <th>Payment Screenshot</th>
                        <td>
                            @if($member->payment_screenshot)
                                <a href="{{ asset('storage/' . $member->payment_screenshot) }}" target="_blank" class="btn-primary" style="padding:4px 12px; font-size:12px;">
                                    <i class="fas fa-eye"></i> View Screenshot
                                </a>
                            @else
                                <span class="badge-custom secondary">No screenshot uploaded</span>
                            @endif
                        </td>
                    </tr>
                </table>

                <!-- ========================================== -->
                <!-- ASSIGNMENT INFORMATION                     -->
                <!-- ========================================== -->
                <div class="section-title mt-3">
                    <i class="fas fa-user-tag"></i> Assignment Information
                </div>

                <table class="details-table">
                    <tr>
                        <th>Assigned Trainer</th>
                        <td>
                            @if ($member->trainer)
                                <span class="badge-custom info">
                                    <i class="fas fa-chalkboard-user"></i> {{ $member->trainer->name }}
                                    <small
                                        style="font-weight:400; opacity:0.7;">({{ $member->trainer->specialization }})</small>
                                </span>
                            @else
                                <span class="badge-custom secondary">Not Assigned</span>
                            @endif
                        </td>
                    </tr>
                </table>

                <!-- ========================================== -->
                <!-- SYSTEM INFORMATION                         -->
                <!-- ========================================== -->
                <div class="section-title mt-3">
                    <i class="fas fa-clock"></i> System Information
                </div>

                <table class="details-table">
                    <tr>
                        <th>Created At</th>
                        <td>{{ $member->created_at ? $member->created_at->format('d-m-Y h:i A') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Updated At</th>
                        <td>{{ $member->updated_at ? $member->updated_at->format('d-m-Y h:i A') : '-' }}</td>
                    </tr>
                </table>

  <tr>
    <th>Expiry Date</th>
    <td>
        @if($member->expiry_date)
            {{ date('d-m-Y', strtotime($member->expiry_date)) }}
            @if(now()->gt($member->expiry_date))
                <span class="badge-custom warning"><i class="fas fa-times-circle"></i> Expired</span>
            @else
                @php
                    // ✅ FIX: Whole number only
                    $daysLeft = floor(now()->diffInDays($member->expiry_date));
                @endphp
                <span class="badge-custom success"><i class="fas fa-clock"></i> {{ $daysLeft }} days left</span>
            @endif
        @else
            <span class="badge-custom secondary">No expiry set</span>
        @endif
    </td>
</tr>

                <!-- ========================================== -->
                <!-- FORM ACTIONS                              -->
                <!-- ========================================== -->
                <div class="form-actions">
                    <a href="{{ route('admin.members') }}" class="btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                    <a href="{{ route('admin.member.edit', $member->id) }}" class="btn-warning">
                        <i class="fas fa-edit"></i> Edit Member
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection