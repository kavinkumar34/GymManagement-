@extends('layouts.app')

@section('content')
<style>
    /* Hide navbar, footer, and WhatsApp icon */
    nav.navbar, .navbar, footer, .footer, .whatsapp-float, .whatsapp-tooltip {
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
        border-color: #4a9eff;
        box-shadow: 0 0 0 4px rgba(74, 158, 255, 0.1);
        outline: none;
        background: #ffffff;
    }
    
    .form-check-input:checked {
        background-color: #4a9eff;
        border-color: #4a9eff;
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
        background: linear-gradient(135deg, #0d1b2a 0%, #1b3a5c 100%);
        color: white;
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #1b3a5c 0%, #0d1b2a 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(13, 27, 42, 0.3);
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
    
    .text-muted {
        font-size: 0.8rem;
        color: #6b7280 !important;
        margin-top: 4px;
        display: block;
    }
    
    .alert {
        border-radius: 10px;
        border: none;
        padding: 14px 18px;
        margin-bottom: 20px;
    }
    
    .alert-danger {
        background: #fef2f2;
        color: #991b1b;
        border-left: 4px solid #ef4444;
    }
    
    .alert-danger p {
        margin-bottom: 0;
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
        .form-control {
            font-size: 0.9rem;
            padding: 8px 12px;
        }
    }
</style>

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h4><i class="fas fa-plus-circle"></i> Add Deliverable State</h4>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <p><i class="fas fa-exclamation-circle me-2"></i> {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('admin.pincodes.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label">State Name <span class="text-danger">*</span></label>
                    <input type="text" name="state" class="form-control" 
                           value="{{ old('state') }}" placeholder="e.g., Tamil Nadu, Karnataka" required>
                    <small class="text-muted">Enter the full state name</small>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Shipping Charge (₹) <span class="text-danger">*</span></label>
                    <input type="number" name="shipping_charge" class="form-control" 
                           value="{{ old('shipping_charge', 0) }}" step="0.01" min="0" max="1000" required>
                    <small class="text-muted">Shipping charge for this state (in INR)</small>
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_active" class="form-check-input" id="isActive" value="1" 
                           {{ old('is_active', 1) ? 'checked' : '' }}>
                    <label class="form-check-label" for="isActive">
                        <i class="fas fa-check-circle text-success me-1"></i> Active (Delivery available)
                    </label>
                </div>
                
                <div class="btn-group-custom">
                    <button type="submit" class="btn btn-primary">
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