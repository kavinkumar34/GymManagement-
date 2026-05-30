@extends('layouts.admin-layout')

@section('content')
<div class="admin-main-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h4><i class="fas fa-edit"></i> Edit Trainer</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.trainer.update', $trainer->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ $trainer->name }}" required>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-control">
                                <option value="Male" {{ $trainer->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ $trainer->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ $trainer->gender == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="tel" name="phone" class="form-control" value="{{ $trainer->phone }}" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ $trainer->email }}" required>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control" rows="2">{{ $trainer->address }}</textarea>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Experience (years)</label>
                            <input type="number" name="experience" class="form-control" value="{{ $trainer->experience }}">
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Specialization</label>
                            <select name="specialization" class="form-control">
                                <option value="Cardio" {{ $trainer->specialization == 'Cardio' ? 'selected' : '' }}>Cardio</option>
                                <option value="Yoga" {{ $trainer->specialization == 'Yoga' ? 'selected' : '' }}>Yoga</option>
                                <option value="Weight Training" {{ $trainer->specialization == 'Weight Training' ? 'selected' : '' }}>Weight Training</option>
                                <option value="CrossFit" {{ $trainer->specialization == 'CrossFit' ? 'selected' : '' }}>CrossFit</option>
                                <option value="Zumba" {{ $trainer->specialization == 'Zumba' ? 'selected' : '' }}>Zumba</option>
                                <option value="Body Building" {{ $trainer->specialization == 'Body Building' ? 'selected' : '' }}>Body Building</option>
                                <option value="Personal Training" {{ $trainer->specialization == 'Personal Training' ? 'selected' : '' }}>Personal Training</option>
                            </select>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Salary (₹ per month)</label>
                            <input type="number" step="0.01" name="salary" class="form-control" value="{{ $trainer->salary }}">
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Shift Timing</label>
                            <select name="shift_timing" class="form-control">
                                <option value="Morning (6AM-12PM)" {{ $trainer->shift_timing == 'Morning (6AM-12PM)' ? 'selected' : '' }}>Morning (6AM-12PM)</option>
                                <option value="Evening (12PM-6PM)" {{ $trainer->shift_timing == 'Evening (12PM-6PM)' ? 'selected' : '' }}>Evening (12PM-6PM)</option>
                                <option value="Night (6PM-10PM)" {{ $trainer->shift_timing == 'Night (6PM-10PM)' ? 'selected' : '' }}>Night (6PM-10PM)</option>
                                <option value="Full Day" {{ $trainer->shift_timing == 'Full Day' ? 'selected' : '' }}>Full Day</option>
                            </select>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Certifications</label>
                            <textarea name="certification" class="form-control" rows="2">{{ $trainer->certification }}</textarea>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="Active" {{ $trainer->status == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ $trainer->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Trainer
                        </button>
                        <a href="{{ route('admin.trainers') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection