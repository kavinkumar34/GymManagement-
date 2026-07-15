@extends('layouts.admin-layout')

@section('content')
    <style>
        /* Custom Toast Notification */
        .custom-toast-container {
            position: fixed;
            top: 30px;
            right: 30px;
            z-index: 999999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 420px;
            width: 100%;
        }

        .custom-toast {
            background: #ffffff;
            color: #1e293b;
            padding: 18px 22px;
            border-radius: 14px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: flex-start;
            gap: 14px;
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            font-size: 14px;
            font-weight: 500;
            border: 1px solid #e2e8f0;
            position: relative;
        }

        .custom-toast.show {
            opacity: 1;
            transform: translateX(0);
        }

        .custom-toast-success {
            border-left: 5px solid #10b981;
        }

        .custom-toast-success .toast-icon {
            color: #10b981;
        }

        .custom-toast-error {
            border-left: 5px solid #ef4444;
        }

        .custom-toast-error .toast-icon {
            color: #ef4444;
        }

        .custom-toast .toast-icon {
            font-size: 22px;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .custom-toast .toast-content {
            flex: 1;
        }

        .custom-toast .toast-title {
            font-weight: 700;
            font-size: 15px;
            color: #0f172a;
            margin-bottom: 2px;
        }

        .custom-toast .toast-message {
            font-size: 14px;
            color: #475569;
            font-weight: 400;
            margin: 0;
            line-height: 1.5;
        }

        .custom-toast .toast-close {
            background: none;
            border: none;
            color: #94a3b8;
            font-size: 18px;
            cursor: pointer;
            padding: 0 5px;
            transition: color 0.3s;
            flex-shrink: 0;
            margin-top: -2px;
        }

        .custom-toast .toast-close:hover {
            color: #475569;
        }

        .custom-toast .toast-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background: #10b981;
            border-radius: 0 0 14px 14px;
            animation: progressBar 3s linear forwards;
            width: 100%;
        }

        .custom-toast-error .toast-progress {
            background: #ef4444;
        }

        @keyframes progressBar {
            0% {
                width: 100%;
            }

            100% {
                width: 0%;
            }
        }

        /* Save Button Hover Effect */
        .btn-save-green {
            background: #10b981;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-save-green:hover {
            background: #059669;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
            color: white;
        }

        .btn-save-green i {
            margin-right: 8px;
        }
        .cor{
        background: linear-gradient(180deg, #0d1b2a 0%, #1b3a5c 50%, #0d1b2a 100%);
                color: #ffffff;


}
    </style>

    <!-- Toast Container -->
    <div class="custom-toast-container" id="toastContainer">
        @if (session('success'))
            <div class="custom-toast custom-toast-success show" id="settingsToast">
                <i class="fas fa-check-circle toast-icon"></i>
                <div class="toast-content">
                    <div class="toast-title">Success!</div>
                    <p class="toast-message">{{ session('success') }}</p>
                </div>
                <button class="toast-close" onclick="this.closest('.custom-toast').remove();">&times;</button>
                <div class="toast-progress"></div>
            </div>
        @endif

        @if (session('error'))
            <div class="custom-toast custom-toast-error show" id="settingsToast">
                <i class="fas fa-exclamation-circle toast-icon"></i>
                <div class="toast-content">
                    <div class="toast-title">Error!</div>
                    <p class="toast-message">{{ session('error') }}</p>
                </div>
                <button class="toast-close" onclick="this.closest('.custom-toast').remove();">&times;</button>
                <div class="toast-progress"></div>
            </div>
        @endif
    </div>

    <div class="admin-main-content">
        <div class="container-fluid">
            <div class="card">
                <!-- ===== UPDATED CARD HEADER ===== -->
                <div class="card-header cor"
                    <h4><i class="fas fa-cog"></i> Company Settings</h4>
                    <small style="color: rgba(255,255,255,0.7);">Manage your company branding</small>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.settings.update') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Company Name</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-building"></i></span>
                                    <input type="text" name="company_name" class="form-control"
                                        value="{{ $settings['company_name'] }}" required>
                                </div>
                                <small class="text-muted">This name appears in navbar</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Company Logo Icon</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-code"></i></span>
                                    <input type="text" name="company_logo" class="form-control"
                                        value="{{ $settings['company_logo'] }}" placeholder="fas fa-dumbbell">
                                </div>
                                <small class="text-muted">Font Awesome icon class (e.g., fas fa-dumbbell, fas
                                    fa-heart)</small>
                                <div class="mt-2">
                                    <span class="badge bg-info">Preview: <i
                                            class="{{ $settings['company_logo'] }}"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <!-- ===== UPDATED GREEN SAVE BUTTON ===== -->
                            <button type="submit" class="btn-save-green">
                                <i class="fas fa-save"></i> Save Settings
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="window.location.reload();">
                                <i class="fas fa-eye"></i> Preview
                            </button>
                        </div>
                    </form>

                    <hr class="mt-4">

                  
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-hide toast after 3 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const toast = document.getElementById('settingsToast');
            if (toast) {
                setTimeout(function() {
                    toast.classList.remove('show');
                    setTimeout(function() {
                        toast.remove();
                    }, 500);
                }, 3000);
            }
        });
    </script>
@endsection
