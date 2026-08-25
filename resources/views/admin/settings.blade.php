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

    .settings-card {
        background: #ffffff;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow);
        border: 1px solid rgba(0,0,0,0.04);
        overflow: hidden;
        max-width: 1000px;
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
    /* LOGO UPLOAD SECTION                         */
    /* ============================================ */
    .logo-upload-wrapper {
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
        padding: 10px 0;
    }

    .logo-preview-box {
        width: 80px;
        height: 80px;
        border-radius: var(--radius);
        border: 2px dashed var(--border-color);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background: var(--light-gray);
        flex-shrink: 0;
        transition: all 0.3s;
        position: relative;
    }

    .logo-preview-box:hover {
        border-color: var(--primary);
    }

    .logo-preview-box img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 8px;
    }

    .logo-preview-box .no-logo {
        font-size: 32px;
        color: var(--gray);
        opacity: 0.5;
    }

    .logo-preview-box .logo-preview-icon {
        font-size: 40px;
        color: var(--gray);
    }

    .logo-upload-controls {
        flex: 1;
        min-width: 200px;
    }

    .logo-upload-controls .file-input-wrapper {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        align-items: center;
    }

    .logo-upload-controls .file-input-wrapper .custom-file-upload {
        background: var(--primary);
        color: white;
        padding: 8px 18px;
        border-radius: var(--radius);
        cursor: pointer;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
    }

    .logo-upload-controls .file-input-wrapper .custom-file-upload:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(74, 158, 255, 0.3);
    }

    .logo-upload-controls .file-input-wrapper .btn-remove-logo {
        background: var(--danger);
        color: white;
        padding: 8px 18px;
        border-radius: var(--radius);
        cursor: pointer;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
    }

    .logo-upload-controls .file-input-wrapper .btn-remove-logo:hover {
        background: #c62828;
        transform: translateY(-2px);
    }

    .logo-upload-controls .file-input-wrapper input[type="file"] {
        display: none;
    }

    .logo-upload-controls .file-name {
        font-size: 12px;
        color: var(--gray);
        margin-top: 5px;
    }

    .logo-upload-controls .file-name i {
        margin-right: 4px;
    }

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

    /* Footer Fields */
    .footer-field-group {
        background: var(--light-gray);
        border-radius: var(--radius);
        padding: 16px;
        margin-bottom: 10px;
        border: 1px solid var(--border-color);
    }

    .footer-field-group .row {
        margin-bottom: 0;
    }

    .footer-field-group .social-field {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .footer-field-group .social-field .social-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        flex-shrink: 0;
        font-size: 14px;
    }

    .social-icon.facebook { background: #1877f2; }
    .social-icon.instagram { background: #e4405f; }
    .social-icon.whatsapp { background: #25d366; }

    /* Toast Styles */
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

        .logo-upload-wrapper {
            flex-direction: column;
            align-items: flex-start;
        }

        .logo-upload-controls .file-input-wrapper {
            flex-direction: column;
            width: 100%;
        }

        .logo-upload-controls .file-input-wrapper .custom-file-upload,
        .logo-upload-controls .file-input-wrapper .btn-remove-logo {
            width: 100%;
            justify-content: center;
        }

        .footer-field-group .social-field {
            flex-wrap: wrap;
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

        .logo-preview-box {
            width: 60px;
            height: 60px;
        }

        .logo-preview-box .no-logo {
            font-size: 24px;
        }
    }
</style>

<!-- TOAST CONTAINER -->
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

<!-- MAIN CONTENT -->
<div class="admin-main-content">
    <div class="settings-card">
        <div class="card-header">
            <div>
                <h4><i class="fas fa-cog"></i> Company Settings</h4>
                <small>Manage your company branding and footer details</small>
            </div>
            <span style="background:rgba(74,158,255,0.2); color:#8ab4f8; padding:3px 12px; border-radius:50px; font-size:11px;">
                <i class="fas fa-circle" style="font-size:6px; color:#4caf50;"></i> Settings
            </span>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
                @csrf

                <!-- ===== BRANDING SETTINGS ===== -->
                <div class="section-title">
                    <i class="fas fa-paint-brush"></i> Branding Settings
                </div>

                <div class="row compact-row">
                    <!-- Company Name -->
                    {{--<div class="col-md-6 mb-3">
                        <label class="form-label">Company Name <span class="text-muted" style="font-size:10px; font-weight:400;">(Optional)</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-building"></i></span>
                            <input type="text" name="company_name" class="form-control" value="{{ $settings['company_name'] ?? '' }}" placeholder="Enter company name">
                        </div>
                        <small class="text-muted-sm">Leave empty to use default name</small>
                    </div> --}}

                    <!-- Company Logo -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Company Logo </label>
                        <div class="logo-upload-wrapper">
                            <div class="logo-preview-box" id="logoPreviewBox">
                                @php
                                    $logoValue = $settings['company_logo'] ?? 'fas fa-dumbbell';
                                    $isImage = $logoValue && !str_starts_with($logoValue, 'fa-') && !str_starts_with($logoValue, 'fas fa-') && !str_starts_with($logoValue, 'far fa-') && !str_starts_with($logoValue, 'fab fa-');
                                @endphp
                                @if($isImage && file_exists(public_path($logoValue)))
                                    <img src="{{ asset($logoValue) }}" alt="Company Logo" id="logoPreviewImg" style="display:block; width:100%; height:100%; object-fit:contain;">
                                    <i class="fas fa-image logo-preview-icon" id="logoPreviewIcon" style="display:none;"></i>
                                @else
                                    <i class="{{ $logoValue }} logo-preview-icon" id="logoPreviewIcon"></i>
                                    <img src="" alt="Company Logo" id="logoPreviewImg" style="display:none;">
                                @endif
                            </div>

                            <div class="logo-upload-controls">
                                <div class="file-input-wrapper">
                                    <label class="custom-file-upload" for="logoUpload">
                                        <i class="fas fa-upload"></i> Choose Logo
                                    </label>
                                    <input type="file" id="logoUpload" name="company_logo" accept="image/*" onchange="previewLogo(this)">
                                    <button type="button" class="btn-remove-logo" onclick="removeLogo()">
                                        <i class="fas fa-times"></i> Remove
                                    </button>
                                </div>
                                <div class="file-name" id="logoFileName">
                                    <i class="fas fa-info-circle"></i> PNG, JPG, JPEG (Max 2MB)
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-title mt-4">
                    <i class="fas fa-map-marker-alt"></i> Footer Settings
                </div>

                <!-- ===== FOOTER CONTACT DETAILS ===== -->
                <div class="footer-field-group">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-map-marker-alt text-danger"></i> Address</label>
                            <input type="text" name="footer_address" class="form-control" value="{{ $settings['footer_address'] ?? '' }}" placeholder="Enter address">
                            <small class="text-muted-sm">Company physical address</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-phone-alt text-success"></i> Phone Number</label>
                            <input type="text" name="footer_phone" class="form-control" value="{{ $settings['footer_phone'] ?? '' }}" placeholder="Enter phone number">
                            <small class="text-muted-sm">Contact phone number</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-envelope text-primary"></i> Email</label>
                            <input type="email" name="footer_email" class="form-control" value="{{ $settings['footer_email'] ?? '' }}" placeholder="Enter email address">
                            <small class="text-muted-sm">Contact email address</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fab fa-whatsapp text-success"></i> WhatsApp Number</label>
                            <input type="text" name="footer_whatsapp" class="form-control" value="{{ $settings['footer_whatsapp'] ?? '' }}" placeholder="Enter WhatsApp number">
                            <small class="text-muted-sm">WhatsApp number display</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label"><i class="fas fa-link text-info"></i> WhatsApp Link</label>
                            <input type="url" name="footer_whatsapp_link" class="form-control" value="{{ $settings['footer_whatsapp_link'] ?? '' }}" placeholder="https://wa.me/919025595190?text=Hi">
                            <small class="text-muted-sm">Full WhatsApp link for chat</small>
                        </div>
                    </div>
                </div>

                <!-- ===== SOCIAL MEDIA LINKS ===== -->
                <div class="section-title mt-3">
                    <i class="fas fa-share-alt"></i> Social Media Links
                </div>

                <div class="footer-field-group">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="social-field">
                                <div class="social-icon facebook"><i class="fab fa-facebook-f"></i></div>
                                <div style="flex:1;">
                                    <label class="form-label" style="font-size:11px;">Facebook</label>
                                    <input type="url" name="footer_facebook" class="form-control" value="{{ $settings['footer_facebook'] ?? '#' }}" placeholder="https://facebook.com/yourpage">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="social-field">
                                <div class="social-icon instagram"><i class="fab fa-instagram"></i></div>
                                <div style="flex:1;">
                                    <label class="form-label" style="font-size:11px;">Instagram</label>
                                    <input type="url" name="footer_instagram" class="form-control" value="{{ $settings['footer_instagram'] ?? '#' }}" placeholder="https://instagram.com/yourpage">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="social-field">
                                <div class="social-icon whatsapp"><i class="fab fa-whatsapp"></i></div>
                                <div style="flex:1;">
                                    <label class="form-label" style="font-size:11px;">WhatsApp</label>
                                    <input type="url" name="footer_whatsapp_social" class="form-control" value="{{ $settings['footer_whatsapp_social'] ?? '#' }}" placeholder="https://wa.me/yournumber">
                                </div>
                            </div>
                        </div>
                    </div>
                    <small class="text-muted-sm"><i class="fas fa-info-circle"></i> Enter full URLs for social media links. Leave as '#' to disable.</small>
                </div>

                <!-- ===== FORM ACTIONS ===== -->
                <div class="form-actions">
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i> Save All Settings
                    </button>
                {{--    <button type="button" class="btn-preview" onclick="window.location.reload();">
                        <i class="fas fa-eye"></i> Preview
                    </button> --}}
                </div>

            </form>

            <hr class="mt-4">

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

<script>
// AUTO-HIDE TOAST AFTER 3 SECONDS
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

// LOGO PREVIEW
function previewLogo(input) {
    const file = input.files[0];
    if (!file) return;

    const previewImg = document.getElementById('logoPreviewImg');
    const previewIcon = document.getElementById('logoPreviewIcon');
    const fileName = document.getElementById('logoFileName');

    // Validate file type
    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
    if (!allowedTypes.includes(file.type)) {
        showToast('Please upload a valid image file (PNG, JPG, JPEG, GIF, WEBP)', 'error');
        input.value = '';
        return;
    }

    // Validate file size (2MB)
    if (file.size > 2 * 1024 * 1024) {
        showToast('Image size should be less than 2MB', 'error');
        input.value = '';
        return;
    }

    const reader = new FileReader();
    reader.onload = function(e) {
        // Hide icon, show image
        if (previewIcon) previewIcon.style.display = 'none';
        if (previewImg) {
            previewImg.src = e.target.result;
            previewImg.style.display = 'block';
        }
        // Show file name
        if (fileName) {
            fileName.innerHTML = '<i class="fas fa-check-circle" style="color:#4caf50;"></i> ' + file.name;
        }
    };
    reader.readAsDataURL(file);
}

// REMOVE LOGO
function removeLogo() {
    if (!confirm('Are you sure you want to remove the logo?')) {
        return;
    }

    const previewImg = document.getElementById('logoPreviewImg');
    const previewIcon = document.getElementById('logoPreviewIcon');
    const fileInput = document.getElementById('logoUpload');
    const fileName = document.getElementById('logoFileName');

    // Add hidden input to tell backend to remove logo
    let removeInput = document.querySelector('input[name="remove_logo"]');
    if (!removeInput) {
        removeInput = document.createElement('input');
        removeInput.type = 'hidden';
        removeInput.name = 'remove_logo';
        removeInput.value = '1';
        document.querySelector('form').appendChild(removeInput);
    } else {
        removeInput.value = '1';
    }

    // Clear file input
    if (fileInput) fileInput.value = '';

    // Reset preview - show icon, hide image
    if (previewImg) {
        previewImg.src = '';
        previewImg.style.display = 'none';
    }
    if (previewIcon) {
        previewIcon.style.display = 'block';
        previewIcon.className = 'fas fa-dumbbell logo-preview-icon';
    }

    // Reset file name
    if (fileName) {
        fileName.innerHTML = '<i class="fas fa-info-circle"></i> PNG, JPG, JPEG (Max 2MB)';
    }

    // Submit the form to save the removal
    document.querySelector('form').submit();
}

// CUSTOM TOAST FUNCTION
function showToast(message, type = 'success') {
    const container = document.getElementById('toastContainer');

    const toast = document.createElement('div');
    toast.className = 'custom-toast ' + type + ' show';

    const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
    const title = type === 'success' ? 'Success!' : 'Error!';

    toast.innerHTML = `
        <i class="fas ${icon} toast-icon"></i>
        <div class="toast-content">
            <div class="toast-title">${title}</div>
            <p class="toast-message">${message}</p>
        </div>
        <button class="toast-close" onclick="this.closest('.custom-toast').remove();">&times;</button>
        <div class="toast-progress"></div>
    `;

    container.appendChild(toast);

    setTimeout(function() {
        toast.classList.remove('show');
        setTimeout(function() {
            toast.remove();
        }, 500);
    }, 3000);
}
</script>

@endsection