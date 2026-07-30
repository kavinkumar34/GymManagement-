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

        .edit-card {
            background: #ffffff;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            border: 1px solid rgba(0, 0, 0, 0.04);
            overflow: hidden;
            max-width: 900px;
            margin: 0 auto;
        }

        .edit-card .card-header {
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

        .edit-card .card-header h4 {
            margin: 0;
            font-weight: 600;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .edit-card .card-header h4 i {
            color: #4a9eff;
        }

        .edit-card .card-header small {
            font-size: 12px;
            opacity: 0.8;
            font-weight: 400;
        }

        .edit-card .card-body {
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

        select.form-control {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236c757d' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 36px;
            cursor: pointer;
            color: #1a1a2e !important;
            background-color: #ffffff !important;
        }

        select.form-control option {
            padding: 8px 12px;
            color: #1a1a2e !important;
            background: #ffffff !important;
        }

        select.form-control option:hover,
        select.form-control option:focus {
            background: #e8f4fd !important;
            color: #1a1a2e !important;
        }

        select.form-control option:checked {
            background: #d4e8fc !important;
            color: #1a1a2e !important;
        }

        .file-input-wrapper {
            position: relative;
            height: 38px;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .file-input-wrapper .file-input-container {
            position: relative;
            flex: 1;
            height: 38px;
            min-width: 150px;
        }

        .file-input-wrapper input[type="file"] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
            z-index: 2;
        }

        .file-input-wrapper .file-label {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 7px 14px;
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            background: #ffffff;
            font-size: 13px;
            color: var(--gray);
            height: 38px;
            transition: all 0.3s;
            position: relative;
            z-index: 1;
            cursor: pointer;
            white-space: nowrap;
        }

        .file-input-wrapper .file-label i {
            color: var(--primary);
            font-size: 14px;
        }

        .file-input-wrapper .file-label:hover {
            border-color: var(--primary);
            background: #f8f9fa;
        }

        .file-input-wrapper .file-name {
            font-size: 13px;
            color: var(--dark);
            padding: 0 8px;
            flex: 1;
            min-width: 60px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .file-input-wrapper .file-name .no-file {
            color: var(--gray);
            font-style: italic;
        }

        .file-input-wrapper .file-name .selected-file {
            color: var(--primary);
            font-weight: 500;
        }

        .current-image {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 8px;
            padding: 8px 12px;
            background: var(--light-gray);
            border-radius: var(--radius);
            border: 1px solid var(--border-color);
        }

        .current-image img {
            width: 150px;
            height: 90px;
            border-radius: var(--radius);
            object-fit: cover;
            border: 2px solid var(--border-color);
        }

        .current-image .image-label {
            font-size: 12px;
            color: var(--gray);
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

        @media (max-width: 768px) {
            .admin-main-content {
                padding: 12px 15px;
            }

            .edit-card .card-header {
                padding: 12px 16px;
                flex-direction: column;
                align-items: flex-start;
            }

            .edit-card .card-header h4 {
                font-size: 16px;
            }

            .edit-card .card-body {
                padding: 14px 16px;
            }

            .form-actions {
                flex-direction: column;
            }

            .form-actions .btn {
                width: 100%;
                justify-content: center;
            }

            .file-input-wrapper {
                flex-wrap: wrap;
                height: auto;
            }

            .file-input-wrapper .file-input-container {
                flex: 1;
                min-width: 150px;
            }

            .file-input-wrapper .file-name {
                font-size: 12px;
                min-width: 50px;
            }

            .current-image img {
                width: 120px;
                height: 70px;
            }
        }

        @media (max-width: 576px) {
            .edit-card .card-header h4 {
                font-size: 14px;
            }

            .edit-card .card-body {
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

            .file-input-wrapper .file-label {
                font-size: 12px;
                padding: 5px 10px;
                height: 34px;
            }

            .file-input-wrapper .file-name {
                font-size: 11px;
            }

            .current-image img {
                width: 100px;
                height: 60px;
            }
        }
    </style>

    <div class="admin-main-content">
        <div class="edit-card">
            <div class="card-header">
                <div>
                    <h4><i class="fas fa-edit"></i> Edit Banner</h4>
                    <small>Update banner details</small>
                </div>
                <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary"
                    style="background:#f0f4f8; color:var(--gray); border:1px solid var(--border-color); padding:6px 16px; border-radius:10px; text-decoration:none; display:inline-flex; align-items:center; gap:6px; font-weight:500; font-size:12px; transition:all 0.3s;">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('admin.banners.update', $banner->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="section-title">
                        <i class="fas fa-image"></i> Banner Details
                    </div>

                    <div class="row compact-row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Current Image</label>
                            @if ($banner->image)
                                <div class="current-image">
                                    <img src="{{ Storage::url($banner->image) }}" alt="Banner">
                                    <span class="image-label"><i class="fas fa-check-circle text-success"></i> Current
                                        Image</span>
                                </div>
                            @endif
                            <div class="file-input-wrapper">
                                <div class="file-input-container">
                                    <div class="file-label">
                                        <i class="fas fa-image"></i>
                                        <span>Choose new image</span>
                                    </div>
                                    <input type="file" name="image" id="image"
                                        accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                                        onchange="updateFileName()">
                                </div>
                                <span class="file-name" id="fileNameDisplay">
                                    <span class="no-file">No file chosen</span>
                                </span>
                            </div>
                            <small class="text-muted-sm">Leave empty to keep current image (Max: 5MB)</small>
                        </div>
                    </div>

                    <div class="row compact-row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Link URL</label>
                            <input type="url" name="link" class="form-control" value="{{ $banner->link }}"
                                placeholder="https://example.com">
                            <small class="text-muted-sm">Optional - where the banner should link to</small>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Display Order</label>
                            <input type="number" name="order" class="form-control" value="{{ $banner->order }}">
                            <small class="text-muted-sm">Lower number = Higher priority</small>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="Active" {{ $banner->status == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ $banner->status == 'Inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Update Banner
                        </button>
                        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        function updateFileName() {
            var input = document.getElementById('image');
            var display = document.getElementById('fileNameDisplay');

            if (input.files && input.files.length > 0) {
                var fileName = input.files[0].name;
                if (fileName.length > 30) {
                    fileName = fileName.substring(0, 27) + '...';
                }
                display.innerHTML =
                    '<span class="selected-file"><i class="fas fa-check-circle" style="color:#4caf50;"></i> ' + fileName +
                    '</span>';
            } else {
                display.innerHTML = '<span class="no-file">No file chosen</span>';
            }
        }
    </script>
@endsection
