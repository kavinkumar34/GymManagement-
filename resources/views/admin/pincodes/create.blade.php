@extends('layouts.app')

@section('content')
<style>
    /* Remove footer from this page */
    footer {
        display: none !important;
    }
    body {
        margin-bottom: 0 !important;
        padding-bottom: 0 !important;
    }
    .container {
        margin-left: 200px;
        min-height: 100vh;
        padding-bottom: 2rem;
    }
</style>

<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fas fa-plus-circle"></i> Add Deliverable State</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.pincodes.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label>State Name <span class="text-danger">*</span></label>
                    <input type="text" name="state" class="form-control @error('state') is-invalid @enderror" 
                           value="{{ old('state') }}" placeholder="e.g., Tamil Nadu, Karnataka, Maharashtra" required>
                    @error('state') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <small class="text-muted">Enter the full state name</small>
                </div>
                
                <div class="mb-3">
                    <label>Shipping Charge (₹) <span class="text-danger">*</span></label>
                    <input type="number" name="shipping_charge" class="form-control @error('shipping_charge') is-invalid @enderror" 
                           value="{{ old('shipping_charge', 0) }}" step="0.01" min="0" max="1000" required>
                    @error('shipping_charge') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <small class="text-muted">Shipping charge for this state (in INR)</small>
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_active" class="form-check-input" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                    <label class="form-check-label">Active (Delivery available to this state)</label>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save State
                </button>
                <a href="{{ route('admin.pincodes.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </form>
        </div>
    </div>
</div>
@endsection