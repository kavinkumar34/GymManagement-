@extends('layouts.app')

@section('content')
<!-- SweetAlert2 CSS & JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* ===== HIDE TOP NAVBAR ONLY ===== */
    nav.navbar, .navbar {
        display: none !important;
    }
        .navbar-spacer {
        display: none !important;
    }
    
    /* Hide WhatsApp float button and tooltip */
    .whatsapp-float, .whatsapp-tooltip {
        display: none !important;
    }
    
    /* Hide footer */
    footer, .footer {
        display: none !important;
    }
    
    /* Keep the admin sidebar visible */
    /* .admin-sidebar is NOT hidden - it stays visible */
    
    /* Reset body and main */
    body {
        margin: 0 !important;
        padding: 0 !important;
        background: #f0f4f8 !important;
        min-height: 100vh;
    }
    
    /* Remove padding from main */
    main.py-4 {
        padding: 0 !important;
        margin: 0 !important;
        min-height: 100vh;
    }
    
    /* Full width container - NO EMPTY SPACE */
    .container {
        margin-left: 270px !important;
        max-width: calc(100% - 270px) !important;
        width: calc(100% - 270px) !important;
        min-height: 100vh;
        padding: 20px 25px 30px 25px !important;
        background: #f0f4f8;
    }
    
    /* Make card full width */
    .card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        overflow: hidden;
        width: 100%;
    }
    
    .table th, .table td {
        vertical-align: middle;
    }
    
    .shipping-amount {
        font-weight: bold;
        color: #10b981;
    }
    
    .select-all-checkbox {
        cursor: pointer;
    }
    
    .bulk-actions-bar {
        background: #f8fafc;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: none;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }
    
    .bulk-actions-bar.show {
        display: flex;
    }
    
    .selected-count {
        background: #3b82f6;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
    }
    
    .bulk-shipping-input {
        width: 120px;
        padding: 6px 10px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
    }
    
    .btn-bulk-update {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border: none;
        padding: 6px 16px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-bulk-update:hover {
        background: linear-gradient(135deg, #059669, #047857);
        color: white;
    }
    
    .btn-bulk-delete {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        border: none;
        padding: 6px 16px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-bulk-delete:hover {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: white;
    }
    
    .btn-bulk-active {
        background: linear-gradient(135deg, #22c55e, #16a34a);
        color: white;
        border: none;
        padding: 6px 16px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-bulk-active:hover {
        background: linear-gradient(135deg, #16a34a, #15803d);
        color: white;
    }
    
    .btn-bulk-inactive {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        border: none;
        padding: 6px 16px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-bulk-inactive:hover {
        background: linear-gradient(135deg, #d97706, #b45309);
        color: white;
    }
    
    .state-checkbox {
        width: 20px;
        height: 20px;
        cursor: pointer;
    }
    
    .card-header {
        background: linear-gradient(135deg, #0d1b2a 0%, #1b3a5c 100%) !important;
        padding: 18px 24px;
        border: none;
    }
    
    .card-header h4 {
        font-size: 1.1rem;
        font-weight: 600;
        color: white;
        margin: 0;
    }
    
    .card-header h4 i {
        color: #4a9eff;
        margin-right: 8px;
    }
    
    .card-header .btn-light {
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.15);
        color: white;
        transition: all 0.3s;
    }
    
    .card-header .btn-light:hover {
        background: rgba(255,255,255,0.2);
        color: white;
    }
    
    .card-header .btn-success {
        background: #10b981;
        border: none;
        color: white;
    }
    
    .card-header .btn-success:hover {
        background: #059669;
        color: white;
    }
    
    .card-body {
        padding: 24px;
        background: #ffffff;
    }
    
    /* ===== TABLE FULL WIDTH ===== */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }
    
    .table {
        margin-bottom: 0;
        width: 100%;
        min-width: 650px;
    }
    
    .table thead th {
        background: #0d1b2a;
        color: white;
        font-weight: 500;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 12px 15px;
        border: none;
        white-space: nowrap;
    }
    
    .table tbody td {
        padding: 12px 15px;
        border-bottom: 1px solid #f1f3f5;
        vertical-align: middle;
    }
    
    .table tbody tr:hover {
        background: #f8fafc;
    }
    
    .table tbody tr:last-child td {
        border-bottom: none;
    }
    
    /* ===== ACTION BUTTONS - HORIZONTAL ===== */
    .action-buttons {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: nowrap;
    }
    
    .btn-sm {
        padding: 4px 10px;
        font-size: 0.75rem;
        border-radius: 6px;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.3s;
        border: none;
    }
    
    .btn-warning {
        background: #f59e0b;
        color: white;
    }
    
    .btn-warning:hover {
        background: #d97706;
        color: white;
    }
    
    .btn-danger {
        background: #ef4444;
        color: white;
    }
    
    .btn-danger:hover {
        background: #dc2626;
        color: white;
    }
    
    .btn-success {
        background: #10b981;
        color: white;
    }
    
    .btn-success:hover {
        background: #059669;
        color: white;
    }
    
    /* ===== TOGGLE SWITCH ===== */
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
        cursor: pointer;
    }
    
    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    
    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: #e5e7eb;
        transition: 0.4s;
        border-radius: 24px;
    }
    
    .toggle-slider::before {
        content: "";
        position: absolute;
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.4s;
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0,0,0,0.15);
    }
    
    .toggle-switch input:checked + .toggle-slider {
        background: #10b981;
    }
    
    .toggle-switch input:checked + .toggle-slider::before {
        transform: translateX(20px);
    }
    
    .toggle-switch input:disabled + .toggle-slider {
        opacity: 0.6;
        cursor: not-allowed;
    }
    
    .badge {
        padding: 5px 12px;
        font-weight: 500;
        font-size: 0.75rem;
        white-space: nowrap;
    }
    
    .badge.bg-success {
        background: #10b981 !important;
    }
    
    .badge.bg-danger {
        background: #ef4444 !important;
    }
    
    /* SweetAlert2 Custom Styling */
    .swal2-popup {
        border-radius: 16px !important;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
    }
    .swal2-title {
        font-size: 1.4rem !important;
        font-weight: 700 !important;
    }
    .swal2-confirm {
        border-radius: 10px !important;
        font-weight: 600 !important;
        padding: 10px 30px !important;
    }
    .swal2-cancel {
        border-radius: 10px !important;
        font-weight: 600 !important;
        padding: 10px 30px !important;
    }
    .swal2-html-container {
        font-size: 1rem !important;
        color: #555 !important;
    }
    
    /* ===== FLOATING ALERT FOR INDEX PAGE (USING SWEETALERT TOAST) ===== */
    .swal2-toast-custom {
        border-radius: 12px !important;
    }
    
    /* ===== RESPONSIVE ===== */
    @media (max-width: 992px) {
        .container {
            margin-left: 70px !important;
            max-width: calc(100% - 70px) !important;
            width: calc(100% - 70px) !important;
            padding: 15px !important;
        }
    }
    
    @media (max-width: 768px) {
        .container {
            margin-left: 0 !important;
            max-width: 100% !important;
            width: 100% !important;
            padding: 10px !important;
        }
        .card-header {
            flex-direction: column;
            gap: 10px;
            align-items: stretch !important;
        }
        .card-header .d-flex {
            flex-wrap: wrap;
            gap: 8px;
        }
        .bulk-actions-bar {
            flex-direction: column;
            align-items: stretch !important;
        }
        .bulk-actions-bar .selected-count {
            text-align: center;
        }
        .table {
            font-size: 0.75rem;
            min-width: 600px;
        }
        .table thead th,
        .table tbody td {
            padding: 8px 10px;
        }
        .btn-sm {
            font-size: 0.65rem;
            padding: 3px 6px;
        }
        .btn-sm i {
            font-size: 0.6rem;
        }
        .action-buttons {
            gap: 4px;
        }
        .card-header h4 {
            font-size: 0.95rem;
        }
        .bulk-shipping-input {
            width: 100%;
        }
        .modal-dialog {
            margin: 10px;
        }
        .toggle-switch {
            width: 36px;
            height: 20px;
        }
        .toggle-slider::before {
            height: 14px;
            width: 14px;
            left: 3px;
            bottom: 3px;
        }
        .toggle-switch input:checked + .toggle-slider::before {
            transform: translateX(16px);
        }
    }
</style>

<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-truck"></i> Deliverable States & Shipping Charges</h4>
            <div>
                <button type="button" class="btn btn-light btn-sm me-2" data-bs-toggle="modal" data-bs-target="#bulkImportModal">
                    <i class="fas fa-upload me-1"></i> Bulk Import
                </button>
                <a href="{{ route('admin.pincodes.create') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-plus me-1"></i> Add State
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Bulk Actions Bar -->
            <div id="bulkActionsBar" class="bulk-actions-bar">
                <span class="selected-count" id="selectedCount">0 selected</span>
                <input type="number" id="bulkShippingCharge" class="bulk-shipping-input" placeholder="Shipping charge" step="0.01" min="0">
                <button class="btn-bulk-update" onclick="bulkUpdateShipping()">
                    <i class="fas fa-edit me-1"></i> Update Shipping
                </button>
                <button class="btn-bulk-active" onclick="bulkUpdateStatus(1)">
                    <i class="fas fa-check-circle me-1"></i> Set Active
                </button>
                <button class="btn-bulk-inactive" onclick="bulkUpdateStatus(0)">
                    <i class="fas fa-times-circle me-1"></i> Set Inactive
                </button>
                <button class="btn-bulk-delete" onclick="bulkDeleteStates()">
                    <i class="fas fa-trash me-1"></i> Delete
                </button>
                <button class="btn btn-secondary btn-sm" onclick="clearSelection()">
                    <i class="fas fa-times me-1"></i> Clear
                </button>
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th width="5%">
                                <input type="checkbox" id="selectAllCheckbox" class="select-all-checkbox" onclick="toggleSelectAll()">
                            </th>
                            <th width="5%">ID</th>
                            <th width="28%">State Name</th>
                            <th width="18%">Shipping Charge</th>
                            <th width="15%">Status</th>
                            <th width="29%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pincodes as $pincode)
                        <tr id="row-{{ $pincode->id }}">
                            <td class="text-center">
                                <input type="checkbox" class="state-checkbox" value="{{ $pincode->id }}" 
                                       data-state="{{ $pincode->state }}" 
                                       data-shipping="{{ $pincode->shipping_charge }}" 
                                       data-status="{{ $pincode->is_active }}" 
                                       onclick="updateSelectedCount()">
                            </td>
                            <td class="text-center">{{ $pincode->id }}</td>
                            <td><strong>{{ $pincode->state }}</strong></td>
                            <td>
                                <span class="shipping-amount" id="shipping-{{ $pincode->id }}">₹{{ number_format($pincode->shipping_charge, 2) }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <label class="toggle-switch" title="Toggle status">
                                        <input type="checkbox" class="status-toggle" data-id="{{ $pincode->id }}" 
                                               {{ $pincode->is_active ? 'checked' : '' }} 
                                               onchange="toggleStatus({{ $pincode->id }}, this.checked)">
                                        <span class="toggle-slider"></span>
                                    </label>
                                    <span class="badge {{ $pincode->is_active ? 'bg-success' : 'bg-danger' }}" id="status-badge-{{ $pincode->id }}">
                                        {{ $pincode->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.pincodes.edit', $pincode->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.pincodes.destroy', $pincode->id) }}" method="POST" style="display:inline-block; margin:0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirmDelete(event, this)" title="Delete">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="fas fa-truck fa-2x d-block mb-2" style="color: #d1d5db;"></i>
                                No states found. Click "Add State" to add one.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Import Modal -->
<div class="modal fade" id="bulkImportModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.pincodes.bulk') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-upload"></i> Bulk Import States</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Enter States (One per line)</label>
                        <textarea name="states" class="form-control" rows="10" placeholder="Format: State Name|shipping_charge
Tamil Nadu|50
Karnataka|70
Maharashtra|80
Kerala|60
Delhi|100

OR just state name (shipping charge will be 0):
Tamil Nadu
Karnataka
Maharashtra"></textarea>
                        <small class="text-muted mt-2 d-block">
                            <i class="fas fa-info-circle me-1"></i> 
                            Format: <strong>State Name|shipping_charge</strong> (separate with pipe |)<br>
                            Example: Tamil Nadu|50 , Karnataka|70
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Import States</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// ===== SHOW TOAST NOTIFICATIONS USING SWEETALERT2 =====
let toastTimeout = null;

function showToast(message, type = 'success') {
    // Clear any existing toast timeout
    if (toastTimeout) {
        clearTimeout(toastTimeout);
        toastTimeout = null;
    }
    
    // Close any existing toast
    Swal.close();
    
    const config = {
        icon: type,
        title: type === 'success' ? 'Success!' : 'Error!',
        text: message,
        timer: 4000,
        showConfirmButton: false,
        position: 'top-end',
        toast: true,
        customClass: {
            popup: 'swal2-toast-custom'
        }
    };
    
    if (type === 'success') {
        config.background = '#ecfdf5';
        config.color = '#065f46';
        config.iconColor = '#10b981';
    } else {
        config.background = '#fef2f2';
        config.color = '#991b1b';
        config.iconColor = '#ef4444';
    }
    
    Swal.fire(config);
    
    // Auto close after timer
    toastTimeout = setTimeout(() => {
        Swal.close();
    }, 4000);
}

document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
        showToast('{{ session('success') }}', 'success');
    @endif

    @if(session('error'))
        showToast('{{ session('error') }}', 'error');
    @endif

    @if($errors->any())
        showToast('{{ $errors->first() }}', 'error');
    @endif
});

// Get CSRF token
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
let selectedStates = [];
let isProcessing = false;

// ===== BEAUTIFUL CONFIRMATION FUNCTION =====
function confirmDelete(event, btn) {
    event.preventDefault();
    
    Swal.fire({
        title: 'Are you sure?',
        text: "This state will be permanently deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            btn.closest('form').submit();
        }
    });
    return false;
}

// Toggle select all checkboxes
function toggleSelectAll() {
    const selectAll = document.getElementById('selectAllCheckbox');
    const checkboxes = document.querySelectorAll('.state-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
    
    updateSelectedCount();
}

// Update selected count and show/hide bulk actions bar
function updateSelectedCount() {
    const checkboxes = document.querySelectorAll('.state-checkbox:checked');
    const count = checkboxes.length;
    const selectedCountSpan = document.getElementById('selectedCount');
    const bulkBar = document.getElementById('bulkActionsBar');
    
    selectedStates = [];
    checkboxes.forEach(checkbox => {
        selectedStates.push({
            id: checkbox.value,
            state: checkbox.getAttribute('data-state'),
            shipping: checkbox.getAttribute('data-shipping'),
            status: checkbox.getAttribute('data-status')
        });
    });
    
    if (count > 0) {
        selectedCountSpan.innerHTML = count + ' selected';
        bulkBar.classList.add('show');
    } else {
        bulkBar.classList.remove('show');
    }
}

// Clear all selections
function clearSelection() {
    const checkboxes = document.querySelectorAll('.state-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });
    document.getElementById('selectAllCheckbox').checked = false;
    updateSelectedCount();
    
    showToast('Selection cleared', 'success');
}

// Toggle individual status with SweetAlert
async function toggleStatus(id, isActive) {
    if (isProcessing) {
        showToast('Please wait for current operation to complete.', 'error');
        return;
    }
    
    const status = isActive ? 1 : 0;
    const badge = document.getElementById('status-badge-' + id);
    const toggle = document.querySelector(`.status-toggle[data-id="${id}"]`);
    const currentState = isActive;
    
    if (badge) {
        badge.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    }
    
    isProcessing = true;
    
    try {
        const response = await fetch('/admin/pincodes/toggle-status/' + id, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ is_active: status })
        });
        
        const data = await response.json();
        
        if (data.success) {
            if (badge) {
                if (isActive) {
                    badge.className = 'badge bg-success';
                    badge.textContent = 'Active';
                } else {
                    badge.className = 'badge bg-danger';
                    badge.textContent = 'Inactive';
                }
            }
            const checkbox = document.querySelector(`.state-checkbox[value="${id}"]`);
            if (checkbox) {
                checkbox.setAttribute('data-status', status);
            }
            
            showToast(isActive ? 'State activated successfully!' : 'State deactivated successfully!', 'success');
        } else {
            if (toggle) {
                toggle.checked = !isActive;
            }
            if (badge) {
                badge.className = 'badge ' + (currentState ? 'bg-success' : 'bg-danger');
                badge.textContent = currentState ? 'Active' : 'Inactive';
            }
            showToast(data.message || 'Failed to update status', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        if (toggle) {
            toggle.checked = !isActive;
        }
        if (badge) {
            badge.className = 'badge ' + (currentState ? 'bg-success' : 'bg-danger');
            badge.textContent = currentState ? 'Active' : 'Inactive';
        }
        showToast('Network error. Please try again.', 'error');
    } finally {
        isProcessing = false;
    }
}

// Bulk update status with SweetAlert
async function bulkUpdateStatus(status) {
    if (isProcessing) {
        showToast('Please wait for current operation to complete.', 'error');
        return;
    }
    
    if (selectedStates.length === 0) {
        showToast('Please select at least one state.', 'error');
        return;
    }
    
    const statusText = status === 1 ? 'Active' : 'Inactive';
    const icon = status === 1 ? 'success' : 'warning';
    const confirmColor = status === 1 ? '#10b981' : '#f59e0b';
    
    const result = await Swal.fire({
        title: `Set to ${statusText}?`,
        html: `You are about to set <strong>${selectedStates.length}</strong> state(s) to <strong style="color:${confirmColor};">${statusText}</strong>.`,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: confirmColor,
        cancelButtonColor: '#6b7280',
        confirmButtonText: `Yes, Set ${statusText}`,
        cancelButtonText: 'Cancel',
        reverseButtons: true
    });
    
    if (!result.isConfirmed) return;
    
    const btn = document.querySelector(status === 1 ? '.btn-bulk-active' : '.btn-bulk-inactive');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
    btn.disabled = true;
    isProcessing = true;
    
    try {
        const response = await fetch('/admin/pincodes/bulk-update-status', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                state_ids: selectedStates.map(s => s.id),
                is_active: status
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            selectedStates.forEach(state => {
                const badge = document.getElementById('status-badge-' + state.id);
                const toggle = document.querySelector(`.status-toggle[data-id="${state.id}"]`);
                const checkbox = document.querySelector(`.state-checkbox[value="${state.id}"]`);
                
                if (badge) {
                    if (status === 1) {
                        badge.className = 'badge bg-success';
                        badge.textContent = 'Active';
                    } else {
                        badge.className = 'badge bg-danger';
                        badge.textContent = 'Inactive';
                    }
                }
                if (toggle) {
                    toggle.checked = status === 1;
                }
                if (checkbox) {
                    checkbox.setAttribute('data-status', status);
                }
            });
            
            showToast(`Successfully updated ${selectedStates.length} state(s) to ${statusText}!`, 'success');
            clearSelection();
        } else {
            showToast(data.message || 'Error updating status', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Network error. Please try again.', 'error');
    } finally {
        btn.innerHTML = originalText;
        btn.disabled = false;
        isProcessing = false;
    }
}

// Bulk update shipping charges with SweetAlert
async function bulkUpdateShipping() {
    if (isProcessing) {
        showToast('Please wait for current operation to complete.', 'error');
        return;
    }
    
    const shippingCharge = document.getElementById('bulkShippingCharge').value;
    
    if (!shippingCharge) {
        showToast('Please enter a shipping charge amount.', 'error');
        return;
    }
    
    if (selectedStates.length === 0) {
        showToast('Please select at least one state.', 'error');
        return;
    }
    
    const result = await Swal.fire({
        title: 'Update Shipping Charge?',
        html: `You are about to update shipping charge to <strong style="color:#3b82f6;">₹${shippingCharge}</strong> for <strong>${selectedStates.length}</strong> state(s).`,
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3b82f6',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, Update',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    });
    
    if (!result.isConfirmed) return;
    
    const updateBtn = document.querySelector('.btn-bulk-update');
    const originalText = updateBtn.innerHTML;
    updateBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
    updateBtn.disabled = true;
    isProcessing = true;
    
    try {
        const response = await fetch('{{ route("admin.pincodes.bulk-update-shipping") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                state_ids: selectedStates.map(s => s.id),
                shipping_charge: shippingCharge
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            selectedStates.forEach(state => {
                const shippingSpan = document.getElementById(`shipping-${state.id}`);
                if (shippingSpan) {
                    shippingSpan.innerHTML = '₹' + parseFloat(shippingCharge).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                }
            });
            
            showToast(`Successfully updated shipping for ${selectedStates.length} state(s)!`, 'success');
            clearSelection();
            document.getElementById('bulkShippingCharge').value = '';
        } else {
            showToast(data.message || 'Error updating shipping charges', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Network error. Please try again.', 'error');
    } finally {
        updateBtn.innerHTML = originalText;
        updateBtn.disabled = false;
        isProcessing = false;
    }
}

// Bulk delete states with SweetAlert
async function bulkDeleteStates() {
    if (isProcessing) {
        showToast('Please wait for current operation to complete.', 'error');
        return;
    }
    
    if (selectedStates.length === 0) {
        showToast('Please select at least one state.', 'error');
        return;
    }
    
    const result = await Swal.fire({
        title: 'Delete These States?',
        html: `You are about to delete <strong style="color:#ef4444;">${selectedStates.length}</strong> state(s).<br><span style="color:#ef4444; font-weight:600;">⚠️ This action cannot be undone!</span>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, Delete All',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    });
    
    if (!result.isConfirmed) return;
    
    const deleteBtn = document.querySelector('.btn-bulk-delete');
    const originalText = deleteBtn.innerHTML;
    deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Deleting...';
    deleteBtn.disabled = true;
    isProcessing = true;
    
    try {
        const response = await fetch('{{ route("admin.pincodes.bulk-delete") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                state_ids: selectedStates.map(s => s.id)
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            selectedStates.forEach(state => {
                const row = document.getElementById(`row-${state.id}`);
                if (row) {
                    row.remove();
                }
            });
            
            showToast(`Successfully deleted ${selectedStates.length} state(s)!`, 'success');
            clearSelection();
            
            const remainingRows = document.querySelectorAll('.state-checkbox').length;
            if (remainingRows === 0) {
                setTimeout(() => location.reload(), 1500);
            }
        } else {
            showToast(data.message || 'Error deleting states', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Network error. Please try again.', 'error');
    } finally {
        deleteBtn.innerHTML = originalText;
        deleteBtn.disabled = false;
        isProcessing = false;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('%c🟢 Deliverable States Page Loaded with Sweet Alerts!', 'color: #10b981; font-weight: bold; font-size: 14px;');
});
</script>
@endsection