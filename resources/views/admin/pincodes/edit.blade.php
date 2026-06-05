@extends('layouts.app')

@section('content')
<div class="container" style="margin-left:200px;">
    <div class="card">
        <div class="card-header">
            <h4>Edit Deliverable Pincode</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.pincodes.update', $pincode->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label>Pincode *</label>
                    <input type="text" name="pincode" class="form-control @error('pincode') is-invalid @enderror" value="{{ old('pincode', $pincode->pincode) }}" maxlength="6" required>
                    @error('pincode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="mb-3">
                    <label>City</label>
                    <input type="text" name="city" class="form-control" value="{{ old('city', $pincode->city) }}">
                </div>
                
                <div class="mb-3">
                    <label>State</label>
                    <input type="text" name="state" class="form-control" value="{{ old('state', $pincode->state) }}">
                </div>
                
                <div class="mb-3">
                    <label>Delivery Days *</label>
                    <input type="number" name="delivery_days" class="form-control @error('delivery_days') is-invalid @enderror" value="{{ old('delivery_days', $pincode->delivery_days) }}" min="1" max="15" required>
                    @error('delivery_days') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_active" class="form-check-input" value="1" {{ old('is_active', $pincode->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label">Active</label>
                </div>
                
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.pincodes.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection