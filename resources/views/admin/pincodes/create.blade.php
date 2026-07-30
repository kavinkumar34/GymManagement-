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

        .create-card {
            background: #ffffff;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            border: 1px solid rgba(0, 0, 0, 0.04);
            overflow: hidden;
            max-width: 700px;
            margin: 0 auto;
        }

        .create-card .card-header {
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

        .create-card .card-header h4 {
            margin: 0;
            font-weight: 600;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .create-card .card-header h4 i {
            color: #4a9eff;
        }

        .create-card .card-header small {
            font-size: 12px;
            opacity: 0.8;
            font-weight: 400;
        }

        .create-card .card-body {
            padding: 20px 24px;
        }

        .section-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--dark);
            padding: 6px 14px;
            background: var(--light-gray);
            border-radius: var(--radius);
            border-left: 3px solid var(--primary);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title i {
            color: var(--primary);
            font-size: 14px;
        }

        .form-label {
            font-size: 12px;
            font-weight: 500;
            color: var(--dark);
            margin-bottom: 4px;
        }

        .form-label .text-danger {
            color: var(--danger) !important;
        }

        .form-control {
            border-radius: var(--radius);
            border: 1px solid var(--border-color);
            padding: 7px 12px;
            font-size: 13px;
            transition: all 0.3s;
            background: #ffffff;
            height: 38px;
            color: var(--dark);
            width: 100%;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(74, 158, 255, 0.12);
            outline: none;
        }

        .form-check {
            padding-left: 28px;
        }

        .form-check-input {
            width: 18px;
            height: 18px;
            margin-top: 2px;
            cursor: pointer;
            accent-color: var(--primary);
        }

        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .form-check-label {
            font-size: 13px;
            color: var(--dark);
            cursor: pointer;
        }

        .form-check-label i {
            margin-right: 4px;
        }

        .compact-row {
            margin-bottom: 0;
        }

        .compact-row .mb-3 {
            margin-bottom: 10px !important;
        }

        .btn-success {
            background: #4caf50;
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
        }

        .btn-success:hover {
            background: #388e3c;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(76, 175, 80, 0.35);
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
            margin-top: 10px;
        }

        .text-muted-sm {
            font-size: 11px;
            color: var(--gray);
            display: block;
            margin-top: 3px;
        }

        .alert-danger {
            background: #fce4ec;
            color: #c62828;
            border-left: 4px solid #ef5350;
            border-radius: var(--radius);
            padding: 12px 18px;
            margin-bottom: 16px;
            border: none;
        }

        .alert-danger ul {
            margin: 0;
            padding-left: 20px;
        }

        @media (max-width: 768px) {
            .admin-main-content {
                padding: 12px 15px;
            }

            .create-card .card-header {
                padding: 12px 16px;
                flex-direction: column;
                align-items: flex-start;
            }

            .create-card .card-header h4 {
                font-size: 16px;
            }

            .create-card .card-body {
                padding: 14px 16px;
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
            .create-card .card-header h4 {
                font-size: 14px;
            }

            .create-card .card-body {
                padding: 10px 12px;
            }

            .form-label {
                font-size: 11px;
            }

            .form-control {
                font-size: 12px;
                padding: 5px 10px;
                height: 34px;
            }

            .section-title {
                font-size: 12px;
                padding: 5px 10px;
            }

            .btn-success,
            .btn-secondary {
                padding: 7px 16px;
                font-size: 12px;
            }

            .form-check-label {
                font-size: 12px;
            }
        }
    </style>

    <div class="admin-main-content">
        <div class="create-card">
            <div class="card-header">
                <div>
                    <h4><i class="fas fa-plus-circle"></i> Add Deliverable State</h4>
                    <small>Add a new state with shipping charge</small>
                </div>
                <span
                    style="background:rgba(74,158,255,0.2); color:#8ab4f8; padding:3px 12px; border-radius:50px; font-size:11px;">
                    <i class="fas fa-circle" style="font-size:6px; color:#4caf50;"></i> Active Form
                </span>
            </div>

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.pincodes.store') }}" method="POST">
                    @csrf

                    <div class="section-title">
                        <i class="fas fa-truck"></i> State Details
                    </div>

                    <div class="row compact-row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">State Name <span class="text-danger">*</span></label>
                            <input type="text" name="state" class="form-control" value="{{ old('state') }}"
                                placeholder="e.g., Tamil Nadu, Karnataka" required>
                            <small class="text-muted-sm">Enter the full state name</small>
                        </div>
                    </div>

                    <div class="row compact-row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Shipping Charge (₹) <span class="text-danger">*</span></label>
                            <input type="number" name="shipping_charge" class="form-control"
                                value="{{ old('shipping_charge', 0) }}" step="0.01" min="0" max="1000"
                                required>
                            <small class="text-muted-sm">Shipping charge for this state (in INR)</small>
                        </div>
                    </div>

                    <div class="row compact-row">
                        <div class="col-md-12 mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" class="form-check-input" id="isActive"
                                    value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                                <label class="form-check-label" for="isActive">
                                    <i class="fas fa-check-circle text-success"></i> Active (Delivery available)
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Save State
                        </button>
                        <a href="{{ route('admin.pincodes.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
