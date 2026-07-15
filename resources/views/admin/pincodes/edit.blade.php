@extends('layouts.app')

@section('content')
<!-- SweetAlert2 CSS & JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* Hide navbar, footer, and WhatsApp icon */
    nav.navbar, .navbar, footer, .footer, .whatsapp-float, .whatsapp-tooltip {
        display: none !important;
    }
      .navbar-spacer {
        display: none !important;
    }
    
    /* Keep admin sidebar - adjust container */
    body {
        margin: 0 !important;
        padding: 0 !important;
        background: #f0f4f8 !important;
    }
    
    main.py-4 {
        padding: 0 !important;
        margin: 0 !important;
    }
    
    .container {
        margin-left: 270px !important;
        max-width: calc(100% - 270px) !important;
        width: calc(100% - 270px) !important;
        min-height: 100vh;
        padding: 30px !important;
        background: #f0f4f8;
    }
    
    .card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        overflow: hidden;
        max-width: 700px;
        margin: 0 auto;
    }
    
    .card-header {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
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
        margin-right: 8px;
    }
    
    .card-body {
        padding: 30px;
        background: #ffffff;
    }
    
    .form-label {
        font-weight: 600;
        color: #1a1a2e;
        margin-bottom: 6px;
        font-size: 0.9rem;
    }
    
    .form-control {
        border-radius: 10px;
        border: 2px solid #e5e7eb;
        padding: 10px 14px;
        font-size: 0.95rem;
        background: #fafafa;
    }
    
    .form-control:focus {
        border-color: #f59e0b;
        box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.1);
        outline: none;
        background: #ffffff;
    }
    
    .form-check-input:checked {
        background-color: #f59e0b;
        border-color: #f59e0b;
    }
    
    .btn {
        padding: 10px 24px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
        color: white;
    }
    
    .btn-secondary {
        background: #f1f3f5;
        color: #374151;
    }
    
    .btn-secondary:hover {
        background: #e5e7eb;
    }
    
    .btn-group-custom {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 10px;
    }
    
    /* ===== FLOATING ALERT - TOP FIXED POSITION ===== */
    .floating-alert {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 99999;
        min-width: 350px;
        max-width: 600px;
        padding: 16px 24px;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        display: none;
        animation: slideDownAlert 0.5s ease;
        text-align: center;
        font-weight: 500;
    }
    
    .floating-alert.success {
        background: #10b981;
        color: white;
        border-left: 6px solid #047857;
    }
    
    .floating-alert.error {
        background: #ef4444;
        color: white;
        border-left: 6px solid #b91c1c;
    }
    
    .floating-alert.show {
        display: block;
    }
    
    @keyframes slideDownAlert {
        from {
            opacity: 0;
            transform: translateX(-50%) translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
    }
    
    @keyframes slideUpAlert {
        from {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
        to {
            opacity: 0;
            transform: translateX(-50%) translateY(-30px);
        }
    }
    
    .floating-alert.hide {
        animation: slideUpAlert 0.5s ease forwards;
    }
    
    .floating-alert .close-btn {
        position: absolute;
        top: 8px;
        right: 14px;
        background: none;
        border: none;
        color: rgba(255,255,255,0.7);
        font-size: 20px;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .floating-alert .close-btn:hover {
        color: white;
        transform: rotate(90deg);
    }
    
    .floating-alert i {
        margin-right: 10px;
        font-size: 1.2rem;
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
    
    @media (max-width: 992px) {
        .container {
            margin-left: 70px !important;
            max-width: calc(100% - 70px) !important;
            width: calc(100% - 70px) !important;
            padding: 20px !important;
        }
    }
    
    @media (max-width: 768px) {
        .container {
            margin-left: 0 !important;
            max-width: 100% !important;
            width: 100% !important;
            padding: 15px !important;
        }
        .card-body {
            padding: 20px;
        }
        .btn {
            width: 100%;
            justify-content: center;
        }
        .btn-group-custom {
            flex-direction: column;
            gap: 8px;
        }
        .floating-alert {
            min-width: auto;
            max-width: 95%;
            width: 95%;
            top: 15px;
            padding: 14px 18px;
            font-size: 0.9rem;
        }
    }
</style>

<!-- ===== FLOATING ALERT - TOP OF PAGE ===== -->
<div class="floating-alert success" id="floatingAlert">
    <button class="close-btn" onclick="closeFloatingAlert()">✕</button>
    <i class="fas fa-check-circle" id="alertIcon"></i>
    <span id="alertMessage">Alert Message</span>
</div>

<div class="container-fluid" style="margin-top:30px;">
    <div class="card">
        <div class="card-header">
            <h4><i class="fas fa-edit"></i> Edit Deliverable State</h4>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <p class="mb-0"><i class="fas fa-exclamation-circle me-2"></i> {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('admin.pincodes.update', $pincode->id) }}" method="POST" id="editForm">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label class="form-label">State Name <span class="text-danger">*</span></label>
                    <input type="text" name="state" class="form-control @error('state') is-invalid @enderror" 
                           value="{{ old('state', $pincode->state) }}" placeholder="e.g., Tamil Nadu" required>
                    @error('state')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Shipping Charge (₹) <span class="text-danger">*</span></label>
                    <input type="number" name="shipping_charge" class="form-control @error('shipping_charge') is-invalid @enderror" 
                           value="{{ old('shipping_charge', $pincode->shipping_charge) }}" step="0.01" min="0" max="1000" required>
                    @error('shipping_charge')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_active" class="form-check-input" id="isActive" value="1" 
                           {{ old('is_active', $pincode->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="isActive">
                        <i class="fas fa-check-circle text-success me-1"></i> Active (Delivery available)
                    </label>
                </div>
                
                <div class="btn-group-custom">
                    <button type="submit" class="btn btn-success" id="updateBtn">
                        <i class="fas fa-save"></i> Update State
                    </button>
                    <a href="{{ route('admin.pincodes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// ===== FLOATING ALERT FUNCTIONS =====
let alertTimeout = null;

function showFloatingAlert(message, type = 'success') {
    const alertDiv = document.getElementById('floatingAlert');
    const alertIcon = document.getElementById('alertIcon');
    const alertMessage = document.getElementById('alertMessage');
    
    // Clear any existing timeout
    if (alertTimeout) {
        clearTimeout(alertTimeout);
        alertTimeout = null;
    }
    
    // Reset animations
    alertDiv.classList.remove('show', 'hide', 'success', 'error');
    
    // Set type
    if (type === 'success') {
        alertDiv.className = 'floating-alert success';
        alertIcon.className = 'fas fa-check-circle';
    } else {
        alertDiv.className = 'floating-alert error';
        alertIcon.className = 'fas fa-exclamation-circle';
    }
    
    // Set message
    alertMessage.textContent = message;
    
    // Show alert
    alertDiv.classList.add('show');
    
    // Auto hide after 5 seconds
    alertTimeout = setTimeout(function() {
        closeFloatingAlert();
    }, 5000);
}

function closeFloatingAlert() {
    const alertDiv = document.getElementById('floatingAlert');
    alertDiv.classList.remove('show');
    alertDiv.classList.add('hide');
    
    if (alertTimeout) {
        clearTimeout(alertTimeout);
        alertTimeout = null;
    }
    
    setTimeout(function() {
        alertDiv.classList.remove('hide');
    }, 500);
}

// ===== CHECK FOR SESSION MESSAGES ON PAGE LOAD =====
document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
        showFloatingAlert('{{ session('success') }}', 'success');
    @endif

    @if(session('error'))
        showFloatingAlert('{{ session('error') }}', 'error');
    @endif

    @if($errors->any())
        showFloatingAlert('{{ $errors->first() }}', 'error');
    @endif
});

// Show loading state on form submit
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('editForm');
    const updateBtn = document.getElementById('updateBtn');
    
    if (form) {
        form.addEventListener('submit', function() {
            updateBtn.disabled = true;
            updateBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
        });
    }
});
</script>
@endsection