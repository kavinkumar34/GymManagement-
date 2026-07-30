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
        --shadow: 0 2px 20px rgba(0,0,0,0.05);
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
    .settings-card {
        background: #ffffff;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow);
        border: 1px solid rgba(0,0,0,0.04);
        overflow: hidden;
        max-width: 900px;
        margin: 0 auto;
    }

    .settings-card .card-header {
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

    .settings-card .card-header h4 {
        margin: 0;
        font-weight: 600;
        font-size: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .settings-card .card-header h4 i {
        color: #4a9eff;
    }

    .settings-card .card-header small {
        font-size: 12px;
        opacity: 0.8;
        font-weight: 400;
    }

    .settings-card .card-body {
        padding: 20px 24px;
    }

    /* ============================================ */
    /* SECTION TITLE                               */
    /* ============================================ */
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

    /* ============================================ */
    /* FORM STYLES                                 */
    /* ============================================ */
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

    .input-group-text {
        background: var(--light-gray);
        border: 1px solid var(--border-color);
        border-right: none;
        color: var(--gray);
        font-size: 14px;
        border-radius: var(--radius) 0 0 var(--radius);
        padding: 0 14px;
        height: 38px;
    }

    .input-group .form-control {
        border-radius: 0 var(--radius) var(--radius) 0;
    }

    .text-muted-sm {
        font-size: 11px;
        color: var(--gray);
        display: block;
        margin-top: 3px;
    }

    .compact-row {
        margin-bottom: 0;
    }

    .compact-row .mb-3 {
        margin-bottom: 10px !important;
    }

    /* ============================================ */
    /* ICON PREVIEW                                */
    /* ============================================ */
    .icon-preview {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 4px 14px;
        background: #e3f2fd;
        border-radius: 50px;
        font-size: 13px;
        color: #1565c0;
        margin-top: 4px;
    }

    .icon-preview i {
        font-size: 18px;
    }

    /* ============================================ */
    /* BUTTON STYLES                               */
    /* ============================================ */
    .btn-save {
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
        cursor: pointer;
    }

    .btn-save:hover {
        background: #388e3c;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(76, 175, 80, 0.35);
    }

    .btn-preview {
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
        cursor: pointer;
    }

    .btn-preview:hover {
        background: #e9ecef;
        color: var(--dark);
        transform: translateY(-2px);
    }

    .form-actions {
        padding-top: 16px;
        border-top: 1px solid var(--border-color);
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 10px;
    }

    /* ============================================ */
    /* CUSTOM TOAST NOTIFICATIONS                  */
    /* ============================================ */
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
        padding: 16px 20px;
        border-radius: var(--radius-lg);
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        display: flex;
        align-items: flex-start;
        gap: 12px;
        opacity: 0;
        transform: translateX(100%);
        transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        font-size: 14px;
        font-weight: 500;
        border: 1px solid #e2e8f0;
        position: relative;
        border-left: 5px solid var(--success);
    }

    .custom-toast.show {
        opacity: 1;
        transform: translateX(0);
    }

    .custom-toast.success {
        border-left-color: #10b981;
    }

    .custom-toast.error {
        border-left-color: #ef4444;
    }

    .custom-toast .toast-icon {
        font-size: 20px;
        margin-top: 2px;
        flex-shrink: 0;
    }

    .custom-toast.success .toast-icon {
        color: #10b981;
    }

    .custom-toast.error .toast-icon {
        color: #ef4444;
    }

    .custom-toast .toast-content {
        flex: 1;
    }

    .custom-toast .toast-title {
        font-weight: 700;
        font-size: 14px;
        color: #0f172a;
        margin-bottom: 2px;
    }

    .custom-toast .toast-message {
        font-size: 13px;
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
        border-radius: 0 0 var(--radius-lg) var(--radius-lg);
        animation: progressBar 3s linear forwards;
        width: 100%;
    }

    .custom-toast.error .toast-progress {
        background: #ef4444;
    }

    @keyframes progressBar {
        0% { width: 100%; }
        100% { width: 0%; }
    }

    /* ============================================ */
    /* RESPONSIVE                                  */
    /* ============================================ */
    @media (max-width: 768px) {
        .admin-main-content {
            padding: 12px 15px;
        }

        .settings-card .card-header {
            padding: 12px 16px;
            flex-direction: column;
            align-items: flex-start;
        }

        .settings-card .card-header h4 {
            font-size: 16px;
        }

        .settings-card .card-body {
            padding: 14px 16px;
        }

        .form-actions {
            flex-direction: column;
        }

        .form-actions .btn {
            width: 100%;
            justify-content: center;
        }

        .custom-toast-container {
            top: 15px;
            right: 15px;
            max-width: calc(100% - 30px);
        }

        .custom-toast {
            padding: 14px 16px;
            font-size: 13px;
        }
    }

    @media (max-width: 576px) {
        .settings-card .card-header h4 {
            font-size: 14px;
        }

        .settings-card .card-body {
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

        .btn-save,
        .btn-preview {
            padding: 7px 16px;
            font-size: 12px;
        }

        .input-group-text {
            font-size: 12px;
            height: 34px;
            padding: 0 10px;
        }

        .custom-toast-container {
            top: 10px;
            right: 10px;
            max-width: calc(100% - 20px);
        }

        .custom-toast {
            padding: 12px 14px;
            font-size: 12px;
        }

        .custom-toast .toast-title {
            font-size: 13px;
        }

        .custom-toast .toast-message {
            font-size: 12px;
        }
    }
</style>

<!-- ============================================ -->
<!-- TOAST CONTAINER                             -->
<!-- ============================================ -->
<div class="custom-toast-container" id="toastContainer">
    @if(session('success'))
        <div class="custom-toast success show" id="settingsToast">
            <i class="fas fa-check-circle toast-icon"></i>
            <div class="toast-content">
                <div class="toast-title">Success!</div>
                <p class="toast-message">{{ session('success') }}</p>
            </div>
            <button class="toast-close" onclick="this.closest('.custom-toast').remove();">&times;</button>
            <div class="toast-progress"></div>
        </div>
    @endif

    @if(session('error'))
        <div class="custom-toast error show" id="settingsToast">
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

<!-- ============================================ -->
<!-- MAIN CONTENT                                -->
<!-- ============================================ -->
<div class="admin-main-content">
    <div class="settings-card">
        <!-- Card Header -->
        <div class="card-header">
            <div>
                <h4><i class="fas fa-cog"></i> Company Settings</h4>
                <small>Manage your company branding</small>
            </div>
            <span style="background:rgba(74,158,255,0.2); color:#8ab4f8; padding:3px 12px; border-radius:50px; font-size:11px;">
                <i class="fas fa-circle" style="font-size:6px; color:#4caf50;"></i> Settings
            </span>
        </div>

        <!-- Card Body -->
        <div class="card-body">
            <form method="POST" action="{{ route('admin.settings.update') }}">
                @csrf

                <!-- ========================================== -->
                <!-- SETTINGS SECTION                          -->
                <!-- ========================================== -->
                <div class="section-title">
                    <i class="fas fa-paint-brush"></i> Branding Settings
                </div>

                <div class="row compact-row">
                    <!-- Company Name -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Company Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-building"></i></span>
                            <input type="text" name="company_name" class="form-control" value="{{ $settings['company_name'] ?? '' }}" required>
                        </div>
                        <small class="text-muted-sm">This name appears in the navbar</small>
                    </div>

                    <!-- Company Logo Icon -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Company Logo Icon</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-code"></i></span>
                            <input type="text" name="company_logo" class="form-control" value="{{ $settings['company_logo'] ?? 'fas fa-dumbbell' }}" placeholder="fas fa-dumbbell">
                        </div>
                        <small class="text-muted-sm">Font Awesome icon class (e.g., fas fa-dumbbell, fas fa-heart)</small>
                        <div class="icon-preview">
                            <i class="{{ $settings['company_logo'] ?? 'fas fa-dumbbell' }}"></i>
                            <span>Preview</span>
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- FORM ACTIONS                              -->
                <!-- ========================================== -->
                <div class="form-actions">
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i> Save Settings
                    </button>
                    <button type="button" class="btn-preview" onclick="window.location.reload();">
                        <i class="fas fa-eye"></i> Preview
                    </button>
                </div>

            </form>

            <hr class="mt-4">

            <!-- ========================================== -->
            <!-- FOOTER INFO                                -->
            <!-- ========================================== -->
            <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; font-size:13px; color:var(--gray);">
                <div>
                    <i class="fas fa-info-circle" style="color:var(--primary);"></i>
                    <span>Current settings are applied instantly</span>
                </div>
                <div>
                    <span class="badge" style="background:#e8f5e9; color:#2e7d32; padding:4px 12px; border-radius:50px; font-size:11px;">
                        <i class="fas fa-check-circle"></i> Live
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- SCRIPTS                                     -->
<!-- ============================================ -->
<script>
// ============================================
// AUTO-HIDE TOAST AFTER 3 SECONDS
// ============================================
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

// ============================================
// LIVE ICON PREVIEW
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    const iconInput = document.querySelector('input[name="company_logo"]');
    const previewIcon = document.querySelector('.icon-preview i');

    if (iconInput && previewIcon) {
        iconInput.addEventListener('input', function() {
            const value = this.value.trim();
            if (value) {
                previewIcon.className = value;
            } else {
                previewIcon.className = 'fas fa-dumbbell';
            }
        });
    }
});
</script>

@endsection