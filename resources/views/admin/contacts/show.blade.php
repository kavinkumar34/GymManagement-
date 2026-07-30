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

    .show-card {
        background: #ffffff;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow);
        border: 1px solid rgba(0,0,0,0.04);
        overflow: hidden;
        max-width: 900px;
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
        width: 30%;
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

    .details-table td .badge-custom.pending {
        background: #fef3c7;
        color: #92400e;
    }

    .details-table td .badge-custom.read {
        background: #e3f2fd;
        color: #1565c0;
    }

    .details-table td .badge-custom .dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        display: inline-block;
    }

    .details-table td .badge-custom.pending .dot {
        background: #ffa726;
    }

    .details-table td .badge-custom.read .dot {
        background: #4a9eff;
    }

    .message-box {
        background: var(--light-gray);
        padding: 16px 20px;
        border-radius: var(--radius);
        border: 1px solid var(--border-color);
        font-size: 14px;
        line-height: 1.8;
        color: var(--dark);
        min-height: 100px;
    }

    .status-select {
        padding: 5px 12px;
        border: 1px solid var(--border-color);
        border-radius: var(--radius);
        font-size: 13px;
        background: #fff;
        height: 34px;
        min-width: 120px;
        transition: all 0.3s;
        color: var(--dark);
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236c757d' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        padding-right: 30px;
    }

    .status-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(74, 158, 255, 0.12);
        outline: none;
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
        text-decoration: none;
    }

    .btn-success:hover {
        background: #388e3c;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(76, 175, 80, 0.35);
    }

    .btn-danger {
        background: #ef5350;
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

    .btn-danger:hover {
        background: #c62828;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(239, 83, 80, 0.35);
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
    /* CUSTOM DELETE MODAL                         */
    /* ============================================ */
    .delete-modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.25);
        backdrop-filter: blur(2px);
        z-index: 9999;
        align-items: flex-start;
        justify-content: flex-end;
        padding: 25px 30px;
        animation: fadeIn 0.25s ease;
    }

    .delete-modal-overlay.active {
        display: flex;
    }

    .delete-modal {
        background: #ffffff;
        border-radius: var(--radius-lg);
        padding: 16px 20px 18px;
        max-width: 280px;
        width: 100%;
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        animation: slideDownModal 0.3s ease;
        border: 1px solid rgba(0,0,0,0.04);
    }

    @keyframes slideDownModal {
        from { opacity: 0; transform: translateY(-20px) scale(0.95); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .delete-modal .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 4px;
    }

    .delete-modal .modal-header h4 {
        font-size: 14px;
        font-weight: 600;
        color: var(--dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .delete-modal .modal-header h4 i {
        color: #ef5350;
        font-size: 14px;
    }

    .delete-modal .modal-close {
        background: none;
        border: none;
        font-size: 16px;
        color: var(--gray);
        cursor: pointer;
        padding: 0 4px;
        transition: all 0.3s;
        line-height: 1;
    }

    .delete-modal .modal-close:hover {
        color: var(--dark);
        transform: rotate(90deg);
    }

    .delete-modal .modal-body {
        font-size: 12px;
        color: var(--gray);
        line-height: 1.5;
        margin-bottom: 12px;
        padding-left: 2px;
    }

    .delete-modal .modal-body .warning-text {
        color: #ef5350;
        font-weight: 500;
        font-size: 11px;
        display: block;
        margin-top: 2px;
    }

    .delete-modal .modal-body .warning-text i {
        font-size: 10px;
        margin-right: 3px;
    }

    .delete-modal .modal-actions {
        display: flex;
        gap: 6px;
        justify-content: flex-end;
    }

    .delete-modal .modal-actions .btn-modal {
        padding: 5px 14px;
        border: none;
        border-radius: var(--radius);
        font-size: 11px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .delete-modal .modal-actions .btn-modal.cancel {
        background: #f0f4f8;
        color: var(--gray);
    }

    .delete-modal .modal-actions .btn-modal.cancel:hover {
        background: #e9ecef;
    }

    .delete-modal .modal-actions .btn-modal.confirm {
        background: #ef5350;
        color: #fff;
    }

    .delete-modal .modal-actions .btn-modal.confirm:hover {
        background: #c62828;
        transform: translateY(-1px);
        box-shadow: 0 3px 12px rgba(239, 83, 80, 0.3);
    }

    @media (max-width: 768px) {
        .admin-main-content { padding: 12px 15px; }
        .show-card .card-header { padding: 12px 16px; flex-direction: column; align-items: flex-start; }
        .show-card .card-header h4 { font-size: 16px; }
        .show-card .card-body { padding: 14px 16px; }
        .details-table { font-size: 12px; }
        .details-table th, .details-table td { padding: 8px 12px; }
        .form-actions { flex-direction: column; }
        .form-actions .btn { width: 100%; justify-content: center; }
        .delete-modal-overlay { padding: 16px; align-items: flex-start; }
        .delete-modal { max-width: 260px; padding: 14px 16px 16px; }
        .delete-modal .modal-header h4 { font-size: 13px; }
        .delete-modal .modal-body { font-size: 11px; }
        .delete-modal .modal-actions .btn-modal { padding: 4px 12px; font-size: 10px; }
        .message-box { font-size: 13px; padding: 14px 16px; }
    }

    @media (max-width: 576px) {
        .show-card .card-header h4 { font-size: 14px; }
        .show-card .card-body { padding: 10px 12px; }
        .details-table { font-size: 11px; }
        .details-table th, .details-table td { padding: 6px 10px; font-size: 11px; }
        .details-table th { font-size: 10px; }
        .section-title { font-size: 12px; padding: 6px 12px; }
        .btn-success, .btn-danger, .btn-secondary { padding: 7px 16px; font-size: 12px; }
        .status-select { font-size: 12px; height: 30px; min-width: 100px; }
        .message-box { font-size: 12px; padding: 12px 14px; min-height: 80px; }
        .delete-modal-overlay { padding: 12px; }
        .delete-modal { max-width: 240px; padding: 12px 14px 14px; }
        .delete-modal .modal-header h4 { font-size: 12px; }
        .delete-modal .modal-body { font-size: 10px; margin-bottom: 10px; }
        .delete-modal .modal-actions .btn-modal { padding: 4px 10px; font-size: 10px; }
    }
</style>

<div class="admin-main-content">
    <div class="show-card">
        <div class="card-header">
            <div>
                <h4><i class="fas fa-envelope"></i> Message Details</h4>
                <small>View complete message</small>
            </div>
            <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary" style="background:#f0f4f8; color:var(--gray); border:1px solid var(--border-color); padding:6px 16px; border-radius:10px; text-decoration:none; display:inline-flex; align-items:center; gap:6px; font-weight:500; font-size:12px; transition:all 0.3s;">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>

        <div class="card-body">
            <!-- ========================================== -->
            <!-- MESSAGE DETAILS                            -->
            <!-- ========================================== -->
            <div class="section-title">
                <i class="fas fa-info-circle"></i> Message Information
            </div>

            <table class="details-table">
                <tr>
                    <th>Name</th>
                    <td><strong>{{ $contact->name }}</strong></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><a href="mailto:{{ $contact->email }}" style="color:var(--primary); text-decoration:none;">{{ $contact->email }}</a></td>
                </tr>
                <tr>
                    <th>Subject</th>
                    <td>{{ $contact->subject }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <form method="POST" action="{{ route('admin.contacts.status', $contact->id) }}" style="display: inline-flex; align-items:center; gap:8px;">
                            @csrf
                            <select name="status" onchange="this.form.submit()" class="status-select">
                                <option value="Pending" {{ $contact->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Read" {{ $contact->status == 'Read' ? 'selected' : '' }}>Read</option>
                            </select>
                            <span class="badge-custom {{ strtolower($contact->status) }}">
                                <span class="dot"></span> {{ $contact->status }}
                            </span>
                        </form>
                    </td>
                </tr>
                <tr>
                    <th>Received</th>
                    <td>{{ $contact->created_at->format('d M Y, h:i A') }}</td>
                </tr>
            </table>

            <!-- ========================================== -->
            <!-- MESSAGE CONTENT                            -->
            <!-- ========================================== -->
            <div class="section-title mt-3">
                <i class="fas fa-envelope-open-text"></i> Message Content
            </div>

            <div class="message-box">
                {{ $contact->message }}
            </div>

            <!-- ========================================== -->
            <!-- FORM ACTIONS                              -->
            <!-- ========================================== -->
            <div class="form-actions">
                <a href="mailto:{{ $contact->email }}" class="btn btn-success" onclick="updateStatus({{ $contact->id }})">
                    <i class="fas fa-reply"></i> update
                </a>
                <button type="button" class="btn btn-danger" onclick="openDeleteModal({{ $contact->id }})">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </div>

        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- CUSTOM DELETE MODAL                       -->
<!-- ========================================== -->
<div class="delete-modal-overlay" id="deleteModal">
    <div class="delete-modal">
        <div class="modal-header">
            <h4><i class="fas fa-trash-alt"></i> Confirm Delete</h4>
            <button class="modal-close" onclick="closeDeleteModal()">&times;</button>
        </div>
        <div class="modal-body">
            Are you sure you want to delete this message?
            <span class="warning-text"><i class="fas fa-exclamation-triangle"></i> This action cannot be undone.</span>
        </div>
        <div class="modal-actions">
            <button class="btn-modal cancel" onclick="closeDeleteModal()">
                <i class="fas fa-times"></i> Cancel
            </button>
            <button class="btn-modal confirm" id="confirmDeleteBtn">
                <i class="fas fa-trash"></i> Delete
            </button>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- DELETE FORM                               -->
<!-- ========================================== -->
<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- ========================================== -->
<!-- STATUS FORM                               -->
<!-- ========================================== -->
<form id="status-form" method="POST" style="display: none;">
    @csrf
</form>

<!-- ========================================== -->
<!-- SCRIPTS                                    -->
<!-- ========================================== -->
<script>
// ============================================
// DELETE MODAL FUNCTIONS
// ============================================
var deleteId = null;

function openDeleteModal(id) {
    deleteId = id;
    document.getElementById('deleteModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('active');
    document.body.style.overflow = '';
    deleteId = null;
}

document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
    if (deleteId) {
        let form = document.getElementById('delete-form');
        form.action = '/admin/contacts/' + deleteId;
        form.submit();
    }
});

document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDeleteModal();
    }
});

// ============================================
// UPDATE STATUS ON REPLY
// ============================================
function updateStatus(id) {
    let form = document.getElementById('status-form');
    form.action = '/admin/contacts/' + id + '/status';
    
    let input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'status';
    input.value = 'Read';
    form.appendChild(input);
    
    form.submit();
}
</script>

@endsection